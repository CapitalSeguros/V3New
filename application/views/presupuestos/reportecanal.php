<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script type="text/javascript">
  <?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script language="javascript">
$(document).ready(function(){
    $("#departamento").on('change', function () {
        $("#departamento option:selected").each(function () {
            elegido=$(this).val();
            $.post("modelos.php", { elegido: elegido }, function(data){
                $("#modelo").html(data);
            });     
        });
   });
});
</script>
<style type="text/css">
  .modal-contenidoGenerico{background-color:none  ;width:90%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .botonCierre{background-color: red;color:white;}
    .contenidoModal{border: solid; color: black; background-color: white;width: 50%;height: 50%}
    .infoModal{position: relative; left: 0%;top: 30%}
    .labelModal{color: red;background-color: white; font-size: 18px;}
    .botonCancelar{border-left: 5px;left: 40%;position: relative;}
    .buttonMenu{width: 100%}
    .subContenido{display: none}
    .ocultarObjeto{display: none}
    .verObjeto{display: block;}
</style>

 <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Canal','Gastos'],
           <?php 
          foreach ($Asig as $row) {
                     echo "['Fianzas',".$row->Fianzas."],";  
                     echo "['Institucional',".$row->Institucional."],"; 
                      echo "['Coorporativo',".$row->Coorporativo."]";         
            }
        
          ?>
        ]);

        var options = {
          title: 'Gasto Por Canal',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
  </body>
  <body>
    <div id="columnchart_material" style="width: 800px; height: 500px;"></div>
  </body>