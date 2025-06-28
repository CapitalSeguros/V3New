<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlCaracteresNoImprimibles = "
	Update `contactos` SET 
		`NOMBRE` = REPLACE(`NOMBRE`,',','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'`','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'´','')
		,`NOMBRE` = REPLACE(`NOMBRE`, '\"', '')
		,`NOMBRE` = REPLACE(`NOMBRE`,'\r','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
						
$sqlCaracteresNoImprimibles = "
	Update `contactos` SET 
		`EMAIL` = REPLACE(`EMAIL`,',','')
		,`EMAIL` = REPLACE(`EMAIL`,'`','')
		,`EMAIL` = REPLACE(`EMAIL`,'´','')
		,`EMAIL` = REPLACE(`EMAIL`, '\"', '')
		,`EMAIL` = REPLACE(`EMAIL`,'\r','')
		,`EMAIL` = REPLACE(`EMAIL`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `contactos` SET 
		`TELEFONO` = REPLACE(`TELEFONO`,',','')
		,`TELEFONO` = REPLACE(`TELEFONO`,'`','')
		,`TELEFONO` = REPLACE(`TELEFONO`,'´','')
		,`TELEFONO` = REPLACE(`TELEFONO`, '\"', '')
		,`TELEFONO` = REPLACE(`TELEFONO`,'\r','')
		,`TELEFONO` = REPLACE(`TELEFONO`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `contactos` SET 
		`DIRECCION` = REPLACE(`DIRECCION`,',','')
		,`DIRECCION` = REPLACE(`DIRECCION`,'`','')
		,`DIRECCION` = REPLACE(`DIRECCION`,'´','')
		,`DIRECCION` = REPLACE(`DIRECCION`, '\"', '')
		,`DIRECCION` = REPLACE(`DIRECCION`,'\r','')
		,`DIRECCION` = REPLACE(`DIRECCION`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/contactos.txt"; //Definicion de archivo y ruta a cargar
if(file_exists($archivo_salida))
{
	//Accion cuando Existe el Archivo
	echo "Archivo Aun no Descargado por El Servidor en Sitio (Gap Seguros Merida, Yucatan)";
	include('CerrarVentana.php');
}else{
	//Accion NO cuando Existe el Archivo
	
	// proceso de generacion archivo salida pedidos

$sqlArchivoSalida = "
	Select * From 
		`contactos` 
	Where 
		`actualizado` = '1'
					";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	

	fputs($archivo,$rowArchivoSalida['CLAVE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NOMBRE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['EMAIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['DIRECCION']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VENDEDOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLAVEWEB']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['correoMasivo']);
	fputs($archivo,"\n");
	
	$sqlUpdateActualizado = "Update `contactos` Set `actualizado` = '0' Where `idContacto` = '$rowArchivoSalida[idContacto]'";
	DreQueryDB($sqlUpdateActualizado);			
}
  fclose($archivo);
  
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Contactos Correcto !!!";	
	include('CerrarVentana.php');
} 

?>