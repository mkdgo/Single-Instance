<!--<div data-role="header" data-position="inline">

<a href="{back}" data-icon="arrow-l">back</a>
<div class="header_search hidden-xs">
<input type="search" id="search" style="" value=""/>
</div>
<h1>Subject select</h1>
</div>-->

<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
	<div class="container">
		<div class="row clearfix">
                    {subjects}
			<div class="{plus_class} subject_center_if_little w150" >
				<a href="/{curriculum_link}/index/{id}"  class="subject_{name_lower} subject_icon">&nbsp;</a>
				<a class="student_text subject_text " href="/{curriculum_link}/index/{id}">{name}</a>
			</div>
			{/subjects}
		</div> 
	</div>
</div>
<footer>
	<div class="container clearfix">
		<div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
		</div>
	</div>
</footer> 