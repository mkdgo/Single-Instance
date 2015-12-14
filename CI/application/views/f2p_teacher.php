<!--<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<link rel="stylesheet" href="<?php echo base_url("/js/slider/style.css")?>" type="text/css"/>
<script src="<?php echo base_url("/js/slider/jquery.noos.slider.min.js")?>"></script>
<link rel="stylesheet" href="<?php echo base_url("/js/timepicker/jquery.timepicker.css")?>" type="text/css"/>
<script src="<?php echo base_url("/js/timepicker/jquery.timepicker.min.js")?>"></script>

<?php
/*
// add css files
$this->minify->css(
    array(
        'js/slider/style.css',
        '/js/timepicker/jquery.timepicker.css'
    )
); 
// add js files
$this->minify->js(
    array(
        'js/slider/jquery.noos.slider.js',
        'js/timepicker/jquery.timepicker.js'
//        'js/f2p_teacher.js'
    )
); 

// bool argument for rebuild css (false means skip rebuilding). 
echo $this->minify->deploy_css(TRUE);
//Output: '<link href="path-to-compiled-css" rel="stylesheet" type="text/css" />'

// rebuild js (false means skip rebuilding).
echo $this->minify->deploy_js(TRUE); 
//Output: '<script type="text/javascript" src="path-to-compiled-js"></script>'.
//*/
?>

<style type="text/css">
    .row { margin-right: 0px; margin-left: 0px; }
    .ui-timepicker-select { padding: 13px 8px; border: 1px solid #c8c8c8; }
    .table2_s tbody td { border-bottom: solid 1px #fff; border-right: none; }
    .table2_s tbody td a{ color: #111; font-weight: normal;}
    #header1.active {color: #000; font-weight: bold;}
    #header2.active {color: #000; font-weight: bold;}
    #header3.active {color: #000; font-weight: bold;}
    a.delete2 {
        display: inline-block;
        width: 24px;
        height: 24px;
        margin-left: 3px;
        background: url(/img/Deleteicon_new.png) no-repeat 0 0;
        background-size: 24px 24px;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        -ms-interpolation-mode: bicubic;
    }
    .ui-timepicker-select {}
    a.publish_chk {
        display: inline-block;
        width: 100%;
        float: left;
        text-align: left;
        color: #fff;
        text-decoration: none;
        line-height: 3.4;
        padding: 0px 10px;
    }
    .publish_chk:before {
        content: '';
        display: inline-block;
        background: #fff;
        width: 20px;
        height: 20px;
        text-align: center;
        vertical-align: middle;
        color: #aaa;
        font-family: 'Glyphicons Halflings';
    }
    .publish_chk.active {}
    .publish_chk.active:before { content: "\e013"; line-height: 1.3; color: #099A4D; }
    span.select .past:before { color: #f00; }
    .field.date .past:before { background: url("/img/icons_calendar.png") no-repeat -30px 0;-webkit-background-size: cover; }
</style>
<!--<script type="text/javascript" src="<?= base_url("/js/nicEdit/nicEdit.js") ?>"></script>-->
<script type="text/javascript">
    
    var classes_years_json = {classes_years_json};
    var selected_year = "{assigned_to_year}";
    var selected_subject = "{assigned_to_subject}";
    var selected_classes = "{class_id}";
    var selected_classes_data = selected_classes.split(',');
    var assignment_categories_json = {assignment_categories_json};
    var assignment_attributes_json = {assignment_attributes_json};
    var assignment_id = {assignment_id};
    var assignment_publish_date_disabled = {assignment_publish_date_disabled};
    var mode = "{mode}";
    var published = "{publish}";
    var datepast = "{datepast}";
    var timepicker;
    var min_pdate = 0;
    var min_date = {min_date};

    $(function  () {
        $('.up_down___').on('click',function () {
            $(this).next('.up_down_homework').click();
        })

        bkLib.onDomLoaded(function() { 
            new nicEditor({
                buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
    //            iconsPath : '<?= base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
            }).panelInstance('assignment_intro');
        })
    })

</script>
<script src="<?php echo base_url("/js/f2p_teacher.js")?>"></script>

<div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>

<div class="blue_gradient_bg">
    <div class="container">
        <form action="" class="big_label" id="form_assignment" >
            <div class="slider" style="margin-top: 50px;">
                <h4 id="step_title" style="font-size: 60px; background-image: url('/img/f2c_teacher_steps.png' );background-position-y: 411px;background-position-x: 0px; background-size: cover;">&nbsp;</h4>
                <ul class="slides" style="width: 100%; padding-left: 0px;height:700px">
                    <li>
                        <article class="step s1">
                            <div class="buttons clearfix"><a id="n1" class="btn b2 right next-step nav next" href="#">Next</a></div>
                            <div class="row">
                                            <div id="step_1_1" class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left: 0;">
                                                <h4 for="assignment_title">Homework Title</h4>
                                                <div class="controls" style="margin-bottom: 30px;">
                                                    <span></span>
                                                    <input type="text" value="{assignment_title}" name="assignment_title" class="required" data-validation-required-message="Please provide a title for this assignment" id="assignment_title">
                                                </div>
                                                <h4 for="assignment_intro">Homework Summary</h4>
                                                <div class="controls" style="margin-bottom: 30px;">
                                                    <span class="tiny-txt"></span>
                                                    <textarea name="assignment_intro" id="assignment_intro" class="textarea_fixed  resizable" minlength="30" style="height: 150px;">{assignment_intro}</textarea>
<!--                                                    <textarea name="assignment_intro" id="assignment_intro" class="textarea_fixed mce-toolbar-grp resizable" minlength="30" >{assignment_intro}</textarea>-->
                                                </div>
                                                <?php if( $mode != 1 ): ?>
                                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Marks given As</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                                <div class="collapsed" style="margin:0px auto;">
                                                <?php else: ?>
                                                <h4 for="grade_type" >Marks given As</h4>
                                                <?php endif ?>
                                                <select onChange="gradeTypeChange()" name="grade_type" id="grade_type" data-mini="true" style="margin-bottom: 30px;" class="resizable">
                                                    <option value="offline" {selected_grade_type_offline}>{label_grade_type_offline}</option>
                                                    <option value="percentage" {selected_grade_type_pers}>{label_grade_type_percentage}</option>
                                                    <option value="mark_out_of_10" {selected_grade_type_mark_out}>Mark out of 10</option>
                                                    <option value="grade" {selected_grade_type_grade}>{label_grade_type_grade}</option>
                                                    <option value="free_text" {selected_grade_type_free_text}>{label_grade_type_free_text}</option>
                                                </select>
                                                <?php if( $mode != 1 ): ?>
                                                </div>
                                                <?php endif ?>
                                            </div>
                                            <div id="step_1_2" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-12" style="margin:0 auto;padding: 0 15px 30px 0;float: left;">
                                                <?php if( $mode != 1 ): ?>
                                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                                <div class="collapsed" style="margin:0px auto;">
                                                <?php else: ?>
                                                <h4>Resources</h4>
                                                <?php endif ?>
                                                    <ul class="ul1 resources">
                                                        {resources}
                                                        <li id="res_{resource_id}">
                                                            <a href="javascript:;" style="color:#111;" onclick="$(this).next().children().click()"><span class="icon {type}" style="color: #c8c8c8"></span>&nbsp; {resource_name}</a>
                                                            <span class="show_resource" style="display:none;">{preview}</span>
                                                            <div class="r" style="float: right;"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;"><span class="glyphicon glyphicon-remove"></span></a></div>
                                                        </li>
                                                        {/resources}
                                                    </ul>
                                                    <div class="buttons"><a class="btn b1 right" href="javascript: saveAndAddResource();">ADD NEW RESOURCE<span class="icon i3"></span></a></div>
                                                <?php if( $mode != 1 ): ?>
                                                </div>
                                                <?php endif ?>
                                            </div>
                                        </div>
                        </article>
                    </li>
                    <li>
                        <article class="step s2">
                            <div class="buttons clearfix">
                                            <a id="p1" class="btn b2 left prev-step nav prev" href="#">Previous</a>
                                            <a class="btn b2 right next-step nav next" href="#">Next</a>
                                        </div>
                            <div class="row">
                                            <div id="step_2_1n" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 10px 30px 0;float: left;">
                                                <h3 class="" style="padding-bottom: 6px; height:26px;font-weight: bold;margin-top: 14px;text-align: center;">No mark scheme required for offline submission homework assignments</h3>
                                            </div>
                                            <div id="step_2_1" class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 10px 30px 0;float: left;">
                                                <?php if( $mode != 1 ): ?>
                                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px; height:26px;overflow: hidden; border-bottom:1px solid #c8c8c8;font-weight: bold;margin-top: 14px;">Mark Allocation</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                                <div class="collapsed" style="margin:0px auto;">
                                                <?php else: ?>
                                                <h4>Mark Categories</h4>
                                                <?php endif ?>
                                                <div style="padding: 0 0px; background: #f5f5f5;">
                                                    <table id="" style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td width="45%" style="padding-left: 12px;"><label>Category</label></td><td width="45%" style="padding-left: 12px;"><label>Marks Available</label></td><td width="10%"></td>
                                                        </tr>
                                                        <tr class="add_cat" style="width: 100%; background: #999;" >
                                                            <td width="45%" style="padding-left: 12px;">
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="category" value="" id="catg" data-validation-required-message="Please fill in the category" style="padding: 6px;">
                                                                </div>
                                                            </td>
                                                            <td width="45%" style="padding-left: 12px;">
                                                                <div width="46%" class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="mark" value="" id="mark" class="mark" data-validation-required-message="Please fill in the mark" style="padding: 6px;">
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
                                                            <td colspan="3" style="text-align: center;"><h3 id="marksTotal" style="margin-top: 5px; margin-bottom: 5px; display: inline-block;"></h3></td>
<!--                                                            <td width="45%"><h3 id="marksTotal"></h3></td>
                                                            <td width="45%">-->
                                                                <!--<a id="add_cat_link" style="margin-bottom: 0px; float: right;" href="javascript: addCategory();">+ Add New Category</a>-->
<!--                                                                <a id="add_cat_link" style="margin-bottom: 0px; float: right;" href="javascript: addCategoryField();">+ Add New Category</a>-->
<!--                                                            </td>
                                                            <td width="10%"></td>-->
                                                        </tr>
                                                    </table>
                                                </div>
                                            <?php if( $mode != 1 ): ?>
                                            </div>
                                            <?php endif ?>
                                            </div>
                                            <div id="step_2_2" is_visible="y" class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0px 30px 10px;float: left;">
                                                <h4>Grade Thresholds</h4>
                                                <div style="padding: 0 0px; background: #f5f5f5;">
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td><label>Name</label></td>
                                                            <td><label>Value</label></td>
                                                            <td></td>
                                                        </tr>
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
                        </article>
                    </li>
                    <li>
                        <article class="step s3">
                            <div class="buttons clearfix"><a class="btn b2 left prev-step nav prev" href="#">Previous</a></div>
                            <div class="row">
                                <div id="step_3_1" class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-left: 0;">
                                    <label for="">Assign to</label>
                                    <div class="controls" style="margin-bottom: 30px;">
                                                    <span></span>
                                                    <select onChange="Y_changed();" name="classes_year_select" id="classes_year_select" data-validation-required-message="Please select an academic year to assign to">
                                                        <option class="classes_select_option" value="-1"/>
                                                        <optgroup class="classes_select_optgroup" label=""></optgroup>
                                                    </select>
                                                </div>
                                    <label for="">Subject</label>
                                    <div class="controls" style="margin-bottom: 30px;">
                                        <span></span>
                                        <select onChange="S_changed();" name="classes_subject_select" id="classes_subject_select" data-validation-required-message="Please select a subject group to assign to"></select>
                                    </div>
                                    <!-- Deadline  -->
                                    <div style="margin-bottom: 30px; display: inline-block;">
                                                    <label for="" style="width: 100%;">Deadline Date & Time</label>
                                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding: 0;" >
                                                        <div class="field date">
                                                            <span class="icon show_picker"></span>
                                                            <div class="controls">
                                                                <div class="fc">
                                                                    <span></span>
                                                                    <input style="padding: 8px 10px;" type="text" value="{assignment_date}" name="deadline_date" id="deadline_date" class="datepicker" data-validation-required-message="Please select a date for the submission deadline that is later than Publish date!">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style=" float: right; padding: 0;">
                                                        <div class="field time">
                                                            <div class="icon" style="display: none;" >
                                                                <span class="b"></span>
                                                            </div>
                                                            <div class="controls">
                                                                <span></span>
                                                                <div class="fc" style=" margin-right: 0; margin-left: 10px;">
                                                                    <span class="select" >
                                                                        <span class="v">
                                                                            <input style="height: 100%;border: none;display:block; padding: 0" type="text" value="<?php if($assignment_time==''){echo'00:00';}else{?>{assignment_time}<?php } ?>" name="deadline_time" id="basicExample" class="" data-validation-required-message="Please set a time of day for the submission deadline">
                                                                        </span>
                                                                        <span class="a"></span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <!-- Publish start -->
                                    <div style="margin-bottom: 30px; background: #099a4d; display: inline-block; width: 100%;">
                                        <a href="javascript: setPublishDate();" class="publish_chk {assignment_publish_date_active}" id="publish_chk" ><span style="padding-left: 5px;">Publish at a later date</span></a>
                                        <div id="pta" style="padding: 10px; display: inline-block; font-size: 14px; background: #099a4d; color: #fff;">
                                            <label for="" style="display: inline;">Select date and time to automatically publish this assignment</label>
                                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8" style="padding: 0;" >
                                                <div class="field date">
                                                    <span class="icon pshow_picker"></span>
                                                    <div class="controls">
                                                        <div class="fc">
                                                            <span></span>
                                                            <input style="padding: 8px 10px;" type="text" value="{assignment_publish_date}" name="_publish_date" id="publish_date" class="pdatepicker" data-validation-required-message="Please select a date when the homework will be published">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4" style=" float: right; padding: 0;">
                                                            <div class="field time">
                                                                <div class="icon" style="display: none;" >
                                                                    <span class="b"></span>
                                                                </div>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <div class="fc" style=" margin-right: 0; margin-left: 10px; background: #fff;">
                                                                        <span id="pta" class="select" >
                                                                            <span class="v">
                                                                                <input style="height: 100%;border: none;display:block; padding: 0" type="text" value="<?php if($assignment_publish_time==''){echo'00:00';}else{?>{assignment_publish_time}<?php } ?>" name="_publish_time" id="publishbasicExample" class="" data-validation-required-message="Please set a time of day when the homework will be published">
                                                                            </span>
                                                                            <span class="a"></span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        </div>
                                    </div>
                                    <br />
                                </div>
                                <div id="step_3_2" class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 0;">
                                    <div id="step_3_1_ax" class="checkbox_fw" style="width: 100%;float: left;">
                                        <label>Assign to classes</label>
                                        <div class="controls">
                                            <span></span>
                                            <table class="table4" style="margin: 0;">
                                                <tr>
                                                    <td style="width: 100%;" id="classes_holder">
                                                        <div style="width: 100%; margin-top: 2px;" class="classes_holder_row"><input class="classes" type="checkbox" name="classes[]" value="" id=""><label for=""></label></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
<!--
                                    <label for="assignment_title">Assign to individual Student(s)</label>
                                    <div class="controls" style="margin-bottom: 30px;">
                                        <span></span>
                                        <div class="keystudents" id="keywords">
                                            <input type="text" id="keystudents"  name="keystudents"  value="{keystudents}" style="display: none;">
                                            <input type="hidden" id="keystudents_a" name="keystudents_a" >
                                        </div>
                                    </div>
-->
                                </div>
                            </div>
                        </article>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
            <input type="hidden" name="categories" id="categories" value="">
            <input type="hidden" name="attributes" id="attributes" value="">
            <input type="hidden" name="class_id" id="class_id" value="">
            <input type="hidden" name="publish" id="publish" value="{publish}">
            <input type="hidden" name="assignment_id" id="assignment_id" value="{assignment_id}">
            <input type="hidden" name="publishmarks" id="publishmarks" value="{publishmarks}">
            <input type="hidden" name="server_require_agree" id="server_require_agree" value="0">
            <input type="hidden" name="has_marks" id="has_marks" value="{has_marks}">
            <input type="hidden" name="publish_date" id="org_publish_date" value="">
            <input type="hidden" name="publish_time" id="org_publish_time" value="">
            <input type="hidden" name="tmp_deadline_date" id="tmp_deadline_date" value="{tmp_deadline_date}">
        </form>
    </div>
</div>

<div class="clear" style="height: 1px;"></div>

<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a onclick="CP( 1 )" class="slide_ctrl_prev btn b2 prev-step  prev" style="margin-top: -1px" href="#">Previous</a>
            <a onclick="CN( 1 )" class="slide_ctrl_next btn b2 next-step  next" style="margin-top: -1px" href="#">Next</a>
<!--            <a href="javascript: confirmPublish();" class="publish_btn active" id="publish_btn_pending" ><span>Published for future date</span></a>-->

            <a href="javascript: confirmPublish();" class="publish_btn" id="publish_btn" ><span>Published</span></a>
            <a href="javascript: saveNewAssigment('save',1);" id="saveBT save" class="red_btn" style="margin-left: 0px;">SAVE</a>
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
