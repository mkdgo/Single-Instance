<script src="<?= base_url("/js/g1_teacher_student.js") ?>"></script>
<script type="text/javascript">
    var g1_work_id = {g1_t_work_id};
    var g1_work_item_id = {g1_t_work_item_id};
</script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="pull-left">{first_name} {last_name}</h2>
                <?php print_r($this->_data); ?>
            </div>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
       {classes}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <h3 class="acc_title" data-offset="{offset}" data-subject-id="{subject_id}" style="cursor:pointer;padding-left: 60px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_assignments == 0}color:#aaa;{/if}">{logo_pic}<b>{class_name}</b> - {group_name} - {teachers}</h3>

                <div class="up_down" style="cursor:pointer;{if count_assignments == 0}background-image:none;{/if}"><span class="count_lessons count_drafted" style="{if count_assignments == 0}color:#aaa;{/if}">({total_work_count})<?php echo $this->_data['total_work_count']; ?></span></div>
                
                <div class="collapsed <?php if ($this->_data['count_assignments'] = 0) { echo "hidden"; } ?>">
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
                        <tr class="ediface-inner tr-work-{subject_id}">
                            <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
                            <td style="width: 58%;">
                                <span class="work-item" data-work-id="{id}" style="color: #4d4d4d; cursor: pointer;">
                                    <a id="work-{id}" data-parent-subject-id="{subject_id}" role="button" data-toggle="collapse" href="#work-item-{id}" aria-expanded="false" aria-controls="work-items-{id}">
                                        {title}
                                    </a>
                                </span>
                                <div id="work-item-{id}" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            {items}
                                            <li class="list-group-item" style="background-color: inherit; border: 0 none;">
                                                <span class="icon {item_type}" style="margin-top: -3px;"></span>
                                                <a href="/f5_teacher/index/{g1_t_s_student_id}/{work_id}/{work_item_id}" style="padding-left:5px">{item_name}</a>
                                            </li>
                                            {/items}
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td style="width: 12%;" class="text-center">{created_on}</td>
                            <td style="width: 16%;" class="text-center">{tagger_name}</td>
                            <td style="width: 4%;" class="text-center">
                                <span style="color: #4d4d4d; cursor: pointer;">
                                    <a role="button" data-toggle="collapse" href="#work-item-{id}" aria-expanded="false" aria-controls="work-item-{id}">
                                        <span class="work-item glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;" data-work-id="{id}">&nbsp;</span>
                                    </a>
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
                            <td style="width: 22%;" class="text-center">{user_deadline_date}</td>
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
