var current_page = 0;
var data;
var AREA;
var MARK; 
var CAT;
var VALID_marks;
var DNL_LINK;
var tmp_ttl = [];
var changed_element;
$('.editable').each(function(){
    this.contentEditable = true;
});
function calcDataCount() {
    tmp = 0;
    for(var c=0; c<data.length; c++) {
        PG = data[c];

        $.each( PG.items, function( key, val ) {
                //if(val.has_area)
                //{
            if(val.unique_n>tmp)tmp=val.unique_n;
                //}
        });
    }
    return tmp+1;
}

function getArea(p, unique_n) {
    PG = data[p];
    E = K = false;
    $.each( PG.items, function( key, val ) {
        if( Number(val.unique_n) == Number(unique_n) ) { E = val; K = key }
    });
    return {'E':E, 'K':K};
}

function deActivateAll() {

    for(ppg=0; ppg<data.length; ppg++) {
        $.each( data[ppg].items, function( key, val ) {
            deactivateOne(val);
        });
    }
}; 

function deactivateOne(val) {
    if(val.has_area) {
        if($("#area_"+val.unique_n)) {
            elm = $("#area_"+val.unique_n);

            elm.css('background', "url('/img/img_dd/green_bg.png')");
            $(elm.find("div")[0]).css({ 'opacity' : 0 });   
            $(elm.find("div")[3]).css({ 'opacity' : 0 });   
            $(elm.find("div")[2]).css({ 'opacity' : 0 }); 

            elm.css('z-index', 100+val.unique_n);

        }
    }

    elm_c = $("#comment_row_"+val.unique_n);
    //$(elm_c.find("textarea")[0]).css({ 'border' : "solid 1px #b2b2b2" });
    //$(elm_c.find("textarea")[0]).css({ 'background' : "#fff" });

    //$(elm_c.find("input")[0]).attr("style", "background : #fff !important; border :solid 1px #b2b2b2 !important");

    // $(elm_c.find("select")[0]).attr("style", "background : #fff !important; border :solid 1px #b2b2b2 !important");

    //mark----$(elm_c.find("div")[0]).css('background', "url('/img/img_dd/dot2.png') no-repeat");
    elm_c.css('background', '#eee');
    $(elm_c.find("div")[0]).css('background', '#ccc');
    $(elm_c.find("div")[1]).css('background', '#ccc');
}


function setActive(ELM_ID, sl) {
    elm = $("#area_"+ELM_ID);
    elm.css('background', "url('/img/img_dd/green_bg2.png')");
    $(elm.find("div")[0]).css({ 'opacity' : 1 });
    $(elm.find("div")[3]).css({ 'opacity' : 1 });
    $(elm.find("div")[2]).css({ 'opacity' : 1 });

    elm.css('z-index', 1000 );

    elm_c = $("#comment_row_"+ELM_ID);
    elm_c.css('background', '#FFE5A4');
    //$(elm_c.find("textarea")[0]).css({ 'border' : "solid 1px #db5a21" });
    // $(elm_c.find("textarea")[0]).css({ 'background' : "#eca88a" });

    //$(elm_c.find("input")[0]).attr("style", "background : #eca88a !important; border: solid 1px #db5a21 !important");
    if(sl) {
//        $(elm_c.find("textarea")[0]).focus();
    } else {
        $(elm_c.find("input")[0]).focus();
    }

    //$(elm_c.find("select")[0]).attr("style", "background : #eca88a !important; border: solid 1px #db5a21 !important");

    //mark-----$(elm_c.find("div")[0]).css('background', "url('/img/img_dd/dot.png')  no-repeat");
    $(elm_c.find("div")[0]).css('background', '#ff0000');
    $(elm_c.find("div")[1]).css('background', '#ff0000');


}    

function redrawPage(p) {
/*
    $("#editor").html("");
    if(pages_num==0) {
        L = DNL_LINK.clone();
        $("#editor").append(L);
    }

    PG = data[p];

    $.each( PG.items, function( key, val ) {
        if(val.has_area) {
            elm = AREA.clone();
            E_k = val.unique_n;

            elm.attr("unique_n", E_k);

            elm.attr("id", "area_"+E_k);

            parent_counter =  $("#comment_row_"+E_k);
            counter = $($(parent_counter.find("div")[0]).find("div")[0]).html();
            $($(elm.find("div")[0]).find("div")[0]).html(counter);

            elm.css("left", val.left+"px");
            elm.css("top", val.top+"px");
            elm.css("width", val.width+"px");
            elm.css("height", val.height+"px");

            if(user_type=="student") {

                $(elm.find("div")[2]).hide();
                $(elm.find("div")[3]).hide();
            }

            $("#editor").append(elm);
        }
    });

    $("#arrow_left_i").show();
    $("#arrow_right_i").show();

    if(p==0)$("#arrow_left_i").hide();
    if(p==data.length-1)$("#arrow_right_i").hide();
//*/
}

function redrawComments(ch_el) {
    $("#comments_rows").html("");

    counter = 1;
    for( ppg = 0; ppg < data.length; ppg++) {    
        PG = data[ppg];
        $.each( PG.items, function( key, val ) {
            elm = MARK.clone();
            E_k = val.unique_n;

            elm.attr("unique_n", E_k);

            elm.attr("id", "comment_row_"+E_k);

            TA = $(elm.find("textarea")[0]);
            TI = $(elm.find("input")[0]);
            NM = $($(elm.find("div")[0]).find("div")[0]);
            CT = $(elm.find("select")[0]);


            NM.html(counter);
            counter++;
            TA.val(val.comment);
            TI.val(val.evaluation);
            TI.attr('value', val.evaluation);

            CT.val(val.cat);
            elm.find('.v').text(CT.find(":selected").text() );

            NM.attr("pg", ppg);
            elm.attr("pg", ppg);
            TA.attr("pg", ppg);
            TI.attr("pg", ppg);
            CT.attr("pg", ppg);
            CT.attr("rel", val.cat);

            $(elm.find("a")[0]).attr("onClick", "deleteComment("+E_k+", "+ppg+");");

            if( user_type == "student" ) {

                $(elm).css( 'height', '100px' );
                $(elm.find(".tinfo")).html(teacher_name);
                $(elm.find(".comment_row_cell_extra")).css( 'margin', '0px' );

                $(elm.find("a")[0]).hide();

                TI.parent().css('text-align', 'center');
                TI.parent().css('width', '73px');

                var tt = CT.find(":selected").text();
                TA.parent().html('<div class="editable view_s">'+'<b>'+tt+'</b><br />'+TA.val()+'</div>');

                CT.remove();
//                CT.html('{teacher_name}');
//console.log( CT )
                TI.css({'height':'70px','font-weight':'bold','font-size':'16px','color':'#000','margin-top':'0px','margin-left':'16px'}).attr('disabled','disabled');
                var points = $(TI).val();
                TI.parent().html('<div class="editable view_s" style="width: 50px;margin-left: 33px;margin-top: 0px;padding-top: 20px;font-weight: bold;font-size:18px;">'+points+'</div>');

                TI.remove();

                //TA.prop('readonly', true);
                //TI.prop('readonly', true);
                //CT.prop('disabled', true);

            }else {
                TA.keyup(function(){CommentChanged($(this));});
                TI.keyup(function(){EvalChanged($(this),1);});
                CT.change(function(){CatChanged($(this), $(this).attr('rel'));});
            }
            $ ("#comments_rows").append(elm);
            elm.css("margin-bottom", "4px");
        });
    }

    totalvalstr = $($('#category_row_total').find("div")[1] ).html();
    totalval = total;
    $('#comment_row_total .category_row_right').html(total);
}

var debug = '';
function saveInfo(caller) {
    debug += caller+", ";
    // saveData();
}

function saveData() {

    if(!VALID_marks) {
        $( $('#popupMessage').find('p')[0] ).text('The total value of the marks has exceeded your allocation.  Please reduce the number of marks provided.');
        $('#popupMessage').modal('show');
        return;
    }

    var counter = 1;
    global:
    for(ppg=0; ppg<data.length; ppg++) {    
        PG = data[ppg];

        $.each( PG.items, function( kd, vd ) {
//            if(vd.comment=="" || vd.evaluation=="") {
            if(vd.comment=="") {
                $( $('#popupMessage').find('p')[0] ).text('Please add a Category/Comment/Mark to `Comment '+counter+'`');
                $('#popupMessage').modal('show');

                return global;
            }
            counter++;  
        });
    }
    $.post(URL_save, {"data": JSON.stringify(data)}, function(r, textStatus) {
        showFooterMessage({status: 'success', mess: 'Assignment was saved!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700});
    }, "json");
}

function loadData() {
//console.log( URL_load );
    $.post(URL_load, {"no": ""}, function(r, textStatus) {
        data=r;
        initionalDataLoaded();
    }, "json");
}

function addJustComment() {
    NEW_ELM_ID = Add({x:0, y:0}, false);

    redrawComments(current_page);

    deActivateAll();

    var element = document.getElementById("comments_rows");
    element.scrollTop = element.scrollHeight;
    $('#comment_row_'+NEW_ELM_ID+' .comment_TA').focus();
    setActive(NEW_ELM_ID,1);
}

function undoDeleteComment() {
    $('#popupDel').modal('hide');
}

function doDeleteComment() {

     $('#popupDel').modal('hide');
 
     p = $('#popupDelBT').attr('p');
     cm = $('#popupDelBT').attr('cm');
     var elmnt = $( "div#comment_row_"+cm+" div.comment_row_cell_three input.comment_TI" );
     
     EvalChanged($(elmnt),0);
 
     E_data = getArea(p, cm );
     K = E_data.K;
 
     data[p].items.splice(K, 1);

     saveInfo('deleteComment');
     saveData();

     deActivateAll();
     calculateTotal();

     redrawComments(current_page,0);   
     redrawPage(current_page);

}

function deleteComment(cm, p) {
    $('#popupDelBT').attr('cm', cm);
    $('#popupDelBT').attr('p', p);
    $('#popupDel').modal('show');
}

function Add(POS, has_area) {
    if(pages_num==0 && has_area)return;
    if(user_type=="student")return;

    new_k = calcDataCount();
    data[current_page].items.push({

            unique_n: new_k,
            has_area: has_area,
            comment: "",
            width: 100,
            height: 100,
            left: POS.x,
            top: POS.y,
            cat: homework_categories[0].id,
            evaluation: 0

    });

    saveInfo('Add');

    return new_k;
}

function CommentChanged(TA) {
    NEW_ELM_ID = TA.parent().parent().attr("unique_n");
    E_data = getArea( current_page, NEW_ELM_ID );
    E_data.E.comment = TA.val();
//console.log(TA)
    saveInfo('CommentChanged');

    deActivateAll();
    setActive(NEW_ELM_ID,1);
}

function EvalChanged(TI,ed_del) {
    NEW_ELM_ID = TI.parent().parent().attr("unique_n");
    E_data = getArea( current_page, NEW_ELM_ID );
    if( ed_del ) {
        $.each( homework_categories, function( khm, vhm ) {
            if(  homework_categories[khm].id == TI.parent().parent().find('select').val() ){
                if( isNumeric(TI.val()) ) {
                    homework_categories[khm].category_total = homework_categories[khm].category_total - E_data.E.evaluation + parseInt(TI.val());
                } else {
                    homework_categories[khm].category_total = homework_categories[khm].category_total - E_data.E.evaluation;
                }
            }
        });
        if( isNumeric(TI.val()) ) {
            total_total = total_total - E_data.E.evaluation + parseInt(TI.val());
            total = total - E_data.E.evaluation + parseInt(TI.val());
            E_data.E.evaluation = TI.val();
        } else {
            total_total = total_total - E_data.E.evaluation;
            total = total - E_data.E.evaluation;
            E_data.E.evaluation = '';
        }
        
    } else {
        
        $.each( homework_categories, function( khm, vhm ) {
            if(  homework_categories[khm].id == TI.parent().parent().find('select').val() ){
                if( isNumeric(TI.val()) ) {
                    homework_categories[khm].category_total = homework_categories[khm].category_total - parseInt(TI.val());
                } else {
                    homework_categories[khm].category_total = homework_categories[khm].category_total - parseInt(TI.val());
                }
            }
        });
        if( isNumeric(TI.val()) ) {
            total_total = total_total - parseInt(TI.val());
            total = total - E_data.E.evaluation;
            E_data.E.evaluation = TI.val();
        } else {
            total_total = total_total - parseInt(TI.val());
            total = total - E_data.E.evaluation;
            E_data.E.evaluation = '';
        }
    }
    calculateTotal();
    redrawComments(TI);
    saveInfo('EvalChanged');

    deActivateAll();
    setActive(NEW_ELM_ID,0);

}

function EvalDeleted(TI) {
//console.log('eval_del');
//console.log(TI);
    NEW_ELM_ID = TI.parent().parent().attr("unique_n");;
    E_data = getArea( current_page, NEW_ELM_ID );
//console.log( NEW_ELM_ID );
    $.each( homework_categories, function( khm, vhm ) {
        if(  homework_categories[khm].id == TI.parent().parent().find('select').val() ){
//console.log(homework_categories);
                homework_categories[khm].category_total = homework_categories[khm].category_total - E_data.E.evaluation;
//console.log(homework_categories);
        }
    });
        total_total = total_total - E_data.E.evaluation;
        total = total - E_data.E.evaluation;
        E_data.E.evaluation = TI.val();
//console.log(homework_categories);
//console.log(homework_categories);
    calculateTotal();
    redrawComments(TI);
    saveInfo('EvalChanged');

/*
    if( changed_element[0] ) {
console.log( changed_element );
        $(changed_element).focus();
    }
//*/
}

function CatChanged(CT, vl) {
    NEW_ELM_ID = CT.parent().parent().attr("unique_n");
    E_data = getArea( current_page, NEW_ELM_ID );
    E_data.E.cat = CT.val();

    $.each( homework_categories, function( khm, vhm ) {
        if(  homework_categories[khm].id == vl ){
            if( isNumeric(TI.val()) ) {
                homework_categories[khm].category_total = homework_categories[khm].category_total - E_data.E.evaluation;
            }
        }
    });
    $.each( homework_categories, function( khm, vhm ) {
        if(  homework_categories[khm].id == CT.val() ){
            if( isNumeric(TI.val()) ) {
                homework_categories[khm].category_total = homework_categories[khm].category_total + parseInt(E_data.E.evaluation);
            }
        }
    });

    calculateTotal();
    redrawComments(TI);

    saveInfo('CatChanged');

    saveInfo('EvalChanged');

    deActivateAll();
    setActive(NEW_ELM_ID,0);
}

function checkValidMarks(NEW_ELM_ID) {

}

function calculateTotal() {
    $.each( homework_categories, function( khm, vhm ) {
        homework_categories[khm].total=0;
    });

    for(ppg=0; ppg<data.length; ppg++) {    
        PG = data[ppg];
//console.log( homework_categories );
        $.each( PG.items, function( key, val ) {
            if( val.evaluation && isNumeric(val.evaluation) ) {

                new_val = parseInt(val.evaluation);
                total += new_val;

                calc_cat_total:
                for(c=0; c<homework_categories.length; c++) {
                    if(homework_categories[c].id == val.cat) {
//console.log( val.cat );
                        homework_categories[c].total += new_val;

                        break calc_cat_total;
                    }
                }
            }
        });
    }

    $('#categories_rows').html("");
    total = 0;
    VALID_marks = true;
    for(c=0; c < homework_categories.length; c++) {
        CT_total = CAT.clone();
        CT_total.attr('id', 'category_row_'+c);
        $( CT_total.find("div")[0] ).html(homework_categories[c].category_name);
        
        var bs_ttl = homework_categories[c].category_marks;
        var lf_ttl = homework_categories[c].category_total;
        var cr_ttl = homework_categories[c].total;
        
        total += cr_ttl;
        $( CT_total.find("div")[1] ).html(lf_ttl+' of '+bs_ttl);
//        $( CT_total.find("div")[1] ).html(cr_ttl+"/"+lf_ttl+' of '+bs_ttl);

        if( lf_ttl > bs_ttl ) {
            VALID_marks = false;
            $( CT_total.find("div")[1] ).css('color', 'red');
            $( CT_total.find("div")[0] ).css('color', 'red');
        }
        $('#categories_rows').append(CT_total);
    }

    CT_totalr = CAT.clone();
    CT_totalr.attr('id', 'category_row_total');
    CT_totalr.css('font-weight', 'bold');
    $( CT_totalr.find("div")[0] ).html("Total:");
    $( CT_totalr.find("div")[1] ).html(total_total+' of '+total_avail);
//    $( CT_totalr.find("div")[1] ).html(total+"/"+total_total+' of '+total_avail);
    $('#categories_rows').append(CT_totalr);

}

function elmentEventPos(ELM, left, top) {
    E_data = getArea(current_page, ELM.attr("unique_n") );
    E = E_data.E;
    E.left = left;
    E.top = top;
}

function elmentEventSave() {
    saveInfo('propertiesUpdated');
}

function elmentEventSize(ELM, width, height) {
    E_data = getArea(current_page, ELM.attr("unique_n") );
    E = E_data.E;
    E.width = width;
    E.height = height;
}

$('body').click(function(e) {

    clickerClass= $(e.target).attr("class");
/*  Temporary unavailabel
    if(clickerClass=="editor") {
        var POS = $('#editor').gmPos(e);
        var CENTER = $('#editor_holder').position();
        var P={x:POS.x-CENTER.left, y:POS.y-CENTER.top};

        NEW_ELM_ID = Add(P, true);

        redrawComments(current_page);
        redrawPage(current_page);

        deActivateAll();
        setActive(NEW_ELM_ID,1);

        e.stopPropagation();
        return;
    }
//*/
    if(clickerClass=="dd_block snap-to-grid") {
        deActivateAll();
        setActive( $(e.target).attr("unique_n"),1 );
        e.stopPropagation();
        return;
    }

    if(
            clickerClass=="comment_row" ||
            clickerClass=="comment_row_cell_one" ||
            clickerClass=="comment_row_cell_extra" ||
            clickerClass=="comment_row_cell_two" ||
            clickerClass=="comment_row_cell_three" ||

            clickerClass=="comment_CT" ||
            clickerClass=="comment_TA" ||
            clickerClass=="comment_TI" ||
            clickerClass=="comment_NM" ||
            clickerClass=="editable view_s"

    ) {

        if( clickerClass=="comment_row") {
            NEW_ELM_ID = Number($(e.target).attr("unique_n"));
            paginnation_changePage( Number($(e.target).attr("pg")) );
        } else if(
                clickerClass=="comment_row_cell_one" ||
                clickerClass=="comment_row_cell_extra" ||
                clickerClass=="comment_row_cell_two" ||
                clickerClass=="comment_row_cell_three"
            ) {
            NEW_ELM_ID = Number($(e.target).parent().attr("unique_n"));
            paginnation_changePage( Number($(e.target).parent().attr("pg")) );
        } else if(
            clickerClass=="editable view_s"
        ){
            NEW_ELM_ID = Number($(e.target).parent().parent().attr("unique_n"));
            paginnation_changePage( Number($(e.target).parent().parent().attr("pg")) );
        } else {
            NEW_ELM_ID = $(e.target).parent().parent().attr("unique_n");
            paginnation_changePage( Number($(e.target).attr("pg")) );
        }

        deActivateAll();
        setActive(NEW_ELM_ID,1);

        e.stopPropagation();
        return;
    }
});

function paginnation_doPage(way) {
    request_page = way+current_page;
    if(request_page>data.length-1)return;
    if(request_page<0)return;

    paginnation_changePage(request_page);
}

function paginnation_changePage(pg) {
    PAGIN_STRING = "PAGE %cp% OF %allp%";

    current_page = pg;
    img = data[current_page].picture;
    IMG_holder = $("#editor_image");

    // set Preload Image Here
    //IMG.css('background', "url('"+homeworks_html_path+img+"')");

    //var tmpImg = new Image() ;
    // tmpImg.src = homeworks_html_path+img;
    $("#preload_img").remove();

    $('<img id="preload_img" style="width: 460px;"/>').attr('src', homeworks_html_path+img).load(function() {
            //tmpImg.onload = function() {

        $(this).hide();
        $(this).appendTo($('body'));

        I_height = this.height;


        $(this).remove();
        $("#preload_img").remove();

        IMG_holder.css('height', (I_height)+"px");
        IMG_holder.css('background', "url('"+homeworks_html_path+img+"')");
        IMG_holder.css('background-size', "460px "+I_height+"px");
        IMG_holder.css('background-repeat', "no-repeat");
        $("#editor").css( 'height',(I_height+100)+"px");
        $("#editor_holder").css( 'height',(I_height+100)+"px");
        $("#editor_image").css( 'height',(I_height+30)+"px");
    });

    PAGIN_STRING = PAGIN_STRING.replace("%cp%", current_page+1);
    PAGIN_STRING = PAGIN_STRING.replace("%allp%", data.length);
    PAGIN_INFO = $("#caption_b").html(PAGIN_STRING);

    redrawPage(current_page);

    deActivateAll();
}

function initionalDataLoaded() {
    //$($("#TTL").find("div")[0]).html(student_name);

    calculateTotal();

    paginnation_changePage(0);
    redrawComments(0);
    redrawPage(0);
    deActivateAll();
}

//$(function()
$(function($){

    DNL_LINK = $("#download_resource_link").clone();
    $("#download_resource_link").remove();
  
    AREA = $("#area").clone();
    $("#area").remove();

    MARK = $("#comment_row").clone();
    $("#comment_row").remove();
    
    catscombo = $( MARK.find('select')[0] );
    $.each( homework_categories, function( key, val ) {
           catscombo.append('<option value="'+val.id+'">'+val.category_name+'</option>');
    });
    
    CAT = $("#category_row").clone();
    $("#category_row").remove();
    
    if(user_type=="student") {
        $('#addcomment_bt').remove();
        $('#savedraft_bt').remove();

        
    } else {
        $('#editor').dragResize({grid: 20});
    }

    loadData();
});
                        
////
function isNumeric(input) {
    return (input - 0) == input && (''+input).replace(/^\s+|\s+$/g, "").length > 0;
}
