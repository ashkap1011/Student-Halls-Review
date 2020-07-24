@extends('master_review')


@section('form_beginning')

<form action="/dorm_review" method="post">
    
    <input type="text" id="uni_name" name="uni_name" value="{{$uni_name}}">

    <input type="number" id="dorm_name" name="dorm_name" value="">
    
@endsection
