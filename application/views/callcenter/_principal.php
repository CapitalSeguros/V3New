
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
    $colorRef[10] = "";
    $colorRef[11] = "";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
?>


 <!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta name="viewport" content="width=900px"/>
 <!--<label>Clientes de Sicas</label>-->
<script language="JavaScript" type="text/javascript" src="ajax.js"></script>

  


<script> 

 function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) 
 {
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

        if (isFooter) 
        {
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
   MakeStaticHeader('Mitabla', 150, 1024, 40, false)
  }

  function PasoaReferido(idCliente){

    var cli = String(idCliente);

    if(cli!="")
    { 
           document.getElementById("cliselecsikas").value = cli;

    }

  }

	function MandoIdCliente(idCliente){

		var cli = String(idCliente);

		if(cli!="")
		{	
           document.getElementById("cliselec").value = cli;

    }

	}

	function MandoIdClienteInsertaContactado(idCliente){

		var cli = String(idCliente);

		if(cli!="")
		{	
           document.getElementById("cliselecInsertaConta").value = cli;

        }
	}



	function MandoIdClienteCotiza(idCliente){

		var cli = String(idCliente);
		if(cli!="")
		{	
           document.getElementById("cliselecCoti").value = cli;
           document.getElementById("cliselecCotiEmi").value = cli;
           document.getElementById("cliselecEmi").value = cli;

        }
	}

</script>





<section class="container-fluid breadcrumb-formularios">
				<div class="col-md-3 col-sm-3 col-xs-3">
					<h4 class="titulo-secciones">Telemarketing</h4>
         </div>
					
       
</section>



<section class="container-fluid breadcrumb-formularios">


         <div class="col-md-3 col-sm-3 col-xs-3"> 
         </div>

          <div class="col-md-3 col-sm-3 col-xs-3"> 
              <IMG width="60" height="60" SRC="./assets/images/fechitanimadabajo.gif">
         </div>

        <div class="col-md-3 col-sm-3 col-xs-3"> 
          </br>
            <IMG width="250" height="60" SRC="./assets/images/fechitanimadizq.gif"> 
        </div>


        <div class="col-md-3 col-sm-3 col-xs-3"> 

 <form  class="form-horizontal" role="formdimension2"
              id="formdimension2" name="formdimension2"
              method="post" 
              action="<?=base_url()?>callcenter" >

           <div class="row">
           </br>
             <!--<label>Clientes de Sicas</label>-->
             <input type="text" name="nomsik" id="nomsik"  align="right" >
             <!--<input type="text" name="cliselecsikas" id="cliselecsikas"  align="right"  required="" >-->
             <input type="submit" name="button2" id="button2" value="Buscar en Sicas">
</form>

 <form  class="form-horizontal" role="formdimension3"
              id="formdimension3" name="formdimension3"
              method="post" 
              action="<?=base_url()?>callcenter/InsertaDimensiondeSikas" >

             <input type="text" name="cliselecsikas" id="cliselecsikas"  align="right"  required="" hidden="" >
             


            <select name="Sikis" 
              id="Sikis" 

              onclick="PasoaReferido(this.value)" 
              size="10" class="form-control" >

              <? 
             

                         if(isset($data_result) && $data_result != "")
                          { 
                             foreach ($data_result as $Registro) {   

                                  if($Registro->ApellidoP!="")
                                  {  
                             ?> 

                                   
                                    <option value="<?=$Registro->IDCli?>"  >
                                    <?  echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
                                        echo $Registro->Nombre .""; ?></option>
                                    <?

                                  }  
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
                <input type="submit" name="button3" id="button3" value="Agregar a Dimension">
            </div>
             </br>
              </br>
</form>           
          
        </div>
     <hr />
</section>


<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->

 <section class="container-fluid breadcrumb-formularios">

       	<div class="col-md-3 col-sm-3 col-xs-3"> 
          <form  class="form-horizontal" role="formdimension"
            	id="formdimension" name="formdimension"
            	method="post" 
           	 	action="<?=base_url()?>callcenter/InsertaDimension/" >
           	 	<div class="row">

						</br>
						<IMG width="250" height="60" SRC="./assets/images/fechitanimada.gif">	
        		</div>
                  

            <input type="radio" name="tipo" id="tipo" value="Moral">Persona Moral<br>
            <div class="row">
            <label>Razon:</label>
            <input type="text"  name="razon" id="razon" placeholder="Razon Social" > 
            </div>
           
            <div class="row">
            <label>RFC:</label>
            <input type="text"  name="rfc" id="rfc" placeholder="RFC" > 
            </div>

            <input type="radio" name="tipo" id="tipo2" value="Fisica">Persona Fisica<br>
            <div class="row">
            <label>Nombres:</label>
            <input type="text"  name="nombre" id="nombre" placeholder="Nombre" >  
            </div>

            <div class="row">
            <label>A. Paterno:</label>
            <input type="text" name="apellidop" id="apellidop" placeholder="Apellido Paterno" >
            </div>

            <div class="row">
            <label>A. Materno:</label>
            <input type="text"  name="apellidom" id="apellidom" placeholder="Apellido Materno" >
            </div>
          </br>

            <div class="row">
                  <div class="col-md-4 col-sm-4 col-xs-4">
                  <label>Email</label>
              <input type="text" name="email" id="email" type="email" placeholder="Email xx@yy.com" align="right" required="" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
              </div>    
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
              <label>Tel Cel.</label>
              <input type="text"  name="celular" id="celular" placeholder="10 Digitos" align="right"  maxlength="10" required="" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
            </div>  
                </div>

            

            <div class="row">
            <label>Fuentes de Prospectos</label>
              <select name="fuente" 
              id="fuente" 
              size="1" class="form-control" >

                  <option value="">Seleccione una opcion</option>
                  <option value="LLAMADAOFICINA">Llamada a Oficina</option>
                  <option value="SITIOWEB">Sitio Web</option>
                  <option value="CHAT">Chat</option>
                  <option value="CAMPANADIGITAL">Campaña Digital</option>
                  <option value="CHATBOT">Chatbot</option>
                   <option value="VENTACRUZADA">Venta Cruzada</option>

                </select>
              </div>  

           

               <div class="row">
               </br>

               
              </div>  
 

        </br>
		

        <input type="button" name="button" id="button" value="Agregar Referido" align="right" 
              onclick="
              var nom = document.getElementById('nombre').value;
              var ap = document.getElementById('apellidop').value;
              var am = document.getElementById('apellidom').value;

              var raz = document.getElementById('razon').value;
              var rfc = document.getElementById('rfc').value;
              var Tel = document.getElementById('celular').value;

        

              if(document.getElementById('tipo').checked )
              { 
                
                if(raz !=''  && Tel!='')
                { 
                    this.form.submit();
                    
                }  
                else
                {
                   alert('No capturaste Razon  O Telefono' );
                } 
                 
              }

              if(document.getElementById('tipo2').checked )
              { 
                
                if(nom !='' && ap!='' && Tel!='')
                { 
                   this.form.submit();
                 
                }  
                else
                {
                   alert('No capturaste Nombre o Apellidos O Telefono');
                } 
              }

             
             
              " >
</form>	
        </div>


 <!--/////////////////////////REGISTRA DE DIMENSION A NUEVOSCONTACATADOS/////////////////////-->


<form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>callcenter/InsertaContactado/" >    
		


         	<div class="col-md-3 col-sm-3 col-xs-3"> 

            	<h4 class="titulo-secciones">1.-Referidos</h4> 
				  <div class="row">
					<select name="IDCli" 
			        id="IDCli" 
			        onclick="MandoIdCliente(this.value)" 
			        size="35" class="form-control" >
			        <? 
                         if(!empty($queryConsultaDimension))
                          { 
                             foreach ($queryConsultaDimension->result() as $Registro) {   
                             ?> 

            						<option value="<?=$Registro->IDCli?>"  >
									<? 
                     if($Registro->ApellidoP!='')
                     { 
                     echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
									   echo $Registro->Nombre ."  (";  echo $Registro->IDCli . " )"; 
                     }
                     else
                     { 
                       echo $Registro->RazonSocial . " (";  echo $Registro->RFC . ") (";  echo $Registro->IDCli . " )"; 
                     }
                     ?></option>
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
							       <input type="text" name="cliselec" id="cliselec"  align="right"  required="" hidden="">
		     			    </div>		
            		</div>


                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                      <label>Codigo Postal</label>
                      <input type="text"  name="cp" id="cp" align="right"  maxlength="10" required="">

                      <label>Edad</label>
                      <input type="text"  name="edad" id="edad" align="right"  maxlength="3" required="">

                      <label>Presupuesto Designado</label>
                      <input type="text"  name="presupuestod" id="presupuestod" align="right"  maxlength="10" required="">

                      <label>Suma Asegurada</label>
                      <input type="text"  name="sumaseg" id="sumaseg" align="right"  maxlength="10" required="">

                      <label>Fecha de Contacto</label>
                   <input required=""
                  type="text" name="fechaStart" id="fechaStart"
                  class="form-control input-sm fecha fechaStart"
                  placeholder="1900-01-01"
                                  value="<?=($this->input->post('fechaStart',TRUE)!="")?$this->input->post('fechaStart',TRUE):date('Y-m-d')?>"
                           />

                       
                        

                                     

                    </div>
                </div>
                 </br>

            		

            		<div class="row">
            			<div class="col-md-4 col-sm-4 col-xs-4">
							<input type="button" name="button" id="button" value="Agregar a Contactados" align="right" 
              onclick="

               var edad = document.getElementById('edad').value;
              var cp = document.getElementById('cp').value;

        
                
                if(edad !=''  && cp!='')
                { 
                    this.form.submit();
                    
                }  
                else
                {
                   alert('No capturaste Edad o CP' );
                } 
                 
              

                
              " >

						</div>	
					</div>
	          
	    	</div> 

</form >

  <!--/////////////////////////REGISTRA DE NUEVOS CONTACATADSO A COTIZADOS/////////////////////-->



              <div class="col-md-3 col-sm-3 col-xs-3">

            <div class="row">
                <h4 class="titulo-secciones">2.-CONTACTADOS</h4>
            </div>

              <select name="IDCli" 
                 id="IDCli" 
                 onclick="MandoIdClienteCotiza(this.value)"  
                   size="20" class="form-control">

                <? 
                         if(!empty($queryConsultacontactados))
                          { 
                             foreach ($queryConsultacontactados->result() as $Registro) {   
                             ?> 

                        <option value="<?=$Registro->IDCli?>" >
                  <? 
                     if($Registro->ApellidoP!='')
                     { 
                     echo $Registro->ApellidoP . " "; echo $Registro->ApellidoM . " "; 
                     echo $Registro->Nombre ."  (";  echo $Registro->IDCli . " )"; 
                     }
                     else
                     { 
                       echo $Registro->RazonSocial . " (";  echo $Registro->RFC . ") (";  echo $Registro->IDCli . " )"; 
                     }


                     ?></option>
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
	
						<IMG width="50" height="200" SRC="./assets/images/fechitanimadabajo.gif">	
        </div>

    
</section>  <!--////////////TERMINA LA SECCION DE ARRIBA//////////////////-->


<section class="container-fluid breadcrumb-formularios">
 
        <div class="col-md-3 col-sm-3 col-xs-3">
       
        </div>

         <div class="col-md-3 col-sm-3 col-xs-3">
              </br>
              </br>

              <div class="col-md-3 col-sm-3 col-xs-3">
                  <div class="row">
                  <IMG width="250" height="60" SRC="./assets/images/fechitanimadizq.gif">
                  </div>
              </div>
                
         </div>
      
</form >   

 </section> 

 <!--/////////////////////////-->

<section Class="container-fluid breadcrumb-formularios"> 



<form  class="form-horizontal" role="formcitado"
            id="formcitado" name="formcitado"
            method="post" 
            action="<?=base_url()?>callcenter/LlamaCotizacion/"   > 
                    

           <div class="row">
                  <input type="text" name="cliselecCoti" id="cliselecCoti"  align="right" required="" readonly="" hidden="">
           </div>
                 
           </br>
           <div class="row">
                   <IMG width="50" height="60" SRC="./assets/images/fechitanimadabajo.gif">  
           </div>

               
           <div class="row">
            </br>
            </br>
            <input type="button" name="button" id="button" value="Llamar Cotizador" align="left"  style="background-color: #FF9900"
                        onclick="

                          var cli = cliselecCoti.value;

                          if(cli>0)
                          { 
                              this.form.submit();
                          }
                          else
                          {
                              alert('No Seleccionaste un Nombre en la Lista de Contactados...haz doble click en el prospecto a Cotizar');
                          } 

            ">
           </div> 
      
</form >  


 </br>
</br>
<form  class="form-horizontal" role="formcitado2"
            id="formcitado3" name="formcitado3"
            method="post" 
            action="<?=base_url()?>callcenter/Emision/"   > 

     <div class="row">
       <input type="text" name="cliselecEmi" id="cliselecEmi"  align="right" required="" readonly="" hidden="">
       <input type="button" name="button" id="button" value="Emitir" align="left"  style=" background-color: #FF9900" onclick="

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
</form >   

 </br>
</br>
<form  class="form-horizontal" role="formcitado2"
            id="formcitado2" name="formcitado2"
            method="post" 
            action="<?=base_url()?>callcenter/LlamaCapturaEmision/"   > 

     <div class="row">
       <input type="text" name="cliselecCotiEmi" id="cliselecCotiEmi"  align="right" required="" readonly="" hidden="">
       <input type="button" name="button" id="button" value="Captura Emision" align="left"  style=" background-color: #FF9900" onclick="

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
</form >       

</section> 

 
 <!--/////////////////////////seccion COTIZADOS -->
<section Class="container-fluid breadcrumb-formularios"> 

          <div class="row">
            <h4 class="titulo-secciones">5.-Cotizados</h4>
          </div>


    <div id="DivRoot" align="left">
              <div style="overflow: hidden;" id="DivHeaderRow">
              </div>

    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
          <div class="table-responsive">
            <table class="table" id='Mitabla'>
              <thead>
                 <tr>
                  <th>Verificacion de Pago</th>  
                  <th>Apellido Paterno</th>                                       
                  <th>Apellido MAterno</th>                                      
                  <th>Nombres</th>
                  <th>Telefono</th>
                  <th>Email</th>
                  <th>FolioActividad</th>
                  <th>Id Sicas</th> 



                </tr>
              </thead>

              <tbody>   
              <?php
                if($queryConsultaCotizados != FALSE){
                  foreach ($queryConsultaCotizados->result() as $row){
              ?>
                    <tr>


                      <td>
                      <a href="<?=base_url()?>callcenter/VerificarPago?IDSIK=<?php echo $row->idSicas?>&IDCL=<?php echo $row->IDCli?>"

                      .?IDCL=. class='btn btn-primary btn-xs contact-item' data-toggle="modal"  data-original-title><span class="glyphicon glyphicon-eye-open" ></span>Verificar Pago</a>
                      </td>

                    

                      <td><?=$row->ApellidoP?></td>
                      <td><?=$row->ApellidoM?></td>
                      <td><?=$row->Nombre?></td>
                      <td><?=$row->Telefono1?></td>
                      <td><?=$row->EMail1?></td>
                      <td><?=$row->FolioActividad?></td>
                      <td><?=$row->idSicas?></td>
                    </tr>


              <?php
                  }
                }
              ?>
              </tbody>
                          
            </table>
           </div>
         <div id="DivFooterRow" style="overflow:hidden">
        </div>

</section> 

 <!--/////////////////////////seccion PAGADOS -->
<section > 


      <div class="row">
         <h4 class="titulo-secciones">6.-Pagados</h4>
      </div>


      <div id="DivRoot" align="left">
              <div style="overflow: hidden;" id="DivHeaderRow">
              </div>

        <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
          <div class="table-responsive">
            <table class="table" id='Mitabla'>
              <thead>
                <tr>

                  <th>Status</th> 
                  <th>Apellido Paterno</th>                                       
                  <th>Apellido MAterno</th>                                      
                  <th>Nombres</th>
                  <th>Telefono</th>
                  <th>Email</th>
                  <th>FolioActividad</th>
                  <th>Id Sicas</th> 

                </tr>
              </thead>

              <tbody>   
              <?php
                if($queryConsultaPagados != FALSE){
                  foreach ($queryConsultaPagados->result() as $row){
              ?>
                    <tr>
                      <td><?=$row->EstadoActual?></td>
                      <td><?=$row->ApellidoP?></td>
                      <td><?=$row->ApellidoM?></td>
                      <td><?=$row->Nombre?></td>
                      <td><?=$row->Telefono1?></td>
                      <td><?=$row->EMail1?></td>
                      <td><?=$row->FolioActividad?></td>
                      <td><?=$row->idSicas?></td>

                    </tr>


              <?php
                  }
                }
              ?>
              </tbody>
                          
            </table>
            </div>

      <div id="DivFooterRow" style="overflow:hidden">
    </div>



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