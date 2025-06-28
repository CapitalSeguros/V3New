<style type="text/css">
	/*Miguel 8/03/2021
	Div de Ejecutivos Operativos*/
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
$CI->load->model('cuadromando_model');
$mes=date('m');
$year=date('Y');

    //Autos
    $semaforoAutos=$CI->cuadromando_model->getSemaforo('AUTOS',$mes,$year);

    
    $ctCotizacionVerdeAutos=$semaforoAutos[0];
	$ctCotizacionAmarilloAutos=$semaforoAutos[1];
	$ctCotizacionRojoAutos=$semaforoAutos[2];

	$ctCancelacionVerdeAutos=$semaforoAutos[3];
	$ctCancelacionAmarilloAutos=$semaforoAutos[4];
	$ctCancelacionRojoAutos=$semaforoAutos[5];

	$ctEndosoVerdeAutos=$semaforoAutos[6];
	$ctEndosoAmarilloAutos=$semaforoAutos[7];
	$ctEndosoRojoAutos=$semaforoAutos[8];

	$ctEmisionVerdeAutos=$semaforoAutos[9];
	$ctEmisionAmarilloAutos=$semaforoAutos[10];
	$ctEmisionRojoAutos=$semaforoAutos[11];

	//Daños
	$semaforoDanios=$CI->cuadromando_model->getSemaforo('DANIOS',$mes,$year);
    
    $ctCotizacionVerdeDanios=$semaforoDanios[0];
	$ctCotizacionAmarilloDanios=$semaforoDanios[1];
	$ctCotizacionRojoDanios=$semaforoDanios[2];

	$ctCancelacionVerdeDanios=$semaforoDanios[3];
	$ctCancelacionAmarilloDanios=$semaforoDanios[4];
	$ctCancelacionRojoDanios=$semaforoDanios[5];

	$ctEndosoVerdeDanios=$semaforoDanios[6];
	$ctEndosoAmarilloDanios=$semaforoDanios[7];
	$ctEndosoRojoDanios=$semaforoDanios[8];

	$ctEmisionVerdeDanios=$semaforoDanios[9];
	$ctEmisionAmarilloDanios=$semaforoDanios[10];
	$ctEmisionRojoDanios=$semaforoDanios[11];

	//Vida 
	$semaforoVida=$CI->cuadromando_model->getSemaforo('VIDA',$mes,$year);
    
    $ctCotizacionVerdeVida=$semaforoVida[0];
	$ctCotizacionAmarilloVida=$semaforoVida[1];
	$ctCotizacionRojoVida=$semaforoVida[2];

	$ctCancelacionVerdeVida=$semaforoVida[3];
	$ctCancelacionAmarilloVida=$semaforoVida[4];
	$ctCancelacionRojoVida=$semaforoVida[5];

	$ctEndosoVerdeVida=$semaforoVida[6];
	$ctEndosoAmarilloVida=$semaforoVida[7];
	$ctEndosoRojoVida=$semaforoVida[8];

	$ctEmisionVerdeVida=$semaforoVida[9];
	$ctEmisionAmarilloVida=$semaforoVida[10];
	$ctEmisionRojoVida=$semaforoVida[11];

	//Semaforo Renovaciones a renovadas
    $renovacion=$this->cuadromando_model->getRenovaciones();

    //Semaforo Renovaciones pendientes por renovar
    $mes=date('m');
    $renovacionPendientes=$this->cuadromando_model->getRenovacionesPendientes($mes);

$flotante_nuevo.="
<div class='card mb-2' style='margin-top: 5px'> 
	<div class='card-header text-center'>
		<a data-toggle='collapse' href='#muestra_avance_operativo' aria-expanded='true' aria-controls='muestra_avance_operativo'><i class='fa fa-cogs'></i>&nbsp;KPI Operativo<span class='caret'></span></a>	
	</div>
	<div class='card-body collapse visible muestra_avance_operativo' id='muestra_avance_operativo'>

		<a href='#' onclick='despliegue(0)'>
			<div id='actividadesAuto' class='actividades text-center' style='margin-top: 7px;'>
				<label for='polizaEfectuada' style='margin-top:3px;font-size:11px;'><i class='fa fa-car'></i>
				&nbsp;AUTOS</b> 
				</label>
			</div>
		</a>

		<!--div Autos-->
		<div id='divAutos' style='display: none;margin-top: 3px'>
			<table style='font-size: 11px;width: 100%;text-align: center;'>
				<tr>
					<td rowspan='2' style='width: 45%;'></td>
					<td colspan='3'><div class='actividadesAuto' style='font-size: 11px;padding: 2px;'>SEMAFORO</div></td>
				</tr>
				<tr style='text-align: center;background-color: #E2E2E2;'>
					<td><span class='badge badge-default' id='verde'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='amarillo'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='rojo'>&nbsp;</span></td>
				</tr>
				<tr>
					
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 1;border-radius: 4px;padding: 2px;'><i class='fa fa-check-circle'></i>&nbsp;Cotizaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='vehiculos-Cotizacion-verde'><b>".$ctCotizacionVerdeAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Cotizacion-amarillo'><b>".$ctCotizacionAmarilloAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Cotizacion-rojo'><b>".$ctCotizacionRojoAutos."</b></td>
				</tr>
				
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;'><i class='fa fa-times-circle'></i>&nbsp;Cancelaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='vehiculos-Cancelacion-verde'><b>".$ctCancelacionVerdeAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Cancelacion-amarillo'><b>".$ctCancelacionAmarilloAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Cancelacion-rojo'><b>".$ctCancelacionRojoAutos."</b></td>
				</tr>
				<tr>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;'><i class='fa fa-edit'></i>&nbsp;Endosos:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='vehiculos-Endoso-verde'><b>".$ctEndosoVerdeAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Endoso-amarillo'><b>".$ctEndosoAmarilloAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Endoso-rojo'><b>".$ctEndosoRojoAutos."</b></td>
				</tr>
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;'><i class='fa fa-send'></i>&nbsp;Emisiónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='vehiculos-Emision-verde'><b>".$ctEmisionVerdeAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Emision-amarillo'><b>".$ctEmisionAmarilloAutos."</b></td>
					<td style='text-align: center;' class='vehiculos-Emision-rojo'><b>".$ctEmisionRojoAutos."</b></td>
				</tr>
			</table>
				<!--div Promedio Autos-->
				<div style='margin-top: 11px; margin-left: 5px'>
				<table style='width: 100%;font-size:11px;'>
						<td style='width: 40%;text-align: right;'><i class='fa fa-clock-o'></i>&nbsp;&nbsp;</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Diario</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Semanal</td>
					</tr>
					<tr>
						<td><div style='background-color: #347ab7;color: #fff;font-weight: bold;opacity: 2;padding: 2px;border-radius: 4px;text-align: center;font-size: 11px'>Promedio</div></td>
						<td style='text-align: center;'><b>0</b></td>
						<td style='text-align: center;'><b>0</b></td>
					</tr>
				</table>
			</div>
		</div>";

	$flotante_nuevo.="
		<a href='#' onclick='despliegue(1)'>
			<div id='actividadesDanios' class='actividades text-center' style='margin-top: 7px;'>
				<label for='polizaEfectuada' style='margin-top:3px;font-size:11px;'><i class='fa fa-heartbeat'></i>
				&nbsp;DAÑOS</b> 
				</label>
			</div>
		</a>

		<!--div Daños-->
		<div id='divDanios' style='display: none;margin-top: 3px'>
			<table style='font-size: 11px;width: 100%;text-align: center;'>
				<tr>
					<td rowspan='2' style='width: 45%;'></td>
					<td colspan='3'><div class='actividadesDanios' style='font-size: 11px;padding: 2px;'>SEMAFORO</div></td>
				</tr>
				<tr style='text-align: center;background-color: #E2E2E2;'>
					<td><span class='badge badge-default' id='verde'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='amarillo'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='rojo'>&nbsp;</span></td>
				</tr>
				<tr>
					
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 1;border-radius: 4px;padding: 2px;'><i class='fa fa-check-circle'></i>&nbsp;Cotizaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='danos-Cotizacion-verde'><b>".$ctCotizacionVerdeDanios."</b></td>
					<td style='text-align: center;' class='danos-Cotizacion-amarillo'><b>".$ctCotizacionAmarilloDanios."</b></td>
					<td style='text-align: center;' class='danos-Cotizacion-rojo'><b>".$ctCotizacionRojoDanios."</b></td>
				</tr>
				
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;'><i class='fa fa-times-circle'></i>&nbsp;Cancelaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='danos-Cancelacion-verde'><b>".$ctCancelacionVerdeDanios."</b></td>
					<td style='text-align: center;' class='danos-Cancelacion-amarillo'><b>".$ctCancelacionAmarilloDanios."</b></td>
					<td style='text-align: center;' class='danos-Cancelacion-rojo'><b>".$ctCancelacionRojoDanios."</b></td>
				</tr>
				<tr>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;'><i class='fa fa-edit'></i>&nbsp;Endosos:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='danos-Endoso-verde'><b>".$ctEndosoVerdeDanios."</b></td>
					<td style='text-align: center;' class='danos-Endoso-amarillo'><b>".$ctEndosoAmarilloDanios."</b></td>
					<td style='text-align: center;' class='danos-Endoso-rojo'><b>".$ctEndosoRojoDanios."</b></td>
				</tr>
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;'><i class='fa fa-send'></i>&nbsp;Emisiónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='danos-Emision-verde'><b>".$ctEmisionVerdeDanios."</b></td>
					<td style='text-align: center;' class='danos-Emision-amarillo'><b>".$ctEmisionAmarilloDanios."</b></td>
					<td style='text-align: center;' class='danos-Emision-rojo'><b>".$ctEmisionRojoDanios."</b></td>
				</tr>
			</table>
			<!--div Promedio Daños-->
			<div style='margin-top: 11px; margin-left: 5px'>
				<table style='width: 100%;font-size:11px;'>
						<td style='width: 40%;text-align: right;'><i class='fa fa-clock-o'></i>&nbsp;&nbsp;</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Diario</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Semanal</td>
					</tr>
					<tr>
						<td><div style='background-color: #347ab7;color: #fff;font-weight: bold;opacity: 2;padding: 2px;border-radius: 4px;text-align: center;font-size: 11px'>Promedio</div></td>
						<td style='text-align: center;'><b>0</b></td>
						<td style='text-align: center;'><b>0</b></td>
					</tr>
				</table>
			</div>
		</div>";

	$flotante_nuevo.="
		<a href='#' onclick='despliegue(2)'>
			<div id='actividadesVida' class='actividades text-center' style='margin-top: 7px;'>
				<label for='polizaEfectuada' style='margin-top:3px;font-size:11px;'><i class='fa fa-user'></i>
				&nbsp;LINEAS PERSONALES</b> 
				</label>
			</div>
		</a>

		<!--div Vida-->
		<div id='divVida' style='display: none;margin-top: 3px'>
			<table style='font-size: 11px;width: 100%;text-align: center;'>
				<tr>
					<td rowspan='2' style='width: 45%;'></td>
					<td colspan='3'><div class='actividadesVida' style='font-size: 11px;padding: 2px;'>SEMAFORO</div></td>
				</tr>
				<tr style='text-align: center;background-color: #E2E2E2;'>
					<td><span class='badge badge-default' id='verde'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='amarillo'>&nbsp;</span></td>
					<td><span class='badge badge-default' id='rojo'>&nbsp;</span></td>
				</tr>
				<tr>
					
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 1;border-radius: 4px;padding: 2px;'><i class='fa fa-check-circle'></i>&nbsp;Cotizaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='lineas_personales-Cotizacion-verde'><b>".$ctCotizacionVerdeVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Cotizacion-amarillo'><b>".$ctCotizacionAmarilloVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Cotizacion-rojo'><b>".$ctCotizacionRojoVida."</b></td>
				</tr>
				
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;'><i class='fa fa-times-circle'></i>&nbsp;Cancelaciónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='lineas_personales-Cancelacion-verde'><b>".$ctCancelacionVerdeVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Cancelacion-amarillo'><b>".$ctCancelacionAmarilloVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Cancelacion-rojo'><b>".$ctCancelacionRojoVida."</b></td>
				</tr>
				<tr>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;'><i class='fa fa-edit'></i>&nbsp;Endosos:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='lineas_personales-Endoso-verde'><b>".$ctEndosoVerdeVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Endoso-amarillo'><b>".$ctEndosoAmarilloVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Endoso-rojo'><b>".$ctEndosoRojoVida."</b></td>
				</tr>
				<tr style='background-color: #F2F2F2;'>
					<td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;'><i class='fa fa-send'></i>&nbsp;Emisiónes:&nbsp;&nbsp;</div></td>
					<td style='text-align: center;' class='lineas_personales-Emision-verde'><b>".$ctEmisionVerdeVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Emision-amarillo'><b>".$ctEmisionAmarilloVida."</b></td>
					<td style='text-align: center;' class='lineas_personales-Emision-rojo'><b>".$ctEmisionRojoVida."</b></td>
				</tr>
			</table>
			<!--Div Promedio Vida-->
			<div style='margin-top: 11px; margin-left: 5px'>
				<table style='width: 100%;font-size:11px;'>
						<td style='width: 40%;text-align: right;'><i class='fa fa-clock-o'></i>&nbsp;&nbsp;</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Diario</td>
						<td style='background-color: #E2E2E2;text-align: center;'>Semanal</td>
					</tr>
					<tr>
						<td><div style='background-color: #347ab7;color: #fff;font-weight: bold;opacity: 2;padding: 2px;border-radius: 4px;text-align: center;font-size: 11px'>Promedio</div></td>
						<td style='text-align: center;'><b>0</b></td>
						<td style='text-align: center;'><b>0</b></td>
					</tr>
				</table>
			</div>
		</div>";

     //Totales de Polizas ya renovadas

    $totalAutos=$renovacion[0]+$renovacion[1]+$renovacion[2];
    $totalDanios=$renovacion[6]+$renovacion[7]+$renovacion[8];
    $totalVida=$renovacion[3]+$renovacion[4]+$renovacion[5];

    $totalVerde=$renovacion[0]+$renovacion[6]+$renovacion[3];
    $totalAmarillo=$renovacion[1]+$renovacion[7]+$renovacion[4];
    $totalRojo=$renovacion[2]+$renovacion[8]+$renovacion[5];

    $total=$totalVerde+$totalAmarillo+$totalRojo;

    //Totales de Polizas pendientes pos renovar
    $totalAutosPendientes=$renovacionPendientes[0]+$renovacionPendientes[1]+$renovacionPendientes[2];
    $totalDaniosPendientes=$renovacionPendientes[6]+$renovacionPendientes[7]+$renovacionPendientes[8];
    $totalVidaPendientes=$renovacionPendientes[3]+$renovacionPendientes[4]+$renovacionPendientes[5] + $renovacionPendientes[9] + $renovacionPendientes[10] + $renovacionPendientes[11];

    $totalVerdePendientes=$renovacionPendientes[0]+$renovacionPendientes[6]+$renovacionPendientes[3] + $renovacionPendientes[9];
    $totalAmarilloPendientes=$renovacionPendientes[1]+$renovacionPendientes[7]+$renovacionPendientes[4] + $renovacionPendientes[10];
    $totalRojoPendientes=$renovacionPendientes[2]+$renovacionPendientes[8]+$renovacionPendientes[5] + $renovacionPendientes[11];

    $totalPendientes=$totalVerdePendientes+$totalAmarilloPendientes+$totalRojoPendientes;
     
	$flotante_nuevo.="
		<a href='#' onclick='despliegue(3)'>
			<div id='actividadesVida' class='actividades text-center' style='margin-top: 7px;'>
				<label for='polizaEfectuada' style='margin-top:3px;font-size:11px;'><i class='fa fa-refresh'></i>
				&nbsp;RENOVACIÓNES</b> 
				</label>
			</div>
		</a>
		<!--div Renovaciones-->
		<div id='divRenovaciones' style='display: none;margin-top: 3px'>
			<!--tabla Renovaciones de polizas renovadas-->
            <table style='font-size: 11px;width: 100%;text-align: center;'>
                
                <tr>
                    <td rowspan='2' style='width: 45%;'>
                    <span style='font-size:10px;'><i class='fa fa-check-circle'></i> Polizas Renovadas</span>
                    </td>
                    <td colspan='3'><div class='actividadesRenovacion' style='font-size: 10px;padding: 2px;'>SEMAFORO</div></td>
                </tr>
                <tr style='text-align: center;background-color: #E2E2E2;'>
                    <td><span class='badge badge-default' id='verde'>+20</span></td>
                    <td><span class='badge badge-default' id='amarillo'>+1</span></td>
                    <td><span class='badge badge-default' id='rojo'>-1</span></td>
                    <td style='text-align: right;'><b>Totales</b>&nbsp;</td>
                </tr>
                <tr>
                    
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-car'></i>&nbsp;AUTOS:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-vehiculos-green-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-vehiculos-yellow-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-vehiculos-red-yr'><b>0</b></td>
                    <td class='renovada-vehiculos-total'>0</td>
                </tr>
                
                <tr style='background-color: #F2F2F2;'>
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-heartbeat'></i>&nbsp;DAÑOS:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-danios-green-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-danios-yellow-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-danios-red-yr'><b>0</b></td>
                    <td class='renovada-danios-total'>0</td>
                </tr>
                <tr>
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-user'></i>&nbsp;LINEAS PERSONALES:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-green-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-yellow-yr'><b>0</b></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-red-yr'><b>0</b></td>
                    <td class='renovada-lineas-personales-total'>0</td>
                </tr>
                <tr>
                    <td style='text-align: right;'><b>Totales:</b>&nbsp;</td>
                    <td><span class='badge badge-default total-renovada-green' id='verde' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                    <td><span class='badge badge-default total-renovada-yellow' id='amarillo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                    <td><span class='badge badge-default total-renovada-red' id='rojo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                    <td style='text-align: center;background-color: #E2E2E2;' class='total-renovada'><b>0</b>&nbsp;</td>
                </tr>
            </table><br>
            <div class='dropdown-divider'></div>
            <!--fin renovaciones ya renovadas-->
            <!--Tabla Renovaciones de polizas pendientes por renovar-->
            
                <table style='font-size: 11px;width: 100%;text-align: center;'>
                    
                    <tr>
                        <td rowspan='2' style='width: 45%;'>
                        <span style='font-size:10px;'><i class='fa fa-clock-o'></i> Polizas Pendientes por Renovar</span>
                        </td>
                        <td colspan='3'><div class='actividadesRenovacion' style='font-size: 10px;padding: 2px;'>SEMAFORO</div></td>
                    </tr>
                    <tr style='text-align: center;background-color: #E2E2E2;'>
                        <td><span class='badge badge-default' id='verde'>+20</span></td>
                        <td><span class='badge badge-default' id='amarillo'>+1</span></td>
                        <td><span class='badge badge-default' id='rojo'>-1</span></td>
                        <td style='text-align: right;'><b>Totales</b>&nbsp;</td>
                    </tr>
                    <tr>
                        
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-car'></i>&nbsp;AUTOS:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-green-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-yellow-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-red-yr'><b>0</b></td>
                        <td class='pendiente-vehiculos-total'>0</td>
                    </tr>
                    
                    <tr style='background-color: #F2F2F2;'>
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-heartbeat'></i>&nbsp;DAÑOS:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-danios-green-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-danios-yellow-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-danios-red-yr'><b>0</b></td>
                        <td class='pendiente-danios-total'>0</td>
                    </tr>
                    <tr>
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-user'></i>&nbsp;LINEAS PERSONALES:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-green-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-yellow-yr'><b>0</b></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-red-yr'><b>0</b></td>
                        <td class='pendiente-lineas-personales-total'>0</td>
                    </tr>
                    <tr>
                        <td style='text-align: right;'><b>Totales:</b>&nbsp;</td>
                        <td><span class='badge badge-default total-pendiente-green' id='verde' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                        <td><span class='badge badge-default total-pendiente-yellow' id='amarillo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                        <td><span class='badge badge-default total-pendiente-red' id='rojo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'>0</span></td>
                        <td style='text-align: center;background-color: #E2E2E2;' class='total-pendiente'><b>0</b>&nbsp;</td>
                    </tr>
                </table>
		</div>
        <!--fin renovaciones pendientes por revovar-->
		<!--fin renovaciones-->
        ";

$flotante_nuevo.="</div></div> <!--aquixd-->";
//Fin de ajuste desactivar visualmente el kpi operativo de renovaciones
//Fin Miguel [16-03-2021]
?>
<script type="text/javascript">
	var ctx=0;
	function despliegue(op){
		switch(op){
			case 0:
				if(ctx==0){
					document.getElementById('divAutos').style.display='block';
					document.getElementById('divDanios').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=1;
				}else{
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=0
				}
			break;
			case 1:
				if(ctx==0){
					document.getElementById('divDanios').style.display='block';
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=1;
				}else{
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=0
				}
			break;
			case 2:
				if(ctx==0){
					document.getElementById('divVida').style.display='block';
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					ctx=1;
				}else{
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=0
				}
			break;
			case 3:
				if(ctx==0){
					document.getElementById('divRenovaciones').style.display='block';
					document.getElementById('divVida').style.display='none';
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					ctx=1;
				}else{
					document.getElementById('divRenovaciones').style.display='none';
					document.getElementById('divAutos').style.display='none';
					document.getElementById('divDanios').style.display='none';
					document.getElementById('divVida').style.display='none';
					ctx=0
				}
			break;

		}
	}
</script>
