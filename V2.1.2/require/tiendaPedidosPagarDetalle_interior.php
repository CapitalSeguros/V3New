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
	
	$sqlConsultaUsuarioPedido = "
		Select `usuario` From
			`tienda_pedidos`
		Where
			`idPedido` = '$idPedido'
								";
	$sqlConsultaUsuarioPedidopagado = "
		Select `pagado` From
			`tienda_pedidos`
		Where
			`idPedido` = '$idPedido'
								";
	$usuarioPedido = mysql_result(DreQueryDB($sqlConsultaUsuarioPedido),0);
	$envioAdeudo = mysql_result(DreQueryDB($sqlConsultaUsuarioPedidopagado),0);
?>
<table width="900" cellpadding="1" cellspacing="1" border="0" >
	<tr>
	  <td colspan="8">&nbsp;</td>
	</tr>
<?php
if($action=="Pagar"){
?>
<form name="formPagarPedido" id="formPagarPedido" method="post" action="includes/agregar.php?tipoAgregar=PagoPedido">
	<input type="hidden" name="idPedido" id="idPedido" value="<?php echo $idPedido; ?>" />
	<input type="hidden" name="usuarioPedido" id="usuarioPedido" value="<?php echo $usuarioPedido; ?>" />
    
	<tr>
      <td colspan="6" align="right">
	  	Adeudo: <input type="text" style="width:100px;" name="importePagado" id="importePagado" title="Ingrese em Importe Cantidad" />
      </td>
      <td colspan="2" align="left">
		<input type="button" class="systemGuardar" title="Guardar Surtido" onClick="ValidarPagarPedido();"/>
		<input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "tiendaPedidosPagarDetalle.php?idPedido=".$idPedido; ?>','_self');"/>
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
    	<td align="right">&nbsp;</td>
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
    	<td bgcolor="#E5E5E5" align="right">
        	<?php
			if($envioAdeudo == 0.00){
				$urlSurtirPartida = $_SERVER['PHP_SELF'];
				$urlSurtirPartida.= "?idPedido=".$idPedido;
				$urlSurtirPartida.= "&action=Pagar";
			?>
        	<a href="<? echo $urlSurtirPartida; ?>" title="Surtir Partida">
        	<img src="img/transparente.fw.png" class="system agregar" alt="Surtir" border="0"/>
            </a>
            <?php
			}
			?>
        </td>
    </tr>
	<tr style="font-size:12px">
    	<td colspan="6" align="right">Envio Adeudo: </td>
    	<td bgcolor="#E5E5E5" align="right" style="color:#FF0004;"><strong><? echo "$".number_format($envioAdeudo,2,'.',','); ?></strong></td>
    	<td>&nbsp;</td>
    </tr>
	<tr style="font-size:12px">
    	<td colspan="6" align="right">Apoyo GAP: </td>
    	<td bgcolor="#E5E5E5" align="right" style="color:#051BCB;"><strong><? echo "$".number_format($totalPedido-$envioAdeudo,2,'.',','); ?></strong></td>
    	<td>&nbsp;</td>
    </tr>
</table>