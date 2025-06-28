
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div id="idperiodo" data-id="<?=$idperiodo?>"></div>
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">PIP (Performance Improvement Plan)</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?= base_url() ?>">Inicio</a></li>
                <li class="active">PIP</li>
            </ol>
        </div>
    </div>
    <hr />
</section>
<section class="container">
<div style="float: left; width: 100%;">
    <div class="row">
    <?php if($idperiodo==0) :?>
            <div class="form-group col-md-12 text-right">
                <a href="<?= base_url() ?>PIP/AgregarPIP/?id=0&idp=0&idpp=0" class="btn btn-primary openModal btn-sm" data-in-mode="normal">Nuevo</a>
            </div>
    <?php endif?>  
    </div>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-condensed" id="example">
                    <thead>
                        <tr>
                            <th scope="col">Colaborador</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Periodo</th>
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

<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        const $idperiodo = $("#idperiodo").attr("data-id");
        console.log($idperiodo);
        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}PIP/getTableMonitoreo?id=${$idperiodo}`,
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
                        <option value="ACTIVO">ACTIVO</option>
                        <option value="BORRADOR">BORRADOR</option>
                        <option value="CERRADO">CERRADO</option>
                    </select>
                </div>
            </div>`
                $('div.toolbar').html(tmp);
            },
            columns: [{
                    data: 'name_complete',
                    defaultContent: 'Sin Nombre'
                },
                {
                    data: 'personaPuesto',
                    defaultContent: 'Sin puesto'
                },
                {
                    data: 'Periodo',
                    defaultContent: 'Sin periodo'
                },
                {
                    data: 'estatus',
                    defaultContent: 'Sin estatus'
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
                                        ${(row.estatus == "BORRADOR" ? `<li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="PIP(${row.idPersona},${row.id},${row.evaluacion_periodo_id})">Editar</a></li>` : "")}
                                        ${(row.estatus == "ACTIVO" ? `<li><a style="cursor: pointer;" class="js-add-incidencia" onclick="Redirect(${row.id})">Seguimiento</a></li>` : '')}
                                        ${(row.estatus == "ACTIVO" ? `<li><a style="cursor: pointer;" class="js-add-incidencia" onclick="Cerrar(${row.id})">Cerrar</a></li>` : '')}
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



        window.Redirect = function(id) {
            window.location.replace($path + 'PIP/MonitoreoPIP?id=' + id);
        }

        window.PIP = function($id, $id2, $id3) {
            window.location = $path + "PIP/AgregarPIP/?id=" + $id + "&idp=" + $id2 + "&idpp=" + $id3;
        }


        window.Cerrar = function (id) {
        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"]
        }).then((value) => {
            if (value) {
                //alert("Se eliminara el pip "+id);
                $.ajax({
                    type: 'POST',
                    url: `${$path}PIP/Cerrar`,
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

    });
</script>