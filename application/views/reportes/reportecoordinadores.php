<?php
	$this->load->view('headers/header'); 
  $this->load->view('headers/headerReportes'); 
?>
<?php
	$this->load->view('headers/menu');
?>

	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Reporte Ejecutivo</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
      <form id="fechas" class="form" method="GET" action="<?=base_url()?>ejecutivos/Consulta">
               
         
		<div class="row">

         <select id="selectCoordinadores" name="selectCoordinadores" class="form-control"></select>      
				<div class="col-sm-4 col-md-4">
					<div class="form-group">

                        <label for="fechaStart">Inicio</label>
						<input
							type="text" name="fechaStart" id="fechaStart"
							class="form-control input-sm fecha fechaStart"
							placeholder="1900-01-01"	
							title="Fecha de Inicio" autocomplete="off"
						/>
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fechaEnd">Fin</label>
						<input
							type="text" name="fechaEnd" id="fechaEnd"
							class="form-control input-sm fecha fechaEnd"
							placeholder="1900-01-01"						
							title="Fecha de Fin" autocomplete="off"
						/>
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<br />
						<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="Consultar Reporte">Consultar Reporte</button>
					</div>
				</div>
			</form>
		</div><!-- /row -->
	 
	</section><!-- /container-fluid -->




<div id="divContenedorTabla" style="overflow-x: scroll; width: 90%; margin-left: 20px;margin-right: 20px">
<div style="width:1000;height: 50px;border:double;overflow:hidden;" id="scrollCabecera">
    <table border="1" style="width: 1000px; color: white; background-color: #361866">
      <thead style="height: 50px">
        <tr>
          <th class="divTD150">Sucursal</th>                                       
          <th class="divTD150">Canal</th>                                      
          <th class="divTD400">Nombre</th>
          <th class="divTD100">Autos</th>  
          <th class="divTD100">Daños</th>  
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
          <th class="divTD100">Total Cotizacion</th>
          <th class="divTD100">Autos</th>
          <th class="divTD100">Daños</th>  
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
           <th class="divTD100">Total Emision</th>
          <th class="divTD100">Autos</th>
          <th class="divTD100">Daños</th>
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
          <th class="divTD100">Total Endosos</th>
          <th class="divTD100">Global</th>
        </tr>
      </thead>
</table>
</div>
<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 400px;border:double;">
    <table border="1" style="width: 1000px;">
      <thead style="width: 1000px;display: none;">
        <tr>
          <th class="divTD150">Sucursal</th>                                       
          <th class="divTD150">Canal</th>                                      
          <th class="divTD400">Nombre</th>
          <th class="divTD100">Autos</th>  
          <th class="divTD100">Daños</th>  
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
          <th class="divTD100">Total Cotizacion</th>
          <th class="divTD100">Autos</th>
          <th class="divTD100">Daños</th>  
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
          <th class="divTD100">Total Emision</th>
          <th class="divTD100">Autos</th>
          <th class="divTD100">Daños</th>
          <th class="divTD100">GMM</th>
          <th class="divTD100">Vida</th>
          <th class="divTD100">Total Endosos</th>
          <th class="divTD100">Global</th>
        </tr>
      </thead>
      <tbody style="width: 1000px;">   
      <?php
      if(isset($ListaVendedores)){
        $sumaAgrupacionVendedor=0;$sumaAgrupacionTotal=0;
        foreach ($ListaVendedores as $row){$sumaAgrupacionVendedor=0;
      ?>
        <tr>
          <td class="divTD150"><?=$row->sucursal?></td>
          <td class="divTD150"><?=$row->nombreTitulo?></td>
          <td class="divTD400"><?=$row->nombre.' '.$row->apellidoPaterno.' '.$row->apellidoMaterno?></td>
          <? //COTIZACIONES AUTOS
            $fechaStart=$this->input->get('fechaStart');
            $fechaEnd=$this->input->get('fechaEnd');
        
            $sqlConsultacotizacionesAUTOS = "select count(act.folioActividad) as numcot from actividades act where act.tipoActividad='Cotizacion' and act.ramoActividad='VEHICULOS'
                                 and act.usuarioVendedor='".$row->email."' and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'";
                                 $queryConsultaCotizacionAUTOS  = $this->db->query($sqlConsultacotizacionesAUTOS);

                                if($queryConsultaCotizacionAUTOS->num_rows()>0){$detalleUser = $queryConsultaCotizacionAUTOS->result();}
    
            ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>

                               <? //COTIZACIONES DAÑOS
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
                                $sqlConsultacotizacionesDANOS = "select count(act.folioActividad) as numcot from actividades act where act.tipoActividad='Cotizacion' and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS') and act.usuarioVendedor='".$row->email."' and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'";
                       $queryConsultaCotizacionDANOS  = $this->db->query($sqlConsultacotizacionesDANOS);

                                if($queryConsultaCotizacionDANOS->num_rows()>0){$detalleUser = $queryConsultaCotizacionDANOS->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>

                              <? //COTIZACIONES gMM
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        
                                 $sqlConsultacotizacionesLP= "select count(act.folioActividad) as numcot from actividades act where act.tipoActividad='Cotizacion' and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES') and act.usuarioVendedor='".$row->email."' and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'";
       $queryConsultaCotizacionLP = $this->db->query($sqlConsultacotizacionesLP);

                                if($queryConsultaCotizacionLP->num_rows()>0){$detalleUser = $queryConsultaCotizacionLP->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                              <? //COTIZACIONES VIDA
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultacotizacionesVIDA= "
        select count(act.folioActividad) as numcot from actividades act 
        where act.tipoActividad='Cotizacion'
        and (act.ramoActividad='VIDA')
        and act.usuarioVendedor='".$row->email."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaCotizacionVIDA = $this->db->query($sqlConsultacotizacionesVIDA);


                                if($queryConsultaCotizacionVIDA->num_rows()>0){
                                $detalleUser = $queryConsultaCotizacionVIDA->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                              <td class="totalAgrupacion divTD100"   ><?php echo($sumaAgrupacionVendedor);?></td>


                            <? //EMISION AUTOS
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
                                  $sumaAgrupacionVendedor=0;

                                 $sqlConsultaEmisionsAUTOS = "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.ramoActividad='VEHICULOS'
        and act.usuarioVendedor='".$row->email."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionAUTOS = $this->db->query($sqlConsultaEmisionsAUTOS);


                                if($queryConsultaEmisionAUTOS->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionAUTOS->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                                <? //EMISION DAÑOS
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionDANOS = "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS')
        and act.usuarioVendedor='".$row->email."'
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionDANOS = $this->db->query($sqlConsultaEmisionDANOS);


                                if($queryConsultaEmisionDANOS->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionDANOS->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                               <? //EMISION gmm
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionGMM= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.usuarioVendedor='".$row->email."'
        and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionGMM  = $this->db->query($sqlConsultaEmisionGMM);


                                if($queryConsultaEmisionGMM->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionGMM->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                              <? //EMISION VIDA
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEmisionVIDA= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Emision' or act.tipoActividad='CapturaEmision')
        and act.usuarioVendedor='".$row->email."'
        and (act.ramoActividad='VIDA')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEmisionVIDA  = $this->db->query($sqlConsultaEmisionVIDA);


                                if($queryConsultaEmisionVIDA->num_rows()>0){
                                $detalleUser = $queryConsultaEmisionVIDA->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                               <td class="totalAgrupacion divTD100"  ><?php echo($sumaAgrupacionVendedor);?></td>



                              <? //ENDOSO CANCELACION AUTOS
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
                                 $sumaAgrupacionVendedor=0;

                                 $sqlConsultaEndosoAUTOS= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row->email."')
        and (act.ramoActividad='VEHICULOS')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoAUTOS  = $this->db->query($sqlConsultaEndosoAUTOS);


                                if($queryConsultaEndosoAUTOS->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoAUTOS->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>


                                 <? //ENDOSO CANCELACION daños
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoDanos= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row->email."')
        and (act.ramoActividad='DANOS' or act.ramoActividad='DAÑOS')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoDanos  = $this->db->query($sqlConsultaEndosoDanos);


                                if($queryConsultaEndosoDanos->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoDanos->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                                <? //ENDOSO CANCELACION gmm
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoGMM= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row->email."')
        and (act.ramoActividad='ACCIDENTES_Y_ENFERMEDADES' or act.ramoActividad='ACCIDENTES Y ENFERMEDADES')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoGMM  = $this->db->query($sqlConsultaEndosoGMM);


                                if($queryConsultaEndosoGMM->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoGMM->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>



                                <? //ENDOSO CANCELACION voida
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaEndosoLP= "
        select count(act.folioActividad) as numcot from actividades act 
        where (act.tipoActividad='Endoso' or act.tipoActividad='Cancelacion')
        and (act.usuarioVendedor='".$row->email."')
        and (act.ramoActividad='VIDA')
          and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   ";
       $queryConsultaEndosoLP  = $this->db->query($sqlConsultaEndosoLP);


                                if($queryConsultaEndosoLP->num_rows()>0){
                                $detalleUser = $queryConsultaEndosoLP->result();}
    
                              ?>
                              <td class="divTD100"><? echo $detalleUser[0]->numcot ;$sumaAgrupacionVendedor=$sumaAgrupacionVendedor+$detalleUser[0]->numcot;?></td>
                              <td class="totalAgrupacion divTD100"  ><?php echo($sumaAgrupacionVendedor); ?></td>


                                <? //GLOBALES
                                  $fechaStart=$this->input->get('fechaStart');
                                  $fechaEnd=$this->input->get('fechaEnd');
        

                                 $sqlConsultaGlobal= "
        select count(act.folioActividad) as numcot from actividades act 
        where  (act.usuarioVendedor='".$row->email."')
        and cast(act.fechaCreacion as date) between '".$fechaStart."' and '".$fechaEnd."'
                   "." and tipoActividad!='PagoCobranza'";
       $queryGlobal  = $this->db->query($sqlConsultaGlobal);


                                if($queryGlobal->num_rows()>0){
                                $detalleUser = $queryGlobal->result();}
    
                              ?>
                              <td class="totalesAgente divTD100"><? echo $detalleUser[0]->numcot ;?></td>
                          
        </tr>
      <?php
        }
      }
      ?>
      </tbody>             

    </table>
</div>
</div>


<script>
  function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

  <?php
                    $cad="";
  foreach ($coordinadores as  $value) {$cad=$cad.'<option value="'.$value->idPersona.'">'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')'.'</option>';}
  echo('document.getElementById("selectCoordinadores").innerHTML=\''.$cad.'\';');

  if(isset($idPersona)){echo('document.getElementById("selectCoordinadores").value='.$idPersona.';');}
               ?>

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

<?php 
echo('document.getElementById("fechaStart").value=\''.$this->input->get('fechaStart').'\';');
echo('document.getElementById("fechaEnd").value=\''.$this->input->get('fechaEnd').'\';');

?>
</script>
<?php 
	$this->load->view('footers/footer'); 
?>
<style type="text/css">
  .totalAgrupacion{background-color: #948c8c}
  .totalesAgente{background-color: #9cdcb0}
  .divTD100{width:100px;max-width: 100px;min-width: 100px}
  .divTD150{width:150px;max-width: 150px;min-width: 150px}
  .divTD400{width:400px;max-width: 400px;min-width: 400px}



</style>
<script type="text/javascript">
 
  document.getElementById('fechaStart').value='<?=($this->input->get('fechaStart',TRUE)!="")?$this->input->get('fechaStart',TRUE):date('Y').'-'.date('m').'-01';?>';
  document.getElementById('fechaEnd').value='<?=($this->input->get('fechaEnd',TRUE)!="")?$this->input->get('fechaEnd',TRUE):date('Y-m-d');?>';
</script>