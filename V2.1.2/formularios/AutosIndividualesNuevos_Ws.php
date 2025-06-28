<?php
if($wsAseguradoraParticular == "ABA"){
	require_once('nusoap-0.9.5-Aba/lib/nusoap.php');
} else {
	require_once('nusoap-0.9.5/lib/nusoap.php');
}
	$yearStart = 2000;
	$yearEnd = 2015;
?>
<script>
	function muestraValorFactura(idCampo,valorCampo){
		var elElemento=document.getElementById(idCampo);
		if(valorCampo == "vF"){
			if(elElemento.style.display == 'block'){
				elElemento.style.display = 'none';
				elElemento.value = '';
			} else {
				elElemento.style.display = 'block';
			}
		} else {
				elElemento.style.display = 'none';
				elElemento.value = '';
		}
	}

	$(function() {
		<?php		
// --> 		
$client = new nusoap_client('http://201.151.239.108/wsTarifa/wsTarifa.asmx?WSDL', true);
	$cMarca = $wsMarca; //"DODGE";//"VOLKSWAGEN";
	$cCAMIS = ""; //7117
	$cModelo = $wsYear; // "2010";//"2012";
	$cVersion = "";
$param = array(
				'cUsuario' => 'linea'
				,'cTarifa' => 'linea'
				,'cMarca' => $cMarca
				,'cTipo' => ''
				,'cVersion' => $cVersion
				,'cModelo'=> $cModelo
				,'cCAMIS' => $cCAMIS
				,'cCategoria' => ''
				,'cNvaAMIS' => ''
			  );
$result = $client->call('listaTarifas', array('parameters' => $param), '', '', false, true);

	// Proceso para presentacion del XML obtenido
$debug =  htmlspecialchars($client->request, ENT_QUOTES);
$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);
$cosasQuitaXml = array('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','</soap:Body></soap:Envelope>','&');
$cosasPonerXml = array('','','');
$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);

		$fileXML = "xmlTodos/qualitas/test/listaTarifas".date('dmY_Gis').'.xml';
		file_put_contents($fileXML, $respuestaXmlDepurada);

$datosSubMarca = simplexml_load_string($respuestaXmlDepurada);

	foreach($datosSubMarca->listaTarifasResult->salida->datos->Elemento as $vehiculo){
		$vehiculo->cTipo." ".$vehiculo->cVersion;
		$vehiculo->CAMIS;
	 	if(!strstr($vehiculo->cVersion,'SERVPUB',false)){
			$elementosModelos[]= '"'.str_replace('"','\"',$vehiculo->cTipo)." ".str_replace('"','\"',$vehiculo->cVersion)." **".$vehiculo->CAMIS.'"'; //--> DreSinAcentos()
		}
	}
		$arregloModelos = implode(", ", $elementosModelos);//junta los valores del array en una sola cadena de texto
		?>		
		var availableTagsModelos = new Array(<?php echo $arregloModelos; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#wsModelo" ).autocomplete({
			source: availableTagsModelos
		});
	});
</script>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
<form name="formWsMarca" id="formWsMarca" method="get" action="actividadesDetalle.php#Formularios">
	<tr>
		<td width="100" align="right">Marca:</td>
        <td>
<!--        	<input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" /> -->
<!--        	<input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" /> -->
<!--        	<input type="hidden" name="form" id="form" value="<?php echo $form; ?>" /> -->
            <select name="wsMarca" id="wsMarca"><!-- onchange="JavaScript: document.formWsMarca.submit();" -->
            	<option value="">-- Seleccione --</option>
                <?php
					$sqlMarcas = "
						Select `NombreMarcaLarga` From 
							`ws_catalogo_marcas_qualitas`
								 ";
					$resMarcas = DreQueryDB($sqlMarcas);
					while($rowMarcas = mysql_fetch_assoc($resMarcas)){
				?>
            	<option value="<?php echo $rowMarcas['NombreMarcaLarga']; ?>" <? echo ($rowMarcas['NombreMarcaLarga']==$wsMarca )?"selected":""; ?>><?php echo $rowMarcas['NombreMarcaLarga']; ?></option>
                <?php
					}
				?>
            </select>
		</td>
	</tr>
<!-- </form> -->
<!-- <form name="formWsYear" id="formWsYear" method="get" action="actividadesDetalle.php#Formularios"> -->
	<tr>
		<td width="100" align="right">A&ntilde;o:</td>
		<td>
        
        	<input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
        	<input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" />
        	<input type="hidden" name="form" id="form" value="<?php echo $form; ?>" />
<!--        	<input type="hidden" name="wsMarca" id="wsMarca" value="<?php echo $wsMarca; ?>" /> -->
            <select name="wsYear" id="wsYear" onchange="JavaScript: document.formWsMarca.submit();"> <!-- onchange="JavaScript: document.formWsYear.submit();" -->
            	<option value="">-- Seleccione --</option>
                <?php
					while($yearStart <= $yearEnd){
			?>
            	<option value="<? echo $yearStart; ?>" <? echo ($yearStart ==$wsYear)? "selected":""; ?>><? echo $yearStart; ?></option>
            <?php
				$yearStart++;
					}
			?>
            </select>
		</td>
	</tr>
</form>

<form name="formAutosInvididualesNuevos" id="formAutosInvididualesNuevos" method="post" action="actividadesDetalle.php#Formularios">
<!-- actividadesDetalle.php#Formularios  includes/ws/wsGeneral.php -->
	<tr>
		<td width="100" align="right">Descripcion:</td>
		<td>
			<input type="text" name="wsModelo" id="wsModelo" style="width:90%; " />
		</td>
	</tr>
	<tr>
		<td align="right">
			Estado:
		</td>
		<td><?php echo SelectEstado($rowAutos['estado'],$rowAutos['estatus']); ?></td>
	</tr>
	<tr>
    	<td width="100" align="right">
    		Codigo Postal:
    	</td>
        <td><input name="codigo_postal" type="text" id="codigo_postal" value="<?php echo $rowAutos['codigo_postal'] ?>" maxlength="30" <?php echo campoBloqueado($rowAutos['estatus']); ?>/></td>
	</tr>
	<tr>
	  <td align="right">Tipo uso:</td>
	  <td>
	  		<?php //echo SelectTipoUso($rowAutos['tipo_uso'],$rowAutos['estatus']); ?>
            <select name="tipo_uso" id="tipo_uso">
				<option value=""> -Seleccione- </option>
                <option value="01-PARTICULAR">01-PARTICULAR</option>
            </select>
            
	  </td>
  </tr>
    <tr>
        <td align="right">Cobertura:</td>
        <td>
			<?php // echo SelectCoberturaAuto($rowAutos['cobertura_auto'],$rowAutos['estatus']); ?>
			<select name="cobertura_auto" id="cobertura_auto">
            	<option value=""> -Seleccione- </option>
	            <option value="Amplia">Amplia</option>        
            </select>
        </td>
      </tr>
<!--      
      <tr>
        <td align="right">Valor factura:</td>
        <td><input name="valor_factura" type="text" id="valor_factura" value="<?php echo $rowAutos['valor_factura'] ?>" maxlength="30" <?php echo campoBloqueado($rowAutos['estatus']); ?>/></td>
      </tr>
-->
      <tr>
        <td align="right">Forma pago:</td>
        <td><?php echo SelectFormaPago($rowAutos['forma_pago'],$rowAutos['estatus'], $Grupo); ?></td>
      </tr>
      <tr>
        <td align="right">Suma Asegurada:</td>
        <td>
        	<select name="sumaAsegurada" id="sumaAsegurada" onChange="muestraValorFactura('valorFactura',this.value);" >
            	<option value="vC"> -Seleccione- </option>
                <?php
				if($wsYear == date('Y')){
				?>
            	<option value="vF">Valor Factura</option>
                <?php
				}
				?>
            	<option value="vC">Valor Convenio</option>
            </select>
            <input type="text" name="valorFactura" id="valorFactura" style="display:none;" onKeyPress="return(currencyFormat(this,',','.',event))" />
        </td>
      </tr>
      <tr>
        <td align="right">Plazo Pago:</td>
        <td>
        	<select name="plazoPago" id="plazoPago" >
            	<option value="14"> -Seleccione- </option>
            	<option value="14">14 d&iacute;as</option>
            	<option value="30">30 d&iacute;as</option>
            </select>
        </td>
      </tr>
<?php
if($_SESSION['WebDreTacticaWeb2']['Integral'] == "1"){
?>
      <tr>
        <td align="right">Descuento:</td>
        <td><?php echo SelectDescuentoAseguradora('Qualitas', 20, 1, 0); ?></td>
      </tr>
<?php
}
?>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $rowActividad['idRef']; ?>" />
      <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $Usuario; ?>" />
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />      
      <input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
      <input type="hidden" name="wsMarca" id="wsMarca" value="<?php echo $wsMarca; ?>" />
      <input type="hidden" name="wsYear" id="wsYear" value="<?php echo $wsYear; ?>" />
      <input type="hidden" name="wsAseguradoraParticular" id="wsAseguradoraParticular" value="QUALITAS" />
      <input type="hidden" name="muestra" id="muestra" value="Formularios" />
      <input type="button" value="Continuar" onclick="java:document.formAutosInvididualesNuevos.submit()" />
      &nbsp;&nbsp;&nbsp;
      </td>
  </tr>
</form>
</table>
<script language="JavaScript"> 
   function currencyFormat(fld, milSep, decSep, e) { 
    var sep = 0; 
    var key = ''; 
    var i = j = 0; 
    var len = len2 = 0; 
    var strCheck = '0123456789'; 
    var aux = aux2 = ''; 
    var whichCode = (window.Event) ? e.which : e.keyCode; 
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode);
    if (strCheck.indexOf(key) == -1) return false;
    len = fld.value.length; 
    for(i = 0; i < len; i++) 
     if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break; 
    aux = ''; 
    for(; i < len; i++) 
     if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i); 
    aux += key; 
    len = aux.length; 
    if (len == 0) fld.value = ''; 
    if (len == 1) fld.value = '0'+ decSep + '0' + aux; 
    if (len == 2) fld.value = '0'+ decSep + aux; 
    if (len > 2) { 
     aux2 = ''; 
     for (j = 0, i = len - 3; i >= 0; i--) { 
      if (j == 3) { 
       aux2 += milSep; 
       j = 0; 
      } 
      aux2 += aux.charAt(i); 
      j++; 
     } 
     fld.value = ''; 
     len2 = aux2.length; 
     for (i = len2 - 1; i >= 0; i--) 
      fld.value += aux2.charAt(i); 
     fld.value += decSep + aux.substr(len - 2, len); 
    } 
    return false; 
   }    
</script>