<?php
	$perfil=$this->tank_auth->get_userprofile();
?>
<div class="panel panel-default" style="border-radius: 8px;">

<div style="text-align: right;margin-right: 2%;padding-top: 2%;">
<button type="button" class="btn btn-primary" name="button" id="button" onclick="exportTableToExcel('reporte_cancelada')" style="border-radius: 8px;"><i class="fa fa-file-text"></i> Exportar</button>
</div>

<div class="panel-body">
    <div class="leyenda">
	<table style="width: 100%">
		<tr>
			<td><span><i class="fa fa-th-list"></i> Status de polizas: <b>CANCELADAS</b></td>
		</tr>
	</table>
</div>
<div style="width:1800;height: 30px;border:solid;overflow:hidden;" id="scrollCabecera3">
	
	<table style="width: 1800px" class="table table-responsive">
		<thead style="width: 1800px; background-color:#472380; color:white;">
        	<tr>
				<th>Operaciones</th>
				<th>Tipo</th>
				<th>Poliza</th>
				<th>Renovación</th>
				<th>Hasta</th>
				<th>Status</th>
				<?php if($perfil!=1){?>
				<th>Vendedor</th>
				<?php }?>
				<th>Nombre</th>
				<th>Moneda</th>
				<th>Compania</th>
				<th>Sub ramo</th>
				<th>Prima total</th>
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
				<?php if($perfil!=1){?>
				<td>1111111111111111111111111111111111111111111111111111</td>
				<?php }?>
				<td>11111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
			</tr>
		</tbody>
	</table> 
</div>

<div onscroll="moverScroll()" id="scrollTabla3" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 250px;border:solid;" >
	<table id="tabla" table style="width:1000px;margin-top: -6%;" border="1" class="table table-responsive">
		<thead id="cabeceraTabla" style="width: 1000px;visibility: hidden;">
			<tr>
				<th >Operaciones</th>
				<th >Tipo</th>
				<th >Poliza</th>
				<th >Renovación</th>
				<th >Hasta</th>
				<th >Status</th>
				<?php if($perfil!=1){?>
				<th >Vendedor</th>
				<?php }?>
				<th >Nombre</th>
				<th >Moneda</th>
				<th >Compania</th>
				<th >Sub ramo</th>
				<th >Prima total</th>
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
				<?php if($perfil!=1){?>
				<td>1111111111111111111111111111111111111111111111111111</td>
				<?php }?>
				<td>11111111111111111111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
				<td>111111111111111111111111</td>
			</tr>
			<?	$rowIndice=1;
				$i=0;$color="";$mod=0;
				if(isset($TableInfo)){
					foreach($TableInfo as $table){
						if($table->Status_TXT=="Cancelada"){
							$i++;
							$mod=$i%2;
							if($mod==0){$color="#F2F2F2";}else{$color="#E6E6E6";}
									
			?>
			<tr id="<?echo $rowIndice?>" style="border-bottom: 2px;background-color: <?php echo $color;?>" >
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
				<?php if($perfil!=1){?>
				<td class="tdPartidas" id="tdDato" align="left"><?= $table->VendNombre; ?></td>
				<?php }?>
				<td ><?= $table->NombreCompleto; ?></td>
				<!--<td ><?= $table->Concepto; ?></td>-->
				<td ><?= $table->Moneda; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->CiaNombre; ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->SRamoAbreviacion; ?></td>            
				<td class="tdPartidas" id="tdDato" align="right">$<?php echo(number_format((double) $table->PrimaTotal,2)); ?></td>
				<td class="tdPartidas" id="tdDato"><?= $table->FPago; ?></td>          
			<?
					} 
				}
			}
			?>
		</tbody>
	</table>       
</div>
</div><!-- panel-body -->
</div><!-- panel-default -->

<!--Tabla para reporte-->
<?php
if(isset($TableInfo)){?>
<div id="panel_reporte" style="display: none;">
	<table id="reporte_cancelada">
		<thead>
			<tr>
				<th >Operaciones</th>
				<th >Tipo</th>
				<th >Poliza</th>
				<th >Renovación</th>
				<th >Hasta</th>
				<th >Status</th>
				<?php if($perfil!=1){?>
				<th >Vendedor</th>
				<?php }?>
				<th >Nombre</th>
				<th >Moneda</th>
				<th >Compania</th>
				<th >Sub ramo</th>
				<th >Prima total</th>
				<th >Forma de pago</th>
			</tr>     
		</thead>
		<thead>
			<?php
			foreach($TableInfo as $table){
				if($table->Status_TXT=="Cancelada"){?>
			<tr>
				<td><?= $table->TipoDocto_TXT; ?></td>
				<td><?= $table->Documento; ?></td>
				<td><?= $table->DPosterior; ?></td>
				<td><?= (date("d-m-y",strtotime((string)$table->FHasta))); ?></td>
				<td><?= $table->Status_TXT; ?></td>
				<?php if($perfil!=1){?>
				<td><?= $table->VendNombre; ?></td>
				<?php }?>
				<td ><?= $table->NombreCompleto; ?></td>
				<td ><?= $table->Moneda; ?></td>
				<td><?= $table->CiaNombre; ?></td>
				<td><?= $table->SRamoAbreviacion; ?></td>            
				<td>$<?php echo(number_format((double) $table->PrimaTotal,2)); ?></td>
				<td><?= $table->FPago; ?></td>          
			<?php
					} 
				}
}?>
			
		</thead>
	</table>
</div>
<!-- fin tabla de reporte--> 