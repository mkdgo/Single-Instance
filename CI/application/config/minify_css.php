<?php defined('BASEPATH') OR exit('No direct script access allowed');

$arr_global_css = array(
    '/js/homescreen-master/style/addtohomescreen.css',
//            '/css/bootstrap.css',
    '/css/newcss.css',
    '/css/colorbox.css',
    '/css/style.css',
    '/css/ladda.css',
    '/js/ladda/dist/ladda.min.css',
    '/css/fineuploader_resources.css'
);
$config['css']['default'] = $arr_global_css;
$config['css']['d2_teacher'] = array_merge($arr_global_css, array( '/css/d2_teacher.css' ));
$config['css']['e5_teacher'] = array_merge($arr_global_css, array( 
//            '/js/reveal/css/reveal.css',
//            '/js/meny/css/demo.css',
            '/js/reveal/css/theme/ediface.css',
            '/js/reveal/lib/css/zenburn.css'
));
$config['css']['f2c_teacher'] = array_merge($arr_global_css, array( '/js/timepicker/jquery.timepicker.min.css' ));
$config['css']['f2b_teacher'] = array_merge($arr_global_css, array( '/js/timepicker/jquery.timepicker.min.css' ));
$config['css']['f2p_teacher'] = array_merge($arr_global_css, array( '/js/timepicker/jquery.timepicker.min.css' ));

$config['css_ext']['c2'] = '<link rel="stylesheet" href="/res/css/fineuploader_resources.css" type="text/css" /><link rel="stylesheet" href="/res/css/ladda.css" type="text/css" />';
$config['css_ext']['d2_teacher'] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">';
$config['css_ext']['e1_teacher'] = '<link rel="stylesheet" href="/css/e1_teacher.css">';
$config['css_ext']['e5_teacher'] = '<link rel="stylesheet" href="/js/reveal/css/reveal.css"><link rel="stylesheet" href="/js/meny/css/demo.css">';
$config['css_ext']['f2b_teacher'] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">';
$config['css_ext']['f2c_teacher'] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"><link rel="stylesheet" href="/res/css/f2c_teacher.css" type="text/css"/><link rel="stylesheet" href="/res/js/slider/style.css" type="text/css"/>';
$config['css_ext']['f2p_teacher'] = '<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"><link rel="stylesheet" href="/res/css/f2c_teacher.css" type="text/css"/><link rel="stylesheet" href="/res/js/slider/style.css" type="text/css"/>';
$config['css_ext']['f3_teacher'] = '<link rel="stylesheet" href="/res/css/f3_teacher.css" type="text/css" media="screen" />';
$config['css_ext']['f4_teacher'] = '<link rel="stylesheet" href="/res/css/f4_teacher.css" type="text/css" media="screen" />';
$config['css_ext']['f2_student'] = '<link rel="stylesheet" href="/res/css/fineuploader_resources.css" type="text/css" /><link rel="stylesheet" href="/res/css/ladda.css" type="text/css" />';



// End of file minify.php
// Location: ./application/config/minify.php
