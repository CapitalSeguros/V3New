<?php
	 $this->load->model('catalogos_kpi');
	 $row=$this->catalogos_kpi->get_indicadores();
	 foreach ($row as $r) {
	 	$pco=$r->pco;
	 	$dc=$r->dc;
	 	$df=$r->df;
	 }
?>
<form name="frm" method="post" action="<?php echo base_url()?>cobranza/kpi_indicadores">
<div class="well" style="margin-right: 4%;">
<section>
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>% POLIZAS CANCELADAS DE ORIGEN (P.C.O.)</label>
		</div>
		<div class="col-md-3 col-sm-3">
			<input type="text" name="pco" id="pco" class="form-control" value="<?php echo $pco;?>"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>% DESCUENTO POR COMPETENCIA</label>
		</div>
		<div class="col-md-3 col-sm-3">
			<input type="text" name="dc" id="dc" class="form-control" value="<?php echo $dc;?>"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-sm-4">
			<label>% DIFERIMEINTO DE PAGOS</label>
		</div>
		<div class="col-md-3 col-sm-3">
			<input type="text" name="df" id="df" class="form-control" value="<?php echo $df;?>"/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-sm-6">
			<input type="submit"  value="Guardar" class="btn btn-primary btn-sm" style="font-size: 10px;">
		</div>
	</div>
</section>
</div>
</form>
