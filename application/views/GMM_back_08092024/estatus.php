<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<style>

    .box.first {
        float: left;
    }
    .card-round {
        border-radius: 5px;
        width: 100px;
        max-width: 100px;
    }
    .progressBar {
        background-color: lightgrey;
        width: 200px;
        height: 20px;
    }

    .progressb {
        height: 100%;
    }

</style>
<!-- <link rel="stylesheet" href="<?=base_url()?>assets/gap/css/jquery.filer.css">
<link rel="stylesheet" href="<?=base_url()?>assets/gap/css/jquery.filer-dragdropbox-theme.css"> -->
<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Estatus de los siniestros</h3>
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
           <!--  <a href="<?=base_url()?>GMM/RegistroGMM" class="bn-sol-bono btn-primary btn-sm btn pull-right">Nuevo</a> -->
               <!--  <button class="bn-sol-bono btn-primary btn-sm btn pull-right" >Nuevo</button> -->
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="example" style='color:#472380 !important;'>
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Orden</th>
                            <th scope="col">Depende</th>
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
        <form id="form_cobertura" action="<?= base_url() ?>GMM/AccionesEstatus" method="POST" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">Tipo de estatus</h4>
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
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Color</label>
                                <input type="color" class="form-control" id="color" name="color" placeholder="Color" required oninvalid="this.setCustomValidity('Seleccione un color')" oninput="setCustomValidity('')">
                            </div>
                        </div>
                        <div class="col-lg-12" id="ordenFull">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Orden</label>
                                <select name="orden" id="orden" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Depende</label>
                                <select class="form-control" name="depende" id="depende">
                                   
                                </select>
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

<!-- <script src="<?=base_url()?>assets/gap/js/jquery.filer.min.js"></script>
<script src="<?=base_url()?>assets/gap/js/customjfiler.js"></script> -->
<script src="<?=base_url()?>assets/gap/js/permisos.js"></script>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
       /*  document.getElementById("over").style.display = "block";
        document.getElementById("upProgressModal").style.display = "block";
        var draw=0; */
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}GMM/get_estatus`,
                type: 'GET',
                dataSrc: 'data'
            },
            /* drawCallback:function(){
               if(draw==0){
                    draw++;
               }else{
                document.getElementById("over").style.display = "none";
                document.getElementById("upProgressModal").style.display = "none";
                //console.log("callback");
               }
               Getpermisos();
            }, */
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                var tmp = `
                <div>
                <div class="row">
                <div class="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right" style="margin-top: 10px;">
                            <a class="btn btn-primary" onclick="OpenModal()" data-permiso="permiso" data-accion-permiso="Nuevo">Nuevo</a>
                    </div>
                </div>
                </div>`
                $('div.toolbar').html(tmp);
                Getpermisos();
            },
            columns: [
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: null,
                    width: '200px',
                    render: function(data, type, row) {
                        //console.log("row",row);
                        return `
                                    <div class="col-md-2">
                                        <div class="card-round" style="background:${row.color};">
                                            <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.nombre}</h6>
                                        </div>
                                    </div>`;
                    }
                    //visible: false
                },
                {
                    data: 'orden',
                    "sClass": "text-center",
                    //visible: false
                },
                {
                    data: 'nom_dep',
                    "sDefaultContent": 'N/A',
                    "sClass": "text-center",
                    //visible: false
                },
                {
                    data: null,
                    "sClass": "control",
                    "sDefaultContent": '',
                    width: '100px',
                    "orderable": false,
                    render: function(data, type, row) {
                        //console.log("row",row);
                        return `
                        <div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dp${row.id}">
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Editar(${row.id})" data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                        <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Eliminar(${row.id},${row.orden})" data-permiso="permiso" data-accion-permiso="Eliminar">Eliminar</a></li>
                                    </ul>
                                </div>
                        </div>`;
                    }
                }
            ],
        });



        //funcion para abrir el modal
        window.OpenModal = function() {
            $.ajax({
                type: 'GET',
                url: `${$path}GMM/get_estatus`,
                success: function (data) {
                var algo=ElementsOrder(data.data,'','','');
                },
                error: function (data) {
                }
            });
            $("#ordenFull").css("display","none")
            $('input[name=Nombre]').val('');
            $('textarea[name=Descripcion]').val('');
            $('input[name=id]').val('');
            $('#modal_tipos').modal('show');
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
               

            });
        });

        ///metodos para la edicion e eliminación de los tipos de incidencias
        window.Eliminar = function (id,orden) {
            swal({
                title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
                text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
                icon: "warning",
                buttons: ["Cancelar", "Aceptar"],
            }).then((value) => {
                if (value) {
                    $.ajax({
                        type: 'POST',
                        url: `${$path}GMM/deleteStatus`,
                        data: {
                            "id": id,
                            "orden":orden
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

        
        //evento del input buscar
        $(document).on('input', '#txSearch', function(e) {
            datatable
                .search(e.currentTarget.value)
                .draw();
        });

        window.Editar = function (id) {
            const _data = datatable.rows().data();
            const oInci = _.find(_data, function (it) {
                return it.id == id;
            });
            //datos del registro 
            console.log("Data",oInci);
                $.ajax({
                        type: 'GET',
                        url: `${$path}GMM/get_estatus`,
                        success: function (data) {
                            var algo=ElementsOrder(data.data,oInci.orden,oInci.depende,oInci.id);
                        },
                        error: function (data) {

                        }
                    });
            $('input[name=Nombre]').val(oInci.nombre);
            $('#id').val(oInci.id);
            $('#color').val(oInci.color);
            $("#ordenFull").css("display","block")
            /* $('select[name=orden]').val(oInci.orden);
            $('select[name=depende]').val(oInci.depende); */
            $('#modal_tipos').modal('show');
        }

        window.ElementsOrder=function(data,orden,depende,id){
            var acum='<option value="">Seleccione uno</option>';
            var acum2='<option value="">Seleccione uno</option>';
            data.forEach(function(element,key){
                acum+=`<option value="${key+1}" ${orden==key+1?'selected':''}>${key+1}</option>`;
                acum2+=`<option value="${element.id}" ${depende==element.id?'selected':''} ${id==element.id?'disabled':''}>${element.nombre}</option>`;
            });
            $("#orden").html('');
            $("#orden").html(acum);
            $("#depende").html('');
            $("#depende").html(acum2);
        }

        

    });
</script>

<!--modal de las aciiones de las tablas-->