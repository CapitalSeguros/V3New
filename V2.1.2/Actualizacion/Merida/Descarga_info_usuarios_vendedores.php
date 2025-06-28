<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`NOMBRE` = REPLACE(`NOMBRE`,',','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'`','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'´','')
		,`NOMBRE` = REPLACE(`NOMBRE`, '\"', '')
		,`NOMBRE` = REPLACE(`NOMBRE`,'\r','')
		,`NOMBRE` = REPLACE(`NOMBRE`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
						
$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`EMAIL` = REPLACE(`EMAIL`,',','')
		,`EMAIL` = REPLACE(`EMAIL`,'`','')
		,`EMAIL` = REPLACE(`EMAIL`,'´','')
		,`EMAIL` = REPLACE(`EMAIL`, '\"', '')
		,`EMAIL` = REPLACE(`EMAIL`,'\r','')
		,`EMAIL` = REPLACE(`EMAIL`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`,',','')
		,`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`,'`','')
		,`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`,'´','')
		,`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`, '\"', '')
		,`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`,'\r','')
		,`TELEFONO_CASA` = REPLACE(`TELEFONO_CASA`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`,',','')
		,`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`,'`','')
		,`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`,'´','')
		,`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`, '\"', '')
		,`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`,'\r','')
		,`TELEFONO_CELULAR` = REPLACE(`TELEFONO_CELULAR`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,',','')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,'`','')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,'´','')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`, '\"', '')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,'\r','')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,'\n','')
		,`CUANTO_TE_GUSTARIA_GANAR` = REPLACE(`CUANTO_TE_GUSTARIA_GANAR`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,',','')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,'`','')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,'´','')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`, '\"', '')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,'\r','')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,'\n','')
		,`GASTO_PROMEDIO_MENSUAL` = REPLACE(`GASTO_PROMEDIO_MENSUAL`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,',','')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,'`','')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,'´','')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`, '\"', '')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,'\r','')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,'\n','')
		,`LUGAR_NACIMIENTO` = REPLACE(`LUGAR_NACIMIENTO`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,',','')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,'`','')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,'´','')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`, '\"', '')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,'\r','')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,'\n','')
		,`PASATIEMPO_FAVORITO` = REPLACE(`PASATIEMPO_FAVORITO`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,',','')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,'`','')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,'´','')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`, '\"', '')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,'\r','')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,'\n','')
		,`CLUB_SOCIAL` = REPLACE(`CLUB_SOCIAL`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `info_usuarios_vendedores` SET 
		`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,',','')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,'`','')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,'´','')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`, '\"', '')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,'\r','')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,'\n','')
		,`LICENCIA_MANEJAR` = REPLACE(`LICENCIA_MANEJAR`,'$','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
	

// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/info_usuarios_vendedores.txt"; //Definicion de archivo y ruta a cargar
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
		`info_usuarios_vendedores`
	Where
		`actualizado` = '1'
					";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	fputs($archivo,$rowArchivoSalida['VALOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NOMBRE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['APELLIDOS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['SUCURSAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CALLE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NO_EXT']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CRUZAMIENTO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['COLONIA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CP']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CIUDAD_ID']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['RFC']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_CASA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_CELULAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CIA_CEL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_TRABAJO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ESTADO_CIVIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['FECHA_NACIMIENTO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['LUGAR_NACIMIENTO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ESCOLARIDAD']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['EMAIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VEHICULO_PROPIO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CUENTA_BANCARIA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['BANCO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO_CUENTA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLABE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CEDULA_CNSF']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VIGENCIA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ACCIDENTE_AVISAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_ACCIDENTE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['RECOMENDADO_POR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['IMAGEN']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['IMSS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['REFERENCIAS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIENE_HIJOS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['GASTO_PROMEDIO_MENSUAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CUANTO_TE_GUSTARIA_GANAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CONSULTOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['MODELO_VEHICULO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO_AUT']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['COLOR_FAVORITO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['COMIDA_FAVORITA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ANIVERSARIO_BODAS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NIVEL_ESTUDIOS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['PASATIEMPO_FAVORITO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLUB_SOCIAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['LICENCIA_MANEJAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VIGENCIA_LICENCIA_MANEJAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['PASAPORTE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VIGENCIA_PASAPORTE']);
	fputs($archivo,"\n");
	
	$sqlUpdateActualizado = "Update `info_usuarios_vendedores` Set `actualizado` = '0' Where `VALOR` = '$rowArchivoSalida[VALOR]'";
	DreQueryDB($sqlUpdateActualizado);
}
  fclose($archivo);
  
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Info Usuarios Vendedores Correcto !!!";	
	include('CerrarVentana.php');
} 

?>