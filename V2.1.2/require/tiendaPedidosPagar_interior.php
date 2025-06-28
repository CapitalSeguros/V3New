<?php
	$sqlMisPedidos = "
		Select 
			*
			,`usuarios`.`VALOR` As `idUsuario`
		From 
			`tienda_pedidos` Inner Join `usuarios`
			On
			`tienda_pedidos`.`usuario` = `usuarios`.`VALOR`
		Order By
			`idPedido` Desc
					 ";
	$resMisPedidos = DreQueryDB($sqlMisPedidos);
?>
<table width="900" cellpadding="2" cellspacing="0" border="0" >
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
    	<td><strong>N&deg; de pedido</strong></td>
    	<td><strong>Usuario</strong></td>
    	<td><strong>Fecha</strong></td>
    	<td align="right"><strong>Total</strong></td>
    	<td align="right"><strong>Adeudo</strong></td>
    	<td width="50">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="6"></td>
    </tr>
<?php
	while($rowMisPedidos = mysql_fetch_assoc($resMisPedidos)){
?>
	<tr style="font-size:12px" bgcolor="#E5E5E5">
    	<td><? echo $rowMisPedidos['idPedido']; ?></td>
    	<td><? echo nombreUsuario($rowMisPedidos['idUsuario']); ?></td>
        <td><? echo date_format(date_create($rowMisPedidos['fecha']), 'd-M-Y'); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidos['totalPedido'],2,'.',','); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidos['pagado'],2,'.',','); ?></td>
    	<td align="right"><a href="<? echo "tiendaPedidosPagarDetalle.php?idPedido=".$rowMisPedidos['idPedido']; ?>" class="systemTex" title="Detalle Pedido">+ Pagar</a></td>
    </tr>
	<tr>
    	<td colspan="6"></td>
    </tr>
<?php
	}
?>
</table>