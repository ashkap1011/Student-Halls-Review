<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\TempReview;


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

    /*
     $all_temp_reviews = TempReview::all();
        $temp_review_columns= Schema::getColumnListing('temp_reviews');
        var_dump($temp_review_columns);
         */


    /**
     * 
<table >
    <thead>
        @foreach ($temp_review_columns as $column_name)
        <th>{{ $column_name }}<th>
        @endforeach
    </thead>
    @foreach ($all_temp_reviews as $row)
        <tr>
            @foreach ($temp_review_columns as $column)
            <td>{{$row->$column}}</td>    
            @endforeach
        </tr>
    @endforeach
</table>
     */



}
