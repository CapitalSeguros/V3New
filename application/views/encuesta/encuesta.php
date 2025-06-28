<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
<style type="text/css">
  body {
    font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  }
  /*ID*/
    #BtnMenuEncuesta.active {margin-left: -125px;}
    #PanelBotonesEncuesta td {padding: 5px 10px;}
    #numevaluados, #numevaluadosaseguradora, #numevaluadosasesoria, #numevaluadosgestor {
      margin: 5px 20px;
      background: #f3ffef;
      box-shadow: 0px 1px 3px #cfcfcf;
    }
    #clientenuevo{background:#172d59; /*#386CD3*/}
    #siniestros{background:#1a1a1a; /*black*/}
    #nameTestSelect {text-align: center;margin-bottom: 10px;}
    #bodyTableMissing > tr > td {vertical-align: middle;border-top: 1px solid #ffffff;}
    #titleTestSelect, #personsMissingTest {color: #472380;}
    #titleTestSelectUser {text-align: center;margin-bottom: 20px;}
    #tab_capa.nav-tabs {font-size: 14px;width: 100%;}
    #tab_capa.nav-tabs > li {margin-bottom: -1px;}
    #tab_capa.nav-tabs>li>a.active, #tab_capa.nav-tabs>li>a.active:focus, #tab_capa.nav-tabs>li>a.active:hover {
      background-color: #5f3c97;
    }
    #tab_capa.nav-tabs>li>a {line-height: 1.42857143;border: 1px solid transparent;color: white; /*#555*/}
    #tab_capa.nav-tabs>li>a:hover {background:#472380;color: white;}
    #contenedor_capa.tab-content {font-size: 13px;border: 1px solid #dee2e6;border-top: transparent;position: relative;box-shadow: 0px 0px 0px 0px rgba(0,0,0,0.10);}
    #contTableReportTestUser {/*height: 450px;*//*background: #f7f7f7;*//*padding: 0px;*/}
    #contTableReportTestUser table tr:nth-child(2) > th > div.th-inner {max-width: 200px;}
    #selectTestReport {transition: all 2s;}
    #countResult {font-size: 16px;color: #3d3d3d;}
    #countFilterResult {font-weight: 500;}
    #contTableResultTest table tr:nth-child(2) > th > div.th-inner {max-width: 200px;}
    #contTableResultTest .bootstrap-table .fixed-table-container .fixed-table-body {max-height: 280px;}
  /*Spinners*/
    .container-spinner-content-loading {
        z-index: 1;
    }
  /*Containers*/
    .panel_botones{background-color: #fff;min-width: 125px;max-width: 125px;float: left;padding: 5px;height: auto;border-right: 1px solid #e1e1e1;transition: all 0.3s;}
    .btncierra{display: flex;justify-content: flex-end;padding:10px 5px 5px;/*margin-right: 20px; */}
    .listaInvitado{/*width: 100%;*/height:150px;overflow: auto;background: #f5f5f5;border: 1px solid #dbdbdb;border-radius: 5px;margin: 8px;}
    .contenedor-modalEncuestas{background-color: rgb(221, 241, 241);align-items: center;width: 700px;margin-left: auto;margin-right:auto;margin-top: 100px;height:550px;overflow: scroll;}
    .listaInvitado ul li{color:black;padding:5px;}
    .encuestasActivas{display : flex;justify-content: space-between;margin:0px 5px;}
    .personas{padding :10px;color :green;}
    .encabezanps{color :#44D338;padding-right:12px;}
    .siniestros{padding :2px;color :white;text-align:center;}
    .telefono, .celular, .correo {/*display: flex;*/align-items: center;}
    .container-graphics {width: 100%;}
    .segment-count-user {border: 1px solid #dbdbdb;border-radius: 5px;padding: 10px;}
    .panel {box-shadow: 0px 1px 5px 0px rgb(0 0 0 / 31%);}
    .container-table-alt {max-width: -webkit-fill-available;}
    .modal-body-table {height: 320px;}
  /*Modals*/
    .modalEncuestas{
      background-color: rgba(0,0,0,.8);
      position:fixed;
      display:none;
      height: 100vh;
      width: 100vw;
      transition: all .5s;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      z-index: 1040;
      overflow: hidden;
      outline: 0;
    }
    .modal-contenidoGenerico{background-color:none;width:90%;height:100%;left:20%;margin:5% auto;position:relative;z-index:1000}
    .emails-employees-modal {background-color: rgb(0 0 0 / 17%);}
  /*Botons*/
    .btn-primary{font-size: 14px;}
    .btn-close-modalEncuestas {background: #286090;color: white;font-size: 16px;border: 1px solid #286090;border-radius: 5px;}
    .nps{background-color:#c91a1a;color:white;padding:10px 10px;border:none;border-radius:5px;}
    .verdad{background-color:#b5169b;color:white;padding:10px 10px;border:none;border-radius:5px;}
    .uno{background-color:#389300;color:white;padding:10px 10px;border:none;border-radius:5px;}
    .btnBotonera {width: 100px;height: 76px;border: 1px solid #d4deff;border-radius: 5px;margin-bottom: 5px;padding: 5px;background: #f2f5ff;transition: all 0.3s;}
    .btnBotoneraActiva {background-color: #7474c3;color:white;transition: all 0.3s;}
    .telefono a, .celular a, .correo a{padding: 5px;font-size:30px;transition: all 0.5s;color: #006f81; /*#1C2C80;*/}
    .btnTest {width: 100%;text-overflow: ellipsis;white-space: normal;text-align: start;background: #f9fff2;border: 1px solid #e9f6da;color: #4e4e4e;}
    .nuevo.disabled,
    .nuevo[disabled],
    .nuevo.disabled > i:hover,
    .nuevo[disabled] > i:hover,
    .nuevo.disabled:focus,
    .nuevo[disabled]:focus,
    .nuevo.disabled.focus,
    .nuevo[disabled].focus,
    .nuevo.disabled:active,
    .nuevo[disabled]:active,
    .nuevo.disabled.active,
    .nuevo[disabled].active {
        color: #82a7ad; /*#82a7ad*/
        -webkit-transform:scale(1);
        cursor: unset;
    }
    button.btnTestActive {background-color: #97b376;color:white;transition: all 0.3s;}
    .boton:hover {background: #f0f2ff;border-color: #bec3e1;transition: 0.3s;color: #1d325a;}
    .btn-close-modalEncuestas:hover {background: #2f73ad; border-color: #2f73ad;}
    .btnBotonera:hover, .btnTest:hover {background: #dfe4f3;border-color: #dfe4f3;color: #472380;}
    .btn-modalEnc:hover {background: #2f73ad; border-color: #2f73ad;color: white;cursor: pointer;}
    .telefono i:hover, .celular i:hover, .correo i:hover {cursor: pointer;/*filter:gray;-webkit-filter:grayScale(2);*/-webkit-transform:scale(1.3);-webkit-transition:all .5s ease-in-out;color: #0f4b7e;}
    .btnTest:hover {background: #e3efd6;border-color: #e3efd6;color: #4e4e4e;}
    .btnBotonera:active, .btnTest:active {outline: 0;}
    .btnBotonera:focus, .btnTest:focus {outline: 0;}
  /*Tables*/
    .table-striped>tbody>tr:nth-of-type(odd).testON, .testON {background-color: #ffdfc4;/*#C4FFD1;/*#ffdfc4*/}
    tbody > tr > td > button.btn-primary, tbody > tr > td > a.btn-primary {font-size: 13px;}
    .tr-section {text-align: center;background: #f1f1f1;color: black;font-size: 13px;}
  /*Texts*/
    .numero{color :red;padding-right:12px;}
    .number-siniestro {color: #ffa700;padding-right: 12px;}
    .title-result {margin-top: 0px;margin-bottom: 0px;color:white;font-size: 16px;}
    .textNumberIcon {top: -5px;position: relative;}
    .textResponse {color: black;margin: 0px 5px;}
    .badge {border-radius: 4px;}
    .text-bdg-primary {background: #28469f;}
    .text-bdg-secondary {background: #1ab98e;color: black;}
    .text-bdg-success {background: #248d29;}
    .text-bdg-warning {background: #ffc107;color: black;}
    .text-bdg-danger {background: #a91a1a;}
    .text-bdg-brown {background: #9b351e;}
    .text-bdg-green {background: #007349;}
    .text-bdg-vine {background: #730b33;}
    .title-graphic {text-align: center;margin-bottom: 20px;}
    .subtitleModal {text-align: center;color: black;font-size: 15px;}
    .title-table {text-align: center;}
    .form-check-label {font-size: 14px;color: #3d3d3d;margin-left: 3px;}
  /*Icons*/
    .icon-circle-check {font-size: 25px;color: green;}
    .icon-circle-close {font-size: 25px;color: red;}
    .icon-circle-send {font-size: 15px;color: green;}
    .icon-circle-no-send {font-size: 15px;color: orange;}
    .icon-angle-danger {color: #9b0000;}
    .icon-angle-success {color: #007a00;}
    .icon-angle-warning {color: #e19200;}
    .icon-bdg-brown {color: #9b351e;}
    .icon-bdg-green {color: #007349;}
    .icon-bdg-vine {color: #730b33;}
  /*Others*/
    .liSeleccionado{background-color: green;color: white} 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .botonCierre{background-color: red;color:white;}
    .contenidoModal{border: solid; color: black; background-color: white;width: 50%;height: 50%}
    .infoModal{position: relative; left: 0%;top: 30%}
    .labelModal{color: red;background-color: white; font-size: 18px;}
    .botonCancelar{border-left: 5px;left: 40%;position: relative;}
    .buttonMenu{width: 100%}
    .subContenido{display: none}
    .no-view-tr {display: none;}
    .border-r-modal-body-bottom {border-radius: 0px 0px 5px 5px;}
    .pd-side-alt {padding-left: 15px;padding-right: 15px;}
  /*Media Query*/
      @media (min-width: 1280px) {
          .segment-options { max-width: 55%; }
          .container-table-bootstrap { max-width: 1160px; } /*1031*/
      }
      @media (min-width: 992px) {
          .segment-options { max-width: 40%; }
          .modal-lg { height: 90%; width: 1000px; }
          /*.modal-body-table { height: 450px; }*/
      }
      @media (min-width: 768px) {
          .segment-options { max-width: 30%; }
          .modal-dialog { margin: 20px auto; }
      }
</style>
<div class="contenido" id="ContentEncuesta">
  <?php $this->load->view("encuesta/opcionesEncuesta");?>
  <div class="contenidoPrincipal" id="ContainerContent">
    <div>
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12 column-flex-center-start">
            <h3 class="title-section-module">
              <button class="btn-burguer" id="BtnMenuBurguer" title="Menú">
                <i class="fa fa-bars" aria-hidden="true"></i></button>
              <span id="TitleSectionTest">Reporte de Encuestas</span>
            </h3>
          </div>
        </div>
        <hr/>
      </section>
    </div>

    <div id="divReportes" class="divContenidoEncuesta verObjeto">
      <ul class="nav nav-tabs" id="tab_capa" role="tablist">
        <li class="nav-item"><!--onclick="manejoPestanias('divMatrizFastFile')"-->
          <a class="nav-link active" data-toggle="tab" id="tab_table" role="tab" aria-selected="true" href="#tabTabla">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Resultados</a>
        </li>
        <?php //if($permission==1){?>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" id="tab_statistics" role="tab" aria-selected="true" href="#tabEstadictica">
            <i class="fa fa-check-square-o" aria-hidden="true"></i> Estadísticas</a>
        </li>
        <?  //}  ?>
      </ul>
      <div class="tab-content" id="contenedor_capa" style="margin-bottom: 80px;">
        <!-- Tablas -->
        <div class="tab-pane active" id="tabTabla" role="tabpanel" aria-labeledby="tab_table">
          <div class="panel-body" style="padding: 0px;">
            <div class="col-md-12" style="margin-bottom: 25px;">
              <h5 class="titleSection">Resultados de Búsqueda <span id="countResult"></span></h5>
              <hr class="title-hr" id="ResultadosBusqueda">
              <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side" style="width: 40%;">
                  <label class="form-check-label">Encuesta:</label>
                  <select class="form-control width-ajust" id="encuestas"><?=$optionT?></select>
                </div>
                <div class="pd-side">
                  <label class="form-check-label">Tipo Persona:</label>
                  <select id="empleados" class="form-control width-ajust" style="margin-right: 8px;">
                    <option value="1">Todos</option>
                    <option value="2">Colaboradores</option>
                    <option value="3">Agentes</option>
                    <option value="4">Clientes</option>
                  </select>
                </div>
                <div class="pd-side">
                  <input type="month" class="form-control width-ajust" id="mesReporte" value="<?=date('Y-m')?>" style="margin-right: 5px;">
                </div>
                <div class="pd-side">
                    <button id="button" class="btn btn-primary" style="margin-right: 5px;">Generar</button>
                </div>
              </div>
              <div class="col-md-12 column-flex-center-start pd-items-table">
                <div class="col-md-6 column-flex-center-start pd-left">
                  <div class="width-ajust" style="padding-right: 5px;">
                    <button class="btn btn-export-report" id="btnExport" onclick="exportarExcel('1')" disabled>
                      <i class="fas fa-file-excel"></i> Exportar</button>
                  </div>
                  <div class="width-ajust" style="padding-left: 5px;border-left: 1px solid #dbdbdb;">
                    <a class="btn btn-export-report" href="<?=base_url()?>VerEncuesta/excel?valor=COLABORADORES" target="_blank" id="btnExportReport" title="Usuarios Faltantes" style="margin-right:10px;">
                    <i class="fas fa-file-excel"></i> Reporte EXCEL</a>
                    <button class="btn btn-primary activa">Encuestas Activas</button>
                  </div>
                </div>
                <div class="col-md-6 column-flex-center-end pd-right">
                  <!-- <span class="textForm mg-right" id="countFilterResult"></span> -->
                  <div class="column-flex-center-end pd-left pd-right input-group" style="width: 65%;">
                    <input class="form-control search-input" placeholder="Filtrar" id="filterTable">
                    <div class="input-group-append">
                      <button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTable')"><i class="fas fa-eraser"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 container-table-alt">
                <table class="table table-striped" id='tableReport' style="height: 100%;margin: 0px;">
                  <thead class="table-thead">
                   <tr class="table-tr">
                      <th>Encuesta</th>
                      <th>Usuario</th>
                      <th>Tipo</th>
                      <th>Calificación</th>
                      <th>Respuestas</th>
                   </tr>
                  </thead>
                  <tbody id="bodyTableReport"></tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 25px;">
              <h5 class="titleSection">Resultados Generales</h5>
              <hr class="title-hr" id="ResultadosGenerales">
              <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side">
                  <label class="form-check-label">Tipo Encuesta:</label>
                  <select class="form-control width-ajust" id="testResult">
                    <option value="todos">Todos</option>
                    <option value="1" selected>NPS</option>
                    <option value="2">Numérico</option>
                    <option value="3">Verdadero/Falso</option>
                  </select>
                </div>
                <div class="pd-side">
                  <label class="form-check-label">Mes:</label>
                  <select class="form-control width-ajust" id="monthResult">
                    <option value="todos" selected>TODOS</option>
                    <?=$optionM?>
                  </select>
                </div>
                <div class="pd-side">
                  <label class="form-check-label">Año:</label>
                  <select class="form-control width-ajust" id="yearResult"><?=$optionY?></select>
                </div>
                <div class="pd-side">
                    <button class="btn btn-primary" onclick="getInfoTestComplete()">Generar</button>
                </div>
              </div>
              <div class="col-md-12 column-flex-center-start pd-items-table">
                <div class="col-md-6 column-flex-center-start pd-left">
                  <button class="btn btn-export-report" id="btnExportGeneral" onclick="exportarExcel('2')" disabled>
                      <i class="fas fa-file-excel"></i> Exportar</button>
                </div>
                <div class="col-md-6 column-flex-center-end pd-right input-group">
                  <input class="form-control search-input" placeholder="Filtrar" id="filterTableGeneral" style="max-width: 60%;">
                  <div class="input-group-append">
                    <button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableGeneral')"><i class="fas fa-eraser"></i></button>
                  </div>
                </div>
              </div>
              <div class="col-md-12 container-table-alt">
                <table class="table table-striped" id='tableReportTestComplete' style="height: 100%;margin: 0px;">
                  <thead class="table-thead">
                    <tr class="table-tr"><th class="title-table" colspan="11" id="titleResult">Todo</th></tr>
                    <tr class="table-tr">
                      <th>ID Encuesta</th>
                      <th>Encuesta</th>
                      <th>Asignadas</th>
                      <th>Contestadas</th>
                      <th>Faltantes</th>
                      <th>Promedio Resuelto</th>
                      <th>Promedio Faltante</th>
                      <th>Promedio Calificación</th>
                      <th>Personas Asignadas</th>
                      <th>Respuestas</th>
                    </tr>
                  </thead>
                  <tbody id="bodyTableReportTestComplete"></tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12" style="margin-bottom: 25px;">
              <h5 class="titleSection">Exportar Resultados</h5>
              <hr class="title-hr">
              <div class="col-md-12 column-flex-center-start" style="margin-bottom: 5px;">
                <label class="subTitleSection">Selecione la Encuesta:</label> 
                <select class="form-control width-ajust" id="selectTestReport" disabled>
                  <option value="0">SELECCIONAR</option>
                </select>
              </div>
              <div class="col-md-12 column-flex-center-start" style="margin-bottom: 5px;">
                <label class="subTitleSection">Buscar por:</label>
                <div class="form-check column-flex-center-center">
                  <input type="radio" class="form-check-input" name="radio-search" title="Mes" value="1" checked>
                  <label class="form-check-label">Mes</label>
                </div>
                <div class="form-check column-flex-center-center">
                  <input type="radio" class="form-check-input" name="radio-search" title="Calificación" value="2">
                  <label class="form-check-label">Calificación</label>
                </div>
                <div class="form-check column-flex-center-center">
                  <input type="radio" class="form-check-input" name="radio-search" title="Usuario" value="3">
                  <label class="form-check-label">Usuario</label>
                </div>
              </div>
              <div class="col-md-12 column-flex-bottom pd-items-table">
                <div class="pd-side-alt brd-right" style="padding-left: 0px;">
                  <label class="subTitleSection">Mes:</label>
                  <input type="month" class="form-control width-ajust brd-right" id="selectMonthReport" value="<?=date('Y-m')?>">
                </div>
                <div class="pd-side-alt brd-right">
                  <label class="subTitleSection">Calificación menor a:</label>
                  <input type="number" class="form-control" id="selectPercentage" style="max-width: 132px;" disabled>
                </div>
                <div class="pd-side-alt width-ajust">
                  <label class="subTitleSection">Selecione el usuario:</label>
                  <select class="form-control" id="selectUserReport" disabled><option value="0">SELECCIONAR</option></select>
                </div>
              </div>
              <div class="col-md-12 column-flex-bottom pd-items-table pd-left pd-right">
                <div class="col-md-6 column-flex-center-start">
                  <button class="btn btn-primary" id="btnSearchAnswers" disabled>Generar</button>
                </div>
                <div class="col-md-6 column-flex-center-end pd-items-table">
                  <span class="label label-wine" id="typeExportReport" style="font-size: 14px;font-weight: 500;"></span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="col-md-12 container-table-bootstrap" id="contTableReportTestUser" style="height: 420px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Estadísticas -->
        <div class="tab-pane" id="tabEstadictica" role="tabpanel" aria-labeledby="tab_statistics">
          <div class="panel-body" style="padding: 0px;">
            <div class="col-md-12" style="margin-bottom: 10px;">
              <div class="container-graphics column-flex-center" id="graphicTestGeneral"></div>
            </div>
            <div class="col-md-12"><hr class="subtitle-hr"></div>
            <div class="col-md-12" style="margin-bottom: 10px;">
              <div class="container-graphics column-flex-center" id="graphicTestReady"></div>
            </div>
            <div class="col-md-12"><hr class="subtitle-hr"></div>
            <div class="col-md-12" style="margin-bottom: 10px;">
              <div class="container-graphics column-flex-center" id="graphicTestMissing"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="divContenidoEncuesta ocultarObjeto" id="divAltas">
      <? $this->load->view('encuesta/encabezadoencuesta');?>
    </div>
    <div class="divContenidoEncuesta ocultarObjeto" id="divAsignar">
      <? $this->load->view('asigna/asigna');?>
    </div>
    <div class="divContenidoEncuesta ocultarObjeto" id="divSinContestar">
      <? $this->load->view('encuesta/VerEncuesta'); ?>
    </div>
    <div class="divContenidoEncuesta ocultarObjeto" id="divPorTelefono">
      <? $this->load->view('encuesta/encuestaPorTelefono');?>
    </div>
    <div class="col-md-12" id="ContainerExportTables" style="display: none;">
      <div class="col-md-12" style="height: 450px;overflow: auto;">
        <table class="table table-striped" id='tableReport2' style="height: 100%;margin: 0px;">
          <thead class="table-thead">
           <tr class="tr-style">
              <th>Encuesta</th>
              <th>Usuario</th>
              <th>Tipo</th>
              <th>Calificacion</th>
           </tr>
          </thead>
          <tbody id="bodyTableReport2"></tbody>
        </table>
      </div>
      <div class="col-md-12" style="height: 450px;overflow: auto;">
        <table class="table table-striped" id='tableReportTestComplete2' style="height: 100%;margin: 0px;">
          <thead class="table-thead">
           <tr class="tr-style">
              <th>ID Encuesta</th>
              <th>Encuesta</th>
              <th>Asignadas</th>
              <th>Contestadas</th>
              <th>Faltantes</th>
              <th>Promedio Resuelto</th>
              <th>Promedio Faltante</th>
              <th>Promedio Calificacion</th>
           </tr>
          </thead>
          <tbody id="bodyTableReportTestComplete2"></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- ------------------ Modals ---------------------- -->
<!--Modal para Fecha de Entrega de  tareas-->
  <div class="modalEncuestas" id='modalEncuestas'>      
    <div class="bodymodal">   
      <div class="contenedor-modalEncuestas">       
        <div class="btncierra">
          <button class="btn btn-close-modalEncuestas" onclick="cierramodalEncuestas()">
            <i class="fas fa-times"></i></button>            
        </div>
        <hr class="title-hr">
        <h2 align="center" style="margin-bottom: 20px;">Encuestas Activas</h2>
        <div class="listaInvitado"><ul id="ullistaEcuestas"></ul></div>
        <div id= "graficaCorporativa"></div>
        <div id= "numevaluados"></div>
        <div id= "graficaAseguradora"></div>
        <div id= "numevaluadosaseguradora"></div>
        <div id= "graficaAsesoria"></div>
        <div id= "numevaluadosasesoria"></div>
        <div id= "graficaGestor"></div>
        <div id= "numevaluadosgestor"></div>
        <div id= "siniestros"></div>
        <div id= "clientenuevo"></div>
        <div id="detractoresDiv"></div>
      </div>
    </div>  
  </div>

<!-- Modal Respuestas -->
<div class="modal fade answer-employees-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Se puede usar el modal para otra información pero solo si se desocupa este espacio -->
      <div class="modal-header column-select">
        <h4 class="title-result">Respuestas</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <h4 class="titleSection" id="titleTestSelectUser"></h4>
        <h5 class="subTitleSection" style="text-align: center;margin-bottom: 20px;">
          <strong id="textNameUser"></strong>
        </h5>
        <div class="col-md-12" style="height: 300px;overflow: auto;">
          <table class="table table-striped" id="tableAnswersUser" style="height: 100%;margin: 0px;">
            <thead class="table-thead">
              <tr style="background: #286090;">
                <th>Pregunta</th>
                <th>Respuesta del Encuestado</th>
                <th>Respuesta Correcta</th>
                <th>Puntaje</th>
              </tr>
            </thead>
            <tbody id="bodyTableAnswersUser"></tbody>
            <tfoot class="table-tfoot" id="tfootTableAnswersUser"></tfoot>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Empleados -->
<div class="modal fade employees-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Usuarios Asignados</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body border-r-modal-body-bottom" style="background: #f9f9f9;">
        <h4 id="titleTestSelection" style="text-align: center;font-size: 16px;"></h4>
        <div class="col-md-12 segment-count-user">
          <div class="col-md-6 pd-left pd-right" style="border-right: 1px solid #dbdbdb;">
            <h4 class="subtitleModal mg-top-cero">Encuestas Resueltas</h4>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Colaboradores: </label><strong id="countRCol"></strong>
            </div>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Agentes: </label><strong id="countRAgn"></strong>
            </div>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Clientes: </label><strong id="countRCli"></strong>
            </div>
          </div>
          <div class="col-md-6 pd-left pd-right">
            <h4 class="subtitleModal mg-top-cero">Encuestas Faltantes</h4>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Colaboradores: </label><strong id="countFCol"></strong>
            </div>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Agentes: </label><strong id="countFAgn"></strong>
            </div>
            <div class="col-md-4 column-grid-center">
              <label class="subTitleSection">Clientes: </label><strong id="countFCli"></strong>
            </div>
          </div>
        </div>
        <div class="col-md-12"><hr class="subtitle-hr"></div>
        <div class="col-md-12 column-flex-center-center" style="margin-bottom: 10px;color: #3d3d3d;">
          <div class="col-md-4" style="max-width: max-content;padding-left: 0px;">
              <i class="fas fa-circle icon-bdg-brown"></i>
              <span class="title-item-consult">Colaborador</span>
              <strong><span id="contCol"></span></strong>
          </div>
          <div class="col-md-4" style="max-width: max-content;padding-left: 0px;">
              <i class="fas fa-circle icon-bdg-green"></i>
              <span class="title-item-consult">Agente</span>
              <strong><span id="contAgn"></span></strong>
          </div>
          <div class="col-md-4" style="max-width: max-content;padding-left: 0px;">
              <i class="fas fa-circle icon-bdg-vine"></i>
              <span class="title-item-consult">Cliente</span>
              <strong><span id="contCli"></span></strong>
          </div>
        </div>
        <div class="col-md-12 pd-left pd-right modal-body-table" style="overflow: auto;">
          <table class="table table-striped" id="tableSelectionTest">
            <thead class="table-thead">
              <tr style="background: #286090;">
                <th>Nombre Completo</th>
                <th>Tipo</th>
                <th>Resuelto</th>
                <th>Calificación</th>
              </tr>
            </thead>
            <tbody id="bodyTableSelectionTest"></tbody>
          </table>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div> -->
    </div>
  </div>
</div>
<!-- Modal Resultados -->
<div class="modal fade response-test-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Resultados y Respuestas </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body border-r-modal-body-bottom" style="background: #f9f9f9;">
        <h4 id="titleTestSelectionResponse" style="text-align: center;font-size: 16px;"></h4>
        <div class="col-md-12 pd-left pd-right container-table-bootstrap" id="contTableResultTest" style="border:0px;height: 420px;"></div>
      </div>
      <!-- <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div> -->
    </div>
  </div>
</div>

<?php $this->load->view('footers/footer'); ?>
<!-- <script src="https://code.jquery.com/jquery-3.2.1.js"></script> -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<!-- <script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script type="text/javascript">

  //----------------------------------- FUNCIONES NUEVAS ---------------------------------------
  $(document).ready(function() {
    //controllers: encuesta, pregunta, asigna, VerEncuesta
    //views: opcionesEncuesta, encuesta, encabezadoencuesta, asigna, VerEncuesta, encuestaPorTelefono
    //models: verencuestamodel, preguntamodel
    //permission: encuesta, encabezadoencuesta, asigna, encuestaPorTelefono
    getInformationBySearch(); //Creado [Suemy][2024-05-27]
    getInfoTestComplete();
    getInformationTestForExport(); //Creado [Suemy][2024-06-10]

    $('#BtnMenuBurguer').click(function() {
      $('#BtnMenuEncuesta').toggleClass('active');
    })

    $('#button').click(function() { //Creado [Suemy][2024-05-27]
      getInformationBySearch();
    })

    $('#empleados').change(function() {
      const val = this.value;
      const month = document.getElementById('mesReporte').value;
      var url = `<?=base_url()?>VerEncuesta/excel?valor=${val}`;
      $('#btnExportReport').attr('href',url);
      if (val != 0) {
        $('#btnExportReport').attr('disabled',false);
      }
      else {
        $('#btnExportReport').attr('disabled',true);
      }
      if (val != 0 && month != 0) {
        $('#button').prop('disabled',false);
      }
      else {
        $('#button').prop('disabled',true);
      }
    })

    $('#mesReporte').change(function() {
      const val = document.getElementById('empleados').value;
      if (this.value != 0 && val != 0) {
        $('#button').prop('disabled',false);
      }
      else {
        $('#button').prop('disabled',true);
      }
    })

    $('#filterTable').keyup(function() {
      const val = $(this).val().toUpperCase();
      const body = "bodyTableReport";
      const clase = "mostrar";
      filterTable(val,body,clase);

      let count = document.getElementsByClassName('mostrar');
      //$('#countFilterResult').html(`(${count.length}) encontradas`);
      $('#countResult').html(`(${count.length}) encontradas`);
    })

    $('#filterTableGeneral').keyup(function() { //Creado [Suemy][2024-05-27]
      const val = $(this).val().toUpperCase();
      const body = "bodyTableReportTestComplete";
      const clase = "show-test-complete";
      filterTable(val,body,clase);
    })

    $('.open-icon').click(function() {
      //const type = $(this).data('icon');
      openContainer(this);
    })

    $('input[name="radio-search"]').click(function() { //Modificado [Suemy][2024-05-27]
      console.log(this.value);
      if (this.value == 1) {
        $('#selectMonthReport').prop('disabled',false);
        $('#selectPercentage').prop('disabled',true);
        $('#selectUserReport').prop('disabled',true);
      }
      else if (this.value == 2) {
        $('#selectMonthReport').prop('disabled',true);
        $('#selectPercentage').prop('disabled',false);
        $('#selectUserReport').prop('disabled',true);
      }
      else if (this.value == 3) {
        $('#selectMonthReport').prop('disabled',true);
        $('#selectPercentage').prop('disabled',true);
        $('#selectUserReport').prop('disabled',false);
      }
    })

    /*$('#btnExportGeneral').click(function() { //Creado [Suemy][2024-05-27]
      $('#contTableTestComplete div[data-type="excel"] button[aria-label="Exportar datos"]').click();
    })*/
  })

  const baseUrl = '<?=base_url()?>encuesta';

  function getInformationBySearch() { //Creado [Suemy][2024-05-27]
      const test = document.getElementById('encuestas').value;
      const employee = document.getElementById('empleados').value;
      var my = document.getElementById('mesReporte').value;
      my = my.split('-');
      const month = my[1];
      const year = my[0];
      getTestResult(test,employee,month,year);
      //getInfoTestByMonth(month,year);
  }

  function getTestResult(test,employee,month,year) {
    $('#button').prop('disabled',true);
    $('#btnExport').prop('disabled',true);

    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getSearchResultTest`,
      data: {
        ts: test,
        em: employee,
        mt: month,
        yr: year
      },
      beforeSend: (load) => {
        $('#bodyTableReport').html(`
            <tr>
                <td colspan="5">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let d = r['result'];
        var trtd = ``;
        var tr = ``;
        var count = 0;
        if (d != 0) {
          for (const a in d) {
            trtd += `
              <tr class="mostrar" data-id="${d[a].idcalificaencuesta}">
                <td>${d[a].descripcion}</td>
                <td>${d[a].usuario}</td>
                <td>${d[a].tipo}</td>
                <td>${d[a].calificacion}</td>
                <td><button class="btn btn-primary" onclick="getAnswersUser('${d[a].idcalificaencuesta}','${d[a].descripcion}','${d[a].usuario}')"><i class="fas fa-eye"></i> Ver</button></td>
              </tr>
            `;
            tr += `
              <tr>
                <td>${d[a].descripcion}</td>
                <td>${d[a].usuario}</td>
                <td>${d[a].tipo}</td>
                <td>${d[a].calificacion}</td>
              </tr>
            `;
          }
          $('#btnExport').prop('disabled',false);
          count = d.length;
        }
        else {
          trtd = `<tr><td colspan="5"><center><strong>Sin resultados</strong><center></td></tr>`;
          $('#btnExport').prop('disabled',true);
        }
        $('#countResult').html(`(${count} resultados)`);
        $('#bodyTableReport').html(trtd);
        $('#bodyTableReport2').html(tr);
        $('#button').prop('disabled',false);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getAnswersUser(test,title,user) { //Creado [Suemy][2024-05-27]
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getQuestionsTestByUser`,
      data: {
        id: test
      },
      beforeSend: (load) => {
        $('#bodyTableAnswersUser').html(`
            <tr>
                <td colspan="4">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        console.log(r);
        let e = r['encuesta'];
        var trtd = ``;
        var tfoot = ``;
        for (const a in e) {
          let p = e[a].preguntas;
          var preguntas = p.length;
          for (const b in p) {
            var valor = 0;
            var puntaje = 0;
            var estatus = "danger";
            var respuesta = (p[b].respuesta == null) ? "Sin responder" : getTextValue(p[b].respuesta);
            if(p[b].respuestausuario == '1'){ 
              valor = valor + Number(p[b].respuesta) * (10/preguntas);
              puntaje = (isNaN(valor)) ? 0 : valor;
              if (valor >= 50 && valor <= 59) {
                estatus = "warning";
              }
              else if (valor >= 60) {
                estatus = "success";
              }
            }
            else { 
              valor = valor + (100/preguntas);
              if (p[b].respuesta == p[b].respuestausuario) {
                puntaje = valor;
                if (valor != 0) { estatus = "success"; }
              }
            }

            trtd += `
              <tr data-id="${p[b].idencuesta}">
                <td>${p[b].pregunta}</td>
                <td><span class="badge text-bdg-secondary">${respuesta}</span></td>
                <td><span class="badge text-bdg-primary">${p[b].respuestausuario}</span></td>
                <td><span class="badge text-bdg-${estatus}">${puntaje.toFixed(0)}%</span></td>
              </tr>
            `;
          }
          tfoot += `
            <tr>
              <td colspan="3" style="text-align: end;"><strong>Puntaje Total:</strong></td>
              <td><strong>${Number(e[a].calificacion).toFixed(0)}%</strong></td>
            </tr>`;
        }
        $('#bodyTableAnswersUser').html(trtd);
        $('#tfootTableAnswersUser').html(tfoot);
        $('#titleTestSelectUser').text(title);
        $('#textNameUser').text(user);
        $(".answer-employees-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        })
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getInfoTestComplete() { //Modificado [Suemy][2024-06-10]
    const type = document.getElementById('testResult').value;
    const month = document.getElementById('monthResult').value;
    const year = document.getElementById('yearResult').value;
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getTestInfoComplete`,
      data: {
        tp: type,
        mt: month,
        yr: year
      },
      beforeSend: (load) => {
        $('#graphicTestGeneral').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
              <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
          </div>
        `);
        $('#graphicTestReady').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
              <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
          </div>
        `);
        $('#graphicTestMissing').html(`
          <div class="container-spinner-content-loading">
              <div class="cr-spinner spinner-border" role="status">
                  <span class="visually-hidden"></span>
              </div>
              <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
          </div>
        `);
        $('#bodyTableReportTestComplete').html(`
            <tr>
                <td colspan="11">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
        $('#btnExportGeneral').prop('disabled',true);
      },
      success: (data) => {
        const resp = JSON.parse(data);
        console.log(resp);
        let r = resp['test'];
        let d = resp['data'];
        let json = [];
        var trtd = ``;
        var tr = ``;
        var testA = 0;
        var testR = 0;
        var testF = 0;
        var testE = 0;
        var yearToday = `<?=date('Y')?>`;
        var monthToday = `<?=date('m')?>`;
        //var thead = `<tr><th>ID Encuesta</th><th>Encuesta</th><th>Asignadas</th><th>Contestadas</th><th>Faltantes</th><th>Promedio Resuelto</th><th>Promedio Faltante</th></tr>`;
        //Graficar
        let col = [];
        let age = [];
        let cli = [];
        let colN = [];
        let ageN = [];
        let cliN = [];
        let categorie = [];
        for (const a in r) {
          let s = r[a].asignados;
          let add = {};
          var asignados = 0;
          var resueltas = 0;
          var faltantes = 0;
          var resultado = 0;
          var extras = 0;
          var claseR = "";
          var claseF = "";
          var claseC = "";
          var contC = 0;
          var contA = 0;
          var contL = 0;
          var contCN = 0;
          var contAN = 0;
          var contLN = 0;
          categorie.push(r[a].titulo);
          if (s != 0) {
            for (const b in s) {
              if (s[b].asignado != 0) { asignados++; }
              if (s[b].activa == 1) {                
                if (s[b].asignado != 0) {testR++; resueltas++; resultado = resultado + Number(s[b].calificacion);}
                else {testE++; extras++;}
                if (s[b].tipoPersona == "Colaborador") {contC++;}
                else if (s[b].tipoPersona == "Agente") {contA++;}
                else {contL++;}
              }
              else {
                testF++;
                faltantes++;
                if (s[b].tipoPersona == "Colaborador") {contCN++;}
                else if (s[b].tipoPersona == "Agente") {contAN++;}
                else {contLN++;}
              }
            }
          }
          testA = testA + Number(asignados);
          const disabled = (asignados != 0) ? "" : ((extras != 0) ? "" : "disabled");
          //Se coloca en arrays
          col.push(contC);
          age.push(contA);
          cli.push(contL);
          colN.push(contCN);
          ageN.push(contAN);
          cliN.push(contLN);
          //Sacar porcentaje
          const promedioR = (asignados != 0) ? ((resueltas / asignados) * 100) : 0;
          const promedioF = (asignados != 0) ? ((faltantes / asignados) * 100) : 0;
          var promedioC = (resultado != 0) ? (resultado / asignados) : 0;
          promedioC = (Number.isInteger(promedioC) != true) ? promedioC.toFixed(2) : promedioC;
          //Class promedio resuelto
          if (promedioR >= 0 && promedioR < 70) {claseR = "danger";}
          else if (promedioR >= 70 && promedioR < 90) {claseR = "warning";}
          else if (promedioR >= 90) {claseR = "success";}
          //Class promedio faltante
          if (promedioF >= 70) {claseF = "danger"; }
          else if (promedioF > "0" && promedioF < 70) {claseF = "warning";}
          else if (promedioF <= "0") {claseF = "success";}
          //Class promedio calificacion
          if (promedioC >= 90) { claseC = "success"; }
          else if (promedioC >= 70 && promedioC < 90) { claseC = "warning"; }
          else if (promedioC < 70) { claseC = "danger"; }
          //En caso de que no haya asignados
          if (asignados == "0") {claseR = ""; claseF = ""; claseC = "";}

          trtd += `
            <tr class="show-test-complete">
              <td>${r[a].idcabencuesta}</td>
              <td>${r[a].titulo}</td>
              <td>${asignados}</td>
              <td>${resueltas}</td>
              <td>${faltantes}</td>
              <td class="${claseR}" title="Porcentaje Resuelto">${promedioR.toFixed(0)}%</td>
              <td class="${claseF}" title="Porcentaje Faltante">${promedioF.toFixed(0)}%</td>
              <td class="${claseC}" title="Promedio Calificación Por Asignados">${promedioC}</td>
              <td>
                <button class="btn btn-primary viewUser" data-test="${r[a].idcabencuesta}"><i class="fas fa-eye"></i> Ver</button>
              </td>
              <td>
                <button class="btn btn-primary viewResponse" data-test="${r[a].idcabencuesta}" data-month="${d['month']}" ${disabled}><i class="fas fa-tasks"></i> Ver</button>
              </td>
            </tr>
          `;
          tr += `
            <tr>
              <td>${r[a].idcabencuesta}</td>
              <td>${r[a].titulo}</td>
              <td>${asignados}</td>
              <td>${resueltas}</td>
              <td>${faltantes}</td>
              <td>${promedioR.toFixed(0)}%</td>
              <td>${promedioF.toFixed(0)}%</td>
              <td>${promedioC}</td>
            </tr>
          `;
          /*add[0] = r[a].idcabencuesta;
          add[1] = r[a].titulo;
          add[2] = asignados;
          add[3] = resueltas;
          add[4] = faltantes;
          add[5] = promedioR.toFixed(0);
          add[6] = promedioF.toFixed(0) + '%';
          json.push(add);*/
        }
        //Grafica General
        let datax = ["Asignadas","Resueltas","Faltantes"];
        let datay = [testA,testR,testF];
        //Graficas
        graphicLine(col,age,cli,categorie,`Encuestas Resueltas (${resp['title']})`,"graphicTestReady");
        graphicLine(colN,ageN,cliN,categorie,`Encuestas Faltantes (${resp['title']})`,"graphicTestMissing");
        graphicColumn(datax,datay,`Total Encuestas Resueltas (${resp['title']})`,"graphicTestGeneral");
        //Tabla
        //getTableBootstrap("contTableTestComplete","tableTestComplete2",thead,json,`ReportG <?=date('Y-m-d H:i:s')?>`);
        $('#titleResult').html(resp['title']);
        $('#bodyTableReportTestComplete').html(trtd);   
        $('#bodyTableReportTestComplete2').html(tr);     
        /*setTimeout(function() {*/ $('#btnExportGeneral').prop('disabled',false); /*},5000);*/
        //Modal Asignados
        $('.viewUser').click(function() {
          const id = $(this).data('test');
          var table = ``;
          var title = "";
          var countRC = 0;
          var countRA = 0;
          var countRL = 0;
          var countFC = 0;
          var countFA = 0;
          var countFL = 0;
          for (const a in r) {
            if (r[a].idcabencuesta == id) {
              title = r[a].titulo;
              let s = r[a].asignados;
              var contC = 0;
              var contA = 0;
              var contL = 0;
              for (const b in s) {
                if (s[b].asignado != 0) {
                  var clase = "";
                  var check = `<i class="fas fa-times-circle icon-circle-close"></i>`;
                  if (s[b].activa == 1) {
                    check = `<i class="fas fa-check-circle icon-circle-check"></i>`;
                    if (s[b].tipoPersona == "Colaborador") {countRC++;}
                    else if (s[b].tipoPersona == "Agente") {countRA++;}
                    else {countRL++}
                  }
                  else {
                    if (s[b].tipoPersona == "Colaborador") {countFC++;}
                    else if (s[b].tipoPersona == "Agente") {countFA++;}
                    else {countFL++}                  
                  }
                  if (s[b].tipoPersona == "Colaborador") {clase = "brown"; contC++;}
                  else if (s[b].tipoPersona == "Agente") {clase = "green"; contA++;}
                  else {clase = "vine"; contL++;}
                  table += `
                    <tr>
                      <td>${s[b].usuario}</td>
                      <td class="badge text-bdg-${clase}">${s[b].tipoPersona}</td>
                      <td>${check}</td>
                      <td><strong>${Number(s[b].calificacion).toFixed(0)}%</strong></td>
                    </tr>`;
                }
              }
              if (table == 0) {
                table = `<tr><td colspan="4"><center><strong>Sin resultados</strong><center></td></tr>`;
              }
            }
          }
          $('#titleTestSelection').text(title);
          $('#countRCol').text("("+countRC+")");
          $('#countRAgn').text("("+countRA+")");
          $('#countRCli').text("("+countRL+")");
          $('#countFCol').text("("+countFC+")");
          $('#countFAgn').text("("+countFA+")");
          $('#countFCli').text("("+countFL+")");
          $('#contCol').text("("+contC+")");
          $('#contAgn').text("("+contA+")");
          $('#contCli').text("("+contL+")");
          $('#bodyTableSelectionTest').html(table);
          $(".employees-modal").modal({
            show: true,
            keyboard: false,
            backdrop: true,
          });
        })
        //Modal Respuestas
        $('.viewResponse').click(function() {
          const id = $(this).data('test');
          const month = $(this).data('month');
          let data = tableResponse(id,r)[0];
          console.log(data);
          getTableBootstrap("contTableResultTest","tableResultTest",data[1],data[2],`Resultados <?=date('Y-m-d H:i:s')?>`);
          $('#titleTestSelectionResponse').text(data[0]);
          $(".response-test-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
          });
        })
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getInformationTestForExport() { //Creado [Suemy][2024-06-10]
    const month = "todos";
    const year = `<?=date('Y')?>`;
    $.ajax({
      type: "GET",
      url: `<?=base_url()?>encuesta/getTestInfoComplete`,
      data: {
        tp: "todos",
        mt: month,
        yr: year
      },
      success: (data) => {
        const resp = JSON.parse(data);
        console.log(resp);
        let r = resp['test'];
        getTestByUser(r);
      },
      error: (error) => {
        console.log(error);
      }
    })
  }

  function getTestByUser(t) { //Modificado [Suemy][2024-06-10]
    var optionTest = `<option value="0">SELECCIONAR</option>`;
    for (const a in t) {
      optionTest += `<option value="${t[a].idcabencuesta}">${t[a].titulo}</option>`;
    }
    $('#selectTestReport').html(optionTest);
    $('#selectTestReport').prop('disabled',false);
    $('#btnSearchAnswers').prop('disabled',false);
    $('#selectTestReport').change(function() {
      var val = this.value;
      var optionUser = `<option value="0">SELECCIONAR</option>`;
      for (const a in t) {
        let u = t[a].asignados;
        if (t[a].idcabencuesta == val) {
          if (u != 0) {
            optionUser += `<option value="t">TODOS</option>`;
            for (const b in u) {
              if (u[b].activa == 1) {
                optionUser += `<option value="${u[b].idcalificaencuesta}" data-status="${u[b].activa}">${u[b].usuario}</option>`;
              }
            }
          }
          else {optionUser = `<option>Ninguno</option>`}
        }
      }
      $('#selectUserReport').html(optionUser);
    })
    $('#btnSearchAnswers').click(function() {
      const month = $('#selectMonthReport').val();
      const test = $('#selectTestReport').val();
      const user = $('#selectUserReport').val();
      const range = Number($('#selectPercentage').val());
      const radio = document.getElementsByName('radio-search');
      let question = [];
      let response = [];
      var check = 0;
      var title = "";
      var table = ``;
      var thead = ``;
      var tbody = ``;
      for (let i=0;i<radio.length;i++) {
        if (radio[i].checked) {
          check = radio[i].value;
          title = radio[i].title;
        }
      }
      //console.log(test, user, range, month, check, radio);
      if (check == 1 && test != 0 && month != 0 || check == 2 && test != 0 && range != 0 || check == 3 && test != 0 && user != 0) {
      for (const a in t) {
        let u = t[a].asignados;
        let p = t[a].preguntas;
        if (t[a].idcabencuesta == test && p != 0) {
          var number = p.length + 2;
          thead += `<tr class="tr-style"><th class="title-table" colspan="${number}">${t[a].titulo}</th></tr><tr class="tr-style"><th>Nombre</th>`;
          for (const b in p) {
            thead += `<th title="${p[b].pregunta}">${p[b].pregunta}</th>`;
            question.push(p[b].pregunta);
          }
          thead += `<th>Calificacion</th><tr>`;
          for (const c in u) {
            let r = u[c].preguntas;
            if (u[c].activa == 1 && u[c].asignado != 0) { //Resueltas
              switch (check) { //Buscar por
                case "1": //Mes y Año
                  const date = (getTextValue(u[c].fechacontesta) != "") ? (getDateFormat(u[c].fechacontesta,10)) : "";
                  if (month == date) {
                    tbody += `<tr><td>${u[c].usuario}</td>`;
                    tbody += iterateResponse(p,r);
                    tbody += `<td>${u[c].calificacion}</td></tr>`;
                    var res = iterateResponse(p,r,u[c].calificacion,1);
                    res.unshift(u[c].usuario);
                    response.push(res);
                  }
                break;
                case "2": //Máximo de calificación
                  const calificacion = Number(u[c].calificacion);
                  if (calificacion <= range) {
                    tbody += `<tr><td>${u[c].usuario}</td>`;
                    tbody += iterateResponse(p,r);
                    tbody += `<td>${u[c].calificacion}</td></tr>`;
                    var res = iterateResponse(p,r,u[c].calificacion,1);
                    res.unshift(u[c].usuario);
                    response.push(res);
                  }
                break;
                case "3": //Nombre usuario
                  if (user != "t") {
                    if (u[c].idcalificaencuesta == user) {
                      tbody += `<tr><td>${u[c].usuario}</td>`;
                      tbody += iterateResponse(p,r);
                      tbody += `<td>${u[c].calificacion}</td></tr>`;
                      var res = iterateResponse(p,r,u[c].calificacion,1);
                      res.unshift(u[c].usuario);
                      response.push(res);
                    }
                  }
                  else {
                    tbody += `<tr><td>${u[c].usuario}</td>`;
                    tbody += iterateResponse(p,r);
                    tbody += `<td>${u[c].calificacion}</td></tr>`;
                    var res = iterateResponse(p,r,u[c].calificacion,1);
                    res.unshift(u[c].usuario);
                    response.push(res);
                  }
                break;
              }
            }
          }
        }
      }
      getTableBootstrap("contTableReportTestUser","tableReportTestUser",thead,response,`Resultados <?=date('Y-m-d H:i:s')?>`);
      const num = (response != 0) ? response.length : 0;
      $('#typeExportReport').text(`*Búsqueda por "${title}" - Resultados encontrados: ${num}`);
      }
      else if (test == 0) { swal("¡Espera!", "No has seleccionado la escuesta.", "warning"); }
      else if (range == 0 || user == 0) { 
        swal("¡Espera!", "Aún no has escrito la calificación o seleccionado el usuario.", "warning"); 
      }
    })
  }

  function tableResponse(test,t) { //Creado [Suemy][2024-06-10]
    var title = "";
    var thead = ``;
    let response = [];
    for (const a in t) {
      let u = t[a].asignados;
      let p = t[a].preguntas;
      if (t[a].idcabencuesta == test && p != 0) {
        var number = p.length + 4;
        title = t[a].titulo;
        thead += `<tr class="tr-style"><th class="title-table" colspan="${number}">${t[a].titulo}</th></tr><tr class="tr-style"><th>Contestado</th><th>Enviado</th><th>Nombre</th>`;
        for (const b in p) {
          thead += `<th title="${p[b].pregunta}">${p[b].pregunta}</th>`;
        }
        thead += `<th>Calificacion</th><tr>`;
        for (const c in u) {
          let r = u[c].preguntas;
          if (u[c].activa == 1) { //Resueltas
            if (u[c].asignado != 0) {
              //var type = (u[c].asignado != 0) ? "Asignado" : "Extra";
              var res = iterateResponse(p,r,u[c].calificacion,1);
              res.unshift(u[c].usuario); //[3]
              //res.unshift(type); //[2]
              res.unshift(getDateFormat(u[c].fechaRegistro,2)); //[1]
              res.unshift(getDateFormat(u[c].fechacontesta,2)); //[0]
              response.push(res);
            }
          }
        }
      }
    }
    let data = [{[0]:title, [1]:thead, [2]:response}];
    return data;
  }

  function iterateResponse(p,r,source = null,type = null) { //Modificado [Suemy][2024-05-27]
    var tbody = ``;
    let resp = [];
    var n = 0;
    if (r.length < p.length) {
      for (i in p) {
        n++;
        var include = "";
        var response = "";
        //console.log("Iteracion: " + n);
        for (const j in r) {
          //console.log(r[j].respuesta + " - " + r[j].pregunta);
          if (r[j].pregunta.includes(p[i].pregunta)) {
            response = r[j].respuesta;
            include = "SI";
            break;
          }
          else {
            include = "NO";
          }
        }
        //console.log("Coincide: " + include);
        if (include == "SI") {
          tbody += `<td>${response}</td>`;
          resp.push(response);
        }
        else {
          tbody += `<td>Sin responder</td>`;
          resp.push("Sin reponder");
        }
      }
    }
    else if (r.length == p.length) { 
      for (const j in r) {
        tbody += `<td>${r[j].respuesta}</td>`;
        resp.push(r[j].respuesta);
      }
    }

    if (type == 1) {
      resp.push(source);
      tbody = resp;
    }
    return tbody;
  }

  //----------------------------------------------- Operaciones -----------------------------------------------

  function getTableBootstrap(container,table,thead,jsonData,file) { //Creado [Suemy][2024-05-27]
      //$('#'+container).css('height','');
      $('#'+container).html(`<table class="table table-striped" id="${table}" data-show-columns="true" data-show-search-clear-button="true"><thead>${thead}</thead></table>`);
        //console.log(jsonData);

      $('#'+table).bootstrapTable({
          data: jsonData,
          height: 400,
          pagination: false,
          search: true,
          cache: false,
          locale: 'es-MX',
          showExport: true,
          exportTypes: ['excel'],
          exportOptions: {
              fileName: function () {
                  return file
              }
          }
      });
  }

  function searchFilterTable(filter,title,obj = null) { //Creado [Suemy][2024-05-27]
    if (obj != null) {
      const id = $(obj).data('id');
      const m_y = $(obj).data('year') + "-" + $(obj).data('month');
      $('#encuestas option[value="'+id+'"]').prop('selected',true);
      $('#empleados option[value="1"]').prop('selected',true);
      $('#mesReporte').val(m_y);
      $('#button').click();
    }
    else {
      const val = title.toUpperCase();
      $('#'+filter).val(val);
      $('#'+filter).keyup();
    }
  }

  function eraserFilterTable(filter) { //Creado [Suemy][2024-05-27]
    $('#'+filter).val("");
    $('#'+filter).keyup();
  }

  function filterTable(value,body,clase) {
    var filter, panel, d, td, i, j, k, visible;
    filter = value;
    panel = document.getElementById(body);
    d = panel.getElementsByTagName("tr");
    let Fila = document.getElementsByClassName(clase);
    //
    for (i = 0; i < d.length; i++) {
        visible = false;
        td = d[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                visible = true;
            }
        }
        if (visible === true) {
            d[i].style.display = "";
            $(d[i]).addClass(clase);
        }
        else {
            d[i].style.display = "none";
            $(d[i]).removeClass(clase);
        }
    }
    result = Fila.length;
  }

  function openContainer(event) {
      const icon = $(event).children('i');
      icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
      icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
  }

  function verContenidoEncuesta(div,title){
    let clas=document.getElementsByClassName('divContenidoEncuesta');
    let cant=clas.length;
    for(let i=0;i<cant;i++){clas[i].classList.remove('verObjeto');clas[i].classList.add('ocultarObjeto');}
    if(document.getElementById(div)){document.getElementById(div).classList.remove('ocultarObjeto');}
    if(document.getElementById(div)){
      document.getElementById(div).classList.add('verObjeto');
      $('#TitleSectionTest').html(title);
    };
  }

  function graphicLine(serie1,serie2,serie3,categorie,titleG,graphic) {
    var options = {
      series: [{
          name: 'Colaboradores',
          data: serie1 //Colaboradores
        }, {
          name: 'Agentes',
          data: serie2 //Agentes
        }, {
          name: 'Clientes',
          data: serie3 //Clientes
      }],
      chart: {
          height: 350,
          type: 'area'
      },
      //colors: ['#3E40B5', '#3EB1B5'],
      title: {
          text: titleG
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          curve: 'smooth'
      },
      xaxis: {
          //type: 'datetime',
          categories: categorie,
          labels: {
            rotate: -45,
            rotateAlways: true,
            //hideOverlappingLabels: true,
            trim: true,
            maxHeight: 150, //Height contenedor de las categorías
          },
      },
      yaxis: {
          title: {
            text: 'Personas',
          },
      },
      /*tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          },
      },*/
    };
    $('#'+graphic).html("");
    var chart = new ApexCharts(document.querySelector("#"+graphic), options);
    chart.render();
  }

  function graphicColumn(datax,datay,titleG,graphic) {
    var options = {
      series: [{
          name: 'Personas',
          data: datay
      }],
      chart: {
          type: 'bar',
          height: 350
      },
      colors: ['#3D65B6', '#488982'],
      plotOptions: {
          bar: {
            borderRadius: 3,
            horizontal: false,
            columnWidth: '50%',
            endingShape: 'rounded',
            distributed: true,
          },
      },
      dataLabels: {
          enabled: true //Número de las columnas
      },
      legend: { //Los indicadores de color
          show: true
      },
      title: {
          text: titleG
      },
      grid: {
          row: {
            colors: ['#fff', '#f2f2f2']
          }
      },
      stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
      },
      xaxis: {
          categories: datax,
          labels: {
            show: false
          },
      },
      yaxis: {
          title: {
            text: 'Personas'
          },
          labels: { //Números del lateral izquierdo y de las columnas
            formatter: (val) => {
                return val.toFixed(0)
            }
          },
      },
      fill: {
          opacity: 1
      },
      /*tooltip: { //Sólo afecta a los resultados de las columnas
          y: {
            formatter: function (val) {
              return val.toFixed(0)
            }
          }
      },*/
      responsive: [{
          breakpoint: 480,
            // options: {
            //   chart: {
            //     width: 200
            //   },
            //   legend: {
            //     position: 'bottom'
            //   }
            // }
      }]
    };
    $('#'+graphic).html("");
    var chart = new ApexCharts(document.querySelector("#"+graphic), options);
    chart.render();
  }

  function getNumberValue(data) { //Creado [Suemy][2024-05-27]
      if (data == "[object Object]" || data == undefined || data == null || data == "" || data == 0) {
          data = 0;
      }
      return data;
  }

  function getTextValue(data) { //Creado [Suemy][2024-05-27]
      if (data == "[object Object]" || data == undefined || data == null || data == "") {
          data = "";
      }
      return data;
  }

  function getDateFormat(data,format) { //Creado [Suemy][2024-05-27]
    let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
    let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
    let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
    let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

    var dateF = "";

    if (data == undefined || data == null || data == "") {
        dateF = "";
    }
    else {
        if (!data.includes(':')) { data = data + " 00:00:00";}
        date = new Date(data);
        switch (format) {
            case 1:
                dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
            break;
            case 2:
                dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            break;
            case 3:
                //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
                dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
            break;
            case 4:
                dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            break;
            case 5:
                dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
            break;
            case 6:
                dateF = dayname[date.getDay()];
            break;
            case 7:
                dateF = monthname[date.getMonth()];
            break;
            case 8:
                dateF = date.getFullYear();
            break;
            case 9:
                if (!data.includes('00:00:00')) { dateF = date.toLocaleTimeString('en-US'); }
            break;
            case 10:
              dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()];
            break;
        }
    }
    return dateF;
  }
//---------------------------------------------------------------------------------------------------------
AddEvenListener();
function AddEvenListener()
{
  document.querySelector(".activa").addEventListener('click',encuestaActivas);
 // document.querySelector(".contenedor-modalEncuestas").addEventListener('click',nps);
  document.querySelector("#ullistaEcuestas").addEventListener('click',uno); 
}
 /********************************************************* */
 function uno(e) //Modificado* [2024-01-04]
{
  e.preventDefault();
  var np = e.target;
  console.log(np);
  var persona =0;
  if(np.classList.contains('uno'))
   {
    // console.log('entro');
     var idnps = np.parentElement.parentElement.id;
     var xhr = new XMLHttpRequest();
     var datos = new FormData();
     datos.append('strvalor',idnps);
     xhr.open('POST',"<?php echo base_url();?>pregunta/ReporteEncuestaNps",true);
     xhr.onload = function()
     {
      if(this.status===200)
      {       
       var respuesta =JSON.parse(xhr.responseText);
       console.log(respuesta);
       //if(respuesta.persona.[0].personas > 0)
      // {
          let  evaluada = respuesta.persona[0].personas;
          let encuestadas =respuesta.evaluada[0].activas; 
          let men70 = Math.round((respuesta.promedio[0].men70 )*100)/100; 
          let entre70 = Math.round((respuesta.promedio[0].entre7090 )*100)/100; 
          let may90 = Math.round((respuesta.promedio[0].may90 )*100)/100; 
         // console.log(men70);
         var div = document.getElementById('graficaCorporativa');
         while (div.firstChild) {
            div.removeChild(div.firstChild);
            }          
            var div = document.getElementById('graficaAseguradora');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaAsesoria');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaGestor');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }       
            var divSiniestros = document.getElementById('siniestros');
       var divClientenuevo = document.getElementById('clientenuevo');
       divSiniestros.innerHTML ="";
       divClientenuevo.innerHTML ="";
       //divevaluado.innerHTML = "";
       var divevaluado = document.getElementById('numevaluados');
       divevaluado.innerHTML ="";
       var divevaluado = document.getElementById('numevaluadosaseguradora');
       divevaluado.innerHTML ="";
 var divevaluado = document.getElementById('numevaluadosasesoria');
       divevaluado.innerHTML ="";
 var divevaluado = document.getElementById('numevaluadosgestor');
       divevaluado.innerHTML ="";
         //  var divevaluado = document.getElementById('numevaluados');
          /* while (divevaluado.firstChild) {
            divevaluado.removeChild(div.firstChild);
            }*/
           divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
           Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam> \
           Menores a 70 = <spam class= 'numero'>"+men70+" %</spam> \
           Entre  a 70 y 90 = <spam class= 'numero'>"+entre70+" %</spam> \
           Mayor 90 = <spam class= 'numero'>"+may90+" %</spam> \
            </p>";
          // Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>";        
           //console.log(divevaluado);    
      // }
      } 
     }
     xhr.send(datos);  
   }
   if(np.classList.contains('verdad'))
   {
    // console.log('entro');
     var idnps = np.parentElement.parentElement.id;
     var xhr = new XMLHttpRequest();
     var datos = new FormData();
     datos.append('strvalor',idnps);
     xhr.open('POST',"<?php echo base_url();?>pregunta/ReporteEncuestaNps",true);
     xhr.onload = function()
     {
      if(this.status===200)
      {       
       var respuesta =JSON.parse(xhr.responseText);
       console.log(respuesta);
       //if(respuesta.persona.[0].personas > 0)
      // {
          let  evaluada = respuesta.persona[0].personas;
          let encuestadas =respuesta.evaluada[0].activas; 
          let verdadero =0;//respuesta.verfalso[0].verdadero; 
          let falso =0;respuesta.verfalso[0].falso; 
          let total =0;
          if(respuesta.total.length > 0)
          {
           // console.log(respuesta.nps[0].detractor);
           total = respuesta.total[0].Total;       
          }

      if(respuesta.verfalso.length > 0)
       {
         // console.log(respuesta.nps[0].detractor);
         verdadero = respuesta.verfalso[0].verdadero;
         falso = respuesta.verfalso[0].falso;
         if(verdadero == null)
           verdadero =0;
           if(falso == null)
           falso =0;  
       }
       
       if(total >0)
       {
         verdadero =(verdadero/total)*100;
         falso =(falso/total)*100;
         verdadero = +verdadero.toFixed(2);
         falso = +falso.toFixed(2);
       }
       var divSiniestros = document.getElementById('siniestros');
       var divClientenuevo = document.getElementById('clientenuevo');
       divSiniestros.innerHTML ="";
       divClientenuevo.innerHTML ="";
       var divevaluado = document.getElementById('numevaluados');
       divevaluado.innerHTML ="";
       var divevaluado = document.getElementById('numevaluadosaseguradora');
       divevaluado.innerHTML ="";
 var divevaluado = document.getElementById('numevaluadosasesoria');
       divevaluado.innerHTML ="";
 var divevaluado = document.getElementById('numevaluadosgestor');
       divevaluado.innerHTML ="";
       var div = document.getElementById('graficaCorporativa');
           while (div.firstChild) {
            div.removeChild(div.firstChild);
            }          
            var div = document.getElementById('graficaAseguradora');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaAsesoria');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaGestor');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
        //   var divevaluado = document.getElementById('numevaluados');
          //     divevaluado.innerHTML = "";
       /*    while (divevaluado.firstChild) {
            divevaluado.removeChild(div.firstChild);
            }*/
         //  var divevaluado = document.getElementById('numevaluados');
           divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
           Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam> </p> \
           <p class= 'personas'> Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam> \
           </p>";       
      } 
     }
     xhr.send(datos);  
   }
   //nps
   if(np.classList.contains('nps'))
   {
     var idnps = np.parentElement.parentElement.id;
     var xhr = new XMLHttpRequest();
     var datos = new FormData();
     var detractor = 0;
         var pasivo = 0;
         var promotor = 0;
         var evaluada = 0; 
         var encuestadas = 0; 
         var verfalso =0;
         var verdadero =0;
         var falso =0;
         var total =0;
         let vnps=0;
     datos.append('strvalor',idnps);
     xhr.open('POST',"<?php echo base_url();?>pregunta/ReporteEncuestaNps",true);
     xhr.onload = function()
     {
      if(this.status===200)
      {       
       var respuesta =JSON.parse(xhr.responseText);
          //console.log(respuesta);
          detractor = parseInt(respuesta.npstiempos[0].detractor);
          pasivo = parseInt(respuesta.npstiempos[0].pasivo);
          promotor = parseInt(respuesta.npstiempos[0].promoter);
          //console.log(detractor);
          pdetractor =Math.round(((detractor/(detractor+pasivo+promotor))*100),-2);
          ppasivo=Math.round(((pasivo/(detractor+pasivo+promotor))*100),-2);
          ppromotor=Math.round(((promotor/(detractor+pasivo+promotor))*100),-2);
          vnps = ppromotor -pdetractor;
          var div = document.getElementById('graficaCorporativa');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaAseguradora');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaAsesoria');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
            var div = document.getElementById('graficaGestor');
            while (div.firstChild) {
            div.removeChild(div.firstChild);
            }
             var divevaluado = document.getElementById('numevaluados');
             divevaluado.innerHTML = "";
          google.charts.load('current', {'packages':['corechart']});
          google.charts.setOnLoadCallback(drawChart3);
          function drawChart3() {
           var data = google.visualization.arrayToDataTable([
            ['nombre', 'valor'],
            ['DETRACTOR',  detractor],
            ['PASIVO',     pasivo],
            ['PROMOTOR',   promotor]          
          ]);

          var options = {
          title: 'NET PROMOTER SCORE TIEMPOS',
          backgroundColor: {fill: '#637164',
                   fillOpacity: 0.8}
   
          };

        var chart = new google.visualization.PieChart(document.getElementById('graficaCorporativa'));
        chart.draw(data, options);
       }
              //Agregamos una nueva grafica para Aseguradora
        /* divevaluado.innerHTML = "";*/     

       var divSiniestros = document.getElementById('siniestros');
       var divClientenuevo = document.getElementById('clientenuevo');
       divSiniestros.innerHTML ="";
       divClientenuevo.innerHTML ="";
       var divevaluado = document.getElementById('numevaluados');
       divevaluado.innerHTML ="";
       let  evaluada = respuesta.persona[0].personas;
          let encuestadas =respuesta.evaluada[0].activas; 
          let verdadero =0;//respuesta.verfalso[0].verdadero; 
          let falso =0;respuesta.verfalso[0].falso; 
          let total =0;
          if(respuesta.total.length > 0)
          {
           // console.log(respuesta.nps[0].detractor);
           total = respuesta.total[0].Total;       
          }
          if(respuesta.verfalso.length > 0)
       {
         // console.log(respuesta.nps[0].detractor);
         verdadero = respuesta.verfalso[0].verdadero;
         falso = respuesta.verfalso[0].falso;
         if(verdadero == null)
           verdadero =0;
           if(falso == null)
           falso =0;  
       }
       
       if(total >0)
       {
         verdadero =(verdadero/total)*100;
         falso =(falso/total)*100;
         verdadero = +verdadero.toFixed(2);
         falso = +falso.toFixed(2);
       }
       divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>\
        <p class= 'personas'> Promotores= <spam class= 'numero'> "+ppromotor+"%</spam> Detractores = <spam class= 'numero'> "+pdetractor+"%</spam> Pasivo = <spam class= 'numero'> "+ppasivo+"%</spam> </p>\
        <p class= 'personas'> NPS = <spam class= 'numero'> "+vnps+"% </p>";  
  
        //05-10-2022 hurcm Encuestas de Aseguradoras
          detractoras = parseInt(respuesta.npsaseguradora[0].detractor);
          pasivoas = parseInt(respuesta.npsaseguradora[0].pasivo);
          promotoras = parseInt(respuesta.npsaseguradora[0].promoter);
          pdetractoras =Math.round(((detractoras/(detractoras+pasivoas+promotoras))*100),-2);
          ppasivoas=Math.round(((pasivoas/(detractoras+pasivoas+promotoras))*100),-2);
          ppromotoras=Math.round(((promotoras/(detractoras+pasivoas+promotoras))*100),-2);
          vnpsas = ppromotoras -pdetractoras;
          google.charts.setOnLoadCallback(drawChart4);
          function drawChart4() {
           var data = google.visualization.arrayToDataTable([
            ['nombre', 'valor'],
            ['DETRACTOR',  detractoras],
            ['PASIVO',     pasivoas],
            ['PROMOTOR',   promotoras]          
          ]);

          var options = {
          title: 'NET PROMOTER SCORE ASEGURADORA',
          backgroundColor: {fill: '#637164',
                   fillOpacity: 0.8}
   
          };
        var chart = new google.visualization.PieChart(document.getElementById('graficaAseguradora'));
        chart.draw(data, options); 
        }
        var divevaluado = document.getElementById('numevaluadosaseguradora');
       divevaluado.innerHTML =""
       divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>\
        <p class= 'personas'> Promotores= <spam class= 'numero'> "+ppromotoras+"%</spam> Detractores = <spam class= 'numero'> "+pdetractoras+"%</spam> Pasivo = <spam class= 'numero'> "+ppasivoas+"%</spam> </p>\
        <p class= 'personas'> NPS = <spam class= 'numero'> "+vnpsas+"% </p>";  
       //termima
        //05-10-2022 hurcm Encuestas de Asesoria
        // console.log(respuesta.cadena[0].tipoencuesta)
         var  titulo ="";
         if(respuesta.cadena[0].tipoencuesta == 1)
         {
          detractorase = parseInt(respuesta.npsasesoria[0].detractor);
          pasivoase = parseInt(respuesta.npsasesoria[0].pasivo);
          promotorase = parseInt(respuesta.npsasesoria[0].promoter);
          titulo = "NET PROMOTER SCORE ASESORIA";
         }
         else{
          detractorase = parseInt(respuesta.npsprofesionalismo[0].detractor);
          pasivoase = parseInt(respuesta.npsprofesionalismo[0].pasivo);
          promotorase = parseInt(respuesta.npsprofesionalismo[0].promoter);
          titulo = "NET PROMOTER SCORE PROFESIONALISMO";
         }
          pdetractorase =Math.round(((detractorase/(detractorase+pasivoase+promotorase))*100),-2);
          ppasivoase=Math.round(((pasivoase/(detractorase+pasivoase+promotorase))*100),-2);
          ppromotorase=Math.round(((promotorase/(detractorase+pasivoase+promotorase))*100),-2);
          vnpsase = ppromotorase -pdetractorase;
          google.charts.setOnLoadCallback(drawChart5);
          function drawChart5() {
           var data = google.visualization.arrayToDataTable([
            ['nombre', 'valor'],
            ['DETRACTOR',  detractorase],
            ['PASIVO',     pasivoase],
            ['PROMOTOR',   promotorase]          
          ]);
          
             var options = {
            
               title: titulo,
              backgroundColor: {fill: '#637164',
                   fillOpacity: 0.8}
   
          };   
        
        var chart = new google.visualization.PieChart(document.getElementById('graficaAsesoria'));
        chart.draw(data, options); 
        }
        var divevaluado = document.getElementById('numevaluadosasesoria');
       divevaluado.innerHTML =""
       divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>\
        <p class= 'personas'> Promotores= <spam class= 'numero'> "+ppromotorase+"%</spam> Detractores = <spam class= 'numero'> "+pdetractorase+"%</spam> Pasivo = <spam class= 'numero'> "+ppasivoase+"%</spam> </p>\
        <p class= 'personas'> NPS = <spam class= 'numero'> "+vnpsase+"% </p>"; 
       //termima asesoria
 //05-10-2022 hurcm Encuestas de Gestor
         if(respuesta.cadena[0].tipoencuesta == 1)
         {
          detractorges = parseInt(respuesta.npsgestor[0].detractor);
          pasivoges = parseInt(respuesta.npsgestor[0].pasivo);
          promotorges = parseInt(respuesta.npsgestor[0].promoter);
         }
         else{
          detractorges = parseInt(respuesta.npsnivel[0].detractor);
          pasivoges = parseInt(respuesta.npsnivel[0].pasivo);
          promotorges = parseInt(respuesta.npsnivel[0].promoter);
         }
          pdetractorges =Math.round(((detractorges/(detractorges+pasivoges+promotorges))*100),-2);
          
          ppasivoges=Math.round(((pasivoges/(detractorges+pasivoges+promotorges))*100),-2);
          ppromotorges=Math.round(((promotorges/(detractorges+pasivoges+promotorges))*100),-2);
          vnpsges = promotorges -pdetractorges;
          google.charts.setOnLoadCallback(drawChart6);
          function drawChart6() {
           var data = google.visualization.arrayToDataTable([
            ['nombre', 'valor'],
            ['DETRACTOR',  detractorges],
            ['PASIVO',     pasivoges],
            ['PROMOTOR',   promotorges]          
          ]);

          var options = {
          title: 'NET PROMOTER SCORE GESTOR',
          backgroundColor: {fill: '#637164',
                   fillOpacity: 0.8}
   
          };
        var chart = new google.visualization.PieChart(document.getElementById('graficaGestor'));
        chart.draw(data, options); 
        }
        var divevaluado = document.getElementById('numevaluadosgestor');
       divevaluado.innerHTML ="";
       divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>\
        <p class= 'personas'> Promotores= <spam class= 'numero'> "+ppromotorges+"%</spam> Detractores = <spam class= 'numero'> "+pdetractorges+"%</spam> Pasivo = <spam class= 'numero'> "+ppasivoges+"%</spam> </p>\
        <p class= 'personas'> NPS = <spam class= 'numero'> "+vnpsges+"% </p>"; 

       //Termina gestor
       //console.log(respuesta);
       if(respuesta.cadena[0].tipoencuesta == 1)
       {      
        console.log('entro');
        //if(isNaN(vnps))
       // {  pdetractor =Math.round(((detractor/(detractor+pasivo+promotor))*100),-2);
        divSiniestros.innerHTML = "<p class= 'siniestros'> NPS Siniestro</p>\
        <p class= 'siniestros'><spam class= 'encabezanps'> TIEMPOS</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[0].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[0].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[0].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[0].promoter*100)-(respuesta.siniestro[0].detractor*100)))+"%</spam></p> \
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASEGURADORA</spam>  Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[1].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[1].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[1].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[1].promoter*100)-(respuesta.siniestro[1].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASESORIA</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[2].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[2].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[2].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[2].promoter*100)-(respuesta.siniestro[2].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  GESTOR</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[3].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[3].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[3].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[3].promoter*100)-(respuesta.siniestro[3].detractor*100)))+"%</spam></p>";                 
       }
       //nps clientes nuevos
       if(respuesta.cadena[0].tipoencuesta == 2)
       {
       
      
       divClientenuevo.innerHTML = "<p class= 'siniestros'> NPS Cliente Nuevo</p> \
       <p class= 'siniestros'><spam class= 'encabezanps'> TIEMPOS</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[0].promoter*100)-(respuesta.clientenuevo[0].detractor*100)))+"%</spam></p> \
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASEGURADORA</spam>  Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[1].promoter*100)-(respuesta.clientenuevo[1].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  PROFESIONALISMO</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[2].promoter*100)-(respuesta.clientenuevo[2].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  NIVEL DE CONFIANZA</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[3].promoter*100)-(respuesta.clientenuevo[3].detractor*100)))+"%</spam></p>";                 
       }
      }
     }
     xhr.send(datos);  
   }
}
 /********************************************************* */
function nps(e) //Modificado* [2024-01-04]
{
  e.preventDefault();
  var np = e.target;
   if(np.classList.contains('nps'))
   {
    if(document.getElementsByClassName('liSeleccionado')[0]){document.getElementsByClassName('liSeleccionado')[0].classList.remove('liSeleccionado')}
    np.parentElement.parentElement.classList.add('liSeleccionado');
     var idnps = np.parentElement.parentElement.id;
     var xhr = new XMLHttpRequest();
     var datos = new FormData();
     datos.append('strvalor',idnps);
     xhr.open('POST',"<?php echo base_url();?>pregunta/ReporteEncuestaNps",true);
     var detractor = 0;
         var pasivo = 0;
         var promotor = 0;
         var evaluada = 0; 
         var encuestadas = 0; 
         var verfalso =0;
         var verdadero =0;
         var falso =0;
         var total =0;
         let vnps=0;
     xhr.onload = function()
    {
      if(this.status===200)
      {       
       var respuesta =JSON.parse(xhr.responseText);

      var detractor=0 ;
      var pasivo=0;
      var promotor=0;
      var pdetractor=0 ;
      var ppasivo=0;
      var ppromotor=0;
     // console.log(parseInt(respuesta.nps[0].pasivo));


     //console.log(respuesta.siniestro[0].detractor);
       if(respuesta.npstiempos.length > 0)
       {
       
       // for(let i=0;i < respuesta.nps.length; i++)
      // {

        // if(respuesta.nps[i].detractor >0){
          detractor = parseInt(respuesta.npstiempos[0].detractor);
         
        // }
        // if(respuesta.nps[i].pasivo >0){
          pasivo = parseInt(respuesta.npstiempos[0].pasivo);
        // }
         //if(respuesta.nps[i].promoter >0){
          promotor = parseInt(respuesta.npstiempos[0].promoter);
          pdetractor =Math.round(((detractor/(detractor+pasivo+promotor))*100),-2);
          ppasivo=Math.round(((pasivo/(detractor+pasivo+promotor))*100),-2);
          ppromotor=Math.round(((promotor/(detractor+pasivo+promotor))*100),-2);
          vnps = ppromotor -pdetractor;
         //}
        
       // } 
       }

       if(respuesta.persona.length > 0)
       {
         evaluada = respuesta.persona[0].personas;

        
       }

       
       if(respuesta.evaluada.length > 0)
       {
         // console.log(respuesta.nps[0].detractor);
         encuestadas = respuesta.evaluada[0].activas;
        
       }
       
       if(respuesta.total.length > 0)
       {
         // console.log(respuesta.nps[0].detractor);
         total = respuesta.total[0].Total;
        
       }
       
      if(respuesta.verfalso.length > 0)
       {
         // console.log(respuesta.nps[0].detractor);
         verdadero = respuesta.verfalso[0].verdadero;
         falso = respuesta.verfalso[0].falso;
         if(verdadero == null)
           verdadero =0;
           if(falso == null)
           falso =0;  
       }
       
       if(total >0)
       {
         verdadero =(verdadero/total)*100;
         falso =(falso/total)*100;
         verdadero = +verdadero.toFixed(2);
         falso = +falso.toFixed(2);
       }

       var div = document.getElementById('graficaCorporativa');
       while (div.firstChild) {
        div.removeChild(div.firstChild);
        }

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart3);
        function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['nombre', 'valor'],
          ['DETRACTOR',  detractor],
          ['PASIVO',     pasivo],
          ['PROMOTOR',   promotor]          
        ]);

        var options = {
       title: 'NET PROMOTER SCORE',
        backgroundColor: {fill: '#637164',
                   fillOpacity: 0.8}
   
      };

       var chart = new google.visualization.PieChart(document.getElementById('graficaCorporativa'));
       chart.draw(data, options);
      /* var divevaluado = document.getElementById('numevaluados');
       if(isNaN(vnps))
       {
        divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>";        
          
       }
       else{
        divevaluado.innerHTML = "<p class= 'personas'> Encuestas= <spam class= 'numero'> "+evaluada+"</spam>  \
        Evaluadas = <spam class= 'numero'>"+encuestadas+"</spam>  Verdaderos = <spam class= 'numero'>"+verdadero+"%</spam>  Falso = <spam class= 'numero'>"+falso+"%</spam></p>\
        <p class= 'personas'> Promotores= <spam class= 'numero'> "+ppromotor+"%</spam> Detractores = <spam class= 'numero'> "+pdetractor+"%</spam> Pasivo = <spam class= 'numero'> "+ppasivo+"%</spam> </p>\
        <p class= 'personas'> NPS = <spam class= 'numero'> "+vnps+"% </p>";  
       }*/
       } 
        //nps siniestros
       // console.log(respuesta.cadena[0].tipoencuesta);
       var divSiniestros = document.getElementById('siniestros');
       var divClientenuevo = document.getElementById('clientenuevo');
       divSiniestros.innerHTML ="";
       divClientenuevo.innerHTML ="";
       if(respuesta.cadena[0].tipoencuesta == 1)
       {      
        
        //if(isNaN(vnps))
       // {  pdetractor =Math.round(((detractor/(detractor+pasivo+promotor))*100),-2);
        divSiniestros.innerHTML = "<p class= 'siniestros'> NPS Siniestro</p>\
        <p class= 'siniestros'><spam class= 'encabezanps'> TIEMPOS</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[0].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[0].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[0].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[0].promoter*100)-(respuesta.siniestro[0].detractor*100)))+"%</spam></p> \
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASEGURADORA</spam>  Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[1].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[1].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[1].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[1].promoter*100)-(respuesta.siniestro[1].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASESORIA</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[2].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[2].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[2].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[2].promoter*100)-(respuesta.siniestro[2].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  GESTOR</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.siniestro[3].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.siniestro[3].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.siniestro[3].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.siniestro[3].promoter*100)-(respuesta.siniestro[3].detractor*100)))+"%</spam></p>";                 
       }
       //nps clientes nuevos
       if(respuesta.cadena[0].tipoencuesta == 2)
       {
       
      
       divClientenuevo.innerHTML = "<p class= 'siniestros'> NPS Cliente Nuevo</p> \
       <p class= 'siniestros'><spam class= 'encabezanps'> TIEMPOS</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[0].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[0].promoter*100)-(respuesta.clientenuevo[0].detractor*100)))+"%</spam></p> \
         <p class= 'siniestros'><spam class= 'encabezanps'>  ASEGURADORA</spam>  Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[1].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[1].promoter*100)-(respuesta.clientenuevo[1].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  PROFESIONALISMO</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[2].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[2].promoter*100)-(respuesta.clientenuevo[2].detractor*100)))+"%</spam></p>\
         <p class= 'siniestros'><spam class= 'encabezanps'>  NIVEL DE CONFIANZA</spam>   Promotores= <spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].promoter)*100+"%</spam> Detractores=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].detractor)*100+"%</spam> Pasivos=<spam class= 'number-siniestro'> "+(respuesta.clientenuevo[3].pasivo)*100+"%</spam> \
         NPS =<spam class= 'number-siniestro'> "+(((respuesta.clientenuevo[3].promoter*100)-(respuesta.clientenuevo[3].detractor*100)))+"%</spam></p>";                 
       }
      }   
            //peronas evaluadas
        /*let table='<table class="table"><thead><tr><th>Persona</th><th>Contacto</th><tr></thead><tbody><tr><td colspan="2">DETRACTORES</td></tr>';
        respuesta.personasDetractoras.forEach(p=>{table+=`<tr><td>${p.usuario}</td><td>${p.email}</td></tr>`})
        table+='</tbody></table>';
        document.getElementById('detractoresDiv').innerHTML=table;
       console.log(respuesta.personasDetractoras);    */
     }
     xhr.send(datos);  
    }
 
}

 /********************************************************* */
function encuestaActivas(e) //Modificado* [2024-01-04]
{
  e.preventDefault();
  //console.log('aqi');
  var xhr = new XMLHttpRequest();
   var datos = new FormData();
   //datos.append('strvalor',tipo);
   xhr.open('POST',"<?php echo base_url();?>encuesta/encuestasActivas",true);
    xhr.onload = function()
    {
      if(this.status===200)
     {       
      var respuesta =JSON.parse(xhr.responseText);
      var lis = document.querySelectorAll('#ullistaEcuestas li'); 
      for(var i=0; li=lis[i]; i++) { 
        li.parentNode.removeChild(li); 
      } 
      for(let i = 0; i < respuesta.length; i++) {
        if(respuesta[i].tipo == 1)
        {
          $("#ullistaEcuestas").append("<li  id= '"+respuesta[i].idcabencuesta+"'> <div class = 'encuestasActivas'><p>"+respuesta[i].fecha +" --- "+respuesta[i].descripcion+"</p><a class='btn-modalEnc nps'>NPS</a></div></li>");
        }                 
        if(respuesta[i].tipo == 2)
        {
          $("#ullistaEcuestas").append("<li  id= '"+respuesta[i].idcabencuesta+"'> <div class = 'encuestasActivas'><p>"+respuesta[i].fecha +" --- "+respuesta[i].descripcion+"</p><a class='btn-modalEnc uno'>1..10</a></div></li>");
        } 
        if(respuesta[i].tipo == 3)
        {
          $("#ullistaEcuestas").append("<li  id= '"+respuesta[i].idcabencuesta+"'> <div class = 'encuestasActivas'><p>"+respuesta[i].fecha +" --- "+respuesta[i].descripcion+"</p><a class='btn-modalEnc verdad'>V o F</a></div></li>");
        } 
      }                 
                       
    
       $(".modalEncuestas").fadeIn();
     }   
    }
    xhr.send(datos);  
 
}
 /********************************************************* */
 function cierramodalEncuestas()
 {
  $(".modalEncuestas").fadeOut();
 }
 /********************************************************* */
function Confirma(dato)
 { 
   /*if (dato == '1') {
  alert("Se ha guardado Correctamente!");
   }
   //Detectamos si el usuario denegó el mensaje
  else {
   alert("Usted No Tiene Encuesta");
   }*/
 
 }
</script>


<script type="text/javascript">
function traerOperativo(datos)
{
if(datos!=''){
let option='';
cantDatos=datos.length;
 for(let i=0;i<cantDatos;i++){
  option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';
 }
 document.getElementById('selectPersona').innerHTML=option;
}
else{
  if(document.getElementById('selectTipoPersona').value=='Operativo'){
  peticionGetAJAX('crmproyecto/devolverOperativos/','','traerOperativo');
   }
   if(document.getElementById('selectTipoPersona').value=='Agente'){console
    peticionGetAJAX('crmproyecto/devolverAgentes/','','traerOperativo');
   }
}

}
function peticionGetAJAX(controlador,parametros,funcion){

  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
//abreCierraEspera();
 req.open('POST', url, true);
 
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);

         switch(funcion){
          case 'traeAgentes':traeAgentes(respuesta);break;
          case 'traerOperativo':traerOperativo(respuesta);break;
         }                                                           
      }     
   }
  }
 req.send();
}
function filtraPorDescripcion(valor)
{
  let table=document.getElementById('bodyMiTabla');
  let rows=table.rows.length;
  if(valor==''){  for(let i=0;i<rows;i++){table.rows[i].classList.remove('ocultarObjeto'); }}
  else{
  for(let i=0;i<rows;i++)
  {
    if(table.rows[i].getAttribute('data-id')==valor){table.rows[i].classList.remove('ocultarObjeto'); }
    else{table.rows[i].classList.add('ocultarObjeto');}
  }
  }

}


function exportarExcel(tipo){ //Modificado* [2024-01-02]
    var tablaActual = "";
    var nameTable = "";
    let refDoc = "";

    if (tipo == "1") {
      tablaActual = document.querySelector('#tableReport2');
      nameTable = `Reporte <?=date('Y-m-d H:i:s')?>`;
    }
    else if (tipo == "2") {
      tablaActual = document.querySelector('#tableReportTestComplete2');
      nameTable = `ReporteG <?=date('Y-m-d H:i:s')?>`;
    }
    else if (tipo == "3") {
      tablaActual = document.querySelector('#tableReportTestUser');
      nameTable = `Resultados <?=date('Y-m-d H:i:s')?>`;
    }

    let tableExport = new TableExport(tablaActual, {
        exportButtons: false, // No queremos botones
        filename: nameTable, //Nombre del archivo de Excel
        sheetname: nameTable, //Tí­tulo de la hoja
    });
    let datos = tableExport.getExportData();
    //console.log(datos);
    if (tipo == "1") {
      refDoc = datos.tableReport2.csv;
    }
    else if (tipo == "2") { //El formato CSV lee bien los datos que contienen string y number
      refDoc = datos.tableReportTestComplete2.xlsx;
    }
    else if (tipo == "3") {
      refDoc = datos.tableReportTestUser.csv;
    }
    //console.log(refDoc);
    tableExport.export2file(refDoc.data,refDoc.mimeType,refDoc.filename,refDoc.fileExtension,refDoc.merges,refDoc.RTL,refDoc.sheetname);
}



</script>