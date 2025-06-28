<style>
    .form-group {
        margin-bottom: unset !important;
    }

    .form-group>label {
        margin-bottom: unset !important;
        color: #472380;
        font-weight: bold;
    }

    .btn-row {
        text-align: end;
    }

    .btn-s {
        margin-left: 5px;
    }
</style>
<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<div id="full-container">
    <section class="container-fluid breadcrumb-formularios">
        <input type="hidden" name="idRegistro" id="idRegistro" value="<?= $idRegistro ?>">
        <input type="hidden" name="Usuario" id="Usuario" value="<?= $Usuario ?>">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Editar Orden Trabajo</h3>
            </div>
            <div class="col-md-6 col-sm-7 col-xs-7 d-flex">
                <ol class="breadcrumb text-right">
                    <li><a href="<?= base_url() ?>">Inicio</a></li>
                    <li><a href="<?= base_url() ?>Siniestros">Catalogos</a></li>
                    <!-- <li class="active">Autos Coorporativo</li> -->
                </ol>
            </div>
        </div>
        <hr />
    </section>
    <section class="container-fluid">
        <?= $this->load->view('servicioSistema/menu'); ?>
        <div style="float: left; width: 90%;">
            <div class="panel panel-default">
                <div class="panel-body" style="color: #000!important;">
                    <div class="rectOT">

                    </div>
                </div><!-- panel-body -->
            </div><!-- panel-default -->
            <div class="modal-seguimiento-container"></div>
            <div id="siniestro-container">
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
        //console.log('init');
        const path = $("#base_url").attr("data-base-url");
        const $pathServicio = $("#urlAPI").val();
        const CapturaC = new CapturaComponente({
            classRender: '.rectOT',
            UrlServicio: $pathServicio,
            UrlPagina: path,
            Tipo:2,
            callbackSuccess: {}
        });
        CapturaC.init();


        $(document).on("input", ".numeric", function() {
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });

    });
</script>