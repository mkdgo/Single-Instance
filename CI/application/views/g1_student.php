<script src="<?= base_url("/js/g1_student.js") ?>"></script>
<script type="text/javascript">
    var g1_subject_id = <?php echo $this->_data['subject_id']; ?>;
    var g1_work_id = <?php echo $this->_data['work_id']; ?>;
</script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2 class="pull-left"><?php echo $this->_data['student_fullname'] ?></h2>
            </div>
        </div>
        <div class="row hidden-xs">&nbsp;</div>
        <?php foreach ($this->_data['subjects'] as $s_key=> $subject): ?>
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="acc_title" id="subject-<?php echo $subject['id']; ?>" data-subject-id="<?php echo $subject['id']; ?>" data-offset="<?php echo $subject['offset']; ?>" style="padding-left: 60px; padding-bottom: 15px; border-bottom: 1px solid #ccc;<?php if (count($this->_data['subjects'][$s_key]['works']) == 0) { echo "color:#aaa;";}?>">
                        <?php echo $subject['logo_pic']."<b>".$subject['name']."</b> - ".$subject['group_name']." - ".$subject['teachers']; ?>
                    </h3>
                    <div class="up_down" style="cursor:pointer;<?php if (count($this->_data['subjects'][$s_key]['works']) == 0) { echo "background-image:none;";}?>"><span class="count_lessons count_drafted" style="<?php if (count($this->_data['subjects'][$s_key]['works']) == 0) { echo "color:#aaa;";}?>">(<?php echo count($this->_data['subjects'][$s_key]['works'])?>)</span></div>
                    <?php if (count($this->_data['subjects'][$s_key]['works']) > 0) { ?>
                    <div class="collapsed">
                        <div style="display: block; ">
                            <div class="row" style="margin-bottom: 5px;">
                                <div class="col-xs-12"><strong style="padding: 5px;">Work</strong></div>
                            </div>
                        </div>
                        <table class="table2" >
                            <thead>
                                <tr class="ediface-subhead">
                                    <td style="width: 5%;" class="text-center">Type</td>
                                    <td style="width: 40%;">Title</td>
                                    <td style="width: 18%;">Tagged to Assignment</td>
                                    <td style="width: 12%;" class="text-center">Date Tagged</td>
                                    <td style="width: 16%;" class="text-center">Tagged By</td>
                                    <td style="width: 4%;">&nbsp;</td>
                                </tr>
                            </thead>
                            <?php foreach ($subject['works'] as $work): ?>
                                <tr class="ediface-inner tr-work-<?php echo $subject['id']; ?>">
                                    <td style="width: 5%; color: #db4646;text-align: center;" class="text-center"><span class="glyphicon glyphicon-paperclip"></span></td>
                                    <td style="width: 40%;">
                                        <span class="work-item" data-work-id="<?php echo $work->id; ?>" style="color: #4d4d4d; cursor: pointer;">
                                            <a id="work-<?php echo $work->id; ?>" data-offset="<?php echo $work->offset; ?>" data-parent-subject-id="<?php echo $subject['id']; ?>" role="button" data-toggle="collapse" href="#work-item-<?php echo $work->id; ?>" aria-expanded="false" aria-controls="work-item-<?php echo $work->id; ?>">
                                                <?php echo $work->title; ?>
                                            </a>
                                        </span>
                                        <div id="work-item-<?php echo $work->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
                                            <div class="panel-body">
                                                <ul class="list-group">
                                                    <?php foreach ($work->items as $wi): ?>
                                                        <li class="list-group-item" style="background-color: inherit; border: 0 none;">
                                                            <span class="icon <?php echo $wi->item_type; ?>" style="margin-top: -3px;"></span>
                                                            <a href="/f5_student/index/<?php echo $subject['id']; ?>/<?php echo $wi->work_id; ?>/<?php echo $wi->work_item_id; ?>" style="padding-left:5px"><?php echo $wi->item_name; ?></a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 18%; text-align: center;">
                                        <?php if ($work->assignment): ?>
                                            <a href="<? echo $work->assignmentlink; ?>"><i class="icon ok" style="margin-left: 0px;"></i></a>
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 12%;" class="text-center">
                                        <?php echo $work->created_on; ?>
                                    </td>
                                    <td style="width: 16%; border-right: solid 3px #fff;" class="text-center">
                                        <?php echo $work->tagger_name; ?>
                                    </td>
                                    <td style="width: 4%;" class="text-center">
                                        <span style="color: #4d4d4d; cursor: pointer;">
                                            <a role="button" data-toggle="collapse" href="#work-item-<?php echo $work->id; ?>" aria-expanded="false" aria-controls="work-item-<?php echo $work->id; ?>">
                                                <span class="work-item glyphicon glyphicon-chevron-right" style="margin-left: -16px;color: #bfbfbf;" data-work-id="{id}">&nbsp;</span>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
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
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right"></div>
    </div>
</footer> 
