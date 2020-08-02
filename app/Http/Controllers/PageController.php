<?php

namespace App\Http\Controllers;
use Config;
use App\Dorm;
use App\IntercollegiateDorm;
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
        $uniId = strval($uni->uni_id);
        $dorms = Dorm::where('uni_id',$uniId)->get();
        $amenities = config('constants.options.amenities');
        $intrclgtDorms = [];
        if($uni->has_intercollegiate_dorms =='1'){
            $intrclgtDorms= $this->appendIntercollegiateDorms($dorms,$uni->uni_id);
            

        }
        return view('/dorms_for_uni', compact('dorms','uni','amenities','intrclgtDorms'));
        //return view showing all dorms and filter list
    }

    public function getDormsPerFilters(){
       $dorms = Dorm::where('amenities','communal_kitchen')->get();
       print_r($dorms);
    }

    public function appendIntercollegiateDorms($dormsArr,$uniId){
        $allIntercollegiateDorms = IntercollegiateDorm::all();
        $intercollegiateDormsArr = [];
        foreach($allIntercollegiateDorms as $interclgtDorm){
            if(in_array($uniId,$interclgtDorm->uni_id_set)){
                $dorm = Dorm::where('dorm_id', $interclgtDorm->dorm_id)->first();
                if($dorm->uni_id != $uniId){        //avoids adding interCltdorms whose uni_id is same as the requested uni, i.e. already in $dorms of method caller
                $intercollegiateDormsArr[] = $dorm;
                }
            }
        }
        return $intercollegiateDormsArr;
    }



}
