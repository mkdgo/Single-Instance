<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
    <div class="container">
        <h2>Homework</h2>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Drafted</h3>
                <table class="table2">
                    <thead>
                        <tr>
                            <td>Assignment</td>
                            <td>Subject</td>
                            <td>Due Date</td>
                            <td>Submitted</td>
                            <td colspan="2">Marked</td>
                        </tr>
                    </thead>
                    <tbody>
                        {drafted}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>
                            <!--<i class="icon ok"></i><i class="icon warning"></i><i class="icon ok_grey">-->
                            <td>&nbsp;</td>
                            <!--<a class="remove" href="#"><span class="glyphicon glyphicon-remove"></span></a>-->
                        </tr>
                        {/drafted}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Assigned</h3>
                <table class="table2">
                    <thead>
                        <tr>
                            <td>Assignment</td>
                            <td>Subject</td>
                            <td>Due Date</td>
                            <td>Submitted</td>
                            <td colspan="2">Marked</td>
                        </tr>
                    </thead>
                    <tbody>
                        {assigned}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>
                            <!--<i class="icon ok"></i><i class="icon warning"></i><i class="icon ok_grey">-->
                            <td>&nbsp;</td>
                            <!--<a class="remove" href="#"><span class="glyphicon glyphicon-remove"></span></a>-->
                        </tr>
                        {/assigned}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row {past_due_date_hidden}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Past Due Date</h3>
                <table class="table2">
                    <thead>
                        <tr>
                            <td>Assignment</td>
                            <td>Subject</td>
                            <td>Due Date</td>
                            <td>Submitted</td>
                            <td colspan="2">Marked</td>
                        </tr>
                    </thead>
                    <tbody>
                        {past}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>
                            <!--<i class="icon ok"></i><i class="icon warning"></i><i class="icon ok_grey">-->
                            <td>&nbsp;</td>
                            <!--<a class="remove" href="#"><span class="glyphicon glyphicon-remove"></span></a>-->
                        </tr>
                        {/past}
                    </tbody>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3>Closed</h3>
                <table class="table2">
                    <thead>
                        <tr>
                            <td>Assignment</td>
                            <td>Subject</td>
                            <td>Due Date</td>
                            <td>Submitted</td>
                            <td colspan="2">Marked</td>
                        </tr>
                    </thead>
                    <tbody>
                        {closed}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>
                            <!--<i class="icon ok"></i><i class="icon warning"></i><i class="icon ok_grey">-->
                            <td>&nbsp;</td>
                            <!--<a class="remove" href="#"><span class="glyphicon glyphicon-remove"></span></a>-->
                        </tr>
                        {/closed}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="/f2b_teacher" style="margin: 12px 30px 0 20px;" class="red_btn">CREATE NEW ASSIGNMENT</a>
        </div>
    </div>
</footer>
