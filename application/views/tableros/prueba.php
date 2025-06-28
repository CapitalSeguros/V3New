<style>
    .labelM {
        /* float: right; */
        font-size: 16px;
    }

    #element1 {
        float: left;
    }

    #element2 {
        /* padding-left: 5px; */
        float: left;
    }

    .padre {
        display: flex;
        justify-content: center;
    }

    .hijo {
        padding: 10px;
        margin: 10px;
    }

    .tituloP{
        font-size: 20px;
    }
    
</style>
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <h3 class="titulo-secciones">Tablero de siniestros</h3>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3" style="float: right;">
        </div>
    </div>
    <hr />
</section>
<section class="container">
    <div style="float: left; width: 90%;">
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">Total de registros</div>
                <div class="panel-body">
                   <div class="row">
                        <div class="col-sm-12 text-center">
                           <!--  <div class="tituloP"><?= $DataSiniestros[0]["total"] ?></div> -->
                            <div>Registros</div>
                           <!--  <div id="element2" class="labelM"><?= $DataSiniestros[0]["total"] ?> <br> <div id="Total">Registros</div></div> -->
                        </div>
                   </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Estado de los registros</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-2 text-center">
                          <!--   <div style="font-size: 20px;"><?= $DataSiniestros[0]["EN TRAMITE"] ?></div> -->
                            <div>En trámite</div>
                            <!-- <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["EN TRAMITE"] ?><br><div id="Tramite" style="word-break: break-all;">En trámite</div></div> -->
                            
                        </div>
                        <div class="col-sm-2 text-center">
                           <!--  <div style="font-size: 20px;"><?= $DataSiniestros[0]["AVISADO"] ?></div> -->
                            <div>Avisados</div>
                            <!-- <div id="element2" class="labelM text-center"><b> </b><br> <div id="Avisado">Avisados</div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                           <!--  <div style="font-size: 20px;"><?= $DataSiniestros[0]["CONDICIONADO"] ?></div> -->
                            <div>Condicionado</div>
                          <!--   <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["CONDICIONADO"] ?><br> <div id="Condicionado">Condicionado</div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                           <!--  <div style="font-size: 20px;"><?= $DataSiniestros[0]["LIQUIDADO"] ?></div> -->
                            <div>Liquidados</div>
                          <!--   <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["LIQUIDADO"] ?> <br><div id="Liquidado">Liquidados </div></div> -->
                        </div>
                        <div class="col-sm-2 text-center">
                            <!-- <div style="font-size: 20px;"><?= $DataSiniestros[0]["VACIOS"] ?></div> -->
                            <div>Sin estatus</div>
                           <!--  <div id="element2" class="labelM text-center"><?= $DataSiniestros[0]["VACIOS"] ?> <br><div id="Liquidado">Sin estatus </div></div> -->
                        </div>
                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-default" >
                <div class="panel-heading">Última actualización</div>
                <div class="panel-body">
                 <!--    <div class="text-center"><?= $lastupdate ?></div> -->
                   <!--  <div id="element2" class="labelM"><?= $lastupdate ?></div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico1["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
            <?= $grafico2["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico3["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico4["HTML"] ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <?= $grafico5["HTML"] ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
               
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>RANGO DE DÍAS DE RESPUESTA</h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="empresa" data-chart-title="REPORTE BONOS" data-chart-name="REPORTE_BONO" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_PERIODO_TERMINO">
                                <thead style="font-size: 10px;">
                                    <tr id="Head-T">

                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padre">
                            <?= $grafico6["HTML"] ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>NÚMERO DE MOVIMIENTOS-AUTOS</h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="empresa" data-chart-title="REPORTE BONOS" data-chart-name="ESTATUS_MESES" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr id="Head-T" style="font-size:9px;">
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr id="Head-T">
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white; font-size:10px;">Movimientos</td>
                                        <td style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td style="text-align:center;"><?=$tablaAutos[0]['ter_no_tiempo']?></td>
                                        <td style="text-align:center;"><?=$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td style="text-align:center;"><?=$tablaAutos[0]['pend_en_tiempo']?></td>
                                        <td style="text-align:center;"><?=$tablaAutos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white; font-size:10px;">Totales</td>
                                        <td style="text-align:center;min-width: 48px;"><?=$tablaAutos[0]['Total']?></td>
                                        <td style="text-align:center;" colspan="2"><?=$tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo']?></td>
                                        <td style="text-align:center;" colspan="2"><?=$tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo']?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>PORCENTAJES DE MOVIMIENTOS-AUTOS</h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="empresa" data-chart-title="REPORTE BONOS" data-chart-name="ESTATUS_MESES" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered" >
                                <thead style="font-size: 9px;">
                                    <tr >
                                        <th colspan="2"></th>
                                        <th colspan="2" style="text-align:center;">Terminados</th>
                                        <th colspan="2" style="text-align:center;">Pendientes</th>
                                    </tr>
                                    <tr >
                                        <th colspan="2" style="text-align:right;">Total</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                        <th style="text-align:center;">En Estandar</th>
                                        <th style="text-align:center;">Fuera de estandar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center; background-color:#472380; color:white;">Movimientos</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['Total']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['ter_no_tiempo']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['ter_en_tiempo']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['pend_en_tiempo']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['pend_no_tiempo']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                    </tr>
                                    <tr style="font-size:11px;">
                                        <td style="text-align:center;background-color:#472380; color:white;">Totales</td>
                                        <td style="text-align:center;"><?=round(($tablaAutos[0]['Total']/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['ter_no_tiempo']+$tablaAutos[0]['ter_en_tiempo'])/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                        <td style="text-align:center;" colspan="2"><?=round((($tablaAutos[0]['pend_en_tiempo']+$tablaAutos[0]['pend_no_tiempo'])/$tablaAutos[0]['Total'])*100,2)?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="menu-panel">
                        <h5>CORTE DE SINIESTROS</h5><a class="bn-open-filter pull-right" style="color:white;margin-top: -30px" data-filter="empresa" data-chart-title="REPORTE BONOS" data-chart-name="REPORTE_BONO" data-uri-filter="<?php echo base_url(); ?>incidencias/updateChart"><i class='fa fa-cog fa-2x' aria-hidden='true'></i></a>
                    </div>
                    <input type="hidden" id="test" value="">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed" id="graficos_REPORTE_TIPO_SINIESTRO">
                                <thead style="font-size: 10px;">
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr id="F_tabla_2">

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="js-modal-filter">
</div>
<div class="modaldetalle"></div>
<script type="text/javascript">
window.formatter = function (val, opts) {
  porcentaje = opts.w.globals.chartID;
  if (
    porcentaje == "SINIESTROS_COMPARACION_MESES" ||
    porcentaje == "SINIESTROS_TOP_ESTADOS"||
    porcentaje == "SINIESTROS_AUTOS_COMPARACION"
  ) {
    return val;
  } else {
    return val + "%";
  }
};

$(document).ready(function () {
  const $path = $("#base_url").attr("data-base-url");
  /* _headers1.forEach(element =>{
    $("#F_tabla_2").append("<th>t</th>");
  }); */
  let algo=0;
  let contenido="";
  /* const datatable = $("#graficos_REPORTE_TIPO_SINIESTRO").DataTable({
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
      //$("#F_tabla_2").empty();
      //$("#F_tabla_2").append(sum);
      contenido=sum;
    },
    bSort: false,
  });
  //datatable.search('y').draw(); */
  

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
      url: `${$path}pruebas/getTable/A`,
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
/*   const datatable3 = $("#graficos_ESTATUS_MESES").DataTable({
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
  }); */

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

</script>
