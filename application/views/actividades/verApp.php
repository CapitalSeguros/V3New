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
<!DOCTYPE html>
<html lang="es">
<script>
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
				<li class="active"><strong>Ver </strong></li>
			</ol>

			<hr />

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!-- Folio Actividad -->
								<div class="col-sm-12 col-md-12" align="left">
									<strong>Folio:</strong>
									<font style="color:#F00;">
										<?=$infoFolioActividad->folioActividad?>
										[<?=($infoFolioActividad->tipoActividadSicas == "ot")?$infoFolioActividad->NumSolicitud:$infoFolioActividad->idSicas?>]
									</font>
								</div>
							</div>
                            
							<div class="row"><!-- Fecha Creacion -->
								<div class="form-group col-sm-12 col-md-12" align="right">
									<label><strong>Fecha Creaci&oacute;n :</strong></label>
									&nbsp;
									<?=$infoFolioActividad->fechaCreacion?>
								</div>
							</div>
                            
							<div class="row"><!--  Status -->
								<div class="form-group col-sm-6 col-md-6" align="left">
								<?
									if($infoFolioActividad->tipoActividad == "Cotizacion" && $infoFolioActividad->fechaEmite == ""  &&  $infoFolioActividad->Status!=6){
								?>
								<input 
									type="button" class="btn btn-primary btn-sm"
									title="Clic" value="Emision"
									onclick="window.open('<?=base_url()?>actividades/emitir/<?=$folioActividad?>','_self');"
								/>
								<?
									} 
								?>
								<br />
								<?	
									if($tomarActividad && $infoFolioActividad->Status == "5"){
								?>
								<input
									type="button" class="btn btn-primary btn-sm"
									title="Clic" value="Tomar Actividad"
									onclick="window.open('<?=base_url()?>actividades/tomaractividad/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
								/>
								<? 
									} else if($tomarActividad && $infoFolioActividad->Status == "3" && $infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()){ 
								?>
								<input 
									type="button" class="btn btn-primary btn-sm"
									title="Clic" value="Soltar Actividad"
									onclick="window.open('<?=base_url()?>actividades/soltaractividad/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
								/>
								<? 
									}
								
									if($viaOficina && $infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()){
								?>
								<input
									type="button" class="btn btn-primary btn-sm"
									title="Clic" value="V&iacute;a Oficina"
									onclick="window.open('<?=base_url()?>actividades/viaoficina/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
								/>
								<? 
									}

									if($cotizada && $infoFolioActividad->usuarioBloqueo == $this->tank_auth->get_usermail()){
								?>
								<input 
									type="button" class="btn btn-primary btn-sm"
									title="Clic" value="Cotizada"
									onclick="window.open('<?=base_url()?>actividades/cotizada/<?=$folioActividad."-".$infoFolioActividad->idSicas?>','_self');"
								/>
								<? 
									}
								?>
								</div>
								<div class="form-group col-sm-6 col-md-6" align="right">
									<label><strong>Status:</strong></label>
									&nbsp;
									<?=$this->capsysdre_actividades->Status($infoFolioActividad->Status)?>
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
            	<label><strong>Fecha Promesa:</strong></label>
                &nbsp;
                <?=$infoFolioActividad->fechaPromesa?>
            </div>
        </div>
        <? } ?>
						</div><!-- /panel-heading -->

						<!-- panel body -->
						<div class="panel-body">
<!-- -->


<!-- Datos Cliente -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;">
				<strong>Datos Cliente</strong>
                </label>
			</div>
		</div>

        <div class="row">
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Entidad</strong></label>
                <br />
				<?=($infoCliente[0]->TipoEnt==0)? "Fisica" : "Moral"?>
			</div>
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Ranking</strong></label>
                <br />
				<?=$infoCliente[0]->Calidad?>
			</div>
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Club Cap</strong></label>
                <br />
				<?=$infoCliente[0]->Expediente?>
			</div>
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Poliza Verde</strong></label>
                <br /> 
                <?=($infoFolioActividad->polizaVerde)? "Si" : "No" ?>
				<?//($infoCliente[0]->ClaveTKM=="POLIZA_VERDE")? "Si" : "No"?>
			</div>
        </div>
        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Nombre Cliente</strong></label>
                <br />
				<?=$infoCliente[0]->NombreCompleto?>
			</div>
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Sexo</strong></label>
                <br />
				<?=($infoCliente[0]->Sexo==0)? "Masculino" : "Femenino"?>
			</div>
			<div class="form-group col-sm-3 col-md-3">
            	<label><strong>Fecha Nacimiento</strong></label>
                <br />
				<?=date_format(date_create($infoCliente[0]->FechaNac),'d/m/Y')?>
			</div>
		</div>
        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Correo</strong></label>
                <br />
				<?=$infoCliente[0]->EMail1?>
			</div>
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Telefono</strong></label>
                <br />
				<?=$infoCliente[0]->Telefono1?>
			</div>
        </div>
<!-- !Datos Cliente -->

<!-- Informacion Actividad -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">            	<label style="font-size:20px; text-decoration:underline;">
				<strong>Informaci&oacute;n Actividad</strong>
                </label>
            </div>
		</div>
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
				<?
					print($this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion));
					print("&nbsp;[".$infoFolioActividad->usuarioCreacion."]");
				?>
			</div>
		</div>
<?
	}
?>
		<div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Vendedor</strong></label>
                <br />
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
            </div>
            <div class="form-group col-sm-6 col-md-6">
            	<label><strong>Autorizado para asesorar</strong></label>
                <br />
                <?
					print($this->capsysdre->CertificacionesVendedor($infoFolioActividad->usuarioVendedor));
				?>
            </div>
        </div>
<?
} else {
?>
        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Creador</strong></label>
                <br />
                <?
                	print($this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion));
                	print("&nbsp;[".$infoFolioActividad->usuarioCreacion."]&nbsp;");
					print("<strong>".$this->capsysdre->RankingUsuarioEmail($infoFolioActividad->usuarioCreacion)."</strong>&nbsp;");
					print("<strong>".$this->capsysdre->ClasificacionVendedor($infoFolioActividad->usuarioCreacion)."</strong>");
				?>
			</div>
            <div class="form-group col-sm-6 col-md-6">
            	<label><strong>Autorizado para asesorar</strong></label>
                <br />
                <?
					print($this->capsysdre->CertificacionesVendedor($infoFolioActividad->usuarioCreacion));
				?>
            </div>
        </div>
<?
}
?>

        <div class="row">
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Responsable</strong></label>
                <br />
               <!-- <?=$this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioResponsable)?>-->
                <?=$infoFolioActividad->usuarioResponsable?>
			</div>
			<div class="form-group col-sm-6 col-md-6">
            	<label><strong>Actividad</strong></label>
                <br />
            	<?
				if($infoFolioActividadEmi != NULL){
				?>
				<?=$infoFolioActividadEmi->tipoActividad." - ".$infoFolioActividadEmi->subRamoActividad?>
                <?="<br />"?>
                <?
				}
				?>
				<?=$infoFolioActividad->tipoActividad." - ".$infoFolioActividad->subRamoActividad?>
			</div>
        </div>
        <?
			if($infoFolioActividad->tipoActividadSicas == "ot"){
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Concepto</strong></label>
                <br />
	            <?=$infoDocumento[0]->Concepto?>
			</div>
        </div>
        <?
			}
		?>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label><strong>Datos Cotizaci&oacute;n Expr&eacute;s</strong></label>
                <br />
            	<?
				if($infoFolioActividadEmi != NULL){
					echo $infoFolioActividadEmi->datosExpres;
					echo "<br />";
				}
				?>
	            	<?=$infoFolioActividad->datosExpres;?>
			</div>            
		</div>

<!-- !Informacion Actividad -->

<!-- Documentos Actividad -->

        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;">
				<strong>Documentos</strong>
                </label>
			</div>
		</div>

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
            	<label style="font-size:16px;">
				<strong>Agregar Documentos</strong>
				</label>
            </div>
		</div>
        
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label>Descripcion Archivo</label>
                <br />
            	<input
                	id="descripcionArchivo" name="descripcionArchivo"
                	type="text" 
                    maxlength="15"
					class="form-control input-sm"
                />
            </div>
		</div>
		<div class="row">
			<div class="form-group col-sm-3 col-md-3">
            	<label>Tipo Img Archivo</label>
                <br />
            	<? print($SelectTipoImg); ?>
			</div>
			<div class="form-group col-sm-9 col-md-9">
            	<label>Archivo</label>
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

                <? if ($this->capsysdre_actividades->Status($infoFolioActividad->Status)!='FINALIZADA')   
                { ?>

                		<input
                			type="submit" value="Enviar Documento"
							onclick="document.formActividadVer_AgregaDocumentos.enviar.value=document.formActividadVer_AgregaDocumentos.oldPosicion.value;
                        	document.formActividadVer_AgregaDocumentos.submit();"
                    		id=""
							class="btn btn-primary btn-sm"
                		/>
                		<?
						if($this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4"){
							?>
                        <br>    
               			<input
                				type="submit" value="Enviar Documento [En Curso]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='5'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="5"
								class="btn btn-primary btn-sm"
                		/>
                        <br>
                		<input
                				type="submit" value="Enviar Documento [Finalizada]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='6'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="6"
								class="btn btn-primary btn-sm"
                		/>
                        <br>
               			 <input
                				type="submit" value="Enviar Documento [Pospuesta]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='7'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="7"
								class="btn btn-primary btn-sm"
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
            </div>
		</div>
        <?
		if($verDocumentosActividad != false){
		if($infoFolioActividad->tipoActividadSicas=="ot"){
			foreach($verDocumentosActividad as $documentos){
				if($documentos->Tipo ==1){
		?>
		<div class="row">
			<div class="col-sm-10 col-md-10">
            	<a href="<?=$documentos->PathWWW?>" title="" target="_blank">
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?=$documentos->NameShow?>
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
		?>
		<div class="row">
			<div class="col-sm-10 col-md-10">
            	<a href="<?=$documentos->PathWWW?>" title="" target="_blank">
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?=$documentos->NameShow?>
                </a>
            </div>
		</div>
		<?
					}
				}
			}
		}
		}
		?>
		<div class="row">
        	<div class="col-sm-12 col-md-12">
            <br />
            </div>
		</div>

<!-- Documentos Actividad -->

<!-- Comentarios Actividad -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;">
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
            	<label style="font-size:16px;">
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
               <?php }else{?><strong>La actividad esta finalizada dudas o aclaraciones comunicares con el Coordinador Operativo o Ejecutivo</strong>  <?} ?>
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
								class="btn btn-primary btn-sm"
                		/>
                	<?
					if($this->tank_auth->get_userprofile() == "3"){
					?>
                		<br>
                        <input
                			type="submit" value="Enviar Comentario [En Curso]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='5'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="5"
							class="btn btn-primary btn-sm"
                		/>
                        <br>
                		<input
                			type="submit" value="Enviar Comentario [Finalizada]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='6'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="6"
							class="btn btn-primary btn-sm"
                		/>
                        <br>
                		<input
                			type="submit" value="Enviar Comentario [Pospuesta]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='7'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="7"
							class="btn btn-primary btn-sm"
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
				<strong>Actividad mala:</strong>
				<label><?=$infoFolioActividad->comentarioActividad?></label>
				</label>
            </div>
		</div>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:16px;">
				<strong>Comentarios Actividad</strong>
				</label>
            </div>
		</div>
        <?
		foreach($verBitacoraActividad as $segumientoBitacoras){
		?>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<?="<strong>(&bull;)".$this->capsysdre_actividades->fechaHoraEspActividades($segumientoBitacoras->FechaHora,'lineal')."</strong>"?>
                <?
					if($segumientoBitacoras->IDUser != 37 && $segumientoBitacoras->Procedencia == ""){
						echo "[";
						echo $segumientoBitacoras->Procedencia;
						echo "]";
						print($segumientoBitacoras->IDUser);
					}
				?>
            </div>
		</div>
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<?=utf8_decode($segumientoBitacoras->Comentario);?>
            	<hr />
            </div>
		</div>        
        <?
		}
		?>
<!-- !Comentarios Actividad -->

<!-- -->
						</div><!-- /panel-body -->
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