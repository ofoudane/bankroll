
$(".hidden-before-send").hide();
$(".hidden-before-validate").hide();

$(function(){
   $("#sendPass").click(function () {
       var pass = $("#motDePasse").val();

       var confirmation = $("#confirmation").val();

       if(pass.length < 8){
           if(!$("#motDePasse").hasClass("is-invalid"))
            $("#motDePasse").addClass("is-invalid");

       }
       else if(pass.localeCompare(confirmation) != 0 ){
           if(!$("#confirmation").hasClass("is-invalid"))
                $("#confirmation").addClass("is-invalid");
       }
       else{
           $.get(
               "php/User/sendKey.php",
                function(data){
                  if(data){
                    $(".hidden-before-send").show();
                    $("#sendPass").hide();
                  }
                }
           );
       }
   });


   $("#motDePasse").keyup(function () {
       if($("#motDePasse").hasClass("is-invalid"))
        $("#motDePasse").removeClass("is-invalid");
   });
   $("#confirmation").keyup(function () {
       if($("#confirmation").hasClass("is-invalid"))
            $("#confirmation").removeClass("is-invalid");
   });
   $("#validatePass").click(
      function () {
           $(".changeFail").hide();
           $(".changeSuccess").hide();
           var pass = $("#motDePasse").val();
           var key = $("#cleRecup").val();
           $.post(
               "php/User/changePass.php",
               {newPass:pass,key:key},
               function(data){
                if(data){
                  $(".changeSuccess").show();
                }
                else
                  $(".changeFail").show();
               }
           );
       }
   );
});