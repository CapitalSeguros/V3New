<?php

function status($st){
  if($st=="DIMENSION"){
    $st="SUSPECTO";
  }
  return $st;
}
?>


<style type="text/css">
  #div_link{
    list-style: none;
    background-color: #361666;
    color: #fff;
    margin-bottom: 1%;
    width: 87%;
    padding: 2px; 
    padding-left: 10px;
    margin-left: -3%;
  }
  #div_cierre, #div_primera, #div_leads{
   margin-left: -3%; 
  }
</style>
<div id="div_notificaciones_pendientes">
<div class="container" style="margin-top: 5%;">
<div class="row">
  <div class="col-md-12">
    <div style="font-size: 14px;margin-bottom: 1%;">
      <b><i class="fa fa-bell"></i> NOTIFICACIÓNES PENDIENTES</b><br>
      <b>Fecha Actual:</b> <?php echo date('d-m-Y');?>
    </div>
    <ul>
      <a href="#" onclick="abrir_lista_primera()">
        <li id="div_link"><i class="fa fa-chevron-circle-down"></i> Lista de Prospectos Rezagados para Primera Cita</li>
      </a>
    <div id="div_primera" style="display: none;">
    <table class="table table-responsive table-bordered" style="font-size: 12px; width: 85%">
      <thead>
        <tr>
          <th colspan="5" style="background-color: #E6E6E6;color: #000;">
            <span style="font-size: 16px;">Lista de Prospectos Rezagados para Primera Cita</span>
          </th>
        </tr>
        <tr style="color: #fff;">
          <td><i class="fa fa-cogs"></i></td>
          <td><i class="fa fa-tag"></i> ID</td>
          <td><i class="fa fa-user"></i> Nombre del Prospecto</td>
          <td><i class="fa fa-tag"></i> Estado</td>
          <td><i class="fa fa-calendar"></i> Fecha de Ultima actividad</td>
        </tr>
      </thead>
      <tbody>
        <?php 
        if(count($primeracita)>0){
          foreach($primeracita as $row){
            //MODIFICACION
            $nombre=$this->crmProyecto_Model->nombreCliente($row->IDCli);
          ?>

          <tr>
            <td><input type="checkbox" name="chk"></td>
            <td><?php echo $row->IDCli;?></td>
            <td><?php echo $nombre;?></td>
            <td><?php echo status($row->EstadoActual);?></td>
            <td><?php echo date("d/m/Y", strtotime($row->fechaActualizacion));?></td>
          </tr>
        <?php }
      }else{?>
          <tr>
            <td colspan="5">
              <div class="alert alert-info" style="text-align: center;">
               <i class="fa fa-info-circle"></i> No se encontraron registros
              </div>
            </td>
          </tr>
      <?php }?>
      </tbody>
    </table>
</div>
<a href="#" onclick="abrir_lista_cierre()">
<li id="div_link"><i class="fa fa-chevron-circle-down"></i> Lista de Prospectos Rezagados para Cierre</li>
</a>
<div id="div_cierre" style="display: none;">
     <table class="table table-responsive table-bordered" style="font-size: 12px; width: 85%">
      <thead>
        <tr>
          <th colspan="5" style="background-color: #E6E6E6;color: #000;">
            <span style="font-size: 16px;">Lista de Prospectos Rezagados para Cierre</span>
          </th>
        </tr>
        <tr style="color: #fff;">
          <td><i class="fa fa-cogs"></i></td>
          <td><i class="fa fa-tag"></i> ID</td>
          <td><i class="fa fa-user"></i> Nombre del Prospecto</td>
          <td><i class="fa fa-tag"></i> Estado</td>
          <td><i class="fa fa-calendar"></i> Fecha de Ultima actividad</td>
        </tr>
      </thead>
      <tbody>
        <?php 
       if(count($cierre)>0){
          foreach($cierre as $row){
             $nombre=$this->crmProyecto_Model->nombreCliente($row->IDCli);
          ?>

          <tr>
            <td><input type="checkbox" name="chk"></td>
            <td><?php echo $row->IDCli;?></td>
            <td><?php echo $nombre;?></td>
            <td><?php echo status($row->EstadoActual);?></td>
            <td><?php echo date("d/m/Y", strtotime($row->fechaActualizacion));?></td>
          </tr>
        <?php }
      }else{?>
          <tr>
            <td colspan="5">
              <div class="alert alert-info" style="text-align: center;">
               <i class="fa fa-info-circle"></i> No se encontraron registros
              </div>
            </td>
          </tr>
      <?php }?>

      </tbody>
    </table>
</div>
 <a href="#" onclick="abrir_lista_leads()">
    <li id="div_link"><i class="fa fa-chevron-circle-down"></i> Alerta Leads Rezagados</li>
  </a>
<div id="div_leads" style="display: none;">
     <table class="table table-responsive table-bordered" style="font-size: 12px; width: 85%">
      <thead>
        <tr>
          <th colspan="5" style="background-color: #E6E6E6;color: #000;">
            <span style="font-size: 16px;">Alerta Leads Rezagados</span>
          </th>
        </tr>
        <tr style="color: #fff;">
          <td><i class="fa fa-cogs"></i></td>
          <td><i class="fa fa-tag"></i> ID</td>
          <td><i class="fa fa-user"></i> Nombre del Prospecto</td>
          <td><i class="fa fa-tag"></i> Estado</td>
          <td><i class="fa fa-calendar"></i> Fecha de Ultima actividad</td>
        </tr>
      </thead>
      <tbody>
        <?php 
        if(count($leads)>0){
          foreach($leads as $row){
             $nombre=$this->crmProyecto_Model->nombreCliente($row->IDCli);
          ?>

          <tr>
            <td><input type="checkbox" name="chk"></td>
            <td><?php echo $row->IDCli;?></td>
            <td><?php echo $nombre;?></td>
            <td><?php echo status($row->EstadoActual);?></td>
            <td><?php echo date("d/m/Y", strtotime($row->fechaActualizacion));?></td>
          </tr>
        <?php }
      }else{?>
          <tr>
            <td colspan="5">
              <div class="alert alert-info" style="text-align: center;">
               <i class="fa fa-info-circle"></i> No se encontraron registros
              </div>
            </td>
          </tr>
      <?php }?>

      </tbody>
    </table>
</div>
<!--Agregamos la lista de pendiente de Alertas de Las tareas!-->
<a href="#" onclick="abrir_lista_tareas()">
    <li id="div_link"><i class="fa fa-chevron-circle-down"></i> Alerta Avisos de Tareas</li>
</a>
<div id="div_tareas" style="display: none;">
     <table class="table table-responsive table-bordered" style="font-size: 12px; width: 85%">
     <thead>
        <tr>
          <th colspan="5" style="background-color: #E6E6E6;color: #000;">
            <span style="font-size: 16px;">Alerta Tareas</span>
          </th>
        </tr>
        <tr style="color: #fff;">
          <td><i class="fa fa-cogs"></i></td>
          <td><i class="fa fa-tag"></i> ID</td>
          <td><i class="fa fa-user"></i> Nombre de la Tarea</td>
          <td><i class="fa fa-tag"></i> Estado</td>
          <td><i class="fa fa-calendar"></i> Fecha de Ultima actividad</td>
        </tr>
      </thead>
      <tbody>
        <?php 
        if(count($tareas)>0){
          foreach($tareas as $row){
            //MODIFICACION
            //$nombre=$this->crmProyecto_Model->nombreCliente($row->IDCli);
          ?>

          <tr>
            <td><a href="#" onclick="enviaTarea(<?php echo $row->idtarea;?>)">Enviar</a></td>
            <td><?php echo $row->idtarea;?></td>
            <td><?php echo $row->nombre;?></td>
            <td><?php echo status($row->ALERTA);?></td>
            <td><?php echo date("d/m/Y", strtotime($row->fechaalerta));?></td>
          </tr>
        <?php }
      }else{?>
          <tr>
            <td colspan="5">
              <div class="alert alert-info" style="text-align: center;">
               <i class="fa fa-info-circle"></i> No se encontraron registros
              </div>
            </td>
          </tr>
      <?php }?>
      </tbody>
     </table>
</div>
<!--Termina Alerta de Tareas!-->
</ul>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript"> 
/***Pestañas de lista de notificaciones ****/

$sw=0;
function enviaTarea($idtarea){
  
}
function abrir_lista_tareas(){
  
 if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_tareas').style.display='block';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_tareas').style.display='none';
  }
}

function abrir_lista_primera(){
if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='block';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_tareas').style.display='none';
  }
}

function abrir_lista_cierre(){
  if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_cierre').style.display='block';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_tareas').style.display='none';
  }
}


function abrir_lista_leads(){
  if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_leads').style.display='block';
    document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
  }
}

</script>
