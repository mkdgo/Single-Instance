<html>
    <body>
        Dear <?php echo $firstName; ?>, <br /><br />

        You have requested to have your password reset for your account at <?php echo $baseURL; ?>. <br /><br />

        Please visit this url to reset your password:<br /><br />

        <a href="<?php echo $baseURL . 'a1/passwordreset?token=' . $token; ?>"><?php echo $baseURL . 'a1/passwordreset?token=' . $token; ?></a>

        <br /><br />
        If you received this email in error, you can safely ignore this email.
    </body>
</html>


