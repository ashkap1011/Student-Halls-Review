@extends('master')

@section('title', 'WriteReviews')

@section('content')

    @yield('form_beginning')

    <!-- ratings-->
    <fieldset class="fieldsets">
    Room 
    <input type="number" class="star_ratings"id="room_rating" name="room_rating"  min="1" max="5"><br>
    Building
    <input type="number" class="star_ratings" id="building_rating" name="building_rating"  min="1" max="5"><br>
    Location
    <input type="number" class="star_ratings" id="location_rating" name="location_rating"  min="1" max="5"><br>
    Bathroom
    <input type="number" class="star_ratings" id="bathroom_rating" name="bathroom_rating"  min="1" max="5"><br>
    Staff
    <input type="number" class="star_ratings" id="staff_rating" name="staff_rating"  min="1" max="5"><br>
    </fieldset>
    
    <!-- recommends-->
    <fieldset class="fieldsets">
    Recommend
    <input type="radio" id="yes" name="is_recommended" value="1" checked>
    <label for="yes">Yes</label>
    <input type="radio" id="no" name="is_recommended" value="0">
    <label for="no">No</label><br><br>
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
    <select id="year" name="year_of_residence" class="">
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
    <br> Amenities: <br>
    @foreach ($amenities as $amenity)
    @php($amenityValue=ucwords(str_replace("_"," ",$amenity)))
    <input type='checkbox' id="{{$amenity}}" name="amenities[]" value="{{$amenity}}">
    <label for="{{$amenity}}">{{$amenityValue}} </label><br>
    @endforeach
    </fieldset>
    

    <fieldset class="fieldsets">
    <br> Quriks:
    <textarea name="quirk" rows="1" cols="30" placeholder="Any quirks?"> </textarea>
    <br><br> Text
    <textarea name="review_text" rows="10" cols="30" placeholder="Any quirks?"> </textarea>
    </fieldset>
    
    @csrf

    <input type="submit" value="Submit">
</form>
use spellcheck attribute

@endsection
