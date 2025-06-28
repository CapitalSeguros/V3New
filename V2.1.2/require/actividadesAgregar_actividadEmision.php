<script>
	function selectCondicionesPago(condicionesPago){
	var f = document.formCondicionesPagoCobro;
			f.submit();
	}
	
	function selectConductoCobro(conductoCobro){
	var f = document.formCondicionesPagoCobro;
			f.submit();
	}
</script>
<?php
if(
	$Actividad == "Emisi%F3n"
	&&
	(
	$idRefCliente != ""
	||
	$idRefProspecto != ""
	)
){
?>
<!-- Cotizador Expres -->

	<tr>
    	<td colspan="2">
			<table width="100%" cellpadding="2" cellspacing="2" border="0">
				<tr>
    				<td colspan="4"><hr /></td>
				</tr>
				<tr>
					<td colspan="4">
	                    Datos Emisi&oacute;n Expr&eacute;s:
                   		<blockquote>
							<?php
								$tipo_toolbar = "Dre";
								$oFCKeditor = new FCKeditor('Referencia') ;
								$oFCKeditor->BasePath = 'fckeditor/' ;
								$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
								//$oFCKeditor->Value = "";
								$oFCKeditor->Value = $txtFormulario;
								$oFCKeditor->Create();
							?>
						</blockquote>
					</td>
				</tr>
				<tr>
					<td colspan="4">
                    <?php
						//include('require/expresTextoRequisitos.php');
						echo $txtAsteriscos;
					?>  
                    </td>
				</tr>
				<tr>
    				<td colspan="4"><hr /></td>
				</tr>
<form name="formCondicionesPagoCobro" id="formCondicionesPagoCobro" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
				<tr>
					<td colspan="4">
	                    Condiciones de Pago
                        <select name="condicionesPago" id="condicionesPago" onchange="selectCondicionesPago(this.value)">
                        	<option value="">--Seleccione--</option>
                        	<option value="Contado" <? echo ($condicionesPago == "Contado")? "selected": ""; ?>>Contado</option>
                        	<option value="Semestral" <? echo ($condicionesPago == "Semestral")? "selected": ""; ?>>Semestral</option>
                        	<option value="Trimestral" <? echo ($condicionesPago == "Trimestral")? "selected": ""; ?>>Trimestral</option>
                        	<option value="Mensual" <? echo ($condicionesPago == "Mensual")? "selected": ""; ?>>Mensual</option>
                        </select>
						Conductos de Cobro
                        <select name="conductoCobro" id="conductoCobro"  onchange="selectConductoCobro()">
                        	<option value="">--Seleccione--</option>
                        	<option value="Agente" <? echo ($conductoCobro == "Agente")? "selected":""; ?>>Agente</option>
                        	<option value="Tarjeta+de+Credito" <? echo ($conductoCobro == "Tarjeta+de+Credito")? "selected":""; ?>>Tarjeta de Cr&eacute;dito</option>
                        </select>
                        
			<input type="hidden" name="idRefCliente" id="idRefCliente" value="<?php echo $idRefCliente ?>" />
		    <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>"  />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
            
					</td>
				</tr>
</form>
				<tr>
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="4" align="center">
                    <?
						if($conductoCobro == "Tarjeta+de+Credito"){
					?>
					<? require('seleccionarAgregar_Tarjetas.php');?>
                    <?
						}
					?>
					</td>
				</tr>
<form  name="formCotizadorExpres" id="formCotizadorExpres"  method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad" >
				<tr>
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="4">
<!-- Multi Archivos -->

						<?
								require('expresImgRequisitos.php');
						?>
<!-- Multi Archivos -->
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
		<td colspan="2" align="right">
<?php
	if(
		$Actividad == "Emisi%F3n"
		||
		$Actividad == "Cotizaci%F3n"
	){
?>
			<input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" />
			<? echo urldecode($Actividad); ?> Urgente !!!
            &nbsp;
<?php
	}
?>
<?php
	if(
		$Actividad == "Emisi%F3n"
		// Endoso
		// Renovacion
	){
?>
			<input name="mesesIntereses" id="mesesIntereses" type="checkbox" title="Clic Para Seleccionar" value="1" />
			Meses Intereses
            &nbsp;
<?php
	}
?>
			<input type="hidden" name="idRef" id="idRef" value="<?php echo ($idRefCliente != "")? $idRefCliente : $idRefProspecto; ?>" />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
			<input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1" />
		    <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />    
		    <input type="button" value="Guardar Emisi&oacute;n" onclick="ValidarCotizadorExpres()" class="buttonGeneral" /><!-- Guardar New -->
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</form>
<!-- Cotizador Expres -->
<?php
}
echo "<pre>";
	print_r($_REQUEST);
echo "</pre>";
?>