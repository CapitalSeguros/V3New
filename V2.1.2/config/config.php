<?php
session_start();
extract($_REQUEST);
date_default_timezone_set('America/Merida') ;

	if(	$seccion != "index"){
		if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
		if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
		
	}
	include('funcionesDre.php');

// Variables Globales

	$Usuario = $_SESSION['WebDreTacticaWeb2']['Usuario'];
	$Vendedor = $_SESSION['WebDreTacticaWeb2']['Vendedor'];
	$Nivel = (int)$_SESSION['WebDreTacticaWeb2']['Nivel'];
	$Nombre = $_SESSION['WebDreTacticaWeb2']['Nombre'];
	$Sucursal = $_SESSION['WebDreTacticaWeb2']['Sucursal'];
	$Promotor = $_SESSION['WebDreTacticaWeb2']['Promotor'];
	$Email = $_SESSION['WebDreTacticaWeb2']['Email'];
	$Telefono = $_SESSION['WebDreTacticaWeb2']['Telefono'];
	$Movil = $_SESSION['WebDreTacticaWeb2']['Movil'];
	$Tipo = $_SESSION['WebDreTacticaWeb2']['Tipo'];
	$Integral = $_SESSION['WebDreTacticaWeb2']['Integral'];
	$Grupo = $_SESSION['WebDreTacticaWeb2']['Grupo'];
	$usuarioCotiza = $_SESSION['WebDreTacticaWeb2']['usuarioCotiza'];
	$usuarioEmite = $_SESSION['WebDreTacticaWeb2']['usuarioCotiza'];

	foreach($_SESSION['WebDreTacticaWeb2']['arregloPermisos'] as $Permisos){
		$nodosPermisos[] = $Permisos['modulo']."-".$Permisos['subModulo']."-".$Permisos['accion']."-".$Permisos['permiso'];		
	}

?>