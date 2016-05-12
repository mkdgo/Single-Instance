$().ready(function(){
	var ns = $('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div.drag',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		maxLevels: 2,
        protectRoot:true,
		isTree: true,
        expandOnHover: 700,
		startCollapsed: false,
       	update: function(){
            sortRequest(sort_save=true);
        }
	});
});


function doDel() {
    document.location = $('#popupDelBT').attr('delrel');
}

function delRequest(L, type,title) {
    $('#popupDelBT').attr('delrel', L);
    if(type==1) {
        $('#popupDel > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Module?');
        $('#popupDel > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Module <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');
    }else {
        $('#popupDel > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Lesson?');
        $('#popupDel > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Lesson <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');
    }
    $('#popupDel').modal('show');
}

function cancelPopup() {
   $('#popupDel').popup('close');
}

var resources_order = '';

function sortRequest(sort_save) {
    var ordered_modules = [];
    var roots = $( 'ol.menu' ).find('li');
    roots.each(function( index ) {
        var ordered_items = [];
        if( $( roots[index] ).hasClass('root_level')) {
            var order_item = [];
            var subs =  $( roots[index] ).find('li');
            subs.each(function( index_sub ) {
                ordered_items.push( $( roots[index] ).attr('idn')+":"+$(subs[index_sub]).attr('idn'));
                link_title = $( $( subs[index_sub] ).find('span')[0] );
                var position = link_title.html().indexOf(':');
                var title = link_title.html().substring(position);
                link_title.html( "Lesson "+(index_sub+1) + ' ' + title );
            });
            if(subs.length==0) {
                ordered_items.push( $( roots[index] ).attr('idn')+":");
                $( $( roots[index] ).find('ol')[0] ).hide();
            } else {
                $( $( roots[index] ).find('ol')[0] ).show();
            }
            ordered_modules.push( ordered_items );
        }
    });
    if(sort_save) {
        $.post('/d2_teacher/saveorder/', {"data": JSON.stringify(ordered_modules)}, function(r, textStatus) {
            //alert(r);
        }, "json");
    }
}
    
function resizeWin() {
    $('.sub_level').each(function( index ) {
        icon = $($(this).find('div')[0]);
        label = $($(this).find('div')[1]);
        del = $($(this).find('div')[2]);
        dot = $($(this).find('div')[3]);
        label.width( $('.sub_level').width() - (icon.width()+dot.width()+del.width()) );
    });
}

function d(m, t) {
    t = t || ', ';
    $("#debuger").html($("#debuger").html()+t+m);
}

function dc() {
    $("#debuger").html("");
}
$(function() {

//$( "body" ).append( '<div id="debuger" style="z-index:100000; left:0; top:0; position: fixed; overflow: scroll; width: 500px; height: 200px; background: #ccc;"></div><a style="z-index:100001; left:0; top:220px; position: fixed;" href="javascript: dc()">clear</a>');
    
    var max = $(document).height()-$(window).innerHeight();
  //$(".submenu li").attr("class", "sub_level");
 // $(".submenu li").css({width: "100%"});

    $( window ).resize(function() {
        //resizeWin();
    });
//  $("ul.menu66").sortable(
//  {
//         
//         handle: 'i.icon-move'
//         
//         ,isValidTarget: function(item, conteiner)
//         {
//             
//             
//            itIs = true;
//            
//            //if($('.placeholder').is(':hidden'))itIs=false;
//            
//            
//            if(conteiner.el.attr('class')=='menu'&& item.attr('class')=='sub_level dragged')itIs=false;
//            if(conteiner.el.attr('class')=='submenu'&& item.attr('class')=='root_level dragged')itIs=false;
//         
//            
//            return itIs;
//         }
//          
//         ,onDrop: function(item, targetContainer, _super)
//         {
//            var clonedItem = $('#temp_item');
//            clonedItem.detach();
//            
//            _super(item);
//            item.css({width:"100%"});
//            sortRequest(true);
//         },
//
//        
//          // set item relative to cursor position
//          onDragStart: function (item, container, _super)
//          {
//          //   container.placeholder.html("7")
//              
//            var offset = item.offset(),
//            pointer = container.rootGroup.pointer;
//    
//    
//            var CITM = '<li id="temp_item" style="margin-bottom: 0px; margin-left: 0px; height: 67px; width: 100%" class="temp_item"></li>';
//           
//            if(item.attr('class')=='root_level')
//            {
//                var CITM = '<li id="temp_item" style="margin-top: 20px; height: '+(item.height())+'px; width: 100%" class="temp_item"></li>';
//            }
//            
//           var clonedItem = $(CITM);
//        
//            item.before(clonedItem);
//          
//            adjustment = {
//              left: pointer.left - offset.left,
//              top: pointer.top - offset.top
//            }
//
//            _super(item, container)
//          },
//          onDrag: function (item, position)
//          {
//        
//          /*
//           var x = $(window).innerHeight() - 50,
//                y = $(window).scrollTop() + 50;
//            
//           if($(window).scrollTop() > max)
//           {
//               $(window).scrollTop() = max;
//              
//           }
//           else if($(window).scrollTop() < 0)
//           {
//               $(window).scrollTop()=0;
//              
//           }else
//           {
//                if (item.offset().top > x)
//                {
//                    //Down
//                   $(window).scrollTop($(window).scrollTop()+20);
//                   //alert('d')
//                }
//                if (item.offset().top < y)
//                {
//                    //Up
//                    //alert('u')
//                    $(window).scrollTop($(window).scrollTop()-20);
//                }
//            }
//            */
//           // alert($(window).scrollTop());
//              
//              
//              
//            item.css({
//              left: position.left - adjustment.left,
//              top: position.top - adjustment.top
//            });
//          },
//          afterMove: function (placeholder, container, closestItemOrContainer)
//          {
//              //lert(closestItemOrContainer.attr("idn"));
//              
//              
//              if(closestItemOrContainer.attr("class")=="temp_item")placeholder.hide();else placeholder.show();
//             // if(closestItemOrContainer.attr("idn")=="label")placeholder.hide();else placeholder.show();
//              
//          }
//          
//  });

    sortRequest(false);

    //resizeWin();
})
