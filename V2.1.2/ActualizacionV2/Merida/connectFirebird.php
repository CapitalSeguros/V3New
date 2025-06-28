<?php
//--> ibase_pconnect
//--> ibase_connect();

/** @-->

// Una base de datos en un PC con dirección IP || port 3050
//--> echo $host = "127.0.0.1:C:\\wamp\\www\\web_gapseguros\\web_tactica\\www\\Firebird\\INTERFACES.FDB";  //C:\\usr\\my database.fdb
//--> echo $host = "192.168.0.42:c:\softsol\interfaces.fdb";
echo $host = "agentecapital.ddns.net:c:\softsol\interfaces.fdb";
echo "<br>";
 
// El administrador de la base de datos
echo $username='SYSDBA';
echo "<br>";

// La contraseña pricipal
echo $password='masterkey';
echo "<br>";

// El rol no es requerido si ya soy un sysdba
echo $role = '';
echo "<br>";
 
// El comando de conexión
$conn = ibase_connect($host,
                      $username,
                      $password,
                      NULL,
                      0,
                      NULL,
                      $role) or die("Error al conectarse a la base de datos") ;

echo $sql = "Select * From PREPOLIZAS";
$res = ibase_query($sql);
while($row = ibase_fetch_object($res)){
	echo $row['POLIZA'];
	echo "<br>";	

}
@--> */
$host = 'agentecapital.ddns.net:c:\softsol\interfaces.fdb'; //'localhost:/ruta/a/su/base_de_datos.gdb';
$nombre_usuario = 'SYSDBA';
$contrasenya = 'masterkey';

$gestor_db = ibase_connect($host, $nombre_usuario, $contrasenya) or die("Error Enla Conexion");
$sentencia = 'SELECT * FROM PREPOLIZAS';
$gestor_sent = ibase_query($gestor_db, $sentencia);
while ($fila = ibase_fetch_object($gestor_sent)) {
    echo $fila->POLIZA, "\n";
}
ibase_free_result($gestor_sent);
ibase_close($gestor_db);
?>