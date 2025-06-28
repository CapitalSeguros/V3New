<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$tipoPersonas = array(
  'BRONCE',
  'ORO',
  'PLATINO VIP',
  'Comercial',
  'Operativo',
  'Administrativo',
  'Gerencial',
  'Directivo',
  'Operativo Corporativo',
  'Operativo Fianzas',
  'Clientes',
);

function imprimirTiposPersonas($tipos) {
  foreach ($tipos as $tipo) {
    echo '<div class="row">';
    echo '    <button type="button" class="btn btn-default btnTipoPersona" data-tipo-persona="'.htmlspecialchars($tipo).'">';
    echo '      <i class="fa fa-user-plus fa-user-plus-extra"></i>';
    echo '      ' . htmlspecialchars($tipo);
    echo '    </button>';
    echo '</div>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Evaluador</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Loader animado -->
    <style>
        /* HTML: <div class="loader"></div> */
        .loader {
            display: none;
            width: 45px;
            aspect-ratio: 1;
            --c: no-repeat linear-gradient(#000 0 0);
            background:
                var(--c) 0% 50%,
                var(--c) 50% 50%,
                var(--c) 100% 50%;
            background-size: 20% 100%;
            animation: l1 1s infinite linear;
        }

        @keyframes l1 {
            0% {
                background-size: 20% 100%, 20% 100%, 20% 100%
            }

            33% {
                background-size: 20% 10%, 20% 100%, 20% 100%
            }

            50% {
                background-size: 20% 100%, 20% 10%, 20% 100%
            }

            66% {
                background-size: 20% 100%, 20% 100%, 20% 10%
            }

            100% {
                background-size: 20% 100%, 20% 100%, 20% 100%
            }
        }
    </style>

    <!-- css de la view -->
    <style>
        body {
            background-color: #b3b3d6;
        }

        /* Scroll para la lista de botones con los tipos de empleados */
        .scrollable-container {
            height: 650px;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scroll para la tabla de resultados */
        .scrollable-table {
            max-height: 300px;
            overflow-y: auto;
            display: block;
        }

        /* Definimos tamaño maximo para la tabla de resultados */
        .table-container {
            max-height: 400px;
            overflow: hidden;
        }

        /* Ajustes visuales */
        .btnTipoPersona {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            word-wrap: break-word;
            white-space: normal;
        }

        .fa-user-plus-extra {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-2 col-md-2 scrollable-container">
                <?php imprimirTiposPersonas($tipoPersonas); ?>
            </div>

            <div class="col-xs-10 col-md-10 scrollable-container">
                <div class="row well well-sm">
                    <div class="col-xs-10 col-md-10">
                        <?=$nombre;?>
                    </div>
                    <div class="col-xs-2 col-md-2">
                        <button type="button" class="btn btn-info"
                            onclick="obtenerListaArchivos('<?= $folio_nc; ?>')">Archivos</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-6" style="padding-left: 0;">
                        <div class="input-group">
                            <input type="text" id="txtNombreBuscado" class="form-control"
                                placeholder="Buscar empleado...">
                            <span class="input-group-btn">
                                <button id="btnNombreBuscado" class="btn btn-default" type="button"
                                    onclick="buscarEmpleado()">Buscar</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 id="titulo_tabla_personas" class="panel-title">Lista de Empleados</h3>
                        </div>
                        <table class="table table-hover scrollable-table" id="table_personas">
                            <thead id="thead_personas">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Clasificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_personas"></tbody>
                        </table>
                        <div class="loader"></div>
                    </div>
                </div>

                <div class="row well well-sm">
                    <div class="col-xs-4 col-md-4">
                        <h5 style="font-weight: bold;">Agregar Invitados</h5>
                    </div>
                    <div class="col-xs-2 col-md-2"></div>
                    <div class="col-xs-6 col-md-6">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card-o"
                                    aria-hidden="true"></i></span>
                            <input type="text" id="txtAgregarEvalExterno" class="form-control"
                                placeholder="ejemplo@dominio.com">
                            <span class="input-group-btn">
                                <button id="btnAgregarEvalExterno" class="btn btn-default" type="button"
                                    onclick="agregarEvaluadorExterno()">Agregar</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">Evaluadores Asignados</h3>
                        </div>
                        <table class="table table-hover scrollable-table" id="table_evaluadores">
                            <thead id="thead_evaluadores">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_evaluadores"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal para ver la lista de archivos asociados a la incidencia que dio origen a la tarea -->
    <?php $this->load->view('accesorios/seguimiento/modal_archivos.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-storage.js"></script>

    <script>

        const MAX_DATOS = 1000; // Tamaño maximo para activar notificaciones de carga y filtrado en conjuntos grandes de datos
        const BLOQUE_FILAS = 100; // Numero de filas a procesar por iteracion

        $(document).ready(function () {
            inicializarFirebase();
            obtenerListaTiposPersonas();
            obtenerListaEvaluadores();
        });

        /**
         * Inicializa Firebase utilizando la configuración obtenida desde el servidor
         */
        function inicializarFirebase() {
            $.ajax({
                url: '<?= base_url("Firebase/getFirebaseConfig"); ?>',
                type: 'GET',
                success: function (responseString) {
                    let firebaseConfig = JSON.parse(responseString);

                    // Verificamos si Firebase ya fue inicializado
                    if (!firebase.apps.length) {
                        firebase.initializeApp(firebaseConfig);
                        console.log('Firebase inicializado correctamente.');
                    } else {
                        console.log('Firebase ya fue inicializado.');
                    }
                },
                error: function (xhr, status, error) {
                    showSwal('Error: Firebase', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            });
        }

        /**
         * Muestra una alerta basica utilizando SweetAlert
         * 
         * @param {string} title - El titulo de la alerta
         * @param {string} message - El mensaje que se mostrara en la alerta
         * @param {string} [icon='success'] - El icono de la alerta (opcional, valor por defecto 'success').
         */
        function showSwal(title, message, icon = 'success') {
            Swal.fire({
                titleText: title,
                html: message,
                icon: icon
            });
        }

        /**
         * Normaliza un nombre eliminando espacios en blanco, acentos y convirtiendolo a minusculas
         * 
         * @param {string} nombre - El nombre que sera normalizado
         * @returns {string} El nombre normalizado sin espacios en los extremos, sin acentos y en minusculas
         */
        function normalizarNombre(nombre) {
            return nombre.trim() // Recordamos eliminar espacios al inicio y al final del string
                .normalize("NFD") // Descomponemos los caracteres con acentos en su forma base
                .replace(/[\u0300-\u036f]/g, "") // Eliminamos acentos, tildes, etc.
                .toLowerCase(); // Convertimos todo a minusculas
        }

        /**
         * Verifica si un correo electronico tiene un formato valido
         * 
         * @param {string} email - El correo electronico a validar
         * @returns {boolean} `true` si el formato del correo es valido, `false` en caso contrario
         */
        function esEmailValido(email) {
            var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar un email
            return regex.test(email.trim());
        }

        /**
         * Busca y filtra empleados en una tabla segun el nombre ingresado
         * Si el numero de filas es mayor al umbral MAX_DATOS definido, muestra un indicador de carga durante el filtrado
         */
        function buscarEmpleado() {
            const nombreBuscado = normalizarNombre($('#txtNombreBuscado').val());
            const filas = $('#tbody_personas tr');
            let index = 0;

            // Verificar si hay muchas filas para filtrar
            if (filas.length > MAX_DATOS) {
                Swal.fire({
                    title: 'Filtrando datos',
                    text: 'Por favor, espera mientras se filtran los datos.',
                    icon: 'info',
                    showCloseButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            /* Funcion interna para procesar las tandas de datos */
            function filtrarFilas() {
                const fragment = document.createDocumentFragment(); // Usar un fragmento para mejorar el rendimiento
                const max = Math.min(BLOQUE_FILAS, filas.length - index); // Procesamos hasta 100 filas

                for (let i = 0; i < max; i++) {
                    const fila = $(filas[index++]);
                    const nombreEnFila = normalizarNombre(fila.find('td:nth-child(2)').text()); // Obtiene el texto del segundo td

                    if (nombreEnFila.includes(nombreBuscado)) {
                        fila.show();
                        fragment.appendChild(fila[0]); // Agregar al fragmento solo si se muestra
                    } else {
                        fila.hide();
                    }
                }

                // Añadir las filas filtradas al DOM
                $('#tbody_personas').append(fragment);

                // Si quedan más filas, llamar a filtrarFilas de nuevo
                if (index < filas.length) {
                    setTimeout(filtrarFilas, 0); // Dejar que el navegador procese otros eventos
                } else {
                    Swal.close(); // Cerrar el Swal al finalizar el proceso
                }
            }

            filtrarFilas(); // Iniciamos el proceso de filtrado
        }

        /**
         * Obtenemos la lista de personas en base al boton presionado
         */
        function obtenerListaTiposPersonas() {
            let btnTipoPersona = document.querySelectorAll('.btnTipoPersona');

            // Añadimos un evento de clic a cada boton
            btnTipoPersona.forEach(function (button) {
                button.addEventListener('click', function () {
                    $('#tbody_personas').empty();
                    $('.loader').show();
                    let tipo_persona = this.getAttribute('data-tipo-persona');
                    $('#titulo_tabla_personas').text('Lista de ' + tipo_persona);

                    $.ajax({
                        url: '<?= base_url("seguimiento/EvaluadorTarea/obtenerListaPersonas") ?>',
                        type: 'POST',
                        data: { tipo_persona: tipo_persona },
                        success: function (responseString) {
                            let response = JSON.parse(responseString);

                            if (response.length > 0) {
                                mostrarListaPersonas(response);
                            } else {
                                showSwal('Aviso', 'No se encontraron resultados.', 'info');
                            }
                        },
                        error: function (xhr, status, error) {
                            showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                        }
                    }).always(function () {
                        $('.loader').hide();
                    });
                });
            });
        }

        /**
         * Obtenemos la lista de evaluadores asignados a la tarea actual
         */
        function obtenerListaEvaluadores() {
            $('#tbody_evaluadores').empty();

            $.ajax({
                url: '<?= base_url("seguimiento/EvaluadorTarea/obtenerListaEvaluadores") ?>',
                type: 'POST',
                data: { id_tarea: '<?= $idtarea; ?>' },
                success: function (responseString) {
                    let response = JSON.parse(responseString);

                    if (response.length > 0) {
                        mostrarListaEvaluadores(response);
                    }
                },
                error: function (xhr, status, error) {
                    showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            });
        }

        /**
         * Llenamos la tabla de resultados con los datos de la lista de personas recibidas
         */
        function mostrarListaPersonas(datos) {
            const tbody = document.getElementById('tbody_personas');

            // Removemos el event listener existente antes de añadir uno nuevo
            tbody.removeEventListener('click', manejarBotonAgregarEvaluador);

            // Verificar si el tamaño de datos es mayor que cierto umbral
            if (datos.length > MAX_DATOS) {
                Swal.fire({
                    title: 'Cargando datos',
                    text: 'Por favor, espera mientras se cargan los datos.',
                    icon: 'info',
                    showCloseButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            let index = 0;

            /* Funcion interna para procesar las tandas de datos */
            function agregarFilas() {
                const fragment = document.createDocumentFragment(); // Usar un fragmento para mejorar el rendimiento

                const max = Math.min(BLOQUE_FILAS, datos.length - index);

                for (let i = 0; i < max; i++) {
                    const dato = datos[index++];
                    const fila = document.createElement('tr');

                    fila.innerHTML = `
                    <td>${dato.idPersona}</td>
                    <td>${dato.nombres}</td>
                    <td>${(dato.emailUsers && dato.emailUsers !== '0') ? dato.emailUsers : dato.emailPersonal}</td>
                    <td>${dato.idpersonarankingagente}</td>
                    <td><button class="btn btn-success btnAgregarPersona" data-id-persona="${dato.idPersona}">Agregar</button></td>
                    `;

                    fragment.appendChild(fila);
                }

                tbody.appendChild(fragment);

                // Si quedan más filas, llamar a agregarFilas de nuevo
                if (index < datos.length) {
                    setTimeout(agregarFilas, 0); // Dejar que el navegador procese otros eventos
                } else {
                    Swal.close(); // Cerrar el Swal al finalizar el proceso

                    // Agregamos el event listener después de agregar todas las filas
                    tbody.addEventListener('click', manejarBotonAgregarEvaluador);
                }
            }

            agregarFilas(); // Iniciamos el proceso de carga de la tabla de resultados
        }

        /**
         * Llenamos la tabla de evaluadores asignados con los datos recibidos
         */
        function mostrarListaEvaluadores(datos) {
            const tbody = document.getElementById('tbody_evaluadores');

            // Removemos el event listener existente antes de añadir uno nuevo
            tbody.removeEventListener('click', manejarBotonEliminarEvaluador);
            tbody.removeEventListener('click', manejarBotonEliminarEvalExterno);

            datos.forEach(dato => {
                const fila = document.createElement('tr');

                if (dato.es_invitado == '1') {
                    fila.innerHTML = `
                    <td>${dato.id_pproyectos}</td>
                    <td>${dato.nombre_persona}</td>
                    <td>${dato.email_persona}</td>
                    <td><button class="btn btn-danger btnEliminarEvalExterno">Eliminar</button></td>
                    `;
                } else {
                    fila.innerHTML = `
                    <td>${dato.id_persona}</td>
                    <td>${dato.nombre_persona}</td>
                    <td>${dato.email_persona}</td>
                    <td><button class="btn btn-danger btnEliminarEvaluador">Eliminar</button></td>
                    `;
                }

                tbody.appendChild(fila);
            });

            // Agregamos el event listener para los botones "Agregar"
            tbody.addEventListener('click', manejarBotonEliminarEvaluador);
            tbody.addEventListener('click', manejarBotonEliminarEvalExterno);
        }

        /**
         * Maneja el evento de agregar una persona(evaluador) a la tarea al hacer clic en el boton correspondiente
         * 
         * @param {Event} event - El evento de clic en el boton para agregar a la persona
         */
        function manejarBotonAgregarEvaluador(event) {
            if (event.target && event.target.classList.contains('btnAgregarPersona')) {
                const fila = event.target.closest('tr');
                const celdas = fila.getElementsByTagName('td');

                const idPersona = celdas[0].textContent;
                const nombres = celdas[1].textContent;
                const email = celdas[2].textContent;
                const idRankingAgente = celdas[3].textContent;

                const datos_evaluador = {
                    'idtarea': '<?=$idtarea;?>',
                    'idPersona': idPersona,
                    'nombres': nombres,
                    'email': email,
                    'idrankingagente': idRankingAgente
                };

                Swal.fire({
                    title: 'Confirmación',
                    text: "¿Desea asignar al evaluador a la tarea?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        asignarEvaluador(datos_evaluador);
                    }
                });
            }
        }

        /**
         * Maneja el evento de eliminar una persona(evaluador) de la tarea al hacer clic en el boton correspondiente
         * 
         * @param {Event} event - El evento de clic en el boton para eliminar a la persona
         */
        function manejarBotonEliminarEvaluador(event) {
            if (event.target && event.target.classList.contains('btnEliminarEvaluador')) {
                const fila = event.target.closest('tr');
                const celdas = fila.getElementsByTagName('td');

                const id_persona = celdas[0].textContent;

                const datos_evaluador = {
                    'id_tarea': '<?=$idtarea;?>',
                    'id_persona': id_persona
                };

                Swal.fire({
                    title: 'Confirmación',
                    text: "¿Desea remover al evaluador de la tarea?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarEvaluador(datos_evaluador);
                    }
                });
            }
        }

        /**
         * Maneja el evento de eliminar una persona(evaluador) externa de la tarea al hacer clic en el boton correspondiente
         * 
         * @param {Event} event - El evento de clic en el boton para eliminar a la persona externa
         */
        function manejarBotonEliminarEvalExterno(event) {
            if (event.target && event.target.classList.contains('btnEliminarEvalExterno')) {
                const fila = event.target.closest('tr');
                const celdas = fila.getElementsByTagName('td');

                const id_pproyecto = celdas[0].textContent;
                const email_persona = celdas[2].textContent;

                const datos_invitado = {
                    'id_tarea': '<?= $idtarea; ?>',
                    'id_pproyecto': id_pproyecto,
                    'email_persona': email_persona
                };

                Swal.fire({
                    title: 'Confirmación',
                    text: "¿Desea remover al evaluador de la tarea?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        eliminarEvaluadorExterno(datos_invitado);
                    }
                });
            }
        }

        /**
         * Asigna un evaluador a una tarea mediante una solicitud AJAX al controlador <seguimiento/EvaluadorTarea/asignarEvaluador>
         * 
         * @param {Object} datos - Un objeto que contiene la informacion del evaluador y la tarea
         * @param {string} datos.idtarea - El ID de la tarea a la que se asignara el evaluador
         * @param {string} datos.idPersona - El ID de la persona que se asignara como evaluador
         * @param {string} datos.nombres - El nombre de la persona que se asignara como evaluador
         * @param {string} datos.email - El correo electronico de la persona que se asignara como evaluador
         * @param {string} datos.idrankingagente - El tipo de evaluador ('Clientes' o 'Operativo')
         */
        function asignarEvaluador(datos) {
            $.ajax({
                url: '<?= base_url("seguimiento/EvaluadorTarea/asignarEvaluador") ?>',
                type: 'POST',
                data: {
                    id_tarea: datos['idtarea'],
                    id_proyecto: '<?= $idproyecto; ?>',
                    tipo_evaluador: datos['idrankingagente'] === 'Clientes' ? 'CLIENTES' : 'OPERATIVO',
                    id_persona: datos['idPersona'],
                    nombre_persona: datos['nombres'],
                    email_persona: datos['email'],
                    es_invitado: false
                },
                success: function (responseString) {
                    let response = JSON.parse(responseString);

                    if (response.asignado) {
                        showSwal(response.status === 'success' ? 'Éxito' : 'Aviso', response.mensaje, response.status);
                    } else {
                        showSwal('Error', response.mensaje, response.status);
                    }
                },
                error: function (xhr, status, error) {
                    showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            }).always(function () {
                obtenerListaEvaluadores();
            });
        }

        /**
         * Elimina un evaluador de una tarea mediante una solicitud AJAX al controlador <seguimiento/EvaluadorTarea/eliminarEvaluador>
         * 
         * @param {Object} datos - Un objeto que contiene la informacion del evaluador a eliminar
         * @param {string} datos.id_tarea - El ID de la tarea de la que se eliminara el evaluador
         * @param {string} datos.id_persona - El ID de la persona que se eliminara como evaluador
         */
        function eliminarEvaluador(datos) {
            $.ajax({
                url: '<?= base_url("seguimiento/EvaluadorTarea/eliminarEvaluador") ?>',
                type: 'POST',
                data: {
                    id_tarea: datos['id_tarea'],
                    id_persona: datos['id_persona']
                },
                success: function (responseString) {
                    let response = JSON.parse(responseString);

                    if (response.eliminado) {
                        showSwal(response.status === 'success' ? 'Éxito' : 'Aviso', response.mensaje, response.status);
                    } else {
                        showSwal('Error', response.mensaje, response.status);
                    }
                },
                error: function (xhr, status, error) {
                    showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            }).always(function () {
                obtenerListaEvaluadores();
            });
        }

        /**
         * Agrega un evaluador externo a una tarea mediante una solicitud AJAX al controlador <seguimiento/EvaluadorTarea/asignarEvaluador>
         */
        function agregarEvaluadorExterno() {
            let email_invitado = $('#txtAgregarEvalExterno').val().trim();
            if (esEmailValido(email_invitado)) {
                Swal.fire({
                    title: 'Confirmación',
                    text: "¿Desea invitar al evaluador de la tarea?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'No, cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url("seguimiento/EvaluadorTarea/asignarEvaluador") ?>',
                            type: 'POST',
                            data: {
                                id_tarea: '<?= $idtarea; ?>',
                                tipo_evaluador: 'EXTERNO',
                                id_persona: 0,
                                nombre_persona: email_invitado,
                                email_persona: email_invitado,
                                es_invitado: true,
                                id_proyecto: '<?= $idproyecto; ?>'
                            },
                            success: function (responseString) {
                                let response = JSON.parse(responseString);

                                if (response.asignado) {
                                    showSwal(response.status === 'success' ? 'Éxito' : 'Aviso', response.mensaje, response.status);
                                    $('#txtAgregarEvalExterno').val('');
                                } else {
                                    showSwal('Error', response.mensaje, response.status);
                                }
                            },
                            error: function (xhr, status, error) {
                                showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                            }
                        }).always(function () {
                            obtenerListaEvaluadores();
                        });
                    }
                });
            } else {
                showSwal('Aviso', 'Debe ingresar un correo electrónico válido.', 'info');
            }
        }

        /**
         * Elimina un evaluador externo de una tarea mediante una solicitud AJAX al controlador <seguimiento/EvaluadorTarea/eliminarEvaluadorExterno>
         * 
         * @param {Object} datos - Un objeto que contiene la informacion del evaluador a eliminar
         * @param {string} datos.id_tarea - El ID de la tarea de la que se eliminara el evaluador externo
         * @param {string} datos.id_pproyecto - El ID del proyecto asociado al evaluador externo
         * @param {string} datos.email_persona - El correo electronico del evaluador externo a eliminar
         */
        function eliminarEvaluadorExterno(datos) {
            $.ajax({
                url: '<?= base_url("seguimiento/EvaluadorTarea/eliminarEvaluadorExterno") ?>',
                type: 'POST',
                data: {
                    id_tarea: datos['id_tarea'],
                    id_pproyecto: datos['id_pproyecto'],
                    email_persona: datos['email_persona']
                },
                success: function (responseString) {
                    let response = JSON.parse(responseString);

                    if (response.eliminado) {
                        showSwal(response.status === 'success' ? 'Éxito' : 'Aviso', response.mensaje, response.status);
                    } else {
                        showSwal('Error', response.mensaje, response.status);
                    }
                },
                error: function (xhr, status, error) {
                    showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            }).always(function () {
                obtenerListaEvaluadores();
            });
        }


        /**
         * Obtiene la lista de archivos de las diferentes carpetas de inconformidades
         * en Firebase Storage con base al folio proporcionado
         *
         * @param {string} folio - El folio para identificar las carpetas en Firebase Storage
         * @returns {Promise<void>} - Retorna una promesa que se resuelve cuando se han obtenido los archivos
         */
        function obtenerListaArchivos(folio) {
            $('#modal_archivos_eval_tarea').modal('show');

            if (folio == '') return;
            
            const storageRefInconforme = firebase.storage().ref('inconformidades/' + folio + '/inconforme/');
            const storageRefResuelto = firebase.storage().ref('inconformidades/' + folio + '/resuelto/');
            const storageRefResponsable = firebase.storage().ref('inconformidades/' + folio + '/administrador/');

            // Obtenemos los archivos de cada storage
            Promise.all([
                storageRefInconforme.listAll(),
                storageRefResuelto.listAll(),
                storageRefResponsable.listAll()
            ]).then(([inconformeFiles, resueltoFiles, responsableFiles]) => {
                // Limpiamos el contenido previo de cada lista
                $('#lista_inconforme').empty();
                $('#lista_resuelto').empty();
                $('#lista_responsable').empty();

                // Función interna para agregar los archivos a los <ul>
                const agregarArchivosALista = (files, listaId) => {
                    files.forEach(file => {
                        const fileName = file.name;

                        // Obtenemos la referencia del archivo
                        const storageRef = firebase.storage().ref(file.fullPath);

                        // Obtenemos la URL de descarga
                        storageRef.getDownloadURL().then(function (url) {
                            // Creamos un nuevo elemento <li>
                            const li = document.createElement('li');
                            li.className = 'list-group-item';

                            // Creamos un nuevo elemento <a>
                            const a = document.createElement('a');
                            a.href = url;
                            a.textContent = fileName;
                            a.target = "_blank";

                            // Agregamos el enlace al <li> y luego el <li> al <ul>
                            li.appendChild(a);
                            document.getElementById(listaId).appendChild(li);
                        }).catch(error => {
                            showSwal('Error: Firebase', 'No se pudo obtener la URL del archivo: ' + error.message, 'error');
                        });
                    });
                };

                // Agregamos los archivos a cada lista que le corresponde
                agregarArchivosALista(inconformeFiles.items, 'lista_inconforme');
                agregarArchivosALista(resueltoFiles.items, 'lista_resuelto');
                agregarArchivosALista(responsableFiles.items, 'lista_responsable');
            }).catch(error => {
                console.error('Error al obtener archivos:', error);
            });
        }
    </script>
</body>

</html>