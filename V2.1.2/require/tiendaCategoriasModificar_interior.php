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
<table width="900" cellpadding="1" cellspacing="2" border="0" align="center">
	<tr>
    	<td>
        	<strong>Listado de Categorias</strong>
        </td>
	</tr>
	<tr>
    	<td>
        	<table width="900" cellpadding="2" cellspacing="2" border="0">
            	<tr bgcolor="#003795" style="font-weight:bold; font-size:12px; color:#FFFFFF;">
                	<td width="720">Nombre</td>
                    <td width="100">Imagen</td>
                    <td width="80">Acciones</td>
                </tr>
<?php
	while($rowCategorias = mysql_fetch_assoc($resCategorias)){
?>
            	<tr bgcolor="#EAF0F4">
                	<td><? echo urldecode($rowCategorias['nombre']); ?></td>
                    <td>
                    	<img src="<? echo "img/tienda_categorias/".$rowCategorias['img_link']; ?>" width="100" height="80" />
                    </td>
                    <td>
                    	&nbsp;
                    	<a href="<?php echo "tiendaCategoriasEditar.php?idCategoria=".$rowCategorias['idCategoria']; ?>" title="Clic Editar"><img src="img/24-em-pencil.png" width="24" height="24" /></a>
                        &nbsp;
                        <a href="<?php echo "includes/accionesTienda.php?action=categorias_Borrar&seccion=tiendaCategorias&idCategoria=".$rowCategorias['idCategoria']; ?>" title="Clic Borrar"><img src="img/24-em-cross.png" width="24" height="24" /></a>

                    </td>
                </tr>
<?php
	}
?>
            </table>
        </td>
	</tr>
</table>