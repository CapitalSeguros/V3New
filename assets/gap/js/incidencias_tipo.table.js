    $(document).ready(function() {
        loadTableTI();

        $('#NuevoTI').click(function() {
            $('#tituloTI').text("Agregar Tipo Incidencia");
            $('#EditarTI').addClass('hidden');
            $('#GuardarTI').removeClass('hidden');
            $('#modalTipoIncidencia').modal({
                show: true,
                keyboard: false,
                backdrop: false,
            });
        })

        $('#RefreshTI').click(function() {
            loadTableTI();
        })

        $('#GuardarTI').click(function() {
            agregarTipoIncidencia();
        })


        $('#EditarTI').click(function() {
            const id = document.getElementById('idTipoIncidencia').value;
            const nombre = document.getElementById('nombreTipoIncidencia').value;
            const descripcion = document.getElementById('descripcionTipoIncidencia').value;
            //console.log(id, valor);
            $.ajax({
                type: 'POST',
                url: `${path}permisosOperativos/updateTipoIncidencia`,
                data: {
                    id: id,
                    nm: nombre,
                    ds: descripcion
                },
                success: (data) => {
                    swal("¡Guardado!", "Se ha actualizado exitósamente.", "success");
                },
                error: (error) => {
                    swal("¡Vaya!", "Ha ocurrido un problema.", "error");
                }
            })
        })
    })
    
    function loadTableTI() {
        $.ajax({
            type: 'GET',
            url: `${path}permisosOperativos/getTipoIncidencia`,
            beforeSend: (load) => {
                $('#Container-TI').html(`
                    <div class="load-spinner-table">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: (data) => {
                //console.log(data);
                //const r = data['data']; //Con el url: ${path}incidencias/getTipoIncidencia
                const r = JSON.parse(data);
                //console.log(r);

                $('#Container-TI').html(`
                    <table class="table" id="TablaTipoInc">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripción</th>
                                <th scope="col" style='text-align: center;'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="list-body-incidencias"></tbody>
                    </table>`);
                trtd = ``;

                for (var a in r) {
                    const id = r[a].id;
                    const nombre = r[a].nombre;
                    const descripcion = r[a].descripcion;
                    trtd += `
                    <tr data-tipoBajaid="${id}">
                        <td>${nombre}</td>
                        <td>${descripcion}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="di${id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="di${id}">
                                    <li>
                                        <a style="cursor: pointer;" class="openModal" data-idti="${id}" data-nameti="${nombre}" data-descrti="${descripcion}" onclick="editarTipoIncidencia(this)">
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a style="cursor: pointer;" class="openModal" data-idti="${id}" data-nameti="${nombre}" data-descrti="${descripcion}" onclick="eliminarTipoIncidencia(this)">
                                            Eliminar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
                }
                $('.list-body-incidencias').html(trtd);
                const datatable2 = $('#TablaTipoInc').DataTable({//1075.89 355.52
                    language: {
                        url: `${path}assets/js/espanol.json`
                    },
                    ordering: false,
                    // columns:[
                    // {
                    //     sortable: true,
                    //     orderable: true,
                    // },
                    // {
                    //     sortable: true,
                    //     orderable: true,
                    // },
                    // {
                    //     sortable: false,
                    //     orderable: false,
                    // }],
                    //order: [['0', 'asc']],
                });
            },
            error: (error) => {
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
    }

    function editarTipoIncidencia(dato) {
        const id = $(dato).data('idti');
        const nombre = $(dato).data('nameti');
        const descripcion = $(dato).data('descrti');

        $('#tituloTI').text("Editar Tipo Incidencia");
        $('#idTipoIncidencia').val(id);
        $('#nombreTipoIncidencia').val(nombre);
        $('#descripcionTipoIncidencia').val(descripcion);
        $('#EditarTI').removeClass('hidden');
        $('#GuardarTI').addClass('hidden');

        $('#modalTipoIncidencia').modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function agregarTipoIncidencia() {
        const nombre = document.getElementById('nombreTipoIncidencia').value;
        const descripcion = document.getElementById('descripcionTipoIncidencia').value;
        //console.log(nombre, descripcion);
        $.ajax({
            type: 'POST',
            url: `${path}permisosOperativos/addTipoIncidencia`,
            data: {
                nm: nombre,
                ds: descripcion
            },
            success: (data) => {
                swal("¡Listo!", "Se ha agregado exitósamente.", "success");
            },
            error: (error) => {
                swal("¡Vaya!", "Ha ocurrido un problema.", "error");
            }
        })
    }

    function eliminarTipoIncidencia(dato) {
        const id = $(dato).data('idti');
        swal({
            title: "¿Está seguro que desea eliminarlo?",
            text: "Una vez eliminado no podrá recuperar el elemento.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${path}permisosOperativos/deleteTipoIncidencia`,
                    data: {
                        id: id
                    },
                    success: function (data) {
                        swal("¡Eliminado!", "Se ha borrado exitósamente.", "success");
                    },
                    error: function (data) {
                        swal("¡Vaya!", "Hay problemas al intentar borrar.", "error");
                    }
                });
            }
        });
    }