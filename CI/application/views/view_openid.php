<html>
  <head><title>PHP OpenID Authentication Example</title></head>
  
  <body>
   

    <?php if (isset($msg)) { echo "<div class=\"alert\">$msg</div>"; } ?>
    <?php if (isset($error)) { echo "<div class=\"error\">$error</div>"; } ?>
    <?php if (isset($success)) { echo "<div class=\"success\">$success</div>"; } ?>

    <div id="verify-form">
      <form method="post" action="<?php echo site_url('test/index'); ?>">
        Identity&nbsp;URL:
        <input type="hidden" name="action" value="verify" />
        <input type="text" name="openid_identifier" value="" />
        <input type="submit" value="Verify" />
      </form>
    </div>
  </body>
</html>