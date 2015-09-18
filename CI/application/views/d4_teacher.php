<!--<script src="<?=base_url("/js/tinymce/tinymce.min.js")?>"></script>-->
<!--<script type="text/javascript">loadTinymce();</script>-->
<script src="<?=base_url("/js/d4_teacher.js")?>"></script>
<script src="<?=base_url("/js/jqBootstrapValidation.min.js")?>"></script>
<script type="text/javascript" src="<?= base_url("/js/nicEdit/nicEdit.js") ?>"></script>
<script type="text/javascript">
    bkLib.onDomLoaded(function() { 
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
//            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('module_intro');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
//            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('module_objectives');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
//            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('module_teaching_activities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
//            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('module_assessment_opportunities');
        new nicEditor({
            buttonList : ['bold','italic','underline','left','center','justify','ol','ul','removeformat','forecolor','bgcolor','link','unlink','fontSize','fontFamily'],
//            iconsPath : '<?=  base_url("/js/nicEdit/nicEditorIcons.gif") ?>'
        }).panelInstance('module_notes');
    })
</script>

<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal big_label" action="/d4_teacher/save" method="post" id="saveform" name="saveform">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 5px;">
                    <div data-role="fieldcontain">
                        <label for="module_name" class="label_fix_space">Module Title:</label>
                         <div class="controls">
                            <span></span>
                            <input type="text" value="{module_name}" class="module_title required encoded" data-validation-required-message="Please provide a title for this module" name="module_name" id="module_name" placeholder="Enter text..." required>
                        </div>
                    </div>

                    <div data-role="fieldcontain">
                        <label for="module_intro" class="label_fix_space">Intro:</label>
                        <textarea name="module_intro" id="module_intro" placeholder="enter text..." class="textarea_fixed encoded mce-toolbar-grp">{module_intro}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_objectives" class="label_fix_space">Objectives:</label>
                        <textarea name="module_objectives" id="module_objectives" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp encoded">{module_objectives}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_teaching_activities" class="label_fix_space">Teaching Activities:</label>
                        <textarea name="module_teaching_activities" id="module_teaching_activities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp encoded">{module_teaching_activities}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_assessment_opportunities" class="label_fix_space">Assessment Opportunities:</label>
                        <textarea name="module_assessment_opportunities" id="module_assessment_opportunities" placeholder="enter text..." class="textarea_fixed mce-toolbar-grp encoded">{module_assessment_opportunities}</textarea>
                    </div>
                    <div data-role="fieldcontain">
                        <label for="module_notes" class="label_fix_space">Notes:</label>
                        <textarea name="module_notes" id="module_notes" placeholder="enter text..." class="module_notes mce-toolbar-grp encoded">{module_notes}</textarea>
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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
                    <h4 class="{hide2_lessons}">Lessons</h4>
                    <ul class="ul3 {hide_lessons}">
                        {lessons}
                        <li><a href="/d5_teacher/index/{subject_id}/{module_id}/{lesson_id}">{lesson_title}</a></li>
                        {/lessons}
                    </ul>
                    <div class="buttons clearfix">
                        {add_new_lesson}
                    </div>
                    <br />
                    <h4 class="{hide2_lessons}">Resources</h4>
                    <ul class="ul1 resource {resource_hidden}">
                        {resources}
                        <li id="res_{resource_id}">
                            <a href="javascript:;" style="border-bottom:1px solid #c8c8c8;color:#111;" onclick="$(this).next().children().click()">
                                <p style="margin: 0;"><span class="icon {type}" style="margin-top: -2px;color: #c8c8c8"></span>&nbsp; {resource_name}</p>
                            </a>
                            <span class="show_resource" style="display:none;">{preview}</span>
                            <div class="r" style="float: right;margin-top: -25px;"><a href="javascript: resourceModal({resource_id})" class="remove" style="font-size: 0;padding-right: 14px;padding-bottom: 14px;"><span class="glyphicon glyphicon-remove"></span></a></div>
                        </li>
                        {/resources}
                    </ul>
                    <div class="buttons clearfix {hide2_lessons}">
                        <button type="submit" onclick=" $('#new_resource').val(1);" class="btn b1 right" href="">Add New Resource<span class="icon i3"></span></button>
                    </div>
                </div>
            </div>
            <input id="module_id" type="hidden" name="module_id" value="{module_id}" />
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
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" rel="{parent_publish}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
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
