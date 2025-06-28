<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			MIINFO 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_MIINFO = "Truncate Table `info_usuarios_vendedores`";
		//-->DreQueryDB($sqlMysql_Truncate_MIINFO);
		
		$sqlFireBird = "
			Select * From 
				MIINFO 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			$sqlMysql_Validacion_MIINFO = "
				Select * From 
					`info_usuarios_vendedores`
				Where 
					`VALOR` = '".$fila->OPERADOR."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_MIINFO)) == 0 ){ // validamos que no exista la empresa
				//-->
				$sqlMysql_Insert_MIINFO = "
					Insert Into
						`info_usuarios_vendedores`
							(
								`VALOR`
								, `NOMBRE`
								, `APELLIDOS`
								, `SUCURSAL`
								, `CALLE`
								, `NO_EXT`
								, `CRUZAMIENTO`
								, `COLONIA`
								, `CP`
								, `CIUDAD_ID`
								, `RFC`
								, `TELEFONO_CASA`
								, `TELEFONO_CELULAR`
								, `CIA_CEL`
								, `TELEFONO_TRABAJO`
								, `ESTADO_CIVIL`
								, `FECHA_NACIMIENTO`
								, `LUGAR_NACIMIENTO`
								, `ESCOLARIDAD`
								, `EMAIL`
								, `VEHICULO_PROPIO`
								, `CUENTA_BANCARIA`
								, `BANCO`
								, `TIPO_CUENTA`
								, `CLABE`
								, `CEDULA_CNSF`
								, `VIGENCIA`
								, `ACCIDENTE_AVISAR`
								, `TELEFONO_ACCIDENTE`
								, `RECOMENDADO_POR`
								, `IMSS`
								, `REFERENCIAS`
								, `TIENE_HIJOS`
								, `GASTO_PROMEDIO_MENSUAL`
								, `CUANTO_TE_GUSTARIA_GANAR`
								, `CONSULTOR`
								, `MODELO_VEHICULO`
								, `TIPO_AUT`
								, `COLOR_FAVORITO`
								, `COMIDA_FAVORITA`
								, `ANIVERSARIO_BODAS`
								, `NIVEL_ESTUDIOS`
								, `PASATIEMPO_FAVORITO`
								, `CLUB_SOCIAL`
								, `LICENCIA_MANEJAR`
								, `VIGENCIA_LICENCIA_MANEJAR`
								, `PASAPORTE`
								, `VIGENCIA_PASAPORTE`
								, `RANKING`
								, `CREDITO_TIENDA`
							)
						Values
							(
								'".$fila->OPERADOR."'
								,'".$fila->NOMBRE."'
								,'".$fila->APELLIDOS."'
								,'".$fila->SUCURSAL."'
								,'".$fila->CALLE."'
								,'".$fila->NO_EXT."'
								,'".$fila->CRUZAMIENTO."'
								,'".$fila->COLONIA."'
								,'".$fila->CP."'
								,'".$fila->CIUDAD_ID."'
								,'".$fila->RFC."'
								,'".$fila->TELEFONO_CASA."'
								,'".$fila->TELEFONO_CELULAR."'
								,'".$fila->CIA_CEL."'
								,'".$fila->TELEFONO_TRABAJO."'
								,'".$fila->ESTADO_CIVIL."'
								,'".$fila->FECHA_NACIMIENTO."'
								,'".$fila->LUGAR_NACIMIENTO."'
								,'".$fila->ESCOLARIDAD."'
								,'".$fila->EMAIL."'
								,'".$fila->VEHICULO_PROPIO."'
								,'".$fila->CUENTA_BANCARIA."'
								,'".$fila->BANCO."'
								,'".$fila->TIPO_CUENTA."'
								,'".$fila->CLABE."'
								,'".$fila->CEDULA_CNSF."'
								,'".$fila->VIGENCIA."'
								,'".$fila->ACCIDENTE_AVISAR."'
								,'".$fila->TELEFONO_ACCIDENTE."'
								,'".$fila->RECOMENDADO_POR."'
								,'".$fila->IMSS."'
								,'".$fila->REFERENCIAS."'
								,'".$fila->HIJOS."'
								,'".$fila->GASTO_MENSUAL."'
								,'".$fila->GUSTARIA_GANAR."'
								,'".$fila->CONSULTOR_ID."'
								,'".$fila->MODELO_VEHICULO."'
								,'".$fila->TIPO_AUTO."'
								,'".$fila->COLOR_FAVORITO."'
								,'".$fila->COMIDA_FAVORITA."'
								,'".$fila->ANIVERSARIO_BODA."'
								,'".$fila->NIVEL_ESTUDIOS."'
								,'".$fila->PASATIEMPO."'
								,'".$fila->CLUB_SOCIAL."'
								,'".$fila->LICENCIA_MANEJAR."'
								,'".$fila->LICENCIA_VIGENCIA."'
								,'".$fila->PASAPORTE."'
								,'".$fila->PASAPORTE_VIGENCIA."'
								,'".$fila->RANKING."'
								,'".$fila->LIMITE."'

							);
											";
//--> 								,'".$fila->IMAGEN."' 								, `IMAGEN`
				if(DreQueryDB($sqlMysql_Insert_MIINFO)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_MIINFO = "
						Update 
							MIINFO 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							OPERADOR = '".$fila->OPERADOR."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO);
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_MIINFO = "
						Update 
							MIINFO 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							OPERADOR = '".$fila->OPERADOR."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO);
				}
			
				
			} else { // ELSE validamos que no exista la empresa
				$sqlMysql_Update_MIINFO = "
					Update
						`info_usuarios_vendedores`
					Set
						`VALOR`='".$fila->OPERADOR."'
						, `NOMBRE`='".$fila->NOMBRE."'
						, `APELLIDOS`='".$fila->APELLIDOS."'
						, `SUCURSAL`='".$fila->SUCURSAL."'
						, `CALLE`='".$fila->CALLE."'
						, `NO_EXT`='".$fila->NO_EXT."'
						, `CRUZAMIENTO`='".$fila->CRUZAMIENTO."'
						, `COLONIA`='".$fila->COLONIA."'
						, `CP`='".$fila->CP."'
						, `CIUDAD_ID`='".$fila->CIUDAD_ID."'
						, `RFC`='".$fila->RFC."'
						, `TELEFONO_CASA`='".$fila->TELEFONO_CASA."'
						, `TELEFONO_CELULAR`='".$fila->TELEFONO_CELULAR."'
						, `CIA_CEL`='".$fila->CIA_CEL."'
						, `TELEFONO_TRABAJO`='".$fila->TELEFONO_TRABAJO."'
						, `ESTADO_CIVIL`='".$fila->ESTADO_CIVIL."'
						, `FECHA_NACIMIENTO`='".$fila->FECHA_NACIMIENTO."'
						, `LUGAR_NACIMIENTO`='".$fila->LUGAR_NACIMIENTO."'
						, `ESCOLARIDAD`='".$fila->ESCOLARIDAD."'
						, `EMAIL`='".$fila->EMAIL."'
						, `VEHICULO_PROPIO`='".$fila->VEHICULO_PROPIO."'
						, `CUENTA_BANCARIA`='".$fila->CUENTA_BANCARIA."'
						, `BANCO`='".$fila->BANCO."'
						, `TIPO_CUENTA`='".$fila->TIPO_CUENTA."'
						, `CLABE`='".$fila->CLABE."'
						, `CEDULA_CNSF`='".$fila->CEDULA_CNSF."'
						, `VIGENCIA`='".$fila->VIGENCIA."'
						, `ACCIDENTE_AVISAR`='".$fila->ACCIDENTE_AVISAR."'
						, `TELEFONO_ACCIDENTE`='".$fila->TELEFONO_ACCIDENTE."'
						, `RECOMENDADO_POR`='".$fila->RECOMENDADO_POR."'
						, `IMSS`='".$fila->IMSS."'
						, `REFERENCIAS`='".$fila->REFERENCIAS."'
						, `TIENE_HIJOS`='".$fila->HIJOS."'
						, `GASTO_PROMEDIO_MENSUAL`='".$fila->GASTO_MENSUAL."'
						, `CUANTO_TE_GUSTARIA_GANAR`='".$fila->GUSTARIA_GANAR."'
						, `CONSULTOR`='".$fila->CONSULTOR_ID."'
						, `MODELO_VEHICULO`='".$fila->MODELO_VEHICULO."'
						, `TIPO_AUT`='".$fila->TIPO_AUTO."'
						, `COLOR_FAVORITO`='".$fila->COLOR_FAVORITO."'
						, `COMIDA_FAVORITA`='".$fila->COMIDA_FAVORITA."'
						, `ANIVERSARIO_BODAS`='".$fila->ANIVERSARIO_BODA."'
						, `NIVEL_ESTUDIOS`='".$fila->NIVEL_ESTUDIOS."'
						, `PASATIEMPO_FAVORITO`='".$fila->PASATIEMPO."'
						, `CLUB_SOCIAL`='".$fila->CLUB_SOCIAL."'
						, `LICENCIA_MANEJAR`='".$fila->LICENCIA_MANEJAR."'
						, `VIGENCIA_LICENCIA_MANEJAR`='".$fila->LICENCIA_VIGENCIA."'
						, `PASAPORTE`='".$fila->PASAPORTE."'
						, `VIGENCIA_PASAPORTE`='".$fila->PASAPORTE_VIGENCIA."'
						, `RANKING`='".$fila->RANKING."'
						, `CREDITO_TIENDA`='".$fila->LIMITE."'
					Where
						`VALOR` = '".$fila->OPERADOR."'
								";
//--> 						, `IMAGEN`='".$fila->IMAGEN."'
				if(DreQueryDB($sqlMysql_Update_MIINFO)){
					//--> echo "Update Firebir Update True";
					$sqlFireBird_Update_MIINFO = "
						Update 
							MIINFO 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							OPERADOR = '".$fila->OPERADOR."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO);
				} else {
					//--> echo "Update Firebir Update False";
					$sqlFireBird_Update_MIINFO = "
						Update 
							MIINFO 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							OPERADOR = '".$fila->OPERADOR."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_MIINFO);
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