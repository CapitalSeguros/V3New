<?php
if(isset($CLAVE) && $CLAVE != ""){
	$sqlDatosEmpresa = "
		Select 
			*
		From 
			`empresas`
		Where 

			`empresas`.`CLAVE` = '$_REQUEST[CLAVE]'
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

$sqlTipoImg = "
	Select * From 
		`tiposdoctos` 
			  ";
$resTipoImg = DreQueryDB($sqlTipoImg);

// Consultas Imagenes Tipo de Documentacion
//-- 1 --//	
	$sqlDocumentosCliente = "
		Select * From
			`imagenes`
		Where
			(
				`CLIENTE_MPRO` = '$CLAVE'
				And 
				`TIPO` = 'CL'
			)
			And
			`recId` = ''
		Order By
			`TIPO_IMG` Asc
							";
	$ExitenDocumentosCliente = mysql_num_rows(DreQueryDB($sqlDocumentosCliente));
							
//-- 2 --//	
	$sqlDocumentosActividades = "
		Select 
			`imagenes`.`NO_ARCHIVO`
			,`imagenes`.`EXTENSION`
			,`imagenes`.`RUTA`
			,`imagenes`.`DESCRIPCION`
			,`imagenes`.`TIPO`
			,`imagenes`.`POLIZA`
			,`imagenes`.`VALOR`
			,`imagenes`.`TIPO_IMG`
			,`imagenes`.`ESTATUS`
			,`imagenes`.`CLIENTE_MPRO`
			,`imagenes`.`CLIENTE_TMP`
			,`imagenes`.`NOMBRE_CLIENTE`
			,`imagenes`.`FECHA_ALTA`
			,`imagenes`.`SUCURSAL`
			,`imagenes`.`recId`
			,`imagenes`.`idUsuario`
--			,`actividades`.`actividad`
		From
			`imagenes`
/*
			Inner Join `actividades` 
			On
			`imagenes`.`recId` = `actividades`.`recId`
*/
		Where
			(
			`imagenes`.`CLIENTE_MPRO` = '$CLAVE'
			And 
			`imagenes`.`TIPO` <> 'PO'
			)
			And 
				`imagenes`.`recId` <> ''
		Group By 
			`imagenes`.`recId`
		Order By
			`imagenes`.`TIPO_IMG` Asc
							";
	$ExitenDocumentosActividad = mysql_num_rows(DreQueryDB($sqlDocumentosActividades));
								
//-- 3 --//
	$sqlDocumentosPolizas = "
		Select * From
			`imagenes`
		Where
			( 
				(
				`CLIENTE_MPRO` = '$CLAVE'
				And 
				`TIPO` = 'PO'
				)
--				And 
--				`recId` = ''
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
			`subRamo`, `VALOR` Asc
							";
	$ExitenDocumentosPoliza = mysql_num_rows(DreQueryDB($sqlDocumentosPolizas));
/*	
	echo "<pre>";
		echo "&bull;DatosEmpresa<br>";
		echo $sqlDatosEmpresa;
		//echo "&bull;Actividad:<br>";
		//echo $sqlDocumentosActividad;
		echo "&bull;Actividades:<br>";
		echo $sqlDocumentosActividades;
		echo "&bull;Cliente:<br>";
		echo $sqlDocumentosCliente;
		echo "&bull;Polizas:<br>";
		echo $sqlDocumentosPolizas;
	echo "</pre>";
*/
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td style="font-size:20px;">
        	Documentos del <? echo $tipoRegistro; ?> Persona <? echo $tipoPersona; ?>
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
                        <input type="button" value="Regresar" class="buttonGeneral" title="Regresar al Cliente" onclick="java:window.open('<?php echo "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE']; ?>','_self');" />
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
                	<td align="left" class="TextoTitulosSecciondivClic">
            			&nbsp;&nbsp;&nbsp;
                        Agregar Documentos al <? echo $tipoRegistro; ?>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
<form name="formAddDocumentos" id="formAddDocumentos" method="post" enctype="multipart/form-data" action="includes/agregar.php?tipoAgregar=Documentos" />
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
            	<tr>
                	<td width="150">Poliza:</td>
					<td width="750">
                    	<input type="text" name="POLIZA" id="POLIZA" maxlength="99" style="width:50%"/>
                    </td>
                </tr>
            	<tr>
                	<td>Descripci&oacute;n:</td>
                	<td>
                    	<input type="text" name="DESCRIPCION" id="DESCRIPCION" maxlength="299" style="width:100%"/>
                    </td>
                </tr>
            	<tr>
                	<td>Tipo de Documento:</td>
                	<td>
						<select name="TIPO_IMG" id="TIPO_IMG" style="width:50%">
							<option value="">-- Seleccione  --</option>
	                        <?php
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
                </tr>
            	<tr>
                	<td>Archivo:</td>
                	<td>
                    	<input name="archivo" type="file" id="archivo" />
                    </td>
                </tr>
                <tr>
                	<td colspan="2" align="right">
                    	<input type="hidden" name="extension" id="extension" />
                    	<input type="hidden" name="CLIENTE_MPRO" id="CLIENTE_MPRO" value="<? echo $CLAVE ?>" />
                    	<input type="hidden" name="CLIENTE_TMP" id="CLIENTE_TMP" value="<? echo $CLAVE ?>" />
                    	<input type="hidden" name="SUCURSAL" id="SUCURSAL" value="<? echo $rowDatosEmpresa['SUCURSAL'] ?>" />
                        <input type="button" value="Agregar" class="buttonGeneral" title="Agregar Documento" onclick="validarAddDocumento()" />
        <!-- -->
      </td>
	  </tr>
</table>
</form>
        	<!-- DocumentosAgregar -->
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
            			&nbsp;&nbsp;&nbsp;
						<a href="#Documentos" onclick="mostrarOcultarDiv('Documentos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Ver Documentos del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#Documentos" onclick="mostrarOcultarDiv('Documentos')" class="LinkSecciondivClic" title="Click para ver detalle...">
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
<!-- Documentos -->
            <div id="Documentos" <?php echo ($muestraPrincipal == "Documentos")? 'style="display:block;"':'style="display:none;"'; ?>>
            <br>
            <!-- 1 Inicio -->
            	<a href="#DocumentosCliente" onclick="mostrarOcultarDiv('DocumentosCliente')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Documentos del Cliente
				</font>
				</a>
            	<div id="DocumentosCliente" style="display:none;">
<?php
	if($ExitenDocumentosCliente <= 0){
		//echo "NO Existen Documentos de Este Tipo";
?>
                <a id="DocumentosCliente" name="DocumentosCliente"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
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
                <a id="DocumentosCliente" name="DocumentosCliente"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                    	<td width="85"><strong>No Archivo</strong></td>
                        <td width="325"><strong>Descripcion</strong></td>
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
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                    	<td align="justify">
                        	<font size="-1"><?php echo $rowDocumentosCliente['NO_ARCHIVO']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowDocumentosCliente['DESCRIPCION']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowDocumentosCliente['TIPO_IMG']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowDocumentosCliente['ESTATUS']; ?></font>
						</td>
                        <td align="justify">
                        	<font size="-1"><?php echo $rowDocumentosCliente['FECHA_ALTA']; ?></font>
						</td>
                        <td align="center">
                        	<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosCliente['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
                        		<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
                            </a>
                        </td>
                        <td align="center">
                        	<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowDocumentosCliente['CLIENTE_MPRO']."&adjuntoCorreo=".$rowDocumentosCliente['NO_ARCHIVO']."&regreso=clienteDocumentos"; ?>" target="_self" title="Clic Enviar">
                        		<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
                        	</a>
                        </td>
						</tr>
<?php
	}
?>
              		</table>
<?php
	} // Fin del If ExistenDocumentosCliente
?>
            	</div>
            <!-- 1 Fin -->
            	<br><br>
            <!-- 2 Inicio -->
            	<a href="#DocumentosActividad" onclick="mostrarOcultarDiv('DocumentosActividad')" class="linkDiv" style="text-decoration:none;" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Documentos de las Actividades
				</font>
				</a>
            	<div id="DocumentosActividad" style="display:none;">
                
<?php
	if($ExitenDocumentosActividad <= 0){
		//echo "NO Existen Documentos de Este Tipo";
?>
                <a id="DocumentosActividad" name="DocumentosActividad"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                    	<tr>
                        	<td style="font-size:12px; color:#00397E;">
                            	<strong>AUN NO CONTAMOS CON DOCUMENTACI&Oacute;N DE LA ACTIVIDAD</strong>
                                <br>
                            </td>
                        </tr>
                    </table>
<?php
	} else {
		$resDocumentosActividades = DreQueryDB($sqlDocumentosActividades);
		while($rowDocumentosActividades = mysql_fetch_assoc($resDocumentosActividades)){ // Recorrido por las Polizas del Cliente
			$actividad = $rowDocumentosActividades['recId'];
			
?>
                <font style="color:#273B71; text-decoration:none; font-size:14px;">
                   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;<strong>Actividad:</strong>
					<? 
						echo $actividad."&nbsp;[";
						DreActividadActividad($rowDocumentosActividades['recId']);
						echo "]"; 
					?>
                    <!-- <strong>Ramo:</strong> -->
				</font>
            	<a id="DocumentosActividad" name="DocumentosActividad"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                        	<td width="85"><strong>No Archivo</strong></td>
                        	<td width="325"><strong>Descripcion</strong></td> <!-- width="325" --> 
                            <td width="160"><strong>Tipo Img</strong></td>
                            <td width="60"><strong>Estatus</strong></td>
                            <td width="150"><strong>Fecha</strong></td>
                            <td width="60" align="center"><strong>Archivo</strong></td>
                            <td width="60" align="center"><strong>Enviar</strong></td>
						</tr>
<?php 
	$contIntLi=0;
	$sqlDocumentosActividad = "
		Select * From
			`imagenes`
		Where
			(
				(
					`CLIENTE_MPRO` = '$CLAVE'
					And 
					`TIPO` <> 'PO'
				)
				And 
					`recId` <> ''
			)
			And
				`recId` = '$actividad'
		Order By
			`TIPO_IMG` Asc
						   ";
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
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosActividad['NO_ARCHIVO']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosActividad['DESCRIPCION']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosActividad['TIPO_IMG']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosActividad['ESTATUS']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosActividad['FECHA_ALTA']; ?></font>
                            </td>
							<td align="center">
								<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosActividad['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
                            	<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
								</a>
							</td>
							<td align="center">
								<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowDocumentosActividad['CLIENTE_MPRO']."&adjuntoCorreo=".$rowDocumentosActividad['NO_ARCHIVO']."&regreso=clienteDocumentos"; ?>" target="_self" title="Clic Enviar">
                            	<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
                                </a>
							</td>
						</tr>
<?php
	}
?>
						<tr>
                        	<td>&nbsp;</td>
                        </tr>
              		</table>
<?php
		}
		}
?>
				</div>
		<!-- 2 Fin -->
               <br><br>
		<!-- 3 Inicio -->
				<a href="#DocumentosPoliza" onclick="mostrarOcultarDiv('DocumentosPoliza')" class="linkDiv" style="text-decoration:none" title="Click para ver detalle...">
                <font style="color:#273B71; text-decoration:none; font-weight:bold;">
                	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;Documentos de las Polizas
				</font>
				</a>
            	<div id="DocumentosPoliza" <?php echo ($muestra == "DocumentosPoliza")? 'style="display:block;"':'style="display:none;"'; ?>>
<?php
	if($ExitenDocumentosPoliza <= 0){
		//echo "NO Existen Documentos de Este Tipo";
?>
            	<a id="DocumentosPoliza" name="DocumentosPoliza"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr>
                    	<td style="font-size:12px; color:#00397E;">
                        	<strong>AUN NO CONTAMOS CON DOCUMENTACI&Oacute;N DE LAS POLIZAS</strong>
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
                                <input type="hidden" name="CLAVE" id="CLAVE" value="<? echo $CLAVE; ?>" />
                                <input type="hidden" name="muestraPrincipal" id="muestraPrincipal" value="Documentos" />
                                <input type="hidden" name="muestra" id="muestra" value="DocumentosPoliza" />
                		        <input type="submit" value="Buscar Poliza" />
							</form>
                        </blockquote>
	                    </td>
                    </tr>
				</table>
<?php
		//echo "<pre>";
			//echo $sqlDocumentosPolizas;
		//echo "</pre>";

		$resDocumentosPolizas = DreQueryDB($sqlDocumentosPolizas);
		while($rowDocumentosPolizas = mysql_fetch_assoc($resDocumentosPolizas)){ // Recorrido por las Polizas del Cliente
			$poliza = $rowDocumentosPolizas['VALOR'];
?>
                <font style="color:#273B71; text-decoration:none;">
                   	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&bull;<strong>Poliza:</strong> <? echo $poliza; echo "&nbsp;&nbsp;["; DreRamoPoliza($poliza); echo "]"; ?>
                    <!-- <strong>Ramo:</strong> -->
				</font>
            	<a id="DocumentosPoliza" name="DocumentosPoliza"></a>
            	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold; font-size:12px;">
                            <td width="60" align="center"><strong>Archivo</strong></td>
                            <td width="60" align="center"><strong>Enviar</strong></td>
                            <td width="160"><strong>Tipo Img</strong></td>
                        	<td width="385"><strong>Descripcion</strong></td> <!-- width="325" --> 
                            <td width="150"><strong>Fecha</strong></td>
                        	<td width="85"><strong>No Archivo</strong></td>
						</tr>
<?php 
	$contIntLi=0;
	$sqlDocumentosPoliza = "
		Select * From
			`imagenes`
		Where
			(
				(
					`CLIENTE_MPRO` = '$CLAVE'
					And 
					`TIPO` = 'PO'
				)
--				And 
--					`recId` = ''
			)
			And
				`VALOR` = '$poliza'
		Order By
			`TIPO_IMG` Asc
						   ";
	$resDocumentosPoliza = DreQueryDB($sqlDocumentosPoliza);
	//echo "<pre>";
		//echo "&bull;->";
		//echo $sqlDocumentosPoliza;
	//echo "</pre>";
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
					<tr bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>" style="font-size:10px;">
							<td align="center">
								<a href="<?php echo tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosPoliza['NO_ARCHIVO'].$extensionDocumento; ?>" target="_blank" title="Clic Descargar">
                            	<img src="img/transparente.fw.png" class="system archivo" alt="archivo" border="0"/>
								</a>
							</td>
							<td align="center">
								<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$rowDocumentosPoliza['CLIENTE_MPRO']."&adjuntoCorreo=".$rowDocumentosPoliza['NO_ARCHIVO']."&regreso=clienteDocumentos"; ?>" target="_self" title="Clic Enviar">
                            	<img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/>
                                </a>
							</td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosPoliza['TIPO_IMG']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosPoliza['DESCRIPCION']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosPoliza['FECHA_ALTA']; ?></font>
                            </td>
                            <td align="justify">
                            	<font size="-1"><?php echo $rowDocumentosPoliza['NO_ARCHIVO']; ?></font>
                            </td>
						</tr>
<?php
	}
?>
						<tr>
                        	<td>&nbsp;</td>
                        </tr>
              		</table>
<?php
		}
	} // Fin del If ExistenDocumentosCliente
?>
<!-- Documentos -->
</div>
        </td>
    </tr>
</table>