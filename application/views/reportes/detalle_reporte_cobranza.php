<?php
  $this->load->view('headers/header');
  $this->load->view('headers/menu');
$fCorte=date("d-m-y");
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

//***Funcion Determinar Dias Feriados por Mes***

function diasferiadosMex($mes){
    $year=date('Y');
    switch ($mes) {
        case 1:return [$year."-01-01"];break;
        case 2:return [$year."-02-01"];break;
        case 3:return [$year."-03-15"];break;
        case 5:return [$year."-05-01"];break;
        case 9:return [$year."-09-16"];break;
        case 11:return [$year."-11-15"];break;
        case 12:return [$year."-12-25"];break;
        default:return [""];break;
    }
}

//***Funcion Determinar de Dias Habiles***
function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
        $diainc = 24*60*60;
        $diashabiles = array();
       for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
            if (!in_array(date('N', $midia), array(6,7))) {
                if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
                }
            }
        }
    return $diashabiles;
}


//***Funcion Determinar Fecha Final del mes actual
function fechaFinal($mes){
    $month=date('m');
    $year=date('Y');
    switch ($mes) {
        case 1:return $year.'-'.$month.'-'.'31';break;
        case 2:return $year.'-'.$month.'-'.'28';break;
        case 3:return $year.'-'.$month.'-'.'31';break;
        case 4:return $year.'-'.$month.'-'.'30';break;
        case 5:return $year.'-'.$month.'-'.'31';break;
        case 6:return $year.'-'.$month.'-'.'30';break;
        case 7:return $year.'-'.$month.'-'.'31';break;
        case 8:return $year.'-'.$month.'-'.'31';break;
        case 9:return $year.'-'.$month.'-'.'30';break;
        case 10:return $year.'-'.$month.'-'.'31';break;
        case 11:return $year.'-'.$month.'-'.'30';break;
        case 12:return $year.'-'.$month.'-'.'31';break;
    }
}


$ctDH=0;
$fechI=date('Y-m-d');
$fechF=fechaFinal(date('m'));
$diasHabiles=getDiasHabiles($fechI, $fechF, diasferiadosMex(date('m')));
foreach ($diasHabiles as $diasH) {
    $ctDH++;
}

//*** Promedio de Cobro Institucional
$ZPINST=$CPINST+$CAINST;
$PromCobroINST=$ZPINST/$ctDH;

//*** Promedio de Cobro Merida
$ZPMID=$CPMID+$CAMID;
$PromCobroMID=$ZPMID/$ctDH;

//*** Promedio de Cobro Cancun
$ZPCUN=$CPCUN+$CACUN;
$PromCobroCUN=$ZPCUN/$ctDH;



?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container">
<div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10">
        <h3 class="titulo-secciones">
        <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
        </div>
          <br>
            <i class="fa fa-list"></i> Detalles Cobranza
        </h3>
      </div>
    </div>
    <br>
    <div style="text-align: left;">
      <b><?php echo mesLetra(date('m')).", ".date('Y');?> </b>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-6 col-md-6">
        <div style="text-align: left;">
           <i class="fa fa-bar-chart"></i> Estado de Cobranza: <b>INSTITUCIONAL</b>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <i class="fa fa-bar-chart"></i> Estado de Cobranza: <b>MERIDA</b>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
          <div class="well" style="background-color: #fff;">
            <div style="text-align: left;">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                    <canvas id="myChartCobranzaInstitucional"></canvas>
                 </div>
                 <div class="alert alert-info">
                    <h5 style="color: #848484">META DE COBRO <?php echo mesLetra(date('m')).", ".date('Y');?></h5>
                    
                    <i class="fa fa-hand-o-right"></i>
                    Total Recibos por Cobrar   : <b><?php echo $ZPINST;?></b><br>

                    <i class="fa fa-calendar"></i>
                    Dias Habiles  : <b><?php echo $ctDH;?></b><br>
                    
                    <i class="fa fa-hand-o-right"></i> Promedio Sugerido de Cobro: <b><?php echo number_format($PromCobroINST)."</b> recibos diarios";?>
                </div>
            </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
          <div class="well" style="background-color: #fff;">
            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartCobranzaMerida"></canvas>
            </div>
             <div class="alert alert-info">
            <h5 style="color: #848484">META DE COBRO <?php echo mesLetra(date('m')).", ".date('Y');?></h5>

             <i class="fa fa-hand-o-right"></i>
                    Total Recibos por Cobrar   : <b><?php echo $ZPMID;?></b><br>

            <i class="fa fa-calendar"></i>
            Dias Habiles  : <b><?php echo $ctDH;?></b><br>

            <i class="fa fa-hand-o-right"></i> Promedio Sugerido de Cobro: <b><?php echo number_format($PromCobroMID)."</b> recibos diarios";?>
               </div>
           </div>
     </div>
    </div>
    <br>
     <div class="row">
      <div class="col-sm-6 col-md-6">
        <div style="text-align: left;">
           <i class="fa fa-bar-chart"></i> Estado de Cobranza: <b>CANCUN</b>
        </div>
      </div>
      <div class="col-sm-6 col-md-6"></div>
    </div>
    <div class="row">
      <div class="col-sm-6 col-md-6">
          <div class="well" style="background-color: #fff;">
            <div style="text-align: left;">
               <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartCobranzaCancun"></canvas>
            </div>
            <div class="alert alert-info">
                <h5 style="color: #848484">META DE COBRO <?php echo mesLetra(date('m')).", ".date('Y');?></h5>
                
                 <i class="fa fa-hand-o-right"></i>
                    Total Recibos por Cobrar   : <b><?php echo $ZPCUN;?></b><br>

                <i class="fa fa-calendar"></i>
                Dias Habiles  : <b><?php echo $ctDH?></b><br>
                
                <i class="fa fa-hand-o-right"></i> Promedio Sugerido de Cobro: <b><?php echo number_format($PromCobroCUN)."</b> recibos diarios";?>
             </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-md-6"></div>
    </div>
</div>

<script type="text/javascript">
//Grafico cobranza Institucional

var ctx = document.getElementById('myChartCobranzaInstitucional').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efectuada', 'Pendiente', 'Atrasada'],
        datasets: [{
            label: 'COBRANZA INSTITUCIONAL:  <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $CEINST?>,<?php echo $CPINST?>,<?php echo $CAINST?>],
            backgroundColor: [
                'rgba(21, 157, 46, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 50, 0.6)'
            ],
            borderColor: [
                'rgba(21, 157, 46, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 50, 1)'
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

//Grafico cobranza Merida

var ctx = document.getElementById('myChartCobranzaMerida').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efectuada', 'Pendiente', 'Atrasada'],
        datasets: [{
            label: 'COBRANZA MERIDA:  <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $CEMID?>,<?php echo $CPMID?>,<?php echo $CAMID?>],
            backgroundColor: [
                'rgba(21, 157, 46, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 50, 0.6)'
            ],
            borderColor: [
                'rgba(21, 157, 46, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 50, 1)'
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

//Grafico cobranza Cancun

var ctx = document.getElementById('myChartCobranzaCancun').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efectuada', 'Pendiente', 'Atrasada'],
        datasets: [{
            label: 'COBRANZA CANCUN:  <?php echo mesLetra(date('m')).', '.date('Y');?>',
            data: [<?php echo $CECUN?>,<?php echo $CPCUN?>,<?php echo $CACUN?>],
            backgroundColor: [
                'rgba(21, 157, 46, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 50, 0.6)'
            ],
            borderColor: [
                'rgba(21, 157, 46, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 50, 1)'
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
