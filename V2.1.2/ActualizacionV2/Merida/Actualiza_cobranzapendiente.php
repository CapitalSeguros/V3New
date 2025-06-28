<?php
include('../Config/funcionesDreFireBird.php');
include('../../config/funcionesDre.php');

$conexFireBird = DreConectarDbFireBird();
$conexMySql = DreConectarDB();

	$sqlFireBird_Validacion_Registros = "
		Select 
			Count(*) As EXISTEN_REGISTROS 
		From 
			COBRANZAPENDIENTE 
		Where 
			TOCADO Like '%XX%'
										";
	//echo "<pre>".$sqlFireBird_Validacion_Registros."</pre>";
	
	$resFireBird_Validacion_Registros = DreQueryDbFireBird($sqlFireBird_Validacion_Registros);
	$rowFirebird_Validacion_Registros = ibase_fetch_object($resFireBird_Validacion_Registros);
	DreFreeResultDbFireBird($rowFirebird_Validacion_Registros);
	
	if((int)$rowFirebird_Validacion_Registros->EXISTEN_REGISTROS > 0){
		//echo "si hay registros a procesar";
	
		$sqlMysql_Truncate_COBRANZAPENDIENTE = "Truncate Table `cobranzapendiente`";
		DreQueryDB($sqlMysql_Truncate_COBRANZAPENDIENTE);
		
		$sqlFireBird = "
			Select 
			-- First 500 
			* 
			From 
				COBRANZAPENDIENTE 
			Where 
				TOCADO Like '%XX%'
					   ";
		$resFireBird = DreQueryDbFireBird($sqlFireBird);

		while ($fila = ibase_fetch_object($resFireBird)) {
			
				//-->
				$sqlMysql_Insert_COBRANZAPENDIENTE = "
					Insert Into
						`cobranzapendiente`
							(
								`poliza`
								, `endoso`
								, `CLIENTE`
								, `VENDEDOR`
								, `aseguradora`
								, `condicion_pago`
								, `Numero_Recibo`
								, `inicio_vigencia`
								, `fin_vigencia`
								, `vencimiento`
								, `importe`
								, `subgrupo`
								, `subramo`
								, `conducto_cobro`
								, `color_linea`
								, `SUCURSAL`						
							)
						Values
							(
								'".$fila->POLIZA."'
								,'".$fila->ENDOSO."'
								,'".$fila->CLAVECLIENTE."'
								,'".$fila->VENDEDOR."'
								,'".$fila->ASEGURADORA."'
								,'".$fila->CONDICIONC."'
								,'".$fila->NUMERO."'
								,'".$fila->INICIO."'
								,'".$fila->FIN."'
								,'".$fila->VENCE."'
								,'".$fila->TOTAL."'
								,'".$fila->TIPO_CLIENTE."'
								,'".$fila->SUBRAMO."'
								,'".$fila->FORMA_PAGO."'
								,'".$fila->ESTADO."'
								,'".$fila->SUCURSAL."'
							);
											";



//-->	echo "InsertRegistro<br>";	
//-->	echo "<pre>".$sqlMysql_Insert_COBRANZAPENDIENTE."</pre>";
	//-->			DreQueryDB($sqlMysql_Insert_COBRANZAPENDIENTE);

				if(DreQueryDB($sqlMysql_Insert_COBRANZAPENDIENTE)){
					//--> echo "Update Firebir Insert True";
					$sqlFireBird_Update_COBRANZAPENDIENTE = "
						Update 
							COBRANZAPENDIENTE 
						Set 
							TOCADO = 'SI'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
							And 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
							And 
							NUMERO = '".$fila->NUMERO."'
												 ";
//-->	echo "<pre>".$sqlFireBird_Update_COBRANZAPENDIENTE."</pre>";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_COBRANZAPENDIENTE);
				} else {
					//--> echo "Update Firebir Insert False";
					$sqlFireBird_Update_COBRANZAPENDIENTE = "
						Update 
							COBRANZAPENDIENTE 
						Set 
							TOCADO = 'NO'
							,FECHAPROCESO = '".date('Y-m-d g:i')."'
						Where 
							POLIZA = '".$fila->POLIZA."'
							And 
							CLAVECLIENTE = '".$fila->CLAVECLIENTE."'
							And 
							NUMERO = '".$fila->NUMERO."'
													 ";
//-->	echo "<pre>".$sqlFireBird_Update_COBRANZAPENDIENTE."</pre>";
					$resFireBird_2 = DreQueryDbFireBird($sqlFireBird_Update_COBRANZAPENDIENTE);
				}
		}
		
		DreFreeResultDbFireBird($resFireBird);
		DreFreeResultDbFireBird($resFireBird_2);
		
	} else {

		//echo "no hay registros a procesar";
		
	} // Fin  Validacion Existen Registros

$sqlMantenimiento1 = "
	Update 
		`cobranzapendiente`
	set
		`VENDEDOR` = Lpad(`VENDEDOR`,10,'0');
					";
					
$sqlMantenimiento2 = "
	Update 
		`cobranzapendiente` 
	Set 
		`CLIENTE_NOMBRE` = (Select `RAZON_SOCIAL` From `empresas` Where `empresas`.`CLAVE` = `cobranzapendiente`.`CLIENTE`)
		,`VENDEDOR_NOMBRE` = (Select `NOMBRE` From `vendedores` Where `vendedores`.`CLAVE` = `cobranzapendiente` .`VENDEDOR`)
		,`SUCURSAL_NOMBRE` = (Select `nombre` From `catalogo_sucursales` Where `catalogo_sucursales`.`clave` = `cobranzapendiente`.`SUCURSAL`);
					";

DreQueryDB($sqlMantenimiento1);
DreQueryDB($sqlMantenimiento2);

echo "Actualizacion de Correcta !!!";
include('CerrarVentana.php');

DreDesconectarDbFireBird($conexFireBird);
DreDesconectarDB($conexMySql);
?>