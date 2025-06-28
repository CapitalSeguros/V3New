<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Bonos por evaluación</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li class="active">Bonos por evaluación</li>
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
                <button class="bn-sol-bono btn-primary btn-sm btn pull-right" data-in-id="0">Nuevo</button>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Puesto</th>
                                    <th scope="col">Calificación</th>
                                    <th scope="col">Bono</th>
                                    <th scope="col">Estado</th>
                                    <th style="text-align: center" scope="col">Acciones</th>
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
<div id="bonos-container"></div>
<div class="modal-seguimiento-container"></div>
<div class="modal-autorizar-container"></div>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
    
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}TabuladorBonos/getTableTabuladorBonos`,
                type: 'GET',
                dataSrc: 'data'
            },
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                var tmp = `<div class="row">
                <div class="col-sm-3">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
                
                <div class="col-sm-2">
                    <label>Estado </label>
                    <select class="form-control input-sm"  id="cbEstado" name="3">
                        <option value="">Todos</option>
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="APROBADO">APROBADO</option>
                        <option value="RECHAZADO">RECHAZADO</option>
                    </select>
                </div>
            </div>`
                $('div.toolbar').html(tmp);
            },
            columns: [{
                    data: 'personaPuesto',
                    defaultContent: 'Sin Nombre'
                },
                {
                    data: 'calificacion',
                    defaultContent: 'Sin puesto',
                    className: "text-center",
                    render: function(data, type, row) {
                        return data === "0" ? 'Sin valor asignado' : data + " pts.";
                    }
                },
                {
                    data: 'sueldo',
                    defaultContent: 'Sin periodo',
                    className: "text-center",
                    render: function(data, type, row) {
                        return data === "0" ? 'Sin valor asignado' : "$" + data + ".00";
                    }
                },
                {
                    data: 'estado',
                    defaultContent: 'Sin estatus',
                    className: "text-center",
                },
                {
                    data: null,
                    "sClass": "control",
                    "sDefaultContent": '',
                    width: '120px',
                    "orderable": false,
                    render: function(data, type, row) {
                        return `
                        <div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dp${row.id}">
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" data-in-id="${row.id}" >Ver</a></li>
                                        <li><a onclick="getDataHistorial(${row.id})" style="cursor: pointer;" data-in-id="${row.id}">Seguimiento</a></li>
                                        <li><a  class="bn-bono-edit"  style="cursor: pointer;" data-in-id="${row.id}">Editar</a></li>
                                        <li><a onclick="EliminarPregunta(${row.id})" style="cursor: pointer;" data-in-id="${row.id}">Eliminar</a></li>
                                    </ul>
                                </div>
                        </div>`;
                    }
                }
            ],
            "order": [
                [0, 'asc']
            ]
        });
        const ModuloTabulador = new Tabulador({
            selector: '#bonos-container',
            selectorAction: '.bn-sol-bono',
            selectorView: '.bn-bono-view',
            selectorEdit: '.bn-bono-edit',
            callBack: function() {
                datatable.ajax.reload();
            },
            Tipo: /* 'Usuario' */ '2'
        });
        ModuloTabulador.init();

        $(document).on('input', '#cbEstado', function(e) {
            datatable
                .columns(e.currentTarget.name)
                .search(e.currentTarget.value)
                .draw();
        });

        $(document).on('input', '#txSearch', function(e) {
            datatable
                .search(e.currentTarget.value)
                .draw();
        });

        window.getDataHistorial = function(id) {
            $.ajax({
                url: `${$path}TabuladorBonos/seguimiento/${id}`,
                method: 'GET',
                dateType: 'json',
                success: function(response) {
                    window.modalModalSeguimiento.show("Seguimiento de tabulador de bonos", response.data)
                }
            });
        }

        window.EliminarPregunta = function(id) {
            swal({
                    title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                    text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                    icon: "warning",
                    buttons: ["Cancelar", "Eliminar"],
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'POST',
                            url: `${$path}TabuladorBonos/deleteRegistro/${id}`,
                            success: function(response) {
                                console.log(response, "Eliminar");
                                if (response.code == "200") {
                                    datatable.ajax.reload();
                                    window.toastr.success(response.message);
                                } else {
                                    window.toastr.error(response.message);
                                }
                                //datatable.ajax.reload();
                            },
                            error: function(xhr) {
                                console.log('error', xhr);
                            }
                        });
                    }
                });
        }
    });
</script>