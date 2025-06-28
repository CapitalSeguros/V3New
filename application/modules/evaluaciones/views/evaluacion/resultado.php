<?php
$total = array_sum(array_map(function ($it) {
    return $it["total"];
}, $evaluacion_incidencias));

$total = ($total / count($evaluacion_incidencias) * 100);
$cnIncidencia = array_filter($evaluaciones, function ($it) {
    return $it->tipo_evaluacion_id == 2;
});
$cnIncidencia = @$cnIncidencia[key($cnIncidencia)];

$cnFunciones = array_filter($evaluaciones, function ($it) {
    return $it->tipo_evaluacion_id == 1;
});
$cnFunciones = @$cnFunciones[key($cnFunciones)];

$cnCompetencia = array_filter($evaluaciones, function ($it) {
    return $it->tipo_evaluacion_id == 3;
});
$cnCompetencia = @$cnCompetencia[key($cnCompetencia)];

$cn360 = array_filter($evaluaciones, function ($it) {
    return $it->tipo_evaluacion_id == 4;
});
$cn360 = @$cn360[key($cn360)];

$cnOtra = array_filter($evaluaciones, function ($it) {
    return $it->tipo_evaluacion_id == 5;
});
$cnOtra = @$cnOtra[key($cnOtra)];
?>

<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Resultado</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
<!--   <?var_dump($otra)?> -->
    <div  style="float: left; width: 90%;">
        <ul class="nav nav-tabs" role="tablist">
            <?php if ($cnIncidencia != null) : ?>
                <li role="presentation" class="<?=$order[0]=="incidencias"?"active":'' ?>" ><a href="#incidencias" aria-controls="incidencias" role="tab" data-toggle="tab">Incidencias</a></li>
            <?php endif; ?>
            <?php if ($cnFunciones != null) : ?>
                <li role="presentation" class="<?=$order[0]=="funciones"?"active":'' ?>"><a href="#funciones" aria-controls="funciones" role="tab" data-toggle="tab">Funciones</a></li>
            <?php endif; ?>
            <?php if ($cnCompetencia != null) : ?>
                <li role="presentation" class="<?=$order[0]=="competencias"?"active":'' ?>"><a href="#competencias" aria-controls="competencias" role="tab" data-toggle="tab">Competencias</a></li>
            <?php endif; ?>
            <?php if ($cn360 != null) : ?>
                <li role="presentation" class="<?=$order[0]=="c360"?"active":'' ?>"><a href="#trco" aria-controls="trco" role="tab" data-toggle="tab">360</a></li>
            <?php endif; ?>
            <?php if ($cnOtra != null) : ?>
                <li role="presentation" class="<?=$order[0]=="otra"?"active":'' ?>"><a href="#trco" aria-controls="trco" role="tab" data-toggle="tab">Otra</a></li>
            <?php endif; ?>
        </ul>
        <div class="tab-content">
            <?php if ($cnIncidencia != null) : ?>
                <div role="tabpanel" class="tab-pane <?=$order[0]=="incidencias"?"active":'' ?>" id="incidencias">
                    <h3><?= $cnIncidencia->titulo ?></h3>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4>Calificación final: <?= round($total, 2, PHP_ROUND_HALF_UP) . ' %' ?></h4>
                                </div>
                                <div class="col-md-3">
                                    <h4> <span class="pull-right">Dias laborales: <?= $nDias ?></span></h4>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-offset-2 col-md-8">
                                    <ul class="media-list">
                                        <?php foreach ($evaluacion_incidencias as $key => $value) : ?>
                                            <li class="media">
                                                <div class="media-body">
                                                    <h4 class="media-heading"><?= $value["titulo"] ?></h4>
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row tabla-principal">
                                                                <div class="col-md-11 text-center"><?= $value["subtitulo"] ?></div>
                                                                <div class="col-md-1 text-center"><?= $value["dias"] ?></div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-11 text-center"><?= $value["subtitulo_1"] ?></div>
                                                                <div class="col-md-1 text-center"><?= $value["dias_laborados"] ?></div>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-1 text-right">
                                                            <strong><?= round(($value["total"] * 100), 2) . ' %' ?></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if ($cnFunciones != null) : ?>
               <!--  <?var_dump($order)?> -->
                <div role="tabpanel" class="tab-pane <?=$order[0]=="funciones"?"active":'' ?>" id="funciones">
                    <h3><?= $cnFunciones->titulo ?></h3>
                     <div class="row">
                        <div class="col-md-12">
                            <section class="container-fluid">
                                <table class="table table-striped issue-tracker" id="tbEvaluacion">
                                    <tbody>
                                        <?php foreach ($funciones as $key => $value) : ?>
                                            <tr>
                                                <td width="100"> <span class="label <?= ($value->complete == 0 ? "label-success" : "label-primary") ?>"><?= ($value->complete == 0 ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                                                <td class="issue-info">
                                                    <a><?= $value->titulo ?></a>
                                                    <small>Evaluado: <?= $value->evaluado; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <a></a><br>
                                                    <small>Evaluador: <?= $value->name_complete; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Fecha aplicación: <?= $value->fecha_aplicacion?date("d/m/Y", strtotime($value->fecha_aplicacion)):'N/A' ?></small>
                                                    <small>Fecha finalización:<?=$value->fecha_finalizacion?date("d/m/Y", strtotime($value->fecha_finalizacion)):'N/A' ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Calificación: <?= round($value->calificacion, 2) ?></small>
                                                </td>
                                                <td width="70">
                                                    <a href="#" class="btn btn-sm js-show-message" data-item-id="<?= $value->id ?>" title="Ver evaluacion"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($cnCompetencia != null) : ?>
                <!-- <?php var_dump($cnCompetencia)?> -->
                <div role="tabpanel" class="tab-pane <?=$order[0]=="competencias"?"active":'' ?>" id="competencias">
                    <h3><?= $cnCompetencia->titulo ?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="container-fluid">
                                <table class="table table-striped issue-tracker" id="tbEvaluacion">
                                    <tbody>
                                    <!-- <?var_dump($competencias)?> -->
                                        <?php foreach ($competencias as $key => $value) : ?>
                                            <tr>
                                                <td width="100"> <span class="label <?= ($value->complete == 0 ? "label-success" : "label-primary") ?>"><?= ($value->complete == 0 ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                                                <td class="issue-info">
                                                    <a><?= $value->titulo ?></a>
                                                    <small>Evaluado: <?= $value->evaluado; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <a></a><br>
                                                    <small>Evaluador: <?= $value->name_complete; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Fecha aplicación: <?= date("d/m/Y", strtotime($value->fecha_aplicacion)) ?></small>
                                                    <small>Fecha finalización: <?= date("d/m/Y", strtotime($value->fecha_finalizacion)) ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Calificación: <?= round($value->calificacion, 2) ?></small>
                                                </td>
                                                <td width="70">
                                                    <a href="#" class="btn btn-sm js-show-message" data-item-id="<?= $value->id ?>" title="Ver evaluacion"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($cn360)) : ?>
                <div role="tabpanel" class="tab-pane <?=$order[0]=="c360"?"active":'' ?>" id="trco">
                    <h3><?= $cn360->titulo ?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="container-fluid">
                                <table class="table table-striped issue-tracker" id="tbEvaluacion">
                                    <tbody>
                                        <?php foreach ($c360 as $key => $value) : ?>
                                            <tr>
                                                <td width="100"> <span class="label <?= ($value->complete == 0 ? "label-success" : "label-primary") ?>"><?= ($value->complete == 0 ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                                                <td class="issue-info">
                                                    <a><?= $value->titulo ?></a>
                                                    <small>Evaluado: <?= $value->evaluado; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <a></a><br>
                                                    <small>Evaluador: <?= $value->name_complete; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Fecha aplicación: <?= date("d/m/Y", strtotime($value->fecha_aplicacion)) ?></small>
                                                    <small>Fecha finalización: <?= date("d/m/Y", strtotime($value->fecha_finalizacion)) ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Calificación: <?= round($value->calificacion, 2) ?></small>
                                                </td>
                                                <td width="70">
                                                    <a href="#" class="btn btn-sm js-show-message" data-item-id="<?= $value->id ?>" title="Ver evaluacion"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
               <!--  <?php var_dump($c360)?> -->
            <?php endif; ?>
            <?php if (isset($cnOtra)) : ?>
                <div role="tabpanel" class="tab-pane <?=$order[0]=="otra"?"active":'' ?>" id="trco">
                    <h3><?= $cnOtra->titulo ?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <section class="container-fluid">
                                <table class="table table-striped issue-tracker" id="tbEvaluacion">
                                    <tbody>
                                        <?php foreach ($otra as $key => $value) : ?>
                                            <tr>
                                                <td width="100"> <span class="label <?= ($value->complete == 0 ? "label-success" : "label-primary") ?>"><?= ($value->complete == 0 ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                                                <td class="issue-info">
                                                    <a><?= $value->titulo ?></a>
                                                    <small>Evaluado: <?= $value->evaluado; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <a></a><br>
                                                    <small>Evaluador: <?= $value->name_complete; ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Fecha aplicación: <?= date("d/m/Y", strtotime($value->fecha_aplicacion)) ?></small>
                                                    <small>Fecha finalización: <?= date("d/m/Y", strtotime($value->fecha_finalizacion)) ?></small>
                                                </td>
                                                <td class="issue-info">
                                                    <small>Calificación: <?= round($value->calificacion, 2) ?></small>
                                                </td>
                                                <td width="70">
                                                    <a href="#" class="btn btn-sm js-show-message" data-item-id="<?= $value->id ?>" title="Ver evaluacion"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </section>
                        </div>
                    </div>
                </div>
               <!--  <?php var_dump($c360)?> -->
            <?php endif; ?>
        </div>
    </div>
</section>