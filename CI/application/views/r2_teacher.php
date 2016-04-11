<style type="text/css">
    .info_row{ border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;}
    .info_title{ min-width:130px; width: 30%; padding: 10px 0px 17px 0px; float: left; font-size:14px; color: black; font-weight: bold;}
    .info_description{ min-width:130px; width: 70%; padding: 10px 0px 17px 0px; float: left; color:#777; font-size:14px; }
</style>
 
<div class="blue_gradient_bg" xmlns="http://www.w3.org/1999/html">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <h2>Assessment Reports</h2>
        <p style="color: #888; padding: 0;"><i style="" class="fa fa-info-circle"></i> Please use the filters below to find the assessments you are looking for.</p>
        <form id="form_search" method="post" action="" name="">
        <div class="row report_filters">
            <div id="condition_0" class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%; margin-bottom: 5px;">
                <div class="f_gray" style="float:left;width: 14%; background: #ddd; height: 45px; margin-right: 1%;">&nbsp;</div>
                <div class="f1 f_gray" style="float:left;width: 30%; margin-right: 1%;">
                    <select class="subject_select" name="conditions[0][field]">
                        <option value="action_date" >From date</option>
                        <option value="action_date" >To date</option>
                        <option value="" >Year</option>
                        <option value="" >Subject</option>
                        <option value="" >Class</option>
                        <option value="student_id" >Student</option>
                        <option value="lesson_id" >Assessment</option>
                        <option value="resource_id" >Assessment Question</option>
                        <option value="behavior" >Independent Study</option>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 24%; margin-right: 1%;">
                    <select class="subject_year_select" name="conditions[0][operation]">
                        <option value="greater_than" >Is Greater Than</option>
                        <option value="lower_than" >Is Lower Than</option>
                        <option value="equal" >Is Equal To</option>
                        <option value="like" >Is Like</option>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 29%;">
                    <input class="datepicker" type="text" name="conditions[0][value]" value="" style="padding: 8px 10px;" />
<!--                      <option value="" ></option>
                        <option value="" ></option>
                    </select>-->
                </div>
            </div>
        </div>
        </form>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%; margin-top: 10px;">
                <a class="btn b1 right" href="javascript: searchAssessments();" style="margin-left: 1%; padding-right: 25px;">SEARCH<span class="glyphicon glyphicon-search" style="float: right;top:0px;left:10px"></span></a>
                <a class="btn b1 right" href="javascript: addCondition();">ADD CONDITION<span class="icon i3"></span></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="count_drafted_title" style="padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;">Results</h3>
<!--                <div class="up_down count_drafted_img" style="cursor:pointer;{if count_drafted == 0}background-image:none;{/if}"><span class="count_lessons count_drafted count_drafted_title" style="{if count_drafted == 0}color:#aaa;{/if}">({count_drafted})</span></div>-->
                <div class="collapsed {if count_drafted == 0} hidden{/if}" id="count_drafted">
                    <table class="table2">
                        <thead>
                            <tr>
                                <td>Assignment</td>
                                <td>Subject</td>
                                <td>Set by</td>
                                <td>Due Date</td>
                                <td>Submitted</td>
                                <td>Marked</td>
                                <td>Copy</td>
                                <td>Delete</td>
                            </tr>
                        </thead>
                        <tbody class="drafted">
                            <?php if( $drafted ): ?>
                            <?php foreach( $drafted as $item ): ?>
                            <tr>
                                <td><a class="info" rel="" onclick="showInfo(<?php echo $item['id'] ?>)" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a><a href="/f2c_teacher/index/<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></td>
                                <td><?php echo $item['subject_name'] ?> - <?php echo $item['classes'] ?></td>
                                <td><?php echo $item['set_by'] ?></td>
                                <td><span class="icon calendar grey"></span><span><?php echo $item['date'] ?></span></td>
                                <?php if ( $item['grade_type'] == "offline" ): ?>
                                <td>N/A</td>
                                <td>N/A</td>
                                <?php else: ?>
                                <td><?php echo $item['submitted'] ?>/<?php echo $item['total'] ?></td>
                                <td><?php echo $item['marked'] ?>/<?php echo $item['total'] ?></td>
                                <?php endif ?>
                                <td style="text-align: center;">
                                    <a title="Copy Homework for another Class" style="color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $item['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-copy"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;" class="assignm_<?php echo $item['id'] ?>">
                                    <a style="color: #333333;" class="copy" href="javascript: delRequest('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','count_drafted');">
                                        <i style="font-size:24px" class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
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
<!--<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
<script type="text/javascript">
    $(function(){
        pretySelect();
        setDatepicker();
/*        var f1_teacher_id = '{f1_teacher_id}';
        var f1_subject_id = '{f1_subject_id}';
        var f1_year = '{f1_year}';
        var f1_class_id = '{f1_class_id}';
        var f1_status = '{f1_status}';
        var f1_type = '{f1_type}';*/
    })

    function searchAssessments() {
        form = $('#form_search');
//console.log(form_id);

        post_data = form.serialize();

        $.post( "/r2_teacher/searchAssessments", { post_data: post_data}, function( data ) {
//console.log(trh);
        });
    }


</script>
<!--You love every second of your live. Exactly as it is. Thrilling!
Just do it, that's all. It is easy.-->