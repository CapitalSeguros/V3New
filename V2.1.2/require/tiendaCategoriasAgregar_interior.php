<?php
$sqlCategorias = "
	Select * From
		`tienda_categorias`
				 ";
$resCategorias = DreQueryDB($sqlCategorias);
?>
<br><br>
<form name="formSeccion" id="formSeccion" method="post" action="includes/accionesTienda.php?action=categorias_Agregar">
<table width="900" cellpadding="2" cellspacing="2" border="0">
	<tr>
    	<td bgcolor="#C1D5E1">
        	<strong>
            	Agregar: Categor&iacute;as - Texto
			</strong>
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
			<strong>Posici&oacute;:</strong>
			<input type="text" name="posicion" id="posicion" style="width:5%" />
		</td>
	</tr>
	<tr>
		<td bgcolor="#EAF0F4" align="right">
		<input type="hidden" name="seccion" id="seccion" value="tiendaCategorias" />
		<input type="submit" name="botonSeccion" id="botonSeccion" value="Guardar" />
		&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
</form>