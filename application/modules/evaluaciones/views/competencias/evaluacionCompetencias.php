<style>
    .menu{
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }
    .menuCompetencias {
        color: white !important;
        white-space: normal;
        word-wrap: break-word;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1rem;
        box-sizing: border-box;
    }
    .table {
    /*min-width: 1600px; /* Puedes ajustarlo */
    border-collapse: collapse;
  }
</style>

<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5">
            <h3 class="titulo-secciones" id="seccion">Evaluacion por competencias</h3>
        </div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <?= $breadcrumbs; ?>
        </div>
    </div>
    <hr />
</section>

<section class="container">
<?= $this->load->view('_parts/sidemenu2',array("tipo"=>$tipo));?>
    <div style="float: left; width: 90%;">
            <div class="panel panel-default">
                <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#L1" data-toggle="tab">
                                    <i class="fa fa-file-o" aria-hidden="true"></i> Evaluación
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#L2" data-toggle="tab">
                                    <i class="fa fa-table" aria-hidden="true"></i> Resultados
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="well table-responsive tab-pane active" style="background-color: #fff;" id="L1">
                                   <div class="row">
                        <div class="col-md-12">
                            <h5>* Seleccione la competencia que desea evaluar</h5>
                            <div class="btn-group btn-group-toggle panel w-100 menu" data-toggle="buttons" style="background-color: #6c757d;">
    <label class="btn btn-secondary active menuCompetencias col-md-2">
      <input type="radio" name="options" id="option1" value="1" autocomplete="off" checked> Trabajo en equipo
    </label>
    <label class="btn btn-secondary menuCompetencias col-md-2">
      <input type="radio" name="options" id="option2" value="2" autocomplete="off"> Iniciativa
    </label>
    <label class="btn btn-secondary menuCompetencias col-md-2">
      <input type="radio" name="options" id="option3" value="3" autocomplete="off"> Calidad de trabajo
    </label>
    <label class="btn btn-secondary menuCompetencias col-md-2">
      <input type="radio" name="options" id="option4" value="4" autocomplete="off"> Orientacion al servicio
    </label>
    <label class="btn btn-secondary menuCompetencias col-md-2">
      <input type="radio" name="options" id="option5" value="5" autocomplete="off"> Planificación y organización del trabajo
    </label>
    <label class="btn btn-secondary menuCompetencias col-md-2">
      <input type="radio" name="options" id="option6" value="6" autocomplete="off"> Pensamiento analítico
    </label>
  </div>
                        </div>
                    </div>
                    <div class="panel">
                      <form id="formPreguntas">
                      <input type="text" class="hidden" id="idCompetencia" name="idCompetencia">
                        <pre>Registra tu evaluación con base a la siguiente escala:
    1 - Totalmente en desacuerdo - Nunca lo ha mostrado.
    2 - En desacuerdo, muy pocas veces lo ha demostrado.
    3 - Ocasionalmente lo ha demostrado.
    4 - De acuerdo, generalmente lo ha demostrado.
    5 - Totalmente de acuerdo, consistentemente lo ha demostrado.</pre>
                        <div class="table-responsive"><table class="table">
                            <thead class="thead-dark" id="encabezadoExC">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">CHABLE COCOM CHRISTIAN JOSUE</th>
                                <th scope="col">GARRIDO ROSADO MARIA ISABEL</th>
                                <th scope="col">CAUICH MUKUL VERONICA ALEJANDRA</th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoExC">
                                <tr>
                                <th scope="row">1. Esta persona participa de manera proactiva en las discusiones y actividades del equipo, asegurando que sus contribuciones sean relevantes y útiles para el grupo.</th>
                                <td><input type="number" class="form-control"  min="1" max="5"></td>
                                <td><input type="number" class="form-control"  min="1" max="5"></td>
                                <td><input type="number" class="form-control"  min="1" max="5"></td>
                                </tr>
                                <tr>
                                <th scope="row">2. Esta persona se ajusta a las necesidades y dinámicas del equipo, mostrando flexibilidad en diferentes roles y responsabilidades.</th>
                                <td><input type="number" class="form-control"  min="1" max="5"></td>
                                <td><input type="number" class="form-control"  min="1" max="5"></td>
                                <td><input type="number" class="form-control" min="1" max="5"></td>
                                </tr>
                            </tbody>
                        </table></div>
                      </form>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-secondary" style="color: white !important;" onclick="guardarRespuestas()">Guardar respuestas</button>
                    </div>         
                                </div><!--cierre L1-->

                                <div class="well table-responsive tab-pane" style="background-color: #fff;" id="L2">
                                    
                                    <div id="tablaResult">
                                      <table class="table">
                                        <thead class="thead-dark">
                                        <tr>
                                          <th>Nombre</th>
                                          <th>Puesto</th>
                                          <th>Departamento</th>
                                          <th>Trabajo en equipo</th>
                                          <th>Iniciativa</th>
                                          <th>Calidad de trabajo</th>
                                          <th>Orientacion al servicio</th>
                                          <th>Planificación y organización del trabajo</th>
                                          <th>Pensamiento analítico</th>
                                          <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody id="bodyResult">

                                        </tbody>
                                        </table>
                                    </div>
                                </div><!--cierre L2-->
                            </div><!--cierre Tab content-->
                </div><!--cierre panel body-->
            </div>
    </div>
</section>


<script>
      function funcionCuandoActivo(valor) {
      console.log("Radio activo con valor:", valor);
      // Aquí tu lógica personalizada
      document.getElementById("idCompetencia").value = valor;
       $.ajax({
            type:"POST",
            url:<?php echo('"'.base_url().'evaluacionCompetencias/getInfoCompetencia"'); ?>,
            data:{"competencia":valor},
            error: function(){},
            success: function(data){
            const r = JSON.parse(data);
            const colaboradores = r['puestos'];
            const idPersona = r['idPersona'];
            const preguntas = r['preguntas'];
            const respuestas = r['respuestas'];
            //console.log(colaboradores, idPersona);
            //console.log(preguntas);
            thead=`<tr><th scope="col">#</th>`;
            tbody=``;
            for (const d in colaboradores){
                if(idPersona==colaboradores[d].id){
                    continue;
                }
                thead+=`<th class="text-center" scope="col">${colaboradores[d].nombre}</th>`;
            }
            thead+=`</tr>`;
            $('#encabezadoExC').html(thead);

            for (const q in preguntas){
                tbody+= `<tr><th scope="row">${preguntas[q].pregunta}</th>`;
               for (const d in colaboradores){
                    if(idPersona==colaboradores[d].id){
                        continue;
                    }
                    if(respuestas=="Guardadas"){
                      tbody+=`<td class="text-center"><i class="fa fa-check-circle fa-2x" aria-hidden="true" style="color: #06cb5b;"></i></td>`;
                    }else{
                      tbody+=`<td><input type="number" class="form-control" id="${preguntas[q].idPregunta}-${colaboradores[d].id}" name="${preguntas[q].idPregunta}-${colaboradores[d].id}" min="1" max="5" required></td>`;
                    }
                    
                } 
                tbody+= `</tr>`;
            }
            $('#cuerpoExC').html(tbody);

            }
        });
}

function traerResultados() {
    $.ajax({
        url: "<?php echo base_url('evaluacionCompetencias/getInfoResultados'); ?>",
        method: "GET",
        dataType: "json", // <- Indica que esperas un JSON
        success: function(data) {
            // Suponiendo que `data.respuestas` es un array
            let html = '';
            data.respuestas.forEach(function(item) {
                html += '<tr>';
                html += '<td>' + item.nombre + '</td>';
                html += '<td>' + item.puesto + '</td>';
                html += '<td>' + item.departamento + '</td>';
                html += '<td>' + item.competencia1 + '%</td>';
                html += '<td>' + item.competencia2 + '%</td>';
                html += '<td>' + item.competencia3 + '%</td>';
                html += '<td>' + item.competencia4 + '%</td>';
                html += '<td>' + item.competencia5 + '%</td>';
                html += '<td>' + item.competencia6 + '%</td>';
                html += '<td>' + item.total + '%</td>';
                html += '</tr>';
            });
            $('#bodyResult').html(html);
        },
        error: function(xhr, status, error) {
            console.log("Error en la petición AJAX:", error);
            $('#tablaResult').html('<p>Error al cargar resultados</p>');
        }
    });
}

    // Obtener todos los radios
    const radios = document.querySelectorAll('input[type="radio"][name="options"]');

  window.addEventListener('DOMContentLoaded', () => {
    const labels = document.querySelectorAll('.menu label');

    // Ejecutar al cargar el que esté activo
    const checkedInput = document.querySelector('.menu input[type="radio"]:checked');
    if (checkedInput) {
      funcionCuandoActivo(checkedInput.value);
    }

    // Escuchar clicks en labels
    labels.forEach(label => {
      label.addEventListener('click', () => {
        // Espera un tick para que el input cambie su estado
        setTimeout(() => {
          const checkedInput = document.querySelector('.menu input[type="radio"]:checked');
          if (checkedInput) {
            funcionCuandoActivo(checkedInput.value);
          }
        }, 0);
      });
    });
    traerResultados();
  });
    

  function guardarRespuestas(){
         
      const form = document.getElementById('formPreguntas');
      if (form.checkValidity()) {
            // Si es válido, enviar con AJAX
            const datos = $('#miFormulario').serialize(); 
            const formData = new FormData(form);
            const url="<?=base_url()?>evaluacionCompetencias/guardarRespuestas";
            // Convertir a objeto JSON
            const data = {};
            formData.forEach((valor, clave) => {
              data[clave] = valor;
            });
            
            $.ajax({
              url: url,
              type: 'POST',
              contentType: 'application/json',
              data: JSON.stringify(data),
              dataType: "json",
              success: function(respuesta) {
                console.log('Respuesta del servidor:', respuesta);
                alert('Formulario enviado correctamente');
                traerResultados();
                respuesta.forEach(function(item) {
                    funcionCuandoActivo(item.valor); 
                });
              },
              error: function(xhr, status, error) {
                console.error('Error al enviar:', error);
                alert('Error al enviar el formulario');
              }
            });
            console.log("Enter");
      } else {
                // Si no es válido, muestra los errores
                form.reportValidity();
              }
  }
  </script>