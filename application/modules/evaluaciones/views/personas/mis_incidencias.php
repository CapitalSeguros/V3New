<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php foreach ($mis_incidencias as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?= ($value->estatus == "ACTIVO" ? "label-success" : "label-primary") ?>"><?= ($value->estatus == "ACTIVO" ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                    <td class="issue-info">
                        <a><?= $value->nombre ?></a>
                    </td>
                    <td class="issue-info">
                        <small>Fecha: <?= date("d/m/Y", strtotime($value->fecha_inicio)) ?></small>
                    </td>
                    <td width="70">
                        <a href="#" onclick="getIncidenciaHistorial(event,<?= $value->idincidencias ?>)" class="btn btn-sm js-show-message"><i class="fa fa-comments" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>