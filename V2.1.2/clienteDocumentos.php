<?
$seccion = "cliente";
	include('config/config.php');
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
			<?php //echo DreTitleInterior($seccion); ?>
		</td>
		<td width="25"></td>
	</tr>
    <tr valign="top" bgcolor="#FFFFFF"><!-- align="center" -->
		<td></td>
		<td height="100%" valign="top">
			<?php require('require/clienteDocumentos_interior.php'); ?>
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