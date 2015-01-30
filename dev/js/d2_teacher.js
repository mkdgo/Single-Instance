$().ready(function(){
    var ns = $('ol.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper:	'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: 2,
                protectRoot:true,
                isTree: true,
                expandOnHover: 700,
                startCollapsed: false,
                update: function(){
//console.log('Relocated item');
                sortRequest(sort_save=true);
            }
    });
});
function doDel(){
    document.location = $('#popupDelBT').attr('delrel');
}


function delRequest(L, type,title){
    console.log(title);
    $('#popupDelBT').attr('delrel', L);
    if(type==1)
        {
        $('#popupDel > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Module?');
        $('#popupDel > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Module <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');

    }else
        {
        $('#popupDel > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Lesson?');
        $('#popupDel > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Lesson <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');
    }
    $('#popupDel').modal('show');
}

function cancelPopup(){
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

                link_title = $( $( subs[index_sub] ).find('a')[0] );

                link_inside = link_title.html().split('Lesson ');
                link_inside_b = link_inside[1].split(': ');
                link_inside_b.shift();
                link_inside[1] = link_inside_b.join();

                link_title.html( link_inside.join('Lesson '+(index_sub+1)+': ') );
            });

            if(subs.length==0) {
                ordered_items.push( $( roots[index] ).attr('idn')+":");
                $( $( roots[index] ).find('ol')[0] ).hide();
            }else {
                $( $( roots[index] ).find('ol')[0] ).show();
            }
            ordered_modules.push( ordered_items );
        }
    });

    //resources_order = ordered_modules.join(';');
    if(sort_save) {
        $.post('/d2_teacher/saveorder/', {"data": JSON.stringify(ordered_modules)}, function(r, textStatus) {
                //alert(r);
        }, "json");
    }
    //alert(resources_order);
    //68:170,68:172,68:175,68:166;70:176,70:177;71:178;88:;89:173;90:181,90:180
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

$(function  () {
    //$( "body" ).append( '<div id="debuger" style="z-index:100000; left:0; top:0; position: fixed; overflow: scroll; width: 500px; height: 200px; background: #ccc;"></div><a style="z-index:100001; left:0; top:220px; position: fixed;" href="javascript: dc()">clear</a>');

    var max = $(document).height()-$(window).innerHeight();
    $( window ).resize(function() { resizeWin(); }); 

    sortRequest(false);
    resizeWin();
})


