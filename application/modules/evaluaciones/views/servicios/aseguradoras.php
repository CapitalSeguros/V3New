<style>
    .scroll-elements{
        max-height: 350px;
        overflow: auto;
        overflow-x: hidden;
    }
    .element1 {
        float: left;
    }

    .element2 {
        padding-left: 20px;
        float: left;
    }
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Servicios de aseguradoras</h3>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>

<div style="float: left; width: 90%;">
<div class="row">
        <div class="form-group col-md-12 text-right">
            <a href="#" class="js-NewAgencia btn btn-primary btn-sm bnNuevo" data-permiso="permiso" data-accion-permiso="Nuevo">Nuevo</a>
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
                                <th scope="col" >Aseguradora</th>
                                <th scope="col" >Cliente</th>
                                <th scope="col">Tipo actualizacion</th>
                                <th scope="col">Metodo</th>
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
</div>
    
</section>
<div id="Agencia-container">
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
                url: `${$path}Serviciosws/getTable/1`,
                type: 'GET',
                dataSrc: function(json) {
                    return json.data;
                }
            },
            ordering: false,
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
            dom: '<"toolbar">rtip ',
            initComplete: function() {
                var tmp = `
                <div class="row">
                <div class="col-sm-2">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
            </div>`
                $('div.toolbar').html(tmp);

            },
            columns: [{
                    data: 'id',
                    visible: false
                },
                {
                    data: 'Promotoria',
                }, 
                {
                    data: 'cliente',
                    "sDefaultContent": 'N/A',
                },
                {
                    data: 'tipo_actualizacion',
                    orderable: false,
                },
                {
                    data: "tipo_metodo",
                    orderable: false,
                    "sDefaultContent": 'N/A',
                },
                {
                    data: null,
                    "sClass": "control text-right",
                    "sDefaultContent": '',
                    width: '40px',
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <div class="dropdown center-aling-items">
                            <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                                <li><a style="cursor: pointer;" class="js-EditSiniestro" data-cliente="${row.cliente_id}" data-id="${row.id}" data-servicio="${row.tipo_actualizacion}" data-aseguradora="${row.aseguradora_id}" data-metodo="${row.tipo_metodo}" data-row='${row.datos}' data-permiso="permiso" data-accion-permiso="Editar">Editar</a></li>
                                <li><a style="cursor: pointer;" onclick="eliminar(${row.id})" data-permiso="permiso" data-accion-permiso="Eliminar">Eliminar</a></li>
                            </ul>
                        </div>
                    `;
                    }
                }
            ],
            order: [
                [0, 'desc']
            ]
        });

        const Aseguradoras = new Aseguradora({
            classRender: '#Agencia-container',
            AccionNuevo: '.js-NewAgencia',
            AccionEditar: '.js-EditSiniestro',
            AccionVer: '.js-ShowSiniestro',
            Datatable: datatable.rows().data(),
            callbackSuccess: function(e) {
                datatable.ajax.reload();
            },
        });
        Aseguradoras.init();


        
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
                    url: `${$path}Serviciosws/servicio_post/3`,
                    data: {
                        "id": id
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

    $(document).on("input", "#txSearch", function (e) {
        datatable.search(e.currentTarget.value).draw();
     });

});
</script>