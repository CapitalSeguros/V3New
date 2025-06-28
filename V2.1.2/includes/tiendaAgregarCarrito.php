<?php
extract($_REQUEST);
include('../config/config.php');
	$conexion = DreConectarDB();

	if(isset($_SESSION['tiendaCapsys'])){ $tiendaCapsys = $_SESSION['tiendaCapsys']; }

	$tiendaCapsys[md5($idArticulo)]=array(
											'idArticulo' => $idArticulo
											,'talla' => $talla
											,'cantidad' => $cantidad
											,'precio' => $precio
										 );

   $_SESSION['tiendaCapsys'] = $tiendaCapsys;
	$return = "../tiendaCategoria.php?idCategoria=".$idCategoria;
	header("Location: $return");   

DreDesconectarDB($conexion);
?>