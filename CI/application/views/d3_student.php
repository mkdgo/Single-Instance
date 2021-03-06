<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container">
        <form class="form-horizontal" action="/d4_student/save" method="post">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h2>{subject_title}</h2>
                    <div class="control-group">
                        <h3 class="label_fix_space">Introduction</h3>
                         <div class="controls">
                             <div class="student_info_block">{subject_intro}</div>
                         </div>
                     </div>
                    <h3 class="label_fix_space">Objectives</h3>
                    <div class="student_info_block">{subject_objectives}</div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    {if modules}
                    <h3 class="label_fix_space">Modules</h3>
                    <ul class="ul3 {hide_modules}">
                        {modules}
                        <li><a href="/d4_student/index/{subject_id}/{module_id}">{module_name}</a></li>
                        {/modules}
                    </ul>
                    {/if}
                </div>
                <!--	<a href="/d5_student/index/{subject_id}/{subject_id}" data-role="button" data-mini="true" class="{hide_add_lesson}">Add new lesson</a>-->
            </div>
            <!--input type="hidden" name="subject_id" value="{subject_id}" /-->
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

