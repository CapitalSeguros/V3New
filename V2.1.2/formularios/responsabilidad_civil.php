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
<form name="form" id="form" method="post" action="../includes/guardar.php?tipoGuardar=formulariosResponsabilidad">
    <tr>
    	<td colspan="2"><font style="font-family:Verdana, Geneva, sans-serif;color:#00397E;font-size:14px;font-weight:bold;text-decoration:none;" >Proteccion Bienes Empresas / Coberturas Adicionales</font>
        <hr />
        </td>
   	</tr>
    <tr>
    <td colspan="2"><strong>Solo seccion V y VI responsabilidad civil</strong></td>
    </tr>
    
    <tr>
	  <td align="right">Coberturas solicitadas:</td>
	  <td><input name="coberturas_solicitadas" type="text" id="coberturas_solicitadas" value="<?php echo $rowDanos['coberturas_solicitadas'] ?>"</td>
    </tr>

    <tr>
	  <td align="right">Coberturas adicionales (indicar si las requiere):</td>
	  <td><input name="coberturas_adicionales_responsabilidad" type="text" id="coberturas_adicionales_responsabilidad" value="<?php echo $rowDanos['coberturas_adicionales_responsabilidad'] ?>" </td>
    </tr>

    <tr>
	  <td align="right">Productos y trabajos terminados:</td>
	  <td><input name="procutos_trabajosTerminados" type="text" id="procutos_trabajosTerminados" value="<?php echo $rowDanos['procutos_trabajosTerminados'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Carga y descarga:</td>
	  <td><input name="carga_descarga" type="text" id="carga_descarga" value="<?php echo $rowDanos['carga_descarga'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Asumida:</td>
	  <td><input name="asumida" type="text" id="asumida" value="<?php echo $rowDanos['asumida'] ?>" </td>
    </tr>

    <tr>
	  <td align="right">Contratistas independientes:</td>
	  <td><input name="contratista_independiente" type="text" id="contratista_independiente" value="<?php echo $rowDanos['contratista_independiente'] ?>" /></td>
    </tr>

    <tr>
	  <td align="right">Explosivos:</td>
	  <td><input name="explosivos" type="text" id="explosivos" value="<?php echo $rowDanos['explosivos'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Guardar ropa, lavado y planchado, equipaje, efectos de hu&eacute;spedes y recepci&oacute;n de dinero y valores:</td>
	  <td><input name="accesorios" type="text" id="accesorios" value="<?php echo $rowDanos['accesorios'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Limite de responsabilidad civil:</td>
	  <td><input name="limite_respCivil" type="text" id="limite_respCivil" value="<?php echo $rowDanos['limite_respCivil'] ?>" /></td>
    </tr>

    <tr>
	  <td align="right">Arrendatario $:</td>
	  <td><input name="arrendatario" type="text" id="arrendatario" value="<?php echo $rowDanos['arrendatario'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Sublimite para cobertura de arrendatario:</td>
	  <td><input name="cobertura_arrendatario" type="text" id="cobertura_arrendatario" value="<?php echo $rowDanos['cobertura_arrendatario'] ?>"/>	</td>
    </tr>

    <tr>
	  <td align="right">Estacionamiento o garaje:</td>
	  <td><input name="estacionamiento_garaje" type="text" id="estacionamiento_garaje" value="<?php echo $rowDanos['estacionamiento_garaje'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Con acomodadores:</td>
	  <td><input name="acomodadores" type="text" id="acomodadores" value="<?php echo $rowDanos['acomodadores'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Sin acomodadores:</td>
	  <td><input name="sin_acomodadores" type="text" id="acomodadores" value="<?php echo $rowDanos['acomodadores'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">N&uacute;mero de cajones:</td>
	  <td><input name="no_cajones" type="text" id="no_cajones" value="<?php echo $rowDanos['no_cajones'] ?>"/></td>
    </tr>

    <tr>
	  <td align="right">Sub limite para cobertura de estacionamieno o garaje $:</td>
	  <td><input name="sublimiteCoberturaGaraje" type="text" id="sublimiteCoberturaGaraje" value="<?php echo $rowDanos['sublimiteCoberturaGaraje'] ?>" /></td>
    </tr>

    <tr>
	  <td align="right">Sub limite por unidad $:</td>
	  <td><input name="sublimiteUnidad" type="text" id="sublimiteUnidad" value="<?php echo $rowDanos['sublimiteUnidad'] ?>"/></td>
    </tr>
    <tr>
	  <td width="150" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="DA%D1OS" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $recId; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
      <?php if($rowDanos['formResponsabilidad'] == 0){ ?>
      <input type="submit" value="guardar"  />
      </div>
      <?php }?>
      </td>
  </tr>
    </form>
         </table>
   
</body>
</html>