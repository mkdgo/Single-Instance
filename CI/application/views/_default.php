<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>EDIFACE - <?=$GLOBALS['SCHOOL']['TITLE']?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0 maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="true" />
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <link href="<?=base_url("/css/bootstrap.css")?>" rel="stylesheet" media="screen">
        <!--<link rel="stylesheet" href="<?=base_url("/css/jquery.mobile-1.3.2.min.css")?>" type="text/css"/>-->
        <!-- <link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.structure-1.3.2.min.css")?>" type="text/css"/> -->
        <!--<link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.theme-1.3.2.min.css")?>" type="text/css"/>
        <!-- REMOVE IN FINAL VERSION, CONFLICTS WITH COLORBOX! -->
        <link rel="stylesheet" href="<?=base_url("/css/newcss.css")?>" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url("/css/colorbox.css")?>" type="text/css"/>
        <link rel="stylesheet" href="<?=base_url("/css/style.css")?>" type="text/css"/>

        <script src="<?=base_url("/js/jquery.js")?>"></script>
        <script src="<?=base_url("/js/main.js")?>"></script>
        <script src="<?=base_url("/js/js_visuals.js")?>"></script>
        <script src="<?=base_url("/js/encoder.js")?>"></script>

        <script type="text/javascript">
            user_id = '{user_id}';
            user_type = '{user_type}';
        </script>
    </head>
    <body>
    <?php if( $_SERVER['REDIRECT_QUERY_STRING']!='/' && substr($_SERVER['REDIRECT_QUERY_STRING'], 0, 3)!='/a1' ): ?>
        {_header}
    <?php endif; ?>
        {_content}
        {_footer}
        <!--
        <div class="footer_menu_wrap">
        <div class="footer_menu">
        <div class="footer_icons_wrap">
        <div style="width: 200px;margin:0 auto;;">
        <a href="#" class="home_icon"></a>
        <a href="#" class="settings_icon"></a>
        <a href="#" class="block_icon"></a>
        <div class="clear"></div>
        </div>
        </div>
        </div>
        </div>-->
        <div id="dialog" style="position: absolute;
            top: 0;
            left: 0;
            width: 100%; 
            height: 100%; 
            z-index: 1000; 
            opacity:0.75;
            background-color: #000000; 
            display: none; 
            text-align: center;
            color: white;
            padding: 30% 10% 30% 10%;
            font-weight: normal;
            text-shadow:none;
            font-size: 30px;
            vertical-align: middle;">
            <h1 id="dialog_title"></h1>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url("/js/bootstrap.min.js")?>"></script>
        <!--<script src="<?=base_url("/js/jquery.mobile-1.3.2.min.js")?>"></script>-->
        <script src="<?=base_url("/js/jquery.colorbox-min.js")?>"></script>
    </body>
</html>
