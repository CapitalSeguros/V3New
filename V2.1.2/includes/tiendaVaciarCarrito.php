<?php
extract($_REQUEST);
include('../config/config.php');
	$conexion = DreConectarDB();

	unset($_SESSION['tiendaCapsys']); //Vaciamos la Session (carrito)

	header("Location: ../tienda.php");
?>