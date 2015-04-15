<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal" action="/d4_student/save" method="post">
            {module}	
            <h2>{module_name}</h2>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="ul2">
                        <li>
                            <h3 class="label_fix_space">Introduction:</h3>
                            <div class="student_info_block">
                            <p>{module_intro}</p>
                            </div>
                        </li>
                        <li>
                            <h3 class="label_fix_space">Objectives:</h3>
                            <div class="student_info_block">
                            <p>{module_objectives}</p>
                            </div>
                        </li>
<!--
                        <li>
                            <h3>Teaching Activities:</h3>
                            <hr class="m2">
                            <p>{module_teaching_activities}</p>
                        </li>
                        <li>
                            <h3>Assessment Opportunities:</h3>
                            <hr class="m2">
                            <p>{module_assessment_opportunities}</p>  
                        </li>
                        <li>
                            <h3>Additional Notes:</h3>
                            <hr class="m2">
                            <p>{module_notes}</p>
                        </li>
                    </ul>
-->


                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <h3 class="label_fix_space">Lessons</h3>
                    <ul class="ul3 {hide_lessons}">
                        {lessons}
                        <li><a href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">{lesson_title}</a></li>
                        {/lessons}
                    </ul>

                    <h3 class="label_fix_space">Resources</h3>
                    <ul class="ul3_resource  {resource_hidden}">
                        {resources}
                        <li><a href="javascript:;" onclick="$(this).next().children().click()"><p><span class="icon {type}"></span>&nbsp; {resource_name}</p></a>
                            <span class="show_resource" style="display:none;">{preview}</span>

                        </li>

                        {/resources}
                    </ul>
                    {/module}
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
        </form>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
    </div>
</footer>

