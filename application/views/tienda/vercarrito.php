<table width="800" align="center" cellpadding="2" cellspacing="2" border="0">
    <tr>
    	<td width="150"></td>
    	<td width="550"></td>
    	<td width="100"></td>
    </tr>
	<?
	$totalPedido = 0;
	foreach($_SESSION['tiendaCapsys'] as $articulo){
		$sqlConsultaArticulo = "
			Select * From 
				`tienda_articulos`
			Where 
				`idArticulo` = '".$articulo['idArticulo']."'
							   ";
		$resConsultaArticulo = DreQueryDB($sqlConsultaArticulo);
		$rowConsultaArticulo = mysql_fetch_assoc($resConsultaArticulo);
		$importe = $articulo['precio']*$articulo['cantidad'];
	?>
	<tr>
    	<td rowspan="2">
        	<img src="<?php echo "img/tienda_articulos/".$rowConsultaArticulo['img_link']; ?>" width="150" height="124" />
        </td>
    	<td valign="top">
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo urldecode($rowConsultaArticulo['nombre']); ?>	
        </td>
    	<td valign="top">
	        <br><br>
			<a href="<?php echo "includes/tiendaBorrarCarrito.php?idArticulo=".$articulo['idArticulo']; ?>" class="systemTex" title="Eliminar">Eliminar <img src="img/transparente.fw.png" class="system eliminar" alt="Eliminar" border="0"/></a>
        </td>
	</tr>
	<tr>
		<td valign="top">
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Cantidad: <strong><?php echo $articulo['cantidad']; ?></strong>
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php 
			if(isset($articulo['talla'])){
			?>
            	Talla: <strong><?php echo $articulo['talla']; ?></strong>
            <?php
			}
			?>
            <br>
        	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font style="font-size:12px; color:#CB0003;">
            Precio Unidad: <?php echo "$".number_format($articulo['precio'],2,'.',','); ?> MXN
            </font>
		</td>
		<td width="100" valign="top" align="right">
            <font style="font-size:12px; color:#CB0003; font-weight:bold;">
            <?php echo "$".number_format($importe,2,'.',','); ?> MXN
            </font>        
        </td>
	</tr>
    <tr>
    	<td colspan="3"><hr></td>
    </tr>
	<?
	$totalPedido = $totalPedido + $importe;
	}
	?> 
    <tr style="font-size:14px; font-weight:bold;">
    	<td></td>
    	<td align="right">Importe Total</td>
    	<td align="right"><?php echo "$".number_format($totalPedido,2,'.',','); ?></td>
    </tr>
<form name="formLevantarPedido" id="formLevantarPedido" method="post" action="includes/tiendaCrearPedido.php" >
    <tr>
    	<td colspan="3" align="right">
        	<input type="hidden" name="totalPedido" id="totalPedido" value="<? echo $totalPedido; ?>" />
        	<input type="submit" value="Crear Pedido" />
        </td>
    </tr>
</form>
    <tr>
    	<td colspan="3" align="right">&nbsp;</td>
    </tr>
</table>