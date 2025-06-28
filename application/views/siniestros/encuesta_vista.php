<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas Siniestros Capital</title>
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/img/logo/iconCapital.png">
    <!-- Estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
  	<!-- Iconos -->
  	<!-- <script defer src="https://use.fontawesome.com/releases/v5.14.0/js/all.js"></script> -->
  	<script defer src="https://use.fontawesome.com/releases/v6.5.2/js/all.js"></script>
  	<!-- Alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <style type="text/css">
    	body {background: #133b78;}
    	body > section {padding: 30px 60px;}
    	footer {padding: 20px; background: #2a2a2a;}
    	/* ID */
    		#btnGuardar {font-size: 15px;}
    	/* Containers */
    		.col-md-12, .col-md-4 {padding: 0px 15px;}
    		.form-input-container > .col-md-6 {padding-left: 15px;padding-right: 15px;}
    		.segment-questions {padding: 15px;border: 1px solid #cfe3eb;border-radius: 8px;background: #f2f7f9;}
    		.container-question {margin-bottom: 10px;padding: 5px;border-radius: 5px;transition: 0.5s;}
    		.alert-primary {background: #ddebff;border-color: #ddebff;}
        .container-no-active-survey {
          margin: 0px;
          color: #266093;
          width: 100%;
          height: 100%;
          align-items: center;
          display: flex;
          flex-direction: column;
          justify-content: center;
          position: fixed;
          background-color: rgb(0 0 0 / 50%);
          z-index: 1;
          transition: all 0.3s;
        }
        .container-no-active-survey:after {content: "Encuesta resuelta.";position: absolute;color: white;font-size: 45px;font-family: fantasy;text-align: center;}
    	/* Bottons */
    		.btn-url-footer {background: transparent;border: none;font-size: 0.8rem;text-decoration: none;color: #9b9b9b;transition: 0.3s;}
    		.btn-url-footer:hover {color: white;}
    	/* Texts */
        .title-survey {color: #133b78;}
    		.title-footer {font-size: 1rem;color: #878787;}
    		.subtitle-footer {font-size: 0.8rem;color: #9b9b9b;/*707070*/}
    		.title-footer-hidden {color: #565656;font-size: 0.8rem;text-align: center;}
      /* Inputs */
        input.form-control, textarea.form-control {color: #2c5799;}
    	/* Images */
    		.img-logo-msg {clip-path: polygon(0 0, 0% 35%, 100% 35%, 100% 66%, 0% 66%);}
    	/* Others */
    		.brd-right-footer {border-right: 1px solid #3d3d3d;}
    		.not-response {background: #ffc8c8;transition: 0.5s;}
        .pd-left-add {padding-left: 15px;}
        .pd-right-add {padding-right: 15px;}
    	/*Media Query*/
  			@media (max-width: 1440px) {
  			    .table-width { max-width: 1220px; }
  			}
  			@media (max-width: 1280px) {
  			    .table-width { max-width: 1060px; }
  			}
  			@media (max-width: 1024px) {
  				.items-quiz {flex-wrap: wrap;}
  			}
  			@media (max-width: 800px) {
  				body > section {padding: 30px 25px;}
  				.form-input-container > div.col-md-6 {width: 100%;}
          .form-input-container > div.col-md-3 {width: 100%;}
          .form-input-container > div.col-md-9 {width: 100%;}
  				.form-input-container, .form-input-container > div, .items-quiz {flex-direction: column;align-items: flex-start;}
          .swal2-popup {width: 26rem;}
  			}
    </style>
    <script type="text/javascript">
      $(document).ready(function() {
        getAnswer('<?=$mode?>');
        $('.answer-quiz').click(function() {
          const question = $(this).data('num');
          if ($('#q-'+question).hasClass('not-response')) {
            $('#q-'+question).removeClass('not-response');
          }
        })
      })

      $(document).bind("contextmenu",function(e){
        return false;
      })

      /*window.onload = function() {
        document.addEventListener("contextmenu", function(e){
          e.preventDefault();
        }, false);
      }*/

      function getAnswer(mode) {
        if (mode != "example") {
          const id = $('input[name="client-info"][data-field="id"]').val();
          $.ajax({
              type: "GET",
              url: `<?=base_url()?>siniestros/getAnswersQuestionByClient`,
              data: { id: id },
              success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                if (r != 0) {
                  r.forEach((e) => {
                    let input = document.getElementsByName(e.idPregunta);
                    for (let i=0;i<input.length;i++) {
                      if (input[i].value == e.respuesta) { $(input[i]).prop('checked',true); }
                    }
                  })
                }
              },
              error: (error) => {
                console.log(error);
              }
          })
        }
      }

      function save_answers(mode) {
        const name = document.getElementById('client').value;
        const ticket = document.getElementById('ticket').value;
        let client = document.getElementsByName('client-info');
        let input = document.getElementsByClassName('answer-quiz');
        let insert = [];
        let values = [];
        let empty = [];
        var empty_t = "";
        //Operation
        for (let i=0;i<client.length;i++) {
          const val = client[i].value;
          insert.push(val);
        }
        for (let i=0;i<input.length;i++) {
          const numQ = $(input[i]).data('num');
          const idQ = input[i].name;
          let count = document.getElementsByName(idQ);
          let add = {};
          if (input[i].checked) {
            add['question'] = idQ;
            add['answer'] = $(input[i]).data('resp');
            add['type'] = $(input[i]).data('type');
            add['value'] = input[i].value;
            values.push(add);
          }
          else {
            var no_resp = 0;
            if (!empty_t.includes(numQ)) {
              for (let j=0;j<count.length;j++) {
                if (!count[j].checked) { no_resp++; }
              }
              if (no_resp == count.length) {
                if (empty_t != 0) { empty_t = empty_t + ", "; }
                empty_t = empty_t + ("Pregunta " + numQ);
                empty.push(numQ);
              }
            }
          }
        }
        //Verification
        if (name == 0 || ticket == 0) {
          var text = (name == 0) ? "Nombre" : (ticket == 0 ? "Folio" : "");
          return Swal.fire("¡Espera!", "Parece que no has escrito el " + text + ".", "warning");
        }
        if (empty != 0) {
          empty.forEach((e) => {
            $('#q-'+e).addClass('not-response');
          })
          return Swal.fire("¡Espera!", "No has respondido todas las preguntas, te falta: " + empty_t + ".", "warning"); 
        }
        else {
          console.log(insert, values);
              
        }
        if (mode == "client") {
          //Send
          $.ajax({
              type: "POST",
              url: `<?=base_url()?>siniestros/updateDataSurvey`,
              data: {
                up: insert,
                in: values
              },
              beforeSend: (load) => {
                $('#SpinnerBar').prop('hidden',false);
              },
              success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                $('#SpinnerBar').prop('hidden',true);
                if (r['status_update'] == true) {
                  Swal.fire("¡Enviado!", "Respuestas enviadas con éxito.", "success");
                }
                else {
                  Swal.fire("¡Uups!", "Parece que ocurrió un conflicto al intentar enviar. Inténtelo nuevamente.", "error"); 
                }
              },
              error: (error) => {
                console.log(error);
                $('#SpinnerBar').prop('hidden',true);
                Swal.fire("¡Vaya!", "Hay problemas al intentar enviar. Favor de reportarlo.", "error");
              }
          })
        }
      }
    </script>
</head>
<body>
  <div class="<?=$class?>"></div>
  <!-- Spinner Bar -->
  <div id="SpinnerBar" class="container-spinner-bar" hidden>
    <div class="container-spinner-bar-content-loading">
      <div class="spinner-bar">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
      </div>
    </div>       
  </div>
	<section>
		<div class="card">
			<div class="card-body">
        <div class="col-md-12 column-flex-center-start form-input-container">
          <div class="col-md-3">
            <img src="<?=base_url()?>assets/img/logo/logo_capital.png" width="100%">
          </div>
          <div class="col-md-9 column-flex-center-end pd-left-add pd-right-add">
            <h4 class="title-survey"><?=$survey->titulo?></h4>
          </div>
        </div>
				<hr class="history-hr">
				<div class="col-md-12 column-flex-center-start form-input-container">
					<div class="col-md-6 pd-items-table">
						<label class="textForm">Nombre del Ejecutivo:</label>
						<input type="text" class="form-control" id="employee" value="<?=$employee?>" disabled>
					</div>
					<div class="col-md-3 pd-items-table pd-left-add pd-right-add">
						<label class="textForm width-ajust">Hora de Ingreso:</label>
						<input type="time" class="form-control" name="client-info" value="<?=date('H:i:s')?>">
					</div>
          <div class="col-md-3 pd-items-table pd-left-add pd-right-add">
            <label class="textForm width-ajust">Fecha de Ingreso:</label>
            <input type="date" class="form-control" name="client-info" value="<?=date('Y-m-d')?>">
          </div>
				</div>
        <div class="col-md-12 column-flex-center-start form-input-container">
          <div class="col-md-6 pd-items-table">
            <label class="textForm">Contratante y Asegurado:</label>
            <input type="text" class="form-control" id="client" value="<?=$client?>">
          </div>
          <div class="col-md-3 pd-items-table pd-left-add pd-right-add">
            <label class="textForm width-ajust">Num. de Póliza:</label>
            <input type="text" class="form-control" value="<?=$poliza?>" disabled>
          </div>
          <div class="col-md-3 pd-items-table pd-left-add pd-right-add">
            <label class="textForm width-ajust">Folio:</label>
            <input type="text" class="form-control" id="ticket" name="client-info" data-field="folio" value="<?=$id?>">
          </div>
        </div>
				<hr class="history-hr">
				<div class="col-md-12 column-flex-center-start pd-items-table" style="margin-bottom: 20px;">
					<label class="textForm"><?//=$instructions?></label>
				</div>
				<div class="col-md-12">
					<div class="col-md-12 segment-questions">
						<?=$questions;?>
					</div>
				</div>
				<div hidden>
          <div class="pd-side">
            <input type="text" class="form-control" name="client-info" data-field="id" value="<?=$id?>">
          </div>
					<div class="pd-side">
						<input type="text" class="form-control" name="client-info" value="<?=$survey->idEncuesta?>">
					</div>
					<div class="pd-side">
						<input type="text" class="form-control" name="client-info" value="<?=$survey->tipo?>">
					</div>
				</div>
				<div class="col-md-12 column-flex-center-center" style="margin-top: 20px;">
					<button class="btn btn-primary hvr-icon-push" id="btnGuardar" onclick="save_answers('<?=$mode?>')">
						<i class="fas fa-save hvr-icon"></i>
						<span class="">Guardar respuestas</span>
					</button>
				</div>
			</div>
		</div>
		<? //var_dump($client); ?>
	</section>
</body>
<footer hidden>
	<section>
		<div class="col-md-12">
			<h6 class="title-footer-hidden" style="margin: 20px 0px;">© <?=date('Y')?> Capital Seguros y Fianzas - Todos los derechos reservados.</h5>
		</div>
	</section>
</footer>
</html>