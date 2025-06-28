<section class="container-fluid breadcrumb-formularios">
    <a id="N" data-IdNotificacion='<?= $idNotificacion; ?>'></a>
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Solicitudes de bonos</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 100%;">
        <div class="row">
            
            <div class="col-md-6 text-left">
                <!--Modificacion Miguel Jaime 15-12-2021-->
                <div style="width: 70%;">
                    <label for="filterByCoord" class="form-label">Filtro por Coordinación:</label>
                    <select class="form-control" id="filterByCoord">
                        <option></option>
                    </select>
                </div>
                <!--Fin de Modificacion-->
            </div>
            <div class="form-group col-md-6 text-right">
                <button class="bn-sol-bono btn-primary btn-sm btn pull-right" data-in-id="0">Solicitar</button>
            </div>
        </div>
        <br>

        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="example">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Empleado</th>
                            <th scope="col">Importe inicial</th>
                            <th scope="col">Importe Final</th>
                            <th scope="col">Fecha de inicial</th>
                            <th scope="col">Fecha de aplicacion</th>
                            <th scope="col">Estatus</th>
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
<div>
    <!--<button onclick="getListColaboradores()" class="btn btn-primary">Test</button>-->
</div>
<div id="bonos-container"></div>
<div class="modal-seguimiento-container"></div>
<div class="modal-autorizar-container"></div>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");
        const $IdNotificacion = $("#N").attr("data-IdNotificacion");
        const ModuloBonos = new Bonos({
            selector: '#bonos-container',
            selectorAction: '.bn-sol-bono',
            selectorView: '.bn-bono-view',
            callBack: function() {
                datatable.ajax.reload();
            },
            Tipo: /* 'Usuario' */ '2'
        });
        ModuloBonos.init();

        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Bonos/getTableBonos`,
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'id',

                }, {
                    data: 'name_complete'
                }, {
                    data: 'importe',
                    className: "text-center",
                    render: function(data, type, row) {
                        return "$" + data + ".00";
                    }
                }, {
                    data: 'importe_final',
                    defaultContent: 'Sin aprobar',
                    className: "text-center",
                    render: function(data, type, row) {
                        return data === "0" ? 'Sin valor asignado' : "$" + data + ".00";
                    }
                },
                {
                    data: 'fecha',
                    defaultContent: 'Sin descripción',
                    className: "text-center",
                    render: function(data, type, row) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                {
                    data: 'fecha_aplicacion',
                    defaultContent: 'Sin descripción',
                    className: "text-center",
                    render: function(data, type, row) {
                        return data === "0000-00-00" ? 'Sin valor asignado' : moment(data).format('DD/MM/YYYY');
                    }
                },
                {
                    data: 'estatus',
                    defaultContent: 'Sin puesto asignado',
                    className: "text-center",
                    width: '100px',
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

        if ($IdNotificacion !== '') {
            setTimeout(function() {
                datatable.column(0).search($IdNotificacion).draw();
            }, 1000);

        }

        window.OpenM = function($id) {
            $("input[id=BonoID]").val($id);
            $("button[id=editar]").click();
        }
        window.Recharge = function() {
            datatable.ajax.reload();
        }



        window.IdSolicitud = function() {
            var clickedValue = $(this).find('li:data-id').val();
            console.log(clickedValue);
        }

        window.getDataHistorial = function(id) {
            $.ajax({
                url: `${$path}Bonos/getSeguimiento/${id}`,
                method: 'GET',
                dateType: 'json',
                success: function(response) {
                    window.modalModalSeguimiento.show("Seguimiento de bonos", response.data)
                }
            });

        }

         window.getListColaboradores = function() {
            $.ajax({
                url: `${$path}listColaboradores`,
                method: 'GET',
                dateType: 'json',
                success: function(response) {
                    alert(response.data);
                }
            });

        }
    });
</script>

<!--modal de las aciiones de las tablas-->