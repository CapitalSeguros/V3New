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
        	<strong>Listado de Articulos</strong>
        </td>
	</tr>
	<tr>
    	<td>
        	<table width="900" cellpadding="2" cellspacing="2" border="0">
<?php
	while($rowCategorias = mysql_fetch_assoc($resCategorias)){
?>
            	<tr>
                	<td><strong>Categoria:</strong> <? echo urldecode($rowCategorias['nombre']); ?><hr></td>
                </tr>
                <tr>
                	<td align="right">
<!-- -->
        	<table width="850" cellpadding="2" cellspacing="2" border="0" align="right">
            	<tr bgcolor="#003795" style="font-weight:bold; font-size:12px; color:#FFFFFF;">
                	<td width="670">Nombre</td>
                    <td width="100">Precio</td>
                    <td width="80">Acciones</td>
                </tr>
<?php
	
	$sqlArticulos = "
		Select * From
			`tienda_articulos`
		Where 
			`idCategoria` = '".$rowCategorias['idCategoria']."'
					";
	$resArticulos = DreQueryDB($sqlArticulos);
	while($rowArticulos = mysql_fetch_assoc($resArticulos)){
?>
            	<tr bgcolor="#EAF0F4" style="font-size:10px; font-weight:bold;">
                	<td><? echo urldecode($rowArticulos['nombre']); ?></td>
                    <td><? echo "$".number_format($rowArticulos['precio'],2,'.',','); ?></td>
                    <td>
                    	&nbsp;
                    	<a href="<?php echo "tiendaArticulosEditar.php?idArticulo=".$rowArticulos['idArticulo']; ?>" title="Clic Editar"><img src="img/24-em-pencil.png" width="24" height="24" /></a>
                        &nbsp;
                        <a href="<?php echo "includes/accionesTienda.php?action=articulos_Borrar&seccion=tiendaArticulos&idArticulo=".$rowArticulos['idArticulo']; ?>" title="Clic Borrar"><img src="img/24-em-cross.png" width="24" height="24" /></a>

                    </td>
                </tr>
<?php
	}
?>
            </table>
<!-- -->
                    </td>
                </tr>
<?php
	}
?>
            </table>
        </td>
	</tr>
</table>