<?
			$xls->OpenRow();
				$xls->NewCell('Reporte De Actividades Todas',false,$xls_encabezado);
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
/*
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
*/
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
				$xls->NewCell('TIEMPO RESPUESTA',true,$xls_fondoAzul); // Semaforo
if($verSucursal == "on"){				$xls->NewCell('SUCURSAL',true,$xls_fondoAzul); }
				$xls->NewCell('URGENTE',true,$xls_fondoAzul);
				$xls->NewCell('FOLIO',true,$xls_fondoAzul);
				$xls->NewCell('CotEmi',true,$xls_fondoAzul);
				$xls->NewCell('POLIZA',true,$xls_fondoAzul);
				$xls->NewCell('CLIENTE',true,$xls_fondoAzul);
				$xls->NewCell('ACTIVIDAD',true,$xls_fondoAzul);
				$xls->NewCell('RAMO',true,$xls_fondoAzul);
				$xls->NewCell('SUBRAMO',true,$xls_fondoAzul);
				$xls->NewCell('STATUS',true,$xls_fondoAzul);

if($verVendedor == "on"){				$xls->NewCell('NOMBRE USUARIO CREACION',true,$xls_fondoAzul); }
if($verConsultor == "on"){				$xls->NewCell('NOMBRE USUARIO CONSULTOR',true,$xls_fondoAzul); }

				$xls->NewCell('NOMBRE USUARIO ENTREGA',true,$xls_fondoAzul); // NOMBRE USUARIO COTIZACION
				$xls->NewCell('NOMBRE USUARIO RE-ENTREGA',true,$xls_fondoAzul); // RECOTIZACION
				$xls->NewCell('NOMBRE USUARIO RE-ENTREGA 2',true,$xls_fondoAzul); // RECOTIZACION 2
				$xls->NewCell('NOMBRE USUARIO RE-ENTREGA 3',true,$xls_fondoAzul); // RECOTIZACION 3
				
				$xls->NewCell('FECHA CREACION',true,$xls_fondoAzul);
				$xls->NewCell('FECHA TERMINO',true,$xls_fondoAzul);
				$xls->NewCell('FECHA ENTREGA',true,$xls_fondoAzul); // FECHA COTIZACION
/*				$xls->NewCell('FECHA EMISION',true,$xls_fondoAzul);		*/
/*				$xls->NewCell('FECHA ENDOSO',true,$xls_fondoAzul);		*/
/*				$xls->NewCell('FECHA CANCELACION',true,$xls_fondoAzul);	*/
				
				$xls->NewCell('FECHA RE-ENTREGA',true,$xls_fondoAzul); // FECHA RECOTIZACION
				$xls->NewCell('FECHA RE-ENTREGA 2',true,$xls_fondoAzul); // RECOTIZACION 2
				$xls->NewCell('FECHA RE-ENTREGA 3',true,$xls_fondoAzul); // RECOTIZACION 3
			$xls->CloseRow();

			$sqlActividadesTodas = "
				Select 
					`recId` As `Folio`
					, `idRef` As `Cliente`
					, `actividadInterno` As `Actividad`
					, `ramoInterno` As `Ramo`
					, `subRamoInterno` As `SubRamo`
					, `inicio`
					, `fin`
					, `prioridad`
					, `SUCURSAL`
					, `usuario` As `Responsable`
					, `CONSULTOR`
					
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
					, `fechaEmite`
					, `fechaEndosa`
					, `fechaCancela`
					, `fechaAclara`
					
					, `cotizacionEmision`
					, `poliza`
					, `actividadUrgente` 
					, `fechaProgramada`
/*
					, TIMESTAMPDIFF(Minute,`fechaCreacion`, `fechaCotizacion`) As `tiempoCotizada`
					, TIMESTAMPDIFF(Minute,`fechaCreacion`, `fechaEmite`) As `tiempoEmitida`
					
					, TIMESTAMPDIFF(Minute,`fechaCreacion`, `fechaEndosa`) As `tiempoEndosa`
					, TIMESTAMPDIFF(Minute,`fechaCreacion`, `fechaCancela`) As `tiempoCancela`
					, TIMESTAMPDIFF(Minute,`fechaCreacion`, `fechaAclara`) As `tiempoAclara`
					
					, DATE_FORMAT(`fechaProgramada`, '%d/%m/%Y') As `fechaCreacionExcel`
					, DATE_FORMAT(`fechaTermino`, '%d/%m/%Y') As `fechaTerminoExcel`
					, DATE_FORMAT(`fechaCotizacion`, '%d/%m/%Y') As `fechaCotizacionExcel`
					, DATE_FORMAT(`fechaRecotizador`, '%d/%m/%Y') As `fechaRecotizacionExcel`
					, DATE_FORMAT(`fechaRecotizador2`, '%d/%m/%Y') As `fechaRecotizacion2Excel`
					, DATE_FORMAT(`fechaRecotizador3`, '%d/%m/%Y') As `fechaRecotizacion3Excel`
*/					
					, DATE_FORMAT(`INICIO`, '%d/%m/%Y') As `INICIOExcel`
					, DATE_FORMAT(`FIN`, '%d/%m/%Y') As `FINExcel`
					
					, if(
							`actividadInterno` = 'Cotizaci%F3n' And `cotizacionEmision` != ''
							, Concat('Emi: ',`cotizacionEmision`) 
							, if(
									`actividadInterno` = 'Emisi%F3n' And `cotizacionEmision` != ''
									,Concat('Cot: ',`cotizacionEmision`)
									,''
								)
						)
					 As `CotEmi`
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
/*
					And
					`GRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroGrupo, '[',0))."%'
*/
/*
					And 
					`SUBGRUPO` Like '%".str_replace($quitarCosas, $ponerCosas, strstr($filtroSubGrupo, '[',0))."%'
*/
					And
					(
						`inicio` = '0'
					)
					And
					(
						`fechaProgramada` Between '$fechaInicio' AND '$fechaFin'
					)
					Order By
						`fechaProgramada` Desc
								   ";
			$resActividadesTodas = DreQueryDB($sqlActividadesTodas);
			while($rowActividadesTodas = mysql_fetch_assoc($resActividadesTodas)){
			extract($rowActividadesTodas);					
			switch($Actividad){
				case "Cotizaci%F3n":
					$nombreEntrega = nombreUsuario($usuarioCotizador);
					$fechaEntrega = ($fechaCotizacion!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaCotizacion)) : '';
				break;
				
				case "Emisi%F3n":
					$nombreEntrega = nombreUsuario($usuarioCotizador);
					$fechaEntrega = ($fechaEmite!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaEmite)) : '';
				break;
				
				case "Endoso";
					$fechaEntrega = ($fechaEndosa!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaEndosa)) : ''; //**
				break;
				
				case "Cancelacion":
					$fechaEntrega = ($fechaCancela!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaCancela)) : '';
				break;
				
				case "Aclaraci%F3n+de+Comisiones";
					$fechaEntrega = ($fechaAclara!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaAclara)) : ''; //**
				break;
				
				case "Otras+Actividades";
					$fechaEntrega = "";
				break;
				
				default:
					$fechaEntrega = $Actividad;
				break;
			}
			$xls->OpenRow();
				$xls->NewCell(DreTiempoRespuesta($Folio), true, DreSemaforoRespuesta($Folio)); // Semaforo
if($verSucursal == "on"){				$xls->NewCell(DreNombreSucursalV2($SUCURSAL),true,$xls_normal); } //DreNombreSucursalV2
				$xls->NewCell(DreUrgenteReporteActividades($actividadUrgente),true,$xls_normal);
				$xls->NewCell($Folio,true,$xls_normal);
				
				$xls->NewCell($CotEmi,true,$xls_normal);
				$xls->NewCell($poliza,true,$xls_normal);
				
				$xls->NewCell(DreNombreCliente($Cliente),true,$xls_normal);
				$xls->NewCell(urldecode($Actividad),true,$xls_normal);
				$xls->NewCell(urldecode($Ramo),true,$xls_normal);
				$xls->NewCell(urldecode($SubRamo),true,$xls_normal);
				$xls->NewCell(DrePrioridadReporteActividades($prioridad),true,$xls_normal);

if($verVendedor == "on"){				$xls->NewCell(nombreUsuario($usuarioCreacion),true,$xls_normal); }
if($verConsultor == "on"){				$xls->NewCell(nombreUsuario($CONSULTOR),true,$xls_normal); }

				$xls->NewCell($nombreEntrega,true,$xls_normal);
				$xls->NewCell(nombreUsuario($usuarioRecotizador),true,$xls_normal);
				$xls->NewCell(nombreUsuario($usuarioRecotizador2),true,$xls_normal);
				$xls->NewCell(nombreUsuario($usuarioRecotizador3),true,$xls_int);

				$xls->NewCell(date('d-m-Y H:i', strtotime($fechaCreacion)),true,$xls_normal);

				$xls->NewCell(($fechaTermino!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaTermino)) : '',true,$xls_normal);
				$xls->NewCell($fechaEntrega,true,$xls_normal);
/*				$xls->NewCell(($fechaEmite!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaEmite)) : '',true,$xls_normal);	*/
/*				$xls->NewCell(($fechaCancela!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaCancela)) : '',true,$xls_normal);	*/
				$xls->NewCell(($fechaRecotizador!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaRecotizador)) : '',true,$xls_normal);
				$xls->NewCell(($fechaRecotizador2!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaRecotizador2)) : '',true,$xls_normal);	
				$xls->NewCell(($fechaRecotizador3!="0000-00-00 00:00:00")? date('d-m-Y H:i', strtotime($fechaRecotizador3)) : '',true,$xls_normal);
				
## $xls_semaforoRojo;
## $xls_semaforoAmarillo;
## $xls_semaforoVerde;
## $xls_semaforoBlanco;


			$xls->CloseRow();
}
		$xls->GetXLS('actividadesTodas');
//** echo "<pre>".$sqlActividadesTodas."</pre>";
?>