<style>
    #tablaGeneral{
        color: #000;
    }
    #tablaGeneral tr td{
        padding: 2px;
    }
    #tablaSecundaria{
        color: #000;
    }
    .wrap{
    width: 100%;
    margin: 10px auto;
    }
    ul.tabs{
    width: 100%;
    background: #363636;
    list-style: none;
    display: flex;
    }
    ul.tabs li{
    width: 20%;
    }
    ul.tabs li a{
    color: #fff;
    text-decoration: none;
    font-size: 11px;
    text-align: center;
    display: block;
    padding: 7px 0px;
    }
    .active{
    background: #0984CC;
    }
    ul.tabs li a:hover{
    background: #0984CC;
    }
    ul.tabs li a .tab-text{
    margin-left: 10px;
    }
</style>
<?php
function efic($pen,$cob){
    if($cob==0){
        $cob=1;
    }
    return number_format(($pen/$cob),2);
}
function MESLETRAS($mes){
    switch ($mes) {
        case '01':
            return "ENERO";
            break;
        case '02':
            return "FEBRERO";
            break;
         case '03':
            return "MARZO";
            break;
        case '04':
            return "ABRIL";
            break;
        case '05':
            return "MAYO";
            break;
        case '06':
            return "JUNIO";
            break;
        case '07':
            return "JULIO";
            break;
        case '08':
            return "AGOSTO";
            break;
        case '09':
            return "SEPTIEMBRE";
            break;
        case '10':
            return "OCTUBRE";
            break;
         case '11':
            return "NOVIEMBRE";
            break;
        case '12':
            return "DICIEMBRE";
            break;
        
    }
}
?>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="wrap">
            <ul class="tabs">
                    <li>
                        <a href="#" onclick="resumen()"><span class="tab-text"><i class="fa fa-arrow"></i>Resumen de Cobranza</span></a>
                    </li>
                        
                    <li>
                        <a href="#" onclick="pendiente()"><span class="tab-text"><i class="fa fa-arrow"></i>Toda la Cobranza</span></a>
                    </li>

                     <li>
                        <a href="#" onclick="pendiente_fianzas()"><span class="tab-text"><i class="fa fa-arrow"></i>Toda la Cobranza de Fianzas</span></a>
                    </li>

                    <li>
                        <a href="#" onclick="efectuada()"><span class="tab-text"><i class="fa fa-arrow"></i>Cobranza Efectuada</span></a>
                    </li>

                     <li>
                        <a href="#" onclick="efectuada_fianzas()"><span class="tab-text"><i class="fa fa-arrow"></i>Cobranza Efectuada de Fianzas</span></a>
                    </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="well">
            <div class="panel panel-default" id="resumen">
                
                <div class="panel-heading" style="font-size: 11px;">
                    <i class="fa fa-list"></i> <b>Rango de Consulta</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desde: <b><?php echo $fdesde?></b>&nbsp;&nbsp;&nbsp;&nbsp;Hasta: <b><?php echo $fhasta?></b>
                </div>
                
                <table style="width: 100%" id="tablaGeneral">
                    <tr style="background-color: #000;color: #fff;">
                        <td rowspan="2" style="padding-top: 25px;width: 35%;">&nbsp;Concepto</td>
                        <td colspan="2" style="text-align: center;">Recibos</td>
                        <td colspan="2" style="text-align: center;">Prima neta</td>
                        <td colspan="2" style="text-align: center;">Comisión</td>
                    </tr>
                    <tr style="background-color: #000;color: #fff;text-align: right;">
                        <td>Fianzas</td>
                        <td>Seguros</td>
                        <td>Fianzas</td>
                        <td>Seguros</td>
                        <td>Fianzas</td>
                        <td>Seguros&nbsp;</td>
                    </tr>
                
                    <tr>
                        <td>&nbsp;Toda la Cobranza(Pendiente, Liquidada, Pagada, Cancelada)</td>
                        <td style="text-align: right;"><?php echo $ctTodaFianzas?></td>
                        <td style="text-align: right;"><?php echo $ctTodaSeguros?></td>
                        <td style="text-align: right;"><?php echo number_format($primaNetaFianzas,2)?></td>
                        <td style="text-align: right;"><?php echo number_format(($primaNetaSeguros),2)?></td>
                        <td style="text-align: right;"><?php echo number_format($comisionFianzas,2)?></td>
                        <td style="text-align: right;"><?php echo number_format($comisionSeguros,2)?>&nbsp;</td>
                    </tr>
    
                    <tr>
                        <td>&nbsp;Cobranza Efectuada Anticipada</td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaAnticipadaFianzas?></td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaAnticipadaSeguros?></td>
                        <td style="text-align: right;"><?php echo number_format($primaNetaEfectuadaAnticipadaFianzas,2)?></td>
                        <td style="text-align: right;"><?php echo number_format($primaNetaEfectuadaAnticipadaSeguros,2)?></td>
                        <td style="text-align: right;"><?php echo number_format($comisionEfectuadaAnticipadaFianzas,2)?></td>
                        <td style="text-align: right;"><?php echo number_format($comisionEfectuadaAnticipadaSeguros,2)?>&nbsp;</td>
                    </tr>


                    <tr>
                        <td>&nbsp;Cancelada</td>
                        <td style="text-align: right;">
                            <?php echo $ctCanceladaFianzas?></td>
                        <td style="text-align: right;">
                            <?php echo $ctCanceladaSeguros?></td>
                        <td style="text-align: right;">
                            <?php echo number_format($primaNetaCanceladaFianzas,2)?>
                        </td>
                        <td style="text-align: right;">
                            <?php echo number_format($primaNetaCanceladaSeguros,2)?>
                        </td>
                        <td style="text-align: right;"><?php echo number_format($comisionCanceladaFianzas,2)?></td>
                        <td style="text-align: right;"><?php echo number_format($comisionCanceladaSeguros,2)?>&nbsp;</td>
                        
                    </tr>



                    <tr>
                        <td>&nbsp;<b>Pendiente</b></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo $ctTodaFianzas-$ctEfectuadaAnticipadaFianzas-$ctCanceladaFianzas?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo $ctTodaSeguros-$ctEfectuadaAnticipadaSeguros-$ctCanceladaSeguros?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaFianzas-($primaNetaEfectuadaAnticipadaFianzas+$primaNetaCanceladaFianzas),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaSeguros-($primaNetaEfectuadaAnticipadaSeguros+$primaNetaCanceladaSeguros),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionFianzas-($comisionEfectuadaAnticipadaFianzas+$comisionCanceladaFianzas),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionSeguros-($comisionEfectuadaAnticipadaSeguros+$comisionCanceladaSeguros),2)?>&nbsp;</td>
                    </tr>
                    <tr><td colspan="7"><hr></td></tr>


                    <tr>
                        <td>&nbsp;Cobranza Efectuada del Periodo</td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaFianzas?></td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaSeguros?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaEfectuadaFianzas,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaEfectuadaSeguros,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionEfectuadaFianzas,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionEfectuadaSeguros,2)?>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>&nbsp;Cobranza Efectuada Atrasada</td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaAtrasadaFianzas?></td>
                        <td style="text-align: right;"><?php echo $ctEfectuadaAtrasadaSeguros?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaEfectuadaAtrasadaFianzas,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($primaNetaEfectuadaAtrasadaSeguros,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionEfectuadaAtrasadaFianzas,2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format($comisionEfectuadaAtrasadaSeguros,2)?>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;<b>Total Cobrado<b></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo $ctEfectuadaFianzas+$ctEfectuadaAtrasadaFianzas?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo $ctEfectuadaSeguros+$ctEfectuadaAtrasadaSeguros?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format(($primaNetaEfectuadaFianzas+$primaNetaEfectuadaAtrasadaFianzas),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format(($primaNetaEfectuadaSeguros+$primaNetaEfectuadaAtrasadaSeguros),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format(($comisionEfectuadaFianzas+$comisionEfectuadaAtrasadaFianzas),2)?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo number_format(($comisionEfectuadaSeguros+$comisionEfectuadaAtrasadaSeguros),2)?>&nbsp;</td>
                    </tr>

                    <tr><td colspan="7"><hr></td></tr>

                    <tr>
                        <td><b>% Eficiencia</b></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo efic(($ctTodaFianzas-$ctEfectuadaAnticipadaFianzas-$ctCanceladaFianzas),($ctEfectuadaFianzas+$ctEfectuadaAtrasadaFianzas))."%";?></td>
                        <td style="text-align: right;font-weight: bold;"><?php echo efic((($ctTodaSeguros-$ctEfectuadaAnticipadaSeguros-$ctCanceladaSeguros)), ($ctEfectuadaSeguros+$ctEfectuadaAtrasadaSeguros))."%";?></td>
                        
                        <td style="text-align: right;font-weight: bold;"><?php echo efic (($primaNetaFianzas-($primaNetaEfectuadaAnticipadaFianzas+$primaNetaCanceladaFianzas)),($primaNetaEfectuadaSeguros+$primaNetaEfectuadaFianzas))."%";?></td>

                        <td style="text-align: right;font-weight: bold;"><?php echo efic($primaNetaSeguros-($primaNetaEfectuadaAnticipadaSeguros+$primaNetaCanceladaSeguros),($primaNetaEfectuadaSeguros+$primaNetaEfectuadaAtrasadaSeguros))."%";?></td>
                        
                        <td style="text-align: right;font-weight: bold;"><?php echo efic( ($comisionFianzas-($comisionEfectuadaAnticipadaFianzas+$comisionCanceladaFianzas) ), ($comisionEfectuadaFianzas+$comisionEfectuadaAtrasadaFianzas))."%";?></td>

                        <td style="text-align: right;font-weight: bold;"><?php echo efic(($comisionSeguros-($comisionEfectuadaAnticipadaSeguros+$comisionCanceladaSeguros)),($comisionEfectuadaSeguros+$comisionEfectuadaAtrasadaSeguros))."%";?>&nbsp;</td>
                    </tr>
                    <tr><td colspan="7" style="height: 1px;"></td></tr>
                    <!--  ========================== POR COBRAR =================-->
                    <tr>
                        <td>&nbsp;Por cobrar</td>
                        <td style="text-align: right;"><?php echo abs(($ctTodaFianzas-($ctEfectuadaAnticipadaFianzas+$ctCanceladaFianzas))-($ctEfectuadaFianzas+$ctEfectuadaAtrasadaFianzas))?></td>
                        <td style="text-align: right;"><?php echo abs(($ctTodaSeguros-($ctEfectuadaAnticipadaSeguros+$ctCanceladaSeguros))-($ctEfectuadaSeguros+$ctEfectuadaAtrasadaSeguros))?></td>
                        <td style="text-align: right;"><?php echo number_format((abs(($primaNetaFianzas-($primaNetaEfectuadaAnticipadaFianzas+$primaNetaCanceladaFianzas))-($primaNetaEfectuadaFianzas+$primaNetaEfectuadaAtrasadaFianzas))),2)?></td>
                        <td style="text-align: right;"><?php echo number_format((abs(($primaNetaSeguros-($primaNetaEfectuadaAnticipadaSeguros+$primaNetaCanceladaSeguros))-($primaNetaEfectuadaSeguros+$primaNetaEfectuadaAtrasadaSeguros))),2)?></td>
                        <td style="text-align: right;"><?php echo number_format( 
                            abs(($comisionFianzas-($comisionEfectuadaAnticipadaFianzas+$comisionCanceladaFianzas))- ($comisionEfectuadaFianzas+$comisionEfectuadaAtrasadaFianzas)),2)?></td>
                        <td style="text-align: right;"><?php echo number_format( 
                            abs(($comisionSeguros-($comisionEfectuadaAnticipadaSeguros+$comisionCanceladaSeguros))- ($comisionEfectuadaSeguros+$comisionEfectuadaAtrasadaSeguros)),2)?>&nbsp;</td>
                    </tr>
                </table>

                <br><br>
                
                <table style="width: 100%" id="tablaSecundaria">
                    <tr style="background-color: #000;color: #fff;text-align: center;">
                        <td style="background-color: orange;color: #000;"><b><?php 

                        echo MESLETRAS(date('m', strtotime($fdesde)))?></b></td>
                        <td>Fianzas</td>
                        <td>Seguro</td>
                        <td>CAT</td>
                        <td>En tiempo</td>
                        <td>Vencida + 10 dias</td>
                    </tr>
                    <tr style="text-align: center">
                        <td>Agentes</td>
                        <td><?php echo $ctFianzasAgentes?></td>
                        <td><?php echo $ctSegurosAgentes?></td>
                        <td><?php echo $ctAgentesCAT?></td>
                        <td><?php echo $ctEntiempoAgente['pendientes'];?></td>
                        <td><?php echo $ctVencidasAgente['vencidas'];?>&nbsp;</td>
                    </tr>
                    <tr style="text-align: center">
                        <td>Institucional</td>
                        <td><?php echo $ctFianzasInstitucional?></td>
                        <td><?php echo $ctSegurosInstitucional?></td>
                        <td><?php echo $ctInstitucionalCAT?></td>
                        <td><?php echo $ctEntiempoInstitucional['pendientes'];?></td>
                        <td><?php echo $ctVencidasInstitucional['vencidas'];?>&nbsp;</td>
                    </tr>
                    <tr><td colspan="6" style="height: 2px;background-color: #000;"></td></tr>
                    <tr style="text-align: center">
                        <td><b>Pendiente</b></td>
                        <td style="font-weight: bold;"><?php echo $ctFianzasAgentes+$ctFianzasInstitucional?></td>
                        <td style="font-weight: bold;"><?php echo $ctSegurosAgentes+$ctSegurosInstitucional?></td>
                        <td style="font-weight: bold;"><?php echo $ctAgentesCAT+$ctInstitucionalCAT?></td>
                        <td style="font-weight: bold;"><?php echo $ctEntiempoAgente['pendientes']+$ctEntiempoInstitucional['pendientes'];?></td>
                        <td style="font-weight: bold;"><?php echo $ctVencidasAgente['vencidas']+$ctVencidasInstitucional['vencidas'];?>&nbsp;</td>
                    </tr>
                    <!--
                    <tr>
                        <td colspan="3">&nbsp;</td>
                        <td style="text-align: center;">35%</td>
                        <td style="text-align: center;">65%</td>
                        <td>&nbsp;</td>
                    </tr>
                -->
                    <tr>
                        <td colspan="7"><br></td>
                    </tr>
                    <tr style="text-align: center;">
                        <td><b>Acumulado</b></td>
                        <td></td>
                        <td></td>
                        <td><b>Semaforo</b></td>
                        <td>
                            <table>
                                <tr>
                                    <td style="color:#fff;background-color: #FA5858;font-weight: bold;"> 10 de vencida</td>
                                    <td style="text-align: right;">&nbsp;&nbsp;<?php echo $totalSemaforo['vencidas'];?></td>
                                </tr>
                                <tr>
                                    <td style="background-color: #FACC2E;font-weight: bold;">< 5 dias p/vencer</td>
                                    <td style="text-align: right;">&nbsp;&nbsp;<?php echo $totalSemaforo['pendientes'];?></td>
                                </tr>
                                <tr>
                                    <td style="color:#fff;background-color: #04B45F;font-weight: bold;text-align: right;>6 dias p/vencer</td "></td>
                                    <td style="text-align: right;">&nbsp;&nbsp;<?php echo $totalSemaforo['entiempo'];?></td>
                                </tr>
                            </table>
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </table>
                <br><br>
                <div>
                    <a href="#" onclick="exportarExcel()"><button class="btn btn-success btn-sm" style="color: #fff;"><i class="fa fa-download"></i> Descargar</button></a>
                </div>
            
            </div>




            <div class="panel panel-default" id="pendiente" style="display: none;">
                <?php 
                    $this->load->view('reportes/cobranza_toda');
                ?>
            </div>

                <div class="panel panel-default" id="pendiente_fianzas" style="display: none;">
                <?php 
                    $this->load->view('reportes/cobranza_toda_fianzas');
                ?>
            </div>

            <div class="panel panel-default" id="efectuada" style="display: none">
                <?php 
                    $this->load->view('reportes/cobranza_efectuada');
                ?>
            </div>          

            <div class="panel panel-default" id="efectuada_fianzas" style="display: none">
                <?php 
                    $this->load->view('reportes/cobranza_efectuada_fianzas');
                ?>
            </div>          



        </div>
    </div>
</div>

<script type="text/javascript">
    function pendiente(){
        document.getElementById('pendiente').style.display="block";
        document.getElementById('resumen').style.display="none";
        document.getElementById('efectuada').style.display="none";
        document.getElementById('pendiente_fianzas').style.display="none";
        document.getElementById('efectuada_fianzas').style.display="none";
    }
    function efectuada(){
        document.getElementById('efectuada').style.display="block";
        document.getElementById('resumen').style.display="none";
        document.getElementById('pendiente').style.display="none";
        document.getElementById('pendiente_fianzas').style.display="none";
        document.getElementById('efectuada_fianzas').style.display="none";
    }

    function pendiente_fianzas(){
        document.getElementById('pendiente_fianzas').style.display="block";
        document.getElementById('resumen').style.display="none";
        document.getElementById('pendiente').style.display="none";
        document.getElementById('efectuada').style.display="none";
        document.getElementById('efectuada_fianzas').style.display="none";
    }
    function efectuada_fianzas(){
        document.getElementById('efectuada_fianzas').style.display="block";
        document.getElementById('resumen').style.display="none";
        document.getElementById('pendiente').style.display="none";
        document.getElementById('efectuada').style.display="none";
        document.getElementById('pendiente_fianzas').style.display="none";
        
    }
    function resumen(){
        document.getElementById('resumen').style.display="block";
        document.getElementById('pendiente').style.display="none";
        document.getElementById('efectuada').style.display="none";
        document.getElementById('pendiente_fianzas').style.display="none";
        document.getElementById('efectuada_fianzas').style.display="none";
    }
</script>