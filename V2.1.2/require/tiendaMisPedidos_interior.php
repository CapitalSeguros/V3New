<script language="JavaScript">
function confirmar ( mensaje ) {
  return confirm( mensaje );
} 
</script>
<?php
	$sqlMisPedidos = "
		Select * From 
			`tienda_pedidos`
		Where
			`usuario` = '$Usuario'
					 ";
	$resMisPedidos = DreQueryDB($sqlMisPedidos);
?>
<table width="900" cellpadding="2" cellspacing="0" border="0" >
	<tr>
	  <td colspan="4">&nbsp;</td>
  </tr>
	<tr>
	  <td colspan="4" class="TextoTitulosSeccion" style="font-size:22px;">Mis Pedidos</td>
  </tr>
	<tr>
	  <td colspan="4">&nbsp;</td>
  </tr>
	<tr style="font-size:12px;" bgcolor="#CCCCCC" height="30">
    	<td><strong>N&deg; de pedido</strong></td>
    	<td><strong>Fecha</strong></td>
    	<td align="right"><strong>Total</strong></td>
    	<td width="50">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="4"></td>
    </tr>
<?php
	
	while($rowMisPedidos = mysql_fetch_assoc($resMisPedidos)){
		$sqlConsultaPedidoSurtido = "
			Select Count(*) As `surtido` From 
				`tienda_pedidos_surtido`
			Where 
				`idPedido` = '$rowMisPedidos[idPedido]'
									";
		$resConsultaPedidoSurtido = DreQueryDB($sqlConsultaPedidoSurtido);
		$rowConsultaPedidoSurtido = mysql_fetch_assoc($resConsultaPedidoSurtido);
?>
	<tr style="font-size:12px" bgcolor="#E5E5E5">
    	<td><? echo $rowMisPedidos['idPedido']; ?></td>
        <td><? echo date_format(date_create($rowMisPedidos['fecha']), 'd-M-Y'); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidos['totalPedido'],2,'.',','); ?></td>
    	<td align="right">
        	<a href="<? echo "tiendaMisPedidosDetalle.php?idPedido=".$rowMisPedidos['idPedido']; ?>" class="systemTex" title="Detalle Pedido">+ Info</a>
		<? if($rowConsultaPedidoSurtido['surtido'] == "0"){ ?>
            &nbsp;
			<a href="<? echo "includes/accionesTienda.php?action=pedido_Borrar&idPedido=".$rowMisPedidos['idPedido']; ?>" class="systemTex" title="Cancelar Pedido" onClick="return confirmar('&iquest;Esta seguro que desea eliminar el pedido?')"><img src="img/transparente.fw.png" class="systemCancelar" alt="logout" border="0"/></a>
		<? } ?>
		</td>
    </tr>
	<tr>
    	<td colspan="4"></td>
    </tr>
<?php
	}
?>
</table>