<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container text-center">
        <div class="row">
            <h2 class="pull-left">Student Search</h2>
        </div>
        <div class="row">
            <h3 class="pull-left">Select a student</h3>
        </div>
        <div class="row clearfix">
            <div class="panel panel-default panel-ediface">
                <div class="panel-heading">
                    <h3 class="panel-title text-left"><strong>{class_name}</strong> - <em>{class_grade}/{class_subject}</em></h3>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            {students}
            <div class="col-sm-12 col-md-6">
                <a class="ediface-student col-sm-12 col-md-11" href="/g1_teacher/student/{subject_id}/{year_id}/{class_id}/{id}">
                    <span class="pull-left">{first_name} {last_name}</span>
                    <span class="pull-right glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
            {/students}
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
