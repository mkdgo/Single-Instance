<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script src="<?=base_url("/js/d4_teacher.js")?>"></script>
<script src="<?=base_url("/js/jqBootstrapValidation.min.js")?>"></script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal big_label" action="/d4_teacher/save" method="post" id="saveform" name="saveform">
            <h2></h2>
            <div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div data-role="fieldcontain">        
                        <label for="module_name" class="label_fix">Module Title:</label>
                         <div class="controls">
                            <span></span>
                            <input type="text" value="{module_name}" class="module_title required" data-validation-required-message="Please provide a title for this module" name="module_name" id="module_name" placeholder="Enter text..." required>
                        </div>
                    </div>
                    <div data-role="fieldcontain">        
                        <label for="module_intro" class="label_fix">Intro:</label>
                        <textarea name="module_intro" id="module_intro" placeholder="enter text..." class="textarea_fixed">{module_intro}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_objectives" class="label_fix">Objectives:</label>
                        <textarea name="module_objectives" id="module_objectives" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{module_objectives}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_teaching_activities" class="label_fix">Teaching Activities:</label>
                        <textarea name="module_teaching_activities" id="module_teaching_activities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{module_teaching_activities}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_assessment_opportunities" class="label_fix">Assessment Opportunities:</label>
                        <textarea name="module_assessment_opportunities" id="module_assessment_opportunities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{module_assessment_opportunities}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_notes" class="label_fix">Notes:</label>
                        <textarea name="module_notes" id="module_notes" placeholder="enter text..." class="module_notes mce-toolbar-grp">{module_notes}</textarea>
                    </div>
                    <div class="row hidden">
                        <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11 label_fix">
                                    <strong>15/04/2013</strong> text text texext text  text tetext text  text text text  text text text  text text text
                                </div>
                                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                    <a data-theme="f" href="#" data-role="button" data-icon="delete" data-iconpos="notext"></a>
                                </div>  
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="lessons_box col-lg-5 col-md-5 col-sm-5 col-xs-12 top-buffer-10" >
                    <h3 class="{hide2_lessons}">Lessons</h3>
                    <ul class="ul3 {hide_lessons}">
                        {lessons}
                        <li><a href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">{lesson_title}</a></li>
                        {/lessons}
                    </ul>
                    <div class="buttons clearfix">
                        {add_new_lesson}
                    </div>
                    <br />
                     <h3 class="{hide2_lessons}">Resources</h3>
                    <ul class="ul1 resources {resource_hidden}">
                        {resources}
                        <li>
                            <div class="i"><span class="icon img"></span></div>
                            <div class="r">{preview}</div>
                            <div class="t"><span title="{resource_name}">{resource_name}</span></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix {hide2_lessons}">
                        <button type="submit" onclick=" $('#new_resource').val(1);" class="btn b1 right" href="">ADD<span class="icon i3"></span></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="subject_id" value="{module_subject_id}" />
            <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input id="publish" type="hidden" name="publish" value="{module_publish}" >
            <input id="parent_publish" type="hidden" name="parent_publish" value="{parent_publish}" />
            <input id="new_lesson" type="hidden" name="new_lesson" value="0" >
            <input id="new_resource" type="hidden" name="new_resource" value="0" >
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
    </div>
</div>
<br />

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
                <button id="popupPublBT" do="1" type="button" onClick="doPubl()" class="btn orange_btn">CONFIRM</button>
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
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" rel="{parent_publish}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>

