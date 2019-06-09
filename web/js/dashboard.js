var chartCircle,chartDonut,chartDays,chartYears,chartMonths;
var chartDoghnutConfig,chartCircleConfig,chartDayConfig,chartMonthConfig,chartYearConfig;
var coteMatch = new Array();
var etatMatch = new Array();
var parisASupprimer ;
function verifieData(data){

    if(data.localeCompare('false') == 0){
        window.location = "index.php";
        return false;
    }
    else
        return true;
}

$(function () {
    $("#messageDirectParisInsert").hide();
    $("#messageAjoutMatch").hide();
   'use strict';

    $('.owl-Normal-carousel').owlCarousel({
        items:1,
        margin:10,
        autoHeight:false
    });
    $('#ajouterParis').owlCarousel({
        items:1,
        margin:15,
        autoHeight:true
    });
    $(document).scroll(function () {
        if($(document).scrollTop() > 60 ) {
            if(!($(".internalMenu").hasClass("fixed-top")))
                $(".internalMenu").addClass("fixed-top");
        }
        else{
            if($(".internalMenu").hasClass("fixed-top"))
                $(".internalMenu").removeClass("fixed-top");
        }
    });


    initialiseCharts();
    //Mise à jour de la liste des bankrolls
    updateBankrolls();
    $(".availableBankroll").change(function () {
        if($(this).val().length == 0)
            window.location = "myBankroll.php";
        else
            updateAll($(this).val());
    });

    $("#directParisForm").submit(function (event) {
        event.preventDefault();
        event.stopPropagation();
        $("#messageDirectParisInsert").hide();
        var toSend = $(this).serialize()+'&nomBank='+$("#nomBank").val();
        $.post(
            "php/Paris/directBetAdd.php",
            toSend,
            function(data){
                if(verifieData(data)){
                    if(data == 0){
                        $("#messageDirectParisInsert").html("<span class='text-warning ' >attention, la mise ne peut pas être supérieur au solde du bankroll</span>");
                    }
                    else{
                        $("#messageDirectParisInsert").html("<span class='text-success ' >Paris enregistré</span>");
                        updateAll($("#nomBank").val());
                    }
                    $("#messageDirectParisInsert").show();
                    
                    $("#ajouterParis").trigger('refresh.owl.carousel');
                }
            }
        );
    });

    $("#ajouterMatch").click(function () {
        $("#messageAjoutMatch").hide();
        var cote = $("#coteMatch").val();
        var message = "<span class=' text-danger'>";
        if(isNaN(cote) || cote < 1 ){
            message += "Attention : Match non enregistré,cote invalide!";
        }
        else{
            var etat = $("#etatMatch").val();
            if(etat < 0 || etat > 2 )
                message += "Attention : Match non enregistré, etat invalide";
            else{
                message = "<span class=' text-success'>";
                var id = coteMatch.length - 1;
                coteMatch.push(cote);
                etatMatch.push(etat);
                var classMatch;
                if(etat == 1 ){
                    classMatch = 'table-success';
                    etat = "gagné";
                }
                else if(etat == 2){
                    classMatch = 'table-info';
                    etat = "remboursé";
                }
                else{
                    classMatch = 'table-danger';
                    etat = "perdu";
                }
                $("#listeMatchAjoute").append("<tr class='"+classMatch+"'>" +
                    "<td>"+cote+"</td>"+
                    "<td>"+etat+"</td>"+
                    "<td><button id='"+id+"' type=\"button\" class=\"btn btn-outline-danger border-0\" data-toggle=\"modal\" data-target=\"#deleteMatch\"><i class=\"far fa-trash-alt\"></i></button></td>"+
                    "</tr>");
                message += "Success : Match ajouté";
            }
        }
        message += "</span>";
        $("#messageAjoutMatch").html(message);
        $("#messageAjoutMatch").show();
        $("#ajouterParis").trigger('refresh.owl.carousel');
    });
    
    $("#ajouterParisParMatch").submit(function () {
        var nomParis = $("#nomParis").val();
        var nomBankroll = $("#nomBankr").val();
        var mise = $("#miseTotal").val();
        var type = $("#typeParis").val();
        $.post(
            "php/Paris/ajouterParisParMatch.php",
            {cotes:coteMatch,etats:etatMatch,nom:nomParis,bank:nomBankroll,mise:mise,type:type},
            function (data) {
                alert("fonctionnalité pas encore ajoutée");
            }

        );
    });

    $(document).on("click",".deleteParis",function(){
    	parisASupprimer =  $(this).attr("id");
    });
    $("#validationSuppression").click(function(){
    	$.post(
    		"php/Paris/deleteParis.php",
    		{id:parisASupprimer},
    		function(data){
    			if(verifieData(data)){
    				if(data == 0)
    					alert("Attention, ce paris n'a pas été supprimer !")
    			     else
                        updateBankrolls();
                }

    		});
    	});
    

});

function updateBankrolls(){
    $.get(
        "php/Bankroll/getBankroll.php",
        function (data) {
            if(verifieData(data))
                $(".availableBankroll").html(data);
            updateAll($(".availableBankroll").val());
        }
    );
}

function updateBankroll(bankrollName){
    $.post(
        "php/Bankroll/infoBankroll.php",
        {nom:bankrollName},
        function (data) {
            if(verifieData(data)){
                var answer = data.split(",");
                if(answer[0] == '')
                    answer[0] = '0';
                if(answer[1] == '')
                    answer[1] = '0';
                if(answer[2] == '')
                    answer[2] = '0';

                $("#nombreDeParis").text(answer[0]);
                $("#soldeEnBankroll").text(answer[1]);
                $("#beneficeBankroll").text(answer[2]);
            }
        }
    );
    $(".input-bankrollName").val(bankrollName);
}

function updateStats(bankrollName){
    $.post(
        "php/Bankroll/bankrollGlobalStats.php",
        {nom:bankrollName},
        function(data){
            if(verifieData(data)){
                var fullData = data.split(';');
                var byNumber = fullData[0].split(',');
                var byValue = fullData[1].split(',');

                updateChartByValue(byValue);
                updateChartByNumber(byNumber);
            }
        }
    );
    $.post(
        "php/Bankroll/bankrollStatsByDate.php",
        {nom:bankrollName},
        function (data) {
            if(verifieData(data)){
                var result = data.split(';');
                var days = result[0].split(',');
                var months = result[1].split(',');
                var years = result[2].split(',');

                var daysNames = days[0].split('|');
                var monthsNames = months[0].split('|');
                var yearsNames = years[0].split('|');
                var daysValues = days[1].split('|') ;
                var monthsValues = months[1].split('|');
                var yearsValues = years[1].split('|');

                daysNames.pop();
                monthsNames.pop();
                yearsNames.pop();
                daysValues.pop();
                monthsValues.pop();
                yearsValues.pop();

                updateLineChart(daysNames,daysValues,chartDays,chartDayConfig);
                updateLineChart(monthsNames,monthsValues,chartMonths,chartMonthConfig);
                updateLineChart(yearsNames,yearsValues,chartYears,chartYearConfig);
            }
        }
    );

}

function updateAll(bankrollName){
    updateBankroll(bankrollName);
    updateStats(bankrollName);
    updateParis(bankrollName);
}

function updateParis(nomBankroll){
    updatePerdant(nomBankroll);
    updateGagnant(nomBankroll);
    updateRembourse(nomBankroll);
}

function updatePerdant(nomBankroll){
    $.post(
        "php/Paris/updateParisPerdant.php",
        {nom:nomBankroll},
        function (data) {
            if(verifieData(data))
                $("#LoseTable").html(data);
        }
    );
}

function updateGagnant(nomBankroll){
    $.post(
        "php/Paris/updateParisGagnant.php",
        {nom:nomBankroll},
        function (data) {
            if(verifieData(data))
                $("#WinTable").html(data);
        }
    );
}

function updateRembourse(nomBankroll){
    $.post(
        "php/Paris/updateParisRembourse.php",
        {nom:nomBankroll},
        function (data) {
            if(verifieData(data))
                $("#DrawTable").html(data);
        }
    );
}


function turnLastToZero(arrayOfVal){
    var allZero = true;
    for(var i = 0; i < arrayOfVal.length;i++){
        if(arrayOfVal[i] != 0 ){
            allZero = false;
            break;
        }
    }
    if(allZero)
        arrayOfVal[arrayOfVal.length - 1] = 1;
}


function initialiseCharts(){
    initialiseConfigs();
    var ctx;
    ctx = document.getElementById("Graph-Par-Nombre-Paris");
    ctx.width = 500;
    chartDonut = new Chart(ctx, chartDoghnutConfig);

    ctx = document.getElementById("Graph-Par-Montant");
    ctx.width = 500;
    chartCircle = new Chart(ctx,chartCircleConfig);

    ctx = document.getElementById("dailyStats");
    ctx.width = 900;
    chartDays = new Chart(ctx,chartDayConfig);

    ctx = document.getElementById("monthlyStats");
    ctx.width = 900;
    chartMonths = new Chart(ctx,chartMonthConfig);

    ctx = document.getElementById("yearlyStats");
    ctx.width = 900;
    chartYears = new Chart(ctx,chartYearConfig);


}

function initialiseConfigs(){
    chartDoghnutConfig= {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [0,0,0],
                backgroundColor: [
                    'rgb(209, 27, 27)',
                    'rgb(66, 244, 107)',
                    'rgb(83, 152, 198)'
                ],
                label: 'Par Nombre De Matchs'
            }],
            labels : [
                "Perdu",
                "Gagné",
                "Remboursé"
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive:true,
            legend: {
                position:'top',
            },
            title : {
                display: true,
                text: 'Statistiques par nombre de paris'
            },
            animation : {
                animateRotate:true,
                easing:'linear',
                duration:400
            }
        }
    };

    chartCircleConfig = {
        type: 'pie',
        data: {
            datasets: [{
                data: [0,0,0],
                backgroundColor: [
                    'rgb(209, 27, 27)',
                    'rgb(66, 244, 107)',
                    'rgb(83, 152, 198)'
                ],
                label: ''
            }],
            labels: [
                "Perdu",
                "Gagné",
                "Remboursé"
            ]
        },
        options: {
            reponsive:false,
            legend: {
                position:'top',
            },
            title : {
                display: true,
                text: 'Statistiques par montant (en euro)'
            },
            maintainAspectRatio: false,
            animation: {
                easing:'linear',
                duration:500
            }
        }
    };

    chartDayConfig = {
        type:'line',
        data: {
            labels: [],
            datasets: [{
                backgroundColor: 'rgba(255,99,132,0.4)',
                borderColor: 'rgb(244,42,80)',
                data: [],
                label: 'Gain',
                fill: 'origin'
            }]
        },
        options: {
            maintainAspectRatio: false,
            elements: {
                line: {
                    tension: 0.4
                }
            },
            plugins: {
                filler: {
                    propagate:false
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip:true,
                        maxRotation: 0
                    }
                }]
            },
            title: {
                text:"Comparaison quotidienne",
                display:true
            }

        }
    };

    chartMonthConfig = {
        type:'line',
        data: {
            labels: [],
            datasets: [{
                backgroundColor: 'rgba(255,99,132,0.4)',
                borderColor: 'rgb(244,42,80)',
                data: [],
                label: 'Gain',
                fill: 'origin'
            }]
        },
        options: {
            maintainAspectRatio: false,
            elements: {
                line: {
                    tension: 0.4
                }
            },
            plugins: {
                filler: {
                    propagate:false
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip:true,
                        maxRotation: 0
                    }
                }]
            },
            title: {
                text:"Comparaison mensuelle",
                display:true
            }

        }
    };

    chartYearConfig = {
        type:'line',
        data: {
            labels: [],
            datasets: [{
                backgroundColor: 'rgba(255,99,132,0.4)',
                borderColor: 'rgb(244,42,80)',
                data: [],
                label: 'Gain',
                fill: 'origin'
            }]
        },
        options: {
            maintainAspectRatio: false,
            elements: {
                line: {
                    tension: 0.4
                }
            },
            plugins: {
                filler: {
                    propagate:false
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        autoSkip:true,
                        maxRotation: 0
                    }
                }]
            },
            title: {
                text:"Comparaison annuel",
                display:true
            }

        }
    };
}

function updateChartByNumber(numbers){
    turnLastToZero(numbers);
    chartDoghnutConfig.data.datasets[0].data = numbers;
    chartDonut.update();

}

function updateChartByValue(valeurs){
    turnLastToZero(valeurs);
    chartCircleConfig.data.datasets[0].data = valeurs;
    chartCircle.update();
}

function updateLineChart(names,values,chart,configs){
    configs.data.labels = names;
    configs.data.datasets[0].data = values;
    chart.update();
}
