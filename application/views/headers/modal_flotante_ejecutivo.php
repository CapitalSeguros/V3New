<!--Miguel 8/03/2021-->
<!--Div de Ejecutivos Operativos-->
<style type="text/css">
		 #divEjecutivosOperativos{
			position:fixed;
			left: 40%;
			width:280px;
			height: 55%;
			border-radius: 8px;
			background-color:#fff;
			bottom: 5%;
			z-index: 1;
         }
		.actividades{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		.actividadesAuto{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		.actividadesVida{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		.actividadesDanios{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		#actividadesAuto{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		#actividadesAuto:hover{
			background-color: #01DF74;
		}
		#actividadesDanios{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		#actividadesDanios:hover{
			background-color: #01DF74;
		}

		#actividadesVida{
			border-radius: 4px;
			width: 100%;
			background-color: #85C1E9;
			color: #fff;	
		}
		#actividadesVida:hover{
			background-color: #01DF74;
		}
		#verde{
			background-color: #04B404;
		}
		#amarillo{
			background-color: #FFBF00;
		}
		#rojo{
			background-color: #FA5858;
		}
		/* fin Miguel 8/03/2021*/
</style>
<?php
$user=$this->tank_auth->get_usermail();
$ci =& get_instance();
$ci->load->model('cuadromando_model');
$mes=date('m');
$year=date('Y');
if(($user=='AUTOS@ASESORESCAPITAL.COM')||($user=='BIENES@ASESORESCAPITAL.COM')||($user=='LINEASPERSONALES@ASESORESCAPITAL.COM')){

switch ($user) {
	case 'AUTOS@ASESORESCAPITAL.COM':
		$ramo='AUTOS';
		$ramo_name='Autos';
		$Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("AUTOS");
		break;
	
	case 'BIENES@ASESORESCAPITAL.COM':
		$ramo='DANIOS';
		$ramo_name='Daños';
		$Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("DANIOS");
		break;
	case 'LINEASPERSONALES@ASESORESCAPITAL.COM':
		$ramo='VIDA';
		$ramo_name='Lineas Personales';
		$Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("VIDA");
		break;
}

$semaforo=$ci->cuadromando_model->getSemaforo($ramo,$mes,$year);

$ctCotizacionVerde=$semaforo[0];
$ctCotizacionAmarillo=$semaforo[1];
$ctCotizacionRojo=$semaforo[2];

$ctCancelacionVerde=$semaforo[3];
$ctCancelacionAmarillo=$semaforo[4];
$ctCancelacionRojo=$semaforo[5];

$ctEndosoVerde=$semaforo[6];
$ctEndosoAmarillo=$semaforo[7];
$ctEndosoRojo=$semaforo[8];

$ctEmisionVerde=$semaforo[9];
$ctEmisionAmarillo=$semaforo[10];
$ctEmisionRojo=$semaforo[11];
?>
<div  id="divEjecutivosOperativos">
	<div style="width: 100%;background-color: #E6E6E6;height: 30px;text-align: center;">
		<i class='fa fa-bell'></i>KPI Operativo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href='javascript: void(0)' onclick='cerrarAlerta_Ejecutivos()' class='cerrar_xx'><i class='fa fa-caret-down' aria-hidden='true'></i></a>
	</div>
	<div id="contenedor_info_ejecutivos">
	<div class='actividades text-center' style='margin-top: 10px;'>
		<label for='polizaEfectuada' style='margin-top:5px;'><i class='fa fa-cogs' aria-hidden='true'></i>
		&nbsp;Actividades Ramo <b><?php echo $ramo_name?></b> <?php echo $meses[date("n")].", ".date("Y");?>
		</label>
	</div>
		<div style='margin-top: 11px; margin-left: 5px'>
			<span class='label label-warning' style='font-size: 11px'>Fecha actual:</span>&nbsp;
			<span class='label label-info' style='font-size: 11px'><?php echo date('d-m-Y')?></span>
		</div>
		<div style='margin-top: 11px; margin-left: 5px'>
			<span class='label label-warning' style='font-size: 11px'>Dias hábiles:</span>&nbsp;
			<span class='label label-info' style='font-size: 11px'><?php echo  $cnc. 'días (Hasta '.date("d-m-Y", mktime(0,0,0,date('m')+1,0,date('Y'))).')'?></span>
		</div>
		<div style='margin-top: 11px; margin-left: 5px'>
			<table style="width: 100%;">
					<td style="width: 40%;text-align: right;"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;</td>
					<td style="background-color: #E2E2E2;text-align: center;">Diario</td>
					<td style="background-color: #E2E2E2;text-align: center;">Semanal</td>
				</tr>
				<tr>
					<td><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 2;padding: 2px;border-radius: 4px;text-align: center;font-size: 12px">Promedio</div></td>
					<td style="text-align: center;"><b><?php echo $ci->cuadromando_model->promedio_atencion_actividades($ramo)[0];?></b></td>
					<td style="text-align: center;"><b><?php echo $ci->cuadromando_model->promedio_atencion_actividades($ramo)[1];?></b></td>
				</tr>
			</table>
		</div>
		<br>
		<table style="font-size: 12px;width: 100%;text-align: center;">
			<tr>
				<td rowspan="2" style="width: 45%;"></td>
				<td colspan="3"><div class='actividades' style='font-size: 12px;padding: 2px;'>SEMAFORO</div></td>
			</tr>
			<tr style="text-align: center;background-color: #E2E2E2;">
				<td><span class="badge badge-default" id="verde">&nbsp;</span></td>
				<td><span class="badge badge-default" id="amarillo">&nbsp;</span></td>
				<td><span class="badge badge-default" id="rojo">&nbsp;</span></td>
			</tr>
			<tr>
				
				<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 1;border-radius: 4px;padding: 2px;"><i class="fa fa-check-circle"></i>&nbsp;Cotizaciónes:&nbsp;&nbsp;</div></td>
				<td style="text-align: center;"><b><?php echo $ctCotizacionVerde?></b></td>
				<td style="text-align: center;"><b><?php echo $ctCotizacionAmarillo?></b></td>
				<td style="text-align: center;"><b><?php echo $ctCotizacionRojo?></b></td>
			</tr>
			
			<tr style="background-color: #F2F2F2;">
				<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.9;border-radius: 4px;padding: 2px;"><i class="fa fa-times-circle"></i>&nbsp;Cancelaciónes:&nbsp;&nbsp;</div></td>
				<td style="text-align: center;"><b><?php echo $ctCancelacionVerde?></b></td>
				<td style="text-align: center;"><b><?php echo $ctCancelacionAmarillo?></b></td>
				<td style="text-align: center;"><b><?php echo $ctCancelacionRojo?></b></td>
			</tr>
			<tr>
				<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.8;border-radius: 4px;padding: 2px;"><i class="fa fa-edit"></i>&nbsp;Endosos:&nbsp;&nbsp;</div></td>
				<td style="text-align: center;"><b><?php echo $ctEndosoVerde?></b></td>
				<td style="text-align: center;"><b><?php echo $ctEndosoAmarillo?></b></td>
				<td style="text-align: center;"><b><?php echo $ctEndosoRojo?></b></td>
			</tr>
			<tr style="background-color: #F2F2F2;">
				<td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.7;border-radius: 4px;padding: 2px;"><i class="fa fa-send"></i>&nbsp;Emisiónes:&nbsp;&nbsp;</div></td>
				<td style="text-align: center;"><b><?php echo $ctEmisionVerde?></b></td>
				<td style="text-align: center;"><b><?php echo $ctEmisionAmarillo?></b></td>
				<td style="text-align: center;"><b><?php echo $ctEmisionRojo?></b></td>
			</tr>
		</table><br><br>
		<div style="padding-top: 0;text-align: right;">
			<span style="font-size: 10px;color: #8370a1;text-shadow: 1px 1px 2px silver;"><i class="fa fa-user"></i>&nbsp;<?php echo $user;?>&nbsp;&nbsp;</span>
		</div>
	</div>
</div>
<?php }?>
