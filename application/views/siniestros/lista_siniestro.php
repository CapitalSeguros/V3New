<?=$this->load->view('headers/header')?>
<?=$this->load->view('headers/menu')?>


<style>
	.showDetalle, 
	.showSeguimientos,
	.showDocumentos,
	.donwloadDocumento,
	.deleteProspecto{
		cursor: pointer; cursor: hand;
	}
	.center{
		text-align:center;
	}
	.justify{
		text-align:justify;		
	}
	.oculto{
		display:none;
	}
</style>
<!-- Inicio Page-Section -->
<?
	$columnas	= array();
	$columnas[] = 'clientes.idCliente';
	$columnas[] = 'clientes.tipoPersona';
	$columnas[] = 'clientes.nombreCompleto';
	$columnas[] = 'clientes.email';			
	$columnas[] = 'clientes.telefono';

	$columnas[] = 'crm.idCrm';
	$columnas[] = 'crm.office';			
	$columnas[] = 'crm.branch';
	$columnas[] = 'crm.canal';
	$columnas[] = 'crm.tipoProspecto';
	$columnas[] = 'crm.estadoProspecto';
	$columnas[] = 'crm.fechaCreacion';
	$columnas[] = 'crm.fechaActualizacion';
	$columnas[] = 'crm.referencia';			
	$columnas[] = 'crm.compania';
	$columnas[] = 'crm.ramo';
	$columnas[] = 'crm.subRamo';
	$columnas[] = 'crm.idUser';
	
	$columnas[] = 'crm.`siniestros-tipoTramite`';
	$columnas[] = 'crm.`siniestros-estatus`';

	$tabla	= "
		`clientes` Inner Join `crm`
		On
		`clientes`.`idCliente` = `crm`.`idCliente`
			  ";
			  

	$user_type="5";	
	$canal="5";		  
	switch($user_type){
		
		case 5: // Siniestros
			$where = "
				Where
					`eliminado` = '0'
					And
					`tipoProspecto` = 'SINIESTRO'
					And
					`clientes`.`estatusPerfil` = 'PROSPECTO'
					And
					`crm`.`office` = '1'
					 ";
		break;
		
		
	}
	$sqlConsultaProspectos = "
		Select
			SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $columnas))."
		From
		$tabla
		$where
							 ";
	//echo "<pre>";
		//print($sqlConsultaProspectos);
	//echo "</pre>";
	//$db1 = $this->load->database('prueba', TRUE);


	$this->db = $this->load->database('dbLite', TRUE);
	$query = $this->db->query($sqlConsultaProspectos);


		

?>
<section class="page-section">
	<div class="container-fluid">
		<?=$this->load->view('siniestros/navegacion')?>
		<div class="row">
			<div class="col-sm-12 col-md-12">
            	&nbsp;
            </div>
        </div>
		<div class="panel panel-default">
			<div class="panel-body">
            	<div class="row">
					<div class="col-sm-12 col-md-12">
						<!-- <table id="example" class="display" width="100%"></table> -->
						<table id="listado_prospectos" class="display" cellspacing="0" width="100%">
                        	<thead>
                            	<tr>
                                	<th class="oculto"></th>
                                	<th class="oculto"></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
									<th>Fecha Alta</th>
									<?=($user_type=='9')?'<th>Oficina</th>':''?>
									<?=($user_type!='1' && $canal!='2')?'<th>Sucursal</th>':''?>
									<?=($user_type=='9')?'<th>Canal</th>':''?>
									<?=($canal=='3')?'<th>Tipo Prospecto</th>':''?>
									<th>Tipo Tramite</th>
									<th>Estado Siniestro</th>
									<?=($user_type=='1')?'<th>Tipo Persona</th>':''?>
									<th>Nombre Completo</th>
									<th>Email</th>
									<th>Telefono</th>
									<th>Referencia</th>
									<?=($canal=='2')?'<th>Aseguradora</th>':''?>
									<?=($canal=='2')?'<th>Ramo</th>':''?>
									<?=($canal=='2')?'<th>SubRamo</th>':''?>
									<?=($user_type!='1' && $canal!='2')?'<th>Usuario</th>':''?>
                            	</tr>
                        	</thead>
                            <tbody>
							<?
							if($query->num_rows()>0){
								foreach($query->result_array() as $row){
									$fechaHoy		= date('Y-m-d');
									$fechaAlta		= $row['fechaCreacion'];	
									$diasCreacion	= date_diff(date_create($fechaAlta), date_create($fechaHoy));
										
									$titleFechaCrea	= "Creado hace: ";
									$titleFechaCrea.= $diasCreacion->format('%a');
									$titleFechaCrea.= " d&iacute;as \r Fecha actualizaci&oacute;n: ".$row['fechaActualizacion'];
							?>
								<tr>
                                	<th id="idCrm" class="oculto"><?=$row['idCrm']?></th>
                                	<th id="idCliente" class="oculto"><?=$row['idCliente']?></th>
                                	<th title="Ver Prospecci&oacute;n">
                                    	<a class="showDetalle"><span class="glyphicon glyphicon-folder-open"></span></a>
                                    </th>
                                	<th title="Ver Seguimientos">
                                    	<a class="showSeguimientos"><span class="glyphicon glyphicon-book"></span></a>
                                    </th>
                                	<th title="Ver Documentos">
                                    	<a class="showDocumentos"><span class="glyphicon glyphicon-briefcase"></span></a>
                                    </th>
                                    <th title="Eliminar Prospecci&oacute;n">
                                    	<a class="deleteProspecto"><span class="glyphicon glyphicon-trash"></span></a>
                                    </th>
                                	<th title="<?=$titleFechaCrea?>">
										<?=date('Y-m-d',strtotime($row['fechaCreacion']))?>
                                    </th>
								<!--<? if($user_type=='9'){ ?>
									<th><?=$this->capsysdre->get_Office($row['office'])?></th>
								<? } ?>-->

								<!--<? if($user_type!='1' && $canal!='2'){ ?>
                                	<th>"<?=$this->capsysdreLite->get_Branch($row['branch'])?>"</th>  
								<? } ?>-->
                                
								<!--<? if($user_type=='9'){ ?>
                                	<th><?=$this->capsysdre->get_nameCanal($row['canal'])?></th>                                	
								<? } ?>-->
								
								<!--<? if($canal=='3'){ ?>
                                    <th><?=$row['tipoProspecto']?></th>
								<? } ?>-->
                                	<!--<th><?=$this->capsysdreLite->get_nameProcessType($row['siniestros-tipoTramite'])?></th>
                                	<th><?=$this->capsysdreLite->get_nameEstatusSiniestro($row['siniestros-estatus'])?> </th>-->
								<!--<? if($user_type=='1'){ ?>
                                	<th><?=$row['tipoPersona']?></th>
								<? } ?>-->
                                    <th><?=$row['nombreCompleto']?></th>
                                	<th><?=$row['email']?></th>
                                	<th><?=$row['telefono']?></th>
                                	<th><?=$this->capsysdreLite->get_nameReference($row['referencia'])?></th>
								<!--<? if($canal=='2'){ ?>
                                	<th><?=$this->capsysdre->get_nameCompani($row['compania'])?></th>
								<? } ?>
								
								<? if($canal=='2'){ ?>
                                	<th><?=$this->capsysdre->get_nameRamo($row['ramo'])?></th>
								<? } ?>
								
								<? if($canal=='2'){ ?>
                                	<th><?=$this->capsysdre->get_nameSRamo($row['subRamo'])?></th>
								<? } ?>-->
								
								<!--<? if($user_type!='1' && $canal!='2'){ ?>
                                	<th><?=$this->capsysdreLite->get_UserName($row['idUser'])?></th>
								<? } ?>-->
                                </tr>
							<?
								}
							}
							?>
                            </tbody>
                            <tfoot>
                            	<tr>
                                	<th class="oculto"></th>
                                	<th class="oculto"></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
                                	<th></th>
									<th>Fecha Alta</th>
									<?=($user_type=='9')?'<th>Oficina</th>':''?>
									<?=($user_type!='1' && $canal!='2')?'<th>Sucursal</th>':''?>
									<?=($user_type=='9')?'<th>Canal</th>':''?>
									<th>Tipo Tramite</th>
									<th>Estado Siniestro</th>
									<?=($user_type=='1')?'<th>Tipo Persona</th>':''?>
									<th>Nombre Completo</th>
									<th>Email</th>
									<th>Telefono</th>
									<th>Referencia</th>
									<?=($canal=='2')?'<th>Aseguradora</th>':''?>
									<?=($canal=='2')?'<th>Ramo</th>':''?>
									<?=($canal=='2')?'<th>SubRamo</th>':''?>
									<?=($user_type!='1' && $canal!='2')?'<th>Usuario</th>':''?>
                                </tr>
                            </tfoot>
						</table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Fin Page-Section -->
<?php $this->load->view('footers/footer'); ?>

<!--..::::::::::::::::::::================ INICIO MODAL PRELOAD AJAX ================::::::::::::::::::::..-->
	<div id="modalPreload" class="modal fade">
		<div class="modal-preload">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body">
						<div class="text-center">
							<img src="<?=base_url()?>assets/images/loading_capsys.gif" class="icon" />
                            <br /><br />
							<small>PROCESANDO...</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--..::::::::::::::::::::================ FIN MODAL PRELOAD AJAX    ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL DETALLE ================::::::::::::::::::::..-->
	<div id="detalleProspecto" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
					<h4 class="modal-title">
                    	Detalles prospección
                        <span id="tipoProspecto"></span><span id="estadoProspecto"></span>
                    </h4>
					<div class="row">
						<div class="pull-left">
                        &nbsp;&nbsp;&nbsp;
						<b>Fecha creaci&oacute;n:</b> <font style="font-style:italic" id="fCreacion"></font><!-- fechaCreacion -->
                        <b>Creado hace:</b> <font style="font-style:italic" id="tiempoCreacion"></font>
						<b>Fecha actualizaci&oacute;n:</b> <font style="font-style:italic" id="fActualizacion"></font>
						</div>
						<div class="pull-right">
						<b>Recordatorio:</b> <font style="font-style:italic" id="fRecordatorio"></font><!-- fechaRecordatorio -->
                        &nbsp;&nbsp;&nbsp;
                        </div>
					</div>
				</div>
				<div class="modal-body">
					<div class="row pull-right">
						<div class="col-xs-12 col-sm-12 col-md-12 pull-right">
                        	<span id="buttonEditarProspeccion"></span>
                        	<span id="buttonSeguimiento"></span>
                        	<span id="buttonDocumento"></span>
                        	<span id="buttonEnviarCorreo"></span>
                        	<span id="buttonAgendarCita"></span>
                        	<span id="buttonProduccion"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
                        	<br />
                        	<hr />
                        </div>
					</div>
					<!-- <form action="#" method="POST" id="frmBuscador"> -->
					<div class="row">
						<div class="col-xs-3 col-sm-2 col-md-1">
							<label for="tipoPersona"><b>Entidad</b></label>
							<p id="tipoPersona"></p>
						</div>
						<div class="col-xs-5 col-sm-8 col-md-9">
							<label for="nombreCompleto"><b>Nombre</b></label>
							<p id="nombreCompleto"></p>
						</div>
						<div class="col-xs-4 col-sm-2 col-md-2">
							<label for="sexo" id="titleSexo"></label>
							<p id="sexo"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-sm-2 col-md-2">
							<label for="fecha" id="titleFecha"></label>
							<p id="fecha"></p>
						</div>
						<div class="col-xs-3 col-sm-2 col-md-1">
							<label for="edad"><b>Edad</b></label>
							<p id="edad"></p>
						</div>
						<div class="col-xs-5 col-sm-8 col-md-7">
							<label for="email"><b>Correo electr&oacute;nico</b></label>
							<p id="email"></p>
						</div>
						<div class="col-xs-4 col-sm-2 col-md-2">
							<label for="telefono"><b>Tel&eacute;fono</b></label>
							<p id="telefono"></p>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<label for="informacion"><b>Informaci&oacute;n</b></label>
                            <p>
                            	<font id="compania"></font> <font id="ramo"></font> <font id="subRamo"></font>
                            </p>
                            <p id="informacion" style="text-align:justify;"></p>
						</div>
					</div>
					<div class="row">
						<div id="adjunto" class="col-xs-12 col-sm-12 col-md-12">
						</div>
					</div>
					<div class="row">
						<div id="tree_menu" class="col-xs-12 col-sm-12 col-md-12">
						</div>
					</div>
					<!-- </form> -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>			
				</div>
			</div>
		</div>
	</div>
<!--..::::::::::::::::::::================ FIN MODAL DETALLE    ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL SEGUIMIENTO ================::::::::::::::::::::..-->
	<div id="seguimientoProspecto" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
					<h4 class="modal-title">
                    	Seguimiento prospecci&oacute;n
                    </h4>
				</div>
				<div class="modal-body">
					<form
						id="frmAddSeguimiento"
						method="post" enctype="multipart/form-data"
						action="<?php echo base_url();?>crm/seguimientoAdd"
                    >
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<label for="Description">Descripci&oacute;n</label>
							<textarea
								class="form-control input-sm"
                                name="seguimiento" id="seguimiento" 
							></textarea>
							<?php echo display_ckeditor($seguimiento); ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12" align="right">
                        	<input type="hidden" name="idCrmModal" id="idCrmModal"/>
                    		<input type="hidden" name="idClienteModal" id="idClienteModal"/>
                    		<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>" />
                    		<input type="hidden" name="office" id="office" value="<?=$office?>" />
                    		<input type="hidden" name="branch" id="branch" value="<?=$branch?>" />
                    		<input type="hidden" name="tipoCrm" id="tipoCrm" value="<?=($this->input->post('tipoCrm', true)!="")?$this->input->post('tipoCrm', true):$tipoCrm?>" />
							<button 
                            	type="submit" 
                                class="btn btn-default" 
		                        form="frmAddSeguimiento"
                            >
                            	Guardar
                            </button>
						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button 
                    	type="button" 
                        class="btn btn-default" 
                        id="buttonCerraSeguimiento" 
                    >
                    	Cerrar
                    </button>
				</div>
			</div>
		</div>
	</div>
<!--..::::::::::::::::::::================ FIN MODAL SEGUIMIENTO ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL DOCUMENTOS ================::::::::::::::::::::..-->
	<div id="documentoProspecto" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
					<h4 class="modal-title">
                    	Documento prospecci&oacute;n
                    </h4>
				</div>
				<div class="modal-body">
					<form
						id="frmAddDocumento"
						method="post" enctype="multipart/form-data"
						action="<?php echo base_url();?>crm/documentoAdd"
                    >

					<div class="row form-group">
						<div class="col-xs-4 col-sm-4 col-md-4">
							<label for="tipoAdjunto">Tipo Adjunto</label>
							<select class="form-control input-sm" name="tipoAdjunto" id="tipoAdjunto" >
								<option value="">Selecccione una Tipo Adjunto</option>
									<?
										if($tipoAdjunto){
											foreach($tipoAdjunto as $registroTipoDocumento){
									?>
								<option 
									value="<?=$registroTipoDocumento['nombreTitulo']?>"
								>
									<?php echo $registroTipoDocumento['nombreTitulo']?>
								</option>
									<?
											}
										}
									?>
							</select>
						</div>
						<div class="col-xs-8 col-sm-8 col-md-8">
							<label for="descripcionAdjunto">Descripci&oacute;n Adjunto</label>
							<input
								type="text" class="form-control input-sm"
								name="descripcionAdjunto" id="descripcionAdjunto"
							/>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<label for="adjunto">Archivo Adjunto</label>
							<div class="input-group">
							<input 
								type="text" class="form-control" readonly="readonly"
							/>
							<!-- value="<?=($_FILES['adjunto']['name']!="")?$_FILES['adjunto']['name']:''?>" -->
							<label class="input-group-btn">
                            	<span class="btn btn-primary">
                                Selecccionar <input type="file" style="display: none;" name="adjunto" id="adjunto"><!-- multiple -->
								</span>
							</label>
							</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12" align="right">
                         
                        	<input type="hidden" name="idCrmAdjunto" id="idCrmAdjunto" />
                    		<input type="hidden" name="idClienteAdjunto" id="idClienteAdjunto"/>
                    		<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>" />
                    		<input type="hidden" name="office" id="office" value="<?=$office?>" />
                    		<input type="hidden" name="branch" id="branch" value="<?=$branch?>" />
                    		<input type="hidden" name="tipoCrm" id="tipoCrm" value="<?=($this->input->post('tipoCrm', true)!="")?$this->input->post('tipoCrm', true):$tipoCrm?>" />
							<button 
                            	type="submit" 
                                class="btn btn-default" 
		                        form="frmAddDocumento"
                            >
                            	Guardar
                            </button>
						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button 
                    	type="button" 
                        class="btn btn-default" 
                        id="buttonCerrarDocumento" 
                    >
                    	Cerrar
                    </button>
				</div>
			</div>
		</div>
	</div>
<!--..::::::::::::::::::::================ Fin MODAL DOCUMENTOS ================::::::::::::::::::::..-->

<!--..::::::::::::::::::::================ INICIO MODAL AGENDAR CITA ================::::::::::::::::::::..-->
	<div id="citaProspecto" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    	<span aria-hidden="true">&times;</span>
                    </button>
					<h4 class="modal-title">
                    	Agendar cita prospecci&oacute;n
                    </h4>
				</div>
				<div class="modal-body">
					<form
						id="frmAddCita"
						method="post" enctype="multipart/form-data"
						action="<?php echo base_url();?>calendario/citaAdd"
                    >

					<div class="row form-group">
						<div class="col-xs-2 col-sm-2 col-md-2">
							<label for="Color">Color</label>
							<select class="form-control input-sm" name="Color" id="Color" >
								<option value="0">Gris</option>
								<option value="1">Rojo</option>
								<option value="2">rosa</option>
								<option value="3">violeta</option>
								<option value="4">Morado</option>
								<option value="5">Azul</option>
							</select>
						</div>
						<div class="col-xs-10 col-sm-10 col-md-10">
							<label for="Subject">Asunto</label>
							<input
								type="text" class="form-control input-sm"
								name="Subject" id="Subject"
							/>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-3 col-sm-3 col-md-3">
							<label for="fechaInicio">Fecha Inicio</label>
							<input          
								type="text" class="form-control input-sm fechaInicio"
								name="fechaInicio" id="fechaInicio"
                                value="<?=date('Y-m-d')?>"
							/>
                        </div>
						<div class="col-xs-3 col-sm-3 col-md-2">
							<label for="horaInicio">Hora Inicio</label>
							<select class="form-control input-sm" name="horaInicio" id="horaInicio" >
                            	<option value="08:00">08:00</option>
                            	<option value="08:30">08:30</option>
                            	<option value="09:00">09:00</option>
                            </select>
                        </div>
						<div class="col-xs-3 col-sm-3 col-md-3">
							<label for="fechaFin">Fecha Fin</label>
							<input
								type="text" class="form-control input-sm fechaFin"
								name="fechaFin" id="fechaFin"
                                value="<?=date('Y-m-d')?>"
							/>
                        </div>
						<div class="col-xs-3 col-sm-3 col-md-2">
							<label for="horaFin">Hora Fin</label>
							<select class="form-control input-sm" name="horaFin" id="horaFin" >
                            	<option value="08:00">08:00</option>
                            	<option value="08:30">08:30</option>
                            	<option value="09:00">09:00</option>
                            </select>
                        </div>
						<div class="col-xs-2 col-sm-2 col-md-2">
                            <input
                            	type="checkbox"
                                name="IsAllDayEvent" id="IsAllDayEvent"
                                value="1"
                            />
							<label for="IsAllDayEvent">Todo el D&iacute;a</label>
                        </div>
					</div>
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<label for="Location">Lugar</label>
							<input
								type="text" class="form-control input-sm"
								name="Location" id="Location"
							/>
                        </div>
					</div>                    
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<label for="Description">Descripci&oacute;n</label>
							<textarea
								class="form-control input-sm"
                                name="Description" id="Description" 
							></textarea>
							<?php echo display_ckeditor($Description); ?>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-12 col-sm-12 col-md-12" align="right">
                         
                        	<input type="hidden" name="idCrmCita" id="idCrmCita" />
                    		<input type="hidden" name="idClienteCita" id="idClienteCita"/>
                    		<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>" />
                    		<input type="hidden" name="office" id="office" value="<?=$office?>" />
                    		<input type="hidden" name="branch" id="branch" value="<?=$branch?>" />
                    		<input type="hidden" name="tipoCrm" id="tipoCrm" value="<?=($this->input->post('tipoCrm', true)!="")?$this->input->post('tipoCrm', true):$tipoCrm?>" />
							<button 
                            	type="submit"
                                class="btn btn-default" 
		                        form="frmAddCita"
                            >
                            	Guardar
                            </button>
						</div>
					</div>
					</form>
				</div>
				<div class="modal-footer">
					<button 
                    	type="button" 
                        class="btn btn-default" 
                        id="buttonCerrarCita" 
                    >
                    	Cerrar
                    </button>
				</div>
			</div>
		</div>
	</div>
<!--..::::::::::::::::::::================ Fin MODAL AGENDAR CITA ================::::::::::::::::::::..-->

<!--
<div id="dialog-confirm" title="Empty the recycle bin?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
-->

<script>	
	Date.prototype.yyyymmdd = function(){
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
	   
       return  (dd[1]?dd:"0"+dd[0])+"/"+ (mm[1]?mm:"0"+mm[0])+"/"+ yyyy; // padding
    };
	/*
	function clearTable(){
		if(table != null){
			table.clear.draw();	
		}			
	}
	*/
	function getValue(data){
		var resl = '';
		if(data != null){
			if(typeof data == 'object'){
				resl = '';
			}else{
				resl = data;
			}
		}else{
			resl = '';
		}

		return resl;
	}

	function getURLParameter(name){
		return 
			decodeURIComponent(
				(new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)')
					.exec(location.search)||[,""])[1]
					.replace(/\+/g, '%20'))||null;
	}

	var fecha =	$('.fechaInicio').datepicker({
		format: "yyyy-mm-dd",
	    startDate: "1900-01-01",
	    language: "es",
	    autoclose: true,
     	orientation: "bottom right",
	});

	var fecha =	$('.fechaFin').datepicker({
		format: "yyyy-mm-dd",
	    startDate: "1900-01-01",
	    language: "es",
	    autoclose: true,
     	orientation: "bottom right",
	});
	
	$(document).ready(function() {

//-- Revisar Funcion
	$('#listado_prospectos tfoot th').each( function () {
		var title = $(this).text();
		var dType  = $(this).attr('data-type');
        var sClass = "";
        if (typeof dType !== typeof undefined && dType !== false) {
            sClass = "fecha";
        }

		if(title == ""){
			//$(this).html( '<span class="btn btn-default exportexcel"><i class="fa fa-file-excel-o"></i> Excel</span>' );
		}else{
			$(this).html(
				'<input type="text" name="'+ title.replace(/ /g,"_").toLowerCase() +'" class="'+ sClass +'" placeholder="Buscar por '+title+'" />'
						);
		}         
	});

	/*
	$('#reporte tfoot th').each( function () {
        var title = $(this).text();
		
		var dType = $(this).attr('data-type');
        var sClass = "";
        if (typeof dType !== typeof undefined && dType !== false) {
            sClass = " fecha ";
        }
		
		if(title == ""){
			$(this).html( '<span class="btn btn-default exportexcel"><i class="fa fa-file-excel-o"></i> Excel</span>' );
		}else{
			$(this).html( '<input type="text" name="'+title.replace(/ /g,"_").toLowerCase() +'" class="' + sClass + '" placeholder="buscar por '+title+'" />' );
		}         
    });
	*/
//--
	var table =	
		$('#listado_prospectos')
		.on('preXhr.dt', function( e, settings, data ){
			/*
			data.search_d = function(){
				var input	= $('#listado_prospectos > tfoot').find("input");
				data_value	= [];
				var _array	= "[";
				var count	= input.size();
				
				$.each(input,function(index, value){
					var name	= $(value).attr("name");
                    var val		= $(value).attr("data-value");

                    if(typeof val === "undefined"){ val	= ""; }

                    if(name != "" && val != ""){
						var indice = index;
                        var sType = "";
                        if($(value).hasClass('fecha')){
                            sType = "date";
                        }else{
                            sType = "text";
                        }
                        _array += '{"id":"'+ indice + '", "val":"' + val + '", "type":"'+sType+'"},';
                    }
				}); 

				_array	= _array.substring(0, _array.length - 1);
				_array	+= "]";
				
//**--> console.log(_array);
                return _array;
			};
			*/
		})
		.on('processing.dt', function ( e, settings, processing ){
			//console.log("prosesando...");
			if(processing){
				$('#modalPreload').modal({
					show: true,
					backdrop: "static"
				});	    			
			}else{
	    		$('#modalPreload').modal('hide');
			}
		})
		.DataTable({
			"order":		[[ 6, "Desc" ]],
			
			"scrollX":		'true',
			"lengthChange":	'true',
			"autoWidth":	'false',

			"language":		{
								"sProcessing":	"",
								"lengthMenu":	"Mostar _MENU_ registros por pagina",
								
								"sZeroRecords":		"No se encontraron resultados",
								"sEmptyTable":		"Ning&uacute;n dato disponible en esta tabla",
								//"sInfo":			"Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
								//"sInfoEmpty":		"Mostrando registros del 0 al 0 de un total de 0 registros",
								//"sInfoFiltered":	"(filtrado de un total de _MAX_ registros)",
								"sInfoPostFix":		"",

								"info":				"Mostrando pagina _PAGE_ de _PAGES_",
								"infoEmpty":		"No records available",
								"infoFiltered":		"(filtrada de _MAX_ registros)",
								"search":			"Buscar en Todos:",

								"sUrl":				"",
								"sInfoThousands":	",",
								"sLoadingRecords":	"Cargando...",

								"paginate": {
									"next":		"Siguiente",
									"previous":	"Anterior"
								},
								"oAria": {
									"sSortAscending":	": Activar para ordenar la columna de manera ascendente",
									"sSortDescending":	": Activar para ordenar la columna de manera descendente",
								}
/*
			"aoColumns":	[
								{
									"data":null,
									"orderable": false
								},
								{
									"data":null,
									"orderable": false
								},
								{
									"data":null,
									"orderable": false
								},
								{
									"data":"fechaCreacion",
								},
							],
*/
/*
			"columnDefs":	[
								{ //** Icono Detalle
									"targets": 0, 
									"width": "3px"
								},
								{ //** Icono Seguimiento
									"targets": 1, 
									"width": "3px"
								},
								{ //** Icono Documentos
									"targets": 2, 
									"width": "3px"
								},
								{ //** Fecha Creacion
									"targets": 3,
									"width": "70px"
								},
								{ //** Sucursal
									"targets": 4
								},
								{ //** Usuario
									"targets": 5
								},
								{ //** Tipo Prospecto
									"targets": 6
								},
								{ //** Estado Prospecto
									"targets": 7
								},
								{ //** Nombre Completo
									"targets": 8
								},
								{ //** Aseguradora
									"targets": 9
								},
								{ //** Ramo
									"targets": 10
								},
								{ //** SubRamo
									"targets": 11
								},
							],
*/

			}
		});
		
		
		table.columns().every(function(){
			var that = this;

			$('input',this.footer()).on('keyup change',function(event){
				if(this.value.length>3){
					$("input[name=" + this.name + "]").attr("data-value",this.value);
					if(that.search()!==this.value){
						that.search(this.value).draw();
					}
				}else{
					if(event.keyCode==8){
						$("input[name=" + this.name + "]").attr("data-value",this.value);
						if(that.search()!==this.value){
							that.search(this.value).draw();
						} else if(this.value.length==0){
							that.search(this.value).draw();
						}
					}
				}
			});
		});
		
		
		/* //--> Posible Quitar
	    $('input.global_filter').on( 'keyup click', function () {
    	    filterGlobal();
	    } );
		*/

		/** Ver Modal Detalle **/
		$('#listado_prospectos')
		.on('click','.showDetalle',function(){
			var parent		= $(this).closest('tr');
			var data		= table.row(parent).data();
			var idCrm		= data[0]; //data['idCrm'];
			var idCliente	= data[1]; //data['idCliente'];
			if(idCrm == '' || idCliente == ''){
				return;
			}
			var data_json = {"idCrm":idCrm,"idCliente": idCliente };
			//console.log(data_json);

			//$('#modalPreload').modal('show');
			$.ajax({
				url:		'<?=base_url()."get_capsysdre/get_prospeccionDetalle"?>',
				type:		'POST',
				data:		{ idCrm : idCrm },
				success:	function(data){
											var hoy = new Date();
											data = jQuery.parseJSON(data);
											//console.log(data);
										if(data.tipoProspecto == 'AGENTE'){
											$('#tipoProspecto').html(getValue('&lt;'+data.tipoProspecto+'&gt; ['+data.canal+']'));
										} else {
											$('#tipoProspecto').html(getValue('&lt;'+data.tipoProspecto+'&gt;'));
										}

										if(data.tipoProspecto == 'CLIENTE'){
											$('#buttonEditarProspeccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Editar prospecci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonSeguimiento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Seguimiento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuSeguimiento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonDocumento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Documento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuDocumento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonEnviarCorreo').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Enviar Correo"'+
													'onclick="window.open(\'<?=base_url()?>correo/nuevo?idCrm='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCorreo.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonAgendarCita').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agendar cita"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"'+
														'>'+
													'</span>'+
												'</button>'
											);

											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Producci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProduccion.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Seguimiento agente"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
										
											/*
											$('#buttonEditarProspeccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Editar prospecci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonEnviarCorreo').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Enviar Correo"'+
													'onclick="window.open(\'<?=base_url()?>correo/nuevo?idCrm='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCorreo.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonAgendarCita').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agendar cita"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											
											$('#buttonProduccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Producci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProduccion.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
										*/	
										} else if(data.tipoProspecto == 'AGENTE'){
											
											$('#buttonEditarProspeccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Editar prospecci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonSeguimiento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Seguimiento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuSeguimiento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonDocumento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Documento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuDocumento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonEnviarCorreo').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Enviar Correo"'+
													'onclick="window.open(\'<?=base_url()?>correo/nuevo?idCrm='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCorreo.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonAgendarCita').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agendar cita"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"'+
														'>'+
													'</span>'+
												'</button>'
											);

											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Producci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProduccion.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Seguimiento agente"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
										} else if(data.tipoProspecto == 'SINIESTRO'){
											$('#buttonEditarProspeccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Editar prospecci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonSeguimiento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Seguimiento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuSeguimiento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonDocumento').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agregar Documento"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuDocumento.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonEnviarCorreo').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Enviar Correo"'+
													'onclick="window.open(\'<?=base_url()?>correo/nuevo?idCrm='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCorreo.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonAgendarCita').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agendar cita"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"'+
														'>'+
													'</span>'+
												'</button>'
											);

											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Producci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProduccion.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
											/*
											$('#buttonSiguientePaso').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Seguimiento agente"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											*/
											
										
											/*
											$('#buttonEditarProspeccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Editar prospecci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>crm/editar/prospecto?idCrm='+data.idCrm+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProspectos.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonEnviarCorreo').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Enviar Correo"'+
													'onclick="window.open(\'<?=base_url()?>correo/nuevo?idCrm='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCorreo.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											$('#buttonAgendarCita').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Agendar cita"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuCalendario.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
											
											$('#buttonProduccion').html(
												'<button '+
													'type="button" class="btn btn-primary btn-sm" '+
													'title="Producci&oacute;n"'+
													'onclick="window.open(\'<?=base_url()?>produccion/agregar?idCliente='+data.idCliente+'\',\'_parent\')"'+
												'>'+
													'<span>'+
														'<image '+
																'src="<?=base_url()?>assets/images/icons-menu/icon-menuProduccion.png"'+
														'>'+
													'</span>'+
												'</button>'
											);
										*/	
										
											
										}
											$('#estadoProspecto').html(getValue(' ('+data.estadoProspecto+')'));
											$('#idCliente').html(getValue(data.idCliente));
											$('#tipoPersona').html(getValue(data.tipoPersona));
											$('#nombreCompleto').html(getValue(data.nombreCompleto));
											$('#rfc').html(getValue(data.rfc));
											$('#sexo').html(getValue(data.sexo));
											$('#fecha').html(getValue(data.fecha));
											$('#edad').html(getValue(data.edad));
											$('#email').html(getValue(data.email));
											$('#telefono').html(getValue(data.telefono));
											$('#idCrm').html(getValue(data.idCrm));

											$('#fechaCreacion').html(getValue(data.fechaCreacion));
										var fCreacion = new Date(getValue(data.fechaCreacion));
										$('#fCreacion').html(fCreacion.yyyymmdd());
										
											$('#fechaActualizacion').html(getValue(data.fechaActualizacion));
										var fActualizacion = new Date(getValue(data.fechaActualizacion));
										$('#fActualizacion').html(fActualizacion.yyyymmdd());

											$('#fechaRecordatorio').html(getValue(data.fechaRecordatorio));
										var fRecordatorio = new Date(getValue(data.fechaRecordatorio));
										$('#fRecordatorio').html(fRecordatorio.yyyymmdd());
										
										var tCreacion = Math.round((hoy-fCreacion) / (60 * 60 * 24 * 1000));
											$('#tiempoCreacion').html(tCreacion+' d&iacute;as');

										if(getValue(data.compania) != ""){
											$('#compania').html('&bull;'+getValue(data.compania));
										} else {
											$('#compania').html();
										}
										if(getValue(data.ramo) != ""){
											$('#ramo').html('&bull;'+getValue(data.ramo));
										} else {
											$('#ramo').html();
										}
										if(getValue(data.subRamo) != ""){
											$('#subRamo').html('&bull;'+getValue(data.subRamo));
										} else {
											$('#subRamo').html();
										}
											$('#informacion').html(getValue(data.informacion));
										if(data.tipoPersona == 'FISICA'){
											$('#titleFecha').html('<b>Fecha nacimiento</b>');
											$('#titleSexo').html('<b>Sexo</b>');
										} else if(data.tipoPersona == 'MORAL'){
											$('#titleFecha').html('<b>Fecha constituci&oacute;n</b>');
											$('#titleSexo').html('');
										}
/* Inicio easytree */
										/*
											$.ajax({
												url:		"<?php echo base_url()?>get_capsysdre/get_adjuntosDetalle",
												type:		'POST',
												data:		{ idCrm: idCrm},
												success:	function(data){
																			data = jQuery.parseJSON(data);
																			//console.log(data);

																			$('#tipoDocumento')
																				.html(getValue(data.tipoDocumento));
																			$('#descripcionAdjunto')
																				.html(getValue(data.descripcionAdjunto));
																			$('#urlAdjunto')
																				.html(getValue(data.urlAdjunto));
																		if(data.urlAdjunto!= null){
																			$('#adjunto').html(
																				'<a href="'+getValue(data.urlAdjunto)+'" title="Clic descargar adjunto !!!" target="_blank" >'+
																				'<span class="glyphicon glyphicon-paperclip"></span> '+
																				getValue(data.tipoDocumento)+
																				' ('+
																				getValue(data.descripcionAdjunto)+
																				')'+
																				'</a>'
																			);
																		} else {
																			$('#adjunto').html('');
																		}
															}
											});
										*/
/* Fin easytree */
											$('#detalleProspecto').modal('show');
							},
				always:function(){
					$('#modalPreload').modal('hide');
				}
			});	
			//$('#modalPreload').modal('hide');
			
			/** Ver Modal Seguimiento **/
			$('#detalleProspecto')
			.on('click','#buttonSeguimiento',function(){
				$("#idCrmModal").val(idCrm);
				$("#idClienteModal").val(idCliente);

				$('#detalleProspecto').modal('hide');
				$('#seguimientoProspecto').modal('show');
				console.log(idCrm)
			});

			/** Cerrar Modal Seguimiento y Regresar Modal Detalle **/
			$('#seguimientoProspecto')
			.on('click','#buttonCerraSeguimiento',function(){
				$('#seguimientoProspecto').modal('hide');
				$('#detalleProspecto').modal('show');
			});

			/** Ver Modal Documento **/
			$('#detalleProspecto')
			.on('click','#buttonDocumento',function(){
				$("#idCrmAdjunto").val(idCrm);
				$("#idClienteAdjunto").val(idCliente);

				$('#detalleProspecto').modal('hide');
				$('#documentoProspecto').modal('show');				
			});
			
			/** Cerrar Modal Documento y Regresar Modal Detalle **/
			$('#documentoProspecto')
			.on('click','#buttonCerrarDocumento',function(){
				$('#documentoProspecto').modal('hide');
				$('#detalleProspecto').modal('show');
			});
			
			/** Ver Modal Agendar Cita **/
			$('#detalleProspecto')
			.on('click','#buttonAgendarCita',function(){
				$("#idCrmCita").val(idCrm);
				$("#idClienteCita").val(idCliente);

				$('#detalleProspecto').modal('hide');
				$('#citaProspecto').modal('show');
			});
			
			/** Cerrar Modal Agendar Cita y Regresar Modal Detalle **/
			$('#citaProspecto')
			.on('click','#buttonCerrarCita',function(){
				$('#citaProspecto').modal('hide');
				$('#detalleProspecto').modal('show');
			});
		});

		/** Ver Tabla Seguimientos **/
		/***/
		//Global
		var dataSegumientos = {};
		/***/
		$('#listado_prospectos')
		.on('click', '.showSeguimientos',function () {
			var tr = $(this).closest('tr');
        	var row = table.row(tr);
			var idCrm = row.data()[0]; //row.data().idCrm;

			if(row.child.isShown()){
				row.child.hide();
				tr.removeClass('shown');
			} else {
				$("tbody tr.new_table").hide();
				$("tbody tr").removeClass('shown');
            	row.child($(

                	'<tr>'+
                    	'<td colspan="3"></td>'+
                    	'<td colspan="15">'+
							
							'<table class="tb-segumientos" cellspacing="0" border="0">'+
								'<thead>'+
									'<tr>'+
										'<th>Fecha</th>'+
										'<th>Usuario</th>'+
										'<th>Seguimiento</th>'+
									'</tr>'+
								'</thead>'+

								'<tfoot>'+
									'<tr>'+
										'<th>Fecha</th>'+
										'<th>Usuario</th>'+
										'<th>Seguimiento</th>'+
									'</tr>'+
								'</tfoot>'+
							'</table>'+
							
						'</td>'+
                	'</tr>'
				)).show();
				$("tbody tr").removeClass('shown');
				tr.addClass('shown');
			}
			
			dataSegumientos = $('table.tb-segumientos').DataTable({
				processing:		true,
				serverSide:		true,
				retrieve:		true, //**
				info:			true, //**
				searching:		false,
				scrollX:		false,
				lengthChange:	false,
				autoWidth:		false,
				filter:			false, //**
				pageLength:		10,
				ajax:			{
									url: "<?=base_url()?>crm/listaSeguimientosProspectosAjax",
									type: 'POST',
									data: {idCrm: idCrm},
									error:function(er,settings){
										console.log(er); //--> Litu
										//$('#modalPreload').modal('hide');
									}
								},
				aoColumns: 		[
									{
										"data":"fechaCreacion",
									},
									{
										"data":"userName",
									},
									{
										"data":"seguimiento",
									},
								],
				"columnDefs":	[
									{ //** Fecha Creacion
										"targets": 0,
										"width": "85px",
										"class": "center"
									},
									{ //** Nombre Usuario
										"targets": 1,
										"width": "120px",
										"class": "center"
									},
									{ //** Texto Seguimiento
										"targets": 2,
										"class": "justify",
									}
								],
				language: 		{
									"sProcessing":     "",
									"sLengthMenu":     "Mostrar _MENU_ registros",
									"sZeroRecords":    "No se encontraron resultados",
									"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
									"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
									"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
									"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
									"sInfoPostFix":    "",
									"sSearch":         "Buscar:",
									"sUrl":            "",
									"sInfoThousands":  ",",
									"sLoadingRecords": "Cargando...",
									"oPaginate": {
											"sFirst":    "Primero",
											"sLast":     "&Uacute;ltimo",
											"sNext":     "Siguiente",
											"sPrevious": "Anterior"
									},
									"oAria": {
											"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
											"sSortDescending": ": Activar para ordenar la columna de manera descendente",
									}
								},
			});

		});

		/** Ver Tabla Documentos **/
		//Global
		var dataDocumentos = {};
		/***/
		$('#listado_prospectos')
		.on('click', '.showDocumentos',function () {
			var tr = $(this).closest('tr');
        	var row = table.row( tr );
			var idCrm = row.data()[0]; //row.data().idCrm;
		
			if(row.child.isShown()){
				row.child.hide();
				tr.removeClass('shown');
			} else {
				$("tbody tr.new_tableDocumentos").hide();
				$("tbody tr").removeClass('shown');
            	row.child($(
                	'<tr>'+
                    	'<td colspan="3"></td>'+
                    	'<td colspan="15">'+
							
							'<table id="listado_documentos" class="tb-documentos" cellspacing="0" border="0">'+
								'<thead>'+
									'<tr>'+
										'<th>Fecha</th>'+
										'<th>Tipo Documento</th>'+
										'<th>Documento</th>'+
									'</tr>'+
								'</thead>'+

								'<tfoot>'+
									'<tr>'+
										'<th>Fecha</th>'+
										'<th>Tipo Documento</th>'+
										'<th>Documento</th>'+
									'</tr>'+
								'</tfoot>'+
							'</table>'+
							
						'</td>'+
                	'</tr>'
				)).show();
				$("tbody tr").removeClass('shown');
				tr.addClass('shown');
			}
			
			dataDocumentos = $('table.tb-documentos').DataTable({
				processing:		true,
				serverSide:		true,
				retrieve:		true, //**
				info:			true, //**
				searching:		false,
				scrollX:		false,
				lengthChange:	false,
				autoWidth:		false,
				filter:			false, //**
				pageLength:		10,
				ajax:			{
									url: "<?=base_url()?>crm/listaDocumentosProspectosAjax",
									type: 'POST',
									data: {idCrm: idCrm},
									error:function(er,settings){
										// console.log(er); // Liu -->
										//$('#modalPreload').modal('hide');
									}
								},
				aoColumns: 		[
									{
										"data":"fechaCreacion",
									},
									{
										"data":"tipoDocumento",
									},
									{
										"data":"nombreAdjunto",
										"fnCreatedCell": function (nTd, sData, oData, iRow, iCol){
											$(nTd).html("<a title='Click - Descargar Documento' href='"+oData.urlAdjunto+"' target='_blank'>"+oData.nombreAdjunto+"</a>");
										}
									},
								],
				"columnDefs":	[
									{ //** Fecha Creacion
										"targets": 0,
										"width": "85px",
										"class": "center"
									},
									{ //** Tipo Documento
										"targets": 1,
										"width": "120px",
										"class": "center"
									},
									{ //** Documento Adjunto
										"targets": 2,
										"class": "justify",
									}
								],
				language: 		{
									"sProcessing":     "",
									"sLengthMenu":     "Mostrar _MENU_ registros",
									"sZeroRecords":    "No se encontraron resultados",
									"sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
									"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
									"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
									"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
									"sInfoPostFix":    "",
									"sSearch":         "Buscar:",
									"sUrl":            "",
									"sInfoThousands":  ",",
									"sLoadingRecords": "Cargando...",
									"oPaginate": {
											"sFirst":    "Primero",
											"sLast":     "&Uacute;ltimo",
											"sNext":     "Siguiente",
											"sPrevious": "Anterior"
									},
									"oAria": {
											"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
											"sSortDescending": ": Activar para ordenar la columna de manera descendente",
									}
								},
			});

		});	
		
		/** Eliminar Prospecto **/
		//Global
		var dataProspecto = {};
		/***/
		$('#listado_prospectos')
		.on('click', '.deleteProspecto',function () {
			var tr = $(this).closest('tr');
        	var row = table.row( tr );
			var idCrm = row.data()[0]; //row.data().idCrm;

			if(confirm('¿Estás seguro que quieres eliminar esto?')){
			window.open('<?=base_url("crm/eliminar/prospecto?idCrm=")?>'+idCrm,'_self');
				/*
				$.ajax({
					url:	'myUrl',
					type:	"POST",
					data:	{
						// data stuff here
					},
            		success:	function () {
                		// does some stuff here...
					}
				});
				*/
			}

//
/*
			$("#dialog-confirm").dialog({
				resizable: false,
				height: "auto",
				width: 400,
				modal: true,
				buttons: {
        					"Delete all items": function() {
								$( this ).dialog( "close" );	
							},
							Cancel: function() {
								$( this ).dialog( "close" );
							}
				}
			});
*/
//
/*
$.confirm({
    title: 'Confirm!',
    content: 'Simple confirm!',
    confirm: function(){
        $.alert('Confirmed!');
    },
    cancel: function(){
        $.alert('Canceled!')
    }
});
*/
		});	
	});
</script>