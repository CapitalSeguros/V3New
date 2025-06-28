<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php foreach ($bonos as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?= ($value->estatus == "AUTORIZADO" ? "label-success" : "label-primary") ?>"><?= $value->estatus ?></span></td>
                    <td class="issue-info">
                        <small>Importe Solicitado: $ <?= number_format(round($value->importe, 2), 2, '.', ',')  ?></small>
                        <small>Importe Autorizado: $ <?= number_format(round($value->importe_final, 2), 2, '.', ',') ?></small>
                    </td>
                    <td class="issue-info">
                        <small>Fecha solicitud: <?= date("d/m/Y", strtotime($value->fecha)) ?></small>
                        <small>Fecha Autorización: <?= date("d/m/Y", strtotime($value->fecha)) ?></small>
                    </td>
                    <td width="70">
                        <div style="text-align: center;">
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dpBono<?= $value->id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dpBono<?= $value->id ?>">
                                    <?php if ($value->estatus === "RECHAZADO") : ?>
                                        <li><a class="bn-sol-bono" data-in-eid="<?= $id; ?>" style="cursor: pointer;" data-in-reply="<?= $value->id ?>">Solicitar de nuevo</a></li>
                                    <?php endif; ?>
                                    <li><a onclick="getDataHistorial(<?= $value->id ?>)" style="cursor: pointer;" data-in-id="<?= $value->id ?>">Seguimiento</a></li>
                                </ul>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>