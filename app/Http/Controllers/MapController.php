<?php

namespace App\Http\Controllers;

use App\MapTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{
    public function index(){
        
          return view('map_test1');
          
    }   

    Public function addData(){
        $markers = MapTest::all();
        return json_encode($markers);
    }


    /**
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */


}
