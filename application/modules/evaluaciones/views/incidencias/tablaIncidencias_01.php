<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Incidencias</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
                <a href="<?= base_url() . 'incidencias/cargar_documento' ?>" class="btn btn-primary btn-sm">Cargar masiva</a>
                <a href="#" onclick="reProcesar(event)" class="btn btn-primary btn-reprocesar btn-sm">Re-procesar</a>
                <a href="#" class="btn btn-primary openModal btn-sm" data-in-mode="normal">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Tipo de incidencia</th>
                                    <th style="text-align: center;" scope="col">Fecha</th>
                                    <th style="text-align: center;" scope="col">Dias</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
    </div>
</section>


<!-- Modal para ver la información de las incidencias -->
<div id="mymodal" class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header titulos">
                <h4 class="modal-title" id="exampleModalLabel">Información de la incidencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <input type="hidden" id="id_incidencia" name="id_incidencia" />
                    <input type="hidden" id="id_justificado" name="id_justificado" />
                    <dt class="col-sm-2 text-right">Empleado:</dt>
                    <dd class="col-sm-4">
                        <div id="nombre"></div>
                    </dd>
                    <dt class="col-sm-2 text-right">Fecha de inicio:</dt>
                    <dd class="col-sm-1">
                        <div id="inicio"></div>
                    </dd>
                    <dt class="col-sm-2 text-right">Duración en días:</dt>
                    <dd class="col-sm-1">
                        <div id="dias"></div>
                    </dd>
                    <dt class="col-sm-2 text-right">Tipo de incidencia:</dt>
                    <dd class="col-sm-4">
                        <div id="tipo"></div>
                    </dd>
                    <dt class="col-sm-2 text-right">Fecha de captura:</dt>
                    <dd class="col-sm-4">
                        <div id="subida"></div>
                    </dd>
                    <dt class="col-sm-2 text-right">Documento:</dt>
                    <dd class="col-sm-9">
                        <div id="documentos">&nbsp;</div>
                    </dd>
                    <dt class="col-sm-2 text-right">Comentario:</dt>
                    <dd class="col-sm-9">
                        <div id="comentario"></div>
                    </dd>
                </dl>
                <div class="row" id="respuestaContenido">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label titulos">Acciones a realizar:</label>
                                    <select name="accion" id="accion" class="form-control input-sm is-invalid" required>
                                        <option value="" selected disabled>Seleccione una opción</option>
                                        <option value="1" name="aprobar">APROBAR</option>
                                        <option value="2" name="rechazar">RECHAZAR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Estatus">Escriba un comentario referente:</label>
                                    <textarea style="height: 100px" id="comentario" name="comentario" class="form-control input-sm" placeholder="Escriba Aqui" value="<?= set_value('smsText') ?>"><?= $this->input->post('smsText', true) ?></textarea>
                                    <?= form_error('smsText') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--final del form modal-->
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button id="enviar" disabled onclick="ValidaciondeIncidencia()" class="btn btn-primary">Enviar respuesta</button>
            </div>
        </div>
    </div>

    <div id="vOptions" data-min-date="<?= $minDayVacation ?>" data-start-block="<?= $startBlock ?>" data-days-block="<?= $daysBlock ?>"></div>
</div>
<div class="js-incidencias"></div>
<div class="js-preview"></div>
<div class="modal-seguimiento-container"></div>