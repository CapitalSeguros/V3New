<?php
	$sqlMisPedidosDetalle = "
		Select * From 
			`tienda_pedidos_productos` Inner Join `tienda_articulos` 
			On 
			`tienda_pedidos_productos`.`idProducto` = `tienda_articulos`.`idArticulo`
		Where
			`idPedido` = '$idPedido'
					 ";
	$resMisPedidosDetalle = DreQueryDB($sqlMisPedidosDetalle);
?>
<table width="900" cellpadding="1" cellspacing="1" border="0" >
	<tr>
	  <td colspan="6">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="6" class="TextoTitulosSeccion" style="font-size:22px;">Mis Pedidos</td>
  </tr>
	<tr>
	  <td colspan="6">&nbsp;</td>
  </tr>
	<tr style="font-size:12px;" bgcolor="#CCCCCC" height="30">
    	<td><strong>Art&iacute;culo</strong></td>
    	<td width="90" align="center"><strong>Surtido</strong></td>
    	<td width="90" align="center"><strong>Talla</strong></td>
    	<td width="90" align="center"><strong>Cantidad</strong></td>
    	<td width="100" align="right"><strong>Precio</strong></td>
    	<td width="100" align="right"><strong>Total</strong></td>
    </tr>
	<tr>
    	<td colspan="6"></td>
    </tr>
<?php
	$totalPedido = 0;
	while($rowMisPedidosDetalle = mysql_fetch_assoc($resMisPedidosDetalle)){
?>
	<tr style="font-size:12px" bgcolor="#E5E5E5">
    	<td align="justify"><? echo "&nbsp;&nbsp;&nbsp;".urldecode($rowMisPedidosDetalle['nombre']); ?></td>
    	<td align="justify">&nbsp;</td>
        <td align="center"><? echo "&nbsp;&nbsp;&nbsp;".$rowMisPedidosDetalle['talla']; ?></td>
    	<td align="center"><? echo "&nbsp;&nbsp;&nbsp;".$rowMisPedidosDetalle['cantidad']; ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidosDetalle['precio'],2,'.',','); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidosDetalle['importe'],2,'.',','); ?></td>
    </tr>
	<tr>
    	<td colspan="6"></td>
    </tr>
    <?php
		$sqlSurtidoPartidas = "
			Select * From 
				`tienda_pedidos_surtido`
			Where
				`idPedido` = '$rowMisPedidosDetalle[idPedido]'
				And 
				`idPartida` = '$rowMisPedidosDetalle[idPartida]'
							  ";
			$resSurtidoPartidas = DreQueryDB($sqlSurtidoPartidas);
			while($rowSurtidoPartidas = mysql_fetch_assoc($resSurtidoPartidas)){
	?>
	<tr style="font-size:12px">
    	<td bgcolor="#E5E5E5" align="center"><?php echo $rowSurtidoPartidas['fechaSurtio']; ?></td>
    	<td bgcolor="#E5E5E5" align="center"><?php echo $rowSurtidoPartidas['cantidadSurtida']; ?></td>
    	<td bgcolor="#E5E5E5" align="center"><?php echo $totalPendiente; ?></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    	<td></td>
    </tr>
	<?php
			}
	?>
<?php
	$totalPedido = $totalPedido + $rowMisPedidosDetalle['importe'] ;
	}
?>
	<tr style="font-size:12px">
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td bgcolor="#E5E5E5" align="right"><strong><? echo "$".number_format($totalPedido,2,'.',','); ?></strong></td>
    </tr>
</table>