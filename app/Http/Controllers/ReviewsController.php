<?php

namespace App\Http\Controllers;

use App\TempReview;
use App\University;
use App\Dorm;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{   

    public function index(){
        $universities = University::all();
        $amenities = array('common_area', 'games','outdoor_area','elevator'
    ,'communal_kitchen','catering','private_bathroom'
    , 'social_events','mature_students_only');
        return view('review', compact('universities','amenities'));
    }

    public function create(Request $request){
        
        $temp_review = new TempReview();
        
        $temp_review->dorm_id = $request->input("dorm_id");


        $temp_review->room_rating = $request->input("room_rating");
        $temp_review->building_rating = $request->input("building_rating");
        $temp_review->location_rating = $request->input("location_rating");
        $temp_review->bathroom_rating = $request->input("bathroom_rating");
        $temp_review->staff_rating = $request->input("staff_rating");
        $temp_review->is_recommended = $request->input("is_recommended");
        $temp_review->year_of_study = $request->input("year_of_study");
        $temp_review->year_of_residence = $request->input("year_of_residence");
        $temp_review->room_type = $request->input("room_type");
                
        $temp_review->is_catered = $request->input("is_catered");
        $temp_review->catered_or_selfcatered_rating = $request->input("catered_or_selfcatered_rating");

        $has_amenities = $request->input("amenities");

        if($has_amenities  !== null){
            $temp_review->amenities = implode(",",$has_amenities);
        }
        $temp_review->quirk = $request->input("quirk");
        $temp_review->review_text = $request->input("review_text");
        
        $temp_review->save();
    }

    public function dormsOnUniSelection($uni_name){
        $uni_id = University::where('uni_name', strval($uni_name))->value('uni_id');
        $dorms_of_uni = Dorm::where('uni_id', strval($uni_id))->get();   

        $dorm_name_arr= array();
        foreach($dorms_of_uni as $dorm){
            array_push($dorm_name_arr, strval($dorm->dorm_name));
        }
        return $dorm_name_arr;
    }

    public function dormNameToId($dorm_name){
        $dorm_id = Dorm::where('dorm_name', strval($dorm_name))->value('dorm_id');
        
        return $dorm_id;
    }

    public function newDormReviewPage($uni_name){
        $amenities = array('common_area', 'games','outdoor_area','elevator'
    ,'communal_kitchen','catering','private_bathroom'
    , 'social_events','mature_students_only');
        return view('new_dorm_review', compact('uni_name', 'amenities'));
    }






    //https://stackoverflow.com/questions/40640069/dynamic-dropdown-options-with-jquery

    
    /*
    Use for other review pages 
     <br>
    <input type="text" id="uni_name" name="uni_name" value="" hidden><br>
    dorm name
    <input type="text" id="dorm_name" name="dorm_name" value="" ><br>
    uni id
    <input type="number" id="uni_id" name="uni_id" value="" ><br>
    dorm id

    https://stackoverflow.com/questions/548541/insert-ignore-vs-insert-on-duplicate-key-update
https://stackoverflow.com/questions/37836087/get-all-fields-from-db-model-in-laravel#:~:text=You%20can%20use%20Schema%3A%3A,values%20of%20your%20Drink%20object.
https://laravel.com/docs/7.x/mix#vanilla-js
https://www.hungred.com/how-to/tutorial-jquery-select-box-manipulation-plugin/
https://laravel.com/docs/7.x/eloquent#eloquent-model-conventions
https://laravel.com/docs/7.x/eloquent-collections#available-methods
https://laravel.com/docs/7.x/queries#retrieving-results


    */


}
