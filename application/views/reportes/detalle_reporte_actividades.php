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

$cotizacionAutos=$actividadesAutos[0];
$cancelacionAutos=$actividadesAutos[1];
$endosoAutos=$actividadesAutos[2];
$emisionAutos=$actividadesAutos[3];


$cotizacionDanios=$actividadesDanios[0];
$cancelacionDanios=$actividadesDanios[1];
$endosoDanios=$actividadesDanios[2];
$emisionDanios=$actividadesDanios[3];

$cotizacionVidas=$actividadesVidas[0];
$cancelacionVidas=$actividadesVidas[1];
$endosoVidas=$actividadesVidas[2];
$emisionVidas=$actividadesVidas[3];

//Semaforo Autos
$ctCotizacionAutosVerde=$autosSemaforo[0];
$ctCotizacionAutosAmarillo=$autosSemaforo[1];
$ctCotizacionAutosRojo=$autosSemaforo[2];

$ctCancelacionAutosVerde=$autosSemaforo[3];
$ctCancelacionAutosAmarillo=$autosSemaforo[4];
$ctCancelacionAutosRojo=$autosSemaforo[5];

$ctEndosoAutosVerde=$autosSemaforo[6];
$ctEndosoAutosAmarillo=$autosSemaforo[7];
$ctEndosoAutosRojo=$autosSemaforo[8];

$ctEmisionAutosVerde=$autosSemaforo[9];
$ctEmisionAutosAmarillo=$autosSemaforo[10];
$ctEmisionAutosRojo=$autosSemaforo[11];

//Semaforo Daños
$ctCotizacionDaniosVerde=$daniosSemaforo[0];
$ctCotizacionDaniosAmarillo=$daniosSemaforo[1];
$ctCotizacionDaniosRojo=$daniosSemaforo[2];

$ctCancelacionDaniosVerde=$daniosSemaforo[3];
$ctCancelacionDaniosAmarillo=$daniosSemaforo[4];
$ctCancelacionDaniosRojo=$daniosSemaforo[5];

$ctEndosoDaniosVerde=$daniosSemaforo[6];
$ctEndosoDaniosAmarillo=$daniosSemaforo[7];
$ctEndosoDaniosRojo=$daniosSemaforo[8];

$ctEmisionDaniosVerde=$daniosSemaforo[9];
$ctEmisionDaniosAmarillo=$daniosSemaforo[10];
$ctEmisionDaniosRojo=$daniosSemaforo[11];

//Semaforo Vida
$ctCotizacionVidaVerde=$vidaSemaforo[0];
$ctCotizacionVidaAmarillo=$vidaSemaforo[1];
$ctCotizacionVidaRojo=$vidaSemaforo[2];

$ctCancelacionVidaVerde=$vidaSemaforo[3];
$ctCancelacionVidaAmarillo=$vidaSemaforo[4];
$ctCancelacionVidaRojo=$vidaSemaforo[5];

$ctEndosoVidaVerde=$vidaSemaforo[6];
$ctEndosoVidaAmarillo=$vidaSemaforo[7];
$ctEndosoVidaRojo=$vidaSemaforo[8];

$ctEmisionVidaVerde=$vidaSemaforo[9];
$ctEmisionVidaAmarillo=$vidaSemaforo[10];
$ctEmisionVidaRojo=$vidaSemaforo[11];




?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<div class="container">
<input type="hidden" id="base" value="<?php echo base_url()?>">
<!--Grafico Autos-->
<div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10">
        <h4 class="titulo-secciones">
        <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
        </div>
          <br>
            <i class="fa fa-list"></i> Detalles actividades actuales por ejecutivo
        </h4>
      </div>
</div>
    <br>
    <div style="text-align: left;">
      <b><?php echo mesLetra(date('m')).", ".date('Y');?> </b>
    </div>
    <br>
    <div class="row">
        <!--Grafico Autos-->
      <div class="col-sm-6 col-md-6">
            <div class="well" style="background-color: #fff;">
                 <div class="panel panel-default" style="font-size: 11px;">
                    <div class="panel-heading">
                       <i class="fa fa-car"></i> Ramo: <b>AUTOS</b><br>
                        <i class="fa fa-user"></i> Ejecutivo: <b><?php echo $nameAuto?></b>&nbsp;(AUTOS@ASESORESCAPITAL.COM)
                     </div>
                 </div>
                 <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                     <canvas id="myChartActividadesAutos"></canvas>
                 </div>
                 <br>
                 <div>
                    <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                            <tr>
                                <td colspan="2" style="background-color: #8370a1"></td>
                                <td colspan="3" style="background-color: #8370a1;text-align: center;color: #fff;">SEMAFORO</td>
                                <td style="background-color: #8370a1"></td>
                            </tr>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cogs"></i>&nbsp;ACTIVIDADES</td>
                                 <td style="text-align: center;">NUMERO</td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #04B404">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FFBF00">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FA5858">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;">DETALLE</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;&nbsp;Cotización</td>
                                 <td style="text-align: center;"><b><?php echo $cotizacionAutos?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionAutosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionAutosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionAutosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(1)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Cancelación</td>
                                 <td style="text-align: center;"><b><?php echo $cancelacionAutos?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionAutosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionAutosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionAutosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(2)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;&nbsp;Endoso</td>
                                 <td style="text-align: center;"><b><?php echo $endosoAutos?></b></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoAutosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoAutosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoAutosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(3)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Emisión</td>
                                 <td style="text-align: center;"><b><?php echo $emisionAutos?></b></td>
                                  <td style="text-align: center;"><?php echo $ctEmisionAutosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionAutosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionAutosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(4)"><i class="fa fa-list"></i></a></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                 </div>
            </div>
        </div>
        <!--Grafico Daños-->
        <div class="col-sm-6 col-md-6">
            <div class="well" style="background-color: #fff;">
                 <div class="panel panel-default" style="font-size: 11px;">
                    <div class="panel-heading">
                       <i class="fa fa-heartbeat"></i> Ramo: <b>DAÑOS</b><br>
                         <i class="fa fa-user"></i> Ejecutivo: <b><?php echo $nameDanio?></b>&nbsp;(BIENES@ASESORESCAPITAL.COM)
                     </div>
                 </div>
                 <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                    <canvas id="myChartActividadesDanios"></canvas>
                 </div>
                 <br>
                 <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                            <tr>
                                <td colspan="2" style="background-color: #8370a1"></td>
                                <td colspan="3" style="background-color: #8370a1;text-align: center;color: #fff;">SEMAFORO</td>
                                <td style="background-color: #8370a1"></td>
                            </tr>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cogs"></i>&nbsp;ACTIVIDADES</td>
                                 <td style="text-align: center;">NUMERO</td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #04B404">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FFBF00">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FA5858">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;">DETALLE</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;&nbsp;Cotización</td>
                                 <td style="text-align: center;"><b><?php echo $cotizacionDanios?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionDaniosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionDaniosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionDaniosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(5)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Cancelación</td>
                                 <td style="text-align: center;"><b><?php echo $cancelacionDanios?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionDaniosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionDaniosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionDaniosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(6)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;&nbsp;Endoso</td>
                                 <td style="text-align: center;"><b><?php echo $endosoDanios?></b></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoDaniosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoDaniosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoDaniosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(7)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Emisión</td>
                                 <td style="text-align: center;"><b><?php echo $emisionDanios?></b></td>
                                  <td style="text-align: center;"><?php echo $ctEmisionDaniosVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionDaniosAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionDaniosRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(8)"><i class="fa fa-list"></i></a></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
            </div>
        </div>
     </div>
<!--Grafico Vida-->

<div class="row">
   <div class="col-sm-6 col-md-6">
        <div class="well" style="background-color: #fff;">
             <div class="panel panel-default">
                <div class="panel-heading" style="font-size: 11px">
                    <i class="fa fa-tag"></i> Ramo: <b>LINEAS PERSONALES</b><br>
                    <i class="fa fa-user"></i>Ejecutivo: <b><?php echo $nameVida?></b>&nbsp;(LINEASPERSONALES@ASESORESCAPITAL.COM)
                 </div>
             </div>
             <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                <canvas id="myChartActividadesVidas"></canvas>
             </div>
             <br>
             <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                            <tr>
                                <td colspan="2" style="background-color: #8370a1"></td>
                                <td colspan="3" style="background-color: #8370a1;text-align: center;color: #fff;">SEMAFORO</td>
                                <td style="background-color: #8370a1"></td>
                            </tr>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cogs"></i>&nbsp;ACTIVIDADES</td>
                                 <td style="text-align: center;">NUMERO</td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #04B404">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FFBF00">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;background-color: #F2F2F2;"><span class="badge" style="background-color: #FA5858">&nbsp;&nbsp;</span></td>
                                 <td style="text-align: center;">DETALLE</td>
                             </tr>
                         </thead>
                         <tbody>
                            <tr>
                                 <td>&nbsp;&nbsp;Cotización</td>
                                 <td style="text-align: center;"><b><?php echo $cotizacionVidas?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionVidaVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionVidaAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCotizacionVidaRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(9)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Cancelación</td>
                                 <td style="text-align: center;"><b><?php echo $cancelacionVidas?></b></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionVidaVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionVidaAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctCancelacionVidaRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(10)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr>
                                 <td>&nbsp;&nbsp;Endoso</td>
                                 <td style="text-align: center;"><b><?php echo $endosoVidas?></b></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoVidaVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoVidaAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEndosoVidaRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(11)"><i class="fa fa-list"></i></a></td>
                             </tr>
                             <tr style="background-color: #E6E6E6;">
                                 <td>&nbsp;&nbsp;Emisión</td>
                                 <td style="text-align: center;"><b><?php echo $emisionVidas?></b></td>
                                  <td style="text-align: center;"><?php echo $ctEmisionVidaVerde?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionVidaAmarillo?></td>
                                 <td style="text-align: center;"><?php echo $ctEmisionVidaRojo?></td>
                                 <td style="text-align: center;"><a href="#" data-toggle="modal" data-target="#detalles" onclick="setDetalle(12)"><i class="fa fa-list"></i></a></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
        </div>
    </div>


<!-- Modal Detalle--> 
<div id="detalles" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 60%;">
    <div class="modal-content">
        <div class="modal-header">
            <table style="width: 100%;">
                <tr>
                    <td><h5 style="font-size: 12px;"><i class="fa fa-list"></i> DETALLES TIPO DE ACTIVIDADES </h5></td>
                    <td> <button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button></td>
                </tr>
            </table>
        </div>
        <div class="modal-body">
           <div id='tabla-detalle'></div> 
        </div>
    </div>
  </div>
  </div>
</div>
<!-- Fin modal-->

<?php 
include('detalle_reporte_actividades_anual_autos.php');
include('detalle_reporte_actividades_anual_danios.php');
include('detalle_reporte_actividades_anual_vida.php');
?>

<!-- Fin Container-->
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script type="text/javascript">
//Grafico Autos

var ctx = document.getElementById('myChartActividadesAutos').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Cotización', 'Cancelación', 'Endoso','Emisión'],
        datasets: [{
            label: 'Actividades',
            data: [<?php echo $cotizacionAutos?>,<?php echo $cancelacionAutos?>,<?php echo $endosoAutos?>,<?php echo $emisionAutos?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
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

//Grafico Daños

var ctx = document.getElementById('myChartActividadesDanios').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Cotización', 'Cancelación', 'Endoso','Emisión'],
        datasets: [{
            label: 'Actividades',
            data: [<?php echo $cotizacionDanios?>,<?php echo $cancelacionDanios?>,<?php echo $endosoDanios?>,<?php echo $emisionDanios?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
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


//Grafico Vida

var ctx = document.getElementById('myChartActividadesVidas').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Cotización', 'Cancelación', 'Endoso','Emisión'],
        datasets: [{
            label: 'Actividades',
            data: [<?php echo $cotizacionVidas?>,<?php echo $cancelacionVidas?>,<?php echo $endosoVidas?>,<?php echo $emisionVidas?>],
            backgroundColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 50, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
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

function setDetalle(op){
    divResultado = document.getElementById('tabla-detalle');  
    ajax=objetoAjax(); 
    var URL=document.getElementById('base').value;  
    URL=URL+"reportes/ajax_detalles_actividades/"+op;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.send(null) 
}


</script>

