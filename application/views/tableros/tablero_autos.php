<?php
setlocale(LC_ALL,"es_ES");
$string = "24/11/2014";
$date = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));
$mesL=strtoupper(strftime("%b",$date->getTimestamp()));
?>
<style>
    .labelM {
        /* float: right; */
        font-size: 16px;
    }

    #element1 {
        float: left;
    }

    #element2 {
        /* padding-left: 5px; */
        float: left;
    }

    .padre {
        display: flex;
        justify-content: center;
    }

    .hijo {
        padding: 10px;
        margin: 10px;
    }

    .tituloP{
        font-size: 20px;
    }
    .box.first {
        float: left;
    }
    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }
    .help-block{
        color:red;
    }
    .swal-button--confirm{
    background-color:#67439f!important;
}

.swal-text{
    color:#472380 !important;
}
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <h3 class="titulo-secciones">TABLERO SINIESTROS AUTOS INDIVIDUALES</h3>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3" style="float: right;">
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico1["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
            <?= $grafico2["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico3["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico4["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <!-- <?= $grafico5["HTML"] ?> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-SINIESTROS_RANGO_AUTOS" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="RANGO DE DÍAS DE RESPUESTA-AUTOS INDIVIDUAL" data-chart-name="SINIESTROS_RANGO_AUTOS" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart" ><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_SINIESTROS_RANGO_AUTOS' >RANGO DE DÍAS DE RESPUESTA-AUTOS INDIVIDUAL-<?=date("Y")?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_AUTOS_RANGO">
                                <thead style="font-size: 10px;">
                                    <tr id="Head-T">

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padre">
                            <?= $grafico5["HTML"] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_MES_AUTOS" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR MES-AUTOS INDIVIDUAL" data-chart-name="TABLA_MES_AUTOS" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='1' data-setyear='1'><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_TABLA_MES_AUTOS'>MOVIMIENTOS POR MES-AUTOS INDIVIDUAL-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_MES_AUTOS_Total' style="text-align:center;min-width: 48px;"><?=$tablaAutosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_AUTOS_ter_en_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOS_ter_no_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOS_pend_en_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOS_pend_no_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_MES_AUTOS_Totales' style="text-align:center;min-width: 48px;"><?=$tablaAutosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_AUTOS_Terminados' style="text-align:center;" colspan="2"><?=$tablaAutosmes[0]['ter_no_tiempo']+$tablaAutosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOS_Pendientes' style="text-align:center;" colspan="2"><?=$tablaAutosmes[0]['pend_en_tiempo']+$tablaAutosmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_MES_AUTOS2" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS MES-AUTOS INDIVIDUAL" data-chart-name="TABLA_MES_AUTOS2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='1' data-setyear='1'></a>
                        <h5 id='title_TABLA_MES_AUTOS2'>PORCENTAJES MOVIMIENTOS MES-AUTOS INDIVIDUAL-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalAmes=$tablaAutosmes[0]['Total']==0?1:$tablaAutosmes[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_MES_AUTOS_p_Totales' style="text-align:center;"><?=round(($tablaAutosmes[0]['Total']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['ter_en_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['ter_no_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['pend_en_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['pend_no_tiempo']/$TotalAmes)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_MES_AUTOS_p_Totaless' style="text-align:center;"><?=round(($tablaAutosmes[0]['Total']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaAutosmes[0]['ter_no_tiempo']+$tablaAutosmes[0]['ter_en_tiempo'])/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOS_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaAutosmes[0]['pend_en_tiempo']+$tablaAutosmes[0]['pend_no_tiempo'])/$TotalAmes)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a class="bn-open-filter pull-right"  id="btnfilter-TABLA_ANO_AUTOS"  data-date="" data-setmonth='0' data-setyear='1' style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR AÑO-AUTOS INDIVIDUAL" data-chart-name="TABLA_ANO_AUTOS" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_TABLA_ANO_AUTOS'>MOVIMIENTOS POR AÑO-AUTOS INDIVIDUAL-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_ANO_AUTOS_Total' style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td id='TABLA_ANO_AUTOS_ter_en_tiempo' style="text-align:center;"><?=$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOS_ter_no_tiempo' style="text-align:center;"><?=$tablaAutos[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOS_pend_en_tiempo' style="text-align:center;"><?=$tablaAutos[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOS_pend_no_tiempo' style="text-align:center;"><?=$tablaAutos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_ANO_AUTOS_Totales' style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td id='TABLA_ANO_AUTOS_Terminados' style="text-align:center;" colspan="2"><?=$tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOS_Pendientes' style="text-align:center;" colspan="2"><?=$tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_ANO_AUTOS2" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS AÑO-AUTOS INDIVIDUAL" data-chart-name="TABLA_ANO_AUTOS2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='0' data-setyear='1'></a>
                        <h5 id='title_TABLA_ANO_AUTOS2'>PORCENTAJES MOVIMIENTOS AÑO-AUTOS INDIVIDUAL-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalAanos=$tablaAutos[0]['Total']==0?1:$tablaAutos[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_ANO_AUTOS_p_Total' style="text-align:center;"><?=round(($tablaAutos[0]['Total']/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['ter_en_tiempo']/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['ter_no_tiempo']/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['pend_en_tiempo']/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['pend_no_tiempo']/$TotalAanos)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_ANO_AUTOS_p_Totaless' style="text-align:center;"><?=round(($tablaAutos[0]['Total']/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo'])/$TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOS_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo'])/$TotalAanos)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <h3 class="titulo-secciones">TABLERO SINIESTROS DAÑOS</h3>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3" style="float: right;">
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico6["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico7["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico8["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico9["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
               <!--  <?= $grafico10["HTML"] ?> -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-SINIESTROS_RANGO_DANOS" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="RANGO DE DÍAS DE RESPUESTA-DAÑOS" data-chart-name="SINIESTROS_RANGO_DANOS" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_SINIESTROS_RANGO_DANOS' >RANGO DE DÍAS DE RESPUESTA-DAÑOS-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_DANOS_RANGO">
                                <thead style="font-size: 10px;">
                                    <tr id="Head-T">

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padre">
                            <?= $grafico10["HTML"] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_MES_DANOS" data-date="" data-setmonth='1' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR MES-DAÑOS" data-chart-name="TABLA_MES_DANOS" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_TABLA_MES_DANOS'>MOVIMIENTOS POR MES-DAÑOS-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_MES_DANOS_Total' style="text-align:center;min-width: 48px;"><?=$tablaDanosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_DANOS_ter_en_tiempo' style="text-align:center;"><?=$tablaDanosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_DANOS_ter_no_tiempo' style="text-align:center;"><?=$tablaDanosmes[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_MES_DANOS_pend_en_tiempo' style="text-align:center;"><?=$tablaDanosmes[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_MES_DANOS_pend_no_tiempo' style="text-align:center;"><?=$tablaDanosmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_MES_DANOS_Totales' style="text-align:center;min-width: 48px;"><?=$tablaDanosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_DANOS_Terminados' style="text-align:center;" colspan="2"><?=$tablaDanosmes[0]['ter_no_tiempo']+$tablaDanosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_DANOS_Pendientes' style="text-align:center;" colspan="2"><?=$tablaDanosmes[0]['pend_en_tiempo']+$tablaDanosmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                    <a class="bn-open-filter pull-right" id="btnfilter-TABLA_MES_DANOS2" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS POR MES-DAÑOS" data-chart-name="TABLA_ANO_AUTOS2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='0' data-setyear='1'></a>
                        <h5 id='title_TABLA_MES_DANOS2'>PORCENTAJES MOVIMIENTOS POR MES-DAÑOS-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalDmes=$tablaDanosmes[0]['Total']==0?1:$tablaDanosmes[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_MES_DANOS_p_Total' style="text-align:center;"><?=round(($tablaDanosmes[0]['Total']/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaDanosmes[0]['ter_en_tiempo']/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaDanosmes[0]['ter_no_tiempo']/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaDanosmes[0]['pend_en_tiempo']/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaDanosmes[0]['pend_no_tiempo']/$TotalDmes)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_MES_DANOS_p_Totaless' style="text-align:center;"><?=round(($tablaDanosmes[0]['Total']/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaDanosmes[0]['ter_no_tiempo']+$tablaDanosmes[0]['ter_en_tiempo'])/$TotalDmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_DANOS_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaDanosmes[0]['pend_en_tiempo']+$tablaDanosmes[0]['pend_no_tiempo'])/$TotalDmes)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_ANO_DANOS" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR AÑO-DAÑOS" data-chart-name="TABLA_ANO_DANOS" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id="title_TABLA_ANO_DANOS">MOVIMIENTOS POR AÑO-DAÑOS-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_ANO_DANOS_Total' style="text-align:center;min-width: 48px;"><?=$tablaDanos[0]['Total']?></td>
                                        <td id='TABLA_ANO_DANOS_ter_en_tiempo' style="text-align:center;"><?=$tablaDanos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_DANOS_ter_no_tiempo' style="text-align:center;"><?=$tablaDanos[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_ANO_DANOS_pend_en_tiempo' style="text-align:center;"><?=$tablaDanos[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_ANO_DANOS_pend_no_tiempo' style="text-align:center;"><?=$tablaDanos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_ANO_DANOS_Totales' style="text-align:center;min-width: 48px;"><?=$tablaDanos[0]['Total']?></td>
                                        <td id='TABLA_ANO_DANOS_Terminados'style="text-align:center;" colspan="2"><?=$tablaDanos[0]['ter_no_tiempo']+$tablaDanos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_DANOS_Pendientes' style="text-align:center;" colspan="2"><?=$tablaDanos[0]['pend_en_tiempo']+$tablaDanos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_ANO_DANOS2" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS POR AÑO-DAÑOS" data-chart-name="TABLA_ANO_DANOS" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"></a>
                        <h5 id="title_TABLA_ANO_DANOS2">PORCENTAJES MOVIMIENTOS POR AÑO-DAÑOS-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalDAnos=$tablaDanos[0]['Total']==0?1:$tablaDanos[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_ANO_DANOS_p_Total' style="text-align:center;"><?=round(($tablaDanos[0]['Total']/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaDanos[0]['ter_en_tiempo']/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaDanos[0]['ter_no_tiempo']/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaDanos[0]['pend_en_tiempo']/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaDanos[0]['pend_no_tiempo']/$TotalDAnos)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_ANO_DANOS_p_Totaless' style="text-align:center;"><?=round(($tablaDanos[0]['Total']/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaDanos[0]['ter_no_tiempo']+$tablaDanos[0]['ter_en_tiempo'])/$TotalDAnos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_DANOS_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaDanos[0]['pend_en_tiempo']+$tablaDanos[0]['pend_no_tiempo'])/$TotalDAnos)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <h3 class="titulo-secciones">TABLERO SINIESTROS GMM</h3>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3" style="float: right;">
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico11["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico12["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico13["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico14["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-SINIESTROS_RANGO_GMM" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="RANGO DE DÍAS DE RESPUESTA-GMM" data-chart-name="SINIESTROS_RANGO_GMM" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id="title_SINIESTROS_RANGO_GMM">RANGO DE DÍAS DE RESPUESTA-GMM-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_GMM_RANGO">
                                <thead style="font-size: 10px;">
                                    <tr id="Head-T">

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padre">
                            <?= $grafico15["HTML"] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_MES_GMM"  data-date="" data-setmonth='1' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR MES-GMM" data-chart-name="TABLA_MES_GMM" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id="title_TABLA_MES_GMM">MOVIMIENTOS POR MES-GMM-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_MES_GMM_Total' style="text-align:center;min-width: 48px;"><?=$tablaGmmmes[0]['Total']?></td>
                                        <td id='TABLA_MES_GMM_ter_en_tiempo' style="text-align:center;"><?=$tablaGmmmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_GMM_ter_no_tiempo' style="text-align:center;"><?=$tablaGmmmes[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_MES_GMM_pend_en_tiempo' style="text-align:center;"><?=$tablaGmmmes[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_MES_GMM_pend_no_tiempo' style="text-align:center;"><?=$tablaGmmmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_MES_GMM_Totales' style="text-align:center;min-width: 48px;"><?=$tablaGmmmes[0]['Total']?></td>
                                        <td id='TABLA_MES_GMM_Terminados' style="text-align:center;" colspan="2"><?=$tablaGmmmes[0]['ter_no_tiempo']+$tablaGmmmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_GMM_Pendientes' style="text-align:center;" colspan="2"><?=$tablaGmmmes[0]['pend_en_tiempo']+$tablaGmmmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_MES_GMM2"  data-date="" data-setmonth='1' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS POR MES-GMM" data-chart-name="TABLA_MES_GMM" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"></a>
                        <h5 id="title_TABLA_MES_GMM2">PORCENTAJES MOVIMIENTOS POR MES-GMM-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalGmes=$tablaGmmmes[0]['Total']==0?1:$tablaGmmmes[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_MES_GMM_p_Total' style="text-align:center;"><?=round(($tablaGmmmes[0]['Total']/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaGmmmes[0]['ter_en_tiempo']/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaGmmmes[0]['ter_no_tiempo']/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaGmmmes[0]['pend_en_tiempo']/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaGmmmes[0]['pend_no_tiempo']/$TotalGmes)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_MES_GMM_p_Totaless' style="text-align:center;"><?=round(($tablaGmmmes[0]['Total']/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaGmmmes[0]['ter_no_tiempo']+$tablaGmmmes[0]['ter_en_tiempo'])/$TotalGmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_GMM_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaGmmmes[0]['pend_en_tiempo']+$tablaGmmmes[0]['pend_no_tiempo'])/$TotalGmes)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_ANO_GMM" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR AÑO-GMM" data-chart-name="TABLA_ANO_GMM" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id="title_TABLA_ANO_GMM">MOVIMIENTOS POR AÑO-GMM-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td id='TABLA_ANO_GMM_Total' style="text-align:center;min-width: 48px;"><?=$tablaGmm[0]['Total']?></td>
                                        <td id='TABLA_ANO_GMM_ter_en_tiempo' style="text-align:center;"><?=$tablaGmm[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_GMM_ter_no_tiempo' style="text-align:center;"><?=$tablaGmm[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_ANO_GMM_pend_en_tiempo' style="text-align:center;"><?=$tablaGmm[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_ANO_GMM_pend_no_tiempo' style="text-align:center;"><?=$tablaGmm[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td  style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_ANO_GMM_Totales' style="text-align:center;min-width: 48px;"><?=$tablaGmm[0]['Total']?></td>
                                        <td id='TABLA_ANO_GMM_Terminados' style="text-align:center;" colspan="2"><?=$tablaGmm[0]['ter_no_tiempo']+$tablaGmm[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_GMM_Pendientes' style="text-align:center;" colspan="2"><?=$tablaGmm[0]['pend_en_tiempo']+$tablaGmm[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <a id="btnfilter-TABLA_ANO_GMM2" data-date="" data-setmonth='0' data-setyear='1' class="bn-open-filter pull-right" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS POR AÑO-GMM" data-chart-name="TABLA_ANO_GMM2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id="title_TABLA_ANO_GMM2">PORCENTAJES MOVIMIENTOS POR AÑO-GMM-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
                    <?
                        $TotalGanos=$tablaGmm[0]['Total']==0?1:$tablaGmm[0]['Total'];
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_ANO_GMM_p_Total' style="text-align:center;"><?=round(($tablaGmm[0]['Total']/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaGmm[0]['ter_en_tiempo']/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaGmm[0]['ter_no_tiempo']/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaGmm[0]['pend_en_tiempo']/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaGmm[0]['pend_no_tiempo']/$TotalGanos)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_ANO_GMM_p_Totaless' style="text-align:center;"><?=round(($tablaGmm[0]['Total']/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaGmm[0]['ter_no_tiempo']+$tablaGmm[0]['ter_en_tiempo'])/$TotalGanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_GMM_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaGmm[0]['pend_en_tiempo']+$tablaGmm[0]['pend_no_tiempo'])/$TotalGanos)*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- modal del reporte de estatus siniestros -->
<div class="modal fade" id="modal_tablero" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Información de los siniestros</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="test">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="Tableros_siniestros">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Estatus</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Progreso</th>
                                        <th style="text-align: center;" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right" id="descarga_tablero">
                         <a class="btn btn-primary" data-permiso="permiso" data-accion-permiso="Nuevo" href="<?=base_url()?>tableros_siniestros/printExcelRegistros">Descargar</a>
                    </div>
                </div>
            </div>
    </div>
</div>

<!-- modal del reporte de rangos siniestros -->
<div class="modal fade" id="modal_tablero_rango" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Información de los siniestros</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    
                </div>
                <div class="modal-body" id="test">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table" id="Tableros_siniestros_rangos">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Estatus</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Progreso</th>
                                        <th style="text-align: center;" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right" id="descarga_tablero_rango">
                         <a class="btn btn-primary" data-permiso="permiso" data-accion-permiso="Nuevo" href="<?=base_url()?>tableros_siniestros/printExcelRegistros">Descargar</a>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="js-modal-filter">
</div>
<div class="modaldetalle"></div>

