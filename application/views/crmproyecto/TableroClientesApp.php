<?  
    $colorRef[0] = "5";
    $colorRef[1] = "8";
    $colorRef[2] = "11";
    $colorRef[3] = "14";
    $colorRef[4] = "17";
    $colorRef[5] = "20";
    $colorRef[6] = "23";
    $colorRef[7] = "26";
    $colorRef[8] = "29";
    $colorRef[9] = "32";
    $colorRef[10] = "33"; //solo llegan a 34 los colores de la libreira
    $colorRef[11] = "34";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
	
	$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
	$totalResultados = $ListaClientes->num_rows();
?>

<script language="javascript" type="text/javascript">
	function MakeStaticHeader(gridId, height, width, headerHeight, isFooter){
		var tbl = document.getElementById(gridId);
        if(tbl){
			var DivHR = document.getElementById('DivHeaderRow');
			var DivMC = document.getElementById('DivMainContent');
			var DivFR = document.getElementById('DivFooterRow');

			//*** Set divheaderRow Properties ****
			DivHR.style.height = headerHeight + 'px';
			DivHR.style.width = (parseInt(width) - 16) + 'px';
			DivHR.style.position = 'relative';
			DivHR.style.top = '0px';
			DivHR.style.zIndex = '10';
			DivHR.style.verticalAlign = 'top';

			//*** Set divMainContent Properties ****
			DivMC.style.width = width + 'px';
			DivMC.style.height = height + 'px';
			DivMC.style.position = 'relative';
			DivMC.style.top = -headerHeight + 'px';
			DivMC.style.zIndex = '1';

			//*** Set divFooterRow Properties ****
			DivFR.style.width = (parseInt(width) - 16) + 'px';
			DivFR.style.position = 'relative';
			DivFR.style.top = -headerHeight + 'px';
			DivFR.style.verticalAlign = 'top';
			DivFR.style.paddingtop = '2px';

			if(isFooter){
				var tblfr = tbl.cloneNode(true);
				tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
				var tblBody = document.createElement('tbody');
				tblfr.style.width = '100%';
				tblfr.cellSpacing = "0";
				//*****In the case of Footer Row *******
				tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
				tblfr.appendChild(tblBody);
				DivFR.appendChild(tblfr);
			}
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
		}
	}


	function OnScrollDiv(Scrollablediv) {
		document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
		document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
	}

	window.onload = function() {
		MakeStaticHeader('Mitabla', 350, 1450, 40, false)
	}
</script>


        <div class="row">
        	<div class="col-sm-6 col-md-6">
			<form
    	    	method="get" 
        		name="infoagente" id="infoagente"  
            	action="<?=base_url()?>crmproyecto/Reportes"
	        >
				<div class="form-group">
					<div class="input-group">
                    <select name="vendedorp" id="vendedorp" class="form-control" required>
						<option value="">Seleccione un Agente y haz click en Ver Detalle</option>
						<?
							if(!empty($ListaVendedores)){
								foreach ($ListaVendedores->result() as $Registro){
						?>
						<option value="<?= $Registro->email; ?>">
							<?= $Registro->name_complete; ?> 
						</option>
						<?
								}
							} else {
						?>
						<option value="false">
							Vendedor No encontrado !!!
						</option>
						<?
							}
						?>
					</select>
					<span class="input-group-btn">
						<button class="btn btn-primary" onclick="enviaFormReportClient(event)"><i class="fa fa-search fa-sm"></i>Ver Detalle</button>

					</span>
                    </div>
                </div><!-- /form-group -->
			</form><!-- /form -->
       	  	</div><!-- /col -->

        	<div class="col-sm-4 col-md-4">
			<form id="formBuscaCliente" method="GET" action="<?=base_url()?>crmproyecto/Reportes">
				<div class="input-group">
					<input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control" placeholder="Buscar entre la lista de Clientes">
					<span class="input-group-btn"><button class="btn btn-primary" onclick="enviaFormBuscaCliente(event)" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
				</div>
			</form>
       	  	</div><!-- /col -->

        	<div class="col-sm-2 col-md-2" align="right">
			<form id="ExportaClientes" method="GET" action="<?=base_url()?>crmproyecto/ExportaClientes">
				<button 
                	name="ExportaAgentes" id="ExportaAgentes"
					class="btn btn-primary"
				>
					Exporta Clientes
				</button>
			</form>
       	  	</div><!-- /col -->
		</div><!-- /row -->
        

            
				<div class="table-responsive">
					<table class="table" id='Mitabla'>
						<thead>
							<tr>
								<th>Eliminar</th>
								<th>Editar</th>
								<th>Suspender</th>
								<th>IDCliente</th>
								<th>ApellidoP</th>				                                
								<th>ApellidoM</th>			                                
								<th>Nombre</th>
								<th>RazonSocial</th>	
								<th>RFC</th>	
								<th>Email1</th>
								<th>Telefono1</th>
								<th>EdoActual</th>	
								<th>Fecha creacion</th>
							</tr>
						</thead>
						<tbody>   
						<?php

							if($ListaClientes != FALSE){
								foreach ($ListaClientes->result() as $row){
						?>
							<tr>
								<td>
									<a
										onclick='eliminarCliente(<?=$row->IDCli ?>,"<?=$row->EstadoActual ?>",this.parentNode.parentNode.rowIndex)'	
										class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title>
                                        <span class="glyphicon glyphicon-remove" ></span> Eliminar
									</a>
								</td>
								<td>
									<a onclick='editarCliente(<?=$row->IDCli ?>)'										
										class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title>
										<span class="glyphicon glyphicon-pencil" ></span> Editar
									</a>
								</td>
								<td><button class='btn btn-primary btn-xs contact-item' onclick="pantallaSuspension(<?=$row->IDCli ?>,'<?=date("d/m/Y", strtotime($row->fechaCreacionCA));?>')">Suspender</button></td>
								<td><?=$row->IDCli?></td> 
								<td><?=$row->ApellidoP?></td>
								<td><?=$row->ApellidoM?></td>
								<td><?=$row->Nombre?></td>
								<td><?=$row->RazonSocial?></td>
								<td><?=$row->RFC?></td>
								<td><?=$row->EMail1?></td>
								<td><?=$row->Telefono1?></td>
								<td><? //secambio la etiqueta a referido pero internamente l abase guarda dimension
                                             if($row->EstadoActual=='DIMENSION')
                                              {
                                                  echo "REFERIDO";
                                              }
                                              else
                                              {  
                                                echo $row->EstadoActual;

                                              }?>             
								</td>
								<td><?=date("Y/m/d", strtotime($row->fechaCreacionCA));?></td>
							</tr>
						<?php
								}
							}
						?>
						</tbody>
						<?
							if($totalResultados == 0){
						?>
						<tfoot>
							<tr>
								<td colspan="4"><center><b>No se encontraron registros.</b></center></td>
							</tr>
						</tfoot>
						<?
							}
						?>
					</table>
				</div><!-- /table-responsive -->

				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->

<?php $this->load->view('footers/footer'); ?>