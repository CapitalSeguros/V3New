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
<form name="form" id="form" method="post"  action="../includes/guardar.php?tipoGuardar=formulariosAnuncios">
	<tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Protecci&oacute;n Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>

	<tr>
    	<td colspan="2"><strong>SECCION VIII ANUNCIOS LUMINOSOS</strong></td>
    </tr>

	<tr>
		<td width="150" align="right">Medidas, largo , ancho:</td>
	  	<td><input name="medidas" type="text" id="medidas" value="<?php echo $rowDanos['medidas'] ?>"/></td>
    </tr>
    <tr>
		<td width="150" align="right">Material de construcci&oacute;n:</td>
	  	<td><input name="material_construccion" type="text" id="material_construccion" value="<?php echo $rowDanos['material_construccion'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Leyenda:</td>
	  <td><input name="leyenda" type="text" id="leyenda" value="<?php echo $rowDanos['leyenda'] ?>"/></td>
    </tr>
    
	<tr>
	  <td width="150" align="right">Sumas asegurada:</td>
	  <td><input name="suma_asegurada_anuncios" type="text" id="suma_asegurada_anuncios" value="<?php echo $rowDanos['suma_asegurada_anuncios'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Ajuste inflacionario para esta secci&oacute;n %:</td>
	  <td><input name="ajuste_inflacionario_anuncios" type="text" id="ajuste_inflacionario_anuncios"  value="<?php echo $rowDanos['ajuste_inflacionario_anuncios'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Tipo de alarma:</td>
	  <td>
      <?php echo SelectTipoAlarma($rowDanos['tipo_alarma_anunios'],$rowDatosFormulario['tipo_alarma_anunios']); ?></td>
    </tr>
    <tr>
	  <td width="150" align="right">Cuantos:</td>
	  <td><input name="cuantos1" type="text" id="cuantos1"  value="<?php echo $rowDanos['cuantos1'] ?>"/></td>
    </tr>
     <tr>
	  <td width="150" align="right">Sistema de circuito cerrado:</td>
	  <td><input name="circuito_cerrado" type="text" id="circuito_cerrado"  value="<?php echo $rowDanos['circuito_cerrado'] ?>"/></td>
    </tr>
     <tr>
	  <td width="150" align="right">Servicio de recolecci&oacute;n de dinero:</td>
	  <td><input name="recoleccion_dinero" type="text" id="recoleccion_dinero"  value="<?php echo $rowDanos['recoleccion_dinero'] ?>"/></td>
    </tr>
     <tr>
	  <td width="150" align="right">Puertas a la calle con protecci&oacute;n:</td>
	  <td><input name="puertas_protecccion" type="text" id="puertas_protecccion"  value="<?php echo $rowDanos['puertas_protecccion'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Ventanas a la calle con protecci&oacute;n:</td>
	  <td><input name="ventanas_protecion" type="text" id="ventanas_protecion"  value="<?php echo $rowDanos['ventanas_protecion'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Tragaluces a la calle con protecci&oacute;n:</td>
	  <td><input name="tragaluces_proteccion" type="text" id="tragaluces_proteccion"  value="<?php echo $rowDanos['tragaluces_proteccion'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Caja de seguridad en veh&iacute;culo repartido:</td>
	  <td><input name="caja_seguridad" type="text" id="caja_seguridad"  value="<?php echo $rowDanos['caja_seguridad'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Polic&iacute;a armando en veh&iacute;culo repartidor:</td>
	  <td><input name="policia_armado" type="text" id="policia_armado"  value="<?php echo $rowDanos['policia_armado'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">&iquest;Realizan deposito bancarios?:</td>
	  <td><input name="deposito_bancario" type="text" id="deposito_bancario"  value="<?php echo $rowDanos['deposito_bancario'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Velador polic&iacute;a armado al servicio del asegurado:</td>
	  <td><input name="velador" type="text" id="velador"  value="<?php echo $rowDanos['velador'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">Cuantos:</td>
	  <td><input name="cuantos2" type="text" id="cuantos2"  value="<?php echo $rowDanos['cuantos2'] ?>"/></td>
    </tr>
   	<tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formAnuncios'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
</form>
</table>
<?php DreDesconectarDB($conexion); ?>