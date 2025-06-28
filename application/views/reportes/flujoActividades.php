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
                    <li class="active"><a>Flujo Actividades</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
		<div class="row">
			<form action="<?=base_url();?>flujoActividades/consultaDatos" method="POST" class="form">
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
						<button type="submit" class="btn btn-primary" name="button" id="button" value="Exportar" onclick="descargarExcel('0','CobEfe')">Exportar</button>
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
					<div id="filtro" style="display:none"></div>
					<input type="hidden" id="fechaFinO" name="valim" <?php if(isset($fecFin)){echo ('value="'.$fecFin.'"');}?> >
					<input type="hidden" id="fechaIniO" name="valim" <?php if(isset($fecIni)){echo ('value="'.$fecIni.'"');}?> >
					<input type="text" class="form-control" id="buscar" name="buscar"  placeholder="Escriba algo para filtrar" style="display:none"/>
                    <div style="text-align:right;">
					<button type="button" class="btn btn-primary" value="Aplicar" onclick="buscar()" style="display:none">Aplicar</button>
                    </div>
				</div>
			</div>
			<img  id="imgCarga" style="display: none ;" src="<?php echo base_url(); ?>assets/img/loading.gif" />
		</div><!-- /row -->    

		<div class="panel panel-default">
			<div class="panel-body">

<div style="width:1000;height: 30px;border:double;overflow:hidden;" id="scrollCabecera">
	<table style="width: 1800px">
		<thead style="width: 1800px; background-color:#472380; color:white;">
			<tr>
				<th>Estatus</th>
				<th>Folio Actividad</th>
				<th>Sub Ramo Actividad</th>
				<th>Usuario Creacion</th>
				<th>Nombre Usuario Creacion</th>
				<th>FechaCreacion</th>
				<th>Fecha Actualizacion</th>
				<th>Dias Pasados Creacion</th>
				<th>Dias Pasados Actualizacion</th>
				<th>Aseguradoras</th>
			</tr>
		</thead>
		<tbody style="visibility: hidden">  
			<tr>
				<td>111111111111</td>
				<td>1111111111111111</td>
				<td>1111111111111111111111111111</td>
				<td>1111111111111111111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
			</tr>
		</tbody>
	</table>
</div>

<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 200px;border:double;">
	<table id="tabla" table style="width:1000px" border="1">
		<thead id="cabeceraTabla" style="width: 1000px;visibility: hidden;">
			<tr>
				<th>Estatus</th>
				<th>Folio Actividad</th>
				<th>Sub Ramo Actividad</th>
				<th>Usuario Creacion</th>
				<th>Nombre Usuario Creacion</th>
				<th>FechaCreacion</th>
				<th>Fecha Actualizacion</th>
				<th>Dias Pasados Creacion</th>
				<th>Dias Pasados Actualizacion</th>
				<th>Aseguradoras</th>
			</tr>
		</thead>
		<tbody id="tbodyReporte" style="width: 1000px;">
			<tr style="visibility: hidden;text-align: right;" >
				<td>111111111111</td>
				<td>1111111111111111</td>
				<td>1111111111111111111111111111</td>
				<td>1111111111111111111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
				<td>11111111111111111111111111</td>
			</tr>
		<?
        $rowIndice=0;
        if(isset($TableInfo)){
			while($rowIndice < count($TableInfo)){
		?>
        	<tr bgcolor="#CCCCCC">
				<td colspan="10" style="font-size:12px">
                	&nbsp;&nbsp;&nbsp;
                	<strong><?= $TableInfo[$rowIndice]['status']; ?></strong>
				 	<i>Total de Actividades <?= count($TableInfo[$rowIndice]['StatusDatos']); ?></i>
                </td>
			</tr>
        <?
				foreach($TableInfo[$rowIndice]['StatusDatos'] as $table){
					//echo "<pre>";
						//print_r($table['Status_Txt']);
					//echo "</pre>";
		?>

        	<tr id="<?= $rowIndice; ?>">
				<td id="tdDato"><?= $table['Status_Txt']; ?></td>
				<td><?= $table['folioActividad'];?></td>
				<td><?= $table['SubRamoActividad']; ?></td>
				<td><?= $table['usuarioCreacion']; ?></td>
				<td><?= $table['nombreUsuarioCreacion']; ?></td>
				<td><?= (date("d-m-y",strtotime((string)$table['fechaCreacion']))); ?></td>    
				<td><?= (date("d-m-y",strtotime((string)$table['fechaActualizacion']))); ?></td>
				<td><?= $table['diasPasadosCreacion']; ?></td>
				<td><?= $table['diasPasadosActualizacion']; ?></td>
                <td><?= $table['aseguradoras']; ?></td>
			</tr>

        <?
				}
			$rowIndice++;
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
		var elmnt	= document.getElementById("scrollTabla");
		var x		= elmnt.scrollLeft;
		document.getElementById("scrollCabecera").scrollLeft=x;
	}

<!-- /*=================================NECESARIO PARA QUE FUNCION reportesGenericos.js================================*/ -->
	var direccion			= "<?php echo base_url()?>produccion/traeArchivos";
	var compruebaVariable	= 0;
	<? if(isset($fecFin)){ ?>
		compruebaVariable	= 1;
	<? } ?>
</script>

<script src="<?=base_url();?>assets/js/reportesGenericos.js"></script>

<?php
	$this->load->view('footers/footer'); 
?>
<style>
.cellClick{cursor: pointer; color: green}
</style>