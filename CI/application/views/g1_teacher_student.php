<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container text-center">
        <div class="row">
            <h2 class="pull-left">{first_name} {last_name}</h2>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
        <div class="row clearfix">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                {classes}
                <div class="panel panel-default ediface-student-panel">
                    <div class="panel-heading ediface-student-panel-heading" role="tab" id="heading{class_id}">
                        <h3 class="panel-title ediface-panel-title">
                            <a class="ediface-student ediface-student-class" data-toggle="collapse" data-parent="#accordion" href="#collapse{class_id}" aria-expanded="true" aria-controls="collapse{class_id}">
                                {class_name} <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </h3>
                    </div>
                    <div id="collapse{class_id}" class="panel-collapse collapse {css_class}" role="tabpanel" aria-labelledby="heading{class_id}">
                        <div class="panel-body panel-body-ediface">
                            <div class="row">
                                <div class="col-sm-10 col-sm-offset-1 text-left">
                                    <table class="table ediface-table">
                                        <tr><td class="ediface-thead" colspan="5"><strong>Assignments</strong></td></tr>
                                        <tr class="ediface-subhead">
                                            <td style="width: 10%;" class="text-center">Type</td>
                                            <td style="width: 58%;">Title</td>
                                            <td style="width: 22%;" class="text-center">Submission Date</td>
                                            <td style="width: 6%;" class="text-center">Grade</td>
                                            <td style="width: 4%;">&nbsp;</td>
                                        </tr>
                                        {assignments}
                                        <tr class="ediface-inner">
                                            <td style="width: 10%; color: #db4646;" class="text-center"><span class="glyphicon glyphicon-picture"></span></td>
                                            <td style="width: 58%;">
                                                <a href="/f3_teacher/index/{base_assignment_id}/{id}" target="_blank">
                                                    {title}
                                                </a>
                                            </td>
                                            <td style="width: 22%;" class="text-center">{deadline_date}</td>
                                            <td style="width: 6%;" class="text-center">{grade}</td>
                                            <td style="width: 4%;" class="text-center">
                                                <a href="/f3_teacher/index/{base_assignment_id}/{id}" target="_blank">
                                                    <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        {/assignments}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/classes}
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
