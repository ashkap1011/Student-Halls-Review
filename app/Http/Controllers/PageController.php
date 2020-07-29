<?php

namespace App\Http\Controllers;

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
            $products=University::where('uni_name','LIKE','%'.$request->search."%")->get();
            if($products) {
                foreach ($products as $key => $product) {
                $output.='<div class="search_results_result">'.
                $product->uni_name.'</div>';
                }
                return Response($output);

            }
        }
    }
}
