<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container"></div>
    </div>
    <div class="container">
        <div class="student_in_wrapper">
            <div class="row align_center">
                <div class="center_if_little w150 " >
                    <a href="/c1" class="my_resources"></a>
                    <a class="student_text" href="/c1"><?php echo $lang['b2_resources'] ?></a>
                </div>
                <div class="center_if_little w150" >
                    <a href="/d1" class="my_classes"></a>
                    <a class="student_text " href="/d1"><?php echo $lang['b2_curriculum'] ?></a>
                </div>
                <div class="center_if_little w150 " >
                    <a href="javascript:;" onclick="$('#infoModal').modal('show');" class="my_homework_student subject_icon"></a>
                    <a href="javascript:;" class="student_text" onclick="$('#infoModal').modal('show');"><?php echo $lang['b2_homework'] ?></a>
                </div>
                <div class="center_if_little w150 " >
                    <a href="/g1_teacher" class="students subject_icon"></a>
                    <a class="student_text" href="/g1_teacher"><?php echo $lang['b2_students'] ?></a>
                </div>
<?php if( DEMO == 1 ): ?>
                <div class="center_if_little w150 " >
                    <a href="/r2_teacher" class="reports subject_icon"></a>
                    <a class="student_text" href="/r2_teacher"><?php echo $lang['b2_reports'] ?></a>
                </div>
<?php endif ?>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height: 1px;"></div>
<footer>
    <div class="container clearfix">
        <div class="left">Powered by <img alt="" src="/img/logo_s.png"></div>
        <div class="right">
        </div>
    </div>
</footer>

<div id="infoModal" class="modal fade" style="top: 10%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header2"><a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a></div>
            <div class="feedback-modal-header"><h4 class="modal-title">Homework</h4></div>
            <div id="feedback_details" style="margin: 50px auto; display: block; padding: 0 15px; text-align: center;">
                <div class="center_if_little w150 " >
                    <a href="javascript:;" onclick="redirect('f1_teacher')" class="default_circle_icon subject_icon" style="font-size: 50px; color: #e74c3c;"><span style="top: 27%;" class="glyphicon glyphicon-search"></span></a>
                    <a href="javascript:;" onclick="redirect('f1_teacher');" class="student_text" >Homework<br />Search</a>
                </div>
                <div class="center_if_little w150 " >
                    <a href="javascript:;" onclick="redirect('f2c_teacher')" class="default_circle_icon subject_icon" style="font-size: 50px; color: #e74c3c;"><span style="top: 27%;" class="glyphicon glyphicon-plus"></span></a>
                    <a href="javascript:;" onclick="redirect('f2c_teacher');" class="student_text" >Create New Homework</a>
                </div>
            </div>
            <div class="feedback-modal-footer feedback-buttons" style="background: #fff;">
                <button type="button" class="btn green_btn" id="submit_feedback" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function redirect(url) {
        $('#infoModal').modal('hide');
        document.location = url;
    }
</script>
