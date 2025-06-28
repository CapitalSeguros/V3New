<?php
  $this->load->view('headers/header'); 
  $this->load->view('headers/menu');
?>
<!-- End navbar -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<style type="text/css">
  #navbarNav ul li a{
    font-size: 11px;
    font-family: arial;
    font-weight: bold;
    color: #08298A;
  }
  .btn-primary {
    color: #fff;
    background-color: #67439f;
    border-color: #57348c;
  }
  .btn-primary:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
  .panel{
    background-color: #fff;
    padding: 10px;
    border-radius: 8px;
    width: 10%;
    margin-top: 10px;
    float: left;
  }
  .panel_botones{
    background-color: #fff;
    width: 10%;
    border-radius: 8px;
    float: left;
    padding: 12px;
    padding-top: 20px;
    height:auto;
    margin-top: -10px;
  }
  .boton{
    border-style: solid;
    border-color: #000;
    border-radius: 8px;
    border-width: 1px;
    margin-bottom: 10%;
    padding: 5%;
    text-align: center;
    color: #000;
  }
  .lbboton{
    font-size: 10px;font-weight: bold;
  }
  /**/
  .table-thead {
      position: sticky;
      top: 0;
      z-index: 2;
  }
  .card-header {
      font-size: 13px;
  }
  .text-center {
      font-size: 13px;
  }
  .column-grid {
      display: flex;
      flex-direction: column;
      align-items: center;
  }
  .form-check {
      display: flex;
      align-items: center;
  }
  label {
      font-size: 13px;
      margin: 0px;
  }
  button.btn {
      font-size: 13px;
  }
  select.form-control:not([size]):not([multiple]) {
      font-size: 13px;
      height: auto;
  }
  .title-capacita {
    font-size: 2rem;
    color: #472380;
  }
  #nav-capacita {
    padding: 0px;
    z-index: 1;
    border: 2px solid #ddd;
    border-style: double;
  }
  #navbar-capacita {
    font-size: 14px;
    height: 61px!important;
  }
  #navbar-capacita.navbar-nav>li>a {
      line-height: 1.42857143;
      border: 1px solid transparent;
      color: #555;
      height: 100%;
      max-height: max-content;
      display: flex;
      align-items: center;
  }
  #navbar-capacita.navbar-nav>li>a>i {
      margin-right: 3px;
      margin-top: -2px;
  }
  #navbar-capacita.navbar-nav>li>a:hover {
      background: #cf7724;/*rgb(207,119,36); | #da914c*/
      color: white;
  }
  .panel_botones > table > tbody > tr > td > a:hover {
      text-decoration: none;
      filter: drop-shadow(0px 1px 2px gray);
  }
  .panel_botones > table > tbody > tr > td > a:hover > div > img,
  .panel_botones > table > tbody > tr > td > a:hover > div > i {
      
  }
  div.container {
    width: 100%;
    max-width: 90%;
  }
  .icon-upload-revista {
    font-size: 70px;
    padding-top: 5px;
    padding-bottom: 10px;
  }
</style>
<?php 
$user= $this->tank_auth->get_user_id();
$perfil= $this->tank_auth->get_userprofile();
$sw=0;
$sw1=0;
//Administrar
if(($user==224)||($user==6)){
  $sw=1;
}

//Coordinadores
if(($perfil==3)||($perfil==4)){
  $sw1=1;
}


?>

<nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav-capacita">
  <img href="<?=base_url()?>capacita" src="<?php echo base_url(); ?>assets/images/logo_capacita.png" style="padding:3px;width: 190px;">
  <div class="collapse navbar-collapse" id="navbarNav" style="height: 61px!important;">
    <ul class="navbar-nav" id="navbar-capacita">
      <?php
        if($sw==1){
      ?>
       <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>capacita"><i class="fa fa-cogs"></i> ADMINISTRACIÓN</a>
      </li>
    <?php }?>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>capacita/videos"><i class="fa fa-video-camera"></i> VIDEOS</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#" onclick="window.open('https://www.dropbox.com/sh/3txhtwzoketivnz/AAAwir5FfwmgcnHVoCBNX3I4a?dl=0', 'new');"><i class="fa fa-download"></i> DESCARGABLES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>capacita/revistas">
          <!-- onclick="window.open('http://agentecapital.com/Revistas/', 'new');" -->
          <i class="fa fa-newspaper-o"></i> REVISTAS
        </a>
      </li>
  <li class="nav-item">
        <!-- <a class="nav-link" href="#" onclick="window.open('https://docs.google.com/forms/d/e/1FAIpQLSdnxipcQd9MnJB57S7bXUEotFQHN0Ie-GahexiupAu6UuGSfA/viewform', 'new');"><i class="fa fa-university"></i>CAPACITACION EXTERNA</a> -->
        <a class="nav-link" href="<?=base_url()?>capacita/CapacitacionExterna"><i class="fa fa-university"></i>CAPACITACIÓN EXTERNA</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>"><i class="fa fa-times-circle"></i>SALIR</a>
      </li>
    </ul>
  </div>
</nav>
<?php
    if($sw1==1){
?>
<div class="panel_botones">
  <?php
    if($sw==1){
  ?>
  <table>
    <tr>
      <td>
        <a href="<?=base_url()?>capacita/cargarvideos">
        <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\subir_video.png')?>" width="100%;">
          <span class="lbboton">Subir Video</span>
        </div>
         </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="<?=base_url()?>capacita/subir_revista">
        <div class="boton">
          <i class="fas fa-cloud-upload-alt icon-upload-revista"></i>
          <span class="lbboton">Subir Revista</span>
        </div>
         </a>
      </td>
    </tr>
    <!--<tr>
      <td>
        <a href="#"  onclick="window.location.href='<?=base_url('persona/resumenGeneral')?>'">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_general.png')?>" width="70%;">
          <span class="lbboton">Resumen General de Capacitación</span>
        </div>
        </a>
      </td>
    </tr>-->
  <?php }?>
  <tr>
      <td>
        <a href="<?=base_url()?>capacita/gestionaCapacitacion">
        <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\asignacion.png')?>"width="70%;">
          <span class="lbboton">Asignación de Capacitación</span>
        </div>
         </a>
      </td>
    </tr>
      <td>
        <a href="<?=base_url()?>capacita/reporteDeCapacitacionManual">
        <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_capacitacion.png')?>" width="70%"><br>
          <span class="lbboton">Mi capacitación</span>
        </div>
         </a>
      </td>
    </tr>
     <!--<tr>
      <td>
        <a href="<?=base_url()?>evaluaciones">
        <div class="boton">
        <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_capacitacion.png')?>" width="100%;">
          <span class="lbboton">Evaluaciónes</span>
        </div>
        </a>
      </td>
    </tr>-->
   <!--<tr>
      <td>
        <a href="#" data-toggle="modal" data-target=".capacitacion">
        <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\asignacion.png')?>" width="70%;">
          <span class="lbboton">Asignación de Capacitación</span>
        </div>
         </a>
      </td>
    </tr>-->
    <tr>
      <td>
        <a href="<?=base_url('capacita/reporteGeneral')?>">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_general.png')?>" width="100%;">
          <span class="lbboton">Reportes Capacitación</span>
        </div>
        </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="<?=base_url('persona/agentesEnProceso')?>">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_general.png')?>" width="70%;">
          <span class="lbboton">Inducción</span>
        </div>
        </a>
      </td>
    </tr>
    <tr>
          <td>
            <a href="<?=base_url()?>persona/agenteNuevoEnProceso">
            <div class="boton">
              <img src="<?php echo(base_url().'assets\images\agrega_agentes\bloc.png')?>" width="100%;">
              <span class="lbboton">Seguimiento de inducción</span>
            </div>
            </a>
          </td>
        </tr>
        <tr>
          <td>
            <a href="<?=base_url()?>crearLiga/crear_liga_reunion_enviados">
            <div class="boton">
              <img src="<?php echo(base_url().'assets\images\agrega_agentes\calendario.png')?>" width="100%;">
              <span class="lbboton">Consultar convocatorias de capacitación</span>
            </div>
            </a>
          </td>
        </tr>
  </table>
</div>
    <?php }  else{ ?> 
      <div class="panel_botones">
      <table>
      </tr>
        <td>
          <a href="<?=base_url()?>capacita/reporteDeCapacitacionManual">
          <div class="boton">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_capacitacion.png')?>" width="70%"><br>
            <span class="lbboton">Mi capacitación</span>
          </div>
          </a>
        </td>
      </tr>
      <tr>
          <td>
            <a href="<?=base_url()?>persona/agenteNuevoEnProceso">
            <div class="boton">
              <img src="<?php echo(base_url().'assets\images\agrega_agentes\bloc.png')?>" width="100%;">
              <span class="lbboton">Seguimiento de inducción</span>
            </div>
            </a>
          </td>
        </tr>
        </tr>
        <tr>
          <td>
            <a href="<?=base_url()?>capacita/viewInducctionDocs">
            <div class="boton">
              <img src="<?php echo(base_url().'assets\images\agrega_agentes\bloc.png')?>" width="100%;">
              <span class="lbboton">Ver documentos de inducción</span>
            </div>
            </a>
          </td>
        </tr>
      </table>
      </div>
    <?php }?>

<!-- 
  menu_capacita
  principal
  gestionHorasCapacitacion
  bundle-capacitaciones.js
  reporteCapacitacionManual
  reporteGeneral
  dashboard
  reports
  agentesEnProceso
  procesoAgenteNuevo
  viewInduccionDocs
  crear_liga_reunion_enviados
  videos
-->

