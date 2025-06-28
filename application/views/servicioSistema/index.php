<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Servicio</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb" style="float: inline-end;">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <!-- <li class="active">Autos Coorporativo</li> -->
            </ol>
        </div>
    </div>
    <hr />
</section><!-- //style="float: left; width: 90%;" -->
<section class="container-fluid">
    <?= $this->load->view('servicioSistema/menu'); ?>
    <div style="float: left; width: 90%;">
        <div class="panel panel-default" style="min-height: 400px;">
            <div class="row">
                <div class="col-md-12">
                    <div class='col-md-12 labelSpecial'>
                        <h4>Acceso Rápido</h4>
                        <hr />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/OrdenTrabajo">
                            <div>
                                <span class="glyphicon glyphicon-file fa-5x"></span><br>
                                <h4>Polizas</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Fianza">
                            <div>
                                <span class="glyphicon glyphicon-briefcase fa-5x"></span><br>
                                <h4>Fianzas</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Recibos">
                            <div>
                                <span class="glyphicon glyphicon-edit fa-5x"></span><br>
                                <h4>Recibos</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3 rectOT" style="cursor: pointer;">

                </div>
                <!-- <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema">
                            <div>
                                <span class="glyphicon glyphicon-piggy-bank fa-5x"></span><br>
                                <h4>Honorarios</h4>
                            </div>
                        </a>
                    </center>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class='col-md-12 labelSpecial mt-3'>
                        <h4>Acceso Rápido Catálogos</h4>
                        <hr />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Compania">
                            <div>
                                <span class="fa fa-institution fa-5x"></span><br>
                                <h4>Compañias</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Vendedores">
                            <div>
                                <i class="fa fa-user-plus fa-5x" aria-hidden="true"></i>
                                <h4>Vendedores</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema">
                            <div>
                                <i class="fa fa-user-plus fa-5x" aria-hidden="true"></i>
                                <h4>Clientes</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Prestamos">
                            <div>
                                <i class="fa fa-exchange fa-5x" aria-hidden="true"></i>
                                <h4>Prestamos</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3 rectRP" style="cursor: pointer;">

                </div>
            </div>
            <div class="row pt-3 pb-3">
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Honorarios">
                            <div>
                                <i class="fa fa-percent fa-5x" aria-hidden="true"></i>
                                <h4>Honorarios</h4>
                            </div>
                        </a>
                    </center>
                </div>
                <div class="col-md-3">
                    <center>
                        <a href="<?= base_url() ?>servicioSistema/Comisiones">
                            <div>
                                <i class="fa fa-calculator fa-5x" aria-hidden="true"></i>
                                <h4>Comisiones</h4>
                            </div>
                        </a>
                    </center>
                </div>
                
            </div>
        </div>
    </div>
    <a id="ref" data-id="Polizas" class="hidden"></a>
    <a id="refId" data-id="OT-202001010102" class="hidden"></a>
    <input id="urlAPI" type="hidden" value="<?=URL_TICC_SICAS?>api/">
</section>
<script>
    $(document).ready(function() {
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }

        const path = $("#base_url").attr("data-base-url");
        const $pathServicio = $("#urlAPI").val();
        const CapturaC = new TCambioComponente({
            classRender: '.rectOT',
            UrlServicio: $pathServicio,
            //callbackSuccess: {}
        });
        CapturaC.init();

        const RPago = new RPagoComponente({
            classRender: '.rectRP',
            UrlServicio: $pathServicio,
        });
        RPago.init();
        // $(document).on("input", ".numeric", function() {
        //     this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        // });

        // const CapturaD = new FmanagerComponente({
        //     classRender: '.file-manager-container',
        //     selectorAction: '#file-manager',
        //     referencia: '',
        //     referenciaId: '',
        //     //callbackSuccess: {}
        // });
        // CapturaD.init();





    });
</script>
