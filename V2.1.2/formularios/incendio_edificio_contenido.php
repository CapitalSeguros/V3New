<?php
include('../includes/funcionesDre.php');
extract($_GET);
$conexion = DreConectarDB();
$rI = urlencode($ramoInterno);
$sqlDanos = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$recId'
		And 
		`ramoInterno`= '$rI'
											";
$resDanos = DreQueryDB($sqlDanos);
$rowDanos = mysql_fetch_assoc($resDanos);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php DreHead($seccion); ?>
<style type="text/css">
table{border: 1px solid rgb(148, 163, 196);margin: 0px 0px 15px;width:500px;}
</style>
</head>
<body>
<?php
$conexion = DreConectarDB(); 
extract($_GET);
?>
<table border="0" cellspacing="2" cellpadding="5" width="95%" align="center">
<form name="form" id="form" method="post"  action="../includes/guardar.php?tipoGuardar=formulariosIncendios">
	<tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Protecci&oacute;n Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>

	<tr>
    	<td colspan="2"><strong>Incendio, edificio y contenidos</strong></td>
    </tr>

	<tr>
		<td width="150" align="right">Edificio $:</td>
	  	<td><input name="dinero_edificio_incendio" type="text" id="dinero_edificio_incendio" value="<?php echo $rowDanos['dinero_edificio_incendio'] ?>"/></td>
    </tr>

    <tr>
		<td width="150" align="right">Contenidos $:</td>
	  	<td><input name="dinero_contenido_incendio" type="text" id="dinero_contenido_incendio" value="<?php echo $rowDanos['dinero_contenido_incendio'] ?>"/></td>
    </tr>

    <tr>
	  <td width="150" align="right">Mobiliario y equipo de oficina:</td>
	  <td><input name="mobiliario_equipo_incendio" type="text" id="mobiliario_equipo_incendio" value="<?php echo $rowDanos['mobiliario_equipo_incendio'] ?>"/></td>
    </tr>
    
	<tr>
	  <td width="150" align="right">Maquinaria y equipo de operacion:</td>
	  <td><input name="maquinaria_equipo_operacion" type="text" id="maquinaria_equipo_operacion" value="<?php echo $rowDanos['maquinaria_equipo_operacion'] ?>"/></td>
    </tr>
    
  <tr>
	  <td width="150" align="right">Existencia:</td>
	  <td>
		<?php echo SelectExistencia($rowDanos['existencia'],$rowDatosFormulario['estatus']); ?>
	  </td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Explosion:</td>
	  <td><input name="explosion" type="text" id="explosion"  value="<?php echo $rowDanos['explosion'] ?>"/></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Naves aereas:</td>
	  <td><input name="naves_aereas_incendios" type="text" id="naves_aereas_incendios"  value="<?php echo $rowDanos['naves_aereas_incendios'] ?>"/></td>
    </tr>
   
    <tr>
	  <td width="150" align="right">Huelgas y alborotos populares:</td>
	  <td><input name="huelgas_alborotos" type="text" id="huelgas_alborotos"  value="<?php echo $rowDanos['huelgas_alborotos'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Extension de cobertura:</td>
	  <td><input name="cobertura_extension" type="text" id="cobertura_extension"  value="<?php echo $rowDanos['cobertura_extension'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Remosion de escombro $:</td>
	  <td><input name="dinero_escombro_incendio" type="text" id="dinero_escombro_incendio" value="<?php echo $rowDanos['dinero_escombro_incendio'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Terremoto y erupcion volcanica:</td>
	  <td><input name="edificion_terremoto_volcan_incendio" type="text" id="edificion_terremoto_volcan_incendio"value="<?php echo $rowDanos['edificion_terremoto_volcan_incendio'] ?>" /></td>
    </tr>
    <tr>
	  <td width="150" align="right">Bienes cubiertos bajo convenio expreso:</td>
	  <td><input name="bienes_bajo_convenio" type="text" id="bienes_bajo_convenio" value="<?php echo $rowDanos['bienes_bajo_convenio'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Derrame de pci:</td>
	  <td><input name="derrame_pci" type="text" id="derrame_pci" value="<?php echo $rowDanos['derrame_pci'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Valor de reposicion:</td>
	  <td><input name="valor_reposicion" type="text" id="valor_reposicion" value="<?php echo $rowDanos['valor_reposicion'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Incisos conocidos $:</td>
	  <td><input name="incisos_conocidos" type="text" id="incisos_conocidos" value="<?php echo $rowDanos['incisos_conocidos'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Incisos nuevos o no conocidos $:</td>
	  <td><input name="incisos_noConocidos_nuevos" type="text" id="incisos_noConocidos_nuevos" value="<?php echo $rowDanos['incisos_noConocidos_nuevos'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Deducible para incendio y explosion %:</td>
	  <td><input name="deducible_incendio" type="text" id="deducible_incendio" value="<?php echo $rowDanos['deducible_incendio'] ?>"/>
      </td>
    </tr>
     <tr>
	  <td width="150" align="right">Coaeguro convenido al %:</td>
	  <td><input name="coaseguro_incendio" type="text" id="coaseguro_incendio" value="<?php echo $rowDanos['coaseguro_incendio'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Ajuste inflacionario para estas secciones al %:</td>
	  <td><input name="ajuste_incendio" type="text" id="ajuste_incendio" value="<?php echo $rowDanos['ajuste_incendio'] ?>"/></td>
    </tr>
	<tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formIncendio'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
</form>
</table>
<?php DreDesconectarDB($conexion); ?>