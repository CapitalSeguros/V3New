<?php
	$this->load->view('headers/header');
?>


<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12"><b>Cliente: </b><?php echo utf8_decode($cliente->NombreCompleto); ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><b>Cliente: </b><?php echo utf8_decode($cliente->Categoria); ?></div>
				</div>
			</div>
			<div class="col-md-6">

				<?//php $dato = explode('*', $cliente->Monedero); ?>
				<div class="row">
					<div class="col-md-12"><?//php echo ($dato[0] != null)? utf8_decode($dato[0]) : ''; ?></div>
				</div>
				<div class="row">
					<div class="col-md-12"><?//php echo ($dato[1] != null)? utf8_decode($dato[1]) : ''; ?></div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php $this->load->view('footers/footer'); ?>