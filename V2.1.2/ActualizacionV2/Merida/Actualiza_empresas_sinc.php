<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			EMPRESAS_SINC
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		echo "si hay registros a procesar";
			
//-->		$sqlMysql_Truncate_EMPRESAS_SINC = "Truncate Table `empresas_sinc`";
//-->		DreQueryDB($sqlMysql_Truncate_EMPRESAS_SINC);
		
		$sqlFireBird = "
			Select 
--				First 100
			*
			From 
				EMPRESAS_SINC
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Insert_EMPRESAS_SINC = "
				Insert Into
					`empresas_sinc` 
							(
								`CLAVECLIENTE`
								, `APELLIDOPATERNO`
								, `APELLIDOMATERNO`
								, `NOMBRE`
								, `RAZONSOCIAL`
								, `TIPOPERSONA`
								, `RFC`
								, `CURP`
								, `CALLE`
								, `NOEXTERIOR`
								, `NOINTERIOR`
								, `REFERENCIA`
								, `REFERENCIA2`
								, `COLONIA`
								, `CODIGOPOSTAL`
								, `LOCALIDAD`
								, `MUNICIPO`
								, `ESTADO`
								, `PAIS`
								, `FECHANACIMIENTO`
								, `NACIONALIDAD`
								, `NIVELESTUDIOS`
								, `AUTOMOVIL`
								, `EDAD`
								, `ESTADOCIVIL`
								, `GENERO`
								, `VENDEDOR`
								, `LIMITEFIANZA`
								, `TELEFONOPARTICULAR`
								, `TELEFONOOFICINA`
								, `TELEFONOMOVIL`
								, `SITIOWEB`
								, `TWITTER`
								, `FACEBOOK`
								, `CLAVEWEB`
								, `SUCURSAL`
								, `PROMOTOR`
								, `TIPO`
								, `CLUB_CAP`
								, `POLIZAELECTRONICA`
								, `TIPOCLIENTE`
								, `ESTATUS`
								, `EMAIL`
								, `RANKING`
								, `VENDEDOR2`
								, `VENDEDOR3`
								, `VENDEDOR4`
							) 
						VALUES 
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
								,'".$fila->VENDEDOR2."'
								,'".$fila->VENDEDOR3."'
								,'".$fila->VENDEDOR4."'
							);

										  ";
//-->			echo "<pre>";
	//-->			echo $sqlMysql_Insert_EMPRESAS_SINC;
//-->			echo "</pre>";

			DreQueryDB($sqlMysql_Insert_EMPRESAS_SINC);
		}

	$sqlFireBird_Update_EMPRESAS_SINC = "
		Update 
			EMPRESAS_SINC 
		Set 
			TOCADO = 'SI'
			,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";
	$resFireBird_Update_EMPRESAS_SINC = DreQueryDbFireBird($sqlFireBird_Update_EMPRESAS_SINC);

	DreFreeResultDbFireBird($resFireBird_Update_EMPRESAS_SINC);

		
	} else {

		echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>