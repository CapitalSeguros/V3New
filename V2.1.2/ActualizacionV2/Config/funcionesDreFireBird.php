<?php
function DreConectarDbFireBird(){
	
	$Host_FireBird = 'agentecapital.ddns.net:c:\softsol\interfaces.fdb';
	//$Host_FireBird = 'C:\wamp\www\web_gapseguros\DbFireBird\INTERFACES.FDB';
	$UserDB_FireBird = 'SYSDBA';
	$PassDB_FireBird = 'masterkey';

	$enlaceFireBird = ibase_connect($Host_FireBird, $UserDB_FireBird, $PassDB_FireBird) or die("Error en la Conexion : ".ibase_errmsg());

    if (!$enlaceFireBird) {
        die('No conectado : ' . ibase_errmsg());
    }
    
	return 
		$enlaceFireBird;
}

function DreQueryDbFireBird($sql, $conexionDb){
	
	if(isset($conexionDb)){
		$res = ibase_query($conexionDb, $sql) or die(ibase_errmsg());
	} else {
		$res = ibase_query($sql) or die(ibase_errmsg());
	}
	
    return 
		$res;
}

function DreFreeResultDbFireBird($res){
	if(isset($res)){
		ibase_free_result($res);
	}
}

function DreDesconectarDbFireBird($conexion){
	if(isset($conexion)){
		ibase_close($conexion);
	}
}

?>