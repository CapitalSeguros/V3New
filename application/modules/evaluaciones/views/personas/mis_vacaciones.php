<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php foreach ($solicitud_vacaciones as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?= ($value->estatus == "ACTIVO" ? "label-success" : "label-primary") ?>"><?= ($value->estatus == "ACTIVO" ? "PENDIENTE" : "COMPLETADO") ?></span></td>
                    <td class="issue-info">
                        <a><?= $value->nombre ?></a>
                    </td>
                    <td class="issue-info">
                        <small>Dias solicitados: <?= $value->dias ?></small>
                    </td>
                    <td class="issue-info">
                        <small>Fecha inicio: <?= date("d/m/Y", strtotime($value->fecha_inicio)) ?></small>
                        <small>Fecha Autorización: <?= (!isset($value->fecha_autorizacion) ? "En proceso" : date("d/m/Y", strtotime($value->fecha_autorizacion))) ?></small>
                    </td>
                    <td width="70">
                        <a href="#" onclick="getIncidenciaHistorial(event,<?= $value->idincidencias ?>)" class="btn btn-sm js-show-message"><i class="fa fa-comments" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>
