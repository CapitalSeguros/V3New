<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones">Catálogo de competencias</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>

<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
    <div style="float: left; width: 90%;">
        <div class="row">
            <div class="form-group text-right col-md-12">
                <a href="<?= base_url() ?>Competencias/AgregarCompetencia" class="btn btn-primary btn-sm">Nuevo</a>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table" id="example">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Puesto</th>
                                    <th scope="col" style='text-align: center;'>Acciones</th>
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

<div id="mymodal" class="modal bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header titulos">
                <h4 class="modal-title" id="exampleModalLabel">Vista previa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="surveyElement"></div>
            </div>
            <!--final del form modal-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        const $path = $("#base_url").attr("data-base-url");

        window.Eliminar = function(id) {
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
                            url: `${$path}Competencias/deleteCompetencia`,
                            data: {
                                'id': id,
                            },
                            success: function(data) {
                                var json = data;
                                //console.log(json);
                                if (json.data === 0) {
                                    toastr.success(data.message);
                                    datatable.ajax.reload();
                                } else {
                                    toastr.error('No se puede eliminar la competencia');
                                }
                            },
                            error: function(xhr) {
                                console.log('error', xhr);
                            }
                        });
                    }
                });

        }

        window.EditarCompencia = function(id) {
            $.ajax({
                type: 'POST',
                url: `${$path}Competencias/Comprobacion`,
                data: {
                    'id': id,
                },
                success: function(data) {
                    var json = data;
                    //console.log(json);
                    if (json.data === 0) {
                        var value1 = id;
                        var queryString = "?id=" + value1;
                        window.open($path + "Competencias/AgregarCompetencia" + queryString, '_blank');
                    } else {
                        toastr.error('No se puede editar la competencia');
                    }
                },
                error: function(xhr) {
                    console.log('error', xhr);
                }
            });
            //window.location.href = $path+"Competencias/AgregarCompetencia" + queryString;
        }

        const datatable = $('#example').DataTable({
            language: {
                url: `${$path}assets/js/espanol.json`
            },
            ajax: {
                url: `${$path}Competencias/getTablaCompetencias`,
                type: 'GET',
                dataSrc: 'data'
            },
            columns: [{
                    data: 'nombre'
                },
                {
                    data: 'descripcion',
                    defaultContent: 'Sin descripción'
                },
                {
                    data: 'puesto',
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
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" onclick="getInfoCompetencia(${row.id})">Vista previa</a></li>
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" id="editar2" onclick="EditarCompencia(${row.id})" >Editar</a></li>
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" onclick="Eliminar(${row.id})">Eliminar</a></li>
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

        window.getInfoCompetencia = function(id) {
            $.ajax({
                type: 'POST',
                url: `${$path}Competencias/getDataUpdate?id=${id}`,
                data: {
                    'id': id,
                },
                success: function(data) {
                    const datos = data.data.listQuestion;
                    datos.sort((a, b) => a.orden - b.orden);
                    var filas = [];
                    var columns;
                    if (data.data.listQuestion[0].tipo_pregunta_id === "7") {
                        var cells = {};
                        datos.forEach(element => {
                            var json_content = JSON.parse(element.template);
                            columns = Object.keys(json_content);
                            var fila = {
                                "value": element.descripcion,
                                "text": element.titulo
                            }
                            cells[element.descripcion] = json_content;
                            filas.push(fila);
                        });
                        stringDta = {
                            "elements": [{
                                "type": "matrix",
                                "name": "temp-matrix",
                                "title": data.data.Informacion[0].titulo,
                                "columns": columns,
                                "rows": filas,
                                "cells": cells
                            }]
                        };
                    } else {
                        var preguntas = [];
                        datos.forEach(element => {
                            var json_content = JSON.parse(element.template);
                            preguntas.push(json_content);
                        });
                        stringDta = {
                            "elements": preguntas
                        };
                        //console.log(stringDta);
                    }
                    Survey.StylesManager.applyTheme("bootstrap");
                    window.survey = new Survey.Model(stringDta);
                    $("#surveyElement").Survey({
                        model: survey,
                    });
                    $('#mymodal').modal('show');
                },
                error: function(xhr) {
                    //console.log('error', xhr);
                }
            });
        }



    });
</script>