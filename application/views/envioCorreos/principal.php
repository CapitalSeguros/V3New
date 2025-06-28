<?php $this->load->view('headers/header'); ?>
<?=$script?>
<section>
	<div class="container">
		<h3>Envio de Correos Masivos...</h3>
        <?
		if($idCorreo != FALSE){
		?>
		<?php foreach ($idCorreo as $correo): ?>
			<div class="row">
				<div class="col-md-1 col-sm-1"><b>Id Email: </b></div>
				<div class="col-md-11 col-sm-11"><?=$correo?></div>
			</div>
		<?php endforeach ?>
        <?
		} else {
		?>
			<div class="row">
				<div class="col-md-1 col-sm-1"></div>
				<div class="col-md-11 col-sm-11">No hay correos pendientes de enviar !!!</div>
			</div>
        <?
		}
		?>
	</div>
</section>
<?php $this->load->view('footers/footer'); ?>