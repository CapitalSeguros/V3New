<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rechazo Domiciliado</title>
    <!-- Bootstrap 3.3.2 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- Font Awesome 4 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- SweetAlert 2.x CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css">
    <style>
        .oculto {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h3>Rechazo Domiciliado</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <textarea id="txt_comentario" class="form-control" rows="4" placeholder="Ingrese su comentario"></textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-8 col-md-8">
                <div class="form-group">
                    <label for="selectMotivoRechazo">Motivo de Rechazo de Pago</label>
                    <select class="form-control" id="selectMotivoRechazo">
                        <option value="-1">Seleccione una opción</option>
                        <?php
                        foreach($motivosRechazo as $motivo){
                            echo '<option value="'.$motivo->id.'">'.$motivo->descripcion.'</option>';
                        }
                        ?>
                    </select>
                    <br>
                    <div class="input-group">
                        <div class="input-group-addon">Poliza</div>
                        <input type="text" class="form-control" id="input_poliza" value="<?= $poliza['folio_doc'] ?>" disabled>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Endoso</div>
                        <input type="text" class="form-control" id="input_endoso" value="<?= $poliza['endoso'] ?>" disabled>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Recibo</div>
                        <input type="text" class="form-control" id="input_recibo" value="<?= $poliza['periodo'] ?>" disabled>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Inicio de vigencia</div>
                        <input type="text" class="form-control" id="input_vigencia" value="<?= $poliza['vigencia'] ?>" disabled>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Compañia</div>
                        <input type="text" class="form-control" id="input_compania" value="<?= $poliza['compania'] ?>" disabled>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Importe</div>
                        <input type="text" class="form-control" id="input_importe" value="<?= $poliza['prima_total'] ?>" disabled>
                    </div>
                    <div class="input-group oculto">
                        <div class="input-group-addon">IDRecibo</div>
                        <input type="text" class="form-control" id="input_idrecibo" value="<?= $poliza['id_recibo'] ?>" disabled>
                    </div>
                    <div class="input-group oculto">
                        <div class="input-group-addon">IDDocto</div>
                        <input type="text" class="form-control" id="input_iddocto" value="<?= $poliza['id_docto'] ?>" disabled>
                    </div>
                    <div class="input-group oculto">
                        <div class="input-group-addon">IDCli</div>
                        <input type="text" class="form-control" id="input_idcli" value="<?= $poliza['id_cli'] ?>" disabled>
                    </div>
                    <div class="input-group oculto">
                        <div class="input-group-addon">Username</div>
                        <input type="text" class="form-control" id="input_username" value="<?= $username ?>" disabled>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-7 col-md-7">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="selectDestinatarios">Destinatarios</label>
                        <select class="form-control" id="selectDestinatarios">
                            <option value="-1">Seleccione un destinatario</option>
                            <?php
                            echo '<option value="'.$cliente['email'].'">'.$cliente['nombre'].'</option>';
                            echo '<option value="'.$vendedor['email'].'">'.$vendedor['nombre'].'</option>';
                            foreach($destinatariosAdicionales as $adicional){
                                echo '<option value="'.$adicional->emailAdicional.'">'.$adicional->emailAdicional.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button id="btnAgregarDestinatario" class="btn btn-primary">Agregar</button>
                </form>
            </div>
            <div class="col-xs-5 col-md-5">
                <form class="form-inline">
                    <div class="form-group">
                        <label for="inputEmailAdicional">Email</label>
                        <input type="email" class="form-control" id="inputEmailAdicional"
                            placeholder="email@dominio.com">
                    </div>
                    <button id="btnAgregarAdicional" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th hidden>Adicional</th>
                            <th>Quitar</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_destinatarios">
                        <tr>
                            <td class="nombre"><?= $cliente['nombre'] ?></td>
                            <td class="correo"><?= $cliente['email'] ?></td>
                            <td class="adicional" hidden>false</td>
                            <td><button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>
                        </tr>
                        <tr>
                            <td class="nombre"><?= $vendedor['nombre'] ?></td>
                            <td class="correo"><?= $vendedor['email'] ?></td>
                            <td class="adicional" hidden>false</td>
                            <td><button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>
                        </tr>
                        <?php
                        foreach($destinatariosAdicionales as $adicional){
                        ?>
                        <tr>
                            <td class="nombre"><?= $adicional->emailAdicional ?></td>
                            <td class="correo"><?= $adicional->emailAdicional ?></td>
                            <td class="adicional" hidden>true</td>
                            <td><button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-3 col-md-3 col-xs-offset-9 col-md-offset-9">
                <button id="btnGenerarMensaje" class="btn btn-info">Generar mensaje</button>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4>Vista previa:</h4>
            </div>
        </div>
        <divc class="row">
            <div class="col-xs-12 col-md-12">
                <textarea id="txt_mensaje" class="form-control" rows="12" placeholder="Presione el botón 'Generar mensaje'"></textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-4 col-md-4"> </div>
            <div class="col-xs-4 col-md-4">
                <!-- checkbox y mensaje Guardar adicionales en V3 -->
                <div class="checkbox" style="float: right;">
                    <label>
                        <input id="checkGuardarAdicional" type="checkbox"> Guardar destinatarios adicionales en V3
                    </label>
                </div>
            </div>
            <div class="col-xs-4 col-md-4">
                <!-- botones de Aceptar y Cancelar -->
                <div class="form-inline" style="float: right;">
                    <button id="btnAceptar" class="btn btn-success">Enviar</button>
                    <button id="btnCancelar" class="btn btn-default">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert 2.x JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.js"></script>
    <!-- Script jQuery y SweetAlert -->
    <script>
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
         * Verifica si un correo electronico tiene un formato valido
         * 
         * @param {string} email - El correo electronico a validar
         * @returns {boolean} `true` si el formato del correo es valido, `false` en caso contrario
         */
        function esEmailValido(email) {
            let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar un email
            return regex.test(email.trim());
        }

        /**
         * Crear una nueva fila a la tabla con los datos proporcionados
        */
        function agregarFila(dato1, dato2, adicional = false) {
            let nuevaFila = '<tr>' +
                '<td class="nombre">' + dato1 + '</td>' +
                '<td class="correo">' + dato2 + '</td>' +
                '<td class="adicional" hidden>' + adicional + '</td>' +
                '<td><button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>' +
                '</tr>';
            $('#tbody_destinatarios').append(nuevaFila);
        }

        /**
         * Devuelve un arreglo de objetos con los datos de los destinatarios
        */
        function obtenerDatosTabla() {
            const datos = [];

            $('#tbody_destinatarios tr').each(function () {
                const nombre = $(this).find('.nombre').text().trim();
                const correo = $(this).find('.correo').text().trim();
                const adicional = $(this).find('.adicional').text().trim() === 'true';

                datos.push({
                    nombre: nombre,
                    correo: correo,
                    esAdicional: adicional
                });
            });

            return datos;
        }

        /**
         * Verifica si el correo ya existe en la tabla
        */
        function correoExiste(correo) {
            let existe = false;

            $('#tbody_destinatarios .correo').each(function () {
                if ($(this).text().trim() === correo) {
                    existe = true;
                    return false; // Detenemos el bucle de busqueda
                }
            });

            return existe;
        }

        /**
         * Guarda la actividad del envio de un rechazo domiciliado en la bitacora de comentarios de la poliza
        */
        function guardarComentario() {
            let datos_comentario = {
                IDRecibo: $('#input_idrecibo').val(),
                idDocto: $('#input_iddocto').val(),
                serie: $('#input_recibo').val(),
                IDCli: $('#input_idcli').val(),
                endoso: $('#input_endoso').val()
            };

            let txt_comentario = `Se ha enviado un rechazo domiciliado realizado por: ${$('#input_username').val()} `;
            txt_comentario += `(Recibo: ${datos_comentario.IDRecibo}, Doc: ${datos_comentario.idDocto}, Serie: ${datos_comentario.serie}, Endoso: ${datos_comentario.endoso}, IDCli: ${datos_comentario.IDCli})`;

            datos_comentario['comentario'] = txt_comentario;

            $.ajax({
                url: '<?= base_url("cobranza/comentarios") ?>',
                type: 'POST',
                data: datos_comentario,
                success: function (responseString) {
                    console.log(responseString);
                },
                error: function (xhr, status, error) {
                    console.error('Error al guardar comentario', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                }
            });
        }

        $(document).ready(function () {
            $('#btnAgregarDestinatario').click(function (event) {
                event.preventDefault();
                let nombre = $('#selectDestinatarios option:selected').text().trim();
                let email = $('#selectDestinatarios option:selected').val().trim();
                if (email === '-1') {
                    showSwal('Aviso', 'Por favor, elija a un destinatario.', 'info');
                    return;
                }
                if (correoExiste(email)) {
                    showSwal('Aviso', 'El destinatario ya ha sido agregado.', 'info')
                    return;
                }
                agregarFila(nombre, email);
            });

            $('#btnAgregarAdicional').click(function (event) {
                event.preventDefault();
                let email_adicional = $('#inputEmailAdicional').val().trim();
                if (!esEmailValido(email_adicional)) {
                    showSwal('Aviso', 'Por favor, ingrese un correo electrónico válido.', 'info');
                    return;
                }
                if (correoExiste(email_adicional)) {
                    showSwal('Aviso', 'El correo ya se encuentra listado entre los destinatarios.', 'info')
                    return;
                }
                agregarFila(email_adicional, email_adicional, true);
                $('#inputEmailAdicional').val('');
            });

            $(document).on('click', '.btn-eliminar', function () {
                $(this).closest('tr').remove();
            });

            $('#btnGenerarMensaje').click(function (event) {
                let fecha = new Date().toLocaleString().split(',')[0];
                let motivo_rechazo = $('#selectMotivoRechazo option:selected').text().trim();
                let comentario = $('#txt_comentario').val().trim();
                let poliza = $('#input_poliza').val();
                let endoso = $('#input_endoso').val();
                let recibo = $('#input_recibo').val();
                let vigencia = $('#input_vigencia').val();
                let compania = $('#input_compania').val();
                let importe = $('#input_importe').val();

                if (comentario === '') {
                    showSwal('Aviso', 'Por favor, ingrese su comentario.', 'info');
                    return;
                }

                let motivo_rechazo_id = $('#selectMotivoRechazo option:selected').val();
                if (motivo_rechazo_id === '-1') {
                    showSwal('Aviso', 'Por favor, seleccione un motivo de rechazo.', 'info');
                    return;
                }

                let pre_mensaje = `Fecha de Notificación: ${fecha}\n\n`;
                pre_mensaje += `Estimado cliente le comentamos que derivado de la gestión de cobro automático que venimos revisando de la póliza que le hemos emitido, le informamos que NO HA PODIDO SER COBRADA POR "${motivo_rechazo.toUpperCase()}"\n\n`;
                pre_mensaje += `Comentario: ${comentario}\n\n`;
                pre_mensaje += `Póliza: ${poliza}\n`;
                pre_mensaje += `Endoso: ${endoso}\n`;
                pre_mensaje += `Recibo: ${recibo}\n`;
                pre_mensaje += `Inicio de vigencia: ${vigencia}\n`;
                pre_mensaje += `Compañia: ${compania}\n`;
                pre_mensaje += `Importe: ${importe}\n\n`;
                pre_mensaje += `Le agradecemos pueda realizar el pago por el monto arriba señalado, con el fin de evitar la CANCELACIÓN de su póliza ya que en caso de siniestro no contará con los beneficios que esta le ofrece.\n\n`;
                pre_mensaje += `Cualquier duda o aclaración puede ponerse en contacto con su agente.\n\n`;
                pre_mensaje += `Saludos.`;

                $('#txt_mensaje').val(pre_mensaje);
            });

            $('#btnAceptar').click(function () {
                let mensaje = $('#txt_mensaje').val().trim();
                if (mensaje === '') {
                    showSwal('Aviso', 'Por favor, genere su mensaje.', 'info');
                    return;
                }
                mensaje = mensaje.replace(/\n/g, '<br>');

                let datos_destinatarios = obtenerDatosTabla();
                if (datos_destinatarios.length === 0) {
                    showSwal('Aviso', 'Por favor, ingrese al menos un destinatario.', 'info');
                    return;
                }

                let guardar_adicional = $('#checkGuardarAdicional').prop('checked');

                // Verificamos que todos los correos electronicos sean validos
                for (let i = 0; i < datos_destinatarios.length; i++) {
                    if (!esEmailValido(datos_destinatarios[i].correo)) {
                        showSwal('Aviso', 'Uno o más destinatarios no tienen un correo electrónico válido, por favor verifique la información.', 'info');
                        return;
                    }
                }

                const datos_rechazo = {
                    mensaje: mensaje,
                    destinatarios: datos_destinatarios,
                    guardar_adicional: guardar_adicional
                };

                Swal.fire({
                    title: 'Confirmación',
                    text: "¿Deseas enviar el correo con el mensaje visualizado en la vista previa?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url("cobranza/enviarRechazoDomiciliado") ?>',
                            type: 'POST',
                            data: datos_rechazo,
                            success: function (responseString) {
                                if (responseString === 'true') {
                                    $('#txt_comentario').val('');
                                    $('#selectMotivoRechazo').val('-1');
                                    $('#selectDestinatarios').val('-1');
                                    $('#txt_mensaje').val('');
                                    guardarComentario();
                                    showSwal('Éxito', 'Mensaje enviado.');
                                } else {
                                    console.error(responseString);
                                    showSwal('Error', 'La operación no pudo ser completada. Por favor, intente de nuevo.');
                                }
                            },
                            error: function (xhr, status, error) {
                                showSwal('Error', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                            }
                        });
                    }
                });
            });

            $('#btnCancelar').click(function () {
                window.close();
            });
        });
    </script>
</body>

</html>