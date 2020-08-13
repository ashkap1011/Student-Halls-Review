//const { toArray, create } = require("lodash");
//don't know why the above function exists
$(document).ready(function(){
    
    /*sets as defualt the dorm being self catered 
    and so it changes rating to communal kitchen and 
    selects communal kitchen check box as checked.
    */
    if($('#new_review_form').length){
        $('#catered_selfcatered_label').text('Communal Kitchen rating')
        $('.fieldsets #communal_kitchen').prop('checked', true);
        console.log('hi')
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

    
    

});


//gets the dorms of the uni that has been selected from the dropdown
function setDormSectionPerUniSelection(){
    let uniName =$('#uni_name_drpdwn').val(); //have the value of uni chosen
        $.get('/dormsForUni/' + uniName, function(data){    //gets dorm names.
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

//refers to homepage
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
        
    $('#search').on('keyup',function(){
        //sets search button's href
        var searchString = $('#search').val()
        $(this).attr('href', '/search/results/'+searchString)

        //dynamically retrieves all matching search results
        let value=$(this).val();
        $.ajax({
            type : 'get',
            url : '/search',
            data:{'search':value},
            success:function(data){
            $('.search_results').html(data);
            }
        });   
    });


    $('#search_button').click(function(){
        var searchString = $('#search').val()
        $(this).attr('href', '/search/results/'+searchString) 
        /*
        $.post('/search-results',{
            '_token': $('meta[name=csrf-token]').attr('content'),
            search: searchString
        });*/
    })



});





function setDormIdFormElement(dormName){
    $.get('/dormNameToId/' + dormName, function(data){
        $('#dorm_id').val(data);
    });
}


//Refers to the admin panel's CRUD operations
$(document).ready(function(){
    $('.editable_cell').dblclick(function() {
        let val = $(this).html();
        
        let elementId = $(this).attr('class').split(' ').pop();//gives you the second class name of element
        $(this).append('<input type = "text" name="updated_text" value="' + val + 
        '" /><input type="button" class="update_btn" onclick="updateReview(this)" value="Update"></td>');
      });
      
      $('.delete_btn').click(function(){
        if(window.confirm("DELETE, U SURE?")){
            let rowId = $(this).attr('id').replace(/[^\d\.]/g, '');
            $.post('/delete_temp_review',{
                '_token': $('meta[name=csrf-token]').attr('content'),
                reviewId: rowId
            });
            location.reload();
        }
      });
      
      //pushes reviews from temp_reviews to public reviews
    $('#push_btn').click(function(){
        
        let reviewsToPush = $('input:checkbox:checked').map(function(){
            return $(this).attr('id').replace(/[^\d\.]/g, '');
        }).get(); 
        let reviewType = $('#type_of_reviews').html();
            if(checkForEmptyFields(reviewsToPush,reviewType)){
                $.post('/migrate_temp_review',{
                    '_token': $('meta[name=csrf-token]').attr('content'),
                    reviewsToMigrate: reviewsToPush,
                    typeOfReviews: reviewType
                });
            }
    });

});

//update a review's field
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

function checkForEmptyFields(reviewsToPush,reviewType){
    var uniLocation = ['uni_address', 'uni_lat', 'uni_lng'];
    var dormLocation = ['dorm_address',	'dorm_lat',	'dorm_lng'];
    if(reviewType == 'new_uni_reviews'){
        for(var i =0; i<reviewsToPush.length;i++){
            for(var j=0;j< uniLocation.length;j++){
                var fieldData = $('#row_'+reviewsToPush[i]+'_col_'+uniLocation[j]).html();
                console.log(fieldData)
                if(fieldData==""){
                    window.alert('id:'+reviewsToPush[i] + " has  the following empty " +uniLocation[j])
                    return false;
                }
                var fieldData = $('#row_'+reviewsToPush[i]+'_col_'+dormLocation[j]).html();
                if(fieldData==""){
                    window.alert('id:'+reviewsToPush[i] + " has  the following empty " +dormLocation[j])
                    return false;
                }
            }
        }
    } 

    if(reviewType == 'new_dorm_reviews'){
        for(var i =0; i<reviewsToPush.length;i++){
            for(var j=0;j< dormLocation.length;j++){
                console.log(reviewsToPush[i])
                var fieldData = $('#row_'+reviewsToPush[i]+'_col_'+dormLocation[j]).html();
                if(fieldData == ""){
                    window.alert('id:'+reviewsToPush[i] + " has  the following empty " +dormLocation[j])
                    return false;
                }
            }
        }
    }
    return true;
}






//This document refers to Dorms upon Uni selection i.e. dorms_for_uni.blade.php

var filteredDorms;
$(document).ready(function(){
    if($('#dorms_for_uni').length){
        filteredDorms = dorms;
        displayDorms(filteredDorms);
    }
    $('#amenity_filters').click(function(){
        var filters = $('input:checkbox:checked').map(function(){
            return $(this).attr('id');
        }).get(); 
        
        
        filteredDorms = dorms.filter(function(val) {
            for(var i = 0; i < filters.length; i++){
                console.log(filters[i])
                let indexOfFilter = AMENITIES.indexOf(filters[i])
                console.log(indexOfFilter)
                if(val.has_amenities[indexOfFilter] == 0){
                    return false;
                } 
            }return true;
            
        });

        displayDorms(filteredDorms);
        sortDormsBy();
    });
    $('#sorting_options_dropdown').change(function(){
        sortDormsBy();
    })

});

function sortDormsBy(){
    let selected = $('select#sorting_options_dropdown option:checked').val()
    var dormsForSorting = filteredDorms
    console.log(selected)
    if(selected === 'name'){
        console.log(dormsForSorting)
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
    $('#dorms').empty();
    console.log(dormsArr)
    for(var i =0; i<dormsArr.length;i++){
        $('#dorms').append('<div class="row" id="row_'+i+'"></div>')
        let row = $('#row_'+i)
        createDormCard(row,dormsArr[i++])
        if(i<dormsArr.length){
        createDormCard(row,dormsArr[i])
        }
    }
    /*
    for(var dorm in dormsArr){
        $('#dorms_div').append(
            '<a href="/'+ uni.uni_name+ '/dorms/' + dormsArr[dorm].dorm_name + '">' +dormsArr[dorm].dorm_name + '</a><br>')
    }*/
}

function createDormCard(rowDiv, dorm){
    console.log(dorm);
    rowDiv.append(
        '<div class="col-12 col-xl-6 h-100 mb-3 stretched-link dorm_card" id="dorm_'+dorm.dorm_id+'" style="cursor: pointer;">'+
            '<div class="card bg-light">'+
             ' <div class="card-body">'+
                '<img class="card-img dorm_icon" src="/storage/icons/dormIcon.jpg" alt="Card image">'+
                '<div class="card_right_panel float-left">'+
                  '<h3 class="card-title">'+dorm.dorm_name+'</h3>'+
                   ' <div class="star_rating">'+ 
                 '     <p class="overall_rating_decimal pl-2">'+dorm.overall_rating+'</p>'+
                      getStarRatingAsStringElement(dorm.overall_rating)+
                '    </div><br>'+
               '   <span class="number_of_reviews">'+numOfReviews(dorm.reviews_count)+'</span> <br>'+
                '  <span>15 mins walk</span>'+
                 ' <i class="fas fa-running"></i>'+
                '</div>   </div>   </div>     </div>')
    $('#dorm_'+dorm.dorm_id).on("click", function(){
        location.href="/"+uni.uni_name+ '/dorms/' + dorm.dorm_name
    });
}

function getStarRatingAsStringElement(starRating){
    var elementString="";
    for(var i =1; i<=starRating; i++){
        elementString+='<i class="fas fa-star star-icon"></i>';
    }
    let ratingIntegerPart = Math.floor(starRating);
    var ratingDecimalPart = starRating-ratingIntegerPart;
    if(ratingDecimalPart>= 0.5){
        elementString+='<i class="fas fa-star-half-alt star-icon"></i>';
        ratingIntegerPart++;
    }
        var elementString = addEmptyStars(ratingIntegerPart,elementString)
    return elementString
}   

function addEmptyStars(ratingIntegerPart,elementString){
    for(var i = ratingIntegerPart; i<5; i++){
        elementString += '<i class="far fa-star star-icon"></i>'
    }
    return elementString
}

function numOfReviews(reviewsCount){
    var reviewString = reviewsCount;
    reviewString += reviewsCount==1 ? ' review': ' reviews'
    return reviewString;
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

//Document for Reviews of a dorm
$(document).ready(function(){
    if($('#reviews_for_dorms').length){
        $('.star_ratings').each(function(index,element){
            $(element).append(getStarRatingAsStringElement(dorm.overall_star_ratings[index]));
        });

        var dormOverallRating = $('#dorm_overall_rating_value').html()
        $('.dorm_overall_rating').append(getStarRatingAsStringElement(dormOverallRating));
        
        var reviewOverallRating = $('.review_overall_rating_container').each(function(index,element){
            $(element).append(getStarRatingAsStringElement(jQuery('b',this).html()));
        })

        var picCounter=1;
        if(screen.width > 900){
            $('.review_row').each(function(index,element){
                if(picCounter == 8){   //7 refers to the last pic i.e. pic7.svg
                    picCounter =1;
                }
                var illustrationAsStringElement= '<div class="col-3 review_row_illustration_container"> <img class="review_row_illustration" src="/storage/review_illustrations/pic'+picCounter+'.svg" alt="illustration of a typical student"></div>'
                console.log(index)
                if(index % 2 == 0){
                    //left side
                    $(element).prepend(illustrationAsStringElement)
                } else{ //right side
                    $(this).append(illustrationAsStringElement)
                }
                picCounter++;
            })
        }



        //looks at cookies and makes clapped reviews clapped for the client
        if(reviewClaps != null){
           reviewIdOfClaps = JSON.parse(reviewClaps);
            console.log(reviewIdOfClaps)
            reviewIdOfClaps.forEach(element => {
                $('#review_id_'+element).addClass('clapped');
                $('#review_id_'+element).css('background-color', 'green');
            });
        }

        //update cookies for reviews applauded 
        $('.clap_icons').each(function(index,element){
            $(element).on('click',function(){
                var idOfReview = $(element).attr('id').split('_').pop();
                if($(element).attr('class') !== 'clap_icons clapped'){  //if it's already clapped
                    $(element).css('background-color', 'green')
                    $(element).addClass('clapped');
                    $.post('/cookie/set/new/review_id', {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        reviewId: idOfReview
                    });
                    //post request to increase review's count

                } else{
                    $(element).css('background-color', 'transparent')
                    $(element).toggleClass('clapped');
                    $.post('/cookie/set/delete/review_id', {
                        '_token': $('meta[name=csrf-token]').attr('content'),
                        reviewId: idOfReview
                    });
                    //post request to reduce review's count
                }
            });
        })
    
    }


    //make stars




});









