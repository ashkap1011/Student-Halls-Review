<?php

namespace App\Http\Controllers;

use App\Dorm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\TempReview;
use App\Review;
use App\University;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
    
    public function adminPage(){
        
        return view('/admin_panel');
    }
    
    //reviews for pre-existing dorms
    public function reviews(){
        //reviews for pre-existing dorms will not have a dorm name but instead a dorm_id
        $reviews = TempReview::whereNull('dorm_name')->get();
        $type_of_review = 'normal_reviews';

        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        return view('/admin_reviews', compact('reviews','temp_review_columns','type_of_review'));
    }

    //New dorm will have is_new_uni as false and will have a dorm name
    public function reviewsWithNewDorm(){
        $reviews = TempReview::where('is_new_uni','=','0')
                    ->whereNotNull('dorm_name')->get();
        $type_of_review = 'new_dorm_reviews';

        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        return view('/admin_reviews', compact('reviews','temp_review_columns','type_of_review'));
    }

    public function reviewsWithNewUni(){
        $reviews = TempReview::where('is_new_uni','=','1')->get();
        $type_of_review = 'new_uni_reviews';

        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        return view('/admin_reviews', compact('reviews','temp_review_columns','type_of_review'));
    }
    /*Use this and get rid of code but find out why it doesn't work
    public function generateReviews($reviews){
        $temp_review_columns = Schema::getColumnListing('temp_reviews');

        return view('/admin_reviews', compact('reviews','temp_review_columns'));
    }*/

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

    public function migrateTempReviews(Request $request){
        $request->all();
        $reviews_arr = $request->reviewsToMigrate;
        $reviewType =  $request->typeOfReviews;
        
        foreach ($reviews_arr as $reviewId) {
            $tempReview = TempReview::find($reviewId);
            if($reviewType =='new_dorm_reviews'){
                $this->createNewDorm($tempReview);
            } 
            if($reviewType == 'new_uni_reviews'){
                $this->createNewUni($tempReview);
            }
            
            $publicReview = $this->mapTempReviewToPublicReview($tempReview);
            $publicReview->save();
        }
        
    }

    public function mapTempReviewToPublicReview($temp_review){
        $publicReviewColumnNames = Schema::getColumnListing('reviews');
        $publicReview = new Review();
        foreach($publicReviewColumnNames as $columName){
            if($columName =='review_id'){
                continue;
            }
            if($columName =='date'){
                continue;
            }
          $publicReview->$columName = $temp_review->$columName;
       }
       return $publicReview;

    }

    public function createNewDorm($temp_review){
        
        $uniNameFromReview = $temp_review->uni_name;
        $newDormName = $temp_review->dorm_name;

        $uniIdFromUniversities = University::where('uni_name',$uniNameFromReview)->value('uni_id');
        $newDorm = new Dorm();
        $newDorm->uni_id = $uniIdFromUniversities;
        $newDorm->dorm_name = $newDormName;
        $newDorm->save();

        $temp_review->dorm_id = Dorm::where('dorm_name', strval($newDormName))->value('dorm_id');
    }

    public function createNewUni($temp_review){
        $newUniName = $temp_review->uni_name;
        
        $newUni = new University();
        $newUni->uni_name= $newUniName;
        $newUni->save();
        

        $this->createNewDorm($temp_review);

    }

    //set this on foriegn key!!
    //->onDelete('cascade');
    //https://stackoverflow.com/questions/26437342/laravel-migration-best-way-to-add-foreign-key
//read this cos apparently there is another way



}
