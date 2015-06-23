<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Administration of - <?php if( isset($this->headTitle) ) { echo $this->headTitle; } else { echo $GLOBALS['SCHOOL']['TITLE']; }?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script type="text/javascript" src="<?php echo base_url() ?>js/jquery.js"></script>    
        <script type="text/javascript" src="<?php echo base_url() ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/bootbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/admin.js"></script>
        <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>css/admin.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>css/admin-sidebar.css" type="text/css" />
        <link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" />
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
    </head>
    <body>
        <div id="wrapper">
            {_sidebar}
            {_content}
        </div>
    </body>
</html>