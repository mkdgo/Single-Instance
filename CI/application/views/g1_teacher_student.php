<!--<script src="<?= base_url("/js/g1_teacher_student.js") ?>"></script>-->
<!--<script src="<?php echo base_url().'js/jquery.session.js'?>" type="text/javascript"></script>-->
<script type="text/javascript">
    var g1_work_id = {g1_t_work_id};
    var g1_work_item_id = {g1_t_work_item_id};
</script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumbs}</div></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="pull-left">{first_name} {last_name}</h2>
                <?php //print_r($this->_data); ?>
            </div>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
         <?php foreach ($this->_data['classes'] as $s_key=> $subject): ?>
        <div class="row">
            <div class="col-xs-12">
                <h3 class="acc_title" id="subject-<?php echo $subject['subject_id']; ?>" data-subject-id="<?php echo $subject['subject_id']; ?>" data-offset="<?php echo $subject['offset']; ?>" style="padding-left: 60px; padding-bottom: 15px; border-bottom: 1px solid #ccc;<?php if ($subject['total_work_count'] == 0) { echo "color:#aaa;";}?>">
                    <?php echo $subject['logo_pic']."<b>".$subject['class_name']."</b> - ".$subject['group_name']." - ".$subject['teachers']; ?>
                </h3>
                <div class="up_down" style="cursor:pointer;<?php if ($subject['total_work_count'] == 0) { echo "background-image:none;";}?>"><span class="count_lessons count_drafted" style="<?php if ($subject['total_work_count'] == 0) { echo "color:#aaa;";}?>">(<?php echo $subject['total_work_count']; ?>)</span></div>
                <?php if ($subject['total_work_count'] > 0) { ?>
                <div class="collapsed">
                    <?php if (sizeof($subject['works']) > 0) { ?>
                    <div style="display: block; ">
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-xs-12"><strong style="padding: 5px;">Work</strong></div>
                            </div>
                        </div>
                    <table class="table2" >
                        <thead>
                                <tr class="ediface-subhead">
                                <td style="width: 5%;" class="text-center">Type</td>
                                <td style="width: 58%;">Title</td>
                                <td style="width: 12%;" class="text-center">Date Tagged</td>
                                <td style="width: 16%;" class="text-center">Tagged By</td>
                                <td style="width: 4%;">&nbsp;</td>
                                </tr>
                            </thead>
                        <?php foreach ($subject['works'] as $work): ?>
                        <tr class="ediface-inner tr-work-<?php echo $subject['id']; ?>">
                                <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
                                <td style="width: 58%;">
                                    <span class="work-item" data-work-id="{id; ?>" style="color: #4d4d4d; cursor: pointer;">
                                        <a id="work-<?php echo $work->id; ?>" data-parent-subject-id="<?php echo $work->subject_id; ?>" role="button" data-toggle="collapse" href="#work-item-<?php echo $work->id; ?>" aria-expanded="false" aria-controls="work-items-<?php echo $work->id; ?>">
                                            <?php echo $work->title; ?>
                                        </a>
                                    </span>
                                    <div id="work-item-<?php echo $work->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                        <div class="panel-body">
                                            <ul class="list-group">
                                                <?php foreach ($work->items as $wi): ?>
                                                <li class="list-group-item" style="background-color: inherit; border: 0 none;">
                                                    <span class="icon <?php echo $wi->item_type; ?>" style="margin-top: -3px;"></span>
                                                    <a href="/f5_teacher/index/{g1_t_s_student_id}/<?php echo $wi->work_id; ?>/<?php echo $wi->work_item_id; ?>" style="padding-left:5px"><?php echo $wi->item_name; ?></a>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 12%;" class="text-center"><?php echo $work->created_on; ?></td>
                                <td style="width: 16%;" class="text-center"><?php echo $work->tagger_name; ?></td>
                                <td style="width: 4%; background: #f2f2f2!important;" class="text-center">
                                    <span style="color: #4d4d4d; cursor: pointer;">
                                        <a role="button" data-toggle="collapse" href="#work-item-<?php echo $work->id; ?>" aria-expanded="false" aria-controls="work-item-<?php echo $work->id; ?>">
                                            <span class="work-item glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;" data-work-id="<?php echo $work->id; ?>">&nbsp;</span>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php } ?>
                    <?php if ($subject['count_assignments'] > 0) { ?>
                    <div class="row" style="margin-bottom: 5px;"><div class="col-xs-12"><strong style="padding: 5px;">Assignments</strong></div></div>
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
                        <?php foreach ($subject['assignments'] as $assignment): 
                            if( $assignment->status != 'closed' ) {
                                $color = '#db4646';
                                $tr = '';
                                if( $assignment->status == 'draft' ) {
                                    $link = '/f2c_teacher/index/'.$assignment->base_assignment_id;
                                } elseif( $assignment->status == 'pending' ) {
                                    $link = '/f2p_teacher/index/'.$assignment->base_assignment_id;
                                } else {
                                    $link = '/f2b_teacher/edit/'.$assignment->base_assignment_id;
                                }
                            } else {
                                $color =  '#4d4d4d';
                                $tr = ' style="opacity: 0.5" ';
                                $link = '/f2d_teacher/index/'.$assignment->base_assignment_id;
                            }
                        ?>
                        <tr class="ediface-inner" <?php echo $tr; ?>>
                            <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-picture"></span></td>
                            <td style="width: 63%;color: #ccc;">
                                <a href="/f2b_teacher/index/<?php echo $assignment->base_assignment_id; ?>" style="color: <?php echo $color; ?>" ><?php echo $assignment->title; ?></a>
                                &nbsp;&nbsp;&nbsp;
                                <?php if( $assignment->grade_type != 'offline' ): ?>
                                <a href="/f3_teacher/index/<?php echo $assignment->base_assignment_id; ?>/<?php echo $assignment->id; ?>" style="color: #4d4d4d;" >
                                    <img src="<?= base_url("/img/icon-doc-red.png") ?>" title="submission" style="height: 16px;" alt="">
                                </a>
                                <?php endif ?>
                            </td>
                            <td style="width: 22%;" class="text-center"><?php echo $assignment->user_deadline_date; ?></td>
                            <td style="width: 6%;" class="text-center"><?php if( $assignment->grade_type != 'offline' ) echo $assignment->grade; else echo "N/A"; ?></td>
                            <td style="width: 4%; background: #f2f2f2!important;" class="text-center">
                            <?php
                                if( $assignment->exempt == 1 ) {
                                    echo '';
                                } elseif( $assignment->publish ) {
                                    if( strtotime( $assignment->submitted_date ) > strtotime( $assignment->deadline_date ) ) {
                                        echo '<span title="Submitted after due date" style="width: 24px; height: 24px; color: green; font-size: 24px;"><i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i></span>';
//                                        echo '<span title="late submission" style="width: 24px; height: 24px; color:#bb3A25; font-size: 24px;"><i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i></span>';
                                    } else {
                                        echo '<i title="Submitted" class="fa fa-check-circle" style="color: green;font-size: 26px;">';
                                    }
                                } elseif( $assignment->active ) {
                                    echo '<i title="Started, awaiting submission" class="fa fa-check-circle" style="color: #E7933C;font-size: 26px;">';
                                } elseif( strtotime( $assignment->deadline_date ) < NOW() ) {
                                        echo '<span title="Past due date" style="width: 24px; height: 24px; color:#bb3A25; font-size: 24px;"><i class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></i></span>';
                                } else {
                                    echo '<div style="width: 24px; height: 24px; border-radius: 50%; background: orange; text-align: center;" title="Awaiting submission"><i class="fa fa-ellipsis-h" style="display: inline; vertical-align: middle;"></div></i>';
                                }
                            ?>
<!--                                <a href="/f3_teacher/index/<?php echo $assignment->base_assignment_id; ?>/<?php echo $assignment->id; ?>" >
                                    <span class=" glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;">&nbsp;</span>
                                </a>-->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
