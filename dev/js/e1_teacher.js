function delRequest(L,slide)
{
    console.log(slide);
    
    $('#popupDelBT').attr('delrel', L);
    $('#popupDel').modal('show');
    
    $('.modal-body p').html('').append('Please confirm you would like to delete this Slide <span style="color:#e74c3c;text-decoration:underline;">'+slide+'</span> ?');
}

function doDel()
{
    document.location = $('#popupDelBT').attr('delrel');
    
}

function addNew()
{
    $('#addPopup').modal('show');
    
}

function cancelPopup()
{
   $('#popupDel').popup('close');
}


function publishAndSave()
{
   
   // console.log('dd');
    $.post('/e1_teacher/saveajax', {"data": $( "#int_lesson_form" ).serializeArray() }, function(r, textStatus)
    {
          //if(r=='1');
    }, "json");
}

function sortRequest()
{
    
    var ordered_items = [];
    $("ul.menu2 li").each(function( index ) {
       if( $( this ).attr('idn').substr(0, 2)=='e2' || $( this ).attr('idn').substr(0, 2)=='e3'  )ordered_items.push($( this ).attr('idn'));
    });
    
    $('#resources_order').val(ordered_items.join());
    
}
    
$(function()
{
  $("ul.menu2").sortable(
  {
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