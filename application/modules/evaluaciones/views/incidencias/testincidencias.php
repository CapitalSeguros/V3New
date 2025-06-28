<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/datatables.min.css">
<section class="container-fluid breadcrumb-formularios">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Tipo de incidencias</h3>
            </div>
            <div class="col-md-3 text-right">
                <div class="col-md-12 text-right">
                    <a href="#" class="btn btn-primary btn-sm" style="margin-top: 10px;" onclick="openModal()">Nuevo</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section style="width:72.5vw;">
<!--     <div style="float: left; width: 90%;"> -->
<!--         <div class="row">
            <div class="form-group col-md-12 text-right">
                <a href="#" class="btn btn-primary btn-sm" onclick="openModal()">Nuevo</a>
            </div>
        </div> -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th style="text-align: center;" scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!--     </div> -->

</section>


<!--modal de las aciiones de las tablas-->
<div id="modalTipo" class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="AddTipoIncidencia" action="<?= base_url() ?>incidencias/guardarTipoIncidencia" onsubmit="onHandleSubmit()" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar tipo de incidencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="Nombre" required>
                                <input type="text" class="form-control" name="id2" id="id2" style="display:none">
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
                                <input type="text" class="form-control" name="descripcion" id="descripcion" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
            <!--final del form modal-->
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/gap/js/incidencias_tipo.table.js"></script>