<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Evaluaciones</h3>
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
                <a href="<?= base_url() . 'evaluaciones/nuevo' ?>" class="btn btn-sm btn-primary">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="tbEvaluacion">
                    <thead>
                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Tipo</th>
                            <th class="text-center" scope="col">Periodicidad</th>
                            <th scope="col">Estado</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<div class="js-modal-configurar"></div>