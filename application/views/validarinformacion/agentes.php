<?php
	$this->load->view('headers/header');
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

<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css"> -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/validar-agentes.min.css">
<script rel="preconnect" defer src="https://use.fontawesome.com/releases/v6.6.0/js/all.js"></script>
<? //var_dump($agentes)?>
<section>
	<div class="container" style="background-color: #f6f7fb;padding: 0px;">
    <?php foreach ($agentes as $value): ?>
            <!--<font color='red'>
                <label><b>Porcentaje de Satisfaccion de este Agente</b></label><br />
                  <?php /*$value['porcentajesa'] */ ?>
                <label><b>%</b></label>
             </font>    -->
    <!-- Datos -->
    <div class="col-md-12" id="datos" style="margin-bottom: 50px;">
      <h3 class="title-center">Datos del representante</h3>
      <hr>
      <div class="segment-info-agent">
		    <div class="col-md-3 text-center">
         <? if(count($imagenPersonal)>0) { 
            $ruta=base_url()."assets/img/miInfo/userPhotos/";
          ?>
           <img class="img-profile-agent" src="<?php echo base_url().'assets/img/miInfo/userPhotos/'.$value['fotoUser'] ?>"
                        width="150">
         <?
         }else{
         ?> 
					<img class="img-profile-agent"
                    	src="<?php echo base_url().'assets/img/miInfo/userPhotos/'.$value['fotoUser'] ?>"
                        width="150"
                        alt="<?=$value['nombreCompleto']?>"
                        title="<?=$value['nombreCompleto']?>"
                    >
          <? }?>
        </div>
        <div class="col-md-9 pd-left">
          <div class="container-info-agent">
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-user icon-data-agent"></i> Nombre</label>
              <label class="textInfo">
                  <?php 
                    if(isset($nombreUsuario)) { echo($nombreUsuario);/*$value['nombreCompleto']*/ }
                    else { echo("N/A"); }
                  ?>
                </label>
            </div>
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-envelope icon-data-agent"></i>Correo</label>
              <label class="textInfo"><?=$value['emailUser']?></label>
            </div>
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-ranking-star icon-data-agent brd-right"></i> Ranking</label>
              <label class="textInfo"><?php echo utf8_decode($value['Ranking']); ?></label>
            </div>
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-landmark-flag icon-data-agent"></i> Clasificaci&oacute;n</label>
              <label class="textInfo"><?php echo utf8_decode($value['Giro']); ?></label>
            </div>
          </div>
          <hr class="divider-segment">
          <div class="container-info-agent">
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-user-tie icon-data-agent"></i> Cedula de Representante
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['cedula_cnsf']); ?></label>
            </div>
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-user-graduate icon-data-agent"></i>Tipo de Cedula
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['tipo_cedula_cnsf']); ?></label>
            </div>    
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-file-circle-check icon-data-agent"></i> Vigencia de Cedula
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['vigencia_cnsf']); ?></label>
            </div>
            <div class="pd-side column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-file-invoice-dollar icon-data-agent"></i> Poliza Resp. Civil Representantes
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['polrescivil']); ?></label>
            </div>
          </div>
          <hr class="divider-segment">
          <div class="container-info-agent">
            <div class="col-md-4 column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-person-circle-check icon-data-agent"></i> 
                Vigencia Resp. Civil Representantes
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['vigenciapolrescivil']); ?></label>
            </div>
            <div class="col-md-5 column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-users-line icon-data-agent"></i> 
                Suma Amparada Resp. Civil Representantes</label>
              <label class="textInfo"><?php echo utf8_decode($value['sumaaseg']); ?></label>
            </div>
            <div class="col-md-3 column-grid-start container-data-agent">
              <label class="textForm column-flex-center-start">
                <i class="fa-solid fa-id-card-clip icon-data-agent"></i> ID Gafet
              </label>
              <label class="textInfo"><?php echo utf8_decode($value['IDValida']); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Facultades -->
    <div class="col-md-12" id="facultades" style="margin-bottom: 50px;">
      <h3 class="title-center">Facultades que tiene este representante</h3>
      <hr>
      <div class="container-info-agent">
        <?php
          $facultadesAgente=explode(";",$facultadesAgenteDato[0]->agenteFacultades);
          $contador=count($facultadesAgente);
          $fac = '';
          foreach ($facultades as $valueAgente) {
            $bandera=0;
            $img_f = '';
            $class_f = "";
            for($i=0;$i<$contador;$i++){ 
              if($facultadesAgente[$i]==$valueAgente->id){$bandera=1;$i=$contador; }
            }
            if($bandera==0){ $img_f = 'cancelInconformidad.png'; $class_f = "red"; }
            else{ $img_f = 'aciertoInconformidad.png'; $class_f = "green"; }
            $fac .= '<div class="col-md-3 cont-fact-'.$class_f.'"><img src="'.base_url().'assets/images/'.$img_f.'"></img><label style="margin-left: 5px;margin-bottom: 0px;">'.$valueAgente->descripcion.'</label></div>';
          }
          echo ($fac);
        ?>
      </div>
    </div>
    <!-- -->
    <div class="col-md-12" style="margin-bottom: 50px;display: none;">
      <div class="col-md-12 col-sm-4 col-xs-12">
        <hr>
           <table><tr>
                        <td>
                          <div ><h1><label class="label label-success">Han calificado  <?= $facultadesAgenteDato[0]->cantidadPersonasEstrellas ?> Clientes obteniendo <?= $facultadesAgenteDato[0]->cantidadEstrellas ?> de estrellas de <?= ($facultadesAgenteDato[0]->cantidadPersonasEstrellas*5) ?> estrellas posibles</label></h1></div>
                        </td>
                      </tr>
            </table>
          </div>
          <div class="row" style="display: none;">
          <div class="col-md-12 col-sm-4 col-xs-12" >
          <br>
          <table class="table">

            <tr>
                           <td ><h3><label class="label label-info">Promedio de calificacion:</label></h3></td>
                           <td>
                            <h3><label class="label label-primary">
                            <?php   
                         
                            if($facultadesAgenteDato[0]->cantidadEstrellas==0){echo(0);}else{             
                        echo(round(($facultadesAgenteDato[0]->cantidadEstrellas*100)/(5*$facultadesAgenteDato[0]->cantidadPersonasEstrellas),2));} ?></label></h3></td>
            </tr>
              <tr>
                <td>
                  <img style=""  src="<?php echo base_url().'assets/images/starPersona.png' ?>" />
                </td>
                <td><h3>
                  <label class="label label-primary"><?php echo($facultadesAgenteDato[0]->cantidadPersonasEstrellas);  ?></label>
                </h3>
                </td>
              </tr>
            <tr>
                            <td colspan="4">
                                <?php  
                                   if($facultadesAgenteDato[0]->cantidadEstrellas==0)
                                   {
                                       for($i=0;$i<5;$i++){echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');}
                                  }
                                  else
                                  { $numeroEstrellas=($facultadesAgenteDato[0]->cantidadEstrellas/$facultadesAgenteDato[0]->cantidadPersonasEstrellas); 
                                   if(is_int($numeroEstrellas))
                                   {
                                     
                                    for($i=0;$i<$numeroEstrellas;$i++){
                                       echo('<img style=""  src="'.base_url().'assets/images/starLlena.png"> ');
                                    }
                                    for($i=0;$i<(5-$numeroEstrellas);$i++){
                                     echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');   
                                    }
                                   }
                                   else
                                   { 
                                     for($i=0;$i<(int)$numeroEstrellas;$i++){
                                       echo('<img style=""  src="'.base_url().'assets/images/starLlena.png"> ');
                                    }

                                     echo('<img style=""  src="'.base_url().'assets/images/starMitad.png"> ');   
                                    for($i=0;$i<(5-($numeroEstrellas+1));$i++){
                                     echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');   
                                    }
                                   }
                                 }
                                ?>

                            </td>
                        </tr>
           
                        
                      </tr>
          </table>
      </div></div>
    </div>
    <!-- Calificación -->
    <div class="col-md-12" id="calificacion" style="margin-bottom: 50px;">
      <h3 class="title-center">Califica a nuestro representante</h3>
      <hr>
      <div class="col-md-12 pd-left pd-right">
        <div class="col-md-5">
          <?php $this->load->view("validarinformacion/estrellas.php")?>
        </div>
        <div class="col-md-7 pd-left pd-right">
          <?php $this->load->view("validarinformacion/comentarios.php")?>
        </div>
      </div>
    </div>

    <!--
      <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <br />
                    <hr> 
                    <label><h1>Califica a nuestros representantes</h1></label><br>
                    <div class="row">
                    <div class="col-md-6 col-xs-6">
                     <h2>Clientes nuevos</h2>
                      <?=imprimirEstrellasClienteNuevo($estrellasClienteNuevo,'estrellasClientesNuevos');?><br>
                      <button class="btn btn-primary" onclick="guardarCalificacionEstrella('','estrellasClientesNuevos',0,<?php echo ($value['idPersona']); ?>)">Guardar</button>
                    </div>
                    <div class="col-md-6 col-xs-6">
                    <h2>Clientes</h2>
                    <?=imprimirEstrellasClienteNuevo($estrellasCliente,'estrellasClientes');?> <br>
                    <button class="btn btn-primary" onclick="guardarCalificacionEstrella('','estrellasClientes',1,<?php echo ($value['idPersona']); ?>)">Guardar</button>
                    </div>                    
                    </div>
                    <div class="row">
                    <div class="col-md-6 col-xs-6">
                    <table>
                     <tr>
                     <td><img style=""  src="<?php echo base_url().'assets/images/starPersona.png' ?>" /></td>
                     <td><h1 id="hEstrellasClientesNuevas"><?=$totalEstrellas['estrellasClienteNuevas'][0]->cuantosCalificaron;?></h1></td>
                     </tr>
                     <tr>
                     <td><h1>Prom:</h1></td>
                     <td><h1 id="hPromClientesNuevos"><? if($totalEstrellas['estrellasTotales'][0]->sumClienteNuevo==0){echo(0);}else{echo(round(($totalEstrellas['estrellasTotales'][0]->sumClienteNuevo*100)/$totalEstrellas['estrellasTotales'][0]->totalClienteNuevo,2));}?>%</h1></td>            
                     </tr>
                    </table>                    
                    </div>
                    <div class="col-md-6 col-xs-6">
                    <table>
                     <tr>
                     <td><img style=""  src="<?php echo base_url().'assets/images/starPersona.png' ?>" /></td>
                     <td><h1 id="hEstrellasCliente"><?=$totalEstrellas['estrellasCliente'][0]->cuantosCalificaron;?></h1></td>
                     </tr>
                     <tr>
                     <td><h1>Prom:</h1></td>
                     <td><h1 id="hPromClientes"><? if($totalEstrellas['estrellasTotales'][0]->sumCliente>0){echo(round(($totalEstrellas['estrellasTotales'][0]->sumCliente*100)/$totalEstrellas['estrellasTotales'][0]->totalCliente,2));}else{echo 0;}?>%</h1></td>                                 
                    </table>                    
                    </div>
                    
                    </div>
                    <div class="row">
                    <div class="col-md-12 col-xs-12">
                    <table>
                     
                     <tr>
                       <td>
                         <div id="graficos"><figure id="figureCalificacion" class="arco" data-valor="<?if($totalEstrellas['estrellasTotales'][0]->sumTotal>0){echo(round(($totalEstrellas['estrellasTotales'][0]->sumTotal*100)/$totalEstrellas['estrellasTotales'][0]->total,2));}else{echo 0;}?>%"><label style="position: relative;left:100px;top: 60px;font-size: 24px">★</label><label style="position: relative;left: 50px;top: 60px;font-size: 24px">★</label><label style="position: relative;left: 0px;top: 60px;font-size: 24px">★</label><label style="position: relative;left: -50px;top: 60px;font-size: 24px">★</label><label style="position: relative;left: -100px;top: 60px;font-size: 24px">★</label></figure></div>
                       </td>
                       <td><h1 id="hEstrellasTotales"><?=$totalEstrellas['estrellasClienteTotal'][0]->cuantosCalificaron;?> PERSONAS HAN CALIFICADO A ESTE AGENTE</h1><h1> DESDE <?=$totalEstrellas['estrellasTotales'][0]->primerFechaCalificacion;?></h1><br>
                          <h1 id="hEstrellasTotalesCalificacion"><?if($totalEstrellas['estrellasTotales'][0]->sumTotal>0){echo(round(($totalEstrellas['estrellasTotales'][0]->sumTotal*100)/$totalEstrellas['estrellasTotales'][0]->total,2));}else{echo 0;}?> CALIFICACION GENERAL</h1>
                       </td>
                     </tr>
                    </table>             
                    </div>
                    </div>


                    <table>
                      <style type="text/css">
                      #graficos{color: yellow}

                        #graficos .arco {
      display: block; 
      font: 900 .8em/6em serif; 
      text-align: center; 
      margin: .2em auto; 
      width: 24em; height: 12em; 
      background-color: gainsboro; 
      padding: 0; 
      background-repeat: no-repeat; 
      background-position: 0 0; 
      background-size: 100% 100%, 100% 200%; 
      }

                      </style>
                      <script type="text/javascript">
                        function ajusta() {

      var arcos = document.querySelectorAll("#graficos .arco"); 



      elem = 0; 
      while(elem<arcos.length) {
      arcos[elem].style.backgroundImage = "radial-gradient(circle at bottom, #f5f5f5 45%, transparent 47%, transparent 67%,       #f5f5f5 70%), linear-gradient("
      + (parseInt(arcos[elem].getAttribute('data-valor')) / 100) * 180 +
      "deg, green 50%, transparent 50%)"; 
      elem++; 
      }; 

      }

        onload = ajusta; 
                      </script>
                    <tr><td colspan="2" align="left" >Clientes nuevos</td><td colspan="3" align="left" >Clientes</td></tr>
                    <tr><td colspan="2" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>El asesor fue puntual</label></td><td colspan="3" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Seguimiento constante a sus trámites</label></td></tr>
                    <tr><td colspan="2" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Cumplio con lo ofrecido</label></label></td><td colspan="3" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>El representate le genera confianza</label></td></tr>
                    <tr><td colspan="2" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Su imagen personal era adecuada</label></label></td><td colspan="3" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Siempre ubicable y disponible</label></td></tr>
                    <tr><td colspan="2" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Transmitio confianza</label></label></td><td colspan="3" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Profesionalismo</label></td></tr>
                    <tr><td colspan="2" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Lo asesoro adecuademente</label></td><td colspan="3" align="left"><?php   echo('<img style="width:20px"  src="'.base_url().'assets/images/starLlena.png"> ');   ?><label>Su servicio está orientado a las necesidades del cliente</label></td></tr> 
                     <tr >
                        <td class="estrellaNoChecked" onclick="califica(this)">
                        </td>
                        <td class="estrellaNoChecked"  onclick="califica(this)">
                        </td>
                        <td class="estrellaNoChecked" onclick="califica(this)">
                        </td>
                        <td class="estrellaNoChecked" onclick="califica(this)">
                        </td>
                        <td class="estrellaNoChecked" onclick="califica(this)">
                        </td>
                        <tr align="right" >
                              <td colspan="5"><button class="btn btn-primary" onclick="enviaFormEstrella()" >Calificar</button></td>
                        </tr
                        <tr align="left"  >
                              <td colspan="5">
                                  <form method="post"  action="<?php echo base_url().'validarinformacion/guardaInconformidad'; ?>">
                                      <label><b> Escribe tu inconformidad:</b></label><br>
                                      <label>Nombre:</label><input type="text" name="nomInconformidad">
                                      <label>Telefono:</label><input type="text" name="telInconformidad">
                                      <label>Email:</label><input type="text" name="emailInconformidad">
                                      <textarea cols="20" id="micajaInconformidad"  onkeyup='cantCaracteres(this)' type="text" name="textTareaInconformidad" style="height: 100px; width: 100%"></textarea>
                                      <input type="hidden" name="gafeteInconformidad" value="<?php echo utf8_decode($value['IDValida']); ?>">
                                      <input type="hidden" name="idPersona" value="<?php echo utf8_decode($value['idPersona']); ?>">
                                      <label>Caracteres usados: </label><label id="labelContador">0 - 300</label>
                                      <input type="submit" value="Enviar Inconformidad "  name="" class="btn btn-primary">
                                   </form>
                              </td>
                        </tr>
                        <script type="text/javascript">
      function cantCaracteres(object){
           
       if(object.value.length>300){
         var valor=object.value.slice(0,300);
         object.value=valor;
       }else{
        document.getElementById("labelContador").innerHTML=object.value.length+" de 300";
       }
      }
      </script>
                        tr>
                           <td ><label style="font-size: 36px">Calificacion:<?php   
                            if($facultadesAgenteDato[0]->cantidadEstrellas==0){echo(0);}else{             
                        echo(round(($facultadesAgenteDato[0]->cantidadEstrellas*100)/(5*$facultadesAgenteDato[0]->cantidadPersonasEstrellas),2));} ?></label><label style="font-size: 36px;position: relative;top: 15px"><?php echo($facultadesAgenteDato[0]->cantidadPersonasEstrellas);  ?></label><img style=""  src="<?php echo base_url().'assets/images/starPersona.png' ?>" /></td>
                            <td colspan="4">
                                <?php  
                                   if($facultadesAgenteDato[0]->cantidadEstrellas==0)
                                   {
                                       for($i=0;$i<5;$i++){echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');}
                                  }
                                  else
                                  { $numeroEstrellas=($facultadesAgenteDato[0]->cantidadEstrellas/$facultadesAgenteDato[0]->cantidadPersonasEstrellas); 
                                   if(is_int($numeroEstrellas))
                                   {
                                    
                                    for($i=0;$i<$numeroEstrellas;$i++){
                                       echo('<img style=""  src="'.base_url().'assets/images/starLlena.png"> ');
                                    }
                                    for($i=0;$i<(5-$numeroEstrellas);$i++){
                                     echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');   
                                    }
                                   }
                                   else
                                   { 
                                     for($i=0;$i<(int)$numeroEstrellas;$i++){
                                       echo('<img style=""  src="'.base_url().'assets/images/starLlena.png"> ');
                                    }

                                     echo('<img style=""  src="'.base_url().'assets/images/starMitad.png"> ');   
                                    for($i=0;$i<(5-($numeroEstrellas+1));$i++){
                                     echo('<img style=""  src="'.base_url().'assets/images/starVacia.png"> ');   
                                    }
                                   }
                                 }
                                ?>

                            </td>
                        </tr
           
                        
                   
                    </table>
                </div>  
    -->

    <!-- -->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
        <form id="formEstrellas" style="display: none" action="<?php echo base_url().'validarinformacion/guardaEstrellas'; ?>" method="post"><input type="text" name="inputEstrellas" id="inputEstrellas" value="2"><input type="text" value="<?php echo($value['emailUser']) ?>" name="inputEmailEstrella">  <input type="text"value="<?php echo utf8_decode($value['IDValida']); ?>" name="inputIdGafeteEstrella"></input></form>

              <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <br />
                   
                </div>  
      </div>
    </div>
  <style type="text/css">
    .estrellaNoChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starVacia.png' ?>) }
    .estrellaChecked{ background-repeat: no-repeat;width: 200px; height:40px;background-image:url(<?php echo base_url().'assets/images/starLlena.png' ?>) }
  </style>

  <script type="text/javascript">
    var estrellas=[];
    var id_user;
    function enviaFormEstrella(){
        document.getElementById("formEstrellas").submit();
    }
    function califica(objeto){
        var row=objeto.parentNode;
      document.getElementById("inputEstrellas").value=objeto.cellIndex+1;
      if(objeto.cellIndex!=0){
      for(var i=0;i<5;i++){row.cells[i].classList.remove("estrellaChecked");row.cells[i].classList.add("estrellaNoChecked");}
      for(var i=0;i<=objeto.cellIndex;i++){row.cells[i].classList.add("estrellaChecked");}
      }
      else{
      for(var i=1;i<5;i++){row.cells[i].classList.remove("estrellaChecked");row.cells[i].classList.add("estrellaNoChecked");}
      if(row.cells[0].classList.contains('estrellaChecked')){row.cells[0].classList.remove("estrellaChecked");row.cells[0].classList.add("estrellaNoChecked");document.getElementById("inputEstrellas").value=0;}
      else{row.cells[0].classList.add("estrellaChecked");row.cells[0].classList.remove("estrellaNoChecked");}}
        //alert(objeto.cellIndex);
      //alert(p.rows[0].cells.length);
    }
  </script>

    <!-- Certificaciones -->
    <?php if($agentes[0]['Giro']!='AGENTE DE FIANZAS'){ ?>
    <div class="col-md-12" style="margin-bottom: 50px">
      <h3 class="title-center">Certificaciones</h3>
      <hr>
      <div class="col-md-12 pd-left pd-right" style="margin-bottom: 20px;">
        <center><h4>Valida las capacitaciones del Agente</h4></center>
        <div class="col-md-12 column-flex-center-center container-percentage-certificate">
          <? $porcentaje     = round(($value['certificacion']/24)*100,2,1);  ?>
          <span style="text-align:center;">
            <!-- <img  src="<?=$graficaPorcen.$porcentaje."&wdt=30"?>" title="" > -->
            <img src="https://capsys.com.mx/V3/assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=0&amp;wdt=30" title="">
          </span>
          <h4 class="mg-left">Total de Capacitaciones</h4> 
        </div>
      </div>
      <div class="col-md-12 pd-left pd-right">
        <!-- <label class="textForm">Seleccione una opción para ver las certificaciones</label> -->
        <div class="panel panel-default">
          <div class="panel-body" role="tabpanel">
            <div class="" style="padding-bottom: 15px;">
              <center><h4><i class="fas fa-graduation-cap"></i> Seguimiento de Certificaciones</h4></center>
            </div>
            <ul class="nav nav-tabs" role="tablist" style="border: 1px solid #ddd;border-bottom: none;">
              <?php if(!empty($capacitacion)) {
                $cont = 0;
                $keys = array_keys($capacitacion);
                foreach($keys as $dk){
                $cont++;
                //var_dump($cont++);
              ?>
              <li role="" class="<?=$cont == 1 ? "active" : ""?>" data-cont="<?=$cont?>">
                <a href="#<?=str_replace(" ","_",$dk)?>" aria-controls="<?=str_replace(" ","_",$dk)?>" role="tab" data-toggle="tab"><?=$dk?></a>
              </li>
              <?php } }?>
            </ul>
            <div class="tab-content" style="border: 1px solid #ddd;">
                    <?php 
                        $cont_1 = 0;
                    foreach($capacitacion as $kc => $data_cert){ 
                        $cont_1++;?>
                        <div role="tabpanel" class="tab-pane fade <?=$cont_1 == 1 ? "in active" : ""?>" id="<?=str_replace(" ", "_", $kc)?>">
                            <?php foreach($data_cert as $kce => $ramos){
                                 $sumatoria = 0;?> 
                                <div class="row segment-cert-agent">
                                    <div class="col-md-12">
                                        <center><h4 class="title-tab-content"><i class="fa-solid fa-certificate"></i> <?=$kce?></h4></center>
                                    </div>
                                    <div class="col-md-12 table-responsive">
                                        <?php $key_ramos = array_keys($ramos["data"]);?>
                                        <div class="card-body">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><h5><span class="label label-primary">Ramos en que se capacitó</span></h5></td>
                                                        <?php foreach($key_ramos as $kr){?>
                                                            <td class="text-center"><h5><span class="label label-success"><?=strtoupper($kr)?></span></h5></td>
                                                        <?php }?>
                                                        <td><h5><span class="label label-wine">Total de horas</span></h5></td>
                                                    </tr>
                                                    <tr>
                                                        <td><h5><span class="label label-primary">Horas capacitadas</span></h5></td>
                                                        <?php foreach($ramos["data"] as $horas){ 
                                                             $sumatoria += $horas?>
                                                            <td class="text-center text-middle"><?=$horas?></td>
                                                        <?php }?>
                                                        <td class="text-center text-middle"><?=$sumatoria?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    <?php }?>
                    <!--<div role="tabpanel" class="tab-pane" id=""></div>-->
                </div>
            </div>
        </div>    

        <!--<div class="col-md-4 col-sm-4 col-xs-6">


             <div class="row"> 
                    <label><b>Hrs de Desarrollo Profesional: </b></label>
                    <?php echo utf8_decode($value['certificacion']); ?>
             </div>        
                
             <div class="row">
                    <label><b>Hrs Certificadas en Autos: </b></label>
                    <?php echo utf8_decode($value['certificacionAutos']); ?>
             </div>   

              <div class="row"> 
                 
                    <label><b>Hrs Certificadas en Gastos Med: </b></label>
                    <?php echo utf8_decode($value['certificacionGmm']); ?>
               
             </div>   

            <div class="row">
                 
                    <label><b>Hrs Certificadas en Vida: </b></label>
                    <?php echo utf8_decode($value['certificacionVida']); ?>
                
            </div> 
            
            <div class="row">    
                
                    <label><b>Hrs Certificadas en Daños: </b></label>
                    <?php echo utf8_decode($value['certificacionDanos']); ?>
                
            </div> 
            
             <div class="row">   
                 
                    <label><b>Hrs Certificadas en Fianzas: </b></label>
                    <?php echo utf8_decode($value['certificacionFianzas']); ?>

                  
                
            </div>   


            


       </div>-->   


            <?
			if($value['certificacion'] > "0"){
			?>
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12">
                	<br />
                    <label><strong><!--Certificaciones-->Autorizado para asesorar en:</strong></label>
                </div>
            </div>
            <div class="row">
				<div class="col-md-1 col-sm-1 col-xs-1 text-center">
                	&nbsp;
                </div>
            <?
			if($value['certificacionAutos'] > "0"){
			?>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/autos.png' ?>"
                        width="60"
                        alt="Certificacion Autos"
                        title="Certificacion Autos"
                    >
					<br />
                    <label>Autos</label>
				</div>
            <?
			}
			if($value['certificacionVida'] > "0"){
			?>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/vida.png' ?>" 
                        width="60"
                        alt="Certificacion Vida"
                        title="Certificacion Vida"
                    >
					<br />
                    <label>Vida</label>
				</div>
            <?
			}
			if($value['certificacionGmm'] > "0"){
			?>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/gmm.png' ?>"
                        width="60"
                        alt="Certificacion Gmm"
                        title="Certificacion Gmm"
                    >
					<br />
                    <label>Gmm</label>
				</div>
            <?
			}
			if($value['certificacionDanos'] > "0"){
			?>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/danos.png' ?>"
                        width="60" 
                        alt="Certificacion Da&ntilde;os"
                        title="Certificacion Da&ntilde;os"
                    >
					<br />
                    <label>Da&ntilde;os</label>
				</div>
            <?
			}
			if($value['certificacionFianzas'] > "0"){
			?>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/fianzas.png' ?>"
                        width="60"
                        alt="Certificacion Fianzas"
                        title="Certificacion Fianzas"
                    >
					<br />
                    <label>Fianzas</label>
				</div>
            <?
			}
			?>
				<div class="col-md-1 col-sm-1 col-xs-1 text-center">
                	&nbsp;
                </div>
			</div>
            <?
			}
			?>
            <?
			if($value['Giro'] == "AGENTE" || $value['Giro'] == "AGENTE INTEGRAL"){
			?>
            <div class="row">
            	<div class="col-md-12 col-sm-12 col-xs-12">
                	<br />
                    <label><strong>Autorizado para asesorar en:</strong></label>
                </div>
            </div>
            <div class="row">
				<div class="col-md-1 col-sm-1 col-xs-1 text-center">
                	&nbsp;
                </div>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/autos.png' ?>"
                        width="60"
                        alt="Certificacion Autos"
                        title="Certificacion Autos"
                    >
					<br />
                    <label>Autos</label>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/vida.png' ?>" 
                        width="60"
                        alt="Certificacion Vida"
                        title="Certificacion Vida"
                    >
					<br />
                    <label>Vida</label>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/gmm.png' ?>"
                        width="60"
                        alt="Certificacion Gmm"
                        title="Certificacion Gmm"
                    >
					<br />
                    <label>Gmm</label>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/danos.png' ?>"
                        width="60" 
                        alt="Certificacion Da&ntilde;os"
                        title="Certificacion Da&ntilde;os"
                    >
					<br />
                    <label>Da&ntilde;os</label>
				</div>
				<div class="col-md-2 col-sm-2 col-xs-2 text-center">
					<img
                    	src="<?php echo base_url().'assets/img/certificaciones/fianzas.png' ?>"
                        width="60"
                        alt="Certificacion Fianzas"
                        title="Certificacion Fianzas"
                    >
					<br />
                    <label>Fianzas</label>
				</div>
				<div class="col-md-1 col-sm-1 col-xs-1 text-center">
                	&nbsp;
                </div>
			</div>
            <?
			}
			?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <br />
                    <hr>
                </div>
            </div>

             <div class="col-md-12">  
                    <label>Estimado Asegurado: En <b>Agente Capital Seguros y Fianzas</b> todos nuestros Asesores deben cumplir con un minimo de horas de capacitacion anualmente con el fin de brindarle un servicio de excelencia y asesorarale. </label>
             </div>   

             <!--<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <img
                        src="<?php echo base_url().'assets/img/bannervalida.jpg' ?>"
                         width="800" height="500"
                    >
                    <br />
                    <label></label>
                </div>
            </div>-->
    <?
      }
    ?>

            <div style="clear: both;">  
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <label style="color: #3d3d3d;"><b>Fotos de Cursos</b></label>               
                </div> 
                <div style="width:100%;height:300px; overflow: scroll; float:left; ;">

                    <?php 
                    if(isset($imagenesMisCursos['imagenes'] )){
                        foreach ($imagenesMisCursos['imagenes'] as  $value) {
                            echo($value);
                        }
                    }
                    ?>
                </div>
             </div> 


		<?php endforeach ?>
	</div>
    
</section>
<script type="text/javascript">
function guardarCalificacionEstrella(datos,clase,tipo,idPersona)
{
    if(datos=='')
   {
    //let params='';
    //params=params+'comentario='+document.getElementById('comentarioParaAN').value;
    //params=params+'&idPersona='+document.getElementById('textIdPersonaComentario').value;
    //params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
    controlador="validarinformacion/guardarCalificacionEstrella/?";
     let estrellas=document.getElementsByName(clase);
     let cant=estrellas.length;
     let info="";
     for(let i=0;i<cant;i++)
     {   if((i+1)==cant){info=info+estrellas[i].value+','+estrellas[i].checked;}
         else{info=info+estrellas[i].value+','+estrellas[i].checked+';';}
     }
    let params='';
    params=params+'tipo='+tipo;
    params=params+'&valores='+info; 
    params=params+'&idPersona='+idPersona;
    peticionAJAX(controlador,params,'guardarCalificacionEstrella');    
   }
   else
   {
     
     document.getElementById('hEstrellasCliente').innerHTML=datos.estrellasCliente.estrellasCliente[0].cuantosCalificaron;
     document.getElementById('hEstrellasClientesNuevas').innerHTML=datos.estrellasCliente.estrellasClienteNuevas[0].cuantosCalificaron;
     document.getElementById('hEstrellasTotales').innerHTML=datos.estrellasCliente.estrellasClienteTotal[0].cuantosCalificaron+' PERSONAS HAN CALIFICADO A ESTE AGENTE';
     let sum=0;
     sum=(parseFloat(datos.estrellasCliente.estrellasTotales[0].sumClienteNuevo)*100)/parseFloat(datos.estrellasCliente.estrellasTotales[0].totalClienteNuevo);
     document.getElementById('hPromClientesNuevos').innerHTML=sum.toFixed(2)+'%';
     sum=(parseFloat(datos.estrellasCliente.estrellasTotales[0].sumCliente)*100)/parseFloat(datos.estrellasCliente.estrellasTotales[0].totalCliente);
     document.getElementById('hPromClientes').innerHTML=sum.toFixed(2)+'%';
     sum=(parseFloat(datos.estrellasCliente.estrellasTotales[0].sumTotal)*100)/parseFloat(datos.estrellasCliente.estrellasTotales[0].total);
     document.getElementById('hEstrellasTotalesCalificacion').innerHTML=sum.toFixed(2)+' CALIFICACIONGENERAL';
          document.getElementById('figureCalificacion').setAttribute('data-valor',sum.toFixed(2)+'%');
          ajusta();
   }

}

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";var url=direccionAJAX+controlador;
   req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) {if (req.readyState == 4) {if(req.status == 200){ var respuesta=JSON.parse(this.responseText); window[funcion](respuesta);}}
  };
 req.send(parametros);
}


</script>
<style>
.imgMisCursos{
  width: 200px;height: 200px;float: left;margin-left: 10px; margin-top: 10px;position: relative;top:0px;border: double;
}
.estrellasValidador{position:relative;left:-10%;top:15px;margin-left: 0;}
.checkboxEstrella{display:none;}
.checkboxEstrella + label{color:gray;font-size:40px}
.checkboxEstrella:checked  + label{color:#ffff4e}
</style>
<?php //$this->load->view('footers/footer'); ?>
<?
function imprimirEstrellasClienteNuevo($datos,$name)
{
    $div='<table class="table" >';
    foreach ($datos as $key => $value) 
    {
     $div.='<tr><td><input type="checkbox" name="'.$name.'" class="checkboxEstrella" id="checkboxEtrella'.$value->idEstrellaValidador.'" value="'.$value->idEstrellaValidador.'"' ;
     $div.=' value="'.$value->idEstrellaValidador.'" class="form-control"><label for="checkboxEtrella'.$value->idEstrellaValidador.'">★</label></td>';
     $div.='<td><div class="col-md-10 col-xs-10 estrellasValidador" align="left">'.$value->estrellaValidador.'</td>';
    }
    $div.='</table>';
    return $div;
}
?>

<script type="text/javascript">

function validarEstrella(estrella,ct,id_user)
{
   this.id_user=id_user;
   var nombre="estrella"+ct;
   var nombreObjeto="est"+ct;
   var color=document.getElementById("color"+ct).value;

   if(color==0){
       document.getElementById("color"+ct).value=1;
       this.document.getElementById(nombre).style.color="#d2b819";
        estrellas.push(estrella);
   }else{
       document.getElementById("color"+ct).value=0;
       this.document.getElementById(nombre).style.color="#1976d2";
       let indice=estrellas.indexOf(estrella);
       estrellas.splice(indice, 1);
   }
}

function guardarEstrellas(){
  if(estrellas.length>0)
  {
    ajax=objetoAjax();   
    var URL="https://www.asesoresonline.mx/tarjeta/estrellas/setEstrellas.php?idValidador="+<?=$idValidador?>+"&id_user="+this.id_user+"&estrellas="+JSON.stringify(estrellas);     
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
        window.location.reload();
      }
    }
  ajax.send(null)  
  }else{
    swal("Para calificar debe seleccionar al menos una estrella");
  }
}

function guardarComentarios(id_user){
  let comentario=document.getElementById('comentario').value;
  let nombre=document.getElementById('nombre').value;
  if(comentario!=""){
    ajax=objetoAjax();   
    var URL="https://www.asesoresonline.mx/tarjeta/estrellas/setComentarios.php?idValidador="+<?=$idValidador?>+"&id_user="+id_user+"&comentario="+comentario+"&nombre="+nombre;

    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
        swal("Su comentario fue guardado!");
        document.getElementById('comentario').value='';
        document.getElementById('nombre').value='';
        window.location.reload();
      }
    }
  ajax.send(null)
  }else{
     swal("Validacion","Debe ingresar un comentario!","error");
  }  
}

/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}

//-------------------------------------------------------------------------------------------------------
  getComments('<?=$idPersona?>'); //Creado [Suemy][2024-10-11]
  getScoreStars('<?=$idValidador?>'); //Creado [Suemy][2024-10-11]
  function getComments(agent) { //Creado [Suemy][2024-10-11]
    $.ajax({
        type: "GET",
        url: `<?=base_url()?>calificacionAgente/getEvaluationsByAgent`,
        data: { ag: agent },
        beforeSend: (load) => {
        },
        success: (data) => {
            const resp = JSON.parse(data);
            //console.log(resp);
            const comment = $('#comentariosDiv').html();
            let dd = resp['agent'];
            let r = dd.generadas;
            var div = ``;
            if (r != 0) {
              for (a in r) {
                let dd = [{[0]:r[a].id, [1]:r[a].estrellas}][0];
                var p = ``;
                var inicial = r[a].nombre.split(" ");
                inicial = inicial[0][0] + inicial[1][0];
                for (i=0;i<5;i++) {
                  var id_star = i + 1;
                  var value = 5 - i;
                  var checked = r[a].estrellas == value ? "checked" : "";
                  p += `
                    <input class="response-star" type="radio" id="star${id_star}-${r[a].id}" name="${r[a].id}" value="${value}" ${checked}>
                    <label for="star${id_star}-${r[a].id}"><i class="fas fa-star icon-star"></i></label>
                  `;
                }
                //Comentarios
                //div += draw_comment(r[a].nombre,r[a].fecha_creacion,r[a].comentario,1,dd);
                div += `
                  <div class="comentariosDiv">
                    <div class="textUserComment">
                      <div class="column-flex-center-start">
                        <div class="dash-user-comment">${inicial}</div>
                        <p class="mb-n1 font-weight-semibold mg-bottom-cero">${r[a].nombre}</p>
                      </div>
                      <div>
                        <small class="text-muted ml-auto"><i class="fas fa-calendar-alt mg-right"></i>${r[a].fecha_creacion}</small>
                      </div>
                    </div>
                    <div class="textStars"><p class="container-stars">${p}</p></div>
                    <div class="textComment">
                      <small><i class="fa fa-comments"></i>&nbsp;${r[a].comentario}</small>
                    </div>
                  </div><br>
                `;
              }
            }
            else {
                div = `<div><center><b>Sin comentarios</b></center></div>`;
            }
            //Comentarios
            div = comment.includes("Sin comentarios") ? div : div + comment;
            $('#comentariosDiv').html(div);
        },
        error: (error) => {
            console.log(error);
        }
    })
  }

  function getScoreStars(agent) { //Creado [Suemy][2024-10-11]
    $.ajax({
        type: "POST",
        url: `<?=base_url()?>validarinformacion/devuelvePuntosCalificacion`,
        data: { idValidador: agent },
        beforeSend: (load) => {
        },
        success: (data) => {
            const resp = JSON.parse(data);
            console.log(resp);
            let estrellas='';
            let ct=0;
    
            for(let val of resp.estrellas) {
              ct++;
              let valorPorcentaje=String(val.estrellas).includes('.') ? val.estrellas*10 : val.estrellas; //Agregado por ligero cambio en los resultados de la consulta
              if(val.id!='0'){
                valorPorcentaje=(valorPorcentaje*100)/resp.totalCuantos;
                var stars = ``;
                switch(true) {
                  case (valorPorcentaje == 0):
                    stars = `<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 0 && valorPorcentaje < 20): 
                    stars = `<i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 20 && valorPorcentaje < 30):
                    stars = `<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 30 && valorPorcentaje < 40):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 40 && valorPorcentaje < 50):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 50 && valorPorcentaje < 60):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 60 && valorPorcentaje < 70):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 70 && valorPorcentaje < 80):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 80 && valorPorcentaje < 90):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>`;
                    break;
                  case (valorPorcentaje >= 90 && valorPorcentaje < 100):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>`;
                    break;
                  case (valorPorcentaje >= 100):
                    stars = `<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>`;
                    break;
                }
                //console.log(valorPorcentaje);
                estrellas+=`
                  <div class="container-specialities">    
                    <div class="pd-side">
                      <span data-idestrella="${val.id}" id="estrella${ct}" style="color: #0089ff;">
                        <i class="fas fa-certificate" style="font-size: 24px;" id="estrella.${ct}"></i>
                      </span>
                    </div>
                    <div class="pd-side"><span class="lt">${val.descripcion}</span></div>
                    <div class="pd-side">${stars}</div>
                  </div>`;
                }
            }
            document.getElementById('calificarRepresentantesDiv').innerHTML=estrellas;
        },
        error: (error) => {
            console.log(error);
        }
    })
  }
</script>