<!--Miguel 8/03/2021-->
<!--Div de Ejecutivos Operativos-->
<style type="text/css">
         #divEjecutivosOperativos{
            position:fixed;
            left: 0%;
            width:280px;
            height: auto;
            border-radius: 8px;
            background-color:#fff;
            top: 15%;
            z-index: 3000;
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
$label = "noavailable";
if(($user=='AUTOS@ASESORESCAPITAL.COM')||($user=='BIENES@ASESORESCAPITAL.COM')||($user=='LINEASPERSONALES@ASESORESCAPITAL.COM') || ($user=='AUTOSRENOVACIONES@ASESORESCAPITAL.COM') || ($user=='EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM')){

switch ($user) {
    case 'AUTOS@ASESORESCAPITAL.COM': //|| 'AUTOSRENOVACIONES@ASESORESCAPITAL.COM' || 'EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM':
        $ramo='AUTOS';
        $ramo_name='Autos';
        $Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("AUTOS");
        $label = "vehiculos";
        break;
    
    case 'AUTOSRENOVACIONES@ASESORESCAPITAL.COM': //|| 'AUTOSRENOVACIONES@ASESORESCAPITAL.COM' || 'EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM':
        $ramo='AUTOS';
        $ramo_name='Autos';
        $Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("AUTOS");
        $label = "vehiculos";
        break;

    case 'EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM': //|| 'AUTOSRENOVACIONES@ASESORESCAPITAL.COM' || 'EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM':
        $ramo='AUTOS';
        $ramo_name='Autos';
        $Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("AUTOS");
        $label = "vehiculos";
        break;

    case 'BIENES@ASESORESCAPITAL.COM':
        $ramo='DANIOS';
        $ramo_name='Daños';
        $Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("DANIOS");
        $label = "danos";
        break;
    case 'LINEASPERSONALES@ASESORESCAPITAL.COM':
        $ramo='VIDA';
        $ramo_name='Lineas Personales';
        $Pdiario=$ci->cuadromando_model->promedio_atencion_actividades("VIDA");
        $label = "lineas_personales";
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

//Semaforo Renovaciones a renovadas
$renovacion=$this->cuadromando_model->getRenovaciones();

//Semaforo Renovaciones pendientes por renovar
    $mes=date('m');
$renovacionPendientes=$this->cuadromando_model->getRenovacionesPendientes($mes);

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
$totalVidaPendientes=$renovacionPendientes[3]+$renovacionPendientes[4]+$renovacionPendientes[5];

$totalVerdePendientes=$renovacionPendientes[0]+$renovacionPendientes[6]+$renovacionPendientes[3];
$totalAmarilloPendientes=$renovacionPendientes[1]+$renovacionPendientes[7]+$renovacionPendientes[4];
$totalRojoPendientes=$renovacionPendientes[2]+$renovacionPendientes[8]+$renovacionPendientes[5];

$totalPendientes=$totalVerdePendientes+$totalAmarilloPendientes+$totalRojoPendientes;

    //------------------- //Dennis Castillo [2022-01-19]
    $autosPermit = array("AUTOS@ASESORESCAPITAL.COM", "AUTOSRENOVACIONES@ASESORESCAPITAL.COM", "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM");
    $danosPermit = array("BIENES@ASESORESCAPITAL.COM");
    $lineasPersonalesPermit = array("LINEASPERSONALES@ASESORESCAPITAL.COM");
    $allUsers = array_merge($autosPermit, $danosPermit, $lineasPersonalesPermit);
    //var_dump($allUsers);
    //------------------- //Dennis Castillo [2022-07-07]
    //-------------------
?>
<div  id="divEjecutivosOperativos" class="muestra_avance_operativo">
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
                    <td><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 2;padding: 2px;border-radius: 4px;text-align: center;font-size: 11px">Promedio</div></td>
                    <td style="text-align: center;"><b><?php echo $ci->cuadromando_model->promedio_atencion_actividades($ramo)[0];?></b></td>
                    <td style="text-align: center;"><b><?php echo $ci->cuadromando_model->promedio_atencion_actividades($ramo)[1];?></b></td>
                </tr>
            </table>
        </div>
        <br>
        <table style="font-size: 11px;width: 100%;text-align: center;">
            <tr>
                <td rowspan="2" style="width: 45%;"></td>
                <td colspan="3"><div class='actividades' style='padding: 2px;'>SEMAFORO</div></td>
            </tr>
            <tr style="text-align: center;background-color: #E2E2E2;">
                <td><span class="badge badge-default" id="verde">&nbsp;</span></td>
                <td><span class="badge badge-default" id="amarillo">&nbsp;</span></td>
                <td><span class="badge badge-default" id="rojo">&nbsp;</span></td>
            </tr>
            <tr>
                
                <td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 1;border-radius: 4px;padding: 2px;"><i class="fa fa-check-circle"></i>&nbsp;Cotizaciónes:&nbsp;&nbsp;</div></td>
                <td style="text-align: center;"  class='<?=$label?>-Cotizacion-verde'><b>0</b></td>
                <td style="text-align: center;"  class='<?=$label?>-Cotizacion-amarillo'><b>0</b></td>
                <td style="text-align: center;"  class='<?=$label?>-Cotizacion-rojo'><b>0</b></td>
            </tr>
            
            <tr style="background-color: #F2F2F2;">
                <td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.9;border-radius: 4px;padding: 2px;"><i class="fa fa-times-circle"></i>&nbsp;Cancelaciónes:&nbsp;&nbsp;</div></td>
                <td style="text-align: center;" class='<?=$label?>-Cancelacion-verde'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Cancelacion-amarillo'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Cancelacion-rojo'><b>0</td>
            </tr>
            <tr>
                <td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.8;border-radius: 4px;padding: 2px;"><i class="fa fa-edit"></i>&nbsp;Endosos:&nbsp;&nbsp;</div></td>
                <td style="text-align: center;" class='<?=$label?>-Endoso-verde'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Endoso-amarillo'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Endoso-rojo'><b>0</b></td>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td style="text-align: right;"><div style="background-color: #347ab7;color: #fff;font-weight: bold;opacity: 0.7;border-radius: 4px;padding: 2px;"><i class="fa fa-send"></i>&nbsp;Emisiónes:&nbsp;&nbsp;</div></td>
                <td style="text-align: center;" class='<?=$label?>-Emision-verde'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Emision-amarillo'><b>0</b></td>
                <td style="text-align: center;" class='<?=$label?>-Emision-rojo'><b>0</b></td>
            </tr>
            
        </table>
        
        <div class='actividades text-center' style='margin-top: 10px;'>
        <label for='polizaEfectuada' style='margin-top:5px;'><i class='fa fa-cogs' aria-hidden='true'></i>
        &nbsp;Renovaciones&nbsp;<b><?php echo $ramo_name?></b> <?php echo $meses[date("n")].", ".date("Y");?>
        </label>
        </div>
        <div id='muestra_avance_operativo'>
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
                 <?php if(in_array($user, $autosPermit)){ //Dennis Castillo [2022-01-19]?>
                <tr>
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-car'></i>&nbsp;AUTOS:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-vehiculos-green-yr'><b><?php echo $renovacion[0];?></b></td>
                    <td style='text-align: center;' class='renovada-vehiculos-yellow-yr'><b><?php echo $renovacion[1];?></b></td>
                    <td style='text-align: center;' class='renovada-vehiculos-red-yr'><b><?php echo $renovacion[2];?></b></td>
                    <td class='renovada-vehiculos-total'><?php echo $totalAutos;?></td>
                </tr>
              <?php }?>
              <?php if(in_array($user, $danosPermit)){ //Dennis Castillo [2022-01-19]?>
                <tr style='background-color: #F2F2F2;'>
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-heartbeat'></i>&nbsp;DAÑOS:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-danios-green-yr'><b><?php echo $renovacion[6];?></b></td>
                    <td style='text-align: center;' class='renovada-danios-yellow-yr'><b><?php echo $renovacion[7];?></b></td>
                    <td style='text-align: center;' class='renovada-danios-red-yr'><b><?php echo $renovacion[8];?></b></td>
                    <td class='renovada-danios-total'><?php echo $totalDanios;?></td>
                </tr>
                <?php }?>
                 <?php if(in_array($user, $lineasPersonalesPermit)){ //Dennis Castillo [2022-01-19]?>
                <tr>
                    <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-user'></i>&nbsp;LINEAS PERSONALES:&nbsp;&nbsp;</div></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-green-yr'><b><?php echo $renovacion[3];?></b></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-yellow-yr'><b><?php echo $renovacion[4];?></b></td>
                    <td style='text-align: center;' class='renovada-lineas-personales-red-yr'><b><?php echo $renovacion[5];?></b></td>
                    <td class='renovada-lineas-personales-total'><?php echo $totalVida;?></td>
                </tr>
                <?php }?>
                 <?php if(!in_array($user, $allUsers)){ //Dennis Castillo [2022-01-19]?>
                <tr>
                    <td style='text-align: right;'><b>Totales:</b>&nbsp;</td>
                    <td><span class='badge badge-default total-renovada-green' id='verde' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo $totalVerde?></span></td>
                    <td><span class='badge badge-default total-renovada-yellow' id='amarillo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo $totalAmarillo?></span></td>
                    <td><span class='badge badge-default total-renovada-red' id='rojo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo $totalRojo?></span></td>
                    <td style='text-align: center;background-color: #E2E2E2;' class='total-renovada'><b><?php echo  $total?></b>&nbsp;</td>
                </tr>
            <?php }?>
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
                    <?php if(in_array($user, $autosPermit)){ //Dennis Castillo [2022-01-19]?>
                    <tr>
                        
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.9;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-car'></i>&nbsp;AUTOS:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-green-yr'><b><?php echo $renovacionPendientes[0]?></b></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-yellow-yr'><b><?php echo $renovacionPendientes[1]?></b></td>
                        <td style='text-align: center;' class='pendiente-vehiculos-red-yr'><b><?php echo $renovacionPendientes[2]?></b></td>
                        <td class='pendiente-vehiculos-total'>0</td>
                    </tr>
                  <?php }?>
                  <?php if(in_array($user, $danosPermit)){ //Dennis Castillo [2022-01-19]?>
                    <tr style='background-color: #F2F2F2;'>
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.8;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-heartbeat'></i>&nbsp;DAÑOS:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-danios-green-yr'><b><?php echo $renovacionPendientes[6]?></b></td>
                        <td style='text-align: center;' class='pendiente-danios-yellow-yr'><b><?php echo $renovacionPendientes[7]?></b></td>
                        <td style='text-align: center;' class='pendiente-danios-red-yr'><b><?php echo $renovacionPendientes[8]?></b></td>
                        <td class='pendiente-danios-total'>0</td>
                    </tr>
                <?php }?>
                <?php if(in_array($user, $lineasPersonalesPermit)){ //Dennis Castillo [2022-01-19]?>
                    <tr>
                        <td style='text-align: right;'><div style='background-color: #347ab7;color: #fff;opacity: 0.7;border-radius: 4px;padding: 2px;font-size: 10px;'><i class='fa fa-user'></i>&nbsp;LINEAS PERSONALES:&nbsp;&nbsp;</div></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-green-yr'><b><?php echo $renovacionPendientes[3]?></b></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-yellow-yr'><b><?php echo $renovacionPendientes[4]?></b></td>
                        <td style='text-align: center;' class='pendiente-lineas-personales-red-yr'><b><?php echo $renovacionPendientes[5]?></b></td>
                        <td class='pendiente-lineas-personales-total'>0</td>
                    </tr>
                  <?php }?>
                   <?php if(!in_array($user, $allUsers)){ //Dennis Castillo [2022-01-19]?>
                    <tr>
                        <td style='text-align: right;'><b>Totales:</b>&nbsp;</td>
                        <td><span class='badge badge-default total-pendiente-green' id='verde' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo$totalVerdePendientes?></span></td>
                        <td><span class='badge badge-default total-pendiente-yellow' id='amarillo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo $totalAmarilloPendientes?></span></td>
                        <td><span class='badge badge-default total-pendiente-red' id='rojo' style='font-weight: normal;border-radius: 0px;width: 100%;font-weight: bold;color: #000;opacity: 0.9;'><?php echo $totalRojoPendientes?></span></td>
                        <td style='text-align: center;background-color: #E2E2E2;' class='total-pendiente'><b><?php echo $totalPendientes?></b>&nbsp;</td>
                    </tr>
                <?php } ?>
                </table>
        </div>
        <br>
        <div style="padding-top: 0;text-align: right;">
            <span style="font-size: 10px;color: #8370a1;text-shadow: 1px 1px 2px silver;"><i class="fa fa-user"></i>&nbsp;<?php echo $user;?>&nbsp;&nbsp;</span>
        </div>
        <br>
    </div>
</div>
<?php }?>
