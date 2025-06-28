<?
			$xls->OpenRow();
				$xls->NewCell('Reporte De Actividades Todas ',false,$xls_encabezado);
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
if($filtroSucursal != ""){
			$xls->OpenRow();
				$xls->NewCell('SUCURSAL:',true,$xls_fondoAzul);
				$xls->NewCell($filtroSucursal,true,$xls_normal);
			$xls->CloseRow();			
}

if($filtroConsultor != ""){
			$xls->OpenRow();
				$xls->NewCell('CONSULTOR:',true,$xls_fondoAzul);
				$xls->NewCell($filtroConsultor,true,$xls_normal);
			$xls->CloseRow();			
}

if($filtroVendedor != ""){
			$xls->OpenRow();
				$xls->NewCell('VENDEDOR:',true,$xls_fondoAzul);
				$xls->NewCell($filtroVendedor,true,$xls_normal);
			$xls->CloseRow();			
}

if($filtroRamo != ""){
			$xls->OpenRow();
				$xls->NewCell('RAMO:',true,$xls_fondoAzul);
				$xls->NewCell($filtroRamo,true,$xls_normal);
			$xls->CloseRow();			
}

if($filtroCliente != ""){
			$xls->OpenRow();
				$xls->NewCell('CLIENTE:',true,$xls_fondoAzul);
				$xls->NewCell($filtroCliente,true,$xls_normal);
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
if($verSucursal == "on"){				$xls->NewCell('SUCURSAL',true,$xls_fondoAzul); }
				$xls->NewCell('URGENTE',true,$xls_fondoAzul);
				$xls->NewCell('FOLIO',true,$xls_fondoAzul);
				$xls->NewCell('CLIENTE',true,$xls_fondoAzul);
				$xls->NewCell('ACTIVIDAD',true,$xls_fondoAzul);
				$xls->NewCell('RAMO',true,$xls_fondoAzul);
				$xls->NewCell('STATUS',true,$xls_fondoAzul);
if($verVendedor == "on"){				$xls->NewCell('USUARIO CREACION',true,$xls_fondoAzul); }
if($verVendedor == "on"){				$xls->NewCell('NOMBRE USUARIO CREACION',true,$xls_fondoAzul); }
if($verConsultor == "on"){				$xls->NewCell('USUARIO CONSULTOR',true,$xls_fondoAzul); }
if($verConsultor == "on"){				$xls->NewCell('NOMBRE USUARIO CONSULTOR',true,$xls_fondoAzul); }
/* */	//				$xls->NewCell('USUARIO COTIZACION',true,$xls_fondoAzul);
				$xls->NewCell('NOMBRE USUARIO COTIZACION',true,$xls_fondoAzul);
				
/* */	//				$xls->NewCell('USUARIO RECOTIZACION',true,$xls_fondoAzul);
				$xls->NewCell('NOMBRE USUARIO RECOTIZACION',true,$xls_fondoAzul);
				
/* */	//				$xls->NewCell('USUARIO RECOTIZACION 2',true,$xls_fondoAzul);
				$xls->NewCell('NOMBRE USUARIO RECOTIZACION 2',true,$xls_fondoAzul);
				
/* */	//				$xls->NewCell('USUARIO RECOTIZACION 3',true,$xls_fondoAzul);
				$xls->NewCell('NOMBRE USUARIO RECOTIZACION 3',true,$xls_fondoAzul);
				
				$xls->NewCell('FECHA CREACION',true,$xls_fondoAzul);
				$xls->NewCell('FECHA TERMINO',true,$xls_fondoAzul);
				$xls->NewCell('FECHA COTIZACION',true,$xls_fondoAzul);
				$xls->NewCell('FECHA RECOTIZACION',true,$xls_fondoAzul);
				$xls->NewCell('FECHA RECOTIZACION 2',true,$xls_fondoAzul);
				$xls->NewCell('FECHA RECOTIZACION 3',true,$xls_fondoAzul);
				$xls->NewCell('FOLIO EMISION',true,$xls_fondoAzul);
			$xls->CloseRow();

			$sqlActividadesTodas = "
				Select 
					`recId` As `Folio`
					, `idRef` As `Cliente`
					, `actividadInterno` As `Actividad`
					, `ramoInterno` As `Ramo`
					, `inicio`
					, `fin`
					, `prioridad`
					, `usuario` As `Responsable`
					, `usuarioCreacion`
					, `usuarioCotizador`
					, `usuarioRecotizador`
					, `usuarioRecotizador2`
					, `usuarioRecotizador3`
					, `fechaCreacion`
					, `fechaTermino`
					, `fechaCotizacion`
					, `fechaRecotizador`
					, `fechaRecotizador2`
					, `fechaRecotizador3`
					, `cotizacionEmision`
					, `poliza`
					, `actividadUrgente` 
					, `fechaProgramada`
				From 
					`actividades`
				Where
					`SUCURSAL` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSucursal, '[',0))."%'
					And
					`CONSULTOR` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroConsultor, '[',0))."%'
					And
					`usuarioCreacion` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroVendedor, '[',0))."%'
					And 
					`RAMO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroRamo, '[',0))."%'
					And 
					`subRamoInterno` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubRamo, '[',0))."%'
					And 
					`idRef` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroCliente, '[',0))."%'
--					And
--					`GRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroGrupo, '[',0))."%'
--					And 
--					`SUBGRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubGrupo, '[',0))."%'
					And
					(
						`inicio` = '0'
					)
					And
					(
						`fechaProgramada` Between '$fechaInicio' AND '$fechaFin'
					)
					And
					(
						`usuarioBolita` = `usuarioCreacion`
					)
					Order By
						`fechaProgramada` Desc
								   ";
			//echo "<pre>".$sqlActividadesTodas."</pre>";
			$resActividadesTodas = DreQueryDB($sqlActividadesTodas);
				
			while($rowActividadesTodas = mysql_fetch_assoc($resActividadesTodas)){
				$fechaCreacionX = explode('-',$rowActividadesTodas['fechaProgramada']);
				$fechaCreacionExcel = $fechaCreacionX[2]."/".$fechaCreacionX[1]."/".$fechaCreacionX[0];
				
				$fechaCreacionX = explode('-',$rowActividadesTodas['fechaProgramada']);
				$fechaCreacionExcel = $fechaCreacionX[2]."/".$fechaCreacionX[1]."/".$fechaCreacionX[0];
				
				$INICIOX = explode('-',$rowActividadesTodas['INICIO']);
				$INICIOExcel = $INICIOX[2]."/".$INICIOX[1]."/".$INICIOX[0];
				
				$FINX = explode('-',$rowActividadesTodas['FIN']);
				$FINExcel = $FINX[2]."/".$FINX[1]."/".$FINX[0];
				
				extract($rowActividadesTodas);

			$xls->OpenRow();
if($verSucursal == "on"){				$xls->NewCell($SUCURSAL,true,$xls_normal); }
				$xls->NewCell(DreUrgenteReporteActividades($actividadUrgente),true,$xls_normal);
				$xls->NewCell($Folio,true,$xls_normal);
				$xls->NewCell(DreNombreCliente($Cliente),true,$xls_normal);
				$xls->NewCell(urldecode($Actividad),true,$xls_normal);
				$xls->NewCell(urldecode($Ramo),true,$xls_normal);
				$xls->NewCell(DrePrioridadReporteActividades($prioridad),true,$xls_normal);
if($verVendedor == "on"){				$xls->NewCell($VENDEDOR_NOMBRE,true,$xls_normal); }
if($verConsultor == "on"){				$xls->NewCell($CONSULTOR_NOMBRE,true,$xls_normal); }
/* */	//				$xls->NewCell($usuarioCotizador,true,$xls_normal);
				$xls->NewCell(DreNombreCliente($usuarioCotizador),true,$xls_normal);
				
/* */	//				$xls->NewCell($usuarioRecotizador,true,$xls_normal);
				$xls->NewCell(DreNombreCliente($usuarioRecotizador),true,$xls_normal);

/* */	//				$xls->NewCell($usuarioRecotizador2,true,$xls_normal);
				$xls->NewCell(DreNombreCliente($usuarioRecotizador2),true,$xls_normal);

/* */	//				$xls->NewCell($usuarioRecotizador3,true,$xls_int);
				$xls->NewCell(DreNombreCliente($usuarioRecotizador3),true,$xls_int);

				$xls->NewCell($fechaCreacionExcel,true,$xls_date);
				$xls->NewCell($PRIMA_TOTAL,true,$xls_date);
				$xls->NewCell($PRIMA_NETA_COMISION,true,$xls_date);
				$xls->NewCell($RECARGO_COMISION,true,$xls_date);
				$xls->NewCell($GASTOS_COMISION,true,$xls_date);
				$xls->NewCell($cotizacionEmision,true,$xls_normal);
				$xls->NewCell($poliza,true,$xls_normal);

			$xls->CloseRow();
}
		$xls->GetXLS('actividadesTodas');
?>