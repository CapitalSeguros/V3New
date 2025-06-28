<?
	$this->load->view('headers/headerApp'); 
?>
<!-- Navbar -->
<?
	$this->load->view('headers/menuApp');
?>
<!-- End navbar -->

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
	$totalResultados = $ListaVendedores->num_rows();
?>
<?
		$usermail	= $this->tank_auth->get_usermail();
		
		if(!isset($coordinadorVendedor)){ $coordinadorVendedor = ""; }
		if(!isset($filtroFechas)){ $filtroFechas = ""; }
		if(!isset($fechaStart)){ $fechaStart = ""; }

		// echo $this->tank_auth->get_idTipoUser();
		// echo $this->session->userdata["usermail"];

		switch($usermail){			
			// Ver Solo El
			default :	
				//echo "z";
				$filtroTipoUser = "
										And
										`persona`.`emailUsers` = '".$usermail."'
								  ";
				$filtroVer = "AGENT";
			break;
			
			// Ver Todos
			case "DIRECTORGENERAL@AGENTECAPITAL.COM":
				//echo "x";
				$filtroTipoUser = "
										And
										`persona`.`userEmailCreacion` Like '%".$coordinadorVendedor."%'
								  ";
				$filtroVer = "DIRECT";
			break;
			
			// Ver Solo Sus Agentes
			case "COORDINADOR@CAPCAPITAL.COM.MX":
			case "COORDINADOR@ASESORESCAPITAL.COM":
			case "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX":
			case "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM":
			case "SUBGERENTE@CAPCAPITAL.COM.MX":
			case "GERENTE@FIANZASCAPITAL.COM":
				//echo "y";
				$filtroTipoUser = "
										And
										`persona`.`userEmailCreacion` = '".$usermail."'
								  ";
				$filtroVer = "COORDINA";
			break;
		}
//		echo "<pre>";
	//		print_r($_REQUEST);
//		echo "</pre>";
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script language="javascript" type="text/javascript">
	$(function(){
		$("#fechaini").datepicker({
			dateFormat: 'yy-mm-dd',
		});
	});

	$(function(){
		$("#fechafin").datepicker({
			dateFormat: 'yy-mm-dd',
		});
	});
	
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

    function OnScrollDiv(Scrollablediv){
		document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
		document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
	}

	window.onload = function(){
		MakeStaticHeader('Mitabla', 350, 1450, 40, false)
	}
 </script>

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Proyecto 100</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Concentrado</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>
    
    <section class="container-fluid"><!-- container-fluid -->
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<h3 class="titulo-secciones">Reporte Puntaje Global P100</h3>
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
			<form  
				method="post" class="form" role="formreferidos"
				id="formreferidos" name="formreferidos"
				action="<?=base_url()?>crmproyecto/consultaxfechas/" 
			>
			<?
				if($filtroVer == "DIRECT" || $filtroVer == "CORDINA"){
			?>
            	<div class="row">
					<div class="col-sm-12 col-md-12">
						<label for="coordinadorVendedor"><strong>Coordinador</strong></label>
                        <select name="coordinadorVendedor" id="coordinadorVendedor" class="form-control">
                           	<option value="">Seleccione</option>
							<option 
                            	value="COORDINADOR@ASESORESCAPITAL.COM" 
								<?= 
								($usermail == "COORDINADOR@ASESORESCAPITAL.COM" || $coordinadorVendedor == "COORDINADOR@ASESORESCAPITAL.COM")?
								"selected":""
								?>
                            >
                            	COORDINADOR@ASESORESCAPITAL.COM
                            </option>
                           	<option 
                            	value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" 
								<?= 
								($usermail == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" || $coordinadorVendedor == "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX")?
								"selected":""
								?>
							>
                            	COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX
                            </option>
                           	<option 
                            	value="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" 
								<?= 
								($usermail == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || $coordinadorVendedor == "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM")?
								"selected":""
								?>
							>
                            	COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM
							</option>
                           	<option 
                            	value="GERENTE@FIANZASCAPITAL.COM" 
								<?= 
								($usermail == "GERENTE@FIANZASCAPITAL.COM" || $coordinadorVendedor == "GERENTE@FIANZASCAPITAL.COM")?"selected":""
								?>	
							>
                            	GERENTE@FIANZASCAPITAL.COM
                            </option>
						</select>
					</div>
				</div>
				<br />
			<?
				}
			?>

        <div class="row">
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
	            	&nbsp;
                </div><!-- /form-group -->
			</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="fechaini">Fecha Inicial: </label>    
					<input type="text"  name="fechaini" id="fechaini" class="form-control" placeholder="Fecha Inicial" required="">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="fechafin">Fecha Final:</label>
					<input type="text"  name="fechafin" id="fechafin" class="form-control" placeholder="Fecha Final" required="">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
		<div class="row">        
        	<div class="col-sm-12 col-md-12" align="right">
				<div class="form-group">
					<input 
						type="submit" name="button" id="button" 
						value="Consultar Puntos" 
						class="btn btn-primary"
					>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
            </form>
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- <div id="DivRoot" align="left"> -->
				<!-- <div style="overflow: hidden;" id="DivHeaderRow"></div> -->
				<!-- <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent"> -->
				<div class="table-responsive">
					<table class="table" id='Mitabla'>
						<thead>
							<tr>
								<th>Nombre del Agente</th>
								<th>Email</th>
								<th>Puntaje Global</th>
								<th>Puntaje Perfilado</th>				                                
								<th>Puntaje Contactado</th>			                                
								<th>Puntaje Citado</th>
								<th>Puntaje Cotizado</th>	
								<th>Puntaje Pagado</th>		
							</tr>
						</thead>
						<tbody>
						<?
							$fin=$fechaini;
							$ffin=$fechafin;
							if($ListaVendedores != FALSE){
								foreach ($ListaVendedores->result() as $row){
						?>
							<tr>
								<?
									$correoProcedente=$row->email;
									$sqlConsultaPuntosGlobales = "
										Select sum(pj.PuntosGenerados) as globalito from puntaje pj
											left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
										Where 
											ca.callcenter is null
											and pj.Usuario='".$correoProcedente."' 
											and cast(pj.FechaRegistro as date)>='".$fin."'  
											and cast(pj.FechaRegistro as date)<='".$ffin."'
										Group by pj.Usuario
																 ";
									$queryPuntosGlobales  = $this->db->query($sqlConsultaPuntosGlobales);
									
      /////////////////////////////////////////////////////////////////////////////////////////PARA PERFILADOS
									$sqlconsultaPuntosPerfilados = "
        select sum(pj.PuntosGenerados) as perfiladito from puntaje pj
         left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
        and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PERFILADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
									$queryPuntosperfilados  = $this->db->query($sqlconsultaPuntosPerfilados);
									
      ///////////////////////////////////////////////////////////////////////////////////// PARA CONTACTADOS
									$sqlconsultaPuntosContactados = "
        select sum(pj.PuntosGenerados) as contactaditos from puntaje pj
         left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
        and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='CONTACTADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
									$queryPuntoscontactados = $this->db->query($sqlconsultaPuntosContactados);
									
      ///////////////////////////////////////////////////////////////////////////////////// PARA REGISTRADAS CITAS
									$sqlconsultaPuntosRegistrados = "
        select sum(pj.PuntosGenerados) as registraditos from puntaje pj
         left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
        and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='REGISTRADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
									$queryPuntosRegistrados = $this->db->query($sqlconsultaPuntosRegistrados);
									
      ///////////////////////////////////////////////////////////////////////////////////// COTIZADOS
									$sqlconsultaPuntosCotizados = "
        select sum(pj.PuntosGenerados) as cotizaditos from puntaje pj
         left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
        and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='COTIZADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
									$queryPuntosCotizados = $this->db->query($sqlconsultaPuntosCotizados);
									
      ///////////////////////////////////////////////////////////////////////////////////// PAGADOS
									$sqlconsultaPuntosPagados = "
        select sum(pj.PuntosGenerados) as pagaditos from puntaje pj
         left join clientes_actualiza ca on ca.IDCli=pj.IDCliente
 where ca.callcenter is null
        and pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PAGADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
									$queryPuntosPagados = $this->db->query($sqlconsultaPuntosPagados);
									$globalito='0';
									if(!empty($queryPuntosGlobales)){
										foreach ($queryPuntosGlobales->result() as $Registro){
											$globalito=$Registro->globalito;
										}
									}

									$perfiladito='0';
									if(!empty($queryPuntosperfilados)){
										foreach($queryPuntosperfilados->result() as $Registro){
											$perfiladito=$Registro->perfiladito;
										}
									}

									$contactaditos='0';
									if(!empty($queryPuntoscontactados)){
										foreach ($queryPuntoscontactados->result() as $Registro){
											$contactaditos=$Registro->contactaditos;  
										}
									}
									
									$registraditos='0'; 
									if(!empty($queryPuntosRegistrados)){
										foreach ($queryPuntosRegistrados->result() as $Registro){
											$registraditos=$Registro->registraditos;
										}
									}

									$cotizaditos='0';
									if(!empty($queryPuntosCotizados)){
										foreach($queryPuntosCotizados->result() as $Registro){
											$cotizaditos=$Registro->cotizaditos;
										}
									}

									$pagaditos='0'; 
									if(!empty($queryPuntosPagados)){
										foreach ($queryPuntosPagados->result() as $Registro){
											$pagaditos=$Registro->pagaditos;
										}
									}
								?>
								<td><?= $row->name_complete; ?></td>
								<td><?= $row->email; ?></td>
								<td><?= $globalito; ?></td>
								<td><?= $perfiladito;?></td>
								<td><?= $contactaditos;?></td>
								<td><?= $registraditos;?></td>
								<td><?= $cotizaditos;?></td>
								<td><?= $pagaditos;?></td>
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
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->
	</section><!-- /container-fluid -->
<?php $this->load->view('footers/footer'); ?>