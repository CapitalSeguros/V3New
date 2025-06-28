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
<?php 
	//$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	//$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="container-fluid breadcrumb-formularios">
	<div class="row">
		<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Actividades</h3></div>
        <div class="col-md-6 col-sm-7 col-xs-7">
			<ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li><a href="<?=base_url()?>actividades" title="Actividades">Actividades</a></li>
                <li class="active">Actividades Agregar</li>
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
                <label for="Estatus">Actividad:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <?
				if($tipoActividad == ""){
		
					if($noCerrados<16 || $usermail='ATENCIONAGENTES@ASESORESCAPITAL.COM'){ //se abre para ashanty

					print_r($SelectActividad);
				   }
				   else
				   {
				   	print_r("<label style='color:red;'>El numero de actividade Maximas no finalizadas en AGENTE GAP es de 15, para crear otras califica y cierra las que esten terminadas</label>");
				   }
				} else {

					print('<input type="text" value="'.$tipoActividad.'" disabled="disabled" class="form-control input-sm" />');
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
			$IDEjecut	= "1"; //-> Bienes[Da�os]
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
			$usuarioResponsable = "COBRANZA@AGENTECAPITAL.COM"; //*
			$tipoActividadSicas = "tarea";
			$TipoDocto	= "";
			$IDUserR	= "38";
			$IDTTarea	= "7";
			require('agregar_pagocobranza.php');
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
?>	</div>
	</div>         
</section>
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
<?php $this->load->view('footers/footer'); ?>
<script >
var evento=CKEDITOR.instances['datosExpres'];evento.on('afterPaste', function (event) {evento.setData('');});

if(document.getElementById("IDPcien")){document.getElementById("tipoRamo").onchange="";document.getElementById("tipoRamo").addEventListener("change",function(){cambia(this.value)});document.getElementById("tipoRamo1").onchange='';document.getElementById("tipoRamo1").addEventListener("change",function(){asignaSubRamoOculto(this)}) }

function asignaSubRamoOculto(objeto){
  //alert(objeto.options[objeto.selectedIndex].text);
  	var numComp=formActividadAgregar_clienteNuevo.length	
	for(i=0;i<numComp;i++){
		if(formActividadAgregar_clienteNuevo[i].id=="tipoSubRamo"){
		formActividadAgregar_clienteNuevo[i].value=objeto.options[objeto.selectedIndex].text;
		}
     if(formActividadAgregar_clienteNuevo[i].id=="IDSRamo"){
			formActividadAgregar_clienteNuevo[i].value=objeto.value;
		}

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

    	for(var i=0;i<datos.length;i++ ){

        var option = document.createElement("option");
        option.text = datos[i].Nombre;
        option.value=datos[i].IDSRamo;
        document.getElementById('tipoRamo1').add(option);
    	}
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