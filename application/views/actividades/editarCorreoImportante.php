<?
?>
<script>
</script>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li class="active">Actividades</li>
            </ol>
        </div>
    </div>
</section>

<section class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

		<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
			<div class="col-sm-12 col-md-12" align="right">
			</div>
		</div>
        
	<form
    	class="form-group" role="form"
        name="formCorreo" id="formCorreo"
        method="post" enctype="multipart/form-data"
	    action="<?=base_url()?>actividades/GuardarCorreoImportante" 
	>
        <div class="row"><!-- -->
        	<div class="col-sm-2 col-md-2">
            	Nombre:
            </div>
        	<div class="col-sm-10 col-md-10">
            	<input
            		type="text"
					name="nombre" id="nombre"
                    value="<?=$correo_info[0]->nombre?>"
					class="form-control input-sm"
    	        />
            </div>
		</div>
<br />
        <div class="row"><!-- -->
        	<div class="col-sm-2 col-md-2">
            	Correo:
            </div>
        	<div class="col-sm-10 col-md-10">
            	<input
            		type="text"
					name="correo" id="correo"
                    value="<?=$correo_info[0]->correo?>"
					class="form-control input-sm"
    	        />
            </div>
		</div>
<br />
        <div class="row"><!-- -->
        	<div class="col-sm-12 col-md-12" align="right">
            	<input
                	type="hidden"
                    name="idCorreo" id="idCorreo"
                    value="<?=$correo_info[0]->idCorreo?>"
                />
				<input 
                	type="button"
                    value="Guardar" class="btn btn-primary btn-sm"
					onclick="document.formCorreo.submit();"
				/>
            </div>
		</div>
    </form>
		</div><!-- /panel-body -->
	</div><!-- /panel panel-default -->
</section><!-- /container-fluid -->
<?php $this->load->view('footers/footer'); ?>