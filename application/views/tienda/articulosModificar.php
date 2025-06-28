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
<style>
header nav ul {
	padding:0;
	margin:0;

	list-style:none;
	color:#FFF;
}

header nav ul li {
	display:inline-block;
	position: relative;
	color:#FFF;
}

header nav ul li:hover {
	background:#563091;
}

header nav ul li a {
	color:#FFF;
	display:block;
	text-decoration:none;
	padding: 5px 5px 5px 35px;
}

header nav ul li a:hover {
	color:#fff;
}

header nav ul li:hover .children {
	display:block;
}

header nav ul li .children {
	display: none;
	background:#472380;
	position: absolute;
	width: 100%;
	z-index:1000;
}

header nav ul li .children li {
	display:block;
	overflow: hidden;	
}

header nav ul li .children li a {
	display: block;
}

@media screen and (max-width: 800px) {
	header nav ul li:hover .children {
		display: none;
	}
 
	header nav ul li .children {
		width: 100%;
		position: relative;
	}
 
	header nav ul li .children li a {
		margin-left:20px;
	}
}
</style>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->

<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Tienda - Modificar Articulos</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="<?=base_url()?>">Inicio</a></li>
				<li><a href="<?=base_url()."tienda"?>">Tienda</a></li>
				<li class="active">Tienda - Modificar Articulos</li>
			</ol>
		</div>
	</div>
	<hr /> 
<!-- Menu de Administracion Tienda -->
<?
	if($moduloConfiguraciones){
?>
	<header>
		<nav class="navbar navbar-default">
			<div class="container-fluid menu-navbar">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarTienda" aria-expanded="false">
                    	<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div id="navbarTienda"  class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="submenu">
							<a href="#">
								<span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-tiendaCategorias.png"></span>
                                Categorias
								<span class="caret"></span>
							</a>
							<ul class="children">
                            	<li>
                                	<a href="<?=base_url()?>tienda/categoriasAgregar" title="Agregar Categorias">
                                    	- Agregar
                                    </a>
                                </li>
                            	<li>
                                	<a href="<?=base_url()?>tienda/categoriasModificar" title="Modificar Categorias">
                                    	- Modificar
                                    </a>
								</li>
							</ul>
                        </li>
                        <li class="submenu">
							<a href="#">
								<span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-tiendaArticulos.png"></span>
                                Articulos
								<span class="caret"></span>
							</a>
                            <ul class="children">
                            	<li>
                                	<a href="<?=base_url()?>tienda/articulosAgregar" title="Agregar Articulos">
                                    	- Agregar
                                    </a>
                                </li>
                            	<li>
                                	<a href="<?=base_url()?>tienda/articulosModificar" title="Modificar Articulos">
                                    	- Modificar
                                    </a>
								</li>
							</ul>
                        </li>
                        <li>
                            <a href="<?=base_url()?>tienda/pedidosSurtir" title="Surtir Pedidos">
                            	<span><image src="<?php echo base_url(); ?>assets/images/icons-menu/icon-tiendaSurtir.png"></span>
                                Surtir Pedidos
							</a>
                        </li>
                    </ul>
				</div>
			</div>
		</nav>
	</header>
    <br />
<?
	}
?>
<!-- !Menu de Administracion Tienda -->
<?php $this->load->view('tienda/tiendaestatus',$tiendaestatus); ?>
</section>

<section class="page-section">
	<div class="container">
    	<div class="row">
			<div class="col-sm-12 col-md-12">
            	<span style="font-size:22px; text-decoration:underline; font-weight:bold;">
					Listado de Articulos
                </span>
                <br /><br />
            </div>
		</div>
        
		<!--
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
        -->

        <?php
			foreach ($ListaCategoriasTienda->result() as $row){
		?>
		<div class="row">
			<div class="col-sm-12 col-md-12">
            	<span style="font-size:18px;">
                	<?="<b>Categoria:</b> ".urldecode($row->nombre)?>
                </span>
            </div>
        </div>
		<hr style="border:dotted 1px #CCC;" />
        <!-- -->
		<div class="row">
			<div class="col-sm-12 col-md-12">
            	<div class="row">
                	<div class="col-sm-1 col-md-1">
                    </div>
                	<div class="col-sm-8 col-md-8">
						<b>Nombre</b>
                    </div>
                	<div class="col-sm-1 col-md-1">
                    	<b>Puntos</b>
                    </div>
                	<div class="col-sm-1 col-md-1">
                    	<b>Precio</b>
                    </div>
                	<div class="col-sm-1 col-md-1">
						<b>Acciones</b>
                    </div>
                </div>
            </div>
		</div>
        <!-- -->
        <?php
			$ListaArticulosTienda = $this->capsysdre_tienda->ListaArticulosTienda($row->idCategoria);
			foreach($ListaArticulosTienda->result() as $rowArticulos){
		?>
		<div class="row">
			<div class="col-sm-12 col-md-12">
            	<div class="row">
                	<div class="col-sm-1 col-md-1">
                    </div>
                	<div class="col-sm-8 col-md-8">
						<?=urldecode($rowArticulos->nombre)?>
                    </div>
                    <div class="col-sm-1 col-md-1">
						<?=$rowArticulos->puntos?>
                    </div>
                	<div class="col-sm-1 col-md-1">
						<?=$rowArticulos->precio?>
                    </div>
                	<div class="col-sm-1 col-md-1">
		            	<a href="<?=base_url()."tienda/articulosEditar?idArticulo=".$rowArticulos->idArticulo?>" title="Editar">
    		            	<span class="glyphicon glyphicon-pencil"></span>
        		        </a>
            			<a href="<?=base_url()."tienda/BorrarArticulo?idArticulo=".$rowArticulos->idArticulo?>" title="Eliminar">
                			<span class="glyphicon glyphicon-remove"></span>
	                	</a>
                    </div>
                </div>
            </div>
		</div>
        <?php
			}
		?>
		<?php
			} /*! foreach */
		?>
	</div>            
</section>
<script>
$(document).ready(main);
 
var contador = 1;
 
function main () {
	$('.menu_bar').click(function(){
		if (contador == 1) {
			$('nav').animate({
				left: '0'
			});
			contador = 0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		}
	});
 
	// Mostramos y ocultamos submenus
	$('.submenu').click(function(){
		$(this).children('.children').slideToggle();
	});
}
</script>
<?php $this->load->view('footers/footer'); ?>