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
                    <li><a href="<?=base_url()."imagenesMkt/areas?idCategoria=".$idCategoria?>">Areas</a></li>
                    <li><a href="<?=base_url()."imagenesMkt/subcategoria?idCategoria=".$idCategoria."&idArea=".$idArea?>">Subcategorias</a></li>
                    <li class="active">Categoria <?=$categoria[0]->nombre?></li>
                </ol>
            </div>
        </div>
            <hr/> 
</section>
<section class="page-section" >
	<div class="container ">

        <div class="row justify-content-center">
        	<?php
				if($ListaImagenesCategoria){foreach ($ListaImagenesCategoria->result() as $row){

        	?>

        	<div class="col-md-3" style="width: 28rem; margin: 0 2% 2%;" onclick="abrirModalImagen(<?=$categoria[0]->idCategoria?>,'<?=$row->img_link?>', '<?=$row->logo?>', '<?=$row->logoside?>', <?=$row->idSubcategoria?>)">
			  <img class="img-fluid efect" src="<?php echo base_url()."assets/img/imagenesMkt/imagenes/".$row->img_link?>">
			</div>
				
			<?php

				} /*! foreach */
			}
			?>
		</div></div>
        

	<?php 
		$Nombres = $nombrePersona[0]->nombres;
		$NombresSeparados = explode(" ", $Nombres);
		$PrimerNombre=$NombresSeparados[0]; 

	?>

		<div class="modal " id="modalImagenEditable" role="dialog" style="overflow-y: auto;">
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        <a onclick="ModificarImg()" style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
				        <a onclick="downloadImagenes('imgModalEditable', 'perfil<?=ucfirst(strtolower($PrimerNombre))?>.png');" style="cursor: pointer; margin-left: 10px;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalEditable" style="color: black;  position: relative; width: 768px !important;">
				       <img id="imgEditablePresentacion" width="768px" src="">
				       <div id="NombreImg" style="position: absolute; top:141px; left:155px; font-size: 24px; font-family:  Tahoma; width: 205px;"><div><?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($nombrePersona[0]->apellidoPaterno));?></div></div>
				       <div id="CelularImg" style="position: absolute; bottom:118px; left:163px; font-size: 26px; font-family:  Tahoma;"><?=$emailPersona[0]->CelularSMS?></div>
				       <div id="CorreoImg" style="position: absolute; bottom: 80px; left: 85px; font-size: 26px; font-family:  Tahoma;"><?=strtolower($emailPersona[0]->email)?></div>
				      </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="modal " id="modalImagenEditableSeguros" role="dialog" style="overflow-y: auto;">
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        <a onclick="ModificarImg()"style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
				        <a onclick="downloadImagenes('imgModalEditableSeguros', 'seguros.png');" style="cursor: pointer; margin-left: 10px;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalEditableSeguros" style="color: white; position: relative; width: 768px !important;" >
				       <img id="imgEditableSeguros" width="768px"  src="">
				       <img id="imglogo" class="img-fluid" width="220px" style="position: absolute; top:25px; right:10px;" src="">
				       <img id="imglogoizq" class="img-fluid" width="220px" style="position: absolute; top:25px; left:10px;" src="">
				       <div id="NombreImgSeguros" style="position: absolute; bottom:70px; left:30px; font-size: 25px; font-family:  Tahoma;"><i class="fa fa-user" aria-hidden="true"></i> <?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($nombrePersona[0]->apellidoPaterno));?></div>
				       <div id="CelularImgSeguros" style="position: absolute; bottom:70px; right:30px; font-size: 25px; font-family:  Tahoma;"><?php if($emailPersona[0]->CelularSMS!=""){?><i class="fa fa-phone" aria-hidden="true"></i><?}?> <?=$emailPersona[0]->CelularSMS?></div>
				       <div id="CorreoImgSeguros" style="position: absolute; bottom: 35px; left: 30px; font-size: 25px; font-family:  Tahoma;"><?php if($emailPersona[0]->email!=""){?><i class="fa fa-envelope" aria-hidden="true"></i><?}?> <?=strtolower($emailPersona[0]->email)?></div>
				      </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="modal " id="modalImagenEditableSegurosAsesores" role="dialog" style="overflow-y: auto;">
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
				    <div class="modal-content" >
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        <a onclick="ModificarImg()"style="cursor: pointer;"><i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i></a>
				        <a onclick="downloadImagenes('imgModalEditableSegurosAsesores', 'segurosAsesores.png');" style="cursor: pointer; margin-left: 10px;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalEditableSegurosAsesores" style="color: white; position: relative; width: 768px !important;" >
				       <img id="imgEditableSegurosAsesores" width="768px"  src="">
				       <img class="img-fluid" width="250px" style="position: absolute; top:20px; left:20px;" src="<?php echo base_url()?>assets/img/imagenesMkt/areas/<?=$Area[0]->img_link_color?>">
				       <div id="NombreImgSegurosAsesores" style="position: absolute; bottom:38px; left:398px; font-size: 20px; font-family:  Tahoma;"><i class="fa fa-user" aria-hidden="true"></i> <?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($nombrePersona[0]->apellidoPaterno));?></div>
				       <div id="CelularImgSegurosAsesores" style="position: absolute; bottom:38px; right:30px; font-size: 20px; font-family:  Tahoma;"><?php if($emailPersona[0]->CelularSMS!=""){?><i class="fa fa-phone" aria-hidden="true"></i><?}?> <?=$emailPersona[0]->CelularSMS?></div>
				       <div id="CorreoImgSegurosAsesores" style="position: absolute; bottom: 10px; left: 398px; font-size: 20px; font-family:  Tahoma;"><?php if($emailPersona[0]->email!=""){?><i class="fa fa-envelope" aria-hidden="true"></i><?}?> <?=strtolower($emailPersona[0]->email)?></div>
				      </div>
				      </div>
				    </div>
				  </div>
				</div>
				<div class="modal " id="modalModificarImg" >
				  <div class="modal-dialog modal-dialog-centered modal-sm"  >
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				      </div>
				      <div class="modal-body">
				     <form class="text-center">
						  <div class="form-group row">
						    <label for="staticEmail" class="col-sm-2 col-form-label" >Nombre</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="nombreNuevo" value="<?=ucfirst(strtolower($PrimerNombre)).' '.ucfirst(strtolower($nombrePersona[0]->apellidoPaterno));?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label">Celular</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="CelularNuevo"  value="<?=$emailPersona[0]->CelularSMS?>">
						    </div>
						  </div>
						  <div class="form-group row">
						    <label for="inputPassword" class="col-sm-2 col-form-label" >Correo</label>
						    <div class="col-sm-10">
						      <input type="email" class="form-control" id="correoNuevo" value="<?=strtolower($emailPersona[0]->email)?>">
						    </div>
						  </div>
						  <button type="button" onclick="cambiosImg()" class="btn btn-primary">Aplicar cambios</button>
						</form>
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
	function abrirModalImagen(idCategoria,img,logo,logoside,idSubcategoria){
		if(idCategoria==1){
			if(idSubcategoria==1){
			$('#modalImagenEditable').modal('show');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			imagen= document.getElementById("imgEditablePresentacion");
			imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
			}else{
				if(idSubcategoria==2 || idSubcategoria==3){
					$('#modalImagenEditableSeguros').modal('show');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					imagen= document.getElementById("imgEditableSeguros");
					imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;

					if(logo==2){
						if(logoside=="izq"){
							logoIzq=document.getElementById("imglogoizq");
							logoIzq.src='<?php echo base_url()?>assets/img/imagenesMkt/areas/<?=$Area[0]->img_link_blanco?>';
						}else{
							logo=document.getElementById("imglogo");
							logo.src='<?php echo base_url()?>assets/img/imagenesMkt/areas/<?=$Area[0]->img_link_blanco?>';
						}
					
					
					}else{
					if(logoside=="izq"){
							logoIzq=document.getElementById("imglogoizq");
							logoIzq.src='<?php echo base_url()?>assets/img/imagenesMkt/areas/<?=$Area[0]->img_link_color?>';
						}else{
							logo=document.getElementById("imglogo");
							logo.src='<?php echo base_url()?>assets/img/imagenesMkt/areas/<?=$Area[0]->img_link_color?>';
						}
					}
				}else{
					if(idSubcategoria==7){
					$('#modalImagenEditableSegurosAsesores').modal('show');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					imagen= document.getElementById("imgEditableSegurosAsesores");
					imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
					}
				}
			}
			
		}else{
			$('#modalImagen').modal('show');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			document.getElementById("imgModal").innerHTML='<img class="img-fluid " src="<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img+'">';
		}
	}

</script>
<script>
	function ModificarImg(){
		$('#modalModificarImg').modal('show');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
	}
	function cambiosImg(){
		if(document.getElementById("nombreNuevo").value!=""){
			document.getElementById("NombreImg").innerHTML=document.getElementById("nombreNuevo").value;
			document.getElementById("NombreImgSeguros").innerHTML='<i class="fa fa-user" aria-hidden="true"></i> '+document.getElementById("nombreNuevo").value;
			document.getElementById("NombreImgSegurosAsesores").innerHTML='<i class="fa fa-user" aria-hidden="true"></i> '+document.getElementById("nombreNuevo").value;
		}
		if(document.getElementById("CelularNuevo").value!=""){
			document.getElementById("CelularImg").innerHTML=document.getElementById("CelularNuevo").value;
			document.getElementById("CelularImgSeguros").innerHTML='<i class="fa fa-phone" aria-hidden="true"></i> '+document.getElementById("CelularNuevo").value;
			document.getElementById("CelularImgSegurosAsesores").innerHTML='<i class="fa fa-phone" aria-hidden="true"></i> '+document.getElementById("CelularNuevo").value;
		}
		if(document.getElementById("correoNuevo").value!=""){
			document.getElementById("CorreoImg").innerHTML=document.getElementById("correoNuevo").value;
			document.getElementById("CorreoImgSeguros").innerHTML='<i class="fa fa-envelope" aria-hidden="true"></i> '+document.getElementById("correoNuevo").value;
			document.getElementById("CorreoImgSegurosAsesores").innerHTML='<i class="fa fa-envelope" aria-hidden="true"></i> '+document.getElementById("correoNuevo").value;

		}
		$('#modalModificarImg').modal('hide');
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

