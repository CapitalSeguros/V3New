<?php
// Consulta Principal de la Actividad //
$sqlActividad = "
		Select 
			*
			,date_format(`actividades`.`fechaCreacion`, '%d-%m-%Y %H:%i:%s') As `actividadFechaCreacion`
		From 
			`actividades` 
		Where 
			`actividades`.`recId` = '$_REQUEST[recId]'
		Order By
			`actividades`.`idInterno` Asc
				";
$resActividad = DreQueryDB($sqlActividad);
$rowActividad = mysql_fetch_assoc($resActividad);
	$idInterno = $rowActividad['idInterno']; //--> 

// Consultas Adicionales //
//**
$sqlConsultaActividadesImg = "
	Select * From
			`imagenes`
		Where
			`recId` = '$rowActividad[recId]'
							 ";
$existeImg = mysql_num_rows(DreQueryDB($sqlConsultaActividadesImg));

//**
$sqlDatosActividad = "
	Select * From 
		`actividades` 
	Where 
		`idInterno` = '$idInterno' 
					 ";
$resDatosActividad = DreQueryDB($sqlDatosActividad);
$rowDatosActividad = mysql_fetch_assoc($resDatosActividad);

//**
$sqlDatosEmisiones = "
	Select * From 
		`actividades_emision` 
	Where 
		`idActividad` = '$rowDatosActividad[recId]' 
		And 
		`tipoEmisiones` Like '%%' 
					 ";
$resDatosEmisiones = DrequeryDB($sqlDatosEmisiones);
$rowDatosEmisiones = mysql_fetch_assoc($resDatosEmisiones);

// Calculo Usuario Bolita //
$usuariosActividad[md5($rowActividad['usuario'])]=array('usuario' => $rowActividad['usuario']);
$usuariosActividad[md5($rowActividad['usuarioCreacion'])]=array('usuario' => $rowActividad['usuarioCreacion']);
	unset($usuariosActividad[md5($Usuario)]);

foreach($usuariosActividad as $usuarios){
	foreach($usuarios as $usu){
		$usuarioBolita = $usu;
	}
}
	
// Calculamos el Email del Usuario Responsable //
$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$rowActividad[usuario]'";
$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
$responsableEmail =  $rowResposableUsuarioEmail['Email'];

// Consultas Imagenes Tipo de Documentacion //
//-- 1 --//	
$sqlDocumentosCliente = "
	Select * From
		`imagenes`
	Where
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And 
		(
			(
			`TIPO` = 'CL'
			And
			`recId` = ''
			)
			Or
			(
			`TIPO_IMG` = 'IFE'
			Or 
			`TIPO_IMG` = 'COMPROBANTE DOMICILIARIO'
			Or 
			`TIPO_IMG` = 'RFC'
			Or 
			`TIPO_IMG` = 'ACTA CONSTITUTIVA'
			)
		)
	Order By
		`TIPO_IMG` Asc
						";
$ExitenDocumentosCliente = mysql_num_rows(DreQueryDB($sqlDocumentosCliente));
							
//-- 2 --//	
$sqlDocumentosActividad = "
	Select * From
		`imagenes`
	Where 
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And
			(
				`recId` = '$rowActividad[recId]'
				And
				(
					`TIPO_IMG` <> 'IFE'
					And
					`TIPO_IMG` <> 'COMPROBANTE DOMICILIARIO'
					And
					`TIPO_IMG` <> 'RFC'
					And
					`TIPO_IMG` <> 'ACTA CONSTITUTIVA'
				)
--				And 
--				`VALOR` = ''
			)
	Order By
		`TIPO_IMG` Asc
						  ";
$ExitenDocumentosActividad = mysql_num_rows(DreQueryDB($sqlDocumentosActividad));
						
//-- 3 --//
$sqlDocumentosPolizas = "
	Select * From
		`imagenes`
	Where 
		`CLIENTE_MPRO` = '$rowActividad[idRef]'
		And
		(
			(
				`TIPO` = 'PO'
				And 
				`recId` = ''
			)
			And
			`VALOR` != ''
		)
			And
			(
			`POLIZA` Like '%$buscarPoliza%' 
			Or 
			`VALOR` Like '%$buscarPoliza%' 
			)
	Group By
		`VALOR`			
	Order By
		`VALOR` Asc
						";
$ExitenDocumentosPoliza = mysql_num_rows(DreQueryDB($sqlDocumentosPolizas));

// Consultas Informacion Adicional //
$sqlInformacionAdicional = "
	Select * From
		`actividades`
	Where 
		 `recId` = '$rowActividad[recId]'
		 And
		 `inicio` = '1'
	Order By 
		`idInterno` Desc
						   ";

// Url Regreso //
	switch($regreso){
		case "cliente":
			$urlRegreso = "cliente.php?CLAVE=".$rowDatosActividad['idRef']."&muestra=Actividades#Actividades";
		break;
		
		default :
			$urlRegreso = "actividades.php";
		break;	
	}
	
	$urlTerminarActividad = "actividadesTerminar.php?recId=".$recId;

// Calculos varios //
	switch($rowActividad['actividadInterno']){
		case "Cotizaci%F3n": ## 1
			$textoVer = "Ver Emision";
			$urlVer = "actividadesDetalle.php?recId=".$rowActividad['cotizacionEmision'];

			$urlRenovacion = "includes/guardar.php?tipoGuardar=MandarRenovar&recId=".$recId."&tipoActividad=Cotizaci%F3n";
			
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Cotizaci%F3n&Usuario=".$Usuario;
			
			$urlactividadCotizada = "includes/guardar.php?tipoGuardar=ActividadCotizada&recId=".$recId."&tipoActividad=Cotizaci%F3n&usuarioCotiza=".$usuarioCotiza;
			
			$urlactividadTomada = "includes/guardar.php?tipoGuardar=ActividadTomada&recId=".$recId."&tipoActividad=Cotizaci%F3n&usuarioCotiza=".$usuarioCotiza;
			$urlactividadSoltada = "includes/guardar.php?tipoGuardar=ActividadSoltada&recId=".$recId."&tipoActividad=Cotizaci%F3n";
			$urlactividadLiberada = "includes/guardar.php?tipoGuardar=ActividadLiberada&recId=".$recId."&tipoActividad=Cotizaci%F3n";
		break;
		
		case "Emisi%F3n": ## 2
			$textoVer = "Ver Cotizacion";
			$urlVer = "actividadesDetalle.php?recId=".$rowActividad['cotizacionEmision'];
			
			$urlRenovacion = "includes/guardar.php?tipoGuardar=MandarRenovar&recId=".$recId."&tipoActividad=Emisi%F3n";
			
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Emisi%F3n&Usuario=".$Usuario;

			$urlactividadEmitida = "includes/guardar.php?tipoGuardar=ActividadEmitida&recId=".$recId."&tipoActividad=Emisi%F3&usuarioEmite=".$usuarioEmite;
		break;
		
		case "Diligencias": ## 3
		break;
		
		case "Cambio+de+Conducto": ## 4
			$urlRenovacion = "includes/guardar.php?tipoGuardar=MandarRenovar&recId=".$recId."&tipoActividad=Cambio+de+Conducto";
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Cambio+de+Conducto&Usuario=".$Usuario;

		break;
		
		case "Endoso": ## 5
			$urlRenovacion = "includes/guardar.php?tipoGuardar=MandarRenovar&recId=".$recId."&tipoActividad=Endoso";
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Endoso&Usuario=".$Usuario;
		break;

		case "Cancelacion": ## 6
			$urlRenovacion = "includes/guardar.php?tipoGuardar=MandarRenovar&recId=".$recId."&tipoActividad=Cancelacion";
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Cancelacion&Usuario=".$Usuario;
		break;
		
		case "Siniestros": ## 7
			$urlViaOficina = "includes/guardar.php?tipoGuardar=ViaOficina&recId=".$recId."&tipoActividad=Siniestros&Usuario=".$Usuario;
			$urlAsignar = "includes/guardar.php?tipoGuardar=Asignar&recId=".$recId."&tipoActividad=Siniestros&Usuario=".$Usuario;
		break;

		case "Otras+Actividades": ## 8
		break;
		
		case "Aclaraci%F3n+de+Comisiones": ## 9
		break;
		
		case "Solicitud+de+tarjetas+Club+Cap": ## 10
		break;
	}

	//** DatosCotizacionTomada
	$datosCotizacionTomada = DreNombreUsuario($rowDatosActividad['usuarioBloqueo']);
	$datosCotizacionTomada.= " &bull; ";	
	$datosCotizacionTomada.= $rowDatosActividad['fechaTomada'];	
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
			<strong>Folio: </strong><font style="color:#F00; font-size:14px;"><?php echo $rowActividad['recId']; ?></font>
        </td>
	</tr>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha Creaci&oacute;n : </strong><?php echo $rowActividad['actividadFechaCreacion']; ?>
        </td>
	</tr>

<?php
	if($rowDatosActividad['fechaViaOficina'] != "0000-00-00 00:00:00"){
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha V&iacute;a Oficina : </strong><?php echo $rowActividad['fechaViaOficina']; ?>
        </td>
	</tr>
<?php
	}
	if($rowDatosActividad['fechaCotizacion'] != "0000-00-00 00:00:00"){
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha Cotizaci&oacute;n : </strong><?php echo $rowActividad['fechaCotizacion']; ?>
        </td>
	</tr>
<?php
	}
	if($rowDatosActividad['fechaRecotizador'] != "0000-00-00 00:00:00"){
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha ReCotizaci&oacute;n : </strong><?php echo $rowActividad['fechaRecotizador']; ?>
        </td>
	</tr>
<?php
	}
	if($rowDatosActividad['fechaRecotizador2'] != "0000-00-00 00:00:00"){
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha ReCotizaci&oacute;n : </strong><?php echo $rowActividad['fechaRecotizador2']; ?>
        </td>
	</tr>
<?php
	}
	if($rowDatosActividad['fechaRecotizador3'] != "0000-00-00 00:00:00"){
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Fecha ReCotizaci&oacute;n : </strong><?php echo $rowActividad['fechaRecotizador3']; ?>
        </td>
	</tr>
<?php
	}
?>
	<tr align="right" style="font-size:12px;" valign="top">
		<td colspan="3">
            <strong>Status: </strong><?php DreStatusActividadV2($rowActividad['recId']); ?>
		</td>
	</tr>
    <tr valign="top">
    	<td colspan="3" align="right" style="font-size:12px;">
        	<strong>Datos Cliente: </strong>
            <a href="<?php echo "cliente.php?CLAVE=".$rowActividad['idRef']."&regreso=actividadesDetalle&recId=".$recId; ?>" style="text-decoration:none; color:#000" title="Clic para ver detalle">
            <?php 				
				echo "(".$rowActividad['idRef'].")&nbsp;";
				echo DreNombreCliente($rowActividad['idRef'])."&nbsp;";
				echo "&lt;".DreNombreClienteContacto($rowActividad['idRef'],$rowActividad['tipo'])."&gt;&nbsp;";
				echo (DreEmailClienteContacto($rowActividad['idRef'],$rowActividad['tipo']) != "")? "&bull;".DreEmailClienteContacto($rowActividad['idRef'],$rowActividad['tipo']) : "";
			?>
            </a>
        </td>
    </tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
    <tr valign="top">
    	<td colspan="3" align="">
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            	<tr class="TextoTitulosSecciondivClic">
                	<td colspan="2">
                    	Informaci&oacute;n Actividad
                    </td>
                </tr>
            	<tr align="left">
                	<td colspan="2">
                    	<strong>Creador:</strong>
                        <? echo nombreUsuario($rowActividad['usuarioCreacion']); ?>
					</td>
				</tr>
				<tr align="left">
					<td width="450">
						<strong>Responsable:</strong>
						<?php echo nombreUsuario($rowActividad['usuario']); ?>
					</td>
					<td>
						<strong>Actividad:</strong>
						<?php echo $rowActividad['actividad']; ?>
					</td>    
				</tr>
<?php
	if($rowDatosActividad['usuarioViaOficina'] != ""){
?>
				<tr align="left">
					<td colspan="2">
						<strong>Via Oficina:</strong>
						<?php echo nombreUsuario($rowActividad['usuarioViaOficina']); ?>
					</td>
				</tr>
<?php
	}
	if($rowDatosActividad['usuarioCotizador'] != ""){
?>
				<tr align="left">
					<td colspan="2">
						<strong>Cotizador:</strong>
						<?php echo nombreUsuario($rowActividad['usuarioCotizador']); ?>
					</td>
				</tr>
<?php
	}
	if($rowDatosActividad['usuarioRecotizador'] != ""){
?>
				<tr align="left">
					<td colspan="2">
						<strong>Re-Cotizador:</strong>
						<?php echo nombreUsuario($rowActividad['usuarioRecotizador']); ?>
					</td>
				</tr>
<?php
	}
	if($rowDatosActividad['usuarioRecotizador2'] != ""){
?>
				<tr align="left">
					<td colspan="2">
						<strong>Re-Cotizador:</strong>
						<?php echo nombreUsuario($rowActividad['usuarioRecotizador2']); ?>
					</td>
				</tr>
<?php
	}
	if($rowDatosActividad['usuarioRecotizador3'] != ""){
?>
				<tr align="left">
					<td colspan="2">
						<strong>Re-Cotizador:</strong>
						<?php echo nombreUsuario($rowActividad['usuarioRecotizador3']); ?>
					</td>
				</tr>
<?php
	}
?>
				<tr>
					<td colspan="2">
						<strong>Datos Cotizaci&oacute;n Expr&eacute;s:</strong>
						<font style="font-style:italic">
						<?php echo $rowActividad['referencia']; ?>						
					</td>
				</tr>
<?php
if(	
	$rowActividad['actividadInterno'] == "Endoso" 
	|| 
	$rowActividad['actividadInterno'] == "Cancelacion" 
	|| 
	$rowActividad['actividadInterno'] == "Siniestros"
){
?>
				<tr>
					<td colspan="2">
						<strong>Poliza:</strong>
						<font style="font-style:italic">
						<?php echo $rowActividad['POLIZA']; ?>						
					</td>
				</tr>
<?php
}
?>
				<tr>
					<td colspan="2" align="right">
<?php 
// Botones Navegacion Primera Linea
	switch($rowActividad['actividadInterno']){

		case "Cotizaci%F3n": ## 1

			//**  Boton - Cotizar Actividad
			if(
				(
					DrePermisoUsuario('actividades-cotizarActividad-cotizar-si', $nodosPermisos)
					||
					mysql_result(DreQueryDB("Select `usuarioBloqueo` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0) == $usuarioCotiza
				)
				&&
				isset($nodosPermisos)
			){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "1"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral" 
                        value="Actividad Cotizada" title="Actividad Cotizada" 
                        onClick="java:window.open('<?php echo $urlactividadCotizada; ?>','_self');"
                    />
                    <?php
				}
			}
			
			//** Boton - Mandar a Renovar
			if(DrePermisoUsuario('actividades-renovarActividad-renovar-si', $nodosPermisos)){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "1"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral"
                        value="Renovaciones" title="Mandar a Ejecutivo Renovaciones" 
                        onclick="java:window.open('<?php echo $urlRenovacion; ?>','_self');"
                    />
                    <?
				}
			}
			
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
		break;
				
		case "Emisi%F3n": ## 2
			//** Boton - Emitir Actividad
			if(
				(
					DrePermisoUsuario('actividades-emitirActividad-emitir-si', $nodosPermisos) 
					||
					mysql_result(DreQueryDB("Select `usuarioBloqueo` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0) == $usuarioCotiza
				)
				&&
				isset($nodosPermisos)
			){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "4"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral"
                        value="Actividad Emitida" title="Emitir Actividad" 
                        onClick="java:window.open('<?php echo $urlactividadEmitida; ?>','_self');"
                    />
                    <?php
				}
			}

			//** Boton - Mandar a Renovar
			if(DrePermisoUsuario('actividades-renovarActividad-renovar-si', $nodosPermisos)){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "4"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral"
                        value="Renovaciones" title="Mandar a Ejecutivo Renovaciones" 
                        onclick="java:window.open('<?php echo $urlRenovacion; ?>','_self');"
                    />
                    <?
				}
			}
			
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
		break;
		
		case "Diligencias": ## 3
		break;
		
		case "Cambio+de+Conducto": ## 4
			//** Boton - Mandar a Renovar
			if(DrePermisoUsuario('actividades-renovarActividad-renovar-si', $nodosPermisos)){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "4"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral"
                        value="Renovaciones" title="Mandar a Ejecutivo Renovaciones" 
                        onclick="java:window.open('<?php echo $urlRenovacion; ?>','_self');"
                    />
                    <?
				}
			}
			
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
		break;

		case "Endoso": ## 5
			//** Boton - Mandar a Renovar
			if(DrePermisoUsuario('actividades-renovarActividad-renovar-si', $nodosPermisos)){
				?>
				<input 
                	type="button" class="buttonGeneral"
                    value="Mandar a Renovar" title="Mandar a Renovar Poliza"
                	onclick="java:window.open('<?php echo $urlRenovacion; ?>','_self');"
                />
				<?
			}
			
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
		break;

		case "Cancelacion": ## 6
			//** Boton - Mandar a Renovar
			if(DrePermisoUsuario('actividades-renovarActividad-renovar-si', $nodosPermisos)){
				if(
					$rowActividad['fin'] != "1"
					&&
					$rowActividad['prioridad'] != "4"
				){
					?>
                    <input 
                    	type="button" class="buttonGeneral"
                        value="Renovaciones" title="Mandar a Ejecutivo Renovaciones" 
                        onclick="java:window.open('<?php echo $urlRenovacion; ?>','_self');"
                    />
                    <?
				}
			}
			
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
		break;
		
		case "Siniestros": ## 7
			//** Boton -  Via Oficina
			if(DrePermisoUsuario('actividades-terminarViaOficina-oficina-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != "3"){
					?>
    				<input 
                    	type="button" class="buttonGeneral"
						value="V&iacute;a Oficina" title="Mandar a Via Oficina"
                    	onclick="java:window.open('<?php echo $urlViaOficina; ?>','_self');" 
                    />
					<?
				}
			}
			
			//** Boton - Asigna Siniestro
			if(DrePermisoUsuario('actividades-asignarActividad-asignar-si', $nodosPermisos)){
				?>
				<input 
                	type="button" class="buttonGeneral"
                    value="Asignar Siniestro" title="Asignar Siniestro a Axiliar"
                	onclick="java:window.open('<?php echo $urlAsignar; ?>','_self');"
                />
				<?
			}
		break;

		case "Otras+Actividades": ## 8
		case "Aclaraci%F3n+de+Comisiones": ## 9
		case "Solicitud+de+tarjetas+Club+Cap": ## 10
		default:
		break;
	}
?>
                    </td>
				</tr>
				<tr>
					<td colspan="2" align="right">
<?php 
// Botones Navegacion Segunda Linea
	switch($rowActividad['actividadInterno']){
		case "Cotizaci%F3n": ## 1
			//** Boton - Emitir/Recotizar
			if($rowActividad['fin'] != "1"){
				?>
				<input 
                	type="button" class="buttonGeneral"
                	value="Emitir-Recotizar" title="Terminar Actividades"
                	onclick="java:window.open('<?php echo $urlTerminarActividad; ?>','_self');"
                />
                <?php
			}
			//** Boton - Ver CotizacionEmision
			if($rowActividad['cotizacionEmision'] != ""){
				?>
                <input
                   	type="button" class="buttonGeneral" 
					value="<? echo $textoVer; ?>" title="<? echo $textoVer; ?>"
					onclick="java:window.open('<?php echo $urlVer; ?>','_self');"
				/>
                <?
			}
			//** Boton - Regresar
			?>
			<input
        		type="button" class="buttonGeneral"
	            value="Regresar" title="Regresar a Actividades" 
	            onclick="java:window.open('<?php echo $urlRegreso; ?>','_self');" 
	        />
	        <?
		break;
		
		case "Emisi%F3n": ## 2
			//** Boton - Ver CotizacionEmision
			if($rowActividad['cotizacionEmision'] != ""){
				?>
                <input
                   	type="button" class="buttonGeneral" 
					value="<? echo $textoVer; ?>" title="<? echo $textoVer; ?>"
					onclick="java:window.open('<?php echo $urlVer; ?>','_self');"
				/>
                <?
			}
			//** Boton - Regresar
			?>
			<input
        		type="button" class="buttonGeneral"
	            value="Regresar" title="Regresar a Actividades" 
	            onclick="java:window.open('<?php echo $urlRegreso; ?>','_self');" 
	        />
	        <?
		break;

		case "Diligencias": ## 3
		case "Cambio+de+Conducto": ## 4
		case "Endoso": ## 5
		case "Cancelacion": ## 6
		case "Siniestros": ## 7
		case "Otras+Actividades": ## 8
		case "Aclaraci%F3n+de+Comisiones": ## 9
		case "Solicitud+de+tarjetas+Club+Cap": ## 10
		default:		
			//** Boton - Regresar
			?>
			<input
        		type="button" class="buttonGeneral"
	            value="Regresar" title="Regresar a Actividades" 
	            onclick="java:window.open('<?php echo $urlRegreso; ?>','_self');" 
	        />
	        <?
		break;
	}
?>
                    </td>
				</tr>
                <tr>
                	<td colspan="2" align="right">
<?php 
// Botones Navegacion Tercera Linea
	switch($rowActividad['actividadInterno']){
		case "Cotizaci%F3n": ## 1
			//** Boton - Tomar Actividad
			if(DrePermisoUsuario('actividades-terminarBloquear-bloquear-si', $nodosPermisos)){
				if($rowActividad['prioridad'] != 1){
					if(mysql_result(DreQueryDB("Select `usuarioBloqueo` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0) == ""){
						?>
						<input
							type="button" class="buttonGeneral"
	                        value="Tomar Actividad" title="Tomar Actividad"
	                        onClick="java:window.open('<?php echo $urlactividadTomada; ?>','_self');"
	                    />
	                    <?
					} else if(mysql_result(DreQueryDB("Select `usuarioBloqueo` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0) == $usuarioCotiza) {
						?>
                        <input 
                        	type="button" class="buttonGeneral"
                            value="Soltar Actividad" title="Soltar Actividad"
                            onClick="java:window.open('<?php echo $urlactividadSoltada; ?>','_self');"
                        />
						<?
					}
				}
			}

			//** Boton - Liberar Ejecutivo
			if(DrePermisoUsuario('actividades-liberarActividad-liberar-si', $nodosPermisos)){
				if(mysql_result(DreQueryDB("Select `usuarioBloqueo` From `actividades` Where (`recId` = '$recId' And `inicio` = '0') And (`prioridad` != '1')"),0) != ""){
					?>
					<input 
                    	type="button" class="buttonGeneral"
                        value="Liberar Actividad <? echo $datosCotizacionTomada; ?>"  title="Liberar Actividad" 
                        onClick="java:window.open('<?php echo $urlactividadLiberada; ?>','_self');" 
                    />
					<?
				}
			}
		break;
		
		case "Emisi%F3n": ## 2
		case "Diligencias": ## 3
		case "Cambio+de+Conducto": ## 4
		case "Endoso": ## 5
		case "Cancelacion": ## 6
		case "Siniestros": ## 7
		case "Otras+Actividades": ## 8
		case "Aclaraci%F3n+de+Comisiones": ## 9
		case "Solicitud+de+tarjetas+Club+Cap": ## 10
		default:
		break;
	}
?>
                    </td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
			</table>
        </td>
	</tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<?php
	if($rowActividad['prioridad'] == 1){
?>
    <tr>
    	<td colspan="3">
        	
        	<font style="color:#F00; font-weight:bold; font-size:14px;">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	Actividad Cotizada !!!
            </font>
        </td>
    </tr>
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
<?php
	}
?>  
<!-- Primera Seccion Formulario -->
    <tr>
    	<td>
		</td>
	</tr>

<!-- Segunda Seccion Añadir Documentos -->
    <tr>
    	<td>
        	<div class="divClic">
            	<table width="" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="300" class="TextoTitulosEdicionAgregar">
						<a href="#Documentos" onclick="mostrarOcultarDiv('Documentos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
							&nbsp;&nbsp;&nbsp;
							Documentos
                        </a>
                        </td>
                    	<td style="font-size:12px;">
						<a href="#Documentos" onclick="mostrarOcultarDiv('Documentos')" class="LinkSecciondivClic" title="Click para ver detalle...">
		                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		            Click para ver detalle...
						</a>
                        </td>
                    </tr>
                </table>
			</div>
        	<div id="Documentos" <?php echo ($muestra == "Documentos")? 'style="display:block;"':'style="display:none;"'; ?>>
            <a name="Documentos" id="Documentos"></a>
				<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td>&nbsp;</td>
                    </tr>
	<?php 
		if(
			(
			$rowActividad['fin'] != "1"
			&&
			$rowActividad['prioridad'] != "1"
			)
			&&
			(
			$rowActividad['usuarioBloqueo'] == ""
			||
			$rowActividad['usuarioBloqueo'] == $_SESSION['WebDreTacticaWeb2']['usuarioCotiza']
			)
		){ 
	?>
                	<tr>
                    	<td>
						<strong>
                            Agregar Documentos
						</strong>
                        </td>
                    </tr>
					<form name="formDocumentosActividad" id="formDocumentosActividad" method="post" enctype="multipart/form-data" action="includes/agregar.php?tipoAgregar=documentosActividad" >
                	<tr>
                    	<td>
                        	<table width="850" align="center" cellpadding="1" cellspacing="2" border="0">
                            	<tr>
                                	<td colspan="2">
                                    	Descripcion
									</td>
								</tr>
                                <tr>
									<td colspan="2">
										<input type="text" name="DESCRIPCION" id="DESCRIPCION" value="<?php echo $descripcionVehiculo; ?>" style="width:100%"/>
                                	</td>
                                </tr>
<?php
	if($rowActividad['actividadInterno'] == "Emisi%F3n" && $_SESSION['WebDreTacticaWeb']['NIVEL'] != 2){
?>
                                <tr>
                                	<td colspan="2">
                                    	Poliza
                                	</td>
                                </tr>
                                <tr>
                                	<td colspan="2">
	                                	<input type="text" name="VALOR" id="VALOR" size="25"/>
	    	                            <input type="hidden" name="validacionPoliza" id="validacionPoliza" value="S" />
        	                        </td>
                                </tr>
<?php
	} else {
?>
                                <tr>
                                	<td colspan="2">
	                                    <input type="hidden" name="validacionPoliza" id="validacionPoliza" value="N" />
	                                    <input type="hidden" name="VALOR" id="VALOR" size="25"/>
                                    </td>
                                </tr>
<?php	
	}
?>
                                <tr>
                                	<td>Tipo Img</td>
                                	<td>Archivo </td>
                                </tr>
                                <tr>
                                	<td>
                                		<select name="TIPO_IMG" id="TIPO_IMG">
											<option value="">-- Seleccione  --</option>
	            				            <?php
											$sqlTipoImg = "Select * From `tiposdoctos`";
											$resTipoImg = DreQueryDB($sqlTipoImg);
											while($rowTipoImg = mysql_fetch_assoc($resTipoImg)){
											?>
											<option value="<?php echo $rowTipoImg['DESCRIPCION']."*".$rowTipoImg['APLICA']; ?>">
												<?php echo $rowTipoImg['DESCRIPCION']; ?>
											</option>
											<?php
											}
											?>
                                		</select>
                                	</td>
                                	<td>
                                		<input type="file" name="archivo" id="archivo" size="40" />
                                	</td>
                                </tr>
                               	<tr>
                                	<td colspan="2" align="right">
	                                	<input type="hidden" name="extension" id="extension" />
                                		<input type="hidden" name="recId" id="recId" value="<? echo $rowActividad['recId']; ?>"/>
                                		<input type="hidden" name="idRef" id="idRef" value="<? echo $rowActividad['idRef']; ?>" />
                                		<input type="hidden" name="idInterno" id="idInterno" value="<? echo $idInterno; ?>"/>
                                		<input type="hidden" name="idEmpresa" id="idEmpresa" value="<? echo $rowActividad['idRef']; ?>"/>
                                		<input type="hidden" name="actividadInterno" id="actividadInterno" value="<? echo $rowActividad['actividadInterno']; ?>" />
                                		<input type="hidden" name="ramoInterno" id="ramoInterno" value="<? echo $rowActividad['ramoInterno']; ?>" />
                                		<input type="hidden" name="tipo" id="tipo" value="<? echo $rowActividad['tipo']; ?>" />
                                		<input type="hidden" name="actividad" id="actividad" value="<? echo $rowActividad['actividad']; ?>" />
                                		<input type="hidden" name="usuario" id="usuario" value="<? echo $rowActividad['usuario']; ?>" />
                                		<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<? echo $Usuario; ?>" />
                                		<input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<? echo $usuarioBolita; ?>" />
                                		<input type="hidden" name="responsableEmail" id="responsableEmail" value="<? echo $responsableEmail; ?>" />
                                		<input type="hidden" name="SUCURSAL" id="SUCURSAL" value="<? echo $Sucursal; ?>" />
                                		<input type="button" value="Agregar" class="ButtonGeneral" onclick="validarDocumentosActividad()" />
                               			&nbsp;&nbsp;
                               		</td>
                               	</tr>
							</table>
                        </td>
					</tr>
					</form>
	<?php } ?>
                	<tr>
                    	<td>
						<strong>
                            Ver Documentos
						</strong>
                        </td>
                    </tr>
                	<tr>
                    	<td>
                            <table width="850" cellpadding="0" cellspacing="0" border="0">
								<tr>
                                	<td width="300" class="TextoTitulosEdicionAgregar">
                                    	<a href="#DocumentosCliente" onclick="mostrarOcultarDiv('DocumentosCliente')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                                        	&nbsp;&nbsp;&nbsp;
                                            Documentos del Cliente
                                    	</a>
                                	</td>
								</tr>
                            </table>
                        </td>
                    </tr>
                	<tr>
                    	<td>
<!-- Documentos Cliente -->
            	<div id="DocumentosCliente" style="display:none;">
                <a name="DocumentosCliente" id="DocumentosCliente"></a>
<?php
	if($ExitenDocumentosCliente <= 0){
		//echo "NO Existen Documentos de Este Tipo";
?>
                            <table width="850" cellpadding="0" cellspacing="0" border="0" style="border:#C3C3C3 solid 1px;" align="center">
                            	<tr>
                                	<td style="font-size:12px; color:#00397E;">
                                    	<strong>AUN NO CONTAMOS CON DOCUMENTACI&Oacute;N DEL CLIENTE</strong>
                                        <br>
                                        <font style=" font-size:10px;">
                                        (IFE, COMPROBANTE DOMICILIARIO, RFC, ACTA CONSTITUTIVA)
                                        </font>
									</td>
								</tr>
                            </table>
<?php
	} else {
		//echo "SI Existen Documentos de Este Tipo";
?>
                            <table width="850" cellpadding="1" cellspacing="1" border="0" align="center">
                            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold; font-size:12px;">
                                	<td width="85"><strong>No Archivo</strong></td>
                                    <td width="275"><strong>Descripcion</strong></td> <!-- width="325" --> 
                                    <td width="160"><strong>Tipo Img</strong></td>
                                    <td width="60"><strong>Estatus</strong></td>
                                    <td width="150"><strong>Fecha</strong></td>
                                    <td width="60" align="center"><strong>Archivo</strong></td>
                                    <td width="60" align="center"><strong>Enviar</strong></td>
								</tr>
<?php 
	$contIntLi=0;
	$resDocumentosCliente = DreQueryDB($sqlDocumentosCliente);
	while($rowDocumentosCliente = mysql_fetch_assoc($resDocumentosCliente)){
		$contIntLi++;
		if(strstr($rowDocumentosCliente['EXTENSION'],'.')){ 
			$extensionDocumento = $rowDocumentosCliente['EXTENSION'];
		} else {
			$extensionDocumento = ".".$rowDocumentosCliente['EXTENSION'];
		}
		if($rowDocumentosCliente['RUTA'] == ""){
			$rutaDocumento = "/";
		} else {
			$rutaDocumento = $rowDocumentosCliente['RUTA'];
		}
?>
								<tr bgcolor="<? echo($contIntLi%2==0)?"#C6C6C6":"#E9E9E9"; ?>" style="font-size:10px;">
									<td align="justify">
										<?php echo $rowDocumentosCliente['NO_ARCHIVO']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosCliente['DESCRIPCION']; ?>
									</td>
									<td align="justify">
	                        	    	<?php echo $rowDocumentosCliente['TIPO_IMG']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosCliente['ESTATUS']; ?>
									</td>
									<td align="justify">
		                            	<?php echo $rowDocumentosCliente['FECHA_ALTA']; ?>
									</td>
									<td align="center">
                        	<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosCliente['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
											<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
										</a>
									</td>
									<td align="center">
										<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowDocumentosCliente['CLIENTE_MPRO']."&adjuntoCorreo=".$rowDocumentosCliente['NO_ARCHIVO']."&regreso=actividadesDetalle&recId=".$recId; ?>" target="_self" title="Clic Enviar">
											<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
										</a>
									</td>
								</tr>
<?php
	}
?>
								<tr>
                                	<td colspan="7">&nbsp;</td>
                                </tr>
							</table>
<?php
	} // Fin del If ExistenDocumentosCliente
?>
				</div>
<!-- Documentos Cliente -->
                        </td>
                    </tr>
                	<tr>
                    	<td>
                            <table width="850" cellpadding="0" cellspacing="0" border="0">
								<tr>
                                	<td width="300" class="TextoTitulosEdicionAgregar">
                                    	<a href="#DocumentosActividad" onclick="mostrarOcultarDiv('DocumentosActividad')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                                        	&nbsp;&nbsp;&nbsp;
                                            Documentos de la Actividad
                                    	</a>
                                	</td>
								</tr>
                            </table>
                        </td>
                    </tr>
                	<tr>
                    	<td>
<!-- Documentos Actividad -->
<?php
	switch($rowActividad['prioridad']){
		case 0:
			?>
            <div id="DocumentosActividad" style="display:none;">
            <?php
		break;
		
		case 1:
			?>
			<div id="DocumentosActividad" style="display:block;">
            <?php
		break;
	}
?>
                <a name="DocumentosActividad" id="DocumentosActividad"></a>
<?php
	if($ExitenDocumentosActividad <= 0){
	//echo "NO Existen Documentos de Este Tipo";
?>
                            <table width="850" cellpadding="0" cellspacing="0" border="0" style="border:#C3C3C3 solid 1px;" align="center">
                            	<tr>
                                	<td style="font-size:12px; color:#00397E;">
                                    	<strong>AUN NO CONTAMOS CON DOCUMENTACI&Oacute;N DE LA ACTIVIDAD</strong>
                                        <br>
                                        <!--
                                        	<font style=" font-size:10px;">
                                            (IFE, COMPROBANTE DOMICILIARIO, RFC, ACTA CONSTITUTIVA)
                                            
										-->
									</td>
								</tr>
                            </table>
<?php
	} else {
		//echo "SI Existen Documentos de Este Tipo";
?>
                            <table width="850" cellpadding="1" cellspacing="1" border="0" align="center">
                            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold; font-size:12px;">
                                	<td width="85"><strong>No Archivo</strong></td>
                                    <td width="275"><strong>Descripcion</strong></td> <!-- width="325" --> 
                                    <td width="160"><strong>Tipo Img</strong></td>
                                    <td width="60"><strong>Estatus</strong></td>
                                    <td width="150"><strong>Fecha</strong></td>
                                    <td width="60" align="center"><strong>Archivo</strong></td>
                                    <td width="60" align="center"><strong>Enviar</strong></td>
								</tr>
<?php 
	$contIntLi=0;
	$resDocumentosActividad = DreQueryDB($sqlDocumentosActividad);
	while($rowDocumentosActividad = mysql_fetch_assoc($resDocumentosActividad)){
		$contIntLi++;
		if(strstr($rowDocumentosActividad['EXTENSION'],'.')){ 
			$extensionDocumento = $rowDocumentosActividad['EXTENSION'];
		} else {
			$extensionDocumento = ".".$rowDocumentosActividad['EXTENSION'];
		}
		if($rowDocumentosActividad['RUTA'] == ""){
			$rutaDocumento = "/";
		} else {
			$rutaDocumento = $rowDocumentosActividad['RUTA'];
		}
?>
								<tr bgcolor="<? echo($contIntLi%2==0)?"#C6C6C6":"#E9E9E9"; ?>" style="font-size:10px;">
									<td align="justify">
										<?php echo $rowDocumentosActividad['NO_ARCHIVO']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosActividad['DESCRIPCION']; ?>
									</td>
									<td align="justify">
	                        	    	<?php echo $rowDocumentosActividad['TIPO_IMG']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosActividad['ESTATUS']; ?>
									</td>
									<td align="justify">
		                            	<?php echo $rowDocumentosActividad['FECHA_ALTA']; ?>
									</td>
									<td align="center">
                        	<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosActividad['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
											<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
										</a>
									</td>
									<td align="center">
										<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowDocumentosActividad['CLIENTE_MPRO']."&adjuntoCorreo=".$rowDocumentosActividad['NO_ARCHIVO']."&regreso=actividadesDetalle&recId=".$recId; ?>" target="_self" title="Clic Enviar">
											<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
										</a>
									</td>

								</tr>
<?php
	}
?>
								<tr>
                                	<td colspan="7">&nbsp;</td>
                                </tr>
							</table>
<?php
	} // Fin del If ExistenDocumentosCliente
?>
				</div>
<!-- Documentos Actividad -->
                        </td>
                    </tr>
                	<tr>
                    	<td>
                            <table width="850" cellpadding="0" cellspacing="0" border="0">
								<tr>
                                	<td width="300" class="TextoTitulosEdicionAgregar">
                                    	<a href="#DocumentosPoliza" onclick="mostrarOcultarDiv('DocumentosPoliza')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                                        	&nbsp;&nbsp;&nbsp;
                                            Documentos de las Polizas
                                    	</a>
                                	</td>
								</tr>
                            </table>
                        </td>
                    </tr>
                	<tr>
                    	<td>
<!-- Documentos Polizas -->
            	<div id="DocumentosPoliza" <?php echo ($muestraPrincipal == "DocumentosPoliza")? 'style="display:block;"':'style="display:none;"'; ?>>
                <a name="DocumentosPoliza" id="DocumentosPoliza"></a>
<?php
	if($ExitenDocumentosPoliza <= 0){
		//echo "NO Existen Documentos de Este Tipo";
?>
                            <table width="850" cellpadding="0" cellspacing="0" border="0" style="border:#C3C3C3 solid 1px;" align="center">
                            	<tr>
                                	<td style="font-size:12px; color:#00397E;">
                                    	<strong>AUN NO CONTAMOS CON DOCUMENTACI&Oacute;N DE LAS POLIZAS </strong>
                                        <br>
                                        <font style=" font-size:10px;">
                                        (CARATULA, ENDOSO, PAGOS, TARJETA DE CIRCULACION, FACTURAS, CONTRATOS, RECIBOS DE PAGO)
                                        </font>
									</td>
								</tr>
                            </table>
<?php
	} else {
		//echo "SI Existen Documentos de Este Tipo";
?>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td>
                        <blockquote>
		                	<form name="formBuscarPoliza" id="formBuscarPoliza" method="post" action="#DocumentosPoliza" >
								<input type="text" name="buscarPoliza" id="buscarPoliza" value="<? echo (isset($_REQUEST['buscarPoliza']))? $_REQUEST['buscarPoliza'] : "" ; ?>" style="width:680px; " />
                                <input type="hidden" name="recId" id="recId" value="<? echo $recId; ?>" />
                                <input type="hidden" name="muestraPrincipal" id="muestraPrincipal" value="DocumentosPoliza" />
                                <input type="hidden" name="muestra" id="muestra" value="Documentos" />
                		        <input type="submit" value="Buscar Poliza" />
							</form>
                        </blockquote>
	                    </td>
                    </tr>
				</table>
<?php

		$resDocumentosPolizas = DreQueryDB($sqlDocumentosPolizas);
		while($rowDocumentosPolizas = mysql_fetch_assoc($resDocumentosPolizas)){ // Recorrido por las Polizas del Cliente
			$poliza = $rowDocumentosPolizas['VALOR'];
?>
                            <font style="color:#00397E;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull; 
                            <strong>Poliza:</strong>
							<? echo $poliza; ?>
                            <strong>Ramo:</strong>
                            <? DreRamoPoliza($poliza); ?>
                            </font>	
                            <table width="850" cellpadding="1" cellspacing="1" border="0" align="center">
                            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold; font-size:12px;">
                                    <td width="60" align="center"><strong>Archivo</strong></td>
                                    <td width="60" align="center"><strong>Enviar</strong></td>
                                    <td width="160"><strong>Tipo Img</strong></td>
                                    <td width="275"><strong>Descripcion</strong></td> <!-- width="325" --> 
                                    <td width="150"><strong>Fecha</strong></td>
                                	<td width="85"><strong>No Archivo</strong></td>
                                    
                                    <td width="60"><strong>Estatus</strong></td>
								</tr>
<?php 
	$contIntLi=0;
	$sqlDocumentosPoliza = "
		Select * From
			`imagenes`
		Where
			`VALOR` = '$poliza'
				And
				(
					`TIPO_IMG` <> 'IFE'
					And
					`TIPO_IMG` <> 'COMPROBANTE DOMICILIARIO'
					And
					`TIPO_IMG` <> 'RFC'
					And
					`TIPO_IMG` <> 'ACTA CONSTITUTIVA'
				)
		Order By
			`TIPO_IMG` Asc
						   ";
	$resDocumentosPoliza = DreQueryDB($sqlDocumentosPoliza);
	while($rowDocumentosPoliza = mysql_fetch_assoc($resDocumentosPoliza)){
		$contIntLi++;	
		if(strstr($rowDocumentosPoliza['EXTENSION'],'.')){ 
			$extensionDocumento = $rowDocumentosPoliza['EXTENSION'];
		} else {
			$extensionDocumento = ".".$rowDocumentosPoliza['EXTENSION'];
		}
		if($rowDocumentosPoliza['RUTA'] == ""){
			$rutaDocumento = "/";
		} else {
			$rutaDocumento = $rowDocumentosPoliza['RUTA'];
		}
?>
								<tr bgcolor="<? echo($contIntLi%2==0)?"#C6C6C6":"#E9E9E9"; ?>" style="font-size:10px;">
									<td align="center">
                        	<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosPoliza['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
											<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
										</a>
									</td>
									<td align="center">
										<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowActividad['idRef']."&adjuntoCorreo=".$rowDocumentosPoliza['NO_ARCHIVO']."&regreso=actividadesDetalle&recId=".$recId; ?>" target="_self" title="Clic Enviar">
											<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
										</a>
									</td>
									<td align="justify">
	                        	    	<?php echo $rowDocumentosPoliza['TIPO_IMG']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosPoliza['DESCRIPCION']; ?>
									</td>
									<td align="justify">
		                            	<?php echo $rowDocumentosPoliza['FECHA_ALTA']; ?>
									</td>
									<td align="justify">
										<?php echo $rowDocumentosPoliza['NO_ARCHIVO']; ?>
									</td>
                                    
									<td align="justify">
										<?php echo $rowDocumentosPoliza['ESTATUS']; ?>
									</td>
								</tr>
<?php
	}
?>
								<tr>
                                	<td colspan="7">&nbsp;</td>
                                </tr>
							</table>
<?php
		}
	} // Fin del If ExistenDocumentosCliente
?>
				</div>
<!-- Documentos Polizas -->
                        </td>
                    </tr>
                </table>
            </div>
			<br>
        </td>
    </tr>
<!-- Tercera Seccion Comentarios Adicionales -->
    <tr>
    	<td>
        	<div class="divClic">
            	<table width="" cellpadding="0" cellspacing="0" border="0">
                	<tr>
                    	<td width="300" class="TextoTitulosEdicionAgregar">
						<a href="#Seguimiento" onclick="mostrarOcultarDiv('Seguimiento')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
							&nbsp;&nbsp;&nbsp;
							Comentarios
                        </a>
                        </td>
                    	<td style="font-size:12px;">
						<a href="#Seguimiento" onclick="mostrarOcultarDiv('Seguimiento')" class="LinkSecciondivClic" title="Click para ver detalle...">
		                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        		            Click para ver detalle...
						</a>
                        </td>
                    </tr>
                </table>
			</div>
        	<div id="Seguimiento" <?php echo ($muestra == "Seguimiento")? 'style="display:block;"':'style="display:none;"'; ?>>
            <a name="Seguimiento" id="Seguimiento"></a>
				<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td>&nbsp;</td>
                    </tr>
	<?php 
		if(
			(
			$rowActividad['fin'] != "1"
			&&
			$rowActividad['prioridad'] != "1"
			)
			&&
			(
			$rowActividad['usuarioBloqueo'] == ""
			||
			$rowActividad['usuarioBloqueo'] == $_SESSION['WebDreTacticaWeb2']['usuarioCotiza']
			)

		){ 
	?>
                	<tr>
                    	<td valign="top">
                        <strong>
                        	&nbsp;&nbsp;&nbsp;Agregar Comentario Actividad
						</strong>
                    	</td>
                    </tr>
<form name="formActividadInformacion" id="formActividadInformacion" method="post" action="includes/agregar.php?tipoAgregar=ActividadInformacion">
                	<tr>
                    	<td valign="top">
                        	<?php
								$tipo_toolbar = "Dre";
								$oFCKeditor = new FCKeditor('referencia') ;
								$oFCKeditor->BasePath = 'fckeditor/' ;
								$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
								$oFCKeditor->Value = "";
								$oFCKeditor->Create();
                        	?>
                        </td>
					</tr>
                	<tr>
                    	<td valign="top" align="right">
		<input type="hidden" name="actividadInterno" id="actividadInterno" value="<?php echo $rowActividad['actividadInterno']; ?>" />
		<input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowActividad['ramoInterno']; ?>" />
		<input type="hidden" name="idRef" id="idRef" value="<?php echo $rowActividad['idRef']; ?>" />
		<input type="hidden" name="tipo" id="tipo" value="<?php echo $rowActividad['tipo']; ?>" />
		<input type="hidden" name="actividad" id="actividad" value="<?php echo $rowActividad['actividad']; ?>" />
		<input type="hidden" name="recId" id="recId" value="<?php echo $rowActividad['recId']; ?>" />
		<input type="hidden" name="usuario" id="usuario" value="<?php echo $rowActividad['usuario']; ?>" />
        <input type="hidden" name="responsableEmail" id="responsableEmail" value="<?php echo $responsableEmail; ?>" />
        
		<input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?php echo $usuarioBolita; ?>" />
		<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $Usuario; ?>" />
                        <input type="submit" value="Guardar Comentario" />
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
					</tr>
</form>
	<?php } ?>
                	<tr>
                    	<td valign="top">
                        <strong>
                        	&nbsp;&nbsp;&nbsp;Comentario Actividad
						</strong>
                    	</td>
                    </tr>
                    <tr>
                    	<td>
                            <table width="850" cellpadding="1" cellspacing="1" border="0" align="center">
<?php
	$contIntLi=0;
	$resInformacionAdicional = DreQueryDB($sqlInformacionAdicional);
	while($rowInformacionAdicional = mysql_fetch_assoc($resInformacionAdicional)){
?>
								<tr bgcolor="<? echo($contIntLi%2==0)?"#C6C6C6":"#E9E9E9"; ?>">
                                	<td width="350" style="font-size:12px;">
                                    	<strong>Usuario:</strong>
                                        <font style="font-size:10px;">
										<?php echo nombreUsuario($rowInformacionAdicional['usuarioCreacion']); ?>
                                        </font>
                                    </td>
                                    <td width="500" style="font-size:12px;">
                                    	<strong>Fecha:</strong>
                                        <font style="font-size:10px;">
										<?php echo $rowInformacionAdicional['fechaCreacion']; ?>
                                        </font>
                                    </td>
								</tr>
                            	<tr>
                                	<td colspan="2" style="font-size:12px;">
                                    	<?php echo $rowInformacionAdicional['referencia']; ?>
                                    </td>
                                </tr>
                            	<tr>
                                	<td colspan="2">&nbsp;</td>
                                </tr>
<?php
	$contIntLi++;
	}
?>
                            </table>
                        </td>
                    </tr>
				</table>
            </div>
            <br>
        </td>
    </tr>

<!-- -->
    <tr height="9">
    	<td colspan="3"></td>
	</tr>
</table>
<br />
<?php DreDesconectarDB($conexion); ?>