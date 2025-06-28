<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			R_COMISIONGE 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_COMISIONESLI = "Truncate Table `comisionesli`";
		DreQueryDB($sqlMysql_Truncate_COMISIONESLI);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				R_COMISIONGE 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_COMISIONESLI = "
					Insert Into
						`comisionesli`
							(
								`SUCURSAL`
								, `POLIZA`
								, `ENDOSO`
								, `CLIENTE`
								, `RAMO`
								, `SUBRAMO`
								, `VENDEDOR`
								, `CONSULTOR`
								, `ASEGURADORA`
								, `GRUPO`
								, `SUBGRUPO`
								, `COND_PAGO`
								, `CONDUCTO_COBRO`
								, `COMENTARIO`
								, `RECIBO`
								, `INICIO`
								, `FIN`
								, `FORMA_PAGO`
								, `FECHA_PAGO`
								, `FECHA_APLIC`
								, `IMPORTE_PAGO`
								, `MONEDA`
								, `TC`
								, `PRIMA_NETA`
								, `RECARGO`
								, `GASTOS`
								, `IVA`
								, `PRIMA_TOTAL`
								, `PRIMA_NETA_COMISION`
								, `RECARGO_COMISION`
								, `GASTOS_COMISION`
								, `TOTAL_COMISION`
								, `PCTJE_DISPERSION_VEND`
								, `IMPORTE_VEND`
								, `LIQUIDADO_VEND`
								, `FECHA_LIQ_VEND`
								, `PENDIENTE_VEND`
								, `PCTJE_DISPERSION_CONS`
								, `IMPORTE_CONS`
								, `LIQUIDADO_CONS`
								, `FECHA_CONS`
								, `PENDIENTE_CONS`
								, `PCJTE_DISPERSION_COM`
								, `IMPORTE_COM`
								, `LIQUIDADO_COM`
								, `FECHA_COM`
								, `PENDIENTE_COM`
								,`CT_PCTJE`
							)
						Values
							(
								'".$fila->SUCURSAL."'
								,'".$fila->POLIZA."'
								,'".$fila->ENDOSO."'
								,'".$fila->CLIENTE."'
								,'".$fila->RAMO."'
								,'".$fila->SUBRAMO."'
								,'".$fila->VENDEDOR."'
								,'".$fila->CONSULTOR."'
								,'".$fila->ASEGURADORA."'
								,'".$fila->GRUPO."'
								,'".$fila->SUBGRUPO."'
								,'".$fila->CONDICION_PAGO."'
								,'".$fila->CONDUCTO_COBRO."'
								,'".$fila->COMENTARIO."'
								,'".$fila->RECIBO."'
								,'".$fila->INICIO."'
								,'".$fila->FIN."'
								,'".$fila->FORMA_PAGO."'
								,'".$fila->FECHA_PAGO."'
								,'".$fila->FECHA_APLICACION."'
								,'".$fila->IMPORTE_PAGO."'
								,'".$fila->MONEDA."'
								,'".$fila->TC."'
								,'".$fila->PRIMA_NETA."'
								,'".$fila->RECARGO."'
								,'".$fila->GASTO."'
								,'".$fila->IVA."'
								,'".$fila->PRIMA_TOTAL."'
								,'".$fila->CT_PRIMA_NETA."'
								,'".$fila->CT_RECARGO."'
								,'".$fila->CT_GASTO."'
								,'".$fila->CT_TOTAL."'
								,'".$fila->CV_PCTJE."'
								,'".$fila->CV_IMPORTE."'
								,'".$fila->CV_LIQUIDADO."'
								,'".$fila->CV_FECHA_LIQUIDADO."'
								,'".$fila->CV_PENDIENTE_LIQUIDAR."'
								,'".$fila->CCN_PCTJE."'
								,'".$fila->CCN_IMPORTE."'
								,'".$fila->CCN_LIQUIDADO."'
								,'".$fila->CCN_FECHA_LIQUIDADO."'
								,'".$fila->CCN_PENDIENTE_LIQUIDAR."'
								,'".$fila->CCM_PCTJE."'
								,'".$fila->CCM_IMPORTE."'
								,'".$fila->CCM_LIQUIDADO."'
								,'".$fila->CCM_FECHA_LIQUIDADO."'
								,'".$fila->CCM_PENDIENTE_LIQUIDAR."'
								,'".$fila->CT_PCTJE."'
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_COMISIONESLI)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_COMISIONESLI = "
						Update 
							R_COMISIONGE 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
												 ";

//-->					$resFireBird_Update_True_COMISIONESLI = DreQueryDbFireBird($sqlFireBird_Update_True_COMISIONESLI);
//-->					DreFreeResultDbFireBird($resFireBird_Update_True_COMISIONESLI);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_COMISIONESLI = "
						Update 
							R_COMISIONGE 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
													 ";
					$resFireBird_Update_False_COMISIONESLI = DreQueryDbFireBird($sqlFireBird_Update_False_COMISIONESLI);
					DreFreeResultDbFireBird($resFireBird_Update_False_COMISIONESLI);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
	} else {
		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

$sqlMantenimiento1 = "
	Update 
		`comisionesli`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`comisionesli` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `comisionesli`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `comisionesli` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `comisionesli` .`CONSULTOR`)
		,`SUCURSAL_NOMBRE` = (Select `nombre` From `catalogo_sucursales` Where `catalogo_sucursales`.`clave` = `comisionesli`.`SUCURSAL`);
					";
DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);

			$sqlFireBird_Update_TrueParche_COMISIONESLI = "
				Update 
					R_COMISIONGE 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";

			$resFireBird_Update_TrueParche_COMISIONESLI = DreQueryDbFireBird($sqlFireBird_Update_TrueParche_COMISIONESLI);
			DreFreeResultDbFireBird($resFireBird_Update_TrueParche_COMISIONESLI);

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>