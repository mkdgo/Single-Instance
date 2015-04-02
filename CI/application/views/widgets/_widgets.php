<!DOCTYPE html><html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>EDIFACE - <?=$GLOBALS['SCHOOL']['TITLE']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
    <!-- Bootstrap -->
    <link href="<?=base_url("/css/bootstrap.css")?>" rel="stylesheet" media="screen">

    <link rel="stylesheet" href="<?=base_url("/css/newcss.css")?>" type="text/css"/>

    <link rel="stylesheet" href="<?=base_url("/css/style.css")?>" type="text/css"/>

    <script src="<?=base_url("/js/jquery.js")?>"></script>

    <script src="<?=base_url("/js/js_visuals.js")?>"></script>

    <script type="text/javascript">
        user_id = '{user_id}';
        user_type = '{user_type}';
    </script>
</head>
<body>
<?php

if(
    $_SERVER['REDIRECT_QUERY_STRING']!='/' &&
    substr($_SERVER['REDIRECT_QUERY_STRING'], 0, 3)!='/a1'
) :

    ?>
    {_header}

<?php endif; ?>
{_content}
{_footer}


<script src="<?=base_url("/js/bootstrap.min.js")?>"></script>
<!--<script src="<?=base_url("/js/jquery.mobile-1.3.2.min.js")?>"></script>-->
<script src="<?=base_url("/js/jquery.colorbox-min.js")?>"></script>
</body>
</html>
