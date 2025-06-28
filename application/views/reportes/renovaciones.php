<?php 
  $this->load->view('headers/header');
  $this->load->view('headers/headerReportes'); 
?>
<?php
  $this->load->view('headers/menu');
  $this->load->model("personamodelo");
  $coordinadores=$this->personamodelo->devuelveCoordinadoresVentas();
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />

<style type="text/css">

	.leyenda{
		padding: 5px;
		margin-top: -10px;
		margin-bottom: 5px;
		width: 40%;
		height: 30px;
		background-color: #fff;
		border-radius: 8px;
		box-shadow: 2px 2px 2px 1px #000;
	}


	.btn:hover{
		background-color: #DBA901;
		border-color: #DBA901;
	}
</style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<?= link_tag('assets/css/reportesGenerico.css'); ?>
<script type="text/javascript">
  if(document.getElementById("ventana-flotante")){ document.getElementById("ventana-flotante").className = "ocultoInicio";}
</script>

	<div id='ventana-flotante'>
		<a
			class='cerrar' href='javascript:void(0);'
			onclick='document.getElementById(&apos;ventana-flotante&apos;).className = &apos;oculto&apos;'
		>
			x
		</a>
	</div>

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Renovaciones</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
		<div class="row">
			<form action="<?=base_url();?>renovaciones/traeDatos?ac=g" method="POST" class="form">
				<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
				<input type="hidden" name="sw" id="sw" value="<?php if(isset($_REQUEST['ac'])){ echo $_REQUEST['ac'];};?>">
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fIni"><i class="fa fa-calendar"></i> Fecha Inicial</label>
						<input type="text" class="datepicker form-control" name="fIni" id="fIni">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fFin"><i class="fa fa-calendar"></i> Fecha Final</label>
						<input type="text" class="datepicker form-control" name="fFin" id="fFin">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<br />
						<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consulta" style="border-radius: 8px;"><i class="fa fa-search"></i>Consulta</button>
						<!-- Miguel 30/08/2020
						<button type="submit" class="btn btn-primary" name="button" id="button" value="Exportar" onclick="descargarExcel('1','Renovacion')" style="border-radius: 8px;"><i class="fa fa-file-text"></i> Exportar</button>
						-->
					</div>
				</div>
			</form>
		</div><!-- /row -->

	<?
	if(isset($mensaje)){
	?>
       	<script type="text/javascript">
		alert("REQUIERE DE FECHAS PARA LA CONSULTA");
		</script>
	<? 
	} else {
	?>

		<div class="row">
			<div class="col-sm-4 col-md-4">
					<div><label><i class="fa fa-user"></i> Filtro:</label>
					<select class="form-control" onchange="ver_vendedor()">
					<?php 
					foreach ($coordinadores as  $value) {?>
						<option value="<?php echo $value->idPersona;?>">
							<?php echo $value->nombres.' '.$value->apellidoPaterno.' '.'('.$value->email.')'; ?>
						</option>
					<?php } ?> 
					</select>
										
				</div>
			</div>
        	<div class="col-sm-6 col-md-6">
				<div class="form-group">
					<div id="filtro"></div>
					<input type="hidden" id="fechaFinO" name="valim" <?php if(isset($fecFin)){echo ('value="'.$fecFin.'"');}?> >
					<input type="hidden" id="fechaIniO" name="valim" <?php if(isset($fecIni)){echo ('value="'.$fecIni.'"');}?> >
				</div>
		</div>
			<img  id="imgCarga" style="display: none ;" src="<?php echo base_url(); ?>assets/img/loading.gif" />
		</div><!-- /row -->
 <?php }?> 

<br>

<?php $this->load->view('reportes/lista_renovaciones_vigentes');?>
<br>
<?php $this->load->view('reportes/lista_renovaciones_renovadas');?> 
<br>
<?php $this->load->view('reportes/lista_renovaciones_norenovadas');?>
<br>
<?php $this->load->view('reportes/lista_renovaciones_canceladas');?> 
<br>

	</section><!-- /container-fluid -->
    <input type="hidden" name="padre" id="padreAnt" >
	<input type="hidden" name="hijo" id="hijoAnt">	
    <div id="capaInvisible" style="visibility: hidden;height: 1px"></div>

<script type="text/javascript">


	function moverScroll(){
		var elmnt = document.getElementById("scrollTabla");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera").scrollLeft=x;

		var elmnt = document.getElementById("scrollTabla1");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera1").scrollLeft=x;

		var elmnt = document.getElementById("scrollTabla2");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera2").scrollLeft=x;

		var elmnt = document.getElementById("scrollTabla3");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera3").scrollLeft=x;
	}

<!-- /*=================================NECESARIO PARA QUE FUNCION reportesGenericos.js================================*/ -->
	var direccion = "<?php echo base_url()?>renovaciones/traeArchivos?sw=1";
	var dirDocAnterior = "<?php echo base_url()?>renovaciones/traeArchivosAnteriores";
	var compruebaVariable = 0;
	<? if(isset($fecFin)){?>
   		compruebaVariable = 1;
	<? } ?>
</script>


<script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    filename = filename?filename+'.xls':'excel_data.xls';
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
   if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    	downloadLink.download = filename;
        downloadLink.click();
    }
}
</script>

<script src="<?=base_url();?>assets/js/reportesGenericos.js"></script>
<?php 
	$this->load->view('footers/footer'); 
?>
<style type="text/css">
	.tdPartidasClick{border: outset .3em ;}
    .tdPartidasClick:hover {background-color: #361866; cursor: pointer;}
</style>
