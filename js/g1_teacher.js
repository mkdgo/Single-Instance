$(function(){

    $('.teacher_select').on('change',function(){

        var self = $(this);
       self.prev('span').removeClass('a').addClass('preloader');

        var teacher_id=$(this).find(':selected').val();

        var type = 'teacher';
        data = {teacher_id:teacher_id,type:type}
        $.ajax({
            type: "POST",
            url: "/g1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {

                $('.f1').fadeOut(200).html('');




                    if (data.subjects_list != ''&& data.subjects_list !=undefined) {
                        //$('.'+i).fadeOut(200);
                        $.each(data.subjects_list, function (key, val) {
                            //console.log(val)
                            if(val['subject_years']!=""&& val['subject_years'] !=undefined){var count_sub=val.subject_years.length}else{count_sub=0}
                            if(count_sub==0) {
                                var c-title = "color:#aaa;";
                                var c-img = "background-image:none;";
                                var c-hidden = "hidden";
                            } else {
                                var c-title = "";
                                var c-img = "";
                                var c-hidden = "";
                            }
                            var str ='<h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;'+c-title+'">'+val.name+'</h3>';
                            str+='<div class="up_down" style="cursor:pointer;padding-right: 2px;'+c-img+'"><span class="count_lessons count_assigned" style="'+c-title+'">('+count_sub+')</span></div>';
                             str+='<div class="collapsed '+c-hidden+'" style="display: none">';
                            str+='  <div class="row" style="width: 100%;margin-left: 0;" >';

                          //ok console.log('Subject:'+val.name);


                            if(val['subject_years']!=""&& val['subject_years'] !=undefined){

                            $.each(val['subject_years'], function (keys, vals) {

                                if(vals.classes!=""&& vals.classes !=undefined) {var count_classes=vals.classes.length}else{count_classes=0}
                                str+='<h3 class="acc_title" style="background-color:#ddd;cursor:pointer;padding:18px 10px;margin-top:-3px;border-bottom: 1px solid #dddddd;font-size:14px;font-weight:bold;">Year: '+vals.year+'</h3>';
                                str+='<div class="up_down" style="cursor:pointer;top:5px;margin-right: 2px"><span class="count_lessons count_assigned">('+count_classes+')</span></div>';
                                str+='<div class="collapsed" style="display: none">';

                                str+='<div class="row" style="width: 100%;margin-left: 0;">';

                                //ok  console.log('Year:'+vals.year);

                                if(vals.classes!=""&& vals.classes !=undefined) {
                                    $.each(vals.classes, function (key1, val1) {
                                        if(val1.students!=""&& val1.students !=undefined) {var count_students=val1.students.length}else{count_students=0}
                                        str+='<h3 class="acc_title" style="background-color:#eee; cursor:pointer;padding:10px;;margin-top:-5px;border-bottom: 1px solid #eeeeee;font-size:14px;">Class: '+val1.group_name+'</h3>';
                                        str+='<div class="up_down" style="cursor:pointer;top:5px;padding-right: 2px"><span class="count_lessons count_assigned">('+count_students+')</span></div>';
                                        str+='<div class="collapsed" style="display: none">';
                                        str+='<div class="row clearfix " style="padding: 5px 0px 15px 0px;">';

                                     //ok   console.log(val1.group_name);
                                        if(val1.students!=""&& val1.students !=undefined) {
                                            $.each(val1.students, function (key2, val2) {
                                                str+='<div class="col-sm-12 col-md-6">';
                                                //str+='<a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/'+val2.subject_ids+'/'+val2.year_id+'/'+val2.class_id+'/'+val2.ids+'">';
                                                str+='<a class="ediface-student col-sm-12 col-md-11" style="border-bottom: 1px solid #ccc;padding-bottom: 5px;padding-top: 10px;width: 100%;" href="/g1_teacher/student/'+val2.ids+'">';
                                                str+='<span class="pull-left">'+val2.first_name +' '+ val2.last_name+'</span>';
                                                str+='<span class="pull-right glyphicon glyphicon-chevron-right"></span></a>';
                                                str+='</div>';

                                            })
                                        }

                                        str+='</div>';
                                        str+='</div>';
                                   });
                                }

                                str+='</div>';
                                str+='</div>';
                           });
                            }

                            str+='</div>';
                            str+='</div>';



                            $('.f1').append(str);

                        });


                       self.prev('span').removeClass('preloader').addClass('a');
                            $('.f1').fadeIn(300);

                    }
                    else {
                        self.prev('span').removeClass('preloader').addClass('a');
                    }

                if (data.subjects != '') {
                    $('.subject_select').empty().append(data.subjects);
                    $('.subject_select').parent().find('.v').html($('.subject_select').find('option:first').text());

                } else {
                    $('.subject_select').empty();
                    $('.subject_select').parent().find('.v').html('No results');

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



            }
        })
    })


    $('.subject_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        var subject_ids=$(this).find(':selected').attr('subject_ids');

        var find = $(this).find(':selected').val();
        var type = 'subject';
        data = {teacher_id:teacher_id,subject_ids:subject_ids,type:type,find:find}
        $.ajax({
            type: "POST",
            url: "/g1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {

                $('.f1').fadeOut(200).html('');

                if (data.subjects_list != ''&&data.subjects_list !=undefined) {
                    //$('.'+i).fadeOut(200);
                    $.each(data.subjects_list, function (key, val) {
                        //console.log(val)
                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){var count_sub=val.subject_years.length}else{count_sub=0}
                        var str ='<h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">'+val.name+'</h3>';
                        str+='<div class="up_down" style="cursor:pointer;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_sub+')</span></div>';
                        str+='<div class="collapsed" style="display: none">';
                        str+='<div class="row" style="width: 100%;margin-left: 0;">';

                        //ok console.log('Subject:'+val.name);


                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){

                            $.each(val['subject_years'], function (keys, vals) {

                                if(vals.classes!=""&& vals.classes !=undefined) {var count_classes=vals.classes.length}else{count_classes=0}
                                str+='<h3 class="acc_title" style="background-color:#ddd;cursor:pointer;padding:18px 10px;margin-top:-3px;border-bottom: 1px solid #dddddd;font-size:14px;font-weight:bold;">Year: '+vals.year+'</h3>';
                                str+='<div class="up_down" style="cursor:pointer;top:5px;margin-right: 2px;"><span class="count_lessons count_assigned">('+count_classes+')</span></div>';
                                str+='<div class="collapsed" style="display: none">';

                                str+='<div class="row" style="width: 100%;margin-left: 0;">';

                                //ok  console.log('Year:'+vals.year);

                                if(vals.classes!=""&& vals.classes !=undefined) {
                                    $.each(vals.classes, function (key1, val1) {
                                        if(val1.students!=""&& val1.students !=undefined) {var count_students=val1.students.length}else{count_students=0}
                                        str+='<h3 class="acc_title" style="background-color:#eee; cursor:pointer;padding:10px;;margin-top:-5px;border-bottom: 1px solid #eeeeee;font-size:14px;">Class: '+val1.group_name+'</h3>';
                                        str+='<div class="up_down" style="cursor:pointer;top:5px;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_students+')</span></div>';
                                        str+='<div class="collapsed" style="display: none">';
                                        str+='<div class="row clearfix " style="padding: 5px 0px 15px 0px;">';

                                        //ok   console.log(val1.group_name);
                                        if(val1.students!=""&& val1.students !=undefined) {
                                            $.each(val1.students, function (key2, val2) {
                                                str+='<div class="col-sm-12 col-md-6">';
                                               // str+='<a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/'+val2.subject_ids+'/'+val2.year_id+'/'+val2.class_id+'/'+val2.ids+'">';
                                                str+='<a class="ediface-student col-sm-12 col-md-11" style="border-bottom: 1px solid #ccc;padding-bottom: 5px;padding-top: 10px;width: 100%;" href="/g1_teacher/student/'+val2.ids+'">';
                                                str+='<span class="pull-left">'+val2.first_name +' '+ val2.last_name+'</span>';
                                                str+='<span class="pull-right glyphicon glyphicon-chevron-right"></span></a>';
                                                str+='</div>';


                                                //console.log(val2.first_name,val2.last_name);
                                            })
                                        }

                                        str+='</div>';
                                        str+='</div>';
                                    });
                                }

                                str+='</div>';
                                str+='</div>';
                            });
                        }

                        str+='</div>';
                        str+='</div>';



                        $('.f1').append(str);

                    });



                    self.prev('span').removeClass('preloader').addClass('a');
                    $('.f1').fadeIn(300);
                }
                else {
                    self.prev('span').removeClass('preloader').addClass('a');
                }




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
        var classes_id=$(this).find(':selected').attr('classes_id');

        var type = 'year';
        var find = $(this).find(':selected').val();
        data = {teacher_id:teacher_id,subjects_ids:subjects_ids,type:type,classes_id:classes_id,find:find,subject_id:subject_id}
        $.ajax({
            type: "POST",
            url: "/g1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                $('.f1').fadeOut(200).html('');

                if (data.subjects_list != ''&&data.subjects_list !=undefined) {
                    //$('.'+i).fadeOut(200);
                    $.each(data.subjects_list, function (key, val) {
                        //console.log(val)
                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){var count_sub=val.subject_years.length}else{count_sub=0}
                        var str ='<h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">'+val.name+'</h3>';
                        str+='<div class="up_down" style="cursor:pointer;top:5px;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_sub+')</span></div>';
                        str+='<div class="collapsed" style="display: none">';
                        str+=' <div class="row" style="width: 100%;margin-left: 0;">';

                        //ok console.log('Subject:'+val.name);


                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){

                            $.each(val['subject_years'], function (keys, vals) {

                                if(vals.classes!=""&& vals.classes !=undefined) {var count_classes=vals.classes.length}else{count_classes=0}
                                str+='<h3 class="acc_title" style="background-color:#ddd;cursor:pointer;padding:18px 10px;margin-top:-3px;border-bottom: 1px solid #dddddd;font-size:14px;font-weight:bold;">Year: '+vals.year+'</h3>';
                                str+='<div class="up_down" style="cursor:pointer;margin-right: 2px;"><span class="count_lessons count_assigned">('+count_classes+')</span></div>';
                                str+='<div class="collapsed" style="display: none">';

                                str+='<div class="row" style="width: 100%;margin-left: 0;">';

                                //ok  console.log('Year:'+vals.year);

                                if(vals.classes!=""&& vals.classes !=undefined) {
                                    $.each(vals.classes, function (key1, val1) {
                                        if(val1.students!=""&& val1.students !=undefined) {var count_students=val1.students.length}else{count_students=0}
                                        str+='<h3 class="acc_title" style="background-color:#eee; cursor:pointer;padding:10px;;margin-top:-5px;border-bottom: 1px solid #eeeeee;font-size:14px;">Class: '+val1.group_name+'</h3>';
                                        str+='<div class="up_down" style="cursor:pointer;top:5px;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_students+')</span></div>';
                                        str+='<div class="collapsed" style="display: none">';
                                        str+='<div class="row clearfix " style="padding: 5px 0px 15px 0px;">';

                                        //ok   console.log(val1.group_name);
                                        if(val1.students!=""&& val1.students !=undefined) {
                                            $.each(val1.students, function (key2, val2) {
                                                str+='<div class="col-sm-12 col-md-6">';
                                                //str+='<a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/'+val2.subject_ids+'/'+val2.year_id+'/'+val2.class_id+'/'+val2.ids+'">';
                                                str+='<a class="ediface-student col-sm-12 col-md-11" style="border-bottom: 1px solid #ccc;padding-bottom: 5px;padding-top: 10px;width: 100%;" href="/g1_teacher/student/'+val2.ids+'">';
                                                str+='<span class="pull-left">'+val2.first_name +' '+ val2.last_name+'</span>';
                                                str+='<span class="pull-right glyphicon glyphicon-chevron-right"></span></a>';
                                                str+='</div>';


                                                //console.log(val2.first_name,val2.last_name);
                                            })
                                        }

                                        str+='</div>';
                                        str+='</div>';
                                    });
                                }

                                str+='</div>';
                                str+='</div>';
                            });
                        }

                        str+='</div>';
                        str+='</div>';



                        $('.f1').append(str);

                    });



                    self.prev('span').removeClass('preloader').addClass('a');
                    $('.f1').fadeIn(300);
                }
                else {
                    self.prev('span').removeClass('preloader').addClass('a');
                }


                if (data.class != '') {
                    $('.class_select').empty().append(data.class);
                    $('.class_select').parent().find('.v').html($('.class_select').find('option:first').text());

                } else {
                    $('.class_select').empty();
                    $('.class_select').parent().find('.v').html('No results');

                }



            }
        })
    })

    //class_select
    $('.class_select').on('change',function(){
        var self = $(this);
        self.prev('span').removeClass('a').addClass('preloader');
        var teacher_id=$('.teacher_select').find(':selected').val();
        var subject_id=$('.subject_select').find(':selected').val();
        var classes_id=$(this).find(':selected').attr('classes_id');
        var year = $(this).find(':selected').val();
        var type = 'class';
        data = {teacher_id:teacher_id,subject_id:subject_id,year:year,type:type,classes_id:classes_id}
        $.ajax({
            type: "POST",
            url: "/g1_teacher/sortable",
            data: data,
            dataType:"json",
            success: function (data) {
                $('.f1').fadeOut(200).html('');

                if (data.subjects_list != ''&&data.subjects_list !=undefined) {

                    $.each(data.subjects_list, function (key, val) {
                        //console.log(val)
                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){var count_sub=val.subject_years.length}else{count_sub=0}
                        var str ='<h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">'+val.name+'</h3>';
                        str+='<div class="up_down" style="cursor:pointer;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_sub+')</span></div>';
                        str+='<div class="collapsed" style="display: none">';
                        str+=' <div class="row" style="width: 100%;margin-left: 0;">';

                        //ok console.log('Subject:'+val.name);


                        if(val['subject_years']!=""&& val['subject_years'] !=undefined){

                            $.each(val['subject_years'], function (keys, vals) {

                                if(vals.classes!=""&& vals.classes !=undefined) {var count_classes=vals.classes.length}else{count_classes=0}
                                str+='<h3 class="acc_title" style="background-color:#ddd;cursor:pointer;padding:18px 10px;margin-top:-3px;border-bottom: 1px solid #dddddd;font-size:14px;font-weight:bold;">Year: '+vals.year+'</h3>';
                                str+='<div class="up_down" style="cursor:pointer;top:5px;margin-right: 2px;"><span class="count_lessons count_assigned">('+count_classes+')</span></div>';
                                str+='<div class="collapsed" style="display: none">';

                                str+='<div class="row" style="width: 100%;margin-left: 0;">';

                                //ok  console.log('Year:'+vals.year);

                                if(vals.classes!=""&& vals.classes !=undefined) {
                                    $.each(vals.classes, function (key1, val1) {
                                        if(val1.students!=""&& val1.students !=undefined) {var count_students=val1.students.length}else{count_students=0}
                                        str+='<h3 class="acc_title" style="background-color:#eee; cursor:pointer;padding:10px;;margin-top:-5px;border-bottom: 1px solid #eeeeee;font-size:14px;">Class: '+val1.group_name+'</h3>';
                                        str+='<div class="up_down" style="cursor:pointer;top:5px;padding-right: 2px;"><span class="count_lessons count_assigned">('+count_students+')</span></div>';
                                        str+='<div class="collapsed" style="display: none">';
                                        str+='<div class="row clearfix " style="padding: 5px 0px 15px 0px;">';

                                        //ok   console.log(val1.group_name);
                                        if(val1.students!=""&& val1.students !=undefined) {
                                            $.each(val1.students, function (key2, val2) {
                                                str+='<div class="col-sm-12 col-md-6">';
                                                //str+='<a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/'+val2.subject_ids+'/'+val2.year_id+'/'+val2.class_id+'/'+val2.ids+'">';
                                                str+='<a class="ediface-student col-sm-12 col-md-11" style="border-bottom: 1px solid #ccc;padding-bottom: 5px;padding-top: 10px;width: 100%;" href="/g1_teacher/student/'+val2.ids+'">';
                                                str+='<span class="pull-left">'+val2.first_name +' '+ val2.last_name+'</span>';
                                                str+='<span class="pull-right glyphicon glyphicon-chevron-right"></span></a>';
                                                str+='</div>';


                                                //console.log(val2.first_name,val2.last_name);
                                            })
                                        }

                                        str+='</div>';
                                        str+='</div>';
                                    });
                                }

                                str+='</div>';
                                str+='</div>';
                            });
                        }

                        str+='</div>';
                        str+='</div>';



                        $('.f1').append(str);

                    });


                    self.prev('span').removeClass('preloader').addClass('a');
                    $('.f1').fadeIn(300);





                }
                else {
                    self.prev('span').removeClass('preloader').addClass('a');
                }




            }
        })
    })







})
