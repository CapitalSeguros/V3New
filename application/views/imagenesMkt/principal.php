<?php

	
	$moduloConfiguraciones = "";
	foreach($configModulos as $modulos){
		if($modulos['modulo'] == "tienda" && $modulos['subModulo'] == "surtirPedidos"){ 
			$moduloConfiguraciones.= TRUE;
		} else { 
			$moduloConfiguraciones.= FALSE;
		}
	}
?>
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
</style>
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Imagenes</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="./">Inicio</a></li>
				<li class="active">Repositorio imagenes</li>
			</ol>
		</div>
	</div>
	<hr /> 
<!-- Menu de Administracion Tienda -->
<?
	if($moduloConfiguraciones){
?>
	<header>
		<nav class="navbar navbar-expand-md navbar-default" style="z-index: 1 !important;">
			<div class="container-fluid menu-navbar">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarImagenes" aria-expanded="false">
                    	<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbarImagenes"  class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="nav-item dropdown" >
					        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
					          <i class="fa fa-picture-o" aria-hidden="true"></i> Categorias <span class="caret"></span>
					        </a>
					        <div class="dropdown-menu submenu">
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/categoriasAgregar">- Agregar</a>
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/categoriasModificar">- Modificar</a>					    
					        </div>
					     </li>
					     <li class="nav-item dropdown" >
					        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
					          <i class="fa fa-picture-o" aria-hidden="true"></i> Áreas <span class="caret"></span>
					        </a>
					        <div class="dropdown-menu submenu">
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/areasAgregar">- Agregar</a>
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/areasModificar">- Modificar</a>					    
					        </div>
					     </li>
					     <li class="nav-item dropdown" >
					        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
					          <i class="fa fa-picture-o" aria-hidden="true"></i> Subcategoria <span class="caret"></span>
					        </a>
					        <div class="dropdown-menu submenu">
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/subcategoriasAgregar">- Agregar</a>
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/subcategoriasModificar">- Modificar</a>					    
					        </div>
					     </li>
					      <li class="nav-item dropdown">
					        <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-expanded="false" style="padding: 10px 15px;">
					          <i class="fa fa-picture-o" aria-hidden="true"></i> Imagenes <span class="caret"></span>
					        </a>
					        <div class="dropdown-menu submenu">
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/imagenesAgregar">- Agregar</a>
					          <a class="dropdown-item" href="<?=base_url()?>imagenesMkt/imagenesModificar">- Modificar</a>	
					      </li>
                    </ul>
				</div>
			</div>
		</nav>
	</header>

		<?
			}
		?>

</section>
<section class="page-section" style="padding-top: 2%;">
	<div class="container justify-content-center">

        
        <div class="row">
        	<?php
				foreach ($ListaCategoriasImagenes->result() as $row){
					if($row->idCategoria==1){
							$url=base_url()."imagenesMkt/areas?idCategoria=".$row->idCategoria;
						}else{
							if($row->idCategoria==2){
								$url=base_url()."imagenesMkt/subcategoriaFirmas?idCategoria=".$row->idCategoria;
							}else{$url=base_url()."imagenesMkt/general?idCategoria=".$row->idCategoria;}}


        	?>
			<div class="col-sm-4 col-md-4">
            	<center>
                <a
                	href="<?= $url?>"
                    title="<?="Categoria ".urldecode($row->nombre)?>"
                >
				<img class="img-fluid" src="<?=base_url()."assets/img/imagenesMkt/categorias/".$row->img_link?>"  />
                </a>
                </center>
                <br />
            </div>
			<?php

				} /*! foreach */
			?>
        </div>
        
	</div>            
</section>