<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
	<div class="container">
        <div class="row">
		    <h2>{lesson_title}</h2>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3 for="lesson_intro" class="label_fix_space">Intro:</h3>
                <textarea name="lesson_intro" id="lesson_intro" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_intro}</textarea>
                <h3 for="lesson_objectives" class="label_fix_space">Objectives:</h3>
                <textarea name="lesson_objectives" id="lesson_objectives" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_objectives}</textarea>
<!--
				<ul class="ul2">
					<li>
						<h3 class="label_fix_space">Introduction:</h3>
						<div class="student_info_block">
						<p class="student_info_block">{lesson_intro}</p>
						</div>
					</li>
					<li>
						<h3 class="label_fix_space">Objectives:</h3>
						<div class="student_info_block">
						<p>{lesson_objectives}</p>
						</div>
					</li>
				</ul>
-->
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<h3 class="label_fix_space">Resources</h3>
				<ul class="ul3_resource  {resource_hidden}">
					{resources}
					<li><a href="javascript:;" onclick="$(this).next().children().click()"><p><span class="icon {type}"></span>&nbsp; {resource_name}</p></a>
						<span class="show_resource" style="display:none;">{preview}</span>
					</li>
					{/resources}
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
	<div class="container clearfix">
		<div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
			{view_lesson}
            {view_interactive_lesson}
		</div>
	</div>
</footer>
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript">loadTinymceStudent();</script>
