<link rel="stylesheet" href="<?=base_url("/js/slider/style.css")?>" type="text/css"/>
<script src="<?=base_url("/js/slider/jquery.noos.slider.js")?>"></script>
 
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<style type="text/css">
    .row { margin-right: 0px; margin-left: 0px; }
    .pr_title{padding-left: 22px;}
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
                <td width="51%" valign="top" style="padding: 0;">
        <?php endif; ?>


                            <ul class="slides" style="width: 100%;padding: 0;">
                                <li>


                                        <div class="row">
                                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                <div class="controls" style="margin-bottom: 10px;">
                                                    <h2>{assignment_title}</h2>
                                                    </div>
                                                <label for="assignment_intro">Homework Summary</label>
                                                <div class="controls" style="margin-bottom: 10px;">
                                                    <span>{assignment_intro}</span>
                                                      </div>
                                                <label for="grade_type" >Grade type:</label> <span>{grade_type}</span>

                                            </div>
                                            <div  class="col-lg-12 col-md-12 col-sm-12  col-xs-12">
                                                <h3 style="padding: 10px 0px 10px 0px; border-bottom:1px solid #c8c8c8;">Resources</h3><div class="up_down_homework" style="cursor:pointer;"></div>
                                                <div class="collapsed">
                                                <ul class="ul1 resources">
                                                    {resources}
                                                    <li><a href="javascript:;" style="background: none;border-bottom:1px solid #c8c8c8;color:#111;padding-top: 4px;" onclick="$(this).next().children().click()"><p><span class="icon {type}" style="margin-top: -2px;color: #c8c8c8"> </span> {resource_name}</p></a>
                                                        <span class="show_resource" style="display:none;">{preview}</span>

                                                    </li>

                                                    {/resources}
                                                </ul>
                                                    </div>

                                            </div>
                                        </div>

                                </li>
                                <li>
                                    <article class="step ">


                                        <div class="row">
                                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 10px;margin-top: -60px;">
                                                <h3 style="padding: 10px 0px; border-bottom:1px solid #c8c8c8;">Mark Categories</h3><div class="up_down_homework" style="cursor:pointer"></div>
                                                <div class="collapsed">
                                                    <h4 style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;">Category: <span class="pr_title">Marks Available</span></h4>
                                                    <h4 style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;" id="marksTotal"></h4>


                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-12 col-md-12 col-sm-12  col-xs-12">
                                                <h3 style="padding: 10px 0px 10px 0px; border-bottom:1px solid #c8c8c8;margin-top: -10px;">Grade Thresholds</h3><div class="up_down_homework" style="cursor:pointer"></div>
                                                <div class="collapsed" style="margin-bottom: 20px;;">

                                                    <div id="grade_attr_holder_preview">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                </li>
                                <li>
                                    <article style="margin-top: -70px;">

                                        <div class="row">
                                            <div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <h3 style="padding: 10px 0px 10px 0px; border-bottom:1px solid #c8c8c8;margin-top: 0px;">Assignment</h3><div class="up_down_homework" style="cursor:pointer"></div>
                                                <div class="collapsed">
                                                <h4 style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;">Assign to: <span class="pr_title">{assigned_to_year}th Grade</span></h4>

                                                <h4 style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;">Subjects: <span class="pr_title">{assigned_to_subject}</span></h4>

                                                <h4 class="last_d" style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;" >Assign to classes: </h4>

                                                <h4  style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;" >Deadline Date: <span class="pr_title">{assignment_date_preview} </span></h4>

                                                <h4  style="padding: 10px 0px 17px 0px; border-bottom:1px solid #c8c8c8;" >Deadline Time: <span class="pr_title">{assignment_time} </span></h4>
                                                </div>

                                                <div style="display: none;">
                                                <div class="controls">

                                                    <select onChange="Y_changed();" name="classes_year_select" id="classes_year_select" data-validation-required-message="Please select an academic year to assign to">
                                                        <option class="classes_select_option" value="-1"/>
                                                    </select>
                                                </div>

                                                <div class="controls">
                                                    <span></span>
                                                    <select onChange="S_changed();" name="classes_subject_select" id="classes_subject_select" data-validation-required-message="Please select a subject group to assign to">
                                                    </select>
                                                </div>



                                                </div>
                                                <br />
                                            </div>


                                        </div>
                                    </article>
                                </li>
                            </ul>


        <?php if( $mode != 1 ): ?>
                </td>
                <td width="49%" valign="top" align="left" style="margin:0px;padding: 0;">
                    <table style="margin-top: 78px;background-color: #ececec; float: left;" class="table2_preview"  width="100%" cellspacing="0">
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
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <?php if($datepast ==0)
{?>

            <a href="<?php echo base_url()?>f2b_teacher/edit/{assignment_id}"  class="btn b1edit " style="text-align: center">EDIT</a>
   <?php } ?>
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
