<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
	<div class="container">
		<h2>My Homework Assignments</h2>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_opened == 0}color:#aaa;{/if}">Opened</h3>
				<div class="up_down" style="cursor:pointer{if count_opened == 0}background-image:none;{/if}"><span class="count_lessons count_drafted">({count_opened})</span></div>
				{if count_opened > 0}
				<div class="collapsed">

				<table class="table2">
					<thead>
						<tr>
							<td>Assignment</td>
							<td>Subject</td>
							<td>Due Date</td>
							<td>Grade</td>
						</tr>
					</thead>
					<tbody>
					{opened}
						<tr>
							<td><a href="/f2_student/index/{id}">{name}</a></td>
							<td>{subject_name}</td>
							<td><span class="icon calendar grey"></span><span>{date}</span></td>
							<td style="text-align: left;padding-left: 20px;">{mark}</td>
					{/opened}
					</tbody>
				</table>
			</div>
			{/if}
				</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Past Due Date</h3>
				<div class="up_down" style="cursor:pointer"><span class="count_lessons count_drafted">({count_past})</span></div>
				{if count_past > 0}
				<div class="collapsed">

				<table class="table2">
					<thead>
						<tr>
							<td>Assignment</td>
							<td>Subject</td>
							<td>Due Date</td>
							<td>Grade</td>
						</tr>
					</thead>
					<tbody>
					{past}
						<tr>
							<td><a href="/f2_student/index/{id}">{name}</a></td>
							<td>{subject_name}</td>
							<td><span class="icon calendar grey"></span><span>{date}</span></td>
							<td style="text-align: left;padding-left: 20px;">{mark}</td>
					{/past}
					</tbody>
				</table>
					</div>
			{/if}
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Submitted</h3>
				<div class="up_down" style="cursor:pointer"><span class="count_lessons count_drafted">({count_submitted})</span></div>
				{if count_submitted > 0}
				<div class="collapsed">
				<table class="table2">
					<thead>
						<tr>
							<td>Assignment</td>
							<td>Subject</td>
							<td>Due Date</td>
							<td>Grade</td>
						</tr>
					</thead>
					<tbody>
					{submitted}
						<tr>
							<td><a href="/f2_student/index/{id}">{name}</a></td>
							<td>{subject_name}</td>
							<td><span class="icon calendar grey"></span><span>{date}</span></td>
							<td style="text-align: left;padding-left: 20px;">{mark}</td>
					{/submitted}
					</tbody>
				</table>
					</div>
			{/if}
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Marked</h3>
				<div class="up_down" style="cursor:pointer"><span class="count_lessons count_drafted">({count_marked})</span></div>
				{if count_marked > 0}
				<div class="collapsed">
				<table class="table2">
					<thead>
						<tr>
							<td>Assignment</td>
							<td>Subject</td>
							<td>Due Date</td>
							<td>Grade</td>
						</tr>
					</thead>
					<tbody>
					{marked}
						<tr>
							<td><a href="/f2_student/index/{id}">{name}</a></td>
							<td>{subject_name}</td>
							<td><span class="icon calendar grey"></span><span>{date}</span></td>
							<td style="text-align: left;padding-left: 20px;">{mark}</td>
					{/marked}
					</tbody>
				</table>
					</div>
			{/if}
			</div>
		</div>
	</div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
<!--            <a href="/f2b_teacher" style="margin: 12px 30px 0 20px;" class="red_btn">CREATE NEW ASSIGNMENT</a>-->
        </div>
    </div>
</footer>
