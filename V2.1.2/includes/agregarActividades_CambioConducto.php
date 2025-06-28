<?php
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
						,'".$_SESSION['WebDreTacticaWeb2']['Sucursal']."'
						,'".$_SESSION['WebDreTacticaWeb2']['Promotor']."'
					)
							   ";
	$arrayFile[] = $_FILES['cambioConductoCaratula']['tmp_name'];
	$arrayFile[] = $_FILES['cambioConductoIfe']['tmp_name'];
	$arrayFile[] = $_FILES['cambioConductoFormato']['tmp_name'];
	
	foreach($arrayFile as $file){
	}	
?>