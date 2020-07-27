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
        $messages =[
            'required' =>'this is required'
        ];
        
        $Validator = Validator::make(
            $request->all(),
            [
                'value'=>'required|string',
            ],
            $messages
            );


            $id = strval($request->reviewId);
            $column = strval($request->column);
            $value = strval($request->value);

            if($Validator->fails()){
                $Response = ['fail'=>'not good son'];
            }else{
                $Response = ['success'=>'your action has been successful'.$id];
            }
               
        
        $review = TempReview::find($id);
        $review->$column = $value;
        $review->save();
        
        return response()->json($Response,200);
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
            $temp_review = TempReview::find($reviewId);
            if($reviewType =='new_dorm_reviews'){
                $this->createNewDorm($temp_review);
            } 
            if($reviewType == 'new_uni_reviews'){
                $this->createNewUni($temp_review);
            }
            
            $public_review = $this->mapTempReviewToPublicReview($temp_review);
            $public_review->save();
        }
        
    }

    public function mapTempReviewToPublicReview($temp_review){
        $public_review_column_names = Schema::getColumnListing('reviews');
        $public_review = new Review();
        foreach($public_review_column_names as $column_name){
            if($column_name =='review_id'){
                continue;
            }
            if($column_name =='date'){
                continue;
            }
          $public_review->$column_name = $temp_review->$column_name;
       }
       return $public_review;

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
        $newUni = new University();
        $newUni->uni_name= $temp_review->uni_name;
        $newUni->save();
        $this->createNewDorm($temp_review);
    }

    //set this on foriegn key!!
    //->onDelete('cascade');
    //https://stackoverflow.com/questions/26437342/laravel-migration-best-way-to-add-foreign-key
//read this cos apparently there is another way



}
