$(function() {
    initPublishButton('#publish_btn', 'publish', 'PUBLISHED', 'PUBLISH');

    /* nicEdit */
    bkLib.onDomLoaded(function() { 
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('subject_objectives');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('subject_teaching_activities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('subject_assessment_opportunities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('subject_notes');
    })
})
function publishModal() {
    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active'))
        {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to unpublish the Curriculum');
    } else {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Curriculum');
    }
    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $.post('/d1b/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
        $('#publish').val(r);
        if( r==1 ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }
        $('#popupPubl').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r==1) {
            showFooterMessage({status: 'success', mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'success', mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    }, "json");
}
