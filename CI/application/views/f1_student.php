<style type="text/css">
    .table2 tbody td:last-child { background:#f2f2f2; }
</style>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
	<div class="container">
		<h2>My Homework Assignments</h2>
		<div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_opened == 0}color:#aaa;{/if}">Open</h3>
				<div class="up_down" style="cursor:pointer;{if count_opened == 0}background-image:none;{/if}"><span class="count_lessons count_drafted" style="{if count_opened == 0}color:#aaa;{/if}">({count_opened})</span></div>
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
                            </tr>
					    {/opened}
					    </tbody>
				    </table>
			    </div>
			    {/if}
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_past == 0}color:#aaa;{/if}">Past Due Date</h3>
				<div class="up_down" style="cursor:pointer;{if count_past == 0}background-image:none;{/if}"><span class="count_lessons count_drafted" style="{if count_past == 0}color:#aaa;{/if}">({count_past})</span></div>
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
                            </tr>
					    {/past}
					    </tbody>
				    </table>
				</div>
			    {/if}
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_submitted == 0}color:#aaa;{/if}">Submitted</h3>
				<div class="up_down" style="cursor:pointer;{if count_submitted == 0}background-image:none;{/if}"><span class="count_lessons count_drafted" style="{if count_submitted == 0}color:#aaa;{/if}">({count_submitted})</span></div>
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
                            </tr>
					    {/submitted}
					    </tbody>
				    </table>
				</div>
			    {/if}
			</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_marked == 0}color:#aaa;{/if}">Marked</h3>
				<div class="up_down" style="cursor:pointer;{if count_marked == 0}background-image:none;{/if}"><span class="count_lessons count_drafted" style="{if count_marked == 0}color:#aaa;{/if}">({count_marked})</span></div>
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
							    <td><a href="/f2_student/marked/{id}">{name}</a></td>
							    <td>{subject_name}</td>
							    <td><span class="icon calendar grey"></span><span>{date}</span></td>
							    <td style="text-align: left;padding-left: 20px;">{mark}</td>
                            </tr>
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
        <div class="right"></div>
    </div>
</footer>
