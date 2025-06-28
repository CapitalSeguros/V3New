<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			SEMACTIVIDAD 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_SEMACTIVIDAD = "Truncate Table `semactividad`";
		DreQueryDB($sqlMysql_Truncate_SEMACTIVIDAD);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				SEMACTIVIDAD 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_SEMACTIVIDAD = "
					Insert Into
						`semactividad`
							(
								`idActividad`
								, `usuario`
								, `semaforo`
							)
						Values
							(
								'".$fila->ID."'
								,'".$fila->USUARIOCREACION."'
								,'".$fila->ESTATUS."'
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_SEMACTIVIDAD)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_SEMACTIVIDAD = "
						Update 
							SEMACTIVIDAD 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ID = '".$fila->ID."'
												 ";

//-->					$resFireBird_Update_True_SEMACTIVIDAD = DreQueryDbFireBird($sqlFireBird_Update_True_SEMACTIVIDAD);
//-->					DreFreeResultDbFireBird($resFireBird_Update_True_SEMACTIVIDAD);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_SEMACTIVIDAD = "
						Update 
							SEMACTIVIDAD 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ID = '".$fila->ID."'
													 ";
					$resFireBird_Update_False_SEMACTIVIDAD = DreQueryDbFireBird($sqlFireBird_Update_False_SEMACTIVIDAD);
					DreFreeResultDbFireBird($resFireBird_Update_False_SEMACTIVIDAD);
				}
		}
		
					$sqlFireBird_Update_True_Parche_SEMACTIVIDAD = "
						Update 
							SEMACTIVIDAD 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
							";
					$resFireBird_Update_True_Parche_SEMACTIVIDAD = DreQueryDbFireBird($sqlFireBird_Update_True_Parche_SEMACTIVIDAD);
					DreFreeResultDbFireBird($resFireBird_Update_True_Parche_SEMACTIVIDAD);
					
				
		DreFreeResultDbFireBird($resFireBird);
		
				
	} else {
		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>