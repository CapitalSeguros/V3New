<table class="table" id="list-files">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Tipo</th>
            <th>Fecha Alta</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($documentos) == 0) : ?>
            <tr>
                <td  colspan="3" class="text-center">No se han cargado documentos</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($documentos as $value) : ?>
            <tr id="Row_<?= $value["nombre"] ?>">
                <td>
                    <?= $value["nombre"] ?>
                </td>
                <td>
                    <img src="<?= $value["url_icono"] ?>" alt="tipo">
                </td>
                <td>
                    <?= $value["fecha_alta"] ?>
                </td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Ver documento" onclick="window.open(' <?= $value['ruta'] ?>', 'hello', 'width=600,height=600');"><i class="fa fa-eye"> </i></a>
                        <a class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="deleteFile('Row_<?= $value['nombre'] ?>',<?= $value['id'] ?>)"><i class="fa fa-trash"> </i></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>