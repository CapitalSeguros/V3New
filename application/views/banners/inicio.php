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
        	name="formBanner01" id="formBanner01"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>LightBox Inicio</strong>
                <br /><br />
                <strong>Ancho:</strong> 1882 px
                <br />
                <strong>Alto:</strong> 811 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/imgBanner/nuestrosagentes1.png" width="470px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/imgBanner/nuestrosagentes1.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner01.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 01 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner02" id="formBanner02"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 1</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/02.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/02.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner02.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 02 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner03" id="formBanner03"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 2</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/03.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/03.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner03.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 03 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner04" id="formBanner04"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 3</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/04.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/04.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner04.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 04 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner05" id="formBanner05"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 4</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/05.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/05.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner05.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 05 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner06" id="formBanner06"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 5</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/06.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/06.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner06.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 06 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner07" id="formBanner07"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 6</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/07.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/07.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner07.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 07 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner08" id="formBanner08"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 7</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/08.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/08.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner08.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 08 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner09" id="formBanner09"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Slideshow Inicio 8</strong>
                <br /><br />
                <strong>Ancho:</strong> 1000 px
                <br />
                <strong>Alto:</strong> 500 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/img/inicio/slideShow/09.png" width="500px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/img/inicio/slideShow/09.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner09.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>

<!-- # 09 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner10" id="formBanner10"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Marquesina Banner 1</strong>
                <br /><br />
                <strong>Ancho:</strong> 1366 px
                <br />
                <strong>Alto:</strong> 100 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/imgBanner/B1/F-1366x100.png" width="341px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/imgBanner/B1/F-1366x100.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner10.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 10 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner11" id="formBanner11"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Marquesina Banner 2</strong>
                <br /><br />
                <strong>Ancho:</strong> 1366 px
                <br />
                <strong>Alto:</strong> 100 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/imgBanner/B2/F-1366x100.png" width="341px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/imgBanner/B2/F-1366x100.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner11.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 11 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner12" id="formBanner12"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Marquesina Banner 3</strong>
                <br /><br />
                <strong>Ancho:</strong> 1366 px
                <br />
                <strong>Alto:</strong> 100 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/imgBanner/B3/F-1366x100.png" width="341px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/imgBanner/B3/F-1366x100.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner12.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- # 12 # -->
		<form
        	class="form-group" role="form"
        	name="formBanner13" id="formBanner13"
            method="post" enctype="multipart/form-data"
            action="<?=base_url();?>banners/EdicionBanner" 
        >
		<div class="row">
			<div class="col-md-2 col-sm-2">
            	<strong>Marquesina Banner 4</strong>
                <br /><br />
                <strong>Ancho:</strong> 1366 px
                <br />
                <strong>Alto:</strong> 100 px
                <br /><br />
                Formato PNG de 32 Bits
            </div>
			<div class="col-md-10 col-sm-10">
            	<center>
            	<img src="<?=base_url()?>assets/imgBanner/B4/F-1366x100.png" width="341px" />
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
                    name="idRutaNombre" id="idRutaNombre"
                    value="assets/imgBanner/B4/F-1366x100.png"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formBanner13.submit();"
				/>
            </div>
        </div>
        </form>

		<div class="row">
        	<br />
	        <hr/>
		</div>
<!-- ## -->
        
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