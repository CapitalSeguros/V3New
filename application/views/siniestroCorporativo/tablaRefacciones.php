<table class="table">
    <thead>
        <tr>
            <th style="width: 150px;">Num de refaccion</th>
            <th>Pieza</th>
            <th style="width: 150px;">Fecha recibida</th>
            <!-- <th>Opciones</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if (count($refacciones) == 0) : ?>
            <tr>
                <td colspan="3" class="text-center">No se han cargado refacciones</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($refacciones as $value) : ?>
            <tr>
                <td>
                    <?= $value['num_refaccion'] ?>
                </td>
                <td>
                    <?= $value['pieza'] ?>
                </td>
                <td>
                    <?= date('d-m-Y',strtotime($value['fecha_add'])) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>