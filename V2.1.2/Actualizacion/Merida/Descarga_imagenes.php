<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlCaracteresNoImprimibles = "
	Update `imagenes` SET 
		`DESCRIPCION` = REPLACE(`DESCRIPCION`,',','')
		,`DESCRIPCION` = REPLACE(`DESCRIPCION`,'`','')
		,`DESCRIPCION` = REPLACE(`DESCRIPCION`,'´','')
		,`DESCRIPCION` = REPLACE(`DESCRIPCION`, '\"', '')
		,`DESCRIPCION` = REPLACE(`DESCRIPCION`,'\r','')
		,`DESCRIPCION` = REPLACE(`DESCRIPCION`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `imagenes` SET 
		`POLIZA` = REPLACE(`POLIZA`,',','')
		,`POLIZA` = REPLACE(`POLIZA`,'`','')
		,`POLIZA` = REPLACE(`POLIZA`,'´','')
		,`POLIZA` = REPLACE(`POLIZA`, '\"', '')
		,`POLIZA` = REPLACE(`POLIZA`,'\r','')
		,`POLIZA` = REPLACE(`POLIZA`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);


$sqlCaracteresNoImprimibles = "
	Update `imagenes` SET 
		`VALOR` = REPLACE(`VALOR`,',','')
		,`VALOR` = REPLACE(`VALOR`,'`','')
		,`VALOR` = REPLACE(`VALOR`,'´','')
		,`VALOR` = REPLACE(`VALOR`, '\"', '')
		,`VALOR` = REPLACE(`VALOR`,'\r','')
		,`VALOR` = REPLACE(`VALOR`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/imagenes.txt"; //Definicion de archivo y ruta a cargar
if(file_exists($archivo_salida))
{
	//Accion cuando Existe el Archivo
	echo "Archivo Aun no Descargado por El Servidor en Sitio (Gap Seguros Merida, Yucatan)";
	include('CerrarVentana.php');
}else{
	//Accion NO cuando Existe el Archivo
	
	// proceso de generacion archivo salida pedidos

$sqlArchivoSalida = "
	Select * From `imagenes` Where `NO_ARCHIVO` Like '%W%' Or `NO_ARCHIVO` Like '%L%'
					";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	fputs($archivo,$rowArchivoSalida['NO_ARCHIVO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['EXTENSION']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['RUTA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['DESCRIPCION']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['POLIZA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VALOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO_IMG']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ESTATUS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLIENTE_MPRO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLIENTE_TMP']);
	fputs($archivo,",");
	fputs($archivo,(int) $rowArchivoSalida['SUCURSAL']);
	fputs($archivo,"\n");			
}
  fclose($archivo);
 //-- \r\n 
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Imagenes Correcto !!!";	
	include('CerrarVentana.php');
} 

?>