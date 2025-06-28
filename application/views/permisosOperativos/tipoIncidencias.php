<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Tipo de Incidencias</h3>
        </div>
    </div>
    <hr />
</section>
<div class="col-md-12">
    <div class="col-md-12 column-flex-center" style="padding: 0px 15px 5px 15px;">
        <div class="col-md-2 column-grid-ajust" style="padding-left: 0px;">
            <button class="btn btn-primary" id="NuevoTI">Nuevo</button>
        </div>
        <div class="col-md-2 column-grid-ajust" style="padding-left: 0px;">
            <button class="btn btn-primary" id="RefreshTI">
                Recargar
                <i class="fa fa-refresh" aria-hidden="true" style="margin-left:5px;"></i>
            </button>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default segment-sms" style="margin: 0px;">
        <div class="panel-body">
            <div class="col-md-12" id="Container-TI" style="height: 355.52px;"></div>
        </div>
    </div>
</div>

<!--modal de las aciiones de las tablas-->
<div id="modalTipoIncidencia" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <form id="AddTipoIncidencia" action="<?= base_url() ?>incidencias/guardarTipoIncidencia" onsubmit="onHandleSubmit()" method="POST"> -->
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloTI"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombreTipoIncidencia">
                                <input type="text" class="form-control" name="id2" id="idTipoIncidencia" style="display:none">
                            </div>
                        </div>
                        <!-- <div class="col-sm-4">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tipo notificación</label>
                                <select type="text" class="form-control" name="notificacion" id="cbNotificacion">
                                    <option value="">Sin notificación</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Descripción</label>
                                <input type="text" class="form-control" name="descripcion" id="descripcionTipoIncidencia">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="GuardarTI">Guardar</button>
                    <button class="btn btn-primary hidden" id="EditarTI">Editar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>


<!-- <script type="text/javascript">
    function openModal() {
        $("#modalTipoIncidencia").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }
</script> -->