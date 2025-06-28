<?php
	$this->load->view('headers/header');
?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12"><b>Estatus: </b><?php echo utf8_decode($poliza->Status_TXT); ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Documento: </b><?php echo utf8_decode($poliza->Documento); ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Desde - Hasta:</b> <?php echo $poliza->FDesde.' - '.$poliza->FHasta; ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Agente: </b><?php echo utf8_decode($poliza->VendNombre); ?></div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12"><b>Aseguradora: </b><?php echo utf8_decode($poliza->CiaNombre); ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Forma Pago: </b><?php echo utf8_decode($poliza->FPago); ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Sub Ramo: </b><?php echo utf8_decode($poliza->SRamoNombre); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>


<?php $this->load->view('footers/footer'); ?>