<?php
if(isset($CLAVE) && $CLAVE != ""){
	$sqlDatosEmpresa = "
		Select 
			*
		From 
			`empresas`
		Where 

			`empresas`.`CLAVE` = '$CLAVE'
					   ";
	$resDatosEmpresa = DreQueryDB($sqlDatosEmpresa);
	$rowDatosEmpresa = mysql_fetch_assoc($resDatosEmpresa);	
}

switch($rowDatosEmpresa['TIPO_REGISTRO']){
	case 'PR':
		$tipoRegistro = "Prospecto"; // PROSPECTO
	break;
	
	case 'CL':
		$tipoRegistro = "Cliente"; // CLIENTE
	break;
}		

switch($rowDatosEmpresa['TIPO_PERSONA']){
	case 'F':
		$tipoPersona = "F&iacute;sica";
	break; 
	
	case 'M':
		$tipoPersona = "Moral";
	break; 
}

switch($rowDatosEmpresa['Club_Cap']){
	case 'S':
		$clubCap = "Si";
	break;

	case 'N':
		$clubCap = "No";
	break;
}

switch($rowDatosEmpresa['Poliza_Electronica']){
	case 'S':
		$polizaElectronica = "Si";
	break;

	case 'N':
		$polizaElectronica = "No";
	break;
}

switch($rowDatosEmpresa['GENERO']){
	case 'F':
		$genero = "Femenino";
	break;

	case 'M':
		$genero = "Masculino";
	break;
}

switch($rowDatosEmpresa['AUTOMOVIL']){
	case 'S':
		$automovil = "Si";
	break;

	case 'N':
		$automovil = "No";
	break;
}

if(isset($regreso) && $regreso != ""){
	switch($regreso){
		
		case "clienteDocumentos" :
			$return = "clienteDocumentos.php?CLAVE=".$rowDatosEmpresa['CLAVE'];
		break;
		
		case "actividadesDetalle" :
			$return = "actividadesDetalle.php?recId=".$recId;
		break;
		
	}
} else {
	$return = "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE'];
}

$sqlCorreosContactos = "
	Select * From
		`contactos`
	Where
		`CLAVE` = '$CLAVE'
		And
		`EMAIL` <> ''
					   ";
$resCorreosContactos = DreQueryDB($sqlCorreosContactos);

$existeCorreo = mysql_num_rows(DreQueryDB($sqlCorreosContactos));

if(isset($_GET['POLIZA'])){
$tipoImg = "CARATULA";
	$sqlCalculamosArchivo = "
		Select
			`NO_ARCHIVO`
			, `EXTENSION`
			, `RUTA`
		From 
			`imagenes`
		Where
			(
				`VALOR` = '$POLIZA'
				Or
				`VALOR` = '$POLIZA_RENOVACION'
			)
			And
				`VALOR` != ''
			And
				`TIPO_IMG` = '$tipoImg'
		Order By
			`FECHA_ALTA` Desc
		Limit
			0,1
							";
	$resCalculamosArchivo = DreQueryDB($sqlCalculamosArchivo);
	$rowCalculamosArchivo = mysql_fetch_assoc($resCalculamosArchivo);
	
		$adjuntoCorreo = $rowCalculamosArchivo['NO_ARCHIVO'];
		if($adjuntoCorreo == ""){
			$txtError = "<br>";
			$txtError.= "Caratula NO ENCONTRADA !!!"; 
		}
}


if(isset($adjuntoCorreo) && $adjuntoCorreo != ""){

	$sqlInfoDocumentoAdjunto = "
		Select * From 
			`imagenes`
		Where 
			`NO_ARCHIVO` = '$adjuntoCorreo'
							   ";
	$resInfoDocumentoAdjunto = DreQueryDB($sqlInfoDocumentoAdjunto);
	$rowInfoDocumentoAdjunto = mysql_fetch_assoc($resInfoDocumentoAdjunto);
	
	if($rowInfoDocumentoAdjunto['TIPO'] == "PO"){
		$sqlConsultaDocumentos = "
			Select * From 
				`imagenes`
			Where 
				(
				`VALOR` = '$rowInfoDocumentoAdjunto[VALOR]'
				And
				`VALOR` != ''
				)
				Or
				`NO_ARCHIVO` = '$adjuntoCorreo'
								 ";
	} else {
		switch($rowInfoDocumentoAdjunto['recId']){
			case "":
			$sqlConsultaDocumentos = "
				Select * From 
					`imagenes`
				Where 
					(
					`CLIENTE_MPRO` = '$rowInfoDocumentoAdjunto[CLIENTE_MPRO]'
					And
					`TIPO` != 'PO'
					)
					And
					`recId` = ''
									 ";
			break;
		
			case !"":
			$sqlConsultaDocumentos = "
				Select * From 
					`imagenes`
				Where 
					`recId` = '$rowInfoDocumentoAdjunto[recId]'
									 ";
			break;
		}

	}
} else {
	$sqlConsultaDocumentos = "
		Select * From 
			`imagenes`
		Where
			`CLIENTE_MPRO` = '$rowInfoDocumentoAdjunto[CLIENTE_MPRO]'
							 ";
}
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td style="font-size:20px;">
        	Enviar Correo al <? echo $tipoRegistro; ?> Persona <? echo $tipoPersona; ?>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
                	<td align="left">Sucursal:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosEmpresa['SUCURSAL']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Clave:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosEmpresa['CLAVE']; ?></strong></td>
				</tr>
				<tr>
                	<td align="left">Raz&oacute;n Social / Nombre:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosEmpresa['RAZON_SOCIAL'];?></strong></td>
				</tr>
                <tr>
                	<td align="left" width="150">RFC:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['RFC'];?></strong></td>
                    <td align="left" width="80">CURP:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['CURP'];?></strong></td>
				</tr>
				<tr>
                	<td colspan="5" align="left">
					<!-- -->
                    <table width="900" cellpadding="2" cellspacing="0" border="0" style="font-size:12px;">
                    	<tr>
                        	<td width="115" align="left">Tipo Persona:</td>
                            <td align="left"><strong><?php echo $tipoPersona; ?></strong></td>
                            <td width="150" align="right">Club Cap:</td>
							<td align="left"><strong><?php echo $clubCap; ?></strong></td>
                            <td width="190" align="right">Poliza Electronica:</td>
                            <td align="left"><strong><?php echo $polizaElectronica; ?></strong></td>
						</tr>
					</table>
                    <!-- -->
                	</td>
				</tr>
                <tr>
                	<td colspan="5" align="left"><hr /></td>
				</tr>    
				<tr>
                	<td align="left">Vendedor:</td>
                    <td colspan="4" align="left"><strong><?php echo nombreVendedor($rowDatosEmpresa['VENDEDOR']); ?></strong></td>
				</tr>
                <tr>
                	<td colspan="5" align="right">
                        <input type="button" value="Regresar" class="buttonGeneral" title="Regresar al Cliente" onclick="java:window.open('<?php echo $return; ?>','_self');" />
                	</td>
                </tr>
			</table>
        	<!-- InfoEmpresa -->
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
					<td width="300" align="left">
						<a href="#CorreosCliente" onclick="mostrarOcultarDiv('CorreosCliente')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
            				&nbsp;&nbsp;&nbsp;
                        	Correos del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#CorreosCliente" onclick="mostrarOcultarDiv('CorreosCliente')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>

                </tr>
			</table>
            </div>
        </td>
    </tr>
<form name="formEnviarCorreoCliente" id="formEnviarCorreoCliente" method="post" action="includes/enviarCorreo.php?tipoEnvio=CorreoCliente">
    <tr>
    	<td>
<!-- Coreos del Cliente -->
            <div id="CorreosCliente" style="display:none;">
			<a id="CorreosCliente" name="CorreosCliente"></a>
<?php
if($existeCorreo > 0){ // Validacion Existen Correos
?>
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
<?php 
	$contIntLi = 0;
	while($rowCorreosContactos = mysql_fetch_assoc($resCorreosContactos)){
?>
            	<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td width="10">
                    	<input type="checkbox" name="paCorreo[]"  id="paCorreo[]" value="<?php echo $rowCorreosContactos['EMAIL']; ?>"/>
                	</td>
					<td width="890">
						<?
							echo $rowCorreosContactos['NOMBRE'];
							echo "&nbsp;(<strong>";
							echo $rowCorreosContactos['EMAIL'];
							echo "</strong>)&nbsp;";
						?>
                    </td>
            	</tr>
<?php
	$contIntLi++;
	}
?>
        	</table>
<?php
} else {
?>
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td>El cliente a&uacute;n no cuenta con un correo registrado</td>
                </tr>
            </table>
<?php
} // Validacion Existen Correos
?>
            </div>
<!-- Coreos del Cliente -->
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
	</tr>
<!-- Documentos Adjuntos -->
<?php
	if(isset($adjuntoCorreo) && $adjuntoCorreo != ""){
?>
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#DocumentosAdjuntos" onclick="mostrarOcultarDiv('DocumentosAdjuntos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Documentos Adjuntos del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#DocumentosAdjuntos" onclick="mostrarOcultarDiv('DocumentosAdjuntos')" class="LinkSecciondivClic" title="Click para ver detalle...">
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
    	<td>
        	<div id="DocumentosAdjuntos" <?php echo ($muestra == "DocumentosAdjuntos")? 'style="display:block;"':'style="display:none;"'; ?>>
                                	<a id="DocumentosAdjuntos" name="DocumentosAdjuntos"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="10"></td>
                    	<td width="85"><strong>No Archivo</strong></td>
                        <td width="435"><strong>Descripcion</strong></td>
                        <td width="150"><strong>Tipo Img</strong></td>
                        <td width="120"><strong>Poliza</strong></td>
                        <td width="100"><strong>Fecha</strong></td>
					</tr>
<?php 
	$contIntLi=0;
	$resConsultaDocumentos = DreQueryDB($sqlConsultaDocumentos);
	while($rowConsultaDocumentos = mysql_fetch_assoc($resConsultaDocumentos)){
		$contIntLi++;
		if(strstr($rowConsultaDocumentos['EXTENSION'],'.')){ 
			$extensionDocumento = $rowConsultaDocumentos['EXTENSION'];
		} else {
			$extensionDocumento = ".".$rowConsultaDocumentos['EXTENSION'];
		}
		if($rowConsultaDocumentos['RUTA'] == ""){
			$rutaDocumento = "/";
		} else {
			$rutaDocumento = $rowConsultaDocumentos['RUTA'];
		}
?>
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td><input type="checkbox" name="AddCorreo[]"  id="AddCorreo[]" value="<? echo $rowConsultaDocumentos['NO_ARCHIVO']; ?>" <? echo ($adjuntoCorreo == $rowConsultaDocumentos['NO_ARCHIVO'])? "checked":""; ?>/></td>
                    	<td align="justify">
                        	<font size="-1"><?php echo $rowConsultaDocumentos['NO_ARCHIVO']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowConsultaDocumentos['DESCRIPCION']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowConsultaDocumentos['TIPO_IMG']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowConsultaDocumentos['VALOR']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1">
								<?php $FECHA_ALTA = date_create($rowConsultaDocumentos['FECHA_ALTA']); ?>
								<? echo date_format($FECHA_ALTA, 'H:i:s a'); ?>
								<br>
								<? echo date_format($FECHA_ALTA, 'd-m-Y'); ?>
							</font>
						</td>
					</tr>
<?php
	}
?>

            	</table>
        	</div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
<?php
	} else {
?>
    <tr>
    	<td align="center">
			<? echo $txtError; ?>
        </td>
    </tr>
<?php
	}
?>

<!-- Documentos Adjuntos -->
<?php
	if(isset($urlComparativo) && $urlComparativo != ""){

		$urlComparativoENvia = "http://capsys.com.mx/".$urlComparativo."&idCliente=".$idCliente;
?>
    <tr>
    	<td>
            <table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="2" style="color:#273B71; text-decoration:none; font-weight:bold;">
                    	Cotizaci&oacute;n:
						<embed src="<?php echo $urlComparativo."&idCliente=".$idCliente; ?>" width="100%" height="230">
                    </td>
                </tr>
            	<tr>
                	<td>&nbsp;</td>
				</tr>
            </table>
		</td>
    </tr>
<?php
	}
?>  
    <tr>
    	<td>
            <table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="2" style="color:#273B71; text-decoration:none; font-weight:bold;">
                    	Mensaje:
                        <?php
							$tipo_toolbar = "Dre";
							$oFCKeditor = new FCKeditor('textoCorreo') ;
							$oFCKeditor->BasePath = 'fckeditor/' ;
							$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
							$oFCKeditor->Value = "";
							$oFCKeditor->Create();              
						?>
                    </td>
                </tr>
                <tr>
                	<td align="right">
                    	<input type="hidden" name="urlComparativoENvia" id="urlComparativoENvia" value="<?php echo $urlComparativoENvia; ?>" />
			        	<input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $rowDatosEmpresa['CLAVE']; ?>" />
        				<input type="button" class="buttonGeneral" value="Enviar Correo" onclick="validarEnviarCorreoCliente();"/>
                    </td>
                </tr>
        	</table>
        </td>
    </tr>
</form>
</table>