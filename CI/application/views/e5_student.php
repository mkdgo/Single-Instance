<link rel="stylesheet" href="/js/reveal/css/reveal.css">
<link rel="stylesheet" href="/js/reveal/css/theme/ediface.css" id="theme">
<link rel="stylesheet" href="/js/reveal/lib/css/zenburn.css">
<?php $running = strpos($_SERVER['REQUEST_URI'], "running") ? true : false; ?>
<?php if(!$running): ?>
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
</style>
<script type="text/javascript">
    <?php if($running): ?>
    $('#staticheader').css("visibility", "hidden");
    <?php endif ?>

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
		</section>
		{/items}
	</div>
</div>

<script src="/js/reveal/lib/js/head.min.js"></script>
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
