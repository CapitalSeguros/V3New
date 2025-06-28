
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

 <div style="margin-left: 2%;padding-top: 1%;"><h4>Cobranza Efectuada de Fianzas</h4></div>
	<div class="well" style="width: 100;">
		<table style="width: 40%">
			<tr>
				<td><b><i class="fa fa-tag"></i>Total Cobranza Efectuada: </b> <?php echo ($totalEfectuadaPagadoF);?></td>
			</tr>
		</table>	
	</div>

<div>
	 <table class="table table-responsive table-hover" id="table_id_efectuada_fianzas" style="font-size: 10px;width: 100%">
		<thead>
			<tr>
				<th>ID_Recibo</th>
				<th>Documento</th>
				<th>Periodo</th>
				<th>Serie</th>
				<th>Renovacion</th>
				<th>Fecha Desde</th>
				<th>Fecha Hasta</th>
				<th>Fecha Limite Pago</th>
				<th>Fecha Docto</th>
				<th>Status/th>
				<th>Prima Neta</th>
				<th>Grupo</th>
				<th>Sub Grupo</th>
				<th>Vend Nombre</th>
				<th>Nombre Comp.</th>
				<th>Ramo</th>
				<th>Sub Ramo</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$ct=0;
				foreach($efectuadaCobranzaF as $rowCP){
				 	$ct++;
			?>
			<tr>
				<td><?php echo $rowCP->IDRecibo;?></td>
				<td><?php echo $rowCP->Documento;?></td>
				<td><?php echo $rowCP->Periodo;?></td>
				<td><?php echo $rowCP->Serie;?></td>
				<td><?php echo $rowCP->Renovacion;?></td>
				<td><?php echo $rowCP->FDesde;?></td>
				<td><?php echo $rowCP->FHasta;?></td>
				<td><?php echo $rowCP->FLimPago;?></td>
				<td><?php echo $rowCP->Status_TXT;?></td>
				<td><?php echo $rowCP->PrimaNeta;?></td>
				<td><?php echo $rowCP->Grupo;?></td>
				<td><?php echo $rowCP->SubGrupo;?></td>
				<td><?php echo $rowCP->VendNombre;?></td>
				<td><?php echo $rowCP->Nombre_Companía;?></td>
				<td><?php echo $rowCP->RamosNombre;?></td>
				<td><?php echo $rowCP->SRamoNombre;?></td>
			<?php }?>
		</tbody>
	</table>
</div>
<br>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
  $(document).ready( function () {
     $('#table_id_efectuada_fianzas').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
            "previous": "Anterior",
            "next": "Siguiente"
        }
        }
    } );
} );
</script>