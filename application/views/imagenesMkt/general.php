
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
                    <li class="active">Categoria <?=$categoria[0]->nombre?></li>
                </ol>
            </div>
        </div>
            <hr /> 
</section>
<section class="page-section">
	<div class="container justify-content-center">
        <div class="row">
        	<?php
				if($ListaImagenesGeneral){foreach ($ListaImagenesGeneral->result() as $row){

        	?>

        	<div class="col-md-3" style="width: 28rem; margin: 0 2% 0;" onclick="abrirModalImagen('<?=$row->img_link?>')">
			  <img class="img-fluid efect" src="<?php echo base_url()."assets/img/imagenesMkt/imagenes/".$row->img_link?>">
			</div>
				
			<?php

				} /*! foreach */
			}
			?>
		</div>
	</div>
	<div class="modal " id="modalImgMkt" role="dialog" >
				  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        
				        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
				          <i class="fa fa-times"></i>
				        </button>
				        <div>
				        
				        <a id="downloadImg" href="" download="ImagenMkt" style="cursor: pointer; margin-left: 10px; color: white;"><i class="fa fa-download fa-2x" aria-hidden="true"></i></a>
				    </div>
				      </div>
				     <div class="modal-body text-center">
				      <div id="imgModalImgMkt" style="color: black;  position: relative; width: 768px !important;">
				       <img id="ImagenMkt" class="img-fluid" src="">
				 
				      </div>
				      </div>
				    </div>
				  </div>
				</div>  
</section>

<script type="text/javascript" src="<?= site_url('assets/js/jquery-1.12.3.min.js'); ?>"></script>
<script type="text/javascript" src="<?= site_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/base64.js"></script>
<script type="text/javascript" src="http://www.nihilogic.dk/labs/canvas2image/canvas2image.js"></script>
<script>
		function abrirModalImagen(img){

			$('#modalImgMkt').modal('show');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
			imagen= document.getElementById("ImagenMkt");
			imagen.src='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
			download= document.getElementById("downloadImg");
			download.href='<?php echo base_url()?>assets/img/imagenesMkt/imagenes/'+img;
			
	}

	</script>