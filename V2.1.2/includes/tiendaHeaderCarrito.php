<?php
$sqlTengoPedidos = "
	Select Count(*) From 
		`tienda_pedidos`
	Where 
		`usuario` = '$Usuario'
				   ";
if(mysql_result(DreQueryDB($sqlTengoPedidos),0)>0){
?>
<a href="tiendaMisPedidos.php" class="systemTex" title="Checa Tus Pedidos">Mis Pedidos</a>
<?php
}
?>
<?php
if(count($_SESSION['tiendaCapsys']) > 0){
?>
	<a href="tiendaVerCarrito.php" class="systemTex" title="Checa Tu Carrito">
    	| Productos: <strong><? echo	count($_SESSION['tiendaCapsys']); ?></strong> <img src="img/transparente.fw.png" class="system carrito" alt="Checa Tu Carrito" border="0"/>
    </a>
<?php
}
?>