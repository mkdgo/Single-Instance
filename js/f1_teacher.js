$(function(){

    $('.teacher_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$(this).find(':selected').val();
        var status = 'all';
        var type = 'teacher';
        data = {teacher_id:teacher_id,status:status,type:type}
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
                          //  console.log(i);

                            $(val).appendTo($('.' + i));
                        });

                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);

                    }
                    else {
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
                });
                if (data.subjects != '') {
                    $('.subject_select').empty().append(data.subjects);
                    $('.subject_select').parent().find('.v').html($('.subject_select').find('option:first').text());

                } else {
                    $('.subject_select').empty();
                    $('.subject_select').parent().find('.v').html('All');

                }

                if (data.years != '') {
                    $('.subject_year_select').empty().append(data.years);
                    $('.subject_year_select').parent().find('.v').html($('.subject_year_select').find('option:first').text());

                } else {
                    $('.subject_year_select').empty();
                    $('.subject_year_select').parent().find('.v').html('All');


                }

                if (data.class != '') {
                    $('.class_select').empty().append(data.class);
                    $('.class_select').parent().find('.v').html($('.class_select').find('option:first').text());

                } else {
                    $('.class_select').empty();
                    $('.class_select').parent().find('.v').html('All');

                }



                if (data.status_select != '') {
                    $('.status_select').empty().append(data.status_select);
                    $('.status_select').parent().find('.v').html($('.status_select').find('option:first').text());

                } else {
                    $('.status_select').empty();
                    $('.status_select').parent().find('.v').html('All');

                }

            }
        })
    })


    $('.subject_select').on('change',function(){

        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        var classes_ids=$(this).find(':selected').attr('classes_ids');
        var status = 'all';
        var find = $(this).find(':selected').val();
        var type = 'subject';
        data = {teacher_id:teacher_id,classes_ids:classes_ids,status:status,type:type,find:find}
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
                    }
                    else {
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
                if (data.subjects != '') {
                    $('.subject_select').empty().append(data.subjects);
                    $('.subject_select').parent().find('.v').html($('.subject_select').find('option:first').text());

                } else {
                    $('.subject_select').empty();
                    $('.subject_select').parent().find('.v').html('No results');

                }
                */
                 if (data.years != '') {
                 $('.subject_year_select').empty().append(data.years);
                 $('.subject_year_select').parent().find('.v').html($('.subject_year_select').find('option:first').text());

                 } else {
                 $('.subject_year_select').empty();
                 $('.subject_year_select').parent().find('.v').html('No results');


                 }

                 if (data.class != '') {
                 $('.class_select').empty().append(data.class);
                 $('.class_select').parent().find('.v').html($('.class_select').find('option:first').text());

                 } else {
                 $('.class_select').empty();
                 $('.class_select').parent().find('.v').html('No results');

                 }

                if (data.status_select != '') {
                    $('.status_select').empty().append(data.status_select);
                    $('.status_select').parent().find('.v').html($('.status_select').find('option:first').text());

                } else {
                    $('.status_select').empty();
                    $('.status_select').parent().find('.v').html('All');

                }


            }
        })
    })

//year change
    $('.subject_year_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        var subject_id = $('.subject_select').find(':selected').val();
        var subjects_ids=$(this).find(':selected').attr('subjects_ids');
        var class_id=$(this).find(':selected').attr('class_id');
        //var status = $('.status_select').find(':selected').val();
        var status = 'all';
        var type = 'year';
        var find = $(this).find(':selected').val();
        data = {teacher_id:teacher_id,subjects_ids:subjects_ids,status:status,type:type,class_id:class_id,find:find,subject_id:subject_id}
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
                    }
                    else {
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


                 if (data.class != '') {
                 $('.class_select').empty().append(data.class);
                 $('.class_select').parent().find('.v').html($('.class_select').find('option:first').text());

                 } else {
                 $('.class_select').empty();
                 $('.class_select').parent().find('.v').html('No results');

                 }

                if (data.status_select != '') {
                    $('.status_select').empty().append(data.status_select);
                    $('.status_select').parent().find('.v').html($('.status_select').find('option:first').text());

                } else {
                    $('.status_select').empty();
                    $('.status_select').parent().find('.v').html('All');

                }

            }
        })
    })

    //class_select
    $('.class_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        var subjects_ids=$(this).find(':selected').attr('subjects_ids');
        var class_id=$(this).find(':selected').attr('class_id');
        var status = 'all';
        var type = 'class';
        data = {teacher_id:teacher_id,subjects_ids:subjects_ids,status:status,type:type,class_id:class_id}
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                //console.log(data);
                $.each(data.assignments, function (i) {

                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(data.assignments[i], function (key, val) {
                            console.log(i);

                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    }
                    else {
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

                if (data.status_select != '') {
                    $('.status_select').empty().append(data.status_select);
                    $('.status_select').parent().find('.v').html($('.status_select').find('option:first').text());

                } else {
                    $('.status_select').empty();
                    $('.status_select').parent().find('.v').html('All');

                }
            }
        })
    })
//status
    $('.status_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        //var subjects_ids=$(this).find(':selected').attr('subjects_ids');
        var class_id=$('.class_select').find(':selected').attr('class_id');
        //var class_id=$(this).find(':selected').attr('class_id');
        var status = $('.status_select').find(':selected').val();
        var type = 'status';
        //data = {teacher_id:teacher_id,subjects_ids:subjects_ids,status:status,type:type,class_id:class_id}
        data = {teacher_id:teacher_id,type:type,status:status,class_id:class_id}
        $.ajax({
            type: "POST",
            url: "/f1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                //console.log(data);
                $.each(data.assignments, function (i) {

                    $('.' + i).fadeOut(200).html('');
                    if (data.assignments[i] != '') {
                        //$('.'+i).fadeOut(200);
                        $.each(data.assignments[i], function (key, val) {
                            console.log(i);

                            $(val).appendTo($('.' + i));
                        });
                        self.prev('span').removeClass('preloader').addClass('a');
                        $('.' + i).fadeIn(200);
                    }
                    else {
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
    })

})

function delRequest(id,title) {
//console.log(title);
    $('#popupDel').attr('del_id', id);

    $('#popupDelRes > .modal-dialog > .modal-content > .modal-header > .modal-title').html('Delete Assignment?');
    $('#popupDelRes > .modal-dialog > .modal-content > .modal-body').html('Please confirm you would like to delete this Assignment <span style="color:#e74c3c;text-decoration:underline;">'+title+'</span> ?');

    $('#popupDelRes').modal('show');
}
$('#popupDel').on('click',function(){
    var id=  $('#popupDel').attr('del_id');
    if(id!=''|| id!=undefined) {
        data = {
            id: id
        }
        var searched = $('.assignm_'+id).parent().parent().parent().parent().parent();
        var searched_number = $(searched).find('.count_past').html();
        var numb = searched_number.substring(1,searched_number.length-1);
        $(searched).find('.count_past').html('('+(numb-1)+')');

        $.ajax({
            type: "POST",
            url: "/f1_teacher/deleteAssignment",
            data: data,
            dataType: "json",
            success: function (data) {
                console.log(data)
                if(data.status=='true') {
                    $('.assignm_'+data.id).parent().fadeOut(300).remove();

                }

            }
        })
    }
    $('#popupDelRes').modal('hide');
})
