window.editar = function (id) {
    const _data = datatable.rows().data();
    const model = _.find(_data, function (it) {
        return it.id == id;
    });
    $('#txNombre').val(model.nombre);
    $('#id').val(model.id);
    $('#mdBaja').appendTo("body").modal('show');
    //$('#mdBaja').appendTo("body").modal('show');
};

$(document).ready(function () {
    //$.noConflict();
    const $path = $("#base_url").attr("data-base-url");
    const datatable = $('#baja').DataTable({
        pageLength : 5,
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}personas/get_baja`,
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [{
                data: 'nombre'
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
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="editar(${row.id})">Editar</a></li>
                            <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})">Eliminar</a></li>
                        </ul>
                    </div>`;
                }
            }
        ],
        "order": [
            [0, 'asc']
        ]
    });

    $(document).on('click', '.bnNuevo', function (e) {
        console.log('open');
        e.preventDefault();
        $('#txNombre').val('');
        $('#id').val('');
        $('#mdBaja').appendTo("body").modal('show');
        //$('#mdBaja').modal('show');
    });

    
    window.eliminar = function (id) {
        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}personas/baja/delete`,
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

    $("#addSaveBaja").submit(function (event) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function (response) {
            if (response.code == "200") {
                toastr.success("Se guardo con éxito.");
                datatable.ajax.reload();
            } else {
                toastr.error("Ocurrio un error al guardar el elemento.");
            }
            $('#mdBaja').modal('hide');

        });
    });


})