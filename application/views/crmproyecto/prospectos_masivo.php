
<!-- seccion registros prospecto persona-->

<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-10 col-sm-10 col-xs-10"><h3 class="titulo-secciones" style="font-size: 18px;">Prospeccion de negocios: Seguimiento de Propectos de Importación Masiva</h3></div></div><hr /> 
	</section>
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

   	<div class="col-sm-2 col-md-2" ><button class="btn btn-primary btn-sm" onclick="abrir()">Muestra Calendario</button></div>

   	<!--MOdificacion-->
   	<div class="col-sm-5 col-md-5">
   		<table style="width: 100%;">
   			<tr>
   				<td>
   					Seleccione tipo de Prospecto
   					<select name="tipo_prospecto" id="tipo_prospecto"  style="font-size: 12px;">
						<option value="2">NINGUNO</option>
						<option value="0">PERSONA</option>
						<option value="1">GENERICO</option>
					</select>
				</td>
				<td>
					<button type="button" class="btn btn-sm btn-primary" onclick="actualizarProspectos()">Actualizar</button>
				</td>
   			</tr>
   		</table>
   	</div>

		<br><br>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive divContTabla">
				<input type="hidden" name="base" id="base" value="<?php echo base_url();?>">
    	        <table class="tableP100 table table-condensed table-hover" id='Mitabla'>
        	        	<thead>
							<tr style="font-size: 11px;">
								<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
								<th style="text-align: center;"><i class="fa fa-check"></i></th>
								<th style="text-align: center;"><i class="fa fa-calendar"></i></th>
								<th>RazonSocial</th>	
								<th>ApellidoP</th>                        
								<th>Nombre</th>
								<th>Telefono</th>
								<th>Estado Actual</th>
							</tr>
            	    	</thead>
                		<tbody>   
                			<? if($ListaClientes != FALSE){
                			$ct=0;
                         	foreach ($ListaClientes as $row){								
                         		if($row->tipo_prospecto==2){ $totalResultados++;?>
									<tr>
										<td style="text-align: center;">
										<?php $fecha=date("Y-m-d", strtotime($row->fechaCreacionCA));?>
										<a href="#" onclick="verDetalle(this,'<?=$row->RFC?>','<?=$row->RazonSocial?>','<?=$row->Nombre?>','<?=$row->ApellidoP?>','<?=$row->ApellidoM?>','<?=$row->EMail1?>','<?=$row->Telefono1?>','<?php echo $fecha;?>','<?=$row->EstadoActual;?>','<?=$row->observacion;?>')"><i class="fa fa-eye"></i></a>
										</td>
										<td style="text-align: center;"><input type="checkbox" id="check<?php echo $ct?>" class="cbReasignar" value="<?=$row->IDCli?>"></button></td> 
										<td>
											<?php if($row->fechaCreacionCA!=null){echo(date("Y-m-d", strtotime($row->fechaCreacionCA)));} ?>
										</td>
										<td><?=$row->RazonSocial?></td>
										<td><?=$row->ApellidoP?></td>
										<td><?=$row->Nombre?></td>
										<td><?=$row->Telefono1?></td>
										<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;"><? echo estado($row->EstadoActual);?></span></td>
									</tr>
								<?php 
								$ct++;}
							}
						}?>
						<input type="hidden" id="ct" value="<?php echo $ct;?>">		
						</tbody>
						<?
							if($totalResultados == 0){
						?>
						<tfoot>
							<tr>
								<td colspan="11"><center><b>No se encontraron registros.</b></center></td>
							</tr>
						</tfoot>
						<?
							}

						?>
					</table>
				</div><!-- /table-responsive -->
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-11"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->

	</section><!-- /container-fluid -->
<!-- Fin seccion propecto persona-->

