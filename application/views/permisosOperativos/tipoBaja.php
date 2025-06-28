<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-12">
            <h3 class="title-section-module">Tipos de Baja</h3>
        </div>
    </div>
    <hr />
</section>
<div class="col-md-12">
    <div class="col-md-12 column-flex-center" style="padding: 0px 15px 5px 15px;">
        <div class="col-md-2 column-grid-ajust" style="padding-left: 0px;">
            <button class="btn btn-primary" id="NuevoTB">Nuevo</button>
        </div>
        <div class="col-md-2 column-grid-ajust" style="padding-left: 0px;">
            <button class="btn btn-primary" id="RefreshTB">
                Recargar
                <i class="fa fa-refresh" aria-hidden="true" style="margin-left:5px;"></i>
            </button>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="panel panel-default segment-sms" style="margin: 0px;">
        <div class="panel-body">
            <div class="col-md-12" id="Container-TB" style="height: 355.52px;"></div>
        </div>
    </div>
</div>

<div id="modalTipoBaja" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloTB">Tipo Baja</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre" id="nombreTipoBaja">
                            <input type="hidden" class="form-control" name="id" id="idTipoBaja">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="GuardarTB">Guardar</button>
                <button class="btn btn-primary hidden" id="EditarTB">Actualizar</button>
                <button class="btn btn-default" data-dismiss="modal" id="CerrarTB">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
</script>