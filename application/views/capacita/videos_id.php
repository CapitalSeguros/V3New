<div class="row">
	<?php
		$idPersona = $this->tank_auth->get_idPersona();
		$ruta_imagen="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/imagenVideosCapacita%2F";
		$ruta_video="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/videosCapacita%2F";
		$ruta_documento="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/documentosCapacita%2F";
		foreach ($videos as $recurso){
        	//***Obtener Url Imagen
        		$file_path = $ruta_imagen.$recurso->url_imagen;
				if(file_contents_exist($file_path)){
				   $data_imagen = json_decode(file_get_contents($ruta_imagen.$recurso->url_imagen), true );
				   $token= $data_imagen['downloadTokens'];
        		   $url_imagen=$ruta_imagen.$recurso->url_imagen."?alt=media&token=".$token;
				}else{
					$url_imagen="";
				}

        	//***Obtener Url Video
        		$file_path = $ruta_video.$recurso->url_video;
				if(file_contents_exist($file_path)){
	    			$data_video = json_decode(file_get_contents($ruta_video.$recurso->url_video), true );
	        		$token= $data_video['downloadTokens'];
	        		$url_video=$ruta_video.$recurso->url_video."?alt=media&token=".$token;
    			}else{
    				$url_video="";
    			}

        	//***Obtener Url Documento
    			$file_path = $ruta_documento.$recurso->url_documento;
	    	   if(file_contents_exist($file_path)){
	    			$data_documento = json_decode(file_get_contents($ruta_documento.$recurso->url_documento), true );
	        		$token= $data_documento['downloadTokens'];
	        		$url_documento=$ruta_documento.$recurso->url_documento."?alt=media&token=".$token;
        		}else{
        			$url_documento="";
        		}
        		$num_vistas=0;
        		foreach($contVistas as $contadorV){
        			if($recurso->id==$contadorV->video_id){
        			$num_vistas=$contadorV->vistas;
        			}
        		}
    ?>
		<div class="col-sm-3 col-md-3 col-lg-3" id="Video-<?=$recurso->id?>">
			<div class="card">
			  <img src="<?php echo $url_imagen;?>" width="100%">
			  <div class="card-body" style="font-size: 11px;">
			    <h5 class="card-title"><?php echo strtoupper($recurso->nombre);?></h5>
			    <p class="card-text"><?php echo $recurso->tipoCapacitacion;?>
			    <p class="card-text"><b>Certificación: </b><?php echo $recurso->nombreCertificado;?>
			    <table style="width: 100%;" border="0">
			    	<tr>
			    		<td><a class="btn-megusta" id="Like-<?=$recurso->id?>" data-id="<?=$recurso->id?>" data-category="<?=$recurso->categoria?>" data-like="0" onclick="votar(this)"><i class="far fa-thumbs-up"></i> Me gusta</a></td>
			    		<td><div id="Valor-<?=$recurso->id?>" data-val="<?=$recurso->valoracion?>"><?php echo $recurso->valoracion;?>&nbsp;Valoración</div></td>
			    		<td ><a class="btn-megusta" id="Vistas-<?=$recurso->id?>" data-toggle="modal" data-target="#modalvistas" data-dismiss="modal" onclick='verVistas(<? echo $recurso->id?>, "<?php echo(str_replace('"', '', $recurso->nombre));?>")' ><i class="fas fa-eye"></i>&nbsp;<?php echo $num_vistas;?> Vistas</a>
			    			<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">

			    		</td>
			    		
			    	</tr>
			    </table>
			    <p>
			    	<table style="width: 100%" id="Table-<?=$recurso->id?>">
				    	<tr>
				    		<td>
				    			<a class="btn btn-primary" id="Btn-<?=$recurso->id?>" data-video="<?=$recurso->id?>" data-title="<?=strtoupper($recurso->nombre)?>" data-url="<?=$url_video?>" data-category="<?=$recurso->categoria?>" data-type="1" data-view="0" onclick="vistas(this)"><i class="far fa-eye"></i>&nbsp;Ver Video</a>
				    		</td>
				    		<td style="text-align: right;"> 
				    			<a href="#" class="btn" data-toggle="modal" data-target="#solicitar" style="background-color: #0f84cc;color: #fff;font-size: 11px;" onclick="setTitulo('<?php echo strtoupper($recurso->nombre);?>','<?php echo $recurso->tipoCapacitacion;?>','<?php echo $recurso->nombreCertificado;?>')"><i class="fa fa-paper-plane"></i>&nbsp;Solicitar Evaluación</a>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td style="text-align: left;" colspan="2">
				    			<?php if($url_documento!=""){ ?>
				    			<div class="col-md-12 column-btn-didactico">
				    				<a href="<?php echo $url_documento;?>" class="btn btn-warning" data-id="<?=$recurso->id ?>" data-type="0" onclick="vistas(this)"><i class="fa fa-file"></i>&nbsp;Material Didactico</a>
				    			</div>
				    			<?php }?>
				    		</td>
				    	</tr>
			    	</table>
			    </p>
			    <p id="FechaVista-<?=$recurso->id?>" class="date-video-view">Último acceso: No visto aún</p>
			  </div>
			</div>
		</div>
		<?php }?>
	</div>

<?php 
function file_contents_exist($url, $response_code = 200){
    $headers = get_headers($url);
    if (substr($headers[0], 9, 3) == $response_code){
        return TRUE;
    }else{
        return FALSE;
    }
}
?>

