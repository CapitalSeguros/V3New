<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Reporte de resultados</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7 hidden-print">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container-fluid text-result">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <dl class="dl-horizontal">
                        <dt>Nombre del colaborador:</dt>
                        <dd class=""><?= $persona->name_complete ?></dd>
                        <dt>Canal:</dt>
                        <dd>ESTRATEGICO</dd>
                        <dt>Puesto:</dt>
                        <dd><?= $persona->puesto->personaPuesto ?></dd>
                        <dt>Periodo evaluado:</dt>
                        <dd><?= $periodo->titulo ?> [<?= date("d/m/Y", strtotime($periodo->fecha_inicio)) ?> - <?= date("d/m/Y", strtotime($periodo->fecha_final)) ?>]</dd>
                        <dt>Jefe inmediator:</dt>
                        <dd><?= $jefe->name_complete ?></dd>
                        <dt>Evaluador:</dt>
                        <dd><?= $jefe->name_complete ?></dd>
                    </dl>
                    <hr>
                    <dl class="dl-horizontal">
                        <dt>Calificación obtenida:</dt>
                        <dd>
                            <h4><u><?= round($resultado->calificacion, 2) ?> %</u></h4>
                        </dd>
                    </dl>

                    <div class="row">
                        <div class="col-md-4 checkbox">
                            <label> <input type="checkbox" name="ckRetroalimentacion" id="ckRetroalimentacion"> <strong>¿Se dio retroalimentación al colaborador?</strong> </label>
                        </div>
                        <div class="col-md-4">
                            <dt>Fecha retroalimentación</dt>
                            <input type="text" class="input-no-border form-control" placeholder="Fecha de retroalimentación" name="txFecha" id="txFecha" />
                        </div>
                    </div>
                    <dt>Observaciones generales:</dt>
                    <dd><textarea class="form-control" name="txObservaciones" id="txObservaciones" cols="30" rows="3"></textarea></dd>
                    <dt>Acciones de Mejora:</dt>
                    <dd><textarea class="form-control" name="txObservaciones" id="txObservaciones" cols="30" rows="3"></textarea></dd>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="row ">
                            <div class="col-md-6 col-print-6 text-center print-horizontal-1">
                                <h5>Evaluador</h5>
                                <p><?= $jefe->name_complete ?></p>
                                <br />
                                __________________________________
                            </div>
                            <div class="col-md-6 col-print-6 text-center print-horizontal-2">
                                <h5>Colaborador</h5>
                                <p><?= $persona->name_complete ?></p>
                                <br />
                                __________________________________
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $("#txFecha").datepicker({
        changeMonth: true,
        changeYear: true,
        firstDay: 1,
        regional: "es",
        closeText: 'Cerrar',
        prevText: 'Anterior',
        nextText: 'Siguiente',
        dateFormat: 'dd/mm/yy',
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ],
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun",
            "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ],

    });
</script>