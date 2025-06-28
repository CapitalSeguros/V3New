<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_DEDUCCIONES = "
		Select Count(*) As `existenRegistros` From
			`tienda_pedidos_pagar`
		Where 
			`enviado` = '0'
									 ";
	$resMysql_Validacion_Registros_DEDUCCIONES = DreQueryDB($sqlMysql_Validacion_Registros_DEDUCCIONES);
	$rowMysql_Validacion_Registros_DEDUCCIONES = mysql_fetch_assoc($resMysql_Validacion_Registros_DEDUCCIONES);
	
	if((int)$rowMysql_Validacion_Registros_DEDUCCIONES['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_DEDUCCIONES = "
			Delete From
				DEDUCCIONES_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_DEDUCCIONES = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_DEDUCCIONES);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_DEDUCCIONES);
		
		
		$sqlMysql_Registros_DEDUCCIONES = "
			Select * From
				`tienda_pedidos_pagar`
			`tienda_pedidos_pagar`
		Where 
			`enviado` = '0'
										  ";
		$resMysql_Registros_DEDUCCIONES = DreQueryDB($sqlMysql_Registros_DEDUCCIONES);
		while($rowMysql_Registros_DEDUCCIONES = mysql_fetch_assoc($resMysql_Registros_DEDUCCIONES)){

// usuario
$var_SqlFireBird_usuario
	= 
	($rowMysql_Registros_DEDUCCIONES['usuario']!='')? "'".substr($rowMysql_Registros_DEDUCCIONES['usuario'],0,20)."'" : " NULL";

// fechaPago
$var_SqlFireBird_fechaPago
	=
	($rowMysql_Registros_DEDUCCIONES['fechaPago']!='')? "'".substr($rowMysql_Registros_DEDUCCIONES['fechaPago'],0,16)."'" : " NULL";
	
// importe
$var_SqlFireBird_importe
	=
	($rowMysql_Registros_DEDUCCIONES['importe']!='')? "".substr((float)$rowMysql_Registros_DEDUCCIONES['importe'],0,17)."" : " NULL";
	
// descripcion
$var_SqlFireBird_descripcion
	=
	($rowMysql_Registros_DEDUCCIONES['descripcion']!='')? "'".substr($rowMysql_Registros_DEDUCCIONES['descripcion'],0,500)."'" : " NULL";
	
							
			$sqlFireBird_Insert_Registro_DEDUCCIONES = "
				Insert Into 
					DEDUCCIONES_DESCARGA
						(
							CLAVE_VENDEDOR
							, FECHA
							, IMPORTE
							, DESCRIPCION
							, TOCADO
							, FECHAPROCESO
						) 
						Values
						(
							".$var_SqlFireBird_usuario."
							,".$var_SqlFireBird_fechaPago."
							,".$var_SqlFireBird_importe."
							,".$var_SqlFireBird_descripcion."
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_DEDUCCIONES;
	//			echo $sqlMysql_Update_Registro_DEDUCCIONES;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_DEDUCCIONES = DreQueryDbFireBird($sqlFireBird_Insert_Registro_DEDUCCIONES);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_DEDUCCIONES);
	
			$sqlMysql_Update_Registro_DEDUCCIONES = "
				Update
					`tienda_pedidos_pagar`
				Set
					 `enviado` = '1'
				Where 
					`idPago` = '".$rowMysql_Registros_DEDUCCIONES['idPago']."'
											  ";
			// 0 => Sin Descargar;  1=> Descargado;
			DreQueryDB($sqlMysql_Update_Registro_DEDUCCIONES);
			
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