window.formatter = function (val, opts) {
  porcentaje = opts.w.globals.chartID;
  if (porcentaje == "EVALUACIONES_DESEMPENIO") {
    return val;
  } else {
    return val + "%";
  }
};
$(document).ready(function () {
  const $path = $("#base_url").attr("data-base-url");

  $(document).on("input", "#txSearch", function (e) {
    datatable.search(e.currentTarget.value).draw();
  });
  $(document).on("input", "#txSearchEv", function (e) {
    datatableEv.search(e.currentTarget.value).draw();
  });

  const datatable = $("#graficos_REPORTE_BONO").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`
    },
    ajax: {
      url: `${$path}Bonos/bonosreporte`,
      type: "GET",
      dataSrc: function (json) {
        return json.data;
      }
    },
    columns: [{
        data: "nombre",
        defaultContent: "Sin Nombre"
      },
      {
        data: "calificacion",
        render: function (data, type, row) {
          return `${Number.parseFloat(data).toFixed(2)} %`;
        }
      },
      {
        data: "bono",
        defaultContent: "Sin bono",
        sClass: "control text-right",
        width: "40px",
        orderable: false,
        render: function (data, type, row) {
          return `$ ${data}`;
        }
      }
    ],
    order: [
      [1, "desc"]
    ],
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      var tmp = `<div class="row">
              <div class="col-sm-3">
                  <label>Buscar </label>
                  <input type="text" placeholder="Buscar..." autocomplete="off" id="txSearch" class="form-control input-sm"  name="search"  />
              </div>
          </div>`;
      $("graficos_REPORTE_BONO_wrapper div.toolbar").html(tmp);
    }
  });

  const datatableEv = $("#graficos_REPORTE_EVALUACIONES").DataTable({
    language: {
      url: `${$path}assets/js/espanol.json`
    },
    ajax: {
      url: `${$path}evaluaciones/getReporteEvaluaciones`,
      type: "GET",
      dataSrc: function (json) {
        return json.data;
      }
    },
    columns: [{
        data: "empleado",
        defaultContent: "Sin Nombre"
      },
      {
        data: "calificacion",
        render: function (data, type, row) {
          return `${Number.parseFloat(data).toFixed(2)} %`;
        }
      },
      {
        data: "puesto",
        defaultContent: "Sin Nombre"
      }
    ],
    order: [
      [1, "desc"]
    ],
    dom: '<"toolbar">rtip ',
    initComplete: function () {
      var tmp = `<div class="row">
              <div class="col-sm-3">
                  <label>Buscar </label>
                  <input type="text" placeholder="Buscar..." autocomplete="off" id="txSearchEv" class="form-control input-sm"  name="search"  />
              </div>
          </div>`;
      $("#graficos_REPORTE_EVALUACIONES_wrapper div.toolbar").html(tmp);
    }
  });


  //type = bar (el resultado en porcentaje)




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
      if (data.options != undefined) {
        ApexCharts.exec(name, "updateOptions", data.options);
      }
      ApexCharts.exec(name, 'updateSeries', data.series, true);
      // ApexCharts.exec(name, "updateSeries", data.series);
    }
  }

  window.ajax = function (name, titulo, filtros) {
    $.ajax({
      method: "POST",
      url: `${$path}tablero/detallereporte`,
      dataType: "json",
      data: {
        seriename: name,
        filtro: filtros
      },
      success: function (data) {
        const modalDetalle = new ModalDetail({
          classRender: ".modaldetalle"
        });

        modalDetalle.show(titulo, data.data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert("Error while request..");
      }
    });
  }
});

window.clickINCIDENCIAS_MENSUALES = function (event, chartContext, config) {

  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name != null) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }

    var id = document.getElementById("graficos_INCIDENCIAS_MENSUALES");
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
    ajax(name, titulo, filtros);
  }
};

window.clickROTACION_PERSONAL = function (event, chartContext, config) {
  var index = config.dataPointIndex;
  var dataLabels = config.globals.categoryLabels[index];

  var id = document.getElementById("graficos_ROTACION_PERSONAL");
  var titulo = name.concat(" ", chartContext.opts.title.text);

  var filtros = "";
  if (id.dataset.chartFilter != null) {
    filtros = id.dataset.chartFilter;
  }
  if (dataLabels > 0) {
    $.ajax({
      method: "POST",
      url: "detallerotacion",
      dataType: "json",
      data: {
        seriename: titulo,
        filtro: filtros,
        anio: dataLabels
      },
      success: function (data) {
        const modalDetalle = new ModalDetail({
          classRender: ".modaldetalle"
        });

        modalDetalle.show(titulo, data.data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert("Error while request..");
      }
    });
  }
};

window.dataPointSelectionCOMPARATIVO_COLABORADORES = function (e, chart, opts) {
  var serie = opts.seriesIndex;
  console.log(serie);
  var index = opts.dataPointIndex;
  var data = opts.w.config.series[serie].data[index];
  console.log(data);
  var titulo = chart.w.globals.seriesNames[serie];
  var punto = opts.selectedDataPoints;
  console.log(punto);
  var valor_punto = "";
  if (punto[0] != null) {
    if (punto[0][0] > 0) {
      valor_punto = punto[0][0];
    } else {
      valor_punto = punto[0];
    }
  }

  var id = document.getElementById("graficos_COMPARATIVO_COLABORADORES");
  var filtros = "";
  if (id.dataset.chartFilter != null) {
    filtros = id.dataset.chartFilter;
  }

  if (data > 0) {
    $.ajax({
      method: "POST",
      url: "detallereportepoint",
      dataType: "json",
      data: {
        seriename: titulo,
        filtro: filtros,
        puntos: valor_punto
      },
      success: function (data) {
        //     //var name = config.globals.labels[posicion_name - 1];
        const modalDetalle = new ModalDetail({
          classRender: ".modaldetalle"
        });

        modalDetalle.show(titulo, data.data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert("Error while request..");
      }
    });
  }
};

window.clickINCIDENCIAS_TRIMESTRAL = function (event, chartContext, config) {
  var el = event.target;
  // var seriesIndex = parseInt(el.getAttribute("i"));
  // var dataPointIndex = parseInt(el.getAttribute("j"));
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name > 0) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }
    var id = document.getElementById("graficos_INCIDENCIAS_TRIMESTRAL");
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
    ajax(name, titulo, filtros);
  }
};

window.clickINCIDENCIAS_BIMESTRALES = function (event, chartContext, config) {
  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name != null) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }

    var id = document.getElementById("graficos_INCIDENCIAS_BIMESTRALES");
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
    ajax(name, titulo, filtros);
  }
};

window.clickINCIDENCIAS_SEMESTRALES = function (event, chartContext, config) {
  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name != null) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }

    var id = document.getElementById("graficos_INCIDENCIAS_SEMESTRALES");
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
    ajax(name, titulo, filtros);
  }
};

window.clickINCIDENCIAS_ANUALES = function (event, chartContext, config) {
  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  if (posicion_name != null) {
    var name = config.globals.labels[posicion_name - 1];
    if (name == undefined) {
      name = "";
    }

    var id = document.getElementById("graficos_INCIDENCIAS_ANUALES");
    var titulo = name.concat(" ", chartContext.opts.title.text);
    var hoy = new Date();
    var filtros = "";
    if (id.dataset.chartFilter != null) {
      filtros = id.dataset.chartFilter;
    }
    ajax(name, titulo, filtros);
  }
};

window.clickEVALUACIONES_DESEMPENIO = function (event, chartContext, config) {
  var index = config.dataPointIndex;
  var el = event.target;
  var posicion_name = el.parentNode.getAttribute("rel");
  var label = config.globals.labels[index];
  var id = document.getElementById("graficos_EVALUACIONES_DESEMPENIO");
  var titulo = name.concat(" ", chartContext.opts.title.text);
  // console.log(dataLabels);
  var filtros = "";
  if (id.dataset.chartFilter != null) {
    filtros = id.dataset.chartFilter;
  }
  if (posicion_name > 0) {
    $.ajax({
      method: "POST",
      url: "detalledesempenio",
      dataType: "json",
      data: {
        seriename: titulo,
        filtro: filtros,
        labels: label
      },
      success: function (data) {
        const modalDetalle = new ModalDetail({
          classRender: ".modaldetalle"
        });

        modalDetalle.show(titulo, data.data);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
        alert("Error while request..");
      }
    });
  }
};