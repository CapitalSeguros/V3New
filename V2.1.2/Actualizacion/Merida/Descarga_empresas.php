<?php
include('../../config/funcionesDre.php');
$conexionDB = DreConectarDB(); // Efectuamos la Conexion a la DB

//Query Limpieza
$sqlMantenimiento = "
	Select * From
		`empresas` 
	Where 
		`VENDEDOR` Not Like '0%'
					";
$resMantenimiento = DreQueryDB($sqlMantenimiento);
while($rowMantenimiento = mysql_fetch_assoc($resMantenimiento)){
	$rowMantenimiento['VENDEDOR'];
	$rowMantenimiento['CLAVE'];
	$sqlBuscamosVendedor = "
		Select * From 
			`usuarios`
		Where
			`NOMBRE` Like '%$rowMantenimiento[VENDEDOR]%'
		Limit 0,1
						   ";
	$resBuscamosVendedor = DreQueryDB($sqlBuscamosVendedor);
	$rowBuscamosVendedor = mysql_fetch_assoc($resBuscamosVendedor);
	$rowBuscamosVendedor['VALOR'];
	
	$sqlUpdateVendedorEmpresa = "
		Update
			`empresas`
		Set
			`VENDEDOR` = '$rowBuscamosVendedor[VALOR]'
		Where	
			`CLAVE` = '$rowMantenimiento[CLAVE]'
								";
	DreQueryDB($sqlUpdateVendedorEmpresa);	
}

$sqlMantenimiento2 = "
	Select * From
		`empresas` 
	Where 
		`ESTADO` Like '%-%'
					 ";
$resMantenimiento2 = DreQueryDB($sqlMantenimiento2);
while($rowMantenimiento2 = mysql_fetch_assoc($resMantenimiento2)){
	$sqlUpdateEstado = "
		Update 
			`empresas`
		Set
			`ESTADO` = 'YUCATAN'
		Where
			`CLAVE` = '$rowMantenimiento2[CLAVE]'
					   ";
	DreQueryDB($sqlUpdateEstado);
}
					 

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`,',','')
		,`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`,'`','')
		,`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`,'´','')
		,`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`, '\"', '')
		,`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`,'\r','')
		,`APELLIDO_PATERNO` = REPLACE(`APELLIDO_PATERNO`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);
						
$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`,',','')
		,`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`,'`','')
		,`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`,'´','')
		,`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`, '\"', '')
		,`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`,'\r','')
		,`APELLIDO_MATERNO` = REPLACE(`APELLIDO_MATERNO`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`NOMBRES` = REPLACE(`NOMBRES`,',','')
		,`NOMBRES` = REPLACE(`NOMBRES`,'`','')
		,`NOMBRES` = REPLACE(`NOMBRES`,'´','')
		,`NOMBRES` = REPLACE(`NOMBRES`, '\"', '')
		,`NOMBRES` = REPLACE(`NOMBRES`,'\r','')
		,`NOMBRES` = REPLACE(`NOMBRES`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`,',','')
		,`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`,'`','')
		,`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`,'´','')
		,`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`, '\"', '')
		,`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`,'\r','')
		,`RAZON_SOCIAL` = REPLACE(`RAZON_SOCIAL`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`CALLE` = REPLACE(`CALLE`,',','')
		,`CALLE` = REPLACE(`CALLE`,'`','')
		,`CALLE` = REPLACE(`CALLE`,'´','')
		,`CALLE` = REPLACE(`CALLE`, '\"', '')
		,`CALLE` = REPLACE(`CALLE`,'\r','')
		,`CALLE` = REPLACE(`CALLE`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`NOEXTERIOR` = REPLACE(`NOEXTERIOR`,',','')
		,`NOEXTERIOR` = REPLACE(`NOEXTERIOR`,'`','')
		,`NOEXTERIOR` = REPLACE(`NOEXTERIOR`,'´','')
		,`NOEXTERIOR` = REPLACE(`NOEXTERIOR`, '\"', '')
		,`NOEXTERIOR` = REPLACE(`NOEXTERIOR`,'\r','')
		,`NOEXTERIOR` = REPLACE(`NOEXTERIOR`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlCaracteresNoImprimibles = "
	Update `empresas` SET 
		`COLONIA` = REPLACE(`COLONIA`,',','')
		,`COLONIA` = REPLACE(`COLONIA`,'`','')
		,`COLONIA` = REPLACE(`COLONIA`,'´','')
		,`COLONIA` = REPLACE(`COLONIA`, '\"', '')
		,`COLONIA` = REPLACE(`COLONIA`,'\r','')
		,`COLONIA` = REPLACE(`COLONIA`,'\n','')
						";
DreQueryDB($sqlCaracteresNoImprimibles);

$sqlComplatamosTipoRegistro = "
	Update `empresas` Set `TIPO_REGISTRO` = 'PR' Where `CLAVE` Like '%W%' And  `TIPO_REGISTRO` = ''
							  ";
DreQueryDB($sqlComplatamosTipoRegistro);

// validamos la existencia  o no del Archivo de salida si este existe no hacemos nada mas que imprimir 
// la exixtencia del mismo
$archivo_salida = "../../syncronizacion/Merida/salida/empresas.txt"; //Definicion de archivo y ruta a cargar
if(file_exists($archivo_salida))
{
	//Accion cuando Existe el Archivo
	echo "Archivo Aun no Descargado por El Servidor en Sitio (Gap Seguros Merida, Yucatan)";
	include('CerrarVentana.php');
}else{
	//Accion NO cuando Existe el Archivo
	
	// proceso de generacion archivo salida pedidos

$sqlArchivoSalida = "
	Select * From `empresas` Where `actualizado` = '1' And `estatusCliente` = 'A'
					";
$resArchivoSalida = DreQueryDB($sqlArchivoSalida);

// Ahora vamos a caminar registro por registro y tirarlos línea por línea y delimitado por comas
$archivo = fopen($archivo_salida,'a+') or die("Problemas en la creacion del Archivo ".$archivo_salida);
while($rowArchivoSalida = mysql_fetch_assoc($resArchivoSalida)){
	
	fputs($archivo,$rowArchivoSalida['CLAVE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['APELLIDO_PATERNO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['APELLIDO_MATERNO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NOMBRES']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['RAZON_SOCIAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO_PERSONA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['RFC']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CURP']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CALLE']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NOEXTERIOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NOINTERIOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['REFERENCIA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['REFERENCIA2']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['COLONIA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CODIGO_POSTAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['LOCALIDAD']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['MUNICIPO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ESTADO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['PAIS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['FECHA_NACIMIENTO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NACIONALIDAD']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['NIVEL_ESTUDIOS']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['AUTOMOVIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['EDAD']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['ESTADO_CIVIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['GENERO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['VENDEDOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['LIMITE_FIANZA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_PARTICULAR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_OFICINA']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TELEFONO_MOVIL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['SITIO_WEB']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TWITTER']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['FACEBOOK']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['CLAVEWEB']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['SUCURSAL']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['PROMOTOR']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['TIPO_REGISTRO']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['email']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['Club_Cap']);
	fputs($archivo,",");
	fputs($archivo,$rowArchivoSalida['Poliza_Electronica']);
	
	fputs($archivo,"\n");			
	
	$sqlUpdateActualizado = "Update `empresas` Set `actualizado` = '0' Where `CLAVE` = '$rowArchivoSalida[CLAVE]'";
	DreQueryDB($sqlUpdateActualizado);
	
}
  fclose($archivo);
  
DreDesconectarDB($conexionDB); // Cerramos la Conexion a la DB
// Termina Grabamos el Numero del Cliente Guardado
	echo "Generacion de Archivo Empresas Correcto !!!";	
	include('CerrarVentana.php');
} 

?>