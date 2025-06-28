<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Periodos de evaluación</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>

<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
                <a href="periodo/nuevo" class="btn btn-primary btn-sm">Nuevo</a>
            </div>
        </div>
        <!--Row-->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Fecha inicio</th>
                                    <th scope="col">Fecha finalización</th>
                                    <th scope="col">Tipo período</th>
                                    <th scope="col">Estatus</th>
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
    </div>

</section>

<div id="modalLiberar">
</div>

<!--modal de las aciiones de las tablas-->