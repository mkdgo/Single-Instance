<header data-role="header" data-position="inline" id="staticheader">
	<div class="container">

		<div class="left">
			<?php if($_SERVER['REDIRECT_QUERY_STRING']!='/' && $_SERVER['REDIRECT_QUERY_STRING']!='/b1' && $_SERVER['REDIRECT_QUERY_STRING']!='/b2') :?>
				<!-- <a onclick="backButtonPress('{firstBack}','{secondback}')" href="javascript:;" data-icon="arrow-l">Back</a>-->
				<a onclick="window.history.back()" href="javascript:;" id="backbutton"><span class="glyphicon glyphicon-chevron-left"></span></a>
			<?php endif;?>
			<a href="/" class="home"><span class="glyphicon glyphicon-home"></span></a>   
		    <form id="formsearch" action="javascript:void(0)" enctype="multipart/form-data" method="post">
		    	<a href="#" class="search"><span class="glyphicon glyphicon-search"></span></a>
		        <div id="search-label"><label for="search-terms" id='search-label-target'>search</label></div>
		        <div class='span2' id="input"><input type="text" data-type="search" name="search-terms" id="search-terms" placeholder="Enter search..."></div>
		    </form>
			
		</div>
	
		<div class="right">
			<a href="/logout" id="la_bt" class="logout">Logout</a>
		</div>
	
		<div class="logo">
			<a href="/" ><img src="/img/logo_top.png" /></a>
		</div>
	</div>
</header>

<script src="/js/classie.js"></script>
<script src="/js/search.js"></script>
<script>
    $("#formsearch").keyup(function(event){

        if(event.keyCode == 13){

            // console.log('query ajax', $('#query_value').val());
            window.location.href = ('/s1/results/' + $('#search-terms').val());
            
        }
    });
</script>