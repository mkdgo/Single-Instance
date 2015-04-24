<script>
    var flashmessage_pastmark = {flashmessage_pastmark};
</script>
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script src="<?=base_url("/js/f2_student.js")?>"></script>
<div class="breadcrumb_container">
    <div class="container">{breadcrumb}</div>
</div>
<div  class="blue_gradient_bg">
    <div class="container">

        <form id="save_assignment" class="form-horizontal" enctype="multipart/form-data" method="post" action="/f2_student/save">
            <input type="hidden" name="publish" id="publish" value="0">	
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <ul class="ul4">
                        <li>
                            <h3>Deadline:</h3>
                            <div class="date_time">
                                <span><i class="glyphicon glyphicon-calendar"></i>{deadline_date}</span>
                                <span><i class="glyphicon glyphicon-time"></i>{deadline_time}</span>
                                <!--{deadline}-->
                            </div>
                        </li>
                        <li>
                            <h3>Assessment Summary:</h3>
                            {intro}
                        </li>
                        <li>
                            <h3>Grade Type:</h3>
                            {grade_type}
                        </li>
                    </ul>
                    <h3>Resources</h3>
                    <ul class="ul3_resource  {resource_hidden}">
                        {resources}
                        <li><a href="javascript:;" onclick="$(this).next().children().click()"><p><span class="icon {type}"></span>&nbsp; {resource_name}</p></a>
                            <span class="show_resource" style="display:none;">{preview}</span>

                        </li>

                        {/resources}
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                <?php if($marked==1):?>
                    <h3>My Submissions Notes</h3>
                    <div style=";" class="block-grey">
                    {submission_info_isempty}
                    </div>
                    <div style="margin-top: 10px;" class="lessons_box">
                        <h3>My Submissions Marks</h3>
                        <div style="display: {list_hidden}; width: 546px;" >
                            <div class="clearfix btns-selected els2">
                                <a class="{selected_link_a}" href="/f2_student/index/{assignment_id}">Marks per Uploaded File</a>
                                <a class="{selected_link_b}" href="/f2_student/index/{assignment_id}/2">Marks By Category</a>
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
                                        <td><span>{marks_total}/{marks_avail}</span></td>
                                        <td><a href="/f4_student/index/{base_assignment_id}/{assignment_id}/{resource_id}" class="btn b1"><span>VIEW</span><i class="icon i1"></i></a></td>
                                    </tr>
                                    {/student_resources}
                                    <tr>
                                        <td colspan="4"><hr></td>
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
                                <table  class="table6">
                                   {assignment_categories}
                                    <tr>

                                        <td colspan="2">{category_name}</td>
                                        <td colspan="4"><span>{category_total}/{category_avail}</span></td>

                                    </tr>
                                    {/assignment_categories}
                                    <tr>
                                        <td colspan="4"><hr></td>
                                    </tr>
                                    <tr>

                                        <td colspan="2"><strong>Submission Total</strong></td>
                                        <td colspan="4"><span>{avarage_mark}/{marks_avail}</span></td>

                                    </tr>
                                    <tr>

                                        <td colspan="2"><strong>Current Attainment</strong></td>
                                        <td colspan="4"><span>{attainment}</span></td>

                                    </tr>
                                </table>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else:?>
                    <h3>Submission Notes</h3>
                    <div class="controls">
                        <span></span>
                        <textarea name="submission_info" class="mce-toolbar-grp required"  style="height: 186px; margin-bottom: 70px;" data-validation-required-message="Please provide some notes to accompany your submission">{submission_info}</textarea>
                    </div>
                    <h3>My Submissions</h3>
                    <div style="display: {student_resources_hidden};">
                        <ul class="ul1 resources">
                            <!-- icon video, icon doc -->
                            {student_resources}
                            <li>
                                <div class="i">
                                    <span class="icon img"></span>
                                </div>
                                <div style="width: 140px;" class="r">
                                    {preview}
                                    <a style="margin-top: 3px; display: none; display{del_hide}: block;" class="remove" href="javascript:deleteFile('{assignment_id}', '{resource_id}');"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                                <div class="t">{resource_name}
                                    <div style="background{is_late_hide}: url('/img/red_dot_late.png') no-repeat;  float: right; width: 30px;  height: 30px;"></div>
                                </div>
                            </li>
                            {/student_resources}
                        </ul>
                    </div>

                    <ul class="ul3_resource_upload">


                    </ul>
                    <!--
                    <div id="filesubmissions" class="buttons clearfix">
                        <input style="float: left;" type="file" onChange="FLCH()" name="userfile[]" id="userfile_0"/>
                    </div>
                    -->
                    <a class="btn b1 right" href="javascript:addSubm();">ADD SUBMISSION<span class="icon i3"></span></a>
                <?php endif;?>
                </div>
            </div>
            <input type="hidden" name="assignment_id" value="{assignment_id}" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>

        <form id="del_file" method="post" action="/f2_student/delfile">
            <input type="hidden" name="assignment_id" id="del_assignment_id" value="">
            <input type="hidden" name="resource_id" id="del_resource_id" value="">
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>

<div id="popupMessage" class="modal fade">
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

<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a  style="display: {hide_editors_publish};" href="javascript: saveAssigment('publish');" class="red_btn">{label_editors_publish}</a>
            <a  style="display: {hide_editors_save};" href="javascript:;" onclick="saveAssigment('save');" class="red_btn">{label_editors_save}</a>
        </div>
    </div>
</footer>

<script type="text/javascript">
</script>
