<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			MIINFO_PROVEEDORES 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_MIINFO_PROVEEDORES = "Truncate Table `miinfo_proveedores`";
		//-->DreQueryDB($sqlMysql_Truncate_MIINFO_PROVEEDORES);
		
		$sqlFireBird = "
			Select * From 
				MIINFO_PROVEEDORES 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			$sqlMysql_Validacion_MIINFO_PROVEEDORES = "
				Select * From 
					`miinfo_proveedores`
				Where 
					`organizacion_id` = '".$fila->ORGANIZACION_ID."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_MIINFO_PROVEEDORES)) == 0 ){ // validamos que no exista la empresa
				//-->
				$sqlMysql_Insert_MIINFO_PROVEEDORES = "
					Insert Into
						`miinfo_proveedores`
							(
								`organizacion_id`
								,`Nombre_organizacion`
								,`id_contacto`
								,`Nombre_contacto`
								,`puesto`
								,`telefono1`
								,`telefono2`
								,`telefono3`
								,`telefono4`
								,`extension`
								,`telefono_movil`
								,`email`
								,`direccion`
								,`banco`
								,`cuenta`
								,`clabe`
							)
						Values
							(
								'".$fila->ORGANIZACION_ID."'
								,'".$fila->NOMBRE."'
								,'".$fila->ID."'
								,'".$fila->NOMBRE_COMPLETO."'
								,'".$fila->PUESTO."'
								,'".$fila->TELEFONO1."'
								,'".$fila->TELEFONO2."'
								,'".$fila->TELEFONO3."'
								,'".$fila->TELEFONO4."'
								,'".$fila->EXTENSION."'
								,'".$fila->TELEFONO_MOVIL."'
								,'".$fila->EMAIL."'
								,'".$fila->DIRECCION_OFICINA."'
								,'".$fila->BANCO."'
								,'".$fila->CUENTA."'
								,'".$fila->CLABE."'
							);
											";

				if(DreQueryDB($sqlMysql_Insert_MIINFO_PROVEEDORES)){
					$sqlFireBird_Update_MIINFO_PROVEEDORES = "
						Update 
							MIINFO_PROVEEDORES 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO_PROVEEDORES);
				} else {
					$sqlFireBird_Update_MIINFO_PROVEEDORES = "
						Update 
							MIINFO_PROVEEDORES 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO_PROVEEDORES);
				}
			
				
			} else { // ELSE validamos que no exista la empresa
				$sqlMysql_Update_MIINFO_PROVEEDORES = "
					Update
						`miinfo_proveedores`
					Set
						`Nombre_organizacion`='".$fila->NOMBRE."'
						,`id_contacto`='".$fila->ID."'
						,`Nombre_contacto`='".$fila->NOMBRE_COMPLETO."'
						,`puesto`='".$fila->PUESTO."'
						,`telefono1`='".$fila->TELEFONO1."'
						,`telefono2`='".$fila->TELEFONO2."'
						,`telefono3`='".$fila->TELEFONO3."'
						,`telefono4`='".$fila->TELEFONO4."'
						,`extension`='".$fila->EXTENSION."'
						,`telefono_movil`='".$fila->TELEFONO_MOVIL."'
						,`email`='".$fila->EMAIL."'
						,`direccion`='".$fila->DIRECCION_OFICINA."'
						,`banco`='".$fila->BANCO."'
						,`cuenta`='".$fila->CUENTA."'
						,`clabe`='".$fila->CLABE."'
					Where
						`organizacion_id` = '".$fila->ORGANIZACION_ID."'
								";

				if(DreQueryDB($sqlMysql_Update_MIINFO_PROVEEDORES)){
					$sqlFireBird_Update_MIINFO_PROVEEDORES = "
						Update 
							MIINFO_PROVEEDORES 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO_PROVEEDORES);
				} else {
					$sqlFireBird_Update_MIINFO_PROVEEDORES = "
						Update 
							MIINFO_PROVEEDORES 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							ORGANIZACION_ID = '".$fila->ORGANIZACION_ID."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO_PROVEEDORES);
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
//		echo $sqlMysql_Insert_MIINFO_PROVEEDORES;
//		echo $sqlMysql_Update_MIINFO_PROVEEDORES;
//		echo $sqlFireBird_Update_MIINFO_PROVEEDORES;
//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>