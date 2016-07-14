<!DOCTYPE html><html>    
    <head>        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
        <meta charset="utf-8">        

        <link rel="apple-touch-icon" href="<?= base_url("/css/touch-icon-iphone.png") ?>" /> 
        <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url("/css/touch-icon-ipad.png") ?>" /> 
        <link rel="apple-touch-icon" sizes="120x120" href="<?= base_url("/css/touch-icon-iphone.png") ?>" />
        <link rel="apple-touch-icon" sizes="152x152" href="<?= base_url("/css/touch-icon-ipad.png") ?>" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>View lesson</title>				

        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
        <!-- Bootstrap -->
        <link href="<?= base_url("/res/css/bootstrap.css") ?>" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="<?= base_url("/res/css/jquery.mobile.structure-1.3.2.min.css") ?>" type="text/css"/>        
        <!--<link rel="stylesheet" href="<?= base_url("/css/jquery.mobile.theme-1.3.2.min.css") ?>" type="text/css"/>
        <!-- REMOVE IN FINAL VERSION, CONFLICTS WITH COLORBOX! -->
        <link rel="stylesheet" href="<?= base_url("/res/css/newcss.css") ?>" type="text/css"/>				
        <link rel="stylesheet" href="<?= base_url("/res/css/colorbox.css") ?>" type="text/css"/>   		
        <link rel="stylesheet" href="<?= base_url("/res/css/style.css") ?>" type="text/css"/>    

        <script src="<?= base_url("/res/js/jquery.js") ?>"></script> 
        <script src="<?= base_url("/res/js/main.js") ?>"></script>        
        <script src="<?= base_url("/res/js/js_visuals.js") ?>"></script>

        <script type="text/javascript">
            user_id = '{user_id}';
            user_type = '{user_type}';
            profile_missing_data = "{profile_missing_data}";
            $(window).load(function () {
                setSizes();
                $("#dialog_profileInfo").popup({
                    afterclose: function (event, ui) {
                        window.location = "/";
                    }
                });

                if (profile_missing_data == "1")
                    $("#dialog_profileInfo").popup("open");
            });

            $(window).resize(function () {
                setSizes();
            });

            function setSizes() {
                var mt = parseFloat($(window).height()) / 2;
                var mt = mt - parseFloat($('#login_form_wrap').height()) / 2;
                $('#login_form_wrap').css('margin-top', mt + 'px');
            }
            
            $(document).ready(function () {
                $('#forgotten-password').click(function() {
                   document.location = '/a1/passwordrecovery'; 
                });
            });
        </script>				    
    </head>
    <body>
        <div style="width: 300px; height: 170px; background-color: #c72d2d;" data-role="popup" id="dialog_profileInfo" data-overlay-theme="b" data-theme="b">
            <!--<a href="#" data-rel="back" style="background-color: #c72d2d;" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-btn-right">X</a>-->
            <div style="margin: 15px;">
                <form action="/a1" method="post">
                    <input type="hidden" name="action" value="verify" />
                    <input type="hidden" name="openid_identifier" value="{esc_identity}" />
                    <div data-role="fieldcontain">
                        <label for="select-choice-1" style="font-size: 15px;">CHOOSE YOUR ACCOUNT TYPE</label>
                        <select name="account_type">
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    </div>
                    <div  style="margin-top:10px;margin-left:5px;" class="log_submit">
                        <input type="submit" value="Save and Login" />
                    </div>
                </form>
            </div>
        </div>

        <div class="rred_gradient_bg" >
            <div  class="container">
                <div class="form-group">
                    <div  class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
                    <div id="login_form_wrap" style="" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                        <div  class="logo_holder_div"  >
                            <img src="<?php echo base_url()?>img/Ediface_White.png" />
                            <br />
                        </div>
                        <form id="login_form" method="post">
                            <!-- <div class="align_center">
                            <img class="mt10p" src="/img/logo_login.png" />
                            </div><br/>-->
                            <div class="align_center login_top_text">ENTER ACCOUNT<span style="color: #343434">INFORMATION</span>
                                <div class="down_arrow_white">&nbsp;</div>
                            </div>
                            <!--  <label for="login_email">Login:</label>-->
                            <div  style="margin-top:10px;margin-left:5px;" class="log_submit">
                            <input type="email" class="not_so_cool_input " name="login_email" id="login_email" value="" placeholder="Type your email" />
                            <!-- <label for="login_Password" class="label_fix">Password:</label>-->
                            </div>
                            <div  style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input type="password" class="not_so_cool_input" name="login_password" id="login_Password" value="" placeholder="Password" />
                            </div>
                                <h4 class="login_error">{login_error}</h4>
                            <div  style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input type="submit" value="SIGN IN" />
                            </div>
                            <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input id="forgotten-password" type="button" value="FORGOTTEN PASSWORD? CLICK HERE" />
                            </div>
                            <div class="login_stuff">
                                <!--a href="#" class="left">Forgot your password ?</a>
                                <a href="#" class="right">Register</a-->
                                <div class="clear"></div>
                            </div>
                        </form>
                        <form method="post" class="hidden">
                            <input type="hidden" name="action" value="verify" />
                            <div style="margin-top:30px;" class="align_center login_top_text">ENTER OPENID <span class="black">URL</span>
                                <div class="down_arrow_white">&nbsp;</div>
                            </div>
                            <input class="not_so_cool_input" type="text" name="openid_identifier" value="" />
                            <h4>{openid_msg}{openid_error}{openid_success}</h4>
                            <div  style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input type="submit" value="VERIFY OPENID" />
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
                </div>
            </div>
        </div>