<html>
    <body>
        <h1>Customer Feedback Received</h1>
        <h3><?php echo date('l j\<\s\u\p\>S\<\/\s\u\p\> F Y H:i'); ?></h3>

        <strong>From:</strong> <?php echo $reporterName; ?> (<?php echo $reporterEmail; ?>) <br />
        <strong>URL:</strong> <?php echo $location; ?> <br />
        <strong>Path:</strong> <?php echo $path; ?> <br />
        <p style="padding: 20px 10px;">
            <em><?php echo $feedback; ?></em>
        </p>
    </body>
</html>


