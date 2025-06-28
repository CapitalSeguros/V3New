<?php
    $this->load->view('headers/header');
    $this->load->view('headers/menu');
   $usermail=$this->tank_auth->get_usermail();
   $ctCapacitacion=0;
function mesLetra($mes){
    switch ($mes) {
        case 1:return 'ENERO';break;
        case 2:return 'FEBRERO';break;
        case 3:return 'MARZO';break;
        case 4:return 'ABRIL';break;
        case 5:return 'MAYO';break;
        case 6:return 'JUNIO';break;
        case 7:return 'JULIO';break;
        case 8:return 'AGOSTO';break;
        case 9:return 'SEPTIEMBRE';break;
        case 10:return 'OCTUBRE';break;
        case 11:return 'NOVIEMBRE';break;
        case 12:return 'DICIEMBRE';break;
    }
}

//***Funcion Determinar Fecha Final del mes actual
function fechaFinal($mes){
    $month=date('m');
    $year=date('Y');
    switch ($mes) {
        case 1:return $year.'-'.$month.'-'.'31';break;
        case 2:return $year.'-'.$month.'-'.'28';break;
        case 3:return $year.'-'.$month.'-'.'31';break;
        case 4:return $year.'-'.$month.'-'.'30';break;
        case 5:return $year.'-'.$month.'-'.'31';break;
        case 6:return $year.'-'.$month.'-'.'30';break;
        case 7:return $year.'-'.$month.'-'.'31';break;
        case 8:return $year.'-'.$month.'-'.'31';break;
        case 9:return $year.'-'.$month.'-'.'30';break;
        case 10:return $year.'-'.$month.'-'.'31';break;
        case 11:return $year.'-'.$month.'-'.'30';break;
        case 12:return $year.'-'.$month.'-'.'31';break;
    }
}

//***Funcion Determinar Dias Feriados por Mes***

function diasferiadosMex($mes){
    $year=date('Y');
    switch ($mes) {
        case 1:return [$year."-01-01"];break;
        case 2:return [$year."-02-01"];break;
        case 3:return [$year."-03-15"];break;
        case 5:return [$year."-05-01"];break;
        case 9:return [$year."-09-16"];break;
        case 11:return [$year."-11-15"];break;
        case 12:return [$year."-12-25"];break;
        default:return [$year.""];break;
    }
}

//***Funcion Determinar de Dias Habiles***
function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
        $diainc = 24*60*60;
        $diashabiles = array();
       for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            if (!in_array(date('N', $midia), array(6,7))) {
                if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
                }
            }
        }
    return $diashabiles;
}

   

    $CE=$cobranza[0]->cobranza_efectuada;
    $CP=$cobranza[0]->cobranza_pendiente;
    $CA=$cobranza[0]->cobranza_atrasada;
    
    //*** Promedio de Cobro
    $ZP=$CP+$CA;
    $ctDH=0;
    $fechI=date('Y-m-d');
    $fechF=fechaFinal(date('m'));
    $diasHabiles=array();
    $diasHabiles=getDiasHabiles($fechI, $fechF, diasferiadosMex(date('m')));
    foreach ($diasHabiles as $diasH) {
        $ctDH++;
    }
    $PromCobro=$ZP/$ctDH;
    
   //Modificacion 12-05*****//
   $i=0;
   foreach ($presupuesto as $rowPresupuesto) {
       $lbSucursal[$i]=$rowPresupuesto->Sucursal;
       $lbComision[$i]=$rowPresupuesto->comision;
       $i++;
   }


?>
<style type="text/css">
#loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('../assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
    opacity: .8;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<body>

<input type="hidden" name="usermail" id="usermail" value="<?php echo $usermail?>">
<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
<div class="container" style="background-color: #fff;padding: 2%;">
<div id="loader" style="display: block;"></div>
    <div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10">
        <h3 class="titulo-secciones">
            <i class="glyphicon glyphicon-equalizer"></i> Cuadro de Mando
        </h3>
      </div>
    </div>
    <div class="row">
        
<?php if($usermail!="GERENTEOPERATIVO@AGENTECAPITAL.COM"){
        if($usermail!="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){
            if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){?>
        <div class="col-md-6 col-lg-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-user"></i> Prospección
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChart"></canvas>
                      </div>
                </div><br><br><br><br><br><br>
                <div>
                    <a href="<?php echo base_url()?>crmproyecto/detalle_reporte_prospectos"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
                </div>
            </div>

        </div>
<?php }
    }
  }

if($usermail!="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){?>
        <div class="col-md-6 col-lg-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Cobranza
                    </div>
                    <div>
                       <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                            <canvas id="myChartCobranza"></canvas>
                        </div>
                        <div class="alert alert-info">
                            <h5 style="color: #848484">META DE COBRO <?php echo mesLetra(date('m')).", ".date('Y');?></h5>
                            <i class="fa fa-calendar"></i>
                            Dias Habiles  : <b><?php echo $ctDH;?></b><br>
                            <i class="fa fa-hand-o-right"></i> Promedio Sugerido de Cobro: <b><?php echo number_format($PromCobro)."</b> recibos diarios";?>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="<?php echo base_url()?>reportes/detalle_cobranza"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
                </div>
            </div>
        </div>
<?php }?>

    </div>

    <!--------------------------->
    <!--Dennis [2021-09-07]------>
    <!--<div>
        <div class="row">
        </div>
    </div>-->
    <!--------------------------->

    <div id="metaComercial">
        <div class="row">
        <?php if(!in_array($usermail, array("GERENTEOPERATIVO@AGENTECAPITAL.COM", "COORDINADOROPERATIVO@ASESORESCAPITAL.COM", "COBRANZA@ASESORESCAPITAL.COM"))){?> 
            <div class="col-md-6">
                <div class="well">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fa fa-flag" aria-hidden="true"></i> Meta comercial</div>
                        <div class="panel-body">
                            <div class="row body-goal"></div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="<?=base_url()."metacomercial/manageAllGoalsData"?>" role="button" class="btn btn-primary btn-sm"><i class="fa fa-bars"></i>&nbspVer detalle</a>
                    </div>
                </div>
            </div>
            <?php }?>
<?php //if($usermail!="GERENTEOPERATIVO@AGENTECAPITAL.COM"){
        //if($usermail!="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){
             //if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){?>
            <!--<div class="col-md-6 col-lg-6">
                
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Metas Comerciales <br>
                            <table width="100%">
                                <tr>
                                    <td>Coordinadores:</td>
                                    <td width="75%">
                                        <select id="coordinador" name="coordinador" class="form-control" style="font-size: 11px">
                                        <option value="null">Seleccione uno</option>
                                        <?php
                                        foreach($todosCoordinadores as $coordinador){
                                            foreach($coordinadores as $coor){
                                                if($coor->idPersona==$coordinador->idPersona){?>
                                                    <option value="<?php echo $coordinador->idPersona;?>">
                                                       <?php echo $coordinador->nombres." ".$coordinador->apellidoPaterno." ".$coordinador->apellidoMaterno." (".$coordinador->email.")";?>
                                                    </option>
                                            <?php }
                                            }
                                        }?>
                                    </select>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <button class="btn btn-default btn-md" onclick="getMetasComercial()">Aceptar</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>

                           <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                <canvas id="myChartMetas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->

<?php //}
 //}
//}

if($usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){
    if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){?>
            <div class="col-md-6 col-lg-6">
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Actividades <br>
                        </div>
                        <div>
                           <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                <canvas id="myChartActividades"></canvas>
                            </div>
                        </div>
                    </div>
                     <div class="alert alert-info">
                        <table width="80%" style="font-size: 12px;">
                            <tr>
                                <td><i class="fa fa-car"></i>
                                &nbsp;&nbsp;<b>AUTOS</b> (<?php echo $nameAuto?>) :</td>
                                <td style="text-align: right;"><b><?php echo $auto;?></b></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-heartbeat"></i>
                                &nbsp;&nbsp;<b>DAÑOS</b> (<?php echo $nameDanio?>) : <b></td>
                                <td style="text-align: right;"><b><?php echo $danio;?></b></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-user"></i>
                                &nbsp;&nbsp;<b>LINEAS PERSONALES</b> (<?php echo $nameVida?>) :</td>
                                <td style="text-align: right;"><b><?php echo $vida;?></b></td>
                            </tr>
                            <tr>
                                <td colspan="2"><br><hr style="border-width: 2px;color: #fff;"></td>
                            </tr>
                            <tr>
                                <td><b>Total Actividades:</b></td>
                                <td style="text-align: right;"><b><?php echo $auto+$danio+$vida;?></b></td>
                            </tr>
                            <tr>
                                <td><b>Total Actividades en General:</b></td>
                                <td style="text-align: right;"><b><?php echo $todasActividades;?></b></td>
                            </tr>
                            <tr style="color: red"><td><b>Actividades en Rojo</b></td>
                              <td style="text-align: right;"><?=count($semaforo['semaforoActividades']);?></td>
                            </tr>
                            
                                <?=imprimirCompaniasConSemaros($semaforo['promotoriasConSemaforos']);?>
                                <?=imprimirInfoEmisiones($infoEmisiones);?>
                            
                        </table>
                     </div>
                     <div>
                        <a href="<?php echo base_url()?>reportes/detalle_reporte_actividades"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
                    </div>
                </div>
            </div>
        <?php }
    }?>
        </div>
    </div>

    <!--Modificacion MJ 12-05-2021-->
        
    <div class="row">
            <?php if($usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){
                    if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){?>
                <div class="col-md-6 col-lg-6">
                    <div class="well">
                         <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="glyphicon glyphicon-repeat"></i> Renovaciones  <?php echo mesLetra(date('m')).", ".date('Y');?><br>
                            </div>
                            <div>
                               <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                    <canvas id="myChartRenovaciones"></canvas>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="<?php echo base_url()?>reportes/detalle_reporte_renovaciones"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
                        </div>
                        <div class="well" style="text-align: center;">
                            <i class="fa fa-tag"></i>  Avance KPI de renovaciones por ejecutivo
                        </div>
                    </div>
                </div>
            <?php }
            }?>

                <?php if($usermail!="GERENTEOPERATIVO@AGENTECAPITAL.COM"){
                        if($usermail!="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){
                             if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){
                                if($usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){?>
                            <div class="col-md-6 col-lg-6">
                               <div class="well">
                                     <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <i class="fa fa-money"></i> Presupuesto  <?php echo mesLetra(date('m')).", ".date('Y');?><br>
                                        </div>
                                        <div>
                                           <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                               <canvas id="myChartPresupuesto"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="<?php echo base_url()?>reportes/detalle_reporte_presupuesto"><button class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</button></a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                         }
                    }
                }?>
                </div><!--fin de row-->



                
            

          <div class="row">
        
<?php if($usermail!="GERENTEOPERATIVO@AGENTECAPITAL.COM"){
        if($usermail!="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){
            if($usermail!="COBRANZA@ASESORESCAPITAL.COM"){?>
        <div class="col-md-6 col-lg-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Fast File <?php echo mesLetra(date('m')).", ".date('Y');?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartFastFile"></canvas>
                     </div>
                </div>
                <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">VALOR</td>
                             </tr>
                         </thead>
                         <tbody>
                          
                             <tr>
                                 <td>&nbsp;Prestamos</td>
                                 <td style="text-align: center;"><?php echo $prestamos[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Vacaciones</td>
                                 <td style="text-align: center;"><?php echo $vacaciones[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Permisos</td>
                                 <td style="text-align: center;"><?php echo $permisos[0]->TOTAL;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Incapacidad</td>
                                 <td style="text-align: center;"><?php echo $incapacidad[0]->TOTAL;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Cambio Puesto</td>
                                 <td style="text-align: center;"><?php echo $cambio_puesto[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Ajuste Sueldo</td>
                                 <td style="text-align: center;"><?php echo $sueldo[0]->TOTAL;?></td>
                                
                             </tr>
                              <tr>
                                 <td>&nbsp;Calificación</td>
                                <td style="text-align: center;"><?php echo $calificacion[0]->TOTAL;?></td>
                             </tr>
                              
                         </tbody>
                     </table>
                     </div>
                    <a href="<?php echo base_url()?>reportes/detalle_reporte_fastfile"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
                </div>
            </div>


            <!--Puntualidad Modificacion MJ-->
            <div class="col-md-6 col-lg-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Puntualidad <?php echo mesLetra(date('m')).", ".date('Y');?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartPuntualidad"></canvas>
                     </div>
                </div>
                <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">VALOR</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;Asistencia</td>
                                 <td style="text-align: center;"><?php echo $asistencia[0]->TOTAL;?></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;Puntualidad</td>
                                 <td style="text-align: center;"><?php echo $puntualidad[0]->TOTAL;?></td>
                             </tr>
                             
                             
                         </tbody>
                     </table>
                     </div>
                 <a href=""><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
            </div>
            </div>
            <!--Fin Puntualidad-->

        </div>
<?php }
    }
  }
  ?>

  <!-------------------------->
  <!-- Dennis Castillo [2022-01-12] -->
  <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading"> Capacita</div>
                    <div class="panel-body">
                        <div class="capacita-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>reportes/reporteCapacita" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">Módulo de calidad (incidencias)</div>
                    <div class="panel-body">
                        <div class="incidencias-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>procesamientoNC?showGraph=1" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading"> Siniestros</div>
                    <div class="panel-body">
                        <div class="siniestros-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>tableros_siniestros" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">Control de presupuesto</div>
                    <div class="panel-body">
                        <div class="control-presupuesto-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>presupuestos/controlPresupuesto" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading"> Marketing</div>
                    <div class="panel-body">
                        <div class="marketing-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>estadisticas_marketing/init" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">Control de ventas</div>
                    <div class="panel-body">
                        <div class="ventas-container"></div>
                    </div>
                </div>
                <div><a href="<?=base_url()?>crmproyecto/proyecto100?showGraph=1" class="btn btn-primary btn-sm"><i class="fa fa-list"></i> Ver Detalles</a></div>
            </div>
        </div>
    </div>


<!--Modificacion MJ-->
<div class="row">
     <div class="col-md-6 col-lg-6">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Indice Rotación por Area - <?php echo mesLetra(date('m')).", ".date('Y');?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartRotacion"></canvas>
                     </div>
                </div>

                <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">Activos</td>
                                 <td style="text-align: center;">Bajas</td>
                                 <td style="text-align: center;">% Rotación</td>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>&nbsp;Comercial</td>
                                 <td style="text-align: center;"><?php echo $activosComercial;?></td>
                                 <td style="text-align: center;"><?php echo $bajasComercial;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionComercial;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo</td>
                                 <td style="text-align: center;"><?php echo $activosOperativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasOperativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionOperativo;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Administrativo</td>
                                 <td style="text-align: center;"><?php echo $activosAdministrativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasAdministrativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionAdministrativo;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Gerencial</td>
                                 <td style="text-align: center;"><?php echo $activosGerencial;?></td>
                                <td style="text-align: center;"><?php echo $bajasGerencial;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionGerencial;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo Coorportivo</td>
                                 <td style="text-align: center;"><?php echo $activosCorporativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasCorporativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionCorporativo;?></td>
                                
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo Fianzas</td>
                                <td style="text-align: center;"><?php echo $activosFianzas;?></td>
                                <td style="text-align: center;"><?php echo $bajasFianzas;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionFianzas;?></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                 <a href="<?php echo base_url()?>reportes/detalle_reporte_rotacion"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
            </div>
            </div>
</div>
<!--Fin Modificacion-->



  <!-------------------------->

</div><!--FIN CONTAINER-->
</body>
<?php

$ctSuspectos=0;
$ctPerfilados=0;
$ctContactado=0;
$ctCotizado=0;
$ctCotizadoEmitido=0;
$ctPagado=0;

// *** suspectos
foreach ($suspectos as $sus) {
    $ctSuspectos++;
}
//*** Perfilados
foreach ($perfilados as $per) {
    $ctPerfilados++;
}
//*** Contactado
foreach ($contactado as $con) {
    $ctContactado++;
}
//*** Cotizado
foreach ($cotizado as $cot) {
    $ctCotizado++;
}
//*** Cotizado Emitido
foreach ($cotizado_emitido as $cot_emit) {
     $ctCotizadoEmitido++;
}

//*** Pagado
foreach ($pagado as $pag) {
    $ctPagado++;
}



?>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="<?=base_url()."assets/js/js_manageGoals.js"?>"></script>
<script src="<?=base_url()."assets/js/jquery.graficasdecuadrodemando.js"?>"></script>

<script type="text/javascript">
var usermail=document.getElementById('usermail').value;

if(usermail!='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
  if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){
    if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Sin Venta', 'Pefilados', 'Contactados', 'Cotizados','Emitidos','Cerrados'],
        datasets: [{
            label: 'PROSPECTOS DE NEGOCIOS: <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $ctSuspectos;?>,<?php echo $ctPerfilados;?>,<?php echo $ctContactado;?>,<?php echo $ctCotizado;?>,<?php echo $ctCotizadoEmitido;?>,<?php echo $ctPagado;?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(155, 231, 23, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(155, 231, 23, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

}
}
}


if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){
//Grafico cobranza
var ctx = document.getElementById('myChartCobranza').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efectuada', 'Pendiente', 'Atrasada'],
        datasets: [{
            label: 'COBRANZA ACTUAL: <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $CE?>,<?php echo $CP?>,<?php echo $CA?>],
            backgroundColor: [
                'rgba(21, 157, 46, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(255, 99, 50, 0.7)'
            ],
            borderColor: [
                'rgba(21, 157, 46, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 50, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

}

//Grafico Metas Comerciales
/*if(usermail!='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
    if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){
         if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
    var ctx = document.getElementById('myChartMetas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: {
                        labels: ['AUTOS', 'DAÑOS','FIANZAS','GMM', 'VIDA'],
                        datasets: [{
                            label: 'Meta Asignada',
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            stack: 'Stack 0',
                        }, {
                            label: 'Meta Alcanzada',
                             backgroundColor: 'rgba(153, 102, 255, 1)',
                             stack: 'Stack 1',
                        },
                        {
                            label: 'Comision Alcanzada',
                             backgroundColor: 'rgba(210, 180, 222  , 1)',
                             stack: 'Stack 1',
                        }]
                    },
                options: {
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true
                        }
                    }
                }
            });
}
}
}*/

//Grafico cobranza
if(usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){
     if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
var ctx = document.getElementById('myChartActividades').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['AUTOS', 'DAÑOS', 'LINEAS PERSONALES'],
        datasets: [{
            label: 'Actividades Actuales: <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $auto?>,<?php echo $danio?>,<?php echo $vida?>],
            backgroundColor: [
                'rgba(115, 198, 182, 0.6)',
                'rgba(127, 179, 213, 0.6)',
                'rgba(243, 156, 18, 0.6)'
            ],
            borderColor: [
                'rgba(115, 198, 182, 1)',
                'rgba(127, 179, 213, 1)',
                'rgba(243, 156, 18, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

}
}

//Grafico Renovaciones
if(usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){
     if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
var ctx = document.getElementById('myChartRenovaciones').getContext('2d');
window.myBar = new Chart(ctx, {
type: 'bar',
data: {
labels: ['AUTOS','DAÑOS','LINEAS PERSONALES'],
datasets: [
         {
            label: '+20',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(21, 157, 46, 0.7)',
            'rgba(21, 157, 46, 0.7)',
            'rgba(21, 157, 46, 0.7)'
            ],
            borderColor: [
                'rgba(115, 198, 182, 1)',
                'rgba(115, 198, 182, 1)',
                'rgba(115, 198, 182, 1)'
            ],
            data: [<?php echo $renovacion[0]?>,<?php echo $renovacion[6]?>,<?php echo $renovacion[3]?>]
        },
        {
            label: '+1',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(255, 206, 86, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(255, 206, 86, 0.7)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 206, 86, 1)'
            ],

            data: [<?php echo $renovacion[1]?>,<?php echo $renovacion[7]?>,<?php echo $renovacion[4]?>]
        },
        {
            label: '-1',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(255, 99, 50, 0.7)',
            'rgba(255, 99, 50, 0.7)',
            'rgba(255, 99, 50, 0.7)'
            ],
            borderColor: [
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)'
            ],
           data: [<?php echo $renovacion[2]?>,<?php echo $renovacion[8]?>,<?php echo $renovacion[5]?>]
        }
        ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});

}
}

//Modificaciones 12/05/2021 Miguel Jaime
//Grafico Presupuesto
if(usermail!='DIRECTORCOMERCIAL@AGENTECAPITAL.COM'){
    if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
         if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
            if(usermail!='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
                if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){

                //}
var ctx = document.getElementById('myChartPresupuesto').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['<?php echo strtoupper($lbSucursal[0])?>','<?php echo strtoupper($lbSucursal[1])?>','<?php echo strtoupper($lbSucursal[2])?>','<?php echo strtoupper($lbSucursal[3])?>'],
        datasets: [{
            label: 'PRESUPUESTO',
            data: [<?php echo number_format($lbComision[0],2)?>,<?php echo number_format($lbComision[1],2)?>,<?php echo number_format($lbComision[2],2)?>,<?php echo number_format($lbComision[3],2)?>],
            backgroundColor: [
                'rgba(115, 198, 182, 0.6)',
                'rgba(127, 179, 213, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(243, 156, 18, 0.6)'
            ],
            borderColor: [
                'rgba(115, 198, 182, 1)',
                'rgba(127, 179, 213, 1)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(243, 156, 18, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
                }
}
}
}
}



if(usermail!='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
  if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){
    if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){
var ctx = document.getElementById('myChartFastFile').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Prestamos', 'Vacaciones', 'Permisos','Incapacidad','Cambio Puesto','Ajuste Sueldo','Calificacion'],
        datasets: [{
            label: 'FAST FILE: <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $prestamos[0]->TOTAL;?>,<?php echo $vacaciones[0]->TOTAL;?>,<?php echo $permisos[0]->TOTAL;?>,<?php echo $incapacidad[0]->TOTAL;?>,<?php echo $sueldo[0]->TOTAL;?>,<?php echo $cambio_puesto[0]->TOTAL;?>,<?php echo $calificacion[0]->TOTAL;?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(155, 231, 23, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(155, 231, 23, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(155, 231, 23, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(155, 231, 23, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});



var ctx = document.getElementById('myChartPuntualidad').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Asistencia','Puntualidad'],
        datasets: [{
            label: 'PUNTUALIDAD: <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $asistencia[0]->TOTAL;?>,<?php echo $puntualidad[0]->TOTAL;?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});



}
}
}



if(usermail!='GERENTEOPERATIVO@AGENTECAPITAL.COM'){
  if(usermail!='COORDINADOROPERATIVO@ASESORESCAPITAL.COM'){
    if(usermail!='COBRANZA@ASESORESCAPITAL.COM'){



var ctx = document.getElementById('myChartRotacion').getContext('2d');
window.myBar = new Chart(ctx, {
type: 'bar',
data: {
labels: ['COMERCIAL','OPERATIVO','ADMINISTRATIVO','GERENCIAL','CORPORATIVO','FIANZAS'],
datasets: [
         {
            label: 'Activos',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)'

            ],
            borderColor: [
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)'
            ],
            data: [<?php echo $activosComercial;?>,<?php echo $activosOperativo;?>,<?php echo $activosAdministrativo;?>,<?php echo $activosGerencial;?>,<?php echo $activosCorporativo;?>,<?php echo $activosFianzas;?>]
        },
        {
            label: 'Bajas',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)'

            ],
            borderColor: [
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)'
            ],

            data: [<?php echo $bajasComercial;?>,<?php echo $bajasOperativo;?>,<?php echo $bajasAdministrativo;?>,<?php echo $bajasGerencial;?>,<?php echo $bajasCorporativo;?>,<?php echo $bajasFianzas;?>]
        }
        ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});

}
}
}

//fin de modificaciones 05/2021


/* Ajax*/


function getMetasComercial(){
    var idPersona=document.getElementById('coordinador').value;
    var URL=$('#base').val()+"reportes/detalle_reporte_meta?idPersona="+idPersona;
    document.location.href=URL;
}

window.onload = function() {
     document.getElementById('loader').style.display="none";
}


</script>

<?
function imprimirCompaniasConSemaros($array)
{
$tr='';

  foreach ($array as $key => $value) 
  {
    $tr.=' <tr><td><b>'.$key.'</b></td>';
    $tr.='<td style="text-align: right;">'.$value.'</td>'; 
    $tr.='</tr>';     
  }

 return $tr;
                          

} 
function imprimirInfoEmisiones($array)
{
    $tr='';
     
 $tr.='<tr style="background-color:#f3f57a;color:black"><td>TOTAL DE EMISIONES</td><td style="text-align: right;">'.$array['emisiones'].'</td></tr>';

     
 
        $tr.='<tr style="background-color:#b68afb;color:black"><td colspan="2">TIPO CONDUCTO</td></tr>';        
        foreach ($array['tipoConducto'] as  $value) 
        {   if($value->pagoConducto!='')
            {
              $tr.='<tr><td>-'.$value->pagoConducto.'</td><td style="text-align: right;">'.$value->total.'</td></tr>';
            }
        }
     
     $tr.='<tr style="background-color:#3fe390;color:black"><td colspan="2">TIPO DE PAGO</td></tr>';           
        foreach ($array['tipoPago'] as  $value) 
        {   
              $tr.='<tr><td>-'.$value->tarjetaTipoPago.'</td><td style="text-align: right;">'.$value->total.'</td></tr>';
            
        }
     
     $tr.='<tr style="background-color:#e3c03f;color:black"><td>TARJETAS CON INFORMACION</td><td style="text-align: right;">'.$array['tarjetas'].'</td></tr>';
        
    return $tr;
}
?>
<style type="text/css">
    .alert-info{width: 100%;height: 200px;overflow: scroll;}
</style>

