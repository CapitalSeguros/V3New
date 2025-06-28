<?
$seccion = "capacita";
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
			<?php echo DreTitleInterior($seccion); ?>
            <!--
            <div style="float:right;" align="right">
            <a href="https://www.dropbox.com/sh/3txhtwzoketivnz/TpG2lnTGrm" title="Descargables !!!" target="_blank" class="systemTex" style="font-size:12px; font-weight:bold;">
            <font class="systemTex">Descargables</font>&nbsp;<img src="img/transparente.fw.png" class="system descargar" alt="logout" border="0"/></a>
            </div>
            -->
		</td>
		<td width="25"></td>
	</tr>
    <tr bgcolor="#FFFFFF">
    	<td colspan="3" height="9"></td>
    </tr>
    <tr align="center" bgcolor="#FFFFFF">
		<td width="25"></td>
		<td width="950">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script>
stm_bm(["menu67a9",900,"img/","blank.gif",0,"","",2,0,250,0,1000,1,0,0,"","100%",0,0,1,2,"default","hand","",1,25],this);
stm_bp("p0",[0,4,0,0,2,3,0,0,100,"",-2,"",-2,50,0,0,"#999999","","fondoMenuCapacita.png",3,1,1,"#000000"]);
stm_ai("p0i0",[0,"Video Tutoriales","","",-1,-1,0,"","_self","","","","",0,0,0,"","",0,0,0,1,1,"",0,"",0,"","",3,3,0,0,"","","#FFFFFF","#FFFFFF","bold 12pt Trebuchet MS","bold 12pt Trebuchet MS",0,0,"","","","",0,0,0],0,47);
stm_bpx("p1","p0",[1,4,0,0,2,3,0,0,91,"",-2,"",-2,50,0,0,"#999999","#3E4040",""]);
stm_aix("p1i0","p0i0",[0,"Iniciar sesion CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=ENQ4IdLVpQA&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=2","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Mi info CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=VYDOw--LhEs&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=2","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Agregar persona fisica directorio CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=GxcegghcMhE&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=3","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Agregar persona moral directorio CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=JS1qVaTe8MQ&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=5","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Búsqueda de datos de personas directorio CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=aDl0-TbRCZg&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=6","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Reportes CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=jHfeXYM9hgc&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=8","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Reportes dinamicos reportes CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=WUXtcfes-9M&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=9","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Actividades - cotización y emisión poliza autos nuevos CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=2vORchJYjFo&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=10","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Calendario CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=rTnIR3lAaCY&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=11","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
stm_aix("p1i0","p0i0",[0,"Tienda CAPSYS","","",-1,-1,0,"http://www.youtube.com/watch?v=3vP7fJPgSoc&list=PLYs3CUSW5jti3EiJFDM2onmphNyJoDLPl&index=12","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]);
<!-- stm_aix("p1i0","p0i0",[0,"Menu Item 1","","",-1,-1,0,"#Link","_blank","","Clic Aquí","","",0,0,0,"","",0,0,0,0,1,"",0,"#2D2D2D"]); -->
stm_ep();
stm_aix("p0i1","p0i0",[0,"Descargables     ","","",-1,-1,0,"https://www.dropbox.com/sh/3txhtwzoketivnz/TpG2lnTGrm","_blank","","Descargables !!!","","",0,0,0,"","",0,0,0,2],0,47);
stm_ep();
stm_em();
</script>
        </td>
		<td width="25"></td>
	</tr>
    <tr valign="top" align="center" bgcolor="#FFFFFF">
		<td></td>
		<td height="100%" valign="top">
			<?php require('require/'.$seccion.'_interior.php'); ?>
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