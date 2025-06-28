<?
			$xls->OpenRow();
				$xls->NewCell('Reporte De Prima Neta Pagada',false,$xls_encabezado);
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
if($verGrupo == "on"){	$xls->NewCell('',true,'');	}
if($verSubGrupo == "on"){	$xls->NewCell('',true,'');	}
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
if($verVendedor == "on"){				$xls->NewCell('',true,''); }
if($verConsultor == "on"){				$xls->NewCell('',true,''); }
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('PRIMA NETA',false,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
			$xls->CloseRow();

			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell('SUCURSAL',true,$xls_fondoAzul); }
				$xls->NewCell('POLIZA',true,$xls_fondoAzul);
				$xls->NewCell('ENDOSO',true,$xls_fondoAzul);
				$xls->NewCell('CLIENTE',true,$xls_fondoAzul);
if($verGrupo == "on"){	$xls->NewCell('GRUPO',true,$xls_fondoAzul);	}
if($verSubGrupo == "on"){	$xls->NewCell('SUBGRUPO',true,$xls_fondoAzul);	}
				$xls->NewCell('RAMO',true,$xls_fondoAzul);
				$xls->NewCell('SUBRAMO',true,$xls_fondoAzul);
if($verVendedor == "on"){				$xls->NewCell('VENDEDOR',true,$xls_fondoAzul); }
if($verConsultor == "on"){				$xls->NewCell('CONSULTOR',true,$xls_fondoAzul); }
if($verDescripcion == "on"){				$xls->NewCell('DESCRIPCION',true,$xls_fondoAzul);	}
if($verDescripcion == "on"){				$xls->NewCell('MODELO',true,$xls_fondoAzul);	}
if($verDescripcion == "on"){				$xls->NewCell('NO SERIE',true,$xls_fondoAzul);	}
				$xls->NewCell('ASEGURADORA',true,$xls_fondoAzul);
				$xls->NewCell('COND. PAGO',true,$xls_fondoAzul);
				$xls->NewCell('CONDUCTO COBRO',true,$xls_fondoAzul);
				$xls->NewCell('RECIBO',true,$xls_fondoAzul);
				$xls->NewCell('INICIO',true,$xls_fondoAzul);
				$xls->NewCell('FIN',true,$xls_fondoAzul);
				$xls->NewCell('FECHA PAGO',true,$xls_fondoAzul);
				$xls->NewCell('FECHA APLIC',true,$xls_fondoAzul);
				$xls->NewCell('IMPORTE PAGO',true,$xls_fondoAzul);
				$xls->NewCell('MONEDA',true,$xls_fondoAzul);
				$xls->NewCell('TC',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA NETA',true,$xls_fondoAzul);
				$xls->NewCell('RECARGO',true,$xls_fondoAzul);
				$xls->NewCell('GASTOS',true,$xls_fondoAzul);
				$xls->NewCell('IVA',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA TOTAL',true,$xls_fondoAzul);
			$xls->CloseRow();

			$sqlPrimaNetaPagada = "
				Select * From
					`primapagada` 
				Where
					(
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
					)
--					And
--					`POLIZA` = '$filtroPoliza'
--					And 
--					`ASEGURADORA` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroAseguradora, '[',0))."%'
					And
					`FECHA_APLICACION` Between '$fechaInicio' And '$fechaFin'
					Order By
						`FECHA_APLICACION` Desc
							  ";
			$resPrimaNetaPagada = DreQueryDB($sqlPrimaNetaPagada);

	$total_PRIMA_NETA = 0;
	$total_RECARGO = 0;
	$total_GASTO = 0;
	$total_IVA = 0;
	$total_PRIMA_TOTAL  = 0;

			while($rowPrimaNetaPagada = mysql_fetch_assoc($resPrimaNetaPagada)){
				//** FECHA_APLICACION
				$FECHA_APLICACIONX = explode('-',$rowPrimaNetaPagada['FECHA_APLICACION']);
				$FECHA_APLICACIONExcel = $FECHA_APLICACIONX[2]."/".$FECHA_APLICACIONX[1]."/".$FECHA_APLICACIONX[0];
				
				//** FECHA_PAGO
				$FECHA_PAGOX = explode('-',$rowPrimaNetaPagada['FECHA_PAGO']);
				$FECHA_PAGOExcel = $FECHA_PAGOX[2]."/".$FECHA_PAGOX[1]."/".$FECHA_PAGOX[0];
				
				//** INICIO
				$INICIOX = explode('-',$rowPrimaNetaPagada['INICIO']);
				$INICIOExcel = $INICIOX[2]."/".$INICIOX[1]."/".$INICIOX[0];

				//** FIN
				$FINX = explode('-',$rowPrimaNetaPagada['FIN']);
				$FINExcel = $FINX[2]."/".$FINX[1]."/".$FINX[0];
				
//** Prima Poliza
		$total_PRIMA_NETA = $rowPrimaNetaPagada['PRIMA_NETA'] + $total_PRIMA_NETA;
		$total_RECARGO = $rowPrimaNetaPagada['RECARGO'] + $total_RECARGO;
		$total_GASTO = $rowPrimaNetaPagada['GASTO'] + $total_GASTO;
		$total_IVA = $rowPrimaNetaPagada['IVA'] + $total_IVA;
		$total_PRIMA_TOTAL = $rowPrimaNetaPagada['PRIMA_TOTAL'] + $total_PRIMA_TOTAL;

				extract($rowPrimaNetaPagada);

			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell($SUCURSAL_NOMBRE,true,$xls_normal); }

				$xls->NewCell($POLIZA,true,$xls_normal);
				$xls->NewCell($ENDOSO,true,$xls_normal);
				$xls->NewCell($CLIENTE_NOMBRE,true,$xls_normal);
if($verGrupo == "on"){	$xls->NewCell(DreNombreGrupo($GRUPO),true,$xls_normal);	}
if($verSubGrupo == "on"){	$xls->NewCell(DreNombreSubGrupo($SUBGRUPO),true,$xls_normal);	}
				$xls->NewCell(DreNombreRamo($RAMO),true,$xls_normal);
				$xls->NewCell(DreNombreSubRamo($SUBRAMO),true,$xls_normal);
if($verVendedor == "on"){				$xls->NewCell($VENDEDOR_NOMBRE,true,$xls_normal); }
if($verConsultor == "on"){				$xls->NewCell($CONSULTOR_NOMBRE,true,$xls_normal); }
if($verDescripcion == "on"){				$xls->NewCell($DESCRIPCION,true,$xls_normal);	}
if($verDescripcion == "on"){				$xls->NewCell($MODELO,true,$xls_normal);	}
if($verDescripcion == "on"){				$xls->NewCell($NO_SERIE,true,$xls_normal);	}
				$xls->NewCell(DreNombreAseguradora($ASEGURADORA),true,$xls_normal);
				$xls->NewCell($CONDICION_PAGO,true,$xls_normal);
				$xls->NewCell($CONDUCTO_COBRO,true,$xls_normal);
				$xls->NewCell($RECIBO,true,$xls_normal);
				$xls->NewCell($INICIOExcel,true,$xls_date);
				$xls->NewCell($FINExcel,true,$xls_date);
				$xls->NewCell($FECHA_PAGOExcel,true,$xls_date);
				$xls->NewCell($FECHA_APLICACIONExcel,true,$xls_date);
				$xls->NewCell("$".number_format($IMPORTE_PAGO,2),true,$xls_normal);
				$xls->NewCell($MONEDA,true,$xls_normal);
				$xls->NewCell("$".number_format($TC,2),true,$xls_normal);

				$xls->NewCell("$".number_format($PRIMA_NETA,2),true,$xls_normal);
				$xls->NewCell("$".number_format($RECARGO,2),true,$xls_normal);
				$xls->NewCell("$".number_format($GASTO,2),true,$xls_normal);
				$xls->NewCell("$".number_format($IVA,2),true,$xls_normal);
				$xls->NewCell("$".number_format($PRIMA_TOTAL,2),true,$xls_normal);
			$xls->CloseRow();
}
			$xls->OpenRow();	
if($verSucursal == "on"){				$xls->NewCell('',true,''); }
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
if($verGrupo == "on"){	$xls->NewCell('',true,'');	}
if($verSubGrupo == "on"){	$xls->NewCell('',true,'');	}
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
if($verVendedor == "on"){				$xls->NewCell('',true,''); }
if($verConsultor == "on"){				$xls->NewCell('',true,''); }
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
if($verDescripcion == "on"){				$xls->NewCell('',true,'');	}
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell("$".number_format($total_PRIMA_NETA,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_RECARGO,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_GASTO,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_IVA,2),true,$xls_normal_negrita);
				$xls->NewCell("$".number_format($total_PRIMA_TOTAL,2),true,$xls_normal_negrita);
			$xls->CloseRow();

	$xls->GetXLS('primaNetaPagada');
/*
	echo "<pre>";
		print_r($_REQUEST);
		echo $sqlPrimaNetaPagada;
	echo "</pre>";
*/
?>