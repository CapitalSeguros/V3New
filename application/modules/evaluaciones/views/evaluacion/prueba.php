<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Visor de documentos</h3>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>
    <div style="float: left; width: 90%;">
        <div id="Puesto" data-id="<?=$puestoUsuario?>"></div>
        <div id="Empleado_id" data-id="<?=$IdUsuario?>"></div>
        <div class="file-manager-container" data-referencia="DOCUMENTOS" data-trashed data-full data-referenciaId="0"></div>
    </div>
</section>