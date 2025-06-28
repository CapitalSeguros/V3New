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
<form name="form" id="form" method="post"  action="../includes/guardar.php?tipoGuardar=formulariosSeccion1">
	<tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Protecci&oacute;n Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>

	<tr>
    	<td colspan="2"><strong>Solo secci&oacute;n I</strong></td>
    </tr>
<tr>
    	<td colspan="2"><strong>Bienes excluidos que pueden ser cubiertos mediante convenio expreso para la cobertura de fen&oacute;menos hidrometereologicos</strong></td>
    </tr>
	<tr>
		<td colspan="2" align="justify">Edificios terminados que carezcan total o parcialmente de techos, muros, puertas o ventanas siempre y cuando dichos edificios hayan sido dise&ntilde;ados y/o construidos para operar bajo estas circunstancias, de acuerdo con los reglamentos de construcci&oacute;n de la zona vigentes a la construcci&oacute;n</td>
    </tr>
    <tr>
    <td>$:<input name="edificios_terminados" type="text" id="edificios_terminados" value="<?php echo $rowDanos['edificios_terminados'] ?>"/></td>
    </tr>
    <tr>
		<td  colspan="2" align="justify">Maquinaria y/o equipo fijo y sus instalaciones que se encuentran total o parcialmente al aire libre que se encuentren en dentro de edificios que carezcan total o parcialmente de techos, muros, puertas o ventanas siempre y cuando dichos edificios hayan sido dise&ntilde;ados y/o construidos para operar bajo estas circunstancias, de acuerdo con los reglamentos de construcci&oacute;n de la zona vigentes a la construcci&oacute;n</td>
    </tr>
    <tr>
    <td>$:<input name="maquinaria_fija" type="text" id="maquinaria_fija" value="<?php echo $rowDanos['maquinaria_fija'] ?>"/></td>
    </tr>
    
    <tr>
	  <td  colspan="2" align="justify">Bienes fijos distintos a maquinaria que por su propia naturaleza est&eacute;n a la intemperie, entendi&eacute;ndose como tales aquellos que se encuentren fuera de edificios o dentro de edificios que carezcan total o parcialmente de techos, puertas, ventanas o muros</td>
    </tr>
    <tr>
    <td>$:<input name="bienes_fijos" type="text" id="bienes_fijos" value="<?php echo $rowDanos['bienes_fijos'] ?>"/></td>
    </tr>
    
	<tr>
	  <td  colspan="2" align="justify">Bienes muebles o la porci&oacute;n del inmueble en s&oacute;tanos o semis&oacute;tanos consider&aacute;ndose como tales, cualquier recinto donde la totalidad de sus muros perimetrales se encuentren total o parcialmente bajo el nivel natural del terreno</td>
    </tr>
    <tr>
    <td>$:<input name="bienes_muebles" type="text" id="bienes_muebles" value="<?php echo $rowDanos['bienes_muebles'] ?>"/></td>
    </tr>
     <tr>
        <td colspan="2"><font style="font-size:12px;"><em>Para cotizar bienes excluidos que pueden ser cubiertos mediante convenio expreso para la cobertura de fen&oacute;menos hidrometereologicos, es requisito anexar la relaci&oacute;n de bienes con las sumas aseguradas correspondientes y contratar la cobertura de fen&oacute;menos hidrometereologicos para edificio.</em></font></td>
    </tr>
   	<tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formSeccion1'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
</form>
</table>
<?php DreDesconectarDB($conexion); ?>