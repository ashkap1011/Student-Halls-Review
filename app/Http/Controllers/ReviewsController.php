<?php

namespace App\Http\Controllers;

use App\TempReview;
use App\University;
use App\Dorm;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{   

        //maybe private universities might work here

    public function index(){
        $universities = University::all();

        $amenities = array('common_area', 'games','outdoor_area','elevator'
                    ,'communal_kitchen','catering','private_bathroom'
                    , 'social_events','mature_students_only');

        return view('review', compact('universities','amenities'));
    }

    public function create(Request $request){
        var_dump($request->input("amenities"));
        
        $tempReview = new TempReview();
        
        $tempReview->dorm_id = $request->input("dorm_id");
        $tempReview->room_rating = $request->input("room_rating");
        $tempReview->building_rating = $request->input("building_rating");
        $tempReview->location_rating = $request->input("location_rating");
        $tempReview->bathroom_rating = $request->input("bathroom_rating");
        $tempReview->staff_rating = $request->input("staff_rating");
        $tempReview->is_recommended = $request->input("is_recommended");
        $tempReview->year_of_study = $request->input("year_of_study");
        $tempReview->year_of_residence = $request->input("year_of_residence");
        $tempReview->room_type = $request->input("room_type");
        
        
        $tempReview->is_catered = $request->input("is_catered");
        $tempReview->catered_or_selfcatered_rating = $request->input("catered_or_selfcatered_rating");

        $has_amenities = $request->input("amenities");

        if($has_amenities  !== null){
            $tempReview->amenities = implode(",",$has_amenities);
        }
        $tempReview->quirk = $request->input("quirk");
        $tempReview->review_text = $request->input("review_text");


        /*
        $input = $request->all();
        foreach($input as $key=>$value){
            //$tempReview->$key = $request->input(strval($value));
            //var_dump($tempReview);
           
        }
        */
        
        $tempReview->save();

    }

    public function dormsOnUniSelection($uniName){
        $uniID = University::where('uni_name', strval($uniName))->value('uni_id');
        $dormsForUni = Dorm::where('uni_id', strval($uniID))->get();   

        $dormNameArr= array();
        foreach($dormsForUni as $eh){
            array_push($dormNameArr, strval($eh->dorm_name));
        }
        return $dormNameArr;
    }

    public function dormNameToId($dormName){
        $dormId = Dorm::where('dorm_name', strval($dormName))->value('dorm_id');
        
        return $dormId;
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
