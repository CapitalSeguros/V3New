<? $this->load->view('headers/header'); ?>
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
	$graficaBarras	= base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
	$graficaPastel	= base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
	$graficaPorcen	= base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
	
?>

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
	<div class="row">
    	<div class="col-md-12">
        </div>
    </div>
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
                            	<div class="col-sm-4 col-md-4">
									<b>Filtrado Tipo:</b> <i>Selecci&oacute;n de Mes</i>
									<p style="padding-left:1px;">
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
<!--
	<div class="row">
		<div class="col-md-12">
        	<div class="row">
            	<div class="col-sm-12 col-md-12">
                	<div class="panel panel-default">
                    	<div class="panel-heading">
                        	<i class="glyphicon glyphicon-list-alt"></i> Actividades
						</div>
                        <div class="panel-body">
                        	@@@
                        </div>
					</div>
				</div>
            </div>
		</div>
	</div>
-->        
	<div class="row">
		<div class="col-md-12">
        	<div class="row">
            	<div class="col-sm-3 col-md-4">
                	<div class="panel panel-default">
                    	<div class="panel-heading">
                        	<i class="glyphicon glyphicon-list-alt"></i>Monitor Actividades
						</div><!--* panel-heading -->
                        <div class="panel-body">
                        <form
                        	name="formMesActividades" id="formMesActividades"
							method="post"
                            action="<?=base_url();?>monitores/verMonitor" 
                        >
                        	<input type="hidden" name="monitorear" value="SemaforoActividades">

					<?
						if(true){
					?>
                        	<div class="row">
								<div class="col-sm-12 col-md-12" align="right">
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
                                	value="<?=$usuVend['EMail1']?>"
									<?=($usuVend['EMail1']==$usuarioVendedor)?'selected="selected"':''?>
                                    title="<?="[".$usuVend['Status_TXT']."] (".$usuVend['Giro'].") {".$usuVend['Clasifica_TXT']."}"?>"
                                >
									<?=$usuVend['NombreCompleto']?>
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
					<?
						}
					?>
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
										//print_r($tiposActividad);
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
													.''.$tiposActividad['tipoActividad']
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
										$imprimeUrgentes=$imprimeUrgentes.$cantUrgentes.')</td><td>Urgentes</td></tr>';
										echo($imprimeUrgentes);*/

										?>
                                        <tr>
                                    	    <td></td>
                                        	<td colspan="2"><b><?=$totalActividades?> Total</b></td>
                                        	
                                        
										</tr>

<tr><td colspan="5">Numero de urgentes: <?php  echo($cantUrgentes)    ?>  </td></tr>




										<tr><td colspan="5">Calificacion de las Actividades </td></tr>
										<tr><td colspan="5"><label style=" color: green"><?php 	echo($cantBuenas); ?> Actividades Buenas (<?php echo(round(($cantBuenas*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP)) ?>%)</label></td></tr>
										<tr><td colspan="5"> <label style=" color: red"><?php 	echo($cantMalas);  ?> <label style=" color: red">Actividades Malas (<?php echo(round(($cantMalas*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP)) ?>%)</label></td></tr>										
										<tr><td colspan="5"><label style=" color: #d28802"><?php 	echo($cantRegulares);  ?> Actividades Regulares (<?php echo(round(($cantRegulares*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP)) ?>%)</label></td></tr>
										<tr><td colspan="5"><label style=" color: #605e5e"><?php 	echo($cantSinCalificar);  ?> Actividades sin Calificar (<?php echo(round(($cantSinCalificar*100)/$sumCalificaciones,1, PHP_ROUND_HALF_UP)) ?>%)</label></td></tr>
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
                        	<input type="hidden" name="monitorear" value="SemaforoActividades">
                            <input type="hidden" name="mesActividades" value="<?=$this->input->post('mesActividades',TRUE)?>">
                            <input type="hidden" name="filtroFechas" value="<?=$this->input->post('filtroFechas',TRUE)?>">
                            <input type="hidden" name="fechaStart" value="<?=$this->input->post('fechaStart',TRUE)?>">
                            <input type="hidden" name="fechaEnd" value="<?=$this->input->post('fechaEnd',TRUE)?>">
                            <input type="hidden" name="usuarioVendedor" value="<?=$this->input->post('usuarioVendedor',TRUE)?>">

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
									}
							?>
								<img src="<?=$graficaPastel.trim($dat_TiposActividades, ',')."&bkg=FFFFFF&wdt=300&hgt=200"?>">
								<br /><br />
								<div class="table-responsive">
                                	<table class="table">
                                    	<tr style="text-decoration:underline;">
                                        	<td></td>
                                            <td>Total</td>
                                            <td>Tipos Actividad</td>
										</tr>
										<?
										foreach($refTiposActividades as $refTipoActivida){
											print($refTipoActivida);
										}
										?>
										<tr>
                                        	<td></td>
                                        	<td colspan="2"><b><?=$totalTiposActividades?> Total</b></td>
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
													.'<br />'
													."<b>Cotizador: </b>".$subRamosActividades['nombreUsuarioCotizador']
													.'<br />'
													."<b>Responsable: </b>".$subRamosActividades['nombreUsuarioResponsable']
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
</section>
<? $this->load->view('footers/footer'); ?>
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
</script>