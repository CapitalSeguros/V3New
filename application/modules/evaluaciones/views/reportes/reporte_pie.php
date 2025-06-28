<!-- headers -->
<?php
	$this->load->view('headers/header');
?>
<link href='<?php echo base_url(); ?>assets/css/apexcharts.css' rel="stylesheet">
<style>
    #graficos_pie {
        max-width: 300px;
        margin: 35px auto;
    }

    #chart {
        max-width: 650px;
    }
</style>

<div id="graficos_pie">
</div>

<div class="modal fade" id="mypie" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                    var seriesName = config.globals.seriesNames[seriesIndex];
                    if (value > 0) {
                        // var clase = el.getAttribute("class").attr("id", "path");
                        // if (clase != null) {
                        // $("#mypie").find(".modal-body").text(value);
                        // $("#mypie").modal("show");
                        // }
                    }
                },
                dataPointSelection: function(event, chartContext, config) {
                    console.log("dataPointSelection");
                    console.log(event.target);
                }
            },

        },
        title:{
            text:'Prueba de gráfica de pie',
            align:'center'
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