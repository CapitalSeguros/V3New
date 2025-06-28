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

		$Referencia.= "<p>";
		$Referencia.= "*".$cambia1." => ".$queda1."<br>";
		if(isset($cambia2) && $cambia2 != ""){ $Referencia.= "*".$cambia2." => ".$queda2."<br>"; }
		if(isset($cambia3) && $cambia3 != ""){ $Referencia.= "*".$cambia3." => ".$queda3."<br>"; }
		if(isset($cambia4) && $cambia4 != ""){ $Referencia.= "*".$cambia4." => ".$queda4."<br>"; }
		if(isset($cambia5) && $cambia5 != ""){ $Referencia.= "*".$cambia5." => ".$queda5."<br>"; }
		$Referencia.= "</p>";

			if(
				/*
				$Ramo == "AUTOS+INDIVIDUALES"
				||
				$Ramo == "Autos+Individuales"
				*/
				false
			){
				
				$usuario = "0000028974"; // Variable Calculada
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				
			} else {
				
				$sqlTipoRamo = "
					Select
						`ramosconfigdre`.`nombre` As `ramoTitulo`
						, `usuarios`.`Email` As `ramoEmail`
						, `usuarios`.`VALOR` As `usuario`
					From	 
						`ramosconfigdre` Inner Join `usuario_ramo`
						On
						`ramosconfigdre`.`ramo_id` = `usuario_ramo`.`ramo` Inner Join `usuarios`
						On 	
						`usuario_ramo`.`Usuario` = `usuarios`.`VALOR`
					Where
						`ramosconfigdre`.`nombre` = '".urldecode($Ramo)."'
							   ";
				$resTipoRamo = DreQueryDB($sqlTipoRamo);
				$rowTipoRamo = mysql_fetch_assoc($resTipoRamo);
		
					$ramoTitulo =  $rowTipoRamo['ramoTitulo']; // Variable Calculada
					$ramoEmail = $rowTipoRamo['ramoEmail']; // Variable Calculada
					$usuario = $rowTipoRamo['usuario']; // Variable Calculada
					
					if(!isset($_REQUEST['Responsable']) || $_REQUEST['Responsable']==""){
						$Responsable = $rowTipoRamo['usuario'];
						$usuarioBolita = $Responsable;
					} else {
						$Responsable = $_REQUEST['Responsable'];
						$usuarioBolita = $Responsable;
					}				

			}
		
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