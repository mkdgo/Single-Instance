<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
if( !defined('FILE_READ_MODE') ) { define('FILE_READ_MODE', 0644); }
if( !defined('FILE_WRITE_MODE') ) { define('FILE_WRITE_MODE', 0666); }
if( !defined('DIR_READ_MODE') ) { define('DIR_READ_MODE', 0755); }
if( !defined('DIR_WRITE_MODE') ) { define('DIR_WRITE_MODE', 0777); }

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

if( !defined('FOPEN_READ') ) { define('FOPEN_READ', 'rb'); }
if( !defined('FOPEN_READ_WRITE') ) { define('FOPEN_READ_WRITE', 'r+b'); }
if( !defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') ) { define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); } // truncates existing file data, use with care
if( !defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') ) { define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); } // truncates existing file data, use with care
if( !defined('FOPEN_WRITE_CREATE') ) { define('FOPEN_WRITE_CREATE', 'ab'); }
if( !defined('FOPEN_READ_WRITE_CREATE') ) { define('FOPEN_READ_WRITE_CREATE', 'a+b'); }
if( !defined('FOPEN_WRITE_CREATE_STRICT') ) { define('FOPEN_WRITE_CREATE_STRICT', 'xb'); }
if( !defined('FOPEN_READ_WRITE_CREATE_STRICT') ) { define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b'); }


error_reporting(E_ERROR | E_WARNING | E_PARSE);

$SCHOOLS = array(
  'live.dragon.ediface.org'=>array(
      'full_url'=>'http://live.dragon.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - LIVE VERSION for the `dragon` school',
      'site_type' => 'live',
      'custom'=> array('onelogin')
  ),
  'teacher.demo.ediface.org'=>array(
      'full_url'=>'http://teacher.demo.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - Teacher Demo VERSION',
      'site_type' => 'demo',
      'demo_type' => 'teacher',
      'custom'=> array('')
  ),
  'student.demo.ediface.org'=>array(
      'full_url'=>'http://student.demo.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - Student Demo VERSION',
      'site_type' => 'demo',
      'demo_type' => 'student',
      'custom'=> array('')
  ),
  'school.demo.ediface.org'=>array(
      'full_url'=>'http://school.demo.ediface.org',
      'db_enviroment'=>'development',
      'TITLE' => 'EDIFACE - School Demo VERSION',
      'site_type' => 'dev',
      'demo_type' => 'student',
      'custom'=> array('')
  ),
  'live.demoschool.ediface.org'=>array(
      'full_url'=>'http://live.demoschool.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - LIVE VERSION for the `ediface` school',
      'site_type' => 'demo',
      'custom'=> array('onelogin')
  ),
   'ediface.dev'=>array(
      'full_url'=>'http://ediface.dev',
      'db_enviroment'=>'devlocal',
      'TITLE' => 'EDIFACE - LOCAL',
      'site_type' => 'dev',
      'demo_type' => 'teacher',
      'custom'=> array('')
  )
);
if(isset($SCHOOLS[$_SERVER['HTTP_HOST']]))$GLOBALS['SCHOOL'] = $SCHOOLS[$_SERVER['HTTP_HOST']];
if(empty($GLOBALS['SCHOOL']))die('Invalid URL');

$config['SCHOOL'] = $GLOBALS['SCHOOL'];
$config['enable_feedback'] = TRUE;

/* End of file constants.php */
/* Location: ./application/config/constants.php */