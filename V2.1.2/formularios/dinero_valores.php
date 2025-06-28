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
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosDineroV">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
    <tr>
   	 <td colspan="2"><strong>SECCION X DINERO Y VALORES</strong></td>
    </tr>

    <tr>
	  <td colspan="2" align="justify">Dentro del local en cajas fuertes o b&oacute;vedas, cajas registradoras o colectoras en poder de sus cajeros, pagadores, cobradores o cualquier empleado funcionario $:<input name="local_valores" type="text" id="local_valores" value="<?php echo $rowDanos['local_valores'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>

    <tr>
	  <td colspan="2" align="justify">Fuera del local en poder de cajeros, pagadores, cobradores o cualquier otro empleado o funcionario con el prop&oacute;sito de efectuar cualquier operaci&oacute;n propia del negocio asegurado $:<input name="FueraLocal_valores" type="text" id="FueraLocal_valores" value="<?php echo $rowDanos['FueraLocal_valores'] ?>" /></td>
    </tr>
    
    <tr>
	  <td align="right">L&iacute;mite &Uacute;nico y Combinado dentro y fuera $:</td>
	  <td><input name="limite_unico" type="text" id="limite_unico" value="<?php echo $rowDanos['limite_unico'] ?>"/></td>
    </tr>
    
    <tr>
	  <td width="150" align="right">Deducibles:</td>
	 <td >
		<?php echo SelectTipoDeducible2($rowDanos['deducible_DineroV'],$rowDatosFormulario['deducible_DineroV']); ?>
	  </td>
    </tr>
    
    <tr>
	  <td align="right">Veh&iacute;culos repartidores:</td>
	  <td><input name="vehiculos_repartidores" type="text" id="vehiculos_repartidores" value="<?php echo $rowDanos['vehiculos_repartidores'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Sublimite por unidad:</td>
	  <td><input name="sublimite_unidadDV" type="text" id="sublimite_unidadDV" value="<?php echo $rowDanos['sublimite_unidadDV'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">N&uacute;mero de unidades:</td>
	  <td><input name="numero_unidadesDV" type="text" id="numero_unidadesDV" value="<?php echo $rowDanos['numero_unidadesDV'] ?>"/></td>
    </tr>
    
   <tr>
	  <td width="150" align="right">Deducibles Veh&iacute;culos Repartidores:</td>
	 <td >
		<?php echo SelectTipoDeducible($rowDanos['deducible_vehiculosRDV'],$rowDatosFormulario['deducible_vehiculosRDV']); ?>
	  </td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formDineroV'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>