<?php
$sqlDanos = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resDanos = DreQueryDB($sqlDanos);
$rowDanos = mysql_fetch_assoc($resDanos);
?>
<br />
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar">
        	Proteccion Bienes Empresas
		</td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">
	<tr>
	  <td width="150" align="right">Moneda:</td>
	  <td><?php echo SelectTipoMoneda($rowDanos['moneda'],$rowDatosFormulario['estatus'],'moneda'); ?></td>
  </tr>
	<tr>
	  <td align="right">Forma pago:</td>
	  <td><?php echo SelectFormaPago($rowDanos['forma_pago'],$rowDatosFormulario['estatus'], ''); ?></td>
  </tr>
<!-- Nuevo campo-->
<tr>
	  <td align="right">Tipo persona:</td>
	  <td><?php echo SelectPersonaTipo($rowDanos['persona_tipo'],$rowDatosFormulario['estatus']); ?></td>
  </tr>
<!-- Nuevo campo--> 
	<tr>
	  <td align="right">No de Empleados:</td>
	  <td><input name="no_empleados" type="text" id="no_empleados" value="<?php echo $rowDanos['no_empleados'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
<!-- Nuevos campos-->    
    <tr>
	  <td align="right">Nombre:</td>
	  <td><input name="nombre" type="text" id="nombre" value="<?php echo $rowDanos['nombre'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Apellido paterno:</td>
	  <td><input name="apellido_paterno" type="text" id="apellido_paterno" value="<?php echo $rowDanos['apellido_paterno'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Apellido materno:</td>
	  <td><input name="apellido_materno" type="text" id="apellido_materno" value="<?php echo $rowDanos['apellido_materno'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Sexo:</td>
	  <td>
		<?php echo SelectSexo($rowDanos['sexo'],$rowDatosFormulario['estatus'],'sexo'); ?>
	  </td>
    </tr>
    <tr>
	  <td align="right">Rfc:</td>
	  <td><input name="rfc" type="text" id="rfc" value="<?php echo $rowDanos['rfc'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Fecha nac.:</td>
	  <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $rowDanos['fecha_nacimiento'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?> readonly/>
      <img src="img/cal.gif" id="fecha_nacimiento_Btn"  title="Clic">
      </td>
    </tr>
     <tr>
	  <td align="right">Curp:</td>
	  <td><input name="curp" type="text" id="curp" value="<?php echo $rowDanos['curp'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Calle:</td>
	  <td><input name="calle" type="text" id="calle" value="<?php echo $rowDanos['calle'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">No. Int.:</td>
	  <td><input name="noint" type="text" id="noint" value="<?php echo $rowDanos['num_interior'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">No. Ext.:</td>
	  <td><input name="noext" type="text" id="noext" value="<?php echo $rowDanos['num_exterior'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
     <tr>
	  <td align="right">Colonia:</td>
	  <td><input name="colonia" type="text" id="colonia" value="<?php echo $rowDanos['colonia'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
     <tr>
	  <td align="right">Ciudad:</td>
	  <td><input name="ciudad" type="text" id="ciudad" value="<?php echo $rowDanos['ciudad'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Estado:</td>
	  <td><?php echo SelectEstado($rowDanos['estado'],$rowDatosFormulario['estatus']); ?></td>
  </tr>
     <tr>
	  <td align="right">Poblacion:</td>
	  <td><input name="poblacion" type="text" id="poblacion" value="<?php echo $rowDanos['poblacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">C.p.:</td>
	  <td><input name="codigo_postal" type="text" id="codigo_postal" value="<?php echo $rowDanos['codigo_postal'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">Telefono:</td>
	  <td><input name="telefono" type="text" id="telefono" value="<?php echo $rowDanos['tel'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
    <tr>
	  <td align="right">E-mail:</td>
	  <td><input name="email" type="text" id="email" value="<?php echo $rowDanos['email'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
<!-- Nuevos campos-->    
	<tr>
	  <td align="right">Niveles:</td>
	  <td><input name="numero_pisos" type="text" id="numero_pisos" value="<?php echo $rowDanos['numero_pisos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Sotanos:</td>
	  <td><input name="numero_sotanos" type="text" id="numero_sotanos" value="<?php echo $rowDanos['numero_sotanos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Muro:</td>
	  <td><?php echo SelectMuro($rowDanos['muro'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Techos:</td>
	  <td><?php echo SelectTecho($rowDanos['techo'],$rowDatosFormulario['estatus']); ?></td>
    </tr>
	<tr>
	  <td align="right">Sector:</td>
	  <td>
      <?php echo SelectTipoSector($rowDanos['sector'],$rowDatosFormulario['estatus']); ?></td>
    </tr>
	<tr>
	  <td align="right">Giro tarifa:</td>
	  <td><?php  echo SelectGiroTarifa($rowDanos['giro_tarifa'],$rowDatosFormulario['estatus']); ?></td>
    </tr>
	<tr>
	  <td align="right">Giro Negocio:</td>
	  <td><input name="giro_negocio" type="text" id="giro_negocio" value="<?php echo $rowDanos['giro_negocio'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
<!--- Nuevos campo -->
    <tr>
	  <td align="right">Edificio $:</td>
	  <td><input name="dinero_edificio" type="text" id="dinero_edificio" value="<?php echo $rowDanos['dinero_edificio'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
        <tr>
	  <td align="right">Contenidos $:</td>
	  <td><input name="robo_contenidos" type="text" id="robo_contenidos" value="<?php echo $rowDanos['robo_contenidos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
        <tr>
	  <td align="right">Mobiliario y equipo de oficina:</td>
	  <td><input name="mobiliario_equipo" type="text" id="mobiliario_equipo" value="<?php echo $rowDanos['mobiliario_equipo'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
<!--- Nuevos campo -->
	  <td colspan="2">Observaciones:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>><?php echo $rowDanos['observaciones'] ?></textarea>
      </td>
  </tr>
<!--- prueba de los nuevos de daños--->
<?php
if($rowDatosFormulario['estatus'] == 1){ 
	$sql = "SELECT * FROM configdre where parametro=\"coberturasAdicionales\" ORDER BY titulo ASC";
	$res = mysql_query($sql) or die(mysql_error());	
?>
<tr>
		<td colspan="2" class="TextoTitulosEdicionAgregar">
        Coberturas Adicionales
		</td>
        </tr>
       <?php if(($rowDanos['formIncendio']=='1') and ($rowDanos['formEdificio']=='1')  and ($rowDanos['formPerdida']=='1') and ($rowDanos['formCaldera']=='1') and ($rowDanos['formResponsabilidad']=='1') and ($rowDanos['formCirstales']=='1') and ($rowDanos['formAnuncios']=='1') and ($rowDanos['formSeccion1']=='1') and ($rowDanos['formAnuncios']=='1')and ($rowDanos['formRobov']=='1') and ($rowDanos['formDineroV']=='1')and ($rowDanos['formRobov']=='1')and ($rowDanos['formEquipoE']=='1')){}else{ ?>
        <tr>
 <td><select name="selec" id="selec" onchange="redirect(this.value);">
	<option value="">-Seleccione-</option> 
	<?php
		while($row = mysql_fetch_assoc($res)){	
	?>
	<option value="<?php echo $row['valor'];?>"><?php if(($row['titulo']=='Incendios Edificios' and $rowDanos['formIncendio']=='1') or ($row['titulo']=='Edificios' and $rowDanos['formEdificio']=='1')  or ($row['titulo']=='Perdida Secuencial' and $rowDanos['formPerdida']=='1') or ($row['titulo']=='Calderas y Recipientes' and $rowDanos['formCaldera']=='1') or ($row['titulo']=='Responsabilidad Civil' and $rowDanos['formResponsabilidad']=='1') or ($row['titulo']=='Robo de Cristales' and $rowDanos['formCirstales']=='1') or ($row['titulo']=='Anuncios Luminosos' and $rowDanos['formAnuncios']=='1')  or ($row['titulo']=='Seccion 1' and $rowDanos['formSeccion1']=='1')or ($row['titulo']=='Robo con Violencia y Asalto' and $rowDanos['formRobov']=='1') or ($row['titulo']=='Dinero y Valores' and $rowDanos['formDineroV']=='1')or ($row['titulo']=='Equipo Electronico' and $rowDanos['formEquipoE']=='1')){echo $row['titulo']." (Completado)";}else{echo $row['titulo'];} ?></option>
	<?php
		}}
	?>
</select>
<?php }?>
<?php if($rowDanos['formIncendio']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/incendio_edificio_contenido.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Incendios Edifios (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formEdificio']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/edificios.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Edifios (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formPerdida']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/perdida_secuencial.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Perida Secuencial (Completado) "; ?></a></td></tr><?php } ?>

<?php if($rowDanos['formCaldera']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/calderas_recipientes.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Calderas y Recipientes (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formResponsabilidad']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/responsabilidad_civil.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Responsabilidad Civil (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formCirstales']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/robo_cristales.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Robo de Cristales (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formAnuncios']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/anuncios_luminosos.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Anuncios Luminosos (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formSeccion1']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/seccion_1.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Seccion 1 (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formRobov']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/robo_violencia_asalto.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Robo con Violencia y Asalto (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formDineroV']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/dinero_valores.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Dinero y Valores (Completado) "; ?></a></td></tr><?php }?>

<?php if($rowDanos['formEquipoE']=='1'){?><tr><td colspan="2" >&nbsp;&nbsp;&nbsp;<a href="formularios/equipo_electronico.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno'];?>" target="_blank" onClick="window.open(this.href, this.target, 'height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes'); return false;"><?php echo "Formulario de Equipo Electronico (Completado) "; ?></a></td></tr><?php }?>

<!--- terminan las pruebas de los formularios de daños--->    
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
	<?php
$sqlExisteFormularioActividad = "
			Select * From 
				`actividades_formularios` 
			Where 
				`idActividad` = '$rowDatosActividad[recId]' 
				And 
				`ramoInterno` = '$rowDatosActividad[ramoInterno]' 
						  "; 
	if(mysql_num_rows(DreQueryDB($sqlExisteFormularioActividad))==0){
	?>
		<input type="button" value="Guardar Formulario" class="buttonGeneral" title="Clic para Guardar" onclick="java:document.formLineasPersonales.submit()" />
		&nbsp;&nbsp;&nbsp;
<?php
	}
?>
      </td>
  </tr>
</form>
</table>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fecha_nacimiento",
		trigger    : "fecha_nacimiento_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
</script>
<script>
	function redirect(valor){
		if(valor=="")
		{
			alert("Seleccione una opcion");
		}
		else
		{
		window.open('formularios/'+valor+'.php?recId=<?php echo $rowDatosActividad['recId']; ?>&ramoInterno=<?php echo $rowDatosActividad['ramoInterno']; ?>','_blank','height=490,width=730,left=10,top=10,screenX=150,screenY=10,direcciones=true,scrollbars=yes');
		}
	}
</script>>>