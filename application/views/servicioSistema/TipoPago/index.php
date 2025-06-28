<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/gap/css/servicios_api.css"> -->
<script src="<?= base_url() ?>/assets/gap/js/jquery.validate.js"></script>
<div id="full-container">
    <section class="container-fluid breadcrumb-formularios">
        <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5">
                <h3 class="titulo-secciones">Tipo Pago</h3>
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
                            <a id="btnADD" class="btn btn-primary Nuevo">Nuevo</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="polizas">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col" style="width: 200px;">Estatus</th>
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
<div class="modal" id="mdADD" tabindex="-1" role="dialog">
    <form id="form_tramite" method="POST" autocomplete="off">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tipo Pago</h5>
                    <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tipo</label>
                        <input type="text" class="form-control fieldForm" name="Nombre" id="Nombre" placeholder="Nombre">
                        <input type="hidden" class="fieldForm" id="IdItem">
                        <span id="e_Nombre" class="error"></span>
                    </div>
                    <div class="form-group" id="EstatusM">
                        <label for="exampleFormControlInput1">Estatus</label>
                        <select class="form-control fieldForm" name="Active" id="Active">
                            <option value="">Seleccione una opcion</option>
                            <option value="A">Activo</option>
                            <option value="I">Inactivo</option>
                        </select>
                        <span id="e_Active" class="error"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <a type="button" class="btn" data-dismiss="modal">Cerrar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
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
                url: `${$pathServicio}catalogos/tipopago`,
                type: 'GET',
                "data": function(d) {
                    return $.extend({}, d, {
                        "search": $("#txSearch").val(),
                        "Active": $("#Factive").val(),
                    });
                }
            },
            drawCallback: function() {},
            ordering: false,
            columns: [{
                    data: 'Id',
                    visible: false
                },
                {
                    data: 'Nombre',
                    width: '100%',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                            <div class="col-md-12">
                                   <div>
                                        <b> ${row.Tipo} </b> 
                                        <div>Estatus: ${row.Active=='A'?'Activo':'Inactivo'}</div>
                                        <div style="text-align: right; margin-top: -30px;">
                                                    <div class="dropdown">
                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.Id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.Id}">
                                                            <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="EditItem(${row.Id})"  data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                                            <li onclick="DeleteItem('${row.Id}')" data-id="${row.Id}"><a class="bn-bono-view"  style="cursor: pointer;"   data-permiso="permiso" data-accion-permiso="Editar">Eliminar</a></li>
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

        $(document).on('input', '#txSearch', function(e) {
            datatable.draw();
        });

        $(document).on('click', '#btnADD', function(e) {
            ResetFields();
            $('#EstatusM').hide();
            //document.getElementById("Estatus").style.display = "none";
            $('#Active').val('A');
            $('#mdADD').modal('show');
        });

        $(document).on('change', '#Factive', function(e) {
            datatable.draw();
        });

        window.EditItem = function(id) {
            //Metodo para obtner un item
            $.ajax({
                type: 'GET',
                url: `${$pathServicio}catalogos/tipopago/${id}`,
                data: {

                },
                success: function(data) {
                    console.log("data", data.Datos);
                    $("#IdItem").val(data.Datos.Id);
                    $("#Nombre").val(data.Datos.Tipo);
                    $("#Active").val(data.Datos.Active);
                    $('#EstatusM').show();
                    //document.getElementById("Estatus").style.display = "block";
                    $('#mdADD').modal('show');
                },
                error: function(data) {

                }
            });
        }

        //Validacion del formulario
        $("#form_tramite").validate({
            rules: {
                Nombre: {
                    required: true,
                },
                Active: {
                    required: true,
                }
            },
            messages: {
                Nombre: {
                    required: "Ingrese un Nombre.",
                },
                Active: {
                    required: "Seleccione un Estatus.",
                }
            },
            errorPlacement: function(error, element) {
                if (error) {
                    $(`#e_${element[0].id}`).append(error);
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                document.getElementById("over").style.display = "block";
                document.getElementById("upProgressModal").style.display = "block";
                data = {
                    "objeto": {
                        "Id": $("#IdItem").val(),
                        "Tipo": $("#Nombre").val(),
                        "Active": $("#Active").val()
                    }
                };
                if(data.objeto.Id==""){
                    delete data.objeto.Id;
                }
                $.ajax({
                    url: `${$pathServicio}catalogos/tipopago`,
                    type: form.method,
                    data: data,
                    success: function(response) {
                        console.log("response", response)
                        if (response.Mensaje == "Exito") {
                            datatable.ajax.reload(null, false);
                            toastr.success(response.Mensaje);
                            $('#mdADD').modal('hide');
                            ResetFields();

                        } else {
                            toastr.error(response.Mensaje);
                            //alert(response.Mensaje);
                        }
                        document.getElementById("over").style.display = "none";
                        document.getElementById("upProgressModal").style.display = "none";
                    }
                });
            }
        });

        //Eliminar registro
        window.DeleteItem = function(id) {

            swal({
                title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    //Metodo para obtner un item
                    $.ajax({
                        type: 'POST',
                        url: `${$pathServicio}catalogos/tipopago_put/${id}`,
                        data: {

                        },
                        success: function(data) {
                            datatable.ajax.reload(null, false);
                            toastr.success(data.Mensaje);
                        },
                        error: function(data) {
                            toastr.error(data.Mensaje);
                        }
                    });
                }
            });

        }

        //Funcion general
        window.ResetFields = function() {
            var sp = document.getElementsByClassName("fieldForm");
            for (var i = 0; i < sp.length; i++) {
                $(`#${sp.item(i).id}`).val('');
            }
        }


    });
</script>