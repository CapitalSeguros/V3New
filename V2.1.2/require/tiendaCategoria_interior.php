<?php
$sqlCategorias = "
	Select * From
		`tienda_categorias`
	Where 
		`idCategoria` = '$idCategoria'
				 ";
$resCategorias = DreQueryDB($sqlCategorias);
$rowCategorias = mysql_fetch_assoc($resCategorias);


$corte = 0;
$columnas = 4;
$sqlArticulos = "
	Select * From
		`tienda_articulos`
	Where 
		`idCategoria` = '$idCategoria'
				 ";
$resArticulos = DreQueryDB($sqlArticulos);
?>
<br><br>
<table width="900" cellpadding="1" cellspacing="2" border="0" align="center">
<tr>
	<td colspan="4" class="TextoTitulosSeccion" style="font-size:20px;">
    	<?php echo urldecode($rowCategorias['nombre']); ?>
    </td>
</tr>
<tr>
<?php
while ($rowArticulos = mysql_fetch_assoc($resArticulos)) {
	extract($rowArticulos);
if ($corte < $columnas) { 
?>
<td width="225" align="center" valign="top">
	<!-- Contenido de Cada Celda -->
        <br><br>
    <form name="formArticulo" id="form" method="post" action="includes/tiendaAgregarCarrito.php">
    <table width="200" cellpadding="0" cellspacing="0" border="0">
    	<tr>
        	<td colspan="2" align="center">
            	<img src="<? echo "img/tienda_articulos/".$img_link ?>" width="200" height="240" border="0" title="<? echo urldecode($nombre); ?>" alt="<? echo $nombre; ?>" />
            </td>
        </tr>
    	<tr height="6">
        	<td colspan="2"></td>
        </tr>
    	<tr valign="top">
        	<td width="150" style="font-size:10px; color:#666666;">
            	<? echo urldecode($nombre); ?>
            </td>
            <td width="50" align="right" style="font-size:12px; font-weight:bold;">
            	<? echo "$".number_format($precio,2,'.',',')."<br>MXN"; ?>
            </td>
        </tr>
    	<tr height="9">
        	<td colspan="2"></td>
        </tr>
    	<tr>
<?php
if($controlaTallas == "1"){
?>
        	<td align="right" valign="bottom" style="font-size:12px; color:#6F6F6F;">
            	<select name="talla" id="talla" style="width:95%">
                	<option value="">Seleccione Talla</option>
                	<option value="Ch">Ch</option>
                	<option value="M" selected>M</option>
                	<option value="G">G</option>
                </select>
                <br>
                Cantidad
                <input type="text" id="cantidad" name="cantidad" value="1" style="width:25%; text-align:center;" >
            </td>
<?php
} else {
?>
        	<td align="right" valign="bottom" style="font-size:12px; color:#6F6F6F;">
                Cantidad
                <input type="text" id="cantidad" name="cantidad" value="1" style="width:25%; text-align:center;" >
            </td>
<?php
}
?>
        	<td valign="bottom">
                <input type="hidden" id="idArticulo" name="idArticulo" value="<? echo $idArticulo; ?>" >
                <input type="hidden" id="precio" name="precio" value="<? echo $precio; ?>" >
                <input type="hidden" id="idCategoria" name="idCategoria" value="<?php echo $idCategoria; ?>" />              
            	<input type="submit" class="ButtonGeneral" value="Agregar" />
                <!-- onClick="JavaScript: window.open('<? echo $urlAgregarCarrito; ?>','_self');" -->
            </td>
        </tr>
    </table>
    </form>
</td>
<?php
$corte = $corte+1; 
} else {
$corte = 0; 
?>
</tr>
<tr>
<td width="225" align="center" valign="top">
	<!-- Contenido de Cada Celda -->
        <br><br>
    <form name="formArticulo" id="form" method="post" action="includes/tiendaAgregarCarrito.php">
    <table width="200" cellpadding="0" cellspacing="0" border="0">
    	<tr>
        	<td colspan="2" align="center">
            	<img src="<? echo "img/tienda_articulos/".$img_link ?>" width="200" height="240" border="0" title="<? echo urldecode($nombre); ?>" alt="<? echo $nombre; ?>" />
            </td>
        </tr>
    	<tr height="6">
        	<td colspan="2"></td>
        </tr>
    	<tr valign="top">
        	<td width="150" style="font-size:10px; color:#666666;">
            	<? echo urldecode($nombre); ?>
            </td>
            <td width="50" align="right" style="font-size:12px; font-weight:bold;">
            	<? echo "$".number_format($precio,2,'.',',')."<br>MXN"; ?>
            </td>
        </tr>
    	<tr height="9">
        	<td colspan="2"></td>
        </tr>
    	<tr>
<?php
if($controlaTallas == "1"){
?>
        	<td align="right" valign="bottom" style="font-size:12px; color:#6F6F6F;">
            	<select name="talla" id="talla" style="width:95%">
                	<option>Seleccione Talla</option>
                	<option>Ch</option>
                	<option>M</option>
                	<option>G</option>
                </select>
                <br>
                Cantidad
                <input type="text" id="cantidad" name="cantidad" value="1" style="width:25%; text-align:center;" >
            </td>
<?php
} else {
?>
        	<td align="right" valign="bottom" style="font-size:12px; color:#6F6F6F;">
                Cantidad
                <input type="text" id="cantidad" name="cantidad" value="1" style="width:25%; text-align:center;" >
            </td>
<?php
}
?>
        	<td valign="bottom">
                <input type="hidden" id="idArticulo" name="idArticulo" value="<? echo $idArticulo; ?>" >
                <input type="hidden" id="precio" name="precio" value="<? echo $precio; ?>" >
                <input type="hidden" id="idCategoria" name="idCategoria" value="<?php echo $idCategoria; ?>" />                 
            	<input type="submit" class="ButtonGeneral" value="Agregar" />
                <!-- onClick="JavaScript: window.open('<? echo $urlAgregarCarrito; ?>','_self');" -->
            </td>
        </tr>
    </table>
    </form>
</td>
<?php
$corte = $corte+1; 
} // fin del else en el if
} // fin del While
?>
</tr>
</table>