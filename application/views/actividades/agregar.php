<script>
	function SeleccionIdCliente(idCliente, urlActividad){
		window.open(urlActividad+'?idCliente='+idCliente, '_self');
	}
</script>
<?php

	$tipoActividad	= $this->uri->segment(3);
	$tipoRamo		= $this->uri->segment(4);
	$tipoSubRamo	= $this->uri->segment(5);
	$tipoCliente	= $this->uri->segment(6);
	$tipoEntidad	= $this->uri->segment(7);
   /* if($tipoActividad=='Endoso'){
     	if($tipoRamo!='' && $tipoSubRamo!=""){
     		if($tipoCliente==''){
     			$fp=fopen('resultadoJason.txt','a');fwrite($fp,print_r($this->uri->segments,true));fclose($fp);

     		}

     	}
    }*/

   
	if($this->uri->segment(6)=='Existente')
	{
		 $IDPcien   = $this->input->get('clientep', TRUE);
    } else {
		 $IDPcien   = $this->uri->segment(8);
	}


	$tipoAPATERNO   = $this->uri->segment(9);
	$tipoAMATERNO   = $this->uri->segment(10);
	$tipoNOMBRES    = str_replace("_", " ", $this->uri->segment(11)); 
	$tipoCEL        = $this->uri->segment(12);
	$tipoEMAIL      =str_replace("-", "@", $this->uri->segment(13)); 
	$Razon      = $this->uri->segment(14);
  
 
	$TipoEnt		= ($tipoEntidad=="Fisica")?"0":"1";
	$busquedaClienteProspecto = $this->input->get('busquedaClienteProspecto', TRUE);
	$idCliente		= $this->input->get('idCliente', TRUE);
	$idPoliza		= $this->input->get('idPoliza', TRUE);

	if($this->input->get('consultar', TRUE) != ""){
		// Desde Reporte
		//** reportes/verReporte?
		$urlCancelar	= base_url()."reportes/verReporte?";
		$urlCancelar	.= "consultar=".$this->input->get('consultar', TRUE);
		$urlCancelar	.= "&cliente=".$this->input->get('cliente', TRUE);
		$urlCancelar	.= "&ramo=".$this->input->get('ramo', TRUE);
		$urlCancelar	.= "&subramo=".$this->input->get('subramo', TRUE);
		$urlCancelar	.= "&habilitarf=".$this->input->get('habilitarf', TRUE);
		$urlCancelar	.= "&fechaini=".$this->input->get('fechaini', TRUE);
		$urlCancelar	.= "&fechafin=".$this->input->get('fechafin', TRUE);
		$urlCancelar	.= "&poliza=".$this->input->get('poliza', TRUE);
		$urlCancelar	.= "&estatus=".$this->input->get('estatus', TRUE);
		$urlCancelar	.= "&promotor=".$this->input->get('promotor', TRUE);
		$urlCancelar	.= "&vendedor=".$this->input->get('vendedor', TRUE);
		$urlCancelar	.= "&grupo=".$this->input->get('grupo', TRUE);
		$urlCancelar	.= "&subgrupo=".$this->input->get('subgrupo', TRUE);
	} else {
		// Desde Actividad
		$urlCancelar	= base_url()."actividades";
	}
?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./" class="labelResponsivo">Inicio</a></li>
                <li><a class="labelResponsivo" href="<?=base_url()?>actividades" title="Actividades">Actividades</a></li>
                <li class="active labelResponsivo">Actividades Agregar</li>
            </ol>
        </div>
    </div>
        <hr /> 
        <a href="https://www.dropbox.com/sh/3txhtwzoketivnz/AABSWpAhQXuqTpiPfv_rDvGxa/COTIZADORES?dl=0" title="Clic Aqui - Descargar Cotizadores" target="_blank"><b>Cotizadores</b></a>
        

</section>

<section class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

<!-- TipoActividad -->
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
                <label for="Estatus" class="labelResponsivo">Actividad:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
			<?
				if($tipoActividad == ""){
					if($noCerrados<16 || $usermail='ATENCIONAGENTES@ASESORESCAPITAL.COM'){ //se abre para ashanty
						print_r($SelectActividad);
					} else {
						print_r("<label style='color:red;'>El numero de actividade Maximas no finalizadas en AGENTE GAP es de 15, para crear otras califica y cierra las que esten terminadas</label>");
					}
				} else {
					print('<input type="text" value="'.$tipoActividad.'" disabled="disabled" class="form-control input-sm" id="tipoActividadDisabled"/>');
				}
			?>
			</div>
		</div>
<!--* TipoActividad -->


<?
	//$tipoActividadSicas => ot, tarea
	//$TipoDocto => 0:Solicitud, 1:Poliza, 2:Fianza
	//$IDEjecut
	switch($this->uri->segment(5)){
		case "17":
		        if($this->uri->segment(3)=="CapturaRenovacion")
               	{

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "AUTOSRENOVACION@AGENTECAPITAL.COM";
                }
               if($this->uri->segment(3)=="Cotizacion")
               	{

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM";
                }
                if($this->uri->segment(3)!="CapturaRenovacion" && $this->uri->segment(3)!="Cotizacion")
                {

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "AUTOSNUEVOS@AGENTECAPITAL.COM";
                }	

		case "19":
		        if($this->uri->segment(3)=="CapturaRenovacion")
               	{

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "AUTOSRENOVACION@AGENTECAPITAL.COM";
                }
		        if($this->uri->segment(3)=="Cotizacion")
               	{


               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM";
                }
                if($this->uri->segment(3)!="CapturaRenovacion" && $this->uri->segment(3)!="Cotizacion")
                {

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "AUTOSNUEVOS@AGENTECAPITAL.COM";
                }	
		case "21":
		        if($this->uri->segment(3)=="CapturaRenovacion")
               	{

               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "AUTOSRENOVACION@AGENTECAPITAL.COM";
                }
		       if($this->uri->segment(3)=="Cotizacion")
               	{
               	   $IDEjecut	= "2"; //-> Autos Individuales
				   $IDUserR = "15";
                   $usuarioResponsable = "EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM";
                }
                 if($this->uri->segment(3)!="CapturaRenovacion" && $this->uri->segment(3)!="Cotizacion")
                {	
					$IDEjecut	= "2"; //-> Autos Individuales
					$IDUserR = "15";
					//$usuarioResponsable = "15";
					$usuarioResponsable = "AUTOSNUEVOS@AGENTECAPITAL.COM";
				}	
		break;
		
		case "20":
			$IDEjecut	= "1"; //-> Flotillas
			$IDUserR =  "19"; //ERA 17
			//$usuarioResponsable = "17";
			$usuarioResponsable = "BIENES@AGENTECAPITAL.COM";
		break;
		
		case "6":
		case "7":
		case "8":
		case "9":
		case "10":
		case "11":
		case "48":
		
		case "12":
		case "13":
		case "14":
		case "15":
		case "16":
			$IDEjecut	= "3"; //-> Lineas Personales
			//$usuarioResponsable = "16";
			$IDUserR = "16";
			$usuarioResponsable = "LINEASPERSONALES@ASESORESCAPITAL.COM";
		break;
		
		case "31":
		case "25":
		case "28":
		case "30":
		case "34":
		case "37":
		case "52":
			$IDEjecut	= "1"; //-> Bienes[Da?s]
			//$usuarioResponsable = "19";
			$IDUserR = "19";
			$usuarioResponsable = "BIENES@AGENTECAPITAL.COM";
		break;
		
		case "44":
		case "45":
		case "46":
		case "47":
		case "70":
			
			$sqlCalculaUsuarioResponsable = "
				Select
					`usuarioResponsable`
				From
					`actividades`
				Where
					`ramoActividad` = 'FIANZAS'
				Order By
					`idInterno` Desc
				Limit
					0,1
				;
											";
			if(!$this->db->query($sqlCalculaUsuarioResponsable)->row()->usuarioResponsable == 'FIANZAS@AGENTECAPITAL.COM'){
				$usuarioResponsableCalculado = "FIANZAS@AGENTECAPITAL.COM";
			} else {
				$usuarioResponsableCalculado = "FIANZAS1@AGENTECAPITAL.COM";
			}
			$IDEjecut			= "6"; //-> Fianzas
			$IDUserR			= "24";
			$usuarioResponsable	= $usuarioResponsableCalculado;
		break;
	}
	
	if($this->tank_auth->get_uservendedor() == "0"){$IDVend = "7";} 
	else {$IDVend = $this->tank_auth->get_uservendedor();}

	switch($tipoActividad){
		case "Cotizacion": /* 1 */
			$tipoActividadSicas = "ot";
			$TipoDocto	= "0";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_cotizaciones.php');
		break;
		
		case "Emision": /* 2 */
			$tipoActividadSicas = "ot";
			$TipoDocto	= "0";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_emisiones.php');
		break;
		
		case "Diligencias": /* 3 */
			$usuarioResponsable = "GESTIONINTERNA@AGENTECAPITAL.COM"; //*
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "39";
			$IDTTarea	= "1";
			require('agregar_diligencias.php');
		break;
		
		case "CambiodeConducto": /* 4 */
			$tipoActividadSicas = "ot";
			$TipoDocto	= "0";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_cambiodeconducto.php');
		break;
		
		case "Endoso":  /* 5 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "0";
			//$IDUserR	= "";
			$IDTTarea	= "0";
			require('agregar_endoso.php');
		break;
		
		case "Sustitucion": /* New JjHe */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "0";
			//$IDUserR	= "";
			$IDTTarea	= "0";
			require('agregar_sustitucion.php');
		break;
		
		case "Cancelacion":  /* 6 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "0";
			//$IDUserR	= "";
			$IDTTarea	= "0";
			require('agregar_cancelacion.php');
		break;
		
		case "Siniestros":  /* 7 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_siniestro.php');
		break;
		
		case "OtrasActividades": /* 8 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_otrasactividades.php');
		break;
		
		case "AclaraciondeComisiones": /* 9 */
			$usuarioResponsable = "MESADECONTROL@AGENTECAPITAL.COM"; //*
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "9";
			$IDTTarea	= "3";
			require('agregar_aclaraciondecomisiones.php');
		break;
		
		case "SolicituddetarjetasClubCap": /* 10 */
			$usuarioResponsable = "MESADECONTROL@AGENTECAPITAL.COM"; //*
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "9";
			$IDTTarea	= "4";
			require('agregar_solicituddetarjetasclubcap.php');
		break;
		
		case "PagoCobranza": /* 11 */
			$usuarioResponsable = "COBRANZA1@ASESORESCAPITAL.COM"; //*"COBRANZA@AGENTECAPITAL.COM"
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "51";//38
			$IDTTarea	= "7";
			require('agregar_pagocobranza.php');
		break;
		
		case "AplicacionPago": /* New JjHe */
			$usuarioResponsable = "COBRANZA1@ASESORESCAPITAL.COM"; //*"COBRANZA@AGENTECAPITAL.COM"
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "51";//38
			$IDTTarea	= "7";
			require('agregar_aplicacionpago.php');
		break;
		
		case "CapturaEmision": /* 12 */
			$tipoActividadSicas = "ot";
			$TipoDocto	= "0";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_capturaemision.php');
		break;
		
		case "CapturaRenovacion": /* 13 */
			$tipoActividadSicas = "ot";
			$TipoDocto	= "0";
			$IDUserR	= "";
			$IDTTarea	= "1";
			require('agregar_capturarenovacion.php');
		break;
		
		case "CambioFormaPago":  /* 14 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "0";
			//$IDUserR	= "";
			$IDTTarea	= "0";
			require('agregar_cambioformapago.php');
		break;

		case "Fianzas":  /* 14 */
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "0";
			//$IDUserR	= "";
			$IDTTarea	= "0";

			$IDEjecut	= "6"; //-> Fianzas
			//$usuarioResponsable = "24";
			$IDUserR = "24";
			$usuarioResponsable = "FIANZAS@AGENTECAPITAL.COM";
			
			require('agregar_fianzas.php');
		break;
	}
?>	</div>
	</div>         
</section>


<style type="text/css">
	.verElemento{display: block;}
	.ocultarElemento{display: none;}
	.form-group {margin-bottom: 1rem;}
	.row {align-items: center;}
	/*Texts*/
    	.textForm {font-size: 12px;color: #3d3d3d;}
    	.labelResponsivo {margin-bottom: 0px;}
    	.textSizeLabel {font-size: 13px;}
	/*Others*/
		.pd-left {padding-left: 0px;}
		.pd-right {padding-right: 0px;}
		.pd-top {padding-top: 15px;}
		.pd-bottom {padding-bottom: 15px;}
    	.pd-items-table {padding-bottom: 5px;}
    	.pd-items-table-top {padding-top: 5px;}
    	.mg-top {margin-top: 5px;}
    	.mg-bottom {margin-bottom: 5px;}
    	.mg-left {margin-left: 5px;}
		.mg-right {margin-right: 5px;}
    	.mg-cero {margin: 0px;}
    	.mg-top-cero {margin-top: 0px;}
    	.mg-bottom-cero {margin-bottom: 0px;}
    	.mg-left-cero {margin-left: 0px;}
    	.mg-right-cero {margin-right: 0px;}
		.pd-side {padding-left: 5px;padding-right: 5px;}
    	.pd-side-alt {padding-left: 15px;padding-right: 15px;}
	/*Checkbox | Radio*/
    	.form-check-input {
    	  	width: 25px;
    	  	height: 25px;
    	  	margin-top: .25em;
    	  	vertical-align: top;
    	  	background-color: #fff;
    	  	background-repeat: no-repeat;
    	  	background-position: center;
    	  	background-size: contain;
    	  	border: 1px solid rgba(0,0,0,.25);
    	  	-webkit-appearance: none;
    	  	-moz-appearance: none;
    	  	appearance: none;
    	  	-webkit-print-color-adjust: exact;
    	  	color-adjust: exact;
    	  	print-color-adjust: exact;
    	  	position: inherit;
    	}
    	input.form-check-input[type=checkbox] {
    	    border-radius: .5em;
    	    cursor: pointer;
    	    margin: 0px 5px;
    	    outline: 0;
    	}
    	input.form-check-input[type=radio] {
    	  	border-radius: 50%;
    	  	cursor: pointer;
    	  	margin: 0px 0 0;
    	  	margin-top: 1px \9;
    	  	line-height: normal;
    	  	outline: 0;
    	}
    	.form-check .form-check-input {
    	    float: left;
    	}
    	.form-check-input:active{
    	  	filter:brightness(90%);
    	}
    	.form-check-input:focus{
    	  	border-color:#86b7fe;
    	  	outline:0;
    	  	box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    	}
    	.form-check-input:disabled {
    	  	pointer-events: none;
    	  	filter: none;
    	  	opacity: .5;
    	}
    	.form-check-input:checked{
    	  	background-color:#0d6efd;
    	  	border-color:#0d6efd;
    	}
    	.form-check-input:checked[type=checkbox]{
    	  	background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    	}
    	.form-check-input:checked[type=radio] {
    	  	background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e");
    	}
    	.form-check-input:disabled~.form-check-label, .form-check-input[disabled]~.form-check-label {
    	    color: #3d3d3d; /*#6c757d*/
    	}
    	@media (min-width: 992px) {
    		.form-check-input {width: 25px;height: 25px;}
    		.col-md-3.pd-items-table {max-width: 20%;}
    	}
    	@media (min-width: 768px) {
    		.col-md-3.pd-items-table {max-width: 25%;}
    		.form-check-input {width: 25px;height: 25px;}
    	}
</style>

	<script>
		$(function(){
			$('#fecha_nacimiento').datepicker({
				format: 'yyyy-mm-dd'
			});			
		});
		$(function(){
			$('#fecha_constitucion').datepicker({
				format: 'yyyy-mm-dd'
			});			
		});
    </script>
<?php //$this->load->view('footers/footer'); ?>
<script >

	var objectRedimensionar="tipoActividad.tipoRamo.tipoRamo1.tipoCliente.tipoEntidad.Sexo.fecha_nacimiento.ApellidoP.ApellidoM.Nombre.Telefono1.EMail1.IDVend.fecha_constitucion.busquedaClienteProspecto.IDCli.buttonBuscar.btnBuscarOtro.tipoActividadDisabled.buscarOtroClient.escogerClient.clienteEscogido.actividadUrgente.cancelarActividad.guardarActividad.btnBuscaClient.guardarForm.selectEndoso.IDPcien.numeroImpresoCaptura.";
window.addEventListener("resize",redimensionar);
redimensionar();

function redimensionar(){
  var arrayObjetos=objectRedimensionar.split('.');var w = window.outerWidth;var h = window.outerHeight;
  var cantidadParametros=arrayObjetos.length;
  
if(w<600)
{
	for(var i=0;i<cantidadParametros;i++)
	{	
	  if(document.getElementById(arrayObjetos[i]))
	  {
	    document.getElementById(arrayObjetos[i]).style.height = "80px";    	
         document.getElementById(arrayObjetos[i]).style.fontSize="36px";
       
      
         if(arrayObjetos[i]==="actividadUrgente"){
            document.getElementById(arrayObjetos[i]).style.width = "80px";
          }
  
       }
     }
             var lResponsivo=document.getElementsByClassName('labelResponsivo');
          var cant_lResponsivo=document.getElementsByClassName('labelResponsivo').length;
          for(var j=0;j<cant_lResponsivo;j++)
          {
          	document.getElementsByClassName('labelResponsivo')[j].style.fontSize="25px";
          }
 }
 else
 {
   if(w>601 && w<700)
   {
      for(var i=0;i<cantidadParametros;i++)
     {	
	   if(document.getElementById(arrayObjetos[i]))
	  {
	  	
	    document.getElementById(arrayObjetos[i]).style.height = "50px";    	
        document.getElementById(arrayObjetos[i]).style.fontSize="24px";
       
                if(arrayObjetos[i]==="actividadUrgente"){
            document.getElementById(arrayObjetos[i]).style.width = "50px";
           
          }
        
       }
                var lResponsivo=document.getElementsByClassName('labelResponsivo');
          var cant_lResponsivo=document.getElementsByClassName('labelResponsivo').length;
          for(var j=0;j<cant_lResponsivo;j++){
          	document.getElementsByClassName('labelResponsivo')[j].style.fontSize="15px";
          }
     
       } 

    }
  else
  {
    for(var i=0;i<cantidadParametros;i++)
    {	
	  if(document.getElementById(arrayObjetos[i]))
	  {
	  	if(arrayObjetos[i]!="IDCli"){
       document.getElementById(arrayObjetos[i]).style.height = "30px";    	
         document.getElementById(arrayObjetos[i]).style.fontSize="12px";
          }
          else{
          	document.getElementById(arrayObjetos[i]).style.fontSize="12px";
          }
                      if(arrayObjetos[i]==="actividadUrgente"){
            document.getElementById(arrayObjetos[i]).style.width = "20px";
          }

      }
     }
            var lResponsivo=document.getElementsByClassName('labelResponsivo');
          var cant_lResponsivo=document.getElementsByClassName('labelResponsivo').length;
          //document.getElementById(arrayObjetos[i]).style.width = "20px";
         for(var j=0;j<cant_lResponsivo;j++){
          	document.getElementsByClassName('labelResponsivo')[j].style.fontSize="10px";
          }
    }
   }

 }



var evento=CKEDITOR.instances['datosExpres'];evento.on('afterPaste', function (event) {evento.setData('');});

if(document.getElementById("IDPcien") || document.getElementById("idCotizaDirectorio")){document.getElementById("tipoRamo").onchange="";document.getElementById("tipoRamo").addEventListener("change",function(){cambia(this.value)});document.getElementById("tipoRamo1").onchange='';document.getElementById("tipoRamo1").addEventListener("change",function(){asignaSubRamoOculto(this,'')}) }

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
    	if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);
         switch(funcion){
         	case 'asignaSubRamoOculto':asignaSubRamoOculto('',respuesta);break;

         }                                                           
      }     
   }
  };
 req.send();
}
function asignaSubRamoOculto(objeto,datos){
  //alert(objeto.options[objeto.selectedIndex].text);
  if(datos==''){

  	var numComp=formActividadAgregar_clienteNuevo.length	
	for(i=0;i<numComp;i++){
		if(formActividadAgregar_clienteNuevo[i].id=="tipoSubRamo"){
		formActividadAgregar_clienteNuevo[i].value=objeto.options[objeto.selectedIndex].text;
		}
     if(formActividadAgregar_clienteNuevo[i].id=="IDSRamo"){
			formActividadAgregar_clienteNuevo[i].value=objeto.value;
		}

	}
	   var parametros="?";    
	     parametros=parametros+'idSubRamo='+objeto.value;	     
	     peticionAJAX('actividades/traeCompaniaPorSubRamo/',parametros,'asignaSubRamoOculto');
  }
  else{
  
  	var opciones="";
  	            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<label class="labelResponsivo" style="border:solid 1px black">'+datos.companias[i].Promotoria+'<input type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="form-control input-sm cbCompania" value="'+datos.companias[i].idPromotoria+'"></label>';
                }
                
                    	if(document.getElementById("divEleccionCompania")){
    	document.getElementById("divEleccionCompania").innerHTML=opciones;}
  }
}
function cambia(valor){
	var actividad=document.getElementById('tipoActividad').value;
	tipoRamo.value=actividad;
	


//alert(valor);
$.ajax({method: "POST",data: {"ramo" :valor,"actividad" : actividad}, url: "<?php echo base_url()?>actividades/traeSubRamo/",dataType: "html",
       success : function(data)
    {var datos=JSON.parse(data);
    	   for(t=0;t<document.getElementById('tipoRamo1').length;){
   	document.getElementById('tipoRamo1').remove(t);
   }

     var option = document.createElement("option");
        option.text ="--Seleccione--";
        option.value="";
        document.getElementById('tipoRamo1').add(option);   

    	for(var i=0;i<datos.subRamos.length;i++ ){

        var option = document.createElement("option");
        option.text = datos.subRamos[i].Nombre;
        option.value=datos.subRamos[i].IDSRamo;
        document.getElementById('tipoRamo1').add(option);

    	}
    	if(document.getElementById("divEleccionCompania")){
    	document.getElementById("divEleccionCompania").innerHTML="";}
    }});

	var numComp=formActividadAgregar_clienteNuevo.length
	for(i=0;i<numComp;i++){
		if(formActividadAgregar_clienteNuevo[i].id=="tipoRamo"){
			formActividadAgregar_clienteNuevo[i].value=valor;
		}
				if(formActividadAgregar_clienteNuevo[i].id=="tipoSubRamo"){
		formActividadAgregar_clienteNuevo[i].value="";
		}
     if(formActividadAgregar_clienteNuevo[i].id=="IDSRamo"){
			formActividadAgregar_clienteNuevo[i].value="";
		}


	}
}
	
</script>
<script type="text/javascript">
	
//window.open(urlActividad+'?idCliente='+idCliente, '_self');
<?php
    if($tipoActividad=='Endoso' || $tipoActividad=='Cancelacion' || $tipoActividad=='AclaraciondeComisiones' || $tipoActividad=='AplicacionPago'){
     	if($tipoRamo!='' && $tipoSubRamo!=""){
     		if($tipoCliente==''){
     			
     			//echo('window.open("'.base_url().'?idCliente='.$this->input->get('idCliente', TRUE).'","_self")');
     				$cadena='if(document.getElementById("tipoCliente")){document.getElementById("tipoCliente").style.display="none";};';
     			echo($cadena);
     			echo('selectTipoCliente("'.$tipoActividad.'","'.$tipoRamo.'","'.$tipoSubRamo.'","Existente");');
     		
     		}

     	}
    }

?>
<? if($this->input->get('tipoEndoso', TRUE)!='')
 {?>
	if(document.getElementById("tipoEndoso"))
    {document.getElementById("tipoEndoso").value="<?=$this->input->get('tipoEndoso', TRUE)?>";
      selecTipoEndoso(document.getElementById("tipoEndoso").value);
    };    
<?}?>

<? if($this->input->get('documento', TRUE)!='')
{?>
    if(document.getElementById('selectEndoso'))
    {
    	document.getElementById('selectEndoso').value="<?=$this->input->get('documento', TRUE)?>";
    	asignaPolzai(document.getElementById('selectEndoso').value);
    }
	
<?}?>

<? if($this->input->get('idvend', TRUE)!='')
{?>
    if(document.getElementById('IDVend'))
    {
    	document.getElementById('IDVend').value="<?=$this->input->get('idvend', TRUE)?>";
    	
    }
	
<?}?>

<? if($this->input->get('fpago', TRUE)!='')
{
    if($this->input->get('tipoEndoso', TRUE)=='B' || $this->input->get('tipoEndoso', TRUE)=='D'){
	?>
    if(document.getElementById('selectNuevaFormaPago'))
    {
    	document.getElementById('selectNuevaFormaPago').value="<?=$this->input->get('fpago', TRUE)?>";
    	
    }
	    if(document.getElementById('hiddenAntiguaFormaPago'))
    {
    	document.getElementById('hiddenAntiguaFormaPago').value="<?=$this->input->get('fpago', TRUE)?>";
    	
    }
<?}}?>


function filtrarSelectVendedor(valor)
{
	  var busqueda=document.getElementById('IDVend');
  var filtro=valor.toUpperCase();
  var contador=busqueda.length;var text="";
  for(var j=1;j<contador;j++)
    {text=busqueda[j].innerHTML;
      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarElemento');}
      else{ busqueda[j].classList.add('ocultarElemento'); busqueda[j].classList.remove('verElemento');}}

}
function borrarArchivo(objeto)
{
	let padre=objeto.parentNode.parentNode.parentNode;
	padre.removeChild(objeto.parentNode.parentNode);
}
function crearArchivoEnvio(e)
{  console.log('llega')
   e.preventDefault();
	if(tipoImg_0.value==''){alert('Necesita escoger un tipo de archivo')}
	else
	{
	 var combo = document.getElementById("tipoImg_0");
     var selected = combo.options[combo.selectedIndex].text;
     objeto='file'+selected;
      if(!document.getElementById(objeto))
      {
	 var combo = document.getElementById("tipoImg_0");
     var selected = combo.options[combo.selectedIndex].text;
     var valueSelect=combo.options[combo.selectedIndex].value;
     let objeto='file'+selected;
     let nombreObjeto=valueSelect;
      if(!document.getElementById(objeto))
      {
      	let divPadre=document.createElement('div');
      	let divFile=document.createElement('div');
      	let divLabel=document.createElement('div');      	
      	let divBoton=document.createElement('div')
      	divPadre.classList.add('row');
      	divLabel.classList.add('col-md-2');
      	divLabel.classList.add('col-sm-2');
      	divFile.classList.add('col-md-8')
      	divFile.classList.add('col-sm-8')
	   	divBoton.classList.add('col-md-2');
      	divBoton.classList.add('col-sm-2');

      	let boton=document.createElement('button');
      	boton.innerHTML='&#10060;';
        boton.setAttribute('style','background-color:white')
        boton.setAttribute('onclick','borrarArchivo(this)');
	    let input=document.createElement('input');
	    input.type='file';
	    input.name=nombreObjeto;
	    input.id=objeto;
	    input.classList.add('form-control');
	    let label=document.createElement('label');
	    label.innerHTML=selected+':';
	    label.classList.add('form-label');
	    label.setAttribute('for',objeto)
	    divFile.append(input);
	    divLabel.append(label);	    
	    divBoton.append(boton);	   
	    divPadre.append(divLabel);
	    divPadre.append(divFile);
        divPadre.append(divBoton);
	    divContenedorArchivos.append(divPadre);

	  }
	  
     }
    else{alert('Ya existe un componente para cargar este archivo')}
}
}
</script>
<style type="text/css">
.verElemento{display: block;}
.ocultarElemento{display: none;}	

</style>
<?
function imprimirTipoDocumentos($array)
{
	$select='<select name="tipoImg_0" id="tipoImg_0" class="form-control input-sm"><option value="">-- Seleccione --</option>';
    foreach ($array as  $value) {$select.='<option value="'.$value->idTipoImg.'">'.$value->nombre.'</option>';}
	$select.='</select>';
	return $select;
}

?>
<script type="text/javascript">
	if(document.getElementById('tipoCliente')){
		document.getElementById('tipoCliente').parentNode.parentNode.setAttribute('style','display:none');
		if(document.getElementById('tipoCliente').value=='')
		{<?echo('selectTipoCliente("'.$tipoActividad.'","'.$tipoRamo.'","'.$tipoSubRamo.'","Existente");');?>}}
</script>
<style type="text/css">
	#selectEndoso{min-height: 54px}
	input,select,textarea{border:solid;}

</style>