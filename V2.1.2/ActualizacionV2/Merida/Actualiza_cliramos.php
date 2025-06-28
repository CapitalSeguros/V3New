<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			CLIRAMOS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_CLIRAMOS = "Truncate Table `cliramos`";
		DreQueryDB($sqlMysql_Truncate_CLIRAMOS);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				CLIRAMOS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_CLIRAMOS = "
					Insert Into
						`cliramos`
							(
								`CLAVE_CLIENTE`
								,`RAMO_ID`
								,`RAMO`
								,`SUBRAMO_ID`
								,`SUBRAMO`
								,`POLIZA`
								,`FECHA_INI`
								,`FECHA_FIN`
								,`descripcion`							
							)
						Values
							(
								'".$fila->CLAVECLIENTE."'
								,'".$fila->RAMO_ID."'
								,'".$fila->RAMO."'
								,'".$fila->SUBRAMO_ID."'
								,'".$fila->SUBRAMO."'
								,'".$fila->POLIZA."'
								,'".$fila->FECHAINICIA."'
								,'".$fila->FECHAFIN."'
								,'".$fila->DESCRIPCION."'								
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_CLIRAMOS)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_CLIRAMOS_FAllO = "
						Update 
							CLIRAMOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
							And 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
					$sqlFireBird_Update_True_CLIRAMOS = "
						Delete From
							CLIRAMOS 
						Where 
							POLIZA = '".$fila->POLIZA."'
							And 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
//-->					$resFireBird_Update_True_CLIRAMOS = DreQueryDbFireBird($sqlFireBird_Update_True_CLIRAMOS);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_CLIRAMOS = "
						Update 
							CLIRAMOS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
							And 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
													 ";
					$resFireBird_Update_False_CLIRAMOS = DreQueryDbFireBird($sqlFireBird_Update_False_CLIRAMOS);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($sqlFireBird_Update_False_CLIRAMOS);
//-->		DreFreeResultDbFireBird($sqlFireBird_Update_True_CLIRAMOS);

					$sqlFireBird_Update_True_CLIRAMOS_FAllO = "
						Update 
							CLIRAMOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
							";
					$resFireBird_Update_True_CLIRAMOS_FALLO = DreQueryDbFireBird($sqlFireBird_Update_True_CLIRAMOS_FAllO);
					DreFreeResultDbFireBird($resFireBird_Update_True_CLIRAMOS_FALLO);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros


echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>