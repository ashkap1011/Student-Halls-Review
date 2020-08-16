<?php

namespace App\Http\Controllers;

use App\TempReview;
use App\University;
use App\Dorm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\IntercollegiateDorm;

/**This Controller is in charge of handling the reviews that the user writes,
 *  these are then saved temp_reviews table */
class ReviewsController extends Controller
{   
    
    private $starRatingCaptionsArr= array('Consider the comfort, furniture and lighting','Consider the age, aesthetics, and cleaniness'
    ,'Consider the safety of the area, the nearby shops, distance to uni','Consider the appliances, cleaniness and size'
    ,'Consider their friendliness, helpfulness and responsiveness','Consider the quality/variety of the food/kitchen appliances');

    /**Create initial form page for writing reviews */
    public function writeReview(){
        $universities = University::all();
        $starRatings = config('constants.options.starRatings');
        $amenities = config('constants.options.amenities');
        $ratingCaptions = $this->starRatingCaptionsArr;
        return view('review', compact('universities','amenities','starRatings','ratingCaptions'));
    }

    /**alternate form page for writing reviews where it is for a new uni and dorm, or just dorm*/
    public function newUniOrDormReviewPage($uni_name){
        $amenities = config('constants.options.amenities');
        $starRatings = config('constants.options.starRatings');
        $ratingCaptions = $this->starRatingCaptionsArr;
        $isNewUni =false;
        if ($uni_name == '-'){
            $isNewUni = true;
        }
        return view('review_for_new_uni_and_or_dorm', compact('uni_name', 'amenities','isNewUni','starRatings','ratingCaptions'));
    }

    /**review is for an exisitng dorm */
    public function createNewReview(Request $request){
        $tempReview = $this->appendReview($request);
        $tempReview->dorm_id = $request->input('dorm_id'); 
        $tempReview->save();
    }

    public function createReviewForNewUniOrDorm(Request $request){
        $request->validate([
            'uni_name' => 'required|string',
            'dorm_name' => 'required|string',
        ]);

        $tempReview = $this->appendReview($request);
        $tempReview->uni_name = $request->input('uni_name');
        $tempReview->dorm_name = $request->input('dorm_name');
        $tempReview->save();
    }

    /**The following method returns the Temp Review view model appended with the common 
     *  review aspects, e.g. star ratings.
     */
    public function appendReview($request){
        $request =$this->validateAppendReviewRequest($request);
               
       
        $tempReview = new TempReview();
        
        foreach(config('constants.options.generalColumnsOfTempReivew') as $columnName){
            
            if($columnName == 'amenities'){
                $hasAmenities = $request->input($columnName);
                if($hasAmenities  !== null){
                    $tempReview->$columnName = implode(',',$hasAmenities);
                }
                continue;
            }
            $tempReview->$columnName = $request->$columnName;
        }
        return $tempReview;

         /*
        $tempReview->is_new_uni = $request->input('is_new_uni');
        $tempReview->room_rating = $request->input('room_rating');
        $tempReview->building_rating = $request->input('building_rating');
        $tempReview->location_rating = $request->input('location_rating');
        $tempReview->bathroom_rating = $request->input('bathroom_rating');
        $tempReview->staff_rating = $request->input('staff_rating');
        $tempReview->is_recommended = $request->input('is_recommended');
        $tempReview->year_of_study = $request->input('year_of_study');
        $tempReview->year_of_residence = $request->input('year_of_residence');
        $tempReview->room_type = $request->input('room_type');
                
        $tempReview->is_catered = $request->input('is_catered');
        $tempReview->catered_or_selfcatered_rating = $request->input('catered_or_selfcatered_rating');

        $hasAmenities = $request->input('amenities');

        if($hasAmenities  !== null){
            $tempReview->amenities = implode(',',$hasAmenities);
        }
        $tempReview->quirk = $request->input('quirk');
        $tempReview->review_text = $request->input('review_text');

        */

    }

    private function validateAppendReviewRequest($request){
        $request->validate([ //addminmaxvalues
            'is_new_uni' => 'required|boolean',
            'room_rating' => 'required|integer|between:1,5',
            'building_rating' => 'required|integer|between:1,5',
            'location_rating' => 'required|integer|between:1,5',
            'bathroom_rating' => 'required|integer|between:1,5',
            'staff_rating' => 'required|integer|between:1,5',
            'is_recommended' => 'required|boolean',
            'year_of_study' => 'required|string',
            'year_of_residence' => 'required|integer',
            'year_of_study' => 'required|string',
            'is_catered' => 'required|boolean',
            'catered_or_selfcatered_rating' => 'required|integer|between:1,5',
            'amenities' => 'array',
            'review_text' => 'nullable'
        ]);
        return $request;
    }



    /**returns all dorm names of a uni, including intercollegiate dorm */
    public function dormsOnUniSelection($uni_name){
        $uni = University::where('uni_name', $uni_name)->first();
        $dormsOfUni = Dorm::where('uni_id', $uni->uni_id)->get();   
        $dormNames= array();

        foreach($dormsOfUni as $dorm){
            array_push($dormNames, strval($dorm->dorm_name));
        }
        if($uni->has_intercollegiate_dorms == '1'){
            $dormNames = $this->appendIntercollegiateDormNames($dormNames,$uni->uni_id);
        } 
        return $dormNames;
    }

    public function dormNameToId($dorm_name){
        $dormId = Dorm::where('dorm_name', strval($dorm_name))->value('dorm_id');
        return $dormId;
    }

    /**Adds all the intercollegiate dorms of a given uni */
    private function appendIntercollegiateDormNames($dormNames,$uniId){
        $allIntercollegiateDorms = IntercollegiateDorm::all();
        foreach($allIntercollegiateDorms as $interclgtDorm){
            if(in_array($uniId,$interclgtDorm->uni_id_set)){
                $dorm = Dorm::where('dorm_id', $interclgtDorm->dorm_id)->first();
                if($dorm->uni_id != $uniId){        //avoids adding interCltdorms whose uni_id is same as the requested uni, i.e. already in $dorms of method caller
                    array_push($dormNames, $dorm->dorm_name);
                }
            }
        } 
        return $dormNames;
    }

    


    


    /*
    Use for other review pages 

https://laravel.com/docs/7.x/eloquent#eloquent-model-conventions
https://laravel.com/docs/7.x/eloquent-collections#available-methods
https://laravel.com/docs/7.x/queries#retrieving-results


    */


}
