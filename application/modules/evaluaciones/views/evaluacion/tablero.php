<?php
$puesto = "";
?>
<style>
    .labelM {
        /* float: right; */
        font-size: 15px;
    }

    #element1 {
        float: left;
    }

    #element2 {
        padding-left: 20px;
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
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-9 col-sm-5 col-xs-5">
            <div class="col-md-12">
                <h3 class="titulo-secciones">Período: <?= $periodo->titulo ?> </h3>
            </div>
        </div>
        <div class="col-md-3 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Fechas de evaluación </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <i id="element1" class="fa fa-list-alt fa-2x" aria-hidden="true"></i>
                                <div id="element2" class="labelM">Inicio: <?= $periodo->fecha_inicio ?><div id="Total"> FIn: <?= $periodo->fecha_final ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Encuestas contestadas</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <i id="element1" class="fa fa-circle-o-notch fa-2x" aria-hidden="true"></i>
                                <div id="element2" class="labelM">Contestadas: <div id="Total"> <?= $totales[0]->total - $totales[0]->incomplete ?> de <?= $totales[0]->total ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Avance general</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <i id="element1" class="fa fa-check-circle-o fa-2x" aria-hidden="true"></i>
                                <div id="element2" class="labelM">Procentaje: <div id="Total"> <?= round(($totales[0]->total - $totales[0]->incomplete) * 100 / ($totales[0]->total ?: 1), 2) ?>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">Registro de resultados</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <i id="element1" class="fa fa-file-text-o fa-2x" aria-hidden="true"></i>
                                <div id="element2" class="labelM">Resultados: <div id="Total"> <a href="<?= base_url() ?>evaluaciones/tableroResultados/<?= $periodo->id ?>">Ir a resultados</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <table class="table  issue-tracker" id="table-evs">
            <tbody>
                <?php foreach ($usuarios as $key => $value) : ?>
                    <tr class="group">
                        <td class="tb-padding" colspan="3" style="background-color: #8370A1;color:white;">
                            <?php if (in_array($value["tipo"],$ranks)) : ?>
                                <span><strong>Ranking: <?= $ranksRel[$value["tipo"]] ?></strong></span>
                            <?php else: ?>
                                <span><strong>Puesto: <?= $value["Puesto"] ?></strong></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr class="group">
                        <td class="tb-padding" colspan="3" style="background-color: white;">
                            <span><strong>Evaluado: <?= $value["nombre"] ?></strong></span>
                            <div style="float: right;">Promedio general: <?= round($value["Promedio"], 2) ?>%</div>
                            <br>
                            <div style="float: right;">Bono por evaluación: <?= empty($value["bono"]) ? 'Ninguno' : "$" . $value["bono"]["sueldo"] . ".00" ?>.</div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="tb-padding">
                            <table class="table table-condensed tb-table">
                                <tbody>
                                    <!--  <tr><td  colspan="3">Evaluadores:</td></tr> -->
                                    <tr>
                                        <?php foreach ($value["PEvaluaciones"] as $k => $v) : ?>
                                            <td>
                                                Tipo evaluación: <?= $v["nombre"] ?><br>Promedio: <?= round($v["promedio"], 2) ?> % <br>Total de encuestas: <?= $v["total"] ?>
                                                <?php foreach ($Calificaciones as $k => $valr) : ?>
                                                    <!--  <br>Total de encuestas: <?= $valr["puesto_id"] ?> -->
                                                    <?php if ($valr["evaluacion_id"] == $v["id"] && $valr["puesto_id"] == $value["puestoid"]) : ?>
                                                        <br>Valor Requerido: <?= $valr["valor"] ?>%
                                                    <?php endif; ?>

                                                <?php endforeach; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</section>