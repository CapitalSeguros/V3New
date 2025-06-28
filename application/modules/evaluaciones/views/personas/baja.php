<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Tipo bajas personal</h3>
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
            <div class="form-group col-md-12 text-right">
                <a href="#" class="btn btn-primary btn-sm bnNuevo">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" style='text-align: center;'>Acciones</th>
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

<div id="mdBaja" class="modal" tabindex="-1" role="dialog" aria-labelledby="mdBaja" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addSaveBaja" action="<?= base_url() ?>personas/baja/save" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tipo baja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="txNombre" required>
                                <input type="hidden" class="form-control" name="id" id="id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>