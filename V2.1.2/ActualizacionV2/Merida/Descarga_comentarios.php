<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_COMENTARIOS = "
		Select Count(*) As `existenRegistros` From
			`cobranzapendiente_comentarios`
		Where
			`status` = '0'
												 ";
	$resMysql_Validacion_Registros_COMENTARIOS = DreQueryDB($sqlMysql_Validacion_Registros_COMENTARIOS);
	$rowMysql_Validacion_Registros_COMENTARIOS = mysql_fetch_assoc($resMysql_Validacion_Registros_COMENTARIOS);
	
	if((int)$rowMysql_Validacion_Registros_COMENTARIOS['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_COMENTARIOS = "
			Delete From
				COMENTARIOS_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_COMENTARIOS = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_COMENTARIOS);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_COMENTARIOS);
		
		$sqlMysql_Registros_COMENTARIOS = "
			Select * From
				`cobranzapendiente_comentarios`
		Where
			`status` = '0'
										  ";
		$resMysql_Registros_COMENTARIOS = DreQueryDB($sqlMysql_Registros_COMENTARIOS);
		while($rowMysql_Registros_COMENTARIOS = mysql_fetch_assoc($resMysql_Registros_COMENTARIOS)){

// poliza
$var_SqlFireBird_poliza
	= 
	($rowMysql_Registros_COMENTARIOS['poliza']!='')? "'".substr($rowMysql_Registros_COMENTARIOS['poliza'],0,50)."'" : " NULL";

// comentario
$var_SqlFireBird_comentario
	=
	($rowMysql_Registros_COMENTARIOS['comentario']!='')? "'".substr($rowMysql_Registros_COMENTARIOS['comentario'],0,500)."'" : " NULL";
	
// fecha
$var_SqlFireBird_fecha
	=
	($rowMysql_Registros_COMENTARIOS['fecha']!='')? "'".substr($rowMysql_Registros_COMENTARIOS['fecha'],0,16)."'" : " NULL";
	
// operador
$var_SqlFireBird_operador
	=
	($rowMysql_Registros_COMENTARIOS['operador']!='')? "'".substr($rowMysql_Registros_COMENTARIOS['operador'],0,20)."'" : " NULL";
	
// origen
$var_SqlFireBird_origen
	=
	($rowMysql_Registros_COMENTARIOS['origen']!='')? "'".substr($rowMysql_Registros_COMENTARIOS['origen'],0,1)."'" : " NULL";
							
			$sqlFireBird_Insert_Registro_COMENTARIOS = "
				Insert Into 
					COMENTARIOS_DESCARGA
						(
							POLIZA
							, COMENTARIO
							, FECHA
							, OPERADOR
							, ORIGEN
							, TOCADO
 							, FECHAPROCESO
						) 
						Values
						(
							".$var_SqlFireBird_poliza."
							,".$var_SqlFireBird_comentario."
							,".$var_SqlFireBird_fecha."
							,".$var_SqlFireBird_operador."
							,".$var_SqlFireBird_origen."
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_COMENTARIOS;
	//			echo $sqlMysql_Update_Registro_COMENTARIOS;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_COMENTARIOS = DreQueryDbFireBird($sqlFireBird_Insert_Registro_COMENTARIOS);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_COMENTARIOS);
	
			$sqlMysql_Update_Registro_COMENTARIOS = "
				Update
					`cobranzapendiente_comentarios`
				Set
					 `actualizado` = '1'
				Where 
					`NO_ARCHIVO` = '".$rowMysql_Registros_COMENTARIOS['NO_ARCHIVO']."'
											  ";
			// 0 => Sin Descargar;  1=> Descargado;
//			DreQueryDB($sqlMysql_Update_Registro_COMENTARIOS);
			

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