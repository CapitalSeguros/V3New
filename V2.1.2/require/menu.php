<?php
//	echo "<pre>";
	//	print_r($_SESSION);
//	echo "</pre>";
?>
<table width="980" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr>
    	<td width="150">
        	<img src="img/logo_CapsysWeb.png" width="134" height="91" />
        
        </td>
    	<td width="8">&nbsp;
        
        </td>
    	<td width="86">
			<a href="inicio.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','inicio','img/botonesMenu/inicio_hover.png','img/botonesMenu/inicio.png',1);" onclick="MM_nbGroup('down','inicio','img/botonesMenu/inicio_hover.png','img/botonesMenu/inicio.png',1);"><img name="inicio" src="img/botonesMenu/inicio.png" width="86" height="94" id="inicio" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
    	<td width="86">
			<a href="miInfo.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','miInfo','img/botonesMenu/miInfo_hover.png','img/botonesMenu/miInfo.png',1);" onclick="MM_nbGroup('down','miInfo','img/botonesMenu/miInfo_hover.png','img/botonesMenu/miInfo.png',1);"><img name="miInfo" src="img/botonesMenu/miInfo.png" width="86" height="94" id="miInfo" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
    	<td width="86">
			<a href="directorio.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','directorio','img/botonesMenu/directorio_hover.png','img/botonesMenu/directorio.png',1);" onclick="MM_nbGroup('down','directorio','img/botonesMenu/directorio_hover.png','img/botonesMenu/directorio.png',1);"><img name="directorio" src="img/botonesMenu/directorio.png" width="86" height="94" id="directorio" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>
<?php if($_SESSION['WebDreTacticaWeb2']['Grupo']!="2"){ ?>        
    	<td width="86">
			<a href="reportes.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','reportes','img/botonesMenu/reportes_hover.png','img/botonesMenu/reportes.png',1);" onclick="MM_nbGroup('down','reportes','img/botonesMenu/reportes_hover.png','img/botonesMenu/reportes.png',1);"><img name="reportes" src="img/botonesMenu/reportes.png" width="86" height="94" id="reportes" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>
<?php } ?>        
<?php //if(($_SESSION['WebDreTacticaWeb2']['Tipo']=="400" || $_SESSION['WebDreTacticaWeb2']['Tipo']=="300") || ($Usuario == "0000028964" || $Usuario == "0000522578" || $Usuario == "0000522650")){ 
if( $Usuario != "0000522607"){?>
    	<td width="86">
			<a href="tienda.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','tienda','img/botonesMenu/tienda_hover.png','img/botonesMenu/tienda.png',1);" onclick="MM_nbGroup('down','tienda','img/botonesMenu/tienda_hover.png','img/botonesMenu/tienda.png',1);"><img name="tienda" src="img/botonesMenu/tienda.png" width="86" height="94" id="tienda" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
<?php } ?>
<?php if($_SESSION['WebDreTacticaWeb2']['MailMasivo']=="S" &&  $Usuario != "0000522607"){ ?>
    	<td width="86">
			<a href="mailMasivo.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','mailMasivo','img/botonesMenu/mailMasivo_hover.png','img/botonesMenu/mailMasivo.png',1);" onclick="MM_nbGroup('down','mailMasivo','img/botonesMenu/mailMasivo_hover.png','img/botonesMenu/mailMasivo.png',1);"><img name="mailMasivo" src="img/botonesMenu/mailMasivo.png" width="86" height="94" id="mailMasivo" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
<?php } ?>
<?php if($_SESSION['WebDreTacticaWeb2']['Grupo']!="2" &&  $Usuario != "0000522607"){ ?>
    	<td width="86">
			<a href="capacita.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','capacita','img/botonesMenu/capacita_hover.png','img/botonesMenu/capacita.png',1);" onclick="MM_nbGroup('down','capacita','img/botonesMenu/capacita_hover.png','img/botonesMenu/capacita.png',1);"><img name="capacita" src="img/botonesMenu/capacita.png" width="86" height="94" id="capacita" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
<?php } ?>
    	<td width="86">
			<a href="actividades.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','actividades','img/botonesMenu/actividades_hover.png','img/botonesMenu/actividades.png',1);" onclick="MM_nbGroup('down','actividades','img/botonesMenu/actividades_hover.png','img/botonesMenu/actividades.png',1);"><img name="actividades" src="img/botonesMenu/actividades.png" width="86" height="94" id="actividades" alt="" border="0" /></a>
        </td>
    	<td width="6">&nbsp;</td>        
<?php if($_SESSION['WebDreTacticaWeb2']['Grupo']!="2" &&  $Usuario != "0000522607"){ ?>
    	<td width="86">
			<a href="calendario.php" onmouseout="MM_nbGroup('out');" onmouseover="MM_nbGroup('over','calendario','img/botonesMenu/calendario_hover.png','img/botonesMenu/calendario.png',1);" onclick="MM_nbGroup('down','calendario','img/botonesMenu/calendario_hover.png','img/botonesMenu/calendario.png',1);"><img name="calendario" src="img/botonesMenu/calendario.png" width="86" height="94" id="calendario" alt="" border="0" /></a>
        </td>
<?php } ?>
    </tr>
</table>