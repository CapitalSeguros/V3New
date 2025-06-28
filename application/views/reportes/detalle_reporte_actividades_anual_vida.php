<?php
//Vidas Año pasado
$year=date('Y')-1;
$mes=1;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado1=$actividadesVidasPasado[0];
$cancelacionVidasPasado1=$actividadesVidasPasado[1];
$endosoVidasPasado1=$actividadesVidasPasado[2];
$emisionVidasPasado1=$actividadesVidasPasado[3];

$mes=2;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado2=$actividadesVidasPasado[0];
$cancelacionVidasPasado2=$actividadesVidasPasado[1];
$endosoVidasPasado2=$actividadesVidasPasado[2];
$emisionVidasPasado2=$actividadesVidasPasado[3];

$mes=3;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado3=$actividadesVidasPasado[0];
$cancelacionVidasPasado3=$actividadesVidasPasado[1];
$endosoVidasPasado3=$actividadesVidasPasado[2];
$emisionVidasPasado3=$actividadesVidasPasado[3];

$mes=4;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado4=$actividadesVidasPasado[0];
$cancelacionVidasPasado4=$actividadesVidasPasado[1];
$endosoVidasPasado4=$actividadesVidasPasado[2];
$emisionVidasPasado4=$actividadesVidasPasado[3];

$mes=5;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado5=$actividadesVidasPasado[0];
$cancelacionVidasPasado5=$actividadesVidasPasado[1];
$endosoVidasPasado5=$actividadesVidasPasado[2];
$emisionVidasPasado5=$actividadesVidasPasado[3];

$mes=6;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado6=$actividadesVidasPasado[0];
$cancelacionVidasPasado6=$actividadesVidasPasado[1];
$endosoVidasPasado6=$actividadesVidasPasado[2];
$emisionVidasPasado6=$actividadesVidasPasado[3];

$mes=7;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado7=$actividadesVidasPasado[0];
$cancelacionVidasPasado7=$actividadesVidasPasado[1];
$endosoVidasPasado7=$actividadesVidasPasado[2];
$emisionVidasPasado7=$actividadesVidasPasado[3];

$mes=8;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado8=$actividadesVidasPasado[0];
$cancelacionVidasPasado8=$actividadesVidasPasado[1];
$endosoVidasPasado8=$actividadesVidasPasado[2];
$emisionVidasPasado8=$actividadesVidasPasado[3];

$mes=9;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado9=$actividadesVidasPasado[0];
$cancelacionVidasPasado9=$actividadesVidasPasado[1];
$endosoVidasPasado9=$actividadesVidasPasado[2];
$emisionVidasPasado9=$actividadesVidasPasado[3];

$mes=10;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado10=$actividadesVidasPasado[0];
$cancelacionVidasPasado10=$actividadesVidasPasado[1];
$endosoVidasPasado10=$actividadesVidasPasado[2];
$emisionVidasPasado10=$actividadesVidasPasado[3];

$mes=11;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado11=$actividadesVidasPasado[0];
$cancelacionVidasPasado11=$actividadesVidasPasado[1];
$endosoVidasPasado11=$actividadesVidasPasado[2];
$emisionVidasPasado11=$actividadesVidasPasado[3];

$mes=12;
$actividadesVidasPasado=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidasPasado12=$actividadesVidasPasado[0];
$cancelacionVidasPasado12=$actividadesVidasPasado[1];
$endosoVidasPasado12=$actividadesVidasPasado[2];
$emisionVidasPasado12=$actividadesVidasPasado[3];


//Vidas Año Actual
$year=date('Y');
$mes=1;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas1=$actividadesVidas[0];
$cancelacionVidas1=$actividadesVidas[1];
$endosoVidas1=$actividadesVidas[2];
$emisionVidas1=$actividadesVidas[3];

$mes=2;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas2=$actividadesVidas[0];
$cancelacionVidas2=$actividadesVidas[1];
$endosoVidas2=$actividadesVidas[2];
$emisionVidas2=$actividadesVidas[3];

$mes=3;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas3=$actividadesVidas[0];
$cancelacionVidas3=$actividadesVidas[1];
$endosoVidas3=$actividadesVidas[2];
$emisionVidas3=$actividadesVidas[3];

$mes=4;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas4=$actividadesVidas[0];
$cancelacionVidas4=$actividadesVidas[1];
$endosoVidas4=$actividadesVidas[2];
$emisionVidas4=$actividadesVidas[3];

$mes=5;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas5=$actividadesVidas[0];
$cancelacionVidas5=$actividadesVidas[1];
$endosoVidas5=$actividadesVidas[2];
$emisionVidas5=$actividadesVidas[3];

$mes=6;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas6=$actividadesVidas[0];
$cancelacionVidas6=$actividadesVidas[1];
$endosoVidas6=$actividadesVidas[2];
$emisionVidas6=$actividadesVidas[3];

$mes=7;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas7=$actividadesVidas[0];
$cancelacionVidas7=$actividadesVidas[1];
$endosoVidas7=$actividadesVidas[2];
$emisionVidas7=$actividadesVidas[3];

$mes=8;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas8=$actividadesVidas[0];
$cancelacionVidas8=$actividadesVidas[1];
$endosoVidas8=$actividadesVidas[2];
$emisionVidas8=$actividadesVidas[3];

$mes=9;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas9=$actividadesVidas[0];
$cancelacionVidas9=$actividadesVidas[1];
$endosoVidas9=$actividadesVidas[2];
$emisionVidas9=$actividadesVidas[3];

$mes=10;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas10=$actividadesVidas[0];
$cancelacionVidas10=$actividadesVidas[1];
$endosoVidas10=$actividadesVidas[2];
$emisionVidas10=$actividadesVidas[3];

$mes=11;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas11=$actividadesVidas[0];
$cancelacionVidas11=$actividadesVidas[1];
$endosoVidas11=$actividadesVidas[2];
$emisionVidas11=$actividadesVidas[3];

$mes=12;
$actividadesVidas=$this->cuadromando_model->getDesgloceActividadesVidas($mes,$year);
$cotizacionVidas12=$actividadesVidas[0];
$cancelacionVidas12=$actividadesVidas[1];
$endosoVidas12=$actividadesVidas[2];
$emisionVidas12=$actividadesVidas[3];


?>

<!-- Graficos comparacion Anuales-->
<!--RAMO Vidas-->
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="well" style="padding: 5px;background-color: #361666;color: #fff;text-align: center;opacity: 0.4;">
            <i class="fa fa-user"></i> <b> LINEAS PERSONALES</b>
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
                <canvas id="myChartActividadesAnioPasadoVidas"></canvas>
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
                <canvas id="myChartActividadesAnioActualVidas"></canvas>
             </div> 
        </div> 
    </div>
    <!-- -->
</div>
<script type="text/javascript">
 //Grafico Actividades del Ramo Vida Año pasado
var ctx = document.getElementById('myChartActividadesAnioPasadoVidas').getContext('2d');
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
            data: [<?php echo $cotizacionVidasPasado1?>,<?php echo $cotizacionVidasPasado2?>,<?php echo $cotizacionVidasPasado3?>,<?php echo $cotizacionVidasPasado4?>,<?php echo $cotizacionVidasPasado5?>,<?php echo $cotizacionVidasPasado6?>,<?php echo $cotizacionVidasPasado7?>,<?php echo $cotizacionVidasPasado8?>,<?php echo $cotizacionVidasPasado9?>,<?php echo $cotizacionVidasPasado10?>,<?php echo $cotizacionVidasPasado11?>,<?php echo $cotizacionVidasPasado12?>]
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
            data: [<?php echo $cancelacionVidasPasado1?>,<?php echo $cancelacionVidasPasado2?>,<?php echo $cancelacionVidasPasado3?>,<?php echo $cancelacionVidasPasado4?>,<?php echo $cancelacionVidasPasado5?>,<?php echo $cancelacionVidasPasado6?>,<?php echo $cancelacionVidasPasado7?>,<?php echo $cancelacionVidasPasado8?>,<?php echo $cancelacionVidasPasado9?>,<?php echo $cancelacionVidasPasado10?>,<?php echo $cancelacionVidasPasado11?>,<?php echo $cancelacionVidasPasado12?>]
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
            data: [<?php echo $endosoVidasPasado1?>,<?php echo $endosoVidasPasado2?>,<?php echo $endosoVidasPasado3?>,<?php echo $endosoVidasPasado4?>,<?php echo $endosoVidasPasado5?>,<?php echo $endosoVidasPasado6?>,<?php echo $endosoVidasPasado7?>,<?php echo $endosoVidasPasado8?>,<?php echo $endosoVidasPasado9?>,<?php echo $endosoVidasPasado10?>,<?php echo $endosoVidasPasado11?>,<?php echo $endosoVidasPasado12?>]
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
            data: [<?php echo $emisionVidasPasado1?>,<?php echo $emisionVidasPasado2?>,<?php echo $emisionVidasPasado3?>,<?php echo $emisionVidasPasado4?>,<?php echo $emisionVidasPasado5?>,<?php echo $emisionVidasPasado6?>,<?php echo $emisionVidasPasado7?>,<?php echo $emisionVidasPasado8?>,<?php echo $emisionVidasPasado9?>,<?php echo $emisionVidasPasado10?>,<?php echo $emisionVidasPasado11?>,<?php echo $emisionVidasPasado12?>]
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
var ctx = document.getElementById('myChartActividadesAnioActualVidas').getContext('2d');
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
             data: [<?php echo $cotizacionVidas1?>,<?php echo $cotizacionVidas2?>,<?php echo $cotizacionVidas3?>,<?php echo $cotizacionVidas4?>,<?php echo $cotizacionVidas5?>,<?php echo $cotizacionVidas6?>,<?php echo $cotizacionVidas7?>,<?php echo $cotizacionVidas8?>,<?php echo $cotizacionVidas9?>,<?php echo $cotizacionVidas10?>,<?php echo $cotizacionVidas11?>,<?php echo $cotizacionVidas12?>]
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
            data: [<?php echo $cancelacionVidas1?>,<?php echo $cancelacionVidas2?>,<?php echo $cancelacionVidas3?>,<?php echo $cancelacionVidas4?>,<?php echo $cancelacionVidas5?>,<?php echo $cancelacionVidas6?>,<?php echo $cancelacionVidas7?>,<?php echo $cancelacionVidas8?>,<?php echo $cancelacionVidas9?>,<?php echo $cancelacionVidas10?>,<?php echo $cancelacionVidas11?>,<?php echo $cancelacionVidas12?>]
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
            data: [<?php echo $endosoVidas1?>,<?php echo $endosoVidas2?>,<?php echo $endosoVidas3?>,<?php echo $endosoVidas4?>,<?php echo $endosoVidas5?>,<?php echo $endosoVidas6?>,<?php echo $endosoVidas7?>,<?php echo $endosoVidas8?>,<?php echo $endosoVidas9?>,<?php echo $endosoVidas10?>,<?php echo $endosoVidas11?>,<?php echo $endosoVidas12?>]
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
            data: [<?php echo $emisionVidas1?>,<?php echo $emisionVidas2?>,<?php echo $emisionVidas3?>,<?php echo $emisionVidas4?>,<?php echo $emisionVidas5?>,<?php echo $emisionVidas6?>,<?php echo $emisionVidas7?>,<?php echo $emisionVidas8?>,<?php echo $emisionVidas9?>,<?php echo $emisionVidas10?>,<?php echo $emisionVidas11?>,<?php echo $emisionVidas12?>]
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
