<!DOCTYPE html>
<html>
<head>        
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
    <meta charset="utf-8">        

    <link rel="apple-touch-icon" href="<?= base_url("/css/touch-icon-iphone.png") ?>" /> 
    <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url("/css/touch-icon-ipad.png") ?>" /> 
    <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url("/css/touch-icon-iphone.png") ?>" />
    <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url("/css/touch-icon-ipad.png") ?>" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>EDIFACE</title>				

    <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <!-- Bootstrap -->
    <link href="<?= base_url("/css/bootstrap.css") ?>" rel="stylesheet" media="screen">        
    <link rel="stylesheet" href="<?= base_url("/css/jquery.mobile.structure-1.3.2.min.css") ?>" type="text/css"/>        
        <!--<link rel="stylesheet" href="<?= base_url("/css/jquery.mobile.theme-1.3.2.min.css") ?>" type="text/css"/>
        <!-- REMOVE IN FINAL VERSION, CONFLICTS WITH COLORBOX! -->        
    <link rel="stylesheet" href="<?= base_url("/css/newcss.css") ?>" type="text/css"/>				
    <link rel="stylesheet" href="<?= base_url("/css/colorbox.css") ?>" type="text/css"/>   		
    <link rel="stylesheet" href="<?= base_url("/css/style.css") ?>" type="text/css"/>    

    <script src="<?= base_url("/js/jquery.js") ?>"></script> 

    <script type="text/javascript">
        $(window).load(function () {
            setSizes();
        });

        $(window).resize(function () {
            setSizes();
        });

        function setSizes() {
            var mt = parseFloat($(window).height()) / 2;
            var mt = mt - parseFloat($('#login_form_wrap').height()) / 2;
            $('#login_form_wrap').css('margin-top', mt + 'px');
        }
            
    </script>
    <style type="text/css">
        .login_top_text {
            font-size: 20px;
            color: #fff;
            text-shadow: none !important;
        }
    </style>
</head>
<body onload="auto_logout()">
    <div class="rred_gradient_bg" >
        <div  class="container">
            <div class="form-group">
                <div  class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
                <div id="login_form_wrap" style="" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                    <div  class="logo_holder_div"  >
                        <br />
                    </div>
                    <div class="align_center login_top_text" style="color: #000; font-weight: bold; margin-bottom: 15px;">THANK YOU FOR USING EDIFACE.</div>
                    <div class="align_center login_top_text" style="margin: 0 25px 25px; line-height: 1.3;">You will now be redirected to OneLogin in a few moments. If you would like to log in to Ediface as another user, you will need to:</div>
                    <div class="align_center login_top_text" style="margin: 0 25px 25px;line-height: 1.3;">
1. Log out of OneLogin<br /> 2. Log in to OneLogin again as the other user<br /> 3. Select Ediface from the App Menu.
                    </div>
                    <div class="align_center login_top_text" style="margin: 0 25px 25px;line-height: 1.3;">
We hope that you have enjoyed using the system. Please continue to give us your feedback to let us know what you think:<br /> 
<a style="color: #454545;" href="mailto: support@ediface.org">support@ediface.org</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var logout_sec = 10;
        function auto_logout() {
            timer1 = setInterval("redirect()", 1000);
        }
        function redirect() {
            logout_sec--;
console.log(logout_sec);
            if( logout_sec < 1 ) {
                window.location.href ="/logout/";
            }
        }
    </script>
</body>
</html>
