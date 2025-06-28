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
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosEquipoE">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
    <tr>
   	 <td colspan="2"><strong>SECCION XI EQUIPO ELECTRONICO</strong></td>
    </tr>
    
    <tr>
	  <td align="right">Cobertura b&aacute;sica Da&ntilde;os materiales $:</td>
	  <td><input name="cobertura_basica" type="text" id="cobertura_basica" value="<?php echo $rowDanos['cobertura_basica'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Equipo m&oacute;vil:</td>
	  <td><input name="equipo_movil" type="text" id="equipo_movil" value="<?php echo $rowDanos['equipo_movil'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Equipo port&aacute;til:</td>
	  <td><input name="equipo_portatil" type="text" id="equipo_portatil" value="<?php echo $rowDanos['equipo_portatil'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Marca:</td>
	  <td><input name="marca_equipoE" type="text" id="marca_equipoE" value="<?php echo $rowDanos['marca_equipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Modelo:</td>
	  <td><input name="modelo_equipoE" type="text" id="modelo_equipoE" value="<?php echo $rowDanos['modelo_equipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">N&uacute;mero de serie:</td>
	  <td><input name="numero_serieE" type="text" id="numero_serieE" value="<?php echo $rowDanos['numero_serieE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Coberturas adicionales:</td>
	  <td><input name="cobertura_adicionalEquipoE" type="text" id="cobertura_adicionalEquipoE" value="<?php echo $rowDanos['cobertura_adicionalEquipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Terremoto:</td>
	  <td><input name="terremoto_equipoE" type="text" id="terremoto_equipoE" value="<?php echo $rowDanos['terremoto_equipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Huelgas y Vandalismo:</td>
	  <td><input name="huelgasVandalismo" type="text" id="huelgasVandalismo" value="<?php echo $rowDanos['huelgasVandalismo'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Robo sin Violencia:</td>
	  <td><input name="robo_sinViolencia" type="text" id="robo_sinViolencia" value="<?php echo $rowDanos['robo_sinViolencia'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Portadores Externos de Datos:</td>
	  <td><input name="portadoresExternos" type="text" id="portadoresExternos" value="<?php echo $rowDanos['portadoresExternos'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Ajuste Inflacionario:</td>
	  <td><input name="ajuste_inflacionarioEquipoE" type="text" id="ajuste_inflacionarioEquipoE" value="<?php echo $rowDanos['ajuste_inflacionarioEquipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Fen&oacute;menos Meteorol&oacute;gicos:</td>
	  <td><input name="fenomenos_equipoE" type="text" id="fenomenos_equipoE" value="<?php echo $rowDanos['fenomenos_equipoE'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Gastos tiempo extra y flete a&eacute;reo::</td>
	  <td><input name="gastos_tiempoExtra" type="text" id="gastos_tiempoExtra" value="<?php echo $rowDanos['gastos_tiempoExtra'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Incremento de Costo de Operaci&oacute;n:</td>
	  <td><input name="costo_operacion" type="text" id="costo_operacion" value="<?php echo $rowDanos['costo_operacion'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Meses Indemnizaci&oacute;n:</td>
	  <td><input name="mesesIndemnizacion" type="text" id="mesesIndemnizacion" value="<?php echo $rowDanos['mesesIndemnizacion'] ?>"/></td>
    </tr>
    <tr>
	  <td align="right">Deducible D&iacute;as:</td>
	  <td><input name="deducible_diasE" type="text" id="deducible_diasE" value="<?php echo $rowDanos['deducible_diasE'] ?>"/></td>
    </tr>
     <tr>
        <td colspan="2"><font style="font-size:12px;"><em>Nota: Para la emisi&oacute;n de la cotizaci&oacute;n es necesaria la descripci&oacute;n del equipo, marca, modelo, n&uacute;mero de serie, capacidad, a&ntilde;o de construcci&oacute;n y valor de reposici&oacute;n. Indispensable entregar la relaci&oacute;n de los bienes a asegurar indicando descripci&oacute;n del paquete o software, marca versi&oacute;n, n&uacute;mero de serie, a&ntilde;o de edici&oacute;n, y valor de reposici&oacute;n. La suma asegurada deber&aacute; ser igual a la cantidad que sea necesaria erogar durante 12 meses por el incremento en el costo de operaci&oacute;n del equipo asegurado aun que seleccione un periodo de indemnizaci&oacute;n m&aacute;s corto.</em></font></td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formEquipoE'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
   	 <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>