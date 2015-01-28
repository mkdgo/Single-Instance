<script src="<?=base_url("/js/f3_teacher.js")?>"></script>
<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>
<div class="blue_gradient_bg">
    <div class="container">
        <h2>{base_assignment_name}</h2>
        <h3>{student_first_name} {student_last_name}</h3>
        <br />
        <hr class="m2">
        <div class="nav clearfix" style=" margin-bottom: 25px;">
            <a style="display: {prev_assignment_visible}" href="{prev_assignment}" class="prev-page arrow-left left"></a>
            <a style="display: {next_assignment_visible}" href="{next_assignment}" class="next-page arrow-right right"></a>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
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
            <div style="display: {list_hidden};" class="col-lg-7 col-md-7 col-sm-7 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                <div class="clearfix btns-selected els2">
                    <a class="{selected_link_a}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}">Marks per Uploaded File</a>
                    <a class="{selected_link_b}" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}/2">Marks By Category</a>
                </div>
                <div  class="clearfix block-grey">
                    <?php if($selected_link_a=='sel'):?>
                        <table class="table5">
                            {student_resources}
                            <tr>
                                <td><i class="icon img"></i></td>
                                <td>{resource_name}
                                    <div style="background{is_late_hide}: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;"></div>
                                </td>
                                <td><span>{marks_total}/{marks_avail}</span></td>
                                <td><a href="/f4_teacher/index/{base_assignment_id}/{assignment_id}/{resource_id}" class="btn b1"><span>VIEW</span><i class="icon i1"></i></a></td>
                                <td><a href="/d5_teacher/resource/{resource_id}" class="btn b1"><span>DOWNLOAD</span><i class="icon i4"></i></a></td>
                            </tr>
                            {/student_resources}
                            <tr>
                                <td colspan="5"><hr></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Submission Total</strong></td>
                                <td><span>{avarage_mark}/{marks_avail}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Current Attainment</strong></td>
                                <td><span>{attainment}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <?php else : ?>
                        <table class="table5">
                            {assignment_categories}
                            <tr>
                                <td></td>
                                <td>{category_name}</td>
                                <td><span>{category_total}/{category_avail}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                            {/assignment_categories}
                            <tr>
                                <td colspan="5"><hr></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Submission Total</strong></td>
                                <td><span>{avarage_mark}/{marks_avail}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><strong>Current Attainment</strong></td>
                                <td><span>{attainment}</span></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">

        </div>
    </div>
</footer>

<style>


    .submenusel, .submenu{ font-size:16px; color: #800000;} 
    .submenu{color: #000;} 

</style>

<?php /* <div class="gray_top_field">
    <!-- <a id="saveandpublish_bt" href="javascript:;" onclick="saveAssigment('savepublish');" style="margin:0 30px 0 0px;width:350px;float:right;" class="add_resource_butt black_button new_lesson_butt ui-link">SAVE AND PUBLISH</a> -->
    <!-- <a id="savedraft_bt" href="javascript:;" onclick="saveAssigment('save');" style="margin:0 10px 0 0px;width:350px;float:right;" class="add_resource_butt black_button new_lesson_butt ui-link">SAVE ASSIGNMENT AS A DRAFT</a> -->

    <div class="clear"></div>
    </div>


    <div class="blue_gradient_bg">
    <div class="container">



    <div style="width: 100%; float: left;" class="ui-grid-c"> 

    <div style="width: 3%;" class="ui-block-a"><a style="display: {prev_assignment_visible}" href="{prev_assignment}"><img src="/img/arr_left.png"></a></div>

    <div style="width: 30%;" class="ui-block-b">
    <div style="width: 100%; font-size: 18px;">
    <a href="/f2b_teacher/index/{base_assignment_id}">{base_assignment_name}</a><br>
    {student_first_name} {student_last_name}
    </div>

    <div style="margin-top:15px;" class="ui-grid-a">
    <div style="width: 40%;" class="ui-block-a">
    Submitted On: 
    </div>
    <div style="padding-left:5px; width: 60%; color:#888; background: white; border:1px solid orange;" class="ui-block-b">
    {submitted_date}
    </div>

    <div style="margin-top: 5px; width: 40%;" class="ui-block-a">
    Submission Notes: 
    </div>
    <div style="padding-left:5px; margin-top: 5px; height: 270px; overflow: auto; width: 60%;  color: #888;  background: white; border:1px solid orange;" class="ui-block-b">
    {submission_info}
    </div>
    </div>


    </div>

    <div style="width: 65%;" class="ui-block-c">
    <div style="margin-left: 25px; width: 95%; font-size: 18px; background: #dce6f2; border:1px solid #759dcc;">
    <a data-role="none" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}" class="submenu{selected_link_a}" style="margin-left: 15px; margin-right: 15px;">Marks by Submission</a>/
    <a data-role="none" href="/f3_teacher/index/{base_assignment_id}/{assignment_id}/2" class="submenu{selected_link_b}" style="margin-left: 15px;">Marks by Category</a> 
    </div>

    <div style="display: {list_hidden}; margin-left: 25px; margin-top: 10px; width: 95%; background: white; border:1px solid #759dcc;">

    <div style=" margin: 5px;">
    <?php if($selected_link_a=='sel'):?>
    <div class="ui-grid-c">
    <div style="font-weight: bold; width: 50%;" class="ui-block-a">Document name</div>
    <div style="font-weight: bold; width: 10%;" class="ui-block-b">Grade</div>
    <div style="width: 20%;" class="ui-block-c"></div>
    <div style="width: 20%;" class="ui-block-d"></div>
    </div>
    <!--height:270px; overflow: auto;-->
    <div style="" class="ui-grid-c">

    {student_resources}
    <div style="padding-top: 10px; font-size:16px; width: 50%;" class="ui-block-a">{resource_name}<div style="background: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px; display: {is_late_hide}"></div></div>
    <div style="padding-top: 10px; font-size:16px; width: 10%;" class="ui-block-b">45</div>
    <div style="width: 20%;" class="ui-block-c">
    <a style="width:120px;" href="/d5_teacher/resource/{resource_id}" data-role="button" data-mini="true" data-theme="a" title="{resource_name}">View Document</a>
    </div>
    <div style="width: 20%;" class="ui-block-d">
    <a style="width:120px;" href="/d5_teacher/resource/{resource_id}" data-role="button" data-mini="true"data-theme="b" title="{resource_name}">Download</a>
    </div>
    {/student_resources}
    </div>

    <div style="margin-top:20px;" class="ui-grid-c">
    <div style="font-weight: bold; width: 50%; color: red;" class="ui-block-a">Submission Total</div>
    <div style="font-weight: bold; width: 10%; color: red;" class="ui-block-b">56</div>
    <div style="width: 20%;" class="ui-block-c"></div>
    <div style="width: 20%;" class="ui-block-d"></div>

    <div style="font-weight: bold; width: 50%; color: red;" class="ui-block-a">Current Attainment</div>
    <div style="font-weight: bold; width: 10%; color: red;" class="ui-block-b">AA</div>
    <div style="width: 20%;" class="ui-block-c"></div>
    <div style="width: 20%;" class="ui-block-d"></div>
    </div>

    <?php else:?>

    <div style="" class="ui-grid-a">
    {assignment_categories}
    <div style="padding-top: 10px; font-size:16px; width: 50%;" class="ui-block-a">{category_name}</div>
    <div style="padding-top: 10px; font-size:16px; width: 50%;" class="ui-block-b">45</div>
    {/assignment_categories}
    </div>

    <div style="" class="ui-grid-a">
    <div style="padding-top: 10px; font-size:16px; font-weight: bold; width: 50%; color: red;" class="ui-block-a">Submission Total</div>
    <div style="padding-top: 10px; font-size:16px; font-weight: bold; width: 50%; color: red;" class="ui-block-b">90/100</div>

    <div style="padding-top: 10px; font-size:16px; font-weight: bold; width: 50%; color: red;" class="ui-block-a">Current Attainment</div>
    <div style="padding-top: 10px; font-size:16px; font-weight: bold; width: 50%; color: red;" class="ui-block-b">A</div>
    </div>

    <?php endif?>
    </div>

    </div>

    </div>
    <div style="width: 2%;" class="ui-block-d"><a style="display: {next_assignment_visible}" href="{next_assignment}"><img src="/img/arr_right.png"></a></div>

    </div>


    </div>
    </div>

*/ ?>