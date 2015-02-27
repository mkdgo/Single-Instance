<link rel="stylesheet" href="/js/reveal/css/reveal.css">
<link rel="stylesheet" href="/js/meny/css/demo.css">
<link rel="stylesheet" href="/js/reveal/css/theme/ediface.css" id="theme">
<link rel="stylesheet" href="/js/reveal/lib/css/zenburn.css">
<div style="width: 260px; height: 100%; padding-top:50px; position: fixed; display: block; z-index: 1; transform-origin: 100% 50% 0px; transition: all 0.3s ease 0s; transform: translateX(-100%) translateX(0px) scale(1.01) rotateY(-30deg);" class="meny">
    <a href="javascript:meny.close()" style="text-decoration: none" id="menyclose" >X</a>
    <h1>Student List </h1>
    <div id="studentlist">
	    <ul>
	    {students}
		    <li><span class="online{online}">&nbsp;</span>{first_name} {last_name}</li>
	    {/students}
	    </ul>
    </div>
</div>
<div class="meny-arrow">
	<a href="javascript:meny.open()" tyle="text-decoration: none" id="menyopen">|||</a>
</div>
<div class="contents">
	<?php /* REMOVED FOR NEW DESIGN
	<div  class="gray_top_field">
		<a href="{close}" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">{close_text}</a>
		<div class="clear"></div>
	</div>
	*/
	?>
	<a style="position:fixed;top:50%;left:15px;visibility:visible;cursor: pointer;" href="javascript:rprev()" id="leftarrow"> <img src="/img/arrow_left.png"/> </a>
	<a style="position:fixed;top:50%;right:15px;visibility:visible;cursor: pointer;" href="javascript:rnext()" id="rightarrow"> <img src="/img/arrow_right.png"/> </a>
	<script>
		function rnext() {
			Reveal.next();
			updateslides();
		}

		function rprev() {
			Reveal.prev();
			updateslides();
		}

		function updatestudents() {			
			//var pathArray = window.location.href.split( '/' );
			var slideno = parseInt(window.location.hash.substring(2,3))+1;
			if(isNaN(slideno)) {
				slideno = 1;
			}	
			//alert('current: '+slideno);
			$.ajax({
				url: '/ajax/interactive_lessons_ajax/new_slide/'+{lesson},
				dataType: 'json',
				type: 'POST',
				data: { slide: slideno },
				success: function() {
					alert('Next slide ');
				}
			});
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
//			updatestudents()
		}
	</script>
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
	</style>
	<script type="text/javascript">
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
	</script>
	<div class="reveal">
		<!-- Any section element inside of this container is displayed as a slide -->
		<div class="slides">
			{items}
			<section>
				<h1>{cont_page_title}</h1>
				<p>{cont_page_text}</p>
				{resources}
				<div class="slideresource">
					{preview}
				</div>
				<br />
				{/resources}
			    {questions}
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
				{/if}
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
            <a href="{close}" class="green_btn close_text">{close_text}</a>
		</div>
	</div>
</footer>
<script src="/js/reveal/lib/js/head.min.js"></script>
<script src="/js/reveal/js/reveal.js"></script>
<script>
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
	Reveal.addEventListener('ready', updateslides());
	Reveal.addEventListener('slidechanged', updateslides());
    Reveal.configure({
        keyboard: {
            39: function(){rnext()}, 
            37: function(){rprev()}// go to the next slide when the ENTER key is pressed
        }
    });

</script>
<script type="text/javascript" src="/js/meny/js/meny.js"></script>
<script>
	// Create an instance of Meny
	var meny = Meny.create({
		// The element that will be animated in from off screen
		menuElement : document.querySelector('.meny'),

		// The contents that gets pushed aside while Meny is active
		contentsElement : document.querySelector('.contents'),

		// [optional] The alignment of the menu (top/right/bottom/left)
		position : Meny.getQuery().p || 'left',

		// [optional] The height of the menu (when using top/bottom position)
		height : 200,

		// [optional] The width of the menu (when using left/right position)
		width : 260,

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
	/*
	if(Meny.getQuery().u && Meny.getQuery().u.match(/^http/gi)) {
		var contents = document.querySelector('.contents');
		contents.style.padding = '0px';
		contents.innerHTML = '<div class="cover"></div><iframe src="' + Meny.getQuery().u + '" style="width: 100%; height: 100%; border: 0; position: absolute;"></iframe>';
	}
	*/
</script>
