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
  <h1 id="uni_heading">{{strval($uni->uni_name)}}</h1>

  <div class="row">
    <div class="col-md-auto col-lg-3" id="left_panel" >
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
    </div>

    <div class="col-lg-9" style="background-color:lavenderblush;">
      <div class="halls_header">
        <div id="halls_header_title">          
          <h2>Halls</h2> 
        </div>
        <div id="halls_header_right">
          <label for="Sort">Sort By:</label>
          <select name="Sort" id="sorting_options_dropdown">
            <option hidden disabled selected value> -- select an option -- </option>
            <option value="name">Name</option>
            <option value="rating">Highest Rating</option>
            <option value="reviews_count">Most Rated</option>
          </select><br>
        </div> 
      </div>
      <div class="halls">
        <div class="row ">
          <div class="col-12 col-xl-6 h-100 mb-3 stretched-link hall_card">
            <div class="card bg-light">
              <div class="card-body">
                <img class="card-img dorm_icon" src="/storage/dormIcon.jpg" alt="Card image">
                <div class="card_right_panel float-left pl-5">
                  <h3 class="card-title">Wood Green</h3>
                    <div class="star_rating">
                      <p class="overall_rating_decimal pl-2">3.2</p>
                      <i class="fas fa-star star-icon pl-2"></i>
                      <i class="fas fa-star star-icon"></i>
                      <i class="fas fa-star-half-alt star-icon"></i>
                      <i class="far fa-star star-icon"></i>
                      <i class="far fa-star star-icon"></i>
                    </div><br>
                  <span class="number_of_reviews">28 reviews</span> <br>
                  <img src="http://www.googlemapsmarkers.com/v1/A/0099FF/">
                  <span>15 mins walk</span>
                  <i class="fas fa-running"></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-6 h-100 mb-3 stretched-link hall_card">
            <div class="card bg-light">
              <div class="card-body">
                <img class="card-img dorm_icon" src="/storage/dormIcon.jpg" alt="Card image">
                <div class="right_panel float-left pl-4">
                  <h3 class="card-title">This is a long name</h3>
                    <div class="star_rating">
                      <p class="overall_rating_decimal pl-2">3.2</p>
                      <i class="fas fa-star star-icon pl-2"></i>
                      <i class="fas fa-star star-icon"></i>
                      <i class="fas fa-star-half-alt star-icon"></i>
                      <i class="far fa-star star-icon"></i>
                      <i class="far fa-star star-icon"></i>
                    </div><br>
                  <span class=float-right >28 reviews</span> <br>
                  <img src="http://www.googlemapsmarkers.com/v1/A/0099FF/">
                  <span>15 mins walk</span>
                  <i class="fas fa-running"></i>
                </div>
              </div>
            </div>
          </div>
      </div>
        
      </div>

      <div class = "row">
        <div id="dorms_div">
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
      height: 400px;  /* The height is 400 pixels */
      width: 100%;  /* The width is the width of the web page */
     }
  </style>



  <div id="map"></div>
<script>
   var dorms = {!! json_encode($dorms, JSON_HEX_TAG) !!}
    
   var uni = {!! json_encode($uni, JSON_HEX_TAG) !!}

   const AMENITIES = {!!json_encode($amenities)!!}

   
</script>
<!--
<script defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgKta8lMAtyclRFwFAAb-mkGRf8ORQJxo&callback=initMap">
    </script>
-->
@endsection