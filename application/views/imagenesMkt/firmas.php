
<?php 
	$this->load->view('headers/header'); 
?>
<style>
			.efect:hover{
		cursor: pointer;
		transform: scale(1.1);
		transition: 1s;
	}
	.modal-body{
		overflow-x: auto;
		overflow-y: auto;
	}
</style>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->

<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Repositorio de imagenes</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li><a href="./">Inicio</a></li>
                    <li><a href="<?php echo base_url(); ?>imagenesMkt">Repositorio imagenes</a></li>
                    <li><a href="<?=base_url()."imagenesMkt/subcategoriaFirmas?idCategoria=".$idCategoria?>">Subcategorias</a></li>
                    <li class="active">Categoria <?=$categoria[0]->nombre?></li>
                </ol>
            </div>
        </div>
            <hr /> 
</section>
<section class="page-section">
	<div class="container justify-content-center">
        <div class="row ">
        	<?php
				if($ListaImagenesFirma){foreach ($ListaImagenesFirma->result() as $row){
        	?>

        	<div class="col-md-3" style="width: 28rem; margin: 0 2% 2%;" onclick="abrirModalImagenFirma(<?=$categoria[0]->idCategoria?>,'<?=$row->img_link?>',<?=$row->idSubcategoria?>)">
			  <img class="img-fluid efect" src="<?php echo base_url()."assets/img/imagenesMkt/imagenes/".$row->img_link?>">
			</div>
				
			<?php

				} /*! foreach */
			}
			?>
		</div>


			<?php 
		$Nombres = $infoPersona[0]->nombres;
		$NombresSeparados = explode(" ", $Nombres);
		$PrimerNombre=$NombresSeparados[0]; 
		if($NombresSeparados[1]!=""){
			$segundoNombre=$NombresSeparados[1].' ';
		}else{
			$segundoNombre="";
		}
		$telOficina=$infoPersona[0]->telOficina;
		if(strlen($telOficina)!=10){
			$telOficina='999'.$telOficina;
		}
		$idVend=$idValida[0]->IDVend;
		if($idVend==""){
			$idValida="";
		}else{
			$idValida=$idValida[0]->IDValida;
		}

	?>
		<div class="modal " id="modalFirma" role="dialog" >
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        <a onclick="ModificarFirma()" style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
				        <a onclick="downloadImagenes('imgModalFirma', 'Firma<?=ucfirst(strtolower($PrimerNombre))?>.png');" style="cursor: pointer; margin-left: 10px;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalFirma" style="color: black;  position: relative; width: 768px !important;">
				       <img id="imgFirma" width="768px" src="">
				      <div id="NombreImgFirma" style="position: absolute; top:100px; left:90px; font-size: 22px; font-family:  segoe ui; color: #0000A0 !important;" ><?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($segundoNombre)).''.ucfirst(strtolower($infoPersona[0]->apellidoPaterno)).' '.ucfirst(strtolower($infoPersona[0]->apellidoMaterno));?></div>
				       <div id="PuestoImgFirma" style="position: absolute; top:127px; left:90px; font-size: 20px; font-family:  segoe ui;"><?=ucfirst(strtolower($personaPuesto[0]->personaPuesto))?></div>
				       <div id="CelularImgFirma" style="position: absolute; top:155px; left:90px; font-size: 18px; font-family:  segoe ui; text-align: left !important;"><?= $celOficina?>Tel: <?=$telOficina?></div>
				       <div id="QRImgFirma" style="position: absolute; bottom: 15px; right: 15px; font-size: 18px; font-family:  segoe ui;"><img width="80px" src="<?=$linkQR?>"></div>
				      </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="modal " id="modalTarjetaDigital" role="dialog" >
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        <a onclick="ModificarTarjeta()"style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
				        <a onclick="downloadImagenes('imgModalTarjetaDigital', 'TarjetaDigital<?=ucfirst(strtolower($PrimerNombre))?>.png');" style="cursor: pointer; margin-left: 10px;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalTarjetaDigital" style="color: #002f85; position: relative; width: 768px !important;" >
				       <img id="imgTarjetaDigital" width="768px"  src="">
				       
				       <div id="NombreImgTarjetaDigital" style="position: absolute; top:50px; left:60px; font-size: 30px; font-family:  Tahoma;"><?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($segundoNombre)).''.ucfirst(strtolower($infoPersona[0]->apellidoPaterno)).' '.ucfirst(strtolower($infoPersona[0]->apellidoMaterno));?></div>
				       <div id="PuestoImgTarjetaDigital" style="position: absolute; top:90px; left:40px; font-size: 25px; font-family:  segoe ui;"><?=ucfirst(strtolower($personaPuesto[0]->personaPuesto))?></div>
				       <div id="CorreoImgTarjetaDigital" style="position: absolute; top:160px; left:90px; font-size: 20px; font-family:  Tahoma;"><?=strtolower($infoPersona[0]->emailUsers)?></div>
				       <div id="CelularImgTarjetaDigital" style="position: absolute; top:205px; left:90px; font-size: 20px; font-family:  Tahoma;"><?=$telOficina?></div>
				       <div id="CelularImgTarjetaDigital2" style="position: absolute; top:253px; left:90px; font-size: 20px; font-family:  Tahoma;"><?=$infoPersona[0]->celOficina?></div>
				       <div id="CorreoImgTarjetaDigital" style="position: absolute; bottom: 153px; left: 90px; font-size: 20px; font-family:  Tahoma;"><?=$idValida?></div>
				       <div id="QRImgFirma" style="position: absolute; bottom: 45px; right: 85px; font-size: 18px; font-family:  segoe ui;"><img width="240px" src="<?=$linkQR?>"></div>
				      </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="modal " id="modalModificarFirma" >
				  <div class="modal-dialog modal-dialog-centered modal-sm" >
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				      </div>
				      <div class="modal-body">
				     <form class="text-center">
						  <div class="form-group row">
						    <label for="nombreNuevo" class="col-sm-2 col-form-label" >Nombre</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="nombreNuevo" value="<?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($segundoNombre)).''.ucfirst(strtolower($infoPersona[0]->apellidoPaterno)).' '.ucfirst(strtolower($infoPersona[0]->apellidoMaterno));?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="PuestoNuevo" class="col-sm-2 col-form-label">Puesto</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="PuestoNuevo"  value="<?=ucfirst(strtolower($personaPuesto[0]->personaPuesto))?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="CelularNuevo" class="col-sm-2 col-form-label">Celular</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="CelularNuevo"  value="<?=$infoPersona[0]->celOficina?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="TelefonoNuevo" class="col-sm-2 col-form-label">Telefono oficina</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="TelefonoNuevo"  value="<?=$telOficina?>">
						    </div>
						  </div>

						  <button type="button" onclick="cambiosImg('firma')" class="btn btn-primary">Aplicar cambios</button>
						</form>
				      </div>
				    </div>
				  </div>
				</div>

				<div class="modal " id="modalModificarTarjetaDigital" >
				  <div class="modal-dialog modal-dialog-centered modal-sm" >
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				      </div>
				      <div class="modal-body">
				     <form class="text-center">
						  <div class="form-group row">
						    <label for="nombreNuevoTarjeta" class="col-sm-2 col-form-label" >Nombre</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="nombreNuevoTarjeta" value="<?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($segundoNombre)).''.ucfirst(strtolower($infoPersona[0]->apellidoPaterno)).' '.ucfirst(strtolower($infoPersona[0]->apellidoMaterno));?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="PuestoNuevoTarjeta" class="col-sm-2 col-form-label">Puesto</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="PuestoNuevoTarjeta"  value="<?=ucfirst(strtolower($personaPuesto[0]->personaPuesto))?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="TelefonoNuevo" class="col-sm-2 col-form-label">Telefono oficina</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="TelefonoNuevoTarjeta"  value="<?=$telOficina?>">
						    </div>
						    </div>
						  <div class="form-group row">
						    <label for="CelularNuevoTarjeta" class="col-sm-2 col-form-label">Celular</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="CelularNuevoTarjeta"  value="<?=$infoPersona[0]->celOficina?>">
						    </div>
						  </div>
						  <button type="button" onclick="cambiosImg('TarjetaDigital')" class="btn btn-primary">Aplicar cambios</button>
						</form>
				      </div>
				    </div>
				  </div>
				</div>
        
	</div> 
	



</section>

<script type="text/javascript" src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?= site_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/base64.js"></script>
<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>
<script>
	function abrirModalImagenFirma(idCategoria,img,idSubcategoria){
		if(idCategoria==2){
			if(idSubcategoria==4){
			$('#modalFirma').modal('show');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			imagen= document.getElementById("imgFirma");
			imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
			}else{
				if(idSubcategoria==5){
					$('#modalTarjetaDigital').modal('show');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					imagen= document.getElementById("imgTarjetaDigital");
					imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
				}
			}
			
		}else{
		}
	}

		function ModificarFirma(){
		$('#modalModificarFirma').modal('show');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
	}

	function ModificarTarjeta(){
		$('#modalModificarTarjetaDigital').modal('show');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
	}

	function cambiosImg(img){
		if(img=="firma"){
			if(document.getElementById("nombreNuevo").value!=""){
			document.getElementById("NombreImgFirma").innerHTML=document.getElementById("nombreNuevo").value;
		}
		if(document.getElementById("TelefonoNuevo").value!=""){
			document.getElementById("CelularImgFirma").innerHTML="Tel: "+document.getElementById("TelefonoNuevo").value;
		}
		if(document.getElementById("PuestoNuevo").value!=""){
			document.getElementById("PuestoImgFirma").innerHTML=document.getElementById("PuestoNuevo").value;
		}
		
		if(document.getElementById("CelularNuevo").value!=""){
			if(document.getElementById("TelefonoNuevo").value!=""){
				document.getElementById("CelularImgFirma").innerHTML='Cel: '+document.getElementById("CelularNuevo").value+' <i style="color: green !important;" class="fa fa-whatsapp" aria-hidden="true"></i><br>Tel: '+document.getElementById("TelefonoNuevo").value;
			}
		}
		$('#modalModificarFirma').modal('hide');
		}else{
		if(document.getElementById("nombreNuevoTarjeta").value!=""){
			document.getElementById("NombreImgTarjetaDigital").innerHTML=document.getElementById("nombreNuevoTarjeta").value;
		}
		if(document.getElementById("PuestoNuevoTarjeta").value!=""){
			document.getElementById("PuestoImgTarjetaDigital").innerHTML=document.getElementById("PuestoNuevoTarjeta").value;
		}
		if(document.getElementById("CelularNuevoTarjeta").value!=""){
			document.getElementById("CelularImgTarjetaDigital2").innerHTML=document.getElementById("CelularNuevoTarjeta").value;
		}
		if(document.getElementById("TelefonoNuevoTarjeta").value!=""){
			document.getElementById("CelularImgTarjetaDigital").innerHTML=document.getElementById("TelefonoNuevoTarjeta").value;

		}
			$('#modalModificarTarjetaDigital').modal('hide');
		}
		
		
	}

</script>
<script>
	function downloadImagenes(canvasId, filename) {
		html2canvas(document.getElementById(canvasId)).then(function (canvas) {
		var img = canvas.toDataURL('image/png'); //o por 'image/jpeg' 
			//display 64bit imag
			document.write('<a id="downloadImg" href="'+img+'" download="'+filename+'"><a>');
			document.getElementById("downloadImg").click();    
			location.reload();
	});
}
	</script>