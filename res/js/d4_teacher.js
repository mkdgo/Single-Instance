$(function() {
    bkLib.onDomLoaded(function() { 
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('module_intro');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('module_objectives');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('module_teaching_activities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('module_assessment_opportunities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
        }).panelInstance('module_notes');
    })
})

function publishModal() {
    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active')) {
        $( $('#popupPubl').find('p')[0] ).html('This act will unpublish all related lessons. Please confirm you would like to unpublish the Module');
    } else {
        if( $('.publish_btn').attr('rel') != '' ) {
            $( $('#popupPubl').find('p')[0] ).html('You are trying to publish lesson from a '+ $('.publish_btn').attr('rel') +' that are unpublished. Please confirm if you would like to publish the parent '+ $('.publish_btn').attr('rel') +' , otherwise please cancel.');
        } else {
            $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Module');
        }
    }
    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $('#module_intro').val( nicEditors.findEditor('module_intro').getContent() );
    $('#module_objectives').val( nicEditors.findEditor('module_objectives').getContent() );
    $('#module_teaching_activities').val( nicEditors.findEditor('module_teaching_activities').getContent() );
    $('#module_assessment_opportunities').val( nicEditors.findEditor('module_assessment_opportunities').getContent() );
    $('#module_notes').val( nicEditors.findEditor('module_notes').getContent() );

    $.post('/d4_teacher/saveajax', {"data": $( "#saveform" ).serializeArray() }, function(r, textStatus) {
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
            $('.publish_btn').attr('rel','');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }

        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r.publish==1) {
            showFooterMessage({status: 'success', mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'alert', mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    }, "json");
}

$( document ).bind( "mobileinit", function() {
    $.mobile.ignoreContentEnabled = true;
});

$( document ).bind( "pageinit", function() {

});

function resourceModal(res) {
    $('#message').modal('hide');
    $( $('#popupDelRes').find('p')[0] ).html('Please confirm you would like to remove this Resource');

    $( $('#popupDelRes').find('h4')[0] ).text('');
    $( "#popupDelRes .res_id" ).val(res);
    $('#popupDelRes').modal('show');
}

function doDelRes() {
    var res_id = $( "#popupDelRes .res_id" ).val();
    $.post('/d4_teacher/removeResource', { module_id: $( "#module_id" ).val(), resource_id: res_id }, function(r, textStatus) {
        if( r==1 ) {
            $('#res_'+res_id).remove();
        }
        $('#popupDelRes').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r==1) {
            showFooterMessage({status: 'success', mess: 'Resource removed', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'alert', mess: 'Processing error...', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    });
}

function addCButton(rid) {
    $('#cboxContent').append('<a class="cdownload" href="/df/index/'+rid+'" style="font-size: 24px; color: #e74c3c; position: absolute; bottom: 0; right: 0; margin-right: 30px; margin-bottom: -5px;"><span class="fa fa-download"></span></a>');
}

function removeCButton() {
    $('#cboxContent').remove('.cdownload');
}
