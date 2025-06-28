<?php
	$idPersona = $this->tank_auth->get_idPersona();
	$ruta="https://firebasestorage.googleapis.com/v0/b/v3plus-279402.appspot.com/o/revistaCapacita%2F";
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<style type="text/css">
	.container{
		width: 90%;
		float: left;
	}
	.container-iframe {
		width: 100%;
    	height: 600px;
    	border-style: none;
    	/* border: 1px solid darkgray; */
    	box-shadow: 0px 0px 3px 4px rgb(60 38 96 / 18%);
	}
	.container-alert {
		height: 100%;
    	padding: 0px;
    	display: flex;
    	align-items: center;
    	justify-content: center;
	}
	.seg-alert {
		width: 500px;
    	height: 100px;
    	font-size: 18px;
    	display: flex;
    	align-items: center;
    	justify-content: center;
	}
	.seg-alert > h4 {
		margin-bottom: 0px;
    	margin-left: 5px;
	}
	.column-flex-center {
		display: flex;
    	align-items: center;
    	justify-content: center;
	}
	.column-flex-start {
		display: flex;
    	align-items: center;
    	justify-content: flex-start;
	}
	.column-btn-didactico {
	    margin-top: 5px;
	    display: flex;
	    align-items: center;
	    justify-content: center;
	}
	.column-btn-didactico > a {
		font-size: 11px;
	}

  	.width-ajust {
  	  	width: 100%;
  	  	max-width: max-content;
  	}
  	.text-span {
  		font-size: 13px;
    	padding: 0px 15px;
  	}
  	.text-link {
  		color: #2663b1;
  	}
  	.text-link:hover {
  		color: #3e84df;
  		text-decoration: none;
  	}
</style>
<!-- Navbar -->
<body>
	<div class="container">
		<h2 class="mt-4 title-capacita"><i class="fas fa-newspaper"></i> Revistas - Capacita</h2>
		<hr>
		<div class="col-md-12" style="padding-bottom: 15px;display: none;">
			<span class="text-span">Para ver todas las revistas visita la 
				<a href="http://agentecapital.com/Revistas/" class="text-link">página oficial</a>.
			</span>
		</div>
		<div class="col-md-12 column-flex-start">
			<div class="col-md-3 width-ajust">
				<h5 style="font-size: 13px;margin: 0px;">Revistas disponibles:</h5>
			</div>
            <div class="col-md-10 width-ajust">
                <select id="DocSelect" class="form-control">
                	<option value="1">SELECCIONE</option>
                	<? 	if ($revistas != 0) {
                			foreach ($revistas as $val){
    						    $file_path = $ruta.$val->archivo;
								if(file_contents_exist($file_path)){
								   $data_file = json_decode(file_get_contents($file_path), true);
								   $token = $data_file['downloadTokens'];
    						       $url_file = $file_path."?alt=media&token=".$token;
								}else{
									$url_file="";
								} ?>
                		<option value="<?=$url_file?>"><?=$val->tituloGeneral?></option>
                		<?	} } else {	?>
                		<option value="0">NINGUNA</option>
                	<?	} ?>
                </select>
            </div>
		</div>
		<div class="col-md-12" id="VistaDoc" style="padding: 15px;">
			<div class="container-iframe">
				<div class="col-md-12 container-alert">
					<div class="alert alert-primary seg-alert" role="alert">
						<i class="fas fa-info-circle"></i>
  						<h4 class="alert-heading">Seleccione una revista para mostrar aquí.</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$('#DocSelect').change(function() {
			const url = this.value;
			VerDocumento(url);
		})
	})

	function VerDocumento(url) {
		console.log(url);
		if (url == "1") {
			/*$('#VistaDoc').html(`
				<div class="container-iframe">
					<div class="col-md-12 container-alert">
						<div class="alert alert-primary seg-alert" role="alert">
							<i class="fas fa-info-circle"></i>
  							<h4 class="alert-heading">Seleccione una revista para mostrar aquí.</h4>
						</div>
					</div>
				</div>
			`);*/
		
		}
		else if (url != 0) {
			$('#VistaDoc').html(`
				<iframe src="${url}" class="container-iframe"></iframe>
			`);
		}
		else {
			$('#VistaDoc').html(`
				<div class="container-iframe">
					<div class="col-md-12 container-alert">
						<div class="alert alert-warning seg-alert" role="alert">
  							<i class="fas fa-exclamation-circle"></i>
  							<h4 class="alert-heading">No es posible encontrar el documento seleccionado.</h4>
						</div>
					</div>
				</div>
			`);
		}
	}

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
</script>