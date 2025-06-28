<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reporte Capacitaci&oacute;n Agentes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="<?=base_url()?>">Inicio</a></li>
	                <li><a href="./persona/agente">Capital Humano</a></li>
                    <li class="active"><a>Reporte Capacitaci&oacute;n</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
		<div class="panel panel-default">
			<div class="panel-body">
            	<div class="row">

					<form
                    	name="formCoordinador" id="formCoordinador"
                        action="<?= base_url("persona/agenteReporteCapacitacion/")?>"
                        method="post"
                    >
                	<div class="form-group col-sm-12 col-md-12">
                        	<select
                            	name="coordinacion" id="coordinacion"
                            	class="form-control"
								onchange="this.form.submit()"
                            >
								<option selected="selected" value="">Todos</option>
                            	<?
								foreach($CoordinadoresVentas as $coordinador){
									$NombreCompleto	= $coordinador->nombres." ".$coordinador->apellidoPaterno." ".$coordinador->apellidoMaterno
								?>
								<option value="<?=$coordinador->email?>" <?=($coordinacion == $coordinador->email)? "selected":""?>><?=$NombreCompleto." (".$coordinador->email.")"?></option>
                                <?
								}
								?>
                            </select>
                    </div>
					</form>
                </div>
            
            	<table class="table">
                	<thead>
                    	<tr>
	                    	<th>Nombre</th>
    		                <th align="center">certificacion</th>
    		                <th align="center">Autos</th>
    		                <th align="center">Gmm</th>
    		                <th align="center">Vida</th>
    		                <th align="center">Danos</th>
    		                <th align="center">Fianzas</th>
						</tr>
                    </thead>
                    <tbody>
                    	<?
						foreach($Agentes as $agente){
							//print_r($agente);
						?>
                    	<tr>
                        	<td title="Su Coordinador es: <?=$agente->userEmailCreacion?>"><?=$agente->nombres." ".$agente->apellidoPaterno." ".$agente->apellidoMaterno?></td>
                        	<td align="center"><?=$agente->certificacion?></td>
                        	<td align="center"><?=$agente->certificacionAutos?></td>
                        	<td align="center"><?=$agente->certificacionGmm?></td>
                        	<td align="center"><?=$agente->certificacionVida?></td>
                        	<td align="center"><?=$agente->certificacionDanos?></td>
                        	<td align="center"><?=$agente->certificacionFianzas?></td>
                        </tr>
		            	<?
						}
						?>
                    </tbody>
                </table>
            </div>
		</div>
    </section>


<? $this->load->view('footers/footer'); ?>