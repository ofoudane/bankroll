$(function () {
    $('.owl-carousel').owlCarousel({
        items:1,
        margin:10,
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






   var config = {
       type:'line',
       data: {
           labels: ["1","2","3","4","5","6","7","8","9","10","11","12"],
           datasets: [{
               backgroundColor: 'rgba(255,99,132,0.4)',
               borderColor: 'rgb(244,42,80)',
               data: [
                   400,
                   140,
                   500,
                   48,
                   -500,
                   -80,
                   -910,
                   750,
                   98,
                   4000,
                   1500,
                   420
               ],
               label: 'Gain',
               fill: 'origin'
           }]
       },
       options: {
           maintainAspectRatio: false,
           spanGaps:false,
           elements: {
               line: {
                   tension: 0.08
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
               text:"Comparaison Mensuelle",
               display:true
           }

       }
   };


    ctx = document.getElementById("dailyStats");
    ctx.width = 1200;

    new Chart(ctx,config);
    ctx = document.getElementById("monthlyStats");
    ctx.width = 1200;
    new Chart(ctx,config);
    ctx = document.getElementById("yearlyStats");
    ctx.width = 1200;
    new Chart(ctx,config);


});


