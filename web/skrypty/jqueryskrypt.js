
$(document).ready(function  () {
    $(".przycisk").click(function  () {
        var img= $("img");
        img.animate({ height: '10px', opacity: '0.9' }, "slow");
        img.animate({ width: '300px', opacity: '0.8' }, "slow");
        img.animate({ height: '50px', opacity: '0.4' }, "slow");
        img.animate({ width: '600px',height:'300px',opacity: '1.0' }, "slow");
       
    });
});

$(function () {
    $("#nawigacja").draggable();
});

$(function() {
    $( "#tabs" ).tabs();
});
