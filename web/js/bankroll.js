var itemToRemove;

function verifieData(data){

    if(data.localeCompare('false') == 0){
        window.location = "index.php";
        return false;
    }
    else
        return true;
}

$(function () {
    updateBankroll();
    $("#messageSuccessCreation").hide();
    $("#messageSuccessCashout").hide();
    $("#messageSuccessAddMoney").hide();

    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });

        updateBankroll();

        }, false);
    $('.owl-carousel').owlCarousel({
        items:1,
        margin:15,
        autoHeight:true,

    });

    $('#addMoneyBankroll').submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        $("#messageSuccessAddMoney").hide();
        var nomBankrollInput = document.getElementById("nomBankroll-AddMoney");
        var montantInput = document.getElementById("montant-AddMoney");
        var result;
        $.post(
            "php/Bankroll/augmenterBankroll.php",
            $("#addMoneyBankroll").serialize(),
            function (data) {
                if(verifieData(data)){
                    result = data;
                    var validName = parseInt((result % 10000)/1000);
                    var isANumber = parseInt((result % 1000)/100);
                    var isPositive = parseInt((result % 100)/10);
                    var isCreated = parseInt(result % 10);
                    if(isCreated == 1){
                        $("#messageSuccessAddMoney").show();
                        nomBankrollInput.setCustomValidity('');
                        montantInput.setCustomValidity('');
                        updateBankroll();
                    }
                    else{
                        if(validName == 0){
                            $("#messageNomBankrollAddMoney").text("Le nom doit être renseigné et sa longueur supérieur à 3");
                            nomBankrollInput.setCustomValidity("no");
                        }
                        if(isANumber == 1 && isPositive == 1){
                            if(validName == 1 ){
                                $("#validationMontantAddMoney").text("Montant supérieur au solde");
                                montantInput.setCustomValidity("no");
                            }

                        }
                        else if(!isANumber){
                            $("#validationMontantAddMoney").text("Ce champ doit contenir un nombre");
                            montantInput.setCustomValidity("no");
                        }
                        else if(!isPositive){
                            $("#validationMontantAddMoney").text("Montant négatif !");
                            montantInput.setCustomValidity("no");
                        }

                    }
                }
                $('.owl-carousel').trigger('refresh.owl.carousel');
            }
        );
    })


   $('#cash-outBankroll').submit(function (event) {
       $("#messageSuccessCashout").hide();
       event.preventDefault();
       event.stopPropagation();
       var nomBankrollInput = document.getElementById("nomBankrollCash-Out");
       var montantInput = document.getElementById("montantCash-Out");
       var result ;

       $.post(
           "php/Bankroll/reduireBankroll.php",
           $("#cash-outBankroll").serialize(),
           function(data){
               if(verifieData(data)){
                   result = data;
                   var validName = parseInt((result % 10000)/1000);
                   var isANumber = parseInt((result % 1000)/100);
                   var isPositive = parseInt((result % 100)/10);
                   var isCreated = parseInt(result % 10);
                   if(isCreated == 1){
                       $("#messageSuccessCashout").show();
                       nomBankrollInput.setCustomValidity('');
                       montantInput.setCustomValidity('');
                       updateBankroll();
                   }
                   else{
                       if(validName == 0){
                           $("#messageNomBankrollCash-Out").text("Le nom doit être renseigné et sa longueur supérieur à 3");
                           nomBankrollInput.setCustomValidity("no");
                       }
                       if(isANumber == 1 && isPositive == 1){
                           if(validName == 1 ){
                               $("#ValidationMontantCash-Out").text("Montant supérieur au solde");
                               montantInput.setCustomValidity("no");
                           }

                       }
                       else if(!isANumber){
                           alert(isANumber);
                           $("#ValidationMontantCash-Out").text("Ce champ doit contenir un nombre");
                           montantInput.setCustomValidity("no");
                       }
                       else if(!isPositive){
                           $("#ValidationMontantCash-Out").text("Montant négatif !");
                           montantInput.setCustomValidity("no");
                       }
                   }
               }
            $('.owl-carousel').trigger('refresh.owl.carousel');

           }
       );

   });

//Optimisation requise

    $('#createBankroll').submit(function (event) {
        var nomBankrollInput = document.getElementById("nomBankroll");
        var montantInput = document.getElementById("solde_depart");
        event.preventDefault();
        event.stopPropagation();
        $("#messageSuccessCreation").hide();
        var result;
        $.post(
            "php/Bankroll/addBankroll.php",
            $("#createBankroll").serialize(),
            function(data){
                if(verifieData(data)){
                    result = data;
                    var validName = parseInt((result % 10000)/1000);
                    var isANumber = parseInt((result % 1000)/100);
                    var isPositive = parseInt((result % 100)/10);
                    var isCreated = parseInt(result % 10);
                    if(isCreated == 1){
                        $("#messageSuccessCreation").show();
                        nomBankrollInput.setCustomValidity('');
                        montantInput.setCustomValidity('');
                        updateBankroll();

                    }
                    else{
                        if(validName == 0){
                            $("#messageNomBankroll").text("Le nom doit être renseigné et sa longueur supérieur à 3");
                            nomBankrollInput.setCustomValidity("no");
                        }
                        if(isANumber == 1 && isPositive == 1){
                            if(validName == 1 ){
                                $("#messageNomBankroll").text("Nom déjà utilisé,Choisissez un autre");
                                nomBankrollInput.setCustomValidity("no");
                            }
                            montantInput.setCustomValidity('');
                        }
                        else if(!isANumber){
                            $("#validationMontant").text("Ce champ doit contenir un nombre");
                            montantInput.setCustomValidity("no");
                        }
                        else if(!isPositive){
                            $("#validationMontant").text("Montant négatif !");
                            montantInput.setCustomValidity("no");
                        }
                    }
                }
                $('.owl-carousel').trigger('refresh.owl.carousel');

            }
        );

    });

    $(document).on("click",".delete-btn",function () {
        itemToRemove = $(this).attr("id");
    });


});

function supprimerBankroll(){
    $.post(
        "php/Bankroll/deleteBankroll.php",
        {id: itemToRemove},
        function (data) {
            updateBankroll();
            if(verifieData(data) && !data)
                alert("Cette bankroll n'a pas été supprimée");
        }
    );
}

function updateBankroll(){
    $.get(
        "php/Bankroll/getBankrolls.php",
        function(data){
            if(verifieData(data)){
                $("#bankroll-table").hide();
                $("#bankroll-table").html(data);
                $("#bankroll-table").show();
            }
        }
    );
}