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
                <button onclick="reProcesar(event)" class="btn btn-primary btn-reprocesar btn-sm">Re-procesar</button>
                <button class="btn btn-primary openModal btn-sm" data-in-mode="normal">Nuevo</button>
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
                                    <th scope="col">Fecha Inicio</th>
                                    <th scope="col">Dias</th>
                                    <th scope="col">Empleado</th>
                                    <th scope="col">Registrado el</th>
                                    <!-- <th scope="col">Modificado el</th> -->
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
<div id="mymodal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header titulos">
                <h4 class="modal-title" id="exampleModalLabel">Información de la incidencia</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <input type="hidden" id="id_incidencia" name="id_incidencia" />
                    <input type="hidden" id="id_justificado" name="id_justificado" />
                    <dt class="col-sm-2 text-right pd-right">Empleado:</dt>
                    <dd class="col-sm-4 pd-right">
                        <div id="nombre"></div>
                    </dd>
                    <dt class="col-sm-2 text-right pd-right">Fecha de inicio:</dt>
                    <dd class="col-sm-1 pd-right">
                        <div id="inicio"></div>
                    </dd>
                    <br>
                    <dt class="col-sm-2 text-right pd-right">Duración en días:</dt>
                    <dd class="col-sm-1 pd-right">
                        <div id="dias"></div>
                    </dd>
                    <dt class="col-sm-2 text-right pd-right">Tipo de incidencia:</dt>
                    <dd class="col-sm-4 pd-right">
                        <div id="tipo"></div>
                    </dd>
                    <dt class="col-sm-2 text-right pd-right">Fecha de captura:</dt>
                    <dd class="col-sm-4 pd-right">
                        <div id="subida"></div>
                    </dd>
                    <dt class="col-sm-2 text-right pd-right">Motivo:</dt>
                    <dd class="col-sm-9 pd-right">
                        <div id="comentario"></div>
                    </dd>
                    <dt class="col-sm-2 text-right pd-right">Documento:</dt>
                    <dd class="col-sm-9 pd-right">
                        <div id="documentos"></div>
                    </dd>
                </dl>
                <div class="col-md-12" id="respuestaIncidencia">
                    <div class="col-md-12 container-response column-flex-center-center">
                        <div class="col-md-3 column-flex-center-center" id="s_incidencia"></div>
                        <div class="col-md-9 brd-left">
                            <div class="pd-side">
                                <label class="text-form mg-right mg-bottom-cero">Fecha respuesta:</label>
                                <label class="text-form-r mg-bottom-cero" id="f_respuesta"></label>
                            </div>
                            <div class="pd-side">
                                <label class="text-form mg-right mg-bottom-cero">Comentario respuesta:</label>
                                <label class="text-form-r mg-bottom-cero" id="c_respuesta"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="respuestaContenido">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-form">Acciones a realizar:</label>
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
                                    <label class="text-form">Escriba un comentario referente:</label>
                                    <textarea type="text" style="height: 100px" id="descripcion" name="descripcion" class="form-control input-sm" maxlength="150" placeholder="Escriba Aqui" value="<?= set_value('smsText') ?>"><?= $this->input->post('smsText', true) ?></textarea>
                                    <?= form_error('smsText') ?>
                                    <label class="control-label">
                                        Caracteres usados: <span id="caracteres">0</span> de 150
                                    </label>
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

<!-- Modal Visor File -->
<div id="visor_file" class="modal fade" role="dialog" tabindex="-1">
    <div class="modal-dialog" style="width: 85%;">
        <div class="modal-content"  style="margin-left:-40%;height: auto;width: 180%;">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-file-pdf-o"></i>&nbsp;Vista del documento <span id="NameDocument"></span></h5>
                <div style="text-align: right;">
                    <button type="button" class="btn btn-warning btn-xs" id="BtnCerrarModal" data-dismiss="modal" style="color: #262626;">Cerrar&nbsp;<i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="modal-body">
                <div id="visor" style="height:450px;"></div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<style type="text/css">
    /*Creado [Suemy][2024-05-28]*/
    body {
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    }
    #toast-container > div { opacity: .9; }
    #s_incidencia {font-size: 18px;}
    #s_incidencia > span.label {font-weight: 500;min-height: 25px;padding: .2em .6em;display: flex;align-items: center;}
    #s_incidencia > span.label > i {margin-right: 3px;margin-top: 2px;}
    #i_incidencia {margin-top: 10px;}
    .toast-message {font-size: 15px;}
    .panel.panel-default {box-shadow: 0px 1px 5px 1px rgb(0 0 0 / 40%);}
    .container-response {width: 100%;border: 1px solid #ddd;border-radius: 8px;padding: 10px 15px;}
    .column-flex-center-center {display: flex;justify-content: center;align-items: center;}
    .column-flex-center-start {display: flex;justify-content: flex-start;align-items: center;}
    .column-grid-center {display: flex;flex-direction: column;align-items: center;justify-content: center;}
    .width-ajust {width: 100%;max-width: max-content;}    
    .btn-download {color: #fff;background-color: #286090;padding: 3px 6px;border-color: #286090;border-radius: 5px;font-size: 15px;}
    .btn-secondary {color: white;}
    .btn-view-cont-alt {color: white;font-size: 20px;outline: none;border: 1px solid #26418f;border-radius: 5px;background: #26418f;padding: 2px 6px;transition: 0.3s;}
    .btn-file {background: none;border: none;padding: 0px;}
    .btn-download:hover {color: white;background: #3e45a1;border-color: transparent;}
    .btn-view-cont-alt:hover {background: #286090;}
    .btn-file:hover {color: #26418f;}
    .btn-view-cont:active, .btn-view-cont:focus, .btn-file:active, .btn-file:focus {outline: 0;}
    .text-form {font-size: 13px;font-weight: 600;}
    .text-form-r {font-size: 13px;color: #3d3d3d;font-weight: 500;}
    .label-primary {padding: .2em .6em .4em;background-color: #3f5f8f;}
    .label-success {padding: .2em .6em .4em;background-color: #3f8f50;/*#3f8f66*/}
    .label-warning {padding: .2em .6em .4em;color: black;}
    .label-danger {padding: .2em .6em .4em;background-color: #d80600;}
    .label-wine {padding: .2em .6em .4em;background-color: #97154b;}
    .control-label {font-size: 1.3rem;color: #6a6a6a;}
    td > span.label {font-size: 13px;font-weight: 500;}
    .pd-left {padding-left: 0px;}
    .pd-right {padding-right: 0px;}
    .mg-left {margin-left: 5px;}
    .mg-right {margin-right: 5px;}
    .mg-bottom-cero {margin-bottom: 0px;}
    .pd-side {padding-left: 5px;padding-right: 5px;}    
    .brd-left {border-left: 1px solid #dbdbdb;}
    .pd-items-table {padding-bottom: 5px;}
    .pd-items-table-top {padding-top: 5px;}
    /*Tables: incidencias, tipo_inicdencias, seguimiento, documentos*/
</style>