
<!-- seccion registros prospecto persona-->
<?$prospectosEnEmision='';?>
<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-10 col-sm-8 col-xs-8"><h3 class="titulo-secciones" style="font-size: 18px;">Prospeccion de negocios: Seguimiento de Prospectos Personas</h3></div></div><hr /> 
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
  <div class="col-md-3 col-sm-3 col-xs-3">    
  		<form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes"><button name="ExportaAgentes" id="ExportaAgentes" class="btn btn-primary btn-sm">Exporta Clientes</button></form>
   </div>

   	<div class="col-sm-2 col-md-2" ><button class="btn btn-primary btn-sm" onclick="abrir()">Muestra Calendario</button></div>
   	   <div class="col-sm-12 col-md-12">
            <?if($imprimirSelecVendedor){?>
              <label for="detalles">Vendedores</label>
            
             <select id="selectVendedorProspectoPersona"  name="selectVendedor" class="form-control"><?=imprimirSelecPersonas($personaTipoPersonaCatalogo,$emailVendedor)?></select>
             <button class="btn-chico"  onclick="cargarPaginaDatos('crmproyecto/seguimientoProspecto/','filtraEnSeguimiento')">&#128270</button>
             <?}?>
          </div>
		<br><br>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive divContTabla">
	
    	        <table class="tableP100 table table-condensed table-hover tableMayaMX" id='Mitabla'>
        	        	<thead>
							<tr style="font-size: 11px;">
								<th></th>
    	                    	<th>ID</th>
    	                    	<th style="text-align: center;"><i class="fa fa-calendar"></i></th>
    	                    	<th>RazonSocial</th>	
								<th>ApellidoP</th>                        
								<th>Nombre</th>
								<th>Estado Actual</th>
								<th style="text-align: center;"><i class="fa fa-comment"></i></th>
								<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
								<th style="text-align: center;">Guardar Cita</th>
								<th style="text-align: center;">Detección necesidades</i></th>
								<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
								<th style="text-align: center;"><i class="fa fa-paperclip"></i>&nbsp;Entrega propuesta</th>
								<th style="text-align: center;"><i class="fa fa-file-text"></i></th>
								<th>Pagado</th>			
							</tr>
            	    	</thead>
                		<tbody onscroll="moverScroll(this)">   
                			<? if($ListaClientes != FALSE)
                	         {?>
                			<tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'HOY')">►</td><td colspan="15">HOY</td></tr>
							<? $cont=0;$nombrePestania="";$prospectosEnEmision="";
                         $nombrePestania="HOY";
                         	foreach ($ListaClientes as $row){
                         	if($row->estaEmitido==0){									
							if($nombrePestania!=$row->pestania){?>
								<tr style="background-color:#ebe6e6"><td onclick="abrirCerrar(this,'<?= $row->pestania?>')">►</td><td colspan="15"><?= $row->pestania; ?></td></tr> <?}$nombrePestania=$row->pestania;?>
							<?php if ($row->tipo_prospecto==0){?>
							<tr class="<?= $row->pestania;?> ocultarObjeto">
								<td style="text-align: center;">
									<?php $fecha=date("Y-m-d", strtotime($row->fechaCreacionCA));?>
									<a href="#" onclick="verDetalle(this,'<?=$row->RFC?>','<?=$row->RazonSocial?>','<?=$row->Nombre?>','<?=$row->ApellidoP?>','<?=$row->ApellidoM?>','<?=$row->EMail1?>','<?=$row->Telefono1?>','<?php echo $fecha;?>','<?=$row->EstadoActual;?>','<?=$row->observacion;?>')"><i class="fa fa-eye"></i></a>
								</td>
								<td style="text-align: center;"><input type="checkbox" class="cbReasignar" value="<?=$row->IDCli?>"></button></td> 
								<td><?php if($row->fechaCreacionCA!=null){echo(date("Y-m-d", strtotime($row->fechaCreacionCA)));} ?></td>								
								<td><?=$row->RazonSocial?></td>
								<td><?=$row->ApellidoP?></td>								
								<td><?=$row->Nombre?></td>																							
								<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;"><? echo estado($row->EstadoActual);?></span></td>
								<td style="text-align: center;"><button onclick="direccionAJAX(<?=$row->IDCli?>,'muestraVentana')" class="btn btn-primary btn-xs ">Comentarios</button></td>
								<td>
    	                        	<?
										$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '".$row->IDCli."'";
										$queryEstaPerfilado=$this->db->query($sqlEstaPerfilado);
										if(!empty($queryEstaPerfilado)){foreach ($queryEstaPerfilado->result() as $Registro) {$estaperfilado=$Registro->numero; }}
										if($estaperfilado>0){ echo "Perfilado"; } 
										else {
                            		?>         
									<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,<?=$row->IDCli?>)" style="background-color: #01A9DB;">Perfilar</button>
                            		<? } ?> 
								</td>

								<td style="text-align: center;"><button onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')" class="btn btn-primary btn-xs" style="background-color: #01A9DB;">Contacto</button></td>
								<td style="text-align: center;">
									<a href="<?= base_url()?>crmproyecto/deteccion_necesidades?IDCL=<?= $row->IDCli?>" class='btn btn-primary btn-xs contact-item' target="_blank" style="background-color: #01A9DB;">1er Cita
									</a>
	                            </td>

								<td>
    	                        	<?
										$sqlEstaCotizado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='COTIZADO' and pj.IDCliente ='".$row->IDCli."'";
										$queryEstaCotizado = $this->db->query($sqlEstaCotizado);
										if(!empty($queryEstaCotizado)){foreach ($queryEstaCotizado->result() as $Registro){$estacotizado=$Registro->numero;}}
										if($estacotizado>0){
											if($row->folioActividad==''){echo "Cotizado"; }
										   else{echo '<a href="'.base_url().'actividades/ver/'.$row->folioActividad.'" target="_blank"><button class="btn btn-success btn-xs contact-item">Ver</button</a>';
										   } 
										} 
										else { 
	                            	?>
									<a href="<?= base_url()?>crmproyecto/LlamaCotizacion?IDCL=<?= $row->IDCli?>" target="_blank" class='btn btn-primary btn-xs contact-item' data-toggle="modal"   data-original-title  style="background-color: #01A9DB;"><span class="glyphicon glyphicon-pencil"></span>Cotizar
									</a>
	                            	<? } ?> 
								</td>

								<td style="text-align: center;">
									<a href="#"  onclick="direccionAJAX(<?=$row->IDCli?>,'ventanaCCC')"
									<button class="btn btn-primary btn-xs" style="background-color: #01A9DB;">2da Cita</button>
									</a>
								</td>

								<td style="text-align: center;"><button onclick="traerDocumentos('',<?=$row->IDCli?>,'<?=$row->IDCliSikas?>')" class="btn btn-primary btn-xs ">Ver documento</button>
								</td>
								
								<td>

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
                                       else{ if($row->pagado==1){
                                        ?>
                                         <a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento=<?=$row->Documento?>" target="_blank">Recibos<span class="badge">✔</span></a> 
                                        <?php
                                       	  }
                                       	  else{ ?>
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
								}else{

                                $fecha=date("Y-m-d", strtotime($row->fechaCreacionCA));
                                 $estadoActual='<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,'.$row->IDCli.')" style="background-color: #01A9DB;">Perfilar</button>';

										$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '".$row->IDCli."'";
										$estaPerfilado=$this->db->query($sqlEstaPerfilado)->result();									
										if($estaPerfilado==0){ $estadoActual= "Perfilado"; } 
                                   

								$primeraCita='<a href="'.base_url().'crmproyecto/deteccion_necesidades?IDCL='.$row->IDCli.'" class="btn btn-primary btn-xs contact-item"   target="_blank" style="background-color: #01A9DB;">1er Cita</a>';
                            		


								$segundaCita='<a href="#"  onclick="direccionAJAX('.$row->IDCli.',\'ventanaCCC\')">
									<button class="btn btn-primary btn-xs" style="background-color: #01A9DB;">2da Cita</button>
									</a>';	 
                            	$verDocumento='<button onclick="traerDocumentos(\'\','.$row->IDCli.',\''.$row->IDCliSikas.'\')" class="btn btn-primary btn-xs ">Ver documento</button>';
																																								
								$prospectosEnEmision.='<td style="text-align: center;"><a href="#" onclick="verDetalle(this, \''.$row->RFC.'\',\''.$row->RazonSocial.'\',\''.$row->Nombre.'\',\''.$row->ApellidoP.'\',\''.$row->ApellidoM.'\',\''.$row->EMail1.'\',\''.$row->Telefono1.'\',\''.$fecha.'\',\''.$row->EstadoActual.'\',\''.$row->observacion.'\')"><i class="fa fa-eye"></i></a></td>';
								$prospectosEnEmision.='<td></td>';
								$prospectosEnEmision.='<td>'.$fecha.'</td>';
								$prospectosEnEmision.='<td>'.$row->RazonSocial.'</td>';
								$prospectosEnEmision.='<td>'.$row->ApellidoP.'</td>';
								$prospectosEnEmision.='<td>'.$row->Nombre.'</td>';
								$prospectosEnEmision.='<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;">'.$row->EstadoActual.'</span></td>';
								$prospectosEnEmision.='<td style="text-align: center;"><button onclick="direccionAJAX('.$row->IDCli.',\'muestraVentana\')" class="btn btn-primary btn-xs ">Comentarios</button></td>'	;
                                $prospectosEnEmision.='<td>'.$estadoActual.'</td>';
                                $prospectosEnEmision.='<td></td>';
                                $prospectosEnEmision.='<td style="text-align: center;">'.$primeraCita.'</td>';
                                $prospectosEnEmision.='<td></td>';
                                $prospectosEnEmision.='<td style="text-align: center;">'.$segundaCita.'</td>';
                                $prospectosEnEmision.='<td style="text-align: center;">'.$verDocumento.'</td>';
                                $prospectosEnEmision.='<td></td>';
                                $prospectosEnEmision.='<td></td>';																										      //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r('entravv', TRUE));fclose($fp);
								}
								}
							}
							?>
							<tr style="background-color:green"><td onclick="abrirCerrar(this,'PROSPECTOSEMISION')"></td><td colspan="15">EN EMISION</td></tr>
							<?=$prospectosEnEmision;?>

						</tbody>
						<?
						     $etiquetaResultados='<center><b>No se encontraron registros.</b></center>';
							if($totalResultados != 0){$etiquetaResultados='<medium><i>Total de resultados: <b>'.$totalResultados.'</b></i></medium>';}
						?>
						<tfoot>
							<tr><td colspan="13"><?=$etiquetaResultados;?></td></tr>
							<tr><td>Filtro para buscar pagados:</td><td>Fecha Inicial:<input type="date" id="fInicialProspectoEmitido" value="<?=$primerDiaMes?>"></td><td>Fecha Final:<input type="date" id="fFinalProspectoEmitido" value="<?=$fechaActual?>"></td><td><button class="btn btn-success"  onclick="buscarProspectosEmitidos('')">&#128270</button></td></tr>
							<tr><td id="tdMuestraPropectosPagados"></td></tr>

						</tfoot>

					</table>
				</div><!-- /table-responsive -->
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->

	</section><!-- /container-fluid -->
<!-- Fin seccion propecto persona-->

<div id="divModalDocumentos" class="modalCierra">
	<div class="modal-btnCerrar"><button onclick="cerrarModal('divModalDocumentos')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido"  >

</div>
</div>

<?php

function imprimirSelecPersonas($datos,$email)
{
  
  $option='<optgroup label=""><option data-value="0" value="">Escoger Vendedor</option></optgroup>';
  $selected='';
  foreach ($datos as $key1 => $value1) 
  {
  
    $option.='<optgroup label="'.$key1.'">';
    foreach ($value1 as $key => $value) 
    {
    	if($value->email==$email){$selected='selected="selected"';}
     $nombres=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
   $option.='<option data-value="'.$value->idPersona.'" value="'.$value->email.'" '.$selected.'>'.$nombres.' <label>     ('.$value->email.')</label></option>';  
      $selected='';
    }
    $option.='</optgroup>';
  
  }
  return $option;

}
?>
<style type="text/css">
 .tableMayaMX{display: block;width: 100%;height: 400px}
 .tableMayaMX > thead{display: block;overflow-x: hidden;height: 40px;overflow-y: scroll;}
 .tableMayaMX>tbody { display:block	;height: 300px;overflow:scroll}
 .tableMayaMX> tbody,thead{width: 900px;} 
 .tableMayaMX > thead>tr>th{min-width: 150px}
 .tableMayaMX > tbody>tr>td{min-width: 150px}	
.iconojpg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconojpj.png') ;?>) no-repeat;}
.iconopdf{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconopdf.png') ;?>) no-repeat;}
.iconoword{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoword.png') ;?>) no-repeat;}
.iconoxls{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxls.png') ;?>) no-repeat;}
.iconoxml{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoxml.png') ;?>) no-repeat;}
.iconomsg{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconomsg.png') ;?>) no-repeat;}
.iconoblanco{width: 100%; height:40px;background: url(<?echo(base_url().'assets/images/iconoblanco.png') ;?>) no-repeat;}
.iconoemail{width: 25px; height:25px;background: url(<?echo(base_url().'assets/images/iconoEmail.png') ;?>) no-repeat;}
.iconogenerico > a{position: relative;left: 35px;  display: flex;align-items: center; text-decoration: underline;}
.ulDocumentos{list-style-type: none;width: 100%;height: 300px;overflow: scroll; }

</style>