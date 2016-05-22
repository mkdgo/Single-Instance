<div class="blue_gradient_bg">
    <div class="breadcrumb_container">
        <div class="container"></div>
    </div>
    <div class="container">
        <div class="student_in_wrapper">
            <div class="row align_center">
                <div class="center_if_little w150" >
                    <a href="javascript:;" class="my_classes" style="text-decoration: none; cursor: default; opacity: 0.5; outline: none;"></a>
                    <a class="student_text" href="javascript:;" style="text-decoration: none; cursor: default; opacity: 0.5; outline: none;"><?php echo $lang['b1_my_classes'] ?></a>
                </div>
                <div style="" class="center_if_little w150 " >
                    <div style="display: {dot_hidden}; width: 32px; height: 32px; position: absolute; margin-left: 100px; background: #fff; border-radius: 50%; ">
                        <div style="background: <?php if( $late > 0 ) echo '#e74c3c'; else echo '#333'; ?>; border-radius: 50%; border-color:2px solid #fff; font-size: 16px; color: white; margin:2px 0 0 2px;width: 28px; height: 28px; padding-top: 2px;">{student_assignments}</div>
                    </div>
<!--                    <div style="display: {dot_hidden}; width: 32px; height: 32px; position: absolute; margin-left: 120px; margin-top: 32px; background: #fff; border-radius: 50%; ">
                        <div style="background: #333; border-radius: 50%; border-color:2px solid #fff; font-size: 16px; color: white; margin: 2px 0 0 2px;width: 28px; height: 28px;padding-top: 2px;">{student_assignments}</div>
                    </div>-->
                    <a href="/f1_student"  class="my_homework_student"></a>
                    <a class="student_text" href="/f1_student"><?php echo $lang['b1_my_homework'] ?></a>
                </div>
                <div class="center_if_little w150 " >
                    <a href="/c1" class="my_resources"></a>
                    <a class="student_text" href="/c1"><?php echo $lang['b1_my_resources'] ?></a>
                </div>
                <div style="" class="center_if_little w150 " >
                    <a href="javascript:;" class="my_student_work" style="text-decoration: none; cursor: default; opacity: 0.5; outline: none;"></a>
                    <a class="student_text" href="javascript:;" style="text-decoration: none; cursor: default; opacity: 0.5; outline: none;"><?php echo $lang['b1_my_work'] ?></a>
<!--                    <a href="/g1_student"  class="my_student_work"></a>
                    <a class="student_text" href="/g1_student">My Work</a>  temporary unavailable-->
                </div>                
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

