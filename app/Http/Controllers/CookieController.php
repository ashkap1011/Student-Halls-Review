<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;
class CookieController extends Controller
{
    public function setClapCookie(Request $request){
        
        if($request->hasCookie('review_claps') != false){
            $this->updateCookie($request);
        } else{
            $minutes =1;
            $response = new Response('cookie set');
            $review = [];
            $review[]=1;
            $reviewsEncoded = json_encode($review);
            $response->withCookie(cookie('review_claps',$reviewsEncoded,$minutes));
            return $response;
        }        
    }

    public function getClapCookie(Request $request){
       $value = $request->cookie('review_claps');
       return $value;
    }

    public function updateCookie($request){
        $reviewsEncoded = Cookie::get('review_claps');
        $reviews= json_decode($reviewsEncoded);
        
    }




}
