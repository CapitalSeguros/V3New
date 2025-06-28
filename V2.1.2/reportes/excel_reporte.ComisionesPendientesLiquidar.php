<?
			$xls->OpenRow();
				$xls->NewCell('Reporte De Comisiones Pendientes de Liquidar ',false,$xls_encabezado);
			$xls->CloseRow();
	
			$xls->OpenRow();	
			$xls->CloseRow();
			$xls->OpenRow();
				$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
				$xls->NewCell($fechaInicio,true,$xls_normal);
			$xls->CloseRow();
	
			$xls->OpenRow();
				$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
				$xls->NewCell($fechaFin,true,$xls_normal);
			$xls->CloseRow();

//** Filtros Aplicados Al Reporte
if($_POST['filtroSucursal'] != ""){
			$xls->OpenRow();
				$xls->NewCell('SUCURSAL:',true,$xls_fondoAzul);
//				$xls->NewCell(DreNombreSucursalV2(str_pad(str_replace($quitarCosas, $ponerCosas, strstr($filtroSucursal, '[',0)),4,"0",STR_PAD_LEFT)),true,$xls_normal); //DreNombreSucursalV2('0001')
				$xls->NewCell($filtroSucursal,true,$xls_normal);
			$xls->CloseRow();			
}

if($filtroConsultor != ""){
			$xls->OpenRow();
				$xls->NewCell('CONSULTOR:',true,$xls_fondoAzul);
				$xls->NewCell($filtroConsultor,true,$xls_normal);
			$xls->CloseRow();			
}

if($_POST['filtroVendedor'] != ""){
			$xls->OpenRow();
				$xls->NewCell('VENDEDOR:',true,$xls_fondoAzul);
//				$xls->NewCell(nombreUsuario(str_replace($quitarCosas, $ponerCosas, strstr($filtroVendedor, '[',0))),true,$xls_normal); //$filtroVendedor;
				$xls->NewCell($filtroVendedor,true,$xls_normal); //$filtroVendedor;
			$xls->CloseRow();			
}
/*
if($filtroAseguradora != ""){
			$xls->OpenRow();
				$xls->NewCell('ASEGURADORA:',true,$xls_fondoAzul);
				$xls->NewCell($filtroAseguradora,true,$xls_normal);
			$xls->CloseRow();			
}
*/
if($filtroRamo != ""){
			$xls->OpenRow();
				$xls->NewCell('RAMO:',true,$xls_fondoAzul);
				$xls->NewCell($filtroRamo,true,$xls_normal);
			$xls->CloseRow();			
}
if($filtroSubRamo != ""){
			$xls->OpenRow();
				$xls->NewCell('SUBRAMO:',true,$xls_fondoAzul);
				$xls->NewCell($filtroSubRamo,true,$xls_normal);
			$xls->CloseRow();			
}
if($filtroCliente != ""){
			$xls->OpenRow();
				$xls->NewCell('CLIENTE:',true,$xls_fondoAzul);
				$xls->NewCell($filtroCliente,true,$xls_normal);
			$xls->CloseRow();			
}
if($filtroGrupo != ""){
			$xls->OpenRow();
				$xls->NewCell('GRUPO:',true,$xls_fondoAzul);
				$xls->NewCell($filtroGrupo,true,$xls_normal);
			$xls->CloseRow();			
}
if($filtroSubGrupo != ""){
			$xls->OpenRow();
				$xls->NewCell('SUBGRUPO:',true,$xls_fondoAzul);
				$xls->NewCell($filtroSubGrupo,true,$xls_normal);
			$xls->CloseRow();			
}
/*
if($filtroPoliza != ""){
			$xls->OpenRow();
				$xls->NewCell('POLIZA:',true,$xls_fondoAzul);
				$xls->NewCell($filtroPoliza,true,$xls_normal);
			$xls->CloseRow();			
}
*/

			$xls->OpenRow();	
			$xls->CloseRow();

			$xls->OpenRow();	
if($verSucursal == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
if($verVendedor == "on"){				$xls->NewCell('',true,''); }
if($verConsultor == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
if($verGrupo == "on"){				$xls->NewCell('',true,''); }
if($verSubGrupo == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('RECIBO',false,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('COMISION',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado_2);
			$xls->CloseRow();
	
			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell('SUCURSAL',true,$xls_fondoAzul); }
				$xls->NewCell('POLIZA',true,$xls_fondoAzul);
				$xls->NewCell('ENDOSO',true,$xls_fondoAzul);
				$xls->NewCell('CLIENTE',true,$xls_fondoAzul);
				$xls->NewCell('RAMO',true,$xls_fondoAzul);
				$xls->NewCell('SUBRAMO',true,$xls_fondoAzul);
if($verVendedor == "on"){				$xls->NewCell('VENDEDOR',true,$xls_fondoAzul); }
if($verConsultor == "on"){				$xls->NewCell('CONSULTOR',true,$xls_fondoAzul); }
				$xls->NewCell('ASEGURADORA',true,$xls_fondoAzul);
if($verGrupo == "on"){	$xls->NewCell('GRUPO',true,$xls_fondoAzul);	}
if($verSubGrupo == "on"){	$xls->NewCell('SUBGRUPO',true,$xls_fondoAzul);	}
				$xls->NewCell('RECIBO',true,$xls_fondoAzul);
				$xls->NewCell('INICIO',true,$xls_fondoAzul);
				$xls->NewCell('FIN',true,$xls_fondoAzul);
				$xls->NewCell('FECHA PAGO',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA NETA',true,$xls_fondoAzul);
				$xls->NewCell('RECARGO',true,$xls_fondoAzul);
				$xls->NewCell('GASTOS',true,$xls_fondoAzul);
				$xls->NewCell('IVA',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA TOTAL',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA NETA',true,$xls_fondoAzul);
				$xls->NewCell('RECARGO',true,$xls_fondoAzul);
				$xls->NewCell('GASTOS',true,$xls_fondoAzul);
				$xls->NewCell('TOTAL',true,$xls_fondoAzul);
				$xls->NewCell('% RECIBO',true,$xls_fondoAzul);
				$xls->NewCell('% VENDEDOR',true,$xls_fondoAzul);
				$xls->NewCell('IMPORTE A PAGAR PENDIENTE',true,$xls_fondoAzul);
			$xls->CloseRow();

			$sqlComisionesPenLiq = "
				Select * From
					`comisionespl` 
				Where
					`SUCURSAL` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSucursal, '[',0))."%'
					And
					`CONSULTOR` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroConsultor, '[',0))."%'
					And
					`VENDEDOR` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroVendedor, '[',0))."%'
					And 
					`RAMO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroRamo, '[',0))."%'
					And 
					`SUBRAMO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubRamo, '[',0))."%'
					And 
					`CLIENTE` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroCliente, '[',0))."%'
					And
					`GRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroGrupo, '[',0))."%'
					And 
					`SUBGRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubGrupo, '[',0))."%'
--					And
--					`POLIZA` = '$filtroPoliza'
--					And 
--					`ASEGURADORA` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroAseguradora, '[',0))."%'
					And
					`FECHA_APLIC` Between '$fechaInicio' And '$fechaFin'
					Order By
						`FECHA_APLIC` Desc
							  ";
			$resComisionesPenLiq = DreQueryDB($sqlComisionesPenLiq);
//**
	$total_PRIMA_NETA = 0;
	$total_RECARGO = 0;
	$total_GASTOS = 0;
	$total_IVA = 0;
	$total_PRIMA_TOTAL  = 0;

//**
	$total_PRIMA_NETA_COMISION = 0;
	$total_RECARGO_COMISION = 0;
	$total_GASTOS_COMISION = 0;
	$total_TOTAL_COMISION = 0;
	$total_IMPORTE_VEND  = 0;
	
			while($rowComisionesPenLiq = mysql_fetch_assoc($resComisionesPenLiq)){
				//**
				$FECHA_PAGOX = explode('-',$rowComisionesPenLiq['FECHA_PAGO']);
				$FECHA_PAGOExcel = $FECHA_PAGOX[2]."/".$FECHA_PAGOX[1]."/".$FECHA_PAGOX[0];
				
				//**
				$INICIOX = explode('-',$rowComisionesPenLiq['INICIO']);
				$INICIOExcel = $INICIOX[2]."/".$INICIOX[1]."/".$INICIOX[0];
				
				//**
				$FINX = explode('-',$rowComisionesPenLiq['FIN']);
				$FINExcel = $FINX[2]."/".$FINX[1]."/".$FINX[0];

//**
				$total_PRIMA_NETA = $rowComisionesPenLiq['PRIMA_NETA'] + $total_PRIMA_NETA;
				$total_RECARGO = $rowComisionesPenLiq['RECARGO'] + $total_RECARGO;
				$total_GASTOS = $rowComisionesPenLiq['GASTOS'] + $total_GASTOS;
				$total_IVA = $rowComisionesPenLiq['IVA'] + $total_IVA;
				$total_PRIMA_TOTAL = $rowComisionesPenLiq['PRIMA_TOTAL'] + $total_PRIMA_TOTAL;
//**
				$total_PRIMA_NETA_COMISION = $rowComisionesPenLiq['PRIMA_NETA_COMISION'] + $total_PRIMA_NETA_COMISION;
				$total_RECARGO_COMISION = $rowComisionesPenLiq['RECARGO_COMISION'] + $total_RECARGO_COMISION;
				$total_GASTOS_COMISION = $rowComisionesPenLiq['GASTOS_COMISION'] + $total_GASTOS_COMISION;
				$total_TOTAL_COMISION = $rowComisionesPenLiq['TOTAL_COMISION'] + $total_TOTAL_COMISION;
				$total_IMPORTE_VEND = $rowComisionesPenLiq['IMPORTE_VEND'] + $total_IMPORTE_VEND;
//echo "<pre>";
	//print_r($rowComisionesPenLiq);
//echo "<pre>";
				extract($rowComisionesPenLiq);

			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell($SUCURSAL_NOMBRE,true,$xls_normal); }
				$xls->NewCell($POLIZA,true,$xls_normal);
				$xls->NewCell($ENDOSO,true,$xls_normal);
				$xls->NewCell($CLIENTE_NOMBRE,true,$xls_normal);
				$xls->NewCell(DreNombreRamo($RAMO),true,$xls_normal);
				$xls->NewCell(DreNombreSubRamo($SUBRAMO),true,$xls_normal);
if($verVendedor == "on"){				$xls->NewCell($VENDEDOR_NOMBRE,true,$xls_normal); }
if($verConsultor == "on"){				$xls->NewCell($CONSULTOR_NOMBRE,true,$xls_normal); }
				$xls->NewCell(DreNombreAseguradora($ASEGURADORA),true,$xls_normal);
if($verGrupo == "on"){	$xls->NewCell(DreNombreGrupo($GRUPO),true,$xls_normal);	}
if($verSubGrupo == "on"){	$xls->NewCell(DreNombreSubGrupo($SUBGRUPO),true,$xls_normal);	}
				$xls->NewCell($RECIBO,true,$xls_int);
				$xls->NewCell($INICIOExcel,true,$xls_normal);
				$xls->NewCell($FINExcel,true,$xls_normal);
				$xls->NewCell($FECHA_PAGOExcel,true,$xls_date);
//**
				$xls->NewCell("$".number_format($PRIMA_NETA,2),true,$xls_normal);
				$xls->NewCell("$".number_format($RECARGO,2),true,$xls_normal);
				$xls->NewCell("$".number_format($GASTOS,2),true,$xls_normal);
				$xls->NewCell("$".number_format($IVA,2),true,$xls_normal);
				$xls->NewCell("$".number_format($PRIMA_TOTAL,2),true,$xls_normal);
//**
				$xls->NewCell("$".number_format($PRIMA_NETA_COMISION,2),true,$xls_normal);
				$xls->NewCell("$".number_format($RECARGO_COMISION,2),true,$xls_normal);
				$xls->NewCell("$".number_format($GASTOS_COMISION,2),true,$xls_normal);
				$xls->NewCell("$".number_format($TOTAL_COMISION,2),true,$xls_normal);
				$xls->NewCell('',true,$xls_normal);
				$xls->NewCell($PCTJE_DISPERSION_VEND,true,$xls_normal);
				$xls->NewCell("$".number_format($IMPORTE_VEND,2),true,$xls_normal);
			$xls->CloseRow();
}

			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
if($verVendedor == "on"){				$xls->NewCell('',true,''); }
if($verConsultor == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
if($verGrupo == "on"){				$xls->NewCell('',true,''); }
if($verSubGrupo == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
//**
				$xls->NewCell("$".number_format($total_PRIMA_NETA,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_RECARGO,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_GASTOS,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_IVA,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_PRIMA_TOTAL,2),true,$xls_normal_negrita);

//**
				$xls->NewCell("$".number_format($total_PRIMA_NETA_COMISION,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_RECARGO_COMISION,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_GASTOS_COMISION,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_TOTAL_COMISION,2),true,$xls_normal_negrita);
				$xls->NewCell('',true,$xls_int_negrita);
				$xls->NewCell('',true,$xls_int_negrita);
				$xls->NewCell("$".number_format($total_IMPORTE_VEND,2),true,$xls_normal_negrita);
			$xls->CloseRow();
	$xls->GetXLS('comisionesPendientesLiq');
/*
	echo "<pre>";
		print_r($_REQUEST);
		echo $sqlComisionesPenLiq;
	echo "</pre>";
*/
?>