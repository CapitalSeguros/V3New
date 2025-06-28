
<?php 
$this->load->view('headers/header'); 
$this->load->view('headers/menu');
$ctCapacitacion=0;
$ctCapacitacionMensual=0;
if( (isset($_REQUEST['mes']))&& (isset($_REQUEST['year'])) ) {
    $mes=$_REQUEST['mes'];
    $year=$_REQUEST['year'];
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


foreach($capacitacion as $row){
    if(($row->mes==$mes)&&($row->anio==$year)){
        $ctCapacitacion++;
    }
}


foreach($capacitacionMensual as $row){
    if($row->anio==$year){
        $ctCapacitacionMensual++;
    }
}


?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
<input type="hidden" id="base" value="<?php echo base_url()?>">
<!--Grafico Autos-->
<div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h4 class="titulo-secciones">
        <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
        </div>
          <br><br>
            <i class="fa fa-search"></i> Consulta Fast File
        </h4>
      </div>
</div>

<div class="row">
      <div class="col-md-3 col-sm-3 col-xs-3">
        <select id="mes" name="mes" class="form-control" onchange="getSearch(this,'<?php echo date('Y')?>')">
            <option value="0"></option>
            <option value="1">ENERO</option>
            <option value="2">FEBRERO</option>
            <option value="3">MARZO</option>
            <option value="4">ABRIL</option>
            <option value="5">MAYO</option>
            <option value="6">JUNIO</option>
            <option value="7">JULIO</option>
            <option value="8">AGOSTO</option>
            <option value="9">SEPTIEMBRE</option>
            <option value="10">OCTUBRE</option>
            <option value="11">NOVIEMBRE</option>
            <option value="12">DICIEMBRE</option>
        </select>
      </div>
     
</div>

    <br>

<div class="row">
       <div class="col-md-12 col-lg-12">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Fast File <?php echo mesLetra($mes).", ".$year;?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartFastFile"></canvas>
                     </div>
                </div>
                <div class="well" style="background-color: #fff;width: 50%;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">VALOR</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;Puntualidad</td>
                                 <td style="text-align: center;"><?php echo $puntualidad[0]->TOTAL;?></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;Prestamos</td>
                                 <td style="text-align: center;"><?php echo $prestamos[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Vacaciones</td>
                                 <td style="text-align: center;"><?php echo $vacaciones[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Permisos</td>
                                 <td style="text-align: center;"><?php echo $permisos[0]->TOTAL;?></td>
                             </tr> 
                              <tr>
                                 <td>&nbsp;Incapacidades</td>
                                 <td style="text-align: center;"><?php echo $incapacidad[0]->TOTAL;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Cambio Puesto</td>
                                 <td style="text-align: center;"><?php echo $cambio_puesto[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Ajuste Sueldo</td>
                                 <td style="text-align: center;"><?php echo $sueldo[0]->TOTAL;?></td>
                                
                             </tr>
                              <tr>
                                 <td>&nbsp;Calificación</td>
                                <td style="text-align: center;"><?php echo $calificacion[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Capacitación</td>
                                 <td style="text-align: center;"><?php echo $ctCapacitacion;?></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                </div>
            </div>
 </div>
 <!--
 <div class="row">
            <div class="col-md-6 col-lg-6">
                 <div class="well">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Puntualidad
                        </div>
                        <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                            <canvas id="myChartPuntualidad"></canvas>
                         </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                 <div class="well">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Prestamos
                        </div>
                        <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                            <canvas id="myChartPrestamos"></canvas>
                         </div>
                    </div>
                </div>
            </div>
 </div>
  
  <div class="row">
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Vacaciones
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartVacaciones"></canvas>
                     </div>
                </div>
            </div>
         </div>
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Permisos
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartPermisos"></canvas>
                     </div>
                </div>
            </div>
        </div>
 </div>


  <div class="row">
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Cambio de Puesto
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartCambioPuesto"></canvas>
                     </div>
                </div>
            </div>
         </div>
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Ajuste de Sueldo
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartSueldo"></canvas>
                     </div>
                </div>
            </div>
        </div>
 </div>



  <div class="row">
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Calificación o Evaluaciones
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartCalificacion"></canvas>
                     </div>
                </div>
            </div>
         </div>
        <div class="col-md-6 col-lg-6">
             <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Capacitación
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartCapacitacion"></canvas>
                     </div>
                </div>
            </div>
        </div>
 </div>

-->

<div class="row">
       <div class="col-md-12 col-lg-12">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Acumulado Global de Fast File <?php echo mesLetra(01)." - ".mesLetra($mes).", ".$year;?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartFastGlobal"></canvas>
                     </div>
                </div>
                <div class="well" style="background-color: #fff;width: 50%;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">VALOR</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;Puntualidad</td>
                                 <td style="text-align: center;"><?php echo $puntualidadMensual[0]->TOTAL;?></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;Prestamos</td>
                                 <td style="text-align: center;"><?php echo $prestamosMensual[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Vacaciones</td>
                                 <td style="text-align: center;"><?php echo $vacacionesMensual[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Permisos</td>
                                 <td style="text-align: center;"><?php echo $permisosMensual[0]->TOTAL;?></td>
                             </tr> 
                              <tr>
                                 <td>&nbsp;Incapacidades</td>
                                 <td style="text-align: center;"><?php echo $incapacidadMensual[0]->TOTAL;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Cambio Puesto</td>
                                 <td style="text-align: center;"><?php echo 
                                 $cambio_puestoMensual[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Ajuste Sueldo</td>
                                 <td style="text-align: center;"><?php echo $sueldoMensual[0]->TOTAL;?></td>
                                
                             </tr>
                              <tr>
                                 <td>&nbsp;Calificación</td>
                                <td style="text-align: center;"><?php echo $calificacionMensual[0]->TOTAL;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Capacitación</td>
                                 <td style="text-align: center;"><?php echo $ctCapacitacionMensual;?></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                </div>
            </div>
 </div>
 
<!-- Fin Container-->
</div>



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script type="text/javascript">



var ctx = document.getElementById('myChartFastGlobal').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Puntualidad', 'Prestamos', 'Vacaciones', 'Permisos', 'Incapacidades','Cambio Puesto','Ajuste Sueldo','Calificacion','Capacitaciones'],
        datasets: [{
            label: 'FAST FILE: <?php echo mesLetra(01)." - ".mesLetra($mes).', '.$year;?>',
            data: [<?php echo $puntualidadMensual[0]->TOTAL;?>,<?php echo $prestamosMensual[0]->TOTAL;?>,<?php echo $vacacionesMensual[0]->TOTAL;?>,<?php echo $permisosMensual[0]->TOTAL;?>,<?php echo $incapacidadMensual[0]->TOTAL;?>,<?php echo $sueldoMensual[0]->TOTAL;?>,<?php echo $cambio_puestoMensual[0]->TOTAL;?>,<?php echo $calificacionMensual[0]->TOTAL;?>,<?php echo $ctCapacitacionMensual;?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(155, 231, 23, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(155, 231, 23, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(155, 231, 23, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(155, 231, 23, 1)'
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


var ctx = document.getElementById('myChartFastFile').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Puntualidad', 'Prestamos', 'Vacaciones', 'Permisos','Incapacidades','Cambio Puesto','Ajuste Sueldo','Calificacion','Capacitaciones'],
        datasets: [{
            label: 'FAST FILE: <?php echo mesLetra($mes).', '.$year;?>',
            data: [<?php echo $puntualidad[0]->TOTAL;?>,<?php echo $prestamos[0]->TOTAL;?>,<?php echo $vacaciones[0]->TOTAL;?>,<?php echo $permisos[0]->TOTAL;?>,<?php echo $incapacidad[0]->TOTAL;?>,<?php echo $sueldo[0]->TOTAL;?>,<?php echo $cambio_puesto[0]->TOTAL;?>,<?php echo $calificacion[0]->TOTAL;?>,<?php echo $ctCapacitacion;?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(155, 231, 23, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(155, 231, 23, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(155, 231, 23, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(155, 231, 23, 1)'
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


/*
var ctx = document.getElementById('myChartPuntualidad').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Puntualidad',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $puntualidad[0]->TOTAL;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});


var ctx = document.getElementById('myChartPrestamos').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Prestamos',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $prestamos[0]->TOTAL;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(54, 162, 235, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});


var ctx = document.getElementById('myChartVacaciones').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Vacaciones',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $vacaciones[0]->TOTAL;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(255, 206, 86, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});



var ctx = document.getElementById('myChartPermisos').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Permisos',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $permisos[0]->TOTAL;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(75, 192, 192, 0.6)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});



var ctx = document.getElementById('myChartCambioPuesto').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Cambio de Puesto',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $cambio_puesto[0]->TOTAL;?>,<?php echo $todos;?>],
            backgroundColor: [
              'rgba(155, 231, 23, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});



var ctx = document.getElementById('myChartSueldo').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Ajuste de Sueldo',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $sueldo[0]->TOTAL;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(153, 102, 255, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});



var ctx = document.getElementById('myChartCalificacion').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Calificacion o Evaluaciones',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $calificacion[0]->TOTAL;?>,<?php echo $todos;?>],
            backgroundColor: [
              'rgba(255, 206, 86, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});



var ctx = document.getElementById('myChartCapacitacion').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
            'Capacitaciones',
            'Total Colaboradores'
            ],
         datasets: [{
            label: 'My First Dataset',
            data: [<?php echo $ctCapacitacion;?>, <?php echo $todos;?>],
            backgroundColor: [
              'rgba(155, 231, 23, 1)',
              'rgba(220,220,220)'
            ],
            hoverOffset: 4
            }]
    },
   
});

*/




function getSearch(mes,year){
    var URL=document.getElementById('base').value;  
    URL=URL+"reportes/detalle_reporte_fastfile?mes="+mes.value+"&year="+year;
    document.location.href=URL;
}


</script>
