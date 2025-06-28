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

<!-- # 00 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner" id="formBanner"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>banners/GuardarBannerMicrositios" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
				<br />
                <strong>Nombre:</strong>
                <input
                	type="text" class="form-control input-sm"
                    name="nombreBanner" id="nombreBanner"                    
                    placeholder="Nombre Slide" title="Nombre de la Imagen"
                    value="<?= $banner_info[0]->nombre; ?>"
                />
                <br />
                <strong>Ramo:</strong>
            	<select class="form-control input-sm" name="ramoBanner" id="ramoBanner">
                	<option value="Lp" <?= ($banner_info[0]->nombre == "Lp")?  "selected" : "";?>>Lineas Personales</option>
                	<option value="Vi" <?= ($banner_info[0]->nombre == "Vi")?  "selected" : "";?>>Vida</option>
                	<option value="Da" <?= ($banner_info[0]->nombre == "Da")?  "selected" : "";?>>Daños</option>
                	<option value="Fi" <?= ($banner_info[0]->nombre == "Fi")?  "selected" : "";?>>Fianzas</option>
                	<option value="Ve" <?= ($banner_info[0]->nombre == "Ve")?  "selected" : "";?>>Vehiculos</option>
                    
                </select>
                <br />
            <!--
Lineas Personales	Lp
Vida				Vi
Daños				Da
Fianzas				Fi
Vehiculos			Ve
            -->
                <strong>Ancho:</strong> 800 px
                <br />
                <strong>Alto:</strong> 800 px
                <br /><br />
                Formato PNG de 32 Bits
                <br /><br />
                
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url("assets/img/banners/micrositios")."/".$banner_info[0]->img; ?>" width="470px" />
                </center>
                <br /><br />
			</div>
		</div>
        <div class="row">
			<div class="col-md-10 col-sm-10">
            	<input
            		type="file"
					name="imgBanner" id="imgBanner"
					class="form-control input-sm"
    	        />
            </div>
			<div class="col-md-2 col-sm-2">
            	<input
                	type="hidden"
                    name="idBanner" id="idBanner"
                    value="<?= $banner_info[0]->id?>"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner.submit();"
				/>
            </div>
        </div>

        <div class="row">
        	<br />
	        <hr/>
		</div>
		</form>
<!-- # 00 # -->

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