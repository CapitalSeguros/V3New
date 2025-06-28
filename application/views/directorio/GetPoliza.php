
<?php
function formatDate($date){
	$tmpDate = new DateTime($date);
	return $tmpDate->format('Y/m/d');

}
function formatMoney($num){
	return '$ '.number_format((Double)$num, 2, '.', ',');
}
$IDCli = $this->input->get('IDCli', TRUE);
$page = $this->input->get('page', TRUE);
if($page == ""){
	$page = 1;
}
// if(!isset($ClienteContact)){
	// redirect('/directorio');
// }
$aJson = array();
foreach ($PolizaClient["documentos"] as $value) {
	array_push($aJson, $value);
}

?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
        <style>		
			th,tr{
				font-size:12px;
				min-width:130px;
				
			}
			th.compania,tr.compania{
				min-width:300px;
			}
			th.cliente,tr.cliente{
				min-width:200px;
			}
            #detalle{
              background-color: rgba(0, 0, 0, 0.7);
              position: fixed;
              top: 0;
              left: 0;
              width: 100%;
              height: 100%;
              z-index: 1050;
            }
            
        </style>
<!-- End navbar -->
<section class="page-section">
	<div class="container">		
		<div class="row">
			<div class="col-sm-12 col-md-12">		
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-8 col-sm-4 col-md-4">
				<ol class="breadcrumb">
				  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
				  <li><a href="<?php echo base_url(); ?>directorio">Directorio</a></li>
				  <li><a href="<?php echo base_url(); ?>directorio/registroDetalle?IDCli=<?php echo $IDCli; ?> ">Detalle Registro</a></li>
				  <li class="active">Poliza</li>
				</ol>			
			</div>
		</div>
		 <div class="row">
			<div class="col-md-12">
				<div class="panel with-nav-tabs panel-default">
					<div class="panel-heading">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#tab1default" data-toggle="tab">Polizas</a></li>
							</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1default">
								<div class="row">
								  <?php
								  
									if(isset($PolizaClient["documentos"])){
										?>
									<!--<div class="col-md-12">
										<div class="pull-right">
												<div class="btn-group">
													<button type="button" class="btn btn-success btn-filter" data-target="pagado">Vigente</button>
													<button type="button" class="btn btn-warning btn-filter" data-target="pendiente">Pendiente</button>
													<button type="button" class="btn btn-danger btn-filter" data-target="cancelado">Cancelado</button>
													<button type="button" class="btn btn-default btn-filter" data-target="all">Todos</button>
												</div>
											</div>
									</div>	-->
									<div class="col-md-12">
									<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Tipo</th>
														<th>Documento</th>
														<th>Anterior</th>
														<th>Posterior</th>
														<!-- <th>A&ntildeo inicio</th> -->
														<th>Desde</th>
														<th>Hasta</th>
														<th>Estatus</th>
														<th class="cliente">Cliente</th>
														<th>Grupo</th>
														<th>Sub Grupo</th>
														<th>Sub sub Grupo</th>
														<th class="compania">Concepto</th>
														<th class="compania">Referencia 1</th>
														<th class="compania">Referencia 2</th>
														<th>No Folio</th>
														<th>Moneda</th>
														<th>Forma de pago</th>
														<th>Clave de agente</th>
														<th class="compania">Compa&ntilde;ia</th>
														<th>Sub Ramo</th>
														<th>Prima neta</th>
														<th>Prima total</th>
														<th class="compania">Ejecutivo</th>
														<th class="compania">Vendedor</th>
													</tr>
												</thead>
												<tbody>
													<?php
													
													foreach($aJson as $poliza){
													?>
														<tr data-status="pagado">
															<td style="display:none;"><?php echo $poliza->IDDocto; ?></td>
															<td><p><?php echo $poliza->TipoDocto_TXT;?></p></td>
															<td>
																<p style="cursor: pointer; cursor: hand;"><?php echo $poliza->Documento;?></p>																	
															</td>
															<td>
																 <p><?php echo $poliza->DAnterior;?></p>
															</td>
															<td>
																 <?php echo $poliza->DPosterior;?>																
															</td>
															<!--<td>
																 <?php //echo $poliza->Documento;?>																
															</td>-->
															<td>
																 <?php echo formatDate($poliza->FDesde);?>																
															</td>
															<td>
																 <?php echo formatDate($poliza->FHasta);?>																
															</td>
															<td>
																 <?php echo $poliza->Status_TXT;?>																
															</td>
															<td>
																 <?php echo $poliza->NombreCompleto;?>																
															</td>
															<td>
																 <?php echo $poliza->Grupo;?>																
															</td>
															<td>
																 <?php echo $poliza->SubGrupo;?>																
															</td>
															<td>
																 <?php echo $poliza->SSGrupo;?>																
															</td>
															<td>
																 <?php echo $poliza->Concepto;?>																
															</td>
															<td>
																 <?php echo $poliza->Referencia1;?>																
															</td>
															<td>
																 <?php echo $poliza->Referencia2;?>																
															</td>
															<td>
																 <?php echo $poliza->FolioNo;?>																
															</td>
															<td>
																 <?php echo $poliza->Moneda;?>																
															</td>
															<td>
																 <?php echo $poliza->FPago;?>																
															</td>
															<td>
																 <?php echo $poliza->CAgente;?>																
															</td>
															<td>
																 <?php echo $poliza->AgenteNombre;?>																
															</td>
															<td>
																 <?php echo $poliza->SRamoAbreviacion;?>																
															</td>
															<td>
																 <?php echo formatMoney($poliza->PrimaNeta);?>																
															</td>
															<td>
																 <?php echo formatMoney($poliza->PrimaTotal);?>																
															</td>
															<td>
																 <?php echo $poliza->EjecutNombre;?>																
															</td>
															<td>
																 <?php echo $poliza->VendNombre;?>																
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
									</div>
									
									</div>
									<div class="col-sm-12 col-md-12 col-lg-12">					
										<nav>
										  <ul class="pagination">
											<?php
												if(isset($PolizaClient["paginacion"]) && isset($PolizaClient["paginacion"]["Pages"])){
														$paginas 		= $PolizaClient["paginacion"]["Pages"];
												$pagina_actual = $PolizaClient["paginacion"]["Page"];
											
												if($paginas >= 1){
													for ($i = 1; $i <= $paginas ; $i++) {
														
														if($i == 1){
															?>
															<li>
															  <a href="#" aria-label="Previous" class="pag_cenis" data-pag="<?php echo $i ?>">
																<span aria-hidden="true">&laquo;</span>
															  </a>
															</li>
															<?php
														}
														
														if ($i == $pagina_actual) {
															?>
															<li><a href="#" class="pag_cenis active" aria-label="<?php echo $i ?>" data-pag="<?php echo $i ?>"><?php echo $i ?></a></li>
															<?php
														}else{
															?>
															<li><a href="#" class="pag_cenis" aria-label="<?php echo $i ?>" data-pag="<?php echo $i ?>" ><?php echo $i ?></a></li>
															<?php
														}
														
														if($i == $paginas){
															?>
															<li>
															  <a href="#" aria-label="Next" data-pag="<?php echo $i ?>" class="pag_cenis">
																<span aria-hidden="true">&raquo;</span>
															  </a>
															</li>
															<?php
														}
														
													}
													
												}
												}								
											?>
											</ul>
										</nav>	
									</div>
									<?php
									}
								  ?>
							  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>            
</section>
<div id="detalle" class="modal bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="gridSystemModalLabel">Modal title</h4>
		</div>
		<div class="modal-body">
			      <form action="#" method="POST" id="frmBuscador">
    		<div class="row">
    	           <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="tipodoc">Tipo Documento</label>
                                <p id="tpDoc"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="solicitud">Solicitud</label>
                                <p id="solicitud"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="anterior">Anterior</label>
                                <p id="anterior"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="polizamaestra">P&oacute;liza Maestra</label>                       
                                <p id="pMaestra"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="documento">Documento</label>
                                <p id="documento"></p>
                            </div>
                            <div class="col-md-4">
                                <label for="posterior">Posterior</label>
                                <p id="posterior"></p>
                            </div>
                        </div>
                   </div>
    		</div>
            <div class="row row-individual">
                <div class="col-md-12">
                    <div id="wizard">
                        <h3>General</h3>
                        <section>
                            <div class="row row-tabs">
                                <div class="col-md-9">
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="cliente">Cliente</label>
                                                    <p id="cliente"></p>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="direccion">Direcci&oacute;n</label>
                                                    <p id="direccion"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="agente">Agente</label>
                                                    <p id="agente"></p>
                                                    <p id="agenteN"></p>
                                                    <p id="agenteci"></p>
                                                </div>
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="ejecutivo">Ejecutivo de Compa&ntilde;ia</label>
                                                    <p id="ejecutivo"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row row-tabs">
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="form-group col-md-6">
                                                    <label for="fechaini">Desde</label>
                                                    <div class="input-group">
                                                        <p id="desde"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="fechafin">Hasta</label>
                                                    <div class="input-group">
                                                        <p id="hasta"></p>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="row row-tabs">
                                                <div class="form-group col-md-6">
                                                    <label for="fechaantiguedad">Fecha de antiguedad</label>
                                                    <div class="input-group">
                                                        <p id="fechaantiguedad"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="renovacion">Renovaci&oacute;n</label>
                                                    <p id="renovacion"></p>
                                                </div>
                                            </div>
                                            <!-- <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="pagos">Celendario de Pagos</label>
                                                    <p id="pagos"></p>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="form-gropup col-md-6">
                                            <div class="row row-tabs">
                                                <div class="col-md-8">
                                                    <label for="moneda">Moneda</label>
                                                    <p id="moneda"></p>
                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <label for="tipocambio">Tipo de Cambio</label>
                                                    <p id="tipocambio"></p>
                                                </div> -->
                                            </div>
                                            <div class="row row-tabs">
                                                <div class="col-md-12">
                                                    <label for="formapago">Forma de pago</label>
                                                    <p id="formapago"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cvendedor">Vendedor</label>
                                            <p id="cvendedor"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="cejecutivo">Ejecutivo</label>
                                            <p id="cejecutivo"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="grupo">Grupo</label>
                                            <p id="grupo"></p>
                                        </div>
                                    </div>
                                    <!-- <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="subgrupo">Sub Grupo</label>
                                            <p id="subgrupo"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="subsubgrupo">Sub Sub Grupo</label>
                                            <p id="subsubgrupo"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="ecobranza">Ejecutivo Cobranza</label>
                                            <p id="ecobranza"></p>
                                        </div>
                                    </div>
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                            <label for="ereclamo">Ejecutivo Reclamo</label>
                                            <p id="ereclamo"></p>
                                        </div>
                                    </div> -->
                                    <div class="rew row-tabs">
                                        <div class="col-md-12">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row row-tabs">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia1">Referencia 1</label>
                                            <p id="referencia1"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia3">Referencia 3</label>
                                            <p id="referencia3"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia2">Referencia 2</label>
                                            <p id="referencia3"></p>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="referencia4">Refencia 4</label>
                                            <p id="referencia4"></p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row row-tabs">
                                <div class="col-md-12">
                                    <label for="concepto">Concepto</label>
                                    <p id="concepto"></p>
                                </div>
                            </div>
                            <div class="row row-tabs">
                            	<div id="tree_menu" class="col-md-12">
            				       
                            	</div>		
                            </div>
                        </section>
                        <!--h3>Detalle</h3>
                        <section>
                        </section>
                        <h3>Endosos Asegurables</h3>
                        <section>
                        </section-->
                    </div>
                </div>
            </div>
        </form>
        <!--div class="row">
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
			<div class="col-sm-4 col-md-4" align="right">
            </div>
        </div-->
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<!--<button type="button" class="btn btn-primary">Save changes</button>-->
		</div>
    </div>
  </div>
</div>
<script>
 	Date.prototype.yyyymmdd = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return  (dd[1]?dd:"0"+dd[0])+"/"+ (mm[1]?mm:"0"+mm[0])+"/"+ yyyy; // padding
    };

	var ajson = JSON.parse('<?php echo json_encode($aJson); ?>');


	function getValue(data){
		var resl = '';
		if(data != null){
			if(typeof data == 'object'){
				resl = '';
			}else{
				resl = data;
			}
		}else{
			resl = '';
		}

		return resl;
	}
	$(document).ready(function(){
		$("tr").click(function(){
			var tr = $(this);
			var IDDocto = tr.find('td:first').html();

			$.each(ajson,function(k,v){
				if(v.IDDocto == IDDocto){

					// console.log(v);
					$('#tpDoc').html(getValue(v.TipoDocto_TXT));
					$('#solicitud').html(getValue(v.Solicitud));
					$('#anterior').html(getValue(v.DAnterior));
					$('#posterior').html(getValue(v.DPosterior));
					$('#documento').html(getValue(v.Documento));
					//General
					$('#cliente').html(getValue(v.NombreCompleto));	
					$('#direccion').html(getValue(v.Calle) +' '+ getValue(v.NOExt) +' '+getValue(v.NOInt)+ ' ' +getValue(v.Colonia)+ ' '+getValue(v.CPostal)+ ' '+getValue(v.Poblacion) + ' '+ getValue(v.Ciudad) + ' ' + getValue(v.Pais));
					$('#agente').html(getValue(v.CAgente));
					$('#agenteN').html(getValue(v.AgenteNombre));
					$('#agenteci').html(getValue(v.CiaNombre));
					$('#cvendedor').html(getValue(v.VendNombre));	
					$('#cejecutivo').html(getValue(v.EjecutNombre));
					$('#grupo').html(getValue(v.Grupo));
					$('#subgrupo').html(getValue(v.SubGrupo));

					var dHasta = new Date(getValue(v.FHasta));
					var dDesde = new Date(getValue(v.FDesde));
					var dFechaAntiguedad = new Date(getValue(v.FAntiguedad));
					$('#hasta').html(dHasta.yyyymmdd());
					$('#desde').html(dDesde.yyyymmdd());
					$('#fechaantiguedad').html(dFechaAntiguedad.yyyymmdd());
					$('#moneda').html(getValue(v.Moneda));
					$('#formapago').html(getValue(v.FPago));
					$('#renovacion').html(getValue(v.Renovacion));
					$('#concepto').html(getValue(v.Concepto));

					return;
				}
				
				
			});

			$.ajax({
					method: "POST",
					data: { "IDDocto": IDDocto },
					url : "<?php echo base_url()?>directorio/LoadCentroDigital",
					dataType: "html",
					success : function(data){
							$('#tree_menu').easytree({					
								// data: arbol,
								data: [JSON.parse(data)],
							});
					}
				
				});
			$(".bs-example-modal-lg").modal("show");
		});
		
		$(".pag_cenis").click(function(e){
			  e.preventDefault();
			
			$data_page = $(this).attr("data-pag");
			
			window.open('<?php echo base_url()?>directorio/GetPoliza?IDCli='+ <?php echo $IDCli; ?> + '&page=' + $data_page,'_self');			
		});	

		// var jsonData = [{"children": [{"href": "Https://www.SICASOnline.com/SICAS1325/Storage/CONT000013028/Cliente/DOC000057787/ACTUALIZACION DESCARGABLES 03 JULIO.pdf", "text": "ACTUALIZACION DESCARGABLES 03 JULIO"}, {"children": [{"href": "Https://www.SICASOnline.com/SICAS1325/Storage/CONT000013028/Cliente/DOC000057787/DEMO/CATALOGOCOBERTURAS.PDF", "text": "CATALOGOCOBERTURAS"} ], "isExpanded":true, "isFolder": true, "text": "DEMO"} ], "isActive":false, "isExpanded":true, "isFolder": true, "text": "PRUEBA22"} ];

		// $('#tree_menu').easytree({
			// data: jsonData,
		// });
	});
</script>
<?php $this->load->view('footers/footer'); ?>
