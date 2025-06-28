<?php
$sqlInfoCita = "
	Select
		*
		,date_format(`fechaStart`, '%d-%m-%Y') As `fechaStartEsp`
		,date_format(`fechaEnd`, '%d-%m-%Y') As `fechaEndEsp`
		,date_format(`fechaStart`, '%H:%i') As `horaStart`
		,date_format(`fechaEnd`, '%H:%i') As `horaEnd`
	From 
		`agenda`
	Where
		`agenda`.`idAgendaMd5` = '$idAgenda'
			   ";
$resInfoCita = DreQueryDB($sqlInfoCita);
$rowInfoCita = mysql_fetch_assoc($resInfoCita);
	
$sqlInfoCitaDetalle = "
	Select * From
		`agenda_invitados`
	Where
		`idAgenda` = '".$rowInfoCita['idAgenda']."'
		And
		`usuario` = '".$Usuario."'
					  ";
$resInfoCitaDetalle = DreQueryDB($sqlInfoCitaDetalle);
$rowInfoCitaDetalle = mysql_fetch_assoc($resInfoCitaDetalle);

$sqlSerieCita = "
	Select 		
		*
	From 
		`agenda`
	Where
		`idAgenda` = '$rowInfoCita[idAgenda]'
		Or
		`padre` = '$rowInfoCita[idAgenda]'
	Order By
		`fechaStart` Asc
				";
//echo "<pre>".$sqlSerieCita."</pre>";
$totalCitaSerializada = 1 - mysql_num_rows(DreQueryDB($sqlSerieCita));
$resSerieCita = DreQueryDB($sqlSerieCita);

$sqlInfoInvitadosExistentes = "
	Select * From
		`agenda_invitados`
	Where
		`idAgenda` = '".$rowInfoCita['idAgenda']."'
							  ";

switch($rowInfoCitaDetalle['confirmado']){
		case 0: // Pendiente de Confirmar
			$estadoCita = "Cita Pendiente de Confirmar !!!";
		break;
		
		case 1: // Confirmada
			$estadoCita = "Cita Confirmada !!!";
		break;
		
		case 2: // Cancelada
			$estadoCita = "Cita Cancelada";
		break;
}

switch($rowInfoCita['periodicidad']){
	case "year":
		$tituloPeriodicidad = "[Anual]";
	break;
	
	case "diario":
		$tituloPeriodicidad = "[Diario]";
	break;
	
	case "semana":
		$tituloPeriodicidad = "[Semanal]";
	break;
	
	case "semanaDos":
		$tituloPeriodicidad = "[Cada 2 Semanas]";
	break;
	
	case "mesDia":
		$tituloPeriodicidad = "[Mensual Dia]";
	break;

	case "mesFecha":
		$tituloPeriodicidad = "[Mensual Fecha]";
	break;

	case "";
		$tituloPeriodicidad = "";
	break;
}

$urlCitaCalendario = "includes/cancelar.php?tipoCancelar=citaCalendario&idAgenda=".$rowInfoCita['idAgendaMd5'];
$urlCitaCalendarioSerializada = "includes/cancelar.php?tipoCancelar=citaCalendarioSerializada&idAgenda=".$rowInfoCita['idAgendaMd5'];

$urlCitaCalendarioCancelarIndividual = "includes/calendarioAgendaCancelacion.php?idAgenda=".$rowInfoCita['idAgendaMd5']."&usuario=".$Usuario;
$urlCitaCalendarioConfirmarIndividual = "includes/calendarioAgendaConfirmacion.php?idAgenda=".$rowInfoCita['idAgendaMd5']."&usuario=".$Usuario;

$fechaInicio = strftime($rowInfoCita['fechaStart']);
$fechaActual = strftime(date('Y-m-d h:i:s'));

?>
<table width="950" cellpadding="0" cellspacing="0" border="0" style="font-size:12px;">
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
	<tr>
    	<td colspan="2" style="font-size:14px; font-weight:bold; color:#F00;">
        	<?php echo $estadoCita; ?>
        </td>
    </tr>
	<?php
		if($fechaInicio > $fechaActual && $rowInfoCita['usuario'] == $Usuario){
	?>
	<tr>
    	<td colspan="2" align="right">

            <?
				if($totalCitaSerializada == 0){
			?>
        	<input type="button" value="Cancelar Cita" class="buttonGeneral" onclick="JavaScript: window.open('<?php echo $urlCitaCalendario; ?>','_self');"/>
            <?
				} else {
			?>
        	<input type="button" value="Cancelar Cita Serializada" class="buttonGeneral" onclick="JavaScript: window.open('<?php echo $urlCitaCalendarioSerializada; ?>','_self');"/>
            <?
				}
			?>
        </td>
    </tr>
    <?php
		} else if($fechaInicio > $fechaActual && $acreated == '0'){
	?>
	<tr>
    	<td colspan="2" align="right">
        	<input type="button" value="Cancelar Cita" class="buttonGeneral" onclick="JavaScript: window.open('<?php echo $urlCitaCalendarioCancelarIndividual; ?>','_self');"/>
            <?php if($rowInfoCitaDetalle['confirmado'] != 1){?>
            <input type="button" value="Confirmar Cita" class="buttonGeneral" onclick="JavaScript: window.open('<?php echo $urlCitaCalendarioConfirmarIndividual; ?>','_self');"/>
            <?php } ?>
        </td>
    </tr>
	<?php
		}
	?>
	<tr>
    	<td width="110">
        	Asunto:
        </td>
        <td width="840" align="left">
        	<strong><?php echo str_replace("'","",urldecode($rowInfoCita['cita'])); ?></strong>
        </td>
    </tr>
	<tr>
    	<td width="110">
        	Lugar:
        </td>
        <td width="840" align="left">
        	<strong><?php echo str_replace("'","",urldecode($rowInfoCita['lugar'])); ?></strong>
        </td>
    </tr>
	<tr>
    	<td>
        	Categoria:
        </td>
        <td align="left">
			<strong><? echo ($rowInfoCita['categoria'] == "")? "Sin Categoria" : $rowInfoCita['categoria']; ?></strong>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Pirvado: 
            <strong><?php echo ($rowInfoCita['privado'] == 1)? "Si" : "No"; ?></strong>
        </td>
    </tr>
    <tr>
    	<td colspan="2"><hr></td>
    </tr>
<?
	if($totalCitaSerializada == 0){
?>
	<tr>
    	<td>
        	Inicio:
        </td>
        <td align="left">
			<strong><?php echo DreFechaEsp($rowInfoCita['fechaStart']); ?></strong>
			<strong><? echo $rowInfoCita['horaStart']; ?>Hrs</strong>
            <strong><?php echo ($rowInfoCita['todoDia'] == 1)? "Todo el d&iacute;a" : ""; ?></strong>
        </td>
	</tr>
	<tr>
    	<td>
        	Finalizaci&oacute;n:
        </td>
        <td align="left">
			<strong><?php echo DreFechaEsp($rowInfoCita['fechaEnd']); ?></strong>
			<strong><? echo $rowInfoCita['horaEnd']; ?>Hrs</strong>
        </td>
	</tr>
<?
	} else {
?>
	<tr>
    	<td align="center">
        	Serie de Citas <br> <? echo $tituloPeriodicidad;  ?>
        </td>
        <td align="left">
        	<table width="830" cellpadding="2" cellspacing="0" border="0" style="font-size:12px;" align="right">
        	<?
				while($rowSerieCita = mysql_fetch_assoc($resSerieCita)){
				$urlCitaCalendarioElementoSerializada =  "includes/cancelar.php?tipoCancelar=citaCalendarioElementoSerializada";
				$urlCitaCalendarioElementoSerializada.=  "&idAgenda=".$rowSerieCita['idAgendaMd5'];
				//** echo $rowSerieCita['idAgenda'];		
				if($rowSerieCita['status'] == 1){
					$styleCancelada = 'style="font-style:italic; color:#F00;"';
				} else {
					$styleCancelada = '';
				}
			?>
            	<tr <? echo $styleCancelada; ?>>
                	<td width="250">
					<?php
						echo "<strong>Inicio:</strong>&nbsp;";
						echo DreFechaEsp($rowSerieCita['fechaStart'])."&nbsp;";
						echo $rowInfoCita['horaStart']."Hrs&nbsp;";
					?>
                    </td>
                	<td width="240">
                    <?php
						echo "<strong>Fin:</strong>&nbsp;";
						echo DreFechaEsp($rowSerieCita['fechaEnd'])."&nbsp;";
						echo $rowInfoCita['horaEnd']."Hrs&nbsp;";
					?>
                    </td>
                	<td width="430">
                    <?
						if(
							$rowSerieCita['status'] == 0
							&&
							$rowSerieCita['padre'] != 0
						){
					?>
						<input 
                        	type="button" value="Cancelar Elemento Cita Serializada" class="buttonGeneral" 
                        	onclick="JavaScript: window.open('<?php echo $urlCitaCalendarioElementoSerializada; ?>','_self');"
						/>
                    <?
						} else if($rowSerieCita['padre'] == 0){
					?>
                    <!--
						<input 
                        	type="button" value="Cancelar Cita Serializada" class="buttonGeneral" 
                        	onclick="JavaScript: window.open('<?php echo $urlCitaCalendarioSerializada; ?>','_self');"
						/>
					-->
                    <?
						} else{
					?>
						<strong>Elemento Cancelado!!!</strong>
                    <?
						}
					?>
                    </td>
                </tr>
            <?
				}
			?>
            </table>
        </td>
	</tr>
<?
	}
?>
    <tr>
    	<td colspan="2"><hr></td>
    </tr>
<?php
if(mysql_num_rows(mysql_query($sqlInfoInvitadosExistentes)) > 1){ // if si hay invitados
?>
    <tr>
    	<td colspan="2">
	        <?php require('calendarioInvitadosDetalle.php'); ?>
        </td>
    </tr>
    <tr>
    	<td colspan="2"><hr></td>
    </tr>
<?php
} // fin del if si hay invitados
?>

    <tr>
    	<td colspan="2">
        	<strong><?php echo $rowInfoCita['texto']; ?></strong>
		</td>
	</tr>
    <tr>
    	<td colspan="2" align="right">
        	<input type="button" value="Regresar" class="buttonGeneral" onclick="java:window.open('calendario.php','_self');" />
            &nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</table>