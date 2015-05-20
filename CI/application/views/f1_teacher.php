<div class="blue_gradient_bg" xmlns="http://www.w3.org/1999/html">
    <div class="breadcrumb_container">
		<div class="container">{breadcrumb}</div>
	</div>
    <div class="container">
        <h2>Homework</h2>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                   <label>Teacher</label>
                    <select class="teacher_select">
                        <option value="<?php  echo $this->session->userdata('id')?>" selected="selected"><?php  echo $this->session->userdata('first_name')?> <?php  echo $this->session->userdata('last_name')?>(ME)</option>
                        {teachers}
                        <option value="{id}" >{first_name} {last_name}</option>
                        {/teachers}
                    </select>
                     </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <label>Subject</label>
                    <select class="subject_select">
                        <option value="{subjects_0_value}" classes_ids="{subjects0_classes_ids}">All</option>
                       {subjects}

                        <option value="{id}" classes_ids="{classes_ids}">{name}</option>
                        {/subjects}
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Year</label>
                    <select class="subject_year_select">
                        {subjects_years}
                        <option value="0" disabled="disabled" selected="selected"></option>
                        {/subjects_years}
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Class</label>
                    <select class="class_select">
                        {year_class}
                        <option value="0" disabled="disabled" selected="selected"></option>
                        {/year_class}
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <label>Status</label>
                    <select class="status_select">
                        {status_select_all}
                        {status_assigned}
                        {status_drafted}
                        {status_past}
                        {status_closed}


                    </select>
                </div>
                </div>
            <br />
            <br />
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Drafted</h3>
                <div class="up_down" style="cursor:pointer"></div>
                <div class="collapsed">

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
                    <tbody class="drafted">
                        {drafted}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>

                            <td>&nbsp;</td>

                        </tr>
                        {/drafted}
                    </tbody>
                </table>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Assigned</h3>
                <div class="up_down" style="cursor:pointer"></div>
                <div class="collapsed">

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
                    <tbody class="assigned">
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
        </div>
        <div class="row {past_due_date_hidden}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Past Due Date</h3>
                <div class="up_down" style="cursor:pointer"></div>
                <div class="collapsed">

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
                    <tbody class="past">
                        {past}
                        <tr>
                            <td><a href="/f2{editor}_teacher/index/{id}">{name}</a></td>
                            <td>{subject_name}</td>
                            <td><span class="icon calendar grey"></span><span>{date}</span></td>
                            <td>{submitted}/{total}</td>
                            <td>{marked}/{total}</td>

                            <td>&nbsp;</td>

                        </tr>
                        {/past}
                    </tbody>

                </table>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Closed</h3>
                <div class="up_down" style="cursor:pointer"></div>
                <div class="collapsed">

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
                    <tbody class="closed">
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
<script src="<?php echo base_url().'js/f1_teacher.js'?>" type="text/javascript"></script>