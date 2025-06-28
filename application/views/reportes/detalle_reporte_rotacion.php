
<?php 
$this->load->view('headers/header'); 
$this->load->view('headers/menu');
$ctCapacitacion=0;
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
            <i class="fa fa-search"></i> Consulta Rotacion de Personal (IRP)
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
     <div class="col-md-8 col-lg-8">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Indice Rotación de Personal por Area - <?php echo mesLetra($mes).", ".date('Y');?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartRotacion"></canvas>
                     </div>
                </div>

                <div class="well" style="background-color: #fff;">
                     <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">Activos</td>
                                 <td style="text-align: center;">Bajas</td>
                                 <td style="text-align: center;">% Rotación</td>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>&nbsp;Comercial</td>
                                 <td style="text-align: center;"><?php echo $activosComercial;?></td>
                                 <td style="text-align: center;"><?php echo $bajasComercial;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionComercial;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo</td>
                                 <td style="text-align: center;"><?php echo $activosOperativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasOperativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionOperativo;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Administrativo</td>
                                 <td style="text-align: center;"><?php echo $activosAdministrativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasAdministrativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionAdministrativo;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Gerencial</td>
                                 <td style="text-align: center;"><?php echo $activosGerencial;?></td>
                                <td style="text-align: center;"><?php echo $bajasGerencial;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionGerencial;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo Coorportivo</td>
                                 <td style="text-align: center;"><?php echo $activosCorporativo;?></td>
                                <td style="text-align: center;"><?php echo $bajasCorporativo;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionCorporativo;?></td>
                                
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo Fianzas</td>
                                <td style="text-align: center;"><?php echo $activosFianzas;?></td>
                                <td style="text-align: center;"><?php echo $bajasFianzas;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionFianzas;?></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                 <a href="<?php echo base_url()?>reportes/detalle_reporte_rotacion"><button class="btn btn-primary btn-sm"><i class="fa fa-bars"></i> Ver Detalles</button></a>
            </div>
            </div>
</div>
<div class="row">
         <!--Grafico Global-->
         <div class="col-md-8 col-lg-8">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-indent-right"></i> Indice Rotación de Personal Acumulado Global <?php echo mesLetra(01). " - ".mesLetra($mes).", ".$year;?>
                    </div>
                    <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                        <canvas id="myChartRotacionGloabal"></canvas>
                     </div>
                </div>
                <div class="well" style="background-color: #fff;width: 100%;">
                      <table style="width: 100%;" border="0">
                         <thead>
                             <tr style="background-color: #8370a1;color: #fff;">
                                 <td>&nbsp;<i class="fa fa-cog"></i>&nbsp;DESCRIPCIÓN</td>
                                 <td style="text-align: center;">Activos</td>
                                 <td style="text-align: center;">Bajas</td>
                                 <td style="text-align: center;">% Rotación</td>
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                 <td>&nbsp;Comercial</td>
                                 <td style="text-align: center;"><?php echo $activosComercial;?></td>
                                 <td style="text-align: center;"><?php echo $bajasComercialGlobal;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionComercialGlobal;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo</td>
                                 <td style="text-align: center;"><?php echo $activosOperativo;?></td>
                                 <td style="text-align: center;"><?php echo $bajasOperativoGlobal;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionOperativoGlobal;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Administrativo</td>
                                 <td style="text-align: center;"><?php echo $activosAdministrativo;?></td>
                                 <td style="text-align: center;"><?php echo $bajasAdministrativoGlobal;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionAdministrativoGlobal;?></td>
                             </tr> 
                             <tr>
                                 <td>&nbsp;Gerencial</td>
                                 <td style="text-align: center;"><?php echo $activosGerencial;?></td>
                                 <td style="text-align: center;"><?php echo $bajasGerencialGlobal;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionGerencialGlobal;?></td>
                             </tr>
                              <tr>
                                 <td>&nbsp;Operativo Coorportivo</td>
                                 <td style="text-align: center;"><?php echo $activosCorporativo;?></td>
                                 <td style="text-align: center;"><?php echo $bajasCorporativoGlobal;?></td>
                                 <td style="text-align: center;"><?php echo $rotacionCorporativoGlobal;?></td>
                                
                             </tr>
                              <tr>
                                <td>&nbsp;Operativo Fianzas</td>
                                <td style="text-align: center;"><?php echo $activosFianzas;?></td>
                                <td style="text-align: center;"><?php echo $bajasFianzasGlobal;?></td>
                                <td style="text-align: center;"><?php echo $rotacionFianzasGlobal;?></td>
                             </tr>
                         </tbody>
                     </table>
                     </div>
                </div>
            </div>
 </div>
 
<!-- Fin Container-->


 



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script type="text/javascript">

var ctx = document.getElementById('myChartRotacion').getContext('2d');
window.myBar = new Chart(ctx, {
type: 'bar',
data: {
labels: ['COMERCIAL','OPERATIVO','ADMINISTRATIVO','GERENCIAL','CORPORATIVO','FIANZAS'],
datasets: [
         {
            label: 'Activos',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)'

            ],
            borderColor: [
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)'
            ],
            data: [<?php echo $activosComercial;?>,<?php echo $activosOperativo;?>,<?php echo $activosAdministrativo;?>,<?php echo $activosGerencial;?>,<?php echo $activosCorporativo;?>,<?php echo $activosFianzas;?>]
        },
        {
            label: 'Bajas',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)'

            ],
            borderColor: [
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)'
            ],

            data: [<?php echo $bajasComercial;?>,<?php echo $bajasOperativo;?>,<?php echo $bajasAdministrativo;?>,<?php echo $bajasGerencial;?>,<?php echo $bajasCorporativo;?>,<?php echo $bajasFianzas;?>]
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

var ctx = document.getElementById('myChartRotacionGloabal').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
data: {
labels: ['COMERCIAL','OPERATIVO','ADMINISTRATIVO','GERENCIAL','CORPORATIVO','FIANZAS'],
datasets: [
         {
            label: 'Activos',
            stack: 'Stack 0',
            backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(54, 162, 235, 0.6)'

            ],
            borderColor: [
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)',
               'rgba(54, 162, 235, 1)'
            ],
            data: [<?php echo $activosComercial;?>,<?php echo $activosOperativo;?>,<?php echo $activosAdministrativo;?>,<?php echo $activosGerencial;?>,<?php echo $activosCorporativo;?>,<?php echo $activosFianzas;?>]
        },
        {
            label: 'Bajas',
            stack: 'Stack 1',
            backgroundColor: [
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)',
            'rgba(255, 99, 50, 0.6)'

            ],
            borderColor: [
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)',
                'rgba(255, 99, 50, 1)'
            ],

            data: [<?php echo $bajasComercialGlobal;?>,<?php echo $bajasOperativoGlobal;?>,<?php echo $bajasAdministrativoGlobal;?>,<?php echo $bajasGerencialGlobal;?>,<?php echo $bajasCorporativoGlobal;?>,<?php echo $bajasFianzasGlobal;?>]
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



function getSearch(mes,year){
    var URL=document.getElementById('base').value;  
    URL=URL+"reportes/detalle_reporte_rotacion?mes="+mes.value+"&year="+year;
    document.location.href=URL;
}


</script>
