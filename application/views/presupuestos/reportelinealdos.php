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
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Meses');
      /*data.addColumn('number', 'Guardians of the Galaxy');
      data.addColumn('number', 'The Avengers');
      data.addColumn('number', 'Transformers: Age of Extinction');*/
       <?php 
         foreach ($ano as $aban) 
         {
          
           echo "data.addColumn('number','".$aban."');";  
           // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("data.addColumn('number','".$aban."')", TRUE));fclose($fp); 
         }

      ?>
      data.addRows([
         <?php 
          $a=1;$b=1;
          $uno="";$dos="";$tres="";$cuatro="";$cinco="";$seis="";$siete="";$ocho="";$nueve="";$diez="";$once="";$doce="";
          foreach ($valor as $row) 
              {
                        $b=1;
                     foreach ($row as $che)
                      {
                         
                            if($a==1)
                            {
                            
                              if($b==1)
                              { 
                                $uno=$uno."[".$b.",".$che;    

                              }
                              if($b==2)
                              { 
                                $dos=$dos."[".$b.",".$che;                               
                              }
                              if($b==3)
                              { 
                                $tres=$tres."[".$b.",".$che;                               
                              }
                              if($b==4)
                              { 
                                $cuatro=$cuatro."[".$b.",".$che;                               
                              }
                              if($b==5)
                              { 
                                $cinco=$cinco."[".$b.",".$che;                               
                              }
                              if($b==6)
                              { 
                                $seis=$seis."[".$b.",".$che;                               
                              }
                              if($b==7)
                              { 
                                $siete=$siete."[".$b.",".$che;                               
                              }
                              if($b==8)
                              { 
                                $ocho=$ocho."[".$b.",".$che;                               
                              }
                              if($b==9)
                              { 
                                $nueve=$nueve."[".$b.",".$che;                               
                              }
                              if($b==10)
                              { 
                                $diez=$diez."[".$b.",".$che;                               
                              }
                              if($b==11)
                              { 
                                $once=$once."[".$b.",".$che;                               
                              }
                              if($b==12)
                              { 
                                $doce=$doce."[".$b.",".$che;                               
                              }
                              
                              if($row == end($valor))
                              {
                               if($che == end($row))
                               {
                                 if($b==1)
                                 { 
                                  $uno=$uno."],"; 
                                 }
                                 if($b==2)
                                 { 
                                  $dos=$dos."],"; 
                                 }
                                 if($b==3)
                                 { 
                                  $tres=$tres."],"; 
                                 }
                                 if($b==4)
                                 { 
                                  $cuatro=$cuatro."],"; 
                                 }
                                 if($b==5)
                                 { 
                                  $cinco=$cinco."],"; 
                                 }
                                 if($b==6)
                                 { 
                                  $seis=$seis."],"; 
                                 }
                                 if($b==7)
                                 { 
                                  $siete=$siete."],"; 
                                 }
                                 if($b==8)
                                 { 
                                  $ocho=$ocho."],"; 
                                 }
                                 if($b==9)
                                 { 
                                  $nueve=$nueve."],"; 
                                 }
                                 if($b==10)
                                 { 
                                  $diez=$diez."],"; 
                                 }
                                 if($b==11)
                                 { 
                                  $once=$once."],"; 
                                 }
                                 if($b==12)
                                 { 
                                  $doce=$doce."]"; 
                                 } 
                               }
                               else
                               {
                                if($b==1)
                                 { 
                                  $uno=$uno."],"; 
                                 }
                                 if($b==2)
                                 { 
                                  $dos=$dos."],"; 
                                 }
                                 if($b==3)
                                 { 
                                  $tres=$tres."],"; 
                                 }
                                 if($b==4)
                                 { 
                                  $cuatro=$cuatro."],"; 
                                 }
                                 if($b==5)
                                 { 
                                  $cinco=$cinco."],"; 
                                 }
                                 if($b==6)
                                 { 
                                  $seis=$seis."],"; 
                                 }
                                 if($b==7)
                                 { 
                                  $siete=$siete."],"; 
                                 }
                                 if($b==8)
                                 { 
                                  $ocho=$ocho."],"; 
                                 }
                                 if($b==9)
                                 { 
                                  $nueve=$nueve."],"; 
                                 }
                                 if($b==10)
                                 { 
                                  $diez=$diez."],"; 
                                 }
                                 if($b==11)
                                 { 
                                  $once=$once."],"; 
                                 }
                                 if($b==12)
                                 { 
                                  $doce=$doce."],"; 
                                 }
                               }  
                              }
                             }  
                             else
                             {
                              if($row == end($valor))
                               {
                                 if($che == end($row))
                                 {
                                  if($b==1)
                                  {
                                   $uno=$uno.",".$che."],"; 
                                  }
                                  if($b==2)
                                  {
                                   $dos=$dos.",".$che."],"; 
                                  } 
                                  if($b==3)
                                  {
                                   $tres=$tres.",".$che."],"; 
                                  }
                                  if($b==4)
                                  {
                                   $cuatro=$cuatro.",".$che."],"; 
                                  }
                                  if($b==5)
                                  {
                                   $cinco=$cinco.",".$che."],"; 
                                  }
                                  if($b==6)
                                  {
                                   $seis=$seis.",".$che."],"; 
                                  }
                                  if($b==7)
                                  {
                                   $siete=$siete.",".$che."],"; 
                                  }
                                  if($b==8)
                                  {
                                   $ocho=$ocho.",".$che."],"; 
                                  }
                                  if($b==9)
                                  {
                                   $nueve=$nueve.",".$che."],"; 
                                  }
                                  if($b==10)
                                  {
                                   $diez=$diez.",".$che."],"; 
                                  }
                                  if($b==11)
                                  {
                                   $once=$once.",".$che."],"; 
                                  }
                                  if($b==12)
                                  {
                                   $doce=$doce.",".$che."]"; 
                                  }
                                 }
                                 else
                                 {
                                  if($b==1)
                                  {
                                   $uno=$uno.",".$che."],"; 
                                  }
                                  if($b==2)
                                  {
                                   $dos=$dos.",".$che."],"; 
                                  } 
                                  if($b==3)
                                  {
                                   $tres=$tres.",".$che."],"; 
                                  }
                                  if($b==4)
                                  {
                                   $cuatro=$cuatro.",".$che."],"; 
                                  }
                                  if($b==5)
                                  {
                                   $cinco=$cinco.",".$che."],"; 
                                  }
                                  if($b==6)
                                  {
                                   $seis=$seis.",".$che."],"; 
                                  }
                                  if($b==7)
                                  {
                                   $siete=$siete.",".$che."],"; 
                                  }
                                  if($b==8)
                                  {
                                   $ocho=$ocho.",".$che."],"; 
                                  }
                                  if($b==9)
                                  {
                                   $nueve=$nueve.",".$che."],"; 
                                  }
                                  if($b==10)
                                  {
                                   $diez=$diez.",".$che."],"; 
                                  }
                                  if($b==11)
                                  {
                                   $once=$once.",".$che."],"; 
                                  }
                                  if($b==12)
                                  {
                                   $doce=$doce.",".$che."],"; 
                                  }
                                 }
                               }
                               else
                               {
                                 if($b==1)
                                 {
                                  $uno=$uno.",".$che;                               
                                 }
                                 if($b==2)
                                 {
                                  $dos=$dos.",".$che;                               
                                 }
                                 if($b==3)
                                 {
                                  $tres=$tres.",".$che;                               
                                 }
                                 if($b==4)
                                 {
                                  $cuatro=$cuatro.",".$che;                               
                                 }
                                 if($b==5)
                                 {
                                  $cinco=$cinco.",".$che;                               
                                 }
                                 if($b==6)
                                 {
                                  $seis=$seis.",".$che;                               
                                 }
                                 if($b==7)
                                 {
                                  $siete=$siete.",".$che;                               
                                 }
                                 if($b==8)
                                 {
                                  $ocho=$ocho.",".$che;                               
                                 }
                                 if($b==9)
                                 {
                                  $nueve=$nueve.",".$che;                               
                                 }
                                 if($b==10)
                                 {
                                  $diez=$diez.",".$che;                               
                                 }
                                 if($b==11)
                                 {
                                  $once=$once.",".$che;                               
                                 }
                                 if($b==12)
                                 {
                                  $doce=$doce.",".$che;                               
                                 } 
                               }
                             }
                              $b++;                           
                            }              
                         $a++;
                     }
                      echo $uno.$dos.$tres.$cuatro.$cinco.$seis.$siete.$ocho.$nueve.$diez.$once.$doce; 
                      $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($uno.$dos.$tres.$cuatro.$cinco.$seis.$siete.$ocho.$nueve.$diez.$once.$doce, TRUE));fclose($fp);
                     /* echo $dos;
                      echo $tres;
                      echo $cuatro;
                      echo $cinco;
                      echo $seis;
                      echo $siete;
                      echo $ocho;
                      echo $nueve;
                      echo $diez;
                      echo $once;
                      echo $doce;
                                  */
                   ?>
                 
      ]);

      var options = {
        chart: {
          title: 'Comparacion de gastos',
          subtitle: 'En Pesos'
        },
        width: 900,
        height: 500,
         vAxis: {
          title: 'Depositos (Pesos)',
          format: '$#'
        },
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
        
      };

      var chart = new google.charts.Line(document.getElementById('line_top_x'));
      //var chart2 = new google.visualization.ColumnChart(document.getElementById('decimal'));
       //  chart.draw(data, options);
      //document.getElementById('format-select').onchange = function() {
          // options['vAxis']['format'] = 'decimal';
          
      chart.draw(data, google.charts.Line.convertOptions(options));
      //chart2.draw(data, options);
    }
  </script>
</head>
<body>
  <div id="line_top_x"></div>
</body>