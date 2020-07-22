function test(){
    alert("hi");
}
/*
$(document).ready(function(){
    $("#button").click(function(){
        alert("Data: ")
        $(".fieldsets").show()
      });
});
*/


$(document).ready(function(){
    $("#uni_name_drpdwn").change(function(){
        var uniName =$(this).val(); //have the value of uni chosen
        $.get("/dormsForUni/" + uniName, function(data){
            
            $("#dorm_name_drpdwn").empty() //mpties all the child nodes of select
            $(data).each(function (){
                $("#dorm_name_drpdwn").append($("<option />").val(this).text(this));
            });
            setDormIdFormElement(data[0]);
            //todo make the field set work properly such that if this value is "" then hide
       });
        $(".fieldsets").show()
      });

    $("#dorm_name_drpdwn").change(function(){
        var dormName =$(this).val(); //have the value of uni chosen
        setDormIdFormElement(dormName);
    });

    

});

function setDormIdFormElement(dormName){
    $.get("/dormNameToId/" + dormName, function(data){
        $("#dorm_id").val(data);
    });
}





//document.getElementById("uni_name").addEventListener("click", onUniNameSelection);

  

    
    

