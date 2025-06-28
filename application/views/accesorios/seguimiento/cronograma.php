<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Cronograma</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />

        <style>
            html,
            body {
                height: 100%;
                margin: 0;
            }

            .container-fluid {
                height: 100vh;
                display: flex;
                flex-direction: column;
            }

            thead {
                position: sticky;
                top: 0;
                background-color: #fff;
                z-index: 3;
            }

            thead th.proyecto_header,
            thead th.detalles_header {
                position: sticky;
                left: 0;
                background-color: #fff;
                z-index: 3;
            }

            thead th.detalles_header {
                left: 0;
            }

            tbody .proyecto_cell,
            tbody .detalles_cell {
                position: sticky;
                left: 0;
                background-color: #fff;
                z-index: 2;
            }

            tbody .detalles_cell {
                left: 0;
            }

            .table-responsive {
                flex: 1;
                overflow-x: auto;
                overflow-y: auto;
            }

            .calendar {
                min-width: 330px;
                min-height: 455px;
                width: auto;
                height: auto;
                z-index: 1;
            }

            .calendar-container {
                display: flex;
                justify-content: center;
                flex-wrap: nowrap;
            }

            .custom-tooltip {
                background-color: #333;
                color: #fff;
                padding: 5px;
                border-radius: 3px;
                font-size: 12px;
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                z-index: 4;
                position: absolute;
            }

            #row_cabecera {
                background-color: #2b3d6c;
                color: whitesmoke;
            }

            .detalles_cell {
                max-width: 330px;
                overflow-wrap: break-word;
            }

            .ul_tareas {
                max-height: 455px;
                overflow-y: auto;
            }

            .li_tareas {
                max-height: 100px; /* Establece la altura máxima del <li> */
                overflow-x: auto; /* Habilita el scroll vertical si el contenido excede la altura */
                /*padding: 10px; /* Opcional: ajusta el padding si es necesario */
                white-space: nowrap; /* Opcional: evita que el texto se rompa en líneas */
                /*text-overflow: ellipsis; /* Opcional: añade '...' si el texto es demasiado largo */
                /*border: 1px solid #ddd; /* Opcional: estilo del borde */
            }

            /*.fc-event-title-container {
                line-height: 0.7; /* Ajusta la altura de línea para que se vea más delgado
            }*/

            /*.fc-daygrid-day-frame {
                height: 50px;
                overflow-y: auto;
                overflow-x: auto;
            }*/
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div id="row_cabecera" class="row">
                <div class="col-xs-2 col-md-2">
                    <h1>CRONOGRAMA</h1>
                </div>
                <div class="col-xs-7 col-md-7"></div>
                <div class="col-xs-2 col-md-2">
                    <div class="form-group">
                        <label for="select_trimestre">Trimestre:</label>
                        <select class="form-control" id="select_trimestre">
                            <option value="1">T1 (Ene - Mar)</option>
                            <option value="2">T2 (Abr - Jun)</option>
                            <option value="3">T3 (Jul - Sep)</option>
                            <option value="4">T4 (Oct - Dic)</option>
                            <option value="5">Mostrar todos</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-1 col-md-1">
                    <div class="form-group">
                        <label for="select_anio">Año:</label>
                        <select class="form-control" id="select_anio">
                            <?php
                                $initial_year = 2024;
                                $current_year = date("Y");
                                for($initial_year ; $initial_year <= $current_year; $initial_year++){
                                    $selected = ($initial_year == $current_year) ? "selected" : "";
                                    echo "<option value='{$initial_year}' {$selected}>{$initial_year}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div id="row_cronograma" class="row table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="proyecto_header">Nombre del proyecto</th>
                            <th class="detalles_header">Detalles</th>
                            <th class="colT1">T1</th>
                            <th class="colT2">T2</th>
                            <th class="colT3">T3</th>
                            <th class="colT4">T4</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_cronograma"></tbody>
                    <tfoot id="tfoot_cronograma" hidden>
                        <tr>
                            <td colspan="6">
                                <p><b>Promedio de días que utilizó cada responsable en completar una tarea:</b></p>
                                <ul id="ul_promedios_responsables" class="list-group"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <script>
            const COLORES = ["dodgerblue", "darkorange", "green", "blue", "rebeccapurple"];
            let tareas_completadas = null;
            let registros_vacaciones = null;

            /**
             * Muestra una alerta basica utilizando SweetAlert
             *
             * @param {string} title - El titulo de la alerta
             * @param {string} message - El mensaje que se mostrara en la alerta
             * @param {string} [icon='success'] - El icono de la alerta (opcional, valor por defecto 'success').
             */
            function showSwal(title, message, icon = "success") {
                Swal.fire({
                    titleText: title,
                    html: message,
                    icon: icon,
                });
            }

            /**
             * Muestra un mensaje de espera usando sweetalert2
             */
            function mostrarSwalLoader() {
                Swal.fire({
                    title: "Cargando cronograma...",
                    html: "Por favor, espere.",
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });
            }

            /**
             * Devuelve el trimestre actual
             */
            function obtenerTrimestreActual() {
                const mesActual = new Date().getMonth() + 1;
                return Math.ceil(mesActual / 3);
            }

            /**
             * Mostramos todas las columnas de los trimestres
             */
            function mostrarTodosTrimestres() {
                for (let i = 1; i <= 4; i++) {
                    $(`.colT${i}`).show();
                }
            }

            /**
             * Muestra la columna de un trimestre en especifico mientras se ocultan las restantes
             */
            function mostrarTrimestre(trimestre) {
                $("#select_trimestre").val(trimestre);

                calcularPromediosResponsables(trimestre);

                if (trimestre == 5) {
                    mostrarTodosTrimestres();
                    return;
                }

                for (let i = 1; i <= 4; i++) {
                    $(`.colT${i}`).hide();
                }

                $(`.colT${trimestre}`).show();
            }

            /**
             * Mostramos en pantalla la info del trimestre actual
             */
            function inicializarTrimestreActual() {
                const trimestre_actual = obtenerTrimestreActual();
                let txt_base = $(`#select_trimestre option[value='${trimestre_actual}']`).text();
                if (!txt_base.includes("[Actual]")) {
                    $(`#select_trimestre option[value='${trimestre_actual}']`).text(txt_base + " [Actual]");
                }
                mostrarTrimestre(5);
            }

            /**
             * Genera los calendarios para cada trimestre por proyecto
             *
             * @param {object} data_proyectos - Objeto con los datos de los proyectos y sus respectivas tareas
             */
            function inicializarCalendarios(data_proyectos) {
                return new Promise((resolve) => {
                    let yearActual = new Date().getFullYear();
                    let color_actual = 0;
                    for (let idproyecto in data_proyectos) {
                        for (let mes = 1; mes <= 12; mes++) {
                            let calendarEl = document.getElementById(`calendar_${idproyecto}_${mes}`);
                            if (calendarEl) {
                                let eventos = [];
                                data_proyectos[idproyecto].tareas.forEach((tarea, indice) => {
                                    let num_tarea = indice + 1;

                                    if (tarea.fecha_creacion !== null) {
                                        let estatus_tarea = tarea.estatus.find(estatus => estatus.tipo_accion === "Crear");
                                        let descripcion = "";

                                        if (estatus_tarea !== undefined) {
                                            descripcion = `<b>Fecha de creación por: ${estatus_tarea.nombre_usuario}</b><br/>` + tarea.nombre_tarea;
                                        } else {
                                            descripcion = "<b>Fecha de creación</b><br/>" + tarea.nombre_tarea;
                                        }

                                        let date_start = tarea.fecha_creacion.split(" ")[0];

                                        let estatus_creacion = {
                                            title: num_tarea,
                                            description: descripcion,
                                            start: date_start,
                                            backgroundColor: COLORES[color_actual],
                                            borderColor: "black",
                                        };

                                        if (date_start.split('-')[1] == mes) eventos.push(estatus_creacion);
                                    }

                                    if (tarea.fecha_entrega !== null) {
                                        let estatus_tarea = tarea.estatus.find(estatus => estatus.tipo_accion === "Programar");
                                        let descripcion = "";

                                        if (estatus_tarea !== undefined) {
                                            descripcion = `<b>Fecha de entrega establecida por: ${estatus_tarea.nombre_usuario}</b><br/>` + tarea.nombre_tarea;
                                        } else {
                                            descripcion = "<b>Fecha de entrega</b><br/>" + tarea.nombre_tarea;
                                        }

                                        let date_start = tarea.fecha_entrega;
                                        let estatus_entrega = {
                                            title: num_tarea,
                                            description: descripcion,
                                            start: date_start,
                                            backgroundColor: COLORES[color_actual],
                                            borderColor: "black",
                                        };

                                        if (date_start.split('-')[1] == mes) eventos.push(estatus_entrega);
                                    }

                                    if (tarea.estatus.length !== 0) {
                                        tarea.estatus.forEach((c_estatus) => {
                                            if (c_estatus.tipo_accion === "Completar") {
                                                let date_start = c_estatus.fecha_evento.split(" ")[0];
                                                let estatus_personalizado = {
                                                    title: num_tarea,
                                                    description: "<b>" + c_estatus.descripcion_accion + " por: " + c_estatus.nombre_usuario + "</b><br/>" + tarea.nombre_tarea,
                                                    start: date_start,
                                                    backgroundColor: COLORES[color_actual],
                                                    borderColor: "black",
                                                };
                                                if (date_start.split('-')[1] == mes) eventos.push(estatus_personalizado);
                                            }
                                        });
                                    }

                                    if (tarea.fecha_produccion !== null) {
                                        let estatus_tarea = tarea.estatus.find(estatus => estatus.tipo_accion === "Desplegar");
                                        let descripcion = "";

                                        if (estatus_tarea !== undefined) {
                                            descripcion = `<b>Tarea marcada como puesta en producción por: ${estatus_tarea.nombre_usuario}</b><br/>` + tarea.nombre_tarea;
                                        } else {
                                            descripcion = "<b>Tarea puesta en producción</b><br/>" + tarea.nombre_tarea;
                                        }

                                        let date_start = tarea.fecha_produccion.split(" ")[0];
                                        let estatus_produccion = {
                                            title: num_tarea,
                                            description: descripcion,
                                            start: date_start,
                                            backgroundColor: COLORES[color_actual],
                                            borderColor: "black",
                                        };

                                        if (date_start.split('-')[1] == mes) eventos.push(estatus_produccion);
                                    }

                                    if (tarea.responsables.length !== 0) {
                                        tarea.responsables.forEach((responsable) => {
                                            if (responsable.registro === null) return;

                                            let nombre_responsable = responsable.nombre ? responsable.nombre : responsable.correo + " (Invitado)";
                                            let date_start = responsable.registro.split(" ")[0];
                                            let estatus_responsable = {
                                                title: num_tarea,
                                                description: "<b>Se asigna responsable: " + nombre_responsable + "</b><br/>" + tarea.nombre_tarea,
                                                start: date_start,
                                                backgroundColor: COLORES[color_actual],
                                                borderColor: "black",
                                            };

                                            if (date_start.split('-')[1] == mes) eventos.push(estatus_responsable);
                                        });
                                    }

                                    if (tarea.evaluadores.length !== 0) {
                                        tarea.evaluadores.forEach((evaluador) => {
                                            if (evaluador.fecha_asignacion === null) return;

                                            let nombre_evaluador = evaluador.nombre_persona;
                                            if (nombre_evaluador.includes('@')) nombre_evaluador += " (Invitado)";

                                            let descripcion = "";
                                            if (evaluador.asignadopor_nombre !== '0') {
                                                descripcion = "<b>Se asigna evaluador: " + nombre_evaluador + ", por: " + evaluador.asignadopor_nombre + "</b><br/>" + tarea.nombre_tarea;
                                            } else {
                                                descripcion = "<b>Se asigna evaluador: " + nombre_evaluador + "</b><br/>" + tarea.nombre_tarea;
                                            }

                                            let date_start = evaluador.fecha_asignacion.split(" ")[0];
                                            let estatus_evaluador = {
                                                title: num_tarea,
                                                description: descripcion,
                                                start: date_start,
                                                backgroundColor: COLORES[color_actual],
                                                borderColor: "black",
                                            };

                                            if (date_start.split('-')[1] == mes) eventos.push(estatus_evaluador);
                                        });
                                    }
                                });

                                let calendar = new FullCalendar.Calendar(calendarEl, {
                                    initialView: "dayGridMonth",
                                    locale: "es",
                                    initialDate: `${yearActual}-${mes < 10 ? "0" + mes : mes}-01`,
                                    headerToolbar: {
                                        left: "", // No se muestra controles de navegacion
                                        center: "title", // Solo el titulo (nombre del mes)
                                        right: "", // No se muestran controles adicionales
                                    },
                                    titleFormat: {
                                        month: "long",
                                    },
                                    events: eventos,
                                    eventMouseEnter: function (info) {
                                        // Mostrar el tooltip
                                        let tooltip = document.createElement("div");
                                        tooltip.className = "custom-tooltip";
                                        tooltip.innerHTML = info.event.extendedProps.description;
                                        document.body.appendChild(tooltip);

                                        // Posicionar el tooltip cerca del cursor
                                        tooltip.style.position = "absolute";
                                        tooltip.style.left = info.jsEvent.pageX + 10 + "px";
                                        tooltip.style.top = info.jsEvent.pageY + 10 + "px";
                                    },
                                    eventMouseLeave: function (info) {
                                        // Ocultar el tooltip
                                        let tooltips = document.getElementsByClassName("custom-tooltip");
                                        while (tooltips.length > 0) {
                                            tooltips[0].parentNode.removeChild(tooltips[0]);
                                        }
                                    },
                                });
                                calendar.render();
                            }
                        }
                        color_actual++;
                        if (color_actual > COLORES.length) color_actual = 0;
                    }
                    resolve();
                });
            }

            /**
             * Agrupa la lista de tareas por proyecto
             *
             * @param {array} datos - Arreglo con los datos de las tareas recibidas desde el servidor
             * @return {object} Los tareas ya agrupadas
             */
            function agruparDatosPorProyecto(datos) {
                let data_proyectos = {};

                let contador = 1;
                datos.forEach((fila) => {
                    if (fila.fechaCreacion !== null) {
                        if (!data_proyectos.hasOwnProperty(fila.idproyecto)) {
                            data_proyectos[fila.idproyecto] = {};
                            data_proyectos[fila.idproyecto]["nombre_proyecto"] = fila.nombre_proyecto;
                            data_proyectos[fila.idproyecto]["tareas"] = [];
                            contador = 1;
                        }
                        data_proyectos[fila.idproyecto]["tareas"].push({
                            nombre_tarea: contador + ".- " + fila.nombre_tarea,
                            fecha_creacion: fila.fechaCreacion,
                            fecha_entrega: fila.fechaentrega,
                            fecha_produccion: fila.fechaEnProduccion,
                            fecha_finaliza: fila.finalizaTiempo,
                            estatus: fila.estatus,
                            responsables: fila.responsables,
                            evaluadores: fila.evaluadores,
                        });
                        contador++;
                    }
                });

                return data_proyectos;
            }


            /**
             * Extrae todas las tareas completadas y las agrupa por responsable
             * 
             * @param {object} datos_proyectos - Objeto con todas las tareas a procesar
             * @return {object} Las tareas completadas ya agrupadas
            */
            function obtenerTareasCompletadasPorResponsable(datos_proyectos) {
                let tareas_completadas = {};
                let tareas_completas_por_responsable = {};

                for (let idproyecto in datos_proyectos) {
                    if (!tareas_completadas.hasOwnProperty(idproyecto)) tareas_completadas[idproyecto] = [];
                    datos_proyectos[idproyecto].tareas.forEach((tarea) => {
                        if (tarea.fecha_finaliza && tarea.responsables.length !== 0) tareas_completadas[idproyecto].push(tarea);
                    });
                }

                for (let idproyecto in tareas_completadas) {
                    let tareas = tareas_completadas[idproyecto];
                    tareas.forEach((tarea) => {
                        tarea.responsables.forEach((responsable) => {
                            let correo = responsable.correo.trim();
                            if (!tareas_completas_por_responsable.hasOwnProperty(correo)) tareas_completas_por_responsable[correo] = {
                                nombre: responsable.nombre,
                                idpersona: responsable.idpersona,
                                completadas: []
                            };
                            tareas_completas_por_responsable[responsable.correo]['completadas'].push({
                                fecha_inicial: responsable.registro,
                                fecha_final: tarea.fecha_finaliza
                            });
                        });
                    });
                }

                return tareas_completas_por_responsable;
            }

            function esVacaciones(idPersona, fecha) {
                const fechaConsulta = new Date(fecha);

                for (let registro of registros_vacaciones) {
                    if (idPersona != 0 && registro.idPersona === idPersona) {
                        const fechaSalida = new Date(registro.fecha_salida);
                        const fechaRetorno = new Date(registro.fecha_retorno);

                        if (fechaConsulta >= fechaSalida && fechaConsulta <= fechaRetorno) {
                            return true;
                        }
                    }
                }

                return false;
            }

            /**
             * Calcula el numero de dias habiles entre dos fecha, excluyendo fines de semana y fechas inhabiles
             * 
             * @param {string} diaInicial - La fecha inicial para el conteo
             * @param {string} diaFInal - La fecha final para el conteo
             * @param {array} diasInhabiles - Arreglo de strings con las fechas especificas a excluir en el conteo
             * @return {number} El numero de dias habiles calculados
            */
            function calcularDiasHabiles(idPersona, diaInicial, diaFinal, diasInhabiles = []) {
                try {
                // Obtenemos solo la parte "YYYY-MM-DD" de las fechas
                diaInicial = diaInicial.split(' ')[0];
                diaFinal = diaFinal.split(' ')[0];

                const fechaInicial = new Date(diaInicial);
                const fechaFinal = new Date(diaFinal);

                // Validamos que la fecha inicial sea menor o igual que la fecha final
                if (fechaInicial > fechaFinal) return 0;

                let diasHabiles = 0;

                // Iteramos desde la fecha inicial hasta la fecha final
                for (let fecha = new Date(fechaInicial); fecha <= fechaFinal; fecha.setDate(fecha.getDate() + 1)) {
                    const diaSemana = fecha.getDay();
                    const esFinDeSemana = (diaSemana === 0 || diaSemana === 6); // Domingo o Sábado

                    const fechaStr = fecha.toISOString().split('T')[0];

                    // Si no es fin de semana y no está en el arreglo de días inhábiles, se cuenta como día hábil
                    if (!esFinDeSemana && !esVacaciones(idPersona, fechaStr) && !diasInhabiles.includes(fechaStr)) {
                        diasHabiles++;
                    }
                }

                return diasHabiles;
                } catch (error) {
                    console.error('error', error);
                    return 0;
                }
            }

            /**
             * Calcula el promedio de dias que le toma a cada responsable completar una tarea
             * 
             * @param {number} trimestre - El trimestre actual a evaluar
            */
            function calcularPromediosResponsables(trimestre) {
                let promedios = [];

                $('#ul_promedios_responsables').empty();

                const params = new URLSearchParams(window.location.search);
                if (!params.has('idproyecto')) {
                    $('#tfoot_cronograma').hide();
                    return;
                }
                $('#tfoot_cronograma').show();

                let ids_responsables = [];
                for (let correo_responsable in tareas_completadas) {
                    let idpersona_responsable = tareas_completadas[correo_responsable].idpersona;
                    if (!ids_responsables.includes(idpersona_responsable)) ids_responsables.push(idpersona_responsable);
                }

                let anio = $('#select_anio').val();

                $.ajax({
                    url: '<?= base_url("seguimiento/Cronograma/obtenerVacacionesUsuario"); ?>',
                    type: "POST",
                    data: {
                        ids_personas: ids_responsables,
                        year: anio
                    },
                    dataType: 'json',
                    success: function (response) {
                        registros_vacaciones = response;
                        if (trimestre == 5) {
                            for (let correo_responsable in tareas_completadas) {
                                let nombre_responsable = tareas_completadas[correo_responsable].nombre;
                                let idpersona_responsable = tareas_completadas[correo_responsable].idpersona;
                                let dias_habiles = 0;
                                let total_tareas = tareas_completadas[correo_responsable].completadas.length;
                                tareas_completadas[correo_responsable].completadas.forEach((tarea) => {
                                    let diasHabiles = calcularDiasHabiles(idpersona_responsable, tarea.fecha_inicial, tarea.fecha_final);
                                    dias_habiles += diasHabiles;
                                });
                                promedios.push({
                                    responsable: nombre_responsable,
                                    idpersona: idpersona_responsable,
                                    dias_habiles: dias_habiles,
                                    total_tareas: total_tareas
                                });
                            }
                        } else {
                            for (let correo_responsable in tareas_completadas) {
                                let nombre_responsable = tareas_completadas[correo_responsable].nombre;
                                let idpersona_responsable = tareas_completadas[correo_responsable].idpersona;
                                let dias_habiles = 0;
                                let total_tareas = tareas_completadas[correo_responsable].completadas.length;
                                tareas_completadas[correo_responsable].completadas.forEach((tarea) => {
                                    const date = new Date(tarea.fecha_final);
                                    const month = date.getMonth();
                                    const trimestreFecha = Math.floor(month / 3) + 1;

                                    if (trimestreFecha == trimestre) {
                                        let diasHabiles = calcularDiasHabiles(idpersona_responsable, tarea.fecha_inicial, tarea.fecha_final);
                                        dias_habiles += diasHabiles;
                                    }
                                });
                                promedios.push({
                                    responsable: nombre_responsable,
                                    idpersona: idpersona_responsable,
                                    dias_habiles: dias_habiles,
                                    total_tareas: total_tareas
                                });
                            }
                        }

                        promedios.forEach((promedio) => {
                            if (promedio.responsable) {
                                $('#ul_promedios_responsables').append(`<li class="list-group-item"><b>${promedio.responsable}:</b> ${(promedio.dias_habiles / promedio.total_tareas).toFixed(2)} días</li>`);
                            }
                        });
                    },
                    error: function (xhr, status, error) {
                        showSwal("Error", "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, "error");
                    },
                });
            }

            /**
             * Genera los <li> de las tareas
             *
             * @param {array} tareas - Arreglo con los datos de las tareas
             * @return {string} La cadena de texto con los <li> generados
             */
            function obtenerListaTareas(tareas) {
                let li = "";
                tareas.forEach((tarea) => {
                    li += `<li class="list-group-item li_tareas">${tarea.nombre_tarea}</li>\n`;
                });
                return li;
            }

            /**
             * Calcular las estadisticas de completado de las tareas para cada proyecto
             * 
             * @param {array} tareas - Arreglo con los datos de las tareas
             * @return {string} La cadena de texto con las estadisticas calculadas
             */
            function generarEstadisticasTareas(tareas) {
                let num_tareas = tareas.length;
                let num_completadas = 0;
                tareas.forEach((tarea) => {
                    if (tarea.fecha_finaliza) num_completadas++;
                });

                let porcentaje_completado = (num_completadas / num_tareas) * 100;

                let txt_html = `
                    <p><b>No. de tareas:</b> ${num_tareas}</p>
                    <p><b>No. de completadas:</b> ${num_completadas}</p>
                    <p><b>Porcentaje completado:</b> ${porcentaje_completado.toFixed(2)}%</p>
                `;

                return txt_html;
            }

            /**
             * Genera las columnas de cada trimestre con el id del proyecto al que pertenecen
             *
             * @param {number} idproyecto - ID del proyecto actual
             * @return {string} La cadena de texto con los <td> de los trimestres
             */
            function generarColumnasTrimestres(idproyecto) {
                const columnas = Array(4)
                    .fill()
                    .map((_, trimestre) => {
                        const trimestre_actual = trimestre * 3 + 1;
                        const calendars = Array.from({ length: 3 }, (_, i) => `<div class="calendar" id="calendar_${idproyecto}_${trimestre_actual + i}"></div>`).join("");

                        return `
                            <td class="colT${trimestre + 1}">
                                <div class="calendar-container">
                                    ${calendars}
                                </div>
                            </td>
                        `;
                    })
                    .join("");

                return columnas;
            }

            /**
             * Genera dinamicamente el tbody de nuestra tabla
             *
             * @param {object} data_proyectos - Objeto con los datos de los proyectos y sus respectivas tareas
             */
            function generarTablaCronograma(data_proyectos) {
                const tbody = document.getElementById("tbody_cronograma");
                tbody.innerHTML = "";

                for (let idproyecto in data_proyectos) {
                    const tr = document.createElement("tr");

                    tr.innerHTML = `
                        <td class="proyecto_cell">
                            <p class="well well-sm"><b>${data_proyectos[idproyecto].nombre_proyecto}</b></p>
                            ${generarEstadisticasTareas(data_proyectos[idproyecto].tareas)}
                        </td>
                        <td class="detalles_cell">
                            <ul class="list-group ul_tareas">
                                ${obtenerListaTareas(data_proyectos[idproyecto].tareas)}
                            </ul>
                        </td>
                        ${generarColumnasTrimestres(idproyecto)}
                    `;

                    tbody.appendChild(tr);
                }
            }

            /**
             * Inicia el proceso para generar el cronograma personal y mostrarlo en pantalla
             */
            function cargarCronograma(anio) {
                mostrarSwalLoader();

                let datos_busqueda = {
                    year: anio
                };

                const params = new URLSearchParams(window.location.search);
                if (params.has('idproyecto')) {
                    const idproyecto = params.get('idproyecto');
                    datos_busqueda['idproyecto'] = idproyecto;
                }

                $.ajax({
                    url: '<?= base_url("seguimiento/Cronograma/obtenerDatosCrono"); ?>',
                    type: "POST",
                    data: datos_busqueda,
                    success: function (responseString) {
                        let datos = null;
                        try {
                            datos = JSON.parse(responseString);
                        } catch (error) {
                            console.error("error al parsear datos", error);
                            showSwal('Error', 'No se ha podido procesar la solicitud. Por favor, intente de nuevo.', 'error');
                        }

                        if (datos !== null) {
                            let data_proyectos = agruparDatosPorProyecto(datos);
                            tareas_completadas = obtenerTareasCompletadasPorResponsable(data_proyectos);
                            generarTablaCronograma(data_proyectos);

                            inicializarCalendarios(data_proyectos).then(() => {
                                inicializarTrimestreActual();

                                // Ajustamos el left de los <th>
                                let firstHeaderWidth = $("thead th.proyecto_header").outerWidth();
                                $("thead th.detalles_header").css("left", firstHeaderWidth + "px");

                                // Ajustamos el left de los <td>
                                $("tbody tr").each(function () {
                                    let firstCellWidth = $(this).find(".proyecto_cell").outerWidth();
                                    $(this)
                                        .find(".detalles_cell")
                                        .css("left", firstCellWidth + "px");
                                });

                                Swal.close();
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        showSwal("Error", "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, "error");
                    },
                });
            }

            $(document).ready(function () {
                cargarCronograma($('#select_anio').val());

                $("#select_trimestre").change(function () {
                    mostrarTrimestre($(this).val());
                });

                $("#select_anio").change(function () {
                    cargarCronograma($(this).val());
                });
            });
        </script>
    </body>
</html>
