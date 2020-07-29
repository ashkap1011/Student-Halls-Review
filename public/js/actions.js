$(document).ready(function(){
    
    /*sets as deafualt the dorm being self catered 
    and so it changes rating to communal kitchen and 
    selects communal kitchen check box as checked.
    */

    $('#catered_selfcatered_label').text('Communal Kitchen rating')
    $('#communal_kitchen').prop('checked', true);

    if($('#dorm_id').html() == null){
        $('.fieldsets').show();
    }

    //takes care of the case where the use goes back from Add a Dorm hyperlink
    if($('select#uni_name_drpdwn option:checked').val() !== ''){
        setDormSectionPerUniSelection();
    }
    
    //populates dorms for chosen uni in drop down
    $('#uni_name_drpdwn').change(function(){
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
    let uniName =$('#uni_name_drpdwn').val(); //have the value of uni chosen
        $.get('/dormsForUni/' + uniName, function(data){
            
            $('#dorm_name_drpdwn').empty() //empties all the child nodes of select
            $(data).each(function (){
                $('#dorm_name_drpdwn').append($('<option />').val(this).text(this));
            });
            setDormIdFormElement(data[0]);
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
    




//document.getElementById("uni_name").addEventListener("click", onUniNameSelection);

  

    
    

