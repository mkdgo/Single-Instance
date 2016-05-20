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
        width: 39px; height: 39px; right: -17px; top: 21px; float: right;
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
    iframe { text-align: center; min-height: 600px; }
    section .slideresource { min-height: 600px; }
    .tbl_results { width: 50%; margin-bottom: 10px; }
    .tbl_results th { padding: 5px; border-bottom: 1px solid; }
    .tbl_results td { padding: 5px; border-right: 1px solid; }
    .tbl_results td.ans_res { padding: 5px; border-right: none; text-align: center; }
</style>
<?php $preview = strpos($_SERVER['REQUEST_URI'], "view") ? true : false; ?>
<?php if (!$preview): ?>
    <div style="width: 340px; height: 100%; padding-top:50px; position: fixed; display: block; z-index: 1; transform-origin: 100% 50% 0px; transition: all 0.3s ease 0s;" class="meny">
        <a href="javascript:meny.close()" style="text-decoration: none" id="menyclose" >X</a>
        <h1>Student List </h1>
        <div id="studentlist">
            <ul>
                {students}
                <li style="width: 270px;" data-student-id="{id}">
                    <span id="student_{id}" class="online{online} student">&nbsp;</span>
                    <label style="font-size: 13px;">{first_name} {last_name}</label>
                    <span class="glyphicon glyphicon-paperclip pull-right class-student" style="line-height: 28px; cursor: pointer;"></span>
                </li>
                {/students}
            </ul>
        </div>
    </div>
    <div class="meny-arrow">
        <a href="javascript:meny.open()" tyle="text-decoration: none" id="menyopen">|||</a>
    </div>
<?php endif ?>
<div class="contents">
    <?php if (!$preview): ?>
    <a style="position:fixed;top:50%;left:40px;visibility:visible;cursor: pointer;z-index:2000;" href="javascript:rprev()" id="leftarrow"> <img src="/img/arrow_left.png"/> </a>
    <a style="position:fixed;top:50%;right:40px;visibility:visible;cursor: pointer;z-index:2000;" href="javascript:rnext()" id="rightarrow"> <img src="/img/arrow_right.png"/> </a>
    <?php endif ?>
    <div class="reveal">
        <!-- Any section element inside of this container is displayed as a slide -->
        <div class="slides">
            {items}
            <section id="sl_{cont_page_id}" rel="{cont_page_id}" quiz="{quiz}">
                <h1>{cont_page_title}</h1>
                <p>{cont_page_text}</p>
                {resources}
                <div class="slideresource sl_res_{resource_id}">
                    {fullscreen}
                    {preview}
                </div>
                <br />
                    {result_table}
                {/resources}
<!--                {questions}
                <div class="int_question">
                    {question_resource_img_preview} <h1>{question_text}</h1>
                    {answers}
                    <label for="{question_num}_{answer_num}">{answer_text}</label>
                    <input type="checkbox" disabled id="{question_num}_{answer_num}" name="questions[{question_num}][]" value="{answer_num}" {answer_is_checked} />
                    {/answers}
                </div>
                {/questions}
                {if no_questions > 0}
                <br>
                <h3>No questions defined on the slide!</h3>
                {/if}-->
            </section>
            {/items}
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>

<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
    <?php if( !$preview ): ?>
            <a id="finish_quiz" href="javascript:;" onclick="finishQuiz()" class="green_btn close_text" style="display: none;">REVEAL ANSWERS</a>
    <?php endif ?>
            <a href="{close}" class="green_btn close_text">{close_text}</a>
        </div>
    </div>
</footer>
<!--<script src="/js/reveal/lib/js/head.min.js"></script>
<script src="/js/reveal/js/reveal.js"></script>
<script type="text/javascript" src="/js/meny/js/meny.js"></script>-->
<script type="text/javascript">
    var many;
    var preview = '<?php echo $type; ?>';
    var lesson_id = '<?php echo $lesson_id; ?>';
    var identity = '<?php echo $socketId; ?>';
    var slides = <?php echo $slides ?>;
    var current_slide = <?php echo $current_slide ?>;

$(window).load(function () {
/*
    //    setIframeHeight(document.getElementsByTagName('iframe'));
$('iframe').load(function() {
    resizeClientIframe();
});
//    setIframeHeight($('iframe'));
//    setIframeHeight(document.getElementById('your-frame-id'));
//*/
});

    $('#staticheader').css("visibility", "visible");
    $('#staticheader').css("background-color", "#229a4c");
    $('.gray_top_field').css("background-color", "#229a4c");
    $('.gray_top_field').css("top", "150px");
    $('#backbutton').css("border-left", "solid 1px #1e8b46");
    $('.left a').css("border-right", "solid 1px #1e8b46");
    $('.right a').css("border-right", "solid 1px #1e8b46");
    $('.right a').css("border-left", "solid 1px #1e8b46");
    $('.ui-overlay-c').removeAttr("background-image");
    $('.ui-overlay-c').removeAttr("background");
    $('.ui-body-c').removeAttr("background-image");
    $('.ui-body-c').removeAttr("background");
    $('.ui-page').removeAttr("background-color");
    $('.ui-page').removeAttr("background-image");
    $('#bootstrap').remove();

    $(document).ready(function (){
        if( $('#sl_'+slides[current_slide]).attr('quiz') == 1 ) {
            $('#finish_quiz').show();
        }

        $('iframe').each(function(){
            var url = $(this).attr("src");
            $(this).attr("src", url + "?wmode=transparent");
//    setIframeHeight(this);


        });

        $('forms').find('input').attr('disabled',true);

        
        // Full list of configuration options available here:
        // https://github.com/hakimel/reveal.js#configuration
        Reveal.initialize({
            controls : false,
            progress : false,
            history : true,
            center : true,
            margin : 0.1,
            slideNumber: false,
            theme : Reveal.getQueryHash().theme, // available themes are in /css/theme
            transition : Reveal.getQueryHash().transition || 'default', // none/fade/slide/convex/concave/zoom

            // Parallax scrolling
            // parallaxBackgroundImage: 'https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg',
            // parallaxBackgroundSize: '2100px 900px',

            // Optional libraries used to extend on reveal.js
            multiplex: {
                secret: '<?php echo $secret ?>', //'14235697133762470241', // Obtained from the socket.io server. Gives this (the master) control of the presentation
                id: '<?php echo $socketId ?>', // '922dd9e615730322', // Obtained from socket.io server
                url: 'http://77.72.3.90:1948' // Location of socket.io server
            },
            dependencies : [
                { src: '//cdnjs.cloudflare.com/ajax/libs/socket.io/0.9.16/socket.io.min.js', async: true },
                { src : '/js/reveal/plugin/multiplex/master.js', async: true },
                { src : '/js/reveal/lib/js/classList.js', condition : function() { return !document.body.classList; } },
                { src : '/js/reveal/plugin/markdown/marked.js', condition : function() { return !!document.querySelector('[data-markdown]'); } },
                { src : '/js/reveal/plugin/markdown/markdown.js', condition : function() { return !!document.querySelector('[data-markdown]'); } },
                { src : '/js/reveal/plugin/highlight/highlight.js', async : true, callback : function() { hljs.initHighlightingOnLoad(); } },
                { src : '/js/reveal/plugin/zoom-js/zoom.js', async : true, condition : function() { return !!document.body.classList; } },
                { src : '/js/reveal/plugin/notes/notes.js', async : true, condition : function() { return !!document.body.classList; } }
            ]
        });
        addEventListener('ready', updateslides());
        Reveal.addEventListener('slidechanged', updateslides());
        Reveal.configure({
            keyboard: {
    <?php if ($preview): ?>
                '39': null,
                '37': null// go to the next slide when the ENTER key is pressed
    <?php else: ?>
                '39': function(){rnext()},
                '37': function(){rprev()}// go to the next slide when the ENTER key is pressed
    <?php endif ?>
            }
        });

    <?php if (!$preview): ?>
        // Create an instance of Meny
        meny = Meny.create({
            // The element that will be animated in from off screen
            menuElement : document.querySelector('.meny'),
            // The contents that gets pushed aside while Meny is active
            contentsElement : document.querySelector('.contents'),
            // [optional] The alignment of the menu (top/right/bottom/left)
            position : Meny.getQuery().p || 'left',
            // [optional] The height of the menu (when using top/bottom position)
            height : 200,
            // [optional] The width of the menu (when using left/right position)
            width : 340,
            // [optional] Distance from mouse (in pixels) when menu should open
            threshold : 40,
            // [optional] Use mouse movement to automatically open/close
            mouse : false,
            // [optional] Use touch swipe events to open/close
            touch : false,
            // Width(in px) of the thin line you see on screen when menu is in closed position.
            overlap : 0,
            // The total time taken by menu animation.
            transitionDuration : '0.3s',
            // Transition style for menu animations
            transitionEasing : 'ease',
        });
        // API Methods:
        // meny.open();
        // meny.close();
        // meny.isOpen();

        // Events:
        // meny.addEventListener( 'open', function(){ console.log( 'open' ); } );
        // meny.addEventListener( 'close', function(){ console.log( 'close' ); } );

        // Embed an iframe if a URL is passed in
        /* if(Meny.getQuery().u && Meny.getQuery().u.match(/^http/gi)) {
            var contents = document.querySelector('.contents');
            contents.style.padding = '0px';
            contents.innerHTML = '<div class="cover"></div><iframe src="' + Meny.getQuery().u + '" style="width: 100%; height: 100%; border: 0; position: absolute;"></iframe>';
        } */
    <?php endif ?>
//        current_slide = Reveal.getIndices().h;
    });

    function rnext() {
//        current_slide += 1;
        Reveal.next();
        updateslides();
    }

    function rprev() {
//        current_slide -= 1;
        Reveal.prev();
        updateslides();
    }

    function updatestudents() {
        //var pathArray = window.location.href.split( '/' );
        var slideno = parseInt(window.location.hash.substring(2, 3)) + 1;
        if (isNaN(slideno)) {
            slideno = 1;
        }
        //alert('current: '+slideno);
        $.ajax({
            url: '/ajax/interactive_lessons_ajax/new_slide/' + {lesson},
                dataType: 'json',
                type: 'POST',
                data: { slide: slideno },
                success: function() {
//                alert('Next slide ');
            }
        });
    }

    function updateslides() {
        if (Reveal.isFirstSlide() && Reveal.isLastSlide()) {
            $('#leftarrow').css("visibility", "hidden");
            $('#rightarrow').css("visibility", "hidden");
        } else if (Reveal.isFirstSlide()) {
            $('#leftarrow').css("visibility", "hidden");
            $('#rightarrow').css("visibility", "visible");
        } else if (Reveal.isLastSlide()) {
            $('#leftarrow').css("visibility", "visible");
            $('#rightarrow').css("visibility", "hidden");
        } else {
            $('#leftarrow').css("visibility", "visible");
            $('#rightarrow').css("visibility", "visible");
        }
        current_slide = Reveal.getIndices().h;
        if( $('#sl_'+slides[current_slide]).attr('quiz') == 1 ) {
            $('#finish_quiz').show();
        } else {
            $('#finish_quiz').hide();
        }
//            updatestudents()
    }

    function refreshTableAnswer( tbl_id, form_id ) {
        var rtype = form_id.attr('rel');
//console.log( form_id );
        if( preview == 'view' ) { return false; }
        $.post( "/e5_teacher/updateResults", {res_id: tbl_id.attr('rel'), lesson_id: lesson_id, identity: identity}, function( data ) {

            $('#sl_'+lesson_id).find(tbl_id).html( data );
            switch( rtype ) {
                case 'single_choice' : singleChart(tbl_id.attr('rel'),data); break;
                case 'multiple_choice' : multipleChart(tbl_id.attr('rel'),data); break;
                case 'fill_in_the_blank' : fillChart(tbl_id.attr('rel'),data); break;
                case 'mark_the_words' : markChart(tbl_id.attr('rel'),data); break;
            }

            var f = $('#'+tbl_id.attr('rel')).height();
            var srh = $('.sl_res_'+tbl_id.attr('rel')).height();
            var trh = $('#chart_'+tbl_id.attr('rel')).height();
//console.log( f );
//console.log( srh );
//console.log( trh );
            if( (f + trh) > srh ) {
                $('.sl_res_'+tbl_id.attr('rel')).height(srh+trh);
            }

        },'json');
    }

    function finishQuiz() {
        $.get( "/e5_teacher/showResults", { lesson_id: lesson_id, identity: identity, slide_id: slides[current_slide]}, function( data ) {});
    }


    if( window.location.href.indexOf('/running') != -1) {
        setInterval(function() { $('.refreshTableAnswer').click(); }, 4000);
    }




    function setIframeHeight(iframe) {

var h = iframe.contents().find("html").outerHeight(true);
console.log(h);
        

        var bod = $(iframe).find($('#document body'));
        
//        var parentDocHeight = parent.getDocumentHeight();
        if (iframe) {
//            var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
//            var iframeWin = iframe.contentWindow;
//console.log( bod );
//            if (iframeWin.document.body) {

//                iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
//            }
        }
    };



function resizeClientIframe() {
    var clientIframe = $('iframe'),//document.getElementById('clientIframe'),
        doc = clientIframe.contentWindow.document,
        trueHeight = Math.max(
            Math.max(doc.body.scrollHeight, doc.documentElement.scrollHeight),
            Math.max(doc.body.offsetHeight, doc.documentElement.offsetHeight),
            Math.max(doc.body.clientHeight, doc.documentElement.clientHeight)
        );

    clientIframe.style.width = trueHeight + 'px';
}

</script>
<script type="text/javascript">
    $(document).ready(function() {
        var subject_id = <?php echo $subject_id; ?>;
        var assignments = null;
        $('span.class-student').click(function(){
            var o = $(this);
            $('#in-lesson-work-assignments span.select span.v').addClass('disabled-control');
            $('#in-lesson-work-assignments span.select span.a').addClass('disabled-control');
            $('#in_lesson_work_tagged_students').val('-' + o.parent().attr('data-student-id') + '-');
            $.ajax({
                type: "GET",
                url: '<?php echo base_url() ?>' + 'work/get_student_data',
                data: 'student_id=' + o.parent().attr('data-student-id'),
                dataType: 'json',
                success: function (data) {
                    $('#inLessonTagWorkModal #in_lesson_work_subject').find("option:gt(0)").remove();
                    $('#inLessonTagWorkModal #in_lesson_work_uuid').val(data.identifier);
                    $('#inLessonTagWorkModal #student_name').text(data.student.fullname);
                    if (data.student.hasSubjects) {
                        $.each(data.student.subjects, function (k, v) {
                            $('#inLessonTagWorkModal #in_lesson_work_subject').append('<option value="' + k + '">' + v + '</option>');
                        });
                        $('#inLessonTagWorkModal #in_lesson_work_subject').val(subject_id);
                        $('#inLessonTagWorkModal #in_lesson_work_subject').trigger('change');
                    }
                    $('#inLessonTagWorkModal').modal('show');
                }
            });
        });
        
        $('#inLessonTagWorkModal #in_lesson_work_subject').change(function() {
            if (parseInt($(this).val(), 10) > 0) {
                $('#inLessonTagWorkModal #no_in_lesson_subject_selected').hide();
                $('#inLessonTagWorkModal #in_lesson_work_subject').parent().removeClass('error-element');
                var addedStudents = $('#inLessonTagWorkModal #in_lesson_work_tagged_students').val().split('-');
                var studentID = addedStudents[1];
                var selectedSubject = $('#inLessonTagWorkModal #in_lesson_work_subject').val();
                $.ajax({
                    url: '/work/load_student_assignments',
                    data: {student_id: studentID, subject_id: selectedSubject},
                    dataType: "json",
                    success: function (data) {
                        if (data.hasAssignments) {
                            $('#inLessonTagWorkModal #in_lesson_work_assignment').find("option:gt(0)").remove();
                            $.each(data.assignments, function (subject, v) {
                                $.each(v, function (k, vv) {
                                    $('#inLessonTagWorkModal #in_lesson_work_assignment').append('<option value="' + vv.id + '">' + vv.title + '</option>');
                                });
                            });
                            $('#inLessonTagWorkModal #in-lesson-work-assignments span.select span.v').removeClass('disabled-control').text('Select Assignment');
                            $('#inLessonTagWorkModal #in-lesson-work-assignments span.select span.a').removeClass('disabled-control');
                            $('#inLessonTagWorkModal #in_lesson_work_assignment').removeAttr('disabled');
                        } else {
                            $('#inLessonTagWorkModal #in_lesson_work_assignment').find("option:gt(0)").remove();
                            $('#inLessonTagWorkModal #in_lesson_work_assignment option[value="0"]').text('No assignments found');
                            $('#inLessonTagWorkModal #in-lesson-work-assignments span.select span.v').text('No assignments found');
                            $('#inLessonTagWorkModal #in_lesson_work_assignment').trigger('change');
                            $('#inLessonTagWorkModal #in-lesson-work-assignments span.select span.v').addClass('disabled-control');
                            $('#inLessonTagWorkModal #in-lesson-work-assignments span.select span.a').addClass('disabled-control');
                            $('#inLessonTagWorkModal #in_lesson_work_assignment').attr('disabled', 'disabled');
                        }
                    }
                });
            } else {
                $('#in-lesson-work-assignments span.select span.v').addClass('disabled-control').text('Select Subject First');
                $('#in-lesson-work-assignments span.select span.a').addClass('disabled-control');
            }
        });
        
        $('#inLessonTagWorkModal #submitInLessonURLButton').click(function () {
            var url = $('#inLessonTagWorkModal #in_lesson_work_resource_link').val();
            if (validInLessonURL(url)) {
                $('#inLessonTagWorkModal #invalidInLessonWorkURL').hide();
                $('#inLessonTagWorkModal #in_lesson_work_resource_remote div.fc').removeClass('error-element');
                $.ajax({
                    type: "POST",
                    url: '<?php echo base_url() ?>' + 'work/url_upload',
                    data: 'url=' + url + '&uuid=' + $('#inLessonTagWorkModal #in_lesson_work_uuid').val(),
                    dataType: 'json',
                    success: function (data) {
                        $('#inLessonTagWorkModal #submitInLessonURLButton .ladda-label').text('Added');
                        $('#inLessonTagWorkModal #addedInLessonWorkItems table').append('\n\
                            <tr data-id="' + data.id + '">\n\
                                <td class="width-10-percent text-center"><span class="icon ' + data.type + '"></span></td>\n\
                                <td class="text-left">' + data.name + '</td>\n\
                                <td class="width-10-percent text-center">\n\
                                    <a href="javascript: deleteInLessonWorkItem(' + data.id + ',\'' + data.fullname + '\');" class="delete2"></a>\n\
                                </td>\n\
                            </tr>');
                        $('#inLessonTagWorkModal #addedInLessonWorkItems').parent().removeClass('hidden');
                        $('#inLessonTagWorkModal #unsubmittedInLessonWorkURL').hide();
                        $('#inLessonTagWorkModal #in_lesson_work_resource_remote div.fc').removeClass('error-element');
                        setTimeout(function () {
                            $('#inLessonTagWorkModal #submitInLessonURLButton .ladda-label').text('Add');
                            $('#inLessonTagWorkModal #in_lesson_work_resource_link').val('');
                        }, 300);
                    }
                });
            } else {
                $('#inLessonTagWorkModal #invalidInLessonWorkURL').show();
                $('#inLessonTagWorkModal #in_lesson_work_resource_remote div.fc').addClass('error-element');
            }
            return false;
        });
        
        $('#inLessonWorkItemDeleteBtn').click(function () {
            var id = $('#deleteInLessonWorkItemID').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>' + 'work/delete_temp_item',
                dataType: "json",
                data: {id: id, uuid: $('#inLessonTagWorkModal #in_lesson_work_uuid').val()},
                success: (function () {
                    $('#inLessonWorkItemDelete').modal('hide');
                    $('#inLessonTagWorkModal tr[data-id="' + id + '"]').remove();
                    if ($('#inLessonTagWorkModal tr[data-id]').length == 0) {
                        $('#inLessonTagWorkModal #addedInLessonWorkItems').parent().addClass('hidden');
                    }
                })
            });
        });

        $('#inLessonTagWorkModal').on('hidden.bs.modal', function (e) {
            $('#inLessonTagWorkModal #in_lesson_work_title').val('');
            $('#inLessonTagWorkModal #submit_work').show();
            $('#inLessonTagWorkModal .tag-work-buttons .text-error').hide();
            $('#inLessonTagWorkModal .tag-work-buttons .text-success').hide();
            $('#inLessonTagWorkModal .tag-work-buttons .text-pending').hide();
            $('#inLessonTagWorkModal #addedInLessonWorkItems table').html('');
            $('#inLessonTagWorkModal #addedInLessonWorkItems').parent().addClass('hidden');
            $('#inLessonTagWorkModal #in_lesson_submit_work').show();
        });

        $('#inLessonTagWorkModal #in_lesson_submit_work').click(function () {
            var url = $('#inLessonTagWorkModal #in_lesson_work_resource_link').val();
            if ($.trim(url) != '') {
                $('#inLessonTagWorkModal #unsubmittedInLessonWorkURL').show();
                $('#inLessonTagWorkModal #in_lesson_work_resource_remote div.fc').addClass('error-element');
                $('#inLessonTagWorkModal #in_lesson_submit_work').show();
                return;
            }
            var workTitle = $.trim($('#inLessonTagWorkModal #in_lesson_work_title').val());
            if (workTitle == '') {
                $('#inLessonTagWorkModal #no_in_lesson_title_entered').show();
                $('#inLessonTagWorkModal #in_lesson_work_title').addClass('error-element');
                $('#inLessonTagWorkModal #in_lesson_submit_work').show();
                return;
            }
            var subject = parseInt($('#inLessonTagWorkModal #in_lesson_work_subject').val(), 10);
            if (!subject > 0) {
                $('#inLessonTagWorkModal #no_in_lesson_subject_selected').show();
                $('#inLessonTagWorkModal #in_lesson_work_subject').parent().addClass('error-element');
                $('#inLessonTagWorkModal #in_lesson_submit_work').show();
                return;
            }
            $('#inLessonTagWorkModal .tag-work-buttons .text-error').hide();
            $('#inLessonTagWorkModal .tag-work-buttons .text-success').hide();
            $('#inLessonTagWorkModal .tag-work-buttons .text-pending').show();
            $('#inLessonTagWorkModal #in_lesson_submit_work').hide();
            var assignment = $('#inLessonTagWorkModal #in_lesson_work_assignment').val();
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>' + 'work/save_work',
                dataType: "json",
                data: {
                    'taggedStudents': $('#in_lesson_work_tagged_students').val(),
                    'title': workTitle,
                    'subject': subject,
                    'assignment': assignment,
                    'uuid': $('#inLessonTagWorkModal #in_lesson_work_uuid').val()
                },
                success: function (data) {
                    if (data.status) {
                        $('#inLessonTagWorkModal .tag-work-buttons .text-pending').hide();
                        $('#inLessonTagWorkModal .tag-work-buttons .text-success').show();
                        setTimeout(function () {
                            $('#inLessonTagWorkModal').modal('hide');
                        }, 3000);
                    } else {
                        $('#inLessonTagWorkModal #in_lesson_submit_work').show();
                        $('#inLessonTagWorkModal .tag-work-buttons .text-error').show();
                        $('#inLessonTagWorkModal .tag-work-buttons .text-success').hide();
                        $('#inLessonTagWorkModal .tag-work-buttons .text-pending').hide();
                    }
                },
                error: function () {
                    $('#inLessonTagWorkModal #in_lesson_submit_work').show();
                    $('#inLessonTagWorkModal .tag-work-buttons .text-error').show();
                    $('#inLessonTagWorkModal .tag-work-buttons .text-success').hide();
                    $('#inLessonTagWorkModal .tag-work-buttons .text-pending').hide();
                }
            });
        });

        $('#inLessonTagWorkModal #in_lesson_work_title').change(function () {
            if (parseInt($.trim($(this).val()).length, 10) > 0) {
                $('#inLessonTagWorkModal #no_in_lesson_title_entered').hide();
                $('#inLessonTagWorkModal #in_lesson_work_title').removeClass('error-element');
            }
        });

        var il_wl = Ladda.create(document.querySelector('.in-lesson-work-progress-demo .ladda-button'));
        var il_w_start_timer = 0;
        var il_manualuploader = $('#inLessonTagWorkModal #in-lesson-work-manual-fine-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'work/item_upload'
            },
            validation: {
                allowedExtensions: ['jpg|JPEG|png|doc|docx|xls|xlsx|pdf|ppt|pptx'],
                sizeLimit: 22120000, // 20000 kB -- 20mb max size of each file
                itemLimit: 40
            },
            autoUpload: true,
            text: {
                uploadButton: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;'
            }
        }).on('progress', function (event, id, filename, uploadedBytes, totalBytes) {
            if (il_w_start_timer == 0) {
                $('#inLessonTagWorkModal #in_lesson_work_file_uploaded').val('');
                $('#inLessonTagWorkModal #in_lesson_work_file_uploaded_label').text('');
                $('#inLessonTagWorkModal .upload_box').hide();
                il_wl.start();
            }
            il_w_start_timer++;
            var wProgressPercent = (uploadedBytes / totalBytes).toFixed(2);
            if (isNaN(wProgressPercent)) {
                $('#inLessonTagWorkModal #in_lesson_work_resource_file #progress-text').text('');
            } else {
                var progress = (wProgressPercent * 100).toFixed();
                il_wl.setProgress((progress / 100));
                if (uploadedBytes == totalBytes) {
                    il_wl.stop();
                }
            }
        }).on('upload', function (event, id, filename) {
            clearTimeout(tmOut);
            $(this).fineUploader('setParams', {'filename': filename, 'uuid': $('#in_lesson_work_uuid').val()});
        }).on('complete', function (event, id, file_name, responseJSON) {
            il_w_start_timer = 0;
            var data = JSON.parse(JSON.stringify(responseJSON));
            $('#inLessonTagWorkModal #addedInLessonWorkItems table').append('\n\
                            <tr data-id="' + data.id + '">\n\
                                <td class="width-10-percent text-center"><span class="icon ' + data.type + '"></span></td>\n\
                                <td class="text-left">' + data.name + '</td>\n\
                                <td class="width-10-percent text-center">\n\
                                    <a href="javascript: deleteInLessonWorkItem(' + data.id + ',\'' + data.fullname + '\');" class="delete2"></a>\n\
                                </td>\n\
                            </tr>');
            $('#inLessonTagWorkModal #addedInLessonWorkItems').parent().removeClass('hidden');
            $('#inLessonTagWorkModal #in_lesson_work_resource_file .ladda-label').text('File Uploaded. Add Another?');
            $('#inLessonTagWorkModal #in_lesson_work_resource_file #in_lesson_work_file_uploaded').val(data.name);
            $('#inLessonTagWorkModal #in_lesson_work_resource_file #in_lesson_work_file_uploaded_label').text(file_name);
            $('#inLessonTagWorkModal #in_lesson_work_resource_file .upload_box').fadeIn(300);
            tmOut = setTimeout(function () {
                $('#inLessonTagWorkModal #in_lesson_work_resource_file .ladda-label').text('Browse File');
                $('#inLessonTagWorkModal #in_lesson_work_resource_file .upload_box').hide();
                $('#inLessonTagWorkModal #in_lesson_work_resource_file #in_lesson_work_file_uploaded').val('');
                $('#inLessonTagWorkModal #in_lesson_work_resource_file #in_lesson_work_file_uploaded_label').text('');
            }, 3000);
        });
    });
    
    function changeInLessonTagWorkResourceType() {
        if ($('#inLessonTagWorkModal input[name="in_lesson_work_resource_remote_ctrl"]:checked').val() == 1) {
            $('#inLessonTagWorkModal #in_lesson_work_resource_url').removeClass('required');
            $('#inLessonTagWorkModal #in_lesson_work_resource_link').addClass('required');
            $('#inLessonTagWorkModal #in_lesson_work_resource_file').hide();
            $('#inLessonTagWorkModal #in_lesson_work_resource_remote').show();
        } else {
            $('#inLessonTagWorkModal #in_lesson_work_resource_file').show();
            $('#inLessonTagWorkModal #in_lesson_work_resource_remote').hide();
            $('#inLessonTagWorkModal #in_lesson_work_resource_url').addClass('required');
            $('#inLessonTagWorkModal #in_lesson_work_resource_link').removeClass('required');
        }
    }
    
    function validInLessonURL(url) {
        var RegExp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/i
        if (RegExp.test(url)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteInLessonWorkItem(id, name) {
        $('#deleteInLessonWorkItemName').text(name);
        $('#deleteInLessonWorkItemID').val(id);
        $('#inLessonWorkItemDelete').modal({
            backdrop: 'static'
        });
    }

</script>

<div id="inLessonTagWorkModal" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="tag-work-modal-header">
                <h4 class="modal-title">In Lesson Tag Work</h4>
            </div>
            <div class="tag-work-modal-body">
                <form class="form-horizontal" id="inLessonFormWorkModal">
                    <input type="hidden" name="in_lesson_work_uuid" id="in_lesson_work_uuid" />
                    <div class="form-group grey no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left">Work Type:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <fieldset onchange="changeInLessonTagWorkResourceType();" data-role="controlgroup" data-type="horizontal" data-role="fieldcontain" class="radio_like_button pull-left" style="width: 100%;"> 
                                <input type="radio" name="in_lesson_work_resource_remote_ctrl" id="in_lesson_work_resource_remote0" value="0">
                                <label for="in_lesson_work_resource_remote0" class="pull-left">Local file</label>
                                <input type="radio" name="in_lesson_work_resource_remote_ctrl" id="in_lesson_work_resource_remote1" value="1" checked="checked">
                                <label for="in_lesson_work_resource_remote1" class="pull-left">Online file</label>
                            </fieldset> 
                        </div>
                        <div class="col-sm-9 col-sm-offset-3 col-xs-12 hidden">
                            <div class="padding-top-15px" id="addedInLessonWorkItems">
                                <table class="table"></table>
                            </div>
                        </div>
                    </div>

                    <div id="in_lesson_work_resource_file" class="form-group grey no-side-margin side-padding-3" style="display: none;">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left" for="in_lesson_work_resource_url">Work File:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <div class="controls" style="position: relative">
                                <span></span>
                                <section class="in-lesson-work-progress-demo" style="padding:0 10px; margin-top: 13px; float: left;">
                                    <div id="in-lesson-work-manual-fine-uploader"style="padding:10px; width:140px; position:absolute; z-index:100; margin-top:0px;"></div>
                                    <button class="ladda-button" data-color="blue" data-size="s" data-style="expand-right" type="button">Browse File</button>
                                </section>
                                <div class="c2_radios upload_box" style="float: left; margin-top: 13px; display: none;">
                                    <input type="checkbox" id="in_lesson_work_file_uploaded_f" value="" disabled="disabled" checked="checked">
                                    <label for="in_lesson_work_file_uploaded_f" id="in_lesson_work_file_uploaded_label" style="width: auto!important;float: left;"></label>
                                </div>
                                <div class="error_filesize"></div>
                            </div>
                        </div>
                    </div>

                    <div id="in_lesson_work_resource_remote" class="form-group grey no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="in_lesson_work_resource_link" class="scaled pull-left">Work URL:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <div class="field search controls">
                                <span id="invalidInLessonWorkURL" class="tip2" style="display: none;">Work URL is not valid!</span>
                                <span id="unsubmittedInLessonWorkURL" class="tip2" style="display: none;">Please confirm the URL by pressing the 'Add' button!</span>
                                <button id="submitInLessonURLButton" class="ladda-button" data-color="blue" data-style="zoom-in"><span class="ladda-label">Add</span></button>
                                <div class="fc">
                                    <input type="text" name="in_lesson_work_resource_link" id="in_lesson_work_resource_link" data-validation-required-message="Please provide a resource file or location">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="in_lesson_work_taggees" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label class="scaled pull-left">Student:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" id="in_lesson_work_tagged_students" name="in_lesson_work_tagged_students" style="display: none;" />
                            <label id="student_name" class="scaled pull-left" style="padding-left: 15px;"></label>
                        </div>
                    </div>

                    <div class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="in_lesson_work_title" class="scaled pull-left">Title:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <span id="no_in_lesson_title_entered" class="tip2" style="display: none;">Please enter title!</span>
                            <input type="text" name="in_lesson_work_title" id="in_lesson_work_title" placeholder="Type a title" />
                        </div>
                    </div>

                    <div id="in-lesson-work-subject" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="in_lesson_work_subject" class="scaled pull-left">Subject:</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <span id="no_in_lesson_subject_selected" class="tip2" style="display: none;">Please select subject!</span>
                            <select name="in_lesson_work_subject" id="in_lesson_work_subject">
                                <option value="0">Select Subject</option>
                            </select>
                        </div>
                    </div>

                    <div id="in-lesson-work-assignments" class="form-group no-side-margin side-padding-3">
                        <div class="col-sm-3 col-xs-12">
                            <label for="in_lesson_work_assignment" class="scaled pull-left">Tag to Assignment?</label>
                        </div>
                        <div class="col-sm-9 col-xs-12">
                            <select name="in_lesson_work_assignment" id="in_lesson_work_assignment" disabled="disabled">
                                <option value="0">Select Subject First</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tag-work-modal-footer tag-work-buttons">
                <h5 class="ajax-error text-error" style="display: none; text-align: right;">An error occurred while trying to submit your feedback.</h5>
                <h5 class="tag-work-pending text-pending" style="display: none; text-align: right;">Saving work, please wait...</h5>
                <h5 class="tag-work-complete text-success" style="display: none; text-align: right;">Your work has been saved.</h5>
                <button type="button" class="btn green_btn" id="in_lesson_submit_work">SAVE</button>
            </div>
        </div>
    </div>
</div>

<div id="inLessonWorkItemDelete" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <input type="hidden" id="deleteInLessonWorkItemID" />
            <div class="modal-body">Please confirm you would like to delete the work item "<span id="deleteInLessonWorkItemName" style="word-wrap: break-word; color: #e74c3c;"></span>"?</div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="inLessonWorkItemDeleteBtn" type="button" class="btn orange_btn del_resource">CONFIRM</button>
            </div>
        </div>
    </div>
</div>
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
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart','controls','bar']});
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
//        nrpChart();

    }
</script>
