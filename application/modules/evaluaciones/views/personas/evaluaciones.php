<h4>Evaluaciones</h4>
<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php var_dump($pendientes);?>
            <?php foreach ($pendientes as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?= ($value->fecha_finalizacion == null ? "label-success" : "label-primary") ?>"><?= ($value->fecha_finalizacion == null ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                    <td class="issue-info">
                        <a><?= $value->titulo ?></a>
                        <small><?= $value->empleado ?></small>
                    </td>
                    <td class="issue-info">
                        <small>Aplicación: <?= (!isset($value->fecha_aplicacion) ? "" : date("d-m-Y, g:i a", strtotime($value->fecha_aplicacion))) ?></small>
                        <small>Finalización: <?= (!isset($value->fecha_finalizacion) ? "" : date("d-m-Y, g:i a", strtotime($value->fecha_finalizacion))) ?></small>
                    </td>

                    <td>
                        <a href="<?= base_url() . "evaluaciones/aplicar/$value->id" ?>" class="btn btn-default btn-sm">Ver</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>