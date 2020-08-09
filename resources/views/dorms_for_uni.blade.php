@extends('layouts.master')


@section('link')
<script src="https://kit.fontawesome.com/242d15205f.js" crossorigin="anonymous"></script>
@endsection
@section('title', 'University')
@section('content')

<nav class="navbar navbar-expand-sm bg-light navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Active</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      
    </ul>
</nav>

  <div class="background" style="background-image: url(/storage/university-banner/qmul1.jpg);">
  </div>
<div class="container main-body">       

  <h5 id="dorms_for_uni" hidden> </h5>   
  <h1 id="uni_heading">{{strval($uni->uni_name)}} Queen Mary University Of London</h1>

  <div class="row">
    <div class="col-sm-4 col-md-3">
      <div id="amenity_filters">
        <h4>Filter Amenities</h4>
        <p id="filter_sidenote">Generated from our reviews</p>
        @foreach ($amenities as $amenity)
          @if ($amenity =='Games' || $amenity =='Social Events')
              @continue;
          @endif
        <input type="checkbox" id="{{$amenity}}" name="amenity_filters[]" value="{{$amenity}}">
        <label class="filters"for="{{$amenity}}"> {{$amenity}}</label><br>
        @endforeach
      </div>
      <div id="map_container">
        <h4 id="map_title">Halls Location</h4>
        <div id="map"></div>
      </div>
    </div>

    <div class="col-sm-8 col-md-9" id="main_panel_of_dorms" style="background-color:lavenderblush;">
      
      <div class="dorms_header row">
        <div id="dorms_header_title" class="col-sm-4">          
          <h2>Halls</h2> 
        </div>
        <div id="dorms_header_sort" class="col-sm-8">
          <label for="Sort">Sort By:</label>
          <select name="Sort" id="sorting_options_dropdown">
            <option hidden disabled selected value> -- select an option -- </option>
            <option value="name">Name</option>
            <option value="rating">Highest Rating</option>
            <option value="reviews_count">Most Rated</option>
          </select><br>
        </div> 
      </div>

      <div id="dorms">
        
        
      </div>
      
    
      
      
    </div>
  </div>
 




<!--
  https://stackoverflow.com/questions/34028575/determining-if-a-file-exists-in-laravel-5
  https://stackoverflow.com/questions/18424798/twitter-bootstrap-3-how-to-use-media-queries
  --->

</div>
</div>
    <style>
    /* Set the size of the div element that contains the map */
    #map {
      height: 350px;  /* The height is 400 pixels */
      width: 100%;  /* The width is the width of the web page */
     }
  </style>



  
<script>
   var dorms = {!! json_encode($dorms, JSON_HEX_TAG) !!}
    
   var uni = {!! json_encode($uni, JSON_HEX_TAG) !!}

   const AMENITIES = {!!json_encode($amenities)!!}

   
</script>
  <!---
    <script defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgKta8lMAtyclRFwFAAb-mkGRf8ORQJxo&callback=initMap">
    </script>
 --->
@endsection