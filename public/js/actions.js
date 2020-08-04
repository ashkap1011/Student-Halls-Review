//const { toArray, create } = require("lodash");
//don't know why the above function exists
$(document).ready(function(){
    
    /*sets as deafualt the dorm being self catered 
    and so it changes rating to communal kitchen and 
    selects communal kitchen check box as checked.
    */
    if($('#new_review_form').length){
        $('#catered_selfcatered_label').text('Communal Kitchen rating')
        $('.fieldsets #communal_kitchen').prop('checked', true);
    
        if($('#dorm_id').html() == null){
            $('.fieldsets').show();
        }
    
        //takes care of the case where the user goes back from Add a Dorm hyperlink
        if($('select#uni_name_drpdwn option:checked').val() !== ''){
            setDormSectionPerUniSelection();
        }
        
        //populates dorms for chosen uni in drop down
        $('#uni_name_drpdwn').change(function(){
            console.log('new uni selected')
            setDormSectionPerUniSelection()
          });
    
        //sets dorm_id based on drop down  
        $('#dorm_name_drpdwn').change(function(){
            let dormName =$(this).val(); //have the value of uni chosen
            setDormIdFormElement(dormName);
        });
    
        /*checks to see the correct catering related amenity is selected based
        on user selection, also changes the text for the catering/self catered 
        rating
        */
    }
    
    $('input[type=radio][name=is_catered]').change(function(){
        if ($('input[type=radio][name=is_catered]:checked').val() === '0'){
            $('#catered_selfcatered_label').text('Food Quality rating');
            $('#communal_kitchen').prop('checked', false);
            $('#catering').prop('checked', true);

        } else{
            $('#catered_selfcatered_label').text('Communal Kitchen rating');
            $('#communal_kitchen').prop('checked', true);
            $('#catering').prop('checked', false);
        }
    });

    $('.editable_cell').dblclick(function() {
        let val = $(this).html();
        
        let elementId = $(this).attr('class').split(' ').pop();//gives you the second class name of element
        $(this).append('<input type = "text" name="updated_text" value="' + val + 
        '" /><input type="button" class="update_btn" onclick="updateReview(this)" value="Update"></td>');
        
        //var rowId = $(this).attr('class').replace(/[^\d\.]/g, ''); //temp_review
        //$('.td_of_row_'+rowId).empty().append('<input type="text" name="test" value="' + rowId + '" /><input type="submit" />')
        //$(this).parent('td').prev('td').empty().html('<input type="text" name="test" value="' + vvaall + '" /><input type="submit" />');
      });

      /*********************************/
      //TODO remove onClick from above function and make it work.
      
      $('.delete_btn').click(function(){
        //add r u sure!!!!
        let rowId = $(this).attr('id').replace(/[^\d\.]/g, '');
        $.post('/delete_temp_review',{
            '_token': $('meta[name=csrf-token]').attr('content'),
            reviewId: rowId
        });
        location.reload();
      });
      
      //pushes reviews from temp_reviews to public reviews
    $('#push_btn').click(function(){
        let reviewsToPush = $('input:checkbox:checked').map(function(){
            return $(this).attr('id').replace(/[^\d\.]/g, '');
          }).get(); 
        let reviewType = $('#type_of_reviews').html();
        
        $.post('/migrate_temp_review',{
            '_token': $('meta[name=csrf-token]').attr('content'),
            reviewsToMigrate: reviewsToPush,
            typeOfReviews: reviewType
        });
       

    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
        
    $('#search').on('keyup',function(){
        console.log('yes')
        $value=$(this).val();
        $.ajax({
            type : 'get',
            url : '/search',
            data:{'search':$value},
            success:function(data){
            $('.search_results').html(data);
            }
        });   
    });

});


function updateReview(button){
    let tableDataElement = $(button).parent()
    let columnName = $(tableDataElement).attr('class').split(' ').pop();
    let rowId = $(tableDataElement).attr('class').replace(/[^\d\.]/g, ''); //temp_review
    let newValue = $(button).prev().val();
    
    $.post('/update_temp_review', {

        '_token': $('meta[name=csrf-token]').attr('content'),
        column: columnName,
        reviewId: rowId,
        value: newValue 
    }
    );
    location.reload();
}

function setDormSectionPerUniSelection(){
    console.log('hi');
    let uniName =$('#uni_name_drpdwn').val(); //have the value of uni chosen
        $.get('/dormsForUni/' + uniName, function(data){    //gets dorm names.
            console.log(data);  
            $('#dorm_name_drpdwn').empty() //empties all the child nodes of select
            $(data).each(function (){
                $('#dorm_name_drpdwn').append($('<option />').val(this).text(this));
            });
            setDormIdFormElement(data[0]);//this sets the initial dorm id to first dorm of the uni
            //todo make the field set work properly such that if this value is "" then hide
       
            //set link for new dorm for the chosen uni
            let uniSelected = $('select#uni_name_drpdwn option:checked').val()
            $('#add_new_dorm').attr('href', '/'+uniSelected+'/add/new-uni-dorm-review');
        });

        $('#dorm_name_section').show()
       $('.fieldsets').show()
}


function setDormIdFormElement(dormName){
    $.get('/dormNameToId/' + dormName, function(data){
        $('#dorm_id').val(data);
    });
}

/**Creates Map and fills it with markers of the uni and its dorms 
 * uni and dorms are defined in the relevant blade.php script tags.
*/

function initMap(){
    
    map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(uni.lat, uni.lng),
          zoom: 12
    });
    createMarkers(dorms,map)
    
}
    
function createMarkers(dorms,map){       
    for(var i = 0; i < dorms.length; i++){
        addMarker(dorms[i],map);
    }
}

function addMarker(marker,map){
    var name = marker.dorm_name;
    var address = marker.address;
    
    var markerLatLng = new google.maps.LatLng(parseFloat(marker.lat),parseFloat(marker.lng));
    var html= '<b>' + name +'</b>' + '<p>' + address +"</p>"
    var mark = new google.maps.Marker({
            map: map,
            position: markerLatLng 
    });

    var infoWindow = new google.maps.InfoWindow;
        google.maps.event.addListener(mark, 'click', function(){
            infoWindow.setContent(html);
            infoWindow.open(map, mark);
        });
}


//This document refers to Dorms upon Uni selection i.e. dorms_for_uni.blade.php

var filteredDorms;
$(document).ready(function(){
    filteredDorms = dorms;
    if($('#dorms_for_uni').length){
        displayDorms(filteredDorms);
    }
    $('#amenity_filters').click(function(){
        var filters = $('input:checkbox:checked').map(function(){
            return $(this).attr('id');
        }).get(); 
    
        filteredDorms = dorms.filter(function(val) {
            for(var i = 0; i < filters.length; i++){
                if(val[filters[i]] != 1){
                return false;
                }
            }return true;
            
        }); 
        displayDorms(filteredDorms);
        sortDormsBy();
    });
    $('#sorting_options').click(function(){
        sortDormsBy();
    })

});

function sortDormsBy(){
    let selected = $('input[type=radio][name=sort_by]:checked').val()
    var dormsForSorting = filteredDorms
    if(selected === 'name'){
        dormsForSorting.sort(getSortOrder('dorm_name'))
        displayDorms(dormsForSorting.reverse());
    }
    if(selected === 'rating'){
        dormsForSorting.sort(getSortOrder('overall_rating'))
        displayDorms(dormsForSorting);

    }
    if(selected === 'reviews_count'){
        dormsForSorting.sort(getSortOrder('reviews_count'))
        displayDorms(dormsForSorting);
    }
}

function getSortOrder(prop) {    
    return function(a, b) {    
        if (a[prop] > b[prop]) {    
            return -1;    
        } else if (a[prop] < b[prop]) {    
            return 1;    
        }    
        return 0;    
    }    
}

function displayDorms(dormsArr){
    $('#dorms_div').empty();
    for(var dorm in dormsArr){
        $('#dorms_div').append('<a href="/'+ uni.uni_name+ '/dorms/' + dormsArr[dorm].dorm_name + '">' +dormsArr[dorm].dorm_name + '</a><br>')
    }
}

    
    

