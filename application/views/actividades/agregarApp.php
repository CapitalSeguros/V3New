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
<!DOCTYPE html>
<html lang="es">
<script>
function mensaje(){
    alert("Esta póliza no corresponde a tu sesión");

    }
</script>
<? $this->load->view("headers/app/main_header") ?>

<body>
<!-- Page container -->
<div class="page-container">

	<? $this->load->view("headers/app/page_sidebar") ?>
  
	<!-- Main container -->
	<div class="main-container gray-bg">
  
		<!-- Main header -->
		<div class="main-header row">
			<div class="col-sm-6 col-xs-7">
			<? $this->load->view("headers/app/user_info") ?>
			</div>
			
			<div class="col-sm-6 col-xs-5">
			<div class="pull-right">
			<? $this->load->view("headers/app/user_alerts") ?>
			</div>
			</div>
		</div>
		<!-- /main header -->
		
		<!-- Main content -->
		<div class="main-content">
        
			<h1 class="page-title">Actividades</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="<?= base_url();?>"><i class="fa fa-home"></i>Home</a></li> 
				<li>Actividades</li>
				<li class="active"><strong>Crear</strong></li>
			</ol>

			<div class="row">
				<div class="col-lg-12">
					<!-- <div class="panel panel-default"> -->
					<div class="panel panel-default">
						<!-- panel heading -->
						<div class="panel-heading clearfix">
							<div class="row" style="padding-bottom:5px;"><!-- Botones de Accion General -->
								<div class="col-sm-12 col-md-12" align="right">
									<!--
                                    <input
										type="button" value="Regresar" 
										title="Clic"
										onclick="window.open('<?=base_url()?>actividades','_self');"
										class="btn btn-primary btn-sm"
									/>
                                    -->
								</div>
							</div>

						</div><!-- /panel-heading -->

						<!-- panel body -->
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
			$IDEjecut	= "6"; //-> Fianzas
			//$usuarioResponsable = "24";
			$IDUserR = "24";
			$usuarioResponsable = "FIANZAS@AGENTECAPITAL.COM";			
		break;
	}
	if($this->tank_auth->get_uservendedor() == "0"){
		$IDVend = "7";
	} else {
		$IDVend = $this->tank_auth->get_uservendedor();
	}

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
	}
?>
						</div><!-- /panel-body -->
					</div>
                        
				</div>
			</div>
            
		<? $this->load->view("footers/app/div_footer-main") ?>
		
	  </div>
	  <!-- /main content -->
	  
  </div>
  <!-- /main container -->
  
</div>
<!-- /page container -->

<? $this->load->view("footers/app/main_footer") ?>

</body>
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

if(document.getElementById("IDPcien")){document.getElementById("tipoRamo").onchange="";document.getElementById("tipoRamo").addEventListener("change",function(){cambia(this.value)});document.getElementById("tipoRamo1").onchange='';document.getElementById("tipoRamo1").addEventListener("change",function(){asignaSubRamoOculto(this,'')}) }

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
</html>