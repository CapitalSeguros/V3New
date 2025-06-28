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
    $mostrar_Vista = false;
    if($mostrar_Vista){
        $this->load->view('headers/header'); 
    }
	
?>
<!-- Navbar -->
<?php
    $mostrar_Vista = false; // No mostrar la vista visualmente, pero sí cargarla

    if ($mostrar_Vista) {
        $this->load->view('headers/menu');
    } else {
        echo '<div style="display: none;">';
        $this->load->view('headers/menu');
        echo '</div>';
    }
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
        </style>
<!-- End navbar -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

<div class="container-fluid">
	<div class="row text-right">
		<div class="col-md-offset-0 col-sm-4 col-md-4">
			<ol class="breadcrumb">
			  <li><a href="<?php echo base_url(); ?>">Inicio</a></li>
			  <li><a href="<?php echo base_url(); ?>directorio">Directorio</a></li>
			  <li><a href="<?php echo base_url(); ?>directorio/registroDetalle?IDCli=<?php echo $IDCli; ?> ">Detalle Registro</a></li>
			  <li class="active">Fianza</li>
			</ol>			
		</div>
	</div>
	<h4>Registros de fianzas</h4>
	<hr>
	<?php if(!empty($PolizasGeneradas)) {
		foreach($PolizasGeneradas as $ramo => $doctos){?>

		<div class="card border-secondary mb-3">
			<div class="card-header"><h5><?=$ramo?></h5></div>
			<div class="card-body table-responsive">
				<table class="table">
					<thead>
						<tr class="info">
						<th class="text-dark">Tipo</th>
						<th class="text-dark">Documento</th>
							<th class="text-dark">Anterior</th>
							<th class="text-dark">Posterior</th>
							<!-- <th>A&ntildeo inicio</th> -->
							<th class="text-dark">Desde</th>
							<th class="text-dark">Hasta</th>
							<th class="text-dark">Estatus</th>
							<th class="cliente text-dark">Cliente</th>
							<th class="text-dark">Grupo</th>														
							<th class="text-dark">Sub Grupo</th>
							<th class="text-dark">Sub sub Grupo</th>
							<th class="compania text-dark">Concepto</th>
							<th class="compania text-dark">Referencia 1</th>
							<th class="compania text-dark">Referencia 2</th>
							<th class="text-dark">No Folio</th>
							<th class="text-dark">Moneda</th>
							<th class="text-dark">Forma de pago</th>
							<th class="text-dark">Clave de agente</th>
							<th class="compania text-dark">Compa&ntilde;ia</th>
							<th class="text-dark">Sub Ramo</th>
							<th class="text-dark">Prima neta</th>
							<th class="text-dark">Prima total</th>
							<th class="compania text-dark">Ejecutivo</th>
							<th class="compania text-dark">Vendedor</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($doctos as $info){?>
							<tr data-status="pagado">
															<td style="display:none;"><?php echo $info->IDDocto; ?></td>
															<td><p><?php echo $info->TipoDocto_TXT;?></p></td>
															<td>
																<p style="cursor: pointer; cursor: hand;"><?php echo $info->Documento;?></p>																	
															</td>
															<td>
																 <p><?php echo $info->DAnterior;?></p>
															</td>
															<td>
																 <?php echo $info->DPosterior;?>																
															</td>
															<!--<td>
																 <?php //echo $poliza->Documento;?>																
															</td>-->
															<td>
																 <?php echo formatDate($info->FDesde);?>																
															</td>
															<td>
																 <?php echo formatDate($info->FHasta);?>																
															</td>
															<td>
																 <?php echo $info->Status_TXT;?>																
															</td>
															<td>
																 <?php echo $info->NombreCompleto;?>																
															</td>
															<td>
																 <?php echo $info->Grupo;?>																
															</td>
															<td>
																 <?php echo $info->SubGrupo;?>																
															</td>
															<td>
																 <?php echo $info->SSGrupo;?>																
															</td>
															<td>
																 <?php echo $info->Concepto;?>																
															</td>
															<td>
																 <?php echo $info->Referencia1;?>																
															</td>
															<td>
																 <?php echo $info->Referencia2;?>																
															</td>
															<td>
																 <?php echo $info->FolioNo;?>																
															</td>
															<td>
																 <?php echo $info->Moneda;?>																
															</td>
															<td>
																 <?php echo $info->FPago;?>																
															</td>
															<td>
																 <?php echo $info->CAgente;?>																
															</td>
															<td>
																 <?php echo $info->AgenteNombre;?>																
															</td>
															<td>
																 <?php echo $info->SRamoAbreviacion;?>																
															</td>
															<td>
																 <?php echo formatMoney($info->PrimaNeta);?>																
															</td>
															<td>
																 <?php echo formatMoney($info->PrimaTotal);?>																
															</td>
															<td>
																 <?php echo $info->EjecutNombre;?>																
															</td>
															<td>
																 <?php echo $info->VendNombre;?>																
															</td>
														</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>

		<?php } ?>
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

		<?php } ?>
</div>
<br><br>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg modal-dialog-centered">
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
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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
			}
			else{
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

			$(".bs-example-modal-lg").attr("data-backdrop","") //Dennis 2021-05-14

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