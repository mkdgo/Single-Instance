function publishModal() {

    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active'))  {
        $( $('#popupPubl').find('p')[0] ).html('This act will unpublish all related modules. Please confirm you would like to unpublish the Curriculum');
    } else {
        if( $('.publish_btn').attr('rel') != '' ) {
            $( $('#popupPubl').find('p')[0] ).html('You are trying to publish lesson from a '+ $('.publish_btn').attr('rel') +' that are unpublished. Please confirm if you would like to publish the parent '+ $('.publish_btn').attr('rel') +' , otherwise please cancel.');
        } else {
            $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Curriculum');
        }
    }

    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $('#subject_intro').val( nicEditors.findEditor('subject_intro').getContent() );
    $('#subject_objectives').val( nicEditors.findEditor('subject_objectives').getContent() );
    $('#subject_teaching_activities').val( nicEditors.findEditor('subject_teaching_activities').getContent() );
    $('#subject_assessment_opportunities').val( nicEditors.findEditor('subject_assessment_opportunities').getContent() );
    $('#subject_notes').val( nicEditors.findEditor('subject_notes').getContent() );
    $.post('/d3_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
        $('#publish').val(r);
        if( r==1 ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
            $('.publish_btn').attr('rel','');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }
        $('#popupPubl').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r==1) {
            showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    }, "json");
}
