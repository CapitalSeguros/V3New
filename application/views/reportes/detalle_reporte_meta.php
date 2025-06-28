<?php 
    $this->load->view('headers/header'); 
    $this->load->view('headers/menu');
    $idPersona=$_REQUEST['idPersona'];
    $datos=$this->personamodelo->obtenerDatosUsers($idPersona);
    $email="";$name="";
    $email=$datos->email;
    $name=$datos->name_complete;


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


     //*** Metas Comerciales en Primas
    $acAutosAsignadaPR=0;
    $acVidaAsignadaPR=0;
    $acFianzasAsignadaPR=0;
    $acDaniosAsignadaPR=0;
    $acGmmAsignadaPR=0;

    foreach ($metasAsignadasPrimas as $metaAsignadaPR) {
        if($metaAsignadaPR->ramo=="autos"){
            $acAutosAsignadaPR=$metaAsignadaPR->prima_polizas;
        }
        if($metaAsignadaPR->ramo=="vida"){
            $acVidaAsignadaPR=$metaAsignadaPR->prima_polizas;   
        }
        if($metaAsignadaPR->ramo=="fianzas" ){
            $acFianzasAsignadaPR=$metaAsignadaPR->prima_polizas;
        }
        if($metaAsignadaPR->ramo=="danios"){
            $acDaniosAsignadaPR=$metaAsignadaPR->prima_polizas;
        }
        if($metaAsignadaPR->ramo=="gmm"){
            $acGmmAsignadaPR=$metaAsignadaPR->prima_polizas;
        }
    }

     //*** Metas Comerciales en Polizas
    $acAutosAsignadaPL=0;
    $acVidaAsignadaPL=0;
    $acFianzasAsignadaPL=0;
    $acDaniosAsignadaPL=0;
    $acGmmAsignadaPL=0;

    foreach ($metasAsignadasPolizas as $metaAsignadaPL) {
        if($metaAsignadaPL->ramo=="autos"){
            $acAutosAsignadaPL=$metaAsignadaPL->cantidad_polizas;
        }
        if($metaAsignadaPL->ramo=="vida"){
            $acVidaAsignadaPL=$metaAsignadaPL->cantidad_polizas;   
        }
        if($metaAsignadaPL->ramo=="fianzas"){
            $acFianzasAsignadaPL=$metaAsignadaPL->cantidad_polizas;
        }
        if($metaAsignadaPL->ramo=="danios"){
            $acDaniosAsignadaPL=$metaAsignadaPL->cantidad_polizas;
        }
        if($metaAsignadaPL->ramo=="gmm"){
            $acGmmAsignadaPL=$metaAsignadaPL->cantidad_polizas;
        }
    }

        $acAutosAlcanzadaPR=0;
        $acVidaAlcanzadaPR=0;
        $acFianzasAlcanzadaPR=0;
        $acDaniosAlcanzadaPR=0;
        $acGmmAlcanzadaPR=0;

        $acAutosAlcanzadaPL=0;
        $acVidaAlcanzadaPL=0;
        $acFianzasAlcanzadaPL=0;
        $acDaniosAlcanzadaPL=0;
        $acGmmAlcanzadaPL=0;

        $acComisionGmm=0;   
        $acComisionAutos=0; 
        $acComisionVida=0; 
        $acComisionDanios=0;    
        $acComisionFianzas=0;
    
	if(isset($metasAlcanzadas[0])){
            $acAutosAlcanzadaPL=$metasAlcanzadas[0];
            $acVidaAlcanzadaPL=$metasAlcanzadas[1];
            $acDaniosAlcanzadaPL=$metasAlcanzadas[2];
            $acGmmAlcanzadaPL=$metasAlcanzadas[3];
            $acFianzasAlcanzadaPL=$metasAlcanzadas[4];

        
            $acAutosAlcanzadaPR=$metasAlcanzadas[5];
            $acVidaAlcanzadaPR=$metasAlcanzadas[6];
            $acDaniosAlcanzadaPR=$metasAlcanzadas[7];
            $acGmmAlcanzadaRL=$metasAlcanzadas[8];
            $acFianzasAlcanzadaPR=$metasAlcanzadas[9];

            $acComisionGmm=$metasAlcanzadas[10];   
            $acComisionAutos=$metasAlcanzadas[11]; 
            $acComisionVida=$metasAlcanzadas[12]; 
            $acComisionDanios=$metasAlcanzadas[13];    
            $acComisionFianzas=$metasAlcanzadas[14];
        }
    //Fin metas Comerciales en primas

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<div class="container" style="background-color: #fff;padding: 2%;">
    <div class="row">
      <div class="col-md-10 col-sm-10 col-xs-10">
        <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
        </div>
        <br>
        <h4 class="titulo-secciones">
            <i class="fa fa-list"></i> Detalles metas comerciales por coordinación
        </h4>
        <div style="font-size: 12px;"> Coordinador: <b><?php echo $name." (". $email.")";?></b><br>
            <?php echo mesLetra(date('m')).", ".date('Y');?>
        </div>
        <br>
      </div>
      </div>
    
    <div id="metaComercial">
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Grafico de metas comerciales en primas netas - pesos MXN<br>
                        </div>
                        <div>
                           <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                <canvas id="myChartMetasPrimas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-5">
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Totales de metas comerciales en primas netas - pesos MXN<br>
                        </div>
                        <div>
                            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                 <table class="table table-responsive" style="font-size: 11px;background-color: #fff;">
                                     <thead style="color: #fff;">
                                        <tr>
                                            <th>RAMOS</th>
                                            <th style="text-align: right;">Asignada</th>
                                            <th style="text-align: right;">Alcanzada</th>
                                            <th style="text-align: right;">Comisión</th>
                                        </tr>    
                                     </thead>
                                     <tbody>
                                    <?php  
                                    if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                                         <tr>
                                             <td>Fianzas</td>
                                             <td style="text-align: right;"><?php echo  number_format($acFianzasAsignadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acFianzasAlcanzadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acComisionFianzas,2);?></td>
                                        </tr>
                                    <?php }else{?>
                                         <tr>
                                             <td>Autos</td>
                                             <td style="text-align: right;"><?php echo  number_format($acAutosAsignadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acAutosAlcanzadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acComisionAutos,2);?></td>
                                        </tr>
                                        <tr>
                                             <td>Daños</td>
                                             <td style="text-align: right;"><?php echo  number_format($acDaniosAsignadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acDaniosAlcanzadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acComisionDanios,2);?></td>
                                        </tr>
                                        <tr>
                                             <td>GMM</td>
                                             <td style="text-align: right;"><?php echo  number_format($acGmmAsignadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acGmmAlcanzadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acComisionGmm,2);?></td>
                                        </tr>
                                        <tr>
                                             <td>Vida</td>
                                             <td style="text-align: right;"><?php echo  number_format($acVidaAsignadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acVidaAlcanzadaPR,2);?></td>
                                             <td style="text-align: right;"><?php echo  number_format($acComisionVida,2);?></td>
                                        </tr>
                                    <?php }?>
                                     </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 col-lg-7">
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Metas comerciales en numero de polizas<br> 
                        </div>
                        <div>
                           <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                <canvas id="myChartMetasPolizas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-lg-5">
                <div class="well">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-indent-right"></i> Totales de metas comerciales en numero de polizas <br>
                        </div>
                        <div>
                            <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                                 <table class="table table-responsive" style="font-size: 11px;">
                                     <thead style="color: #fff;">
                                        <tr>
                                            <th>RAMOS</th>
                                            <th style="text-align: right;">Asignada</th>
                                            <th style="text-align: right;">Alcanzada</th>
                                            
                                        </tr>    
                                     </thead>
                                     <tbody>
                                    <?php  
                                    if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                                         <tr>
                                             <td>Fianzas</td>
                                             <td style="text-align: right;"><?php echo  number_format($acFianzasAsignadaPL,2);?></td>
                                             <td style="text-align: right;"><?php echo  $acFianzasAlcanzadaPL;?></td>
                                        </tr>
                                    <?php }else{?>   
                                         <tr>
                                             <td>Autos</td>
                                             <td style="text-align: right;"><?php echo  $acAutosAsignadaPL;?></td>
                                             <td style="text-align: right;"><?php echo  $acAutosAlcanzadaPL;?></td>
                                        </tr>
                                        <tr>
                                             <td>Daños</td>
                                             <td style="text-align: right;"><?php echo $acDaniosAsignadaPL;?></td>
                                             <td style="text-align: right;"><?php echo  $acDaniosAlcanzadaPL;?></td>
                                        </tr>
                                        <tr>
                                             <td>GMM</td>
                                             <td style="text-align: right;"><?php echo  $acGmmAsignadaPL;?></td>
                                             <td style="text-align: right;"><?php echo  $acGmmAlcanzadaPL;?></td>
                                        </tr>
                                        <tr>
                                             <td>Vida</td>
                                             <td style="text-align: right;"><?php echo  $acVidaAsignadaPL;?></td>
                                             <td style="text-align: right;"><?php echo  $acVidaAlcanzadaPL;?></td>
                                        </tr>
                                    <?php }?>
                                     </tbody>
                                 </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">


//Grafico Metas Comerciales

var ctx = document.getElementById('myChartMetasPrimas').getContext('2d');
window.myBar = new Chart(ctx, {
    type: 'bar',
    data: {
            <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                 labels: ['','','FIANZAS','',''],
            <?}else{?>
                labels: ['AUTOS', 'DAÑOS','GMM', 'VIDA'],
            <?}?>

            datasets: [{
                label: 'META ASIGNADA',
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                stack: 'Stack 0',
                <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                    data: [0,0,'<?php echo $acFianzasAsignadaPR?>',0,0
                    ]
                <?php }else{?>
                    data: [
                   '<?php echo $acAutosAsignadaPR?>','<?php echo $acDaniosAsignadaPR?>','<?php echo $acGmmAsignadaPR?>','<?php echo $acVidaAsignadaPR?>' 
                    ]
                <?php }?>
            }, {
                label: 'META ALCANZADA',
                 backgroundColor: 'rgba(153, 102, 255, 1)',
                 stack: 'Stack 1',
                 <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                    data: [0,0,'<?php echo $acFianzasAlcanzadaPR?>',0,0
                    ]
                <?php }else{?>
                    data: [
                   '<?php echo $acAutosAlcanzadaPR?>','<?php echo $acDaniosAlcanzadaPR?>','<?php echo $acGmmAlcanzadaPR?>','<?php echo $acVidaAlcanzadaPR?>' 
                    ]
                <?php }?>
            }
            , {
                label: 'TOTAL COMISION',
                 backgroundColor: 'rgba(210,180,222, 1)',
                 stack: 'Stack 2',
                 <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                    data: [0,0,'<?php echo $acComisionFianzas?>',0,0
                    ]
                <?php }else{?>
                    data: [
                    '<?php echo $acComisionAutos?>','<?php echo $acComisionDanios?>','<?php echo $acComisionGmm?>','<?php echo $acComisionVida?>' 
                    ]
                <?php }?>
            }]
        },
    options: {
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        responsive: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        }
    }
});

var ctx = document.getElementById('myChartMetasPolizas').getContext('2d');
window.myBar = new Chart(ctx, {
    type: 'bar',
   data: {
            <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                labels: ['','','FIANZAS','',''],
            <?}else{?>
                labels: ['AUTOS', 'DAÑOS','GMM', 'VIDA'],
            <?}?>

            datasets: [{
                label: 'META ASIGNADA',
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                stack: 'Stack 0',
                <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                    data: [0,0,'<?php echo $acFianzasAsignadaPL?>',0,0
                    ]
                <?php }else{?>
                    data: [
                    '<?php echo $acAutosAsignadaPL?>','<?php echo $acDaniosAsignadaPL?>','<?php echo $acGmmAsignadaPL?>','<?php echo $acVidaAsignadaPL?>' 
                    ]
                <?php }?>
            }, {
                label: 'META ALCANZADA',
                 backgroundColor: 'rgba(153, 102, 255, 1)',
                 stack: 'Stack 1',
                 <?php if($email=='COORDINADORCOMERCIAL@FIANZASCAPITAL.COM'){?>
                    data: [0,0,'<?php echo $acFianzasAlcanzadaPL?>',0,0
                    ]
                <?php }else{?>
                    data: [
                   '<?php echo $acAutosAlcanzadaPL?>','<?php echo $acDaniosAlcanzadaPL?>','<?php echo $acGmmAlcanzadaPL?>','<?php echo $acVidaAlcanzadaPL?>' 
                    ]
                <?php }?>
            }]
        },
    options: {
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        responsive: true,
        scales: {
            x: {
                stacked: true,
            },
            y: {
                stacked: true
            }
        }
    }
});

</script>





