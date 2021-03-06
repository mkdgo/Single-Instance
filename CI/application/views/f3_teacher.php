<style type="text/css">
    .submenusel, .submenu{ font-size:16px; color: #800000;} 
    .submenu{color: #000;}
    .sel_a, .sel_b { cursor: pointer; }
    .attained {
        float: right;
        font-weight: bold;
        height: 40px;
        background-color: #99ff99;
        width: 40px;
        text-align: center;
        line-height: 40px;
        border-radius: 40px;
        border: 1px solid #333;
        margin-top: -10px;
    }
</style>
<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>
<div class="blue_gradient_bg">
    <div class="container">
        <br />
        <div class="nav clearfix" style=" margin-bottom: 25px;">
<!--            <a style="display: {prev_assignment_visible}" rel="{prev_assignment}" class="prev-page arrow-left left"></a>
            <a style="display: {next_assignment_visible}" rel="{next_assignment}" class="next-page arrow-right right"></a>-->
            <a style="display: {prev_assignment_visible}" href="{prev_assignment}" class="prev-page arrow-left left"></a>
            <a style="display: {next_assignment_visible}" href="{next_assignment}" class="next-page arrow-right right"></a>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h3>Submitted On:</h3>
                <div class="date_time">
                    <span><i class="glyphicon glyphicon-calendar"></i>{submitted_date}</span>
                    <span><i class="glyphicon glyphicon-time"></i>{submitted_time}</span>
                    <!--{submitted_date}-->
                </div>
                <br />
                <br />
                <h3>Submission Notes: </h3>
                <div class="text">{submission_info}</div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php if( $grade_type != 'test' ): ?>
                <div class="clearfix btns-selected els2">
                    <a class="sel_a {selected_link_a}" onclick="changeViewMarks('a')">Marks per Uploaded File</a>
                    <a class="sel_b {selected_link_b}" onclick="changeViewMarks('b')">Marks By Category</a>
                </div>
                <div class="clearfix block-grey">
                    <table class="table5">
                        {no-submission}
                        <?php foreach( $student_resources as $res ): ?> 
                        <?php if( $res['resource_id'] ): ?>
                        <tr>
                            <td><i class="icon img" style="margin-top:-10px;"></i></td>
                            <td><?php echo $res['resource_name']; ?>
<!--                                <div style="background<?php echo $res['is_late_hide']; ?>: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;">-->
                                <div style="float: right; width: 30px; height: 30px; color:#bb3A25; font-size: 25px; margin-top: -5px; display: <?php echo $res['is_late_hide'] ?>;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                </div>
                            </td>
                            <td><span><?php echo $res['marks_total']; ?></span></td>
                            <td><?php echo $res['view']; ?></td>
                            <td><a href="/f4_teacher/resourceDownload/<?php echo $res['resource_id']; ?>" class="btn b1"><span>DOWNLOAD</span><i class="icon i4"></i></a></td>
                        </tr>
                        <?php endif ?>
                        <?php endforeach ?>
                        <tr><td colspan="5"><hr></td></tr>
                        <tr>
                            <td></td>
                            <td><strong>Submission Total</strong></td>
                            <td colspan="3"><span><span class="avarage_mark">{avarage_mark}</span>/<span>{marks_avail}</span></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Current Attainment</strong></td>
                            <td colspan="3"><span class="attainment">{attainment}</span></td>
                        </tr>
                    </table>
                    <table class="table_f3t" style="display: none;">
                        {assignment_categories}
                        <tr>
                            <td></td>
                            <td>{category_name}</td>
                            <td colspan="3"><span><span id="cat_{id}">{category_total}</span>/<span>{category_avail}</span></span></td>
                        </tr>
                        {/assignment_categories}
                        <tr><td colspan="5"><hr></td></tr>
                        <tr>
                            <td></td>
                            <td><strong>Submission Total</strong></td>
                            <td colspan="3"><span><span class="avarage_mark">{avarage_mark}</span>/<span>{marks_avail}</span></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><strong>Current Attainment</strong></td>
                            <td colspan="3"><span class="attainment">{attainment}</span></td>
                        </tr>
                    </table>
                </div>
                <?php if($this->session->userdata('user_type')=='teacher'): ?>
                <div style="display: {list_hidden}; padding: 0;">
                    <div id="comments">
                        <div class="clear"></div>
                        <h3 style="float: left; width:320px;" >Comments</h3><h3 style="float: right; width:80px;text-align: left">Marks</h3>
                        <div id="comments_rows">
                            <div id="comment_row" class="comment_row">
                                <a href="javascript: void(0);" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a>
                                <div class="comment_row_cell_one"><div class="comment_NM">D</div></div>
                                <div class="comment_row_cell_extra">
                                    <select class="comment_CT customize">
                                    </select>
                                </div>
                                <div class="comment_row_cell_two"><textarea class="comment_TA"></textarea></div>
                                <div class="comment_row_cell_three" style=""><input class="comment_TI" style="text-align: center" type="text"></div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <div id="comment_row_total" class="category_row">
                            <div class="category_row_left" style="text-align: right; border-right-width: 4px; border-right-style: solid; border-right-color: rgb(238, 238, 238);">Total Marks</div>
                            <div class="category_row_right" style="text-align: center; width: 40px;"></div>
                        </div>
                        <div id="caption_a">
                            <div  class="buttons clearfix">
                                <a id="addcomment_bt" class="btn b1 right" href="javascript:;" onclick="addJustComment();" style="margin:0 10px 0 0px;" >ADD COMMENT<span class="icon i3"></span></a>
                            </div>  
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <?php endif ?>
            <?php else: ?>
                {if resources}
                <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12" style="margin:0 auto;padding: 0 0px 30px;float: left;">
                    <h3 class="" style="padding-bottom: 6px;height: 26px;;overflow: hidden;clear: both; border-bottom:1px solid #c8c8c8;font-weight: bold;">Resources</h3>
                    <div class="" style="float:right;background-size: 70%;height:22px;margin-top:-36px;"></div>
                    <div class="collapsed resources-student" style="margin:0px auto; display: block;">
                        <ul class="ul1 hw_resources">
                            <?php foreach( $resources as $res ): ?> 
                            <li>
                                <a href="javascript:;" style="background: none; color: #e7423c;padding-top: 4px;" onclick="$(this).next().children().click()">
                                    <?php echo $res['span_name'] ?>
<!--                                    <span class="icon <?php //echo $res['type']; ?>" style="margin-top: -2px;color: #c8c8c8"> </span>--> <?php //echo $res['resource_name']; ?>
                                </a>
                                <span class="show_resource" style="display:none;"><?php echo $res['preview']; ?></span>
                                <?php echo $res['styled']; ?>
                                <?php //if( in_array( $res['type'], array('single_choice','multiple_choice','fill_in_the_blank','mark_the_words') ) ): ?>
<!--                                <span class="attained" <?php echo $res['styled'] ?>> <?php echo $res['attained']; ?>/<?php echo $res['marks_available']; ?> </span>-->
                                <?php //endif ?>
                            </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                {/if}
                <?php if($this->session->userdata('user_type')=='teacher'): ?>
                <div style="display: {list_hidden}; padding: 0;">
                    <div id="comments">
                        <div class="clear"></div>
                        <h3 style="float: left; width:320px;" >Comments</h3>
                        <div id="comments_rows">
                            <div id="comment_row" class="comment_row">
                                <a href="javascript: void(0);" class="btn remove"><span class="glyphicon glyphicon-remove"></span></a>
                                <div class="comment_row_cell_one"><div class="comment_NM">D</div></div>
                                <div class="comment_row_cell_extra">
                                    <select class="comment_CT customize"></select>
                                </div>
                                <div class="comment_row_cell_two" style="width: 480px;"><textarea class="comment_TA" style="width: 100%;"></textarea></div>
                                <div class="comment_row_cell_three" style=""><input class="comment_TI" style="text-align: center" type="hidden" value="0"></div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <div id="comment_row_total" class="category_row">
                            <div class="category_row_left" style="text-align: right; border-right-width: 4px; border-right-style: solid; border-right-color: rgb(238, 238, 238);">Total Marks</div>
                            <div class="category_row_right_" style="text-align: center; width: 40px; padding-top: 10px; height: 40px; float: left;"><?php echo $attainment ?></div>
                        </div>
                        <div id="caption_a">
                            <div  class="buttons clearfix">
                                <a id="addcomment_bt" class="btn b1 right" href="javascript:;" onclick="addJustComment();" style="margin:0 10px 0 0px;" >ADD COMMENT<span class="icon i3"></span></a>
                            </div>  
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </div>
                <?php endif ?>
            <?php endif ?>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
        </div>
    </div>
</footer>

<div id="message" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupMessage" class="modal fade">
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
                <button type="button" class="btn btn-cancel" data-dismiss="modal" >CANCEL</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="popupDel" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2">
                <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="modal-body">
                <p>Please confirm you want to delete your Comment!</p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal" onClick="undoDeleteComment()">CANCEL</button>
                <button id="popupDelBT" cm="" p="" do="1" type="button" onClick="doDeleteComment()" class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
//    var mark_id=0;
    var mark_id = {mark_id};
    var base_assignment_id = {base_assignment_id};
    var assignment_id = {assignment_id};
    var student_name = "{student_name}";
    var student_id = {student_id};
    var HOST = '/f3_teacher/';
    var URL_save = HOST + 'savedata/' + mark_id;
    var URL_load = HOST + 'loaddata/' + mark_id;
    var URL_cat_total = HOST + 'getCategoriesTotal/' + base_assignment_id;
    var homeworks_html_path = "{homeworks_html_path}";
    <?php if( $assignment_categories_json ): ?>
    var homework_categories = {assignment_categories_json};
    <?php else: ?>
    var homework_categories = '';
    <?php endif ?>
    var total = 0;
    var total_total = 0;
    var total_avail = 0;
    $.each( homework_categories, function( khm, vhm ) {
        total_avail += parseInt( homework_categories[khm].category_marks );
        total_total += parseInt( homework_categories[khm].category_total );
    });
    var pages_num=0;
    function changeViewMarks( clss ) {
        if( clss == 'a' ) {
            $('.sel_b').removeClass('sel');
            $('.sel_a').addClass('sel');
            $('.table_f3t').hide();
            $('.table5').show();
        } else {
            $('.sel_a').removeClass('sel');
            $('.sel_b').addClass('sel');
            $('.table5').hide();
            $('.table_f3t').show();
        }
    }


    function setResult(res_id) {
        $('#form_b'+res_id).find('input').attr('disabled',true);
        $('#form_b'+res_id).find('.ans').attr('onclick','');
        $('#form_b'+res_id).find('.ans').removeClass('choice-true');
        $('#form_b'+res_id).find('.ans').removeClass('choice-wrong');
        $('#form_b'+res_id).find('.choice-correct-radio-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-radio-value').remove();
        $('#form_b'+res_id).find('.choice-correct-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-value').remove();
        $('#form_b'+res_id).find('.choice-correct-mark-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-mark-value').remove();
        $('#form_b'+res_id).find('.choice-correct-fill-value').remove();
        $('#form_b'+res_id).find('.choice-wrong-fill-value').remove();
        $('#form_b'+res_id).find('label.choice-correct-radio').attr('class', '');
        $('#form_b'+res_id).find('label.choice-wrong-radio').attr('class', '');
        $('#form_b'+res_id).find('input.choice-wrong').attr('class', '');
        $('#form_b'+res_id).find('input.choice-wrong-fill').attr('class', '');
        $('#form_b'+res_id).find('input.choice-true').attr('class', '');
        $('#form_b'+res_id).find('input.choice-correct').attr('class', '');
        $('#form_b'+res_id).find('input.choice-correct-fill').attr('class', '');

        $.get( "/r2_teacher/getStudentAnswers", { lesson_id: base_assignment_id, resource_id: 'b'+res_id, student_id: student_id, behavior: 'homework' }, function( data ) {
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

            $('.tbl_b'+res_id).html(data.html.html);
        },'json');
    }
</script>
