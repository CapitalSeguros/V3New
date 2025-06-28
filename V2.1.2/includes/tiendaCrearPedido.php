<?php
extract($_REQUEST);
include('../config/config.php');
	$conexion = DreConectarDB();

	$tiendaCapsys=$_SESSION['tiendaCapsys'];
		
	$sqlInsertPedido = "
		Insert Into
			`tienda_pedidos`
				(
					`usuario`
					,`totalPedido`
				)
				Values
				(
					'$Usuario'
					,'$totalPedido'
				);
					   ";
	DreQueryDB($sqlInsertPedido);
	$idPedido = mysql_insert_id();
	
	foreach($_SESSION['tiendaCapsys'] as $productoPedido){
		extract($productoPedido);
		$sqlInsertProductoPedido = "
			Insert Into
				`tienda_pedidos_productos`
				(
					`idPedido`
					,`idProducto`
					,`cantidad`
					,`talla`
					,`precio`
				)
				Values
				(
					'$idPedido'
					,'$idArticulo'
					,'$cantidad'
					,'$talla'
					,'$precio'
				);
								   ";
		DreQueryDB($sqlInsertProductoPedido);
		$idPedido;
		unset($tiendaCapsys[md5($idArticulo)]);		
	}
	unset($productoPedido);

	$_SESSION['tiendaCapsys']=$tiendaCapsys;

	$return = "../tienda.php";
//	header("Location: $return");

//** Envio de correo
		$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
		$para = DreCorreoUsuario('0000028964');
		$copia = "";
		$copiaOculta = "";
		$asunto = "Pedido Tienda Web CAPSYS - ".$idPedido;
		$mensaje = "";
		$mensaje.="<strong>No. Pedido:</strong> ".$idPedido."<br>";
		$mensaje.="<strong>Fecha:</strong> ".DreFechaEsp(date('Y-m-d'))."<br>";
		$mensaje.="<strong>Total:</strong> $".number_format($totalPedido,2,'.',',')."<br>";
		$mensaje.="<strong>Cliente:</strong> ".DreNombreUsuario($Usuario)."<br>";

		$fileAdjunto = "";
		$nameAdjunto = "";
		
		DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);

?>
<script>
	alert('Pedido Creado \n Exitosamente!!!');
	window.open('<? echo $return; ?>','_self');
</script>
<?
DreDesconectarDB($conexion);
?>