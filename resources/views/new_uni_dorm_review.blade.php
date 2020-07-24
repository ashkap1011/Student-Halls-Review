@extends('master_review')



@section('form_header')
<h2>Let us know your Uni and and we will add it shortly</h2>
@endsection

@section('form_beginning')

<form action="/post_uni_and_dorm_review" method="post">
    <!--Add button which goes to uni which shows all dorms-->
    
    <label for="uni_name">Uni Name</label>
    <input type="text" id="uni_name" name="uni_name">

    <label for="dorm_name">Dorm Name</label>
    <input type="text" id="dorm_name" name="dorm_name" value="">
    
@endsection
