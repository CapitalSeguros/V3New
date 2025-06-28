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
<?php DreHead($eccion); ?>
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
<form name="form" id="form" method="post"  action="../includes/guardar.php?tipoGuardar=formulariosCristales">
	<tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Protecci&oacute;n Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>

	<tr>
    	<td colspan="2"><strong>SECCION VII ROBO DE CRISTALES</strong></td>
    </tr>

	<tr>
		<td width="150" align="right">Espesor de los cristales:</td>
	  	<td><input name="espesor_cristal" type="text" id="espesor_cristal" value="<?php echo $rowDanos['espesor_cristal'] ?>"/></td>
    </tr>
	<tr>
        <td colspan="2"><font style="font-size:12px;"><em>No se cubren cristales con espesor menos a 4mm.</em></font></td>
    </tr>
    <tr>
		<td width="150" align="right">Rotura de cristales suma asegurada $:</td>
	  	<td><input name="rotura_cristal" type="text" id="rotura_cristal" value="<?php echo $rowDanos['rotura_cristal'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Cristales con avalu&oacute; suma asegurada $:</td>
	  <td><input name="evaluo_cristal" type="text" id="evaluo_cristal" value="<?php echo $rowDanos['evaluo_cristal'] ?>"/></td>
    </tr>
    
	<tr>
	  <td width="150" align="right">Cobertura adicional:</td>
	  <td><input name="cobertura_adicional_cristal" type="text" id="cobertura_adicional_cristal" value="<?php echo $rowDanos['cobertura_adicional_cristal'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Decorado:</td>
	  <td><input name="decorado" type="text" id="decorado"  value="<?php echo $rowDanos['decorado'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Remoci&oacute;n:</td>
	  <td><input name="remocion" type="text" id="remocion"  value="<?php echo $rowDanos['remocion'] ?>"/></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Ajuste inflacionario para esta secci&oacute;n %:</td>
	  <td><input name="ajuste_inflacionario_cristal" type="text" id="ajuste_inflacionario_cristal"  value="<?php echo $rowDanos['ajuste_inflacionario_cristal'] ?>"/></td>
    </tr>
   	<tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formCirstales'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
</form>
</table>
<?php DreDesconectarDB($conexion); ?>