<script language="JavaScript">
function confirmar ( mensaje ) {
  return confirm( mensaje );
} 
</script>
<?php
function DreCalculaPedidoPendiente($idPedido){
	$sql = "
		Select * From 
			`tienda_pedidos_productos` 
		Where 
			`idPedido` = '$idPedido'
		   ";
	$res = DreQueryDB($sql);
	while($row = mysql_fetch_assoc($res)){
		if($row['cantidad'] == $row['surtidos']){
			$estatusPartida[] = "Surtida";
		} else if($row['cantidad'] != $row['surtidos']){
			$estatusPartida[] = "Pendiente";
		}
	}
	if(in_array("Pendiente", $estatusPartida)){ $estatusPartidaFinal = "Si"; } else { $estatusPartidaFinal = "No"; }
	
	return print($estatusPartidaFinal);
}
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
    	<td><strong>Pendiente</strong></td>
    	<td><strong>Usuario</strong></td>
    	<td><strong>Fecha</strong></td>
    	<td align="right"><strong>Total</strong></td>
    	<td width="50">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="6"></td>
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
    	<td><? DreCalculaPedidoPendiente($rowMisPedidos['idPedido']); ?></td>
    	<td><? echo nombreUsuario($rowMisPedidos['idUsuario']); ?></td>
        <td><? echo date_format(date_create($rowMisPedidos['fecha']), 'd-M-Y'); ?></td>
    	<td align="right"><? echo "$".number_format($rowMisPedidos['totalPedido'],2,'.',','); ?></td>
    	<td align="right">
        <a href="<? echo "tiendaPedidosSurtirDetalle.php?idPedido=".$rowMisPedidos['idPedido']; ?>" class="systemTex" title="Detalle Pedido">+ Surtir</a>
		<? if($rowConsultaPedidoSurtido['surtido'] == "0"){ ?>
            &nbsp;
			<a href="<? echo "includes/accionesTienda.php?action=pedido_Borrar&idPedido=".$rowMisPedidos['idPedido']; ?>" class="systemTex" title="Cancelar Pedido" onClick="return confirmar('&iquest;Esta seguro que desea eliminar el pedido?')"><img src="img/transparente.fw.png" class="systemCancelar" alt="logout" border="0"/></a>
		<? } ?>
        </td>
    </tr>
	<tr>
    	<td colspan="6"></td>
    </tr>
<?php
	}
?>
</table>