<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Nuevo periodo</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>

<section class="container">
<?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>
    <div id="new_ev" data-id-ev="<?= @$id ?>" style="float: left; width: 90%;">

    </div>
</section>