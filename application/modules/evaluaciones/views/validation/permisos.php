<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Permisos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
                <a href="#" class="btn btn-primary btn-sm js-NuevoE">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">Url</th>
                                    <th>Puesto</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- panel-body -->
        </div><!-- panel-default -->
    </div>

</section>
<div id="js-container">
</div>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Permisos/Acciones/3`,
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'id',
                    visible: false
                },
                {
                    data: 'nombre',
                },
                {
                    data: 'personaPuesto',
                    "sDefaultContent": 'SIN PUESTO',
                },
                {
                    data: null,
                    "sClass": "control",
                    "sDefaultContent": '',
                    width: '120px',
                    "orderable": false,
                    render: function(data, type, row) {
                        return `
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})">Eliminar</a></li>
                        </ul>
                    </div>`;
                    }
                }
            ],
            ordering: false,
            "order": [
                [0, 'asc']
            ]
        });

        const Perm = new Permisos({
            classRender: '#js-container',
            AccionNuevo: '.js-NuevoE',
            callbackSuccess: function() {
                datatable.ajax.reload();
            },
        });
        Perm.init();

        window.eliminar = function(id) {
            swal({
                title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true,
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}Permisos/Acciones/2`,
                        data: {
                            "id": id
                        },
                        success: function(data) {
                            data.code === 200 ? datatable.ajax.reload() : toastr.error(data.message);
                        },
                        error: function(data) {
                            toastr.error(data.message);
                        }
                    });
                }
            });
        }
    });
</script>