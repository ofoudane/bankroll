
$(function () {
	$("#registerMessage").hide();
	$(".hiddenBeforeSend").hide();
    $('.owl-carousel').owlCarousel({
        items:1,
        margin:10,
        autoHeight:true
    });
    $("#registerForm").submit(function(e){
    	e.preventDefault();
    	$.post(
    		"php/User/register.php",
    		$(this).serialize(),
    		function(data){
    		     $("#registerMessage").text(data);
    		     $("#registerMessage").show();
                $(".owl-carousel").trigger('refresh.owl.carousel');
            });
    });
    $("#loginForm").submit(function(e){
    	e.preventDefault();
    	$.post(
    		"php/User/login.php",
    		$(this).serialize(),
    		function(data){

    			if(data == 0){
    				window.location = "pagePerso.php";
    			}
    			else{
    				$("#loginMessage").html(data);
    				$(".owl-carousel").trigger('refresh.owl.carousel');
    			}
    	}
    	);
    }
    );
    $("#envoyerMessage #envoyer").click(function(){
    	var mail = $("#mail").val();
    	$.post(
    		"php/User/forgotPassword.php",
    		{addresse:mail},
    		function(data){
    			$(".hiddenBeforeSend").show(100);
    			$("#envoyerMessage #envoyer").hide();
    			$("#envoyerMessage #valider").show();
    		});
    });
    $("#envoyerMessage #valider").click(function(){
    	var mail = $("#mail").val();
    	var key = $("#recoverKey").val();
    	$.post(
    		"php/User/ResetPassword.php",
			{mail:mail,key:key},
			function(data){
    			
			}
		);
    	
    })

});