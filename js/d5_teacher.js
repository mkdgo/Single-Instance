function publishModal() {
    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active')) {
        $( $('#popupPubl').find('p')[0] ).html('This act will unpublish all related slides. Please confirm you would like to unpublish the Lesson Plan');
    } else {
        if( $('.publish_btn').attr('rel') != '' ) {
            $( $('#popupPubl').find('p')[0] ).html('You are trying to publish lesson from a '+ $('.publish_btn').attr('rel') +' that are unpublished. Please confirm if you would like to publish the parent '+ $('.publish_btn').attr('rel') +' , otherwise please cancel.');
        } else {
            $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Lesson Plan');
        }
    }
    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $('#lesson_intro').val( nicEditors.findEditor('lesson_intro').getContent() );
    $('#lesson_objectives').val( nicEditors.findEditor('lesson_objectives').getContent() );
    $('#lesson_teaching_activities').val( nicEditors.findEditor('lesson_teaching_activities').getContent() );
    $('#lesson_assessment_opportunities').val( nicEditors.findEditor('lesson_assessment_opportunities').getContent() );
    $('#lesson_notes').val( nicEditors.findEditor('lesson_notes').getContent() );

    $.post('/d5_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
        sid = $('input[name=subject_id]').val();
        mid = $('input[name=module_id]').val();
        lid = $('input[name=lesson_id]').val();
//        ppsh = $('input[name=parent_publish]').val();

        if( lid=='0' ) {
            lid=r.publish;
            document.location="/d5_teacher/index/"+sid+'/'+mid+'/'+r.lesson_id;
        }
        $('#popupPubl').modal('hide');
        $('#publish').val(r.publish);
        if( r.publish == 1 ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
            $('.publish_btn').attr('rel','');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
            $('.publish_btn').attr('rel','');
        }
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if( r.publish == 1 ) {
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

// remove resource
function resourceModal(res) {
    $('#message').modal('hide');
    $( $('#popupDelRes').find('p')[0] ).html('Please confirm you would like to remove this Resource');

    $( $('#popupDelRes').find('h4')[0] ).text('');
    $( "#popupDelRes .res_id" ).val(res);
    $('#popupDelRes').modal('show');
}

function doDelRes() {
    var res_id = $( "#popupDelRes .res_id" ).val();
    $.post('/d5_teacher/removeResource', { lesson_id: $( "#lesson_id" ).val(), resource_id: res_id }, function(r, textStatus) {
        if( r==1 ) {
            $('#res_'+res_id).remove();
        }
        $('#popupDelRes').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r==1) {
            showFooterMessage({mess: 'Resource removed', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({mess: 'Processing error...', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    });
}
