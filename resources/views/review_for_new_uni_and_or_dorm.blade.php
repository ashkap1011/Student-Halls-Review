@extends('master_review')


@section('form_header')

    @if ($isNewUni)
        <h2>Let us know your Uni and and we will add it shortly</h2>
    @else
    <h2>Add A New Dorm For {{$uni_name}}</h2>
    @endif


@endsection

@section('form_beginning')

<form action="/post_review_for_new_uni_or_dorm" method="post">
    <!--Add button which goes to uni which shows all dorms-->
    
    @if ($isNewUni)
        <label for="uni_name">Uni Name</label>
        <input type="text" id="uni_name" name="uni_name" required> 
        <input type="text" id="is_new_uni" name="is_new_uni" value="1" hidden>
    @else
        <input type="text" id="is_new_uni" name="is_new_uni" value="0" hidden>
        <input type="text" id="uni_name" name="uni_name" value="{{$uni_name}}" hidden>
    @endif
    

    <label for="dorm_name">Dorm Name</label>
    <input type="text" id="dorm_name" name="dorm_name" value="" required>
    
@endsection
