<?php
//fechas para los titulos de las graficas
setlocale(LC_ALL,"es_ES");
$string = "24/11/2014";
$date = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));
$mesL=strtoupper(strftime("%b",$date->getTimestamp()));

//var_dump($tablaAutosmes);
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

    .title-infoS {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .btnACt {
        float: right;
        margin-right: 15px;
        margin-top: 20px;
    }

    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }

    .Siniestro-body {
        display: inline-block;
    }

    .box.first {
        float: left;
    }

    .edit {
        margin-bottom: unset !important;
    }

    /* test */
    [aria-label="Tipo"]{
        width:unset !important;
    }
    
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <h3 class="titulo-secciones">Tablero de siniestros</h3>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3" style="float: right;">
        <?php if(count($clientes)>1): ?>
            <div class="form-group">
                <label>Cliente</label>
                <select class="form-control" name="clientes" id="clientes">
                    <option value="0">Todos</option>
                    <?php foreach($clientes as $key=>$value): ?>
                        <option value="<?php echo $value["id"]?>"><?php echo $value["nombre"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php else :?>
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li class="active">Tablero</li>
                <li><a href="<?= base_url() ?>Siniestros/registros">Registro de siniestros</a></li>
            </ol>
        <?php endif;?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
    <div style="float: left; width: 90%;">
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Total de registros</div>
                <div class="panel-body">
                   <div class="row">
                        <div class="col-sm-12 text-center">
                            <div class="tituloP"><?= $DataSiniestros[0]["total"] ?></div>
                            <div>Registros</div>
                           <!--  <div id="element2" class="labelM"><?= $DataSiniestros[0]["total"] ?> <br> <div id="Total">Registros</div></div> -->
                        </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Estado de los registros</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["ACTIVO"] ?></div>
                            <div>ACTIVO</div>
                            <!-- <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["EN TRAMITE"] ?><br><div id="Tramite" style="word-break: break-all;">En trámite</div></div> -->
                            
                        </div>
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["FINIQUITADO"] ?></div>
                            <div>FINIQUITADO</div>
                            <!-- <div id="element2" class="labelM text-center"><b> </b><br> <div id="Avisado">Avisados</div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["RECHAZADO"] ?></div>
                            <div>RECHAZADO</div>
                          <!--   <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["CONDICIONADO"] ?><br> <div id="Condicionado">Condicionado</div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["DESISTIMIENTO"] ?></div>
                            <div>DESISTIMIENTO</div>
                          <!--   <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["LIQUIDADO"] ?> <br><div id="Liquidado">Liquidados </div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["DORMIDO"] ?></div>
                            <div>DORMIDO</div>
                           <!--  <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["VACIOS"] ?> <br><div id="Liquidado">Sin estatus </div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                            <div style="font-size: 20px;"><?= $DataSiniestros[0]["N/A"] ?></div>
                            <div>N/A</div>
                           <!--  <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["VACIOS"] ?> <br><div id="Liquidado">Sin estatus </div></div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-default" >
                <div class="panel-heading">Última actualización</div>
                <div class="panel-body">
                    <div class="text-center"><?= $lastupdate ?></div>
                   <!--  <div id="element2" class="labelM"><?= $lastupdate ?></div> -->
                </div>
            </div>
        </div>
    </div>
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
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>RANGO DE DÍAS DE RESPUESTA-<?=$mesL?>-<?=date('Y')?></h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="empresa" data-chart-title="REPORTE BONOS" data-chart-name="REPORTE_BONO" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_PERIODO_TERMINO">
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
                            <div class="hijo">
                            <?= $grafico5["HTML"] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>ESTATUS DE LOS SINIESTROS POR MESES-<?=date('Y')?></h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="fecha" data-chart-title="ESTATUS DE LOS SINIESTROS POR MESES" data-chart-name="ESTATUS_MESES_C" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_ESTATUS_MESES">
                                <thead style="font-size: 10px;">
                                    <tr id="Head-T">

                                    </tr>
                                </thead>
                                <tbody>
                                <tfoot>
                                    <tr id="F_tabla_3">

                                    </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>CORTE DE SINIESTROS</h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="fecha" data-chart-title="CORTE SINIESTROS" data-chart-name="CORTE_SINIESTROS_C" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                    <input type="hidden" id="test" value="">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_REPORTE_TIPO_SINIESTRO">
                                <thead style="font-size: 10px;">
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr id="F_tabla_2">

                                    </tr>
                                </tfoot>
                            </table>
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
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_MES_AUTOSC" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR MES-AUTOS CORPORATIVO" data-chart-name="TABLA_MES_AUTOSC" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart" data-date="" data-setmonth='1' data-setyear='1'><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_TABLA_MES_AUTOSC'>MOVIMIENTOS POR MES-AUTOS CORPORATIVO-<?=$mesL?>-<?=date('Y')?></h5>
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
                                        <td id='TABLA_MES_AUTOSC_Total' style="text-align:center;min-width: 48px;"><?=$tablaAutosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_AUTOSC_ter_no_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOSC_ter_en_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOSC_pend_en_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOSC_pend_no_tiempo' style="text-align:center;"><?=$tablaAutosmes[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_MES_AUTOSC_Totales' style="text-align:center;min-width: 48px;"><?=$tablaAutosmes[0]['Total']?></td>
                                        <td id='TABLA_MES_AUTOSC_Terminados' style="text-align:center;" colspan="2"><?=$tablaAutosmes[0]['ter_no_tiempo']+$tablaAutosmes[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_MES_AUTOSC_Pendientes' style="text-align:center;" colspan="2"><?=$tablaAutosmes[0]['pend_en_tiempo']+$tablaAutosmes[0]['pend_no_tiempo']?></td>
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
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_MES_AUTOSC2" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS MES-AUTOS CORPORATIVO" data-chart-name="TABLA_MES_AUTOSC2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='1' data-setyear='1'></a>
                        <h5 id='title_TABLA_MES_AUTOSC2'>PORCENTAJES MOVIMIENTOS MES-AUTOS CORPORATIVO-<?=$mesL?>-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
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
                                    <?
                                        $TotalAmes=$tablaAutosmes[0]['Total']==0?1:$tablaAutosmes[0]['Total'];
                                    ?>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_MES_AUTOSC_p_Totales' style="text-align:center;"><?=round(($tablaAutosmes[0]['Total']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['ter_no_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['ter_en_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['pend_en_tiempo']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaAutosmes[0]['pend_no_tiempo']/$TotalAmes)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_MES_AUTOSC_p_Totaless' style="text-align:center;"><?=round(($tablaAutosmes[0]['Total']/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaAutosmes[0]['ter_no_tiempo']+$tablaAutosmes[0]['ter_en_tiempo'])/$TotalAmes)*100,2)?>%</td>
                                        <td id='TABLA_MES_AUTOSC_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaAutosmes[0]['pend_en_tiempo']+$tablaAutosmes[0]['pend_no_tiempo'])/$TotalAmes)*100,2)?>%</td>
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
                        <a class="bn-open-filter pull-right"  id="btnfilter-TABLA_ANO_AUTOSC"  data-date="" data-setmonth='0' data-setyear='1' style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="MOVIMIENTOS POR AÑO-AUTOS CORPORATIVO" data-chart-name="TABLA_ANO_AUTOSC" data-uri-filter="<?php echo base_url(); ?>tableros_siniestros/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                        <h5 id='title_TABLA_ANO_AUTOSC'>MOVIMIENTOS POR AÑO-AUTOS CORPORATIVO-<?=date('Y')?></h5>
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
                                        <td id='TABLA_ANO_AUTOSC_Total' style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td id='TABLA_ANO_AUTOSC_ter_no_tiempo' style="text-align:center;"><?=$tablaAutos[0]['ter_no_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOSC_ter_en_tiempo' style="text-align:center;"><?=$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOSC_pend_en_tiempo' style="text-align:center;"><?=$tablaAutos[0]['pend_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOSC_pend_no_tiempo' style="text-align:center;"><?=$tablaAutos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td id='TABLA_ANO_AUTOSC_Totales' style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td id='TABLA_ANO_AUTOSC_Terminados' style="text-align:center;" colspan="2"><?=$tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td id='TABLA_ANO_AUTOSC_Pendientes' style="text-align:center;" colspan="2"><?=$tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo']?></td>
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
                        <a class="bn-open-filter pull-right" id="btnfilter-TABLA_ANO_AUTOSC2" style="color:white;margin-top: -5px" data-filter="fecha" data-chart-title="PORCENTAJES MOVIMIENTOS AÑO-AUTOS CORPORATIVO" data-chart-name="TABLA_ANO_AUTOSC2" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart" data-date="" data-setmonth='0' data-setyear='1'></a>
                        <h5 id='title_TABLA_ANO_AUTOSC2'>PORCENTAJES MOVIMIENTOS AÑO-AUTOS CORPORATIVO-<?=date('Y')?></h5>
                    </div>
                </div>
                <div class="panel-body">
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
                                    <?
                                        $TotalAanos=$tablaAutos[0]['Total']==0?1:$tablaAutos[0]['Total'];
                                    ?>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td id='TABLA_ANO_AUTOSC_p_Total' style="text-align:center;"><?=round(($tablaAutos[0]['Total']/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_ter_no_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['ter_no_tiempo']/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_ter_en_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['ter_en_tiempo']/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_pend_en_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['pend_en_tiempo']/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_pend_no_tiempo' style="text-align:center;"><?=round(($tablaAutos[0]['pend_no_tiempo']/ $TotalAanos)*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td id='TABLA_ANO_AUTOSC_p_Totaless' style="text-align:center;"><?=round(($tablaAutos[0]['Total']/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_Terminados' style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo'])/ $TotalAanos)*100,2)?>%</td>
                                        <td id='TABLA_ANO_AUTOSC_p_Pendientes' style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo'])/ $TotalAanos)*100,2)?>%</td>
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
