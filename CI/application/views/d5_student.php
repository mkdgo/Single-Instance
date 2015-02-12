<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
	<div class="container">
        <div class="row">
		
		<h2>{lesson_title}</h2>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            
				<ul class="ul2">
					<li>
						<h3>Introduction:</h3>
						<hr class="wm">
						<p>{lesson_intro}</p>
					</li>
					<li>
						<h3>Objectives:</h3>
						<hr class="wm">
						<p>{lesson_objectives}</p>
					</li>
<!--                                        <li>
						<h3>Teaching Activities</h3>
						<hr class="wm">
						<p>{lesson_teaching_activities}</p>
					</li>
                                         <li>
						<h3>Assessment Opportunities</h3>
						<hr class="wm">
						<p>{lesson_assessment_opportunities}</p>
					</li>
                                         <li>
						<h3>Notes</h3>
						<hr class="wm">
						<p>{lesson_notes}</p>
					</li>-->
				</ul>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 top-4">
				<h3>Resources</h3>
				<ul class="ul1 resources">
				{resources}
					<li>
						<div class="r">{preview}</div>
						<div class="t"><span title="{resource_name}">{resource_name}</span></div>
					</li>
				{/resources}
				</ul>
			</div>
		</div>
	</div>
</div>
<br />
<footer>
	<div class="container clearfix">
		<div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
			{view_lesson}
            {view_interactive_lesson}
		</div>
	</div>
</footer>
