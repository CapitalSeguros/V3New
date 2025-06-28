<?php
	$sqlCategorias = "
		Select * From 
			`tienda_categorias`
		Order By 
			`posicion` Asc
					 ";
	$resCategorias = DreQueryDB($sqlCategorias);
	
	$sqlArticulos = "
		Select * From 
			`tienda_articulos`
		Where
			`idArticulo` = '$idArticulo'
					";
	$resArticulos = DreQueryDB($sqlArticulos);
	$rowArticulos = mysql_fetch_assoc($resArticulos);
?>
<br><br>
<table width="900" cellpadding="2" cellspacing="2" border="0">
<form name="formSeccion" id="formSeccion" method="post" action="includes/accionesTienda.php?action=articulos_Editar">
	<tr>
    	<td bgcolor="#C1D5E1">
        	<strong>
            	Editar: Art&iacute;culos - Texto / Imagen
			</strong>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
        	<strong>Categoria:</strong>
            <select name="idCategoria" id="idCategoria">
            	<option value="">-- Seleccione --</option>
			<?php
				while($rowCategorias = mysql_fetch_assoc($resCategorias)){
			?>
            	<option value="<? echo $rowCategorias['idCategoria']; ?>" <? echo ($rowArticulos['idCategoria'] == $rowCategorias['idCategoria'])? "selected":""; ?>><? echo urldecode($rowCategorias['nombre']); ?></option>
			<?php
				}
			?>
            </select>
        </td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Nombre:</strong>
			<input type="text" name="nombre" id="nombre" value="<? echo urldecode($rowArticulos['nombre']); ?>" style="width:90%" />
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Precio: $</strong>
			<input type="text" name="precio" id="precio" value="<? echo $rowArticulos['precio']; ?>" style="width:9%" />
			<strong>Controla Talla</strong>
			<input type="checkbox" name="controlaTallas" id="controlaTallas" value="1" <? echo ($rowArticulos['controlaTallas'] == 1)? "checked":""; ?> />
		</td>
	</tr>
	<tr>
		<td bgcolor="#EAF0F4" align="right">
        <input type="hidden" name="idArticulo" id="idArticulo" value="<? echo $rowArticulos['idArticulo']; ?>" />
		<input type="hidden" name="seccion" id="seccion" value="tiendaArticulos" />
		<input type="submit" name="botonSeccion" id="botonSeccion" value="Guardar" />
		&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</form>
	<tr>
    	<td>&nbsp;</td>
    </tr>
<!-- -->
<form name="formImagenSeccion" id="formImagenSeccion" method="post" enctype="multipart/form-data" action="includes/accionesTienda.php?action=articulos_ImgPortada">
	<tr>
		<td bgcolor="#C1D5E1">
		<strong>
			Cambiar Imagen: Articulo
		</strong>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4" align="center">
		<td valign="top">
		<br>
			<img src="<?php echo "img/tienda_articulos/".$rowArticulos['img_link']; ?>" width="150" />
		<br>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td align="center">
			<input type="file" name="fileImg" id="fileImg" />
			<br>
			<font style="font-size:10px;">
				Las imagenes de esta secci&oacute;n deben de ser de 300 x 250 pixeles con calidad de 72 dpi en PNG
			</font>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td align="right">
			<input type="hidden" name="source" id="source" value="<?php echo "Articulo_".$rowArticulos['idArticulo'].".png"; ?>" />
			<input type="hidden" name="idArticulo" id="idArticulo" value="<?php echo $rowArticulos['idArticulo']; ?>" />
			<input type="hidden" name="seccion" id="seccion" value="tiendaArticulos" />
			<input type="submit" name="botonImagenSeccion" id="botonImagenSeccion" value="Guardar Imagen" />
			&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</form>
<!-- -->
</table>