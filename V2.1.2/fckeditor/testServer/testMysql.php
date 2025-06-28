<?
    $host = "localhost";	
    $usuariodb = "gapsegur_tactica";
    $pwddb = "viki52";
    $db = "gapsegur_webdre_tactica";

    $enlace = mysql_connect($host,$usuariodb,$pwddb) or die("No pudo conectarse : " . mysql_error());
    if (!$enlace) {
        die('No conectado : ' . mysql_error());
    }
    $seldb = mysql_select_db($db,$enlace);
    if (!$seldb) {
        die ('No se puede usar la base de datos' . mysql_error());
    }

?>