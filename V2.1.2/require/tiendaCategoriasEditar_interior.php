<?php
$sqlCategorias = "
	Select * From
		`tienda_categorias`
	Where
		`idCategoria` = '$idCategoria'
				 ";
$resCategorias = DreQueryDB($sqlCategorias);
$rowCategorias = mysql_fetch_assoc($resCategorias);
?>
<br><br>
<table width="900" cellpadding="2" cellspacing="2" border="0">
<form name="formSeccion" id="formSeccion" method="post" action="includes/accionesTienda.php?action=categorias_Editar">
	<tr>
    	<td bgcolor="#C1D5E1">
        	<strong>
            	Editar: Categor&iacute;as - Texto / Imagen
			</strong>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Nombre:</strong>
			<input type="text" name="nombre" id="nombre" value="<? echo urldecode($rowCategorias['nombre']); ?>" style="width:90%" />
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Posici&oacute;:</strong>
			<input type="text" name="posicion" id="posicion" value="<? echo $rowCategorias['posicion']; ?>" style="width:5%" />
		</td>
	</tr>
	<tr>
		<td bgcolor="#EAF0F4" align="right">
		<input type="hidden" name="seccion" id="seccion" value="tiendaCategorias" />
		<input type="hidden" name="idCategoria" id="idCategoria" value="<? echo $idCategoria; ?>" />
		<input type="submit" name="botonSeccion" id="botonSeccion" value="Guardar" />
		&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</form>
	<tr>
		<td>&nbsp;
        	
        </td>
	</tr>
<!-- -->
<form name="formImagenSeccion" id="formImagenSeccion" method="post" enctype="multipart/form-data" action="includes/accionesTienda.php?action=categorias_ImgPortada">
	<tr>
		<td bgcolor="#C1D5E1">
		<strong>
			Cambiar Imagen: Portada Categoria
		</strong>
		</td>
	</tr>
	<tr bgcolor="#EAF0F4" align="center">
		<td valign="top">
		<br>
			<img src="<?php echo "img/tienda_categorias/".$rowCategorias['img_link']; ?>" width="150" />
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
			<input type="hidden" name="source" id="source" value="<?php echo "Categoria_".$rowCategorias['idCategoria'].".png"; ?>" />
			<input type="hidden" name="idCategoria" id="idCategoria" value="<?php echo $rowCategorias['idCategoria']; ?>" />
			<input type="hidden" name="seccion" id="seccion" value="tiendaCategorias" />
			<input type="submit" name="botonImagenSeccion" id="botonImagenSeccion" value="Guardar Imagen" />
			&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</form>
<!-- -->
</table>