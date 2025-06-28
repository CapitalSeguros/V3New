<?
$seccion = "actividades";
	include('config/config.php');
	include_once("fckeditor/fckeditor.php");
		$conexion = DreConectarDB();
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<? DreHead($seccion); ?>
</head>
<body onload="MM_preloadImages(
'img/botonesMenu/actividades.png'
,'img/botonesMenu/actividades_hover.png'
,'img/botonesMenu/calendario.png'
,'img/botonesMenu/calendario_hover.png'
,'img/botonesMenu/capacita.png'
,'img/botonesMenu/capacita_hover.png'
,'img/botonesMenu/directorio.png'
,'img/botonesMenu/directorio_hover.png'
,'img/botonesMenu/inicio.png'
,'img/botonesMenu/inicio_hover.png'
,'img/botonesMenu/mailMasivo.png'
,'img/botonesMenu/mailMasivo_hover.png'
,'img/botonesMenu/miInfo.png'
,'img/botonesMenu/miInfo_hover.png'
,'img/botonesMenu/reportes.png'
,'img/botonesMenu/reportes_hover.png'
,'img/botonesMenu/tienda.png'
,'img/botonesMenu/tienda_hover.png');">
<table height="100%" cellpadding="0" cellspacing="0" align="center" class="TablePrincipal">
	<tr>
    	<td colspan="3"><?php require('require/menu.php'); ?></td>
    </tr>
	<tr>
    	<td colspan="3"><?php require('require/header.php'); ?></td>
	</tr>
    <tr bgcolor="#FFFFFF">
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr valign="top" align="center" bgcolor="#FFFFFF">
		<td width="25"></td>
		<td width="950" class="TextoTitulosSeccion" align="left">
			<?php echo DreTitleInterior($seccion); ?>
		</td>
		<td width="25"></td>
	</tr>
    <tr valign="top" bgcolor="#FFFFFF">
		<td></td>
		<td height="100%" valign="top">
			<?php

				if(isset($_GET['Actividad'])){
					$Actividad = urlencode($_GET['Actividad']);
				switch($Actividad){
					case "Diligencias":
						//$buscadorPolizaCliente = DreNombreCliente($_GET['CLIENTE']); //"DIANA ROCIO FIRTH NOVELO";
					break;
				}
				}
				
				if(isset($_GET['Ramo'])){
					$Ramo = urlencode($_GET['Ramo']);
				}
				
				if(isset($_GET['CLIENTE'])){
					$idRefCliente = $_GET['CLIENTE'];
				}
				
				if(isset($_GET['SUBRAMO'])){
					$quitarSubRamo = array('%D1', 'Lineas+Personales');
					$ponerSubRamo = array('%F1', 'L%EDneas+Personales');
					$Ramo = str_replace($quitarSubRamo, $ponerSubRamo ,urlencode(ucwords(strtolower(DreNombreRamoV2($_GET['SUBRAMO'])))));
					
					// Calculo Complementos
					switch($Ramo){
						case "L%EDneas+Personales":
						case "Da%F1os":
							$SubRamoLocal = DreNombreSubRamo($_GET['SUBRAMO']);
							// $SubRamo = DreNombreSubRamo($_GET['SUBRAMO']);
						break;						
					}
				}
				
				include('require/expresTextoRequisitos.php');
				
				require('require/actividadesAgregar_interior.php'); 
			?>
<?php
/*
	echo "<pre>";
		print_r($_REQUEST);
		print_r($_SESSION);
	echo "</pre>";
*/
?>
		</td>
		<td></td>
	</tr>
	<tr bgcolor="#FFFFFF">
    	<td colspan="3">&nbsp;</td>
	</tr>
</table>
</body>
</html>
<?php DreDesconectarDB($conexion); ?>