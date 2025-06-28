<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archivos Incidencia</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- css de la view -->
    <style>
        body {
            background-color: #b3b3d6;
        }

        /* Scroll para el caso donde se listen muchos archivos */
        .scrollable-container {
            height: 450px;
            overflow-y: auto;
            overflow-x: hidden;
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
            <div class="col-xs-12 col-md-12 scrollable-container">
                <div class="row">
                    <h2>Archivos adjuntos en la incidencia origen</h2>
                </div>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Inconforme:</b></div>
                        <ul class="list-group" id="lista_inconforme">
                            <!-- <li class="list-group-item"><a href="ruta/al/archivo.ext" download>Test.ext</a></li> -->
                        </ul>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Resuelto:</b></div>
                        <ul class="list-group" id="lista_resuelto"></ul>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Responsable:</b></div>
                        <ul class="list-group" id="lista_responsable"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-storage.js"></script>

    <script>

        $(document).ready(function () {
            inicializarFirebase().then(function () {
                obtenerListaArchivos('<?= $folio_nc; ?>');
            }).catch(function (error) {
                console.error("Error al inicializar Firebase:", error);
            });
        });

        /**
         * Inicializa Firebase utilizando la configuración obtenida desde el servidor
         */
        function inicializarFirebase() {
            return new Promise(function (resolve, reject) {
                $.ajax({
                    url: '<?= base_url("Firebase/getFirebaseConfig"); ?>',
                    type: 'GET',
                    success: function (responseString) {
                        let firebaseConfig = JSON.parse(responseString);

                        // Verificamos si Firebase ya fue inicializado
                        if (!firebase.apps.length) {
                            firebase.initializeApp(firebaseConfig);
                            console.log('Firebase inicializado correctamente.');
                            resolve();
                        } else {
                            console.log('Firebase ya fue inicializado.');
                            resolve();
                        }
                    },
                    error: function (xhr, status, error) {
                        showSwal('Error: Firebase', "Estado: " + status + "\nCódigo de estado: " + xhr.status + "\nMensaje: " + xhr.responseText, 'error');
                        reject(error);
                    }
                });
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
         * Obtiene la lista de archivos de las diferentes carpetas de inconformidades
         * en Firebase Storage con base al folio proporcionado
         *
         * @param {string} folio - El folio para identificar las carpetas en Firebase Storage
         * @returns {Promise<void>} - Retorna una promesa que se resuelve cuando se han obtenido los archivos
         */
        function obtenerListaArchivos(folio) {
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