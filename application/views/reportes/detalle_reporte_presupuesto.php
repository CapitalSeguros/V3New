<?php
  //$this->load->view('headers/header'); 
  $this->load->view('headers/menu');
?>
<?php 
    $ci =& get_instance();
    $ci->load->library("libreriav3");
    $months4 = $ci->libreriav3->devolverMeses();
    //var_dump($months);
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<br>
<div class="container">
  <div class="row">
      <div class="col-md-2 col-sm-2 col-xs-2">
        <h4 class="titulo-secciones">
            <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
            </div>
        </h4>
    </div>
</div>
<br>
<!-- Graficos comparacion Anuales-->
<!--Presupuesto-->

<div class="row">
  <div class="col-md-10 col-sm-10 col-xs-10">
    <h4 class="titulo-secciones">
        <i class="fa fa-area-chart"></i>Grafico de Comportamiento de Presupuesto Anual
    </h4>
    <br>
  </div>
</div>
<input type="hidden" name="" id="base-url" data-url="<?=base_url()?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<?php 
$this->load->view('reportes/detalle_reporte_presupuesto_seguros');
$this->load->view('reportes/detalle_reporte_presupuesto_fianzas');
$this->load->view('reportes/detalle_reporte_presupuesto_corporativo');
?>

<script src="<?=base_url()."/assets/js/jquery.filterbudget.js"?>"></script>
<script src="<?=base_url()."/assets/js/jquery.filterbudgetfianzas.js"?>"></script>
<script src="<?=base_url()."/assets/js/jquery.filterbudgetcorporate.js"?>"></script>

