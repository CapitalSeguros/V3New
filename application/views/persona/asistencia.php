<?php 
  $this->load->view('headers/header');
	$this->load->view('headers/menu'); 
	$this->load->model('personamodelo');
	$email = $this->tank_auth->get_usermail();
	$tab1='';
	$tab2='';
	$tab3='';
	/*switch($tab){
		case 1:
			$tab1='active';
		break;
		case 2:
			$tab2='active';
		break;
		case 3:
			$tab3='active';
		break;
	}*/
	$tab4='active';


?>
<style type="text/css">
	.adjust {
  height: 30em;
  line-height: 1em;
  overflow-x: auto;
  overflow-y: scroll;
  width: 100%;

}
#TablePresentDayReporte thead {

  position: -webkit-sticky;
  position: sticky;
  z-index: 2;
  top: 0;
}
#TablePresentDayReporte tbody th{

  position: -webkit-sticky;
  position: sticky;
  left: 0;
  background: #FFF;
}
</style>
<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<br>
<div class="container" style="margin-bottom: 50px;">
<h4><i class="fa fa-edit"></i>&nbsp;Control de asistencia y puntualidad</h4>
<br>    
<div class="row">
 <div class="col-md-12 col-sm-12 col-lg-12">
   		<div class="card card-primary card-tabs" style="border-bottom: 0px;">
       <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
        <!-- <li class="nav-item">
           <a class="nav-link <?php echo $tab1;?>" id="custom-tabs-one-home-tab" data-toggle="pill" href="#diario" role="tab" aria-controls="diario" aria-selected="true">Control Diario</a>
         </li>
         		<li class="nav-item">
           			<a class="nav-link <?php echo $tab2;?>" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#mensual" role="tab" aria-controls="mensual" aria-selected="false">Control Mensual</a>
         		</li>
         		<li class="nav-item">
           			<a class="nav-link <?php echo $tab3;?>" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#anual" role="tab" aria-controls="anual" aria-selected="false">Control Anual</a>
         </li>
         		<? //if ($email=="DATACENTER@AGENTECAPITAL.COM" || $email=="COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){ ?>
         			<li class="nav-item">
           				<a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#registro" role="tab" aria-selected="false">Control de Asistencias</a>
         </li>
         		<?// } ?>
-->
         			<li class="nav-item">
           				<a class="nav-link <?php echo $tab4;?>" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#reporteasistencia" role="tab" aria-selected="false" onclick="getAssistence()">Reporte de Asistencias</a>
         			</li>

       </ul>
     </div>
       <div class="tab-content" id="custom-tabs-one-tabContent">
         <div class="tab-pane <?php echo $tab1;?>" id="diario" role="tabpanel">
         	<div class="well"style="background-color: #fff;width: 100%;">
					<div class="row" style="width: 100%; display: flex;align-items: center;">
						<div class="col-md-5 col-sm-5 col-lg-5" style="text-align: left;padding: -10px;">
							<b><i class="fa fa-calendar"></i>&nbsp;Fecha de consulta: </b><?php echo $dia."-".$mes."-".$year;?>
						</div>
						<h4 style="font-size: 14px;margin-right: 8px;">Seleccione una fecha para consultar:</h4>
						<div class="col-md-3 col-sm-3 col-lg-3" style="text-align: right;">
							<input type="date" name="fecha" id="fecha" class="form-control">
						</div>
						<div class="col-md-1 col-sm-1 col-lg-1">
							<button onclick="filtroByFecha(1)" class="btn btn-primary btn-sm">Aceptar</button>
						</div>
					</div>
					</div>
					<div class="well" style="background-color: #fff;width: 100%;">
					  <table class="table table-responsive table-hover" id="table_id" style="font-size: 11px;width: 100%">
						<thead>
							<tr>
								<th style="width: 20%">
									Fecha
								</th>
								<th style="width: 40%">
									Colaborador
								</th>
								<th style="width: 10%">
									Asistencia
								</th>
								<th style="width: 10%">
									Puntualidad
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 foreach($personal as $row){
						 	$idPersona=$row->idPersona;
						 	if(!empty($row->nombre)){?>
								<tr>
									<td style="width: 20%"><?php echo date('d-m-Y',strtotime($this->personamodelo->getFechaLastLogin($idPersona,$dia,$mes,$year)));?></td>
									<td style="width: 40%"><?php echo strtoupper($row->nombre." ".$row->apellidop)?></td>
									<?php if( $this->personamodelo->asistencia($idPersona,$dia,$mes,$year) ){?>
												<td style="text-align: center;width: 10%;"><i class="fa fa-check-circle" style="font-size: 16px;color: green;"></i></td>
									<?php }else{?>
												<td style="text-align: center;width: 10%;"><i class="fa fa-times-circle" style="font-size: 16px;color: red;"></i></td>
									<?php }
										if($this->personamodelo->puntualidad($idPersona,$dia,$mes,$year)){?>
												<td style="text-align: center;width: 10%;"><i class="fa fa-check-circle" style="font-size: 16px;color: green;"></i></td>
									<?php }else{?>
												<td style="text-align: center;width: 10%;"><i class="fa fa-times-circle" style="font-size: 16px;color: red;"></i></td>
									<?php }?>

								</tr>
						<?php
							}
						}?>
						</tbody>
					</table>
				</div>
         </div>
         <div class="tab-pane <?php echo $tab2;?>" id="mensual" role="tabpanel">
            <div class="well"style="background-color: #fff;width: 100%;">
					<div class="row" style="width: 100%; display: flex;align-items: center;">
						<div class="col-md-5 col-sm-5 col-lg-5" style="text-align: left;padding: -10px;">
							<b><i class="fa fa-calendar"></i>&nbsp;Mes de consulta: </b><?php echo $mes."-".$year;?>
						</div>
						<h4 style="font-size: 14px;margin-right: 8px;">Seleccione una fecha para consultar:</h4>
						<div class="col-md-3 col-sm-3 col-lg-3" style="text-align: right;">
							<select class="form-control" name="mes" id="mes">
								<option value="0"></option>
								<option value='1'>ENERO</option>
								<option value='2'>FEBRERO</option>
								<option value='3'>MARZO</option>
								<option value='4'>ABRIL</option>
								<option value='5'>MAYO</option>
								<option value='6'>JUNIO</option>
								<option value='7'>JULIO</option>
								<option value='8'>AGOSTO</option>
								<option value='9'>SEPTIEMBRE</option>
								<option value='10'>OCTUBRE</option>
								<option value='11'>NOVIEMBRE</option>
								<option value='12'>DICIEMBRE</option>

							</select>
						</div>
						<div class="col-md-1 col-sm-1 col-lg-1">
							<button onclick="filtroByMensual(2)" class="btn btn-primary btn-sm">Aceptar</button>
						</div>
					</div>
					</div>
					<div class="well" style="background-color: #fff;width: 100%;">
					  <table class="table table-responsive table-hover" id="table_id_mensual" style="font-size: 11px;width: 100%">
						<thead>
							<tr>
								<th style="width: 20%">
									Fecha
								</th>
								<th style="width: 40%">
									Colaborador
								</th>
								<th style="width: 10%">
									Asistencias
								</th>
								<th style="width: 10%">
									Puntualidad
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 foreach($personal as $row){
						 	$idPersona=$row->idPersona;
						 	if(!empty($row->nombre)){?>
								<tr>
									<td style="width: 20%"><?php echo date('d-m-Y',strtotime($this->personamodelo->getFechaLastLogin($idPersona,$dia,$mes,$year)));?></td>
									<td style="width: 40%"><?php echo strtoupper($row->nombre." ".$row->apellidop)?></td>
									
									<?php 
										$asistM=$this->personamodelo->asistenciaMensual($idPersona,$mes,$year);
										$puntM=$this->personamodelo->puntualidadMensual($idPersona,$mes,$year);
									
									//Asistencia Mensual
									if($asistM==0){?>
										<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: red;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $asistM;?></span></td>
									<?php }else{?>
											<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: green;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $asistM;?></span></td>
								<?php	} ?>

								<?php 
								//Asistencia Mensual
										if($puntM==0){?>
										<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: red;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $puntM;?></span></td>
									<?php }else{?>
											<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: green;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $puntM;?></span></td>
								<?php	} ?>



								</tr>
						<?php
							}
						}?>
						</tbody>
					</table>
				</div>
         </div>
         <div class="tab-pane <?php echo $tab3;?>" id="anual" role="tabpanel">
            <div class="well"style="background-color: #fff;width: 100%;">
					<div class="row" style="width: 100%; display: flex;align-items: center;">
						<div class="col-md-5 col-sm-5 col-lg-5" style="text-align: left;padding: -10px;">
							<b><i class="fa fa-calendar"></i>&nbsp;Año de consulta: </b><?php echo $year;?>
						</div>
						<h4 style="font-size: 14px;margin-right: 8px;">Seleccione una fecha para consultar:</h4>
						<div class="col-md-3 col-sm-3 col-lg-3" style="text-align: right;">
							<select class="form-control" name="year" id="year">
								<?= $option ?>
							</select>
						</div>
						<div class="col-md-1 col-sm-1 col-lg-1">
							<button onclick="filtroByAnual(3)" class="btn btn-primary btn-sm">Aceptar</button>
						</div>
					</div>
					</div>
					<div class="well" style="background-color: #fff;width: 100%;">
					  <table class="table table-responsive table-hover" id="table_id_anual" style="font-size: 11px;width: 100%">
						<thead>
							<tr>
								<th style="width: 20%">
									Fecha
								</th>
								<th style="width: 40%">
									Colaborador
								</th>
								<th style="width: 10%">
									Asistencias
								</th>
								<th style="width: 10%">
									Puntualidad
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						 foreach($personal as $row){
						 	$idPersona=$row->idPersona;
						 	if(!empty($row->nombre)){?>
								<tr>
									<td style="width: 20%"><?php echo date('d-m-Y',strtotime($this->personamodelo->getFechaLastLogin($idPersona,$dia,$mes,$year)));?></td>
									<td style="width: 40%"><?php echo strtoupper($row->nombre." ".$row->apellidop)?></td>
									<?php 
										$asistA=$this->personamodelo->asistenciaAnual($idPersona,$year);
										$puntA=$this->personamodelo->puntualidadAnual($idPersona,$year);
									
									//Asistencia Anual
									if($asistA==0){?>
										<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: red;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $asistA;?></span></td>
									
									<?php }else{?>
											<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: green;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $asistA;?></span></td>
								<?php	} 

										//Puntualidad Anual
									if($puntA==0){?>
										<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: red;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $puntA;?></span></td>
									<?php }else{?>
											<td style="text-align: left;width: 10%;">
											<span style="font-size: 11px;color: #fff;background-color: green;padding: 3px;padding-left: 6px;padding-right: 6px; border-radius: 70px"><?php echo $puntA;?></span></td>
								<?php	} ?>
								</tr>
						<?php
							}
						}?>
						</tbody>
					</table>
				</div>
         </div>
         	<? if ($email == "DATACENTER@AGENTECAPITAL.COM" || $email == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM"){
         		if ($email == "DATACENTER@AGENTECAPITAL.COM") {
         			$usermail = "CAPTURA2@ASESORESCAPITAL.COM";
         		} else if ($email == "COORDINADOROPERATIVO@ASESORESCAPITAL.COM") {
         			$usermail = "SOPORTEOPERATIVO@ASESORESCAPITAL.COM";
         		}
         	?>
         		<div class="tab-pane" id="registro" role="tabpanel">
         			<div class="well"style="background-color: #fff;width: 100%;">
         				<div class="row" style="width: 100%; display: flex;align-items: center;">
         					<div class="col-md-5 col-sm-5 col-lg-5" style="text-align: left;padding: -10px;">
								<b>
									<i class="fa fa-calendar"></i>
									<span>Fecha de hoy: </span>
								</b>
								<span><? echo date("d-m-Y");?></span>
							</div>
         					<h4 style="font-size: 14px;margin-right: 8px;">Consultar asistencia de:</h4>
         					<select class="form-control" id="SelectEmail" onchange="ConsultaCompleta()" style="width: 40%;">
         						<?= showEmails($empleados); ?>
         					</select>
         				</div>
         			</div>
         			<div class="well" id="PAsistencias" style="background-color: #fff;width: 100%;color: #212529;">
         				<div class="col-md-12" style="display:flex;align-items:center;justify-content:center;font-size: 15px;">
         					<p style="text-align: center;margin: 0px;padding-right: 5px;">Asistencias de: </p>
         					<p id="ConNombre" style="margin: 0px;"></p>
         				</div>
         				<div class="col-md-12 tab-items" style="padding: 0px;"> <!-- width: 285px; -->
            			    <ul class="nav nav-tabs" id="Nav-Tab-ContAsistencias">
            			        <li class="nav-item">
            			            <a class="nav-tab-link active" aria-current="page" id="VerPanelP1" href="#ConDia" role="tab" data-toggle="tab">
            			                Día
            			            </a>
            			        </li>
            			        <li class="nav-item">
            			            <a class="nav-tab-link" aria-current="page" id="VerPanelP2" href="#ConMes" role="tab" data-toggle="tab">
            			                Mes
            			            </a>
            			        </li>
            			        <li class="nav-item">
            			            <a class="nav-tab-link" aria-current="page" id="VerPanelP3" href="#ConAnual" role="tab" data-toggle="tab">
            			                Año
            			            </a>
            			        </li>
            			        <li class="nav-item">
            			            <a class="nav-tab-link" aria-current="page" id="VerPanelP4" href="#ConTodas" role="tab" data-toggle="tab">
            			                Todas
            			            </a>
            			        </li>
            			    </ul>
            			</div>
            			<div class="tab-content bg-tab-content-poliza">
            			    <div class="col-md-12 tab-pane active" id="ConDia">
            			    	<div class="col-md-12" style="padding: 10px 0px;display: flex;">
            			    		<table class="table table-hover" id="TablePresentDay" style="font-size:12px;width:100%;margin-bottom:0px">
         								<thead>
         									<tr style="background: #6857a4;">
                                		        <th class="title-table" colspan="24">Día</th>
                                		    </tr>
											<tr>
												<th scope="col">Asistencia</th>
												<th scope="col">Puntualidad</th>
												<th scope="col">Fecha</th>
												<th scope="col">Hora</th>
											</tr>
										</thead>
										<tbody class="list-body-table-presentday">
											<tr>
												<td></td>
											</tr>
										</tbody>
									</table>
         							<div class="col-md-4 column-right" style="padding: 10px;">
         								<h4 style="font-size: 13px;margin-right: 5px;">Día:</h4>
         								<input type="date" class="form-control search-input" id="FchDia" value="<?echo date("Y-m-d")?>">
         								<button class="btn btn-primary" onclick="ConsultarDia()">Buscar</button>
         							</div>
         						</div>
            			    </div>
            			    <div class="col-md-12 tab-pane" id="ConMes">
            			    	<div class="col-md-12" style="padding: 10px 0px;display: flex;">
            			    		<table class="table table-hover" id="TablePresentMounth" style="font-size:12px;width:100%;margin-bottom:0px">
         								<thead>
         									<tr style="background: #6857a4;">
                            		            <th class="title-table" colspan="24">Mes</th>
                            		        </tr>
											<tr>
												<th scope="col">Asistencia</th>
												<th scope="col">Puntualidad</th>
												<th scope="col">Mes</th>
											</tr>
										</thead>
										<tbody class="list-body-table-presentmonth"></tbody>
									</table>
         							<div class="col-md-4 column-right" style="padding: 10px;">
         								<h4 style="font-size: 13px;margin-right: 5px;">Mes:</h4>
         								<select class="form-control search-input" id="FchMes">
         									<option value="1">Enero</option>
         									<option value="2">Febrero</option>
         									<option value="3">Marzo</option>
         									<option value="4">Abril</option>
         									<option value="5">Mayo</option>
         									<option value="6">Junio</option>
         									<option value="7">Julio</option>
         									<option value="8">Agosto</option>
         									<option value="9">Septiembre</option>
         									<option value="10">Octubre</option>
         									<option value="11">Noviembre</option>
         									<option value="12">Diciembre</option>
         								</select>
         								<button class="btn btn-primary" onclick="ConsultarMes()">Buscar</button>
       </div>
     </div>
   </div>
            			    <div class="col-md-12 tab-pane" id="ConAnual">
            			    	<div class="col-md-12" style="padding: 10px 0px;display: flex;">
            			    		<table class="table table-hover" id="TablePresentYear" style="font-size:12px;width:100%;margin-bottom:0px">
         								<thead>
         									<tr style="background: #6857a4;">
                            		            <th class="title-table" colspan="24">Año</th>
                            		        </tr>
											<tr>
												<th scope="col">Asistencia</th>
												<th scope="col">Puntualidad</th>
												<th scope="col">Año</th>
											</tr>
										</thead>
										<tbody class="list-body-table-presentyear"></tbody>
									</table>
									<div class="col-md-4 column-right" style="padding: 10px;">
         								<h4 style="font-size: 13px;margin-right: 5px;">Año:</h4>
         								<select class="form-control search-input" id="FchYear">
         									<?= $option ?>
         								</select>
         								<button class="btn btn-primary" onclick="ConsultaAnual()">Buscar</button>
 </div>
 </div>
            			    </div>
            			    <div class="col-md-12 tab-pane" id="ConTodas">
       
							</div>
            			</div>
					</div>
         		</div>
         	<? } ?>

         	<!--MODIFICACION EDWIN MARIN 06-03-2024-->
         	         	<? if ($email == "CAPITALHUMANO@AGENTECAPITAL.COM" || $email=="CONTABILIDAD@AGENTECAPITAL.COM" || $email=="DIRECTORGENERAL@AGENTECAPITAL.COM" || $email=="GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX"){
         				$permiso = 0;
         			}else{$permiso=1;}
         	?>
         		<div class="tab-pane <?php echo $tab4;?>" id="reporteasistencia" role="tabpanel">
         			<div class="well"style="background-color: #fff;width: 100%;">
         				<div class="row" style="width: 100%; display: flex;align-items: center;">
         					<div class="col-md-5 col-sm-5 col-lg-5" style="text-align: left;padding: -10px;">
								<b>
									<i class="fa fa-calendar"></i>
									<span>Fecha de hoy: </span>
								</b>
								<span><? echo date("d-m-Y");?></span>
							</div>
							<input type="text" class="hidden" id="permisos" value="<?php echo $permiso?>">
         				</div>
         			</div>
         			<div class="well" id="RepAsistencias" style="background-color: #fff;width: 100%;color: #212529;">
         				<div class="col-md-12" style="display:flex;align-items:center;justify-content:center;font-size: 15px;">
         					<p style="text-align: center;margin: 0px;padding-right: 5px;">Reporte de asistencias de colaboradores: </p>
         					<p id="ConNombre" style="margin: 0px;"></p>
         				</div>
            			<div class=" bg-tab-content-poliza">
            			    <div class="col-md-12" id="RepDia">
            			    	<div class="row " style="padding: 10px 0px;display: flex; ">
            			    		<div class="center-block" style="padding: 10px;">
         								<h4 style="font-size: 13px;margin-right: 5px;float: left;">Día:</h4>
         								<div class="col-md-8"><div class="col-md-6"><input type="date" class="form-control " id="FchAssistenceReport1" value="<?echo date("Y-m-d")?>"></div>
         								<div class="col-md-6"><input type="date" class="form-control " id="FchAssistenceReport2" value="<?echo date("Y-m-d")?>"></div></div>
         								<button class="btn btn-primary cargarAssistence" onclick="getAssistence()">Buscar</button>
         							</div>
<div class="right-block" ><button class="btn btn-primary" onclick="exportarxls('for-export-day')">Exportar</button></div>
            			    		<div class="adjust col-md-12"><table class="table table-hover " id="TablePresentDayReporte" style="font-size:12px;width:100%;margin-bottom:0px">
         								<thead>
         									
											<tr id="thFechaTableDay">
												<th rowspan="3" class="text-center align-middle">Nombre</th>
												<th rowspan="3" class="text-center align-middle">Puesto</th>
											</tr>
											<tr id="thFechaTableDay2">
												<th colspan="2" class="text-center align-middle">Fecha</th>
												<th colspan="2" class="text-center align-middle">Fecha</th>
												
											</tr>
											<tr id="trHoraDay">
												<th class="text-center align-middle">Hora Entrada</th>
												<th class="text-center align-middle">Hora Salida</th>
												<th class="text-center align-middle">Hora Entrada</th>
												<th class="text-center align-middle">Hora Salida</th>

											</tr>
										</thead>
										<tbody class="list-body-table-presentdayReporte">
         									<tr>
												<td></td>
											</tr>
										</tbody>
									</table></div>
								<table class="hidden border" id="for-export-day" >
         								<thead>
         									<tr id="thFecha-export-day">
												<th rowspan="2" class="text-center align-middle">Nombre</th>
												<th rowspan="2" class="text-center align-middle">Puesto</th>
											</tr>
											<tr id="trHora-export-day">
												<th class="text-center align-middle">Hora Entrada</th>
												<th class="text-center align-middle">Hora Salida</th>
												<th class="text-center align-middle">Hora Entrada</th>
												<th class="text-center align-middle">Hora Salida</th>
												<th class="text-center align-middle">Hora Entrada</th>
												<th class="text-center align-middle">Hora Salida</th>

											</tr>
										</thead>
										<tbody class="body-export-day">
         									<tr>
												<td></td>
											</tr>
										</tbody>
									</table>
 </div>
            			    </div>
            			    

            			</div>
					</div>
         		</div>
    
         	<!--FIN DE LA MODIFICACION - EDWIN MARIN-->
        </div>
    </div>
</div><!--fin de container-->
<style type="text/css">
	#custom-tabs-one-tab.nav-tabs>li>a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 0px 0px 0px 0px;
    }
    #custom-tabs-one-tab.nav-tabs > li > a:hover {
        background: #472380;
    }
    #custom-tabs-one-tab.nav-tabs > li > a.active, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        background: white;
        border-bottom-color: transparent;
        border-radius: 0px 0px 0px 0px;
    }
    .nav-tabs.tabs >li > a {
        margin-right: 0px;
        border: 1px solid transparent;
    }
    .nav-tabs.tabs > li > a:hover {
        background: #472380;
        border: 1px solid #472380;
        border-bottom-color: transparent;
        border-radius: 0px 0px 0px 0px;
    }
    .tab-content {
        border-left: 1px solid #ddd;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }
    .column-center {
    	display: flex;
    	align-items: center;
    	justify-content: center;
    }
    .column-right {
    	display: flex;
    	align-items: center;
    	justify-content: flex-end;
    }
    .seg-asistencia {
    	font-size: 11px;
    	color: #fff;
    	background-color: green;
    	padding: 3px;
    	padding-left: 6px;
    	padding-right: 6px;
    	border-radius: 70px;
    }
    .seg-noasistencia {
    	font-size: 11px;
    	color: #fff;
    	background-color: red;
    	padding: 3px;
    	padding-left: 6px;
    	padding-right: 6px; 
    	border-radius: 70px
    }
    .seg-icon-asist {
    	font-size: 20px;
    	color: green;
    	/* background-color: green; */
    	/*padding: 3px;*/
    	/* padding-left: 4px; */
    	/* padding-right: 4px; */
    	border-radius: 70px;
    }
    .seg-icon-noasist {
    	font-size: 20px;
    	color: red;
    	/* background-color: red; */
    	/*padding: 3px;*/
    	/* padding-left: 2px; */
    	/* padding-right: 2px; */
    	border-radius: 70px;
    }
    .title-table {
		font-size: 13px;
		text-align: center;
	}
	.search-input {
		width: 50%;
		margin-right: 15px;
	}
    /*Tab*/
    .tab-items {
		display: flex;
		padding-right: 0px;
		margin-top: 20px;
	}
	.bg-tab-content-poliza {
		padding-left: 10px;
		padding-right: 10px;
		background: white;
		padding-top: 10px;
		display: flex;
		justify-content: center;
		margin-bottom: 20px;
	}
	#Nav-Tab-ContAsistencias.nav-tabs {
		border-bottom: 1px solid #ddd;
		background: transparent;
		width: 100%;
	}
	#Nav-Tab-ContAsistencias.nav-tabs > li {
		margin-bottom: -1px;
	}
	#Nav-Tab-ContAsistencias.nav-tabs>li>a.active, .nav-tabs>li>a.active:focus, .nav-tabs>li>a.active:hover {
    	color: #8370A1;
    	cursor: default;
    	background-color: #fff;
    	border: 1px solid #ddd;
    	border-bottom-color: transparent;
    }
    #Nav-Tab-ContAsistencias.nav-tabs>li>a {
    	margin-right: 2px;
    	line-height: 1.42857143;
    	border: 1px solid transparent;
    	border-radius: 4px 4px 0 0;
    	color: #555;
    }
    #Nav-Tab-ContAsistencias.nav-tabs>li>a:hover {
    	background: #8370A1;
    	color: white;
    }
    #Nav-Tab-ContAsistencias.nav-tabs>li {
	    float: left;
	    margin-bottom: -1px;
	}
	.opaco {
	    opacity: .5;
	}
	.container-spinner-table-asist {
	    /*padding: 51px 15px;*/
	    color: #266093;
	    width: 100%;
	    height: 271px;
	    align-items: center;
	    display: flex;
	    justify-content: center;
	    /*position: relative;
	    z-index: 100;*/
	}
</style>
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script> -->
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script type="text/javascript">
	var nombremeses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

  $(document).ready( function () {
     $('#table_id').DataTable( {
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
    });

     $('#table_id_mensual').DataTable( {
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
    });

     $('#table_id_anual').DataTable( {
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
    });

     	var hoy = new Date();
     	const fecha = hoy.getDate() + "-" + hoy.getMonth() + "-" + hoy.getFullYear();
     	const mes = hoy.getMonth() + 1;
     	var fechaquincena1="";
     	var  fechaquincena2="";
     	var mescero="";
    	//$('#FchDia').val(fecha);
    	$("#FchMes option[value='"+ mes +"']").prop("selected",true);
    	$("#FchMesReporte option[value='"+ mes +"']").prop("selected",true);
    	if(mes<10){
    		mescero="0"+mes;
    	}
    	if(hoy.getDate()<=15){
    		fechaquincena1= hoy.getFullYear()+ "-" + mescero + "-01";
    		fechaquincena2= hoy.getFullYear()+ "-" + mescero + "-15";
    	}else{
    		fechaquincena1= hoy.getFullYear()+ "-" + mescero + "-16";
    		const day=getLastDayOfMonth(hoy.getFullYear(), mes)
    		fechaquincena2=hoy.getFullYear()+ "-" + mescero + "-" + day;
    	}

    	document.getElementById("Fchquincena1").value=fechaquincena1;
    	document.getElementById("Fchquincena2").value=fechaquincena2;

    	var mesRep=document.getElementById("FchMesReporte").value;
		var today = new Date();
		var mesceroRep="";
		if(mesRep<10){
    		mesceroRep="0"+mesRep;
    	}
	var fecha1=today.getFullYear()+"-"+mesceroRep+"-"+"01";
	const dayRep=getLastDayOfMonth(today.getFullYear(), mesRep);
    var fecha2=today.getFullYear()+ "-" + mesceroRep + "-" + dayRep;

    	document.getElementById("FchMes1").value=fecha1;
    	document.getElementById("FchMes2").value=fecha2;




    	ConsultaCompleta();

	});
function aplicarFiltroCabecera(objeto)
{

  let index=objeto.parentNode.cellIndex;
  let body=Array.from(objeto.parentNode.parentNode.parentNode.nextElementSibling.rows);
  let estilos='';

  if(objeto.value==-1 || objeto.value==''){body.forEach(b=>{b.classList.remove('ocultaRow'+index);})}
  else{
  body.forEach(b=>{
     b.classList.remove('ocultaRow'+index);    
    if(b.cells[index].dataset.newvalue!=objeto.value){b.classList.add('ocultaRow'+index);}     
   })
  }

  estilos+='.ocultaRow'+index+'{display:none}';
  var nuevaHojaDeEstilo = document.createElement("style");
  document.head.appendChild(nuevaHojaDeEstilo);
  nuevaHojaDeEstilo.textContent = estilos;

}


function getLastDayOfMonth(year, month) {
  let date = new Date(year, month, 0);
  return date.getDate();
}

function ajustarfecha(data){
	var date=""
	if(data=="primer"){
		date = new Date(document.getElementById("Fchquincena1").value+'T00:00:00');
	}else{
		date = new Date(document.getElementById("Fchquincena2").value+'T00:00:00');
	}
	const mes = date.getMonth() + 1;
	var fechaquincena1="";
    var  fechaquincena2="";
    var mescero="";
	if(mes<10){
    		mescero="0"+mes;
    	}
    	if(date.getDate()<=15){
    		fechaquincena1= date.getFullYear()+ "-" + mescero + "-01";
    		fechaquincena2= date.getFullYear()+ "-" + mescero + "-15";
    	}else{
    		fechaquincena1= date.getFullYear()+ "-" + mescero + "-16";
    		const day=getLastDayOfMonth(date.getFullYear(), mes)
    		fechaquincena2=date.getFullYear()+ "-" + mescero + "-" + day;
    	}

    	document.getElementById("Fchquincena1").value=fechaquincena1;
    	document.getElementById("Fchquincena2").value=fechaquincena2;
	

}

function ajustarfechaMes(){
	var mes=document.getElementById("FchMesReporte").value;
	var today = new Date();
	var mescero="";
	if(mes<10){
    		mescero="0"+mes;
    	}
	var fecha1=today.getFullYear()+"-"+mescero+"-"+"01";
	const day=getLastDayOfMonth(today.getFullYear(), mes);
    var fecha2=today.getFullYear()+ "-" + mescero + "-" + day;

    	document.getElementById("FchMes1").value=fecha1;
    	document.getElementById("FchMes2").value=fecha2;
}
  	const base = "<?php echo base_url()?>fastFile/";
	function filtroByFecha(tab){
	var fecha=document.getElementById('fecha').value;
		document.location.href=base+"asistencia/?fecha="+fecha+"&tab="+tab;
	}

	function filtroByMensual(tab){
	var fecha=document.getElementById('mes').value;
		document.location.href=base+"asistencia/?fecha="+fecha+"&tab="+tab;
	}

	function filtroByAnual(tab){
	var fecha=document.getElementById('year').value;
		document.location.href=base+"asistencia/?fecha="+fecha+"&tab="+tab;
	}

	function ConsultaCompleta() {
		$('#PAsistencias').addClass('opaco');
    	ConsultarDia();
    	ConsultarMes();
    	ConsultaAnual();
		ConsultarTodos();
		ConsultarDiaReporte();
	}

	function ConsultarDia() {
		const correo = document.getElementById('SelectEmail').value;
		const dia = document.getElementById('FchDia').value;
		//console.log(correo,dia);
		$.ajax({
            type: "GET",
            url: `${base}ConsultarPorDia`,
            data: {
                cr: correo,
                dt: dia
            },
            /*beforeSend: (load) => {
                $('#view-table-polizas').html(`
                    <div class="container-spinner-table-polizas">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },*/
            success: (data) => {
            	//console.log(data);
            	const r = JSON.parse(data);
            	//console.log(r);
            	var trtd = ``;
            	var asistencia = "";
            	var puntualidad = "";
            	var fecha = "";
            	var hora = "";
            	var day = dia + "T00:00:00";
            	const a = r['asistencia'];
            	const p = r['puntualidad'];

            	if (a != 0) {
            		for (const d in a) {
            			const date = new Date(a[d].fecha);
            			fecha = numerodias[date.getDate()] + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();
            			hora = date.toLocaleTimeString('en-US');
            		}
            		asistencia = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
            	}
            	else {

            		var hoy = new Date(day);
     				fecha = numerodias[hoy.getDate()] + "/" + nombremeses[hoy.getMonth()] + "/" + hoy.getFullYear();
            		asistencia = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            		hora = "N/A";
            	}

            	if (p != 0) {
            		puntualidad = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
            	}
            	else {
            		puntualidad = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            	}

            	trtd += `
                   	<tr data-id="${a.id}">
                   	    <td>${asistencia}</td>
                   	    <td>${puntualidad}</td>
                   	    <td>${fecha}</td>
                   	    <td>${hora}</td>
                   	</tr>`;

            	$('.list-body-table-presentday').html(trtd);
            },
            error: (error) => {
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
	}

	//modificacion Edwin Marin 07-03-2024

	function agregarFiltro(){
		var permiso = document.getElementById('permisos').value;

		$.ajax({
            type: "GET",
            url: "<?php echo base_url()?>fastFile/traerFiltroAsistencias",
 			data:{
            permisos: permiso
            },
            
            success: (data) => {
            	//console.log(data);
            	const r = JSON.parse(data);
            	const n = r['nombres'];
            	const p = r['puestos'];
            	const a = r['areaColaborador'];
            	filtroNombre='<select class="filtroCabecera form-control" onchange="aplicarFiltroCabecera(this)"><option value="-1">ESCOGER UN FILTRO</option>';
            	for(const e in n){
            		const obj= n[e].id;
            		const nombre= n[e].nombre;
                        	 filtroNombre+=`<option value="${obj}">${nombre}</option>`;
                        }
                filtroNombre+='</select>';

                filtroPuesto='<select class="filtroCabecera form-control" onchange="aplicarFiltroCabecera(this)"><option value="-1">ESCOGER UN FILTRO</option>';
            	for(const x in p){
            		const obj= p[x].id;
            		const nombre= p[x].nombre;
                        	 filtroPuesto+=`<option value="${obj}">${nombre}</option>`;
                        }
                filtroPuesto+='</select>';

                filtroArea='<select class="filtroCabecera form-control" onchange="aplicarFiltroCabecera(this)"><option value="-1">ESCOGER UN FILTRO</option>';
            	for(const j in a){
            		const obj= a[j].id;
            		const nombre= a[j].nombre;
                        	 filtroArea+=`<option value="${obj}">${nombre}</option>`;
                        }
                filtroArea+='</select>';
                
                cabecera="<th>Nombre <br>"+filtroNombre+"</th><th >Puesto<br>"+filtroPuesto+"</th><th >Area<br>"+filtroArea+"</th><th >Fecha</th><th >Hora Entrada</th><th >Hora Salida</th>";
                cabeceraQuincenal="<th rowspan='3' class='text-center align-middle'>Nombre <br>"+filtroNombre+"</th><th rowspan='3' class='text-center align-middle'>Puesto<br>"+filtroPuesto+"</th><th rowspan='3' class='text-center align-middle'>Area<br>"+filtroArea+"</th>";
            			
                $('#thFechaTable').html(cabeceraQuincenal);
                $('#thFechaTableDay').html(cabeceraQuincenal);

            }
        })
            		
                   }

	//fin modificación 
	function ConsultarMes() {
		const correo = document.getElementById('SelectEmail').value;
		const mes = document.getElementById('FchMes').value;
		//console.log(correo,mes);
		$.ajax({
            type: "GET",
            url: `${base}ConsultarPorMes`,
            data: {
                cr: correo,
                dt: mes
            },
            /*beforeSend: (load) => {
                $('#view-table-polizas').html(`
                    <div class="container-spinner-table-polizas">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },*/
            success: (data) => {
            	//console.log(data);
            	const r = JSON.parse(data);
            	//console.log(r);
            	var trtd = ``;
            	var asistencia = "";
            	var puntualidad = "";
            	var fecha = nombremeses[mes - 1];

            	const a = r['asistencia'];
            	const p = r['puntualidad'];
            	const countA = a.length;
            	const countP = p.length;

            	if (a != 0) {
            		asistencia = '<span class="seg-asistencia">'+countA+'</span>';
            	}
            	else {
            		asistencia = '<span class="seg-noasistencia">0</span>';
            	}

            	if (p != 0) {
            		puntualidad = '<span class="seg-asistencia">'+countP+'</span>';
            	}
            	else {
            		puntualidad = '<span class="seg-noasistencia">0</span>';
            	}

            	trtd += `
                   	<tr data-id="${a.id}">
                   	    <td>${asistencia}</td>
                   	    <td>${puntualidad}</td>
                   	    <td>${fecha}</td>
                   	</tr>`;

            	$('.list-body-table-presentmonth').html(trtd);
            },
            error: (error) => {
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
	}

	function ConsultaAnual() {
		const correo = document.getElementById('SelectEmail').value;
		const year = document.getElementById('FchYear').value;
		//console.log(correo,year);
		$.ajax({
            type: "GET",
            url: `${base}ConsultaAnual`,
            data: {
                cr: correo,
                dt: year
            },
            /*beforeSend: (load) => {
                $('#view-table-polizas').html(`
                    <div class="container-spinner-table-polizas">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);
            },*/
            success: (data) => {
            	//console.log(data);
            	const r = JSON.parse(data);
            	//console.log(r);
            	var trtd = ``;
            	var asistencia = "";
            	var puntualidad = "";
            	var fecha = "";

            	const a = r['asistencia'];
            	const p = r['puntualidad'];
            	const countA = a.length;
            	const countP = p.length;

            	if (a != 0) {
            		asistencia = '<span class="seg-asistencia">'+countA+'</span>';
            	}
            	else {
            		asistencia = '<span class="seg-noasistencia">0</span>';
            	}

            	if (p != 0) {
            		puntualidad = '<span class="seg-asistencia">'+countP+'</span>';
            	}
            	else {
            		puntualidad = '<span class="seg-noasistencia">0</span>';
            	}

            	trtd += `
                   	<tr data-id="${a.id}">
                   	    <td>${asistencia}</td>
                   	    <td>${puntualidad}</td>
                   	    <td>${year}</td>
                   	</tr>`;

            	$('.list-body-table-presentyear').html(trtd);
            },
            error: (error) => {
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
	}

	function ConsultarTodos() {
		const val = document.getElementById('SelectEmail').value;
		//console.log(val);
		$.ajax({
            type: "GET",
            url: `${base}ConsultarAsistencia`,
            data: {
                ml: val 
            },
            beforeSend: (load) => {
            	$('#ConTodas').html(`
                    <div class="container-spinner-table-asist">
                        <div class="bd-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                    </div>
                `);
            },
            success: (data) => {
            	const r = JSON.parse(data);
            	//console.log(r);

            	var thead = `
            		<table class="table table-hover" id="TableAsistencias" style="font-size: 12px;width: 100%">
						<thead>
							<tr>
								<th scope="col">Nombre</th>
								<th scope="col">Asistencia</th>
								<th scope="col">Puntualidad</th>
								<th scope="col">Fecha</th>
								<th scope="col">Hora</th>
							</tr>
						</thead>
						<tbody class="list-body-table-asistencias"></tbody>
					</table>
            	`;
            	var trtd = ``;
            	$('#PAsistencias').removeClass('opaco');

            	const i = r['info'];
            	const a = r['asistencia'];
            	const p = r['puntualidad'];

            	var numeromeses = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
            	var numerodias = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");

            	for (const d in i) {
            		$('#ConNombre').text(i[d].nombres + " " + i[d].apellidoPaterno + " " + i[d].apellidoMaterno);
            	}

            	for (const b in a) {
            		const Nombres = a[b].nombres;
            		const ApellidoP = a[b].apellidoPaterno;
            		const ApellidoM = a[b].apellidoMaterno;
            		const NombreCompleto = Nombres + " " + ApellidoP + " " + ApellidoM;
            		var Asistencia = "";
            		var Puntualidad = "";

            		//Fecha
            		const date = new Date(a[b].fecha);
            		//const Fecha = date.getDate() + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();
            		const Fecha = date.getFullYear() + "/" + numeromeses[date.getMonth()] + "/" + numerodias[date.getDate()];
            		const Hora = date.toLocaleTimeString('en-US');

            		if (a[b].descripcion == "asistencia") {
            			Asistencia = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
            		}
            		else {
            			Asistencia = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';
            		}

            		Puntualidad = '<span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span>';

            		for (const c in p) {
            			if (a[b].fecha == p[c].fecha) {
            				//console.log(a[b].fecha, p[c].fecha);
            				Puntualidad = '<span class="seg-icon-asist"><i class="fa fa-check-circle"></i></span>';
            			}
            		}

            		trtd += `
                        <tr data-id="${a[b].id}">
                            <td>${NombreCompleto}</td>
                            <td>${Asistencia}</td>
                            <td>${Puntualidad}</td>
                            <td>${Fecha}</td>
                            <td>${Hora}</td>
                        </tr>`;
            	}
            	$('#ConTodas').html(thead);
            	$('.list-body-table-asistencias').html(trtd);
    			$('#TableAsistencias').DataTable( {
    			    language: {
    			        url: `<?=base_url()?>assets/js/espanol.json`
    			    },
    			    columns:[
        		    {
        		        sortable: false,
        		        orderable: false,
        		    },
        		    {
        		        sortable: false,
        		        orderable: false,
        		    },
        		    {
        		        sortable: false,
        		        orderable: false,
        		    },
        		    {
        		        sortable: true,
        		        orderable: true,
        		    },
        		    {
        		        sortable: true,
        		        orderable: true,
        		    }],
        		    order: [['3', 'desc']],
    			});
            },
            error: (error) => {
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
	}

	<?
		function showEmails($employees) {
			$option = "";
			foreach ($employees as $val) {
				$selected = "";
				if ($val->idPersona == 907 || $val->idPersona == 1067) { $selected = "selected"; }
				$option .= '<option value="'.$val->email.'" '.$selected.'>'.$val->email.'</option>';
			}
			return $option;
		}
	?>
</script>
<script>
	$(window).on("load", function(){
    $('.cargarAssistence').click(); 
});
</script>
<script>
	function exportarxls(id){

    var downloadLink;
    var filename = "asistencia";
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(id);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
	}
</script>

<script>
	function getAssistence(){
			const rango1 = document.getElementById('FchAssistenceReport1').value;
			const rango2 = document.getElementById('FchAssistenceReport2').value;
			var fechaInicio = new Date(rango1+" 00:00:00");
			var fechaFin = new Date(rango2+" 23:00:00");
			var thFecha =  ``;
			var trHora =  ``;
			var thFechaExport =  ``;
			var trHoraExport =  ``;
			var permiso = document.getElementById('permisos').value;
			var fechaCurrent=fechaInicio.getDate();
				for(fechaCurrent; fechaCurrent<=fechaFin.getDate(); fechaCurrent++){
		          const month="0"+(fechaInicio.getMonth()+1);
		          let diaCero = fechaCurrent<10 ? "0"+fechaCurrent : fechaCurrent;
		          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
		          const fechaComplete = fechaDia+" 00:00:00";
		          var finde= new Date(fechaComplete);

		          	fechaFinal = numerodias[finde.getDate()] + "/" + nombremeses[finde.getMonth()] + "/" + finde.getFullYear();
		          	console.log(fechaFinal);
		            thFecha+= `<th colspan="4" class="text-center align-middle" style="border-bottom: solid 1px #472380;">${fechaFinal}</th>`;
					
		            trHora+= `<th colspan="2" class="text-center align-middle">Hora Entrada</th>
												<th colspan="2" class="text-center align-middle">Hora Salida</th>`;
				

		        }
		$('#thFechaTableDay2').html(thFecha);
		$('#trHoraDay').html(trHora);
		console.log(rango1, rango2, permiso);
		//console.log(correo,dia);
		$.ajax({
            type: "GET",
            url: `${base}getAssistenceReport`,
            data: {
                dt1: rango1,
                dt2: rango2,
                permiso: permiso
            },
            beforeSend: (load) => {
                $('#list-body-table-presentdayReporte').html(`
            <tr>
                <td colspan="6">
                    <div class="container-spinner-content-loading">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                </td>
            </tr>
                `);
            },
            success: (data) =>{
            		//console.log(data);
            	const r = JSON.parse(data);
            	console.log(data);
            	//console.log(r);
            	var trtd = ``;
            	var horaEntrada = "";
            	var medioEntrada="";
            	var fecha = "";
            	var horaSalida = "";
            	var medioSalida="";
            	var nombre ="";
            	const a = r['asistencia'];
            	const s = r['salida'];
            	const c = r['colaboradores'];
            	const v = r['vacations'];
            	const nl = r['nolaborales'];
            	const i = r['incapacidad'];
            	var semaforo="";
            	var semaforoHora="";
            	var td="";
            	var idAnterior="";
            	var idAnteriorSec="";
            	var semaforoSalida="";
            	var dateAnteriorImpresa="";
            	var fechaAnteriorImpresa="";
            	var fechaCurrent="";
            	var dateimpreso="";
            	console.log(data);

            	//Se recorre a todos los colaboradores
            	for (const d in c){
            		var semaforoColaborador="";
            		var dateAnteriorImpresa="";
            		var dateimpreso="";
            		var fechaConsecuente="";
            		var dateafter="";
            		var diaconsecuente ="";
            		var validFinde="";
            		diaconsecuente = fechaInicio.getDate()+1;
            		dateafter = fechaInicio.getFullYear()+"-"+(fechaInicio.getMonth()+1)+"-"+diaconsecuente;
            		fechaConsecuente = new Date(dateafter+" 00:00:00");
            		trtd += `
                   	<tr data-id="${c[d].id}">
                   	    <th data-newvalue="${c[d].id}">${c[d].nombre}</th>
                   	    <td data-newvalue="${c[d].idPuesto}">${c[d].personaPuesto}</td>
                   	    <td data-newvalue="${c[d].idColaboradorArea}">${c[d].colaboradorArea}</td>
                   	    `;
            		
            		
            		//se recorren las asistencias y se valida que el colaborador tenga registros
            		for (const e in a){
            			if(c[d].id==a[e].idPersona){
            				const date = new Date(a[e].fecha);
            				horaEntrada = date.toLocaleTimeString('en-US');
            				var horaEntradaValid = date.toLocaleTimeString('it-IT');
            				medioEntrada= a[e].comentario=="v3" ? "V3" : "H";
            				var horaEntradaColaborador = "";
            				var styleEntrada="color: #1E8A28;";
            				var styleSalida="color: #1E8A28;";
            				switch(date.getDay()){
            				case 1:
            					horaEntradaColaborador=c[d].entradaLunes;
            					horaSalidaColaborador=c[d].salidaLunes;
            					break;
            				case 2: 
            					horaEntradaColaborador=c[d].entradaMartes;
            					horaSalidaColaborador=c[d].salidaMartes;
            					break;
            				case 3:
            					horaEntradaColaborador=c[d].entradaMiercoles;
            					horaSalidaColaborador=c[d].salidaMiercoles;
            					break;
            				case 4:
            					horaEntradaColaborador=c[d].entradaJueves;
            					horaSalidaColaborador=c[d].salidaJueves;
            					break;
            				case 5:
            					horaEntradaColaborador=c[d].entradaViernes;
            					horaSalidaColaborador=c[d].salidaViernes;
            					break;
            				case 6:
            					horaEntradaColaborador=c[d].entradaSabado;
            					horaSalidaColaborador=c[d].salidaSabado;
            					break;
            				}
            				if(horaEntradaValid>horaEntradaColaborador){
            					styleEntrada="color: #CD1629;";
            				}
            				console.log(c[d].id, fechaConsecuente);
            				if(date.getTime()>=fechaInicio.getTime() && date.getTime()<=fechaConsecuente.getTime()){//revisar aqui

            					if(date.getTime()<=fechaFin.getTime()){
            						var fechaEntrada = numerodias[date.getDate()] + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();

            						for (const f in s){
            							const dateSalida = new Date(s[f].fecha);
            							semaforoSalida="";
            							var fechaSalida = numerodias[dateSalida.getDate()] + "/" + nombremeses[dateSalida.getMonth()] + "/" + dateSalida.getFullYear();
            							if(c[d].id==s[f].idPersona){
            							if(fechaEntrada==fechaSalida){
            								horaSalida = dateSalida.toLocaleTimeString('en-US');
            								var horaSalidaValid = dateSalida.toLocaleTimeString('it-IT');
            								if(horaSalidaValid<horaSalidaColaborador){
            					styleSalida="color: #CD1629;";
            				}
            								medioSalida= s[f].comentario=="v3" ? "V3" : "H";
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+"-"+anteriorFecha.getMonth()+"-"+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td data-hora="${horaSalidaValid}" data-salidacol="${horaSalidaColaborador}" style='${styleSalida}'>${horaSalida}</td>
                   	    <td>${medioSalida}</td>
                   				`;
                   				semaforoSalida="entro";
                   				//poner otro semaforo
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
										}else{
            								fechaConsecuente= date.getFullYear()+"-"+date.getMonth()+"-"+(date.getDate()+1)+" 00:00:00";
            								fechaConsecuente= new Date(fechaConsecuente);
            							}
            						}
            						}
            						}
            						if(semaforoSalida!="entro"){
            							if(dateAnteriorImpresa!=""){
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+anteriorFecha.getMonth()+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+date.getMonth()+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
                   	    <td data-hora=${horaEntradaValid} data-horario=${horaEntradaColaborador} style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   				}
                   			}else{
                   				trtd += `
		          			          		
                   	    <td data-hora=${horaEntradaValid} data-horario=${horaEntradaColaborador} style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   			}
            						}

            					}
            					diaconsecuente = fechaConsecuente.getDate()+1;
            					dateafter= fechaConsecuente.getFullYear()+"-"+(fechaConsecuente.getMonth()+1)+"-"+diaconsecuente;
            					fechaConsecuente = new Date(dateafter+" 00:00:00");
          					}
          					else{
          						if(date.getTime()>fechaConsecuente.getTime()){
          							var fechaCurrent=fechaConsecuente.getDate()-1;
													for(fechaCurrent; fechaCurrent<date.getDate(); fechaCurrent++){
														const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCurrent<10 ? "0"+fechaCurrent : fechaCurrent;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
									          var semaforoIncapacidad="";
														
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td><td></td>
                   	    <td class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td><td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}
																}
																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td><td></td>
                   	    <td class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
																	}
																	
															}
															}else{
																trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
															}
															
															
														
													}
          						}
            						var fechaEntrada = numerodias[date.getDate()] + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();

            						for (const f in s){
            							const dateSalida = new Date(s[f].fecha);
            							semaforoSalida="";
            							var fechaSalida = numerodias[dateSalida.getDate()] + "/" + nombremeses[dateSalida.getMonth()] + "/" + dateSalida.getFullYear();
            							if(c[d].id==s[f].idPersona){
            							if(fechaEntrada==fechaSalida){
            								horaSalida = dateSalida.toLocaleTimeString('en-US');
            								var horaSalidaValid = dateSalida.toLocaleTimeString('it-IT');
            								if(horaSalidaValid<horaSalidaColaborador){
            					styleSalida="color: #CD1629;";
            				}
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+"-"+anteriorFecha.getMonth()+"-"+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td style='${styleSalida}'>${horaSalida}</td>
                   	    <td>${medioSalida}</td>
                   				`;
                   				semaforoSalida="entro"
                   				//poner otro semaforo
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
            							}
            						}
            						}
            						}
            						if(semaforoSalida!="entro"){
            							if(dateAnteriorImpresa!=""){
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+anteriorFecha.getMonth()+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+date.getMonth()+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   				}
                   			}else{
                   				trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;${styleEntrada}">${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   			}
            						}

            					diaconsecuente = date.getDate()+2;
            					dateafter= date.getFullYear()+"-"+(date.getMonth()+1)+"-"+diaconsecuente;
            					fechaConsecuente = new Date(dateafter+" 00:00:00");
          					}
          					semaforoColaborador="entro";
            			}
            		
            		}
            		if(semaforoColaborador!="entro"){
            			var fechaCont=fechaInicio.getDate();
								for(fechaCont; fechaCont<=fechaFin.getDate(); fechaCont++){
									const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCont<10 ? "0"+fechaCont : fechaCont;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
													
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td>
                   	    <td></td>
                   	    <td class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td>
                   	    <td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}
																}

																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td>
                   	    <td></td>
                   	    <td class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
																	}
															}
															}else{
																trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
															}
                   			
								}
            		}else{
            			dtImp= new Date(dateimpreso);
            			let mesimpreso= (dtImp.getMonth()+1)<10 ? "0"+(dtImp.getMonth()+1) : (dtImp.getMonth()+1);
            		fechaImpresa= dtImp.getFullYear()+"-"+mesimpreso+"-"+dtImp.getDate();
            		if(fechaImpresa!=rango2){
            			var fechaAfterImpresa=dtImp.getFullYear()+"-"+mesimpreso+"-"+(dtImp.getDate()+1);
            			var dtAftImp= new Date(fechaAfterImpresa+" 00:00:00");
            			var fechaCont=dtAftImp.getDate();
								for(fechaCont; fechaCont<=fechaFin.getDate(); fechaCont++){
									const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCont<10 ? "0"+fechaCont : fechaCont;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
														
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td><td></td>
                   	    <td class="text-center"><i class='fa fa-plane' style='color: #2AA828;font-size: 22px;'></i></td><td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}

																}

																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td><td></td>
                   	    <td class="text-center"><i class='fa fa-bed' style='color: #33B5FF;font-size: 22px;'></i></td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-calendar-check-o" style='color: #F37E1D;'></i></span></td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
																	}}
															}else{
																trtd += `
		          			          		
                   	    <td style="border-left: solid 1px #472380;" class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   	    <td class="text-center"><span class="seg-icon-noasist"><i class="fa fa-times-circle"></i></span></td><td></td>
                   				`;
															}
                   				
								}
            		}
            		}
            		
            		trtd += `
            		</tr>
            		`;
            	}

            	$('.list-body-table-presentdayReporte').html(trtd);
            },
            error: (error) => {
                swal("¡Uups!", error, "error");
            }
          });
agregarFiltro();
getAssistenceExport();
	}
</script>

<script>
	function getAssistenceExport(){
			const rango1 = document.getElementById('FchAssistenceReport1').value;
			const rango2 = document.getElementById('FchAssistenceReport2').value;
			var fechaInicio = new Date(rango1+" 00:00:00");
			var fechaFin = new Date(rango2+" 23:00:00");
			var thFecha =  ``;
			var permiso = document.getElementById('permisos').value;
		var trHora =  ``;
		var thFechaExport =  ``;
		var trHoraExport =  ``;
		var fechaCurrent=fechaInicio.getDate();
				for(fechaCurrent; fechaCurrent<=fechaFin.getDate(); fechaCurrent++){
		          const month="0"+(fechaInicio.getMonth()+1);
		          let diaCero = fechaCurrent<10 ? "0"+fechaCurrent : fechaCurrent;
		          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
		          const fechaComplete = fechaDia+" 00:00:00";
		          var finde= new Date(fechaComplete);
		         
		          	fechaFinal = numerodias[finde.getDate()] + "/" + nombremeses[finde.getMonth()] + "/" + finde.getFullYear();
		          	console.log(fechaFinal);
		           
					thFechaExport+= `<th colspan="6">${fechaFinal}</th>`;

					trHoraExport+= `<th>Horario</th><th colspan="2">Hora Entrada</th><th>Horario</th><th colspan="2">Hora Salida</th>`;
		          
		        }
		$('#thFecha-export-day').html(`<th></th><th></th><th></th>${thFechaExport}`);
		$('#trHora-export-day').html(`<th>Nombre</th><th>Puesto</th><th>Area</th>${trHoraExport}`);
		//console.log(correo,dia);
		$.ajax({
            type: "GET",
            url: `${base}getAssistenceReport`,
            data: {
                dt1: rango1,
                dt2: rango2,
                permiso: permiso
            },
            success: (data) =>{
            		//console.log(data);
            	const r = JSON.parse(data);
            	console.log(data);
            	//console.log(r);
            	var trtd = ``;
            	var horaEntrada = "";
            	var medioEntrada="";
            	var fecha = "";
            	var horaSalida = "";
            	var medioSalida="";
            	var nombre ="";
            	const a = r['asistencia'];
            	const s = r['salida'];
            	const c = r['colaboradores'];
            	const v = r['vacations'];
            	const nl = r['nolaborales'];
            	const i = r['incapacidad'];
            	var semaforo="";
            	var semaforoHora="";
            	var td="";
            	var idAnterior="";
            	var idAnteriorSec="";
            	var semaforoSalida="";
            	var dateAnteriorImpresa="";
            	var fechaAnteriorImpresa="";
            	var fechaCurrent="";
            	var dateimpreso="";


            	//Se recorre a todos los colaboradores
            	for (const d in c){
            		var semaforoColaborador="";
            		var dateAnteriorImpresa="";
            		var dateimpreso="";
            		var fechaConsecuente="";
            		var dateafter="";
            		var diaconsecuente ="";
            		var validFinde="";
            		diaconsecuente = fechaInicio.getDate()+1;
            		dateafter = fechaInicio.getFullYear()+"-"+(fechaInicio.getMonth()+1)+"-"+diaconsecuente;
            		fechaConsecuente = new Date(dateafter+" 00:00:00");
            		trtd += `
                   	<tr data-id="${c[d].id}">
                   	    <td data-newvalue="${c[d].id}">${c[d].nombre}</td>
                   	    <td data-newvalue="${c[d].idPuesto}">${c[d].personaPuesto}</td>
                   	    <td data-newvalue="${c[d].idColaboradorArea}">${c[d].colaboradorArea}</td>
                   	    `;
            		
            		
            		//se recorren las asistencias y se valida que el colaborador tenga registros
            		for (const e in a){
            			if(c[d].id==a[e].idPersona){
            				const date = new Date(a[e].fecha);
            				horaEntrada = date.toLocaleTimeString('en-US');
            				medioEntrada= a[e].comentario==="v3" ? "V3" : "H";
            				console.log(c[d].id, fechaConsecuente);
		switch(date.getDay()){
            				case 1:
            					horaEntradaColaborador=c[d].entradaLunes;
            					horaSalidaColaborador=c[d].salidaLunes;
            					break;
            				case 2: 
            					horaEntradaColaborador=c[d].entradaMartes;
            					horaSalidaColaborador=c[d].salidaMartes;
            					break;
            				case 3:
            					horaEntradaColaborador=c[d].entradaMiercoles;
            					horaSalidaColaborador=c[d].salidaMiercoles;
            					break;
            				case 4:
            					horaEntradaColaborador=c[d].entradaJueves;
            					horaSalidaColaborador=c[d].salidaJueves;
            					break;
            				case 5:
            					horaEntradaColaborador=c[d].entradaViernes;
            					horaSalidaColaborador=c[d].salidaViernes;
            					break;
            				case 6:
            					horaEntradaColaborador=c[d].entradaSabado;
            					horaSalidaColaborador=c[d].salidaSabado;
            					break;
            				}
            				if(date.getTime()>=fechaInicio.getTime() && date.getTime()<=fechaConsecuente.getTime()){//revisar aqui

            					if(date.getTime()<=fechaFin.getTime()){
            						var fechaEntrada = numerodias[date.getDate()] + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();

            						for (const f in s){
            							const dateSalida = new Date(s[f].fecha);
            							semaforoSalida="";
            							var fechaSalida = numerodias[dateSalida.getDate()] + "/" + nombremeses[dateSalida.getMonth()] + "/" + dateSalida.getFullYear();
            							if(c[d].id==s[f].idPersona){
            							if(fechaEntrada==fechaSalida){
            								horaSalida = dateSalida.toLocaleTimeString('en-US');
            								medioSalida= s[f].comentario=="v3" ? "V3" : "H";
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+"-"+anteriorFecha.getMonth()+"-"+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td>${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
						<td>${horaSalidaColaborador}</td>
                   	    <td>${horaSalida}</td>
                   	    <td>${medioSalida}</td>
                   				`;
                   				semaforoSalida="entro"
                   				//poner otro semaforo
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
            							}
            						}
            						}
            						}
            						if(semaforoSalida!="entro"){
            							if(dateAnteriorImpresa!=""){
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+anteriorFecha.getMonth()+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+date.getMonth()+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td >${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
						<td>${horaSalidaColaborador}</td>
                   	    <td>S/R</td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   				}
                   			}else{
                   				trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td >${horaEntrada}</td>
                   	    <td data-comen="${a[e].comentario}">${medioEntrada}</td>
						<td>${horaSalidaColaborador}</td>
                   	    <td>S/R</td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   			}
            						}

            					}
            					diaconsecuente = fechaConsecuente.getDate()+1;
            					dateafter= fechaConsecuente.getFullYear()+"-"+(fechaConsecuente.getMonth()+1)+"-"+diaconsecuente;
            					fechaConsecuente = new Date(dateafter+" 00:00:00");
          					}
          					else{
          						if(date.getTime()>fechaConsecuente.getTime()){
          							var fechaCurrent=fechaConsecuente.getDate()-1;
													for(fechaCurrent; fechaCurrent<date.getDate(); fechaCurrent++){
														const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCurrent<10 ? "0"+fechaCurrent : fechaCurrent;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
									          var semaforoIncapacidad="";
														
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>V</td><td></td>
                   	    <td></td><td>V</td><td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}
																}
																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>I</td><td></td>
                   	    <td></td><td>I</td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td></td><td>DNL</td><td></td>
                   	    <td></td><td>DNL</td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
																	}
																	
															}
															}else{
																trtd += `
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
															}
															
															
														
													}
          						}
            						var fechaEntrada = numerodias[date.getDate()] + "/" + nombremeses[date.getMonth()] + "/" + date.getFullYear();

            						for (const f in s){
            							const dateSalida = new Date(s[f].fecha);
            							semaforoSalida="";
            							var fechaSalida = numerodias[dateSalida.getDate()] + "/" + nombremeses[dateSalida.getMonth()] + "/" + dateSalida.getFullYear();
            							if(c[d].id==s[f].idPersona){
            							if(fechaEntrada==fechaSalida){
            								horaSalida = dateSalida.toLocaleTimeString('en-US');
            								medioSalida= s[f].comentario=="v3" ? "V3" : "H";
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+"-"+anteriorFecha.getMonth()+"-"+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+"-"+date.getMonth()+"-"+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td>${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
						<td>${horaSalidaColaborador}</td>
                   	    <td>${horaSalida}</td>
                   	    <td>${medioSalida}</td>
                   				`;
                   				semaforoSalida="entro"
                   				//poner otro semaforo
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
            							}
            						}
            						}
            						}
            						if(semaforoSalida!="entro"){
            							if(dateAnteriorImpresa!=""){
            								anteriorFecha= new Date(dateAnteriorImpresa);
            								fechaAnteriorImpresa=anteriorFecha.getFullYear()+anteriorFecha.getMonth()+anteriorFecha.getDate();
            								fechaCurrent=date.getFullYear()+date.getMonth()+date.getDate();
            								if(fechaAnteriorImpresa!=fechaCurrent){
            									trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td >${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
						<td>${horaSalidaColaborador}</td>
                   	    <td>S/R</td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   				}
                   			}else{
                   				trtd += `
		          			          		
						<td>${horaEntradaColaborador}</td>
                   	    <td >${horaEntrada}</td>
                   	    <td>${medioEntrada}</td>
                   	    <td>${horaSalidaColaborador}</td>
                   	    <td>S/R</td>
                   	    <td></td>
                   				`;
                   				semaforoColaborador="entro";
                   				dateAnteriorImpresa=date;
                   				dateimpreso=date;
                   			}
            						}

            					diaconsecuente = date.getDate()+2;
            					dateafter= date.getFullYear()+"-"+(date.getMonth()+1)+"-"+diaconsecuente;
            					fechaConsecuente = new Date(dateafter+" 00:00:00");
          					}
          					semaforoColaborador="entro";
            			}
            		
            		}
            		if(semaforoColaborador!="entro"){
            			var fechaCont=fechaInicio.getDate();
								for(fechaCont; fechaCont<=fechaFin.getDate(); fechaCont++){
									const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCont<10 ? "0"+fechaCont : fechaCont;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
														
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>V</td><td></td>
                   	    <td></td><td>V</td><td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}
																}

																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>I</td><td></td>
                   	    <td></td><td>I</td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td></td><td>DNL</td><td></td>
                   	    <td></td><td>DNL</td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
																	}
															}
															}else{
																trtd += `
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
															}
                   			
								}
            		}else{
            			dtImp= new Date(dateimpreso);
            			let mesimpreso= (dtImp.getMonth()+1)<10 ? "0"+(dtImp.getMonth()+1) : (dtImp.getMonth()+1);
            		fechaImpresa= dtImp.getFullYear()+"-"+mesimpreso+"-"+dtImp.getDate();
            		if(fechaImpresa!=rango2){
            			var fechaAfterImpresa=dtImp.getFullYear()+"-"+mesimpreso+"-"+(dtImp.getDate()+1);
            			var dtAftImp= new Date(fechaAfterImpresa+" 00:00:00");
            			var fechaCont=dtAftImp.getDate();
								for(fechaCont; fechaCont<=fechaFin.getDate(); fechaCont++){
									const month="0"+(fechaInicio.getMonth()+1);
									          let diaCero = fechaCont<10 ? "0"+fechaCont : fechaCont;
									          const fechaDia= fechaInicio.getFullYear()+"-"+month+"-"+diaCero;
									          const fechaComplete = fechaDia+" 00:00:00";
									          validFinde= new Date(fechaComplete);
									          var semaforoVacaciones="";
													
															if(!(validFinde.getDay()===6)||!(validFinde.getDay()===0)){
																for (const l in v){
																if(c[d].id==v[l].idPersona){
																	vacationsInicio= new Date(v[l].fecha);
																	diaEnd=vacationsInicio.getDate()+parseInt(v[l].valor);
																	dayVacas=diaEnd<10 ? "0"+diaEnd : diaEnd;
																	const mesvacas="0"+(vacationsInicio.getMonth()+1);
																	dateVacasFin=vacationsInicio.getFullYear()+"-"+mesvacas+"-"+dayVacas+" 00:00:00";
																	vacationsFin= new Date(dateVacasFin);
																	if(validFinde.getTime()>= vacationsInicio.getTime() && validFinde.getTime()<vacationsFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>V</td><td></td>
                   	    <td></td><td>V</td><td></td>
                   				`;
                   						semaforoVacaciones="entro";
																	}

																}

																}
																for (const h in i){
																if(c[d].id==i[h].idPersona){
																	incapacidadInicio= new Date(i[h].fecha);
																	diaIncapacidadEnd=incapacidadInicio.getDate()+parseInt(i[h].valor);
																	dayIncapacidad=diaIncapacidadEnd<10 ? "0"+diaIncapacidadEnd : diaIncapacidadEnd;
																	const mesincap="0"+(incapacidadInicio.getMonth()+1);
																	dateIncapFin=incapacidadInicio.getFullYear()+"-"+mesincap+"-"+dayIncapacidad+" 00:00:00";
																	incapacidadFin= new Date(dateIncapFin);
																	if(validFinde.getTime()>= incapacidadInicio.getTime() && validFinde.getTime()<incapacidadFin.getTime()){
																		trtd += `
		          			          		
                   	    <td></td><td>I</td><td></td>
                   	    <td></td><td>I</td><td></td>
                   				`;
                   						semaforoIncapacidad="entro";
																	}
																}
																}

																if(semaforoVacaciones!="entro" && semaforoIncapacidad!="entro"){
																	var semaforoNolaboral="";
																	for (const m in nl){
																		if(fechaDia==nl[m].diaNoLaboral){
																			trtd += `
		          			          		
                   	    <td></td><td>DNL</td><td></td>
                   	    <td></td><td>DNL</td><td></td>
                   				`;
                   				semaforoNolaboral="entro";
																		}
																	}
																	if(semaforoNolaboral!="entro"){
																		trtd += `
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
																	}}
															}else{
																trtd += `
		          			          		
                   	    <td></td><td>S/R</td><td></td>
                   	    <td></td><td>S/R</td><td></td>
                   				`;
															}
                   				
								}
            		}
            		}
            		
            		trtd += `
            		</tr>
            		`;
            	}

				$('.body-export-day').html(trtd);
            }
          });
	}
</script>