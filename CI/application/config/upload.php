<?php

if (!defined('BASEPATH'))	exit('No direct script access allowed');

$school_uploads = $GLOBALS['BUCKET'];

$config['bucket'] = $school_uploads; // Amazon Storage Bucket
$config['subjects'] = 'subjects/'; // Amazon Storage structure
$config['resources'] = 'resources/'; // Amazon Storage structure
$config['homeworks'] = 'homeworks/'; // Amazon Storage structure
$config['imports'] = 'imports/'; // Amazon Storage structure


//$config['upload_path'] = './uploads/'.$school_uploads.'/resources/temp/'; // must start with "."!
//$config['image_path'] = './uploads/'.$school_uploads.'/resources/'; // must start with "."!
//$config['subjects_icon_path'] = './uploads/'.$school_uploads.'/subject_icons/';
$config['subjects_icon_path'] = './res/subjects/';
$config['default_image'] = 'default.jpg';
$config['errorfilenotfound'] = 'errorfilenotfound.png';
$config['red_pen_download_image'] = 'gray_button_arrow.png';

$config['homeworks_path'] = './uploads/'.$school_uploads.'/homeworks_generated/';
$config['homeworks_html_path'] = '/uploads/'.$school_uploads.'/homeworks_generated/';
$config['allowed_types'] = 'gif|jpg|png|pdf|doc|jpeg|docx|ppt|pptx|pub|mmap';
$config['max_size'] = '10000';
$config['encrypt_name'] = true;


$config['sinc_demo'][0]['ftp_config']['hostname'] = '91.208.99.4'; 
$config['sinc_demo'][0]['ftp_config']['username'] = 'school@demo.ediface.org';
$config['sinc_demo'][0]['ftp_config']['password'] = 'school15';
$config['sinc_demo'][0]['ftp_config']['debug']    = TRUE;
$config['sinc_demo'][0]['subdomain'] = 'teacher';
$config['sinc_demo'][0]['upload_resource'] = '/subdomains/teacher/uploads/resources/temp/';

$config['sinc_demo'][1]['ftp_config']['hostname'] = '91.208.99.4'; 
$config['sinc_demo'][1]['ftp_config']['username'] = 'school@demo.ediface.org';
$config['sinc_demo'][1]['ftp_config']['password'] = 'school15';
$config['sinc_demo'][1]['ftp_config']['debug']    = TRUE;
$config['sinc_demo'][1]['subdomain'] = 'student';
$config['sinc_demo'][1]['upload_resource'] = '/subdomains/student/uploads/resources/temp/';

$config['sinc_demo'][2]['ftp_config']['hostname'] = '91.208.99.4'; 
$config['sinc_demo'][2]['ftp_config']['username'] = 'live@demoschool.ediface.org';
$config['sinc_demo'][2]['ftp_config']['password'] = 'live!@#$';
$config['sinc_demo'][2]['ftp_config']['debug']    = TRUE;
$config['sinc_demo'][2]['subdomain'] = 'live';
$config['sinc_demo'][2]['upload_resource'] = '/subdomains/live/uploads/resources/temp/';

$config['sinc_demo'][3]['ftp_config']['hostname'] = '91.208.99.4'; 
$config['sinc_demo'][3]['ftp_config']['username'] = 'teacher@teacher.ediface.org';
$config['sinc_demo'][3]['ftp_config']['password'] = 'teacher2016';
$config['sinc_demo'][3]['ftp_config']['debug']    = TRUE;
$config['sinc_demo'][3]['subdomain'] = 'teacher';
$config['sinc_demo'][3]['upload_resource'] = '/uploads/resources/temp/';

$config['sinc_demo'][4]['ftp_config']['hostname'] = '91.208.99.4'; 
$config['sinc_demo'][4]['ftp_config']['username'] = 'student@student.ediface.org';
$config['sinc_demo'][4]['ftp_config']['password'] = 'student2016';
$config['sinc_demo'][4]['ftp_config']['debug']    = TRUE;
$config['sinc_demo'][4]['subdomain'] = 'student';
$config['sinc_demo'][4]['upload_resource'] = '/uploads/resources/temp/';
