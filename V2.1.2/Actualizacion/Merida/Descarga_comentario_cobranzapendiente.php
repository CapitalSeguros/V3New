<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlCaracteresNoImprimibles = "
	Update `cobranzapendiente_comentarios` SET 
		`poliza` = REPLACE(`poliza`,',','')
		,`poliza` = REPLACE(`poliza`,'`','')
		,`poliza` = REPLACE(`poliza`,'´','')
		,`poliza` = REPLACE(`poliza`, '\"', '')
		,`poliza` = REPLACE(`poliza`,'\r','')
		,`poliza` = REPLACE(`poliza`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
						
$sqlCaracteresNoImprimibles = "
	Update `cobranzapendiente_comentarios` SET 
		`comentario` = REPLACE(`comentario`,',','')
		,`comentario` = REPLACE(`comentario`,'`','')
		,`comentario` = REPLACE(`comentario`,'´','')
		,`comentario` = REPLACE(`comentario`, '\"', '')
		,`comentario` = REPLACE(`comentario`,'\r','')
		,`comentario` = REPLACE(`comentario`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/comentario.txt"; //Definicion de archivo y ruta a cargar
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
		`cobranzapendiente_comentarios`
	Where
		`status` = '0'
					";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	fputs($archivo,$rowArchivoSalida['poliza']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['comentario']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fecha']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['operador']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['origen']);
	fputs($archivo,"\n");
	
	$sqlUpdateActualizado = "Update `cobranzapendiente_comentarios` Set `status` = '1' Where `idComentario` = '$rowArchivoSalida[idComentario]'";
	DreQueryDB($sqlUpdateActualizado);			
}
  fclose($archivo);
  
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Comentarios Correcto !!!";	
	include('CerrarVentana.php');
} 

?>