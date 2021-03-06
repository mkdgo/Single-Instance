var CHR;
var OPTION_E;
var CAT;
var ATTR;
var STEPDOT;
var crr_step = 0;
var disableresource = "0";
var disablecategories = "0";
var disablegrade = "0";
var disablenext = "0";
var disableprev = "0";
var disableclasses = "0";
var disablepublishandsave = "0";
var fadeval = 0.25;

var steps_data = [
    {'text': 'Step 1: Assignment Description & Accompanying Resources'},
    {'text': 'Step 2: Mark Categories & Grade Thresholds'},
    {'text': 'Step 3: Select Classes and Set Deadlines'}
];
var slidestepway = 1;
var slidestep = 0;

function updateSlideHeight(sid) {
    var actli = $($(sid).parent());
    if (mode == 1) {
        $('.slides').css('height', actli.outerHeight()+250);
    }
}

function SlideCompleted() {
    slidestep = slidestep + Number(slidestepway);
    if (slidestep == '3') {
        $('#publish_btn').show();
    }
}

function initpublishedScreen() {
    $("article > header").hide();
    $(".slides > li").css("list-style", "none");
    $(".buttons.clearfix").hide();
    $("#saveBT").text('SAVE');

    var c_A = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
    var c_B = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';

    $('#step_1_1').attr('class', c_A);
    $('#step_1_2').attr('class', c_B);

    $('#step_2_1').attr('class', c_A);
    $('#step_2_2').attr('class', c_B);

    $('#step_3_1').attr('class', c_A);
    $('#step_3_2').attr('class', c_B);
}

function initunpublishedScreen() {
    $('#publish_btn').css('opacity','0.4');
    $('.slide_ctrl_prev').css('opacity','0.2');
    $('.slide_ctrl_next').css('opacity','1');
    disablepublishandsave = 1;
    disableprev = 1;
    $(".buttons.clearfix").hide();
    $('#publish_btn').show();

    $("#saveBT").text('SAVE AS A DRAFT');
    $('.slider').noosSlider({ autoAnimate: 0 });

    var c_A = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
    var c_B = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';

    $('#step_1_1').attr('class', c_A);
    $('#step_1_2').attr('class', c_B);

    $('#step_2_1').attr('class', c_A);
    $('#step_2_2').attr('class', c_B);

    $('#step_3_1').attr('class', c_A);
    $('#step_3_2').attr('class', c_B);

    $('.btn.b2.right.next-step.nav.next').attr('onClick', 'slideStep(\'1\')');
    $('.btn.b2.left.prev-step.nav.prev').attr('onClick', 'slideStep(\'-1\')');

    if (mode == 1) {
        $('#assignment_intro').attr('onkeydown', 'updateSlideHeight(".step.s1")');
        updateSlideHeight(".step.s1");
    }
}

function initpastdateScreen() {
    $("#publishmarks_btn").show();
    if (datepast == "1") {
        disablecategories="0";
        disableresource="1";
        disablegrade="1";
        disableclasses="1";
        disablepublishandsave="1";
    }

    $(".slider input, .slider textarea").attr('readonly', true);
    $('#grade_type').attr('disabled', true);
    $(".slider").fadeTo( "fast", fadeval);
    $("#publish_btn").off('click');

    $("#saveBT").fadeTo( "fast", fadeval );
    $("#publish_btn").off('mouseenter mouseleave');

    $('.btn.b1.right').hide();
    $('.btn.remove').hide();
    $('#add_cat_link').hide();
    initPublishButton('#publishmarks_btn', 'publishmarks', 'PUBLISH MARKS', 'PUBLISH MARKS');
}

function slideStep(w) {
    if( $('#grade_categories_holder tr').length > 0 ) {
        $('.add_cat #mark').removeClass('required');
        $('.add_cat #catg').removeClass('required');
    }
    slidestepway = Number(w);
    $("#publish_btn").off('click');
}

function gradeTypeChange() {
    if( $('#grade_type').val() == 'offline' ) {
        $("#step_2_1").css('display', 'none');
        $("#step_2_1n").show();
        
        $("#publishmarks_btn").css('display', 'none');
        $.each( $('.table2_s').find('a.st-link'), function(index, value) {
            $(this).attr('onclick', 'return false');
            $(this).css('text-decoration', 'none').css('cursor','default');
        })
    } else {
        $("#step_2_1n").hide();
        $("#step_2_1").css('display', 'block');
        $("#publishmarks_btn").css('display', 'inline-block');
        $.each( $('.table2_s').find('a.st-link'), function(index, value) {
            $(this).attr('onclick', '');
            $(this).css('text-decoration', '').css('cursor','pointer');
        })
    }
    if(disablegrade=="1") {
        $("#step_2_2").attr('is_visible', 'n');
    } else if( $('#grade_type').val()=='grade' ) { 
        $("#step_2_2").attr('is_visible', 'y'); 
    } else {
        $("#step_2_2").attr('is_visible', 'n');
    }
    setGradeActivity();
}

function setGradeActivity() {
    if(true) {
        if( $("#step_2_2").attr('is_visible')=='n' ) {   
            $("#step_2_2").fadeTo( "fast", fadeval );
            $("#step_2_2").hide();
            $("#step_2_2 input").prop('disabled', true);
            $("#step_2_2 .add_attr").hide(100);
        } else {
            $("#step_2_2 input").prop('disabled', false);
            $("#step_2_2").fadeTo( "fast", 1 );
            $("#step_2_2 .add_attr").show(100);
            $("#step_2_2").show();
        }
    }
}

function initCategories() {
    CAT = $('#grade_categories_row').clone();
    $('#grade_categories_row').remove();
    drawCategoories();
}

function drawCategoories() {
    $('#grade_categories_holder').html("");
    total = 0;
    if( assignment_categories_json.length == 0 ) {
        $('.add_cat .mark').on('keyup', function(){
            input = $(this);
            if( input.val().length > 0 && !$.isNumeric( input.val() ) ) {
                $('.status_mark').removeClass('correct');
                $('.status_mark').addClass('incorrect');
                input.val( input.val().slice(0,-1));
                setTimeout(function () {
                    $('.status_mark').removeClass('incorrect');
                }, 1000);
            } else if(input.val().length > 0 && $.isNumeric( input.val() ) ) {
                $('.status_mark').addClass('correct');
            } else if(input.val().length == 0) {
                $('.status_mark').removeClass('correct');
            }
        })
    } else {
        $('.add_cat #mark').removeClass('required');
        $('.add_cat #catg').removeClass('required');
        var len = assignment_categories_json.length-1;
        for( var i = len; i >= 0 ; i-- ) {
            opt = CAT.clone();

            opt.attr('id', 'grade_categories_row_'+i);
            $( opt.find('a')[0] ).attr('onClick', 'delCategory('+i+')');

            $( opt.find('input')[0] ).val(assignment_categories_json[i].category_name);
            $( opt.find('input')[0] ).attr('onChange', 'catDataChange('+i+', "category_name", $(this).val() )');
            $( opt.find('input')[0] ).css('padding', '6px');

            $( opt.find('input')[1] ).val(assignment_categories_json[i].category_marks);
            $( opt.find('input')[1] ).attr('onChange', 'catDataChange('+i+', "category_marks", $(this).val() )');
            $( opt.find('input')[1] ).css('padding', '6px');

            if(i!=0)opt.css('border-top', 'none');
            if(assignment_categories_json[i].category_marks) total += parseInt(assignment_categories_json[i].category_marks);

            $('#grade_categories_holder').append(opt);
            $('#grade_categories_holder .mark').on('keyup', function(){
                input = $(this);
                if( input.val().length > 0 && !$.isNumeric( input.val() ) ) {
                    input.css({'border':'1px dashed #f00'});
                    var msg = 'Only digits allowed!';
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
                    input.val( input.val().slice(0,-1));
                    input.prev('span.tip2').fadeOut(4000);
                    input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"});
                }
            })
            $('.add_cat .mark').on('keyup', function(){
                input = $(this);
                if( input.val().length > 0 && !$.isNumeric( input.val() ) ) {
                    $('.status_mark').removeClass('correct');
                    $('.status_mark').addClass('incorrect');
                    input.val( input.val().slice(0,-1));
                    setTimeout(function () {
                        $('.status_mark').removeClass('incorrect');
                    }, 1000);
                } else if(input.val().length > 0 && $.isNumeric( input.val() ) ) {
                   $('.status_mark').addClass('correct');
                } else if(input.val().length == 0) {
                    $('.status_mark').removeClass('correct');
                }
            })
        }
    }

    $('.add_cat input[type="text"]').focus(function(){
        $(this).parent().parent().css({'background-color': '#999'});
    })
    $('.add_cat input[type="text"]').focusout(function(){
        $(this).parent().parent().css({'background-color': '#999'});
    })
    $("#marksTotal").html('<div class="pr_title" style="color: black;padding: 5px 0px 5px 0px;font-weight: bold; float: left;">Total Marks: </div><div class="pr_title" style="padding: 5px 0px 5px 30px;font-weight: bold; float: left;">'+total+'</div>');

    if (mode == 1) { updateSlideHeight('.step.s2'); }

    $('#catg').on('keydown',  function(e) {
        var keyCode = e.keyCode || e.which;
        if ((keyCode == 9) || (keyCode == 13)) {
            e.preventDefault();
            $('.status_mark').removeClass('incorrect');
            if($(this).val().length>0 && $('#mark').val().length==0){
                $('#mark').focus();
            } else if($(this).val().length>0 && $('#mark').val().length>0) {
                addCategory($(this).val(),$('#mark').val());
                $(this).val('');
                $('#mark').val('');
                $('#catg').focus();
                $('.status_mark').removeClass('incorrect');
                $('.status_mark').removeClass('correct');
            } else if($(this).val().length==0 && $('#mark').val().length==0) {
                $('.status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('.status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    });
    $('#mark').on('keydown',  function(e) {
        var keyCode = e.keyCode || e.which;
        if ((keyCode == 9) || (keyCode == 13)) {
            e.preventDefault();
            $('.status_mark').removeClass('incorrect');
            if($(this).val().length>0 && $('#catg').val().length==0){
                $('#catg').focus();
                $('.status_mark').removeClass('correct');
            } else if($(this).val().length>0 && $('#catg').val().length>0) {
                addCategory($('#catg').val(),$(this).val());
                $(this).val('');
                $('#catg').val('');
                $('#catg').focus();
                $('.status_mark').removeClass('correct');
                $('.status_mark').removeClass('incorrect');
            } else if($(this).val().length==0 && $('#catg').val().length==0) {
                $('.status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('.status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    });

    $('.status_mark').on('click',function(){
        if($(this).hasClass('correct')) {
            if($.isNumeric($('#mark').val()) && $('#catg').val().length>0) {
                addCategory($('#catg').val(),$('#mark').val());
                $(this).removeClass('correct');
                $('#catg').val('');
                $('#mark').val('');
                $('#catg').focus();
            } else if($('#mark').val().length ==0 || $('#catg').val().length==0) {
                $('.status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('.status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    })
}

function delCategory(i) {
    if(disablecategories=="1")return;
    assignment_categories_json.splice(i, 1);
    drawCategoories();
    removeCategoryField();
}

function catDataChange(i, data, val) {
    if(disablecategories=="1")return;
    storage = assignment_categories_json[i];
    storage[data]=val;
    drawCategoories();
    removeCategoryField();
}

function addCategory(name,mark) {
    if(disablecategories=="1")return;

    if(assignment_categories_json.length>0) {
        add_row = $('#grade_categories_row_' + (assignment_categories_json.length - 1));

        el_name = $(add_row.find('input')[0]);
        el_mark = $(add_row.find('input')[1]);

        Cmark = $(add_row.find('input')[1]).val();
        Cname = $(add_row.find('input')[0]).val();

        if (Cname.trim() == '' || Cname === undefined) {
            el_name.css({'border': '1px dashed red'});
            var msg = el_name.attr('data-validation-required-message');
            el_name.prev('span').attr('id', 'scrolled');
            el_name.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
            el_name.prev('span').removeAttr('scrolled');
            el_name.prev('span').focus();
            el_name.prev('span.tip2').fadeOut(6000);
            el_name.css({"border-color": "#c8c8c8", "border-width": "1px", "border-style": "solid"});
            return;
        }

        if (Cmark.trim() == '' || Cmark === undefined) {
            el_mark.css({'border': '1px dashed red'});
            var msg = el_mark.attr('data-validation-required-message');
            el_mark.prev('span').attr('id', 'scrolled');
            el_mark.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display': 'block'});
            el_mark.prev('span').removeAttr('scrolled');
            el_mark.prev('span').focus();
            el_mark.prev('span.tip2').fadeOut(6000);
            el_mark.css({"border-color": "#c8c8c8", "border-width": "1px", "border-style": "solid"});
            return;
        }
    }

    opt = CAT.clone();

    opt.attr('id', 'grade_categories_row_'+assignment_categories_json.length);
    $( opt.find('a')[0] ).attr('onClick', 'delCategory('+assignment_categories_json.length+')');
    $( opt.find('input')[0] ).attr('value',mark);
    $( opt.find('input')[0] ).attr('onChange', 'catDataChange('+assignment_categories_json.length+', "category_name", $(this).val() )');
    $( opt.find('input')[0] ).attr('class', 'required');

    $( opt.find('input')[1] ).attr('value',name);
    $( opt.find('input')[1] ).attr('onChange', 'catDataChange('+assignment_categories_json.length+', "category_marks", $(this).val() )');
    $( opt.find('input')[1] ).addClass('class', 'required');

    $('#grade_categories_holder').prepend($(opt));
    C = {"assignment_id":"","category_marks":$( opt.find('input')[0] ).val(),"category_name":$( opt.find('input')[1] ).val()};

    assignment_categories_json.push(C);
    drawCategoories();
}

function addCategoryField() {
    if(disablecategories=="1")return;
    $('#add_new_cat').show();
    if (mode == 1) { updateSlideHeight('.step.s2'); }
}

function preRemoveCategoryField() {
    $('#catg').val('');
    $('#mark').val(''); 
    removeCategoryField();
}

function removeCategoryField() {
    $('#add_new_cat').hide();
    $('#add_cat_link').show();
    if(mode==1)updateSlideHeight('.step.s2');
}

/*//////// attributes */
function initAttributes() {

    $('#grade_holder input[type="text"]').focus(function(){
        $(this).parent().parent().css({'background-color': '#999'});
    })
    $('#grade_holder input[type="text"]').focusout(function(){
        $(this).parent().parent().css({'background-color': '#999'});
    })

    $('#add_grade_attribute_name').on('keydown',  function(e) {
        var keyCode = e.keyCode || e.which;
        if ((keyCode == 9) || (keyCode == 13)) {
            e.preventDefault();
            $('#grade_holder .status_mark').removeClass('incorrect');
            if($(this).val().length>0 && $('#add_grade_attribute_value').val().length==0){
                $('#add_grade_attribute_value').focus();
            } else if($(this).val().length>0 && $('#add_grade_attribute_value').val().length>0) {
                addAttribute();
                $(this).val('');
                $('#add_grade_attribute_value').val('');
                $('#add_grade_attribute_value').focus();
                $('#grade_holder .status_mark').removeClass('incorrect');
                $('#grade_holder .status_mark').removeClass('correct');
            } else if($(this).val().length==0 && $('#add_grade_attribute_value').val().length==0) {
                $('#grade_holder .status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('#grade_holder .status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    });
    $('#add_grade_attribute_value').on('keydown',  function(e) {
        var keyCode = e.keyCode || e.which;
        if ((keyCode == 9) || (keyCode == 13)) {
            e.preventDefault();
            $('#grade_holder .status_mark').removeClass('incorrect');
            if($(this).val().length>0 && $('#add_grade_attribute_name').val().length==0){
                $('#add_grade_attribute_value').focus();
                $('#grade_holder .status_mark').removeClass('correct');
            } else if($(this).val().length>0 && $('#add_grade_attribute_value').val().length>0) {
                addAttribute();
                $(this).val('');
                $('#add_grade_attribute_name').val('');
                $('#add_grade_attribute_name').focus();
                $('#grade_holder .status_mark').removeClass('correct');
                $('#grade_holder .status_mark').removeClass('incorrect');
            } else if($(this).val().length==0 && $('#catg').val().length==0) {
                $('#grade_holder .status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('#grade_holder .status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    });

    $('#grade_holder .status_mark').on('click',function(){
        if($(this).hasClass('correct')) {
            if($.isNumeric($('#add_grade_attribute_value').val()) && $('#add_grade_attribute_name').val().length>0) {
                addAttribute()
                $(this).removeClass('correct');
                $('#add_grade_attribute_name').val('');
                $('#add_grade_attribute_value').val('');
                $('#add_grade_attribute_name').focus();
            } else if($('#add_grade_attribute_value').val().length ==0 || $('#add_grade_attribute_name').val().length==0) {
                $('#grade_holder .status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('#grade_holder .status_mark').removeClass('incorrect');
                }, 1000);
            } else if($('#add_grade_attribute_value').val().length >0 && $('#add_grade_attribute_name').val().length==0) {
                $('#add_grade_attribute_name').focus();
                $('#grade_holder .status_mark').removeClass('correct');
                $('#grade_holder .status_mark').addClass('incorrect');
                setTimeout(function () {
                    $('#grade_holder .status_mark').removeClass('incorrect');
                }, 1000);
            }
        }
    })

    ATTR = $('#grade_attr_row').clone();
    $('#grade_attr_row').remove();

    if(assignment_id==-1 || assignment_attributes_json.length == 0 ) {
        def_attr = [
            {"assignment_id":"0","attribute_name":"A","attribute_marks":"80"},
            {"assignment_id":"0","attribute_name":"B","attribute_marks":"65"},
            {"assignment_id":"0","attribute_name":"C","attribute_marks":"55"},
            {"assignment_id":"0","attribute_name":"D","attribute_marks":"45"},
            {"assignment_id":"0","attribute_name":"E","attribute_marks":"35"},
            {"assignment_id":"0","attribute_name":"F","attribute_marks":"25"}
        ];

        assignment_attributes_json = def_attr;
    }

    $('#add_grade_attribute_value').on('keyup', function() {
        input = $(this);
        if( input.val().length > 0 && !$.isNumeric( input.val() ) ) {
            $('#grade_holder .status_mark').addClass('incorrect');
            setTimeout(function () {
                $('#grade_holder .status_mark').removeClass('incorrect');
            }, 1000);
            input.val( input.val().slice(0,-1));
        } else if( input.val().length > 0 && $.isNumeric( input.val() ) ) {
            $('#grade_holder .status_mark').addClass('correct');
        }
    });

    drawAttributes();
}

function drawAttributes() {
    if($('#grade_attr_holder_preview').length>=1) {
        $('#grade_attr_holder_preview').html("");
        for( i = 0; i < assignment_attributes_json.length; i++) {
            $('#grade_attr_holder_preview').append('<div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;"><div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">' + assignment_attributes_json[i].attribute_name + ': </div><div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">'+ assignment_attributes_json[i].attribute_marks + '</div></div>')
        }
    }

    $('#grade_attr_holder').html("");

    for( i = 0; i < assignment_attributes_json.length; i++) {
        opt = ATTR.clone();
        opt.attr('id', 'grade_attr_row_'+i);
        $( opt.find('a')[0] ).attr('onClick', 'delAttribute('+i+')');

        $( opt.find('input')[0] ).val(assignment_attributes_json[i].attribute_name);
        $( opt.find('input')[0] ).attr('onChange', 'attrDataChange('+i+', "attribute_name", $(this).val() )');
        $( opt.find('input')[0] ).css('padding','6px');

        $( opt.find('input')[1] ).val(assignment_attributes_json[i].attribute_marks);
        $( opt.find('input')[1] ).attr('onChange', 'attrDataChange('+i+', "attribute_marks", $(this).val() )');
        $( opt.find('input')[1] ).css('padding','6px');

        if(i!=0)opt.css('border-top', 'none');
        $('#grade_attr_holder').append(opt);
    }

    setGradeActivity();
    if(mode==1)updateSlideHeight('.step.s2');
}

function delAttribute(i) {
    if( $("#step_2_2").attr('is_visible')=='n' )return;
    assignment_attributes_json.splice(i, 1);
    drawAttributes();
}

function attrDataChange(i, data, val) {
    storage = assignment_attributes_json[i];
    storage[data]=val;
    drawAttributes();
}

function addAttribute() {
    var msg = '';

    if( $("#step_2_2").attr('is_visible')=='n' ) { return; }
    add_row = $('#grade_holder');
    el_aname = $( add_row.find('input')[0] );
    el_amark = $( add_row.find('input')[1] );
    Aname = $( add_row.find('input')[0] ).val();
    Amark = $( add_row.find('input')[1] ).val();

    if(Aname.trim()==''||Aname === undefined) {
        msg = 'Please fill in the grade name';
        el_aname.parent().css('position','relative');
        el_aname.parent().prepend('<span></span>');
        el_aname.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        el_aname.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"});
        return;
    } else if( Amark.trim() == '' || Amark === undefined ) {
        msg = 'Please fill in the grade value';
        el_amark.parent().css('position','relative');
        el_amark.parent().prepend('<span></span>');
        el_amark.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        el_amark.prev('span.tip2').fadeOut(4000);
        el_amark.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"});
        return;
    } else if( parseInt(Amark) != Amark ) {
        msg = 'Only digits allowed for the value';
        el_amark.parent().css('position','relative');
        el_amark.parent().prepend('<span></span>');
        el_amark.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        el_amark.prev('span.tip2').fadeOut(4000);
        el_amark.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"});
        return;
    }

    C = {"assignment_id":"","attribute_marks":Amark,"attribute_name":Aname};
    assignment_attributes_json.push(C);
    assignment_attributes_json.sort(dynamicSort('attribute_marks'));
    drawAttributes();
}

/*//// classes */
function refresh_BSC(id) {
    C = $("#"+id).val();
    T = $('#'+id+' option[value="'+C+'"]').text();
    $($("#"+id).parent().find('span')[0]).text(T);
}

function initClasses() {
    CHR = $(".classes_holder_row").clone();
    $(".classes_holder_row").remove();

    OPTION_E = $(".classes_select_option").clone();
    $(".classes_select_option").remove();

    if(disableclasses=="1") { 
        disableClassesEdition();
    }
    drawClassesYearsOpt();
    drawClassesSubjectsOpt($("#classes_year_select").val());
    search:
    for(var c=0; c<classes_years_json.length; c++) {
        for(var cc=0; cc<classes_years_json[c].subjects.length; cc++) {
            for(var cccheck=0; cccheck<classes_years_json[c].subjects[cc].classes.length; cccheck++) {
                if(classes_years_json[c].subjects[cc].classes[cccheck].id==selected_classes_data[0]) {
                    $("#classes_year_select").val(c);
                    refresh_BSC("classes_year_select");
                    drawClassesSubjectsOpt($("#classes_year_select").val());
                    if(classes_years_json[c].subjects[cc].classes[cc]!=undefined) {
                        $('<span class="pr_title" style="font-weight: normal">' + classes_years_json[c].subjects[cc].classes[cc].year +' '+ classes_years_json[c].subjects[cc].classes[cc].group_name + '</span>&nbsp;'+' ').appendTo('.last_d');
                    }
                    $("#classes_subject_select").val(classes_years_json[c].subjects[cc].subject_id);
                    refresh_BSC("classes_subject_select");
                    break search;
                }
            }
        }
    }
    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
}

function disableClassesEdition() {
    $("#classes_subject_select").attr('disabled', 'disabled');
    $("#classes_year_select").attr('disabled', 'disabled');
    if(datepast != "1") {
        $("#step_3_1").fadeTo( "fast", fadeval );
        $("#step_3_1_a").fadeTo( "fast", fadeval );
    }
}

function Y_changed() {
    drawClassesSubjectsOpt($("#classes_year_select").val());
    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
    updateSlideHeight(".step.s3");
}

function S_changed() {
    getClasses($("#classes_year_select").val(), $("#classes_subject_select").val());
}

function drawClassesYearsOpt() {
    $('#classes_year_select').html("");
    for( i = 0; i < classes_years_json.length; i++) {
        opt = OPTION_E.clone();
        opt.attr('value', i);
        opt.text('Year '+classes_years_json[i].year);
        if(classes_years_json[i].year == selected_year) {
            opt.attr('selected', 'selected');
        }
        $('#classes_year_select').append(opt);
    }
    refresh_BSC("classes_year_select");
}

function drawClassesSubjectsOpt(y) {
    $('#classes_subject_select').html("");
    if(classes_years_json[y])yeardata = classes_years_json[y].subjects;else yeardata = [];
    for(i=0; i<yeardata.length; i++) {
        opt = OPTION_E.clone();
        opt.attr('value', yeardata[i].subject_id);
        opt.text(yeardata[i].subject_name);
        if(yeardata[i].subject_name == selected_subject) {
            opt.attr('selected', 'selected');
        }
        $('#classes_subject_select').append(opt);
    }
    $('#classes_subject_select').val(yeardata[0].subject_id);
    refresh_BSC("classes_subject_select");
}

function getClasses(Y_index, S) {
    if(classes_years_json[Y_index])C_subj = classes_years_json[Y_index].subjects;else C_subj = []; 

    S_index = 0;
    for(var c=0; c<C_subj.length; c++) {
        if(C_subj[c].subject_id==S)S_index = c;
    }
    if(C_subj[S_index])onNewClasses(C_subj[S_index].classes);
}

function onNewClasses(cls_res) {
    $('#classes_holder').html("");

    for(var c=0; c<cls_res.length; c++) {
        if(selected_classes_data.indexOf(cls_res[c].id) != -1)checked=true; else checked=false;
        EL = CHR.clone();
        cb = $(EL.find("input")[0]);
        lb = $(EL.find("label")[0]);

        cb.attr('value', cls_res[c].id);
        cb.attr('id',  'cb_classes_'+cls_res[c].id);
        cb.prop('checked', checked);
        if(disableclasses==1)cb.prop('disabled', true);
        lb.attr('for', 'cb_classes_'+cls_res[c].id);
        lb.html(cls_res[c].group_name);
        $("#classes_holder").append(EL);
    }
}

function confirmPublish() {
    if(disablepublishandsave=="1") return false;
    $('#popupPublBT').attr('do', '1');
    if( $('#publish').val()=='0' ) {
        $( $('#popupPubl').find('p')[0] ).text('Are you sure you want to publish to Students?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    } else {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to unpublish this assignment?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    }
    $('#popupPubl').modal('show');
}

function confirmPublishMarks() {
    $('#popupPublBT').attr('do', '2');
    if( $('#publishmarks').val() == 0 ) {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to publish the marks for this assignment?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    } else {
        $( $('#popupPubl').find('p')[0] ).text('Please confirm you wish to unpublish the marks for this assignment?');
        $( $('#popupPubl').find('h4')[0] ).text('');
    }
    $('#popupPubl').modal('show');
}

function doPubl(){
    $('#popupPubl').modal('hide');
    if( $('#popupPublBT').attr('do')=="1" ) {
        if( $('#publish').val()=='0' ) {
            $('#publish').val(1);
        } else {
            $('#publish').val(0);
        }
        if( validate_to_publish(1) ) {
            saveNewAssigment('save',1);
        } else {
            showFooterMessage({status: 'alert', mess: 'Some information is missing. Please complete all fields before Publishing!', clrT: '#6b6b6b', clr: '#fcaa57', anim_a:3000, anim_b:12700});
        }
    } else if($('#popupPublBT').attr('do')=="3") {
        saveMarks();
    } else {
        $('#server_require_agree').val("1");
        saveNewAssigment('save',1);
    }
}

function undoPubl(){
    if( $('#popupPublBT').attr('do') == "1" || $('#popupPublBT').attr('do') == "2" ) {
        if( $('#popupPublBT').attr('do') == "1" ) {
            pblid='publish';
            pnlbtnid='publish_btn';
            label_0='PUBLISH';
            label_1='PUBLISH';
        } else if($('#popupPublBT').attr('do')=="2") {
            pblid='publishmarks';
            pnlbtnid='publishmarks_btn';
            label_0='PUBLISH MARKS';
            label_1='PUBLISH MARKS';
        }
        if( $('#'+pblid).val()=='0' ) {
            $('input[name='+pblid+']').val('0');
            $("#"+pnlbtnid).removeClass('active').text(label_0);
        } else {
            $('input[name='+pblid+']').val('1');
            $("#"+pnlbtnid).addClass('active').text(label_1);
        }
    } else {
    }
    $('#popupPubl').modal('hide');
}

function redirectToMode(m) {
    document.location = m;
}

function saveNewAssigment(action, rtrn) {
    $('#org_publish_date').val($('#publish_date').val());
    $('#org_publish_time').val($('#publishbasicExample').val());
    if($('#grade_categories_holder tr').length > 0) {
        $('.add_cat #mark').removeClass('required');
        $('.add_cat #catg').removeClass('required');
    }
    vs = validate_as_draft(1);
    if( vs == 1 ) {
        return false;
    }
    if( !validate_to_publish(1) ) { return false; }
    action_url = action;
    GRADE_TYPE_TMP = $('#grade_type').attr('disabled');
    $('#grade_type').removeAttr('disabled');
    classes = [];
    $('#classes_holder input').each(function( index ) {
        E = $(this);
        if( E.prop('checked') )classes.push( E.attr('value') );
    });
    $('#class_id').val(classes.join(','));
    $('#categories').val(JSON.stringify(assignment_categories_json));
    $('#attributes').val(JSON.stringify(assignment_attributes_json));
    $($($('#message').find("div")[0]).find("div")[0]).html('&nbsp;&nbsp;Saving Data ...');
    $('#message').modal('show');

    $('#assignment_intro').val( nicEditors.findEditor('assignment_intro').getContent() );

    $.ajax({
        type: "POST",
        url: "/f2p_teacher/"+action_url,
        data: $("#form_assignment").serialize(),
        async: false,
        success: function(data) {
            if( GRADE_TYPE_TMP == 'disabled' ) { $('#grade_type').attr('disabled', true); }
            $('#server_require_agree').val("0");
            if( data.ok == 1 || data.ok == 2 ) {
                assignment_id = data.id;
                if( mode == 1 ) {
                    if($("#publish").val()==1) {
                        $('#message').modal('hide');
                        $($($('#message').find("div")[0]).find("div")[0]).hide();
                        if( rtrn == 1 ) {
                            if( data.warn.length > 0 ) {
                                showFooterMessage({status: 'alert', mess: data.warn.join('<br />'), clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
                            } else {
                                showFooterMessage({status: 'success', mess: 'Your changes have been saved successfully!', clrT: '#fff', clr: '#128c44', anim_a:200, anim_b:1700,
                                    onFinish : 'redirectToMode(\'/f2p_teacher/index/'+assignment_id+'\')'
                                });
                            }
                        }
                    } else {
                        $('#assignment_id').val(data.id);
                        $('#message').modal('hide');
                        assignment_categories_json = $.grep( assignment_categories_json, function( n, i ) {
                            return ( n.category_name == '' || n.category_marks < 1 );
                        }, true )
                        drawCategoories();
/*  //                        showFooterMessage({status: 'success', mess: 'Assignment was saved!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:170, */
                        if( rtrn == 1 ) {
                            showFooterMessage({status: 'success', mess: 'Your changes have been saved successfully!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700,
                                onFinish : 'redirectToMode(\'/f2c_teacher/index/'+assignment_id+'\')'
                            });
                        }
                    }
                } else {
                    if($("#publish").val()==0) {
                        $('#message').modal('hide');
                        $($($('#message').find("div")[0]).find("div")[0]).hide();
                        if( rtrn == 1 ) {
                            showFooterMessage({status: 'success', mess: 'Successfully Unpublished!', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700,
                                onFinish : 'redirectToMode(\'/f2c_teacher/index/'+assignment_id+'\')'
                            });
                        }
                    } else {
                        $('#message').modal('hide');
                        if(data.ok == 2 || data.pmarks == 1 ) { redirect = 'redirectToMode(\'/f2b_teacher/index/'+assignment_id+'\')'; } else { redirect = false; }
                        if(datepast==1 ) {
/*
                            if($("#publishmarks").val()==0) { 
                                message= 'Marks Unpublished';
                            } else { message= 'Marks Published'; }
//*/
                        } else {
                            message= 'Assignment was saved!';
                        }
                        $('#assignment_id').val(data.id);
                        if( rtrn == 1 ) {
                            showFooterMessage({status: 'success', mess: message, clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700, onFinish : redirect });
                        }
                    }
                }
            } else {
                $('#message').modal('hide');
                if( mode == 1 && data.mess[0] != 'confirm:cats') {
                    $('input[name=publish]').val('0');
                    $("#publish_btn").removeClass('active').text('PUBLISH');
                }
                if( data.mess[0] == 'confirm:cats' ) {
                    $( $('#popupPubl').find('p')[0] ).html('Please confirm you wish to change the Mark Categories.<br>All markings against marked submissions will be lost.');
                    $( $('#popupPubl').find('h4')[0] ).text('');
                    $('#popupPublBT').attr('do', '3');
                    $('#popupPubl').modal('show');
                }  else  {
                    showFooterMessage({status: 'alert', mess: data.mess.join('<br />'), clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
                }
            }
        },
        error: function(data) {
            $('#message').modal('hide');
            showFooterMessage({status: 'alert', mess: data.statusText, clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
        }
    });
}

function saveAndAddResource() {
    if( disableresource == 1 ) { return; }
    saveAssigment('saveaddresource');
}
/*
function addResource() {
    if(disableresource==1)return;
    saveAssigment('saveaddresource');
}
//*/
function saveAssigment(action) {
    action_url = action;
    if( published == 1 ) { publ = 1; } else { publ = 0; }
    if( action == 'saveaddresource' ) action_url += ('/'+publ);
    classes = [];
    $('#classes_holder input').each(function( index ) {
        E = $(this);
        if( E.prop('checked') )classes.push( E.attr('value') );
    });
    $('#class_id').val(classes.join(','));
    $('#categories').val(JSON.stringify(assignment_categories_json));
    $('#attributes').val(JSON.stringify(assignment_attributes_json));
    $('#assignment_intro').val( nicEditors.findEditor('assignment_intro').getContent() );
    
    /* $('#form_assignment').submit(); */

    $($('#message').find("div")[0]).html('Saving Data ...');
    /* $('#message').popup('open'); */

    $.ajax({
        type: "POST",
        url: "/f2b_teacher/save",
        data: $("#form_assignment").serialize(),
        async: false,
        success: function(data) {
        /* $('#message').popup('close'); */
            if( data.ok == 1 ) {
                if( action == 'saveaddresource' ) {
                    assignment_id = data.id;
                    document.location="/c1/index/assignment/"+assignment_id;
                    return;
                }
                if( mode == 1 ) {
                    $($('#message_b').find("div")[0]).html('Your changes have been saved successfully!');
                    $('#message_b').popup('open');
                    $('#message_b').delay( 800 ).fadeOut( 500, function() {
                        $('#message_b').popup('close');
                        $('#message_b').fadeIn( 1 );
                    });
                    assignment_id = data.id;
                    $('#assignment_id').val(data.id);
                    if( action == 'savepublish' ) {
                        document.location="/f2b_teacher/index/"+assignment_id;
                        return;
                    }
                } else {
                    document.location="/f1_teacher";
                }
            } else {
                showFooterMessage({status: 'alert', mess: data.mess, clrT: '#6b6b6b', clr: '#fcaa57', anim_a:2000, anim_b:1700});
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
    initunpublishedScreen();
/*    if( mode == 1 ) {
    } else {
        initpublishedScreen();
    }*/
//    if( datepast == 1 && mode==2) initpastdateScreen();
    if(datepast=="1") {
        $('#deadline_date').css('border','1px solid #f00').css('color', '#f00');
        $('#deadline_date').parent().parent().parent().find('.icon').addClass('past');
        $('#deadline_date').parent().parent().parent().find('.icon').css('border','1px solid #f00');
        $('#basicExample').css('color', '#f00');
        $('#basicExample').parent().parent().css('border','1px solid #f00').css('color', '#f00');
        $('#basicExample').parent().parent().parent().find('.a').css('border','1px solid #f00');
        $('#basicExample').parent().parent().parent().find('.a').addClass('past');
/*       disablecategories="1";
        disablecategories="0";
        disableresource="1";
        disablegrade="1";
        disableclasses="1";
        disablepublishandsave="1";*/
    }

    $('#popupPubl').keypress(function(e) {
        if( e.keyCode == $.ui.keyCode.ENTER ) {
/*              //Close dialog and/or submit here...
//console.log( 'ok' ); */
        }
    });
}

$(document).ready(function() {
    $('textarea').focus(function(){})
    $("div.nicEdit-main").on('paste', function(e) {
        setTimeout(function() {
            updateSlideHeight(".step.s1");            
        }, 100);
    });
    $('.resizable').each(function(){
        var t = this;
        var $t = $(t);

        $t.on('keyup',t, function(){
            var v = $(this).val();
            var to = $t.data('to');
/* //            if(to) clearTimeout(to); to = false; */
            if(to) { clearTimeout(to); }
            to = false;
            if(v){
                to = setTimeout(function(){}, 200);
            }
        }).on('keydown', t, function(e){
            var v = $(this).val();
            if(e.keyCode == 13 && v) {
                $(this).val('');
            }
        }).on('click', t, function(){
            var v = $(this).text();
            if(v) {
/* //                $('.input-container input', t).val(''); */
            }
        });
    });

    init();

    $('#deadline_time').blur(function(){
        var val = this.value;
        var res = val.slice(0, this.selectionStart).length;
        if(res < 3) {
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
            if(res.toString().length < 2 ) {
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
        $('#basicExample').timepicker("show");
    }) 

    $('.check_digit').on('keyup', function() {
        input = $(this);
        if( input.val().length > 0 && !$.isNumeric( input.val() ) ) {
            input.css({'border':'1px dashed #f00'});
            var msg = 'Only digits allowed!';
            input.parent().css('position','relative');
            input.parent().prepend('<span></span>');
            input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
            input.val( input.val().slice(0,-1));
            input.prev('span.tip2').fadeOut(4000);
            input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
        }
    });

    if( $('#grade_type').val() == 'offline' ) {
//        var s_tbl = $(this).parent().parent().parent().find(".hidden.q_option");
        $.each( $('.table2_s').find('a.st-link'), function(index, value) {
            $(this).attr('onclick', 'return false');
            $(this).css('text-decoration', 'none').css('cursor','default');
        })
    }
});

$(function() {
    var pdatepicker = $('.pdatepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: min_pdate,
        onSelect: function(dateText) {
            saveNewAssigment('save',0);
            initPublishDate();
        }
    });
    $('.pshow_picker').click(function(){
        if( assignment_publish_date_disabled == 1 ) { return false; }
        pdatepicker.datepicker("show");
    });
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        minDate: min_date
    });   
    $('.show_picker').click(function(){
        $( ".datepicker" ).datepicker("show");
    });

    $('#publishbasicExample').timepicker({
        'timeFormat': 'H:i',
        'selectOnBlur': 'focus',
        'useSelect': true,
        'minTime': '7:00',
        'maxTime': '22:00'
    });
    $('#publishbasicExample').show();
    $('#basicExample').timepicker({
        'timeFormat': 'H:i',
        'selectOnBlur': 'focus',
        'useSelect': true,
        'minTime': '7:00',
        'maxTime': '22:00'
    });
    $('#basicExample').show();
    $('.ui-timepicker-select').css('z-index', '10000');
    $('.ui-timepicker-select').css('padding', '8px 10px');
    initPublishDate();
});

function CP( p ) {
    if( !disableprev ) { $('#p'+p).click(); }
}
function CN( n ) {
    if( disablenext == 0 ) {
/* //        if( $('#grade_type').val() == 'offline' ) {} */
        $('#n'+n).click();
    }
}

/* // remove resource */
function resourceModal(res) {
    $('#message').modal('hide');
    $( $('#popupDelRes').find('p')[0] ).html('Please confirm you would like to remove this Resource');
    $( $('#popupDelRes').find('h4')[0] ).text('');
    $( "#popupDelRes .res_id" ).val(res);
    $('#popupDelRes').modal('show');
}

function doDelRes() {
    var res_id = $( "#popupDelRes .res_id" ).val();
    $.post('/f2b_teacher/removeResource', { assignment_id: $( "#assignment_id" ).val(), resource_id: res_id }, function(r, textStatus) {
        if( r == 1 ) {
            $('#res_'+res_id).remove();
        }
        $('#popupDelRes').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if( r == 1 ) {
            showFooterMessage({status: 'success', mess: 'Resource removed', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'alert', mess: 'Processing error...', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    });
}

function confirmDeleteAssignments( aid, sname ) {
    $( "#popupDelAssign .assign_id" ).val(aid);
    $( "#popupDelAssign .assign_title" ).val(sname);
    $( $('#popupDelAssign').find('p')[0] ).text('Please click confirm if you wish to remove this homework assignment for '+sname+'.');
    $( $('#popupDelAssign').find('h4')[0] ).text('');
    $('#popupDelAssign').modal('show');
}

function doDelAssignments() {
    var assign_id = $( "#popupDelAssign .assign_id" ).val();
    var assign_title = $( "#popupDelAssign .assign_title" ).val();
    $.post('/f2b_teacher/removeAssignment', { assignment_id: assign_id}, function(r, textStatus) {
        if( r == 1 ) {
            $('#ass_status_'+assign_id).html(' ');
            $('#ass_attainment_'+assign_id).html('<span style="font-weight: normal;">exempt</span>');
            $('#ass_delete_'+assign_id).html('<a class="addAss" title="" href="javascript:confirmAddAssignments('+assign_id+', \''+assign_title+'\')"></a>');
        }
        $('#popupDelAssign').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if( r == 1 ) {
            showFooterMessage({status: 'success', mess: 'Assignment removed', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'alert', mess: 'Processing error...', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    });
}

function confirmAddAssignments( aid, sname ) {
    $( "#popupAddAssign .assign_id" ).val(aid);
    $( "#popupAddAssign .assign_title" ).val(sname);
    $( $('#popupAddAssign').find('p')[0] ).text('Please click confirm if you wish to reassign this homework to '+sname+'.');
    $( $('#popupAddAssign').find('h4')[0] ).text('');
    $('#popupAddAssign').modal('show');
}

function doAddAssignments() {
    var assign_id = $( "#popupAddAssign .assign_id" ).val();
    var assign_title = $( "#popupAddAssign .assign_title" ).val();
    $.post('/f2b_teacher/addAssignment', { assignment_id: assign_id}, function(r, textStatus) {
        if( r.res == 1 ) {
            $('#ass_status_'+assign_id).html(r.submission_status);
            $('#ass_attainment_'+assign_id).html('-');
            $('#ass_delete_'+assign_id).html('<a class="delete2" title="" href="javascript:confirmDeleteAssignments('+assign_id+', \''+assign_title+'\')"></a>');
        }
        $('#popupAddAssign').modal('hide');
        $($($('#message').find("div")[0]).find("div")[0]).hide();
        if( r.res == 1 ) {
            showFooterMessage({status: 'success', mess: 'Assignment added', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        } else {
            showFooterMessage({status: 'alert', mess: 'Processing error...', clrT: '#fff', clr: '#128c44', anim_a:2000, anim_b:1700 });
        }
    },'json');
}

function dynamicSort(property) {
    var sortOrder = 1;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a,b) {
        var result = (a[property] > b[property]) ? -1 : (a[property] < b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

function copyAssignment( assignment_id ) {
    $('#popupCopy').attr('assignment_id', assignment_id);
    $('#popupCopyAss > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Copy Assignment?');
    $('#popupCopyAss > .modal-dialog > .modal-content > .modal-body').html('Please confirm you wish to copy this Homework for another class?');
    $('#popupCopyAss').modal('show');
}

$(document).on("click", "#popupCopy", function(){
    var assignment_id =  $('#popupCopy').attr('assignment_id');
    if( assignment_id != '' || assignment_id != undefined ) {
        data = { assignment_id: assignment_id }
        $.ajax({
            type: "POST",
            url: "/f2b_teacher/copyAssignment",
            data: data,
            dataType: "json",
            success: function (data) {
                if(data.status == false) {
                    showFooterMessage({status: 'alert', mess: 'Your assignment has not been copied successfull. Please try again later.', anim_a:2000, anim_b:170});
                } else {
                    showFooterMessage({status: 'success', mess: 'A new copy of this homework assignment has been created for you to assign to another class. You will be redirected to edit this assignment in a moment..', anim_a:2000, anim_b:170,
                        onFinish : 'redirectToMode(\'/f2c_teacher/index/'+data.assignment_id+'\')'
                    });
                }
            }
        })
    }
    $('#popupCopyAss').modal('hide');
})

function setPublishDate() {
    var output = '';
    if( assignment_publish_date_disabled == 1 ) {
        assignment_publish_date_disabled = 0;
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate()+1;
        output = d.getFullYear() + '-' + ((''+month).length < 2 ? '0' : '') + month + '-' + ((''+day).length < 2 ? '0' : '') + day;

        $('#org_publish_date').val(output);
        $('#org_publish_time').val($('#publishbasicExample').val());
        $('#publish_date').val(output);
        $('#publishbasicExample').val();
        $('#publish_chk').addClass('active');
    } else {
        var d = new Date();
        var month = d.getMonth()+1;
        var day = d.getDate();
        output = d.getFullYear() + '-' + ((''+month).length < 2 ? '0' : '') + month + '-' + ((''+day).length < 2 ? '0' : '') + day;

        $('#org_publish_date').val(output);
        $('#org_publish_time').val($('#publishbasicExample').val());
        $('#publish').val(0);
        $('#publish_date').val(output);
        $('#publishbasicExample').val();
        saveNewAssigment('save',1);
        assignment_publish_date_disabled = 1;
        $('#publish_chk').removeClass('active');
    }
    initPublishDate();
}

function initPublishDate() {
    if( mode == 1 ) {
        if( assignment_publish_date_disabled == 1 ) {
            $('#pta').hide();
            $('#pta').parent().css('background', '#a0a0a0');
        } else {
            $('#pta').show();
            $('#pta').parent().css('background', '#099A4D');
        }
        updateSlideHeight(".step.s3");
    }
}
