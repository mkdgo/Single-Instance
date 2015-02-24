<div class="blue_gradient_bg">
    <div class="container">

        <div class="left rebuild_butt">
            <a href="javascript:void(0);" onclick="rebuildDatabase();" class="red_btn">Rebuild Search Index<i class="icon"></i></a>
        </div>

        <div style='clear:both'>
        	<div class='rebuild_progress' style='display:none'><img src='/img/ajax-loader.gif' />Rebuilding the Search Index</div>
        	<!-- <div class='returned_results'></div> -->
        </div>

    </div>
</div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
    </div>
</footer>
<script>
	function rebuildDatabase(){
		
		$('.rebuild_butt').hide();
		$('.rebuild_progress').show();

		$.ajax({
              type: "POST",
              url: "/search_admin/rebuild",
              data: {}
            })
              .done(function( msg ) {
              	$('.rebuild_progress').hide();
                // $(".returned_results").html( msg );
                $('.rebuild_butt').show();
              });

	}
</script>