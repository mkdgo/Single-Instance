<style type="text/css">
    .change_pass {
        margin-top: 10px;
        text-align: center;
    }
    .change_pass input {
        background-color: #343434;
        border: none;
        color: #fff;
        margin: 0 auto;
        padding: 10px 60px;
    }
</style>

<div class="rred_gradient_bg" >
    <div  class="container">
        <div class="form-group">
            <div id="login_form_wrap" class="col-xs-12 col-sm-6 col-sm-offset-3">
                <form id="login_form" method="post" action="passwordchange" style="margin-top: 100px;" onsubmit="return checkForm()">
                    <div class="align_center login_top_text">CHANGE YOUR PASSWORD<div class="down_arrow_white">&nbsp;</div></div>
                    <h2>Current Password</h2>
                    <input id="password" type="hidden" name="password" value="{password}" />
                    <input id="password_current" type="password" class="not_so_cool_input" name="password_current" value="" placeholder="Enter your current password" />
                    <h4 style="color: #ffffff;">{passwordcur_status}</h4>
                    <br />
                    <br />
                    <h4 style="color: #ffffff;">{passwordmismatch_status}</h4>
                    <h2>New Password</h2>
                    <input id="password_new" type="password" class="not_so_cool_input" name="password_new" value="" placeholder="Enter new password" />
<!--                    <h4 style="color: #ffffff;">{status}</h4>-->
                    <h2>Confirm New Password</h2>
                    <input id="password_new_repeat" type="password" class="not_so_cool_input" name="password_new_repeat" value="" placeholder="Enter new password again" />
                    <div style="float: left;" class="change_pass">
                        <h3><input type="submit" name="change" value="Change Password" /></h3>
                    </div>
                    <div style=" float: right;" class="change_pass">
                        <h3><input id="back-to-login-page" type="button" value="Cancel" /></h3>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/components/enc-base64-min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#back-to-login-page').click(function () {
            window.history.back();
        });
        $('#password_current').blur(function () {
            var pass_c = CryptoJS.MD5( $('#password_current').val() );
            if( pass_c != $('#password').val() || $('#password_current').val() == '' ) {
                alert( 'Incorrect current password' );
            }
        });
    });
    function checkForm() {
        var pass_c = CryptoJS.MD5( $('#password_current').val() );
        if( pass_c != $('#password').val() || $('#password_current').val() == '' ) {
            alert( 'Incorrect current password' );
            return false;
        }
        if( $('#password_new').val() != $('#password_new_repeat').val() || $('#password_new').val() == '' ) {
            alert( 'Mismatch between new password and confirm new password' );
            return false;
        }
        return true;
    }
</script>