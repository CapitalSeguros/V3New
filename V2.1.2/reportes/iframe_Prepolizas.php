<?
$seccion = "reportes";
	include('../config/config.php');
//	include('../config/funcionesDre.php');
		$conexion = DreConectarDB();
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<? DreHead($seccion); ?>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<table width="2134" cellpadding="2" cellspacing="1" align="center" >
	<tr bgcolor="#273B71" style="font-size:12px; font-weight:300; color:#FFFFFF; "><!-- #B6C6D7 -->
		<td width="120">Poliza</td>
		<td width="75">Fecha Pago</td>
		<td width="190">Seguimiento</td>
		<td width="350">Clave Cliente</td>
		<td width="350">Vendedor</td>
		<td width="250">Promotor</td>
		<td width="150">Ramo</td>
		<td width="75">Fecha Desde</td>
		<td width="75">Fecha Hasta</td>
		<td width="99">Importe</td>
		<td width="400">Comentario</td>
	</tr>
<?
	$sqlPrepolizas = "
		Select * From 
			`prepolizas`
		Order By
			`FechaPago` ASC 
					 ";
	$resPrepolizas = DreQueryDB($sqlPrepolizas);
	$contIntLi = 0;
	while($rowPrepolizas = mysql_fetch_assoc($resPrepolizas)){						
?>
	<tr style="font-size:10px;" bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
		<td><? echo $rowPrepolizas['Poliza']; ?></td>
		<td><? echo DreFechaEsp($rowPrepolizas['FechaPago']); ?></td>
		<td><? echo $rowPrepolizas['Seguimiento']; ?></td>
		<td><? echo DreNombreCliente($rowPrepolizas['ClaveCliente'])."[".$rowPrepolizas['ClaveCliente']."]"; ?></td>
		<td><? echo nombreVendedor(str_pad($rowPrepolizas['VendedorId'],10,"0",0))."[".str_pad($rowPrepolizas['VendedorId'],10,"0",0)."]"; ?></td>
		<td><? echo nombreVendedor(str_pad((int)$rowPrepolizas['PromotorId'],10,"0",0))."[".str_pad($rowPrepolizas['PromotorId'],10,"0",0)."]"; ?></td>
		<td><? echo DreNombreSubRamo($rowPrepolizas['RamoId'])."[".$rowPrepolizas['RamoId']."]"; ?></td>
		<td><? echo DreFechaEsp($rowPrepolizas['FechaDesde']); ?></td>
		<td><? echo DreFechaEsp($rowPrepolizas['FechaHasta']); ?></td>
		<td align="right"><? echo "$".number_format($rowPrepolizas['Importe'],2,'.',','); ?></td>
		<td><? echo $rowPrepolizas['Comentario']; ?></td>
	</tr>
<?
	$contIntLi++;
	}
?>
</table>
</body>
</html>