<?php 
    
    $CI=& get_instance();
    $CI->load->model("crmproyecto_model");

    $cobranzaGeneral=$CI->crmproyecto_model->devuelveTodosLosRegistrosPorRegion();

    $flotante_nuevo.='

									<div class="card" style="margin-top: 5px;">
										<div class="card-header text-center text-dark">
											<a data-toggle="collapse" href="#info_region" role="button" aria-expanded="false" aria-controls="info_region"><i class="fa fa-cogs"></i>&nbspKPI Cobranza<span class="caret"></span></a>
										</div>
										<div class="card-body collapse table-responsive visible" id="info_region">';

											if(!empty($cobranzaGeneral)){

												$flotante_nuevo.='
													<table class="table-sm">
														<thead>
															<tr>
																<td></td>
																<td><span class="label label-info">EFECTUADA</span></td>
																<td><span class="label label-success">A TIEMPO</span></td>
																<td><span class="label label-warning">PENDIENTE</span></td>
																<td><span class="label label-danger">ATRASADA</span></td>
															</tr>
														</thead>
														<tbody>
													';

													$sum_efectuadas=0;
													$sum_pendientes=0;
													$sum_atrasadas=0;
													$sum_a_tiempo=0;

													$sum_efectuadas_seguros=0;
													$sum_pendientes_seguros=0;
													$sum_atrasadas_seguros=0;
													$sum_a_tiempo_seguros = 0;

													$sum_efectuadas_fianzas=0;
													$sum_pendientes_fianzas=0;
													$sum_atrasadas_fianzas=0;
													$sum_a_tiempo_fianzas = 0;

													foreach($cobranzaGeneral as $bb){

														$sum_efectuadas += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
														$sum_pendientes += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
														$sum_atrasadas += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
														$sum_a_tiempo += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);

														if($bb->reporte != "fianzas"){
															$sum_efectuadas_seguros += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
															$sum_pendientes_seguros += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
															$sum_atrasadas_seguros += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
															$sum_a_tiempo_seguros += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);

															$flotante_nuevo.='
															<tr>
																<td>'.ucwords($bb->reporte).'</td>
																<td class="text-center">'.number_format($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer).'</td>
																<td class="text-center">'.number_format($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer).'</td>
																<td class="text-center">'.number_format($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer).'</td>
																<td class="text-center">'.number_format($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer).'</td>
															</tr>
														';

														} else{
															$sum_efectuadas_fianzas += ($bb->recibos_efectuados + $bb->recibos_efectuados_grupo_cer);
															$sum_pendientes_fianzas += ($bb->recibos_pendientes + $bb->recibos_pendientes_grupo_cer);
															$sum_atrasadas_fianzas += ($bb->recibos_atrasados + $bb->recibos_atrasados_grupo_cer);
															$sum_a_tiempo_fianzas += ($bb->recibos_a_tiempo + $bb->recibos_a_tiempo_cer);
														}
													}

												$flotante_nuevo.='
														<tr><td colspan="5" style="border-top: solid"></td></tr>
														<tr><td>Seguros</td><td class="text-center">'.$sum_efectuadas_seguros.'</td><td class="text-center">'.$sum_a_tiempo_seguros.'</td><td class="text-center">'.$sum_pendientes_seguros.'</td><td class="text-center">'.$sum_atrasadas_seguros.'</td></tr>
														<tr><td>Fianzas</td><td class="text-center">'.$sum_efectuadas_fianzas.'</td><td class="text-center">'.$sum_a_tiempo_fianzas.'</td><td class="text-center">'.$sum_pendientes_fianzas.'</td><td class="text-center">'.$sum_atrasadas_fianzas.'</td></tr>
														<tr><td>Total</td><td class="text-center">'.$sum_efectuadas.'</td><td class="text-center">'.$sum_a_tiempo.'</td><td class="text-center">'.$sum_pendientes.'</td><td class="text-center">'.$sum_atrasadas.'</td></tr>
													</tbody>
												</table>
												';
											}
											
									$flotante_nuevo.='
                                        </div>
									</div> <!--termina card-->
								';

?>