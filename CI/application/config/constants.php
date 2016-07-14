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


$link = mysql_connect('localhost', 'root', 'hoyya');
//$link = mysql_connect('10.169.0.100', 'edifaceo_admin', 'admin@2016');
if (!$link) {
    die('Could not connect to the server!');// . mysql_error());
} else {
	mysql_set_charset ( 'utf8' );
    mysql_select_db( 'defedifa_copy' );
//	mysql_select_db( 'edifaceo_admin' );
	$sql_School = "SELECT * FROM school_vars WHERE school = '".ENVIRONMENT."' ";
	$res_School = mysql_query( $sql_School );

	if (!$res_School) {
    	echo "Could not successfully run query from DB";
//    	echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    	exit;
	}

	if (mysql_num_rows($res_School) == 0) {
    	echo "No rows found, nothing to print so am exiting";
    	exit;
	}

	while( $row_sel = mysql_fetch_assoc( $res_School ) ) {
    	$cnfg = json_decode( $row_sel['configs'], true );
    	$SCHOOLS = array( $row_sel['school'] => $cnfg['config'] );
    	$db['default'] = $cnfg['db'];
        $amazon = $cnfg['amazon'];
	}
}
mysql_close($link);



/*
$SCHOOLS = array(
  'live.dragon.ediface.org'=>array(
      'full_url'=>'http://live.dragon.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - LIVE VERSION for the `dragon` school',
      'site_type' => 'live',
      'custom'=> array('onelogin')
  ),
  'teacher.ediface.org'=>array(
      'full_url'=>'http://teacher.ediface.org',
      'db_enviroment'=>'default',
      'TITLE' => 'EDIFACE - Teacher Demo VERSION',
      'site_type' => 'demo',
      'demo_type' => 'teacher',
      'custom'=> array('')
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
//*/


if(isset($SCHOOLS[ENVIRONMENT])) {
    $GLOBALS['SCHOOL'] = $SCHOOLS[ENVIRONMENT];
    $GLOBALS['DB'] = $db;
    $GLOBALS['BUCKET'] = $amazon['bucket'];
}

//if(isset($SCHOOLS[$_SERVER['HTTP_HOST']]))$GLOBALS['SCHOOL'] = $SCHOOLS[$_SERVER['HTTP_HOST']];
if(empty($GLOBALS['SCHOOL']))die('Invalid URL');

$config['SCHOOL'] = $GLOBALS['SCHOOL'];
$config['ELASTIC']['url'] = $amazon['elastic_url'];
$config['ELASTIC']['index'] = $amazon['elastic_index'];
$config['enable_feedback'] = TRUE;

/* End of file constants.php */
/* Location: ./application/config/constants.php */
