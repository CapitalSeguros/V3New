<?php 
	$this->load->view('headers/header'); 
?>
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5">
			<h3 class="titulo-secciones">Banners</h3>
		</div>
		<div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
				<li><a href="../">Inicio</a></li>
				<li class="active">Banners</li>
			</ol>
		</div>
	</div>
	<hr />         
</section>
<section class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12" align="right">
            <form
				class="form-group" role="form"
                name="NewBannerSlide" id="NewBannerSlide"
                method="post" enctype="multipart/form-data"
				action="<?=base_url();?>banners/NewBannerMicrositio" 
            >
                <button type="submit" class="btn btn-primary btn-sm">Agregar Nuevo Banner</button>
			</form>
            </div>
		</div>
        <br /><br />

<?
	$sqlBannersMicrosi = "
		Select * From
			`banners_micrositios`
		Where
			1
		Order By
			`orden` Asc
					  ";
	$queryBannersMicrosi = $this->db->query($sqlBannersMicrosi);

	foreach($queryBannersMicrosi->result() as $banner){
		//echo "<pre>";
			//print_r($slide);
		//echo "</pre>";
		
		switch($banner->ramo){
			default:
				$nombreRamo	= "";
			break;
			
			case "Lp":
				$nombreRamo	= "Lineas Personales";
			break;
			
			case "Vi":
				$nombreRamo	= "Vida";
			break;
			
			case "Da":
				$nombreRamo	= "Daños";
			break;
			
			case "Fi":
				$nombreRamo	= "Fianzas";
			break;
			
			case "Ve":
				$nombreRamo	= "Vehiculos";
			break;
		}
?>
<!-- # 00 # -->
		<div class="row">
			<div class="col-md-2 col-sm-2">
                <br />
                <strong>Nombre:</strong> <i><?=$banner->nombre?></i>
                <br />
                <strong>Ramo:</strong> <i><?=$nombreRamo?></i>
                <br />
                <strong>Ancho:</strong> 800 px
                <br />
                <strong>Alto:</strong> 800 px
                <br /><br />
                Formato PNG de 32 Bits
                <br /><br />
				
                <a
                	href="<?= base_url("banners/editarMicrositios")."/".$banner->id?>"
                    title="Editar Slide" 
                ><span class="glyphicon glyphicon-pencil"></span></a>
				
                &nbsp;&nbsp;&nbsp;
				
                <a
                	href="<?= base_url("banners/eliminarMicrositios")."/".$banner->id?>"
                    title="Eliminar Slide" 
                ><span class="glyphicon glyphicon-trash"></span></a>
                
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url("assets/img/banners/micrositios")."/".$banner->img?>" width="400px" />
                </center>
			</div>
		</div>
        
        <br />
		
        <div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 00 # -->
<?
	}
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