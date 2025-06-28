<?php
//Autos Año pasado
$year=date('Y')-1;
$mes=1;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado1=$actividadesAutosPasado[0];
$cancelacionAutosPasado1=$actividadesAutosPasado[1];
$endosoAutosPasado1=$actividadesAutosPasado[2];
$emisionAutosPasado1=$actividadesAutosPasado[3];

$mes=2;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado2=$actividadesAutosPasado[0];
$cancelacionAutosPasado2=$actividadesAutosPasado[1];
$endosoAutosPasado2=$actividadesAutosPasado[2];
$emisionAutosPasado2=$actividadesAutosPasado[3];

$mes=3;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado3=$actividadesAutosPasado[0];
$cancelacionAutosPasado3=$actividadesAutosPasado[1];
$endosoAutosPasado3=$actividadesAutosPasado[2];
$emisionAutosPasado3=$actividadesAutosPasado[3];

$mes=4;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado4=$actividadesAutosPasado[0];
$cancelacionAutosPasado4=$actividadesAutosPasado[1];
$endosoAutosPasado4=$actividadesAutosPasado[2];
$emisionAutosPasado4=$actividadesAutosPasado[3];

$mes=5;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado5=$actividadesAutosPasado[0];
$cancelacionAutosPasado5=$actividadesAutosPasado[1];
$endosoAutosPasado5=$actividadesAutosPasado[2];
$emisionAutosPasado5=$actividadesAutosPasado[3];

$mes=6;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado6=$actividadesAutosPasado[0];
$cancelacionAutosPasado6=$actividadesAutosPasado[1];
$endosoAutosPasado6=$actividadesAutosPasado[2];
$emisionAutosPasado6=$actividadesAutosPasado[3];

$mes=7;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado7=$actividadesAutosPasado[0];
$cancelacionAutosPasado7=$actividadesAutosPasado[1];
$endosoAutosPasado7=$actividadesAutosPasado[2];
$emisionAutosPasado7=$actividadesAutosPasado[3];

$mes=8;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado8=$actividadesAutosPasado[0];
$cancelacionAutosPasado8=$actividadesAutosPasado[1];
$endosoAutosPasado8=$actividadesAutosPasado[2];
$emisionAutosPasado8=$actividadesAutosPasado[3];

$mes=9;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado9=$actividadesAutosPasado[0];
$cancelacionAutosPasado9=$actividadesAutosPasado[1];
$endosoAutosPasado9=$actividadesAutosPasado[2];
$emisionAutosPasado9=$actividadesAutosPasado[3];

$mes=10;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado10=$actividadesAutosPasado[0];
$cancelacionAutosPasado10=$actividadesAutosPasado[1];
$endosoAutosPasado10=$actividadesAutosPasado[2];
$emisionAutosPasado10=$actividadesAutosPasado[3];

$mes=11;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado11=$actividadesAutosPasado[0];
$cancelacionAutosPasado11=$actividadesAutosPasado[1];
$endosoAutosPasado11=$actividadesAutosPasado[2];
$emisionAutosPasado11=$actividadesAutosPasado[3];

$mes=12;
$actividadesAutosPasado=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutosPasado12=$actividadesAutosPasado[0];
$cancelacionAutosPasado12=$actividadesAutosPasado[1];
$endosoAutosPasado12=$actividadesAutosPasado[2];
$emisionAutosPasado12=$actividadesAutosPasado[3];


//Autos Año Actual
$year=date('Y');
$mes=1;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos1=$actividadesAutos[0];
$cancelacionAutos1=$actividadesAutos[1];
$endosoAutos1=$actividadesAutos[2];
$emisionAutos1=$actividadesAutos[3];

$mes=2;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos2=$actividadesAutos[0];
$cancelacionAutos2=$actividadesAutos[1];
$endosoAutos2=$actividadesAutos[2];
$emisionAutos2=$actividadesAutos[3];

$mes=3;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos3=$actividadesAutos[0];
$cancelacionAutos3=$actividadesAutos[1];
$endosoAutos3=$actividadesAutos[2];
$emisionAutos3=$actividadesAutos[3];

$mes=4;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos4=$actividadesAutos[0];
$cancelacionAutos4=$actividadesAutos[1];
$endosoAutos4=$actividadesAutos[2];
$emisionAutos4=$actividadesAutos[3];

$mes=5;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos5=$actividadesAutos[0];
$cancelacionAutos5=$actividadesAutos[1];
$endosoAutos5=$actividadesAutos[2];
$emisionAutos5=$actividadesAutos[3];

$mes=6;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos6=$actividadesAutos[0];
$cancelacionAutos6=$actividadesAutos[1];
$endosoAutos6=$actividadesAutos[2];
$emisionAutos6=$actividadesAutos[3];

$mes=7;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos7=$actividadesAutos[0];
$cancelacionAutos7=$actividadesAutos[1];
$endosoAutos7=$actividadesAutos[2];
$emisionAutos7=$actividadesAutos[3];

$mes=8;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos8=$actividadesAutos[0];
$cancelacionAutos8=$actividadesAutos[1];
$endosoAutos8=$actividadesAutos[2];
$emisionAutos8=$actividadesAutos[3];

$mes=9;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos9=$actividadesAutos[0];
$cancelacionAutos9=$actividadesAutos[1];
$endosoAutos9=$actividadesAutos[2];
$emisionAutos9=$actividadesAutos[3];

$mes=10;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos10=$actividadesAutos[0];
$cancelacionAutos10=$actividadesAutos[1];
$endosoAutos10=$actividadesAutos[2];
$emisionAutos10=$actividadesAutos[3];

$mes=11;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos11=$actividadesAutos[0];
$cancelacionAutos11=$actividadesAutos[1];
$endosoAutos11=$actividadesAutos[2];
$emisionAutos11=$actividadesAutos[3];

$mes=12;
$actividadesAutos=$this->cuadromando_model->getDesgloceActividadesAutos($mes,$year);
$cotizacionAutos12=$actividadesAutos[0];
$cancelacionAutos12=$actividadesAutos[1];
$endosoAutos12=$actividadesAutos[2];
$emisionAutos12=$actividadesAutos[3];


?>

<!-- Graficos comparacion Anuales-->
<!--RAMO AUTOS-->
<hr style="border-color: solid;border-width: 2px;">
<div class="row">
  <div class="col-md-10 col-sm-10 col-xs-10">
    <h4 class="titulo-secciones">
        <i class="fa fa-area-chart"></i>Grafico de Comportamiento de Actividades Anuales
    </h4>
    <br>
  </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="well" style="text-align:center;padding: 5px;background-color: #361666;color: #fff;text-align: center;opacity: 0.4;">
            <i class="fa fa-car"></i><b> AUTOS</b>
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
                <canvas id="myChartActividadesAnioPasadoAutos"></canvas>
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
                <canvas id="myChartActividadesAnioActualAutos"></canvas>
             </div> 
        </div> 
    </div>
    <!-- -->
</div>
<script type="text/javascript">
 //Grafico Actividades del Ramo Auto Año pasado
var ctx = document.getElementById('myChartActividadesAnioPasadoAutos').getContext('2d');
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
            data: [<?php echo $cotizacionAutosPasado1?>,<?php echo $cotizacionAutosPasado2?>,<?php echo $cotizacionAutosPasado3?>,<?php echo $cotizacionAutosPasado4?>,<?php echo $cotizacionAutosPasado5?>,<?php echo $cotizacionAutosPasado6?>,<?php echo $cotizacionAutosPasado7?>,<?php echo $cotizacionAutosPasado8?>,<?php echo $cotizacionAutosPasado9?>,<?php echo $cotizacionAutosPasado10?>,<?php echo $cotizacionAutosPasado11?>,<?php echo $cotizacionAutosPasado12?>]
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
            data: [<?php echo $cancelacionAutosPasado1?>,<?php echo $cancelacionAutosPasado2?>,<?php echo $cancelacionAutosPasado3?>,<?php echo $cancelacionAutosPasado4?>,<?php echo $cancelacionAutosPasado5?>,<?php echo $cancelacionAutosPasado6?>,<?php echo $cancelacionAutosPasado7?>,<?php echo $cancelacionAutosPasado8?>,<?php echo $cancelacionAutosPasado9?>,<?php echo $cancelacionAutosPasado10?>,<?php echo $cancelacionAutosPasado11?>,<?php echo $cancelacionAutosPasado12?>]
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
            data: [<?php echo $endosoAutosPasado1?>,<?php echo $endosoAutosPasado2?>,<?php echo $endosoAutosPasado3?>,<?php echo $endosoAutosPasado4?>,<?php echo $endosoAutosPasado5?>,<?php echo $endosoAutosPasado6?>,<?php echo $endosoAutosPasado7?>,<?php echo $endosoAutosPasado8?>,<?php echo $endosoAutosPasado9?>,<?php echo $endosoAutosPasado10?>,<?php echo $endosoAutosPasado11?>,<?php echo $endosoAutosPasado12?>]
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
            data: [<?php echo $emisionAutosPasado1?>,<?php echo $emisionAutosPasado2?>,<?php echo $emisionAutosPasado3?>,<?php echo $emisionAutosPasado4?>,<?php echo $emisionAutosPasado5?>,<?php echo $emisionAutosPasado6?>,<?php echo $emisionAutosPasado7?>,<?php echo $emisionAutosPasado8?>,<?php echo $emisionAutosPasado9?>,<?php echo $emisionAutosPasado10?>,<?php echo $emisionAutosPasado11?>,<?php echo $emisionAutosPasado12?>]
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
var ctx = document.getElementById('myChartActividadesAnioActualAutos').getContext('2d');
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
            data: [<?php echo $cotizacionAutos1?>,<?php echo $cotizacionAutos2?>,<?php echo $cotizacionAutos3?>,<?php echo $cotizacionAutos4?>,<?php echo $cotizacionAutos5?>,<?php echo $cotizacionAutos6?>,<?php echo $cotizacionAutos7?>,<?php echo $cotizacionAutos8?>,<?php echo $cotizacionAutos9?>,<?php echo $cotizacionAutos10?>,<?php echo $cotizacionAutos11?>,<?php echo $cotizacionAutos12?>]
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
            data: [<?php echo $cancelacionAutos1?>,<?php echo $cancelacionAutos2?>,<?php echo $cancelacionAutos3?>,<?php echo $cancelacionAutos4?>,<?php echo $cancelacionAutos5?>,<?php echo $cancelacionAutos6?>,<?php echo $cancelacionAutos7?>,<?php echo $cancelacionAutos8?>,<?php echo $cancelacionAutos9?>,<?php echo $cancelacionAutos10?>,<?php echo $cancelacionAutos11?>,<?php echo $cancelacionAutos12?>]
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
            data: [<?php echo $endosoAutos1?>,<?php echo $endosoAutos2?>,<?php echo $endosoAutos3?>,<?php echo $endosoAutos4?>,<?php echo $endosoAutos5?>,<?php echo $endosoAutos6?>,<?php echo $endosoAutos7?>,<?php echo $endosoAutos8?>,<?php echo $endosoAutos9?>,<?php echo $endosoAutos10?>,<?php echo $endosoAutos11?>,<?php echo $endosoAutos12?>]
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
            data: [<?php echo $emisionAutos1?>,<?php echo $emisionAutos2?>,<?php echo $emisionAutos3?>,<?php echo $emisionAutos4?>,<?php echo $emisionAutos5?>,<?php echo $emisionAutos6?>,<?php echo $emisionAutos7?>,<?php echo $emisionAutos8?>,<?php echo $emisionAutos9?>,<?php echo $emisionAutos10?>,<?php echo $emisionAutos11?>,<?php echo $emisionAutos12?>]
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
