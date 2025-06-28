<?php
$POLIZA = $idPoliza;

if($idCliente != ""){
	$idRef = $idCliente;
}
			$sqlAgregarActividad = "
				Insert Into `actividades`
					(		
						`recId`
						,`idRef`
						,`tipo`
						,`inicio`
						,`fin`
						,`referencia`
						,`actividad`
						,`usuario`
						,`usuarioCreacion`
						,`usuarioBolita`
						,`fechaCreacion`
						,`fechaProgramada`
						,`actividadInterno`
						,`ramoInterno`
						,`POLIZA`
						,`SUCURSAL`
						,`CONSULTOR`
						
						,`fechaPago`
						,`importePago`
						,`moneda`
						,`tipoCambio`
					)
				Values
					(
						'$recId'
						,'$idRef'
						,'$TIPO'
						,'0'
						,'0'
						,'$Referencia'
						,'".urldecode($Actividad)."'
						,'$Responsable'
						,'$IDUsuarioCreacion'
						,'$usuarioBolita'
						,'".date('Y-m-d H:i:s')."'
						,'$formatFecha'
						,'$actividadInterno'
						,'$ramoInterno'
						,'$POLIZA'
						,'".$_SESSION['WebDreTacticaWeb2']['Sucursal']."'
						,'".$_SESSION['WebDreTacticaWeb2']['Promotor']."'

						,'".$fechaPago."'
						,'".str_replace(',','',$importePago)."'
						,'".$moneda."'
						,'".$tipoCambio."'
					)
								   ";	
?>