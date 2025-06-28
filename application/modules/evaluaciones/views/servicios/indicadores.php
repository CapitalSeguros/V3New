<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Indicadores</h3>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>

<div style="float: left; width: 90%;">
<div class="row">
        <div class="form-group col-md-12 text-right">
            <a  class="btn btn-primary btn-sm js-NuevoI" data-permiso="permiso" data-accion-permiso="Nuevo">Nuevo</a>
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
                                <th scope="col" >Cliente</th>
                                <th>Tipo</th>
                                <th>Sub-tipo</th>
                                <th>Causa</th>
                                <th>Dias</th>
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
<div id="js-container">
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
            url: `${$path}Serviciosws/getTable/5`,
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
                data:'id',
                visible: false
            },
            {
                data: 'cliente',
                "sDefaultContent": 'N/A',
            },
            {
                data: 'tipo'
            },
            {
                data: 'sub_tipo',
                "sClass": "text-center",
            },
            {
                data: 'causa'
            },
            {
                data: 'dias',
                "sClass": "text-center",
            },
            {
                data: null,
                "sClass": "control",
                "sDefaultContent": '',
                width: '120px',
                "orderable": false,
                render: function (data, type, row) {
                    return `
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                            <li><a style="cursor: pointer;" class="js-EditarI" data-id='${row.id}' data-row='${JSON.stringify(row)}' data-permiso="permiso" data-accion-permiso="Editar" >Editar</a></li>
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

    const cliente = new Cliente({
        classRender: '#js-container',
        AccionNuevoE: '',
        AccionEditarE: '',
        AccionNuevoN: '',
        AccionEditarN: '',
        AccionNuevoI: '.js-NuevoI',
        AccionEditarI: '.js-EditarI',
        callbackSuccess: function() {
            datatable.ajax.reload();
        },
    });
    cliente.init();

    window.eliminar = function (id) {
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
                    url: `${$path}Serviciosws/servicio_postI/3`,
                    data: {
                        "id": id
                    },
                    success: function (data) {
                        data.code===200?datatable.ajax.reload():toastr.error(data.message);
                    },
                    error: function (data) {
                        toastr.error(data.message);
                    }
                });
            }
        });
    }

});
</script>