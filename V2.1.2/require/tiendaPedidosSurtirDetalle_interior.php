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
	  <td colspan="8">&nbsp;</td>
	</tr>
<?php
if($action=="Surtir"){
?>
<form name="formSurtirPartida" id="formSurtirPartida" method="post" action="includes/agregar.php?tipoAgregar=SurtidoPartida">
	<input type="hidden" name="idPartida" id="idPartida" value="<?php echo $idPartida; ?>" />
	<input type="hidden" name="idPedido" id="idPedido" value="<?php echo $idPedido; ?>" />
	<tr>
      <td colspan="6" align="right">
	  	<? echo $nombreArticulo; ?>: <input type="text" style="width:30px;" name="cantidadSurtida" id="cantidadSurtida" title="Ingrese la Cantidad" />
      </td>
      <td colspan="2" align="left">
		<input type="button" class="systemGuardar" title="Guardar Surtido" onClick="ValidarAgregarSurtido();"/>
		<input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "tiendaPedidosSurtirDetalle.php?idPedido=".$idPedido; ?>','_self');"/>
      </td>
	</tr>
</form>
<?php
}
?>
	<tr>
	  <td colspan="8" class="TextoTitulosSeccion" style="font-size:22px;">Mis Pedidos</td>
	</tr>
	<tr>
	  <td colspan="8">&nbsp; Detalle del pedido # <strong><? echo $idPedido; ?></strong></td>
	</tr>
	<tr style="font-size:12px;" bgcolor="#CCCCCC" height="30">
    	<td><strong>Art&iacute;culo</strong></td>
    	<td width="90" align="center"><strong>Surtido</strong></td>
    	<td width="90" align="center"><strong>Pendiente</strong></td>
    	<td width="90" align="center"><strong>Talla</strong></td>
    	<td width="90" align="center"><strong>Cantidad</strong></td>
    	<td width="100" align="right"><strong>Precio</strong></td>
    	<td width="100" align="right"><strong>Total</strong></td>
    	<td width="20" align="right">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="8"></td>
    </tr>
<?php
	$totalPedido = 0;
	while($rowMisPedidosDetalle = mysql_fetch_assoc($resMisPedidosDetalle)){
		$idPartida = $rowMisPedidosDetalle['idPartida'];
		$totalPendiente = $rowMisPedidosDetalle['cantidad']-$rowMisPedidosDetalle['surtidos'];
?>
	<tr style="font-size:12px" bgcolor="#E5E5E5">
    	<td align="justify"><? echo "&nbsp;&nbsp;&nbsp;".urldecode($rowMisPedidosDetalle['nombre']); ?></td>
    	<td align="justify">&nbsp;</td>
    	<td align="justify">&nbsp;</td>
        <td align="center"><? echo "&nbsp;&nbsp;&nbsp;".$rowMisPedidosDetalle['talla']; ?></td>
    	<td align="center"><? echo "&nbsp;&nbsp;&nbsp;".$rowMisPedidosDetalle['cantidad']; ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidosDetalle['precio'],2,'.',','); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidosDetalle['importe'],2,'.',','); ?></td>
    	<td align="right">
        	<?php
			if($totalPendiente > 0){
				$urlSurtirPartida = $_SERVER['PHP_SELF'];
				$urlSurtirPartida.= "?idPedido=".$idPedido;
				$urlSurtirPartida.= "&action=Surtir&idPartida=".$idPartida;
				$urlSurtirPartida.= "&nombreArticulo=".$rowMisPedidosDetalle['nombre'];
			?>
        	<a href="<? echo $urlSurtirPartida; ?>" title="Surtir Partida">
        	<img src="img/transparente.fw.png" class="system agregar" alt="Surtir" border="0"/>
            </a>
            <?php
			}
			?>
        </td>
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
	<tr>
    	<td colspan="8"></td>
    </tr>
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
    	<td>&nbsp;</td>
    	<td bgcolor="#E5E5E5" align="right"><strong><? echo "$".number_format($totalPedido,2,'.',','); ?></strong></td>
    	<td bgcolor="#E5E5E5" align="right">&nbsp;</td>
    </tr>
</table>