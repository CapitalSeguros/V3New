<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3 class="titulo-secciones">Evaluaciones   </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <ol class="breadcrumb text-left">
                <?= $breadcrumbs; ?>
            </ol>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 ">
        </div>
    </div>
</section>
<hr />
<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">

        <tbody>
            <?php foreach ($pendientes as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?=($value->fecha_finalizacion == null ? "label-success" : "label-primary") ?>"><?= ($value->fecha_finalizacion == null ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                    <td class="issue-info">
                        <a><?= $value->titulo ?></a>
                        <small><?= $value->empleado ?></small>
                    </td>
                    <td><i class="fa fa-clock-o"></i> <?= (!isset($value->fecha_aplicacion) ? "0000-00-00 00:00" : $value->fecha_aplicacion) ?></td>
                    <td><i class="fa fa-clock-o"></i> <?= (!isset($value->fecha_finalizacion) ? "0000-00-00 00:00" : $value->fecha_finalizacion) ?></td>
                    <td>
                        <a href="<?= base_url() . "evaluaciones/aplicar/$value->id" ?>" class="btn btn-default btn-sm">Ver</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>

<div class="js-modal-configurar"></div>