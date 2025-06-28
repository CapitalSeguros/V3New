<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
				<div class="col-md-6 col-sm-5 col-xs-5">
					<h3 class="titulo-secciones">Video Tutoriales del V3 Plus</h3>
				</div>

		</div>
	</section>
	<h5 class="titulo-secciones">Para ver el video ha click en play, y para ver pantalla completa haz click en el cuadrito junto al contro de volumen del video</h5>
	<section>
	<video width="400" height="300"  controls>
      <source src="<?php echo base_url(); ?>assets/videotutoriales/Video1.mp4" type="video/mp4">
    </video>
    </section>	

<?php $this->load->view('footers/footer'); ?>