@extends('layouts.master')

@section('title', 'University')

@section('content')
<div class="container-fluid">


<div class="container">



<div class="jumbotron">
    <h1>Bootstrap Tutorial</h1>
    <p>Bootstrap is the most popular HTML, CSS...</p>
</div>
</div>

<h5 id="dorms_for_uni" hidden> </h5>   
<h1 id="uni_heading">{{strval($uni->uni_name)}}</h1>


<div id="sorting_options">
    <h3>Sort</h3>
    <input type="radio" id="name" name="sort_by" value="name">
    <label for="name">Name</label><br>
    <input type="radio" id="rating" name="sort_by" value="rating">
    <label for="rating">Highest Rating</label><br>
    <input type="radio" id="reviews_count" name="sort_by" value="reviews_count">
    <label for="reviews_count">Most Rated</label><br>
</div>


<div id="amenity_filters">
    <h3>Filters</h3>
@foreach ($amenities as $amenity)
    <input type="checkbox" id="{{$amenity}}" name="amenity_filters[]" value="{{$amenity}}">
    <label for="{{$amenity}}"> {{$amenity}}</label><br>
@endforeach
</div>

<h2>Dorms</h2>
<div id="dorms_div">


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