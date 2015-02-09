<!--<div data-role="header" data-position="inline">
<a href="/d2_teacher/index/{module_subject_id}" data-icon="arrow-l">back</a>
<div class="header_search hidden-xs">
<input type="search" id="search" style="" value=""/>
</div>
<h1>View module</h1>
</div>
--><!--
<div style="padding:10px 0 ;background: #ccc;">
<a style="margin-top:0;margin-left:20px;height: 33px;font-size:15px;padding:3px 0 ;width:140px;float:left;" class="right blue_button add_lesson_butt" href="/c1/index/module/{module_id}/{module_subject_id}">ADD</a>
<div class="clear"></div>
</div>-->
<!--<div  class="gray_top_field">
<a  href="javascript:;" onclick="document.getElementById('saveform').submit()" style="margin:0 30px 0 20px;width:350px;float:right;" class="add_resource_butt black_button new_lesson_butt ui-link">SAVE</a>
<div class="clear"></div>
</div>-->
<script src="<?= base_url("/js/tinymce/tinymce.min.js") ?>"></script>
<script src="<?= base_url("/js/d4_teacher.js") ?>"></script>
<script src="<?= base_url("/js/jqBootstrapValidation.min.js") ?>"></script>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal big_label" action="/d4_teacher/save" method="post" id="saveform">
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
                    <label class="label_fix">Plenary Objectives:</label>
                    <div class="keywords" id="keywords" data-url="/d4_teacher/suggestKeywords">
                        <input type="text" id="module_plenary_keywords"  name="module_plenary_keywords" value="{module_plenary_keywords}" style="display: none;" />
                        <input type="hidden" id="module_plenary_keywords_a" name="module_plenary_keywords_a" value="{module_plenary_keywords}" />
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
                    <!--<div class="row gray_backg100 ">
                    <div class="switch" data-role="fieldcontain">
                    <label for="flip-b" class="text_label">Publish</label><br />
                    <select name="publish" id="flip-b" data-role="slider">
                    <option value="0" {module_publish_0}>No</option>
                    <option value="1" {module_publish_1}>Yes</option>
                    </select> 
                    </div> 
                    </div>-->






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
                        <a class="btn b1 right" href="/c1/index/module/{module_id}/{module_subject_id}">ADD<span class="icon i3"></span></a>
                    </div>

                </div>
                <!--	<a href="/d5_teacher/index/{subject_id}/{module_id}" data-role="button" data-mini="true" class="{hide_add_lesson}">Add new lesson</a>-->
            </div>
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="subject_id" value="{module_subject_id}" />
            <input id="publish" type="hidden" name="publish" value="{module_publish}" >
            <button type="submit" name="submit" value="true" class="hidden_submit" style="display: none;">SAVE</button>

        </form>
    </div>

    <!--   <a href="#" onclick="document.getElementById('saveform').submit()">Submit the Form</a> -->
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
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
        </div>
    </div>
</footer>

