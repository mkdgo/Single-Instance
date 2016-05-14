<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title>EDIFACE - <?php if( isset($this->headTitle) ) { echo $this->headTitle; } else { echo $GLOBALS['SCHOOL']['TITLE']; }?></title>

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <link href="<?php echo base_url("/res/css/bootstrap.min.css")?>" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <?php
            // add css files
            $this->minify->css( $_css, $css_group ); 
            // bool argument for rebuild css (false means skip rebuilding). 
            if( !in_array( $_SERVER['HTTP_HOST'], array('live.dragon.ediface.org', 'teacher.demo.ediface.org/', 'student.demo.ediface.org/') ) ) {
                echo $this->minify->deploy_css(TRUE, $css_name, $css_group);
            } else {
                echo $this->minify->deploy_css(FALSE, $css_name, $css_group);    
            }
            //Output: '<link href="path-to-compiled-css" rel="stylesheet" type="text/css" />'
        ?>
        <?php echo $_css_ext; ?>

        <?php if( $_SERVER['HTTP_HOST'] != 'ediface.dev' ): ?>
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript">
            (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter32566765 = new Ya.Metrika({ id:32566765, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/32566765" style="position:absolute; left:-9999px;" alt="" /></div>
        </noscript>
        <!-- /Yandex.Metrika counter -->
        <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

              ga('create', 'UA-67986355-1', 'auto');
              ga('send', 'pageview');
        </script>
        <?php endif ?>
        <script src="<?=base_url("/res/js/jquery.js")?>"></script>

        <script type="text/javascript">
            user_id = '{user_id}';
            user_type = '{user_type}';

        <?php if( $_SERVER['HTTP_HOST'] != 'ediface.dev' ): ?>
            $(document).ready(function() {
                addToHomescreen();
                heap.identify({handle: '<?php echo $heap_identify; ?>'});
            });
            window.heap=window.heap||[],heap.load=function(e,t){window.heap.appid=e,window.heap.config=t=t||{};var n=t.forceSSL||"https:"===document.location.protocol,a=document.createElement("script");a.type="text/javascript",a.async=!0,a.src=(n?"https:":"http:")+"//cdn.heapanalytics.com/js/heap-"+e+".js";var o=document.getElementsByTagName("script")[0];o.parentNode.insertBefore(a,o);for(var r=function(e){return function(){heap.push([e].concat(Array.prototype.slice.call(arguments,0)))}},p=["clearEventProperties","identify","setEventProperties","track","unsetEventProperty"],c=0;c<p.length;c++)heap[p[c]]=r(p[c])};
            heap.load("1342915830");
        <?php endif ?>
        </script>
    </head>
    <body>
    <?php if( $_SERVER['REDIRECT_QUERY_STRING']!='/' && substr($_SERVER['REDIRECT_QUERY_STRING'], 0, 3)!='/a1' ): ?>
        {_header}
    <?php endif; ?>
        {_content}
        {_footer}
        <div id="dialog" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; opacity:0.75; background-color: #000000; display: none; text-align: center; color: white; padding: 30% 10% 30% 10%; font-weight: normal; text-shadow:none; font-size: 30px; vertical-align: middle;">
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
                        <h5 class="no-error">You will be Logged out in <span class="logout_sec">10</span> seconds</h5>
                    </div>
                    <div class="feedback-modal-footer feedback-buttons">
                        <button type="button" class="btn red_btn dismiss-logout" data-dismiss="modal">Stay Logged in</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
            // add js files
            $this->minify->js( $_js, $js_group);
            // rebuild js (false means skip rebuilding).
//            if( $_SERVER['HTTP_HOST'] == 'ediface.dev' ) {
            if( !in_array( $_SERVER['HTTP_HOST'], array('live.dragon.ediface.org', 'teacher.demo.ediface.org/', 'student.demo.ediface.org/') ) ) {
                echo $this->minify->deploy_js(TRUE, $js_name, $js_group );
//                echo $this->minify->deploy_js(FALSE, $js_name, $js_group );
            } else {
                echo $this->minify->deploy_js(FALSE, $js_name, $js_group);
            }  //Output: '<script type="text/javascript" src="path-to-compiled-js"></script>'.
        ?>
        <?php echo $_js_ext; ?>

        <?php if( $_SERVER['HTTP_HOST'] != 'ediface.dev' ): ?>
        <script>
            window.intercomSettings = {
                app_id: "tuwxmlcz",
                name: '{user_full_name}', // Full name
                email: '{user_email}', // Email address
                user_id: '{user_id}' // User id
            };
        </script>
        <script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/tuwxmlcz';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
        <?php endif ?>
    </body>
</html>
