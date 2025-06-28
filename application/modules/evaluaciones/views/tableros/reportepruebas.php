<!-- headers -->
<?php
	$this->load->view('headers/header');
?>
<link href='<?php echo base_url(); ?>assets/css/apexcharts.css' rel="stylesheet">
<style>
    #graficos_bar,
    #graficos_line,
    #graficos_pie {
        max-width: 300px;
        margin: 35px auto;
    }

    #chart {
        max-width: 650px;
    }
</style>

<ul class="user-perfil pull-left">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="caret"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-left">
            <li><a href="#" title="Barras" id="bar"><i class="fa fa-user"></i> Barras</a></li>
            <li><a href="#" title="Lineas" id="line"><i class="fa fa-cogs"></i> Lineas</a></li>
            <li><a href="#" title="Circular" id="circle"><i class="fa fa-sign-out"></i> Circular</a></li>
        </ul>
    </li>
</ul>


<div id="graficos_bar">
</div>

<div id="graficos_line">
</div>

<div></div>
<div id="graficos_pie">
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    $("#bar").click(function(e) {
        e.preventDefault();
        var options1 = {
            chart: {
                id: 'prueba15',
                type: 'bar',
                height: 300,
                foreColor: '#373d3f',
                width: 400,
                events: {
                    click: function(event, chartContext, config) {
                        var el = event.target;
                        var seriesIndex = parseInt(el.getAttribute("i"));
                        var dataPointIndex = parseInt(el.getAttribute("j"));
                        var value = el.getAttribute("val");
                        console.log(value);
                        var seriesName = config.globals.seriesNames[seriesIndex];
                        if (value > 0) {
                            // var clase = el.getAttribute("class").attr("id", "path");
                            // if (clase != null) {

                            $("#myModal").find(".modal-body").text(value);
                            $("#myModal").modal("show");
                            // }
                        }
                    }
                },
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: true,
                    zoomedArea: {
                        fill: { //contorno de la seleccion
                            color: '#90CAF9',
                            //color: 'red',
                            opacity: 0.4
                        },
                        stroke: { //linea de seleccion
                            color: '#0D47A1',
                            //color: 'purple',
                            opacity: 0.4,
                            width: 1
                        }
                    }
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
            series: [{
                name: 'prueba one',
                data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
            }, {
                name: 'prueba dos',
                data: [20, 28, 30, 40, 50, 60, 70, 80, 90]
            }],
            xaxis: {
                title: {
                    text: 'prueba x'
                },
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
                tickPlacement: 'on' //solo cuando es grafica de barras se pone para aparecer zoom, reset etc
            },
            yaxis: {
                title: {
                    text: 'pueba y'
                }
            },
            colors: ['#546E7A', '#E91E63'], //colores de las barras
            dataLabels: {
                enable: true,
                style: { //formato de la informacion de datos en la grafica
                    fontSize: 8,
                    fontFamily: 'Helvetica, Arial, sans-serif',
                    fontWeight: 'bold',
                },
                textAnchor: 'middle'
            }
        }

        document.getElementById('graficos_bar').innerHTML = '';
        var chart1 = new ApexCharts(document.querySelector("#graficos_bar"), options1);
        chart1.render();

        //despues de un tiempo se actualiza por los datos que se pasen
        setTimeout(function() {
            ApexCharts.exec('prueba15', 'updateSeries', [{
                data: [100, 200, 300, 400, 500, 600, 700, 800]
            }], true);
        }, 5000);
    });

    $("#line").click(function(e) {
        e.preventDefault();
        var options3 = {
            chart: {
                height: 200,
                width: 350,
                stacked: false,
                zoom: {
                    enabled: true,
                    type: 'xy',
                    autoScaleYaxis: true,
                    zoomedArea: {
                        fill: {
                            color: '#90CAF9',
                            opacity: 0.8
                        },
                        stroke: {
                            color: '#0D47A1',
                            opacity: 0.4,
                            width: 1
                        }
                    }
                },
                events: {
                    click: function(event, chartContext, config) {
                        var el = event.target;
                        var seriesIndex = parseInt(el.getAttribute("i"));
                        var dataPointIndex = parseInt(el.getAttribute("j"));
                        var value = el.getAttribute("val");
                        var seriesName = config.globals.seriesNames[seriesIndex];
                        console.log(event.target);
                        if (value > 0) {
                            var clase = el.getAttribute("class");
                            if (clase != null) {
                                alert(clase);
                            }
                        }
                    },
                    dataPointSelection(event, chartContext, config) {
                        console.log(event.target);
                    }
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
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            series: [{
                name: 'Series Column',
                type: 'column',
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            }, {
                name: 'Series Area',
                type: 'area',
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            }, {
                name: 'Series Line',
                type: 'line',
                data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
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
                size: 0
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
                shared: true,
                intersect: false,
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
        document.getElementById('graficos_line').innerHTML = '';
        var chart3 = new ApexCharts(document.querySelector("#graficos_line"), options3);
        chart3.render();
    });


    var options4 = {
        chart: {
            id: 'prueba_pie',
            type: 'pie',
            height: 200,
            width: 380,
            events: {
                click: function(event, chartContext, config) {
                    var el = event.target;
                    var seriesIndex = parseInt(el.getAttribute("i"));
                    var dataPointIndex = parseInt(el.getAttribute("j"));
                    var value = el.getAttribute("data:value");
                    console.log(value);
                    var seriesName = config.globals.seriesNames[seriesIndex];
                    if (value > 0) {
                        // var clase = el.getAttribute("class").attr("id", "path");
                        // if (clase != null) {
                        $("#myModal").find(".modal-body").text(value);
                        $("#myModal").modal("show");
                        // }
                    }
                },
                dataPointSelection: function(event, chartContext, config) {
                    console.log("dataPointSelection");
                    console.log(event.target);
                }
            },

        },
        series: [80, 120, 50],
        labels: ["nombre", "apellido", "ciudad"],
        colors: ['#546E7A', '#E91E63', '#00E396'], //colores de las barras
        dataLabels: {
            enable: true,
            style: { //formato de la informacion de datos en la grafica
                fontSize: 10,
                fontFamily: 'Helvetica, Arial, sans-serif',
                fontWeight: 'bold',
            },
            textAnchor: 'middle'
        }
    }

    document.getElementById('graficos_pie').innerHTML = '';
    var chart4 = new ApexCharts(document.querySelector("#graficos_pie"), options4);
    chart4.render();
    // });
</script>