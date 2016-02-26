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
        <style type="text/css">
            .select { background: #faffbd; width: 85%; margin: 0 auto; }
            .modal-title { margin: 25px; }
            .modal-body { background: none repeat scroll 0 0 #eee; margin-left: auto; margin-right: auto; padding: 10px 0 15px; position: relative; text-align: center; width: 94%; }
        </style>
        <script src="<?= base_url("/js/main.js") ?>"></script>
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

            function confirmPublish(e) {
                e.preventDefault;
                $('#popupPubl').modal('show');
            }

            function doPubl(){
                $('#popupPubl').modal('hide');
                $('#login_form').submit();
            }

            function undoPubl(){
                $('#login_email').val(0);
                $('.v').html('Choose user');
                $('#popupPubl').modal('hide');
            }
        </script>
    </head>
    <body>
        <div class="rred_gradient_bg" style="width: 100%;" >
            <div  class="container">
                <div class="form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
                    <div id="login_form_wrap" style="" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                        <div class="logo_holder_div"><img src="<?php echo base_url()?>img/Ediface_White.png" /><br /></div>
                        <form id="login_form" method="post">
                            <div class="align_center login_top_text">ENTER ACCOUNT<span style="color: #343434">INFORMATION</span>
                                <div class="down_arrow_white">&nbsp;</div>
                            </div>
                            <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <select id="login_email" name="login_email" class="not_so_cool_input">
                                    <option value="0">Choose user</option>
                                    {users_options}
                                </select>
                            </div>
                            <h4 class="login_error">{login_error}</h4>
                            <div style="margin-top:10px;margin-left:5px;" class="log_submit"><input onclick="confirmPublish(event)" type="button" value="SIGN IN" /></div>
                            <div class="login_stuff"><div class="clear"></div></div>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 hidden-xs"></div>
                </div>
            </div>
        </div>
        <div id="popupPubl" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #eee;">
                    <div class="modal-header2">
                        <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
        <!--                <h4 class="modal-title">Publish Assignment</h4>-->
                    </div>
                    <div class="modal-body">
                        <div style="display: inline-block; margin: 20px; background: #fff; text-align: left; padding: 20px;">
                            <p>You are about to enter the Ediface platform demo site.
                            Please be aware that this demo is publically available and 
                            therefore not all of the content encountered on this site 
                            has been created by Ediface.</p>
                            <p>The data is refreshed daily in order to make sure that it is 
                            as clean and usable as possible. If you do encounter any 
                            issues, then please get in touch with us at 
                            <a href="mailto:support@ediface.org">support@ediface.org</a>.</p>
                            <p>By using this site you agree to our <a href="">terms and conditions</a>.</p>
                        </div>
                    </div>
                    <div class="modal-footer2">
                        <button type="button" class="btn btn-cancel" data-dismiss="modal" onClick="undoPubl()">CANCEL</button>
                        <button id="popupPublBT" do="1" type="button" onClick="doPubl()" class="btn orange_btn">CONFIRM</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
