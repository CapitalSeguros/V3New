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
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosPerdida">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
    <tr>
   	 <td colspan="2"><strong>Solo seccion II Perdidas secuenciales</strong></td>
    </tr>

    <tr>
	  <td width="150" align="right">Tipo de cotizacion:</td>
	<td><?php echo SelectTipoCotizacion($rowDanos['cotizacion'],$rowDatosFormulario['estatus']); ?></td>
    </tr>

    <tr><!--- prueba de bloqueo--->
	  <td align="right">Perdidas de rentas a (meses) $:</td>
	  <td><input name="perdidas_rentas" type="text" id="perdidas_rentas" value="<?php echo $rowDanos['perdidas_rentas'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>

    <tr>
	  <td align="right">Gastos extraordinarios (meses) $:</td>
	  <td><input name="gastos_extraordinarios_perdida" type="text" id="gastos_extraordinarios_perdida" value="<?php echo $rowDanos['gastos_extraordinarios_perdida'] ?>" /></td>
    </tr>
    
    <tr>
	  <td align="right">Reduccion de ingresos por interrupcion de actividades comerciales hasta por  (meses) $:</td>
	  <td><input name="reduccion_ingresos_interrupcion" type="text" id="reduccion_ingresos_interrupcion" value="<?php echo $rowDanos['reduccion_ingresos_interrupcion'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Perdida de utilidades, salarios y gastos fijos hasta por (meses) $:</td>
	  <td><input name="perdida_utilidades" type="text" id="perdida_utilidades" value="<?php echo $rowDanos['perdida_utilidades'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Ganancias brutas no realizadas en negociaciones:</td>
	  <td><input name="ganancias_brutas_noRealizadas" type="text" id="ganancias_brutas_noRealizadas" value="<?php echo $rowDanos['ganancias_brutas_noRealizadas'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Comerciales o en plantas industriales % $:</td>
	  <td><input name="comerciales_plantasIndustriales" type="text" id="comerciales_plantasIndustriales" value="<?php echo $rowDanos['comerciales_plantasIndustriales'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Seguro contingente al % $:</td>
	  <td><input name="seguro_contingente" type="text" id="seguro_contingente" value="<?php echo $rowDanos['seguro_contingente'] ?>"/></td>
    </tr>
    
    <tr>
	  <td align="right">Ajuste inflacionario para esta seccion al %:</td>
	  <td><input name="ajuste_inflacionario_perdida" type="text" id="ajuste_inflacionario_perdida" value="<?php echo $rowDanos['ajuste_inflacionario_perdida'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formPerdida'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>