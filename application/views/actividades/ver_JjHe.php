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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li><a href="<?=base_url()?>actividades" title="Actividades">Actividades</a></li>
                <li class="active">Actividades Ver [<?=$infoFolioActividad->tipoActividad?>]</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>

<section class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

        <div class="row">
        	<div class="col-sm-3 col-md-3">
            <!-- 	<label>&iquest;C&oacute;mo calificas el proceso de tu Actividad?</label>
                <br />
                <?
					if($infoFolioActividad->satisfaccion == ""){
				?>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=bueno&tipoActividad=Actividad" 
				class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-titletitle="Clic - Para calificar">
                	<span class="glyphicon glyphicon-thumbs-up"></span> Bueno
                </a>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=regular&tipoActividad=Actividad" 
				class='btn btn-primary btn-xs contact-item' data-toggle="modal"title="Clic - Para calificar">
					<span class="glyphicon glyphicon-record"></span> Regular
                </a>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=malo&tipoActividad=Actividad" 
				class='btn btn-primary btn-xs contact-item' data-toggle="modal"
				title="Clic - Para calificar">
					<span class="glyphicon glyphicon-thumbs-down"></span> Malo
                </a>
                <?
					} else {
				?>
				    <a>
					<span class="glyphicon glyphicon glyphicon-ok-sign"> </span>Actividad Calificada
					</a>
                <?
					}
				?> -->
            </div>
        	<div class="col-sm-3 col-md-3">
            <!-- 	<?
				if($infoFolioActividadEmi != NULL){
				?>
            		<label>&iquest;C&oacute;mo calificas el proceso de Emisi&oacute;n?</label>
                    <br />
                    <?
						if($infoFolioActividadEmi->satisfaccionEmision == ""){	
					?>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=bueno&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-titletitle="Clic - Para calificar">
                	<span class="glyphicon glyphicon-thumbs-up"></span> Bueno
                </a>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=regular&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal"title="Clic - Para calificar">
					<span class="glyphicon glyphicon-record"></span> Regular
                </a>
				<a href="<?=base_url()?>actividades/calificarActividad?folioActividad=<?=$infoFolioActividad->folioActividad?>&satisfaccion=malo&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal"
				title="Clic - Para calificar">
					<span class="glyphicon glyphicon-thumbs-down"></span> Malo
                </a>
					<?
						} else {
					?>
					<a>
					<span class="glyphicon glyphicon glyphicon-ok-sign"> </span>Emision Calificada
					</a>
                    <?
						}
					?>
                <?
				}
				?> -->
            </div>
           
			<div class="col-sm-6 col-md-6" align="right">
				<strong>Folio:</strong>
                <font style="color:#F00;">
				<?=$infoFolioActividad->folioActividad?>
                [<?=($infoFolioActividad->tipoActividadSicas == "ot")?$infoFolioActividad->NumSolicitud:$infoFolioActividad->idSicas?>]
                </font>
            </div>
        </div>
        <div class="row">
			<div class="form-group col-sm-12 col-md-12" align="right">
            	<label><strong>Fecha Creaci&oacute;n</strong></label>
                <br />
				<?=$infoFolioActividad->fechaCreacion?>
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
            	<label><strong>Fecha Promesa</strong></label>
                <br />
                <?=$infoFolioActividad->fechaPromesa?>
            </div>
        </div>
        <? } ?>
<!-- Datos Cliente -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;">
				<strong>Datos Cliente</strong>
                </label>
			</div>
		</div>
		<a 
        	href="<?=base_url()."directorio/registroDetalle?IDCli=".$infoFolioActividad->idCliente?>" 
			target="_parent" 
			title="Clic - Detalle Cliente"
		>
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
        </a>
<!-- !Datos Cliente -->
        <div class="row">
			<div class="form-group col-sm-12 col-md-12">            	<label style="font-size:20px; text-decoration:underline;">
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
<!-- -->
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
               			<input
                				type="submit" value="Enviar Documento [En Curso]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='5'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="5"
								class="btn btn-primary btn-sm"
                		/>
                		<input
                				type="submit" value="Enviar Documento [Finalizada]"
								onclick="document.formActividadVer_AgregaDocumentos.enviar.value='6'; document.formActividadVer_AgregaDocumentos.submit();"
                    			id="6"
								class="btn btn-primary btn-sm"
                		/>
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
				<? // = $saldo; ?>
            </div>
		</div>
        <?
		if($verDocumentosActividad != false){
			
			$movilNumber	= substr($infoCliente[0]->Telefono1, strpos($infoCliente[0]->Telefono1, ":")+1, strlen($infoCliente[0]->Telefono1));
			if($movilNumber != false ){
				$siTieneNumero = true;
			}else{
				$siTieneNumero = false;
			}
			
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
            <!-- Aqui poner links -->
            <div class="col-sm-2 col-md-2">
            	<?
					if($saldo >= '5.0000' && $siTieneNumero == true){
						$linkSms		= base_url('smsMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
						$linkWhatSapp	= base_url('whatsAppMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
						$linkCorreo		= base_url('mailMasivo?')."paraCorreoUrl=".$infoCliente[0]->EMail1."&textCorreoUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
				?>
    	            <button type="button" class="btn btn-primary" title="Clic - Enviar SMS" onclick="window.open('<?= $linkSms; ?>', '_blank')">
                    	<span class="fa fa-mobile" aria-hidden="true"></span>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-primary" title="Clic - Enviar WhatSapp" onclick="window.open('<?= $linkWhatSapp; ?>', '_blank')">
                    	<span class="fa fa-whatsapp" aria-hidden="true"></span>
                    </button>
                    &nbsp;
    	            <button type="button" class="btn btn-primary" title="Clic - Enviar Correo Electrónico" onclick="window.open('<?= $linkCorreo; ?>', '_blank')">
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
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				&nbsp;
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
            <!-- Aqui poner links -->
            <div class="col-sm-2 col-md-2">
            	<?
					if($saldo >= '5.0000' && $siTieneNumero == true){
						$linkSms		= base_url('smsMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
						$linkWhatSapp	= base_url('whatsAppMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
						$linkCorreo		= base_url('mailMasivo?')."paraCorreoUrl=".$infoCliente[0]->EMail1."&textCorreoUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);;
				?>
    	            <button type="button" class="btn btn-primary" title="Clic - Enviar SMS" onclick="window.open('<?= $linkSms; ?>', '_blank')">
                    	<span class="fa fa-mobile" aria-hidden="true"></span>
                    </button>
                    &nbsp;
                    <button type="button" class="btn btn-primary" title="Clic - Enviar WhatSapp" onclick="window.open('<?= $linkWhatSapp; ?>', '_blank')">
                    	<span class="fa fa-whatsapp" aria-hidden="true"></span>
                    </button>
                    &nbsp;
    	            <button type="button" class="btn btn-primary" title="Clic - Enviar Correo Electrónico" onclick="window.open('<?= $linkCorreo; ?>', '_blank')">
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
                		<input
                			type="submit" value="Enviar Comentario [En Curso]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='5'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="5"
							class="btn btn-primary btn-sm"
                		/>
                		<input
                			type="submit" value="Enviar Comentario [Finalizada]"
							onclick="document.formActividadVer_AgregaSeguimiento.enviar.value='6'; document.formActividadVer_AgregaSeguimiento.submit();"
                    		id="6"
							class="btn btn-primary btn-sm"
                		/>
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

<?php if(isset($permisos['modificarActividad'])){ ?>
        <div class="row" style="border: solid;">
			<div class="form-group col-sm-12 col-md-12">
            	<label style="font-size:20px; text-decoration:underline;"><strong>Manejo</strong></label>
			</div>
			<div class="form-group col-sm-12 col-md-12">
				<div class="row">
           	  <label>Cambiar estado<select class="form-control input-sm" id="selectStatusSicas"> 
                          <?php foreach ($statusActividades as  $value) {if($infoFolioActividad->Status==$value->idStatus){ ?>
                           <option value="<?= $value->idStatus; ?>" selected><?= $value->Nombre; ?></option>
                          <?php }else{ ?>
                           <option value="<?= $value->idStatus; ?>"><?= $value->Nombre; ?></option>
                           <?php }
                           }
                          ?>
           				</select>
           			</label>
           			 <?php   if($infoFolioActividad->tipoActividad == "Endoso" || $infoFolioActividad->tipoActividad == "Cancelacion" ){
           			 	if($infoFolioActividad->captura==1){?>  <label>Captura<input id="cbPasarCaptura" type="checkbox" checked></label>   <?php }
           			 	else {?><label>Captura<input id="cbPasarCaptura" type="checkbox"></label><?php }} ?>
           			 <?php if($infoFolioActividad->tipoActividad=="Emision" || $infoFolioActividad->tipoActividad=="Cotizacion"){ $fechaParaEmision=explode('T',$infoDocumento[0]->FEmision);$fecConvertida=strtotime($infoDocumento[0]->FEmision);?>
           			 	<label>Fecha Emision:<input class="formEnviar fechaPersona" class="fechaPersona"   type="text"  id="fechaEmision" autocomplete="off" value="<?=date('d',$fecConvertida).'/'.date('m',$fecConvertida).'/'.date('Y',$fecConvertida); ?>"></label>
           			 <?php } ?>
           		 <?php if($infoFolioActividad->tipoActividadSicas == "ot"){?>
           	<label>Concepto<input type="text" class="form-control input-sm" id="textConceptoSicas" style="width:300px" value="<?=$infoDocumento[0]->Concepto?>"></label><br>
           	       <?php } ?>
           	      </div>
           	      <div class="row">
           	     <input type="text" class="form-control input-sm" name="textComentario" id="textComentario" placeholder="agregar comentario">
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
            	<label style="font-size:20px; text-decoration:underline;"><strong>Calificacion</strong></label>
			</div>
			<div><?= imprimirCalificaciones($calificaciones); ?></div>
			<div><button class="btn btn-primary btn-sm" onclick="guardarCalificacion('<?=$folioActividad;?>',<?=$infoFolioActividad->IDVend;?>,'<?=$infoFolioActividad->tipoActividad;?>')">Guardar</button></div>
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
         <label>
            Tipo de pago aplicación
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipoPago; ?>" />
            </label>
			<label>
            Banco
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaBanco; ?>" />
            </label>
			<label>
            Tipo tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTipo; ?>" />
            </label>
			<label>
			Titular de la tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaTitular; ?>" />
            </label>
		</div>
		<div  class="form-group col-sm-12 col-md-12">
			<label>
			Número de tarjeta
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaNumero; ?>" />
            </label>
			<label>
			Vencimiento
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaMes; ?>" />
            </label>
			<label>
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaYear; ?>" />
            </label>
			<label>
			Código de Seguridad 
            <input type="text" class="form-control input-sm" value="<?= $infoFolioActividad->tarjetaCcv; ?>" />
            </label>
		</div>
	</div>




<? } ?>




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
<!--* Comentarios Actividad -->
                        
		<div class="row">
			<div class="form-group col-sm-12 col-md-12">&nbsp;</div>
		</div>

	</div>            
    </div>
</section>
<?php $this->load->view('footers/footer'); ?><script >
var evento=CKEDITOR.instances['Comentario'];evento.on('afterPaste', function (event) {evento.setData('');});

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
function actualizarDatosEnSicas(folioActividad,IDDocto,tipoActividadSicas,ClaveBit){
	if(document.getElementById('textConceptoSicas')){
	crearObjetosParaForm(document.getElementById('textConceptoSicas').value,"Concepto");}
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
     enviarFormGenerales('actividades/modificarActividad');

}
function guardarCalificacion(folioActividad,IDVend,tipoActividad){
	objetosForm=document.getElementsByClassName('tdCalificacion');objetos="";cant=objetosForm.length;cadena="";
  for(var i=0;i<cant;i++)
  {
    cadena=cadena+objetosForm[i].getAttribute('idCalificacion')+"-"+objetosForm[i].getAttribute('calificacion')+";"; 
  }
 	crearObjetosParaForm(cadena,"calificaciones");
    crearObjetosParaForm(folioActividad,"folioActividad");
    crearObjetosParaForm(IDVend,"IDVend",0);
     crearObjetosParaForm(tipoActividad,"tipoActividad");
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
</script>
<?php
function imprimirAgregarCompania($datos,$folioActividad,$IDSRamo,$tipoActividad){			
		$option='<select id="selectAgregarCompania"><option id="-1">Escoger compania</option>';
		foreach ($datos as $value) {
			 $option.='<option value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
			}	
		$option.='</select><button onclick="agregarCompania('.$IDSRamo.',\''.$folioActividad.'\',\''.$tipoActividad.'\')">Agregar compania</button>';
		return $option;
}
function imprimirCalificaciones($datos){
	$tabla='<table border="1">';
	foreach ($datos as  $value) {
		$tabla=$tabla.'<tr>';
		$tabla=$tabla.'<td>'.$value->calificacionAgente.'</td>';
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
		$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="if(!this.value.length)return false; this.form.submit();"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td>$<input type="text" style="text-align:right" data-idRelActividadPromotoria="'.$value->idRelActividadPromotoria.'" class="idRelActividadPromotoria" value="'.$value->montoRAP.'"></td></tr>';
		$band=$value->folioActividad;}
	else{
$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="alert(\'Para Agregar el archivo hay que poner  el monto\')"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td>$<input type="text" style="text-align:right" data-idRelActividadPromotoria="'.$value->idRelActividadPromotoria.'" class="idRelActividadPromotoria" value="'.$value->montoRAP.'"></td></tr>';$band=$value->folioActividad;
	   }
	  }
	  else{
	  		$file=$file.'<tr><td><form action="'.base_url().'actividades/agregarDocumentoPromotoria" method="post" enctype="multipart/form-data"><label>'.$value->Promotoria.$enviado.'<input type="file"  name="DocumentoFiles" onchange="if(!this.value.length)return false; this.form.submit();"></label><input type="hidden" name="folioActividad" value="'.$folioActividad.'"><input type="hidden" name="TypeDestinoCDigital" value="'.$TypeDestinoCDigital.'"><input type="hidden" name="IDValuePK" value="'.$idSicas.'"><input type="hidden" name="Promotoria" value="'.$value->Promotoria.'"><input type="hidden" name="idRelActividadPromotoria" value="'.$value->idRelActividadPromotoria.'"><input type="hidden" name="FolderDestino" value="'.$FolderDestino.'"></form></td><td></td></tr>';
	
	  }
	}
	if($band!=""){
		$file.='<tr><td></td><td><button onclick="guardarMontoAseguradora(\''.$band.'\')">Guardar monto de cotizaciones</button>';
	}
	$file.="</table>";

   return $file;
}
function imprimirDatosAdicionales($datos){
	$informacion='<table border="1">';
if(count($datos)>0){
$informacion.='<tr><td>Preferencia de comunicacion</td><td>'.$datos[0]->preferenciaComunicacion.'</td></tr><br>';
$informacion.='<tr><td>Horarion de comunicacion</td><td>'.$datos[0]->horarioComunicacion.'</td></tr><br>';
$informacion.='<tr><td>Dia de comunicacion</td><td>'.$datos[0]->diaComunicacion.'</td></tr><br>';
$informacion.='<tr><td>Telefono</td><td>'.$datos[0]->Telefono1.'</td></tr><br>';
$informacion.='<tr><td>Email</td><td>'.$datos[0]->EMail1.'</td></tr><br>';
}else{
$informacion.='<tr><td>Preferencia de comunicacion</td><td></td></tr><br>';
$informacion.='<tr><td>Horarion de comunicacion</td><td></td></tr><br>';
$informacion.='<tr><td>Dia de comunicacion</td><td></td></tr><br>';
$informacion.='<tr><td>Telefono</td><td></td></tr><br>';
$informacion.='<tr><td>Email</td><td></td></tr><br>';	
}
$informacion.="</table>";
	return $informacion;
}

?>
<style type="text/css">
    .estrellaNoChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starVacia.png' ?>) }
    .estrellaChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starLlena.png' ?>) }

</style>