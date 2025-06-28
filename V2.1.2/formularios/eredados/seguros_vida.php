<?php 
include('../config/config.php');
$seccion  = "seguros";
$idioma = "sp";
$tipo_seguro = "vida";
$titulo = "Seguros de Vida | GAP Seguros y Fianzas";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $titulo; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<?php require('../require/meta.txt'); ?>
<link href="../config/estilos.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="../js/stmenu.js"></script> <!-- Menu -->
<script type="text/javascript" src="../js/stscode.js"></script> <!-- Scroll -->

</head>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td style="background-image:url(../img/fondo_izq_header.png); background-repeat:repeat-x;">&nbsp;</td>
    <td width="1000" height="140" background="../img/fondo_header.png" valign="top">
    <?php require('../require/header.php'); ?>
    </td>
    <td style="background-image:url(../img/fondo_der_header.png); background-repeat:repeat-x;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td height="190" style="background-image:url(../img/fondo_news.png); background-repeat:repeat-x;" valign="bottom">
    <?php require('../require/noticias.php'); ?>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="270" height="670" style="background-image:url(../img/fondo_left.png); background-repeat:no-repeat;" valign="top">
        <?php require('../require/left.php'); ?>
        </td>
        <td width="730" valign="top">
        	<table width="710" border="0" align="center" cellpadding="0" cellspacing="0">
            	<tr>
                	<td class="Titulo_Seccion" valign="top"><?php echo $titulo_seccion[$idioma][$seccion]." > ".$titulo_seguro[$idioma][$tipo_seguro]; ?>&nbsp;</td>
            	</tr>
<?php 
	$query_detalle_seccion = "Select * From `texto_seguros` Where `seccion` = '$tipo_seguro'";
	$result_detalle_seccion = mysql_query($query_detalle_seccion) or die(mysql_error());
	$row_detalle_seccion = mysql_fetch_assoc($result_detalle_seccion);
?>                
            	<tr>
                	<td>&nbsp;</td>
            	</tr>
            	<tr>
                	<td class="Texto"><?php echo $row_detalle_seccion['texto'];?></td>
            	</tr>
        	</table>
        </td>
      </tr>
    </table>
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="background-image:url(../img/fondo_fott.png); background-repeat:repeat-x;">&nbsp;</td>
    <td height="148" style="background-image:url(../img/fondo_fott.png); background-repeat:repeat-x;">
    <?php require('../require/foot.php'); ?>
    </td>
    <td style="background-image:url(../img/fondo_fott.png); background-repeat:repeat-x;">&nbsp;</td>
  </tr>
</table>
</body>
</html>