<table style="width:80%;" class="table table-striped table-hover" id="tablaHijos">
	<thead >
	<tr style="background-color: #8370a1;">
		<th colspan="3">Listadode Hijos</th>
		</tr>
	<tr style="background-color: #8370a1;">
		<th>Hijos</th>
		<th style="text-align: center;">Edad</th>
		<th style="text-align: center;"><i class="fa fa-cog"></i></th>
	</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($hijos)){
			$hijos=json_decode($hijos);
			foreach($hijos as $hijo){
				$hijo=explode('|',$hijo);
				$nombre=$hijo[0];
				$edad=$hijo[1];
			?>
				<tr>
					<td><?php echo $nombre?></td>
					<td><?php echo $edad;?></td>
					<td><a href='#' onclick="quitarItem('<?php echo $nombre?>')"><i class="fa fa-times-circle" style="color: red"></i></a></td>
				</tr>
			<?php 
			}
		}else{?>
			<tr>
				<td colspan="3"><div class="alert alert-info">No hay hijos registrados</div></td>
			</tr>
		<?}?>
	</tbody>
</table>