<html>
<head>
<title><?php echo $titulo_pag; ?></title> 
<script language="javascript">
	function Cerrar_Ventana()
		{
			window.open('','_self','');
			window.close();
		}
</script> 
</head>
<body onLoad="cuenta_atras=setTimeout('Cerrar_Ventana();',3000)">
</body>
</html>