<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			R_CONTROLRENOVA 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_RENOVACIONES = "Truncate Table `renovaciones`";
		DreQueryDB($sqlMysql_Truncate_RENOVACIONES);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				R_CONTROLRENOVA 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_RENOVACIONES = "
					Insert Into
						`renovaciones`
							(
								`SUCURSAL`
								, `EMISION`
								, `POLIZA`
								, `ENDOSO`
								, `RAMO`
								, `SUBRAMO`
								, `DESCRIPCION`
								, `MODELO`
								, `NoSERIE`
								, `VENDEDOR`
								, `CONSULTOR`
								, `ASEGURADORA`
								, `GRUPO`
								, `SUBGRUPO`
								, `CLIENTE`
								, `PERSONA_F_M`
								, `COND_PAGO`
								, `CONDUCTO_COBRO`
								, `INICIO`
								, `FIN`
								, `PRIMA_NETA`
								, `RECARGO`
								, `GASTOS`
								, `IVA`
								, `PRIMA_TOTAL`
								, `PRIMA_NETA_COMISION`
								, `RECARGO_COMISION`
								, `GASTOS_COMISION`
								, `TOTAL_COMISION`
								, `COMENTARIOS`
								, `CLIENTE_NOMBRE`
								, `VENDEDOR_NOMBRE`
								, `CONSULTOR_NOMBRE`
								, `SUCURSAL_NOMBRE`
								, `color_linea`
							)
						Values
							(
'".$fila->SUCURSAL."'
,'".$fila->POLIZA_RENOVACION."'
,'".$fila->POLIZA_ANTERIOR."'
,'".$fila->ENDOSO."'
,'".$fila->RAMO."'
,'".$fila->SUBRAMO."'
,'".$fila->DESCRIPCION."'
,'".$fila->MODELO."'
,'".$fila->NO_SERIE."'
,'".$fila->VENDEDOR."'
,'".$fila->CONSULTOR."'
,'".$fila->ASEGURADORA."'
,'".$fila->GRUPO."'
,'".$fila->SUBGRUPO."'
,'".$fila->CLIENTE."'
,'".$fila->PERSONA_FM."'
,'".$fila->CONDICION_PAGO."'
,'".$fila->CONDUCTO_COBRO."'
,'".$fila->INICIO."'
,'".$fila->FIN."'
,'".$fila->PRIMA_NETA."'
,'".$fila->RECARGO."'
,'".$fila->GASTO."'
,'".$fila->IVA."'
,'".$fila->PRIMA_TOTAL."'
,'".$fila->CT_PRIMA_NETA."'
,'".$fila->CT_RECARGO."'
,'".$fila->CT_GASTO."'
,'".$fila->CT_TOTAL."'
,'".$fila->COMENTARIO."'
,'".$fila->ESTATUS."'
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_RENOVACIONES)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_RENOVACIONES = "
						Update 
							R_CONTROLRENOVA 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
												 ";

//-->					$resFireBird_Update_True_RENOVACIONES = DreQueryDbFireBird($sqlFireBird_Update_True_RENOVACIONES);
//-->					DreFreeResultDbFireBird($resFireBird_Update_True_RENOVACIONES);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_RENOVACIONES = "
						Update 
							R_CONTROLRENOVA 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
													 ";
					$resFireBird_Update_False_RENOVACIONES = DreQueryDbFireBird($sqlFireBird_Update_False_RENOVACIONES);
					DreFreeResultDbFireBird($resFireBird_Update_False_RENOVACIONES);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
			$sqlFireBird_Update_TrueParche_RENOVACIONES = "
				Update 
					R_CONTROLRENOVA 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";

			$resFireBird_Update_TrueParche_RENOVACIONES = DreQueryDbFireBird($sqlFireBird_Update_TrueParche_RENOVACIONES);
			DreFreeResultDbFireBird($resFireBird_Update_TrueParche_RENOVACIONES);

	} else {
		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

$sqlMantenimiento1 = "
	Update 
		`renovaciones`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`renovaciones` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `renovaciones`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `renovaciones` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `renovaciones` .`CONSULTOR`)
		,`SUCURSAL_NOMBRE` = (Select `nombre` From `catalogo_sucursales` Where `catalogo_sucursales`.`clave` = `renovaciones`.`SUCURSAL`);
					";
DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);


echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>