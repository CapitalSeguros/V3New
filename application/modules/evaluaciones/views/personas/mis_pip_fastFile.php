<div class="row">
    <div class="col-md-6">
        <section class="container-fluid">
            <span>Seguimiento del Año: <?= $years[0] ?></span>
            <table class="table table-striped issue-tracker" id="tbPip">
                <tbody>
                    <?php if (count($pipsActual) == 0) : ?>
                        <tr>
                            <td class="issue-info">
                                <b>No existen seguimientos</b>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($pipsActual as $key => $value) : ?>
                        <tr>
                            <td class="issue-info">
                                <b> Seguimiento a :</b> <?= $value["nombre"] ?> <br>
                                <b>Fecha:</b> <?= date('d/m/Y', strtotime($value["created"])) ?> <b> Periodo: </b><?= $value["titulo"] == '' ? 'Sin periodo' : $value["titulo"] ?>.
                            </td>
                            <td width="70">
                                <div style="text-align: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dpPIP<?= $value["id"] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dpPIP<?= $value["id"] ?>">
                                            <li><a href="<?= base_url() . "PIP/MonitoreoPIP?id=" . $value["id"] ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Seguimiento</a></li>
                                            <!--  <li><a href="<?= base_url() . "PIP/AgregarPIP?id=" . $value["empleado_id"] . "&idp=" . $value["id"] . "&idpp=0" ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Editar</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </div>
    <div class="col-md-6">
        <section class="container-fluid">
            <span>Seguimiento del Año: <?= $years[1] ?></span>
            <table class="table table-striped issue-tracker" id="tbPip">
                <tbody>
                    <?php if (count($pipsPast) == 0) : ?>
                        <tr>
                            <td class="issue-info">
                                <b>No existen seguimientos</b>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($pipsPast as $key => $value) : ?>
                        <tr>
                            <td class="issue-info">
                                <b> Seguimiento a :</b> <?= $value["nombre"] ?> <br>
                                <b>Fecha:</b> <?= date('d/m/Y', strtotime($value["created"])) ?> <b> Periodo: </b><?= $value["titulo"] == '' ? 'Sin periodo' : $value["titulo"] ?>.

                            </td>
                            <td width="70">
                                <div style="text-align: center;">
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dpPIP<?= $value["id"] ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dpPIP<?= $value["id"] ?>">
                                            <li><a href="<?= base_url() . "PIP/MonitoreoPIP?id=" . $value["id"] ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Seguimiento</a></li>
                                            <!-- <li><a href="<?= base_url() . "PIP/AgregarPIP?id=" . $value["empleado_id"] . "&idp=" . $value["id"] . "&idpp=0" ?>" style="cursor: pointer;" data-in-id="<?= $value["id"] ?>">Editar</a></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </div>
</div>