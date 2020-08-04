@extends('layouts.master')



@section('title', 'Review')

@section('content')
<h1>{{$uniName}}</h1>
<h2>Dorm: {{$dormName}}</h2>

@foreach ($reviews as $review)
   {{$review}} 
@endforeach
@endsection

<!--

-->