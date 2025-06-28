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
    <div style="display: flex">
        <div style="flex:1"><h3 class="titulo-secciones">Actividades [Agregar]</h3></div>
        <div style="flex:1;display: flex;justify-content: end">
            
                <a href="./" class="labelResponsivo"><h3>Inicio</h3></a>
                <h3>/</h3>
                <a class="labelResponsivo" href="<?=base_url()?>actividades" title="Actividades"><h3>Actividades</h3></a>
                <h3>/</h3>
                <a class="labelResponsivo" href="<?=base_url()?>actividades/ver/<?=$folioActividad?>" title="Actividades"><h3>Regresar</h3></a>

                                
                
            
        </div>
    </div>
    <hr /> 



		<!--div class="row">
			<div class="col-sm-10 col-md-10">
	    		<font class="tituloSeccione">
                	Actividades
                	<blockquote> Emitir [<?=$infoFolioActividad->tipoActividad?>]</blockquote>
                </font>
			</div>
            <div class="col-sm-2 col-md-2" style="vertical-align:baseline;">
            	<blockquote>
            	<input 
                	type="button" value="Regresar"
                    title="Clic"
                    onclick="window.open('<?=base_url()?>actividades/ver/<?=$folioActividad?>','_self');"
                />
                </blockquote>
            </div>
		</div-->      
        <div class="row">
        	<div class="col-sm-6 col-md-6">
            	<label>&iquest;C&oacute;mo calificas el proceso de Emisi&oacute;n?</label>
                <br />
                <?
					if($infoFolioActividad->satisfaccionEmision == ""){
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
            </div>
			<div class="col-sm-6 col-md-6" align="right">
				<label><strong>Folio:</strong></label>
                <label><strong style="color:#F00;">
				<?=$infoFolioActividad->folioActividad?>
                [<?=($infoFolioActividad->tipoActividadSicas == "ot")?$infoFolioActividad->NumSolicitud:$infoFolioActividad->idSicas?>]
                </strong>
                </label>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<label><strong>Fecha Creaci&oacute;n:
				<?=$infoFolioActividad->fechaCreacion?></strong></label>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<label><strong>Status:
                <?=$this->capsysdre_actividades->Status($infoFolioActividad->Status)?></strong></label>
            </div>
        </div>
        <? if($infoFolioActividad->fechaPromesa != NULL){ ?>
        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<label><strong>Fecha Promesa:
                <?=$infoFolioActividad->fechaPromesa?></strong></label>
            </div>
        </div>
        <? } ?>
        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
				<label><strong>Datos Cliente:
				<?=$infoCliente[0]->NombreCompleto?></strong></label>
                <br />
				<label><strong><?=$infoCliente[0]->EMail1?></strong></label>
                <br />
				<label><strong><?=$infoCliente[0]->Telefono1?></strong></label>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-12 col-md-12" style="font-size:20px;" >
				<label><strong>Informaci&oacute;n Actividad</strong></label>
            </div>
		</div>
        <div class="informacionActivdadDiv">
        <div class="row rowColumn">
        	<div class="col-sm-3 col-md-3">
				<label><strong>Creador:</strong></label>
            </div>
        	<div class="col-sm-10 col-md-10">
                <label><strong><?=$this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioCreacion)?></strong></label>
            </div>
        </div>
        <div class="row rowColumn">
        	<div class="col-sm-3 col-md-3">
				<label><strong>Responsable:</strong></label>
            </div>
        	<div class="col-sm-4 col-md-4">
               <label><strong> <?=$this->capsysdre->NombreUsuarioEmail($infoFolioActividad->usuarioResponsable)?></strong></label>
            </div>
        </div>
        <div class="row rowColumn">
        	<div class="col-sm-3 col-md-3">
            	<label><strong>Actividad:</strong></label>
            </div>
        	<div class="col-sm-4 col-md-4">
				<label><strong><?=$infoFolioActividad->tipoActividad." - ".$infoFolioActividad->subRamoActividad?></strong></label>
            </div>
        </div>
        <div class="row rowColumn">
        	<div class="col-sm-3 col-md-3">
				<label><strong>Concepto:</strong></label>
            </div>
        	<div class="col-sm-10 col-md-10">
            <label><strong><? echo (!empty($infoDocumento))? $infoDocumento[0]->Concepto : "";	?></strong></label>
            </div>
        </div>
        <div class="row rowColumn">
        	<div class="col-sm-12 col-md-12">
				<label><strong>Datos Cotizaci&oacute;n Expr&eacute;s:</strong></label>
            </div>
                        <div class="col-sm-12 col-md-12">
                <label><strong>
                    <?=$infoFolioActividad->datosExpres;?>
                </strong></label>
            </div>
		</div>
    </div>
<!-- Documentos Actividad -->
		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div class="clearfix">
                	<label><strong>Documentos</strong></label>
				</div>
            </div>
        </div>
		<form 
        	class="form-horizontal" role="form"
            id="formActividadVer_AgregaDocumentos" name="formActividadVer_AgregaDocumentos"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarDocumento"
		>
<!-- -->
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<label><strong>Agregar Documentos</strong></label>
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2">
            	<label><strong>Descripcion Archivo</strong></label>
            </div>
        	<div class="col-sm-10 col-md-10">
            	<input id="descripcionArchivo" name="descripcionArchivo" type="text" maxlength="15" style="width:99%;" class="form-control" />
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2">
            	<label><strong>Tipo Img Archivo</strong></label>
            </div>
        	<div class="col-sm-4 col-md-4">
            	<? print($SelectTipoImg); ?>
            </div>
        </div>
        <div class="row">
        	<div class="col-sm-2">
            	<label><strong>Archivo</strong></label>
            </div>
        	<div class="col-sm-4">
            	<input id="DocumentoFiles" name="DocumentoFiles" type="file"  />
            </div>
            <div class="col-sm-4"><input type="submit" value="Guardar Documento" class="btn btn-primary btn-xs contact-item" /></div>
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
				<input type="hidden" name="IDValuePK" id="IDValuePK" value="<?=$infoFolioActividad->idSicas?>" />
                <input type="hidden" name="folioActividad" id="folioActividad" value="<?=$infoFolioActividad->folioActividad?>" />
                
            </div>
		</div>
        </form>
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<label><strong>Documentos Actividad</strong></label>
            </div>
		</div>

        <?
		if($verDocumentosActividad != false){
		foreach($verDocumentosActividad as $documentos){
			if($documentos->Tipo ==1){
		?>
		<div class="row">
			<div class="col-sm-10 col-md-10">
            	<a href="<?=$documentos->Path?>" title="" target="_blank">
					<span class="glyphicon glyphicon-file" aria-hidden="true"></span> <label><strong><?=$documentos->NameShow?></strong></label>
                </a>
            </div>
		</div>        
		<?
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
            action="<?=base_url()?>actividades/agregarEmitir"
		>
                <div class="row">
            
            <?php   if(isset($companias) && count($companias)>0){$opciones='<select onchange="escogerCompania(this.value)" name="selectCompania" class="form-control input-sm"><option value="-1">ESCOGER COMPANIA</option>';
              
                foreach ($companias as $value) {
                    $opciones=$opciones.'<option class="labelResponsivo" value="'.$value->idPromotoria.'">'.$value->Promotoria.'</option>';
                }
                $opciones=$opciones.'</select>';
                echo($opciones);
            } ?>

        </div>
        <div class="row">
        	<div class="col-sm-12 col-md-12">
            	<label><strong>Agregar Comentario Emision</strong></label>
					<textarea name="ComentarioEmision" id="ComentarioEmision">
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
                <input type="submit" class="ocultarObjeto" id="btnEmision" value="Emitir Cotizacion" />
                <?php }else{ ?>
<input type="submit" class="verrObjeto" id="btnEmision" value="Emitir Cotizacion" />
                <?php }?>
            </div>
		</div>
        </form>
<!--* Comentarios Emision -->
                        
		<div class="row">
			<div class="col-sm-12 col-md-12">&nbsp;</div>
		</div>

	</div>            

<?php $this->load->view('footers/footer'); ?>
<style type="text/css">
    .verObjeto{display: table-row;}
    .ocultarObjeto{display: none;}
</style>
<script type="text/javascript">
    function escogerCompania(valor){
        if(valor>0){
         document.getElementById("btnEmision").classList.add('verObjeto');
         document.getElementById("btnEmision").classList.remove('ocultarObjeto');
        }
        else{
 document.getElementById("btnEmision").classList.remove('verObjeto');
         document.getElementById("btnEmision").classList.add('ocultarObjeto');
        
        }
    }

    document.getElementById('DocumentoFiles').classList.add('form-control')
</script>
<style type="text/css">
    .rowColumn{display: flex;border-bottom: solid 1px}
    .rowColumn>div:nth-child(1){flex:1;color: black;}
    .rowColumn>div:nth-child(1) label{text-decoration: underline;}
    .rowColumn>div:nth-child(2){flex:3;}
    .informacionActivdadDiv{display: flex;flex-direction: column;}


    .row>div:nth-child(1){flex:1;color: black;}
    .row>div:nth-child(1) label{text-decoration: underline;}
    
</style>
<style type="text/css" id="estiloParaMovilV3">
@media only screen and (min-device-width: 320px)
{
 
 .linkParaDocumento{font-size: 35px;}
 .glyphicon-file{font-size: 25px;width: 60px}
 .glyphicon{font-size: 50px;width: 60px}
 .linkCorreo{width: 60px;height: 60px;font-size: 25px}
 .linkWhatSapp{width: 60px;height: 60px;font-size: 25px}
 .linkSms{width: 60px;height: 60px;font-size: 25px}
 .cke_editable{font-size:50px}
 label{font-size: 40px}

 .input-sm{font-size: 35px;height: 80px}
.form-control{font-size: 35px;height: 80px}
select.input-sm{font-size: 35px;height: 80px}
  body{width: 1200px}

 .btn {height: 80px;width: 250px;font-size: 50px}
 .fa-lg{height: 60px;width: 60px}
 .btn-default{height: 60px;width: 60px}
 .btn-sm{height: 100px;width: 300px;font-size: 35px}
 .formaNombreForm{font-size: 35px}
 .btnActividadComentariosOperativos{height: 100px;width: 200px;font-size: 35px}
 .manejoActividad{width: 400px;font-size: 25px}
 .contenedoDocumentosNombreDiv{display: flex}
 .cke_editable{font-size: 36px}
 #ComentarioEmision{font-size: 36px}
 textarea{font-size: 36px}


}
</style>
<script type="text/javascript">
     
      
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
          //document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));
        }
        else{document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));} 
    
</script>