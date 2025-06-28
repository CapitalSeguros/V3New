<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			EMPRESAS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//-->$sqlMysql_Truncate_EMPRESAS = "Truncate Table `EMPRESAS`";
		//-->DreQueryDB($sqlMysql_Truncate_EMPRESAS);
		
		$sqlFireBird = "
			Select 
				First 100
				* 
			From 
				EMPRESAS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			$sqlMysql_Validacion_Empresas = "
				Select * From 
					`empresas`
				Where 
					`CLAVE` = '".$fila->CLAVECLIENTE."'
											";
			if(mysql_num_rows(DreQueryDB($sqlMysql_Validacion_Empresas)) == 0 ){ // validamos que no exista la empresa
				//-->
				$sqlMysql_Insert_EMPRESAS = "
					Insert Into
						`empresas`
							(
								`CLAVE`
								,`APELLIDO_PATERNO`
								,`APELLIDO_MATERNO`
								,`NOMBRES`
								,`RAZON_SOCIAL`
								,`TIPO_PERSONA`
								,`RFC`
								,`CURP`
								,`CALLE`
								,`NOEXTERIOR`
								,`NOINTERIOR`
								,`REFERENCIA`
								,`REFERENCIA2`
								,`COLONIA`
								,`CODIGO_POSTAL`
								,`LOCALIDAD`
								,`MUNICIPO`
								,`ESTADO`
								,`PAIS`
								,`FECHA_NACIMIENTO`
								,`NACIONALIDAD`
								,`NIVEL_ESTUDIOS`
								,`AUTOMOVIL`
								,`EDAD`
								,`ESTADO_CIVIL`
								,`GENERO`
								,`VENDEDOR`
								,`VENDEDOR1`
								,`VENDEDOR2`
								,`VENDEDOR3`
								,`LIMITE_FIANZA`
								,`TELEFONO_PARTICULAR`
								,`TELEFONO_OFICINA`
								,`TELEFONO_MOVIL`
								,`SITIO_WEB`
								,`TWITTER`
								,`FACEBOOK`
								,`CLAVEWEB`
								,`SUCURSAL`
								,`PROMOTOR`
								,`TIPO_REGISTRO`
								,`Club_Cap`
								,`Poliza_Electronica`
								,`Tipo_Cliente`
								,`estatusCliente`
								,`email`
								,`RANKING`
							
							)
						Values
							(
								'".$fila->CLAVECLIENTE."'
								,'".$fila->APELLIDOPATERNO."'
								,'".$fila->APELLIDOMATERNO."'
								,'".$fila->NOMBRE."'
								,'".$fila->RAZONSOCIAL."'
								,'".$fila->TIPOPERSONA."'
								,'".$fila->RFC."'
								,'".$fila->CURP."'
								,'".$fila->CALLE."'
								,'".$fila->NOEXTERIOR."'
								,'".$fila->NOINTERIOR."'
								,'".$fila->REFERENCIA."'
								,'".$fila->REFERENCIA2."'
								,'".$fila->COLONIA."'
								,'".$fila->CODIGOPOSTAL."'
								,'".$fila->LOCALIDAD."'
								,'".$fila->MUNICIPIO."'
								,'".$fila->ESTADO."'
								,'".$fila->PAIS."'
								,'".$fila->FECHANACIMIENTO."'
								,'".$fila->NACIONALIDAD."'
								,'".$fila->NIVELESTUDIOS."'
								,'".$fila->AUTOMOVIL."'
								,'".$fila->EDAD."'
								,'".$fila->ESTADOCIVIL."'
								,'".$fila->GENERO."'
								,'".$fila->VENDEDOR."'
								,'".$fila->VENDEDOR2."'
								,'".$fila->VENDEDOR3."'
								,'".$fila->VENDEDOR4."'
								,'".$fila->LIMITEFIANZA."'
								,'".$fila->TELEFONOPARTICULAR."'
								,'".$fila->TELEFONOOFICINA."'
								,'".$fila->TELEFONOMOVIL."'
								,'".$fila->SITIOWEB."'
								,'".$fila->TWITTER."'
								,'".$fila->FACEBOOK."'
								,'".$fila->CLAVEWEB."'
								,'".$fila->SUCURSAL."'
								,'".$fila->PROMOTOR."'
								,'".$fila->TIPO."'
								,'".$fila->CLUB_CAP."'
								,'".$fila->POLIZAELECTRONICA."'
								,'".$fila->TIPOCLIENTE."'
								,'".$fila->ESTATUS."'
								,'".$fila->EMAIL."'
								,'".$fila->RANKING."'
							);
											";

				if(DreQueryDB($sqlMysql_Insert_EMPRESAS)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_EMPRESAS = "
						Update 
							EMPRESAS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_EMPRESAS);
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_EMPRESAS = "
						Update 
							EMPRESAS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_EMPRESAS);
				}
			
				
			} else { // ELSE validamos que no exista la empresa
				$sqlMysql_Update_EMPRESAS = "
					Update
						`empresas`
					Set
						`APELLIDO_PATERNO`='".$fila->APELLIDOPATERNO."'
						,`APELLIDO_MATERNO`='".$fila->APELLIDOMATERNO."'
						,`NOMBRES`='".$fila->NOMBRE."'
						,`RAZON_SOCIAL`='".$fila->RAZONSOCIAL."'
						,`TIPO_PERSONA`='".$fila->TIPOPERSONA."'
						,`RFC`='".$fila->RFC."'
						,`CURP`='".$fila->CURP."'
						,`CALLE`='".$fila->CALLE."'
						,`NOEXTERIOR`='".$fila->NOEXTERIOR."'
						,`NOINTERIOR`='".$fila->NOINTERIOR."'
						,`REFERENCIA`='".$fila->REFERENCIA."'
						,`REFERENCIA2`='".$fila->REFERENCIA2."'
						,`COLONIA`='".$fila->COLONIA."'
						,`CODIGO_POSTAL`='".$fila->CODIGOPOSTAL."'
						,`LOCALIDAD`='".$fila->LOCALIDAD."'
						,`MUNICIPO`='".$fila->MUNICIPIO."'
						,`ESTADO`='".$fila->ESTADO."'
						,`PAIS`='".$fila->PAIS."'
						,`FECHA_NACIMIENTO`='".$fila->FECHANACIMIENTO."'
						,`NACIONALIDAD`='".$fila->NACIONALIDAD."'
						,`NIVEL_ESTUDIOS`='".$fila->NIVELESTUDIOS."'
						,`AUTOMOVIL`='".$fila->AUTOMOVIL."'
						,`EDAD`='".$fila->EDAD."'
						,`ESTADO_CIVIL`='".$fila->ESTADOCIVIL."'
						,`GENERO`='".$fila->GENERO."'
						,`VENDEDOR`='".$fila->VENDEDOR."'
						,`VENDEDOR1`='".$fila->VENDEDOR2."'
						,`VENDEDOR2`='".$fila->VENDEDOR3."'
						,`VENDEDOR3`='".$fila->VENDEDOR4."'
						,`LIMITE_FIANZA`='".$fila->LIMITEFIANZA."'
						,`TELEFONO_PARTICULAR`='".$fila->TELEFONOPARTICULAR."'
						,`TELEFONO_OFICINA`='".$fila->TELEFONOOFICINA."'
						,`TELEFONO_MOVIL`='".$fila->TELEFONOMOVIL."'
						,`SITIO_WEB`='".$fila->SITIOWEB."'
						,`TWITTER`='".$fila->TWITTER."'
						,`FACEBOOK`='".$fila->FACEBOOK."'
						,`CLAVEWEB`='".$fila->CLAVEWEB."'
						,`SUCURSAL`='".$fila->SUCURSAL."'
						,`PROMOTOR`='".$fila->PROMOTOR."'
						,`TIPO_REGISTRO`='".$fila->TIPO."'
						,`Club_Cap`='".$fila->CLUB_CAP."'
						,`Poliza_Electronica`='".$fila->POLIZAELECTRONICA."'
						,`Tipo_Cliente`='".$fila->TIPOCLIENTE."'
						,`estatusCliente`='".$fila->ESTATUS."'
						,`email`='".$fila->EMAIL."'
						,`RANKING`='".$fila->RANKING."'
					Where
						`CLAVE` = '".$fila->CLAVECLIENTE."'
								";

				if(DreQueryDB($sqlMysql_Update_EMPRESAS)){
					//--> echo "Update Firebir Update True";
					$sqlFireBird_Update_EMPRESAS = "
						Update 
							EMPRESAS 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
												 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_EMPRESAS);
				} else {
					//--> echo "Update Firebir Update False";
					$sqlFireBird_Update_EMPRESAS = "
						Update 
							EMPRESAS 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
													 ";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_EMPRESAS);
				}
			} // FIN validamos que no exista la empresa
			
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($resFireBird_2);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

//echo "<pre>";
	//	echo $fila->POLIZA."<br>";
	//	echo $sqlMysql_Insert_EMPRESAS;
	//	echo $sqlMysql_Update_EMPRESAS;
	//	echo $sqlFireBird_Update_EMPRESAS;
//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>