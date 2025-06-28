<!DOCTYPE html>
<html lang="es">
<script>
function mensaje(){
    alert("Esta póliza no corresponde a tu sesión");

    }
</script>
<? $this->load->view("headers/app/main_header") ?>

<body>
<!-- Page container -->
<div class="page-container">

	<? $this->load->view("headers/app/page_sidebar") ?>
  
	<!-- Main container -->
	<div class="main-container gray-bg">
  
		<!-- Main header -->
		<div class="main-header row">
			<div class="col-sm-6 col-xs-7">
			<? $this->load->view("headers/app/user_info") ?>
			</div>
			
			<div class="col-sm-6 col-xs-5">
			<div class="pull-right">
			<? $this->load->view("headers/app/user_alerts") ?>
			</div>
			</div>
		</div>
		<!-- /main header -->
		
		<!-- Main content -->
		<div class="main-content">
        
			<h1 class="page-title">Actividades</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?= base_url();?>"><i class="fa fa-home"></i>Home</a></li> 
				<li>Actividades</li>
				<li class="active"><strong>Consultar</strong></li>
			</ol>

			<hr />

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
								<div class="col-sm-12 col-md-12" align="right">
									<input
										type="button" value="Regresar" 
										title="Clic"
										onclick="window.open('<?=base_url()?>actividades','_self');"
										class="btn btn-primary btn-sm"
									/>
								</div>
							</div>

						</div><!-- /panel-heading -->

						<!-- panel body -->
						<div class="panel-body">
							<div class="row">
								<div class="table-responsive">

							<table class="table table-striped table-bordered table-sm">
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
										<th width="200">SubRamo</th>
										<th width="80">Status</th>
										<th>Cliente</th>
									</tr>
								</thead>
								<tbody>
					<?
					if($busquedaResult != false){
						foreach($busquedaResult as $row){
							$infoCliente = $this->capsysdre_actividades->DetalleCliente($row->idCliente.'-'.$row->idContacto);
					?>
									<tr style="font-size:12px;">
										<td align="center">
					<!-- -->
                    		<?
								$resultado= $this->capsysdre_actividades->permiteEmision($this->tank_auth->get_usermail());
								//echo $resultado;
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
					<!-- -->
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

										<td><?=$row->subRamoActividad?></td>
										<td><?=$this->capsysdre_actividades->Status($row->Status)?></td>
										<td><?=$infoCliente[0]->NombreCompleto?></td>
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
					</div>
                        
				</div>
			</div>
            
		<? $this->load->view("footers/app/div_footer-main") ?>
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<? $this->load->view("footers/app/main_footer") ?>

</body>
</html>