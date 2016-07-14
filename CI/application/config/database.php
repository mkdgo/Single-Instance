<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------
  | DATABASE CONNECTIVITY SETTINGS
  | -------------------------------------------------------------------
  | This file will contain the settings needed to access your database.
  |
  | For complete instructions please consult the 'Database Connection'
  | page of the User Guide.
  |
  | -------------------------------------------------------------------
  | EXPLANATION OF VARIABLES
  | -------------------------------------------------------------------
  |
  |	['hostname'] The hostname of your database server.
  |	['username'] The username used to connect to the database
  |	['password'] The password used to connect to the database
  |	['database'] The name of the database you want to connect to
  |	['dbdriver'] The database type. ie: mysql.  Currently supported:
  mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
  |	['dbprefix'] You can add an optional prefix, which will be added
  |				 to the table name when using the  Active Record class
  |	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
  |	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
  |	['cache_on'] TRUE/FALSE - Enables/disables query caching
  |	['cachedir'] The path to the folder where cache files should be stored
  |	['char_set'] The character set used in communicating with the database
  |	['dbcollat'] The character collation used in communicating with the database
  |				 NOTE: For MySQL and MySQLi databases, this setting is only used
  | 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
  |				 (and in table creation queries made with DB Forge).
  | 				 There is an incompatibility in PHP with mysql_real_escape_string() which
  | 				 can make your site vulnerable to SQL injection if you are using a
  | 				 multi-byte character set and are running versions lower than these.
  | 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
  |	['swap_pre'] A default table prefix that should be swapped with the dbprefix
  |	['autoinit'] Whether or not to automatically initialize the database.
  |	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
  |							- good for ensuring strict SQL while developing
  |
  | The $active_group variable lets you choose which connection group to
  | make active.  By default there is only one group (the 'default' group).
  |
  | The $active_record variables lets you determine whether or not to load
  | the active record class
 */

$active_group = 'default';
//$active_group = $GLOBALS['SCHOOL'][ENVIRONMENT];
$active_record = TRUE;

$db = $GLOBALS['DB'];
//$db[]
//echo '<pre>'; var_dump( $GLOBALS['SCHOOL'] );die;


/*
$db['default']['hostname'] = '10.169.0.100';
$db['default']['username'] = 'edifaceo_admin';
$db['default']['password'] = 'admin@2016';
$db['default']['database'] = 'edifaceo_admin';
//*/






/*
$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'devedifa_first';
$db['default']['password'] = '@password11@';
$db['default']['database'] = 'devedifa_first';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

///////////////////////////////////////////////////////

$db['development']['hostname'] = 'localhost';
$db['development']['username'] = 'p1stoyso_dbuser';
$db['development']['password'] = 'edi1234';
$db['development']['database'] = 'p1stoyso_ediface';
$db['development']['dbdriver'] = 'mysql';
$db['development']['dbprefix'] = '';
$db['development']['pconnect'] = TRUE;
$db['development']['db_debug'] = TRUE;
$db['development']['cache_on'] = FALSE;
$db['development']['cachedir'] = '';
$db['development']['char_set'] = 'utf8';
$db['development']['dbcollat'] = 'utf8_general_ci';
$db['development']['swap_pre'] = '';
$db['development']['autoinit'] = TRUE;
$db['development']['stricton'] = FALSE;

/////////////////////////////////////////////////

$db['devlocal']['hostname'] = 'localhost';
$db['devlocal']['username'] = 'root';
$db['devlocal']['password'] = 'hoyya';
$db['devlocal']['database'] = 'defedifa_copy';
//$db['devlocal']['database'] = 'defedifa_ediface';
$db['devlocal']['dbdriver'] = 'mysql';
$db['devlocal']['dbprefix'] = '';
$db['devlocal']['pconnect'] = TRUE;
$db['devlocal']['db_debug'] = TRUE;
$db['devlocal']['cache_on'] = FALSE;
$db['devlocal']['cachedir'] = '';
$db['devlocal']['char_set'] = 'utf8';
$db['devlocal']['dbcollat'] = 'utf8_general_ci';
$db['devlocal']['swap_pre'] = '';
$db['devlocal']['autoinit'] = TRUE;
$db['devlocal']['stricton'] = FALSE;

$db[ENVIRONMENT]['hostname'] = 'localhost';
$db[ENVIRONMENT]['username'] = 'root';
$db[ENVIRONMENT]['password'] = 'hoyya';
$db[ENVIRONMENT]['database'] = 'defedifa_copy';
//$db['devlocal']['database'] = 'defedifa_ediface';
$db[ENVIRONMENT]['dbdriver'] = 'mysql';
$db[ENVIRONMENT]['dbprefix'] = '';
$db[ENVIRONMENT]['pconnect'] = TRUE;
$db[ENVIRONMENT]['db_debug'] = TRUE;
$db[ENVIRONMENT]['cache_on'] = FALSE;
$db[ENVIRONMENT]['cachedir'] = '';
$db[ENVIRONMENT]['char_set'] = 'utf8';
$db[ENVIRONMENT]['dbcollat'] = 'utf8_general_ci';
$db[ENVIRONMENT]['swap_pre'] = '';
$db[ENVIRONMENT]['autoinit'] = TRUE;
$db[ENVIRONMENT]['stricton'] = FALSE;
//*/

//echo 'hi';
//echo '<pre>';var_dump( $this->db );die;

/* End of file database.php */
/* Location: ./application/config/database.php */