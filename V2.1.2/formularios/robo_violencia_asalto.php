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
<form name="form" id="form" method="post"  action="../includes/guardar.php?tipoGuardar=formulariosRoboV">
	<tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Protecci&oacute;n Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>

	<tr>
    	<td colspan="2"><strong>SECCION IX ROBO CON VIOLENCIA Y ASALTO</strong></td>
    </tr>
	
    <tr>
		<td colspan="2" align="justify">Mercanc&iacute;as, materia prima, productos en proceso, productos terminados, maquinaria, mobiliario, &uacute;tiles, accesorios y dem&aacute;s equipo propio y necesario a la &iacute;ndole del negocio asegurado, tambi&eacute;n cubre los art&iacute;culos mencionados en el siguiente apartado cuyo valor unitario o por juego sea hasta el equivalente 500 d&iacute;as de salario m&iacute;nimo vigente en el Distrito Art&iacute;culos raros de arte y en general,  Federal $:<input name="mercancias_materiaPrima" type="text" id="mercancias_materiaPrima" value="<?php echo $rowDanos['mercancias_materiaPrima'] ?>"/></td>
    </tr>
    
    <tr>
		<td  colspan="2" align="justify">Aquellos que no sean necesarios a la &iacute;ndole del negocio asegurado y que expresamente se enumeren y especifiquen en la relaci&oacute;n anexa a la presente solicitud y cuyo valor unitario o por juego sea superior al equivalente 500 d&iacute;as de salario m&iacute;nimo vigente en el Distrito Federal $:<input name="negocio_asegurado" type="text" id="negocio_asegurado" value="<?php echo $rowDanos['negocio_asegurado'] ?>"/></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Deducibles:</td>
	 <td >
		<?php echo SelectTipoDeducible($rowDanos['deducible_roboV'],$rowDatosFormulario['deducible_roboV']); ?>
	  </td>
    </tr>
	
   	<tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formRobov'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
</form>
</table>
<?php DreDesconectarDB($conexion); ?>