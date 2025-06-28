<?php
function semaforo($FLimPago){
	$dias=0;
    $Pago=0;
    $fechaFinal=date("d-m-Y");
    $Pago=date("d-m-Y", strtotime((String)$FLimPago));
    $dias=(int)$Pago-(int)$fechaFinal;
   if($dias <= -10){
      return "<span class='badge' style='background-color:red;color:white;'>".$dias."</span>";
    } 
    if($dias > -10 && $dias <= 5){
      return "<span class='badge' style='background-color:orange;color:white;'>".$dias."</span>";
    }
    if($dias >= 10){
     return "<span class='badge' style='background-color:green;color:white;'>".$dias."</span>";
    }
}
?>
<div id="panel">
	<table id="table_id" width="100%" class="table table-hover">
	<thead>
		<tr>
			<th>Documento</th>
			<th>FDesde</th>
			<th>FHasta</th>
			<th>FLimPago</th>
			<th>Vendedor</th>
			<th>Cliente</th>
			<th>Ramo</th>
			<th>Comision</th>
			<th>Prima Neta</th>
			<th>Moneda</th>
			<th>Semaforo</th>
		</tr>
	</thead>
	
	<tbody>
	<?php 
	foreach ($pendientes as $row) {
		$totalComision=0;
		for($i=0;$i<17;$i++){
			$c="Comision".$i;
			$totalComision=$totalComision+$row->$c;
		}
	?>
		<tr>
			<td><?php echo $row->Documento;?></td>
			<td><?php echo date('d-m-Y',strtotime($row->FDesde));?></td>
			<td><?php echo date('d-m-Y',strtotime($row->FHasta));?></td>
			<td><?php echo date('d-m-Y',strtotime($row->FLimPago));?></td>
			<td><?php echo utf8_encode($row->VendNombre);?></td>
			<td><?php echo utf8_encode($row->NombreCompleto);?></td>
			<td><?php echo $row->SRamoNombre;?></td>
			<td style="text-align: right;"><?php echo number_format($totalComision,2);?></td>
			<td style="text-align: right;"><?php echo $row->PrimaNeta;?></td>
			<td><?php echo $row->Moneda;?></td>
			<td><?php echo semaforo($row->FLimPago);?></td>
		</tr>
	<?php }?>
	</tbody>
	</table>
</div>
