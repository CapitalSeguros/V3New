<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlCaracteresNoImprimibles = "
	Update `actividades` SET 
		`comenResultado` = REPLACE(`comenResultado`,',','')
		,`comenResultado` = REPLACE(`comenResultado`,'`','')
		,`comenResultado` = REPLACE(`comenResultado`,'´','')
		,`comenResultado` = REPLACE(`comenResultado`, '\"', '')
		,`comenResultado` = REPLACE(`comenResultado`,'\r',' ')
		,`comenResultado` = REPLACE(`comenResultado`,'\n',' ')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `actividades` SET 
		`referencia` = REPLACE(`referencia`,',','')
		,`referencia` = REPLACE(`referencia`,'`','')
		,`referencia` = REPLACE(`referencia`,'´','')
		,`referencia` = REPLACE(`referencia`, '\"', '')
		,`referencia` = REPLACE(`referencia`,'\r',' ')
		,`referencia` = REPLACE(`referencia`,'\n',' ')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
				
$sqlCaracteresNoImprimibles = "
	Update `actividades` SET 
		`ubicacion` = REPLACE(`ubicacion`,',','')
		,`ubicacion` = REPLACE(`ubicacion`,'`','')
		,`ubicacion` = REPLACE(`ubicacion`,'´','')
		,`ubicacion` = REPLACE(`ubicacion`, '\"', '')
		,`ubicacion` = REPLACE(`ubicacion`,'\r','')
		,`ubicacion` = REPLACE(`ubicacion`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
/*
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
*/
// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/actividades.txt"; //Definicion de archivo y ruta a cargar
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
		`actividades`
	Where 
		`ubicacion` != 'LOCAL'
		And
		`fechaActualizacion` >= Curdate(); -- '2014-05-09';
					";

//echo "<pre>";
	//echo $sqlArchivoSalida;
//echo "</pre>";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	
	fputs($archivo,$rowArchivoSalida['idInterno']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['idInternoMd5']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['recId']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['idRef']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['tipo']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['inicio']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fin']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['actividadInterno']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ramoInterno']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['referencia']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['actividad']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ubicacion']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['prioridad']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['usuario']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['usuarioCreacion']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fechaCreacion']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fechaProgramada']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fechaTermino']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['cantidadVecesTrasladada']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['fechaOriginal']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['Resultado']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['comenResultado']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['cotizacionEmision']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['aseguradoraUno']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['aseguradoraDos']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['aseguradoraTres']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['aseguradoraCuatro']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['usuarioBolita']);
	fputs($archivo,"\n");
	
	//$sqlUpdateActualizado = "Update `contactos` Set `actualizado` = '0' Where `idContacto` = '$rowArchivoSalida[idContacto]'";
	//DreQueryDB($sqlUpdateActualizado);			
}
  fclose($archivo);
  
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Actividades Correcto !!!";	
	include('CerrarVentana.php');
} 

?>