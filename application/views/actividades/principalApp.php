<?
	$moduloConfiguraciones	= "";
	$nubeVehiculos			= "";
	$nubeDanos				= "";
	$nubeLineas				= "";
/*
	foreach($configModulos as $modulos){
		//var_dump($modulos);
		if($modulos['modulo'] == "configuraciones"){ $moduloConfiguraciones.= TRUE; } else { $moduloConfiguraciones.= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeVEHICULOS"){ $nubeVehiculos .= TRUE; } else { $nubeVehiculos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeDANOS"){ $nubeDanos .= TRUE; } else { $nubeDanos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeLINEAS"){ $nubeLineas .= TRUE; } else { $nubeLineas .= FALSE; }
		
	}
*/
?>
<!DOCTYPE html>
<html lang="es">
<script>
function seleccionar_todo(nombreFormulario){ 
	var f = document.forms[nombreFormulario.name];
	for (i=0;i<f.elements.length;i++) 
		if(f.elements[i].type == "checkbox")	
			f.elements[i].checked=1
}

function deseleccionar_todo(nombreFormulario){
	var f = document.forms[nombreFormulario.name];
	for(i=0;i<f.elements.length;i++)
		if(f.elements[i].type == "checkbox")
			f.elements[i].checked=0 
}

function todas(nombreFormulario, tipoTodas){
	var f = document.forms[nombreFormulario.name];
	f.tipo.value = tipoTodas;
		
		f.submit();
}
</script>
<? $this->load->view("headers/app/main_header") ?>

<body>
<!-- Page container -->
<div class="page-container">

	<? $this->load->view("headers/app/page_sidebar") ?>
  
	<!-- Main container -->
	<div class="main-container gray-bg">
  
		<!-- Main header -->
		<div class="main-header row">
			<div class="col-sm-6 col-xs-7">
			<? $this->load->view("headers/app/user_info") ?>
			</div>
			
			<div class="col-sm-6 col-xs-5">
			<div class="pull-right">
			<? $this->load->view("headers/app/user_alerts") ?>
			</div>
			</div>
		</div>
		<!-- /main header -->
		
		<!-- Main content -->
		<div class="main-content">
        
			<h1 class="page-title">Actividades</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?= base_url();?>"><i class="fa fa-home"></i>Home</a></li> 
				<li>Actividades</li>
				<li class="active"><strong>Consultar</strong></li>
			</ol>
			<hr />
			<a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores" target="_blank"><b>Cotizadores</b></a>
			<hr />

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
								<div class="col-sm-12 col-md-12" align="right">
									<input
										type="button" value="Actualizar Actividad"
										title="Actualizar Actividad - Clic Aqu&iacute;"                                               
										onclick="window.open('actualizaActividades/actualizaactividadesporvendedor','_self');"
										class="btn btn-primary btn-sm"
									/>
								</div>
							</div>

							<div class="row"><!-- Buscador de Folio -->
								<div class="col-sm-12 col-md-12" align="right">
									<form
										class="form-horizontal" role="form"
										id="formActividadBuscarFolio" name="formActividadBuscarFolio"
										method="post" enctype="multipart/form-data"
										action="<?=base_url()?>actividades/busqueda"
									>
									<div class="input-group" style="width:50%;">
										<input
											id="folioBuscado" name="folioBuscado" 
											type="text" class="form-control input-sm"
											placeholder="Buscar Folio"
										>
										<span class="input-group-btn">
											<button class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
										</span>
									</div>
									<input
										type="hidden"
										id="usuarioCreacion" name="usuarioCreacion"
										value="<?=$this->tank_auth->get_usermail()?>"
									/>
									</form>
								</div>
							</div>
						</div><!-- /panel-heading -->

						<!-- panel body -->
						<div class="panel-body">
							<div class="tab-content">
                            </div>
						</div>
					</div>
                        
				</div>
			</div>
            
		<? $this->load->view("footers/app/div_footer-main") ?>
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<? $this->load->view("footers/app/main_footer") ?>

</body>
</html>