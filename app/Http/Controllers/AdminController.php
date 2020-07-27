<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\TempReview;
use App\Review;
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
        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        $type_of_review = 'normal_reviews';
        return view('/admin_reviews', compact('reviews','temp_review_columns','type_of_review'));
    }

    //New dorm will have is_new_uni as false and will have a dorm name
    public function reviewsWithNewDorm(){
        $reviews = TempReview::where('is_new_uni','=','0')
                    ->whereNotNull('dorm_name')->get();
        
        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        $type_of_review = 'new_dorm_reviews';
        return view('/admin_reviews', compact('reviews','temp_review_columns','type_of_review'));
    }

    public function reviewsWithNewUni(){
        $reviews = TempReview::where('is_new_uni','=','1')->get();
        $temp_review_columns = Schema::getColumnListing('temp_reviews');
        $type_of_review = 'new_uni_reviews';
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
        
        //var_dump($request->value);
    }

    public function deleteTempReview(Request $request){
        $request->all();
        $id = strval($request->reviewId);
        $review = TempReview::find($id);
        $review->delete();
    }

    public function migrateTempReview(Request $request){
        $request->all();

        //
        //$ans = implode(" ",$request->reviewsToMigrate);
        $reviews_arr = $request->reviewsToMigrate;
        $reviewType =  $request->typeOfReviews;
        //$reviews_arr = (array) $reviews_arr;
        
        foreach ($reviews_arr as $reviewId) {
            $public_review_column_names = Schema::getColumnListing('reviews');
            $temp_review = TempReview::find($reviewId);
            $public_review = new Review();
            if($reviewType =='normal_reviews'){
                foreach($public_review_column_names as $column_name){
                    if($column_name =='review_id'){
                        continue;
                    }
                    if($column_name =='date'){
                        continue;
                    }
                  $public_review->$column_name = $temp_review->$column_name;
               }

            } else if($reviewType ==='new_dorm_reviews'){
                return response()->json('not good',200);
            } else{
                return response()->json('nor this',200);
            }
            $public_review->save();
        }
        /**
         * $public_review_column_names = implode(" ",$public_review_column_names);
            return response()->json('normal'.$public_review_column_names,200);
         */
    }





}
