<form name="formAgregarActividadOtras" id="formAgregarActividadOtras" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad">
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
<!--
    <tr>
    	<td>
            Responsable:
            <select name="Responsable" id="Responsable">
				<option value="">-- Seleccione --</option>
                <?php
					$resResponsables = DreQueryDB($sqlResponsables);
					while($rowResponsables = mysql_fetch_assoc($resResponsables)){
				?>
            	<option value="<?php echo $rowResponsables['VALOR']; ?>" <?php echo ($rowResponsables['VALOR'] == $Usuario)? "selected" : "" ;?>><?php echo $rowResponsables['NOMBRE'].' ('.$rowResponsables['TIPO'].')'; ?></option>
                <?php } ?>
            </select> 
        </td>
    </tr>
-->
	<tr>
    	<td colspan="2">
        	Comentario:
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
		<td colspan="2">
<!-- Multi Archivos -->
						<? require('expresImgRequisitos.php');?>
<!-- Multi Archivos -->
		</td>
	</tr>
    <tr>
		<td colspan="2" align="right">
			<!-- <input type="" name="idRef" id="idRef" value="<?php //echo ($idRefCliente != "")? $idRefCliente : $idRefProspecto; ?>" /> -->

			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>"/>
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>"/>
			<input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1"/>
			<input type="hidden" name="idRef" id="idRef" value="0000014025"/>
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
            
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Aclaraci&oacute;n de Comisiones" onclick="JavaScript: document.formAgregarActividadOtras.submit();" class="buttonGeneral"/>
			&nbsp;&nbsp;&nbsp;&nbsp;            
        </td>
    </tr>
</form>