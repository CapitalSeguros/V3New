<table width="950" cellpadding="1" cellspacing="0" border="0">
	<tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
<form name="formAgenda" id="formAgenda" method="post" action="#">
	<tr>
    	<td>
        	<input type="" name="texto" id="texto" />
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
			<?php
				SelectCategoriaCitaDre($categoria);
			?>
			<input name="privado" type="checkbox" id="privado" value="1" <? echo ($privado == "1")? "checked":""; ?> />
			Privado
		</td>
	</tr>
    <tr>
		<td colspan="4"><hr></td>
    </tr>
<?php
if($MiMismo['MiMismo'] != "0"){ // validamos que no estes ocupado miMismo
?>
	<tr>
	  <td colspan="4">
		<font style="color:#FF0004;">
			Ya tienes una Cita en la Misma Fecha y Hora
		</font>
      </td>
    </tr>
<?php
}
?>
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
<?php
if($MiMismo != "1"){
?>    
    <tr>
    	<td colspan="4" align="right">

			<input type="button" value="Agregar Invitados" class="buttonGeneral" onclick="agregarInvitadosV2();" />
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
<?php
}
?>
    <tr>
    	<td colspan="4"><hr></td>
    </tr>
</form>
<form name="formAgendaGuardar" id="formAgendaGuardar" method="post" action="#">
<?php

if($MiMismo['MiMismo'] == "0"){ // validamos que no estes ocupado miMismo

if(isset($fechaStart) && isset($fechaEnd) && isset($horaStart) && isset($horaEnd)){
?>
    <tr valign="top">
    	<td colspan="4">
			<?php include('calendarioInvitados.php'); ?>
        </td>
    </tr>
    <tr>
    	<td colspan="4"><hr></td>
    </tr>
<?php
}
} // fin de ya estas ocupado miMismo
?>
    <tr>
    	<td colspan="4">
			<?php
				$tipo_toolbar = "Default";
				$oFCKeditor = new FCKeditor('textoEditor') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = $textoEditor;
				$oFCKeditor->Create();              
			?>
        </td>
    </tr>
    <tr>
    	<td colspan="4">
			<input type="" name="texto2" id="texto2"/>
            <input type="hidden" name="cita" id="cita" value="<? echo $cita; ?>" />
        	<input type="hidden" name="lugar" id="lugar" value="<? echo $lugar; ?>" />
        	<input type="hidden" name="categoria" id="categoria" value="<? echo $categoria; ?>" />
        	<input type="hidden" name="privado" id="privado" value="<? echo $privado; ?>" />
        	<input type="hidden" name="fechaStart" id="fechaStart" value="<? echo $fechaStart; ?>" />
        	<input type="hidden" name="horaStart" id="horaStart" value="<? echo $horaStart; ?>" />
        	<input type="hidden" name="todoDia" id="todoDia" value="<? echo $todoDia; ?>" />
        	<input type="hidden" name="fechaEnd" id="fechaEnd" value="<? echo $fechaEnd; ?>" />
        	<input type="hidden" name="horaEnd" id="horaEnd" value="<? echo $horaEnd; ?>" />
        	<input type="hidden" name="periodicidad" id="periodicidad" value="<? echo $periodicidad; ?>" />
        	<input type="hidden" name="enviaAgendarCita" id="enviaAgendarCita" value="1" />

        	<input type="hidden" name="usuario" id="usuario" value="<? echo $Usuario; ?>"/>
            <input type="button" onClick="alert(document.formAgendaGuardar.texto.value);" />
            
            <input type="submit" />
        </td>
	</tr>
</form>
<?php

?>
<form name="formAgendaValidarCita" id="formAgendaValidarCita" method="post" action="includes/agregar.php?tipoAgregar=citaCalendario">
	<tr>
    	<td colspan="4">
            <input type="hidden" name="cita" id="cita" value="<? echo $cita; ?>" />
        	<input type="hidden" name="lugar" id="lugar" value="<? echo $lugar; ?>" />
        	<input type="hidden" name="categoria" id="categoria" value="<? echo $categoria; ?>" />
        	<input type="hidden" name="privado" id="privado" value="<? echo $privado; ?>" />
        	<input type="hidden" name="fechaStart" id="fechaStart" value="<? echo $fechaStart; ?>" />
        	<input type="hidden" name="horaStart" id="horaStart" value="<? echo $horaStart; ?>" />
        	<input type="hidden" name="todoDia" id="todoDia" value="<? echo $todoDia; ?>" />
        	<input type="hidden" name="fechaEnd" id="fechaEnd" value="<? echo $fechaEnd; ?>" />
        	<input type="hidden" name="horaEnd" id="horaEnd" value="<? echo $horaEnd; ?>" />
        	<input type="hidden" name="periodicidad" id="periodicidad" value="<? echo $periodicidad; ?>" />
			
            <input type="hidden" name="enviaAgendarCita" id="enviaAgendarCita" value="<? echo $enviaAgendarCita; ?>" />
            
			<input type="" name="texto" id="texto" value="<? echo $texto; ?>"/>
        	<input type="hidden" name="usuario" id="usuario" value="<? echo $Usuario; ?>"/>
        </td>
	</tr>
</form>
<?php
?>
	<tr>
    	<td colspan="4">
    <tr>
    	<td colspan="4" align="right" valign="top">

        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('calendario.php','_self');" />
<?php
if(
	(
		isset($fechaStart) 
		&& 
		isset($fechaEnd) 
		&& 
		isset($horaStart) 
		&& 
		isset($horaEnd)
	) 
	&& 
	$MiMismo['MiMismo'] == "0"
){
?>
        	<input type="button" value="Agendar Old" class="buttonGeneral" onclick="agendarValidarCita('<? echo $MiMismo; ?>');" />
<?php
} else if($MiMismo['MiMismo'] == "0"){
?>
			<input type="button" value="Agendar New 1" class="buttonGeneral" onClick="agendarSinInvitadosV2();" />	
<?php
} else if($MiMismo['MiMismo'] != "0"){
?>
			<input type="button" value="Agendar New 2" class="buttonGeneral" onClick="agendarValidarCita('<? echo $MiMismo; ?>');" />
<?php
}
?>
        </td>
    </tr>
        </td>
    </tr>
</table>
<script type="text/javascript">

function agendarValidarCita(existenCitas){
	var f = document.formAgendaValidarCita;
	var error = "";
	var textAlert = "Ya tienes una Cita en la Misma Fecha y Hora";
	
	if(error == ""){
		if(existenCitas == "0"){
			f.submit();
		} else {
			alert(textAlert);
		}
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

function agendarSinInvitadosV2(){

	/* Pasamos las Variables Entre Formularios */	
	var f_origen = document.formAgenda;
	var f_destino = document.formAgendaGuardar;

	var error = "";

	f_destino.cita.defaultValue = f_origen.cita.value;
	f_destino.lugar.defaultValue = f_origen.lugar.value;
	f_destino.categoria.defaultValue = f_origen.categoria.value;
	f_destino.privado.defaultValue = f_origen.privado.value;
	f_destino.fechaStart.defaultValue = f_origen.fechaStart.value;
	f_destino.horaStart.defaultValue = f_origen.horaStart.value;
	f_destino.todoDia.defaultValue = f_origen.todoDia.value;
	f_destino.fechaEnd.defaultValue = f_origen.fechaEnd.value;
	f_destino.horaEnd.defaultValue = f_origen.horaEnd.value;
	f_destino.periodicidad.defaultValue = f_origen.periodicidad.value;

	 //--> document.formAgenda.texto.defaultValue = document.formAgendaGuardar.texto.value;

	var cita = f_destino.cita.value;
	var fechaStart = f_destino.fechaStart.value;
	var horaStart = f_destino.horaStart.value;
	var fechaEnd = f_destino.fechaEnd.value;
	var horaEnd = f_destino.horaEnd.value;
		
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
		//--> alert(document.formAgendaGuardar.texto.value);
		f_destino.submit();
	} else {
		alert(error);
	}

}

function cambiaDatosFechaFin(){
	var f = document.formAgenda;
	var fechaEnd = f.fechaEnd.value;

	if(fechaStart != ""){
		document.formAgenda.fechaEnd.defaultValue = document.formAgenda.fechaStart.value;
	}
}

function cambiaDatosHoraFin(){
		var f = document.formAgenda;
		var horaStart = document.formAgenda.horaStart.value;
				
	if(horaStart != ""){
		if(horaStart == '08:00'){ document.formAgenda.horaEnd.value = "08:30"; }
		if(horaStart == '08:30'){ document.formAgenda.horaEnd.value = "09:00"; }
		if(horaStart == '09:00'){ document.formAgenda.horaEnd.value = "09:30"; }
		if(horaStart == '09:30'){ document.formAgenda.horaEnd.value = "10:00"; }
		if(horaStart == '10:00'){ document.formAgenda.horaEnd.value = "10:30"; }
		if(horaStart == '10:30'){ document.formAgenda.horaEnd.value = "11:00"; }
		if(horaStart == '11:00'){ document.formAgenda.horaEnd.value = "11:30"; }
		if(horaStart == '11:30'){ document.formAgenda.horaEnd.value = "12:00"; }
		if(horaStart == '12:00'){ document.formAgenda.horaEnd.value = "12:30"; }
		if(horaStart == '12:30'){ document.formAgenda.horaEnd.value = "13:00"; }
		if(horaStart == '13:00'){ document.formAgenda.horaEnd.value = "13:30"; }
		if(horaStart == '13:30'){ document.formAgenda.horaEnd.value = "14:00"; }
		if(horaStart == '14:00'){ document.formAgenda.horaEnd.value = "14:30"; }
		if(horaStart == '14:30'){ document.formAgenda.horaEnd.value = "15:00"; }
		if(horaStart == '15:00'){ document.formAgenda.horaEnd.value = "15:30"; }
		if(horaStart == '15:30'){ document.formAgenda.horaEnd.value = "16:00"; }
		if(horaStart == '16:00'){ document.formAgenda.horaEnd.value = "16:30"; }
		if(horaStart == '16:30'){ document.formAgenda.horaEnd.value = "17:00"; }
		if(horaStart == '17:00'){ document.formAgenda.horaEnd.value = "17:30"; }
		if(horaStart == '17:30'){ document.formAgenda.horaEnd.value = "18:00"; }
		if(horaStart == '18:00'){ document.formAgenda.horaEnd.value = "18:30"; }
		if(horaStart == '18:30'){ document.formAgenda.horaEnd.value = "19:00"; }
		if(horaStart == '19:00'){ document.formAgenda.horaEnd.value = "19:30"; }
		if(horaStart == '19:30'){ document.formAgenda.horaEnd.value = "20:00"; }
		if(horaStart == '20:00'){ document.formAgenda.horaEnd.value = "20:00"; }		 
	}
}
	Calendar.setup(
		{
		inputField : "fechaStart",
		trigger    : "fechaStart_Btn",
		onSelect   : function() { this.hide(), cambiaDatosFechaFin() },
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