@extends('layouts.master')

@section('title', 'Homepage')

@section('content')

<h1 id="uni_heading">{{strval($uni->uni_name)}}</h1>


<div id="sorting_options">
    <h3>Sort</h3>
    <input type="radio" id="date" name="sort_by" value="date">
    <label for="date">Date</label><br>
    <input type="radio" id="name" name="sort_by" value="name">
    <label for="name">Name</label><br>
    <input type="radio" id="rating" name="sort_by" value="rating">
    <label for="rating">Highest Rated</label><br>
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
@foreach ($dorms as $dorm)
    <p>{{$dorm->dorm_name}}</p>
@endforeach

@foreach($intrclgtDorms as $dorm)
<p>{{$dorm->dorm_name}}</p>
@endforeach
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
   var interCollegiateDorms = {!! json_encode($intrclgtDorms, JSON_HEX_TAG) !!}
   console.log(interCollegiateDorms)
   var uni = {!! json_encode($uni, JSON_HEX_TAG) !!}
</script>
<!--
<script defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgKta8lMAtyclRFwFAAb-mkGRf8ORQJxo&callback=initMap">
    </script>
-->
@endsection