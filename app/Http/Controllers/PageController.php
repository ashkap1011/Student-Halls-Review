<?php

namespace App\Http\Controllers;
use Config;
use App\Dorm;
use App\IntercollegiateDorm;
use App\Review;
use App\University;
use Illuminate\Http\Request;


/**Thing contorller handles all pages that are to do with viewing universities/dorms/or their reviews
 *  i.e. not to do with writing a review */
class PageController extends Controller
{   
    public function index(){
        $reviewCount = count(Review::all());
        $universityCount = count(University::all());
        return view('homepage', compact('reviewCount','universityCount'));
    }
    /**Used by the search function of the homepage */
    public function search(Request $request){
        if($request->ajax()) {
            $output="";
            $universities=University::where('uni_name','LIKE','%'.$request->search."%")->get();
            if($universities) {
                foreach ($universities as $uni) {
                $uniName = $uni->uni_name;
                $output.='<div class="search_result"> <a href="/'.$uniName.'/dorms">'.$uniName.'</a></div>';
                }
                return Response($output);
                //add pagentate probably
            }
        }
    }

    public function getSearchMatchingUnis($searchString){
        $universities=University::where('uni_name','LIKE','%'.$searchString."%")->get();
        return view('search_results', compact('universities','searchString'));      
    }


    public function createDormsForUni($uniName){
        $uni = University::where('uni_name',strval($uniName))->first();
        $amenities = config('constants.options.amenities');
        $dorms = $this->getDormsForUni($uni);
        return view('/dorms_for_uni', compact('dorms','uni','amenities'));
        
    }   
    //not sure if we use the next method at all, blocked it from web.php
    public function getFilteredDorms(Request $request,$uniName){
        $uni = University::where('uni_name',strval($uniName))->first();
        $dorms = $this->getDormsForUni($uni);
    }
    
    /**Gets all the dorms for the uni, including intercollegiate dorms */
    public function getDormsForUni($uni){
        $uniId = $uni->uni_id;
        $dorms = Dorm::where('uni_id',$uniId)->get()->toArray();
        if($uni->has_intercollegiate_dorms =='1'){
            $dorms= $this->seekIntercollegiateDorms($dorms,$uniId);
        }
        return $dorms;
    }

    /**Finds all intercollegiate dorms and alters their name and distance to uni field,
     *  then append this to the $dorm array variable */
    public function seekIntercollegiateDorms($dorms,$uniId){
        $allIntercollegiateDorms = IntercollegiateDorm::all();
        foreach($allIntercollegiateDorms as $interclgtDorm){
            if(in_array($uniId,$interclgtDorm->uni_id_set)){
                $dorm = Dorm::where('dorm_id', $interclgtDorm->dorm_id)->first();
                if($dorm->uni_id != $uniId){        //avoids adding interCltdorms whose uni_id is same as the requested uni, i.e. already in $dorms of method caller
                    $dormName = $dorm->dorm_name;
                    $dorm->dorm_name = $dormName . ' (I)'; //make it so that it removes distance for the thing
                    $dorms[] = $dorm;
                }
            }
        }
        return $dorms;
    }

    /***
     * Returns the reviews of a given dorm
     */
    public function createReviewsForDorm($uniName, $dormName){
        $uni = University::where('uni_name',$uniName)->first();
        $dorm = Dorm::where('dorm_name', $dormName)->first();
        $reviews = Review::where('dorm_id', $dorm->dorm_id)->get();
        $dormAmenities = $dorm->has_amenities;
        $dormHasAmenities=[];
        $AMENITIES = config('constants.options.amenities');
        for($i = 0; $i< sizeof($AMENITIES);$i++){
            if($dormAmenities[$i]== 1){
                $dormHasAmenities[] = $AMENITIES[$i];
            }
        }
        $STARRATINGS = $this->starRatingNames();
        
        return view('reviews_for_dorm', compact('dorm', 'uni', 'reviews','dormHasAmenities','STARRATINGS'));
    }

    private function starRatingNames(){
        $starRatingNamesUnedited = config('constants.options.starRatings');
        $starRatingNames = [];

        foreach($starRatingNamesUnedited as $ratingName){
            if($ratingName == 'catered_or_selfcatered_rating'){
                continue;
            }
            $starRatingNames[] = ucfirst(explode('_',$ratingName)[0]);
        }
        return $starRatingNames;

    }

    public function incrementReviewClaps(Request $request){
        $request->validate([
            'reviewId' => 'required|integer',
        ]);
        $review = Review::where('id',$request->reviewId)->first();
        $review->increment('review_claps');
        $review->save();
    }
    public function decrementReviewClaps(Request $request){
        $request->validate([
            'reviewId' => 'required|integer',
        ]);
        $review = Review::where('id',$request->reviewId)->first();
        $review->decrement('review_claps');
        $review->save();
    }


    
    ///!!!!!!!!!!!!!!!!!1 for distances remove mins to university, maybe do it client side for dorms that are intercollegiate that way they are good for the uni they originally were.
}
