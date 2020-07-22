@extends('master_review')


@section('form_beginning')

<label for="uni_name">Select a University</label>
<select id="uni_name_drpdwn" name="uni_name_drpdwn">
    <option selected disabled hidden style='display: none' value=''></option>

@foreach ($universities as $university)
@php ($uni=$university->uni_name)
<option value="{{$uni}}">{{$uni}}</option>
@endforeach
</select>

<label for="dorm_name_drpdwn">Select The Dorm</label>
<select id="dorm_name_drpdwn" name="dorm_name_drpdwn">
    <option selected disabled hidden style='display: none' value=''></option>

</select>

<form action="/newreview" method="post">
    
    <input type="number" id="dorm_id" name="dorm_id" value=""><br>
    <br>
    
@endsection
