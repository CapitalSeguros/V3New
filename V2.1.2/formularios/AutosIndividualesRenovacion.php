<script type="text/javascript">
//Carga las funciones
$(document).ready(function(){
	cargar_marca();
	$("#categoria").change(function(){dependencia_ano();});
	$("#ano").change(function(){dependencia_modelo();});
	$("#ano").attr("disabled",true);
	$("#buscar").attr("disabled",true);
});
function cargar_marca()
{
	$.get("scripts/cargar-marcas.php", function(resultado){
		if(resultado == false)
		{
			alert("No se encuentran resultados");
		}
		else
		{
			$('#categoria').append(resultado);	
		}
	});	
}
function dependencia_ano()
{
	var cod = $("#categoria").val();
	$.get("scripts/dependencia-anos.php", { cod: cod },
		function(resultado)
		{
			if(resultado == false)
			{
				alert("No se encuentran resultados");
				$("#ano").attr("disabled",true);
				$("#buscar").attr("disabled",true);
			}
			else
			{
				$("#ano").attr("disabled",false);
				$("#buscar").attr("disabled",true);
				document.getElementById("ano").options.length=1;
				$('#ano').append(resultado);			
			}
		}
	);
}
function dependencia_modelo()
{
	var code = $("#ano").val();
	var cod = $("#categoria").val();
	$.get("scripts/dependencia-modelos.php?", { code: code, cod: cod }, function(resultado){
		if(resultado == false)
		{
			alert("No se encuentran resultados");
			$("#buscar").attr("disabled",true);
		}
		else
		{
			$("#buscar").attr("disabled",false);
			document.getElementById("buscar").options.length=1;
			$('#buscar').append(resultado);			
		}
	});	
}
</script>
<?php
$sqlAutos = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resAutos = DreQueryDB($sqlAutos);
$rowAutos = mysql_fetch_assoc($resAutos);
?>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
	  <td width="100" align="right">Marca:</td>
       <td> 
       <?php
			if($rowAutos['marca_auto'] == ""){
        ?>
       <select id="categoria" name="categoria">
        <option value="0">Seleccione Marca</option>
        </select>
        <?php
			} else {
        ?>
        <select id="categoria" name="categoria">
        <option value="<?php echo $rowAutos['marca_auto']?>"><?php echo $rowAutos['marca_auto']; ?></option>
        </select>
        <?php
			}
		?>
        </td></tr>
   <tr>
	  <td width="100" align="right">A&ntilde;o:</td>
        <td>
        <?php
			if($rowAutos['year_auto'] == ""){
        ?>
        <select id="ano" name="ano">
        <option value="0">Seleccione A&ntilde;o</option>
        </select>
        <?php
			} else {
        ?>
        <select id="ano" name="ano">
        <option value="<?php echo $rowAutos['year_auto']?>"><?php echo $rowAutos['year_auto']?></option>
        </select>
         <?php
			}
		?>
        </td></tr>
	  <tr>
	  <td width="100" align="right">Modelo:</td>
        <td>
        <?php
			if($rowAutos['modelo_auto'] == ""){
        ?><select id="buscar" name="buscar">
        <option value="0">Seleccione Modelo</option>
        </select>
        <?php
			} else {
        ?>
        <select id="buscar" name="buscar">
        <option value="<?php echo $rowAutos['modelo_auto']?>"><?php echo $rowAutos['modelo_auto']?></option>
        </select>
        <?php
			}
		?>
        </td></tr>
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
	  <td><?php echo SelectTipoUso($rowAutos['tipo_uso'],$rowAutos['estatus']); ?></td>
  </tr>
    <tr>
        <td align="right">Cobertura:</td>
        <td><?php echo SelectCoberturaAuto($rowAutos['cobertura_auto'],$rowAutos['estatus']); ?></td>
      </tr>
      <tr>
        <td align="right">Valor factura:</td>
        <td><input name="valor_factura" type="text" id="valor_factura" value="<?php echo $rowAutos['valor_factura'] ?>" maxlength="30" <?php echo campoBloqueado($rowAutos['estatus']); ?>/></td>
      </tr>
      <tr>
        <td align="right">Forma pago:</td>
        <td><?php echo SelectFormaPago($rowAutos['forma_pago'],$rowAutos['estatus']); ?></td>
      </tr>
	<tr>
        <td colspan="2">Descripci&oacute;n:</td>
	</tr>
	<tr>
        <td colspan="2">
        <textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowAutos['estatus']);?>><?php echo $rowAutos['observaciones'] ?></textarea>
        </td>
	</tr>
	<tr>
        <td colspan="2">Adaptaci&oacute;n:</td>
	</tr>
	<tr>
        <td colspan="2">
        <textarea name="comentario" cols="80" id="comentario" <?php echo campoBloqueado($rowAutos['estatus']);?>><?php echo $rowAutos['comentario'] ?></textarea>
      </td>
	</tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
      
       <?php if($rowAutos['estatus'] == 0){ ?>
      <input type="button" value="guardar" onclick="java:document.formLineasPersonales.submit()" />
      &nbsp;&nbsp;&nbsp;
      <?php }?>
      </td>
  </tr>
</form>
</table>