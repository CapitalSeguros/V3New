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
			<form
				class="form-group" role="form"
               	name="NewCorreoImportante" id="NewCorreoImportante" 
				method="post" enctype="multipart/form-data"
				action="<?=base_url()?>actividades/NewCorreoImportante"
			>
	            <button type="submit" class="btn btn-primary btn-sm">Agregar Correo</button>
			</form>
			</div>
		</div>
        
        <div class="row"><!-- -->
        	<div class="col-sm-12 col-md-12">
				<table class="table table-striped table-bordered table-sm">
					<thead>
						<tr scope="row">
                        	<strong>Listado de Envia Correo Actividad Importante</strong>
                        </tr>
						<tr scope="row" bgcolor="#A391C0">
							<th scope="col" ></th>
                            <th scope="col" >Nombre</th>
                            <th scope="col"	>Correo</th>
                        </tr>
                	</thead>
					<tbody>
                    	<?
						foreach($listaCorreos as $correo){
						?>
                        <tr>
                        	<td>
                            	<a
                                	title="Editar"
                                	href="<?=base_url("actividades/editarCorreoImportante/".$correo->idCorreo)?>"
                                >
                                <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                &nbsp;&nbsp;&nbsp;
                            	<a
                                	title="Editar"
                                	href="<?=base_url("actividades/eliminarCorreoImportante/".$correo->idCorreo)?>"
                                >
                                <span class="glyphicon glyphicon-trash"></span>
                                </a>
                                
                            </td>
                        	<td><?=$correo->nombre?></td>
                        	<td><?=$correo->correo?></td>
                        </tr>
                        <?
						}
						?>
					</tbody>
				</table>
			</div>
		</div>

		</div><!-- /panel-body -->
	</div><!-- /panel panel-default -->
</section><!-- /container-fluid -->
<?php $this->load->view('footers/footer'); ?>