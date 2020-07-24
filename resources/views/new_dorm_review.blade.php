@extends('master_review')



@section('form_header')
<h2>Add A New Dorm For {{$uni_name}}</h2>
@endsection

@section('form_beginning')

<form action="/post_dorm_review" method="post">
    <!--Add button which goes to uni which shows all dorms-->
    
    <input type="text" id="uni_name" name="uni_name" value="{{$uni_name}}" hidden>

    <label for="dorm_name">Dorm Name</label>
    <input type="text" id="dorm_name" name="dorm_name" value="">
    
@endsection
