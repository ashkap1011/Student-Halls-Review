<?php

namespace App\Http\Controllers;

use App\MapTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{
    public function index(){
        $markers = MapTest::all();
        header("Content-type: text/xml");
        // Start XML file, echo parent node
        echo "<?xml version='1.0' ?>";
        echo '<markers>';
        
        foreach($markers as $row){
            // Add to XML document node
            echo '<marker ';
            echo 'id="' . $row['id'] . '" ';
            echo 'name="' . $this->parseToXML($row['name']) . '" ';
            echo 'address="' .  $this->parseToXML($row['address']) . '" ';
            echo 'lat="' . $row['lat'] . '" ';
            echo 'lng="' . $row['lng'] . '" ';
            echo 'type="' . $row['type'] . '" ';
            echo '/>';
            
          }
          
          // End XML file
          echo '</markers>';
          return view('map_test1');
          
    }   

    function parseToXML($htmlStr){
        $xmlStr=str_replace('<','&lt;',$htmlStr);
        $xmlStr=str_replace('>','&gt;',$xmlStr);
        $xmlStr=str_replace('"','&quot;',$xmlStr);
        $xmlStr=str_replace("'",'&#39;',$xmlStr);
        $xmlStr=str_replace("&",'&amp;',$xmlStr);
        return $xmlStr;
    }

    Public function addData(){
 //DB::insert('insert into map_test (id, name) values (?, ?)', [1, 'Dayle']);
 DB::insert('insert into map_test (id, name, address, lat, lng, type) values (?, ?, ?, ?, ?,?)', ['2', 'Young Henrys', '76 Wilford Street, Newtown, NSW', '-33.898113', '151.174469', 'bar']);
 DB::insert('insert into map_test (id, name, address, lat, lng, type) values (?, ?, ?, ?, ?,?)', ['3', 'Hunter Gatherer', 'Greenwood Plaza, 36 Blue St, North Sydney NSW', '-33.840282', '151.207474', 'bar']);
 DB::insert('insert into map_test (id, name, address, lat, lng, type) values (?, ?, ?, ?, ?,?)', ['4', 'The Potting Shed', '7A, 2 Huntley Street, Alexandria, NSW', '-33.910751', '151.194168', 'bar']);
 DB::insert('insert into map_test (id, name, address, lat, lng, type) values (?, ?, ?, ?, ?,?)', ['5', 'Nomad', '16 Foster Street, Surry Hills, NSW', '-33.879917', '151.210449', 'bar']);
 DB::insert('insert into map_test (id, name, address, lat, lng, type) values (?, ?, ?, ?, ?,?)', ['6', 'Three Blue Ducks', '43 Macpherson Street, Bronte, NSW', '-33.906357', '151.263763', 'restaurant']);


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
