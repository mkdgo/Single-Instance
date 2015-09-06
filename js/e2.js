$(function(){
/*
    new TINY.editor.edit('editor',{
    id:'content_text',
    width:550,
    height:175,
    cssclass:'te',
    controlclass:'tecontrol',
    rowclass:'teheader',
    dividerclass:'tedivider',
    controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
              'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
              'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
              'font','size','style','|','image','hr','link','unlink','|','cut','copy','paste','print'],
    footer:true,
    fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
    xhtml:true,
    cssfile:'style.css',
    bodyid:'editor',
    footerclass:'tefooter',
    toggle:{text:'source',activetext:'wysiwyg',cssclass:'toggle'},
    resize:{cssclass:'resize'}
});
//*/    
    
//    $('#content_text').wysihtml5();
/*
  var editor = new wysihtml5.Editor( "content_text", {
    toolbar:        "toolbar",
    parserRules:    wysihtml5ParserRules,
    useLineBreaks:  false
  });
//*/
/*
    var editor = new wysihtml5.Editor(document.querySelector('.textarea_fixed'), {
        toolbar: document.querySelector('.toolbar'),
        parserRules:  wysihtml5ParserRules // defined in file parser rules javascript
    });
//*/

//    site.initFrontPage();
//    site.initEditor();
})


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
    $.post('/e2/removeResource', { cont_page_id: $( "#cont_page_id" ).val(), resource_id: res_id }, function(r, textStatus) {
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
