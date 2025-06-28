<?php $this->load->view('actividades/actividadesComentariosOperativos');?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<script>
function mensaje(){
    alert("Esta póliza no corresponde a tu sesión");

    }
</script>
<!-- End navbar -->
<section class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12">    
	    		<font class="tituloSeccione">Actividades</font>
			</div>
		</div>
        <div class="row">
			<div class="col-sm-12 col-md-12" align="right">
            	<input
                	type="button" value="Regresar" 
                    title="Clic" 
                    onclick="window.open('<?=base_url()?>actividades','_self');"
                />
            </div>
			<div class="col-sm-12 col-md-12" align="right">
                <!-- Buscar Folio -->
            </div>            
        </div>
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<table class="table table-striped table-bordered">
					<thead>
						<tr align="right">
                        	<div class="clearfix">
                        	<font class="subTituloSeccione">Resultado Busqueda:</font>
                            <?=$folioBuscado?>
                            </div>
                        </tr>
						<tr bgcolor="#A391C0">
							<th width="100">Folio</th>
                            <th width="90">Fecha</th>
                            <th width="140">Actividad</th>
                            <th width="140">Ramo</th>
                            <th width="200">SubRamo</th>
                            <th width="80">Status</th>
                            <th>Cliente</th>
                            <th width="50">Acciones</th>
                        </tr>
                	</thead>
					<tbody>
					<?
					if($busquedaResult != false){
						foreach($busquedaResult as $row){
							//$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
							$infoCliente=[];
							if($row->idCliente=='')
							{
							 $infoCliente[0]=new stdClass();;
							 $infoCliente[0]->NombreCompleto=$row->nombreCliente;
						    }
						    else
						    {
						     $infoCliente = $this->ws_sicas->obtenerClientePorID($row->idCliente)->TableInfo;	
						    }
					?>
						<tr style="font-size:12px;">
							<td align="center">
                    		<?
								$resultado= $this->capsysdre_actividades->permiteEmision($this->tank_auth->get_usermail());								
								if($this->tank_auth->get_usermail()==$row->usuarioCreacion or $resultado==true){
							?>
									
                            	<a  href="<?=base_url()."actividades/ver/".$row->folioActividad?>"
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres)?>" >
							<?
								} else if($this->tank_auth->get_usermail()=="COBRANZA1@ASESORESCAPITAL.COM"){
							?>
                            	<a  href="<?=base_url()."actividades/ver/".$row->folioActividad?>"
                                	title="<?=$this->capsysdre_actividades->titleDatosExpres($row->datosExpres)?>" >
							<?	
								} else {
							?>
								<a onclick="mensaje()">
							<?	
								}
							?>  
                            	<div style=" <?=$this->capsysdre_actividades->semaforoActividad($row->semaforo); ?>">
								<?=$row->folioActividad."<br />"?>
                                <font style="font-size:9px;">
                                <?=($row->tipoActividadSicas=="tarea")?$row->idSicas:$row->NumSolicitud?>
                                </font>
                                </div>
                                </a>
					<button class="btn btn-info btnActividadComentariosOperativos" onclick="abrirVentanaComentariosOperativos('',<?=$row->idInterno?>,'<?=$row->folioActividad?>')">&#128172</button>
                            </td>
							<td title="<?="Fecha Actualizaci&oacute;n\n".$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaActualizacion,'title')?>">
								<?=$this->capsysdre_actividades->fechaHoraEspActividades($row->fechaCreacion,'')?>
                            </td>
							<td>
								<?=$row->tipoActividad?>
                                <font style="color:red; font-weight:bold;"/>
                                <?=($row->actividadUrgente==1)?" &bull; Urgente !!!":""?>
                                </font>
                            </td>
							<td><?=$row->ramoActividad?></td>
							<td><?=$row->subRamoActividad?></td>
							<td><?=$this->capsysdre_actividades->Status($row->Status)?></td>
							<td><?=$infoCliente[0]->NombreCompleto?></td>
							<td>
								<a href="<?=base_url()."actividades/posponer/".$row->idSicas?>" title="Pausa la Actividad del Sistema">
									<span class="glyphicon glyphicon-pause"></span>
								</a>
								<a href="<?=base_url()."actividades/terminar/".$row->folioActividad?>" title="Elimina la Actividad del Sistema">
									<span class="glyphicon glyphicon-trash"></span>
								</a>
							</td>
						</tr>
					<?
						}
					} else {
					?>

						<tr>
                        	<td colspan="8">
                            No se Encontraron Actividades !!!
							</td>
						</tr>
                    <?
					}
					?>
                    </tbody>

				</table>
            </div>
        </div>

	</div>            
</section>
<?php $this->load->view('footers/footer'); ?>