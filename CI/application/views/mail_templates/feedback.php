<html>
    <body>
        <h1>Customer Feedback Received</h1>
        <h3><?php echo date('l j\<\s\u\p\>S\<\/\s\u\p\> F Y H:i'); ?></h3>

        <strong>From:</strong> <?php echo $reporterName; ?> (<?php echo $reporterEmail; ?>) <br />
        <strong>User:</strong> <?php echo $user_type; ?> <br />
        <strong>Browser:</strong> <?php echo $user_agent; ?> <br />
<!--        <strong>REFFERER:</strong> <?php echo $refferer; ?> <br />-->
        <strong>URL:</strong> <?php echo $location; ?> <br />
        <strong>Path:</strong> <?php echo $path; ?> <br />
        <p style="padding: 0 10px;">
            <em><?php echo $feedback; ?></em>
        </p>
    </body>
</html>


