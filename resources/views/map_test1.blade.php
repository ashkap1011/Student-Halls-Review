@extends('layouts.master')

@section('title', 'Homepage')

@section('content')
hey
<style>
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
    <div id="map"></div>

    
        <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
    <script defer
   src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDgKta8lMAtyclRFwFAAb-mkGRf8ORQJxo&callback=initMap">
    </script>




@endsection