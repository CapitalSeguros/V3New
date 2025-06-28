<?
$sqlSubordinados = "
		Select
			`usuario_usuarios`.`Usuario`
			,`usuario_usuarios`.`UsuarioValor`
			,`usuarios`.`NOMBRE`
			,`usuarios`.`VALOR`
		From 
				`usuario_usuarios`  Inner Join `usuarios` 
			On 
				`usuario_usuarios`.`UsuarioValor` = `usuarios`.`CLAVE`
		Where `usuario_usuarios`.`Usuario` = '$Usuario'
					 ";
$resSubordinados = DreQueryDB($sqlSubordinados);
$tieneSubordinados = mysql_num_rows($resSubordinados);
?>
<table width="950" cellpadding="1" cellspacing="0" border="0">
	<tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
<!-- -->
<?php
if(false){ // $Usuario == '0000028961'
if($tieneSubordinados > 0){
?>
	<tr>
    	<td colspan="4">
			<form name="formSelectSubordinado" id="formSelectSubordinado" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<select name="idSubordinado" id="idSubordinado" onchange="document.formSelectSubordinado.submit();" style="width:100%;">
                	<option value="">-- Seleccione Subordinado --</option>
                    <?php
						while($rowSubordinados = mysql_fetch_assoc($resSubordinados)){
					?>
                    <option value="<?php echo $rowSubordinados['UsuarioValor']; ?>" <?php echo ($rowSubordinados['UsuarioValor']==$idSubordinado)? "selected" : ""; ?>>
						<?php echo $rowSubordinados['NOMBRE']; ?>
                    </option>
                    <?php
						}
					?>
				</select>
			</form>
        </td>
    </tr>
<?php
}
}
?>
<!-- -->

<!-- Primer Formulario -->
<form name="formAgendaGuardarV2" id="formAgendaGuardarV2" method="post" action="<? echo "includes/agregar.php?tipoAgregar=citaCalendario"; ?>">
	<tr>
    	<td>
        	Asunto:
		</td>
		<td colspan="3" align="left">
			<input type="text" name="cita" id="cita" style="width:100%" value="<?php echo $cita; ?>" >
		</td>
	</tr>
	<tr>
		<td>
			Lugar:
		</td>
		<td colspan="3" align="left">
			<input type="text" name="lugar" id="lugar" style="width:100%" value="<?php echo $lugar; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Categoria:
		</td>
		<td colspan="3" align="left">
			<?php SelectCategoriaCitaDre($categoria); ?>
			<input name="privado" type="checkbox" id="privado" value="1" <? echo ($privado == "1")? "checked":""; ?> />
			Privado
		</td>
	</tr>
    <tr>
		<td colspan="4"><hr></td>
    </tr>
	<tr>
		<td width="105">
			Inicio:
		</td>
		<td width="275" align="left">
			<input type="text" name="fechaStart" id="fechaStart" value="<?php echo ($fechaStart == "")? date('d-m-Y'):$fechaStart; ?>" readonly />
			<img src="img/cal.gif" id="fechaStart_Btn"  title="Clic">
			<?php
				SelectHoraCitaDreOnChange($horaStart, 'Start'); 
			?>
        </td>
		<td width="100" align="left">
			Todo el d&iacute;a:
        </td>
		<td width="470" align="left">
			<input name="todoDia" type="checkbox" id="todoDia" value="1" <? echo ($todoDia)? "checked":""; ?>/>
        </td>
	</tr>
	<tr>
    	<td>
			Finalizaci&oacute;n:
        </td>
        <td align="left">
			<input type="text" name="fechaEnd" id="fechaEnd" value="<?php echo ($fechaStart == "")? date('d-m-Y'):$fechaStart; ?>" readonly />
            <img src="img/cal.gif" id="fechaEnd_Btn"  title="Clic">
			<?php
            	SelectHoraCitaDre($horaEnd, 'End'); 
			?>            
        </td>
        <td align="left">
			Periodicidad:
        </td>
        <td align="left">
            <select name="periodicidad" id="periodicidad">
            	<option value="" <? echo ($periodicidad =="")? "selected":""?>>Evento &uacute;nico</option>
            	<option value="diario" <? echo ($periodicidad =="diario")? "selected":""?>>A diario</option>
            	<option value="diaLaborable" <? echo ($periodicidad =="diaLaborable")? "selected":""?>>*Cada d&iacute;a laborable</option>
            	<option value="semana" <? echo ($periodicidad =="semana")? "selected":""?>>Semanalmente</option>
            	<option value="semanaDos" <? echo ($periodicidad =="semanaDos")? "selected":""?>>Cada 2 semanas</option>
            	<option value="mesDia" <? echo ($periodicidad =="mesDia")? "selected":""?>>Mensual d&iacute;a</option>
            	<option value="mesFecha" <? echo ($periodicidad =="mesFecha")? "selected":""?>>Mensual Fecha</option>
            	<option value="year" <? echo ($periodicidad =="year")? "selected":""?>>Anual</option>
            </select>
        </td>
	</tr>
    <tr>
    	<td colspan="4"><hr></td>
    </tr>
    <tr>
    	<td colspan="4">
			<?php
				$tipo_toolbar = "Default";
				$oFCKeditor = new FCKeditor('texto') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = urldecode(htmlspecialchars_decode($texto, ENT_NOQUOTES));
				$oFCKeditor->Create();              
			?>
        </td>
    </tr>
    <tr>
    	<td colspan="4"><hr></td>
    </tr>
    <tr align="center" valign="top">
    	<td colspan="4">
			<?php include('calendarioInvitados.php'); ?>
        </td>
    </tr>
<?
	if(!isset($addInvitados)){
?>
    <tr>
    	<td colspan="4" align="right">
            <input type="submit" id="addInvitados" name="addInvitados" value="Agregar Invitados"
            />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
<?
	}
?>
    <tr>
    	<td colspan="4"><hr></td>
    </tr>
    <tr>
    	<td colspan="4" align="right" valign="top">
        <!--
        	<input type="hidden" id="idSubordinado" name="idSubordinado"
            	value="<? echo $idSubordinado; ?>"
            />
		-->
        	<input type="hidden" id="usuario" name="usuario"
            	value="<? echo ($_POST['idSubordinado'])? $_POST['idSubordinado']: $Usuario; ?>" 
            />
        	<input type="button" id="buttonCancelar" name="buttonCancelar" value="Cancelar" class="buttonGeneral"
            	onclick="java:window.open('calendario.php','_self');"
            />
        	<input type="button" id="buttonCancelar" name="buttonCancelar" value="Agendar" class="buttonGeneral"
            	onclick="agendarCitaSinInvitadosV2('formAgendaGuardarV2', '', '');"
            />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
	<tr>
    	<td colspan="4">
	</td>
<!-- -->
</form>
        </td>
    </tr>
</table>
<script type="text/javascript">
function agendarCitaConInvitadosV2(nameFormOrigen, nameFormDestino, param){
	
	var f_Origen = document.forms[nameFormOrigen];
	//-> var f_Destino = document.forms[nameFormDestino];

	var cita = f_Origen.cita.value;
	var fechaStart = f_Origen.fechaStart.value;
	var horaStart = f_Origen.horaStart.value;
	var fechaEnd = f_Origen.fechaEnd.value;
	var horaEnd = f_Origen.horaEnd.value;
	
	var error = "";

	/* Validamos Campos de la Actividad */
	if(cita == ""){
		error+= "\n Escriba el Asunto de la Cita !!!";
	}
	
	if(fechaStart == ""){
		error+= "\n Seleccione una Fecha de Inicio !!!";
	}

	if(horaStart == ""){
		error+= "\n Seleccione una Hora de Inicio !!!";
	}

	if(fechaEnd == ""){
		error+= "\n Seleccione una Fecha de Finalizaci\u00f3n !!!";
	}

	if(horaEnd == ""){
		error+= "\n Seleccione una Hora de Finalizaci\u00f3n !!!";
	}

	/* validamos la existencia de duplicidad en la agenda */
		//error+= "\n Ya tienes una Cita en la Misma Fecha y Hora !!!";

	/* Mandamos la actividad al correo */	
	if(error == ""){
		
		f_Origen.submit();
	} else {
		alert(error);
	}
}

function agendarCitaSinInvitadosV2(nameFormOrigen, nameFormDestino, param){
	
	var f = document.forms[nameFormOrigen];

	var cita = f.cita.value;
	var fechaStart = f.fechaStart.value;
	var horaStart = f.horaStart.value;
	var fechaEnd = f.fechaEnd.value;
	var horaEnd = f.horaEnd.value;
	
	var error = "";

	/* Validamos Campos de la Actividad */
	if(cita == ""){
		error+= "\n Escriba el Asunto de la Cita !!!";
	}
	
	if(fechaStart == ""){
		error+= "\n Seleccione una Fecha de Inicio !!!";
	}

	if(horaStart == ""){
		error+= "\n Seleccione una Hora de Inicio !!!";
	}

	if(fechaEnd == ""){
		error+= "\n Seleccione una Fecha de Finalizaci\u00f3n !!!";
	}

	if(horaEnd == ""){
		error+= "\n Seleccione una Hora de Finalizaci\u00f3n !!!";
	}

	/* validamos la existencia de duplicidad en la agenda */
		//error+= "\n Ya tienes una Cita en la Misma Fecha y Hora !!!";

	/* Mandamos la actividad al correo */	
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function agregarInvitadosV2(){
	var f_origen = document.formAgendaGuardar;
	var f_destino = document.formAgenda;

	var f = document.formAgenda;
	
	var cita = f.cita.value;	
	var fechaStart = f.fechaStart.value;
	var horaStart = f.horaStart.value;
	var fechaEnd = f.fechaEnd.value;
	var horaEnd = f.horaEnd.value;

	var error = "";
	
	//--> Reenvio de Variable
	f_destino.texto.defaultValue = f_origen.textoEditor.value;
		
	if(cita == ""){
		error+= "\n Escriba el Asunto de la Cita !!!";
	}
	
	if(fechaStart == ""){
		error+= "\n Seleccione una Fecha de Inicio !!!";
	}

	if(horaStart == ""){
		error+= "\n Seleccione una Hora de Inicio !!!";
	}

	if(fechaEnd == ""){
		error+= "\n Seleccione una Fecha de Finalizaci\u00f3n !!!";
	}

	if(horaEnd == ""){
		error+= "\n Seleccione una Hora de Finalizaci\u00f3n !!!";
	}
	
	if(error == ""){
		f.submit(); 
	} else {
		alert(error);
	}
}


function cambiaDatosFechaStartVsEnd(){ // nameFormOrigen, nameFormDestino, param [cambiaDatosFechaFin]

		var f_Origen = document.formAgendaGuardarV2; //--> document.forms[nameFormOrigen];
		var f_Destino = document.formAgendaGuardarV2; //--> document.forms[nameFormDestino
	
		var fechaEnd = f_Destino.fechaEnd.value;

	if(fechaStart != ""){
		f_Destino.fechaEnd.defaultValue = f_Destino.fechaStart.value;
	}
				
	if(horaStart != ""){
		if(horaStart == '08:00'){ f_Destino.horaEnd.value = "08:30"; }
	}

}

function cambiaDatosHoraStartVsEnd(){  // nameFormOrigen, nameFormDestino, param [cambiaDatosHoraFin]

		var f_Origen = document.formAgendaGuardarV2; //--> document.forms[nameFormOrigen];
		var f_Destino = document.formAgendaGuardarV2; //--> document.forms[nameFormDestino];

		var horaStart = f_Origen.horaStart.value;
				
	if(horaStart != ""){
		if(horaStart == '08:00'){ f_Destino.horaEnd.value = "08:30"; }
		if(horaStart == '08:30'){ f_Destino.horaEnd.value = "09:00"; }
		if(horaStart == '09:00'){ f_Destino.horaEnd.value = "09:30"; }
		if(horaStart == '09:30'){ f_Destino.horaEnd.value = "10:00"; }
		if(horaStart == '10:00'){ f_Destino.horaEnd.value = "10:30"; }
		if(horaStart == '10:30'){ f_Destino.horaEnd.value = "11:00"; }
		if(horaStart == '11:00'){ f_Destino.horaEnd.value = "11:30"; }
		if(horaStart == '11:30'){ f_Destino.horaEnd.value = "12:00"; }
		if(horaStart == '12:00'){ f_Destino.horaEnd.value = "12:30"; }
		if(horaStart == '12:30'){ f_Destino.horaEnd.value = "13:00"; }
		if(horaStart == '13:00'){ f_Destino.horaEnd.value = "13:30"; }
		if(horaStart == '13:30'){ f_Destino.horaEnd.value = "14:00"; }
		if(horaStart == '14:00'){ f_Destino.horaEnd.value = "14:30"; }
		if(horaStart == '14:30'){ f_Destino.horaEnd.value = "15:00"; }
		if(horaStart == '15:00'){ f_Destino.horaEnd.value = "15:30"; }
		if(horaStart == '15:30'){ f_Destino.horaEnd.value = "16:00"; }
		if(horaStart == '16:00'){ f_Destino.horaEnd.value = "16:30"; }
		if(horaStart == '16:30'){ f_Destino.horaEnd.value = "17:00"; }
		if(horaStart == '17:00'){ f_Destino.horaEnd.value = "17:30"; }
		if(horaStart == '17:30'){ f_Destino.horaEnd.value = "18:00"; }
		if(horaStart == '18:00'){ f_Destino.horaEnd.value = "18:30"; }
		if(horaStart == '18:30'){ f_Destino.horaEnd.value = "19:00"; }
		if(horaStart == '19:00'){ f_Destino.horaEnd.value = "19:30"; }
		if(horaStart == '19:30'){ f_Destino.horaEnd.value = "20:00"; }
		if(horaStart == '20:00'){ f_Destino.horaEnd.value = "20:00"; }		 
	}

}
	Calendar.setup(
		{
		inputField : "fechaStart",
		trigger    : "fechaStart_Btn",
		onSelect   : function() { this.hide(), cambiaDatosFechaStartVsEnd() },
		dateFormat : "%d-%m-%Y"
		}
		);
	Calendar.setup(
		{
		inputField : "fechaEnd",
		trigger    : "fechaEnd_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
		}
		);
</script>