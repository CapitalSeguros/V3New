<div class="panel panel-default" style="margin-bottom: 80px;">
  <div class="panel-body column-flex-center-start">
    <div class="col-md-4" style="border-right: 1px solid #dbdbdb;">
      <h4 class="titleSection">Encuestas</h4>
      <hr class="title-hr">
      <div class="col-md-12 pd-left pd-right" id="btnTestView" style="height: 510px;overflow: auto;background: #f7f7f7;">
      </div>
    </div>
    <div class="col-md-8">
      <h4 class="titleSection pd-bottom"> Título:
        <strong id="titleTestSelect">(Título de la Encuesta Faltante)</strong>
      </h4>
      <h5 class="subtitleSection pd-bottom">Personas Faltantes Por Contestar: 
        <strong id="personsMissingTest">(0)</strong>
      </h5>
      <div class="col-md-12">
        <label class="subtitleSection">Nombre y celular:</label>  
        <select class="form-control width-ajust" id="selectPerson">
          <option>NINGUNO</option>
        </select>
      </div>
      <div class="col-md-12 pd-left pd-right">
        <hr class="subtitle-hr">
      </div>
      <form id="formencuestas" name="formencuestas" method="post" action=""> 
        <input type="hidden" name="idenc" id="idenc" value="">
        <div class="col-md-12 pd-top pd-bottom" id="contAnswersSelect"style="height: 350px;overflow: auto;background: #f7f7f7;"></div>
        <div class="col-md-12 column-flex-center-center pd-top">
          <button type="submit" class="btn btn-primary" id="btnSaveAnswers" style="margin-right:5px;" disabled><i class="fas fa-save"></i> Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  //------ Seccion 5: Encuestas Por Teléfono  ------
  $(document).ready(function() {
    $('#selectPerson').change(function() {
      getQuestionsTest();
    })

    $("#formencuestas").on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(document.getElementById("formencuestas"));
      $.ajax({
          url: `<?=base_url()?>asigna/GrabaEncu`,
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: (load) => {
            $('#spinnerSaveTest').html(`
              <div class="container-spinner-content-loading">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Espere...</p>
              </div>
            `);
          },
          success: (data) => {
            const res = JSON.parse(data);
            console.log(res);
            const test = document.getElementsByClassName('btnTestActive')[0].value;
            $('#spinnerSaveTest').html("");
            swal("¡Guardado!", "Se ha guardado exitósamente.", "success");
            getUsersTest(test);
            getTestResult();
            <?php //if($permission==1){?>
            getInfoTestComplete();
            <? //} ?>
            //window.location.reload();
          },
          error: (error) => {
              swal("¡Uups!", "Hay problemas al intentar guardar la información.", "error");
          }            
      })
    })
  })

  function getUsersTest(id) {
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getUsersTest`,
      data: {
        id: id
      },
      beforeSend: (load) => {
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let f = r['personasFaltantes'];
        var option = ``;
        if (f != 0) {
          for (a in f) {
            /*var celular = f[a].celPersonal.replace(" ", "");
            celular.replace(".", "");*/
            var celular = f[a].celPersonal;
            if (f[a].celPersonal == 0 || f[a].celPersonal == undefined || f[a].celPersonal == null) {
              celular = "Ninguno";
            }
            option += `<option value="${f[a].idcalificaencuesta}">${f[a].usuario} (${celular})</option>`;
          }
          $('#btnSaveAnswers').prop('disabled',false);
        }
        else {
          option = `<option value="0">NINGUNO</option>`;
          $('#btnSaveAnswers').prop('disabled',true);
        }
        $('#titleTestSelect').text(r['titulo']);
        $('#personsMissingTest').text(f.length);
        $('#selectPerson').html(option);
        getQuestionsTest();
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getQuestionsTest() {
    const score = document.getElementById('selectPerson').value;
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getQuestionsTest`,
      data: {
        id: score
      },
      beforeSend: (load) => {
        $('#contAnswersSelect').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
          </div>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let p = r['preguntas'];
        var option = ``;
        var div = ``;

        if (p != 0) {
          for (a in p) {
            answer = ``;
            div += `<div><label class="textQuestion">${p[a].pregunta}</label>`;
            if (p[a].tipo == 1) {
              div += `
                <div class="column-flex-center-start"><label class="textResponse">Respuesta:</label>
                <select class="form-control width-ajust" name="${p[a].idencuesta}" id="${p[a].idencuesta}">
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
                </select></div>`;
            }
            else {
              div +=`
                <div class="column-flex-center-start"><label class="textResponse">Respuesta:</label>
                <select class="form-control width-ajust" name="${p[a].idencuesta}" id="${p[a].idencuesta}">
                  <option value="V">V</option>
                  <option value="F">F</option>
                </select></div>
              `;
            }
            div += `</div><hr class="subtitle-hr">`;
          }
        }
        else {
          div = `<option value="0">NINGUNO</option>`;
        }
        $('#idenc').val(r['idcalificaencuesta']);
        $('#contAnswersSelect').html(div);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function selectedTest(obj){
    let btn = document.getElementsByClassName('btnTestActive');
    for (let i=0;i<btn.length;i++){btn[i].classList.remove('btnTestActive');}
    obj.classList.add('btnTestActive');
    test = obj.value;
    getUsersTest(test);
  }
</script>