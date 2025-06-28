<?
	$ci = &get_instance();
	$ci->load->library('webservice_sicas_soap');
	
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
?>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> Ojo Complemeto en Conflicto con easytree -->
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
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
	//$totalResultados = 1; //$ListaClientes->num_rows();
//echo "<pre>";
//	print_r($ListClientesWs);
//print_r($resultClientes);
	//** $listaClient	= json_decode($ListClientesWs, true);
	//print_r($ListClientesWs);
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

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Prospeccion de negocios: Tablero Clientes</h3></div>

        </div>
		<hr /> 
	</section>
	
    <section class="container-fluid"><!-- container-fluid -->
        <div class="row">
        	<div class="col-sm-6 col-md-6">
			<form
    	    	method="get" 
        		name="infoagente" id="infoagente"  
            	action="<?=base_url()?>crmproyecto/TableroClientes"
	        >
				<div class="form-group">
					<div class="input-group">
                    <select name="vendedorp" id="vendedorp" class="form-control" required>
						<option value="">Seleccione un Agente y haz click en Ver Detalle </option>
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
						<button class="btn btn-primary" onclick="enviaFormReportClientTab(event)"><i class="fa fa-search fa-sm"></i>Ver Detalle</button>

					</span>
                    </div>
                </div><!-- /form-group -->
			</form><!-- /form -->
       	  	</div><!-- /col -->

        	<div class="col-sm-4 col-md-4">
			<form id="formBuscaCliente" method="GET" action="<?=base_url()?>crmproyecto/TableroClientes">
				<div class="input-group">
					<input type="text" name="busquedaUsuario" id="busquedaUsuario" class="form-control" placeholder="Buscar entre la lista de Clientes">
					<span class="input-group-btn"><button class="btn btn-primary" onclick="enviaFormBuscaClienteTab(event)" title="Buscar"><i class="fa fa-search"></i>&nbsp;</button></span>
				</div>
			</form>
       	  	</div><!-- /col -->

		</div><!-- /row -->
        
		<div class="panel panel-default">
			<div class="panel-body">
            
				<!-- <div id="DivRoot" align="left"></div> -->
				<!-- <div style="overflow: hidden;" id="DivHeaderRow"></div> -->
				<!-- <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent"> -->
                <?
				//echo "<pre>";
				//** print_r($ListClientesWs);
			//	foreach ($ListClientesWs->clientes as $value) {
			//	}
				?>
                <h1><? // = $value['sramo']; ?></h1>
				<div class="table-responsive">
					<table class="table" id='Mitabla'>
						<thead>
							<tr>
								<th>IDCliente</th>
								<th>ApellidoP</th>				                                
								<th>ApellidoM</th>			                                
								<th>Nombre</th>
								<th>RazonSocial</th>	
								<th>RFC</th>	
								<th>Email1</th>
								<th>Telefono1</th>
								<!-- <th>Compañia</th> -->
								<!-- <th>Sub Ramo</th> -->
                                <th>Lineas Personales</th>
                                <th>Vida</th>
                                <th>Daños</th>
                                <th>Fianzas</th>
                                <th>Vehiculos</th>
                                <th><?= "Saldo:<br />$".number_format($saldo,2,".",","); ?></th>
							</tr>
						</thead>
						<tbody>   
						<?
//						if($ListClientesWs->clientes != FALSE){
							$totalResultados	= count($ListClientesWs['clientes']);
							foreach($ListClientesWs['clientes'] as $row){
								//print_r($row);
								//calculaPolizasRamo($row->IDCli);
						?>
							<tr>
								<td><?=$row['IDCli']?></td>
								<td><?=(isset($row['ApellidoP'])&& count($row['ApellidoP'])>0)? $row['ApellidoP'] : ""?></td>
								<td><?=(isset($row['ApellidoM'])&& count($row['ApellidoM'])>0)? $row['ApellidoM'] : ""?></td>
								<td><?=(isset($row['Nombre'])&& count($row['Nombre'])>0)? $row['Nombre'] : ""?></td>
								<td><?=(isset($row['RazonSocial']) && count($row['RazonSocial'])>0)? $row['RazonSocial'] : ""?></td>
								<td><?=(isset($row['RFC'])&& count($row['RFC'])>0)? $row['RFC'] : ""?></td>
								<td><?=(isset($row['EMail1'])&& count($row['EMail1'])>0)? $row['EMail1'] : ""?></td>
								<td><?=(isset($row['Telefono1'])&& count($row['Telefono1'])>0)? $row['Telefono1'] : ""?></td>
								<!-- <td></td> -->
								<!-- <td></td> -->
								<td align="center"><?=$row['Lp']?></td>
								<td align="center"><?=$row['Vi']?></td>
								<td align="center"><?=$row['Da']?></td>
								<td align="center"><?=$row['Fi']?></td>
								<td align="center"><?=$row['Ve']?></td>
                                <td id="links" style="text-align:center; vertical-align:central; padding:2px;">
            	<?
					if($saldo >= '5.0000'){
				?>
					<? if(isset($row['Telefono1'])&& count($row['Telefono1'])>0){ ?>
                    &nbsp;
    	            <button type="button" class="btn btn-primary linkSms" title="Clic - Enviar SMS" style="width:60px;" 
						onclick="generaLinkEnvio('linkSms', '<?= $row['Telefono1']; ?>', '', '')"
					>
                    	<span class="fa fa-mobile" aria-hidden="true"></span>
                    </button>
                    <? } ?>
					<? if(isset($row['Telefono1'])&& count($row['Telefono1'])>0){ ?>
                    &nbsp;
                    <button type="button" class="btn btn-primary linkWhatSapp" title="Clic - Enviar WhatSapp" style="width:60px;" 
                    	onclick="generaLinkEnvio('linkWhatSapp', '<?= $row['Telefono1']; ?>', '', '')"
					>
                    	<span class="fa fa-whatsapp" aria-hidden="true"></span>
                    </button>
                    <? } ?>
					<? if(isset($row['EMail1'])&& count($row['EMail1'])>0){ ?>
                    &nbsp;
    	            <button type="button" class="btn btn-primary linkCorreo" title="Clic - Enviar Correo Electrónico" style="width:60px;"
                    	onclick="generaLinkEnvio('linkCorreo', '', '<?= $row['EMail1']; ?>', '')"
					>
                    	<span class="fa fa-envelope-o" aria-hidden="true"></span>
                    </button>
                    <? } ?>
                    &nbsp;
            	<?
					} else {
				?>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar SMS"><span class="fa fa-mobile" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar WhatSapp"><span class="fa fa-whatsapp" aria-hidden="true"></span></button>
	                <button type="button" class="btn btn-secondary" title="Desactivado - Enviar Correo Electrónico"><span class="fa fa-envelope-o" aria-hidden="true"></span></button>
            	<?
					}
				?>
                                </td>
							</tr>
						<?
							}
//						}
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
                <?
				?>
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->
        
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<br />
       	  	</div><!-- /col -->
		</div><!-- /row -->

	</section><!-- /container-fluid -->
<?
	function calculaPolizasRamo($IDCli){
		
			//$IDCli						= $IDCli;
			$wsdata['TypeFormat']		= 'XML';			
			$wsdata['KeyProcess']		= 'REPORT';
			$wsdata['KeyCode']			= 'HWS_DOCTOS';
			$wsdata['Page']				= '1';
			$wsdata['InfoSort']			= 'CatClientes.IDCli';
			$wsdata['ConditionsAdd']	= '
							Cliente Id;2;0;'.$IDCli.';'.$IDCli.';0;-1;DatDocumentos.IDCli
							! 
							Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto
										  ';
			
			$value	= $this->webservice_sicas_soap->getDatosSicas($wsdata);
		
//		$getDatosSicas= $ci->webservice_sicas_soap->getDatosSicas($wsdata);

//		getDatosSicas($wsdata);
		
		return
			$value;
	}
?>
<?php $this->load->view('footers/footer'); ?>