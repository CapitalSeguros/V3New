<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			VENDEDORES 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_VENDEDORES = "Truncate Table `vendedores`";
		DreQueryDB($sqlMysql_Truncate_VENDEDORES);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				VENDEDORES 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_VENDEDORES = "
					Insert Into
						`vendedores`
							(
								`CLAVE`
								,`NOMBRE`
								,`TIPO`
							)
						Values
							(
								'".$fila->VENDEDOR."'
								,'".$fila->NOMBRE."'
								,'".$fila->PROMOTOR."'
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_VENDEDORES)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_VENDEDORES = "
						Update 
							VENDEDORES 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
												 ";

					$resFireBird_Update_True_VENDEDORES = DreQueryDbFireBird($sqlFireBird_Update_True_VENDEDORES);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_VENDEDORES = "
						Update 
							VENDEDORES 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
													 ";
					$resFireBird_Update_False_VENDEDORES = DreQueryDbFireBird($sqlFireBird_Update_False_VENDEDORES);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($sqlFireBird_Update_False_VENDEDORES);
		DreFreeResultDbFireBird($sqlFireBird_Update_True_VENDEDORES);
				
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros
	
	// Mantenimiento
	$sqlMantenimiento = "Update `vendedores` Set `CLAVE` = LPAD(`CLAVE`,10,'0'), `TIPO` = LPAD(`TIPO`,10,'0')";
	DreQueryDB($sqlMantenimiento);

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>