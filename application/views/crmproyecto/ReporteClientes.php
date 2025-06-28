<?
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
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
	
	$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
	$totalResultados = $ListaClientes->num_rows();
?>
<style type="text/css">
	   			@media only screen and (min-width:750px)
   			{
   				
   				.form-control{width: 80%}
   				.graficaPerfilDiv{display: flex;flex-direction: row;}

   			}

	   			@media only screen and (max-width:750px)
   			{
   				
   				.form-control{width: 80%}
   				.graficaPerfilDiv{display: flex;flex-direction: column;}

   			}
</style>
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

	<!--section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Prospeccion de negocios: Clientes Prospecto</h3></div>

        </div>
		<hr /> 
	</section-->
	
    <section class="container-fluid"><!-- container-fluid -->
        <div class="row">
        	<div class="col-sm-6 col-md-6">
			<form method="get" name="infoagente" id="infoagente"  action="<?=base_url()?>crmproyecto/Reportes">
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
        
        <style type="text/css">
        	.table>thead{position: sticky;top:0px;z-index: 10}
        	.table-responsive{height: 300px;max-height: 300px}
        </style>
	
            
				<!-- <div id="DivRoot" align="left"></div> -->
				<!-- <div style="overflow: hidden;" id="DivHeaderRow"></div> -->
				<!-- <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent"> -->
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
				<!-- <div id="DivFooterRow" style="overflow:hidden"></div> -->
				<div class="row">
					<div class="col-md-12"><medium><i>Total de resultados: <b><?=$totalResultados?></b></i></medium></div>
				</div><!-- /row -->
            </div><!-- panel-body -->
		</div><!-- panel-default -->

        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<h3 class="titulo-secciones">Graficas Perfil de Prospectos</h3>
       	  	</div><!-- /col -->
		</div><!-- /row -->
        <style type="text/css">
        	.graficaPerfilDiv{display: flex;}
        	.graficaPerfilDiv>div{display: flex; flex-direction: column;}
        	.graficaPerfilDiv>div:nth-child(1){flex:1;}
        	.graficaPerfilDiv>div:nth-child(2){flex:1;}
        </style>
        <div class="graficaPerfilDiv">
			<?
				if(!empty($queryPuntosGlobales)){
					foreach ($queryPuntosGlobales->result() as $Registro){
                              $globalito=$Registro->globalito;
					} 
				} 

				if(!empty($queryPuntosperfilados)){
					foreach ($queryPuntosperfilados->result() as $Registro){ 
						$perfiladito=$Registro->perfiladito;
					}
				}
				
				if(!empty($queryPuntoscontactados)){
					foreach ($queryPuntoscontactados->result() as $Registro){ 
						$contactaditos=$Registro->contactaditos;  
					} 
				} 
				
				if(!empty($queryPuntosRegistrados)){
					foreach ($queryPuntosRegistrados->result() as $Registro){
						$registraditos=$Registro->registraditos;
					}
				}
				
				if(!empty($queryPuntosCotizados)){
					foreach ($queryPuntosCotizados->result() as $Registro){
						$cotizaditos=$Registro->cotizaditos; 
					}
				}
				
				if(!empty($queryPuntosPagados)){
					foreach ($queryPuntosPagados->result() as $Registro){
						$pagaditos=$Registro->pagaditos;
					}
				}
              
				if(
					(isset($perfiladito) && $perfiladito>0) &&
					(isset($contactaditos) && $contactaditos>0) && 
					(isset($registraditos) && $registraditos>0)  && 
					(isset($cotizaditos) && $cotizaditos>0) && 
					(isset($pagaditos) && $pagaditos>0)
				){
					$imprimeBarras =
							$graficaBarras
							.$perfiladito.","
							.$contactaditos.","
							.$registraditos.","
							.$cotizaditos.","
							.$pagaditos."&ttl=Puntos+por+etapa&bkg=FFFFFF&wdt=50";

				} else {
					if(
						(isset($perfiladito) && $perfiladito>0) &&
						(isset($contactaditos) && $contactaditos>0) && 
						(isset($registraditos) && $registraditos>0)  && 
						(isset($cotizaditos) && $cotizaditos>0) 
					){
						$imprimeBarras = 
							$graficaBarras
							.$perfiladito.","
							.$contactaditos.","
							.$registraditos.","
							.$cotizaditos."&ttl=Puntos+por+etapa&bkg=FFFFFF&wdt=50";
                
					} else {
						if(
							(isset($perfiladito) && $perfiladito>0) &&
							(isset($contactaditos) && $contactaditos>0) && 
							(isset($registraditos) && $registraditos>0)
						){
							$imprimeBarras =
								$graficaBarras
								.$perfiladito.","
								.$contactaditos.","
								.$registraditos."&ttl=Puntos+por+etapa&bkg=FFFFFF&wdt=50";
                
						} else {
							if(
								(isset($perfiladito) && $perfiladito>0) &&
								(isset($contactaditos) && $contactaditos>0) 
							){
								$imprimeBarras =
									$graficaBarras
									.$perfiladito.","
									.$contactaditos."&ttl=Puntos+por+etapa&bkg=FFFFFF&wdt=50";
								
							} else {
								if(isset($perfiladito) && $perfiladito>0){
									$imprimeBarras=$graficaBarras.$perfiladito."&ttl=Puntos+por+etapa&bkg=FFFFFF&wdt=50";
								
								} else {
									
								}
							}
						}
					}
				}
			?>
			<div>
			<div>
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
                	<img  src="<?=$imprimeBarras ?>">
					<? } ?>
				</span>
				</br>
			</div>
			<div>
				</br>
				<img  src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
              	<label>Puntos en Perfilados=</label>
              	<label><? if(isset($perfiladito)){ echo $perfiladito; } ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Puntos en Contactados=</label>
				<label><? if(isset($contactaditos)){ echo $contactaditos; } ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Puntos en Registrados=</label>
				<label><? if(isset($registraditos)){ echo $registraditos; } ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Puntos en Cotizados=</label>
				<label><? if(isset($cotizaditos)){ echo $cotizaditos;} ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[4]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Puntos en Pagados=</label>
				<label><? if(isset($pagaditos)){ echo $pagaditos; }?></label>
				</br>
				<label>Puntos Globales=</label> 
				<label><? if(isset($globalito)){ echo $globalito; }?></label>
			</div>
           </div>
             <? 
                          $Amigosescuela='0';
                         if(!empty($queryAmigosescuela))
                          { 
                             foreach ($queryAmigosescuela->result() as $Registro) {   
                              $Amigosescuela=$Registro->Amigosescuela;     
                            } 
                           

                          } 

                         $Amigosfamilia='0';
                         if(!empty($queryAmigosfamilia))
                          { 
                             foreach ($queryAmigosfamilia->result() as $Registro) { 
                              $Amigosfamilia=$Registro->Amigosfamilia;  
                            } 
                           
                          } 
                        

                         $Vecinos='0';
                         if(!empty($queryVecinos))
                          { 
                             foreach ($queryVecinos->result() as $Registro) { 
                             $Vecinos=$Registro->Vecinos;  
                            } 
                          } 

                         $Conocidospasatiempos='0';
                         if(!empty($queryConocidospasatiempos))
                          { 
                             foreach ($queryConocidospasatiempos->result() as $Registro) {   
                              $Conocidospasatiempos=$Registro->Conocidospasatiempos; 
                            } 
                          } 

                         $Fampropia='0';
                         if(!empty($queryFampropia))
                          { 
                             foreach ($queryFampropia->result() as $Registro) {   
                              $Fampropia=$Registro->Fampropia; 
                            } 
                          }       

                         $Gposocial='0';
                         if(!empty($queryGposocial))
                          { 
                             foreach ($queryGposocial->result() as $Registro) {   
                              $Gposocial=$Registro->Gposocial; 
                            } 
                          } 

                          $Comunidad='0';
                          if(!empty($queryComunidad))
                          { 
                             foreach ($queryComunidad->result() as $Registro) {   
                              $Comunidad=$Registro->Comunidad; 
                            } 
                          } 

                          $Antempleo='0';
                          if(!empty($queryAntempleo))
                          { 
                             foreach ($queryAntempleo->result() as $Registro) {   
                              $Antempleo=$Registro->Antempleo; 
                            } 
                          } 

                          $Negocio='0';
                          if(!empty($queryNegocio))
                          { 
                             foreach ($queryNegocio->result() as $Registro) {   
                              $Negocio=$Registro->Negocio; 
                            } 
                          } 

                          $Influencia='0';
                          if(!empty($queryInfluencia))
                          { 
                             foreach ($queryInfluencia->result() as $Registro) {   
                              $Influencia=$Registro->Influencia; 
                            } 
                          } 

           

                  
                  $imprimeBarras=$graficaBarras.$Amigosescuela.",".$Amigosfamilia.",".$Vecinos.",".$Conocidospasatiempos.",".$Fampropia.",".$Gposocial.",".$Comunidad.",".$Antempleo.",".$Negocio.",".$Influencia."&ttl=Fuentes+de+Prospectos&bkg=FFFFFF&wdt=50";

           
             
              ?> 
             <div>
			<div>               
				<span style="text-align:center;">
                	<? if(isset($imprimeBarras)){ ?>
                	<img src="<?=$imprimeBarras ?>"  >
                	<? } ?>
                </span>
				</br>
			</div>
			<div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Amigos de la Escuela=</label>
				<label><? if(isset($Amigosescuela)){ echo $Amigosescuela; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Amigos de la Familia=</label>
				<label><?if (isset($Amigosfamilia)) { echo $Amigosfamilia;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Vecinos=</label>
				<label><? if(isset($Vecinos)){ echo $Vecinos; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Conocidos a traves de los Pasatiempos=</label>
				<label><? if(isset($Conocidospasatiempos)){ echo $Conocidospasatiempos;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[4]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Familia Propia o Conyugue=</label>
				<label><? if(isset($Fampropia)){ echo $Fampropia; }?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[5]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Conocidos a traves de los grupos sociales=</label>
				<label><? if(isset($Gposocial)){ echo $Gposocial; }?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[6]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Conocidos por la Actividad de la Comunidad=</label>
				<label><? if(isset($Comunidad)){ echo $Comunidad; }?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[7]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Conocidos de Antiguos Empleos=</label>
				<label><? if(isset($Antempleo)){ echo $Antempleo; }?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[8]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Personas con las que hace Negocio=</label>
				<label><? if(isset($Negocio)){ echo $Negocio; }?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[9]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Centro de Influencia=</label>
				<label><? if(isset($Influencia)){ echo $Influencia; }?></label>
             </div>
		</div><!-- /row -->
         </div>
        <div class="row">
        	<div class="col-sm-12 col-md-12">
	        	<hr />
       	  	</div><!-- /col -->
		</div><!-- /row -->

        <div class="graficaPerfilDiv">
			<?
                          $menos25='0';
                         if(!empty($querymenos25))
                          { 
                             foreach ($querymenos25->result() as $Registro) {   
                              $menos25=$Registro->menos25;     
                            } 
                           

                          } 

                         $entre25y60='0';
                         if(!empty($queryentre25y60))
                          { 
                             foreach ($queryentre25y60->result() as $Registro) { 
                              $entre25y60=$Registro->entre25y60;  
                            } 
                           
                          } 
                        

                         $entre60y100='0';
                         if(!empty($queryentre60y100))
                          { 
                             foreach ($queryentre60y100->result() as $Registro) { 
                             $entre60y100=$Registro->entre60y100;  
                            } 
                          } 

                         $mas100='0';
                         if(!empty($querymas100))
                          { 
                             foreach ($querymas100->result() as $Registro) {   
                              $mas100=$Registro->mas100; 
                            } 
                          } 

                         

           

                  
                  $imprimeBarras=$graficaBarras.$menos25.",".$entre25y60.",".$entre60y100.",".$mas100."&ttl=Ingreso+Mensual&bkg=FFFFFF&wdt=50";

           
             
              ?>
             <div> 
			<div>
                <span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
						<img  src="<?= $imprimeBarras ?>">
					<? } ?>  
                </span>
                </br>
			</div>
			<div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Menos de $25000=</label>
				<label><? if(isset($menos25)){ echo $menos25; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Entre $25000 y $60000=</label>
				<label><? if(isset($entre25y60)){ echo $entre25y60; } ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Entre $60000 y $100000=</label>
				<label><? if(isset($entre60y100)){ echo $entre60y100; } ?></label>
				</br>
				<img  src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Mas de $100000=</label>
				<label><? if(isset($mas100)){ echo $mas100; } ?></label>
			</div>
              </div>
			<?
                          $menos18='0';
                         if(!empty($querymenos18))
                          { 
                             foreach ($querymenos18->result() as $Registro) {   
                              $menos18=$Registro->menos18;     
                            } 
                           

                          } 

                         $de19a35='0';
                         if(!empty($queryde19a35))
                          { 
                             foreach ($queryde19a35->result() as $Registro) { 
                              $de19a35=$Registro->de19a35;  
                            } 
                           
                          } 
                        

                         $de36a50='0';
                         if(!empty($queryde36a50))
                          { 
                             foreach ($queryde36a50->result() as $Registro) { 
                             $de36a50=$Registro->de36a50;  
                            } 
                          } 

                         $de51a65='0';
                         if(!empty($queryde51a65))
                          { 
                             foreach ($queryde51a65->result() as $Registro) {   
                              $de51a65=$Registro->de51a65; 
                            } 
                          } 



                  
                  $imprimeBarras=$graficaBarras.$menos18.",".$de19a35.",".$de36a50.",".$de51a65."&ttl=Rango+de+Edad&bkg=FFFFFF&wdt=50";

           
             
              ?>
             <div>
			<div>
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
					<img src="<?= $imprimeBarras ?>">
					<? } ?>
				</span>
				</br>
			</div>
			<div >
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Menos de 18 Años=</label>
				<label><? if(isset($menos18)){ echo $menos18; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>De 19 a 35 Años=</label>
				<label><? if(isset($de19a35)){ echo $de19a35; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>De 36 a 50 Años=</label>
				<label><? if (isset($de36a50)) { echo $de36a50; } ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>De 51 a 65 Años=</label>
				<label><? if(isset($de51a65)){ echo $de51a65; } ?></label>
			</div>
		</div>
		</div><!-- /row -->

        <div class="row">
        	<div class="col-sm-12 col-md-12">
	        	<hr />
       	  	</div><!-- /col -->
		</div><!-- /row -->

        <div class="graficaPerfilDiv">
			<?
                          $amacasa='0';
                         if(!empty($queryamacasa))
                          { 
                             foreach ($queryamacasa->result() as $Registro) {   
                              $amacasa=$Registro->amacasa;     
                            } 
                           

                          } 

                         $ejecutivo='0';
                         if(!empty($queryejecutivo))
                          { 
                             foreach ($queryejecutivo->result() as $Registro) { 
                              $ejecutivo=$Registro->ejecutivo;  
                            } 
                           
                          } 
                        

                         $empleado='0';
                         if(!empty($queryempleado))
                          { 
                             foreach ($queryempleado->result() as $Registro) { 
                             $empleado=$Registro->empleado;  
                            } 
                          } 

                         $estudiante='0';
                         if(!empty($queryestudiante))
                          { 
                             foreach ($queryestudiante->result() as $Registro) {   
                              $estudiante=$Registro->estudiante; 
                            } 
                          } 

                           $empresario='0';
                         if(!empty($queryempresario))
                          { 
                             foreach ($queryempresario->result() as $Registro) {   
                              $empresario=$Registro->empresario; 
                            } 
                          } 

                           $gerente='0';
                         if(!empty($querygerente))
                          { 
                             foreach ($querygerente->result() as $Registro) {   
                              $gerente=$Registro->gerente; 
                            } 
                          } 

                           $negociop='0';
                         if(!empty($querynegociop))
                          { 
                             foreach ($querynegociop->result() as $Registro) {   
                              $negociop=$Registro->negociop; 
                            } 
                          } 

                           $profesionista='0';
                         if(!empty($queryprofesionista))
                          { 
                             foreach ($queryprofesionista->result() as $Registro) {   
                              $profesionista=$Registro->profesionista; 
                            } 
                          } 

                           $retirado='0';
                         if(!empty($queryretirado))
                          { 
                             foreach ($queryretirado->result() as $Registro) {   
                              $retirado=$Registro->retirado; 
                            } 
                          } 

                           $otros='0';
                         if(!empty($queryotros))
                          { 
                             foreach ($queryotros->result() as $Registro) {   
                              $otros=$Registro->otros; 
                            } 
                          } 

                  
                  $imprimeBarras=$graficaBarras.$amacasa.",".$ejecutivo.",".$empleado.",".$estudiante.",".$empresario.",".$gerente.",".$negociop.",".$profesionista.",".$retirado.",".$otros."&ttl=Ocupacion+de+Prospectos&bkg=FFFFFF&wdt=50";

           
             
              ?>
              <div>
			<div>               
				<span style="text-align:center;">
                	<? if(isset($imprimeBarras)){ ?>
                		<img src="<?= $imprimeBarras; ?>">
                	<? } ?>
				</span>
				</br>
			</div>
			<div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Ama de Casa=</label>
				<label><? if(isset($amacasa)){ echo $amacasa;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Ejecutivo=</label>
				<label><? if(isset($ejecutivo)){ echo $ejecutivo;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Empleado=</label>
				<label><? if(isset($empleado)){ echo $empleado;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Estudiante=</label>
				<label><? if(isset($estudiante)){ echo $estudiante;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[4]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Empresario=</label>
				<label><? if(isset($empresario)){ echo $empresario;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[5]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Gerente=</label>
				<label><? if(isset($gerente)){ echo $gerente;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[6]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Negocio Propio=</label>
				<label><? if(isset($negociop)){ echo $negociop;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[7]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Profesionista Independiente=</label>
				<label><? if(isset($profesionista)){ echo $profesionista;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[8]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Retirado=</label>
				<label><? if(isset($retirado)){ echo $retirado;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[9]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Otros Empleos=</label>
				<label><? if(isset($otros)){ echo $otros;} ?></label>
			</div>
             </div>
			<? 
                          $casado='0';
                         if(!empty($querycasado))
                          { 
                             foreach ($querycasado->result() as $Registro) {   
                              $casado=$Registro->casado;     
                            } 
                          } 

                         $casadoch='0';
                         if(!empty($querycasadoch))
                          { 
                             foreach ($querycasadoch->result() as $Registro) { 
                              $casadoch=$Registro->casadoch;  
                            } 
                           
                          } 
                        

                         $divorciado='0';
                         if(!empty($querydivorciado))
                          { 
                             foreach ($querydivorciado->result() as $Registro) { 
                             $divorciado=$Registro->divorciado;  
                            } 
                          } 

                         $divorciadoch='0';
                         if(!empty($querydivorciadoch))
                          { 
                             foreach ($querydivorciadoch->result() as $Registro) {   
                              $divorciadoch=$Registro->divorciadoch; 
                            } 
                          } 

                           $soltero='0';
                         if(!empty($querysoltero))
                          { 
                             foreach ($querysoltero->result() as $Registro) {   
                              $soltero=$Registro->soltero; 
                            } 
                          } 

                           $solteroch='0';
                         if(!empty($querysolteroch))
                          { 
                             foreach ($querysolteroch->result() as $Registro) {   
                              $solteroch=$Registro->solteroch; 
                            } 
                          } 

                           $unionl='0';
                         if(!empty($queryunionl))
                          { 
                             foreach ($queryunionl->result() as $Registro) {   
                              $unionl=$Registro->unionl; 
                            } 
                          } 

                           $unionlch='0';
                         if(!empty($queryunionlch))
                          { 
                             foreach ($queryunionlch->result() as $Registro) {   
                              $unionlch=$Registro->unionlch; 
                            } 
                          } 

                           $viudo='0';
                         if(!empty($queryviudo))
                          { 
                             foreach ($queryviudo->result() as $Registro) {   
                              $viudo=$Registro->viudo; 
                            } 
                          } 

                           $viudoch='0';
                         if(!empty($queryviudoch))
                          { 
                             foreach ($queryviudoch->result() as $Registro) {   
                              $viudoch=$Registro->viudoch; 
                            } 
                          } 

                  
                  $imprimeBarras=$graficaBarras.$casado.",".$casadoch.",".$divorciado.",".$divorciadoch.",".$soltero.",".$solteroch.",".$unionl.",".$unionlch.",".$viudo.",".$viudoch."&ttl=Estado+Civil&bkg=FFFFFF&wdt=50";

           
             
              ?>
              <div> 
			<div>               
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
						<img src="<?= $imprimeBarras; ?>">
					<? } ?>  
				</span>
				</br>
			</div>
			<div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>"> 
				<label>Casaso=</label>
				<label><? if(isset($casado)){  echo $casado;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Casado con Hijos=</label>
				<label><? if(isset($casadoch)){ echo $casadoch;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Divorciado=</label>
				<label><? if(isset($divorciado)){ echo $divorciado;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Divorciado con Hijos=</label>
				<label><? if(isset($divorciadoch)){ echo $divorciadoch;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[4]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Soltero=</label>
				<label><? if(isset($soltero)){ echo $soltero;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[5]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Soltero Con Hijos=</label>
				<label><? if(isset($solteroch)){ echo $solteroch;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[6]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Union Libre=</label>
				<label><? if(isset($unionl)){ echo $unionl;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[7]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Union Libre con Hijos=</label>
				<label><? if(isset($unionlch)){ echo $unionlch;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[8]."&typ=2&dim=5&bkg=FFFFFF" ?>">
				<label>Viudo=</label>
				<label><? if(isset($viudo)){ echo $viudo;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[9]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Viudo con Hijos=</label>
				<label><? if(isset($viudoch)){ echo $viudoch;} ?></label>
			</div>
		</div>
		</div><!-- /row -->
        
        <div class="row">
        	<div class="col-sm-12 col-md-12">
	        	<hr />
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
        <div class="graficaPerfilDiv">
			<?
                $masde5='0';$dedosa5='0';$menos2='0';
                if(!empty($querymasde5)){ foreach ($querymasde5->result() as $Registro) {$masde5=$Registro->masde5;} } 
                if(!empty($querydedosa5)){ foreach ($querydedosa5->result() as $Registro) { $dedosa5=$Registro->dedosa5;  } } 
                if(!empty($querymenos2)){ foreach ($querymenos2->result() as $Registro) { $menos2=$Registro->menos2;  } } 

                  
                  $imprimeBarras=$graficaBarras.$masde5.",".$dedosa5.",".$menos2."&ttl=Tiempo+de+Conocer+Prospectos&bkg=FFFFFF&wdt=50";

           
             
              ?> 
              <div>
			<div >
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)) {?>
						<img src="<?= $imprimeBarras; ?>" >
					<? } ?>
				</span>
				</br>
			</div>
			<div > 
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Mas de 5 Años=</label>
				<label><? if(isset($masde5)){ echo $masde5;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Entre 2 y 5 Años=</label>
				<label><? if(isset($dedosa5)){ echo $dedosa5;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Menos de 2 Años=</label>
				<label><? if(isset($menos2)){ echo $menos2;} ?></label>
			</div>
           </div>
			<?  //FRECUENCIA QUE LO VIO ULTIMOS 12 meses
                $masde5v='0';$de3a5v='0';$de1a2v='0';$novio='0';
                if(!empty($querymasde5v)){ foreach ($querymasde5v->result() as $Registro) {   $masde5v=$Registro->masde5v;} } 
                if(!empty($queryde3a5v)){ foreach ($queryde3a5v->result() as $Registro) { $de3a5v=$Registro->de3a5v;}}                         
                if(!empty($queryde1a2v)){ foreach ($queryde1a2v->result() as $Registro) { $de1a2v=$Registro->de1a2v;  } }                             
                if(!empty($querynovio)){ foreach ($querynovio->result() as $Registro) { $novio=$Registro->novio;  } } 
                  $imprimeBarras=$graficaBarras.$masde5v.",".$de3a5v.",".$de1a2v.",".$novio."&ttl=Frecuencia+que+Vio+Ult+12+Mes&bkg=FFFFFF&wdt=50";
              ?>
             <div>
			<div>               
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
	                	<img src="<?= $imprimeBarras; ?>">
                	<? } ?>
				</span>
				</br>
			</div>
			<div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Mas de 5 Veces=</label>
				<label><?if (isset($masde5v)) {  echo $masde5v;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Entre 3 a 5 Veces=</label>
				<label><? if(isset($de3a5v)){ echo $de3a5v;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>De 1 a 2 Veces=</label>
				<label><? if(isset($de1a2v)){ echo $de1a2v;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[3]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>No lo vio=</label>
				<label><? if(isset($novio)){ echo $novio;} ?></label>
			</div>
		</div>
		</div><!-- /row -->

        <div class="row">
        	<div class="col-sm-12 col-md-12">
	        	<hr />
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
        <div class="graficaPerfilDiv">
			<? 
                $facil='0';$nomuyf='0';$difi='0';
                if(!empty($queryfacil)){ foreach ($queryfacil->result() as $Registro) {$facil=$Registro->facil;}}                          
                if(!empty($querynomuyf)){ foreach ($querynomuyf->result() as $Registro) { $nomuyf=$Registro->nomuyf;  } }                         
                if(!empty($querydifi)){ foreach ($querydifi->result() as $Registro) { $difi=$Registro->difi;  } } 
                  $imprimeBarras=$graficaBarras.$facil.",".$nomuyf.",".$difi."&ttl=Posibilidad+de+Acercamiento&bkg=FFFFFF&wdt=50";

             
              ?>
              <div> 
			<div>        
				<span style="text-align:center;">
					<? if(isset($imprimeBarras)){ ?>
                		<img src="<?= $imprimeBarras; ?>">
					<? } ?>  
				</span>
                </br>
             </div>
             <div>
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Facilmente=</label>
				<label><? if(isset($facil)){ echo $facil;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>No muy Facilmente=</label>
				<label><? if(isset($nomuyf)){ echo $nomuyf;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Con Dificultad=</label>
				<label><? if(isset($difi)){ echo $difi;} ?></label>
			</div>
            </div>
			<?
                $exel='0';$buena='0';$regular='0';
                if(!empty($queryexel)){ foreach ($queryexel->result() as $Registro) { $exel=$Registro->exel;} }                          
                if(!empty($querybuena)){ foreach ($querybuena->result() as $Registro) { $buena=$Registro->buena;  }} 
                if(!empty($queryregular)){ foreach ($queryregular->result() as $Registro) { $regular=$Registro->regular;  } } 
                  $imprimeBarras=$graficaBarras.$exel.",".$buena.",".$regular."&ttl=Posibilidad+de+Acercamiento&bkg=FFFFFF&wdt=50";

             
              ?>
              <div>
			<div>               
				<span style="text-align:center;">
                	<? if(isset($imprimeBarras)){ ?>
                	<img src="<?= $imprimeBarras; ?>">
                	<? } ?>
				</span>
                </br>
			</div>
			<div> 
				</br>
				<img src="<?=$graficaRef.$colorRef[0]."&typ=2&dim=5&bkg=FFFFFF" ?>" > 
				<label>Excelente=</label>
				<label><? if(isset($exel)){ echo $exel;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[1]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Buena=</label>
				<label><? if(isset($buena)){ echo $buena;} ?></label>
				</br>
				<img src="<?=$graficaRef.$colorRef[2]."&typ=2&dim=5&bkg=FFFFFF" ?>" >
				<label>Regular=</label>
				<label><? if(isset($regular)){ echo $regular;} ?></label>
			</div>
		</div>
		</div><!-- /row -->
        
        <div class="row">
        	<div class="col-sm-12 col-md-12">
				<br />
       	  	</div><!-- /col -->
		</div><!-- /row -->
	</section><!-- /container-fluid -->

<?php $this->load->view('footers/footer'); ?>