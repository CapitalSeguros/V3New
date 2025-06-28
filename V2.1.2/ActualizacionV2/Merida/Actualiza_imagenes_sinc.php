<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			IMAGENES_SINC
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		echo "si hay registros a procesar";
			
//-->		$sqlMysql_Truncate_IMAGENES_SINC = "Truncate Table `imagenes_sinc`";
//-->		DreQueryDB($sqlMysql_Truncate_IMAGENES_SINC);
		
		$sqlFireBird = "
			Select 
--				First 10
			*
			From 
				IMAGENES_SINC
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Insert_IMAGENES_SINC = "
				Insert Into
					`imagenes_sinc` 
							(
								`NO_ARCHIVO`
								, `EXTENSION`
								, `RUTA`
								, `DESCRIPCION`
								, `TIPO`
								, `POLIZA`
								, `VALOR`
								, `TIPO_IMG`
								, `ESTATUS`
								, `CLIENTE_MPRO`
								, `CLIENTE_TMP`
								, `NOMBRE_CLIENTE`
								, `FECHA_ALTA`
								, `SUCURSAL`
								, `recId`
								, `subRamo`
							) 
						VALUES 
							(
								'".$fila->NO_ARCHIVO."'
								,'".$fila->EXTENSION."'
								,'".$fila->RUTA."'
								,'".$fila->DESCRIPCION."'
								,'".$fila->TIPO."'
								,'".$fila->POLIZA."'
								,'".$fila->VALOR."'
								,'".$fila->TIPO_IMG."'
								,'".$fila->ESTATUS."'
								,'".$fila->CLIENTEM."'
								,'".$fila->CLIENTED."'
								,'".$fila->NOMBRE_CLIENTE."'
								,'".$fila->FECHA_HORA_ALTA."'
								,'".$fila->SUCURSAL."'
								,'".$fila->REC_ID."'
								,'".$fila->SUBRAMO."'
							);

										  ";
//-->			echo "<pre>";
	//-->			echo $sqlMysql_Insert_IMAGENES_SINC;
//-->			echo "</pre>";
			DreQueryDB($sqlMysql_Insert_IMAGENES_SINC);
		}

	$sqlFireBird_Update_IMAGENES_SINC = "
		Update 
			IMAGENES_SINC 
		Set 
			TOCADO = 'SI'
			,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";
	$resFireBird_Update_IMAGENES_SINC = DreQueryDbFireBird($sqlFireBird_Update_IMAGENES_SINC);

	DreFreeResultDbFireBird($resFireBird_Update_IMAGENES_SINC);

		
	} else {

		echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>