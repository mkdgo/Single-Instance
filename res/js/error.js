$(document).bind("mobileinit", function() {
    $.mobile.ajaxEnabled = false;
    $.autoInitializePage = true;
});

$(document).ready(function() {
});

$(window).load(function(){
        bg_fix()
})
$(window).resize(function(){
        bg_fix()
})

function bg_fix(){
    // .ui-header>.ui-btn-right
    var bhHeight = $('.blue_gradient_bg').height() - parseInt($('.blue_gradient_bg').css('margin-top')) - $('footer').height() - parseInt($('footer').css('border-top-width'));
    if(bhHeight<$(window).height())
        $('.blue_gradient_bg').css('min-height',parseInt($(window).height() - $('footer').height() - parseInt($('footer').css('border-top-width')) - parseInt($('.blue_gradient_bg').css('margin-top')) )+'px');

    if($('.red_gradient_bg').height()<$(window).height())
        $('.red_gradient_bg').css('min-height',parseInt($(window).height()-42 - $('.footer_menu').height())+'px')
    if($('.rred_gradient_bg').height()<$(window).height())
        $('.rred_gradient_bg').css('min-height',parseInt($(window).height())+'px')

    $('.ui-header>.ui-btn-right').css('left',parseInt($('.ui-header').width()/2 - $('.ui-header>.ui-btn-right').width()/2)+'px')

    if($(window).width()>768)
        $('.left_menu_pic').css('height',$('.pic_e5').height()+'px');
    else
        $('.left_menu_pic').css('height','auto');
}
