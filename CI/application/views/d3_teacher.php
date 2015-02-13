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
                        <button type="submit" name="redirect" value="{subject_id}" style="border: none; float: right;margin-right: -3px;background-color: transparent;"><a class="btn b1 right" href="javascript:;">ADD NEW MODULE<span class="icon i3"></span></a></button>
                    </div>

                </div>
            </div>

            <?php /*
                <div class="form-group">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="title_backg100 row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                <span class="lesson_title">{subject_title}</span>
                </div>
                </div>
                <div class="gray_backg100 row">

                <div data-role="fieldcontain">        
                <label for="subject_intro" class="label_fix">Intro:</label>
                <textarea name="subject_intro" id="subject_intro" placeholder="enter text..." class="textarea_fixed">{subject_intro}</textarea>
                </div>
                <div data-role="fieldcontain">
                <label for="subject_objectives" class="label_fix">Objectives:</label>
                <textarea name="subject_objectives" id="subject_objectives" placeholder="enter text..." class="textarea_fixed">{subject_objectives}</textarea>
                </div>
                <div data-role="fieldcontain">
                <label for="subject_teaching_activities" class="label_fix">Teaching Activities:</label>
                <textarea name="subject_teaching_activities" id="subject_teaching_activities" placeholder="enter text..." class="textarea_fixed">{subject_teaching_activities}</textarea>
                </div>
                <div data-role="fieldcontain">
                <label for="subject_assessment_opportunities" class="label_fix">Assessment Opportunities:</label>
                <textarea name="subject_assessment_opportunities" id="subject_assessment_opportunities" placeholder="enter text..." class="textarea_fixed">{subject_assessment_opportunities}</textarea>
                </div>
                <div data-role="fieldcontain">
                <label for="subject_notes" class="label_fix">Notes:</label>
                <textarea name="subject_notes" id="subject_notes" placeholder="enter text..." class="subject_notes">{subject_notes}</textarea>
                </div>

                </div>

                <div class="row gray_backg100 ">
                <div class="switch" data-role="fieldcontain">
                <label for="flip-b" class="text_label">Publish</label><br />
                <select name="publish" id="flip-b" data-role="slider">
                <option value="0" {module_publish_0}>No</option>
                <option value="1" {module_publish_1}>Yes</option>
                </select> 
                </div> 
                </div>

                <div class="row"><!--
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                &nbsp;
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <input type="submit" value="Save" data-theme="g" />
                </div>-->
                </div>       
                <!--div class="row gray_backg100 ">
                <div>
                <div class="row col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <label style="font-weight: normal;font-size:1.2em">Feedback</label>
                </div>
                </div>
                <div class="clear"></div>
                <div  class="res_row_each row col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="res_row">
                <div class=" col-lg-9 col-md-9 col-sm-9 col-xs-9 label_fix">
                <strong class="fdb_date">15/04/2013</strong>  text tasd astext tasd astext tasd astext tasd asd asd asd 
                </div>
                <div style="padding-right:0;float:right;;" class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <a class="delete_button right" href="#">Delete</a>
                </div>
                <div class="clear"></div>
                </div>
                </div>
                </div-->
                <div class="row hidden gray_backg100 ">
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
                <div class="lessons_box">
                <h3>Modules</h3>
                <div class="lessons">
                <div class="{hide_modules}">
                {modules}
                <a class="lesson_button" href="/d4_teacher/index/{subject_id}/{module_id}">
                <img src="/img/red_arrow_gray_sub_button.png"/>{module_name}</a>
                {/modules}
                </div>
                <a href="/d4_teacher/index/{subject_id}" class="red_button new_lesson_butt">ADD NEW MODULE</a>
                </div>
                </div>
                <!--	<a href="/d5_teacher/index/{subject_id}/{module_id}" data-role="button" data-mini="true" class="{hide_add_lesson}">Add new lesson</a>-->
                </div>
            </div> */ ?>
            <!--input type="hidden" name="module_id" value="{module_id}" /-->
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="subject_curriculum_id" value="{subject_curriculum_id}" />
            
            <input id="publish" type="hidden" name="publish" value="{subject_publish}" />
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
            <a href="javascript: publishModal();" class="publish_btn {publish_active}" style="text-decoration: none;"><span>{publish_text}</span></a>
            <a href="javascript:" onclick="validate()" class="red_btn">SAVE</a>
            
        </div>
    </div>
</footer>


