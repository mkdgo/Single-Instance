<div  class="gray_top_field">
	<a  href="javascript:;" onclick="document.getElementById('int_assessment_form').submit()" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">SAVE</a>
    <!--a  href="javascript:;" onclick="document.getElementById('int_assessment_form').submit()" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">ADD NEW QUESTION</a-->
    <div class="clear"></div>
</div>    
<!--div data-role="header" data-position="inline">

	<a href="/e1_teacher/index/{subject_id}/{module_id}/{lesson_id}" data-icon="arrow-l">back</a>
	<div class="header_search hidden-xs">
		<input type="search" id="search" style="" value=""/>
	</div>
	<h1>Create interactive assessment</h1>
</div-->

<div class="blue_gradient_bg">
    <br/>{breadcrumb}<br/>
	<div class="container">
		<div class="row question_box hidden">
		    <div class="gray_backg100 ">
        	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				    <strong>Question / Statement</strong><br/><br />
			    </div>
			    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
				    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> <!-- align_center -->
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
		</div>
		<div class="row">
			<form method="post" action="/e3/save/" id="int_assessment_form">
				<!--div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12">
					<input type="submit" value="Save interactive assessment" data-role="button" data-theme="g" />
				</div-->
				<div id="questions_wrap">
					{questions}
					<div class="row question_box">
						<div class="gray_backg100 ">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<strong>Question / Statement</strong><br/>
							</div>
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"> <!-- align_center -->
									{question_resource_img_preview}
									<input type="hidden" class="resource_id" name="questions[{question_num}][question_resource_id]" value="{question_resource_id}" />
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<input type="text" name="questions[{question_num}][question_text]" value="{question_text}" class="question_text" placeholder="enter text..."/>
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<a href="/c1/index/question/{question_num}/{subject_id}/{module_id}/{lesson_id}/{int_assessment_id}" class="margin_top_7px add_q_ressource red_button add_lesson_butt" >add resource</a>
										</div>
									</div>
								</div>
							</div><br/>
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
						</div>
					</div>
					{/questions}
				</div>
				<div class="row add_question">
					<div class="col-lg-12 col-md-12 col-sm-12 col-sm-12 col-xs-12">
						<a href="#" class="blue_button add_lesson_butt margin_top_7px">Add question</a>
					</div>
				</div>
				<input type="hidden" name="subject_id" class="subject_id" value="{subject_id}" />
				<input type="hidden" name="module_id" class="module_id" value="{module_id}" />
				<input type="hidden" name="lesson_id" class="lesson_id" value="{lesson_id}" />
				<input type="hidden" name="int_assessment_id" class="int_assessment_id" value="{int_assessment_id}" />					
            </form>
        </div><br/>
    </div>
</div>