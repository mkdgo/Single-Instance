<style type="text/css">
    .info_row{ border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;}
    .info_title{ min-width:130px; width: 30%; padding: 10px 0px 17px 0px; float: left; font-size:14px; color: black; font-weight: bold;}
    .info_description{ min-width:130px; width: 70%; padding: 10px 0px 17px 0px; float: left; color:#777; font-size:14px; }
    table.assesment_result { width: 100%; border: 1px solid #ccc; background: #e0e0e0; }
    table.assesment_result .question{ width: 100%; border: 1px solid #ccc; background: #fff; padding: 10px; float: left; }
    table.assesment_result .student{ width: 100%; border: 1px solid #ccc; background: #fff; padding: 10px; float: left; }
    table.assesment_result .marks{ width: 100%; border: 1px solid #ccc; background: rgb(145, 208, 80); padding: 10px; float: left; }

    table.assesment_result .score1{ width: 100%; border: 1px solid #ccc; background: #f00; padding: 10px; float: left; }
    table.assesment_result .score2{ width: 100%; border: 1px solid #ccc; background: rgb(255, 192, 0); padding: 10px; float: left; }
    table.assesment_result .score3{ width: 100%; border: 1px solid #ccc; background: rgb(145, 208, 80); padding: 10px; float: left; }
    table.assesment_result .score4{ width: 100%; border: 1px solid #ccc; background: rgb(0, 175, 80); padding: 10px; float: left; }
</style>
 
<div class="blue_gradient_bg" xmlns="http://www.w3.org/1999/html">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <h2>Assessment Reports</h2>
        <p style="color: #888; padding: 0;"><i style="" class="fa fa-info-circle"></i> Please use the filters below to find the assessments you are looking for.</p>
        <form id="form_search" method="post" action="" name="">
        <input id="base_assignment_id" type="hidden" name="base_assignment_id" value="" />
        <input id="selected_class_id" type="hidden" name="selected_class_id" value="" />
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%">
                <div class="f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Teacher</label>
                    <input type="hidden" name="conditions[4][field]" value="teacher_id" />
                    <select class="teacher_select" name="conditions[4][value]">
                        <option value="<?php  echo $this->session->userdata('id')?>" <?php if( $r2_teacher_id == $this->session->userdata('id') ) echo 'selected="selected"'; ?>>Me (<?php  echo $this->session->userdata('last_name')?>, <?php  echo $this->session->userdata('first_name')?>)</option>
                        <option value="all" <?php if( $r2_teacher_id == 'all' ) echo 'selected="selected"'; ?> >All</option>
                        <?php if( $teachers ): ?>
                        <?php foreach( $teachers as $t ): ?>
                        <option value="<?php echo $t['id']?>" <?php if( $r2_teacher_id == $t['id'] ) echo 'selected="selected"'; ?> ><?php echo $t['teacher_name']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Subject</label>
                    <input type="hidden" name="conditions[3][field]" value="subject_id" />
                    <select class="subject_select" name="conditions[3][value]">
                        <option value="all" <?php if( $r2_subject_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $subjects ): ?>
                        <?php foreach( $subjects as $sub ): ?>
                        <option value="<?php echo $sub['id']?>" <?php if( $r2_subject_id == $sub['id'] ) echo 'selected="selected"'; ?>><?php echo $sub['name']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Year</label>
                    <input type="hidden" name="conditions[2][field]" value="year" />
                    <select class="subject_year_select" name="conditions[2][value]">
                        <option value="all" <?php if( $r2_year == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $subjects_years ): ?>
                        <?php foreach( $subjects_years as $sub_year ): ?>
                        <option value="<?php echo $sub_year['id']?>" <?php if( $r2_year == $sub_year['id'] ) echo 'selected="selected"'; ?>><?php echo $sub_year['year']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Class</label>
                    <input type="hidden" name="conditions[1][field]" value="class_id" />
                    <select class="class_select" name="conditions[1][value]">
                      <option value="all" <?php if( $r2_class_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $classes ): ?>
                        <?php foreach( $classes as $class ): ?>
                        <option value="<?php echo $class['id']?>" <?php if( $r2_class_id == $class['id'] ) echo 'selected="selected"'; ?>><?php echo $class['text']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="margin-left:0px;">
                <div class="f1 f_gray" style="float:left;width: 100%;">
                    <label>Assessment</label>
                    <input type="hidden" name="conditions[0][field]" value="lesson_id" />
                    <select class="assignment_select" name="conditions[0][value]">
                      <option value="all" ></option>
                        <?php if( $assignments ): ?>
                        <?php foreach( $assignments as $assignment ): ?>
                        <option value="<?php echo $assignment['id']?>"><?php echo $assignment['name']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="margin-left:0px; margin-top: 10px;">
                <label style="width: 100%;">&nbsp;</label>
                <a class="btn b1 right" href="javascript: searchAssessments();" style="padding-right: 25px;">VIEW REPORT<span class="glyphicon glyphicon-search" style="float: right;top:0px;left:10px"></span></a>
            </div>
        </div>
        </form>
        <div class="row" style="margin-top: 50px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="count_drafted_title" style="padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Results</h3>

                <div class="collapsed {if count_drafted == 0} hidden{/if}" id="assesment_results">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
<!--        <div class="right"><a href="/f2c_teacher" style="margin: 12px 30px 0 20px;" class="red_btn">SET HOMEWORK ASSIGNMENT</a></div>-->
    </div>
</footer>

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
                <button id="popupDel"  type="button"  class="btn orange_btn">CONFIRM</button>
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
<div id="infoModal" class="modal fade" style="top: 10%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2"><a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a></div>
            <div class="feedback-modal-header"><h4 class="modal-title">Assignment Details</h4></div>
            <div class="feedback-modal-body">
                <h5 class="ajax-error text-error" style="display: none;">An error occurred while trying to get details.</h5>
            </div>
            <div id="feedback_details" style="margin: 0 auto; display: block; padding: 0 15px;">
                <div class="info_row">
                    <div class="info_title">Title: </div>
                    <div class="info_description title_info"></div>
                </div>
                <div class="info_row">
                    <div class="info_title">Set by: </div>
                    <div class="info_description set_by_info"></div>
                </div>
                <div class="info_row">
                    <div class="info_title">Description: </div>
                    <div class="info_description intro_info"></div>
                </div>
                <div class="info_row">
                    <div class="info_title">Deadline: </div>
                    <div class="info_description deadline_info"></div>
                </div>
                <div class="info_row">
                    <div class="info_title">Resources: </div>
                    <div class="info_description resources_info"></div>
                </div>
<!--                                    <div class="info_row">
                                        <div class="info_title">Assigned to: </div>
                                        <div class="info_description assignment_to_info"></div>
                                    </div>
                                    <div class="info_row">
                                        <div class="info_title">Publish Date: </div>
                                        <div class="info_description publish_info"></div>
                                    </div>
                                    <div class="info_row">
                                        <div class="info_title">Marks Given As: </div>
                                        <div class="info_description grade_type_info"></div>
                                    </div>
                                    <div class="info_row">
                                        <div class="info_title">Submitted: </div>
                                        <div class="info_description submitted_info"></div>
                                    </div>
                                    <div class="info_row">
                                        <div class="info_title">Marked: </div>
                                        <div class="info_description marked_info"></div>
                                    </div>
                                    <div class="info_row">
                                        <div class="info_title">Status: </div>
                                        <div class="info_description status_info"></div>
                                    </div>-->
            </div>
            <div class="feedback-modal-footer feedback-buttons">
                <button type="button" class="btn green_btn" id="submit_feedback" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
//        pretySelect();
        setDatepicker();

        var r2_teacher_id = '{r2_teacher_id}';
        var r2_subject_id = '{r2_subject_id}';
        var r2_year = '{r2_year}';
        var r2_class_id = '{r2_class_id}';
        var r2_status = '{r2_status}';
        var r2_type = '{r2_type}';

    })

    function searchAssessments() {
        form = $('#form_search');
        form.find('input[name="base_assignment_id"]').val($('.assignment_select').val());
        form.find('input[name="selected_class_id"]').val($('.class_select').val());
 //console.log(form_id);

        post_data = form.serialize();
console.log(form);

        $.post( "/r2_teacher/searchAssessments", { post_data: post_data}, function( data ) {
//console.log(trh);
            $('#assesment_results').html(data);
        });
    }


</script>
