$(document).bind("mobileinit", function() {
    $.mobile.ajaxEnabled = false;
    $.autoInitializePage = true;
});

function showFooterMessage(O) {
    if( O.status != 'undefined' ) {
        if(O.status == 'success') {
            $('prefooter > .container').html('<p><span class="circle-ok"><span class="glyphicon glyphicon-ok"></span></span>'+O.mess+'</p>');
            $('prefooter > .container p').css('background', '#128c44');
            $('prefooter > .container p').css('color', '#fff' );
            $('prefooter > .container p').css('padding', '20px');
        } else if(O.status == 'alert' ) {
            $('prefooter > .container').html('<p><span class="circle-alert"><span>!</span></span>'+O.mess+'</p>');
            $('prefooter > .container p').css('background', '#fcaa57');
            $('prefooter > .container p').css('color', '#fff' );
            $('prefooter > .container p').css('padding', '20px');
        }
    } else {
        $('prefooter > .container').html('<p style="">'+O.mess+'</p>');
        $('prefooter > .container p').css('background', O.clr);
        $('prefooter > .container p').css('color', O.clrT);
        $('prefooter > .container p').css('padding', '20px');
    }

    $('prefooter').show();
    $('prefooter').delay( O.anim_a ).fadeOut( O.anim_b, function() {
        $('prefooter').hide();
        if(O.onFinish)eval(O.onFinish);
    });
}

$(document).ready(function() {

    $('prefooter').hide();
    //alert('prefooter');

    $('.int_less_publish').change(function() {
        var data = $('form#int_lesson_form').serialize();
        $.ajax({
            url: '/ajax/interactive_lessons_ajax/save_publish/',
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function(data) { }
        });
    });
    $('a.template_id').click(function(e) {
        e.preventDefault();
        var template_id = $(this).attr('id').replace('template_', '');
        $('div.ui-controlgroup-controls').find('a.active_template').removeClass('active_template');
        $(this).addClass('active_template');

        $('input#tmpl_id').val(template_id);
    });
    var teml_id = $('input#tmpl_id').val();
    if (teml_id !== '') {
        $('#template_' + teml_id).addClass('active_template');
    }

    //Interactive assessments
    $('.add_question a').on('click', function(e) {
        e.preventDefault();
        var cloned_elem = $(".hidden.question_box:first").clone(true, true);
        var subject_id = $("input.subject_id").val();
        var module_id = $("input.module_id").val();
        var lesson_id = $("input.lesson_id").val();
        var int_les_id = $("input.int_les_id").val();
        var int_assessment_id = $("input.int_assessment_id").val();
        $('#questions_wrap').append(cloned_elem);
        var last_q_num = parseInt($('#questions_wrap .question_box').last().index());
        $('#questions_wrap .question_box').last().find('input.question_text').attr('name', 'questions[' + last_q_num + '][question_text]');
        $('#questions_wrap .question_box').last().find('input.question_id').attr('name', 'questions[question][' + last_q_num + '][question_id]');
        $('#questions_wrap .question_box').last().find('input.resource_id').attr('name', 'questions[' + last_q_num + '][question_resource_id]');
        $('#questions_wrap .question_box').last().find('a.add_q_ressource').attr('href', '/c1/index/question/' + last_q_num + '/' + subject_id + '/' + module_id + '/' + lesson_id + '/' + int_assessment_id);
        $('.question_box').last().removeClass('hidden');
    });

    $('.add_option').on('click', function(e) {
        e.preventDefault();

        var option_text = $(this).parent().parent().find('input.add_option_text');
        var option_text_val = option_text.val();
        $(option_text).val('');
        var count_options = $(this).parent().parent().parent().find('.q_options_list').children().length;
        if (count_options <= 10) {
            var cloned_option = $(this).parent().parent().parent().find(".hidden.q_option").clone();

            $.each(cloned_option.find('select'), function(index, value) {
                var element = $(this);
                var index = element.attr('id');
                index++;
                element.attr('id', index);
                element.slider();
                element.slider('refresh');
                element.parent().find('.ui-slider').last().remove();
            });
            var append_to = $(this).parent().parent().parent().find('.q_options_list');
            $(append_to).append(cloned_option);
            $(this).parent().parent().parent().find('.q_options_list .q_option:last input.option_text').val(option_text_val);
            var num_q = parseInt($(this).parent().parent().parent().parent('.question_box').index());
            $(this).parent().parent().parent().find('.q_options_list .q_option:last input.option_text').attr('name', 'questions[' + num_q + '][answers][' + (parseInt(count_options) - 1) + '][answer_text]');
            $(this).parent().parent().parent().find('.q_options_list .q_option:last select.answer').attr('name', 'questions[' + num_q + '][answers][' + (parseInt(count_options) - 1) + '][answer_true]');
            $(this).parent().parent().parent().find('.q_options_list .q_option:last').removeClass('hidden');
        }
    });

    $(document).on('click', '.delete_option', function(e) {
        e.preventDefault();
        $(this).parent().parent('.q_option').remove();
    });

    // save interactive assesment temp data
    $('a.add_q_ressource').click(function(e) {
        e.preventDefault();
        var data = $('form#int_assessment_form').serialize();
        var data_url = $(this).attr('href');
        $.ajax({
            url: '/ajax/int_assessment_ajax/save_temp_data/',
            dataType: 'json',
            type: 'POST',
            data: data,
            success: function(data) {
                if (data.success) {
                    window.location.href = data_url;
                }
            }
        });
    });

    $('.colorbox').colorbox({ photo: true, maxWidth: "100%", maxHeight: "100%"});

    if (user_type == 'student') {
        intervalRes = setInterval(function() { checkRunningLesson(); }, 3000);
    } else if (user_type == 'teacher') {
        intervalRes = setInterval(function() { checkRunningLessonForTeacher(); }, 5000);	
        setInterval(function() { checkOnlineStudents(); }, 5000);
    } else if (window.location.href.indexOf('/e5_teacher') != -1 && window.location.href.indexOf('/running') != -1) {			
        setInterval(function() { checkOnlineStudents(); }, 5000);
    }

    $('.add_option_text').keypress(function (e) {
        var key = e.which;

        if (key == 13) // the enter key code
        {
            var option_button = $(this).parent().parent().parent().find('.add_option');
            //$(this).parent().parent().find('.add_option').click();
            $(option_button).click();
            //if ($(option_button).length !== 0)
            //	alert('found');

            //alert($('.add_option').length);
            //alert($(this).parent().parent().html());

            return false;  
        }
    });
    /*
        $('input[type=file]').each(function(){
        var v = $(this).prop('value');
        //var p = $(this).prop('placeholder');
        if(!v) v = 'u';
        //if(!p) p = 'Choose File';
        $(this).after('<span class="file"><span class="v">'+v+'</span></span>');
        //$(this).addClass('customize');
        });

        $('.file').on('click', function(){
        $(this).prev().trigger('click');
        });

        $('input[type=file]').on('change', function(){
        var v = $(this).prop('value');
        if(!v) v = '';
        $(this).next().find('.v').text(v);
        });
        */
    //$('').css({height:'auto'})
/*
    function expandTextarea(id) {
        var $element = $('.textarea_fixed').get(0);

        $element.addEventListener('keyup', function() {
            this.style.overflow = 'hidden';
            this.style.height = 0;
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }

    expandTextarea('#resource_desc');
*/

    $.each($('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;
        var resizeTextarea = function(el) {
            $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
            if($(el).val().length==0) {
                $(el).css({'height':62+'px'});
            }
        };
        $(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });

    $('textarea').each(function() {
        var sh = this.scrollHeight;
        var h = $(this).outerHeight();
                //var lh = parseInt($(this).css('line-height'));
               // var pt = parseInt($(this).css('padding-top'));
    }).on('keyup', function(){
        var sh = this.scrollHeight;
        var h = $(this).outerHeight();
        if(sh+2>h) {
            $(this).scrollTop(0).css({
                'height':sh + 2 +'px'
            });
        }
    });

    $('.keywords').each(function(){
        var t = this;
        var $t = $(t);
        var $input = $('> input', t);
        var keys = $input.val(); 
        ke = keys.slice(1, -1);  

        keys = ke.split(',');

        var addKeyword = function(key, onlyDraw){
            if(key) {
                if(!onlyDraw) {
                    var keys2 = $input.val();
                    keys2 = keys2.split(',');
                    keys2.push(key);
                    keys2 = keys2.join();
                    keys2 = keys2.toString();
                    keys2 = keys2.replace(/[\])}[{(]/g,'');

                    $input.val(keys2);
                }
                $('.input-container', t).before('<div class="keyword"><span>'+key+'</span><a class="remove"></a></div>');
                $('.list').html('');
            }
        }
        var removeKeyword = function(){
            var keys2 = $input.val();

            keys2 = keys2.split(',');

            keys2 = keys2.toString();
            keys2 = keys2.replace(/[\])}[{(]/g,'');
            keys2 = keys2.split(',');

            var i = $(this).parent().index()-2;

            keys2.splice(i,1);

            $input.val(keys2);

            $(this).parent().remove();

            $('.list').html('');

        }
        $input.css({'display':'none'});
        $t.append('<div class="input-container"><input value="" type="text"><div><div class="list"></div>');
        if(keys.length) {
            $.each(keys, function(i,v){
                addKeyword(v, true);
            });
        }

        $t.on('keyup', '.input-container input', function(){
            var v = $(this).val();
            var to = $t.data('to');
            if(to) clearTimeout(to); to = false;
            if(v){
                to = setTimeout(function(){
                    $.ajax({
                        url:'/c2/suggestKeywords',
                        data:{q:v},
                        dataType:"json",
                        success: function(data){
                            var list = '';
                            $.each(data,function(i,v){
                                list += '<li>'+v+'</li>';
                            });
                            $('.list').html('<ul>'+list+'</ul>');

                        }
                    });
                }, 200);
                $t.data('to', to);
            }
        }).on('keydown', '.input-container input', function(e){
            var v = $(this).val();
            if(e.keyCode == 13 && v) {
                $(this).val('');
                addKeyword(v);
            }
        }).on('click', '.list li', function(){
            var v = $(this).text();
            if(v) {
                $('.input-container input', t).val('');
                addKeyword(v);
            }
        }).on('click', '.keyword .remove', function(){
            removeKeyword.call(this);
        });

        $(document).click(function(e){
            var c = $('.input-container input').val();
//            var c = $('.list li ').text();
            if(c!='') {
                addKeyword(c);
                $('.input-container input').val('');
            }

            var env = $(e.target).closest('li');

            if(env[0]===undefined) {
                $('.list').html('')
            } else {
            }
        });
    });
    //end keywords

    $('.keystudents').each(function(){
        var t = this;
        var $t = $(t);
        var $exist = $('> input#keystudents', t);
        var $input = $('> input#keystudents_a', t);
        var keyst = $input.val(); 
        var keyst1 = $exist.val(); 
//console.log( t );
//console.log( $t );
//console.log( $exist );
//console.log( $input );
//console.log( keyst );
        kest = keyst.slice(1, -1);  
        kest1 = keyst1.slice(1, -1);  

        keyst = kest.split(',');
        keyst1 = kest1.split(',');

        var addKeystudent = function(key, kid, onlyDraw){
            if(key) {
                if(!onlyDraw) {
                    var keys2 = $input.val();
                    var keys3 = $exist.val();
console.log( keys2 );
console.log( keys3 );
//                    keys2 = keys2.split(',');
//console.log( keys2 );
//                    keys2.push(key);
//console.log( keys2 );
//                    keys2 = keys2.join();
//console.log( keys2 );
//                    keys2 = keys2.toString();
//console.log( keys2 );
//                    keys2 = keys2.replace(/[\])}[{(]/g,'');
                    keys2 = keys2 + key+',';
                    keys3 = keys3 + kid+',';
console.log( keys2 );
console.log( keys3 );
                    $input.val(keys2);
                    $exist.val(keys3);
console.log( $input.val() );
console.log( $exist.val() );
                }
                $('.input-container', t).before('<div class="keystudent"><span>'+key+'</span><a class="remove"></a></div>');
                $('.list').html('');
            }
        }
        var removeKeystudent = function(){
            var keys2 = $input.val();

            keys2 = keys2.split(',');

            keys2 = keys2.toString();
            keys2 = keys2.replace(/[\])}[{(]/g,'');
            keys2 = keys2.split(',');

            var i = $(this).parent().index()-2;

            keys2.splice(i,1);

            $input.val(keys2);

            $(this).parent().remove();

            $('.list').html('');

        }
        $input.css({'display':'none'});
        $t.append('<div class="input-container"><input value="" type="text"><div><div class="list"></div>');
        if(keyst.length) {
            $.each(keyst, function(i,v){
                addKeystudent(v, i, true);
            });
        }

        $t.on('keyup', '.input-container input', function(){
            var v = $(this).val();
            var to = $t.data('to');
            if(to) clearTimeout(to); to = false;
            if(v){
                to = setTimeout(function(){
                    $.ajax({
                        url:'/f2c_teacher/suggestKeystudents',
                        data:{q:v},
                        dataType:"json",
                        success: function(data){
                            var list = '';
                            $.each(data,function(i,v){
                                list += '<li rel="'+i+'">'+v+'</li>';
                            });
                            $('.list').html('<ul>'+list+'</ul>');
                            updateSlideHeight(".step.s3")
                        }
                    });
                }, 200);
                $t.data('to', to);
            }
        }).on('keydown', '.input-container input', function(e){
            var v = $(this).val();
            var k = $(this).attr('rel');
            if(e.keyCode == 13 && v) {
                $(this).val('');
                addKeystudent(v,k);
//                updateSlideHeight(".step.s3")
            }
        }).on('click', '.list li', function(){
            var v = $(this).text();
            var k = $(this).attr('rel');
            if(v) {
                $('.input-container input', t).val('');
                addKeystudent(v,k);
//                updateSlideHeight(".step.s3")
            }
        }).on('click', '.keystudent .remove', function(){
            removeKeystudent.call(this);
        });

        $(document).click(function(e){
            var c = $('.input-container input').val();
//            var c = $('.list li ').text();
            if(c!='') {
                addKeystudent(c);
                $('.input-container input').val('');
            }

            var env = $(e.target).closest('li');

            if(env[0]===undefined) {
                $('.list').html('')
            } else {
            }
        });
    });
    //end keystudents

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

    initPublishButton('#publish_btn', 'publish', 'PUBLISHED', 'PUBLISH');

});

$(window).load(function(){
    bg_fix();
//    set_interval()
})
$(window).resize(function(){
        bg_fix()
})
//$(window).scroll(function(){
//    bg_fix();
//})

function initPublishButton(bt_selector, inp_name, label_1, label_0) {
    $(bt_selector).each(function(){
        if($('input[name='+inp_name+']').size() && $('input[name='+inp_name+']').val() == '1')$(this).addClass('active').text(label_1);
        $(this).off('click');

        $(this).on('click', function(){
            if( disablepublishandsave == 0 ) {
                if($('input[name='+inp_name+']').size()) {
                    if($('input[name='+inp_name+']').val() == '1') {
                        $('input[name='+inp_name+']').val('0');
                        $(this).removeClass('active').text(label_0);
                    } else {
                        $('input[name='+inp_name+']').val('1');
                        $(this).addClass('active').text(label_1);
                    }
                }
//console.log( $('input[name='+inp_name+']').val() );
            }
        })
    });
}

function bg_fix(){
    // .ui-header>.ui-btn-right
    var bhHeight = $('.blue_gradient_bg').height() - parseInt($('.blue_gradient_bg').css('margin-top')) - $('footer').height() - parseInt($('footer').css('border-top-width'));
    if(bhHeight<$(window).height())
        $('.blue_gradient_bg').css('min-height',parseInt($(window).height() - $('footer').height() - parseInt($('footer').css('border-top-width')) - parseInt($('.blue_gradient_bg').css('margin-top')) )+'px');

    if($('.red_gradient_bg').height()<$(window).height())
        $('.red_gradient_bg').css('min-height',parseInt($(window).height()-42 - $('.footer_menu').height())+'px')
    if($('.rred_gradient_bg').height()<$(window).height())
        $('.rred_gradient_bg').css('min-height',parseInt($(window).height())+'px')

    $('.ui-header>.ui-btn-right').css('left',parseInt($('.ui-header').width()/2 - $('.ui-header>.ui-btn-right').width()/2)+'px')

    if($(window).width()>768)
        $('.left_menu_pic').css('height',$('.pic_e5').height()+'px');
    else
        $('.left_menu_pic').css('height','auto');
}

function getPathnameParts() {
    var pathname = window.location.pathname;				
    if (pathname.substr(0, 1) == '/') {
        pathname = pathname.substr(1);
    }
    return pathname.split('/');
}

function checkRunningLesson() {
    set_logout()

    $.ajax({
        url: '/ajax/running_lesson/index/' + user_id,
        dataType: 'json',
        success: function(data) {
//console.log(data.toString());
//                var displaypage = data.running_page-1;
            if (data.subject_id !== undefined && data.module_id !== undefined && data.lesson_id !== undefined && data.secret !== undefined  /*data.running_page !== undefined && data.teacher_led !== undefined*/) {
                if (window.location.href.indexOf('/running') == -1) {
                    clearInterval(intervalRes); // stop calling checkRunningLesson()
                    $('#staticheader').css("background-color", "#009900");
                    $('.gray_top_field').css("background-color", "#004400");
                    $('#dialog_title').html('title');
                    $('#dialog').show();					

                    var start = new Date().getTime();
                    function updatePopupTitle() {
                        var secs = (new Date().getTime() - start) / 1000;
                        if (secs < 5) {
                            $('#dialog_title').html('Taking you to interactive lesson: <br /><span style="color:#004400;text-shadow:none;font-weight:bold;font-size:58px;font-style: italics;">' + data.lesson_title + '</span><br /> with ' + data.teacher_first_name + ' ' + data.teacher_last_name + ' in ' + Math.floor(5 - secs) + ' seconds...');											
                        } else {
                            clearInterval(intervalRes); // stop calling this function
                            window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/';//  + displaypage ;
                        }						
                    }					

                    updatePopupTitle();

                    intervalRes = setInterval(function() { updatePopupTitle();	}, 800);

                } else if ( window.location.href.indexOf('/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' ) == -1 ) {
                    window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/';// + displaypage;
                }
            } else if (window.location.href.indexOf('/running') != -1 && data.free_preview !== undefined) {
                window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1'; // + data.running_page;
            }
                /*
                else if (window.location.href.indexOf('/running') != -1 && $('#close_lesson').is(':hidden')) { // teacher-led running lesson
                var parts = getPathnameParts();
                parts[0] = 'd5_student';
                patts = parts.splice(5, 2);
                window.location.href = window.location.protocol + '//' + window.location.host + '/' + parts.join('/');

                } */
        }, error: function(data) {
//                    console.log(data.toString());
        }
    });
}

function checkRunningLessonForTeacher() {
    set_logout()
    $.ajax({
        url: '/ajax/running_lesson_t/index/' + user_id,
        dataType: 'json',
        success: function(data) {
            var displaypage = data.running_page-1;
            if (data.subject_id !== undefined && data.module_id !== undefined && data.lesson_id !== undefined && data.running_page !== undefined) {
                if (window.location.href.indexOf('/running') == -1) {
                    clearInterval(intervalRes); // stop calling this function

                    $('#staticheader').css("background-color", "#009900");
                    $('.gray_top_field').css("background-color", "#004400");
                    $('#dialog_title').html('title');
                    $('#dialog').show();					

                    var start = new Date().getTime();
                    function updatePopupTitle() {
                        var secs = (new Date().getTime() - start) / 1000;
                        if (secs < 5) {
                            $('#dialog_title').html('Returning you to your open interactive lesson: <br /><span style="color:#004400;text-shadow:none;font-weight:bold;font-size:58px;font-style: italics;">' + data.lesson_title + '</span><br /> in ' + Math.floor(5 - secs) + ' seconds...');
                        } else {
                            clearInterval(intervalRes); // stop calling this function
                                //window.location.href = '/e5_teacher/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + data.running_page;
                            window.location.href = '/e5_teacher/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + displaypage;
                        }						
                    }					

                    updatePopupTitle();
                    intervalRes = setInterval(function() { updatePopupTitle(); }, 800);
                }
            }
        }
    });
}

function checkOnlineStudents() {
    var parts = getPathnameParts();
    var lesson_id = parts[4];
    $.ajax({
        url: '/ajax/online_students/index/' + lesson_id,
        dataType: 'json',
        success: function(data) {
            $('#studentlist .student.online1').removeClass('online1').addClass('online0');
            for (index in data) {
                $('#studentlist #student_' + data[index]).removeClass('online0').addClass('online1');
            }
        }
    });

    var currentdate = new Date();
    var hours = currentdate.getHours();
    if (hours < 10)	{
        hours = '0' + hours;
    }
    var minutes = currentdate.getMinutes();
    if (minutes < 10)	{
        minutes = '0' + minutes;
    }

    $('#student_list #clock').html(hours + ':' + minutes);
}

function change_res(res){
    if(res==1){
        $('#all_resources').addClass('hidden');
        $('#my_resources').removeClass('hidden');                        
        $('#all_resources_button').removeClass('hidden');
        $('#my_resources_button').addClass('hidden');

    }else{
        $('#my_resources').addClass('hidden');
        $('#all_resources').removeClass('hidden');                        
        $('#all_resources_button').addClass('hidden');
        $('#my_resources_button').removeClass('hidden');

    }
}

function loadTinymce(){

    tinymce.init({
        selector: "textarea.mce-toolbar-grp",
        theme: "modern",
        mode:'exact',
//        entity_encoding : "raw",
//        encoding: "xml",
        plugins: "pagebreak table save charmap media contextmenu paste directionality noneditable visualchars nonbreaking spellchecker template",
        toolbar:" bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | table |",
        menu : { // this is the complete default configuration
                //file   : {},
                //edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
                //insert : {title : 'Insert', items : 'link media | template hr'},
                //view   : {},
                //format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                //table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
                //tools  : {}
        },
        setup : function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '14px';
                this.getDoc().body.style.letterSpacing = '0.8px';
                this.getDoc().body.style.lineHeight = '24px';
            }),
            ed.on('change', function () {
                tinymce.triggerSave();
            }),
            ed.on( 'submit',function(e) {
//                Encoder.EncodeType = "entity";

//                    var encoded = ed.getContent();
//                    encoded = encoded.replace(/'/g, "\\'");
//                    var encoded = encodeURIComponent(ed.getContent());
//                var encoded = Encoder.htmlEncode(ed.getContent());
                ed.getElement().value = ed.getContent(); //encoded;
//console.log( ed.getElement().value ); return false;
            });
        },
        contextmenu: "cut copy paste",
        menubar:true,
        statusbar: false,
        toolbar_item_size: "normal"
    });
}

function loadTinymceStudent(){

    tinymce.init({
        selector: "textarea.mce-toolbar-grp",
        theme: "modern",
        readonly : 1,
        mode:'exact',
//        entity_encoding : "raw",
//        encoding: "xml",
        plugins: "",
        toolbar:"|",
//        plugins: "pagebreak table save charmap media contextmenu paste directionality noneditable visualchars nonbreaking spellchecker template",
//        toolbar:" bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | table |",
        menu : { // this is the complete default configuration
                //file   : {},
                //edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
                //insert : {title : 'Insert', items : 'link media | template hr'},
                //view   : {},
                //format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                //table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
                //tools  : {}
        },
        setup : function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '14px';
                this.getDoc().body.style.letterSpacing = '0.8px';
                this.getDoc().body.style.lineHeight = '24px';
            }),
            ed.on('change', function () {
                tinymce.triggerSave();
            }),
            ed.on( 'submit',function(e) {
//                Encoder.EncodeType = "entity";

//                    var encoded = ed.getContent();
//                    encoded = encoded.replace(/'/g, "\\'");
//                    var encoded = encodeURIComponent(ed.getContent());
//                var encoded = Encoder.htmlEncode(ed.getContent());
                ed.getElement().value = ed.getContent(); //encoded;
//console.log( ed.getElement().value ); return false;
            });
        },
        contextmenu: "cut copy paste",
        menubar:true,
        statusbar: false,
        toolbar_item_size: "normal"
    });
}

function loadTinymceSlider(){

    tinymce.init({
        selector: "textarea.mce-toolbar-grp",
        theme: "modern",
        mode:'exact',
        plugins: "pagebreak table save charmap media contextmenu paste directionality noneditable visualchars nonbreaking spellchecker template",
        toolbar:" bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | table |",
        menu : { // this is the complete default configuration
            //file   : {},
            //edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall'},
            //insert : {title : 'Insert', items : 'link media | template hr'},
            //view   : {},
            //format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            //table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
            //tools  : {}
        },
        setup : function(ed) {
            ed.on('init', function() {
                this.getDoc().body.style.fontSize = '14px';
                this.getDoc().body.style.letterSpacing = '0.8px';
                this.getDoc().body.style.lineHeight = '24px';
                updateSlideHeight('.step.s1');
            }),
            ed.on('change', function () {
                tinymce.triggerSave();
            });
        },
        contextmenu: "cut copy paste",
        menubar:true,
        statusbar: false,
        toolbar_item_size: "normal"
    });
}

function validate() {
    var errors = [];
    $('input, select, textarea').each(
        function(index,i){
            var input = $(this);
            if($(input).hasClass("required")) {
                if(input.val().trim()==''||input.val() ===undefined) {
                    input.css({'border':'1px dashed red'});
                    var msg = input.attr('data-validation-required-message');
                    input.prev('span').attr('id','scrolled');
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
                    $('html, body').animate({ scrollTop: $('#scrolled').stop().offset().top-500 }, 300);
                    input.prev('span').removeAttr('scrolled');
                    errors[index] = 1;
                } else if(input.attr("minlength") !== undefined && input.val().length<input.attr("minlength")) {
                    input.css({'border':'1px dashed red'});
                    input.prev('span').attr('id','scrolled');
                    msg = "This must be at least " + input.attr("minlength")+' characters long';
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $('html, body').animate({ scrollTop: $('#scrolled').stop().offset().top-500 }, 300);
                    input.prev('span').removeAttr('scrolled');   
                    errors[index] = 1;
                }
            }

            input.on('focus',function(){
                input.prev('span.tip2').fadeOut('3333');
                input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
            })
        }
    );

    if(errors.length===0) {
        $('input:text, textarea').each( function() {
//            Encoder.EncodeType = "entity";
//            var encoded = Encoder.htmlEncode(this.value);
            $(this).val( this.value );
        })
        $('.hidden_submit').click();
    }
}  

function validate_slider( bln ) {
    var bl = bln;
    var errors = [];
    if( bl == 1 ) {
        $('input, select').each(
            function(index,i){  
                var input = $(this);
                if($(input).hasClass("required")) {
                    if(input.val().trim()==''||input.val() ===undefined) {
                        input.css({'border':'1px dashed red'});
                        var msg = input.attr('data-validation-required-message');
                        input.prev('span').attr('id','scrolled');
                        input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
                        //                            $('html, body').animate({
                        //        scrollTop: $('#scrolled').stop().offset().top
                        //    }, 300);
    //                    if( input.attr('id') == 'catg' || input.attr('id') == 'mark' ) { $('#add_new_cat').show(); }
                        input.prev('span').removeAttr('scrolled');
                        errors[index] = 1;
                    } else if(input.attr("minlength") !== undefined && input.val().length<input.attr("minlength")) {
                        input.css({'border':'1px dashed red'});
                        input.prev('span').attr('id','scrolled');
                        msg = "This must be at least " + input.attr("minlength")+' characters long';
                        input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
                        //                  $('html, body').animate({
                        //        scrollTop: $('#scrolled').stop().offset().top
                        //    }, 300);

                        input.prev('span').removeAttr('scrolled');
                        errors[index] = 1;
                    }
                }

                input.on('focus',function(){
                    input.prev('span.tip2').fadeOut('3333');
                    input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
                })
            }
        );
    }
//console.log( 'error : ' + errors );
    if(errors.length===0) {
        $('input:text, textarea').each( function() {
//            Encoder.EncodeType = "entity";
//            var encoded = Encoder.htmlEncode(this.value);
            $(this).val( this.value );
        })
        errors = [];
        return 0;
    } else {
        errors = [];
        return 1;
    }
} 

function validate_as_draft( bln ) {
    var bl = bln;
    var errors = [];
    var input = $('#assignment_title');
    if( bl == 1 ) {
        if(input.val().trim()==''||input.val() ===undefined) {
            input.css({'border':'1px dashed red'});
            var msg = input.attr('data-validation-required-message');
            input.prev('span').attr('id','scrolled');
            input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
            input.prev('span').removeAttr('scrolled');
            errors[0] = 1;
        }
        input.on('focus',function(){
            input.prev('span.tip2').fadeOut('3333');
            input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
        })
    }

//console.log( 'error : ' + errors );
    if(errors.length===0) {
//        $('input:text, textarea').each( function() {
//            $(this).val( this.value );
//        })
        errors = [];
        return 0;
    } else {
        errors = [];
        return 1;
    }
} 

function validate_to_publish( bln ) {
    var bl = bln;
    var valid = 1;
    var pdate = $(".pdatepicker").datepicker('getDate').getTime();
    var ddate = $(".datepicker").datepicker('getDate').getTime();
    if( (ddate - pdate) < (24*3600*1000) ) {
        opdate = $('#publish_date');
        oddate = $('#deadline_date');
                    oddate.css({'border':'1px dashed #fcaa57'});
                    var msg = oddate.attr('data-validation-required-message');
                    oddate.prev('span').attr('id','scrolled');
                    oddate.prev('span').html('').removeClass('tip3').addClass('tip3').append(msg).css({'display':'block'});
//                        if( input.attr('id') == 'catg' || input.attr('id') == 'mark' ) { $('#add_new_cat').show(); }
//console.log( input );
                    oddate.prev('span').removeAttr('scrolled');
//                    valid = 0;
//console.log( ddate - pdate );
    }

    if( $('#grade_type').val() != 'offline' ) {
        if($('#grade_categories_holder tr').length > 0) {
            $('.add_cat #mark').removeClass('required');
            $('.add_cat #catg').removeClass('required');
        } else {
            $('.add_cat #catg').addClass('required');
            $('.add_cat #mark').addClass('required');
        }
    }
    $('input, select').each(
        function(index,i){  
            var input = $(this);
            if($(input).hasClass("required")) {
                if( input.val().trim() == '' || input.val() === undefined ) {
                    input.css({'border':'1px dashed red'});
                    var msg = input.attr('data-validation-required-message');
                    input.prev('span').attr('id','scrolled');
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
//                        if( input.attr('id') == 'catg' || input.attr('id') == 'mark' ) { $('#add_new_cat').show(); }
//console.log( input );
                    input.prev('span').removeAttr('scrolled');
                    valid = 0;
                } else if(input.attr("minlength") !== undefined && input.val().length<input.attr("minlength")) {
                    input.css({'border':'1px dashed red'});
                    input.prev('span').attr('id','scrolled');
                    msg = "This must be at least " + input.attr("minlength")+' characters long';
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
                    input.prev('span').removeAttr('scrolled');
                    valid = 0;
                }
            }
            input.on('focus',function(){
                input.prev('span.tip2').fadeOut('3333');
                input.prev('span.tip3').fadeOut('3333');
                input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
            })
        }
    )
//console.log( valid );
    if( $(".classes:checked").length < 1 ) {
        $('.table4').css({'border':'1px dashed red'});
        var msg = 'You must choose at least one class!';
        $('.table4').prev('span').attr('id','scrolled');
        $('.table4').prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'});
        $('.table4').prev('span').removeAttr('scrolled');
//    $( $('#popupMessage').find('p')[0] ).text('You must add the summary information for the assignment!');
//    $($($('#popupMessage').find("div")[0]).find("div")[0]).html('You must add the summary information for the assignment!');
//    $('#popupMessage').modal('show');
//    showFooterMessage({mess: 'You must add the summary information for the assignment!', clrT: '#6b6b6b', clr: '#fcaa57', anim_a:3000, anim_b:12700});
        valid = 0;
        $('.classes').on('click',function(){
            $('.table4').prev('span.tip2').fadeOut('3333');
            $('.table4').css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
        })
    }
//console.log( valid );
    if( $('#grade_type').val() != 'offline' ) {
        $('#catg').removeClass('required');
        $('#mark').removeClass('required');
    }
//console.log( errors );
    return valid;
} 

function validate_resource() {
    var errors = [];
    $('input, select, textarea').each(
        function(index,i){  
            var input = $(this);
            if($(input).hasClass("required")) {
                if(input.val().trim()==''||input.val() ===undefined) {
                    input.css({'border':'1px dashed red'});
                    var msg = input.attr('data-validation-required-message');
                    input.prev('span').attr('id','scrolled');
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $('html, body').animate({ scrollTop: $('#scrolled').stop().offset().top-500 }, 300);
                    input.prev('span').removeAttr('scrolled');
                    errors[index] = 1;
                } else if(input.attr("minlength") !== undefined && input.val().length<input.attr("minlength")) {
                    input.css({'border':'1px dashed red'});
                    input.prev('span').attr('id','scrolled');
                    msg = "This must be at least " + input.attr("minlength")+' characters long';
                    input.prev('span').html('').removeClass('tip2').addClass('tip2').append(msg).css({'display':'block'}); 
                    $('html, body').animate({ scrollTop: $('#scrolled').stop().offset().top-500 }, 300);
                    input.prev('span').removeAttr('scrolled');   
                    errors[index] = 1;
                }
            }

            input.on('focus',function(){
                input.prev('span.tip2').fadeOut('3333');
                input.css({"border-color": "#c8c8c8","border-width":"1px","border-style":"solid"})
            })
        }
    );

    if(errors.length===0) {
        $('.red_btn').fadeOut(100);
        $('#saveform').submit()
    }
}

$(function () {
//    $('.collapsed').slideUp()

    $(document).on('click', '.up_down', function(e) {
        var next_div = $(this).next('.collapsed');
        var self = this;
        if( $(next_div).hasClass('hidden') ) { return false; }

        if ($(next_div).is(":visible")) {
            $(this).next('.collapsed').slideUp(400);
            $(this).css({'background-position': '0 1px'})
            $.session.set( $(this).next().attr('id'), 'none');
        } else {
            $(this).next('.collapsed').slideDown(400,function(){
                theOffset = $(self).offset();
                $('body,html').animate({ scrollTop: theOffset.top - 120  }, 300);
            });
            $(this).css({'background-position': '0 -36px'});
            $.session.set( $(this).next().attr('id'), 'block');
        }
    })

    $(document).on('click', '.acc_title', function(e) {
        var next_div = $(this).next().next('.collapsed');
        var self = this;
        if( $(next_div).hasClass('hidden') ) { return false; }

        if ($(next_div).is(":visible")) {
            $(this).next().next('.collapsed').slideUp(400);
            $(this).next('.up_down').css({'background-position': '0 1px'})
            $.session.set( $(this).next().next().attr('id'), 'none');
        } else {
            $(this).next().next('.collapsed').slideDown(400,function(){
                theOffset = $(self).offset();
                $('body,html').animate({ scrollTop: theOffset.top - 120  }, 300);
            });
            $(this).next('.up_down').css({'background-position': '0 -36px'});
            $.session.set( $(this).next().next().attr('id'), 'block');
        }
    })

    $('.up_down_homework').click(function () {
        var next_div = $(this).next('.collapsed');
        var self = this;
        if ($(next_div).is(":visible")) {
            $(this).next('.collapsed').slideUp(400);
            $(this).css({'background-position': '0 1px'})
        } else {
            $(this).next('.collapsed').slideDown(400,function(){
                theOffset = $(self).offset();
                $('body,html').animate({ scrollTop: theOffset.top - 120  }, 300);
            });
            $(this).css({'background-position': '0 -30px'});
        }
    })

    $('.assignment').show();
})


var timer = 0;
var timer1 = 0;
var set_timer = false;
var logout_sec = 10;
//var activity = 5000 // Eg: to set it to 5 mins, calculate 5 x60 sec = 300 sec = 300,000 millisec.
var activity = 7200000 // Eg: to set it to 2h mins, calculate  2h x60 min = 120min x60 sec = 7200 sec = 7,200,000 millisec.
function set_logout() {
    if( set_timer == false ) {
        set_timer = true;
        timer = setInterval("auto_logout()", activity);

        $('.dismiss-logout').on('click', function() {
            clearInterval(timer1);
            reset_logout();
        })
/*
        $(document).click(function(event) {
            reset_logout();
        })
        $(document).keyup(function(event) {
            reset_logout();
        })
        $(document).scroll(function(event) {
            reset_logout();
        })
        $(document).mousemove(function(event) {
            reset_logout();
        })
        $(document).mouseover(function(event) {
            reset_logout();
        })
//*/
//        $( "#dialog_logout" ).off( "mouseover" );
    }
}

function reset_logout() {
    //resets the timer. The timer is reset on each of the below events:
    // 1. mousemove   2. mouseclick   3. key press 4. scroliing
    //first step: clear the existing timer
    if (timer != 0 ) {
        clearInterval(timer);
        timer = setInterval("auto_logout()", activity);
        logout_sec = 10;
        $('#dialog_logout .logout_sec').text(logout_sec);
    }
}

function auto_logout() {
    $('#dialog_logout').modal('show');
    timer1 = setInterval("auto_logout2()", 1000);
}

function auto_logout2() {
    logout_sec--;
//console.log(logout_sec);
    $('#dialog_logout .logout_sec').text(logout_sec);
    if( logout_sec < 1 ) {
        window.location.href ="/logout/";
    }
}



