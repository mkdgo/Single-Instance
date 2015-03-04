var CHR;
var OPTION_E;
var CAT;
var ATTR;
var STEPDOT;
var crr_step = 0;
var disableresource="0";
var disablecategories="0";
var disablegrade = "0";
var disableclasses = "0";
var disablepublishandsave = "0";
var fadeval = 0.25;

var steps_data = [
    {'text': 'Step 1: Assignment Description & Accompanying Resources'},
    {'text': 'Step 2: Mark Categories & Grade Thresholds'},
    {'text': 'Step 3: Select Classes and Set Deadlines'}
];
var slidestepway=1;
var slidestep=0;

function SlideCompleted()
{
    slidestep += Number(slidestepway);
    if(slidestep==3)$('#publish_btn').show();else $('#publish_btn').hide();
}

function initpublishedScreen()
{
    //$("#publishmarks_btn").hide();
    $("#publish_btn").show();

    $("article > header").hide();

    $(".slides > li").css("margin-top", "50px");
    $(".slides > li").css("margin-bottom", "50px");
//    $(".slides > li").css("margin-bottom", "200px");
    $(".slides > li").css("list-style", "none");
    $(".btn b2").hide();
    $(".btn.b2").hide();
    $("#saveBT").text('SAVE');

    c_A = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
    c_B = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';

    $('#step_1_1').attr('class', c_A);
    $('#step_1_2').attr('class', c_B);

    $('#step_2_1').attr('class', c_A);
    $('#step_2_2').attr('class', c_B);

    $('#step_3_1').attr('class', c_A);
    $('#step_3_2').attr('class', c_B);

    $('#step_1_2').css('margin-top', '30px');
}

function initunpublishedScreen() {
    //$("#publishmarks_btn").hide();

    $("#saveBT").text('SAVE AS A DRAFT');
    $('.slider').noosSlider({autoAnimate:0});
    //$('.slider').checkInWindow();

    c_A = 'col-lg-7 col-md-7 col-sm-7 col-xs-12';
    c_B = 'col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-12';

    $('#step_1_1').attr('class', c_A);
    $('#step_1_2').attr('class', c_B);

    $('#step_2_1').attr('class', c_A);
    $('#step_2_2').attr('class', c_B);

    $('#step_3_1').attr('class', c_A);
    $('#step_3_2').attr('class', c_B);

    $('.btn.b2.right.next-step.nav.next').attr('onClick', 'slideStep(\'1\')');
    $('.btn.b2.left.prev-step.nav.prev').attr('onClick', 'slideStep(\'-1\')');

    SlideCompleted();
    if(mode==1) {
        $('#assignment_intro').attr('onkeydown', 'updateSlideHeight(".step.s1")');
        updateSlideHeight(".step.s1");
    }
}

function initpastdateScreen() {

    $("#publishmarks_btn").show();

    if(datepast=="1") {
        disablecategories="1";
        disableresource="1";
        disablegrade="1";
        disableclasses="1";
        disablepublishandsave="1";
    }

    $(".slider input, .slider textarea").attr('readonly', true);
    //$('#grade_type').attr('readOnly', true);
    $('#grade_type').attr('disabled', true);
    $(".slider").fadeTo( "fast", fadeval);
    $("#publish_btn").off('click');

    $("#saveBT").fadeTo( "fast", fadeval );
    $("#publish_btn").fadeTo( "fast", fadeval );
    $("#publish_btn").off('mouseenter mouseleave');

    $('.btn.b1.right').hide();
    $('.btn.remove').hide();
    $('#add_cat_link').hide();

    initPublishButton('#publishmarks_btn', 'publishmarks', 'PUBLISHED MARKS', 'PUBLISH MARKS');
}

function slideStep(w) {
    slidestepway = Number(w);
    $('#publish_btn').hide();
}

function gradeTypeChange() {

    if(disablegrade=="1") {
        $("#step_2_2").attr('is_visible', 'n');
    } else if( $('#grade_type').val()=='grade' ) { 
        $("#step_2_2").attr('is_visible', 'y'); 
    } else {
        $("#step_2_2").attr('is_visible', 'n');
    }

    setGradeActivity();
}

function setGradeActivity()
{

    if(true)//mode!=1
        {

        if(datepast=="1") {
            $("#step_2_2").fadeTo( "fast", 1 );
        } else if( $("#step_2_2").attr('is_visible')=='n' ) {   
            $("#step_2_2").fadeTo( "fast", fadeval );
            // $("#step_2_2").hide();
            $("#step_2_2 input").prop('disabled', true);
            //add_attr
            $("#step_2_2 .add_attr").hide(100);
            //console.log('sds33');
        } else {
            $("#step_2_2 input").prop('disabled', false);
            $("#step_2_2").fadeTo( "fast", 1 );
            $("#step_2_2 .add_attr").show(100);
        }
    }
}

function initCategories()
{
    CAT = $('#grade_categories_row').clone();
    $('#grade_categories_row').remove();

    drawCategoories();
//    removeCategoryField();
}

function drawCategoories() {
    $('#grade_categories_holder').html("");

    total = 0;
//console.log( assignment_categories_json.length );
    if( assignment_categories_json.length == 0 ) {
        opt = CAT.clone();
        opt.attr('id', 'grade_categories_row_0');
        $( opt.find('a')[0] ).attr('onClick', 'delCategory(0)');

        $( opt.find('input')[0] ).val('');
        $( opt.find('input')[0] ).attr('onChange', 'catDataChange(0, "category_name", $(this).val() )');

        $( opt.find('input')[1] ).val('');
        $( opt.find('input')[1] ).attr('onChange', 'catDataChange(0, "category_marks", $(this).val() )');
        $('#grade_categories_holder').append(opt);
        C = {"assignment_id":"","category_marks":$( opt.find('input')[0] ).val(),"category_name":$( opt.find('input')[1] ).val()};
        assignment_categories_json.push(C);

    } else {
        for(i=0; i < assignment_categories_json.length; i++) {
            opt = CAT.clone();
            opt.attr('id', 'grade_categories_row_'+i);
            $( opt.find('a')[0] ).attr('onClick', 'delCategory('+i+')');

            $( opt.find('input')[0] ).val(assignment_categories_json[i].category_name);
            $( opt.find('input')[0] ).attr('onChange', 'catDataChange('+i+', "category_name", $(this).val() )');
            $( opt.find('input')[0] ).addClass('required');

            $( opt.find('input')[1] ).val(assignment_categories_json[i].category_marks);
            $( opt.find('input')[1] ).attr('onChange', 'catDataChange('+i+', "category_marks", $(this).val() )');
            $( opt.find('input')[1] ).addClass('required');

            if(i!=0)opt.css('border-top', 'none');
            if(assignment_categories_json[i].category_marks)
            total += parseInt(assignment_categories_json[i].category_marks);

            $('#grade_categories_holder').append(opt);
        }
        
    }
    $("#marksTotal").html("Total Marks: "+total);

    if(mode==1)updateSlideHeight('.step.s2');
}

function delCategory(i) {
    if(disablecategories=="1")return;

    assignment_categories_json.splice(i, 1);
    drawCategoories();
    removeCategoryField()
    $('#catg').addClass('required');
    $('#mark').addClass('required');
}

//start resizable
$(document).ready(function() {
    $('textarea').focus(function(){
//   console.log('start demo'); 
    })
    $('.resizable').each(function(){
//console.log('start');
        var t = this;
        var $t = $(t);
 //        var $input = $('> input', t);

        $t.on('keyup',t, function(){
            var v = $(this).val();
            var to = $t.data('to');
            if(to) clearTimeout(to); to = false;
            if(v){
                to = setTimeout(function(){
//console.log('keyup');
                }, 200);
       //                $t.data('to', to);
            }
        }).on('keydown', t, function(e){
            var v = $(this).val();
            if(e.keyCode == 13 && v) {
                $(this).val('');
//console.log('keydown');
            }
        }).on('click', t, function(){
            var v = $(this).text();
            if(v) {
//                $('.input-container input', t).val('');
//console.log('klick');
            }
        });

    });
});

//end resizable

function catDataChange(i, data, val)
{
    if(disablecategories=="1")return;

    storage = assignment_categories_json[i];
    storage[data]=val;
    drawCategoories();
    removeCategoryField()
}

function addCategory() {
    if(disablecategories=="1")return;
//*
//    add_row = $('#add_new_cat');
    add_row = $('#grade_categories_row_'+(assignment_categories_json.length-1));
    el_name = $( add_row.find('input')[0] );
    el_mark = $( add_row.find('input')[1] );
    Cmark = $( add_row.find('input')[1] ).val();
    Cname = $( add_row.find('input')[0] ).val();

//console.log( input );
    if(Cname.trim()==''||Cname ===undefined) {
        el_name.css({'border':'1px dashed red'});
        var msg = el_name.attr('data-validation-required-message');
        el_name.prev('span').attr('id','scrolled');
        el_name.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        el_name.prev('span').removeAttr('scrolled');
        el_name.prev('span').focus();
        return;
    }
    el_name.on('focus',function(){
        el_name.prev('span.tip2').fadeOut('333');
        el_name.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
    })

    if(Cmark.trim()==''||Cmark ===undefined) {
        el_mark.css({'border':'1px dashed red'});
        var msg = el_mark.attr('data-validation-required-message');
        el_mark.prev('span').attr('id','scrolled');
        el_mark.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        el_mark.prev('span').removeAttr('scrolled');
        el_mark.prev('span').focus();
        return;
    }

    el_mark.on('focus',function(){
        el_mark.prev('span.tip2').fadeOut('333');
        el_mark.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
    })

    opt = CAT.clone();
    opt.attr('id', 'grade_categories_row_'+assignment_categories_json.length);
    $( opt.find('a')[0] ).attr('onClick', 'delCategory('+assignment_categories_json.length+')');

    $( opt.find('input')[0] ).val('');
    $( opt.find('input')[0] ).attr('onChange', 'catDataChange('+assignment_categories_json.length+', "category_name", $(this).val() )');
    $( opt.find('input')[0] ).attr('class', 'required');

    $( opt.find('input')[1] ).val('');
    $( opt.find('input')[1] ).attr('onChange', 'catDataChange('+assignment_categories_json.length+', "category_marks", $(this).val() )');
    $( opt.find('input')[1] ).addClass('class', 'required');

    $('#grade_categories_holder').append(opt);

    C = {"assignment_id":"","category_marks":$( opt.find('input')[0] ).val(),"category_name":$( opt.find('input')[1] ).val()};
    assignment_categories_json.push(C);

//console.log( assignment_categories_json );
    drawCategoories();
//    removeCategoryField();

}

function addCategoryField()
{
    if(disablecategories=="1")return;

    $('#add_new_cat').show();
//    $('#add_cat_link').hide();

    if(mode==1)updateSlideHeight('.step.s2');

}

function updateSlideHeight(sid) {
//console.log( mode );
    actli = $( $(sid).parent() );
    if( mode == 1 ) {
        $('.slides').css('height', actli.outerHeight()+50);
    }
}

function preRemoveCategoryField() {

    $('#catg').val('');
    $('#mark').val(''); 

    removeCategoryField()
}

function removeCategoryField() {

    $('#add_new_cat').hide();
    $('#add_cat_link').show();

    if(mode==1)updateSlideHeight('.step.s2');
}

///////// attributes
function initAttributes() {
    ATTR = $('#grade_attr_row').clone();
    $('#grade_attr_row').remove();

    if(assignment_id==-1 || assignment_attributes_json.length == 0 ) {
        def_attr = [
            {"assignment_id":"0","attribute_name":"A","attribute_marks":"100"},
            {"assignment_id":"0","attribute_name":"B","attribute_marks":"80"},
            {"assignment_id":"0","attribute_name":"C","attribute_marks":"60"},
            {"assignment_id":"0","attribute_name":"D","attribute_marks":"40"},
            {"assignment_id":"0","attribute_name":"E","attribute_marks":"20"}
        ];

        assignment_attributes_json = def_attr;
    }

    drawAttributes();
}

function drawAttributes()
{
    $('#grade_attr_holder').html("");

    for(i=0; i<assignment_attributes_json.length; i++) {
        opt = ATTR.clone();
        opt.attr('id', 'grade_attr_row_'+i);
        $( opt.find('a')[0] ).attr('onClick', 'delAttribute('+i+')');

        $( opt.find('input')[0] ).val(assignment_attributes_json[i].attribute_name);
        $( opt.find('input')[0] ).attr('onChange', 'attrDataChange('+i+', "attribute_name", $(this).val() )');

        $( opt.find('input')[1] ).val(assignment_attributes_json[i].attribute_marks);
        $( opt.find('input')[1] ).attr('onChange', 'attrDataChange('+i+', "attribute_marks", $(this).val() )');

        if(i!=0)opt.css('border-top', 'none');
        $('#grade_attr_holder').append(opt);
    }

    optADD = ATTR.clone();
    optADD.attr('id', 'add_new_attr');
    $( optADD.find('a')[0] ).hide();
    $( optADD.find('input')[0] ).val("");
    $( optADD.find('input')[1] ).val("");
    //optADD.css('background-color', '#e0e6e7');attribute_name

    if(assignment_attributes_json.length!=0)optADD.css('border-top', 'none');
    $('#grade_attr_holder').append(optADD);

    setGradeActivity();
    if(mode==1)updateSlideHeight('.step.s2');
}

function delAttribute(i)
{
    if( $("#step_2_2").attr('is_visible')=='n' )return;
    assignment_attributes_json.splice(i, 1);
    drawAttributes();
}

function attrDataChange(i, data, val)
{
    storage = assignment_attributes_json[i];
    storage[data]=val;
    drawAttributes();
}

function addAttribute()
{
    if( $("#step_2_2").attr('is_visible')=='n' )return;
    add_row = $('#add_new_attr');
    Cmark = $( add_row.find('input')[1] ).val();
    Cname = $( add_row.find('input')[0] ).val();

    if( Cname=='' || Cmark=='' || parseInt(Cmark)!=Cmark)   
        {
        alert('Invalid values !');
        return;
    }

    C = {"assignment_id":"","attribute_marks":Cmark,"attribute_name":Cname};
    assignment_attributes_json.push(C);

    drawAttributes();
}

///// classes
function refresh_BSC(id)
{
    C = $("#"+id).val();
    T = $('#'+id+'  option[value="'+C+'"]').text();
    $($("#"+id).parent().find('span')[0]).text(T);
}

function initClasses()
{
    CHR = $(".classes_holder_row").clone();
    $(".classes_holder_row").remove();

    OPTION_E = $(".classes_select_option").clone();
    $(".classes_select_option").remove();

    if(disableclasses=="1")
        { 
        disableClassesEdition();
    }

    drawClassesYearsOpt();
    drawClassesSubjectsOpt($("#classes_year_select").val());

    search:
    for(var c=0; c<classes_years_json.length; c++)
    {
        for(var cc=0; cc<classes_years_json[c].subjects.length; cc++)
        {
            for(var cccheck=0; cccheck<classes_years_json[c].subjects[cc].classes.length; cccheck++)
            {
                if(classes_years_json[c].subjects[cc].classes[cccheck].id==selected_classes_data[0]) 
                    {
                    $("#classes_year_select").val(c);

                    refresh_BSC("classes_year_select");

                    drawClassesSubjectsOpt($("#classes_year_select").val());

                    $("#classes_subject_select").val(classes_years_json[c].subjects[cc].subject_id);
                    refresh_BSC("classes_subject_select")

                    break search;
                }
            }
        }
    }

    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
}

function disableClassesEdition()
{
    $("#classes_subject_select").attr('disabled', 'disabled');
    $("#classes_year_select").attr('disabled', 'disabled');

    if(datepast != "1")
        {
        $("#step_3_1").fadeTo( "fast", fadeval );
        $("#step_3_1_a").fadeTo( "fast", fadeval );
    }

}

function Y_changed()
{
    drawClassesSubjectsOpt($("#classes_year_select").val());
    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
}

function S_changed()
{
    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
}

function drawClassesYearsOpt()
{

    $('#classes_year_select').html("");

    for(i=0; i<classes_years_json.length; i++)
    {
        opt = OPTION_E.clone();
        opt.attr('value', i);
        opt.text('Year '+classes_years_json[i].year);

        $('#classes_year_select').append(opt);

    }

    refresh_BSC("classes_year_select");
}

function drawClassesSubjectsOpt(y)
{

    $('#classes_subject_select').html("");

    if(classes_years_json[y])yeardata = classes_years_json[y].subjects;else yeardata = [];
    for(i=0; i<yeardata.length; i++)
    {
        opt = OPTION_E.clone();
        opt.attr('value', yeardata[i].subject_id);
        opt.text(yeardata[i].subject_name);

        $('#classes_subject_select').append(opt);
    }

    $('#classes_subject_select').val(yeardata[0].subject_id);
    refresh_BSC("classes_subject_select");
}

function getClasses(Y_index, S)
{

    if(classes_years_json[Y_index])C_subj = classes_years_json[Y_index].subjects;else C_subj = []; 

    S_index = 0;
    for(var c=0; c<C_subj.length; c++)
    {
        if(C_subj[c].subject_id==S)S_index = c;
    }
    if(C_subj[S_index])onNewClasses(C_subj[S_index].classes);

}

function onNewClasses(cls_res)
{
    $('#classes_holder').html("");

    for(var c=0; c<cls_res.length; c++)
    {

        if(selected_classes_data.indexOf(cls_res[c].id) != -1)checked=true; else checked=false;

        EL = CHR.clone();
        cb = $(EL.find("input")[0]);
        lb = $(EL.find("label")[0]);

        cb.attr('value', cls_res[c].id);
        cb.attr('id',  'cb_classes_'+cls_res[c].id);
        cb.prop('checked', checked);
        if(disableclasses==1)cb.prop('disabled', true);
        lb.attr('for', 'cb_classes_'+cls_res[c].id);
        lb.html(cls_res[c].year+""+cls_res[c].group_name);

        $("#classes_holder").append(EL);
    }
}

function confirmPublish()
{
    if(disablepublishandsave=="1")return;

    $('#popupPublBT').attr('do', '1');

    if( $('#publish').val()=='1' ) {
        $( $('#popupPubl').find('p')[0] ).text('Are you sure you want to publish to Students?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    } else {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to unpublish this assignment?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    }
    $('#popupPubl').modal('show');
}

function confirmPublishMarks()
{
    $('#popupPublBT').attr('do', '2');

    if( $('#publishmarks').val()=='1' )
        {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to publish this marks?');
        $( $('#popupPubl').find('h4')[0] ).text('');

    }else
        {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to unpublish this marks?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    }
    $('#popupPubl').modal('show');
}

function doPubl()
{
    $('#popupPubl').modal('hide');

    if( $('#popupPublBT').attr('do')=="1" ) {
        saveNewAssigment('save');
    }else if($('#popupPublBT').attr('do')=="2") {
        saveNewAssigment('savemarks');
    }else {
        $('#server_require_agree').val("1");
        saveNewAssigment('save');
    }
}

function undoPubl(){
 
    if($('#popupPublBT').attr('do')=="1" || $('#popupPublBT').attr('do')=="2") {
        if($('#popupPublBT').attr('do')=="1") {
            pblid='publish';
            pnlbtnid='publish_btn';
            label_0='PUBLISH';
            label_1='PUBLISHED';
        }else if($('#popupPublBT').attr('do')=="2") {
            pblid='publishmarks';
            pnlbtnid='publishmarks_btn';
            label_0='PUBLISH MARKS';
            label_1='PUBLISHED MARKS';
        }

        if( $('#'+pblid).val()=='1' ) {
            $('input[name='+pblid+']').val('0');
            $("#"+pnlbtnid).removeClass('active').text(label_0);
        }else {
            $('input[name='+pblid+']').val('1');
            $("#"+pnlbtnid).addClass('active').text(label_1);
        }
    }else {
    }
    $('#popupPubl').modal('hide');
}

function redirectToMode(m)
{

    document.location=m;
}

function saveNewAssigment(action) {

    vs = validate_slider();
    if(vs==1) {
        return false;
    }

    if( disablepublishandsave == "1" && action != "savemarks" ) return;
    action_url = action;
    GRADE_TYPE_TMP = $('#grade_type').attr('disabled');
    $('#grade_type').removeAttr('disabled');
    //return;

    classes = [];
    $('#classes_holder input').each(function( index )  {
        E = $(this);
        if( E.prop('checked') )classes.push( E.attr('value') );
    });

    $('#class_id').val(classes.join(','));

    $('#categories').val(JSON.stringify(assignment_categories_json));
    $('#attributes').val(JSON.stringify(assignment_attributes_json));

    $($($('#message').find("div")[0]).find("div")[0]).html('&nbsp;&nbsp;Saving Data ...');

    $('#message').modal('show');

    $.ajax({
        type: "POST",
        url: "/f2b_teacher/"+action_url,
        data: $("#form_assignment").serialize(), 
        success: function(data) {
            if(GRADE_TYPE_TMP=='disabled')$('#grade_type').attr('disabled', true);
            $('#server_require_agree').val("0");

            if(data.ok==1 || data.ok==2) {
                assignment_id = data.id;

                if(mode==1) {
                    if($("#publish").val()==1) {
                        $($($('#message').find("div")[0]).find("div")[0]).hide();

                        showFooterMessage({mess: 'Successfully Published', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700,
                                onFinish : 'redirectToMode(\'/f2b_teacher/index/'+assignment_id+'\')'
                        });

                    } else {
                        $('#assignment_id').val(data.id);
                        $('#message').modal('hide');
                        showFooterMessage({mess: 'Assignment was saved!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700});
                    }
                } else {
                    if($("#publish").val()==0) {
                        $($($('#message').find("div")[0]).find("div")[0]).hide();

                        showFooterMessage({mess: 'Successfully Unpublished!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700,
                                onFinish : 'redirectToMode(\'/f2c_teacher/index/'+assignment_id+'\')'
                        });
                    } else {
                        if(data.ok==2)redirect = 'redirectToMode(\'/f2b_teacher/index/'+assignment_id+'\')';else redirect=false;

                        if(datepast==1) {
                            if($("#publishmarks").val()==0)message= 'Marks Unpublished';else message= 'Marks Published';

                        }else {
                            message= 'Assignment was saved!';
                        }

                        $('#assignment_id').val(data.id);
                        $('#message').modal('hide');
                        showFooterMessage({mess: message, clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700,
                                onFinish : redirect
                        });
                    }
                }
            } else {
                $('#message').modal('hide');

                if(mode==1 && data.mess[0] != 'confirm:cats') {
                    $('input[name=publish]').val('0');
                    $("#publish_btn").removeClass('active').text('PUBLISH');
                }

                if(data.mess[0] == 'confirm:cats') {
                        //$('#popupPubl').modal('hide');
                    $( $('#popupPubl').find('p')[0] ).html('Please confirm you wish to change the Mark Categories.<br>All markings against marked submissions will be lost');
                    $( $('#popupPubl').find('h4')[0] ).text('');

                    $('#popupPublBT').attr('do', '3');

                    $('#popupPubl').modal('show');
                }  else  {
                        //mess.join('0')
                    showFooterMessage({mess: data.mess.join('<br>'), clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
                }
            }
        }
    });
}

function saveAndAddResource() {
    if(disableresource==1)return;
    saveAssigment('saveaddresource');
}

function saveAssigment(action) {

    action_url = action;
    if(published==1)publ=1;else publ = 0;
    if(action=='saveaddresource') action_url += ('/'+publ);

    classes = [];
    $('#classes_holder input').each(function( index )
        {
            E = $(this);
            if( E.prop('checked') )classes.push( E.attr('value') );
    });

    $('#class_id').val(classes.join(','));

    $('#categories').val(JSON.stringify(assignment_categories_json));
    $('#attributes').val(JSON.stringify(assignment_attributes_json));

    //$('#form_assignment').submit();

    $($('#message').find("div")[0]).html('Saving Data ...');
    //$('#message').popup('open');

    $.ajax({
        type: "POST",
        url: "/f2b_teacher/save",
        data: $("#form_assignment").serialize(), 
        success: function(data) {
        //$('#message').popup('close');

            if(data.ok==1) {
                if(action=='saveaddresource') {
                    assignment_id = data.id;
                    document.location="/c1/index/assignment/"+assignment_id;
                    return;
                }

                if(mode==1) {
                    $($('#message_b').find("div")[0]).html('Assignment saved successfully !');
                    $('#message_b').popup('open');
                    $('#message_b').delay( 800 ).fadeOut( 500, function() {
                        $('#message_b').popup('close');
                        $('#message_b').fadeIn( 1 );
                    });

                    assignment_id = data.id;
                    $('#assignment_id').val(data.id);

                    if(action=='savepublish') {
                        document.location="/f2b_teacher/index/"+assignment_id;
                        return;
                    }
                }else {
                    document.location="/f1_teacher";
                }
            }else {
                alert(data.mess.join('\n'));
            }
        }
    });
}


function init() {

    if(datepast==1 && mode==2) initpastdateScreen();

    initClasses();
    initCategories();
    gradeTypeChange();
    initAttributes();
    if(mode==1) initunpublishedScreen();else initpublishedScreen();

    if(datepast==1 && mode==2) initpastdateScreen();

}

$(document).ready(function() {
    init();
});


$(function() {
    $('.datepicker').datepicker({dateFormat: 'yy-mm-dd' });   
    $('.show_picker').click(function(){
//    console.log('click');
        $( ".datepicker" ).datepicker("show");
    });
});
$(document).ready(function() {

    $('#deadline_time').blur(function(){
        var val = this.value;

        var res = val.slice(0, this.selectionStart).length;
        if(res<3) {
            $(this).removeClass('right_p').addClass('left_p');    
        } else if(res>=3) {
            $(this).removeClass('left_p').addClass('right_p');
        }
    })

    $('.u').click(function(){
        if($('#deadline_time').hasClass('left_p')) {
            var str = $('#deadline_time').val();
            var res = str.substring(0, 2); 
            res= parseInt(res)+1;

            if(res>24) {
                res = 1;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(2, 20); 

            $('#deadline_time').html('').val(res+end);
        } else if($('#deadline_time').hasClass('right_p')) {
            var str = $('#deadline_time').val();
            var res = str.substring(3, 5); 

            res= parseInt(res)+1;

            if(res>59) {
                res = 0;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(0, 3); 

            $('#deadline_time').html('').val(end+res);
        } else {
            var str = $('#deadline_time').val();
            var res = str.substring(0, 2); 
            res= parseInt(res)+1;

            if(res>24) {
                res = 1;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(2, 20); 

            $('#deadline_time').html('').val(res+end);
//            $('#deadline_time').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);   
        }
    }) 
    $('.b').click(function(){
        if($('#deadline_time').hasClass('left_p')) {
            var str = $('#deadline_time').val();
            var res = str.substring(0, 2); 
            res= parseInt(res)-1;

            if(res<1) {
                res = 24;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(2, 20); 

            $('#deadline_time').html('').val(res+end);
        } else if($('#deadline_time').hasClass('right_p')) {
            var str = $('#deadline_time').val();
            var res = str.substring(3, 5); 
            res= parseInt(res)-1;
//console.log(res.toString().length);
            if(res<1) {
                res = 59;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(0, 3); 

            $('#deadline_time').html('').val(end+res);
        }  else {
            var str = $('#deadline_time').val();
            var res = str.substring(0, 2); 
            res= parseInt(res)-1;

            if(res<1) {
                res = 24;
            }

            if(res.toString().length<2) {
                res = '0'+res;
            }
            var end = str.substring(2, 20); 

            $('#deadline_time').html('').val(res+end);
//            $('#deadline_time').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);   
        }
    }) 
})


// remove resource
function publishModal(res) {

    $('#message').modal('hide');
    $( $('#popupDelRes').find('p')[0] ).html('Please confirm you would like to remove this Resource');

    $( $('#popupDelRes').find('h4')[0] ).text('');
    $( "#popupDelRes .res_id" ).val(res);
    $('#popupDelRes').modal('show');
}

function doDelRes() {
    var res_id = $( "#popupDelRes .res_id" ).val();
    $.post('/f2b_teacher/removeResource', { assignment_id: $( "#assignment_id" ).val(), resource_id: res_id }, function(r, textStatus) {

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
