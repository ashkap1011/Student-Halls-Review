<?php

namespace App\Http\Controllers;
use Config;
use App\Dorm;
use App\IntercollegiateDorm;
use App\Review;
use App\University;
use Illuminate\Http\Request;

class PageController extends Controller
{   
    public function index(){
        return view('homepage');
    }

    public function search(Request $request){
        
        if($request->ajax()) {
            $output="";
            $universities=University::where('uni_name','LIKE','%'.$request->search."%")->get();
            if($universities) {
                foreach ($universities as $key => $uni) {
                $uniName = $uni->uni_name;
                $output.='<div class="search_result"> <a href="/'.$uniName.'/dorms">'.$uniName.'</a></div>';
                }
                return Response($output);
                //add pagentate probably
            }
        }
    }

    public function createDormsForUni($uniName){
        $uni = University::where('uni_name',strval($uniName))->first();
        $amenities = config('constants.options.amenities');
        $dorms = $this->getDormsForUni($uni);
        return view('/dorms_for_uni', compact('dorms','uni','amenities'));
        
    }   
    //not sure if we use the next method at all, blocked it from web.php
    public function getFilteredDorms(Request $request,$uniName){
        $uni = University::where('uni_name',strval($uniName))->first();
        $dorms = $this->getDormsForUni($uni);
    }
    
    public function getDormsForUni($uni){
        $uniId = $uni->uni_id;
        $dorms = Dorm::where('uni_id',$uniId)->get()->toArray();
        if($uni->has_intercollegiate_dorms =='1'){
            $dorms= $this->seekIntercollegiateDorms($dorms,$uniId);
        }
        return $dorms;
    }

    public function seekIntercollegiateDorms($dorms,$uniId){
        $allIntercollegiateDorms = IntercollegiateDorm::all();
        foreach($allIntercollegiateDorms as $interclgtDorm){
            if(in_array($uniId,$interclgtDorm->uni_id_set)){
                $dorm = Dorm::where('dorm_id', $interclgtDorm->dorm_id)->first();
                if($dorm->uni_id != $uniId){        //avoids adding interCltdorms whose uni_id is same as the requested uni, i.e. already in $dorms of method caller
                $dormName = $dorm->dorm_name;
                $dorm->dorm_name = $dormName . ' (I)'; //make it so that it removes distance for the thing
                $dorms[] = $dorm;
                }
            }
        }
        return $dorms;
    }

    public function createReviewsForDorm($uniName, $dormName){
        $uni = University::where('uni_name',$uniName)->first();
        $dorm = Dorm::where('dorm_name', $dormName)->first();
        $reviews = Review::where('dorm_id', $dorm->dorm_id)->get();
        return view('reviews_for_dorm', compact('dorm', 'uni', 'reviews'));
    }


    
        //get highest rated dorm, check to see if uni has intercollegiate, if so find highetrated and compare with this one.
        //you can merge two together:https://stackoverflow.com/questions/42494732/append-a-laravel-collection-with-another-collection
        
    
    ///!!!!!!!!!!!!!!!!!1 for distances remove mins to university, maybe do it client side for dorms that are intercollegiate that way they are good for the uni they originally were.
}
