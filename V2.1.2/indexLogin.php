<?
$seccion = "index";
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
	if(isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: inicio.php"); }
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<? DreHead($seccion); ?>
</head>
<body>
<table width="1000" height="100%" align="center" class="TablePrincipal" cellpadding="0" cellspacing="0">
	<tr>
    	<td height="45" class="HeaderAzul">
        	<font class="TextoTitulosHeaderAzul">
            	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            	Capsys Web Versi&oacute;n 2.1.2
        	</font>
        </td>
    </tr>
    <tr>
    	<td height="500">
       	  <table class="TableLogin" align="center" cellpadding="2" cellspacing="2">
            	<tr>
                	<td colspan="2" class="TextoTitulosLogin">
                    	Iniciar sesi&oacute;n
                    </td>
                </tr>
            	<tr>
            	  <td width="40%" class="TextoGeneralNegro">
                  <!--
                  	<a href="#" class="TextoGeneralNegro">
                    	¿Ha olvidado su contrase&ntilde;a?
                    </a>
                  -->
            	  </td>
            	  <td rowspan="2">
                  	<table align="center" class="TableInteriorLogin" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td class="TextoGeneralNegro">
                            	<form id="formLogin" name="formLogin" method="post" action="includes/login.php" onSubmit="return ValidarLogin(this)">
                                Usuario: <br />
                                <input name="user" type="text" id="user" size="34"  />
                                <br /><br />
                                Contrase&ntilde;a:
                                <br />
                                <input name="pass" type="password" id="pass" size="34"  />
                                <br /><br />
                                <input type="submit" name="buttonLogin" id="buttonLogin" value="Ingresar" />
                                </form>
                            </td>
                        </tr>
                    </table>
                  </td>
       	      </tr>
            	<tr>
            	  <td>
                  	<a href="" style="font-size:10px; text-decoration:none;" title="Clic Aqui !!!">
	                  	Olvid&oacute; contrase&ntilde;a?
                  	</a>
                  </td>
           	  </tr>
            	<tr>
            	  <td>&nbsp;</td>
           	  </tr>
            </table>
        </td>
    </tr>
    
    <tr>
    	<td>&nbsp;</td>
    </tr>
</table>
</body>
</html>