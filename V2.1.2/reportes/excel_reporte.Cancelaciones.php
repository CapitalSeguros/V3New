<?
			$xls->OpenRow();
				$xls->NewCell('Reporte De Cancelaciones',false,$xls_encabezado);
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

			$xls->OpenRow();	
			$xls->CloseRow();

			$xls->OpenRow();	
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
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,'');
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('RECIBO',false,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('COMISION',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
				$xls->NewCell('',true,$xls_fondoAzulConcatenado);
			$xls->CloseRow();
	
			$xls->OpenRow();
				$xls->NewCell('SUCURSAL',true,$xls_fondoAzul);
				$xls->NewCell('TIPO',true,$xls_fondoAzul);
				$xls->NewCell('FECHA CAPTURA',true,$xls_fondoAzul);
				$xls->NewCell('FECHA CANCELACION',true,$xls_fondoAzul);
				$xls->NewCell('POLIZA',true,$xls_fondoAzul);
				$xls->NewCell('ENDOSO',true,$xls_fondoAzul);
				$xls->NewCell('RAMO',true,$xls_fondoAzul);
				$xls->NewCell('MOTIVO CANCELACION',true,$xls_fondoAzul);
				$xls->NewCell('DESCRIPCION',true,$xls_fondoAzul);
				$xls->NewCell('MODELO',true,$xls_fondoAzul);
				$xls->NewCell('NO SERIE',true,$xls_fondoAzul);
				$xls->NewCell('VENDEDOR',true,$xls_fondoAzul);
				$xls->NewCell('PROMOTOR',true,$xls_fondoAzul);
				$xls->NewCell('ASEGURADORA',true,$xls_fondoAzul);
				$xls->NewCell('GRUPO',true,$xls_fondoAzul);
				$xls->NewCell('SUBGRUPO',true,$xls_fondoAzul);
				$xls->NewCell('CLIENTE',true,$xls_fondoAzul);
				$xls->NewCell('PERSONA (F/M)',true,$xls_fondoAzul);
				$xls->NewCell('COND. PAGO',true,$xls_fondoAzul);
				$xls->NewCell('COND. COBRO',true,$xls_fondoAzul);
				$xls->NewCell('INICIO',true,$xls_fondoAzul);
				$xls->NewCell('FIN',true,$xls_fondoAzul);
				$xls->NewCell('PAGADO',true,$xls_fondoAzul);
				$xls->NewCell('MONEDA',true,$xls_fondoAzul);
				$xls->NewCell('TC',true,$xls_fondoAzul);
				$xls->NewCell('CAMBIO CONDUCTO',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA NETA',true,$xls_fondoAzul);
				$xls->NewCell('RECARGO',true,$xls_fondoAzul);
				$xls->NewCell('GASTOS',true,$xls_fondoAzul);
				$xls->NewCell('IVA',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA TOTAL',true,$xls_fondoAzul);
				$xls->NewCell('%',true,$xls_fondoAzul);
				$xls->NewCell('PRIMA NETA',true,$xls_fondoAzul);
				$xls->NewCell('RECARGO',true,$xls_fondoAzul);
				$xls->NewCell('GASTOS',true,$xls_fondoAzul);
				$xls->NewCell('TOTAL',true,$xls_fondoAzul);
				$xls->NewCell('%',true,$xls_fondoAzul);
				$xls->NewCell('IMPORTE',true,$xls_fondoAzul);
				$xls->NewCell('PRODUCTO',true,$xls_fondoAzul);
			$xls->CloseRow();

			$sqlComisionesPenLiq = "
				Select * From
					`cancelaciones` 
				Where
					`SUCURSAL` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSucursal, '[',0))."%'
					And
					`CONSULTOR` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroConsultor, '[',0))."%'
					And
					`VENDEDOR` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroVendedor, '[',0))."%'
					And 
					`ASEGURADORA` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroAseguradora, '[',0))."%'
					And 
					`RAMO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroRamo, '[',1))."%'
					And 
					`SUBRAMO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubRamo, '[',1))."%'
					And 
					`CLIENTE` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroCliente, '[',0))."%'
					And
					`GRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroGrupo, '[',1))."%'
					And 
					`SUBGRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubGrupo, '[',1))."%'
							  ";
			echo "<pre>".$sqlComisionesPenLiq."</pre>";
			$resComisionesPenLiq = DreQueryDB($sqlComisionesPenLiq);
			while($rowComisionesPenLiq = mysql_fetch_assoc($resComisionesPenLiq)){
				$FECHA_PAGOX = explode('-',$rowComisionesPenLiq['FECHA_PAGO']);
				$FECHA_PAGOExcel = $FECHA_PAGOX[2]."/".$FECHA_PAGOX[1]."/".$FECHA_PAGOX[0];
				
				$INICIOX = explode('-',$rowComisionesPenLiq['INICIO']);
				$INICIOExcel = $INICIOX[2]."/".$INICIOX[1]."/".$INICIOX[0];
				
				$FINX = explode('-',$rowComisionesPenLiq['FIN']);
				$FINExcel = $FINX[2]."/".$FINX[1]."/".$FINX[0];
				
				extract($rowComisionesPenLiq);

			$xls->OpenRow();
				$xls->NewCell($SUCURSAL_NOMBRE,true,$xls_normal);
				$xls->NewCell($POLIZA,true,$xls_normal);
				$xls->NewCell($ENDOSO,true,$xls_normal);
				$xls->NewCell($CLIENTE_NOMBRE,true,$xls_normal);
				$xls->NewCell(DreNombreRamo($RAMO),true,$xls_normal);
				$xls->NewCell(DreNombreSubRamo($SUBRAMO),true,$xls_normal);
				$xls->NewCell($VENDEDOR_NOMBRE,true,$xls_normal);
				$xls->NewCell($CONSULTOR_NOMBRE,true,$xls_normal);
				$xls->NewCell(DreNombreAseguradora($ASEGURADORA),true,$xls_normal);
				$xls->NewCell($RECIBO,true,$xls_int);
				$xls->NewCell($INICIOExcel,true,$xls_normal);
				$xls->NewCell($FINExcel,true,$xls_normal);
				$xls->NewCell($FECHA_PAGOExcel,true,$xls_date);
				$xls->NewCell($PRIMA_NETA,true,$xls_int);
				$xls->NewCell($RECARGO,true,$xls_int);
				$xls->NewCell($GASTOS,true,$xls_int);
				$xls->NewCell($IVA,true,$xls_int);
				$xls->NewCell($PRIMA_TOTAL,true,$xls_int);
				$xls->NewCell($PRIMA_NETA_COMISION,true,$xls_int);
				$xls->NewCell($RECARGO_COMISION,true,$xls_int);
				$xls->NewCell($GASTOS_COMISION,true,$xls_int);
				$xls->NewCell($TOTAL_COMISION,true,$xls_int);
				$xls->NewCell('',true,$xls_int);
				$xls->NewCell($PCTJE_DISPERSION_VEND,true,$xls_int);
				$xls->NewCell($IMPORTE_VEND,true,$xls_int);
			$xls->CloseRow();
}
	$xls->GetXLS('cancelaciones');
?>