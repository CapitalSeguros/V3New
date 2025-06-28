<style>

    .box.first {
        float: left;
    }
    .swal-button--confirm{
    background-color:#67439f!important;
}


</style>
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Tipos siniestros autos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('siniestro_catalogo/sidemenu2', array("tipo" => $tipo)); ?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group col-md-12 text-right">
                <button class="bn-sol-bono btn-primary btn-sm btn pull-right" onclick="OpenModal()" data-permiso="permiso" data-accion-permiso="Nuevo" >Nuevo</button>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="example" style='color:#472380 !important;'>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Tipo</th>
                            <th style="text-align: center;" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<div class="modal fade" id="modal_tipos" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="form_cobertura" action="<?= base_url() ?>Siniestro_catalogos/AccionesTipoAutos" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Nuevo causa de cierre</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nombre</label>
                                <input  type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Nombre" required oninvalid="this.setCustomValidity('Ingrese un nombre')" oninput="setCustomValidity('')">
                                <input type="text" class="form-control" name="id" id="id" style="display:none">
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?=base_url()?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
        var draw=0;
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Siniestro_catalogos/getTableData/7`,
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
            columns: [
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'nombre',
                    render: function(data, type, row) {
                        return `
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <div class="media-body">
                                        <h4 class="media-heading"  style="padding-left: 15px;"><strong>Tipo: </strong>${row.nombre}</h4>
                                        
                                    </div>
                                </div>  
                            </div>     
                        </div>`;
                    }
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
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" data-in-id="${row.id}" onclick="Editar(${row.id})" data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                        <li><a onclick="eliminar(${row.id})" style="cursor: pointer;" data-in-id="${row.id}" data-permiso="permiso" data-accion-permiso="Eliminar">Eliminar</a></li>
                                    </ul>
                                </div>
                        </div>`;
                    }
                }
            ],
            "order": [
                [2, 'desc']
            ],
        });

        //funcion para abrir el modal
        window.OpenModal = function() {
            $('#modal_tipos').modal('show'); 
            $('input[name=Nombre]').val('');
            $('textarea[name=Descripcion]').val('');
            $('input[name=id]').val('');
        }

        //funcion para editar un registro
        window.Editar = function (id) {
            //console.log("id",id);
            const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == id;
            });
            //console.log("Data",oInci);
            $('input[name=Nombre]').val(oInci.nombre);
           // $('textarea[name=Descripcion]').val(oInci.descripcion);
            $('input[name=id]').val(oInci.id);
            //$('select[name=tipo]').val(oInci.Tipo);
            $('#modal_tipos').modal('show');
            return;
        }


        $("#form_cobertura").submit(function (event) {
            event.preventDefault(); //prevent default action 
            var post_url = $(this).attr("action"); //get form action url
            var request_method = $(this).attr("method"); //get form GET/POST method
            var form_data = $(this).serialize(); //Encode form elements for submission

            //console.log("DATA",form_data)

            $.ajax({
                url: post_url,
                type: request_method,
                data: form_data
            }).done(function (response) {
                if (response.code == "200") {
                    toastr.success("Se guardo con éxito.");
                    datatable.ajax.reload();
                    $('#modal_tipos').modal('hide');
                } else {
                    toastr.error(response.message);
                }
               // $('#modal_tipos').modal('hide');

            });
        });

        ///metodos para la edicion e eliminación de los tipos de incidencias
        window.eliminar = function (id) {
            swal({
                title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}Siniestro_catalogos/deleteTiposAutos`,
                        data: {
                            "id": id,
                            //"Tipo":1
                        },
                        success: function (data) {
                            datatable.ajax.reload();
                        },
                        error: function (data) {

                        }
                    });
                }
            });
        }



    });
</script>
