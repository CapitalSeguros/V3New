<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			R_PRODUCCION 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_PRODUCCION = "Truncate Table `produccion`";
//-->		DreQueryDB($sqlMysql_Truncate_PRODUCCION);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				R_PRODUCCION 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_PRODUCCION = "
					Insert Into
						`produccion`
							(
								`SUCURSAL`
								, `TIPO`
								, `FECHA_CAPTURA`
								, `FECHA_EMISION`
								, `POLIZA`
								, `POLIZA_ANTERIOR`
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
								, `PAGADO`
								, `MONEDA`
								, `TC`
								, `CAMBIO_CONDUCTO`
								, `PRIMA_NETA`
								, `RECARGO`
								, `GASTOS`
								, `IVA`
								, `PRIMA_TOTAL`
								, `PORCENTAJE`
								, `PRIMA_NETA_COMISION`
								, `RECARGO_COMISION`
								, `GASTOS_COMISION`
								, `TOTAL_COMISION`
								, `PCTJE_DISPERSION_VEND`
								, `IMPORTE_VEND`
								, `PCTJE_DISPERSION_CONS`
								, `IMPORTE_CONS`
								, `PCJTE_DISPERSION_COM`
								, `IMPORTE_COM`
							)
						Values
							(
'".$fila->SUCURSAL."'
,'".$fila->TIPO."'
,'".$fila->FECHA_CAPTURA."'
,'".$fila->FECHA_EMISION."'
,'".$fila->POLIZA."'
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
,'".$fila->PAGADO."'
,'".$fila->MONEDA."'
,'".$fila->TC."'
,'".$fila->CAMBIO_CONDUCTO."'
,'".$fila->PRIMA_NETA."'
,'".$fila->RECARGO."'
,'".$fila->GASTO."'
,'".$fila->IVA."'
,'".$fila->PRIMA_TOTAL."'
,'".$fila->CT_PCTJE."'
,'".$fila->CT_PRIMA_NETA."'
,'".$fila->CT_RECARGO."'
,'".$fila->CT_GASTO."'
,'".$fila->CT_TOTAL."'
,'".$fila->CV_PCTJE."'
,'".$fila->CV_IMPORTE."'
,'".$fila->CCN_PCTJE."'
,'".$fila->CCN_IMPORTE."'
,'".$fila->CCM_PCTJE."'
,'".$fila->CCM_IMPORTE."'

							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_PRODUCCION)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_PRODUCCION = "
						Update 
							R_PRODUCCION 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
												 ";

//-->					$resFireBird_Update_True_PRODUCCION = DreQueryDbFireBird($sqlFireBird_Update_True_PRODUCCION);
//-->					DreFreeResultDbFireBird($resFireBird_Update_True_PRODUCCION);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_PRODUCCION = "
						Update 
							R_PRODUCCION 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
													 ";
					$resFireBird_Update_False_PRODUCCION = DreQueryDbFireBird($sqlFireBird_Update_False_PRODUCCION);
					DreFreeResultDbFireBird($resFireBird_Update_False_PRODUCCION);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
			$sqlFireBird_Update_TrueParche_PRODUCCION = "
				Update 
					R_PRODUCCION 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";

			$resFireBird_Update_TrueParche_PRODUCCION = DreQueryDbFireBird($sqlFireBird_Update_TrueParche_PRODUCCION);
			DreFreeResultDbFireBird($resFireBird_Update_TrueParche_PRODUCCION);

	} else {
		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

$sqlMantenimiento1 = "
	Update 
		`produccion`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`produccion` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `produccion`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `produccion` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `produccion` .`CONSULTOR`)
		,`SUCURSAL_NOMBRE` = (Select `nombre` From `catalogo_sucursales` Where `catalogo_sucursales`.`clave` = `produccion`.`SUCURSAL`);
					";
DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);


echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>