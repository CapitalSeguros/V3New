<?php
$puesto = "";
$puestoN = "";
?>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Evaluaciones del período: <?= $InfoPeriodo[0]->titulo ?></h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <table class="table table-striped issue-tracker" id="table-evs">
            <tbody>
                <?php foreach ($evals as $key => $value) : ?>
                    <tr class="group">
                        <td class="tb-padding" colspan="3">
                            <span><strong>Nombre de la evaluación: <?= $value["evaluacion"] ?></strong></span>
                            <div style="float:right; margin-right: 25px; display: inline-block;">
                                <div>Encuestas completas: <?= $value["result"][0]->total - $value["result"][0]->completas ?> de <?= $value["result"][0]->total ?> </div>
                                <div>Porcentaje: <?= ($value["result"][0]->total - $value["result"][0]->completas) * 100 / $value["result"][0]->total ?> de 100% </div>
                            </div>
                        </td>
                    </tr>
                    <tr role="row" class="odd">
                        <td class="tb-padding">
                            <table class="table table-condensed tb-table">
                                <?php foreach ($value["empleados"] as $k => $v) : ?>
                                    <tbody>
                                        <?php if ($v->puesto_id != $puesto) {
                                            $puesto = $v->puesto_id;
                                            $puestoN = in_array($v->puesto_id, $ranks) ? $ranksRel[$v->puesto_id] : $v->puesto;
                                            //$puestoN=$v->puesto_id;
                                        ?>
                                            <tr>
                                                <td colspan="6">Puesto: <?= $puestoN ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td width="100"> <span class="label <?= (intval($v->calificacion) <= 0 ? "label-success" : "label-primary") ?>"><?= (intval($v->calificacion) <= 0 ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                                            <!-- <td class="issue-info">
                                                <a>Evaluacion: <?= $v->titulo ?></a>
                                            </td> -->
                                            <td class="issue-info">
                                                <a>Evaluador: <?= $v->evaluador != null ? $v->evaluador : 'N/A' ?></a>
                                            </td>
                                            <td class="issue-info">
                                                <a>Evaluado: <?= $v->empleado ?></a>
                                            </td>
                                            <td class="issue-info">
                                                <small>Fecha aplicación: <?= $v->fecha_aplicacion != NULL ? date("d/m/Y", strtotime($v->fecha_aplicacion)) : 'N/A' ?></small>
                                                <small>Fecha finalización: <?= $v->fecha_aplicacion != NULL ? date("d/m/Y", strtotime($v->fecha_finalizacion)) : 'N/A' ?></small>
                                            </td>
                                            <td class="issue-info">
                                                <small>Calificación: <?= round($v->calificacion, 2) ?></small>
                                            </td>
                                            <td width="70">
                                                <a href="<?= base_url() . "evaluaciones/resultado_completo/$v->periodo_id/$v->empleado_id" ?>" target="_blank" class="btn btn-sm" title="Ver evaluacion"><i class="fa fa-file-text" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</section>