  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-app.js"></script>
     <script src="https://www.gstatic.com/firebasejs/7.15.1/firebase-storage.js"></script>
<script>
  var firebaseConfig = {    
    apiKey: "AIzaSyAt0LKhc2LcZ7EIbRTIPSxTq1R8RrWnz2U",
    authDomain: "v3-plus-2.firebaseapp.com",
    //databaseURL: "https://v3-plus-2-default-rtdb.firebaseio.com/",
    projectId: "v3-plus-2",
    storageBucket: "v3-plus-2.appspot.com",
    messagingSenderId: "90046407574",
    appId: "1:90046407574:web:efa800e312ac7020baf3b7",
    measurementId: "G-7SLVDSJMBN"
  };

  firebase.initializeApp(firebaseConfig);
</script>

    <script type="text/javascript">

      google.charts.load('current', {'packages':['corechart','bar']});
      //google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawColumnas);
     // google.charts.setOnLoadCallback(drawColumnas);
var datosImpresion=[];
var optionsImpresion='';
      function drawChart1(div='',tipo='') 
      {
       if(div!='')
       {
        if(tipo=='')
        {
        let data = google.visualization.arrayToDataTable(datos);
        let chart = new google.visualization.PieChart(document.getElementById('piechart'));
          chart.draw(data, options);

       }
       else
       {
           if(tipo=='columnas')
           {
            let data = google.visualization.arrayToDataTable(datos);

            let chart = new google.visualization.Bar(document.getElementById('piechart'));
        chart.draw(data, options);
       }
      }
      }
    }


      function drawChart() {}



function drawColumnas()
{
        /*var data = google.visualization.arrayToDataTable(datosImpresion);
        var chart = new google.charts.Bar(document.getElementById('divGraficasColumnas'));
        chart.draw(data, optionsImpresion);*/
  }
          
 var data=[]; 
 var options = {title: 'My Daily Activities'};
 var dataColumnas=[];
 var optionsColumnas ={title: 'My Daily Activities'};

  //ASISTENTEDIRECCION@AGENTECAPITAL.COM
  //LAYORA2020
    </script>

  </head>

<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');   ?>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>



<div class="divPrincipal">

   <div class="col-md-1">
    <button class="buttonMenu" onclick="cambiaDivVista(0)" style="display: none;">NC</button><br>
    <button class="buttonMenu" onclick="cambiaDivVista(8)">
      <i class="fa fa-pencil-square-o fa-3x" style="margin-left: 8px;"></i>
      <p>NC</p>
    </button>
    <button class="buttonMenu" onclick="cerrarInconformidad()" id="divCerrarInconformidad" style="display: none;">Cerrar inconformi.</button>
    <!--button class="buttonMenu" onclick="cambiaDivVista(1)">Causa raiz</button><br>
    <button class="buttonMenu" onclick="cambiaDivVista(2)">Accion correctiva</button><br-->
    <button class="buttonMenu" onclick="cambiaDivVista(3)">
      <i class="fa fa-book fa-3x" aria-hidden="true"></i>
      <p>Reportes</p>
    </button>
    <button class="buttonMenu" onclick="cambiaDivVista(5)">
      <i class="fa fa-list-alt fa-3x" aria-hidden="true"></i>
      <p>Reporte Inciden.</p>
    </button>
    <button class="buttonMenu" onclick="cambiaDivVista(4)">
      <i class="fa fa-star fa-3x" aria-hidden="true"></i>
      <p>Reportes Estrellas</p>
    </button>
    <button class="buttonMenu" onclick="cambiaDivVista(6)">
      <i class="fa fa-bar-chart fa-3x" aria-hidden="true"></i>
      <p>Graficas</p>
    </button>
    <button class="buttonMenu" onclick="cambiaDivVista(7)">
      <i class="fa fa-star-half-empty fa-3x" aria-hidden="true"></i>
      <p>Calificaciones</p>
    </button>

   </div>
   <div class="col-md-11 col-xs-11">
   <div class="divContenido">
    <div class="divContenidoHijo ocultarObjeto">
      <h1>Manejo de Inconformidades</h1>
      <hr>
 <!--div style="width:100%;height: 80px;border:double;overflow:hidden;" id="scrollCabecera"><table border="1" class="tablaCabecera table"><thead id="theadNC"><tr><th class="divTD300"><label>Procedencia de inconformidad<select class="form-control" onchange="filtrarTabla(this,'tbodyNC')" data-busqueda="procedeenciainconformidad"><option value=""></option><option value="1">Validador</option><option value="2">NC para Agentes</option><option value="3">NC para operativos</option><option value="4">Buzon de inconformidad</option></select></label></th><th class="divTD100">Fecha</th><th class="divTD400">Persona inconforme</th><th class="divTD400">Persona responsable</th><th class="divTD400">Descripcion</th><th class="divTD100">Folio actividad</th><th class="divTD100">Tipo actividad</th><th class="divTD300">Datos alternos</th><th class="divTD300">Usuario Responsable</th><th class="divTD50"></th>
 </tr>
</thead>
</table>
</div>
<div onscroll="moverScroll()" id="scrollTabla" style="width:100%;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double;"><table border="1" id="tablaConsultarPuntos" class="table">
  <tbody id="tbodyNC" class="tbodyNC">
  <? /*buzonInconformidad($tiposNC['calificaUsuario']);*/?>
  <? //validador($tiposNC['calificaCliente']);?>
  <? //inconformidadParaOperativos($tiposNC['calificaAgente']);?>
  <? //inconformidadParaAgentes($tiposNC['calificaOperativo']);?>
  </tbody></table></div-->

    </div>
    <div class="divContenidoHijo ocultarObjeto">
      <h1>Agregar Causas de la Raiz</h1>
      <hr>
      <table border="1" id="tableACR" class="table">
        <thead>
          <tr>
            <th><input type="text" name="" id="textNombreACR" class="form-control" placeholder="Nombre de causa raiz"></th>
            <th>
              <div class="row">
              <div class="col-sm-10 col-md-10"><input type="text" name="" id="textDescripcionACR" class="form-control" placeholder="Descripcion"></div>
              <div class="col-sm-2 col-md-2"><button onclick="agregarCausaRaiz('')" class="btn btn-success">+</button></th></div>
            </div>
          </tr>

        </thead>
        <tbody id="bodyACR">
          <?= imprimirCausaRaiz($causaRaiz);?>
        </tbody>
      </table>
    </div>
    <div class="divContenidoHijo ocultarObjeto" >
<h1>Agregar Acciones Correctivas</h1>
<hr>
    <table border="1" class="table" id="tableAAC">
        <thead>
          <tr>

            <th><input type="text" name="" id="textNombreAAC" class="form-control" placeholder="Nombre de accion correctiva"></th>
            <th>
              <div class="row">
              <div class="col-sm-10 col-md-10"><input type="text" name="" id="textDescripcionAAC" class="form-control" placeholder="Descripcion"></div>
                <div class="col-sm-2 col-md-2"><button class="btn btn-success" onclick="agregarAccionCorrectiva('')">+</button></div>
              </div>
              </th>

          </tr>
        </thead>
        <tbody id="bodyAAC"><?= imprimirAccionCorrectiva($accionCorrectiva);?></tbody>
      </table>

    </div>
  <div class="divContenidoHijo ocultarObjeto" style="float: left;padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">Reportes</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr/>
    <div class="col-md-12" style="display: flex;align-items: flex-end;padding: 0px;margin-bottom: 10px;">
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Inicial:</label>
        <input  type="text" id="fechaInicial" name="fechaInicial" class="fecha form-control" >
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Final:</label>
        <input type="text" id="fechaFinal" name="fechaFinal" class="fecha form-control" >
      </div>
      <div class="col-md-2 width-ajust">
        <label class="width-ajust">Persona:</label>
        <select name="selectTipoPersonaReporte" id="selectTipoPersonaReporte" class="form-control" onchange="traerPersona('')">
          <option value="0"></option>
          <option value='3'>Agentes</option>
          <option value=1>Colaboradores</option>
        </select>
      </div>
      <div class="col-md-3 width-ajust">
        <label class="width-ajust">Escoger Responsable:</label>
        <select name="selectPersonaReporte" id="selectPersonaReporte" class="form-control"></select>
      </div>
      <div class="col-md-2 width-ajust">
        <button class="btn btn-primary" onclick="buscarReporte('')">Buscar</button>
      </div>
    </div>
    <div class="col-md-12 tab-items" style="padding: 0px;"> <!-- width: 285px; -->
      <ul class="nav nav-tabs">
        <li class="nav-item active">
          <a class="nav-tab-link active" aria-current="page" href="#TablaReportes" role="tab" data-toggle="tab">
              Reportes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-tab-link" aria-current="page" href="#TablaPersonas" role="tab" data-toggle="tab">
              Personas
          </a>
        </li>
      </ul>
    </div>
    <div class="tab-content bg-tab-content-poliza">
      <div class="col-md-12 tab-pane active" id="TablaReportes" style="padding: 0px;">
        <div class="col-md-12" style="height: 400px;overflow: auto;padding: 0px;">
          <table class="table table-reportes">
            <thead id="theadReporte" style="position: sticky;top: 0px">
              <tr>
                <th>Procedencia de Inconformidad</th>
                <th>Fecha creación</th>
                <th>Estatus de la Inconformidad</th>
                <th>Veredicto</th>
                <th>Persona Inconforme</th>
                <th>Persona Responsable</th>
                <th>Descripción</th>
                <th>Folio Actividad</th>
                <th>Tipo Actividad</th>
                <th>Datos Alternos</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody id="tbodyReporte"></tbody>
            <tfoot></tfoot>
          </table>
        </div>
      </div>
      <div class="col-md-12 tab-pane" id="TablaPersonas" style="padding: 0px;">
        <div class="col-md-12" style="height: 400px;overflow: auto;padding: 0px;" id="divReporteResponsables"></div>
      </div>
    </div>
  </div>
</div>

  <div class="divContenidoHijo ocultarObjeto" style="float: left;padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">Reportes Estrellas</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr/>
    <div class="col-md-12" style="display: flex;padding: 0px;margin-bottom: 10px;">
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Inicial:</label>
        <input  type="text" id="fechaInicialEstrellas" name="fechaInicial" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Final:</label>
        <input type="text" id="fechaFinalEstrellas" name="fechaFinal" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-1 width-ajust column-grid">
        <label>Filtro Fechas:</label>
        <div class="checkbox-container">
          <label class="segment">
          <input class="form-check-input checkbox-All" type="checkbox" id="checkboxEstrellas">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
      <div class="col-md-2 width-ajust" style="display: flex;align-items: flex-end;">
        <button class="btn btn-primary" onclick="reporteEstrellasAgente('')">
          <i class="fa fa-search" aria-hidden="true"></i> Buscar
        </button>
      </div>
    </div>
    <div class="col-md-12" style="height: 400px;overflow: auto;padding: 0px;">
      <table class="table table-reportes">
        <thead style="position: sticky;top: 0px;">
          <tr>
            <th>Agentes</th>
            <th style="text-align: right"><span style='font-size:20px;'>&#129489;</span></th>
            <th style="text-align: right"><label style="color:yellow">?</label> Clientes Nuevos</th>
            <th style="text-align: right"><label style="color:yellow">?</label> Clientes</th>      
            <th style="text-align: right"><label style="color:yellow">?</label> Total de Estrellas</th>      
          </tr>
        </thead>
        <tbody id="tbodyReporteEstrellas"></tbody>
      </table>
    </div>
  </div>

  <div class="divContenidoHijo ocultarObjeto" style="float: left;padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">Reportes Incidencias</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr/>
    <div class="col-md-12" style="display: flex;padding: 0px;margin-bottom: 10px;">
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Inicial:</label>
        <input  type="text" id="fechaInicialReporte" name="fechaInicialReporte" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Final:</label>
        <input type="text" id="fechaFinalReporte" name="fechaFinalReporte" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-1 width-ajust column-grid">
        <label>Todos</label>
        <div class="checkbox-container">
          <label class="segment">
          <input class="form-check-input checkbox-All" type="checkbox" id="cbTodosNoInconformidad" onclick="aplicarFiltroMeses()">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
      <div class="col-md-2 width-ajust" style="display: flex;align-items: flex-end;">
        <button class="btn btn-primary" onclick="buscarReporteIncidencias('')">
          <i class="fa fa-search" aria-hidden="true"></i> Buscar
        </button>
      </div>
      <div class="col-md-8 column-input-filter">
        <div class="col-md-4">
          <label>Filtrar:</label>
          <input class="form-control input-sm" placeholder="" id="filtrarFolio" onkeyup="filterReport()">
        </div>
      </div>
    </div>
    <div class="col-md-12" style="height: 400px;overflow: auto;padding: 0px;">
      <table class="table table-reportes" id="TableReportesIncidencias">
        <thead style="position: sticky;top: 0px;">
          <tr>
            <th>N°</th>
            <th>FOLIO</th>
            <th>RAMO</th>
            <th>PERSONA RESPONSABLE</th>
            <th>PERSONA INCONFORME</th>
            <th>CAUSA RAÍZ</th>
            <th>ACCIÓN CORRECTIVA</th>
            <th>VEREDICTO</th>
          </tr>
          <tbody id="bodyReporteIncidencias"></tbody>
        </thead>
      </table>
    </div>
  </div>

  <div class="divContenidoHijo ocultarObjeto" style="float: left;padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">Gráficas</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr/>
    <div class="col-md-12" style="display: flex;padding: 0px;margin-bottom: 10px;display: none">
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Inicial:</label>
        <input type="date" id="fecInicGraficas" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Fecha Final:</label>
        <input type="date" id="fecFinGraficas" class="fecha form-control" autocomplete="false">
      </div>
    </div>
    <div class="col-md-12" style="display: flex;padding: 0px;margin-bottom: 10px;">
      <div class="col-md-2 width-ajust">
        <label class="width-ajust">Tipo de Comparacion:</label>
        <select id="graficaTipoSelect" class="fecha form-control" autocomplete="false">
          <option value="Dia">Dia</option>
          <option value="Mes">Mes</option>
          <option value="Anio">Año</option>
        </select>
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Mes:</label>
        <select id="graficaMesSelect" class="fecha form-control" autocomplete="false"><?=imprimirMeses($meses)?></select>
      </div>
      <div class="col-md-1 width-ajust">
        <label class="width-ajust">Año:</label>
        <select id="graficaAnioSelect" class="fecha form-control" autocomplete="false"><?=imprimirAnios($anios)?></select>
      </div>
      <div class="col-md-2 width-ajust" style="display: flex;align-items: flex-end;">
        <button class="btn btn-primary" onclick="buscarReportesGraficas('')">
          <i class="fa fa-search" aria-hidden="true"></i> Buscar
        </button>
      </div>
    </div>
    <div class="col-md-12" style="height: 400px;overflow: auto;padding: 0px;">
      <div id="divGraficasColumnas"></div>
      <div id="divGraficasInter"></div>
      <div id="divGraficasCausaRaiz"></div> 
      <div id="divGraficasIncidencias"></div> 
      <div id="divTotalIncidencias"></div>
      <div id="divEstrellaGraficas"></div>
    </div>
  </div>
  <div class="divContenidoHijo ocultarObjeto" style="float: left;padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">Calificaciones</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
    <hr/>
    <div style="display: flex; align-items: center;"><label class="segment">
          <input class="form-check-input checkbox-All" type="checkbox" id="calificacionEjecutivos"><span class="checkmark"></span>
          </label><label style="padding-left: 1%; padding-top: .5%;">  Calificación de Ejecutivos</label>
        </div><br>
   <div class="col-md-12" style="display: flex;padding: 0px;margin-bottom: 10px;">

      <div class="col-md-2 width-ajust">
        <label class="width-ajust">Fecha Inicial:</label>
        <input  type="text" id="fechaInicialCalificaciones" name="fechaInicialCalificaciones" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-2 width-ajust">
        <label class="width-ajust">Fecha Final:</label>
        <input type="text" id="fechaFinalCalificaciones" name="fechaFinalCalificaciones" class="fecha form-control" autocomplete="false">
      </div>
      <div class="col-md-2 width-ajust column-grid">
        <label>Todos</label>
        <div class="checkbox-container">
          <label class="segment">
          <input class="form-check-input checkbox-All" type="checkbox" id="TodosCalificacion">
            <span class="checkmark"></span>
          </label>
        </div>
      </div>
      <div class="col-md-2 width-ajust" style="display: flex;align-items: flex-end;">
        <button class="btn btn-primary" onclick="buscarCalificacionesEjecutivos()">
          <i class="fa fa-search" aria-hidden="true"></i> Buscar
        </button>
      </div>

    </div>
    <div class="col-md-12" style="height: 500px;overflow: auto;padding: 0px;margin-top: 3%;">
      <div id="divGraficaCalificaciones" style="height: 400px;"></div>
    </div>
    <div class="row">
      <div id="tablacalificacionesbuena" class="col-md-6"></div>
      <div id="tablacalificacionesmala" class="col-md-6"></div>
    </div>
    
  </div>
  <div class="divContenidoHijo verObjeto divContenidoHijoNC" style="padding: 20px 0px;">
    <div class="row">
      <div class="col-md-8" style="display: flex;align-items: center;">
        <h4 class="title-Modulo">INCIDENCIAS - MÓDULO DE CALIDAD</h4><h4>(<span id="totalFiltroLabel"></span>)</h4>
      </div>
      <div class="col-md-6 col-sm-7 col-xs-7"></div>
    </div>
  <hr/>
  <div>
    <div class="col-md-12" style="display: flex; padding: 0px;margin-bottom: 10px;">
        <div class="col-md-1 width-ajust">
          <label>Persona</label>
          <select id="selectTipoPersona" class="form-control input-sm" onchange="traerOperativo('')">
            <option></option>
            <option>Agente</option>
            <option>Operativo</option>
          </select>
        </div>
        <div class="col-md-7 width-ajust" style="padding-right: 5px;">
          <label>Persona</label>
          <select id="selectPersona" class="form-control input-sm"></select>
        </div>
        <div class="col-md-1 width-ajust column-btn">
          <button class="btn btn-warning" onclick="agregarPersona()"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>
        <div class="col-md-1 width-ajust column-btn">
          <button class="btn btn-warning" onclick="borrarPersona()" title="Eliminar responsable"><i class="fa fa-minus" aria-hidden="true"></i></button>
        </div>
        <div class="col-md-2 width-ajust">
          <label>Filtro</label>
          <select id="selectFiltroMeses" class="form-control input-sm">
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
        <div class="col-md-1 width-ajust column-grid">
          <label>Aplicar filtro</label>
          <div class="checkbox-container">
            <label class="segment">
            <input class="form-check-input checkbox-All" type="checkbox" id="aplicarFiltroMeses" onclick="aplicarFiltroMeses()">
              <span class="checkmark"></span>
            </label>
          </div>
        </div>
        <div class="col-md-1 column-filter column-btn" style="padding: 0px;">
          <button class="btn btn-success" onclick="mostrarModalIncidencia(1)" title="AGREGAR DIGITAL">&#128193</button>
          <!-- abrirVentanaDigitales('divContenedorPadreDigital') -->
          <button class="btn btn-success" onclick="mostrarModalIncidencia(2)" title="AGREGAR COMENTARIO">&#128172</button>
          <!-- abrirVentanaDigitales('divComentarioBitacoraDigital') -->
          <button class="btn btn-success" onclick="mostrarModalNuevaTareaSeguimiento()" title="CREAR TAREA DE SEGUIMIENTO">&#128209</button>
        </div>

        <!-- 1. Add CSS to `<head>` -->
    <link href="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.css" rel="stylesheet">
<script type="text/javascript">
  /*function abrirVentanaDigitales(ventana='')
  {
    document.getElementById(ventana).classList.toggle('ocultarObjeto');

     if(!document.getElementById(ventana).classList.contains('ocultarObjeto'))
     {
        seleccion=tablaNoConformidad1.devolverRowSeleccionado(); 
        if(seleccion!='')
          {    if(ventana=='divContenedorPadreDigital')
            {
            trearArchivosInconformidad(seleccion.dataset.idtablanoconformidad)}
          }
         else{document.getElementById(ventana).classList.toggle('ocultarObjeto');}
     
    }
  }*/
</script>
<!-- 2. Add JS before the closing `</body>` -->

<!-- <div class="ocultarObjeto" id="divContenedorPadreDigital">
  <div style="display: flex;flex-direction: column;width:50%;height: 95%;overflow: scroll;position: fixed;z-index: 100; top:-0%" ><div style="background-color: #7264a9;position: sticky;top:0px;z-index: 1000;"><button class="btn btn-danger" onclick="abrirVentanaDigitales('divContenedorPadreDigital')">X</button><label class="label label-success">AGREGAR ARCCHIVOS A LA INCIDENCIA: </label><label id="agreagarArchivosLabel" class="label label-info"></label></div> <div id="drag-drop-area" style="height: 200px"></div><div id="mostrarArchivosInconformidad" style="width: 100%;height: 100%;background-color: white">
                  <div><button class="btn btn-primary" onclick="mostrarHijosArchivos(this,'mostrarArchivosInconforme')">-</button><label class="label label-info">Archivos Inconforme:</label><ul id="mostrarArchivosInconforme"></ul></div>
         <div><button class="btn btn-primary" onclick="mostrarHijosArchivos(this,'mostrarArchivosResuelto')">-</button><label class="label label-info">Archivos Resuelto</label><ul id="mostrarArchivosResuelto"></ul></div>
         <div><button class="btn btn-primary" onclick="mostrarHijosArchivos(this,'mostrarArchivosResponsable')">-</button><label class="label label-info">Archivos Responsable</label><ul id="mostrarArchivosResponsable"></ul></div>
       </div></div>
     </div> -->

        <!-- <div class="ocultarObjeto" id="divComentarioBitacoraDigital">
       <div style="display: flex;flex-direction: column;width:50%;height: 95%;overflow: scroll;position: fixed;z-index: 100; top:-0%" ><div style="background-color: #7264a9;position: sticky;top:0px;z-index: 1000;"><button class="btn btn-danger" onclick="abrirVentanaDigitales('divComentarioBitacoraDigital')">X</button><label class="label label-success">AGREGAR COMENTARIO PARA ACTIVIDAD: </label><label id="agreagarComentarioInconLabel" class="label label-info"></label></div> <div><textarea style="width: 100%;height: 300px" id="comentarioTextTareaInconformidad"></textarea></div><button class="btn btn-success" onclick="guardarBitacoraComentario()">&#128190</button></div>
     </div> -->
<!-- Modal Agregar Archivos -->
<div class="modal fade" id="modalAgregarArchivosIncidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="display: flex;align-items: center;">
        <h4 class="modal-title">Agregar archivos a la incidencia:</h4>
        <h4 class="modal-title" id="agreagarArchivosLabel" style="margin-left: 5px;"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body modal-body-subir-archivos">
        <div class="col-md-12">
          <div class="col-md-12" style="padding: 0px;">
            <div id="drag-drop-area" style="height: 200px"></div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-12" style="padding: 10px 15px;">
            <button class="btn-despliegue" onclick="mostrarHijosArchivos(this,'mostrarArchivosInconforme')"><i class="fa fa-minus" aria-hidden="true"></i></button>
            <label class="label-info subtitle-modal-files">Archivos Inconforme:</label>
            <ul id="mostrarArchivosInconforme"></ul>
          </div>
          <div class="col-md-12">
            <hr style="border-top: 1px solid #e3e3e3;">
          </div>
          <div class="col-md-12">
            <button class="btn-despliegue" onclick="mostrarHijosArchivos(this,'mostrarArchivosResuelto')"><i class="fa fa-minus" aria-hidden="true"></i></button>
            <label class="label-info subtitle-modal-files">Archivos Resuelto</label>
            <ul id="mostrarArchivosResuelto"></ul>
          </div>
          <div class="col-md-12">
            <hr style="border-top: 1px solid #e3e3e3;">
          </div>
          <div class="col-md-12">
            <button class="btn-despliegue" onclick="mostrarHijosArchivos(this,'mostrarArchivosResponsable')"><i class="fa fa-minus" aria-hidden="true"></i></button>
            <label class="label-info subtitle-modal-files">Archivos Responsable</label>
            <ul id="mostrarArchivosResponsable"></ul>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" >Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Agregar Comentario -->
<div class="modal fade" id="modalAgregarComentarioBitacora" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="display: flex;align-items: center;">
        <h4 class="modal-title">Agregar comentario para actividad:</h4>
        <h4 class="modal-title" id="agreagarComentarioInconLabel" style="margin-left: 5px;"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body modal-body-subir-archivos">
        <div class="col-md-12">
          <h4 class="title-modal-files">Escribe tus observaciones aquí:</h4>
          <div class="col-md-12" style="padding: 0px;">
            <textarea class="text-add-comment" id="comentarioTextTareaInconformidad"></textarea>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="guardarBitacoraComentario()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Archivos -->
<div class="modal fade" id="modal-archivos-inconformidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="display: flex;align-items: center;">
        <h4 class="modal-title">Archivos del folio</h4>
        <h4 class="modal-title" id="FolioInc" style="margin-left: 5px;"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body modal-body-archivos">
        <div class="col-md-12">
          <h4 class="title-modal-files">Subido recientemente</h4>
          <div class="col-md-12 files-center" id="NuevosArchInc">
            <span class="subtitle-modal-files">Inconforme:</span>
            <div class="col-md-12" id="NDocInc" style="padding-bottom: 5px;"></div>
            <span class="subtitle-modal-files">Resuelto:</span>
            <div class="col-md-12" id="NDocRlt" style="padding-bottom: 5px;"></div>
            <span class="subtitle-modal-files">Responsable:</span>
            <div class="col-md-12" id="NDocRpb"></div>
          </div>
        </div>
        <div class="col-md-12" style="display: flex;justify-content: center;">
          <div class="col-md-10">
            <hr style="border-top: 1px solid #e3e3e3; margin-top: 10px; margin-bottom: 5px;">
          </div>
        </div>
        <div class="col-md-12">
          <h4 class="title-modal-files">Todos los archivos</h4>
          <div class="col-md-12 files-center" id="TodosArchInc">
            <span class="subtitle-modal-files">Inconforme:</span>
            <div class="col-md-12" id="DocInc" style="padding-bottom: 5px;"></div>
            <span class="subtitle-modal-files">Resuelto:</span>
            <div class="col-md-12" id="DocRlt" style="padding-bottom: 5px;"></div>
            <span class="subtitle-modal-files">Responsable:</span>
            <div class="col-md-12" id="DocRpb"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar persona-->
<div class="modal " id="modal-eliminar-persona" >
          <div class="modal-dialog modal-dialog-centered modal-sm"  >
            <div class="modal-content">
              <div class="modal-header">
                
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
                  <i class="fa fa-times"></i>
                </button>
              </div>
              <div class="modal-body" id="body">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="eliminarResponsable()">Eliminar responsable</button>
              </div>
            </div>
          </div>
        </div>

<!-- Modal Crear Tarea Desde Incidencia -->
<div class="modal fade" id="modalCrearTareaDesdeIncidencia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="display: flex;align-items: center;">
        <h4 class="modal-title">Selecciona el proyecto en el que desea crear la tarea:</h4>
        <h4 class="modal-title" id="crearTareaDesdeIncidenciaTitleLabel" style="margin-left: 5px;"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <h4>Tus proyectos:</h4>
          <div class="col-md-12" style="padding: 0px;">
            <!-- select con la lista de proyectos a los que pertenece el usuario -->
            <select class="form-control" id="selectProyectoSeguimiento">
              <option value="" selected disabled>Selecciona un proyecto</option>
              <?=imprimirProyectosSeguimiento($proyectosSeguimiento);?>
            </select>
            <!-- textarea para que ingresen la descripcion de la tarea a generar -->
            <div class="col-md-12" style="padding: 0px; margin-top: 10px;">
              <textarea class="form-control" id="textareaProyectoSeguimiento" rows="4" placeholder="Escribe aqui la descripción de la tarea..."></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="crearTareaDesdeIncidencia()">Crear Tarea</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://transloadit.edgly.net/releases/uppy/v0.25.2/dist/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/v2.13.0/uppy.min.js"></script>
   <script src="https://releases.transloadit.com/uppy/v2.13.0/uppy.legacy.min.js" nomodule></script>
   <script src="https://releases.transloadit.com/uppy/locales/v2.1.1/es_ES.min.js"></script>



<script>

  var uppy = new Uppy.Core({ autoProceed: false,debug:true ,locale: Uppy.locales.es_ES})
  uppy.use(Uppy.Dashboard, { target: '#drag-drop-area', inline: true })
  uppy.use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})
  //uppy.use(Uppy.XHRUpload, { endpoint: 'https://mywebsite.com/receive-file.php' })
      uppy.on('complete', (result) => 
      {
      let archivos=uppy.getFiles();
      archivos.forEach(a=>
      {  
      var file=uppy.getFile(a.id);  

      seleccion=tablaNoConformidad1.devolverRowSeleccionado(); 
      //>var storage = firebase.storage().ref('inconformidades/'+seleccion.dataset.idtablanoconformidad+'/administrador/'+file.name);
      let folio=seleccion.dataset.folioinconformidad.replace('IN',"");
      console.log(folio); //Agregado por mi
      var storage = firebase.storage().ref('inconformidades/'+folio+'/administrador/'+file.name);
      var upload = storage.put(file.data);
      upload.on("state_changed", function progress(snapshot) {
          var percentage = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
          document.getElementById("progress").value = percentage;
        },

        

        function complete() {});
      })

        
      })

  //------------------------------------ Funciones del botón de archivos ------------------------------------------
  $(document).ready(function() {
    cargarArchivo();
  })

  //Fechas
  let numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
  let numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
  const hoy = new Date();
  //const horaHoy = hoy.toLocaleTimeString('en-US');
  const fechaAyer = hoy.getFullYear() + "-" + numeromeses[hoy.getMonth()] + "-" + numerodias[hoy.getDate()];
  const ayer = new Date(fechaAyer);
  //const horaAyer = ayer.toLocaleTimeString('en-US');

  function cargarArchivo() {
    var base = firebase.storage().ref('inconformidades');
    var folio = "";
    base.listAll().then((res) => {
      //console.log(res);
      res.prefixes.forEach((folderRef) => {
        //console.log(folderRef);

        const folio = folderRef.name;
        var storageRefInconforme = firebase.storage().ref('inconformidades/'+folio+'/inconforme/');
        var storageRefResuelto = firebase.storage().ref('inconformidades/'+folio+'/resuelto/');
        var storageRefResponsable = firebase.storage().ref('inconformidades/'+folio+'/administrador/');
        var fecha = "";
        var btn = `Abrir`;
        
        //Por Inconformidad
        storageRefInconforme.listAll().then(function(result) {
            result.items.forEach(function(urlFile) {
              var storage = firebase.storage().ref(urlFile.fullPath);
              storage.getMetadata().then((metadata) => {
                //console.log(metadata);
                fecha = new Date(metadata.timeCreated);
                //const horaFecha = fecha.toLocaleTimeString('en-US');
                //console.log(fecha.getTime(), ayer.getTime(), hoy.getTime(), folio, metadata.name);
                //console.log(fecha, horaFecha, ayer, horaAyer, hoy, horaHoy);
                if (fecha.getTime() >= ayer.getTime() && fecha.getTime() < hoy.getTime()) {
                  btn = `Abrir<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle" id="Notif${folio}"></span>`;
                }

                $('button[name="archivos"][data-folio="IN'+folio+'"]').addClass('archivos');
                $('button[name="archivos"][data-folio="IN'+folio+'"]').html(btn);
              })
            })
        })
      });
      res.items.forEach((itemRef) => {
          //console.log(itemRef);
      });
    })
    .catch((error) => {
        // Uh-oh, an error occurred!
    });
  }

  function filesInconformidad(inconformidad) {
    const nombrefolio = $(inconformidad).data('folio');
    const folio = nombrefolio.replace('IN',"");
    var storageRefInconforme = firebase.storage().ref('inconformidades/'+folio+'/inconforme/');
    var storageRefResuelto = firebase.storage().ref('inconformidades/'+folio+'/resuelto/');
    var storageRefResponsable = firebase.storage().ref('inconformidades/'+folio+'/administrador/');
    var fecha = "";
    var ar1 = ``;
    var ar2 = ``;
    var ar3 = ``;
    var li1 = ``;
    var li2 = ``;
    var li3 = ``;
    let href = "";

    $('#Notif'+folio).addClass('hidden');
    $('#FolioInc').text(nombrefolio);
    console.log(nombrefolio, folio);
    
    //Por Inconformidad
    storageRefInconforme.listAll().then(function(result) {
      if (result.items != 0) {
        result.items.forEach(function(urlFile) {
          var nombre = urlFile.name;  
          var storage = firebase.storage().ref(urlFile.fullPath);    
          let count=0;

          storage.getDownloadURL().then(function(url) {
            count++
            href = url;
          })

          storage.getMetadata().then((metadata) => {
            console.log(metadata);
            fecha = new Date(metadata.timeCreated);

            if (fecha.getTime() >= ayer.getTime() && fecha.getTime() < hoy.getTime()) {
              ar1 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              ar1 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
            }

            if (fecha.getTime() <= ayer.getTime()) {
              li1 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              li1 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
            }
            $('#NDocInc').html(ar1);
            $('#DocInc').html(li1);
          })
        })
      }
      else {
        ar1 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
        li1 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
      }
      $('#NDocInc').html(ar1);
      $('#DocInc').html(li1);
    })

    //Por Resuelto
    storageRefResuelto.listAll().then(function(result) {
      if (result.items != 0) {
        result.items.forEach(function(urlFile) {
          var nombre = urlFile.name;  
          var storage = firebase.storage().ref(urlFile.fullPath);    
          let count=0;

          storage.getDownloadURL().then(function(url) {
            count++
            href = url;
          })

          storage.getMetadata().then((metadata) => {
            console.log(metadata);
            fecha = new Date(metadata.timeCreated);

            if (fecha.getTime() > ayer.getTime() && fecha.getTime() < hoy.getTime()) {
              ar2 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              ar2 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
            }

            if (fecha.getTime() <= ayer.getTime()) {
              li2 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              li2 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
            }
            $('#NDocRlt').html(ar2);
            $('#DocRlt').html(li2);
          })
        })
      }
      else {
        ar2 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
        li2 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
      }
      $('#NDocRlt').html(ar2);
      $('#DocRlt').html(li2);
    })

    //Por Responsable
    storageRefResponsable.listAll().then(function(result) {
      if (result.items != 0) {
        result.items.forEach(function(urlFile) {
          var nombre = urlFile.name;  
          var storage = firebase.storage().ref(urlFile.fullPath);    
          let count=0;

          storage.getDownloadURL().then(function(url) {
            count++
            href = url;
          })

          storage.getMetadata().then((metadata) => {
            console.log(metadata);
            fecha = new Date(metadata.timeCreated);

            if (fecha.getTime() > ayer.getTime() && fecha.getTime() < hoy.getTime()) {
              ar3 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              ar3 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
            }
            if (fecha.getTime() <= ayer.getTime()) {
              li3 += `<li><a href="${href}" target="_blank">${nombre}</a></li>`;
            }
            else {
              li3 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
            }
            $('#NDocRpb').html(ar3);
            $('#DocRpb').html(li3);
          })
        })
      }
      else {
        ar3 = `<span style="font-size:13px; text-align: center">Ninguno</span>`;
        li3 = `<span style="font-size:13px; text-align: center">Ningún documento encontrado</span>`;
      }
      $('#NDocRpb').html(ar3);
      $('#DocRpb').html(li3);
    })

    $("#modal-archivos-inconformidad").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });

    /*let quitar = document.getElementById('Notif'+folio).parentNode;
    quitar.removeChild(document.getElementById('Notif'+folio));*/
  }

  function mostrarModalIncidencia(number) {
    if(document.getElementsByClassName('rowSeleccionadoTablaCapital')[0]) {
      if (number == 1) {
        seleccion=tablaNoConformidad1.devolverRowSeleccionado(); 
        if(seleccion!=''){
          trearArchivosInconformidad(seleccion.dataset.idtablanoconformidad);
        }

        $("#modalAgregarArchivosIncidencia").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
      }
      else {
        $("#modalAgregarComentarioBitacora").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
      }
    }
    else {
      swal("¡Espera!", "Debes escoger una fila.", "warning");
    }
  }

/**
 * Muestra el modal para crear la nueva tarea en el modulo de Seguimiento
 */
function mostrarModalNuevaTareaSeguimiento(){
  let selectedRows = document.getElementsByClassName('rowSeleccionadoTablaCapital');
  if (selectedRows.length === 0) {
    swal("¡Espera!", "Por favor, seleccione una fila.", "warning");
  } else if (selectedRows.length > 1) {
    swal("¡Espera!", "Solo puede seleccionar una fila.", "warning");
  } else {
    $("#modalCrearTareaDesdeIncidencia").modal({
      show: true,
      keyboard: false,
      backdrop: false,
    });
  }
}

/**
 * Validamos los datos ingresados por el usuario y entonces dispara el flujo para crear la nueva tarea en el modulo de Seguimiento
 */
function crearTareaDesdeIncidencia(){
  let selectElement = document.getElementById('selectProyectoSeguimiento');
  let idProyectoSeguimiento = selectElement.value;
  //console.log('id proyecto: ' + idProyectoSeguimiento);

  let textareaElement = document.getElementById('textareaProyectoSeguimiento');
  let descripcionTareaSeguimiento = textareaElement.value.trim();

  if(!idProyectoSeguimiento){
    swal("¡Espera!", "Por favor, seleccione un proyecto.", "warning");
    return;
  }

  if(descripcionTareaSeguimiento === ""){
    swal("¡Espera!", "Por favor, ingrese la descripción de la tarea.", "warning");
    return;
  }

  let selectedRows = document.getElementsByClassName('rowSeleccionadoTablaCapital');
  let selectedRow = selectedRows[0];
  let _idtablanoconformidad = selectedRow.dataset.idtablanoconformidad;
  //console.log('id tablanoconformidad', _idtablanoconformidad);
  
  let cells = selectedRow.getElementsByTagName('td');
  let _folio = cells[2].textContent;
  let _bitacora = cells[6].textContent;

  $.ajax({
    url: '<?=base_url()?>cproyecto/crearTareaDesdeIncidencia',
    type: 'POST',
    data: {
      idproyecto: idProyectoSeguimiento,
      descripcionTarea: descripcionTareaSeguimiento,
      noconformidad_id: _idtablanoconformidad,
      folio: _folio,
      bitacora: _bitacora
    },
    dataType: 'json',
    success: function (response) {
      console.log('respuesta', response);
      if(response.success){
        swal("¡Éxito!", "La operación se completó correctamente." + response.message, "success").then((willReload)=>{if(willReload){ window.location.reload()}});
        $("#modalCrearTareaDesdeIncidencia").modal("hide");
      }else{
        swal("¡Atención!", response.message, "info");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('respuesta', jqXHR);
      let errorMessage = jqXHR.responseText || "Error desconocido";
      console.error('error', errorMessage);
      swal("¡Error!", "Ha ocurrido un error al procesar su solicitud.", "error");
    }
  });
}

function guardarBitacoraComentario(datos=''){
  const comentario = document.getElementById('comentarioTextTareaInconformidad').value.trim();
  if(datos=='')  {
    seleccion=tablaNoConformidad1.devolverRowSeleccionado();
    if(seleccion!='')    {
      if(comentario !='')      {
        let parametros='';
        idTabla = seleccion.dataset.idtablanoconformidad
        //parametros='comentario='+document.getElementById('comentarioTextTareaInconformidad').value.trim();       
        //parametros+='&idtablanoconformidad='+seleccion.dataset.idtablanoconformidad;         
        //peticionAJAX('procesamientoNC/guardarBitacoraComentario',parametros,'guardarBitacoraComentario');
        $.ajax({
            type: "POST",
            url: `<?=base_url()?>procesamientoNC/guardarBitacoraComentario`,
            data: {
                idtablanoconformidad: idTabla,
                comentario: comentario
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const datos = JSON.parse(data);
                console.log(datos);
                swal("¡Listo!", "Comentario guardado.", "success");

                const bitacora = document.getElementById('Bit'+idTabla).innerHTML;
                const textarea = document.getElementById('textoTablaCelda').value;
                const text = bitacora.replace(/<br>/g,'')
                let cadena = datos.comentario+'      [ Usuario: '+datos.email+',        Fecha:'+datos.fecha+']<br>===============================<br>';
                let comment = `${datos.comentario}      [ Usuario: ${datos.email}, Fecha:${datos.fecha}] ===================================================================== 
`;
                
                document.getElementById('Bit'+idTabla).innerHTML = cadena + bitacora;
                $('#textoTablaCelda').val(comment+textarea);
            },
            error: (error) => {
                swal("¡Uups!", "Hay problemas al guardar comentario.", "error");
            }
        })
      }
      else{
        swal("¡Espera!", "Agrega un comentario para guardar.", "warning");
      }
    }
  }  
}
</script>

<script>

//import Uppy from '@uppy/core'
//import DragDrop from '@uppy/drag-drop'
//import Russian from '@uppy/locales/lib/ru_RU'

/*const uppy = new Uppy({
  debug: true,
  autoProceed: true,
  locale: Russian,
})*/
</script>   
    </div>
    <div style="display: flex;width: 100%;margin-bottom: 10px;">
      <textarea type="text" class="text-comment" id="textoTablaCelda" readonly=""></textarea>
      <div class="col-md-1 btn-comment">
        <button class="btn btn-success input-sm" style="padding: 5px 10px;" onclick="tablaNoConformidad1.guardarRowsConCambios('procesamientoNC/guardarCambiosNC')">&#128190</button>
        <button class="btn btn-warning input-sm" style="padding: 5px 10px;" onclick="tablaNoConformidad1.borrarRow('procesamientoNC/eliminarNoConformidadResuelta')">&#9940</button>
      </div>
    </div>
    <div style="display: none;"><select id="selectCausaRaizNC"></select><select id="selectAccionCorrectivaNC"></select><select id="selectVeredictoNC"><option value=""></option><option value="1">RESUELTO</option><option value="0">PENDIENTE</option></select><button onclick="guardarComentarioResponsableInconformeNC(1)">comentario inconforme</button><button onclick="guardarComentarioResponsableInconformeNC(2)">comentario responsable</button></div>    
    
    <div style="width: 100%;height: 350px;overflow: scroll;">
      <table id="tablaNoConformidadIncidencias">
        <thead>
          <tr>
            <th></th><th data-button="1" >ARCHIVOS</th><th data-inputtext="1" class="col-input-table"  style="vertical-align: bottom">FOLIO</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($tipoInconformidad,"tipoInconformidad")?>'  style="vertical-align: bottom">TIPO INCONFORMIDAD</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($inconformidad,"inconformidad")?>'  style="vertical-align: bottom">INCONFORMIDAD</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($area,"area")?>'  style="vertical-align: bottom">ÁREA</th><th data-bit="1">BITÁCORA</th><th data-ocultar="1"  style="vertical-align: bottom">COMENTARIO INCONFORME</th><th >RESPONSABLE</th><th data-ocultar="1"  style="vertical-align: bottom">COMENTARIO RESPONSABLE</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($causaRaiz,"causaRaiz")?>'  style="vertical-align: bottom">CAUSA RAÍZ</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($accionCorrectiva,"accionCorrectiva")?>'  style="vertical-align: bottom">ACCIÓN CORRECTIVA</th><th class="col-select-table" data-select='1' data-valores='<?=imprimirCausaRaizCabecera($statusNoConformidad,"status")?>'  style="vertical-align: bottom">ESTATUS</th>
          </tr>
        </thead>
       <tbody id="tbodyNC" style="background: #f8fcff;">
       <?= buzonInconformidad($tiposNC['calificaUsuario']);?>
       <? validador($tiposNC['calificaCliente']); ?>
       <?= inconformidadParaOperativos($tiposNC['calificaAgente']);?>
       <?= inconformidadParaAgentes($tiposNC['calificaOperativo']);?>
      </tbody></table>
    </div>
</div>
    </div>

</div><!--Fin del contenido-->

<style type="text/css">
  .divContenidoHijoNC{display: flex;flex-direction: column;width: 100%;/*height: 100%;overflow: scroll;*/}
</style>


<div id="divModalGenerico" class="modalCierra">
  <div style="width:95%;height: 90%;overflow: scroll;margin-left: 2%; margin-top: 2%">
  <div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button>
    <hr>
    <div class="row" style="margin-left: 5%">
        <label>Causa raiz<select id="selectCausaRaiz" class="form-control"></select></label>
        <label><input type="text" id="txtComentarioCausaRaiz" name="txtComentarioCausaRaiz" placeholder="Comentario para causa raiz " class="form-control"></label>
        <label>Accion correctiva<select id="selectAccionCorrectiva" class="form-control"></select></label>
         <label><input type="text" id="txtComentarioAccionCorrectiva" name="txtComentarioAccionCorrectiva" placeholder="Comentario para Accion Correctiva" class="form-control"></label>
        <div class="row"></div>
        <label>Veredicto<select id="selectVeredicto" class="form-control"><option value=""></option><option value="1">RESUELTO</option><option value="0">PENDIENTE</option></select></label>
        <label><input type="text" name="comentarioDeCierra" placeholder="agregar comentario de cierre" class="form-control" id="textComentarioCierre"></label>
        <label><select class="form-control" id="selectStatusNoConformidad"><option></option><option>Agente</option><option>Colaborador</option></select></label>        
        <div class="row" >
          <div class="col-xs-8">
        <input type="text" id="textNombreNoConformidad" class="form-control" placeholder="agregar descripcion a la no conformidad">

      </div>
        </div>

        <div><button class="btn btn-primary" onclick="guardarCambiosNoConformidad('')">Guardar Cambios</button>
<button class="btn btn-danger" onclick="cerrarNoConformidad('')">Cerrar Conformidad</button>
          <input type="hidden" id="textIdTablaNoConformidad"></div>
  </div></div>
    <div id="divModalContenidoGenerico" class="modal-contenido">
      <div class="row" id="divSubModalContenidoGenerico"></div>
       <br>
       


      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="row">
      <div class="modal-contenido row" style="height: 100px;width:90%"><textarea style="width: 100%; height: 80px; max-height: 100px" placeholder="A�adir comentario" id="textComentario"></textarea>
      </div>
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-4">
      <button class="btn btn-success" onclick="guardarComentarios('',0)"> Personal</button></div><div class="col-md-4 col-sm-4 col-xs-4"><button class="btn btn-success" onclick="guardarComentarios('',1)">Inconforme</button></div><div class="col-md-4 col-sm-4 col-xs-4"><button class="btn btn-success" onclick="guardarComentarios('',2)">Responsable</button></div></div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
      <table class="table"><thead><tr><th>Comentario<button onclick="actualizarComentario()" class="btn btn-success">Guardar</button><button onclick="eliminarComentario()" class="btn btn-danger">Eliminar</button></th></tr></thead><tbody id="bodyComentarios"></tbody></table>
    </div>
      </div>
      

      <h3>Responsables</h3>
      <div id="divContieneResponsables" style="border: solid black"></div>
      <div><button onclick="guardarResponsables('')" class="btn btn-success">Guardar Responsables</button></div>
    <div>
      <br>
      <hr>
    <div style="height: 400px;width:90%;overflow:scroll;">
  <table class="table">
    <tbody id="BodyNoConformidadesTrabajandose">
      
    </tbody>
  </table>
  </div>
</div>
    </div>

</div>

</div>
</div>
<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>

<? //php $this->load->view('footers/footer'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<script type="text/javascript">

function buscarReporteIncidencias(datos){
  if(datos=='')
  {
      let parametros='fechaInicial='+document.getElementById('fechaInicialReporte').value;
  parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinalReporte').value;
  if(document.getElementById('cbTodosNoInconformidad').checked)
  {parametros=parametros+'&mostrarTodos=1';}
  else{{parametros=parametros+'&mostrarTodos=0';}}
  if(document.getElementById('selectTipoPersonaReporte').value!=0)
  {
    parametros=parametros+'&Persona='+document.getElementById('selectTipoPersonaReporte').value;
  }
  if(document.getElementById('selectPersonaReporte').value!=0)
  {
    parametros=parametros+'&idPersona='+document.getElementById('selectPersonaReporte').value;
  }  
  peticionAJAX('procesamientoNC/buscarReporte',parametros,'buscarReporteIncidencias');

  }
  else
  {  

    
    let rows="";
    let cantidad=datos.calificaUsuario.length;
    let indice=0;
    if(datos.total==0){alert('No se encontraron NC en este rango de fechas');return false;}
  //BUZON DE INCONFOMIDAD
   for(let i=0;i<cantidad;i++) 
   {
    indice++;
    let comentarioInconforme='';
    let comentarioResponsable='';
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaUsuario[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaUsuario[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaUsuario[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
    for(let j=0;j<datos.calificaUsuario[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaUsuario[i].comentarioInconforme[j].comentarios+'<br>';}
        for(let j=0;j<datos.calificaUsuario[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaUsuario[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr class="mostrar">';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>Buzon Inconformidad</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].personaResponsable+'<label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].causaRaiz+':</label><br><label>'+datos.calificaUsuario[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaUsuario[i].accionCorrectiva+':</label><br><label>'+datos.calificaUsuario[i].comentarioAccionCorrectiva+'</label></td>';    
    if(datos.calificaUsuario[i].noConformidadRevisada==1){if(datos.calificaUsuario[i].aFavor==1){rows=rows+'<td><label class="labelComentarioPrincipal">A favor</label><br>'+datos.calificaUsuario[i].comentarioCierre+'</td>';}else{rows=rows+'<td><label class="labelComentarioPrincipal">PENDIENTE</label><br>'+datos.calificaUsuario[i].comentarioCierre+'</td>';}}
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';
  }

       cantidad=datos.calificaCliente.length;
  //VALIDADOR     
  for(let i=0;i<cantidad;i++) {
    indice++;
    let comentarioInconforme='';
    let comentarioResponsable='';
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaCliente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaCliente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaCliente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
                 for(let j=0;j<datos.calificaCliente[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaCliente[i].comentarioInconforme[j].comentarios+'<br>';}
            for(let j=0;j<datos.calificaCliente[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaCliente[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr class="mostrar">';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>Validador</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal>'+datos.calificaCliente[i].causaRaiz+':</label><br><label>'+datos.calificaCliente[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaCliente[i].accionCorrectiva+':</label><br><label>'+datos.calificaCliente[i].comentarioAccionCorrectiva+'</label></td>'; 
    if(datos.calificaCliente[i].noConformidadRevisada==1)
    { let veredicto='En contra';
      if(datos.calificaCliente[i].aFavor){veredicto='A favor';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaCliente[i].comentarioCierre+'</td>';
      
     }
          else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';
  }

       cantidad=datos.calificaAgente.length;
       //NC PARA OPERATIVOS
  for(let i=0;i<cantidad;i++) 
  {
    let select='<div>Responsables:<ul>';
    indice++;
    let comentarioInconforme='';
     let comentarioResponsable='';
    for(let j=0;j<datos.calificaAgente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaAgente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaAgente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';

       for(let j=0;j<datos.calificaAgente[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaAgente[i].comentarioInconforme[j].comentarios+'<br>';}
      for(let j=0;j<datos.calificaAgente[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaAgente[i].comentarioResponsable[j].comentarios+'<br>';}
    rows=rows+'<tr class="mostrar">';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].folioActividad+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].causaRaiz+':</label><br><label>'+datos.calificaAgente[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaAgente[i].accionCorrectiva+':</label><br><label>'+datos.calificaAgente[i].comentarioAccionCorrectiva+'</label></td>';
    if(datos.calificaAgente[i].noConformidadRevisada==1)
    {
          if(datos.calificaAgente[i].noConformidadRevisada==1)
    { let veredicto='En contra';
      if(datos.calificaAgente[i].aFavor){veredicto='A favor';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaAgente[i].comentarioCierre+'</td>';
      
     }
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';  
  }
  cantidad=datos.calificaOperativo.length;
       //NC PARA AGENTES
  for(let i=0;i<cantidad;i++) 
  {
    let select='<div>Responsables:<ul>';
    indice++;
    let comentarioInconforme='';
     let comentarioResponsable='';
    for(let j=0;j<datos.calificaOperativo[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaOperativo[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaOperativo[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
           for(let j=0;j<datos.calificaOperativo[i].comentarioInconforme.length;j++){comentarioInconforme=comentarioInconforme+datos.calificaOperativo[i].comentarioInconforme[j].comentarios+'<br>';}
           for(let j=0;j<datos.calificaOperativo[i].comentarioResponsable.length;j++){comentarioResponsable=comentarioResponsable+datos.calificaOperativo[i].comentarioResponsable[j].comentarios+'<br>';}
    let selectEstrella='<div>Estrellas:<ul style="width:200px">';
    for(let j=0;j<datos.calificaOperativo[i].estrellas.length;j++){
    let status='Mala';
    let clase='estrellaMala';
        if(datos.calificaOperativo[i].estrellas[j].calificacionActividad==1){status="Buena";clase="estrellaBuena"}
        selectEstrella=selectEstrella+'<li class="'+clase+'">'+status+'->'+datos.calificaOperativo[i].estrellas[j].calificacionAgente+'</li>';
      }
    selectEstrella=selectEstrella+'</ul></div>';
    rows=rows+'<tr class="mostrar">';
    rows=rows+'<td>'+indice+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].folioActividad+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].ramoActividad+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].personaResponsable+'</label><br>'+comentarioResponsable+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].personaInconforme+'</label><br>'+comentarioInconforme+'</td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].causaRaiz+':</label><br><label>'+datos.calificaOperativo[i].comentarioCausaRaiz+'</label></td>';
    rows=rows+'<td><label class="labelComentarioPrincipal">'+datos.calificaOperativo[i].accionCorrectiva+':</label><br><label>'+datos.calificaOperativo[i].comentarioAccionCorrectiva+'</label></td>';
 
    if(datos.calificaOperativo[i].noConformidadRevisada==1)
    {
          if(datos.calificaOperativo[i].noConformidadRevisada==1)
    { let veredicto='En contra';
      if(datos.calificaOperativo[i].aFavor){veredicto='A favor';}
      rows=rows+'<td><label class="labelComentarioPrincipal">'+veredicto+'</label><br>'+datos.calificaOperativo[i].comentarioCierre+'</td>';
      
     }
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'</tr>';

  }
   document.getElementById('bodyReporteIncidencias').innerHTML=rows;
  }
}

  function guardarCambiosNoConformidad(datos)
{
  if(datos=='')
  {
   let  parametros='';
   parametros=parametros+'causaRaiz='+document.getElementById('selectCausaRaiz').value;
   parametros=parametros+'&accionCorrectiva='+document.getElementById('selectAccionCorrectiva').value;
   parametros=parametros+'&veredicto='+document.getElementById('selectVeredicto').value;
   parametros=parametros+'&comentario='+document.getElementById('textComentarioCierre').value;
   parametros=parametros+'&status='+document.getElementById('selectStatusNoConformidad').value;
   parametros=parametros+'&nombre='+document.getElementById('textNombreNoConformidad').value;
   parametros=parametros+'&id='+document.getElementById('textIdTablaNoConformidad').value;
   parametros=parametros+'&comentarioCausaRaiz='+document.getElementById('txtComentarioCausaRaiz').value;
   parametros=parametros+'&comentarioAccionCorrectiva='+document.getElementById('txtComentarioAccionCorrectiva').value;
  peticionAJAX('procesamientoNC/guardarCambiosNoConformidad',parametros,'guardarCambiosNoConformidad');
  }
  else
  {
    
    let bodyNT=document.getElementById('BodyNoConformidadesTrabajandose');
    let body=document.getElementById('tbodyNC');
    let cantBody=body.rows.length;
    let rowModificado="";
    let cantBodyNT=bodyNT.rows.length;
    for(let i=0;i<cantBody;i++)
    {
      if(body.rows[i].getAttribute('data-idtablanoconformidad')==datos.datosNoConformidad[0].idTablaNoConformidad)
      {
       body.rows[i].setAttribute('data-estamodificado',datos.datosNoConformidad[0].estaModificado); 
       body.rows[i].setAttribute('data-idcausaraiz',datos.datosNoConformidad[0].idCausaRaiz);
       body.rows[i].setAttribute('data-idaccioncorrectiva',datos.datosNoConformidad[0].idAccionCorrectiva);
       body.rows[i].setAttribute('data-nombrenoconformidad',datos.datosNoConformidad[0].nombreNoConformidad);
       body.rows[i].setAttribute('data-statusnoconformidad',datos.datosNoConformidad[0].statusNoconformidad);
       body.rows[i].setAttribute('data-comentariocierre',datos.datosNoConformidad[0].comentarioCierre);
       body.rows[i].setAttribute('data-afavor',datos.datosNoConformidad[0].aFavor);
       body.rows[i].setAttribute('data-comentarioac',datos.datosNoConformidad[0].comentarioAccionCorrectiva);
       body.rows[i].setAttribute('data-comentariocr',datos.datosNoConformidad[0].comentarioCausaRaiz)
       i=cantBody;
      }
    }
        for(let i=0;i<cantBodyNT;i++)
    {
      if(bodyNT.rows[i].getAttribute('data-idtablanoconformidad')==datos.datosNoConformidad[0].idTablaNoConformidad)
      {
       bodyNT.rows[i].setAttribute('data-estamodificado',datos.datosNoConformidad[0].estaModificado); 
       bodyNT.rows[i].setAttribute('data-idcausaraiz',datos.datosNoConformidad[0].idCausaRaiz);
       bodyNT.rows[i].setAttribute('data-idaccioncorrectiva',datos.datosNoConformidad[0].idAccionCorrectiva);
       bodyNT.rows[i].setAttribute('data-nombrenoconformidad',datos.datosNoConformidad[0].nombreNoConformidad);
       bodyNT.rows[i].setAttribute('data-statusnoconformidad',datos.datosNoConformidad[0].statusNoconformidad);
       bodyNT.rows[i].setAttribute('data-comentariocierre',datos.datosNoConformidad[0].comentarioCierre);
       bodyNT.rows[i].setAttribute('data-afavor',datos.datosNoConformidad[0].aFavor);
       bodyNT.rows[i].setAttribute('data-comentarioac',datos.datosNoConformidad[0].comentarioAccionCorrectiva);
       bodyNT.rows[i].setAttribute('data-comentariocr',datos.datosNoConformidad[0].comentarioCausaRaiz)
       rowModificado=bodyNT.rows[i];
       
       i=cantBody;
      }
    }
    buscarInconformidadesModificadas();

  }
}
function actualizarComentario()
{
  let comentarioSeleccionado=document.getElementsByClassName('comentarioSeleccionado')[0];
  if(comentarioSeleccionado!=undefined)
  {
    
    let  parametros='';
    parametros='comentario='+comentarioSeleccionado.cells[0].innerHTML;
    parametros=parametros+'&idTNCComentarios='+comentarioSeleccionado.getAttribute('data-idcomentario');
    parametros=parametros+'&id='+document.getElementById('textIdTablaNoConformidad').value;
    
     peticionAJAX('procesamientoNC/actualizarComentario',parametros,'muestraComentarios');
  }
  else{alert('Escoger un comentario');}
}

function eliminarComentario()
{
  let comentarioSeleccionado=document.getElementsByClassName('comentarioSeleccionado')[0];
  if(comentarioSeleccionado!=undefined)
  {
    
    let  parametros='';
    parametros='comentario='+comentarioSeleccionado.cells[0].innerHTML;
    parametros=parametros+'&idTNCComentarios='+comentarioSeleccionado.getAttribute('data-idcomentario');
    parametros=parametros+'&id='+document.getElementById('textIdTablaNoConformidad').value;
   
     peticionAJAX('procesamientoNC/eliminarComentario',parametros,'muestraComentarios');
  }
  else{alert('Escoger un comentario');}
}
function guardarResponsables(datos)
{
  if(datos=='')
  {
      let idPersona="";
      let parametros='';
      parametros=parametros+'id='+document.getElementById('textIdTablaNoConformidad').value;
   let clase=document.getElementsByClassName('classPersona');
   let cantClase=clase.length;
   for(let i=0;i<cantClase;i++){
    idPersona=idPersona+clase[i].getAttribute('data-idPersona');
        if(clase[i].checked){idPersona=idPersona+'-1;';}
         else{idPersona=idPersona+'-0;';}
   }
    parametros=parametros+'&idPersona='+idPersona;
    peticionAJAX('procesamientoNC/guardarResponsables',parametros,'mostrarResponsables');
  }
  else
  {
    mostrarResponsables(datos);
  }
}
function borrarResponsable(objeto)
{
  let hijoElimnar=objeto.parentNode.parentNode;
  let padre=objeto.parentNode.parentNode.parentNode
  padre.removeChild(hijoElimnar);
}
function mostrarResponsables(datos)
{
  
 let cant=datos.responsables.length;
 let input="";
 for(let i=0;i<cant;i++)
 {let check='';
  if(datos.responsables[i].conformidadMala=='1'){check='checked="true"'}
  input=input+'<div><input type="checkbox" class="classPersona" data-idpersona="'+datos.responsables[i].idPersona+'" '+check+'><label>'+datos.responsables[i].apellidoPaterno+' '+datos.responsables[i].apellidoMaterno+' '+datos.responsables[i].nombres+'('+datos.responsables[i].email+')<button class="btn btn-danger" onclick="borrarResponsable(this)">-</button></div>';
 }
 document.getElementById('divContieneResponsables').innerHTML=input;
}
function guardarComentarios(datos,tipoComentario=null)
{
 if(datos=="")
 {
   let parametros='comentario='+document.getElementById('textComentario').value;
   parametros=parametros+'&id='+document.getElementById('textIdTablaNoConformidad').value;
   parametros=parametros+'&tipoComentario='+tipoComentario;
   parametros=parametros+'&idTNCComentarios=-1';
   
  //parametros=parametros+'&selectReporte='+document.getElementById('selectReporte').value;
  
  peticionAJAX('procesamientoNC/guardarComentarios',parametros,'muestraComentarios');
 }
 else{muestraComentarios(datos);}
}

function muestraComentarios(datos)
{
  let cant=datos.comentarios.length;
  let rows='';
  let rowsPersonal='<tr style="background-color:#f3fb73;color:black"><td><button class="btn btn-info btn-sm">-</button>Personal</td></tr>';
  let rowsInconforme='<tr style="background-color:#f3fb73;color:black"><td><button class="btn btn-info btn-sm">-</button>Inconforme</td></tr>';
  let rowsResponsable='<tr style="background-color:#f3fb73;color:black"><td><button class="btn btn-info btn-sm">-</button>Personal</td></tr>';
  
  for(let i=0;i<cant;i++)
  {
  
    switch(datos.comentarios[i].tipoComentario)
    {
      case '0':
          rowsPersonal=rowsPersonal+'<tr onclick="seleccionarComentario(this)" data-idcomentario="'+datos.comentarios[i].idTNCComentarios+'"><td contenteditable>'+datos.comentarios[i].comentarios+'</td></tr>';
          break;

      case '1':
          rowsInconforme=rowsInconforme+'<tr onclick="seleccionarComentario(this)" data-idcomentario="'+datos.comentarios[i].idTNCComentarios+'"><td contenteditable>'+datos.comentarios[i].comentarios+'</td></tr>';
          break;

      case '2':
          rowsResponsable=rowsResponsable+'<tr onclick="seleccionarComentario(this)" data-idcomentario="'+datos.comentarios[i].idTNCComentarios+'"><td contenteditable>'+datos.comentarios[i].comentarios+'</td></tr>';
          break;

    }

  }
  document.getElementById('bodyComentarios').innerHTML=rowsPersonal+rowsInconforme+rowsResponsable;
  mostrarResponsables(datos)
}
function seleccionarComentario(objeto)
{
  let padre=objeto.parentNode;
  
  let cant=padre.rows.length;
  for(let= i=0;i<cant;i++){padre.rows[i].classList.remove('comentarioSeleccionado');}
  objeto.classList.add('comentarioSeleccionado');
}
function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

function filtrarTabla(objeto,tablaProcedencia)
{
  let index=objeto.parentNode.cellIndex;
  let tabla=document.getElementById(tablaProcedencia);
  let cant=tabla.rows.length;
  let dataBusqueda=objeto.getAttribute('data-busqueda')
  let data='data-'+dataBusqueda;
  
  if(objeto.value=='')
   {
    for(let i=0;i<cant;i++){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);}
   }
 else
  {
    for(let i=0;i<cant;i++)
    {
     if(tabla.rows[i].getAttribute(data)==objeto.value){tabla.rows[i].classList.remove('ocultar'+dataBusqueda);}
     else{tabla.rows[i].classList.add('ocultar'+dataBusqueda);}
    }
  }
}



function enviarFormAjax(formulario,controlador,funcionControlador){
     var Data = new FormData(document.getElementById(formulario));
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  var direccion= <?php echo('"'.base_url().'"');?>+controlador+'/'+funcionControlador;
    Req.open("POST",direccion, true);

  Req.onload = function(Event) {
     
    if (Req.status == 200) {
      var respuesta = JSON.parse(Req.responseText);
        alert(respuesta.respuesta);

    } else {      }
  };

  //Enviamos la petici�n
  Req.send(Data);
}



  function ordenarFecha(body){
      body=document.getElementById(body);
      n=body.rows.length;

       for (k = 1; k < n; k++) {
              for (i = 0; i < (n - k); i++) {
               fechaInner1=body.rows[i].cells[2].innerHTML;
              fechaInner2=body.rows[i+1].cells[2].innerHTML;
              fecha1=Date.parse(fechaInner1);
              fecha2=Date.parse(fechaInner2);
            if(fecha1<fecha2){
              body.rows[i].parentNode.insertBefore(body.rows[i + 1], body.rows[i]);
            }
        }

       }


  }

  function cerrarNoConformidad(datos){
   if(datos==''){
   parametros='idCausaRaiz='+document.getElementById('selectCausaRaiz').value;
   parametros=parametros+'&idAccionCorrectiva='+document.getElementById('selectAccionCorrectiva').value;
   parametros=parametros+'&comentario='+document.getElementById('textComentario').value;
   parametros=parametros+'&veredicto='+document.getElementById('selectVeredicto').value;
   parametros=parametros+'&idTablaNoConformidad='+document.getElementById('textIdTablaNoConformidad').value;
   parametros=parametros+'&nombreNoConformidad='+document.getElementById('textNombreNoConformidad').value;
   let idPersona="";
   let clase=document.getElementsByClassName('classPersona');
   let cantClase=clase.length;
   for(let i=0;i<cantClase;i++){
    idPersona=idPersona+clase[i].getAttribute('data-idPersona');
        if(clase[i].checked){idPersona=idPersona+'-1;';}
         else{idPersona=idPersona+'-0;';}
   }
    parametros=parametros+'&idPersona='+idPersona;

   peticionAJAX('procesamientoNC/cerrarNoConformidad',parametros,'cerrarNoConformidad');

   }
   else
   {
       //let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');
   //document.getElementById('tbodyNC').deleteRow(rowSeleccionado[0].rowIndex-1);
    let bodyNT=document.getElementById('BodyNoConformidadesTrabajandose');
    let body=document.getElementById('tbodyNC');
    let cantBody=body.rows.length;
    let cantBodyNT=bodyNT.rows.length;
    for(let i=0;i<cantBody;i++)
    {
      if(body.rows[i].getAttribute('data-idtablanoconformidad')==datos.idTablaNoConformidad)
      {
        body.rows[i].parentNode.removeChild(body.rows[i]);
        i=cantBody;
      }
    }
        for(let i=0;i<cantBodyNT;i++)
    {
      if(bodyNT.rows[i].getAttribute('data-idtablanoconformidad')==datos.idTablaNoConformidad)
      {
        bodyNT.rows[i].parentNode.removeChild(bodyNT.rows[i]);
        i=cantBodyNT;
      }
    }
   document.getElementById('textIdTablaNoConformidad').value='';
   document.getElementById('textNombreNoConformidad').value='';
   document.getElementById('textComentario').value='';
     //document.getElementById('divModalGenerico').classList.toggle('modalCierra');
       //document.getElementById('divModalGenerico').classList.toggle('modalAbre');
    alert(datos.mensaje);
   }

  }

function traerOperativo(datos)
{

if(datos!=''){
let option='';
cantDatos=datos.length;

 /*for(let i=0;i<cantDatos;i++){
  option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';
 }*/
 cantDatos=datos.length;
 let select=""
 for(let i=0;i<cantDatos;i++)
 {
   select=select+'<optgroup label="'+datos[i].Name+'">';
   let cantOption=datos[i].Data.length;
   for(let j=0;j<cantOption;j++)
   {
    let nombre=datos[i].Data[j].apellidoPaterno+' '+datos[i].Data[j].apellidoMaterno+' '+datos[i].Data[j].nombres ;
    select=select+'<option value="'+datos[i].Data[j].idPersona+'">'+nombre+'('+datos[i].Data[j].email+')</option>';
   }

   select=select+'</optgroup>';
  //option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';
 }

 document.getElementById('selectPersona').innerHTML=select;
}
else
{
    
   if(document.getElementById('selectTipoPersona').value=='Operativo')
   {
    peticionGetAJAX('procesamientoNC/devolverOperativos/','','traerOperativo');
   }
   if(document.getElementById('selectTipoPersona').value=='Agente'){
    peticionGetAJAX('procesamientoNC/devolverAgentes/','','traerOperativo');
   }
}

}
function traerPersona(datos)
{

if(datos!=''){
let option='';
cantDatos=datos.length;
option=option+'<option value="0">Escoger</option>';
 for(let i=0;i<cantDatos;i++){
  option=option+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';
 }
 document.getElementById('selectPersonaReporte').innerHTML=option;
}
else
{

   if(document.getElementById('selectTipoPersonaReporte').value==1)
   {
    peticionGetAJAX('crmproyecto/devolverOperativos/','','traerPersona');
   }
   if(document.getElementById('selectTipoPersonaReporte').value==3){
    peticionGetAJAX('crmproyecto/devolverAgentes/','','traerPersona');
   }
   else
   {
    document.getElementById('selectPersonaReporte').innerHTML='';
   }
}

}
function reporteEstrellasAgente(datos)
{
 if(datos=='')
 {parametros='';
  if(document.getElementById('checkboxEstrellas').checked)
   {
     parametros='fechaInicial='+document.getElementById('fechaInicialEstrellas').value;
     parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinalEstrellas').value;
    
   }
   peticionGetAJAX('procesamientoNC/reporteEstrellasAgente?',parametros,'reporteEstrellasAgente');
 }
 else
 {
   let cant=datos.datos.length;
   let tbody="";
   let nombre="";
   let promClienteNuevo=0;
   let promCliente=0;
   let promTotal=0;
   for(let i=0;i<cant;i++)
   {
    nombre=datos.datos[i].apellidoPaterno+' '+datos.datos[i].apellidoMaterno+' '+datos.datos[i].nombres;
    promClienteNuevo=((parseFloat(datos.datos[i].sumClienteNuevo)*100)/parseFloat(datos.datos[i].totalClienteNuevo)).toFixed(2);
    promCliente=((parseFloat(datos.datos[i].sumCliente)*100)/parseFloat(datos.datos[i].totalCliente)).toFixed(2);
    promTotal=((parseFloat(datos.datos[i].sumTotal)*100)/parseFloat(datos.datos[i].total)).toFixed(2);
    if(isNaN(promClienteNuevo)){promClienteNuevo=0;}
    if(isNaN(promCliente)){promCliente=0;}
    if(isNaN(promTotal)){promTotal=0;}
    tbody=tbody+'<tr>';
    tbody=tbody+'<td>'+nombre+'</td>';
    tbody=tbody+'<td align="right">'+datos.datos[i].totalPersonas+'</td>';
    tbody=tbody+'<td align="right">'+datos.datos[i].sumClienteNuevo+'-'+datos.datos[i].totalClienteNuevo+'='+promClienteNuevo+'%</td>';
    tbody=tbody+'<td align="right">'+datos.datos[i].sumCliente+'-'+datos.datos[i].totalCliente+'='+promCliente+'%</td>';
    tbody=tbody+'<td align="right">'+datos.datos[i].sumTotal+'-'+datos.datos[i].total+'='+promTotal+'%</td>';
    tbody=tbody+'</tr>';
   }
  
   document.getElementById('tbodyReporteEstrellas').innerHTML=tbody;
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
          case 'traerPersona':traerPersona(respuesta);break;
          default: window[funcion](respuesta);
         }
      }
   }
  };
 req.send();
}
//----------------------------------------
function menejoDivGenerico(){
  document.getElementById('divModalGenerico').classList.toggle('modalCierra');
       document.getElementById('divModalGenerico').classList.toggle('modalAbre');
}
//----------------------------------------------------------------

/*  function buscaPersona(valor){
   alert(valor)
  }*/
function escogerNoConformidadModificada(row)
{
  let padre=row.parentNode;
  let cant=padre.rows.length;
  for(let i=0;i<cant;i++){padre.rows[i].classList.remove('ncModificadaSeleccionada');}
  row.classList.add('ncModificadaSeleccionada');
asiganValores(row);
    let parametros="";
  parametros=parametros+'id='+document.getElementById('textIdTablaNoConformidad').value;
  peticionAJAX('procesamientoNC/obtenerComentarios',parametros,'muestraComentarios');

}
function buscarInconformidadesModificadas()
{
  let tabla=document.getElementById('tbodyNC');
  let cant=tabla.rows.length;
  let insertar="";
  /*insertar=document.getElementById('theadNC').innerHTML;*/
  
  for(let i=0;i<cant;i++)
  {
    //if(tabla.rows[i].getAttribute('data-estamodificado')=='1')
    //{
      insertar=insertar+'<tr onclick="escogerNoConformidadModificada(this)" data-idtablanoconformidad="'+tabla.rows[i].getAttribute('data-idtablanoconformidad')+'"';
      insertar=insertar+' data-idpersonaresponsable="'+tabla.rows[i].getAttribute('data-idpersonaresponsable')+'"';
      insertar=insertar+' data-nombre="'+tabla.rows[i].getAttribute('data-nombre')+'"';
      insertar=insertar +' data-procedeenciainconformidad="'+tabla.rows[i].getAttribute('data-procedeenciainconformidad')+'"';
      insertar=insertar+' data-estamodificado="'+tabla.rows[i].getAttribute('data-estamodificado')+'"';
      insertar=insertar +' data-idcausaraiz="'+tabla.rows[i].getAttribute('data-idcausaraiz')+'"';
      insertar=insertar +' data-idaccioncorrectiva="'+tabla.rows[i].getAttribute('data-idaccioncorrectiva')+'"';
      insertar=insertar +' data-nombrenoconformidad="'+tabla.rows[i].getAttribute('data-nombrenoconformidad')+'"';
      insertar=insertar +' data-statusnoconformidad="'+tabla.rows[i].getAttribute('data-statusnoconformidad')+'"';
      insertar=insertar +' data-comentariocierre="'+tabla.rows[i].getAttribute('data-comentariocierre')+'"';
      insertar=insertar +' data-afavor="'+tabla.rows[i].getAttribute('data-afavor')+'"';
      insertar=insertar +' data-comentariocr="'+tabla.rows[i].getAttribute('data-comentariocr')+'"';
      insertar=insertar +' data-comentarioac="'+tabla.rows[i].getAttribute('data-comentarioac')+'">';
      insertar=insertar+tabla.rows[i].innerHTML;
      insertar=insertar+'</tr>';
    //}
  }

  document.getElementById('BodyNoConformidadesTrabajandose').innerHTML=insertar;
}
//---------------------------------
function asiganValores(row)
{
  //document.getElementById('').value=row.
  document.getElementById('selectCausaRaiz').value=row.getAttribute('data-idcausaraiz');
  document.getElementById('selectAccionCorrectiva').value=row.getAttribute('data-idaccioncorrectiva');
  document.getElementById('textNombreNoConformidad').value=row.getAttribute('data-nombrenoconformidad');
  document.getElementById('selectStatusNoConformidad').value=row.getAttribute('data-statusnoconformidad');
  document.getElementById('textComentarioCierre').value=row.getAttribute('data-comentariocierre');
  document.getElementById('selectVeredicto').value=row.getAttribute('data-afavor');
   document.getElementById('textIdTablaNoConformidad').value=row.getAttribute('data-idtablanoconformidad');
  document.getElementById('txtComentarioCausaRaiz').value=row.getAttribute('data-comentariocr');
  document.getElementById('txtComentarioAccionCorrectiva').value=row.getAttribute('data-comentarioac');
}
//---------------------------------
  function cerrarInconformidad(){
    let rowSeleccionado=document.getElementsByClassName('rowSeleccionado');

    if(rowSeleccionado.length>0){

      document.getElementById('divSubModalContenidoGenerico').innerHTML='<div style="width: 80%;height:150px;margin-left:5%;overflow:scroll"><table border="1" >'+document.getElementById('theadNC').innerHTML+'<tbody><tr>'+rowSeleccionado[0].innerHTML+'</tr></tbody></table></div>';
       document.getElementById('divModalGenerico').classList.toggle('modalCierra');
       document.getElementById('divModalGenerico').classList.toggle('modalAbre');
       document.getElementById('divContieneResponsables').innerHTML='';
       document.getElementById('textComentario').value='';
       
       document.getElementById('textIdTablaNoConformidad').value=rowSeleccionado[0].getAttribute('data-idTablaNoConformidad');
  //if(rowSeleccionado[0].getAttribute('data-idPersonaResponsable')!=''){
       let div=document.createElement('div');
  let input=document.createElement('input');
  input.setAttribute('type','checkbox');
  input.setAttribute('class', 'classPersona')
  input.setAttribute('data-idPersona',rowSeleccionado[0].getAttribute('data-idPersonaResponsable'));
  div.appendChild(input);
  let label=document.createElement('label');
  label.innerHTML=rowSeleccionado[0].getAttribute('data-nombre');
  div.appendChild(label);
  document.getElementById('divContieneResponsables').appendChild(div);

  buscarInconformidadesModificadas();
  asiganValores(rowSeleccionado[0]);
    let parametros="";
  parametros=parametros+'id='+document.getElementById('textIdTablaNoConformidad').value;
  peticionAJAX('procesamientoNC/obtenerComentarios',parametros,'muestraComentarios');
//}

    }
    else{
      alert('Elegir inconformidad');
    }
  }
  function seleccionaRowInconformidad(trObjeto){
    let tbody=trObjeto.parentNode;
     cantRows=tbody.rows.length;
     for(let i=0;i<cantRows;i++){
      tbody.rows[i].classList.remove('rowSeleccionado');
     }
     trObjeto.classList.add('rowSeleccionado');
  }
  function cambiaDivVista(intVista){

    var divVista=document.getElementsByClassName('divContenidoHijo');
    var cant=divVista.length;
    for(var i=0;i<cant;i++){
      divVista[i].classList.add('ocultarObjeto');
      divVista[i].classList.remove('verObjeto');
    }
    divVista[intVista].classList.remove('ocultarObjeto');
    divVista[intVista].classList.add('verObjeto');

  }

function agregarCausaRaiz(datos){
 if(datos==""){
  let parametros='nombreCausaRaiz='+document.getElementById('textNombreACR').value;
  parametros=parametros+'&descripcionCausaRaiz='+document.getElementById('textDescripcionACR').value;
  peticionAJAX('procesamientoNC/causaRaiz',parametros,'agregarCausaRaiz');
 }else {

   document.getElementById('bodyACR').insertRow(0);
   document.getElementById('bodyACR').rows[0].setAttribute('data-idcausaraiz', datos.causaRaiz[0].idCausaRaiz)
   document.getElementById('bodyACR').rows[0].insertCell(0);
   document.getElementById('bodyACR').rows[0].insertCell(1);
  document.getElementById('bodyACR').rows[0].cells[0].innerHTML=datos.causaRaiz[0].causaRaiz;
  document.getElementById('bodyACR').rows[0].cells[2].innerHTML=datos.causaRaiz[0].descripcionCausaRaiz;
  llenaSelectCR();
 }
}
function agregarAccionCorrectiva(datos){
  if(datos==""){
  let parametros='nombreAccionCorrectiva='+document.getElementById('textNombreAAC').value;
  parametros=parametros+'&descripcionAccionCorrectiva='+document.getElementById('textDescripcionAAC').value;
  peticionAJAX('procesamientoNC/accionCorrectiva',parametros,'agregarAccionCorrectiva');
 }
 else {
     document.getElementById('bodyAAC').insertRow(0);
   document.getElementById('bodyAAC').rows[0].setAttribute('data-idaccioncorrectiva', datos.accionCorrectiva[0].idAccionCorrectiva)
   document.getElementById('bodyAAC').rows[0].insertCell(0);
   document.getElementById('bodyAAC').rows[0].insertCell(1);
  document.getElementById('bodyAAC').rows[0].cells[0].innerHTML=datos.accionCorrectiva[0].accionCorrectiva;
  document.getElementById('bodyAAC').rows[0].cells[2].innerHTML=datos.accionCorrectiva[0].descripcionAccionCorrectiva;
  llenaSelectAC();
  }
}
function buscarReporte(datos){
 if(datos==""){
  let parametros='fechaInicial='+document.getElementById('fechaInicial').value;
  parametros=parametros+'&fechaFinal='+document.getElementById('fechaFinal').value;
  if(document.getElementById('selectTipoPersonaReporte').value!=0)
  {
    parametros=parametros+'&Persona='+document.getElementById('selectTipoPersonaReporte').value;
  }
  if(document.getElementById('selectPersonaReporte').value!=0)
  {
    parametros=parametros+'&idPersona='+document.getElementById('selectPersonaReporte').value;
  }

  //parametros=parametros+'&selectReporte='+document.getElementById('selectReporte').value;
  peticionAJAX('procesamientoNC/buscarReporte',parametros,'buscarReporte');
 }
 else
 {
    if(datos.mensaje!='') {alert(datos.mensaje)}
    else{
      
      let rows="";
      let cantidad=datos.calificaUsuario.length;
      if(datos.total==0){alert('No se encontraron NC en este rango de fechas');return false;}

  for(let i=0;i<cantidad;i++) {

  let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaUsuario[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaUsuario[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaUsuario[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';

    rows=rows+'<tr>';
    rows=rows+'<td><div>Buzon inconformidad</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaUsuario[i].noConformidadRevisada==1)
    {
      if(datos.calificaUsuario[i].aFavor==1){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaUsuario[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].personaResponsable+'</td>';

    if(datos.calificaUsuario[i].descripcion){rows=rows+'<td>'+datos.calificaUsuario[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
   // rows=rows+'<td>'+datos.calificaUsuario[i].datosAlternos+'</td>';
let datosalternos=(datos.calificaUsuario[i].datosAlternos!=null) ? datos.calificaUsuario[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaUsuario[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';
  }

       cantidad=datos.calificaCliente.length;
       
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaCliente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaCliente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaCliente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';
    rows=rows+'<tr>';
    rows=rows+'<td><div>Validador</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaCliente[i].noConformidadRevisada==1)
    {
      if(datos.calificaCliente[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaCliente[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].personaResponsable+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].descripcion+'</td>';
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    rows=rows+'<td>'+datos.calificaCliente[i].datosAlternos+'</td>';
    rows=rows+'<td>'+datos.calificaCliente[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';


  }

       cantidad=datos.calificaAgente.length;
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaAgente[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaAgente[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaAgente[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';

    rows=rows+'<tr>';
    rows=rows+'<td><div>NC para operativos</div>'+select+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaAgente[i].noConformidadRevisada==1)
    {
      if(datos.calificaAgente[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaAgente[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].personaResponsable+'</td>';
    if(datos.calificaAgente[i].descripcion){rows=rows+'<td>'+datos.calificaAgente[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    //rows=rows+'<td>'+datos.calificaAgente[i].datosAlternos+'</td>';
    let datosalternos=(datos.calificaAgente[i].datosAlternos!=null) ? datos.calificaAgente[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaAgente[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';  
  }

       cantidad=datos.calificaOperativo.length;
  for(let i=0;i<cantidad;i++) {
    let select='<div>Responsables:<ul>';
    for(let j=0;j<datos.calificaOperativo[i].responsables.length;j++){
       select=select+'<li>'+datos.calificaOperativo[i].responsables[j].descricpioConformidadMala+'->'+datos.calificaOperativo[i].responsables[j].persona+'</li>'}
          select=select+'</ul></div>';

let selectEstrella='<div>Estrellas:<ul style="width:200px">';
for(let j=0;j<datos.calificaOperativo[i].estrellas.length;j++){
  let status='Mala';
  let clase='estrellaMala';


        if(datos.calificaOperativo[i].estrellas[j].calificacionActividad==1){status="Buena";clase="estrellaBuena"}
        selectEstrella=selectEstrella+'<li class="'+clase+'">'+status+'->'+datos.calificaOperativo[i].estrellas[j].calificacionAgente+'</li>';
      }
selectEstrella=selectEstrella+'</ul></div>';

    rows=rows+'<tr>';
    rows=rows+'<td><div>NC para Agentes<div>'+select+selectEstrella+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].fCreacion+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].descrNoConfomridadRevisada+'</td>';
    if(datos.calificaOperativo[i].noConformidadRevisada==1)
    {
      if(datos.calificaOperativo[i].aFavor){rows=rows+'<td>A favor</td>';}
      else{rows=rows+'<td>En contra</td>';}
     }
     else{rows=rows+'<td></td>'; }
    rows=rows+'<td>'+datos.calificaOperativo[i].personaInconforme+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].personaResponsable+'</td>';
    if(datos.calificaOperativo[i].descripcion){rows=rows+'<td>'+datos.calificaOperativo[i].descripcion+'</td>';}
    else{rows=rows+'<td></td>';}

    //rows=rows+'<td>'+datos.calificaOperativo[i].descripcion+'</td>';
    rows=rows+'<td></td>';
    rows=rows+'<td></td>';
    //rows=rows+'<td>'+datos.calificaOperativo[i].datosAlternos+'</td>';
    let datosalternos=(datos.calificaOperativo[i].datosAlternos!=null) ? datos.calificaOperativo[i].datosAlternos : '';
   rows=rows+'<td>'+datosalternos+'</td>';
    rows=rows+'<td>'+datos.calificaOperativo[i].comentarioTNC+'</td>';
    rows=rows+'</tr>';

  }

   document.getElementById('tbodyReporte').innerHTML=rows;
   let tablaRevisadas="<table class='table table-reportes'><thead style='position: sticky;top: 0px'><tr><th>Persona</th><th>Buenas</th><th>Malas</th><tr></thead><tbody>";
   let totalRevisadas=datos.personaRevisada.length;


   for(let i=0;i<totalRevisadas;i++)
   {
      if(datos.tipoPersona!=0)
    {
      if(datos.idPersona!=0)
      {
        if(datos.idPersona==datos.personaRevisada[i].idPersona)
        {  
          
          tablaRevisadas=tablaRevisadas+'<tr data-idpersona="'+datos.personaRevisada[i].idPersona+'">';
          tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].nombre+'</td>';
          tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidaBuena.length+'</td>';
          tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidadMala.length+'</td>';
          tablaRevisadas=tablaRevisadas+'</tr>';
        }
      }
      else
      {
        if(datos.tipoPersona==datos.personaRevisada[i].tipoPersona)
        {  
         tablaRevisadas=tablaRevisadas+'<tr data-idpersona="'+datos.personaRevisada[i].idPersona+'">';
         tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].nombre+'</td>';
         tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidaBuena.length+'</td>';
         tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidadMala.length+'</td>';
         tablaRevisadas=tablaRevisadas+'</tr>';
        }
      }
     }
     else
     {
      tablaRevisadas=tablaRevisadas+'<tr data-idpersona="'+datos.personaRevisada[i].idPersona+'">';
      tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].nombre+'</td>';
      tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidaBuena.length+'</td>';
      tablaRevisadas=tablaRevisadas+'<td>'+datos.personaRevisada[i].conformidadMala.length+'</td>';
      tablaRevisadas=tablaRevisadas+'</tr>';

     }

   }
   tablaRevisadas=tablaRevisadas+'</tbody></table>';
   document.getElementById('divReporteResponsables').innerHTML=tablaRevisadas;
   ordenarFecha('tbodyReporte');
    }

 }
}
function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    document.getElementById('gifDeEspera').classList.toggle('verObjeto');
document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');
   req.onreadystatechange = function (aEvt)
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {

         var respuesta=JSON.parse(this.responseText);
         document.getElementById('gifDeEspera').classList.toggle('verObjeto');
         document.getElementById('gifDeEspera').classList.toggle('ocultarObjeto');
         switch(funcion){
          case 'agregarCausaRaiz':agregarCausaRaiz(respuesta);break;
          case 'agregarAccionCorrectiva':agregarAccionCorrectiva(respuesta);break;
          case 'cerrarNoConformidad':cerrarNoConformidad(respuesta);break;
          case 'buscarReporte':buscarReporte(respuesta);break;
          default:window[funcion](respuesta);

         }
      }
   }
  };
 req.send(parametros);
}
function llenaSelectCR(){
  var tbody=document.getElementById('bodyACR');
  var option="<option></option>";
  cantTbody=tbody.rows.length;
  for(let i=0;i<cantTbody;i++){
   option=option+'<option value="'+tbody.rows[i].getAttribute('data-idcausaraiz')+'">'+tbody.rows[i].cells[0].innerHTML+'</option>';
  }
  document.getElementById('selectCausaRaiz').innerHTML=option;
}
function llenaSelectAC(){
  var tbody=document.getElementById('bodyAAC');
  var option="<option></option>";
  cantTbody=tbody.rows.length;
  for(let i=0;i<cantTbody;i++){
   option=option+'<option value="'+tbody.rows[i].getAttribute('data-idaccioncorrectiva')+'">'+tbody.rows[i].cells[0].innerHTML+'</option>';
  }
  document.getElementById('selectAccionCorrectiva').innerHTML=option;
}
function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');
}
function verGrid(id,objeto){

  let estado=document.getElementById('tabla'+id).classList.toggle('ocultarObjeto');
  if(estado){objeto.innerHTML="+";}else{objeto.innerHTML="-";}
}
function verDetalle(id,objeto){
  let estado=document.getElementById('tablaReporte'+id).classList.toggle('ocultarObjeto');
  if(estado){objeto.innerHTML="+";}else{objeto.innerHTML="-";}
}
llenaSelectCR();
llenaSelectAC();
</script>
<style>
 .cabeceraOculta{opacity: 0; }
 .contTabla2{width: 100%; height:50px;overflow-x: hidden; overflow-y: hidden; }
 .contTabla{ width: 100%;height: 300px; overflow-x: hidden; overflow-y: scroll;}
 .tableV3{width: 100%}
 .tableV3>thead{background-color: #472380;color: white;}
 .rowActivo{background-color:#2ad52a; color:white;}
 .comentarioSeleccionado{background-color:#2ad52a; color:white;}
 .divPrincipal{width: 100%; display: flex; }
 .divMenu{min-width: 80px;  height: 350px;border: none; border-right: solid;border-bottom: solid;}
 .divContenido{width: 100%;/*margin-left: 30px*/  }
 .divBotonMenu{border:solid black .1em;background-color:  #e6e6e6}
 .divBotonMenu:active{color:red;background-color:#a373ef87}
 .divBotonMenu:hover{color:#a373ef87;cursor: pointer;}
  .ocultarObjeto{display: none}
  .verObjeto{display: block;width: 100%;}
  .tbodyNC > tr:hover{background-color: #85cc85}
  .rowSeleccionado{background-color: green}
  .ncModificadaSeleccionada{background-color: green}
  .modal-btnCerrar{background-color:white;width:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:100%;height:auto;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
  .estrellaMala{background-color: #F7DC6F; color:black; ; margin-left: 50px}
  .estrellaBuena{background-color: #52BE80;color:black;}
     
    .ocultarprocedeenciainconformidad{display: none;}
 
/*  .divTD25{width:25px;max-width: 25px;min-width: 25px}
  .divTD50{width:50px;max-width: 50px;min-width: 50px}
  .divTD75{width:75px;max-width: 75px;min-width: 75px}
  .divTD100{width:100px;max-width: 100px;min-width: 100px}
  .divTD150{width:150px;max-width: 150px;min-width: 150px}
  .divTD150{width:200px;max-width: 200px;min-width: 200px}
  .divTD300{width:300px;max-width: 300px;min-width: 300px}
  .divTD400{width:400px;max-width: 400px;min-width: 400px}*/

  tr[data-status='3']{background-color:#f8ffaa }
  tr[data-status='4']{background-color: #ab99ed}
  tr[data-status='1']{background-color: #acf5d0 }
.gifEspera{position: absolute;left: 50%;top:70%;z-index: 100000}
.labelComentarioPrincipal{color:black;/*text-decoration: underline;*/font-size: 12px}
.inconformidadCompleta{background-color: #f8ffaa;/*#eaed3e*/;font-size: 20px}
.filtroCabecera {outline: none;width: 100%;min-width: 50px;height: 20px;}
.buttonMenu {min-width: 90px;min-height: 90px;width: 90px;height: 90px;background-color: white;border: 2px solid #8370A1;border-radius: 5px;margin-bottom: 3px;color: #361666;display: flex;flex-direction: column;justify-content: center;align-items: center;}
.buttonMenu:hover {background: #d2cbdc;}
.buttonMenu > label{width: 60%;}
.buttonMenu > p {margin: 0px;}
.btn-despliegue {color: black;background: #e9ecef;border: 1px solid #ced4da;border-radius: 5px;padding: 10px;}
.btn-despliegue:hover {color: white;background: #9a9240;border-color: #9a9240;}
button.btn-file {padding: 3px 7px;border-radius: 5px;background: white;color: #3e3e3e;border-color: #cfcfcf;margin-left: 5px;margin-right: 6px;z-index: 2;}
button:focus {outline: none;}
.title-Modulo {font-size: 20px;margin-right: 5px;}
.title-modal-files {color: #303030;font-size: 14px;text-align: center;}
.subtitle-modal-files {width: max-content;font-size: 13px;color: #00284a;/*background: #5bc0de;*/font-weight: 700;padding: 0px 5px;border-radius: 3px;}
.files-center {padding: 0px;display: grid;}
.container-spinner-archivos-inc {margin: 0px;color: #266093;width: 100%;height: 100%;align-items: center;display: flex;justify-content: center;}
.column-filter {width: 100%;max-width: inherit;padding-left: 0px;}
.column-grid {display: flex;flex-direction: column;align-items: center;}
.column-btn {display: flex;align-items: flex-end;justify-content: space-evenly;}
.column-input-filter {padding: 0px;display: flex;align-items: flex-end;justify-content: flex-end}
.column-input-filter > label {margin-bottom: 0px;margin-right: 5px;}
div.width-ajust, .width-ajust {width: 100%;max-width: max-content;padding-left: 0px;}
button.archivos {background: #75d775;border-color: #75d775;}
.text-comment {width: 100%;height: 70px;outline: none;border: 2px solid #6067b1;border-radius: 3px;}
  .text-add-comment {
    width: 100%;
    height: 300px;
    color: black;
    background: #f9fbff;
    border: 1px solid #263a6e;
    border-radius: 5px;
    outline: aqua;
  }
  .btn-comment {display: flex;flex-direction: column;align-items: flex-start;justify-content: space-evenly;}
  .button-files.celdaSeleccionadoTablaCapital {background-color: #E63C5E;}
  .celdaSeleccionadoTablaCapital button {border-color: white;}
  button.btn {
    border-radius: 5px;
  }
  .swal-modal { width: 28%;  }
  .swal-button--confirm{ background-color:#337ab7!important; }
  .swal-text{ font-size: 17px; text-align: center; }
  
  .rounded-pill {
    border-radius: 50rem!important;
  }
  .rounded-circle {
    border-radius: 50%!important;
  }
  .p-2 {
    padding: .5rem!important;
  }
  .border-light {
    border-color: #f8f9fa!important;
  }
  .border {
    border: 1px solid #dee2e6!important;
  }
  .btn-primary .badge {
    color: white;
  }
  .translate-middle {
    transform: translate(-50%,-50%)!important;
  }
  .start-100 {
    left: 100%!important;
  }
  .top-0 {
    top: 0!important;
  }
  .position-absolute {
    position: absolute!important;
  }
  .badge { display: inline-block; padding: .35em .65em; font-size: .75em;font-weight: 700; line-height: 1; color: #fff; text-align: center;white-space: nowrap; vertical-align: baseline; border-radius: .25rem; }
/*Table*/
  .table-reportes {
    margin: 0px;
    font-size: 13px;
    background-color: white;
  }
  .textarea-table {
    outline: none;
    color: black;
    height: auto;
  }
  #tablaNoConformidadIncidencias th.col-input-table {
    height: 40px;
    position: relative;
  }
  #tablaNoConformidadIncidencias th.col-select-table {
    min-width: 120px;
    position: relative;
  }
  /*Tab*/
  .tab-items {
    display: flex;
    padding-right: 0px;
  }
  .tab-content.bg-tab-content-poliza {
    display: flex;
    justify-content: center;
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
  /* Checkbox Style*/
    .checkbox-container{
      width: 23px;
      height: 23px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .checkbox-All {
      width: 23px;
      height: 23px;
      position: inherit;
    }
    input:checked ~ .checkmark {
      background-color: #0d6efd; /*#337ab7, #0d6efd*/
      border-color: #0d6efd;
    }
    /*input:active ~ .checkmark{
        filter:brightness(90%);
    }*/
    input:focus ~ .checkmark{
        border-color:#86b7fe;
        outline:0;
        box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    }
    .segment {
      display: block;
      position: relative;
      cursor: pointer;
      width: 18px;
      height: 18px;
      /*margin-bottom: 0px;
      padding-top: 2px;
      padding-left: 2px;
      margin-top: -3px;
      margin-left: -1px;*/
    }
    /* Checkbox original oculto */
    .segment input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    /* Checkbox nuevo */
    .checkmark {
      display: flex;
      /* position: absolute; */
      /* top: 0px; */
      /* left: 0; */
      height: 23px;
      width: 23px;
      border-radius: 5px;
      border: 1px solid darkgray;
      margin-top: 0px;
    }
    /* Antes de seleccionar */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    /* Después de seleccionar */
    .segment input:checked ~ .checkmark:after {
      display: block;
    }
    /* Marcador del checkbox */
    .segment .checkmark:after {
      left: 9px;
      top: 5px;
      width: 6px;
      height: 11px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
</style>
<?php
function validador($array){
  $datos="";
  foreach ($array as  $value) {
        $personasResponsables="";
    $valuePR="";
    if(isset($value->personaResponsables))
    {
     foreach ($value->personaResponsables as $pr) 
     {
        $personasResponsables.='<br>*'.$pr->nombres.' '.$pr->apellidoPaterno.' '.$pr->apellidoMaterno.'('.$pr->email.')';
        $valuePR.=$pr->idPersona.',';
      } 
    }
    $dataExtra='Inconforme:'.$value->personaInconforme.' Comentario:'.$value->descripcion.' Fecha Creacion:'.$value->fCreacion.'---Responsable'.$value->personaResponsable;
    $datos.='<tr  data-idTablaNoConformidad="'.$value->idTablaNoConformidad;
    $datos.='" data-value="'.$value->idTablaNoConformidad;
    $datos.='" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-procedeenciainconformidad="1" data-estamodificado="'.$value->estaModificado.'" data-idcausaraiz="'.$value->idCausaRaiz.'" data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'" data-nombrenoconformidad="'.$value->nombreNoConformidad.'" data-statusnoconformidad="'.$value->statusNoconformidad.'" data-comentariocierre="'.$value->comentarioCierre.'" data-afavor="'.$value->aFavor.'" data-comentarioac="'.$value->comentarioAccionCorrectiva.'" data-comentariocr="'.$value->comentarioCausaRaiz.'" data-extra="'.$dataExtra.'" data-fechacreacion="'.$value->fCreacion.'">';
    $datos.='<td></td>';
     $datos.='<td class="divTD100"></td>';
    $datos.='<td class="divTD400">'.$value->personaInconforme.'<br>Comentario:'.$value->descripcion.'<br>Fecha Creacion:'.$value->fCreacion.'</td>';
    $datos.='<td data-input="textarea" data-defaultvalue="'.$value->comentarioInconforme.'" data-comentinconforme data-name="comentarioInconforme"></td>';
    $datos.='<td class="divTD400" data-responsable data-oldvalue="'.$valuePR.'" data-newvalue="'.$valuePR.'" data-name="personaResponsable">'.$value->personaResponsable.$personasResponsables.'</td>';
     $datos.='<td data-input="textarea" data-defaultvalue="'.$value->comentarioResponsable.'" data-comentresponsable="1" data-name="comentarioResponsable">  </td>';
     $datos.='<td class="divTD100" data-input="select" data-selectcr data-selectvd="'.$value->idCausaRaiz.'" data-name="causaRaiz"></td>';
     $datos.='<td class="divTD100" data-input="select" data-selectac data-selectvd="'.$value->idAccionCorrectiva.'" data-name="accionCorrectiva"></td>';
    $datos.='<td class="divTD300"  data-input="select" data-selectveredicto data-selectvd="'.$value->aFavor.'" data-name="veredicto"></td>';
    $datos.='</tr>';
  }
  return $datos;
  
}
function inconformidadParaAgentes($array){
  $datos="";

  foreach ($array as  $value) {
    $personasResponsables="";
    $valuePR="";
    if(isset($value->personaResponsables))
    {
     foreach ($value->personaResponsables as $pr) 
     {
        $personasResponsables.='<br>*'.$pr->nombres.' '.$pr->apellidoPaterno.' '.$pr->apellidoMaterno.' ( '.$pr->email.' ) ';
        $valuePR.=$pr->idPersona.',';
      } 
    }
        $comentarioActividad='';

     $classCompleta='';
     if($value->aFavor==1){$classCompleta='class="inconformidadCompleta"';}

     foreach ($value->comentariosBitacora as $valC) 
     {
       $comentarioActividad.=$valC->movimiento.'     [ Correo:'.$valC->email.' , Nombre:'. $valC->name_complete .', Fecha:'.$valC->fechaMovimiento.']<br>===========================================================<br>';
     }
    $select='<select style="width:150px"><option>Ver calificacion</option>';
    $estrellasBuenas="";
    $estrellas="";
    $estrellasIncidencias="";
        foreach ($value->estrellas as $valueEstrellas) {
      $tipoEstrella='estrellaBuena';
      if($valueEstrellas->calificacionActividad==0){$tipoEstrella='estrellaMala';$estrellas.='<span style="font-size:15px;">?'.$valueEstrellas->calificacionAgente.'</span><br>';
        $estrellasIncidencias.='?'.$valueEstrellas->calificacionAgente.';';
    }
        
    $select.='<option class="'.$tipoEstrella.'">'.$valueEstrellas->calificacionAgente.'</option>';
    }
    $select.='<select>';
    $dataExtra='Inconforme:'.$value->personaInconforme.' '.$estrellasIncidencias.' Fecha Creacion:'.$value->fCreacion.'--- Responsable:'.$value->personaResponsable;
    $datos.='<tr  data-idTablaNoConformidad="'.$value->idTablaNoConformidad.'"  data-value="'.$value->idTablaNoConformidad.'"data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-procedeenciainconformidad="2" data-estamodificado="'.$value->estaModificado.'"data-idcausaraiz="'.$value->idCausaRaiz.'" data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'" data-nombrenoconformidad="'.$value->nombreNoConformidad.'" data-statusnoconformidad="'.$value->statusNoconformidad.'" data-comentariocierre="'.$value->comentarioCierre.'" data-afavor="'.$value->aFavor.'" data-comentarioac="'.$value->comentarioAccionCorrectiva.'" data-comentariocr="'.$value->comentarioCausaRaiz.'" data-extra="'.$dataExtra.'" data-fechacreacion="'.$value->fCreacion.'" '.$classCompleta.'>';
    $datos.='<td></td>';
    $datos.='<td data-button="1" class="button-files"><button class="btn btn-file position-relative" name="archivos" data-folio="'.$value->folioInconformidad.'" onclick="filesInconformidad(this)">Abrir</button></td>';
    $datos.='<td class="divTD100" data-newvalue="'.$value->folioInconformidad.'" data-oldvalue="'.$value->folioInconformidad.'">'.$value->folioInconformidad.'</td>';    
    $datos.='<td>'.$value->tipoInconformidad.'</td>';
    $datos.='<td>'.$value->opcionInconformidad.'</td>';
    $datos.='<td>'.$value->areaInconformidad.'</td>';    
    

    $datos.='<td class="divTD400">'.$comentarioActividad.'</td>'; 
    $datos.='<td class="divTD100" data-responsable data-oldvalue="'.$valuePR.'" data-newvalue="'.$valuePR.'" data-name="personaResponsable">'.$value->personaResponsable.$personasResponsables.'</td>';
  

    $datos.='<td style="display:none" data-input="textarea" data-defaultvalue="'.$value->comentarioInconforme.'" data-comentinconforme data-name="comentarioInconforme"></td>'; 
   
    $datos.='<td style="display:none" data-input="textarea" data-defaultvalue="'.$value->comentarioResponsable.'" data-comentresponsable="1" data-name="comentarioResponsable"></td>'; 
  $datos.='<td class="divTD200" data-input="select" data-selectcr data-defaultvalue="'.$value->idCausaRaiz.'"  data-selectvd="'.$value->idCausaRaiz.'" data-name="causaRaiz"></td>';
     $datos.='<td class="divTD200" data-input="select" data-selectac data-defaultvalue="'.$value->idAccionCorrectiva.'" data-selectvd="'.$value->idAccionCorrectiva.'" data-name="accionCorrectiva"></td>';         
     $datos.='<td class="divTD200" data-input="select" data-selectveredicto data-defaultvalue="'.$value->aFavor.'" data-selectvd="'.$value->aFavor.'" data-name="veredicto" ></td>';         

    $datos.='</tr>';
  
   

    
  }
  return $datos;
}
function inconformidadParaOperativos($array){
$datos="";

  foreach ($array as  $value) 
  {

       $personasResponsables="";
    $valuePR="";
    if(isset($value->personaResponsables))
    {
     foreach ($value->personaResponsables as $pr) 
     {
        $personasResponsables.='<br>*'.$pr->nombres.' '.$pr->apellidoPaterno.' '.$pr->apellidoMaterno.' ( '.$pr->email.' ) ';
        $valuePR.=$pr->idPersona.',';
      } 
    }
    $dataExtra='Inconforme:'.$value->personaInconforme.' Comentario:'.$value->comentarioActividad.' Fecha Creacion:'.$value->fCreacion.'---Responsable'.$value->personaResponsable;

     $classCompleta='';
     if($value->aFavor==1){$classCompleta='class="inconformidadCompleta"';}


    
    $datos.='<tr  data-idTablaNoConformidad="'.$value->idTablaNoConformidad.'" data-value="'.$value->idTablaNoConformidad.'" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-procedeenciainconformidad="3" data-estamodificado="'.$value->estaModificado.'"data-idcausaraiz="'.$value->idCausaRaiz.'" data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'" data-nombrenoconformidad="'.$value->nombreNoConformidad.'" data-statusnoconformidad="'.$value->statusNoconformidad.'" data-comentariocierre="'.$value->comentarioCierre.'" data-afavor="'.$value->aFavor.'" data-comentarioac="'.$value->comentarioAccionCorrectiva.'" data-comentariocr="'.$value->comentarioCausaRaiz.'" data-extra="'.$dataExtra.'" data-fechacreacion="'.$value->fCreacion.'" '.$classCompleta.'>';
    $datos.='<td></td>';
    $datos.='<td data-button="1" class="button-files"><button class="btn btn-file position-relative" name="archivos" data-folio="'.$value->folioInconformidad.'" onclick="filesInconformidad(this)">Abrir</button></td>';
    $datos.='<td class="divTD100" data-newvalue="'.$value->folioInconformidad.'" data-oldvalue="'.$value->folioInconformidad.'">'.$value->folioInconformidad.'</td>';    
    $datos.='<td >'.$value->tipoInconformidad.'</td>';
    $datos.='<td>'.$value->opcionInconformidad.'</td>';
    $datos.='<td>'.$value->areaInconformidad.'</td>';    
    //$datos.='<td  data-input="textarea" data-defaultvalue="'.$value->personaInconforme.'<br>Comentario:'.$value->descripcion.'<br>Fecha Creacion:'.$value->fCreacion.'"></td>';   

    $comentarioActividad='';
     foreach ($value->comentariosBitacora as $valC) 
     {

       $comentarioActividad.=$valC->movimiento.'    [ Correo:'.$valC->email.' , Nombre:'. $valC->name_complete .', '.$valC->fechaMovimiento.']<br>=====================================================================<br>';
  }
     
    $datos.='<td data-bit="1"><div class="contieneTextoTableDiv" data-value="1" id="Bit'.$value->idTablaNoConformidad.'">'.$comentarioActividad.'</td>';     
     $datos.='<td style="display:none"  data-input="textarea" data-defaultvalue="'.$value->comentarioInconforme.'" data-comentinconforme data-name="comentarioInconforme"></td>';        
     $datos.='<td class="divTD100" data-responsable data-oldvalue="'.$valuePR.'" data-newvalue="'.$valuePR.'" data-name="personaResponsable">'.$personasResponsables.'</td>';     
     $datos.='<td style="display:none" class="divTD100"  data-input="textarea" data-defaultvalue="'.$value->comentarioResponsable.'" data-comentresponsable data-name="comentarioResponsable"></td>';
     $datos.='<td class="divTD200" data-input="select" data-selectcr data-defaultvalue="'.$value->idCausaRaiz.'"  data-selectvd="'.$value->idCausaRaiz.'" data-name="causaRaiz"></td>';
     $datos.='<td class="divTD200" data-input="select" data-selectac data-defaultvalue="'.$value->idAccionCorrectiva.'" data-selectvd="'.$value->idAccionCorrectiva.'" data-name="accionCorrectiva"></td>';         
     $datos.='<td class="divTD200" data-input="select" data-selectveredicto data-defaultvalue="'.$value->aFavor.'" data-selectvd="'.$value->aFavor.'" data-name="veredicto" ></td>';         

    $datos.='</tr>';
  }
  return $datos;
}
function buzonInconformidad($array){// Modificado [Suemy][2024-04-04]
  $datos="";

  foreach ($array as  $value) 
  {

        $personasResponsables="";
    $valuePR="";
    if(isset($value->personaResponsables))
    {
     foreach ($value->personaResponsables as $pr) 
     {
         $personasResponsables.='<br>*'.$pr->nombres.' '.$pr->apellidoPaterno.' '.$pr->apellidoMaterno.' ( '.$pr->email.' ) ';
        $valuePR.=$pr->idPersona.',';
      } 
    }
     $classCompleta='';
     if($value->aFavor==1){$classCompleta='class="inconformidadCompleta"';}
    $dataExtra='Inconforme:'.$value->personaInconforme.' Comentario:'.replaceText($value->descripcion).' Fecha Creacion:'.$value->fCreacion.'---Responsable';
    $datos.='<tr data-idTablaNoConformidad="'.$value->idTablaNoConformidad;
    $datos.='"  data-value="'.$value->idTablaNoConformidad;
     $datos.='" data-idPersonaResponsable="'.$value->idPersonaResponsable.'" data-nombre="'.$value->personaResponsable.'" data-procedeenciainconformidad="4" data-estamodificado="'.$value->estaModificado.'"data-idcausaraiz="'.$value->idCausaRaiz.'" data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'" data-nombrenoconformidad="'.$value->nombreNoConformidad.'" data-statusnoconformidad="'.$value->statusNoconformidad.'" data-comentariocierre="'.$value->comentarioCierre.'" data-afavor="'.$value->aFavor.'" data-comentarioac="'.$value->comentarioAccionCorrectiva.'" data-comentariocr="'.$value->comentarioCausaRaiz.'" data-extra="'.$dataExtra.'" data-fechacreacion="'.$value->fCreacion.'" '.$classCompleta.' data-folioinconformidad="'.$value->folioInconformidad.'">';
    $datos.='<td></td>';
    $datos.='<td data-button="1" class="button-files"><button class="btn btn-file position-relative" name="archivos" data-folio="'.$value->folioInconformidad.'" onclick="filesInconformidad(this)">Abrir</button></td>';
    $datos.='<td class="divTD100" data-newvalue="'.$value->folioInconformidad.'" data-oldvalue="'.$value->folioInconformidad.'">'.$value->folioInconformidad.'</td>';    
    $datos.='<td data-defaultvalue="'.$value->idCBITipo.'" data-newvalue="'.$value->idCBITipo.'" data-text="'.$value->tipoInconformidad.'">'.$value->tipoInconformidad.'</td>';
    $datos.='<td data-defaultvalue="'.$value->idCBIOpcion.'" data-newvalue="'.$value->idCBIOpcion.'" data-text="'.$value->opcionInconformidad.'">'.$value->opcionInconformidad.'</td>';
    $datos.='<td data-defaultvalue="'.$value->idCBIArea.'" data-newvalue="'.$value->idCBIArea.'" data-text="'.$value->areaInconformidad.'">'.$value->areaInconformidad.'</td>';    
    //$datos.='<td  data-input="textarea" data-defaultvalue="'.$value->personaInconforme.'<br>Comentario:'.$value->descripcion.'<br>Fecha Creacion:'.$value->fCreacion.'"></td>';   
    $comentarioActividad='';

     foreach ($value->comentariosBitacora as $valC) 
     {
       $comentarioActividad.=$valC->movimiento.'     [ Correo:'.$valC->email.' , Nombre:'. $valC->name_complete .', Fecha Creacion: '.$valC->fechaMovimiento.']<br>=====================================================================<br>';
     }
     //$comentarioActividad.=$value->descripcion.'[ Usuario:'.$value->personaInconforme.'   Fecha Creacion:'.$value->fCreacion.' ]';
    $datos.='<td data-bit="1"><div class="contieneTextoTableDiv" data-value="1" id="Bit'.$value->idTablaNoConformidad.'">'.$comentarioActividad.'</div></td>';     
     $datos.='<td style="display:none"  data-input="textarea" data-defaultvalue="'.$value->comentarioInconforme.'" data-comentinconforme data-name="comentarioInconforme"></td>';        
     $datos.='<td class="divTD100" data-responsable data-oldvalue="'.$valuePR.'" data-newvalue="'.$valuePR.'" data-name="personaResponsable">'.$personasResponsables.'</td>';     
     $datos.='<td style="display:none" class="divTD100"  data-input="textarea" data-defaultvalue="'.$value->comentarioResponsable.'" data-comentresponsable data-name="comentarioResponsable"></td>';
     $datos.='<td class="divTD200" data-input="select" data-selectcr data-defaultvalue="'.$value->idCausaRaiz.'"  data-selectvd="'.$value->idCausaRaiz.'" data-name="causaRaiz" data-text="'.$value->causaRaiz.'"></td>';
     $datos.='<td class="divTD200" data-input="select" data-selectac data-defaultvalue="'.$value->idAccionCorrectiva.'" data-selectvd="'.$value->idAccionCorrectiva.'" data-name="accionCorrectiva" data-text="'.$value->accionCorrectiva.'"></td>';         
     $datos.='<td class="divTD200" data-input="select" data-selectveredicto data-defaultvalue="'.$value->aFavor.'" data-selectvd="'.$value->aFavor.'" data-name="veredicto" data-text="'.$value->status.'"></td>';         

    $datos.='</tr>';
  } 
  return $datos;

}
function imprimirCausaRaizCabecera($datos,$tipo='')
{
$json="{";

switch ($tipo) 
{
  case 'causaRaiz':foreach ($datos as  $value) {$json.='"'.$value->idCausaRaiz.'":"'.$value->causaRaiz.'",';}break;
  case 'accionCorrectiva':foreach ($datos as  $value) {$json.='"'.$value->idAccionCorrectiva.'":"'.$value->accionCorrectiva.'",';}break;
  case 'status':foreach ($datos as  $value) {$json.='"'.$value->idTNCStatus.'":"'.$value->status.'",';}break;
  case 'tipoInconformidad':foreach ($datos as  $value) {$json.='"'.$value->idCBI.'":"'.$value->catalogBuzonInconformidad.'",';}break;
  case 'inconformidad':foreach ($datos as  $value) {$json.='"'.$value->idCBI.'":"'.$value->catalogBuzonInconformidad.'",';}break;
  case 'area':foreach ($datos as  $value) {$json.='"'.$value->idCBI.'":"'.$value->catalogBuzonInconformidad.'",';}break;

  default:
    # code...
    break;
}


$json = substr ($json, 0, -1);
$json.="}";
return $json;
 
}

/**
 * Genera un option para el select por cada proyecto al que el usuario tiene acceso
 * 
 * @param array $proyectos - Arreglo con la lista de proyectos asociados al usuario
 */
function imprimirProyectosSeguimiento($proyectos) {
  foreach ($proyectos as $key => $value) {
    echo '<option value="' . $value->idproyecto . '">' . $value->nombre . '</option>';
  }
}

function imprimirOpcionesVeredicto($datos)
{
  //new Array(new Array('',''),new Array('RESUELTO','1'),new Array('PENDIENTE','0'));
  $tbody="Array(";
  foreach ($datos as $key => $value) 
  {
    $tbody.='new Array("'.$value->status.'","'.$value->idTNCStatus.'"),';
  }
  $tbody = substr ($tbody, 0, -1);
  $tbody.=")";
  return $tbody;

}
function imprimirCausaRaiz($datos)
{
$tbody="";
foreach ($datos as  $value) {
  $tbody.='<tr data-idcausaraiz="'.$value->idCausaRaiz.'">';
  $tbody.='<td>'.$value->causaRaiz.'</td>';
  $tbody.='<td>'.$value->descripcionCausaRaiz.'</td>';
  $tbody.='</tr>';
}
return $tbody;
}
function imprimirAccionCorrectiva($datos)
{
$tbody="";
foreach ($datos as  $value) {
  $tbody.='<tr data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'">';
  $tbody.='<td>'.$value->accionCorrectiva.'</td>';
  $tbody.='<td>'.$value->descripcionAccionCorrectiva.'</td>';
  $tbody.='</tr>';
}
return $tbody;
}

function imprimirAnios($array)
{
  $option="";
  foreach ($array as $value) {$option.='<option>'.$value.'</option>';}
  return $option;

}
function imprimirMeses($array)
{

  $option="";
  $mes=date('m');
  foreach ($array as $key => $value) {
    
    $com=$key;
    if($key<9){$com='0'.$key;}
  if($mes==$com){$option.='<option value="'.$key.'" selected>'.$value.'</option>';}
  else{$option.='<option value="'.$key.'">'.$value.'</option>';}

    
  }
  return $option;
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array, TRUE));fclose($fp);
}

  function replaceText($text) {// Creado [Suemy][2024-04-04]
    $text = str_replace('"', '', $text);
    return $text;
  }

?>
<script type="text/javascript">

$(function () {$(".fecha").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,
});
});

var f = new Date();
var mes=(f.getMonth() +1);;
var dia=f.getDate();
if(dia<10){let dia1=dia;dia=`0${dia}`}
if(mes<10){let mes1=mes;mes=`0${mes1}`}

var fechaInicial= f.getFullYear()+"-"+ mes+'-01';
var fechaFinal=f.getFullYear()+'-'+ mes+'-'+dia;

//document.write(f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear());
document.getElementById('fechaInicial').value="01/" + (f.getMonth() +1) + "/" + f.getFullYear();
document.getElementById('fechaFinal').value=f.getDate() + "/" + (f.getMonth() +1) + "/" + f.getFullYear();
document.getElementById('fechaInicialEstrellas').value="01/" + (f.getMonth() +1) + "/" + f.getFullYear();
document.getElementById('fechaFinalEstrellas').value= "30/" + (f.getMonth()+1) + "/" + f.getFullYear();
document.getElementById('fecInicGraficas').value= fechaInicial;
document.getElementById('fecFinGraficas').value= fechaFinal;
ordenarFecha('tbodyNC');
</script>
<script type="text/javascript">
  function buscarReportesGraficas(datos="")
{
  if(datos=='')
  {
   let parametros='fechaInicialGraf=1';//+document.getElementById('fecInicGraficas').value;  
   parametros=parametros+'&fechaFinalGraf=1';//+document.getElementById('fecFinGraficas').value;
   parametros=parametros+'&tipoBusqueda='+document.getElementById('graficaTipoSelect').value;
   parametros=parametros+'&anioBusqueda='+document.getElementById('graficaAnioSelect').value;
   parametros=parametros+'&mesBusqueda='+document.getElementById('graficaMesSelect').value;

  parametros=parametros+'&mostrarTodos=1';
  peticionAJAX('procesamientoNC/buscarReporteGraficas',parametros,'buscarReportesGraficas');
 }
 else
 {
   let arrayD=[];
   datosImpresion=[];
   let causaRaizGrafica=[];
   if(datos.tipoBusqueda=='Dia')
   {

    let a1=['Dia',"Cantidad"];
    optionsImpresion= {title: 'COMPARATIVO DE INCIDENCIAS POR DIA DEL MES',hAxis: {
          title: 'TOTAL DE INCIDENCIAS '+datos.total,         
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }},        vAxis: {
          title: 'INCIDENCIAS'
        }}; 
   datosImpresion.push(a1);      
   for(let i=1;i<datos.ultimoDiaDeMes;i++){datosImpresion.push([i,0]);}
        datos.calificaUsuario.forEach(c=>{          
     let fechaDia=c.fCreacion.split('-');
     
     
     let val=parseInt(fechaDia[2]);
     datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
     if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
    })
      

    datos.calificaCliente.forEach(c=>{     
     let fechaDia=c.fCreacion.split('-');
     let val=parseInt(fechaDia[2]);
     datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
     if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
    })
    datos.calificaAgente.forEach(c=>{     
     let fechaDia=c.fCreacion.split('-');
     let val=parseInt(fechaDia[2]);
     datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
     if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
    })
        datos.calificaOperativo.forEach(c=>{
     //c.fCreacion.split('-');
     let fechaDia=c.fCreacion.split('-');
     let val=parseInt(fechaDia[2]);
     datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
     if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
    })

     
    }
    else
    {
      if(datos.tipoBusqueda=='Mes')
      {
            optionsImpresion= {title: 'COMPARATIVO DE INCIDENCIAS POR MES DEL AÑO',hAxis: {
          title: 'TOTAL DE INCIDENCIAS '+datos.total,
          
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }},        vAxis: {
          title: 'INCIDENCIAS'
        }}; 
         let a1=['Mes',"Cantidad"];
         datosImpresion.push(a1);        
          let i=0;
          let cantMeses=datos.meses.length;          
          for(let i=1;i<=12;i++){datosImpresion.push([datos.meses[i],0]);          }            
         datos.calificaUsuario.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
         let val=parseInt(fechaDia[1]);
         
        datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
                datos.calificaCliente.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
         let val=parseInt(fechaDia[1]);
        datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
         datos.calificaAgente.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
         let val=parseInt(fechaDia[1]);
        datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
         datos.calificaOperativo.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
         let val=parseInt(fechaDia[1]);
        datosImpresion[val][1]=parseInt(datosImpresion[val][1])+parseInt(1);
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
      }
      else
      {
            optionsImpresion= {title: 'COMPARATIVO DE INCIDENCIAS POR AÑO',hAxis: {
          title: 'TOTAL DE INCIDENCIAS '+datos.total,
          
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }},        vAxis: {
          title: 'INCIDENCIAS'
        }}; 
         let a1=['Año',"Cantidad"];
         datosImpresion.push(a1);        
          let i=0;
          let cantAnios=0;
          if(datos.anios){ cantAnios=datos.anios.length; }                             
          for(const i in datos.anios)
          {
            let val=datos.anios[i].toString();
            datosImpresion.push([val,0]);
          }

         datos.calificaUsuario.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
         let val=parseInt(fechaDia[0]);
        datosImpresion.forEach(d=>{if(d[0]==val){d[1]=parseInt(d[1])+parseInt(1);}})
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        
        })            
        datos.calificaCliente.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
          let val=parseInt(fechaDia[0]);
        datosImpresion.forEach(d=>{if(d[0]==val){d[1]=parseInt(d[1])+parseInt(1);}})        
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
         datos.calificaAgente.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
        let val=parseInt(fechaDia[0]);
        datosImpresion.forEach(d=>{if(d[0]==val){d[1]=parseInt(d[1])+parseInt(1);}})        
        if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
        })            
         datos.calificaOperativo.forEach(c=>{
         c.fCreacion.split('-');
         let fechaDia=c.fCreacion.split('-');
 let val=parseInt(fechaDia[0]);
        datosImpresion.forEach(d=>{if(d[0]==val){d[1]=parseInt(d[1])+parseInt(1);}})        
      if(c.causaRaiz==''){causaRaizGrafica.push('SIN AC')}else{causaRaizGrafica.push(c.causaRaiz);}
      })   
      }
    }
    data=[arrayD];
    
      optionsImpresionCR= {title: 'COMPARATIVO DE CAUSA RAIZ',hAxis: {
          title: '',          
          viewWindow: {min: [7, 30, 0],max: [17, 30, 0]}},        
          vAxis: {title: 'CAUSA RAIZ'}
         }; 
         let a1CR=['CAUSA RAIZ',"CAUSA RAIZ"];
    let CRG=[];
    let datosCR=[];
       datosCR.push(a1CR);
        causaRaizGrafica.forEach(c=>{
          if(CRG[c]){CRG[c]+=1;}
          else{CRG[c]=1}
        })
        
        
for (let key in CRG) {
  let a=[];
   a[0]=key+' '+CRG[key];
   a[1]=CRG[key];
   datosCR.push(a);
  
}
    

    data = google.visualization.arrayToDataTable(datosImpresion);
    chart = new google.visualization.ColumnChart(document.getElementById('divGraficasColumnas'));
    chart.draw(data, optionsImpresion);
    chart = new google.visualization.LineChart(document.getElementById('divGraficasInter'));
    chart.draw(data, optionsImpresion);

    data = google.visualization.arrayToDataTable(datosCR);
    chart = new google.visualization.ColumnChart(document.getElementById('divGraficasCausaRaiz'));
    chart.draw(data, optionsImpresionCR);



    data=[
           ['Task', 'INCIDENCIAS'],
           ['AGENTES',datos.calificaAgente.length],
           ['OPERATIVOS',datos.calificaOperativo.length],
           ['CLIENTES',datos.calificaCliente.length],
           ['USUARIOS',datos.calificaUsuario.length],
          ]
  
options = {title: 'PROCEDENCIA DE LAS INCIDENCIAS'};          

          data = google.visualization.arrayToDataTable(data);
         chart = new google.visualization.PieChart(document.getElementById('divGraficasIncidencias'));
        chart.draw(data, options);

   data=[
          ['Task','TOTALES INCIDENCIAS'],
          ['PENDIENTES',datos.pendientes],
          ['REVISADAS',datos.revisadas],

         ]

   options={title:'TOTAL INCIDENCIAS'}
   data = google.visualization.arrayToDataTable(data);
    chart = new google.visualization.PieChart(document.getElementById('divTotalIncidencias'));
        chart.draw(data, options);

   data=[['Task','ESTRELLAS']];
        
    datos.estrellas.forEach(estrella=>{
      let agregar=new Array();
      agregar[0]=`${estrella.apellidoPaterno} ${estrella.apellidoMaterno} ${estrella.nombres}`;
      agregar[1]=parseInt(estrella.sumTotal);
      data.push(agregar);
    })
       options={title:'TOTAL ESTRELLAS POR AGENTE'}
       
   data = google.visualization.arrayToDataTable(data);
    chart = new google.visualization.PieChart(document.getElementById('divEstrellaGraficas'));
        chart.draw(data, options);
 }
 if(document.getElementById('google-visualization-errors-all-1')){document.getElementById('google-visualization-errors-all-1').innerHTML=''}
   
}
//buscarReportesGraficas('')

</script>
<script type="text/javascript">
  function buscarCalificacionesEjecutivos(){
    var fechaInicial=document.getElementById('fechaInicialCalificaciones').value;
    var fechaFinal=document.getElementById('fechaFinalCalificaciones').value;
    var todos="no";
    if(document.getElementById('TodosCalificacion').checked){
      todos="si";
    };
    if(document.getElementById('calificacionEjecutivos').checked){
    document.getElementById('tablacalificacionesbuena').innerHTML="";
    document.getElementById('tablacalificacionesmala').innerHTML="";
    var parametros={
            "fechaInicialEjec": fechaInicial,
            "fechaFinalEjec": fechaFinal,
            "todosEjec":todos,
              };
      $.ajax({
            
            url: <?php echo('"'.base_url().'procesamientoNC/calificacionesactividadEjecutivo"'); ?>,
            data: parametros,
            method: 'POST',
            success: function(data){
              const dataObj=JSON.parse(data);
              console.log(dataObj.bueno);
              console.log(dataObj.malo);
              if(dataObj.bueno==0 && dataObj.malo==0){
                    document.getElementById('divGraficaCalificaciones').innerHTML="<h4>No hay calificaciones para este rango de fechas</h4>";
                  }else{
                    datos=[
                  ['Calificación','Buena', 'Mala'],
                  ['Calificación',parseInt(dataObj.bueno), parseInt(dataObj.malo)],
                 
          
                 ]

                options={title:'CALIFICACIONES EJECUTIVOS'}
                datos = google.visualization.arrayToDataTable(datos);
                chart = new google.visualization.BarChart(document.getElementById('divGraficaCalificaciones'));
                    chart.draw(datos, options);
                  }
    }
      });




    }else{
    var bueno=0;
    var malo=0;
    var parametros={
            "fechaInicialCal": fechaInicial,
            "fechaFinalCal": fechaFinal,
            "todos":todos,
              };
    var direccion=<?php echo('"'.base_url().'procesamientoNC/calificacionesactividad"'); ?>;
    console.log(document.getElementById('TodosCalificacion').checked);
    $.ajax({
            data: parametros,
            url: direccion,
            method: 'POST',
            success: function(data) {
              const dataObj=JSON.parse(data);
              console.log(dataObj.bueno);
              if(dataObj.bueno==0 && dataObj.malo==0){
                    document.getElementById('divGraficaCalificaciones').innerHTML="<h4>No hay calificaciones para este rango de fechas</h4>";
                  }else{
                    datos=[
                  ['Task','CALIFICACIÓN'],
                  ['BUENO',dataObj.bueno],
                  ['MALO',dataObj.malo],
          
                 ]

                options={title:'CALIFICACIONES AGENTES'}
                datos = google.visualization.arrayToDataTable(datos);
                chart = new google.visualization.PieChart(document.getElementById('divGraficaCalificaciones'));
                    chart.draw(datos, options);
                  }
              


                  
            }
        });

    $.ajax({
            data: parametros,
            url: <?php echo('"'.base_url().'procesamientoNC/calificacionporPersona"'); ?>,
            method: 'POST',
            success: function(data) {
              console.log(data);
              const dataObj=JSON.parse(data);
              console.log(dataObj.buena);
              console.log(dataObj.mala);
              console.log(dataObj.totalbueno);
              console.log(dataObj.totalmalo);
              if(dataObj.totalbueno!=0 || dataObj.totalmalo!=0){
              cantbuena=dataObj.buena.length;
              tbody="";
              for(let i=0;i<cantbuena;i++)
                 {

                  if(dataObj.buena[i].nombreCompleto!=null){
                    var porcentaje=(parseInt(dataObj.buena[i].buena)/parseInt(dataObj.totalbueno))*100;
                    porcentaje=porcentaje.toString().substring(0, 5);
                    tbody=tbody+'<tr>';
                  tbody=tbody+'<td>'+dataObj.buena[i].nombreCompleto+'</td>';
                  tbody=tbody+'<td  class="text-center">'+dataObj.buena[i].buena+'</td>';
                  tbody=tbody+'<td  class="text-center">'+dataObj.buena[i].buena+'/'+dataObj.totalbueno+'='+porcentaje+'%</td>';
                  tbody=tbody+'</tr>';
                  }
                  
                 };

                 table='<table class="table table-reportes"><thead style="position: sticky;top: 0px;"><tr style="background-color:#3366cc !important;"><th colspan=3 class="text-center">Calificaci&oacute;n buena</th></tr><tr style="background-color:#3366cc !important;"><th>Agente</th><th class="text-center">#</th><th  class="text-center">Porcentaje</th>     </tr></thead><tbody >'+tbody+'</tbody></table>';
                 document.getElementById('tablacalificacionesbuena').innerHTML=table;
                 
          cantmala=dataObj.mala.length;
              tbodymalo="";
              for(let i=0;i<cantmala;i++)
                 {

                  if(dataObj.mala[i].nombreCompleto!=null){
                    var porcentaje=(parseInt(dataObj.mala[i].mala)/parseInt(dataObj.totalmalo))*100;
                    porcentaje=porcentaje.toString().substring(0, 5);
                    tbodymalo=tbodymalo+'<tr>';
                  tbodymalo=tbodymalo+'<td>'+dataObj.mala[i].nombreCompleto+'</td>';
                  tbodymalo=tbodymalo+'<td  class="text-center">'+dataObj.mala[i].mala+'</td>';
                  tbodymalo=tbodymalo+'<td  class="text-center">'+dataObj.mala[i].mala+'/'+dataObj.totalmalo+'='+porcentaje+'%</td>';
                  tbodymalo=tbodymalo+'</tr>';
                  }
                  
                 }
                  table2='<table class="table table-reportes"><thead style="position: sticky;top: 0px;"><tr style="background-color:#dc3912 !important;"><th colspan=3 class="text-center">Calificaci&oacute;n mala</th></tr><tr style="background-color:#dc3912 !important;"><th>Agente</th><th class="text-center">#</th><th  class="text-center">Porcentaje</th>     </tr></thead><tbody >'+tbodymalo+'</tbody></table>';
                 document.getElementById('tablacalificacionesmala').innerHTML=table2;
            }else{
              document.getElementById('tablacalificacionesbuena').innerHTML="";
              document.getElementById('tablacalificacionesmala').innerHTML="";
            }
          }
        });


}



  }
</script>

<script type="text/javascript">
//============CLASE
  class tablaCapital
  {
    constructor(tabla)
    {
      this.tabla=tabla;
      this.cambiaValorCelda='';  
    }
    rows(index=0)
    {      
      let cantidad=this.tabla.rows.length;
      for(let i=0;i<cantidad;i++)
        { 
          this.tabla.rows[i].id=this.tabla.rows[i].dataset.idtablanoconformidad;
          if(this.tabla.rows[i].cells[0].nodeName=='TD')
         {
          this.tabla.rows[i].addEventListener('click',this.escogerRow,true);
          
          //this.tabla.rows[i].cells[index].innerHTML=i;
          this.tabla.rows[i].cells[index].innerHTML=`<input class="form-check-input check-table" type="checkbox" name="multiCBNC">`;
         }
        }
    }
    copiarTexto()
    {
     
      let texto='';

      if(this.children.length>0)
      {
      switch(this.children[0].tagName)
      {
        case 'SELECT': 
           if(this.children[0].value!='')
            {
              texto=this.children[0].options[this.children[0].selectedIndex].text;
            }
        break;
        case 'DIV': 
          if (this.children[0].dataset.value != 0) {
            texto=this.children[0].innerHTML;
          }
        break;
        case 'TEXTAREA':  texto=this.children[0].value;break;
        //case 'DIV':texto=texto=this.children[0].innerHTML;break;
        case 'INPUT':texto='';break;
        case 'BUTTON':texto='Mostrar los archivos de la inconformidad';break;
        case 'LABEL':texto=this.text;break;
        default:texto=this.innerHTML;break;
      }
      }
      else{texto=this.innerHTML}
      let patron=/<br>/g;     
      texto=texto.replace(patron,'\n');
      patron=/&gt;/g;
      texto=texto.replace(patron,'>');
      patron=/<span style="font-size:15px;">/g;
      texto=texto.replace(patron,'');
            patron=/<\/span>/g;
      texto=texto.replace(patron,'');
      document.getElementById('textoTablaCelda').value=texto;
      let celSeleccionado=document.getElementsByClassName('celdaSeleccionadoTablaCapital');
      let cantCelSelec=celSeleccionado.length;
      if(cantCelSelec>0){celSeleccionado[0].classList.remove('celdaSeleccionadoTablaCapital');}
      
      this.classList.add('celdaSeleccionadoTablaCapital');
    }
    escogerRow()
    {
            let cantidad=this.parentNode.rows.length;
      for(let i=0;i<cantidad;i++){ this.parentNode.rows[i].classList.remove('rowSeleccionadoTablaCapital');this.parentNode.rows[i].removeAttribute('data-rowseleccionado')}
        this.classList.add('rowSeleccionadoTablaCapital');
        this.setAttribute('data-rowseleccionado','1')
        if(document.getElementById('agreagarArchivosLabel')){ document.getElementById('agreagarArchivosLabel').innerHTML=this.cells[2].dataset.newvalue}
                if(document.getElementById('agreagarComentarioInconLabel')){ document.getElementById('agreagarComentarioInconLabel').innerHTML=this.cells[2].dataset.newvalue}
          
        /*if(!document.getElementById('divContenedorPadreDigital').classList.contains('ocultarObjeto'))
        {
         
          trearArchivosInconformidad(this.dataset.idtablanoconformidad);
         
        }*/
    }
    borrarRow(index=''){}
    asignaClaseTabla(clase){this.tabla.classList.add(clase);}
    devolverRowSeleccionado()
    {
      let cantidad=this.tabla.rows.length;
      let totalSeleccionado=0;
      let objetoRow='';
      for(let i=0;i<cantidad;i++)
        { if(this.tabla.rows[i].dataset.rowseleccionado==1)
         {
            totalSeleccionado++;
            objetoRow=this.tabla.rows[i];
         }
        }
        if(totalSeleccionado==1){return objetoRow;}
        else {alert('ESCOGER FILA');return '';}
    }
    asignaEventosCeldaTD(arrayCells)
    {
     let cantidad=this.tabla.rows.length;
           let cantidadCells=this.tabla.rows[0].cells.length;
      for(let i=0;i<cantidad;i++)
        {
          for(let j=0;j<cantidadCells;j++)
           {
          
                arrayCells.forEach(cells=>
              {
                 if(this.tabla.rows[i].cells[j].hasAttribute(cells))
                 { 
                  this.tabla.rows[i].cells[j].addEventListener('click',this.modificarCelda,true);
                  this.tabla.rows[i].cells[j].addEventListener('blur',this.modificarCelda,true);
                 }
              })

             
           }
        }
    }
    agregarElementoParaCelda()
    { 

      let tablaElemento=Array.from(this.tabla.rows);      
      let band=0;   
      tablaElemento.forEach(t=>{
        let celdaElemento=Array.from(t.cells)
        celdaElemento.forEach(c=>{
          var id=c.getAttribute('data-defaultvalue')
          if(c.hasAttribute('data-input'))
          {
            switch(c.dataset.input)
            {
              case 'select': break;
              case 'textarea':
                      let input=document.createElement('textarea');                      
                      input.value=c.dataset.defaultvalue;                    
                      input.addEventListener('change',this.cambiaValorElemento);
                      input.setAttribute('style','height:40px');
                      input.setAttribute('class','textTareaTablaCapital');
                      c.dataset.newvalue=c.dataset.defaultvalue;
                      c.dataset.oldvalue=c.dataset.defaultvalue;
                      c.appendChild(input);
              break;
              default: 
                  switch(c.dataset.input)
                  {
                    case 'text':
            let input=document.createElement('input');
            input.type=c.dataset.input;                                
            input.value=c.dataset.defaultvalue;                    
            input.addEventListener('change',this.cambiaValorElemento);
            c.dataset.newvalue=c.dataset.defaultvalue;
            c.dataset.oldvalue=c.dataset.defaultvalue;
                      
            c.appendChild(input);
                    break 

                    default: 
                      
                    break
                  }

                 
              break;
             }

          }
            else
            {

            if(band>0){ 
              if (!c.dataset.button && !c.dataset.bit) {
                c.innerHTML=`<div class="contieneTextoTableDiv" data-value="1" value="${id}">${c.innerHTML}</div>`
              }
              else {
                c.innerHTML += "";
              }
            }
            else{
                 let filtro='';
                 
                if(c.dataset.select){
                    
                  filtro='<select class="filtroCabecera "><option value="-1" data-text="-1">ESCOGER UN FILTRO</option>';
                  if(c.dataset.valores){
                    
                    let val=JSON.parse(c.dataset.valores);
                    for(let obj in val){
                        filtro+=`<option value="${obj}" data-text="${val[obj]}">${val[obj]}</option>`
                        
                    }
                     
                  }
                  filtro+='</select>';
                }
                else{
                  if(c.dataset.inputtext){
                      filtro+='<input type="text" class="filtroCabecera">';
                  }
                }
                c.innerHTML=`<div class="textTareaTablaCapitalCabecera" readonly minlength="10">${c.innerHTML}</div>${filtro}`
                if(c.dataset.ocultar){c.setAttribute('style','display:none')}
                  
                }
            }
          
        })
        band++;
       }
      )
    }
    agregarElemento(elementoConValores)
    {
      let cantidad=this.tabla.rows.length;
      let cantidadCells=this.tabla.rows[0].cells.length;
      let defecto='';

      elementoConValores.forEach(element=>
              {
      for(let i=0;i<cantidad;i++)
        {
                 for(let j=0;j<cantidadCells;j++)
                  {

                   if(this.tabla.rows[i].cells[j].hasAttribute(element.celdaParaAsignar))
                   {
                    if(element.elemento=='select')
                   {
                      let opciones="";
                     element.valores.forEach(val=>
                   {
                    
                   if(val[1]==this.tabla.rows[i].cells[j].dataset.selectvd){defecto="default";}
                    else{defecto='';}                    
                    opciones+=`<option value="${val[1]}" ${defecto}>${val[0]}</option>`;}
                    )
                    let select=document.createElement('select');                    
                    select.innerHTML =opciones;
                    select.value=this.tabla.rows[i].cells[j].dataset.selectvd;                    
                    select.addEventListener('change',this.cambiaValorElemento);
                    select.setAttribute('class','form-control input-sm')
                    this.tabla.rows[i].dataset.status=this.tabla.rows[i].cells[j].dataset.selectvd;
                    select.id=element.nameId+this.tabla.rows[i].dataset.idtablanoconformidad;
                   /// select.setAttribute('name',this.tabla.rows[i].cells[j].dataset.selectvd);

                    this.tabla.rows[i].cells[j].appendChild(select) ;
                    this.tabla.rows[i].cells[j].dataset.newvalue=this.tabla.rows[i].cells[j].dataset.selectvd;
                    this.tabla.rows[i].cells[j].dataset.oldvalue=this.tabla.rows[i].cells[j].dataset.selectvd;

                  }
                 }             
                 this.tabla.rows[i].cells[j].addEventListener('click',this.copiarTexto,true)           
           }//FIN FOR 2
         }//FIN FOR 1            
        }   
        )
    }
    modificarCelda()
    {
      if(!this.hasAttribute('data-oldvalue')){this.dataset.oldvalue=this.innerHTML;this.dataset.newvalue=this.innerHTML
      }
      this.dataset.newvalue=this.innerHTML;
      if(this.dataset.newvalue!=this.dataset.oldvalue){this.parentNode.dataset.modificado=true;}
    }
     modificarCeldaSinEvento(cell)
    {
     /* if(!cell.hasAttribute('data-oldvalue')){cell.dataset.oldvalue=this.innerHTML;cell.dataset.newvalue=this.innerHTML
      }
      cell.dataset.newvalue=cell.innerHTML;*/
      if(cell.dataset.newvalue!=cell.dataset.oldvalue){cell.parentNode.dataset.modificado=true;}
    }
    cambiaValorElemento()
    {
            if(!this.parentNode.hasAttribute('data-oldvalue')){this.parentNode.dataset.oldvalue=this.value;this.parentNode.dataset.newvalue=this.value
    }
      this.parentNode.dataset.newvalue=this.value;
      this.parentNode.parentNode.dataset.modificado=true;
    }
    devolverRowsConCambios()
    {
      let cant=this.tabla.rows.length;      
      for(let i=0;i<cant;i++)
      {
        if(this.tabla.rows[i].hasAttribute('data-modificado'))
        {
          row.push(this.tabla.rows[i]);

        }
      }
      return row;

      
    }
    guardarRowsConCambios(funcionControlador='')
    {
      let rows=Array.from(this.tabla.rows);
      rows.forEach(r=>{
        if(r.hasAttribute('data-modificado'))
        { let mandarRow=new Object();
          let celdas=Array.from(r.cells);
          celdas.forEach(c=>{  
          if(c.hasAttribute('data-newvalue'))
          {
            if(c.dataset.newvalue!=c.dataset.oldvalue){mandarRow[c.dataset.name]=c.dataset.newvalue;}
           }
          })
          if(mandarRow!=null)
           {
            mandarRow.value=r.dataset.value;
            mandarRow.extra=r.dataset.extra;                               
            this.guardarDatos(funcionControlador,mandarRow);
 
           }
          }
         })
    }
    borrarRow(funcionControlador='')
    {
      let check=Array.from(document.getElementsByName('multiCBNC'));
      console.log(check);
      let cadena='';

      check.forEach(c=>{
        if(c.checked){
          cadena+=c.parentNode.parentNode.dataset.idtablanoconformidad+',';
          
        }
      })
      if(cadena==''){alert('SELECCIONE UNA O VARIAS INCONFORMIDADES A BORRAR')}
      else
      {
        
        console.log(cadena);
        let mandarRow=new Object();
        mandarRow.value=cadena;//rowTabla.dataset.value;
        mandarRow.delete=1;
        let rowTabla='';
        this.guardarDatos(funcionControlador,mandarRow,'delete',rowTabla,this);
      }

      
    }
    guardarDatos(dir,objetoRow,operacion='update',rowTabla=null,objeto=null)
    {
      var parametros = 'params='+JSON.stringify(objetoRow);  
      var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
      var url=direccionAJAX+dir;//+parametros;
      req.open('POST', url, true);
      req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      document.getElementById('gifDeEspera').classList.remove('ocultarObjeto');
      req.onreadystatechange = function (aEvt)
      {
       if (req.readyState == 4) 
       {
        document.getElementById('gifDeEspera').classList.add('ocultarObjeto');
       if(req.status == 200)
        {
         var respuesta=JSON.parse(this.responseText);
        if(operacion=='delete')
        {         
             if(rowTabla){rowTabla.parentNode.deleteRow(rowTabla.sectionRowIndex);}
                let rowBorrar=Array.from(objeto.tabla.rows)
                respuesta.idtablanoconformidad.forEach(i=>{
                  
                     rowBorrar.forEach(r=>{
                      
                      if(r.dataset.idtablanoconformidad==i)
                        { 
                          r.parentNode.parentNode.deleteRow(r.rowIndex);
                          return false;
                        }
                     })
                })
             
             objeto.rows();
             
            aplicarFiltroMeses();
             
        }
          else
          {
            if(operacion=='update')
            {
              guardarBitacoraComentario(respuesta);
              document.getElementById(respuesta.idtablanoconformidad).dataset.status=document.getElementById('status'+respuesta.idtablanoconformidad).value;
            }
          }
        }
   }
  };
 req.send(parametros);

    }
  }
  //=========================FIN DE CLASE=========================

  function escogerCeldaComentario()
  {
    
  }
  function obtenerComentariosDeNoConformidad(datos='',idNoConformidad='')
  {
    if(datos=='')
    {
     let parametros='';
     parametros='id='+idNoConformidad;
     peticionAJAX('procesamientoNC/obtenerComentarios',parametros,'obtenerComentariosDeNoConformidad');
    }
    else
    {
      let comentarioPersona="";
      let comentarioInconforme="";
      let comentarioResponsable="";
      
      datos.comentarios.forEach(coment=>
      {            
          if(coment.tipoComentario==0){comentarioPersona+=`<div>${coment.comentarios}</div>`;}
          if(coment.tipoComentario==1){comentarioInconforme+=`<div>${coment.comentarios}</div>`;}
           if(coment.tipoComentario==2){comentarioResponsable+=`<div>${coment.comentarios}</div>`;}
           
      })      
    let tabla=document.getElementById('tablaNoConformidadIncidencias');
    let cant=tabla.rows.length;
    for(let i=0;i<cant;i++)
     {
      if(tabla.rows[i].dataset.idtablanoconformidad==datos.idtablanoconformidad)
      {
       tabla.rows[i].cells[4].innerHTML= comentarioInconforme
       tabla.rows[i].cells[6].innerHTML= comentarioResponsable;
      }
     } 

    }
  }
  function retornarComentarios()
  {
    let tabla=document.getElementById('tablaNoConformidadIncidencias');
    let cant=tabla.rows.length;
    for(let i=0;i<cant;i++)
     {
      obtenerComentariosDeNoConformidad('',tabla.rows[i].dataset.idtablanoconformidad);
     } 
      
  }
  function llenaCausaRaizAccionCorrectiva()
  {
    document.getElementById('bodyACR')
     var tbody=document.getElementById('bodyACR');
    var option="<option></option>";
  cantTbody=tbody.rows.length;
  for(let i=0;i<cantTbody;i++){option=option+'<option value="'+tbody.rows[i].getAttribute('data-idcausaraiz')+'">'+tbody.rows[i].cells[0].innerHTML+'</option>';}
    document.getElementById('selectCausaRaizNC'). innerHTML=option;  


    var tbodyC=document.getElementById('bodyAAC');
   var optionC="<option></option>";
   cantTbodyC=tbodyC.rows.length;
   for(let i=0;i<cantTbodyC;i++){
   optionC=optionC+'<option value="'+tbodyC.rows[i].getAttribute('data-idaccioncorrectiva')+'">'+tbodyC.rows[i].cells[0].innerHTML+'</option>';
  }
  document.getElementById('selectAccionCorrectivaNC').innerHTML=optionC;
  }


function guardarComentarioResponsableInconformeNC(tipoNC)
{
  seleccion=tablaNoConformidad1.devolverRowSeleccionado();  
  if(seleccion!='')
  {
       var comentario = prompt("ESCRIBIR UN COMENTARIO", "");
   if(comentario != null && comentario != ''){

    guardarComentariosNC('',tipoNC,seleccion.dataset.idtablanoconformidad,comentario)
  }
   else {alert("ESCRIBIR UN COMENTARIO");}
 }

}
function guardarComentariosNC(datos='',tipoComentario=null,idTablaNoConformidad=null,comentario='')
{
 if(datos=="")
 {
   let parametros='comentario='+comentario;
   parametros=parametros+'&id='+idTablaNoConformidad;
   parametros=parametros+'&tipoComentario='+tipoComentario;
   parametros=parametros+'&idTNCComentarios=-1';
   peticionAJAX('procesamientoNC/guardarComentarios',parametros,'guardarComentariosNC');
}
 else{obtenerComentariosDeNoConformidad('',datos.idTablaNoConformidad);}
}



// function guardarCambiosNC(datos='')
// {
//   let rows=tablaNoConformidad1.devolverRowsConCambios();
//   let cantCells=rows[0].cells.length;
//   if(rows.length>0)
//   { let cant=rows.length;
//    for(let i=0;i<cant;i++)
//    {
//     let array=new Object();
//      for(let j=0;j<cantCells;j++)
//      {
//        let bandCI=rows[i].cells[j].hasAttribute('data-comentinconforme') ;
//        let bandCR=rows[i].cells[j].hasAttribute('data-comentresponsable') ;
//        let bandCausa=rows[i].cells[j].hasAttribute('data-selectcr') ;
//        let bandCorreccion=rows[i].cells[j].hasAttribute('data-selectac') ;
//        let bandVeredicto=rows[i].cells[j].hasAttribute('data-comentinconforme') ; 
//        let bandResponsable=rows[i].cells[j].hasAttribute('data-responsable') ; 

//        if(bandCI || bandCR || bandCausa || bandCorreccion || bandVeredicto || bandResponsable)
//        { 
//          if(rows[i].cells[j].hasAttribute('data-newvalue'))
//          {
//           if(rows[i].cells[j].dataset.newvalue!=rows[i].cells[j].dataset.oldvalue)
//           {
//             if(bandCI){array.comentarioInconforme=rows[i].cells[j].dataset.newvalue}
//             if(bandCR){array.comentarioResponsable=rows[i].cells[j].dataset.newvalue}
//             if(bandCausa){array.causaRaiz=rows[i].cells[j].dataset.newvalue}
//             if(bandCorreccion){array.correcion=rows[i].cells[j].dataset.newvalue}
//             if(bandVeredicto){array.veredicto=rows[i].cells[j].dataset.newvalue}
//             if(bandResponsable){array.responsable=rows[i].cells[j].dataset.newvalue}
//           }
//          }
//        }
//      }
//      //peticionAJAX('procesamientoNC/guardarCambiosNC',array,'guardarCambiosIncidencias');
    
//    }
//   }
//   else
//   {
//     alert('NO HAY MODIFICACIONES')
//   }
//  /* seleccion=tablaNoConformidad1.devolverRowSeleccionado();  
//   if(datos=='')
//   {  if(seleccion!='')
//    {
//     let  parametros='';
//     parametros=parametros+'causaRaiz='+document.getElementById('selectCausaRaizNC').value;
//     parametros=parametros+'&accionCorrectiva='+document.getElementById('selectAccionCorrectivaNC').value;
//     parametros=parametros+'&veredicto='+document.getElementById('selectVeredictoNC').value;
//     parametros=parametros+'&id='+seleccion.dataset.idtablanoconformidad;
//     peticionAJAX('procesamientoNC/guardarCambiosNoConformidad',parametros,'guardarCambiosNC');
//    }
//   }
//   else
//   {
    

//   }*/
// }
function guardarCambiosIncidencias()
{
  
}

function agregarPersona()
{
  let select=document.getElementById('selectPersona');
  let texto = select.options[select.selectedIndex].text;
  let valor=select.value;
  seleccion=tablaNoConformidad1.devolverRowSeleccionado(); 
  if(seleccion!='')
  {
  let valorEncontrado=0;
  let cantCells=seleccion.cells.length;
  let newValue="";
  let posicionCelda=0;
  for(let i=0;i<cantCells;i++)
  {
    if(seleccion.cells[i].hasAttribute('data-responsable'))
    {
      let valores=seleccion.cells[i].dataset.newvalue.split(',');
      if(valores.length>0)
      {
       valores.forEach(val=>{if(val!=''){if(val==valor){valorEncontrado=1;}newValue+=`${val},`}}) 
      }
      posicionCelda=i;
    }
  }
   if(valorEncontrado==0)
   {
     let textoAnterior=seleccion.cells[posicionCelda].children[0].innerHTML;
    seleccion.cells[posicionCelda].dataset.newvalue=newValue+valor;
     seleccion.cells[posicionCelda].innerHTML='<div class="contieneTextoTableDiv">'+textoAnterior+'<br>*'+texto+'</div>';
    tablaNoConformidad1.modificarCeldaSinEvento(seleccion.cells[posicionCelda]);
  }
 }
}

  function borrarPersona(){
if(document.getElementsByClassName('rowSeleccionadoTablaCapital')[0]) {
  row = document.getElementsByClassName('rowSeleccionadoTablaCapital');
  console.log(row[0].dataset.idtablanoconformidad);
  body= '<input type="text" style="display:none" class="form-control" id="idtablanoconformidadmodal" value="'+row[0].dataset.idtablanoconformidad+'">';
  responsablesCelda=document.getElementsByClassName('celdaSeleccionadoTablaCapital');
  responsables=responsablesCelda[0].dataset.newvalue;
  responsablesTexto=responsablesCelda[0].getElementsByClassName("contieneTextoTableDiv");
  console.log(responsablesTexto[0].innerHTML);
  var arrayDeResponsables = responsables.split(",");
  var arrayDeResponsablesTexto = responsablesTexto[0].innerHTML.split("<br>");
  for (var i = 0; i < arrayDeResponsablesTexto.length; i++) {
    if(arrayDeResponsablesTexto[i]!=""){
     console.log(arrayDeResponsablesTexto[i],arrayDeResponsables[i-1] );
     body+= '<input type="radio" id="'+arrayDeResponsables[i-1]+'" name="responsables" value="'+arrayDeResponsables[i-1]+'" /><label for="'+arrayDeResponsables[i-1]+'">'+arrayDeResponsablesTexto[i]+'</label><br>'
    }
  }

  document.getElementById('body').innerHTML=body;


  $("#modal-eliminar-persona").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        });
    }
    else {
      swal("¡Espera!", "Debes escoger una fila.", "warning");
    }
  }

  function eliminarResponsable(){
    if(document.querySelector('input[name = "responsables"]:checked')){
      idtablanoconformidad=document.getElementById("idtablanoconformidadmodal").value;
      responsable=document.querySelector('input[name = "responsables"]:checked').value;
      console.log(idtablanoconformidad, responsable);
       $.ajax({
            type: "POST",
            url: `<?=base_url()?>procesamientoNC/eliminarResponsable`,
            data: {
                idtablanoconformidad: idtablanoconformidad,
                idPersona: responsable
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                location.reload()
            },
            error: (error) => {
                swal("¡Uups!", "Hay problemas al eliminar al responsable.", "error");
            }
        })
    }else{
       swal("¡Espera!", "Debes escoger un responsable.", "warning");
    }

  }

  llenaCausaRaizAccionCorrectiva();
  let tablaNoConformidad1=new tablaCapital(document.getElementById('tablaNoConformidadIncidencias'));
  tablaNoConformidad1.agregarElementoParaCelda();
  tablaNoConformidad1.rows();
  tablaNoConformidad1.asignaClaseTabla('ExcelTable2007');
  tablaNoConformidad1.guardarRowsConCambios();
 //let  celdas=['data-comentresponsable','data-comentinconforme','data-responsable'];  
 //tablaNoConformidad1.asignaEventosCeldaTD(celdas);
  //retornarComentarios(); 
  let varCR=document.getElementById('bodyACR');
  let cantCR=varCR.rows.length;
  arregloOpciones=new Array();
  arregloOpcionesAC=new Array();
  array=new Array();
  arregloOpcionesI=new Array();
  arregloOpcionesI[0]='';
  arregloOpcionesI[1]='';
  arregloOpciones.push(arregloOpcionesI);

  for(let i=0;i<cantCR;i++)
  {
    let opciones=new Array();
    opciones[0]=varCR.rows[i].cells[0].innerHTML;
    opciones[1]=varCR.rows[i].dataset.idcausaraiz;
    arregloOpciones.push(opciones);
  }
  arregloOpcionesAC.push(arregloOpcionesI);
   var varAC=document.getElementById('bodyAAC');
   let cantAC=varAC.rows.length;
   for(let i=0;i<cantAC;i++){
    let opciones=new Array();
    opciones[0]= varAC.rows[i].cells[0].innerHTML;
    opciones[1]= varAC.rows[i].dataset.idaccioncorrectiva;
   arregloOpcionesAC.push(opciones);
  }
  

arregloOpcionesVeredicto=<?=imprimirOpcionesVeredicto($statusNoConformidad)?>//new Array(new Array('',''),new Array('RESUELTO','1'),new Array('PENDIENTE','0'));


array[0]={'celdaParaAsignar':'data-selectcr','elemento':'select','valores':arregloOpciones,'nameId':'causaRaiz'};
array[1]={'celdaParaAsignar':'data-selectac','elemento':'select','valores':arregloOpcionesAC,'nameId':'accionCorrectiva'};
array[2]={'celdaParaAsignar':'data-selectveredicto','elemento':'select','valores':arregloOpcionesVeredicto,'nameId':'status'};

tablaNoConformidad1.agregarElemento(array);

function aplicarFiltroMeses()
{
  let valorFiltro=document.getElementById('selectFiltroMeses').value;
  let aplicarFiltro=document.getElementById('aplicarFiltroMeses').checked;  
  let tt=Array.from(tablaNoConformidad1.tabla.rows)
  let cantFiltro=0;
  if(aplicarFiltro){
    let cont=0;
    document.getElementById('selectFiltroMeses').disabled=true;
  tt.forEach(t=>{
    if(cont!=0){
      let fecha=t.dataset.fechacreacion.split('-');
      if(parseInt(fecha[1])!=parseInt(valorFiltro)){
      t.classList.add('ocultarObjeto');      
      
      }
      else{cantFiltro++;}
    }
    cont++;
    })
document.getElementById('totalFiltroLabel').innerHTML=cantFiltro+' Inconformidades filtradas';
}
  else{
    document.getElementById('selectFiltroMeses').disabled=false;
    cantFiltro=-1;
  tt.forEach(t=>{t.classList.remove('ocultarObjeto');
  cantFiltro++;
    })
  document.getElementById('totalFiltroLabel').innerHTML=cantFiltro+' Inconformidades';
  }

}
aplicarFiltroMeses();

 
function trearArchivosInconformidad(idtablanoconformidad)
{
  

document.getElementById('mostrarArchivosInconforme').innerHTML='';
document.getElementById('mostrarArchivosResuelto').innerHTML='';
document.getElementById('mostrarArchivosResponsable').innerHTML='';
//var storageRefInconforme = firebase.storage().ref('inconformidades/'+idtablanoconformidad);
seleccion=tablaNoConformidad1.devolverRowSeleccionado();
let folio=seleccion.dataset.folioinconformidad.replace('IN',"");
//var storageRefInconforme = firebase.storage().ref('inconformidades/'+seleccion.dataset.idtablanoconformidad+'/inconforme/');
var storageRefInconforme = firebase.storage().ref('inconformidades/'+folio+'/inconforme/');


//var storageRefInconforme = firebase.storage().ref('inconformidades/2326/inconforme/');
  let href='';
  storageRefInconforme.listAll().then(function(result) {
  result.items.forEach(function(urlFile) {        
    var nombre=urlFile.location.path.split('/');
    let totalArray=nombre.length;    
    var storage = firebase.storage().ref(urlFile.location.path);    
    let count=0;

    storage.getDownloadURL().then(function(url) 
    {       
      
      count++
      href=url;    
      document.getElementById('mostrarArchivosInconforme').innerHTML +=  `<li><a href="${href}" target="_blank"> ${nombre[totalArray-1]} </a></li>`; 

    })

      
    });


                              })


    //storageRefInconforme = firebase.storage().ref('inconformidades/'+idtablanoconformidad);
   //storageRefInconforme = firebase.storage().ref('inconformidades/'+seleccion.dataset.idtablanoconformidad+'/resuelto/');
   storageRefInconforme = firebase.storage().ref('inconformidades/'+folio+'/resuelto/');
   href='';
  storageRefInconforme.listAll().then(function(result) {
  result.items.forEach(function(urlFile) {        
    var nombre=urlFile.location.path.split('/');
    let totalArray=nombre.length;    
    var storage = firebase.storage().ref(urlFile.location.path);    
    let count=0;

    storage.getDownloadURL().then(function(url) 
    {       
      
      count++
      href=url;    
      document.getElementById('mostrarArchivosResuelto').innerHTML +=  `<li><a href="${href}" target="_blank"> ${nombre[totalArray-1]} </a></li>`; 

    })

      
    });
                              })




    //storageRefInconforme = firebase.storage().ref('inconformidades/'+idtablanoconformidad);
   //storageRefInconforme = firebase.storage().ref('inconformidades/'+seleccion.dataset.idtablanoconformidad+'/administrador/');
   storageRefInconforme = firebase.storage().ref('inconformidades/'+folio+'/administrador/');
   href='';
  storageRefInconforme.listAll().then(function(result) {
  result.items.forEach(function(urlFile) {        
    var nombre=urlFile.location.path.split('/');
    let totalArray=nombre.length;    
    var storage = firebase.storage().ref(urlFile.location.path);    
    let count=0;

    storage.getDownloadURL().then(function(url) 
    {       
      
      count++
      href=url;    
      document.getElementById('mostrarArchivosResponsable').innerHTML +=  `<li><a href="${href}" target="_blank"> ${nombre[totalArray-1]} </a></li>`; 

    })

      
    });
                              })



}
         

</script>
<style type="text/css">
  .rowSeleccionadoTablaCapital{
    border: 2px solid #2b439b;
  }
  .rowSeleccionadoTablaCapital td{color:black;}
  .celdaSeleccionadoTablaCapital{background-color:pink;}
  .celdaSeleccionadoTablaCapital texttarea{background-color: pink}

  .tablaCapitalInconformidades{  border: 1px solid #B0CBEF;
  border-width: 1px 0px 0px 1px;
  font-size: 11pt;
  font-family: Calibri;
  font-weight: 100;
  border-spacing: 0px;
  border-collapse: collapse;}

/*.tablaCapitalInconformidades:hover{color: black;background-color: #46b746}
.tablaCapitalInconformidades TH:nth-child(1){color: black;background-color: #002060;width:50px;max-width: 50px;min-width: 50px}
.tablaCapitalInconformidades TH:nth-child(2){color: black;background-color: #A9D08E}
.tablaCapitalInconformidades TH:nth-child(3){color: black;background-color: #8EA9DB}
.tablaCapitalInconformidades TH:nth-child(4){color: black;background-color: #A6A6A6}
.tablaCapitalInconformidades TH:nth-child(5){color: black;background-color: #F4B084}
.tablaCapitalInconformidades TH:nth-child(6){color: black;background-color: #FFD966}
.tablaCapitalInconformidades TH:nth-child(7){color: black;background-color: #2F75B5}
.tablaCapitalInconformidades TH:nth-child(8){color: black;background-color: #BFBFBF}
.tablaCapitalInconformidades TH:nth-child(9){color: black;background-color: #24E829}
.tablaCapitalInconformidades TH:nth-child(10){color: black;background-color: #00B0F0}
.tablaCapitalInconformidades TD:nth-child(1){color: black;background-color: #E2EFDA;}
.tablaCapitalInconformidades TD:nth-child(2){color: black;background-color: #DDEBF7}
.tablaCapitalInconformidades TD:nth-child(3){color: black;background-color: #D9D9D9}
.tablaCapitalInconformidades TD:nth-child(4){color: black;background-color: #FCE4D6}
.tablaCapitalInconformidades TD:nth-child(5){color: black;background-color: #FFF2CC}
.tablaCapitalInconformidades TD:nth-child(6){color: black;background-color: #DDEBF7}
.tablaCapitalInconformidades TD:nth-child(7){color: black;background-color: #EDEDED}
.tablaCapitalInconformidades TD:nth-child(8){color: black;background-color: #E2EFDA}
.tablaCapitalInconformidades TD:nth-child(9){color: black;background-color: #E2EFDA}
.tablaCapitalInconformidades TD:nth-child(10){color: black;background-color: #D9E1F2}*/
.contieneTextoTableDiv{height: 100%;width: 100%;overflow: auto}

  .ExcelTable2007 {
  border: 1px solid #B0CBEF;
  border-width: 1px 0px 0px 1px;
  font-size: 11pt;
  font-family: Calibri;
  font-weight: 100;
  border-spacing: 0px;
  border-collapse: collapse;
}
.ExcelTable2007>thead>tr:first-child{color:blue;position: sticky;top: -2;background-color: white; z-index: 1;}
.ExcelTable2007 TH {
  background-image: url(excel-2007-header-bg.gif);
  background-repeat: repeat-x; 
  font-weight: normal;
  font-size: 12px;
  border: 1px solid #9EB6CE;
  border-width: 0px 1px 1px 0px;
  height: 17px;
  
  background: rgba(212,228,239,1);
  background: -moz-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212,228,239,1)), color-stop(11%, rgba(212,228,239,1)), color-stop(31%, rgba(212,228,239,1)), color-stop(100%, rgba(183,195,204,1)));
  background: -webkit-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -o-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -ms-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: linear-gradient(to bottom, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e4ef', endColorstr='#b7c3cc', GradientType=0 );
}

.textTareaTablaCapitalCabecera{resize: horizontal;border: none;  /*background: rgba(212,228,239,1);
  background: -moz-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212,228,239,1)), color-stop(11%, rgba(212,228,239,1)), color-stop(31%, rgba(212,228,239,1)), color-stop(100%, rgba(183,195,204,1)));
  background: -webkit-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -o-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);
  background: -ms-linear-gradient(top, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);*/
  /*background: linear-gradient(to bottom, rgba(212,228,239,1) 0%, rgba(212,228,239,1) 11%, rgba(212,228,239,1) 31%, rgba(183,195,204,1) 100%);*/
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d4e4ef', endColorstr='#b7c3cc', GradientType=0 );min-width: 20px;width: 100%;text-align: center;padding: 0px 5px;}
  .textTareaTablaCapitalCabecera textarea: nth-child(0){color:black;border:solid;outline: none;}
.ExcelTable2007 TD {
  border: 0px;
font-size: 12px;
  padding: 0px 0px 0px 2px;
  border: 1px solid #D0D7E5;
  border-width: 0px 1px 1px 0px;
  height: 5px;

}

.ExcelTable2007 TD B {
  border: 0px;
  background-color: white;
  font-weight: bold;
}

.ExcelTable2007 TD.heading {
  background-color: #E4ECF7;
  text-align: center;
  border: 1px solid #9EB6CE;
  border-width: 0px 1px 1px 0px;
}
.ExcelTable2007 >tbody>tr {height: 50px;}
.textTareaTablaCapital{resize: vertical;height: auto;width:100%;min-width: 200px}
.form-control{width:100%;min-width: 100px}
div:: -webkit-scrollbar{width:12px};
textarea:has(th){color:red;}
.ocultarObjeto{display:none;}

.ExcelTable2007 th {
  position: relative;
}
.ExcelTable2007 th .resizing > div{
  border-right: 4px solid #4c6477;
}
.ExcelTable2007  .grip {
      content: "&nbsp;";
      position: absolute;
      top: 0;
      bottom: 0;
      right: 0;
      width: 8px;
      cursor: col-resize;
}
</style>
<script type="text/javascript">

//buscarReportesGraficas('')
//window.addEventListener(buscarReportesGraficas(''))
function aplicarFiltroCabecera(objeto)
{

  let index=objeto.parentNode.cellIndex;
  let body=Array.from(objeto.parentNode.parentNode.parentNode.nextElementSibling.rows);
  let cantFiltro=0;
  if(objeto.value==-1 || objeto.value==''){body.forEach(b=>{b.classList.remove('ocultaRow'+index);})}

  else{
  body.forEach(b=>{

     b.classList.remove('ocultaRow'+index);    
    if(b.cells[index].dataset.newvalue!=objeto.value){b.classList.add('ocultaRow'+index);}     
    var objSelect = $(objeto).find('option:selected');    
    /*if(b.cells[index].dataset.text!=objSelect.data('text')){b.classList.add('ocultaRow'+index);}else{ b.classList.remove('ocultaRow'+index); } */  

   })
  }
  body.forEach(b=>{
        if($(b).is(':visible')){
      cantFiltro++;
    }});
  document.getElementById('totalFiltroLabel').innerHTML=cantFiltro+' Inconformidades filtradas';
}
function despuesCargar()
{
  //document.getElementById('tablaNoConformidadIncidencias').childNodes[1].rows[0].cells[3].setAttribute('style','display:none')
  let filtros=Array.from(document.getElementsByClassName('filtroCabecera'));
  let estilos='';
  filtros.forEach(f=>{
    f.addEventListener('change',function(){aplicarFiltroCabecera(this)},false);
    estilos+='.ocultaRow'+f.parentNode.cellIndex+'{display:none}';
  })

  var nuevaHojaDeEstilo = document.createElement("style");
  document.head.appendChild(nuevaHojaDeEstilo);
  nuevaHojaDeEstilo.textContent = estilos;


}
despuesCargar();
function mostrarHijosArchivos(objeto,ul)
{let hijos=Array.from(document.getElementById(ul).childNodes);
  if(objeto.innerHTML=='<i class="fa fa-minus" aria-hidden="true"></i>')
  {
    objeto.innerHTML='<i class="fa fa-plus" aria-hidden="true"></i>';
    
    hijos.forEach(h=>{h.classList.add('ocultarObjeto')})
  }
  else
  {
    objeto.innerHTML='<i class="fa fa-minus" aria-hidden="true"></i>';
    hijos.forEach(h=>{h.classList.remove('ocultarObjeto')})
  }
}

  $(document).ready(function() {

  })
  //------------------ Filtrar Reporte Incidencias -----------------------
  function filterReport() {
    var input, filter, table, tr, td, i, j, visible;
    input = document.getElementById("filtrarFolio");
    filter = input.value.toUpperCase();
    table = document.getElementById("bodyReporteIncidencias");
    tr = table.getElementsByTagName("tr");
    let Fila = document.getElementsByClassName('mostrar');

    for (i = 0; i < tr.length; i++) {
      visible = false;
      td = tr[i].getElementsByTagName("td");
      for (j = 0; j < td.length; j++) {
        if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
          visible = true;
        }
      }
      if (visible === true) {
        tr[i].style.display = "";
        $(tr[i]).addClass('mostrar');
      }
      else {
        tr[i].style.display = "none";
        $(tr[i]).removeClass('mostrar');
      }
    }
    result = Fila.length;
  }
  //------------------ Redimencionar -------------------
  class Resize {
    constructor() {
      this.resizeColumn = this.resizeColumn.bind(this);
      this.columnResizing = null;
      this.columnResizingOffset = 0;
      this.AddResizingEvent();
    }
    // Función encargada de añadir los eventos de redimensionar
    AddResizingEvent() {
      const table = document.getElementById('tablaNoConformidadIncidencias');
      document.querySelectorAll("thead th").forEach((th) => {
        let grip = document.createElement("div");
        grip.style.height = document.querySelector("table").offsetHeight + "100%";
        grip.classList.add("grip");
        th.appendChild(grip);
        grip.addEventListener("mousedown", (e) => {
          this.columnResizing = th;
          this.columnResizingOffset = th.offsetWidth - e.pageX;
          this.columnResizing.classList.add("resizing");
          document.addEventListener("mousemove", this.resizeColumn);
          document.addEventListener("mouseup", () => {
            document.removeEventListener("mousemove", this.resizeColumn);
            this.columnResizing.classList.remove("resizing");
          });
        });
      });
    }
    // Esta función se encarga de actualizar el tamaño de la columna     //mientras arrastramos
    resizeColumn(e) {
      this.columnResizing.style.minWidth =
        this.columnResizingOffset + e.pageX + "px";
    }
  }
  new Resize();
</script>