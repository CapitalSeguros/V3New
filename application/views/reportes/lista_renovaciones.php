<div class="panel panel-default" style="border-radius: 8px;">
<div class="panel-body">
    <div class="leyenda">
	<table style="width: 100%">
		<tr>
			<td><span><i class="fa fa-th-list"></i> Nomenclatura - status de polizas:</span></td>
			<td><div class="vigente">VIGENTE</div></td>
			<td><div class="renovada">RENOVADA</div></td>
			<td><div class="norenovada">NO RENOVADA</div></td>
			<td><div class="cancelada">CANCELADA</div></td>
		</tr>
	</table>
</div>
<div style="width:1800;height: 30px;border:solid;overflow:hidden;" id="scrollCabecera">
	
	<table style="width: 1800px" class="table table-responsive">
		<thead style="width: 1800px; background-color:#472380; color:white;">
        	<tr>
				<th>Operaciones</th>
				<th>Tipo</th>
				<th>Poliza</th>
				<th>Renovación</th>
				<th>Hasta</th>
				<th>Status</th>
				<th>Nombre</th>
				<th>Moneda</th>
				<th>Compania</th>
				<th>Sub ramo</th>
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
				<td>11111111111111111111111111111111111111111</td>
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

<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 250px;border:solid;" >
	<table id="tabla" table style="width:1000px;margin-top: -6%;" border="1" class="table table-responsive">
		<thead id="cabeceraTabla" style="width: 1000px;visibility: hidden;">
			<tr>
				<th >Operaciones</th>
				<th >Tipo</th>
				<th >Poliza</th>
				<th >Renovación</th>
				<th >Hasta</th>
				<th >Status</th>
				<th >Nombre</th>
				<th >Moneda</th>
				<th >Compania</th>
				<th >Sub ramo</th>
				<th >Prima total</th>
				<th >Vendedor</th>
				<th >Forma de pago</th>
			</tr>     
		</thead>
		<tbody id="tbodyReporte" style="width: 1000px;">
			<tr  style="visibility: hidden;text-align: right;">
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>            
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>11111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>1111111111111111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
			</tr>
			<?	$rowIndice=1;
				if(isset($TableInfo)){
					foreach($TableInfo as $table){
						$rowIndice=$rowIndice+1;
						if($table->Status_TXT=="Cancelada"){
							$colorFondo="red";
							$color="white";
						} else {
							if($table->Status_TXT=="Vigente"){
								$colorFondo="white";
								$color="#472380";
							} else {
								if($table->Status_TXT=="No Renovada"){
									$colorFondo="yellow";
									$color="#472380";
								} else {
									if($table->Status_TXT=="Renovada"){
										$colorFondo="blue";
										$color="white";
									} else {
										$colorFondo="orange";
										$color="white";
									}
								}
							}
						}
			?>
			<tr id="<?echo $rowIndice?>" style="background-color: <? echo($colorFondo);?>;color:<? echo($color) ?>;border-bottom: 2px solid #472380 " >
            	<td  class="caja2" id="tdDato" >
					<input type="button" value="Ver operaciones"   onmouseover="agregaDetalleSinComentario(<?echo $rowIndice?>,'<? echo $table->ClaveBit?>','<? echo $table->RamosNombre?>','<?echo $table->IDDocto?>','<?echo $table->IDSRamo?>','<?echo $table->Documento?>','<?echo $table->RamosNombre?>','<? echo base_url()?>','<?echo $table->IDCli?>')"  style="width: 120px;height: 100%;">
					<div  id="Caja<?echo $rowIndice?>" class="disco"> </div>
				</td>
				<td class="tdPartidas" id="tdDato"><?= $table->TipoDocto_TXT; ?></td>
				<td class="tdPartidas  tdPartidasClick" id="tdDato" onclick="apareceDetalle(<?= $rowIndice; ?>,'<?= $table->IDDocto; ?>')">
					<?= $table->Documento; ?>
				</td>
					<td class="tdPartidas tdPartidasClick" id="tdDato" onclick="apareceDetalleAnterior(<?= $rowIndice; ?>,'<?= $table->DPosterior; ?>')">
                	<?= $table->DPosterior; ?>
                </td>
				<td ><?= (date("d-m-y",strtotime((string)$table->FHasta))); ?></td>
				<td ><?= $table->Status_TXT; ?></td>
				<td ><?= $table->NombreCompleto; ?></td>
				<!--<td ><?= $table->Concepto; ?></td>-->
				<td ><?= $table->Moneda; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->CiaNombre; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->SRamoAbreviacion; ?></td>            
				<td class="tdPartidas" id="tdDato" align="right">$<?php echo(number_format((double) $table->PrimaTotal,2)); ?></td>
				<td class="tdPartidas" id="tdDato" align="center"><?= $table->VendNombre; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->FPago; ?></td>          
			<?
					} 
				}
			?>
		</tbody>
	</table>       
</div>

							
            </div><!-- panel-body -->
		</div><!-- panel-default -->
 