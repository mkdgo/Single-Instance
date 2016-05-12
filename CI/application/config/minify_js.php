<?php defined('BASEPATH') OR exit('No direct script access allowed');

$arr_global_js = array(
    '/js/homescreen-master/src/addtohomescreen.js',
    '/js/main.js',
//            '/js/encoder.js',
    '/js/jquery.session.js',
    '/js/ladda/dist/spin.min.js',
    '/js/ladda/dist/ladda.min.js',
    '/js/jquery.fineuploader-3.5.0.min.js',
    '/js/classie.js',
    '/js/search.js',
    '/js/js_visuals.js',
    '/js/bootstrap.min.js',
    '/js/jquery.colorbox-min.js'
);

$config['js']['default'] = $arr_global_js;
$config['js']['c2'] = array_merge($arr_global_js, array(
            '/js/crypt/aes.js',
            '/js/crypt/upload.js'
));
$config['js']['c2n'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/crypt/aes.js',
            '/js/crypt/upload.js'
));
$config['js']['d1b'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/d1b_curriculum.js'
));
$config['js']['d3_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/d3_teacher.js'
));
$config['js']['d4_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/jqBootstrapValidation.min.js',
            '/js/d4_teacher.js'
));
$config['js']['d5_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/d5_teacher.js'
));
$config['js']['e1_teacher'] = array_merge($arr_global_js, array( '/js/sortable.js', '/js/e1_teacher.js' ) );
$config['js']['e2'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/e2.js'
));
$config['js']['e5_teacher'] = array_merge($arr_global_js, array(
            '/js/reveal/lib/js/head.min.js',
            '/js/reveal/js/reveal.js',
            '/js/meny/js/meny.js'
));
$config['js']['f1_teacher'] = array_merge($arr_global_js, array( '/js/f1_teacher.js' ) );
$config['js']['f2c_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/slider/jquery.noos.slider.js',
            '/js/timepicker/jquery.timepicker.js'
));
$config['js']['f2p_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/slider/jquery.noos.slider.js',
            '/js/timepicker/jquery.timepicker.js'
));
$config['js']['f2b_teacher'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/timepicker/jquery.timepicker.js'
));
$config['js']['f2d_teacher'] = array_merge($arr_global_js, array(
            '/js/timepicker/jquery.timepicker.js'
));
$config['js']['g1_teacher'] = array_merge($arr_global_js, array(
            '/js/g1_teacher.js',
            '/js/g1_teacher_student.js'
));

$config['js']['f2_student'] = array_merge($arr_global_js, array(
            '/js/nicEdit/nicEdit.js',
            '/js/crypt/aes.js',
            '/js/crypt/upload.js',
            '/js/f2_student.js'
));

$config['js_ext']['default'] = '';
$config['js_ext']['d2_teacher'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/jquery.ui.touch-punch.min.js"></script><script type="text/javascript" src="/res/js/jquery.mjs.nestedSortable.js"></script><script type="text/javascript" src="/res/js/d2_teacher.js"></script>';
$config['js_ext']['d4_teacher'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/jquery.ui.touch-punch.min.js"></script>';
$config['js_ext']['d5_teacher'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/jquery.ui.touch-punch.min.js"></script>';
$config['js_ext']['e2'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/jquery.ui.touch-punch.min.js"></script>';
//$config['js_ext']['e5_teacher'] = '<script type="text/javascript" src="/res/js/meny/js/meny.js"></script>';
$config['js_ext']['f2c_teacher'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script><script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/f2c_teacher.js"></script>';
$config['js_ext']['f2b_teacher'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script><script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/f2b_teacher.js"></script>';
$config['js_ext']['f2p_teacher'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script><script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/f2p_teacher.js"></script>';
$config['js_ext']['f2d_teacher'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script><script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/f2d_teacher.js"></script>';
$config['js_ext']['f3_teacher'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/resize/jquery.drag.resize.js"></script><script type="text/javascript" src="/res/js/f3_teacher.js"></script>';
$config['js_ext']['f4_teacher'] = '<script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/resize/jquery.drag.resize.js"></script><script type="text/javascript" src="/res/js/f4_teacher.js"></script>';
$config['js_ext']['r2_teacher'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script><script type="text/javascript" src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script><script type="text/javascript" src="/res/js/r2_teacher.js"></script>';
//$config['js_ext']['f2_student'] = '<script type="text/javascript" src="/res/js/f2_student.js"></script>';


// End of file minify.php
// Location: ./application/config/minify.php
