<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'da_admin';
$db['default']['password'] = '2NsDAo08B9';
$db['default']['database'] = 'capsysV3';
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


$db['dbLite']['dsn'] = ''; /* New SysJjHe */
$db['dbLite']['hostname'] = 'localhost';
$db['dbLite']['username'] = 'capsysWebLight';
$db['dbLite']['password'] = 'viki$52';
$db['dbLite']['database'] = 'capsysLight';
$db['dbLite']['dbdriver'] = 'mysqli'; //'mysql';
$db['dbLite']['dbprefix'] = '';
$db['dbLite']['pconnect'] = TRUE;
$db['dbLite']['db_debug'] = TRUE;
$db['dbLite']['cache_on'] = FALSE;
$db['dbLite']['cachedir'] = '';
$db['dbLite']['char_set'] = 'utf8';
$db['dbLite']['dbcollat'] = 'utf8_general_ci';
$db['dbLite']['swap_pre'] = '';
$db['dbLite']['encrypt'] = FALSE; /* New SysJjHe */
$db['dbLite']['compress'] = FALSE; /* New SysJjHe */
$db['dbLite']['autoinit'] = TRUE;
$db['dbLite']['stricton'] = FALSE;
$db['dbLite']['failover'] = array(); /* New SysJjHe */



/*BD CON MYSQLI*/
$db['db2']['hostname'] = 'localhost';
$db['db2']['username'] = 'da_admin';
$db['db2']['password'] = '2NsDAo08B9';
$db['db2']['database'] = 'capsysV3pruebas';
$db['db2']['dbdriver'] = 'mysqli';
$db['db2']['dbprefix'] = '';
$db['db2']['pconnect'] = TRUE;
$db['db2']['db_debug'] = TRUE;
$db['db2']['cache_on'] = FALSE;
$db['db2']['cachedir'] = '';
$db['db2']['char_set'] = 'utf8';
$db['db2']['dbcollat'] = 'utf8_general_ci';
$db['db2']['swap_pre'] = '';
$db['db2']['autoinit'] = TRUE;
$db['db2']['stricton'] = FALSE;


/*BD CON MYSQLI CONEXION A CAPITAL SEGUROS*/
$db['capitalSeguros']['hostname'] = 'capitalseguros.com.mx';
$db['capitalSeguros']['username'] = 'capita13';
$db['capitalSeguros']['password'] = '2tDF86dl8a-)?<';
$db['capitalSeguros']['database'] = 'capita13_wp1';
$db['capitalSeguros']['dbdriver'] = 'mysqli';
$db['capitalSeguros']['dbprefix'] = '';
$db['capitalSeguros']['pconnect'] = TRUE;
$db['capitalSeguros']['db_debug'] = TRUE;
$db['capitalSeguros']['cache_on'] = FALSE;
$db['capitalSeguros']['cachedir'] = '';
$db['capitalSeguros']['char_set'] = 'utf8';
$db['capitalSeguros']['dbcollat'] = 'utf8_general_ci';
$db['capitalSeguros']['swap_pre'] = '';
$db['capitalSeguros']['autoinit'] = TRUE;
$db['capitalSeguros']['stricton'] = FALSE;

/*CONEXION A LA BD DE FIANZAS EN CAPITAL SEGUROS*/

/*BD CON MYSQLI CONEXION A CAPITAL SEGUROS*/
$db['capitalSegurosFianzas']['hostname'] = 'capitalseguros.com.mx';
$db['capitalSegurosFianzas']['username'] = 'capita13';
$db['capitalSegurosFianzas']['password'] = '2tDF86dl8a-)?<';
$db['capitalSegurosFianzas']['database'] = 'capita13_fianzas';
$db['capitalSegurosFianzas']['dbdriver'] = 'mysqli';
$db['capitalSegurosFianzas']['dbprefix'] = '';
$db['capitalSegurosFianzas']['pconnect'] = TRUE;
$db['capitalSegurosFianzas']['db_debug'] = TRUE;
$db['capitalSegurosFianzas']['cache_on'] = FALSE;
$db['capitalSegurosFianzas']['cachedir'] = '';
$db['capitalSegurosFianzas']['char_set'] = 'utf8';
$db['capitalSegurosFianzas']['dbcollat'] = 'utf8_general_ci';
$db['capitalSegurosFianzas']['swap_pre'] = '';
$db['capitalSegurosFianzas']['autoinit'] = TRUE;
$db['capitalSegurosFianzas']['stricton'] = FALSE;


/* End of file database.php */
/* Location: ./application/config/database.php */