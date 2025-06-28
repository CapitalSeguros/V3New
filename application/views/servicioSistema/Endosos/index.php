<link rel="stylesheet" href="<?= base_url() ?>/assets/gap/css/servicios_api.css">
<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<div id="full-container">
    <section class="container-fluid breadcrumb-formularios">
        <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Endosos</h3>
            </div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb" style="float: inline-end;">
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
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <label>Buscar </label>
                            <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm" name="search" />
                            <input type="hidden" id="year" name="2">
                            <input type="hidden" id="Tramites_Autos" name="10">
                            <input type="hidden" id="cbEstado_2" name="7">
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" id="Estatus">
                                <label for="exampleFormControlInput1">Estatus</label>
                                <select class="form-control form-control-sm fieldForm" name="Factive" id="Factive">
                                    <option value="">Seleccione una opcion</option>
                                    <option value="A">Activo</option>
                                    <option value="I">Inactivo</option>
                                </select>
                                <span id="e_Active" class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-8 text-right" style="margin-top: 15px;">
                            <a id="btnADD" class="btn btn-primary Nuevo" onclick="DowloadFile()"><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>
                            <a id="btnADD" class="btn btn-primary Nuevo" href="<?= base_url() ?>servicioSistema/OrdenTrabajoNew"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="polizas">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col" style="width: 200px;">Estatus usuario</th>
                                        <th scope="col" style="width: 200px;">Dias</th>
                                        <th scope="col" style="width: 200px;">Solicitud</th>
                                        <th scope="col" style="width: 200px;">SubRamo</th>
                                        <th scope="col" style="width: 200px;">Fdesde</th>
                                        <th scope="col" style="width: 200px;">FHasta</th>
                                        <th scope="col" style="width: 200px;">FCaptura</th>
                                        <th scope="col" style="width: 200px;">Vendedor</th>
                                        <th scope="col" style="width: 200px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");
        const $pathServicio = $("#urlAPI").val();
        const datatable = $('#polizas').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            preDrawCallback: function() {},
            initComplete: function() {},
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$pathServicio}capture/endosos`,
                type: 'GET',
                "data": function(d) {
                    return $.extend({}, d, {
                        "search": $("#txSearch").val(),
                        //"Active": $("#Factive").val(),
                    });
                }
            },
            drawCallback: function() {},
            ordering: false,
            columns: [{
                    data: 'IDDocto',
                    visible: false,
                    
                },
                {
                    data: 'EstatusUsuario',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'Dias',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'Solicitud',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'Subramo',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'FDesde',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'FHasta',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'FCaptura',
                    visible: true,
                    defaultContent:"N/A"
                },
                /*                 {
                                    data: 'Usuario',
                                    visible: true
                                }, */
                {
                    data: 'Vendedor',
                    visible: true,
                    defaultContent:"N/A"
                },
                {
                    data: 'Acciones',
                    width: '5%',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="col-md-12">
                                <div style="text-align: right;">
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.IDDocto}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.IDDocto}">
                                            <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="EditItem(${row.IDDocto})"  data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>`
                    }
                },
            ],
            order: [
                [0, 'desc']
            ],


        });

        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });


        $(document).on('change', '#Factive', function(e) {
            datatable.draw();
        });

        window.EditItem = function(Id) {
            window.location = $path + 'servicioSistema/OrdenTrabajoEdit/' + Id;
        }

        window.DowloadFile= function(){
            var Filter= $("#txSearch").val();
            return window.open(`${$pathServicio}capture/docPolizas?search=${Filter}`, '_blank');
        }
    });
</script>