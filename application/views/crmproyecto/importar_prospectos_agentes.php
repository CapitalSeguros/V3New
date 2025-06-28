<section class="container-fluid breadcrumb-formularios">
	<br>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="alert alert-info">
				<i class="fa fa-upload"></i>
				<b style="font-size: 14px;">Seleccione Documento Excel (.xls ó .xlsx)</b>
				para realizar importación masiva de los prospectos agentes
			</div>
		</div>	
	</div>
</section>
<form method="post" enctype="multipart/form-data" action="<?php echo base_url()?>crmproyecto/guardar_prospectos_agentes">
<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-4">
     <i class="fa fa-list fa-2x"></i>
    <input type="file" id="lista" name="lista">
  </div>
</div>
<br><br>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-2" style="text-align: left;">
	<input type="submit" name="boton" value="Guardar Prospectos Agentes" class="btn btn-primary btn-md">
</div>
</div>
</form>
<br><br><br>
<div class="row">
	<div class="col-md-6"></div>
	<div class="col-md-6" style="text-align: left;">
<a href="../assets/documentos/layouts_prospectos/prospectos_agentes.xlsx"><i class="fa fa-download"></i>&nbsp;Click para descargar plantilla modelo de Importacion Masiva de prospectos (Agentes)</a>
	</div>
</div>

