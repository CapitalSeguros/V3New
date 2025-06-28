<?php $this->load->view('actividades/actividadesComentariosOperativos');?>
<?php

$IDCli = $this->input->get('IDCli', TRUE);
$page = $this->input->get('page', TRUE);
$documentosParaRecotizar='';
if($page == ""){
	$page = 1;
}
#var_dump($ClienteContact);
#var_dump($SubGrupo);

if(!isset($ClienteContact)){redirect('/directorio');}?>

<?
	$usermail = $this->tank_auth->get_usermail();
	$moduloConfiguraciones	= "";
	$nubeVehiculos			= "";
	$nubeDanos				= "";
	$tomarActividad			= "";
	$viaOficina				= "";
	$cotizada				= "";

	foreach($configModulos as $modulos){
		if($modulos['modulo'] == "configuraciones"){ $moduloConfiguraciones.= TRUE; } else { $moduloConfiguraciones.= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeVEHICULOS"){ $nubeVehiculos .= TRUE; } else { $nubeVehiculos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "cotizadorNubeDANOS"){ $nubeDanos .= TRUE; } else { $nubeDanos .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "terminarBloquearsi"){ $tomarActividad .= TRUE; } else { $tomarActividad .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "terminarViaOficinasi"){ $viaOficina .= TRUE; } else { $viaOficina .= FALSE; }
		if($modulos['subModulo'].$modulos['permiso'] == "terminarActividadsi"){ $cotizada .= TRUE; } else { $cotizada .= FALSE; }
	}
?>
<?php $folioActividad	= $this->uri->segment(3);?>
<?
$ci = &get_instance();
$ci->load->model("bitly_model");
?>
<?php $this->load->view('headers/header'); ?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>
<script type="text/javascript">
	
	function cargarDocumentoFin(objeto='')
	{
            if( document.getElementById('cargaArchivosDiv')){
		   document.getElementById('cargaArchivosDiv').classList.remove('verVisorArchivos');
	          document.getElementById('cargaArchivosDiv').classList.add('ocultarVisorArchivos')
	      }
	}
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> Ojo Complemeto en Conflicto con easytree -->
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div style="display: flex">
		<div style="flex:3"><h3 class="titulo-secciones">Actividades [<?=$infoFolioActividad->tipoActividad?>]</h3></div>
        <div style="flex:2;display: flex;justify-content: end">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li><a href="<?=base_url()?>actividades" title="Actividades">Actividades</a></li>
                <!--li class="active">Actividades Ver [<?=$infoFolioActividad->tipoActividad?>]</li-->
            </ol>
        </div>
    </div>
        <hr /> 
</section>

<section class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<button class="btn btn-info btnActividadComentariosOperativos" onclick="abrirVentanaComentariosOperativos('',<?=$infoFolioActividad->idInterno?>,'<?=$infoFolioActividad->folioActividad?>')">&#128172</button>
				<label>Folio:</label>
                <label style="color:#F00;">
				<?=$infoFolioActividad->folioActividad?>
                [<?=($infoFolioActividad->tipoActividadSicas == "ot")?$infoFolioActividad->NumSolicitud:$infoFolioActividad->idSicas?>]
                </label>
            </div>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right">
            	<label><strong>Fecha Creaci&oacute;n</strong></label>
                <br />
				<label><?=$infoFolioActividad->fechaCreacion?></label>
            </div>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-6 col-md-6" align="left">
            <?	if(
					$infoFolioActividad->tipoActividad == "Cotizacion"
					&&
					$infoFolioActividad->fechaEmite == ""  &&  $infoFolioActividad->Status!=6
				){?>
            	<input type="button" value="Emision"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>actividades/emitir/<?=$folioActividad?>','_self');"
					class="btn btn-primary btn-sm"
                />
			<? } ?>
            <br />
            <?	if(
					$tomarActividad
					&&
					$infoFolioActividad->Status == "5"
				){?>
            	<input 
                	type="button" value="Tomar Actividad"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>actividades/tomaractividad/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
					class="btn btn-primary btn-sm"
                />
			<? } else if(
					$tomarActividad
					&&
					$infoFolioActividad->Status == "3"
					&&
					$infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()
				){ ?>
            	<input type="button" value="Soltar Actividad" title="Clic" onclick="window.open('<?=base_url()?>actividades/soltaractividad/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');" class="btn btn-primary btn-sm"
                />
            <? } ?>
            <?	if(
					$viaOficina
					&&
					$infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()
				){?>
            	<input 
                	type="button" value="V&iacute;a Oficina"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>actividades/viaoficina/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
					class="btn btn-primary btn-sm"
                />
			<? } ?>
            <?	if(
					$cotizada
					&&
					$infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()
				){?>
            	<input 
                	type="button" value="Cotizada"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>actividades/cotizada/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
					class="btn btn-primary btn-sm"
                />
			<? } ?>
            </div>
			<div class="form-group col-sm-6 col-md-6" align="right">
            	<label><strong>Status</strong></label>
				<br />
                <label><?=$this->capsysdre_actividades->Status($infoFolioActividad->Status)?></label>
            </div>
        </div>
       
        <?
		if($infoFolioActividad->actividadImportante == "1"){
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right" style="color:#F00; font-size:12px">
				<strong>!!! Actividad Importante !!!</strong>
            </div>
		</div>
        <?
		}
		?>
        
        <? if($infoFolioActividad->fechaPromesa != NULL){ ?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right">
            	<label><strong>Fecha Promesa</strong></label>
                <br />
                <?=$infoFolioActividad->fechaPromesa?>
            </div>
        </div>
        <? } ?>
        
<!-- Datos Cliente -->
<section class="container-fluid">
	<form id="frmClient" action="<?php echo base_url();?>actividades/updateClient">
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label class="formaNombreForm">
				<strong>Datos Cliente</strong>
                </label>
			</div>
		</div>
        
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
	<!-- New -->

	            <div class="row" style="<?=$ocultarParaClienteNuevo?>">
	                <div class="form-group col-md-6 col-sm-6 col-xs-4">
                        <a
							href="#"
                            id="aCDigital"
                            title="Centro Digital - Cliente" 
                            class="btn btn-default btn-sm"
						>
							&nbsp;<i class="fa fa-archive fa-lg"></i>&nbsp;
						</a>

                        <a 
							href="#"
							title="Editar - Cliente"
                            id="aEdit" style="margin-left:10px;"
							class="btn btn-default btn-sm"
						>
							&nbsp;<i class="fa fa-pencil-square-o fa-lg"></i>&nbsp;
                        </a>
<!--                         <a href="#" title="Documentos - Cliente" id="aCDocuments" style="margin-left:10px;"
							class="btn btn-default btn-sm">&nbsp;<i class="fa fa-file-text" style="font-size: 13px;"></i>&nbsp;
                        </a> -->
                        <a	title="Documentos - Cliente" id="btn-Docs" data-idcli="<?=$ClienteContact["cliente"]->IDCli?>" style="margin-left:10px;"
							class="btn btn-default btn-sm">&nbsp;<i class="fa fa-file-pdf-o" style="font-size: 15px;"></i>&nbsp;
                        </a>
	                </div>
                    
	                <div class="form-group col-md-6 col-sm-6 col-xs-8 text-right">
                    	<input type="hidden" id="folioActividad" name="folioActividad" value="<?= $infoFolioActividad->folioActividad; ?>" />
	                    <button type="button" class="btn btn-default btn-sm ctl-save" id="btnCancel" name="operacion" title="CANCELAR" disabled >CANCELAR</button>

	                    <button type="submit" class="btn btn-primary btn-sm ctl-save" id="btnSave" name="operacion" value="Guardar" disabled >GUARDAR</button>
	                </div>
	            </div>

	<!-- Documentacion Cliente -->
	<div class="" id="tabContent-Docs" style="margin-bottom: 50px;border-top: .1px solid lightgrey;border-bottom: .1px solid lightgray;display: none;">
		<div class="d-flex p-2">
			<h4 style="font-size:20px;">Documentación</h4>
		</div>
		<div class="tab-content" style="border: 0.1px solid whitesmoke;background-color: #2151;margin-bottom:15px;">
  			<div class="tab-pane fade show" id="pills-docs" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0" style="opacity:1;visibility: visible;">
				<div class="d-inline-flex p-2">
					<div class="col-md-4">
                		<i><strong>Cliente</strong></i><br>
                		<?= $ClienteContact["cliente"]->NombreCompleto; ?>
            		</div>
					<div class="col-md-4">
               			<?
							if($infoFolioActividad->usuarioVendedor != ""){
								?>
                					<i><strong>Vendedor</strong></i><br>
									<?= $infoFolioActividad->nombreUsuarioVendedor; ?>
                					[<?= $infoFolioActividad->usuarioVendedor; ?>]
								<?
							}
						?>
					</div>
					<div class="col-md-4"><h5>CLICK DERECHO AL MOUSE SOBRE EL DOCUMENTO PARA SU VISUALIZACION PREVIA</h5><h5 id="nombreDocumentoH4"></h5></div>
				</div>
				<section>
					<div class="container-spinner-docs-client" id="loading-docs-client">
						<div class="spinner-border" role="status">
  							<span class="visually-hidden"></span>
						</div>
					</div>
					<div class="row row-tabs">
                        <div id="tab_doc" class="col-md-4"></div>
                        <div class="col-md-8">
                        	<!--embed id="ventanaMostrarImagen" src="" type="application/pdf" style="height: auto;" width="500px" height="400px" /-->
                        	<iframe class="ocultarVisorArchivos" id="visorGeneral" onload='cargarDocumentoFin(this)' src="" frameborder="0"></iframe>
                        	<iframe class="ocultarVisorArchivos" id="visorTXT" onload='cargarDocumentoFin(this)' src="" frameborder="0"></iframe>

                        	<iframe class="ocultarVisorArchivos" id="visorXMLDOC" onload='cargarDocumentoFin(this)' src=""></iframe>
                            <div id="visorJPGDiv" class="ocultarVisorArchivos" style="height: 300px;overflow: scroll;"><img  id="visorJPG"  onload='cargarDocumentoFin(this)'> </img></div>
                            <div class="ocultarVisorArchivos" id="visorSinProcesarArchivo"><h1>ESTE VISOR NO PUEDE PROCESAR ESTE TIPO DE ARCHIVO, DALE CLICK IZQUIERDO AL ARCHIVO</h1></div>
                            <div id="cargaArchivosDiv" class="ocultarVisorArchivos" style=""><img src="<?=base_url()?>assets/images/loading.gif"></div>

                       
                        </div>
					</div>
				</section>
			</div>
  		</div>
		<div class="d-flex flex-row-reverse">
			<a tittle="Cerrar Documentación" id="close-tab-Docs" style="margin-left:0px;margin-bottom: 15px" class="btn btn-default">Cerrar</a>
		</div>
	</div>


                
	             <!-- Nav tabs -->
	            <ul class="nav nav-tabs" role="tablist">
	                <li role="presentation" class="active"><a href="#tab-01" aria-controls="tab-01" role="tab" data-toggle="tab">Generales</a></li>
	                <li role="presentation" style="<?=$ocultarParaClienteNuevo?>"><a href="#tab-02" aria-controls="tab-02" role="tab" data-toggle="tab">Contacto</a></li>
	                <li role="presentation" style="<?=$ocultarParaClienteNuevo?>"><a href="#tab-03" aria-controls="tab-03" role="tab" data-toggle="tab">Direcciones</a></li>
	            </ul>

	            <div class="tab-content">
	            	<div role="tabpanel" class="tab-pane fade in active" id="tab-01">
						<div class="row">
	            			<div class="form-group col-md-3 col-sm-3">
	                            <label for="Entidad">Entidad</label>
	                            <input type="hidden" class="form-control" name="idcli" value="<?php echo $ClienteContact["cliente"]->IDCli; ?>" >
								<input type="hidden" class="form-control" name="idcont" value="<?php echo $ClienteContact["cliente"]->IDCont; ?>" >
								<select class="form-control input-sm" name="tipoEntidad" id="tipoent" disabled >
									<option value="1" <?php echo ($ClienteContact["cliente"]->TipoEnt == "1")?'selected = "selected"':''; ?> >Moral</option>
									<option value="0" <?php echo ($ClienteContact["cliente"]->TipoEnt == "0")?'selected = "selected"':''; ?>>F&iacute;sica</option>
								</select>
	                        </div>
	            			<div class="form-group col-md-3 col-sm-3"><!-- JjHe -->
								<label for="Calidad">Ranking</label>
								<a class="form-control" disabled id="txtEdad"><?=$ClienteContact["cliente"]->Calidad?></a>
                            </div>
	            			<div class="form-group col-md-3 col-sm-3"><!-- JjHe -->
								<label for="Expediente">Club Cap</label>
	                            <input type="text" class="form-control  input-sm" name="Expediente" value="<?=$ClienteContact["cliente"]->Expediente?>" disabled />
                            </div>
	            			<div class="form-group col-md-3 col-sm-3"><!-- JjHe -->
								<label for="ClaveTKM">Poliza Verde</label>
								<select class="form-control input-sm" name="ClaveTKM" id="ClaveTKM" disabled >
									<option value="POLIZA_VERDE" <?=($ClienteContact["cliente"]->ClaveTKM == "POLIZA_VERDE")?'selected = "selected"':''; ?> >Si</option>
									<option value="" <?=($ClienteContact["cliente"]->ClaveTKM != "POLIZA_VERDE")?'selected = "selected"':''; ?>>No</option>
								</select>
                            </div>
	                        

	
                         	
	            		</div>
	                    <div class="row">
                        	<div class="form-group col-md-12 col-sm-12 ctn-m <?php echo ($ClienteContact["cliente"]->TipoEnt == '0')?'entidad-moral':''; ?> ">
	                            <label for="RazonSocial">Raz&#243;n social</label>
	                            <input type="text" class="form-control  input-sm" name="razonSocial" value="<?php echo $ClienteContact["cliente"]->RazonSocial; ?>" disabled />
	                        </div>
                            
	                        <div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Nombre</label>
	                            <input type="text" class="form-control input-sm" name="nombre" value="<?php echo $ClienteContact["cliente"]->Nombre; ?>" disabled />
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Apell. Pat.</label>
	                            <input type="text" class="form-control input-sm" name="apellidoP" value="<?php echo $ClienteContact["cliente"]->ApellidoP; ?>" disabled />
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Apell. Mat.</label>
	                            <input type="text" class="form-control input-sm" name="apellidoM" value="<?php echo $ClienteContact["cliente"]->ApellidoM; ?>" disabled>
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Sexo</label>
	                            <select name="sexo" class="form-control input-sm" disabled>
									<option value="0" <?php echo ($ClienteContact["cliente"]->Sexo == "0" ? "selected" : ''); ?>>Masculino</option>
									<option value="1" <?php echo ($ClienteContact["cliente"]->Sexo == "1" ? "selected" : ''); ?>>Femenino</option>
								</select>
	                        </div>
	                    </div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Fec. Nac.</label>
	                          	<input type="text" class="form-control input-sm fecha" name="fechaNac" placeholder="01/01/1900" value="<?php echo strftime("%d/%m/%Y", strtotime($ClienteContact["cliente"]->FechaNac)); ?>" disabled>
	                        </div>
                            <div class="form-group col-md-3 col-sm-3 ctn-m <?php echo ($ClienteContact["cliente"]->TipoEnt == '0')?'entidad-moral':''; ?>">
	                            <label for="Celular">Fecha Constituci&#243;n</label>
	                          	<input type="text" class="form-control input-sm fecha" name="fechaCons" placeholder="01/01/1900" value="<?php echo strftime("%d/%m/%Y", strtotime($ClienteContact["cliente"]->FechaConst)); ?>" disabled>
	                        </div>
                            
	                        <div class="form-group col-md-3 col-sm-3 ctn-f <?php echo ($ClienteContact["cliente"]->TipoEnt == '1')?'entidad-moral':''; ?>">
	                            <label for="Celular">Edad</label>
	                            
	                        	<a class="form-control" disabled id="txtEdad"><?php echo $ClienteContact["cliente"]->CEdad; ?></a>
								<input type="hidden" class="form-control" id="edad" name="edad" value="<?php echo $ClienteContact["cliente"]->Edad; ?>" disabled>
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="Celular">Celular</label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-mobile fa-lg"></i></span>
	                                <input type="text" class="form-control input-sm" name="telefono1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo str_replace("Telefono1:","",$ClienteContact["cliente"]->Telefono1); ?>" disabled />
	                            </div>
	                        </div>
	                        <div class="form-group col-md-3 col-sm-3">
	                            <label for="RFC">RFC</label>
	                            <input type="text" class="form-control input-sm" name="rfc" value="<?php echo $ClienteContact["cliente"]->RFC; ?>" maxlength="13" minlegth="12" disabled />
	                        </div>
						</div>
						<div class="row">
							<div class="form-group col-md-3 col-sm-3">
	                            <label for="Correo1">Correo 1</label>
	                            <div class="input-group">
	                                <span class="input-group-addon"><i class="fa fa-envelope fa-lg"></i></span>
	                                <input type="email" class="form-control input-sm" name="email1" value="<?php echo $ClienteContact["cliente"]->EMail1; ?>" disabled />
	                            </div>
	                        </div>
						</div>
	                </div>

		            <!-- INICIO CONTENIDO TAB -->
		            <div role="tabpanel" class="tab-pane fade" id="tab-02">
					 	<div class="row">
		                    <div class="form-group col-md-12 text-right">
		                        <a href="#"  class="btn btn-default btn-sm addCto " title="Agregar contacto" disabled >&nbsp;<i class="fa fa-plus-circle fa-lg "></i> Agregar contacto</a>
		                    </div>
		                </div>

		                <?php
							if(isset($ClienteContact["contactos"])){
							   //tipoEnt
							   // var_dump($ClienteContact["contactos"]);
						?>
						<div class="row">
						   <div class="col-md-12 custyle">
								<table class="table table-striped custab">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Puesto / Trato</th>
											<th>Nacionalida / Idioma</th>
											<th>Correo 1</th>
											<th>Tel&#233;fono</th>
											<th class="text-center">Acci&#243;n </th>
										</tr>
									</thead>
									<tbody id="tabbody">
										<?php
											$i = 0;
											foreach($ClienteContact["contactos"] as $key => $contacto){
												$i += 1;	?>
												<tr>
													<td><?php echo $contacto->Nombre . " " . $contacto->ApellidoP . " " . $contacto->ApellidoM; ?></td>
													<td><?php echo $contacto->Puesto; ?></td>
													<td><?php if(isset($contacto->Nacionalidad)){ echo $contacto->Nacionalidad; } ?></td>
													<td><?php echo $contacto->EMail1; ?></td>
													<td><?php if(isset($contacto->Telefono1)){ echo $contacto->Telefono1; } ?></td>
													<td class="text-center">
														<input type="hidden" name="contacto-<?php echo $i;?>" class="cto-itm"
															data-IdCont="<?php echo $contacto->IDCont; ?>" 
															data-Nombre="<?php echo $contacto->Nombre; ?>" 
															data-ApellidoP="<?php echo $contacto->ApellidoP; ?>" 
															data-ApellidoM="<?php echo $contacto->ApellidoM; ?>" 
															data-Alias="<?php echo $contacto->Abreviacion; ?>"
															data-Sexo="<?php echo $contacto->Sexo; ?>" 
															data-Edad="<?php echo $contacto->Edad; ?>" 
															data-FechaNac="<?php echo $contacto->FechaNac; ?>"
															data-Email1="<?php echo $contacto->EMail1; ?>"
															data-Telefono1="<?php echo $contacto->Telefono1; ?>"
															data-Nacionalidad="<?php echo $contacto->Nacionalidad; ?>"
														>
														<a name="ver" class='btn btn-primary btn-xs contact-item' data-toggle="modal" data-target="#contact" data-original-title>
															<span class="glyphicon glyphicon-eye-open" ></span> 
														Ver Info</a>
														<a name="editar" class='btn btn-primary btn-xs contact-item hidden' data-toggle="modal" data-target="#contact" data-original-title>
															<span class="glyphicon glyphicon-edit"></span> 
														Editar</a>
														<!--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>-->
												</tr>	
											<?php
											}
											?>																					
									</tbody>												
								</table>
							</div>
						</div>
						<?php
							}
						?>
		            </div>
		            <!-- FIN CONTENIDO TAB -->

		         	<!-- INICIO CONTENIDO TAB -->
		            <div role="tabpanel" class="tab-pane fade" id="tab-03">
		                <div class="row">
		                    <div class="form-group col-md-12 text-right">
		                        <a href="#"  class="btn btn-default btn-sm addDic ctl-save"  title="Agregar dirección" disabled >&nbsp;<i class="fa fa-plus-circle fa-lg"></i> Agregar direcci&#243;n</a>
		                    </div>
		                </div>
		                <div class="row">
		                    <div class="col-md-12 table-responsive">
		                        <?php
								if(isset($Direcciones)){
								?>
								<div class="row">
									   <div class="col-md-12 custyle">
										<table class="table table-striped custab">
											<thead>
												<tr>
													<th>Calle</th>
													<th>No Ext</th>
													<th>No Int</th>
													<th>C&#243;digo Postal</th>
													<th>Colonia</th>
													<th>Poblaci&#243;n</th>
													<th>Ciudad</th>
													<th>Pa&#237;s</th>
													<th>Tel&#233;fono</th>
													<th>Tel&#233;fono2</th>
													<th class="text-center">Acci&#243;n &nbsp;&nbsp;<a class="fa fa-plus-circle addDic" disabled>&nbsp;Direcci&#243;n</a></th>
												</tr>
											</thead>
											<tbody id="tabbodyd">
												<?php
													$i = 0;
													foreach($Direcciones as $key => $contacto){
														$i += 1;	?>
														<tr>
															<td><?php echo $contacto->Calle ?></td>
															<td><?php echo $contacto->NOExt; ?></td>
															<td><?php echo $contacto->NOInt; ?></td>
															<td><?php echo $contacto->CPostal; ?></td>
															<td><?php echo $contacto->Colonia; ?></td>
															<td><?php echo $contacto->Poblacion; ?></td>
															<td><?php echo $contacto->Ciudad; ?></td>
															<td><?php echo $contacto->Pais; ?></td>
															<td><?php if(isset($contacto->Telefono1)){ echo str_replace("Telefono1:","",$contacto->Telefono1); } ?></td>
															<td><?php if(isset($contacto->Telefono2)){ echo str_replace("Telefono2:","",$contacto->Telefono2); } ?></td>
															<td class="text-center">
																<input type="hidden" name="direccion-<?php echo $i;?>" class="dic-itm"
																	data-IDDir="<?php echo $contacto->IDDir; ?>" 
																	data-Calle="<?php echo $contacto->Calle; ?>" 
																	data-NOExt="<?php echo $contacto->NOExt; ?>" 
																	data-NoInt="<?php echo $contacto->NOInt; ?>" 
																	data-CPostal="<?php echo $contacto->CPostal; ?>"
																	data-Colonia="<?php echo $contacto->Colonia; ?>" 
																	data-Poblacion="<?php echo $contacto->Poblacion; ?>" 
																	data-Ciudad="<?php echo $contacto->Ciudad; ?>"
																	data-Pais="<?php echo $contacto->Pais; ?>"
																	data-Telefono1="<?php echo str_replace("Telefono1:","",$contacto->Telefono1); ?>"
																	data-Telefono2="<?php echo str_replace("Telefono2:","",$contacto->Telefono2); ?>"
																>
																<a name="ver" class='btn btn-primary btn-xs address-item' data-toggle="modal" data-target="#address" data-original-title>
																	<span class="glyphicon glyphicon-eye-open" ></span> 
																	Ver Info
                                                                </a>
																<a 
                                                                	name="utilizar" class='btn btn-primary btn-xs' 
                                                                    href="<?= 
																		base_url("actividades/agregarSeguimiento?").
																		"oldPosicion=".$infoFolioActividad->Status.
																		"&ClaveBit=".$infoFolioActividad->ClaveBit.
																		"&Procedencia=".$infoFolioActividad->tipoActividad." Capsys Web ".$infoFolioActividad->folioActividad.
																		"&IDDocto=".$infoFolioActividad->idSicas.
																		"&folioActividad=".$infoFolioActividad->folioActividad.
																		"&tipoActividadSicas=".$infoFolioActividad->tipoActividadSicas.
																		"&Comentario="."Utilizar Esta Direccion \n\r ** Calle: ".$contacto->Calle." No Ext: ".$contacto->NOExt." No Int: ".$contacto->NOInt." Cp: ".$contacto->CPostal." Colonia: ".$contacto->Colonia." Poblacion: ".$contacto->Poblacion." Ciudad: ".$contacto->Ciudad." Pais: ".$contacto->Pais;
																		
																		 ?>"
                                                                >
																	<span class="glyphicon glyphicon-flag" ></span> 
																	Utilizar
                                                                </a>
																<a name="editar" class='btn btn-primary btn-xs address-item hidden' data-toggle="modal" data-target="#address" data-original-title>
																	<span class="glyphicon glyphicon-edit"></span> 
																	Editar
                                                                </a>
																<!--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>-->
														</tr>	
														<?php
													}
												?>																					
											</tbody>												
										</table>
										</div>
								</div>
								<?php
									}
								?>
		                    </div>
		                </div>
		            </div>
		            <!-- FIN CONTENIDO TAB -->
				</div>	            
    <!-- !New -->
			</div>
		</div>
    </form>
</section>
<!-- !Datos Cliente -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">            	
				<label style=" text-decoration:underline;">
				<strong>Informaci&oacute;n Actividad</strong>
                </label>
            </div>
		</div>        
<!-- -->
<?
if($infoFolioActividad->usuarioVendedor != Null){
?>
<?
	if($infoFolioActividad->usuarioVendedor != $infoFolioActividad->usuarioCreacion){
?>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Creador</strong></label>
                <br />
                <label>
				<?
					print($this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion));
					print("&nbsp;[".$infoFolioActividad->usuarioCreacion."]");
				?>
			   </label>
			</div>
		</div>
<?
	}
?>
		<div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Vendedor</strong></label>
                <br />
                <label>
				<?
					print($this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioVendedor));
					print("&nbsp;[".$infoFolioActividad->usuarioVendedor."]&nbsp;");
					//print("<b>".$this->capsysdre->RankingUsuarioEmaildeMiinfo($infoFolioActividad->usuarioVendedor)."</b>&nbsp;");
					//print("<b>".$this->capsysdre->ClasificacionVendedor($infoFolioActividad->usuarioVendedor)."</b>");
					if($infoFolioActividad->usuarioVendedor!=Null){$informacion=$this->capsysdre->devolverDatosActividades($infoFolioActividad->usuarioVendedor);}else{
					$informacion=$this->capsysdre->devolverDatosActividades($infoFolioActividad->usuarioCreacion);}
					print("<br />[".$informacion[0]->idpersonarankingagente."]");
					print("<br />[".$informacion[0]->personaTipoAgente."]"); 
					 
				?>
			</label>
            </div>
            <div class="form-group col-sm-6 col-md-6">
            	<label><strong>Autorizado para asesorar</strong></label>
                <br />
                <label>
                <?
					print($this->capsysdre->CertificacionesVendedor($infoFolioActividad->usuarioVendedor));
				?>
			</label>
            </div>
        </div>
<?
} else {
?>
        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Creador</strong></label>
                <br />
                <label>
                <?
                	print($this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion));
                	print("&nbsp;[".$infoFolioActividad->usuarioCreacion."]&nbsp;");
					print("<strong>".$this->capsysdre->RankingUsuarioEmail($infoFolioActividad->usuarioCreacion)."</strong>&nbsp;");
					print("<strong>".$this->capsysdre->ClasificacionVendedor($infoFolioActividad->usuarioCreacion)."</strong>");
				?>
			</label>
			</div>
            <div class="form-group col-sm-6 col-md-6">
            	<label><strong>Autorizado para asesorar</strong></label>
                <br />
                <label>
                <?
					print($this->capsysdre->CertificacionesVendedor($infoFolioActividad->usuarioCreacion));
				?>
			</label>
            </div>
        </div>
<?
}
?>
<!-- -->
        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Responsable</strong></label>
                <br />
                <label>
               <!-- <?=$this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioResponsable)?>-->
                <?=$infoFolioActividad->usuarioResponsable?>
            </label>
			</div>
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Actividad</strong></label>
                <br />
                <label>
            	<?
				if($infoFolioActividadEmi != NULL){
				?>
				<?=$infoFolioActividadEmi->tipoActividad." - ".$infoFolioActividadEmi->subRamoActividad?>
                <?="<br />"?>
                <?
				}
				?>
				<?=$infoFolioActividad->tipoActividad." - ".$infoFolioActividad->subRamoActividad?>
			</label>
			</div>
        </div>
        <?
			if($infoFolioActividad->tipoActividadSicas == "ot"){
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Concepto</strong></label>
                <br />
                <label>
                <?= (!empty($infoDocumento))? $infoDocumento[0]->Concepto:""; ?>
            </label>
			</div>
        </div>
        <?
			}
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Datos Cotizaci&oacute;n Expr&eacute;s</strong></label>
                <br />
                <label>
            	<?
				if($infoFolioActividadEmi != NULL){
					echo $infoFolioActividadEmi->datosExpres;
					echo "<br />";
				}
				?>
			</label>
			<label>
	            	<?=$infoFolioActividad->datosExpres;?>
	            </label>
			</div>            
		</div>

<?
	if($infoFolioActividad->tipoActividad == "AplicacionPago"){
?>
<!-- Tarjeta Pago Actividad -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;">
				<strong>Tarjeta Pago</strong>
                </label>
			</div>        
		</div>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2">
            Tipo de pago aplicación
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipoPago; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
            Banco
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaBanco; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
            Tipo tarjeta
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipo; ?>" />
            </div>
			<div class="form-group col-sm-6 col-md-6">
			Titular de la tarjeta
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTitular; ?>" />
            </div>
		</div>
        <?
		//--> $this->tank_auth->ci->session->userdata["user_id"] == "215" && $this->tank_auth->ci->session->userdata["user_id"] = "228"
		if($usermail == "COBRANZA1@ASESORESCAPITAL.COM"){
		?>
        <div class="row">
			<div class="form-group col-sm-4 col-md-4">
			Número de tarjeta
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaNumero; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
			Vencimiento
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaMes; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaYear; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
			Código de Seguridad 
            <br />
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaCcv; ?>" />
            </div>
		</div>
        <?
		} else {
			$numeroTarjetaRecortado = "**** **** **** ";
			$numeroTarjetaRecortado.= substr($infoFolioActividad->tarjetaNumero,12,4);
		?>
        <div class="row">
			<div class="form-group col-sm-4 col-md-4">
			Número de tarjeta
            <br />
            <input type="text" class="form-control input-sm" value="<?= $numeroTarjetaRecortado; ?>" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
			Vencimiento
            <br />
            <input type="text" class="form-control input-sm" value="**" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
            <br />
            <input type="text" class="form-control input-sm" value="****" />
            </div>
			<div class="form-group col-sm-2 col-md-2">
			Código de Seguridad 
            <br />
            <input type="text" class="form-control input-sm" value="***" />
            </div>
		</div>
        <?
		}
		?>
<!-- Tarjeta Pago Actividad -->
<?
	}
?>
<!-- Documentos Actividad -->

        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style=" text-decoration:underline;">
				<strong>Documentos</strong>
                </label>
			</div>
		</div>
<?
if($infoFolioActividad->motivoCambio==1)
{  
	if($infoFolioActividad->tipoActividad=='Cotizacion')
	{
		if($infoFolioActividad->idSicas!=''){
?>
<form method="post" action="<?=base_url().'actividades/agregarGuardar'?>">
   <textarea name="datosExpres" rows="5" cols="50" placeholder="Comentario"></textarea><br>
   <input type="hidden" name="idInternoPadre" value="<?=$infoFolioActividad->idInterno;?>">
   <input type="hidden" name="folioActividad" value="<?=$infoFolioActividad->folioActividad;?>">
   <input type="hidden" name="documentosWWW" id="documentosWWW" value="">
   <button class="btn btn-primary">Recotizar</button>
 </form>
  <? } else{?>
 <form method="post" action="<?=base_url().'actividades/crearRecotizacionProspeccion'?>">
   <textarea name="datosExpres" rows="5" cols="50" placeholder="Comentario"></textarea><br>
   <input type="hidden" name="idInternoPadre" value="<?=$infoFolioActividad->idInterno;?>">
   <input type="hidden" name="folioActividad" value="<?=$infoFolioActividad->folioActividad;?>">
   <button class="btn btn-primary">Recotizar</button>
 </form>
<?
    }
	}
	else
	{
	
 ?>

   <a href="<?=base_url().'actividades/agregar/Endoso/'.$infoFolioActividad->ramoActividad.'/'.$infoFolioActividad->IDSRamo.'/Existente?idCliente='.$infoFolioActividad->idCliente.'-0' ?>" class="btn btn-primary" target="_blank">Solicitar Endoso</a>
 <?}}?>
		<form 
        	class="form-group" role="form"
            id="formActividadVer_AgregaDocumentos" name="formActividadVer_AgregaDocumentos"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarDocumento"
		>
        <input type="hidden" name="enviar" value="">
<!-- -->

        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label>
				<strong>Agregar Documentos</strong>
				</label>
            </div>
		</div>
        
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label  for="descripcionArchivo">DESCRIPCION ARCHIVO</label>
                <br>
            	<input id="descripcionArchivo" name="descripcionArchivo" type="text"  maxlength="15" class="form-control input-sm" placeholder="ES NECEARIO AÑADIR UN COMENTARIO " required/>
            </div>
		</div>
		<div class="row">
			<div class="form-group col-sm-3 col-md-3">
            	<label>TIPO IMG DE ARCHIVO</label>
                <br />
            	<? print($SelectTipoImg); ?>
			</div>
			<div class="form-group col-sm-9 col-md-9">
            	<label >ARCHIVO (EL TAMAÑO MAXIMO DEL ARCHIVO ES DE 7 MB)</label>
                <br />
            	<input
                	id="DocumentoFiles" name="DocumentoFiles"
                	type="file" 
					class="form-control input-sm"
                />
			</div>            
		</div>
<!-- -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right">
            	<? 
					if($infoFolioActividad->tipoActividadSicas=="ot"){
						$TypeDestinoCDigital	= "DOCUMENT";
						$IDValuePK				= $infoFolioActividad->idSicas;
						$FolderDestino			= "";
					} else {
						$TypeDestinoCDigital	= "CLIENT";
						$IDValuePK				= $infoFolioActividad->idCliente;
						$FolderDestino			= "Target_".$infoFolioActividad->tipoActividad;
						if($infoFolioActividad->poliza!=""){
						$FolderDestino			.= "\\".$infoFolioActividad->poliza;
						}
					}
				?>
                <input type="hidden" name="folioActividad" id="folioActividad" value="<?=$infoFolioActividad->folioActividad?>" />
				<input type="hidden" name="TypeDestinoCDigital" id="TypeDestinoCDigital" value="<?=$TypeDestinoCDigital?>" />
				<input type="hidden" name="IDValuePK" id="IDValuePK" value="<?=$IDValuePK?>" />
                <input type="hidden" name="FolderDestino" id="FolderDestino" value="<?=$FolderDestino?>" />
                <input type="hidden" name="IDDocto" id="IDDocto" value="<?=$infoFolioActividad->idSicas?>" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$infoFolioActividad->tipoActividadSicas?>" />
                <input type="hidden" name="oldPosicion" id="oldPosicion" value="<?=$infoFolioActividad->Status?>" />  
                <input type="hidden" name="idCliente" id="idCliente" value="<?=$infoFolioActividad->idCliente?>" />  
                

                <? if ($this->capsysdre_actividades->Status($infoFolioActividad->Status)!='FINALIZADA')   
                { ?>

                		<input
                			type="submit" value="Enviar Documento"
							onclick="document.formActividadVer_AgregaDocumentos.enviar.value=document.formActividadVer_AgregaDocumentos.oldPosicion.value;
                        	agregarDocto(event)"
                    		id=""
							class="btn btn-primary btn-sm manejoActividad"
                		/>
                		<?
						if($this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4"){
							?>
               			<!--input type="submit" value="Enviar Documento [En Curso]" onclick="document.formActividadVer_AgregaDocumentos.enviar.value='5'; document.formActividadVer_AgregaDocumentos.submit();" id="5" class="btn btn-primary btn-sm manejoActividad"
                		/-->
                		  <input type="submit" value="Enviar Documento [En Curso]" onclick="document.formActividadVer_AgregaDocumentos.enviar.value='5'; agregarDocto(event)" id="5" class="btn btn-primary btn-sm manejoActividad"
                		/>
                		<input
                				type="submit" value="Enviar Documento [Finalizada]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='6'; agregarDocto(event)"
                    			id="6"
								class="btn btn-primary btn-sm manejoActividad" style="display: none;"
                		/>
               			 <input
                				type="submit" value="Enviar Documento [Pospuesta]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='7'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="7"
								class="btn btn-primary btn-sm manejoActividad" style="display: none;"
                		/>
                		<?
						}
						?>
				<?
				}
				?>
								
            </div>
		</div>
        </form>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:16px;">
				<strong>Documentos Actividad</strong>
				</label>
				<? // = $saldo; ?>
            </div>
		</div>
        <div id="DocumenosActividades">
        <? 
		if($verDocumentosActividad != false){

			$quitar = array("-", ".");
			$movilNumber='';
			$movilNumber	= str_replace($quitar, "", substr($infoCliente[0]->Telefono1, strpos($infoCliente[0]->Telefono1, ":")+1, strlen($infoCliente[0]->Telefono1)));
			
			if($movilNumber != false ){
				$siTieneNumero = true;
			}else{
				$siTieneNumero = false;
			}
			
		if($infoFolioActividad->tipoActividadSicas=="ot"){
			
			foreach($verDocumentosActividad as $documentos){
				
				if($documentos->Tipo ==1){
		?>
		<div class="contenedoDocumentosNombreDiv">
            <!-- Aqui poner links -->

            <div>
            	<? if($saldo >= '5.0000'){?>                    
    	            <button type="button" class="btn btn-primary linkSms" title="Clic - Enviar SMS" onclick="generaLinkEnvio('linkSms', '<?= $movilNumber; ?>', '', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-mobile" aria-hidden="true"></span>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-primary linkWhatSapp" title="Clic - Enviar WhatSapp" onclick="generaLinkEnvio('linkWhatSapp', '<?= $movilNumber; ?>', '', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-whatsapp" aria-hidden="true"></span>
                    </button>
                    &nbsp;
    	            <button type="button" class="btn btn-primary linkCorreo" title="Clic - Enviar Correo Electrónico" onclick="generaLinkEnvio('linkCorreo', '', '<?= $infoCliente[0]->EMail1; ?>', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-envelope-o" aria-hidden="true"></span>
                    </button>
            	<? } else {?>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar SMS"><span class="fa fa-mobile" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar WhatSapp"><span class="fa fa-whatsapp" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar Correo Electrónico"><span class="fa fa-envelope-o" aria-hidden="true"></span></button>
            	<? } ?>
            </div>
        
			<div>
            	<a href="<?=$documentos->PathWWW?>"  target="_blank" title="<?=$documentos->DateModify?>">
					<span class="glyphicon glyphicon-file" aria-hidden="true"><?=$documentos->NameShow?></span> 
					<? $documentosParaRecotizar.=$documentos->PathWWW.';';?>
                </a>                
            </div>
		</div>

		<?
				}
			}
		} else {
			
			foreach($verDocumentosActividad as $documentos){
				if($documentos->Tipo ==1){
					if(strpos($documentos->PathWWW, 'Target_'.$infoFolioActividad->tipoActividad)){
					$nameId='';
					if(strpos($documentos->PathWWW, 'Target_'.$infoFolioActividad->tipoActividad.'/'.$infoFolioActividad->poliza)){$nameId='esEndosoActividad';}
		?>
		<div  name="<?=$nameId?>">
            <!-- Aqui poner links -->            
            <div class="contenedoDocumentosNombreDiv" id="links2">
            	 <div>
            	<? if($saldo >= '5.0000'){?>                
    	            <button type="button" class="btn btn-primary linkSms" title="Clic - Enviar SMS" onclick="generaLinkEnvio('linkSms', '<?= $movilNumber; ?>', '', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-mobile" aria-hidden="true"></span>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-primary linkWhatSapp" title="Clic - Enviar WhatSapp" onclick="generaLinkEnvio('linkWhatSapp', '<?= $movilNumber; ?>', '', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-whatsapp" aria-hidden="true"></span>
                    </button>
                    &nbsp;
    	            <button type="button" class="btn btn-primary linkCorreo" title="Clic - Enviar Correo Electrónico" onclick="generaLinkEnvio('linkCorreo', '', '<?= $infoCliente[0]->EMail1; ?>', '<?= $documentos->PathWWW; ?>')">
                    	<span class="fa fa-envelope-o" aria-hidden="true"></span>
                    </button>
            	<?
					} else {
				?>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar SMS"><span class="fa fa-mobile" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar WhatSapp"><span class="fa fa-whatsapp" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar Correo Electrónico"><span class="fa fa-envelope-o" aria-hidden="true"></span></button>
            	<?
					}
				?>
            </div>
			<div>
            	<a href="<?=$documentos->PathWWW?>"  target="_blank" title="<?=$documentos->DateModify?>">
					<span class="glyphicon glyphicon-file" aria-hidden="true" ><?=$documentos->NameShow?></span> 
                </a>
            </div>
		</div>
       
		<?
					}
				}
		?>
	</div>
		<?

			}
		?>
		<div>
		<div class="row"><h1>DOCUMENTOS DEL ENDOSO</h1></div>
		<div class="row" id='contieneDocumentosEndosoDiv' style="display: flex;flex-direction: column;margin-left: 10px">
		</div>	
		</div>
		<?	
		}//FIN DEL ELSE
		}
		?>
        </div>
		<div class="row">
        	<div class="col-sm-12 col-md-12">
            <br />
            </div>
		</div>
<!-- Documentos Actividad -->

<!-- Comentarios Actividad -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style=" text-decoration:underline;">
				<strong>Seguimiento</strong>
                </label>
			</div>
		</div>
        <?
			if($infoFolioActividad->poliza != ""){
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Poliza</strong></label>
                <br />
				<?=$infoFolioActividad->poliza?>
			</div>
		</div>
        <?
			}
		?>
		<form 
        	class="form-group" role="form"
            id="formActividadVer_AgregaSeguimiento" name="formActividadVer_AgregaSeguimiento"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarSeguimiento"
		>
        <input type="hidden" name="enviar" value="">
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="">
				<strong>Agregar Comentario Actividad</strong>
				</label>
            </div>
		</div>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label>Comentario</label>
                <br />
                <? if ($infoFolioActividad->Status!='6')   
                { ?>
                <textarea name="Comentario" id="Comentario" style="width:100%;">
                </textarea>
               <? }else{?><label><strong>La actividad esta finalizada dudas o aclaraciones comunicares con el Coordinador Operativo o Ejecutivo</strong> </label> <?} ?>
				<?php echo display_ckeditor($ckeditor); ?>
            </div>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right">
				<input type="hidden" name="ClaveBit" id="ClaveBit" value="<?=$infoFolioActividad->ClaveBit?>" />
				<input type="hidden" name="Procedencia" id="Procedencia" value="<?=$infoFolioActividad->tipoActividad?> Capsys Web <?=$infoFolioActividad->folioActividad?>" />
                <input type="hidden" name="folioActividad" id="folioActividad" value="<?=$infoFolioActividad->folioActividad?>" />
                <input type="hidden" name="IDDocto" id="IDDocto" value="<?=$infoFolioActividad->idSicas?>" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$infoFolioActividad->tipoActividadSicas?>" />
                <input type="hidden" name="oldPosicion" id="oldPosicion" value="<?=$infoFolioActividad->Status?>" />

                 <? if ($this->capsysdre_actividades->Status($infoFolioActividad->Status)!='FINALIZADA')   
                { ?>

               			<input
               	 			type="submit" value="Enviar Comentario"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value=document.formActividadVer_AgregaSeguimiento.oldPosicion.value; document.formActividadVer_AgregaSeguimiento.submit();"
                   			 id=""
								class="btn btn-primary btn-sm manejoActividad"
                		/>
                	<?
                					if($this->tank_auth->get_userprofile() == "3"){
					?>
                		<input
                			type="submit" value="Enviar Comentario [En Curso]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='5'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="5"
							class="btn btn-primary btn-sm manejoActividad"
                		/>
                		<input
                			type="submit" value="Enviar Comentario [Finalizada]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='6'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="6"
							class="btn btn-primary btn-sm manejoActividad"
                		/>
                		<input
                			type="submit" value="Enviar Comentario [Pospuesta]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='7'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="7"
							class="btn btn-primary btn-sm manejoActividad"
                		/>
                	<?
					}
					?>

				<?
				}
				?>
						
            </div>
		</div>
        </form>

<?php if(isset($permisos['modificarActividad'])){ ?>
        <div class="row" style="border: solid;">
			<div class="form-group col-sm-12 col-md-12">
            	<label style=" text-decoration:underline;"><strong>Manejo</strong></label>
			</div>
			<div class="form-group col-sm-12 col-md-12">
				<div class="row">
           	  <div class="col-sm-2 col-md-2"><label>Cambiar estado<select class="form-control input-sm" id="selectStatusSicas"> 
                          <?php foreach ($statusActividades as  $value) {if($infoFolioActividad->Status==$value->idStatus){ ?>
                           <option value="<?= $value->idStatus; ?>" selected><?= $value->Nombre; ?></option>
                          <?php }else{ ?>
                           <option value="<?= $value->idStatus; ?>"><?= $value->Nombre; ?></option>
                           <?php }
                           }
                          ?>
           				</select>
           			</label>
           		</div>
           		<div class="col-sm-3 col-md-3">
           		<label>Motivo del cambio<select id="selectMotivoCambio" class="form-control input-sm"><option value='-1'></option><option value="1">Completa</option><option value="2">No se especifica el tipo de producto a cotizar</option><option value="3">Falta de Informacion</option><option value="4">Documentacion Faltante</option><option value="5">El numero de seria ya se encuentra amparado</option><option value="6">La cotizacion no coincide con la emision solicitada</option><option value="8">No terminan el proceso de cotización a emision</option><option value="9">Solicitar autorización de costos o detalles de la póliza diferente a cotizacion</option><option value="10">Actividad no corresponde al ramo correcto</option><!--option value="7">Otros</option--></select></label></div>
                   
                   
           			 <?php   if($infoFolioActividad->tipoActividad == "Endoso" || $infoFolioActividad->tipoActividad == "Cancelacion" || $infoFolioActividad->tipoActividad == "Sustitucion" || $infoFolioActividad->tipoActividad=='AclaraciondeComision')
           			 {
           			 	$checked='';
           			 	if($infoFolioActividad->captura==1){ $checked='checked';}?>

                       <div class="col-sm-1 col-md-1"> <label>Captura<input id="cbPasarCaptura" type="checkbox" class="form-control" <?=$checked?> style="height: 25px"></label> </div>
                       
           			<? } ?>

           			 <?php if(($infoFolioActividad->tipoActividad=="Emision" || $infoFolioActividad->tipoActividad=="Cotizacion") && !empty($infoDocumento)){ 
									$fechaParaEmision=explode('T',$infoDocumento[0]->FEmision);$fecConvertida=strtotime($infoDocumento[0]->FEmision);
								
								?>
           			 		<?
           			 		    $miFecha="";
           			 		   if(date('Y',$fecConvertida)=='1969'){$miFecha=date('d').'/'.date('m').'/'.date('Y');}
           			 		   else{$miFecha=date('d',$fecConvertida).'/'.date('m',$fecConvertida).'/'.date('Y',$fecConvertida);} 

           			 	    ?>
           			 
           			 	<div class="col-sm-2 col-md-2"><label>Fecha Emision:<input class="formEnviar fechaPersona form-control" class="fechaPersona"   type="text"  id="fechaEmision" autocomplete="off" value="<?=$miFecha?>"></label></div>
								<?php } else{ ?> 
									<div class="col-sm-2 col-md-2"><label>Fecha Emision:<input class="formEnviar fechaPersona form-control" class="fechaPersona"   type="text"  id="fechaEmision" autocomplete="off" value="<?=date("d-m-Y")?>"></label></div>
								<?php }?>
           		 <?php if($infoFolioActividad->tipoActividadSicas == "ot" && !empty($infoDocumento))
           		 {
                     $checkedConcepto='';
                     if($infoDocumento[0]->Concepto=='//Captura'){$checkedConcepto='checked';}
           		 ?>
           	        <div class="col-sm-2 col-md-2"><label>Concepto(pasar a captura)<input type="checkbox" onclick="agregarDiagonal(this)" <?=$checkedConcepto?>><input type="text" class="form-control input-sm" id="textConceptoSicas" style="width:300px" data-oldvalue="<?=$infoDocumento[0]->Concepto?>" value="<?=$infoDocumento[0]->Concepto?>"></label></div><br>
					<?php } else{ ?> 
						<div class="col-sm-2 col-md-2"><label>Concepto<input type="text" class="form-control input-sm" id="textConceptoSicas" style="width:300px" value=""></label></div><br>
					<?php }?>
           	      </div>
           	      <div class="row">
           	     <input type="text" class="form-control input-sm" name="textComentario" id="textComentario" placeholder="agregar comentario">
           	     </div>
           	     <div class="row">
           	     	<div class="col-md-1 col-sm-1"><label>Pasar a cobranza:</label></div>
           	     	<div class="col-md-6 col-sm-6"><input type="text" name="comentarioParaCobranza" id="comentarioParaCobranza" class="form-control"></div>
           	     	<div class="col-md-1 col-sm-1"><input type="checkbox" name="cbPasarCobranza" id="cbPasarCobranza" class=""></div>    
           	     	<input type="hidden" id="idInternoActividadCobranza" value="<?=$infoFolioActividad->idInterno?>">
           	     	<input type="hidden" id="usuarioCreacionActividadCobranza" value="<?=$infoFolioActividad->usuarioCreacion?>">   
           	     	 <input type="hidden" id="usuarioResponsableActividadCobranza" value="<?=$infoFolioActividad->usuarioResponsable?>">       	     	
           	     </div>
           	     	    <div class="row">
                <button class="btn btn-primary btn-sm" onclick="actualizarDatosEnSicas('<?=$folioActividad;?>','<?=$infoFolioActividad->idSicas;?>','<?=$infoFolioActividad->tipoActividadSicas;?>','<?=$infoFolioActividad->ClaveBit;?>')">Guardar</button>
                 </div>
                <?php if($infoFolioActividad->actividadImportante==1){ ?>
                <button class="btn btn-danger" onclick="eliminarImportante('<?=$folioActividad;?>','<?=$infoDocumento[0]->IDDocto;?>')">No importante</button>
                <?php } ?>
			</div>
		    <div class="form-group col-sm-12 col-md-12">
               <?php echo(imprimirPromotorias($promotorias,$infoFolioActividad->folioActividad,$IDValuePK,$FolderDestino,$TypeDestinoCDigital)); ?>
            </div>
            <div class="form-group col-sm-12 col-md-12">
               <?php echo(imprimirDatosAdicionales($cliente)); ?>
            </div>
              <div class="form-group col-sm-12 col-md-12">
              	<label><strong>->Forma de Pago:</strong><?=$infoFolioActividad->pagoFormas;?></label><br>
              	<label><strong>->Conducto de Pago:</strong><?=$infoFolioActividad->pagoConducto;?></label>
              </div>
             <div class="form-group col-sm-12 col-md-12">
               <?php if(isset($agregarCompania)){
                  if($infoFolioActividadEmi != NULL){echo(imprimirAgregarCompania($agregarCompania,$infoFolioActividad->folioActividad,$infoFolioActividad->IDSRamo,$infoFolioActividadEmi->tipoActividad)); }
               	else{echo(imprimirAgregarCompania($agregarCompania,$infoFolioActividad->folioActividad,$infoFolioActividad->IDSRamo,$infoFolioActividad->tipoActividad)); }
               }?>
            </div>
		
		</div>

    <?php } ?>
<?php if(isset($permisos['calificarActividad'])){ if($actividadCalificada==0){?>
        <div class="row" style="border: solid;">
			<div class="form-group col-sm-12 col-md-12">
            	<label style=" text-decoration:underline;"><strong>Calificacion</strong></label>
			</div>
			<div><?= imprimirCalificaciones($calificaciones); ?></div>
			<div><button class="btn btn-primary btn-sm" onclick="guardarCalificacion('<?=$folioActividad;?>',<?=$infoFolioActividad->IDVend;?>,'<?=$infoFolioActividad->tipoActividad;?>',<?=$infoFolioActividad->idInterno?>)">Guardar</button></div>
		</div>
<?php }} ?>


<?

	if($infoFolioActividad->tipoActividad == "Emision" && isset($permisos['tarjetaBancoActividad'])){
		 
?>

        <div class="row" style="border: solid;">
        
         <div  class="form-group col-sm-12 col-md-12">
        	<label style="font-size:20px; text-decoration:underline;"><strong>Datos de Tarjeta</strong></label>
         </div>
             <div  class="form-group col-sm-12 col-md-12">
             	Tarjetas<select class="form-control" onchange="verTarjetas(this)"><?=imprimirTarjetas($tarjetasDelCliente)?></select>
             </div>
         <div  class="form-group col-sm-12 col-md-12">
         <label>
            Tipo de pago aplicación
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipoPago; ?>" id="tipoPagoTarjeta2" />
            </label>
			<label>
            Banco
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaBanco; ?>" id="banco2"/>
            </label>
			<label>
            Tipo tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipo; ?>" id="tipoTarjeta2"/>
            </label>
			<label>
			Titular de la tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTitular; ?>" id="titularTarjeta2"/>
            </label>
		</div>
		<div  class="form-group col-sm-12 col-md-12">
			<label>
			Número de tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaNumero; ?>" id="numeroTarjeta2"/>
            </label>
			<label>
			Vencimiento
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaMes; ?>" id="vencimiento2"/>
            </label>
			<label>
		    Año
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaYear; ?>" id="anio2"/>
            </label>
			<label>
			Código de Seguridad 
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaCcv; ?>" id="codigoSeguridad2"/>
            </label>
		</div>
	</div>




<? } ?>




        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label >
				<strong>Actividad mala:</strong>
				<label><?=$infoFolioActividad->comentarioActividad?></label>
				</label>
            </div>
		</div>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label>
				<strong>Comentarios Actividad</strong>
				</label>
				<? $requiereFactura='';
                  if($infoFolioActividad->seRequiereFactura==1)
                  {
                  	$requiereFactura='ESTA ACTIVIDAD REQUIERE FACTURA, RFC:'.$infoFolioActividad->rfcFactura;
                  }
				?>
				<h3><label class="label label-warning">ESTA ACTIVIDAD SE ENCUENTRA EN STATUS: <?=($infoFolioActividad->Status_Txt.' '.$requiereFactura )?></label></h3>
				<?
				/*CAMBIOS AGREGADOS*/
				$edad=''; 
				if(isset($ClienteContact["cliente"]->edad)){$edad=' ,EDAD:'.$ClienteContact["cliente"]->edad;}
				if(isset($ClienteContact["cliente"]->codigoPostal)){?>
				<h3><label class="label label-warning">CP: <?=($ClienteContact["cliente"]->codigoPostal)." ".$edad ?></label></h3>
				<?}?>
               <? 
                  $folioPadre='';
                  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($infoFolioActividad->folioPadre,TRUE));fclose($fp);
               if($infoFolioActividad->folioPadre!=''){$folioPadre='<a href="'.base_url().'actividades/ver/'.$infoFolioActividad->folioPadre.'" target="_blank">  '.$infoFolioActividad->folioPadre.'</a>';}
               else{$folioPadre='';}
               ?>
               <h3><label class="label label-warning">Folio Padre:<?=$folioPadre?></label></h3>
            </div>
		</div>


  


        <? foreach($verBitacoraActividad as $segumientoBitacoras){ ?>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<?="<label><strong>(&bull;)".$this->capsysdre_actividades->fechaHoraEspActividades($segumientoBitacoras->FechaHora,'lineal')."</strong></label>"?>
            	<label><strong>
                <?
					if($segumientoBitacoras->IDUser != 37 && $segumientoBitacoras->Procedencia == ""){
						echo "[";
						echo $segumientoBitacoras->Procedencia;
						echo "]";
						print($segumientoBitacoras->IDUser);
					}
				?>
			  </strong></label>
            </div>
		</div>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><?=utf8_decode($segumientoBitacoras->Comentario);?></label>
            	<hr />
            </div>
		</div>        
        <? } ?>


      <? foreach($verBitacoraActividadCotizacion as $segumientoBitacoras){ ?>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<?="<label><strong>(&bull;)".$this->capsysdre_actividades->fechaHoraEspActividades($segumientoBitacoras->FechaHora,'lineal')."</label></strong>"?>
            	<label><strong>
                <?
					if($segumientoBitacoras->IDUser != 37 && $segumientoBitacoras->Procedencia == ""){
						echo "[";
						echo $segumientoBitacoras->Procedencia;
						echo "]";
						print($segumientoBitacoras->IDUser);
					}
				?>
			</strong></label>
            </div>
		</div>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><?=utf8_decode($segumientoBitacoras->Comentario);?></label>
            	<hr />
            </div>
		</div>        
        <? } ?>

<!--* Comentarios Actividad -->
                        
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">&nbsp;</div>
		</div>

	</div>            
    </div>
</section>

<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar contacto</h4>
            </div>
            
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-12">
            			<input class="IdCont" name="IdCont" type="hidden">
                      	<div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="ApellidoP">Apellido Paterno</label>
                                <input class="form-control ApellidoP" name="ApellidoP" placeholder="Apellido Paterno" type="text" required autofocus />
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="ApellidoM">Apellido Materno</label>
                                <input class="form-control ApellidoM" name="ApellidoM" placeholder="Apellido Materno" type="text" required />
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">Nombre (s)</label>
                                <input class="form-control Nombre" id="Nombre" name="Nombre" placeholder="Nombre" type="text" required />
                            </div>
                        </div>
						<!--div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="sexoc">Sexo</label>
                                <select name="sexoc" class="form-control2 Sexo" disabled>
									<option value="0">Masculino</option>
									<option value="1">Femenino</option>
								</select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="fechaNacc">Fecha Nacimiento</label>
                                <div class="input-group">
									<input type="text" class="form-control FechaNac fecha" name="fechaNacc" placeholder="01/01/1900" value="" disabled>
	                                <div class="input-group-btn"><button class="btn btn-default fecha" type="button" disabled><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
	                            </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="edadc">Edad</label>
                                <a class="form-control Edad" disabled id="txtEdadC"></a>
								<input type="hidden" class="form-control Edad" id="edadC" name="edad" value="" disabled>
                            </div>
                        </div-->
                        <!--input class="form-control Departamento" name="Departamento" placeholder="Departamento" type="text" required /-->
                        <div class="row">
                        	<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                        		<label for="Alias">Alias</label>
                        		<input class="form-control Alias" name="Alias" placeholder="Alias" type="text" required autofocus />
                        	</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            	<label for="Email1">E-mail</label>
                                <input class="form-control Email1" name="Email1" placeholder="E-mail" type="email"  required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            	<label for="telefono1">Tel&#233;fono1</label>
                                <input class="form-control Telefono1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="Telefono1" placeholder="Telefono1" type="text" required />
                            </div>
                        </div>
            		</div>
            	</div>
            </div>  
            <div class="panel-footer">
            	<div class="row">
            		<div class="col-md-1 col-md-offset-9" id="dvC">
					</div>
					<div class="col-md-1">
						<a class="btn btn-primary btn-sm" data-dismiss="modal" id="btnGuardar">Aceptar</a>
					</div>
					<div class="col-md-1">
					</div>
            	</div>
            </div>
        </div>
    </div>
</div>

<!--:::::::::: INICIO MODAL ::::::::::-->
<div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar direcci&#243;n</h4>
            </div>
            <div class="modal-body">
	        	<div class="row">
	        		<div class="col-md-12">
	        			<input class="IdCont" name="IdCont" type="hidden">
	                  	<div class="row">
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoP">Calle</label>
	                            <input class="form-control DCalle" name="calle" placeholder="Calle" type="text" required autofocus />
	                        </div>
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoM">No Ext</label>
	                            <input class="form-control DNoExt" name="noext" placeholder="No Ex" type="text" required />
	                        </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">No Int</label>
	                            <input class="form-control DNoInt" id="noint" name="noint" placeholder="No Int" type="text" required />
	                        </div>
	                    </div>

	                    <div class="row">
	    	               	<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoP">C&#243;digo Postal</label>
	                            <input class="form-control DCP" name="cp" maxlength="5" minlength="5" placeholder="Codigo Postal" type="text" required autofocus />
	                        </div>
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoM">Colonia</label>
	                            <input class="form-control DColonia" name="colonia" placeholder="Colonia" type="text" required />
	                        </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">Poblaci&#243;n</label>
	                            <input class="form-control DPoblacion" id="poblacion" name="poblacion" placeholder="Poblacion" type="text" required />
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="Email1">Ciudad</label>
	                            <input class="form-control DCiudad" name="ciudad" placeholder="Ciudad" type="text" required />
	                        </div>
	                         <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="Email1">Pa&#237;s</label>
	                            <input class="form-control DPais" name="pais" placeholder="Pais" type="text" required />
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
	                        	<label for="telefono1">Tel&#233;fono1</label>
	                            <input class="form-control DTelefono1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="Telefono1" placeholder="Telefono 1" type="text" required />
	                        </div>
	                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
	                        	<label for="telefono1">Tel&#233;fono2</label>
	                            <input class="form-control DTelefono2" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="telefono2" placeholder="Telefono 2" type="text" required />
	                        </div>
	                    </div>
	        		</div>
	        	</div>
			</div>  
            
            <div class="modal-footer">
            	<div class="row">
            		<div class="col-md-1 col-md-offset-9" id="dvD">
					</div>
					<div class="col-md-1">
						<a class="btn btn-primary btn-sm" data-dismiss="modal" id="btnGuardarD">Aceptar</a>
					</div>
					<div class="col-md-1">
					</div>
            	</div>
            </div>
        </div>
        
    </div>
</div>
<!--:::::::::: FIN MODAL ::::::::::-->

<!--:::::::::: INICIO MODAL ::::::::::-->
<div class="modal fade modal-CDigital" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Centro Digital</h4>
			</div><!-- modal-header -->
			<div class="modal-body">
            
				<form 
                	action="#" method="POST"
					id="frmBuscador"
                    class=""
                >
				<div class="row row-individual">
					<div class="col-md-12">
						<div id="wizard">
							<h3>Generales</h3>
                            <?
						//	echo "<pre>";
						//	print_r($ClienteContact);
						//	echo "<br />***<br />";
						//	print_r($infoFolioActividad);
							?>
							<section>
								<div class="row row-tabs">
									<div class="col-md-4">
                                    	<i><strong>Cliente</strong></i>
                                        <br />
                                    	<? // = $infoFolioActividad->nombreCliente; ?>
                                        <?= $ClienteContact["cliente"]->NombreCompleto; ?>
									</div>
									<div class="col-md-8">
                                    <?
									if($infoFolioActividad->usuarioVendedor != ""){
									?>
                                    	<i><strong>Vendedor</strong></i>
                                        <br />
										<?= $infoFolioActividad->nombreUsuarioVendedor; ?>
                                    	[<?= $infoFolioActividad->usuarioVendedor; ?>]
									<?
									}
									?>
									</div>
								</div>

								<div class="row row-tabs">
									<div class="col-md-12">
										<!-- <label for="concepto">Concepto</label> -->
										<!-- <p id="concepto"></p> -->
									</div>
								</div>

								<div class="row row-tabs">
                            		<div id="tree_menu" class="col-md-12">
								</div>		
						</div>
							</section>
						</div>
					</div>
				</div>
				</form>

			</div><!-- modal-body -->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div><!-- modal-footer -->
		</div><!-- modal-content -->
	</div>
</div>
<!--:::::::::: FIN MODAL ::::::::::-->
<script>
	<?
if(isset($permisos['finalizarActividad'])){echo('var finalizarActividad=true;');}
else {echo('var finalizarActividad=false;');}
	?>

$(document).ready(function(){


 	$(document.body).find('input[type=email]').blur(function(){
 		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 		var email = this.value;

	    if(!re.test(email)){
	    	alert("El formato de correo es incorrecto.");
	    	$(this).focus();
	    }
 	});
	
 	<?php
 		if (strlen($msj) > 0)
 		{
 			echo 'alert("'.$msj.'");';
 		}
 	?>
	
	$('.addCto').off('click');
	$('.addDic').off('click');
	var editar = false;

	$(document.body).on('click','#aEdit',function(e){
		
		e.preventDefault();
		editar = true;
		$('.form-control, .ctl-save, .fecha, .form-control2').prop('disabled',false);
	
		$('a[name="editar"]').removeClass('hidden');
		$(".addCto").removeAttr("disabled");
		$('.addDic').removeAttr('disabled');
		$('.addCto').on("click", function(e){
			e.preventDefault();
			$(".editando").removeClass("editando");
			$("#contact input:text").removeAttr("disabled");
			$(".Nombre").val("");      
			$(".ApellidoP").val("");      
			$(".ApellidoM").val("");      
			$(".Alias").val("");      
			//$("#txtEdadC").text("");
			//$(".Edad").val("");      
			//$(".FechaNac").val("");      
			$(".Email1").val("");      
			$(".Telefono1").val("");      
			$(".Nacionalidad").val("");
			
			$("#btnGuardar").attr("data-new","true");
			$("#btnGuardar").addClass("guardarCto");
    		$("#dvC").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
			$("#contact").modal('show');
		});


		$('.addDic').on("click", function(e){
			e.preventDefault();
			$(".editando").removeClass("editando");
			$("#address input:text").removeAttr("disabled");
			$(".DCalle").val("");      
			$(".DNoExt").val("");      
			$(".DNoInt").val("");      
			$(".DCP").val("");      
			$(".DColonia").val("");      
			$(".DPoblacion").val("");      
			$(".DCiudad").val("");      
			$(".DPais").val("");      
			$(".DTelefono1").val("");      
			$(".DTelefono2").val(""); 
			
			$("#btnGuardarD").attr("data-new","true");
			$("#btnGuardarD").addClass("guardarDic");
    		$("#dvD").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardarD").removeAttr("data-dismiss");
			$("#address").modal('show');
		});
	});

	$('#btnSave').click(function(e){
		e.preventDefault();

		var contactos = [];
		$(".cto-itm").each(function(i,input){
			var item = {
				"IDCont"       : $(input).attr("data-IdCont"),
				"Nombre"       : $(input).attr("data-Nombre"),
				"ApellidoP"    : $(input).attr("data-ApellidoP"),
				"ApellidoM"    : $(input).attr("data-ApellidoM"),
				"Alias" 	   : $(input).attr("data-Alias"),
				//"Sexo" 	   	   : $(input).attr("data-Sexo"),
				//"FechaNac" 	   : $(input).attr("data-FechaNac"),
				//"Edad"		   : $(input).attr("data-Edad"),
				"Email1"       : $(input).attr("data-Email1"),
				"Telefono1"    : $(input).attr("data-Telefono1"),
				"Nacionalidad" : $(input).attr("data-Nacionalidad")
			}
			contactos.push(item);
			//var cto = JSON.stringify(item);
			//$(input).val(cto);
		});
		var ctos = JSON.stringify(contactos);
		if($("#contactos").length == 0) {
		  $('#frmClient').append('<input type="hidden" name="contactos" id="contactos">');
		}
		
		$("#contactos").val(ctos);

		var direcciones = [];
		$(".dic-itm").each(function(i,input){
			var item = {
				"IDDir"       : $(input).attr("data-IDDir"),
				"Calle"       : $(input).attr("data-Calle"),
				"NOExt"    : $(input).attr("data-NOExt"),
				"NOInt"    : $(input).attr("data-NoInt"),
				"CPostal" 	   : $(input).attr("data-CPostal"),
				"Colonia" 	   : $(input).attr("data-Colonia"),
				"Poblacion" 	   : $(input).attr("data-Poblacion"),
				"Ciudad" 	   : $(input).attr("data-Ciudad"),
				"Pais"       : $(input).attr("data-Pais"),
				"Telefono1"    : $(input).attr("data-Telefono1"),
				"Telefono2" : $(input).attr("data-Telefono2")
			}
			direcciones.push(item);
			//var cto = JSON.stringify(item);
			//$(input).val(cto);
		});
		var dirs = JSON.stringify(direcciones);
		if($("#direcciones").length == 0) {
		  $('#frmClient').append('<input type="hidden" name="direcciones" id="direcciones">');
		}
		
		$("#direcciones").val(dirs);
		
		var frmCli = $('#frmClient').find('input').serializeArray();
		// console.log(frmCli);
		$('#frmClient').submit();
		//$('#frmClient').trigger('submit');
	});

	$('#btnCancel').click(function(e){
		e.preventDefault();
		editar = false;
		window.location.reload(true);
		// $('.ctl-save').prop('disabled',true);
		//$('.addCto').off('click');
		//$('.form-control, .ctl-save, .fecha, .form-control2').prop('disabled',true);
		//$(".addCto").Attr("disabled","disabled");
		//$('.form-control').prop('disabled',true);
	});
	
       //Click dropdown
    $('#tabbody').on('click','.contact-item',function(e){
    	e.preventDefault();
    	$(".editando").removeClass("editando");
    	$("#btnGuardar").removeAttr("data-new");
    	if (e.target.name == "editar" && editar)
    	{
    		//$("#btnGuardar").text("Guardar");
    		$("#btnGuardar").addClass("guardarCto");
    		$("#dvC").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
    		$("input:text, select").removeAttr("disabled");
    	}
    	else
    	{
    		//$("#btnGuardar").text("Aceptar");
    		$("#btnGuardar").removeClass("guardarCto");
    		$("#btnGuardar").attr("data-dismiss","modal");
    		$("#contact input:text").attr("disabled","disabled");
    		$("#dvC").html('');	
    	}
        //get data-for attribute
        var input = $(this).parent().find("input.cto-itm");
        //console.log(input);
        input.addClass("editando");
		var //IdCont = input.attr("data-IdCont"),
			Nombre = input.attr("data-Nombre");
			ApellidoP = input.attr("data-ApellidoP");
			ApellidoM = input.attr("data-ApellidoM");
			Alias = input.attr("data-Alias");
			//Sexo = input.attr("data-Sexo"),
			//FechaNac = input.attr("data-FechaNac"),
			//Edad   = input.attr("data-Edad"),
			Email1 = input.attr("data-Email1");
			Telefono1 = input.attr("data-Telefono1");
			Nacionalidad = input.attr("data-Nacionalidad");
			
			
		 //$(".IdCont").val("");      
		$(".Nombre").val("");      
		$(".ApellidoP").val("");      
		$(".ApellidoM").val("");      
		$(".Alias").val("");      
		//$("#txtEdadC").text("");
		//$(".Edad").val("");      
		//$(".FechaNac").val("");      
		$(".Email1").val("");      
		$(".Telefono1").val("");      
		$(".Nacionalidad").val("");   
			
			
		//$(".IdCont").val(IdCont);      
		$(".NombreCompleto").html("<span class='glyphicon glyphicon-info-sign'></span> " + Nombre + " " + ApellidoP + " "+ ApellidoM);      
		$(".Nombre").val(Nombre);      
		$(".ApellidoP").val(ApellidoP);      
		$(".ApellidoM").val(ApellidoM);      
		$(".Alias").val(Alias);      
		//$("#txtEdadC").text(Edad);
		//$(".Sexo").val(Sexo);
		//$(".Edad").val(Edad);      
		//$(".FechaNac").val(fechaNac);      
		$(".Email1").val(Email1);      
		$(".Telefono1").val(Telefono1);      
		//$(".Nacionalidad").val(Nacionalidad);      
    });

    $('#tabbodyd').on('click','.address-item',function(e){
    	e.preventDefault();
    	$(".editando").removeClass("editando");
    	$("#btnGuardarD").removeAttr("data-new");
    	if (e.target.name == "editar" && editar)
    	{
    		//$("#btnGuardar").text("Guardar");
    		$("#btnGuardarD").addClass("guardarDic");
    		$("#dvD").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardarD").removeAttr("data-dismiss");
    		$("input:text, select").removeAttr("disabled");
    	}
    	else
    	{
    		//$("#btnGuardar").text("Aceptar");
    		$("#btnGuardarD").removeClass("guardarDic");
    		$("#btnGuardarD").attr("data-dismiss","modal");
    		$("#address input:text").attr("disabled","disabled");
    		$("#dvD").html('');	
    	}
        //get data-for attribute
        var input = $(this).parent().find("input.dic-itm");
        //console.log(input);
        input.addClass("editando");
		var //IdCont = input.attr("data-IdCont"),
			Calle = input.attr("data-Calle");
			NoExt = input.attr("data-NOExt");
			NoInt = input.attr("data-NoInt");
			CP = input.attr("data-CPostal");
			Colonia = input.attr("data-Colonia");
			Poblacion = input.attr("data-Poblacion");
			Ciudad = input.attr("data-Ciudad");
			Pais = input.attr("data-Pais");
			Telefono1 = input.attr("data-Telefono1");
			Telefono2 = input.attr("data-Telefono2");			
			
		 //$(".IdCont").val("");      
		$(".DCalle").val("");      
		$(".DNoExt").val("");      
		$(".DNoInt").val("");      
		$(".DCP").val("");      
		$(".DColonia").val("");      
		$(".DPoblacion").val("");      
		$(".DCiudad").val("");      
		$(".DPais").val("");      
		$(".DTelefono1").val("");      
		$(".DTelefono2").val("");   
			
			
		$(".DCalle").val(Calle);      
		$(".DNoExt").val(NoExt);      
		$(".DNoInt").val(NoInt);      
		$(".DCP").val(CP);      
		$(".DColonia").val(Colonia);      
		$(".DPoblacion").val(Poblacion);      
		$(".DCiudad").val(Ciudad);      
		$(".DPais").val(Pais);      
		$(".DTelefono1").val(Telefono1);      
		$(".DTelefono2").val(Telefono2);
    });

	$(document).on("click",".guardarCto",function(e){
		e.preventDefault();
		var //IdCont = $(".IdCont").val().trim(),
			Nombre = $(".Nombre").val().trim();
			ApellidoP = $(".ApellidoP").val().trim();
			ApellidoM = $(".ApellidoM").val().trim();
			Alias = $(".Alias").val().trim();
			//Sexo = $(".Sexo").val().trim();
			//FechaNac = $(".FechaNac").val().trim();
			//Edad = = $(".Edad").val().trim();
			Email1 = $(".Email1").val().trim();
			Telefono1 = $(".Telefono1").val().trim();
			//Nacionalidad = $(".Nacionalidad").val().trim();	

			if(Nombre == "" && ApellidoP == "" && ApellidoM == "" && Email1 == "" && Telefono1 == ""){
				$("#contact").modal('hide');
				return;
			}	

		if ($(e.target).attr("data-new") == "true")
		{
			var sig = $("#tabbody tr").length + 1;
			$("#tabbody").append('<tr>'+
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td class="text-center">' +
											'<input type="hidden" name="contacto-' + sig + '" class="cto-itm editando" data-IdCont="-1">' +
											'<a name="ver" class="btn btn-primary btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
												'<span class="glyphicon glyphicon-eye-open" ></span>' +
											'Ver Info</a>' +
											' <a name="editar" class="btn btn-primary btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
												'<span class="glyphicon glyphicon-edit"></span>' + 
											'Editar</a>' +
										'</td>' +
				                      '</tr>');
		}
		
		var input = $(".editando");
		var Row = $(".editando").parents("tr");
		Row.find("td:eq(0)").text(Nombre + ' ' + ApellidoP + ' ' + ApellidoM);
		//Row.find("td:eq(1)").text(Puesto);
		Row.find("td:eq(3)").text(Email1);
		Row.find("td:eq(4)").text(Telefono1);
		
		//input.attr("data-IdCont",IdCont);
		input.attr("data-Nombre",Nombre);
		input.attr("data-ApellidoP",ApellidoP);
		input.attr("data-ApellidoM",ApellidoM);
		input.attr("data-Alias",Alias);
		//input.attr("data-Sexo",Sexo);
		//input.attr("data-Edad",Edad);
		//input.attr("data-FechaNac",FechaNac);
		input.attr("data-Email1",Email1);
		input.attr("data-Telefono1",Telefono1);
		//input.attr("data-Nacionalidad",Nacionalidad);

		input.removeClass("editando");

		$("#contact").modal('hide');
	});

	$(document).on("click",".guardarDic",function(e){
		e.preventDefault();
		var //IdCont = $(".IdCont").val().trim(),
		Calle = $(".DCalle").val().trim();      
		NoExt =	$(".DNoExt").val().trim();      
		NoInt =	$(".DNoInt").val().trim();      
		CP = $(".DCP").val().trim();      
		Colonia = $(".DColonia").val().trim();      
		Poblacion =	$(".DPoblacion").val().trim();      
		Ciudad = $(".DCiudad").val().trim();      
		Pais = $(".DPais").val().trim();      
		Telefono1 =	$(".DTelefono1").val().trim();      
		Telefono2 = $(".DTelefono2").val().trim();	


		if(Calle == "" && NoExt == "" && CP == "" && Colonia == "" && Poblacion == "" && Ciudad == "" && Pais == "" && Telefono1 == "" && Telefono2 == "" ){
			$("#address").modal('hide');
			return;
		}

		if ($(e.target).attr("data-new") == "true")
		{
			var sig = $("#tabbodyd tr").length + 1;
			$("#tabbodyd").append('<tr>'+
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td class="text-center">' +
											'<input type="hidden" name="contacto-' + sig + '" class="dic-itm editando" data-IDDir="-1">' +
											'<a name="ver" class="btn btn-primary btn-xs address-item" data-toggle="modal" data-target="#address" data-original-title>' +
												'<span class="glyphicon glyphicon-eye-open" ></span>' +
											'Ver Info</a>' +
											' <a name="editar" class="btn btn-primary btn-xs address-item" data-toggle="modal" data-target="#address" data-original-title>' +
												'<span class="glyphicon glyphicon-edit"></span>' + 
											'Editar</a>' +
										'</td>' +
				                      '</tr>');
		}
		
		var input = $(".editando");
		var Row = $(".editando").parents("tr");
		Row.find("td:eq(0)").text(Calle);
		Row.find("td:eq(1)").text(NoExt);
		Row.find("td:eq(2)").text(NoInt);
		Row.find("td:eq(3)").text(CP);
		Row.find("td:eq(4)").text(Colonia);
		Row.find("td:eq(5)").text(Poblacion);
		Row.find("td:eq(6)").text(Ciudad);
		Row.find("td:eq(7)").text(Pais);
		Row.find("td:eq(8)").text(Telefono1);
		Row.find("td:eq(9)").text(Telefono2);
		
		input.attr("data-Calle",Calle);
		input.attr("data-NOExt",NoExt);
		input.attr("data-NoInt",NoInt);
		input.attr("data-CPostal",CP);
		input.attr("data-Colonia",Colonia);
		input.attr("data-Poblacion",Poblacion);
		input.attr("data-Ciudad",Ciudad);
		input.attr("data-Pais",Pais);
		input.attr("data-Telefono1",Telefono1);
		input.attr("data-Telefono2",Telefono2);
		//input.attr("data-Nacionalidad",Nacionalidad);

		input.removeClass("editando");

		$("#address").modal('hide');
	});

	$(document).on('change','#grupo',function(event){
        var IDR = $(this).val();

        $.ajax({
          method: "POST",
          url: "<?php echo base_url(); ?>" + "directorio/getSubGrupos",        
          //dataType: 'json',
          data: { IDGrupo : IDR },
            success: function(json){
                if(json != ""){
                 $('#subgrupo').find('option')
                                        .remove()
                                        .end();

                $('#subgrupo').append($('<option>',{
                            value : "",
                            text : "Selecccione un Sub Grupo",
                        }));
                    var oJson = JSON.parse(json);
                    $.each(oJson,function(k,v){
                        $('#subgrupo').append($('<option>',{
                            value : v.IDSGrupo,
                            text : v.SubGrupo,
                        }));
                    });
                }
            },
            error: function(jqXHR,textStatus,errorThrown ){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown );
                    alert('Error while request..');
            }
        });
    });

	$('#tipoent').change(function(e){
    	this.value;

    	if(this.value == "0"){
    		$('.ctn-m').hide();
			$('.ctn-f').show();
    	}else{
    		$('.ctn-m').show();
			$('.ctn-f').hide();
    	}

    });

	var fecha =	$('.fecha').datepicker({
		format: "dd/mm/yyyy",
	    startDate: "01/01/1900",
	    language: "es",
	    autoclose: true,
     	orientation: "top auto",
	});

    fecha.on('changeDate',function(ev){
        //console.log(ev);
        var todayTime = new Date(ev.date);
       	var hoy = new Date();
		var edad = Math.floor((hoy-todayTime) / (365.25 * 24 * 60 * 60 * 1000));
		if ($("#tipoent").val() == "0")
		{
	        $("#txtEdad").text(edad);
	        $("#edad").val(edad);
		}
        // $('.fecha').val(todayTime.yyyymmdd());
    });
	
	$("#tipoent").change(function() {
		
		var TipoEntidad = $(this).val();
		
		console.log(TipoEntidad);
	})
	
	//** **
//--	$("tr").click(function(){
	$(document.body).on('click','#aCDigital',function(){
		
		var	TypeDestinoCDigital	= "CLIENT";
		var	IDValuePK			= "<?= $infoFolioActividad->idCliente; ?>";
		var	ActionCDigital		= "GETFiles";
		var	ListFilesURL		= false;
		var	FolderDestino		= false;

		$.ajax({
			method: "POST",
			data	: { 
						"TypeDestinoCDigital"	: TypeDestinoCDigital,
						"IDValuePK"				: IDValuePK,
						"ActionCDigital"		: ActionCDigital,
						"ListFilesURL"			: ListFilesURL,
						"FolderDestino"			: FolderDestino,
			},
			url 	: "<?= base_url(); ?>centrodigital/LoadCentroDigital",
			dataType: "html",
			success : function(data){
						$('#tree_menu').easytree({
								data: [JSON.parse(data)],
						});
			}		
		});

		$(".modal-CDigital").modal("show");
	});
	// 	var	IDValuePK			= "<?= $infoFolioActividad->idCliente; ?>";
	// 	var	ActionCDigital		= "GETFiles";

 //        $.ajax({
 //            method: "POST",
 //            data    : { 
 //                        "TypeDestinoCDigital"   : TypeDestinoCDigital,
 //                        "IDValuePK"             : IDValuePK,
 //                        "ActionCDigital"        : ActionCDigital,
 //            },
 //            url     : "<?= base_url(); ?>actividades/digitalAct",
	// 		dataType: "html",
	// 		success : function(data){
	// 					$('#menu_doc').easytree({
	// 							data: [JSON.parse(data)],
	// 					});
	// 					document.getElementById('loading-docs-client-modal').classList.add('hidden');
	// 					console.log(data);
	// 		}		
	// 	});
	// 	console.log(TypeDestinoCDigital,IDValuePK,ActionCDigital);

	// 	$(".modal-CDocuments").modal("show");
 //        document.getElementById('aCDocuments').classList.add('active');
	// });

    $('#btn-Docs').click(function() {
        console.log(this)
        var TypeDestinoCDigital = "CLIENT";
        var IDValuePK           = this.dataset.idcli;
        var ActionCDigital      = "GETFiles";

        $.ajax({
            method: "POST",
            data    : { "TypeDestinoCDigital"   : TypeDestinoCDigital,
                        "IDValuePK"             : IDValuePK,
                        "ActionCDigital"        : ActionCDigital,
            },
            url     : "<?= base_url(); ?>actividades/digitalAct",
            dataType: "html",
            success : function(data){
                        //$('#tab_doc').easytreeDocsClient({data: [JSON.parse(data)],});
                        document.getElementById('loading-docs-client').classList.add('hidden');
                        let datos=JSON.parse(data);let doc='';let abierto=false;let level='';let c=datos.documentos.children;let total=c.length;let arrayDoc=[];let bandEntrada=true;let nivelAnt=0;let idAnterior=0;idPadre=0;
                    idAnterior=0;nivelAnt=0;bandEntrada=false;
                       let nivelMaximo=0;
                       console.log(c)
/*===================================CLASIFICA CARPETAS Y HEREDA IL IDPADRE============*/
                        for(let i=0;i<total;i++)
                        	{  
                        	 if(c[i].isFolder)
                        		{    if(c[i].level>nivelMaximo){nivelMaximo=c[i].level;}

                        				if(c[i].level>nivelAnt){idPadre=idAnterior;}
                        				 else
                        				 {
                        				 if(c[i].level<=nivelAnt){                        				  
                        				   let cantRevers=arrayDoc.length-1;
                        				   for(let j=cantRevers;j>0;j--)
                        				   {
                        				   	if(c[i].level==arrayDoc[j][1])
                        				   	{                        				   		
                        				   		idPadre=arrayDoc[j][3];
                        				   		j=-1;
                        				   	}
                        				   }

                        				   }
                        				 
                        				 }
                        				let a=[i,c[i].level,c[i].text,idPadre];
                        				arrayDoc.push(a);
                        				nivelAnt=c[i].level;
                        				idAnterior=i;
                        			}
                        	}
/*=================================================================================================*/  
/*========================LE AGREGA LOS RESPECTIVOS DOCUMENTOS A CADA CARPETA=======================*/  
          // c=ES TODO EL ARREGLO DE SICAS
          // arrayDoc= SON LAS CARPETAS QUE TIENE c                    	
                        cant=arrayDoc.length;
                        let liA='';
                        for(let i=0;i<cant;i++)
                        {
                        	//doc+=`<ul><li class="digitalSicas" href=".carpeta">${c[arrayDoc[i][0]].text}</li>`;
                        	let incrementador=arrayDoc[i][0]+1;
                        	console.log('entre')
                        
                             try
                             {   
                                
                             	let li='';
                                 let salida=0;
                                 let bandFolder=false;
                                  liA='';

                                  let nivelIgual=(arrayDoc[i][1]);
                                    nivelIgual++;
                                   	//if(incrementador<total){
                                   	let salidaWhile=0;
                                   while((c[incrementador].level)==nivelIgual)
                                   {
                                    
                                   	if(!c[incrementador].isFolder)
                                   	{	bandFolder=true;

                                       li+=`<li class="digitalSicas"><a  href="${c[incrementador].href}" onmousedown="mostrarDocumentoVisor(event,this)" target="_blank">${c[incrementador].text}</a></li>`;
                                   	}
                                    if(incrementador==(total-1)){break;}
                                   	 incrementador++;
                                    
                                  }
                               
                                  (li=='')? arrayDoc[i][4]='':arrayDoc[i][4]=`<ul>${li}</ul>`;
                              
                             }
                             catch(error){console.log(error)}
                         
                        }
                            
/*=============================================================================================*/
/*================CONCATENA SUBCARPETAS CON LA CARPETA DE NIVEL 1=============================*/

                        while(nivelMaximo>1)
                        {
                        	 for(let i=0;i<cant;i++)
                        	 {
                               if(arrayDoc[i][1]==nivelMaximo)
                               {
                                let subFolder='';
                               	for(let j=0;j<total;j++)
                        	     {
                                   if(arrayDoc[i][3]==arrayDoc[j][0])
                                   {
                                   	//arrayDoc[j][4]+=`<ul><ul><li class="digitalSicas" href=".carpeta">${arrayDoc[i][2]}</li></ul>${arrayDoc[i][4]}</ul>`;
                                   	arrayDoc[j][4]+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)">►</button><div>'+arrayDoc[i][2]+'</div></div><ul>'+arrayDoc[i][4]+'</ul></div>';
                                   	j=total;
                                   }
                        	     }
                               }
                        	 }
                        	nivelMaximo--;
                        }
/*=================================================================*/   
                        cant=arrayDoc.length;
                        doc='';
/*=========================IMPRIME ARBOL=======================*/
                        for(let i=0;i<cant;i++)
                        {
                           if(arrayDoc[i][3]=="0")
                           {
                           	if(arrayDoc[i][4]==''){doc+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)">►</button><div>'+arrayDoc[i][2]+'</div></div></div>';}
                           	else
                           	{
                           	 doc+='<div class="divContenedorCarpeta"><div class="divContenedorBotonTitulo"><button class="btn-despliegue btn-carpeta" onclick="ocultarHijosFolder(event,this)">►</button><div>'+arrayDoc[i][2]+'</div></div><ul>'+arrayDoc[i][4]+'</ul></div>';
                           	}
                           	//console.log(arrayDoc[i][4]);
                           }   
                        }
/*=============================================================*/
                        console.log(arrayDoc);                        
                        document.getElementById('tab_doc').innerHTML=doc;
                      }  
              
        });
        //console.log(TypeDestinoCDigital,IDValuePK,ActionCDigital);

        $('#tabContent-Docs').toggle(500, "easeInOutSine");
        //document.getElementById('btn-Docs').classList.add('active');

    });

    //----- Funciones botones -----//

    $('#close-tab-Docs').click(function() {
    	$('#tabContent-Docs').toggle(500, "easeInOutSine");
    	//document.getElementById('btn-Docs').classList.remove('active');
    });

    // $('#btn-close-modal').click(function() {
    // 	document.getElementById('aCDocuments').classList.remove('active');
    // });

    // $('#btn-close-icon-modal').click(function() {
    // 	document.getElementById('aCDocuments').classList.remove('active');
    // });

});
</script>

<?php $this->load->view('footers/footer'); ?>

<style type="text/css">
	#tab_doc{background-color: white;
    overflow: scroll;
    height: 305px;}
</style>
<script >
var evento=CKEDITOR.instances['Comentario'];evento.on('afterPaste', function (event) {evento.setData('');});
function ocultarHijosFolder(e,objeto)
{
	e.preventDefault();
  if(objeto.parentElement.parentElement.classList.contains('ocultarHijos'))
  {
   objeto.parentElement.parentElement.classList.remove('ocultarHijos')
   objeto.innerHTML='►'; 
  }
  else{objeto.parentElement.parentElement.classList.add('ocultarHijos');objeto.innerHTML='▼' }
  //objeto.parentElement.parentElement.classList.toggle('ocultarHijos');
}
function agregarCompania(IDSRamo,folioActividad,tipoActividad){
 var idPromotoria=document.getElementById('selectAgregarCompania').value;
 if(idPromotoria>0){
 crearObjetosParaForm(idPromotoria,"idPromotoria");
 crearObjetosParaForm(folioActividad,"folioActividad"); 	
  crearObjetosParaForm(IDSRamo,"IDSRamo"); 	
crearObjetosParaForm(tipoActividad,"tipoActividad"); 	  
 enviarFormGenerales('actividades/agregarCompaniaAdicional');
 }
 else{
 	alert("Escoger compania");
 }
 
}

function guardarMontoAseguradora(folio){
	var objetosForm=document.getElementsByClassName('idRelActividadPromotoria');
	var cantidad=objetosForm.length;
	valores="";
	for(var i=0;i<cantidad;i++){
     valores=valores+objetosForm[i].getAttribute('data-idrelactividadpromotoria')
     valores=valores+'-'+objetosForm[i].value+';';
	}
	crearObjetosParaForm(valores,'identificadorValor','text');
	crearObjetosParaForm(folio,'folio','text');
	enviarFormGenerales('actividades/guardaMontosPromotoria');
}

function enviarArchivoPromotoria(objeto,folioActividad){
 crearObjetosParaForm(objeto.value,"Concepto");
 crearObjetosParaForm(folioActividad,"folioActividad"); 
 enviarFormGenerales('actividades/agregarDocumentoPromotoria');
}

function crearObjetosParaForm(datos,nombre,tipo){
	var input=document.createElement('input');input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class', 'formAutomatico');input.setAttribute('name',nombre);document.body.appendChild(input);
}

function eliminarImportante(folioActividad,idSicas){
	crearObjetosParaForm(folioActividad,"folioActividad");
    crearObjetosParaForm(idSicas,"Status");
    enviarFormGenerales('actividades/eliminarImportante');
}
function actualizarDatosEnSicas(folioActividad,IDDocto,tipoActividadSicas,ClaveBit)
{
 if(document.getElementById('selectStatusSicas').value==6)
 {if(!finalizarActividad){alert('No tiene permisos para finalizar la actividad');return 0;}}
 
	if(document.getElementById('selectStatusSicas').value==1)
	{
		if(document.getElementById('selectMotivoCambio').value==-1)
		{
			alert('Para pasarlo a agente gap escoge un motivo de cambio');
			return 0;
		}
        if(document.getElementById('selectMotivoCambio').value==1)
        {
        	if(tipoActividadParaCaptura!='Cotizacion')
			{  let band=0;
                switch (tipoActividadParaCaptura)
                {
                	case 'CambiodeConducto': band=1;break;
                	case 'Emision':band=1;break;
                	case 'Endoso':band=2;break;
                	case 'Cancelacion':band=2;break;
                	case 'Sustitucion':band=2;break;
                	case 'AclaraciondeComision':band=2;
                }
      
                if(band!=0)
                {
                  if(band==1)
                  {
			       if(document.getElementById('textConceptoSicas'))
			       {			   	
			   	    if(document.getElementById('textConceptoSicas').value!='//Captura')
			   	    {
			         let confirmacion = confirm("SI CONSIDERA QUE ESTA ACTIVIDAD SE DEBE PASAR A CAPTURA: \n\n 1. CANCELAR EL CAMBIO DE ESTADO. \n 2. ACTIVAR EL CHECKBOX: Concepto(pasar a captura) VERIFICANDO QUE ESTE EL //Captura. \n 3. REALIZAR EL CAMBIO DE ESTADO");
                     if(!confirmacion){return 0;} 
			        }
			       }
			       }
			       else
			       {
			       	if(document.getElementById('cbPasarCaptura'))
			       	{
			       		if(!document.getElementById('cbPasarCaptura').checked)
			       		{
			              let confirmacion = confirm("SI CONSIDERA QUE ESTA ACTIVIDAD SE DEBE PASAR A CAPTURA: \n 1. CANCELAR EL CAMBIO DE ESTADO \n 2. ACTIVAR EL CHECKBOX DE Captura \n 3. REALIZAR EL CAMBIO DE ESTADO");
                          if(!confirmacion){return 0;} 
			       		}
			       	}
			       }
			     
			  }//band!=0
			}
	    }
    
          

	     crearObjetosParaForm(document.getElementById('selectMotivoCambio').value,"motivoCambio");
	 }
	if(document.getElementById('textConceptoSicas')){crearObjetosParaForm(document.getElementById('textConceptoSicas').value,"Concepto");}
	if(document.getElementById("cbPasarCaptura")){
		if(document.getElementById("cbPasarCaptura").checked){
	crearObjetosParaForm(document.getElementById('cbPasarCaptura').value,"cambioPropietario");	
	 
	 }
	}
		if(document.getElementById('fechaEmision')){
	crearObjetosParaForm(document.getElementById('fechaEmision').value,"FEmision");}
    crearObjetosParaForm(ClaveBit,"ClaveBit");
	crearObjetosParaForm(tipoActividadSicas,"tipoActividadSicas");
    crearObjetosParaForm(document.getElementById('selectStatusSicas').value,"Status");
    crearObjetosParaForm(folioActividad,"folioActividad");
    crearObjetosParaForm(IDDocto,"IDDocto");
    crearObjetosParaForm(document.getElementById('textComentario').value,'textoComentario');
    crearObjetosParaForm(document.getElementById('idInternoActividadCobranza').value,'idInterno');
    crearObjetosParaForm(document.getElementById('usuarioCreacionActividadCobranza').value,'usuarioCreacion');
    crearObjetosParaForm(document.getElementById('usuarioResponsableActividadCobranza').value,'usuarioResponsable');
    if(document.getElementById('cbPasarCobranza').checked)
    {
     crearObjetosParaForm(document.getElementById('comentarioParaCobranza').value,'comentarioParaCobranza');
     crearObjetosParaForm(document.getElementById('cbPasarCobranza').value,'pasarCobranza');
     if(document.getElementById('comentarioParaCobranza').value==''){alert('PARA PASAR A COBRANZA AGREGAR EL COMENTARIO DE LO REQUERIDO');return 0; }
    }
     enviarFormGenerales('actividades/modificarActividad');
}
function guardarCalificacion(folioActividad,IDVend,tipoActividad,idInterno){
	objetosForm=document.getElementsByClassName('tdCalificacion');objetos="";cant=objetosForm.length;cadena="";
  for(var i=0;i<cant;i++)
  {
    cadena=cadena+objetosForm[i].getAttribute('idCalificacion')+"-"+objetosForm[i].getAttribute('calificacion')+";"; 
  }
 	crearObjetosParaForm(cadena,"calificaciones");
    crearObjetosParaForm(folioActividad,"folioActividad");
    crearObjetosParaForm(IDVend,"IDVend",0);
     crearObjetosParaForm(tipoActividad,"tipoActividad");
     crearObjetosParaForm(idInterno,"idInterno");
    enviarFormGenerales('actividades/guardarCalificacion');
}
function enviarFormGenerales(controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;direccion=direccion+controlador;

  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.setAttribute('name','miFormulario');formulario.setAttribute('id','miFormulario');
  formulario.setAttribute('enctype',' multipart/form-data')
  objetosForm=document.getElementsByClassName('formAutomatico');objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++)
  {var objeto=document.createElement('input');objeto.setAttribute('value',objetosForm[i].value);objeto.setAttribute('name',objetosForm[i].name);objeto.setAttribute('type','hidden');formulario.appendChild(objeto); 
  }
  document.body.appendChild(formulario);
  formulario.submit();
}
function califica(objeto){
	if(objeto.classList.contains('estrellaChecked')){
		objeto.classList.remove("estrellaChecked");
		objeto.classList.add("estrellaNoChecked");
		objeto.setAttribute('calificacion',0);
	}else{
				objeto.classList.add("estrellaChecked");
		objeto.classList.remove("estrellaNoChecked");
		objeto.setAttribute('calificacion',1);
	}
	//console.log(objeto.getAttribute('idCalificacion'));
}

$(function () {$(".fechaPersona").datepicker({
		closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  firstDay: 1,  
     changeMonth: true,
    changeYear: true,  
});
});

	function generaLinkEnvio(tipoLink, numeroMovilLink, correoLink, datosLink){

	//	console.log(tipoLink);
	//	console.log(numeroMovilLink);
	//	console.log(correoLink);
	//	console.log(datosLink);
	
		var paramLinkCorto	= {
								"linkLargo"		: datosLink,
							  }
		//** console.log(paramLinkCorto);
		$.ajax({
			always:		function(){
							$('#modalPreload').modal('show');
						},
			url:		'<?=base_url()."bitly_controller/getLinkCorto"?>',
			type:		'POST',
			data:		paramLinkCorto,
			success:	function(data){
							data = jQuery.parseJSON(data);
							//** console.log(data);
							switch(tipoLink){
								case "linkSms":
// base_url('smsMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('smsMasivo?')."paraTelefonosUrl="; ?>'+numeroMovilLink+'&smsTextUrl=Documento de la Poliza '+data, '_blank');
									//console.log('Sms');
								break;
			
								case "linkWhatSapp":

// base_url('whatsAppMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('whatsAppMasivo?')."paraTelefonosUrl="; ?>'+numeroMovilLink+'&smsTextUrl=Documento de la Poliza '+data, '_blank');
									//console.log('WhatSapp');
								break;
			
								case "linkCorreo":
// base_url('mailMasivo?')."paraCorreoUrl=".$infoCliente[0]->EMail1."&textCorreoUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('mailMasivo?')."paraCorreoUrl="; ?>'+correoLink+'&textCorreoUrl=Documento de la Poliza '+data, '_blank');
									//console.log('Correo');
								break;
							}
						}
		});
	}

</script>
<?php

function imprimirAgregarCompania($datos,$folioActividad,$IDSRamo,$tipoActividad){			
		$option='<select id="selectAgregarCompania" class="form-control input-sm"><option id="-1">Escoger compania</option>';
		foreach ($datos as $value) {
			 $option.='<option value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
			}	
		$option.='</select><button onclick="agregarCompania('.$IDSRamo.',\''.$folioActividad.'\',\''.$tipoActividad.'\')" class="btn btn-primary btn-sm">Agregar compania</button>';
		return $option;
}

function imprimirCalificaciones($datos){
	$tabla='<table border="1">';
	foreach ($datos as  $value) {
		$tabla=$tabla.'<tr>';
		$tabla=$tabla.'<td><label>'.$value->calificacionAgente.'</label></td>';
		$tabla=$tabla.'<td idCalificacion="'.$value->idCalificacionAgente.'" calificacion="1" onclick="califica(this)"  class="estrellaChecked tdCalificacion"></td>';
		$tabla=$tabla.'</tr>';
	}
	$tabla=$tabla.'</table>';
	return $tabla;
}

function imprimirPromotorias($datos,$folioActividad,$idSicas,$FolderDestino,$TypeDestinoCDigital){
	$file="<table>";
    $band=0;
   
	foreach ($datos as $key => $value) {
		$band="";
		$enviado="";		
		if($value->numArchivos>0){$enviado="--->Archivo de [".$value->tipoActividad."] arriba";}
		if($value->tipoActividad=='Cotizacion'){
		if($value->montoRAP>0){
		$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="if(!this.value.length)return false; this.form.submit();"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td>$<input type="text" style="text-align:right" data-idRelActividadPromotoria="'.$value->idRelActividadPromotoria.'" class="form-control idRelActividadPromotoria" value="'.$value->montoRAP.'"></td></tr>';
		$band=$value->folioActividad;}
	else{
$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="alert(\'Para Agregar el archivo hay que poner  el monto\')"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td>$<input type="text" style="text-align:right" data-idRelActividadPromotoria="'.$value->idRelActividadPromotoria.'" class="form-control idRelActividadPromotoria" value="'.$value->montoRAP.'"></td></tr>';$band=$value->folioActividad;
	   }
	  }
	  else{
	  		$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="if(!this.value.length)return false; this.form.submit();"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" class="form-control" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td></td></tr>';
	
	  }
	}
	if($band!=""){
		$file.='<tr><td></td><td><button onclick="guardarMontoAseguradora(\''.$band.'\')" class="btn btn-primary btn-sm">Guardar</button>';
	}
	$file.="</table>";

   return $file;
}

function imprimirDatosAdicionales($datos){
	$informacion='<table border="1">';
if(count($datos)>0){
$informacion.='<tr><td><label>Preferencia de comunicacion</td><td>'.$datos[0]->preferenciaComunicacion.'</label></td></tr><br>';
$informacion.='<tr><td><label>Horarion de comunicacion</td><td>'.$datos[0]->horarioComunicacion.'</label></td></tr><br>';
$informacion.='<tr><td><label>Dia de comunicacion</td><td>'.$datos[0]->diaComunicacion.'</label></td></tr><br>';
$informacion.='<tr><td><label>Telefono</td><td>'.$datos[0]->Telefono1.'</label></td></tr><br>';
$informacion.='<tr><td><label>Email</td><td>'.$datos[0]->EMail1.'</label></td></tr><br>';
}else{
$informacion.='<tr><td><label>Preferencia de comunicacion</label></td><td></td></tr><br>';
$informacion.='<tr><td><label>Horarion de comunicacion</label></td><td></td></tr><br>';
$informacion.='<tr><td><label>Dia de comunicacion</label></td><td></td></tr><br>';
$informacion.='<tr><td><label>Telefono</label></td><td></td></tr><br>';
$informacion.='<tr><td><label>Email</label></td><td></td></tr><br>';	
}
$informacion.="</table>";
	return $informacion;
}

function imprimirTarjetas($datos)
{
	
	         $option='<option value="0">Escoger Tarjeta</option>';
     foreach ($datos as  $value) 
     {
         $option.='<option data-numerotarjeta="'.$value->numeroTarjeta.'" data-codigoseguridad="'.$value->codigoSeguridad.'" data-vencimiento="'.$value->vencimiento.'" data-anio="'.$value->anio.'" data-titulartarjeta="'.$value->titularTarjeta.'" data-tipotarjeta="'.$value->tipoTarjeta.'" data-banco="'.$value->banco.'" data-tipoPago="'.$value->tipoPago.'" data-idpersonatarjeta="'.$value->idPersonaTarjeta.'" data-idcli="'.$value->IDCli.'">'.$value->banco.'->'.$value->numeroTarjeta.'</option>';
    }
  return $option;

}
?>
<style type="text/css">
    .estrellaNoChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starVacia.png' ?>) }
    .estrellaChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starLlena.png' ?>) }

</style>
<script type="text/javascript">$("#fechaEmision").datepicker('setDate', 'today');</script>


<?

if($infoFolioActividad->motivoCambio==1)
{
 ?>
 <script type="text/javascript">

 	let cant=document.getElementsByClassName('manejoActividad').length;
    for(let i=0;i<cant;i++){document.getElementsByClassName('manejoActividad')[i].setAttribute('style','display:none');
    }
 </script>
<?}

?>
<?
if(isset($permisos['tarjetaBancoActividad'])){
?>
<script type="text/javascript">
function verTarjetas(objeto)
{
	numeroTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-numerotarjeta');
	codigoSeguridad2.value=objeto.options[objeto.selectedIndex].getAttribute('data-codigoseguridad');
	vencimiento2.value=objeto.options[objeto.selectedIndex].getAttribute('data-vencimiento');
	anio2.value=objeto.options[objeto.selectedIndex].getAttribute('data-anio');
	titularTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-titulartarjeta');
	tipoTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-tipotarjeta');
	banco2.value=objeto.options[objeto.selectedIndex].getAttribute('data-banco');
	tipoPagoTarjeta2.value=objeto.options[objeto.selectedIndex].getAttribute('data-tipoPago');
}



</script>
<?	
}
?>
<script type="text/javascript">
	
    
	if(document.getElementById('documentosWWW')){document.getElementById('documentosWWW').value="<?=$documentosParaRecotizar?> "}
	function agregarDiagonal(objeto)
{
 if(objeto.checked){document.getElementById('textConceptoSicas').value='//Captura';}
 else{document.getElementById('textConceptoSicas').value=document.getElementById('textConceptoSicas').dataset.oldvalue;}
}
if(document.getElementById('contieneDocumentosEndosoDiv'))
{
	let div=document.getElementsByName('esEndosoActividad');
	let cant=div.length;
	let divIns='';
	for(let i=0;i<cant;i++){divIns+=div[i].innerHTML;}
	contieneDocumentosEndosoDiv.innerHTML=divIns;
}

function agregarDocto(e)
{
	e.preventDefault();
	if(document.getElementById('descripcionArchivo').value.trim()=='')
	{
		alert("ES NECESARIO AGREGAR UN COMENTARIO");
		return 0;
	}

	if(document.getElementById('tipoImg_0').value=='')
	{
		alert("ES NECESARIO ESCOGER EL TIPO DE ARCHIVO");
		return 0;
	}
	if(document.getElementById('DocumentoFiles').value=='')
	{
		alert("ES NECEARIO UN AGREGAR UN ARCHIVO");
		return 0;
	}
	else
	{
		let tamanio=(parseFloat(document.getElementById('DocumentoFiles').files[0].size))/parseFloat(1000000);
		if(tamanio>=8){alert('EL ARCHIVO SUPERO EL LIMITE');return 0;}
		
	}
document.formActividadVer_AgregaDocumentos.submit();

}

if(document.getElementById('tipoImg_0')){document.getElementById('tipoImg_0').setAttribute('required','')}
	var tipoActividadParaCaptura="<?=$tipoActividadParaCaptura;?>";

</script>
<style type="text/css">
	.modal-backdrop{z-index: 0}
	a {color:#472380;}
	.contenedoDocumentosNombreDiv{display: flex;margin-top: 10px}
</style>

<style type="text/css" id="estiloParaMovilV3">
@media only screen and (min-device-width: 320px)
{
 
 .linkParaDocumento{font-size: 35px;}
 .glyphicon-file{font-size: 25px}
 .linkCorreo{width: 60px;height: 60px;font-size: 25px}
 .linkWhatSapp{width: 60px;height: 60px;font-size: 25px}
 .linkSms{width: 60px;height: 60px;font-size: 25px}
 .cke_editable{font-size:50px}
 label{font-size: 40px}

 .input-sm{font-size: 35px;height: 80px}
.form-control{font-size: 35px;height: 80px}
select.input-sm{font-size: 35px;height: 80px}
  body{width: 1200px}
  .nav-tabs > li.active > a{font-size: 35px}  
 .nav-tabs > li > a {font-size: 35px}  
 .btn {height: 60px;width: 100px}
 .fa-lg{height: 60px;width: 60px}
 .btn-default{height: 60px;width: 60px}
 .btn-sm{height: 100px;width: 300px;font-size: 35px}
 .formaNombreForm{font-size: 35px}
 .btnActividadComentariosOperativos{height: 100px;width: 200px;font-size: 35px}
 .manejoActividad{width: 400px;font-size: 25px}
 .contenedoDocumentosNombreDiv{display: flex}

}
</style>
<script type="text/javascript">
     
      
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
          //document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));
          
        }
        else{document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));} 
    
</script><script type="text/javascript">
	/*!
 * jQuery EasyTree Plugin
 * http://www.EasyJsTree.com
 *
 * Copyright 2014 Matthew Rand
 * Released under the MIT license
 * V1.0.1
 */

(function ($) { 
	$.fn.easytreeDocsClient = function (a) { 
		var b = this; var c = new F(b, a); return c 
	}; var F = function (z, A) { 
		var B = { 
			allowActivate: true, data: null, dataUrl: null, dataUrlJson: null, disableIcons: false, enableDnd: false, ordering: null, slidingTime: 100, minOpenLevels: 0, building: null, built: null, toggling: null, toggled: null, opening: null, opened: null, openLazyNode: null, closing: null, closed: null, canDrop: null, dropping: null, dropped: null, stateChanged: null 
		}; var C; var D = null; var E = new Object(); this.init = function (b, c) {
		 B = $.extend(B, c); init(); C = b; var d = ''; if (B.dataUrl) { 
		 	ajaxService(B.dataUrl, B.dataUrlJson, function (a) { 
		 		d = convertInputDataToJson(a); if (!d) { 
		 			alert("EasyTree: Invalid data!"); return this 
		 		} buildTree(d); return this 
		 	}) 
		 } else if (B.data) { 
		 	d = convertInputDataToJson(B.data); if (!d) { 
		 		alert("EasyTree: Invalid data!"); return this 
		 	} buildTree(d) 
		 } else { 
		 	d = convertInputDataToJson(C.html()); if (!d) { 
		 		alert("EasyTree: Invalid data!"); 
		 		return this 
		 	} buildTree(d) 
		 } return this 
		}; this.options = B; this.rebuildTree = function (a) { 
			var b = a ? convertInputDataToJson(a) : D; if (!b) { 
				alert("EasyTree: Invalid data!") 
			} buildTree(b) 
		}; this.getAllNodes = function () { 
			return D 
		}; this.getNode = function (a) { 
			return getNode(D, a) 
		}; this.addNode = function (a, b) { 
			if (!b) { D.push(a); 
				return 
			} var c = getNode(D, b); if (!a) { 
				return 
			} if (!c.children) { 
				c.children = [] 
			} c.children.push(a) 
		}; this.removeNode = function (a) { 
			removeNode(D, a) 
		}; this.activateNode = function (a) { 
			unactivateAll(D); if (!B.allowActivate) { 
				return 
			} var b = getNode(D, a); if (!b) { 
				return 
			} b.isActive = true; $('#' + b.id).addClass('easytree-active') 
		}; this.toggleNode = function (a) { 
			var b = getNode(D, a); if (!b) { 
				return 
			} toggleNodeBegin(event, D, b) 
		}; function nodeClick(a) { 
			var b = getElementId(this); var c = a.data; var d = getNode(c, b); if (!d) { 
				return 
			} unactivateAll(c); if (!B.allowActivate) { 
				return 
			} d.isActive = true; $('#' + d.id).addClass('easytree-active'); if (B.stateChanged) { 
				var j = getMinifiedJson(c); B.stateChanged(c, j) 
			} 
		} function toggleNodeEvt(a) { 
			var b = getElementId(this); var c = a.data; var d = getNode(c, b); if (!d) { 
				return 
			} toggleNodeBegin(a, c, d) 
		} function toggleNodeBegin(c, d, e) { 
			var f = ''; if (B.toggling) { 
				f = B.toggling(c, d, e); if (f === false) { 
					return false 
				} 
			} if (e.isExpanded) { 
				if (B.closing) { 
					f = B.closing(c, d, e); if (f === false) { 
						return false 
					} 
				} 
			} else { 
				if (B.opening) { 
					f = B.opening(c, d, e); if (f === false) { 
						return false 
					} 
				} 
			} if (e.isLazy && !e.isExpanded) { 
				var g = e.children && e.children.length > 0; f = true; if (B.openLazyNode) { 
					f = B.openLazyNode(c, d, e, g) 
				} if (e.lazyUrl && f !== false) { 
					ajaxService(e.lazyUrl, e.lazyUrlJson, function (a) { 
						if (a.d) { 
							a = a.d 
						} var b = convertInputDataToJson(a); if ($.isArray(b)) { 
							e.children = b 
						} else { 
							e.children = []; e.children.push(b) 
						} buildTree(d); toggleNodeEnd(c, d, e) 
					}); return false 
				} 
			} toggleNodeEnd(c, d, e) 
		} function toggleNodeEnd(a, b, c) { if (c.isExpanded) { openCloseNode(b, c.id, "close"); renderNode(c, "close"); if (B.closed) { B.closed(a, b, c) } } else { openCloseNode(b, c.id, "open"); renderNode(c, "open"); if (B.opened) { B.opened(a, b, c) } } if (B.toggled) { var d = B.toggled(a, b, c) } } function dragStart(a) { if (!B.enableDnd) { return } var b = a.target; while (b) { if (b.className.indexOf("easytree-draggable") > -1) { break } b = b.parentElement } if (!b) { return } unsourceAll(D); unactivateAll(D); $('#' + b.id).addClass('easytree-drag-source'); resetDnd(E); E.createClone = !(b.className.indexOf("easytree-no-clone") > -1); E.dragok = true; E.sourceEl = b; E.sourceId = b.id; E.sourceNode = getNode(D, E.sourceId); return false } function drag(a) { if (!E.dragok) { return } if (!B.enableDnd) { return } if (E.createClone) { if (!E.clone) { E.clone = createClone(E.sourceEl); $(E.clone).appendTo('body') } E.clone.style.left = (a.pageX + 5) + "px"; E.clone.style.top = (a.pageY) + "px" } var b = getDroppableTargetEl(a.clientX, a.clientY); if (!b) { hideDragHelpers(); E.targetEl = null; E.targetId = null; E.targetNode = null; E.canDrop = false; return } if (b.id == E.targetId) { return } E.canDrop = false; window.clearTimeout(E.openDelayTimeout); E.targetEl = b; E.targetId = b.id; E.targetNode = getNode(D, E.targetId); log('source:' + (E.sourceNode && E.sourceNode.text ? E.sourceNode.text : E.sourceId)); log('target:' + (E.targetNode && E.targetNode.text ? E.targetNode.text : E.targetId)); log('isAncester:' + isAncester(E.sourceNode, E.targetId)); var c = $('#' + E.targetId); if (isAncester(E.sourceNode, E.targetId)) { showRejectDragHelper(); return } if (E.targetId == E.sourceId) { hideDragHelpers(); return } if (B.canDrop) { var d = E.sourceNode != null; var e = d ? E.sourceNode : E.sourceEl; var f = E.targetNode != null; var g = f ? E.targetNode : E.targetEl; var h = B.canDrop(a, D, d, e, f, g); if (h === true) { showAcceptDragHelper(); E.canDrop = true; E.openDelayTimeout = window.setTimeout(function () { openCloseNode(D, E.targetId, 'open'); renderNode(E.targetNode, 'open') }, 600); return } else if (h === false) { showRejectDragHelper(); return } } if (c.hasClass('easytree-reject')) { showRejectDragHelper() } else if (c.hasClass('easytree-accept')) { showAcceptDragHelper(); E.canDrop = true; E.openDelayTimeout = window.setTimeout(function () { openCloseNode(D, E.targetId, 'open'); renderNode(E.targetNode, 'open') }, 600) } else { hideDragHelpers() } return false } function dragEnd(a) { var b = E.sourceNode != null; var c = b ? E.sourceNode : E.sourceEl; var d = E.targetNode != null; var e = d ? E.targetNode : E.targetEl; var f = E.canDrop; hideDragHelpers(); $('#_st_clone_').remove(); if (c === null || e === null) { resetDnd(E); return false } if (B.dropping) { var g = B.dropping(a, D, b, c, d, e, f); if (g === false) { resetDnd(E); return } } if (E.targetNode && E.sourceNode && f) { if (!E.targetNode.children) { E.targetNode.children = [] } removeNode(D, E.sourceId); E.targetNode.children.push(E.sourceNode) } if (f) { if (B.dropped) { B.dropped(a, D, b, c, d, e) } buildTree(D) } resetDnd(E); return false } function createClone(a) { $(a).remove(".easytree-expander"); var b = $(a).clone().remove(".easytree-expander").removeClass('easytree-drag-source')[0]; var c = b.children[0]; if (c && c.className == 'easytree-expander') { b.removeChild(c) } b.style.display = 'block'; b.style.position = "absolute"; b.style.opacity = 0.5; b.id = '_st_clone_'; b.style.zIndex = 1000; return b } function getDroppableTargetEl(a, b) { var c = document.elementFromPoint(a, b); while (c) { if (c.className.indexOf('easytree-droppable') > -1) { return c } c = c.parentElement } return null } function resetDnd(a) { a.canDrop = false; a.createClone = true; a.clone = null; a.dragok = false; a.openDelayTimeout = null; a.targetEl = null; a.targetId = null; a.targetNode = null; a.sourceEl = null; a.sourceId = null; a.sourceNode = null } function getElementId(a) { while (a != null) { if (a.id) { return a.id } a = a.parentElement } return null } function getNode(a, b) { var i = 0; for (i = 0; i < a.length; i++) { var n = a[i]; var t = n.text; if (n.id == b) { return n } var c = n.children && n.children.length > 0; if (c) { var d = getNode(n.children, b); if (d) { return d } } } return null } function isAncester(a, b) { var i = 0; if (!a || !a.children || a.children.length == 0) { return false } for (i = 0; i < a.children.length; i++) { var n = a.children[i]; var t = n.text; if (n.id == b) { return true } var c = n.children && n.children.length > 0; if (c) { var d = isAncester(n, b); if (d) { return d } } } return false } function removeNode(a, b) { var i = 0; for (i = 0; i < a.length; i++) { var n = a[i]; var t = n.text; if (n.id == b) { a.splice(i, 1); return } var c = n.children && n.children.length > 0; if (c) { removeNode(n.children, b) } } } function openCloseNode(a, b, c) { var i = 0; for (i = 0; i < a.length; i++) { var n = a[i]; var t = n.text; if (n.id == b) { n.isExpanded = c == "open"; return } var d = n.children && n.children.length > 0; if (d) { openCloseNode(n.children, b, c) } } } function unactivateAll(a) { var i = 0; for (i = 0; i < a.length; i++) { var n = a[i]; n.isActive = false; $('#' + n.id).removeClass('easytree-active'); var b = n.children && n.children.length > 0; if (b) { unactivateAll(n.children) } } } function unsourceAll(a) { var i = 0; for (i = 0; i < a.length; i++) { var n = a[i]; $('#' + n.id).removeClass('easytree-drag-source'); var b = n.children && n.children.length > 0; if (b) { unsourceAll(n.children) } } } function sort(f) { var i = 0; f = f.sort(function (a, b) { var c = a.text.toLowerCase(); var d = b.text.toLowerCase(); if (!c) { c = "a" } if (!d) { d = "a" } if (B.ordering.toLowerCase().indexOf('folder') > -1 && a.isFolder) { c = "______" + c } if (B.ordering.toLowerCase().indexOf('folder') > -1 && b.isFolder) { d = "______" + d } var e = B.ordering.indexOf(" DESC") == -1 ? 1 : -1; if (c < d) { return -1 * e } if (c > d) { return 1 * e } return 0 }); for (i = 0; i < f.length; i++) { var n = f[i]; var g = n.children && n.children.length > 0; if (g) { sort(n.children) } } return f } function giveUniqueIds(a, b, c) { var i = 0; if (!b) { b = 0; c = "_st_node_" + c + "_" } for (i = 0; i < a.length; i++) { var n = a[i]; if (!n.id) { n.id = c + i.toString() } var d = n.children && n.children.length > 0; if (d) { giveUniqueIds(n.children, b + 1, c + i + "_") } } } function buildTree(a) { if (!a) { return } var b = new Date(); if (B.building) { var c = B.building(a); if (c === false) { return false } } var d = new Date(); if (B.ordering) { a = sort(a) } var e = new Date(); var f = Math.floor(Math.random() * 10000); giveUniqueIds(a, 0, f); var g = new Date(); D = a; var h = getNodesAsHtml(a, 0, true); var i = new Date(); C[0].innerHTML = h; var k = new Date(); $(C.selector + " .easytree-node").on("click", a, nodeClick); $(C.selector + " .easytree-expander").on("click", a, toggleNodeEvt); $(C.selector + " .easytree-icon").on("dblclick", a, toggleNodeEvt); $(C.selector + " .easytree-title").on("dblclick", a, toggleNodeEvt); var l = new Date(); if (B.enableDnd) { $(document).on("mousedown", dragStart); $(document).on("mousemove", drag); $(document).on("mouseup", dragEnd) } var m = new Date(); if (B.built) { B.built(a) } var n = new Date(); if (B.stateChanged) { var j = getMinifiedJson(a); B.stateChanged(a, j) } var o = new Date(); var p = d - b; var q = e - d; var r = g - e; var s = i - g; var t = k - i; var u = l - k; var v = m - l; var w = n - m; var x = o - n; var y = o - b } 
		
		function getNodesAsHtml(a, b, c) { 
			var d = ''; 
			let mn = '';
			var i = 0; 
			var e = ""; 
			if (b == 0) { 
				e += "ui-easytree easytree-container easytree-focused" 
			} 
			var f = b < B.minOpenLevels; 
			var g = b == 0 || c || f ? "" : " style='display:none' "; 
			d += '<ul tabindex="0" class="' + e + '" ' + g + '>'; 
			for (i = 0; i < a.length; i++) { 
				var n = a[i]; 
				if (f === true) { 
					n.isExpanded = true 
				} 
				var h = i == a.length - 1; 
				var j = getSpanCss(n, h);
				if (n.isFolder != false) { 
					d += '<li>'; 
					d += '<span id="' + n.id + '" class="' + j + ' ">';
					d += f ? '' : '<span class="easytree-expander" ></span>';
					d += getIconHtml(n); 
					d += getTitleHtml(n);
					d += '</span>'; 
					if (n.children && n.children.length > 0) { 
						d += getNodesAsHtml(n.children, b + 1, n.isExpanded) 
					}
					console.log(n.children);
					d += '</li>';
				}
				else if (n.isFolder == false) {
					d += '<li class="">';
					d += '<span id="'+n.id+'" class='+j+'">'; 
					//d += '<span class="easytree-expander"></span>'; 
					d += getIconHtml(n); 
					d += getTitleHtml(n); 
					d += '</span>'; 
					if (n.children && n.children.length > 0) { 
						d += getNodesAsHtml(n.children, b + 1, n.isExpanded); 
					} 
					d += '</li>'
				}  
			} 
			d += '</ul>'; 
			return d  
		}

		function getSpanCss(a, b) { var c = a.children && a.children.length > 0; var d = "easytree-node "; if (B.enableDnd) { d += " easytree-draggable " } if (a.liClass) { d += a.liClass } if (a.isFolder && B.enableDnd) { d += " easytree-droppable easytree-accept " } else if (B.enableDnd) { d += " easytree-droppable easytree-reject " } if (a.isActive && B.allowActivate) { d += " easytree-active " } d += getExpCss(a, b); var e = a.isExpanded ? "e" : "c"; if (a.isFolder) { e += "f" } d += " easytree-ico-" + e; return d } function getExpCss(a, b) { var c = a.children && a.children.length > 0; var d = ""; if (!c && a.isLazy) { d = "c" } else if (a.isFolder && a.level > 1) { d="c"} else if (a.level <= 1) { d=" hidden" } else if (a.level >= 2) { d+="n show" } else if (!c) { d = "n" } else if (a.isExpanded) { d = "e" } else { d = "c" } if (b) { d += "l" } return " easytree-exp-" + d } function getIconHtml(a) { var b = ''; if (B.disableIcons) { return b } if (a.uiIcon) { return '<span class="easytree-custom-icon ui-icon ' + a.uiIcon + '"></span>' } if (a.iconUrl) { return '<span><img src="' + a.iconUrl + '" /></span>' } return '<span class="easytree-icon"></span>' } function getTitleHtml(a) { var b = ''; var c = a.tooltip ? 'title="' + a.tooltip + '"' : ""; var d = "easytree-title"; if (a.textCss) { d += " " + a.textCss } b += '<span ' + c + ' class="' + d + '">'; if (a.href) { b += '<a href="' + a.href + '" '; if (a.hrefTarget) { b += ' target="' + a.hrefTarget + '" ' } b += '>' } b += a.text; if (a.href) { b += '</a>' } b += '</span>'; return b } function renderNode(a, b) { if (!a) { return } var c = $('#' + a.id).attr('class'); var d = c.indexOf('easytree-exp-'); if (d > -1) { var e = c.indexOf(' ', d); var f = e > -1 ? c.substring(d, e) : c.substring(d); $('#' + a.id).removeClass(f); $('#' + a.id).addClass(getExpCss(a, false)) } var g = $('#' + a.id).parents('li').first(); var h = g.children('ul').first(); var i = parseInt(B.slidingTime, 10); if (b == "close") { h.slideUp(i) } else { h.slideDown(i) } } function hideDragHelpers() { $("#easytree-reject").hide(); $("#easytree-accept").hide() } function showAcceptDragHelper() { $("#easytree-accept").show(); $("#easytree-reject").hide() } function showRejectDragHelper() { $("#easytree-reject").show(); $("#easytree-accept").hide() } function getMinifiedJson(a) { var j = JSON.stringify ? JSON.stringify(a) : 'Please import json2.js'; while (j.indexOf(',"children":[]') > -1) { j = j.replace(',"children":[]', '') } while (j.indexOf('"liClass":"",') > -1) { j = j.replace('"liClass":"",', '') } while (j.indexOf('"textCss":"",') > -1) { j = j.replace('"textCss":"",', '') } while (j.indexOf('"isExpanded":false,') > -1) { j = j.replace('"isExpanded":false,', '') } while (j.indexOf('"isActive":false,') > -1) { j = j.replace('"isActive":false,', '') } while (j.indexOf('"isFolder":false,') > -1) { j = j.replace('"isFolder":false,', '') } while (j.indexOf('"isLazy":false,') > -1) { j = j.replace('"isLazy":false,', '') } return j } function init() { initDragHelpers(); resetDnd(E); $(document).on("mousemove", function (a) { var b = a.pageY; var c = a.pageX; document.getElementById('easytree-reject').style.top = (b + 10) + 'px'; document.getElementById('easytree-reject').style.left = (c + 17) + 'px'; document.getElementById('easytree-accept').style.top = (b + 10) + 'px'; document.getElementById('easytree-accept').style.left = (c + 17) + 'px' }) } function initDragHelpers() { if (!$("#easytree-reject").length) { var a = '<div id="easytree-reject" class="easytree-drag-helper easytree-drop-reject">'; a += '<span class="easytree-drag-helper-img"></span>'; a += '</div>'; $('body').append(a) } if (!$("#easytree-accept").length) { var b = '<div id="easytree-accept" class="easytree-drag-helper easytree-drop-accept">'; b += '<span class="easytree-drag-helper-img"></span>'; b += '</div>'; $('body').append(b) } } function ajaxService(d, e, f) { $.ajax({ url: d, type: "POST", contentType: "application/json; charset=utf-8", data: e, success: f, error: function (a, b, c) { alert("Error: " + a.responseText) } }) } function convertInputDataToJson(a) { var b = null; if (typeof a == 'object') { b = a } else if (typeof a == 'string') { a = $.trim(a); if (a.indexOf('[') == 0 || a.indexOf('{') == 0) { b = $.parseJSON(a) } else { b = convertHtmlToJson(a) } } return b } function convertHtmlToJson(b) { var i = 0; var c = $(b); var d = []; var e = c.children().each(function (a) { d.push(convertHtmlToNode(this)) }); return d } function convertHtmlToNode(b) { var c = $(b); var d = {}; var e = c.data(); d.isActive = c.hasClass('isActive'); c.removeClass('isActive'); d.isFolder = c.hasClass('isFolder'); c.removeClass('isFolder'); d.isExpanded = c.hasClass('isExpanded'); c.removeClass('isExpanded'); d.isLazy = c.hasClass('isLazy'); c.removeClass('isLazy'); d.uiIcon = e.uiicon; d.liClass = c.attr('class'); d.id = c.attr('id'); var f = c.children('a'); if (f) { d.href = f.attr('href'); d.hrefTarget = f.attr('target') } var g = c.children('img'); if (g) { d.iconUrl = g.attr('src') } d.textCss = ''; var h = c.children('span'); if (h && h.attr('class')) { d.textCss += h.attr('class') + ' ' } h = f.children('span'); if (h && h.attr('class')) { d.textCss += h.attr('class') + ' ' } h = g.children('span'); if (h && h.attr('class')) { d.textCss += h.attr('class') + ' ' } d.text = getNodeValue(c[0]); d.tooltip = c.attr('title'); d.children = []; var i = c.children('ul').children('li').each(function (a) { d.children.push(convertHtmlToNode(this)) }); return d } function getNodeValue(a) { var i = 0; for (i = 0; i < a.childNodes.length; i++) { var b = a.childNodes[i]; while (b) { if (b.nodeType == 3 && $.trim(b.nodeValue).length > 0) { return $.trim(b.nodeValue) } b = b.firstChild } } return '' } this.init(z, A); function log(a) { if (!a) { a = 'null' } console.log(a) } } }(jQuery));

</script>
<link rel="stylesheet" href="<?=base_url()?>assets/css/capsysTipoArchivo.css">
<script type="text/javascript">
	function limpiarContenedorDocumento()
	{
      document.getElementById('visorXMLDOC').setAttribute('src','');
      document.getElementById('visorGeneral').setAttribute('src','');
      document.getElementById('visorJPG').setAttribute('src','');
      document.getElementById('visorTXT').setAttribute('src','');
      document.getElementById('nombreDocumentoH4').innerHTML='';
	}
	function mostrarDocumentoVisor(e,objeto)
	{ 
		/*e.preventDefault();
		document.getElementById('ventanaMostrarImagen').setAttribute('src',objeto.getAttribute('href'));
		document.getElementById('ventanaMostrarImagen').setAttribute('type','application/pdf')*/
		//limpiarContenedorDocumento();
		if(e.button==2)
		{      
			 let href=objeto.getAttribute('href');
			let ref=href.slice((href.lastIndexOf(".") - 1 >>> 0) + 2);
			ref=ref.toUpperCase();
			document.getElementById('visorGeneral').classList.add('ocultarVisorArchivos');
			document.getElementById('visorTXT').classList.add('ocultarVisorArchivos');
			document.getElementById('visorXMLDOC').classList.add('ocultarVisorArchivos');
			document.getElementById('visorGeneral').classList.remove('verVisorArchivos');
			document.getElementById('visorTXT').classList.remove('verVisorArchivos');
			document.getElementById('visorXMLDOC').classList.remove('verVisorArchivos');
			document.getElementById('visorJPGDiv').classList.add('ocultarVisorArchivos');
			document.getElementById('visorJPGDiv').classList.remove('verVisorArchivos');
			document.getElementById('visorSinProcesarArchivo').classList.add('ocultarVisorArchivos');
			document.getElementById('visorSinProcesarArchivo').classList.remove('verVisorArchivos');
			   document.getElementById('cargaArchivosDiv').classList.add('verVisorArchivos');
	          document.getElementById('cargaArchivosDiv').classList.remove('ocultarVisorArchivos')
			document.getElementById('nombreDocumentoH4').innerHTML=`<label class="label label-info">${objeto.innerHTML}</label>`;

			if(ref=='XLS' || ref=='XLSX' || ref=='DOC' || ref=='DOCX' || ref=='XLSM' )
			{


				document.getElementById('visorXMLDOC').classList.remove('ocultarVisorArchivos');
				document.getElementById('visorXMLDOC').classList.add('verVisorArchivos');				
		    	document.getElementById('visorXMLDOC').setAttribute('src','//view.officeapps.live.com/op/embed.aspx?src='+href);
                
			}
			else
			{
				if(ref=='XML' || ref=='PDF' ){
				document.getElementById('visorGeneral').classList.remove('ocultarVisorArchivos');
				document.getElementById('visorGeneral').classList.add('verVisorArchivos');	
				document.getElementById('visorGeneral').setAttribute('src','https://docs.google.com/gview?url='+href+'&id=explorer&efh=false&a=v&chrome=false&embedded=true');
			  }
			  else
			  {//https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000013028/Cliente/IFE--202101111842.jpg
			  	if(ref=='JPG' || ref=='PNG' || ref=='JPEG')
			  	{
				document.getElementById('visorJPGDiv').classList.remove('ocultarVisorArchivos');
				document.getElementById('visorJPGDiv').classList.add('verVisorArchivos');	
				//document.getElementById('visorJPG').setAttribute('src',href);
				//document.getElementById('visorJPG').setAttribute('type',"image/jpg");
								//document.getElementById('visorGeneral').setAttribute('src','https://docs.google.com/gview?url='+href+'&id=explorer&efh=false&a=v&chrome=false&embedded=true');
						document.getElementById('visorJPG').setAttribute('src',href);

			  	}
			  	else
			  	{
                   if(ref=='TXT')
                   {
                      				document.getElementById('visorTXT').classList.remove('ocultarVisorArchivos');
				document.getElementById('visorTXT').classList.add('verVisorArchivos');	
			
						document.getElementById('visorTXT').setAttribute('src',href);
                   }
                   else{
                  document.getElementById('visorSinProcesarArchivo').classList.remove('ocultarVisorArchivos');
				  document.getElementById('visorSinProcesarArchivo').classList.add('verVisorArchivos');
				  cargarDocumentoFin();
				}

			  	}
			  }
			}
		}

	}

</script>
<script type="text/javascript">
   document.oncontextmenu = function(){return false;}
</script>
<style type="text/css">
	#contieneDocumentosEndosoDiv
</style>