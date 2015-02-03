<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal" action="/d4_student/save" method="post">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h2>{subject_title}</h2>
                    <ul class="ul2">
                        <li>
                            <h3>Introduction:</h3>
                            <hr class="m2">
                            <p>{subject_intro}</p>
                        </li>
                        <li>
                            <h3>Objectives:</h3>
                            <hr class="m2">
                            <p>{subject_objectives}</p>
                        </li>
<!--                        <li>
                            <h3>Teaching Activities:</h3>
                            <hr class="m2">
                            <p>{subject_teaching_activities}</p>
                        </li>
                        <li>
                            <h3>Assessment Opportunities:</h3>
                            <hr class="m2">
                            <p>{subject_assessment_opportunities}</p>  
                        </li>
                        <li>
                            <h3>Additional Notes:</h3>
                            <p>{subject_notes}</p>
                        </li>
-->
                    </ul>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                    <h3>Modules</h3>
                    <ul class="ul3 {hide_modules}">
                        {modules}
                        <li><a href="/d4_student/index/{subject_id}/{module_id}">{module_name}</a></li>
                        {/modules}
                    </ul>
                </div>
                <!--	<a href="/d5_student/index/{subject_id}/{subject_id}" data-role="button" data-mini="true" class="{hide_add_lesson}">Add new lesson</a>-->
            </div>
            <!--input type="hidden" name="subject_id" value="{subject_id}" /-->
            <input type="hidden" name="subject_id" value="{subject_id}" />
        </form>
    </div>
</div>
<br />
<footer>
    <div class="container clearfix">
        <div class="left unvisible">Powered by <img alt="" src="/img/logo_s.png"></div>
    </div>
</footer>