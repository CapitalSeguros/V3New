<?php
		$Referencia.= "<p>";
		$Referencia.= "<strong>Motivo Cancelaci&oacute;n:</strong> ".$motivoCancelacion;
		$Referencia.= "<br>";
		$Referencia.= $Comentario;
		$Referencia.= "</p>";

if(!isset($idRef)){
	if($idCliente != ""){
		$idRef = $idCliente;
	} else if($CLIENTE != ""){
		$idRef = $CLIENTE;
	}
} // Validacion idRef
		$sqlAgregarActividad = "
			Insert Into 
				`actividades`
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
					)
				Values
					(
						'$recId'
						,'$idRef'
						,'CONTACTO1'
						,'0'
						,'0'
						,'$Referencia'
						,'".urldecode($Actividad)."-".urldecode($ramoInterno)."'
						,'$Responsable'
						,'$IDUsuarioCreacion'
						,'$usuarioBolita'
						,'".date('Y-m-d H:i:s')."'
						,'$formatFecha'
						,'$actividadInterno'
						,'$ramoInterno'
						,'$idPoliza'
						,'".$_SESSION['WebDreTacticaWeb2']['Sucursal']."'
						,'".$_SESSION['WebDreTacticaWeb2']['Promotor']."'
					)
							   ";
?>