
/*
$(document).ready(function(){
    $("#button").click(function(){
        alert("Data: ")
        $(".fieldsets").show()
      });
});
*/




$(document).ready(function(){
    
    $("#catered_selfcatered_label").text("Communal Kitchen rating")
    $('#communal_kitchen').prop('checked', true);


    //populates dorms for chosen uni in drop down
    $("#uni_name_drpdwn").change(function(){
        var uniName =$(this).val(); //have the value of uni chosen
        $.get("/dormsForUni/" + uniName, function(data){
            
            $("#dorm_name_drpdwn").empty() //empties all the child nodes of select
            $(data).each(function (){
                $("#dorm_name_drpdwn").append($("<option />").val(this).text(this));
            });
            setDormIdFormElement(data[0]);
            //todo make the field set work properly such that if this value is "" then hide
       
            //set link for new dorm for the chosen uni
            var uniSelected = $("select#uni_name_drpdwn option:checked").val()
            $('#add_new_dorm').attr('href', '/'+uniSelected+'/add_dorm');
       
        });

       
       $(".fieldsets").show()
      });

    //sets dorm_id based on drop down  
    $("#dorm_name_drpdwn").change(function(){
        var dormName =$(this).val(); //have the value of uni chosen
        setDormIdFormElement(dormName);
    });

    /*checks to see the correct catering related amenity is selected based
    on user selection, also changes the text for the catering/self catered 
    rating
    */
    $("input[type=radio][name=is_catered]").change(function(){
        if ($("input[type=radio][name=is_catered]:checked").val() === "0"){
            $("#catered_selfcatered_label").text("Food Quality rating");
            $('#communal_kitchen').prop('checked', false);
            $('#catering').prop('checked', true);

        } else{
            $("#catered_selfcatered_label").text("Communal Kitchen rating");
            $('#communal_kitchen').prop('checked', true);
            $('#catering').prop('checked', false);
            
        }
    });

    
    

});


function setDormIdFormElement(dormName){
    $.get("/dormNameToId/" + dormName, function(data){
        $("#dorm_id").val(data);
    });
}





//document.getElementById("uni_name").addEventListener("click", onUniNameSelection);

  

    
    

