<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			CONTACTOS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_CONTACTOS = "Truncate Table `CONTACTOS`";
		//-->DreQueryDB($sqlMysql_Truncate_CONTACTOS);
		
		$sqlFireBird = "
			Select * From 
				CONTACTOS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			$sqlMysql_Validacion_CONTACTOS = "
				Select * From 
					`contactos`
				Where 
					`CLAVE` = '".$fila->CLAVECLIENTE."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_CONTACTOS)) == 0 ){ // validamos que no exista la empresa
				//-->
				$sqlMysql_Insert_CONTACTOS = "
					Insert Into
						`contactos`
							(
								`CLAVE`
								,`TIPO`
								,`NOMBRE`
								,`EMAIL`
								,`TELEFONO`
								,`DIRECCION`
								,`VENDEDOR`
								,`PROMOTOR`
								,`SUCURSAL`
								,`ES_DIR_PRINCIPAL`
							)
						Values
							(
								'".$fila->CLAVE."'
								,'".$fila->TIPO."'
								,'".$fila->NOMBRE."'
								,'".$fila->EMAIL."'
								,'".$fila->TELEFONO."'
								,'".$fila->DIRECCION."'
								,'".$fila->VENDEDOR."'
								,'".$fila->PROMOTOR."'
								,'".$fila->SUCURSAL."'
								,'".$fila->ES_DIR_PRINCIPAL."'
							);
											";

				if(DreQueryDB($sqlMysql_Insert_CONTACTOS)){
					$sqlFireBird_Update_CONTACTOS = "
						Update 
							CONTACTOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_CONTACTOS);
				} else {
					$sqlFireBird_Update_CONTACTOS = "
						Update 
							CONTACTOS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_CONTACTOS);
				}
			
				
			} else { // ELSE validamos que no exista la empresa
				$sqlMysql_Update_CONTACTOS = "
					Update
						`contactos`
					Set
						`TIPO`='".$fila->TIPO."'
						,`NOMBRE`='".$fila->NOMBRE."'
						,`EMAIL`='".$fila->EMAIL."'
						,`TELEFONO`='".$fila->TELEFONO."'
						,`DIRECCION`='".$fila->DIRECCION."'
						,`VENDEDOR`='".$fila->VENDEDOR."'
						,`PROMOTOR`='".$fila->PROMOTOR."'
						,`SUCURSAL`='".$fila->SUCURSAL."'
						,`ES_DIR_PRINCIPAL`='".$fila->ES_DIR_PRINCIPAL."'
					Where
						`CLAVE` = '".$fila->CLAVECLIENTE."'
								";

				if(DreQueryDB($sqlMysql_Update_CONTACTOS)){
					$sqlFireBird_Update_CONTACTOS = "
						Update 
							CONTACTOS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_CONTACTOS);
				} else {
					$sqlFireBird_Update_CONTACTOS = "
						Update 
							CONTACTOS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_CONTACTOS);
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
	//	echo $sqlMysql_Insert_CONTACTOS;
	//	echo $sqlMysql_Update_CONTACTOS;
	//	echo $sqlFireBird_Update_CONTACTOS;
//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>