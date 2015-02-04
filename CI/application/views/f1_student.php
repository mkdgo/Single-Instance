<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
	<div class="container">
		<h2>My Homework Assignments</h2>
                
               
                
                
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Opened</h3>
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
							
							<td style="text-align: left;">{mark}</td>
                                                        
					{/opened}
					</tbody>
				</table>
			</div>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Past Due Date</h3>
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
							
							<td style="text-align: left;">{mark}</td>
                                                        
					{/past}
					</tbody>
				</table>
			</div>
                    
                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Submitted</h3>
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
							
							<td style="text-align: left;">{mark}</td>
                                                        
					{/submitted}
					</tbody>
				</table>
			</div>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<h3>Marked</h3>
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
							
							<td style="text-align: left;">{mark}</td>
                                                        
					{/marked}
					</tbody>
				</table>
			</div>
		</div>
		
		
	</div>
</div>