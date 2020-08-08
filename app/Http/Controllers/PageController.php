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
                $dorm->dorm_name = $dormName . ' (intercollegiate)'; //make it so that it removes distance for the thing
                $dorms[] = $dorm;
                }
            }
        }
        return $dorms;
    }

    public function createReviewsForDorm($uniName, $dormName){
        $dormId = Dorm::where('dorm_name', $dormName)->value('dorm_id');
        $reviews = Review::where('dorm_id', $dormId)->get();
        return view('dorm_reviews', compact('dormName', 'uniName', 'reviews'));
    }


    
        //get highest rated dorm, check to see if uni has intercollegiate, if so find highetrated and compare with this one.
        //you can merge two together:https://stackoverflow.com/questions/42494732/append-a-laravel-collection-with-another-collection
        
    
    ///!!!!!!!!!!!!!!!!!1 for distances remove mins to university, maybe do it client side for dorms that are intercollegiate that way they are good for the uni they originally were.
}
