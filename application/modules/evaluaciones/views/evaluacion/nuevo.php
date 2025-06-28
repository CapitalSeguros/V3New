<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Nueva evaluación </h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb">
                <div class="row">
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>
    <div data-id-ev="<?=@$id?>" id="new_ev" style="float: left; width: 90%;"></div>
</section>