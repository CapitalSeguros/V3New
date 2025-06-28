<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div>
    <style>
        .espacio_derecha {
            margin-right: 10px;
        }

        /* Estilos para el contenedor */
        #contenedorTabla {
            max-height: calc(100vh - 325px);
            overflow-y: auto;
        }

        /* Hacer que el thead sea fijo */
        #tablaReporte thead th {
            position: sticky;
            top: 0;
            z-index: 1;
            background-color: #67439f;
        }

        /* Mejora visual */
        #tablaReporte th, #tablaReporte td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="form-inline">
                    <div class="form-group espacio_derecha">
                        <label for="p_fechaInicio">Fecha Inicial:</label>
                        <input type="date" class="form-control" id="p_fechaInicio" name="p_fechaInicio">
                    </div>
                    <div class="form-group espacio_derecha">
                        <label for="p_fechaFinal">Fecha Final:</label>
                        <input type="date" class="form-control" id="p_fechaFinal" name="p_fechaFinal">
                    </div>
                    <button type="button" class="btn btn-primary espacio_derecha" onclick="buscarPagosAplicados()">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-primary" title="Descargar reporte" onclick="descargarReporteAP()">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 col-md-12" id="contenedorTabla" style="overflow-y: auto;">
                <table id="tablaReporte" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Endoso</th>
                            <th>idSerie</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                            <th>Fecha Aplicación</th>
                            <th>Fecha Documento</th>
                            <th>Importe</th>
                            <th>Tipo de cambio</th>
                            <th>Moneda</th>
                            <th>Tipo de Documento</th>
                            <th>emailUser</th>
                            <th>usuarioResponsable</th>
                            <th>NombreCompleto</th>
                            <th>ApellidoP</th>
                            <th>ApellidoM</th>
                            <th>Nombre</th>
                            <th>Nombre Vendedor</th>
                            <th>Gerencia</th>
                            <th>idTipoSolicitudCobro</th>
                            <th>SolicitudCobro</th>
                            <th>Compañia</th>
                            <th>Ramo</th>
                            <th>Subramo</th>
                            <th>Conducto de Cobro</th>
                            <th>Prima Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_pagosAplicados"> </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const DATOS_MAX = 100;

        $(document).ready(function () {
            $('#p_fechaInicio').val('<?= $fechaInicial ?>');
            $('#p_fechaFinal').val('<?= $fechaFinal ?>');
        });

        /**
         * Dispara la peticion para obtener la lista de pagos aplicados entres las fechas especificadas
        */
        async function buscarPagosAplicados() {
            mostrarSwalEspera();
            let datos_v3 = await obtenerPagosAplicados();
            let datos_sicas = await obtenerDatosRecibosSicas(datos_v3);
            cargarDatosEnTabla(datos_v3, datos_sicas);
        }

        /**
         * Obtiene desde V3 la lista de pagos aplicados entre las fechas indicadas
        */
        async function obtenerPagosAplicados() {
            return new Promise((resolve, reject) => {
                let fecha_inicio = $('#p_fechaInicio').val();
                let fecha_final = $('#p_fechaFinal').val();

                $.ajax({
                    url: '<?= base_url("cobranza/obtenerPagosAplicados"); ?>',
                    type: 'POST',
                    data: {
                        fechaInicial: fecha_inicio,
                        fechaFinal: fecha_final
                    },
                    dataType: 'json',
                    success: function (response) {
                        resolve(response);
                    },
                    error: function (xhr, status, error) {
                        console.error("Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText);
                        alert('Un error ha ocurrido. Por favor, intente de nuevo.');
                        swal.close();
                        reject({
                            status: xhr.status,
                            statusText: status,
                            responseText: xhr.responseText,
                            error: error
                        });
                    }
                });
            });
        }

        /**
         * Inicia el flujo para procesar los datos recibidos y mostrarlos en la tabla
        */
        function cargarDatosEnTabla(datos_v3, datos_sicas) {
            $('#tbody_pagosAplicados').empty();

            // Función interna para procesar los datos en lotes
            function procesarLotes(i) {
                const lote = datos_v3.slice(i, i + DATOS_MAX); // Obtener un lote de hasta 100 datos
                let filasHTML = '';

                // Creamos las filas para el lote actual
                lote.forEach(dato => {
                    filasHTML += `
                        <tr>
                            <td>${dato.documento}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'Endoso')}</td>
                            <td>${dato.IDRecibo}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'FDesde').split('T')[0]}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'FHasta').split('T')[0]}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'FechaPago').split('T')[0]}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'FechaDocto').split('T')[0]}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'ImportePago')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'TCPago')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'MonedaPago')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'TipoDocto')}</td>
                            <td>${dato.emailUser} (${dato.name_complete_user})</td>
                            <td>${dato.usuarioResponsable} (${dato.name_complete_responsable})</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'NombreCompleto')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'ApellidoP')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'ApellidoM')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'Nombre')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'VendNombre')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'GerenciaNombre')}</td>
                            <td>${dato.idTipoSolicitudCobro}</td>
                            <td>${obtenerNombreTipoSolicitudCobro(dato.idTipoSolicitudCobro)}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'CiaNombre')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'RamosNombre')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'SRamoNombre')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'CCobro_TXT')}</td>
                            <td>${obtenerDatoPorId(datos_sicas, dato.IDRecibo, 'PrimaTotal')}</td>
                        </tr>`;
                });

                // Insertamos las filas en el tbody
                document.getElementById('tbody_pagosAplicados').innerHTML += filasHTML;

                // Si hay más lotes por procesar, llamamos nuevamente a la función
                if (i + DATOS_MAX < datos_v3.length) {
                    setTimeout(() => procesarLotes(i + DATOS_MAX), 0); // Usamos setTimeout para evitar bloquear la interfaz
                } else {
                    // Si ya se procesaron todos los datos, cerramos el swal de espera
                    swal.close();
                }
            }

            // Iniciamos el procesamiento de los datos por lotes
            procesarLotes(0);
        }

        /**
         * Dispara el proceso para generar y descargar el reporte como un archivo excel
         */
        function descargarReporteAP() {
            let tabla = $("#tablaReporte");

            let encabezados = [];
            tabla.find("thead th").each(function () {
                encabezados.push($(this).text().trim());
            });

            let datos = [];
            tabla.find("tbody tr").each(function () {
                let fila = [];
                $(this).find("td").each(function () {
                    fila.push($(this).text().trim());
                });
                datos.push(fila);
            });

            // Comienza la parte para generar el archivo excel
            let worksheet = {};

            encabezados.forEach((titulo, idx) => {
                let celda = XLSX.utils.encode_cell({ c: idx, r: 0 }); // c = columna, r = fila
                worksheet[celda] = { v: titulo }; // 'v' es el valor de la celda
            });

            datos.forEach((fila, filaIdx) => {
                fila.forEach((valor, colIdx) => {
                    let celda = XLSX.utils.encode_cell({ c: colIdx, r: filaIdx + 1 }); // +1 para las filas después del encabezado
                    worksheet[celda] = { v: valor };
                });
            });

            worksheet["!ref"] = XLSX.utils.encode_range({
                s: { c: 0, r: 0 }, // Inicio (columna 0, fila 0)
                e: { c: encabezados.length - 1, r: datos.length }, // Fin (última columna y fila)
            });

            let workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Aplicación de pagos");

            let archivoExcel = XLSX.write(workbook, { bookType: "xlsx", type: "binary" });

            let fechaActual = new Date().toISOString().split('T')[0];

            let blob = new Blob([s2ab(archivoExcel)], { type: "application/octet-stream" });
            let a = document.createElement("a");
            let url = URL.createObjectURL(blob);
            a.href = url;
            a.download = `ReporteAplicacionDePago_${fechaActual}.xlsx`;
            document.body.appendChild(a);
            a.click();
            setTimeout(() => {
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 0);
        }

    </script>
</div>