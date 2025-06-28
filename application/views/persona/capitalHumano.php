<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
 <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
<script type="text/javascript">
 window.onload=function() {
    document.body.setAttribute('onpaste','manejarCopiado()');}
   function manejarCopiado(){}
</script>
<style type="text/css">
  button:active, button.btn:active { outline: 0; }
  button:focus, button.btn:focus { outline: 0; }
  .subMenuPuesto{position: relative;left:70px;top:-80px;z-index: 100;background-color: white;color:#472380;display: none;border: solid #472380 1px;height: 120%}
  .subMenuPuesto li{list-style: none;border:solid 1px;}
  .subMenuPuesto li:hover{color: white;background-color:#565556;}
  .boton:hover  ul {display: block;}
  .contenido{display: flex;/*margin-left: 40px;*/width: 100%;align-items: stretch;}
  .contenidoPrincipal{display: flex;flex-direction: column;padding: 15px 25px;width: 100%;transition: all 0.3s;}
  #archivoImagen {
      display: none;
  }
  #archivoDocumento {
      display: none;
  }
  #employmentMission {
    color: #3d3d3d;
    font-size: 13px;
  }
  .panel_botones{
    background-color: #fff;
    min-width: 125px;
    max-width: 125px;
    /*width: 10%;*/
    /* border-radius: 8px; */
    float: left;
    /* margin-left: -40px; */
    padding: 5px;
    /* padding-top: 20px; */
    /* margin-right: 15px; */
    height: auto;
    /* margin-top: 2px; */
    border-right: 1px solid #e1e1e1;
    transition: all 0.3s;
  }
  .boton{
    border: 1px solid #a892cb;
    border-radius: 8px;
    border-width: 1px;
    /*margin-top: -3%;
    margin-bottom: -3%;*/
    text-align: center;
    max-height: 110px;
    max-width: 110px;
    cursor: pointer;
    transition: 0.3s;
    background: #fcfbff;
    padding: 3px;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  .boton:hover {
    background: #f0f2ff;
    border-color: #bec3e1;
    transition: 0.3s;
  }
  .lbboton{
    font-size: 12px;font-family: verdana;
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
  #modal-file-manager-preview, #subir_organigrama, #subir_documento,#modal, #visor_pdf, #subir_organigrama {
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 1050;
  }
  #modal-file-manager-preview, #subir_organigrama, #subir_documento,#modal, #visor_pdf, #modal-doc-details {
   background-color: rgba(0, 0, 0, 0.08);
  }
  #subir_organigrama {
    background: rgba(0, 0, 0, 0.16);
  }
  #BtnMenuPuestos.active {
    margin-left: -125px;
  }
  #PanelBotonesPuesto td {
    padding: 5px 10px;
  }
  #tab_capa.nav-tabs, #tab_alta_puesto.nav-tabs {
      font-size: 14px;
      /*border-bottom: 1px solid #dee2e6;
      background: transparent;*/
      width: 100%;
  }
  #tab_capa.nav-tabs > li, #tab_info_puesto.nav-tabs > li, #tab_alta_puesto.nav-tabs > li {
      margin-bottom: -1px;
  }
  #tab_capa.nav-tabs>li>a.active, #tab_capa.nav-tabs>li>a.active:focus, #tab_capa.nav-tabs>li>a.active:hover,
  #tab_info_puesto.nav-tabs>li>a.active, #tab_info_puesto.nav-tabs>li>a.active:focus, #tab_info_puesto.nav-tabs>li>a.active:hover,
  #tab_alta_puesto.nav-tabs>li>a.active, #tab_alta_puesto.nav-tabs>li>a.active:focus, #tab_alta_puesto.nav-tabs>li>a.active:hover {
      /*color: #472380;
      cursor: default;
      background-color: #fff;
      border: 1px solid #ddd;
      border-bottom-color: transparent;*/
      background-color: #5f3c97;
  }
  #tab_capa.nav-tabs>li>a, #tab_info_puesto.nav-tabs>li>a, #tab_alta_puesto.nav-tabs>li>a {
      /*margin-right: 2px;*/
      line-height: 1.42857143;
      border: 1px solid transparent;
      /*border-radius: 4px 4px 0 0;*/
      color: white; /*#555*/
  }
  #tab_capa.nav-tabs>li>a:hover, #tab_info_puesto.nav-tabs>li>a:hover, #tab_alta_puesto.nav-tabs>li>a:hover {
      background:#472380;
      color: white;
  }
  /*#tab_capa.nav-tabs>li {
      float: left;
      margin-bottom: -1px;
  }*/
  #contenedor_capa.tab-content, #contenedor_info_puesto.tab-content, #contenedor_alta_puesto.tab-content {
      font-size: 13px;
      border: 1px solid #dee2e6;
      border-top: transparent;
      position: relative;
      box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);
  }
  #upload-files-employee, #upload-files-employee > div.dropdown {
    height: 100%;
  }
  #upload-files-employee > div.dropdown > a, .btn-dropdown {
    height: 100%;
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
    transition: 0.3s;
  }
  #upload-files-employee > div.dropdown:hover, .btn-dropdown:hover {
    color: white;
    background: #654a91;
    transition: 0.3s;
  }
  #upload-files-employee .nav .open>a, .nav .open>a:focus, .nav .open>a:hover, .nav .open>a {
    background-color: #654a91;
    border-color: #654a91;
  }
  #TablaGrupoPuestosNuevos > tbody > tr.danger > td, #TablaPuestosGrupos > tbody > tr.danger > td {
    border-top: 1px solid #ffffff;
  }
  #modal-upload-container > div.modal-dialog > div.modal-content > .modal-header > button {
    margin-top: -1rem;
    color: #dff0ff;
    transition: 0.3s;
    /*opacity: .5;*/
  }
  #modal-upload-container > div.modal-dialog > div.modal-content > .modal-body > h5 {
    font-size: 15px;
    text-align: center;
  }
  #modal-upload-container table > thead > tr > th {
    font-size: 13px;
  }
  #modal-upload-container table > tbody > tr > td, #modal-upload-container table > tbody > tr > td > .label {
    font-size: 12px;
    font-weight: 500;
  }
  #nav-general-dashboard > li {
    width: 100%;
  }
  #nav-general-dashboard > li > a:hover {
    color: white;
    background: #636ec1;
  } 
  #TablaVacaciones tbody > tr > td, #TablaVacaciones tbody > tr > td > .label, #TablaAsistencias tbody > tr > td {
    font-size: 12px;
  }
  #TablaVacaciones_wrapper {
    margin-bottom: 5px;
  }
  #TablaVacaciones_filter label > input, #TablaAsistencias_filter label > input {
    border: 1px solid #a9aab9;
    outline: none;
    border-radius: 3px;
  }
  #tableFunctionsEmployment > tbody > tr > td:nth-child(1) {width: 56px;}
  #tableFunctionsEmployment > tbody > tr > td:nth-child(2) {width: 200px;}
  /*#tableFunctionsEmployment > tbody > tr > td:nth-child(3) {border: 1px solid #8897a9dd;border-radius: 40px;max-height: 200px;overflow: auto;}*/
  table > tbody > tr > td {
    font-size: 12px;
  }
  td > span.label { font-size: 12px; }
  table > tbody > tr.collapse.show.in, tr.show {
    display: table-row!important;
  }
  .css-nw3mfz, .css-1chpzqh {
    font-size: 11px;
  }
  .width-ajust {
    width: 100%;
    max-width: max-content;
  }
  .column-edit-puesto {
    display: flex;
    flex-direction: column;
  }
  .column-label {
    display: flex;
    align-items: center;
    font-weight: 500;
    font-size: 13px;
    color: #3c3c3c;
  }
  .column-label > i {
    color: #40709d;
  }
  .column-flex-center {
    display: flex;
    align-items: center;
  }
  .column-flex-bottom {
    display: flex;
    align-items: flex-end;
  }
  .column-flex-column {
    display: flex;
    flex-direction: column;
  }
  .content-info-puesto {
    width: 100%;
    height: 100%;
    position: absolute;
  }
  .col-spinner-puestos {
    width: 100%;
    height: 722px;
    position: absolute;
  }
  .col-spinner-verpuestos {
    width: 86%;
    height: 834px;
    position: absolute;
  }
  .col-spinner-altapuestos {
    width: 86%;
    height: 30%;
    position: absolute;
  }
  .col-spinner-documentacion {
    width: -webkit-fill-available;
    height: -webkit-fill-available;
    position: absolute;
  }
  .col-spinner-reportes {
    width: 86%;
    height: 100%;
    position: absolute;
  }
  .col-spinner-table-grupo-puestos {
    width: 86%;
    height: 100%;
    position: absolute;
  }
  .col-spinner-funcionespuestos {
    width: 86%;
    height: 834px;
    position: absolute;
  }
  .container-NT {
    height: 600px;
    overflow: auto;
    padding: 0px;
    border-radius: 5px;
    background: white;
  }
  .container-divBarTool {
    padding: 15px;
    background: white;
    box-shadow: 0px 2px 5px 0px rgb(23 23 23 / 5%);
  }
  .container-table-puestos {
    padding: 15px;
    border: 1px solid #74afb9;
    border-radius: 5px;
    border-style: dotted;
    background: #f7fbff;
  }
  .container-spinner-content-upload {
    margin: 0px;
    color: #266093;
    width: 100%;
    height: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    position: relative;
    background-color: rgb(255 255 255 / 75%);
    z-index: 1;
  }
  .container-spinner-content-loading {
    margin: 0px;
    color: #266093;
    width: 100%;
    height: 100%;
    align-items: center;
    display: flex;
    justify-content: center;
    position: relative;
    background-color: rgb(255 255 255 / 95%);
    z-index: 1;
    transition: all 0.3s;
  }
  .container-spinner-content-loading > .spinner-grow {
    width: 5rem;
    height: 5rem;
    margin-right: 10px;
  }
  .general-dashboard {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 3px 5px;
  }
  .general-dashboard > .row.mt-2 > div.col-md-2 > div.col-md-12 {
    padding: 15px;
    border-radius: 8px;
    background: #f1f1f1;
  }
  .general-dashboard > .row.mt-2 > div.col-md-10.tab-content {
    box-shadow: 0px 0px 3px 2px rgba(0, 0, 0, 0.10);
  }
  .btn-burguer {
    outline: none;
    background: transparent;
    border: none;
    color: #472380;
    padding: 3px;
    cursor: pointer;
    font-size: 18px;
  }
  .btn-divBarTool {
    color: white;
    background: #266093;
    border: 1px solid #266093;
    border-radius: 5px;
    cursor: pointer;
    outline: none;
    padding: 5px 8px;
    margin: 0px 5px;
    transition: 0.3s;
  }
  .btn-report-excel {
    outline: none;
    color: white;
    padding: 6px 8px;
    background: green;
    border: 1px solid #3d3d3d;
    border-radius: 5px;
    transition: 0.3s;
  }
  .btn-danger, .btn-success {
    color: white;
  }
  .btn-radius {
    font-weight: 600;
    padding: 9px 11px;
    border-radius: 5px;
  }
  .btn-function {
    color: #004f76;
    background: #e8eff4;
    font-size: 14px;
    padding: 5px 6px;
    border: 1px solid #dae4ee;
    border-radius: 4px;
    transition: 0.3s;
  }
  .btn-burguer:hover {
    color: #235480;
  }
  .btn-divBarTool:hover {
    color: white;
    background: #337ab7;
    border-color: #337ab7;
    transition: 0.3s;
  }
  .btn-function:hover {
    background: #cbdfee;
    border-color: #cbdfee;
  }
  /*Textos*/
  .title-center-puesto {
    text-align: center;
    margin-top: 5px;
    color: #062a4a;
  }
  .subtitle-center-puesto {
    text-align: center;
    color: #303030;
    font-size: 14px;
  }
  .label-warning {
    color: #3d3d3d;
  }
  .titleSection {font-size: 18px;color: black;/*color: #362380;margin-bottom: 0px;*/text-align: center;padding-top: 15px;}
  /*Otros*/
  .active-bar-spinner {
    width: 96%;
  }
  .opacity-spinner {
    opacity: .2;
  }
  .opacity-load {
    opacity: .2;
  }
  .box-s {
    box-shadow: 0px 1px 5px 1px #8370a1;
  }
  .table-width2 {
      max-width: 1178px;
    }
  .table-width3 {
    max-width: 1090px; /*1115px, 92%*/
  }
  .pd-left {
    padding-left: 0px;
  }
  .pd-right {
    padding-right: 0px;
  }
  .pd-top {
    padding-top: 15px;
  }
  .pd-bottom {
    padding-bottom: 15px;
  }
  .hr-step {
    margin: 5px 0px 5px 0px;
    border-top: 1px solid #677ca3;
  }
  .hr-divider {margin: 10px 0px 10px 0px;border-top: 1px solid #bfbfbf;}
  .td-step {border: 1px solid #8897a9dd;border-radius: 40px;max-height: 200px;overflow: auto;}
  .thead-procedure {background: #3958a1;color: white;position: sticky;top: 0;}
  /*Perfil*/
  .MsoListParagraphCxSpFirst, .MsoListParagraphCxSpMiddle, .MsoListParagraphCxSpLast {
    margin-left: 38.25pt;
  }
  /* Checkbox Bootstrap*/
    .form-check-input {
      width: 20px;
      height: 20px;
      margin-top: .25em;
      vertical-align: top;
      background-color: #fff;
      background-repeat: no-repeat;
      background-position: center;
      background-size: contain;
      border: 1px solid rgba(0,0,0,.25);
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      -webkit-print-color-adjust: exact;
      color-adjust: exact;
      print-color-adjust: exact;
      position: inherit;
    }
    .form-check-input[type=checkbox] {
        border-radius: .5em;
        cursor: pointer;
        margin: 0px 5px;
    }
    .form-check .form-check-input {
        float: left;
    }
    .form-check-input:active{
      filter:brightness(90%);
    }
    .form-check-input:focus{
      border-color:#86b7fe;
      outline:0;
      box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .form-check-input:checked{
      background-color:#0d6efd;
      border-color:#0d6efd;
    }
    .form-check-input:checked[type=checkbox]{
      background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

  .wrapper{
  width: 450px;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.12);
  }
  .wrapper header{
  display: flex;
  align-items: center;
  padding: 25px 30px 10px;
  justify-content: space-between;
  }
  header .icons{
  display: flex;
  }
  header .icons span{
  height: 38px;
  width: 38px;
  margin: 0 1px;
  cursor: pointer;
  color: #878787;
  text-align: center;
  line-height: 38px;
  font-size: 1.9rem;
  user-select: none;
  border-radius: 50%;
  }
  .icons span:last-child{
  margin-right: -10px;
  }
  header .icons span:hover{
  background: #f2f2f2;
  }
  header .current-date{
  font-size: 1.45rem;
  font-weight: 500;
  }
  .calendar{
  padding: 20px;
  }
  .calendar ul{
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  text-align: center;
  }
  .calendar .days{
  margin-bottom: 20px;
  }
  .calendar li{
  color: #333;
  width: calc(100% / 7);
  font-size: 1.07rem;
  }
  .calendar .weeks li{
  font-weight: 500;
  cursor: default;
  }
  .calendar .days li{
  z-index: 1;
  cursor: pointer;
  position: relative;
  margin-top: 30px;
  }
  .days li.inactive{
  color: #aaa; background-color: transparent !important;
  }
  .days li.active{
  color: #fff;
  }
  .days li::before{
  position: absolute;
  content: "";
  left: 50%;
  top: 50%;
  height: 40px;
  width: 40px;
  z-index: -1;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  }
  .days li.active::before{
  background: #9B59B6;
  }
</style>
<?php 
//Validar menu de puestos
$email  = $this->tank_auth->get_usermail(); 
$idPersona= $this->tank_auth->get_idPersona();
$validateEmail = array();
$sw=0;
  if($email=="SISTEMAS@ASESORESCAPITAL.COM" || $email=="AUDITORINTERNO@AGENTECAPITAL.COM"|| $email=="CAPITALHUMANO@AGENTECAPITAL.COM" || $email=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $email=="PROYECTO@AGENTECAPITAL.COM.MX" || $email=="ASISTENTEDIRECCION@AGENTECAPITAL.COM"){
      $sw=1;
      array_push($validateEmail, $email);
  }
  //**************************
?>
<script type="text/javascript">
  function verContenidoPuesto(div)
  {
   let clas=document.getElementsByClassName('divContenidoDePuesto');
   let cant=clas.length;
   for(let i=0;i<cant;i++){clas[i].classList.remove('verObjeto');clas[i].classList.add('ocultarObjeto');}
   if(document.getElementById(div)){document.getElementById(div).classList.remove('ocultarObjeto');}
   if(document.getElementById(div)){document.getElementById(div).classList.add('verObjeto')};
   if(document.getElementById(div).id=='divIndicadoresDeProductividad')
    {
      document.getElementById('buscarIdPuesto').classList.add('ocultarObjeto');
      document.getElementById('buscarIdPuesto').classList.remove('verObjeto')
    }
   else
    {
      document.getElementById('buscarIdPuesto').classList.remove('ocultarObjeto')
    document.getElementById('buscarIdPuesto').classList.add('verObjeto')
    } 
  }
</script>

<div class="col-spinner-puestos" id="SpinnerLoadPuestos">
  <div class="container-spinner-content-loading">
    <div class="spinner-grow" role="status">
    </div>
    <div class="spinner-grow" role="status">
    </div>
    <div class="spinner-grow" role="status">
    </div>
  </div>
</div>
<div class="contenido" id="ContentPuestos">
  <div class="panel_botones" id="BtnMenuPuestos">
    <table class="tablaMenu table" id="PanelBotonesPuesto" style="position: sticky;top:0;">
      <!--tr>
        <td>
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\puestos.png')?>" width="70%;"><br>
          <span class="lbboton">Puestos</span>
          <ul class="subMenuPuesto">
            <li onclick="verContenidoPuesto('organigramaPuestoDiv')"><span class="lbboton">Organigrama</span></li>
            <li onclick="verContenidoPuesto('verPuestoDiv')"><span class="lbboton">Ver Puesto</span></li>
          <?php if($sw==1){?>            
            <li onclick="verContenidoPuesto('altaPuestoDiv')"><span class="lbboton">Alta de puestos</span></li>
            <li onclick="verContenidoPuesto('divFunciones')"><span class="lbboton">Asignar funcion para puesto</span></li-->
          <!--<?php }?>
            <li onclick="verContenidoPuesto('org_chartPuesto')"><span class="lbboton">Asignar funcion para puesto</span></li-->
          <!--/ul>
          </div>  
        </td>
      </tr> -->
      <tr>
        <td style="border-top: none;">
          <div class="boton" onclick="verContenidoPuesto('organigramaPuestoDiv')" class="lbboton"><!-- 94 x 83.89 -->
            <div style="height: 48px; display: flex;align-items: center;justify-content: center;">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\puestos.png')?>" width="65%;"></div>
            <span >Organigrama</span>
          </div>
        </td>
      </tr>    
      <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('verPuestoDiv')" class="lbboton">
            <div style="height: 48px;">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\agentes2.png')?>" width="65%;"></div>
            <span >Ver Puesto</span>
          </div>
        </td>
      </tr>    
      <?php if($sw==1){?> 
      <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('altaPuestoDiv')" class="lbboton">
            <div style="height: 48px;">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\agentes2.png')?>" width="65%;"></div>
            <span >Alta de Puestos</span>
          </div>
        </td>
      </tr>
      <?php } ?>
      <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('divDocuments')" class="lbboton">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\document.png')?>" width="65%;" style="padding: 5px;">
            <span >Documentación</span>
          </div>
        </td>
      </tr>
      <?php if($sw==1){?> 
      <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('divNuevaTabla')" class="lbboton">
            <div style="height: 48px;">
            <img src="<?php echo(base_url().'assets\images\agrega_agentes\agentes2.png')?>" width="65%;"></div>
            <span >NT</span>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('divReportes')" class="lbboton">
            <i class="fas fa-newspaper" style="font-size: 36px;padding: 8px;color: #561a69;"></i>
            <span>Reportes</span>
          </div>
        </td>
      </tr>
      <?php }?>
          <tr>
        <td>
          <div class="boton" onclick="verContenidoPuesto('divIndicadoresDeProductividad')" class="lbboton">
           <i class="fas fa-line-chart" style="font-size: 36px;padding: 8px;color: #561a69;"></i>
            <span >Indicadores de productividad</span>
          </div>
        </td>
      </tr>
    </table>
  </div>

  <div class="contenidoPrincipal" id="ContainerContent">
    <!-- ------ Select Colaboradores ------ -->
    <div>
      <div class="col-md-12" style="display:flex;align-items: center;">
        <div class="col-md-1 width-ajust">
          <button class="btn-burguer" id="BtnMenuBurguer" title="Menú"><i class="fa fa-bars" aria-hidden="true"></i></button>
        </div>
        <div class="col-md-2 width-ajust" style="padding-right: 0px;"><label class="textSizeLabel" style="margin: 0px;">Colaboradores:</label></div>
        <div class="col-md-10">
          <select id="buscarIdPuesto" class="buscarPuesto form-control width-ajust" onchange="BuscarPorPuesto()">
            <?=imprimirPuestosHomonimos($puestos)?></select>
        </div>
        <!--<div class="col-md-1"><button class="btn btn-primary btn-sm" onclick="enviaForm(2)"><i class="fa fa-search"></i>Buscar</button></div>-->
      </div>
    </div>
    <br>

    <div id="org_chartPuesto" class="divContenidoOrganigrama divContenidoDePuesto ocultarObjeto" >
      <div id="org_chart" style="width: 30%;height: 500px;overflow: scroll"></div>
    </div>
    <!-- ------ NT ------ -->
    <div id="divNuevaTabla" class="divContenidoDePuesto ocultarObjeto">
      <div class="col-md-12 container-NT table-width2">
        <?=imprimirTablaGrupoPuestosNuevo($puestosGrupos,$colaboradorConPuesto)?>
      </div>
    </div>
    <!-- ------ Organigrama ------ -->
    <div id="organigramaPuestoDiv" class="divContenidoDePuesto verObjeto">
      <div id="divOrganigrama" style="height: auto;overflow:auto;" class="verObjeto">
        <div class="col-md-12" style="text-align: end;padding-bottom: 5px;">
          <?php if($permisoAgregar==1){?>
            <button data-toggle="modal" data-target="#subir_organigrama" class="btn btn-primary">
              <i class="fa fa-upload"></i> Subir Organigrama</button>
          <?php }?>
        </div>
        <br>
        <div style="width: 100%;height: auto;margin: 0px;">
        <?php $ruta_imagen=base_url()."assets/documentos/capitalHumano/organigrama/";?>
        <?php foreach($mapa as $recurso){$url_imagen=$ruta_imagen.$recurso->url_imagen;}?>
          <div class="col-md-12" id="DocOrganigrama" style="padding: 0px;">
            <iframe src="<?php echo $url_imagen;?>" style="width: 100%;height: 600px;border-style: none;"></iframe>
          </div>
        </div>
      </div>
    </div>
    <!-- ------ Alta Puestos ------ -->
    <div id="altaPuestoDiv" class="divContenidoDePuesto ocultarObjeto">
      <ul class="nav nav-tabs" id="tab_alta_puesto" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" aria-selected="true" href="#tab_alta">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Alta Puesto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" aria-selected="true" href="#tab_function">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Funciones</a>
        </li>
      </ul>
      <div class="tab-content" id="contenedor_alta_puesto">
        <div class="tab-pane active" id="tab_alta" role="tabpanel" aria-labeledby="tab_alta">
      <input type="hidden" class="puesto" id="idPuesto">
      <input type="hidden" class="repository-permission" id="repository-permission" value="<?= $permission["uploadToRepositories"] ?>"> <!-- Dennis Castillo [2022-03-28] -->
      <div class="col-spinner-altapuestos" id="SpinnerAltaPuestos"></div>
          <div class="" style="display: inline-block;padding: 0px;">
        <?php if($permisoAgregar==1){?>
        <div class="col-md-12" style="margin-bottom: 10px;">
          <button onclick="nuevoPuestoAutorizado()" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Crear Nuevo Puesto Autorizado</button>
          <button onclick="nuevoPuesto()" class="btn btn-primary">
            <i class="fa fa-plus-circle"></i> Nueva Asignación de Puesto</button>
          <!-- <button onclick="modificarPuesto()" class="btn btn-primary"><i class="fa fa-edit"></i> Modificar puesto</button> -->
          <button onclick="enviaForm(1)" class="btn btn-primary"><i class="fa fa-folder"></i> Guardar</button>
        </div>
        <div class="col-md-12">
          <div class="col-md-4 width-ajust">  
            <label><i class="fa fa-filter" aria-hidden="true"></i> Puestos Autorizados</label>
            <select class="puesto form-control" id="selectPuestos" disabled required>
              <?=imprimirPuestosGrupos($puestosGrupos)?></select>
          </div>
          <div class="col-md-5">  
            <label><i class="fas fa-user-edit"></i> Nombre Puesto</label>
            <input class="puesto form-control" id="personaPuesto" type="text" name="" placeholder="Nombrar Puesto" required>
          </div>
          <div class="col-md-3 width-ajust">
            <label><i class="fa fa-briefcase" aria-hidden="true"></i> Área del Puesto</label>
            <select class="puesto form-control" id="areaPuesto" required>
              <option value="">Seleccione</option>
                <?= array_reduce($area, function($acc, $curr){
                  $acc .= '<option value="'.$curr->idColaboradorArea.'">'.$curr->colaboradorArea.'</option>';
                  return $acc;
                }, "");?>
            </select>
          </div>
        </div>
        <div class="col-md-12" style="margin-top: 10px;">
          <div class="col-md-12">  
            <label><i class="fas fa-user-tie"></i> Depende</label><select class="puesto form-control" id="padrePuesto" required><?=imprimirPuestosHomonimos($puestosTodos)?></select>
          </div>
        </div>
            <div class="col-md-12 column-flex-bottom" style="margin-top: 10px">
              <div class="col-md-11">
                <label><i class="fas fa-university"></i> Misión</label>
                <input type="text" id="misionContenido" class="form-control">
              </div>
              <div class="col-md-1 pd-left pd-right">
                <button class="btn btn-success" onclick="misionGuardar()">Guardar</button>
          </div>
        </div>
        <?php }?>
        <div class="col-md-12">
          <hr style="margin-top: 20px;border-top: 1px solid #cbcbcb;">
        </div>
        <div id="divPuestoGrupos">
          <div class="col-md-12" style="padding-bottom: 5px;">
            <div class="container-table-puestos" id="bodyContieneCCP">
              <h5 style="text-align: center;">Seleccione un puesto de la tabla de abajo.</h5>
            </div>
          </div>
          <div class="col-md-12" id="TableGruposPuesto" style="max-height: 300px;overflow: auto;">
            <table class="table table-striped" id="TablaPuestosGrupos">
              <thead>
                <tr style="background: #1e4c82;">
                  <th>Puesto</th>
                  <th>Plazas</th>
                  <th>Creadas</th>
                  <th>Incrementar</th>
                  <th>Decrementar</th>
                </tr>
              </thead>
              <tbody class="body-table-grupos-puesto"></tbody>
            </table>
          </div>
              <div class="row ocultarObjeto" id="divColaboradorConPuesto"><?=imprimirdivColaboradorConPuesto($colaboradorConPuesto);?></div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab_function" role="tabpanel" aria-labeledby="tab_function">
          <div class="panel-body" style="padding: 0px;">
            <div class="col-md-12 column-flex-bottom">
              <input type="hidden" id="idFuncionProceso" class="funcionProceso">
              <div class="col-md-7">
                <label>Nombre función:</label>
                <input type="text" id="inputFunciones" class="form-control funcionProceso" placeholder="Agregar Funcion">
              </div>
              <div class="col-md-3">
                <label>Clasificación:</label>
                <select id="tipoFuncion" class="form-control funcionProceso">
                  <option value="0">Descriptiva</option>
                  <option value="1">Medible</option>
                </select>
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary" onclick="direccionAJAX(0,null)">Guardar Función</button>
              </div>
            </div>
            <div class="col-md-12">
              <hr style="margin-top: 20px;border-top: 1px solid #cbcbcb;">
            </div>
            <div class="col-md-12" style="text-align: center;padding: 5px;display: none;">
              <button class="btn btn-primary" id="ViewTable1" onclick="MostrarTabla(1)">Ver tabla</button>
            </div>
            <div class="col-md-12" style="max-height: 400px;overflow: auto;">
              <table id="tablaFunciones" class="table table-striped tableFunciones"></table>
            </div>
          </div>
          <div class="col-md-12"><hr class="hr-divider"></div>
          <div class="panel-body pd-top pd-bottom">
            <div class="col-md-6" style="padding-left: 0px;border-right: 1px solid #e5e5e5;">
              <h5>Guardar Procedimientos</h5>
              <hr>
              <div class="col-md-12" style="padding-bottom: 10px;">
                <textarea class="form-control" id="inputProcedimientos"></textarea>
              </div>
              <div class="col-md-12" style="padding-left: 0px;">
                <div class="col-md-4 width-ajust" style="padding-right: 0px;">
                  <button class="btn btn-primary" onclick="direccionAJAX(1,null)">Guardar</button>
                </div>
                <div class="col-md-4" style="padding-right: 0px;">
                  <form id="formDocumento" action="javascript: enviarArchivoAJAX('formDocumento','guardaDocumentoProc')">
                    <label  for="archivoProc" class="btn btn-primary">Agregar Documento</label>
                    <input type="file" class="custom-file-input" name="documentos" id="archivoProc" onchange="if(!this.value.length)return false;document.getElementById('formDocumento').submit();" style="opacity: 0; width: 5px"/>
                    <input class="btn" type="hidden" name="idFuncionProcedimiento" id="idArchivoProc">
                  </form>
                </div>
                <div class="col-md-4" style="padding-right: 0px;">
                  <form id="formDiagrama" action="javascript: enviarArchivoAJAX('formDiagrama','guardarDiagrama')">
                    <label  for="archivoDiagrama" class="btn btn-primary">Agregar Diagrama</label>
                    <input type="file" class="custom-file-input" name="documentos" id="archivoDiagrama" onchange="if(!this.value.length)return false;this.form.submit();" style="opacity: 0; width: 5px"/>
                    <input class="btn" type="hidden" name="idFuncionProcedimiento" id="idArchivoProcDiagrama">
                  </form>
                </div>
              </div>
              <div class="col-md-12" style="padding-top: 15px;">
                <fieldset>
                  <legend style="font-size: 14px;">PERIOCIDAD DE PROCEDIMIENTOS</legend> 
                  <div class="col-md-4 width-ajust">
                    <select class="form-control" onchange="escogerPeriocidad(this.value)" id="selectTipoPeriocidad">
                      <option value=''>ESCOGER</option>
                      <option>Fecha</option>
                      <option>Dia</option>
                    </select>
                  </div>
                  <div id="divfechaPeriocidad" class="col-md-5 width-ajust ocultarObjeto">
                    <input type="date" class="form-control" id="fechaPeriocidad">
                  </div>
                  <div id="divselectDiaPeriocidad" class="col-md-5 width-ajust ocultarObjeto">
                    <select class="form-control" id="selectDiaPeriocidad">
                      <option value="1">Lunes</option>
                      <option value="2">Martes</option>
                      <option value="3">Miercoles</option>
                      <option value="4">Jueves</option>
                      <option value="5">Viernes</option>
                    </select>
                  </div>
                  <div class="col-md-2"><button class="btn btn-primary" onclick="guardarPeriocidad()">Guardar</button></div>
                </fieldset>
              </div>
              <div class="col-md-12">
                <hr style="margin-top: 20px;border-top: 1px solid #cbcbcb;">
              </div>
              <div class="col-md-12" style="max-height: 280px;overflow: auto;padding-right: 0px;">
                <table class="table" id="tablaProcedimientos" style="background-color: #f9f9f9;">
                  <tbody><tr><td>Seleccione función de la tabla</td></tr></tbody>
                </table>
              </div>
            </div>
            <div class="col-md-6" style="padding-right: 0px;">
              <h5>Guardar Pasos</h5>
              <hr>
              <div class="col-md-12" style="padding-bottom: 10px;">
                <textarea class="form-control" id="inputPasos"></textarea>
              </div>
              <div class="col-md-5">
                <button class="btn btn-primary" onclick="direccionAJAX(4,null)">Guardar Pasos</button>
              </div>
              <div class="col-md-12">
                <hr style="margin-top: 20px;border-top: 1px solid #cbcbcb;">
              </div>
              <div class="col-md-12" style="max-height: 400px;overflow: auto;padding-right: 0px;">
                  <table class="table" id="tablaPasos" style="background-color: #f9f9f9;">
                    <tbody><tr><td>Seleccione procedimiento de la tabla de Procedimientos</td></tr></tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ------ Ver Puestos ------ -->
    <div id="verPuestoDiv" class="divContenidoDePuesto ocultarObjeto">
      <div id="divBarTool" class="col-md-12 container-divBarTool ocultarObjeto" style="">
        <?php if($permisoAgregar==1){?>
        <div class="divBarTool">
          <button class="btn-divBarTool" onclick="insertaObjetos('p')">Parrafo </button>
          <button class="btn-divBarTool" onclick="insertaObjetos('ul')">Lista</button>
          <button class="btn-divBarTool" onclick="insertaObjetos('check')">Checkbox</button>
          <button class="btn-divBarTool" onclick="insertaObjetos('a')">Link</button>
          <button class="btn-divBarTool" onclick="insertaObjetos('table')">Tabla</button>
          <button class="btn-divBarTool" onclick="insertaObjetos('tr')">Fila</button>
          <button class="btn-divBarTool" onclick="insertaObjetos('td')">Columna</button>
        </div>
        <div class="divBarTool">
          <button class="btn-divBarTool" onclick="eliminarFila()">Eliminar Fila</button>
          <button class="btn-divBarTool" onclick="eliminarColumna()">Eliminar Columna</button>
          <button class="btn-divBarTool" onclick="eliminarObjeto()">Eliminar</button>
           <!--button class="btn" onclick="tamanioCeldas()">+</button-->
           <!--button class="btn" onclick="tamanioCeldas()">-</button-->
         </div>
         <div class="divBarTool">
          <button class="btn-divBarTool" onclick="formatoTexto('bold')">Negrita</button>
          <button class="btn-divBarTool" onclick="formatoTexto('underline')">Subrayado</button>
          <button class="btn-divBarTool" onclick="formatoTexto('foreColor')">Color</button>
          <button class="btn-divBarTool" onclick="formatoTexto('backColor')">Fondo</button>
          <input type="color" id="colorTextMU">
        </div>
        <?}?>
        <div class="divBarTool">
          <!--button class="btn"  onclick="datosParaPlantilla()">Datos para plantilla</button-->
          <button class="btn-divBarTool"  onclick="imprimirManualUsuario()">Imprimir</button>
          <button class="btn-divBarTool"  onclick="imprimirTodoElManual()">Imprimir Todo</button>
          <?php if($permisoAgregar==1){?>
          <button class="btn-divBarTool"  onclick="guardarManualUsuario()">Guardar</button>
          <?}?>
        </div>
      </div>
      <ul class="nav nav-tabs" id="tab_capa" role="tablist">
        <!-- <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" id="tab_divManual" role="tab" aria-selected="true" href="#divManual" onclick="manejoPestanias('divManual')">
            <i class="fa fa-file-text" aria-hidden="true"></i> Manual</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divProcesos" role="tab" aria-selected="true" href="#divProcesos" onclick="manejoPestanias('divProcesos')">
            <i class="fa fa-th-large" aria-hidden="true"></i> Descriptivo</a>
        </li> -->
        <li class="nav-item"><!--onclick="manejoPestanias('divMatrizFastFile')"-->
          <a class="nav-link active get-fast-file" data-toggle="tab" id="tab_fastfile" role="tab" aria-selected="true" href="#divMatrizFastFile">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Fast File</a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divMatrizDoc" role="tab" aria-selected="true" href="#divMatrizDoc1">
            <i class="fa fa-file" aria-hidden="true"></i> Documentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divVisor" role="tab" aria-selected="true" href="#divVisor">
            <i class="fa fa-file" aria-hidden="true"></i> Visor</a>
        </li> -->
        <?php if($permisoAgregar==1){?>
        <!-- <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divPuestoGrupos" role="tab" aria-selected="true" href="#divPuestoGrupos">
            <i class="fa fa-file" aria-hidden="true"></i> Grupo de Puestos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divFunciones" role="tab" aria-selected="true" href="#divFunciones1">
            <i class="fa fa-plus-square" aria-hidden="true"></i> Funciones</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_divMatrizProc" role="tab" aria-selected="true" href="#divMatrizProc">
            <i class="fa fa-th" aria-hidden="true"></i> Matrices de Procedimientos</a>
        </li> -->
        <?  }  ?>
        <li class="nav-item" id="ContainerUploadFilesEmployee">
          <div class="" id="upload-files-employee"></div>
        </li>
      </ul>
      <div class="col-spinner-verpuestos" id="SpinnerVerPuestos"></div>
      <div class="tab-content" id="contenedor_capa">
        <input type="hidden" id="sw" value="0">
        <!-- divManual -->
        <!-- <div class="tab-pane active" id="divManual" role="tabpanel" aria-labeledby="tab_divManual">
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPRP")' >PRINCIPALES REQUERIMIENTOS DEL PUESTO</label></div><div id="divContenidoPRP" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPP")' >PERFIL DE PUESTO</label></div><div   id="divContenidoPP" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoMP")' >MISION DEL PUESTO</label></div><div id="divContenidoMP" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoFPR")' >RESPONSABILIDADES</label></div><div   id="divContenidoFPR" class="divContMU" style="display: none;"></div></div>
          <div  class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoEC")' >ESQUEMA DE COMUNICACIONES</label></div><div id="divContenidoEC" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoAGT")' >AREAS GEOGRAFICAS DE TRABAJO</label></div><div id="divContenidoAGT" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoCTD")' >CAPACITACION, TALLERES O DIPLOMADOS NECESARAS PUESTO</label></div><div id="divContenidoCTD" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPER")'>PRINCIPALES ENLACES Y REPORTES</label></div><div id="divContenidoPER" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoNCBC")' >NORMAS DE INGRESOS, COMISIONES, BONOS Y COMPENSACIONES</label></div><div id="divContenidoNCBC" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoPO")' >POSICION ORGANIZACIONAL</label></div><div id="divContenidoPO" class="divContMU" style="display: none;"></div></div>
          <div class="divPadreContMU"><div><label class="labelTitContMU"  onclick='manejoVistaContenido("divContenidoDIO")' >DOCUMENTOS PARA INGRESO A LA ORGANIZACION</label></div><div id="divContenidoDIO" class="divContMU" style="display: none;"></div></div>
        </div> -->
        <!-- divProcesos -->
        <!-- <div class="tab-pane divPestania ocultarObjeto divAparienciaManuales" id="divProcesos" role="tabpanel" aria-labeledby="tab_divProcesos">
          <div class="col-md-12">
            <select class="form-control input-sm width-ajust" id="selectOpcionProc" onchange="selectOpcionProc(this)" style="margin-bottom: 3px;">
              <option value="-1"></option>
              <option value="divCapturaFuncion">Función</option>
              <option value="divCapturaMP">Matriz procedimiento</option>
            </select>
          <div id="divCapturaFuncion" class="ocultarObjeto">
            <select class="form-control input-sm width-ajust" id="selectCapturaFuncion" onchange="selectCapturaFuncion(this)" style="margin-bottom: 3px;"></select>
            <select class="form-control input-sm width-ajust" onchange="selectCapturaProc(this)" id="selectCapturaProc" style="margin-bottom: 3px;"></select>
          </div>
          <div id="divCapturaMP" class="ocultarObjeto"><select class="form-control input-sm" id="selectCapturaMP" onchange="selectCapturaMP(this)" style="margin-bottom: 3px;"></select></div>
          </div>
          <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContODPProc")'>OBJETIVO DEL PROCEDIMIENTO</label></div>
          <div  id="divContODPProc" class="divContMU" style="display: none;"></div>
          </div>
          <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContAPProc")'>ALCANCE DEL PROCEDIMIENTO</label></div>
          <div  id="divContAPProc" class="divContMU" style="display: none;"></div>
          </div>
          <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContRAProc")'>RESPONSABILIDAD Y AUTORIDAD</label></div>
          <div  id="divContRAProc" class="divContMU" style="display: none;"></div>
          </div>
            <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDTAProc")'>DEFINICIONES, TERMINOS Y ACRONIMOS</label></div>
          <div  id="divContDTAProc" class="divContMU" style="display: none;"></div>
          </div>
           <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContPPProc")'>POLITICAS DE PROCEDIMIENTO</label></div>
          <div  id="divContPPProc" class="divContMU" style="display: none;"></div>
          </div>
          <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDiagrama")'>DIAGRAMA DE  PROCEDIMIENTOS</label></div>
          <div  id="divContDiagrama" class="divContMU" style="display: none;"></div>
          </div>
          <div class="divPadreContMU">
          <div><label class="labelTitContMU" onclick='manejoVistaContenido("divContDPProc")'>DESCRIPCION DEL PROCEDIMIENTO</label></div>
          <div  id="divContDPProc" class="divContMU" style="display: none;"></div>
          </div>
          <div id="archivosDelProcedimiento"></div>
        </div> -->
        <!-- divMatrizFastFile -->
        <div class="tab-pane active" id="divMatrizFastFile" role="tabpanel" aria-labeledby="tab_fastfile">
          <?= $this->load->view("persona/fastFile", array("months" => $months));?>
        </div>
        <!-- divMatrizDoc -->
        <div class="tab-pane" id="divMatrizDoc1" role="tabpanel" aria-labeledby="tab_divMatrizDoc">
          <?php //$this->load->view('persona/documentos');?>
        </div>
        <!-- divVisor -->
        <!-- <div class="tab-pane" id="divVisor" role="tabpanel" aria-labeledby="tab_divVisor">
          <div id="Puesto" data-id="<?=$puestoUsuario?>"></div>
          <div id="Empleado_id" data-id="<?=$IdUsuario?>"></div>
          <div style="height: 350px;margin-left: 5%;width: 90%;">
            <div class="file-manager-container" data-referencia="DOCUMENTOS" data-trashed data-full data-referenciaId="0"></div>
          </div>
        </div> -->
        <!-- divPuestoGrupos -->
        <!-- <div class="tab-pane" id="divPuestoGrupos" role="tabpanel" aria-labeledby="tab_divPuestoGrupos">
          <div class="row">
            <div class="col-md-6" style="height: 600px;overflow: scroll;"><?//imprimirTablaGrupoPuestos($puestosGrupos)?></div>
            <div class="col-md-6" > <div id="bodyContieneCCP"></div></div>
          </div>
          <div class="row ocultarObjeto"><?//imprimirdivColaboradorConPuesto($colaboradorConPuesto);?></div>
        </div> -->
        <!-- divFunciones -->
        <!-- <div class="tab-pane" id="divFunciones1" role="tabpanel" aria-labeledby="tab_divFunciones"></div> -->
        <!-- divMatrizProc -->
        <!-- <div class="tab-pane" id="divMatrizProc" role="tabpanel" aria-labeledby="tab_divMatrizProc">
          <div class="well">  
          <div  style="float: left;border:solid;margin-right: 5%; width: 40%;overflow: scroll;">
          <div >
          <select id="SelectparaMP"><?//imprimirPuestosHomonimos($puestosTodos)?></select><button onclick="direccionAJAX(7,null)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar procedimientos</button>
          </div>
          <hr><hr>
          <div id="listaProc"></div>
          </div>
          <div   style="float: left; border:solid;width: 50%;overflow: scroll;">
          <button class="btn-primary" onclick="direccionAJAX(8,null)">Matriz Procedimientos</button>      
          <textarea  id="inputNuevoMP" placeholder="Agregar matriz procedimientos"></textarea>
          <select id="selectMP" onchange="onchangeSelectMP(this)"></select>
          <div><input type="date" id="dateTarea"><button onclick="guardarTarea()" class="btn btn-success">Guardar como tarea</button></div>
          <div style="display: none"><select id="selectDiaSemana"><option value="">Lunes</option><option value="">Martes</option><option value="">Miercoles</option><option value="">Jueves</option><option value="">Viernes</option></select><select><option>Semanal</option><option>Mensual</option></select><button onclick="guardarTarea()" class="btn btn-success">Guardar como tarea</button></div>
          <hr> <hr> 
          <div id="contFuncionAsignadasMP"></div>
          </div>  
          </div>
          <div id="cuadroDialogo" class="ocultarObjeto">
          <div><button class="btn btn-primary btn-xs contact-item" onclick="cuadroDeDialogoOnCLick(this)">Cerrar</button></div>
          <div id="cuadroDialogoContenido">Contenido</div>
          </div>
          </div>
        </div> -->
      </div>
    </div>
    <!-- ------ Documentación ------ -->
    <div id="divDocuments" class="divContenidoDePuesto ocultarObjeto">
      <?php $this->load->view('persona/documentos');?>
    </div>
    <!-- ------ Reportes ------ -->
    <div id="divReportes" class="divContenidoDePuesto ocultarObjeto">
      <div class="col-spinner-reportes"></div>
      <div class="tab-content box-s table-width3" id="tabContentReports" style="margin:0px;">
        <ul class="nav nav-tabs" id="tab_capa" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" id="tab_vacaciones" role="tab" aria-selected="true" href="#tab_vac">
              <i class="fas fa-calendar-check"></i> Vacaciones
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" id="tab_asistencias" role="tab" aria-selected="true" href="#tab_asist">
              <i class="fas fa-check-circle"></i> Asistencias
            </a>
          </li>
          <li class="nav-item">
            <div class="dropdown nav-dropdown" style="height: 100%;">
              <a class="btn btn-dropdown dropdown-toggle" data-target="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-newspaper"></i>&nbsp;Generar Reporte</a>
              <ul class="dropdown-menu" aria-labelledby="dLabel" style="">
                <!-- <li><a class="dropdown-item" onclick="GenerarReporte('1')" style="cursor:pointer;">Descargar Reporte de Vacaciones</a></li>
                <li><a class="dropdown-item" onclick="GenerarReporte('2')" style="cursor:pointer;">Descargar Reporte de Asistencias</a></li> -->
                <li><a class="dropdown-item" onclick="GenerarReporte('3')" style="cursor:pointer;">Descargar registros de Vacaciones</a></li>
                <li><a class="dropdown-item" onclick="GenerarReporte('4')" style="cursor:pointer;">Descargar registros de Asistencias</a></li>
              </ul>
            </div>
          </li>
        </ul>
        <div class="tab-content" id="contenedor_capa">
          <div class="tab-pane table-width3 active" id="tab_vac" style="max-height: 530px;overflow: auto;">
            <table class="table table-striped" id="TablaVacaciones">
              <thead>
                <tr style="background: #266093;">
                  <th scope="col">N°</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Puesto</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Área</th>
                  <th scope="col">Correo Jefe</th>
                  <th scope="col">Antigüedad</th>
                  <th scope="col">Fecha de Salida</th>
                  <th scope="col">Fecha de Retorno</th>
                  <th scope="col">Cantidad de Días</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Solicitado el</th>
                </tr>
              </thead>
              <tbody class="list-table-vacations-body"></tbody>
            </table>
          </div>
          <div class="tab-pane" id="tab_asist" style="max-height: 530px;overflow: auto;">
            <table class="table table-striped" id="TablaAsistencias">
              <thead>
                <tr style="background: #266093;">
                  <th scope="col">N°</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Puesto</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Área</th>
                  <th scope="col">Asistencia</th>
                  <th scope="col">Puntualidad</th>
                  <th scope="col">Fecha</th>
                </tr>
              </thead>
              <tbody class="list-table-asistencias-body"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- INDICADORS DE PRODUCTIVIDAD -->
    <div id="divIndicadoresDeProductividad" class="divContenidoDePuesto ocultarObjeto">
      <?php $this->load->view('persona/indicadoresDeProductividad'); ?>
    </div>
    <!-- INDICADORS DE PRODUCTIVIDAD FIN -->
  </div>
</div>

<!-- Obsoletas -->
<div id="divOrganigrama" style="width: 1200px;height: auto;overflow-x: scroll;display: none;" class="divPestania varObjeto">
  <div id="divOrganigramaContenedor" class="tree" style="width: 4500px;height:auto;min-height: 400px;display: none;"></div>
</div>
<div style="" id="divFuncionesAsignar"></div>
<div style="clear: both; margin-left: 2%;margin-right: 2%;display: none;"></div>
<div id="divMatrizProc" class="divPestania ocultarObjeto"></div>

<!-- Estatus de carga por sección -->
<div class="col-md-12" id="StatusLoadPuestos" style="display: none;">
  <input type="text" class="form-control" id="P-VerPuesto">
  <input type="text" class="form-control" id="P-AltaPuestos">
  <input type="text" class="form-control" id="P-Funciones">
  <input type="text" class="form-control" id="P-Documentacion">
  <input typr="text" class="form-control" id="P-Reportes">
</div>


<!--******* Uilima Modificacion Miguel 21/10/2020   ***-->
<!-- Modal Subir Imagen Organigrama-->
<div id="subir_organigrama" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 60%">
    <form id="frmorganigrama" enctype="multipart/form-data" method="post" action="">
     <!-- Modal content-->
    <input type="hidden" name="id" id="id">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-upload"></i>&nbsp;Subir Documento de Organigrama</h4>
      </div>
      <div class="content-info-puesto" id="SpinnerUploadOrganigrama"></div>
      <div class="modal-body">
          <table border="0" width="100%">
          <tr>
            <td><label class="column-label"><i class="fa fa-image fa-2x"></i>&nbsp; ORGANIGRAMA</label></td>
            <td> <input type="file" id="organigrama" name="organigrama" class="textSizeLabel"></td>
          </tr>
          </table>
      </div>
      <div class="modal-footer" style="position: relative;">
        <button id="bnt_submit" type="submit" class="btn btn-primary">Guardar&nbsp;<i class="fa fa-check"></i></button>
         <button type="button" class="btn btn-warning" data-dismiss="modal" id="OrgClose">Cerrar&nbsp;<i class="fa fa-times"></i></button>
      </div>
    </div>
  </form>
  </div>
</div>
<!--**********************Fin de modificacion-->

<!--******* Uilima Modificacion Miguel 30/10/2020   ***-->
<!-- Mostrar documento visor PDF -->
<div id="visor_pdf" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog" style="width: 85%;">
  <!-- Modal content-->
     <div class="modal-content"  style="margin-left:-40%;height: auto;width: 180%;">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-file-pdf-o"></i>&nbsp;Visor Documentos Capital Humano</h5>
        <div style="text-align: right;">
        <button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
        </div>
      </div>
      <div class="modal-body">
       <div id="visor"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!--**********************Fin de modificacion-->

<!--Moficacion Miguel Jaime 22-11-2021-->
<!-- Modal-->
<div id="modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="width: 105%">
      <div class="modal-header">
       <h4 class="modal-title">
          <i class="fa fa-search"></i>&nbsp;Detalles <h5 id="TitleModal"></h5></h4>
      </div>
      <div class="modal-body" style="max-height: 430px;">
        <div id="pantalla"></div>
      </div>
       <div class="modal-footer">
           <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar<i class="fa fa-times"></i></button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal-->

<!--Fin de Modificacion-->

<div>
  <form id="formIncrementaDecrementa" method="POST" action="<?php echo base_url()?>capitalHumano/aumentoDecrementoPuesto">
    <input type="hidden" name="idPersonaPuestoGrupo" id="hiddenidPersonaPuestoGrupo">
    <input type="hidden" name="aumentodecremento" id="hiddenaumentodecremento">
  </form>
</div>

<div>
  <!-- <form id="formCreaPuestoHomonimo" method="post" action="<?=base_url();?>capitalHumano/creaPuestoHomonimo">
    <input type="hidden" id="hiddenPuestoHomonimo" name="personaPuestoGrupo">
  </form> -->
</div>

<!----- Dennis Castillo [2022-03-22]  -->
<div class="modal fade" id="modal-doc-details" tabindex="-1" role="dialog" aria-labelledby="modal-doc-details" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-doc-details">Información del documento</h4>
        <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body details-content">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!------->

<?php $this->load->view('adicional/espera');?>
<?php $this->load->view('footers/footer'); ?>
<script src="<?=base_url()."assets/js/js_documentoCapitalHumano.js"?>"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script src="<?=base_url()?>/assets/gap/js/datatables.reports.js"></script>

<!-- scripts Tic Consultores -->
<script src="<?=base_url()."gap/js/datatables.min.js"?>"></script>
<script src="<?=base_url()."assets/js/filemanager/public/bundle.js"?>"></script>
<!-- Fin scripts Tic Consultores -->

<script type="text/javascript">
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------


  function incrementarPuesto(idPersonaPuestoGrupo,operacion)
  {
    document.getElementById('hiddenidPersonaPuestoGrupo').value=idPersonaPuestoGrupo;
    document.getElementById('hiddenaumentodecremento').value=operacion;
    document.getElementById('formIncrementaDecrementa').submit();
  }
  var nombreDivActivo="";var objetoFoco="";var vistaAnterior="";var bandBorrado=0;var rowIndex="";var cellIndex="";var objetoEliminar=null;var varCapturaProc=-1;

function cuadroDeDialogoOnCLick(objeto){
  objeto.parentNode.parentNode.classList.remove('ventanaFPStyle');
  objeto.parentNode.parentNode.classList.add('ocultarObjeto');
}
function enviarArchivoAJAX(formulario,funcion){
  
    var Data = new FormData(document.getElementById(formulario));
  
  /* Creamos el objeto que hara la petición AJAX al servidor, debemos de validar si existe el   objeto “ XMLHttpRequest” ya que en internet explorer viejito no esta, y si no esta usamos 
  “ActiveXObject” */
  
  if(window.XMLHttpRequest) { 
    var Req = new XMLHttpRequest();
  }else if(window.ActiveXObject) {
    var Req = new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  //Pasándole la url a la que haremos la petición
  var direccion= <?php echo('"'.base_url().'capitalHumano/"');?>+funcion;
  Req.open("POST",direccion, true);
  
  /* Le damos un evento al request, esto quiere decir que cuando
  termine de hacer la petición, se ejecutara este fragmento de
  código */
  
  Req.onload = function(Event) {
    //Validamos que el status http sea  ok
    if (Req.status == 200) {
      /*Como la info de respuesta vendrá en JSON 
      la parseamos */
      var st = JSON.parse(Req.responseText);        
        swal("",st.mensaje,"info");

      if(st.success){
        /* Código si el return fue true */
            }else{
        /* Código si el return fue false */
      }
    } else {
          //console.log(Req.status); //Vemos que paso.
    }
  };    
  
  //Enviamos la petición
  Req.send(Data);
}


function crearObjetosParaForm(datos,clase,nombre){

  var input=document.createElement('input');
  input.setAttribute('type','hidden');
  input.setAttribute('value',datos);
  input.setAttribute('class',clase);
  input.setAttribute('name',nombre);

  document.body.appendChild(input);
}
function selectCapturaMP(objeto){
  var tipoObjeto=typeof(objeto);var numero=1;
  if(Array.isArray(objeto)){
    var cant=objeto.length;var option="";
     document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
    tabla='<table border="1"><tr><td># Act.</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
    
    for(var i=0;i<cant;i++){
      var linkDoc="";
          if(objeto[i].funcion==0){
            if(Array.isArray(objeto[i].documento)){           
              var cantDoc=objeto[i].documento.length;
              for(var j=0;j<cantDoc;j++){
                 linkDoc=linkDoc+'<a href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+objeto[i].idFuncionFP+'/'+objeto[i].documento[j]+'">'+objeto[i].documento[j]+'</a><br>';
              }
            }
      tabla=tabla+'<tr>';
      tabla=tabla+'<td>'+numero+'</td>';
      tabla=tabla+'<td>'+objeto[i].personaPuesto+'</td>';
      tabla=tabla+'<td>'+objeto[i].descripcionFP+'</td>';
      tabla=tabla+'<td>'+linkDoc+'</td>';
      tabla=tabla+'</tr>';
          }
       //value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
      else{
        if(document.getElementById(objeto[i].idFuncionFP)){
        document.getElementById(objeto[i].idFuncionFP).innerHTML=objeto[i].descripcionFP;}
      }
     numero++;
    }
   tabla=tabla+'</table>';
    
   document.getElementById("divContDPProc").innerHTML=tabla;
   // document.getElementById("selectCapturaProc").innerHTML=option;
  }
  else{direccionAJAX(16,objeto.value);}
}
function selectCapturaProc(objeto){
  var tipoObjeto=typeof(objeto);var numero=1;

  if(Array.isArray(objeto)){
  document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
    var cant=objeto.length;var option="";
    var responsable=document.getElementById("personaPuesto").value;
    var tabla='<table border="1"><tr><td># Act.</td><td>Responsable</td><td>Actividad</td><td>Formato o Anexo</td></tr>';
    var tr="<tr><td  colspan='4'>";
    var cad="";
    
    for(var i=0;i<(cant);i++){
      if(objeto[i].funcion==0){/*SI ES PROCEDIMIENTOS*/
      tabla=tabla+'<tr>';
      tabla=tabla+'<td>'+numero+'</td>';
      tabla=tabla+'<td>'+responsable+'</td>';
      tabla=tabla+'<td>'+objeto[i].descripcionFP+'</td>';
      tabla=tabla+'<td></td>';
      tabla=tabla+'</tr>';
       //value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
   
       }
      else{ 
        if(objeto[i].funcion==1){ 
        if(document.getElementById(objeto[i].idFuncionProceso)){/*SI SON DESCRIPCIONES DEL MANUAL*/
        document.getElementById(objeto[i].idFuncionProceso).innerHTML=objeto[i].descripcionFP;}
        }
        else{

          /*SI SON ARCHIVOS DEL PROCEDIMIENTO*/
          if(objeto[i].funcion==2){ 
          var idFuncionProceso=objeto[i].idFuncionProceso;
          var f=objeto[i].archivos;
          var canArchivos=objeto[i].cantidad;
          for(var j=0;j<canArchivos;j++){
            if(objeto[i].archivos[j]!='Diagrama'){
            cad=cad+'<a href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+idFuncionProceso+'/'+objeto[i].archivos[j]+'">'+objeto[i].archivos[j]+'</a><br>';}
            
          }
           
          //document.getElementById('archivosDelProcedimiento').innerHTML=cad;
         }else{
          /*SI ES DIAGRAMA*/
          document.getElementById('divContDiagrama').innerHTML='<img src="'+objeto[i].diagrama+'">';
         }
        }
      }
     numero++;
    }

    tr=tr+cad+"</td></tr>";
    tabla=tabla+tr;
   tabla=tabla+'</table>';
   document.getElementById("divContDPProc").innerHTML=tabla;
  }
  else{direccionAJAX(15,objeto.value);}
}
function selectCapturaFuncion(objeto)
{
  var tipoObjeto=typeof(objeto);
  if(Array.isArray(objeto)){
    var cant=objeto.length;var option="";
    option='<option value="-1"></option>'
    for(var i=0;i<cant;i++){
      option=option+'<option value="'+objeto[i].idFuncionProceso+'">'+objeto[i].descripcionFP+'</option>';
     
    }
    document.getElementById("selectCapturaProc").innerHTML=option;
    if(varCapturaProc>0){document.getElementById("selectCapturaProc").value=varCapturaProc;selectCapturaProc(document.getElementById("selectCapturaProc"));}
  }
  else{direccionAJAX(14,objeto.value);}
}
function selectOpcionProc(objeto){
  var cantidad=objeto.length;
  console.log(objeto, objeto.value, cantidad);
document.getElementById("selectCapturaFuncion").value=-1;
document.getElementById("selectCapturaProc").innerHTML="";
  document.getElementById("divContODPProc").innerHTML="";
  document.getElementById("divContAPProc").innerHTML="";
  document.getElementById("divContRAProc").innerHTML="";
  document.getElementById("divContDTAProc").innerHTML="";
  document.getElementById("divContPPProc").innerHTML="";
  for(var i=1;i<cantidad;i++){
    document.getElementById(objeto[i].value).classList.add("ocultarObjeto");
    document.getElementById(objeto[i].value).classList.remove("verObjeto");
  }
   if(objeto.value!='-1'){
  document.getElementById(objeto.value).classList.remove('ocultarObjeto');
  document.getElementById(objeto.value).classList.add('verObjeto');
   }
}
function eliminarFuncionMP(idProcesoFuncion,objeto){
 direccionAJAX(11,idProcesoFuncion);
 objeto.parentNode.parentNode.removeChild(objeto.parentNode);
}
function subirFuncionMP(idProcesoFuncion,objeto){direccionAJAX(12,idProcesoFuncion);}
function bajarFuncionMP(idProcesoFuncion,objeto){direccionAJAX(13,idProcesoFuncion);}
function onchangeSelectMP(objeto){
 if(objeto.value>-1){direccionAJAX(10,objeto.value);}
 else{document.getElementById("contFuncionAsignadasMP").innerHTML="";}
}
function asignarMP(idFuncionProceso){direccionAJAX(9,idFuncionProceso);}
function eliminarFP(objeto,e){
  e.stopPropagation();
  if(objetoEliminar==null){
  objetoEliminar=objeto.parentNode.parentNode;
  direccionAJAX(6,objeto.parentNode.parentNode.cells[0].innerHTML);
    }
    else{var tabla="";
      if(objetoEliminar.classList.contains('rowFuncion')){
          document.getElementById("tablaProcedimientos").innerHTML="";
          document.getElementById("tablaPasos").innerHTML="";
       }else{if(objetoEliminar.classList.contains('rowProcedimientos')){document.getElementById("tablaPasos").innerHTML="";}}   
      objetoEliminar.parentNode.removeChild(objetoEliminar);
      objetoEliminar=null;
    }
}

function enviarAJAX(controlador,parametros){
  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
 req.open('POST', url, true);
  /*document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');*/
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    { 
         var respuesta=JSON.parse(this.responseText);
        //procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass);
                
        procesaRespuestaAJAX(respuesta.datos,respuesta.tabla,respuesta.opcionTabla,'classRATProcedimiento');
          /*document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');*/
                                                  
      }     
   }
  };
 req.send();
}
function ejemplo(){
  alert("");
}


function moverProcedimiento(tipoMovimiento,idProcesoFuncion){
  var datos='/?idProcesoFuncion='+idProcesoFuncion+"&tipoMovimiento="+tipoMovimiento;
  enviarAJAX('capitalHumano/moverProcedimiento',datos);
}
function guardarModificacionFP(objeto,e){
     e.stopPropagation();
        objetoEliminar=objeto.parentNode.parentNode;
        var datos=objeto.parentNode.parentNode.cells[0].innerHTML+"&descripcionFP="+objeto.parentNode.parentNode.cells[1].innerHTML;
        
       direccionAJAX(19,datos);
}

function verDocumentos(objeto,e){
  
  e.stopPropagation();
  guardaIdFuncion(3,objeto.parentNode.parentNode,"classRATProcedimiento")
 direccionAJAX(17,objeto.parentNode.parentNode.cells[0].innerHTML);
  
}
function mostrarEnlacesDoc(objeto){
       cant=objeto.length;
     var link="";
      if(objeto.bandera==0)
       {
         link=objeto.datos;
       }
     else{
       var cant=objeto.datos.length;
       for(var i=0;i<cant;i++){
       link=link+'<div id="archivosProcedimiento'+objeto.datos[i]+'"><a target="_blank" href="<?php echo(base_url()."ArchivosProcedimientos/");?>'+objeto.idFuncionProceso+'/'+objeto.datos[i]+'">'+objeto.datos[i]+'</a><button class="btn" onclick=eliminarDocumento("'+objeto.idFuncionProceso+'","'+objeto.datos[i]+'")>Elimnar</button><br></div>';
       }
     }
  
    document.getElementById('cuadroDialogo').classList.remove('ocultarObjeto');
    document.getElementById('cuadroDialogo').classList.add('ventanaFPStyle');
    document.getElementById('cuadroDialogoContenido').innerHTML=link;

}
function eliminarDocumento(idFuncionProceso,nombreDocumento){
direccionAJAX(18,idFuncionProceso+";"+nombreDocumento);
}
function guardaIdFuncion(opcionAjax,objeto,classRow){ 
  //document.getElementById('idFuncionProceso').value=objeto.cells[0].innerHTML;
  var rowActivo=document.getElementsByClassName(classRow);
  if(rowActivo.length>0){rowActivo[0].classList.remove(classRow);}
  objeto.classList.add(classRow);
  if(opcionAjax!=5){direccionAJAX(opcionAjax,objeto.cells[0].innerHTML);}
  if(objeto.classList.contains('rowProcedimientos')){document.getElementById('idArchivoProc').value=objeto.cells[0].innerHTML;document.getElementById('idArchivoProcDiagrama').value=objeto.cells[0].innerHTML;}
}
function direccionAJAX(option,id){
 var direccionAJAX="<?php echo(base_url().'capitalHumano/');?>";
 var datos="";
 var bandConectar=1;
 var nombreTabla=null;
 var nombreClass=null;
 var opcion = "";
 var idCelda = "";
 var tipo = "";

  switch(option){
     case 0:
        datos='idFuncionProceso='+document.getElementById('idFuncionProceso').value;
       datos=datos+"&descripcionFP="+document.getElementById('inputFunciones').value;
       datos=datos+"&clasificacionFP=0";
       datos=datos+"&tipoFP="+document.getElementById('tipoFuncion').value;
       datos=datos+"&idPuesto="+document.getElementById('idPuesto').value;
       direccionAJAX=direccionAJAX+'operacionFuncionProceso/'; 
       nombreTabla='Funciones';
       opcion=2;nombreClass="classRATFuncion";
     break;
     case 1:
        var row=document.getElementsByClassName('classRATFuncion');
        if(row.length>0){
        datos=datos+"padreFP="+row[0].cells[0].innerHTML;
        datos=datos+'&descripcionFP='+document.getElementById('inputProcedimientos').value;
        datos=datos+'&clasificacionFP=2';
        direccionAJAX=direccionAJAX+'agregarProcedimientos/'; 
         nombreTabla='Procedimientos';nombreClass="classRATProcedimiento";
         opcion=3;
         idCelda = row[0].cells[0].innerHTML;
         tipo = "AgregarProcedimiento";
      }
      else{
        swal("¡Espera!", "Debes seleccionar una función", "warning");
        bandConectar=0;
      }
     break;
     case 2:
       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';
       nombreTabla="Procedimientos" ;nombreClass="classRATProcedimiento";
       opcion=3;
     break;
  case 3:
             datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';
       nombreTabla="Pasos" ;nombreClass="classRATPasos";
       opcion=5;
     break;
     case 4:
       var row=document.getElementsByClassName('classRATProcedimiento');
        if(row.length>0){
        datos=datos+"padreFP="+row[0].cells[0].innerHTML;
        datos=datos+'&descripcionFP='+document.getElementById('inputPasos').value;
        datos=datos+'&clasificacionFP=3';
        direccionAJAX=direccionAJAX+'agregarProcedimientos/'; 
         nombreTabla='Pasos';nombreClass="classRATPasos";
         opcion=5;
         }
     break;
     case 5:

     break;
     case 6:
            datos=datos+"idFuncionProceso="+id;
            direccionAJAX=direccionAJAX+'EliminarPF/';
            nombreTabla=null;opcion="Eliminar";nombreClass=null;       
     break;
     case 7:datos=datos+"idFuncionProceso="+document.getElementById("SelectparaMP").value;
            direccionAJAX=direccionAJAX+'traePFParaMatriz/';
            nombreTabla=null;opcion="traeProc";nombreClass=null; 
            break;
     case 8:datos=datos+"descripcionFP="+document.getElementById("inputNuevoMP").value ;
                datos=datos+'&clasificacionFP=4&tipoFP=1';datos=datos+"&idPuesto="+document.getElementById('idPuesto').value;
              direccionAJAX=direccionAJAX+'nuevoMP/';
            nombreTabla=null;opcion="nuevoMP";nombreClass=null; 
     break;
     case 9: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;direccionAJAX=direccionAJAX+'asignarFPU/';
     
            nombreTabla=null;opcion="asignarFPU";nombreClass=null; break;
     case 10: datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'devolverFPU/';nombreTabla=null;opcion="asignarFPU";nombreClass=null; break;
      case 11: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;direccionAJAX=direccionAJAX+'eliminarProcMP/';
      nombreTabla=null;opcion="eliminarProcMP";nombreClass=null; break;
        case 12: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;datos=datos+'&direccion=0';direccionAJAX=direccionAJAX+'cambioPosicionFuncion/';
      nombreTabla=null;opcion="procArriba";nombreClass=null; break;
      case 13: datos='idFuncionProceso='+id;datos=datos+'&idFuncionMP='+document.getElementById("selectMP").value;datos=datos+'&direccion=1';direccionAJAX=direccionAJAX+'cambioPosicionFuncion/';
      nombreTabla=null;opcion="procAbajo";nombreClass=null; break;
      case 14:       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverProcedimientosFuncion/';    nombreTabla=null;opcion="procCaptura";nombreClass=null; break;
      case 15:       datos=datos+"idFuncionProceso="+id;
       direccionAJAX=direccionAJAX+'devolverDescripPF/';
       nombreTabla=null;opcion="pasosCaptura";nombreClass=null;
     break;
     case 16:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'devolverFPUDatos/';nombreTabla=null;opcion="procPasosMP";nombreClass=null; break;
     case 17:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'verDocumentos/';nombreTabla=null;opcion="verDocumentos";nombreClass=null; break;
     case 18:datos='idFuncionMP='+id;direccionAJAX=direccionAJAX+'eliminarDocumento/';nombreTabla=null;opcion="verDocumentos";nombreClass=null; break;
     case 19:datos='idFuncionProceso='+id;direccionAJAX=direccionAJAX+'modificarFP/';nombreTabla=null;opcion="eliminarDocumentos";nombreClass=null; break;

  } 

  console.log(bandConectar, "case: "+option+", direccionAJAX: "+direccionAJAX+", datos: "+datos+", nombreTabla: "+nombreTabla+", opcion: "+opcion+", nombreClass: "+nombreClass+", idCelda: "+idCelda+", tipo: "+tipo);
  if(bandConectar){conectaAJAX(direccionAJAX,datos,nombreTabla,opcion,nombreClass,idCelda,tipo);};
}
function traeProc(respuesta){document.getElementById("listaProc").innerHTML=respuesta;}
function nuevoMP(respuesta){
  var select=document.getElementById("selectMP");
  select.innerHTML=respuesta;
select.value=select.options[select.length-1].value;

}
function asignaFuncionesMP(respuesta){
  document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta;
}
function conectaAJAX(url,parametros,nombreTabla,opcionAjax,nombreClass,id,clase){
  var req = new XMLHttpRequest();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    /*document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    document.getElementById('imgEspera').classList.toggle('verObjeto');*/
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {   /*document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');*/
      if(nombreTabla!=null)
       {
        if (nombreTabla == "Funciones") {
          enviaForm(2);
        }
        else {
          var respuesta=JSON.parse(this.responseText);
          console.log("Respuesta del envío: "+respuesta);
          procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass);
        }
       }
       else
       {
          
        var respuesta=JSON.parse(this.responseText);
           
         switch(opcionAjax){
          case 'Eliminar':eliminarFP(null,event);  break;
          case 'traeProc':traeProc(respuesta);break;
          case 'nuevoMP':nuevoMP(respuesta);break;
          case 'asignarFPU': asignaFuncionesMP(respuesta);break;
          case 'eliminarProcMP': break;
          case 'procArriba':document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta; break;
          case 'procAbajo':document.getElementById("contFuncionAsignadasMP").innerHTML=respuesta; break;
          case 'procCaptura':selectCapturaFuncion(respuesta); 
          case 'pasosCaptura': selectCapturaProc(respuesta); break;
          case 'procPasosMP':selectCapturaMP(respuesta) ;break;
          case 'verDocumentos':          
          if(respuesta.eliminarArchivo)
          {
            alert(respuesta.mensaje);
            document.getElementById('archivosProcedimiento'+respuesta.archivo).parentNode.removeChild(document.getElementById('archivosProcedimiento'+respuesta.archivo));
          }
          else{
          mostrarEnlacesDoc(respuesta); }break;
          case 'eliminarDocumentos':swal("", respuesta, "info");break;
         }
       }                                              
      }     
   }
  };
 req.send(parametros);
}

/*Modificado - Nueva versión Puestos*/
function procesaRespuestaAJAX(respuesta,nombreTabla,opcionAjax,nombreClass){
  console.log("procesaRespuestaAJAX",respuesta, nombreTabla, opcionAjax, nombreClass);
 var cant=respuesta.length;
 var rows="";
 var claseRow="";
 if(nombreTabla=="Funcion"){claseRow="rowFuncion";}else{if(nombreTabla=="Procedimientos"){claseRow="rowProcedimientos"}else{claseRow="rowPasos"}}
 if(typeof(respuesta)=='number'){
    console.log(2,respuesta);
    //direccionAJAX(2,respuesta);
  rows=document.createElement('tr');
  rows.dataset.valor=respuesta;
  rows.setAttribute('onclick','guardaIdFuncion('+opcionAjax+',this,"'+nombreClass+'")');
  cell1=document.createElement('td')
  cell1.innerHTML=respuesta;
  cell2=document.createElement('td');
  cell2.innerHTML=document.getElementById("input"+nombreTabla).value;
  cell4=document.createElement('td');
  cell4.innerHTML='<button class="btn btn-danger" title="Eliminar" onclick=\'eliminarFP(this,event)\'><i class="fas fa-trash-alt"></i></button>';

  rows.appendChild(cell1);
  rows.appendChild(cell2);
  if(nombreTabla=="Procedimientos"){cell3=document.createElement('td');cell3.innerHTML='<button class="btn btn-default" title="Documentos" onclick=\'verDocumentos(this,event)\'><i class="fas fa-file-alt"></i></button>'; rows.appendChild(cell3); }
  rows.appendChild(cell4);
    cell4=document.createElement('td');
    cell4.innerHTML='<button class="btn btn-primary" title="Guardar" onclick=\'guardarModificacionFP(this,event)\'><i class="fa fa-floppy-o"></i></button>';
     rows.appendChild(cell4);

  document.getElementById('tabla'+nombreTabla).appendChild(rows);

 }else{

 for(var i=0;i<cant;i++)
  { 
    rows=rows+'<tr onclick=\'guardaIdFuncion('+opcionAjax+',this,\"'+nombreClass+'\")\' class=\"'+claseRow+'\" data-valor=\"'+respuesta[i].idFuncionProceso+'\">';
    rows=rows+'<td>'+respuesta[i].idFuncionProceso+'</td>';
    rows=rows+'<td contenteditable="true">'+respuesta[i].descripcionFP+'</td>';
    if(nombreTabla=="Procedimientos" ){rows=rows+ '<td><button class="btn btn-default" title="Documentos" onclick=\'verDocumentos(this,event)\'><i class="fas fa-file-alt"></i></button></td>';}
    rows=rows+ '<td ><button class="btn btn-danger" title="Eliminar" onclick=\'eliminarFP(this,event)\'><i class="fas fa-trash-alt"></i></button></td>';
     rows=rows+ '<td ><button class="btn btn-primary" title="Guardar" onclick=\'guardarModificacionFP(this,event)\'><i class="fa fa-floppy-o"></i></button></td>';
     if(nombreTabla=="Procedimientos" || nombreTabla=="Pasos"){rows=rows+ '<td style="padding:8px;"><button class="btn" onclick=\'moverProcedimiento(1,'+respuesta[i].idFuncionProceso+')\'>▲</button></td>';rows=rows+ '<td style="padding:8px;"><button class="btn" onclick=\'moverProcedimiento(0,'+respuesta[i].idFuncionProceso+')\'>▼</button></td>';}
    rows=rows+'<tr>';
  }

  if (respuesta == 0 || respuesta == null || respuesta == undefined) {
    rows = "<tbody><tr><td>Sin resultados</td></tr></tbody>";
  }
  document.getElementById("tabla"+nombreTabla).innerHTML=rows;
 }
  
}

function crerFuncionProceso(){
  document.getElementById("idFuncionProceso").value=0;
  document.getElementById("descripcionFP").value="";
  //document.getElementById("clasificacionFP").value=0;
}
function tamanioCeldas(){
  if(objetoFoco.nodeName.toUpperCase()=='TABLE')
    { 
      objetoFoco.rows[0].cells[cellIndex].setAttribute('style','width:200px');

    }
}
function datosParaPlantilla(){
  let contenteditable=' contenteditable="true" ';
  document.getElementById('divContenidoPP').innerHTML='<ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
  document.getElementById('divContenidoMP').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
  document.getElementById('divContenidoFPR').innerHTML='<ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
  document.getElementById('divContenidoEC').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Administrativa:</u></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Operativa:</u></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Dirección Comercial:</u></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Clientes:</u></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>Con Proveedores:</u></p>';
  document.getElementById('divContenidoPRP').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>EXPERIENCIA:</b></p><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>HABILIDADES:</b></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>COMPETENCIAS CLAVES DEL PUESTO:</b></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
  document.getElementById('divContenidoCTD').innerHTML='<ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
  document.getElementById('divContenidoPER').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">PUESTOS <u>AL QUE REPORTA:</u><div><u>FRECUENCIA DE REPORTE:</u></div><div><u>INFORMACION QUE REPORTA:</u></div></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><u>PUESTO QUE LE REPORTAN:</u><div><u>FRECUENCIA DE REPORTE:</u></div><div>I<u>NFORMACION QUE REPORTA:</u></div></p><ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"></li></ul>';
  document.getElementById('divContenidoNCBC').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><b>Tipo de Nómina: Semanal() Quincenal(x) Otro()</b><div><b>Sueldo: $</b></div><div><b>Comisiones:$</b></div><div><b>Bonos en especie:</b></div><div><b>Otro tipo de ingreso:</b></div></p>';
  document.getElementById('divContenidoPO').innerHTML='<ul '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)" onkeyup="eliminarDirecto(this)"><li onkeyup="eliminarDirecto(this)"><b>UBICACIO DE TRABAJO:</b></li><li onkeyup="eliminarDirecto(this)"><b>DIRECCION DE ÁREA PERTENECIENTE:</b></li><li onkeyup="eliminarDirecto(this)"><b>POSICION EN ORGANIGRAMA:</b></li></ul>';
  document.getElementById('divContODPProc').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"><div><br></div></p>';
  document.getElementById('divContAPProc').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
  document.getElementById('divContRAProc').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)"></p>';
  document.getElementById('divContDTAProc').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">4.1 Acrónimos</p><table border="2" '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Acrónimo</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripción</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table><p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">4.2 Definiciones y Términos</p><table border="2" '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Término</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripción</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table>';
  document.getElementById('divContPPProc').innerHTML='<p '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this,event)" onkeyup="eliminarDirecto(this)">5.1 Políticas Generales y Específicas</p><table border="2" '+contenteditable+' class="estlGnralMU" onclick="objetoFocoEvent(this)"><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)">Politica #</td><td class="celdaTabla" onclick="guardaIndexTabla(this)">Descripcion</td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr><tr onclick="guardaIndexTabla(this)"><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td><td class="celdaTabla" onclick="guardaIndexTabla(this)"></td></tr></table>';
}

/*Modificado - Nueva versión Puestos*/
function manejoPestanias(nombre){
  var pestania=document.getElementsByClassName("divPestania")
  var contPestania=pestania.length;
  for(var i=0;i<contPestania;i++){
    pestania[i].classList.add("ocultarObjeto");
    pestania[i].classList.add("pestaniaOff")
    pestania[i].classList.remove("verObjeto");
        pestania[i].classList.remove("pestaniaOn");
  }
  /*if(nombre=="divOrganigrama" || nombre=="divFunciones" || nombre=="divMatrizProc" || nombre=="divMatrizDoc" || nombre=="divVisor" || nombre=="divMatrizFastFile"){document.getElementById('divBarTool').classList.remove('verObjeto');document.getElementById('divBarTool').classList.add('ocultarObjeto');
    //Miguel Jaime 22/11/2021 //Comentado por Dennis Castillo [2022-04-04]
    //if(nombre=="divMatrizFastFile"){
      //getFastFile('<?php //echo $idPersona?>','<?php //echo date('Y')?>');
    //}
    //Fin Modificacion
  }
  else{
    document.getElementById('divBarTool').classList.add('verObjeto');
    document.getElementById('divBarTool').classList.remove('ocultarObjeto');
  }
  document.getElementById(nombre).classList.remove("ocultarObjeto");
  document.getElementById(nombre).classList.add("verObjeto");
     document.getElementById(nombre).classList.add("pestaniaOn");
  document.getElementById(nombre).classList.remove("pestaniaOff")*/
}
function formatoTexto(accion){
  var valor=null;
 if(accion=='foreColor' || accion=='backColor'){valor=document.getElementById('colorTextMU').value;}
  
  //  document.execCommand("foreColor", false, 'Red');
  document.execCommand(accion,false,valor);
  //document.execCommand("foreColor",'black');
}
function objetoFocoEvent(objeto,e){
 
  objetoFoco=objeto;
 
  activaPestania(objetoFoco.parentNode,'h');
}
function guardaIndexTabla(objeto){
  if(objeto.nodeName.toUpperCase()=='TR'){
      {rowIndex=objeto.rowIndex;}
  }
    else{cellIndex=objeto.cellIndex;}
}
function eliminarFila(){
 if(objetoFoco.nodeName=='TABLE'){
  objetoFoco.deleteRow(rowIndex);rowIndex=rowIndex-1;
  if(objetoFoco.childNodes.length==0){eliminarObjeto();}
 }
}
function eliminarColumna(){
  if(objetoFoco.nodeName=='TABLE'){
     rows=objetoFoco.rows.length;
     for(var i=0;i<rows;i++){
      objetoFoco.rows[i].deleteCell(cellIndex);
     }
     cellIndex=cellIndex-1;
     if(objetoFoco.rows[0].childNodes.length==0){eliminarObjeto();}
     //objetoFoco.rows[0].deleteCell(cellIndex);
  //objetoFoco.deleteRow(rowIndex);rowIndex=rowIndex-1;
  //if(objetoFoco.childNodes.length==0){eliminarObjeto();}
   }
}
function eliminarObjeto(){
  padre=objetoFoco.parentNode;
  padre.removeChild(objetoFoco);  
}

function manejoVistaContenido(nombreObjeto){
  var objeto=document.getElementById(nombreObjeto);
  var sw=document.getElementById('sw').value;
  if(sw==0){
    objeto.style.display="block";  
    document.getElementById('sw').value=1;
  }else{
    objeto.style.display="none";  
    document.getElementById('sw').value=0;
  }
  
  if(objeto.childNodes.length>0){ objetoFoco=objeto;}
  else{objetoFoco=null;}
 contieneElementoActivo=nombreObjeto;
    activaPestania(objeto,'p');
   vistaAnterior=objeto;
}

function activaPestania(objeto,llamado){
  
   if(vistaAnterior==""){objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');}
   else{if(objeto.id==vistaAnterior.id){objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');}
        else{objeto.parentNode.classList.remove('divPadreContMU');objeto.parentNode.classList.add('divPadreContMUActivo');vistaAnterior.parentNode.classList.add('divPadreContMU');vistaAnterior.parentNode.classList.remove('divPadreContMUActivo');if(objeto.childNodes.length>0){if(llamado=='p'){objeto.childNodes[0].focus();objetoFoco=objeto.childNodes[0];}}}}
        vistaAnterior=objeto;
       contieneElementoActivo=objeto.id;
 
}
function eliminarDirecto(tipoObjeto){
 tipoObjeto=tipoObjeto.nodeName;
 if(document.activeElement.innerHTML.length==0){bandBorrado=bandBorrado+1;}
 if(tipoObjeto=='UL' && document.activeElement.innerHTML.length==0){bandBorrado=2;}

 if(bandBorrado==2){
  var padre=document.activeElement.parentNode;
  switch(tipoObjeto){
  case 'LABEL':padre.removeChild(document.activeElement.previousSibling);
  padre.removeChild(document.activeElement);
  if(padre.childNodes.length==0)
  {objetoFoco=padre;eliminarObjeto();}break;
   case 'DIV':eliminarObjeto();break;
   case 'UL':if(objetoFoco.childNodes.length==0){eliminarObjeto();}break;
    }

    bandBorrado=0;
   }

}
function onclickCheck(objeto){
 if(objeto.checked){
  objeto.setAttribute('checked','');
 }
 else{ objeto.removeAttribute('checked');}
}
function insertaObjetos(tipoObjeto){
  var objetoEnCreacion;
  
  switch (tipoObjeto){
  case 'p':objetoEnCreacion=document.createElement('div') ; 
           objetoEnCreacion.setAttribute('contentEditable','true'); 
           objetoEnCreacion.setAttribute('class','estlGnralMU');
            objetoEnCreacion.classList.add('estiloParrafo');
             objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this,event)');

             objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
    break;
  case 'ul': objetoEnCreacion=document.createElement('ul'); 

             objetoEnCreacion.setAttribute('contentEditable','true'); 
             objetoEnCreacion.setAttribute('class','estlGnralMU');
             objetoEnCreacion.classList.add('estiloLista');
               objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
               objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
               objetoLI=document.createElement('li');  
                objetoLI.setAttribute('onkeyup','eliminarDirecto(this)');
      objetoEnCreacion.appendChild(objetoLI);break;
     
  case 'check':
      objetoCheck=document.createElement('input'); 
      objetoCheck.setAttribute('type','checkbox');
     // objetoCheck.setAttribute('checked','false');
      objetoCheck.setAttribute('onclick','onclickCheck(this)');
      objetoCheck.setAttribute('class','estlGnralMU');
      objetoLabel=document.createElement('label');
      objetoLabel.setAttribute('contentEditable','true');
      objetoLabel.setAttribute('class','labelDeCheck');
      objetoLabel.setAttribute('onkeyup','eliminarDirecto(this)');
      objetoLabel.innerHTML="Click";
 
  if(objetoFoco){
    if(!objetoFoco.classList.contains('contCheck'))
    {
      objetoEnCreacion=document.createElement('div');
      objetoEnCreacion.appendChild(objetoCheck);
      objetoEnCreacion.appendChild(objetoLabel);     
       objetoEnCreacion.setAttribute('class','estlGnralMU');
       objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
       objetoEnCreacion.classList.add('contCheck')

    }
    else
    {
      objetoFoco.appendChild(objetoCheck);
      objetoFoco.appendChild(objetoLabel);   
      tipoObjeto='insertado';  
    }
    }else{
            objetoEnCreacion=document.createElement('div');
      objetoEnCreacion.appendChild(objetoCheck);
      objetoEnCreacion.appendChild(objetoLabel);     
       objetoEnCreacion.setAttribute('class','estlGnralMU');
       objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
       objetoEnCreacion.classList.add('contCheck')
    }
  break; 
  case 'table':
              //objetoEnCreacion=document.createElement('div');
              objetoEnCreacion=document.createElement('table');
              objetoEnCreacion.setAttribute('class','celdaTabla');
              objetoTR=document.createElement('tr');
              objetoTR.setAttribute('onclick','guardaIndexTabla(this)');
              objetoTR.setAttribute('class','rowTabla');
              objetoTD=document.createElement('td');

              objetoTD.setAttribute('class','celdaTabla');
              objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
                objetoTD.setAttribute('style','');

              objetoTR.appendChild(objetoTD);
              objetoEnCreacion.appendChild(objetoTR);
              objetoEnCreacion.setAttribute('border','2');
                objetoEnCreacion.setAttribute('contentEditable','true');
              objetoEnCreacion.setAttribute('class','estlGnralMU');
              objetoEnCreacion.classList.add('classTabla');
                objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this)');
               break;
    case 'tr':tipoObjeto='insertado';
              if(objetoFoco.nodeName.toUpperCase()=='TABLE')
              {
                var columnas=objetoFoco.rows[0].cells.length;
                objetoTR=document.createElement('tr');
                 objetoTR.setAttribute('class','rowTabla');
                objetoTR.setAttribute('onclick','guardaIndexTabla(this)');
                for(var i=1;i<=columnas;i++){
                  objetoTD=null;
                  objetoTD=document.createElement('td');
                  objetoTD.setAttribute('class','celdaTabla');
                  objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
                  objetoTD.setAttribute('style','');
                  objetoTR.appendChild(objetoTD);

                }
                objetoFoco.appendChild(objetoTR);
              }
              break;
     case 'td':
     tipoObjeto='insertado';
              if(objetoFoco.nodeName.toUpperCase()=='TABLE')
              {
                var filas=objetoFoco.rows.length;
                for(var i=0;i<filas;i++)
                {
                   objetoTD=document.createElement('td');
                     objetoTD.setAttribute('class','celdaTabla')
                  objetoTD.setAttribute('onclick','guardaIndexTabla(this)');
                  objetoTD.setAttribute('style','');
                  objetoFoco.rows[i].appendChild(objetoTD);
                }

              }
              break;
        case 'a':
             var link=prompt('link','direccion web');
             objetoA="";
            if (link != null && link != "") 
            {
              objetoEnCreacion=document.createElement('div') ; 
           objetoEnCreacion.setAttribute('class','estlGnralMU');
             objetoEnCreacion.setAttribute('onclick','objetoFocoEvent(this,event)');

             objetoEnCreacion.setAttribute('onkeyup','eliminarDirecto(this)');
              objetoA=document.createElement('a') ; 
              objetoA.setAttribute('class','estlGnralMU');
             objetoA.setAttribute('onclick','objetoFocoEvent(this,event)');
             objetoA.setAttribute('href',link);
             objetoA.setAttribute('target','_blank');
              objetoA.innerHTML=link;
              objetoA.setAttribute('oncontextmenu','eliminarTagA(this)')
              objetoEnCreacion.appendChild(objetoA);
            }            
         break;

 }
   if(tipoObjeto!='insertado'){
     if(objetoFoco==""){document.getElementById(contieneElementoActivo).appendChild(objetoEnCreacion);}
     else
     {
      
        if(document.getElementById(contieneElementoActivo).childNodes.length>0)
        {document.getElementById(contieneElementoActivo).insertBefore(objetoEnCreacion,objetoFoco.nextSibling);}
        else{document.getElementById(contieneElementoActivo).appendChild(objetoEnCreacion);}
     }
  objetoFoco=objetoEnCreacion;
  objetoEnCreacion.focus();}
}
    <?php

   //$opciones="";
   //foreach ($puestos as $key => $value) {$opciones=$opciones.'<option value="'.$value->idPuesto.'">'.$value->personaPuesto.'</option>';}
  
   //echo('document.getElementById("buscarIdPuesto").innerHTML=\''.$opciones.'\';');
   //echo('document.getElementById("padrePuesto").innerHTML=\''.$opciones.'\';');
   //echo('document.getElementById("SelectparaMP").innerHTML=\''.$opciones.'\';');
 ?>
function eliminarTagA(objeto){
  var padre=objeto.parentNode;
  var padrePadre=padre.parentNode;
   padre.removeChild(objeto);
   padrePadre.removeChild(padre); 
}
 function funcionesPuesto(objeto){
  if(objeto.checked){objeto.classList.add("asignaFPEstilo");}
  else{objeto.classList.remove("asignaFPEstilo");}
 }
function imprimirManualUsuario(){
  if(document.getElementsByClassName("pestaniaOn")[0].id=="divManual"){
  crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/generaPDF');
 }else{
  if(document.getElementById("selectOpcionProc").value!=-1 && document.getElementById("selectCapturaFuncion").value!=-1 && document.getElementById("selectCapturaProc").value!=-1  ){
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classImprimir','selectOpcionProc');
    crearObjetosParaForm(document.getElementById("selectCapturaFuncion").value,'classImprimir','selectCapturaFuncion');
    crearObjetosParaForm(document.getElementById("selectCapturaProc").value,'classImprimir','selectCapturaProc');
     crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/generaPDF');

  }else{alert("Seleccion los datos completos");}
 }
}
function imprimirTodoElManual(){

  if(document.getElementById("selectOpcionProc").value!=-1  ){
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classImprimir','selectOpcionProc');
     crearObjetosParaForm(document.getElementById("idPuesto").value,'classImprimir','idPuesto');
   enviarFormGenerales('classImprimir','capitalHumano/imprimirTodoElManual');

  }else{alert("Escoger Funcion o Matriz de Procesos");}
 
}





 function guardarManualUsuario(){
 if(document.getElementsByClassName("pestaniaOn")[0].id=="divManual"){
  
    crearObjetosParaForm(document.getElementById("divContenidoPRP").innerHTML,'classProcManus','divContenidoPRP');
    crearObjetosParaForm(document.getElementById("divContenidoPP").innerHTML,'classProcManus','divContenidoPP');
    crearObjetosParaForm(document.getElementById("divContenidoMP").innerHTML,'classProcManus','divContenidoMP');
    crearObjetosParaForm(document.getElementById("divContenidoFPR").innerHTML,'classProcManus','divContenidoFPR');
    crearObjetosParaForm(document.getElementById("divContenidoEC").innerHTML,'classProcManus','divContenidoEC');
    crearObjetosParaForm(document.getElementById("divContenidoAGT").innerHTML,'classProcManus','divContenidoAGT');    
    crearObjetosParaForm(document.getElementById("divContenidoCTD").innerHTML,'classProcManus','divContenidoCTD');
    crearObjetosParaForm(document.getElementById("divContenidoPER").innerHTML,'classProcManus','divContenidoPER');
    crearObjetosParaForm(document.getElementById("divContenidoNCBC").innerHTML,'classProcManus','divContenidoNCBC');
    crearObjetosParaForm(document.getElementById("divContenidoPO").innerHTML,'classProcManus','divContenidoPO');
    crearObjetosParaForm(document.getElementById("divContenidoDIO").innerHTML,'classProcManus','divContenidoDIO');
    crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','idPuesto');
    crearObjetosParaForm(document.getElementById("divContenidoMP").textContent,'classProcManus','forNewTable'); //Dennis Castillo [2021-10-31]

     enviarFormGenerales('classProcManus','capitalHumano/guardarManualUsuario');
  
  }
  else{
    if(document.getElementById("selectOpcionProc").value!="-1"){
    if(document.getElementById("selectOpcionProc").value=="divCapturaFuncion"){
    crearObjetosParaForm(document.getElementById("divContODPProc").innerHTML,'classProcManus','divContODPProc');
    crearObjetosParaForm(document.getElementById("divContAPProc").innerHTML,'classProcManus','divContAPProc');
    crearObjetosParaForm(document.getElementById("divContRAProc").innerHTML,'classProcManus','divContRAProc');
    crearObjetosParaForm(document.getElementById("divContDTAProc").innerHTML,'classProcManus','divContDTAProc');
    crearObjetosParaForm(document.getElementById("divContPPProc").innerHTML,'classProcManus','divContPPProc');
    crearObjetosParaForm(document.getElementById("selectCapturaProc").value,'classProcManus','idFuncionProceso');
    crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','buscarIdPuesto');
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
    crearObjetosParaForm(document.getElementById("selectCapturaFuncion").value,'classProcManus','selectCapturaFuncion');
      enviarFormGenerales('classProcManus','capitalHumano/grabarManualProcedimiento');
     }else{
    crearObjetosParaForm(document.getElementById("divContODPProc").innerHTML,'classProcManus','divContODPProc');
    crearObjetosParaForm(document.getElementById("divContAPProc").innerHTML,'classProcManus','divContAPProc');
    crearObjetosParaForm(document.getElementById("divContRAProc").innerHTML,'classProcManus','divContRAProc');
    crearObjetosParaForm(document.getElementById("divContDTAProc").innerHTML,'classProcManus','divContDTAProc');
    crearObjetosParaForm(document.getElementById("divContPPProc").innerHTML,'classProcManus','divContPPProc');
    crearObjetosParaForm(document.getElementById("selectOpcionProc").value,'classProcManus','selectOpcionProc');
    crearObjetosParaForm(document.getElementById("selectCapturaMP").value,'classProcManus','idFuncionProceso');
    crearObjetosParaForm(document.getElementById("buscarIdPuesto").value,'classProcManus','buscarIdPuesto');
    enviarFormGenerales('classProcManus','capitalHumano/grabarManualProcedimientoMP');

     }

     }
  
  }
}
 function grabarMUAJAX(url,parametros){
    var req = new XMLHttpRequest();
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  req.onreadystatechange = function (aEvt) 
  {     
     if (req.readyState == 4) {if(req.status == 200)
       {                                               
      }     
   }
 };
 req.send(parametros);
 }
function devuelveFuncionesAJAX(opcion,id,objeto){
  
  objetoClick=objeto.parentNode;
  
  var cantidadHijosClick=objetoClick.childNodes.length;
for(var i=0;i<cantidadHijosClick;i++){
  if(objetoClick.childNodes[i].classList.contains('verObjeto') && !objetoClick.classList.contains('inicialClass') && objetoClick.childNodes[i].nodeName!="LABEL" )
  {objetoClick.childNodes[i].classList.add('ocultarObjeto');objetoClick.childNodes[i].classList.remove('verObjeto');}
  else{
    objetoClick.childNodes[i].classList.remove('ocultarObjeto');objetoClick.childNodes[i].classList.add('verObjeto');
  }

    if(objetoClick.childNodes[i].nodeName=='DIV'){
      for(var j=0;j<objetoClick.childNodes[i].childNodes.length;j++){
         
           if(objetoClick.childNodes[i].childNodes[j].classList.contains('verObjeto') ){
objetoClick.childNodes[i].childNodes[j].classList.remove('verObjeto');
objetoClick.childNodes[i].childNodes[j].classList.add('ocultarObjeto');
           }else{
objetoClick.childNodes[i].childNodes[j].classList.add('verObjeto');objetoClick.childNodes[i].childNodes[j].classList.remove('ocultarObjeto');
           }
      }
    }
  }

  



  //objeto.parentNode.childNodes[1].classList.add('verObjeto');
  //for(var i=0;i<cantidadHijos;i++){
    //objeto.parentNode.childNodes[i].classList.add('verObjeto');
  //}
  /*var url="";
  switch(opcion){
    case 0: var idPuesto=document.getElementById('idPuesto').value ;url='<?=base_url()?>capitalHumano/devuelveFunciones/?idPuesto='+idPuesto;  break;
    case 1: ;url='<?=base_url()?>capitalHumano/devolverFuncionesAsignadas/?idPuesto='+id;break;
  }
  var req = new XMLHttpRequest();
  req.open('GET', url, true);
  req.onreadystatechange = function (aEvt) 
  {     
     if (req.readyState == 4) {if(req.status == 200)
       {var datos=JSON.parse(this.responseText);   
         document.getElementById("divFuncionesAsignar").classList.add('ventanaFPStyle');
         document.getElementById("divFuncionesAsignar").innerHTML=datos;                                                
      }     
   }
 };
 req.send();*/

}


 function habilitarCaptura(){
 objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
    //objetosForm[i].
  }
 }
 function deshabilitarCaptura(){
 objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
    //objetosForm[i].
  }
 }
  function listaMatrizProc(objeto){
   if(objeto.parentNode.classList.contains('mpOcultar')){objeto.parentNode.classList.add('verHijos');objeto.parentNode.classList.remove('mpOcultar');objeto.innerHTML="-";}
   else{
     objeto.parentNode.classList.remove('verHijos');objeto.parentNode.classList.add('mpOcultar');objeto.innerHTML="+";
     }
 
 }
 




<?php  if(isset($personaPuesto)){
  ?>
    if(document.getElementById("buscarIdPuesto")){document.getElementById("buscarIdPuesto").value=<?php echo('"'.$personaPuesto->idPuesto.'";') ;?>;}

<?php
}
?>



<?php
$datos='';
$datosSelect='';
?>
document.getElementById('tablaFunciones').innerHTML=" <?php echo($datos); ?>";
<?php if(isset($pestania)){ ?>
manejoPestanias(<?php echo('"'.$pestania.'"'); ?>)
<?php } ?>
<?php if(isset($selectOpcionProc)){  if($selectOpcionProc=="divCapturaFuncion"){ ?>
document.getElementById("selectOpcionProc").value=<?php echo('"'.$selectOpcionProc.'"'); ?>;
var objeto=document.getElementById("selectOpcionProc");
selectOpcionProc(objeto);
document.getElementById("selectCapturaFuncion").value=<?php echo('"'.$selectCapturaFuncion.'"') ;?>;
selectCapturaFuncion(document.getElementById("selectCapturaFuncion"));
document.getElementById("selectCapturaProc").value=<?php echo('"'.$selectCapturaProc.'"') ;?>;
varCapturaProc=<?php echo('"'.$selectCapturaProc.'"') ; }else {?>;
document.getElementById("selectOpcionProc").value=<?php echo('"'.$selectOpcionProc.'"'); ?>;
selectOpcionProc(document.getElementById("selectOpcionProc"));
 document.getElementById('selectCapturaMP').value=<?php echo($selectCapturaMP); ?>;
 selectCapturaMP(document.getElementById('selectCapturaMP'));
<?php }} ?>

</script>


  <script src="https://www.gstatic.com/firebasejs/3.6.7/firebase.js"></script>
  <script>
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyBa6S-7_FtZE_cMxNz33e1Tvil3PGnON_4",
        authDomain: "v3plus-279402.firebaseapp.com",
        databaseURL: "https://v3plus-279402.firebaseio.com",
        projectId: "v3plus-279402",
        storageBucket: "v3plus-279402.appspot.com",
        messagingSenderId: "4568272251",
        appId: "1:4568272251:web:483a7b036920897138c1de",
        measurementId: "G-8EJP31SQZ7"
    };
    firebase.initializeApp(config);
  </script>
<script type="text/javascript">

 // Servicios de APIs Firebase
    var authService = firebase.auth();
    var storageService = firebase.storage();

    window.onload = function() {
      authService.signInAnonymously()
        .catch(function(error) {
          console.error('Detectado error de autenticación', error);
        });

      //manejador de evento para el input file
      // document.getElementById('imagen').addEventListener('change', function(evento){
      //   evento.preventDefault();
      //   var archivo  = evento.target.files[0];
      //   subirImagen(archivo);
      // });
    
    };

    // defino el uploadTask como variable global, porque lo voy a necesitar
    var uploadTaskImagen;
    function subirImagen(archivo) {
      var refStorage = storageService.ref('organigrama').child(archivo.name);
      uploadTaskImagen = refStorage.put(archivo);

      // El evento donde comienza el control del estado de la subida
      uploadTaskImagen.on('state_changed', registrandoEstadoSubidaImagen, errorSubidaImagen, finSubidaImagen);

      //Callbacks para controlar los distintos instantes de la subida
      function registrandoEstadoSubidaImagen(uploadSnapshot) {
        var calculoPorcentaje = (uploadSnapshot.bytesTransferred / uploadSnapshot.totalBytes) * 100;
        calculoPorcentaje = Math.round(calculoPorcentaje);
        registrarPorcentajeImagen (calculoPorcentaje);
      }
      function errorSubidaImagen(err) {
        console.log('Error al subir el archivo', err);
      }
      function finSubidaImagen(){
        console.log('Subida completada');
        console.log('el archivo está subido. Su ruta: ', uploadTaskImagen.snapshot.downloadURL);
        enlaceSubidoImagen(uploadTaskImagen.snapshot.downloadURL);
      }

    }

     // mostramos el porcentaje en cada instante de la subida de imagen
    function registrarPorcentajeImagen(porcentaje) {
      var elMensaje = document.getElementById('mensajeImagen');
      var textoMensaje = '<p style="font-size:16px;font-weight:bold;">Porcentaje de subida: ' + porcentaje + '%</p>';
      elMensaje.innerHTML = textoMensaje;
    }
     //mostramos el link para acceso al archivo al final de la subida
    function enlaceSubidoImagen(enlace) {
      document.getElementById('enlaceImagen').href = enlace;
      document.getElementById('archivoImagen').style.display = 'block';
      var imagen=($('#imagen'))[0].files[0];
      guardar_organigrama(imagen);
      
    }  

    function guardar_organigrama(imagen){
       var url=$('#base').val()+"capitalHumano/guardar_organigrama";
      $.ajax({
          type: "POST",
          dataType: 'html',
          url: url,
          data: "imagen="+imagen.name,
          success: function(resp){
          }
      });
    }   




function muestraCCP(objeto)
{
  let dat=objeto.getAttribute('data-ppg');
  let puesto=objeto.getAttribute('data-puesto');
  if(document.getElementById('divCCP'+dat))
  {
    document.getElementById('bodyContieneCCP').innerHTML='<h2 class="title-center-puesto">'+puesto+'</h2>'+document.getElementById('divCCP'+dat).innerHTML;
  }
  else
  {
   document.getElementById('bodyContieneCCP').innerHTML='<h2 class="title-center-puesto">'+puesto+'</h2><div class="subtitle-center-puesto">No tiene puestos ocupados</div>'; 
  }
}
</script>
<style type="text/css">
/*.tree{overflow: scroll;width: 800px; height: 300px; overflow-x: 1000px; border: solid; }*/
 /*Now the CSS*/
  * {margin: 0; padding: 0;}
 .tree ul {padding-top: 20px; position: relative;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;}
 .tree li {float: left; text-align: center;list-style-type: none;position: relative;padding: 20px 5px 0 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;  }
 /*Usaremos :: before y :: after para dibujar los conectores*/
 .tree li::before, .tree li::after{content: '';position: absolute; top: 0; right: 0%;border-top: 1px solid #ccc;width: 100%; height: 20px;}
 .tree li::after{right: auto; left: 50%;border-left: 1px solid #ccc;}
 /*Necesitamos eliminar los conectores izquierdo-derecho de los elementos sin hermanos*/
 .tree li:only-child::after, .tree li:only-child::before {display: none;}
 /*Eliminar el espacio de la parte superior de los nodos solos*/
 .tree li:only-child{ padding-top: 0;}
 /*Retira el conector izquierdo del primer hijo y el conector derecho del último hijo*/
 .tree li:first-child::before, .tree li:last-child::after{
  border: 0 none;
 }
 /*Agregar de nuevo el conector vertical a los últimos nodos*/
 .tree li:last-child::before{border-right: 1px solid #ccc;border-radius: 0 5px 0 0;-webkit-border-radius: 0 5px 0 0;-moz-border-radius: 0 5px 0 0;}
 .tree li:first-child::after{border-radius: 5px 0 0 0;-webkit-border-radius: 5px 0 0 0;-moz-border-radius: 5px 0 0 0;
 }
 /*Time to add downward connectors from parents*/
 .tree ul ul::before{content: '';position: absolute; top: 0; left: 50%;border-left: 1px solid #ccc;width: 1500; height: 20px;
 }
 .tree li label{border: 1px solid #ccc;padding: 2px 5px;text-decoration: none;color: #666;font-family: arial, verdana, tahoma;font-size: 8px;display: inline-block;border-radius: 1px;-webkit-border-radius: 5px;-moz-border-radius: 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s; background-color: #68d668; color: black;width: 100px}
 .tree li a{
  border: 1px solid #ccc;padding: 5px 10px;text-decoration: none;color: #666;font-family: arial, verdana, tahoma;font-size: 11px;display: inline-block;border-radius: 5px;-webkit-border-radius: 5px;-moz-border-radius: 5px;transition: all 0.5s;-webkit-transition: all 0.5s;-moz-transition: all 0.5s;
 }
 /*Time for some hover effects*/
 /*We will apply the hover effect the the lineage of the element also*/
 .tree li a:hover, .tree li a:hover+ul li a {background: #c8e4f8; color: #000; border: 1px solid #94a0b4;}
 /*Connector styles on hover*/
 .tree li a:hover+ul li::after, 
 .tree li a:hover+ul li::before, 
 .tree li a:hover+ul::before, 
 .tree li a:hover+ul ul::before{border-color:  #94a0b4;}
 /*Thats all. I hope you enjoyed it.Thanks :)*/
  .ventanaFPStyle {border: 4px solid #472380; background-color: white;color:black;position:fixed;top:50%;left:40%;font-size:20px;z-index:100}
  .labelFAP{font-size: large;color: black; background-color: white; }
  .verObjeto{display: block;}
  .ocultarObjeto{display: none;}
  .estlGnralMU{color: black;border:none;border:groove; margin:0;padding: 10px;}
  p[class="estlGnralMU"]{color:black;}
  ul[class="estlGnralMU"]{color:black;}
  .centrarContenido{margin-left: 25%;margin-right: 25%;border: solid}
.divContMU{border:solid; border-color: #6197cd;background-color: white}
 .divPadreContMU{background-color: #6b6b6b;margin-top: 0%;clear: both}
 .divPadreContMUActivo{background-color: #55b171;margin-top: 0%;  }
  .labelTitContMU{color: white; width: 100%;margin-top: 1%; border: solid; border-color:black; position: relative; top: -10px; height: auto; }
  .labelDeCheck{width: 100px;height: 20px;border: thin;color: black}
  .celdaTabla{height: 12px;border: solid; width: 100px}
  .divBarTool{float: left;border-right: 1px solid #bdbdbd;;margin-right: 10px;margin-bottom: 5px;padding-right: 10px;display: flex;align-items: center;}
  .classTabla{width: 100%}
  .classTabla td{width: auto;}
  .classDiv{resize:right;border:solid; }
  .tablaFunciones tr:hover {color: orange}
  .classRATFuncion {background-color: #9ce69c}
  .classRATProcedimiento {background-color: #b3f2b3}
  .classRATPasos {background-color: #b3f2b3}
  .mpOcultar li {display:none}
.verHijos  li{display:block}
.labelLlave{border:solid 1px blue}
.labelLlaveMP:hover {background-color:#7171cc}
.labelMP{margin-left:5px}
.ulMP{margin-left: 25px}
.divAparienciaManuales{height: 400px; overflow: scroll;"}
.buttonMP{position: relative;top:-10px}
.labelParaMP{width:300px;overflow:scroll;height:60px}
</style>
<script type="text/javascript">
   function eliminar_documento(id){
    var op=confirm("¿Esta seguro de eliminar este documento?");
    if(op==1){
      document.location.href="capitalHumano/borrar_documento/"+id;  
    }
  }
</script>
  <script type="text/javascript">    
function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//document.getElementById('gifDeEspera1').classList.add('verObjetoGif');
//document.getElementById('gifDeEspera1').classList.remove('ocultarObjeto');
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) {
      
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         // document.getElementById('gifDeEspera1').classList.remove('verObjetoGif');
        //document.getElementById('gifDeEspera1').classList.add('ocultarObjeto');           
        window[funcion](respuesta);              
                                 
      }     

      
   }

  };
 req.send(parametros);
}




    function escogerPeriocidad(value)
    {
      if(value=='Fecha'){document.getElementById('divfechaPeriocidad').classList.add('verObjeto');document.getElementById('divfechaPeriocidad').classList.remove('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.add('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.remove('verObjeto')}
      else{if(value=='Dia'){document.getElementById('divfechaPeriocidad').classList.remove('verObjeto');document.getElementById('divfechaPeriocidad').classList.add('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.remove('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.add('verObjeto')}
          else{
                    document.getElementById('divfechaPeriocidad').classList.remove('verObjeto');document.getElementById('divfechaPeriocidad').classList.add('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.add('ocultarObjeto');document.getElementById('divselectDiaPeriocidad').classList.remove('verObjeto')
          }
         }
    }
    function guardarPeriocidad(datos='')
    {
      if(datos=='')
      {
      if(document.getElementById('selectTipoPeriocidad').value==''){alert('Escoger un tipo de periocidad');return 0;}
      if(document.getElementsByClassName('classRATProcedimiento').length==0){alert('Escoger un procedimiento');return 0;}
               let params = 'tipoPeriocidad='+document.getElementById('selectTipoPeriocidad').value;                
               params+='&fechaPeriocidad='+document.getElementById('fechaPeriocidad').value;
               params+='&diaPeriocidad='+document.getElementById('selectDiaPeriocidad').value;
               params+='&idProcedimiento='+document.getElementsByClassName('classRATProcedimiento')[0].dataset.valor;
               params+='&idPuesto='+document.getElementById('idPuesto').value;
          controlador="capitalHumano/guardarPeriocidad/?";          
           peticionAJAX(controlador,params,'guardarPeriocidad'); 
      }
      else
      {
        if(!datos.success){alert(datos.mensaje);return 0}
        alert(datos.mensaje);
      }
    }



  </script>
<?
function imprimirPuestosHomonimos($datos)
{
  $opciones="";
   foreach ($datos as $key => $value) 
    {$opciones.='<optgroup label="'.$key.'">';
      foreach ($value as  $valuePP) 
      {
        $texto='';
        $texto.=$valuePP->apellidoPaterno.' '.$valuePP->apellidoMaterno.' ';
        $texto.=$valuePP->nombres.'( <label style="color:blak">'.$valuePP->personaPuesto.'</label>,'.$valuePP->email.')';
        $opciones.='<option value="'.$valuePP->idPuesto.'">'.$texto.'</option>';

      }
      $opciones.='</optgroup>';
      
    }
   return $opciones;
}

function imprimirPuestosGrupos($datos)
{
  
  $option='';
   foreach ($datos as $value) 
   {
    $disable="";
    if($value->cantidadPermitida<=$value->cantidadOcupada){$disable='disabled';}
    $option.='<option value="'.$value->idPersonaPuestoGrupo.'" '.$disable.'>'.$value->personaPuestoGrupo.'</option>';  
   }
  return $option;
}

//-------------------------------------------
function imprimirTablaGrupoPuestosNuevo($datos,$colaboradorCP)
{
  $table='';
  $table='<table class="table table-striped" id="TablaGrupoPuestosNuevos"><thead><tr style="background: #1e4c82;"><th></th><th>PLAZA/PUESTO</th><th>REQUERMIENTOS NECESARIOS PARA EL PUESTO<th>DOCUMENTOS DEL PUESTO</th><th>PROCESOS DE FUNCIONES QUE PRESENTAN DETALLES</th><th>DOCUMENTOS DEL COLABORADOR</th><th>PLAZAS</th><th>CREADAS</th><th>INCREMENTAR</th><th>DECREMENTAR</th></tr></thead><tbody>';
  //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($colaboradorCP, TRUE));fclose($fp); 
   foreach ($datos as $key=> $value) 
   {
    $disable='';

    if($value->cantidadPermitida==$value->cantidadOcupada){$disable='class="danger"';}    
     $tableHijo='';
     $colorFondoCS='circuloVerde';
     $bandFondo=0;
     $contBand=0;
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($colaboradorCP, TRUE));fclose($fp); 
    foreach ($colaboradorCP as $keyCP => $valueCP) 
    {
      if($keyCP==$value->idPersonaPuestoGrupo)
      {                 
       //$tableHijo.='<tr class="cabeceraHijo ocultarObjeto" name="hijo'.$keyCP.'"><td>NOMBRE</td><td>PUESTO</td><td>REQUERIMIENTO NECESARIO PARA EL PUESTO</td><td>DOCUMENTOS DEL PUESTO</td><td>PROCESOS DE FUNCIONES QUE PRESENTA DETALLES</td></tr>';
       $divBanderaDP='';
       $divColorFondoCS='';
       $divDocumentosDelPuesto='';
       $divFuncionesProcesos='';
       foreach ($valueCP as $valueDatos) 
       {
        $tableHijo.='<tr name="hijo'.$keyCP.'" class="ocultarObjeto">';
        $tableHijo.='<td>'.$valueDatos->nombrePersona.'</td>';
        $tableHijo.='<td>'.$valueDatos->personaPuesto.'</td>';
        //==================== REQUERIMIENTOS DEL PUESTO======================= 
        $tableHijo.='<td><div style="height:300px;width100%;overflow:auto">';

       
         $bandFondo=1;
         $contBand=0;
         $colorFondoCS='circuloVerde';
        foreach ($valueDatos->requerimientosPuestoDoc as $keyRP => $valueRP) 
        {
          $contBand++;
          $checado='checked';
          $checadoclass="conDocClass";
          if(!isset($valueRP->bandContenido)){}
          if(!$valueRP->bandContenido){$checado='';$checadoclass='sinDocClass';$bandFondo++;}
          $tableHijo.='<div class="requerimientoPuesto '.$checadoclass.'"><label >'.$valueRP->descripcionMUP.'</label><input type="checkbox" class="form-check-input" disabled '.$checado.'></div><br>';
        }

    if($bandFondo>1){$colorFondoCS='circuloAmarillo';}
    else{if(($contBand*11)==0){$colorFondoCS='circuloRojo';}}
    $divColorFondoCS.='<div class="circulosSemaforo '.$colorFondoCS.'"><div class="ocultarObjeto">'.$valueDatos->nombrePersona.'('.$valueDatos->personaPuestoGrupo.')</div></div>';
//======================================================
      //==================== DOCUMENTOS DEL PUESTO=======================


        $tableHijo.='</td>';
        $tableHijo.='<td><div style="height:300px;width100%;overflow:auto">';
        $bandDocumentosClass='circuloRojo';
        $documentosObligatoriosClass='circuloRojo';
        //if(count($valueDatos->archivosObligatorios)>0){$documentosObligatoriosClass='circuloAmarillo';}
        foreach ($valueDatos->documentosDelPuesto as  $valueDP) 
        {
          $bandDocumentosClass='circuloVerde';
          $tableHijo.='<div><a href="'.base_url().'assets/documentos/capitalHumano/'.$valueDP->url.'">'.$valueDP->nombre.'</a></div><br>';
        }
        $tableHijo.='</div></td>';
$divDocumentosDelPuesto.='<div class="circulosSemaforo '.$bandDocumentosClass.'"><div class="ocultarObjeto">'.$valueDatos->nombrePersona.'('.$valueDatos->personaPuestoGrupo.')</div></div>';
//============================================================================
//==================== PROCESOS DE FUNCIONES=======================
        $tableHijo.='<td><div style="height:300px;width100%;overflow:auto">';
        $classInformacionProcesos='circuloVerde';
        if($valueDatos->bandInformacionProcesos==0){$classInformacionProcesos='circuloRojo';}
        foreach ($valueDatos->informacionProcesos as $valueRPD) 
        {
          $classInformacionProcesos='circuloAmarillo';          
          $tableHijo.='<div><label>FUNCION</label>'.$valueRPD['funcion'].'<label>PROCESO</label>'.$valueRPD['proceso'].'('.$valueRPD['informacion'].')</div><hr><br>';
        }
        $tableHijo.='</div></td>';
        
                $tableHijo.='</td>';
$divFuncionesProcesos.='<div class="circulosSemaforo '.$classInformacionProcesos.'"><div class="ocultarObjeto">'.$valueDatos->nombrePersona.'('.$valueDatos->personaPuestoGrupo.')</div></div>';                
//==================== ===========================================
              $tableHijo.='<td><div style="height:300px;width100%;overflow:auto">';
        //$classInformacionProcesos='circuloVerde';
//=============================DOCUMENTOS PERSONALES==============================
        if($valueDatos->bandInformacionProcesos==0){$classInformacionProcesos='circuloRojo';}
        $DPClass='circuloRojo';
        if((int)$valueDatos->bandDocPersonales==1){$DPClass='circuloAmarillo';}
        if((int)$valueDatos->bandDocPersonales==2){$DPClass='circuloVerde';}
      $divBanderaDP.='<div class="circulosSemaforo '.$DPClass.'"><div class="ocultarObjeto">'.$valueDatos->nombrePersona.'('.$valueDatos->personaPuestoGrupo.')</div></div>';
        foreach ($valueDatos->documentosPersonales as $valDP) 
        {
          $check='';
          if($valDP->tieneDocumento=='1'){$check='checked';}
                    
          $tableHijo.='<div class="requerimientoPuesto conDocClass"><label>'.$valDP->textoPD.'</label><input type="checkbox" class="form-check-input" disabled '.$check.'></div><br>';
        }
        $tableHijo.='</div></td>';
        
                $tableHijo.='</td>';                
//=========================================================================                
      }
      $tableHijo.='</tr>';
     }
    }
/*    if($bandFondo>1){$colorFondoCS='circuloAmarillo';}
    else{if(($contBand*11)==0){$colorFondoCS='circuloRojo';}}
    $divColorFondoCS.='<div class="circulosSemaforo '.$colorFondoCS.'"></div>';*/
        $table.='<tr onclick="muestraCCP(this)" data-puesto="'.$value->personaPuestoGrupo.'" data-ppg="'.$value->idPersonaPuestoGrupo.'" '.$disable.'>';
    $table.='<td><button class="btn btn-primary" onclick="muestraHijos(this,'.$value->idPersonaPuestoGrupo.')" style="font-weight: 600;">+</button></td>'; 
    $table.='<td>'.$value->personaPuestoGrupo.'</td>'; 
    $table.='<td align="center"><div class="divContieneSemaforos">'.(isset($divColorFondoCS)?$divColorFondoCS:'').'</div></td>'; 
    $table.='<td align="center"><div class="divContieneSemaforos">'.(isset($divDocumentosDelPuesto)?$divDocumentosDelPuesto:'').'</div></td>';
    $table.='<td align="center"><div class="divContieneSemaforos">'.(isset($divFuncionesProcesos)?$divFuncionesProcesos:'').'</div></td>';
    $table.='<td align="center"><div class="divContieneSemaforos">'.(isset($divBanderaDP)?$divBanderaDP:'').'</div></td>';    
    $table.='<td align="center">'.$value->cantidadPermitida.'</td>'; 
    $table.='<td align="center">'.$value->cantidadOcupada.'</td>'; 
    $table.='<td align="center"><button class="btn btn-success btn-radius" onclick="incrementarPuesto('.$value->idPersonaPuestoGrupo.',1)"><i class="fas fa-plus"></i></button></td>'; 
    $table.='<td align="center"><button class="btn btn-danger btn-radius" onclick="incrementarPuesto('.$value->idPersonaPuestoGrupo.',0)"><i class="fas fa-minus"></i></button></td>'; 

    $table.='</tr>';
     $table.=$tableHijo;
   }
   $table.='</tbody></table>';
  return $table;
}

//-------------------------------------------
function imprimirTablaGrupoPuestos($datos)
{

  $table='';
  $table='<table class="table"><thead><tr><th>Puesto</th><th>Plazas</th><th>Creadas</th><th>Incrementar</th><th>Decrementar</th></tr></thead><tbody>';
   foreach ($datos as $value) 
   {
    $disable='';

    if($value->cantidadPermitida==$value->cantidadOcupada){$disable='class="danger"';}
    $table.='<tr onclick="muestraCCP(this)" data-puesto="'.$value->personaPuestoGrupo.'" data-ppg="'.$value->idPersonaPuestoGrupo.'" '.$disable.'>';
    $table.='<td>'.$value->personaPuestoGrupo.'</td>'; 
    $table.='<td>'.$value->cantidadPermitida.'</td>'; 
    $table.='<td>'.$value->cantidadOcupada.'</td>'; 
    $table.='<td><button class="btn btn-primary" onclick="incrementarPuesto('.$value->idPersonaPuestoGrupo.',1)">+</button></td>'; 
    $table.='<td><button class="btn btn-primary" onclick="incrementarPuesto('.$value->idPersonaPuestoGrupo.',0)">-</button></td>'; 
    $table.='</tr>';
   }
   $table.='</tbody></table>';
  return $table;
}
//-------------------------------------------
function imprimirdivColaboradorConPuesto($datos)
{
  $div='';
  $band='';
  $info="";
   foreach ($datos as $key =>$value) 
   {

    $info.='<div id="divCCP'.$key.'" name="puestosOcupados">';
    foreach ($value as  $valueInfo) 
    {
      //$info.=$valueInfo->nombres.' '.$valueInfo->apellidoPaterno.' '.$valueInfo->apellidoMaterno.'<br>';
      $info.='<div class="subtitle-center-puesto">Puesto y Homónimos: '.$valueInfo->personaPuesto.' ('.$valueInfo->nombrePersona.')</div>';
    
    }
    $info.='</div>';
    $div.=$info;
   }
   
  return $div;
}

//-------------------------------------------

?><script type="text/javascript">
<?if($permisoAgregar!=1){?>
 let div= document.getElementsByTagName('div')
  let cant=div.length;
  for(let i=0;i<cant;i++){div[i].removeAttribute('contenteditable');}
<?}?>
</script>
<script type="text/javascript">
  function escogerMatrizProcedimiento(objeto)
  {
   let clas=Array.from(document.getElementsByClassName('escogerMatrizProcedimiento'));
   clas.forEach(clase=>{clase.classList.remove('escogerMatrizProcedimiento')})
   objeto.classList.add('escogerMatrizProcedimiento')
  }
  function guardarTarea()
  {
    let clas=document.getElementsByClassName('escogerMatrizProcedimiento');
    let fecha=document.getElementById('dateTarea').value;
    if(clas.length==0){alert('ESCOGER UNA MATRIZ');return 0;}
    if(fecha==""){alert('ESCOGER UNA FECHA');}
    
  }
</script>
<style type="text/css">
  .escogerMatrizProcedimiento{background-color: green}
</style>
<script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

//google.charts.load(‘current’, {packages:["orgchart"]});
//google.charts.setOnLoadCallback(drawChart);

function drawChart() {
var data = new google.visualization.DataTable();
data.addColumn("string", "Nombre");
data.addColumn("string", "Superior");
data.addRows([
<?php
  /*$puestos="";
  foreach ($organigrama as  $value) 
  {
    $puestos.='["'.$value->personaPuesto.'","'.$value->hereda.'"],';
  }
  echo($puestos);*/

?>  
/*["Jefe","" ],
["Ventas","Jefe"],
["Recursos humanos","Jefe" ],
["Recursos humanos1","Jefe" ],
["Recursos humanos2","Jefe" ],
["Recursos humanos3","Jefe" ],
["Recursos humanos4","Jefe" ],
["Recursos humanos5","Jefe" ],
["Recursos humanos6","Jefe" ],
["Finanzas","Jefe"],
["La secretaria del jefe","Jefe"],
["El contador","Finanzas"],
["La secretaria del contador","El contador"],
["La asistente del contador","El contador"],
["La subsecretaria del contador","La secretaria del contador"],
["Vendedores","Ventas"],
["Vendedor 1","Vendedores"],
["Vendedor 2","Vendedores"],
["Facturacion","Ventas"],
["Devoluciones","Ventas"],
["Jane Smith","Recursos humanos"],
["Vilma","Jane Smith"],
["Ayudante","Vilma"],
["Ayudante del ayudante","Ayudante"],*/
]);
var chart = new google.visualization.OrgChart(document.getElementById("org_chart"));
chart.draw(data, {allowHtml:true});
chart.draw(data, {allowCollapse:true});
}
<?
  $ul="";
  //
  //foreach ($organigrama as  $value) 
  //{ 
  //  foreach ($value as $key => $value1) 
  //  {
  //  
  //  }
    //$li='<li>'.$value->personaPuesto.'</li>';
    //$ul='<ul>'.$li.'</ul>';
  //}  
?>
//document.getElementById("org_chart").innerHTML=<?=$ul?>;

<?php if(isset($vista)){ ?> verContenidoPuesto("<?=$vista?>"); <?}?>

<?php if(isset($manejoPestanias)){ ?> manejoPestanias("<?=$manejoPestanias?>"); <?}else{?>manejoPestanias("divManual");<?}?>
</script><style type="text/css">
  .modal-backdrop{height: 0px;}
</style>

<!--Miguel Jaime 22/11/2021-->
<script type="text/javascript">
  
function getFastFile(idPersona,year){
 var base='<?php echo base_url()?>';
 divResultado = document.getElementById('divMatrizFastFile');  
 ajax=objetoAjax();
 var URL=base+"fastFile/getTablero?idPersona="+idPersona+"&year="+year;
 ajax.open("GET", URL);
 ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
        divResultado.innerHTML = ajax.responseText
        $('.tree-repositorio').jstree();
    }
  }
  ajax.send(null)
} 

function getFastFileReload(idPersona,year){
 var base='<?php echo base_url()?>';
 divResultado = document.getElementById('divMatrizFastFile');  
 ajax=objetoAjax();
 var getYear=year.value;
 var URL=base+"fastFile/getTablero?idPersona="+idPersona+"&year="+getYear;
 ajax.open("GET", URL);
 ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
        divResultado.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}  


function getByMonth(idPersona,mes,descripcion, anio){
 var base='<?php echo base_url()?>';
 divResultado = document.getElementById('pantalla');  
 ajax=objetoAjax();
 var URL=base+"fastFile/getByMonth?idPersona="+idPersona+"&mes="+mes+"&descripcion="+descripcion+"&anio="+anio;
 ajax.open("GET", URL);
 ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {

      $("#modal").modal({
        show: true,
      });

      divResultado.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)  
} 

function viewSearchOtherFastFile(){
  var base='<?php echo base_url()?>';
   divResultado = document.getElementById('pantalla');  
   ajax=objetoAjax();
   var URL=base+"fastFile/viewSearchOtherFastFile";
   ajax.open("GET", URL);
   ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)  
}

function filterByNameFastFile(name) {
 var base='<?php echo base_url()?>';
   divResultado = document.getElementById('tablaFastFile');  
   ajax=objetoAjax();
   var URL=base+"fastFile/filterByNameFastFile?name="+name.value;
   ajax.open("GET", URL);
   ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)  
}

function selectFastFile(puesto,year) {
   var base='<?php echo base_url()?>';
   ajax=objetoAjax();
   var URL=base+"fastFile/getIdPersonaByPuesto?puesto="+puesto.value;
   ajax.open("GET", URL);
   ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          idPersona=ajax.responseText
          getFastFile(idPersona,year);
      }
    }
    ajax.send(null)  
}


function viewPerfilApego(idPersona,puesto){
  var base='<?php echo base_url()?>';
   divResultado = document.getElementById('pantalla');  
   ajax=objetoAjax();
   var URL=base+"fastFile/viewPerfilApego?idPersona="+idPersona+"&puesto="+puesto;
   ajax.open("GET", URL);
   ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null) 
}

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


</script>

<style type="text/css">
  .requerimientoPuesto{display: flex;flex-direction: row;width: 100%;align-items: center;}
  .requerimientoPuesto label{flex: 3;}
  /*.requerimientoPuesto input {flex: 1;border: double;}*/
  .sinDocClass{background-color:#ffdb6e}
  .conDocClass{background-color:#a3e5c0;}
  .circulosSemaforo{width: 10px;height: 10px;-moz-border-radius: 50%;-webkit-border-radius: 50%;border-radius: 50%;}
  .circulosSemaforo:hover >div{display: block;border:solid;background-color: white;width: 200px;margin-top: 10px;z-index: 100000}
  .circuloVerde{background: green}
  .circuloAmarillo{background: yellow}
  .circuloRojo{background: red}
  .table>thead>tr:first-child{color:blue;position: sticky;top: 0;}
  .cabeceraHijo{color:black;background-color: yellow}
  .divContieneSemaforos{display:flex}

</style>
<script type="text/javascript">
  function muestraHijos(objeto,id)
  {
    let hijos=Array.from(document.getElementsByName('hijo'+id));
    //console.log(hijos)
    hijos.forEach(h=>{$(h).toggle(350, 'easeInOutCubic')})
    if(objeto.innerHTML=='+')
    {
      
      objeto.innerHTML='-';
      objeto.style.padding = "6px 14px";
    }
    else
      {
      objeto.innerHTML='+';
      objeto.style.padding = "6px 12px";

      }

  }
</script>
<!----- Dennis Castillo [2022-03-02] ----->
<script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-cargadearchivosdepuestos.js"?>"></script>
<script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-repositoriosdearchivos.js"?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script>

  /*const employeeDocsModal = new EmployeeModal( //Desactivado [Suemy][2024-04-26]
    "#upload-files-employee", 
    $("#buscarIdPuesto").val(),
    {
      upload: $("#repository-permission").val() > 0 ? true : false,
      formats: true,
      requerimentsFile: true,
      jobProfile: true,
    }
  );
  employeeDocsModal.render();*/

  //Dennis Castillo [2022-03-04]
  //Usar este evento solo para desplegar el modal. El contenido del modal se refleja desde componentes de React
  $(document).on("click", ".show-upload-modal", function(){
    $("#modal-upload-container").modal({
      show: true,
      keyboard: false,
      backdrop: ""
    });
  });

  $(document).on("click", ".remove-file-tree", function(){

    const value = $(this).data("id");
    const node = $(this).data("node");
    //console.log(value);

    if(confirm("¿Esta seguro que desea eliminar este archivo?")){

      const ajax = $.ajax({
        type: "POST",
        url: "<?=base_url()?>fastFile/deleteFileFromRepository",
        data: {
          idDoc: value
        },
        error: (error) => {
          console.log(error.responseText);
        },
        success: (data) => {
          const response = JSON.parse(data);
          //console.log(response);

          alert(response.message);

          if(response.bool){

            $("#modal-doc-details").modal("hide");
            var instance = $('.div-repositorio').jstree(true);
            instance.delete_node(instance.get_selected());
          }
        }
      });
    }
  });

  $(document).on("click", ".download-file", function(){

    const value = $(this).data("href");
    window.open(value);

  });

  //---------------------

  $("#fast-file-year").change(function(){

    const now = new Date();
    const year = $(this).val();
    const selected = year < now.getFullYear() ? 0 : now.getMonth() + 1;
    $("#fast-file-month").prop("selectedIndex", selected);
    //const disabled = $(this).val() < now.getFullYear() ? false : true;

    $("#fast-file-month option").each(function(){

      if(year < now.getFullYear()){

        $(this).prop("disabled", false);
      } else if(year == now.getFullYear() && $(this).val() > (now.getMonth() + 1)){

        $(this).prop("disabled", true);
      }
    });

  });
  //---------------------
    function sombrearvacaciones(vacaciones,vacationsPendientes){

      document.getElementById("vacacionespendjson").innerHTML = JSON.stringify(vacationsPendientes);
        const dias=document.querySelectorAll(".days li");

        for (let i = 0; i < dias.length; i++) {
          if(vacaciones){
            for(var j=0; j<vacaciones.length; j++){
            salida = vacaciones[j].fecha_salida;
            retorno = vacaciones[j].fecha_retorno;
            
            var fechaInicio = new Date(salida);
            var fechaFin    = new Date(retorno);
            var fechaActual = new Date();
            var prueba1= fechaInicio.getTime(); 
            var prueba2= fechaActual.getTime(); 

            if(fechaInicio.getTime()<=fechaActual.getTime()){
            while(fechaFin.getTime() > fechaInicio.getTime()){
            fechaInicio.setDate(fechaInicio.getDate() + 1);

            AñoSalida= fechaInicio.getFullYear();
          mesSalida= fechaInicio.getMonth();
          diaSalida= fechaInicio.getDate();
          if(dias[i].dataset.year==AñoSalida){
            if(dias[i].dataset.month==mesSalida){
              if(dias[i].dataset.value==diaSalida){
                dias[i].style="background-color:#B65A59";
              }
            }
          }
            }}else{
              while(fechaFin.getTime() > fechaInicio.getTime()){
            fechaInicio.setDate(fechaInicio.getDate() + 1);

            AñoSalida= fechaInicio.getFullYear();
          mesSalida= fechaInicio.getMonth();
          diaSalida= fechaInicio.getDate();
          if(dias[i].dataset.year==AñoSalida){
            if(dias[i].dataset.month==mesSalida){
              if(dias[i].dataset.value==diaSalida){
                dias[i].style="background-color:#3EFF00";
              }
            }
          }
            }
            }
          }}
          if(vacationsPendientes){
            for(var x=0; x<vacationsPendientes.length; x++){
            salidapen = vacationsPendientes[x].fecha_salida;
            retornopen = vacationsPendientes[x].fecha_retorno;

            var fechaInicioPen = new Date(salidapen);
            var fechaFinPen    = new Date(retornopen);

            while(fechaFinPen.getTime() > fechaInicioPen.getTime()){
            fechaInicioPen.setDate(fechaInicioPen.getDate() + 1);

            AñoSalida= fechaInicioPen.getFullYear();
          mesSalida= fechaInicioPen.getMonth();
          diaSalida= fechaInicioPen.getDate();
          if(dias[i].dataset.year==AñoSalida){
            if(dias[i].dataset.month==mesSalida){
              if(dias[i].dataset.value==diaSalida){
                dias[i].style="background-color:#E49E43";
              }
            }
          }
            }
          
          }}
        }
  }
  //--------------------- //Dennis Castillo [2022-06-02]
  function getGeneralDashboard(response, yearSelected){ //Modificado [Suemy][2024-07-09]

    var panels = ``;
    var tabContents = ``;
    var list = Object.keys(response.data.monthData).reduce((acc, curr) => {

    if(curr !== "dias_vacaciones"){
      acc += `<li role="presentation"><a href="#${curr}" aria-controls="${curr}" role="tab" data-toggle="tab">${curr.toUpperCase().replace("_", " ")}</a></li>`;
    }

    return acc;
    }, ``);

    for(var a in response.data.monthData){
      
      if(a !== "dias_vacaciones"){

        const iconAndLabel = getIconAndLabel(a);
        const dataRows = response.data.monthData[a];
		const showFirstCard = dataRows[1].showCard;
        var monthPanels = ``;

        var countAll = Object.values(dataRows).reduce((acc, curr) => {
          acc += curr.data.length;
          return acc;
        }, 0);

        for(var b in dataRows){ //b is numeric month

          const numericCol = ["calificacion", "permiso", "incapacidad", "prestamo", "sueldo"].includes(a) ? 10 : 4;
        
          if(["vacacion","calificacion", "permiso", "incapacidad", "prestamo", "sueldo", "cambio_puesto"].includes(a) && dataRows[b].data.length == 0)
          continue;
          
          var bodyPanel = getCategoryData(a, dataRows[b], response.data.monthData["asistencia"][b].assits.assistance); //third param for calculate the delay in assists
          monthPanels += `
            <div class="col-md-${numericCol}">
              <div class="panel panel-default">
                <div class="panel-heading">${response.data.months[b]}</div>
                ${bodyPanel}
                <!--<div class="panel-body"></div>-->
              </div>
            </div>
          `;
        }

      
        if(a=="vacacion"){
          var yearAcumuled = 0;
          if (response.data.period != 0) { yearAcumuled = response.data.period; }
          tabContents += `<div role="tabpanel" class="tab-pane fade" id="${a}">
          <div class="col-md-12">
              <h3>${a.toUpperCase().replace("_", " ")}</h3>
              <hr>
              
          </div>
           <div class="row">
        <div class="col-md-12"><div id="contenidoVacacion"><div class="alert alert-info" style="padding-left: 50px;">
        <i class="fa fa-info-circle"></i> <b>Nota:</b> Actualmente Ud. posee <b>${yearAcumuled}</b> años de antiguedad en la empresa, le corresponde en este periodo(${response.data.periodoActual}) lo siguente:<br>
        <ul>
          <li>Dias de Vacaciones: <b>${response.data.diasVacaciones}</b></li>
          <li>Dias aprobados ó pendientes por aprobar: <b>${response.data.diasSolicitados}</b></li>
          <li>Le Resta: <b>${response.data.diasRest}</b> dia(s) para vacacionar</li>
        </ul>
            </div></div></div></div>
          <br>
          <div class="row" style="display: flex; justify-content: center;">
         <div class="col-12 text-center"><h4>Planificador de vacaciones</h4></div>
          <div class="wrapper">
      <header>
        <p class="current-date" id="current-date"></p>
        <div class="icons">
          <span id="prev" class="material-symbols-rounded">chevron_left</span>
          <span id="next" class="material-symbols-rounded">chevron_right</span>
        </div>
      </header>
      <div class="calendar">
        <ul class="weeks">
          <li>Domingo</li>
          <li>Lunes</li>
          <li>Martes</li>
          <li>Miercoles</li>
          <li>Jueves</li>
          <li>Viernes</li>
          <li>Sabado</li>
        </ul>
        <ul class="days" id="days"></ul>
      </div>
    </div>
     <div class="simbologia col-md-2" style="padding-top:15%;">
          <label> <i class="fas fa-circle" style="color:#B65A59;"></i> D&iacute;as aprobados tomados</label>
          <label> <i class="fas fa-circle" style="color:#3EFF00;"></i> D&iacute;as aprobados pendientes por tomar</label>
          <label> <i class="fas fa-circle" style="color:#E49E43;"></i> D&iacute;as pendientes por aprobar</label>
          </div></div>
          <div id="vacacionesjson" style="visibility: hidden;">${JSON.stringify(response.data.vacaciones)}</div>
        <div id="vacacionespendjson" style="visibility: hidden;">${JSON.stringify(response.data.VacationsPendientes)}</div>
        <div id="pruebatext" style="visibility: hidden;"></div>
    <br>
    <div class="col-md-12">
    <div class="mt-4"><p><strong>Total acumulado: ${countAll}</strong></p></div>
              <div clas="row">${countAll > 0 ? monthPanels : `<div class="col-md-12 text-center"><h3>Sin registros por el momento</h3></div>`}</div>
               </div>
          <br>
         
            
        </div>
        <script src="<?php echo site_url('assets/js/calendarioVacaciones.js'); ?>" defer/>`;
        

        
        }
          else{
        tabContents += `<div role="tabpanel" class="tab-pane fade" id="${a}">
          <div class="col-md-12">
              <h3>${a.toUpperCase().replace("_", " ")}</h3>
              <hr>
              <div class="mt-4"><p><strong>Total acumulado: ${countAll}</strong></p></div>
              <div clas="row">${countAll > 0 ? monthPanels : `<div class="col-md-12 text-center"><h3>Sin registros por el momento</h3></div>`}</div>
          </div>
        </div>`;
          }
          

        var body = showFirstCard ? `<div clas="row">
          <div class="col-md-4">${iconAndLabel.icon}</div>
          <div class="col-md-8">
            <div>Total acumulado</div>
            <div><strong>${countAll} ${iconAndLabel.label}</strong></div>
            <div><a href="javascript: void(0)" class="active-tab" data-tab="${a}">Ver detalles</a></div>
          </div>
        </div>` : ``;

        panels += showFirstCard ? `<div class="col-md-4"><div class="panel panel-default"><div class="panel-heading">${a.toUpperCase()}</div><div class="panel-body">${body}</div></div></div>` : ``;
      }
    }
    $("#vacacion").html();


    $(".general-dashboard").html(`<h3><center>Acumulado ${response.data.year}</center></h3><div class="row mt-2" style="padding: 0px 15px;">
        <div class="col-md-2"><div class="col-md-12" role="tabpanel"><ul class="nav nav-pills nav-stacked category-list" id="nav-general-dashboard" role="tablist"><li role="presentation" class="active"><a href="#general-content" aria-controls="general-content" role="tab" data-toggle="tab">GENERAL</a></li>${list}</ul></div></div>
          <div class="col-md-10 border-top border-left tab-content">
              <div role="tabpanel" class="tab-pane active" id="general-content"><h3>CONTEO GENERAL</h3><hr><div>${panels}</div></div>${tabContents}
          </div>
      </div>`
    );

    $(".specified-dashboard").hide();
    $(".general-dashboard").show();
    const vacaciones=response.data.vacaciones;
    const vacationsPendientes= response.data.VacationsPendientes;

        sombrearvacaciones(vacaciones,vacationsPendientes);  

  }
  //--------------------- //Dennis Castillo [2022-06-02]
  function getCategoryData(category, data_, assistance){
    //third param for calculate the delay in assists
    var body = ``;
  
    switch(category){
      case "calificacion":

        body += `<table class="table table-condensed">
          <thead><tr><th>Evaluación</th><th>Fecha de aplicación</th><th>Calificación</th></tr></thead>
          <tbody> ${data_.data.reduce((acc, curr) => acc += `<tr><td>${curr.descripcion}</td><td>${curr.fecha}</td><td>${curr.calificacion}</td></tr>`, ``)} </tbody>
        </table>`;
        break;
      case "incapacidad":
      case "permiso":

        body += `<table class="table table-condensed">
          <thead><tr><th>Comentario</th><th>Fecha de inicio</th><th>Respuesta</th><th>Dias solicitados</th></tr></thead>
          <tbody> ${data_.data.reduce((acc, curr) => acc += `<tr><td>${curr.comentario}</td><td>${curr.fecha}</td><td>${curr.respuesta}</td><td>${curr.valor}</td></tr>`, ``)} </tbody>
        </table>`;
        break;
      case "asistencia":

        body += `<table class="table table-condensed">
          <tr><td>Asistencias</td><td>${data_.assits.assistance}</td></tr>
          <tr><td>Faltas</td><td>${data_.assits.fouls}</td></tr>
          <tr><td>Dias inhábiles (con fines de semana)</td><td>${data_.weekends}</td></tr>
        </table>`;
        break;
      case "puntualidad":

        body += `<table class="table table-condensed">
          <tr><td>Chequeo a tiempo</td><td>${data_.assits.assistance}</td></tr>
          <tr><td>Retardos</td><td>${(assistance - data_.assits.assistance)}</td></tr>
          <tr><td>Total de asistencias</td><td>${assistance}</td></tr>
        </table>`;
        break;
      case "sueldo":
      case "prestamo":

        var th = category == "sueldo" ? `<th>Monto aplicado</th>` : ``;
        body += `<table class="table table-condensed">
          <thead><tr><th>Fecha de aplicación</th><th>Monto solicitado</th>${th}</tr></thead>
          <tbody> ${data_.data.reduce((acc, curr) => {

              var td = category == "sueldo" ? `<td>${curr.valor_ant}</td>` : ``;
              acc += `<tr><td>${curr.fecha}</td><td>${curr.valor}</td>${td}</tr>`;
              return acc;
                
            }, ``)} </tbody>
        </table>`;
        break;
      case "vacacion": 

        body += `<table class="table table-condensed">
          <thead><tr><th>Fecha de salida</th><th>Dias aprobados</th></tr></thead>
          <tbody> ${data_.data.reduce((acc, curr) => acc += `<tr><td>${curr.fecha}</td><td>${curr.valor}</td></tr>`, ``)} </tbody>
        </table>`;
        break;
      case "cambio_puesto": 

        body += `<table class="table table-condensed">
          <thead><tr><th>Fecha de cambio</th><th>Nuevo puesto</th><th>Puesto anterior</th></tr></thead>
          <tbody> ${data_.data.reduce((acc, curr) => acc += `<tr><td>${curr.fecha}</td><td>${curr.valor}</td><td>${curr.valor_ant}</td></tr>`, ``)} </tbody>
        </table>`;
        break;
    }

    return body;
  }
  //--------------------- //Dennis Castillo [2022-06-02]
  function getSpecifiedDashboard(response){ //Modificado [Suemy][2024-04-26]

    const dataParse = response.data;
    const monthData = response.data.monthData;
    const monthDays = monthData.asistencia.filter(arr => !arr.finsemana).map(arr => arr.dia);
    const colspan = monthData.asistencia.filter(arr => !arr.finsemana).length;
    const vacaciones = response.data.vacaciones;
    const nolaborales = response.data.nolaborales;
    var trtd = ``;

    const trth = monthDays.reduce((acc, curr) => { //header days
      acc += `<th>${parseInt(curr)}</th>`;
      return acc;
    }, ``);

    for(const a in monthData){
      const trueCheck = monthData[a].filter(arr => !arr.finsemana && arr.check);
      const td = monthData[a].filter(arr => !arr.finsemana).reduce((acc, curr) => {

        const asistence = ["puntualidad", "asistencia","salida"].includes(a) ? true : false;
        var check = ``;


        if(asistence){
          check = curr.check ? `<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>` : `<i class='fa fa-times-circle' style='color: red;font-size: 16px;'></i>`;
          fecha= response.data.year+"-"+("0"+response.data.month).slice(-2)+"-"+curr.dia;
          var d=new Date(fecha);
          if(vacaciones){
            for(var i=0; i<vacaciones.length; i++){
            salida = vacaciones[i].fecha_salida;
            retorno = vacaciones[i].fecha_retorno;
            
            var fechaInicio = new Date(salida);
            var fechaFin    = new Date(retorno);
          if(d.getTime()>=fechaInicio.getTime() && d.getTime()<fechaFin.getTime()){
            check=`<i class='fa fa-plane' style='color: #2AA828;font-size: 16px;'></i>`;
          }
          }
          }
          if(nolaborales){
            for(var i=0; i<nolaborales.length; i++){
            nolaboral = nolaborales[i].diaNoLaboral;
            
            var fechaNoLaboral = new Date(nolaboral);
          if(d.getTime()==fechaNoLaboral.getTime() ){
            check=`<i class="fa fa-calendar-check-o" style='color: #F37E1D;font-size: 16px;'></i>`;
          }
          }
          }

        }
        else if (a == "capacitacion") {
          check = curr.check ? `<i class="fas fa-graduation-cap" style="color: #cf7724;font-size: 16px;"></i>` : ``;
        }
        else{
          check = curr.check ? `<i class='fa fa-check-circle' style='color: #1976d2;font-size: 16px;'></i>` : ``;
        }

        acc += curr.show ? `<td>${check}</td>` : `<td></td>`;
        
        return acc;
      }, ``);

      trtd += `<tr>${td}<td>${trueCheck.length}</td><td><a href="javascript: void(0)" class="text-info" onclick="getByMonth(${dataParse.idPersona}, ${dataParse.month}, '${getParam(a).replace("_", " ")}', ${dataParse.year})"><div>Detalles de</div><div>${a.replace("_", " ").toUpperCase()}</div><a></td></tr>`;
    }

    $(".show-days-selected").html(`<tr><th colspan="${colspan + 2}" class="text-center">${dataParse.monthName} ${dataParse.year}</th></tr><tr>${trth}<th>T</th><th>Detalles</th></tr>`);
    $(".show-days-info").html(trtd);
    $(".specified-dashboard").show();
    $(".general-dashboard").hide();
  }
  //--------------------- //Dennis Castillo [2022-06-02]
  function getIconAndLabel(type){

    var icon = [];
    icon["label"] = "registro (s)";

    switch(type){
      case "puntualidad": icon["icon"] = `<i class="fa fa-hourglass-half fa-3x" aria-hidden="true"></i>`; 
        break;
      case "asistencia": icon["icon"] = `<i class="fa fa-clock-o fa-3x" aria-hidden="true"></i>`;
        break;
      case "vacacion": icon["icon"] = `<i class="fa fa-plane fa-3x" aria-hidden="true"></i>`; icon["label"] = "solicitud (es)";
        break;
      case "prestamo": icon["icon"] = `<i class="fa fa-money fa-3x" aria-hidden="true"></i>`;
        break;
      case "calificacion": icon["icon"] = `<i class="fa fa-check fa-3x" aria-hidden="true"></i>`; icon["label"] = "evaluacion (es)";
        break;
      case "incapacidad": icon["icon"] = `<i class="fa fa-h-square fa-3x" aria-hidden="true"></i>`;
        break;
      case "sueldo": icon["icon"] = `<i class="fa fa-usd fa-3x" aria-hidden="true"></i>`; icon["label"] = "solicitud (es)";
        break;
      case "permiso": icon["icon"] = `<i class="fa fa-life-ring fa-3x" aria-hidden="true"></i>`; icon["label"] = "solicitud (es)";
        break;
    }

    return icon;
  }
  //--------------------- //Dennis Castillo [2022-06-02]
  function getParam(key){

    var response = ``;

    switch(key){
      case "vacaciones": response = "vacacion"; //permiso
      break;
      case "permisos": response = "permiso"; //permiso
      break;
      case "prestamos": response = "prestamo"; //permiso
      break;
      case "sueldos": response = "sueldo"; //permiso
      break;
      default: response = key;
    }

    return response;
  }
  //--------------------- //Dennis Castillo [2022-06-02]
  $(document).on("click", ".active-tab", function(){

    $(`.category-list a[href="#${$(this).data("tab")}"]`).tab('show');
  });
  //-------------------------------------------------------------------------------------------------------------
  $(document).ready(function() {
    $('#dLabel').addClass('dropdown-toggle');
    $('#BtnMenuBurguer').click(function() {
      $('#BtnMenuPuestos').toggleClass('active');
      $('#SpinnerVerPuestos').toggleClass('active-bar-spinner');
      $('#SpinnerAltaPuestos').toggleClass('active-bar-spinner');
      $('#TableFastFileMonth').toggleClass('table-width');
      $('.container-NT').toggleClass('table-width2');
      $('#tabContentReports').toggleClass('table-width3');
      $('#tab_vac').toggleClass('table-width3');
    })

    $("#frmorganigrama").on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(document.getElementById("frmorganigrama"));
      var documento=document.getElementById('organigrama').value;
      if(documento==""){
        var text = "Informacion";
        swal("¡Espera!", "Debes seleccionar un archivo.", "warning");
      }else{
        $.ajax({
            url: `<?=base_url()?>capitalHumano/guardar_organigrama`,
            type: "POST",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: (load) => {
                $('#SpinnerUploadOrganigrama').html(`
                    <div class="container-spinner-content-upload">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
                    </div>
                `);
            },
            success: (data) => {
                const res = JSON.parse(data);
                console.log(res);
                const url = `<?=base_url()?>assets/documentos/capitalHumano/organigrama/${res['registro'].url_imagen}`;
                $('#SpinnerUploadOrganigrama').html("");
                if (res['message'] == "GUARDADO") {
                  swal("¡Guardado!", "Documento guardado. Organigrama actualizado.", "success");
                  $('#DocOrganigrama').html(`<iframe src="${url}" style="width: 100%;height: 600px;border-style: none;"></iframe>`);
                  console.log(url);
                  //window.location.reload();
                } else {
                  swal("¡Vaya!", "Ocurrió un conflicto al tratar de guardar el documento.", "error");
                }
                $('.swal-button--confirm').click(function() {
                  $('#OrgClose').click();
                });
            },
            error: (error) => {
              $('#SpinnerUploadOrganigrama').html("");
                swal("¡Uups!", "Hay problemas al intentar guardar el documento.", "error");
            }            
        })
      }
    })

    BuscarPorPuesto();
    DocumentosCC();
    <? if($sw==1){?> 
    TablaGrupoPuestos();
    TablasReportes();
    <? } ?>
  })
  
  //Formato Monetario
    const money = { style: 'currency', currency: 'MXN' };
    const moneyFormat = new Intl.NumberFormat('es-MX', money);

  //:::::::::::::::::::::::::::::::::::::::::: Funciones Nuevas ::::::::::::::::::::::::::::::::::::::::::
  function BuscarPorPuesto() { //Modificado [Suemy][2024-09-23]
    const idPuesto = document.getElementById('buscarIdPuesto').value;
    $('#ContainerUploadFilesEmployee').html(`<div class="" id="upload-files-employee"></div>`);
    $('#tablaProcedimientos').html(`<tbody><tr><td>Seleccione función de la tabla</td></tr></tbody>`);
    $('#tablaPasos').html(`<tbody><tr><td>Seleccione procedimiento de la tabla de Procedimientos</td></tr></tbody>`);
    enviaForm(2);
    buscarFastFile('false');
    <? if ($permission['uploadToRepositories'] == 1) { ?>
    obtenerDocPuesto(idPuesto);
    <? } ?>
    AllRepositorio();
    seguimientoPIP();
    TableKPICobranza(idPuesto);
    TableKPIComercial(idPuesto);
    TableKPIProspeccion(idPuesto);
    TableKPIEjecutivo(idPuesto);
    TableKPIOperativo(idPuesto);
    <? if ($sw == 1) {?>
    AltaPuestos(idPuesto);
    <? } ?>
    $('.nav-kpi').removeClass('active');
    $('.tab-kpi').removeClass('active');
    $('#kpi-select').addClass('active');
    $('.container-spinner-load-kpi').html(`<div class="container-spinner-content-upload"><div class="cr-spinner spinner-border" role="status"><span class="visually-hidden"></span></div><p class="cr-cargando" style="font-size:18px;margin:0px;">Espere...</p></div>`);
    setTimeout(function() { $('.container-spinner-load-kpi').html(""); },8000);    
  }

  function LoadingPuestos() {
    const cont = document.getElementById('SpinnerLoadPuestos');
    const sec1 = document.getElementById('P-VerPuesto').value;
    const sec2 = document.getElementById('P-AltaPuestos').value;
    const sec3 = document.getElementById('P-Funciones').value;
    const sec4 = document.getElementById('P-Documentacion').value;
    const sec5 = document.getElementById('P-Reportes').value;
    console.log("VerPuesto: "+sec1+", AltaPuestos: "+sec2+", Funciones: "+sec3+", Documentación: "+sec4+", Reportes: "+sec5);
    <? if ($sw == 1) {?>
      if (sec1 != 0 && sec2 != 0 && sec3 != 0 && sec4 != 0 && sec5 != 0) {
      $(cont).html("");
      cont.style.height = "auto";
    }
    <? } else { ?>
      if (sec1 != 0 && sec4 != 0) {
        $(cont).html("");
        cont.style.height = "auto";
      }
    <? } ?>
  }

  function CargarContenidoMU() {
    const idPuesto = document.getElementById('buscarIdPuesto').value;
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: idPuesto,
          tp: "1"
        },
        // beforeSend: (load) => {
        //   $('#SpinnerManual').html(`
        //     <div class="container-spinner-manual-usuario">
        //         <div class="cr-spinner spinner-border" role="status">
        //             <span class="visually-hidden"></span>
        //         </div>
        //     </div>
        //   `);
        // },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
          for (const m in r) {
            const cuerpo = r[m].contenido;
            const filtro1 = cuerpo.replace(/[']/g, "");
            const filtro2 = filtro1.replace(/\\/g, "");
            $('#'+r[m].idDivContenedor).html(filtro2);
            //$('#SpinnerManual').html("");
          }
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function CargarInfoPuesto() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: "0",
          tp: "2"
        },
        beforeSend: (load) => {
          $('.container-spinner-table-alta-puestos').html(`
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          var disabled = "";
          var option = ``;
          for (const p in r) {
            var disabled = "";
            if(r[p].cantidadPermitida <= r[p].cantidadOcupada) {
              disabled = 'disabled';
            }
            option += `
              <option value="${r[p].idPersonaPuestoGrupo}" ${disabled}>${r[p].personaPuestoGrupo}</option>
            `;
          }
          $('#selectPuestos').html(option);
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function AltaPuestos(idPuesto) {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: idPuesto,
          tp: "3"
        },
        beforeSend: (load) => {  
          $('#SpinnerAltaPuestos').html(`
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          var idPuesto = "";
          var grupo = "";
          var puesto = "";
          var area = "";
          var pp = "";
          //console.log("Grupo: "+r.idPersonaPuestoGrupo);
          if (r.idPuesto != 0) {
            $('#idPuesto').val(r.idPuesto);
            //document.getElementById('selectPuestos').value = r.idPersonaPuestoGrupo;
            $('#selectPuestos option[value="'+ r.idPersonaPuestoGrupo +'"]').prop('selected',true);
            $('#personaPuesto').val(r.personaPuesto);
            $('#areaPuesto option[value="'+ r.idColaboradorArea +'"]').prop('selected',true);
            $('#padrePuesto option[value="'+ r.padrePuesto +'"]').prop('selected',true);
          }
          $('#SpinnerAltaPuestos').html("");
          $('#P-AltaPuestos').val("1");
          LoadingPuestos();
        },
        error: (error) => {
          $('#SpinnerAltaPuestos').html("");
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function DocumentosCC() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: "0",
          tp: "4"
        },
        beforeSend: (load) => {  
          $('.col-spinner-load-general').html(`
              <div class="container-spinner-load-general">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          const a = r['documentospuestoasignados'];
          const b = r['documentospuesto'];
          const c = r['documentos'];
          const ruta = `<?=base_url()?>assets/documentos/capitalHumano/`;
          var subruta = "";
          var link = "";
          var option = "<option></option>";
          var opcion1 = "";
          var opcion2 = "";
          var trtd1 = ``;
          var trtd2 = ``;
          var trtd3 = ``;
          let nombrePuestos = [];
          let add = {};
          //Puestos para el filtro
          a.forEach((e) => {
            if (!nombrePuestos.includes(e.personaPuesto)) {
              nombrePuestos.push(e.personaPuesto);
            }
          });
          //console.log(nombrePuestos);
          for (let i=0;i<nombrePuestos.length;i++) {
            option += '<option class="dropdown-item">'+nombrePuestos[i]+'</option>';
          }
          //Documentos Asignados
          for (const s in a) {
            const id = a[s].id;
            const nameDoc = a[s].url.replace(/[_]/g, " ");
            let ref = a[s].url.slice((a[s].url.lastIndexOf(".") - 1 >>> 0) + 2);

            if (a[s].carpeta != "raiz") {
              subruta = a[s].carpeta;
            }
            else {
              subruta = `materialDidactico/${a[s].carpeta}`;
            }
            link = ruta+subruta+a[s].url;

            if (ref == "pdf" || ref == "xml" || ref == "txt" || ref == "jpg" || ref == "jpeg" || ref == "png" || ref == "mp4") {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#" download>Descargar</a></li>`;
            }
            else {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#">Descargar</a></li>`;
            }

            <? if (empty($permission["delete"]["disabled"])) {?>
              opcion2 = `
                <li role="presentation" class="<?=$permission["delete"]["disabled"]?>">
                  <a class="text-danger" role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="eliminarArchivo('${id}')">
                  <?=$permission["delete"]["label"]?></a>
                </li>`;
            <? } ?>

            trtd1 += `
              <tr class="mostrar">
                <td width="40%">${a[s].nombre}</td>
                <td width="40%">${a[s].personaPuesto}</td>
                <td>
                  <div class="dropdown">
                    <a class="text-dark" href="javascript: void(0)" data-target="#" id="optionLabel" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">${nameDoc}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                      <li role="presentation">
                        <a href="#" data-toggle="modal" data-target="#visor_pdf" onclick="setVisorPdf('${link}','${a[s].nombre}','${nameDoc}')">Ver</a>
                      </li>
                      ${opcion1}
                      ${opcion2}
                    </ul>
                  </div>
                </td>
              </tr>
            `;
            //option += '<option class="dropdown-item">'+a[s].personaPuesto+'</option>';
          }
          //Documentos del Puesto
          for (const p in b) {
            const id = b[p].id;
            const nameDoc = b[p].url.replace(/[_]/g, " ");
            let ref = b[p].url.slice((b[p].url.lastIndexOf(".") - 1 >>> 0) + 2);

            if (b[p].carpeta == "raiz") {
              subruta = b[p].url;
            }
            else {
              subruta = `materialDidactico/${b[p].url}`;
            }
            link = ruta+subruta;

            if (ref == "pdf" || ref == "xml" || ref == "txt" || ref == "jpg" || ref == "jpeg" || ref == "png" || ref == "mp4") {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#" download>Descargar</a></li>`;
            }
            else {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#">Descargar</a></li>`;
            }

            <? if (empty($permission["delete"]["disabled"])) {?>
              opcion2 = `
                <li role="presentation" class="<?=$permission["delete"]["disabled"]?>">
                  <a class="text-danger" role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="eliminarArchivo('${id}')">
                  <?=$permission["delete"]["label"]?></a>
                </li>`;
            <? } ?>

            trtd2 += `
              <tr>
                <td width="50%">${b[p].nombre}</td>
                <td>
                  <div class="dropdown">
                    <a class="text-dark" href="javascript: void(0)" data-target="#" id="optionLabel" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">${nameDoc}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                      <li role="presentation">
                        <a href="#" data-toggle="modal" data-target="#visor_pdf" onclick="setVisorPdf('${link}','${b[p].nombre}','${nameDoc}')">Ver</a>
                      </li>
                      ${opcion1}
                      ${opcion2}
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            `;
          }
          //Documentos Generales
          for (const d in c) {
            const id = c[d].id;
            const nameDoc = c[d].url.replace(/[_]/g, " ");
            let ref = c[d].url.slice((c[d].url.lastIndexOf(".") - 1 >>> 0) + 2);

            if (c[d].carpeta == "raiz") {
              subruta = c[d].url;
            }
            else {
              subruta = `materialDidactico/${c[d].url}`;
            }
            link = ruta+subruta;

            if (ref == "pdf" || ref == "xml" || ref == "txt" || ref == "jpg" || ref == "jpeg" || ref == "png" || ref == "mp4") {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#" download>Descargar</a></li>`;
            }
            else {
              opcion1 = `<li role="presentation"><a href="${link}" target="_blank" role="menuitem" tabindex="-1" data-target="#">Descargar</a></li>`;
            }

            <? if (empty($permission["delete"]["disabled"])) {?>
              opcion2 = `
                <li role="presentation" class="<?=$permission["delete"]["disabled"]?>">
                  <a class="text-danger" role="menuitem" tabindex="-1" href="javascript: void(0)" onclick="eliminarArchivo('${id}')">
                  <?=$permission["delete"]["label"]?></a>
                </li>`;
            <? } ?>

            trtd3 += `
              <tr>
                <td>${c[d].nombre}</td>
                <td>
                  <div class="dropdown">
                    <a class="text-dark" href="javascript: void(0)" data-target="#" id="optionLabel" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">${nameDoc}<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                      <li role="presentation">
                        <a onclick="setVisorPdf('${link}','${c[d].nombre}','${nameDoc}')">Ver</a>
                      </li>
                      ${opcion1}
                      ${opcion2}
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            `;
          }
          $('#SelectFiltrar').html(option);
          $('#body-table-doc-asignado').html(trtd1);
          $('#body-table-doc-puesto').html(trtd2);
          $('#body-table-doc-general').html(trtd3);
          $('.col-spinner-load-general').html("");
          $('#P-Documentacion').val("1");

          /*let eliminarDuplicado=this.SelectFiltrar.options;
          let array=[];let arraySR=[];
          for(let val of eliminarDuplicado){array.push(val.value);}
          arraySR=[... new Set(array)];
          let optionSinDuplicados='';
          arraySR.forEach(val=>{optionSinDuplicados+=`<option class="dropdown-item">${val}</option>`})
          this.SelectFiltrar.innerHTML=optionSinDuplicados;*/

          LoadingPuestos();
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function eliminarArchivo(file) {
    $.ajax({
        type: "POST",
        url: `<?=base_url()?>capitalHumano/delete_archivo`,
        data: {
          id: file
        },
        beforeSend: (load) => {  
          $('.col-spinner-documentacion').html(`
            <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Espera...</p>
              </div>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          $('.col-spinner-documentacion').html("");
          if (r['success'] != false) {
            swal("¡Eliminado!", "Documento eliminado con éxito.", "success");
            DocumentosCC();
          }
        },
        error: (error) => {
          $('.col-spinner-documentacion').html("");
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  /*function ConsultaPermisos() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: "0",
          tp: "6"
        },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }*/

  function TablaGrupoPuestos() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: "0",
          tp: "5"
        },
        beforeSend: (load) => {  
          $('.body-table-grupos-puesto').html(`
            <tr>
              <td colspan="5">
                <center>
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
              </div>
                </center>
              </td>
            </tr>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          const p = r['puestosGrupos'];
          const c = r['colaboradorConPuesto'];
          var disabled = "";
          var trtd1 = ``;
          var trtd2 = ``;
          var trtd3 = ``;

          if (p != 0) {
            for (const a in p) {
              if (p[a].cantidadPermitida == p[a].cantidadOcupada) {
                disabled = 'class="danger"';
              }
              trtd1 += `
                <tr onclick="muestraCCP(this)" data-puesto="${p[a].personaPuestoGrupo}" data-ppg="${p[a].idPersonaPuestoGrupo}" ${disabled}>';
                  <td>${p[a].personaPuestoGrupo}</td>
                  <td>${p[a].cantidadPermitida}</td>
                  <td>${p[a].cantidadOcupada}</td>
                  <td>
                    <button class="btn btn-success btn-radius" onclick="incrementarPuesto('${p[a].idPersonaPuestoGrupo}',1)">
                      <i class="fas fa-plus"></i>
                    </button>
                  </td>'; 
                  <td>
                    <button class="btn btn-danger btn-radius" onclick="incrementarPuesto('${p[a].idPersonaPuestoGrupo}',0)">
                      <i class="fas fa-minus"></i>
                    </button>
                  </td>'; 
                '</tr>`;

              //imprimirTablaGrupoPuestosNuevo($datos,$colaboradorCP)
              /*var trtd3 = ``;
              var colorFondoCS='circuloVerde';
              var bandFondo=0;
              var contBand=0;

              for (const b in c) {
                if (b == p[a].idPersonaPuestoGrupo) {
              var divBanderaDP='';
              var divColorFondoCS='';
              var divDocumentosDelPuesto='';
                  var divFuncionesProcesos='';
                  //console.log(b);
                  for (const d in c[b]) {
                    const e = c[b][d].requerimientosPuestoDoc;
                    const g = c[b][d].documentosDelPuesto;
                    const i = c[b][d].informacionProcesos;
                    const k = c[b][d].documentosPersonales;
                    var bandFondo=1;
                    var contBand=0;
                    var colorFondoCS='circuloVerde';

                    trtd3 += `
                      <tr name="hijo${b}" class="ocultarObjeto">
                        <td>${c[b][d].nombrePersona}</td>
                        <td>${c[b][d].personaPuesto}</td>
                        <td>
                          <div style="height:300px;width100%;overflow:auto">`;

                    //requerimientosPuestoDoc
                    for (const f in e) {
                      contBand++;
                      var checado='checked';
                      var checadoclass="conDocClass";
                      if(e[f].bandContenido != 0){}
                      if(!e[f].bandContenido){
                        checado='';
                        checadoclass='sinDocClass';
                        bandFondo++;
                      }
                      trtd3 += `<div class="requerimientoPuesto ${checadoclass}"><label>${e[f].descripcionMUP}</label><input type="checkbox" class="form-check-input" disabled ${checado}></div><br>`;
                    }

                    if(bandFondo>1){colorFondoCS='circuloAmarillo';}else{if((contBand*11)==0){colorFondoCS='circuloRojo';}}
                    divColorFondoCS+='<div class="circulosSemaforo '+colorFondoCS+'"><div class="ocultarObjeto">'+c[b][d].nombrePersona+'('+c[b][d].personaPuestoGrupo+')</div></div>';
                    
                    trtd3 +=`
                          </div>
                        </td>
                        <td><div style="height:300px;width100%;overflow:auto">`;

                    //documentosDelPuesto
                    var bandDocumentosClass='circuloRojo';
                    var documentosObligatoriosClass='circuloRojo';
                    for (const h in g) {
                      bandDocumentosClass='circuloVerde';
                      trtd3 += `
                        <div><a href="<?=base_url()?>assets/documentos/capitalHumano/${g[h].url}">${g[h].nombre}</a></div><br>
                      `;
                    }

                    trtd3 += `</div></td>`;

                    divDocumentosDelPuesto+='<div class="circulosSemaforo '+bandDocumentosClass+'"><div class="ocultarObjeto">'+c[b][d].nombrePersona+'('+c[b][d].personaPuestoGrupo+')</div></div>';

                    trtd3 +=`<td><div style="height:300px;width100%;overflow:auto">`;

                    var classInformacionProcesos='circuloVerde';
                    if(c[b][d].bandInformacionProcesos==0){classInformacionProcesos='circuloRojo';}

                    //informacionProcesos
                    for (const j in i) {
                      //console.log(i[j].funcion);
                      classInformacionProcesos='circuloAmarillo';          
                      trtd3+='<div><label>FUNCION</label>'+i[j].funcion+'<label>PROCESO</label>'+i[j].proceso+'('+i[j].informacion+')</div><hr><br>';
                    }

                    trtd3 += `</div></td></td>`;

                    divFuncionesProcesos+='<div class="circulosSemaforo '+classInformacionProcesos+'"><div class="ocultarObjeto">'+c[b][d].nombrePersona+'('+c[b][d].personaPuestoGrupo+')</div></div>';

                    trtd3 +=`<td><div style="height:300px;width100%;overflow:auto">`;

                    var DPClass='circuloRojo';
                    if(c[b][d].bandInformacionProcesos==0){classInformacionProcesos='circuloRojo';}
                    if(c[b][d].bandDocPersonales==1){DPClass='circuloAmarillo';}
                    if(c[b][d].bandDocPersonales==2){DPClass='circuloVerde';}

                    divBanderaDP+='<div class="circulosSemaforo '+DPClass+'"><div class="ocultarObjeto">'+c[b][d].nombrePersona+'('+c[b][d].personaPuestoGrupo+')</div></div>';

                    //documentosPersonales
                    for (const l in k) {
                      var check = "";
                      if(k[l].tieneDocumento=='1'){check='checked';}
                      trtd3+='<div class="requerimientoPuesto conDocClass"><label>'+k[l].textoPD+'</label><input type="checkbox" class="form-check-input" disabled '+check+'></div><br>';
                    }

                    trtd3 +=`</div></td></td>`;
                  }
                  trtd3 +=`</tr>`;
                  }
                }

              trtd2 += `
                <tr onclick="muestraCCP(this)" data-puesto="${p[a].personaPuestoGrupo}" data-ppg="${p[a].idPersonaPuestoGrupo}" ${disabled}>
                  <td><button class="btn btn-primary" onclick="muestraHijos(this,'${p[a].idPersonaPuestoGrupo}')">+</button></td>
                  <td>${p[a].personaPuestoGrupo}</td>
                  <td align="center"><div class="divContieneSemaforos">${divColorFondoCS}</div></td>
                  <td align="center"><div class="divContieneSemaforos">${divDocumentosDelPuesto}</div></td>
                  <td align="center"><div class="divContieneSemaforos">${divFuncionesProcesos}</div></td>
                  <td align="center"><div class="divContieneSemaforos">${divBanderaDP}</div></td>
                  <td>${p[a].cantidadPermitida}</td>
                  <td>${p[a].cantidadOcupada}</td>
                  <td>
                    <button class="btn btn-success btn-radius" onclick="incrementarPuesto('${p[a].idPersonaPuestoGrupo}',1)">
                      <i class="fas fa-plus"></i>
                    </button>
                  </td> 
                  <td>
                    <button class="btn btn-danger btn-radius" onclick="incrementarPuesto('${p[a].idPersonaPuestoGrupo}',0)">
                      <i class="fas fa-minus"></i>
                    </button>
                  </td> 
                </tr>
                ${trtd3}
              `;*/
            }
          }
          else {
            trtd1 += `
              <tr>
                <td colspan="5">
                  <center>
                    <b>No se encontraron registros.</b>
                  </center>
                </td>
              </tr>`;
          }

          //imprimirdivColaboradorConPuesto($datos)
          /*for (const b in c) {
            div += `<div id="divCCP${b}" name="puestosOcupados">`;
            for (const d in c[b]) {
              div += `<div class="subtitle-center-puesto">Puesto y Homónimos: ${c[b][d].personaPuesto} (${c[b][d].nombrePersona})</div>`;
            }
            div += `</div>`;
          }*/

          $('.container-spinner-table-alta-puestos').html(""); 
          $('.body-table-grupos-puesto').html(trtd1);
          /*$('.body-table-nt').html(trtd2);
          $('#divColaboradorConPuesto').html(div);*/
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  /*function TablaGrupoPuestosNuevos() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getInfoPuesto`,
        data: {
          id: "0",
          tp: "5"
        },
        success: (data) => {
          const r = JSON.parse(data);
          console.log(r);
          var disable='';
          var tableHijo='';
          var colorFondoCS='circuloVerde';
          var bandFondo=0;
          var contBand=0;
          //imprimirTablaGrupoPuestosNuevo
          for (const p in r) {
            if (r[p].cantidadPermitida == r[p].cantidadOcupada) {
              disable = 'class="danger"';
            }
          }    
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }            
    })
  }*/

  function TablasReportes() {
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTablesReport`,
        beforeSend: (load) => {  
          $('.list-table-vacations-body').html(`
            <tr>
              <td colspan="12">
                <center>
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
                </center>
              </td>
            </tr>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          const a = r['vacaciones'];
          const b = r['asistencias'];
          const c = r['puntualidad'];
          var puntualidad = "";
          var trtd1 = ``;
          var trtd2 = ``;

          if (r != 0) {
            for (const v in a) {
              const fila = Number(v) + 1;
              const nombre = textValue(a[v].nombre);
              const puesto = textValue(a[v].personaPuesto);
              const email = textValue(a[v].email);
              const area = textValue(a[v].colaboradorArea);
              const jefe = textValue(a[v].correoJefeDirecto);
              const antiguedad = textValue(a[v].antiguedad);
              const fsalida = dateFormat(a[v].fecha_salida);
              const fretorno = dateFormat(a[v].fecha_retorno);
              const dias = textValue(a[v].cantidad_dias);
              const estatus = textValue(a[v].estado).toUpperCase();
              const solicitado = dateFormat(a[v].fecha);
              var estado = "";
              //console.log(v);
              switch(estatus) {
                case "PENDIENTE":
                  estado = "label-primary";
                break;
                case "APROBADO":
                  estado = "label-success";
                break;
                case "RECHAZADO":
                  estado = "label-danger";
                break;
                case "CANCELADO":
                  estado = "label-warning";
                break;
              }

              trtd1 += `
                <tr id="V-${a[v].id}">
                  <td>${fila}</td>
                  <td>${nombre}</td>
                  <td>${puesto}</td>
                  <td>${email}</td>
                  <td>${area}</td>
                  <td>${jefe}</td>
                  <td>${antiguedad}</td>
                  <td>${fsalida}</td>
                  <td>${fretorno}</td>
                  <td>${dias}</td>
                  <td><span class="label ${estado}">${estatus}</span></td>
                  <td>${solicitado}</td>
                </tr>
              `;
            }

            for (const s in b) {
              const fila = Number(s) + 1;
              const nombre = textValue(b[s].empleado);
              const puesto = textValue(b[s].personaPuesto);
              const email = textValue(b[s].email);
              const area = textValue(b[s].colaboradorArea);
              var HCreate = new Date(b[s].fecha);
              const registro = dateFormat(b[s].fecha) + " " + HCreate.toLocaleTimeString('en-US');
              puntualidad = "No";
              if (b[s].descripcion == "asistencia") {
                for (const p in c) {
                  if (b[s].fecha == c[p].fecha) {
                    puntualidad = 'Sí';
                  }
                }
                trtd2 += `
                  <tr class="mostrarAsistencia">
                    <td>${fila}</td>
                    <td>${nombre}</td>
                    <td>${puesto}</td>
                    <td>${email}</td>
                    <td>${area}</td>
                    <td>Sí</td>
                    <td>${puntualidad}</td>
                    <td>${registro}</td>
                  </tr>
                `;
              }
            }
          }
          else {
            trtd1 += `
              <tr>
                <td colspan="12">
                  <center>
                    No hay registros
                  </center>
                </td>
              </tr>`;

            trtd2 += `
              <tr>
                <td colspan="12">
                  <center>
                    No hay registros
                  </center>
                </td>
              </tr>`;
          }
          $('.list-table-vacations-body').html(trtd1);
          $('.list-table-asistencias-body').html(trtd2);
          $('#TablaVacaciones').DataTable({
              language: {
                  url: `<?=base_url()?>assets/js/espanol.json`
              },
              // dom: '<"toolbar toolbar-table-poliza">rtip ',
              // initComplete: function(row) {
              //     var tmp = `
              //     <div></div>`
              //     $('div.toolbar-table-poliza').html(tmp);
              // },
              columns:[
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: false,
                  orderable: false,
              }],
              //order: [['11', 'desc']],
          });
          $('#TablaAsistencias').DataTable({
              language: {
                  url: `<?=base_url()?>assets/js/espanol.json`
              },
              columns:[
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: true,
                  orderable: true,
              },
              {
                  sortable: false,
                  orderable: false,
              }],
              //order: [['11', 'desc']],
          });

          $('#P-Reportes').val("1");
          LoadingPuestos();
        },
        error: (error) => {
          console.log("Hay conflicto al buscar la información.");
        }
    })
  }

  function TableKPICobranza(idPuesto) { //Creado [Suemy][2024-02-16]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTableKPICobranza`,
        data: {
          id: idPuesto
        },
        beforeSend: (load) => {  
          $('#bodyTableKPICobranza').html(`
            <tr>
              <td colspan="5">
                <center>
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                  </div>
                </center>
              </td>
            </tr>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          if (r['permiso'] == 1) { $('#nav-kpi-c').css('display',''); $('#kpi-c').css('display',''); }
          else { $('#nav-kpi-c').css('display','none'); $('#kpi-c').css('display','none'); }
          var trtd = r['resultados'];
          $('#bodyTableKPICobranza').html(trtd);
        },
        error: (error) => {
          console.log(error);
          $('#bodyTableKPICobranza').html("");
          //console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function TableKPIComercial(idPuesto) { //Creado [Suemy][2024-02-16]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTableKPIComercial`,
        data: {
          id: idPuesto
        },
        beforeSend: (load) => {  
          $('#bodyTableKPIComercial').html(`
            <tr>
              <td colspan="3">
                <center>
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                  </div>
                </center>
              </td>
            </tr>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          let vn = r['venta_nueva'];
          let it = r['ingreso_total'];
          var trtd = ``;
          if (r['permiso'] == 1) { $('#nav-kpi-m').css('display',''); $('#kpi-m').css('display',''); }
          else { $('#nav-kpi-m').css('display','none'); $('#kpi-m').css('display','none'); }
          if (vn != 0 && it != 0) {
            trtd = `
              <tr>
                <td>Meta</td>
                <td>${moneyFormat.format(vn['meta'])}</td>
                <td>${moneyFormat.format(it['meta'])}</td>
              </tr>
              <tr>
                <td>Avance</td>
                <td>${moneyFormat.format(vn['comision'])}</td>
                <td>${moneyFormat.format(it['comision'])}</td>
              </tr>
              <tr>
                <td>Promedio Comisión Real</td>
                <td>${moneyFormat.format(vn['comision_real'])}</td>
                <td>${moneyFormat.format(it['comision_real'])}</td>
              </tr>
              <tr>
                <td>Promedio Comisión Sugerida</td>
                <td>${moneyFormat.format(vn['comision_sugerida'])}</td>
                <td>${moneyFormat.format(it['comision_sugerida'])}</td>
              </tr>`
            ;
          }
          else {
            trtd = `<tr><td colspan="3"><center>Sin resultados</center></td></tr>`;
          }
          $('#bodyTableKPIComercial').html(trtd);
        },
        error: (error) => {
          console.log(error);
          $('#bodyTableKPIComercial').html("");
          //console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function TableKPIProspeccion(idPuesto) { //Creado [Suemy][2024-02-16]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTableKPIProspeccion`,
        data: {
          id: idPuesto
        },
        beforeSend: (load) => {  
          $('#bodyTableKPIProspeccion').html(`
            <tr>
              <td colspan="5">
                <center>
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                  </div>
                </center>
              </td>
            </tr>
          `);
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          if (r['permiso'] == 1) { $('#nav-kpi-p').css('display',''); $('#kpi-p').css('display',''); }
          else { $('#nav-kpi-p').css('display','none'); $('#kpi-p').css('display','none'); }
          var trtd = r['resultados'];
          $('#bodyTableKPIProspeccion').html(trtd);
        },
        error: (error) => {
          console.log(error);
          $('#bodyTableKPIProspeccion').html("");
          //console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function TableKPIEjecutivo(idPuesto) { //Creado [Suemy][2024-02-16]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTableKPIEjecutivo`,
        data: {
          id: idPuesto
        },
        beforeSend: (load) => {  
          /*$('#bodyTableKPIEjecutivo').html(`
            <tr>
              <td colspan="5">
                <center>
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                  </div>
                </center>
              </td>
            </tr>
          `);*/
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          if (r['permiso'] == 1) { $('#nav-kpi-e').css('display',''); $('#kpi-e').css('display',''); }
          else { $('#nav-kpi-e').css('display','none'); $('#kpi-e').css('display','none'); }
          $('.ramoEjecutivo').text(r['ramo']);
          $('#bodyTableKPIEjecutivo1').html(r['trtd1']);
          $('#bodyTableKPIEjecutivo2').html(r['trtd2']);
          $('#bodyTableKPIEjecutivo3').html(r['trtd3']);
        },
        error: (error) => {
          console.log(error);
          $('#bodyTableKPIEjecutivo1').html("");
          $('#bodyTableKPIEjecutivo2').html("");
          $('#bodyTableKPIEjecutivo3').html("");
          //console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function TableKPIOperativo(idPuesto) { //Creado [Suemy][2024-02-16]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>capitalHumano/getTableKPIOperativo`,//capitalHumano/getTableKPIOperativo, //actividades/getActivitiesKpi
        data: {
          id: idPuesto
        },
        beforeSend: (load) => {  
          /*$('#bodyTableKPIOperativo').html(`
            <tr>
              <td colspan="5">
                <center>
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                  </div>
                </center>
              </td>
            </tr>
          `);*/
        },
        success: (data) => {
          const r = JSON.parse(data);
          //console.log(r);
          if (r['permiso'] == 1) { 
            $('#nav-kpi-o').css('display',''); $('#kpi-o').css('display',''); 
            let autos = r['autos'];
            let danio = r['daños'];
            let vida = r['vida'];
            let ren = r['renovaciones'];
            let pen = r['pendientes'];
            var trtd1 = getTableKPI(autos);
            var trtd2 = getTableKPI(danio);
            var trtd3 = getTableKPI(vida);
            var trtd4 = `
              <tr><td colspan="5" class="tr-cobranza">Pólizas Renovadas</td></tr>
              <tr>
                <td>Autos</td>
                <td>${ren['autosRenV']}</td>
                <td>${ren['autosRenA']}</td>
                <td>${ren['autosRenR']}</td>
                <td class="tr-total">${ren['totalAutos']}</td>
              </tr>
              <tr>
                <td>Daños</td>
                <td>${ren['daniosRenV']}</td>
                <td>${ren['daniosRenA']}</td>
                <td>${ren['daniosRenR']}</td>
                <td class="tr-total">${ren['totalDanios']}</td>
              </tr>
              <tr>
                <td>Líneas Personales</td>
                <td>${ren['vidaRenV']}</td>
                <td>${ren['vidaRenA']}</td>
                <td>${ren['vidaRenR']}</td>
                <td class="tr-total">${ren['totalVida']}</td>
              </tr>
              <tr class="tr-total">
                <td>Total</td>
                <td>${ren['totalVerde']}</td>
                <td>${ren['totalAmarillo']}</td>
                <td>${ren['totalRojo']}</td>
                <td>${ren['total']}</td>
              </tr>
              <tr><td colspan="5" class="tr-cobranza">Pólizas Pendientes por Renovar</td></tr>
              <tr>
                <td>Autos</td>
                <td>${pen['autosPenV']}</td>
                <td>${pen['autosPenA']}</td>
                <td>${pen['autosPenR']}</td>
                <td class="tr-total">${pen['totalAutos']}</td>
              </tr>
              <tr>
                <td>Daños</td>
                <td>${pen['daniosPenV']}</td>
                <td>${pen['daniosPenA']}</td>
                <td>${pen['daniosPenR']}</td>
                <td class="tr-total">${pen['totalDanios']}</td>
              </tr>
              <tr>
                <td>Líneas Personales</td>
                <td>${pen['vidaPenV']}</td>
                <td>${pen['vidaPenA']}</td>
                <td>${pen['vidaPenR']}</td>
                <td class="tr-total">${pen['totalVida']}</td>
              </tr>
              <tr class="tr-total">
                <td>Total</td>
                <td>${pen['totalVerde']}</td>
                <td>${pen['totalAmarillo']}</td>
                <td>${pen['totalRojo']}</td>
                <td>${pen['totalPendientes']}</td>
              </tr>
            `;
            $('#tableAutosOperativo').html(trtd1);
            $('#tableDaOperativo').html(trtd2);
            $('#tableLPOperativo').html(trtd3);
            $('#bodyTableRenovacionesOp').html(trtd4);
          }
          else { $('#nav-kpi-o').css('display','none'); $('#kpi-o').css('display','none'); }
        },
        error: (error) => {
          console.log(error);
          //console.log("Hay conflicto al buscar la información.");
        }            
    })
  }

  function GenerarReporte(tipo) {
    let table = "";

    if (tipo == "3") {
      table = $('#TablaVacaciones').find('tbody tr');
    }
    else if (tipo == "4") {
      table = $('#TablaAsistencias').find('tbody tr');
    }

    if (table.length > 700) {
      swal({
        title: "¿Seguro que desea descargarlo?",
        text: "La cantidad total de registros que desea descargar superan los 700 y puede tardar un tiempo en generar el archivo descargable.",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
        if (value) {
          DescargarReporte(tipo);
        }
      })
    }
    else {
      DescargarReporte(tipo);
    }
  }

  function DescargarReporte(tipo) {
    /*$('.col-spinner-reportes').html(`
      <div class="container-spinner-content-upload">
          <div class="cr-spinner spinner-border" role="status">
              <span class="visually-hidden"></span>
          </div>
          <p class="cr-cargando" style="font-size:18px;">Espera...</p>
      </div>
    `);*/
    var tablaActual = "";
    var nameTable = "";
    let refDoc = "";

    if (tipo == "3") {
      tablaActual = document.querySelector('#TablaVacaciones');
      nameTable = "Registro Vcaciones";
    }
    else if (tipo == "4") {
      tablaActual = document.querySelector('#TablaAsistencias');
      nameTable = "Registro Asistencias";
    }

    let tableExport = new TableExport(tablaActual, {
        exportButtons: false, // No queremos botones
        filename: nameTable, //Nombre del archivo de Excel
        sheetname: nameTable, //Tí­tulo de la hoja
    });
    let datos = tableExport.getExportData();

    if (tipo == "3") {
      refDoc = datos.TablaVacaciones.xlsx;
    }
    else if (tipo == "4") {
      refDoc = datos.TablaAsistencias.xlsx;
    }
    //console.log(refDoc);
    tableExport.export2file(refDoc.data,refDoc.mimeType,refDoc.filename,refDoc.fileExtension,refDoc.merges,refDoc.RTL,refDoc.sheetname);
    //$('.col-spinner-reportes').html("");
  }

  function MostrarTabla(table) {
    switch (table) {
      case 1:
        $('#tablaFunciones').toggle(500, "easeInOutExpo");
      break;
    }
  }

  //Formato Fechas
  var nombremeses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
  var numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
  var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

  function dateFormat(dato) {
    var fecha = "";

    if (dato != undefined || dato != null || dato != 0) {
      if (!dato.includes(':')) { dato = dato + " 00:00:00";}
      date = new Date(dato);
      fecha = date.getFullYear() + "/" + numeromeses[date.getMonth()] + "/" + numerodias[date.getDate()];
    }

    return fecha;
  }

  function textValue(dato) {
    if (dato == undefined || dato == "[object Object]" || dato == null) {
        dato = "";
    }
    else {
        dato = dato;
    }
    return dato;
  }

  function openContainer(event) { //Creado [Suemy][2024-02-16]
      const icon = $(event).children('i');
        icon.attr('class', icon.hasClass('fas fa-plus') ? 'fas fa-minus' : icon.attr('data-class'));
        icon.attr('title', icon.hasClass('fas fa-plus') ? 'Ver' : 'Ocultar');
  }

  function getTableKPI(data) { //Creado [Suemy][2024-02-16]
    var table = `
      <thead>                        
        <tr style="background: #396da1;">
          <th colspan="5"><center>SEMÁFORO<center></th>
        </tr>
        <tr style="background: #acc5df;">
          <th></th>
          <th><span class="semaphore-green"><i class="fas fa-circle"></i></span></th>
          <th><span class="semaphore-yellow"><i class="fas fa-circle"></i></span></th>
          <th><span class="semaphore-red"><i class="fas fa-circle"></i></span></th>
          <th style="color: black;">Totales</th>
        </tr>
      </thead>
      <tbody id="bodyTableAutosOperativo">
        <tr>
          <td>Cotizaciones</td>
          <td>${data['CotizacionV']}</td>
          <td>${data['CotizacionA']}</td>
          <td>${data['CotizacionR']}</td>
          <td class="tr-total">${data['CotizacionT']}</td>
        </tr>
        <tr>
          <td>Cancelación</td>
          <td>${data['CancelacionV']}</td>
          <td>${data['CancelacionA']}</td>
          <td>${data['CancelacionR']}</td>
          <td class="tr-total">${data['CancelacionT']}</td>
        </tr>
        <tr>
          <td>Endosos</td>
          <td>${data['EndosoV']}</td>
          <td>${data['EndosoA']}</td>
          <td>${data['EndosoR']}</td>
          <td class="tr-total">${data['EndosoT']}</td>
        </tr>
        <tr>
          <td>Emisión</td>
          <td>${data['EmisionV']}</td>
          <td>${data['EmisionA']}</td>
          <td>${data['EmisionR']}</td>
          <td class="tr-total">${data['EmisionT']}</td>
        </tr>
        <tr class="tr-total">
          <td>Total</td>
          <td>${data['totalVerde']}</td>
          <td>${data['totalAmarillo']}</td>
          <td>${data['totalRojo']}</td>
          <td>${data['total']}</td>
        </tr>
        <tr><td colspan="5" style="padding:15px;background: white;"></td></tr>
        <tr style="background: #396da1;color: white;"><th><i class="fas fa-clock"></i></th><th colspan="2">Diario</th><th colspan="2">Semanal</th></tr>
        <tr><td>Promedio</td><td colspan="2">${data['diario']}</td><td colspan="2">${data['semanal']}</td></tr>
      </tbody>`;
    return table;
  }

  //:::::::::::::::::::::::::::::::: Funciones Modificadas (Cambios significativos) ::::::::::::::::::::::::::::::::::
  function obtenerDocPuesto(idPuesto) {
    const employeeDocsModal = new EmployeeModal(
      "#upload-files-employee", 
      idPuesto,
      {
        upload: $("#repository-permission").val() > 0 ? true : false,
        formats: true, //Descargar formato de requerimiento
        requerimentsFile: true,
        jobProfile: true, //Descargar perfil del puesto
      }
    );
    employeeDocsModal.render();
    //console.log(employeeDocsModal);
  }

  function nuevoPuestoAutorizado(){
    const idPuesto = document.getElementById('buscarIdPuesto').value;
    const puesto = document.getElementById('selectPuestos');
    swal({
      text: 'Escribe el nombre del puesto Homónimo.',
      content: "input",
      buttons: ["Cancelar", "Crear"],
      // button: {
      //   text: "Crear",
      //   closeModal: false,
      // },
    }).then((value) => {
      //console.log(value);
      if (value != "" && value != null) {
          $.ajax({
            type: "POST",
            url: "<?=base_url();?>capitalHumano/creaPuestoHomonimo",
            data: {
              personaPuestoGrupo: value,
            },
            beforeSend: (load) => {
              $('#SpinnerAltaPuestos').html(`
                  <div class="container-spinner-content-upload">
                      <div class="cr-spinner spinner-border" role="status">
                          <span class="visually-hidden"></span>
                      </div>
                      <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
                  </div>
              `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                $('#SpinnerAltaPuestos').html("");
                if (r['success']) {
                  CargarInfoPuesto();
                  TablaGrupoPuestos();
                  if (puesto.disabled) {
                    console.log('Puestos desactivado');
                    AltaPuestos(idPuesto);
                  }
                  else {
                    console.log('Puestos activado');
                  }
                }
            },
            error: (error) => {
              $('#SpinnerPuestos').html("");
                swal("¡Uups!", "Hay problemas al intentar encontrar la información.", "error");
            }            
          })
      }
      else if (value == "") {
        swal("¡Espera!", "Necesitas agregar el nombre", "warning");
      }
    })
    //    var textoEscrito = prompt("Escribe el nombre del puesto Homónimo", "");
    //   textoEscrito=textoEscrito.trim();
    // if(textoEscrito != null && textoEscrito != '')
    // {
    //   document.getElementById('hiddenPuestoHomonimo').value=textoEscrito;
    //   document.getElementById('formCreaPuestoHomonimo').submit();
    // } 
    // else {alert("Necesitas agregar el nombre");}
  }

  function nuevoPuesto(){
    document.getElementById("idPuesto").value=0;
    document.getElementById("padrePuesto").value=1;
    document.getElementById('personaPuesto').value="";
    $('#areaPuesto').val("");
    $('#selectPuestos').prop('disabled',false);
  }

  function enviaForm(accion){ //Modificado* [Suemy][2024-03-01]
    const idPuesto = document.getElementById('buscarIdPuesto').value;
    var direccion="";var clase="";var id="";
    switch(accion){
      case 1:direccion=<?php echo('"'.base_url().'capitalHumano/puesto"'); ?>;clase="puesto";break;
      case 2:direccion=<?php echo('"'.base_url().'capitalHumano/buscarFunciones"'); ?>;clase="buscarPuesto";break;
      case 3:direccion=<?php echo('"'.base_url().'capitalHumano/asignarFuncionesPuesto"'); ?>;clase="asignaFPEstilo";break;
      case 4:direccion=<?php echo('"'.base_url().'capitalHumano/guardarManualUsuario"'); ?>;
    }
    var formulario=document.createElement('form'); formulario.setAttribute('method','post');
    formulario.action=direccion;formulario.id="miFormulario";
    objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
    for(var i=0;i<cant;i++){
      tipo=objetosForm[i].nodeName;
      var objeto=document.createElement('input');
      objeto.className = "hidden"; 
      objeto.name=objetosForm[i].id;objeto.value=objetosForm[i].value;formulario.appendChild(objeto);
    }

    document.body.appendChild(formulario);
    var formData = new FormData(formulario);
    if (accion == 1) {
      const puesto = document.getElementById('selectPuestos').value;
      const nombre = document.getElementById('personaPuesto').value;
      const area = document.getElementById('areaPuesto').value;
      const responsable =document.getElementById('padrePuesto').value;
      if (puesto != 0 && nombre != 0 && area != 0 && responsable != 0) {
        $.ajax({
          url: direccion,
          type: "POST",
          dataType: "html",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: (load) => {
            $('#SpinnerAltaPuestos').html(`
                <div class="container-spinner-content-upload">
                    <div class="cr-spinner spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
                </div>
            `);
          },
          success: (data) => {
              const r = JSON.parse(data);
              console.log(r);
              $('#SpinnerAltaPuestos').html("");
              if (r['success']) {
                swal("¡Guardado!", "La información se guardó con éxito.", "success");
              }
          },
          error: (error) => {
            $('#SpinnerAltaPuestos').html("");
              swal("¡Uups!", "Hay problemas al intentar guardar la información.", "error");
          }          
        })
      }
      else {
        swal("¡Espera!", "Parece que falta llenar información.", "warning");
      }
    } else if (accion == 2) {
      $.ajax({
        url: direccion,
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: (load) => {
          $('#SpinnerPuestos').html(`
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
              </div>
          `);
          $('#tablaFunciones').html(`
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
          `);
        },
        success: (data) => {
            const r = JSON.parse(data);
            //console.log(r);
            $('#SpinnerPuestos').html("");
            //const mu = r['contenidoMU'];
            const fp = r['funcionesPuesto'];
            
            $('#misionContenido').val(r['mision']);
            //const mp = r['matrizProcesos'];
            const months = r['months'];
            const pm = r['permission'];
            var trtd1 = `
              <thead>
                <tr style='background: #396da1;'>
                  <th>N°</th>
                  <th>Función</th>
                  <th><i class="fas fa-trash-alt"></i> Eliminar</th>
                  <th><i class="fas fa-save"></i> Guardar</th>
                </tr>
              </thead>
            `;
            var trtd2 = `
              <thead class="table-thead">
                <tr style='background: #396da1;'>
                  <th></th>
                  <th>N°</th>
                  <th>Función</th>
                </tr>
              </thead>
            `;
            var option1 = `<option value="-1"></option>`;

            if (fp != 0) {
              for (const b in fp) {
                let pr = fp[b].procedimientos;
                var procedure = ``;
                trtd1 += `
                  <tr id="tr${fp[b].idFuncionProcesoFP}" onclick="guardaIdFuncion(2,this,'classRATFuncion')" class="rowFuncion">
                    <td>${fp[b].idFuncionProcesoFP}</td>
                    <td contentEditable="true">${fp[b].descripcionFP}</td>
                    <td><button class="btn btn-danger" onclick="eliminarFP(this,event)"><i class="fas fa-trash-alt"></i> Eliminar</button></td>
                    <td><button class="btn btn-primary" onclick="guardarModificacionFP(this,event)"><i class="fas fa-save"></i> Guardar</button></td>
                  </tr>
                `;

                if (pr != 0) {
                  for (const c in pr) {
                    let st = pr[c].pasos;
                    var step = ``;
                    if (st != 0) {
                      for (const d in st) {
                        step += `
                          <div data-step="${st[d].idFuncionProceso}">
                            <label style="margin:0px;"><strong>${Number(d) + 1}</strong> - ${st[d].descripcionFP}</label>
                            <hr class="hr-step">
                          </div>
                        `;
                      }
                    }
                    else {
                      step = `---`;
                    }
                    procedure += `
                      <tr class="procedure${fp[b].idFuncionProcesoFP} ocultarObjeto" data-procedure="${pr[c].idFuncionProceso}">
                        <td>${Number(c) + 1}</td>
                        <td>${pr[c].descripcionFP}</td>
                        <td>${step}</td>
                      </tr>
                    `;
                  }
                }
                else {
                  procedure += `
                    <tr class="procedure${fp[b].idFuncionProcesoFP} ocultarObjeto">
                      <td></td>
                      <td>Vacío</td>
                      <td>---</td>
                    </tr>
                  `;
                }

                trtd2 += `
                  <tr id="function${fp[b].idFuncionProcesoFP}">
                    <td>
                      <button class="btn-function open-function" data-icon="1" value="${fp[b].idFuncionProcesoFP}"><i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i></button>
                    </td>
                    <td>${Number(b) + 1}</td>
                    <td>${fp[b].descripcionFP}</td>
                  </tr>
                  <tr class="procedure${fp[b].idFuncionProcesoFP} thead-procedure ocultarObjeto">
                    <td>N°</td>
                    <td>Procedimiento</td>
                    <td>Pasos</td>
                  </tr>
                  ${procedure}
                `;

                option1 += `
                  <option value="${fp[b].idFuncionProcesoFP}">${fp[b].descripcionFP}</option>
                `;
              }
            }
            else {
              trtd1 += `
                <tr>
                  <td colspan="4">
                    <center>
                      <b>No se encontraron registros.</b>
                    </center>
                  </td>
                </tr>`;
            }
            $('#tablaFunciones').html(trtd1);
            $('#tableFunctionsEmployment').html(trtd2);
            $('#selectCapturaFuncion').html(option1);
            $('#employmentMission').text(r['mision']);
            $('#P-Funciones').val("1");
            LoadingPuestos();
            //$('#selectCapturaMP').html(mp);
            //CargarContenidoMU();

            $('.open-function').click(function() {
              const id = this.value;
              openContainer(this);
              $('.procedure'+id).toggleClass('ocultarObjeto');
              console.log("Click a procedimiento con el id: "+id);
            })
        },
        error: (error) => {
          $('#SpinnerPuestos').html("");
          console.log(error);
          //swal("¡Uups!", "Hay problemas al intentar encontrar la información.", "error");
        }            
      })
    }
    else {
      formulario.submit();
    }
  }

  function enviarFormGenerales(clase,controlador){
    var direccion=<?php echo('"'.base_url().'"'); ?>;
    direccion=direccion+controlador;
    var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
    if (clase == "classImprimir"){
      formulario.target="_blank";
    }
    objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
    for(var i=0;i<cant;i++){
    var objeto=document.createElement('input'); 
        objeto.setAttribute('value',objetosForm[i].value);
        objeto.setAttribute('name',objetosForm[i].name);
        objeto.setAttribute('type','hidden');
        formulario.appendChild(objeto);    
    }
    document.body.appendChild(formulario);
    if (clase == "classImprimir") {
      formulario.submit();
    } else {
      var formData = new FormData(formulario);
      $.ajax({
        url: direccion,
        type: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: (load) => {
          /*$('#SpinnerVerPuestos').html(`
              <div class="container-spinner-content-upload">
                  <div class="cr-spinner spinner-border" role="status">
                      <span class="visually-hidden"></span>
                  </div>
                  <p class="cr-cargando" style="font-size:18px;">Guardando...</p>
              </div>
          `);
          $('#contenedor_capa').addClass('opacity-spinner');*/
        },
        success: (data) => {
            const r = JSON.parse(data);
            console.log(r);
            if (r['pestania'] == "divManual") {
              CargarContenidoMU();
              swal("¡Guardado!", "Cambios guardados con éxito.", "success");
            }
            else if (r['pestania'] == "divProcesos") {
              swal("¡Guardado!", "Cambios guardados con éxito.", "success");
            }
            //$('#SpinnerVerPuestos').html("");
            //$('#contenedor_capa').removeClass('opacity-spinner');
        },
        error: (error) => {
          //$('#SpinnerVerPuestos').html("");
            swal("¡Uups!", "Hay problemas al intentar encontrar la información.", "error");
        }            
      })
    }
  }

  function buscarFastFile(status) {
    manejoPestanias('divMatrizFastFile');
    const jobvalue = $("#buscarIdPuesto option:selected").val();
    const useParams = status;

    const params = {};
    params.id = parseInt(jobvalue);
    params.param = false;
    if(useParams != "false"){

      params.year = $("#fast-file-year").val();
      params.month = $("#fast-file-month").val();
      params.param = true;

      if(params.year == 0 || params.month == 0){
        swal("¡Espera!", "Selecciona una opción correcta.", "warning");
        return false;
      }

    }
    const ajax = $.ajax({
      type: "GET",
      url: `<?=base_url()?>fastFile/${params.month == "accumulated" ? `getAccumulated` : `getDashboard`}`, //getDashboard
      data: params, //{ id: parseInt(jobvalue) }, 
      beforeSend: (load) => {
        $('#SpinnerVerPuestos').html(`
            <div class="container-spinner-content-upload">
                <div class="cr-spinner spinner-border" role="status">
                    <span class="visually-hidden"></span>
                </div>
                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
            </div>
        `);
        $('#contenedor_capa').addClass('opacity-spinner');
      },
      error: (error, errorMessage, code) => {
        console.log(errorMessage);
        $('#SpinnerVerPuestos').html("");
        $('#contenedor_capa').removeClass('opacity-spinner');
      },
      success: (data) => {

        const response = JSON.parse(data);
        const dataParse = response.data;
        console.log(response);

        if(!dataParse.empty){
          var nombremeses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
          const fecha = new Date(dataParse.fechaIngreso);
          const ingreso = fecha.getDate() + "/" + nombremeses[fecha.getMonth()] + "/" + fecha.getFullYear();
          $(".name-complete").html(`Nombre:&nbsp;<b>${dataParse.persona[0].name_complete}</b>`);
          $(".date-of-admission").html(`Fecha de Ingreso:&nbsp;<b>${ingreso}</b>`);
          $(".name-job").html(`Puesto:&nbsp;<b>${dataParse.cargo[0].personaPuesto.toUpperCase()}</b>`);
          $(".user-email").html(`Correo:&nbsp;<b>${dataParse.persona[0].email.toUpperCase()}</b>`);
          $(".profile-photo").prop("src", dataParse.fotoUser);
          $(".view-requeriments-profile").attr("onclick", `viewPerfilApego(${dataParse.idPersona}, "${dataParse.cargo[0].personaPuesto}")`)

          if(params.month == "accumulated"){
            getGeneralDashboard(response, params.year);
          } else{
            getSpecifiedDashboard(response);
          }
        }
        $('#SpinnerVerPuestos').html("");
        $('#contenedor_capa').removeClass('opacity-spinner');
        $('#P-VerPuesto').val("1");
        LoadingPuestos();
      }
    });
  }

  function AllRepositorio() { //Modificado [Suemy][2024-05-13]
    const parameter = $("#buscarIdPuesto option:selected").val();

    const ajax = $.ajax({
      type: "GET",
      url: "<?=base_url()?>fastFile/getAllRepositories",
      data: {
        job: parameter
      },
      error: (error) => {

      },
      success: (data) => {
        const response = JSON.parse(data);
        //console.log(response);
        var ul = ``;
        var div = ``;
        ul = response.reduce((acc, curr) => {
          acc += `<li role="presentation" class="${curr.active}"><a href="#${curr.id}" aria-controls="${curr.id}" role="tab" data-toggle="tab">${curr.label}</a></li>`;
          return acc;
        } , ``);
        div =  response.reduce((acc, curr) => {
          acc += `<div role="tabpanel" class="tab-pane ${curr.active} div-${curr.id}" id="${curr.id}">${curr.label}</div>`;
          return acc;
        } , ``);
        

        //Agregamos la parte de los nuevos compoenentes
        ul+=`<li role="presentation" class=""><a href="#PIP" id="click_PIP" aria-controls="PIP" role="tab" data-toggle="tab" onclick="seguimientoPIP()">Seguimiento PIP</a></li>`;

        div+=`<div role="tabpanel" class="tab-pane div-PIP" id="PIP">
        </div>`;

        $(".tabpanel-documents").html(`<ul class="nav nav-tabs" role="tablist">${ul}</ul> <div class="tab-content">${div}</div>`);

        //-------------------
        if (response != 0) {
        $(".div-historial").jstree({
          core : {
            check_callback: true,
            data : response[1].content
          },
          types: {
            "#": {
              "icon": "glyphicon glyphicon-folder-open"
            },
            "root": {
              "icon" : "glyphicon glyphicon-folder-open"
            },
            "file": {
              "icon": "glyphicon glyphicon-file"
            },
            "default": {
            }
          },
          plugins : [ "types" ],
        }).bind("select_node.jstree", function(event, node){

          if(node.node.type == "file" && node.node.a_attr.showContent){

            $(".details-content").html(`
              <div class="row">
                <div class="col-md-8">
                  <h5 style="text-align:center;font-size:16px;"><strong>Detalles</strong></h5>
                  <div class="row mb-4">
                    <div class="col-md-4"><b>Nombre del archivo</b></div>
                    <div class="col-md-8"><p class="text-dark">${node.node.a_attr.docName}</p></div>
                  </div>
                  <hr style="border-top: 1px solid #e5e5e5;">
                  <div class="row mb-4">
                    <div class="col-md-12"><b>Ruta del archivo</b></div>
                    <div class="col-md-12"><p class="text-dark">${node.node.a_attr.pathfile}</p></div>
                  </div>
                  <hr style="border-top: 1px solid #e5e5e5;">
                  <div class="row mb-4">
                    <div class="col-md-4"><b>Fecha de subida</b></div>
                    <div class="col-md-8"><p class="text-dark">${node.node.a_attr.dateCreate}</p></div>
                  </div>
                </div>
                <div class="col-md-4" style="border-left: 1px #ABB2B9 solid">
                  <h5 style="text-align:center;font-size:16px;"><strong>Opciones</strong></h5>
                  <div class="col-md-12"><button class="btn btn-primary btn-sm mb-2 download-file" data-href="${node.node.a_attr.href}" download><i class="fas fa-download"></i> Descargar fichero</button></div>
                  <!--<div class="col-md-12"><button class="btn btn-danger btn-sm remove-file-tree" data-id="${node.node.a_attr.idDoc}" data-node="${node.node.a_attr.id}">Eliminar fichero</button></div>-->
                </div>
              </div>
            `);

            $("#modal-doc-details").modal({
              show: true,
              keyboard: false,
              backdrop: false
            })
          }
        });
        //-------------------
        $('.div-repositorio').jstree({
          core : {
            check_callback: true,
            data : response[0].content
          },
          types: {
            "#": {"icon": "glyphicon glyphicon-folder-open"},
            "root": {"icon" : "glyphicon glyphicon-folder-open"},
            "file": {"icon": "glyphicon glyphicon-file"},
            "default": {
            }
          },
          checkbox: {"keep_selected_style" : false},
          plugins : [ "types" ],
        })
        .bind("select_node.jstree", function(event, node){
          if(node.node.type == "file" && node.node.a_attr.showContent){

            $(".details-content").html(`
              <div class="row">
                <div class="col-md-8">
                  <h5><b>Detalles</b></h5>
                  <div class="row mb-4">
                    <div class="col-md-4"><b>Nombre del archivo</b></div>
                    <div class="col-md-8"><p class="text-dark">${node.node.a_attr.docName}</p></div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-12"><b>Ruta del archivo</b></div>
                    <div class="col-md-12"><p class="text-dark">${node.node.a_attr.pathfile}</p></div>
                  </div>
                  <div class="row mb-4">
                    <div class="col-md-4"><b>Fecha de subida</b></div>
                    <div class="col-md-8"><p class="text-dark">${node.node.a_attr.dateCreate}</p></div>
                  </div>
                </div>
                <div class="col-md-4" style="border-left: 1px #ABB2B9 solid">
                  <h5><b>Opciones</b></h5>
                  <div class="col-md-12"><button class="btn btn-primary btn-sm mb-2 download-file" data-href="${node.node.a_attr.href}">Descargar fichero</button></div>
                  <div class="col-md-12"><button class="btn btn-danger btn-sm remove-file-tree" data-id="${node.node.a_attr.idDoc}" data-node="${node.node.a_attr.id}">Eliminar fichero</button></div>
                </div>
              </div>
            `);

            $("#modal-doc-details").modal({
              show: true,
              keyboard: false,
              backdrop: false
            })
          }
        });
        }
        //-------------------
      }
    });
  }

  function seguimientoPIP() {
    var puesto=$("#buscarIdPuesto option:selected").val();
    const ajax = $.ajax({
        type: "GET",
        url: "<?=base_url()?>fastFile/getviewPIP",
        data: {
          puesto: puesto
        },
        error: (error) => {
          console.log(error.responseText);
        },
        success: (data) => {
          $('#PIP').html(data);
        }
    });
    
    //alert(puesto)
  }

  function setVisorPdf(url,name,file){
    $('#NameDocument').text(name);
    $('#UrlDocument').text("("+file+")");
    //document.getElementById('visor').innerHTML='<iframe src='+url+' style="width: 100%;height: 490px;border-style: none;"></iframe>';
    const iframe = document.getElementById('visor');
    let ref = url.slice((url.lastIndexOf(".") - 1 >>> 0) + 2);
    ref = ref.toUpperCase();
    if(ref=='XLS' || ref=='XLSX' || ref=='DOC' || ref=='DOCX' || ref=='XLSM' || ref=='PPTX') {
      iframe.innerHTML = `<iframe src='https://view.officeapps.live.com/op/embed.aspx?src=${url}' width='100%' height='100%' frameborder='0'></iframe>`;
    }
    else if(ref=='XML' || ref=='TXT' || ref=='JPG' || ref=='PNG' || ref=='JPEG') {
      iframe.innerHTML = '<iframe src='+url+'  class="container-xml"></iframe>';
    }
    else if(ref=='PDF') {
      iframe.innerHTML = '<iframe src='+url+' style="width: 100%;border-style: none;height: -webkit-fill-available;"></iframe>';
    }
    else if (ref=='MP4') {
      iframe.innerHTML = '<video controls="" autoplay="" name="media" style="width: -webkit-fill-available;height: -webkit-fill-available;"><source src="'+url+'" type="video/mp4"></video>';
    }

    $("#visor_pdf").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });
  }

  //fastFile - view
  //fastFile- controlador
  function misionGuardar(datos='')
  {
    if(datos=='')
    {   let params='';
        params='&idPuesto='+document.getElementById('idPuesto').value;
               params+='&mision='+document.getElementById('misionContenido').value;
          controlador="capitalHumano/misionPuestoGuardar/?";          
           peticionAJAX(controlador,params,'misionGuardar'); 
    }
   else
   {
    if(datos.success)
    {
      alert('GUARDADO CON EXITO')
    }
   }
  }
</script>
<!---------->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script><script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<!-- SELECT pr.idPersona, us.name_complete as nombre, us.email, us.last_login as ultimo_inicio_sesion, if (us.activated = 1,"Activo","De Baja") AS estatus, pp.nombrePersonaPermiso AS nombre_permiso, pp.descripcionPermiso AS descripcion 
FROM `personapermisorelacion` pr 
INNER JOIN `personapermiso` pp ON pp.idPersonaPermiso = pr.idPersonaPermiso 
INNER JOIN `users` us ON us.idPersona = pr.idPersona WHERE pr.idPersonaPermiso = 34 -->
