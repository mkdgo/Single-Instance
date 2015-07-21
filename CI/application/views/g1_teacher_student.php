<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container">
        <div class="row">
            <h2 class="pull-left">{first_name} {last_name}</h2>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
       {classes}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            {logo_pic}<h3 class="acc_title" style="cursor:pointer;padding-left: 45px;padding-bottom:15px;border-bottom: 1px solid #ccc;">{class_name} - {group_name} - {teachers}</h3>

                <div class="up_down" style="cursor:pointer"><span class="count_lessons count_drafted">({count_assignments})</span></div>
                <div class="collapsed">
                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-xs-12"><strong style="padding: 5px;">Work</strong></div>
                    </div>
                    <table class="table2">
                        <thead>
                            <tr class="ediface-subhead">
                                <td style="width: 5%;" class="text-center">Type</td>
                                <td style="width: 58%;">Title</td>
                                <td style="width: 12%;" class="text-center">Date Tagged</td>
                                <td style="width: 16%;" class="text-center">Tagged By</td>
                                <td style="width: 4%;">&nbsp;</td>
                            </tr>
                        </thead>
                        {works}
                        <tr class="ediface-inner">
                            <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
                            <td style="width: 58%;color: #ccc;">
                                <span class="work-item" data-work-id="{id}" style="color: #4d4d4d; cursor: pointer;">
                                    {title}
                                </span>
                            </td>
                            <td style="width: 12%;" class="text-center">{created_on}</td>
                            <td style="width: 16%;" class="text-center">{tagger_name}</td>
                            <td style="width: 4%;" class="text-center">
                                <span style="color: #4d4d4d; cursor: pointer;">
                                    <span class="work-item glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;" data-work-id="{id}">&nbsp;</span>
                                </span>
                            </td>
                        </tr>
                        {/works}
                    </table>

                    <div class="row" style="margin-bottom: 5px;">
                        <div class="col-xs-12"><strong style="padding: 5px;">Assignments</strong></div>
                    </div>
                    <table class="table2">
                        <thead>
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
        {/classes}
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
