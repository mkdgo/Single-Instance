<link rel="stylesheet" href="/js/reveal/css/reveal.css">
<link rel="stylesheet" href="/js/reveal/css/theme/ediface.css" id="theme">
<link rel="stylesheet" href="/js/reveal/lib/css/zenburn.css">
	<?
	$running = strpos($_SERVER['REQUEST_URI'], "running") ? true : false;
	?>
	<div  class="gray_top_field">
	<?
	if(!$running) {
	?>
		<a href="{close}" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">{close_text}</a>
		<div class="clear"></div>
	<?
	}
	?>
	</div>
	
	<?
	if(!$running) {
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

		function updateslides() {	
			if(Reveal.isFirstSlide()) {
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
	<?
	}
	?>
	<style>
		.ui-body-c {
			background-image: none;
			background: none;
		}
		.ui-overlay-c {
			background-image: none;
		}
		.ui-page {
			background-image: none;
			background: none;
		}
	</style>
	<script type="text/javascript">
		$('#staticheader').css("visibility", "hidden");
		$('.gray_top_field').css("background-color", "#009900");
		$('.gray_top_field').css("top", "0px");
		$('.gray_top_field').css("height", "47px");
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
			{content_pages}
			<section>
				<h1>{cont_page_title}</h1>
				<p>
					{cont_page_text}
				</p>
				{resources}
				<div class="slideresource">
					{preview}
				</div>
				<br />
				{/resources}
			</section>
			{/content_pages}

			{int_assessments}
			<section>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 align_center page">
					<!-- top_350px -->
					{questions}
						<div class="int_question">
							{question_resource_img_preview} <h1>{question_text}</h1>
							{answers} <label for="{question_num}_{answer_num}">{answer_text}</label>
							<input type="checkbox" disabled id="{question_num}_{answer_num}" name="questions[{question_num}][]" value="{answer_num}" {answer_is_checked}>
							{/answers}
						</div>
					{/questions}

					{if no_questions > 0}
					<br>
					<h3>No questions defined on the slide!</h3>
					{/if}
				</div>
			</section>
			{/int_assessments}
		</div>
	</div>

</div> <script src="/js/reveal/lib/js/head.min.js"></script>
<script src="/js/reveal/js/reveal.js"></script>
<script>
	// Full list of configuration options available here:
	// https://github.com/hakimel/reveal.js#configuration
	Reveal.initialize({
		controls : false,
		progress : true,
		history : true,
		center : true,
		margin : 0.1,

		theme : Reveal.getQueryHash().theme, // available themes are in /css/theme
		transition : Reveal.getQueryHash().transition || 'default', // none/fade/slide/convex/concave/zoom

		// Parallax scrolling
		// parallaxBackgroundImage: 'https://s3.amazonaws.com/hakim-static/reveal-js/reveal-parallax-1.jpg',
		// parallaxBackgroundSize: '2100px 900px',

		// Optional libraries used to extend on reveal.js
		dependencies : [{
			src : '/js/reveal/lib/js/classList.js',
			condition : function() {
				return !document.body.classList;
			}
		}, {
			src : '/js/reveal/plugin/markdown/marked.js',
			condition : function() {
				return !!document.querySelector('[data-markdown]');
			}
		}, {
			src : '/js/reveal/plugin/markdown/markdown.js',
			condition : function() {
				return !!document.querySelector('[data-markdown]');
			}
		}, {
			src : '/js/reveal/plugin/highlight/highlight.js',
			async : true,
			callback : function() {
				hljs.initHighlightingOnLoad();
			}
		}, {
			src : '/js/reveal/plugin/zoom-js/zoom.js',
			async : true,
			condition : function() {
				return !!document.body.classList;
			}
		}, {
			src : '/js/reveal/plugin/notes/notes.js',
			async : true,
			condition : function() {
				return !!document.body.classList;
			}
		}]
	});
	<?php 
	if(!$running) {
	?>
	Reveal.addEventListener('slidechanged', updateslides());
	<?php
	}
	?>
	
	Reveal.configure({
	  keyboard: {
	    39: null, 
	    37: null// go to the next slide when the ENTER key is pressed
	  }
	});

</script>
