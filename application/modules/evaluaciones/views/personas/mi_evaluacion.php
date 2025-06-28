<section class="container-fluid">
    <table class="table table-striped issue-tracker" id="tbEvaluacion">
        <tbody>
            <?php foreach ($mis_evaluaciones as $key => $value) : ?>
                <tr>
                    <td width="100"> <span class="label <?= ($value->complete ? "label-primary" : "label-success") ?>"><?= ($value->complete ?  "COMPLETADO" : "PENDIENTE") ?></span></td>
                    <td class="issue-info">
                        <a><?= $value->titulo ?></a>
                    </td>
                    <td>
                        <a>Fecha inicio: <?= $value->fecha_inicio ?></a><br>
                        <a>Fecha fin: <?= $value->fecha_final ?></a>
                    </td>
                    <?php foreach ($promedio as $key => $val) : ?>
                        <?php if ($value->evaluacion_id==$val['id']) : ?>
                            <td>
                               <a>Resultado: <?=round($val["promedio"],2) ?> %</a>
                            </td>
                        <?php endif; ?>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</section>