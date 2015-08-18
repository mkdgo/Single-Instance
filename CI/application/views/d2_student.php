<div class="blue_gradient_bg">
	<div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
	<div class="container">
		<h2>{subject_title}</h2>
		<div class="{hide_modules}">
			{modules}
			<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">{module_name}</h3>
			<div class="up_down" style="cursor:pointer"></div>
			<div class="collapsed">
			<table class="table2" data-module="{module_id}">
				<thead>
					<tr>
						<td><a href="/d4_student/index/{subject_id}/{module_id}">Module: &nbsp;{module_name}</a></td>
						<td class="ta-c">Slides Available?</td>
					</tr>
				</thead>
				<tbody>
				{lessons}
					<tr>
						<td><a href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">Lesson {lesson_count}: {lesson_title}</a></td>
						<td class="ta-c"> {lesson_interactive}</td><!--echo hide if no slides-->
					</tr>
				{/lessons}
				</tbody>
			</table>
				</div>
			<!--<div class="{float} module_butt">
				<a class="gray_button gray_button_text " href="/d4_student/index/{subject_id}/{module_id}">Module: {module_name}<span class="module_down_arrow"></span></a>

				<?php
					/*
					<div class="lessons {hide_lessons}">
					{lessons}
					<a class="lesson_button" href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">
					<img src="/img/red_arrow_gray_sub_button.png"/>{lesson_title}</a>
					{/lessons}
					</div>
					*/
				?>

				<table class="lessons {hide_lessons}" width="100%" cellspacing="20">
					<tr width="100%">
						<td></td>
						<td width="300" align="center" class="lesson_available">Interactive Lesson Avaialble?</td>
					</tr>
					{lessons}
					<tr>
						<td><a class="lesson_button" href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}"><img src="/img/red_arrow_gray_sub_button.png"/>Lesson {lesson_count}: <span class="lesson_link">{lesson_title}</span></a></td>
						<td class="lesson_button" width="300" align="center">{lesson_interactive}</td>
					</tr>
					{/lessons} 
				</table>
				<br />

			</div>-->
			{clear}
			{/modules}
		</div>
	</div>
 </div>
<div class="clear" style="height: 1px;"></div>
<footer>
	<div class="container clearfix">
		<div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
		<div class="right">
            <?php if($curriculum_published==1) {?>
            <a href="/d3_student/index/{subject_id}"  style="margin:0 30px 0 20px;" class="red_btn">VIEW CURRICULUM</a>
            <?php } ?>
		</div>
	</div>
</footer>
