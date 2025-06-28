<?
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style type="text/css">
  .tableP100{width: 100%; height: 300px; overflow: scroll;}
  .tableP100 thead {color: white; background-color: #361866 }
  .tableP100 >thead >tr>th {border: solid black;width: 300px}
 .tableP100 >tbody >tr>td {border: solid black 1px; margin:5em; ;width: 300px}
 .divContTabla{height: 400px; width: 100%;overflow: scroll;}
 ul {list-style:none;}
 .puntoDimension{height: 0px; width: 10px; border-bottom:10px dotted #D82A19; display:inline-block; margin-left:-18px}
 .puntoVacio{height: 0px; width: 10px; border: 1px black solid; border-radius: 5px; padding: 4px; display:inline-block; margin-left:-18px}
 .puntoPerfilado {height: 0px; width: 10px; border-bottom:10px dotted #D8AD19; display:inline-block; margin-left:-18px}
 .puntoContactado{'style='height: 0px; width: 10px; border-bottom:10px dotted #42D819; display:inline-block; margin-left:-18px}
 .puntoCotizado{height: 0px; width: 10px; border-bottom:10px dotted #0080FF; display:inline-block; margin-left:-18px}
 .puntoPagado{height: 0px; width: 10px; border-bottom:10px dotted #92733D; display:inline-block; margin-left:-18px}
  </style>
<? $totalResultados = count($ListaClientes);?>
	<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Seguimiento a reasignados</h3></div></div><hr /> 
	</section>
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive divContTabla">
	
    	        	<table class="tableP100" id='Mitabla' >
        	        	<thead>
							<tr>
    	                    	<th style="width: 300px">ID</th>
    	                    	<th>Fecha Creacion</th>
    	                    	<th>Fecha Asignacion</th>
    	                    	<th>Correo Asignacion</th>
								<th>ApellidoP</th>                        
								<th>ApellidoM</th>			               
								<th>Nombre</th>
								<th>Status</th>
		
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
								<td><?=$row->IDCli?></button></td> 
								<td><?php if($row->fechaCreacionCA!=null){echo(date("Y/m/d", strtotime($row->fechaCreacionCA)));} ?></td>
								<td><?=$row->fechaTraspaso?></td>
								<td><?=$row->Usuario?></td>
								<td><?=$row->ApellidoP?></td>
								<td><?=$row->ApellidoM?></td>
								<td><?=$row->Nombre?></td>
								<td>
									<?#=$row->EstadoActual."<br>";
									
									
									switch ($row->EstadoActual) {
										case 'DIMENSION': echo "<ul>
																<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
																<li><div class='puntoVacio'></div>&nbsp PERFILADO</li>
																<li><div class='puntoVacio'></div>&nbsp CONTACTADO</li>
																<li><div class='puntoVacio'></div>&nbsp COTIZADO</li>
																<li><div class='puntoVacio'></div>&nbsp PAGADO</li>
																</ul>";														
										
										break;
										case 'PERFILADO': echo "<ul>
																<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
																<li><div class='puntoPerfilado'></div>&nbsp PERFILADO</li>
																<li><div class='puntoVacio'></div>&nbsp CONTACTADO</li>
																<li><div class='puntoVacio'></div>&nbsp COTIZADO</li>
																<li><div class='puntoVacio'></div>&nbsp PAGADO</li>
																</ul>";
										break;
										case 'CONTACTADO': echo "<ul>
																<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
																<li><div class='puntoPerfilado'></div>&nbsp PERFILADO</li>
																<li><div class='puntoContactado'></div>&nbsp CONTACTADO</li>
																<li><div class='puntoVacio'></div>&nbsp COTIZADO</li>
																<li><div class='puntoVacio'></div>&nbsp PAGADO</li>
																</ul>";
										break;
										default: 'El seguimiento ha sido eliminado o desactivado'; 
										
										if ($row->EstadoActual === 'COTIZADO' && $row->folioActividad !='' ) {
											#echo $row->folioActividad;
											echo "<ul>
													<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
													<li><div class='puntoPerfilado'></div>&nbsp PERFILADO</li>
													<li><div class='puntoContactado'></div>&nbsp CONTACTADO</li>
													<li><div class='puntoCotizado'></div>&nbsp COTIZADO</li>
													<li><div class='puntoVacio'></div>&nbsp PAGADO</li>
												</ul>";
																
										}
										elseif ($row->EstadoActual === 'REGISTRADO' && $row->pagado !='') {
											echo "<ul>
													<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
													<li><div class='puntoPerfilado'></div>&nbsp PERFILADO</li>
													<li><div class='puntoContactado'></div>&nbsp CONTACTADO</li>
													<li><div class='puntoCotizado'></div>&nbsp COTIZADO</li>
													<li><div class='puntoPagado'></div>&nbsp PAGADO</li>
												</ul>";
										}
										else {
											echo "<ul>
													<li><div class='puntoDimension'></div>&nbsp DIMENSION</li>
													<li><div class='puntoPerfilado'></div>&nbsp PERFILADO</li>
													<li><div class='puntoContactado></div>&nbsp CONTACTADO</li>
													<li><div class='puntoVacio'></div>&nbsp COTIZADO</li>
													<li><div class='puntoVacio'></div>&nbsp PAGADO</li>
												</ul>";
										}
									}
									}
								}
							?>
								</td>

							</tr>
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

	</section><!-- /container-fluid -->


