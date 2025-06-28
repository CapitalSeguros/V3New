<!-- headers -->
<?php
$this->load->view('headers/header');
?>
<link href='<?php echo base_url(); ?>assets/css/apexcharts.css' rel="stylesheet">
<style>
    

    #chart {
        max-width: 650px;
    }
</style>

<div id="graficos_linea">
</div>

<div class="modal fade" id="myline" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <!--modal-lg -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/plugins/apexcharts/apexcharts.js'></script>
<script type="text/javascript">

    var options3 = {
        chart: {
            id: 'prueba_lineas',
            type: 'line',
            
            events: {
                dataPointSelection: function(e, chart, opts){
                    var serie = opts.seriesIndex;
                    var index = opts.dataPointIndex;
                    var data = opts.w.config.series[serie].data[index];
                    if (data > 0){
                        alert(data);

                    }
                }
                // markerClick: function(q, e, t) {
                //     console.log(q);
                //     console.log(e);
                //     console.log(t);
                //     console.log(t.w.config.labels);
                // }
                // click: function(event, chartContext, config) {

                //     console.log(config);
                //     console.log(event.target);
                //     // console.log(config.w.config.labels[config.dataPointIndex]);
                //     var el = event.target;
                //     var seriesIndex = parseInt(el.getAttribute("i"));
                //     var dataPointIndex = parseInt(el.getAttribute("j"));
                //     var value = el.getAttribute("val");
                //     var seriesName = config.globals.seriesNames[seriesIndex];
                //     // console.log(value);
                //     if (value > 0) {
                //         var clase = el.getAttribute("class");
                //         if (clase != null) {
                //             alert(clase);
                //         }
                //     }
                // }
            }
        },
        toolbar: {
            show: true,
            tools: {
                selection: true,
                zoom: true,
                download: false,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true
            },
            autoSelected: 'zoom'
        },
        stroke: {
            curve: 'smooth'
        },
        // plotOptions: {
        //     bar: {
        //         columnWidth: '50%'
        //     }
        // },
        series: [{
            //     name: 'Series Column',
            //     type: 'column',
            //     data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            // }, {
            // name: 'Series Area',
            // type: 'area',
            // data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            //}
            //, {
            name: 'Series Line',
            //  type: 'line',
            data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
        }, {
            name: 'Series Column',
            //  type: 'column',
            data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
        }],
        fill: {
            opacity: [0.85, 0.25, 1],
            gradient: {
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 0.55,
                stops: [0, 100, 100, 100]
            }
        },
        labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
        markers: {
            size: 2
            // ,
            // onClick: function(e) {
            //     console.log(e);
            // }
        },
        xaxis: {
            type: 'datetime'
        },
        yaxis: {
            title: {
                text: 'Points',
            },
            min: 0
        },
        legend: {
            show: false
        },
        tooltip: {
            shared: false,
            intersect: true,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            }
        }
    }
    document.getElementById('graficos_linea').innerHTML = '';
    var chart3 = new ApexCharts(document.querySelector("#graficos_linea"), options3);
    chart3.render();
    //despues de un tiempo se actualiza por los datos que se pasen
    // setTimeout(function() {
    //     ApexCharts.exec('prueba_lineas', 'updateSeries', [{
    //         data: [100, 200, 300, 400, 500, 600, 700, 800]
    //     }], true);
    // }, 5000);    
</script>