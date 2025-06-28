<?php 
	$this->load->view('headers/header'); 
	$this->load->view('headers/menu');
?>
<style type="text/css">
  .tablita{
    font-size: 12px;
    width: 50%;
  }
  h4{
    color: #A5A5A5;
  }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
<div  style="margin: 1%;">
		<div class="row" >
			<div class="col-md-5 col-sm-5 col-xs-5">
				<h3 class="titulo-secciones">
					<br>
    				<i class="fa fa-bar-chart"></i> Estadisticas de Marketing - Detección de Necesidades
				</h3>
			</div>
		</div>
    <br>
    <div class="well">
      <!-- Primer row-->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="well" style="background-color: #fff;">
             <canvas id="chartEdoCivil"></canvas>
             <p>
               <div>
                 <h4>Totales (Estado Civil)</h4>

                 <table class="tablita">
                  <tr><td><b>Casado</b></td><td style="text-align: right;"><?php echo $casado;?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>Casado con Hijos:</b></td><td style="text-align: right;"><?php echo $casado_hijos;?></td></tr>
                  <tr><td><b>Divorciado:</b></td><td style="text-align: right;"><?php echo $divorciado;?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>Divorciado con Hijos:</b></td><td style="text-align: right;"><?php echo $divorciado_hijos;?></td></tr>
                  <tr><td><b>Soltero:</b></td><td style="text-align: right;"><?php echo $soltero;?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>Soltero con Hijos</b></td><td style="text-align: right;"><?php echo $soltero_hijos;?></td></tr>
                  <tr><td><b>Union Libre:</b></td><td style="text-align: right;"><?php echo $unionlibre;?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>Union Libre con Hijos:</b></td><td style="text-align: right;"><?php echo $unionlibre_hijos;?></td></tr>
                  <tr><td><b>Viudo:</b></td><td style="text-align: right;"><?php echo $viudo;?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>Viudo con Hijos::</b></td><td style="text-align: right;"><?php echo $viudo_hijos;?></td></tr>
                </table>
                 
               </div>
            </p>
          </div>
        </div>


        <div class="col-md-6 col-sm-6 col-lg-6">
           <div class="well" style="background-color: #fff;">
           <canvas id="chartRangoDeEdad"></canvas>
           <p>
             <div>
               <h4>Totales (Rango de Edad)</h4>
               <table class="tablita">
                  <tr style="background-color: #F2F2F2;"><td><b>Menos de 18:</b></td><td style="text-align: right;"><?php echo $MENOSDE18?></td></tr>
                  <tr><td><b>de 19 a 35:</b></td><td style="text-align: right;"><?php echo $DE19A35?></td></tr>
                  <tr style="background-color: #F2F2F2;"><td><b>de 36 a 50:</b></td><td style="text-align: right;"><?php echo $DE36A50?></td></tr>
                  <tr><td><b>de 51 a 65:</b></td><td style="text-align: right;"><?php echo $DE51A65?></td></tr>
                </table>
               
             </div>
          </p>
        </div>
        </div>
      
      </div>
<br>
      <!-- Segundo row-->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6">
          <div class="well" style="background-color: #fff;">
           <canvas id="chartOcupacion"></canvas>
             <p>
               <div>
                 <h4>Totales (Ocupacion)</h4>
                 <table  class="tablita">
                    <tr style="background-color: #F2F2F2;"><td><b>Ama de Casa:</b></td><td style="text-align: right;"><?php echo $amadecasa;?></td></tr>
                    <tr><td><b>Ejecutivo:</b></td><td style="text-align: right;"><?php echo $ejecutivo;?></td></tr>
                    <tr style="background-color: #F2F2F2;"><td><b>Empleado:</b></td><td style="text-align: right;"><?php echo $empleado;?></td></tr>
                    <tr><td><b>Estudiante:</b></td><td style="text-align: right;"><?php echo $estudiante;?></td></tr>
                    <tr style="background-color: #F2F2F2;"><td><b>Empresario:</b></td><td style="text-align: right;"><?php echo $empresario;?></td></tr>
                    <tr><td><b>Gerente:</b></td><td style="text-align: right;"><?php echo $gerente;?></td></tr>
                    <tr style="background-color: #F2F2F2;"><td><b>Negocio Propio</b></td><td style="text-align: right;"><?php echo $negociopropio;?></td></tr>
                    <tr><td><b>Profesionista Independiente:</b></td><td style="text-align: right;"><?php echo $profesionistaindependiente;?></td></tr>
                    <tr style="background-color: #F2F2F2;"><td><b>Retirado:</b></td><td style="text-align: right;"><?php echo $retirado;?></td></tr>
                    <tr><td><b>Otros Empleos:</b></td><td style="text-align: right;"><?php echo $otrospempleos;?></td></tr>
                 </table>
                
               </div>
            </p>
          </div>
       </div>


        <div class="col-md-6 col-sm-6 col-lg-6">
           <div class="well" style="background-color: #fff;">
           <canvas id="chartFuente"></canvas>
           <br>
               <p>
                 <div>

                   <h4>Totales (Fuente del Propecto))</h4>
                  <table class="tablita">
                    <tr style="background-color: #f2f2f2"><td><b>Amigos de la Escuela</b></td><td style="text-align: right;"><?php echo $AMIGODEESCUELA;?></td></tr>
                    <tr><td><b>Amigos de la Familia:</b></td><td style="text-align: right;"><?php echo $AMIGODEFAMILIA;?></td></tr>
                    <tr style="background-color: #f2f2f2"><td><b>Vecinos:</b></td><td style="text-align: right;"><?php echo $VECINOS;?></td></tr>
                    <tr><td><b>Conocido a traves de Pasatiempos:</b></td><td style="text-align: right;"><?php echo $CONOCIDOPASATIEMPOS;?></td></tr>
                    <tr style="background-color: #f2f2f2"><td><b>Familia propia o Conyugue:</b></td><td style="text-align: right;"><?php echo $FAMPROPIAOCONYUGUE;?></td></tr>
                    <tr><td><b>Conocidos a traves de Grupos Sociales</b></td><td style="text-align: right;"><?php echo $CONOCIDOGRUPOSOCIAL;?></td></tr>
                    <tr style="background-color: #f2f2f2"><td><b>Conocidos por la Actividad de la Comunidad</b></td><td style="text-align: right;"><?php echo $CONOCIDOACTIVICOMUNIDAD;?></td></tr>
                    <tr><td><b>Conocidos de los Antiguos Empleos</b></td><td style="text-align: right;"><?php echo $CONOCIDOANTIGUOEMPLEO;?></td></tr>
                    <tr style="background-color: #f2f2f2"><td><b>Personas con la que hace Negocios</b></td><td style="text-align: right;"><?php echo $PERSONASHACENEGOCIO;?></td></tr>
                    <tr><td><b>Centro de Influencia</b></td><td style="text-align: right;"><?php echo $CENTRODEINFLUENCIA;?></td></tr>
                 </table>
                  
                 </div>
              </p>
            </div>
      
      </div>


    </div>


<br>
      <!--Tercer row-->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6">
          <div class="well" style="background-color: #fff;">
           <canvas id="chartHabilidadesReferencia"></canvas>
             <p>
               <div>
                 <h4>Totales (Habilidades para dar Referencia)</h4>
                 <table class="tablita">
                    <tr style="background-color: #FAFAFA"><td><b>Excelente:</b></td><td style="text-align: right;"> <?php echo $HABILIDADEXCELENTE?></td></tr>
                    <tr><td><b>Buena:</b></td><td style="text-align: right;"><?php echo $HABILIDADBUENA?></td></tr>
                    <tr style="background-color: #FAFAFA"><td><b>Regular:</b></td><td style="text-align: right;"><?php echo $HABILIDADREGULAR?></td></tr>
                 </table>

               </div>
            </p>
          </div>
       </div>


        <div class="col-md-6 col-sm-6 col-lg-6">
            <div class="well" style="background-color: #fff;">
           <canvas id="chartPosibilidad"></canvas>
           <br>
               <p>
                 <div>
                   <h4>Totales (Posibilidad de Acercamiento))</h4>

                  <table class="tablita">
                    <tr><td style="background-color: #FAFAFA"><b>Facilmente</b></td><td style="text-align: right;"><?php echo $FACILMENTE?></td></tr>
                    <tr><td><b>No muy Dificil:</b></td><td style="text-align: right;"><?php echo $NOMUYDIFICIL?></td></tr>
                    <tr><td style="background-color: #FAFAFA"><b>Con Dificultad:</b></td><td style="text-align: right;"><?php echo $CONDIFICULTAD?></td></tr>
                 </table>
                  
                 </div>
              </p>
            </div>
      
      </div>


    </div>


  <br>
      <!--Cuarto row-->
      <div class="row">
        <div class="col-md-6 col-sm-6 col-lg-6">
          <div class="well" style="background-color: #fff;">
           <canvas id="chartIngresoMensual"></canvas>
             <p>
               <div>
                 <h4>Totales (Ingreso Mensual)</h4>
                 <table class="tablita">
                    <tr style="background-color: #FAFAFA">
                      <td><b>Menos de $25000:</b></td>
                      <td style="text-align: right;"> <?php echo $MENOSDE25000?></td></tr>
                    <tr>
                      <td><b>De $25.000 a $60.000:</b></td>
                      <td style="text-align: right;"><?php  echo $DE25000A60000?></td></tr>
                    <tr style="background-color: #FAFAFA">
                      <td><b>De $60.000 a $100.000:</b></td>
                      <td style="text-align: right;"><?php echo $DE6000A100000?></td></tr>
                     <tr>
                      <td><b>Mas de $100.000:</b></td>
                      <td style="text-align: right;"><?php echo $MASDE100000?></td></tr>
                 </table>

               </div>
            </p>
          </div>
       </div>


        <div class="col-md-6 col-sm-6 col-lg-6"></div>


    </div>


		<hr/> 
   
</div>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
     $('#table_id').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
      			"previous": "Anterior",
      			"next": "Siguiente"
    		}
        }
    } );
} );
</script>
<script type="text/javascript">
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

//Estado Civil
var ctx = document.getElementById('chartEdoCivil').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Casado', 'Casado con Hijos', 'Divorciado','Divorciado con Hijos','Soltero','Soltero con Hijos','Union Libre','Union Libre con Hijos','Viudo', 'Viudo con Hijos'],
        datasets: [{
            label: 'ESTADO CIVIL',
            data: [<?php echo $casado?>,<?php echo $casado_hijos?>,<?php echo $divorciado?>,<?php echo $divorciado_hijos?>,<?php echo $soltero?>,<?php echo $soltero_hijos?>,<?php echo $unionlibre?>,<?php echo $unionlibre_hijos?>,<?php echo $viudo?>,<?php echo $viudo_hijos?>],
            backgroundColor: [
                'rgba(0, 0, 255, 0.6)',
                'rgba(60, 179, 113, 0.6)',
                'rgba(255, 0, 0, 0.6)',
                'rgba(255, 165, 0, 0.6)',
                'rgba(106, 90, 205, 0.6)',
                'rgba(238, 130, 238, 0.6)',
                'rgba(180, 180, 180, 0.6)',
                'rgba(255, 99, 71, 0.6)',
                'rgba(82, 122, 162, 0.6)',
                'rgba(255, 253, 130, 0.6)'
            ],
            borderColor: [
               'rgba(0, 0, 255, 1)',
                'rgba(60, 179, 113, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(255, 165, 0, 1)',
                'rgba(106, 90, 205, 1)',
                'rgba(238, 130, 238, 1)',
                'rgba(180, 180, 180, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(82, 122, 162, 1)',
                'rgba(255, 253, 130, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

//Rango de Edad
var ctx = document.getElementById('chartRangoDeEdad').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['MENOS DE 18', 'DE 19 A 35', 'DE 36 A 50','DE 51 A 65'],
        datasets: [{
            label: 'RANGO DE EDAD',
            data: [<?php echo $MENOSDE18;?>,<?php echo $DE19A35;?>,<?php echo $DE36A50;?>,<?php echo $DE51A65;?>],
           backgroundColor: [
              'rgba(82, 122, 162, 0.6)',
              'rgba(106, 90, 205, 0.6)',
              'rgba(238, 130, 238, 0.6)',
              'rgba(180, 180, 180, 0.6)'
            ],
            borderColor: [
             'rgba(82, 122, 162, 1)',
              'rgba(106, 90, 205, 1)',
              'rgba(238, 130, 238, 1)',
              'rgba(180, 180, 180, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


//Ocupacion
var ctx = document.getElementById('chartOcupacion').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Ama de Casa', 'Ejecutivo', 'Empleado','Estudiante','Empresario','Gerente','Negocio Propio','Profesionista Independiente','Retirado','Otros Empleos'],
        datasets: [{
            label: 'OCUPACIÓN',
             data: [<?php echo $amadecasa?>,<?php echo $ejecutivo?>,<?php echo $empleado?>,<?php echo $estudiante?>,<?php echo $empresario?>,<?php echo $gerente?>,<?php echo $negociopropio?>,<?php echo $profesionistaindependiente?>,<?php echo $retirado?>,<?php echo $otrospempleos?>],
            backgroundColor: [
                'rgba(0, 0, 255, 0.6)',
                'rgba(60, 179, 113, 0.6)',
                'rgba(255, 0, 0, 0.6)',
                'rgba(255, 165, 0, 0.6)',
                'rgba(106, 90, 205, 0.6)',
                'rgba(238, 130, 238, 0.6)',
                'rgba(180, 180, 180, 0.6)',
                'rgba(255, 99, 71, 0.6)',
                'rgba(82, 122, 162, 0.6)',
                'rgba(255, 253, 130, 0.6)'
            ],
            borderColor: [
               'rgba(0, 0, 255, 1)',
                'rgba(60, 179, 113, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(255, 165, 0, 1)',
                'rgba(106, 90, 205, 1)',
                'rgba(238, 130, 238, 1)',
                'rgba(180, 180, 180, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(82, 122, 162, 1)',
                'rgba(255, 253, 130, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


//Fuente de prospecto
var ctx = document.getElementById('chartFuente').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Amigos de la Escuela', 'Amigos de la Familia', 'Vecinos','Conocido a traves de Pasatiempos','Familia propia o Conyugue','Conocidos a traves de Grupos Sociales','Conocidos por la Actividad de la Comunidad','Conocidos de los Antiguos Empleos','Personas con la que hace Negocios','Centro de Influencia'],
        datasets: [{
            label: 'FUENTE DE PROSPECTO',
            data: [<?php echo $AMIGODEESCUELA?>,<?php echo $AMIGODEFAMILIA?>,<?php echo $VECINOS ?>,<?php echo $CONOCIDOPASATIEMPOS?>,
            <?php echo $FAMPROPIAOCONYUGUE?>,<?php echo $CONOCIDOGRUPOSOCIAL?>,<?php echo $CONOCIDOACTIVICOMUNIDAD ?>,<?php echo $CONOCIDOANTIGUOEMPLEO?>,<?php echo $PERSONASHACENEGOCIO ?>,<?php echo $CENTRODEINFLUENCIA?>],
             backgroundColor: [
                'rgba(0, 0, 255, 0.6)',
                'rgba(60, 179, 113, 0.6)',
                'rgba(255, 0, 0, 0.6)',
                'rgba(255, 165, 0, 0.6)',
                'rgba(106, 90, 205, 0.6)',
                'rgba(238, 130, 238, 0.6)',
                'rgba(180, 180, 180, 0.6)',
                'rgba(255, 99, 71, 0.6)',
                'rgba(82, 122, 162, 0.6)',
                'rgba(255, 253, 130, 0.6)'
            ],
            borderColor: [
               'rgba(0, 0, 255, 1)',
                'rgba(60, 179, 113, 1)',
                'rgba(255, 0, 0, 1)',
                'rgba(255, 165, 0, 1)',
                'rgba(106, 90, 205, 1)',
                'rgba(238, 130, 238, 1)',
                'rgba(180, 180, 180, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(82, 122, 162, 1)',
                'rgba(255, 253, 130, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});



//Habilidad Referencia
var ctx = document.getElementById('chartHabilidadesReferencia').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['EXCELENTE', 'REGULAR', 'BUENA'],
        datasets: [{
            label: 'HABILIDAD PARA DAR REFERENCIA',
            data: [<?php echo $HABILIDADEXCELENTE?>,<?php echo $HABILIDADBUENA?>,<?php echo $HABILIDADREGULAR?>],
            backgroundColor: [
              'rgba(82, 122, 162, 0.6)',
              'rgba(106, 90, 205, 0.6)',
              'rgba(238, 130, 238, 0.6)'
            ],
            borderColor: [
             'rgba(82, 122, 162, 1)',
              'rgba(106, 90, 205, 1)',
              'rgba(238, 130, 238, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


//Habildad Referencia
/*
var ctx = document.getElementById('chartAfore').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SI', 'NO'],
        datasets: [{
            label: 'AFORE',
            data: [100,200,300],
            backgroundColor: [
               'rgba(82, 122, 162, 0.6)',
               'rgba(180, 180, 180, 0.6)'
            ],
            borderColor: [
               'rgba(82, 122, 162, 1)',
               'rgba(180, 180, 180, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
*/

//Ingreso Mensual
var ctx = document.getElementById('chartIngresoMensual').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Menos de $25.000','De $25.000 A $60.000','De $60.000 A $100.000','Mas de $100.000'],
        datasets: [{
            label: 'INGRESO MENSUAL',
            data: [<?php echo $MENOSDE25000?>,<?php echo $DE25000A60000?>,<?php echo $DE6000A100000?>,<?php echo $MASDE100000?>],
            backgroundColor: [
              'rgba(82, 122, 162, 0.6)',
              'rgba(106, 90, 205, 0.6)',
              'rgba(238, 130, 238, 0.6)',
              'rgba(180, 180, 180, 0.6)'
            ],
            borderColor: [
             'rgba(82, 122, 162, 1)',
              'rgba(106, 90, 205, 1)',
              'rgba(238, 130, 238, 1)',
              'rgba(180, 180, 180, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});


//Posibilidad de acercamiento
var ctx = document.getElementById('chartPosibilidad').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Facilmente','No muy Dificil','Con Dificultad'],
        datasets: [{
            label: 'POSIBILIDAD DE ACERCAMIENTO',
            data: [<?php echo $FACILMENTE?>,<?php echo $NOMUYDIFICIL?>,<?php echo $CONDIFICULTAD?>],
            backgroundColor: [
              'rgba(82, 122, 162, 0.6)',
              'rgba(106, 90, 205, 0.6)',
              'rgba(238, 130, 238, 0.6)',
              'rgba(180, 180, 180, 0.6)'
            ],
            borderColor: [
             'rgba(82, 122, 162, 1)',
              'rgba(106, 90, 205, 1)',
              'rgba(238, 130, 238, 1)',
              'rgba(180, 180, 180, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});




</script>

 
