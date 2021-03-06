<!--<script src="<?=base_url("/js/g1_teacher.js")?>"></script>-->
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumbs}</div></div>
    <div class="container">
        <h2>Students</h2>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="float:left;margin-left:0px;width: 100%">
                <div class="f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Teacher</label>
                    <select class="teacher_select">
                        <option value="<?php  echo $this->session->userdata('id')?>" selected="selected">Me (<?php  echo $this->session->userdata('last_name')?>, <?php  echo $this->session->userdata('first_name')?>)</option>
                        {if teachers}
                        <option value="all" >All</option>
                        {teachers}
                        <option value="{id}" >{teacher_name}</option>
                        {/teachers}
                        {/if}
                    </select>
                </div>
                <div class="f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Subject</label>
                    <select class="subject_select">
                        <option value="all" subject_ids="{all_subjects}">All</option>
                        {if t_subjects}
                        {t_subjects}
                        <option value="{id}" subject_ids="{classes_ids}">{name}</option>
                        {/t_subjects}
                        {/if}
                    </select>
                </div>
                <div class="f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Year</label>
                    <select class="subject_year_select">
                        {subjects_years}
                        <option value="0" disabled="disabled" selected="selected">All</option>
                        {/subjects_years}
                    </select>
                </div>
                <div class="f_gray" style="float:left;width: 25%;">
                    <label>Class</label>
                    <select class="class_select">
                        {year_class}
                        <option value="0" disabled="disabled" selected="selected">All</option>
                        {/year_class}
                    </select>
                </div>
            </div>
        </div>
        <?php $i=0;?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 f1" >
                <?php if($subjects_list): ?>
                    <?php foreach($subjects_list as $list): ?>
                <h3 class="acc_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;<?php if (count($list['subject_years']) == 0) { echo "color:#aaa;";}?>"><?php echo $list['name']?></h3>
                <div class="up_down" style="cursor:pointer;padding-right: 2px;<?php if (count($list['subject_years']) == 0) { echo "background-image:none;";}?>"><span class="count_lessons count_assigned">(<?php echo count($list['subject_years'])?>)</span></div>
                        <?php if (count($list['subject_years']) > 0): ?>
                <div class="collapsed" style="display: none;">
                    <div class="row" style="width: 100%;margin-left: 0;" >
                        <?php if (!empty($list['subject_years'])) foreach ($list['subject_years'] as $sub_years): ?>
                        <h3 class="acc_title" style="background-color:#ddd;cursor:pointer;padding:18px 10px;margin-top:-3px;border-bottom: 1px solid #dddddd;font-size:14px;font-weight:bold;<?php if (count($sub_years['classes']) == 0) { echo "color:#aaa;";}?>">Year: <?php echo $sub_years['year']?></h3>
                        <div class="up_down" style="cursor:pointer;top:0px;margin-right: 2px;<?php if (count($sub_years['classes']) == 0) { echo "background-image:none;";}?>"><span class="count_lessons count_assigned">(<?php echo count($sub_years['classes'])?>)</span></div>
                        <?php if (count($sub_years['classes']) > 0): ?>
                        <div class="collapsed" style="display: none;">
                            <div class="row" style="width: 100%;margin-left: 0;">
                                <?php if( !empty($sub_years['classes'])) foreach ($sub_years['classes'] as $class): ?>
                                <h3 class="acc_title" style="background-color:#eee; cursor:pointer;padding:10px;;margin-top:-5px;border-bottom: 1px solid #eeeeee;font-size:14px;<?php if (count($class['students']) == 0) { echo "color:#aaa;";}?>">Class: <?php echo $class['group_name']?></h3>
                                <div class="up_down" style="cursor:pointer;top:6px;margin-right: 2px;<?php if (count($class['students']) == 0) { echo "background-image:none;";}?>"><span class="count_lessons count_assigned">(<?php echo count($class['students'])?>)</span></div>
                                <?php if( count($class['students']) > 0): ?>
                                <div class="collapsed" style="display: none;">
                                    <div class="row clearfix " style="padding: 5px 0px 15px 0px;">
                                        <?php if( !empty($class['students']) ): ?>
                                        <?php foreach( $class['students'] as $students_list ): ?>
                                        <div class="col-sm-12 col-md-6" >
                                            <!--<a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/<?php echo $students_list['subject_ids'].'/'.$students_list['year_id'].'/'.$students_list['class_id'].'/'.$students_list['ids']?>">-->
                                                <a class="ediface-student col-sm-12 col-md-11" style="border-bottom: 1px solid #ccc;padding-bottom: 5px;padding-top: 10px;width: 100%;" href="/g1_teacher/student/<?php echo $students_list['ids']; ?>">
                                                <span class="pull-left"><?php echo $students_list['first_name'].' '.$students_list['last_name']; ?></span>
                                                <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                                            </a>
                                        </div>
                                        <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
                        <?php endif ?>
                    <?php endforeach ?>
                <?php endif; ?>
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
<script type="text/javascript">
    var g1_work_id = 0;
    var g1_work_item_id = 0;
</script>
