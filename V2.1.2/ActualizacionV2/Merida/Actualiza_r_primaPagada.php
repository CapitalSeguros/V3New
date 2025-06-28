<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			R_PRIMAPAGADA 
		Where 
			TOCADO Like '%XX%'
										";
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_R_PRIMAPAGADA = "Truncate Table `primapagada`";
		DreQueryDB($sqlMysql_Truncate_R_PRIMAPAGADA);
		
		$sqlFireBird = "
			Select 
			-- First 500
			* 
			From 
				R_PRIMAPAGADA 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_R_PRIMAPAGADA = "
					Insert Into
						`primapagada`
							(
								`SUCURSAL`
								, `TIPO`
								, `POLIZA`
								, `ENDOSO`
								, `CLIENTE`
								, `RAMO`
								, `SUBRAMO`
								, `VENDEDOR`
								, `CONSULTOR`
								, `DESCRIPCION`
								, `MODELO`
								, `NO_SERIE`
								, `ASEGURADORA`
								, `GRUPO`
								, `SUBGRUPO`
								, `CONDICION_PAGO`
								, `CONDUCTO_COBRO`
								, `COMENTARIO`
								, `RECIBO`
								, `INICIO`
								, `FIN`
								, `FORMA_PAGO`
								, `FECHA_PAGO`
								, `FECHA_APLICACION`
								, `IMPORTE_PAGO`
								, `MONEDA`
								, `TC`
								, `PRIMA_NETA`
								, `RECARGO`
								, `GASTO`
								, `IVA`
								, `PRIMA_TOTAL`
								, `CT_PRIMA_NETA`
								, `CT_RECARGO`
								, `CT_GASTO`
								, `CT_TOTAL`
								, `CAMBIO_CONDUCTO`
							)
						Values
							(
'".$fila->SUCURSAL."'
,'".$fila->TIPO."'
,'".$fila->POLIZA."'
,'".$fila->ENDOSO."'
,'".$fila->CLIENTE."'
,'".$fila->RAMO."'
,'".$fila->SUBRAMO."'
,'".$fila->VENDEDOR."'
,'".$fila->CONSULTOR."'
,'".$fila->DESCRIPCION."'
,'".$fila->MODELO."'
,'".$fila->NO_SERIE."'
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
,'".$fila->CAMBIO_CONDUCTO."'
							);
											";
	
				if(DreQueryDB($sqlMysql_Insert_R_PRIMAPAGADA)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_True_R_PRIMAPAGADA = "
						Update 
							R_PRIMAPAGADA 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
												 ";

//-->					$resFireBird_Update_True_R_PRIMAPAGADA = DreQueryDbFireBird($sqlFireBird_Update_True_R_PRIMAPAGADA);
//-->					DreFreeResultDbFireBird($resFireBird_Update_True_R_PRIMAPAGADA);
					
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_False_R_PRIMAPAGADA = "
						Update 
							R_PRIMAPAGADA 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
													 ";
					$resFireBird_Update_False_R_PRIMAPAGADA = DreQueryDbFireBird($sqlFireBird_Update_False_R_PRIMAPAGADA);
					DreFreeResultDbFireBird($resFireBird_Update_False_R_PRIMAPAGADA);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
	} else {
		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

$sqlMantenimiento1 = "
	Update 
		`primapagada`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0')
        ,`CONSULTOR` = Lpad(`CONSULTOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`primapagada` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `primapagada`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `primapagada` .`VENDEDOR`)
		,`CONSULTOR_NOMBRE` = (Select `NOMBRE` From `usuarios` Where `usuarios`.`VALOR` = `primapagada` .`CONSULTOR`)
		,`SUCURSAL_NOMBRE` = (Select `nombre` From `catalogo_sucursales` Where `catalogo_sucursales`.`clave` = `primapagada`.`SUCURSAL`);
					";
DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);

			$sqlFireBird_Update_TrueParche_R_PRIMAPAGADA = "
				Update 
					R_PRIMAPAGADA 
				Set 
					TOCADO = 'SI'
					,FECHAPROCESO = '".date('Y-m-d g:i')."'
												 ";

			$resFireBird_Update_TrueParche_R_PRIMAPAGADA = DreQueryDbFireBird($sqlFireBird_Update_TrueParche_R_PRIMAPAGADA);
			DreFreeResultDbFireBird($resFireBird_Update_TrueParche_R_PRIMAPAGADA);

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>