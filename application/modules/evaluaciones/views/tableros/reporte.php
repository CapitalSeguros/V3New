<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Tablero</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="col-md-6">
                <?= $incidencia_mensual["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $incidencia_trimestral["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $comparativo_col["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $rotacion_personal["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $crecimiento_periodo["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $evaluacion_competencia["HTML"] ?>
            </div>
            <div class="col-md-6">
                <?= $evaluacion_desempenio["HTML"] ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="menu-panel">
                            <h5>REPORTE DE BONOS
                                <a class="bn-open-filter pull-right" style="color:white;margin-top: -6px" data-filter="empresa,periodos" data-chart-title="REPORTE BONOS" data-chart-name="REPORTE_BONO" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                            </h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
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
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div class="menu-panel">
                            <h5>REPORTE DE EVALUACIONES
                                <a class="bn-open-filter pull-right" style="color:white;margin-top: -6px" data-filter="empresa,colaborador,puesto,periodos" data-chart-title="REPORTE EVALUACIONES" data-chart-name="REPORTE_EVALUACIONES" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                            </h5>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
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
    </div>

</section>

<div class="js-modal-filter">
</div>
<div class="modaldetalle"></div>

<div class="modal fade" id="mymodalgrafica" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--modal-lg -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
            </div>
            <div class="modal-body">
                <div id="descripcion_reporte">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>