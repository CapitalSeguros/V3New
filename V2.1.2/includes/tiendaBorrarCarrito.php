<?php
extract($_REQUEST);
include('../config/config.php');
	$conexion = DreConectarDB();

		$tiendaCapsys=$_SESSION['tiendaCapsys'];
	
		unset($tiendaCapsys[md5($idArticulo)]);
		$_SESSION['tiendaCapsys']=$tiendaCapsys;

	header("Location: ../tiendaVerCarrito.php");
?>