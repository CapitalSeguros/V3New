<?php 
	
	$optionMonths = "";
	foreach($months as $n => $name){
		$disabled = $n > date("n") ? "disabled" : "";
		$optionMonths .= "<option value=".$n." ".$disabled.">".$name."</option>";
	}

	$years = array_reduce(array(0, 1, 2, 3, 4), function($acc, $curr){

		$value = date("Y") - $curr;
		$acc .= '<option value="'.$value.'">'.$value.'</option>';

		return $acc;
	}, "") ;

?>

<!-- Navbar -->
<style type="text/css">	
	#Nav-Tab-KPI.nav-tabs {
		border-bottom: 1px solid #ddd;
		background: transparent;
		width: 100%;
	}
	#Nav-Tab-KPI.nav-tabs > li {
		margin-bottom: -1px;
	}
	#Nav-Tab-KPI.nav-tabs>li>a.active, #Nav-Tab-KPI.nav-tabs>li>a.active:focus, #Nav-Tab-KPI.nav-tabs>li>a.active:hover {
    	color: #8370A1;
    	cursor: default;
    	background-color: #fff;
    	border: 1px solid #ddd;
    	border-bottom-color: transparent;
    	cursor: pointer;
    }
    #Nav-Tab-KPI.nav-tabs>li>a {
    	margin-right: 2px;
    	line-height: 1.42857143;
    	border: 1px solid transparent;
    	border-radius: 4px 4px 0 0;
    	color: #555;
    }
    #Nav-Tab-KPI.nav-tabs>li>a:hover {
    	background: #8370A1;
    	color: white;
    }
    #Nav-Tab-KPI.nav-tabs>li {
	    float: left;
	    margin-bottom: -1px;
	}
	#pills-kpi-o > li > a {
		border: 1px solid #c5dcf3;
    	background: #dfeaf5;
    	color: #3d3d3d;
	}
	#pills-kpi-o > li.active > a {
		border: 1px solid #3392b8;
    	background: #3392b8;
    	color: white;
	}
	#tableKPICobranza,
	#tableKPIComercial,
	#tableKPIProspeccion,
	#tableKPIEjecutivo1,
	#tableKPIEjecutivo2,
	#tableKPIEjecutivo3 { 
		border: 1px solid #ddd;
	}
	.bg-tab-content-poliza {
		padding-left: 10px;
		padding-right: 10px;
		background: white;
		padding-top: 10px;
		display: flex;
		justify-content: center;
		margin-bottom: 20px;
		border-left: 1px solid #ddd;
    	border-right: 1px solid #ddd;
    	border-bottom: 1px solid #ddd;
	}
	.bg-tab-content-kpi-operativo {
		padding-left: 10px;
		padding-right: 10px;
		background: white;
		padding-top: 10px;
		display: flex;
		justify-content: center;
		margin-bottom: 20px;
	}
	.diax{
		font-size: 11px;
		font-weight: bold; 
	}
	.img-profile {
		width: 80px;
    	border-radius: 100px;
    	/* border: 1px solid #375a7c; */
    	box-shadow: 0px 0px 3px 3px #7570a152;
	}
	.btn-profile {
		color: white;
    	background: #266093;
    	border: 1px solid #266093;
    	border-radius: 2px;
    	cursor: pointer;
    	outline: none;
    	padding: 5px 8px;
    	margin: 0px 5px;
    	transition: 0.3s;
	}
  	.btn-profile:hover {
  	  	color: white;
  	  	background: #337ab7;
  	  	border-color: #337ab7;
  	  	transition: 0.3s;
  	}
  	.table-width {
  		overflow: auto;
    	max-width: 1060px;
  	}
  	.container-table-fastfile {
  		height: 350px;
  		overflow: auto;
  		border: 1px solid #ddd;
  	}
  	.container-section-title {
  		background-color: #7598bf;
    	color: #fff;
  	}
  	.container-section-title > label {
  		text-align: center;
    	font-weight: 600;
    	font-size: 12px;
    	width: 100%;
    	margin: 4px;
  	}
  	.container-spinner-load-kpi {
  		position: absolute;
  		width: -webkit-fill-available;
    	height: -webkit-fill-available;
  	}
  	.border-lr {
  		border: 1px solid #ddd;
    	border-top: none;
    	border-bottom: none;
  	}
  	.tr-cobranza {
  		text-align: center;
    	background: #f1f1f1;
    	color: #3d3d3d;
    	font-size: 11.5px;
  	}
  	.tr-total {
  		background-color: #ABD4DE;
  	}
  	.td-effected {
  		background-color: #9abcd9;
  	}
  	.td-ontime {
  		background-color: #b1e3b1;
  	}
  	.td-peding {
  		background-color: #f3cc96;
  	}
  	.td-late {
  		background-color: #ef8a87;
  	}
  	tbody > tr.tr-total > td, tbody > tr > td.tr-total {
  		border-top: 1px solid #ffffff;
  	}
  	th > span.label-primary,
  	th > span.label-success,
  	th > span.label-warning,
  	th > span.label-danger {
  		padding: 4px 6px;
    	border-radius: 3px
  	}
  	.label-success, .label-warning { color: black; }
  	.semaphore-green {color: green;}
  	.semaphore-yellow {color: #f7a200;}
  	.semaphore-red {color: red;}
  	.cont-semaphore-green {background: green;padding: 5px;border-radius: 25%;}
  	.cont-semaphore-yellow {background: #eb9d09;padding: 5px;border-radius: 25%;}
  	.cont-semaphore-red {background: red;padding: 5px;border-radius: 25%;}
  	/*Media Query*/
  	@media (max-width: 1440px) {
  	    .table-width { max-width: 1220px; }
  	    .table-width3 { max-width: 1220px; }
  	}
  	@media (max-width: 1280px) {
  	    .table-width { max-width: 1060px; }
  	    .table-width3 { max-width: 1090px; }
  	}
</style>
<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->

	<!--
	<div style="text-align: right;">
		<button class="btn btn-primary btn-sm" onclick="viewSearchOtherFastFile()" data-toggle="modal" data-target="#modal" ><i class="fa fa-search"></i> Buscar Fast File</button>
	</div>
	-->
	<div > <!--style="margin-top: -15px;margin-bottom: 5px;text-align: left;"-->
	</div>
	<table style="width: 100%;border-style: solid;border-color: silver;font-size: 11px;" border="1" class="table table-hover">
	<tr>
		<td colspan="33"><div class="col-md-12" style="display: flex;align-items: center;">
		<img src="<?=base_url()."assets/img/miInfo/userPhotos/noPhoto.png"?>" class="profile-photo img-profile" style="width: 80px;border-radius: 100px;"> <!--fotoUser--><h4 style="margin-left: 15px;">Expediente General (Fast File)</h4></div>
		</td>
		<td colspan="2" style="text-align: center;width: 12%;font-size: 12px;font-weight: bold;">
			<div class="mb-2">
				<button class="btn btn-profile btn-sm view-requeriments-profile" data-toggle="modal" data-target="#modal"><i class='fa fa-check-circle'></i> Perfil de Apego</button>
			</div>
			<div class="mb-2">
				<button class="btn btn-primary btn-sm" data-toggle="collapse" href="#docs-collapse" aria-expanded="false" aria-controls="docs-collapse"><i class="fas fa-eye"></i> Documentación</button>
				</div>
			</div>
			<div class="mb-2">
				<button class="btn btn-primary btn-sm" data-toggle="collapse" href="#docsEmployment" aria-expanded="false" aria-controls="docsEmployment"><i class="fas fa-file-alt"></i> Documentos del Puesto</button>
				</div>
			</div>
			<div>
				<button class="btn btn-primary btn-sm" data-toggle="collapse" href="#infoEmployment" aria-expanded="false" aria-controls="functionsEmployment"><i class="fas fa-user-cog"></i> Información del Puesto</button>
				</div>
			</div>
		</td>
		
	</tr>
	<tr style="font-size: 11px;">
		<td colspan="19" class="name-complete">Nombre:&nbsp;<b>Sin personal</b></td>
		<td colspan="19" class="date-of-admission">Fecha de Ingreso: <b>Sin fecha de ingreso</b></td>
	</tr>
	<tr style="font-size: 11px;">
		<td colspan="19" class="name-job">Nombre del Puesto:&nbsp;<b>Sin puesto</b></td>
		<td colspan="19" class="user-email">Correo:&nbsp;<b>Sin correo electrónico</b></td>
	</tr>
	</table>
	<!--<div id="repository-view"></div>  React Component (pending)-->
	<div class="collapse" id="docs-collapse">
		<div class="panel panel-body" style="border: 1px #ABB2B9 solid">
			<div role="tabpanel" class="tabpanel-documents"></div>
		</div>
	</div>
	<div class="collapse" id="docsEmployment">
		<div class="panel panel-default" style="border: 1px #ABB2B9 solid">
			<div class="panel-body">
				<? if($permission["viewAllDocs"]){ ?>
					<div class="container-section-title">
						<label>DOCUMENTOS DEL PUESTO</label>
					</div>
					<div class="col-md-12 column-flex border-lr">
				        <label style="margin-bottom:0px; margin-right: 5px;color: #3d3d3d;">Filtrar:</label>
				        <select class="form-control input-sm" id="SelectFiltrar" style="width: 95%;" onchange="FiltrarPorPuesto()">
				        </select>
				    </div>
				    <div class="col-md-12 pd-left pd-right container-table-fastfile">
				    	<table class="table table-striped">
				    	  <thead class="table-thead">
				    	    <tr style="background-color:#1e4c82;color: #fff;height: 25px;z-index: 1;">
				    	      <th class="th-table"><i class="fa fa-file"></i>&nbsp;Nombre del Documento</th>
				    	      <th class="th-table"><i class="fas fa-user-tie"></i>&nbsp;Asignado</th>
				    	      <th class="th-table"><i class="fa fa-file-pdf-o"></i>&nbsp;Opciones del documento</th>
				    	      <?php 
				    	      $permisoEliminar=0;  
				    	      if($permisoAgregar==1){
				    	        $permisoEliminar=1;?>
				    	      <?php }?>
				    	    </tr>
				    	  </thead>
				    	  <tbody id="body-table-doc-asignado"></tbody>
				    	</table>
				    </div>
				<!--Documentos asignados en particular-->
				<?php }else{ ?>
					<div class="col-md-12 pd-left pd-right container-table-fastfile">
				    	<table class="table table-striped">
				    		<thead class="table-thead">
				    		   <tr style="background-color:#7598bf;color: #fff;height: 25px;z-index: 1;">
				    		     <td colspan="3" style="text-align:center;font-weight: 600;font-size: 12px;">
				    		        DOCUMENTOS DEL PUESTO
				    		     </td>
				    		   </tr>
				    		   <tr style="background-color:#1e4c82;color: #fff;height: 25px;">
				    		     <th class="th-table"><i class="fa fa-file"></i>&nbsp;Nombre del Documento</th>
				    		     <th class="th-table"><i class="fa fa-file-pdf-o"></i>&nbsp;Opciones del documento</th>
				    		     <?php 
				    		     $permisoEliminar=0;  
				    		     if($permisoAgregar==1){
				    		       $permisoEliminar=1;?>
				    		     <?php }?>
				    		   </tr>
				    		</thead>
				    		<tbody id="body-table-doc-puesto"></tbody>
				  		</table>
				  	</div>
				<? } ?>
			</div>
		</div>
	</div>
	<div class="collapse" id="infoEmployment">
		<div class="panel panel-default" style="border: 1px #ABB2B9 solid">
			<div class="panel-body">
				<ul class="nav nav-tabs" id="tab_info_puesto" role="tablist">
					<li role="presentation" class="active"><a class="nav-link active" data-toggle="tab" id="tab_vacaciones" role="tab" aria-selected="true" href="#tab_obj">Objetivo del puesto </a></li>
					<li role="presentation"><a class="nav-link" data-toggle="tab" id="tab_vacaciones" role="tab" aria-selected="true" href="#tab_func">Funciones de puesto</a></li>
					<li role="presentation"><a class="nav-link" data-toggle="tab" id="tab_vacaciones" role="tab" aria-selected="true" href="#tab_kpi">KPI´S</a></li>
				</ul>
				<div class="tab-content" id="contenedor_info_puesto">
					<div class="tab-pane active" id="tab_obj"><h5><strong id="employmentMission"></strong></h5></div>
					<div class="tab-pane container-table-fastfile" id="tab_func" style="max-height: 350px;overflow: auto;">
						<table class="table" id="tableFunctionsEmployment"></table>
					</div>
					<div class="tab-pane" id="tab_kpi">
						<div class="container-spinner-load-kpi"></div>
         				<div class="col-md-12 tab-items" style="padding: 0px;"> <!-- width: 285px; -->
            			    <ul class="nav nav-tabs" id="Nav-Tab-KPI">
            			        <li class="nav-item nav-kpi" id="nav-kpi-c">
            			            <a class="nav-tab-link nav-kpi" aria-current="page" href="#kpi-c" role="tab" data-toggle="tab">
            			                Cobranza
            			            </a>
            			        </li>
            			        <li class="nav-item nav-kpi" id="nav-kpi-m">
            			            <a class="nav-tab-link nav-kpi" aria-current="page" href="#kpi-m" role="tab" data-toggle="tab">
            			                Comercial
            			            </a>
            			        </li>
            			        <li class="nav-item nav-kpi" id="nav-kpi-p">
            			            <a class="nav-tab-link nav-kpi" aria-current="page" href="#kpi-p" role="tab" data-toggle="tab">
            			                Prospección
            			            </a>
            			        </li>
            			        <li class="nav-item nav-kpi" id="nav-kpi-e">
            			            <a class="nav-tab-link nav-kpi" aria-current="page" href="#kpi-e" role="tab" data-toggle="tab">
            			                Ejecutivo
            			            </a>
            			        </li>
            			        <li class="nav-item nav-kpi" id="nav-kpi-o">
            			            <a class="nav-tab-link nav-kpi" aria-current="page" href="#kpi-o" role="tab" data-toggle="tab">
            			                Operativo
            			            </a>
            			        </li>
            			    </ul>
            			</div>
            			<div class="tab-content bg-tab-content-poliza">
            				<div class="col-md-12 tab-pane tab-kpi active" id="kpi-select">
            					<h5 style="text-align: center;color: black;">Seleccione un KPI disponible</h5>
            				</div>
            				<div class="col-md-12 tab-pane tab-kpi" id="kpi-c">
            					<table class="table" id="tableKPICobranza">
    								<thead>
    								    <tr style="background: #396da1;">
										    <th></th>
											<th>EFECTUADA</th>
											<th>A TIEMPO</th>
										    <th>PENDIENTE</th>
											<th>ATRASADA</th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPICobranza"></tbody>
								</table>
            				</div>
            				<div class="col-md-12 tab-pane tab-kpi" id="kpi-m">
            					<table class="table" id="tableKPIComercial">
    								<thead>
    								    <tr style="background: #396da1;">
										    <th></th>
											<th>VENTA NUEVA</th>
											<th>INGRESO TOTAL</th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPIComercial"></tbody>
								</table>
            				</div>
            				<div class="col-md-12 tab-pane tab-kpi" id="kpi-p">
            					<table class="table" id="tableKPIProspeccion">
    								<thead>
    								    <tr style="background: #396da1;">
										    <th>SIN VENTA</th>
											<th>PERFILADOS</th>
											<th>CONTACTADOS</th>
											<th>COTIZADOS</th>
											<th>EMITIDOS</th>
											<th>CERRADOS</th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPIProspeccion"></tbody>
								</table>
            				</div>
            				<div class="col-md-12 tab-pane tab-kpi" id="kpi-e">
            					<h4 class="titleSection">Actividades Ramo <span class="ramoEjecutivo"></span></h4>
            					<table class="table" id="tableKPIEjecutivo1">
    								<thead>
    								    <tr style="background: #396da1;">
										    <th><i class="fas fa-clock"></i></th>
											<th>Diario</th>
											<th>Semanal</th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPIEjecutivo1"></tbody>
								</table>
            					<table class="table" id="tableKPIEjecutivo2">
    								<thead>
    									<tr style="background: #396da1;">
    										<th colspan="4"><center>SEMÁFORO</center></th>
    									</tr>
    								    <tr style="background: #acc5df;">
										    <th></th>
										    <th><span class="semaphore-green"><i class="fas fa-circle"></i></span></th>
											<th><span class="semaphore-yellow"><i class="fas fa-circle"></i></span></th>
											<th><span class="semaphore-red"><i class="fas fa-circle"></i></span></th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPIEjecutivo2"></tbody>
								</table>
								<hr class="hr-divider">
            					<h4 class="titleSection">Renovaciones <span class="ramoEjecutivo"></span></h4>
            					<table class="table" id="tableKPIEjecutivo3">
    								<thead>
    									<tr style="background: #396da1;">
    										<th colspan="5"><center>SEMÁFORO<center></th>
    									</tr>
    								    <tr style="background: #acc5df;">
										    <th></th>
											<th><span class="cont-semaphore-green">+20</span></th>
											<th><span class="cont-semaphore-yellow">+1</span></th>
											<th><span class="cont-semaphore-red">-1</span></th>
											<th style="color: black;display: none;">Totales</th>
									    </tr>
									</thead>
									<tbody id="bodyTableKPIEjecutivo3"></tbody>
								</table>
            				</div>
            				<div class="col-md-12 tab-pane tab-kpi" id="kpi-o">
            					<div class="col-md-12 tab-items" style="padding: 0px;">
            						<ul class="nav nav-pills" id="pills-kpi-o">
									  <li role="presentation" class="active"><a href="#r1" role="tab" data-toggle="tab"><i class="fas fa-car"></i> Autos</a></li>
									  <li role="presentation"><a href="#r2" role="tab" data-toggle="tab"><i class="fas fa-heartbeat"></i> Daños</a></li>
									  <li role="presentation"><a href="#r3" role="tab" data-toggle="tab"><i class="fas fa-user"></i> Líneas Personales</a></li>
									  <li role="presentation"><a href="#r4" role="tab" data-toggle="tab"><i class="fas fa-sync-alt"></i> Renovaciones</a></li>
									</ul>
								</div>
								<div class="tab-content bg-tab-content-kpi-operativo">
									<div class="col-md-12 tab-pane active" id="r1">
										<table class="table" id="tableAutosOperativo"></table>
									</div>
									<div class="col-md-12 tab-pane" id="r2">
										<table class="table" id="tableDaOperativo"></table>
									</div>
									<div class="col-md-12 tab-pane" id="r3">
										<table class="table" id="tableLPOperativo"></table>
									</div>
									<div class="col-md-12 tab-pane" id="r4">
										<table class="table" id="tableRenovacionesOp">
    										<thead>
    											<tr style="background: #396da1;">
    												<th colspan="5"><center>SEMÁFORO<center></th>
    											</tr>
    										    <tr style="background: #acc5df;">
												    <th></th>
													<th><span class="cont-semaphore-green">+20</span></th>
													<th><span class="cont-semaphore-yellow">+1</span></th>
													<th><span class="cont-semaphore-red">-1</span></th>
													<th style="color: black;">Totales</th>
											    </tr>
											</thead>
											<tbody id="bodyTableRenovacionesOp"></tbody>
										</table>
									</div>
								</div>
            				</div>
            			</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="table">

		<div class="row mb-4">
			<div class="col-md-2"><select id="fast-file-year" class="form-control input-sm"><option value="0">Seleccione un año</option><?= $years ?></select></div>
			<div class="col-md-2"><select id="fast-file-month" class="form-control input-sm"><option value="0">Seleccione un mes</option><?= $optionMonths ?><option value="accumulated">ACUMULADO</option></select></div>
			<div class="col-md-2 width-ajust"><button class="btn btn-primary btn-sm" data-params="true" onclick="buscarFastFile('true')"><i class="fas fa-search"></i> Consultar</button></div>
			<? if ($permission['showSE'] == 1) { ?>
			<div class="col-md-2 width-ajust"><a class="btn btn-profile btn-sm" href="<?=base_url()?>superEstrella" style="margin: 0px;" target="_blank"><i class="fas fa-star"></i> Ir a Super Estrella</a></div>
			<? } ?>
		</div>

		<div class="specified-dashboard table-width" id="TableFastFileMonth">
			<table class="table table-sm table-condensed table-bordered">
				<thead class="show-days-selected"></thead>
				<tbody class="show-days-info"></tbody>
			</table>
		</div>
		
		<div class="general-dashboard"></div>
	</div>
	
