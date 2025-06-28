
<?php
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
  $tipoRamo="";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>

  


<script> 

	function MandoIdCliente(idCliente,nombre){

		var cli = String(idCliente);

		if(cli!="")
		{	
           document.getElementById("cliselec").value = cli;

    }

	}

	function MandoIdClienteInsertaContactado(idCliente,){

		var cli = String(idCliente);
		if(cli!="")
		{	
           document.getElementById("cliselecInsertaConta").value = cli;

        }
	}

	function MandoIdClienteInsertaRegistrado(idCliente,){

		var cli = String(idCliente);
		if(cli!="")
		{	
           document.getElementById("cliselecRegistraCita").value = cli;

        }
	}

	function MandoIdClienteCotiza(idCliente,){

		var cli = String(idCliente);
		if(cli!="")
		{	
           document.getElementById("cliselecCoti").value = cli;

        }
	}

</script>

<section class="container-fluid breadcrumb-formularios">
		<div class="row">
				<div class="col-md-6 col-sm-5 col-xs-5">
					<h4 class="titulo-secciones">Proyecto 100</h4>
					<font color='red'>	<label>Puntos Globales:</label>
					<? 
                         if(!empty($queryPuntosGlobales))
                          { 
                             foreach ($queryPuntosGlobales->result() as $Registro) {   
                             ?> 
                             <label><? echo $Registro->globalito; ?></label>
                   <?       
                            } 
                          } 
                    ?>         

					</font>


					<font color='green'>	<label>Puntos en Perfilados:</label>
					<? 
                         if(!empty($queryPuntosperfilados))
                          { 
                             foreach ($queryPuntosperfilados->result() as $Registro) {   
                             ?> 
                             <label><? echo $Registro->perfiladito; ?></label>
                   <?       
                            } 
                          } 
                    ?>         

					</font>


					<font color='blue'>	<label>Puntos en Contactados:</label>
					<? 
                         if(!empty($queryPuntoscontactados))
                          { 
                             foreach ($queryPuntoscontactados->result() as $Registro) {   
                             ?> 
                             <label><? echo $Registro->contactaditos; ?></label>
                   <?       
                            } 
                          } 
                    ?>         

					</font>


					<font color='orange'>	<label>Puntos en Registrados:</label>
					<? 
                         if(!empty($queryPuntosRegistrados))
                          { 
                             foreach ($queryPuntosRegistrados->result() as $Registro) {   
                             ?> 
                             <label><? echo $Registro->registraditos; ?></label>
                   <?       
                            } 
                          } 
                    ?>         

					</font>

          <font color='purple'> <label>Puntos en Cotizados:</label>
          <? 
                         if(!empty($queryPuntosCotizados))
                          { 
                             foreach ($queryPuntosCotizados->result() as $Registro) {   
                             ?> 
                             <label><? echo $Registro->cotizaditos; ?></label>
                   <?       
                            } 
                          } 
                    ?>         

          </font>

				</div>

		</div>
		 <hr />
</section>

<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->

 <section class="container-fluid breadcrumb-formularios">

       	<div class="col-md-3 col-sm-3 col-xs-3"> 
			<form  class="form-horizontal" role="formdimension"
            	id="formdimension" name="formdimension"
            	method="post" 
           	 	action="<?=base_url()?>crmproyecto/InsertaDimension/" >
           	 	<div class="row">

						</br>
						<IMG width="250" height="60" SRC="./assets/images/fechitanimada.gif">	
        		</div>

       		 	<div class="row">
						<label>Nombres:</label>
						<input type="text"  name="nombre" id="nombre" placeholder="Nombre" required="">	
        		</div>

        		<div class="row">
						<label>A. Paterno:</label>
						<input type="text" name="apellidop" id="apellidop" placeholder="Apellido Paterno" required="">
        		</div>

         		<div class="row">
						<label>A. Materno:</label>
						<input type="text"  name="apellidom" id="apellidom" placeholder="Apellido Materno" required="">
				</div>
				<input type="submit" name="button" id="button" value="Agregar Referido">
			</form>	
        </div>

        <!--/////////////////////////REGISTRA DE DIMENSION A PERFILADOS/////////////////////-->


    	<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>crmproyecto/InsertaPerfilado/" >    
		


         	<div class="col-md-3 col-sm-3 col-xs-3"> 

            	<h4 class="titulo-secciones">1.-Referidos</h4> 
				<div class="row">
					<select name="IDCli" 
			        id="IDCli" 
			        onclick="MandoIdCliente(this.value)" 
			        size="10" class="form-control" >
			        <? 
                         if(!empty($queryConsultaDimension))
                          { 
                             foreach ($queryConsultaDimension->result() as $Registro) {   
                             ?> 

            						<option value="<?=$Registro->IDCli?>"  >
									<? echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
									   echo $Registro->Nombre ."  (";  echo $Registro->IDCli . " )"; ?></option>
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
        		</div>



         	</div> 
 

        	<div class="col-md-3 col-sm-3 col-xs-3"> 
        	
           			 <div class="row">

						      </br>
						        <IMG width="250" height="60" SRC="./assets/images/fechitanimada.gif">
						
            		  </div>

            		<div class="row">
             			<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="text" name="cliselec" id="cliselec"  align="right" readonly=""  required="" hidden="">
		     			</div>		
            		</div>

            		<div class="row">
             			<div class="col-md-4 col-sm-4 col-xs-4">
        					<label>Email</label>
							<input type="text" name="email" id="email" type="email" placeholder="Email xx@yy.com" align="right"  pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
		     			</div>		
            		</div>

            		<div class="row">
              			<div class="col-md-4 col-sm-4 col-xs-4">
							<label>Tel Cel.</label>
							<input type="text"  name="celular" id="celular" placeholder="10 Digitos" align="right"  maxlength="10" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
			 			</div>	
            		</div>

            		<div class="row">
            			<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="button" name="button" id="button" value="Agregar a Perfilados" align="right" 
              onclick="
              var cli = cliselec.value;
               var ema = email.value;
                var Tels = celular.value;

              if(cli>0 && ema!='' && Tels!='')
              { 
                 this.form.submit();
              }
              else
              {
                alert('Selecciona un Nombre de la Lista de Referidos o No capturaste un Dato');
              }" >

						</div>	
					</div>
	          
	    	</div> 

		</form >

  <!--/////////////////////////REGISTRA DE PERFIALDOS A CONTACTADOS/////////////////////-->

       
    	<form  class="form-horizontal" role="formcontactado"
            id="formcontactado" name="formcontactado"
            method="post" 
            action="<?=base_url()?>crmproyecto/InsertaContactado/" >    
	    
         	<div class="col-md-3 col-sm-3 col-xs-3">
          	<h4 class="titulo-secciones">2.-Perfilados (+1 Punto)</h4> 
				<div class="row" style='overflow-x: scroll'>

         			<select name="IDCliContac" 
			       		 id="IDCliContac" 
			       		 onclick="MandoIdClienteInsertaContactado(this.value)"  
			             size="10" class="form-control" width="450">

			        	<? 
                         if(!empty($queryConsultaperfilados))
                          { 
                             foreach ($queryConsultaperfilados->result() as $Registro) {   
                             ?> 

            						<option value="<?=$Registro->IDCli?>">
									<? echo $Registro->ApellidoP . " "; 
                     echo $Registro->ApellidoM . " "; 
									   echo $Registro->Nombre."  (";  
                     echo $Registro->IDCli ."  )(";
                     echo $Registro->EMail1 . " )(" ;
                     echo $Registro->Telefono1 . " ) " ; ?>
                       
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

        		</div>	
        		<div class="row">
             			<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="text" name="cliselecInsertaConta" id="cliselecInsertaConta"  align="right" required="" readonly="" hidden="">
		     			</div>		
            	</div>
        		<div class="row">
                 </br>
                   <label>Fecha de Contacto</label>
					         <input
									type="text" name="fechaStart" id="fechaStart"
									class="form-control input-sm fecha fechaStart"
									placeholder="1900-01-01"
                	                value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>"
                           />
        		</div>

        		<div class="row">
        		</br>
							<input type="submit" name="button" id="button" value="Agregar a Contactados" align="right">
				</div>

				<div class="row">
	
						<IMG width="50" height="80" SRC="./assets/images/fechitanimadabajo.gif">	
        		</div>

    

        </form > 	
    
</section>  <!--////////////TERMINA LA SECCION DE ARRIBA//////////////////-->


 <section class="container-fluid breadcrumb-formularios">
 
	  

  <!--/////////////////////////ESTE NO HACE NADA SOLO LOS MUESTRA LOS QUE REGSITRARON CITA/////////////////////-->

        <div class="col-md-3 col-sm-3 col-xs-3">

        	<div class="row">
					<h4 class="titulo-secciones">4.-Citas Registradas(+2 Puntos)</h4>
			    </div>

           <div class="row">
		 	     <select   name="IDCliCita" 
			       		 id="IDCliCita" onclick="MandoIdClienteCotiza(this.value)"  
			             size="20" class="form-control" >



			       		
			        	<? 
                         if(!empty($queryConsultaRegistrados))
                          { 
                             foreach ($queryConsultaRegistrados->result() as $Registro) {   
                             ?> 

            						<option value="<?=$Registro->IDCli?>" >
									<? echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
									   echo $Registro->Nombre."  (";  echo $Registro->IDCli . " )"; ?></option>
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
            </div>
        		
        </div>





        <div class="col-md-3 col-sm-3 col-xs-3">  

                <div class="row">
                	<font color='red'>
					<h5 class="titulo-secciones">Haga click sobre el dia de la Cita y Registre</h5>
				    </font>
			    </div>
             
                <div class="row">
                 <iframe src="<?=base_url()?>calendariop100" width="450" height="400"></iframe>
                </div>   


 <!--/////////////////////////REGISTRA DE CONTACTADOS A REGSITRADOSNO MOVER ESTE FROM -->  
        

<form  class="form-horizontal" role="formcitado"
            id="formcitado" name="formcitado"
            method="post" 
            action="<?=base_url()?>crmproyecto/InsertaCitaRegistrada" >     
        

        		<div class="row">
             			<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="text" name="cliselecRegistraCita" id="cliselecRegistraCita"  align="right" required="" readonly="" hidden="">
		     			</div>		
            	</div>


        </div>
    

 
                   

        <div class="col-md-3 col-sm-3 col-xs-3">
        </br>
        </br>
              <div class="col-md-3 col-sm-3 col-xs-3">
                
              </div>

              <div class="col-md-3 col-sm-3 col-xs-3">
                  <div class="row">
                  <IMG width="250" height="60" SRC="./assets/images/fechitanimadizq.gif">
                  </div>
              </div>

            

              <div class="col-md-2 col-sm-2 col-xs-2">
              	     </br>
                    </br>
                    </br>

              

                         <input type="button" name="button" id="button" value="Agregar a Citas" align="left"
                          onclick="

                          var cli = cliselecRegistraCita.value;
                         

                          if(cli>0)
                          { 
                              this.form.submit();
                          }
                          else
                          {
                              alert('Selecciona un Nombre de la Lista de Contactados!!');
                          } 

                          ">


                      <div class="row">

                      </br>
                         <label>Fecha/Cita</label>
                      </div>
                      
                      <div class="row">
                     <input
                  type="text" name="fechaStart" id="fechaStart"
                  class="form-control input-sm fecha fechaStart"
                  placeholder="1900-01-01"
                                  value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>" >
                      </div>                

              </div>
        </div>


        <div class="col-md-3 col-sm-3 col-xs-3">

            <div class="row">
				<h4 class="titulo-secciones">3.-Contactados (+1 Punto)</h4>
		    </div>

           		<select name="IDCli" 
			       		 id="IDCli" 
			       		 onclick="MandoIdClienteInsertaRegistrado(this.value)"  
			             size="20" class="form-control">

			        	<? 
                         if(!empty($queryConsultacontactados))
                          { 
                             foreach ($queryConsultacontactados->result() as $Registro) {   
                             ?> 

            						<option value="<?=$Registro->IDCli?>" >
									<? echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
									   echo $Registro->Nombre."  (";  echo $Registro->IDCli . " )"; ?></option>
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

        </div>

</form >   

 </section> 


 <!--/////////////////////////EMPIEZA COTIZACIONM -->

<section Class="container-fluid breadcrumb-formularios"> 

<form  class="form-horizontal" role="formcitado"
            id="formcitado" name="formcitado"
            method="post" 
            action="<?=base_url()?>crmproyecto/LlamaCotizacion/"   >  


            <div class="col-md-3 col-sm-3 col-xs-3">
                    <div class="row">
                         <input type="text" name="cliselecCoti" id="cliselecCoti"  align="right" required="" readonly="" hidden="">
                     </div>

                    <div class="row">
                        <input type="button" name="button" id="button" value="Llamar Cotizador" align="left"  style="background-color: #FF9900"
                        onclick="

                          var cli = cliselecCoti.value;
                         

                          if(cli>0)
                          { 
                              this.form.submit();
                          }
                          else
                          {
                              alert('Selecciona un Nombre de la Lista de Citas Registradas!!');
                          } 

                          ">


                    </div>

                    <div class="row">
                    <IMG width="50" height="80" SRC="./assets/images/fechitanimadabajo.gif">  
              </div>

              
            </div>


            <div class="col-md-3 col-sm-3 col-xs-3">

              
            </div>

            <div class="col-md-3 col-sm-3 col-xs-3">
            </div>

            
</form >   
        

</section> 



  <!--/////////////////////////TERMINA/////////////////////-->

   <!--/////////////////////////EMPIEZA COTIZACIONM -->

<section Class="container-fluid breadcrumb-formularios"> 

<form  class="form-horizontal" role="formcitado"
            id="formcitado" name="formcitado"
            method="post" 
            action="<?=base_url()?>crmproyecto/LlamaCotizacion/"   >  

             <div class="col-md-3 col-sm-3 col-xs-3">

                 <div class="row">
                    <h4 class="titulo-secciones">5.-Cotizados (+1 Punto)</h4>
                </div>

                <select name="IDCliCotizados" 
                 id="IDCliCotizados" 
                 onclick="MandoIdClienteInsertaRegistrado(this.value)"  
                   size="20" class="form-control">

                <? 
                         if(!empty($queryConsultaCotizados))
                          { 
                             foreach ($queryConsultaCotizados->result() as $Registro) {   
                             ?> 

                        <option value="<?=$Registro->IDCli?>" >
                  <? echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
                     echo $Registro->Nombre."  (";  echo $Registro->IDCli . " )"; ?></option>
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
             </div>   

             <div class="col-md-3 col-sm-3 col-xs-3">
            </div>




            
</form >   
        

</section> 


  <!--/////////////////////////TERMINA/////////////////////-->
  

 <script>
	var fechaStart =
	$('.fechaStart').datepicker({
		format:		"yyyy-mm-dd",
		startDate:	"",
		language:	"es",
		autoclose:	true
	});

	var fechaStartCita =
	$('.fechaStartCita').datepicker({
		format:		"yyyy-mm-dd",
		startDate:	"",
		language:	"es",
		autoclose:	true
	});


  function objetoAjax(){
  var xmlhttp=false;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
       xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
      }
  }

  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function MostrarConsulta(datos){
  divResultado = document.getElementById('resultado');
  ajax=objetoAjax();
  ajax.open("GET", datos);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      divResultado.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}
	
	
	
</script>  




<?php $this->load->view('footers/footer'); ?>