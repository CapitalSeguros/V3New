<?php
	$sqlCategorias = "
		Select * From 
			`tienda_categorias`
		Order By 
			`posicion` Asc
					 ";
	$resCategorias = DreQueryDB($sqlCategorias);
?>
<br><br>
<form name="formSeccion" id="formSeccion" method="post" action="includes/accionesTienda.php?action=articulos_Agregar">
<table width="900" cellpadding="2" cellspacing="2" border="0">
	<tr>
    	<td bgcolor="#C1D5E1">
        	<strong>
            	Agregar: Art&iacute;culos - Texto
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
            	<option value="<? echo $rowCategorias['idCategoria']; ?>"><? echo urldecode($rowCategorias['nombre']); ?></option>
			<?php
				}
			?>
            </select>
        </td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Nombre:</strong>
			<input type="text" name="nombre" id="nombre" style="width:90%" />
		</td>
	</tr>
	<tr bgcolor="#EAF0F4">
		<td>
			<strong>Precio: $</strong>
			<input type="text" name="precio" id="precio" style="width:9%" />
			<strong>Controla Talla</strong>
			<input type="checkbox" name="controlaTallas" id="controlaTallas" value="1" />
		</td>
	</tr>
	<tr>
		<td bgcolor="#EAF0F4" align="right">
		<input type="hidden" name="seccion" id="seccion" value="tiendaArticulos" />
		<input type="submit" name="botonSeccion" id="botonSeccion" value="Guardar" />
		&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
</form>