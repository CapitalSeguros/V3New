<?php 
  $this->load->view('headers/header'); 
  $this->load->view('headers/headerReportes');
  $this->load->view('headers/menu');
?>
<br>
<input type="hidden" id="base" value="<?php echo base_url()?>">
<div class="container" style="background-color: #fff;width: 100%">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h4 class="titulo-secciones">
            <i class="glyphicon glyphicon-equalizer"></i> Reporte KPI´s Cobranza
        </h4>
      </div>
    </div>
	

<div id="panel">
<?php $this->load->view('reportes/cobranzakpi_panel');?>
</div>

</div>


