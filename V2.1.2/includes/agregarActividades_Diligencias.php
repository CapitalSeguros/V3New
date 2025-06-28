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
						,`SUCURSAL`
						,`CONSULTOR`
					)
				Values
					(
						'$recId'
						,'$idRef'
						,'$tipoContacto'
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
						,'$SubRamo'
						,'".$_SESSION['WebDreTacticaWeb2']['Sucursal']."'
						,'".$_SESSION['WebDreTacticaWeb2']['Promotor']."'
					)
								   ";
//** echo "<pre>";
	//** print_r($_REQUEST);
	//** echo "<br>";
	//** echo $sqlAgregarActividad;
	
	//echo $sqlInfoUsuarioCreacion;
	//echo "<br>";
	//echo $sqlInfoUsuarioResponsable;
	//echo "<br>";
//** echo "</pre>";
?>