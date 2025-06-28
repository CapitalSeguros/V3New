<?php
	if($idVendedor != ""){$usuarioSql = $idVendedor; } else if($idVendedor == ""){ $usuarioSql = $Usuario; }
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
<?php
	if(in_array('actividades-monitorNube-monitorear-Autos+Individuales', $nodosPermisos)){
?>
<!-- Nube Autos -->
	<tr>
    	<td><div id="contenedor">&nbsp;</div></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="950" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientesAutos" onclick="mostrarOcultarDiv('MisPendientesAutos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Autos
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <a name="MisPendientesAutos" id="MisPendientesAutos"></a>
        <!-- Detalle Nube Autos -->
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="68">Folio</td>
                	<td width="110">Actividad</td>
                	<td width="180">Ramo</td>
                	<td width="80">Fecha<br>Creaci&oacute;n</td>
                	<td width="110">Bloqueo</td>
                	<td width="70">Status</td>
                	<td width="260">Cliente</td>
                </tr>
<?php
	$sqlActividadesMonitorNube = "
		Select
			*
			, `actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades`
		Where
			(
				`actividadInterno` = 'Cotizaci%F3n'
				And
				(
					`ramoInterno` =  'Autos+Individuales'
				)
			)
			And
			(
				`fin` = '0' 
				And 
				`inicio` = '0'
			)
			And
			(
				(
					`prioridad` = '0'
					Or
					`prioridad` = '2'
				)
		--		And
		--		`usuarioBloqueo` = ''
			)
			And
			(
				`usuarioCreacion` != `usuarioBolita`
			)
		Order By
			`actividades`.`fechaActualizacion` Asc
								 ";
	$resActividadesMonitorNube = DreQueryDB($sqlActividadesMonitorNube);
		$contIntLi = "0";
	while($romActividadesMonitorNube = mysql_fetch_assoc($resActividadesMonitorNube)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php DreSemaforoNubeCotizaciones($romActividadesMonitorNube['recId']); ?>
                    	<!-- <a href="<?php //echo "actividadesDetalle.php?recId=".$romActividadesMonitorNube['recId']; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;"> -->
                        <strong><?php echo $romActividadesMonitorNube['recId']; ?></strong>
                        <!-- </a> -->
                        &nbsp;
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesMonitorNube['actividadInterno']);
							if($romActividadesMonitorNube['actividadUrgente']){
							echo "<br>";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php echo urldecode($romActividadesMonitorNube['ramoInterno']); ?>
                    </td>
                	<td>
	                    <?php
							$fecha = date_create($romActividadesMonitorNube['fechaCreacionActividades']);
							echo date_format($fecha, 'd-m-Y');
							echo "<br />";
							echo date_format($fecha, 'H:i:s a');
						?>

                    </td>
                	<td>
						<?php DreBloqueActividad($romActividadesMonitorNube['recId']); ?>
                    </td>
                	<td>
						<?php DreStatusActividadV2($romActividadesMonitorNube['recId']); ?>
                	</td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							if($romActividadesMonitorNube['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesMonitorNube['usuarioCreacion']);
							}
						?>
                    </td>
                </tr>
<?php
		$contIntLi++;
	}
?>
			</table>
        <!-- Detalle Nube Autos -->
        </td>
    </tr>
<!-- Nube Autos -->
<?php
	}
?>	

<?php
	if(in_array('actividades-monitorNube-monitorear-L%EDneas+Personales', $nodosPermisos)){
?>
<!-- Nube LineasPersonales -->
	<tr>
    	<td><div id="contenedor">&nbsp;</div></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="950" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientesLineasPersonales" onclick="mostrarOcultarDiv('MisPendientesLineasPersonales')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion L&iacute;neas Personales
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <a name="MisPendientesLineasPersonales" id="MisPendientesLineasPersonales"></a>
        <!-- Detalle Nube LineasPersonales -->
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="68">Folio</td>
                	<td width="110">Actividad</td>
                	<td width="180">Ramo</td>
                	<td width="80">Fecha<br>Creaci&oacute;n</td>
                	<td width="110">Bloqueo</td>
                	<td width="70">Status</td>
                	<td width="260">Cliente</td>
                </tr>
<?php
	$sqlActividadesMonitorNube = "
		Select
			*
			, `actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades`
		Where
			(
				`actividadInterno` = 'Cotizaci%F3n'
				And
				(
					`ramoInterno` =  'L%EDneas+Personales'
				)
			)
			And
			(
				`fin` = '0' 
				And 
				`inicio` = '0'
			)
			And
			(
				(
					`prioridad` = '0'
					Or
					`prioridad` = '2'
				)
		--		And
		--		`usuarioBloqueo` = ''
			)
			And
			(
				`usuarioCreacion` != `usuarioBolita`
			)
		Order By
			`actividades`.`fechaActualizacion` Asc
								 ";
	$resActividadesMonitorNube = DreQueryDB($sqlActividadesMonitorNube);
		$contIntLi = "0";
	while($romActividadesMonitorNube = mysql_fetch_assoc($resActividadesMonitorNube)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php DreSemaforoNubeCotizaciones($romActividadesMonitorNube['recId']); ?>
                    	<!-- <a href="<?php //echo "actividadesDetalle.php?recId=".$romActividadesMonitorNube['recId']; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;"> -->
                        <strong><?php echo $romActividadesMonitorNube['recId']; ?></strong>
                        <!-- </a> -->
                        &nbsp;
                    </td>
                	<td>
						<?php
							echo urldecode($romActividadesMonitorNube['actividadInterno']); 
							if($romActividadesMonitorNube['actividadUrgente']){
							echo "<br>";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php echo urldecode($romActividadesMonitorNube['ramoInterno']); ?>
                    </td>
                	<td>
	                    <?php
							$fecha = date_create($romActividadesMonitorNube['fechaCreacionActividades']);
							echo date_format($fecha, 'd-m-Y');
							echo "<br />";
							echo date_format($fecha, 'H:i:s a');
						?>

                    </td>
                	<td>
						<?php DreBloqueActividad($romActividadesMonitorNube['recId']); ?>
                    </td>
                	<td>
						<?php DreStatusActividadV2($romActividadesMonitorNube['recId']); ?>
                	</td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							if($romActividadesMonitorNube['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesMonitorNube['usuarioCreacion']);
							}
						?>
                    </td>
                </tr>
<?php
		$contIntLi++;
	}
?>
			</table>
        <!-- Detalle Nube LineasPersonales -->
        </td>
    </tr>
<!-- Nube LineasPersonales -->
<?php
	}
?>

<?php
	if(in_array('actividades-monitorNube-monitorear-Da%F1os', $nodosPermisos)){
?>
<!-- Nube Daños -->
	<tr>
    	<td><div id="contenedor">&nbsp;</div></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="950" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientesDanos" onclick="mostrarOcultarDiv('MisPendientesDanos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Da&ntilde;os
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <a name="MisPendientesDanos" id="MisPendientesDanos"></a>
        <!-- Detalle Nube Danos -->
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="68">Folio</td>
                	<td width="110">Actividad</td>
                	<td width="180">Ramo</td>
                	<td width="80">Fecha<br>Creaci&oacute;n</td>
                	<td width="110">Bloqueo</td>
                	<td width="70">Status</td>
                	<td width="260">Cliente</td>
                </tr>
<?php
	$sqlActividadesMonitorNube = "
		Select
			*
			, `actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades`
		Where
			(
				`actividadInterno` = 'Cotizaci%F3n'
				And
				(
					`ramoInterno` =  'Da%F1os'
				)
			)
			And
			(
				`fin` = '0' 
				And 
				`inicio` = '0'
			)
			And
			(
				(
					`prioridad` = '0'
					Or
					`prioridad` = '2'
				)
		--		And
		--		`usuarioBloqueo` = ''
			)
			And
			(
				`usuarioCreacion` != `usuarioBolita`
			)
		Order By
			`actividades`.`fechaActualizacion` Asc
								 ";
	$resActividadesMonitorNube = DreQueryDB($sqlActividadesMonitorNube);
		$contIntLi = "0";
	while($romActividadesMonitorNube = mysql_fetch_assoc($resActividadesMonitorNube)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php DreSemaforoNubeCotizaciones($romActividadesMonitorNube['recId']); ?>
                    	<!-- <a href="<?php //echo "actividadesDetalle.php?recId=".$romActividadesMonitorNube['recId']; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;"> -->
                        <strong><?php echo $romActividadesMonitorNube['recId']; ?></strong>
                        <!-- </a> -->
                        &nbsp;
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesMonitorNube['actividadInterno']);
							if($romActividadesMonitorNube['actividadUrgente']){
							echo "<br>";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php echo urldecode($romActividadesMonitorNube['ramoInterno']); ?>
                    </td>
                	<td>
	                    <?php
							$fecha = date_create($romActividadesMonitorNube['fechaCreacionActividades']);
							echo date_format($fecha, 'd-m-Y');
							echo "<br />";
							echo date_format($fecha, 'H:i:s a');
						?>

                    </td>
                	<td>
						<?php DreBloqueActividad($romActividadesMonitorNube['recId']); ?>
                    </td>
                	<td>
						<?php DreStatusActividadV2($romActividadesMonitorNube['recId']); ?>
                	</td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							if($romActividadesMonitorNube['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesMonitorNube['usuarioCreacion']);
							}
						?>
                    </td>
                </tr>
<?php
		$contIntLi++;
	}
?>
			</table>
        <!-- Detalle Nube Danos -->
        </td>
    </tr>
<!-- Nube Daños -->
<?php
	}
?>

<?php
	if(in_array('actividades-monitorNube-monitorear-Fianzas', $nodosPermisos)){
?>
<!-- Nube Fianzas -->
	<tr>
    	<td><div id="contenedor">&nbsp;</div></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="950" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientesFianzas" onclick="mostrarOcultarDiv('MisPendientesFianzas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Fianzas
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <a name="MisPendientesFianzas" id="MisPendientesFianzas"></a>
        <!-- Detalle Nube Fianzas -->
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="68">Folio</td>
                	<td width="110">Actividad</td>
                	<td width="180">Ramo</td>
                	<td width="80">Fecha<br>Creaci&oacute;n</td>
                	<td width="110">Bloqueo</td>
                	<td width="70">Status</td>
                	<td width="260">Cliente</td>
                </tr>
<?php
	$sqlActividadesMonitorNube = "
		Select
			*
			, `actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades`
		Where
			(
				`actividadInterno` = 'Cotizaci%F3n'
				And
				(
					`ramoInterno` =  'Fianzas'
				)
			)
			And
			(
				`fin` = '0' 
				And 
				`inicio` = '0'
			)
			And
			(
				(
					`prioridad` = '0'
					Or
					`prioridad` = '2'
				)
		--		And
		--		`usuarioBloqueo` = ''
			)
			And
			(
				`usuarioCreacion` != `usuarioBolita`
			)
		Order By
			`actividades`.`fechaActualizacion` Asc
								 ";
	$resActividadesMonitorNube = DreQueryDB($sqlActividadesMonitorNube);
		$contIntLi = "0";
	while($romActividadesMonitorNube = mysql_fetch_assoc($resActividadesMonitorNube)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php DreSemaforoNubeCotizaciones($romActividadesMonitorNube['recId']); ?>
                    	<!-- <a href="<?php //echo "actividadesDetalle.php?recId=".$romActividadesMonitorNube['recId']; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;"> -->
                        <strong><?php echo $romActividadesMonitorNube['recId']; ?></strong>
                        <!-- </a> -->
                        &nbsp;
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesMonitorNube['actividadInterno']); 
							if($romActividadesMonitorNube['actividadUrgente']){
							echo "<br>";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php echo urldecode($romActividadesMonitorNube['ramoInterno']); ?>
                    </td>
                	<td>
	                    <?php
							$fecha = date_create($romActividadesMonitorNube['fechaCreacionActividades']);
							echo date_format($fecha, 'd-m-Y');
							echo "<br />";
							echo date_format($fecha, 'H:i:s a');
						?>

                    </td>
                	<td>
						<?php DreBloqueActividad($romActividadesMonitorNube['recId']); ?>
                    </td>
                	<td>
						<?php DreStatusActividadV2($romActividadesMonitorNube['recId']); ?>
                	</td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							if($romActividadesMonitorNube['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesMonitorNube['usuarioCreacion']);
							}
						?>
                    </td>
                </tr>
<?php
		$contIntLi++;
	}
?>
			</table>
        <!-- Detalle Nube Fianzas -->
        </td>
    </tr>
<!-- Nube Fianzas -->
<?php
	}
?>

<?php
	if(in_array('actividades-monitorNube-monitorear-Flotillas', $nodosPermisos)){
?>
<!-- Nube Flotillas -->
	<tr>
    	<td><div id="contenedor">&nbsp;</div></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="950" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientesFlotillas" onclick="mostrarOcultarDiv('MisPendientesFlotillas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Flotillas
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
        <a name="MisPendientesFlotillas" id="MisPendientesFlotillas"></a>
        <!-- Detalle Nube Flotillas -->
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="68">Folio</td>
                	<td width="110">Actividad</td>
                	<td width="180">Ramo</td>
                	<td width="80">Fecha<br>Creaci&oacute;n</td>
                	<td width="110">Bloqueo</td>
                	<td width="70">Status</td>
                	<td width="260">Cliente</td>
                </tr>
<?php
	$sqlActividadesMonitorNube = "
		Select
			*
			, `actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades`
		Where
			(
				`actividadInterno` = 'Cotizaci%F3n'
				And
				(
					`ramoInterno` =  'Flotillas'
				)
			)
			And
			(
				`fin` = '0' 
				And 
				`inicio` = '0'
			)
			And
			(
				(
					`prioridad` = '0'
					Or
					`prioridad` = '2'
				)
		--		And
		--		`usuarioBloqueo` = ''
			)
			And
			(
				`usuarioCreacion` != `usuarioBolita`
			)
		Order By
			`actividades`.`fechaActualizacion` Asc
								 ";
	$resActividadesMonitorNube = DreQueryDB($sqlActividadesMonitorNube);
		$contIntLi = "0";
	while($romActividadesMonitorNube = mysql_fetch_assoc($resActividadesMonitorNube)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php DreSemaforoNubeCotizaciones($romActividadesMonitorNube['recId']); ?>
                    	<!-- <a href="<?php //echo "actividadesDetalle.php?recId=".$romActividadesMonitorNube['recId']; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;"> -->
                        <strong><?php echo $romActividadesMonitorNube['recId']; ?></strong>
                        <!-- </a> -->
                        &nbsp;
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesMonitorNube['actividadInterno']);
							if($romActividadesMonitorNube['actividadUrgente']){
							echo "<br>";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php echo urldecode($romActividadesMonitorNube['ramoInterno']); ?>
                    </td>
                	<td>
	                    <?php
							$fecha = date_create($romActividadesMonitorNube['fechaCreacionActividades']);
							echo date_format($fecha, 'd-m-Y');
							echo "<br />";
							echo date_format($fecha, 'H:i:s a');
						?>

                    </td>
                	<td>
						<?php DreBloqueActividad($romActividadesMonitorNube['recId']); ?>
                    </td>
                	<td>
						<?php DreStatusActividadV2($romActividadesMonitorNube['recId']); ?>
                	</td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesMonitorNube['idRef'], $romActividadesMonitorNube['tipo']);
							if($romActividadesMonitorNube['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesMonitorNube['usuarioCreacion']);
							}
						?>
                    </td>
                </tr>
<?php
		$contIntLi++;
	}
?>
			</table>
        <!-- Detalle Nube Flotillas -->
        </td>
    </tr>
<!-- Nube Flotillas -->
<?php
	}
?>
</table>