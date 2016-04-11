<!--<div  class="gray_top_field">
	<a  href="javascript:;" onclick="document.getElementById('int_assessment_form').submit()" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">SAVE</a>
    <div class="clear"></div>
</div>-->
<!--div data-role="header" data-position="inline">

	<a href="/e1_teacher/index/{subject_id}/{module_id}/{lesson_id}" data-icon="arrow-l">back</a>
	<div class="header_search hidden-xs">
		<input type="search" id="search" style="" value=""/>
	</div>
	<h1>Create interactive assessment</h1>
</div-->
<style type="text/css">
    span.select { background: #fff;line-height: 28px; font-size: 15px; padding: 16px; height: 62px;}
    span.select .a { height: 62px; }
</style>
<div class="blue_gradient_bg">
    <div class="breadcrumb_container"><div class="container">{breadcrumb}</div></div>
	<div class="container">
<!--		<div class="row question_box hidden">
		    <div class="gray_backg100 ">
        	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <strong>Question / Statement</strong><br/><br />
			    </div>
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
				    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
					    <img src="/uploads/resources/temp/default.jpg" class="img_200x150"/>
					    <input class="resource_id" type="hidden" value="" name="">
				    </div>
				    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					    <input type="text" name="" class="question_text" placeholder="enter text..."/>
					    <div class="row">
						    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
							    <a href="/c1/index/question/{question_num}/{subject_id}/{module_id}/{lesson_id}/{int_assessment_id}" class="margin_top_7px add_q_ressource red_button add_lesson_butt">add resource</a>
						    </div>
					    </div>
				    </div>
			    </div>
                <br/>
		    </div>
		    <div class="gray_backg100 ">
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
				    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					    <input type="text" name="add_option_text" class="add_option_text" placeholder="Type the next option here"/>
				    </div>

				    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					    <a href="#" class="margin_top_7px add_option blue_button">Add option</a>
				    </div>
			    </div><br/>
						    
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 options">
				    <strong>Options</strong>
			    </div>
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row q_options_list">
				    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row hidden q_option">
					    <div class="margin_top_7px col-lg-1 col-md-1 col-sm-1 col-xs-1">
						    <a href="#" data-role="button" data-theme="f" data-icon="delete" data-iconpos="notext" class="margin_center_fix delete_option"></a>
					    </div>
					    <div class="margin_top_10px col-lg-9 col-md-9 col-sm-9 col-xs-9">
						    <input type="text" name="" class="option_text" data-mini="true"/>
					    </div>
					    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						    <div class="ui-switch">
							    <select name="" class="answer" data-mini="true" data-role="slider" id="0">
								    <option value="0">False</option>
								    <option value="1">True</option>
							    </select>
						    </div>
					    </div>
				    </div>
			    </div>
		    </div>
		</div>-->
        <form action="/e3/save/" method="post" class="form-horizontal big_label" id="saveform" >
            <h2>{head_title}</h2> 
		    <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding-right: 5px;">
                    <label class="label_fix_space" for="content_title" style="line-height: 48px;">Title</label>
                    <div class="controls">
                        <span></span>
                        <input type="text" name="content_title" value="{cont_page_title}" id="content_title" autocomplete="off" class="required"  placeholder="Enter text..."  minlength="2"  data-validation-required-message="Please provide a title for this slide">
                    </div>
                    <label class="label_fix_space" for="content_text" style="line-height: 48px;">Intro</label>
                    <div class="controls">
                        <span></span>
                        <textarea name="content_text" id="content_text" class="textarea_fixed mce-toolbar-grp" placeholder="Enter text..." style="height: 150px;" >{cont_page_text}</textarea>
                    </div>
                </div>
            </div>
            <br />



<!--			<form method="post" action="/e3/save/" id="int_assessment_form">-->
				<!--div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12">
					<input type="submit" value="Save interactive assessment" data-role="button" data-theme="g" />
				</div-->
            <div id="questions_wrap"  class="row gray_backg100" style="margin-left: 0; margin-right: 0;">
                {questions}
                <div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12" style="display: inline-block;">
    				<div class="col-lg-6 col-md-6 col-sm-6 col-sm-6 col-xs-12">
<!--					<div class="question_box">
						<div class=" ">-->
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">Question / Statement</label>
                        <div class="controls">
                            <span></span>
                            <input type="text" name="questions[{question_num}][question_text]" value="{question_text}" id="content_title" autocomplete="off" class="required"  placeholder="Enter text..."  minlength="2"  data-validation-required-message="Please provide a title for this slide">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-sm-6 col-xs-12">
<!--                    <div class="question_box">
                        <div class="gray_backg100 ">-->
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">Type</label>
                        <div class="controls">
                            <span></span>
                            <select onChange="" name="questions[{question_num}][question_type]" id="classes_year_select" data-validation-required-message="Please select quiz type">
                                <option class="classes_select_option" value="0"></option>
                                <option class="classes_select_option" value="drag_word">Drag Word</option>
                                <option class="classes_select_option" value="one_choise">One Choice</option>
                                <option class="classes_select_option" value="multiple_select">Multiple Select</option>
                            </select>
                        </div>
                    </div>
                </div>

<!--							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<strong>Question / Statement</strong><br/>
							</div>-->
<!--							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> 
									{question_resource_img_preview}
									<input type="hidden" class="resource_id" name="questions[{question_num}][question_resource_id]" value="{question_resource_id}" />
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<input type="text" name="questions[{question_num}][question_text]" value="{question_text}" class="question_text" placeholder="enter text..."/>
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<a href="/c1/index/question/{question_num}/{subject_id}/{module_id}/{lesson_id}/{int_assessment_id}" class="margin_top_7px add_q_ressource red_button add_lesson_butt" >add resource</a>
										</div>
									</div>
								</div>
							</div>
                            <br/>-->
<!--						</div>-->
						
<!--						<div class="gray_backg100 ">-->
        				    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">Option Label</label>
                                    <input type="text" name="add_option_text" class="add_option_text" placeholder="Type the next option here"/>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">Option Value</label>
                                    <input type="text" name="add_option_text" class="add_option_text" placeholder="Type the next option here"/>
                                </div>
							    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">&nbsp; </label>
								    <input type="text" name="add_option_text" class="add_option_text" placeholder="Type the next option here"/>
							    </div>

							    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <label class="label_fix_space" for="content_text" style="line-height: 48px;">&nbsp;</label>
								    <a href="#" class="margin_top_7px add_option blue_button">Add option</a>
							    </div>
						    </div><br/>
						    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 options">
							    <strong>Options</strong>
						    </div>
						    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row q_options_list">
							    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row hidden q_option">
								    <div class="margin_top_7px col-lg-1 col-md-1 col-sm-1 col-xs-1">
									    <a href="#" data-role="button" data-theme="f" data-icon="delete" data-iconpos="notext" class="margin_center_fix delete_option"></a>
								    </div>
								    <div class="margin_top_10px col-lg-9 col-md-9 col-sm-9 col-xs-9">
									    <input type="text" name="" class="option_text" data-mini="true"/>
								    </div>
								    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									    <div class="ui-switch">
										    <select name="" class="answer" data-mini="true" data-role="slider" id="0">
											    <option value="0">False</option>
											    <option value="1">True</option>
										    </select>
									    </div>
								    </div>
							    </div>
							    {answers}
							    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row q_option">
								    <div class="margin_top_7px col-lg-1 col-md-1 col-sm-1 col-xs-1">
									    <a href="#" data-role="button" data-theme="f" data-icon="delete" data-iconpos="notext" class="margin_center_fix delete_option"></a>
								    </div>
								    <div class="margin_top_10px col-lg-9 col-md-9 col-sm-9 col-xs-9">
									    <input type="text" name="questions[{question_num}][answers][{answer_num}][answer_text]" value="{answer_text}" class="option_text" data-mini="true"/>
								    </div>
								    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
									    <div class="margin_top_4px ui-switch">
										    <select name="questions[{question_num}][answers][{answer_num}][answer_true]" value="{answer_true}" class="answer" data-mini="true" data-role="slider" id="0">
											    <option {answer_true_0} value="0">False</option>
											    <option {answer_true_1} value="1">True</option>
										    </select>
									    </div>
								    </div>
							    </div>
							    {/answers}
						    </div>
<!--						</div>-->
<!--					</div>-->
				{/questions}
			</div>
			<div class="row add_question">
				<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12">
					<a href="#" class="blue_button add_lesson_butt margin_top_7px">Add question</a>
				</div>
			</div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
            <input type="hidden" name="year_id" value="{year_id}" />
            <input type="hidden" name="module_id" value="{module_id}" />
            <input type="hidden" name="lesson_id" value="{lesson_id}" />
            <input type="hidden" id="cont_page_id" name="cont_page_id" value="{cont_page_id}" />
            <input type="hidden" name="is_preview" class="is_preview" value="0" />


			<input type="hidden" name="int_assessment_id" class="int_assessment_id" value="{int_assessment_id}" />					
<!--            </div><br/>-->
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<prefooter><div class="container"></div></prefooter>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="javascript:;" onclick="document.getElementById('int_assessment_form').submit()" id="saveBT" class="red_btn" style="margin-left: 0px;">SAVE</a>
        </div>
    </div>
</footer>
