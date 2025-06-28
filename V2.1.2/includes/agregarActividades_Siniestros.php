<?php

//** Complemento para endoso cuando si existe la poliza
	if($idPoliza != "" && $idPoliza != "otra"){
		$sqlConsultamosInfoPoliza = "
			Select * From 
				`cliramos` Inner Join `empresas`
				On
				`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
			Where
				`cliramos`.`POLIZA` Like '%$idPoliza%'
									";
		$resConsultamosInfoPoliza = DreQueryDB($sqlConsultamosInfoPoliza);
		$rowConsultamosInfoPoliza = mysql_fetch_assoc($resConsultamosInfoPoliza);
		
		$Ramo = $ramoInterno = urlencode($rowConsultamosInfoPoliza['RAMO']);			
		$idRef = $rowConsultamosInfoPoliza['CLAVE'];

	}else if($idPoliza == "otra"){
		$idRef = $idCliente;
		$idPoliza = $otraPoliza;
	}


	//** Ojo $Referencia.= "<strong>Referencia de la Poliza:</strong>";
	//** Ojo $Referencia.= $ReferenciaPol;
	//$Referencia.= "<br><br>";

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
						,`poliza`
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