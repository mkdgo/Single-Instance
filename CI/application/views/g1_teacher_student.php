<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container">
        <div class="row">
            <h2 class="pull-left">{first_name} {last_name}</h2>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
       <!-- <div class="row clearfix"> -->
            <!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">-->
                {classes}
                <!--<div class="panel panel-default ediface-student-panel">-->
                    <!--<div class="panel-heading ediface-student-panel-heading" role="tab" id="heading{class_id}">
                        <h3 class="panel-title ediface-panel-title">
                            <a class="ediface-student ediface-student-class" data-toggle="collapse" data-parent="#accordion" href="#collapse{class_id}" aria-expanded="true" aria-controls="collapse{class_id}">
                                {class_name} <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </h3>
                    </div>-->
                   <!-- <div id="collapse{class_id}" class="panel-collapse collapse {css_class}" role="tabpanel" aria-labelledby="heading{class_id}">-->
                        <!--<div class="panel-body panel-body-ediface">-->
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h3 class="acc_title" style="cursor:pointer;padding-left: 10px;padding-bottom:15px;border-bottom: 1px solid #ccc;"> {class_name}</h3>
                                    <div class="up_down" style="cursor:pointer"><span class="count_lessons count_drafted">({count_assignments})</span></div>
                                    <div class="collapsed">




                                    <table class="table2">
                                        <thead>
                                        <!--<tr><td class="ediface-thead" colspan="5"><strong>Assignments</strong></td></tr>-->
                                        <tr class="ediface-subhead">
                                            <td style="width: 5%;" class="text-center">Type</td>
                                            <td style="width: 63%;">Title</td>
                                            <td style="width: 22%;" class="text-center">Submission Date</td>
                                            <td style="width: 6%;" class="text-center">Grade</td>
                                            <td style="width: 4%;">&nbsp;</td>
                                        </tr>
                                        </thead>
                                        {assignments}
                                        <tr class="ediface-inner">
                                            <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-picture"></span></td>
                                            <td style="width: 63%;color: #ccc;">
                                                <a href="/f3_teacher/index/{base_assignment_id}/{id}" style="color: #4d4d4d;" >
                                                    {title}
                                                </a>
                                            </td>
                                            <td style="width: 22%;" class="text-center">{deadline_date}</td>
                                            <td style="width: 6%;" class="text-center">{grade}</td>
                                            <td style="width: 4%;" class="text-center">
                                                <a href="/f3_teacher/index/{base_assignment_id}/{id}" >
                                                    <span class=" glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;">&nbsp;</span>
                                                </a>
                                            </td>
                                        </tr>
                                        {/assignments}
                                    </table>
                                        </div>
                                </div>
                            </div>
                        <!--</div>-->
                   <!-- </div>-->
                <!--</div>-->
                {/classes}
            <!--</div>-->
       <!-- </div> -->
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
