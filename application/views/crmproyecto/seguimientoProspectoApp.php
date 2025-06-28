
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
	.tableP100{width: 100%; height: 300px; overflow: scroll;}
	.tableP100 thead {color: white; background-color: #361866 }
	.tableP100 >thead >tr>th {border: solid black;width: 300px}
	.tableP100 >tbody >tr>td {border: solid black 1px; margin:5em; ;width: 300px}
	.divContTabla{height: 400px; width: 100%;overflow: scroll;}
</style>

<? $totalResultados = count($ListaClientes);?>
	
<div class="row">
	<div class="col-lg-6">
		<form id="formBuscarCliente" method="GET" action="<?=base_url()?>crmproyecto">
		<div class="input-group">
	  		<input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control input-sm" placeholder="Buscar entre la lista de Prospectos">
			<span class="input-group-btn">
            	<button class="btn btn-primary btn-sm" title="Buscar" onclick="buscarCliente(event)"><i class="fa fa-search"></i>&nbsp;</button>
            </span>
		</div>
		</form>
    </div>
    <div class="col-lg-2">    
		<form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes">
			<button name="ExportaAgentes" id="ExportaAgentes" class="btn btn-primary">Exporta Clientes</button>
		</form>
    </div>
	<div class="col-lg-2">
		<button class="btn btn-primary" onclick="abrir()">Muestra Calendario</button>
	</div>
</div>
    
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive divContTabla">
        
    	        	<table class="tableP100" id='Mitabla' >
        	        	<thead>
							<tr>
    	                    	<th style="width: 300px">ID</th>
    	                    	<th>Fecha Creacion</th>
    	                    	<th>Comentarios</th>
    	                    	<th>Contacto y Cita</th>
								<th>ApellidoP</th>                        
								<th>ApellidoM</th>			               
								<th>Nombre</th>
								<th>RazonSocial</th>	
								<th>RFC</th>	
								<th>Email1</th>
								<th>Telefono1</th>
								<th>Agregar Archivo</th>
								<th>Ver Archivos</th>
								<th>Perfilado</th>
								<th>Contactado</th>
<!--							<th>Citado</th>		-->
<!--							<th>Cotizado</th>	-->
								<th>Pagado</th>			
							</tr>
            	    	</thead>
                		<tbody>   
                			<tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'HOY')">►</td><td colspan="15">HOY</td></tr>
							<? if($ListaClientes != FALSE){$cont=0;$nombrePestania="";
                         $nombrePestania="HOY";
								foreach ($ListaClientes as $row){									
							if($nombrePestania!=$row->pestania){?><tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'<?= $row->pestania?>')">►</td><td colspan="15"><?= $row->pestania; ?></td></tr> <?}
                             $nombrePestania=$row->pestania;
							?>
							<tr class="<?= $row->pestania;?> ocultarObjeto">
								<td><input type="checkbox" class="cbReasignar" value="<?=$row->IDCli?>"></button></td> 
								<td><?php if($row->fechaCreacionCA!=null){echo(date("Y/m/d", strtotime($row->fechaCreacionCA)));} ?></td>
								<td><button onclick="direccionAJAX(<?=$row->IDCli?>,'muestraVentana')" class="btn btn-primary btn-xs ">Comentarios</button></td>
								<td><button onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')" class="btn btn-primary btn-xs">Contacto y Cita</button></td>
								<td><?=$row->ApellidoP?></td>
								<td><?=$row->ApellidoM?></td>
								<td><?=$row->Nombre?></td>
								<td><?=$row->RazonSocial?></td>
								<td><?=$row->RFC?></td>
								<td><?=$row->EMail1?></td>
								<td><?=$row->Telefono1?></td>
								<td><label for="<?echo('Archivo'.$row->IDCli);?>" class="btn btn-primary btn-xs ">Enviar Archivo</label>
                                <input  id="<?echo('Archivo'.$row->IDCli);?>"  type="file" onchange="if(!this.value.length)return false; enviarArchivo(this);" style="opacity: 0; width: 5px">
                                    
								</td>
								<td><button class="btn btn-primary btn-xs contact-item" onclick="verDocumentos(<? echo($row->IDCli);?>)">Ver Archivos</button></td>
								<td>
    	                        	<?
										$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '".$row->IDCli."'";
										$queryEstaPerfilado=$this->db->query($sqlEstaPerfilado);
										if(!empty($queryEstaPerfilado)){foreach ($queryEstaPerfilado->result() as $Registro) {$estaperfilado=$Registro->numero; }}
										if($estaperfilado>0){ echo "Perfilado"; } 
										else {
                            		?>         
	                            	<!--a href="<?= base_url()?>crmproyecto/InsertaPerfilado?IDCL=<?= $row->IDCli?>" class="btn btn-primary btn-xs contact-item" data-toggle="modal" data-original-title><span class="glyphicon glyphicon-pencil" ></span>Perfilar
									</a-->
									<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,<?=$row->IDCli?>)">Perfilar</button>
                            		<? } ?> 
								</td>

								<td>
    	                        	<?
										$sqlEstaCotizado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'";
										$queryEstaCotizado = $this->db->query($sqlEstaCotizado);
										if(!empty($queryEstaCotizado)){foreach ($queryEstaCotizado->result() as $Registro){$estacotizado=$Registro->numero;}}
										if($estacotizado>0){
											if($row->folioActividad==''){
											echo "Cotizado"; 
										   }
										   else{
										   	echo '<a href="'.base_url().'actividades/ver/'.$row->folioActividad.'" target="_blank"><button class="btn btn-success btn-xs contact-item">Ver</button</a>';
										   } 
										} 
										else { 
	                            	?>
									<a href="<?= base_url()?>crmproyecto/LlamaCotizacion?IDCL=<?= $row->IDCli?>" class='btn btn-primary btn-xs contact-item' data-toggle="modal"   data-original-title><span class="glyphicon glyphicon-pencil" ></span>Cotizar
									</a>
	                            	<? } ?> 
								</td>
								<td>
									<?
										$sqlEstaPagado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='PAGADO' and pj.IDCliente ='".$row->IDCli."'";
										$queryPagado = $this->db->query($sqlEstaPagado);
										if(!empty($queryPagado)){foreach($queryPagado->result() as $Registro){$estapagado = $Registro->numero;}}
										if($estapagado>0){echo "Pagado"; } 
										else { 
											if($row->folioActividad!=''){
									?>
                                  
                                    	<div class="btn-group" style="overflow: all;width: 200px">
									<?php if($row->Documento==''){?>
									<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button>
									<?php }
                                       else{
                                         
                                       	  if($row->pagado==1){
                                        ?>
                                          	
                                         <a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento=<?=$row->Documento?>" target="_blank">Recibos<span class="badge">✔</span></a> 
                                        <?php

                                       	  }
                                       	  else{
                                       	  	?>
	<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button> 
                                         <a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento=<?=$row->Documento?>" target="_blank">Recibos<span class="badge">X</span></a>
                                       	  	<?php
                                       	  }
                                       }
									?>
                        	    	<? }

                        	    } ?> 
                        	</div>
								</td>
							</tr>
							<?
									}
								}
							?>
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
    </div>
</div>

<div class="row">
	<div class="col-lg-12">
    	<medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium>
    </div>
</div><!-- /row -->

<input type="text"  id="dpCita2dd">
