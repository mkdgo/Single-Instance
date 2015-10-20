<html>
    <body>
        <h1>Error report</h1>
        <h3><?php echo date('l j\<\s\u\p\>S\<\/\s\u\p\> F Y H:i'); ?></h3>

        <strong>From:</strong> <?php echo $reporterName; ?> (<?php echo $reporterEmail; ?>) <br />
        <strong>Browser:</strong> <?php echo $user_agent; ?> <br />
        <strong>URL:</strong> <?php echo $refferer; ?> <br />
        <strong>Error message:</strong>
        <p style="padding: 0 10px;">
            <em><?php echo $message; ?></em>
        </p>
    </body>
</html>


