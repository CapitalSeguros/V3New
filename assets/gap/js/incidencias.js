$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");
    let dataSet = [];
    $('#chooseFile').bind('change', function (e) {
        var filename = $("#chooseFile").val();
        if (/^\s*$/.test(filename)) {
            $(".file-upload").removeClass('active');
            $("#noFile").text("Archivo no seleccionado...");
        } else {
            var formData = new FormData();
            formData.append("isRequest", true);
            var files = e.target.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                // Add the file to the request.
                formData.append('document', file, file.name);
            }
            Pace.track(function () {
                $.ajax({
                    url: `${$path}incidencias/cargar_documento`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (json) {
                        $(".file-upload").removeClass('error');
                        $(".file-upload").removeClass('active');

                        if (json.code == "400") {
                            $(".file-upload").addClass('error');
                            toastr.error(json.message);
                        } else {
                            $(".file-upload").addClass('active');
                            toastr.success(json.message);
                            dataSet = [];
                            for (const key in json.data) {
                                const element = json.data[key];
                                dataSet.push(element);
                            }
                            datatable.rows.add(dataSet).draw();
                        }
                        $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
                    },
                    complete: function () {

                    }
                });
            });
        }
    });
    const groupColumn = 0;
    const datatable = $("#tb-empleado-incidencia").DataTable({
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        data: dataSet,
        "order": [
            [groupColumn, 'asc']
        ],
        columns: [{
                visible: false,
                targets: groupColumn,
                data: "empleado",
            },
            {
                data: "fecha",
                className: "text-center"
            },
            {
                data: "entrada",
                className: "text-center",
                render: function (data, type, row) {
                    if (data == undefined)
                        return ""
                    else
                        return moment(data).format('LT');
                },
            },
            {
                data: "salida",
                className: "text-center",
                render: function (data, type, row) {
                    if (data == undefined)
                        return ""
                    else
                        return moment(data).format('LT');
                },
            },
            {
                data: "incidencia"
            },
            {
                data: null,
                className: "control text-right",
                "sDefaultContent": '',
                width: '120px',
                orderable: false,
                render: function (data, type, row) {
                    return `<div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.empleado_id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dp${row.empleado_id}">
                                    <li><a href="#" data-js-id="${row.empleado_id}" data-js-fecha="${row.fecha}" class="js-add-incidencia">Agregar incidencia</a></li>
                                </ul>
                            </div>`;
                }
            }
        ],
        "drawCallback": function (settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(groupColumn, {
                page: 'current'
            }).data().each(function (group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                    );
                    last = group;
                }
            });
        }
    });
    $(document).on('click', '.js-add-incidencia', function () {
        const id = $(this).attr("data-js-id");
        const fecha = $(this).attr("data-js-fecha");
        incidencia.show(id,fecha);
    });
    // Order by the grouping
    $('#tb-empleado-incidencia tbody').on('click', 'tr.group', function () {
        var currentOrder = datatable.order()[0];
        if (currentOrder[0] === groupColumn && currentOrder[1] === 'asc') {
            datatable.order([groupColumn, 'desc']).draw();
        } else {
            datatable.order([groupColumn, 'asc']).draw();
        }
    });

    // const incidencia = new Incidencias({
    //     classRender: '.js-incidencias',
    //     actionOpen: '.js-add-incidencia',
    //     reference: 'INCIDENCIAS',
    //     callbackSuccess: function (response) {
            
    //         // datatable.draw();
    //     }
    // });
    // incidencia.init();
});