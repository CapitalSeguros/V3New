//opciones de moment
moment.lang('es', {
  months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
  monthsShort: 'Enero_Feb_Mar_Abr_May_Jun_Jul_Ago_Sept_Oct_Nov._Dec'.split('_'),
  weekdays: 'Domingo_Lunes_Martes_Miercoles_Jueves_Viernes_Sabado'.split('_'),
  weekdaysShort: 'Dom._Lun._Mar._Mier._Jue._Vier._Sab.'.split('_'),
  weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sa'.split('_')
}
);

//opciones del formato de las graficas
window.formatter = function (val, opts) {
  porcentaje = opts.w.globals.chartID;
  return val;
};

const $path = $("#base_url").attr("data-base-url");
var dateA='';
$(document).ready(function () {
  const $path = $("#base_url").attr("data-base-url");
  let algo=0;
  let contenido="";
  

  $(document).on("input", "#txSearch", function (e) {
    datatable.search(e.currentTarget.value).draw();
  });


  


  const datatableDanosRango = $("#graficos_DANOS_RANGO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    paging:false,
    "bInfo": false,
    /* ajax: {
      url: `${$path}tableros_siniestros/getTable/D`,
      type: "GET",
      dataSrc: function (json) {
        return json.data.data;
      },
    }, */
    ajax: {
      url: `${$path}tableros_siniestros/getTable/D`,
      type: 'POST',
      data : function (d) {
          d.fecha =dateA
      },
      dataSrc: 'data.data'
    },
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      var tmp = `
                <div></div>`;
      $("div.toolbar").html(tmp);
    },
    columns: dataColums,
    bSort: false,
  });

  const datatableGMMRango = $("#graficos_GMM_RANGO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    paging:false,
    "bInfo": false,
    /* ajax: {
      url: `${$path}tableros_siniestros/getTable/G`,
      type: "GET",
      dataSrc: function (json) {
        return json.data.data;
      },
    }, */
    ajax: {
      url: `${$path}tableros_siniestros/getTable/G`,
      type: 'POST',
      data : function (d) {
          d.fecha =dateA
      },
      dataSrc: 'data.data'
    },
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      var tmp = `
                <div></div>`;
      $("div.toolbar").html(tmp);
    },
    columns: dataColums,
    bSort: false,
  });


  //datatable.search('').draw();
  window.metodo = function (index) {
    if(index==0){
      $('#graficos_REPORTE_TIPO_SINIESTRO_wrapper .dataTables_scroll .dataTables_scrollFoot .dataTables_scrollFootInner table tfoot th').eq(index).text("TOTALES");
    }else{
      var total = 0;
      $('#graficos_REPORTE_TIPO_SINIESTRO_wrapper tbody tr').each(function() {
          var value = parseInt($('td', this).eq(index).text());
          if (!isNaN(value)) {
              total += value;
          }
      });
      $('#graficos_REPORTE_TIPO_SINIESTRO_wrapper .dataTables_scroll .dataTables_scrollFoot .dataTables_scrollFootInner table tfoot th').eq(index).text(total);
    }
       
  }

  window.metodo2=function(){
    $('#graficos_REPORTE_TIPO_SINIESTRO_wrapper #graficos_REPORTE_TIPO_SINIESTRO thead th div').each(function(i,elemento) {
        metodo(i);
    });
  }

  var modal = new ModalFiltro({
    classRender: ".js-modal-filter",
    actionOpen: ".bn-open-filter",
    callbackSuccess: function (name, data) {
    //alert(`'es data de la tabla ${name} `);
      switch (name) {
        case "REPORTE_BONO":
          datatable.clear();
          datatable.rows.add(data);
          datatable.draw();
          break;
        case "REPORTE_EVALUACIONES":
          datatableEv.clear();
          datatableEv.rows.add(data);
          datatableEv.draw();
          break;
        case "SINIESTROS_RANGO_AUTOS":
           //alert("grafica de los rango autos");
           updateDatos(name, data);
           clickReloadRango(name);
           datatable2.ajax.reload();
          break;
        case "SINIESTROS_RANGO_DANOS":
            //alert("grafica de los rango daños");
            updateDatos(name, data);
            clickReloadRango(name);
            datatableDanosRango.ajax.reload();
           break;
        case "SINIESTROS_RANGO_GMM":
            //alert("grafica de los rango GMM");
            updateDatos(name, data);
            clickReloadRango(name);
            datatableGMMRango.ajax.reload();
            break;
        case "TABLA_MES_AUTOS":
        case "TABLA_ANO_AUTOS":
        case "TABLA_MES_DANOS":
        case "TABLA_ANO_DANOS":
        case "TABLA_MES_GMM":
        case "TABLA_ANO_GMM":
            setTitle(name);
            setTitle2(name);
            //alert(`'es data de la tabla ${name} `+ JSON.stringify(data));
            updateTablesData(name,data);
            break;
        default:
          updateDatos(name, data);
          break;
      }

    }
  });
  modal.init();


  window.updateDatos = function (name, data) {
    setTitle(name);
    if (data != undefined) {
      if(name=="SINIESTROS_TOP_ESTADOS"){
        ApexCharts.exec(name, "updateOptions", {
          labels: data.labels,
          series: data.series
        });
      }else{
        if (data.options != undefined) {
          ApexCharts.exec(name, "updateOptions", data.options);
        }
        ApexCharts.exec(name, 'updateSeries', data.series, true);
      }
    }
    
  }

  window.setTitle=function(name){
    //moment.locale('es-es');
    var grahpname=$(`#btnfilter-${name}`).data('chart-title');
    let año=$(`#btnfilter-${name}`).data('setyear');//setyear
    let mes=$(`#btnfilter-${name}`).data('setmonth');
    let fecha=$(`#btnfilter-${name}`).data('date');
    console.log("fecha_add",fecha);
    let setaño=año?'-'+moment(fecha).locale('es').format("YYYY"):'';
    let setmes=mes?'-'+moment(fecha).locale('es').format("MMM"):'';
    ano_tabla=moment(fecha).locale('es').format("YYYY");
    mes_tabla=moment(fecha).locale('es').format("MM");
    console.log("LA FECHA ES ",fecha);
    console.log("el año seleccionado", moment(fecha).locale('es').format("YYYY"));
    console.log("el mes seleccionado es ",moment(fecha).locale('es').format("MM"));
    //ano_tabla=

    //console.log(`title_${name}`);
    //console.log({"mes":mes,"mes-es":setmes,"año":año,"año-es":setaño});
    $(`#title_${name}`).text(grahpname+setmes.toUpperCase()+setaño);
    //console.log("title",grahpname+setaño+setmes);
  }
  window.setTitle2=function(name){
    //moment.locale('es-es');
    var grahpname=$(`#btnfilter-${name}2`).data('chart-title');
    let año=$(`#btnfilter-${name}`).data('setyear');//setyear
    let mes=$(`#btnfilter-${name}`).data('setmonth');
    let fecha=$(`#btnfilter-${name}`).data('date');
    let setaño=año?'-'+moment(fecha).locale('es').format("YYYY"):'';
    let setmes=mes?'-'+moment(fecha).locale('es').format("MMM"):'';
    $(`#title_${name}2`).text(grahpname+setmes.toUpperCase()+setaño);
    //console.log("title",grahpname+setaño+setmes);
  }



  ///Metodo para actualizar las tablas de los reportes de movimientos (NUM y PORCENTAJES)
  window.updateTablesData = function (id, data) {
    var datos=data[0];
    var total=datos['Total'];
    Object.keys(datos).forEach(key => {
        //console.log(`Total-key${key}->`+total+' data->'+datos[key]+ ' resultado'+datos[key]/total)
        $(`#${id}_${key}`).html(datos[key]);
        $(`#${id}_p_${key}`).html(((datos[key]/total?datos[key]/total:0)*100).toFixed(2)+'%');
    });
    $(`#${id}_Totales`).html(total);
    $(`#${id}_p_Totales`).html(((total/total?total/total:0)*100)+'%');
    $(`#${id}_p_Totaless`).html(((total/total?total/total:0)*100)+'%');
    $(`#${id}_Terminados`).html(datos['ter_no_tiempo']+datos['ter_en_tiempo']);
    $(`#${id}_p_Terminados`).html((((datos['ter_no_tiempo']+datos['ter_en_tiempo'])/total?(datos['ter_no_tiempo']+datos['ter_en_tiempo'])/total:0)*100).toFixed(2)+'%');
    $(`#${id}_Pendientes`).html(datos['pend_en_tiempo']+datos['pend_no_tiempo']);
    $(`#${id}_p_Pendientes`).html((((datos['pend_en_tiempo']+datos['pend_no_tiempo'])/total?(datos['pend_en_tiempo']+datos['pend_no_tiempo'])/total:0)*100).toFixed(2)+'%');
    
  }


});
  
//tabla de los rangos
var dataColums = _headers;
  const datatable2 = $("#graficos_AUTOS_RANGO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    paging:false,
    "bInfo": false,
    ajax: {
      url: `${$path}tableros_siniestros/getTable/A`,
      type: 'POST',
      data : function (d) {
          d.fecha =dateA
      },
      dataSrc: 'data.data'
    },
    dom: '<"toolbar">rtip ',
    initComplete: function () {
    },
    columns: dataColums,
    bSort: false,
  });

///tabla de los registros al hacer click en las tablas de pie
var id_tabla='';var status='';var ano_tabla='';var mes_tabla='';
const datatable = $('#Tableros_siniestros').DataTable({
  language: {
      url: `${$path}assets/js/espanol.json`
  },
  ajax: {
      url: `${$path}tableros_siniestros/getTablasEstatus`,
      type: 'POST',
      data : function (d) {
          d.id = id_tabla,
          d.estatus=status,
          d.ano=ano_tabla,
          d.mes=mes_tabla
      },
      dataSrc: 'data'
  },
  pageLength : 5,
  dom: '<"toolbar">rtip ',
  initComplete: function() {
      var tmp = `
      <div>
      <div class="row">
          <div class="col-md-12 text-right" style="margin-top: 10px;">
                  <a class="btn btn-primary Nuevo" href="Danos/RegistroDanos">Nuevo</a>
          </div>
      </div>
      </div>`
      $('div.toolbar').html(tmp);
      //GetTotal();
  },
  drawCallback:function(settings){
    if(id_tabla!=''){
      $("#modal_tablero").modal('show');
    }
    var api = this.api();
    if ( ! api.data().any() ) {
      $("#descarga_tablero").addClass("hidden");
    }else{
      $("#descarga_tablero").removeClass("hidden");
    }
  },
  columns: [
      {
          data: 'id',
          visible: false
      },
      {
          data: null,
          orderable: false,
          render: function(data, type, row) {
              //console.log(row);
              //var colorS = color(row.estatus);
              return renderEstatusTabla(row,id_tabla);
              //return `<div>test</div>`;
          }
      },
      {
          data: null,
          orderable: false,
          render: function(data, type, row) {
              //var date=new Date(row.inicio_ajuste);
              return TipoTablaRender(row,id_tabla);
          }
      },
      {
          data: 'nombre',
          orderable: false,
          render: function(data, type, row) {
              //var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.siniestro_estatus);
              return renderProgreso(row,id_tabla);
          }
      },
      {
          data: null,
          "sClass": "control",
          "sDefaultContent": '',
          "orderable": false,
          visible: false,
          render: function(data, type, row) {
              //var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.estatus);
              //console.log("tramite",Findtramite(row.tipo_tramite==null?1:row.tipo_tramite+1))
              //console.log("row",row);//${row.estatus_t=="ACTIVO"?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="CerarTramite(${row.id},${row.tramite})" >Cerrar tramite</a></li>`:''}
              return `
              <div style="text-align: center;" >
                      <div class="dropdown">
                          <button class="btn btn-link dropdown-toggle" type="button" id="dp${row.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dp${row.id}">
                              <li><a class="bn-bono-view"  style="cursor: pointer;" onclick="Ver(${row.id})" >Ver</a></li>
                          </ul>
                      </div>
              </div>
              `;
          }
      }
  ],
  "order": [
      [0, 'desc']
  ],
});

var rango1=null;var rango2=null;
const datatableRangos = $('#Tableros_siniestros_rangos').DataTable({
  language: {
      url: `${$path}assets/js/espanol.json`
  },
  ajax: {
      url: `${$path}tableros_siniestros/getTablasRangosclikc`,
      type: 'POST',
      data : function (d) {
          d.id = id_tabla,
          d.rango1=rango1,
          d.rango2=rango2
      },
      dataSrc: 'data'
  },
  pageLength : 5,
  dom: '<"toolbar">rtip ',
  initComplete: function() {
    var tmp = `
    <div>
    <div class="row">
        <div class="col-md-12 text-right" style="margin-top: 10px;">
                <a class="btn btn-primary Nuevo" href="Danos/RegistroDanos">Nuevo</a>
        </div>
    </div>
    </div>`
    $('div.toolbar').html(tmp);
    //GetTotal();
  },
  drawCallback:function(){
    if(id_tabla!=''){
      $("#modal_tablero_rango").modal('show');
    }
    var api = this.api();
    if ( ! api.data().any() ) {
      $("#descarga_tablero_rango").addClass("hidden");
    }else{
      $("#descarga_tablero_rango").removeClass("hidden");
    }
  },
  columns: [
      {
          data: 'id',
          visible: false
      },
      {
          data: 'estatus',
          width: '150px',
          orderable: false,
          render: function(data, type, row) {
              //console.log(row);
              //var colorS = color(row.estatus);
              return renderEstatusTabla(row,id_tabla);
          }
      },
      {
          data: null,
          orderable: false,
          render: function(data, type, row) {
              //var date=new Date(row.inicio_ajuste);
              return TipoTablaRender(row,id_tabla);
          }
      },
      {
          data: 'nombre',
          orderable: false,
          width: '200px',
          render: function(data, type, row) {
              return renderProgreso(row,id_tabla);
          }
      },
      {
          data: null,
          "sClass": "control",
          "sDefaultContent": '',
          width: '120px',
          "orderable": false,
          visible: false,
          render: function(data, type, row) {
              //var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.estatus);
              //console.log("tramite",Findtramite(row.tipo_tramite==null?1:row.tipo_tramite+1))
              //console.log("row",row);//${row.estatus_t=="ACTIVO"?`<li><a class="bn-bono-view"  style="cursor: pointer;" onclick="CerarTramite(${row.id},${row.tramite})" >Cerrar tramite</a></li>`:''}
              return `
              <div style="text-align: center;" >
                      
              </div>
              `;
          }
      }
  ],
  "order": [
      [0, 'desc']
  ],
});

window.Colorbarra=function(parametro,progreso,fechaI,fechaF,estado){
  var FI=moment(fechaI, "YYYY-MM-DD");
  var FF=fechaF==null?moment():moment(fechaF, "YYYY-MM-DD");
  var days=FF.diff(FI, 'days');
  var color = {};
  var total = parseFloat(parseInt(days) / parseInt(parametro==null?1:parametro));

  if (estado == "LIQUIDADO" || estado == "FINALIZADO"||estado=="FINIQUITADO") {
    //console.log(`dias-> ${days}, parametro-> ${parametro},  total-> `,total);
      color = {
          color: Colores(total),
          porcentaje: "100%",
          mensaje: `Se ha liquidado el trámite en ${days} dias`,
          dias:days
      };
  }
  else if (estado=='RECHAZADO') {
      color = {
          color: "#472380",
          porcentaje: "100%",
          mensaje: 'Se ha rechazado el trámite',
          dias:days
      };
  } 
  else if (parametro == null) {
      color = {
          color: "#472380",
          porcentaje: "0%",
          mensaje: 'No se tiene ningún indicador relacionado.',
          dias:isNaN(days)?0:days
          
      };
  } else {
      if (total >= 0 && total <= 0.40) {
          color = {
              color: Colores(total),
              porcentaje: "30%",
              mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
              dias:days
          };
      }
      if (total > 0.40 && total <= 0.60) {
          color = {
              color: Colores(total),
              porcentaje: "60%",
              mensaje: `han transcurrido ${days} dias de los${parametro} del indicador`,
              dias:days
          };
      }
      if (total > 0.60 && total < 1) {
          color = {
              color: Colores(total),
              porcentaje: "85%",
              mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
              dias:days
          };
      }
      if (total >= 1) {
          color = {
              color: Colores(total),
              porcentaje: "100%",
              mensaje: `Han transcurrido ${days} dias de los ${parametro} del indicador`,
              dias:days
          };
      }
  }
  return color;
  
}
window.Colores=function(total){
  var color='';
  if (total >= 0 && total <= 0.40) {
          color="#6dca6d";
      }
      if (total > 0.40 && total <= 0.60) {
          color="#e8f051";
      }
      if (total > 0.60 && total < 1) {
          color="#e68d10";
      }
      if (total >= 1) {
          color="#db311a";
      }
      return color;
}
/* window.LoadTabletablero=function(){
  datatable.ajax.reload();
}
 */
window.returnDataClic=function(event, chartContext, config,id){
  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name != null) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }

    var id = document.getElementById(id);
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
  }
  return {"nombre":name,"titulo":titulo,"filtros":filtros};
}

//Eventos de las tablas especificas
window.clickSINIESTROS_AUTOS_TOTAL = async function (event, chartContext, config) {
  let fecha=$(`#btnfilter-SINIESTROS_AUTOS_TOTAL`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
/*   console.log("LA FECHA ES ",fecha);
  console.log("el año seleccionado", moment(fecha).locale('es').format("YYYY"));
  console.log("el mes seleccionado es ",moment(fecha).locale('es').format("MM")); */

  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_AUTOS_TOTAL");
  id_tabla='SINIESTROS_AUTOS_TOTAL';
  status=dta.nombre;
  await datatable.ajax.reload();
  //console.log("dta",dta);
  //await $("#modal_tablero").modal('show');
}

window.clickSINIESTROS_DANOS_TOTAL=async function(event, chartContext, config){
  let fecha=$(`#btnfilter-SINIESTROS_DANOS_TOTAL`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_DANOS_TOTAL");
  //console.log("dta",dta);
  id_tabla='SINIESTROS_DANOS_TOTAL';
  status=dta.nombre;
  await datatable.ajax.reload();
  //await $("#modal_tablero").modal('show');
}

window.clickSINIESTROS_GMM= async function(event, chartContext, config){
  let fecha=$(`#btnfilter-SINIESTROS_GMM`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_GMM");
  //console.log("dta",dta);
  id_tabla='SINIESTROS_GMM';
  status=dta.nombre;
  await datatable.ajax.reload();
  //await $("#modal_tablero").modal('show');
}

window.TipoTablaRender=function(row,tipo){
  var contenido='';
  switch (tipo) {
    case "SINIESTROS_AUTOS_TOTAL":
    case "SINIESTROS_RANGO_AUTOS":
      contenido=`<div class="row">
              <div class="col-md-12">
                  <div>
                      <div class="media-body">
                          <h5 class="media-heading"><strong>Evento: ${row.tipo_siniestro_nombre}, Causa: ${row.causa_nombre}</strong> </h5>
                          <div class="Siniestro-body">
                              <div class="box first">Fecha inicio: ${row.inicio_ajuste==null?'N/A':moment(row.inicio_ajuste).format("DD/MM/YYYY")}</div>
                              <div class="box first" style="padding-left: 15px;"> Asegurado: ${row.asegurado_nombre}</div>
                              <div class="box first" style="padding-left: 15px;"> Número de siniestro: ${row.siniestro_id}</div>
                              <div class="box first" style="padding-left: 15px;"> Poliza: ${row.poliza}</div>
                          </div>
                      </div>
                  </div>  
              </div>
          </div>`;
      
      break;
      case "SINIESTROS_DANOS_TOTAL":
      case "SINIESTROS_RANGO_DANOS":
        var index = _Tram.findIndex(elemt => elemt.nombre === row.nombre_tramite);
        contenido=`<div class="row">
        <div class="col-md-12">
            <div>
                <div class="media-body">
                    <h4 class="media-heading"><strong>Evento: ${row.nombre_tramite==null?'N/A':row.nombre_tramite}</strong> (${index+1} de ${_Tram.length})</h4>
                    <div class="Siniestro-body">
                        <div class="box first ">Fecha inicio: ${row.inicio_ajuste==null?'N/A':moment(row.inicio_ajuste).format("DD/MM/YYYY")}</div>
                        <div class="box first" style="padding-left: 15px;"> Asegurado: ${row.asegurado_nombre}</div>
                        <div class="box first" style="padding-left: 15px;"> Número de siniestro: ${row.siniestro_id}</div>
                        <div class="box first" style="padding-left: 15px;"> Poliza: ${row.poliza}</div>
                    </div>
                </div>
            </div>  
        </div>
    </div>`;
      break;
      case "SINIESTROS_GMM":
      case "SINIESTROS_RANGO_GMM":
        var complemento=JSON.parse(row.complemento_json);
        contenido=`<div class="row">
        <div class="col-md-12">
            <div>
                <div class="media-body">
                    <h4 class="media-heading"><strong>Tramite: ${row.nombre_tramite==null?'N/A':row.nombre_tramite}</strong></h4>
                    <div class="Siniestro-body">
                        <div class="box first">Fecha inicio: ${row.fecha_inicio==null?moment(row.inicio_ajuste).format("DD/MM/YYYY"):moment(row.fecha_inicio).format("DD/MM/YYYY")}</div>
                        <div class="box first" style="padding-left: 15px;"> Afectado: ${complemento.general['afectado']}</div>
                        <div class="box first" style="padding-left: 15px;"> Número de siniestro: ${row.siniestro_id}</div>
                        <div class="box first" style="padding-left: 15px;"> Poliza: ${row.poliza}</div>
                        <div class="box first" style="padding-left: 15px;"> Folio CIA: ${row.folio_cia==null?'N/A':row.folio_cia}</div>
                    </div>
                </div>
            </div>  
        </div>
    </div>`;
      break;
      default:
        contenido='';
      break;
  }


  return contenido;
}

window.renderEstatusTabla=function(row,tipo){
    var contenido='';
    switch (tipo) {
      case "SINIESTROS_AUTOS_TOTAL":
      case "SINIESTROS_RANGO_AUTOS":
        contenido=`<div class="col-md-1 center-aling-items">
                    <div class="card-round" style="background:${row.color==null?'#8c8787':row.color};">
                        <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.siniestro_estatus==null?'N/A':row.siniestro_estatus}</h6>
                    </div>
            </div>`;
        break;
      case "SINIESTROS_DANOS_TOTAL":
      case "SINIESTROS_RANGO_DANOS":
        contenido=`<div class="col-md-1 center-aling-items">
                  <div class="card-round" style="background:${row.color==null?'#8c8787':row.color};">
                      <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.estatus==null?'N/A':row.estatus}</h6>
                  </div>
          </div>`;
      break;
      case "SINIESTROS_GMM":
      case "SINIESTROS_RANGO_GMM":
        contenido=`<div class="col-md-1 center-aling-items">
              <div class="card-round" style="background:${row.color==null?'#8c8787':row.color};">
                  <h6 class="text-uppercase fw-bold text-center" style="padding-top:9px;padding-bottom: 9px;font-size: 9px;color: white !important;">${row.estatus==null?'N/A':row.estatus}</h6>
              </div>
          </div>`;
      break;
    }
    return contenido;
}

window.renderProgreso=function(row,tipo){
  var contenido='';
  switch (tipo) {
    case "SINIESTROS_AUTOS_TOTAL":
    case "SINIESTROS_RANGO_AUTOS":
      var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.siniestro_estatus);
      contenido=`<div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>`;
    break;
    case "SINIESTROS_DANOS_TOTAL":
    case "SINIESTROS_RANGO_DANOS":
      var colorS= Colorbarra(row.dias,row.progreso,row.inicio_ajuste,row.fecha_fin,row.siniestro_estatus);
      contenido=` <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>`;
    break;
    case "SINIESTROS_GMM":
    case "SINIESTROS_RANGO_GMM":
      var colorS= Colorbarra(row.dias,row.progreso,row.fecha_inicio,row.fec_tram_F,row.estatus);
      contenido=` <div style="float: left;font-size: 20px;" class="text-center"><div style="font-size: 12px;"> Duración</div><div style="height: 30px;width: 30px;background-color: ${colorS.color};color:white;border-radius: 50%; display: inline-block;">${colorS.dias}</div><div  style="font-size: 12px;"> Dias </div></div>`;
    break;
  }
  return contenido;
}

//aciones de las tablas de rangos 
window.clickSINIESTROS_RANGO_AUTOS=function(event, chartContext, config){
  let fecha=$(`#btnfilter-SINIESTROS_RANGO_AUTOS`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_RANGO_AUTOS");
  //console.log("dta",dta);
  id_tabla='SINIESTROS_RANGO_AUTOS';
  var match=dta.nombre.match(/\d+/g);
  rango1=match[0];
  rango2=match[1];
  datatableRangos.ajax.reload();
  //console.log({"val1":match[0],"val2":match[0]});
   //$("#modal_tablero_rango").modal('show');
}

window.clickSINIESTROS_RANGO_DANOS=function(event, chartContext, config){
  let fecha=$(`#btnfilter-SINIESTROS_RANGO_DANOS`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_RANGO_DANOS");
  //console.log("dta",dta);
  id_tabla='SINIESTROS_RANGO_DANOS';
  var match=dta.nombre.match(/\d+/g);
  rango1=match[0];
  rango2=match[1];
  datatableRangos.ajax.reload();
  //console.log({"val1":match[0],"val2":match[1]});
   //$("#modal_tablero_rango").modal('show');
}

window.clickSINIESTROS_RANGO_GMM=function(event, chartContext, config){
  let fecha=$(`#btnfilter-SINIESTROS_RANGO_GMM`).data('date');
  ano_tabla=moment(fecha).locale('es').format("YYYY");
  mes_tabla=moment(fecha).locale('es').format("MM");
  var dta=returnDataClic(event,chartContext,config,"graficos_SINIESTROS_RANGO_GMM");
  //console.log("dta",dta);
  id_tabla='SINIESTROS_RANGO_GMM';
  var match=dta.nombre.match(/\d+/g);
  rango1=match[0];
  rango2=match[1];
  datatableRangos.ajax.reload();
  //console.log({"val1":match[0],"val2":match[1]});
   //$("#modal_tablero_rango").modal('show');
}


window.clickReloadRango=function(name){
  //console.log("name",name);
  let dateF=$(`#btnfilter-${name}`).data('date');
  dateA=moment(dateF).format('MM/DD/YYYY');
}
