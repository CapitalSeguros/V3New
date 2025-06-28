<div id="editar" style="width: 89%;float: left;padding: 15px 0px 0px 0px;">
  <div id="nuevo">
    <h1 id="title-action"style="margin-left: 2%;font-size: 20px"><i class="fa fa-upload"></i> Guardar Revistas - Capacita</h1>
    <section>
      <div class="col-md-12" style="margin-bottom: 2%; padding: 2%;background-color: #F2F2F2;border-radius: 9px;" id="nuevo">
        <!-- <form method="post" id="FormRevista" name="FormRevista" action="<?=base_url()?>capacita/guardar_revista"> -->
          <table id="TablaRegistro" style="width: 100%;" border="0">
            <tr>
              <td class="celda1"><label><i class="fas fa-feather"></i>&nbsp;TÍTULO O TEMA PRINCIPAL</label></td>
              <td class="celda2"><input type="text" id="titulo" name="titulo" class="form-control"></td>
              <td class="celda1"><label class="label-text"><i class="fas fa-user-shield"></i>&nbsp;RAMO</label></td>
              <td class="celda2">
                <select class="form-control" name="ramo" id="ramo">
                  <option value="0">NINGUNA</option>
                    <? foreach ($ramos as $ramo){?>
                      <option value="<?php echo $ramo->IDRamo;?>" ><?php echo $ramo->Nombre;?></option>
                    <? } ?>
                </select>
              </td>
            </tr>
            <tr name="verDatos" style="display: none;">
              <td class="celda1"><label><i class="fas fa-user-lock"></i>&nbsp;TEMA SERVICIO CAPITAL</label></td>
              <td class="celda2"><input type="text" id="servicio" name="servicio" class="form-control"></td>
              <td class="celda1"><label class="label-text"><i class="fas fa-user-tie"></i>&nbsp;TEMA EXPERIENCIA CAPITAL</label></td>
              <td class="celda2"><input type="text" id="experiencia" name="experiencia" class="form-control">
            </tr>
            <tr name="verDatos" style="display: none;">
              </td>
              <td class="celda1"><label><i class="fas fa-users-cog"></i>&nbsp;EXPERIENCIA EQUIPO CAPITAL</label></td>
              <td class="celda2">
                <select id="equipo" name="equipo" class="form-control selectpicker" data-show-subtext="false" data-live-search="true">
                  <?=ImprimirColaboradores($empleados);?>
                  <?=ImprimirAgentes($agentes);?>
                </select>
                <button class="btn-add-colb" onclick="agregar_nombre()"><i class="fas fa-plus"></i></button>
              </td>
              <td class="celda1"><label class="label-text"><i class="fas fa-calendar-alt"></i>&nbsp;FECHA DE PUBLICACIÓN</label></td>
              <td class="celda2"><input type="date" id="fecha" name="fecha" class="form-control select-max"></td>
            </tr>
            <tr name="verDatos" style="display: none;">
              <td class="celda1"></td>
              <td class="celda4" id="TextColb"></td>
            </tr>
            <tr>
              <td class="celda1"><label><i class="fas fa-pen-square"></i>&nbsp;EDICIÓN</label></td>
              <td class="celda2"><input type="text" id="edicion" name="edicion" class="form-control"></td>
              <td class="celda1"><label class="label-text"><i class="fas fa-calendar-check"></i>&nbsp;AÑO DE EDICIÓN</label></td>
              <td class="celda2"><input type="number" id="edicionAnio" name="edicionAnio" class="form-control"></td>
            </tr>
            <tr class="celda3">
              <td class="celda1"><label style="margin-top: 5px;"><i class="fas fa-edit"></i>&nbsp;DESCRIPCIÓN</label></td>
              <td class="celda2"><textarea type="text" id="descripcion" name="descripcion" class="form-control"></textarea></td>
              <td class="celda1" id="textFile">
              </td>
              <td class="celda2" id="contFile">
              </td>
            </tr>
            <tr>
              <td colspan="3"><hr></td>
            </tr>
          </table>
        <!-- </form> -->
        <div class="col-md-12" style="padding: 0px;">
          <div class="col-md-6" style="padding: 0px;">
          </div>
          <div class="col-md-6 cont-btn-upload-revista">
            <button type="button" class="btn btn-primary" id="guardar" style="border-radius: 5px;" onclick="guardar_revista('0','1')"><i class="fas fa-save"></i> Guardar</button>
          </div>
        </div>
      </div>        
    </section>
  </div>
  <div class="col-md-12" style="padding: 5px 15px;">
    <div class="col-md-6" style="padding: 0px;">
      <div class="col-md-5" style="padding: 0px;">
        <input type="text" class="form-control" placeholder="Filtrar" id="filtrarTabla" style="font-size: 13px;">
      </div>
    </div>
    <div class="col-md-6">
    </div>
  </div>
  <div class="col-md-12 cont-table-revistas">
    <div class="content-table-revistas"></div>
    <table id="TablaRevistas" class="table table-revistas">
      <thead style="position: sticky;top: 0px;">
        <tr>
          <th colspan="1" style="text-align: center;"><i class="fa fa-upload fa-2x" style="font-size: 16px;"></i></th>
          <th colspan="1">Tema Principal</th>
          <th colspan="1">Ramo</th>
          <th colspan="1">Descripción</th>
          <th colspan="1">Edición</th>
          <th colspan="1">Año Edición</th>
          <th colspan="1">Nombre Archivo</th>
          <th colspan="3" style="text-align: center;"><i class="fa fa-cogs"></i></th>
        </tr>
      </thead>
      <tbody id="BodyTablaRevistas"></tbody>
    </table>
  </div>
</div>
<!-- Modal Subir documento-->
<div class="modal fade capacita-modal" id="ModalSubirArchivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="margin: 10% auto;">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Documento</h4>
      </div>
      <div class="modal-body">
        <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-file-text fa-2x"></i>&nbsp; DOCUMENTO</label></td>
            <td><input type="file" id="documento"></td>
            <td><input type="hidden" name="id" id="id"></td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="mensajeDocumento"></div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="progress" id="Progress">
                <div class="progress-bar progress-bar-striped active" id="ProgressBar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">
                  <!-- progress-bar-striped active -->
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div id="archivoDocumento">
                Archivo subido: <a href="" id="enlaceDocumento">Click para ver</a>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal" data-close>Cerrar</button>
      </div>
    </div>
  </div>
</div>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<style type="text/css">
  #archivoDocumento {
    display: none;
    font-size: 13px;
    text-align: center;
  }
  #documento {
    font-size: 13px;
  }
  #Progress {
    display: none;
  }
  #ProgressBar {
    background-color: #337ab7;
    transition: 0.3s;
  }
  .select-max {
    max-width: max-content;
  }
  select.form-control:not([size]):not([multiple]) {
      font-size: 13px;
      height: calc(1.5em + .75rem + 2px);
  }
  #TablaRegistro tr .celda1, .celda2 {
    margin-bottom: 3px;
    display: inline-flex;
  }
  .celda1 {
    width: 18%;
  }
  .celda2 {
    width: 30%;
    /*width: 90%;
    display: flex;*/
  }
  .celda2 > textarea {
    font-size: 13px;
  }
  .celda3 {
    display: flex;
    align-items: flex-start;
  }
  .celda3 > textarea {
    height: 29px;
  }
  .celda4 {
    margin-bottom: 3px;
    display: inline-flex;
    flex-direction: column;
  }
  .celda1 > input, .celda2 > input {
    font-size: 13px;
  }
  #contFile {
    display: grid;
  }
  .text-alert-file {
    font-size: 12px;
    color: #6a6a6a;
  }
  .label-text {
    margin-left: 10px;
  }
  .btn-primary {
    transition: 0.3s;
  }
  .btn-edit {
    background-color: #24855a;
    color: white;
    border: 1px solid #24855a;
    border-radius: 5px;
    outline: none;
    padding: 4px 3px 5px 5px;
    cursor: pointer;
    transition: 0.3s;
  }
  .btn-edit > i {
    font-size: 21px;
  }
  .btn-delete {
    background-color: #dd3223;
    color: #fff;
    border: 1px solid #dd3223;
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
    margin-right: 5px;
  }
  a.btn-file {
    color: #40709d; /*#355e83*/
    cursor: pointer;
  }
  .btn-add-colb {
    font-size: 13px;
    color: #3d3d3d;
    padding: 6px 7px;
    background: #9ac7ff;
    border: 1px solid #9ac7ff;
    border-radius: 3px;
    margin-left: 5px;
    transition: 0.5s;
  }
  .btn-remove-all {
    background-color: #e92b2b;
    color: #fff;
    border: 1px solid #e92b2b;
    border-radius: 5px;
    outline: none;
    padding: 4px 6px;  
    cursor: pointer;
    transition: 0.3s;
    font-size: 21px;
  }
  .btn-remove-file {
    background-color: #e92b2b;
    color: #fff;
    border: 1px solid #e92b2b;
    border-radius: 5px;
    outline: none;
    padding: 4px 6px;  
    cursor: pointer;
    transition: 0.3s;
    font-size: 18px;
    margin-left: 3px;
  }
  .btn-eraser-team {
    font-size: 11px;
    border: none;
    /*height: fit-content;*/
  }
  .btn-default {
    color: #472380;
    background-color: #fff;
    border-color: #d2d2d2;
  }
  .btn-edit:hover {
    color: #000;
    background-color: #82cda9;
    border-color: #82cda9;
  }
  .btn-delete:hover {
    background-color: #f74b3c;
    border-color: #f74b3c;
  }
  .btn-nuevo:hover {
    color: #3d3d3d;
    background-color: #b8cfff;
    border-color: #b8cfff;
  }
  a.btn-file:hover {
    color: #354f8b;
  }
  .btn-add-colb:hover {
    color: white;
    background: #5596e9;
    border-color: #5596e9;
  }
  .btn-remove-all:hover, .btn-remove-file:hover {
    background-color: #c70000;
    border-color: #c70000;
  }
  .modal {
    transition: all 0.35s ease-in;
  }
  #ModalSubirArchivo.fade.in {
      opacity: 1;
  }
  .modal.is-visible {
    visibility: visible;
    opacity: 1;
  }
  .modal-content {
    border: none;
    border-radius: 6px 6px 4px 4px;
  }
  .modal-header {
    border-radius: 4px 4px 0px 0px;
    padding: 10px 15px;
  }
  .modal-footer > button {
    display: flex;
    align-items: center;
  }
  .modal-footer > button > i {
    margin-top: 3px;
    margin-left: 3px;
  }
  .width-ajust {
    width: 100%;
    max-width: max-content;
  }
  .column-flex {
    display: flex;
    align-items: center;
  }
  .column-column {
    display: flex;
    flex-direction: column;
    align-items: center;
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
  .text-p {
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    margin: 10px;
  }
  .text-colb {
    font-size: 12.3px;
    width: 100%;
    display: block;
    margin-left: 5px;
  }
  .cont-btn-upload-revista {
    display: flex;
    justify-content: flex-end;
  }
  .cont-table-revistas {
    padding: 0px;
    width: 100%;
    height: 550px;
    overflow: auto;
    border-radius: 5px;
    border: 1px solid #ddd;
  }
  .cont-btn-eraser {
    display: flex;
    align-items: center;
    width: 100%;
    max-width: max-content;
    flex-direction: row;
    padding: 0px 5px;
  }
  .table-revistas {
    font-size: 12px;
    background: white;
    position: relative;
  }
  .campoOculto {
    display: none;
  }
  .capacita-modal {
    background: #0000003d;
  }
  .capacita-modal > .modal-dialog.modal-lg {
    transition: all 0.3s ease 0s;
  }
  /*Selectpicker*/
  .celda2 > div.btn-group.bootstrap-select.form-control {
    /*height: 100%;*/
    max-width: 90%;
  }
  div.btn-group.bootstrap-select.form-control > .btn.dropdown-toggle.selectpicker.btn-default {
    border: 1px solid #ced4da;
    margin-bottom: 0px;
    background: white;
  }
  div.btn-group.bootstrap-select.form-control > .dropdown-menu > .bs-searchbox > .input-block-level.form-control,
  div.btn-group.bootstrap-select.form-control > .dropdown-menu > .dropdown-menu.inner.selectpicker > li {
    font-size: 12.3px;
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
  /* Checkbox Style*/
    .checkbox-container{
      width: 21px;
      height: 21px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .checkbox-All {
      width: 20px;
      height: 20px;
      position: inherit;
    }
    input:checked ~ .checkmark {
      background-color: #0d6efd; /*#337ab7, #0d6efd*/
      border-color: #0d6efd;
    }
    /*input:active ~ .checkmark{
        filter:brightness(90%);
    }*/
    input:focus ~ .checkmark{
        border-color:#86b7fe;
        outline:0;
        box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .segment {
      display: block;
      position: relative;
      cursor: pointer;
      width: 18px;
      height: 18px;
      /*margin-bottom: 0px;
      padding-top: 2px;
      padding-left: 2px;
      margin-top: -3px;
      margin-left: -1px;*/
    }
    /* Checkbox original oculto */
    .segment input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    /* Checkbox nuevo */
    .checkmark {
      display: flex;
      /* position: absolute; */
      /* top: 0px; */
      /* left: 0; */
      height: 21px;
      width: 21px;
      border-radius: 5px;
      border: 1px solid darkgray;
      margin-top: 0px;
    }
    /* Antes de seleccionar */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    /* Después de seleccionar */
    .segment input:checked ~ .checkmark:after {
      display: block;
    }
    /* Marcador del checkbox */
    .segment .checkmark:after {
      left: 8px;
      top: 4px;
      width: 6px;
      height: 11px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
  /*swal*/
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
<!-- <script defer src="<?php echo base_url();?>assets/js/font-awesome.v5.15.4.js"></script> -->
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script src="https://www.gstatic.com/firebasejs/3.6.7/firebase.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    TablaRevistas();

    $('#filtrarTabla').keyup(function() {
      filtrar_tabla();
    })
  })

  const baseUrl = '<?=base_url()?>capacita';
  var colaborador = new Array();

  function TablaRevistas() {
    $.ajax({
      type: "GET",
      url: `${baseUrl}/get_revistas`,
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
        const r = JSON.parse(data);
        console.log(r);
        const v = r['revistas'];
        trtd = ``;
        $('.content-table-revistas').html("");
        if (r != 0) {
          for (var a in v) {
            var ramo = v[a].IDRamo;
            //console.log(ramo);
            switch(ramo) {
              case '0':
                ramo = "NINGUNA";
              break;
              case '1':
                ramo = "DAÑOS";
              break;
              case '2':
                ramo = "VEHICULOS";
              break;
              case '3':
                ramo = "ACCIDENTES Y ENFERMEDADES";
              break;
              case '4':
                ramo = "VIDA";
              break;
              case '5':
                ramo = "CREDITO";
              break;
              case '6':
                ramo = "FIANZAS";
              break;
              case '7':
                ramo = "Fidelidad";
              break;
              case '8':
                ramo = "Judiciales";
              break;
              case '9':
                ramo = "Administrativas";
              break;
              case '10':
                ramo = "Crédito";
              break;
            }
            trtd += `
              <tr class="mostrar">
                <td><a class="btn-file" data-toggle="modal" onclick="subir_archivo(${v[a].id})"><i class="fa fa-file-text fa-2x"></i></a></td>
                <td>${v[a].tituloGeneral}</td>
                <td>${ramo}</td>
                <td>${v[a].descripcion}</td>
                <td>${v[a].edicion}</td>
                <td>${v[a].edicionAnio}</td>
                <td>${v[a].archivo}</td>
                <td style="padding: 8px">
                  <a href="#editar" onclick="editar_revista(${v[a].id})">
                    <button class="btn-edit">
                      <i class="far fa-edit"></i>
                    </button>
                  </a>
                </td>
                <td style="padding: 8px">
                  <button class="btn-delete" onclick="borrar_revista(${v[a].id})">
                    <i class="fa fa-times-circle fa-2x"></i>
                  </button>
                </td>
                <td style="padding: 8px;display:none">
                  <button class="btn-remove-all" onclick="eliminar_revista(${v[a].id})">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </td>
              </tr>
            `;
          }
        }
        else {
          trtd += `
            <tr>
              <td colspan="3"></td>
              <td>Sin resultados</td>
              <td colspan="3"></td>
            </tr>
          `;
        }
        $('#BodyTablaRevistas').html(trtd);
      },
      error: (error) => {
         swal("¡Uups!", "Hay conflicto al buscar la información.", "error");
      }            
    });
  }

  function guardar_revista(id,type) {
    const title = document.getElementById('titulo').value;
    const ramo = document.getElementById('ramo').value;
    const edition = document.getElementById('edicion').value;
    const year = document.getElementById('edicionAnio').value;
    const descp = document.getElementById('descripcion').value;
    //console.log("SERVICIO: "+name+", EXPERIENCIA: "+theme+", EQUIPO: "+colaborador+", RAMO: "+ramo+", EDICIÓN: "+edition+", AÑO: "+year+", FECHA: "+date+", ARCHIVO: "+file);

    if (title != 0 && edition != 0 && year != 0) {
      $.ajax({
        type: "POST",
        url: `${baseUrl}/guardar_revista`,
        data: {
          id: id,
          tp: type,
          t0: title,
          rm: ramo,
          ed: edition,
          yr: year,
          ds: descp
        },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
          if (r == "Registrado") {
            swal("¡Guardado!", "Información de la revista se ha guardado exitósamente.", "success");
          }
          else if (r == "Actualizado") {
            swal("¡Listo!", "Información de la revista se ha actualizado.", "success");
            setTimeout(function(){
              $('.swal-button--confirm').click();
            }, 3000);
          }
          TablaRevistas();
        },
        error: (error) => {
           swal("¡Vaya!", "Ha ocurrido un error al intentar registrar la información.", "error");
        }            
      });
    }
    else {
      swal("¡Espera!", "Tienes un campo vacío.", "warning");
    }
  }

  function editar_revista(id) {
    $.ajax({
      type: "GET",
      url: `${baseUrl}/buscar_revista`,
      data: {
        id: id
      },
      success: (data) => {
        const r = JSON.parse(data);
        console.log(r);

        for (var a in r) {
          $('#titulo').val(r[a].tituloGeneral);
          $("#ramo option[value='"+ r[a].IDRamo +"']").prop("selected",true);
          $('#edicion').val(r[a].edicion);
          $('#edicionAnio').val(r[a].edicionAnio);
          $('#descripcion').val(r[a].descripcion);
          $('#textFile').html('<label class="label-text" style="margin-top: 5px;"><i class="fas fa-cloud"></i>&nbsp;ARCHIVO ACTUAL</label>');
          $('.cont-btn-upload-revista').html(`
            <button type="button" class="btn btn-nuevo" id="modificar" onclick="nueva_revista()">
              <i class="far fa-newspaper"></i> Registro Nuevo</button>
            <button type="button" class="btn btn-primary" style="border-radius: 5px;" onclick="guardar_revista('${r[a].id}','2')">
              <i class="fas fa-save"></i> Guardar Cambios</button>
          `);

           const archivo = r[a].archivo;
           var span = ``;
           if (archivo != 0) {
             document.getElementById('contFile').style.display = "flex";
             span += `
               <input type="text" class="form-control" id="archivo" value="${r[a].archivo}" title="${r[a].archivo}" readonly>
             `;
             // span += `
             //   <input type="text" class="form-control" id="archivo" value="${r[a].archivo}" title="${r[a].archivo}" readonly>
             //   <span class="hidden" id="title-file">${r[a].archivo}</span>
             //   <button class="btn-remove-file" onclick="eliminar_archivo(${r[a].archivo})">
             //     <i class="fas fa-minus-circle"></i>
             //   </button>
             // `;
           }
           else {
             document.getElementById('contFile').style.display = "grid";
             span += `
               <input type="text" class="form-control" id="archivo" value="Ninguno" readonly>
               <span class="hidden" id="title-file"></span>
             `;
           }
           $('#contFile').html(span);
        }
      },
      error: (error) => {
         swal("¡Uups!", "Hay conflicto al buscar la información.", "error");
      }            
    });
  }

  function borrar_revista(id) {
    swal({
        title: "¿Desea eliminarlo?",
        text: "La información del registro seleccionado se eliminará.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
        if (value) {
          $.ajax({
            type: "POST",
            url: `${baseUrl}/borrar_revista`,
            data: {
              id: id
            },
            success: (data) => {
              swal("¡Hecho!", "Información eliminada exitósamente.", "success");
              TablaRevistas();
            },
            error: (error) => {
              swal("¡Uups!", "Hay problemas al tratar de borrar la información.", "error");
            }            
          })
        }
    })
  }

  function nueva_revista() {
    $('#title-action').html('<i class="fa fa-upload"></i> Guardar Revistas - Capacita');
    $('.cont-btn-upload-revista').html(`
      <button type="button" class="btn btn-primary" id="guardar" style="border-radius: 5px;" onclick="guardar_revista('0','1')"><i class="fas fa-save"></i> Guardar</button>
    `);
    $('#titulo').val("");
    $("#ramo option[value='0']").prop("selected",true);;
    $('#edicion').val("");
    $('#edicionAnio').val("");
    $('#descripcion').val("");
    $('#textFile').html("");
    $('#contFile').html("");
  }

  function subir_archivo(id){
    document.getElementById('id').value=id;
    document.getElementById('documento').value = "";
    document.getElementById('mensajeDocumento').innerHTML = "";
    document.getElementById('archivoDocumento').style.display = "none";
    document.getElementById('enlaceDocumento').href = "";
    document.getElementById('Progress').style.display = "none";
    document.getElementById('ProgressBar').style.width = "0%";
    $("#ModalSubirArchivo").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });
  }

  function filtrar_tabla() {
    var input, filter, table, tr, td, i, j, visible;
    input = document.getElementById("filtrarTabla");
    filter = input.value.toUpperCase();
    table = document.getElementById("BodyTablaRevistas");
    tr = table.getElementsByTagName("tr");
    let Fila = document.getElementsByClassName('mostrar');

    for (i = 0; i < tr.length; i++) {
      visible = false;
      td = tr[i].getElementsByTagName("td");
      for (j = 0; j < td.length; j++) {
        if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
          visible = true;
        }
      }
      if (visible === true) {
        tr[i].style.display = "";
        $(tr[i]).addClass('mostrar');
      }
      else {
        tr[i].style.display = "none";
        $(tr[i]).removeClass('mostrar');
      }
    }
    result = Fila.length;
  }

  //-------------------------- Firebase --------------------------------
  //:::::::::: Subir Archivo ::::::::::
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

  // Servicios de APIs Firebase
  var authService = firebase.auth();
  var storageService = firebase.storage();

  window.onload = function() {
    authService.signInAnonymously()
      .catch(function(error) {
        console.error('Detectado error de autenticación', error);
    });

    //manejador de evento para el input file
    document.getElementById('documento').addEventListener('change', function(evento){
      evento.preventDefault();
      var archivo  = evento.target.files[0];
      subirDocumento(archivo);//enlaceSubidoDocumento(archivo);//
    });
  };

  var uploadTaskDocumento;
  function subirDocumento(archivo) {
    var refStorage = storageService.ref('revistaCapacita').child(archivo.name);
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
      console.log('El archivo está subido. Su ruta: ', uploadTaskDocumento.snapshot.downloadURL);
      enlaceSubidoDocumento(uploadTaskDocumento.snapshot.downloadURL);
    }
  }

  // mostramos el porcentaje en cada instante de la subida
  function registrarPorcentajeDocumento(porcentaje) {
    var elMensaje = document.getElementById('mensajeDocumento');
    var textoMensaje = '<p class="text-p">Porcentaje de subida: ' + porcentaje + '%</p>';
    elMensaje.innerHTML = textoMensaje;
    document.getElementById('Progress').style.display = "block";
    document.getElementById('ProgressBar').style.width = porcentaje + "%";
  }

  //mostramos el link para acceso al archivo al final de la subida
  function enlaceSubidoDocumento(enlace) {
    document.getElementById('enlaceDocumento').href = enlace;
    document.getElementById('archivoDocumento').style.display = 'block';
    document.getElementById('mensajeDocumento').innerHTML = '<p class="text-p">Proceso Terminado: 100%</p>';
    var documento=($('#documento'))[0].files[0];
    guardar_url_documento(documento);
  }

  function guardar_url_documento(documento){
    var id = $("#id").val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: `${baseUrl}/agregar_archivo`,
        data: {
          id: id,
          fl: documento.name
        },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
          TablaRevistas();
        },
        error: (error) => {
          console.log(error);
        }
    });
  }

  /*function SizeType(t) {
    var kb = t.toFixed(1) + " KB";
    var mb = (t / 1024).toFixed(1) + " MB";
    var size = "Pesa "+kb+", y "+mb;
    return size;
  }*/

  <?
    function ImprimirColaboradores($datos){
      $option='<option>Seleccione Colaborador</option>';  
      foreach ($datos as $key1 => $value1) {
        $option.='<optgroup label="'.$value1['Name'].'" style="font-size: 12.5px">';
        foreach ($value1['Data'] as $key => $value) {
          $nombres = $value['nombres'].' '.$value['apellidoPaterno'].' '.$value['apellidoMaterno'];
          $option.='<option class="dropdown-item" data-name="'.$nombres.'" data-email="'.$value['email'].'">'.$nombres.'</option>';  
        }
        $option.='</optgroup>';
      }
      return $option;
    }

    function ImprimirAgentes($datos){
      $option='<optgroup label="Agentes">';  
      foreach ($datos as $key => $value) {
        $nombres = $value->nombre.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno;
        $option.='<option class="dropdown-item" data-name="'.$nombres.'" data-email="'.$value->email.'">'.$nombres.'</option>';  
      }
      $option.='</optgroup>';
      return $option;
    }
  ?>
</script>
