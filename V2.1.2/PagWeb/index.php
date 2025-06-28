<?
	extract($_REQUEST);
	$seccion = "miInfo";
	include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
			
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
	<? DreHead($seccion); ?>
</head>
<body  class="Body">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" align="center">
	<tr valign="top">
    	<td>
			<table width="800" cellpadding="0" cellspacing="0" border="0" align="center" bgcolor="#FFFFFF">
            	<tr valign="top">
                	<td>
<?php
	if(!isset($poliza) && !isset($agente)){
?>
                    	<div style="width:850px; text-align:justify;" align="center">
                        	<form name="formPoliza" id="formPoliza" method="post" action="validarPoliza.php?validacion=polizas">
                            	Poliza
                                <br />
								<input type="hidden" name="idioma" id="idioma" value="<? echo $idioma; ?>" />
                            	<input type="text" name="poliza" id="poliza" style="width:85%" />
                                <input type="submit" value="Validar" class="buttonGeneral" />
                            </form>
                        </div>
                        <br />
                    	<div style="width:850px; text-align:justify;" align="center">
                        	<form name="formAgente" id="formAgente" method="post" action="validarAgente.php?validacion=agente">
                            	Agente
                                <br />
								<input type="hidden" name="idioma" id="idioma" value="<? echo $idioma; ?>" />
                            	<input type="text" name="agente" id="agente" style="width:85%" />
                                <input type="submit" value="Validar" class="buttonGeneral" />
                            </form>
                        </div>
<?php } ?>                        
                    </td>
				</tr>
<?php 

	if(isset($poliza)){
		
		$sqlInformacionPolizaValida = "		
			Select
				*
			From
				`cliramos` Inner Join `empresas`
				On 
				`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE`
			Where 
				`cliramos`.`POLIZA` Like '%$value%'
									  ";
		$resInformacionPolizaValida = DreQueryDB($sqlInformacionPolizaValida);
		$rowInformacionPolizaValida = mysql_fetch_assoc($resInformacionPolizaValida);
		
?>
                <tr>
                    <td align="center">
                    	<div style="width:850px; text-align:justify;" align="center">
                    	<?php 
							if($poliza == "true"){
								?><script>alert('Poliza Encontrada !!!');</script><?
								echo "<font style='font-size:28px;'><strong>Datos de la poliza</strong><br /></font>"; 
								echo "<strong>&bull; Poliza: </strong>";
								echo $rowInformacionPolizaValida['POLIZA'];
								echo "<br />";
								echo "<strong>&bull; Clave Cliente: </strong>";
								echo $rowInformacionPolizaValida['CLAVE_CLIENTE'];
								echo "<br />";
								echo "<strong>&bull; Cliente: </strong>";
								echo $rowInformacionPolizaValida['RAZON_SOCIAL'];
								echo "<br />";
								echo "<strong>&bull; Vigencia: </strong>";
								echo date_format(date_create($rowInformacionPolizaValida['FECHA_INI']), 'd-M-Y');
								echo "&nbsp;&nbsp;&nbsp;";
								echo date_format(date_create($rowInformacionPolizaValida['FECHA_FIN']), 'd-M-Y');
								
								echo "<br />";
								echo "<strong>&bull; Sub-Ramo: </strong>";
								echo $rowInformacionPolizaValida['SUBRAMO'];

								
							} else if($poliza == "false") {
								?><script>alert('Poliza NO Encontrada !!!');</script><?
								echo "<font style='font-size:28px;'><strong>El numero de poliza No existe.</strong><br /></font>"; 
								echo "<br /><br />";
								require('../require/formReportarPolizaNoEncontrada.php');
							}
						?>
                        </div>
                    </td>
                </tr>
<?php 
	} 

	if(isset($agente) && isset($value)){
		
		$sqlInformacionAgenteValido = "		
			Select
				*
				, `usuarios`.`NOMBRE` As `nombreCompletoAgente`
			From
				`usuarios` Inner Join `info_usuarios_vendedores`
				On 
				`usuarios`.`VALOR` = `info_usuarios_vendedores`.`VALOR`
			Where 
				`usuarios`.`VALOR` Like '%$value%'
									  ";
		$resInformacionAgenteValido = DreQueryDB($sqlInformacionAgenteValido);
		$rowInformacionAgenteValido = mysql_fetch_assoc($resInformacionAgenteValido);

if(file_exists('../img/usuarios/'.$rowInformacionAgenteValido['IMAGEN']) && $rowInformacionAgenteValido['IMAGEN'] != ""){
	$imgValidada = '<img src="http://www.capsys.com.mx/img/usuarios/'.$rowInformacionAgenteValido['IMAGEN'].'" width="100" height="120" />';
} else {
	$imgValidada = '<img src="http://www.capsys.com.mx/img/usuarios/noPhoto.png" width="100" height="120" />';
}
		
?>
                <tr>
                    <td align="center">
                    	<div style="width:850px; text-align:justify;" align="center">
                    	<?php 
							if($agente == "true"){
								?><script>alert('Agente Encontrado !!!');</script><?
								echo "<font style='font-size:28px;'><strong>Datos del Agente</strong><br /></font>"; 
								echo "<strong>&bull; Nombre: </strong>";
								echo $rowInformacionAgenteValido['nombreCompletoAgente'];
								echo "<br />";
								echo "<strong>&bull; Clave Agente: </strong>";
								echo $rowInformacionAgenteValido['VALOR'];
								echo "<br />";
								echo "<strong>&bull; Email: </strong>";
								echo $rowInformacionAgenteValido['Email'];
								echo "<br />";
								echo "<strong>&bull; Vigente: </strong>";
								echo "Si";
								echo "<br />";
								echo "<blockquote>";
								echo '<div style="border:1px solid #000000; width:100px; height:120px;">';
								echo $imgValidada;
								echo '</div>';
								echo "</blockquote>";
								
							} else if($agente == "false") {
								?><script>alert('Agente NO Encontrado !!!');</script><?
								echo "<font style='font-size:28px;'><strong>El numero &oacute; nombre de agente No existe.</strong><br /></font>"; 
								echo "<br /><br />";
								require('../require/formReportarAgenteNoEncontrado.php');
							}
						?>
                        </div>
                    </td>
                </tr>
<?php 
	} else if(isset($agente) && isset($busqueda)){
		$sqlInformacionListadoAgenteValido = "		
			Select
				*
				, `usuarios`.`NOMBRE` As `nombreCompletoAgente`
			From
				`usuarios` Inner Join `info_usuarios_vendedores`
				On 
				`usuarios`.`VALOR` = `info_usuarios_vendedores`.`VALOR`
			Where
				MATCH (`usuarios`.`NOMBRE`) AGAINST ('$busqueda' IN BOOLEAN MODE);
									  ";
		$resInformacionListadoAgenteValido = DreQueryDB($sqlInformacionListadoAgenteValido);
?>
<!-- -->
                <tr>
                    <td align="center">
                    	<div style="width:850px; text-align:justify;" align="center">
                    	<?php 
							if($agente == "true"){
								?><script>alert('Agentes Encontrados !!!');</script><?
								
								while($rowInformacionListadoAgenteValido = mysql_fetch_assoc($resInformacionListadoAgenteValido)){
if(file_exists('../img/usuarios/'.$rowInformacionListadoAgenteValido['IMAGEN']) && $rowInformacionListadoAgenteValido['IMAGEN'] != ""){
	$imgValidada = '<img src="http://www.capsys.com.mx/img/usuarios/'.$rowInformacionListadoAgenteValido['IMAGEN'].'" width="100" height="120" />';
} else {
	$imgValidada = '<img src="http://www.capsys.com.mx/img/usuarios/noPhoto.png" width="100" height="120" />';
}
								
								echo "<font style='font-size:28px;'><strong>Datos del Agente</strong><br /></font>"; 
								echo "<strong>&bull; Nombre: </strong>";
								echo $rowInformacionListadoAgenteValido['nombreCompletoAgente'];
								echo "<br />";
								echo "<strong>&bull; Clave Agente: </strong>";
								echo $rowInformacionListadoAgenteValido['VALOR'];
								echo "<br />";
								echo "<strong>&bull; Email: </strong>";
								echo $rowInformacionListadoAgenteValido['Email'];
								echo "<br />";
								echo "<strong>&bull; Vigente: </strong>";
								echo "Si";
								echo "<br />";
								echo "<blockquote>";
								echo '<div style="border:1px solid #000000; width:100px; height:120px;">';
								echo $imgValidada; 
								echo '</div>';
								echo "</blockquote>";
								} // Fin While
								
							} else if($agente == "false") {
								?><script>alert('Agente NO Encontrado !!!');</script><?
								echo "<font style='font-size:28px;'><strong>El numero &oacute; nombre de agente No existe.</strong><br /></font>"; 
								echo "<br /><br />";
								require('../require/formReportarAgenteNoEncontrado.php');
							}
						?>
                        </div>
                    </td>
                </tr>
<!-- -->
<?php
	}
		DreDesconectarDB($conexion);
?>
			</table>
		</td>
	</tr>
</table>
</body>