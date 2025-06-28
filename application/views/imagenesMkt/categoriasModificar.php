<?php
	$corte = 0;
	$columnas = 3;
	
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
				<li><a href="<?=base_url()."imagenesMkt"?>">Repositorio imagenes</a></li>
                <li class="active">Repositorio imagenes - Modificar Categor&iacute;as</li>
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

<section class="page-section">
	<div class="container">
    	<div class="row">
			<div class="col-sm-12 col-md-12">
            	<span style="font-size:22px; text-decoration:underline; font-weight:bold;">
					Listado de Categor&iacute;as
                </span>
                <br /><br />
            </div>
		</div>

    	<div class="row">
			<div class="col-sm-10 col-md-10">
            	<b>Nombre</b>
            </div>
			<div class="col-sm-10 col-md-1">
            	<b>Imagen</b>
            </div>
			<div class="col-sm-10 col-md-1">
            	<b>Acciones</b>
            </div>
        </div>
		<hr />
        <?php
			foreach ($ListaCategoriasImagenes->result() as $row){
		?>
		<div class="row">
			<div class="col-sm-10 col-md-10">
                <?="&bull; ".urldecode($row->nombre)?>
            </div>
			<div class="col-sm-1 col-md-1">
				<img  class="img-fluid" src="<?=base_url()."assets/img/imagenesMkt/categorias/".$row->img_link?>" />
            </div>
			<div class="col-sm-1 col-md-1" style="text-align:center;">
            	<a href="<?=base_url()."imagenesMkt/categoriasEditar?idCategoria=".$row->idCategoria?>" title="Editar">
                	<span class="glyphicon glyphicon-pencil"></span>
                </a>
            	<a href="<?=base_url()."imagenesMkt/BorrarCategoria?idCategoria=".$row->idCategoria?>" title="Eliminar">
                	<span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
        </div>
		<hr style="border:dotted 1px #CCC;" />
		<?php
			} /*! foreach */
		?>
	</div>            
</section>