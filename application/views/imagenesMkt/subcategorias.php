
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<style>
	.submenu a:hover{
		background-color: #472380 !important;
		color: white;
	}
	.efect:hover{
		cursor: pointer;
		transform: scale(1.1);
		transition: 1s;
	}
</style>
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Imagenes</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li><a href="<?php echo base_url(); ?>imagenesMkt">Repositorio imagenes</a></li>
				<li><a href="<?=base_url()."imagenesMkt/areas?idCategoria=".$idCategoria?>">Areas</a></li>
				<li class="active">Subcategorias</li>
			</ol>
		</div>
	</div>
	<hr /> 

</section>
<section class="page-section" style="padding-top: 2%;">
	<div class="container justify-content-center">

        
        <div class="row">
        	<?php
				foreach ($ListaSubcategoriasImagenes->result() as $row){
					if($idArea!=5){
						if($row->idSubcategoria!=3){

        	?>
			<div class="col-sm-4 col-md-4">
            	<center>
                <a
                	href="<?=base_url()."imagenesMkt/categoria?idCategoria=".$idCategoria."&idArea=".$idArea."&idSubcategoria=".$row->idSubcategoria?>"
                    title="<?=urldecode($row->nombre)?>"
                >
				<img class="img-fluid efect" src="<?=base_url()."assets/img/imagenesMkt/subcategorias/".$row->img_link?>"  />
                </a>
                </center>
                <br />
            </div>
			<?php

				}}else{
					if($idArea==5){
						if($row->idSubcategoria==1 || $row->idSubcategoria==3){
							?>
			<div class="col-sm-4 col-md-4">
            	<center>
                <a
                	href="<?=base_url()."imagenesMkt/categoria?idCategoria=".$idCategoria."&idArea=".$idArea."&idSubcategoria=".$row->idSubcategoria?>"
                    title="<?=urldecode($row->nombre)?>"
                >
				<img class="img-fluid efect" src="<?=base_url()."assets/img/imagenesMkt/subcategorias/".$row->img_link?>"  />
                </a>
                </center>
                <br />
            </div>


							<?php
						}
					}
				}} /*! foreach */
			?>
        </div>
        
	</div>            
</section>