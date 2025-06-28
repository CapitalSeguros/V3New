<?php 
  $this->load->view('headers/header'); 
  $this->load->view('headers/menu');
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
  
<?php
$ctSuspectosPersonasImportacion=0;
$ctSuspectosPersonasLeads=0;
$ctPerfiladosPersonasImportacion=0;
$ctPerfiladosPersonasLeads=0;
$ctContactadosPersonasImportacion=0;
$ctContactadosPersonasLeads=0;
$ctCotizadosPersonasImportacion=0;
$ctCotizadosPersonasLeads=0;
$ctCerradosPersonasImportacion=0;
$ctCerradosPersonasLeads=0;
$ctSuspectosGenericosImportacion=0;
$ctSuspectosGenericosLeads=0;
$ctSinVentaGenericosImportacion=0;
$ctSinVentaGenericosLeads=0;
$ctProgresoGenericosImportacion=0;
$ctProgresoGenericosLeads=0;


//******************************************
// *** Suspectos-Personas-Importacion
foreach ($suspectos_personas_importacion as $spi) {
    $ctSuspectosPersonasImportacion++;
}
// *** Suspectos-Personas-Leads
foreach ($suspectos_personas_leads as $spl) {
    $ctSuspectosPersonasLeads++;
}
// *** Perfilado-Personas-Importacion
foreach ($perfilados_personas_importacion as $ppi) {
    $ctPerfiladosPersonasImportacion++;
}
// *** Perfilado-Personas-Leads
foreach ($perfilados_personas_leads as $ppl) {
    $ctPerfiladosPersonasLeads++;
}
// *** Contactados-Personas-Importacion
foreach ($contactado_personas_importacion as $cpp) {
    $ctContactadosPersonasImportacion++;
}
// *** Contactados-Personas-Leads
foreach ($contactado_personas_leads as $cpl) {
    $ctContactadosPersonasLeads++;
}
// *** Cotizados-Personas-Importacion
foreach ($cotizado_personas_importacion as $cpi) {
    $ctCotizadosPersonasImportacion++;
}
// *** Cotizados-Personas-Leads
foreach ($cotizado_personas_leads as $cpl) {
    $ctCotizadosPersonasLeads++;
}
// *** Cerrados-Personas-Importacion
foreach ($cerrado_personas_importacion as $cpi) {
    $ctCerradosPersonasImportacion++;
}
// *** Cerrados-Personas-Leads
foreach ($cerrado_personas_leads as $cpl) {
    $ctCerradosPersonasLeads++;
}


//**********************************************+
// *** Suspectos-Genericos-Importacion
foreach ($suspectos_genericos_importacion as $sgi) {
    $ctSuspectosGenericosImportacion++;
}
// *** Suspectos-Personas-Leads
foreach ($suspectos_genericos_leads as $sgl) {
    $ctSuspectosGenericosLeads++;
}

// *** SIN VENTA-Genericos-Importacion
foreach ($sinventa_genericos_importacion as $sgi) {
    $ctSinVentaGenericosImportacion++;
}
// *** SIN VENTA-Personas-Leads
foreach ($sinventa_genericos_leads as $sgl) {
    $ctSinVentaGenericosLeads++;
}

// *** EN PROGRESO-Genericos-Importacion
foreach ($progreso_genericos_importacion as $pgi) {
    $ctProgresoGenericosImportacion++;
}
// *** EN PROGRESO-Personas-Leads
foreach ($progreso_genericos_leads as $pgl) {
    $ctProgresoGenericosLeads++;
}





//***************
$ctSuspectos_personas_directo=0;
$ctPerfilados_personas_directo=0;
$ctContactado_personas_directo=0;
$ctCotizado_personas_directo=0;
$ctCerrado_personas_directo=0;


foreach ($suspectos_personas_directo as $row) {
    $ctSuspectos_personas_directo++;
}

foreach ($perfilados_personas_directo as $row) {
    $ctPerfilados_personas_directo++;
}

foreach ($contactado_personas_directo as $row) {
    $ctContactado_personas_directo++;
}

foreach ($cotizado_personas_directo as $row) {
    $ctCotizado_personas_directo++;
}

foreach ($cerrado_personas_directo as $row) {
    $ctCerrado_personas_directo++;
}

$ctSuspectos_genericos_directo=0;
$ctSinventa_genericos_directo=0;
$ctProgreso_genericos_directo=0;

foreach ($suspectos_genericos_directo as $row) {
    $ctSuspectos_genericos_directo++;
}

foreach ($sinventa_genericos_directo as $row) {
    $ctSinventa_genericos_directo++;
}

foreach ($progreso_genericos_directo as $row) {
    $ctProgreso_genericos_directo++;
}








function mesLetra($mes){
    switch ($mes) {
        case 1:return 'ENERO';break;
        case 2:return 'FEBRERO';break;
        case 3:return 'MARZO';break;
        case 4:return 'ABRIL';break;
        case 5:return 'MAYO';break;
        case 6:return 'JUNIO';break;
        case 7:return 'JULIO';break;
        case 8:return 'AGOSTO';break;
        case 9:return 'SEPTIEMBRE';break;
        case 10:return 'OCTUBRE';break;
        case 11:return 'NOVIEMBRE';break;
        case 12:return 'DICIEMBRE';break;
    }
}

?>


  <div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10">
        <h3 class="titulo-secciones">
          <br>
            <i class="fa fa-list"></i> Detalles de Prospección de Negocios
        </h3>
      </div>
    </div>
    <br>
    <div style="text-align: left;">
      <h5><b><?php echo mesLetra(date('m'))." ,".date('Y');?> </b></h5>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
       <table style="width: 100%;text-align: center;">
         
       </table>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div style="text-align: left;">
          <h4><b><i class="fa fa-download"></i><?php echo "  Prospectos Via Importación Masiva";?></b>
          </h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartPersonaImportacion"></canvas>
            </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
       <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
            <div class="well" style="background-color: #fff;">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                    <canvas id="myChartGenericoImportacion"></canvas>
                </div>
            </div>
        </div>
      </div>
    </div>

     <br>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div style="text-align: left;">
          <h4><b><i class="fa fa-download"></i><?php echo "  Prospectos Via Leads";?></b>
          </h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
            <div class="well" style="background-color: #fff;">
                 <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                    <canvas id="myChartPersonaLeads"></canvas>
                 </div>
            </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartGenericoLeads"></canvas>
            </div>
        </div>
      </div>
    </div>


<br>

<div class="row">
      <div class="col-sm-6 col-md-6">
        <div style="text-align: left;">
          <h4><b><i class="fa fa-download"></i><?php echo "  Prospectos Via Directa";?></b>
          </h4>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
            <div class="well" style="background-color: #fff;">
                 <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                    <canvas id="myChartPersonaDirecto"></canvas>
                 </div>
            </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartGenericoDirecto"></canvas>
            </div>
        </div>
      </div>
    </div>

</div>


<br><br><br>







<script type="text/javascript">


var ctx = document.getElementById('myChartPersonaDirecto').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'PERFILADOS', 'CONTACTADOS', 'COTIZADOS','CERRADOS'],
        datasets: [{
            label: 'PERSONAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectos_personas_directo?>,<?php echo $ctPerfilados_personas_directo?>,<?php echo $ctContactado_personas_directo?>,<?php echo $ctCotizado_personas_directo?>,<?php echo $ctCerrado_personas_directo?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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





var ctx = document.getElementById('myChartPersonaImportacion').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'PERFILADOS', 'CONTACTADOS', 'COTIZADOS','CERRADOS'],
        datasets: [{
            label: 'PERSONAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectosPersonasImportacion?>,<?php echo $ctPerfiladosPersonasImportacion?>,<?php echo $ctContactadosPersonasImportacion?>,<?php echo $ctCotizadosPersonasImportacion?>,<?php echo $ctCerradosPersonasImportacion?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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

var ctx = document.getElementById('myChartPersonaLeads').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'PERFILADOS', 'CONTACTADOS', 'COTIZADOS','CERRADOS'],
        datasets: [{
            label: 'PERSONAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectosPersonasLeads?>,<?php echo $ctPerfiladosPersonasLeads?>,<?php echo $ctContactadosPersonasImportacion?>,<?php echo $ctCotizadosPersonasImportacion?>,<?php echo $ctCerradosPersonasImportacion?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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


var ctx = document.getElementById('myChartGenericoLeads').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'SIN VENTA', 'EN PROGRESO'],
        datasets: [{
            label: 'FIANZAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectosGenericosLeads?>,<?php echo $ctSinVentaGenericosLeads?>,<?php echo $ctProgresoGenericosLeads?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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

var ctx = document.getElementById('myChartGenericoImportacion').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'SIN VENTA', 'EN PROGRESO'],
        datasets: [{
            label: 'FIANZAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectosGenericosImportacion?>,<?php echo $ctSinVentaGenericosImportacion?>,<?php echo $ctProgresoGenericosImportacion?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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



var ctx = document.getElementById('myChartGenericoDirecto').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['SUSPECTOS', 'SIN VENTA', 'EN PROGRESO'],
        datasets: [{
            label: 'FIANZAS: <?php echo mesLetra(date('m'))." ,".date('Y');?>',
            data: [<?php echo $ctSuspectos_genericos_directo?>,<?php echo $ctSinventa_genericos_directo?>,<?php echo $ctProgreso_genericos_directo?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
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
