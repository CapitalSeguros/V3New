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
<style type="text/css">
	.btn:hover{
		background-color: #DBA901;
		border-color: #DBA901;
	}
	#tabla td{
		width: 25%;
  		min-width: 150px;
	}
</style>

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
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones" style="font-size: 18px;"><i class="fa fa-list"></i> Reportes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Cob. Pendiente</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>
    
	<section class="container-fluid" style="background-color: #e6e6e6;margin: 5px;padding: 10px;border-radius: 8px;"><!-- container-fluid -->
		<div class="row">
			<form action="<?=base_url();?>cobranzaPendiente/traeDatos" method="POST" class="form">
				<div class="col-sm-2 col-md-2">
					<div class="form-group">
						<label for="fIni"><i class="fa fa-calendar"></i> Fecha inicial</label>
						<input type="text" class="form-control" name="fIni" id="fIni">
					</div>
				</div>
				<div class="col-sm-2 col-md-2">
					<div class="form-group">
						<label for="fFin"><i class="fa fa-calendar"></i> Fecha final</label>
						<input type="text" class="form-control" name="fFin" id="fFin">
					</div>
				</div>
				<div class="col-sm-2 col-md-2">
					<div class="form-group">
						<label for="fCorte"><i class="fa fa-calendar"></i> Fecha Corte</label>
						<input type="text" class="datepicker form-control" name="fCorte" id="fCorte">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<br />
						<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consulta" style="border-radius: 8px;"><i class="fa fa-search"></i> Consulta</button>
					<button type="submit" class="btn btn-primary" name="button" id="button" value="Exportar" onclick="exportarExcel()" style="border-radius: 8px;"><i class="fa fa-file-text"></i> Exportar</button>
						

					</div>
				</div>
				<div class="col-md-2"></div>
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
					<button type="button" class="btn btn-primary" value="Aplicar" onclick="buscar()" style="border-radius: 8px;"><i class="fa fa-check"></i> Aplicar</button>
                    </div>
				</div>
			</div>
			<div class="col-sm-4 col-md-4">
				<select class="form-control" name="despacho" id="despacho">
					<?php foreach ($sucursales as $row) {?>
						<option value="<?php echo $row->idDespachoSicas;?>"><?php echo $row->NombreSucursal;?></option>
					<?php } ?>
				</select>
				 <div style="text-align:right;">
					<button type="button" class="btn btn-primary" value="Aplicar" onclick="buscar()" style="border-radius: 8px;"><i class="fa fa-check"></i> Aplicar</button>
                  </div>
			</div>
			<img  id="imgCarga" style="display: none ;" src="<?php echo base_url(); ?>assets/img/loading.gif" />
		</div><!-- /row -->

<?
if(isset($_REQUEST['fCorte'])){?>
	<b>  Fecha de Corte: </b><?= $_REQUEST['fCorte']?>
<?} ?>

<div class="panel panel-default" style="height: 500px;overflow-y: scroll;border-radius: 8px;padding: 10px;">
		<table id="tabla" class="table table-hover table-responsive" border="1">
			<thead>
				<tr>
					<th>TIPO</th>
					<th>DOCUMENTO</th>
					<th>DESDE</th>
					<th>HASTA</th>
					<th>LIM.PAGO</th>
					<th>SEMAFORO</th>
					<th>STATUS</th>
					<th>NOMBRE</th>
					<th>CONCEPTO</th>
					<th>MONEDA</th>
					<th>AGENTE</th>
					<th>COMPAÑIA</th>
					<th>SUB_RAMO</th>
					<th>PRIMA_NETA</th>
					<th>PRIMA_TOTAL</th>
					<th>VENDEDOR</th>
					<th>FORMA_DE_PAGO</th>
					<th>CONDUCTO</th>
				</tr>
			</thead>
			<tbody>
					<?
					function semaforo($fLimite){
						return $fLimite-$_REQUEST['fCorte'];
					}

					$rowIndice=1;
					if(isset($TableInfo)){
						foreach($TableInfo as $table){
							$rowIndice=$rowIndice+1;

					?>
						
						<tr id="<?= $rowIndice; ?>">
							<td id="tdDato"><?= $table->TipoDocto_TXT; ?></td>
							<td onclick="apareceDetalle(<?= $rowIndice; ?>,'<?= $table->IDDocto; ?>')"><?= $table->Documento; ?></td>
							<td><?= (date("d-m-y",strtotime($table->FDesde))); ?></td>    
							<td><?= (date("d-m-y",strtotime($table->FHasta))); ?></td>
							<td><?= (date("d-m-y",strtotime($table->FLimPago))); ?></td>
							<td style="text-align: center;"><?
								$dias=semaforo((date("d-m-y",strtotime($table->FLimPago))));
									if($dias <= -10){ ?>
										<span class="badge badge-danger" style="background-color: red;color: #fff;"><?= $dias?></span>
								<? }if(($dias > -10)&&($dias<=5)){ ?>
										<span class="badge badge-warning" style="background-color: yellow;color: #000;"><?= $dias?></span>
								<? }if($dias>5){ ?>
									    <span class="badge badge-danger" style="background-color: #000;color: #fff;"><?= $dias?></span>
								<?}
								?>
							</td>
							<td><?= $table->Status_TXT; ?></td>
							<td><?= $table->NombreCompleto; ?></td>
							<td><?= $table->Concepto; ?></td>
							<td><?= $table->Moneda; ?></td>
							<td><?= $table->CAgente; ?></td>
							<td><?= $table->CiaNombre; ?></td>
							<td><?= $table->SRamoAbreviacion; ?></td>
							<td align="right">$<?php echo(number_format( $table->PrimaNeta,2)); ?></td>
							<td align="right">$<?php echo(number_format( $table->PrimaTotal,2)); ?></td>
							<td align="center"><?= $table->VendNombre; ?></td>        
							<td><?= $table->FPago; ?></td>
							<td><?= $table->CCobro_TXT; ?></td>
						</tr>
					<?
						}
					?>
			</tbody>
		</table>
<?php } 
}?>


	</section><!-- /container-fluid -->

	<input type="hidden" name="padre" id="padreAnt" >
	<input type="hidden" name="hijo" id="hijoAnt">
	<div id="capaInvisible" style="visibility: hidden;height: 1px"></div>  


<script type="text/javascript">
	function exportarExcel(){
		var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('tabla');
        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        }
        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
        return (sa);
	}
</script>


<script type="text/javascript">
	

	function moverScroll(){
		var elmnt = document.getElementById("scrollTabla");
		var x = elmnt.scrollLeft;
		document.getElementById("scrollCabecera").scrollLeft=x;
	}

<!-- /*=================================NECESARIO PARA QUE FUNCION reportesGenericos.js================================*/ -->
	var direccion="<?php echo base_url()?>produccion/traeArchivos";
	var compruebaVariable=0;
	<? if(isset($fecFin)){ ?>
		compruebaVariable=1;
	<? } ?>
</script>

<script src="<?=base_url();?>assets/js/reportesGenericos.js"></script>
<?php
	$this->load->view('footers/footer'); 
?>


