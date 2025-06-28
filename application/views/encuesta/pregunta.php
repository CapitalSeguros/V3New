<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>
<script type="text/javascript">
	<?php if(isset($pestania)){ ?> manejoMenu(<?php echo('"'.$pestania.'"'); ?>); <?php } ?>
</script>
<style type="text/css">
	.modal-contenidoGenerico{background-color:none	;width:90%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
    .modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
    .modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
    .botonCierre{background-color: red;color:white;}
    .contenidoModal{border: solid; color: black; background-color: white;width: 50%;height: 50%}
    .infoModal{position: relative; left: 0%;top: 30%}
    .labelModal{color: red;background-color: white; font-size: 18px;}
    .botonCancelar{border-left: 5px;left: 40%;position: relative;}
    .buttonMenu{width: 100%}
    .subContenido{display: none}
    .ocultarObjeto{display: none}
    .verObjeto{display: block;}
    .encuesta{
      font-size:15px ;
    color: red;
    }
    .tituloencuesta{
      margin-left: 5px;
      font-size:15px ;
      text-transform: uppercase;
    
    }
    .editaTitulo
    {
      color:red;
      font-size:25px;
     
    }
    .nombreTitulo
    {
      display:flex;
      align-items:center;
      margin-bottom:9px;
    }
    .editaTitulo:hover{
      cursor: pointer;
    }
 </style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
 <form  class="form-horizontal" role="formreferidos"
            id="formreferidos" name="formreferidos"
            method="post" 
            action="<?=base_url()?>pregunta/GuardarPregunta/" > 
  <div style="display: flex;">
  <div style="flex: 1"><?php $this->load->view("encuesta/opcionesEncuesta");?></div>
  <div style="flex: 10;display: flex;flex-direction: column;">
      <div ><h4 class="titulos"> Encuestas </h4></div>
     <div>
      <div class="nombreTitulo">
         <label class="encuesta"> Nombre Ecuesta </label>
        <!--span class="tituloencuesta"><?php echo $nombre[0]->descripcion ?></span> </div-->
        <input type="text" style="width:350px;"  name="idEncuesta" id="idEncuesta"  required=""  value ="<?php echo $nombre[0]->descripcion ?>"> 
         <span class="tituloencuesta"><i class="far fa-save editaTitulo" ></i></span> 
     </div> 
      <div>
        <!--?php var_dump($nombre[0]->tipo); ?-->
           <input type="hidden" class="form-group-inline"  name="Encuesta" id="Encuesta" placeholder="Folio de Enuesta"  required=""  
             value ="<?=$IdEncuesta?>"> 
                        <label  class="form-group-inline"> Pregunta </label>  
            <input type="text"  name="pregunta" id="pregunta"  required="" size="80" > 

      </div>
      <div style=" margin :8px 0;">
                   <label class="etiquetaSimple" >Tipo de Respuesta</label>                    
              <select name="TipoRespuesta" 
              id="TipoRespuesta" 
              class="etiquetaSimple" required="" >
                <?php 
                  //alert($nombre[0]->tipo);
                  if ($nombre[0]->tipo =="1") {?>
                   <option value="NUMERO">1..10</option>
                   <?}?>
                   <?php if ($nombre[0]->tipo =="2") {?>
                   <option value="NUMERO">1..10</option>
                   <?}?>
                   <?php if ($nombre[0]->tipo =="3") {?>
                     <option value="VOF">V o F(SI O NO)</option>  
                     <?}?>                                
                </select>
              <label  class="etiquetaLabel1" >&nbsp; &nbsp;Respuesta</label>                    
              <select name="respuesta" 
              id="respuesta" 
              class="etiquetaSimple" required="">
                  <? if ($nombre[0]->tipo =="1") {?>
                  <option value="1">1</option>
                  <?}?>
                  <?php if ($nombre[0]->tipo =="2") {?>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                  <?}?>
                  <?php if ($nombre[0]->tipo =="3") {?>
                  <option value="V">V (SI)</option>
                  <option value="F">F (NO)</option>   
                  <?}?>                               
                </select>
                <label  class="etiquetaLabel1" >&nbsp; &nbsp;NPS</label>    
              
                  <select name="selectNps" 
                  id="selectNps" 
                  class="etiquetaSimple" >
                  
                <?if ($nombre[0]->tipo =="1") 
                {
                  
                 if(intval($tipoEncuesta[0]->tipoencuesta) == 0)
                
                {?>                  
                  
                      <option value="Tiempos">Tiempos</option>
                      <option value="Aseguradora">Aseguradora</option>
                      <option value="Asesoria">Asesoria</option>                                  
                      <option value="Gestor">Gestor</option>                                 
                      <?     
                } 
                    if(intval($tipoEncuesta[0]->tipoencuesta) == 1)
                {?>
                  
                      <option value="Tiempos">Tiempos</option>
                      <option value="Aseguradora">Aseguradora</option>
                      <option value="Asesoria">Asesoria</option>                                  
                      <option value="Gestor">Gestor</option>                                  
                      <?     
                } 
                  if(intval($tipoEncuesta[0]->tipoencuesta) == 2)
                {?>
                  
                      <option value="Tiempos">Tiempos</option>
                      <option value="Aseguradora">Asegurador</option>
                      <option value="Profesionalismo">Profesionalismo</option>                                  
                      <option value="Nivel">Nivel de Satisfaccion </option>                                  
                      <?  
                }
                ?>
                </select>                  
                  <?
               } ?>
                                  <input style="margin:0 5px;" type="submit" name="button" id="button" value="Guardar Preguntas" align="center"  
                        onclick=""> 
      </div>
      <div>         <table class="table" id='Mitabla'>
          <thead>
                      <tr>
                  <th>Eliminar</th>
                  <th>Id</th>
                  <th>Pregunta</th>
                  <th>Tipo</th>    
                  <th>Respuesta</th>                                           
                                               
                                </tr>
           </thead>
        <tbody>          
         <?php
          if($Pre != FALSE){
            foreach ($Pre as $row){
               ?>
                     <td><?
                    ?>
                         <a href="<?=base_url()?>pregunta/eliminaPregunta?IDpre=<?php echo $row->idpregunta?>"
                         .?IDCL=. class='btn btn-primary btn-xs contact-item'   data-original-title><span class="glyphicon -remove" ></span>Eliminar</a>
                                    
                                         <?                          
                    ?></td>
                    <th><?=$row->idpregunta?></th>
                    <th><?=$row->pregunta?></th>
                    <th><?=$row->tipo?></th>
                    <th><?=$row->respuesta?></th>
                    </tr>
              <?php
              }
           }
         ?>
           </tbody>

            </table></div>
  </div>
   </div>
</form>
<script>
  AddEventListener();
  function AddEventListener(){
    //document.querySelector("#boton").addEventListener('click',graba);
    document.querySelector("#button").addEventListener('click',comprueba);
    document.querySelector(".editaTitulo").addEventListener('click',titulo);
  }
  /************************* */
function titulo(e)
{
   
   var nombre =e.target; 
   var tituloEncuesta = document.getElementById("idEncuesta").value;
   var idEncuesta = document.getElementById("Encuesta").value;
// if(e.target.classList.contains('fa-star'))
   if(nombre.classList.contains('fa-save'))
   {
    if (tituloEncuesta =="")
    {
     // tituloEncuesta.focus();.focus();
     document.getElementById("idEncuesta").focus();
      Swal.fire({
                    title: 'Error!',
                    text:'El titulo no Puede estar Vacio',
                    type:'success'
                     });
       return;              
                   
    }
   
        var xhr = new XMLHttpRequest();
        var datos = new FormData();
        datos.append('idencuesta',idEncuesta);
        datos.append('titulo',tituloEncuesta);
        xhr.open('POST',"<?=base_url()?>pregunta/updateTitulo",true);
        xhr.onload=function()
              {
                if(this.status === 200)
                {
                  var respuesta = JSON.parse(xhr.responseText);
                  console.log(respuesta);
                    Swal.fire({
                    title: 'Exito!',
                    text:'se ha actualizado la Encuesta',
                    type:'success'
                     });
                  
                }
              }  
        xhr.send(datos);  
   }
   return;
   //console.log('entro');
}
 /************************* */
function comprueba(e)
{
   e.preventDefault();
  // console.log('entro');
   var idencuesta =  document.getElementById("Encuesta").value;
   var pregunta =  document.getElementById("selectNps").value.toUpperCase();
  // console.log(pregunta);
        var xhr = new XMLHttpRequest();
        var datos = new FormData();
        datos.append('idencuesta',idencuesta);
        datos.append('pregunta',pregunta);
        xhr.open('POST',"<?=base_url()?>pregunta/verificaNps",true);
              xhr.onload=function()
              {
                if(this.status === 200)
                {
                  var respuesta = JSON.parse(xhr.responseText);
                  //console.log(respuesta);
                 if(respuesta >= 1)
                   {
                    Swal.fire({
                    title: 'Error!',
                    text:'El Nps solo puede tener una pregunta de'+pregunta,
                    type:'success'
                     });
                   }
                  else{
                  document.getElementById("formreferidos").submit();
                  console.log(respuesta);
                  }
                }
              }  
        xhr.send(datos);  
        return;
}
</script>




