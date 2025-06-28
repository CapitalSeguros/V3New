<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			ORGANIZACIONES 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_ORGANIZACIONES = "Truncate Table `organizaciones`";
		//-->DreQueryDB($sqlMysql_Truncate_ORGANIZACIONES);
		
		$sqlFireBird = "
			Select * From 
				ORGANIZACIONES 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			$sqlMysql_Validacion_ORGANIZACIONES = "
				Select * From 
					`organizaciones`
				Where 
					`id` = '".$fila->ORGANIZACION_ID."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_ORGANIZACIONES)) == 0 ){ // validamos que no exista la empresa
				//-->
				$sqlMysql_Insert_ORGANIZACIONES = "
					Insert Into
						`organizaciones`
							(
								`id`
								,`Nombre`
								,`Descripcion`
								,`Es_Aseguradora`
							)
						Values
							(
								'".$fila->ORGANIZACION_ID."'
								,'".$fila->NOMBRE."'
								,'".$fila->DESCRIPCION."'
								,'".$fila->ES_ASEGURADORA."'
							);
											";

				if(DreQueryDB($sqlMysql_Insert_ORGANIZACIONES)){
					$sqlFireBird_Update_ORGANIZACIONES = "
						Update 
							ORGANIZACIONES 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_ORGANIZACIONES);
				} else {
					$sqlFireBird_Update_ORGANIZACIONES = "
						Update 
							ORGANIZACIONES 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_ORGANIZACIONES);
				}
			
				
			} else { // ELSE validamos que no exista la empresa
				$sqlMysql_Update_ORGANIZACIONES = "
					Update
						`organizaciones`
					Set
						`Nombre`='".$fila->NOMBRE."'
						,`Descripcion`='".$fila->DESCRIPCION."'
						,`Es_Aseguradora`='".$fila->ES_ASEGURADORA."'
					Where
						`id` = '".$fila->ORGANIZACION_ID."'
								";

				if(DreQueryDB($sqlMysql_Update_ORGANIZACIONES)){
					$sqlFireBird_Update_ORGANIZACIONES = "
						Update 
							ORGANIZACIONES 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_ORGANIZACIONES);
				} else {
					$sqlFireBird_Update_ORGANIZACIONES = "
						Update 
							ORGANIZACIONES 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_ORGANIZACIONES);
				}
			} // FIN validamos que no exista la empresa
			
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($resFireBird_2);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

//echo "<pre>";
		//echo $fila->POLIZA."<br>";
//		echo $sqlMysql_Insert_ORGANIZACIONES;
//		echo $sqlMysql_Update_ORGANIZACIONES;
//		echo $sqlFireBird_Update_ORGANIZACIONES;
//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>