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
<?
	$sqlBanners = "
		Select * From 
			`banners`
		Where
			1
		Order By
			`id` Asc
				  ";
	$queryBanners = $this->db->query($sqlBanners);
	foreach($queryBanners->result() as $banners){
		//echo "<pre>";
			//print_r($banners);
		//echo "</pre>";
?>    
<!-- # 00 # -->    
		<form
        	class="form-group" role="form"
        	name="<?="formBanner_".$banners->id;?>" id="<?="formBanner_".$banners->id;?>"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
        <input type="hidden" name="linkRedirect" id="linkRedirect" value="fijos" />
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong><?= $banners->nombre; ?></strong>
                <br /><br />
                <strong>Ancho: </strong> <?= $banners->ancho; ?>
                <br />
                <strong>Alto: </strong> <?= $banners->alto; ?>
                <br /><br />
                <?= $banners->texto; ?>
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?= base_url("".$banners->directorio."")."/".$banners->img; ?>" width="470px" />
                </center>
			</div>
		</div>
        <br />
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
                    name="id" id="id"
                    value="<?=$banners->id?>"
                />
            	<input
                	type="hidden"
                    name="directorio" id="directorio"
                    value="<?=$banners->directorio?>"
                />
            	<input
                	type="hidden"
                    name="img" id="img"
                    value="<?=$banners->img?>"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.<?="formBanner_".$banners->id;?>.submit();"
				/>
            </div>
        </div>
        </form>

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