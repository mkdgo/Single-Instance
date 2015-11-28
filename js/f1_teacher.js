$(function(){
// filters select

    $('select').each(function(){
        var self = $(this);
        if( self.val() != 'all' ) { 
            self.parent().css('background','#888');
            self.parent().find('.v').css('color','#fff');
        } else {
            self.parent().css('background','#E0E0E0');
            self.parent().find('.v').css('color','#333');
        }
    })

    if( $.session.get('count_drafted') != 'block' ) { 
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
        history.replaceState(null, null, "f1_teacher?=" + f1_teacher_id);
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (fdata) {
                $.each(fdata.assignments, function (i) {
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

                setSubjectOptions( fdata.subjects );
                setYearOptions( fdata.years );
                setClassOptions( fdata.classes )
                setStatusOptions( fdata.status_select );
            }
        })
    })

    $('.subject_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'subject' );
        history.replaceState(null, null, "f1_teacher?=" + f1_subject_id);
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
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

                setTeacherOptions( data.teachers );
                setYearOptions( data.years );
                setClassOptions( data.classes );
                setStatusOptions( data.status_select );
            }
        })
    })

    $('.subject_year_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'year' );
        history.replaceState(null, null, "f1_teacher?=" + f1_year);
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                $.each(data.assignments, function (i) {
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

                setTeacherOptions( data.teachers );
                setSubjectOptions( data.subjects );
                setClassOptions( data.classes );
                setStatusOptions( data.status_select );
            }
        })
    })

    $('.class_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'class' );
        history.replaceState(null, null, "f1_teacher?=" + f1_class_id);
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
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
                setTeacherOptions( data.teachers );
                setSubjectOptions( data.subjects );
                setYearOptions( data.years );
                setStatusOptions( data.status_select );
            }
        })
    })

    $('.status_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');

        data = setData( 'status' );
        history.replaceState(null, null, "f1_teacher?=" + f1_status);
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
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
/*
                if( data.teachers != '' ) {
                    $('.teacher_select').html(data.teachers);
                    $('.teacher_select').parent().find('.v').html($('.teacher_select').find(':selected').text());
                } else {
                    $('.teacher_select').html(data.teachers);
                    $('.teacher_select').parent().find('.v').html($('.teacher_select').find(':selected').text());
                }
                if( data.subjects != '' ) {
                    $('.subject_select').html(data.subjects);
                    $('.subject_select').parent().find('.v').html($('.subject_select').find(':selected').text());
                } else {
                    $('.subject_select').html(data.subjects);
                    $('.subject_select').parent().find('.v').html($('.subject_select').find(':selected').text());
                }
                if( data.years != '' ) {
                    $('.subject_year_select').html(data.years);
                    $('.subject_year_select').parent().find('.v').html($('.subject_year_select').find(':selected').text());
                } else {
                    $('.subject_year_select').html(data.years);
                    $('.subject_year_select').parent().find('.v').html($('.subject_year_select').find(':selected').text());
                }
//*/
            }
        })
    })
})

function setData( type ) {
    f1_teacher_id = $('.teacher_select').find(':selected').val();
    f1_subject_id = $('.subject_select').find(':selected').val();
    f1_year = $('.subject_year_select').find(':selected').val();
    f1_class_id = $('.class_select').find(':selected').val();
    f1_status = $('.status_select').find(':selected').val();
    f1_type = type;
    
    f1_css_assigned = $('#count_assigned').css('display');
    f1_css_draft = $('#count_drafted').css('display');
    f1_css_past = $('#count_past').css('display');
    f1_css_closed = $('#count_closed').css('display');

    data = { f1_teacher_id: f1_teacher_id, f1_subject_id: f1_subject_id, f1_year: f1_year, f1_class_id: f1_class_id, f1_status: f1_status, f1_type: f1_type };
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
//*
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
//*/
function delRequest(id,title, section) {
    $('#popupDel').attr('del_id', id);
    $('#popupDel').attr('del_title', title);
    $('#popupDel').attr('del_section', section);

    $('#popupDelRes > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Assignment?');
    $('#popupDelRes > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Assignment <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');

    $('#popupDelRes').modal('show');
}
$('#popupDel').on('click',function(){
    var id =  $('#popupDel').attr('del_id');
    var title =  $('#popupDel').attr('del_title');
    var section =  $('#popupDel').attr('del_section');
    if(id!=''|| id!=undefined) {
        data = { id: id }
        var searched = $('.assignm_'+id).parent().parent().parent().parent().parent();
        var searched_number = $('.'+section).html();
        var numb = searched_number.substring(1,searched_number.length-1);
        $('.'+section).html('('+(numb-1)+')');

        $.ajax({
            type: "POST",
            url: "/f1_teacher/deleteAssignment",
            data: data,
            dataType: "json",
            success: function (data) {
                if(data.status=='true') {
                    $('.assignm_'+data.id).parent().fadeOut(300).remove();
                    showFooterMessage({status: 'success', mess: 'Your assignment has been deleted successfull.', anim_a:2000, anim_b:170});
                }
            }
        })
    }
    $('#popupDelRes').modal('hide');
})

function copyAssignment( assignment_id ) {
    $('#popupCopy').attr('assignment_id', assignment_id);

    $('#popupCopyAss > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Copy Assignment?');
    $('#popupCopyAss > .modal-dialog > .modal-content > .modal-body').html('Please confirm you wish to copy this Homework for another class?');

    $('#popupCopyAss').modal('show');
}
$('#popupCopy').on('click',function(){
    var assignment_id =  $('#popupCopy').attr('assignment_id');
    if( assignment_id != '' || assignment_id != undefined ) {
        data = { assignment_id: assignment_id }
        $.ajax({
            type: "POST",
            url: "/f2b_teacher/copyAssignment",
            data: data,
            dataType: "json",
            success: function (data) {
                if(data.status==false) {
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

function redirectToMode(m) {
    document.location = m;
}

function showInfo( assignment_id ) {
    data = { assignment_id: assignment_id }
    $.ajax({
        type: "POST",
        url: "/f1_teacher/getDetails",
        data: data,
        dataType: "json",
        success: function (data) {
            if(data.success == 1 ) {
                $('.title_info').html(data.title);
                $('.intro_info').html(data.intro);
                $('.assignment_to_info').html(data.assigned_to);
                $('.set_by_info').html(data.set_by);
                $('.publish_info').html(data.publish_date);
                $('.deadline_info').html(data.deadline_date);
                $('.grade_type_info').html(data.grade_type);
                $('.submitted_info').html(data.submitted);
                $('.marked_info').html(data.marked);
                $('.status_info').html(data.status);
            } else {
                $('#infoModal h5.text-error').show();
                $('.title_info').html('');
                $('.intro_info').html('');
                $('.assignment_to_info').html('');
                $('.set_by_info').html('');
                $('.publish_info').html('');
                $('.deadline_info').html('');
                $('.grade_type_info').html('');
                $('.submitted_info').html('');
                $('.marked_info').html('');
                $('.status_info').html('');
            }
            $('#infoModal').modal('show');
        }
    })
}
