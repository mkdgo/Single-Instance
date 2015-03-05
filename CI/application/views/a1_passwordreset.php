<?php if ($this->_data['passwordreset_status']) { ?>
    <?php if (isset($this->_data['passwordreset_success'])) { ?>
        <div class="rred_gradient_bg" >
            <div class="container">
                <div class="form-group">
                    <div id="login_form_wrap" class="col-xs-12 col-sm-8 col-sm-offset-2">
                        <form id="login_form" method="post" action="passwordrecovery">
                            <div class="align_center login_top_text">PASSWORD SUCCESSFULLY CHANGED.</div>
                            <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input id="back-to-login-page" type="button" value="BACK TO LOGIN PAGE" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="rred_gradient_bg" >
            <div class="container">
                <div class="form-group">
                    <div id="login_form_wrap" class="col-xs-12 col-sm-6 col-sm-offset-3">
                        <form id="password_reset_form" method="post" action="passwordreset">
                            <div class="align_center login_top_text">PLEASE ENTER AND CONFIRM YOUR NEW PASSWORD</div>
                            <div class="down_arrow_white">&nbsp;</div>
                            <input type="hidden" name="token" id="token" value="<?php echo $this->_data['passwordreset_token']; ?>" />
                            <input type="password" class="not_so_cool_input" name="password" id="password" placeholder="Enter your new password" />
                            <input type="password" class="not_so_cool_input" name="confirmPassword" id="confirmPassword" placeholder="Confirm your new password" />
                            <h4 id="missingvalues" style="color: #ffffff; display: none;">Please enter and confirm your new password.</h4>
                            <h4 id="mismatch" style="color: #ffffff; display: none;">Passwords do not match.</h4>
                            <?php if (isset($this->_data['passwordreset_server_error'])) { ?>
                                <h4 id="mismatch" style="color: #ffffff;">Could not update your password. Please try again.</h4>
                            <?php } ?>
                            <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                                <input id="submit-page" type="button" value="CHANGE PASSWORD" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>
    <div class="rred_gradient_bg" >
        <div class="container">
            <div class="form-group">
                <div id="login_form_wrap" class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <form id="login_form" method="post" action="passwordrecovery">
                        <div class="align_center login_top_text">MISSING OR INVALID PASSWORD RECOVERY TOKEN</div>
                        <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                            <input id="back-to-login-page" type="button" value="BACK TO LOGIN PAGE" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#back-to-login-page').click(function () {
            document.location = '/a1';
        });

        $('#submit-page').click(function () {
            var password = $.trim($('#password').val());
            var confirmPassword = $.trim($('#confirmPassword').val());

            $('#missingvalues').hide();
            $('#mismatch').hide();

            if (password === '' || confirmPassword === '') {
                $('#missingvalues').show();
                return;
            }

            if (password !== confirmPassword) {
                $('#mismatch').show();
                return;
            }

            $('#password_reset_form').submit();
        });
    });
</script>