<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->

<!--<link rel="stylesheet" href="<?php echo base_url("/js/slider/style.css")?>" type="text/css"/>-->
<!--<script src="<?php echo base_url("/js/slider/jquery.noos.slider.min.js")?>"></script>-->
<!--<link rel="stylesheet" href="<?php echo base_url("/js/timepicker/jquery.timepicker.css")?>" type="text/css"/>
<script src="<?php echo base_url("/js/timepicker/jquery.timepicker.min.js")?>"></script>-->
<style type="text/css">
    .row { margin-right: 0px; margin-left: 0px; }
    .ui-timepicker-select { padding: 13px 8px; border: 1px solid #c8c8c8; }
    .table2_s tbody td { border-bottom: solid 5px #fff; border-right: none; }
    .table2_s tbody td a{ color: #111; font-weight: normal;}
    a.delete2 { background: url(/img/Deleteicon_new.png) no-repeat 0 0; }
    a.addAss { background: url(/img/Addicon_new.png) no-repeat 0 0; }
    a.addHomework { font-size: 28px; color: #666!important;width: 24px; height: 24px; display: inline-block; line-height: 1; }
    a.addedHomework { font-size: 28px; color: #099a4d!important; width: 24px; height: 24px; display: inline-block; line-height: 1; }
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
    .disabledinput { opacity:0.5; background-color:#eee; }
    li .collapsed { display: block; }
    span.select .past:before { color: #f00; }
    .field.date .past:before { background: url("/img/icons_calendar.png") no-repeat -30px 0;-webkit-background-size: cover; }
</style>

<!--<script type="text/javascript" src="<?= base_url("/js/nicEdit/nicEdit.js") ?>"></script>-->
<!--<script src="<?php echo base_url("/js/f2b_teacher.js")?>"></script>-->

<div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>

<div class="blue_gradient_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left:0px"><h2>Homework: {assignment_title}</h2></div>
        </div>
        <table width="100%" cellpadding="0" style="margin-top: 0px;">
            <tr>
                <td width="50%" valign="top">
                    <form action="" class="big_label" id="form_assignment" >
                        <div class="slider">
                            <ul class="slides" style="width: 100%; padding-left: 0px;">
                                <li style="list-style: none;">
                                    <div class="row">
                                        <div id="step_2_3" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left;">
                                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Assignment</h3>
                                            <div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px; background-position: 0px -30px;"></div>
                                            <div class="collapsed assignment" style="margin:0px auto;">
                                                <h4 for="assignment_title">Homework Title</h3>
                                                <div class="controls" style="margin-bottom: 30px;">
                                                    <span></span>
                                                    <input type="text" value="{assignment_title}" name="assignment_title" class="required" data-validation-required-message="Please provide a title for this assignment" id="assignment_title">
                                                </div>
                                                <h4 for="assignment_intro">Homework Summary</h4>
                                                <div class="controls" style="margin-bottom: 30px;">
                                                    <span></span>
                                                    <textarea name="assignment_intro" id="assignment_intro" class="textarea_fixed resizable" minlength="30" style="height: 150px;">{assignment_intro}</textarea>
                                                </div>
                                                <h4 for="assignment_intro">Marks Given As</h4>
                                                <select onChange="gradeTypeChange()" name="grade_type" id="grade_type" data-mini="true" style="margin-bottom: 30px;">
                                                    <option value="offline" {selected_grade_type_offline}>{label_grade_type_offline}</option>
                                                    <option value="percentage" {selected_grade_type_pers}>{label_grade_type_percentage}</option>
                                                    <option value="mark_out_of_10" {selected_grade_type_mark_out}>Mark out of 10</option>
                                                    <option value="grade" {selected_grade_type_grade}>{label_grade_type_grade}</option>
                                                    <option value="free_text" {selected_grade_type_free_text}>{label_grade_type_free_text}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="step_2_2" is_visible="y" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left;">
                                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Grade Thresholds</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px; background-position: 0px -30px;"></div>
                                            <div class="collapsed" style="margin:0px auto;">
                                                <div style="padding: 0 0px; background: #f5f5f5;">
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr><td style="padding-left: 12px;"><label>Name</label></td><td style="padding-left: 12px;"><label>Value</label></td><td></td></tr>
                                                        <tr id="grade_holder" style="background: #999;">
                                                            <td style="padding-left: 12px;"><input type="text" id="add_grade_attribute_name"  value="" style="padding: 6px;"></td>
                                                            <td style="padding-left: 12px;"><input type="text" id="add_grade_attribute_value"   value="" style="padding: 6px;"></td>
                                                            <td><span class="status_mark"></span></td>
                                                        </tr>
                                                    </table>
                                                    <table style="background: #f5f5f5;" id="grade_attr_holder" class="table3 w2">
                                                        <tr id="grade_attr_row">
                                                            <td style="padding-left: 12px;"><input type="text" name="grade_attribute_name" value=""></td>
                                                            <td style="padding-left: 12px;"><input type="text" name="grade_attribute_value" class="check_digit" value=""></td>
                                                            <td><a href="javascript:;" class="btn remove add_attr"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step_2_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left; {hide_mark_allocation}">
                                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px; height:26px;overflow: hidden; border-bottom:1px solid #c8c8c8;font-weight: bold;margin-top: 14px;">Mark Allocation</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px; background-position: 0px -30px;"></div>
                                            <div class="collapsed" style="margin:0px auto;">
                                                <div style="padding: 0 0px; background: #f5f5f5;">
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td width="45%" style="padding-left: 12px;"><label>Category</label></td>
                                                            <td width="45%" style="padding-left: 12px;" ><label>Marks Available</label></td>
                                                            <td width="10%"></td>
                                                        </tr>
                                                        <tr class="add_cat" style="width: 100%; background: #999;" >
                                                            <td width="45%" style="padding-left: 12px;">
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="category" value="" id="catg" data-validation-required-message="Please fill in the category" style="padding: 6px;" />
                                                                </div>
                                                            </td>
                                                            <td style="padding-left: 12px;">
                                                                <div width="45%" class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="mark" value="" id="mark" class="mark" data-validation-required-message="Please fill in the mark" style="padding: 6px;" />
                                                                </div>
                                                            </td>
                                                            <td width="10%" style="padding-left: 12px;"><span class="status_mark"></span></td>
                                                        </tr>
                                                    </table>
                                                    <table style="background: #f5f5f5;" id="grade_categories_holder" class="table3 w2">
                                                        <tr id="grade_categories_row" style="border: none;">
                                                            <td width="45%" style="padding-left: 12px;">
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="category" value="" id="catg" class="catg"  data-validation-required-message="Please fill in the category">
                                                                </div>
                                                            </td>
                                                            <td width="45%" style="padding-left: 12px;">
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="mark" value="" id="mark" class="mark"  data-validation-required-message="Please fill in the mark">
                                                                 </div>
                                                            </td>
                                                            <td><a href="javascript:;" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                        </tr>
                                                    </table>
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td colspan="3" style="text-align: center;"><h4 id="marksTotal" style="margin-top: 5px; margin-bottom: 5px; display: inline-block;"></h4></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step_1_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left;">
                                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px; background-position: 0px -30px;"></div>
                                            <div class="collapsed" style="margin:0px auto;">
                                                <ul class="ul1 resources">
                                                    {resources}
                                                    <li id="res_{resource_id}">
                                                        <a href="javascript:;" style="color:#111;" onclick="$(this).next().children().click()">
                                                            <span class="icon {type}" style="color: #c8c8c8"></span>&nbsp; {resource_name}
                                                        </a>
                                                        <span class="show_resource" style="display:none;">{preview}</span>
                                                        <div class="r" style="float: right;"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;"><span class="glyphicon glyphicon-remove"></span></a></div>
                                                    </li>
                                                    {/resources}
                                                </ul>
                                                <div class="buttons">
                                                    <a class="btn b1 right" href="javascript: saveAndAddResource();">ADD NEW RESOURCE<span class="icon i3"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="step_3_1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left;">
                                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Assigned To</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px; background-position: 0px -30px;"></div>
                                            <div class="collapsed" style="margin:0px auto;">
                                                <h4 for="">Year</h4>
                                                <div class="controls disabledinput" style="margin-bottom: 30px;">
<!--                                                    <span></span>-->
                                                    <select disabled="disabled" onChange="Y_changed();" name="classes_year_select" id="classes_year_select" data-validation-required-message="Please select an academic year to assign to">
                                                        <option class="classes_select_option" value="-1"/>
                                                        <optgroup class="classes_select_optgroup" label=""></optgroup>
                                                    </select>
                                                </div>
                                                <h4 for="">Subject</h4>
                                                <div class="controls disabledinput" style="margin-bottom: 30px;">
<!--                                                    <span ></span>-->
                                                    <select disabled="disabled" onChange="S_changed();" name="classes_subject_select" id="classes_subject_select" data-validation-required-message="Please select a subject group to assign to"></select>
                                                </div>
                                                <div id="step_3_1_ax" class="checkbox_fw" style="width: 100%;float: left;margin-bottom: 30px;">
                                                    <h4 >Classes</h4>
                                                    <table class="table4" style="margin: 0;">
                                                        <tr>
                                                            <td style="width: 100%;" id="classes_holder">
                                                                <div style="width: 100%; margin-top: 2px;" class="classes_holder_row disabledinput">
                                                                    <input disabled="disabled" type="checkbox" name="classes[]" value="" id=""><label for=""></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div id="step_3_2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 ;float: left;">
                                                    <div style="display: inline-block;">
                                                        <h4 for="" style="width: 100%;">Deadline Date & Time</h4>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" style="padding: 0;" >
                                                            <div class="field date">
                                                                <span class="icon show_picker"></span>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <div class="fc">
                                                                        <input style="padding: 8px 10px;" type="text" value="{assignment_date}" name="deadline_date" id="deadline_date" class="datepicker" data-validation-required-message="Please select a date for the submission deadline">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style=" float: right; padding: 0;">
                                                            <div class="field time">
                                                                <div class="icon" style="display: none;" >
                                                                    <span class="b"></span>
                                                                </div>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <div class="fc" style=" margin-right: 0; margin-left: 10px;">
                                                                        <span class="select" >
                                                                            <span class="v">
                                                                                <input style="height: 100%;border: none;display:block;" type="text" value="<?php if($assignment_time==''){echo'00:00';}else{?>{assignment_time}<?php } ?>" name="deadline_time" id="basicExample" onclick="$('#basicExample').timepicker('show');" class="" data-validation-required-message="Please set a time of day for the submission deadline">
                                                                            </span>
                                                                            <span class="a" id="openSpanExample"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br /><br />
                                    <!-- Publish start -->
                                                    <div style="display: inline-block;">
                                                        <h4 for="" style="width: 100%;">Publish Date & Time</h4>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7" style="padding: 0;" >
                                                            <div class="field date">
                                                                <span class="icon pshow_picker"></span>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <div class="fc">
                                                                        <input disabled="disabled" style="padding: 8px 10px; opacity: 0.6" type="text" value="{publish_date}" name="publish_date" id="publish_date" class="" data-validation-required-message="Please select a date for the published date">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style=" float: right; padding: 0;">
                                                            <div class="field time">
                                                                <div class="icon" style="display: none;" >
                                                                    <span class="pb"></span>
                                                                </div>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <div class="fc" style=" margin-right: 0; margin-left: 10px;">
                                                                        <span class="select" >
                                                                            <span class="v">
                                                                                <input disabled="disabled" style="height: 100%;border: none;display:block; opacity: 0.6" type="text" value="<?php if(publish_time==''){echo'00:00';}else{?>{publish_time}<?php } ?>" name="publish_time" id="__pbasicExample" onclick="" class="" data-validation-required-message="Please set a time of day for the published date">
<!--                                                                                <input style="height: 100%;border: none;display:block;" type="text" value="<?php if(publish_time==''){echo'00:00';}else{?>{publish_time}<?php } ?>" name="publish_time" id="pbasicExample" onclick="$('#pbasicExample').timepicker('show');" class="" data-validation-required-message="Please set a time of day for the published date">-->
                                                                            </span>
                                                                            <span class="a" id="openSpanExample"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="categories" id="categories" value="">
                        <input type="hidden" name="attributes" id="attributes" value="">
                        <input type="hidden" name="class_id" id="class_id" value="{class_id}">
                        <input type="hidden" name="publish" id="publish" value="{publish}">
                        <input type="hidden" name="assignment_id" id="assignment_id" value="{assignment_id}">
                        <input type="hidden" name="student_id" value="{student_id}">
                        <input type="hidden" name="publishmarks" id="publishmarks" value="{publishmarks}">
                        <input type="hidden" name="server_require_agree" id="server_require_agree" value="0">
                        <input type="hidden" name="has_marks" id="has_marks" value="{has_marks}">
                        <input type="hidden" name="tmp_deadline_date" id="tmp_deadline_date" value="{tmp_deadline_date}">
                    </form>
                </td>
                <td width="50%" valign="top" align="left">
                    <table style="margin-top: 0px;" class="table2_s"  width="100%" cellspacing="0">
                        <tbody> 
                            <?php foreach( $student_assignments as $sa ): ?>
                            <tr>
                                <td ><a class="st-link" href="/f3_teacher/index/<?php echo $assignment_id ?>/<?php echo $sa['id'] ?>" onclick=""><?php echo $sa['first_name'] ?> <?php echo $sa['last_name'] ?></a></td>
                                <td id="ass_status_<?php echo $sa['id'] ?>" align="center"><?php echo $sa['submission_status'] ?></td>
                                <td id="ass_attainment_<?php echo $sa['id'] ?>" style="text-align: center;">
                                    <?php if( $sa['exempt'] == '1' ): ?>
                                    <span style="font-weight: normal;">exempt</span>
                                    <?php else: ?>
                                    <?php echo $sa['attainment'] ?>
                                    <?php endif ?>
                                </td>
                                <td id="ass_delete_<?php echo $sa['id'] ?>" style="text-align: center; padding-left: 10px; padding-right: 10px;">
                                    <?php if( $sa['exempt'] != '1' ): ?>
                                    <a id="exem_<?php echo $sa['id'] ?>" class="delete2" title="exempt <?php echo addslashes( $sa['first_name'] ) .' '. addslashes( $sa['last_name'] ) ?>" href="javascript:doDelAssignments(<?php echo $sa['id'] ?>, '<?php echo addslashes( $sa['first_name'] ) .' '. addslashes( $sa['last_name'] ) ?>')"></a>
                                    
<!--                                    <a class="delete2" title="" href="javascript:confirmDeleteAssignments(<?php echo $sa['id'] ?>, '<?php echo addslashes( $sa['first_name'] ) .' '. addslashes( $sa['last_name'] ) ?>')"></a>-->
                                    <?php else: ?>
                                    <a id="exem_<?php echo $sa['id'] ?>" class="addAss" title="" href="javascript:doAddAssignments(<?php echo $sa['id'] ?>, '<?php echo addslashes( $sa['first_name'] ) .' '. addslashes( $sa['last_name'] ) ?>')"></a>
<!--                                    <a class="addAss" title="" href="javascript:confirmAddAssignments(<?php echo $sa['id'] ?>, '<?php echo addslashes( $sa['first_name'] ) .' '. addslashes( $sa['last_name'] ) ?>')"></a>-->
                                    <?php endif ?>
                                    <?php echo $sa['publish'] ?>
                                </td>
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

<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: copyAssignment('<?php echo $assignment_id ?>')" class="red_btn" id="copy">COPY FOR ANOTHER CLASS</a>
            <a href="javascript: confirmPublishMarks();" class="publish_btn" id="publishmarks_btn"><span>PUBLISH MARKS</span></a>
            <a href="javascript: confirmPublish();" class="publish_btn" id="publish_btn" style="display:none"><span>PUBLISH</span></a>
            <a href="javascript: saveNewAssigment('save',0);" id="saveBT" class="red_btn">SAVE</a>
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
                <input type='hidden' class='assign_title' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDel" do="1" type="button" onClick="doDelAssignments()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupAddAssign" class="modal fade">
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
                <input type='hidden' class='assign_title' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupDel" do="1" type="button" onClick="doAddAssignments()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupCopyAss" class="modal fade">
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
                <input type='hidden' class='assignment_id' value="" />
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupCopy" type="button" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    var classes_years_json = {classes_years_json};
    var selected_year = "{assigned_to_year}";
    var selected_subject = "{assigned_to_subject}";
    var selected_classes = "{class_id}";
    var selected_classes_data = selected_classes.split(',');
    var assignment_categories_json = {assignment_categories_json};
    var assignment_attributes_json = {assignment_attributes_json};
    var assignment_id = {assignment_id};
    var mode = "{mode}";
    var published = "{publish}";
    var datepast = "{datepast}";
    var timepicker;
    var min_date = {min_date};
//console.log(datepast);
    URL_PARALEL_ID_BASED = '/index/'+assignment_id;
    if( assignment_id == -1 ) { URL_PARALEL_ID_BASED = ''; }
    URL_PARALEL = false;
    if( published == 1 && mode == 1 ) { URL_PARALEL = '/f2b_teacher'+URL_PARALEL_ID_BASED; }
    if( published == 0 && mode == 2 ) { URL_PARALEL = '/f2c_teacher'+URL_PARALEL_ID_BASED; }
    if( URL_PARALEL ) { document.location = URL_PARALEL; }
 
    $(function() {
        bkLib.onDomLoaded(function() { 
            new nicEditor({
                buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
    //            iconsPath : '<?= base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
            }).panelInstance('assignment_intro');
        })
        $('.up_down___').on('click',function () {
            $(this).next('.up_down_homework').click();
        })
    })

</script>
