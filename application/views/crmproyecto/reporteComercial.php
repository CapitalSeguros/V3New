<?
	$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
?>
<?
?>

<?
$in='';
	$usermail	= $this->tank_auth->get_usermail();
	if(!isset($emailCoordinador)){ $emailCoordinador = ""; }
	if(!isset($filtroFechas)){ $filtroFechas = ""; }
	if(!isset($fechaStart)){ $fechaStart = ""; }
	if(!isset($fechaEnd)){ $fechaEnd = ""; }
    $ListaVendedores=array();
	switch($usermail){

			
		// Ver Todos
		case "DIRECTORGENERAL@AGENTECAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` Like '%".$emailCoordinador."%'";
			$filtroVer = "DIRECT";
		break;
			
		// Ver Solo Sus Agentes
		/*case "COORDINADOR@CAPCAPITAL.COM.MX":
		case "COORDINADOR@ASESORESCAPITAL.COM":
		case "COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX":
		case "COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM":
		case "SUBGERENTE@CAPCAPITAL.COM.MX":*/
		case "GERENTE@FIANZASCAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` = '".$usermail."'";
			$filtroVer = "COORDINA";
		break;
				case "SISTEMAS@ASESORESCAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` Like '%".$emailCoordinador."%'";
			$filtroVer = "DIRECT";
		break;
				// Ver Todos
		case "DIRECTORCOMERCIAL@AGENTECAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` Like '%".$emailCoordinador."%'";
			$filtroVer = "DIRECT";
		break;

		case "GERENTECOMERCIAL@AGENTECAPITAL.COM":
			$filtroTipoUser = "And `persona`.`userEmailCreacion` Like '%".$emailCoordinador."%'";
			$filtroVer = "DIRECT";
		break;
				default :
				
		
		    if($esCoordinador==1) {
		    	$filtroVer = 'CORDINA';
		    	$filtroTipoUser = "And `persona`.`userEmailCreacion` = '".$usermail."'";
		    }
		    else
		    {
		    	 $filtroVer = 'AGENT';
			$filtroTipoUser = "And `persona`.`emailUsers` = '".$usermail."'";
		    }
		break;
	}

	if($filtroFechas == "si"){$filtradoFechas	= "`puntaje`.`FechaRegistro` Between '".$fechaStart."' And '".$fechaEnd."'";} 
	else {$filtradoFechas = "`puntaje`.`FechaRegistro` Between '".$year."-".$month."-01' And '".$year."-".$month."-31'";}
	
		
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

	<!--section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Prospeccion de negocios: Reporte Comercial</h3></div></div><hr /> 
	</section-->


<!-- -->
		<div class="panel panel-default">
			<div class="panel-body">                
                <form method="post" class="form" role="formReporteComercial" id="formReporteComercial" name="formReporteComercial" action="<?= base_url("crmproyecto")?>/verReporteComercial">
			<? if($filtroVer == "DIRECT" || $filtroVer == "CORDINA"){ ?>
            	<div style="display: flex">
					<div ><label for="month"><h4>Coordinador</h4></label></div>
					<div>
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
            	<div style="display: flex;justify-content: space-around;">
				<div style="flex: 1;display: flex" >
		    		        <label for="year"><h4>A&ntilde;o</h4></label>
                        	<select name="year" id="year" class="form-control"><?=imprimirFecha($year);?></select>
                        </div>
				 <div style="flex: 1;display: flex">
		    		        <label for="month"><h4>Mes</h4></label>
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
                        <label for="fechaStart" >Inicio</label>
						<input
							type="date" name="fechaStart" id="fechaStart"
							class="form-control  fecha2 fechaStart"
							placeholder="1900-01-01"
							value="<?=($fechaStart != "")? date('Y-m-d') : $fechaStart?>"
							title="Fecha de Inicio"
						/>
                	</div>
                	<div class="col-sm-5 col-md-5">
						<label for="fechaEnd" >Fin</label>
						<input
							type="date" name="fechaEnd" id="fechaEnd"
							class="form-control  fecha2 fechaEnd"
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
                <div>
                	<button class="btn btn-primary" style="background:url(<?=base_url()?>assets/images/iconoxls.png);width: 45px;height: 50px;border: none;background-repeat: none;background-size: contain;cursor: pointer;" id="btnExportarReporteComercial" onclick="exportarReporteComercial()"></button>
                </div>
                <style type="text/css">
                	.tipoAgenteContDiv{max-height: 200px;overflow: auto;}
                	.tipoAgenteContDiv>table>thead{position: sticky;top:0px;}
                </style>
                <?
   
                foreach ($catalogTipoPersona as  $value) 
                {

                ?>
              <div class="tipoAgenteContDiv">
   
							<? $SqlAgentes = "
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
				`users`.`celularSMS`,
							    (SELECT COUNT(usuario) FROM  puntaje WHERE usuario=users.email AND EdoActual='PERFILADO') AS perfilado,
			    (SELECT COUNT(usuario) FROM  puntaje WHERE usuario=users.email AND EdoActual='CONTACTDO') AS contactado,
			    (SELECT COUNT(usuario) FROM  puntaje WHERE usuario=users.email AND EdoActual='COTIZADO') AS cotizado,
			    (SELECT COUNT(usuario) FROM  puntaje WHERE usuario=users.email AND EdoActual='REGISTRADO') AS registrado				 			   

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
				`persona`.`personaTipoAgente` = ".$value['idPersonaTipoAgente']."
				".$filtroTipoUser;

				$vendedoresDatos=$this->db->query($SqlAgentes)->result();
				$totalAgentes=count($vendedoresDatos);
			if($totalAgentes>0){?>
	             <table class="table">
                	<thead>
								<tr>
									<th scope="col"><?=$value['personaTipoAgente'];?></th>
									<th scope="col"><div style="text-align: end">Perfilados</div></th>
									<th scope="col"><div style="text-align: end">Primera Cita</div></th>
									<th scope="col"><div style="text-align: end">Segunda Cita</div></th>
									<th scope="col"><div style="text-align: end">Emisiones</div></th>
								</tr>
							</thead>
						<tbody>
			<?
                 $sumPerfilados=0;$sumContactados=0;$sumCotizados=0;$sumRegistrados=0;
				foreach ($vendedoresDatos as  $valueVD) 
				{
                    $arrayLV['sucursal']=$valueVD->sucursal;
                    $arrayLV['nombreTitulo']=$valueVD->nombreTitulo;
                    $arrayLV['nombre']=$valueVD->nombre;
                    $arrayLV['apellidoPaterno']=$valueVD->apellidoPaterno;
                    $arrayLV['apellidoMaterno']=$valueVD->apellidoMaterno;
                    $arrayLV['email']=$valueVD->email;
					array_push($ListaVendedores, $arrayLV);
					$sumPerfilados=$sumPerfilados+$valueVD->perfilado;
					$sumContactados=$sumContactados+$valueVD->contactado;
					$sumCotizados=$sumCotizados+$valueVD->cotizado;
					$sumRegistrados=$sumRegistrados+$valueVD->registrado;
								?>
                  <tr class="reporteComercialTR" data-tipo="<?=$value['personaTipoAgente'];?>">
                  	  <td><?=$valueVD->name_complete;?></td>
                  	  <td align="right"><?=$valueVD->perfilado?></td>
                  	  <td align="right"><?=$valueVD->contactado?></td>
                  	  <td align="right"><?=$valueVD->cotizado?></td>
                  	  <td align="right"><?=$valueVD->registrado?></td>
								</tr>
                                <?
				}/*FIN DE $vendedoresDatos*/
											 
			
											  ;?>
<tfoot style="color: black;font-size: 13px;text-decoration-style: solid;text-decoration-line: overline;background-color: #a79e9e;
"><tr><td align="right">TOTAL DE AGENTES:<?=$totalAgentes?></td><td align="right"><?=$sumPerfilados?></td><td align="right"><?=$sumContactados?></td><td align="right"><?=$sumCotizados?></td><td align="right"><?=$sumRegistrados?></td></tr></tfoot>											 
							</tbody>
						</table>
<?}?>                
                    </div>
         <hr>
                <? }/*FIN DEL FOREACH $personaTipoAgente*/?>
                <? if(($year != "" && $month != "") || ($fechaStart != "" && $fechaEnd != "")){?>

   
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right"><?$dat_Actividades = "10 , 20 , 30 , 40";?>
                    <br />
                    </div>
                </div>
                <div class="row">
					<div class="col-sm-12 col-md-12" align="right">         
	                    <div class="table-responsive">


<div class="tipoAgenteContDiv" style="max-height: 400px">
    <table class="table" id='Mitabla'>
      <thead>
        <tr>
      		<th colspan="3" style="text-align: center;">VENDEDOR</th>
            <th colspan="5" style="text-align: center">COTIZACIONES</th>
            <th colspan="5" style="text-align: center">EMISION Y CAPTURA EMISION</th>
            <th colspan="5" style="text-align: center">CANCELACION Y ENDOSO</th>
            <th>TOTALES</th>
      	</tr>
        <tr>
          <th >Sucursal</th>                                       
          <th>Canal</th>                                      
          <th>Nombre</th>
          <th>Autos</th>  
          <th>Daños</th>  
          <th>GMM</th>
          <th>Vida</th>
          <th style="background-color: #a79e9e;color: black">Total Cotizacion</th>
          <th>Autos</th>
          <th>Daños</th>  
          <th>GMM</th>
          <th>Vida</th>
           <th style="background-color: #a79e9e;color: black">Total Emision</th>
          <th>Autos</th>
          <th>Daños</th>
          <th>GMM</th>
          <th>Vida</th>
          <th style="background-color: #a79e9e;color: black">Total Endosos</th>
          <th>Global</th>
        </tr>
      </thead>
      <tbody>   

<?
$sumColCotAutos=0;$sumColCotDanios=0;$sumColCotAcci=0;$sumColCotVida=0;
$sumColEmiAutos=0;$sumColEmiDanios=0;$sumColEmiAcci=0;$sumColEmiVida=0;
$sumColCancelAutos=0;$sumColCancelDanios=0;$sumColCancelAcci=0;$sumColCancelVida=0;
  foreach ($ListaVendedores as $row){?>
  <tr>
   <?
        	       $vehiculosCotizacion=0;$daniosCotizacion=0;$accidentesCotizacion=0;$vidaCotizacion=0;$vehiculosEmisionCaptura=0;$daniosEmisionCaptura=0;$accidentesEmisionCaptura=0;$vidaEmisionCaptura=0;$vehiculosEndosoCancelacion=0;$daniosEndosoCancelacion=0;$accidentesEndosoCancelacion=0;$vidaEndosoCancelacion=0;$sumCotizacion=0;$sumEmision=0;$sumEndoso=0;

    if(isset($_POST['filtroFechasChec']))
    {
    $consulta='select count(a.folioActividad) as total,a.ramoActividad,a.tipoActividad,a.usuarioVendedor from actividades a 
 where  a.tipoActividad IN("Emision","Cotizacion","Cancelacion","CapturaEmision","Endoso") and a.usuarioVendedor="'.$row['email'].'" and cast(a.fechaCreacion as date) between "'.$fechaStart.'" and "'.$fechaEnd.'"'.' GROUP BY a.ramoActividad,a.tipoActividad ';

   
   }
   else
   {
   	   $consulta='select count(a.folioActividad) as total,a.ramoActividad,a.tipoActividad,a.usuarioVendedor from actividades a 
 where  a.tipoActividad IN("Emision","Cotizacion","Cancelacion","CapturaEmision","Endoso") and a.usuarioVendedor="'.$row['email'].'" and year(a.fechaCreacion)='.$_POST['year'].' and month(a.fechaCreacion)='.$_POST['month'].' GROUP BY a.ramoActividad,a.tipoActividad';
 
   }
     $info=$this->db->query($consulta)->result();
     
     foreach ($info as  $rowInfo) 
     {
        switch ($rowInfo->tipoActividad) 
        {
        	case 'Endoso':
        	        $sumEndoso=$sumEndoso+$rowInfo->total;
        	        	
        		    if($rowInfo->ramoActividad=='VIDA'){$vidaEndosoCancelacion=$vidaEndosoCancelacion+$rowInfo->total;$sumColCancelVida=$sumColCancelVida+$rowInfo->total;}
        		    if($rowInfo->ramoActividad=='ACCIDENTES_Y_ENFERMEDADES' || $rowInfo->ramoActividad=='ACCIDENTES Y ENFERMEDADES'){$accidentesEndosoCancelacion=$accidentesEndosoCancelacion+$rowInfo->total;$sumColCancelAcci=$sumColCancelAcci+$rowInfo->total;}
        		      if($rowInfo->ramoActividad=='DANOS' || $rowInfo->ramoActividad=='DAÑOS'){$daniosEndosoCancelacion=$daniosEndosoCancelacion+$rowInfo->total;$sumColCancelDanios=$sumColCancelDanios+$rowInfo->total;}
        		      if($rowInfo->ramoActividad=='VEHICULOS'){$vehiculosEndosoCancelacion=$vehiculosEndosoCancelacion+$rowInfo->total;$sumColCancelAutos=$sumColCancelAutos+$rowInfo->total;}
        		break;
        	case 'Cancelacion':
        	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($rowInfo->total.',cancel',TRUE));fclose($fp);	
        	        $sumEndoso=$sumEndoso+$rowInfo->total;
        		    if($rowInfo->ramoActividad=='VIDA'){$vidaEndosCancelacion=$vidaEndosoCancelacion+$rowInfo->total;$sumColCancelVida=$sumColCancelVida+$rowInfo->total;}
        		    if($rowInfo->ramoActividad=='ACCIDENTES_Y_ENFERMEDADES' || $rowInfo->ramoActividad=='ACCIDENTES Y ENFERMEDADES'){$accidentesEndosoCancelacion=$accidentesEndosoCancelacion+$rowInfo->total;$sumColCancelAcci=$sumColCancelAcci+$rowInfo->total;}
        		    if($rowInfo->ramoActividad=='DANOS' || $rowInfo->ramoActividad=='DAÑOS'){$daniosEndosoCancelacion=$daniosEndosoCancelacion+$rowInfo->total;$sumColCancelDanios=$sumColCancelDanios+$rowInfo->total;}
        		    if($rowInfo->ramoActividad=='VEHICULOS'){$vehiculosEndosoCancelacion=$vehiculosEndosoCancelacion+$rowInfo->total;$sumColCancelAutos=$sumColCancelAutos+$rowInfo->total;}
        		break;        
        	case 'Cotizacion':
        	    $sumCotizacion=$sumCotizacion+$rowInfo->total;
        	    
        		if($rowInfo->ramoActividad=='VIDA'){$vidaCotizacion=$vidaCotizacion+$rowInfo->total;$sumColCotVida=$sumColCotVida+$rowInfo->total;}
        		if($rowInfo->ramoActividad=='ACCIDENTES_Y_ENFERMEDADES' || $rowInfo->ramoActividad=='ACCIDENTES Y ENFERMEDADES'){$accidentesCotizacion=$accidentesCotizacion+$rowInfo->total;$sumColCotAcci=$sumColCotAcci+$rowInfo->total;}
        		      if($rowInfo->ramoActividad=='DANOS' || $rowInfo->ramoActividad=='DAÑOS'){$daniosCotizacion=$daniosCotizacion+$rowInfo->total;$sumColCotDanios=$sumColCotDanios+$rowInfo->total;}
                 if($rowInfo->ramoActividad=='VEHICULOS'){$vehiculosCotizacion=$vehiculosCotizacion+$rowInfo->total;$sumColCotAutos=$sumColCotAutos+$rowInfo->total;}        		     
        		break;	
        	case 'Emision':
        	    $sumEmision=$sumEmision+$rowInfo->total;
        		if($rowInfo->ramoActividad=='VIDA'){$vidaEmisionCaptura=$vidaEmisionCaptura+$rowInfo->total;$sumColEmiVida=$sumColEmiVida+$rowInfo->total;}
        		if($rowInfo->ramoActividad=='ACCIDENTES_Y_ENFERMEDADES' || $rowInfo->ramoActividad=='ACCIDENTES Y ENFERMEDADES'){$accidentesEmisionCaptura=$accidentesEmisionCaptura+$rowInfo->total;$sumColEmiAcci=$sumColEmiAcci+$rowInfo->total;} 
        		if($rowInfo->ramoActividad=='DANOS' || $rowInfo->ramoActividad=='DAÑOS'){$daniosEmisionCaptura=$daniosEmisionCaptura+$rowInfo->total;$sumColEmiDanios=$sumColEmiDanios+$rowInfo->total;}
        		if($rowInfo->ramoActividad=='VEHICULOS'){$vehiculosEmisionCaptura=$vehiculosEmisionCaptura+$rowInfo->total;$sumColEmiAutos=$sumColEmiAutos+$rowInfo->total;}
        		break;
            case 'CapturaEmision': 
                $sumEmision=$sumEmision+$rowInfo->total;
                if($rowInfo->ramoActividad=='VIDA'){$vidaEmisionCaptura=$vidaEmisionCaptura+$rowInfo->total;$sumColEmiVida=$sumColEmiVida+$rowInfo->total;}
                if($rowInfo->ramoActividad=='ACCIDENTES_Y_ENFERMEDADES' || $rowInfo->ramoActividad=='ACCIDENTES Y ENFERMEDADES'){$accidentesEmisionCaptura=$accidentesEmisionCaptura+$rowInfo->total;$sumColEmiAcci=$sumColEmiAcci+$rowInfo->total;}
                if($rowInfo->ramoActividad=='DANOS' || $rowInfo->ramoActividad=='DAÑOS'){$daniosEmisionCaptura=$daniosEmisionCaptura+$rowInfo->total;$sumColEmiDanios=$sumColEmiDanios+$rowInfo->total;}
                if($rowInfo->ramoActividad=='VEHICULOS'){$vehiculosEmisionCaptura=$vehiculosEmisionCaptura+$rowInfo->total;$sumColEmiAutos=$sumColEmiAutos+$rowInfo->total;}
                break;
        }

# code...
     }
 ?>

 
  	<td><?=$row['sucursal'];?></td>
  	<td><?=$row['nombreTitulo'];?></td>
  	<td><?=$row['apellidoPaterno'].' '.$row['apellidoMaterno'].' '.$row['nombre']?></td>
  	<td align="right"><?=$vehiculosCotizacion?></td>
  	<td align="right"><?=$daniosCotizacion?></td>
  	<td align="right"><?=$accidentesCotizacion?></td>
  	<td align="right"><?=$vidaCotizacion?></td>
  	<td align="right" style="text-align: right;background-color: #a79e9e;"><?=$sumCotizacion?></td>
  	<td align="right"><?=$vehiculosEmisionCaptura?></td>
  	<td align="right"><?=$daniosEmisionCaptura?></td>
  	<td align="right"><?=$accidentesEmisionCaptura?></td>
  	<td align="right"><?=$vidaEmisionCaptura?></td>
  	<td align="right" style="text-align: right;background-color: #a79e9e;"><?=$sumEmision?></td>
  	<td align="right"><?=$vehiculosEndosoCancelacion?></td>
  	<td align="right"><?=$daniosEndosoCancelacion?></td>
  	<td align="right"><?=$accidentesEndosoCancelacion?></td>
  	<td align="right"><?=$vidaEndosoCancelacion?></td>
  	<td align="right" style="text-align: right;background-color: #a79e9e;"><?=$sumEndoso?></td>
  	<td align="right"><?=($sumCotizacion+$sumEmision+$sumEndoso)?></td>

  </tr>
  <? } //FIN $ListaVendedores ?>
</tbody>
<tfoot style="
    color: black;
    font-size: 13px;
    text-decoration-style: solid;
    text-decoration-line: overline;
    background-color: #a79e9e;
"><tr><td colspan="3">TOTALES DE AGENTES:<?=count($ListaVendedores)?></td><td align="right"><?=$sumColCotAutos?></td><td align="right"><?=$sumColCotDanios?></td><td align="right"><?=$sumColCotAcci?></td><td align="right"><?=$sumColCotVida?></td><td align="right"><?=($sumColCotAutos+$sumColCotDanios+$sumColCotAcci+$sumColCotVida)?></td><td align="right"><?=$sumColEmiAutos?></td><td align="right"><?=$sumColEmiDanios?></td><td align="right"><?=$sumColEmiAcci?></td><td align="right"><?=$sumColEmiVida?></td><td align="right"><?=($sumColEmiAutos+$sumColEmiDanios+$sumColEmiAcci+$sumColEmiVida)?></td><td align="right"><?=$sumColCancelAutos?></td><td align="right"><?=$sumColCancelDanios?></td><td align="right"><?=$sumColCancelAcci?></td><td align="right"><?=$sumColCotVida?></td><td align="right"><?=($sumColCancelAutos+$sumColCancelDanios+$sumColCancelAcci+$sumColCancelVida)?></td><td align="right"><?=(($sumColCotAutos+$sumColCotDanios+$sumColCotAcci+$sumColCotVida)+($sumColEmiAutos+$sumColEmiDanios+$sumColEmiAcci+$sumColEmiVida)+($sumColCancelAutos+$sumColCancelDanios+$sumColCancelAcci+$sumColCancelVida))?></td></tr></tfoot>
</table>
</div>




      <?php
    $ListaVendedores=null;
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
<?
	$this->load->view('footers/footer'); 
?>
<style type="text/css">
	.totalAgrupacion{background-color: #948c8c}
	.totalesAgente{background-color: #9cdcb0}
</style><?

function imprimirFecha($year)
{ 
	$option='<option value="">Seleccione</option>';

                            	//<option value="2018" <?= ($year=="2018")? "selected":""

  for($i=date("Y");$i>=2018;$i--)
  {
   if($year==$i){$option.="<option value='".$i."' selected>".$i."</option>";}
   else{$option.="<option value='".$i."'>".$i."</option>";}
  }
    return $option;
}

?>

