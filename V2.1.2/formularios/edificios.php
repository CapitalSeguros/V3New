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
table{border: 1px solid rgb(148, 163, 196);margin: 0px 0px 15px;width:700px;}
</style>
</head>
<body>
<?php
$conexion = DreConectarDB(); 
?>
<table border="0" cellspacing="2" cellpadding="5" width="95%" align="center">
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosEdificios">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
	<tr>
    	<td colspan="2"><strong>Solo seccion II Edificios</strong></td>
    </tr>
    
    <tr>
	<td width="150" align="right">Combustion espontanea $:</td>
	<td><input name="combustion_espontanea" type="text" id="combustion_espontanea" value="<?php echo $rowDanos['combustion_espontanea'] ?>"/></td>
    </tr>
  
    <tr>
	  <td width="150" align="right">Tipo de producto:</td>
	  <td><input name="tipo_producto" type="text" id="tipo_producto" value="<?php echo $rowDanos['tipo_producto'] ?>" /></td>
    </tr>
  
    <tr>
	  <td width="150" align="right">Mercancias o productos terminados:</td>
	  <td><input name="mercancias_productos" type="text" id="mercancias_productos" value="<?php echo $rowDanos['mercancias_productos'] ?>" /></td>
    </tr>
	
    <tr>
	  <td width="150" align="right">Precio neto de venta:</td>
	  <td><input name="precio_neto_venta" type="text" id="precio_neto_venta" value="<?php echo $rowDanos['precio_neto_venta'] ?>"/></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Exitencia en declaracion:</td>
	  <td><input name="existencia_decalracion" type="text" id="existencia_decalracion" value="<?php echo $rowDanos['existencia_decalracion'] ?>"/>	</td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Bienes en aparatos refrigeradores $:</td>
	  <td><input name="naves_aereas" type="text" id="naves_aereas" value="<?php echo $rowDanos['naves_aereas'] ?>" /></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Bienes en incubadora $	:</td>
	  <td><input name="huelgas_alborotos_edificio" type="text" id="huelgas_alborotos_edificio" value="<?php echo $rowDanos['huelgas_alborotos_edificio'] ?>"/></td>
    </tr>
   
    <tr>
	  <td width="150" align="right">Con planta de fuerza motriz de emergencias:</td>
	  <td><?php echo SelectSiNo($rowDanos['planta_motriz_emergencias'],$rowDatosFormulario['estatus'],'planta_motriz_emergencias'); ?></td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formEdificio'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
	 <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>