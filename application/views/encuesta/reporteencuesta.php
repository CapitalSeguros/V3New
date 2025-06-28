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
        <?
         //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($netpro, TRUE));fclose($fp); 
         ?>
       /* var data = google.visualization.arrayToDataTable([
          ['Task', 'NET PROMOTER SCORE'],
          ['nADA',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);*/
        var data = google.visualization.arrayToDataTable([
                ['nombre', 'valor'],
        <?php 

         foreach ($netpro as $row) {
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($row->nombre, TRUE));fclose($fp); 
          if($row->nombre <> "PROMOTOR")
            {
            echo "['".$row->nombre."',".$row->valor."],";          
            }
            else {
            echo "['".$row->nombre."',".$row->valor."]";          
           // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($row->nombre, TRUE));fclose($fp);
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r( "['".$row['nombre']."',".$row['valor']."]", TRUE));fclose($fp); 
                         # code...
                       }           
           }
        
          ?>
        ]);
        var options = {
          title: 'NET PROMOTER SCORE',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
    
    <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="" >
      <label class="etiquetaLabel1"> &nbsp;&nbsp; &nbsp;&nbsp;</label>            

     <a href="<?=base_url()?>VerEncuesta/ExcelDetractores?valor=<?php  echo $iden ?>" style="background:#2E64FE;color: #FFFFFF;" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" target="_blank">DETRACTORES</a>
      <label class="etiquetaLabel1"> &nbsp;&nbsp;</label>  
     <a href="<?=base_url()?>VerEncuesta/ExcelPasivos?valor=<?php echo $iden?>" style="background:#FF4000;color: #FFFFFF;" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" target="_blank">PASIVOS</a>
      <label class="etiquetaLabel1"> &nbsp;&nbsp;</label>  
     <a href="<?=base_url()?>VerEncuesta/ExcelPromotores?valor=<?php echo $iden?>" style="background:#FFBF00;color: #FFFFFF;" class="glyphicon glyphicon-file btn btn-sucess bullet bullet-verde" target="_blank">PROMOTORES</a>
    </form>
    
  </body>