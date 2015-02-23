<link rel="stylesheet" href="<?=base_url("/js/slider/style.css")?>" type="text/css"/>
<script src="<?=base_url("/js/slider/jquery.noos.slider.js")?>"></script>
 
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style type="text/css">
    .row { margin-right: 0px; margin-left: 0px; }
</style>
<script>
    loadTinymceSlider();
    
    var classes_years_json = {classes_years_json};
    var selected_classes = "{class_id}";
    var selected_classes_data = selected_classes.split(',');
    var assignment_categories_json = {assignment_categories_json};
    var assignment_attributes_json = {assignment_attributes_json};
    var assignment_id = {assignment_id};
    var mode = "{mode}";
    var published = "{publish}";
    var datepast = "{datepast}";

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
</script>
<script src="<?php echo base_url("/js/f2b_teacher.js")?>"></script>

<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>

<div class="blue_gradient_bg">
    <div class="container">
        <h2>Homework</h2>
        <?php if( $mode != 1 ): ?> 
        <table width="100%" cellpadding="20">
            <tr>
                <td width="60%" valign="top">
        <?php endif; ?>
                    <form action="" class="big_label" id="form_assignment">
                        <div class="slider">
                            <ul class="slides">
                                <li>
                                    <article class="step s1">
                                        <div class="buttons clearfix"><a class="btn b2 right next-step nav next" href="#">Next</a></div>
                                        <header>
                                            <h3>1. Assignment Description &amp; Accompanying Resources</h3>
                                            <div>Step 1 of 3</div>
                                        </header>
                                        <div class="row">
                                            <div id="step_1_1" class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <label for="assignment_title">Assignment Title</label>
                                                <div class="controls">
                                                    <span></span>
                                                    <input type="text" value="{assignment_title}" name="assignment_title" class="required" data-validation-required-message="Please provide a title for this assignment" id="assignment_title">
                                                </div>
                                                <label for="assignment_intro">Assignment Summary</label>
                                                <div class="controls">
                                                    <span></span>
                                                    <textarea name="assignment_intro" id="assignment_intro" class="textarea_fixed mce-toolbar-grp  resizable" minlength="30" >{assignment_intro}</textarea>
                                                </div>
                                                <label for="grade_type">Grade type</label>
                                                <select onChange="gradeTypeChange()" name="grade_type" id="grade_type" data-mini="true">
                                                    <option value="percentage" {selected_grade_type_pers}>{label_grade_type_percentage}</option>
                                                    <option value="mark_out_of_10" {selected_grade_type_mark_out}>Mark out of 10</option>
                                                    <option value="grade" {selected_grade_type_grade}>{label_grade_type_grade}</option>
                                                    <option value="free_text" {selected_grade_type_free_text}>{label_grade_type_free_text}</option>
                                                </select>
                                            </div>
                                            <div id="step_1_2" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-12">
                                                <h3>Resources</h3>
                                                <ul class="ul1 resources">
                                                    {resources}
                                                    <li id="res_{resource_id}">
                                                        <div class="i"><span class="icon img"></span></div>
                                                        <div class="r"><a href="javascript: publishModal({resource_id})" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a></div>
                                                        <div class="t">{resource_name}</div>
                                                    </li>
                                                    {/resources}
                                                </ul>
                                                <div class="buttons clearfix">
                                                    <a class="btn b1 right" href="javascript: saveAndAddResource();">ADD<span class="icon i3"></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                <li>
                                    <article class="step s2">
                                        <div class="buttons clearfix">
                                            <a class="btn b2 left prev-step nav prev" href="#">Previous</a>
                                            <a class="btn b2 right next-step nav next" href="#">Next</a>
                                        </div>
                                        <header>
                                            <h3>2. Mark Categories &amp; Grade Thresholds</h3>
                                            <div>Step 2 of 3</div>
                                        </header>
                                        <div class="row">
                                            <div id="step_2_1"  class="col-lg-7 col-md-7 col-sm-7 col-xs-12" style="padding-bottom: 10px;">
                                                <h3>Mark Categories</h3>
                                                <div style="padding: 0 15px; background: #f5f5f5;">
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td width="45%"><label>Category</label></td>
                                                            <td width="45%"><label>Marks Available</label></td>
                                                            <td width="10%"></td>
                                                        </tr>
                                                    </table>
                                                    <table style="background: #f5f5f5;" id="grade_categories_holder" class="table3 w2">
                                                        <tr id="grade_categories_row">
                                                            <td>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="category" value="" id="catg"  data-validation-required-message="Please select the marking method for this assignment">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="controls">
                                                                    <span></span>
                                                                    <input type="text" name="mark" value="" id="mark"  data-validation-required-message="Please provide at least one marking category for this assignment">
                                                                </div>
                                                                <a style="margin-top: 5px; float: right;" class="btn b1 right" href="javascript: addCategory();">ADD<span class="icon i3"></span></a>
                                                                <a style="margin-top: 5px; float: right; margin-right: 10px;" href="javascript: preRemoveCategoryField();">Cancel</a>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:;" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td width="45%"><h3 id="marksTotal"></h3></td>
                                                            <td width="45%">
                                                                <a id="add_cat_link" style="margin-bottom: 0px; float: right;" href="javascript: addCategoryField();">+ Add New Category</a>
                                                            </td>
                                                            <td width="10%"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div id="step_2_2" is_visible="y"  class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-12">
                                                <h3>Grade Thresholds</h3>
                                                <div style="padding: 0 15px; background: #f5f5f5;">
                                                    <table style="background: #f5f5f5;" class="table3 w2">
                                                        <tr>
                                                            <td><label>Name</label></td>
                                                            <td><label>Value</label></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>       
                                                    <table style="background: #f5f5f5;" id="grade_attr_holder" class="table3 w2">
                                                        <tr id="grade_attr_row">
                                                            <td><input type="text" name="grade_attribute_name" value=""></td>
                                                            <td><input type="text" name="grade_attribute_value" value=""></td>
                                                            <td><a href="javascript:;" class="btn remove add_attr"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                        </tr>
                                                    </table>        
                                                    <table class="table3 w2">
                                                        <tr>
                                                            <td></td>
                                                            <td><a class="btn b1 right add_attr" href="javascript: addAttribute();">ADD<span class="icon i3"></span></a></td>
                                                            <td></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                <li>
                                    <article class="step s3">
                                        <div class="buttons clearfix">
                                            <a class="btn b2 left prev-step nav prev" href="#">Previous</a>
                                        </div>
                                        <header>
                                            <h3>3. Assignment &amp; Deadlines</h3>
                                            <div>Step 3 of 3</div>
                                        </header>
                                        <div class="row">
                                            <div id="step_3_1" class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                                <label for="">Assign to</label>
                                                <div class="controls">
                                                    <span></span>
                                                    <select onChange="Y_changed();" name="classes_year_select" id="classes_year_select" data-validation-required-message="Please select an academic year to assign to">
                                                        <option class="classes_select_option" value="-1"/>
                                                    </select>
                                                </div>
                                                <label for="">Subject</label>
                                                <div class="controls">
                                                    <span></span>
                                                    <select onChange="S_changed();" name="classes_subject_select" id="classes_subject_select" data-validation-required-message="Please select a subject group to assign to">
                                                    </select>
                                                </div>
                                                <label for="">Deadline Date</label>
                                                <div class="field date">
                                                    <span class="icon show_picker"></span>
                                                    <div class="controls">
                                                        <span></span>
                                                        <div class="fc">
                                                            <input type="text" value="{assignment_date}" name="deadline_date" id="deadline_date" class="datepicker" data-validation-required-message="Please select a date for the submission deadline">
                                                        </div>
                                                    </div>
                                                </div>
                                                <label for="">Deadline Time</label>
                                                <div class="field time">
                                                    <div class="icon" >
                                                        <span class="u"></span>
                                                        <span class="b"></span>
                                                    </div>
                                                    <div class="controls">
                                                        <span></span>
                                                        <div class="fc">
                                                            <input type="text" value="<?php if($assignment_time==''){echo'00:00';}else{?>{assignment_time}<?php } ?>" name="deadline_time" id="deadline_time" class="" maxlength="5" data-validation-required-message="Please set a time of day for the submission deadline">
                                                        </div>
                                                    </div>
                                                </div>
                                                <br />
                                            </div>
                                            <div id="step_3_2" class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-12">
                                                <div id="step_3_1_ax" class="checkbox_fw" style="width: 100%;float: left;">
                                                    <label>Assign to classes</label>
                                                    <table class="table4" style="margin: 0;">
                                                        <tr>
                                                            <td style="width: 100%;" id="classes_holder">
                                                                <div style="width: 100%; margin-top: 2px;" class="classes_holder_row">
                                                                    <input type="checkbox" name="classes[]" value="" id=""><label for=""></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="categories" id="categories" value="">
                        <input type="hidden" name="attributes" id="attributes" value="">
                        <input type="hidden" name="class_id" id="class_id" value="">
                        <input type="hidden" name="publish" id="publish" value="{publish}">
                        <input type="hidden" name="assignment_id" id="assignment_id" value="{assignment_id}">
                        <input type="hidden" name="publishmarks" id="publishmarks" value="{publishmarks}">
                        <input type="hidden" name="server_require_agree" id="server_require_agree" value="0">
                        <input type="hidden" name="has_marks" id="has_marks" value="{has_marks}">
                    </form>
        <?php if( $mode != 1 ): ?>
                </td>
                <td width="40%" valign="top" align="left">
                    <table style="margin-top: 90px;" class="table2_s"  width="100%" cellspacing="0">
                        <tbody> 
                            {student_assignments}
                            <tr>
                                <td ><a href="/f3_teacher/index/{assignment_id}/{id}">{first_name} {last_name}</a></td>
                                <td align="center">{submission_status}</td>
                                <td align="center">{attainment}</td>
                            </tr>
                            {/student_assignments}
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <?php endif; ?>
    </div>
</div>

<div class="clear" style="height: 1px;"></div>

<prefooter>
    <div class="container"></div>
</prefooter>
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: confirmPublishMarks();" class="publish_btn" id="publishmarks_btn" style="display:none"><span>PUBLISH MARKS</span></a>
            <a href="javascript: confirmPublish();" class="publish_btn" id="publish_btn" style="display:none"><span>PUBLISH</span></a>
            <a href="javascript: saveNewAssigment('save');" id="saveBT" class="red_btn">SAVE</a>
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
                <button id="popupPublBT" do="1" type="button" onClick="doPubl()"  class="btn orange_btn">CONFIRM</button>
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
