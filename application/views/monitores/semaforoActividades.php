<? $this->load->view('headers/header'); ?>

<!-- Spinner Bar -->
<div id="LoadingSpinnerBar" class="container-spinner-bar hidden">
    <div class="container-spinner-bar-content-loading">
        <div class="spinner-bar">
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3"></div>
            <div class="rect4"></div>
            <div class="rect5"></div>
        </div>
    </div>       
</div>

<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>
<?	
	$colorRef[0] = "5";
	$colorRef[1] = "8";
	$colorRef[2] = "11";
	$colorRef[3] = "14";
	$colorRef[4] = "17";
	$colorRef[5] = "20";
	$colorRef[6] = "23";
	$colorRef[7] = "26";
	$colorRef[8] = "29";
	$colorRef[9] = "32";
	$colorRef[10] = "";
	$colorRef[11] = "";
	$colorRef[12] = "";
	$colorRef[13] = "";
	$colorRef[14] = "";

	$graficaRef		= base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
	$graficaBarras	= base_url().'assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=';
	$graficaPastel	= base_url().'assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=';
	$graficaPorcen	= base_url().'assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=';

	//var_dump($result); Consulta funciona correctamente, al mandarlo por echo json_encode trae conflicto.
	//var_dump($rangeQ);
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/hover-min.css">
<style type="text/css">
	/*ID*/
		#LoadingSpinnerBar {z-index: 1000;}
		/*#contTableRGeneral {background: #f5f8ff;}*/
	/*Containers*/
		.container-spinner-bar {position: fixed;}
		.container-table {height: auto;}
		.container-table-bootstrap {border: 0;background: #f7f7f7;}
		.segment-section {background: #eceef5;border-radius: 8px;padding: 10px;}
		.segment-table {width: 100%;border: 0;background: #f7f7f7;border-radius: 8px;padding: 10px;}
		.segment-search-filter {padding: 5px 10px;border: 1px solid #dbdbdb;border-radius: 5px;}
		.btn-export > .container-spinner-btn-loading {padding: 0px;}
	/*Botones*/
		.btn-function {color: #004f76;background: #e8eff4;font-size: 14px;padding: 5px 6px;border: 1px solid #dae4ee;border-radius: 4px;transition: 0.3s;}
		.btn-menu-vendedor {color: #3d3d3d;font-size: 1.4rem;background: #dff1f5;border: 1px solid #aec1d3;border-radius: 5px;padding: 6px 8px;margin-bottom: 0.5rem;}
		.btn-export {width: 4.5rem;height: 3.4rem;font-size: 1.6rem;border-radius: 4px;background: #287f8f;border-color: #287f8f;}
		.btn-show-column {height: 3.4rem;font-size: 1.5rem;border-radius: 4px;}
		.btn-function:hover {background: #cbdfee;border-color: #cbdfee;}
		.btn-menu-vendedor:hover {color: black;background: #bfe1e9;}
		button.btn:focus {outline: 0 !important;}
	/*Tables*/
		.title-table-alt > div {left: 0px;position: sticky;}
		.table-sub-tr {background: #1E6C82;color: white;}
		#TableGeneral thead > tr > th:nth-child(28),
		#TableRepetidas thead > tr > th:nth-child(28) {min-width: 180px;}
		#TableGeneral thead > tr > th:nth-child(31),
		#TableRepetidas thead > tr > th:nth-child(31) {min-width: 400px;}
		/*#TableRGeneral.table-striped > tbody > tr {background-color: #f9f9f9;}*/
		/*#TableRGeneral.table-striped > tbody > tr:nth-of-type(odd) {background-color: #f0f8fb;}*/
		.container-table table > tbody > tr,
		.container-table-bootstrap table.table-striped > tbody > tr {background-color: #f9f9f9;}
		.container-table table.table-striped > tbody > tr:nth-of-type(odd),
		.container-table-bootstrap table.table-striped > tbody > tr:nth-of-type(odd) {background-color: #efefef;}
		.container-table table > tbody > tr.selected-vend,
		.container-table-bootstrap table.table-striped > tbody > tr.selected-vend {background: #e9d8a6;}
		.container-table table > tbody > tr:hover,
		.container-table-bootstrap table > tbody > tr:hover {background: #e0e3f7;}
		.container-table table > tbody > tr.table-sub-tr,
		.container-table table.table-striped > tbody > tr.table-sub-tr:nth-of-type(odd) {background: #1E6C82;color: white;}
	/*Texts*/
		.textForm {text-wrap: nowrap;margin-bottom: 0px;}
		.text-rs-vn {font-size: 1.2rem;font-weight: 700;}
	/*Others*/
		.position-footer-table {position: sticky;bottom: 0px;}
		.rs-total {background: #b9d7ea;}
		.rs-total-v2 {background: #d8f5ff;}
		.active {transition: 0.3s;}
		.obj-spinner-bar {overflow: hidden;}
		.text-b {font-weight: 700;}
		.dropdown-h {max-height: 300px;overflow: auto;}
		.collapse.show {visibility: visible;}
	/*Media Query*/
    	@media (max-width: 1440px) {
    	  	.container-table { max-width: 1263px;max-height: 500px; }
    	  	.container-table-bootstrap { max-width: 1263px; }
    	}
    	@media (max-width: 1280px) {
    	  	.container-table { max-width: 1104px; }
    	  	.container-table-bootstrap { max-width: 1104px; }
    	}
    	@media (max-height: 860px) {
    		.container-table { max-height: 600px; }
    	  	.container-table-bootstrap { height: 680px; }
    	}
    	@media (max-height: 680px) {
    		.container-table { max-height: 480px; }
    	  	.container-table-bootstrap { height: 600px; }
    	}
</style>
<!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Monitores</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
            <ol class="breadcrumb text-right">
                <li><a href="<?=base_url()?>">Inicio</a></li>
                <li><a href="<?=base_url()."monitores"?>">Monitores</a></li>
				<li class="active"><?=$consultarView?></li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>
<!-- End navbar -->
<section class="container-fluid">
    <div class="col-md-12 pd-left pd-right pd-top pd-bottom">
        <div class="col-md-12 pd-left pd-right">
            <div class="col-md-12 pd-left pd-right" id="nav-yearly-General">
                <ul class="nav nav-tabs tab_capa">
                    <li class="nav-item">
                        <a class="nav-tab-link active" aria-current="page" href="#Mn1" role="tab" data-toggle="tab">
                        	<i class="fas fa-desktop"></i> Control</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-tab-link" aria-current="page" href="#Mn2" role="tab" data-toggle="tab">
                        	<i class="fas fa-newspaper"></i> Reportes</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content bg-tab-content-nav mg-cero">
            	<!-- Panel 1 -->
            	<div class="col-md-12 tab-pane active" id="Mn1">
<?
if($ConsultaTipoAct->num_rows() > 0){
?>
	<div class="row">
    	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="glyphicon glyphicon-filter"></i> Resultados Filtrados
				</div><!--* panel-heading -->
            	<div class="panel-body">
                	<div class="row">
						<div class="col-md-12">
                        	<span style="font-size:14px;">
                            <?
								if($filtroFechas == "si"){
							?>
<!--                            <div class="row"> -->
                            	<div class="col-md-6">
									<b>Filtrado Tipo:</b> <i>Rango de Fechas</i>
									<p style="padding-left:9px;">
        	                        	<b>Fecha de Inicio:</b> <i><?=$fechaStart?></i>
            	                        &nbsp;
                                		<b>Fecha de Inicio:</b> <i><?=$fechaEnd?></i>
                	                </p>
                                </div>
<!--							</div> -->
                            <?
								} else {
							?>
<!--                            <div class="row"> -->
                            	<div class="col-md-6">
								<b>Filtrado Tipo:</b> <i>Selecci&oacute;n de Mes</i>
								<p style="padding-left:9px;">
                                	<b>Mes Seleccionado:</b> <i><?=$meses[$mesActivo]?></i>
                                </p>
                                <form
                        				name="exportaActividades" id="exportaActividades"
										method="post"
                            			action="<?=base_url();?>monitores/Exporta" 
                       			 	>
                                		<div class="col-sm-4 col-md-4">
                                			<label>Inicio</label>
                                			<input
											type="text" name="fechaStart" id="fechaStart"
											class="form-control input-sm fecha fechaStart"
											placeholder="1900-01-01"
                	                		value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>"
                                    		title="Fecha de Inicio"
								         	/>
								   		</div>

								    	<div class="col-sm-4 col-md-4">
                                    		<label>Fin</label>
								    		<input
                            					type="text" name="fechaEnd" id="fechaEnd"
												class="form-control input-sm fecha fechaEnd"
												placeholder="1900-01-01"
                	                			value="<?=($this->input->post('fechaEnd',TRUE)!="")?$this->input->post('fechaEnd',TRUE):date('Y-m-d')?>"
                                    			title="Fecha de Fin"
								    		/>

								     		

                                		</div>
                                		&nbsp;
                                		<button
                                    			class="btn btn-primary btn-sm"
                                        		name="ExportaMonitor" id="ExportaMonitor"
                                    		>
												Exporta Actividades
                                		</button>
								
                               		 </form>	
                                </div>
<!--							</div> -->
							<?
								}
							?>
                                <?
									if(!isset($usuarioVendedor) || $usuarioVendedor != ""){
								?>
                            	<div class="col-md-6">
									<b>Filtrado Agente:</b> <i>Si</i>
									<p style="padding-left:9px;">
                                    	<?
										/*
											// print_r($usuVend_Array);
											if(in_array($usuarioVendedor,$usuVend_Array)){
												//echo "Si";
											} else {
												//echo "No";
											}
										*/
										?>
        	                        	<b>Agente:</b> <i><?=$usuarioVendedor?></i>
									</p>
                                </div>
                                <?
									}
								?>
                            </span>
						</div>
                	</div>
            	</div>
			</div>
        </div>
    </div>
<?
} else if($this->input->post('fechaStart',TRUE)!=""){
?>
	<div class="row">
    	<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="glyphicon glyphicon-warning-sign"></i> No Hay Resultados
                    <!-- glyphicon glyphicon-warning-sign -->
				</div><!--* panel-heading -->
            	<div class="panel-body">
                	<div class="row">
						<div class="col-md-12">
                        	<span style="color:#F00; font-weight:bold; font-size:14px;">
								Lo siento no existen resultados con el filtro solicitado !!!
                            </span>
						</div>
                	</div>
                </div>
			</div>
		</div>
    </div>
<?
}
?>      
	<div class="row">
		<div class="col-md-12">
        	<div class="row">
            	<div class="col-sm-3 col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading">
                        	<i class="glyphicon glyphicon-list-alt"></i> Semaforo Actividades
						</div><!--* panel-heading -->
                        <div class="panel-body">
                        <form
                        	name="formMesActividades" id="formMesActividades"
							method="post"
                            action="<?=base_url();?>monitores/verMonitor" 
                        >
                        	<input type="hidden" name="monitorear" value="SemaforoActividades">

                            <!-- -->
                        	<div class="row">
								<div class="col-sm-12 col-md-12" align="right">
								<select id="selectCoordinadores" name="selectCoordinadores" onchange="cambioCoordinador(this.value)" class="form-control input-sm"></select>
							<select
								class="form-control input-sm"
								name="usuarioVendedor" id="usuarioVendedor"
                                title="Seleccione un Agente a Monitorear"
							>
                            	<option value="" title="Muestra Todos los Agentes">-- Seleccione un Agente --</option>                                
                            	<?
									foreach($usuVend_Array as $usuVend){ // $key => $mes
                                ?>
                            	<option 
                                	value="<?=$usuVend->email;?>"
									
                                >
									<?=$usuVend->nombre.' '.$usuVend->apellidoPaterno.' '.$usuVend->apellidoMaterno;?>
                                </option>
                                <?
									}
								?>
							</select>
                                </div>
							</div>
                        	<div class="row">
								<div class="col-sm-12 col-md-12" align="right">
                                	<p><hr /></p>
                                </div>
							</div>
                        	<div class="row">
								<div class="col-sm-4 col-md-4">
									<input type="hidden" name="filtroFechas" id="filtroFechas" value="<?=$this->input->post('filtroFechas',TRUE)?>">
                                	<label style="alignment-baseline:central;">
                                    	Filtro Fechas:
                                		<input type="checkbox" name="filtroFechasChec" id="filtroFechasChec" value="si"
											<?=($this->input->post('filtroFechas',TRUE)=="si")?'checked="checked"':''?> 
                                            title="Click para activar el filtro por rango de fechas"
        	                            />
									</label>
                                </div>
								<div class="col-sm-4 col-md-4">
								<input
									type="text" name="fechaStart" id="fechaStart"
									class="form-control input-sm fecha fechaStart"
									placeholder="1900-01-01"
                	                value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>"
                                    title="Fecha de Inicio"
								/>
                                </div>
								<div class="col-sm-4 col-md-4">
								<input
                            		type="text" name="fechaEnd" id="fechaEnd"
									class="form-control input-sm fecha fechaEnd"
									placeholder="1900-01-01"
                	                value="<?=($this->input->post('fechaEnd',TRUE)!="")?$this->input->post('fechaEnd',TRUE):date('Y-m-d')?>"
                                    title="Fecha de Fin"
								/>
                                </div>
                            </div>
                        	<div class="row">
								<div class="col-sm-12 col-md-12" align="right">
                                	<p><hr /></p>
                                </div>
							</div>
                        	<div class="row">
								<div class="col-sm-8 col-md-8">
                            <!-- -->
							<select
								class="form-control input-sm"
								name="mesActividades" id="mesActividades"
                                title="Seleccione el Mes a Monitorear"
							>
                            	<option value="">-- Seleccione Mes a Monitorear --</option>
                            	<?
									foreach($meses as $key => $mes){
                                ?>
                            	<option value="<?=$key?>" <?=($mesActivo==$key)?'selected="selected"':''?>><?=$mes?></option>
                                <?
									}
								?>
                            </select>
								</div>
								<div class="col-sm-4 col-md-4">
                                    <button
                                    	class="btn btn-primary btn-sm"
                                        name="GenerarMonitor" id="GenerarMonitor"
                                    >
										Mostrar Monitor
                                    </button>
                                </div>
							</div>
                            <div class="row">
                            	<div class="col-sm-12 col-md-12">
                        	<?
								if($ConsultaActivi->num_rows() > 0){
									$dat_Actividades	= "";
									$ref				= array();
									$puntero			= 0;
									$tipoActividadMes	= array();
									$totalActividades	= 0;
									
									foreach($ConsultaActivi->result_array() as $tiposActividad){

										$cotizacion	= "";
										$Endoso		= "";
										if($tiposActividad['tipoActividad']=='Cotizacion'){$cotizacion=' <button class="btn btn-primary" onclick="verMontosPorCompania(\'\',event)">Ver</button>';}

										if($tiposActividad['tipoActividad']=='Endoso'){$Endoso=' <button class="btn btn-primary" onclick="verMontosEndosos(\'\',event)">Ver</button>';}
										
										$totalActividades	= $totalActividades + $tiposActividad['noTipoActividad'];
										$tipoActividadMes[]	= $tiposActividad['tipoActividad'];
										$dat_Actividades   .= $tiposActividad['noTipoActividad'].",";
										$ref[] = ''
											.'<tr>'
	                                       		.'<td>'
													.'<img src="'.$graficaRef.$colorRef[$puntero].'&typ=2&dim=5&bkg=FFFFFF">'
												.'</td>'
												.'<td>'
													.'('.str_pad($tiposActividad['noTipoActividad'],2,'0',0).')'
												.'</td>'
												.'<td>'
													.''.$tiposActividad['tipoActividad'].$cotizacion.$Endoso
												.'</td>'
											.'</tr>';
										$puntero++;
									}
									$dat_Actividades=$dat_Actividades.$cantUrgentes;
									$sumCalificaciones=$cantMalas+$cantRegulares+$cantSinCalificar+$cantBuenas;
							?>


								<img src="<?=$graficaBarras.trim($dat_Actividades, ',')."&bkg=FFFFFF&wdt=300&hgt=200"?>">
								<br />
								<div class="table-responsive">
									<table class="table">
                                    	<tr style="text-decoration:underline;">
                                        	<td></td>
                                            <td>Total</td>
                                            <td>Tipo Actividad</td>
										</tr>
                                        <?
											foreach($ref as $referencia){
												print($referencia);
												
											}
										/*$imprimeUrgentes='<tr><td><img src="'.base_url();
										$imprimeUrgentes=$imprimeUrgentes.'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=23&typ=2&dim=5&bkg=FFFFFF"></td><td>(';
										$imprimeUrgentes=$imprimeUrgentes.$cantUrgentes.')</td><td>Urgentes</td></tr>';*/

										//echo($imprimeUrgentes);

										?>
                                        <tr>
                                    	    <td></td>
                                        	<td colspan="2"><b><?=$totalActividades?> Total</b></td>

										</tr>
<tr><td colspan="5">Numero de urgentes: <?php  echo($cantUrgentes)    ?>  </td></tr>

<tr><td colspan="5">Calificacion de las Actividades </td></tr>
										<tr><td colspan="5"><label style=" color: green"><?php 	echo($cantBuenas); ?> Actividades Buenas (<?php   echo(($cantBuenas>0) ? round(($cantBuenas*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>
										<tr><td colspan="5"> <label style=" color: red"><?php 	echo($cantMalas);  ?> <label style=" color: red">Actividades Malas (<?php echo(($cantBuenas>0) ? round(($cantMalas*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>										
										<tr><td colspan="5"><label style=" color: #d28802"><?php 	echo($cantRegulares);  ?> Actividades Regulares (<?php echo(($cantBuenas>0) ? round(($cantRegulares*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>
										<tr><td colspan="5"><label style=" color: #605e5e"><?php 	echo($cantSinCalificar);  ?> Actividades sin Calificar (<?php echo(($cantBuenas>0) ? round(($cantSinCalificar*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>

									</table>

								</div>
							<?
								} /*! if Num_Rows() */
							?>
                                </div>
                            </div>
                        	<!-- <input type="hidden" name="tipoActividad" value=""> -->
						</form>    
                        </div><!--* panel-body -->
					</div><!--* panel panel-default -->
				</div><!--* col-sm-3 col-md-4 -->
            	
                <? if($ConsultaActivi->num_rows() > 0){ ?>
                <div class="col-sm-3 col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading">
                        	<i class="glyphicon glyphicon-list-alt"></i> Desglose Tipos Actividades
						</div><!--* panel-heading -->
                        <div class="panel-body">
                        <form
                        	name="formTipoActividades" id="formTipoActividades"
							method="post"
                            action="<?=base_url();?>monitores/verMonitor" 
                        >
                        	<input type="hidden" name="monitorear" id="monitorearDTA" value="SemaforoActividades">
                            <input type="hidden" name="mesActividades" id="mesActividadesDTA" value="<?=$this->input->post('mesActividades',TRUE)?>">
                            <input type="hidden" name="filtroFechas" id="filtroFechaDTA" value="<?=$this->input->post('filtroFechas',TRUE)?>">
                            <input type="hidden" name="fechaStart" id="fechaStartDTA" value="<?=$this->input->post('fechaStart',TRUE)?>">
                            <input type="hidden" name="fechaEnd" id="fechaEndDTA" value="<?=$this->input->post('fechaEnd',TRUE)?>">
                            <input type="hidden" name="usuarioVendedor" id="usuarioVendedorDTA" value="<?=$this->input->post('usuarioVendedor',TRUE)?>">
                           <input type="hidden" name="selectCoordinadores" id="selectCoordinadoresDTA" value="<?=$this->input->post('selectCoordinadores',TRUE)?>">
							<select
								class="form-control input-sm"
                                name="tipoActividad" id="tipoActividad"
                                title="Seleccione el Tipo de actividad a Monitorear"
							>
                            	<?
									foreach($tipoActividadMes as $tiposActividades){
                                ?>
                                <option value="<?=$tiposActividades?>" <?=($tipoActividad==$tiposActividades)?'selected="selected"':''?>><?=$tiposActividades?></option>
                                <?
									}
								?>
                            </select>
                        	<?
								if($ConsultaTipoAct->num_rows() > 0){
									$dat_TiposActividades	= "";
									$refTiposActividades	= array();
									$puntero				= 0;
									$totalTiposActividades	= 0;
									$tiposProspectos		= array();
									$subRamosActivida		= array();
									
									foreach($ConsultaTipoAct->result_array() as $tipoActividades){
										//$totalSubRamo			= $tipoActividades['noActividadTipo'];
										$subRamosActivida[]		= $tipoActividades['subRamoActividad'];
										$totalTiposActividades	= $totalTiposActividades + $tipoActividades['noActividadTipo'];
										$dat_TiposActividades   .= $tipoActividades['noActividadTipo'].",";
										$refTiposActividades[]	= ''
											.'<tr>'
												.'<td>'
													.'<img src="'.$graficaRef.$colorRef[$puntero].'&typ=2&dim=5&bkg=FFFFFF">'
												.'</td>'
                                                .'<td>'
													.'('.str_pad($tipoActividades['noActividadTipo'],2,'0',0).')'
												.'</td>'
												.'<td>'
													.''.$tipoActividades['tipoActividad']
													.'<font style="font-size:10px;">'
														.'<br /><b>&bull;'.$tipoActividades['ramoActividad'].'</b>'
														.'<br /><b>-'.$tipoActividades['subRamoActividad'].'</b>'
													.'</font>'
												.'</td>'
											.'</tr>';
										$puntero++;
										if($puntero==14){$puntero=1;}

									}
										
							?>

								<img src="<?=$graficaPastel.trim($dat_TiposActividades, ',')."&bkg=FFFFFF&wdt=300&hgt=200"?>">
								<?echo '<img   src='.base_url().'GraPHPico_0-0-3/graphpastel.php?dat=2,5,1,6,3,4&bkg=FFFFFF&wdt=100&hgt=200"'.'">'?>
								<br /><br />
								<div class="table-responsive">
                                	<table class="table">
                                    	<tr style="text-decoration:underline;">
                                        	<td></td>
                                            <td>Total</td>
                                            <td>Tipos Actividad</td>
										</tr>
										<?
										$sumaCalifPorTipo=$cantBuenasPorTipoResult+$cantMalasPorTipoResult+$cantRegularResult+$cantSinCalificarResult;
										foreach($refTiposActividades as $refTipoActivida){
											print($refTipoActivida);
										}
										?>
										<tr>
                                        	<td></td>
                                        	<td colspan="2"><b><?=$totalTiposActividades?> Total</b></td>
										</tr>

										<tr><td colspan="5">Calificacion de las Actividades </td></tr>
										<tr><td colspan="5"><label style=" color: green"><?php 	echo($cantBuenasPorTipoResult); ?> Actividades Buenas (<?php echo(($cantBuenas>0) ? round(($cantBuenasPorTipoResult*100)/$sumaCalifPorTipo,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>
										<tr><td colspan="5"> <label style=" color: red"><?php 	echo($cantMalasPorTipoResult);  ?> <label style=" color: red">Actividades Malas (<?php echo(($cantBuenas>0) ?round(($cantMalasPorTipoResult*100)/$sumaCalifPorTipo,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>										
										<tr><td colspan="5"><label style=" color: #d28802"><?php 	echo($cantRegularResult);  ?> Actividades Regulares (<?php echo(($cantBuenas>0) ?round(($cantRegularResult*100)/$sumaCalifPorTipo,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>
										<tr><td colspan="5"><label style=" color: #605e5e"><?php 	echo($cantSinCalificarResult);  ?> Actividades sin Calificar (<?php echo(($cantBuenas>0) ?round(($cantSinCalificarResult*100)/$sumaCalifPorTipo,1, PHP_ROUND_HALF_UP):0) ?>%)</label></td></tr>
									</table>
								</div>
							<?
								} /*! if Num_Rows() */
							?>
						</form>
                        </div><!--* panel-body -->
					</div><!--* panel panel-default -->
				</div><!--* col-sm-3 col-md-4 -->
                <? } ?>
				<? if($ConsultaActivi->num_rows() > 0){ ?>
                <div class="col-sm-3 col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading">
                        	<i class="glyphicon glyphicon-list-alt"></i> Detalle Actividades Tipo
						</div><!--* panel-heading -->
                        <div class="panel-body">
                        <form
                        	name="formDetalleActividades" id="formDetalleActividades"
							method="post"
                            action="<?=base_url();?>monitores/verMonitor" 
                        >
                        	<input type="hidden" name="monitorear" value="SemaforoActividades">
                            <input type="hidden" name="mesActividades" value="<?=$this->input->post('mesActividades',TRUE)?>">
                            <input type="hidden" name="tipoActividad" value="<?=$this->input->post('tipoActividad',TRUE)?>">
                            <input type="hidden" name="filtroFechas" value="<?=$this->input->post('filtroFechas',TRUE)?>">
                            <input type="hidden" name="fechaStart" value="<?=$this->input->post('fechaStart',TRUE)?>">
                            <input type="hidden" name="fechaEnd" value="<?=$this->input->post('fechaEnd',TRUE)?>">
                            <input type="hidden" name="usuarioVendedor" value="<?=$this->input->post('usuarioVendedor',TRUE)?>">
                            <!-- tipoActividad -->
                            <select
								class="form-control input-sm"
                                name="subRamoActividad" id="subRamoActividad"
                                title="Seleccione el SubRamo de actividades a Monitorear"
							>
                            <?
								foreach($subRamosActivida as $ramosActividad){
							?>
                            	<option value="<?=$ramosActividad?>" <?=($ramosActividad==$subRamoActividad)?'selected="selected"':''?>><?=$ramosActividad?></option>
							<?
								}
							?>
                            </select>
                        	<?
								if($ConsultaTipoAct->num_rows() > 0){
									$totalSubRamo	= count($ConsultaSubRamosAct->result_array());
									$porcentaje		= round(($totalSubRamo / $totalTiposActividades)*100,2,1);
									$refDetalleActivida	= "";
									foreach($ConsultaSubRamosAct->result_array() as $subRamosActividades){
										$refDetalleActivida[]	= ''
											.'<tr>'
												.'<td title="'.$subRamosActividades['datosExpres'].'">'
													.'<font style="font-size:12px;">'
													.$subRamosActividades['folioActividad']
													.'</font>'
												.'</td>'
												
                                                .'<td>'
													.'<font style="font-size:10px;">'
													."<b>FecAlta: </b>".$subRamosActividades['fechaCreacion']
													.'<br />'
													."<b>FacActu: </b>".$subRamosActividades['fechaActualizacion']
													.'</font>'
												.'</td>'
												
												.'<td>'
													.'<font style="font-size:12px;">'
													.$subRamosActividades['Status_Txt']
													.'</font>'
												.'</td>'
											.'</tr>'
											.'<tr style="border-top:solid 2px #FFF;">'
												.'<td>'
												.'</td>'
												
                                                .'<td colspan="2">'
													.'<font style="font-size:10px;">'
													."<b>Creado: </b>".$subRamosActividades['nombreUsuarioCreacion']
													.'<br />'
													."<b>Agente: </b>".$subRamosActividades['nombreUsuarioVendedor']
													.'</font>'
												.'</td>'
											.'</tr>'
											.'<tr style="border-top:solid 2px #FFF;" align="left">'
                                                .'<td colspan="3">'
													.'<font style="font-size:14px; font-style:italic;">'
													.'<b>&bull;</b> '
													.'<font style="text-decoration:underline;">'.$subRamosActividades['tipoActividad'].'</font><br />'
													.'</font>'
													.'<font style="font-size:11px;">'
													." <b>&bull;</b> ".$subRamosActividades['ramoActividad']
													." <b>&bull;</b> ".$subRamosActividades['subRamoActividad']
													.'</font>'
												.'</td>'
											.'</tr>';
									}
							?>
                            	<br />
                                <div class="row">
                                	<div class="col-sm-6 col-md-6" align="right">
                                    	<span style="text-align:right">
											<img src="<?=$graficaPorcen.$porcentaje."&wdt=30"?>" title="">
                                    	</span>
                                    </div>
                                	<div class="col-sm-6 col-md-6" align="left">
                                    	<table cellpadding="2" cellspacing="0" style="font-size:10px;">
                                        	<tr align="left">
                                            	<td><b>Total Actividades:</b></td>
                                            </tr>
                                        	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
                                            	<td><?=$totalActividades?></td>
                                            </tr>
                                        	<tr align="left">
                                            	<td><b>Total Tipo <?=$tipoActividades['tipoActividad']?>:</b></td>
                                            </tr>
                                        	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
                                            	<td><?=$totalTiposActividades?></td>
                                            </tr>
                                        	<tr align="left">
                                            	<td><b>Total <?=ucwords(strtolower($subRamoActividad))?>:</b></td>
                                            </tr>
                                        	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
                                            	<td><?=$totalSubRamo?></td>
                                            </tr>
                                        	<tr align="left">
                                            	<td><b>% <?=ucwords(strtolower($subRamoActividad))?>:</b></td>
                                            </tr>
                                        	<tr align="right" style="font-size:12px; text-decoration:underline; font-style:italic;">
                                            	<td><?=$porcentaje?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <br /><br />
								<div class="table-responsive">
                                	<table class="table">
                                    	<tr style="text-decoration:underline;">
                                        	<td>Folio</td>
                                            <td>Fecha</td>
                                            <td>Estado</td>
										</tr>
										<?
										foreach($refDetalleActivida as $refDetalle){
											print($refDetalle);
										}
										?>
										<tr>
                                        	<td></td>
                                        	<td></td>
                                        	<td></td>
										</tr>
									</table>
                                </div>
							<?
								} /*! if Num_Rows() */
							?>
						</form>
                        </div><!--* panel-body -->
					</div><!--* panel panel-default -->
				</div><!--* col-sm-3 col-md-4 -->
                <? } ?>
			</div>
		</div>		       	
	</div>
				</div>
				<!-- Panel 2 [2024-08-28] -->
				<div class="col-md-12 tab-pane" id="Mn2">
					<div class="col-md-12 pd-left pd-right" style="margin-bottom: 25px;">
            			<h5 class="titleSection">Reportes de Actividades
            				<button class="btn-view-cont" data-toggle="collapse" href="#segWarning" aria-expanded="true">
            					<i class="fa fa-exclamation-circle" title="Ver Información"></i>
                			</button>
                		</h5>
            			<hr class="table-hr">
            			<div class="col-md-12" style="margin-bottom: 10px;">
            			    <div class="col-md-12 collapse pd-top pd-bottom" id="segWarning">
            			        <div class="alert alert-primary" role="alert" style="margin: 0px;">
            			            <h4><i class="fas fa-exclamation-circle"></i> Advertencia</h4>
            			            <ul>
            			            	<li>
            			            		<p class="p-list-alert">La búsqueda por año utilizando el <b>Rango de Fechas</b> (Por ejemplo: 01/01/2024 - 31/12/2024) puede tardar aproximadamente 5 minutos o más, pero si te muestra la información. Este tipo de búsqueda al manejar demasiada información puede hacer que la exportación no sea posible.</p>
            			            	</li>
            			            	<li>
            			            		<p class="p-list-alert">Al realizar la búsqueda por más de 3 meses los resultados tardarán más en mostrarse, además de que la exportación no es segura.</p>
            			            	</li>
            			            	<li>
            			            		<p class="p-list-alert">Se recomienda utilizar como máximo rango entre 3 meses o el <b>Trimestral</b>.</p>
            			            	</li>
            			            </ul>            			            
            			        </div>
            			    </div>
            			</div>
            			<div class="col-md-12 segment-search-filter mg-bottom">
            				<div class="col-md-12 column-flex-center-start pd-items-table">
            					<label class="textForm">Buscar por: </label>
            					<div class="form-check column-flex-center-center" style="padding-right: 1.25rem;">
                  					<input type="radio" class="form-check-input" name="check-search" value="1">
                  					<label class="form-check-label">Trimestre</label>
                  					<input type="radio" class="form-check-input" name="check-search" value="2" checked>
                  					<label class="form-check-label">Mes</label>
                  					<input type="radio" class="form-check-input" name="check-search" value="3">
                  					<label class="form-check-label">Rango de Fechas</label>
                  				</div>
            				</div>
							<div class="col-md-12 column-flex-bottom segment-search-filter pd-items-table">
            				    <div class="pd-side">
            				        <label class="form-check-label">Trimestre:</label>
            				        <select class="form-control width-ajust" name="input-search" id="searchQuarterly" disabled>
            				            <?=$op_quarterly?>
            				        </select>
            				    </div>
            				    <div class="pd-side">
            				        <label class="form-check-label">Mes:</label>
            				        <select class="form-control width-ajust" name="input-search" id="searchMonth">
            				            <?=$op_months?>
            				        </select>
            				    </div>
            				    <div class="pd-side">
            				        <label class="form-check-label">Año:</label>
            				        <select class="form-control width-ajust" id="searchYear">
            				            <?=$op_years?>
            				        </select>
            				    </div>
            				    <div class="pd-side">
            				        <label class="form-check-label">Fecha Inicial:</label>
            				        <input type="date" class="form-control" name="input-search" id="searchDateI" value="<?=$rangeQ['dateI']?>" disabled>
            				    </div>
            				    <div class="pd-side">
            				        <label class="form-check-label">Fecha Final:</label>
            				        <input type="date" class="form-control" name="input-search" id="searchDateF" value="<?=$rangeQ['dateF']?>" disabled>
            				    </div>
            				    <div class="pd-side">
            				        <button class="btn btn-primary" id="btnSearch" onclick="getCompleteInformationActivities()">Generar</button>
            				    </div>
            			    </div>
            			</div>
            		</div>
            		<div class="col-md-12" style="margin-bottom: 25px;">
            			<div class="row">
            				<div class="col-md-6 column-flex-center-start">
            					<h5 class="titleSection">
            						Reporte General <span class="selectedMonth"></span> <span class="textForm">(Resultados: <b id="rsGeneral">0</b>)</span>
            					</h5>
            				</div>
            				<div class="col-md-6 column-flex-center-end">
            					<div class="pd-side">
            						<form id="exportReport" method="get" action="<?=base_url()?>monitores/getCompleteInformationActivities">
            							<input type="hidden" class="form-control input-sm rp" name="rp" id="rp" value="3">
            							<input type="hidden" class="form-control input-sm ck" name="ck" id="ck">
            							<input type="hidden" class="form-control input-sm qr" name="qr" id="qr">
            							<input type="hidden" class="form-control input-sm mn" name="mn" id="mn">
            							<input type="hidden" class="form-control input-sm dI" name="dI" id="dI">
            							<input type="hidden" class="form-control input-sm dF" name="dF" id="dF">
            							<input type="hidden" class="form-control input-sm yr" name="yr" id="yr">
            							<button class="btn btn-success" id="btnExportReport">
            								<i class="fas fa-file-excel"></i> Exportar
            							</button>
            						</form>
            					</div>
            				</div>
            			</div>
            			<hr class="table-hr">
            			<div class="col-md-12 pd-left pd-right pd-top pd-bottom">
                    		<div class="col-md-12 pd-left pd-right">
                    			<ul class="nav nav-tabs nav-light">
                    				<li class="nav-item">
                    					<a class="nav-tab-link active" aria-current="page" href="#RpG" role="tab" data-toggle="tab">Actividades</a>
                    				</li>
                    				<li class="nav-item">
                    					<a class="nav-tab-link" aria-current="page" href="#RpR" role="tab" data-toggle="tab">Repetidos</a>
                    				</li>
                    			</ul>
                    		</div>
                    		<div class="tab-content bg-tab-content-nav" style="min-height: 400px;">
                    			<div class="col-md-12 tab-pane pd-left pd-right active" id="RpG"></div>
                    			<div class="col-md-12 tab-pane pd-left pd-right" id="RpR"></div>
                    		</div>
            			</div>
            		</div>
            		<div class="col-md-12" style="margin-bottom: 25px;">
            			<div class="row">
            				<div class="col-md-6 column-flex-center-start">
            					<h5 class="titleSection">
            						Reporte de Actividades
            						<button class="btn-view-cont" data-toggle="collapse" href="#segInfo" aria-expanded="true">
            							<i class="fa fa-info-circle" title="Ver Información"></i>
                					</button>
                					<span class="selectedMonth" id="selectedMonth"></span> <span class="textForm">(Folios: <b id="rsTiposAct">0</b>)</span>
            					</h5>
            				</div>
            				<div class="col-md-6 column-flex-center-end">
            					<div class="pd-side">
            						<button class="btn btn-success" id="btnExportActP1" onclick="getExportTablesPart1()" disabled>
            							<i class="fas fa-file-excel"></i> Parte 1
            						</button>
            					</div>
            					<div class="pd-side">
            						<form id="exportAct" method="get" action="<?=base_url()?>monitores/getCompleteInformationActivities">
            							<input type="hidden" class="form-control input-sm rp" name="rp" id="rp" value="2">
            							<input type="hidden" class="form-control input-sm ck" name="ck" id="ck">
            							<input type="hidden" class="form-control input-sm qr" name="qr" id="qr">
            							<input type="hidden" class="form-control input-sm mn" name="mn" id="mn">
            							<input type="hidden" class="form-control input-sm dI" name="dI" id="dI">
            							<input type="hidden" class="form-control input-sm dF" name="dF" id="dF">
            							<input type="hidden" class="form-control input-sm yr" name="yr" id="yr">
            							<button class="btn btn-success" id="btnExportActP2">
            								<i class="fas fa-file-excel"></i> Parte 2
            							</button>
            						</form>
            					</div>
            				</div>
            			</div>
            			<hr class="table-hr">
            			<div class="col-md-12" style="margin-bottom: 10px;">
            			    <div class="col-md-12 collapse pd-top pd-bottom" id="segInfo">
            			        <div class="alert alert-primary" role="alert" style="margin: 0px;">
            			            <h4><i class="fas fa-info-circle"></i> Información</h4>
            			            <ul>
            			            	<li>
            			            		<p class="p-list-alert">Debido a la carga de datos que se maneja la exportación de la información proporcionada en estas tablas está dividido en dos:</p>
            			            		<ul>
            			            			<li>
            			            				<p class="p-list-alert">La <b>Parte 1</b> exporta la información de las tablas <i>Conteo Total de Actividades</i> y <i>Actividades Por Vendedor</i>.</p>
            			            			</li>
            			            			<li>
            			            				<p class="p-list-alert">La <b>Parte 2</b> exporta la información de las tablas <i>Folios por Actividad</i> y <i>Reporte Tipos de Actividades</i>.</p>
            			            			</li>
            			            		</ul>
            			            	</li>
            			            	<li>
            			            		<p class="p-list-alert">Las tablas que tengan el botón con el ícono <i class="fas fa-download"></i> pueden descargarse la información que solo te proporcione, es decir, si se filtra y/o se oculta columnas se exportará la información que solo te muestre.</p>
            			            	</li>
            			            	<li>
            			            		<p class="p-list-alert">La información proporcionada en el pie de las tablas (Totales) se suman/calculan según lo mostrado, por ejemplo, si filtras la tabla los resultados <i>Total</i> se volverán a calcular de acuerdo las filas que queden.</p>
            			            	</li>            			            
            			        	</ul>
            			        </div>
            			    </div>
            			</div>
            			<div class="col-md-12 pd-left pd-right pd-top pd-bottom">
                    		<div class="col-md-12 pd-left pd-right" id="navTablesActivities"></div>
                    		<div class="tab-content bg-tab-content-nav cont-spinner-general" id="tabsTablesActivities" style="min-height: 400px;"></div>
            			</div>
            		</div>
				</div>
			</div>
        </div>
    </div><!-- Fin Tab -->
</section>
<div id="divModalGenerico" class="modalCierra">
	<div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido"  >

</div>
</div>

<div class="gifEspera ocultarObjeto" id="gifDeEspera"><img src="<?php echo(base_url().'assets\img\loading.gif')?>"></div>
<? //$this->load->view('footers/footer'); ?>

<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="extensions/sticky-header/bootstrap-table-sticky-header.js"></script>
<script src="<?=base_url()?>/assets/gap/js/jquery.validate.js"></script>
<script>
	var fechaStart =
	$('.fechaStart').datepicker({
		format:		"yyyy-mm-dd",
		startDate:	"",
		language:	"es",
		autoclose:	true
	});
	
	var fechaEnd =
	$('.fechaEnd').datepicker({
		format:		"yyyy-mm-dd",
		startDate:	"",
		language:	"es",
		autoclose:	true
	});

	$('#GenerarMonitor').click(function(e){
		if($('#filtroFechasChec').prop('checked') == true){
			$('#filtroFechas').val('si');
			$('#mesActividades').val('13');
		} else if(filtroFecha == false){
			$('#filtroFechas').val('');
		}
    });

	$('#mesActividades').change(function(e){
		$('#filtroFechas').val('');
		$('#filtroFechasChec').prop('checked','');
    });

	$('#tipoActividad').change(function(e){
		document.formTipoActividades.submit();
    });

	$('#formDetalleActividades').change(function(e){
		document.formDetalleActividades.submit();
    });
<?php
                        $cad='<option value="0">Todas las Actividades</option>';
	foreach ($coordinadores as  $value) {$cad=$cad.'<option value="'.$value->idPersona.'">'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';}
	echo('document.getElementById("selectCoordinadores").innerHTML=\''.$cad.'\';');
	
	if(isset($idPersonaCoordinador)){echo('document.getElementById("selectCoordinadores").value='.$idPersonaCoordinador.';');}
	if(isset($usuarioVendedor) && $usuarioVendedor!=""){echo('document.getElementById("usuarioVendedor").value="'.$usuarioVendedor.'";');}
               ?>
function cambioCoordinador(valor){
	muestraGif();
	var formulario=document.createElement('form'); 
	formulario.setAttribute('method','post'); formulario.action=<?php echo('"'.base_url().'monitores/verMonitor"'); ?>;
	var input1=document.createElement('input'); input1.setAttribute('type','hidden');input1.setAttribute('name','monitorear'); 
	input1.value='SemaforoActividades';
	var input2=document.createElement('input'); input2.setAttribute('type','hidden');input2.setAttribute('name','selectCoordinadores'); 
	input2.value=document.getElementById("selectCoordinadores").value;
	formulario.appendChild(input1);
	formulario.appendChild(input2);
	document.body.appendChild(formulario);
	formulario.submit();
}
function asignaEventos(){
	//document.body.addEventListener("onbeforeload",muestraGif());
}
function muestraGif(){
	document.getElementById('gifDeEspera').classList.add('verObjeto');
}
asignaEventos();
window.onbeforeunload =  muestraGif;
//monitorearDTA,mesActividadesDTA,filtroFechaDTA,fechaStartDTA,fechaEndDTA,usuarioVendedorDTA
//document.getElementById('monitorearDTA').value=document.getElementById('mesActividades').value;
document.getElementById('selectCoordinadoresDTA').value=document.getElementById('selectCoordinadores').value;
if(document.getElementById('filtroFechasChec').checked){
	document.getElementById('filtroFechaDTA').value=document.getElementById('filtroFechasChec').value;
}else{
document.getElementById('mesActividadesDTA').value=document.getElementById('mesActividades').value;

}

document.getElementById('fechaStartDTA').value=document.getElementById('fechaStart').value;
document.getElementById('fechaEndDTA').value=document.getElementById('fechaEnd').value;
document.getElementById('usuarioVendedorDTA').value=document.getElementById('usuarioVendedor').value;
</script>
<style type="text/css">
	.gifEspera{position: absolute;left: 50%;top:70%;}
	.ocultarObjeto{display: none}
	.verObjeto{display: block;}

</style>
<style>
.modal-btnCerrar{background-color:white;width:800px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
.verObjeto{display: block;}
.ocultarObjeto{display: none}
.formProspecto > label{color: black; text-decoration: underline;}

</style>
<script type="text/javascript">
/*CUANDO SE REQUIERA ABRIR O CERRAR*/   

function verMontosEndosos(datos,event){
	if(event!=''){event.preventDefault();}

//			console.log(parametros);
//			console.log(datos);
				
	if(datos==''){
		var parametros="?";
		if(document.getElementById('mesActividades').value!=''){
			
			parametros=parametros+'mesActividades='+document.getElementById('mesActividades').value;
			parametros=parametros+'&coordinador='+document.getElementById('selectCoordinadores').value;	     

			if(document.getElementById('usuarioVendedor').value!=''){
				parametros=parametros+' &usuarioVendedor='+document.getElementById('usuarioVendedor').value;	     
			}
			peticionAJAX('monitores/montosEndosos/',parametros,'verMontosEndosos');
		} else {
	 		alert('Tiene que escoger un mes');
		}
		
			console.log(parametros);
	} else {
		//  console.log(datos);
		var cantDatos=datos.montoCompanias.length;
		var tabla='<div style="height:400px; width:100%; overflow: scroll"><table border="2" ><thead style="background-color:#361866; color:white"><tr><td>Compania</td><td align="Center"> Endoso<br />Total </td><td align="Center"> Endoso<br />A </td><td align="Center"> Endoso<br />B </td><td align="Center"> Endoso<br />D </td><td align="Center"> Sin<br />Definir </td></tr></thead>';
		var total=0;
		
		for(var i=0;i<cantDatos;i++){
			tabla=tabla+'<tr><td>'+datos.montoCompanias[i].Promotoria+'</td><td align="Center">'+datos.montoCompanias[i].cantidad+'</td><td align="Center">'+datos.montoCompanias[i].cantidadA+'</td><td align="Center">'+datos.montoCompanias[i].cantidadB+'</td><td align="Center">'+datos.montoCompanias[i].cantidadD+'</td><td align="Center">'+datos.montoCompanias[i].cantidadS+'</td></tr>';
		}
			tabla=tabla+'</tbody><tfoot style="background-color:#361866; color:white"><tr><td>Total</td><td align="Center">'+datos.pieTabla.cantidad+'</td><td align="Center">'+datos.pieTabla.cantidadA+'</td><td align="Center">'+datos.pieTabla.cantidadB+'</td><td align="Center">'+datos.pieTabla.cantidadD+'</td><td align="Center">'+datos.pieTabla.cantidadS+'</td></tr>';
			tabla=tabla+'</table><div>';
          
			document.getElementById('divModalContenidoGenerico').innerHTML=tabla;
			
			cerrarModal('divModalGenerico');
	}       
}

function verMontosPorCompania(datos,event){
	if(event!=''){event.preventDefault();}
	
	   	        if(datos==''){
    	 var parametros="?";
      if(document.getElementById('mesActividades').value!=''){
    	 	parametros=parametros+'mesActividades='+document.getElementById('mesActividades').value;
    	 
         parametros=parametros+'&coordinador='+document.getElementById('selectCoordinadores').value;	     
         if(document.getElementById('usuarioVendedor').value!=''){
         	parametros=parametros+' &usuarioVendedor='+document.getElementById('usuarioVendedor').value;	     
         }
	     peticionAJAX('monitores/montosPorCompania/',parametros,'verMontosPorCompania');
	 }
	 else{
	 	alert('Tiene que escoger un mes');
	 }
        }	
        else{
        //  console.log(datos);
          var cantDatos=datos.montoCompanias.length;
          var tabla='<div style="height:400px; width:100%; overflow: scroll"><table border="2" ><thead style="background-color:#361866; color:white"><tr><td>Compania</td><td>Monto</td></tr></thead>';
          var total=0;
          for(var i=0;i<cantDatos;i++){
             tabla=tabla+'<tr><td>'+datos.montoCompanias[i].Promotoria+'</td><td align="right">$'+datos.montoCompanias[i].monto+'</td></tr>';
             //total=total+datos.montoCompanias[i].monto;
          }
          //tabla=tabla+'<tr><td>Total</td><td align="right">$'+total+'</td></tr>';
          tabla=tabla+'</tbody><tfoot style="background-color:#361866; color:white"><tr><td>Total</td><td align="right">$'+datos.pieTabla.monto+'</td></tr>';
          tabla=tabla+'</table><div>';
          
          document.getElementById('divModalContenidoGenerico').innerHTML=tabla;
          cerrarModal('divModalGenerico');
        }
        
}


function cerrarModal(modal){

     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
  //abreCierraEspera();
 
 req.open('GET', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
    	if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);
         
         switch(funcion){
         	case 'verMontosPorCompania':verMontosPorCompania(respuesta,'');break;
			
			case 'verMontosEndosos':verMontosEndosos(respuesta,'');break;
         }                                                           
      }     
   }
  };
   req.send();
}

//------------------------------------------------------------------------------------------------------------

	const baseUrl = '<?=base_url()?>monitores';

	$(document).ready(function() {
        getCompleteInformationActivities();

        $('input[name="check-search"]').click(function() {
        	let input = document.getElementsByName('input-search');
        	const val = this.value;
        	var active = "";
        	switch(val) {
        		case '1': active = "searchQuarterly"; break;
        		case '2': active = "searchMonth"; break;
        		case '3': active = ["searchDateI", "searchDateF"]; break;
        	}
        	for (let i=0;i<input.length;i++) {
        		const id = $(input[i]).attr('id');
        		if (typeof(active) != "object" && id == active || typeof(active) == "object" && id == active[0] || typeof(active) == "object" && id == active[1]) {
        			$(input[i]).prop('disabled',false);
        		}
        		else {
        			$(input[i]).prop('disabled',true);
        		}
        	}
        	if (val == 3) { $('#searchYear').prop('disabled',true); }
        	else { $('#searchYear').prop('disabled',false); }
        })
	})

	function getCompleteInformationActivities() {
		let check = document.getElementsByName('check-search');
		const quarter = document.getElementById('searchQuarterly').value;
		const month = document.getElementById('searchMonth').value;
		const dateI = document.getElementById('searchDateI').value;
		const dateF = document.getElementById('searchDateF').value;
		const year = document.getElementById('searchYear').value;
		var checked = 0;
		for (let i=0;i<check.length;i++) {
			if (check[i].checked) { checked = check[i].value; }
		}
		console.log("Tipo: "+checked+", Trimestre: "+quarter+", "+month+", FechaI: "+dateI+", FechaF: "+dateF+", Año: "+year);
    	$.ajax({
            type: "GET",
            url: `${baseUrl}/getCompleteInformationActivities`,
            data: {
            	ck: checked,
            	qr: quarter,
                mn: month,
                dI: dateI,
                dF: dateF,
                yr: year,
                rp: 1
            },
            beforeSend: (load) => {
            	/*$('body').addClass('obj-spinner-bar');
            	$('#LoadingSpinnerBar').removeClass('hidden');*/
            	$('#rsGeneral').text("0");
            	$('#rsTiposAct').text("0");
            	$('#btnSearch').prop('disabled',true);
            	$('#btnExportReport').prop('disabled',true);
            	$('#btnExportActP1').prop('disabled',true);
            	$('#btnExportActP2').prop('disabled',true);
                $('#RpG').css('height','450px');
                $('#RpR').css('height','450px');
                $('#RpG').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
                $('#RpR').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
                $('.cont-spinner-general').html(`
                    <div class="container-spinner-content-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },
            success: (data) => {
                //Es demasiada información que el proceso json_encode no puede procesar. Tener en cuenta cuando se maneja la tabla de `actividades`.
                const r = JSON.parse(data);
                console.log(r);
                $('.cont-spinner-general').html("");
                let dd = r['data'];
                let rs = r['result'];
                let rr = r['repeated'];
                const title = dd['mes'];
                //Tabla de Actividades
                getStructureTablesActvities(r['activities'],rs,title,rr);
                //Tabla General
                let title_g = [{[0]:title, [1]:"Reporte General de Actividades", [2]:"General"}];
                var table_g = getStructureTables(rs,'general',title_g[0]);
                //Tabla Repetidas
                let title_r = [{[0]:title, [1]:"Actividades Repetidas", [2]:"Repetidas"}];
                var table_r = getStructureTables(rr,'repetidas',title_r[0]);
                //
                $('#RpG').css('height','');
                $('#RpR').css('height','');
                $('#RpG').html(table_g);
                $('#RpR').html(table_r);
                $('#btnSearch').prop('disabled',false);
            	$('#btnExportReport').prop('disabled',false);
                $('#btnExportActP1').prop('disabled',false);
            	$('#btnExportActP2').prop('disabled',false); 
                $('.selectedMonth').text('- '+dd['mes']);
                $('#rsGeneral').text(rs.length);
                //
                $('.ck').val(dd['checked']);
                $('.qr').val(dd['quarter']);
                $('.mn').val(dd['month']);
                $('.dI').val(dd['dateI']);
                $('.dF').val(dd['dateF']);
                $('.yr').val(dd['year']);
        		//-->Obtener conteo de resultados por tablas
        		$('input[name="filter-input"]').keyup();
        		//-->Mostrar/Ocultar columnas
        		$('input[name="check-input"]').click(function() {
        			const table = $(this).data('table');
        			let columns = $('#'+table).find('tr td[data-field="'+this.value+'"]');
        			//console.log(table, this.value, this.checked, columns);
        			if (!this.checked) {
        				$('#'+table+' tr th[data-field="'+this.value+'"]').addClass('ocultarObjeto');
        				$('#'+table+' tr td[data-field="'+this.value+'"]').addClass('ocultarObjeto');
        			}
        			else {
        				$('#'+table+' tr th[data-field="'+this.value+'"]').removeClass('ocultarObjeto');
        				$('#'+table+' tr td[data-field="'+this.value+'"]').removeClass('ocultarObjeto');
        			}
        		})
            },
            error: (error) => {
                console.log(error);
                $('#btnSearch').prop('disabled',false);
            }
        })
    }

    function getStructureTables(rs,clase,title) {
    	var table = get_container_table(clase,title);
    	if (rs != 0) {
    		for (const a in rs) {
        		let add = {};
        		var ramo = (rs[a].ramoActividad.includes('_')) ? rs[a].ramoActividad.replace(/[_]/g, " ") : rs[a].ramoActividad;
        		table += `
        			<tr class="show-${clase}" data-indicator="${rs[a].IdInterno}" data-sub="info-${clase}">
        				<td data-field="0">${getTextValue(rs[a].IdInterno)}</td>
        				<td data-field="1">${getTextValue(rs[a].folioActividad)}</td>
        				<td data-field="2">${getTextValue(rs[a].idSicas)}</td>
        				<td data-field="3">${getTextValue(rs[a].NumSolicitud)}</td>
        				<td data-field="4">${getTextValue(rs[a].Documento)}</td>
        				<td data-field="5">${getTextValue(rs[a].Status)}</td>
        				<td data-field="6">${getTextValue(rs[a].Status_Txt)}</td>
        				<td data-field="7">${getTextValue(rs[a].tipoActividadSicas)}</td>
        				<td data-field="8">${getTextValue(rs[a].idCliente)}</td>
        				<td data-field="9">${getTextValue(rs[a].nombreCliente)}</td>
        				<td data-field="10">${getTextValue(rs[a].tipoActividad)}</td>
        				<td data-field="11">${ramo}</td>
        				<td data-field="12">${getTextValue(rs[a].subRamoActividad)}</td>
        				<td data-field="13">${getTextValue(rs[a].actividadUrgente_Txt)}</td>
        				<td data-field="14">${getTextValue(rs[a].usuarioCreacion)}</td>
        				<td data-field="15">${getTextValue(rs[a].usuarioVendedor)}</td>
        				<td data-field="16">${getTextValue(rs[a].usuarioResponsable)}</td>
        				<td data-field="17">${getTextValue(rs[a].usuarioBolita)}</td>
        				<td data-field="18">${getTextValue(rs[a].usuarioBloqueo)}</td>
        				<td data-field="19">${getTextValue(rs[a].usuarioCotizador)}</td>
        				<td data-field="20">${getTextValue(rs[a].nombreUsuarioCreacion)}</td>
        				<td data-field="21">${getTextValue(rs[a].nombreVendedor)}</td>
        				<td data-field="22">${getTextValue(rs[a].nombreUsuarioResponsable)}</td>
        				<td data-field="23">${getTextValue(rs[a].nombreUsuarioCotizador)}</td>
        				<td data-field="24">${getDateFormat(rs[a].fechaCreacion,2)}</td>
        				<td data-field="25">${getTextValue(rs[a].satisfaccion)}</td>
        				<td data-field="26">${getTextValue(rs[a].satisfaccionEmision)}</td>
        				<td data-field="27">${getTextValue(rs[a].name_complete)}</td>
        				<td data-field="28">${getTextValue(rs[a].tipoEndoso)}</td>
        				<td data-field="29">${getTextValue(rs[a].poliza)}</td>
        				<td data-field="30">${getTextValue(rs[a].datosExpres)}</td>
        			</tr>
        		`;
        	}
        }
        else {
        	table += `<tr><td colspan="31"><center><strong>Sin resultados</strong><center></td></tr>`;
        }
        table += `</tbody></table></div></div>`;
        return table;
    }

    function getStructureTablesActvities(ac,r,month,rp) {
    	let sc = ac['tabs'];
    	let rm = ac['ramos'];
    	let count = [];
        var num = 0;
        var ul = `<ul class="nav nav-tabs nav-light">`;
        var tab = ``;
    	for (const a in sc) {
    		var active = (num == 0) ? "active" : "";
    		var name = sc[a];
    		var select_menu = ``;
    		num++;
    		if (a == 1 || a == 2) { name = "Por " + sc[a]; }
    		if (a == 1) {
    			select_menu += `<div class="col-md-12 column-flex-center-start"><label class="textForm mg-right">Ir a:</label><div class="col-md-12 tab-items" id="contBtnRamos" style="padding: 0px;">`;
    			for (const m in rm) {
    				select_menu += `
						<a class="btn btn-menu-vendedor" id="btnVnRm${rm[m].IDRamo}" href="#contTableActRm${rm[m].IDRamo}" title="Folios encontrados">${rm[m].Nombre} <span class="text-rs-vn" id="rsVnRm${rm[m].IDRamo}"></span></a>`;
    			}
    			select_menu += `</div></div>`;  			
    		}
    		ul += `<li class="nav-item"><a class="nav-tab-link ${active}" aria-current="page" href="#Act${num}" role="tab" data-toggle="tab">${name}</a></li>`;
    		tab += `
    			<div class="col-md-12 tab-pane pd-left pd-right ${active}" id="Act${num}">`;
    		switch(sc[a]) {
    			case 'Total':
    				tab += getTableTotal(ac,r,rp,month);
    				tab += getTableVendedor(ac,r,month);
    			break;
    			case 'Ramos':
    				tab += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${select_menu}</div>`;
    				let result = getTableRamos(ac,r,month);
    				tab += result[0];
    				count = result[1];
    			break;
    			case 'Actividades': tab += getTableClasificacion(ac,r,month); break;
    			case 'Resumen': tab += getTableResumen(ac,r,month); break;
    		}
    		//tab += getTableResumen(ac,r,month);
    		tab += `</div>`;
    	}
    	ul += `</ul>`;
    	//Mostrar la información
    	$('#tabsTablesActivities').css('height','');
    	$('#navTablesActivities').html(ul);
    	$('#tabsTablesActivities').html(tab);
    	//Funciones adicionales
    	//-->Seleccionar al vendedor en la tabla por ramos
    	$('tr[name="vendedor"]').click(function() {
       		$('tr[name="vendedor"]').removeClass('selected-vend');
        	const val = $(this).data('index');
        	$('tr[name="vendedor"][data-index="'+val+'"]').addClass('selected-vend');
        })
        //-->Obtener conteo de resultados para los botones
        for (let i=0;i<count.length;i++) {
        	if (count[i].total != 0) {
       			$('#rsVnRm'+count[i].IDRamo).text("("+count[i].total+")");
       		}
       		else {
       			//Buscar poder eliminar la direccion de los "a" cuando se da click a un boton de este tipo
       			$('#contTableActRm'+count[i].IDRamo).parent().remove();
       			$('#btnVnRm'+count[i].IDRamo).remove();
       		}
        }
        if ($('#contBtnRamos').html() == 0) {
        	$('#contBtnRamos').html(`<div class="col-md-12"><center><strong>Sin resultados</strong></center></div>`);
        }
    }

    function getTableTotal(ac,r,rp,month) {
    	let fl = ac['folios'];
        let tags = ["Captura Emision", "Cotizacion", "Cotizacion & Emision", "Emisiones", "Sustitucion"];
    	let folios = [];
    	var table = get_container_table('total',month);
        //Total
       	var capt_t = 0;
       	var cotz_t = 0;
       	var emsn_t = 0;
       	var sust_t = 0;
       	var cotz_emsn = 0;
       	var capt_u = 0;
       	var cotz_u = 0;
       	var emsn_u = 0;
       	var sust_u = 0;
       	var cotz_emsn_u = 0;
        for (const a in r) {
        		const folioActividad = r[a].folioActividad;
        		switch(r[a].tipoActividad) {
        			case 'CapturaEmision':
        				capt_t++;
        				rp.forEach((e) => {
        					if (e.folioActividad == folioActividad) { capt_u++; }
        				})
        			break;
        			case 'Cotizacion':
        				cotz_t++;
        				folios.push({folioActividad});
        				rp.forEach((e) => {
        					if (e.folioActividad == folioActividad) { cotz_u++; }
        				})
        			break;
        			case 'Emision':
        				var exist = 0;
        				folios.forEach((e) => {
           					if (e.folioActividad == folioActividad) {
           						cotz_emsn++;
        						cotz_t--;
        						exist = 1;
           					}
          				})
        				if (exist != 1) { emsn_t++; }
        				rp.forEach((e) => {
        					if (e.folioActividad == folioActividad && exist != 1) { emsn_u++; }
        					else if (e.folioActividad == folioActividad && exist == 1) { cotz_emsn_u++; }
        				})
        			break;
        			case 'Sustitucion':
        				sust_t++;
        				rp.forEach((e) => {
        					if (e.folioActividad == folioActividad) { sust_u++; }
        				})
        			break;
        		}
        }
        //
        for (let i=0;i<tags.length;i++) {
        	var value = "";
        	var unique = 0; //Valor único
        	switch(tags[i]) {
        		case 'Captura Emision': value = capt_t; unique = capt_t - capt_u; break;
        		case 'Cotizacion': value = cotz_t; unique = cotz_t - cotz_u; break;
        		case 'Cotizacion & Emision': value = cotz_emsn; unique = cotz_emsn - cotz_emsn_u; break;
        		case 'Emisiones': value = emsn_t; unique = emsn_t - emsn_u; break;
        		case 'Sustitucion': value = sust_t; unique = sust_t - sust_u; break;
        	}
        	table += `<tr class="show-total"><td data-field="0">${tags[i]}</td><td data-field="1">${value}</td><td data-field="2">${unique}</td></tr>`;
        }
        table += `</tbody><tfoot class="position-footer-table rs-total"><tr><td>Total General</td><td class="text-b">0</td><td class="text-b">0</td></tr></tfoot></table></div></div>`;
        $('#rsTiposAct').text(fl.length);
        return table;
    }

    function getTableVendedor(ac,r,month) {
    	let vn = ac['vend'];
    	let rm = ac['ramos'];
        var table = get_container_table('vendedor',month);
       	//Vendedor
       	var num = 0;
        for (const v in vn) {
       		let add = {};
       		let folios = [];
       		var capt = 0;
       		var cotz = 0;
       		var cotz_emsn = 0;
       		var emsn = 0;
       		var sust = 0;
       		var total = 0;
        	var num_ = 0;
        	var trtd = `<tr class="info-vend${v} table-sub-tr ocultarObjeto"><td>N°</td><td>IdInterno</td><td>Folio Actividad</td><td>Num. Solicitud</td><td>Documento</td><td>Póliza</td><td>Tipo Actividad Sicas</td><td>Tipo Actividad</td><td>Ramo</td></tr>`;
        	var tr = ``;
       		for (const a in r) {
       			const folioActividad = r[a].folioActividad;
       			var ramo = (r[a].ramoActividad.includes('_')) ? r[a].ramoActividad.replace(/[_]/g, " ") : r[a].ramoActividad;
       			if (r[a].nombreVendedor == vn[v]) {
       				switch(r[a].tipoActividad) {
        				case 'CapturaEmision': capt++; break;
        				case 'Cotizacion': cotz++; folios.push({folioActividad});  break;
        				case 'Emision':
        					var exist = 0;
        					folios.forEach((e) => {
            					if (e.folioActividad == folioActividad) {
            						cotz_emsn++;
        							cotz--;
        							exist = 1;
            					}
          					})
        					if (exist != 1) { emsn++; }
        				break;
        				case 'Sustitucion': sust++; break;
       				}
       				
       				if (r[a].tipoActividad == 'CapturaEmision' || r[a].tipoActividad == 'Cotizacion' || r[a].tipoActividad == 'Emision' || r[a].tipoActividad == 'Sustitucion') {
       					num_++;
       					tr += `
       						<tr class="info-vend${v} ocultarObjeto" style="background: #e9f2f2;">
        						<td data-field="0">${num_}</td>
        						<td data-field="1">${r[a].IdInterno}</td>
        						<td data-field="2">${r[a].folioActividad}</td>
        						<td data-field="3">${getTextValue(r[a].NumSolicitud)}</td>
        						<td data-field="4">${getTextValue(r[a].Documento)}</td>
        						<td data-field="5">${getTextValue(r[a].poliza)}</td>
        						<td data-field="6">${getTextValue(r[a].tipoActividadSicas)}</td>
        						<td data-field="7">${getTextValue(r[a].tipoActividad)}</td>
        						<td data-field="8">${ramo}</td>
        					</tr>
       					`;
       				}
       			}
       			total = capt + cotz + emsn + sust + cotz_emsn;
       		}
       		capt = (capt != 0) ? capt : "";
       		cotz = (cotz != 0) ? cotz : "";
       		cotz_emsn = (cotz_emsn != 0) ? cotz_emsn : "";
       		emsn = (emsn != 0) ? emsn : "";
       		sust = (sust != 0) ? sust : "";
       		num++;
       		if (tr == 0) {
       			tr = `<tr class="info-vend${v} ocultarObjeto" style="background: #e9f2f2;"><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
       		}
        	table += `
        		<tr class="show-vend">
        			<td data-field="0"><button class="btn-function" onclick="openContainerTable(this,'info-vend${v}')"><i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i></button></td>
        			<td data-field="1">${num}</td>
        			<td data-field="2">${vn[v]}</td>
        			<td data-field="3">${capt}</td>
        			<td data-field="4">${cotz}</td>
        			<td data-field="5">${cotz_emsn}</td>
        			<td data-field="6">${emsn}</td>
        			<td data-field="7">${sust}</td>
        			<td class="rs-total-v2" data-field="8"><b>${total}</b></td>
        		</tr>${trtd += tr}
        	`;
       	}
       	if (vn == 0) { table += `<tr style="background: #e9f2f2;"><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`; }
        table += `</tbody><tfoot class="position-footer-table rs-total"><tr><td data-field="0"></d><td data-field="1"></td><td data-field="2"><strong>TOTAL</strong></td><td data-field="3" class="text-b">0</td><td data-field="4" class="text-b">0</td><td data-field="5" class="text-b">0</td><td data-field="6" class="text-b">0</td><td data-field="7" class="text-b">0</td><td data-field="8" class="text-b">0</td></tr></tfoot></table></div></div>`;
        return table;
    }

    function getTableRamos(ac,r,month) {
    	let fl = ac['folios'];
    	let vn = ac['vend'];
    	let rm = ac['ramos'];
    	let count = [];
    	var table = ``;
    	for (m in rm) {
    		const IDRamo = rm[m].IDRamo;
    		const Nombre = rm[m].Nombre;
    		let ramo = [{[0]:IDRamo, [1]:Nombre}];
        	table += get_container_table('ramo',month,ramo[0]);
       		var capt_t = 0;
       		var cotz_t = 0;
       		var cotz_emsn_t = 0;
       		var emsn_t = 0;
       		var sust_t = 0;
        	var total_t = 0;
       		var num = 0;
       		for (const v in vn) {
       			let add = {};
       			let folios = [];
       			var capt = 0;
       			var cotz = 0;
       			var cotz_emsn = 0;
       			var emsn = 0;
       			var sust = 0;
       			var total = 0;
        		var num_ = 0;
        		var trtd = `<tr class="info-vend${v}-ramo${rm[m].IDRamo} table-sub-tr ocultarObjeto"><td>N°</td><td>IdInterno</td><td>Folio Actividad</td><td>Num. Solicitud</td><td>Documento</td><td>Póliza</td><td>Tipo Actividad Sicas</td><td>Tipo Actividad</td><td>Fecha</td></tr>`;
        		var tr = ``;
       			for (const a in r) {
       				if (r[a].nombreVendedor == vn[v] && r[a].ramoActividad == rm[m].Abreviacion || r[a].nombreVendedor == vn[v] && r[a].ramoActividad == 0 && rm[m].IDRamo == "0") {
       					const folioActividad = r[a].folioActividad;
       					switch(r[a].tipoActividad) {
        					case 'CapturaEmision': capt++; capt_t++; break;
        					case 'Cotizacion': cotz++; cotz_t++; folios.push({folioActividad}); break;
        					case 'Emision':
        						var exist = 0;
        						folios.forEach((e) => {
            						if (e.folioActividad == folioActividad) {
            							cotz_emsn++; cotz_emsn_t++;
        								cotz--; cotz_t--;
        								exist = 1;
            						}
          						})
        					if (exist != 1) { emsn++; emsn_t++; }
        					break;
        					case 'Sustitucion': sust++; sust_t++; break;
       					}
       					if (r[a].tipoActividad == 'CapturaEmision' || r[a].tipoActividad == 'Cotizacion' || r[a].tipoActividad == 'Emision' || r[a].tipoActividad == 'Sustitucion') {
       						num_++;
       						tr += `
       							<tr class="info-vend${v}-ramo${rm[m].IDRamo} ocultarObjeto" style="background: #e9f2f2;">
        							<td data-field="0">${num_}</td>
        							<td data-field="1">${r[a].IdInterno}</td>
        							<td data-field="2">${r[a].folioActividad}</td>
        							<td data-field="3">${getTextValue(r[a].NumSolicitud)}</td>
        							<td data-field="4">${getTextValue(r[a].Documento)}</td>
        							<td data-field="5">${getTextValue(r[a].poliza)}</td>
        							<td data-field="6">${getTextValue(r[a].tipoActividadSicas)}</td>
        							<td data-field="7">${getTextValue(r[a].tipoActividad)}</td>
        							<td data-field="8">${getDateFormat(r[a].fechaCreacion,2)}</td>
        						</tr>
       						`;
       					}
       				}
       				total = capt + cotz + emsn + sust + cotz_emsn;
       			}
       			if (tr == 0) {
       				tr = `<tr class="info-vend${v}-ramo${rm[m].IDRamo} ocultarObjeto" style="background: #e9f2f2;"><td colspan="9"><center><strong>Sin resultados</strong><center></td></tr>`;
       			}
       			else if (rm[m].IDRamo == "0" && tr != 0 || rm[m].IDRamo != 0) {
       				total_t = capt_t + cotz_t + emsn_t + sust_t + cotz_emsn_t;
       				capt = (capt != 0) ? capt : "";
       				cotz = (cotz != 0) ? cotz : "";
       				cotz_emsn = (cotz_emsn != 0) ? cotz_emsn : "";
       				emsn = (emsn != 0) ? emsn : "";
       				sust = (sust != 0) ? sust : "";
       				num++;
        			table += `
        				<tr class="show-ramo${rm[m].IDRamo}" name="vendedor" data-index="${v}">
        					<td data-field="0"><button class="btn-function" onclick="openContainerTable(this,'info-vend${v}-ramo${rm[m].IDRamo}')"><i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i></button></td>
        					<td data-field="1">${num}</td>
        					<td data-field="2">${vn[v]}</td>
        					<td data-field="3">${capt}</td>
        					<td data-field="4">${cotz}</td>
        					<td data-field="5">${cotz_emsn}</td>
        					<td data-field="6">${emsn}</td>
        					<td data-field="7">${sust}</td>
        					<td class="rs-total-v2" data-field="8"><b>${total}</b></td>
        				</tr>${trtd += tr}
        			`;
        		}
       		}
       		table += `</tbody><tfoot class="position-footer-table rs-total"><tr></tr><td data-field="0"></td><td data-field="1"></td><td data-field="2"><strong>TOTAL</strong></td><td data-field="3" class="text-b">0</td><td data-field="4" class="text-b">0</td><td data-field="5" class="text-b">0</td><td data-field="6" class="text-b">0</td><td data-field="7" class="text-b">0</td><td data-field="8" class="text-b">0</td></tr></tfoot></table></div></div>`;
       		//
       		let add = {};
       		add['IDRamo'] = rm[m].IDRamo;
       		add['total'] = total_t;
       		count.push(add);
       	}
       	let data = [{[0]:table, [1]:count}];
       	return data[0];
    }

    function getTableClasificacion(ac,r,month) {
    	let fl = ac['folios'];
        var table = get_container_table('actividad',month);
       	var num = 0;
        for (const f in fl) {
       		let add = {};
       		let folios = [];
       		var capt = "";
       		var cotz = "";
       		var cotz_emsn = "";
       		var emsn = "";
       		var sust = "";
       		var mov = "";
        	var num_ = 0;
       		for (const a in r) {
       			const folioActividad = r[a].folioActividad;
       			var ramo = (r[a].ramoActividad.includes('_')) ? r[a].ramoActividad.replace(/[_]/g, " ") : r[a].ramoActividad;
       			if (folioActividad == fl[f]) {
       				mov = r[a].tipoActividad;
       				switch(r[a].tipoActividad) {
        				case 'CapturaEmision': capt = folioActividad; break;
        				case 'Cotizacion': cotz = folioActividad; folios.push({folioActividad}); break;
        				case 'Emision':
        					var exist = 0;
        					folios.forEach((e) => {
            					if (e.folioActividad == folioActividad) {
            						cotz_emsn = folioActividad;
        							cotz = "";
        							exist = 1;
        							mov = "Cotizacion & Emision";
            					}
          					})
        					if (exist != 1) { emsn = folioActividad; }
        				break;
        				case 'Sustitucion': sust = folioActividad; break;
       				}
       			}
       		}
       		if (mov != 0 && mov != "AclaraciondeComision" && mov != "CambiodeConducto" && mov != "Cancelacion" && mov != "Endoso") {
       			num++;
        		table += `
        			<tr class="show-actividad select-activity">
        				<td data-field="0">${num}</td>
        				<td data-field="1">${capt}</td>
        				<td data-field="2">${cotz}</td>
        				<td data-field="3">${cotz_emsn}</td>
        				<td data-field="4">${emsn}</td>
        				<td data-field="5">${sust}</td>
        				<td data-field="6" class="text-b">${mov}</td>
        			</tr>
        		`;
        	}
       	}
       	if (fl == 0) { table += `<tr style="background: #e9f2f2;"><td colspan="7"><center><strong>Sin resultados</strong><center></td></tr>`; }
        table += `</tbody><tfoot class="position-footer-table rs-total"><tr></td><td data-field="0"><strong>TOTAL</strong></td><td data-field="1" class="text-b">0</td><td data-field="2" class="text-b">0</td><td data-field="3" class="text-b">0</td><td data-field="4" class="text-b">0</td><td data-field="5" class="text-b">0</td><td data-field="6" class="rs-total-v2 text-b">0</td></tr></tfoot></table></div></div>`;
        return table;
    }

    function getTableResumen(ac,r,month) {
    	let fl = ac['folios'];
    	var table = get_container_table('resumen',month);
        var num = 0;
        //Resumen
        for (const f in fl) {
        	let add_r = {};
        	var comm = 0;
        	var cond = 0;
        	var canc = 0;
        	var capt = 0;
        	var cotz = 0;
        	var emsn = 0;
        	var ends = 0;
        	var sust = 0;
        	var empty = 0;
        	var total = 0;
        	var num_ = 0;
    		var trtd = `<tr class="info-resumen${fl[f]} table-sub-tr ocultarObjeto"><td>N°</td><td>IdInterno</td><td>Folio Actividad</td><td>Num. Solicitud</td><td>Documento</td><td>Póliza</td><td>Estatus</td><td>Tipo Actividad Sicas</td><td>Tipo Actividad</td><td>Tipo Endoso</td><td>Ramo</td><td>Vendedor</td><td>Fecha</td></tr>`;
        	for (const a in r) {
        		var ramo = (r[a].ramoActividad.includes('_')) ? r[a].ramoActividad.replace(/[_]/g, " ") : r[a].ramoActividad;
        		if (r[a].folioActividad == fl[f]) {
        			if (r[a].tipoActividad != 0) {
        				switch(r[a].tipoActividad) {
        					case 'AclaraciondeComision': comm++; break;
        					case 'CambiodeConducto': cond++; break;
        					case 'Cancelacion': canc++; break;
        					case 'CapturaEmision': capt++; break;
        					case 'Cotizacion': cotz++; break;
        					case 'Emision': emsn++; break;
        					case 'Endoso': ends++; break;
        					case 'Sustitucion': sust++; break;
        				}
        			}
        			else { empty++; }
        			total = comm + cond + canc + capt + cotz + emsn + ends + sust + empty;
        			//console.log(fl[f], r[a].IdInterno);
        			num_++;
        			trtd += `
        				<tr class="info-resumen${fl[f]} ocultarObjeto" style="background: #e9f2f2;">
        					<td data-field="0">${num_}</td>
        					<td data-field="1">${r[a].IdInterno}</td>
        					<td data-field="2">${r[a].folioActividad}</td>
        					<td data-field="3">${getTextValue(r[a].NumSolicitud)}</td>
        					<td data-field="4">${getTextValue(r[a].Documento)}</td>
        					<td data-field="5">${getTextValue(r[a].poliza)}</td>
        					<td data-field="6">${getTextValue(r[a].Status_Txt)}</td>
        					<td data-field="7">${getTextValue(r[a].tipoActividadSicas)}</td>
        					<td data-field="8">${getTextValue(r[a].tipoActividad)}</td>
        					<td data-field="9">${getTextValue(r[a].tipoEndoso)}</td>
        					<td data-field="10">${ramo}</td>
        					<td data-field="11">${getTextValue(r[a].nombreVendedor)}</td>
        					<td data-field="12">${getDateFormat(r[a].fechaCreacion,2)}</td>
        				</tr>
        			`;
        		}
        	}
        	num++;
        	comm = (comm != 0) ? comm : "";
        	cond = (cond != 0) ? cond : "";
        	canc = (canc != 0) ? canc : "";
        	capt = (capt != 0) ? capt : "";
        	cotz = (cotz != 0) ? cotz : "";
        	emsn = (emsn != 0) ? emsn : "";
        	ends = (ends != 0) ? ends : "";
        	sust = (sust != 0) ? sust : "";
        	empty = (empty != 0) ? empty : "";

        	table += `
        		<tr class="show-resumen" data-indicator="${fl[f]}" data-sub="info-resumen">
        			<td data-field="0"><button class="btn-function" onclick="openContainerTable(this,'info-resumen${fl[f]}')"><i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i></button></td>
        			<td data-field="1">${num}</td>
        			<td data-field="2">${fl[f]}</td>
        			<td data-field="3">${comm}</td>
        			<td data-field="4">${cond}</td>
        			<td data-field="5">${canc}</td>
        			<td data-field="6">${capt}</td>
        			<td data-field="7">${cotz}</td>
        			<td data-field="8">${emsn}</td>
        			<td data-field="9">${ends}</td>
        			<td data-field="10">${sust}</td>
        			<td data-field="11">${empty}</td>
        			<td class="rs-total-v2" data-field="12"><b>${total}</b></td>
        		</tr>${trtd}
        	`;
        }
        if (fl == 0) { table += `<tr style="background: #e9f2f2;"><td colspan="13"><center><strong>Sin resultados</strong><center></td></tr>`; }
        table += `</tbody><tfoot class="position-footer-table rs-total"><tr><td data-field="0"></td><td data-field="1"></td><td data-field="2"><strong>TOTAL</strong></td><td data-field="3" class="text-b">0</td><td data-field="4" class="text-b">0</td><td data-field="5" class="text-b">0</td><td data-field="6" class="text-b">0</td><td data-field="7" class="text-b">0</td><td data-field="8" class="text-b">0</td><td data-field="9" class="text-b">0</td><td data-field="10" class="text-b">0</td><td data-field="11" class="text-b">0</td><td data-field="12" class="text-b">0</td></tr></tfoot></table></div></div>
        `;
        
        return table;
    }

    function getExportTable(table,clase) {
    	let data_ = getDataTableForExport(table,clase);
    	const search = $('#selectedMonth');
    	var title = "";
    	var month = search.text().replace(" ","");
    	month = month.replace("-","");
    	month = month.substring(0,3);
    	console.log(month);
        switch(table) {
        	case 'TableTotalAct': title = "Total"; break;
        	case 'TableVendedorAct': title = "Vendedor"; break;
        	case 'TableActividadAct': title = "Movimiento"; break;
        	case 'TableResumenAct': title = "Resumen"; break;
        	default: title = "Ramo"; break;
        }
        const title_f = title + "("+month+")";
        console.log(title);
    	$.ajax({
            type: "POST",
            url: `${baseUrl}/exportTableActivities`,
            data: {
            	tt: title,
            	tf: title_f,
                d_h: data_[0],
                d_b: data_[1]
            },
            beforeSend: (load) => {
            	$('#btnExport'+table).html(`
            		<div class="container-spinner-btn-loading">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
            	`);
            },
            success: (data) => {
                var r = JSON.parse(data);
                console.log(r);
              	var exportFile = $("<a>");
              	exportFile.attr("href",r['data']);
              	$("body").append(exportFile);
              	exportFile.attr("download",r['title']);
              	exportFile[0].click();
              	exportFile.remove();
              	$('#btnExport'+table).html(`<i class="fas fa-download"></i>`);
            },
            error: (error) => {
                console.log(error);
            }            
        })
    }

    function getExportTablesPart1() {
    	let t_Total = getDataTableForExport('TableTotalAct','show-total',1);
        let t_Vend = getDataTableForExport('TableVendedorAct','show-vend',1);
        let t_totales = [t_Total, t_Vend];
        //console.log(t_totales);
        $.ajax({
            type: "POST",
            url: `${baseUrl}/exportActivitiesPart1`,
            data: {
                t1: t_totales
            },
            beforeSend: (load) => {
            	//$('#btnExportActP2').html();
            },
            success: (data) => {
                var r = JSON.parse(data);
                //console.log(r);
              	var exportFile = $("<a>");
              	exportFile.attr("href",r['data']);
              	$("body").append(exportFile);
              	exportFile.attr("download",r['title']);
              	exportFile[0].click();
              	exportFile.remove();
            },
            error: (error) => {
                console.log(error);
            }            
        });
    }

    function getDataTableForExport(table,clase,type = 0) {
    	let th = $('#'+table).find('thead tr:nth-child(3) th');
        let tr = $('#'+table).find('tbody tr.'+clase);
        let ft = $('#'+table).find('tfoot tr');
        let header = [];
        let body = [];
        var title = "";
        for (let i=0;i<th.length;i++) {
        	if (table != "TableTotalAct" && table != "TableActividadAct") {
    			if (i == 0) { continue; }
    			if (type == 1) {  if (i == 1) { continue; } }
    		}
        	if (type == 1 || type == 0 && !$(th[i]).hasClass('ocultarObjeto')) {
        		var val = $(th[i]).text();
        		header.push(val);
        	}
        }
        for (let i=0;i<tr.length;i++) {
        	if ($(tr[i]).css('display') != "none" || type == 1) {
        		let val = [];
        		let td = $(tr[i]).find('td');
        		for (let j=0;j<td.length;j++) {
        			if (table != "TableTotalAct" && table != "TableActividadAct") {
    					if (j == 0) { continue; }
    					if (type == 1) {  if (j == 1) { continue; } }
    				}
        			if (type == 0 && !$(td[j]).hasClass('ocultarObjeto') || type == 1) {
        				var value = $(td[j]).text();
        				val.push(value);
        			}
        		}
        		body.push(val);
        	}
        }
        for (let i=0;i<ft.length;i++) {
        	let val = [];
        	let td = $(ft[i]).find('td');
        	for (let j=0;j<td.length;j++) {
        		if (table != "TableTotalAct" && table != "TableActividadAct") {
    				if (j == 0) { continue; }
    				if (type == 1) {  if (j == 1) { continue; } }
    			}
        		if (type == 1 || type == 0 && !$(td[j]).hasClass('ocultarObjeto')) {
        			var value = $(td[j]).text();
        			val.push(value);
        		}
        	}
        	body.push(val);
        }
        let data = [{[0]:header, [1]:body}];
        //console.log(data[0]);
        return data[0];
    }

    function get_container_table(table,title,ramo = null) {
    	var div = ``;
    	switch(table) {
    		case 'total':
    			div += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${get_btn_filter_table('TableTotalAct','show-total',1)}<div class="col-md-12 container-table" id="contTableTotalAct"><table class="table table-striped" id="TableTotalAct"><thead class="table-thead"><tr class="table-tr"><th colspan="3" class="title-table">${title}</th></tr><tr class="table-tr"><th colspan="3" class="title-table">Conteo Total de Actividades</th></tr><tr class="table-tr"><th>Etiquetas</th><th>Cantidad de Folios</th><th>Folios Únicos</th></tr></thead><tbody id="bodyTableTotalAct">`;
    		break;
    		case 'vendedor':
    			div += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${get_btn_filter_table('TableVendedorAct','show-vend',1,'vendedor')}<div class="col-md-12 container-table" id="contTableVendedorAct"><table class="table" id="TableVendedorAct"><thead class="table-thead"><tr class="table-tr"><th colspan="9" class="title-table">${title}</th></tr><tr class="table-tr"><th colspan="9" class="title-table">Actividades Por Vendedor</th></tr><tr class="table-tr"><th data-field="0">Detalles</th><th data-field="1">N°</th><th data-field="2">Vendedor</th><th data-field="3">Captura Emision</th><th data-field="4">Cotizacion</th><th data-field="5">Cotizacion & Emision</th><th data-field="6">Emisiones</th><th data-field="7">Sustitucion</th><th data-field="8">Total</th><tr></thead><tbody id="bodyTableVendedorAct">`;
    		break;
    		case 'ramo':
    			div += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${get_btn_filter_table(`TableActRm${ramo[0]}`,`show-ramo${ramo[0]}`,1)}<div class="col-md-12 container-table" id="contTableActRm${ramo[0]}"><table class="table" id="TableActRm${ramo[0]}"><thead class="table-thead"><tr class="table-tr"><th colspan="9" class="title-table">Actividades Vendedor (${title}) - ${ramo[1]}</th></tr><tr class="table-tr"><tr class="table-tr"><th data-field="0">Detalles</th><th data-field="1">N°</th><th data-field="2">Vendedor</th><th data-field="3">Captura Emision</th><th data-field="4">Cotizacion</th><th data-field="5">Cotizacion & Emision</th><th data-field="6">Emisiones</th><th data-field="7">Sustitucion</th><th data-field="8">Total</th><tr></thead><tbody id="bodyTableActRm${ramo[0]}">`;
    		break;
    		case 'actividad':
    			const select = `<select class="form-control input-sm" id="selectMov" onchange="filterFieldSelected(this,'bodyTableActividadAct','show-actividad')"><option value=""></option><option value="CapturaEmision">CapturaEmision</option><option value="Cotizacion">Cotizacion</option><option value="Cotizacion & Emision">Cotizacion & Emision</option><option value="Emision">Emisiones</option><option value="Sustitucion">Sustitucion</option></select>`;
    			div += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${get_btn_filter_table('TableActividadAct','show-actividad',0,'actividad')}<div class="col-md-12 container-table" id="contTableActividadAct"><table class="table" id="TableActividadAct"><thead class="table-thead"><tr class="table-tr"><th colspan="8" class="title-table">${title}</th></tr><tr class="table-tr"><th colspan="8" class="title-table">Folios por Actividad</th></tr><tr class="table-tr"><th data-field="0">N°</th><th data-field="1">Captura Emision</th><th data-field="2">Cotizacion</th><th data-field="3">Cotizacion & Emision</th><th data-field="4">Emisiones</th><th data-field="5">Sustitucion</th><th data-field="6"><span>Tipo de Movimiento</span>${select}</th><tr></thead><tbody id="bodyTableActividadAct">`;
    		break;
    		case 'resumen':
    			div += `<div class="col-md-12 segment-table" style="margin-bottom: 20px;">${get_btn_filter_table('TableResumenAct','show-resumen',0,'resumen')}<div class="col-md-12 container-table" id="contTableResumenAct"><table class="table" id="TableResumenAct"><thead class="table-thead"><tr class="table-tr"><th colspan="13" class="title-table">${title}</th></tr><tr class="table-tr"><th colspan="13" class="title-table">Reporte Tipos de Actividades</th></tr><tr class="table-tr"><th data-field="0">Detalles</th><th data-field="1">N°</th><th data-field="2">Folio Actividad</th><th data-field="3">Aclaracion de Comision</th><th data-field="4">Cambio de Conducto</th><th data-field="5">Cancelación</th><th data-field="6">Captura Emision</th><th data-field="7">Cotizacion</th><th data-field="8">Emision</th><th data-field="9">Endoso</th><th data-field="10">Sustitucion</th><th data-field="11">(En blanco)</th><th data-field="12">Total</th><tr></thead><tbody id="bodyTableResumenAct">`;
    		break;
    		default:
    			div += `<div class="col-md-12 segment-table">${get_btn_filter_table(`Table${title[2]}`,`show-${table}`,0,`${table}`)}<div class="col-md-12 container-table" id="contTable${title[2]}"><table class="table" id="Table${title[2]}"><thead class="table-thead"><tr class="table-tr"><th colspan="31" class="title-table">${title[0]}</th></tr><tr class="table-tr"><th colspan="31" class="title-table">${title[1]}</th></tr><tr class="table-tr"><th data-field="0">IdInterno</th><th data-field="1">Folio Actividad</th><th data-field="2">IDSicas</th><th data-field="3">Num. Solicitud</th><th data-field="4">Documento</th><th data-field="5">Status</th><th data-field="6">Status_TXT</th><th data-field="7">Tipo Actividad Sicas</th><th data-field="8">IDCliente</th><th data-field="9">Nombre Cliente</th><th data-field="10">Tipo Actividad</th><th data-field="11">Ramo</th><th data-field="12">SubRamo</th><th data-field="13">Actividad Urgente</th><th data-field="14">Us. Creacion</th><th data-field="15">Us. Vendedor</th><th data-field="16">Us. Responsable</th><th data-field="17">Us. Bolita</th><th data-field="18">Us. Bloqueo</th><th data-field="19">Us. Cotizador</th><th data-field="20">Nombre Creador</th><th data-field="21">Nombre Vendedor</th><th data-field="22">Nombre Responsable</th><th data-field="23">Nombre Cotizador</th><th data-field="24">Fecha Creacion</th><th data-field="25">Cotizacion (Satisfaccion)</th><th data-field="26">Emision (Satisfaccion)</th><th data-field="27">Nombre Completo</th><th data-field="28">Tipo Endoso</th><th data-field="29">Poliza Perteneciente</th><th data-field="30">Dato Express</th></tr></thead><tbody id="bodyTable${title[2]}">`;
    		break;
    	}
    	return div;
    }

    function get_btn_filter_table(table,clase,export_table,type = null) {
    	var dropdown = (type != null) ? `<div class="pd-side" style="padding-right: 0px;"><button class="btn btn-primary btn-show-column dropdown-toggle" data-toggle="dropdown" aria-label="Columnas" title="Mostrar/Ocultar Columnas" aria-expanded="true"><i class="fas fa-th-list"></i></button><div class="dropdown-menu dropdown-menu-right dropdown-h">${get_dropdown_field(table,type)}</div></div>` : "";
    	var btnExport = ``;
    	if (export_table == 1) {
    		btnExport = `<div class="pd-side" style="padding-right: 0px;"><button class="btn btn-primary btn-export" id="btnExport${table}" onclick="getExportTable('${table}','${clase}')"><i class="fas fa-download"></i></button></div>`;
    	}    	
    	var div = `
    		<div class="col-md-12 column-flex-center-bottom pd-items-table pd-left pd-right">
        		<div class="col-md-6 column-flex-center-start pd-left">
        			<div class="pd-side">
        				<label class="label label-primary textSizeLabel">Resultados: <b id="rs${table}">0</b></label>
        			</div>
        		</div>
        		<div class="col-md-6 column-flex-center-end pd-right">
        			<div class="column-flex-center-end pd-left pd-right input-group" style="width: 65%;">
                  			<input class="form-control search-input" name="filter-input" placeholder="Filtrar" id="filter${table}" onkeyup="filterSelectedTable(this,'body${table}','${clase}')">
                    	<div class="input-group-append">
                      		<button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filter${table}')"><i class="fas fa-eraser"></i></button>
                  		</div>
                 	</div>
        			${dropdown}
        			${btnExport}
        		</div>
        	</div>
    	`;
    	return div;
    }

    function get_dropdown_field(table,type) {
    	var dropdown = ``;
    	switch(type) {
    		case 'vendedor':
    			dropdown = `
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="0" checked>
    					<span>Detalles</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="1" checked>
    					<span>N°</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="2" checked>
    					<span>Vendedor</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="3" checked>
    					<span>Captura Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="4" checked>
    					<span>Cotizacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="5" checked>
    					<span>Cotizacion & Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="6" checked>
    					<span>Emisiones</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="7" checked>
    					<span>Sustitucion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="8" checked>
    					<span>Total</span>
    				</label>
    			`;
    		break;
    		case 'actividad':
    			dropdown = `
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="0" checked>
    					<span>N°</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="1" checked>
    					<span>Captura Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="2" checked>
    					<span>Cotizacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="3" checked>
    					<span>Cotizacion & Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="4" checked>
    					<span>Emisiones</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="5" checked>
    					<span>Sustitucion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="6" checked>
    					<span>Tipo de Movimiento</span>
    				</label>
    			`;
    		break;
    		case 'resumen':
    			dropdown = `
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="0" checked>
    					<span>Detalles</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="1" checked>
    					<span>N°</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="2" checked>
    					<span>Folio Actividad</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="3" checked>
    					<span>Aclaracion de Comision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="4" checked>
    					<span>Cambio de Conducto</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="5" checked>
    					<span>Cancelacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="6" checked>
    					<span>Captura Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="7" checked>
    					<span>Cotizacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="8" checked>
    					<span>Emision</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="9" checked>
    					<span>Endoso</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="10" checked>
    					<span>Sustitucion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="11" checked>
    					<span>(En blanco)</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="12" checked>
    					<span>Total</span>
    				</label>
    			`;
    		break;
    		default:
    			dropdown = `
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="0" checked>
    					<span>IdInterno</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="1" checked>
    					<span>Folio Actividad</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="2" checked>
    					<span>IDSicas</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="3" checked>
    					<span>Num. Soliciud</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="4" checked>
    					<span>Documento</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="5" checked>
    					<span>Status</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="6" checked>
    					<span>Status_TXT</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="7" checked>
    					<span>Tipo Actividad Sicas</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="8" checked>
    					<span>IDCliente</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="9" checked>
    					<span>Nombre Cliente</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="10" checked>
    					<span>Tipo Actividad</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="11" checked>
    					<span>Ramo</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="12" checked>
    					<span>SubRamo</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="13" checked>
    					<span>Actividad Urgente</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="14" checked>
    					<span>Us. Creacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="15" checked>
    					<span>Us. Vendedor</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="16" checked>
    					<span>Us. Responsable</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="17" checked>
    					<span>Us. Bolita</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="18" checked>
    					<span>Us. Bloqueo</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="19" checked>
    					<span>Us. Cotizador</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="20" checked>
    					<span>Nombre Creador</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="21" checked>
    					<span>Nombre Vendedor</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="22" checked>
    					<span>Nombre Responsable</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="23" checked>
    					<span>Nombre Cotizador</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="24" checked>
    					<span>Fecha Creacion</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="25" checked>
    					<span>Cotizacion (Satisfaccion)</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="26" checked>
    					<span>Emision (Satisfaccion)</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="27" checked>
    					<span>Nombre Completo</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="28" checked>
    					<span>Tipo Endoso</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="29" checked>
    					<span>Poliza Perteneciente</span>
    				</label>
    				<label class="dropdown-item dropdown-item-marker">
    					<input type="checkbox" name="check-input" data-table="${table}" value="30" checked>
    					<span>Dato Express</span>
    				</label>
    			`;
    		break;
    	}
    	return dropdown;
    }
	//------------------------------------------------- OPERACIONES -------------------------------------------------

    function getCountResultByTable(table,clase) {
    	const name = table.split('body');
    	let foot = $('#'+name[1]+' tfoot tr td');
    	let tr = $('#'+table).find('tr.'+clase);
    	var count = 0;
    	for (let i=0;i<tr.length;i++) {
    		if ($(tr[i]).css('display') != "none") {
    			count++;
    		}
    	}
    	$('#rs'+name[1]).text(count);
    	//console.log(foot);
    	for (let f=0;f<foot.length;f++) {
    		const num = Number(f) + 1;
    		if (name[1] == "TableTotalAct" || name[1] == "TableActividadAct") {
    			if (f == 0) { continue; }
    		}
    		else { if (f == 0 || f == 1 || f == 2) { continue; } }
    		var val = 0;
    		for (let i=0;i<tr.length;i++) {
    			if ($(tr[i]).css('display') != "none") {
    				const td = $(tr[i]).find('td');
    				const field = $(td[f]).data('field');
    				var value = $(td[f]).text();
    				if (name[1] == "TableActividadAct") {
    					if (value != 0) { val++; }
    				}
    				else {
    					val = val + Number(value);
    				}
    			}
    		}
    		$('#'+name[1]+' tfoot tr').find('td:nth-child('+num+')').text(val);
    		//console.log("td: " + num + ", val: " + val);
    	}
    }

	function openContainerTable(obj,clase) {
        iconFunction(obj,2);
        $('.'+clase).toggleClass('ocultarObjeto');
        //console.log(clase, obj);
    }

	function filterTable(value,body,clase) {
        var filter, panel, d, td, i, j, k, visible, btn, tr, sub, subclass;
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            tr = $(d[i]).data('indicator');
            sub = $(d[i]).data('sub');
            subclass = sub + tr;
            if ($(d[i]).hasClass(clase)) {
            	btn = d[i].getElementsByTagName("button")[0];
            	$(btn).html(`<i class="fas fa-plus" data-class="fas fa-plus" title="Ver"></i>`);
            	for (j = 0; j < td.length; j++) {
            	    if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1 && !$(td[j]).hasClass('ocultarObjeto')) {
            	        visible = true;
            	    }
            	}
            }
            if ($(d[i]).hasClass(clase) || $(d[i]).hasClass(subclass)) {
            	if (visible === true) {
            	    d[i].style.display = "";
            	    //$(d[i]).addClass(clase);
            	}
            	else {
            	    d[i].style.display = "none";
            	    //$(d[i]).removeClass(clase);
            	}
            }
            else {
            	$(d[i]).addClass('ocultarObjeto');
            }
        }
        result = Fila.length;
    }

    function filterTableAlt(value,body,clase) {
        var filter, panel, d, td, i, j, k, visible, btn, tr, sub, subclass;
        filter = value;
        panel = document.getElementById(body);
        d = panel.getElementsByTagName("tr");
        let Fila = document.getElementsByClassName(clase);
        //
        for (i = 0; i < d.length; i++) {
            visible = false;
            td = d[i].getElementsByTagName("td");
            const text = td[6].innerHTML.indexOf(filter);
            //console.log("td: "+$(td[6]).text()+", index: "+text+" filter: "+filter);
            if (text > -1 && filter == "" || $(td[6]).text() == filter) {
                visible = true;
            }
            if (visible === true) {
                d[i].style.display = "";
                $(d[i]).addClass(clase);
            }
            else {
                d[i].style.display = "none";
                $(d[i]).removeClass(clase);
            }
            $(d[i]).removeClass('ocultarObjeto');
        }
        result = Fila.length;
    }

    function filterSelectedTable(obj,body,clase) {
    	const val = $(obj).val().toUpperCase();
    	//console.log(val,body,clase);
        filterTable(val,body,clase);
        getCountResultByTable(body,clase)
    }

    function filterFieldSelected(obj,body,clase) {
    	const val = $(obj).val();
        filterTableAlt(val,body,clase);
        getCountResultByTable(body,clase)
    }

    function searchFilterTable(filter,val) {
      $('#'+filter).val(val);
      $('#'+filter).keyup();
    }

    function eraserFilterTable(filter) {
    	$('#'+filter).val("");
    	$('#'+filter).keyup();
  	}

  	function iconFunction(event,type) {
        const icon = $(event).children('i');
        if (type == 1) {
            icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
        }
        else if (type == 2) {
            icon.attr('class', icon.hasClass('fas fa-plus') ? 'fas fa-minus' : icon.attr('data-class'));
            icon.attr('title', icon.hasClass('fas fa-plus') ? 'Ver' : 'Ocultar');
        }
    }

	function getNumberInteger(data) {
        data = (Number.isInteger(data) != true) ? data.toFixed(2) : data;
        return data
    }

    function getNumberValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "" || data == 0) {
            data = 0;
        }
        return data;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

	function getDateFormat(data,format) {
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            if (!data.includes(':')) { data = data + " 00:00:00";}
            date = new Date(data);
            switch (format) {
                case 1:
                    dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 2:
                    dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
                break;
                case 3:
                    dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
                break;
                case 4:
                    dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
                break;
                case 5:
                    dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
                break;
                case 6:
                    dateF = dayname[date.getDay()];
                break;
                case 7:
                    dateF = monthname[date.getMonth()];
                break;
                case 8:
                    dateF = date.getFullYear();
                break;
                case 9:
                    if (!data.includes('00:00:00')) { dateF = date.toLocaleTimeString('en-US'); }
                break;
            }
        }
        return dateF;
    }

//------------------------------------------------------------------------------------------------------------
</script>
