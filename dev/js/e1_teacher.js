function delRequest(L,slide){
//    console.log(slide);

    $('#popupDelBT').attr('delrel', L);
    $('#popupDel').modal('show');

    $('.modal-body p').html('').append('Please confirm you would like to delete this Slide <span style="color:#e74c3c;text-decoration:underline;">'+slide+'</span> ?');
}

function doDel(){
    document.location = $('#popupDelBT').attr('delrel');
}

function addNew(){
    $('#addPopup').modal('show');
}

function cancelPopup(){
    $('#popupDel').popup('close');
}

/* publish modal*/
function publishModal() {
    $('#message').modal('hide');
    if($('.publish_btn').hasClass('active'))
        {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to unpublish the Slides');
    }
    else
        {
        $( $('#popupPubl').find('p')[0] ).html('Please confirm you would like to publish the Slides');
    }
    $( $('#popupPubl').find('h4')[0] ).text('');
    $('#popupPubl').modal('show');
}

function doPubl() {
    $.post('/e1_teacher/saveajax', {"data": $( "#int_lesson_form" ).serializeArray() }, function(r, textStatus){
        $('#publish').val(r);
        if( r ) {
            $('.publish_btn').addClass('active');
            $('.publish_btn span').text('PUBLISHED');
        } else {
            $('.publish_btn').removeClass('active');
            $('.publish_btn span').text('PUBLISH');
        }
        $('#popupPubl').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if(r==1){
            showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({mess: 'Successfully Unpublished', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    }, "json");
}
/* end publish modal */

function sortRequest(){
    var ordered_items = [];
    $("ul.menu2 li").each(function( index ) {
            if( $( this ).attr('idn').substr(0, 2)=='e2' || $( this ).attr('idn').substr(0, 2)=='e3'  )ordered_items.push($( this ).attr('idn'));
    });
    $('#resources_order').val(ordered_items.join());
}

$(function() {
        $("ul.menu2").sortable({
                axis: 'x',

                handle: 'a.question-m',

                isValidTarget: function  (item, conteiner) {
                    itIs = true;
                    return itIs;
                },

                onDrop: function  (item, targetContainer, _super) {
                    var clonedItem = $('#temp_item');
                    clonedItem.detach();
                    sortRequest();
                    _super(item);
                },


                // set item relative to cursor position
                onDragStart: function (item, container, _super) {


                    var offset = item.offset(),
                    pointer = container.rootGroup.pointer

                    var clonedItem = $('<li id="temp_item" style="height: '+item.height()+'px; width: '+item.width()+'px;" class="temp_item"><div class="temp_item_inside"></div></li>');

                    item.before(clonedItem)

                    adjustment = {
                        left: pointer.left - offset.left,
                        top: pointer.top - offset.top
                    }

                    _super(item, container)
                },
                onDrag: function (item, position) {
                    item.css({
                            left: position.left - adjustment.left,
                            top: position.top - adjustment.top
                    })
                },
                afterMove: function (placeholder, container, closestItemOrContainer)
                {
                    if(closestItemOrContainer.attr("class")=="temp_item")placeholder.hide();else placeholder.show();
                    if(closestItemOrContainer.attr("idn")=="addnew")placeholder.hide();else placeholder.show();
                }

        });


        sortRequest();
});