<?php
function semaforo($color,$folio){
	$tag='';
	switch ($color) {
		case 'rojo':
			$tag='<span class="badge" style="background-color: #FA5858;font-weight: normal;">'.$folio.'</span>';
			break;
		case 'amarillo':
			$tag='<span class="badge" style="background-color: #FFBF00;color:#000;font-weight: normal;">'.$folio.'</span>';
			break;
		case 'verde':
			$tag='<span class="badge" style="background-color: #04B404;font-weight: normal;">'.$folio.'</span>';
			break;
		default:
			$tag='<span class="badge" style="background-color: #BDBDBD;color: #000;font-weight: normal;">'.$folio.'</span>';
			break;
	}
	return $tag;
}
function calificacion($valor){
	$tag='';
	switch ($valor) {
		case 'bueno':
			$tag='<i class="fa fa-thumbs-up fa-2x" style="color: ##FFBF00;"></i> Bueno';
			break;
		case 'regular':
			$tag='<i class="fa fa-thumbs-o-up fa-2x"></i> Regular';
			break;
		case 'malo':
			$tag='<i class="fa fa-thumbs-down fa-2x"></i> Malo';
			break;
		default:
			$tag='--';
			break;
	}
	return $tag;
}

?>
<div class="well">
	<div>
		<span style="font-size: 12px;"><i class="fa fa-tag"></i> <b>RAMO:</b> <?php echo $ramo;?></span>
	</div>
	<div style="overflow-y: auto;height: 400px;width: 100%;">
	<table class="table table-hover" style="font-size: 11px;">
	<thead>
		<tr>
			<th>FOLIO</th>
			<th>ACTIVIDAD</th>
			<th>DETALLE DE ACTIVIDAD</th>
			<th style="text-align: center;">SATISFACCIÓN</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($datos as $row) {?>
		<tr>
			<td><?php echo semaforo($row->semaforo,$row->folioActividad);?></td>
			<td><?php echo $row->tipoActividad;?></td>
			<td><?php echo $row->subRamoActividad;?></td>
			<td style="text-align: center;"><?php echo calificacion($row->satisfaccion);?></td>
		</tr>
	<?php
	}	
	?>
	</tbody>
	</table>
	</div>
</div>

