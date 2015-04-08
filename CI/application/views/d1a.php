<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container">{breadcrumb}</div>
    </div>
    <div class="container text-center">
        <div class="row clearfix ">
        {years}
        <div class="{plus_class} subject_center_if_little w150" >
            <a href="/d2_teacher/index/{subject_id}/{id}"  class="subject_year{year} subject_icon">
                <!--  <div style="padding-top: 60px;" class="student_text subject_text">{name}</div> -->
            </a>
        </div>
        {/years}
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
            <a href="/d1b/curriculum/{subject_id}/{subject_curriculum_id}"  style="margin:0 30px 0 20px;" class="red_btn ">VIEW {subject_title} CURRICULUM</a>
        </div>
    </div>
</footer> 
