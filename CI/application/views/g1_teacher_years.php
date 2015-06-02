<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumbs}</div>
    </div>
    <div class="container text-center">
        <div class="row">
            <h2 class="pull-left">Student Search</h2>
        </div>
        <div class="row">
            <h3 class="pull-left">Select a class</h3>
        </div>
        <div class="row clearfix">
            {classes}
            <div class="pull-left ediface_box">
                <a href="/g1_teacher/studentclass/{subject_id}/{year_id}/{id}">{year}{group_name}</a>&nbsp;&nbsp;
            </div>
            {/classes}
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="Ediface Logo" src="/img/logo_s.png"></div>
    </div>
</footer> 
