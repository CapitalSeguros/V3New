<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			USUARIOS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_USUARIOS = "Truncate Table `usuarios`";
		//-->DreQueryDB($sqlMysql_Truncate_USUARIOS);
		
		$sqlFireBird = "
			Select * From 
				USUARIOS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Validacion_INFO_USUARIOS_VENDEDORES = "
				Select * From 
					`info_usuarios_vendedores` 
				Where 
					`VALOR` = '".str_pad($fila->VENDEDOR, 10, '0', 0)."'
															";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_INFO_USUARIOS_VENDEDORES)) == 0 ){ // validamos que no exista la empresa
				$sqlMysql_Insert_INFO_USUARIOS_VENDEDORES = "
					Insert Into 
						`info_usuarios_vendedores`
						(
							`VALOR`
							, `NOMBRE`
							, `SUCURSAL`
						)
						Values
						(
							'".str_pad($fila->VENDEDOR, 10, '0', 0)."'
							, '".$fila->NOMBRE."'
							,'".str_pad($fila->SUCURSAL, 4, '0', 0)."'
						)
															";
				DreQueryDB($sqlMysql_Insert_INFO_USUARIOS_VENDEDORES);
								
			}
			

			
			
			
			
			$sqlMysql_Validacion_USUARIOS = "
				Select * From 
					`usuarios`
				Where 
					`VALOR` = '".str_pad($fila->VENDEDOR, 10, '0', 0)."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_USUARIOS)) == 0 ){ // validamos que no exista la empresa
				//-->
				//str_pad($fila->SUCURSAL, 4, '0', 0)
				$sqlMysql_Insert_USUARIOS = "
					Insert Into
						`usuarios`
							(
								`CLAVE`
								, `NOMBRE`
								, `VALOR`
								, `TIPO`
								, `PASSWORD`
								, `PROMOTOR`
								, `SUCURSAL`
								, `Email`
								, `EDIRECTA`
								, `Telefono_Fijo`
								, `Telefono_Celular`
								, `integral`
								, `mailMasivo`
								, `check1`
								, `check2`
								, `check3`
								, `check4`
							)
						Values
							(
								'".$fila->USUARIO."'
								,'".$fila->NOMBRE."'
								,'".str_pad($fila->VENDEDOR, 10, '0', 0)."'
								,'".$fila->PERFIL."'
								,'".$fila->CLAVE."'
								,'".str_pad($fila->PROMOTOR, 10, '0', 0)."'
								,'".$fila->SUCURSAL."'
								,'".$fila->EMAIL."'
								,'".$fila->EDIRECTA."'
								,'".$fila->TELEFONOFIJO."'
								,'".$fila->TELEFONOCELULAR."'
								,'".$fila->INTEGRAL."'
								,'".$fila->C1."'
								,'".$fila->C2."'
								,'".$fila->C3."'
								,'".$fila->C4."'
								,'".$fila->C5."'
							);
											";
	
//-->	echo "<pre>".$sqlMysql_Insert_USUARIOS."</pre>";
	
				if(DreQueryDB($sqlMysql_Insert_USUARIOS)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_USUARIOS = "
						Update 
							USUARIOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
												 ";
//-->	echo "<pre>".$sqlFireBird_Update_USUARIOS."</pre>";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_USUARIOS);
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_USUARIOS = "
						Update 
							USUARIOS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
													 ";
//-->	echo "<pre>".$sqlFireBird_Update_USUARIOS."</pre>";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_USUARIOS);
				}
			
	
			} else { // ELSE validamos que no exista la empresa
					//--> ".str_pad($fila->SUCURSAL, 4, '0', 0)."
				$sqlMysql_Update_USUARIOS = "
					Update
						`usuarios`
					Set
						`CLAVE`='".$fila->USUARIO."'
						,`NOMBRE`='".$fila->NOMBRE."'
						,`VALOR`='".str_pad($fila->VENDEDOR, 10, '0', 0)."'
						,`TIPO`='".$fila->PERFIL."'
						,`PASSWORD`='".$fila->CLAVE."'
						,`PROMOTOR`='".str_pad($fila->PROMOTOR, 10, '0', 0)."'
						,`SUCURSAL`='".$fila->SUCURSAL."'
						,`Email`='".$fila->EMAIL."'
						,`EDIRECTA`='".$fila->EDIRECTA."'
						,`Telefono_Fijo`='".$fila->TELEFONOFIJO."'
						,`Telefono_Celular`='".$fila->TELEFONOCELULAR."'
						,`integral`='".$fila->INTEGRAL."'
						,`mailMasivo`='".$fila->C1."'						
						,`check1`='".$fila->C2."'
						,`check2`='".$fila->C3."'
						,`check3`='".$fila->C4."'
						,`check4`='".$fila->C5."'												
					Where
						`VALOR` = '".str_pad($fila->VENDEDOR, 10, '0', 0)."'
								";
//-->	echo "<pre>".$sqlMysql_Update_USUARIOS."</pre>";
	
				if(DreQueryDB($sqlMysql_Update_USUARIOS)){
					//--> echo "Update Firebir Update True";
					$sqlFireBird_Update_USUARIOS = "
						Update 
							USUARIOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_USUARIOS);
				} else {
					//--> echo "Update Firebir Update False";
					$sqlFireBird_Update_USUARIOS = "
						Update 
							USUARIOS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							VENDEDOR = '".$fila->VENDEDOR."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_USUARIOS);
				}
			} // FIN validamos que no exista la empresa			
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($resFireBird_2);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros


echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>