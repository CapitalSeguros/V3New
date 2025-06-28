<?
$seccion = "inicio";
	include('config/config.php');
	if (ae_detect_ie()) {
		$textoBloqueo = "Estas usando Internet Explorer, tenemos problemas de compatibilidad. ";
		$textoBloqueo.= "Recomendamos el uso de otros navegadores como Chrome, Firefox o Safari.";
		?>
        <script>
			alert('<? echo $textoBloqueo; ?>');
			window.open('http://www.agentecapital.com','_self');
		</script>
        <?
	}
		$conexion = DreConectarDB();
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<? DreHead($seccion); ?>
</head>
<body onLoad="MM_preloadImages(
'img/botonesInicio/actividades.png'
,'img/botonesInicio/actividades_hover.png'
,'img/botonesInicio/calendario.png'
,'img/botonesInicio/calendario_hover.png'
,'img/botonesInicio/capacita.png'
,'img/botonesInicio/capacita_hover.png'
,'img/botonesInicio/directorio.png'
,'img/botonesInicio/directorio_hover.png'
,'img/botonesInicio/inicio.png'
,'img/botonesInicio/inicio_hover.png'
,'img/botonesInicio/mailMasivo.png'
,'img/botonesInicio/mailMasivo_hover.png'
,'img/botonesInicio/miInfo.png'
,'img/botonesInicio/miInfo_hover.png'
,'img/botonesInicio/reportes.png'
,'img/botonesInicio/reportes_hover.png'
,'img/botonesInicio/tienda.png'
,'img/botonesInicio/tienda_hover.png');">
<table height="100%" cellpadding="0" cellspacing="0" align="center" class="TablePrincipal">
	<tr>
    	<td colspan="3"><?php require('require/header.php'); ?></td>
	</tr>
    <tr valign="top" align="center">
		<td width="118">&nbsp;</td>
		<td height="100%" width="664" style="background-image:url(img/fondoInicioDegradadoBlanco.png); background-repeat:no-repeat; background-position:center;" align="center">
		<dl id="circuloBase" name="circuloBase" style="align-content:center;">
        <dd id="inicio" name="inicio">
        	<a href="inicio.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','inicio','img/botonesInicio/inicio_hover.png','img/botonesInicio/inicio.png',1);" onClick="MM_nbGroup('down','inicio','img/botonesInicio/inicio_hover.png','img/botonesInicio/inicio.png',1);"><img name="inicio" src="img/botonesInicio/inicio.png" width="160" height="178" id="inicio" alt="" border="0" /></a>
		</dd>
		<dd id="miInfo" name="miInfo">
        	<a href="miInfo.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','miInfo','img/botonesInicio/miInfo_hover.png','img/botonesInicio/miInfo.png',1);" onClick="MM_nbGroup('down','miInfo','img/botonesInicio/miInfo_hover.png','img/botonesInicio/miInfo.png',1);"><img name="miInfo" src="img/botonesInicio/miInfo.png" width="160" height="178" id="miInfo" alt="" border="0" /></a>
		</dd>
        <dd id="directorio" name="directorio">
        	<a href="directorio.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','directorio','img/botonesInicio/directorio_hover.png','img/botonesInicio/directorio.png',1);" onClick="MM_nbGroup('down','directorio','img/botonesInicio/directorio_hover.png','img/botonesInicio/directorio.png',1);"><img name="directorio" src="img/botonesInicio/directorio.png" width="160" height="178" id="directorio" alt="" border="0" /></a>
		</dd>
<?php if($Grupo != "2"){ ?>
        <dd id="reportes" name="reportes">
        	<a href="reportes.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','reportes','img/botonesInicio/reportes_hover.png','img/botonesInicio/reportes.png',1);" onClick="MM_nbGroup('down','reportes','img/botonesInicio/reportes_hover.png','img/botonesInicio/reportes.png',1);"><img name="reportes" src="img/botonesInicio/reportes.png" width="160" height="178" id="reportes" alt="" border="0" /></a>
		</dd>
<?php } ?>
<?php //if(($_SESSION['WebDreTacticaWeb2']['Tipo']=="400" || $_SESSION['WebDreTacticaWeb2']['Tipo']=="300") || ($Usuario == "0000028964" || $Usuario == "0000522578" || $Usuario == "0000522650")){ 
	if( $Usuario != "0000522607"){
?>
        <dd id="tienda" name="tienda">
        	<a href="tienda.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','tienda','img/botonesInicio/tienda_hover.png','img/botonesInicio/tienda.png',1);" onClick="MM_nbGroup('down','tienda','img/botonesInicio/tienda_hover.png','img/botonesInicio/tienda.png',1);"><img name="tienda" src="img/botonesInicio/tienda.png" width="160" height="178" id="tienda" alt="" border="0" /></a>
		</dd>
<?php } ?>
<?php if($_SESSION['WebDreTacticaWeb2']['MailMasivo']=="S" && $Usuario != "0000522607"){ ?>
        <dd id="mailMasivo" name="mailMasivo">
        	<a href="mailMasivo.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','mailMasivo','img/botonesInicio/mailMasivo_hover.png','img/botonesInicio/mailMasivo.png',1);" onClick="MM_nbGroup('down','mailMasivo','img/botonesInicio/mailMasivo_hover.png','img/botonesInicio/mailMasivo.png',1);"><img name="mailMasivo" src="img/botonesInicio/mailMasivo.png" width="160" height="178" id="mailMasivo" alt="" border="0" /></a>
		</dd>
<?php } ?>
<?php if($Grupo != "2" &&  $Usuario != "0000522607"){ ?>
		<dd id="capacita" name="capacita">
        	<a href="capacita.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','capacita','img/botonesInicio/capacita_hover.png','img/botonesInicio/capacita.png',1);" onClick="MM_nbGroup('down','capacita','img/botonesInicio/capacita_hover.png','img/botonesInicio/capacita.png',1);"><img name="capacita" src="img/botonesInicio/capacita.png" width="160" height="178" id="capacita" alt="" border="0" /></a>
		</dd>
<?php } ?>
<?php if($Grupo != "2" && $Usuario != "0000522607"){ ?>
        <dd id="calendario" name="calendario">
        	<a href="calendario.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','calendario','img/botonesInicio/calendario_hover.png','img/botonesInicio/calendario.png',1);" onClick="MM_nbGroup('down','calendario','img/botonesInicio/calendario_hover.png','img/botonesInicio/calendario.png',1);"><img name="calendario" src="img/botonesInicio/calendario.png" width="160" height="178" id="calendario" alt="" border="0" /></a>
		</dd>
<?php } ?>
        <dd id="actividades" name="actividades">
        	<a href="actividades.php" onMouseOut="MM_nbGroup('out');" onMouseOver="MM_nbGroup('over','actividades','img/botonesInicio/actividades_hover.png','img/botonesInicio/actividades.png',1);" onClick="MM_nbGroup('down','actividades','img/botonesInicio/actividades_hover.png','img/botonesInicio/actividades.png',1);"><img name="actividades" src="img/botonesInicio/actividades.png" width="160" height="178" id="actividades" alt="" border="0" /></a>
		</dd>
		</dl>
		</td>
		<td width="118">&nbsp;</td>
	</tr>
	<tr>
    	<td colspan="3">&nbsp;</td>
	</tr>
</table>
</body>
</html>
<?php DreDesconectarDB($conexion); ?>