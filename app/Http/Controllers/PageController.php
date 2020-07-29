<?php

namespace App\Http\Controllers;

use App\Dorm;
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
        $uniId = University::where('uni_name',strval($uniName))->value('uni_id');
        $dorms = Dorm::where('uni_id',strval($uniId))->get();

        return view('/dorms_for_uni', compact('dorms','uniName'));
        //return view showing all dorms and filter list
    }
}
