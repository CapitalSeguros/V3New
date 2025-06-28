<?php $estado=$_REQUEST['estado'];
$totalResultados=0;?>
<p>
 <div id="pantalla">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive divContTabla">
				 <table width="100%" border="1">
					<tr>
		        		<td colspan="7" width="72%"></td>
		        		<td style="text-align: center;" width="10%">
		        			<select id="txtEstadoActual" name="txtEstadoActual" style="font-size: 12px;" onchange="seleccionarEstadoActual(this)">
		        				<option value="SUSPECTO">SUSPECTO</option>
		        				<option value="PROGRESO">EN PROGRESO</option>
		        				<option value="COTIZACION">EN COTIZACION</option>
		        				<option value="VENTA">CON VENTA</option>
		        			</select>
		        		</td>
		        		<td width="20%">&nbsp;</td>
	        		</tr>
	        	</table>
    	        <table class="tableP100 table table-condensed table-hover" id='Mitabla'>

        	        	<thead>
							<tr style="font-size: 11px;">
								<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
								<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
								<th style="text-align: center;"><i class="fa fa-calendar"></i></th>
								<th>RazonSocial</th>	
								<th>ApellidoP</th>                        
								<th>Nombre</th>
								<th>Telefono</th>
								<th>Estado Actual</th>
								<th style="text-align: center;" colspan="2"><i class="fa fa-cogs"></i>
							</tr>
            	    	</thead>
                		<tbody>   
                			<? if($ListaClientes != FALSE){
                         	foreach ($ListaClientes as $row){								
                         		if($row->tipo_prospecto==1){ $totalResultados++;?>
									<tr>
										<td style="text-align: center;">
										<?php $fecha=date("Y-m-d", strtotime($row->fechaCreacionCA));?>
										<a href="#" onclick="verDetalle(this,'<?=$row->RFC?>','<?=$row->RazonSocial?>','<?=$row->Nombre?>','<?=$row->ApellidoP?>','<?=$row->ApellidoM?>','<?=$row->EMail1?>','<?=$row->Telefono1?>','<?php echo $fecha;?>','<?=$row->EstadoActual;?>','<?=$row->observacion;?>')"><i class="fa fa-eye"></i></a>
										</td>
										<td style="text-align: center;"><input type="checkbox" class="cbReasignar" value="<?=$row->IDCli?>"></button></td> 
										<td><?php if($row->fechaCreacionCA!=null){echo(date("Y-m-d", strtotime($row->fechaCreacionCA)));} ?>
										</td>
										<td><?=$row->RazonSocial?></td>
										<td><?=$row->ApellidoP?></td>
										<td><?=$row->Nombre?></td>
										<td><?=$row->Telefono1?></td>
										<td>
											<select name="estado" id="estado" style="font-size: 12px;">
												<option value="<?php echo $row->EstadoActual;?>"><?php echo $row->EstadoActual;?></option>
												<option value="PROGRESO">EN PROGRESO</option>
												<option value="COTIZACION">EN COTIZACION</option>
												<option value="VENTA">CON VENTA</option>
											</select>
										</td>
										<td style="text-align: left;">
											<button class="btn btn-sm btn-primary" onclick="actualiza_estado('<?php echo $row->IDCli;?>')">Actualizar
											</button>
										</td>
									</tr>
								<?php }
							}
						}?>
								
						</tbody>
						<?
							if($totalResultados == 0){
						?>
						<tfoot>
							<tr>
								<td colspan="13"><center><b>No se encontraron registros.</b></center></td>
							</tr>
						</tfoot>
						<?
							}

						?>
					</table>
				</div><!-- /table-responsive -->
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->
</div><!-- panel pantalla-->
</p>
