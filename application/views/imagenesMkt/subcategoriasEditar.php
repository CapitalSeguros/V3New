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
                <li><a href="<?=base_url()."imagenesMkt/subcategoriasModificar"?>">Repositorio imagenes - Modificar subcategor&iacute;as</a></li>
                <li class="active">Repositorio imagenes - Editar subcategor&iacute;as</li>
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
					Edici&oacute;n
                </span>
                <br /><br />
            </div>
		</div>
		<hr />
		<form
        	class="form-group" role="form"
        	name="formEdicionSubcategoria" id="formEdicionSubcategoria"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>imagenesMkt/EdicionSubcategoria" 
        >
		<div class="row">
			<div class="col-sm-3 col-md-3">
            	<label><b>Nombre:</b></label>
                <br />
                <input 
                	type="text" class="form-control input-sm"
                    name="nombre" id="nombre" 
                    placeholder="Nombre" required="required"
                    value="<?=urldecode($ListaSubcategoriasImagenes[0]->nombre)?>"
                />
            </div>
             <div class="col-sm-3 col-md-3">
            <label><b>Categoria:</b></label>
                <br />
                <select
                    class="form-control input-sm"
                    name="idCategoria" id="idCategoria"
                >
                    <?
                        //$this->capsysdre_tienda->EditarCategoriaTienda($EditarArticulosTienda[0]->idCategoria);
                        $sqlListaCategorias = "
                            Select * From 
                                `imagenesMkt_categorias`
                            Where
                                1
                                              ";
                        $query = $this->db->query($sqlListaCategorias);
                        foreach($query->result() as $categoria){
                            if($categoria->idCategoria == $ListaSubcategoriasImagenes[0]->idCategoria){
                                $selectec = 'selected="selected"';
                            } else {
                                $selectec = '';
                            }
                    ?>
                    <option value="<?=$categoria->idCategoria?>" <?=$selectec?>><?=urldecode($categoria->nombre)?></option>
                    <?
                        }
                    ?>
                </select>
            </div>
			<div class="col-sm-1 col-md-1">
            	<label><b>Posici&oacute;n:</b></label>
                <br />
                <input 
                	type="text" class="form-control input-sm"
                    name="posicion" id="posicion"
                    placeholder="Posici&oacute;n" required="required"
                    value="<?=$ListaSubcategoriasImagenes[0]->posicion?>"
                />
            </div>
			<div class="col-sm-5 col-md-5">
				<img  class="img-fluid" src="<?=base_url()."assets/img/imagenesMkt/subcategorias/".$ListaSubcategoriasImagenes[0]->img_link?>" />
            	<input
            		type="file"
					name="imgSubcategoria" id="imgSubcategoria"
					class="form-control input-sm"
    	        />
            </div>
            <div class="col-sm-1 col-md-1">
            	<input
                	type="hidden"
                    name="idSubcategoria" id="idSubcategoria"
                    value="<?=$ListaSubcategoriasImagenes[0]->idSubcategoria?>"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formEdicionSubcategoria.submit();"
				/>
                <!--
                <input
                	type="submit" 
                    value="Enviar Documento" class="btn btn-primary btn-sm"
					onclick="document.formEdicionCategoria.submit();"
                />
                -->
            </div>
        </div>
        </form>
	</div>            
</section>