<div class="blue_gradient_bg" xmlns="http://www.w3.org/1999/html">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <h2>Assessment Reports</h2>
        <p style="color: #888; padding: 0;"><i style="" class="fa fa-info-circle"></i> Please use the filters below to find the assessments you are looking for.</p>
        <form id="form_search" method="post" action="" name="">
            <input id="base_assignment_id" type="hidden" name="base_assignment_id" value="" />
            <input id="selected_class_id" type="hidden" name="selected_class_id" value="" />
            <input id="selected_behavior" type="hidden" name="behavior" value="" />
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%">
                    <div class="f1 f_gray" style="float:left;width: 14%;margin-right: 1%;">
                        <label>Assessment Type</label>
                        <input type="hidden" name="conditions[5][field]" value="behavior" />
                        <select class="behavior_select" name="conditions[5][value]">
                            <?php if( $behavior ): ?>
                            <?php foreach( $behavior as $beh ): ?>
                            <option value="<?php echo $beh['id']?>" <?php if( $r2_behavior == $beh['id'] ) echo 'selected="selected"'; ?>><?php echo $beh['name']?></option>
                            <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="f_gray" style="float:left;width: 24%;margin-right: 1%; display: none;">
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
                            <?php if( $subjects ): ?>
                            <option value="all" <?php if( $r2_subject_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                            <?php foreach( $subjects as $sub ): ?>
                            <option value="<?php echo $sub['id']?>" <?php if( $r2_subject_id == $sub['id'] ) echo 'selected="selected"'; ?>><?php echo $sub['name']?></option>
                            <?php endforeach ?>
                            <?php else: ?>
                            <option value="all">No data</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="f1 f_gray" style="float:left;width: 24%;margin-right: 1%;">
                        <label>Year</label>
                        <input type="hidden" name="conditions[2][field]" value="year" />
                        <select class="subject_year_select" name="conditions[2][value]">
                            <?php if( $subjects_years ): ?>
                            <option value="all" <?php if( $r2_year == 'all' ) echo 'selected="selected"'; ?>>All</option>
                            <?php foreach( $subjects_years as $sub_year ): ?>
                            <option value="<?php echo $sub_year['id']?>" <?php if( $r2_year == $sub_year['id'] ) echo 'selected="selected"'; ?>><?php echo $sub_year['year']?></option>
                            <?php endforeach ?>
                            <?php else: ?>
                            <option value="all">No data</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="f1 f_gray" style="float:left;width: 24%;margin-right: 1%; display: none;">
                        <label>Class</label>
                        <input type="hidden" name="conditions[1][field]" value="class_id" />
                        <select class="class_select" name="conditions[1][value]">
                            <?php if( $classes ): ?>
                            <option value="all" <?php if( $r2_class_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                            <?php foreach( $classes as $class ): ?>
                            <option value="<?php echo $class['id']?>" <?php if( $r2_class_id == $class['id'] ) echo 'selected="selected"'; ?>><?php echo $class['text']?></option>
                            <?php endforeach ?>
                            <?php else: ?>
                            <option value="all">No data</option>
                            <?php endif ?>
                        </select>
                    </div>
                    <div class="f1 f_gray" style="float:left;width: 35%;">
                        <label>Assessment</label>
                        <input type="hidden" name="conditions[0][field]" value="lesson_id" />
                        <select class="assignment_select" name="conditions[0][value]">
                            <?php if( $assignments ): ?>
                            <option value="all" ></option>
                            <?php foreach( $assignments as $assignment ): ?>
                            <option value="<?php echo $assignment['id']?>" <?php if( $r2_assignment_id == $assignment['id'] ) echo 'selected="selected"'; ?>><?php echo $assignment['name']?></option>
                            <?php endforeach ?>
                            <?php else: ?>
                            <option value="all">No data</option>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="margin-left:0px;"></div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="margin-left:0px; margin-top: 10px;">
                    <a class="btn b1 right" href="javascript: searchAssessments();" style="padding-right: 25px;"><span style="float: left;">VIEW REPORT</span><span class="glyphicon glyphicon-search" style="float: right;top:0px;left:10px"></span></a>
                </div>
            </div>
        </form>
        <div class="row" style="margin-top: 50px;">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="count_drafted_title" style="padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Results</h3>
                <div class="collapsed {if count_drafted == 0} hidden{/if}" id="assesment_results"></div>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
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
<div id="popupError" class="modal fade">
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
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CLOSE</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
        var r2_behavior = '{r2_behavior}';

        if( $('.assignment_select').val() != 'all' ) {
            searchAssessments();
        }
    })

    function searchAssessments() {
        if( $('.assignment_select option:selected').val() == 'all' ) {
            $('.modal-body').html('<p style="display: inline-block; line-height: 1.5; margin: 20px; background: #fff; text-align: left; padding: 20px;">Chose Assessment to view report!</p>');
            $('#popupError').modal('show');
            $('.assignment_select').focus();
            return false;
        }
        form = $('#form_search');
        form.find('input[name="base_assignment_id"]').val($('.assignment_select').val());
        form.find('input[name="selected_class_id"]').val($('.class_select').val());
        form.find('input[name="behavior"]').val($('.behavior_select').val());

        post_data = form.serialize();
        $.post( "/r2_teacher/searchAssessments", { post_data: post_data}, function( data ) {
            $('#assesment_results').html(data);
            $('[data-toggle="tooltip"]').tooltip({
                content: function () {
                    return $(this).prop('title');
                },
                position: { my: "left+5 bottom", at: "left+5 top" }
            });
        });
    }

    function clearForm(id) {
        $('#form_b'+id).find('input').attr('disabled',true);
        $('#form_b'+id).find('input').attr('checked',false);
        $('#form_b'+id).find('input[type=text]').val('');
        $('#form_b'+id).find('label').removeClass('choice-true');

        $('#form_b'+id).find('.ans').attr('onclick','');
        $('#form_b'+id).find('.ans').removeClass('choice-true');
        $('#form_b'+id).find('.ans').removeClass('choice-correct-mark');
        $('#form_b'+id).find('.ans').removeClass('choice-wrong');
        $('#form_b'+id).find('.ans').removeClass('choice-wrong-mark');

        $('#form_b'+id).find('.choice-correct-radio-value').remove();
        $('#form_b'+id).find('.choice-wrong-radio-value').remove();
        $('#form_b'+id).find('.choice-correct-value').remove();
        $('#form_b'+id).find('.choice-wrong-value').remove();
        $('#form_b'+id).find('.choice-correct-mark-value').remove();
        $('#form_b'+id).find('.choice-wrong-mark-value').remove();
        $('#form_b'+id).find('.choice-correct-fill-value').remove();
        $('#form_b'+id).find('.choice-wrong-fill-value').remove();
        $('#form_b'+id).find('label.choice-correct-radio').attr('class', '');
        $('#form_b'+id).find('label.choice-wrong-radio').attr('class', '');
        $('#form_b'+id).find('input.choice-wrong').attr('class', '');
        $('#form_b'+id).find('input.choice-wrong-fill').attr('class', '');
        $('#form_b'+id).find('input.choice-true').attr('class', '');
        $('#form_b'+id).find('input.choice-correct').attr('class', '');
        $('#form_b'+id).find('input.choice-correct-fill').attr('class', '');
        $('.tbl_b'+id).html('');
    }

    function openForm(id, st_id) {
        setResult(id, st_id);
        $('#'+id).click();
    }

    function setResult(res_id, stud_id) {
        $.get( "/r2_teacher/getStudentAnswers", { lesson_id: $('.assignment_select option:selected').val(), resource_id: res_id, student_id: stud_id, behavior: $('.behavior_select option:selected').val() }, function( data ) {
            switch(data.type) {
                case 'single_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'multiple_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#i_'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'fill_in_the_blank':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i].key).val(data.answers[i].val);
                    }
                    break;
                case 'mark_the_words':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#q'+res_id+data.answers[i]).css('background', '#53EEEB');
                    }
                    break;
            }
            $.each(data.html.answers,function(key,val){
                $('#'+key).addClass(val.class);
                if(val.value) {
                    $('#'+key).after('<span class="'+val.class+'-value">'+val.value+'</span>');
                }
            })

            $('.tbl_'+res_id).html(data.html.html);
        },'json');
    }

</script>
