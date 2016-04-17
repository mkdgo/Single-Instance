function pretySelect() {
    $('select').each(function(){
        if(!$(this).hasClass('customize')) {
            $(this).addClass('customize');
            $(this).after('<span class="select"><span class="v">'+$('option:selected', this).text()+'</span><span class="a"></span></span>');
            $(this).appendTo($(this).next());
        }
    })
    $('span.select select').on('change', function(){
        $(this).closest('.select').find('.v').text($('option:selected', this).text());
    });
}

function setDatepicker() {
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
    });   
}

function addCondition() {
    var count_con = $(".report_filters").children().length;
    var con = '<div id="condition_'+count_con+'" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%; margin-bottom: 5px;">'
+'<div class="f_gray" style="float:left;width: 14%; margin-right: 1%;">'
    +'<select class="subject_select" name="conditions['+count_con+'][condition]">'
        +'<option value="AND">AND</option>'
        +'<option value="OR">OR</option>'
        +'<!-- <option value="GROUP BY">GROUP BY</option> -->'
    +'</select>'
+'</div>'
+'<div class="f1 f_gray" style="float:left;width: 30%; margin-right: 1%;">'
    +'<select class="subject_select" name="conditions['+count_con+'][field]">'
        +'<option value="action_date" >From date</option>'
        +'<option value="action_date" >To date</option>'
        +'<option value="" >Year</option>'
        +'<option value="" >Subject</option>'
        +'<option value="" >Class</option>'
        +'<option value="student_id" >Student</option>'
        +'<option value="lesson_id" >Assessment</option>'
        +'<option value="resource_id" >Assessment Question</option>'
        +'<option value="behavior">Independent Study</option>'
    +'</select>'
+'</div>'
+'<div class="f1 f_gray" style="float:left;width: 24%; margin-right: 1%;">'
    +'<select class="subject_year_select" name="conditions['+count_con+'][operation]">'
        +'<option value="greater_than">Is Greater Than</option>'
        +'<option value="lower_than">Is Lower Than</option>'
        +'<option value="equal">Is Equal To</option>'
        +'<option value="like">Is Like</option>'
    +'</select>'
+'</div>'
+'<div class="f1 f_gray" style="float:left;width: 29%;">'
    +'<input class="datepicker" type="text" name="conditions['+count_con+'][value]" value="" style="padding: 8px 10px;" />'
+'</div>'
+'</div>';
    $('.report_filters').append(con);
    pretySelect();
    setDatepicker();
}






$(function(){
// filters select

    $('select').each(function(){
        var self = $(this);
        if( self.val() != 'all' ) { 
            self.parent().parent().addClass('active');
//            self.parent().css('background','#888');
            self.parent().find('.v').css('color','#fff');
        } else {
//            self.parent().css('background','#E0E0E0');
//            self.parent().find('.v').css('color','#333');
        }
    })

/*    if( $.session.get('count_drafted') != 'block' ) { 
        $('#count_drafted').prev().click();
    }
    if( $.session.get('count_assigned') != 'block' ) { 
        $('#count_assigned').prev().click();
    }
    if( $.session.get('count_past') != 'block' ) { 
        $('#count_past').prev().click();
    }
    if( $.session.get('count_closed') != 'block' ) { 
        $('#count_closed').prev().click();
    }
*/
    $('select').on('change',function(){
        var self = $(this);
        if( self.val() != 'all' ) { 
            self.parent().css('background','#888');
            self.parent().find('.v').css('color','#fff');
        } else {
            self.parent().css('background','#E0E0E0');
            self.parent().find('.v').css('color','#333');
        }
    })
    $('.teacher_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        data = setData( 'teacher' );
        history.replaceState(null, null, "r2_teacher?=" + r2_teacher_id);
        $.ajax({
            type: "POST",
            url: "/r2_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (fdata) {
/*                $.each(fdata.assignments, function (i) {
                    $('.' + i).fadeOut(200).html('');
                    if (fdata.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(fdata.assignments[i], function (key, val) {
                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    } else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }
                });
                $.each(fdata.counters, function (i,r) {
                    $('.'+i).html('('+r+")")
                    if(r > 0) {
                        $('#'+i).removeClass('hidden');
                        $('.'+i+'_title').css( "color", "#333" );
                        $('.'+i+'_img').css( "background-image", "url('../img/acc_arrows.png')" );
                    } else {
                        $('#'+i).removeClass('hidden').addClass('hidden');
                        $('.'+i+'_title').css( "color", "#aaa" );
                        $('.'+i+'_img').css( "background-image", "none" );
                    }
                });
*/

                self.prev('span').removeClass('preloader').addClass('a');
                setSubjectOptions( fdata.subjects );
                setYearOptions( fdata.years );
                setClassOptions( fdata.classes )
                setAssignmentOptions( data.assignments )
//                setStatusOptions( fdata.status_select );
            }
        })
    })

    $('.subject_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'subject' );
        history.replaceState(null, null, "r2_teacher?=" + r2_subject_id);
        $.ajax({
            type: "POST",
            url: "/r2_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
/*                $.each(data.assignments, function (i) {
                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(data.assignments[i], function (key, val) {
                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    } else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }
                });
                $.each(data.counters, function (i,r) {
                    $('.'+i).html('('+r+")")
                    if(r > 0) {
                        $('#'+i).removeClass('hidden');
                        $('.'+i+'_title').css( "color", "#333" );
                        $('.'+i+'_img').css( "background-image", "url('../img/acc_arrows.png')" );
                    } else {
                        $('#'+i).removeClass('hidden').addClass('hidden');
                        $('.'+i+'_title').css( "color", "#aaa" );
                        $('.'+i+'_img').css( "background-image", "none" );
                    }
                })
*/
                self.prev('span').removeClass('preloader').addClass('a');
                setTeacherOptions( data.teachers );
                setYearOptions( data.years );
                setClassOptions( data.classes );
                setAssignmentOptions( data.assignments )
//                setStatusOptions( data.status_select );
            }
        })
    })

    $('.subject_year_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'year' );
        history.replaceState(null, null, "r2_teacher?=" + r2_year);
        $.ajax({
            type: "POST",
            url: "/r2_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
/*                $.each(data.assignments, function (i) {
                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        $.each(data.assignments[i], function (key, val) {
                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    } else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }
                });
                $.each(data.counters, function (i,r) {
                    $('.'+i).html('('+r+")")
                    if(r > 0) {
                        $('#'+i).removeClass('hidden');
                        $('.'+i+'_title').css( "color", "#333" );
                        $('.'+i+'_img').css( "background-image", "url('../img/acc_arrows.png')" );
                    } else {
                        $('#'+i).removeClass('hidden').addClass('hidden');
                        $('.'+i+'_title').css( "color", "#aaa" );
                        $('.'+i+'_img').css( "background-image", "none" );
                    }
                })
*/
                self.prev('span').removeClass('preloader').addClass('a');
                setTeacherOptions( data.teachers );
                setSubjectOptions( data.subjects );
                setClassOptions( data.classes );
                setAssignmentOptions( data.assignments )
//                setStatusOptions( data.status_select );
            }
        })
    })

    $('.class_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'class' );
        history.replaceState(null, null, "r2_teacher?=" + r2_class_id);
        $.ajax({
            type: "POST",
            url: "/r2_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
/*                $.each(data.assignments, function (i) {
                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(data.assignments[i], function (key, val) {
                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    } else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }
                });
                $.each(data.counters, function (i,r) {
                    $('.'+i).html('('+r+")")
                    if(r > 0) {
                        $('#'+i).removeClass('hidden');
                        $('.'+i+'_title').css( "color", "#333" );
                        $('.'+i+'_img').css( "background-image", "url('../img/acc_arrows.png')" );
                    } else {
                        $('#'+i).removeClass('hidden').addClass('hidden');
                        $('.'+i+'_title').css( "color", "#aaa" );
                        $('.'+i+'_img').css( "background-image", "none" );
                    }
                })
*/
                self.prev('span').removeClass('preloader').addClass('a');
                setTeacherOptions( data.teachers );
                setSubjectOptions( data.subjects );
                setYearOptions( data.years );
                setAssignmentOptions( data.assignments )
//                setStatusOptions( data.status_select );
            }
        })
    })

    $('.status_select').on('change',function(){
        var self = $(this);
//        self.prev('span').removeClass('a').addClass('preloader');
/*
        data = setData( 'status' );
        history.replaceState(null, null, "r2_teacher?=" + r2_status);
        $.ajax({
            type: "POST",
            url: "/r2_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                $.each(data.assignments, function (i) {
                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(data.assignments[i], function (key, val) {
                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    } else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }
                });
                $.each(data.counters, function (i,r) {
                    $('.'+i).html('('+r+")")
                    if(r > 0) {
                        $('#'+i).removeClass('hidden');
                        $('.'+i+'_title').css( "color", "#333" );
                        $('.'+i+'_img').css( "background-image", "url('../img/acc_arrows.png')" );
                    } else {
                        $('#'+i).removeClass('hidden').addClass('hidden');
                        $('.'+i+'_title').css( "color", "#aaa" );
                        $('.'+i+'_img').css( "background-image", "none" );
                    }
                })
            }
        })
*/
    })
})

function setData( type ) {
    r2_teacher_id = $('.teacher_select').find(':selected').val();
    r2_subject_id = $('.subject_select').find(':selected').val();
    r2_year = $('.subject_year_select').find(':selected').val();
    r2_class_id = $('.class_select').find(':selected').val();
//    r2_status = $('.status_select').find(':selected').val();
    r2_type = type;
    
//    r2_css_assigned = $('#count_assigned').css('display');
//    r2_css_draft = $('#count_drafted').css('display');
//    r2_css_past = $('#count_past').css('display');
//    r2_css_closed = $('#count_closed').css('display');

//    data = { r2_teacher_id: r2_teacher_id, r2_subject_id: r2_subject_id, r2_year: r2_year, r2_class_id: r2_class_id, r2_status: r2_status, r2_type: r2_type };
    data = { r2_teacher_id: r2_teacher_id, r2_subject_id: r2_subject_id, r2_year: r2_year, r2_class_id: r2_class_id, r2_type: r2_type };
    return data;
}

function setTeacherOptions( teachers ) {
    $('.teacher_select').html(teachers);
    $('.teacher_select').parent().find('.v').html($('.teacher_select').find(':selected').text());
}

function setSubjectOptions( subjects ) {
    $('.subject_select').html(subjects);
    $('.subject_select').parent().find('.v').html($('.subject_select').find(':selected').text());
}

function setYearOptions( years ) {
    $('.subject_year_select').html(years);
    $('.subject_year_select').parent().find('.v').html($('.subject_year_select').find(':selected').text());
}

function setClassOptions( classes ) {
    $('.class_select').html(classes);
    $('.class_select').parent().find('.v').html($('.class_select').find(':selected').text());
}

function setAssignmentOptions( assignments ) {
    $('.assignment_select').html(assignments);
    $('.assignment_select').parent().find('.v').html($('.assignment_select').find(':selected').text());
}
/*
function setStatusOptions( statuses ) {
    $('.status_select').html(statuses);
    if (statuses != '') {
        $('.status_select').parent().find('.v').html($('.status_select').find('option:first').text());
    } else {
        $('.status_select').parent().find('.v').html('All');
    }
//    $('.status_select').html(statuses);
//    $('.status_select').parent().find('.v').html($('.status_select').find(':selected').text());
}
*/
