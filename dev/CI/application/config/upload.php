<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

$config['upload_path'] = './uploads/resources/temp/'; // must start with "."!
$config['image_path'] = './uploads/resources/'; // must start with "."!
$config['default_image'] = 'default.jpg';
$config['red_pen_download_image'] = 'gray_button_arrow.png';

$config['homeworks_path'] = './uploads/homeworks_generated/';
$config['homeworks_html_path'] = '/uploads/homeworks_generated/';
$config['allowed_types'] = 'gif|jpg|png|pdf|doc|jpeg|docx|ppt|pptx';
$config['max_size'] = '10000';
$config['encrypt_name'] = true;