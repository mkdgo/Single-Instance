<script src="<?=base_url("/js/d3_teacher.js")?>"></script>
<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript">loadTinymce();</script>

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <h2>{subject_title}</h2>
        <form class="form-horizontal big_label"  action="/d3_teacher/save" method="post" id="saveform">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="control-group">
                        <label for="subject_intro" class="label_fix">Intro:</label>
                         <div class="controls">
                             <span></span>
                             <textarea name="subject_intro" id="subject_intro" placeholder="enter text..." class="textarea_fixed required" data-validation-required-message="Please provide an description for this subject">{subject_intro}</textarea>
                         </div>
                     </div>
                    <label for="subject_objectives" class="label_fix">Objectives:</label>
                    <textarea name="subject_objectives" id="subject_objectives" placeholder="enter text..."  class=" mce-toolbar-grp">{subject_objectives}</textarea>
                    <label for="subject_teaching_activities" class="label_fix">Teaching Activities:</label>
                    <textarea name="subject_teaching_activities" id="subject_teaching_activities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{subject_teaching_activities}</textarea>
                    <label for="subject_assessment_opportunities" class="label_fix">Assessment Opportunities:</label>
                    <textarea name="subject_assessment_opportunities" id="subject_assessment_opportunities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{subject_assessment_opportunities}</textarea>
                    <label for="subject_notes" class="label_fix">Notes:</label>
                    <textarea name="subject_notes" id="subject_notes" placeholder="enter text..." class="subject_notes mce-toolbar-grp">{subject_notes}</textarea>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-10 col-sm-offset-10 top-buffer-6" >
                    <h3>Modules</h3>
                    <ul class="ul3 {hide_modules}">
                        {modules}
                        <li><a href="/d4_teacher/index/{subject_id}/{module_id}">{module_name}</a></li>
                        {/modules}
                    </ul>
                    <div class="buttons clearfix">
                        <button type="submit" class="btn b1 right" name="new_module" value="{subject_id}" >ADD NEW MODULE<span class="icon i3"></span></button>
                    </div>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
            <input id="publish" type="hidden" name="publish" value="{subject_publish}" />
            <input id="parent_publish" type="hidden" name="parent_publish" value="{parent_publish}" />
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>

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
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" rel="{parent_publish}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>
