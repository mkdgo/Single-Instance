function publishModal() {

    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active')) {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to unpublish the Module');
    } else {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Module');
    }
    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $.post('/d4_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
            //console.log(r);
        sid = $('input[name=subject_id]').val();
        mid = $('input[name=module_id]').val();
        if( mid == '0' ) {
            mid = r.publish;
            document.location="/d4_teacher/index/"+sid+'/'+r.module_id;
        }
        $('#popupPubl').modal('hide');
        $('#publish').val(r.publish);
        if( r.publish==1 ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }

        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r.publish==1) {
            showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    }, "json");
}

$( document ).bind( "mobileinit", function() {
    $.mobile.ignoreContentEnabled = true;
});

//$(function()
$( document ).bind( "pageinit", function() {

});
                        
