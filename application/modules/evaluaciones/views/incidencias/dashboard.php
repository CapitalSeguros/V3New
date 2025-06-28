<section class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico3["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico3["HTML"] ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico2["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico2["HTML"] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico1["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico1["HTML"] ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico4["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico4["HTML"] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico5["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico5["HTML"] ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico6["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico6["HTML"] ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <?= $grafico7["ACCION"] ?>
                    </div>
                </div>
                <div class="panel-body">
                    <?= $grafico7["HTML"] ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <a class="bn-open-filter" style="color:white;" data-filter="empresa,periodos" data-chart-title="REPORTE BONOS" data-chart-name="REPORTE_BONO" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-center">REPORTE DE BONOS</h5>
                            <table class="table" id="graficos_REPORTE_BONO">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Calificación</th>
                                        <th scope="col">Bono</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel text-right">
                        <a class="bn-open-filter" style="color:white;" data-filter="empresa,colaborador,puesto,periodos" data-chart-title="REPORTE EVALUACIONES" data-chart-name="REPORTE_EVALUACIONES" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="text-center">REPORTE DE EVALUACIONES</h5>
                            <table class="table" id="graficos_REPORTE_EVALUACIONES">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Calificación</th>
                                        <th scope="col">Puesto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="js-modal-filter">
</div>
<div class="modaldetalle"></div>