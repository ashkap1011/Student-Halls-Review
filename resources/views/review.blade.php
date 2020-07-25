@extends('master_review')


@section('form_header')

<label for="uni_name">Select a University</label>
<select id="uni_name_drpdwn" name="uni_name_drpdwn">
    <option selected disabled hidden style='display: none' value=''></option>

@foreach ($universities as $university)
@php ($uni=$university->uni_name)
<option value="{{$uni}}">{{$uni}}</option>
@endforeach
</select>


<a href="/-/add/new-uni-dorm-review"> Add a New University</a>

<div id="dorm_name_section">
<label for="dorm_name_drpdwn">Select The Dorm</label>
<select id="dorm_name_drpdwn" name="dorm_name_drpdwn">
    <option selected disabled hidden style='display: none' value=''></option>
</select>

<a href="/" id="add_new_dorm">Add a Dorm</a>
</div>
@endsection




@section('form_beginning')


<form action="/post_review" method="post">
    <input type="text" id="is_new_uni" name="is_new_uni" value="0" hidden>

    <input type="number" id="dorm_id" name="dorm_id" value="" hidden><br>
    <br>
    
@endsection
