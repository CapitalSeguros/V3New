<?php
// mysql example
/*
define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
define('PHPGRID_DB_USERNAME', 'root');     // database user name
define('PHPGRID_DB_PASSWORD', ''); // database password
define('PHPGRID_DB_NAME', 'sampledb'); // database name
define('PHPGRID_DB_TYPE', 'mysql');  // database type
define('PHPGRID_DB_CHARSET','utf8'); // ex: utf8(for mysql),AL32UTF8 (for oracle), leave blank to use the default charset
*/
// postgres example
//define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
//define('PHPGRID_DB_USERNAME', 'postgres');     // database user name
//define('PHPGRID_DB_PASSWORD', ''); // database password
//define('PHPGRID_DB_NAME', 'sampledb'); // database name
//define('PHPGRID_DB_TYPE', 'postgres');  // database type
//define('PHPGRID_DB_CHARSET','');

// mssql server example
/*
define('PHPGRID_DB_HOSTNAME','phpgridmssql'); // database host name or DSN name
define('PHPGRID_DB_USERNAME', 'mssqluser');     // database user name
define('PHPGRID_DB_PASSWORD', ''); // database password
define('PHPGRID_DB_NAME', 'sampledb'); // database name
define('PHPGRID_DB_TYPE', 'odbc_mssql');  // database type
define('PHPGRID_DB_CHARSET','');

putenv("ODBCINSTINI=/usr/local/Cellar/unixodbc/2.3.1/etc/odbcinst.ini");
putenv("ODBCINI=/usr/local/Cellar/unixodbc/2.3.1/etc/odbc.ini"); //odbc.ini contains your DSNs.
*/

// oracle server example
//define('PHPGRID_DB_HOSTNAME','oracledb.mydomain.com');
//define('PHPGRID_DB_USERNAME', 'oracleuser');     // database user name
//define('PHPGRID_DB_PASSWORD', ''); // database password
//define('PHPGRID_DB_NAME', 'sampledb'); // database name
//define('PHPGRID_DB_TYPE', 'oci805');  // database type
//define('PHPGRID_DB_CHARSET','AL32UTF8');

// sqlite server example
//define('PHPGRID_DB_HOSTNAME','c:\path\to\sqlite.db'); // database host name
//define('PHPGRID_DB_USERNAME', '');     // database user name
//define('PHPGRID_DB_PASSWORD', ''); // database password
//define('PHPGRID_DB_NAME', ''); // database name
//define('PHPGRID_DB_TYPE', 'sqlite');  // database type
//define('PHPGRID_DB_CHARSET','');

// db2 example

/*
define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
define('PHPGRID_DB_USERNAME', 'db2user');     // database user name
define('PHPGRID_DB_PASSWORD', ''); // database password
define('PHPGRID_DB_NAME', 'sample'); // database name
define('PHPGRID_DB_TYPE', 'db2');  // database type
define('PHPGRID_DB_CHARSET','');
*/

/*
    $host = "localhost";	
    $usuariodb = "gapsegur_tactica";
    $pwddb = "viki52";
    $db = "gapsegur_webdre_tactica";
*/

// define('SERVER_ROOT', '/phpGrid_Professional');
 define('SERVER_ROOT', '/phpgrid_professional');
 


define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
define('PHPGRID_DB_USERNAME', 'gapsegur_tactica');     // database user name
define('PHPGRID_DB_PASSWORD', 'viki52'); // database password
define('PHPGRID_DB_NAME', 'gapsegur_webdre_tactica'); // database name  //sampledb
define('PHPGRID_DB_TYPE', 'mysql');  // database type
define('PHPGRID_DB_CHARSET','utf8'); // ex: utf8(for mysql),AL32UTF8 (for oracle), leave blank to use the default charset  // iso-8859-1

//--> define('SERVER_ROOT', '/web_gapseguros/web_tactica/www/Capsys_New/phpgrid_professional');



/******** DO NOT MODIFY ***********/
require_once('phpGrid.php');     
/**********************************/
?>