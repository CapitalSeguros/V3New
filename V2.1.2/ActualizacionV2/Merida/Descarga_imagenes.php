<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

$quitarCosas = array('&nbsp;'); 
$ponerCosas = array('');

	$sqlMysql_Validacion_Registros_IMAGENES = "
		Select Count(*) As `existenRegistros` From
			`imagenes`
		Where 
			(
				`NO_ARCHIVO` Like '%W%' Or `NO_ARCHIVO` Like '%L%'
			)
--			And
--			(
--				`actualizado` = '1'
--			)
									 ";
	$resMysql_Validacion_Registros_IMAGENES = DreQueryDB($sqlMysql_Validacion_Registros_IMAGENES);
	$rowMysql_Validacion_Registros_IMAGENES = mysql_fetch_assoc($resMysql_Validacion_Registros_IMAGENES);
	
	if((int)$rowMysql_Validacion_Registros_IMAGENES['existenRegistros'] > 0){
		echo "SI hay Registros a Procesar<br>";
		
		//--> Mantenimiento Tabla FireBird
		// si el registro tiene NO conservar de lo contrario borrar 
		$sqlFireBird_Mantenimiento_1_Tabla_IMAGENES = "
			Delete From
				IMAGENES_DESCARGA
			Where
				TOCADO != 'NO'
													   ";
//-->		$resFireBird_Mantenimiento_1_Tabla_IMAGENES = DreQueryDbFireBird($sqlFireBird_Mantenimiento_1_Tabla_IMAGENES);
//-->		DreFreeResultDbFireBird($resFireBird_Mantenimiento_1_Tabla_IMAGENES);
		
		
		$sqlMysql_Registros_IMAGENES = "
			Select * From
				`imagenes`
			Where 
			(
				`NO_ARCHIVO` Like '%W%' Or `NO_ARCHIVO` Like '%L%'
			)
--			And
--			(
--				`actualizado` = '1'
--			)
			And
			(
				`FECHA_ALTA` Not LIke  '%0000-00%'
			)
			Order By `FECHA_ALTA` Desc
			Limit 0,100 

							  ";
		$resMysql_Registros_IMAGENES = DreQueryDB($sqlMysql_Registros_IMAGENES);
		while($rowMysql_Registros_IMAGENES = mysql_fetch_assoc($resMysql_Registros_IMAGENES)){
			
$var_SqlFireBird_NO_ARCHIVO = "'".substr($rowMysql_Registros_IMAGENES['NO_ARCHIVO'],0,50)."'";
$var_SqlFireBird_EXTENSION = "'".substr($rowMysql_Registros_IMAGENES['EXTENSION'],0,20)."'";

// RUTA
$var_SqlFireBird_RUTA
	= 
	($rowMysql_Registros_IMAGENES['RUTA']!='')? "'".substr($rowMysql_Registros_IMAGENES['RUTA'],0,200)."'" : " NULL";

// DESCRIPCION
$var_SqlFireBird_DESCRIPCION
	=
	($rowMysql_Registros_IMAGENES['DESCRIPCION']!='')? "'".substr($rowMysql_Registros_IMAGENES['DESCRIPCION'],0,100)."'" : " NULL";
	
// TIPO
$var_SqlFireBird_TIPO
	=
	($rowMysql_Registros_IMAGENES['TIPO']!='')? "'".substr($rowMysql_Registros_IMAGENES['TIPO'],0,2)."'" : " NULL";
	
// POLIZA
$var_SqlFireBird_POLIZA
	=
	($rowMysql_Registros_IMAGENES['POLIZA']!='')? "'".substr($rowMysql_Registros_IMAGENES['POLIZA'],0,50)."'" : " NULL";
	
// VALOR
$var_SqlFireBird_VALOR
	=
	($rowMysql_Registros_IMAGENES['VALOR']!='')? "'".substr($rowMysql_Registros_IMAGENES['VALOR'],0,50)."'" : " NULL";

// TIPO_IMG
$var_SqlFireBird_TIPO_IMG
	=
	($rowMysql_Registros_IMAGENES['TIPO_IMG']!='')? "'".substr($rowMysql_Registros_IMAGENES['TIPO_IMG'],0,30)."'" : " NULL";
	
// ESTATUS
$var_SqlFireBird_ESTATUS
	=
	($rowMysql_Registros_IMAGENES['ESTATUS']!='')? "'".substr($rowMysql_Registros_IMAGENES['ESTATUS'],0,2)."'" : " NULL";

// CLIENTE_MPRO
$var_SqlFireBird_CLIENTE_MPRO
	=
	($rowMysql_Registros_IMAGENES['CLIENTE_MPRO']!='')? "'".substr($rowMysql_Registros_IMAGENES['CLIENTE_MPRO'],0,10)."'" : " NULL";
	
// CLIENTE_TMP
$var_SqlFireBird_CLIENTE_TMP
	=
	($rowMysql_Registros_IMAGENES['CLIENTE_TMP']!='')? "'".substr($rowMysql_Registros_IMAGENES['CLIENTE_TMP'],0,10)."'" : " NULL";
	
// NOMBRE_CLIENTE
$var_SqlFireBird_NOMBRE_CLIENTE
	=
	($rowMysql_Registros_IMAGENES['NOMBRE_CLIENTE']!='')? "'".substr($rowMysql_Registros_IMAGENES['NOMBRE_CLIENTE'],0,80)."'" : " NULL";

// FECHA_ALTA
$var_SqlFireBird_FECHA_ALTA
	=
	($rowMysql_Registros_IMAGENES['FECHA_ALTA']!='')? "'".substr($rowMysql_Registros_IMAGENES['FECHA_ALTA'],0,16)."'" : " NULL";

// SUCURSAL
$var_SqlFireBird_SUCURSAL
	=
	($rowMysql_Registros_IMAGENES['SUCURSAL']!='')? "'".substr($rowMysql_Registros_IMAGENES['SUCURSAL'],0,1)."'" : " NULL";
	
// recId
$var_SqlFireBird_recId
	=
	($rowMysql_Registros_IMAGENES['recId']!='')? "'".substr($rowMysql_Registros_IMAGENES['recId'],0,10)."'" : " NULL";

// subRamo
$var_SqlFireBird_subRamo
	=
	($rowMysql_Registros_IMAGENES['subRamo']!='')? "'".substr($rowMysql_Registros_IMAGENES['subRamo'],0,50)."'" : " NULL";
							
			$sqlFireBird_Insert_Registro_IMAGENES = "
				Insert Into 
					IMAGENES_DESCARGA
						(
							NO_ARCHIVO
							, EXTENSION
							, RUTA
							, DESCRIPCION
							, TIPO
							, POLIZA
							, VALOR
							, TIPO_IMG
							, ESTATUS
							, CLIENTEM
							, CLIENTED
							, NOMBRE_CLIENTE
							, FECHA_HORA_ALTA
							, SUCURSAL
							, REC_ID
							, SUBRAMO
							, TOCADO
 							, FECHAPROCESO
						) 
						Values
						(
							".$var_SqlFireBird_NO_ARCHIVO."
							,".$var_SqlFireBird_EXTENSION."
							,".$var_SqlFireBird_RUTA."
							,".$var_SqlFireBird_DESCRIPCION."
							,".$var_SqlFireBird_TIPO."
							,".$var_SqlFireBird_POLIZA."
							,".$var_SqlFireBird_VALOR."
							,".$var_SqlFireBird_TIPO_IMG."
							,".$var_SqlFireBird_ESTATUS."
							,".$var_SqlFireBird_CLIENTE_MPRO."
							,".$var_SqlFireBird_CLIENTE_TMP."
							,".$var_SqlFireBird_NOMBRE_CLIENTE."
							,".$var_SqlFireBird_FECHA_ALTA."
							,".$var_SqlFireBird_SUCURSAL."
							,".$var_SqlFireBird_recId."
							,".$var_SqlFireBird_subRamo."
							,'XX'
							,'".date('Y-m-d g:i')."'
						);
												 ";
//			echo "<pre>";
	//			echo $sqlFireBird_Insert_Registro_IMAGENES;
	//			echo $sqlMysql_Update_Registro_IMAGENES;
//			echo "</pre>";
			
			$resFireBird_Insert_Registro_IMAGENES = DreQueryDbFireBird($sqlFireBird_Insert_Registro_IMAGENES);			
			DreFreeResultDbFireBird($resFireBird_Insert_Registro_IMAGENES);
	
			$sqlMysql_Update_Registro_IMAGENES = "
				Update
					`imagenes`
				Set
					 `actualizado` = '1'
				Where 
					`NO_ARCHIVO` = '".$rowMysql_Registros_IMAGENES['NO_ARCHIVO']."'
											  ";
			// 0 => Sin Descargar;  1=> Descargado;
			DreQueryDB($sqlMysql_Update_Registro_IMAGENES);
			

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