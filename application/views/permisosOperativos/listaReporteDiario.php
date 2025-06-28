<?php 

$tipoDisplay="Resumen Movimientos Operativos (Prospección/Cobranza)";

?>
<table class="table table-striped">
	<thead>
		<tr>
			<th colspan="2" id="titleTableDailyReport" style="background:#fff;color: #000;"><b>Reporte:</b> <?php echo $tipoDisplay;?></th>
		</tr>
		<tr>
			<th>Correos Configurados</th><th><i class="fa fa-cog"></i>&nbsp;Eliminar</th>
		</tr>
	</thead>
	<tbody id="bodyTableReportEmail">
	<? 	if(isset($reportes_asignados)){
			foreach ($reportes_asignados as $item){ ?>
				<tr><td style="text-align: left"><?php echo $item->correo?></td><td style="text-align: center"><a class="btn-delItem" onclick="delItem('<?php echo $item->id?>','<?php echo $item->tipo?>')"><i class="fa fa-times-circle"></i></a></td></tr>
			<?php }
		}else{ ?>
				<tr><td colspan="2"><center><strong>Sin resultados</strong><center></td></tr>
			<?php
		}
	?>
	</tbody>
</table>
