<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			CONTACTOS_SINC
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		echo "si hay registros a procesar";
			
//-->		$sqlMysql_Truncate_CONTACTOS_SINC = "Truncate Table `contactos_sinc`";
//-->		DreQueryDB($sqlMysql_Truncate_CONTACTOS_SINC);
		
		$sqlFireBird = "
			Select 
--				First 10
			*
			From 
				CONTACTOS_SINC
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$sqlMysql_Insert_CONTACTOS_SINC = "
				Insert Into
					`contactos_sinc` 
							(
								`CLAVECLIENTE`, 
								`TIPO`, 
								`NOMBRE`, 
								`EMAIL`, 
								`TELEFONO`, 
								`DIRECCION`, 
								`VENDEDOR`, 
								`PROMOTOR`, 
								`SUCURSAL`, 
								`ES_DIR_PRINCIPAL`
							) 
						VALUES 
							(
								'".$fila->CLAVECLIENTE."'
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
//-->			echo "<pre>";
	//-->			echo $sqlMysql_Insert_CONTACTOS_SINC;
//-->			echo "</pre>";
			DreQueryDB($sqlMysql_Insert_CONTACTOS_SINC);
		}

	$sqlFireBird_Update_CONTACTOS_SINC = "
		Update 
			CONTACTOS_SINC 
		Set 
			TOCADO = 'SI'
			,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";
	$resFireBird_Update_CONTACTOS_SINC = DreQueryDbFireBird($sqlFireBird_Update_CONTACTOS_SINC);

	DreFreeResultDbFireBird($resFireBird_Update_CONTACTOS_SINC);

		
	} else {

		echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>