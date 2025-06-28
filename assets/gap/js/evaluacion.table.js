const $path = $("#base_url").attr("data-base-url");

// const persona = new Personas({
//     classRender: '.js-persona-baja',
//     actionOpen: '.bn-per-baja',
//     callbackSuccess: function (response) {
//         datatable.ajax.reload();
//         // datatable.draw();
//     }
// });
// persona.init();

// const configurarEvaluacion = new ConfigurarEvaluacion({
//     classRender: '.js-modal-configurar',
//     actionOpen: '.bn-js-eva-confg',
//     callbackSuccess: function (response) {
//         datatable.ajax.reload();
//         // datatable.draw();
//     }
// });
// configurarEvaluacion.init();


//
$(document).ready(function () {

    $(document).on('input', '#txSearch', function (e) {
        datatable
            .search(e.currentTarget.value)
            .draw();
    });

    let datatable = $('#tbEvaluacion').DataTable({
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}evaluaciones/getData`,
            type: 'GET',
            dataSrc: 'data'
        },
        ordering: false,
        // searching: false,
        dom: '<"toolbar">rtip ',
        initComplete: function () {
            var tmp = `<div class="row">
                <div class="col-sm-3">
                    <label>Buscar </label>
                    <input type="text" placeholder="Buscar..." autocomplete="off" id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
            </div>`
            $('div.toolbar').html(tmp);

        },
        columns: [{
                data: 'titulo'
            },
            {
                data: 'tipo_evaluacion',
                className: "control text-center",
            },
            {
                data: 'tipo_periodo',
                className: "control text-center",
                render: function (data, type, row) {
                    var tipo = "No aplica"
                    switch (data) {
                        case "1":
                            tipo = "Mensual";
                            break;
                        case "2":
                            tipo = "Bimestral";
                            break;
                        case "3":
                            tipo = "Trimestral";
                            break;
                        case "6":
                            tipo = "Semestral";
                            break;
                        case "12":
                            tipo = "Anual";
                            break;
                    }
                    return tipo;
                }
            },
            {
                width: '50px',
                data: 'estatus'
            },
            {
                data: null,
                "sClass": "control text-right",
                "sDefaultContent": '',
                width: '40px',
                orderable: false,
                render: function (data, type, row) {
                    return `
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${row.id}">
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" href="evaluaciones/editar/${row.id}">Editar</a></li>
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})">Eliminar</a></li>
                        </ul>
                    </div>
                `;
                }
            }
        ],
    });


    window.eliminar = function (id) {
        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"]
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}evaluaciones/delete`,
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