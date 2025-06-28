$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");

    const pregunta = new Pregunta({
        selector: '#jfileupload', //es el id del div
        reference: 'INCIDENCIAS', // es el nombre de la referencia
        referenceId: 5,
        //getFiles: '<?= base_url() ?>uploaDocuments/getFiles?ref=',
        postFiles: `${$path}Preguntas/addPregunta`,
    });
    pregunta.init();
    $('#listPreguntas').addClass('textNew');
    $('#listPreguntas').html('No se ha agregado ninguna opción');

    const datatable = $('#example').DataTable({
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}Preguntas/getPreguntasTable`,
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [{
                data: 'titulo'
            },
            {
                data: 'nombre',
                className: "text-center"
            },
            {
                data: null,
                "sClass": "control",
                "sDefaultContent": '',
                width: '120px',
                "orderable": false,
                render: function (data, type, row) {
                    return `
                        <div style="text-align: center;">
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.Idp}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" onclick="editPregunta(${row.Idp})">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dp${row.Idp}">
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" id="ver" onclick="getInfoPregunta(${row.Idp})" >Vista previa</a></li>
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" id="editar2" onclick="clickEdiatr(${row.Idp})">Editar</a></li>
                                        <li><a style="cursor: pointer;" class="js-add-incidencia" onclick="EliminarPregunta(${row.Idp})">Eliminar</a></li>
                                    </ul>
                                </div>
                        </div>`;
                }
            }
        ],
    });

    window.getInfoPregunta = function (id) {
        $('input[id=idRow]').val(`${$path}Preguntas/editPregunta?ref=` + id);
        $.ajax({
            type: 'POST',
            url: `${$path}Preguntas/getPregunta`,
            data: {
                'id': id,
            },
            success: function (data) {
                //console.log(data.data[0].id);
                var stringDta = '';
                Survey.StylesManager.applyTheme("bootstrap");
                var json = data.data;
                var json_content = JSON.parse(json[0].json_content);
                //console.log('json_content',json_content);
                if (json[0].clave === "matrix") {
                    var cells = {};

                    cells[json[0].descripcion] = json_content;
                    //console.log(cells);
                    stringDta = {
                        "elements": [{
                            "type": "matrix",
                            "name": "temp-matrix",
                            "title": json[0].titulo,
                            "columns": Object.keys(json_content),
                            "rows": [{
                                "value": json[0].descripcion,
                                "text": json[0].titulo
                            }],
                            "cells": cells
                        }]
                    };
                    //console.log
                } else {
                    stringDta = {
                        "elements": [json_content]
                    };
                }
                window.survey = new Survey.Model(stringDta);
                $("#surveyElement").Survey({
                    model: survey,
                });
                $('#mymodal').modal('show');
            },
            error: function (xhr) {
                console.log('error', xhr);
            }
        });
    }

    window.EliminarPregunta = function (id) {
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
                    url: `${$path}Preguntas/deletePregunta`,
                    data: {
                        'id': id,
                    },
                    success: function (data) {
                        var json = data;
                    //console.log(json);
                        if (json != 1) {
                            $('div[id=danger]').append("Hubo un error, intentelo mas tarde");
                            $('div[id=danger]').removeClass("hidden");
                        } else {
                            $('#mymodal').modal('hide');
                        }
                        datatable.ajax.reload();
                        toastr.success(data.message);
                    },
                    error: function (xhr) {
                        console.log('error', xhr);
                    }
                });
            } 
    });
    }


    window.editPregunta = function (id) {
        $('input[id=idRow]').val(`${$path}Preguntas/editPregunta?ref=` + id);

    }

    window.clickEdiatr = function (id) {
        //$('input[id=idRow]').val(`${$path}Preguntas/editPregunta?ref=`+id);
        $('button[id=editar]').click();
    }

    window.rechageTable = function () {
        datatable.ajax.reload();
        //console.log('Se actualizo la tabla');
    }

    $("#exampleModalCenter").on('hidden.bs.modal', function () {
        datatable.ajax.reload();
    });

});