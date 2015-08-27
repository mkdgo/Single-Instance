<script>
//    var mark_id=0;
//    var mark_id={mark_id};
    var mark_id=0;
    var base_assignment_id={base_assignment_id};
    var assignment_id={assignment_id};
    var student_name="{student_name}";
    var HOST = '/f3_teacher/';
    var URL_save = HOST+'savedata/'+mark_id;
    var URL_load = HOST+'loaddata/'+mark_id;
    var URL_cat_total = HOST+'getCategoriesTotal/'+base_assignment_id;
    var homeworks_html_path = "{homeworks_html_path}";
    var homework_categories = {assignment_categories_json};

    var total = 0;
    var total_total = 0;
    var total_avail = 0;
    $.each( homework_categories, function( khm, vhm ) {
        total_avail+=parseInt(homework_categories[khm].category_marks);
        total_total+=parseInt(homework_categories[khm].category_total);
    });

    var pages_num={pages_num};

</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?=base_url("/js/resize/jquery.drag.resize.js")?>"></script>
<link rel="stylesheet" href="<?=base_url("/css/f3_teacher.css")?>" type="text/css" media="screen" title=""/>
<script src="<?=base_url("/js/f3_teacher.js")?>"></script>
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





                <?php if($this->session->userdata('user_type')=='teacher'): ?>
            <div style="display: {list_hidden}; padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="comments">
            <!--LOADING Data ...-->
<!--
            <div class="clear"></div>
            <h3>Marks</h3>
            <div id="categories_rows">
                <div id="category_row" class="category_row">
                    <div class="category_row_left"></div>
                    <div class="category_row_right"></div>
                </div>
            </div>
-->
            <div class="clear"></div>
            <h3 style="float: left; width:320px;" >Comments</h3><h3 style="float: left; width:80px;text-align: right">Marks</h3>
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
                <?php endif ?>
</div>















            </div>
            <div style="display: {list_hidden};" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="clearfix btns-selected els2">
                    <a class="sel_a {selected_link_a}" href="javascript: $('.sel_b').removeClass('sel');$('.sel_a').addClass('sel');$('.table_f3t').hide();$('.table5').show();">Marks per Uploaded File</a>
                    <a class="sel_b {selected_link_b}" href="javascript: $('.sel_a').removeClass('sel');$('.sel_b').addClass('sel');$('.table5').hide();$('.table_f3t').show();">Marks By Category</a>
<!--                    <a class="sel_a {selected_link_a}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}">Marks per Uploaded File</a>
                    <a class="sel_b {selected_link_b}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}/2">Marks By Category</a>-->
                </div>
                <div class="clearfix block-grey">
                    <?php  ?>
                        <table class="table5">
                            <?php foreach( $student_resources as $res ): ?> 
                            <?php if( $res['resource_id'] ): ?>
                            <tr>
                                <td><i class="icon img" style="margin-top:-15px;"></i></td>
                                <td><?php echo $res['resource_name']; ?>
                                    <div style="background{is_late_hide}: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;"></div>
                                </td>
                                <td><span><?php echo $res['marks_total']; ?></span></td>
<!--                                <td><span>{marks_total}/{marks_avail}</span></td>-->
                                <td><?php echo $res['view']; ?></td>
                                <td><a href="/f4_teacher/resourceDownload/<?php echo $res['resource_id']; ?>" class="btn b1"><span>DOWNLOAD</span><i class="icon i4"></i></a></td>
                            </tr>
                            <?php endif ?>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="5"><hr></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Submission Total</strong></td>
                                <td colspan="4"><span>{avarage_mark}/{marks_avail}</span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Current Attainment</strong></td>
                                <td colspan="4"><span>{attainment}</span></td>
                            </tr>
                        </table>
                        <?php //else : ?>
                        <table class="table_f3t" style="display: none;">
                            {assignment_categories}
                            <tr>
                                <td></td>
                                <td>{category_name}</td>
                                <td><span>{category_total}/{category_avail}</span></td>
                            </tr>
                            {/assignment_categories}
                            <tr>
                                <td colspan="5"><hr></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Submission Total</strong></td>
                                <td colspan="4"><span>{avarage_mark}/{marks_avail}</span></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Current Attainment</strong></td>
                                <td colspan="4"><span>{attainment}</span></td>
                            </tr>
                        </table>
                        <?php //endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
        </div>
    </div>
</footer>

<style>
    .submenusel, .submenu{ font-size:16px; color: #800000;} 
    .submenu{color: #000;} 
</style>
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

