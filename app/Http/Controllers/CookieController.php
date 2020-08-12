<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
class CookieController extends Controller
{
    public function setNewClapCookie(Request $request){
        if($request->hasCookie('review_claps') != false){
            $reviewsIdEncoded = Cookie::get('review_claps');
            $reviewIdArray= json_decode($reviewsIdEncoded);
        } else{
            $reviewIdArray = array();
        }   
        array_push($reviewIdArray, $request->reviewId);
        print_r($reviewIdArray);
        $response = $this->updateCookie($reviewIdArray);
        return $response;
    }

    private function updateCookie($reviewIdArray){
        echo"updating";
        print_r($reviewIdArray);
        $minutes =1;
        $response = new Response('cookie set');
        $reviewsEncoded = json_encode($reviewIdArray);
        $response->withCookie(cookie('review_claps',$reviewsEncoded,$minutes)); //todo make it forever
        return $response;
    }

    public function deleteReviewFromClapCookie(Request $request){
        echo "deleting";
        $reviewsEncoded = Cookie::get('review_claps');
        $reviews= json_decode($reviewsEncoded);
        $reviewToRemove = $request->reviewId;
        $keyInCookie = array_search($reviewToRemove,$reviews);
        print($keyInCookie);
        if($keyInCookie !== FALSE){
            echo ('key found');
            unset($reviews[$keyInCookie]);
            $updatedReviews = array_values($reviews);
            $response = $this->updateCookie($updatedReviews);
            return $response;
        }
    }


    public function getClapCookie(Request $request){
       $value = $request->cookie('review_claps');
       return $value;
    }



}
