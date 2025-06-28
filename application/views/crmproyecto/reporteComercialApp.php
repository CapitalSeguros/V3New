<?

	$usermail	= $this->tank_auth->get_usermail();
	if(!isset($emailCoordinador)){ $emailCoordinador = ""; }
	if(!isset($filtroFechas)){ $filtroFechas = ""; }
	if(!isset($fechaStart)){ $fechaStart = ""; }
	if(!isset($fechaEnd)){ $fechaEnd = ""; }

	switch($usermail){
		default :
			$filtroTipoUser = "And `persona`.`emailUsers` = '".$usermail."'";
			$filtroVer = "AGENT";
		break;
			
		// Ver Todos
		case "DIRECTORGENERAL@AGENTECAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` Like '%".$emailCoordinador."%'";
			$filtroVer = "DIRECT";
		break;
			
		// Ver Solo Sus Agentes
		case "COORDINADOR@CAPCAPITAL.COM.MX":
		case "COORDINADOR@ASESORESCAPITAL.COM":
		case "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX":
		case "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM":
		case "SUBGERENTE@CAPCAPITAL.COM.MX":
		case "GERENTE@FIANZASCAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` = '".$usermail."'";
			$filtroVer = "COORDINA";
		break;
	}

	if($filtroFechas == "si"){
		$filtradoFechas	= "`puntaje`.`FechaRegistro` Between '".$fechaStart."' And '".$fechaEnd."'";
	} else {
		$filtradoFechas = "`puntaje`.`FechaRegistro` Between '".$year."-".$month."-01' And '".$year."-".$month."-31'";
	}
		
	function CalculaEdosAgente($usuario,$year,$month,$edo,$filtradoFechas){
		$sql = "Select Count(*) As total From `puntaje` Where `usuario` = '".$usuario."' And `EdoActual` = '".$edo."' And
				".$filtradoFechas."";
		$result = mysql_fetch_assoc(mysql_query($sql));
		return
			$result['total'];
	}
	
	$ListaVendedores = array();
	$mes['01'] = "Enero";$mes['02'] = "Febrero";$mes['03'] = "Marzo";$mes['04'] = "Abril";$mes['05'] = "Mayo";$mes['06'] = "Junio";$mes['07'] = "Julio";$mes['08'] = "Agosto";$mes['09'] = "Septiembre";$mes['10'] = "Octubre";$mes['11'] = "Noviembre";$mes['12'] = "Diciembre";
?>
<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->
<!-- -->
		<div class="panel panel-default">
			<div class="panel-body">                
                <form method="post" class="form" role="formReporteComercial" id="formReporteComercial" name="formReporteComercial" action="<?= base_url("crmproyecto")?>/verReporteComercial">
			<? if($filtroVer == "DIRECT" || $filtroVer == "CORDINA"){ ?>
            	<div class="row">
					<div class="col-sm-12 col-md-12">
						<label for="month"><strong>Coordinador</strong></label>
                        <select name="emailCoordinador" id="emailCoordinador" class="form-control">
                           	<option value="">Seleccione</option>

                            <?php foreach ($coordinadores as $value): ?>
                            	<option value="<?= $value->email ?>" <?= ($usermail == $value->email || $emailCoordinador == $value->email)?"selected":""
								?>	
							>
                            	<?= $value->nombres.' '.$value->apellidoPaterno.' '.$value->apellidoMaterno.' ('.$value->email.')' ;?>
                            </option>
                            	
                            <?php endforeach ?>
						</select>
					</div>
				</div>
				<br />
			<?
				}
			?>
            	<div class="row">
						<div class="col-sm-6 col-md-6">
		    		        <label for="year"><strong>A&ntilde;o</strong></label>
                        	<select name="year" id="year" class="form-control">
                            	<option value="">Seleccione</option>
                            	<option value="2018" <?= ($year=="2018")? "selected":""?>>2018</option>
                            	<option value="2019" <?= ($year=="2019")? "selected":""?>>2019</option> 
                            </select>
                        </div>
						<div class="col-sm-6 col-md-6">
		    		        <label for="month"><strong>Mes</strong></label>
                        	<select name="month" id="month" class="form-control">
                            	<option value="">Seleccione</option>
                            	<option value="01" <?= ($month=="01")? "selected":""?>>Enero</option>
                            	<option value="02" <?= ($month=="02")? "selected":""?>>Febrero</option>
                            	<option value="03" <?= ($month=="03")? "selected":""?>>Marzo</option>
                            	<option value="04" <?= ($month=="04")? "selected":""?>>Abril</option>
                            	<option value="05" <?= ($month=="05")? "selected":""?>>Mayo</option>
                            	<option value="06" <?= ($month=="06")? "selected":""?>>Junio</option>
                            	<option value="07" <?= ($month=="07")? "selected":""?>>Julio</option>
                            	<option value="08" <?= ($month=="08")? "selected":""?>>Agosto</option>
                            	<option value="09" <?= ($month=="09")? "selected":""?>>Septiembre</option>
                            	<option value="10" <?= ($month=="10")? "selected":""?>>Octubre</option>
                            	<option value="11" <?= ($month=="11")? "selected":""?>>Noviembre</option>
                            	<option value="12" <?= ($month=="12")? "selected":""?>>Diciembre</option>
                            </select>
                        </div>
                </div>
                <br />
				<div class="row">
                	<div class="col-sm-2 col-md-2">
	    		        <label for="month"><strong>Activar Filtro Fechas</strong></label>
                    	<input type="hidden" name="filtroFechas" id="filtroFechas" value="<?=$this->input->post('filtroFechas',TRUE)?>">
                        <label style="alignment-baseline:central;">
							Filtro Fechas:
							<input type="checkbox" name="filtroFechasChec" id="filtroFechasChec" value="si"
								<?=($filtroFechas=="si")?'checked="checked"':''?> 
								title="Click para activar el filtro por rango de fechas"
							/>
						</label>
                	</div>
                	<div class="col-sm-5 col-md-5">
                        <label for="fechaStart">Inicio</label>
						<input
							type="text" name="fechaStart" id="fechaStart"
							class="form-control input-sm fecha fechaStart"
							placeholder="1900-01-01"
							value="<?=($fechaStart != "")? date('Y-m-d') : $fechaStart?>"
							title="Fecha de Inicio"
						/>
                	</div>
                	<div class="col-sm-5 col-md-5">
						<label for="fechaEnd">Fin</label>
						<input
							type="text" name="fechaEnd" id="fechaEnd"
							class="form-control input-sm fecha fechaEnd"
							placeholder="1900-01-01"
							value="<?=($fechaEnd != "")? date('Y-m-d') : $fechaEnd?>"
							title="Fecha de Fin" autocomplete="off"
						/>
                	</div>
				</div>
                <br />
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
                    	<input 
                    		type="button" name="button" id="button" 
                        	value="Cargar Reporte" class="btn btn-primary" 
                        	onclick="SendForm_ReporteComercial()" 
						/>
					</div>
                </div>
				</form>
                <br /><br />
                <?
				if(
					($year != "" && $month != "")
					||
					($fechaStart != "" && $fechaEnd != "")
				){
				?>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
						<h3><center><strong>
							<?
								if($month != ""){
									print($mes[$month]." ".$year);
								} else if($filtroFechas != "") {
									print($fechaStart." - ".$fechaEnd);
								}
							?>
                        </strong></center></h3>
                    </div>
				</div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
	                    <div class="table-responsive">
                    <!-- Consolidados -->
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Agentes Consolidados</th>
									<th scope="col">Perfilados</th>
									<th scope="col">Primera Cita</th>
									<th scope="col">Segunda Cita</th>
									<th scope="col">Emisiones</th>
								</tr>
							</thead>
							<tbody>
                            	<?
								$SqlAgentes = "
			Select
				`persona`.`idPersona`,
				(if(`persona`.`nombres` is null,'',`persona`.`nombres`)) as `nombre`,
				(if(`persona`.`apellidoPaterno` is null,'',`persona`.`apellidoPaterno`)) as `apellidoPaterno`,
				(if(`persona`.`apellidoMaterno` is null,'',`persona`.`apellidoMaterno`)) as `apellidoMaterno`, 
				`personatipoagente`.`personaTipoAgente`,
				(if(`persona`.`idpersonarankingagente` is null,'',`persona`.`idpersonarankingagente`)) as `ranking`,
				(if(`catalog_sucursales`.`NombreSucursal` is null,'',`catalog_sucursales`.`NombreSucursal`)) as `sucursal`,
				`catalog_canales`.`nombreTitulo`,
				(cast(`persona`.`fecAltaSistemPersona` as date)) as `fecAltaSistemPersona`,
				`catalog_vendedores`.`promotoriasActivadasCP`,
				`users`.`id`,
				`users`.`IdSucursal`,
				`users`.`name_complete`,
				`users`.`email`,
				`users`.`idVend`,
				`users`.`celularSMS`
			From 
				`persona` Left Join `users`
				On 
				`users`.`idPersona` = `persona`.`idPersona` Left Join `personatipoagente`
				On `personatipoagente`.`idPersonaTipoAgente` = `persona`.`personaTipoAgente` Left Join `catalog_sucursales`
				On `catalog_sucursales`.`IdSucursal` = `persona`.`id_catalog_sucursales` Left Join `catalog_canales`
				On `catalog_canales`.`IdCanal` = `persona`.`id_catalog_canales` Left Join `catalog_vendedores`
				On `catalog_vendedores`.`idPersona` = `persona`.`idPersona`
			Where 
				`persona`.`tipoPersona` = '3' 
				and 
				`users`.`banned` = '0'
				and 
				`users`.`activated` = '1'
				And
				`persona`.`personaTipoAgente` = '2'
				".$filtroTipoUser."
											  ";
	

								$resultAgentes = $this->db->query($SqlAgentes);
								$contPerf = $contCont = $contCot = $contReg = 0;
								foreach($resultAgentes->result() as $rowAgente ){
									$ListaVendedores[] = array(
																"idPersona" => $rowAgente->idPersona,
																"nombre" => $rowAgente->nombre,
																"apellidoPaterno" => $rowAgente->apellidoPaterno,
																"apellidoMaterno" => $rowAgente->apellidoMaterno,
																"personaTipoAgente" => $rowAgente->personaTipoAgente,
																"ranking" => $rowAgente->ranking,
																"sucursal" => $rowAgente->sucursal,
																"nombreTitulo" => $rowAgente->nombreTitulo,
																"fecAltaSistemPersona" => $rowAgente->fecAltaSistemPersona,
																"promotoriasActivadasCP" => $rowAgente->promotoriasActivadasCP,
																"id" => $rowAgente->id,
																"IdSucursal" => $rowAgente->IdSucursal,
																"name_complete" => $rowAgente->name_complete,
																"email" => $rowAgente->email,
																"idVend" => $rowAgente->idVend,
																"celularSMS" => $rowAgente->celularSMS
															);

								?>
								<tr>
									<th scope="row" title="<?=$rowAgente->email?>"><?= $this->capsysdre->NombreUsuarioEmail($rowAgente->email)?></th>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"PERFILADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"CONTACTADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"COTIZADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"REGISTRADO",$filtradoFechas); ?></td>
								</tr>
                                <?
									$contPerf = CalculaEdosAgente($rowAgente->email,$year,$month,"PERFILADO",$filtradoFechas) + $contPerf;
									$contCont = CalculaEdosAgente($rowAgente->email,$year,$month,"CONTACTADO",$filtradoFechas) + $contCont;
									$contCot = CalculaEdosAgente($rowAgente->email,$year,$month,"COTIZADO",$filtradoFechas) + $contCot;
									$contReg = CalculaEdosAgente($rowAgente->email,$year,$month,"REGISTRADO",$filtradoFechas) + $contReg;
								}
								?>
							</tbody>
                            <tfoot>
                            	<tr>
                                	<td>Totales</td>
                                	<td><?= $contPerf; ?></td>
                                	<td><?= $contCont; ?></td>
                                	<td><?= $contCot; ?></td>
                                	<td><?= $contReg; ?></td>
                                </tr>
                                <tr>
                                	<td>Total Agentes Consolidados</td>
                                    <td><?= $resultAgentes->num_rows() ?></td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
						</table>
                    <!-- -->
	                    </div>
                    </div>
                </div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
                    <?
						$dat_Actividades = "10 , 20 , 30 , 40";
					?>
                    <!-- 
                    <img src="<?= base_url(); ?>assets/plugins/GraPHPico_0-0-3/graphref.php?ref=23&typ=2&dim=5&bkg=FFFFFF" /> 
                    -->
					<!--
                    <img src="<?=$graficaBarras.trim($dat_Actividades, ',')."&bkg=FFFFFF&wdt=300&hgt=200"?>">
                    -->
                    <!-- <img src="<?=$graficaPorcen.trim($dat_Actividades, ',')."&bkg=FFFFFF&wdt=300&hgt=200"?>"> -->
                    <br />
                    </div>
                </div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
	                    <div class="table-responsive">
                    <!-- Formacion -->
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Agentes en Formacion</th>
									<th scope="col">Perfilados</th>
									<th scope="col">Primera Cita</th>
									<th scope="col">Segunda Cita</th>
									<th scope="col">Emisiones</th>
								</tr>
							</thead>
							<tbody>
                            	<?
								$SqlAgentes = "
			Select
				`persona`.`idPersona`,
				(if(`persona`.`nombres` is null,'',`persona`.`nombres`)) as `nombre`,
				(if(`persona`.`apellidoPaterno` is null,'',`persona`.`apellidoPaterno`)) as `apellidoPaterno`,
				(if(`persona`.`apellidoMaterno` is null,'',`persona`.`apellidoMaterno`)) as `apellidoMaterno`, 
				`personatipoagente`.`personaTipoAgente`,
				(if(`persona`.`idpersonarankingagente` is null,'',`persona`.`idpersonarankingagente`)) as `ranking`,
				(if(`catalog_sucursales`.`NombreSucursal` is null,'',`catalog_sucursales`.`NombreSucursal`)) as `sucursal`,
				`catalog_canales`.`nombreTitulo`,
				(cast(`persona`.`fecAltaSistemPersona` as date)) as `fecAltaSistemPersona`,
				`catalog_vendedores`.`promotoriasActivadasCP`,
				`users`.`id`,
				`users`.`IdSucursal`,
				`users`.`name_complete`,
				`users`.`email`,
				`users`.`idVend`,
				`users`.`celularSMS`
			From 
				`persona` Left Join `users`
				On 
				`users`.`idPersona` = `persona`.`idPersona` Left Join `personatipoagente`
				On `personatipoagente`.`idPersonaTipoAgente` = `persona`.`personaTipoAgente` Left Join `catalog_sucursales`
				On `catalog_sucursales`.`IdSucursal` = `persona`.`id_catalog_sucursales` Left Join `catalog_canales`
				On `catalog_canales`.`IdCanal` = `persona`.`id_catalog_canales` Left Join `catalog_vendedores`
				On `catalog_vendedores`.`idPersona` = `persona`.`idPersona`
			Where 
				`persona`.`tipoPersona` = '3' 
				and 
				`users`.`banned` = '0'
				and 
				`users`.`activated` = '1'
				And
				`persona`.`personaTipoAgente` = '1'
				".$filtroTipoUser."
											  ";

								$resultAgentes = $this->db->query($SqlAgentes);																
								$contPerf = $contCont = $contCot = $contReg = 0;								
								foreach($resultAgentes->result() as $rowAgente ){
									$ListaVendedores[] = array(

																"idPersona" => $rowAgente->idPersona,
																"nombre" => $rowAgente->nombre,
																"apellidoPaterno" => $rowAgente->apellidoPaterno,
																"apellidoMaterno" => $rowAgente->apellidoMaterno,
																"personaTipoAgente" => $rowAgente->personaTipoAgente,
																"ranking" => $rowAgente->ranking,
																"sucursal" => $rowAgente->sucursal,
																"nombreTitulo" => $rowAgente->nombreTitulo,
																"fecAltaSistemPersona" => $rowAgente->fecAltaSistemPersona,
																"promotoriasActivadasCP" => $rowAgente->promotoriasActivadasCP,
																"id" => $rowAgente->id,
																"IdSucursal" => $rowAgente->IdSucursal,
																"name_complete" => $rowAgente->name_complete,
																"email" => $rowAgente->email,
																"idVend" => $rowAgente->idVend,
																"celularSMS" => $rowAgente->celularSMS
															);
								?>
								<tr>
									<th scope="row" title="<?=$rowAgente->email?>"><?= $this->capsysdre->NombreUsuarioEmail($rowAgente->email)?></th>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"PERFILADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"CONTACTADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"COTIZADO",$filtradoFechas); ?></td>
									<td><?= CalculaEdosAgente($rowAgente->email,$year,$month,"REGISTRADO",$filtradoFechas); ?></td>
								</tr>
                                <?
									$contPerf = CalculaEdosAgente($rowAgente->email,$year,$month,"PERFILADO",$filtradoFechas) + $contPerf;
									$contCont = CalculaEdosAgente($rowAgente->email,$year,$month,"CONTACTADO",$filtradoFechas) + $contCont;
									$contCot = CalculaEdosAgente($rowAgente->email,$year,$month,"COTIZADO",$filtradoFechas) + $contCot;
									$contReg = CalculaEdosAgente($rowAgente->email,$year,$month,"REGISTRADO",$filtradoFechas) + $contReg;
								}
								?>
							</tbody>
                            <tfoot>
                            	<tr>
                                	<td>Totales</td>
                                	<td><?= $contPerf; ?></td>
                                	<td><?= $contCont; ?></td>
                                	<td><?= $contCot; ?></td>
                                	<td><?= $contReg; ?></td>
                                </tr>
                                <tr>
                                	<td>Total Agentes en Formacion</td>
                                    <td><?= $resultAgentes->num_rows() ?></td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>
						</table>
                    <!-- -->
                    	</div>
                    </div>
                </div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">
                    <?
						$dat_Actividades = "10 , 20 , 30 , 40";
					?>

                    <br />
                    </div>
                </div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">         
	                    <div class="table-responsive">

    <table class="table" id='Mitabla'>
      <thead>
        <tr>
          <th>Sucursal</th>                                       
          <th>Canal</th>                                      
          <th>Nombre</th>
          <th>Autos</th>  
          <th>Daños</th>  
          <th>GMM</th>
          <th>Vida</th>
          <th>Total Cotizacion</th>
          <th>Autos</th>
          <th>Daños</th>  
          <th>GMM</th>
          <th>Vida</th>
           <th>Total Emision</th>
          <th>Autos</th>
          <th>Daños</th>
          <th>GMM</th>
          <th>Vida</th>
          <th>Total Endosos</th>
          <th>Global</th>
        </tr>
      </thead>
      <tbody>   
      <?php

      if(isset($ListaVendedores)){
        $sumaAgrupacionVendedor=0;$sumaAgrupacionTotal=0;
        foreach ($ListaVendedores as $row){$sumaAgrupacionVendedor=0;

			if($filtroFechas == "si"){
				echo "";

			} else {								
				$fechaStart = $year."-".$month."-01";//$this->input->get('fechaStart');
				$fechaEnd = $year."-".$month."-31";//$this->input->get('fechaEnd');
			}
      ?>
        <tr>
          <td><?=$row['sucursal']?></td>
          <td><?=$row['nombreTitulo']?></td>
          <td><?=$row['nombre'].' '.$row['apellidoPaterno'].' '.$row['apellidoMaterno']?></td>
          <? //COTIZACIONES AUTOS
            //$fechaStart=$this->input->get('fechaStart');
            //$fechaEnd=$this->input->get('fechaEnd');

                                 $sqlConsultacotizacionesAUTOS = "
                                 select count(act.folioActividad) as numcot from actividades act 
                                 where act.tipoActividad='Cotizacion'
                                 and act.ramoActividad='VEHICULOS'
                                 and act.usuarioVendedor='".$row['email']."'
                                 and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                                 ";
                                 $queryConsultaCotizacionAUTOS  = $this->db->query($sqlConsultacotizacionesAUTOS);
                                if($queryConsultaCotizacionAUTOS->num_rows()>0){
                                	$detalleUser = $queryConsultaCotizacionAUTOS->result();
								}
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                               <? //COTIZACIONES DAÑOS
                                  //$fechaStart=$this->input->get('fechaStart');
                                  //$fechaEnd=$this->input->get('fechaEnd');
        

                                $sqlConsultacotizacionesDANOS = "
        select count(act.folioActividad) as numcot from actividades act 
        where act.tipoActividad='Cotizacion'
        and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS')
        and act.usuarioVendedor='".$row['email']."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaCotizacionDANOS  = $this->db->query($sqlConsultacotizacionesDANOS);


                                if($queryConsultaCotizacionDANOS->num_rows()>0){
                                $detalleUser = $queryConsultaCotizacionDANOS->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                              <? //COTIZACIONES gMM
                                 //$fechaStart=$this->input->get('fechaStart');
                                 //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultacotizacionesLP= "
        select count(act.folioActividad) as numcot from actividades act 
        where act.tipoActividad='Cotizacion'
        and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES')
        and act.usuarioVendedor='".$row['email']."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaCotizacionLP = $this->db->query($sqlConsultacotizacionesLP);


                                if($queryConsultaCotizacionLP->num_rows()>0){
                                $detalleUser = $queryConsultaCotizacionLP->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                              <? //COTIZACIONES VIDA
                                 //$fechaStart=$this->input->get('fechaStart');
                                 //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultacotizacionesVIDA= "
        select count(act.folioActividad) as numcot from actividades act 
        where act.tipoActividad='Cotizacion'
        and (act.ramoActividad='VIDA')
        and act.usuarioVendedor='".$row['email']."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaCotizacionVIDA = $this->db->query($sqlConsultacotizacionesVIDA);


                                if($queryConsultaCotizacionVIDA->num_rows()>0){
                                $detalleUser = $queryConsultaCotizacionVIDA->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                              <td class="totalAgrupacion"   ><?php echo($sumaAgrupacionVendedor);?></td>


                            <? //EMISION AUTOS
                               //$fechaStart=$this->input->get('fechaStart');
                               //$fechaEnd=$this->input->get('fechaEnd');
                                  $sumaAgrupacionVendedor=0;

                                 $sqlConsultaEmisionsAUTOS = "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.ramoActividad='VEHICULOS'
        and act.usuarioVendedor='".$row['email']."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionAUTOS = $this->db->query($sqlConsultaEmisionsAUTOS);


                                if($queryConsultaEmisionAUTOS->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionAUTOS->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>

                                <? //EMISION DAÑOS
                                   //$fechaStart=$this->input->get('fechaStart');
                                   //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionDANOS = "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS')
        and act.usuarioVendedor='".$row['email']."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionDANOS = $this->db->query($sqlConsultaEmisionDANOS);


                                if($queryConsultaEmisionDANOS->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionDANOS->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                               <? //EMISION gmm
                                  //$fechaStart=$this->input->get('fechaStart');
                                  //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionGMM= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.usuarioVendedor='".$row['email']."'
        and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionGMM  = $this->db->query($sqlConsultaEmisionGMM);


                                if($queryConsultaEmisionGMM->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionGMM->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                              <? //EMISION VIDA
                                 //$fechaStart=$this->input->get('fechaStart');
                                 //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionVIDA= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.usuarioVendedor='".$row['email']."'
        and (act.ramoActividad='VIDA')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionVIDA  = $this->db->query($sqlConsultaEmisionVIDA);


                                if($queryConsultaEmisionVIDA->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionVIDA->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                               <td class="totalAgrupacion"  ><?php echo($sumaAgrupacionVendedor);?></td>



                              <? //ENDOSO CANCELACION AUTOS
                                 //$fechaStart=$this->input->get('fechaStart');
                                 //$fechaEnd=$this->input->get('fechaEnd');
                                 $sumaAgrupacionVendedor=0;

                                 $sqlConsultaEndosoAUTOS= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row['email']."')
        and (act.ramoActividad='VEHICULOS')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoAUTOS  = $this->db->query($sqlConsultaEndosoAUTOS);


                                if($queryConsultaEndosoAUTOS->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoAUTOS->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                                 <? //ENDOSO CANCELACION daños
                                  //$fechaStart=$this->input->get('fechaStart');
                                  //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoDanos= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row['email']."')
        and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoDanos  = $this->db->query($sqlConsultaEndosoDanos);


                                if($queryConsultaEndosoDanos->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoDanos->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                                <? //ENDOSO CANCELACION gmm
                                   //$fechaStart=$this->input->get('fechaStart');
                                   //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoGMM= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row['email']."')
        and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoGMM  = $this->db->query($sqlConsultaEndosoGMM);


                                if($queryConsultaEndosoGMM->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoGMM->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                                <? //ENDOSO CANCELACION voida
                                   //$fechaStart=$this->input->get('fechaStart');
                                   //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoLP= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row['email']."')
        and (act.ramoActividad='VIDA')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoLP  = $this->db->query($sqlConsultaEndosoLP);


                                if($queryConsultaEndosoLP->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoLP->result();}
    
                              ?>
                              <td><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                              <td class="totalAgrupacion"  ><?php echo($sumaAgrupacionVendedor); ?></td>


                                <? //GLOBALES
                                   //$fechaStart=$this->input->get('fechaStart');
                                   //$fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaGlobal= "
        select count(act.folioActividad) as numcot from actividades act 
        where  (act.usuarioVendedor='".$row['email']."')
        and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   "." and tipoActividad!='PagoCobranza'";
       $queryGlobal  = $this->db->query($sqlConsultaGlobal);


                                if($queryGlobal->num_rows()>0){
                                $detalleUser = $queryGlobal->result();}
    
                              ?>
                              <td class="totalesAgente"><? echo $detalleUser[0]->numcot ;?></td>
                          
        </tr>
      <?php
        }
      }
      ?>
      </tbody>             

    </table>

	                    </div>
					</div>
				</div> 
                <?
				}
				?>
            </div><!-- panel-body -->
		</div><!-- panel-default -->
<script>
	var fechaStart =
	$('.fechaStart').datepicker({
		



		format:   "yyyy-mm-dd",
		startDate:  "",
		language: "es",
		autoclose:  true
	});
  
	var fechaEnd =
	$('.fechaEnd').datepicker({
		format:   "yyyy-mm-dd",
		startDate:  "",
		language: "es",
		autoclose:  true
	});

<?
	echo('document.getElementById("fechaStart").value=\''.$fechaStart.'\';');
	echo('document.getElementById("fechaEnd").value=\''.$fechaEnd.'\';');
?>
</script>
<script>
/*	function SendForm_ReporteComercial(){
		var formulario	= document.getElementById('formReporteComercial');
		var year		= document.getElementById('year').value;
		var month		= document.getElementById('month').value;
		var filtroFechasChec = document.getElementById('filtroFechasChec').value;
		
		if((year!='' && month!='') || filtroFechasChec != ''){
					document.formReporteComercial.submit();
		} else {
					alert('No capturaste Año ó Mes');
		}
	}	*/
</script>
<?
	$this->load->view('footers/footer'); 
?>
<style type="text/css">
	.totalAgrupacion{background-color: #948c8c}
	.totalesAgente{background-color: #9cdcb0}
</style>