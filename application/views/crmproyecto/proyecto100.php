<?php
$this->load->view('headers/header');
$this->load->view('headers/menu');


//Miguel Jaime 15/02/2023

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


//**************************************************************
?>
<style type="text/css">
  .modal {
    background-color: rgba(0, 0, 0, 0);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1500;
  }

  .menuSeleccionado {
    background-color: #7ae593
  }
</style>
<div id="divContenedor">
  <div id="divMenu">
    <div><button class="btn btn-primary" onclick="muestraMenu()">&#127915</button></div>
    <div>
      <div>
        <button id="agregarProspectoBTN"
          style="background-image:url(<?php echo (base_url() . 'assets/images/crm/alta.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;"
          class="buttonMenu"
          onclick="cargarPagina('crmproyecto/agregarProspecto',this)">
        </button>

      </div>
      <div>
        <button id="seguimientoProspectoBTN"
          style="background-image:url(<?php echo (base_url() . 'assets/images/crm/seguimientoProspecccion.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;"
          class="buttonMenu"
          onclick="cargarPagina('crmproyecto/seguimientoProspecto',this)">
        </button>
      </div>
      <!--Ultima actualizacion Miguel Jaime 05/10/2020-->
      <!-- <div>
				<button id="agendaCitasAsesoresBTN" 
					style="background-image:url(<?php echo (base_url() . 'assets/images/crm/asesores_Online.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu" 
					onclick="cargarPagina('crmproyecto/agenda_citas_asesores',this)"
				>
				</button>
			</div> -->
      <!--*** fin ****-->
      <div>
        <button
          style="background-image:url(<?php echo (base_url() . 'assets/images/crm/administracionProspectos.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;"
          class="buttonMenu"
          onclick="cargarPagina('crmproyecto/Reportes',this)">
        </button>
      </div>
      <div>
        <button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/reporte.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/reporteComercial',this)">
        </button>
      </div>
      <div>
        <button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/puntosGenerados.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/Estadistica',this)">
        </button>
      </div>
      <div>
        <button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/funnel.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('funnel',this)">
        </button>
      </div>
      <div><!-- Creado [Suemy][2024-06-26] -->
        <button class="buttonMenu btn-icon-buttonMenu" onclick="cargarPagina('crmproyecto/reportes_ventas',this)"><i class="fa fa-university" aria-hidden="true"></i><span style="font-size: 1.5rem">Ventas</span>
        </button>
      </div>
      <div>
        <?php
        $usuario = $this->tank_auth->get_usermail();
        if ($usuario == 'SISTEMAS@ASESORESCAPITAL.COM' || $usuario == 'DIRECTORGENERAL@AGENTECAPITAL.COM'  || $usuario == 'COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX' || $usuario == 'CCO@AGENTECAPITAL.COM' || $usuario == 'COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM' || $usuario == 'SERVICIOSESPECIALES@AGENTECAPITAL.COM') {
        ?>
          <div><button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/reasignaAgente.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="traeAgentes('')"></button></div>
          <div><button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/reasignaOperativo.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="traeOperativos('')"></button></div>
          <div><button style="background-image:url(<?php echo (base_url() . 'assets/images/crm/reasignados.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/verReasignados')"></button></div>
        <?php } ?>

      </div>
    </div>
  </div>
  <div id="divContenido">
  </div>
</div>
</div>
<div id="divModalGenerico" class="modalCierra">
  <div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;width: 50px">X</button>

  </div>
  <div id="divModalContenidoGenerico" class="modal-contenido"></div>
</div>

<div id="miModal" class="modalCierra">
  <div id="Modalcontenido" class="modal-contenido">
    <table border="2" style="position:relative; top:10px; left:0px">
      <tr>
        <td><button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button>
        <td>
      </tr>
      <tr>
        <td>
          <p>Titulo: <input type="text" id="tituloCita" autocomplete="off"></p>
        </td>
      </tr>
      <tr>
        <td>
          <p>Date: <input type="text" id="dpCita" autocomplete="off"></p>
        </td>
      </tr>
      <tr>
        <td>
          <p>De: <select id="selFecIniCita">
              <?php
              $inicio = 8;
              for ($i = 0; $i < 12; $i++) {
                echo ('<option>' . $inicio . ':00</option>');
                echo ('<option>' . $inicio . ':30</option>');
                $inicio++;
              }

              ?>
            </select>
            A:<select id="selFecFinCita">
              <?php
              $inicio = 8;
              for ($i = 0; $i < 12; $i++) {
                echo ('<option>' . $inicio . ':00</option>');
                echo ('<option>' . $inicio . ':30</option>');
                $inicio++;
              }


              ?>
            </select>
            <button onclick="guardaCita()" class="btn btn-primary">Guardar Cita</button>
        </td>
      </tr>
      <tr>
        <td>
          <div id='calendar'></div>

        </td>
      </tr>
    </table>
  </div>
</div>

<!--Nuevo Modal MJ 15-02-2023-->

<div id="modalGrafico" class="modal" role="dialog">
  <div class="modal-dialog" role="document">
    <!-- Modal content-->
    <div class="modal-content" style="width:200%;margin-left:-50%;height: auto;">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-chart"></i>&nbsp;Grafico Estadistico de Perfilamiento</h4>
        <button type="button" class="btn btn-warning" data-dismiss="modal" style="color: #fff;"><i class="fa fa-times-circle"></i> Cerrar</button>
      </div>
      <div class="modal-body">
        <div id="usuario_grafico"></div>

        <div style="height: 400px;overflow-y: auto;overflow-x: hidden;" class="flotante">

          <div class="panel panel-default">
            <div class="row">
              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartEdoCivil"></canvas>
                </div>
              </div>

              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartRango"></canvas>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="panel panel-default">
            <div class="row">
              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartOcupacion"></canvas>
                </div>
              </div>

              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartFuente"></canvas>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="panel panel-default">
            <div class="row">
              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartHabilidadesReferencia"></canvas>
                </div>
              </div>

              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartIngresoMensual"></canvas>
                </div>
              </div>
            </div>
          </div>

          <br>

          <div class="panel panel-default">
            <div class="row">
              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartPosibilidad"></canvas>
                </div>
              </div>

              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartBantAuthorithy"></canvas>
                </div>
              </div>
            </div>
          </div>


          <br>

          <div class="panel panel-default">
            <div class="row">
              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartBantNeed"></canvas>
                </div>
              </div>

              <div class="col-6">
                <div id="grafico" style="width: 100%;height:auto;padding: 1%;">
                  <canvas id="chartBantTiming"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div><!--Flotante-->

      </div>

    </div>

  </div>
</div>

<div><img id="imgEspera" src="<?php echo (base_url() . 'assets/img/loading.gif'); ?>" class="divEspera ocultarObjeto"></div>

<!-- modal prospeccion-->
<div id="generar" class="modal" role="dialog" data-backdrop="false">
  <div class="modal-dialog" style="font-size: 12px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: -60%; width: 1100px;">
      <div class="modal-header">
        <h4 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Prospección</h4>
        <div style="text-align: right;width: 100%;"><button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar
          </button></div>
      </div>
      <div class="modal-body">
        <br>
        <div id="divDetalleProspectos"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


<!-- modal Prima-->
<div id="divPrimaMinima" class="modal" role="dialog">
  <div class="modal-dialog" style="font-size: 12px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 10%; width: 400px;">
      <div class="modal-header">
        <h6 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Modificación de Prima Minima</h6>
        <div style="text-align: right;width: 100%;"><button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar
          </button></div>
      </div>
      <div class="modal-body">
        <form name="frm_prima" id="frm_prima" action="<?php echo base_url() ?>crmproyecto/guardar_prima_minima" method="post">
          <div style="float: left;">
            <input type="text" name="txtprimaMinima" id="txtprimaMinima" class="form-control" style="width:200px;text-align: right;">
          </div>
          <div>
            <button type="button" name="btn_guardar_prima" class="btn btn-primary btn-md" onclick="validacionPrimaMinima()"><i class="fa fa-file"></i>&nbsp;Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- modal Buro-->
<div id="divBuro" class="modal" role="dialog">
  <div class="modal-dialog" style="font-size: 12px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 10%; width: 400px;">
      <div class="modal-header">
        <h6 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Modificación de Costo Buro</h6>
        <div style="text-align: right;width: 100%;"><button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar
          </button></div>
      </div>
      <div class="modal-body">
        <form name="frm_buro" id="frm_buro" action="<?php echo base_url() ?>crmproyecto/guardar_buro" method="post">
          <div>
            <table>
              <tr>
                <td>Costo Persona Moral:&nbsp;</td>
                <td><input type="text" class="form-control" name="txtMoral" id="txtMoral" style="text-align: right;"></td>
              </tr>
              <tr>
                <td>Costo Persona Fisica:&nbsp;</td>
                <td><input type="text" class="form-control" name="txtFisica" id="txtFisica" style="text-align: right;"></td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" name="btn_guardar_buro" class="btn btn-primary btn-md" onclick="validacionBuro()"><i class="fa fa-file"></i>&nbsp;Guardar</button>
                </td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal Porcentajes de afianzadora-->
<div id="divPor" class="modal" role="dialog">
  <div class="modal-dialog" style="font-size: 12px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 10%; width: 400px;">
      <div class="modal-header">
        <h6 class="modal-title" style="color: #fff;">
          <i class="fa fa-details"></i>
          &nbsp;Modificación de Porcentaje Afianzar
        </h6>
        <div style="text-align: right;width: 100%;">
          <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar
          </button>
        </div>
      </div>
      <div class="modal-body">
        <form name="frm_por" id="frm_por" action="<?php echo base_url() ?>crmproyecto/guardar_porcentajes" method="post">
          <div style="float: left;">

            <table>
              <tr>
                <td width="40%"><label>SOFIMEX</label></td>
                <td width="50%">
                  <input type="text" name="txtpor1_edit" id="txtpor1_edit" class="form-control" style="width:150px;text-align: right;">
                </td>
                <td><b>&nbsp;%</b></td>
              </tr>
              <tr>
                <td><label>LIBERTY</label></td>
                <td>
                  <input type="text" name="txtpor2_edit" id="txtpor2_edit" class="form-control" style="width:150px;text-align: right;">
                </td>
                <td><b>&nbsp;%</b></td>
              </tr>

              <tr>
                <td><label>CHUBB</label></td>
                <td><input type="text" name="txtpor3_edit" id="txtpor3_edit" class="form-control" style="width:150px;text-align: right;">
                <td><b>&nbsp;%</b></td>
              </tr>

              <tr>
                <td><label>TOKIO/ASERTA/INSURGENTES</label></td>
                <td><input type="text" name="txtpor4_edit" id="txtpor4_edit" class="form-control" style="width:150px;text-align: right;">
                </td>
                <td><b>&nbsp;%</b></td>
              </tr>

              <tr>
                <td><label>BERKLEY</label></td>
                <td>
                  <input type="text" name="txtpor5_edit" id="txtpor5_edit" class="form-control" style="width:150px;text-align: right;">
                </td>
                <td><b>&nbsp;%</b></td>
              </tr>

              <tr>
                <td><label>--</label></td>
                <td>
                  <input type="text" name="txtpor6_edit" id="txtpor6_edit" class="form-control" style="width:150px;text-align: right;">
                </td>
                <td><b>&nbsp;%</b></td>
              </tr>

              <tr>
                <td colspan="2">
                  <button type="button" name="btn_guardar_prima" class="btn btn-primary btn-md" onclick="validacionPorcentajes()"><i class="fa fa-file"></i>&nbsp;Guardar</button>
                </td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- modal Afianzadora-->
<div id="divAfianzadora" class="modal" role="dialog">
  <div class="modal-dialog" style="font-size: 12px;">
    <!-- Modal content-->
    <div class="modal-content" style="margin-left: 10%; width: 400px;">
      <div class="modal-header">
        <h6 class="modal-title" style="color: #fff;"><i class="fa fa-details"></i>&nbsp;Modificar Gastos Exp. de Afianzadoras</h6>
        <div style="text-align: right;width: 100%;"><button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Cerrar
          </button></div>
      </div>
      <div class="modal-body">
        <form name="frm_afianzadora" id="frm_afianzadora" action="<?php echo base_url() ?>crmproyecto/guardar_afianzadora" method="post">
          <div>
            <table>
              <tr>
                <td>SOFIMEX:&nbsp;</td>
                <td><input type="text" class="form-control" name="txtsofimex" id="txtsofimex" style="text-align: right;"></td>
              </tr>
              <tr>
                <td>LIBERTY:&nbsp;</td>
                <td><input type="text" class="form-control" name="txtliberty" id="txtliberty" style="text-align: right;"></td>
              </tr>
              <tr>
                <td>TOKYO/ASERTA/INSURGENTES:&nbsp;</td>
                <td><input type="text" class="form-control" name="txttokyo" id="txttokyo" style="text-align: right;"></td>
              </tr>
              <tr>
                <td>BERKLEY:&nbsp;</td>
                <td><input type="text" class="form-control" name="txtberkley" id="txtberkley" style="text-align: right;"></td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="button" name="btn_guardar_afianzadora" class="btn btn-primary btn-md" onclick="validacionAfianzadora()"><i class="fa fa-file"></i>&nbsp;Guardar</button>
                </td>
              </tr>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Indicadores -->
<div class="modal fade indicators-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Detalles de Indicadores</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
        <div class="col-md-12">
          <h5 class="titleSection title-table" id="modalSubTitleIndicators"></h5>
          <hr class="title-hr">
          <div class="col-md-12 pd-left pd-right" id="container-tab-indicator"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php //$this->load->view('footers/footerSinSegurin'); 
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/iconos.css">
<!-- <link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.css' rel="stylesheet"> -->
☺<!-- <link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'> -->
<!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-table-style.css">
<style type="text/css">
  /*ID*/
  #cont-nav-indicator input.search-input {
    max-width: 30%
  }

  #cont-nav-indicator table {
    font-size: 12px;
  }

  /*Modals*/
  .modal-dialog {
    margin: 20px auto;
  }

  /*Containers*/
  .container-table-tab-indicator {
    height: 320px;
    overflow: auto;
    /* border: 1px solid #dbdbdb; */
    padding: 0px;
    max-width: 715px;
  }

  /*Bottons*/
  button.btn-icon-buttonMenu {
    color: #510d67;
    font-size: 5.5rem;
  }

  /*Tables*/
  tbody>tr>td.indicator,
  tbody>tr>td.indicator2 {
    border-top: 1px solid #ffffff;
  }

  .container-table-tab-indicator table>thead>tr>th:nth-child(9) {
    min-width: 150px;
  }

  /*Others*/
  .indicator {
    background: #e5f1ff;
  }

  .indicator2 {
    background: #ffe5e5;
  }

  /**/
  .input-small>.input-group-append>.btn.btn-secondary {
    height: 30px;
  }

  @media (max-width: 750px) {
    .boton {
      min-height: 85px;
    }

    .boton>div>img {
      width: 60%;
    }

    .img-menu {
      height: 42px;
    }

    .btn {
      margin-bottom: 0px;
    }

    #cont-nav-indicator input.search-input {
      max-width: 60%
    }

    .indicators-modal .modal-body>.col-md-12 {
      padding: 0px;
    }

    .container-table-tab-indicator {
      max-width: 345px;
    }

    .modal-dialog {
      margin: 20px 10px;
    }

    .column-flex-bottom {
      flex-wrap: wrap;
    }
  }
</style>

<!-- <script src='<?php echo base_url(); ?>assets/fullcalendar/lib/moment.min.js'></script> -->
<!-- <script src='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.js'></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>-->
<!-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --> <!-- Dennis Castillo [2021-10-31] -->
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> Ojo Complemeto en Conflicto con easytree -->
<!-- <script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

<script type="text/javascript">
  var contienePrspectoTD = "";
  var nunRow = "";
  var refrescadoGlobal = '';

  function verificarPago(datos, folioActividad, IDCli, objeto) {
    if (datos == '') {
      var parametros = "?";
      contienePrspectoTD = objeto.parentNode.parentNode;
      parametros = parametros + 'folioActividad=' + folioActividad + '&IDCli=' + IDCli;
      peticionAJAX('crmproyecto/verificarPago/', parametros, 'verificarPago');
    } else {
      if (datos.Documento != '') {
        var insertar = "";
        if (datos.pagado == 1) {
          insertar = '<a class="btn btn-primary btn-xs contact-item" href="<?= base_url() ?>crmproyecto/muestraRecibos?Documento=' + datos.Documento + '" target="_blank">Recibos<span class="badge">✔</span></a> ';
          contienePrspectoTD.innerHTML = insertar;
        } else {
          insertar = '<div class="btn-group" style="overflow: all;width: 200px"><button class="btn btn-primary btn-xs contact-item" onclick="verificarPago(\'\',\'' + datos.folioActividad + '\',' + datos.IDCli + ',this)">Verificar pago</button>';
          insertar = insertar + '<a class="btn btn-primary btn-xs contact-item" href="<?= base_url() ?>crmproyecto/muestraRecibos?Documento=' + datos.Documento + '" target="_blank">Recibos<span class="badge">X</span></a> </div>';
          contienePrspectoTD.innerHTML = insertar;
        }

      }
      abreCierraEspera();
      alert(datos.mensaje);
      // alert(datos.mensaje);
      // document.getElementById('tablaActivacion').deleteRow(numRow);
      //cargarPagina('crmproyecto/Reportes');
    }
  }

  function activarEnPausa(datos, IDCli, row) {
    if (datos == '') {
      var parametros = "?";
      parametros = parametros + 'IDCli=' + IDCli;
      numRow = row.parentNode.parentNode.rowIndex;
      peticionAJAX('crmproyecto/activarEnPausa/', parametros, 'activarEnPausa');

    } else {
      // alert(datos.mensaje);
      document.getElementById('tablaActivacion').deleteRow(numRow);
      abreCierraEspera()
      cargarPagina('crmproyecto/Reportes');
    }

  }

  function guardarSuspension(datos, idCliente) {
    if (datos == '') {
      var fecha = document.getElementById('fechaPospuesto').value;
      var parametros = "?";
      parametros = parametros + 'IDCli=' + idCliente + '&fechaPospuesto=' + fecha;
      peticionAJAX('crmproyecto/suspenderCliente/', parametros, 'guardarSuspension');

    } else {
      //alert(datos.mensaje);
      cargarPagina('crmproyecto/Reportes');
      abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    }

  }

  function pantallaSuspension(idCliente, fecha) {
    var cadena = "";
    cadena = cadena + '<label>Fecha de recordatorio:</label><input type="text" id="fechaPospuesto" class="fecha form-control" value="' + fecha + '">';
    cadena = cadena + '<button class="btn btn-success" onclick="guardarSuspension(\'\',' + idCliente + ')">Guardar</button>';
    cadena = cadena + '<button class="btn btn-danger" onclick="cerrarModal(\'divModalGenerico\')">Cancelar</button>';
    document.getElementById('divModalContenidoGenerico').innerHTML = cadena;
    llamarDate();
    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
    document.getElementById('divModalGenerico').classList.toggle('modalAbre');
  }

  function guardaPerfilProspecto(datos) {
    if (datos != '') {
      alert(datos.respuesta);
      contienePrspectoTD.innerHTML = 'Perfilado';
      abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    } else {
      var formulario = document.getElementById('formProspecto');
      var cant = formulario.length;
      var parametros = "?";
      for (var i = 0; i < cant; i++) {
        parametros = parametros + formulario[i].name + "=" + formulario[i].value + "&";
      }
      peticionAJAX('crmproyecto/insertaPerfilado/', parametros, 'guardaPerfilProspecto');
    }

  }

  function perfilarProspecto(objeto, idProspecto) {
    contienePrspectoTD = objeto.parentNode;
    var form = '<div style="padding:3%;width:1	00%;height:750px;overflow:scroll"><form id="formProspecto" method="post" class="formProspecto" action="<?= base_url() . 'crmproyecto/InsertaPerfilado' ?>"><div class="perfilarProspecto"><label>Fuente de Prospecto</label><select name="fuente" id="fuente" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="AMIGODEESCUELA">Amigos de la Escuela</option><option value="AMIGODEFAMILIA">Amigos de la Familia</option><option value="VECINOS">Vecinos</option><option value="CONOCIDOPASATIEMPOS">Conocidos a traves de Pasatiempos</option><option value="FAMPROPIAOCONYUGUE">Familia Propia o Conyugue</option><option value="CONOCIDOGRUPOSOCIAL">Conocidos atraves de los grupos sociales</option><option value="CONOCIDOACTIVICOMUNIDAD">Conocidos por la actividad de la comunidad</option><option value="CONOCIDOANTIGUOEMPLEO">Conocidos de Antiguos Empleos</option><option value="PERSONASHACENEGOCIO">Personas con las que hace negocios</option><option value="CENTRODEINFLUENCIA">Centro de Influencia</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Ingreso Mensual</label><select name="IngMen" id="IngMen" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MENOSDE$25000">Menos de $25000</option><option value="DE$25000A$60000">de $25000 a $60000</option><option value="DE$6000A$100000">de $60000 a $100000</option><option value="MASDE$100000">Mas de $100000</option></select></div>';
    form += '<div class="perfilarProspecto"> <label>Rango de edad</label><select name="RangoEdad" id="RangoEdad" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MENOSDE18">Menos de 18</option><option value="DE19A35">de 19 a 35</option><option value="DE36A50">de 36 a 50</option><option value="DE51A65">de 51 a 65</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Ocupacion</label><select name="ocupacion" id="ocupacion" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="AMADECASA">Ama de Casa</option><option value="EJECUTIVO">Ejecutivo</option><option value="EMPLEADO">Empleado</option><option value="ESTUDIANTE">Estudiante</option><option value="EMPRESARIO">Empresario</option><option value="GERENTE">Gerente</option><option value="NEGOCIOPROPIO">Negocio Propio</option><option value="PROFESIONISTAINDEPENDIENTE">Profesionista Independiente</option><option value="RETIRADO">Retirado</option><option value="OTROSEMPLEOS">Otros Empleos</option></select></div>';
    form += '<div class="perfilarProspecto"> <label>Estado Civil</label><select name="estadocivil" id="estadocivil" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="CASADO">Casado</option><option value="CASADOCONHIJOS">Casado con hijos</option><option value="DIVORCIADOS">Divorciado</option><option value="DIVORCIADOSCONHIJOS">Divorciado con hijos </option><option value="SOLTERO">Soltero</option><option value="SOLTEROCONHIJOS">Soltero con hijos</option><option value="UNIONLIBRE">Union Libre</option><option value="UNIONLIBRECONHIJOS">Union Libre con hijos</option><option value="VIUDO">Viudo</option><option value="VIUDOCONHIJOS">Viudo con hijos</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Tiempo de Conocer los Prospectos</label><select name="tiempoconocer" id="tiempoconocer" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MASDE5ANIOS">Mas de 5 Años</option><option value="DE2A5ANIOS">de 2 a 5 Años</option><option value="MENOSDE2ANIOS">Menos de 2 años</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Frecuencia que lo vio(ulitmo 12 meses)</label><select name="frecuenciavio" id="frecuenciavio" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MASDE5VECES">Mas de 5 Veces</option><option value="DE3A5VECES">de 3 a 5 Veces</option><option value="DE1A2VECES">de 1 a 2 Veces</option><option value="NOLOVIO">No lo vio</option></select></div>';
    form += '<div class="perfilarProspecto"> <label>Posibilidad de Acercamiento</label><select name="posacercamiento" id="posacercamiento" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="FACILMENTE">Facilmente</option><option value="NOMUYFACIL">No muy Facil</option><option value="CONDIFICULTAD">Con Dificultad</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Habilidad para dar Referencias</label><select name="habilidadref" id="habilidadref" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="EXCELENTE">Excelente</option><option value="BUENA">Buena</option><option value="REGULAR">Regular</option></select></div>';

    //Modificacion MJ 07-02-2023
    form += '<div class="perfilarProspecto"><label><strong>BANT</strong></label></div>';
    form += '<div class="perfilarProspecto"><label>Authorithy (Que nivel de autoridad tiene el prospecto)</label><select name="bant_aut" id="bant_aut" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Need (Qué nivel de urgencia tiene)</label><select name="bant_need" id="bant_need" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="1">1</option><option value="2">2</option><option value="3">3</option></select></div>';
    form += '<div class="perfilarProspecto"><label>Timing (Para cuando lo necesita)</label><select name="bant_timing" id="bant_timing" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="Inmediato">Inmediato</option><option value="Sin urgencia">Sin urgencia</option><option value="Largo plazo">Largo plazo</option></select></div>';


    form += '<div class="perfilarProspecto"><input type="hidden" name="IDCL" value="' + idProspecto + '"></form></div><button class="btn btn-success" onclick="guardaPerfilProspecto(\'\')">Aceptar</button><button class="btn btn-danger" onclick="perfilarProspecto(-1)">Cancelar</button></div>';

    document.getElementById('divModalContenidoGenerico').innerHTML = form;
    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
    document.getElementById('divModalGenerico').classList.toggle('modalAbre');
  }




  function verDetalle(objeto, rfc, razon, nombre, apellidop, apellidom, email, telefono, fecha, estado, observacion) {
    contienePrspectoTD = objeto.parentNode;
    var form = '<div style="padding:3%;width:100%;height:600px;overflow:scroll"><table style="width:70%;"><tr><td colspan="2"><h3>DETALLE DE PROSPECTO</h3></td></tr><tr><td>Estado Actual:</td><td>' + estado + '</td></tr><tr><td><label>RFC:</label></td><td>' + rfc + '</td></tr><tr><td><label>Razon Social:</label></td><td>' + razon + '</td></tr><tr><td>Apellido Paterno: </td><td>' + apellidop + '</td></tr><tr><td>Apellido Materno: </td><td>' + apellidom + '</td></tr><tr><td>Nombre: </td><td>' + nombre + '</td></tr><tr><td>Email: </td><td>' + email + '</td></tr><tr><td>Telefono: </td><td>' + telefono + '</td></tr><tr><td>Fecha: </td><td>' + fecha + '</td></tr><tr><td>Observaciónes:</td><td>' + observacion + '</td></tr></table></div>';
    document.getElementById('divModalContenidoGenerico').innerHTML = form;
    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
    document.getElementById('divModalGenerico').classList.toggle('modalAbre');
  }




  //----------------------------------------			
  function traeFunnelCoordinadores(datos) {
    cargarPagina("funnel/?idCoordinador=" + document.getElementById('selectPersonaCoordinador').value);
  }

  //----------------------------------------
  function traeFunnelAgentes(datos) {

    if (document.getElementById('selectAgentes').value > 0) {
      cargarPagina("funnel/?idCoordinador=" + document.getElementById('selectPersonaCoordinador').value + "&idAgente=" + document.getElementById('selectAgentes').value);
    } else {
      cargarPagina("funnel/?idCoordinador=" + document.getElementById('selectPersonaCoordinador').value);
    }
  }

  //----------------------------------------
  function traeAgentes(datos) {
    if (datos != '') {
      var select = '<div>Agentes</div><div><select class="form-control" id="selectPersona">';
      cantidad = datos.length;
      for (var i = 0; i < cantidad; i++) {
        select = select + '<option value="' + datos[i].idPersona + '">' + datos[i].nombre + '</option>';
      }
      select = select + '</select></div>';
      select = select + '<button class="btn-primary" onclick="transferirProspectos(\'\')">Transferir prospecto</button>';
      document.getElementById('divModalContenidoGenerico').innerHTML = select;
      abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');

    } else {
      peticionAJAX('crmproyecto/devolverAgentes/', '', 'traeAgentes');
    }


  }

  //----------------------------------------
  function traeOperativos(datos) {
    if (datos != '') {
      var select = '<div>Operativos</div><div><select class="form-control" id="selectPersona">';
      cantidad = datos.length;
      for (var i = 0; i < cantidad; i++) {
        select = select + '<option value="' + datos[i].idPersona + '">' + datos[i].nombre + '</option>';
      }
      select = select + '</select></div>';
      select = select + '<button class="btn-primary" onclick="transferirProspectos(\'\')">Transferir prospecto</button>';
      document.getElementById('divModalContenidoGenerico').innerHTML = select;
      abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    } else {
      peticionAJAX('crmproyecto/devolverOperativos/', '', 'traeOperativos');
    }
  }

  //----------------------------------------
  function transferirProspectos(datos) {

    if (datos != '') {
      alert(datos);
      abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
      cargarPagina('crmproyecto/seguimientoProspecto');
    } else {
      var elementos = document.getElementsByClassName('cbReasignar');
      var cantidad = elementos.length;
      idCliente = "";
      for (var i = 0; i < cantidad; i++) {
        if (elementos[i].checked) {
          (idCliente = idCliente + elementos[i].value + '-');
        }
      }
      var parametros = '?idCliente=' + idCliente + '&idPersona=' + document.getElementById('selectPersona').value;
      peticionAJAX('crmproyecto/transfiereProspectos/', parametros, 'transferirProspectos');
    }
  }

  //----------------------------------------
  function buscarProspectosEmitidos(datos) {
    if (datos == '') {
      var parametros = "?";
      parametros = parametros + 'fInicial=' + document.getElementById('fInicialProspectoEmitido').value + '&fFinal=' + document.getElementById('fFinalProspectoEmitido').value;
      if (document.getElementById('selectVendedorProspectoPersona').value != '') {
        parametros += '&email=' + document.getElementById('selectVendedorProspectoPersona').value
      }
      peticionAJAX('crmproyecto/buscarProspectosEmitidos/', parametros, 'buscarProspectosEmitidos');
    } else {
      let li = '';
      datos.informacion.forEach(info => {
        li += `<li>${info.ApellidoP} ${info.ApellidoM} (Documento: ${info.Documento} )</li>`;
      })
      document.getElementById('tdMuestraPropectosPagados').innerHTML = li;
    }
  }

  //----------------------------------------
  function peticionAJAX(controlador, parametros, funcion) {
    var req = new XMLHttpRequest();
    var direccionAJAX = "<?= base_url(); ?>";
    var url = direccionAJAX + controlador + parametros;
    abreCierraEspera();
    req.open('POST', url, true);
    req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    req.onreadystatechange = function(aEvt) {
      if (req.readyState == 4) {
        if (req.status == 200) {
          var respuesta = JSON.parse(this.responseText);

          switch (funcion) {
            case 'traeAgentes':
              traeAgentes(respuesta);
              break;
            case 'traeOperativos':
              traeOperativos(respuesta);
              break;
            case 'transferirProspectos':
              transferirProspectos(respuesta);
              break;
            case 'traeAgentesPorCoordinador':
              traeAgentesPorCoordinador(respuesta);
              break;
            case 'guardaPerfilProspecto':
              guardaPerfilProspecto(respuesta);
              break;
            case 'guardarSuspension':
              guardarSuspension(respuesta, '');
              break;
            case 'activarEnPausa':
              activarEnPausa(respuesta, '');
              break;
            case 'verificarPago':
              verificarPago(respuesta, '', '');
              break;
            default:
              abreCierraEspera();
              window[funcion](respuesta);
              break;
          }
        }
      }
    };
    req.send();
  }

  //----------------------------------------
  function abreCierraEspera() {
    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    document.getElementById('imgEspera').classList.toggle('verObjeto');
  }

  //---------------------------------------
  function SendForm_JjHe() {
    var bandFalse = 0;
    var bandFalse = 1;
    /*POR EL MOMENTO NO VA A VALIDAR DATOS HASTA NUEVO AVISO*/
    if (bandFalse == 1) {
      var formulario = document.getElementById('formdimension');
      var nom = document.getElementById('nombre').value;
      var ap = document.getElementById('apellidop').value;
      var am = document.getElementById('apellidom').value;
      var raz = document.getElementById('razon').value;
      var rfc = document.getElementById('rfc').value;
      var ema = document.getElementById('email').value;
      var cel = document.getElementById('celular').value;
      var fNac = document.getElementById('fNac').value;
      var cp = document.getElementById('codigoPostal').value;
      let vend = 0;
      if (document.getElementById('selectProspectoPersona')) {
        if (document.getElementById('selectProspectoPersona').value) {
          vend = document.getElementById('selectProspectoPersona').value;
        }
      }
      if (document.getElementById('tipo2').checked || document.getElementById('tipo').checked) {
        /* Persona Moral */
        if (document.getElementById('tipo').checked) {
          if (raz != '' && rfc != '' && ema != '' && cel != '') {
            document.formdimension.submit();
          } else {
            alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');
          }
        }
        /* Persona Fisica */
        if (document.getElementById('tipo2').checked) {
          if (nom != '' && ap != '' && ema != '' && cel != '' && fNac != '' && cp != '') {
            document.formdimension.submit();
          } else {
            alert('No capturaste Nombre o Apellidos, Es Obligatorio Email, Telefono, Fecha de nacimiento y Codigo postal');
          }
        }
      } else {
        alert('Seleciona un tipo de persona')
      }

    } else {
      document.formdimension.submit();
    }
  }




  function SendForm_JjHe_generico() {
    var bandFalse = 0;
    /*POR EL MOMENTO NO VA A VALIDAR DATOS HASTA NUEVO AVISO*/
    if (bandFalse == 1) {
      var formulario = document.getElementById('formdimension_generico');
      var nom = document.getElementById('nombre_generico').value;
      var ap = document.getElementById('apellidop_generico').value;
      var am = document.getElementById('apellidom_generico').value;
      var raz = document.getElementById('razon_generico').value;
      var rfc = document.getElementById('rfc_generico').value;
      var ema = document.getElementById('email_generico').value;
      var cel = document.getElementById('celular_generico').value;
      let vend = 0;
      if (document.getElementById('selectProspectoGenerico').value) {
        vend = document.getElementById('selectProspectoGenerico').value;
      }

      /* Persona Moral */
      if (document.getElementById('tipo_generico').checked) {
        if (raz != '' && rfc != '' && ema != '' && cel != '') {
          document.formdimension_generico.submit();
        } else {
          alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');
        }
      }
      /* Persona Fisica */
      if (document.getElementById('tipo2_generico').checked) {
        if (nom != '' && ap != '' && ema != '' && cel != '') {
          document.formdimension_generico.submit();
        } else {
          alert('No capturaste Nombre o Apellidos, Es Obligatorio Email y Telefono');
        }
      }
    } else {
      document.formdimension_generico.submit();
    }
  }
</script>

<script>
  function guardaCita() {

    var formulario = document.createElement('form');
    formulario.setAttribute('method', 'post');
    formulario.action = <?php echo ('"' . base_url() . 'crmproyecto/guardaCita"'); ?>;
    var inputFI = document.createElement('input');
    inputFI.setAttribute('type', 'text');
    inputFI.setAttribute('name', 'fecIniCita');
    inputFI.value = document.getElementById('selFecIniCita').value;
    var inputFF = document.createElement('input');
    inputFF.setAttribute('type', 'text');
    inputFF.setAttribute('name', 'fecFinCita');
    inputFF.value = document.getElementById('selFecFinCita').value;
    var inputF = document.createElement('input');
    inputF.setAttribute('type', 'text');
    inputF.setAttribute('name', 'fecCita');
    inputF.value = document.getElementById('dpCita').value;
    var inputT = document.createElement('input');
    inputT.setAttribute('type', 'text');
    inputT.setAttribute('name', 'tituloCita');
    inputT.value = document.getElementById('tituloCita').value;
    var inputC = document.createElement('input');
    inputC.setAttribute('type', 'hidden');
    inputC.setAttribute('name', 'idClienteCita');
    inputC.value = "<?php echo ($idCliente); ?>";

    formulario.appendChild(inputFI);
    formulario.appendChild(inputFF);
    formulario.appendChild(inputF);
    formulario.appendChild(inputT);
    formulario.appendChild(inputC);
    document.body.appendChild(formulario);
    if (inputT.value == "" || inputF.value == "") {
      alert("Debe llevar titulo y fecha");
    } else {
      var fechaInicial = inputFI.value;
      fechaInicial = fechaInicial.replace(":", "");
      var fechaFinal = inputFF.value;
      fechaFinal = fechaFinal.replace(":", "");
      if (parseInt(fechaFinal) > parseInt(fechaInicial)) {
        formulario.submit();
      } else {
        alert("la fecha final debe ser mayor a la inicial")
      }
    }
  }

  //----------------------------------------
  function enviarArchivo(objeto) {
    objeto.setAttribute('name', objeto.id);
    var formulario = document.createElement('form');
    formulario.setAttribute('method', 'post');
    formulario.enctype = 'multipart/form-data';
    formulario.action = <?php echo ('"' . base_url() . 'crmproyecto/guardaArchivo"'); ?>;
    formulario.appendChild(objeto);
    document.body.appendChild(formulario);

    formulario.submit();
  }

  //----------------------------------------
  function verDocumentos(idProspecto) {
    var req = new XMLHttpRequest();
    req.open('GET', '<?= base_url() ?>crmproyecto/devuelveDocumentos/?idProspecto=' + idProspecto, true);
    req.onreadystatechange = function(aEvt) {
      document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
      document.getElementById('imgEspera').classList.toggle('verObjeto');
      if (document.getElementById("divVentanaDocumentos")) {
        document.head.removeChild(document.getElementById('divVentanaDocumentosEstilo'));
      }
      if (document.getElementById('divVentanaDocumentos')) {
        document.body.removeChild(document.getElementById('divVentanaDocumentos'));
      }
      if (req.readyState == 4) {
        if (req.status == 200) {
          var j = JSON.parse(this.responseText);
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
          document.getElementById('imgEspera').classList.toggle('verObjeto');
          if (j == 0) {
            alert("Este usuario no tiene documento");
          } else {
            var hoja = document.createElement('style');
            var div = document.createElement('div');
            div.id = "divVentanaDocumentos";
            div.innerHTML = j["datos"];
            hoja.id = "divVentanaDocumentosEstilo";
            hoja.type = "text/css";
            hoja.innerHTML = j['estilo'];
            document.head.appendChild(hoja);
            document.body.appendChild(div);
            document.getElementById("divVentanaDocumentos").classList.add('ventanaDocumentosEstilo');
          }
        }
      }
    };
    req.send();
  }

  //----------------------------------------
  function direccionAJAX(idProspecto, opcion) {
    var direccionAJAX = "<?php echo (base_url() . 'crmproyecto/'); ?>";
    switch (opcion) {
      case 'muestraDocumentos':
        direccionAJAX = direccionAJAX + 'devuelveDocumentos/?idProspecto=' + idProspecto;
        break;
      case 'muestraVentana':
        direccionAJAX = direccionAJAX + 'comentarios/?idProspecto=' + idProspecto + "&tipoCCC=0";
        break;
      case 'nuevoComentario':
        direccionAJAX = direccionAJAX + 'comentarios/?idProspecto=' + idProspecto + "&nuevoComentario=" + document.getElementById('textNuevoComentario').value + "&tipoCCC=0";
        break;
      case 'eliminaComentario':
        direccionAJAX = direccionAJAX + 'comentarios/?idProspecto=' + idProspecto + "&eliminaComentario=" + document.getElementById('textNuevoComentario').value + "&tipoCCC=0";
        break;
      case 'modificaComentario':
        direccionAJAX = direccionAJAX + 'comentarios/?idProspecto=' + idProspecto + "&modificaComentario=" + document.getElementById('comentario' + idProspecto).value + "&tipoCCC=0";
        break;
      case 'ventanaCCC':
        direccionAJAX = direccionAJAX + 'ventanaCitaContacto/?idProspecto=' + idProspecto;
        break;
      case 'guardarCCC':
        direccionAJAX = direccionAJAX + 'guardarContactoCita/?idProspecto=' + idProspecto + "&citaContacto=" + document.getElementById("dpCitaContacto").value + "&tipoCCC=" + document.getElementById("tipoCCC").value + "&selectFechaDeCC=" + document.getElementById("selectFechaDeCC").value + "&selectFechaACC=" + document.getElementById("selectFechaACC").value;
        refrescadoGlobal = 'guardarCCC';
        break;
      case 'modificaCCC':
        direccionAJAX = direccionAJAX + 'comentarios/?idProspecto=' + idProspecto + "&modificaComentario=" + document.getElementById('comentario' + idProspecto).value + "&tipoCCC=1";
        break;
    }

    conectaAJAX(direccionAJAX);
  }

  //----------------------------------------
  function conectaAJAX(direccionAJAX) {
    var req = new XMLHttpRequest();
    req.open('GET', direccionAJAX, true);
    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    document.getElementById('imgEspera').classList.toggle('verObjeto');
    req.onreadystatechange = function(aEvt) {
      if (req.readyState == 4) {
        if (req.status == 200) {
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
          document.getElementById('imgEspera').classList.toggle('verObjeto');
          if (document.getElementById("divVentanaComentarios")) {
            document.body.removeChild(document.getElementById('divVentanaComentarios'));
          }
          if (document.getElementById("divVentanaComentarioEstilo")) {
            document.head.removeChild(document.getElementById('divVentanaComentarioEstilo'));
          }

          var j = JSON.parse(this.responseText);
          var hoja = document.createElement('style');
          hoja.id = "divVentanaComentariosEstilo";
          document.head.appendChild(hoja);
          var div = document.createElement('div');
          div.id = "divVentanaComentarios";
          div.innerHTML = j["datos"];
          hoja.type = "text/css";
          hoja.innerHTML = j['estilo'];
          document.body.appendChild(div);
          document.getElementById("divVentanaComentarios").classList.add('estilo');

          if (refrescadoGlobal == 'guardarCCC') {
            location.reload();
          }
          asignaCalendario();
        }
      }
    };
    req.send();
  }
</script>

<script type="text/javascript">
  function asignaCalendario() {
    $(function() {
      $("#dpCitaContacto").datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        firstDay: 1,
        dateFormat: 'dd/mm/yy',
        regional: "fr",
        closeText: 'Cerrar',
        prevText: 'Anterior',
        nextText: 'Siguiente',
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],

      });
    });
  }
</script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> Ojo Complemeto en Conflicto con easytree -->
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<script type="text/javascript">
  function traerDocumentos(datos, IDCli, IDCliSikas) {
    if (datos == '') {

      parametros = `?IDCli=${IDCli}&IDCliSikas=${IDCliSikas}`;
      peticionAJAX('crmproyecto/traerDocumentos/', parametros, 'traerDocumentos');
      //alert(parametros)
    } else {
      //console.log(datos.children);
      let ul = '<ul class="ulDocumentos">';
      let band = false;
      if (datos.children) {
        band = true;
        datos.children.forEach(info => {
          if (info.href) {

            let extension = info.href.slice((info.href.lastIndexOf(".") - 1 >>> 0) + 2);
            let clase = '';
            extension = extension.toUpperCase();
            switch (extension) {
              case 'PDF':
                clase = 'iconopdf';
                break;
              case 'MSG':
                clase = 'iconomsg';
                break;
              case 'JPG':
                clase = 'iconojpg';
                break;
              case 'JPEG':
                clase = 'iconojpg';
                break;
              case 'WORD':
                clase = 'iconoword';
                break;
              case 'XLS':
                clase = 'iconoxls';
                break;
              case 'XLSX':
                clase = 'iconoxls';
                break;
              case 'XML':
                clase = 'iconoxml';
                break;
              case 'DOCX':
                clase = 'iconoword';
                break;
              case 'PNG':
                clase = 'iconopdf';
                break;
              default:
                clase = 'iconoblanco';
                break;
            }
            ul += `<li class="liArchivos"><div class="${clase} iconogenerico"><a href="${info.href}" target="_blank">${info.text}</a></div></li>`;
          }
        })
      }
      ul += '</ul>';
      if (!band) {
        ul = 'SIN DOCUMENTOS';
      }
      document.getElementById('divModalContenidoGenerico').innerHTML = ul;
      cerrarModal('divModalDocumentos');
    }
  }

  function cerrarModal(modal) {
    document.getElementById(modal).classList.toggle('modalCierra');
    document.getElementById(modal).classList.toggle('modalAbre');
  }

  function cerrar() {
    document.getElementById("miModal").classList.add("modalCierra");
    document.getElementById("miModal").classList.remove("modalAbre");
    document.getElementById("Modalcontenido").style.display = "none";

  }

  function abrir() {
    document.getElementById("miModal").classList.remove("modalCierra");
    document.getElementById("miModal").classList.add("modalAbre");
    document.getElementById("Modalcontenido").style.display = "block";
    $(function() {
      $("#dpCita").datepicker({
        changeMonth: true,
        changeYear: true,
        showWeek: true,
        firstDay: 1,
        regional: "fr",
        closeText: 'Cerrar',
        prevText: 'Anterior',
        nextText: 'Siguiente',
        dateFormat: 'dd/mm/yy',
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
        changeMonth: true,
        changeYear: true,


      });
    });

  }
</script>
<script>
  function muestraMenu() {

    if (!document.querySelector('#divMenu>div:nth-child(2)').classList.contains('bandMenu')) {
      document.querySelector('#divMenu>div:nth-child(2)').classList.add('bandMenu')
      document.querySelector('#divMenu>div:nth-child(2)').style.display = 'block';
    } else {
      document.querySelector('#divMenu>div:nth-child(2)').style.display = 'none';
      document.querySelector('#divMenu>div:nth-child(2)').classList.remove('bandMenu')
    }
  }
  var mql = window.matchMedia('(max-width: 750px)');

  function screenTest(e) {

    if (e.matches) {
      document.querySelector('#divMenu>div:nth-child(2)').style.display = 'none';
      document.querySelector('#divMenu>div:nth-child(2)').classList.remove('bandMenu')
      document.getElementById('marquesinaCiclo').classList.add('ocultarObjeto')
    } else {
      /* the viewport is more than than 0 pixels wide */
      document.querySelector('#divMenu>div:nth-child(2)').classList.add('bandMenu')
      document.querySelector('#divMenu>div:nth-child(2)').style.display = 'block';
      document.getElementById('marquesinaCiclo').classList.remove('ocultarObjeto')

    }
  }

  mql.addListener(screenTest);
</script>

<style type="text/css" id="cssPrueba">
  .prue {
    display: block;
  }

  @media only screen and (max-width:750px) {
    #divMenu>div:nth-child(1) {
      color: yellow;
      width: 100%;
      height: 40px
    }

    #divMenu>div:nth-child(2) {
      color: yellow;
      width: 100%;
      display: none
    }

    #divMenu>div {
      width: 100%;
      background-color: #1c3794
    }

    #divContenedor {
      flex-direction: column;
    }
  }

  @media only screen and (min-width:751px) {
    #divMenu>div:nth-child(1) {
      color: red;
      width: 0%;
      height: 0px
    }

    #divMenu>div {
      width: 2%;
      min-width: 120px;
    }
  }

  .buttonMenu {
    border-color: #472380;
    clear: both;
    height: 100px;
    max-width: 25%;
    color: black;
    min-width: 100px
  }

  .buttonMenu:hover {
    background-color: #7ae593;
    cursor: pointer;
  }

  #divContenedor {
    display: flex;
    height: auto
  }

  #divMenu {
    display: flex;
    flex-direction: column;
    margin-left: 0%;
  }


  /*#divMenu{transform: scale(.5,1.5);margin-left: 0px;position: inherit; top:120px; left: -120px}*/
  #divContenido {
    width: 90%;
    background-color: white;
    /*margin-left: 5%;*/
    /*overflow: scroll; height: 500px*/
    padding: 15px;
    margin: 0px 15px;
  }
</style>
<style>
  .modal-btnCerrar {
    background-color: white;
    width: 60%;
    padding: 0% 0%;
    margin: 0% auto;
    position: relative;
    z-index: 1000;
    border-bottom: solid 5px #5A5553
  }

  .modal-contenido {
    background-color: white;
    width: 60%;
    height: 100%;
    padding: 0% 0%;
    margin: 0% auto;
    position: relative;
    z-index: ;
    overflow: scroll;
    max-height: 95%
  }

  .modal-contenido1 {
    background-color: white;
    width: 400px;
    height: 50%;
    padding: 0% 0%;
    margin: 0% auto;
    position: relative;
    z-index: 1000
  }

  .modalCierra {
    background-color: rgba(0, 0, 0, .8);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0px;
    left: 0;
    opacity: 0;
    transition: all 1s;
    display: none;
    z-index: 1000
  }

  .modalAbre {
    background-color: rgba(0, 0, 0, .8);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0px;
    left: -100;
    transition: all 1s;
    width: 100%;
    height: 100%;
    display: block;
    relative;
    z-index: 1000
  }

  .labelEditar {
    display: block;
  }

  .labelEditar input {
    width: 100%;
    border: solid 1px black;
    color: black;
    background-color: #d7d1e1
  }

  .divEspera {
    width: 80px;
    height: 80px;
    margin-top: -23px;
    margin-left: -163px;
    left: 60%;
    top: 55%;
    position: fixed;
    z-index: 100
  }

  .verObjeto {
    display: block;
  }

  .ocultarObjeto {
    display: none
  }

  .formProspecto>label {
    color: black;
    text-decoration: underline;
  }

  .table>thead>tr>th {
    max-width: 50px;
    width: 50px;
    min-width: 50px
  }

  .table>tbody>tr>th {
    max-width: 50px;
    width: 50px;
    min-width: 50px
  }
</style>


<script>
  function buscarCliente(e) {
    e.preventDefault();
    if (document.getElementById("busquedaUsuario").value == '') {
      window.alert('Escribir nombre de cliente');
      document.getElementById("busquedaUsuario").focus();
    } else {
      enviarArchivoAJAX('formBuscarCliente', 'seguimientoProspecto');
    }

  }

  function SendForm_ReporteComercial() {
    var formulario = document.getElementById('formReporteComercial');
    var year = document.getElementById('year').value;
    var month = document.getElementById('month').value;
    var filtroFechasChec = document.getElementById('filtroFechasChec').value;
    if (document.getElementById('emailCoordinador').value == '') {
      alert('DEBE SELECCIONAR UNA COORDINACION');
      return 0;
    }
    if (document.getElementById('filtroFechasChec').checked) {
      if (document.getElementById('fechaStart').value == '') {
        alert('AL REALIZAR UN FILTRO DE FECHAS SELECCION UNA FECHA INICIO');
        return 0;
      }
      if (document.getElementById('fechaEnd').value == '') {
        alert('AL REALIZAR UN FILTRO DE FECHAS SELECCION UNA FECHA FIN');
        return 0;
      }
      enviarArchivoAJAX('formReporteComercial', 'verReporteComercial');
    } else {
      if (year == '') {
        alert('AL REALIZAR UNA BUSQUEDA POR MES Y AÑO DE SELECCIONAR UN AÑO');
        return 0;
      }
      if (month == '') {
        alert('AL REALIZAR UNA BUSQUEDA POR MES Y AÑO DE SELECCIONAR UN MES');
        return 0;
      }
      enviarArchivoAJAX('formReporteComercial', 'verReporteComercial');
    }

  }

  function enviarArchivoAJAX(formulario, controlador) {
    var Data = new FormData(document.getElementById(formulario));
    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    document.getElementById('imgEspera').classList.toggle('verObjeto');
    if (window.XMLHttpRequest) {
      var Req = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      var Req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    var direccion = <?= ('"' . base_url() . 'crmproyecto/"'); ?> + controlador;

    Req.open("POST", direccion, true);
    Req.onload = function(Event) {
      if (Req.status == 200) {
        document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
        document.getElementById('imgEspera').classList.toggle('verObjeto');
        divContenido.innerHTML = Req.responseText;
      } else {}
    };

    Req.send(Data);
  }
</script>
<script type="text/javascript">
  function cargarPagina1(controlador, id) {

    if (controlador != "") {
      document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
      document.getElementById('imgEspera').classList.toggle('verObjeto');
      var xhr = new XMLHttpRequest();
      var url = <?= '"' . base_url() . '"' ?> + controlador + '?id=' + id;
      xhr.open('POST', url, true);
      xhr.onload = function() {
        if (this.status == 200) {
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
          if (<?= '"' . base_url() . 'auth/login"' ?> == xhr.responseURL) {
            window.location.replace(xhr.responseURL);
          }
          document.getElementById('imgEspera').classList.toggle('verObjeto');
          divContenido.innerHTML = xhr.responseText;
          $('#calendar').fullCalendar()
        }
      }
      xhr.send();
    }
  }


  function cargarPaginaDatos(controlador, opcion) {

    let datos = '';
    switch (opcion) {
      case 'filtraEnSeguimiento':
        if (document.getElementById('selectVendedorProspectoPersona').value != '') {
          datos = '?emailVendedor=' + document.getElementById('selectVendedorProspectoPersona').value
        }
        break;
      default:
        break;
    }

    if (controlador != "") {
      document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
      document.getElementById('imgEspera').classList.toggle('verObjeto');
      var xhr = new XMLHttpRequest();
      var url = <?= '"' . base_url() . '"' ?> + controlador + datos;
      xhr.open('POST', url, true);
      xhr.onload = function() {

        if (this.status == 200) {
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');

          if (<?= '"' . base_url() . 'auth/login"' ?> == xhr.responseURL) {
            window.location.replace(xhr.responseURL);
          }
          document.getElementById('imgEspera').classList.toggle('verObjeto');
          divContenido.innerHTML = xhr.responseText;
          $('#calendar').fullCalendar()
        }
      }
      xhr.send();
    }
  }



  function cargarPagina(controlador, objeto) {


    if (controlador != "") {
      console.log(controlador)
      if (objeto) {
        let bMenu = Array.from(document.getElementsByClassName('buttonMenu'))

        bMenu.forEach(b => {
          b.classList.remove('menuSeleccionado')
        })
        objeto.classList.add('menuSeleccionado');
      }
      document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
      document.getElementById('imgEspera').classList.toggle('verObjeto');
      var xhr = new XMLHttpRequest();
      var url = <?= '"' . base_url() . '"' ?> + controlador;
      xhr.open('POST', url, true);
      xhr.onload = function() {
        if (this.status == 200) {
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
          if (<?= '"' . base_url() . 'auth/login"' ?> == xhr.responseURL) {
            window.location.replace(xhr.responseURL);
          }
          document.getElementById('imgEspera').classList.toggle('verObjeto');
          divContenido.innerHTML = xhr.responseText;
          $('#calendar').fullCalendar();
          if (controlador == 'crmproyecto/seguimientoProspecto') {
            buscarProspectosEmitidos('');
            mostrarTotalProspectos();
            loadVueApp();
          }
        }
      }
      xhr.send();
    }
  }

  function enviaFormReportClient(e) {
    e.preventDefault();

    if (document.getElementById("vendedorp").value == '') {
      alert('Escoger Agente')
    } else {
      enviarArchivoAJAX('infoagente', 'Reportes');
    }
  }

  function enviaFormReportClientTab(e) {
    e.preventDefault();

    if (document.getElementById("vendedorp").value == '') {
      alert('Escoger Agente')
    } else {
      enviarArchivoAJAX('infoagente', 'ReportesTablero');
    }
  }


  function enviaFormBuscaCliente(e) {
    e.preventDefault();
    if (document.getElementById("busquedaUsuario").value == '') {
      alert('Escoger cliente')
    } else {
      enviarArchivoAJAX('formBuscaCliente', 'Reportes');
    }
  }

  function enviaFormBuscaClienteTab(e) {
    e.preventDefault();
    if (document.getElementById("busquedaUsuario").value == '') {
      alert('Escoger cliente')
    } else {
      enviarArchivoAJAX('formBuscaCliente', 'ReportesTablero');
    }
  }

  function eliminarCliente(IDCli, EDOANT, row) {
    if (IDCli != "") {
      var direccionAJAX = "<?php echo (base_url() . 'crmproyecto/'); ?>";
      direccionAJAX = direccionAJAX + 'Eliminar/?EDOANT=' + EDOANT + "&IDCL=" + IDCli + "&row=" + row;
      conectarAJAXMovimientos(direccionAJAX);
    } else {
      if (row != "") {
        document.getElementById("Mitabla").deleteRow(row.row);
        alert(row.mensaje);
      }
    }
  }

  function editarCliente(IDCli, respuesta) {
    if (IDCli != "") {
      var direccionAJAX = "<?php echo (base_url() . 'crmproyecto/'); ?>";
      direccionAJAX = direccionAJAX + 'editPros/?' + "&IDCli=" + IDCli;
      conectarAJAXMovimientos(direccionAJAX);
    } else {
      var datos = '<div ><form id="formEditarCliente"><label class="labelEditar">Apellido Paterno:<input type="text" name="ApellidoP"  value="' + respuesta.detalleUsuario[0].ApellidoP + '"></label>';
      datos = datos + '<label class="labelEditar">Apellido Matero:<input type="text" name="ApellidoM" value="' + respuesta.detalleUsuario[0].ApellidoM + '"></label>';
      datos = datos + '<label class="labelEditar">Nombres:<input type="text" name="Nombre" value="' + respuesta.detalleUsuario[0].Nombre + '"></label>';
      datos = datos + '<label class="labelEditar">Email:<input type="text" name="EMail1" value="' + respuesta.detalleUsuario[0].EMail1 + '"></label>';
      datos = datos + '<label class="labelEditar">Telefono:<input type="text" name="Telefono1" value="' + respuesta.detalleUsuario[0].Telefono1 + '"></label>';
      datos = datos + '<label class="labelEditar">Razon Social:<input type="text" name="RazonSocial" value="' + respuesta.detalleUsuario[0].RazonSocial + '"></label>';
      datos = datos + '<input type="hidden" value="' + respuesta.detalleUsuario[0].IDCli + '" name="IDCl">';
      datos = datos + '<label class="labelEditar">RFC:<input type="text" name="RFC" value="' + respuesta.detalleUsuario[0].RFC + '"></label><form></div>';
      datos = datos + '<button onclick="guardarCambiosProspecto()">Guardar</button>';
      document.getElementById('divModalContenidoGenerico').innerHTML = datos;
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
      document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    }
  }

  function guardarCambiosProspecto() {
    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
    document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    enviarArchivoAJAX('formEditarCliente', 'actualizaProspecto');
  }

  function conectarAJAXMovimientos(direccionAJAX) {
    var req = new XMLHttpRequest();
    req.open('GET', direccionAJAX, true);
    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
    document.getElementById('imgEspera').classList.toggle('verObjeto');
    req.onreadystatechange = function(aEvt) {
      if (req.readyState == 4) {
        if (req.status == 200) {
          var respuesta = JSON.parse(this.responseText);
          document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
          switch (respuesta.respuesta) {
            case 'Eliminar':
              eliminarCliente("", "", respuesta);
              break;
            case 'Editar':
              editarCliente("", respuesta);
              break;
            case 'clienteXmes':
              traerDatosFunnelMes("", "", "", respuesta.datos);
              break;
          }
        }
      }
    };
    req.send();
  }

  function traerDatosFunnelMes(anio, mes, posicion, datos) {
    if (anio != '') {
      var direccionAJAX = "<?php echo (base_url() . 'funnel/'); ?>";
      direccionAJAX = direccionAJAX + 'devolverClientesPorMes/?anio=' + anio + "&mes=" + mes + "&posicion=" + posicion;
      if (document.getElementById('selectPersonaCoordinador')) {
        if (document.getElementById('selectAgentes')) {
          if (document.getElementById('selectAgentes').value > 0) {
            direccionAJAX = direccionAJAX + 'devolverClientesPorMes/?anio=' + anio + "&mes=" + mes + "&posicion=" + posicion + "&idPersona=" + document.getElementById('selectAgentes').value;
          } else {
            direccionAJAX = direccionAJAX + 'devolverClientesPorMes/?anio=' + anio + "&mes=" + mes + "&posicion=" + posicion + "&idPersona=" + document.getElementById('selectPersonaCoordinador').value;
          }
        } else {


          if (document.getElementById('selectPersonaCoordinador').value > 0) {
            direccionAJAX = direccionAJAX + 'devolverClientesPorMes/?anio=' + anio + "&mes=" + mes + "&posicion=" + posicion + "&idPersona=" + document.getElementById('selectPersonaCoordinador').value;
          }
        }
      }
      conectarAJAXMovimientos(direccionAJAX);
    } else {

      cantDimension = datos.DIMENSION.length;
      cantPerfilado = datos.PERFILADO.length;
      cantContactado = datos.REGISTRADO.length;
      cantCotizado = datos.COTIZADO.length;
      cantEmitido = datos.EMITIDO.length;
      cantPagado = datos.PAGADO.length
      var div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>SUSPECTOS (DIMENSION) =' + cantDimension + ' (ACUMULADO ANUAL)</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantDimension; i++) {
        div = div + '<div style="z-index:2;">-> ' + datos.DIMENSION[i].ApellidoP + ' ' + datos.DIMENSION[i].ApellidoM + ' ' + datos.DIMENSION[i].Nombre + ' Razon Social : ' + datos.DIMENSION[i].RazonSocial + '</div>';
      }
      div += '</div></div>';
      document.getElementById('divDimension').innerHTML = div;
      div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>PROSPECTOS (PERFILADOS) =' + cantPerfilado + '</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantPerfilado; i++) {
        div = div + '<label style="z-index:2">->' + datos.PERFILADO[i].ApellidoP + ' ' + datos.PERFILADO[i].ApellidoM + ' ' + datos.PERFILADO[i].Nombre + '</label></br>';
      }
      div += '</div></div>';
      document.getElementById('divPerfilado').innerHTML = div;

      div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>IMPACTO (CONTACTADO) =' + cantContactado + '</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantContactado; i++) {
        div = div + '<label style="z-index:2">->' + datos.REGISTRADO[i].ApellidoP + ' ' + datos.REGISTRADO[i].ApellidoM + ' ' + datos.REGISTRADO[i].Nombre + '</label></br>';
      }
      div += '</div></div>';
      document.getElementById('divContactado').innerHTML = div;

      div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>SEGUIMIENTO (COTIZADO) =' + cantCotizado + '</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantCotizado; i++) {
        div = div + '<label style="z-index:2">->' + datos.COTIZADO[i].ApellidoP + ' ' + datos.COTIZADO[i].ApellidoM + ' ' + datos.COTIZADO[i].Nombre + '</label></br>';
      }
      div += '</div></div>';
      document.getElementById('divCotizado').innerHTML = div;

      div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>SEGUIMIENTO (EMITIDO) =' + cantEmitido + '</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantEmitido; i++) {
        div = div + '<label style="z-index:2">->' + datos.EMITIDO[i].ApellidoP + ' ' + datos.EMITIDO[i].ApellidoM + ' ' + datos.EMITIDO[i].Nombre + '</label></br>';
      }
      div += '</div></div>';
      document.getElementById('divCotizadoEmitido').innerHTML = div;



      div = "";
      div = '<div style="display:flex;flex-direction:column"><div><h4>PAGADO (CIERRE) =' + cantPagado + '</h4></div><div class="contenedorProspectoFunnel">';
      for (var i = 0; i < cantPagado; i++) {
        div = div + '<label style="z-index:2">->' + datos.PAGADO[i].ApellidoP + ' ' + datos.PAGADO[i].ApellidoM + ' ' + datos.PAGADO[i].Nombre + '</label></br>';
      }
      div += '</div></div>';
      document.getElementById('divPagado').innerHTML = div;

      document.getElementById("Vdimension").value = cantDimension;
      document.getElementById("Vperfilado").value = cantPerfilado;
      document.getElementById("Vcontactado").value = cantContactado;
      document.getElementById("Vcotizado").value = cantCotizado;
      document.getElementById("VcotizadoEmitido").value = cantEmitido;
      document.getElementById("Vpagado").value = cantPagado;
    }
  }
</script>

<script>
  var rowAnterior;
  var objetoClickAnterior;
  var objetoClick;
  //var largoTabla=t_Funnel.rows[0].cells.length;var appen=false;

  function F_borrar() {
    var alto = t_Funnel.rows.length;
    var row;
    for (var i = 0; i < alto; i++) {
      if (t_Funnel.rows[i].className == "fondoClickRow") {
        row = t_Funnel.rows[i].rowIndex;
      }
    }
    var idFun = t_Funnel.rows[row].cells[0].innerHTML;
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var rutabsoluta = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    rutabsoluta = rutabsoluta + "funnel/cancelaFunnel";
    $.ajax({
      method: "POST",
      data: {
        "datos": idFun
      },
      url: rutabsoluta,
      dataType: "html",
      success: function(data) {
        t_Funnel.deleteRow(row);
        alert("El funnel fue eliminado");
      }
    })
  }

  function F_cancelar() {
    t_Funnel.deleteRow(1);
  }


  /*function F_guardar(){
  	var mensaje=confirm("EL GUARDADO ES PARA EL FUNNEL NUEVO, DESEA PROSEGUIR");
  	if(mensaje)
      { var cadena="";
  	 for(var i=0;i<largoTabla;i++){
  	 if((largoTabla-1)==i)
  	 {cadena=cadena;cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
       cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML;
  	}else
  	 {cadena=cadena;
       cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
       cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML+',';
       }
  	}	
  	var loc = window.location;
      var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
      var rutabsoluta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
      rutabsoluta=rutabsoluta+"funnel/guardaNuevo";

  	$.ajax({
  		method:"POST",data:{"datos":cadena},url:rutabsoluta,dataType:"html",
  		success:function(data){
        console.log(data);
          	var j=JSON.parse(data);
  			if(typeof(j)=="number"){
            	var valor=(-1)*(data);          	
            switch(valor){
               case 1:alert("El contrato a cerrar debe ser mayor de cero"); break;
               case 2:alert("El ticket promedio y el objetivo mensual deben ser mayores de cero"); break;
               case 3:alert("Los porcentajes deben ser mayor 0"); break;
               case 4:alert("Los porcentajes son menores o igual a 100"); break;
               case 5:alert("Error en la fecha seleccionada"); break;
               case 6:alert("Error en el mes seleccionado");break;
              }
  			}
  			else
  			{var altoT=t_Funnel.rows.length;             
  			 var row=t_Funnel.insertRow(altoT);	
         row.addEventListener("click",function(){cambiaClickTabla(this)});
         row.addEventListener("mouseover",function(){cambiaFocoTabla(this)});
         //row.className="fondoClickRow";//fondoNoSelecRow";
         
  	   for(var i=0;i<largoTabla;i++){row.insertCell(i).innerHTML="-";}	
  			 var objeto=  Object.keys(j[0]);
  			 var long=objeto.length;    
         for(var t=0;t<long;t++)
         {var nombre=objeto[t];
          if(document.getElementById(objeto[t]))
           {t_Funnel.rows[altoT].cells[document.getElementById(objeto[t]).cellIndex].innerHTML=j[0][nombre];          
           }
         }
        cambiaClickTabla(row);
         t_Funnel.deleteRow(1);
  			}
  		}
  	})}else{alert("GUARDADO EN ESPERA");}   
   }*/



  /*function F_append(){
  var row=t_Funnel.insertRow(1);
  for(var i=0; i<largoTabla;i++){
    row.insertCell(i);
    if(t_Funnel.rows[0].cells[i].id=="anio")
    {row.cells[i].innerHTML="2017";}
    if(t_Funnel.rows[0].cells[i].id=="id")
    {row.cells[i].innerHTML="NUEVO";}

    row.className="fondoRowNuevo";
    if(t_Funnel.rows[0].cells[i].id != "anio" && t_Funnel.rows[0].cells[i].id != "mes")
      {var ob="V"+t_Funnel.rows[0].cells[i].id;  	
       if(document.getElementById(ob))
       	{document.getElementById(ob).value="";}}
   }
   row.addEventListener("click",function(){cambiaClickTabla(this)}); 
   cambiaClickTabla(row);
  //cambiaClickTabla(Vsuspecto);
  Vsuspecto.value="100";
  Vprospecto.value="100";
  Vimpacto.value="100";
  Vseguimiento.value="100";
  suspect.innerHTML="0";
  prospect.innerHTML="0";
  impact.innerHTML="0";
  seguimient.innerHTML="0";
  }*/


  /*for(var i=0; i<largoTabla;i++){	
  	var obj="V"+t_Funnel.rows[0].cells[i].id;	
     if(document.getElementById(obj)){
    
     	  document.getElementById(obj).addEventListener("change",function(){cambia(this.id)});  
     }
  }*/

  function modificaTablaFunnel(id, valor) {
    var columna = id.substring(1, id.length);
  }

  function cambiaClickTabla(objeto) {
    var bandNuevo = objeto.cells[0].innerHTML;
    if (bandNuevo == "NUEVO") {
      var largo = objeto.cells.length;
      for (var i = 0; i < largo; i++) {
        var idCab = objeto.parentNode.rows[0].cells[i].id;
        if (document.getElementById("V" + idCab)) {
          document.getElementById("V" + idCab).value = objeto.cells[i].innerHTML;
          document.getElementById("V" + idCab).className = "fondoEditNuevo";

          if (idCab != "dimension" && idCab != "perfilado" && idCab != "pagado" && idCab != "contactado" && idCab != "cotizado" && idCab != "contratoCerrar") {
            document.getElementById("V" + idCab).disabled = "";
          } else {
            document.getElementById("V" + idCab).disabled = "disabled";
          }
        }
      }
    } else {
      //if(bandNuevo!="NUEVO")
      objeto.className = "fondoClickRow";

      objetoClick = objeto;
      var largo = objeto.cells.length;
      for (var i = 0; i < largo; i++) {
        var idCab = objeto.parentNode.rows[0].cells[i].id;
        if (document.getElementById("V" + idCab)) {
          document.getElementById("V" + idCab).value = objeto.cells[i].innerHTML;
          //document.getElementById("V"+idCab).className="fondoEditExistente";
          document.getElementById("V" + idCab).disabled = "disabled";
        }
      }
      if (objetoClickAnterior) {
        objetoClickAnterior.className = "fondoNoSelecRow";
      }
      //if(bandNuevo!="NUEVO")	
      objetoClickAnterior = objeto;
    }
    cambia();
  }

  function cambiaFocoTabla(objeto) {
    if (objeto.className != "fondoClickRow") {
      objeto.className = "fondoSelecRow";
      if (rowAnterior && rowAnterior.className != "fondoClickRow") {
        rowAnterior.className = "fondoNoSelecRow";
      }
      rowAnterior = objeto;
    }
  }


  function cambia(id) {
    var n1 = Number(Vseguimiento.value);
    var n2 = Number(Vimpacto.value);
    var n3 = Number(Vprospecto.value);
    var n4 = Number(Vsuspecto.value);
    var n5 = Number(VobjetivoMensual.value);
    var n6 = Number(VticketProm.value);
    var n7 = Number(Vcomision.value)

    if (!isNaN(n1) && n1 > 0 && !isNaN(n2) && n2 > 0 && !isNaN(n3) && n3 > 0 && !isNaN(n4) && n4 > 0 && n5 > 0 && !isNaN(n5) && !isNaN(n6) && n6 > 0 && !isNaN(n7) && n7 > 0) {
      var calculado = (VcontratoCerrar.value * 100) / Vseguimiento.value;
      t_Funnel.rows[1].cells[seguimiento.cellIndex].innerHTML = Vseguimiento.value; //Math.round(calculado);
      seguimient.innerHTML = Math.round(calculado);
      if (!isNaN(Vimpacto.value))
        calculado = (calculado * 100) / Vimpacto.value;

      t_Funnel.rows[1].cells[impacto.cellIndex].innerHTML = Vimpacto.value; //Math.round(calculado);

      impact.innerHTML = Math.round(calculado);
      if (Vprospecto.value > 0)
        calculado = (calculado * 100) / Vprospecto.value;
      t_Funnel.rows[1].cells[prospecto.cellIndex].innerHTML = Vprospecto.value; //Math.round(calculado);
      prospect.innerHTML = Math.round(calculado);
      if (Vsuspecto.value > 0)
        calculado = (calculado * 100) / Vsuspecto.value;
      t_Funnel.rows[1].cells[suspecto.cellIndex].innerHTML = Vsuspecto.value; //Math.round(calculado);
      suspect.innerHTML = Math.round(calculado);
      porFinal.innerHTML = Math.round((VcontratoCerrar.value * 100) / calculado) + "%";
      Otn4.innerHTML = Vseguimiento.value + "%{";
      Otn3.innerHTML = Vimpacto.value + "%{";
      Otn2.innerHTML = Vprospecto.value + "%{";
      Otn1.innerHTML = Vsuspecto.value + "%{";

      if (id != "Vmes" && id != "Vanio") {
        cantidad = Vcomision.value / 100;
        cantidad = cantidad * VticketProm.value;
        var objetivo = VobjetivoMensual.value / cantidad;
        entero = Math.floor(objetivo);
        var contrato;
        if (entero - objetivo == 0) {
          contrato = entero
        } else {
          contrato = entero + 1;
        }
        VcontratoCerrar.value = contrato;
        cerrar.innerHTML = contrato;
        t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML = contrato;
        if (!isNaN(n1) && n1 == 0) {
          Vseguimiento.value = 100;
        }
        if (!isNaN(n2) && n2 == 0) {
          Vimpacto.value = 100;
        }
        if (!isNaN(n3) && n3 == 0) {
          Vprospecto.value = 100;
        }
        if (!isNaN(n4) && n4 == 0) {
          Vsuspecto.value = 100;
        }
        if (!isNaN(n1) && n1 == 100 && !isNaN(n2) && n2 == 100 && !isNaN(n2) && n3 == 100 && !isNaN(n2) && n4 == 100) {
          impact.innerHTML = contrato;
          prospect.innerHTML = contrato;
          suspect.innerHTML = contrato;
          seguimient.innerHTML = contrato;
          porFinal.innerHTML = "100%"
        }
      }


    }
    if (id == "VobjetivoMensual" || id == "VticketProm" || id == "Vcomision" || id == "Vmes" || id == "Vanio") {
      var columna = id.substring(1, id.length);
      t_Funnel.rows[1].cells[document.getElementById(columna).cellIndex].innerHTML = document.getElementById(id).value;
    }

  }

  function calcular() {
    cantidad = Vcomision.value / 100;
    cantidad = cantidad * VticketProm.value;
    var objetivo = VobjetivoMensual.value / cantidad;
    entero = Math.floor(objetivo);
    var contrato;
    if (entero - objetivo == 0) {
      contrato = entero
    } else {
      contrato = entero + 1;
    }
    VcontratoCerrar.value = contrato;
    t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML = contrato;
    var n1 = Number(Vseguimiento.value);
    var n2 = Number(Vimpacto.value);
    var n3 = Number(Vprospecto.value);
    var n4 = Number(Vsuspecto.value);

    if (!isNaN(n1) && n1 == 0) {
      Vseguimiento.value = 100;
    }
    if (!isNaN(n2) && n2 == 0) {
      Vimpacto.value = 100;
    }
    if (!isNaN(n3) && n3 == 0) {
      Vprospecto.value = 100;
    }
    if (!isNaN(n4) && n4 == 0) {
      Vsuspecto.value = 100;
    }
    cambia();
  }
  //cambiaClickTabla(t_Funnel.rows[1]);
</script>
<script type="text/javascript">
  document.getElementById('marquesinaBanner').style.display = 'none';
  <?php
  if (isset($pestania)) {
    echo ('cargarPagina("crmproyecto/' . $pestania . '")');
  } else {
    echo ('cargarPagina("crmproyecto/agregarProspecto")');
  }
  ?>
</script>
<link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<script src='<?php echo base_url(); ?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url(); ?>assets/fullcalendar/fullcalendar.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#calendar').fullCalendar({ //Modificado [Suemy][2024-06-26]
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek',
      },
      defaultDate: new Date(),
      navLinks: false,
      editable: true,
      eventLimit: true,

      events: [<?php foreach ($citas as $value) {
                  echo ("{ title:'" . $value->title . "',start:'" . $value->start . "',end:'" . $value->end . "',id:'" . $value->id . "'},");
                } ?>],
      eventDrop: function(event, delta, reverFunc) {
        var id = event.id;
        var fi = event.start.format();
        var ff = event.end.format();
        $.post(<?php echo ('"' . base_url() . 'crmproyecto/actualizaCita"'); ?>, {
            id: id,
            fi: fi,
            ff: ff
          },
          function(data) {
            if (data == 1) {
              alert("Cita actualizado correctamente")
            } else {
              alert("error intenterlo mas tarde")
            }
          })
      },
      eventResize: function(event) {
        var id = event.id;
        var fi = event.start.format();
        var ff = event.end.format();
        $.post(<?php echo ('"' . base_url() . 'crmproyecto/actualizaCita"'); ?>, {
            id: id,
            fi: fi,
            ff: ff
          },
          function(data) {
            if (data == 1) {
              alert("Cita actualizado correctamente")
            } else {
              alert("error intenterlo mas tarde")
            }
          })


      },
      eventRender: function(event, element) {
        var el = element.html();
        element.html("<div style='width:90%;'>" + el + "</div><div style='float:right;color:red;border:solid; width:10px; height:10px;text-align:right;position:relative; top:-15px; background-color:white' class='eliminaCita'>X</div>");
        element.find('.eliminaCita').click(function() {
          if (!confirm("Estas seguro de eliminar el evento")) {
            alert("Eliminacion cancelada");
          } else {
            var id = event.id;
            $.post(<?php echo ('"' . base_url() . 'crmproyecto/eliminaCita"');  ?>, {
                id: id
              },
              function(data) {
                if (data == 1) {
                  $('#calendar').fullCalendar('removeEvents', event.id);
                  alert("Cita eliminada correctamente")
                } else {
                  alert("error intenterlo mas tarde")
                }
              })

          }
        })
      }

    });

  });

  function abrirCerrar(objeto, clase) {
    var imagen = objeto.innerHTML;
    if (imagen == "▼") {
      objeto.innerHTML = "►";
      var clase = document.getElementsByClassName(clase);
      for (var i = 0; i < clase.length; i++) {
        clase[i].classList.remove("verObjeto");
        clase[i].classList.add("ocultarObjeto");
      }

    }
    if (imagen == "►") {
      objeto.innerHTML = "▼";
      var clase = document.getElementsByClassName(clase);

      for (var i = 0; i < clase.length; i++) {
        clase[i].classList.remove("ocultarObjeto");
        clase[i].classList.add("verObjeto");
        clase[i].classList.remove("verObjeto");
      }
    }
  }
</script>
<script type="text/javascript">
  function llamarDate() {
    $(document).ready(function() {
      $('.fecha').datepicker({

        closeText: 'Cerrar',
        prevText: 'Anterior',
        nextText: 'Siguiente',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mi&eacute;', 'Juv', 'Vie', 'S&aacute;b'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'S&aacute;'],
        dateFormat: 'dd/mm/yy',
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        firstDay: 1,
        changeMonth: true,
        changeYear: true,

      });
    });
  }
</script>
<style type="text/css">
  .ocultarObjeto1 {
    display: none;
  }

  .verObjeto1 {
    display: table;
  }
</style>
<script type="text/javascript">
  <?php

  if (isset($clientesEnPausa)) {
    if ((count($clientesEnPausa)) > 0) {

      echo ('document.getElementById(\'divModalContenidoGenerico\').innerHTML="' . impirmirEnPausa($clientesEnPausa) . '";');
      echo ('cerrarModal(\'divModalGenerico\');');
    }
  }

  ?>
</script>
<?
function impirmirEnPausa($datos)
{
  $enPausa = '<table  id=\'tablaActivacion\' class=\'table\'><thead><tr><th>CLIENTES EN PAUSA</th><th>FECHA DE REVISION</th><th></th></tr></thead><tbody>';

  foreach ($datos as  $value) {

    $originalDate = $value->fechaMensajePausa;
    $newDate = date("d-m-Y", strtotime($originalDate));
    $enPausa .= '<tr><td>' . $value->ApellidoP . ' ' . $value->ApellidoM . ' ' . $value->Nombre . '(Razon Social:' . $value->RazonSocial . ')</td><td>' . $newDate . '</<td><td><button align=\'right\' onclick=\'activarEnPausa(\"\",' . $value->IDCli . ',this)\' class=\'btn btn-warning\'>activar</button></td></tr>';
  }
  $enPausa .= '</tbody></table>';
  return $enPausa;
}
?>
<script>
  function generaLinkEnvio(tipoLink, numeroMovilLink, correoLink, datosLink) {

    //	console.log(tipoLink);
    //	console.log(numeroMovilLink);
    //	console.log(correoLink);
    //	console.log(datosLink);
    var paramLinkCorto = {
      "linkLargo": datosLink,
    }
    //** console.log(paramLinkCorto);
    $.ajax({
      always: function() {
        $('#modalPreload').modal('show');
      },
      url: '<?= base_url() . "bitly_controller/getLinkCorto" ?>',
      type: 'POST',
      data: paramLinkCorto,
      success: function(data) {
        data = jQuery.parseJSON(data);
        //** console.log(data);
        switch (tipoLink) {
          case "linkSms":
            // base_url('smsMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
            window.open('<?= base_url('smsMasivo?') . "paraTelefonosUrl="; ?>' + numeroMovilLink + '&smsTextUrl=', '_blank');
            //console.log('Sms');
            break;

          case "linkWhatSapp":

            // base_url('whatsAppMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
            window.open('<?= base_url('whatsAppMasivo?') . "paraTelefonosUrl="; ?>' + numeroMovilLink + '&smsTextUrl=', '_blank');
            //console.log('WhatSapp');
            break;

          case "linkCorreo":
            // base_url('mailMasivo?')."paraCorreoUrl=".$infoCliente[0]->EMail1."&textCorreoUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
            window.open('<?= base_url('mailMasivo?') . "paraCorreoUrl="; ?>' + correoLink + '&textCorreoUrl=', '_blank');
            //console.log('Correo');
            break;
        }
      }
    });

  }

  //*********Ultimas Actualizacion Miguel Jaime 01/10/2020

  /* Ajax*/
  function objetoAjax() {
    var oHttp = false;
    var asParsers = ["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
      "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"
    ];
    for (var iCont = 0;
      ((!oHttp) && (iCont < asParsers.length)); iCont++) {
      try {
        oHttp = new ActiveXObject(asParsers[iCont]);
      } catch (e) {
        oHttp = false;
      }
    }
    if ((!oHttp) && (typeof XMLHttpRequest != 'undefined')) {
      oHttp = new XMLHttpRequest();
    }
    return oHttp;
  }

  //Modificacion 05/11/2020
  function activar_persona() {
    document.getElementById('div_persona').style.display = 'block';
    document.getElementById('div_generico').style.display = 'none';

    document.getElementById('div_seleccion').style.display = 'none';
    document.getElementById('div_agente').style.display = 'none';
    document.getElementById('menuAltaProspecto').style.display = 'none';


  }

  function activar_generico() {
    document.getElementById('div_generico').style.display = 'block';
    document.getElementById('div_persona').style.display = 'none';
    document.getElementById('menuAltaProspecto').style.display = 'none';
    document.getElementById('div_seleccion').style.display = 'none';
    document.getElementById('div_agente').style.display = 'none';

  }

  function activar_agente() {
    document.getElementById('div_agente').style.display = 'block';
    document.getElementById('div_persona').style.display = 'none';
    document.getElementById('menuAltaProspecto').style.display = 'none';
    document.getElementById('div_seleccion').style.display = 'none';
    document.getElementById('div_generico').style.display = 'none';
  }



  function abrir_pestania_generico() {
    document.getElementById('generico').style.display = 'block';
    document.getElementById('lead').style.display = 'none';
    document.getElementById('persona').style.display = 'none';
    document.getElementById('masivo').style.display = 'none';
    document.getElementById('agentes').style.display = 'none';
    document.getElementById('li_generico').style = "background-color:blue";
    document.getElementById('li_persona').style = "background-color: #000";
    document.getElementById('li_masivo').style = "background-color: #000";
    document.getElementById('li_lead').style = "background-color: #000";
    document.getElementById('li_agentes').style = "background-color: #000";
  }

  function abrir_pestania_persona() {
    document.getElementById('persona').style.display = 'block';
    document.getElementById('lead').style.display = 'none';
    document.getElementById('generico').style.display = 'none';
    document.getElementById('agentes').style.display = 'none';
    document.getElementById('masivo').style.display = 'none';
    document.getElementById('li_persona').style = "background-color:blue";
    document.getElementById('li_generico').style = "background-color:#000";
    document.getElementById('li_masivo').style = "background-color: #000";
    document.getElementById('li_lead').style = "background-color: #000";
    document.getElementById('li_agentes').style = "background-color: #000";
  }

  function abrir_pestania_masivo() {
    document.getElementById('masivo').style.display = 'block';
    document.getElementById('lead').style.display = 'none';
    document.getElementById('generico').style.display = 'none';
    document.getElementById('persona').style.display = 'none';
    document.getElementById('agentes').style.display = 'none';
    document.getElementById('li_masivo').style = "background-color:blue";
    document.getElementById('li_generico').style = "background-color:#000";
    document.getElementById('li_persona').style = "background-color:#000";
    document.getElementById('li_lead').style = "background-color: #000";
    document.getElementById('li_agentes').style = "background-color: #000";
  }

  function abrir_pestania_lead() {
    document.getElementById('lead').style.display = 'block';
    document.getElementById('masivo').style.display = 'none';
    document.getElementById('generico').style.display = 'none';
    document.getElementById('persona').style.display = 'none';
    document.getElementById('agentes').style.display = 'none';
    document.getElementById('li_masivo').style = "background-color:#000";
    document.getElementById('li_generico').style = "background-color:#000";
    document.getElementById('li_persona').style = "background-color:#000";
    document.getElementById('li_agentes').style = "background-color: #000";
    document.getElementById('li_lead').style = "background-color: blue";
  }


  function abrir_pestania_agentes() {
    document.getElementById('agentes').style.display = 'block';
    document.getElementById('masivo').style.display = 'none';
    document.getElementById('generico').style.display = 'none';
    document.getElementById('lead').style.display = 'none';
    document.getElementById('persona').style.display = 'none';
    document.getElementById('li_masivo').style = "background-color:#000";
    document.getElementById('li_generico').style = "background-color:#000";
    document.getElementById('li_persona').style = "background-color:#000";
    document.getElementById('li_lead').style = "background-color: #000";
    document.getElementById('li_agentes').style = "background-color: blue";
  }
  //fin modificacion

  // Pestañas de lista de notificaciones
  $sw = 0;

  function abrir_lista_primera() {
    if ($sw == 0) {
      $sw = 1;
      document.getElementById('div_primera').style.display = 'block';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    } else {
      $sw = 0;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    }
  }

  function abrir_lista_cierre() {
    if ($sw == 0) {
      $sw = 1;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'block';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    } else {
      $sw = 0;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    }
  }


  function abrir_lista_leads() {
    if ($sw == 0) {
      $sw = 1;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_leads').style.display = 'block';
      document.getElementById('div_tareas').style.display = 'none';
    } else {
      $sw = 0;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    }
  }

  function abrir_lista_tareas() {

    if ($sw == 0) {
      $sw = 1;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'block';
    } else {
      $sw = 0;
      document.getElementById('div_primera').style.display = 'none';
      document.getElementById('div_leads').style.display = 'none';
      document.getElementById('div_cierre').style.display = 'none';
      document.getElementById('div_tareas').style.display = 'none';
    }
  }

  function enviaTarea($idtarea) {
    //console.log($idtarea);
    //var proyecto=0;
    var xhr = new XMLHttpRequest();
    var datos = new FormData();
    datos.append('idtarea', $idtarea);
    //  datos.append('fecha',fechaTarea.value);
    xhr.open('POST', "<?php echo base_url(); ?>cproyecto/actualizaAlerta", true);
    xhr.onload = function() {
      if (this.status === 200) {
        var respuesta = JSON.parse(xhr.responseText);
        // console.log(respuesta);
        //proyecto = respuesta;
        window.location.replace("<?php echo base_url(); ?>Cproyecto/muestraProyectos?idproyecto=" + respuesta);
      }
    }
    //console.log(respuesta);
    xhr.send(datos);
    //window.location.replace("<?php echo base_url(); ?>Cproyecto/muestraProyectos?idproyecto="+proyecto);
  }

  //FIN
  /** Actualiza tipo de prospectos**/
  function actualiza_prospecto(id) {
    var url = $('#base').val() + "crmproyecto/actualiza_prospecto";
    var tipo = $('#tipo_prospecto').val();
    $.ajax({
      type: "POST",
      dataType: 'html',
      url: url,
      data: "id=" + id + "&tipo_prospecto=" + tipo,
      success: function(resp) {}
    });
    window.history.back(-2);
  }


  //*** Filtro tipo de Estado Actual prospectos genericos
  function seleccionarEstadoActual(e) {
    var estado = e.value;
    divResultado = document.getElementById('pantalla');
    ajax = objetoAjax();
    var url = document.getElementById('base').value;
    var URL = url + "crmproyecto/prospecto_genericos_estado?estado=" + estado;
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText
        document.getElementById('loader').style.display = "none";
      }
    }
    ajax.send(null)
  }

  //Pestañas Agenda asesores
  function abrir_pestania_citas() {
    document.getElementById('citas').style.display = 'block';
    document.getElementById('configuracion').style.display = 'none';
    document.getElementById('li_citas').style = "background-color:blue";
    document.getElementById('li_configuracion').style = "background-color: #000";
  }

  function abrir_pestania_configuracion() {
    document.getElementById('citas').style.display = 'none';
    document.getElementById('configuracion').style.display = 'block';
    document.getElementById('li_citas').style = "background-color:#000";
    document.getElementById('li_configuracion').style = "background-color:blue";
  }

  //Modificacion
  function agregarAgenda() {
    divResultado = document.getElementById('configuracion');
    ajax = objetoAjax();
    var url = document.getElementById('base').value;
    var id = document.getElementById('id_userInfo').value;
    var inicio = document.getElementById('hinicio').value;
    var fin = document.getElementById('hfinal').value;
    var mes = document.getElementById('mesActual').value;
    var year = document.getElementById('yearActual').value;
    var URL = url + "crmproyecto/agregar_agenda?id_userInfo=" + id + "&hinicio=" + inicio + "&hfinal=" + fin + '&mesActual=' + mes + '&yearActual=' + year;
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML
        divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)
  }

  function eliminarAgenda(id) {
    divResultado = document.getElementById('configuracion');
    ajax = objetoAjax();
    var url = document.getElementById('base').value;
    var URL = url + "crmproyecto/eliminar_configuracion_agenda?id=" + id;
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)
  }
  //Fin modificacion

  function detalle_cita(cliente, correo, telefono, detalle, medio) {
    document.getElementById('detalle_cita').style.display = "block";
    document.getElementById('detalle_cita').innerHTML = "<table width='65%'><tr><td><div style='text-align:left'><button onclick='cerrar_detalle()' class='btn btn-xs btn-danger' style='color: #fff;'><i class='fa fa-times-circle'></i>&nbsp;Cerrar</button></div><br></td><td></td></tr><tr><td colspan='2'><h5>DETALLES DEL CLIENTE</h5></td></tr><tr><td><b>Nombre:</b></td><td>" + cliente + "</td></tr><tr><td><b>Email:</b></td><td>" + correo + "</td></tr><tr><td><b>Telefono:</b></td><td>" + telefono + "</td></tr><tr><td><b>Medio de Preferencia:</b></td><td>" + medio + "</td></tr><tr><td><b>Detalle de la Cita:</b></td><td>" + detalle + "</td></tr></table>";
  }

  function cerrar_detalle() {
    document.getElementById('detalle_cita').style.display = "none";
  }

  //Modificacion  miguel jaime 11/11/2020
  function eliminar_prospecto_agente(id) {
    var opt = confirm("¿Esta seguro de eliminar este Prospecto de Agente?");
    if (opt == 1) {
      var url = "<?php echo base_url() ?>crmproyecto/EliminarProspectoAgente";
      document.location.href = url + '?id=' + id;
    }
  }

  function guardar_agente_temporal(nombres, apellidoP, apellidoM, email, telefono, fechaRegistro) {
    var op = confirm("¿Esta seguro de traspasar este agente a capital humano?");
    if (op == 1) {
      var url = document.getElementById('base').value;
      document.location.href = url + "crmproyecto/guardar_agente_temporal?nombres=" + nombres + "&apellidoP=" + apellidoP + "&apellidoM=" + apellidoM + "&email=" + email + "&telefono=" + telefono + "&fechaRegistro=" + fechaRegistro;
    }
  }

  /** Actualiza tipo de prospectos**/
  function actualiza_estado(id) {
    var estado = document.getElementById('estado').value;
    var url = "<?php echo base_url() ?>crmproyecto/actualiza_estado";
    document.location.href = url + '?estado=' + estado + '&id=' + id;
  }


  //Modificacion actualizacion prospectos 02/02/2021
  function actualizarProspectos() {
    var tipo = document.getElementById('tipo_prospecto').value;
    if (tipo != 2) {
      const prospectos = [];
      var hasta = document.getElementById('ct').value;
      for (i = 0; i < hasta; i++) {
        var chk = document.getElementById('check' + i).checked;
        if (chk == true) {
          var id = document.getElementById('check' + i).value;
          prospectos.push(id);
        }
      }
      if (prospectos.length > 0) {
        ids = JSON.stringify(prospectos);
        var url = "<?php echo base_url() ?>crmproyecto/setProspecto";
        document.location.href = url + '?tipo=' + tipo + '&ids=' + ids;
      } else {
        alert("Debe seleccionar al menos un prospecto");
      }
    } else {
      alert("Debe seleccionar un tipo de prospecto para actualizar");
    }

  }
  const prospectos_agentes = [];

  function seleccionar_agentes(id) {
    if (id == '-1') {
      if (prospectos_agentes.length > 0) {
        cargarPagina('crmproyecto/actualizar_prospectos_agentes/?p=' + JSON.stringify(prospectos_agentes));
      } else {
        alert("Debe seleccionar al menos un Agente");
      }
    } else {
      prospectos_agentes.push(id);
    }
  }

  function modificar_agentes_seleccionados() {
    var status = document.getElementById('status').value;
    var asignado = document.getElementById('asignado').value;
    var url = "<?php echo base_url() ?>crmproyecto/modificar_agentes_seleccionados";
    document.location.href = url + '?status=' + status + '&asignado=' + asignado + '&prospectos=' + prospectos_agentes;
  }



  function filtroProspectoAgente(valor, param) {
    var valor = valor.value;
    var URL = "crmproyecto/prospectos_agentes_filtrado?param=" + param + "&valor=" + valor;
    cargarPagina(URL);
  }

  function editar_prospecto_agente(id, comentarios, nombre) {
    document.getElementById('id_edit').value = id;
    document.getElementById('comentarios_edit').value = comentarios;
    document.getElementById('nombre_edit').innerHTML = nombre;
  }


  function guardar_comentarios() {
    var id = document.getElementById('id_edit').value;
    var comentario = document.getElementById('comentarios_edit').value;
    var url = "<?php echo base_url() ?>crmproyecto/actualiza_comentario";
    document.location.href = url + '?comentario=' + comentario + '&id=' + id;
  }
  //*************Fin  

  function moverScrollBorrar(objeto) {
    let cabecera = objeto.parentNode.firstElementChild
    let x = objeto.scrollLeft;
    cabecera.scrollLeft = x;
  }
  //Utimas modidificaciones MJ 22/07/2021
  function calcular(obj) {


    var contrato = 0;
    if (obj == -1) {
      contrato = document.getElementById('contrato').value;
    } else {
      contrato = obj.value;
    }


    //Porcentajes de reporte
    document.getElementById('txtporrpt1').value = document.getElementById('por1').value;
    document.getElementById('txtporrpt2').value = document.getElementById('por2').value;
    document.getElementById('txtporrpt3').value = document.getElementById('por3').value;

    //Buro
    var buro = 0;
    if (document.getElementById('personaMoral').checked == true) {
      buro = parseFloat(document.getElementById('costopersonaMoral').value);
    }

    if (document.getElementById('personaFisica').checked == true) {
      buro = parseFloat(document.getElementById('costopersonaFisica').value);
    }

    document.getElementById('buro1').value = formatterPeso.format(buro);
    document.getElementById('buro2').value = 0;
    document.getElementById('buro3').value = 0;




    //GAS. EXP.


    if (document.getElementById('sofimex').checked == true) {

      var totalGas1 = parseFloat(document.getElementById('TotalGas1').value);
      var totalGas2 = parseFloat(document.getElementById('TotalGas1').value);
      var totalGas3 = parseFloat(document.getElementById('TotalGas1').value);


      document.getElementById('gas1').value = formatterPeso.format(document.getElementById('TotalGas1').value);
      document.getElementById('gas2').value = formatterPeso.format(document.getElementById('TotalGas1').value);
      document.getElementById('gas3').value = formatterPeso.format(document.getElementById('TotalGas1').value);
    }

    if (document.getElementById('liberty').checked == true) {

      var totalGas1 = parseFloat(document.getElementById('TotalGas2').value);
      var totalGas2 = parseFloat(document.getElementById('TotalGas2').value);
      var totalGas3 = parseFloat(document.getElementById('TotalGas2').value);


      document.getElementById('gas1').value = formatterPeso.format(document.getElementById('TotalGas2').value);
      document.getElementById('gas2').value = formatterPeso.format(document.getElementById('TotalGas2').value);
      document.getElementById('gas3').value = formatterPeso.format(document.getElementById('TotalGas2').value);
    }

    if (document.getElementById('chubb').checked == true) {

      var totalGas1 = parseFloat(document.getElementById('TotalGas3').value);
      var totalGas2 = parseFloat(document.getElementById('TotalGas3').value);
      var totalGas3 = parseFloat(document.getElementById('TotalGas3').value);


      document.getElementById('gas1').value = formatterPeso.format(document.getElementById('TotalGas3').value);
      document.getElementById('gas2').value = formatterPeso.format(document.getElementById('TotalGas3').value);
      document.getElementById('gas3').value = formatterPeso.format(document.getElementById('TotalGas3').value);
    }

    if (document.getElementById('tokyo').checked == true) {

      var totalGas1 = parseFloat(document.getElementById('TotalGas4').value);
      var totalGas2 = parseFloat(document.getElementById('TotalGas4').value);
      var totalGas3 = parseFloat(document.getElementById('TotalGas4').value);


      document.getElementById('gas1').value = formatterPeso.format(document.getElementById('TotalGas4').value);
      document.getElementById('gas2').value = formatterPeso.format(document.getElementById('TotalGas4').value);
      document.getElementById('gas3').value = formatterPeso.format(document.getElementById('TotalGas4').value);
    }


    if (document.getElementById('berkley').checked == true) {

      var totalGas1 = parseFloat(document.getElementById('TotalGas5').value);
      var totalGas2 = parseFloat(document.getElementById('TotalGas5').value);
      var totalGas3 = parseFloat(document.getElementById('TotalGas5').value);

      document.getElementById('gas1').value = formatterPeso.format(document.getElementById('TotalGas5').value);
      document.getElementById('gas2').value = formatterPeso.format(document.getElementById('TotalGas5').value);
      document.getElementById('gas3').value = formatterPeso.format(document.getElementById('TotalGas5').value);
    }


    //Monto
    var por1 = document.getElementById('por1').value;
    var por2 = document.getElementById('por2').value;
    var por3 = document.getElementById('por3').value;


    var monto1 = document.getElementById('monto1').value = (contrato * por1) / 100;
    var monto2 = document.getElementById('monto2').value = (contrato * por2) / 100;
    var monto3 = document.getElementById('monto3').value = (contrato * por3) / 100;


    document.getElementById('monto1').value = formatterPeso.format(monto1);
    document.getElementById('monto2').value = formatterPeso.format(monto2);
    document.getElementById('monto3').value = formatterPeso.format(monto3);


    //Prima

    var tar1 = document.getElementById('tar1').value;
    var tar2 = document.getElementById('tar2').value;
    var tar3 = document.getElementById('tar3').value;



    var prima1 = (((contrato * por1) / 100) * tar1) / 100;
    var prima2 = (((contrato * por2) / 100) * tar2) / 100;
    var prima3 = (((contrato * por3) / 100) * tar3) / 100;
    //Verificar Generar
    generarBoton(prima1);


    document.getElementById('prima1').value = formatterPeso.format(prima1);
    document.getElementById('prima2').value = formatterPeso.format(prima2);
    document.getElementById('prima3').value = formatterPeso.format(prima3);


    //DIV

    var div1 = (((((contrato * por1) / 100) * tar1) / 100) * 3.5) / 100;
    var div2 = (((((contrato * por2) / 100) * tar2) / 100) * 3.5) / 100;
    var div3 = (((((contrato * por3) / 100) * tar3) / 100) * 3.5) / 100;


    document.getElementById('div1').value = formatterPeso.format(div1);
    document.getElementById('div2').value = formatterPeso.format(div2);
    document.getElementById('div3').value = formatterPeso.format(div3);



    //SUBTOTAL
    var subtotal1 = prima1 + div1 + totalGas1 + buro;
    var subtotal2 = prima2 + div2 + totalGas2;
    var subtotal3 = prima3 + div3 + totalGas3;


    document.getElementById('subtotal1').value = formatterPeso.format(subtotal1);
    document.getElementById('subtotal2').value = formatterPeso.format(subtotal2);
    document.getElementById('subtotal3').value = formatterPeso.format(subtotal3);



    //IVA

    var iva1 = (subtotal1 * 16) / 100;
    var iva2 = (subtotal2 * 16) / 100;
    var iva3 = (subtotal3 * 16) / 100;


    document.getElementById('iva1').value = formatterPeso.format(iva1)
    document.getElementById('iva2').value = formatterPeso.format(iva2)
    document.getElementById('iva3').value = formatterPeso.format(iva3)



    //TOTAL

    var total1 = parseFloat(subtotal1) + parseFloat(iva1);
    var total2 = parseFloat(subtotal2) + parseFloat(iva2);
    var total3 = parseFloat(subtotal3) + parseFloat(iva3);



    document.getElementById('Total1').value = formatterPeso.format(total1);
    document.getElementById('Total2').value = formatterPeso.format(total2);
    document.getElementById('Total3').value = formatterPeso.format(total3);



    //PRIMAS
    document.getElementById('primaMinima').value = formatterPeso.format(prima1 * 0.35);
    document.getElementById('primaMinimaX').value = formatterPeso.format((prima1 * 0.35) * 0.70);
    document.getElementById('primaMinimaY').value = formatterPeso.format((prima1 * 0.35) * 0.50);

    //Cuadro 1

    document.getElementById('contrato1').value = formatterPeso.format(contrato);
    document.getElementById('contrato2').value = formatterPeso.format(contrato);
    document.getElementById('contrato3').value = formatterPeso.format(contrato);

    document.getElementById('montoAfianzado1').value = formatterPeso.format(monto1);
    document.getElementById('montoAfianzado2').value = formatterPeso.format(monto2);
    document.getElementById('montoAfianzado3').value = formatterPeso.format(monto3);

    //Total Cuadro 1
    document.getElementById('totalPagar1').value = formatterPeso.format(total1);
    document.getElementById('totalPagar2').value = formatterPeso.format(total2);
    document.getElementById('totalPagar3').value = formatterPeso.format(total3);

    document.getElementById('totalMontoAfianzado1').value = formatterPeso.format((monto1 + monto2 + monto3));
    document.getElementById('totalMontoPagar1').value = formatterPeso.format((total1 + total2 + total3));
    //Cuadro 2

    document.getElementById('totalPagarX1').value = formatterPeso.format(totalGas1);
    document.getElementById('totalPagarX2').value = formatterPeso.format(totalGas2);
    document.getElementById('totalPagarX3').value = formatterPeso.format(totalGas3);


    //Total
    var Total = totalGas1 + totalGas2 + totalGas3;
    document.getElementById('Total').value = formatterPeso.format(Total);


  }


  const formatterPeso = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0
  })

  function verDetalleX(estado, op) {
    divResultado = document.getElementById('divDetalleProspectos');
    var URL = ''
    if (op == 'agentes') {
      mes = document.getElementById('mesAgentes').value;
      selectedCoor = document.getElementById('selectCoordinator').selectedIndex;
      coor = document.getElementById('selectCoordinator').options[selectedCoor];
      var URL = "<?php echo base_url() ?>crmproyecto/funnelEstadoAgentes?estado=" + estado + "&mes=" + mes + "&coor=" + coor.value;
      //var URL="<?php echo base_url() ?>crmproyecto/funnelEstadoAgentes?estado="+estado+"&mes="+mes;
    }

    if (op == 'fianzas') {
      mes = document.getElementById('mesFianzas').value;
      var URL = "<?php echo base_url() ?>crmproyecto/funnelEstadoFianzas?estado=" + estado + "&mes=" + mes;
    }

    if (op == 'marketing') {
      mes = document.getElementById('mesMarketing').value;
      var URL = "<?php echo base_url() ?>crmproyecto/funnelEstadoMarketing?estado=" + estado + "&mes=" + mes;
    }
    ajax = objetoAjax();
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText;
      } else {
        divResultado.innerHTML = "<div class='alert alert-info'>No se encontraron resultados</div>";
      }
    }
    ajax.send(null)
  }

  function filtroProspeccionFianzas(mes) {
    divResultado = document.getElementById('divFunnelFianzas');
    var URL = "<?php echo base_url() ?>crmproyecto/filtroProspeccionFianzas?mes=" + mes.value;
    ajax = objetoAjax();
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText;
      }
    }
    ajax.send(null)
  }



  function filtroProspeccionAgentes(mes) {
    divResultado = document.getElementById('divFunnelAgentes');
    var URL = "<?php echo base_url() ?>crmproyecto/filtroProspeccionAgentes?mes=" + mes.value;
    ajax = objetoAjax();
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText;
      }
    }
    ajax.send(null)
  }

  function filtroEstadisticaMarketing(mes) {
    divResultado = document.getElementById('divEstadisticaMarketing');
    var URL = "<?php echo base_url() ?>crmproyecto/filtroEstadisticaMarketing?mes=" + mes.value;
    ajax = objetoAjax();
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText;
      }
    }
    ajax.send(null)
  }

  function foco(obj) {
    var afianzadora = obj.value;
    if (afianzadora == 'sofimex') {
      document.getElementById('TotalGas1').style.backgroundColor = '#ffd866';
      document.getElementById('TotalGas2').style.backgroundColor = '#fff';
      document.getElementById('TotalGas3').style.backgroundColor = '#fff';
      document.getElementById('TotalGas4').style.backgroundColor = '#fff';
      document.getElementById('TotalGas5').style.backgroundColor = '#fff';
      var monto = document.getElementById('TotalGas1').value;
    }
    if (afianzadora == 'liberty') {
      document.getElementById('TotalGas2').style.backgroundColor = '#ffd866';
      document.getElementById('TotalGas1').style.backgroundColor = '#fff';
      document.getElementById('TotalGas3').style.backgroundColor = '#fff';
      document.getElementById('TotalGas4').style.backgroundColor = '#fff';
      document.getElementById('TotalGas5').style.backgroundColor = '#fff';
      var monto = document.getElementById('TotalGas2').value;
    }

    if (afianzadora == 'chubb') {
      document.getElementById('TotalGas3').style.backgroundColor = '#ffd866';
      document.getElementById('TotalGas1').style.backgroundColor = '#fff';
      document.getElementById('TotalGas2').style.backgroundColor = '#fff';
      document.getElementById('TotalGas4').style.backgroundColor = '#fff';
      document.getElementById('TotalGas5').style.backgroundColor = '#fff';
      var monto = document.getElementById('TotalGas3').value;
    }

    if (afianzadora == 'tokyo') {
      document.getElementById('TotalGas4').style.backgroundColor = '#ffd866';
      document.getElementById('TotalGas1').style.backgroundColor = '#fff';
      document.getElementById('TotalGas2').style.backgroundColor = '#fff';
      document.getElementById('TotalGas3').style.backgroundColor = '#fff';
      document.getElementById('TotalGas5').style.backgroundColor = '#fff';
      var monto = document.getElementById('TotalGas4').value;
    }

    if (afianzadora == 'berkley') {
      document.getElementById('TotalGas5').style.backgroundColor = '#ffd866';
      document.getElementById('TotalGas1').style.backgroundColor = '#fff';
      document.getElementById('TotalGas2').style.backgroundColor = '#fff';
      document.getElementById('TotalGas4').style.backgroundColor = '#fff';
      document.getElementById('TotalGas3').style.backgroundColor = '#fff';
      var monto = document.getElementById('TotalGas5').value;
    }
    document.getElementById('gas1').value = monto;
    document.getElementById('gas2').value = monto;
    document.getElementById('gas3').value = monto;

  }

  function focoBuro(obj) {
    var buro = obj.value;
    if (buro == 'moral') {
      document.getElementById('costopersonaMoral').style.backgroundColor = '#ffd866';
      document.getElementById('costopersonaFisica').style.backgroundColor = '#fff';
      var monto = document.getElementById('costopersonaMoral').value;
    }
    if (buro == 'fisica') {
      document.getElementById('costopersonaFisica').style.backgroundColor = '#ffd866';
      document.getElementById('costopersonaMoral').style.backgroundColor = '#fff';
      var monto = document.getElementById('costopersonaFisica').value;
    }
    document.getElementById('buro1').value = monto;
  }

  function validacionPrimaMinima() {
    var primaMinima = document.getElementById('txtprimaMinima').value;
    if (!(isNaN(primaMinima))) {
      if (primaMinima == '') {
        alert('Debe ingresar una Prima Minima');
      } else {
        document.getElementById('frm_prima').submit();
        alert('Los datos se guardaron con exito!');
      }
    } else {
      alert('La prima minima suministrada debe ser numerica');
    }
  }


  function validacionBuro() {
    var txtMoral = document.getElementById('txtMoral').value;
    var txtFisica = document.getElementById('txtFisica').value;
    if (!(isNaN(txtMoral))) {
      if (!(isNaN(txtFisica))) {
        alert('El monto suministrado debe ser numerico');
      } else {
        document.getElementById('frm_buro').submit();
        alert('Los datos se guardaron con exito!');
      }
    }

  }



  function validacionAfianzadora() {
    var txtsofimex = document.getElementById('txtsofimex').value;
    var txtliberty = document.getElementById('txtliberty').value;
    var txttokyo = document.getElementById('txttokyo').value;
    var txtberkley = document.getElementById('txtberkley').value;

    if ((!(isNaN(txtsofimex))) || (!(isNaN(txtliberty))) || (!(isNaN(txttokyo))) ||
      (!(isNaN(txtberkley)))) {
      if ((txtsofimex == '') || (txtliberty == '') || (txttokyo == '') || (txtberkley == '')) {
        alert('Debe ingresar un monto');
      } else {
        document.getElementById('frm_afianzadora').submit();
        alert('Los datos se guardaron con exito!');
      }
    } else {
      alert('El monto suministrado debe ser numerico');
    }

  }

  function generarBoton(prima) {

    var primaminima = document.getElementById('PrimaMinima').value;
    if (prima >= primaminima) {
      document.getElementById('btnGenerar').style.display = 'block';
      document.getElementById('mensajeCorizador').style.display = 'none';

      document.getElementById('anticipo_contrato').value = document.getElementById('contrato1').value;

      if (document.getElementById('personaMoral').checked == true) {
        document.getElementById('tipo').value = 'moral';
      }

      if (document.getElementById('personaFisica').checked == true) {
        document.getElementById('tipo').value = 'fisica';
      }

      document.getElementById('anticipo_contrato').value = document.getElementById('contrato1').value;
      document.getElementById('anticipo_monto').value = document.getElementById('montoAfianzado1').value;
      document.getElementById('anticipo_total').value = document.getElementById('totalPagar1').value;

      document.getElementById('cumplimiento_contrato').value = document.getElementById('contrato2').value;
      document.getElementById('cumplimiento_monto').value = document.getElementById('montoAfianzado2').value;
      document.getElementById('cumplimiento_total').value = document.getElementById('totalPagar2').value;

      document.getElementById('vicios_contrato').value = document.getElementById('contrato3').value;
      document.getElementById('vicios_monto').value = document.getElementById('montoAfianzado3').value;
      document.getElementById('vicios_total').value = document.getElementById('totalPagar3').value;
    } else {
      document.getElementById('btnGenerar').style.display = 'none';
      document.getElementById('mensajeCorizador').style.display = 'block';
    }

  }

  function asignarPor(por) {
    var id = por.id;
    if (id == 'por1') {
      document.getElementById('txtporrpt1').value = por.value;
    }
    if (id == 'por2') {
      document.getElementById('txtporrpt2').value = por.value;
    }
    if (id == 'por3') {
      document.getElementById('txtporrpt3').value = por.value;
    }

    var obj = -1;
    calcular(obj);


  }


  function generarReportePdfFianzas() {
    document.getElementById('frmGenerar').submit();
  }

  function calcular_costo_leads(monto, op) {
    var monto = monto.value;
    if (!isNaN(monto)) {
      if (op == 1) {
        var totalFianzas = document.getElementById('fianzas').value;
        document.getElementById('totalFianzas').value = formatterPeso.format(parseFloat(monto) / parseFloat(totalFianzas));
      } else {
        var totalGmm = document.getElementById('gmm').value;
        document.getElementById('totalGmm').value = formatterPeso.format(parseFloat(monto) / parseFloat(totalGmm));
      }
    } else {
      alert('Debe ingresar solo numeros');
      document.getElementById('totalGmm').value = 0;
      document.getElementById('totalFianzas').value = 0;
    }
  }


  //*************Fin  
</script>
<script>
  const url = window.location;
  const params = new URLSearchParams(url.search);

  if (params.has("showGraph") === true) {
    cargarPagina("funnel");
  }

  $(document).on("submit", "#upload-prospective-list", function(e) {
    e.preventDefault();
    const file = $("#lista").val();
    const arrayFile = file.split(".");
    const formdata = new FormData(this);

    if (file.length == 0) {
      $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Favor de seleccionar un archivo</div>`);
      return false;
    }

    if (!["xlsx", "xls"].includes(arrayFile.pop())) {
      $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El formato no es el adecuado para la importación de registros.</div>`);
      return false;
    }

    const ajax = $.ajax({
      type: "POST",
      url: `<?= base_url() ?>crmproyecto/importProspectivesList`,
      data: formdata,
      contentType: false,
      processData: false,
      beforeSend: (data) => {
        $(".message").html(`<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Subiendo registros...</div>`);
      },
      success: (data) => {
        const response = JSON.parse(data);
        console.log(response);
        $(".message").html(`<div class="alert alert-${response.status == "failed" ? "danger" : "success"}" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>${response.message} (registros importados: ${response.data.count}).</div>`);
      },
      error: (error) => {
        $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ocurrió un error al importar los datos. Favor de contactar al depto de sistemas.</div>`);
      }
    });

  });

  function mostrarTotalProspectos() {
    let tr = document.getElementById('trTotalProscpectos');
    document.getElementById('prospectosTotalInfoLabel').innerHTML = tr.cells[0].innerHTML;
    document.getElementById('suspectosTotalInfoLabel').innerHTML = tr.cells[1].innerHTML;
    document.getElementById('perfiladosTotalInfoLabel').innerHTML = tr.cells[2].innerHTML;
    document.getElementById('cotizadosTotalInfoLabel').innerHTML = tr.cells[3].innerHTML;
    //document.getElementById('pagadosTotalInfo').innerHTML= '<label>MES ACTUAL:</label><label>8595'+tr.cells[4].innerHTML+'</label>';
    //document.getElementById('pagadosTotalInfoLabel').innerHTML= 5;
  }

  function guardarCancelarPuntos(datos = '', usuario = '', mes = '', anio = '', tipo = '') {
    if (datos == '') {
      parametros = `usuario=${usuario}&anio=${anio}&mes=${mes}&tipo=${tipo}`;
      peticionAJAX('crmproyecto/guardarCancelarPuntos/?', parametros, 'guardarCancelarPuntos');
    } else {

      alert(datos.mensaje);
      let tabla = Array.from(document.getElementById('consultarPuntosTbody').rows);
      tabla.forEach(t => {
        if (t.dataset.email == datos.usuario) {
          if (datos.tipo == 1) {

            t.cells[7].innerHTML = `<button class="btn btn-primary" onclick="guardarCancelarPuntos('','${datos.usuario}',${datos.mes},${datos.anio},'0')">Canjear</button>`;
          } else {
            t.cells[7].innerHTML = `<button class="btn btn-warning" onclick="guardarCancelarPuntos('','${datos.usuario}',${datos.mes},${datos.anio},'1')">Cancelar</button>`;
          }
        }
      })
    }
  }

  function verOcultar(id) {
    document.getElementById(id).classList.toggle('verObjeto');
    document.getElementById(id).classList.toggle('ocultarObjeto')
  }


  //Miguel Jaime 13-02-2023
  function filterByBant(option) {
    var bant = '';
    if (option == 'NEED') {
      bant = document.getElementById('selectBantNeed').value;
    }
    if (option == 'AUTH') {
      bant = document.getElementById('selectBantAut').value;
    }
    if (option == 'TIMING') {
      bant = document.getElementById('selectBantTiming').value;
    }

    divResultado = document.getElementById('panel');
    var URL = "<?php echo base_url() ?>crmproyecto/filtroByBant?option=" + option + "&bant=" + bant;
    ajax = objetoAjax();
    ajax.open("GET", URL);
    ajax.onreadystatechange = function() {
      if (ajax.readyState == 4) {
        divResultado.innerHTML = ajax.responseText;
      }
    }
    ajax.send(null)

  }




  function abrirGraficoProspeccion(
    id,
    casado,
    casado_hijos,
    divorciado,
    divorciado_hijos,
    soltero,
    soltero_hijos,
    unionlibre,
    unionlibre_hijos,
    viudo,
    viudo_hijos,
    MENOSDE18,
    DE19A35,
    DE36A50,
    DE51A65,
    amadecasa,
    ejecutivo,
    empleado,
    empresario,
    gerente,
    negociopropio,
    profesionistaindependiente,
    retirado,
    otrospempleos,
    estudiante,
    AMIGODEESCUELA,
    VECINOS,
    AMIGODEFAMILIA,
    CONOCIDOPASATIEMPOS,
    FAMPROPIAOCONYUGUE,
    CONOCIDOGRUPOSOCIAL,
    CONOCIDOACTIVICOMUNIDAD,
    CONOCIDOANTIGUOEMPLEO,
    PERSONASHACENEGOCIO,
    CENTRODEINFLUENCIA,
    HABILIDADEXCELENTE,
    HABILIDADBUENA,
    HABILIDADREGULAR,
    MENOSDE25000,
    DE25000A60000,
    DE6000A100000,
    MASDE100000,
    FACILMENTE,
    NOMUYDIFICIL,
    CONDIFICULTAD,
    bant_auht1,
    bant_auht2,
    bant_auht3,
    bant_need1,
    bant_need2,
    bant_need3,
    bant_timing_inmediato,
    bant_timing_sin_urgencia,
    bant_timing_largo_plazo
  ) {
    document.getElementById('usuario_grafico').innerHTML = '<h5><b>USUARIO:</b> ' + id + '</h5>';

    //Estado
    var ctx = document.getElementById('chartEdoCivil').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Casado', 'Casado con Hijos', 'Divorciado', 'Divorciado con Hijos', 'Soltero', 'Soltero con Hijos', 'Union Libre', 'Union Libre con Hijos', 'Viudo', 'Viudo con Hijos'],
        datasets: [{
          label: 'ESTADO CIVIL',
          data: [casado, casado_hijos, divorciado, divorciado_hijos, soltero, soltero_hijos, unionlibre, unionlibre_hijos, viudo, viudo_hijos],
          backgroundColor: [
            'rgba(0, 0, 255, 0.6)',
            'rgba(60, 179, 113, 0.6)',
            'rgba(255, 0, 0, 0.6)',
            'rgba(255, 165, 0, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)',
            'rgba(255, 99, 71, 0.6)',
            'rgba(82, 122, 162, 0.6)',
            'rgba(255, 253, 130, 0.6)'
          ],
          borderColor: [
            'rgba(0, 0, 255, 1)',
            'rgba(60, 179, 113, 1)',
            'rgba(255, 0, 0, 1)',
            'rgba(255, 165, 0, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)',
            'rgba(255, 99, 71, 1)',
            'rgba(82, 122, 162, 1)',
            'rgba(255, 253, 130, 1)'
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



    //Rango de Edad
    var ctx = document.getElementById('chartRango').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['MENOS DE 18', 'DE 19 A 35', 'DE 36 A 50', 'DE 51 A 65'],
        datasets: [{
          label: 'RANGO DE EDAD',
          data: [MENOSDE18, DE19A35, DE36A50, DE51A65],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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

    //Ocupacion
    var ctx = document.getElementById('chartOcupacion').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Ama de Casa', 'Ejecutivo', 'Empleado', 'Empresario', 'Gerente', 'Negocio Propio', 'Profesionista Independiente', 'Retirado', 'Otros Empleos', 'Estudiante'],
        datasets: [{
          label: 'OCUPACIÓN',
          data: [amadecasa, ejecutivo, empleado, empresario, gerente, negociopropio, profesionistaindependiente, retirado, otrospempleos, estudiante],
          backgroundColor: [
            'rgba(0, 0, 255, 0.6)',
            'rgba(60, 179, 113, 0.6)',
            'rgba(255, 0, 0, 0.6)',
            'rgba(255, 165, 0, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)',
            'rgba(255, 99, 71, 0.6)',
            'rgba(82, 122, 162, 0.6)',
            'rgba(255, 253, 130, 0.6)'
          ],
          borderColor: [
            'rgba(0, 0, 255, 1)',
            'rgba(60, 179, 113, 1)',
            'rgba(255, 0, 0, 1)',
            'rgba(255, 165, 0, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)',
            'rgba(255, 99, 71, 1)',
            'rgba(82, 122, 162, 1)',
            'rgba(255, 253, 130, 1)'
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


    //Fuente de prospecto
    var ctx = document.getElementById('chartFuente').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Amigos de la Escuela', 'Amigos de la Familia', 'Vecinos', 'Conocido a traves de Pasatiempos', 'Familia propia o Conyugue', 'Conocidos a traves de Grupos Sociales', 'Conocidos por la Actividad de la Comunidad', 'Conocidos de los Antiguos Empleos', 'Personas con la que hace Negocios', 'Centro de Influencia'],
        datasets: [{
          label: 'FUENTE DE PROSPECTO',
          data: [AMIGODEESCUELA, VECINOS, AMIGODEFAMILIA, CONOCIDOPASATIEMPOS, FAMPROPIAOCONYUGUE, CONOCIDOGRUPOSOCIAL, CONOCIDOACTIVICOMUNIDAD, CONOCIDOANTIGUOEMPLEO, PERSONASHACENEGOCIO, CENTRODEINFLUENCIA],
          backgroundColor: [
            'rgba(0, 0, 255, 0.6)',
            'rgba(60, 179, 113, 0.6)',
            'rgba(255, 0, 0, 0.6)',
            'rgba(255, 165, 0, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)',
            'rgba(255, 99, 71, 0.6)',
            'rgba(82, 122, 162, 0.6)',
            'rgba(255, 253, 130, 0.6)'
          ],
          borderColor: [
            'rgba(0, 0, 255, 1)',
            'rgba(60, 179, 113, 1)',
            'rgba(255, 0, 0, 1)',
            'rgba(255, 165, 0, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)',
            'rgba(255, 99, 71, 1)',
            'rgba(82, 122, 162, 1)',
            'rgba(255, 253, 130, 1)'
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


    //Habilidad Referencia
    var ctx = document.getElementById('chartHabilidadesReferencia').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['EXCELENTE', 'REGULAR', 'BUENA'],
        datasets: [{
          label: 'HABILIDAD PARA DAR REFERENCIA',
          data: [HABILIDADEXCELENTE, HABILIDADBUENA, HABILIDADREGULAR],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)'
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


    //Ingreso Mensual
    var ctx = document.getElementById('chartIngresoMensual').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Menos de $25.000', 'De $25.000 A $60.000', 'De $60.000 A $100.000', 'Mas de $100.000'],
        datasets: [{
          label: 'INGRESO MENSUAL',
          data: [MENOSDE25000, DE25000A60000, DE6000A100000, MASDE100000],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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


    //Posibilidad de acercamiento
    var ctx = document.getElementById('chartPosibilidad').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Facilmente', 'No muy Dificil', 'Con Dificultad'],
        datasets: [{
          label: 'POSIBILIDAD DE ACERCAMIENTO',
          data: [FACILMENTE, NOMUYDIFICIL, CONDIFICULTAD],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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


    //Nivel de Bant Authorithy
    var ctx = document.getElementById('chartBantAuthorithy').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['1', '2', '3'],
        datasets: [{
          label: 'BANT AUTHORITY (Que nivel de autoridad tiene el prospecto)',
          data: [bant_auht1, bant_auht2, bant_auht3],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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


    //Nivel de Bant Authorithy
    var ctx = document.getElementById('chartBantNeed').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['1', '2', '3'],
        datasets: [{
          label: 'BANT NEED (Qué nivel de urgencia tiene)',
          data: [bant_need1, bant_need2, bant_need3],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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


    //Nivel de Bant Timing
    var ctx = document.getElementById('chartBantTiming').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Inmediato', 'Sin Urgencia', 'Largo Plazo'],
        datasets: [{
          label: 'BANT TIMING  (Para cuando lo necesita)',
          data: [bant_timing_inmediato, bant_timing_sin_urgencia, bant_timing_largo_plazo],
          backgroundColor: [
            'rgba(82, 122, 162, 0.6)',
            'rgba(106, 90, 205, 0.6)',
            'rgba(238, 130, 238, 0.6)',
            'rgba(180, 180, 180, 0.6)'
          ],
          borderColor: [
            'rgba(82, 122, 162, 1)',
            'rgba(106, 90, 205, 1)',
            'rgba(238, 130, 238, 1)',
            'rgba(180, 180, 180, 1)'
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









    //fin de funcion
  }
</script>
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>-->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- Dennis Castillo [2021-10-31] -->
<script src="<?= base_url() . "assets/js/js_prospectiveAgentFunnel.js" ?>"></script> <!-- Dennis Castillo [2021-10-31] -->
<script src="<?= base_url() . "assets/js/js_prospectiveAgents.js" ?>"></script> <!-- Dennis Castillo [2021-10-31] -->
<style type="text/css">
  .perfilarProspecto {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2%
  }

  .perfilarProspecto>label {
    flex: 1;
  }

  .perfilarProspecto>select,
  input {
    flex: 3;
  }

  #tablaActivacion>thead {
    position: sticky;
    top: 0px;
  }

  #tablaActivacion {
    max-height: 300px
  }

  .table>thead {
    position: sticky;
    top: 0px;
  }

  html,
  body {
    max-width: 100%;
    overflow-x: hidden;
    overflow-y: scroll;
  }
</style>

<table border="1" class="ExcelTable2007" id="reporteComercialExportarTable">
  <tbody id="reporteComercialExportarBody" style="display: none">


  </tbody>
</table>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script type="text/javascript">
  function exportarReporteComercial() {



    let tr = document.getElementsByClassName('reporteComercialTR');
    let tableTR = '<tr><td>Agente</td><td>Tipo Agente</td><td>Perfilados</td><td>Primera cita</td><td>Segunda cota</td><td>Emisiones</td></tr>';
    for (let val of tr) {
      tableTR += `<tr><td>${val.cells[0].innerHTML}</td><td>${val.dataset.tipo}</td><td>${val.cells[1].innerHTML}</td><td>${val.cells[2].innerHTML}</td><td>${val.cells[3].innerHTML}</td><td>${val.cells[4].innerHTML}</td></tr>`
    }
    document.getElementById('reporteComercialExportarBody').innerHTML = tableTR;

    table = document.getElementById('reporteComercialExportarTable');
    let tableExport = new TableExport(table, {
      exportButtons: false, // No queremos botones
      filename: "PARTIDAS DE ACTIVIDADES", //Nombre del archivo de Excel
      sheetname: "ACTIVIDADES", //Título de la hoja
    });

    let datos = tableExport.getExportData();
    let preferenciasDocumento = datos.reporteComercialExportarTable.xlsx;

    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);


  }

  //-------------------------------------------------------------------------------------------------------------------------------

  //Formato Monetario | Creado [Suemy][2024-06-26]
  const money = {
    style: 'currency',
    currency: 'MXN'
  };
  const moneyFormat = new Intl.NumberFormat('es-MX', money);

  function getReportSalesByUser() { //Creado [Suemy][2024-06-26]
    const month = document.getElementById('monthReportMonthly').value;
    const year = document.getElementById('yearReportMonthly').value;
    const email = document.getElementById('userReportMonthly').value;
    const report = document.getElementById('typeReportMonthly').value;

    if (report == 3 || report == 4) {
      if (email == 0) {
        return swal("¡Espera!", "Debes seleccionar un correo.", "warning");
      }
    }
    $.ajax({
      url: `<?= base_url() ?>crmproyecto/getReportSales`,
      data: {
        mn: month,
        yr: year,
        em: email,
        rp: report,
        tp: 1
      },
      beforeSend: (load) => {
        $('#searchMonthly').prop('disabled', true);
        $('#btnExportReportSales').prop('disabled', true);
        $('#bodyTableReportSales').html(`
            <tr>
                <td colspan="7">
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
        `);
      },
      success: (data) => {
        const resp = JSON.parse(data);
        console.log(resp);
        let r = resp['result'];
        let dt = resp['date'];
        let dd = resp['data'];
        var com1 = 0;
        var com2 = 0;
        var com3 = 0;
        var com4 = 0;
        var trtd = ``;
        for (const a in r) {
          const num = Number(a) + 1;
          var week1 = (r[a].week1 != 0) ? (r[a].class != "indicator2" ? r[a].week1.length : r[a].week1) : 0;
          var week2 = (r[a].week2 != 0) ? (r[a].class != "indicator2" ? r[a].week2.length : r[a].week2) : 0;
          var week3 = (r[a].week3 != 0) ? (r[a].class != "indicator2" ? r[a].week3.length : r[a].week3) : 0;
          var week4 = (r[a].week4 != 0) ? (r[a].class != "indicator2" ? r[a].week4.length : r[a].week4) : 0;
          var btn = (r[a].class != "indicator2") ? `<button class="btn btn-primary viewIndicator" data-indicator="${num}"><i class="fa fa-eye"></i> Ver</button>` : "";
          var typeCom = 1;
          //Para Coordinadores
          if (dd['report'] == "3") {
            week1 = Number(r[a].week1);
            week2 = Number(r[a].week2);
            week3 = Number(r[a].week3);
            week4 = Number(r[a].week4);
            btn = ``;
            typeCom = 2;
          }
          //Obtener Comision
          if (r[a].tipo == "4") {
            com1 = com1 + get_comission_week(r[a].week1, typeCom);
            com2 = com2 + get_comission_week(r[a].week2, typeCom);
            com3 = com3 + get_comission_week(r[a].week3, typeCom);
            com4 = com4 + get_comission_week(r[a].week4, typeCom);
            week1 = moneyFormat.format(com1);
            week2 = moneyFormat.format(com2);
            week3 = moneyFormat.format(com3);
            week4 = moneyFormat.format(com4);
          }
          trtd += `
              <tr>
                <td class="${r[a].class}">${num}</td>
                <td class="${r[a].class}">${r[a].title}</td>
                <td>${week1}</td>
                <td>${week2}</td>
                <td>${week3}</td>
                <td>${week4}</td>
                <td>${btn}</td>
              </tr>
            `;
        }
        $('#monthExport').val(dd['month']);
        $('#yearExport').val(dd['year']);
        $('#emailExport').val(dd['user']);
        $('#reportExport').val(dd['report']);
        $('#bodyTableReportSales').html(trtd);
        $('#searchMonthly').prop('disabled', false);
        $('#btnExportReportSales').prop('disabled', false);
        $('.viewIndicator').click(function() {
          const val = $(this).data('indicator');
          var tab = `<div class="col-md-12 pd-left pd-right"><ul class="nav nav-tabs tab_capa"><li class="nav-item"><a class="nav-tab-link active" aria-current="page" href="#Sm1" role="tab" data-toggle="tab">Semana 1</a></li><li class="nav-item"><a class="nav-tab-link" aria-current="page" href="#Sm2" role="tab" data-toggle="tab">Semana 2</a></li><li class="nav-item"><a class="nav-tab-link" aria-current="page" href="#Sm3" role="tab" data-toggle="tab">Semana 3</a></li><li class="nav-item"><a class="nav-tab-link" aria-current="page" href="#Sm4" role="tab" data-toggle="tab">Semana 4</a></li></ul></div><div class="tab-content bg-tab-content-nav" id="cont-nav-indicator" style="margin:0px;height: 400px;">`;
          for (const a in r) {
            const num = Number(a) + 1;
            if (num == val) {
              $('#modalSubTitleIndicators').text(r[a].title);
              tab += draw_tab_table_week(r[a].week1, dt['week1'], 1, r[a].tipo);
              tab += draw_tab_table_week(r[a].week2, dt['week2'], 2, r[a].tipo);
              tab += draw_tab_table_week(r[a].week3, dt['week3'], 3, r[a].tipo);
              tab += draw_tab_table_week(r[a].week4, dt['week4'], 4, r[a].tipo);
            }
          }
          tab += `</div>`;
          $('#container-tab-indicator').html(tab);
          $(".indicators-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
          });
        })
      },
      error: (error) => {
        console.log(error);
        $('#searchMonthly').prop('disabled', false);
        $('#btnExportReportSales').prop('disabled', false);
      }
    })
  }

  function draw_tab_table_week(r, range, week, type) { //Creado [Suemy][2024-06-26]
    // console.log(range,week,type);
    var active = (week == 1) ? "active" : "";
    var tab = `<div class="col-md-12 tab-pane ${active} pd-left pd-right" id="Sm${week}"><div class="col-md-12 column-flex-center-center pd-items-table"><h5 class="textForm mg-cero">${range}</h5></div><div class="col-md-12 column-flex-center-end pd-right pd-items-table input-group input-small"><input class="form-control input-sm search-input" placeholder="Filtrar" id="filterTableWeek${week}" data-tbody="bodyTableWeek${week}" data-class="show-tr-week${week}" onkeyup="showFilterTable(this)"><div class="input-group-append"><button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableWeek${week}')"><i class="fas fa-eraser"></i></button></div></div><div class="col-md-12 container-table-tab-indicator"><table class="table table-striped" id="tabTableWeek${week}"><thead class="table-thead">`;
    switch (type) {
      case '1': //Prospectos
        tab += `<tr class="tr-style"><th>Fecha</th><th>Nombre Completo</th><th>Email</th><th>Teléfono</th><th>RFC</th><th>Razón Social</th><th>Estado Actual</th><th>Tipo</th><th>Observaciones</th><th>Actualizado</th></tr></thead><tbody id="bodyTableWeek${week}">`;
        if (r != 0) {
          for (const a in r) {
            const name = getTextValue(r[a].ApellidoP) + " " + getTextValue(r[a].ApellidoM) + " " + getTextValue(r[a].Nombre);
            tab += `
              <tr class="show-tr-week${week}">
                <td>${getDateFormat(r[a].fechaCreacionCA,1)}</td>
                <td>${name}</td>
                <td>${getTextValue(r[a].EMail1)}</td>
                <td>${getTextValue(r[a].Telefono1)}</td>
                <td>${getTextValue(r[a].RFC)}</td>
                <td>${getTextValue(r[a].RazonSocial)}</td>
                <td>${getTextValue(r[a].EstadoActual)}</td>
                <td>${getTextValue(r[a].tipoEntidad)}</td>
                <td>${getTextValue(r[a].observacion)}</td>
                <td>${getDateFormat(r[a].fechaActualizacion,1)}</td>
              </tr>
            `;
          }
        } else {
          tab += `<tr><td colspan="10"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        break;
      case '2': //Actividades
        tab += `<tr class="tr-style"><th>Folio Actividad</th><th>Id SICAS</th><th>Cliente</th><th>Actividad</th><th>SubRamo</th><th>Estado</th><th>Creador</th><th>Vendedor</th><th>Fecha Creación</th><th>Fecha Recepción</th></tr></thead><tbody id="bodyTableWeek${week}">`;
        if (r != 0) {
          for (const a in r) {
            const creador = `<label class="text-author-comment mg-cero">${getTextValue(r[a].nombreUsuarioCreacion)} <br> (${getTextValue(r[a].usuarioCreacion)})</label>`;
            const vendedor = `<label class="text-author-comment mg-cero">${getTextValue(r[a].nombreUsuarioVendedor)} <br> (${getTextValue(r[a].usuarioVendedor)})</label>`;
            tab += `
              <tr class="show-tr-week${week}">
                <td>${getTextValue(r[a].folioActividad)}</td>
                <td>${getTextValue(r[a].idSicas)}</td>
                <td>${getTextValue(r[a].nombreCliente)}</td>
                <td>${getTextValue(r[a].tipoActividad)}</td>
                <td>${getTextValue(r[a].subRamoActividad)}</td>
                <td>${getTextValue(r[a].Status_Txt)}</td>
                <td>${creador}</td>
                <td>${vendedor}</td>
                <td>${getDateFormat(r[a].fechaCreacion,1)}</td>
                <td>${getDateFormat(r[a].fechaActualizacion,1)}</td>
              </tr>
            `;
          }
        } else {
          tab += `<tr><td colspan="10"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        break;
      case '3': //Citas
        tab += `<tr class="tr-style"><th>Título Cita</th><th>Fecha Cita</th><th>Fecha Contacto</th><th>Nombre Completo</th><th>Email</th><th>Teléfono</th><th>RFC</th><th>Razón Social</th><th>Estado Actual</th></tr></thead><tbody id="bodyTableWeek${week}">`;
        if (r != 0) {
          for (const a in r) {
            const name = getTextValue(r[a].ApellidoP) + " " + getTextValue(r[a].ApellidoM) + " " + getTextValue(r[a].Nombre);
            const dateR = (getDateFormat(r[a].fechaCCC, 1).includes("undefined")) ? "" : getDateFormat(r[a].fechaCCC, 1);
            const dateC = (getDateFormat(r[a].fechaContactoCitaCCC, 1).includes("undefined")) ? "Ninguno" : getDateFormat(r[a].fechaContactoCitaCCC, 1);
            tab += `
              <tr class="show-tr-week${week}">
                <td>${getTextValue(r[a].comentarioCCC)}</td>
                <td>${dateR}</td>
                <td>${dateC}</td>
                <td>${name}</td>
                <td>${getTextValue(r[a].EMail1)}</td>
                <td>${getTextValue(r[a].Telefono1)}</td>
                <td>${getTextValue(r[a].RFC)}</td>
                <td>${getTextValue(r[a].RazonSocial)}</td>
                <td>${getTextValue(r[a].EstadoActual)}</td>
              </tr>
            `;
          }
        } else {
          tab += `<tr><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        break;
      case '4': //Comisiones
        tab += `<tr class="tr-style"><th>Fecha Pago</th><th>Tipo Docto</th><th>Documento</th><th>Nombre Completo</th><th>Prima Total</th><th>Comision</th><th>Oficina</th><th>Despacho</th><th>Nombre Gerencia</th><th>Grupo</th><th>SubGrupo</th><th>Ramo</th><th>SubRamo</th><th>Vendedor</th></tr></thead><tbody id="bodyTableWeek${week}">`;
        if (r != 0) {
          for (const a in r) {
            const comission = Number(r[a].Comision0) + Number(r[a].Comision1) + Number(r[a].Comision2) + Number(r[a].Comision3) + Number(r[a].Comision4) + Number(r[a].Comision5) + Number(r[a].Comision6) + Number(r[a].Comision7) + Number(r[a].Comision8) + Number(r[a].Comision9);
            tab += `
              <tr class="show-tr-week${week}" data-recibo="${r[a].IDRecibo}">
                <td>${getDateFormat(r[a].FechaPago,1)}</td>
                <td>${r[a].TipoDocto}</td>
                <td>${r[a].Documento}</td>
                <td>${getTextValue(r[a].NombreCompleto)}</td>
                <td>$${r[a].PrimaTotal}</td>
                <td>${comission}</td>
                <td>${r[a].OfnaNombre}</td>
                <td>${r[a].DespNombre}</td>
                <td>${r[a].GerenciaNombre}</td>
                <td>${r[a].Grupo}</td>
                <td>${r[a].SubGrupo}</td>
                <td>${r[a].RamosNombre}</td>
                <td>${r[a].SRamoNombre}</td>
                <td>${r[a].VendNombre}</td>
              </tr>
            `;
          }
        } else {
          tab += `<tr><td colspan="14"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        break;
    }

    tab += `</tbody></table></div></div>`;
    return tab;
  }

  function get_comission_week(r, type) { //Creado [Suemy][2024-06-26]
    var comission = 0;
    if (type != 2) {
      for (const a in r) {
        comission += parseFloat(Number(r[a].PrimaTotal));
      }
    } else {
      comission += parseFloat(r);
    }
    return comission;
  }

  function exportReportSales() { //Creado [Suemy][2024-06-26]
    document.formExportReportSales.submit();
  }

  function emailFilter(value) { //Creado [Suemy][2024-03-21]
    let group = $('#userReportMonthly optgroup');
    var type = "";
    $('#userReportMonthly').prop('disabled', false);
    switch (value) {
      case '1':
        $('#userReportMonthly').prop('disabled', true);
        $('#userReportMonthly optgroup option').css('display', '');
        $(group).css('display', '');
        break;
      case '2':
        type = "coord";
        showEmailByType(value, group, type);
        break;
      case '3':
        type = "coordcom";
        showEmailByType(value, group, type);
        break;
      case '4':
        type = "agente";
        showEmailByType(value, group, type);
        break;
    }
    $('#userReportMonthly option[value="0"]').prop('selected', true);
  }

  //-------------------------------------- OPERACIONES --------------------------------------

  function showEmailByType(value, data, type) {
    //console.log($(data).parent());    
    for (let i = 0; i < data.length; i++) {
      let option = data[i].children;
      var active = 0;
      //console.log(data[i].children);
      for (let j = 0; j < option.length; j++) {
        if (value == option[j].dataset[type]) {
          $(option[j]).css('display', '');
          active++;
        } else {
          $(option[j]).css('display', 'none');
        }
      }
      if (active > 0) {
        $(data[i]).css('display', '');
      } else {
        $(data[i]).css('display', 'none');
      }
    }
  }

  function statusCheckbox(obj) { //Creado [Suemy][2024-06-26]
    const value = obj.value;
    const type = $(obj).data('type');    
    $('input[type="checkbox"][data-type="'+type+'"]').prop('disabled',true);    
    $('input[type="checkbox"][data-type="'+type+'"]').prop('checked',false);
    if(document.getElementsByClassName('mensajeReferido').length>0)
  {document.getElementsByClassName('mensajeReferido')[0].classList.remove('flash')
    document.getElementsByClassName('mensajeReferido')[0].classList.remove('mensajeReferido')
    
    }
document.getElementById('referido'+obj.value).classList.add('mensajeReferido')
document.getElementById('referido'+obj.value).classList.add('flash')
    if (obj.checked) { $('input[type="checkbox"][data-type="'+type+'"][value="'+value+'"]').prop('disabled',false); }
  }

  function showFilterTable(obj) { //Creado [Suemy][2024-06-26]
    const val = $(obj).val().toUpperCase();
    const body = $(obj).data('tbody');
    const clase = $(obj).data('class');
    filterTable(val, body, clase);
  }

  function eraserFilterTable(filter) { //Creado [Suemy][2024-06-26]
    $('#' + filter).val("");
    $('#' + filter).keyup();
  }

  function filterTable(value, body, clase) { //Creado [Suemy][2024-06-26]
    var filter, panel, d, td, i, j, k, visible;
    var tr = "";
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
      } else {
        d[i].style.display = "none";
        $(d[i]).removeClass(clase);
      }
    }
    result = Fila.length;
  }

  function getTextValue(data) { //Creado [Suemy][2024-06-26]
    if (data == "[object Object]" || data == undefined || data == null || data == "") {
      data = "";
    }
    return data;
  }

  function getDateFormat(data, format) { //Creado [Suemy][2024-06-26]
    let nameM = new Array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
    let numbermonth = new Array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
    let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    let numberday = new Array("00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31");
    let monthname = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
    let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

    var dateF = "";

    if (data == undefined || data == null || data == "") {
      dateF = "";
    } else {
      if (!data.includes(':')) {
        data = data + " 00:00:00";
      }
      date = new Date(data);
      switch (format) {
        case 1:
          dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
          break;
        case 2:
          dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
          break;
        case 3:
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
          if (!data.includes('00:00:00')) {
            dateF = date.toLocaleTimeString('en-US');
          }
          break;
        case 10:
          dateF = dayname[date.getDate()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
          break;
      }
    }
    return dateF;
  }
  //-------------------------------------------------------------------------------------------------------------------------------
</script><!--
  Cotizaciones: como se enlazan los prospectos a las actividades si cuando se crea una actividad solo guarda los existentes?

-->
<script src="<?= base_url() . "assets/vuejs-bundles/diary_process/diaryService.js" ?>"></script> <!-- Dennis Castillo [2024-04-06] -->
<script src="<?= base_url() . "assets/vuejs-bundles/diary_process/diaryComponent.js" ?>"></script> <!-- Dennis Castillo [2024-02-29] -->  <style>
     .mensajeReferido{color:red}
     .mensajeReferido:after{content:'SI ES REFERIDO MARCAR ESTA CASILLA';display:flex;width:500px;padding-left:30px}
     .mensajeReferido {-webkit-animation-duration: 2s;animation-duration: 2;-webkit-animation-fill-mode: both;animation-fill-mode: both;
}
@-webkit-keyframes flash {0%, 50%, 100% {opacity: 1;}
25%, 75% {opacity: 0;}}
@keyframes flash {0%, 50%, 100% {opacity: 1;}25%, 75% {opacity: 0;}}
.flash {-webkit-animation-name: flash;animation-name: flash;}
  </style>
