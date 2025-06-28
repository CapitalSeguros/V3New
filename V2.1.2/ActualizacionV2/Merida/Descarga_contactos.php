<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_CONTACTOS = "
		Select Count(*) As `existenRegistros` From
			`contactos`
		Where 
			`actualizado` = '1'
									 ";
	$resMysql_Validacion_Registros_CONTACTOS = DreQueryDB($sqlMysql_Validacion_Registros_CONTACTOS);
	$rowMysql_Validacion_Registros_CONTACTOS = mysql_fetch_assoc($resMysql_Validacion_Registros_CONTACTOS);
	
	if((int)$rowMysql_Validacion_Registros_CONTACTOS['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_CONTACTOS = "
			Delete From
				CONTACTOS_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_CONTACTOS = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_CONTACTOS);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_CONTACTOS);
		
		
		$sqlMysql_Registros_CONTACTOS = "
		Select * From
			`contactos`
		Where 
			`actualizado` = '1'
		Limit 0,100
							  ";
		$resMysql_Registros_CONTACTOS = DreQueryDB($sqlMysql_Registros_CONTACTOS);
		while($rowMysql_Registros_CONTACTOS = mysql_fetch_assoc($resMysql_Registros_CONTACTOS)){

// CLAVE
$var_SqlFireBird_CLAVE
	= 
	($rowMysql_Registros_CONTACTOS['CLAVE']!='')? "'".substr($rowMysql_Registros_CONTACTOS['CLAVE'],0,20)."'" : " NULL";

// TIPO
$var_SqlFireBird_TIPO
	=
	($rowMysql_Registros_CONTACTOS['TIPO']!='')? "'".substr($rowMysql_Registros_CONTACTOS['TIPO'],0,10)."'" : " NULL";
	
// NOMBRE
$var_SqlFireBird_NOMBRE
	=
	($rowMysql_Registros_CONTACTOS['NOMBRE']!='')? "'".substr($rowMysql_Registros_CONTACTOS['NOMBRE'],0,100)."'" : " NULL";
	
// EMAIL
$var_SqlFireBird_EMAIL
	=
	($rowMysql_Registros_CONTACTOS['EMAIL']!='')? "'".substr($rowMysql_Registros_CONTACTOS['EMAIL'],0,50)."'" : " NULL";
	
// TELEFONO
$var_SqlFireBird_TELEFONO
	=
	($rowMysql_Registros_CONTACTOS['TELEFONO']!='')? "'".substr($rowMysql_Registros_CONTACTOS['TELEFONO'],0,50)."'" : " NULL";

// DIRECCION
$var_SqlFireBird_DIRECCION
	=
	($rowMysql_Registros_CONTACTOS['DIRECCION']!='')? "'".substr(str_replace($quitarCosas, $ponerCosas, $rowMysql_Registros_CONTACTOS['DIRECCION']),0,100)."'" : " NULL";
	
// VENDEDOR
$var_SqlFireBird_VENDEDOR
	=
	($rowMysql_Registros_CONTACTOS['VENDEDOR']!='')? "'".substr($rowMysql_Registros_CONTACTOS['VENDEDOR'],0,10)."'" : " NULL";

// promotor
$var_SqlFireBird_promotor
	=
	($rowMysql_Registros_CONTACTOS['promotor']!='')? "'".substr($rowMysql_Registros_CONTACTOS['promotor'],0,10)."'" : " NULL";
	
// SUCURSAL
$var_SqlFireBird_SUCURSAL
	=
	($rowMysql_Registros_CONTACTOS['SUCURSAL']!='')? "'".substr($rowMysql_Registros_CONTACTOS['SUCURSAL'],0,2)."'" : " NULL";
	
// ES_DIR_PRINCIPAL
$var_SqlFireBird_ES_DIR_PRINCIPAL
	=
	($rowMysql_Registros_CONTACTOS['ES_DIR_PRINCIPAL']!='')? "'".substr($rowMysql_Registros_CONTACTOS['ES_DIR_PRINCIPAL'],0,1)."'" : " NULL";
							
			$sqlFireBird_Insert_Registro_CONTACTOS = "
				Insert Into 
					CONTACTOS_DESCARGA
						(
							CLAVECLIENTE
							, TIPO
							, NOMBRE
							, EMAIL
							, TELEFONO
							, DIRECCION
							, VENDEDOR
							, PROMOTOR
							, SUCURSAL
							, ES_DIR_PRINCIPAL
							, TOCADO
							, FECHAPROCESO
						) 
						Values
						(
							".$var_SqlFireBird_CLAVE."
							,".$var_SqlFireBird_TIPO."
							,".$var_SqlFireBird_NOMBRE."
							,".$var_SqlFireBird_EMAIL."
							,".$var_SqlFireBird_TELEFONO."
							,".$var_SqlFireBird_DIRECCION."
							,".$var_SqlFireBird_VENDEDOR."
							,".$var_SqlFireBird_promotor."
							,".$var_SqlFireBird_SUCURSAL."
							,".$var_SqlFireBird_ES_DIR_PRINCIPAL."
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_CONTACTOS;
	//			echo $sqlMysql_Update_Registro_CONTACTOS;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_CONTACTOS = DreQueryDbFireBird($sqlFireBird_Insert_Registro_CONTACTOS);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_CONTACTOS);
	
			$sqlMysql_Update_Registro_CONTACTOS = "
				Update
					`contactos`
				Set
					 `actualizado` = '0'
				Where 
					`idContacto` = '".$rowMysql_Registros_CONTACTOS['idContacto']."'
											  ";
			// 1 => Sin Descargar;  0=> Descargado;
			DreQueryDB($sqlMysql_Update_Registro_CONTACTOS);
			

		}		
		
		//-->
		
	} else { // ELSE If existenRegistrosMysql
		//echo "No hay Registros a Procesar<br>";
		
		//-->
				
	}// Fin If existenRegistrosMysql

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>