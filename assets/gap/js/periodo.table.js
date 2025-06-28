$(document).ready(function () {
    const $path = $("#base_url").attr("data-base-url");

    $("#AddTipoIncidencia").submit(function (event) {
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
            $('#modalTipo').modal('hide');

        });
    });

    ///metodos para la edicion e eliminación de los tipos de incidencias
    window.eliminar = function (id) {

        swal({
            title: "¿Está seguro de que quiere eliminar el elemento seleccionado?",
            text: "Una vez eliminado, ¡no podrá recuperar el elemento!",
            icon: "warning",
            buttons: {
                cancel: true,
                confirm: true,
            },
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}periodo/eliminar/${id}`,
                    success: function (data) {
                        datatable.ajax.reload();
                    },
                    error: function (data) {

                    }
                });
            }
        });
    }

    window.cerrar = function (id) {

        swal({
            title: "¿Está seguro de que quiere cerrar el periodo?",
            text: "Una vez cerrado, ¡no se podrá realizar cambios!",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${$path}periodo/cerrar/${id}`,
                    success: function (data) {
                        datatable.ajax.reload();
                    },
                    error: function (data) {

                    }
                });
            }
        });
    }

    window.editar = function (id) {

        const _data = datatable.rows().data();
        const oInci = _.find(_data, function (it) {
            return it.id == id;
        });
        $('input[name=nombre]').val(oInci.nombre);
        $('input[name=id]').val(oInci.id);
        $('input[name=descripcion]').val(oInci.descripcion);
        $('#cbNotificacion').val(oInci.notificacion);
        $('#modalTipo').modal('show');
        return;
    }
    //scripts de la tabla incidencias
    const datatable = $('#example').DataTable({
        language: {
            url: `${$path}assets/js/espanol.json`
        },
        ajax: {
            url: `${$path}periodo/getAll`,
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
                <div class="col-sm-3">
                    <label>Estatus </label>
                    <select class="form-control input-sm"  id="cbEstado" name="4">
                        <option value="">Todos</option>
                        <option value="BORRADOR">BORRADOR</option>
                        <option value="LIBERADO">LIBERADO</option>
                        <option value="CERRADO">CERRADO</option>
                    </select>
                </div>
            </div>`
            $('div.toolbar').html(tmp);

        },
        columns: [{
                data: 'titulo'
            },
            {
                data: 'fecha_inicio',
                "sClass": "text-center",
                render: function (data, type, row) {
                    var fecha=new Date(data);
                    return moment(fecha).format("DD/MM/YYYY");
                }
            },
            {
                data: 'tiempo_evaluacion',
                "sClass": "text-center",
                render: function (data, type, row) {
                    var fecha=new Date(data);
                    return moment(fecha).format("DD/MM/YYYY");
                }
            },
            {
                data: 'tipo_periodo',
                "sClass": "text-center",
                render: function (data, type, row) {
                    return data == "O" ? "Ordinaria" : "ExtraOrdinaria";
                }
            },
            {
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
                                ${(row.estatus == "BORRADOR" ? `<li><a href="#" style="cursor: pointer;" class="bnLiberar" data-in-id="${row.id}" >Liberar</a></li>` : "")}
                                ${(row.estatus != "BORRADOR" ? `<li><a href="${$path}evaluaciones/tablero/${row.id}" style="cursor: pointer;" class="bnTablero" data-in-id="${row.id}" >Ver</a></li>` : "")}
                                ${(row.estatus == "LIBERADO" ? `<li><a href="#" style="cursor: pointer;" class="bnCerrar" onclick="cerrar(${row.id})" data-in-id="${row.id}" >Cerrar</a></li>` : "")}
                                ${(row.estatus == "BORRADOR" ? `<li><a href="periodo/editar/${row.id}" style="cursor: pointer;" class="openModal" data-in-id="${row.id}" >Editar</a></li>` : "")}
                                ${(row.estatus == "BORRADOR" ? `<li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="eliminar(${row.id})">Eliminar</a></li>` : "")}
                                ${(row.estatus == "CERRADO" ? `<li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="PIP(${row.id})">PIP</a></li>` : "")}
                                ${(row.estatus == "CERRADO" ? `<li><a style="cursor: pointer;" class="openModal" data-in-id="${row.id}" onclick="clonar(${row.id})">Generar siguiente</a></li>` : "")}
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

    $(document).on('input', '#cbEstado', function (e) {
        datatable
            .column(e.currentTarget.name)
            .search(e.currentTarget.value)
            .draw();
    });

    
    $(document).on('input', '#txSearch', function(e) {
        //console.log('input search');
        datatable
            .search(e.currentTarget.value)
            .draw();
    });


    window.openModal = function () {
        $('input[name=id]').val(0);
        $('input[name=nombre]').val("");
        $('input[name=descripcion]').val("");
        $('#cbNotificacion').val("");
        $('#modalTipo').modal('show');
    }

    window.PIP = function (id) {
        $.ajax({
            type: 'POST',
            url: `${$path}PIP/generar?id=${id}`,
            success: function (response) {

                if (response.code == "200") {
                    toastr.success("Se guardo con éxito.");
                    window.location = $path + "PIP/" + id;
                } else {
                    toastr.error("Ocurrio un error al guardar el elemento.");
                }

            },
            error: function (data) {

            }
        });

    }
    window.clonar = function (id) {
        $.ajax({
            type: 'POST',
            url: `${$path}periodo/clonar/${id}`,
            success: function (response) {

                if (response.code == "200") {
                    toastr.success("Se guardo con éxito.");
                    datatable.ajax.reload();
                } else {
                    toastr.error("Ocurrio un error al guardar el elemento.");
                }
            },
            error: function (data) {

            }
        });

    }

    const modalLiberar = new ModalLiberar({
        selector: '#modalLiberar',
        AccionOpen: '.bnLiberar',
        callback: function () {
            datatable.ajax.reload();
        }
    });
    modalLiberar.init();

    window.OpenM = function ($id) {
        $("input[id=PeridoID]").val($id);
        $("button[id=editar]").click();
        //$("#exampleModalCenter").modal("show");
    }

});