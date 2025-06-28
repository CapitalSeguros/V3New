<?
$existePoliza = 1;
?>
<script>
	function selectCliente(urlReenvio){	
		window.open(urlReenvio,'_self');
	}
</script>

<form 
	name="formAgregarComentarioCobranza" id="formAgregarComentarioCobranza" 
    method="post" enctype="multipart/form-data" 
	action="includes/agregarActividades.php?tipoAgregar=Actividad"
>
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
    	<td>
			<table width="900" border="0">
            	<tr>
                	<td width="200" align="right">Poliza:</td>
					<td style="font-style:italic; font-weight:bold;">
                    	<? echo $poliza; ?>
                        <input type="hidden" id="poliza" name="poliza" value="<? echo $poliza; ?>" />
                    </td>
				</tr>
            	<tr>
                	<td width="200" align="right">Tipo Comentario</td>
					<td>
                    	<?php
							$urlReenvio = $_SERVER['PHP_SELF']."?Actividad=comentarioCobranza";
							$urlReenvio.= "&poliza=".$poliza;
							$urlReenvio.= "&tipoComentario=";
						?>
                    	<select
                        	type="text" name="tipoComentario" id="tipoComentario"
                            onchange="selectCliente('<? echo $urlReenvio; ?>' + this.value);"
                        >
                        	<option 
                            	value="COMENTARIO" 
								<? echo ($tipoComentario == "COMENTARIO")? "selected":""; ?>
                            >
                            	COMENTARIO
                            </option>
                        	<option 
                            	value="DILIGENCIA" 
								<? echo ($tipoComentario == "DILIGENCIA")? "selected":""; ?>
                            >
                            	DILIGENCIA
                            </option>
                        	<option 
                            	value="RECORDATORIO" 
								<? echo ($tipoComentario == "RECORDATORIO")? "selected":""; ?>
                            >
                            	RECORDATORIO
                            </option>
                        </select>
                    </td>
                </tr>
			<?
			if(isset($tipoComentario) && $tipoComentario != "COMENTARIO" ){
			?>
            	<tr>
                	<td width="200" align="right">Fecha</td>
					<td>
                    	<input 
                        	type="text" name="fechaComentario" id="fechaComentario"
                            style="width:90px" readonly  
                            value="<? echo date('Y-m-d'); ?>" 
                        />
						<img src="img/cal.gif" id="fechaComentario_Btn"  title="Clic" />
                    </td>
                </tr>
            	<tr>
                	<td width="200" align="right">Hora</td>
					<td>
						<?
							SelectHoraCitaDre($horaEnd, '');
						?>
                    </td>
                </tr>
			<?
			}
			?>
            </table>
        </td>
	</tr> 
	<tr>
    	<td colspan="2">
        	Comentario:
			<blockquote>
            <?php
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('comentario') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = $txtFormulario;
				$oFCKeditor->Create();              
			?>
			</blockquote>
        </td>
    </tr>       
    <tr>
		<td colspan="2" align="right">
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>"/>
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" />
            
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
            
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Comentario Cobranza" onclick="validacionAgregarComentarioCobranza('<? echo $existePoliza; ?>');" class="buttonGeneral"/>
            <!-- JavaScript: document.formAgregarComentarioCobranza.submit(); -->
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>

</form>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fechaComentario",
		trigger    : "fechaComentario_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
</script>