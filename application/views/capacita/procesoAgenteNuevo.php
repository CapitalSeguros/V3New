<?php 
    $this->load->view("capacita/menu_capacita")
?>
<div class="container" style="margin-right: 0px;">
    <h2 class="mt-4 title-capacita">Seguimiento del agente nuevo</h2>
    <hr>
    <div  class="card" style="width: 50%; border: 1px black solid; margin: 0 auto; margin-top:40px;">
        <div class="card-header">
            <?php foreach($datosPersonales as $datos) {?>
                <div class="jumbotron">
                    <h3 class="display-4"><?=$datos->nombres." ".$datos->apellidoPaterno." ".$datos->apellidoMaterno?></h3>
                </div>
                <div class="card-body" style="font-size: 10px">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Email creador: </td>
                            <td colspan="2"><?=$datos->userEmailCreacion?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-center">Datos de capacidades</td>
                        </tr>
                        <tr>
                            <td class="text-center">Capacidad</td>
                            <td class="text-center">Acreditación</td>
                            <td class="text-center">Evaluación</td>
                        </tr>
            <?php  if(!empty($capacitacionActiva)) {
                foreach($capacitacionActiva as $orden){?> 
                <tr>
                    <?php foreach($orden as $capacita=>$valor) {
                        $capacidad="";
                        if($capacita=="miinfo"){
                            $capacidad="Mi Info";
                        } elseif($capacita=="induccionempresa"){
                            $capacidad="Inducción empresa";
                        }
                        elseif($capacita=="manualagente"){
                            $capacidad="Manual agente";
                        }
                        elseif($capacita=="agenteideal"){
                            $capacidad="Agente ideal";
                        }
                        elseif($capacita=="capacitacionsistema"){
                            $capacidad="Capacitación sistema";}?> 
                    
                        <td><b><i class="fa fa-cube" aria-hidden="true"></i>&nbsp<?=$capacidad?></b></td>

                        <?php if(!empty($valor)){?> 
                            <td class="text-success text-center"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbspACREDITADO</td>
                        <?php if($valor["evaluacion"]>0){?> 
                            <td class="text-success text-center"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbspSOLICITADA</td>
                        <?php } else{?>
                            <td class="text-danger text-center"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbspNO SOLICITADA</td>
                         <?php }?>
                        <?php } else{?> 
                            <td class="text-danger text-center"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbspNO VALIDADO</td>
                            <td class="text-danger text-center"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbspNO SOLICITADA</td>
                        <?php }?>
                    <?php }?>
                </tr>
            <?php } 
            } else{ ?> 
            
                <tr><td colspan=3><h4 class="text-center">No hay datos por el momento</h4></td></tr>
            <?php }?>
                    </tbody>
                </table>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<!--<div class="row" style="">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo creador</th>
                <th>Mi Info</th>
                <th>Induccion empresa</th>
                <th>Manual Agente</th>
                <th>Agente Ideal</th>
                <th>Capacitacion del Sistema</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php foreach($datosPersonales as $datos){?>
                    <td><?=$datos->nombres." ".$datos->apellidoPaterno." ".$datos->apellidoMaterno?></td>
                    <td><?=$datos->userEmailCreacion?></td>
                <?php foreach($capacitacionActiva as $valor) {
                    foreach($valor as $key=>$info) {
                        if(!empty($info)) {?> 
                    <td class="text-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbspValidado</td>
                    
                <?php } else {?>
                    <td class="text-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbspNo validado</td>
            <?php } } }?>
                <?php }?>
            </tr>
        </tbody>
    </table>
</div>-->