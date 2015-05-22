<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
	<div class="container">
		<div class="row clearfix">
            {subjects}
			<div class="{plus_class} subject_center_if_little w150" >
                <a href="/{curriculum_link}/index/{id}"  class="subject_icon" style="background-image: url(<?php echo base_url().'uploads/subject_icons/';?>{logo_pic})"></a>
                <a class="student_text subject_text " href="/{curriculum_link}/index/{id}">{name}</a>
			</div>
			{/subjects}
		</div>



		<div class="col-lg-12 col-sm-12 col-xs-12"  >

			<div class="innactive_block">
<div class="out">
				{na_subjects}
				<div class="innactive_icons" >
					<a href="/{curriculum_link}/index/{id}"  class="subject_icon" style="background-image: url(<?php echo base_url().'uploads/subject_icons/';?>{logo_pic});"></a>
					<a href="/{curriculum_link}/index/{id}" class="subject_text_small " ">{name}</a>
				</div>
				{/na_subjects}
</div>
			</div>
				</div>
		</div>
	</div>



<div class="clear" style="height: 1px;"></div>
<footer>
	<div class="container clearfix">
		<div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
		</div>
	</div>
</footer> 