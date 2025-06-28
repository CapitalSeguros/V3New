<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $ListaVendedores->num_rows();
?>
<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

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
?>
<meta name="viewport" content="width=900px"/>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#fechaini" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );

      $( function(){$( "#fechafin" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );
</script>

<script language="javascript" type="text/javascript">
    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
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

        if (isFooter) {
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


<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div  class="col-md-3 col-sm-3 col-xs-3"><h3 class="titulo-secciones">Reporte Puntaje Global P100</h3></div>

        </div>

 </section>    

 <section >
         <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>crmproyecto/consultaxfechas/" > 

        <div class="row">
             <label>Fecha Inicial</label>    
            <input type="text"  name="fechaini" id="fechaini" placeholder="Fecha Inicial" required="">

        </div>

         <div class="row">
             <label>Fecha Final</label>  
            <input type="text"  name="fechafin" id="fechafin" placeholder="Fecha Final" required="">

        </div>
      </br>
   

         <div class="row">
         <input type="submit" name="button" id="button" value="Consultar Puntos" align="left"  
                             onclick="">
         </div> 
      </br> 
      </br>
      </br>
      </br>
      </br>
      </br>
      </br>
      </br>

     </form > 

 </section>    




<section class="container-fluid breadcrumb-formularios">

<div id="DivRoot" align="left">
    <div style="overflow: hidden;" id="DivHeaderRow">
    </div>

    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
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
							<?php


              $fin=$fechaini;
              $ffin=$fechafin;




								if($ListaVendedores != FALSE){
									foreach ($ListaVendedores->result() as $row){
							?>
										<tr>

                        <td><?=$row->name_complete?></td> 
                         <td><?=$row->email?></td> 
                       <?

                        $correoProcedente=$row->email;

                        $sqlConsultaPuntosGlobales = "
        select sum(pj.PuntosGenerados) as globalito from puntaje pj
        where pj.Usuario='".$correoProcedente."' and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntosGlobales  = $this->db->query($sqlConsultaPuntosGlobales);

        

      /////////////////////////////////////////////////////////////////////////////////////////PARA PERFILADOS

     
      $sqlconsultaPuntosPerfilados = "
        select sum(pj.PuntosGenerados) as perfiladito from puntaje pj
        where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PERFILADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntosperfilados  = $this->db->query($sqlconsultaPuntosPerfilados);



      ///////////////////////////////////////////////////////////////////////////////////// PARA CONTACTADOS



      $sqlconsultaPuntosContactados = "
        select sum(pj.PuntosGenerados) as contactaditos from puntaje pj
        where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='CONTACTADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntoscontactados = $this->db->query($sqlconsultaPuntosContactados);



      ///////////////////////////////////////////////////////////////////////////////////// PARA REGISTRADAS CITAS



      $sqlconsultaPuntosRegistrados = "
        select sum(pj.PuntosGenerados) as registraditos from puntaje pj
        where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='REGISTRADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntosRegistrados = $this->db->query($sqlconsultaPuntosRegistrados);



      
      ///////////////////////////////////////////////////////////////////////////////////// COTIZADOS 

    
      $sqlconsultaPuntosCotizados = "
        select sum(pj.PuntosGenerados) as cotizaditos from puntaje pj
        where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='COTIZADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntosCotizados = $this->db->query($sqlconsultaPuntosCotizados);

      ///////////////////////////////////////////////////////////////////////////////////// PAGADOS 


      $sqlconsultaPuntosPagados = "
        select sum(pj.PuntosGenerados) as pagaditos from puntaje pj
        where pj.Usuario='".$correoProcedente."'  and pj.EdoActual='PAGADO'
        and cast(pj.FechaRegistro as date)>='".$fin."'  and cast(pj.FechaRegistro as date)<='".$ffin."'
        group by pj.Usuario
                   ";
      $queryPuntosPagados = $this->db->query($sqlconsultaPuntosPagados);

                      
                        
                        $globalito='0';
                        if(!empty($queryPuntosGlobales))
                          { 
                             foreach ($queryPuntosGlobales->result() as $Registro) {   
                              $globalito=$Registro->globalito;     
                            } 
                          } 

                         $perfiladito='0';
                         if(!empty($queryPuntosperfilados))
                          { 
                             foreach ($queryPuntosperfilados->result() as $Registro) { 
                              $perfiladito=$Registro->perfiladito;  
                            } 
                          } 

                          $contactaditos='0';
                         if(!empty($queryPuntoscontactados))
                          { 
                             foreach ($queryPuntoscontactados->result() as $Registro) { 
                             $contactaditos=$Registro->contactaditos;  
                            } 
                          } 

                         $registraditos='0'; 
                         if(!empty($queryPuntosRegistrados))
                          { 
                             foreach ($queryPuntosRegistrados->result() as $Registro) {   
                              $registraditos=$Registro->registraditos; 
                            } 
                          } 

                          $cotizaditos='0';
                         if(!empty($queryPuntosCotizados))
                          { 
                             foreach ($queryPuntosCotizados->result() as $Registro) {   
                              $cotizaditos=$Registro->cotizaditos; 
                            } 
                          }      

                          $pagaditos='0'; 
                         if(!empty($queryPuntosPagados))
                          { 
                             foreach ($queryPuntosPagados->result() as $Registro) {   
                              $pagaditos=$Registro->pagaditos; 
                            } 
                          } 



                       ?>

                        <td><?echo $globalito?></td> 
                        <td><?echo $perfiladito?></td> 
                        <td><?echo $contactaditos?></td> 
                        <td><?echo $registraditos?></td> 
                         <td><?echo $cotizaditos?></td> 
                          <td><?echo $pagaditos?></td> 


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
               		</div>

    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>


</section>




           
       
 
<?php $this->load->view('footers/footer'); ?>