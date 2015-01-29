function publishModal() {

$('#message').modal('hide');
          if($('.publish_btn').hasClass('active'))
{
    $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to unpublish the Lesson Plan');
}
else
    {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Lesson Plan');
    }

$( $('#popupPubl').find('h4')[0] ).text('');
$('#popupPubl').modal('show');


    
}

function doPubl() {

    $.post('/d5_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
        sid = $('input[name=subject_id]').val();
        mid = $('input[name=module_id]').val();
        lid = $('input[name=lesson_id]').val();
        //lid=r.lesson_id;
        if( lid=='0' ) {
            lid=r.publish;
            document.location="/d5_teacher/index/"+sid+'/'+mid+'/'+r.lesson_id;
        }
        $('#popupPubl').modal('hide');
        $('#publish').val(r.publish);
        if( r ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }
         $($($('#message').find("div")[0]).find("div")[0]).hide();
                                    if(r.publish==1)
                                        {
                                    showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
                                    }
                                    else
                                        {
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
                        
