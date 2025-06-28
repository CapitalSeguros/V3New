<?php
$folioActividad	= $this->uri->segment(3);
?>
<?php
$this->load->view('headers/header');
?>
<!-- Navbar -->
<?php
$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-md-10">
				<font class="tituloSeccione">
					Actividades
					<blockquote>&bull; Emitir [<?= $infoFolioActividad->tipoActividad ?>]</blockquote>
				</font>
			</div>
			<div class="col-sm-2 col-md-2" style="vertical-align:baseline;">
				<blockquote>
					<input
						type="button" value="Regresar"
						title="Clic"
						onclick="window.open('<?= base_url() ?>actividades/ver/<?= $folioActividad ?>','_self');" />
				</blockquote>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-md-6">
				<label>&iquest;C&oacute;mo calificas el proceso de Emisi&oacute;n?</label>
				<br />
				<?
				if ($infoFolioActividad->satisfaccionEmision == "") {
				?>
					<a href="<?= base_url() ?>actividades/calificarActividad?folioActividad=<?= $infoFolioActividad->folioActividad ?>&satisfaccion=bueno&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal" data-original-titletitle="Clic - Para calificar">
						<span class="glyphicon glyphicon-thumbs-up"></span> Bueno
					</a>
					<a href="<?= base_url() ?>actividades/calificarActividad?folioActividad=<?= $infoFolioActividad->folioActividad ?>&satisfaccion=regular&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal" title="Clic - Para calificar">
						<span class="glyphicon glyphicon-record"></span> Regular
					</a>
					<a href="<?= base_url() ?>actividades/calificarActividad?folioActividad=<?= $infoFolioActividad->folioActividad ?>&satisfaccion=malo&tipoActividad=Emision" class='btn btn-primary btn-xs contact-item' data-toggle="modal"
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
			</div>
			<div class="col-sm-6 col-md-6" align="right">
				<strong>Folio:</strong>
				<font style="color:#F00;">
					<?= $infoFolioActividad->folioActividad ?>
					[<?= ($infoFolioActividad->tipoActividadSicas == "ot") ? $infoFolioActividad->NumSolicitud : $infoFolioActividad->idSicas ?>]
				</font>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<strong>Fecha Creaci&oacute;n:</strong>
				<?= $infoFolioActividad->fechaCreacion ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<strong>Status:</strong>
				<?= $this->capsysdre_actividades->Status($infoFolioActividad->Status) ?>
			</div>
		</div>
		<? if ($infoFolioActividad->fechaPromesa != NULL) { ?>
			<div class="row">
				<div class="col-sm-12 col-md-12" align="right">
					<strong>Fecha Promesa:</strong>
					<?= $infoFolioActividad->fechaPromesa ?>
				</div>
			</div>
		<? } ?>
		<div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<strong>Datos Cliente:</strong>
				<?= $infoCliente[0]->NombreCompleto ?>
				<br />
				<?= $infoCliente[0]->EMail1 ?>
				<br />
				<?= $infoCliente[0]->Telefono1 ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12" style="font-size:20px;">
				<strong>Informaci&oacute;n Actividad</strong>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-md-2">
				<strong>Creador:</strong>
			</div>
			<div class="col-sm-10 col-md-10">
				<?= $this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-md-2">
				<strong>Responsable:</strong>
			</div>
			<div class="col-sm-4 col-md-4">
				<?= $this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioResponsable) ?>
			</div>
			<div class="col-sm-2 col-md-2">
				<strong>Actividad:</strong>
			</div>
			<div class="col-sm-4 col-md-4">
				<?= $infoFolioActividad->tipoActividad . " - " . $infoFolioActividad->subRamoActividad ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-md-2">
				<strong>Concepto:</strong>
			</div>
			<div class="col-sm-10 col-md-10">
				<?
				//print_r($infoFolioActividad);
				echo (!empty($infoDocumento)) ? $infoDocumento[0]->Concepto : "";

				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<strong>Datos Cotizaci&oacute;n Expr&eacute;s:</strong>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<blockquote>
					<?= $infoFolioActividad->datosExpres; ?>
				</blockquote>
			</div>
		</div>
		<!-- Documentos Actividad -->
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="clearfix">
					<font class="subTituloSeccione">Documentos</font>
				</div>
			</div>
		</div>
		<form
			class="form-horizontal" role="form"
			id="formActividadVer_AgregaDocumentos" name="formActividadVer_AgregaDocumentos"
			method="post" enctype="multipart/form-data"
			action="<?= base_url() ?>actividades/agregarDocumento">
			<!-- -->
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<strong>Agregar Documentos</strong>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-md-2">
					Descripcion Archivo
				</div>
				<div class="col-sm-10 col-md-10">
					<input
						id="descripcionArchivo" name="descripcionArchivo"
						type="text"
						maxlength="15" style="width:99%;" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 col-md-2">
					Tipo Img Archivo
				</div>
				<div class="col-sm-4 col-md-4">
					<? print($SelectTipoImg); ?>
				</div>
				<div class="col-sm-1 col-md-1">
					Archivo
				</div>
				<div class="col-sm-5 col-md-5">
					<input
						id="DocumentoFiles" name="DocumentoFiles"
						type="file"
						style="width:90%;" />
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<hr />
				</div>
			</div>
			<!-- -->
			<div class="row">
				<div class="col-sm-12 col-md-12" align="right">
					<input type="hidden" name="TypeDestinoCDigital" id="TypeDestinoCDigital" value="DOCUMENT" />
					<input type="hidden" name="IDValuePK" id="IDValuePK" value="<?= $infoFolioActividad->idSicas ?>" />
					<input type="hidden" name="folioActividad" id="folioActividad" value="<?= $infoFolioActividad->folioActividad ?>" />
					<input type="submit" value="Guardar Documento" />
				</div>
			</div>
		</form>
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<strong>Documentos Actividad</strong>
			</div>
		</div>

		<?
		if ($verDocumentosActividad != false) {
			foreach ($verDocumentosActividad->Datos as $documentos) {
				if (isset($documentos->Tipo)) {
					if ($documentos->Tipo != 0) {
		?>
					<div class="row">
						<div class="col-sm-10 col-md-10">
							<a href="<?= $documentos->PathWWW ?>" title="" target="_blank">
								<span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?= $documentos->NameShow ?>
							</a>
						</div>
					</div>
		<?
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

		<!-- Comentarios Emision -->
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="clearfix">
					<font class="subTituloSeccione">Seguimiento</font>
				</div>
			</div>
		</div>
		<form
			class="form-horizontal" role="form"
			id="formActividadVer_AgregaSeguimiento" name="formActividadVer_AgregaSeguimiento"
			method="post" enctype="multipart/form-data"
			action="<?= base_url() ?>actividades/agregarEmitir">
			<div class="row">

				<?php if (isset($companias) && count($companias) > 0) {
					$opciones = '<select onchange="escogerCompania(this.value)" name="selectCompania" class="form-control input-sm"><option value="-1">ESCOGER COMPANIA</option>';

					foreach ($companias as $value) {
						$opciones = $opciones . '<option class="labelResponsivo" value="' . $value->idPromotoria . '">' . $value->Promotoria . '</option>';
					}
					$opciones = $opciones . '</select>';
					echo ($opciones);
				} ?>

			</div>
			<div class="row">
         <div class="col-sm-2"><label><strong>Cruce</strong></label></div>
        <div class="col-sm-4"><input type="checkbox" class="form-control" name="cruce" id="cruce" value="1"></div>
       </div>
        
        <div class="row">
				<div class="col-sm-12 col-md-12">
					<strong>Agregar Comentario Emision</strong>
					<textarea name="ComentarioEmision" id="ComentarioEmision" style="width:100%;">
                    </textarea>
					<?php echo display_ckeditor($ckeditorEmision); ?>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12" align="right">
				<input type="hidden" name="ClaveBit" id="ClaveBit" value="<?=$infoFolioActividad->ClaveBit?>" />
				<input type="hidden" name="Procedencia" id="Procedencia" value="<?=$infoFolioActividad->tipoActividad?> Capsys Web <?=$infoFolioActividad->folioActividad?>" />
                <input type="hidden" name="IDDocto" id="IDDocto" value="<?=$infoFolioActividad->idSicas?>" />
                <input type="hidden" name="folioActividad" id="folioActividad" value="<?=$infoFolioActividad->folioActividad?>" />
                <?php if(count($companias)>0){ ?>
                <input type="submit" class="ocultarObjeto" id="btnEmision" value="Emitir Cotizacion" onclick="verificarDatos(event,this)"/>
                <?php }else{ ?>
<input type="submit" class="verrObjeto" id="btnEmision" value="Emitir Cotizacion" onclick="verificarDatos(event,this)"/>
                <?php }?>
				</div>
			</div>
		</form>
		<!--* Comentarios Emision -->

		<div class="row">
			<div class="col-sm-12 col-md-12">&nbsp;</div>
		</div>

	</div>
</section>
<?php $this->load->view('footers/footer'); ?>
<style type="text/css">
	.verObjeto {
		display: table-row;
	}

	.ocultarObjeto {
		display: none;
	}
</style>
<script type="text/javascript">
	function escogerCompania(valor) {
		if (valor > 0) {
			document.getElementById("btnEmision").classList.add('verObjeto');
			document.getElementById("btnEmision").classList.remove('ocultarObjeto');
		} else {
			document.getElementById("btnEmision").classList.remove('verObjeto');
			document.getElementById("btnEmision").classList.add('ocultarObjeto');

		}
	}
   function verificarDatos(event,objeto)
        {
            event.preventDefault();
            if(!document.getElementById('cruce').checked)
                {
                    let text = "¿Esta seguro que esta emision no es un cruce de cartera?\n 1.Si es asi de  aceptar y prosiga \n 2.Si no cancele y seleccione cruce de cartera";
                    if (confirm(text) == false) 
                    {
                        return false;
                    }
                } 
                document.getElementById('formActividadVer_AgregaSeguimiento').submit()
        }
</script>
