<style type="text/css">
    .attained_marks {
        margin-left: 10px;
        display: none;
    }
    .attained {
        float: right;
        font-weight: bold;
        height: 40px;
/*        background-color: #99ff99;*/
        width: 40px;
        text-align: center;
        line-height: 40px;
        border-radius: 40px;
        border: 1px solid #333;
        margin-top: -10px;
    }
</style>

<div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
<div  class="blue_gradient_bg">
    <div class="container">
        <h2>{title}</h2>
<?php if( $grade_type == 'test' ): ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px;">
                <ul class="slides" style="width: 100%; padding-left: 0px;">
                    <li style="margin:10px 15px 0 0;list-style:none;">
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                            <h3 class="" style="padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Homework Description</h3>
                            <div class="" style="float:right;background-size: 70%;margin-top:-36px; background-position: 0px -30px;"></div>
                            <div class="assignment" style="margin:0px auto;">
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="padding: 10px 0px 17px 0px;font-weight: normal; float: left;">{intro}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Set by: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{set_by}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Date: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_date}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Time: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_time}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Marks Given As: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{grade_type_label}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                {if resources}
                <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                    <h3 class="" style="padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                    <div class="" style="float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                    <div class="collapsed resources-student" style="margin:0px auto; display: block;">
                        <ul class="ul1 hw_resources">
                            <?php foreach( $resources as $res ): ?> 
                            <li id="li<?php echo $res['resource_id'] ?>" <?php echo $res['li_style'] ?>>
                                <a href="javascript:;" style="background: none;color:#e74c3c;padding-top: 4px;" onclick="$(this).next().children().click()">
                                    <span class="icon <?php echo $res['type']; ?>" style="margin-top: -2px;color: #c8c8c8"> </span> <?php echo $res['resource_name']; ?>
                                </a>
                                <span class="show_resource" style="display:none;"><?php echo $res['preview']; ?></span>
<!--                                <span class="attained_marks"><?php echo $res['attained']; ?>/<?php echo $res['marks_available']; ?></span>-->
<?php if( $marked ): ?>
                                <span class="act<?php echo $res['resource_id'] ?> attained" style=" <?php echo $res['styled']; ?>"> <?php echo $res['required']; ?> </span>
<?php else: ?>
                                <span class="act<?php echo $res['resource_id'] ?> " style="float: right;"> <?php echo $res['required']; ?> </span>
<?php endif ?>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <form id="save_assignment" class="form-horizontal" enctype="multipart/form-data" method="post" action="/f2_student/save">
            <input type="hidden" name="publish" id="publish" value="0">    
            <input type="hidden" name="assignment_id" value="{assignment_id}" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
<?php elseif( $grade_type != 'offline' ): ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px;">
                <ul class="slides" style="width: 100%; padding-left: 0px;">
                    <li style="margin:10px 15px 0 0;list-style:none;">
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                            <h3 class="up_down___" style="cursor:pointer;padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Homework Description</h3>
                            <div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;margin-top:-36px; background-position: 0px -30px;"></div>
                            <div class="collapsed assignment" style="margin:0px auto;">
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="padding: 10px 0px 17px 0px;font-weight: normal; float: left;">{intro}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Set by: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{set_by}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Date: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_date}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Time: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_time}</div>
                                </div>
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Marks Given As: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{grade_type_label}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    {if resources}
                    <li style="margin:0px 15px 0 0;list-style:none;">
                            <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                                <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                                <div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                                <div class="collapsed " style="margin:0px auto;">
                                    <ul class="ul1 hw_resources">
                                        <?php foreach( $resources as $res ): ?> 
                                        <li>
                                            <a href="javascript:;" style="background: none;border-bottom:1px solid #c8c8c8;color:#111;padding-top: 4px;" onclick="$(this).next().children().click()">
                                                <span class="icon <?php echo $res['type']; ?>" style="margin-top: -2px;color: #c8c8c8"> </span> <?php echo $res['resource_name']; ?> 
                                            </a>
                                            <span class="show_resource" style="display:none;"><?php echo $res['preview']; ?></span>
                                        </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    {/if}
                    {if assignment_categories1 }
                    <li style="margin:0px 15px 0 0;list-style:none;">
                        <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                            <h3 class="up_down___" style="cursor:pointer;padding-bottom: 6px; height:26px;overflow: hidden; border-bottom:1px solid #c8c8c8;font-weight: bold;margin-top: 14px;">Mark Allocation</h3><div class="up_down_homework" style="cursor:pointer;float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                            <div class="collapsed" style="margin:0px auto;">
                                {assignment_categories1}
                                <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                    <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">{category_name}: </div>
                                    <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{category_marks}</div>
                                </div>
                                {/assignment_categories1}
                            </div>
                        </div>
                    </li>
                    {/if}
                </ul>
            </div>
            <form id="save_assignment" class="form-horizontal" enctype="multipart/form-data" method="post" action="/f2_student/save">
                <input type="hidden" name="publish" id="publish" value="0">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-right: 0px;">
                    <?php if( $marked == 1 || $publish_marks == 1 ): ?>
                    <h3 style="padding-left: 10px;">Submission Notes</h3>
                    <div style="margin-left: 10px;" class="block-grey">{submission_info_isempty}</div>
                    <div style="margin-top: 10px;" class="lessons_box">
                        <h3>My Submissions</h3>
                        <div style="display: <?php echo $list_hidden ?>;" >
                            <?php if (sizeof(assignment_categories2) > 0): ?>
                            <div class="clearfix btns-selected els2">
                                        <a class="sel_a {selected_link_a}" onclick=" $('.sel_b').removeClass('sel');$('.sel_a').addClass('sel');$('.table6').hide();$('.table5').show();">Marks per Uploaded File</a>
                                        <a class="sel_b {selected_link_b}" onclick=" $('.sel_a').removeClass('sel');$('.sel_b').addClass('sel');$('.table5').hide();$('.table6').show();">Marks By Category</a>
                                    </div>
                            <?php endif ?>
                            <div  class="clearfix block-grey">
                                        <table class="table5">
                                            <?php foreach( $student_resources as $sres ): ?> 
                                            <tr>
                                                <td><i class="icon img" style="margin-top:-15px;"></i></td>
                                                <td colspan="2"><?php if( strlen( $sres['resource_name'] ) < 20 ) echo $sres['resource_name']; else echo substr( $sres['resource_name'],0,19 ).'...' ?>
                                                    <div style="background<?php echo $sres['is_late_hide']; ?>: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;"></div>
                                                </td>
                                                <?php if (sizeof(assignment_categories2) > 0): ?>
                                                <td><span><?php echo $sres['marks_total']; ?></span></td>
                                                <?php endif ?>
                                                <td colspan="2"><a href="/f4_student/index/<?php echo $sres['base_assignment_id']; ?>/<?php echo $sres['assignment_id']; ?>/<?php echo $sres['resource_id']; ?>" class="btn b1"><span>VIEW</span><i class="icon i1"></i></a></td>
                                            </tr>
                                            <?php endforeach ?>
                                            {if student_overall_marks }
                                            <tr><td colspan="6">
                                                <h5 style="font-weight: bold">Comments - Overall Marks</h5>
                                                {student_overall_marks}
                                                <div id="comments_rows">
                                                    <div pg="0" unique_n="1" id="comment_row_1" class="comment_row">
                                                        <div style="" class="comment_row_cell_one"><div  pg="0" class="comment_NM">{unique_n}</div></div>
                                                        <div class="comment_row_cell_two"><div class="editable view_s"><b>{cat}</b><br>{comment}</div></div>
                                                        <div class="comment_row_cell_three" style="text-align: center; "><div class="editable view_s" style="width: 70px;margin-top: 10px;padding-top: 20px;font-weight: bold;font-size:18px;">{evaluation}</div></div>
                                                        <div style="clear: both;"></div>
                                                    </div>
                                                </div>
                                                {/student_overall_marks}
                                                </td>
                                            </tr>
                                            {/if}
                                            <?php if (sizeof(assignment_categories2) > 0): ?>
                                            <tr><td colspan="6"><hr></td></tr>
                                            <tr>
                                                <td colspan="2"><strong>Submission Total</strong></td>
                                                <td colspan="4"><span>{avarage_mark}/{marks_avail}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong>Current Attainment</strong></td>
                                                <td colspan="4"><span>{attainment}</span></td>
                                            </tr>
                                            <?php endif ?>
                                        </table>
                                        <table  class="table6" style="display: none;">
                                           {assignment_categories}
                                            <tr>
                                                <td colspan="2">{category_name}</td>
                                                <td colspan="4"><span>{category_total}/{category_avail}</span></td>
                                            </tr>
                                            {/assignment_categories}
                                            <tr><td colspan="6"><hr></td></tr>
                                            <tr>
                                                <td colspan="2"><strong>Submission Total</strong></td>
                                                <td colspan="4"><span>{avarage_mark}/{marks_avail}</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong>Current Attainment</strong></td>
                                                <td colspan="4"><span>{attainment}</span></td>
                                            </tr>
                                        </table>
                                    </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <h3>Submission Notes</h3>
                    <div class="controls">
                        <span></span>
                        <textarea id="submission_info" name="submission_info" class=""  style="height: 186px; margin-bottom: 10px;" >{submission_info}</textarea>
                    </div>
                    <h3>My Submissions</h3>
                    <div id="uploads" style="display: {student_resources_hidden};">
                        <ul class="ul1 resources">
                            <!-- icon video, icon doc -->
                            <?php foreach( $student_resources as $sres ): ?> 
                            <li>
                                        <div class="i"><span class="icon img" style="display: inline-block; margin-top: 13px;"></span></div>
                                        <div class="r">
                                            <?php echo $sres['preview']; ?>
                                            <a style="display<?php echo $sres['del_hide']; ?>: block; margin: 5px;" class="remove" href="javascript:deleteFile('<?php echo $sres['assignment_id']; ?>', '<?php echo $sres['resource_id']; ?>');"><span class="glyphicon glyphicon-remove"></span></a>
                                        </div>
                                        <div class="t">
                                            <span style=" display: inline-block; margin-top: 8px;"><?php if( strlen( $sres['resource_name'] ) < 20 ) echo $sres['resource_name']; else echo substr( $sres['resource_name'],0,19 ).'...' ?></span>
                                            <div class="late" style="display: <?php echo $sres['is_late'] ?>; float: right; font-size: 18px; color: #e74c3c; margin: 5px;">
                                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                            </div>
                                        </div>
                                    </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                    <ul class="ul3_resource_upload"></ul>
                    <div style="float: right; display: inline-block;">
                        <div class="progress-demo" style="padding:0 10px;height: 22px;margin-top:0px;float: left;">
                                    <div id="manual-fine-uploader"style="padding:10px;height: 22px;width:140px;height:40px;position:absolute;z-index:100;margin-top:0px;"></div>
                                </div>
                        <div class="c2_radios upload_box" style="float: left;margin-top: 20px;display: none;">
                            <input type="checkbox" id="file_uploaded_f" value="" disabled="disabled" checked="checked">
                            <label for="file_uploaded_f" id="file_uploaded_label" style="height: 40px;width:auto!important;float: left" ></label>
                        </div>
                        <div class="error_filesize"></div>
                        <button id="lb" class="ladda-button" style="float: right;" data-color="blue" data-size="s" data-style="expand-right" type="button" >Browse file</button>
                    </div>
                    <?php endif; ?>
                </div>
                <input type="hidden" name="assignment_id" value="{assignment_id}" />
                <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
            </form>
        </div>
<?php else: ?>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px;">
                <ul class="slides" style="width: 100%; padding-left: 0px;">
                    <li style="margin:10px 15px 0 0;list-style:none;">
                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:0 auto;padding: 0 0 30px;float: left;">
                                <h3 class="" style="padding-bottom:4px; height:26px;overflow: hidden;  border-bottom:1px solid #c8c8c8;margin-top: 14px;font-weight: bold;">Homework Description</h3>
                                <div class="" style="float:right;background-size: 70%;margin-top:-36px; background-position: 0px -30px;"></div>
                                <div class="assignment" style="margin:0px auto;">
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="padding: 10px 0px 17px 0px;font-weight: normal; float: left;">{intro}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Set by: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{set_by}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Date: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_date}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Deadline Time: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{deadline_time}</div>
                                    </div>
                                    <div style=" border-bottom:1px solid #c8c8c8;display: inline-block; width: 100%;">
                                        <?php if( $grade_type != 'offline' ): ?>
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left;">Marks Given As: </div>
                                        <div class="pr_title" style="padding: 10px 0px 17px 30px;font-weight: normal; float: left;">{grade_type_label}</div>
                                        <?php else: ?>
                                        <div class="pr_title" style="color: black;padding: 10px 0px 17px 0px;font-weight: bold; float: left; width: 100%;">This assignment must be submitted offline</div>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                </ul>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                {if resources}
                <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                    <h3 class="" style="padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                    <div class="" style="float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                    <div class="collapsed resources-student" style="margin:0px auto; display: block;">
                        <ul class="ul1 hw_resources">
                            <?php foreach( $resources as $res ): ?> 
                            <li>
                                <a href="javascript:;" style="background: none;border-bottom:1px solid #c8c8c8;color:#111;padding-top: 4px;" onclick="$(this).next().children().click()">
                                    <span class="icon <?php echo $res['type']; ?>" style="margin-top: -2px;color: #c8c8c8"> </span> <?php echo $res['resource_name']; ?>
                                </a>
                                <span class="show_resource" style="display:none;"><?php echo $res['preview']; ?></span>
                                <span style="float: right;"> <?php echo $res['required']; ?> </span>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                {/if}
            </div>
        </div>
        <form id="save_assignment" class="form-horizontal" enctype="multipart/form-data" method="post" action="/f2_student/save">
            <input type="hidden" name="publish" id="publish" value="0">    
            <input type="hidden" name="assignment_id" value="{assignment_id}" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
<?php endif ?>

        <form id="del_file" method="post" action="/f2_student/delfile">
            <input type="hidden" name="assignment_id" id="del_assignment_id" value="">
            <input type="hidden" name="resource_id" id="del_resource_id" value="">
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>

<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <?php if( $grade_type != 'offline' ): ?>
            <a  style="display: {hide_editors_publish};" href="javascript: saveAssigment('publish');" class="red_btn">{label_editors_publish}</a>
            <a  style="display: {hide_editors_save};" href="javascript:;" onclick="saveAssigment('save');" class="red_btn">{label_editors_save}</a>
            <?php endif ?>
        </div>
    </div>
</footer>

<div id="popupError" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" onClick="$('#popupMessage').modal('hide');" style="background: #128c44;" class="btn btn-primary">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">

<?php
$error_msg = $this->session->flashdata('error_msg');
if ($error_msg != '') {
    ?>
        $(document).ready(function () {
            message = '<?php echo $error_msg; ?>';
            showFooterMessage({status: 'alert', mess: message, clrT: '#6b6b6b', clr: '#fcaa57', anim_a: 2000, anim_b: 1700});
        })
<?php } ?>

</script>

<script type="text/javascript">
    var flashmessage_pastmark = '<?php echo $flashmessage_pastmark ?>';
    var assignment_id = '<?php echo $assignment_id ?>';
    var base_assignment_id = <?php echo $base_assignment_id ?>;
    var marked = '<?php echo $marked ?>';
    var l;
    var manualuploader;
    var start_timer = 0;

    $(function() {
        if( marked == 1 ) { $('.attained_marks').show() }
<?php if( $marked != 1 && $publish_marks != 1 ): ?>
        l = Ladda.create(document.querySelector('#save_assignment .ladda-button'));

        // nicEditor
        bkLib.onDomLoaded(function() { 
            new nicEditor({
                buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
    //            iconsPath : '<?= base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
            }).panelInstance('submission_info');
        })
<?php endif ?>
        $('.up_down___').on('click',function () {
            $(this).next('.up_down_homework').click();
        })
    
        manualuploader = $('#manual-fine-uploader').fineUploader({
            request: {
                endpoint: '<?php echo base_url() ?>' + 'f2_student/submissionUpload/',
                params: {assignment_id: '<?php echo $assignment_id ?>'}
            },
            multiple: false,
            validation: {
                allowedExtensions: ['jpg|JPEG|png|doc|docx|xls|xlsx|pdf|ppt|pptx|mmap|pub'],
                sizeLimit: 22120000, // 20000 kB -- 20mb max size of each file
                itemLimit: 40
            },
            showMessage: function (message) {
                $('.modal-body').html('').append('<div class="alert-error">' + message + '</div>');
                $('#popupError').modal('show');
            },
            //listElement: document.getElementById('files'),
            messages: {
                typeError: "An issues was experienced when uploading this file. Please check the file and then try again. If the problem persists, it may be a file that can't be uploaded."
            },
            autoUpload: true,
            text: {
                uploadButton: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />&nbsp;&nbsp;&nbsp;&nbsp;'
            },
        }).on('progress', function (event, id, filename, uploadedBytes, totalBytes) {
            if (start_timer == 0) {
                $('#save_assignment .ladda-label').text('Uploading File');
                $('#save_assignment #file_uploaded').val('');
                $('#save_assignment #file_uploaded_label').text('');
                $('#save_assignment .upload_box').fadeOut(200);
                l.start();
            }

            start_timer++;
            var progressPercent = (uploadedBytes / totalBytes).toFixed(2);

            if (isNaN(progressPercent)) {
                $('#save_assignment #progress-text').text('');
            } else {
                var progress = (progressPercent * 100).toFixed();
                l.setProgress((progress / 100));
                if (uploadedBytes == totalBytes) {
                    l.stop();
                }
            }
        }).on('complete', function (event, id, file_name, responseJSON) {
            start_timer = 0;
            if (responseJSON.success) {
                $('#save_assignment .ladda-label').text('Browse file');
                $('#uploads').show();
                $('.ul1.resources').append(
                    '<li><div class="i"><span class="icon img" style="display: inline-block; margin-top: 13px;"></span></div><div class="r">' + responseJSON.preview +
                    '<a style="display: block; margin: 5px;" class="remove" href="javascript:deleteFile(\'<?php echo $assignment_id ?>\', \''+responseJSON.resource_id+'\');"><span class="glyphicon glyphicon-remove"></span></a></div>'+
                    '<div class="t"><span style=" display: inline-block; margin-top: 8px;">'+responseJSON.name+'</span>'+
                    '<div class="late" style="display: '+responseJSON.is_late+'; float: right; font-size: 18px; color: #e74c3c; margin: 5px;"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></div></div></li>'
                );
                $('.colorbox').colorbox({ photo: true, maxWidth: "100%", maxHeight: "100%"});
            }
        });

        $('.upload').bind('change', function () {
            var filesize = this.files[0].size;
            if (filesize > 20000000) {
                $('.error_filesize').html('').append('<p>Please select files less than 20mb</p>');
                $('.upload').val('');
                $("#uploadFile").text('Choose file');
            }
        });
    })

    function cancel_resource() {
        if($('#save_assignment .new_upload').val().length>0) {
            var filename = $('#saveform .new_upload').val();
            data={filename:filename}
            $.ajax({
                url: '<?php echo base_url()?>f2_student/delete_file',
                data:data,
                type: 'POST',
                dataType: 'json',
                success: function(data) {
//                    window.location.href = '<?php echo base_url()?>c1'
                }
            });
        } else {
//            window.location.href = '<?php echo base_url()?>c1'
        }
    }

    function clickLB(){
        $('#lb').click();
    }

    function update_text() {
        var t = $('.upload').val();
        var filename = t.replace(/^.*\\/, "");
        $("#uploadFile").text(filename);

    }

//    var lesson_id = '';
    var slide_id = assignment_id;
    var identity = '<?php echo $identity; ?>';
    var behavior = 'homework';

    function submitAnswer( tbl_id, form_id, this_btn ) {
        form_id.find('input[name="slide_id"]').val(slide_id);
        form_id.find('input[name="identity"]').val(identity);
        form_id.find('input[name="behavior"]').val(behavior);

        post_data = form_id.serialize();

        $.post( "/f2_student/saveAnswer", {res_id: form_id.attr('name'), post_data: post_data}, function( data ) {
                $(this_btn).hide();
                //tbl_id.parent().parent()
                $('#li'+tbl_id.attr('rel')).css('background','#e6ffe6');
                //tbl_id.parent().parent().find
                $('.act'+tbl_id.attr('rel')).html('Question Answered');
        });
        $.colorbox.close();
    }

    function setResult(res_id) {
        $('#form_'+res_id).find('input').attr('disabled',true);

        $.get( "/f2_student/getStudentAnswers", { lesson_id: base_assignment_id, slide_id: assignment_id, resource_id: res_id, marked: marked }, function( data ) {
            switch(data.type) {
                case 'single_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'multiple_choice':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i]).attr('checked',true);
                    }
                    break;
                case 'fill_in_the_blank':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#'+data.answers[i].key).val(data.answers[i].val);
                    }
                    break;
                case 'mark_the_words':
                    for (i = 0; i < (data.answers.length); i++) { 
                        $('#q'+res_id+data.answers[i]).css('background', '#ff0');
                    }
                    break;
            }
            $('.tbl_'+res_id).html(data.html);
        },'json');
    }

    function showResult(res_id) {
//alert('What now ?!?!');
    }
</script>
