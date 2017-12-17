$(window).scroll(function() {
    console.log($(this).scrollTop());
    if ($(this).scrollTop() > 125){

        $('#navroot').addClass("sticky");
        $('#logo').addClass("sticky_logo_fix");
    }
    else{
        console.log("removeClass");
        $('#logo').removeClass("sticky_logo_fix");
        $('#navroot').removeClass("sticky");
    }

    if($('#nav2a2').css('display') != "none")
    {
        console.log($(this).scrollTop());
        $('#nav2a2').css({'display':"none"});
    }
});

function hideCategories()
{
    if($('#nav2a2').css('display') == "none")
    {
        $('#nav2a2').css({'display':"inherit"});
    }
    else{
        $('#nav2a2').css({'display':"none"});
    }
}

$(window).load(function() {
    $('#slider').nivoSlider();
    hideCategories();
});

$(".menu_category_item").mouseenter(function(){
    var $index = $( ".menu_category_item" ).index(this);
    $('.ui_nav2_sub:eq('+$index+')').addClass("activate");
}).mouseleave(function(){
    var $index = $( ".menu_category_item" ).index(this);
    $('.ui_nav2_sub:eq('+$index+')').removeClass("activate");
});