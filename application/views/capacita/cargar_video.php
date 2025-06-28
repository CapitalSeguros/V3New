<?php 
	//$this->load->view('headers/header'); 
  $this->load->view('capacita/menu_capacita'); 
?>
<!-- Navbar -->
<?php
	//$this->load->view('headers/menu');
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<style type="text/css">
  #archivoImagen {
    display: none;
    font-size: 12px;
  }
  #archivoVideo, #archivoVideoTutorial {
    display: none;
    font-size: 12px;
  }
  #archivoDocumento {
    display: none;
    font-size: 12px;
  }
  #imagen, #video, #documento, #tutorial {
    font-size: 12px;
  }
  .select-max {
    max-width: max-content;
  }
  select.form-control:not([size]):not([multiple]) {
      font-size: 13px;
      height: calc(1.5em + .75rem + 2px);
  }
  .celda1 {
    width: 17%;
  }
  .celda2 {
    width: 30%;
    /*width: 90%;
    display: flex;*/
  }
  .celda1 > input, .celda2 > input {
    font-size: 13px;
  }
  .label-text {
    margin-left: 10px;
  }
  .btn-edit {
    background-color: #ffbf47;
    color: #000;
    border: 1px solid #ffbf47;
    border-radius: 5px;
    outline: none;
    padding: 5px 5px 5px 7px;
    cursor: pointer;
    transition: 0.3s;
  }
  .btn-edit > i {
    font-size: 21px;
  }
  .btn-delete {
    background-color: #e92b2b;
    color: #fff;
    border: 1px solid #e92b2b;
    border-radius: 5px;
    outline: none;
    padding: 3px;    
    cursor: pointer;
    transition: 0.3s;
  }
  .btn-nuevo {
    color: white;
    background-color: #4d6caf;
    border: 1px solid #4d6caf;
    border-radius: 5px;
    transition: 0.3s;
  }
  a.btn-file {
    color: #40709d; /*#355e83*/
    cursor: pointer;
  }
  .btn-edit:hover {
    background-color: #ffd381;
    border-color: #ffd381;
  }
  .btn-delete:hover {
    background-color: #c70000;
    border-color: #c70000;
  }
  .btn-nuevo:hover {
    color: #3d3d3d;
    background-color: #b8cfff;
    border-color: #b8cfff;
  }
  a.btn-file:hover {
    color: #354f8b;
  }
  .modal-content {
    border: none;
    border-radius: 6px 6px 4px 4px;
  }
  .modal-header {
    border-radius: 4px 4px 0px 0px;
  }
  .modal-footer > button {
    display: flex;
    align-items: center;
  }
  .modal-footer > button > i {
    margin-top: 3px;
    margin-left: 3px;
  }
  .column-label {
    display: flex;
    align-items: center;
    font-weight: 500;
  }
  .column-label > i {
    color: #40709d;
  }
  .col-cel-1 {
    width: 50%;
    max-width: 50%;
  }
  .columm-celda {
    display: flex;
    flex-direction: column;
    width: 100%;
  }
  .ft {
    font-size: 13px;
  }
  #tab_capa.nav-tabs {
      font-size: 14px;
      border-bottom: 1px solid #dee2e6;
      background: transparent;
      width: 100%;
  }
  #tab_capa.nav-tabs > li {
      margin-bottom: -1px;
  }
  #tab_capa.nav-tabs>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {
      color: #8370A1;
      cursor: default;
      background-color: #fff;
      border: 1px solid #ddd;
      border-bottom-color: transparent;
  }
  #tab_capa.nav-tabs>li>a {
      margin-right: 2px;
      line-height: 1.42857143;
      border: 1px solid transparent;
      border-radius: 4px 4px 0 0;
      color: #555;
  }
  #tab_capa.nav-tabs>li>a:hover {
      background: #8370A1;
      color: white;
  }
  #tab_capa.nav-tabs>li {
      float: left;
      margin-bottom: -1px;
  }
  #contenedor_capa.tab-content {
      font-size: 13px;
      border: 1px solid #dee2e6;
      border-top: transparent;
      box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);
  }
  .tab-content>.active {
    height: 814px;
  }
  .cont-table-tutoriales {
    padding: 0px;
    width: 100%;
    height: 570px;
    overflow: auto;
    /*border-radius: 5px;
    border: 1px solid #ddd;*/
  }
  .table-tutoriales {
    font-size: 12px;
    background: white;
    position: relative;
  }
  /*Spinner*/
  .content-table-revistas {
    width: 100%;
    height: 100%;
    position: absolute;
  }

  .container-spinner-table-revistas {
    text-align: center;
    /* margin: 10px; */
    color: #266093;
    width: 100%;
    height: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    position: relative;
    background-color: rgb(255 255 255 / 60%);
    z-index: 1001;
  }
  .container-spinner-table-revistas > .spinner-border {
    width: 3rem;
    height: 3rem;
  }
  .swal-modal {
      width: 28%; /* 68% height: 40%*/
  }
  .swal-button--confirm{
      background-color:#337ab7!important;
  }
  .swal-text{
      /*color:#472380 !important;*/
      font-size: 17px;
      text-align: center;
  }
</style>
<div id="curso" style="width: 89%;float: left;padding: 15px 0px 0px 0px;">
  <h1 style="margin-left: 2%;font-size: 20px"><i class="fa fa-upload"></i> Guardar Videos - Capacita</h1>
  <div class="col-md-12">
    <ul class="nav nav-tabs" id="tab_capa" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" id="cursos_tab" role="tab" aria-controls="mi_curso" aria-selected="true" href="#mi_curso">Cursos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" id="tutoriales_tab" role="tab" aria-controls="mi_tutorial" aria-selected="true" href="#mi_tutorial">Tutoriales</a>
      </li>
    </ul>
    <div class="tab-content" id="contenedor_capa">
      <div class="tab-pane active" id="mi_curso" role="tabpanel" aria-labeledby="cursos_tab">
        <div id="editar"></div>
        <div id="nuevo">
          <div style="margin-bottom: 2%; padding: 2%;background-color: #F2F2F2;border-radius: 9px;" id="nuevo">
            <form method="post" id="formulario" name="formulario" action="<?=base_url()?>capacita/guardarvideo">
              <table style="width: 100%;" border="0">
                <tr>
                  <td class="celda1"><label><i class="fa fa-tag"></i>&nbsp;SELECCIONE CAPACITACIÓN:</label></td>
                  <td class="celda2">
                    <select class="form-control" name="categoria" id="categoria" onchange="filtrar_categoria()">
                      <option value="NINGUNA"><?php echo "NINGUNA"?></option>
                      <?php 
                      foreach ($categorias as $categoria){?>
                        <option value="<?php echo $categoria->id_capacitacion;?>" ><?php echo $categoria->tipoCapacitacion;?></option>
                      <?php }?>
                    </select>
                  </td>
                  <td class="celda1"><label class="label-text"><i class="fa fa-tag"></i>&nbsp;SELECCIONE CERTIFICACIÓN:</label></td>
                  <td class="celda2">
                    <div id="div_subcategoria">
                      <select class="form-control nt" name="subcategoria" id="subcategoria" disabled>
                        <option value="NINGUNA"><?php echo "NINGUNA"?></option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="celda1">
                   <div id="lbramos" style="display: none;">
                      <label><i class="fa fa-tag"></i>&nbsp;SELECCIONE RAMOS:</label>
                   </div>
                  </td>
                  <td class="celda2">
                    <div id="ramos" style="display: none;">
                      <select class="form-control" name="ramo" id="ramo">
                        <!-- <option value="0">NINGUNA</option> -->
                        <?php 
                        foreach ($ramos as $ramo){?>
                          <option value="<?php echo $ramo->IDRamo;?>" ><?php echo $ramo->Nombre;?></option>
                        <?php }?>
                      </select>
                    </div>
                  </td>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td class="celda1"><label><i class="fa fa-graduation-cap"></i>&nbsp;NOMBRE DEL CURSO</label></td>
                  <td class="celda2"><input type="text" name="nombre" id="nombre" class="form-control"></td>
                  <td class="celda1"><label class="label-text"><i class="fas fa-book-open"></i>&nbsp;LECCIONES</label></td>
                  <td class="celda2"><input type="text" name="lecciones" class="form-control nt"></td>
                </tr>
                <tr>
                  <td class="celda1"><label><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;DESCRIPCIÓN</label></td>
                  <td class="celda2"><input type="text" name="descripcion" class="form-control"></td>
                  <td class="celda1"><label class="label-text"><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;DURACIÓN</label></td>
                  <td class="celda2"><input type="number" name="duracion" class="form-control nt"></td>
                </tr>
                <tr>
                  <td class="celda1"><label><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp;EXAMEN</label></td>
                  <td class="celda2"><select class="form-control select-max nt" name="examen">
                      <option>NO</option>
                      <option>SI</option>
                    </select></td>
                  <td class="celda1"><label class="label-text"><i class="fas fa-user-graduate"></i>&nbsp;ESTUDIANTES</label></td>
                  <td class="celda2"><input type="number" name="estudiantes" class="form-control nt"></td>
                </tr>
                <tr>
                  <td class="celda1"><label><i class="fas fa-certificate"></i>&nbsp;CERTIFICADO</label></td>
                  <td class="celda2"><select class="form-control select-max nt" name="certificado">
                      <option>NO</option>
                      <option>SI</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="4"><hr></td>
                </tr>
                <tr>
                  <td colspan="4" style="text-align: right;">
                    <button type="button" class="btn btn-primary" name="guardar" id="guardar" style="border-radius: 5px;" onclick="guardar_video()"><i class="fas fa-save"></i> Guardar</button>
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <section>
          <table id="tabla" class="table table-responsive table-hover" style="width: 100%;height: 550px;font-size: 12px;">
            <thead style="position: sticky;top: 0px;">
            <tr>
              <th colspan="3" style="text-align: center;"><i class="fa fa-upload fa-2x" style="font-size: 16px;"></i></th>
              <th class="col-cel-1">Nombre</th>
              <th class="col-cel-1">Descripción</th>
              <th>Lecciones</th>
              <th>Examen</th>
              <th>Duración</th>
              <th>Estudiantes</th>
              <th>Certificado</th>
              <th>Fecha</th>
              <th>Valoración</th>
              <th>Vistas</th>
              <th colspan="2" style="text-align: center;"><i class="fa fa-cogs"></i></th>
            </tr>
            </thead>
            <tbody>
            <?php 
                foreach ($videos as $video){?>
              <tr>
                <td><a class="btn-file" data-toggle="modal" data-target="#subir_portada" onclick="setId('<?php echo $video->id;?>')"><i class="fa fa-image fa-2x"></i></a></td>
                <td><a class="btn-file" data-toggle="modal" data-target="#subir_video" onclick="setId('<?php echo $video->id;?>')"><i class="fa fa-video-camera fa-2x"></i></a></td>
                <td><a class="btn-file" data-toggle="modal" data-target="#subir_documento" onclick="setId('<?php echo $video->id;?>')"><i class="fa fa-file-text fa-2x"></i></a></td>
                <td class="col-cel-1"><?php echo $video->nombre;?></td>
                <td class="col-cel-1"><?php echo $video->descripcion;?></td>
                <td><?php echo $video->lecciones;?></td>
                <td><?php echo $video->examen;?></td>
                <td><?php echo $video->duracion;?></td>
                <td><?php echo $video->estudiantes;?></td>
                <td><?php echo $video->certificado;?></td>
                <td><?php echo $video->fecha;?></td>
                <td><?php echo $video->valoracion;?></td>
                <td><?php echo $video->vistas;?></td>
                <td><a href="#curso" onclick="editar_video('<?php echo $video->id;?>')"><button class="btn-edit"><i class="far fa-edit"></i></button></a></td>
                <td><a onclick="eliminar_video('<?php echo $video->id;?>')"><button class="btn-delete"><i class="fa fa-times-circle fa-2x"></i></button></a></td>
              </tr>
            <?php }?>
            </tbody>
          </table>
        </section>
      </div>
      <div class="tab-pane" id="mi_tutorial" role="tabpanel" aria-labeledby="tutoriales_tab">
        <div class="col-md-12" style="margin-bottom: 2%; padding: 2%;background-color: #F2F2F2;border-radius: 9px;">
          <table id="TablaRegistro" style="width: 100%;" border="0">
            <tr class="columm-celda">
              <td><label><i class="fa fa-graduation-cap"></i>&nbsp;NOMBRE DEL TUTORIAL</label></td>
              <td><input type="text" id="titulo" class="form-control ft"></td>
            </tr>
            <tr class="columm-celda" style="margin-top:10px;">
              <td><label><i class="fas fa-edit"></i>&nbsp;DESCRIPCIÓN</label></td>
              <td ><textarea type="text" id="descripcion" class="form-control ft"></textarea></td>
            </tr>
            <tr>
              <td colspan="4"><hr></td>
            </tr>
            <tr>
              <td colspan="4" id="BtnGuardar" style="text-align: right;">
                <button type="button" class="btn btn-primary" name="guardar" id="guardar" style="border-radius: 5px;" onclick="guardar_tutorial('0','1')"><i class="fas fa-save"></i> Guardar</button>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-12 cont-table-tutoriales">
          <div class="content-table-revistas"></div>
            <table id="TablaTutoriales" class="table table-tutoriales">
              <thead style="position: sticky;top: 0px;">
                <tr>
                  <th colspan="1" style="text-align: center;"><i class="fa fa-upload fa-2x" style="font-size: 16px;"></i></th>
                  <th colspan="1">Nombre</th>
                  <th colspan="1">Descripción</th>
                  <th colspan="1">Archivo</th>
                  <th colspan="1">Fecha Modificación</th>
                  <th colspan="2" style="text-align: center;"><i class="fa fa-cogs"></i></th>
                </tr>
              </thead>
              <tbody id="BodyTablaTutoriales"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Subir documento-->
<div id="subir_documento" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin: 10% auto;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Material Didactico</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-file-text fa-2x"></i>&nbsp; DOCUMENTO</label></td>
            <td> <input type="file" id="documento"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeDocumento"></div>
              <div id="archivoDocumento">
                Archivo subido: <a href="" id="enlaceDocumento">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Subir portada-->
<div id="subir_portada" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin: 10% auto;">
    <!-- Modal content-->
    <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
    <input type="hidden" name="id" id="id">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Portada de Video</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-image fa-2x"></i>&nbsp; IMAGEN DE PORTADA</label></td>
            <td> <input type="file" id="imagen"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeImagen"></div>
              <div id="archivoImagen">
                Archivo subido: <a href="" id="enlaceImagen">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Subir video-->
<div id="subir_video" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin: 10% auto;">
    <!-- Modal content-->
    <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
    <input type="hidden" name="id" id="id">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Video</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-video-camera fa-2x"></i>&nbsp; VIDEO</label></td>
            <td> <input type="file" id="video"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeVideo"></div>
              <div id="archivoVideo">
                Archivo subido: <a href="" id="enlaceVideo">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Subir Video Tutorial-->
<div id="subir_tutorial" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin: 10% auto;">
    <!-- Modal content-->
    <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
    <input type="hidden" name="id" id="idTutorial">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Video</h4>
      </div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-video-camera fa-2x"></i>&nbsp; VIDEO</label></td>
            <td><input type="file" id="tutorial"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeVideoTutorial"></div>
              <div id="archivoVideoTutorial">
                Archivo subido: <a href="" id="enlaceVideoTutorial">Click para ver</a>
              </div>
            </td>
          </tr>
          </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.7/firebase.js"></script>
<script>  
  $(document).ready(function() {
    cargar_tutoriales();
  })

    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
        authDomain: "v3plus-279402.firebaseapp.com",
        databaseURL: "https://v3plus-279402.firebaseio.com",
        projectId: "v3plus-279402",
        storageBucket: "v3plus-279402.appspot.com",
        messagingSenderId: "4568272251",
        appId: "1:4568272251:web:483a7b036920897138c1de",
        measurementId: "G-8EJP31SQZ7"
    };
    firebase.initializeApp(config);
  </script>
  <script>
    // Servicios de APIs Firebase
    var authService = firebase.auth();
    var storageService = firebase.storage();

    window.onload = function() {
      authService.signInAnonymously()
        .catch(function(error) {
          console.error('Detectado error de autenticación', error);
        });

      //manejador de evento para el input file
      document.getElementById('imagen').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirImagen(archivo);
      });

       document.getElementById('video').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirVideo(archivo);
      });

      document.getElementById('documento').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirDocumento(archivo);
      });
     
      document.getElementById('tutorial').addEventListener('change', function(evento){
        evento.preventDefault();
        var archivo  = evento.target.files[0];
        subirTutorial(archivo);
      });
    };

    // defino el uploadTask como variable global, porque lo voy a necesitar
    var uploadTaskImagen;
    function subirImagen(archivo) {
      var refStorage = storageService.ref('imagenVideosCapacita').child(archivo.name);
      uploadTaskImagen = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskImagen.on('state_changed', registrandoEstadoSubidaImagen, errorSubidaImagen, finSubidaImagen);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaImagen(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeImagen (calculoPorcentaje);
      }
      function errorSubidaImagen(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaImagen(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskImagen.snapshot.downloadURL);
        enlaceSubidoImagen(uploadTaskImagen.snapshot.downloadURL);
      }

    }
     // mostramos el porcentaje en cada instante de la subida de imagen
    function registrarPorcentajeImagen(porcentaje) {
      var elMensaje = document.getElementById('mensajeImagen');
      var textoMensaje = '<p style="font-size:14px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }
     //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoImagen(enlace) {
      document.getElementById('enlaceImagen').href = enlace;
      document.getElementById('archivoImagen').style.display = 'block';
      var imagen=($('#imagen'))[0].files[0];
      guardar_url_imagen(imagen);
    }


//Subir Video***********
     var uploadTaskVideo;
    function subirVideo(archivo) {
      var refStorage = storageService.ref('videosCapacita').child(archivo.name);
      uploadTaskVideo = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskVideo.on('state_changed', registrandoEstadoSubidaVideo, errorSubidaVideo, finSubidaVideo);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaVideo(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeVideo (calculoPorcentaje);
      }
      function errorSubidaVideo(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaVideo(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskVideo.snapshot.downloadURL);
        enlaceSubidoVideo(uploadTaskVideo.snapshot.downloadURL);
      }
    }

    // mostramos el porcentaje en cada instante de la subida
    function registrarPorcentajeVideo(porcentaje) {
      var elMensaje = document.getElementById('mensajeVideo');
      var textoMensaje = '<p style="font-size:14px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }

    //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoVideo(enlace) {
      document.getElementById('enlaceVideo').href = enlace;
      document.getElementById('archivoVideo').style.display = 'block';
      var video=($('#video'))[0].files[0];
      guardar_url_video(video);
    }

    //Subir Documento***********
     var uploadTaskDocumento;
    function subirDocumento(archivo) {
      var refStorage = storageService.ref('documentosCapacita').child(archivo.name);
      uploadTaskDocumento = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskDocumento.on('state_changed', registrandoEstadoSubidaDocumento, errorSubidaDocumento, finSubidaDocumento);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaDocumento(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeDocumento (calculoPorcentaje);
      }
      function errorSubidaDocumento(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaDocumento(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskDocumento.snapshot.downloadURL);
        enlaceSubidoDocumento(uploadTaskDocumento.snapshot.downloadURL);
      }

    }

    // mostramos el porcentaje en cada instante de la subida
    function registrarPorcentajeDocumento(porcentaje) {
      var elMensaje = document.getElementById('mensajeDocumento');
      var textoMensaje = '<p style="font-size:14px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }


    //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoDocumento(enlace) {
      document.getElementById('enlaceDocumento').href = enlace;
      document.getElementById('archivoDocumento').style.display = 'block';
      var documento=($('#documento'))[0].files[0];
      guardar_url_documento(documento);
    }

    //Subir Tutorial***********
    var uploadTaskTutorial;
    function subirTutorial(archivo) {
      var refStorage = storageService.ref('modulos_de_tutoria/CAPACITA/').child(archivo.name);
      uploadTaskTutorial = refStorage.put(archivo);
      uploadTaskTutorial.on('state_changed', registrandoEstadoSubidaTutorial, errorSubidaTutorial, finSubidaTutorial);

      function registrandoEstadoSubidaTutorial(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeTutorial(calculoPorcentaje);
      }

      function errorSubidaTutorial(err) {
        console.log('Error al subir el archivo', err);
      }

      function finSubidaTutorial(){
        console.log('Subida completada');
        console.log('El video está subido. Su ruta: ', uploadTaskTutorial.snapshot.downloadURL);
        enlaceSubidoTutorial(uploadTaskTutorial.snapshot.downloadURL);
      }
    }

    function registrarPorcentajeTutorial(porcentaje) {
      var elMensaje = document.getElementById('mensajeVideoTutorial');
      var textoMensaje = '<p style="font-size:14px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }

    function enlaceSubidoTutorial(enlace) {
      document.getElementById('enlaceVideoTutorial').href = enlace;
      document.getElementById('archivoVideoTutorial').style.display = 'block';
      var tutorial = ($('#tutorial'))[0].files[0];
      guardar_url_tutorial(tutorial);
    }
  </script>
  <script type="text/javascript">

  function guardar_video(){
   var nombre=document.getElementById('nombre').value;
    if(nombre!=''){
      document.getElementById('formulario').submit();
    }else{
      alert("Debe ingresar un nombre");
    }
  }
  function eliminar_video(id){
    swal({
        title: "¿Desea eliminarlo?",
        text: "La información del registro seleccionado se eliminará.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
        if (value) {
          document.location.href="borrarvideo/"+id;
        }
    })
  }

  function setId(id){
    document.getElementById('id').value=id;
  }

  function sendId(id){
    document.getElementById('tutorial').value = "";
    document.getElementById('mensajeVideoTutorial').innerHTML = "";
    document.getElementById('archivoVideoTutorial').style.display = "none";
    document.getElementById('enlaceVideoTutorial').href = "";
    document.getElementById('idTutorial').value=id;
  }
  
  function guardar_url_video(video){
    var id = $("#id").val();
    var url=$('#base').val()+"capacita/modificarurlvideo";
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: "id="+id+"&video="+video.name,
        success: function(resp){
        }
    });
}   

function guardar_url_imagen(imagen){
    var id = $("#id").val();
    var url=$('#base').val()+"capacita/modificarurlimagen";
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: "id="+id+"&imagen="+imagen.name,
        success: function(resp){
        }
    });
}  

function guardar_url_documento(documento){
    var id = $("#id").val();
    var url=$('#base').val()+"capacita/modificarurldocumento";
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: "id="+id+"&documento="+documento.name,
        success: function(resp){
        }
    });
}    

  function guardar_url_tutorial(tutorial){
    var id = $("#idTutorial").val();
    var name = tutorial.name;
    var format = name.slice((name.lastIndexOf(".") - 1 >>> 0) + 2);
    var url = $('#base').val()+"capacita/modificarurltutorial";
    console.log(id, name, format, url);
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: {
          id: id,
          fl: name,
          fr: format
        },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
          cargar_tutoriales();
        }
    });
  }
//***********Filtro categoria en Codeingiter con ajax
function filtrar_categoria(){
    var categoria=document.getElementById('categoria').value;
    
    if((categoria==1)||(categoria==2)){
      document.getElementById('lbramos').style.display="block";
      document.getElementById('ramos').style.display="block";
     }else{
      document.getElementById('lbramos').style.display="none";
      document.getElementById('ramos').style.display="none";
    }

    //1.) Vista envio de Parmetro al Controlador
    divResultado = document.getElementById('div_subcategoria');  
    ajax=objetoAjax();
    var URL=$('#base').val()+"capacita/cargarsubcategoria/"+categoria;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText;
        }
    }
    ajax.send(null);
}


  // function archivo1(evt) {
  //         var files = evt.target.files; 
  //         for (var i = 0, f; f = files[i]; i++) {
  //           var reader = new FileReader();
  //           reader.onload = (function(theFile) {
  //           return function(e) {
  //           document.getElementById("list").innerHTML = ['<img class="thumb" width="25%" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
  //         };
  //       })(f);
  //         reader.readAsDataURL(f);
  //         }
  //       }
  //         document.getElementById('campoarchivo').addEventListener('change', archivo1, false);

/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}
function editar_video(id){
    divResultado = document.getElementById('editar');  
    ajax=objetoAjax();   
    //1.) Vista envio de Parmetro al Controlador
    var URL=$('#base').val()+"capacita/editar_video/"+id;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            document.getElementById('nuevo').style.display="none";
            divResultado.innerHTML = ajax.responseText
        }
    }
      ajax.send(null)  
}

  function nuevo_curso() {
    document.getElementById('nuevo').style.display="block";
    document.getElementById('editar').innerHTML="";
  }

  //---------------------------------------------------------------------
  const baseUrl = '<?=base_url()?>capacita';
  function cargar_tutoriales() {
    $.ajax({
      type: "GET",
      url: `${baseUrl}/get_tutoriales`,
      data: {
        id: "si"
      },
      beforeSend: (load) => {
        $('.content-table-revistas').html(`
          <div class="container-spinner-table-revistas">
            <div class="bd-spinner spinner-border" role="status">
              <span class="visually-hidden"></span>
            </div>
          </div>
        `);
      },
      success: (data) => {
        const t = JSON.parse(data);
        console.log(t);
        $('.content-table-revistas').html("");
        var trtd = ``;
        var numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

        for (const a in t) {
          var archivo = t[a].nameDoc;
          var date = new Date(t[a].dateUpdate);
          var fecha = numerodias[date.getDate()] + "/" + numeromeses[date.getMonth()] + "/" + date.getFullYear();

          if (archivo == 0 || archivo == null || archivo == undefined) {
            archivo = "";
          }

          if (t[a].dateUpdate == 0 || t[a].dateUpdate == null || t[a].dateUpdate == undefined) {
            fecha = "";
          }

          trtd += `
            <tr>
                <td><a class="btn-file" data-toggle="modal" data-target="#subir_tutorial" onclick="sendId(${t[a].idTutorial})"><i class="fa fa-video-camera fa-2x"></i></a></td>
                <td>${t[a].name}</td>
                <td>${t[a].description}</td>
                <td>${archivo}</td>
                <td>${fecha}</td>
                <td style="padding: 8px">
                  <a href="#curso" onclick="editar_tutorial(${t[a].idTutorial})"><button class="btn-edit"><i class="far fa-edit"></i></button></a>
                </td>
                <td style="padding: 8px">
                  <a onclick="eliminar_tutorial(${t[a].idTutorial})"><button class="btn-delete"><i class="fa fa-times-circle fa-2x"></i></button></a>
                </td>
              </tr>
          `;
        }
        $('#BodyTablaTutoriales').html(trtd);
      },
      error: (data) => {

      }
    })
  }

  function editar_tutorial(id) {
    $.ajax({
      type: "GET",
      url: `${baseUrl}/buscar_tutorial`,
      data: {
        id: id
      },
      success: (data) => {
        const r = JSON.parse(data);
        console.log(r);

        for (const a in r) {
          $('#titulo').val(r[a].name);
          $('#descripcion').val(r[a].description);
          $('#BtnGuardar').html(`
            <button type="button" class="btn btn-nuevo" onclick="nuevo_tutorial()">
              <i class="fa fa-graduation-cap"></i> Nuevo Tutorial</button>
            <button type="button" class="btn btn-success" style="border-radius: 5px;" onclick="guardar_tutorial('${r[a].idTutorial}','2')">
              <i class="fas fa-save"></i> Guardar Cambios</button>
          `);
        }
      },
      error: (data) => {
      }
    })
  }

  function nuevo_tutorial() {
    $('#titulo').val("");
    $('#descripcion').val("");
    $('#BtnGuardar').html(`
      <button type="button" class="btn btn-primary" name="guardar" id="guardar" style="border-radius: 5px;" onclick="guardar_tutorial('0','1')"><i class="fas fa-save"></i> Guardar</button>
    `);
  }

  function guardar_tutorial(id,type) {
    const title = document.getElementById('titulo').value;
    const descp = document.getElementById('descripcion').value;
    $.ajax({
      type: "POST",
      url: `${baseUrl}/guardar_tutorial`,
      data: {
        id: id,
        tl: title,
        ds: descp,
        tp: type
      },
      success: (data) => {
        const r = JSON.parse(data);
        console.log(r);
        if (r == "Registrado") {
          swal("¡Guardado!", "Información guardado exitósamente.", "success");
        }
        else if (r == "Actualizado") {
          swal("¡Listo!", "Información actualizada.", "success");
        }
        cargar_tutoriales();
      },
      error: (data) => {
        swal("¡Vaya!", "Ha ocurrido un error al intentar registrar la información.", "error");
      }
    })
  }

  function eliminar_tutorial(id) {
    swal({
        title: "¿Desea eliminarlo?",
        text: "La información del registro seleccionado se eliminará.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
        if (value) {
          $.ajax({
            type: "POST",
            url: `${baseUrl}/borrar_tutorial`,
            data: {
              id: id
            },
            success: (data) => {
              swal("¡Hecho!", "Información eliminada exitósamente.", "success");
              cargar_tutoriales();
            },
            error: (error) => {
              swal("¡Uups!", "Hay problemas al tratar de borrar la información.", "error");
            }            
          })
        }
    })
  }
  //https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/imagenVideosCapacita%2Fkisspng-hamburger-button-computer-icons-menu-number-list-5b5c089f664156.0146657315327581754189.jpg?alt=media&token=286cf668-d4ec-4860-bfdf-31913326b15f
  //kisspng-hamburger-button-computer-icons-menu-number-list-5b5c089f664156.0146657315327581754189
</script>
<?php $this->load->view('footers/footer'); ?>
