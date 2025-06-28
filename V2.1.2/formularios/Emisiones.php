<?php 
if(isset($_REQUEST['tipoEmisiones'])){ $tipoEmisiones = $_REQUEST['tipoEmisiones']; } else { $tipoEmisiones = $rowDatosEmisiones['tipoEmisiones']; }

if($tipoEmisiones == ""){
?>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="10">
        	Descargue el Formato Correspondiente, Dando Clic Sobre el Icono.
        </td>
    </tr>
	<tr>
	  <td width="122"></td>
	  <td width="122"></td>
	  <td width="122"></td>
	  <td width="122"></td>
	  <td width="122"></td>     
  </tr>
	<tr align="center" valign="top">
	  <td><a href="formularios/emisiones/Descarga.php?file=casa_habitacion.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Casa Habitaci&oacute;n </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=embarcaciones_placer.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Embarcaciones<br />
Placer </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=empresarial.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Empresarial</td>
	  <td><a href="formularios/emisiones/Descarga.php?file=incendio.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Incendio </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=obra_civil.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Obra Civil </td>
  </tr>
	<tr align="center" valign="top">
	  <td><a href="formularios/emisiones/Descarga.php?file=obra_civil_cuestionario.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Obra Civil<br />Cuestionario </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=rc_equipo_contratistas.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Rc Equipo<br />Contratistas </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=rc_medico.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Rc Medico </td>
	  <td><a href="formularios/emisiones/Descarga.php?file=transporte_especifico.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Transporte<br />Especifico </td>
	  <td>&nbsp;</td>
  </tr>
	<tr align="left" valign="top">
	  <td colspan="5">
<form name="formEmisiones" id="formEmisiones" method="get" action="<?php echo $_SERVER['PHP_SELF']."#Formularios"; ?>" >
<select name="tipoEmisiones" id="tipoEmisiones" onchange="java: document.formEmisiones.submit()">
	<option> -Seleccione- </option>
    <?php
	$sqltipoEmisiones = "Select * From `configdre`  Where `parametro` = 'tipoEmisiones' Order By `titulo`";
	$restipoEmisiones = DreQueryDB($sqltipoEmisiones);
	while($rowtipoEmisiones = mysql_fetch_assoc($restipoEmisiones)){
	?>
    <option value="<?php  echo $rowtipoEmisiones['valor']?>"><?php echo $rowtipoEmisiones['titulo']; ?></option>
    <?php
	}
	?>
</select>
<input type="hidden" name="muestra" id="muestra" value="Formularios" />
<input type="hidden" name="recId" id="recId" value="<?php echo $rowDatosActividad['recId']; ?>" />
</form>
      </td>
  </tr>
	</table>
<?php
}
$sqlConsultaWs = "
	Select * From
			`ws_comparativo`
		Where
			`idActividad` = '$rowActividad[cotizacionEmision]'
				 ";
$existeCotizacionWs = mysql_num_rows(DreQueryDB($sqlConsultaWs));

switch($tipoEmisiones){
	
	case 'autos':
		if($existeCotizacionWs != "0"){
			require('Emisiones_Autos_Ws.php');
		} else {
			require('Emisiones_Autos.php');
		}
	break;
}
?>