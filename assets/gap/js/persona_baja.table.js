    $(document).ready(function() {
        loadTableTB();

        $('#NuevoTB').click(function() {
            $('#tituloTB').text("Agregar Tipo Baja");
            $('#EditarTB').addClass('hidden');
            $('#GuardarTB').removeClass('hidden');
            $('#modalTipoBaja').modal({
                show: true,
                keyboard: false,
                backdrop: false,
            });
        })

        $('#RefreshTB').click(function() {
            loadTableTB();
        })

        $('#GuardarTB').click(function() {
            agregarTipoBaja();
        })


        $('#EditarTB').click(function() {
            const id = document.getElementById('idTipoBaja').value;
            const valor = document.getElementById('nombreTipoBaja').value;
            console.log(id, valor);
            $.ajax({
                type: 'POST',
                url: `${path}permisosOperativos/updateTipoBaja`,
                data: {
                    id: id,
                    nm: valor
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

    function loadTableTB() {
        $.ajax({
            type: 'GET',
            url: `${path}permisosOperativos/getTipoBaja`,
            beforeSend: (load) => {
                $('#Container-TB').html(`
                    <div class="load-spinner-table">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: (data) => {
                //console.log(data);
                const r = JSON.parse(data);
                //console.log(r);
                $('#Container-TB').html(`
                    <table class="table" id="TablaTipoBaja">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col" style='text-align: center;'>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="list-body-baja"></tbody>
                    </table>`);
                trtd = ``;

                for (var a in r) {
                    const nombre = r[a].nombre;
                    const id = r[a].id;
                    trtd += `
                    <tr data-tipoBajaid="${id}">
                        <td>${nombre}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dp${id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" >
                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right"  aria-labelledby="dp${id}">
                                    <li>
                                        <a style="cursor: pointer;" class="openModal" data-idtb="${id}" data-nametb="${nombre}" onclick="editarTipoBaja(this)">
                                            Editar
                                        </a>
                                    </li>
                                    <li>
                                        <a style="cursor: pointer;" class="openModal" data-idtb="${id}" data-nametb="${nombre}" onclick="eliminarTipoBaja(this)">
                                            Eliminar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>`;
                }
                $('.list-body-baja').html(trtd);
                $('#TablaTipoBaja').DataTable({//1075.89 355.52
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

    function editarTipoBaja(dato) {
        const id = $(dato).data('idtb');
        const nombre = $(dato).data('nametb');

        $('#tituloTB').text("Editar Tipo Baja");
        $('#idTipoBaja').val(id);
        $('#nombreTipoBaja').val(nombre);
        $('#EditarTB').removeClass('hidden');
        $('#GuardarTB').addClass('hidden');

        $('#modalTipoBaja').modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }

    function agregarTipoBaja() {
        const nombre = document.getElementById('nombreTipoBaja').value;

        $.ajax({
            type: 'POST',
            url: `${path}permisosOperativos/addTipoBaja`,
            data: {
                nm: nombre
            },
            success: (data) => {
                swal("¡Listo!", "Se ha agregado exitósamente.", "success");
            },
            error: (error) => {
                swal("¡Vaya!", "Ha ocurrido un problema.", "error");
            }
        })
    }

    function eliminarTipoBaja(dato) {
        const id = $(dato).data('idtb');
        swal({
            title: "¿Está seguro que desea eliminarlo?",
            text: "Una vez eliminado no podrá recuperar el elemento.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: 'POST',
                    url: `${path}permisosOperativos/deleteTipoBaja`,
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