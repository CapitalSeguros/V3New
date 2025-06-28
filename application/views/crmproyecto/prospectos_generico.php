<?php
$this->load->model('PersonaModelo');
$hijos=$this->PersonaModelo->devuelveHijosCoordinador($this->tank_auth->get_usermail());
function cambiarEstado($estado){
	if($estado=='DIMENSION'){
		return "SUSPECTO";
	}else{
		return $estado;
	}
}
?>
<!-- seccion registros prospecto persona-->
<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-10 col-sm-10 col-xs-10"><h3 class="titulo-secciones" style="font-size: 18px;">Prospeccion de negocios: Seguimiento de Propectos Genericos</h3></div></div><hr /> 
	</section>
	<div class="row">
		<div class="col-sm-2 col-md-2" ><button class="btn btn-primary btn-sm" onclick="abrir()">Muestra Calendario</button></div>
	</div>
	<br>

	<div class="col-md-3 col-sm-3 col-xs-3">         
    <div class="row">
    <form id="formBuscarCliente" method="GET" action="<?=base_url()?>crmproyecto">
	 <div class="input-group">
	  <input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar entre la lista de Prospectos">
	   <span class="input-group-btn"><button class="btn btn-primary btn-sm" title="Buscar" onclick="buscarCliente(event)"><i class="fa fa-search"></i>&nbsp;</button></span>
	 </div>
	</form>
    </div>
  </div> 
  <div class="col-md-2 col-sm-2 col-xs-2">    
  		<form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes"><button name="ExportaAgentes" id="ExportaAgentes" class="btn btn-primary btn-sm">Exporta Clientes</button></form>
   </div>

   	

<!-- ********* Combo de Hijos *********-->

 <div class="col-md-2 col-sm-2 col-xs-2" style="text-align: right;">      
 	<label><i class="fa fa-filter"></i> Operativos Asignados: </label>
 </div>
   <div class="col-md-3 col-sm-3 col-xs-3">         
    <div class="row">
	 <div class="input-group">
	 <select name="busquedaHijos" id="busquedaHijos" class="form-control" style="font-size: 12px;">
	  	<?php foreach ($hijos as $row ){?>
	  		  	<option value="<?php echo $row->email;?>"><?php echo $row->name_complete;?></option>
	  	<?php }?>
	  </select>
	 </div>
    </div>
  </div> 
   <div class="col-md-1 col-sm-1 col-xs-1" style="text-align: left;">    
  		<button name="buscarhijos" id="buscarhijos" class="btn btn-primary btn-sm" onclick="cargarPaginaHijos('crmproyecto/seguimientoProspectoHijo')">Buscar</button>
   </div>
 <br><br>
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
		        				<option value="PROGRESO">PROGRESO</option>
		        				<option value="COTIZACION">COTIZACION</option>
		        				<option value="VENTA">VENTA</option>
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
												<option value="<?php $row->EstadoActual;?>"><?php echo  cambiarEstado($row->EstadoActual);?></option>
												<option value="PROGRESO">PROGRESO</option>
												<option value="COTIZACION">COTIZACION</option>
												<option value="VENTA">VENTA</option>
											</select>										</td>
										<td style="text-align: left;">
											<button type="button" class="btn btn-sm btn-primary" onclick="actualiza_estado('<?php echo $row->IDCli;?>')">Actualizar
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

</section><!-- /container-fluid -->
<!-- Fin seccion propecto persona-->


