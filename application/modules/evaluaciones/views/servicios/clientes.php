<style>
  .select__menu-list::-webkit-scrollbar {
  width: 4px;
  height: 0px;
}
.select__menu-list::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.select__menu-list::-webkit-scrollbar-thumb {
  background: #888;
}
.select__menu-list::-webkit-scrollbar-thumb:hover {
  background: #555;
}
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Servicio de clientes</h3>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <?= $this->load->view('_parts/sidemenu2', array("tipo" => $tipo)); ?>

    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
                <a href="#" class="btn btn-primary btn-sm bnNuevo" data-permiso="permiso" data-accion-permiso="Nuevo">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-condensed" id="example">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 100px;">id</th>
                                    <th scope="col">Cliente</th>
                                    <th style="text-align: center;" scope="col"></th>
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

<div id="mdBaja" class="modal" tabindex="-1" role="dialog" aria-labelledby="mdBaja" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addSaveBaja" action="<?= base_url() ?>Serviciosws/servicio_postC/1" method="POST" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title">Clientes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre" id="nombre" required>
                                <input type="hidden" class="form-control" name="id" id="id">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Descripción</label>
                                <input type="text" class="form-control" placeholder="Descripcion" name="descripcion" id="descripcion" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        var draw=0;
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Serviciosws/getTable/2`,
                type: 'GET',
                dataSrc: 'data'
            },
            drawCallback:function(){
               if(draw==0){
                    draw++;
               }else{
                //document.getElementById("over").style.display = "none";
                //document.getElementById("upProgressModal").style.display = "none";
                //console.log("callback");
               }
               Getpermisos();
            },
            columns: [{
                    data: 'id',
                    visible: false
                },
                {
                    data: 'nombre'
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
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="editar(${row.id})" data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})" data-permiso="permiso" data-accion-permiso="Eliminar">Eliminar</a></li>
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

        $(document).on('click', '.bnNuevo', function(e) {
            e.preventDefault();
            $('#nombre').val('');
            $('#descripcion').val('');
            $('#id').val('');
            $('#mdBaja').modal('show');
        });

        window.editar = function(id) {
            const _data = datatable.rows().data();
            const model = _.find(_data, function(it) {
                return it.id == id;
            });
            $('#nombre').val(model.nombre);
            $('#descripcion').val(model.descripcion);
            $('#id').val(model.id);
            $('#mdBaja').modal('show');
        };

        $("#addSaveBaja").submit(function(event) {
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = $(this).serialize(); //Encode form elements for submission

            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data
            }).done(function(response) {
                if (response.code == "200") {
                    toastr.success("Se guardo con éxito.");
                    datatable.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
                $('#mdBaja').modal('hide');

            });
        });

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
                        url: `${$path}Serviciosws/servicio_postC/2`,
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