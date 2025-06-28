<script>
	function enviarActividadFolio(recId){
		var error= "";
		if(recId != ""){
			window.open('actividadesDetalle.php?recId='+recId,'_self');
		} else {
			alert('Escriba un Folio !!!');
		}
	}
	function PopPupMonitor(ramoCotizador){
		window.open('monitorCotizadores.php','_blank');
	}
</script>
<?php

if($idVendedor != ""){$usuarioSql = $idVendedor; } else if($idVendedor == ""){ $usuarioSql = $Usuario; }
	$sqlActividadesContactos = 	"
		Select 
			* 
			,`actividades`.`fechaCreacion` As `fechaCreacionActividades`
		From 
			`actividades` 
		Where
			(
				(
					`usuario` = '$usuarioSql' 
					Or 
					`usuarioCreacion` = '$usuarioSql'
					Or
					`usuarioBloqueo` = '$usuarioSql'
				)
				And
				(`inicio` = '0' And `usuarioBolita` = '$usuarioSql')
			)
			And
			`actividades`.`fin` = '0'
		Order By
			`actividades`.`fechaActualizacion` Desc
		Limit 0,2000
							";
$resActividadesContactos = DreQueryDB($sqlActividadesContactos);

$sqlActividadesContactosTrabajando = 	"
	Select 
		* 
		,`actividades`.`fechaCreacion` As `fechaCreacionActividades`
	From 
		`actividades`
	Where
		(
			(`actividades`.`usuario` = '$usuarioSql' Or `actividades`.`usuarioCreacion` = '$usuarioSql')
			And
			(`actividades`.`inicio` = '0' And `actividades`. `usuarioBolita` != '$usuarioSql')
		)
		And
		`actividades`.`usuarioBolita` != `actividades`.`usuarioCreacion`
		And
		`fin` = '0'
	Order By
		`actividades`.`fechaActualizacion` Desc 
	Limit 0,2000
										";
$resActividadesContactosTrabajando = DreQueryDB($sqlActividadesContactosTrabajando);

$sqlSubordinados = "
		Select
			`usuario_usuarios`.`Usuario`
			,`usuario_usuarios`.`UsuarioValor`
			,`usuarios`.`NOMBRE`
			,`usuarios`.`VALOR`
		From 
				`usuario_usuarios`  Inner Join `usuarios` 
			On 
				`usuario_usuarios`.`UsuarioValor` = `usuarios`.`CLAVE`
		Where `usuario_usuarios`.`Usuario` = '$Usuario'
		Limit 0,2000
					 ";
$resSubordinados = DreQueryDB($sqlSubordinados);
$tieneSubordinados = mysql_num_rows($resSubordinados);

$sqlValidacionEsUsuarioCotizadorAutos = "
	Select 
		* 
		, Count(*) As `existeUsuarioCotizador`
		, `usuarios`.`VALOR` As `usuarioCotiza`
	From
		`usuario_usuarios` Inner Join `usuarios`
		On
		`usuario_usuarios`.`UsuarioValor` = `usuarios`.`valor`
	Where
		(
			`usuarios`.`EDIRECTA` = '1'
		)
		And
		(
			`usuarios`.`VALOR` = '".$Usuario."'
		)
		Limit 0,2000
										";
$resValidacionEsUsuarioCotizadorAutos = DreQueryDB($sqlValidacionEsUsuarioCotizadorAutos);
$rowValidacionEsUsuarioCotizadorAutos = mysql_fetch_assoc($resValidacionEsUsuarioCotizadorAutos);

if($rowValidacionEsUsuarioCotizadorAutos['existeUsuarioCotizador'] > 0){ 
	$usuarioCotiza = $rowValidacionEsUsuarioCotizadorAutos['usuarioCotiza']; 
	$_SESSION['WebDreTacticaWeb2']['usuarioCotiza'] = $rowValidacionEsUsuarioCotizadorAutos['usuarioCotiza'];
} else { 
	$usuarioCotiza = FALSE;
	$_SESSION['WebDreTacticaWeb2']['usuarioCotiza'] = "";
}

/**  **/
if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Autos+Individuales', $nodosPermisos)){

	$ramoNubeCotizaciones = 'Autos+Individuales'; 

	$sqlActividadesContactosNube_AutosIndividuales = "
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
				`ramoInterno` =  '".$ramoNubeCotizaciones."'
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
			And
			`usuarioBloqueo` = ''
		)
		And
		(
			`usuario` = `usuarioBolita`
		)
	Order By
		`actividades`.`fechaActualizacion` Asc
		Limit 0,2000
													 ";
	$resActividadesContactosNube_AutosIndividuales = DreQueryDB($sqlActividadesContactosNube_AutosIndividuales);

}

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-L%EDneas+Personales', $nodosPermisos)){
	
	$ramoNubeCotizaciones = 'L%EDneas+Personales'; 

	$sqlActividadesContactosNube_LineasPersonales = "
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
				`ramoInterno` =  '".$ramoNubeCotizaciones."'
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
			And
			`usuarioBloqueo` = ''
		)
		And
		(
			`usuario` = `usuarioBolita`
		)
	Order By
		`actividades`.`fechaActualizacion` Asc
		Limit 0,2000
													";
	$resActividadesContactosNube_LineasPersonales = DreQueryDB($sqlActividadesContactosNube_LineasPersonales);

}

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Da%F1os', $nodosPermisos)){
	
	$ramoNubeCotizaciones = 'Da%F1os';
	
	$sqlActividadesContactosNube_Danos = "
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
				`ramoInterno` =  '".$ramoNubeCotizaciones."'
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
			And
			`usuarioBloqueo` = ''
		)
		And
		(
			`usuario` = `usuarioBolita`
		)
	Order By
		`actividades`.`fechaActualizacion` Asc
		Limit 0,2000
													";
	$resActividadesContactosNube_Danos = DreQueryDB($sqlActividadesContactosNube_Danos);
}

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Fianzas', $nodosPermisos)){

	$ramoNubeCotizaciones = 'Fianzas';
	
	$sqlActividadesContactosNube_Fianzas = "
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
				`ramoInterno` =  '".$ramoNubeCotizaciones."'
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
			And
			`usuarioBloqueo` = ''
		)
		And
		(
			`usuario` = `usuarioBolita`
		)
	Order By
		`actividades`.`fechaActualizacion` Asc
		Limit 0,2000
										   ";
	$resActividadesContactosNube_Fianzas = DreQueryDB($sqlActividadesContactosNube_Fianzas);
}

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Flotillas', $nodosPermisos)){

	$ramoNubeCotizaciones = 'Flotillas'; 
	
	$sqlActividadesContactosNube_Flotillas = "
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
				`ramoInterno` =  '".$ramoNubeCotizaciones."'
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
			And
			`usuarioBloqueo` = ''
		)
		And
		(
			`usuario` = `usuarioBolita`
		)
	Order By
		`actividades`.`fechaActualizacion` Asc
		Limit 0,2000
											 ";
	$resActividadesContactosNube_Flotillas = DreQueryDB($sqlActividadesContactosNube_Flotillas);
}
/** **/

//	echo "<pre>";
	//	print_r($nodosPermisos);
	//	echo $sqlActividadesContactosNube_AutosIndividuales;
//	echo "</pre>";
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr>
    	<td width="100">
        	<form name="formCrearActividad" id="formCrearActividad" method="post" action="actividadesAgregar.php">
            	<input type="submit" name="button" id="button" value="Crear Actividad"  title="Crear Actividad">
			</form>
        </td>
		<td width="850" align="right">
        <?php
			if(
				DrePermisoUsuario('actividades-monitorNube-monitorear-Autos+Individuales', $nodosPermisos)
				||
				DrePermisoUsuario('actividades-monitorNube-monitorear-Da%F1os', $nodosPermisos)
				||
				DrePermisoUsuario('actividades-monitorNube-monitorear-Fianzas', $nodosPermisos)
				||
				DrePermisoUsuario('actividades-monitorNube-monitorear-Flotillas', $nodosPermisos)
				||
				DrePermisoUsuario('actividades-monitorNube-monitorear-L%EDneas+Personales', $nodosPermisos)
			){
		?>
        	<input type="button" name="" id="" value="Monitor Nube" class="buttonGeneral" title="Monitor Nube" onClick="JavaScript: PopPupMonitor('Autos');" />
		<?php
			}
		?>
			<form name="formActividadFolio" id="formActividadFolio" method="get" action="JavaScript: enviarActividadFolio(recId.value)" >
        		<input type="text" name="recId" id="recId" style="width:27%" value="<?php echo (isset($_REQUEST['recId']))? $_REQUEST['recId']:""; ?>" />
            	<input type="submit" value="Buscar Folio" title="Buscar Actividad"/>
			</form>
        </td>
	</tr>
<!-- -->
<?php
if($tieneSubordinados > 0){
?>
	<tr>
    	<td colspan="2">
			<form name="formSelectVendedor" id="formSelectVendedor" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<select name="idVendedor" id="idVendedor" onchange="document.formSelectVendedor.submit()" style="width:100%;">
                	<option value="">-- Seleccione Subordinado --</option>
                    <?php
						while($rowSubordinados = mysql_fetch_assoc($resSubordinados)){
					?>
                    <option value="<?php echo $rowSubordinados['UsuarioValor']; ?>" <?php echo ($rowSubordinados['UsuarioValor']==$idVendedor)? "selected" : ""; ?>>
						<?php echo $rowSubordinados['NOMBRE']; ?>
                    </option>
                    <?php
						}
					?>
				</select>
			</form>
        </td>
    </tr>
<?php
}
?>
<!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#MisPendientes" onclick="mostrarOcultarDiv('MisPendientes')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Mis Pendientes
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#MisPendientes" onclick="mostrarOcultarDiv('MisPendientes')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="MisPendientes" <?php echo ($muestra == "MisPendientes")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="MisPendientes" id="MisPendientes"></a>
        <!-- Mis Pendientes -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="345">Cliente</td>
                	<td width="70">Acciones</td>
                </tr>
<?php
$contIntLi = "0";
	while($romActividadesContactos = mysql_fetch_assoc($resActividadesContactos)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($romActividadesContactos['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($romActividadesContactos['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$romActividadesContactos['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $romActividadesContactos['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($romActividadesContactos['fechaCreacionActividades']);
						$fechaActualizacion = date_create($romActividadesContactos['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesContactos['actividadInterno']); 
							if($romActividadesContactos['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td>
						<?php 
							echo urldecode($romActividadesContactos['ramoInterno']);
							echo "<br>";
							echo ($romActividadesContactos['subRamoInterno'] != "")? 
									'<font style="font-size:6px; font-weight:bold; font-stretch:condensed;">['.urldecode($romActividadesContactos['subRamoInterno']).']</font>'
									: 
									'';
						?>
                    </td>
                	<td><?php DreStatusActividadV2($romActividadesContactos['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($romActividadesContactos['idRef'], $romActividadesContactos['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($romActividadesContactos['idRef'], $romActividadesContactos['tipo']);
							if($romActividadesContactos['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($romActividadesContactos['usuarioCreacion']);
							}
						?>
					</td>
                	<td align="center">
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$romActividadesContactos['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<img src="img/transparente.fw.png" class="system editar" alt="editar" title="Editar Actividad" border="0"/>
                        </a>
                    	<a href="<?php echo "includes/guardar.php?tipoGuardar=quitarActividad&recId=".$romActividadesContactos['recId']; ?>" style="text-decoration:none; color:#000;" >
							<img src="img/transparente.fw.png" class="system quitar" alt="quitar" title="Terminar Actividad" border="0"/>
                        </a>
                    	<a href="<?php echo "actividadesTerminar.php?recId=".$romActividadesContactos['recId']; ?>" style="text-decoration:none; color:#000;" >
							<img src="img/transparente.fw.png" class="system recotizar" alt="recotizar" title="Recotizar Acividad" border="0"/>
                        </a>
                    </td>
                </tr>
<?php
	$contIntLi++;
	}
?>
			</table>
        <!-- Mis Pendientes -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#TrabajandoAgenteCapital" onclick="mostrarOcultarDiv('TrabajandoAgenteCapital')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Trabajando en Agente Capital
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#TrabajandoAgenteCapital" onclick="mostrarOcultarDiv('TrabajandoAgenteCapital')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
	<tr>
		<td colspan="2">
       	<div id="TrabajandoAgenteCapital" <?php echo ($muestra == "TrabajandoAgenteCapital")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="TrabajandoAgenteCapital" id="TrabajandoAgenteCapital"></a>
        <!-- Trabajando -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="345">Cliente</td>
                	<td width="70">Acciones</td>
                </tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosTrabajando = mysql_fetch_assoc($resActividadesContactosTrabajando)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosTrabajando['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosTrabajando['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosTrabajando['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosTrabajando['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosTrabajando['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosTrabajando['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosTrabajando['actividadInterno']);
							if($rowActividadesContactosTrabajando['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosTrabajando['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosTrabajando['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosTrabajando['idRef'], $rowActividadesContactosTrabajando['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosTrabajando['idRef'], $rowActividadesContactosTrabajando['tipo']);
							if($rowActividadesContactosTrabajando['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosTrabajando['usuarioCreacion']);
							}
						?>
					</td>
                	<td align="center">
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosTrabajando['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<img src="img/transparente.fw.png" class="system editar" alt="editar" title="Editar Actividad" border="0"/>
                        </a>
                    	<a href="<?php echo "includes/guardar.php?tipoGuardar=quitarActividad&recId=".$rowActividadesContactosTrabajando['recId']; ?>" style="text-decoration:none; color:#000;" >
							<img src="img/transparente.fw.png" class="system quitar" alt="quitar" title="Terminar Actividad" border="0"/>
                        </a>
                    	<a href="<?php echo "actividadesTerminar.php?recId=".$rowActividadesContactosTrabajando['recId']; ?>" style="text-decoration:none; color:#000;" >
							<img src="img/transparente.fw.png" class="system recotizar" alt="recotizar" title="Recotizar Acividad" border="0"/>
                        </a>
                    </td>
                </tr>
<?php
	$contIntLi++;
	}
?>
			</table>
        <!-- Trabajando -->
        </div>
        </td>
    </tr>
<?php
//echo "<pre>";
	//echo "&bull;";
	//print_r($_SESSION);
//echo "</pre>";
if(isset($usuarioCotiza) && $usuarioCotiza != ""){

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Autos+Individuales', $nodosPermisos)){
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#NubeCotizacion_AutosIndividuales" onclick="mostrarOcultarDiv('NubeCotizacion_AutosIndividuales')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Autos Individuales
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#NubeCotizacion_AutosIndividuales" onclick="mostrarOcultarDiv('NubeCotizacion_AutosIndividuales')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="NubeCotizacion_AutosIndividuales" <?php echo ($muestra == "NubeCotizacion_AutosIndividuales")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="NubeCotizacion_AutosIndividuales" id="NubeCotizacion_AutosIndividuales"></a>
        <!-- NubeCotizacion AutosIndividuales -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="415">Cliente</td>
               	</tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosNube_AutosIndividuales = mysql_fetch_assoc($resActividadesContactosNube_AutosIndividuales)){
		// rowActividadesContactosNube_AutosIndividuales
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosNube_AutosIndividuales['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosNube_AutosIndividuales['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosNube_AutosIndividuales['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosNube_AutosIndividuales['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosNube_AutosIndividuales['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosNube_AutosIndividuales['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosNube_AutosIndividuales['actividadInterno']);
							if($rowActividadesContactosNube_AutosIndividuales['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosNube_AutosIndividuales['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosNube_AutosIndividuales['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosNube_AutosIndividuales['idRef'], $rowActividadesContactosNube_AutosIndividuales['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosNube_AutosIndividuales['idRef'], $rowActividadesContactosNube_AutosIndividuales['tipo']);
							if($rowActividadesContactosNube_AutosIndividuales['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosNube_AutosIndividuales['usuarioCreacion']);
							}
						?>
					</td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
        <!-- NubeCotizacion AutosIndividuales -->
       	</div>
       	</td>
	</tr>
<?php
} // Nube de AutosIndividuales

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-L%EDneas+Personales', $nodosPermisos)){
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#NubeCotizacion_LineasPersonales" onclick="mostrarOcultarDiv('NubeCotizacion_LineasPersonales')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion L&iacute;neas Personales
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#NubeCotizacion_LineasPersonales" onclick="mostrarOcultarDiv('NubeCotizacion_LineasPersonales')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="NubeCotizacion_LineasPersonales" <?php echo ($muestra == "NubeCotizacion_LineasPersonales")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="NubeCotizacion_LineasPersonales" id="NubeCotizacion_LineasPersonales"></a>
        <!-- NubeCotizacion LineasPersonales -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="415">Cliente</td>
               	</tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosNube_LineasPersonales = mysql_fetch_assoc($resActividadesContactosNube_LineasPersonales)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosNube_LineasPersonales['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosNube_LineasPersonales['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosNube_LineasPersonales['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosNube_LineasPersonales['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosNube_LineasPersonales['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosNube_LineasPersonales['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosNube_LineasPersonales['actividadInterno']);
							if($rowActividadesContactosNube_LineasPersonales['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosNube_LineasPersonales['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosNube_LineasPersonales['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosNube_LineasPersonales['idRef'], $rowActividadesContactosNube_LineasPersonales['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosNube_LineasPersonales['idRef'], $rowActividadesContactosNube_LineasPersonales['tipo']);
							if($rowActividadesContactosNube_LineasPersonales['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosNube_LineasPersonales['usuarioCreacion']);
							}
						?>
					</td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
        <!-- NubeCotizacion LineasPersonales -->
       	</div>
       	</td>
	</tr>
<?php
} // Nube de LineasPersonales

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Da%F1os', $nodosPermisos)){
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#NubeCotizacion_Danos" onclick="mostrarOcultarDiv('NubeCotizacion_Danos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Da&ntilde;os
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#NubeCotizacion_Danos" onclick="mostrarOcultarDiv('NubeCotizacion_Danos')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="NubeCotizacion_Danos" <?php echo ($muestra == "NubeCotizacion_Danos")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="NubeCotizacion_Danos" id="NubeCotizacion_Danos"></a>
        <!-- NubeCotizacion Danos -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="415">Cliente</td>
               	</tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosNube_Danos = mysql_fetch_assoc($resActividadesContactosNube_Danos)){
		// rowActividadesContactosNube_Danos
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosNube_Danos['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosNube_Danos['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosNube_Danos['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosNube_Danos['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosNube_Danos['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosNube_Danos['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosNube_Danos['actividadInterno']);
							if($rowActividadesContactosNube_Danos['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosNube_Danos['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosNube_Danos['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosNube_Danos['idRef'], $rowActividadesContactosNube_Danos['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosNube_Danos['idRef'], $rowActividadesContactosNube_Danos['tipo']);
							if($rowActividadesContactosNube_Danos['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosNube_Danos['usuarioCreacion']);
							}
						?>
					</td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
        <!-- NubeCotizacion Danos -->
       	</div>
       	</td>
	</tr>
<?php
} // Nube de Daños

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Fianzas', $nodosPermisos)){
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#NubeCotizacion_Fianzas" onclick="mostrarOcultarDiv('NubeCotizacion_Fianzas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Fianzas
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#NubeCotizacion_Fianzas" onclick="mostrarOcultarDiv('NubeCotizacion_Fianzas')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="NubeCotizacion_Fianzas" <?php echo ($muestra == "NubeCotizacion_Fianzas")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="NubeCotizacion_Fianzas" id="NubeCotizacion_Fianzas"></a>
        <!-- NubeCotizacion Fianzas -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="415">Cliente</td>
               	</tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosNube_Fianzas = mysql_fetch_assoc($resActividadesContactosNube_Fianzas)){
		// rowActividadesContactosNube_Fianzas
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosNube_Fianzas['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosNube_Fianzas['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosNube_Fianzas['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosNube_Fianzas['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosNube_Fianzas['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosNube_Fianzas['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosNube_Fianzas['actividadInterno']);
							if($rowActividadesContactosNube_Fianzas['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosNube_Fianzas['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosNube_Fianzas['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosNube_Fianzas['idRef'], $rowActividadesContactosNube_Fianzas['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosNube_Fianzas['idRef'], $rowActividadesContactosNube_Fianzas['tipo']);
							if($rowActividadesContactosNube_Fianzas['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosNube_Fianzas['usuarioCreacion']);
							}
						?>
					</td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
        <!-- NubeCotizacion Fianzas -->
       	</div>
       	</td>
	</tr>
<?php
} // Nube de Fianzas

if(in_array('actividades-cotizadorNube-verCotizacionesPendientes-Flotillas', $nodosPermisos)){
?>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="350" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#NubeCotizacion_Flotillas" onclick="mostrarOcultarDiv('NubeCotizacion_Flotillas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Nube Cotizacion Flotillas
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#NubeCotizacion_Flotillas" onclick="mostrarOcultarDiv('NubeCotizacion_Flotillas')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="NubeCotizacion_Flotillas" <?php echo ($muestra == "NubeCotizacion_Flotillas")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="NubeCotizacion_Flotillas" id="NubeCotizacion_Flotillas"></a>
        <!-- NubeCotizacion NubeCotizacion_Flotillas -->
        	<table width="900" cellpadding="4" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td width="55">Folio</td>
                	<td width="75">Fecha<br>Creaci&oacute;n</td>
                	<td width="170">Actividad</td>
                	<td width="110">Ramo</td>
                	<td width="75">Status</td>
                	<td width="415">Cliente</td>
               	</tr>
<?php
$contIntLi = "0";
	while($rowActividadesContactosNube_Flotillas = mysql_fetch_assoc($resActividadesContactosNube_Flotillas)){
		// rowActividadesContactosNube_Flotillas
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td align="center">
						<?php
							$referencia = htmlspecialchars($rowActividadesContactosNube_Flotillas['referencia'], ENT_QUOTES);
							$referencia = htmlspecialchars($referencia);
						?>
                    	<div title="<? echo htmlspecialchars_decode($referencia, ENT_QUOTES); ?>">
                        <? echo DreSemaforoActividad($rowActividadesContactosNube_Flotillas['idInterno']); ?>
                        <br>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesContactosNube_Flotillas['recId']; ?>" style="text-decoration:none; color:#000;" >
                        	<strong><?php echo $rowActividadesContactosNube_Flotillas['recId']; ?></strong>
                        </a>
                        </div>
                    </td>
                	<td align="right">
                    <?php
						$fechaCreacionActividades = date_create($rowActividadesContactosNube_Flotillas['fechaCreacionActividades']);
						$fechaActualizacion = date_create($rowActividadesContactosNube_Flotillas['fechaActualizacion']);
					?>
                    <div title="<? echo "Fecha Actualizaci&oacute;n\r".date_format($fechaActualizacion, 'H:i:s a')."\r".date_format($fechaActualizacion, 'd-m-Y'); ?>">
                    	<? echo date_format($fechaCreacionActividades, 'H:i:s a'); ?>
                        <br>
                        <? echo date_format($fechaCreacionActividades, 'd-m-Y'); ?>
                    </div>
                    </td>
                	<td>
						<?php 
							echo urldecode($rowActividadesContactosNube_Flotillas['actividadInterno']); 
							if($rowActividadesContactosNube_Flotillas['actividadUrgente']){
							echo " - ";
							echo '<font style=" font-weight:bold; font-size:12px; color:#FF0000;" >';
								echo 'Urgente !!!';
							echo '</font>';
							}
						?>
                    </td>
                	<td><?php echo urldecode($rowActividadesContactosNube_Flotillas['ramoInterno']); ?></td>
                	<td><?php DreStatusActividadV2($rowActividadesContactosNube_Flotillas['recId']); ?></td>
                	<td>
						<?php
							echo DreNombreClienteContacto($rowActividadesContactosNube_Flotillas['idRef'], $rowActividadesContactosNube_Fianzas['tipo']);
							echo "<br />";
							echo DreEmailClienteContacto($rowActividadesContactosNube_Flotillas['idRef'], $rowActividadesContactosNube_Fianzas['tipo']);
							if($rowActividadesContactosNube_Flotillas['usuarioCreacion'] != $Usuario){
								echo "<br /> Vend: ";
								echo nombreVendedor($rowActividadesContactosNube_Flotillas['usuarioCreacion']);
							}
						?>
					</td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
        <!-- NubeCotizacion NubeCotizacion_Flotillas -->
       	</div>
       	</td>
	</tr>
<?php
} // Nube de Flotillas

} // Solo Grupo de Cotizadores
?>
</table>