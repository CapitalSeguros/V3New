<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select
			Count(*) As EXISTEN_REGISTROS 
		From 
			COMENTARIOS 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		//--> $sqlMysql_Truncate_COMENTARIOS = "Truncate Table `COMENTARIOS`";
		//--> DreQueryDB($sqlMysql_Truncate_COMENTARIOS);
		
		$sqlFireBird = "
			Select * From 
				COMENTARIOS 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
			$status = "1";
			$sqlMysql_Insert_COMENTARIOS = "
				Insert Into
					`cobranzapendiente_comentarios`
						(
							`poliza`
							, `comentario`
							, `fecha`
							, `operador`
							, `origen`
							, `status`
						)
					Values
						(
							'".$fila->POLIZA."'
							,'".$fila->COMENTARIO."'
							,'".$fila->FECHA."'
							,'".$fila->OPERADOR."'
							,'".$fila->ORIGEN."'
							,'".$status."'
						);
										  ";

			if(DreQueryDB($sqlMysql_Insert_COMENTARIOS)){
				$sqlFireBird_Update_COMENTARIOS = "
					Update 
					COMENTARIOS 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
				Where 
					POLIZA = '".$fila->POLIZA."' And FECHA = '".$fila->FECHA."'
												 ";
				$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_COMENTARIOS);
			} else {
				$sqlFireBird_Update_COMENTARIOS = "
					Update 
					COMENTARIOS 
				Set 
					TOCADO = 'NO'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
				Where 
					POLIZA = '".$fila->POLIZA."' And FECHA = '".$fila->FECHA."'
												 ";
				$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_COMENTARIOS);
			}
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($resFireBird_2);
		$sqlMantenimientoMySql_1 = "
			Update 
				`cobranzapendiente_comentarios`
			set
				`operador` = Lpad(`operador`,10,'0');
								   ";
					
		DreQueryDB($sqlMantenimiento1);

		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

	//echo "<pre>";
		//echo $fila->POLIZA."<br>";
		//echo $sqlMysql_Insert_COMENTARIOS;
		//echo $sqlFireBird_Update_COMENTARIOS;
	//echo "</pre>";

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>