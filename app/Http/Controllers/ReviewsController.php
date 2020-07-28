<?php

namespace App\Http\Controllers;

use App\TempReview;
use App\University;
use App\Dorm;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{   
    public function writeReview(){
        $universities = University::all();
        $amenities = array('common_area', 'games','outdoor_area','elevator'
    ,'communal_kitchen','catering','private_bathroom'
    , 'social_events','mature_students_only');
        return view('review', compact('universities','amenities'));
    }


    public function newUniOrDormReviewPage($uni_name){
        $amenities = array('common_area', 'games','outdoor_area','elevator'
    ,'communal_kitchen','catering','private_bathroom'
    , 'social_events','mature_students_only');

        $isNewUni =false;
        if ($uni_name == '-'){
            $isNewUni = true;
        }

        return view('review_for_new_uni_and_or_dorm', compact('uni_name', 'amenities','isNewUni'));
    }

   

    public function createNewReview(Request $request){
           

        $temp_review = $this->appendReview($request);
        $temp_review->dorm_id = $request->input('dorm_id'); 
        $temp_review->save();
    }

    public function createReviewForNewUniOrDorm(Request $request){
        $request->validate([
            'uni_name' => 'required',
            'dorm_name' => 'required',
        ]);

        $temp_review = $this->appendReview($request);
        $temp_review->uni_name = $request->input('uni_name');
        $temp_review->dorm_name = $request->input('dorm_name');
        $temp_review->save();
    }

    public function appendReview($request){

        $request->validate([//addminmaxvalues
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
            'quirk' => 'nullable',
            'review_text' => 'nullable',
        ]);
        $temp_review = new TempReview();
        $temp_review->is_new_uni = $request->input('is_new_uni');
        $temp_review->room_rating = $request->input('room_rating');
        $temp_review->building_rating = $request->input('building_rating');
        $temp_review->location_rating = $request->input('location_rating');
        $temp_review->bathroom_rating = $request->input('bathroom_rating');
        $temp_review->staff_rating = $request->input('staff_rating');
        $temp_review->is_recommended = $request->input('is_recommended');
        $temp_review->year_of_study = $request->input('year_of_study');
        $temp_review->year_of_residence = $request->input('year_of_residence');
        $temp_review->room_type = $request->input('room_type');
                
        $temp_review->is_catered = $request->input('is_catered');
        $temp_review->catered_or_selfcatered_rating = $request->input('catered_or_selfcatered_rating');

        $has_amenities = $request->input('amenities');

        if($has_amenities  !== null){
            $temp_review->amenities = implode(',',$has_amenities);
        }
        $temp_review->quirk = $request->input('quirk');
        $temp_review->review_text = $request->input('review_text');

        return $temp_review;
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


    


    /*
    Use for other review pages 

https://laravel.com/docs/7.x/eloquent#eloquent-model-conventions
https://laravel.com/docs/7.x/eloquent-collections#available-methods
https://laravel.com/docs/7.x/queries#retrieving-results


    */


}
