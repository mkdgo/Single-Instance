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
		<section id="sl_{cont_page_id}" rel="{cont_page_id}">
			<h1>{cont_page_title}</h1>
			<p>{cont_page_text}</p>
			{resources}
			<div class="slideresource sl_res_{resource_id}">
                {fullscreen}
				{preview}
			</div>
			<br />
			{/resources}
		</section>
		{/items}
	</div>
</div>

<script src="/js/reveal/lib/js/head.min.js"></script>
<script src="/js/reveal/js/reveal.js"></script>
<script type="text/javascript">
	// Full list of configuration options available here:
	// https://github.com/hakimel/reveal.js#configuration
	Reveal.initialize({
		controls : false,
		progress : true,
		history : true,
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
	<?php endif ?>

	Reveal.configure({
	    keyboard: {
	        39: null, 
	        37: null// go to the next slide when the ENTER key is pressed
	    }
	});

    var behavior = 'online';
    $(document).ready(function (){
        <?php if(!$running): ?>
        $('.submit-answer').html('Check Answer');
        behavior = 'offline';
        <?php endif ?>
    })


    function submitAnswer( tbl_id, form_id, this_btn ) {
        var lesson_id = $('.slides').attr('rel');
        var slide_id = form_id.parent().parent().parent().attr('rel');
        var identity = '<?php echo $socketId; ?>';
//console.log( form_id.find('input[name="answer"]') );
//console.log( form_id.find('input[name="answer"]').val() );
//        if( form_id.find('input[name="answer"]').val().length == 0 ) { return false; }
//return false;
        form_id.find('input[name="lesson_id"]').val(lesson_id);
        form_id.find('input[name="slide_id"]').val(slide_id);
        form_id.find('input[name="identity"]').val(identity);
        form_id.find('input[name="behavior"]').val(behavior);
//console.log(form_id.find('input[name="slide_id"]').val());
//console.log(form_id);

        post_data = form_id.serialize();
        $.post( "/e5_student/saveAnswer", {res_id: form_id.attr('name'), post_data: post_data}, function( data ) {
            if( behavior != 'offline' ) {
                $(this_btn).hide();
            }
            
            $('#sl_'+slide_id).find(tbl_id).css( 'display','none' );
            $('#sl_'+slide_id).find(tbl_id).html( data );

            var f = $('#'+tbl_id.attr('rel')).height();
            var srh = $('.sl_res_'+tbl_id.attr('rel')).height();
            var trh = tbl_id.height();
            if( (f + trh) > srh ) {
                $('.sl_res_'+tbl_id.attr('rel')).height(srh+tbl_id.height());
            }
        });
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
