<?php 
if(isset($_REQUEST['tipoDanos'])){ $tipoDanos = $_REQUEST['tipoDanos']; } else { $tipoDanos = $rowDatosFormulario['tipoDanos']; }
if($tipoDanos == ""){
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
	  <td><a href="formularios/descargables/Descarga.php?file=danos_obra_civil.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Obra </td>
	  <td><a href="formularios/descargables/Descarga.php?file=danos_rc_equipo_contratistas.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
RC<br />
contratistas </td>
	  <td><a href="formularios/descargables/Descarga.php?file=danos_rc_medico.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
RC<br />
medicos </td>
	  <td><a href="formularios/descargables/Descarga.php?file=danos_transporte_especifico.xlsx" title="Clic para Descargar" target="new" ><img src="img/formulario.png" width="36" height="36" border="0" /></a> <br />
Transporte<br />
especifico </td>
	  <td>&nbsp;</td>
  </tr>
	<tr align="center" valign="top">
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
  </tr>
	<tr align="left" valign="top">
	  <td colspan="5">
      <form name="formDanos" id="formDanos" method="get" action="<?php echo $_SERVER['PHP_SELF']."#Formularios"; ?>" >
<select name="tipoDanos" id="tipoDanos" onchange="java: document.formDanos.submit()">
	<option> -Seleccione- </option>
    <?php
	$sqlTipoDanos = "Select * From `configdre`  Where `parametro` = 'tipoDanos' Order By `titulo`";
	$resTipoDanos = DreQueryDB($sqlTipoDanos);
	while($rowTipoDanos = mysql_fetch_assoc($resTipoDanos)){
	?>
    <option value="<?php  echo $rowTipoDanos['valor']?>"><?php echo $rowTipoDanos['titulo']; ?></option>
    <?php
	}
	?>
</select>
<input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
<input type="hidden" name="muestra" id="muestra" value="Formularios" />
</form>
      </td>
  </tr>
	</table>
<?php
}
switch($tipoDanos){
	case 'embarcaciones':
		require('Danos_Embarcaciones.php');
	break;
	case 'proteccionBienesEmpresariales':
		require('Danos_ProteccionBienesEmpresariales.php');
	break;
	case 'hogar':
		require('Danos_Hogar.php');
	break;
}
?>