$(document).bind("mobileinit", function() {
	$.mobile.ajaxEnabled = false;
	$.autoInitializePage = true;
        
        
        
});
  
  
function showFooterMessage(O)
{
    $('prefooter').show();
    $('prefooter > .container').text(O.mess);
    $('prefooter > .container').css('background', O.clr);
}

  
$(document).ready(function() {
    

    
	$('.int_less_publish').change(function() {
		var data = $('form#int_lesson_form').serialize();
		$.ajax({
			url: '/ajax/interactive_lessons_ajax/save_publish/',
			dataType: 'json',
			type: 'POST',
			data: data,
			success: function(data) {

			}
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
		intervalRes = setInterval(function() { checkRunningLesson(); }, 1000);
	} else if (user_type == 'teacher') {
		intervalRes = setInterval(function() { checkRunningLessonForTeacher(); }, 1000);	
	} else if (window.location.href.indexOf('/e5_teacher') != -1 && window.location.href.indexOf('/running') != -1) {			
		setInterval(function() { checkOnlineStudents(); }, 1000);
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

});

$(window).load(function(){
    
    
    bg_fix();
    
    
})
$(window).resize(function(){
    bg_fix()
})
//$(window).scroll(function(){
//    bg_fix();
//})

function bg_fix(){
   // .ui-header>.ui-btn-right
    if($('.blue_gradient_bg').height()<$(window).height())
        $('.blue_gradient_bg').css('min-height',parseInt($(window).height()-42 - $('.footer_menu').height())+'px')
        
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
		$.ajax({
		url: '/ajax/running_lesson/index/' + user_id,
		dataType: 'json',
		success: function(data) {
			if (data.subject_id !== undefined && data.module_id !== undefined && data.lesson_id !== undefined && data.running_page !== undefined /*&& data.teacher_led !== undefined*/) {
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
							window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + data.running_page;
						}						
					}					
										
					updatePopupTitle();
										
					intervalRes = setInterval(function() { updatePopupTitle();	}, 800);
					
				} else if (/*data.teacher_led == '1' && */window.location.href.indexOf('/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + data.running_page) == -1) {
					window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + data.running_page;
				}
			}
			/*
			else if (window.location.href.indexOf('/running') != -1 && $('#close_lesson').is(':hidden')) { // teacher-led running lesson
				var parts = getPathnameParts();
				parts[0] = 'd5_student';
				patts = parts.splice(5, 2);
				window.location.href = window.location.protocol + '//' + window.location.host + '/' + parts.join('/');

			} */
			else if (window.location.href.indexOf('/running') != -1 && data.free_preview !== undefined) {
				window.location.href = '/e5_student/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1'; // + data.running_page;
			}
		}
	});
}

function checkRunningLessonForTeacher() {
	$.ajax({
		url: '/ajax/running_lesson_t/index/' + user_id,
		dataType: 'json',
		success: function(data) {
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
							window.location.href = '/e5_teacher/index/' + data.subject_id + '/' + data.module_id + '/' + data.lesson_id + '/1/running'+ '#/' + data.running_page;
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
			$('#student_list .student .online_student').removeClass('online_student').addClass('offline_student');
			for (index in data) {			
				$('#student_list #student_' + data[index]).removeClass('offline_student').addClass('online_student');
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
