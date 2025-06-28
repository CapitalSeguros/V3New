<style>
.BotonSeleccionado{
		padding:2px;
		color:#000000;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
		text-decoration:none;
		border:solid 2px #FF0004;
		background-image:url(img/fondo_azul.png);
		border-radius:6px 6px 6px 6px;	
}
.BotonUnSeleccionado{
		padding:2px;
		color:#FFF;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		font-weight:bold;
		text-decoration:none;
		border:none;
		background-image:url(img/fondo_azul.png);
		border-radius:6px 6px 6px 6px;		
}
</style>
<?php	
	if($form==1 || !isset($form) || $form == ""){
		$tipoFormularioSeleccionado = "En Actualizacion ..."; //--> Web Services // MultiCotizador
		$seleccionBotonWs = "BotonSeleccionado";
		$seleccionBotonManual = "BotonUnSeleccionado";
	}else{
		$tipoFormularioSeleccionado = "Manual";
		$seleccionBotonWs = "BotonUnSeleccionado";
		$seleccionBotonManual = "BotonSeleccionado";
	}
	
// actividadesDetalle.php?recId=w2451&muestra=Formularios&form=1#Formularios	
	$urlCotWs = $_SERVER['PHP_SELF'];
	$urlCotWs.= "?recId=".$recId;
	$urlCotWs.= "&muestra=Formularios";
	$urlCotWs.= "&form=1";
	$urlCotWs.= "#Formularios";
	
	$urlCotManual = $_SERVER['PHP_SELF'];
	$urlCotManual.= "?recId=".$recId;
	$urlCotManual.= "&muestra=Formularios";
	$urlCotManual.= "&form=2";
	$urlCotManual.= "#Formularios";


	$sqlExisteCotizacionWs = "
		Select
			*
		From
			`ws_comparativo`
		Where
			`idActividad` = '$recId'
							 ";
	$resDatosCotizacionWs = DreQueryDb($sqlExisteCotizacionWs);
	$rowDatosCotizacionWs = mysql_fetch_assoc($resDatosCotizacionWs);

	if(mysql_num_rows(DreQueryDB($sqlExisteCotizacionWs)) > 0 && !isset($wsAseguradoraParticular)){ //
		//http://agentecapital.com/Capsys_New/
		$urlComparativo = "reportes/cuadroComparativo.php";
		$urlComparativo.= "?idActividad=".$recId;
		$urlComparativo.= "&idCliente=".$rowDatosCotizacionWs['idCliente'];
		
		$urlEnvioCotizacion = "clienteEnviarCorreo.php?CLAVE=".$rowDatosCotizacionWs['idCliente']."&recId=".$recId."&urlComparativo=".$urlComparativo."&regreso=actividadesDetalle"."#CorreosCliente";
?>
		<br>
        <input type="button" value="Enviar Cotizacion" onClick="java:window.open('<? echo $urlEnvioCotizacion; ?>', '_self');" class="buttonGeneral" align="right" />
        <br>
	<embed src="<?php echo $urlComparativo?>" width="100%" height="630">
<?php
	}else{
		//echo "muestras formulario";
?>
<table width="100%" cellpadding="1" cellspacing="1" border="0" align="center">
        <?php
		$sqlConsultaFormulario = "
			Select * From 
				`actividades_formularios`
			Where
				`idActividad` = '$recId'
								 ";
		$existeFormulario = mysql_num_rows(DreQueryDB($sqlConsultaFormulario));
		
		$sqlConsultaWs = "
			Select * From
				`ws_comparativo` 
			Where
				`idActividad` = '$recId'
						 ";
		$existeWs = mysql_num_rows(DreQueryDB($sqlConsultaWs));
	if($Grupo != "2"){
		if($existeFormulario == 0 && $existeWs == 0){
		?>
	<tr>
    	<td align="right">
<!--
			<input type="button"  value="Cotizar Web S [Qualitas, Aba, Ana, Hdi]" class="buttonGeneral" title="Cotizar Web Services" onClick="JavaScript: window.open('<?php //echo $urlCotWs; ?>','_self');"/>
-->
<!--
            &nbsp;&nbsp;&nbsp;
        	<input type="button"  value="Cotizar Manual Oficina" class="buttonGeneral" title="Cotizar Manual" onClick="JavaScript: window.open('<?php //echo $urlCotManual; ?>','_self');"/>
-->
        </td>
    </tr>
	<tr>
    	<td align="right">
            &nbsp;&nbsp;&nbsp;
        </td>
    </tr>
	<tr>
    	<td>
        	<font style="font-weight:bold; font-size:12px;">
			<? echo "&bull;&nbsp;".$tipoFormularioSeleccionado; ?>
            </font>
        </td>
	</tr>
        <?php
		}
	}
		?>
    <tr>
    	<td>
        	<?php				
			if(!isset($wsAseguradoraParticular)){
/*				
				if(!isset($form) && $existeFormulario != 0){ $form = 2; }
				switch($form){
					case 1:
						require('formularios/AutosIndividualesNuevos_Ws.php');
					break;
					
					case 2:
						require('formularios/AutosIndividualesNuevos_Manual.php');
					break;
					
					default :
						require('formularios/AutosIndividualesNuevos_Ws.php');
					break;					
				}
*/				
			} else {

				include('includes/ws/wsGeneral.php');
			}
			?>
        </td>
    </tr>
</table>
<?php
	}
?>