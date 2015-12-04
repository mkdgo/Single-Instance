<style type="text/css">
/*    .info { display: none; }*/
    .info_row{ border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;}
    .info_title{ min-width:130px; width: 30%; padding: 10px 0px 17px 0px; float: left; font-size:14px; color: black; font-weight: bold;}
    .info_description{ min-width:130px; width: 70%; padding: 10px 0px 17px 0px; float: left; color:#777; font-size:14px; }
</style>
 
<div class="blue_gradient_bg" xmlns="http://www.w3.org/1999/html">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
    <div class="container">
        <h2>Homework Search</h2>
        <div class="row">
            <p style="color: #888; padding: 0 15px;"><i style="" class="fa fa-info-circle"></i> Please use the filters below to find the homework assignment you are looking for.</p>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-left:0px;width: 100%">
                <div class="f_gray" style="float:left;width: 24%;margin-right: 1%;">
                   <label>Teacher</label>
                    <select class="teacher_select">
                        <option value="<?php  echo $this->session->userdata('id')?>" <?php if( $f1_teacher_id == $this->session->userdata('id') ) echo 'selected="selected"'; ?>>Me (<?php  echo $this->session->userdata('last_name')?>, <?php  echo $this->session->userdata('first_name')?>)</option>
                        <option value="all" <?php if( $f1_teacher_id == 'all' ) echo 'selected="selected"'; ?> >All</option>
                        <?php if( $teachers ): ?>
                        <?php foreach( $teachers as $t ): ?>
                        <option value="<?php echo $t['id']?>" <?php if( $f1_teacher_id == $t['id'] ) echo 'selected="selected"'; ?> ><?php echo $t['teacher_name']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class=" f1 f_gray" style="float:left;width: 24%;margin-right: 1%;">
                    <label>Subject</label>
                    <select class="subject_select">
                        <option value="all" <?php if( $f1_subject_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $subjects ): ?>
                        <?php foreach( $subjects as $sub ): ?>
                        <option value="<?php echo $sub['id']?>" <?php if( $f1_subject_id == $sub['id'] ) echo 'selected="selected"'; ?>><?php echo $sub['name']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 16%;margin-right: 1%;">
                    <label>Year</label>
                    <select class="subject_year_select">
                        <option value="all" <?php if( $f1_year == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $subjects_years ): ?>
                        <?php foreach( $subjects_years as $sub_year ): ?>
                        <option value="<?php echo $sub_year['id']?>" <?php if( $f1_year == $sub_year['id'] ) echo 'selected="selected"'; ?>><?php echo $sub_year['year']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 16%;margin-right: 1%;">
                    <label>Class</label>
                    <select class="class_select">
                      <option value="all" <?php if( $f1_class_id == 'all' ) echo 'selected="selected"'; ?>>All</option>
                        <?php if( $classes ): ?>
                        <?php foreach( $classes as $class ): ?>
                        <option value="<?php echo $class['id']?>" <?php if( $f1_class_id == $class['id'] ) echo 'selected="selected"'; ?>><?php echo $class['text']?></option>
                        <?php endforeach ?>
                        <?php endif ?>
                    </select>
                </div>
                <div class="f1 f_gray" style="float:left;width: 16%;">
                    <label>Status</label>
                    <select class="status_select">
                        {status_select_all}
                        {status_pending}
                        {status_assigned}
                        {status_drafted}
                        {status_past}
                        {status_closed}
                    </select>
                </div>
            </div>
            <br />
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title count_drafted_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_drafted == 0}color:#aaa;{/if}">Drafts</h3>
                <div class="up_down count_drafted_img" style="cursor:pointer;{if count_drafted == 0}background-image:none;{/if}"><span class="count_lessons count_drafted count_drafted_title" style="{if count_drafted == 0}color:#aaa;{/if}">({count_drafted})</span></div>
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
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="drafted">
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
                                <td style="text-align: center;" class="assignm_<?php echo $item['id'] ?>">
                                    <a style="display: inline-block;" class="remove" href="javascript: delRequest('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','count_drafted');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a title="Copy Homework for another Class" style="float: right; color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $item['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-clone"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title count_pending_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_pending == 0}color:#aaa;{/if}">Pending Publish</h3>
                <div class="up_down count_pending_img" style="cursor:pointer;{if count_drafted == 0}background-image:none;{/if}"><span class="count_lessons count_pending count_pending_title" style="{if count_pending == 0}color:#aaa;{/if}">({count_pending})</span></div>
                <div class="collapsed {if count_pending == 0} hidden{/if}" id="count_pending">
                    <table class="table2">
                        <thead>
                            <tr>
                                <td>Assignment</td>
                                <td>Subject</td>
                                <td>Set by</td>
                                <td>Due Date</td>
                                <td>Submitted</td>
                                <td>Marked</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="pending">
                            <?php if( count( $pending ) ): ?>
                            <?php foreach( $pending as $pitem ): ?>
                            <tr>
                                <td><a class="info" rel="" onclick="showInfo(<?php echo $item['id'] ?>)" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a><a href="/f2p_teacher/index/<?php echo $pitem['id'] ?>"><?php echo $pitem['name'] ?></a></td>
                                <td><?php echo $pitem['subject_name'] ?> - <?php echo $pitem['classes'] ?></td>
                                <td><?php echo $pitem['set_by'] ?></td>
                                <td><span class="icon calendar grey"></span><span><?php echo $pitem['date'] ?></span></td>
                                <?php if ( $pitem['grade_type'] == "offline" ): ?>
                                <td>N/A</td>
                                <td>N/A</td>
                                <?php else: ?>
                                <td><?php echo $pitem['submitted'] ?>/<?php echo $pitem['total'] ?></td>
                                <td><?php echo $pitem['marked'] ?>/<?php echo $pitem['total'] ?></td>
                                <?php endif ?>
                                <td style="text-align: center;" class="assignm_<?php echo $pitem['id'] ?>">
                                    <a style="display: inline-block;" class="remove" href="javascript: delRequest('<?php echo $pitem['id'] ?>','<?php echo $pitem['name'] ?>','count_pending');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a title="Copy Homework for another Class" style="float: right; color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $pitem['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-clone"></i>
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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title count_assigned_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_assigned == 0}color:#aaa;{/if}">Assigned</h3>
                <div class="up_down count_assigned_img" style="cursor:pointer;{if count_assigned == 0}background-image:none;{/if}"><span class="count_lessons count_assigned count_assigned_title" style="{if count_assigned == 0}color:#aaa;{/if}">({count_assigned})</span></div>
		        <div class="collapsed {if count_assigned == 0} hidden{/if}" id="count_assigned">
                    <table class="table2">
                        <thead>
                            <tr>
                                <td>Assignment</td>
                                <td>Subject</td>
                                <td>Set by</td>
                                <td>Due Date</td>
                                <td>Submitted</td>
                                <td>Marked</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="assigned">
                            <?php foreach( $assigned as $item ): ?>
                            <tr>
                                <td><a class="info" rel="" onclick="showInfo(<?php echo $item['id'] ?>)" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a><a href="/f2b_teacher/edit/<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></td>
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
                                <td style="" class="assignm_<?php echo $item['id'] ?>">
                                    <a style="float: left;" class="remove" href="javascript: delRequest('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','count_assigned');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a title="Copy Homework for another Class" style="float: right; color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $item['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-clone"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row {past_due_date_hidden}">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title count_past_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_past == 0}color:#aaa;{/if}">Past Due Date</h3>
                <div class="up_down count_past_img" style="cursor:pointer;{if count_past == 0}background-image:none;{/if}"><span class="count_lessons count_past count_past_title" style="{if count_past == 0}color:#aaa;{/if}">({count_past})</span></div>
               	<div class="collapsed {if count_past == 0} hidden{/if}" id="count_past">
                    <table class="table2">
                        <thead>
                            <tr>
                                <td>Assignment</td>
                                <td>Subject</td>
                                <td>Set by</td>
                                <td>Due Date</td>
                                <td>Submitted</td>
                                <td>Marked</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="past">
                            <?php foreach( $past as $item ): ?>
                            <tr>
                                <td><a class="info" rel="" onclick="showInfo(<?php echo $item['id'] ?>)" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a><a href="/f2b_teacher/past/<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></td>
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
                                <td style="" class="assignm_<?php echo $item['id'] ?>">
                                    <a style="float: left;" class="remove" href="javascript: delRequest('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','count_past');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a title="Copy Homework for another Class" style="float: right; color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $item['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-clone"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3 class="acc_title count_closed_title" style="cursor:pointer;padding-left: 0px;padding-bottom:15px;border-bottom: 1px solid #ccc;{if count_closed == 0}color:#aaa;{/if}">Closed</h3>
                <div class="up_down count_closed_img" style="cursor:pointer;{if count_closed == 0}background-image:none;{/if}"><span class="count_lessons count_closed count_closed_title" style="{if count_closed == 0}color:#aaa;{/if}">({count_closed})</span></div>
                <div class="collapsed {if count_closed == 0} hidden{/if}" id="count_closed">
                    <table class="table2">
                        <thead>
                            <tr>
                                <td>Assignment</td>
                                <td>Subject</td>
                                <td>Set by</td>
                                <td>Due Date</td>
                                <td>Submitted</td>
                                <td>Marked</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="closed">
                            <?php foreach( $closed as $item ): ?>
                            <tr>
                                <td><a class="info" rel="" onclick="showInfo(<?php echo $item['id'] ?>)" style="margin-right: 5px; color:#e74c3c; cursor: pointer;" title="Show details" ><i class="fa fa-info-circle"></i></a><a href="/f2d_teacher/index/<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></td>
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
                                <td style="" class="assignm_<?php echo $item['id'] ?>">
                                    <a style="float: left;" class="remove" href="javascript: delRequest('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','count_closed');">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                    <a title="Copy Homework for another Class" style="float: right; color: #333333;" class="copy" href="javascript: copyAssignment('<?php echo $item['id'] ?>');">
                                        <i style="font-size:24px" class="fa fa-clone"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach ?>
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
<script type="text/javascript">
    $(function(){
        var f1_teacher_id = '{f1_teacher_id}';
        var f1_subject_id = '{f1_subject_id}';
        var f1_year = '{f1_year}';
        var f1_class_id = '{f1_class_id}';
        var f1_status = '{f1_status}';
        var f1_type = '{f1_type}';
/*
        $('#infoModal').on('show.bs.modal', function (e) {
            $('.feedback-modal-body .no-error').hide();
//            $('.feedback-modal-body .ajax-error').hide();
            $('.feedback-modal-body .feedback-error').hide();
            $('.feedback-confirmation').hide();
            $('.feedback-pending').hide();
            $('.feedback-buttons').show();
        });
//*/
    })
</script>
<script src="<?php echo base_url().'js/f1_teacher.js'?>" type="text/javascript"></script>
