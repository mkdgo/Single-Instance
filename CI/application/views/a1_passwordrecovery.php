<div class="rred_gradient_bg" >
    <div  class="container">
        <div class="form-group">
            <div id="login_form_wrap" class="col-xs-12 col-sm-6 col-sm-offset-3">
                <form id="login_form" method="post" action="passwordrecovery">
                    <div class="align_center login_top_text">ENTER EMAIL ADDRESS
                        <div class="down_arrow_white">&nbsp;</div>
                    </div>
                    <input type="email" class="not_so_cool_input" name="email" id="email" value="{email_used}" placeholder="Enter your email address" />
                    <h4 style="color: #ffffff;">{status}</h4>
                    <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                        <input type="submit" value="SEND PASSWORD RECOVERY EMAIL" />
                    </div>
                    <div style="margin-top:10px;margin-left:5px;" class="log_submit">
                        <input id="back-to-login-page" type="button" value="BACK TO LOGIN PAGE" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#back-to-login-page').click(function () {
            document.location = '/a1';
        });
    });
</script>