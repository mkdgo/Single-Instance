<!--<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>
<script type="text/javascript">loadTinymce();</script>-->
<script src="<?=base_url("/js/d5_teacher.js")?>"></script>
<script type="text/javascript" src="<?= base_url("/js/nicEdit/nicEdit.js") ?>"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { 
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('lesson_intro');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('lesson_objectives');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('lesson_teaching_activities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('lesson_assessment_opportunities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','right','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily','fontFormat','html'],
            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('lesson_notes');
    })
</script>

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal big_label" action="/d5_teacher/save" method="post" id="saveform">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label for="lesson_title" class="label_fix_space">Lesson Title:</label>
                     <div class="controls">
                         <span></span>
                        <input type="text" value="{lesson_title}" name="lesson_title" id="lesson_title" placeholder="Enter text..." class="required" data-validation-required-message="Please provide a title for this lesson"/>
                     </div>
                    <label for="lesson_intro" class="label_fix_space">Intro:</label>
                    <textarea name="lesson_intro" id="lesson_intro" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_intro}</textarea>
                    <label for="lesson_objectives" class="label_fix_space">Objectives:</label>
                    <textarea name="lesson_objectives" id="lesson_objectives" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_objectives}</textarea>
                    <label for="lesson_teaching_activities" class="label_fix_space">Teaching Activities:</label>
                    <textarea name="lesson_teaching_activities" id="lesson_teaching_activities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_teaching_activities}</textarea>
                    <label for="lesson_assessment_opportunities" class="label_fix_space">Assessment Opportunities:</label>
                    <textarea name="lesson_assessment_opportunities" id="lesson_assessment_opportunities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp">{lesson_assessment_opportunities}</textarea>
                    <label for="lesson_notes" class="label_fix_space">Notes:</label>
                    <textarea name="lesson_notes" id="lesson_notes" placeholder="enter text..." class="lesson_notes mce-toolbar-grp">{lesson_notes}</textarea>
                </div>		
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h4  class="{resource2_hidden}">Resources</h4>
                    <ul class="ul1 resource {resource_hidden}">
                        {resources}
                        <li id="res_{resource_id}">
                            <a href="javascript:;" style="border-bottom:1px solid #c8c8c8;color:#111;" onclick="$(this).next().children().click()">
                                <p style="margin: 0;"><span class="icon {type}" style="margin-top: -2px;color: #c8c8c8"></span>&nbsp; {resource_name}</p>
                            </a>
                            <span class="show_resource" style="display:none;">{preview}</span>
                            <div class="r" style="float: right;margin-top: -25px;"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;;padding-right: 14px;padding-bottom: 14px;"><span class="glyphicon glyphicon-remove"></span></a></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix {resource2_hidden}">
                        <button type="submit" onclick=" $('#new_resource').val(1);" class="btn b1 right" href="">Add New Resource <span class="icon i3"></span></button>
                    </div>
                </div>
            </div>
            <input id="subject_id" type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input id="lesson_id" type="hidden" name="lesson_id" value="{lesson_id}" />
            <input id="publish" type="hidden" name="publish" value="{publish}" />
            <input id="parent_publish" type="hidden" name="parent_publish" value="{parent_publish}" />
            <input id="new_resource" type="hidden" name="new_resource" value="0" >
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
            <a href="javascript: publishModal(this);" class="publish_btn {publish_active}" rel="{parent_publish}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
            {create_edit_interactive_lesson}
        </div>
    </div>
</footer>

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
