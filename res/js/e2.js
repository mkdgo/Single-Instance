$(function(){
})

/* remove resource */
function resourceModal(res) {
    $('#message').modal('hide');
    $( $('#popupDelRes').find('p')[0] ).html('Please confirm you would like to remove this Resource');

    $( $('#popupDelRes').find('h4')[0] ).text('');
    $( "#popupDelRes .res_id" ).val(res);
    $('#popupDelRes').modal('show');
}

function doDelRes() {
    var res_id = $( "#popupDelRes .res_id" ).val();
    $.post('/e2/removeResource', { cont_page_id: $( "#cont_page_id" ).val(), resource_id: res_id }, function(r, textStatus) {
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
