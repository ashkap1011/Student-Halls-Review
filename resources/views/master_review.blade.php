@extends('layouts.master')

@section('title', 'WriteReviews')

@section('content')
<div class="container">
    <div class="form_header">
        <h1 id="write_review_header_title">write a review</h1>
    </div>
    <div class="form_body">

            @yield('form_header')

            @yield('form_beginning')

            <!-- ratings-->
            <fieldset class="fieldsets">
            @foreach ($starRatings as $rating)
            @if ($rating == 'catered_or_selfcatered_rating')
                @continue;
            @endif
            <label for="{{$rating}}_star_container">{{ucfirst(explode('_',$rating)[0])}}</label>    
            <span class="starRating" id="{{$rating}}_star_container">
                <input class="rating5" id="rating5_{{$rating}}" type="radio" name="{{$rating}}" value="5">
                <label for="rating5_{{$rating}}">5</label>
                <input class="rating4" id="rating4_{{$rating}}" type="radio" name="{{$rating}}" value="4">
                <label for="rating4_{{$rating}}">4</label>
                <input class="rating3" id="rating3_{{$rating}}" type="radio" name="{{$rating}}" value="3">
                <label for="rating3_{{$rating}}">3</label>
                <input class="rating2" id="rating2_{{$rating}}" type="radio" name="{{$rating}}" value="2">
                <label for="rating2_{{$rating}}">2</label>
                <input class="rating1" id="rating1_{{$rating}}" type="radio" name="{{$rating}}" value="1">
                <label for="rating1_{{$rating}}">1</label> 
            </span>
            <br>

            @endforeach
            
            </fieldset>
            
            <!-- recommends-->
            <fieldset class="fieldsets">
            Recommend
            <input type="radio" id="is_recommended_yes" name="is_recommended" value="1" checked>
            <label for="is_recommended_yes">Yes</label>
            <input type="radio" id="is_recommended_no" name="is_recommended" value="0">
            <label for="is_recommended_no">No</label><br><br>
            </fieldset>

            <!-- Year of Study-->
            <fieldset class="fieldsets">
            <br> Year of study:
            <select id="year_of_study" name="year_of_study">
                <option value="First" selected>First</option>
                <option value="Second">Second</option>
                <option value="Third">Third</option>
                <option value="Fourth">Fourth</option>
                <option value="Postgraduate">Postgraduate</option>
            </select>
            </fieldset>

            <fieldset class="fieldsets">
            <!--calendar year-->
            <br> year of residency
            <select id="year" name="year_of_residence" >
                @php ($last= 2015)
                @php ($now = date('Y'))
            
                <option value="{{ $now }}" selected>{{ $now }}</option> 
                @for ($i = $now-1; $i >= $last; $i--)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select> 
            </fieldset>

            <!-- Room type -->
            <fieldset class="fieldsets">
            <br>Room Type:
            <select id="room_type" name="room_type">
                <option value="single" selected>Single</option>
                <option value="double">Double</option>
                <option value="shared">Shared</option>
                <option value="other">Other</option>
            </select>
            </fieldset>

            <fieldset class="fieldsets">
                <label for="is_catered"> Is it Self Catered</label>
                <input type="radio" id="is_catered_yes" name="is_catered" value="1" checked>
                <label for="is_catered_yes">Yes</label>
                <input type="radio" id="is_catered_no" name="is_catered" value="0">
                <label for="is_catered_no">No</label><br>
                <label for="catered_or_selfcatered_rating" id="catered_selfcatered_label"></label>
                <span class="starRating" id="catered_or_selfcatered_rating_star_container">
                    <input class="rating5" id="rating5_catered_or_selfcatered_rating" type="radio" name="catered_or_selfcatered_rating" value="5">
                    <label for="rating5_catered_or_selfcatered_rating">5</label>
                    <input class="rating4" id="rating4_catered_or_selfcatered_rating" type="radio" name="catered_or_selfcatered_rating" value="4">
                    <label for="rating4_catered_or_selfcatered_rating">4</label>
                    <input class="rating3" id="rating3_catered_or_selfcatered_rating" type="radio" name="catered_or_selfcatered_rating" value="3">
                    <label for="rating3_catered_or_selfcatered_rating">3</label>
                    <input class="rating2" id="rating2_catered_or_selfcatered_rating" type="radio" name="catered_or_selfcatered_rating" value="2">
                    <label for="rating2_catered_or_selfcatered_rating">2</label>
                    <input class="rating1" id="rating1_catered_or_selfcatered_rating" type="radio" name="catered_or_selfcatered_rating" value="1">
                    <label for="rating1_catered_or_selfcatered_rating">1</label> 
                </span>
                <br>
            
            </fieldset>

            <fieldset class="fieldsets">
            <br> Amenities: <br>
            @foreach ($amenities as $amenity)
            @php($amenityId=str_replace(' ', '',strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $amenity))))
            <input type='checkbox' id="{{$amenityId}}" name="amenities[]" value="{{$amenity}}">
            <label for="{{$amenityId}}">{{$amenity}} </label><br>
            @endforeach
            </fieldset>

            <fieldset class="fieldsets">
            <br><br> Text
            <textarea name="review_text" rows="10" cols="30" placeholder="Any quirks?"> </textarea>
            <input type="submit" value="Submit">

            </fieldset>
            
            @csrf

        </form>

        use spellcheck attribute
        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
        @endforeach

    </div>
</div>

@endsection
