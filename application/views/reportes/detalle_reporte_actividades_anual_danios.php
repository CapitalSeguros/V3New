<?php
//Danios Año pasado
$year=date('Y')-1;
$mes=1;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado1=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado1=$actividadesDaniosPasado[1];
$endosoDaniosPasado1=$actividadesDaniosPasado[2];
$emisionDaniosPasado1=$actividadesDaniosPasado[3];

$mes=2;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado2=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado2=$actividadesDaniosPasado[1];
$endosoDaniosPasado2=$actividadesDaniosPasado[2];
$emisionDaniosPasado2=$actividadesDaniosPasado[3];

$mes=3;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado3=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado3=$actividadesDaniosPasado[1];
$endosoDaniosPasado3=$actividadesDaniosPasado[2];
$emisionDaniosPasado3=$actividadesDaniosPasado[3];

$mes=4;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado4=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado4=$actividadesDaniosPasado[1];
$endosoDaniosPasado4=$actividadesDaniosPasado[2];
$emisionDaniosPasado4=$actividadesDaniosPasado[3];

$mes=5;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado5=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado5=$actividadesDaniosPasado[1];
$endosoDaniosPasado5=$actividadesDaniosPasado[2];
$emisionDaniosPasado5=$actividadesDaniosPasado[3];

$mes=6;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado6=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado6=$actividadesDaniosPasado[1];
$endosoDaniosPasado6=$actividadesDaniosPasado[2];
$emisionDaniosPasado6=$actividadesDaniosPasado[3];

$mes=7;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado7=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado7=$actividadesDaniosPasado[1];
$endosoDaniosPasado7=$actividadesDaniosPasado[2];
$emisionDaniosPasado7=$actividadesDaniosPasado[3];

$mes=8;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado8=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado8=$actividadesDaniosPasado[1];
$endosoDaniosPasado8=$actividadesDaniosPasado[2];
$emisionDaniosPasado8=$actividadesDaniosPasado[3];

$mes=9;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado9=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado9=$actividadesDaniosPasado[1];
$endosoDaniosPasado9=$actividadesDaniosPasado[2];
$emisionDaniosPasado9=$actividadesDaniosPasado[3];

$mes=10;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado10=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado10=$actividadesDaniosPasado[1];
$endosoDaniosPasado10=$actividadesDaniosPasado[2];
$emisionDaniosPasado10=$actividadesDaniosPasado[3];

$mes=11;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado11=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado11=$actividadesDaniosPasado[1];
$endosoDaniosPasado11=$actividadesDaniosPasado[2];
$emisionDaniosPasado11=$actividadesDaniosPasado[3];

$mes=12;
$actividadesDaniosPasado=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDaniosPasado12=$actividadesDaniosPasado[0];
$cancelacionDaniosPasado12=$actividadesDaniosPasado[1];
$endosoDaniosPasado12=$actividadesDaniosPasado[2];
$emisionDaniosPasado12=$actividadesDaniosPasado[3];


//Danios Año Actual
$year=date('Y');
$mes=1;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios1=$actividadesDanios[0];
$cancelacionDanios1=$actividadesDanios[1];
$endosoDanios1=$actividadesDanios[2];
$emisionDanios1=$actividadesDanios[3];

$mes=2;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios2=$actividadesDanios[0];
$cancelacionDanios2=$actividadesDanios[1];
$endosoDanios2=$actividadesDanios[2];
$emisionDanios2=$actividadesDanios[3];

$mes=3;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios3=$actividadesDanios[0];
$cancelacionDanios3=$actividadesDanios[1];
$endosoDanios3=$actividadesDanios[2];
$emisionDanios3=$actividadesDanios[3];

$mes=4;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios4=$actividadesDanios[0];
$cancelacionDanios4=$actividadesDanios[1];
$endosoDanios4=$actividadesDanios[2];
$emisionDanios4=$actividadesDanios[3];

$mes=5;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios5=$actividadesDanios[0];
$cancelacionDanios5=$actividadesDanios[1];
$endosoDanios5=$actividadesDanios[2];
$emisionDanios5=$actividadesDanios[3];

$mes=6;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios6=$actividadesDanios[0];
$cancelacionDanios6=$actividadesDanios[1];
$endosoDanios6=$actividadesDanios[2];
$emisionDanios6=$actividadesDanios[3];

$mes=7;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios7=$actividadesDanios[0];
$cancelacionDanios7=$actividadesDanios[1];
$endosoDanios7=$actividadesDanios[2];
$emisionDanios7=$actividadesDanios[3];

$mes=8;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios8=$actividadesDanios[0];
$cancelacionDanios8=$actividadesDanios[1];
$endosoDanios8=$actividadesDanios[2];
$emisionDanios8=$actividadesDanios[3];

$mes=9;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios9=$actividadesDanios[0];
$cancelacionDanios9=$actividadesDanios[1];
$endosoDanios9=$actividadesDanios[2];
$emisionDanios9=$actividadesDanios[3];

$mes=10;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios10=$actividadesDanios[0];
$cancelacionDanios10=$actividadesDanios[1];
$endosoDanios10=$actividadesDanios[2];
$emisionDanios10=$actividadesDanios[3];

$mes=11;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios11=$actividadesDanios[0];
$cancelacionDanios11=$actividadesDanios[1];
$endosoDanios11=$actividadesDanios[2];
$emisionDanios11=$actividadesDanios[3];

$mes=12;
$actividadesDanios=$this->cuadromando_model->getDesgloceActividadesDanios($mes,$year);
$cotizacionDanios12=$actividadesDanios[0];
$cancelacionDanios12=$actividadesDanios[1];
$endosoDanios12=$actividadesDanios[2];
$emisionDanios12=$actividadesDanios[3];


?>

<!-- Graficos comparacion Anuales-->
<!--RAMO Danios-->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="well" style="text-align: center;padding: 5px;background-color: #361666;color: #fff;opacity: 0.4;">
            <i class="fa fa-heartbeat"></i> <b> DAÑOS</b>
        </div>
    </div>
</div>
<div class="row">
    <!-- Reporte anio pasado-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO PASADO <?php echo date('Y')-1;?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;">
                <canvas id="myChartActividadesAnioPasadoDanios"></canvas>
             </div> 
        </div> 
    </div>
    <!-- -->
    <!-- Reporte anio actual-->
    <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 12px">
                    <i class="fa fa-calendar-check-o"></i> REPORTE AÑO ACTUAL <?php echo date('Y');?><br>
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartActividadesAnioActualDanios"></canvas>
             </div> 
        </div> 
    </div>
    <!-- -->
</div>
<script type="text/javascript">
 //Grafico Actividades del Ramo Daños Año pasado
var ctx = document.getElementById('myChartActividadesAnioPasadoDanios').getContext('2d');
window.myBar = new Chart(ctx, {
type: 'bar',
data: {
labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
datasets: [
         {
            label: 'COTIZACION',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6'
            ],
            data: [<?php echo $cotizacionDaniosPasado1?>,<?php echo $cotizacionDaniosPasado2?>,<?php echo $cotizacionDaniosPasado3?>,<?php echo $cotizacionDaniosPasado4?>,<?php echo $cotizacionDaniosPasado5?>,<?php echo $cotizacionDaniosPasado6?>,<?php echo $cotizacionDaniosPasado7?>,<?php echo $cotizacionDaniosPasado8?>,<?php echo $cotizacionDaniosPasado9?>,<?php echo $cotizacionDaniosPasado10?>,<?php echo $cotizacionDaniosPasado11?>,<?php echo $cotizacionDaniosPasado12?>]
        },
        {
            label: 'CANCELACION',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6'
            ],
            data: [<?php echo $cancelacionDaniosPasado1?>,<?php echo $cancelacionDaniosPasado2?>,<?php echo $cancelacionDaniosPasado3?>,<?php echo $cancelacionDaniosPasado4?>,<?php echo $cancelacionDaniosPasado5?>,<?php echo $cancelacionDaniosPasado6?>,<?php echo $cancelacionDaniosPasado7?>,<?php echo $cancelacionDaniosPasado8?>,<?php echo $cancelacionDaniosPasado9?>,<?php echo $cancelacionDaniosPasado10?>,<?php echo $cancelacionDaniosPasado11?>,<?php echo $cancelacionDaniosPasado12?>]
        },
        {
            label: 'ENDOSO',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6'
            ],
            data: [<?php echo $endosoDaniosPasado1?>,<?php echo $endosoDaniosPasado2?>,<?php echo $endosoDaniosPasado3?>,<?php echo $endosoDaniosPasado4?>,<?php echo $endosoDaniosPasado5?>,<?php echo $endosoDaniosPasado6?>,<?php echo $endosoDaniosPasado7?>,<?php echo $endosoDaniosPasado8?>,<?php echo $endosoDaniosPasado9?>,<?php echo $endosoDaniosPasado10?>,<?php echo $endosoDaniosPasado11?>,<?php echo $endosoDaniosPasado12?>]
        }
        ,
        {
            label: 'EMISION',
            stack: 'Stack 3',
            backgroundColor: [
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6'
            ],
            data: [<?php echo $emisionDaniosPasado1?>,<?php echo $emisionDaniosPasado2?>,<?php echo $emisionDaniosPasado3?>,<?php echo $emisionDaniosPasado4?>,<?php echo $emisionDaniosPasado5?>,<?php echo $emisionDaniosPasado6?>,<?php echo $emisionDaniosPasado7?>,<?php echo $emisionDaniosPasado8?>,<?php echo $emisionDaniosPasado9?>,<?php echo $emisionDaniosPasado10?>,<?php echo $emisionDaniosPasado11?>,<?php echo $emisionDaniosPasado12?>]
        }
        ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});

//Grafico Actividades del Ramo Auto Año Actual
var ctx = document.getElementById('myChartActividadesAnioActualDanios').getContext('2d');
window.myBar = new Chart(ctx, {
type: 'bar',
data: {
labels: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
datasets: [
         {
            label: 'COTIZACION',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6'
            ],
             data: [<?php echo $cotizacionDanios1?>,<?php echo $cotizacionDanios2?>,<?php echo $cotizacionDanios3?>,<?php echo $cotizacionDanios4?>,<?php echo $cotizacionDanios5?>,<?php echo $cotizacionDanios6?>,<?php echo $cotizacionDanios7?>,<?php echo $cotizacionDanios8?>,<?php echo $cotizacionDanios9?>,<?php echo $cotizacionDanios10?>,<?php echo $cotizacionDanios11?>,<?php echo $cotizacionDanios12?>]
        },
        {
            label: 'CANCELACION',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6',
            'rgba(54, 162, 235, 0.6'
            ],
            data: [<?php echo $cancelacionDanios1?>,<?php echo $cancelacionDanios2?>,<?php echo $cancelacionDanios3?>,<?php echo $cancelacionDanios4?>,<?php echo $cancelacionDanios5?>,<?php echo $cancelacionDanios6?>,<?php echo $cancelacionDanios7?>,<?php echo $cancelacionDanios8?>,<?php echo $cancelacionDanios9?>,<?php echo $cancelacionDanios10?>,<?php echo $cancelacionDanios11?>,<?php echo $cancelacionDanios12?>]
        },
        {
            label: 'ENDOSO',
            stack: 'Stack 2',
            backgroundColor: [
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6',
            'rgba(255, 206, 86, 0.6'
            ],
            data: [<?php echo $endosoDanios1?>,<?php echo $endosoDanios2?>,<?php echo $endosoDanios3?>,<?php echo $endosoDanios4?>,<?php echo $endosoDanios5?>,<?php echo $endosoDanios6?>,<?php echo $endosoDanios7?>,<?php echo $endosoDanios8?>,<?php echo $endosoDanios9?>,<?php echo $endosoDanios10?>,<?php echo $endosoDanios11?>,<?php echo $endosoDanios12?>]
        }
        ,
        {
            label: 'EMISION',
            stack: 'Stack 3',
            backgroundColor: [
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6',
            'rgba(76, 175, 80, 0.6'
            ],
            data: [<?php echo $emisionDanios1?>,<?php echo $emisionDanios2?>,<?php echo $emisionDanios3?>,<?php echo $emisionDanios4?>,<?php echo $emisionDanios5?>,<?php echo $emisionDanios6?>,<?php echo $emisionDanios7?>,<?php echo $emisionDanios8?>,<?php echo $emisionDanios9?>,<?php echo $emisionDanios10?>,<?php echo $emisionDanios11?>,<?php echo $emisionDanios12?>]
        }
        ]
},
options: {
    plugins: {
        tooltip: {
            mode: 'index'
        }
    },
    responsive: true,
}
});

</script>
