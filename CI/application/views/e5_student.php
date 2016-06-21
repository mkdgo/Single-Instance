<link rel="stylesheet" href="/js/reveal/css/reveal.css">
<link rel="stylesheet" href="/js/reveal/css/theme/ediface.css" id="theme">
<link rel="stylesheet" href="/js/reveal/lib/css/zenburn.css">
<?php $running = strpos($_SERVER['REQUEST_URI'], "running") ? true : false; ?>
<?php if(!$running): ?>
<a style="position:fixed;top:50%;left:15px;visibility:visible;cursor: pointer;z-index:3000;" href="javascript:rprev()" id="leftarrow"> <img src="/img/arrow_left.png"/> </a>
<a style="position:fixed;top:50%;right:15px;visibility:visible;cursor: pointer;z-index:3000;" href="javascript:rnext()" id="rightarrow"> <img src="/img/arrow_right.png"/> </a>
<script type="text/javascript">
    function rnext() {
        Reveal.next();
        updateslides();
    }

    function rprev() {
        Reveal.prev();
        updateslides();
    }

    function updateslides() {	
        if(Reveal.isFirstSlide() && Reveal.isLastSlide()) {
            $('#leftarrow').css("visibility", "hidden");
            $('#rightarrow').css("visibility", "hidden");
        } else if(Reveal.isFirstSlide()) {
            $('#leftarrow').css("visibility", "hidden");
            $('#rightarrow').css("visibility", "visible");
        } else if(Reveal.isLastSlide()) {
            $('#leftarrow').css("visibility", "visible");
            $('#rightarrow').css("visibility", "hidden");
        } else {
            $('#leftarrow').css("visibility", "visible");
            $('#rightarrow').css("visibility", "visible");
        }
    }
</script>
<?php endif ?>
<style>
    .ui-body-c { background-image: none; background: none; }
    .ui-overlay-c { background-image: none; }
    .ui-page { background-image: none; background: none; }
    
    .close_text {
        margin:0 30px 0 20px;display: inline-block;
        background: #229a4c;
        color: #fff;
        font-size: 15px;
        font-family: 'Open Sans';
        font-weight: normal;
        text-align: center;
        line-height: 46px;
        padding: 0 15px;
        min-width: 86px;
        margin-left: 10px;
        text-transform: uppercase;
    }
    .fullscreen {
        outline: none!important;
        width: 39px;
        height: 39px;
        right: -17px;
        top: 21px;
        float: right;
        background-image: url('/res/icons/move1.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-size: 35px 35px;
        -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);
        z-index: 1000;
    }
    iframe { min-height: 600px; }
</style>
<script type="text/javascript">
    <?php //if($running): ?>
//    $('#staticheader').css("visibility", "hidden");
    <?php //endif ?>

    $('#staticheader').css("background-color", "#229a4c");
    $('#backbutton').css("border-left", "solid 1px #1e8b46");
    $('.left a').css("border-right", "solid 1px #1e8b46");
    $('.right a').css("border-right", "solid 1px #1e8b46");
    $('.right a').css("border-left", "solid 1px #1e8b46");
    $('.gray_top_field').css("background-color", "#229a4c");
    $('.gray_top_field').css("top", "0px");
    $('.gray_top_field').css("height", "47px");
    $('.present').css("top", "-250px");
    $('.ui-overlay-c').removeAttr("background-image");
    $('.ui-overlay-c').removeAttr("background");
    $('.ui-body-c').removeAttr("background-image");
    $('.ui-body-c').removeAttr("background");
    $('.ui-page').removeAttr("background-color");
    $('.ui-page').removeAttr("background-image");
    $('#bootstrap').remove();
</script>
<div class="reveal">
	<!-- Any section element inside of this container is displayed as a slide -->
	<div class="slides" rel={lesson_id}>
		{items}
		<section id="sl_{cont_page_id}" rel="{cont_page_id}" quiz="{quiz}">
			<h1>{cont_page_title}</h1>
			<p>{cont_page_text}</p>
			{resources}
			<div class="slideresource{quiz} sl_res_{resource_id}">
                <div class="slide_click" onclick="{slide_click}" style="display: none;"></div>
                {fullscreen}
                {preview}
			</div>
			<br />
			{/resources}
		</section>
		{/items}
	</div>
</div>
<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="popupError" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CLOSE</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="/js/reveal/lib/js/head.min.js"></script>
<script src="/js/reveal/js/reveal.js"></script>
<script type="text/javascript">
	// Full list of configuration options available here:
	// https://github.com/hakimel/reveal.js#configuration
	Reveal.initialize({
		controls : false,
		progress : true,
		history : true,
        top : true,
		center : true,
		margin : 0.1,
		<?php if($running): ?>
		touch: false,
		<?php endif ?>
		theme : Reveal.getQueryHash().theme, // available themes are in /css/theme
		transition : Reveal.getQueryHash().transition || 'default', // none/fade/slide/convex/concave/zoom

		// Parallax scrolling
		// parallaxBackgroundImage: 'https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg',
		// parallaxBackgroundSize: '2100px 900px',

		// Optional libraries used to extend on reveal.js
        multiplex: {
            secret: null, //'14235697133762470241', // Obtained from the socket.io server. Gives this (the master) control of the presentation
            id: '<?php echo $socketId ?>', // '922dd9e615730322', // Obtained from socket.io server
            url: 'http://77.72.3.90:1948' // Location of socket.io server
        },

		dependencies : [
            { src: '//cdnjs.cloudflare.com/ajax/libs/socket.io/0.9.16/socket.io.min.js', async: true },
            { src : '/js/reveal/plugin/multiplex/client.js', async: true },
            { src : '/js/reveal/lib/js/classList.js', condition : function() { return !document.body.classList; } },
            { src : '/js/reveal/plugin/markdown/marked.js', condition : function() { return !!document.querySelector('[data-markdown]'); } },
            { src : '/js/reveal/plugin/markdown/markdown.js', condition : function() { return !!document.querySelector('[data-markdown]'); } },
            { src : '/js/reveal/plugin/highlight/highlight.js', async : true, callback : function() { hljs.initHighlightingOnLoad(); } },
            { src : '/js/reveal/plugin/zoom-js/zoom.js', async : true, condition : function() { return !!document.body.classList; } },
            { src : '/js/reveal/plugin/notes/notes.js', async : true, condition : function() { return !!document.body.classList; } }
        ]
	});
	<?php if(!$running): ?>
	Reveal.addEventListener('slidechanged', updateslides());
    <?php else: ?>
    Reveal.addEventListener('slidechanged', updatewindow());
	<?php endif ?>

	Reveal.configure({
	    keyboard: {
	        39: null, 
	        37: null// go to the next slide when the ENTER key is pressed
	    },
        enter: 'top',
	});

    var behavior = 'online';
    var teacher_id = "<?php echo $teacher_id; ?>";
    var teacher_name = "<?php echo $teacher_name; ?>";
    var subject_id = "<?php echo $subject_id; ?>";
    var subject_name = '<?php echo $subject_name; ?>';
    var year = "<?php echo $year; ?>";
    var class_id = '<?php echo $class_id; ?>';
    var class_name = '<?php echo $class_name; ?>';
    var lesson_title = '<?php echo $lesson_title; ?>';
    var marked = 0;
    var socketId = '<?php echo $socketId; ?>';


    $(document).ready(function (){
        <?php if(!$running): ?>
        $('.submit-answer').html('Check Answer');
        behavior = 'offline';
        <?php else: ?>
        <?php endif ?>
        $('.slide_click').click();
    })

    function updatewindow() {
//        Reveal.up();
        $('html, body').animate({ scrollTop: 0 }, 'fast');
//        $('html, body').animate({ scrollTop: 0 }, 'fast');
//        scroll(0,0);
//        window.scrollTo(0, 0);
//console.log( 'updatewindow' ); 
    }

    function submitAnswer( tbl_id, form_id, this_btn ) {
        var submited = $(this_btn).attr('rel');
        $(this_btn).attr('rel', 1);
//        $(this_btn).hide();

        if( submited == 1 ) {
            $(this_btn).hide();
            return false;
        } else {
            var lesson_id = $('.slides').attr('rel');
            var slide_id = form_id.parent().parent().parent().attr('rel');
            var identity = socketId;
            form_id.addClass('quiz-container-feedback');
            form_id.find('input[name="lesson_id"]').val(lesson_id);
            form_id.find('input[name="slide_id"]').val(slide_id);
            form_id.find('input[name="identity"]').val(identity);
            form_id.find('input[name="behavior"]').val(behavior);
            form_id.append('<input type="hidden" name="teacher_id" value="'+teacher_id+'" />');
            form_id.append('<input type="hidden" name="teacher_name" value="'+teacher_name+'" />');
            form_id.append('<input type="hidden" name="subject_id" value="'+subject_id+'" />');
            form_id.append('<input type="hidden" name="subject_name" value="'+subject_name+'" />');
            form_id.append('<input type="hidden" name="year" value="'+year+'" />');
            form_id.append('<input type="hidden" name="class_id" value="'+class_id+'" />');
            form_id.append('<input type="hidden" name="class_name" value="'+class_name+'" />');
            form_id.append('<input type="hidden" name="lesson_title" value="'+lesson_title+'" />');

            post_data = form_id.serialize();
            $.post( "/e5_student/saveAnswer", {res_id: form_id.attr('name'), post_data: post_data}, function( data ) {
                if( behavior != 'offline' ) {
                    $(this_btn).hide();
                    $('#sl_'+slide_id).find(tbl_id).css( 'display','none' );
                    form_id.find('input').attr('disabled','disabled');
                    form_id.find('.ans').attr('onclick','');
                } else {
                    $(this_btn).hide();
                    form_id.find('input').attr('disabled',true);
                    form_id.find('.ans').attr('onclick','');
                    $.each(data.answers,function(key,val){
                        $('#'+key).addClass(val.class);
                        if(val.value) {
                            $('#'+key).after('<span class="'+val.class+'-value">'+val.value+'</span>');
                        }
                    })
                    $('#sl_'+slide_id).find(tbl_id).html( data.html );
                }
    /*
                var f = $('#'+tbl_id.attr('rel')).height();
                var srh = $('.sl_res_'+tbl_id.attr('rel')).height();
                var trh = tbl_id.height();
                if( (f + trh) > srh ) {
    //                $('.sl_res_'+tbl_id.attr('rel')).height(srh+tbl_id.height());
                }
    //*/
            },'json');
        }
    }

    function setResult(res_id) {
        $('#form_'+res_id).find('input').attr('disabled',true);
        var lesson_id = $('.slides').attr('rel');
        var slide_id = $('#form_'+res_id).parent().parent().parent().attr('rel');
//*
        $.get( "/e5_student/getStudentAnswers", { lesson_id: lesson_id, slide_id: slide_id, resource_id: res_id, marked: marked, behavior: behavior }, function( data ) {
            switch(data.type) {
                case 'single_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'multiple_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'fill_in_the_blank':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i].key).val(data.answers[i].val);
                    }
                    break;
                case 'mark_the_words':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#q'+res_id+data.answers[i]).css('background', '#ff0');
                    }
                    break;
            }
            $('.tbl_'+res_id).html(data.html.html);
            $('.tbl_'+res_id).attr('onclick','');
        },'json');
//*/
    }

    function showResult(res_id) {
        
        $('#form_'+res_id).find('.submit-answer').attr('onclick','closedQuiz()');

        $('#form_'+res_id).find('input').attr('disabled',true);
        $('#form_'+res_id).find('input').attr('disabled',true);
        $('#form_'+res_id).find('.ans').attr('onclick','');
        $('#form_'+res_id).find('.ans').removeClass('choice-true');
        $('#form_'+res_id).find('.ans').removeClass('choice-wrong');
        $('#form_'+res_id).find('.choice-correct-radio-value').remove();
        $('#form_'+res_id).find('.choice-wrong-radio-value').remove();
        $('#form_'+res_id).find('.choice-correct-value').remove();
        $('#form_'+res_id).find('.choice-wrong-value').remove();
        $('#form_'+res_id).find('.choice-correct-mark-value').remove();
        $('#form_'+res_id).find('.choice-wrong-mark-value').remove();
        $('#form_'+res_id).find('.choice-correct-fill-value').remove();
        $('#form_'+res_id).find('.choice-wrong-fill-value').remove();
        $('#form_'+res_id).find('label.choice-correct-radio').attr('class', '');
        $('#form_'+res_id).find('label.choice-wrong-radio').attr('class', '');
        $('#form_'+res_id).find('input.choice-wrong').attr('class', '');
        $('#form_'+res_id).find('input.choice-wrong-fill').attr('class', '');
        $('#form_'+res_id).find('input.choice-true').attr('class', '');
        $('#form_'+res_id).find('input.choice-correct').attr('class', '');
        $('#form_'+res_id).find('input.choice-correct-fill').attr('class', '');

        var lesson_id = $('.slides').attr('rel');
        var slide_id = $('#form_'+res_id).parent().parent().parent().attr('rel');
//*
//        $.get( "/e5_student/checkStudentAnswers", { lesson_id: lesson_id, slide_id: slide_id, resource_id: res_id }, function( data ) {
        $.get( "/e5_student/getStudentAnswers", { lesson_id: lesson_id, slide_id: slide_id, resource_id: res_id, marked: marked, behavior: behavior }, function( data ) {
            switch(data.type) {
                case 'single_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'multiple_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'fill_in_the_blank':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i].key).val(data.answers[i].val);
                    }
                    break;
                case 'mark_the_words':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#q'+res_id+data.answers[i]).css('background', '#53EEEB');
                    }
                    break;
            }
            $('#form_'+res_id).parent().addClass('quiz-container-feedback');

            $.each(data.html.answers,function(key,val){
                $('#'+key).addClass(val.class);
                if(val.value) {
                    $('#'+key).after('<span class="'+val.class+'-value">'+val.value+'</span>');
                }
            })

            $('.tbl_'+res_id).html(data.html.html);
            $('.tbl_'+res_id).attr('onclick','');
        },'json');
//*/
    }

    function closedQuiz() {
        $( $('#popupError').find('.modal-body p')).text("You can't submit your answers since the teacher closed the quiz.");
        $('#popupError').modal('show');
    }

</script>
<?php if(!$running): ?>
<div class="clear" style="height: 1px;"></div>
<footer>
	<div class="container clearfix">
		<div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
            <a href="{close}" class="green_btn close_text">{close_text}</a>
	    </div>
	</div>
</footer>
<?php endif ?>
