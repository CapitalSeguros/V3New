<?php
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
				,`subRamoInterno`
				,`actividadUrgente`
						,`SUCURSAL`
						,`CONSULTOR`
			)
			Values
			(
				'$recId'
				,'$idRef'
				,'$TIPO'
				,'0'
				,'0'
				,'$Referencia'
				,'".urldecode($Actividad)." - $ramoTitulo'
				,'$Responsable'
				,'$IDUsuarioCreacion'
				,'$usuarioBolita'
				,'".date('Y-m-d H:i:s')."'
				,'$formatFecha'
				,'$actividadInterno'
				,'$ramoInterno'
				,'$SubRamo'
				,'$actividadUrgente'
						,'".$_SESSION['WebDreTacticaWeb2']['Sucursal']."'
						,'".$_SESSION['WebDreTacticaWeb2']['Promotor']."'
			);
						   ";
?>