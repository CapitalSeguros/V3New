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
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosCaldera">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
    <tr>
    <td colspan="2"><strong>Solo seccion IV Calderas y recipientes sujetos a presion y rotura de maquinaria (tecnomaq)</strong></td>
    </tr>
    
    <tr>
	  <td align="right">Cotizacion a efectuar:</td>
	 <td>
		<?php echo SelectTipoCotizacionEfectuar($rowDanos['cotizacion_efectuar'],$rowDatosFormulario['estatus']); ?>
	  </td>
    </tr>
    
    <tr>
	  <td align="right">Edad promedio de la maquinaria:</td>
	  <td><input name="edad_promedioMaquinaria" type="text" id="edad_promedioMaquinaria" value="<?php echo $rowDanos['edad_promedioMaquinaria'] ?>" /></td>
    </tr>
    
    <tr>
	  <td align="right">Suma asegurada toral de los equipos $:</td>
	  <td><input name="suma_aseguradaEquipo" type="text" id="suma_aseguradaEquipo" value="<?php echo $rowDanos['suma_aseguradaEquipo'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Cobertura adicionales D.O.P.A $:</td>
	  <td><input name="cobertura_adicional" type="text" id="cobertura_adicional" value="<?php echo $rowDanos['cobertura_adicional'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Derrame de contenido $:</td>
	  <td><input name="derrame_contenido" type="text" id="derrame_contenido" value="<?php echo $rowDanos['derrame_contenido'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Gastos extras:</td>
	  <td><input name="gastos_extras" type="text" id="gastos_extras" value="<?php echo $rowDanos['gastos_extras'] ?>" /></td>
    </tr>
    
    <tr>
	  <td align="right">Gastos por flete aereo:</td>
	  <td><input name="gastos_fleteAereo" type="text" id="gastos_fleteAereo" value="<?php echo $rowDanos['gastos_fleteAereo'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Periodo de inactividad:</td>
	  <td><input name="periodo_inactividad" type="text" id="periodo_inactividad" value="<?php echo $rowDanos['periodo_inactividad'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Ajuste inflacionario para esta seccion al %:</td>
	  <td><input name="ajuste_inflacionario" type="text" id="ajuste_inflacionario" value="<?php echo $rowDanos['ajuste_inflacionario'] ?>"/></td>
    </tr>
    
    <tr>
        <td colspan="2"><font style="font-size:12px;"><em>Para cotizar es indispensable anexar la relaci&oacute;n de la maquinaria indicando, descripci&oacute;n, marca, modelo, numero de serie, capacidad, a&ntilde;o de construcci&oacute;n y valor de reposici&oacute;n.</em></font></td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formCaldera'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
      <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>