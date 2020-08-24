@extends('master_review')


@section('form_header')
<h5 id="new_review_form" hidden> </h5>   
<div class="form_initial_fieldset initial_drop_down">
    <label class="form_label" for="uni_name">Select a University</label>
    <div class="form_drp_dwn_and_hyperlink_container">
    <select class="form_drop_down" id="uni_name_drpdwn" name="uni_name_drpdwn">
        <option class="form_drop_down_options" selected disabled hidden style='display: none' value=''></option>

    @foreach ($universities as $university)
    @php ($uni=$university->uni_name)
    <option class="form_drop_down_options" value="{{$uni}}">{{$uni}}</option>
    @endforeach
    </select>
    <a class="form_hyperlink" href="/-/add/new-uni-dorm-review"> Add a New University</a>
</div>
</div>

<div id="dorm_name_section" class="initial_drop_down">
    <label class="form_label initial_drop_downs_labels" for="dorm_name_drpdwn">Select The Dorm</label>
    <div class="form_drp_dwn_and_hyperlink_container">
        <select class="form_drop_down" id="dorm_name_drpdwn" name="dorm_name_drpdwn">
            <option class="form_drop_down_options" selected disabled hidden style='display: none' value=''></option>
        </select>
    
        <a class="form_hyperlink" href="/" id="add_new_dorm">Add a Dorm</a>
    </div>

</div>
@endsection




@section('form_beginning')

<form action="/post_review" method="post">
    <input type="text" id="is_new_uni" name="is_new_uni" value="0" hidden>

    <input type="number" id="dorm_id" name="dorm_id" value="" hidden><br>
    <br>
    
@endsection
