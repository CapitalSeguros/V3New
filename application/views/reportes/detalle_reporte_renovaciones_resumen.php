
<?php

function mesLetra($mes){
    switch ($mes) {
        case '01':return 'ENERO';break;
        case '02':return 'FEBRERO';break;
        case '03':return 'MARZO';break;
        case '04':return 'ABRIL';break;
        case '05':return 'MAYO';break;
        case '06':return 'JUNIO';break;
        case '07':return 'JULIO';break;
        case '08':return 'AGOSTO';break;
        case '09':return 'SEPTIEMBRE';break;
        case '10':return 'OCTUBRE';break;
        case '11':return 'NOVIEMBRE';break;
        case '12':return 'DICIEMBRE';break;
    }

}

function avance($pend,$base){
    if(($base==0)||($base==0.00)){
        return number_format(abs((($pend*100)/1)-100),2);
    }else{
        return number_format(abs((($pend*100)/$base)-100),2);
    }
}

?>
<style type="text/css">
    .semaforo{
        width: 100%;border-width: 0.7px; border-style: solid;border-color: silver;text-align: center;background-color: #fff;
    }
    .semaforo tr td{
        width: 5%;
    }
    
    .resumen{
        width: 90%;border-width: 0.7px; border-style: solid;border-color: silver;text-align: center;background-color: #fff;
    }
    .resumen tr td{
        width: 17%;
        vertical-align: middle;
        padding-left: 5px;
        text-align: center;
        height: 25px;
    }
    .resumen tr td a{
        text-decoration: none;
        color: #000;
    }
    .resumen tr td:hover{
        background-color: orange;
        font-size: 14px;
        opacity: 0.8;
        font-weight: bold;
    }
    #loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('../assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .8;
    }
    #seleccion_mes {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1050;
    }
    .table{
        font-size: 11px;
        width: 100%;
    }
</style>

<div id="loader" style="display: none;"></div>
<div id="rango">
    <span><i class="fa fa-calendar"></i> Rango de consulta </span><br>
    <span style="font-weight: bold;">Desde: </span>
    <span><?php echo $fdesde;?></span>
    <span style="font-weight: bold;">&nbsp;&nbsp;Hasta: </span>
    <span><?php echo $fhasta;?></span>
</div>
<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-8">
        <table class="resumen" border="1">
            <tr style="background-color: #000;color: #fff;">
                <td  style="background-color: orange;color: #000;">
                    <span id="lbMes">
                        <?php
                         $p=explode('/',$fhasta);
                         echo mesLetra($p[1]);?>
                    </span>
                </td>
                <td>Acc y Enf</td>
                <td>Daños</td>
                <td>Vehiculos</td>
                <td>Vida</td>
                <td>Total</td>
            </tr>
            <tr style="font-weight: bold;background-color: #E6E6E6">
                <td style="text-align:left;"><b>Base x Renovar</b></td>
                <td><?php echo $totalAccEnf+$renovacionesPendientesRamo[0];?></td>
                <td><?php echo $totalDanios+$renovacionesPendientesRamo[1];?></td>
                <td><?php echo $totalAutos+$renovacionesPendientesRamo[2];?></td>
                <td><?php echo $renovacionesPendientesRamo[3];?></td>
                <td><?php echo $totalAccEnf+$renovacionesPendientesRamo[0]+$totalDanios+$renovacionesPendientesRamo[1]+$totalAutos+$renovacionesPendientesRamo[2];?></td>
            </tr>
            <tr style="background-color: #F2F2F2;">
                <td style="text-align:left;">Renovadas</td>
                <td><a href='#AccidentesR'><?php echo $totalAccEnf;?></a></td>
                <td><a href='#DaniosR'><?php echo $totalDanios;?></a></td>
                <td><a href='#VehiculosR'><?php echo $totalAutos;?></a></td>
                <td><a href='#VidasR'><?php echo $totalVida;?></a></td>
                <td><?php echo $totalAccEnf+$totalAutos+$totalDanios+$totalVida;?></td>
            </tr>
            <tr style="background-color: #FAFAFA;">
                <td style="text-align:left;"><b>Pendientes</b></td>
                <td><a href='#Accidentes'><?php echo $renovacionesPendientesRamo[0];?></a></td>
                <td><a href='#Danios'><?php echo $renovacionesPendientesRamo[1];?></a></td>
                <td><a href='#Vehiculos'><?php echo $renovacionesPendientesRamo[2];?></a></td>
                <td><a href='#Vidas'><?php echo $renovacionesPendientesRamo[3];?></a></td>
                <td><?php echo ($renovacionesPendientesRamo[0]+$renovacionesPendientesRamo[1]+$renovacionesPendientesRamo[2]+$renovacionesPendientesRamo[3]);?></td>
            </tr>
            <tr>
                <td colspan="6"><br></td>
            </tr>
            <tr>
                <td style="text-align:left;">% Avance</td>
                <td><?php echo avance($renovacionesPendientesRamo[0],($totalAccEnf+$renovacionesPendientesRamo[0]))."%";?></td>
                <td><?php echo avance($renovacionesPendientesRamo[1],($totalDanios+$renovacionesPendientesRamo[1]))."%";?></td>
                <td><?php echo avance($renovacionesPendientesRamo[2],($totalAutos+$renovacionesPendientesRamo[2]))."%";?></td>
                <td><?php echo avance($renovacionesPendientesRamo[3],($totalVida+$renovacionesPendientesRamo[3]))."%";?></td>
                <td><?php echo avance(($renovacionesPendientesRamo[0]+$renovacionesPendientesRamo[1]+$renovacionesPendientesRamo[2]+$renovacionesPendientesRamo[3]),($totalAccEnf+$renovacionesPendientesRamo[0]+$totalDanios+$renovacionesPendientesRamo[1]+$totalAutos+$renovacionesPendientesRamo[2]))."%";?></td>
            </tr>
        </table>
    </div>

     <div class="col-md-4 col-sm-4 col-xs-4">
        <table class="semaforo" border="1">
            <tr>
                <td colspan="2"><b><i class="fa fa-file"></i>&nbsp;Polizas Pendientes x Renovar&nbsp;</b></td>
            </tr>
            <tr>
                <td style="background-color: red;font-weight: bold;color: #fff;">- 1 dia</td>
                <td><b><div id='totalRojosSemaforo'></div></b></td>
            </tr>
            <tr>
                <td style="background-color: orange;font-weight: bold;">+ 1 dia</td>
                <td><b><div id='totalAmarillosSemaforo'></div></b></td>
            </tr>
            <tr>
                <td style="background-color: green;font-weight: bold;color: #fff;">+ 20 dias</td>
                <td><b><div id='totalVerdesSemaforo'></div></b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;background-color: #000;color: #fff;">&nbsp;<i class="fa fa-edit"></i>&nbsp;JUSTIFICACIÓN</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">
                    <textarea id="justificacion" name="justificacion" cols="50" rows="4">
                        <?php echo $comentario;?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;margin-right: 2%;background-color: #f5f5f5;"><button type="button" class="btn btn-primary btn-xs" onclick="guardar_renovacion_justificacion()">Guardar</button></td>
            </tr>
        </table>
    </div>
</div>
<br><br>
<!--*******************************-->
<!-- Polizas pendientes por Renovar-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="alert alert-default" style="background-color: #E6E6E6;color: #000;padding: 1px;padding-left: 10px;margin-bottom: 5px;">
        <h4 class="titulo-secciones">
          <br>
             <i class="fa fa-list"></i> DETALLES DE POLIZAS PENDIENTES X RENOVAR
        </h4>
        </div>
    </div>
</div>

<!--Autos-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px"><i class="fa fa-list"></i> Detalles de polizas: <b>Pendientes x Renovar</b></div>
     <p id="Vehiculos">
    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-car"></i> Autos</h4>
    </div>
     <div class="panel panel-default">
        <!--Inicio Verde-->
        <div>
            <table class="table table-hover">
            <thead>
             <tr style="background-color: green;color: #fff;">
                <th>Documento</th>
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Cliente</th>
                <th>Comisión</th>
                <th>Prima Total</th>
                <th>Moneda</th>
            </tr>
            </thead>
             <tbody>
            <?php
            $totalVerdesPendientes=0;
            $ct=0;$FActual=date('d-m-Y');
            foreach ($renovacionesPendientes as $rowV) {
                if($rowV->RamosNombre=="Vehiculos"){
                    $FActual=strtotime($FActual);
                    $FHasta=strtotime($rowV->FHasta);
                    $dias=floor(($FActual-$FHasta)/86400);
                    if($dias>20){ $ct++;$totalVerdesPendientes++;
                        $comision=0;
                        for($i=0;$i<17;$i++){
                            $c="Comision".$i;
                            $comision=$comision+$rowV->$c;
                        }
                    ?>
                       <tr>
                            <td><?php echo $rowV->Documento?></td>
                            <td><?php echo $rowV->VendNombre?></td>
                            <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                            <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                            <td><?php echo $rowV->NombreCompleto?></td>
                            <td  style="text-align: right;"><?php echo $comision;?></td>
                            <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                            <td><?php echo $rowV->Moneda?></td>
                            <td>
                                <button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>comentarios</button>
                            </td>
                        </tr>
                <?php
                    }
                }
            }?>
            <tr>
                <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                <td><?php echo $ct;?></td>
            </tr>
            </tbody>
            </table>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
        <div>
           <table class="table table-hover">
            <thead>
             <tr style="background-color: orange;color: #000;">
                <th>Documento</th>
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Cliente</th>
                <th>Comision</th>
                <th>Prima Total</th>
                <th>Moneda</th>
            </tr>
            </thead>
             <tbody>
            <?php
            $ct=0;$FActual=date('d-m-Y');
            $totalAmarillosPendientes=0;
            foreach ($renovacionesPendientes as $rowV) {
                if($rowV->RamosNombre=="Vehiculos"){
                    $FActual=strtotime($FActual);
                    $FHasta=strtotime($rowV->FHasta);
                    $dias=floor(($FActual-$FHasta)/86400);
                    if(($dias>-1)&&($dias<21)){ $ct++;$totalAmarillosPendientes++;
                         $comision=0;
                        for($i=0;$i<17;$i++){
                            $c="Comision".$i;
                            $comision=$comision+$rowV->$c;
                        }
                    ?>
                       <tr>
                            <td><?php echo $rowV->Documento?></td>
                            <td><?php echo $rowV->VendNombre?></td>
                            <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                            <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                            <td><?php echo $rowV->NombreCompleto?></td>
                            <td style="text-align: right;"><?php echo $comision;?></td>
                            <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                            <td><?php echo $rowV->Moneda?></td>
                        </tr>
                <?php
                    }
                }
            }?>
            <tr>
                <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                <td><?php echo $ct;?></td>
            </tr>
            </tbody>
            </table>
        </div>
        <!--fin Amarillo-->

         <!--Inicio Rojo-->
        <div>
            <table class="table table-hover">
               <thead>
                <tr style="background-color: red;color: #000;">
                    <th>Documento</th>
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Cliente</th>
                    <th>Comision</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                </tr>
                </thead>
                <tbody>
                <?php
               $totalRojosPendientes=0;
               $ct=0;$FActual=date('d-m-Y');
               foreach ($renovacionesPendientes as $rowV) {
                    if($rowV->RamosNombre=="Vehiculos"){
                        $FActual=strtotime($FActual);
                        $FHasta=strtotime($rowV->FHasta);
                        $dias=floor(($FActual-$FHasta)/86400);
                        if($dias<0){ $ct++;$totalRojosPendientes++;
                             $comision=0;
                            for($i=0;$i<17;$i++){
                                $c="Comision".$i;
                                $comision=$comision+$rowV->$c;
                            }
                        ?>
                           <tr>
                                <td><?php echo $rowV->Documento?></td>
                                <td><?php echo $rowV->VendNombre?></td>
                                <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                <td><?php echo $rowV->NombreCompleto?></td>
                                <td style="text-align: right;"><?php echo $comision;?></td>
                                <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                <td><?php echo $rowV->Moneda?></td>
                            </tr>
                    <?php
                        }
                    }
                }?>
                <tr>
                     <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                    <td><?php echo $ct;?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!--fin Rojo-->
    </div>
 </div>
  <!--Fin de Autos-->



  <!--Daños-->
<div class="well" style="background-color: #fff;padding: 15px;">
    
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px"><i class="fa fa-list"></i> Detalles de polizas: <b>Pendientes x Renovar</b></div>
     <p id="Danios">

    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-bolt"></i> Daños</h4>
    </div>
     <div class="panel panel-default">
        <!--Inicio Verde-->
        <div>
            <table class="table table-hover">
                        <thead>
                         <tr style="background-color: green;color: #fff;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Daños"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias>20){ $ct++;$totalVerdesPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                    <td><?php echo $rowV->Documento?></td>
                                    <td><?php echo $rowV->VendNombre?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                    <td><?php echo $rowV->NombreCompleto?></td>
                                    <td style="text-align: right;"><?php echo $comision;?></td>
                                    <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                    <td><?php echo $rowV->Moneda?></td>
                                  </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                             <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
        <div>
           <table class="table table-hover">
                        <thead>
                         <tr style="background-color: orange;color: #000;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Daños"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if(($dias>-1)&&($dias<21)){ $ct++;$totalAmarillosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                    <td><?php echo $rowV->Documento?></td>
                                    <td><?php echo $rowV->VendNombre?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                    <td><?php echo $rowV->NombreCompleto?></td>
                                    <td style="text-align: right;"><?php echo $comision;?></td>
                                    <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                    <td><?php echo $rowV->Moneda?></td>
                                  </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Amarillo-->

         <!--Inicio Rojo-->
        <div>
           <table class="table table-hover">
                       <thead>
                        <tr style="background-color: red;color: #000;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th  style="text-align: right;">Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ctdanios=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Daños"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias<0){ $ctdanios++;$totalRojosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                    <td><?php echo $rowV->Documento?></td>
                                    <td><?php echo $rowV->VendNombre?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                    <td><?php echo $rowV->NombreCompleto?></td>
                                    <td style="text-align: right;"><?php echo $comision;?></td>
                                    <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                    <td><?php echo $rowV->Moneda?></td>
                                  </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                           <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ctdanios;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Rojo-->
    </div>
 </div>
  <!--Fin de Daños-->

  <!--Vida-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px"><i class="fa fa-list"></i> Detalles de polizas: <b>Pendientes x Renovar</b></div>
     <p id="Vidas">

    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-user"></i> Vida</h4>
    </div>
     <div class="panel panel-default">
        <!--Inicio Verde-->
        <div>
            <table class="table table-hover">
                        <thead>
                         <tr style="background-color: green;color: #fff;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th  style="text-align: right;">Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                       <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Vida"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias>20){ $ct++;$totalVerdesPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                    <td><?php echo $rowV->Documento?></td>
                                    <td><?php echo $rowV->VendNombre?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                    <td><?php echo $rowV->NombreCompleto?></td>
                                    <td style="text-align: right;"><?php echo $comision;?></td>
                                    <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                    <td><?php echo $rowV->Moneda?></td>
                                  </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
        <div>
           <table class="table table-hover">
                        <thead>
                         <tr style="background-color: orange;color: #000;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Vida"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if(($dias>-1)&&($dias<21)){ $ct++;$totalAmarillosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                    <td><?php echo $rowV->Documento?></td>
                                    <td><?php echo $rowV->VendNombre?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                    <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                    <td><?php echo $rowV->NombreCompleto?></td>
                                    <td style="text-align: right;"><?php echo $comision;?></td>
                                    <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                    <td><?php echo $rowV->Moneda?></td>
                                   </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                           <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Amarillo-->

         <!--Inicio Rojo-->
        <div>
           <table class="table table-hover">
                       <thead>
                        <tr style="background-color: red;color: #000;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ctvida=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Vida"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias<0){ $ctvida++;$totalRojosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                        <td><?php echo $rowV->Documento?></td>
                                        <td><?php echo $rowV->VendNombre?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                        <td><?php echo $rowV->NombreCompleto?></td>
                                        <td style="text-align: right;"><?php echo $comision;?></td>
                                        <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                        <td><?php echo $rowV->Moneda?></td>
                                    </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ctvida;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Rojo-->
    </div>
 </div>
  <!--Fin de Vida-->

 <!--Accidentes y Enfermedades-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <p id="Accidentes">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px"><i class="fa fa-list"></i> Detalles de polizas: <b>Pendientes x Renovar</b></div>
    

    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-heartbeat"></i> Accidentes y Enfermedades</h4>
    </div>
     <div class="panel panel-default">
        <!--Inicio Verde-->
        <div>
            <table class="table table-hover">
                        <thead>
                         <tr style="background-color: green;color: #fff;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Accidentes y Enfermedades"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias>20){ $ct++;$totalVerdesPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                        <td><?php echo $rowV->Documento?></td>
                                        <td><?php echo $rowV->VendNombre?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                        <td><?php echo $rowV->NombreCompleto?></td>
                                        <td style="text-align: right;"><?php echo $comision;?></td>
                                        <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                        <td><?php echo $rowV->Moneda?></td>
                                    </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
        <div>
           <table class="table table-hover">
                        <thead>
                         <tr style="background-color: orange;color: #000;">
                            <th>Documento</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Cliente</th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ct=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Accidentes y Enfermedades"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if(($dias>-1)&&($dias<21)){ $ct++;$totalAmarillosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                        <td><?php echo $rowV->Documento?></td>
                                        <td><?php echo $rowV->VendNombre?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                        <td><?php echo $rowV->NombreCompleto?></td>
                                        <td style="text-align: right;"><?php echo $comision;?></td>
                                        <td  style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                        <td><?php echo $rowV->Moneda?></td>
                                    </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan="7"><b>Total de Documentos:</b></td>
                            <td><?php echo $ct;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Amarillo-->

         <!--Inicio Rojo-->
        <div>
           <table class="table table-hover">
                       <thead>
                        <tr style="background-color: red;color: #000;">
                            <th>IDDocto</th>
                            <th>Documento</th>
                            <th>OTPosterior</th>
                            <th>Vendedor</th>
                            <th>Fecha&nbsp;Desde</th>
                            <th>Fecha&nbsp;Hasta </th>
                            <th>Comision</th>
                            <th>Prima Total</th>
                            <th>Moneda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ctacenf=0;$FActual=date('d-m-Y');
                       foreach ($renovacionesPendientes as $rowV) {
                            if($rowV->RamosNombre=="Accidentes y Enfermedades"){
                                $FActual=strtotime($FActual);
                                $FHasta=strtotime($rowV->FHasta);
                                $dias=floor(($FActual-$FHasta)/86400);
                                if($dias<0){ $ctacenf++;$totalRojosPendientes++;
                                    $comision=0;
                                    for($i=0;$i<17;$i++){
                                        $c="Comision".$i;
                                        $comision=$comision+$rowV->$c;
                                    }
                                ?>
                                   <tr>
                                        <td><?php echo $rowV->Documento?></td>
                                        <td><?php echo $rowV->VendNombre?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FDesde))?></td>
                                        <td><?php echo date("d-m-Y", strtotime($rowV->FHasta))?></td>
                                        <td><?php echo $rowV->NombreCompleto?></td>
                                        <td style="text-align: right;"><?php echo $comision;?></td>
                                        <td style="text-align: right;"><?php echo $rowV->PrimaTotal;?></td>
                                        <td><?php echo $rowV->Moneda?></td>
                                    </tr>
                            <?php
                                }
                            }
                        }?>
                        <tr>
                            <td style="text-align: right;" colspan=7><b>Total de Documentos:</b></td>
                            <td><?php echo $ctacenf;?></td>
                        </tr>
                        </tbody>
                    </table>
        </div>
        <!--fin Rojo-->
    </div>
 </div>
  <!--Accidentes y Fnfermedades-->


<br><br><br><br>
<!--*****************************************************************-->
<!-- Polizas Ya renovadas-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-default" style="background-color: #E6E6E6;color: #000;padding: 1px;padding-left: 10px;margin-bottom: 5px;">
        <h4 class="titulo-secciones">
          <br>
             <i class="fa fa-list"></i> DETALLES DE POLIZAS YA RENOVADAS
        </h4>
        </div>
    </div>
</div>

<!--Autos-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <p id="VehiculosR">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px">
        <i class="fa fa-list"></i> Detalles de polizas: <b>Renovadas</b>
    </div>
    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-car"></i> Autos</h4>
    </div>
     
        <!--Inicio Verde-->
       <table class="table table-hover">
                <thead>
                <tr style="background-color: green;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                    <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
             <table class="table table-hover">
                <tbody>
                <?php
                    $ctAutosRV=0;
                    foreach($autos_renovadas[0]as $rowAutos){
                        $row_autos=$this->cuadromando_model->getRenovacionRenovada($rowAutos);
                        $ctAutosRV++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_autos->Documento?></td>
                                
                                <td><?php echo $row_autos->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->fechaInsersion))?></td>
                                <td><?php echo number_format($row_autos->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaTotal,2);?></td>
                                <td><?php echo $row_autos->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
        <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctAutosRV;?></b>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
         <table class="table table-hover" style="font-size: 12px;">
                <thead>
                <tr style="background-color: orange;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                    <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%">
            <table class="table table-hover">
                <tbody>
                <?php
                    $ctAutosRA=0;
                    foreach($autos_renovadas[1]as $rowAutos){
                        $row_autos=$this->cuadromando_model->getRenovacionRenovada($rowAutos);
                        $ctAutosRA++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_autos->Documento?></td>
                                
                                <td><?php echo $row_autos->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->fechaInsersion))?></td>
                                <td><?php echo number_format($row_autos->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaTotal,2);?></td>
                                <td><?php echo $row_autos->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctAutosRA;?></b>
        </div>
        <!--fin Amarillo-->

         <!--Inicio Rojo-->
         <table class="table table-hover">
            <thead>
            <tr style="background-color: red;">
                <th>Documento</th>
                
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Fecha&nbsp;Insersion</th>
                <th>Prima Neta</th>
                <th>Prima Neta Nueva</th>
                <th>Prima Total</th>
                <th>Moneda</th>
                 <th><i class="fa fa-cogs"></th>
            </tr>
            </thead>
        </table>
        <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
            <table class="table table-hover">
               <tbody>
                <?php
                    $ctAutosRR=0;
                    foreach($autos_renovadas[2]as $rowAutos){
                        $row_autos=$this->cuadromando_model->getRenovacionRenovada($rowAutos);
                        $ctAutosRR++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_autos->Documento?></td>
                                
                                <td><?php echo $row_autos->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->fechaInsersion))?></td>
                                <td><?php echo number_format($row_autos->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaTotal,2);?></td>
                                <td><?php echo $row_autos->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctAutosRR;?></b>
        </div>
        <!--fin Rojo-->
         <!--Fin de Autos-->
    </div>


<!--Daños-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <p id="DaniosR">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px">
        <i class="fa fa-list"></i> Detalles de polizas: <b>Renovadas</b>
    </div>
    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-bolt"></i> Daños</h4>
    </div>
     
        <!--Inicio Verde-->
       <table class="table table-hover" style="font-size: 12px;">
                <thead>
                <tr style="background-color: green;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
             <table class="table table-hover">
                <tbody>
                <?php
                    $ctDaniosRV=0;
                    foreach($danios_renovadas[0]as $rowDanios){
                        $row_danios=$this->cuadromando_model->getRenovacionRenovada($rowDanios);
                        $ctDaniosRV++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_danios->Documento?></td>
                                
                                <td><?php echo $row_danios->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->fechaInsersion))?></td>
                                <td><?php echo number_format($row_danios->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_danios->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_danios->PrimaTotal,2);?></td>
                                <td><?php echo $row_danios->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
        <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctDaniosRV;?></b>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
         <table class="table table-hover">
                <thead>
                <tr style="background-color: orange;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%">
            <table class="table table-hover">
                <tbody>
                <?php
                    $ctDaniosRA=0;
                    foreach($danios_renovadas[1]as $rowDanios){
                        $row_danios=$this->cuadromando_model->getRenovacionRenovada($rowDanios);
                        $ctDaniosRA++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_danios->Documento?></td>
                                
                                <td><?php echo $row_danios->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_autos->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->fechaInsersion))?></td>
                                <td><?php echo number_format($row_danios->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_autos->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_danios->PrimaTotal,2);?></td>
                                <td><?php echo $row_danios->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctDaniosRA;?></b>
        </div>
        <!--fin Amarillo-->
         <!--Inicio Rojo-->
         <table class="table table-hover">
            <thead>
            <tr style="background-color: red;">
                <th>Documento</th>
                
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Fecha&nbsp;Insersion</th>
                <th>Prima Neta</th>
                <th>Prima Neta Nueva</th>
                <th>Prima Total</th>
                <th>Moneda</th>
                 <th><i class="fa fa-cogs"></th>
            </tr>
            </thead>
        </table>
        <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
            <table class="table table-hover">
               <tbody>
                <?php
                    $ctDaniosRR=0;
                    foreach($danios_renovadas[2]as $rowDanios){
                        $row_danios=$this->cuadromando_model->getRenovacionRenovada($rowDanios);
                        $ctDaniosRR++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_danios->Documento?></td>
                                
                                <td><?php echo $row_danios->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_danios->fechaInsersion))?></td>
                                <td><?php echo number_format($row_danios->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_danios->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_danios->PrimaTotal,2);?></td>
                                <td><?php echo $row_danios->Moneda?></td>
                                <td>
                                   <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctDaniosRR;?></b>
    </div>
</div>
<!--fin Rojo-->
<!--FiN DAÑOS-->


<!--Segmentacion de Lineas Personales: Accidentes y Enfermedades, Vida -->
<!--Accidentes y Enfermedades-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <p id="AccidentesR">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px">
        <i class="fa fa-list"></i> Detalles de polizas: <b>Renovadas</b>
    </div>
    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-heartbeat"></i> Accidentes y Enfermedades</h4>
    </div>
        <!--Inicio Verde-->
       <table class="table table-hover">
                <thead>
                <tr style="background-color: green;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
             <table class="table table-hover">
                <tbody>
                <?php
                    $ctVidasRV=0;
                    foreach($vidas_renovadas[3]as $rowVidas){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRV++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_vidas->Documento?></td>
                                
                                <td><?php echo $row_vidas->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                                <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                                <td><?php echo $row_vidas->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                            </td>
                        </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
        <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRV;?></b>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
         <table class="table table-hover">
                <thead>
                <tr style="background-color: orange;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%">
            <table class="table table-hover">
                <tbody>
                <?php
                    $ctVidasRA=0;
                    foreach($vidas_renovadas[4]as $rowVida){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRA++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_vidas->Documento?></td>
                                
                                <td><?php echo $row_vidas->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                                <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                                <td><?php echo $row_vidas->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRA;?></b>
        </div>
        <!--fin Amarillo-->
         <!--Inicio Rojo-->
         <table class="table table-hover">
            <thead>
            <tr style="background-color: red;">
                <th>Documento</th>
                
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Fecha&nbsp;Insersion</th>
                <th>Prima Neta</th>
                <th>Prima Neta Nueva</th>
                <th>Prima Total</th>
                <th>Moneda</th>
                 <th><i class="fa fa-cogs"></th>
            </tr>
            </thead>
        </table>
        <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
            <table class="table table-hover">
               <tbody>
                <?php
                    $ctVidasRR=0;
                    foreach($vidas_renovadas[5]as $rowVidas){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRR++;?>
                        <tr>
                             <tr>
                               
                                <td><?php echo $row_vidas->Documento?></td>
                                
                                <td><?php echo $row_vidas->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                                <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                                <td><?php echo $row_vidas->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                            </td>
                            </tr>
                        </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRR;?></b>
    </div>
</div>
    <!--fin Rojo-->
    <!--FiN Accidentes y Enfermedades-->



<!--Vida-->
<div class="well" style="background-color: #fff;padding: 15px;">
    <p id="VidasR">
    <div style="width: 100%;margin-right: 10%;text-align: right;font-size: 14px">
        <i class="fa fa-list"></i> Detalles de polizas: <b>Renovadas</b>
    </div>
    <div style="width: 100%;text-align: left;">
        <h4> <i class="fa fa-user"></i> Vida</h4>
    </div>
     
        <!--Inicio Verde-->
       <table class="table table-hover">
                <thead>
                <tr style="background-color: green;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
             <table class="table table-hover">
                <tbody>
                <?php
                    $ctVidasRV=0;
                    foreach($vidas_renovadas[0]as $rowVidas){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRV++;
                        ?>
                             <tr>
                                
                                <td><?php echo $row_vidas->Documento?></td>
                                
                                <td><?php echo $row_vidas->NombreCompleto?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                                <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                                <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                                <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                                <td><?php echo $row_vidas->Moneda?></td>
                                <td>
                                 <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                                </td>
                            </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
        <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRV;?></b>
        </div>
        <!--fin Verde-->

        <!--Inicio Amarillo-->
         <table class="table table-hover">
                <thead>
                <tr style="background-color: orange;">

                    <th>Documento</th>
                    
                    <th>Vendedor</th>
                    <th>Fecha&nbsp;Desde</th>
                    <th>Fecha&nbsp;Hasta </th>
                    <th>Fecha&nbsp;Insersion</th>
                    <th>Prima Neta</th>
                    <th>Prima Neta Nueva</th>
                    <th>Prima Total</th>
                    <th>Moneda</th>
                     <th><i class="fa fa-cogs"></th>
                </tr>
                </thead>
        </table>

         <div style="height: 300px;overflow: scroll;margin-bottom: 2%">
            <table class="table table-hover">
                <tbody>
                <?php
                    $ctVidasRA=0;
                    foreach($vidas_renovadas[1]as $rowVida){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRA++;
                        ?>
                        <tr>
                            
                            <td><?php echo $row_vidas->Documento?></td>
                            
                            <td><?php echo $row_vidas->NombreCompleto?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                            <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                            <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                            <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                            <td><?php echo $row_vidas->Moneda?></td>
                            <td>
                             <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                            </td>
                        </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRA;?></b>
        </div>
        <!--fin Amarillo-->
         <!--Inicio Rojo-->
         <table class="table table-hover">
            <thead>
            <tr style="background-color: red;">
                <th>Documento</th>
                
                <th>Vendedor</th>
                <th>Fecha&nbsp;Desde</th>
                <th>Fecha&nbsp;Hasta </th>
                <th>Fecha&nbsp;Insersion</th>
                <th>Prima Neta</th>
                <th>Prima Neta Nueva</th>
                <th>Prima Total</th>
                <th>Moneda</th>
                <th><i class="fa fa-cogs"></th>
            </tr>
            </thead>
        </table>
        <div style="height: 300px;overflow: scroll;margin-bottom: 2%;">
            <table class="table table-hover" style="font-size: 12px;">
               <tbody>
                <?php
                    $ctVidasRR=0;
                    foreach($vidas_renovadas[2]as $rowVidas){
                        $row_vidas=$this->cuadromando_model->getRenovacionRenovada($rowVidas);
                        $ctVidasRR++;?>
                        <tr>
                            
                            <td><?php echo $row_vidas->Documento?></td>
                            
                            <td><?php echo $row_vidas->NombreCompleto?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->FDesde));?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->FHasta))?></td>
                            <td><?php echo date("d-m-Y", strtotime($row_vidas->fechaInsersion))?></td>
                            <td><?php echo number_format($row_vidas->PrimaNeta,2);?></td>
                            <td><?php echo number_format($row_vidas->PrimaNetaNueva,2);?></td>
                            <td><?php echo number_format($row_vidas->PrimaTotal,2);?></td>
                            <td><?php echo $row_vidas->Moneda?></td>
                            <td>
                            <a href="#" data-toggle="modal" data-target="#comentarios"><button type="button" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></button></a>
                           </td>
                        </tr>
                    <?php
                    }?>
                </tbody>
            </table>
        </div>
         <div style="width: 100%;text-align: right;margin-bottom: 4%;padding-right: 3%;font-size: 16px">Total de Documentos:&nbsp;<b><?php echo $ctVidasRR;?></b>
    </div>
</div>
    <!--fin Rojo-->
    <!--FiN Vida-->



<!--Modal de Comentarios-->

<div id="comentarios" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;font-size: 12px;">
  <!-- Modal content-->
    <div class="modal-content" style="width: 130%;">
      <div class="modal-header">
        <h5 class="modal-title" style="color: #fff;"><i class="fa fa-edit"></i>&nbsp;Comentario Referente a la Poliza:<span id="numPoliza"></span></h5>
      </div>
      <div class="modal-body" style="width: 100%;">
        <br>
        <div class="well">
        <table style="width: 100%">
          <input type="hidden" name="id_edit" id="id_edit">
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Comentario: </span></td>
            <td><textarea name="comentarios_edit" id="comentarios_edit" cols="75" rows="4"></textarea></td>
          </tr>
        </table>
        </div>
      </div>
       <div class="modal-footer">
        <table>
          <tr>
            <td><button type="button" class="btn btn-warning btn-md" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar
            <td>&nbsp;</td>
            <td><button type="button" class="btn btn-primary btn-md" onclick="guardar_comentarios()" data-dismiss="modal"><i class="fa fa-check"></i> Aceptar</button></td>
            </button>
            </td>
          </tr>
        </table>
       </div>
    </div>
  </div>
</div>

<input type="hidden" id="totalVerdesPendientes" value="<?php echo $totalVerdesPendientes;?>">
<input type="hidden" id="totalAmarillosPendientes" value="<?php echo $totalAmarillosPendientes;?>">
<input type="hidden" id="totalRojosPendientes" value="<?php echo $totalRojosPendientes;?>">

</div>
