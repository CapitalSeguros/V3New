<?php
$corte = 0;
$columnas = 3;
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
<?php
while ($rowCategorias = mysql_fetch_assoc($resCategorias)) {
	extract($rowCategorias);
if ($corte < $columnas) { 
?>
<td width="300" align="center" valign="top">
	<!-- Contenido de Cada Celda -->
    <a href="<?php echo "tiendaCategoria.php?idCategoria=".$idCategoria; ?>" title="Clic Para Entrar">
    <img src="<? echo "img/tienda_categorias/".$img_link ?>" width="280" border="0" title="<? echo "Categoria ".urldecode($nombre); ?>" alt="<? echo $nombre; ?>" />
    </a>
</td>
<?php
$corte = $corte+1; 
} else {
$corte = 0; 
?>
</tr>
<tr>
<td width="300" align="center" valign="top">
	<!-- Contenido de Cada Celda -->
    <a href="<?php echo "tiendaCategoria.php?idCategoria=".$idCategoria; ?>" title="Clic Para Entrar">
    <img src="<? echo "img/tienda_categorias/".$img_link ?>" width="280" border="0" title="<? echo "Categoria ".urldecode($nombre); ?>" alt="<? echo $nombre; ?>" />
    </a>
</td>
<?php
$corte = $corte+1; 
} // fin del else en el if
} // fin del While
?>
</tr>
</table>