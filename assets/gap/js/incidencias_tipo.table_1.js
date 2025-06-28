$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");

    $("#AddTipoIncidencia").submit(function (event) {
        event.preventDefault(); //prevent default action 
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        console.log("DATA",form_data)

        $.ajax({
            url: post_url,
            type: request_method,
            data: form_data
        }).done(function (response) {
            if (response.code == "200") {
                toastr.success("Se guardo con éxito.");
                datatable2.ajax.reload();
            } else {
                toastr.error("Ocurrio un error al guardar el elemento.");
            }
            $('#modalTipo').modal('hide');

        });
    });

    ///metodos para la edicion e eliminación de los tipos de incidencias
    window.eliminar2 = function (id) {

        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}incidencias/deleteTipoIncidencia`,
                    data: {
                        "id": id
                    },
                    success: function (data) {
                        datatable2.ajax.reload();
                    },
                    error: function (data) {

                    }
                });
            }
        });
    }

    
    //scripts de la tabla incidencias
    const datatable2 = $('#example').DataTable({
        pageLength : 5,
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}incidencias/getTipoIncidencia`,
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
                    <input type="text" placeholder="Buscar..." id="txSearch" class="form-control input-sm"  name="search"  />
                </div>
            </div>`
            $('div.toolbar').html(tmp);

        },
        columns: [{
                data: 'nombre'
            },
            {
                data: 'descripcion'
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
                                <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="Editar(${row.id})">Editar</a></li>
                                <li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar2(${row.id})">Eliminar</a></li>
                            </ul>
                        </div>
                    `;
                }
            }
        ],
        order: [
            [1, 'desc']
        ]
    });

    window.Editar = function (id) {
        console.log("id",id);
        const _data = datatable2.rows().data();
        const oInci = _.find(_data, function (it) {
            return it.id == id;
        });
        console.log("Data",oInci);
        $('input[name=nombre]').val(oInci.nombre);
        $('input[name=id2]').val(oInci.id);
        $('input[name=descripcion]').val(oInci.descripcion);
        $('#cbNotificacion').val(oInci.notificacion);
        $('#modalTipo').modal('show');
        return;
    }


    window.openModal = function () {
        $('input[name=id2]').val(0);
        $('input[name=nombre]').val("");
        $('input[name=descripcion]').val("");
        $('#cbNotificacion').val("");
        $('#modalTipo').modal('show');
    }
});