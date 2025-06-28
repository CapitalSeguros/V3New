<?
$emailUsuarioAsistencia=$this->tank_auth->get_usermail();
$idPersona = $this->tank_auth->get_idPersona();

if ($idPersona == 1067 || $idPersona == 907) {
  $consultaAsistencia="select (count(idPersona)) as contador,((now()))  as fecha,(year(now())) as anio,(month(now())) as mes,(day(now())) as dia,(hour(now())) as hora,(minute(now())) as minuto,(second(now())) as segundos,(weekday(now())) numeroDia,time (NOW()) as hora,(if(time (NOW())>'08:29:59' and time (NOW())<'09:01:00','GRABAR_PUNTUALIDADASISTENCIA','GRABAR_ASISTENCIA')) as rangoHora,(select count(diaNoLaboral) from dianolaboral where diaNoLaboral=date(NOW())) diaNoLaboral from fastfile where   year(fecha)=year(NOW()) and month(fecha)=month(NOW()) and day(fecha)=day(NOW()) and descripcion='asistencia' and idPersona=".$idPersona;
  $asistencia=$this->db->query($consultaAsistencia)->result()[0];

  $grabarAsistencia=1;
  if($asistencia->contador!=0){
    $grabarAsistencia=0;
  }
  else{
    if($asistencia->diaNoLaboral>0){
      $grabarAsistencia=0;
    }
  }
}
else {
  $consultaAsistencia="select (count(idPersona)) as contador,((now()))  as fecha,(year(now())) as anio,(month(now())) as mes,(day(now())) as dia,(hour(now())) as hora,(minute(now())) as minuto,(second(now())) as segundos,(weekday(now())) numeroDia, time (NOW()) as hora,(if(time (NOW())>'08:29:59' and time (NOW())<'09:01:00','GRABAR_PUNTUALIDADASISTENCIA',if(time (NOW())>'09:01:00' and time (NOW())<'09:30:00','GRABAR_ASISTENCIA','NO_GRABAR'))) as rangoHora,(select count(diaNoLaboral) from dianolaboral where diaNoLaboral=date(NOW())) diaNoLaboral from fastfile where   year(fecha)=year(NOW()) and month(fecha)=month(NOW()) and day(fecha)=day(NOW()) and descripcion='asistencia' and idPersona=".$idPersona;
  $asistencia=$this->db->query($consultaAsistencia)->result()[0];

  $grabarAsistencia=1;
  if($asistencia->contador!=0){$grabarAsistencia=0;}
  else
  {
  if($asistencia->numeroDia==5 || $asistencia->numeroDia==6){$grabarAsistencia=0;}
  else
  {
     if($asistencia->rangoHora=='NO_GRABAR'){$grabarAsistencia=0;}
     else{
          if($asistencia->diaNoLaboral>0){$grabarAsistencia=0;} 
          else{
                if($this->tank_auth->get_IDVend()>0){$grabarAsistencia=0;}
              }
        }
  }
  }
}

$tipoTrabajo= "select `tipoTrabajo` FROM `persona` WHERE idPersona=".$idPersona;
$modalidad=$this->db->query($tipoTrabajo)->result()[0];


if($modalidad->tipoTrabajo=="Presencial"){$grabarAsistencia==0;}
if($grabarAsistencia==1)
{
  $checkAsistencia='&#9989';
  $checkPuntualidad='&#10060';
  $mesNombre=['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTE','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'];
  $insert['idPersona']=$idPersona;
  $insert['fecha']=$asistencia->fecha;
  $insert['descripcion']='asistencia';
  $insert['valor']=1;
  $insert['comentario']="v3";
  $this->db->insert('fastfile',$insert);
  if($asistencia->rangoHora=='GRABAR_PUNTUALIDADASISTENCIA')
  {
   $checkPuntualidad='&#9989';
   $insert['idPersona']=$this->tank_auth->get_idPersona();
   $insert['fecha']=$asistencia->fecha;
   $insert['descripcion']='puntualidad';
   $insert['valor']=1;
   $insert['valor_ant']=1;
   $this->db->insert('fastfile',$insert);    
  }
?>
<div  id="mensajeDeAsistenciaDiv">
  <div><label><h3>Asistencia</h3></label></div>
  <div data-comentarios>
    <!--div><label data-comentariosLabel><h4 data-confirma>Confirma tu hora de asistencia.</h4></label></div-->
    <div><label data-comentariosLabel>-  La asistencia se toma a partir de las 08:30 hrs</label></div>
    <div><label data-comentariosLabel>-  Es retardo a partir de las 09:01:00 hrs</label></div>
    <div><label data-comentariosLabel>-  Despues de las 9:31 esta ventana ya no se visualizara</label></div>
  </div>
  <div data-comentarioFecha>
    <div><label data-comentariosLabel style="font-size: 16px">-  Fecha de hoy:</label><label style="font-size: 16px"><?=$asistencia->dia.' de '.$mesNombre[$asistencia->mes-1].' del '.$asistencia->anio?></label></div>
    <div><label data-comentariosLabel style="font-size: 16px">-  Hora actual: </label><label style="font-size: 16px"><?=$asistencia->hora?></label></div>
    <div><label data-comentariosLabel style="font-size: 16px">-  Asistencia</label><div style="font-size: 16px"><?=$checkAsistencia;?></div></div>
    <div><label data-comentariosLabel style="font-size: 16px">-  Puntualidad</label><div style="font-size: 16px"><?=$checkPuntualidad;?></div></div>
  </div>
  <div data-comentarioCerrar><button class="btn btn-primary" onclick="destruirVentana()">Cerrar</button></div>

</div>
<script type="text/javascript">
  function destruirVentana()
  {
    let padre=document.getElementById('mensajeDeAsistenciaDiv').parentNode;
    padre.removeChild(document.getElementById('mensajeDeAsistenciaDiv'));
  }
</script>
<style type="text/css">
  #mensajeDeAsistenciaDiv{display: flex;flex-direction: column;position: fixed;top: 15%;left: 20%;border: 1px solid rgba(0,0,0,.2);border-radius: 6px;width: 50%;background-color: white;z-index: 20}
  #mensajeDeAsistenciaDiv>div:nth-child(1){background-color: #472380;color:white;}
  #mensajeDeAsistenciaDiv>div:nth-child(1)>label{width: 100%}
  #mensajeDeAsistenciaDiv>div:nth-child(1)>label>h3{margin-left: 45%;color:white;}
  h4[data-confirma]{color: #31708f}
  div[data-comentarios]{display: flex;flex-direction: column;background-color: #d9edf7;margin:30px;}
  label[data-comentariosLabel]{color:#31708f;}
  div[data-comentarioFecha]{display: flex;flex-direction: column}
  div[data-comentarioFecha]{border:solid 1px #dee2e6;margin:30px;}
  div[data-comentarioFecha]>div{color:#808b96;display: flex}
     div[data-comentarioFecha]>div:nth-child(1){flex:1;} 
     div[data-comentarioFecha]>div:nth-child(2){flex:1;} 
  div[data-comentarioCerrar]{display: flex;flex-direction: row-reverse;}
  label[data-FechaLabel]{}



</style>

<? }
 
?>





<?php
	$sqlSlideInicio = "Select * From  `slide_inicio` Where 1 Order By `id` Asc";
	$querySlideInicio = $this->db->query($sqlSlideInicio);



	$this->load->view('headers/header'); 
    
?>
<!-- Navbar -->
<?php $this->load->view('headers/menu');?>
<style type="text/css">
  .modal-dialog{padding:0px;width:600px;}
  .modal-content{margin:50px auto;width :550px;}
  .etiquetaLabel1{font-size:14px;}
  .etiquetaSimple{text-transform:uppercase;font-size:14px;color:red;text-decoration:none;}
  .btn_new{padding: 5px 10px;background:green;color:white;}
  .modal-header{display:flex;flex-direction:column;text-align:center;justify-content: center;align-items:center;}
  .myModal{background-color: rgba(0,0,0,.8);position:fixed;display:none;height: 100vh;width: 100vw;transition: all .5s;top: 0;right: 0;bottom: 0;left: 0;z-index: 1040;overflow: hidden;outline: 0;}
.modal-body{min-height: 100px;overflow: hidden;}
.encuesta{height: 350px;overflow-y:scroll;}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<div id="myModal" class="myModal">   
     <!--div class="modal-dialog modal-sm" role="document"-->
     <div class="modal-content">
       <div class="modal-header">
         <div class="cabecera">
          <h4 class="modal-title" id="largeModalLabel">Encuesta</h4>
        </div>
        <div class="contenido">
          <p>Capital SF te da las gracias por aportar en la mejora continua, tu opinion es muy valiosa para nosotros</p>
          </div>
        </div>
     <div class="modal-body">
      <form  
            id="formencuestas" name="formencuestas"
            method="post" 
            action="javascript: enviarFormAjax('formencuestas','asigna','GrabaEncu')" > 
         <input type="hidden" name="idenc" id="idenc"  value="<?php echo $ide?>" />
        <div class="encuesta">
         <?php
        
           $valor=0;   
          if($Pre != FALSE){ 
             foreach ($Pre as $row){
              
                   if($valor==0)
                   {
                    ?>
                    </br>
                    <?
                   }
                    ?>
                   </br>
                   <label class="etiquetaLabel1" for="<?$row->idencuesta?>">&nbsp;&nbsp;<?php echo ltrim($row->pregunta) ?> </label>  
                  
                   <?
                    if($row->tipo == 1)
                    {
                     ?>
                     </br>
                     
                     <label class="etiquetaSimple">&nbsp;&nbsp;Respuesta &nbsp;</label>
                      <select name="<?php echo $row->idencuesta?>" 
                       id="<?php echo $row->idencuesta?>" 
                        class="form-control-width-small input-sm" required="">
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
                     </select>
                     
                     <?
                     }
                     else
                     {
                      ?>
                      </br>
                      <label class="etiquetaSimple">&nbsp;&nbsp;&nbsp;Respuesta &nbsp;</label>
                      <select name="<?php echo $row->idencuesta?>" 
                       id="<?php echo $row->idencuesta?>" 
                        class="form-control-width-small input-sm" required="">
                      <option value="V">V(SI)</option>
                      <option value="F">F(NO)</option>
                      </select>
                     <?
                     }                 
                     ?>  
                     </br>             
                     <? 
              $valor=$valor+1; 
              }          
      }
      ?>
      </div>
     <div class="modal-footer">
     <button type = "submit" class = "btn_new"><i class="fas fa-plus"> </i>Grabar</button>        
     <!--button name="cerrar" id="cerrar" type = "button" class = "btn_new" data-dismiss = "modal" >Cerrar</button-->
     </div>
      </form>
    
    
    </div>
     <!--/div-->

    </div>  
</div>
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- End navbar -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<section class="container-fluid breadcrumb-formularios">
        <div class="row">
            <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Bienvenido</h3></div>
            <div class="col-md-6 col-sm-7 col-xs-7">
                <ol class="breadcrumb text-right">
                    <li class="active">Inicio</a></li>
                </ol>
            </div>
        </div>
            <hr /> 
</section>
<section class="page-section">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-6 col-md-offset-6" align="right">
            	<font style="font-weight:bold; font-size:18px;">
            	<!--<a href="http://www.capsys.com.mx/V3" target="_blank">
                	Capsys Web Versi&oacute;n 2.1.1
                </a>-->
                </font>
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-12 col-md-12">
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
						<ol class="carousel-indicators">
                        <?
							$active = "active";
							foreach($querySlideInicio->result() as $slideInicio){
						?>
							<!--li data-target="#myCarousel" data-slide-to="<?=$slideInicio->id?>" class="<?=$active?>"></li-->
						<?
							$active = "";
							}
						?>
						</ol>
					<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
                        <?
							$active = "active";
							foreach($querySlideInicio->result() as $slideInicio){
						?>
							<div class="item <?=$active?>">
                            	<img 
                                	src="<?=base_url("assets/img/inicio/slideShow/".$slideInicio->img)?>"
                                    width="100%"
                                    alt=""
								>
							</div>
						<?
							$active = "";
							}
						?>
						</div>
					<!-- Left and right controls -->
						<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
				</div>
			</div>
        </div>
	</div>            
</section>

<!---------- Dennis Castillo [2022-04-16] ----------->
<div class="url" data-url="<?=base_url()?>"></div>
<div class="modal-asistence-time"></div>
<!--------------------------------------------------->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<?php 



if($enc > 0){ ?>  	  
 
  <script language="javascript" type="text/javascript">

eventListeners();
function eventListeners(){
   var idenc = document.getElementById("idenc").value;
  //console.log(idenc);
  if(idenc >0)
  {
    //console.log('encusta');
    $(".myModal").fadeIn();
 }
  
 
} 

/*
  $( document ).ready(function() {
    $('#myModal').modal(backdrop: 'static', keyboard: false);
    $('#myModal').modal(toogle);
  });*/
 
 function enviarFormAjax(formulario,controlador,funcionControlador){
 	 var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}    
  var direccion= <?php echo('"'.base_url().'"');?>+controlador+'/'+funcionControlador;
    Req.open("POST",direccion, true);
  Req.onload = function(Event) {
     console.log(Req.status);
    if (Req.status == 200) {

      var respuesta = JSON.parse(Req.responseText);      
       alert(respuesta);
      $(".myModal").fadeOut(); 
 
  //***
    } else {      }

  };    

  //Enviamos la petición

  Req.send(Data);

}

function CierraPopup() {
$('#cerrar').click(); //Esto simula un click sobre el botón close de la modal, por lo que no se debe preocupar por qué clases agregar o qué clases sacar.
$('.modal-backdrop').remove();//eliminamos el backdrop del modal
}

  </script>
 <?php } ?> 
<?php $this->load->view('footers/footer'); ?>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function(){
    if(document.getElementsByClassName('modal-backdrop fade in')[0]){
    let vent=document.getElementsByClassName('modal-backdrop fade in')[0]
    vent.classList.remove('in');
    vent.classList.remove('modal-backdrop');
    vent.classList.remove('fade');
  }
  if(document.getElementsByClassName('modal-backdrop  in')[0]){
    let vent=document.getElementsByClassName('modal-backdrop  in')[0]
    vent.classList.remove('in');
    vent.classList.remove('modal-backdrop');    
  }
});
</script>



<!--script src="<?=base_url()."assets/react_js/react_modules/bundle_js/bundle-asistenciaypuntualidad.js"?>"></script-->