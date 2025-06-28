<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_EMPRESAS = "
		Select Count(*) As `existenRegistros` From
			`empresas`
		Where 
			`actualizado` = '1'
									 ";
	$resMysql_Validacion_Registros_EMPRESAS = DreQueryDB($sqlMysql_Validacion_Registros_EMPRESAS);
	$rowMysql_Validacion_Registros_EMPRESAS = mysql_fetch_assoc($resMysql_Validacion_Registros_EMPRESAS);
	
	if((int)$rowMysql_Validacion_Registros_EMPRESAS['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_EMPRESAS = "
			Delete From
				EMPRESAS_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_EMPRESAS = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_EMPRESAS);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_EMPRESAS);
		
		
		$sqlMysql_Registros_EMPRESAS = "
			Select * From
				`empresas`
			Where 
				`actualizado` = '1'
			Limit 0,100
							  ";
		$resMysql_Registros_EMPRESAS = DreQueryDB($sqlMysql_Registros_EMPRESAS);
		while($rowMysql_Registros_EMPRESAS = mysql_fetch_assoc($resMysql_Registros_EMPRESAS)){
			$sqlFireBird_Insert_Registro_EMPRESAS = "
				Insert Into 
					EMPRESAS_DESCARGA
						(
							CLAVECLIENTE
							, APELLIDOPATERNO
							, APELLIDOMATERNO
							, NOMBRE
							, RAZONSOCIAL
							, TIPOPERSONA
							, RFC
							, CURP
							, CALLE
							, NOEXTERIOR
							, NOINTERIOR
							, REFERENCIA
							, REFERENCIA2
							, COLONIA
							, CODIGOPOSTAL
							, LOCALIDAD
							, MUNICIPIO
							, ESTADO
							, PAIS
							, FECHANACIMIENTO
							, NACIONALIDAD
							, NIVELESTUDIOS
							, AUTOMOVIL
							, EDAD
							, ESTADOCIVIL
							, GENERO
							, VENDEDOR
							, LIMITEFIANZA
							, TELEFONOPARTICULAR
							, TELEFONOOFICINA
							, TELEFONOMOVIL
							, SITIOWEB
							, TWITTER
							, FACEBOOK
							, CLAVEWEB
							, SUCURSAL
							, PROMOTOR
							, TIPO
							, CLUB_CAP
							, POLIZAELECTRONICA
							, TIPOCLIENTE
							, ESTATUS
							, EMAIL
							, RANKING
							, VENDEDOR2
							, VENDEDOR3
							, VENDEDOR4
							, TOCADO
 							, FECHAPROCESO
						) 
						Values
						(
							'".substr($rowMysql_Registros_EMPRESAS['CLAVE'],0,20)."'
							,'".substr($rowMysql_Registros_EMPRESAS['APELLIDO_PATERNO'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['APELLIDO_MATERNO'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['NOMBRES'],0,100)."'
							,'".substr($rowMysql_Registros_EMPRESAS['RAZON_SOCIAL'],0,100)."'
							,'".substr($rowMysql_Registros_EMPRESAS['TIPO_PERSONA'],0,1)."'
							,'".substr($rowMysql_Registros_EMPRESAS['RFC'],0,20)."'
							,'".substr($rowMysql_Registros_EMPRESAS['CURP'],0,20)."'
							,'".substr($rowMysql_Registros_EMPRESAS['CALLE'],0,50)."'
							,'".substr($rowMysql_Registros_EMPRESAS['NOEXTERIOR'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['NOINTERIOR'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['REFERENCIA'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['REFERENCIA2'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['COLONIA'],0,50)."'
							,'".substr($rowMysql_Registros_EMPRESAS['CODIGO_POSTAL'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['LOCALIDAD'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['MUNICIPO'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['ESTADO'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['PAIS'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['FECHA_NACIMIENTO'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['NACIONALIDAD'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['NIVEL_ESTUDIOS'],0,20)."'
							,'".substr($rowMysql_Registros_EMPRESAS['AUTOMOVIL'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['EDAD'],0,3)."'
							,'".substr($rowMysql_Registros_EMPRESAS['ESTADO_CIVIL'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['GENERO'],0,1)."'
							,'".substr($rowMysql_Registros_EMPRESAS['VENDEDOR'],0,10)."'
							,".(float)$rowMysql_Registros_EMPRESAS['LIMITE_FIANZA']."
							,'".substr($rowMysql_Registros_EMPRESAS['TELEFONO_PARTICULAR'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['TELEFONO_OFICINA'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['TELEFONO_MOVIL'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['SITIO_WEB'],0,50)."'
							,'".substr($rowMysql_Registros_EMPRESAS['TWITTER'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['FACEBOOK'],0,30)."'
							,'".substr($rowMysql_Registros_EMPRESAS['CLAVEWEB'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['SUCURSAL'],1,3)."'
							,'".substr($rowMysql_Registros_EMPRESAS['PROMOTOR'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['TIPO_REGISTRO'],0,2)."'
							,'".substr($rowMysql_Registros_EMPRESAS['Club_Cap'],0,1)."'
							,'".substr($rowMysql_Registros_EMPRESAS['Poliza_Electronica'],0,1)."'
							,'".substr($rowMysql_Registros_EMPRESAS['Tipo_Cliente'],0,5)."'
							,'".substr($rowMysql_Registros_EMPRESAS['estatusCliente'],0,2)."'
							,'".substr($rowMysql_Registros_EMPRESAS['email'],0,100)."'
							,'".substr($rowMysql_Registros_EMPRESAS['RANKING'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['VENDEDOR1'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['VENDEDOR2'],0,10)."'
							,'".substr($rowMysql_Registros_EMPRESAS['VENDEDOR3'],0,10)."'
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_EMPRESAS;
	//			echo $sqlMysql_Update_Registro_EMPRESAS;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_EMPRESAS = DreQueryDbFireBird($sqlFireBird_Insert_Registro_EMPRESAS);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_EMPRESAS);
	
			$sqlMysql_Update_Registro_EMPRESAS = "
				Update
					`empresas`
				Set
					 `actualizado` = '0'
					 ,`fechaSyncronizado` = '".date('Y-m-d g:i:s')."'
				Where 
					`CLAVE` = '".$rowMysql_Registros_EMPRESAS['CLAVE']."'
											  ";
			DreQueryDB($sqlMysql_Update_Registro_EMPRESAS);
			

		}		
		
		//-->
		
	} else { // ELSE If existenRegistrosMysql
		//echo "No hay Registros a Procesar<br>";
		
		//-->
				
	}// Fin If existenRegistrosMysql

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>