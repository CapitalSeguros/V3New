<? $prospectosEnEmision = ''; ?>

<div style="display: flex; flex-direction: row;">
	<div style="flex: 1;display: flex">
		<form id="formBuscarCliente" method="GET" action="<?= base_url() ?>crmproyecto" style="display: flex; flex-direction: row;">
			<input type="text" name="busquedaUsuario" id="busquedaUsuario" placeholder="Buscar entre la lista de Prospectos">
			<button title="Buscar" onclick="buscarCliente(event)">&#128270</button>
		</form>
	</div>


	<? if ($imprimirSelecVendedor) { ?>
		<div style="flex: 2;display: flex;">
			<select id="selectVendedorProspectoPersona" style="width: 100%" name="selectVendedor"><?= imprimirSelecPersonas($personaTipoPersonaCatalogo, $emailVendedor) ?></select>
			<button onclick="cargarPaginaDatos('crmproyecto/seguimientoProspecto/','filtraEnSeguimiento')">&#128270</button>

		</div>

	<? } ?>
	&nbsp;

	<!--Miguel Jaime 13-02-2023-->
	<div style="flex: 1;display: flex;">
		<select id="selectBantAut" style="width: 100%" name="selectBantAut" placeholder="">
			<option value="0">Nivel BANT-Authorithy</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		<button onclick="filterByBant('AUTH')">&#128270</button>

	</div>
	&nbsp;
	<div style="flex: 1;display: flex;">
		<select id="selectBantNeed" style="width: 100%" name="selectBantNeed" placeholder="">
			<option value="0">Nivel BANT-Need</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
		<button onclick="filterByBant('NEED')">&#128270</button>

	</div>
	&nbsp;
	<div style="flex: 1;display: flex;">
		<select id="selectBantTiming" style="width: 100%" name="selectBantTiming" placeholder="">
			<option value="0">Nivel BANT-Timing</option>
			<option value="Inmediato">Inmediato</option>
			<option value="Sin urgencia">Sin urgencia</option>
			<option value="Largo plazo">Largo plazo</option>
		</select>
		<button onclick="filterByBant('TIMING')">&#128270</button>

	</div>

</div>

<div class="col-sm-12 col-md-12">
	<div class="collapse mt-4 mb-4 visible" id="guion_tel">
		<div class="card card-body">
			<h4>Guión telefónico</h4>
			<div class="row">
				<div class="col-md-2 visible">
					<div class="list-group" id="myList" role="tablist">
						<?php if (!empty($guionTelefonico)) {
							foreach ($guionTelefonico as $id => $d_g) { ?>
								<a class="list-group-item list-group-item-action" data-toggle="list" href="#g_<?= $id ?>" role="tab"><?= $d_g["nombre"] ?></a>
						<?php }
						} ?>

					</div>
				</div>
				<div class="col-md-10 visible">
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane bg-white active" id="inicio" role="tabpanel">
							<h3 class="text-center mt-12 mb-10">Visualice cualquier de los ejemplos del lado izquierdo</h3>
						</div>
						<?php if (!empty($guionTelefonico)) {
							foreach ($guionTelefonico as $id => $d_g) { ?>
								<div class="tab-pane bg-white" id="g_<?= $id ?>" role="tabpanel">
									<h4>Ejemplo de guía telefónica (Guión para referidos)</h4>
									<br>
									<div class="ml-4">
										<?php foreach ($d_g["mensaje"] as $conversacion) { ?>
											<span class="badge badge-primary mb-2"><?= $conversacion["etiqueta"] ?></span><br>
											<p class="text-dark font-italic"><?= $conversacion["texto"] ?></p><br>
										<?php } ?>
									</div>
								</div>
						<?php }
						} ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!------------------->
</div>
<br>
<style type="text/css">
	.botonesInformativos {
		display: flex
	}

	.botonesInformativos>div {
		flex: 1;
		display: flex;
	}

	.botonesInformativos>div>div>label:nth-child(1) {
		color: white;
		background-color: #03a30385;
		border: solid 1px #03a30385;
		flex: 4;
	}

	.botonesInformativos>div>div>label:nth-child(2) {
		border: solid 1px #03a30385;
		flex: 2;
	}

	.botonesInformativos>div>div>label:nth-child(2):hover {
		color: red;
	}

	.botonesInformativos>div>div>div:nth-child(3) {
		flex: 2;
		display: flex;
		flex-direction: column;
		max-width: 20px;
	}

	.botonesInformativos>div>div>div:nth-child(3)>label:hover {
		background-color: green;
		border: solid
	}

	.botonesInformativos>div>div>div:nth-child(3)>label {
		font-size: 20px;
		border: solid 1px black;
		height: 87%
	}


	.botonesInformativos>div>div>div:nth-child(3)>div {
		flex-direction: column;
		z-index: 100;
		color: black;
		background-color: white;
		border: solid;
	}

	.puntosMes {
		position: relative;
		left: -1000%;
		width: 200px
	}

	.contenedorPuntosDiv {
		display: flex;
		justify-content: space-between
	}

	.contenedorPuntosDiv>div:nth-child(1) {
		flex: 3;
	}

	.contenedorPuntosDiv>div:nth-child(2) {
		flex: 2;
	}

	.contenedorPuntosDiv>div:nth-child(3) {
		flex: 1;
	}

	.contenedorPuntosDiv>div:nth-child(4) {
		flex: 1;
	}

	.puntosMes>div {
		display: flex;
		flex-direction: column;
		height: 200px;
		overflow: scroll;
	}

	.puntosMes>div>div:nth-child(even) {
		background-color: #03a30385
	}

	@media only screen and (min-width:1001px) {
		.botonesInformativos>div {
			flex-direction: row;
		}

		.puntosMes {
			left: -1150%;
			top: 0%;
		}

		.botonesInformativos>div>div>div:nth-child(3)>div {
			width: 1500%;
		}
	}

	@media only screen and (max-width:1000px) {
		.puntosMes {
			left: -300%;
			top: 40%
		}

		.botonesInformativos>div {
			flex-direction: column;
		}

		.botonesInformativos>div>div>div:nth-child(3)>div {
			width: 1000%;
		}
	}
</style>
<script type="text/javascript">

</script>
<div class="botonesInformativos">
	<div>
		<div id="prospectosTotalInfo" class="botonInformativo"><label>SUSPECTOS </label><label id="prospectosTotalInfoLabel"></label> </div>
		<div id="suspectosTotalInfo" class="botonInformativo"><label>PROSPECTOS </label><label id="suspectosTotalInfoLabel"></label></div>
		<div id="perfiladosTotalInfo" class="botonInformativo"><label>PERFILADOS </label><label id="perfiladosTotalInfoLabel"></label></div>
	</div>
	<div>
		<div id="cotizadosTotalInfo" class="botonInformativo"><label>COTIZADOS</label><label id="cotizadosTotalInfoLabel"></label></div>
		<div id="pagadosTotalInfo" class="botonInformativo">
			<label>PUNTOS MES ACTUAL <?= $puntosMesActual ?></label>
			<label id="pagadosTotalInfoLabel"><?= $puntosMesActual ?></label>
			<div>
				<label onclick="verOcultar('puntosMesesProspectos')">&#8595</label>
				<div class="puntosMes ocultarObjeto" id="puntosMesesProspectos">
					<div>
						<?= imprimirPuntosMeses($anioEnCurso, $anioAnterior) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.tablaColumnaFija {
		width: 90%;
		height: 500px;
		overflow: scroll;
	}

	.tablaColumnaFija thead {
		position: sticky;
		top: 0px
	}

	.botonInformativo {
		width: 50px;
		height: 40px;
		flex: 1;
		background-color: white;
		color: black;
		border: none;
		margin-left: 5px;
		display: flex
	}
</style>
<div class="tablaColumnaFija" id="panel">
	<!--div class="panel-body">
				<div class="table-responsive divContTabla"-->

	<table class="table" id='Mitabla'>
		<thead>
			<tr style="font-size: 11px;">
				<th></th>
				<th>ID</th>
				<th style="text-align: center;"><i class="fa fa-calendar"></i></th>
				<th>RazonSocial</th>
				<th>ApellidoP</th>
				<th>Nombre</th>
				<th>Estado Actual</th>
				<th style="text-align: center;">Authorithy</th>
				<th style="text-align: center;">Need</th>
				<th style="text-align: center;">Timing</th>
				<th style="text-align: center;"><i class="fa fa-comment"></i></th>
				<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
				<th style="text-align: center;">Guardar Cita</th>
				<?php if (in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"])) { ?> <th style="text-align: center;">Guardar Cita (prototipo)</th> <?php } ?>
				<th style="text-align: center;">Detección necesidades</i></th>
				<th style="text-align: center;"><i class="fa fa-cogs"></i></th>
				<th style="text-align: center;"><i class="fa fa-paperclip"></i>&nbsp;Entrega propuesta</th>
				<?php if (in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"])) { ?> <th style="text-align: center;">Entrega propuesta (prototipo)</th> <?php } ?>
				<th style="text-align: center;"><i class="fa fa-file-text"></i></th>
				<th>Pagado</th>
			</tr>
		</thead>
		<tbody>
			<?
			$prospectoCount = 0;
			$suspectoCount = 0;
			$perfiladosCount = 0;
			$cotizadosCount = 0;
			$emisionCount = 0;
			$pagadosCount = 0;
			if ($ListaClientes != FALSE) { ?>
				<tr style="background-color:#ebe6e6">
					<td onclick="abrirCerrar(this,'HOY')">►</td>
					<td colspan="15">HOY</td>
				</tr>
				<? $cont = 0;
				$nombrePestania = "";
				$prospectosEnEmision = "";
				$nombrePestania = "HOY";

				foreach ($ListaClientes as $row) {
					$prospectoCount++;
					if ($row->estaEmitido == 0) {
						if ($nombrePestania != $row->pestania) { ?>
							<tr style="background-color:#ebe6e6">
								<td onclick="abrirCerrar(this,'<?= $row->pestania ?>')">►</td>
								<td colspan="15"><?= $row->pestania; ?></td>
							</tr> <? }
								$nombrePestania = $row->pestania; ?>
						<?php if ($row->tipo_prospecto == 0 || $row->tipo_prospecto == 1) { ?>
							<tr class="<?= $row->pestania; ?> ocultarObjeto">

								<td style="text-align: center;">
									<?php $fecha = date("Y-m-d", strtotime($row->fechaCreacionCA)); ?>
									<a href="#" onclick="verDetalle(this,'<?= $row->RFC ?>','<?= $row->RazonSocial ?>','<?= $row->Nombre ?>','<?= $row->ApellidoP ?>','<?= $row->ApellidoM ?>','<?= $row->EMail1 ?>','<?= $row->Telefono1 ?>','<?php echo $fecha; ?>','<?= $row->EstadoActual; ?>','<?php echo preg_replace('/[\r\n]+/',  '', $row->observacion); ?>')"><i class="fa fa-eye"></i></a>
								</td>
								<td style="text-align: center;"><input type="checkbox" class="cbReasignar" value="<?= $row->IDCli ?>"></button></td>
								<td><?php if ($row->fechaCreacionCA != null) {
										echo (date("Y-m-d", strtotime($row->fechaCreacionCA)));
									} ?></td>
								<td><?= $row->RazonSocial ?></td>
								<td><?= $row->ApellidoP ?></td>
								<td><?= $row->Nombre ?></td>
								<?

								switch ($row->EstadoActual) {
									case 'DIMENSION':
										$suspectoCount++;
										break;
									case 'PAGADO':
										$pagadosCount++;
										break;
									case 'PERFILADO':
										$perfiladosCount++;
										break;
									case 'COTIZADO':
										$cotizadosCount++;
										break;
								}
								?>
								<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;"><? echo estado($row->EstadoActual); ?></span></td>

								<td style="text-align: center;">
									<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
										<?php echo $row->bant_aut ?>
									</span>
								</td>

								<td style="text-align: center;">
									<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
										<?php echo $row->bant_need ?>
									</span>
								</td>

								<td style="text-align: center;">
									<span class="badge badge-warning" style="font-size: 11px;font-weight: normal;background-color: orange;color: black;">
										<?php echo $row->bant_timing ?>
									</span>
								</td>




								<td style="text-align: center;"><button onclick="direccionAJAX(<?= $row->IDCli ?>,'muestraVentana')" class="btn btn-primary btn-xs ">Comentarios</button></td>
								<td>
									<?
									$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '" . $row->IDCli . "'";
									$queryEstaPerfilado = $this->db->query($sqlEstaPerfilado);
									if (!empty($queryEstaPerfilado)) {
										foreach ($queryEstaPerfilado->result() as $Registro) {
											$estaperfilado = $Registro->numero;
										}
									}
									if ($estaperfilado > 0) {
										echo "Perfilado";
									} else {
									?>
										<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,<?= $row->IDCli ?>)" style="background-color: #01A9DB;">Perfilar</button>
									<? } ?>
								</td>

								<td style="text-align: center;"><button onclick="direccionAJAX(<?= $row->IDCli ?>,'ventanaCCC')" class="btn btn-primary btn-xs" style="background-color: #01A9DB;">Contacto</button></td>
								<?php if (in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"])) { ?> <td style="text-align: center;"><button class="btn btn-primary btn-xs generateEvent" p="<?= $row->IDCli ?>" m="prpt">Contacto</button></td> <?php } ?>
								<td style="text-align: center;">
									<a href="<?= base_url() ?>crmproyecto/deteccion_necesidades?IDCL=<?= $row->IDCli ?>" class='btn btn-primary btn-xs contact-item' target="_blank" style="background-color: #01A9DB;">1er Cita
									</a>
								</td>

								<td>
									<?
									$sqlEstaCotizado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='COTIZADO' and pj.IDCliente ='" . $row->IDCli . "'";
									$queryEstaCotizado = $this->db->query($sqlEstaCotizado);
									if (!empty($queryEstaCotizado)) {
										foreach ($queryEstaCotizado->result() as $Registro) {
											$estacotizado = $Registro->numero;
										}
									}
									if ($estacotizado > 0) {
										if ($row->folioActividad == '') {
											echo "Cotizado";
										} else {
											echo '<a href="' . base_url() . 'actividades/ver/' . $row->folioActividad . '" target="_blank"><button class="btn btn-success btn-xs contact-item">Emitir</button</a>';
										}
									} else {
									?>


										<!--Modificacion MJ 21-07-2021 -->
										<?php
										$fianzas = $row->leads;
										if ($fianzas == "http://www.fianzascapital.com.mx") { ?>

											<a href="#" onclick="cargarPagina1('crmproyecto/CotizacionFianzas',<?= $row->IDCli ?>)" class='btn btn-primary btn-xs contact-item' data-original-title style="background-color: #01A9DB;"><span class="glyphicon glyphicon-pencil"></span>Cotizador Express
											</a>

											<a href="<?= base_url() . "actividades/actividadNuevaProspeccion?IDCL=" . $row->IDCli . "&SelectRamo=FIANZAS&SelectSubRamo=70" ?>" target="_blank" class='btn btn-primary btn-xs contact-item' data-original-title style="background-color:#01A9DB;">
												<span class="glyphicon glyphicon-pencil"></span>Cotizar
											</a>
										<?php } else { ?>
											<a href="<?= base_url() ?>actividades/actividadNuevaProspeccion?IDCL=<?= $row->IDCli ?>" target="_blank" class='btn btn-primary btn-xs contact-item' data-original-title style="background-color: #01A9DB;"><span class="glyphicon glyphicon-pencil"></span>Cotizar
											</a>
									<? }
									} ?>
									<!-- fin Modificaciones-->
								</td>

								<td style="text-align: center;">
									<a href="#" onclick="direccionAJAX(<?= $row->IDCli ?>,'ventanaCCC')">
										<button class="btn btn-primary btn-xs" style="background-color: #01A9DB;">2da Cita</button>
									</a>
								</td>
								<?php if (in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"])) { ?>
									<td style="text-align: center;">
										<button class="btn btn-primary btn-xs generateEvent" p="<?= $row->IDCli ?>" m="prpt" style="background-color: #01A9DB;">2da Cita</button>
									</td>
								<?php } ?>

								<td style="text-align: center;"><button onclick="traerDocumentos('',<?= $row->IDCli ?>,'<?= $row->IDCliSikas ?>')" class="btn btn-primary btn-xs ">VER COTIZACION</button>
								</td>

								<td>

								<td>
									<?
									$sqlEstaPagado = "Select count(IDCliente) as numero From puntaje pj Where pj.EdoActual='PAGADO' and pj.IDCliente ='" . $row->IDCli . "'";
									$queryPagado = $this->db->query($sqlEstaPagado);
									if (!empty($queryPagado)) {
										foreach ($queryPagado->result() as $Registro) {
											$estapagado = $Registro->numero;
										}
									}
									if ($estapagado > 0) {
										echo "Pagado";
									} else {
										if ($row->folioActividad != '') {
									?>

											<div class="btn-group" style="overflow: all;width: 200px">
												<?php if ($row->Documento == '') { ?>
													<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button>
													<?php } else {
													if ($row->pagado == 1) {
													?>
														<a class="btn btn-primary btn-xs contact-item" href="<?= base_url() ?>crmproyecto/muestraRecibos?Documento=<?= $row->Documento ?>" target="_blank">Recibos<span class="badge">✔</span></a>
													<?php
													} else { ?>
														<button class="btn btn-primary btn-xs contact-item" onclick="verificarPago('','<?= $row->folioActividad; ?>',<?= $row->IDCli; ?>,this)">Verificar pago</button>
														<a class="btn btn-primary btn-xs contact-item" href="<?= base_url() ?>crmproyecto/muestraRecibos?Documento=<?= $row->Documento ?>" target="_blank">Recibos<span class="badge">X</span></a>
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
					} else {

						$fecha = date("Y-m-d", strtotime($row->fechaCreacionCA));
						$estadoActual = '<button class="btn btn-primary btn-xs" onclick="perfilarProspecto(this,' . $row->IDCli . ')" style="background-color: #01A9DB;">Perfilar</button>';

						$sqlEstaPerfilado = "select count(IDCliente) as numero from puntaje pj where pj.EdoActual = 'PERFILADO' and pj.IDCliente = '" . $row->IDCli . "'";
						$estaPerfilado = $this->db->query($sqlEstaPerfilado)->result();
						if ($estaPerfilado == 0) {
							$estadoActual = "Perfilado";
						}


						$primeraCita = '<a href="' . base_url() . 'crmproyecto/deteccion_necesidades?IDCL=' . $row->IDCli . '" class="btn btn-primary btn-xs contact-item"   target="_blank" style="background-color: #01A9DB;">1er Cita</a>';



						$segundaCita = '<a href="#"  onclick="direccionAJAX(' . $row->IDCli . ',\'ventanaCCC\')">
									<button class="btn btn-primary btn-xs" style="background-color: #01A9DB;">2da Cita</button>
									</a>';
						$verDocumento = '<button onclick="traerDocumentos(\'\',' . $row->IDCli . ',\'' . $row->IDCliSikas . '\')" class="btn btn-primary btn-xs ">Ver documento</button>';

						$prospectosEnEmision .= '<tr><td style="text-align: center;"><a href="#" onclick="verDetalle(this, \'' . $row->RFC . '\',\'' . $row->RazonSocial . '\',\'' . $row->Nombre . '\',\'' . $row->ApellidoP . '\',\'' . $row->ApellidoM . '\',\'' . $row->EMail1 . '\',\'' . $row->Telefono1 . '\',\'' . $fecha . '\',\'' . $row->EstadoActual . '\',\'' . $row->observacion . '\')"><i class="fa fa-eye"></i></a></td>';
						$prospectosEnEmision .= '<td></td>';
						$prospectosEnEmision .= '<td>' . $fecha . '</td>';
						$prospectosEnEmision .= '<td>' . $row->RazonSocial . '</td>';
						$prospectosEnEmision .= '<td>' . $row->ApellidoP . '</td>';
						$prospectosEnEmision .= '<td>' . $row->Nombre . '</td>';
						$prospectosEnEmision .= '<td><span class="badge badge-secondary" style="font-size: 11px;font-weight: normal;">' . $row->EstadoActual . '</span></td>';
						$prospectosEnEmision .= '<td style="text-align: center;"><button onclick="direccionAJAX(' . $row->IDCli . ',\'muestraVentana\')" class="btn btn-primary btn-xs ">Comentarios</button></td>';
						$prospectosEnEmision .= '<td>' . $estadoActual . '</td>';
						$prospectosEnEmision .= '<td></td>';
						$prospectosEnEmision .= '<td style="text-align: center;">' . $primeraCita . '</td>';
						$prospectosEnEmision .= '<td></td>';
						$prospectosEnEmision .= '<td style="text-align: center;">' . $segundaCita . '</td>';
						$prospectosEnEmision .= in_array($this->tank_auth->get_usermail(), ["DIRECTORGENERAL@AGENTECAPITAL.COM", "DESARROLLO@AGENTECAPITAL.COM"]) ? '<td style="text-align: center;"><button class="btn btn-primary btn-xs generateEvent" p="' . $row->IDCli . '" m="prpt" style="background-color: #01A9DB;">2da Cita</button></td>' : "";
						$prospectosEnEmision .= '<td style="text-align: center;">' . $verDocumento . '</td>';
						$prospectosEnEmision .= '<td></td>';
						$prospectosEnEmision .= '<td></td></tr>';
					}
				}
			}
			?>
			<tr style="background-color:green">
				<td onclick="abrirCerrar(this,'PROSPECTOSEMISION')"></td>
				<td colspan="15">EN EMISION</td>
			</tr>
			<?= $prospectosEnEmision; ?>

		</tbody>
		<?
		$etiquetaResultados = '<center><b>No se encontraron registros.</b></center>';
		if ($totalResultados != 0) {
			$etiquetaResultados = '<medium><i>Total de resultados: <b>' . $totalResultados . '</b></i></medium>';
		}
		?>
		<tfoot>
			<tr>
				<td colspan="13"><?= $etiquetaResultados; ?></td>
			</tr>
			<tr>
				<td>Filtro para buscar pagados:</td>
				<td>Fecha Inicial:<input type="date" id="fInicialProspectoEmitido" value="<?= $primerDiaMes ?>"></td>
				<td>Fecha Final:<input type="date" id="fFinalProspectoEmitido" value="<?= $fechaActual ?>"></td>
				<td><button class="btn btn-success" onclick="buscarProspectosEmitidos('')">&#128270</button></td>
			</tr>
			<tr>
				<td id="tdMuestraPropectosPagados"></td>
			</tr>
			<tr id='trTotalProscpectos'>
				<td><?= $prospectoCount ?></td>
				<td><?= $suspectoCount ?></td>
				<td><?= $perfiladosCount ?></td>
				<td><?= $cotizadosCount ?></td>
				<td><?= $pagadosCount ?></td>
			</tr>
		</tfoot>

	</table>
	<!--/div>
				
            </div--><!-- panel-body -->
</div><!-- panel-default -->

</section><!-- /container-fluid -->
<!-- Fin seccion propecto persona-->

<div id="divModalDocumentos" class="modalCierra">
	<div class="modal-btnCerrar"><button onclick="cerrarModal('divModalDocumentos')" style="color: white;background-color:red; border:double;">X</button></div>
	<div id="
" class="modal-contenido">

	</div>
</div>

<div id="main-app">
	<dialog_ v-if="showModal"></dialog_>
</div>

<?php
function imprimirPuntosMeses($datosActuales, $datosAnteriores)
{
	$cadena = '';
	foreach ($datosActuales as $key => $value) {
		$estapagado = '';
		if ($value['estaPagado'] > 0) {
			$estapagado = '&#9989';
		}
		$cadena .= '<div class="contenedorPuntosDiv"><div>' . $value['mes'] . '</div><div>' . $value['anio'] . '</div><div>' . $value['puntos'] . '</div><div style="border-radius:50% solid black">' . $estapagado . '</div></div>';
	}


	foreach ($datosAnteriores as $key => $value) {
		$estapagado = '';
		if ($value['estaPagado'] > 0) {
			$estapagado = '&#9989';
		}
		$cadena .= '<div class="contenedorPuntosDiv"><div>' . $value['mes'] . '</div><div>' . $value['anio'] . '</div><div>' . $value['puntos'] . '</div><div style="border-radius:50% solid black">' . $estapagado . '</div></div>';
	}

	return $cadena;
}
function imprimirSelecPersonas($datos, $email)
{

	$option = '<optgroup label=""><option data-value="0" value="">Escoger Vendedor</option></optgroup>';
	$selected = '';
	foreach ($datos as $key1 => $value1) {

		$option .= '<optgroup label="' . $key1 . '">';
		foreach ($value1 as $key => $value) {
			if ($value->email == $email) {
				$selected = 'selected="selected"';
			}
			$nombres = $value->apellidoPaterno . ' ' . $value->apellidoMaterno . ' ' . $value->nombres;
			$option .= '<option data-value="' . $value->idPersona . '" value="' . $value->email . '" ' . $selected . '>' . $nombres . ' <label>     (' . $value->email . ')</label></option>';
			$selected = '';
		}
		$option .= '</optgroup>';
	}
	return $option;
}
?>
<style type="text/css">
	.tableMayaMX {
		display: block;
		width: 100%;
	}

	.tableMayaMX>thead {
		display: block;
		overflow-x: hidden;
		/*height: 40px;overflow-y: scroll;*/
	}

	.tableMayaMX>tbody {
		display: block;
		height: 300px;
		overflow: scroll
	}

	.tableMayaMX>tbody,
	thead {
		width: 900px;
	}

	.tableMayaMX>thead>tr>th {
		min-width: 150px
	}

	.tableMayaMX>tbody>tr>td {
		min-width: 150px
	}

	.iconojpg {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconojpj.png'); ?>) no-repeat;
	}

	.iconopdf {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconopdf.png'); ?>) no-repeat;
	}

	.iconoword {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconoword.png'); ?>) no-repeat;
	}

	.iconoxls {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconoxls.png'); ?>) no-repeat;
	}

	.iconoxml {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconoxml.png'); ?>) no-repeat;
	}

	.iconomsg {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconomsg.png'); ?>) no-repeat;
	}

	.iconoblanco {
		width: 100%;
		height: 40px;
		background: url(<? echo (base_url() . 'assets/images/iconoblanco.png'); ?>) no-repeat;
	}

	.iconoemail {
		width: 25px;
		height: 25px;
		background: url(<? echo (base_url() . 'assets/images/iconoEmail.png'); ?>) no-repeat;
	}

	.iconogenerico>a {
		position: relative;
		left: 35px;
		display: flex;
		align-items: center;
		text-decoration: underline;
	}

	.ulDocumentos {
		list-style-type: none;
		width: 100%;
		height: 300px;
		overflow: scroll;
	}
</style>