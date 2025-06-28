<?php 
  $this->load->view('headers/header');
  $this->load->view('headers/headerReportes'); 
?>
<?php
  $this->load->view('headers/menu');
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<?= link_tag('assets/css/reportesGenerico.css'); ?>
<script type="text/javascript">
	document.getElementById("ventana-flotante").className = "ocultoInicio";
</script>

	<div id='ventana-flotante'>
		<a 
        	class='cerrar' 
            href='javascript:void(0);' 
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
                    <li class="active"><a>CARTERA</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>
    
	<section class="container-fluid"><!-- container-fluid -->
		<div id="divReporte" ></div>
		<div class="row">
			<form action="<?=base_url();?>produccion/traeDatos" method="POST" class="form">
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fIni">Fecha inicial</label>
						<input type="text" class="datepicker form-control" name="fIni" id="fIni">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fFin">Fecha final</label>
						<input type="text" class="datepicker form-control" name="fFin" id="fFin">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<br />
						<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consulta">Consulta</button>
						<button type="submit" class="btn btn-primary" name="button" id="button" value="Exportar" onclick="descargarExcel('0','Produccion')">Exportar</button>
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
				<div class="form-group">
					<div id="filtro"></div>
					<input type="hidden" id="fechaFinO" name="valim" <?php if(isset($fecFin)){echo ('value="'.$fecFin.'"');}?> >
					<input type="hidden" id="fechaIniO" name="valim" <?php if(isset($fecIni)){echo ('value="'.$fecIni.'"');}?> >
					<input type="text" class="form-control" id="buscar" name="buscar"  placeholder="Escriba algo para filtrar"/>
                    <div style="text-align:right;">
					<button type="button" class="btn btn-primary" value="Aplicar" onclick="buscar()">Aplicar</button>
                    </div>
				</div>
			</div>
			<img  id="imgCarga" style="display: none ;" src="<?php echo base_url(); ?>assets/img/loading.gif" />
		</div><!-- /row -->    
        
		<div class="panel panel-default">
			<div class="panel-body">

<div style="width:1800;height: 30px;border:double;overflow:hidden;" id="scrollCabecera">
	<table style="width: 1800px" >
		<thead style="width: 1800px; background-color:#472380; color:white;">
			<tr>
				<th>Operaciones</th>
				<th>Tipo</th>
				<th>Documento</th>
				<th>Anterior</th>
				<th>Posterior</th>
				<th>Desde</th>
				<th>Hasta</th>
				<th>Status</th>
				<th>Nombre</th>
				<th>Concepto</th>
				<th>Moneda</th>
				<th>Agente</th>
				<th>Compania</th>
				<th>Sub ramo</th>
				<th>Prima neta</th>
				<th>Prima total</th>
				<th>Vendedor</th>
				<th>Forma de pago</th>
			</tr>
		</thead>  
		<tbody style="visibility: hidden">
			<tr>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>            
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>11111111111111111111111111111111111111111</td>
				<td>11111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>1111111111111111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
			</tr>
		</tbody>
	</table> 
</div>

<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 200px;border:double;" >  
	<table id="tabla" table style="width:1000px" border="1" >
		<thead id="cabeceraTabla" style="width: 1000px;visibility: hidden;">
			<tr>
				<th>Operaciones</th>
				<th>Tipo</th>
				<th>Documento</th>
				<th>Anterior</th>
				<th>Posterior</th>
				<th>Desde</th>
				<th>Hasta</th>
				<th>Status</th>
				<th>Nombre</th>
				<th>Concepto</th>
				<th>Moneda</th>
				<th>Agente</th>
				<th>Compania</th>
				<th>Sub ramo</th>
				<th>Prima neta</th>
				<th>Prima total</th>
				<th>Vendedor</th>
				<th>Forma de pago</th>
			</tr>     
		</thead>
		<tbody id="tbodyReporte" style="width: 1000px;">
			<tr style="visibility: hidden;text-align: right;">
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>            
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>11111111111111111111111111111111111111111</td>
				<td>11111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>1111111111111111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
			</tr>
		<?
        $rowIndice=1;
        if(isset($TableInfo)){
			foreach($TableInfo as $table){
				$rowIndice=$rowIndice+1;
		?>
			<tr id="<?echo $rowIndice?>">
            	<td class="caja2" id="tdDato">
                	<input 
                    	type="button" 
                        value="Ver operaciones"
                        style="width: 120px;height: 100%;"
                        onmouseover="agregaDetalleSinComentario(<?= $rowIndice; ?>,'<?= $table->ClaveBit; ?>','<?= $table->RamosNombre;?>','<?= $table->IDDocto; ?>','<?= $table->IDSRamo; ?>','<?= $table->Documento; ?>','<?= $table->RamosNombre; ?>','<?= base_url(); ?>','<?= $table->IDCli; ?>')"
                    >
                    <div  id="Caja<?echo $rowIndice?>" class="disco"></div> 
				</td>
				<td class="tdPartidas" id="tdDato"><?= $table->TipoDocto_TXT; ?></td>
				<td class="tdPartidas" id="tdDato" onclick="apareceDetalle(<?= $rowIndice;?>,'<?= $table->IDDocto;?>')"><?= $table->Documento;?></td>
				<td class="tdPartidas" id="tdDato" onclick="apareceDetalleAnterior(<?= $rowIndice;?>,'<?= $table->DAnterior;?>')"><?= $table->DAnterior;?></td>
				<td class="tdPartidas" id="tdDato" onclick="apareceDetalleAnterior(<?= $rowIndice;?>,'<?= $table->DPosterior;?>')"><?= $table->DPosterior;?></td> 
				<td><?= (date("d-m-y",strtotime((string)$table->FDesde))); ?></td>   
				<td><?= (date("d-m-y",strtotime((string)$table->FHasta))); ?></td>
				<td><?= $table->Status_TXT; ?></td>
				<td><?= $table->NombreCompleto; ?></td>
				<td><?= $table->Concepto; ?></td>
				<td><?= $table->Moneda; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->CAgente; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->CiaNombre; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->SRamoAbreviacion; ?></td>            
				<td class="tdPartidas" id="tdDato" align="right">$<?php echo(number_format((double)$table->PrimaNeta,2)); ?></td>
				<td class="tdPartidas" id="tdDato" align="right">$<?php echo(number_format((double)$table->PrimaTotal,2)); ?></td>
				<td style="width: 150px" id="tdDato" align="center"><?= $table->VendNombre; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->FPago; ?></td>
			</tr>
        <?
			}
		}  
        ?>
		</tbody>
	</table> 
</div>
            
            </div><!-- panel-body -->
		</div><!-- panel-default -->

	<?
	}
	?>   
	</section><!-- /container-fluid -->
    
	<input type="hidden" name="padre" id="padreAnt" >
	<input type="hidden" name="hijo" id="hijoAnt">
	<div id="capaInvisible" style="visibility: hidden;height: 1px"></div>   

<script type="text/javascript">
	function moverScroll(){
		var elmnt = document.getElementById("scrollTabla");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera").scrollLeft=x;
	}
<!-- /*========================================================================================================================================*/ -->
	var direccion="<?php echo base_url()?>produccion/traeArchivos";
	var dirDocAnterior="<?php echo base_url()?>renovaciones/traeArchivosAnteriores";
	var compruebaVariable=0;
	<? if(isset($fecFin)){ ?>
		compruebaVariable=1;
	<? } ?>
</script>
<script src="<?=base_url();?>assets/js/reportesGenericosV2.js"></script>
<?php 
	$this->load->view('footers/footer'); 
?>
<style type="text/css">
	.disco>div{display: flex;flex-wrap: wrap;justify-content: space-between;margin-left: 5px}
	.disco>div>a{color:white;background-color: #5bc0de;border:solid 1px;border-radius: 10%}
	.disco>div>a:hover{background-color: #56d3f8;}
	
</style>