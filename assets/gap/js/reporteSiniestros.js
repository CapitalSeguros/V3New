window.formatter = function (val, opts) {
  porcentaje = opts.w.globals.chartID;
  if (
    porcentaje == "SINIESTROS_COMPARACION_MESES" ||
    porcentaje == "SINIESTROS_TOP_ESTADOS"
  ) {
    return val;
  } else {
    return val + "%";
  }
};

$(document).ready(function () {
  const $path = $("#base_url").attr("data-base-url");
  _headers1.forEach(element =>{
    $("#F_tabla_2").append("<th>t</th>");
  });
  let algo=0;
  let contenido="";
  const datatable = $("#graficos_REPORTE_TIPO_SINIESTRO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    ajax: {
      url: `${$path}Siniestros/getTabla1`,
      type: "GET",
      dataSrc: function (json) {
        return json.data.data;
      },
    },
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      //console.log("contenido Exterior",contenido);
      var tmp = `<div class="row">
              <div class="col-sm-4">
                <div style="display:inline-block;margin-right:10px;"><label>Buscar:</label></div>
                <div style="display:inline-block;"><input type="text" placeholder="Buscar..." autocomplete="off" id="txSearch" class="form-control input-sm"  name="search"  /></div>
              </div>
          </div>`;
      $("#graficos_REPORTE_TIPO_SINIESTRO_wrapper div.toolbar").html(tmp);
      metodo2();
      metodo(2);
      //$("#graficos_REPORTE_TIPO_SINIESTRO_wrapper #F_tabla_2").append(contenido);
    },
    paging:false,
    columns: _headers1,
    scrollY:400,
    scrollCollapse:true,
    footerCallback: function (row, data, start, end, display) {
      $("#F_tabla_2").append("");
      algo++;
      var api = this.api();
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      nb_cols = api.columns().nodes().length;
      j = 0;
      sum = "";
      while (j < nb_cols) {
        if (j == 0) {
          sum += `<th class="control">TOTALES</th>`;
        } else {
          let total = api
            .column(j,{ page: 'current' })
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b);
            }, 0);
          sum += `<th class="control text-center"><div class="center-block">${total}</div></th>`;
        }
        j++;
      }
      /* $("#F_tabla_2").empty();
      $("#F_tabla_2").append(sum); */
      contenido=sum;
    },
    bSort: false,
  });
  //datatable.search('y').draw();
  

  $(document).on("input", "#txSearch", function (e) {
    datatable.search(e.currentTarget.value).draw();
  });


  var dataColums = _headers;
  const datatable2 = $("#graficos_PERIODO_TERMINO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    paging:false,
    ajax: {
      url: `${$path}Siniestros/getTabla2`,
      type: "GET",
      dataSrc: function (json) {
        return json.data.data;
      },
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

  //var dataColums=_headers;
  const datatable3 = $("#graficos_ESTATUS_MESES").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`,
    },
    paging:false,
    ajax: {
      url: `${$path}Siniestros/getTabla3`,
      type: "GET",
      dataSrc: function (json) {
        return json.data.data;
      },
    },
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      var tmp = `<div></div>`;
      $("div.toolbar").html(tmp);
    },
    columns: _headers3,
    ordering: false,
    footerCallback: function (row, data, start, end, display) {
      var api = this.api();
      var intVal = function (i) {
        return typeof i === "string"
          ? i.replace(/[\$,]/g, "") * 1
          : typeof i === "number"
          ? i
          : 0;
      };

      nb_cols = api.columns().nodes().length;
      j = 0;
      sum = "";
      while (j < nb_cols) {
        if (j == 0) {
          sum += `<th>TOTALES</th>`;
        } else {
          let total = api
            .column(j)
            .data()
            .reduce(function (a, b) {
              return intVal(a) + intVal(b);
            }, 0);
          sum += `<th class="control text-center">${total}</th>`;
        }
        j++;
      }
      $("#F_tabla_3").empty();
      $("#F_tabla_3").append(sum);
    },
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
        default:
          updateDatos(name, data);
          break;
      }

    }
  });
  modal.init();


  window.updateDatos = function (name, data) {
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
      //ApexCharts.exec(name, "updateOptions", data.options);
      // ApexCharts.exec(name, "updateSeries", data.series);
    }
  }


  $(document).on("input", "#clientes", function (e) {
    let valor=e.currentTarget.value;
      //console.log("clientes :v"+e.currentTarget.value);¿
      const data={cliente:valor};
      $.ajax({
        type: 'POST',
        url: `${$path}Siniestros/changeClient`,
        dataType: 'json',
        data: data,
        success: function(response) {
          document.getElementById("Total").innerHTML = response.data.DataSiniestros[0].total;
          document.getElementById("Tramite").innerHTML = response.data.DataSiniestros[0]["EN TRAMITE"];
          document.getElementById("Avisado").innerHTML = response.data.DataSiniestros[0]["AVISADO"];
          document.getElementById("Condicionado").innerHTML = response.data.DataSiniestros[0]["CONDICIONADO"];
          document.getElementById("Liquidado").innerHTML = response.data.DataSiniestros[0]["LIQUIDADO"];
          ApexCharts.exec("TEST", "updateOptions", {series: response.data.TEST["series"]});
          ApexCharts.exec("SINIESTROS_TODOS_LOS_MESES", "updateOptions", {series: response.data.MESES["series"],options: response.data.MESES["options"]});
          ApexCharts.exec("SINIESTROS_COMPARACION_MESES", "updateOptions", {series: response.data.COMPARACION["series"],options: response.data.COMPARACION["options"]});
          ApexCharts.exec("CORTE_SINIESTROS", "updateOptions", {series: response.data.CORTE["series"]});
          ApexCharts.exec("SINIESTROS_TOP_ESTADOS", "updateOptions", {series: response.data.ESTADOS["series"],labels:response.data.ESTADOS["labels"]});
          datatable.clear();datatable.rows.add(response.data.Tabla1);datatable.draw();metodo2();
          datatable2.clear();datatable2.rows.add(response.data.Tabla2);datatable2.draw();
          datatable3.clear();datatable3.rows.add(response.data.Tabla3);datatable3.draw();
          
          //#graficos_TEST
        },
        error: function(xhr) {
            console.log('error', xhr);
        }
    });

  });

});
