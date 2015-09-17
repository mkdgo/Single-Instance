<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>EDIFACE - <?php if( isset($this->headTitle) ) { echo $this->headTitle; } else { echo $GLOBALS['SCHOOL']['TITLE']; }?></title>

        <meta name="apple-mobile-web-app-capable" content="yes">
<!--        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">-->
        <link rel="apple-touch-icon" sizes="57x57" href="/img/apple-icon-57x57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="/img/apple-icon-72x72.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="/img/apple-icon-114x114.png" />
        <link rel="apple-touch-icon" sizes="144x144" href="/img/apple-icon-144x144.png" />
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/apple-icon-57x57-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/img/apple-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/apple-icon-114x114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/apple-icon-144x144-precomposed.png" />

        <!-- <link rel="shortcut icon" sizes="16x16" href="icon-16x16.png"> --> 
        <link rel="shortcut icon" sizes="144x144" href="/img/apple-icon-144x144.png">

        <link rel="stylesheet" type="text/css" href="<?= base_url("/js/homescreen-master/style/addtohomescreen.css")?>" />
        <script src="<?= base_url("/js/homescreen-master/src/addtohomescreen.js") ?>"></script>
        <script type="text/javascript">
            addToHomescreen();
        </script>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <link href="<?php echo base_url("/css/bootstrap.css")?>" rel="stylesheet" media="screen">
        <!--<link rel="stylesheet" href="<?=base_url("/css/jquery.mobile-1.3.2.min.css")?>" type="text/css"/>-->
        <!-- <link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.structure-1.3.2.min.css")?>" type="text/css"/> -->
        <!--<link rel="stylesheet" href="<?=base_url("/css/jquery.mobile.theme-1.3.2.min.css")?>" type="text/css"/> -->
        <!-- REMOVE IN FINAL VERSION, CONFLICTS WITH COLORBOX! -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
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

        <div id="dialog_logout" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header2">
                        <a class="remove" href="javascript:;" data-dismiss="modal" ><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                    <div class="feedback-modal-header">
                        <h4 class="modal-title">User Activities</h4>
                    </div>
                    <div class="feedback-modal-body">
<!--                        <h5 class="no-error">Since you have no activity in the last 20 min</h5>-->
                        <h5 class="no-error">You will be Logged out in <span class="logout_sec">10</span> seconds</h5>
                    </div>
                    <div class="feedback-modal-footer feedback-buttons">
                        <button type="button" class="btn red_btn dismiss-logout" data-dismiss="modal">Stay Logged in</button>
<!--                        <button type="button" class="btn green_btn" id="submit_feedback" style="display: none;">Submit</button>-->
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->       
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?=base_url("/js/bootstrap.min.js")?>"></script>
        <!--<script src="<?=base_url("/js/jquery.mobile-1.3.2.min.js")?>"></script>-->
        <script src="<?=base_url("/js/jquery.colorbox-min.js")?>"></script>
    </body>
</html>
