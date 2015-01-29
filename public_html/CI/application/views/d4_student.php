
<!--div  class="gray_top_field">
<a href="/d4_student/index/{subject_id}" style="margin:0 30px 0 20px;" class="add_resource_butt black_button new_lesson_butt ui-link">ADD NEW MODULE</a>
<div class="clear"></div>
</div-->
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
                            <h3>Introduction:</h3>
                            <hr class="m2">
                            <p>{module_intro}</p>
                        </li>
                        <li>
                            <h3>Objectives:</h3>
                            <hr class="m2">
                            <p>{module_objectives}</p>
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
                    <h3>Resources</h3>
                    <ul class="ul1 resources  {resource_hidden}">
                        {resources}
                        <li>
                            <div class="r">{preview}</div>
                            <div class="t"><span title="{resource_name}">{resource_name}</span></div>
                        </li>
                        {/resources}
                    </ul>
                    {/module}
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                    <h3>Lessons</h3>
                    <ul class="ul3 {hide_lessons}">
                        {lessons}
                        <li><a href="/d5_student/index/{subject_id}/{module_id}/{lesson_id}">{lesson_title}</a></li>
                        {/lessons}
                    </ul>
                </div>
            </div>
            <input type="hidden" name="subject_id" value="{subject_id}" />
        </form>
    </div>
</div>
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
    </div>
</footer>

