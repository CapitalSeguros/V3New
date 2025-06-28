<div class="panel panel-default" style="margin-bottom: 80px;">
  <div class="panel-body">
    <div class="col-md-12" style="margin-bottom: 25px;">
      <h5 class="titleSection">Crear Encuesta</h5>
      <hr class="title-hr">
      <div class="col-md-12" style="margin-bottom: 5px;">
        <label  class="subTitleSection">Titulo de Encuesta:</label>  
        <input type="text" class="form-control" id="titleNewTest" maxlength="100">
      </div>
      <div class="col-md-5 column-flex-center-start width-ajust pd-right">
        <label class="subTitleSection" >Tipo de Encuesta:</label>                    
        <select class="form-control width-ajust" id="TipoRespuesta">
          <option value="NPS">NPS</option>
          <option value="NUMERO">1..10</option>  
          <option value="VERDAD">V o F(SI O NO)</option>                                
        </select>          
      </div>
      <div class="col-md-5 column-flex-center-start width-ajust">
        <label class="subTitleSection">Aplica Encuesta a:</label>
        <select class="form-control width-ajust" id="encuestaA">
          <option value="0">NINGUNO</option>
          <option value="1">SINIESTRO</option>
          <option value="2">CLIENTE NUEVO</option>
        </select>
      </div>
      <div class="col-md-2 column-flex-start" style="border-left: 1px solid #dbdbdb;">
        <button class="btn btn-primary" id="btnSaveTest" onclick="saveNewTest()" style="margin-right: 10px;" disabled>Crear</button>
        <div class="column-flex-center-start content-loading-test"></div>
      </div>
    </div>
    <div class="col-md-12" style="margin-bottom: 25px;">
      <h5 class="titleSection">Encuestas Activas 
        <button class="btn-view-cont open-icon" data-icon="2" data-toggle="collapse" href="#contTableTest" aria-expanded="true">
          <i class="fa fa-eye" data-class="fa fa-eye" title="Ver"></i>
        </button>
      </h5>
      <hr class="title-hr">
      <div class="col-md-12 collapse show in" id="contTableTest">
        <div class="col-md-12 pd-left pd-right" style="height: 450px;overflow: auto;border-bottom: 1px solid #dbdbdb;">
          <table class="table table-striped" id='tableTest' style="height: 100%;margin: 0px;">
            <thead class="table-thead">
              <tr class="tr-style">
                <th>IdEncuesta</th>
                <th>Titulo</th>
                <th>Url</th>
                <th>Fecha</th>                                              
                <th>Preguntas</th> 
                <!--th>NPS</th-->                                              
                <th>Cerrar</th>                             
              </tr>
            </thead>
            <tbody id="bodyTableTest"></tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-12" id="SectionQuestion" style="margin-bottom: 25px;">
      <h5 class="titleSection">Agregar Pregunta</h5>
      <hr class="title-hr">
      <div class="col-md-12 pd-left pd-right" style="margin-bottom: 10px;">
        <div class="col-md-12">
          <label class="subTitleSection">Encuesta seleccionada (IdEncuesta): <strong id="IDTestSelect">Ninguna</strong></label>
        </div>
        <div class="col-md-12 column-flex-bottom" style="margin-bottom: 5px;">
          <div class="col-md-9 pd-left">
            <label  class="subTitleSection">Titulo de Encuesta:</label>  
            <input type="text" class="form-control" id="titleTestEnc" maxlength="100" disabled>
          </div>
          <div class="col-md-2 column-flex-start pd-right" style="border-left: 1px solid #dbdbdb;">
            <button class="btn btn-primary" id="btnUpdateTitle" onclick="updateTitle()" style="margin-right: 10px;" disabled>Actualizar</button>
            <div class="column-flex-center-start content-loading-title"></div>
          </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 5px;">
          <label  class="subTitleSection">Pregunta:</label>
          <input type="text" class="form-control" id="preguntaEnc" maxlength="300" disabled>
        </div>
        <div class="col-md-5 column-flex-center-start width-ajust pd-right">
          <label class="subTitleSection" >Tipo de Encuesta:</label>                    
          <select class="form-control width-ajust" id="tipoEnc" disabled></select>          
        </div>
        <div class="col-md-5 column-flex-center-start width-ajust pd-right">
          <label class="subTitleSection" >Respuesta:</label>                    
          <select class="form-control width-ajust" id="respuestaEnc" disabled></select>          
        </div>
        <div class="col-md-5 column-flex-center-start width-ajust">
          <label class="subTitleSection">NPS:</label>
          <select class="form-control width-ajust" id="NPSEnc" disabled></select>
        </div>
        <div class="col-md-2 column-flex-start" style="border-left: 1px solid #dbdbdb;">
          <button class="btn btn-primary" id="btnSaveQuestion" onclick="checkNPS()" style="margin-right: 10px;" disabled>
          Guardar</button>
          <div class="column-flex-center-start content-loading-question"></div>
        </div>
      </div>
      <div class="col-md-12" style="height: 450px;overflow: auto;">
        <table class="table table-striped" id="tableQuestions" style="height: 100%;margin: 0px;">
          <thead class="table-thead">
            <tr class="tr-style">
              <th>Id</th>
              <th>Pregunta</th>
              <th>Tipo</th>    
              <th>Respuesta</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody id="bodyTableQuestions"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  //------ Seccion 2: Alta de Encuestas ------
  $(document).ready(function() {
    getTestTable();
    
    $('#titleNewTest').keyup(function() {
      const type = document.getElementById('TipoRespuesta').value;
      if (this.value != 0 && type != 0) {
        $('#btnSaveTest').prop('disabled',false);
      }
      else {
        $('#btnSaveTest').prop('disabled',true);
      }
    })

    $('#TipoRespuesta').change(function() {
      const title = document.getElementById('titleNewTest').value;
      if (this.value != 0 && title != 0) {
        $('#btnSaveTest').prop('disabled',false);
      }
      else {
        $('#btnSaveTest').prop('disabled',true);
      }
    })

    /*$('#preguntaEnc').keyup(function() {
      if (this.value != 0) {
        $('#btnSaveQuestion').prop('disabled',false);
      }
      else {
        $('#btnSaveQuestion').prop('disabled',true);
      }
    })*/
  })

  function getTestTable() {
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>pregunta/getTestOn`,
      beforeSend: (load) => {
        $('#bodyTableTest').html(`
            <tr>
                <td colspan="6">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        var trtd = ``;
        for (const a in r) {
          var url = `<p><?=base_url()?>encuesta/encuestasUrl?id=${r[a].idcabencuesta}</p>`;
          trtd += `
            <tr>
              <td>${r[a].idcabencuesta}</td>
              <td>${r[a].descripcion}</td>
              <td>${url}</td>
              <td>${r[a].fecha}</td>
              <td>
                <a class='btn btn-primary' data-id="${r[a].idcabencuesta}" data-title="${r[a].descripcion}" href="#SectionQuestion" onclick="addQuestionTest(this)"><i class="fas fa-pencil-alt"></i> Agregar</a>
              </td>
              <td>
                <button class='btn btn-danger' onclick="closeTest(${r[a].idcabencuesta})">
                  Cerrar <i class="fas fa-times"></i>
                </button>
              </td>
            </tr>
          `;
        }
        $('#bodyTableTest').html(trtd);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getTableQuestions(id) {
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>pregunta/getQuestionTest`,
      data: { 
        id: id
      },
      beforeSend: (load) => {
        $('#bodyTableQuestions').html(`
            <tr>
                <td colspan="5">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const p = JSON.parse(data);
        //console.log(p);
        var trtd = ``;
        if (p != 0) {
          for (b in p) {
            trtd += `
              <tr data-id="${p[b].idpregunta}">
                <td>${p[b].idpregunta}</td>
                <td>${p[b].pregunta}</td>
                <td>${p[b].tipo}</td>
                <td>${p[b].respuesta}</td>
                <td>
                  <button class='btn btn-danger' data-id="${p[b].idpregunta}" data-enc="${p[b].idcabencuesta}" onclick="deleteQuestionTest(this)"><i class="fas fa-trash-alt"></i> Eliminar</button>
                </td>
              </tr>
            `;
          }
        }
        else {
          trtd = `<tr><td colspan="5"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        $('#bodyTableQuestions').html(trtd);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function saveNewTest() {
    const title = document.getElementById('titleNewTest').value;
    const type = document.getElementById('TipoRespuesta').value;
    const apli = document.getElementById('encuestaA').value;
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>pregunta/GuardarEncuesta`,
      data: {
        descripcion: title,
        TipoRespuesta: type,
        encuestaA: apli
      },
      beforeSend: (load) => {
        $('.content-loading-test').html(`
            <div class="container-spinner-content-loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        if (r['status'] == "success") {
          swal("¡Guardado!", "Encuesta creada con éxito.", "success");
          $('.content-loading-test').html(``);
          getTestSelect();
          getTestTable();
          <?php //if($permission==1){?>
          getInfoTestComplete();
          <? //} ?>
        }
      },
      error: (error) => {
        swal("¡Uups!", "Ocurrió un error al intentar guardar.", "error");
        $('.content-loading-test').html(``);
      }
    })
  }

  function saveNewQuestion() { //Modificado [Suemy][2024-05-27]
    const id = $('#IDTestSelect').text();
    const p = document.getElementById('preguntaEnc').value;
    const t = document.getElementById('tipoEnc').value;
    const r = document.getElementById('respuestaEnc').value;
    const s = document.getElementById('NPSEnc').value;
    //console.log(id, p, t, r, s);
    if (p != 0) {
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>pregunta/GuardarPregunta`,
      data: {
        pregunta: p,
        TipoRespuesta: t,
        respuesta: r,
        selectNps: s,
        Encuesta: id
      },
      beforeSend: (load) => {
          $('#btnSaveQuestion').html(`
            <div class="container-spinner-btn-loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
          `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        if (r['status'] == "success") {
          swal("¡Guardado!", "Pregunta creada y guardada con éxito.", "success");
          //$('.content-loading-question').html(``);
          getTableQuestions(id);
        }
        $('#btnSaveQuestion').html("Guardar");
      },
      error: (error) => {
        console.log(error);
        swal("¡Vaya!", "Hay problemas al intentar guardar.", "error");
        //$('.content-loading-test').html(``);
        $('#btnSaveQuestion').html("Guardar");
      }
    })
  }
    else {
      swal("¡Espera!", "Aún no has escrito la pregunta.", "warning");
    }
  }

  function addQuestionTest(test) {
    const id = $(test).data('id');
    const title = $(test).data('title');
    $('#IDTestSelect').text(id);
    $('#titleTestEnc').val(title);
    $('#btnUpdateTitle').prop('disabled',false);
    $('#titleTestEnc').prop('disabled',false);
    $('#preguntaEnc').prop('disabled',false);
    $('.content-loading-title').html("");
    getTableQuestions(id);
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>pregunta/VistaPregunta`,
      data: {
        IdEncuesta: id,
      },
      beforeSend: (load) => {
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let n = r['nombre'];
        let t = r['tipoEncuesta'];
        var option1 = ``;
        var option2 = ``;
        var option3 = ``;

        for (a in n) {
          const type = n[a].tipo;
          if (type == 1) {
            option1 += `<option value="NUMERO">1..10</option>`;
            option2 += `<option value="1">1</option>`;
            //
            for (c in t) {
              const tEnc = t[c].tipoencuesta;
              if (tEnc == 0 || tEnc == 1) {
                option3 += `
                  <option value="Tiempos">Tiempos</option>
                  <option value="Aseguradora">Aseguradora</option>
                  <option value="Asesoria">Asesoria</option>
                  <option value="Gestor">Gestor</option> `;
              }
              else if (tEnc == 2) {
                option3 += `
                  <option value="Tiempos">Tiempos</option>
                  <option value="Aseguradora">Aseguradora</option>
                  <option value="Profesionalismo">Profesionalismo</option>
                  <option value="Nivel">Nivel de Satisfaccion </option> `;
              }
            }
          }
          else if (type == 2) {
            option1 += `<option value="NUMERO">1..10</option>`;
            option2 += `
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            `;
          }
          else if (type == 3) {
            option1 += `<option value="VOF">V o F(SI O NO)</option>`;
            option2 += `<option value="V">V (SI)</option><option value="F">F (NO)</option>`;
          }
        }

        $('#tipoEnc').html(option1);
        $('#respuestaEnc').html(option2);
        $('#NPSEnc').html(option3);
        $('#tipoEnc').prop('disabled',false);
        $('#respuestaEnc').prop('disabled',false);
        $('#NPSEnc').prop('disabled',false);
        $('#btnSaveQuestion').prop('disabled',false);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function closeTest(id) {
    swal({
        title: "¿Desea desactivarlo?",
        text: "La encuesta seleccionada será desactivada.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
      if (value) {
        $.ajax({
          type: "POST",
          url: `<?=base_url()?>pregunta/CierraEncuesta`,
          data: {
            IdEncuesta: id,
          },
          beforeSend: (load) => {
          },
          success: (data) => {
            const r = JSON.parse(data);
            //console.log(r);
            if (r['status'] == "success") {
              swal("¡Hecho!", "La encuesta ha finalizado.", "success");
              getTestTable();
            }
          },
          error: (error) => {
            swal("¡Uups!", "Ocurrió un error al intentar la acción.", "error");
          }
        })
      }
    })
  }

  function updateTitle() {
    const id = $('#IDTestSelect').text();
    const title = document.getElementById('titleTestEnc').value;
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>pregunta/updateTitulo`,
      data: {
        idencuesta: id,
        titulo: title
      },
      beforeSend: (load) => {
        $('.content-loading-title').html(`
            <div class="container-spinner-btn-loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
            </div>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        console.log(r);
        if (r == true) {
          $('.content-loading-title').html(`<i class="fas fa-check-circle icon-circle-check"></i><label class="textCheck">Listo</label>`);
          getTestTable();
        }
      },
      error: (error) => {
        console.log(error);
        $('.content-loading-title').html(`<i class="fas fa-times-circle icon-circle-close"></i><label class="textError">Error</label>`);
      }
    })
  }

  function deleteQuestionTest(question) {//Modificado [Suemy][2024-04-16]
    const id = $(question).data('id');
    const enc = $(question).data('enc');
    swal({
        title: "¿Desea eliminarlo?",
        text: "La pregunta se eliminará de la encuesta.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
      if (value) {
    console.log(enc, id);
        $.ajax({
          type: "POST",
          url: `<?=base_url()?>pregunta/eliminaPregunta`,
          data: {
            idenc: enc,
            IDpre: id,
          },
          beforeSend: (load) => {
          },
          success: (data) => {
            const r = JSON.parse(data);
            //console.log(r);
            if (r['status'] == "success") {
              swal("¡Eliminado!", "Pregunta eliminada con éxito.", "success");
              getTableQuestions(enc);
            }
          },
          error: (error) => {
            swal("¡Vaya!", "Hay conflicto al intentar eliminar.", "error");
          }
        })
      }
    })
  }

  function checkNPS() {
    const id = $('#IDTestSelect').text();
    const s = document.getElementById('NPSEnc').value;
    $.ajax({
      type: "POST",
      url: `<?=base_url()?>pregunta/verificaNps`,
      data: {
        idencuesta: id,
        pregunta: s
      },
      beforeSend: (load) => {
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        if (r >= 1) {
          swal("¡Aviso!", "El NPS solo puede tener una pregunta de " + s, "warning");
        }
        else {
          saveNewQuestion();
        }
      },
      error: (error) => {
        console.log(error);
      }
    })
  }
</script>