<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script src="<?=base_url("/js/d5_teacher.js")?>"></script>
<script type="text/javascript">loadTinymce();</script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal big_label" action="/d5_teacher/save" method="post" id="saveform">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="lesson_title" class="label_fix">Lesson Title:</label>
                     <div class="controls">
                         <span></span>
                        <input type="text" value="{lesson_title}" name="lesson_title" id="lesson_title" placeholder="Enter text..." class="required" data-validation-required-message="Please provide a title for this lesson"/>
                     </div>
                    <label for="lesson_intro" class="label_fix">Intro:</label>
                    <textarea name="lesson_intro" id="lesson_intro" placeholder="enter text..." class="textarea_fixed">{lesson_intro}</textarea>
                    <label for="lesson_objectives" class="label_fix">Objectives:</label>
                    <textarea name="lesson_objectives" id="lesson_objectives" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_objectives}</textarea>
                    <label for="lesson_teaching_activities" class="label_fix">Teaching Activities:</label>
                    <textarea name="lesson_teaching_activities" id="lesson_teaching_activities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_teaching_activities}</textarea>
                    <label for="lesson_assessment_opportunities" class="label_fix">Assessment Opportunities:</label>
                    <textarea name="lesson_assessment_opportunities" id="lesson_assessment_opportunities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_assessment_opportunities}</textarea>
                    <label for="lesson_notes" class="label_fix">Notes:</label>
                    <textarea name="lesson_notes" id="lesson_notes" placeholder="enter text..." class="lesson_notes mce-toolbar-grp">{lesson_notes}</textarea>
                </div>		
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 top-buffer-5">
                    <h3  class="{resource2_hidden}">Resources</h3>
                    <ul class="ul1 resources {resource_hidden}">
                        {resources}
                        <li>
                            <div class="i"><span class="icon img"></span></div>
                            <div class="r">{preview}</div>
                            <div class="t"><span title="{resource_name}">{resource_name}</span></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix {resource2_hidden}">
                        <button type="submit" onclick=" $('#new_resource').val(1);" class="btn b1 right" href="">ADD<span class="icon i3"></span></button>
<!--                        <button type="submit" name="redirect" value="{lesson_id}/{subject_id}/{module_id}" style="border: none; float: right;margin-right: -3px;background-color: transparent;"> <a class="btn b1 right" href="/c1/index/lesson/{lesson_id}/{subject_id}/{module_id}">ADD<span class="icon i3"></span></a></button>-->
                    </div>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input id="publish" type="hidden" name="publish" value="{publish}" />
            <input id="parent_publish" type="hidden" name="parent_publish" value="{parent_publish}" />
            <input id="new_resource" type="hidden" name="new_resource" value="0" >
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
    </div>
</div>

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
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer2">
                <button type="button" class="btn btn-cancel" data-dismiss="modal">CANCEL</button>
                <button id="popupPublBT" do="1" type="button" onClick="doPubl()"  class="btn orange_btn">CONFIRM</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<prefooter>
    <div class="container"></div>
</prefooter>
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: publishModal(this);" class="publish_btn {publish_active}" rel="{parent_publish}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
            {create_edit_interactive_lesson}
        </div>
    </div>
</footer>
