<link rel="stylesheet" href="<?= base_url() ?>/assets/gap/css/servicios_api.css">
<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<div id="full-container">
    <section class="container-fluid breadcrumb-formularios">
        <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Compañias</h3>
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
                        <div class="col-md-10 text-right" style="margin-top: 15px;">
                            <a id="btnADD" class="btn btn-primary Nuevo" href="<?=base_url()?>/servicioSistema/CompaniaAdd">Nuevo</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="polizas">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Compañia</th>
                                        <th scope="col">Alias</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col"></th>
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


<!-- modal para añadir-->

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
        $('body').append('<div id="over" style="display:none;position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
        const $path = $("#base_url").attr("data-base-url");
        const $pathServicio = $("#urlAPI").val();
        if ($('body div').hasClass('pace')) {
            $("body div").removeClass("pace");
        }


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
                url: `${$pathServicio}catalogos/compania`,
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
                    data: 'IDCia',
                    visible: false,
                    //width: '100%',
                },
                {
                    data: 'CiaNombre',
                    visible: true,
                    width: '80%',
                },
                {
                    data: 'CiaAbreviacion',
                    visible: true,
                    width: '100%',
                    defaultContent: 'N/A',
                },
                {
                    data: 'TCompania',
                    visible: true,
                    width: '100%',
                    render: function(data, type, row) {
                        return `
                            <div class="col-md-12">
                                ${GetTipo(row.TCompania)}
                            </div>`
                    }
                },
                {
                    data: 'Comentario',
                    width: '400px',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="col-md-12">
                                   <div>
                                        <div style="text-align: right;">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.IDCia}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.IDCia}">
                                                            <li><a class="bn-bono-view"  style="cursor: pointer;" href="${$path}servicioSistema/CompaniaEdit/${row.IDCia}"  data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                        </ul>
                                                    </div>
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

        function GetTipo(Tipo) {
            var _res = '';
            switch (Tipo) {
                case 1:
                    _res = "Pólizas";
                    break;
                case 2:
                    _res = "Fianzas";
                    break;
                default:
                    _res = "N/A";
                    break;
            }
            return _res;
        }

        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });

    });
</script>