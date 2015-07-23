<!--<script src="<?=base_url("/js/f3_teacher.js")?>"></script>-->
<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>
<div class="blue_gradient_bg">
    <div class="container">
        <br />
        <div class="nav clearfix" style=" margin-bottom: 25px;">
            <a style="display: {prev_assignment_visible}" href="{prev_assignment}" class="prev-page arrow-left left"></a>
            <a style="display: {next_assignment_visible}" href="{next_assignment}" class="next-page arrow-right right"></a>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h6>Submitted On:</h6>
                <div class="date_time">
                    <span><i class="glyphicon glyphicon-calendar"></i>{submitted_date}</span>
                    <span><i class="glyphicon glyphicon-time"></i>{submitted_time}</span>
                    <!--{submitted_date}-->
                </div>
                <br />
                <br />
                <h6>Submission Notes: </h6>
                <div class="text">{submission_info}</div>
            </div>
            <div style="display: {list_hidden};" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="clearfix btns-selected els2">
                    <a class="{selected_link_a}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}">Marks per Uploaded File</a>
                    <a class="{selected_link_b}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}/2">Marks By Category</a>
                </div>
                <div  class="clearfix block-grey">
                    <?php if($selected_link_a=='sel'):?>
                        <table class="table5">
                            {student_resources}
                            <tr>
                                <td><i class="icon img" style="margin-top:-15px;"></i></td>
                                <td>{resource_name}
                                    <div style="background{is_late_hide}: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;"></div>
                                </td>
                                <td><span>{marks_total}</span></td>
<!--                                <td><span>{marks_total}/{marks_avail}</span></td>-->
                                <td>{view}</td>
                                <td><a href="/f4_teacher/resourceDownload/{resource_id}" class="btn b1"><span>DOWNLOAD</span><i class="icon i4"></i></a></td>
                            </tr>
                            {/student_resources}
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
                        <?php else : ?>
                        <table class="table_f3t">
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
                        <?php endif; ?>
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
