<link href='js/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='js/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='js/jquery/jquery-1.10.2.min.js'></script>
<script src='js/jquery/jquery-ui-1.10.3.custom.min.js'></script>
<script src='js/fullcalendar/fullcalendar.min.js'></script>
<style>
	#calendar {
		width: 900px;
		margin: 0 auto;
		}
</style>
<?
switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$activaFiltro = "si"; 
		$filtroActividadesPerfil = "
			And 
				(
					`usuario` = '$Usuario'
					Or
					`usuarioCreacion` = '$Usuario'
				)
								   ";
	break;
}
?>
<script>
	$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			events: [
				<?php
					$sqlAgenda = "
						Select
							`agenda`.`idAgenda`
							,`agenda`.`idAgendaMd5`
							,`agenda`.`usuario`
							,date_sub(`agenda`.`fechaStart`, interval 1 Month) As `fechaStart`
							,date_sub(`agenda`.`fechaEnd`, interval 1 Month) As `fechaEnd`
							,`agenda`.`cita`
							,`agenda`.`categoria`
							,`agenda`.`privado`
							,`agenda`.`todoDia`
							,`agenda`.`periodicidad`
						From
							`agenda` Inner Join `agenda_invitados` 
							On 
							`agenda`.`idAgenda` = `agenda_invitados`.`idAgenda`
						Where
						(
							(
							`agenda`.`usuario` = '$Usuario'
							Or
							`agenda_invitados`.`usuario` = '$Usuario'
							)
							And 
							(
							`agenda_invitados`.`confirmado` = '0'
							Or
							`agenda_invitados`.`confirmado` = '1'
							)
						) And (
							`agenda`.`status` = '0'
						)
						Group By 
							`agenda`.`idAgenda`
								 ";
					$resAGenda = DreQueryDB($sqlAgenda);	
					while($rowAgenda = mysql_fetch_assoc($resAGenda)){
						$dateStart = date_format(date_create($rowAgenda['fechaStart']),'Y, n, d, H, i ');
						$dateEnd = date_format(date_create($rowAgenda['fechaEnd']),'Y, n, d, H, i ');
					echo "{";

					echo "title: '";
					if($rowAgenda['privado'] == 0){ 
						echo str_replace("'","",urldecode($rowAgenda['cita']));
					} else {
						if($rowAgenda['usuario'] == $Usuario){
							echo str_replace("'","",urldecode($rowAgenda['cita']));
						} else {
							echo "No Disponible";
						}
					}
					InvitadosCitasDre($rowAgenda['idAgenda'],$Usuario);
					echo "'";
					echo ", start: new Date($dateStart)";
					echo ", end: new Date($dateEnd)";
					if($rowAgenda['todoDia'] == 1){ echo ", allDay: true"; } else { echo ", allDay: false"; }
					if($rowAgenda['categoria'] == ""){ 
						echo ", className : 'fc-event'"; 
					} else {
						switch($rowAgenda['categoria']){
							case "Amarilla":
								echo ", className : 'fc-event_Amarilla'";
							break;
							
							case "Azul":
								echo ", className : 'fc-event_Azul'";
							break;
							
							case "Naranja":
								echo ", className : 'fc-event_Naranja'";
							break;
							
							case "Morada":
								echo ", className : 'fc-event_Morada'";
							break;
							
							case "Roja":
								echo ", className : 'fc-event_Roja'";
							break;
							
							case "Verde":
								echo ", className : 'fc-event_Verde'";
							break; 
							
							default :
								echo ", className : 'fc-event'";
							break;
						}
					}

					if($rowAgenda['usuario'] == $Usuario){ echo ", url: 'calendarioDetalle.php?idAgenda=".$rowAgenda['idAgendaMd5']."'"; } else { echo ", url: 'calendarioDetalle.php?idAgenda=".$rowAgenda['idAgendaMd5']."&acreated=0'"; }
					echo "},"; 
					}
				?>
			]
		});
	});
</script>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign="top" align="right">
        	<a href="calendarioAgregar.php" title="Agregar Cita" style="text-decoration:none"><img src="img/transparente.fw.png" class="system agregar" alt="agregar" border="0"/></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
    </tr>
	<tr>
    	<td valign="top" align="center">
			<div id='calendar'></div>
    	</td>
	</tr>
</table>