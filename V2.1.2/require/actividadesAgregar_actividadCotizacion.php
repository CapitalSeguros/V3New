<?php
if(
	$Actividad == "Cotizaci%F3n"
	&&
	(
	$idRefCliente != ""
	||
	$idRefProspecto != ""
	)
){
?>
<!-- Cotizador Expres -->
<form  name="formCotizadorExpres" id="formCotizadorExpres"  method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad" >
	<tr>
    	<td colspan="2">
			<table width="100%" cellpadding="2" cellspacing="2" border="0">
				<tr>
    				<td colspan="4"><hr /></td>
				</tr>
				<tr>
					<td colspan="4">
	                    Datos Cotizaci&oacute;n Expr&eacute;s:
                   		<blockquote>
							<?php
								$tipo_toolbar = "Dre";
								$oFCKeditor = new FCKeditor('Referencia') ;
								$oFCKeditor->BasePath = 'fckeditor/' ;
								$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
								// $oFCKeditor->Value = "";
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
					<td colspan="4"><hr></td>
				</tr>
				<tr>
					<td colspan="4">
<!-- Multi Archivos -->
						<? require('expresImgRequisitos.php');?>
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
			<input type="hidden" name="idRef" id="idRef" value="<?php echo ($idRefCliente != "")? $idRefCliente : $idRefProspecto; ?>" />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
			<input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1" />
		    <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />    
		    <input type="button" value="Guardar Cotizaci&oacute;n" onclick="ValidarCotizadorExpres()" class="buttonGeneral" /><!-- Guardar New -->
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</form>
<!-- Cotizador Expres -->
<?php
}
?>