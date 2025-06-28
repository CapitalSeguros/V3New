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
		$tipoPersona = "Fisica";
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

$sqlContactosEmpresa = "
	Select * From
		`contactos`
	Where
		`CLAVE` = '$rowDatosEmpresa[CLAVE]'
					   ";
$resContactosEmpresa = DreQueryDB($sqlContactosEmpresa);

$sqlMaxContacto = "
	Select Count(`TIPO`) As `maxContacto` From 
		`contactos` 
	Where 
		`CLAVE` = '$rowDatosEmpresa[CLAVE]'
				  ";
$resMaxContacto = DreQueryDB($sqlMaxContacto);
$numeroContacto = mysql_result($resMaxContacto,0) + 1;

$sqlActividadesCliente = "
	Select
		*
		,`actividades`.`fechaCreacion` As `fechaCreacionActividades`
	From 
		`actividades`
	Where 
		`idRef` = '$rowDatosEmpresa[CLAVE]'
		And
		`recId` Not Like 'c%'
	Order By
		`fechaCreacion` Desc
						 ";
$resActividadesCliente = DreQueryDB($sqlActividadesCliente);

$sqlLlamadasCitasCliente = "
	Select
		*
		,`actividades`.`fechaCreacion` As `fechaCreacionActividades`
	From 
		`actividades`
	Where 
		`idRef` = '$rowDatosEmpresa[CLAVE]'
		And
		`recId` Like 'c%'
	Order By
		`tipo`, `fechaCreacion` Desc
						 ";
$resLlamadasCitasCliente = DreQueryDB($sqlLlamadasCitasCliente);


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
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	<?php echo $tipoRegistro; ?>
		</td>
	</tr>
	<?php
	if($agregar=="LlamadaCita"){
	?>
    <tr>
    	<td>
			<a id="LlamadaCita" name="LlamadaCita"></a>
        	<table width="900" cellpadding="2" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="5">
						<strong>Agregar Llamada o Cita</strong>
                    </td>
                </tr>
			<form name="formLlamadaCita" id="formLlamadaCita" method="post" action="includes/agregar.php?tipoAgregar=LlamadaCita">
				<tr valign="top">
                	<td width="135">
						Tipo:
                        <br>
                        <select name="tipo" id="tipo">
                        	<option value="">--Selecccione--</option>
                        	<option value="llamada">Llamada</option>
                        	<option value="cita">Cita</option>
                        </select>
                    </td>
                	<td colspan="3">
                    	Comentario:
                        <br>
                    	<textarea name="comentario" id="comentario" style="width:100%"></textarea>
                    </td>
                	<td width="60" align="center">
                        <input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarAgregarLlamadaCita();"/>
                        <input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE']; ?>','_self');"/>
                    </td>
                </tr>
				<tr valign="top">
                	<td colspan="5"><hr style="border:double 1px #000000;"></td>
				</tr>
                <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $CLAVE; ?>" />
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $Usuario; ?>" /> 
                <input type="hidden" name="promotor" id="promotor" value="<?php echo $Promotor; ?>" /> 
                <input type="hidden" name="SUCURSAL" id="SUCURSAL" value="<?php echo $Sucursal; ?>" /> 
                <input type="hidden" name="VENDEDOR" id="VENDEDOR" value="<?php echo $Vendedor; ?>" />                 
                </form>
        	</table>
        </td>
    </tr>
    <?php
	}
	?>
	<tr>
		<td valign="top" align="right">
<!-- cliente.php?CLAVE=0000046709&agregar=CONTACTO3&muestra=Contactos#agregar -->        
        	<a href="<?php echo "cliente.php?CLAVE=".$CLAVE."&agregar=LlamadaCita&muestra=LlamadaCita#LlamadaCita"; ?>" title="Llamada - Cita" style="text-decoration:none"><img src="img/transparente.fw.png" class="system LlamadaCita" alt="enviarCorreo" border="0"/></a>
			&nbsp;
        	<a href="<?php echo "clienteEnviarCorreo.php?CLAVE=".$CLAVE; ?>" title="Enviar Correo Cliente" style="text-decoration:none"><img src="img/transparente.fw.png" class="system enviarCorreo" alt="enviarCorreo" border="0"/></a>
        	<a href="<?php echo "clienteDocumentos.php?CLAVE=".$CLAVE; ?>" title="Documentos Cliente" style="text-decoration:none"><img src="img/transparente.fw.png" class="system documentos" alt="documentos" border="0"/></a>
            &nbsp;
        	<a href="<?php echo "clienteEditar.php?CLAVE=".$CLAVE; ?>" title="Editar Cliente" style="text-decoration:none"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
			<?php require('require/semaforoEmpresas.php'); ?>
            <font style="font-size:12px; font-weight:bold;" >
	            <?php if($rowDatosEmpresa['RANKING'] != ""){ echo $rowDatosEmpresa['RANKING']; } ?>
            </font>
            &nbsp;
            <font style="font-size:10px; font-weight:bold;">
	            Puntos [<? echo puntosClub($rowDatosEmpresa['CLAVE']); ?>]
            </font>
        </td>
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
                	<td align="left">Calle:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosEmpresa['CALLE']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">No. Ext:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['NOEXTERIOR']; ?></strong></td>
                    <td align="left">No. Int:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['NOINTERIOR']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Colonia:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['COLONIA']; ?></strong></td>
                    <td align="left">CP:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['CODIGO_POSTAL']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Referencia:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['REFERENCIA']; echo $rowDatosEmpresa['REFERENCIA2']; ?></strong></td>
                    <td align="left">Tel Casa:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['TELEFONO_PARTICULAR']; ?></strong></td>
				</tr>
                <tr>
	                <td align="left">Localidad:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['LOCALIDAD']; ?></strong></td>
                    <td align="left">Tel Trabajo:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['TELEFONO_OFICINA']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Municipio:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['MUNICIPO']; ?></strong></td>
                    <td align="left">Celular:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['TELEFONO_MOVIL']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Estado:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosEmpresa['ESTADO']; ?></strong></td>
                    <td align="right">&nbsp;</td>
                    <td align="left">&nbsp;</td>
				</tr>
                <tr>
                	<td colspan="5"><hr /></td>
				</tr>
                <tr>
                	<td align="left">Fecha Nacimiento:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['FECHA_NACIMIENTO']; ?></strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
				</tr>
				<tr>
                	<td align="left">Nacionalidad:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['NACIONALIDAD']; ?></strong></td>
                    <td align="right">&nbsp;</td>
                    <td align="left">Edad:</td>
                    <td><strong><?php echo calculaedad($rowDatosEmpresa['FECHA_NACIMIENTO']);//echo $rowDatosEmpresa['EDAD']; ?></strong></td>
				</tr>
				<tr>
                	<td align="left">Nivel Estudios:</td>
                    <td align="left"><strong><?php echo $rowDatosEmpresa['NIVEL_ESTUDIOS']; ?></strong></td>
                    <td align="right">&nbsp;</td>
                    <td align="left">Edo Civil:</td>
                    <td><strong><?php echo $rowDatosEmpresa['ESTADO_CIVIL']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Automovil:</td>
                    <td align="left"><strong><?php echo $automovil; ?></strong></td>
                    <td align="right">&nbsp;</td>
                    <td align="left">Genero:</td>
					<td><strong><?php echo $genero; ?></strong></td>
				</tr>
                <tr>
                	<td colspan="5">
                    <hr />
                    </td>
				</tr>
				<tr>
                	<td align="left">Vendedor:</td>
                    <td colspan="4" align="left"><strong><?php echo nombreVendedor($rowDatosEmpresa['VENDEDOR']); ?></strong></td>
				</tr>
<?php
	if(isset($regreso) && $regreso != ""){
?>
                <tr>
                	<td colspan="5" align="right">
                        <input type="button" value="Regresar" class="buttonGeneral" title="Regresar al Cliente" onclick="java:window.open('<?php echo $return; ?>','_self');" />
                	</td>
                </tr>
<?php
	}
?>
			</table>
            <!-- InfoEmpresa -->
        </td>
	<tr>
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
						<a href="#Contactos" onclick="mostrarOcultarDiv('Contactos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Contactos del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#Contactos" onclick="mostrarOcultarDiv('Contactos')" class="LinkSecciondivClic" title="Click para ver detalle...">
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
        	<div id="Contactos" <?php echo ($muestra == "Contactos")? 'style="display:block;"':'style="display:none;"'; ?>>
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="5" align="right">
                    	<?php
							$urlAgregarContacto = $_SERVER['PHP_SELF']."?CLAVE=".$CLAVE."&agregar=CONTACTO".$numeroContacto."&muestra=Contactos#agregar";
						?>
                    	<a href="<? echo $urlAgregarContacto ?>" title="Agregar Contactos"><img src="img/transparente.fw.png" class="system agregar" alt="agregar" border="0"/></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            	<tr>
                	<td colspan="5">&nbsp;</td>
				</tr>
<?php
	if(isset($agregar) && $agregar != ""){
?>
                    	<a id="agregar" name="agregar"></a>
		<form name="formAgregarContacto" id="formAgregarContacto" method="post" action="includes/agregar.php?tipoAgregar=Contacto">
            	<tr>
                	<td>Nombre:</td>
                	<td colspan="3" align="left">
                    	<input type="text" name="NOMBRE" id="NOMBRE" style="width:100%;" />
                    </td>
                	<td align="right">
                        <input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarAgregarContacto();"/>
                        <!-- JavaScript: document.formAgregarContacto.submit(); -->
                        <input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE']; ?>','_self');"/>
                    </td>
                </tr>
            	<tr>
                	<td width="70">Email:</td>
                	<td width="330">
                    	<input type="text" name="EMAIL" id="EMAIL" style="width:100%;" />
                    </td>
                	<td width="70">Tel&eacute;fono:</td>
                	<td width="330">
                    	<input type="text" name="TELEFONO" id="TELEFONO" style="width:100%" />
                    </td>
                	<td width="100">&nbsp;</td>
                </tr>
				<tr>
                	<td>Direcci&oacute;n:</td>
                	<td colspan="3" align="left">
                    	<textarea name="DIRECCION" id="DIRECCION" style="width:100%"></textarea>
                    </td>
                	<td>&nbsp;</td>
                </tr>
				<tr>
                	<td colspan="4">
                    	Correo Masivo:
                        Si<input type="radio" name="correoMasivo" id="correoMasivo" value="1" />
                        No<input type="radio" name="correoMasivo" id="correoMasivo" value="2" />
                    </td>                    
                	<td>&nbsp;</td>
                </tr>
                <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $CLAVE; ?>" />
                <input type="hidden" name="TIPO" id="TIPO" value="<?php echo $agregar; ?>" /> 
                <input type="hidden" name="promotor" id="promotor" value="<?php echo $Promotor; ?>" /> 
                <input type="hidden" name="SUCURSAL" id="SUCURSAL" value="<?php echo $Sucursal; ?>" /> 
                <input type="hidden" name="VENDEDOR" id="VENDEDOR" value="<?php echo $Vendedor; ?>" /> 
                
		</form>
            	<tr>
                	<td colspan="5"><hr></td>
				</tr>
            	<tr>
                	<td colspan="5">&nbsp;</td>
				</tr>
<?php
	}
?>
                    	<a id="Contactos" name="Contactos"></a>
<?php
	while($rowContactosEmpresa = mysql_fetch_assoc($resContactosEmpresa)){
		switch($rowContactosEmpresa['correoMasivo']){
			case 1:
				$correoMasivo = "Si"; 
			break;
	 
			case 0:
				$correoMasivo = "No"; 
			break; 
		} 

?>
				<tr>
                	<td colspan="5">
                    	<a id="<?php echo $rowContactosEmpresa['TIPO']; ?>" name="<?php echo $rowContactosEmpresa['TIPO']; ?>"></a>
                    </td>
                </tr>
<?php
		if($rowContactosEmpresa['idContacto'] != $editar){
?>
            	<tr>
                	<td>Nombre:</td>
                	<td colspan="3" align="left"><strong><?php echo $rowContactosEmpresa['NOMBRE']; ?></strong></td>
                	<td align="right">
                    	<?php
                    		$urlEditarContacto = $_SERVER['PHP_SELF']."?CLAVE=".$CLAVE."&editar=".$rowContactosEmpresa['idContacto']."&muestra=Contactos#".$rowContactosEmpresa['TIPO'];
						?>
						<a href="<? echo $urlEditarContacto; ?>" title="Editar Contacto"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
                    </td>
                </tr>
            	<tr>
                	<td width="70">Email:</td>
                	<td width="330"><strong><? echo $rowContactosEmpresa['EMAIL']; ?></strong></td>
                	<td width="70">Tel&eacute;fono:</td>
                	<td width="330"><strong><? echo $rowContactosEmpresa['TELEFONO']; ?></strong></td>
                	<td width="100">&nbsp;</td>
                </tr>
				<tr>
                	<td>Direcci&oacute;n:</td>
                	<td colspan="3" align="left"><strong><?php echo $rowContactosEmpresa['DIRECCION']; ?></strong></td>
                	<td>&nbsp;</td>
                </tr>
				<tr>
                	<td colspan="4">
                    	Correo Masivo:
						<strong><?php echo $correoMasivo; ?></strong>
                    </td>
                	<td>&nbsp;</td>
                </tr>
<?php
		} else if($rowContactosEmpresa['idContacto'] == $editar){
?>
		<form name="formEditarContacto" id="formEditarContacto" method="post" action="includes/editar.php?tipoEdicion=Contacto">
            	<tr>
                	<td>Nombre:</td>
                	<td colspan="3" align="left">
                    	<input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $rowContactosEmpresa['NOMBRE']; ?>" style="width:100%;" />
                    </td>
                	<td align="right">
                        <input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarEditarContacto();"/>
                        <!-- JavaScript: document.formEditarContacto.submit(); -->
                        <input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE']."&muestra=Contactos#".$rowContactosEmpresa['TIPO']; ?>','_self');"/>
                        
                    </td>
                </tr>
            	<tr>
                	<td width="70">Email:</td>
                	<td width="330">
                    	<input type="text" name="EMAIL" id="EMAIL" value="<? echo $rowContactosEmpresa['EMAIL']; ?>" style="width:100%;" />
                    </td>
                	<td width="70">Tel&eacute;fono:</td>
                	<td width="330">
                    	<input type="text" name="TELEFONO" id="TELEFONO" value="<? echo $rowContactosEmpresa['TELEFONO']; ?>" style="width:100%" />
                    </td>
                	<td width="100">&nbsp;</td>
                </tr>
				<tr>
                	<td>Direcci&oacute;n:</td>
                	<td colspan="3" align="left">
                    	<textarea name="DIRECCION" id="DIRECCION" style="width:100%">
							<?php echo $rowContactosEmpresa['DIRECCION']; ?>
                        </textarea>
                    </td>
                	<td>&nbsp;</td>
                </tr>
				<tr>
                	<td colspan="4">
                    	Correo Masivo:
                        Si<input type="radio" name="correoMasivo" id="correoMasivo" value="1" <? echo ($rowContactosEmpresa['correoMasivo'] == 1)? "checked":""; ?> />
                        No<input type="radio" name="correoMasivo" id="correoMasivo" value="2" <? echo ($rowContactosEmpresa['correoMasivo'] == 0)? "checked":""; ?>/>
                    </td>                    
                	<td>&nbsp;</td>
                </tr>
                <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $CLAVE; ?>" />
                <input type="hidden" name="idContacto" id="idContacto" value="<?php echo $rowContactosEmpresa['idContacto']; ?>" />
                <input type="hidden" name="TIPO" id="TIPO" value="<?php echo $rowContactosEmpresa['TIPO']; ?>" />                
		</form>
<?php			
		}
?>
                <tr>
                	<td colspan="5"><hr></td>
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
<!-- -->
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#Actividades" onclick="mostrarOcultarDiv('Actividades')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Actividades del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#Actividades" onclick="mostrarOcultarDiv('Actividades')" class="LinkSecciondivClic" title="Click para ver detalle...">
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
        	<div id="Actividades" <?php echo ($muestra == "Actividades")? 'style="display:block;"':'style="display:none;"'; ?>>
                                	<a id="Actividades" name="Actividades"></a>
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="6">&nbsp;</td>
                </tr>
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td>Folio</td>
                	<td>Fecha<br>Creaci&oacute;n</td>
                	<td>Actividad</td>
                	<td>Ramo</td>
                	<td>Semaforo</td>
                	<td>Status</td>
                </tr>
<?php
	$contIntLi = 0;
	while($rowActividadesCliente = mysql_fetch_assoc($resActividadesCliente)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td>
                    	<a href="<?php echo "actividadesDetalle.php?recId=".$rowActividadesCliente['recId']."&regreso=cliente"; ?>" title="Clic Ver M&aacute;s" style="text-decoration:none; color:#000;">
                        <strong><?php echo $rowActividadesCliente['recId']; ?></strong>
                        </a>
                    </td>
                	<td>
                    <?php
						$fecha = date_create($rowActividadesCliente['fechaCreacionActividades']);
						echo date_format($fecha, 'd-m-Y');
						echo "<br />";
						echo date_format($fecha, 'H:i:s a');
					?>
                    </td>
                	<td><?php echo urldecode($rowActividadesCliente['actividadInterno']); ?></td>
                	<td><?php echo urldecode($rowActividadesCliente['ramoInterno']); ?></td>
                	<td><?php echo DreSemaforoActividad($rowActividadesCliente['idInterno']); ?></td>
                	<td><?php echo ($rowActividadesCliente['fin'] == 1)? " Terminada " : " Proceso "; ?></td>
                </tr>
<?php
	$contIntLi++;
	}
?>
            </table>
            </div>
    	</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
<!-- -->
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#LlamadasCitas" onclick="mostrarOcultarDiv('LlamadasCitas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Llamadas-Citas del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#LlamadasCitas" onclick="mostrarOcultarDiv('LlamadasCitas')" class="LinkSecciondivClic" title="Click para ver detalle...">
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
        	<div id="LlamadasCitas" <?php echo ($muestra == "LlamadasCitas")? 'style="display:block;"':'style="display:none;"'; ?>>
                                	<a id="LlamadasCitas" name="LlamadasCitas"></a>
        	<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="4">&nbsp;</td>
                </tr>
            	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
            	  <td width="50">Folio</td>
                	<td width="60">Tipo</td>
                	<td width="100">Fecha<br></td>
                	<td >Comentario</td>
               	</tr>
<?php
	$contIntLi = 0;
	while($rowLlamadasCitasCliente = mysql_fetch_assoc($resLlamadasCitasCliente)){
?>
                <tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                	<td>
                        <strong><?php echo $rowLlamadasCitasCliente['recId']; ?></strong>                        
                    </td>
                	<td>
                    	<?php echo $rowLlamadasCitasCliente['tipo']; ?>
                    </td>
                	<td>
                    <?php
						$fecha = date_create($rowLlamadasCitasCliente['fechaCreacionActividades']);
						echo date_format($fecha, 'd-m-Y');
						echo "<br />";
						echo date_format($fecha, 'H:i:s a');
					?>
                    </td>
                	<td style="text-align:justify"><?php echo $rowLlamadasCitasCliente['referencia']; ?></td>
               	</tr>
<?php
	$contIntLi++;
	}
?>
            </table>
            </div>
    	</td>
    </tr>
</table>