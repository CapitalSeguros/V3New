<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			PREPOLIZAS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_prepolizas = "Truncate Table `prepolizas`";
		DreQueryDB($sqlMysql_Truncate_prepolizas);
		
		$sqlFireBird = "
			Select * From 
				PREPOLIZAS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Insert_prepolizas = "
				Insert Into
					`prepolizas`
						(
							`Poliza`
							,`FechaPago`
							,`ClaveCliente`
							,`Seguimiento`
							,`VendedorId`
							,`RamoId`
							,`FechaDesde`
							,`FechaHasta`
							,`Importe`
							,`Comentario`
							,`PromotorId`
						)
					Values
						(
							'".$fila->POLIZA."'
							,'".$fila->FECHA_PAGO."'
							,'".$fila->CLAVE_CLIENTE."'
							,'".$fila->SEGUIMIENTO."'
							,'".$fila->VENDEDOR."'
							,'".$fila->RAMO."'
							,'".$fila->FECHAI."'
							,'".$fila->FECHAF."'
							,'".$fila->IMPORTE."'
							,'".$fila->COMENTARIO."'						
							,'".$fila->CONSULTOR_ID."'
						);
										  ";

			if(DreQueryDB($sqlMysql_Insert_prepolizas)){
				$sqlFireBird_Update_PREPOLIZAS = "
					Update 
					PREPOLIZAS 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
				Where 
					POLIZA = '".$fila->POLIZA."'
												 ";
//-->				$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_PREPOLIZAS);
			} else {
				$sqlFireBird_Update_PREPOLIZAS = "
					Update 
					PREPOLIZAS 
				Set 
					TOCADO = 'NO'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
				Where 
					POLIZA = '".$fila->POLIZA."'
												 ";
//-->				$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_PREPOLIZAS);
			}
		}

	$sqlFireBird_Update_PREPOLIZAS = "
		Update 
			PREPOLIZAS 
		Set 
			TOCADO = 'SI'
			,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";
	$resFireBird_Update_PREPOLIZAS = DreQueryDbFireBird($sqlFireBird_Update_PREPOLIZAS);

	DreFreeResultDbFireBird($resFireBird_Update_PREPOLIZAS);
//-->		DreFreeResultDbFireBird($resFireBird);
//-->		DreFreeResultDbFireBird($resFireBird_2);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

	//echo "<pre>";
		//echo $fila->POLIZA."<br>";
		//echo $sqlMysql_Insert_prepolizas;
		//echo $sqlFireBird_Update_PREPOLIZAS;
	//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>