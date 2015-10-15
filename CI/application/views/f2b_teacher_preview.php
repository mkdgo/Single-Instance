<!--<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url("/js/timepicker/jquery.timepicker.css")?>" type="text/css"/>
<style type="text/css">
    .row { margin-right: 0px; margin-left: 0px; }
    .pr_title{padding-left: 30px;min-width:130px;color:#777;font-size:14px;}
    a.delete2 { background: url(/img/Deleteicon_new.png) no-repeat 0 0; }
    a.addAss { background: url(/img/Addicon_new.png) no-repeat 0 0; }
    a.delete2, a.addAss {
        display: inline-block;
        width: 24px;
        height: 24px;
        margin-left: 3px;
        background-size: 24px 24px;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        -ms-interpolation-mode: bicubic;
    }
</style>
<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>

<div class="blue_gradient_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px"><h2>Homework: &nbsp; {assignment_title}</h2></div>
        </div>
        <table width="100%" cellpadding="0" style="/*margin-left: -38px;*/">
            <tr>
                <td width="50%" valign="top">
                    <ul class="slides" style="width: 100%; padding-left: 0px;list-style: none;">
                        <li style="margin:0px 15px 0 0;">
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                                <h3 class="up_down___" style="cursor:pointer;padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Assignment</h3>
                                <div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;margin-top:-36px; background-position: 0px -30px;"></div>
                                <div class="collapsed assignment" style="margin:0px auto;">
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="padding: 10px 0px 17px 0px;font-weight: normal; float: left;">{assignment_intro}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Assigned to: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">Year {assigned_to_year},  {assigned_to_subject} ({assigned_to_classes})</div>
<!--                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{assigned_to_year}th Grade,  {assigned_to_subject} ({assigned_to_classes})</div>-->
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Set by: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{set_by}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Date: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{assignment_date_preview}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Time: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{assignment_time}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Marks Given As: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{grade_type}</div>
                                    </div>
                                </div>
                                <div style="display: none;">
                                    <div class="controls">
                                        <select onChange="Y_changed();" name="classes_year_select" id="classes_year_select" data-validation-required-message="Please select an academic year to assign to">
                                            <option class="classes_select_option" value="-1"/>
                                        </select>
                                    </div>
                                    <div class="controls">
                                        <span></span>
                                        <select onChange="S_changed();" name="classes_subject_select" id="classes_subject_select" data-validation-required-message="Please select a subject group to assign to"></select>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {if resources}
                        <li style="margin:0px 15px 0 0;">
                            <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                                <div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                <div class="collapsed" style="margin:0px auto;">
                                    <ul class="ul1 resources">
                                        {resources}
                                        <li>
                                            <a href="javascript:;" style="background: none;border-bottom:1px solid #c8c8c8;color:#111;padding-top: 4px;" onclick="$(this).next().children().click()">
                                                <span class="icon {type}" style="margin-top: -2px;color: #c8c8c8"> </span> {resource_name}
                                            </a>
                                            <span class="show_resource" style="display:none;">{preview}</span>
                                        </li>
                                        {/resources}
                                    </ul>
                                </div>
                            </div>
                        </li>
                        {/if}
                        {if grade_type != 'offline'}
                        <li style="margin:0px 15px 0 0;">
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px; height:26px;overflow: hidden; border-bottom:1px solid #c8c8c8;font-weight: bold;margin-top: 14px;">Mark Allocation</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                <div class="collapsed" style="margin:0px auto;">
                                    {assignment_categories}
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">{category_name}: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{category_marks}</div>
                                    </div>
                                    {/assignment_categories}
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;" id="marksTotal"></div>
                                </div>
                            </div>
                        </li>
                        <li style="margin:0px 15px 0 0;">
                            <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                                <h3 class="up_down___" style="cursor:pointer;padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Grade Thresholds</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;margin-top:-36px;"></div>
                                <div class="collapsed" style="margin:0px auto;">
                                    <div id="grade_attr_holder_preview"></div>
                                </div>
                            </div>
                        </li>
                        {/if}
                    </ul>
                </td>
                <td width="50%" valign="top" align="left">
                    <table style="margin-top: 0px;background-color: #ececec; float: left;" class="table2_preview"  width="100%" cellspacing="0">
                        <tbody>
                            <?php foreach( $student_assignments as $sa ): ?>
                            <tr>
                                <td ><a href="/f3_teacher/index/<?php echo $assignment_id ?>/<?php echo $sa['id'] ?>"><?php echo $sa['first_name'] ?> <?php echo $sa['last_name'] ?></a></td>
                                <td id="ass_status_<?php echo $sa['id'] ?>" align="center"><?php echo $sa['submission_status'] ?></td>
                                <td id="ass_attainment_<?php echo $sa['id'] ?>" align="center"><?php echo $sa['attainment'] ?></td>
<!--                                <td id="ass_delete_<?php echo $sa['id'] ?>" align="center"><?php if( $sa['submission_status'] != '' ): ?><a class="delete2" href="javascript:confirmDeleteAssignments(<?php echo $sa['id'] ?>, '<?php echo $sa['first_name'] .' '. $sa['last_name'] ?>')"></a><?php endif ?></td>-->
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="clear" style="height: 1px;"></div>

<prefooter>
    <div class="container"></div>
</prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: copyAssignment('<?php echo $assignment_id ?>')" class="red_btn" id="copy">COPY FOR ANOTHER CLASS</a>
            <?php if( $grade_type != 'offline' ): ?>
            <a href="javascript: confirmPublishMarksOnly();" class="publish_btn <?php if( $publishmarks ) echo 'active'; ?>" id="publishmarks_btn"><span><?php if( $publishmarks ) echo 'PUBLISH MARKS'; else echo 'PUBLISH MARKS'; ?></span></a>
            <?php endif ?>
            <?php if( $datepast == 0 ): ?>
<!--            <a href="<?php echo base_url()?>f2b_teacher/edit/{assignment_id}"  class="btn b1edit " style="text-align: center">EDIT</a>-->
            <?php endif ?>
        </div>
    </div>
</footer>
<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupPubl" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title">Publish Assignment</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal" onClick="undoPubl()">CANCEL</button>
                <button id="popupPublBT" do="1" type="button" onClick="doPubl()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupDelRes" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer2">
                <input type='hidden' class='res_id' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDel" do="1" type="button" onClick="doDelRes()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupDelAssign" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer2">
                <input type='hidden' class='assign_id' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDel" do="1" type="button" onClick="doDelAssignments()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script src="<?php echo base_url("/js/timepicker/jquery.timepicker.js")?>"></script>
<script src="<?php echo base_url("/js/f2b_teacher.js")?>"></script>
<script>
//    loadTinymceSlider();
    
    var classes_years_json = {classes_years_json};
    var selected_classes = "{class_id}";
    var selected_classes_data = selected_classes.split(',');
    var selected_year = "{assigned_to_year}";
    var selected_subject = "{assigned_to_subject}";
    var assignment_categories_json = {assignment_categories_json};
    var assignment_attributes_json = {assignment_attributes_json};
    var assignment_id = {assignment_id};
    var mode = "{mode}";
    var published = "{publish}";
    var datepast = "{datepast}";
    var publishmarks = "{publishmarks}";

    URL_PARALEL_ID_BASED = '/index/'+assignment_id;
    if(assignment_id==-1)URL_PARALEL_ID_BASED = '';


    URL_PARALEL=false;

    if(published==1 && mode==1) {
        URL_PARALEL = '/f2b_teacher'+URL_PARALEL_ID_BASED;
    }

    if(published==0 && mode==2) {
        URL_PARALEL = '/f2c_teacher'+URL_PARALEL_ID_BASED;
    }

    if(URL_PARALEL)document.location = URL_PARALEL;

    $(function  () {
        $('.up_down___').on('click',function () {
            $(this).next('.up_down_homework').click();
        })
    })
</script>
