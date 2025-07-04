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

define('SERVER_ROOT','http://v3prod.capsys.site/assets/phpgrid/'); //** /var/www/html/V3/assets/phpgrid
//* define('SERVER_ROOT','http://localhost/web_capsys/www/V3/assets/phpgrid');

define('PHPGRID_DB_HOSTNAME','localhost'); // database host name
define('PHPGRID_DB_USERNAME', 'capsysWeb');     // database user name
define('PHPGRID_DB_PASSWORD', 'Wedn$52'); // database password
define('PHPGRID_DB_NAME', 'capsysV3'); // database name  //sampledb
define('PHPGRID_DB_TYPE', 'mysql');  // database type
define('PHPGRID_DB_CHARSET','utf8'); // ex: utf8(for mysql),AL32UTF8 (for oracle), leave blank to use the default charset  // iso-8859-1
//define('DEBUG', true);
/******** DO NOT MODIFY ***********/
require_once('phpGrid.php');     
/**********************************/
?>