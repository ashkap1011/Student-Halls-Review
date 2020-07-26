<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\TempReview;
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

        return view('/admin_reviews', compact('reviews','temp_review_columns'));
    }

    //New dorm will have is_new_uni as false and will have a dorm name
    public function reviewsWithNewDorm(){
        $reviews = TempReview::where('is_new_uni','=','0')
                    ->whereNotNull('dorm_name')->get();
        
        $temp_review_columns = Schema::getColumnListing('temp_reviews');

        return view('/admin_reviews', compact('reviews','temp_review_columns'));
    }

    public function reviewsWithNewUni(){
        $reviews = TempReview::where('is_new_uni','=','1')->get();
        $temp_review_columns = Schema::getColumnListing('temp_reviews');

        return view('/admin_reviews', compact('reviews','temp_review_columns'));
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





}
