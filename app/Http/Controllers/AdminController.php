<?php

namespace App\Http\Controllers;

use App\Dorm;
use App\IntercollegiateDorm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\TempReview;
use App\Review;
use App\University;
use Illuminate\Support\Facades\Validator;


/***
 * This meaty controller handles viewing all new reviews sent by a client and 
 * then can carry out CRUD operations on them.The reviews, if reasonable/appropriate,
 * are then migrated to Review Table allowing the general public to see them.
 *  Where appropriate it will add add new Uni and dorms to their respective tables
 *  allowing new users to view them for writing reviews 
 */

class AdminController extends Controller
{   
    private $temp_review_columns_names;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->tempReviewColumnsNames = Schema::getColumnListing('temp_reviews');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/admin_panel');
    }
    
    
    //reviews for pre-existing dorms
    public function reviews(){
        //reviews for pre-existing dorms will not have a dorm name but instead a dorm_id
        $reviews = TempReview::whereNull('dorm_name')->get();
        $typeOfReviews = 'normal_reviews';

        $tempReviewColumns = $this->tempReviewColumnsNames;
        return view('/admin_reviews', compact('reviews','tempReviewColumns','typeOfReviews'));
    }

    //New dorm will have is_new_uni as false and will have a dorm name
    public function reviewsWithNewDorm(){
        $reviews = TempReview::where('is_new_uni','=','0')
                    ->whereNotNull('dorm_name')->get();
        $typeOfReviews = 'new_dorm_reviews';
        $tempReviewColumns = $this->tempReviewColumnsNames;
        $dorms = Dorm::all();

        return view('/admin_reviews', compact('reviews','tempReviewColumns','typeOfReviews','dorms'));
    }

    public function reviewsWithNewUni(){
        $reviews = TempReview::where('is_new_uni','=','1')->get();
        $typeOfReviews = 'new_uni_reviews';

        $tempReviewColumns = $this->tempReviewColumnsNames;
        $universities = University::all();
        $dorms = Dorm::all();
        return view('/admin_reviews', compact('reviews','tempReviewColumns','typeOfReviews','universities','dorms'));
    }
    
    public function updateTempReview(Request $request){
        $id = strval($request->reviewId);
        $column = strval($request->column);
        $value = strval($request->value);              
                        
        $review = TempReview::find($id);
        $review->$column = $value;
        $review->save();
    }

    public function deleteTempReview(Request $request){
        $request->all();
        $id = strval($request->reviewId);
        $review = TempReview::find($id);
        $review->delete();
    }

        /**
         * Migrates temp reviews to public review
         */
    public function migrateTempReviews(Request $request){
        $request->all();
        $reviews_arr = $request->reviewsToMigrate;  //all reviews pushed in one go
        $reviewType =  $request->typeOfReviews;         
        
        foreach ($reviews_arr as $reviewId) {
            $tempReview = TempReview::find($reviewId);
            /*if review contains a new dorm or uni then it will first 
            add the new dorm/uni to DB before saving the review
            */
            if($reviewType == 'new_uni_reviews'){
                $this->createNewUni($tempReview);
            }
            if($reviewType =='new_dorm_reviews'){
                $this->createDorm($tempReview);
            } 
            $publicReview = $this->mapTempReviewToPublicReview($tempReview);
            $publicReview->save();
            $this->updateDormStatistics($publicReview,$tempReview);
        }
    }

    public function mapTempReviewToPublicReview($tempReview){
        $publicReviewColumnNames = Schema::getColumnListing('reviews');
        $publicReview = new Review();
        foreach($publicReviewColumnNames as $columName){
            if($columName =='id'){
                continue;
            } if($columName == 'overall_rating'){   
                $publicReview->overall_rating = $this->calculateOverallReviewRating($tempReview);
                continue;
            } 
          $publicReview->$columName = $tempReview->$columName;
       }
       return $publicReview;
    }
    /**
     * Creates new dorm record using info from $temp_review
     */
    public function createDorm($tempReview){
        $uniNameFromReview = $tempReview->uni_name;
        $newDormName = $tempReview->dorm_name;
        $uniOfReview = University::where('uni_name',$uniNameFromReview)->first();
        $uniIdOfReview = $uniOfReview->uni_id;
        if(!Dorm::where('dorm_name',$newDormName)->exists()){
            $this->createNewDorm($uniIdOfReview,$newDormName,$tempReview);

        } else{ 

            $dorm = Dorm::where('dorm_name', $newDormName)->first();

            /*This scenario would occur when users enter review for the same dorm and Admin hasn't 
            pushed the new dorm to the public database so people assume it is a new dorm*/

            $existingDormUniId = $dorm->uni_id;
            $existingDormId= $dorm->dorm_id;

            //Check to see if it is the same dorm but diff uni- i.e. intercollegiate dorm.
            if($existingDormUniId != $uniIdOfReview){   //i.e. uni_id of dorm in public and uni_id of review so must be intercollegiate
               
                $intercollegiateDorm = IntercollegiateDorm::where('dorm_id',$existingDormId)->first();
                if($intercollegiateDorm == null){

                    /*creates intercollegiate dorm and adds uni ids of both review 
                    and existing dorm universities to uni_id_sets, and updates both universities 
                    has_intercollegiate_dorms to true;*/

                    $this->createNewIntercollegiateDorm($existingDormId,$existingDormUniId,$uniIdOfReview);
                    $this->updateHasIntercollegiateDorms($uniOfReview,$existingDormUniId);
                    
                } else{
                    /*adds to existing intercollegiate dorm the uni of the review 
                    and updates the uni's has_intercollegate_dorms field to true;*/
                    $this->appendUniToIntercollegiateDorm($intercollegiateDorm,$uniIdOfReview,$uniOfReview);
                }      
            }         
        }
        $tempReview->dorm_id = Dorm::where('dorm_name', $newDormName)->value('dorm_id');
                
        /**need to see if perhaps intercollegiate, i.e. dorm name exists twice but for diff uni,
        *so iterate through all dorms where dorm_name is $newdormName. but give the one that has 
            sameuninameintemp then when displaying dorms, check if uni/dorm exists in
            this table, if so then shows it as Dorm-name (intercollegiate) and append rest of the reviews 
            for that dorm onto it. 
            here return the dorm which has same uni_name from temp review, also check if it returns a collection or what. 
        */ 
        //here if user enters same dorm name but gives it diff 
    }

    private function createNewDorm($uniIdOfReview,$newDormName,$tempReview){
        $newDorm = new Dorm();
            $newDorm->uni_id = $uniIdOfReview;
            $newDorm->dorm_name = $newDormName;
            $newDorm->reviews_count = 0;    //will be changed after review is inputted
            $newDorm->overall_rating= 0;
            $newDorm->overall_star_ratings = array_fill(0, sizeOf(config('constants.options.starRatings')), 0);  
            $newDorm->has_amenities = array_fill(0, sizeOf(config('constants.options.amenities')), 0);  
            $newDorm->amenities_count = array_fill(0, sizeOf(config('constants.options.amenities')), 0);//number of reviews that say user has these amenities
            $newDorm->address= $tempReview->dorm_address;
            $newDorm->lat= $tempReview->dorm_lat;
            $newDorm->lng= $tempReview->dorm_lng;
            $newDorm->save();
    }

    private function createNewIntercollegiateDorm($existingDormId,$existingDormUniId,$uniIdOfReview){
        $interClgtDorm = new IntercollegiateDorm(); 
        $interClgtDorm->dorm_id = $existingDormId;
        $interClgtDorm->uni_id_set = [$existingDormUniId,$uniIdOfReview];
        $interClgtDorm ->save();
    }

    private function updateHasIntercollegiateDorms($uniOfReview,$existingDormUniId){
        $uniOfReview->has_intercollegiate_dorms = '1';
        $uniOfReview->save();
        $uniOfExistingDorm = University::where('uni_id',$existingDormUniId )->first();
        $uniOfExistingDorm->has_intercollegiate_dorms = '1';
        $uniOfExistingDorm->save();
    }

    private function appendUniToIntercollegiateDorm($intercollegiateDorm,$uniIdOfReview,$uniOfReview){
        $intClgtUniIdSets = $intercollegiateDorm->uni_id_set;
        array_push($intClgtUniIdSets, $uniIdOfReview);
        $intercollegiateDorm->uni_id_set= $intClgtUniIdSets;
        $intercollegiateDorm->save();
        $uniOfReview->has_intercollegiate_dorms = '1';
        $uniOfReview->save();
    }


    public function createNewUni($tempReview){
        $newUniName = $tempReview->uni_name;
        if(!University::where('uni_name',$newUniName)->exists()){
        $newUni = new University();
        $newUni->uni_name= $newUniName;
        $newUni->address= $tempReview->uni_address;
        $newUni->lat= $tempReview->uni_lat;
        $newUni->lng= $tempReview->uni_lng;
        $newUni->has_intercollegiate_dorms = '0';
        $newUni->save();
        }
        $this->createDorm($tempReview);
    }


    public function updateDormStatistics($publicReview,$tempReview){
        //update dorm overall ratings
        $dorm = Dorm::where('dorm_id',$publicReview->dorm_id)->first();
        $this->updateDormOverallRating($dorm,$publicReview);
        $this->updateDormOverallStarRatings($dorm,$tempReview);
        $this->updateDormAmenities($dorm, $tempReview);
        $dorm->reviews_count = $dorm->reviews_count +1;
        $this->validateAndUpdateHasAmenities($dorm);
        $dorm->save();
        //update dorm amenities
    }

    public function updateDormOverallRating($dorm,$review){
        $dormReviewsCount = $dorm->reviews_count;
        $currSumOfDormRating = $dorm->overall_rating * $dormReviewsCount;
        $newOverallDormRating= ($currSumOfDormRating + $review->overall_rating) / (float) ($dormReviewsCount+1);
        $dorm->overall_rating = bcdiv($newOverallDormRating,1,2);
    }
    
    public function updateDormOverallStarRatings($dorm,$tempReview){
        $dormReviewsCount = $dorm->reviews_count;
        $dormStarRatingsArray = $dorm->overall_star_ratings;
        $starRatings = config('constants.options.starRatings');
        for($i=0;$i<sizeof($dormStarRatingsArray); $i++){
            $rating = $starRatings[$i];
            $currStarRating = $dormStarRatingsArray[$i];
            $newReviewStarRating = $tempReview->$rating;
            $newRating= (($currStarRating * $dormReviewsCount) + $newReviewStarRating)/(float) ($dormReviewsCount+1);
            $newRoundedRating = bcdiv($newRating,1,2);  
            $dormStarRatingsArray[$i] = $newRoundedRating;
        }
        $dorm->overall_star_ratings = $dormStarRatingsArray;
       
    }

    public function calculateOverallReviewRating($tempReview){
        $starRatings = config('constants.options.starRatings');
        $sum =0;
        foreach($starRatings as $rating){
            $sum+=$tempReview->$rating;
        }
        return $sum/(float) sizeof($starRatings);
    }
   

    public function updateDormAmenities($dorm, $tempReview){
        $reviewsCount = $dorm->reviews_count;
        $tempReviewAmenitiesArray = explode(',',$tempReview->amenities);    
        $amenitiesArray = config('constants.options.amenities');
            //get json, increase it per new amenities then validateandupdateamenities which saves the data
            $dormAmenitiesCountArray=$dorm->amenities_count;
            //iterate rhough tempreview, find index in amenities array, then use that index to increase dorm amenities count
            foreach($tempReviewAmenitiesArray as $amenity){
                $indexOfAmenity = array_search($amenity,$amenitiesArray);
                $dormAmenitiesCountArray[$indexOfAmenity]++;
            }
            $dorm->amenities_count = $dormAmenitiesCountArray;            
            if($reviewsCount>2){
                print('more than 2 reviews');
                $this->validateAndUpdateHasAmenities($dorm);
            } else{
                $this->updateHasAmenities($dorm);
            }
    }

    public function updateHasAmenities($dorm){
        $amenitiesArraySize = sizeof(config('constants.options.amenities'));
        $dormAmenitiesCountArray = $dorm->amenities_count;
        $dormHasAmenitiyArr = $dorm->has_amenities;
        for($i = 0; $i < $amenitiesArraySize; $i++){
            if($dormAmenitiesCountArray[$i] > 0){
                $dormHasAmenitiyArr[$i] = 1;
            }
        }
        $dorm->has_amenities = $dormHasAmenitiyArr;
    }
    //if a third of the reviews say it has the amenity exists then has_amenity's respective index turns true.
    public function validateAndUpdateHasAmenities($dorm){
        $dormReviewsCount = $dorm->reviews_count;
        $dormAmenitiesCount = $dorm->amenities_count;
        $dormHasAmenitiyArr = $dorm->has_amenities;
        for($i=0;$i<sizeOf($dormAmenitiesCount);$i++){
            if(3*$dormAmenitiesCount[$i] >= $dormReviewsCount){
                $dormHasAmenitiyArr[$i] = 1;
            }
            else{
                $dormHasAmenitiyArr[$i] = 0;
            }
        }
        $dorm->has_amenities = $dormHasAmenitiyArr;
    }



    /*

    public function updateDormAmenities($dorm,$reviewId){
        $reviewCount = $dorm->reviews_count;
        if($reviewCount > 2){
                $amenityArray = $this->createZeroValueAmenityArray();
                $reviews = Review::where('dorm_id',$dorm->dorm_id)->get();
                foreach($reviews as $review){
                    $reviewAmenitiesArr = explode(',',$review->amenities);
                    foreach($reviewAmenitiesArr as $reviewAmenity){
                        $amenityArray[$reviewAmenity]++;
                    }
                }
                $this->validateAndUpdateHasAmenities($dorm,$amenityArray);
            //iterate through all reviews per dorm id and count number of review 
        } else{
            $review = Review::where('id',$reviewId)->first();
            $amenitiesFromReview = $review->amenities;
            $amenitiesArray = explode(',',$amenitiesFromReview);
            foreach($amenitiesArray as $amenity){
                $amenityName = 'has_'.$amenity;
                $dorm->$amenityName = '1';
            }   $dorm->save();
        }
    }

    //create assoc array where all amenities have zero value
    public function createZeroValueAmenityArray(){
        $amenityArray = array();
        $size=count(config('constants.options.amenities')); 

        for ($i = 0; $i < $size; $i++) {
            $amenityArray[config('constants.options.amenities')[$i]] = 0;
          }
        return $amenityArray;   
    }
    */
    /*
    public function updateDormStatistics($reviewId){
        $dormId = Review::where('id',$reviewId)->value('dorm_id');
        $dorm = Dorm::where('dorm_id',$dormId)->first();
        $newReviewRating = $this->overallReviewRating($reviewId);
        $currSumOfDormRating = $dorm->overall_rating * $dorm->reviews_count;
        $dorm->increment('reviews_count');
        $newOverallDormRating= ($currSumOfDormRating + $newReviewRating) / (float) $dorm->reviews_count;
        
        $dorm->overall_rating = $newOverallDormRating;
        $dorm->save();
        $this->updateDormAmenities($dorm,$reviewId);
    
    }
    
*/

}
