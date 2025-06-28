<style>
    .table-wrapperH {
        width: 80hw;
        height: 400px;
        overflow: auto;
    }

    .table-wrapperH2 {
        width: 80hw;
        height: 200px;
        overflow: auto;
    }
/*     #Honorarios> table th {
    width: auto !important;
} */

table { table-layout: fixed; }
 table th, table td { overflow: hidden; }
</style>
<link rel="stylesheet" href="<?= base_url() ?>/assets/gap/css/servicios_api.css">
<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<div id="full-container">
    <section class="container-fluid breadcrumb-formularios">
        <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Honorarios</h3>
            </div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb" style="float: inline-end;">
                    <li><a href="<?= base_url() ?>">Inicio</a></li>
                </ol>
            </div>
        </div>
        <hr />
    </section>
    <section class="container-fluid">
        <?= $this->load->view('servicioSistema/menu'); ?>
        <div style="float: left; width: 90%;">
            <div class="panel panel-default">
                <div class="panel-body rectOT">

                </div><!-- panel-body -->
            </div><!-- panel-default -->
            <div class="modal-seguimiento-container"></div>
            <div id="siniestro-container">
            </div>
        </div>
        <input id="urlAPI" type="hidden" value="<?=URL_TICC_SICAS?>api/">
</div>
</section>
</div>

<div id="upProgressModal" style="display:none;" role="status" aria-hidden="true">
    <div id="nprogress" class="nprogress">
        <div class="spinner">
            <div class="spinner-icon"></div>
            <div class="spinner-icon-bg"></div>
        </div>
        <div class="overlay"></div>
    </div>
</div>


<script>
    $(document).ready(function() {
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const path = $("#base_url").attr("data-base-url");
        const pathServicio = $("#urlAPI").val();
        const CapturaC = new HonorariosComponente({
            classRender: '.rectOT',
            UrlServicio: pathServicio,
            UrlPagina: path,
            Modulo: "P",
            callbackSuccess: {}
        });
        CapturaC.init();
    });
</script>