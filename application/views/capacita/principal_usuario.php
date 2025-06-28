<?php 
	$this->load->view('headers/header'); 
  	$this->load->view('capacita/menu_usuario'); 
?>
<!-- Navbar -->
<?php
	//$this->load->view('headers/menu');
?>
<section class="page-section">
	<div class="container">

		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
							<li data-target="#myCarousel" data-slide-to="1"></li>
							<li data-target="#myCarousel" data-slide-to="2"></li>
							<li data-target="#myCarousel" data-slide-to="3"></li>
						</ol>
					<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>

							<div class="item">
								<img 
                                	src="<?=base_url()?>/assets/img/capacita/slideShow/actualizaciones.png"
                                    width="100%"
                                    alt="Actualizaciones"
								>
							</div>
						</div>

					<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
				</div>
			</div>
        </div>
	</div>            
</section>
<?php $this->load->view('footers/footer'); ?>