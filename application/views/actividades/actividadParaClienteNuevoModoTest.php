<script type="text/javascript">
  /*alert(screen.width*window.devicePixelRatio)*/ //ANCHURA DISPONIBLE
  //alert(screen.width)    // OBTENER EL ANCHO DE LA PANTALLA
  //alert(window.screen.availHeight)
</script>
    <script>
      var esDispositivoMovil=false;
        let navegador = navigator.userAgent;
        if (navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i)) {
          esDispositivoMovil=true;
        } 
    </script>
<?php $this->load->view('headers/menu');?>
<form id="formActividades" method="post" action="" onsubmit="cancelarSubmit(event)" style="width: 100%">
<div class="contenedorReqActividades">
  <div class="elementosReqActividades"><label>Tipo Actividad</label><div><select id="tipoActividad" name="tipoActividad" onchange="opcionesActividad()"><option value="Cotizacion">Cotizacion</option><option value="Emision">Emision</option><option value="CapturaEmision">Captura Emision</option><option value="CambiodeConducto">Cambio de Conducto</option></select></div></div>
  <div class="elementosReqActividades componenteFlex"><label>Ramo</label><div><select id="selectRamo" name="tipoRamo" onchange="devolverSubRamos('')" ><?=imprimirRamos($ramos);?></select></div></div>
  <div class="elementosReqActividades"><label>Sub Ramo</label><div><select id="selectSubRamo" name="IDSRamo" onchange="obtenerCompaniaPorSubRamo('')"></select></div></div>
  <div class="ocultarElemento subRamoVehiculo"><label>Tipo de carga</label><div><select  name="tipiCarga" ><option>Carga A</option><option>Carga B</option><option>Carga C</option></select></div></div>
  <div class="elementosReqActividades"><label>Cliente</label><div><input type="text"  value="Nuevo" name="tipoCliente" disabled="true"></div></div>
  <div class="elementosReqActividades"><label>Tipo Entidad:</label><div><select id="selectRazon" name="entidad" onchange="escogerTipoEntidad()"><option></option><option value="Fisica">Fisica</option><option value="Moral">Moral</option></select></div></div>
 <div class="elementosReqActividades"><label>Enlace prospeccion</label><div><input type="text" id="enlaceProyecto100" name="idProyecto100" value="" disabled="true"></div></div>
<div class="elementosReqActividades razonMoral"><label>Fecha Constitucion:</label><div><input type="date" name="fechaConstitucion" id="fechaConstitucion"></div></div>
<div class="elementosReqActividades razonMoral"><label>Razon Social:</label><div><input type="text"id="textRazonSocial" name="razonSocial" ></div></div>
  <div class="elementosReqActividades razonFisica"><label>Sexo:</label><div><select name="Sexo" id="selectSexo"><option></option><option value="0">Masculino</option><option value="1">Femenino</option></select></div></div>
  <div class="elementosReqActividades  razonFisica"><label>Fecha Nacimiento:</label><div><input type="date" name="fecha_nacimiento" id="fecha_nacimiento"></div></div>
<div class="elementosReqActividades  razonFisica"><label>Apellido Paterno:</label><div><input type="text" id="textApellidoPaterno" name="ApellidoP" ></div></div>
<div class="elementosReqActividades  razonFisica"><label>Apellido Materno:</label><div><input type="text" id="textApellidoMaterno" name="ApellidoM"></div></div>
<div class="elementosReqActividades  razonFisica"><label>Nombres:</label><div><input type="text"  id="textNombres" name="Nombre" value="" ></div></div>

<div class="elementosReqActividades"><label>Estado:</label><div><select name="estado"><?=imprimirEstados($estados);?></select></div></div>
<div class="elementosReqActividades"><label>Giro:</label><div><select id='giroCliente' name="giroCliente"><?=imprimirGiros($giroCatalogo);?></select><button id="btnGiroCliente" class="btn btn-primary" onclick="abrirModal(event)">+</button></div></div>
<div class="elementosReqActividades"><label>Actividad:</label><div><input type="text" name="giroActividad" value="" ></div></div>
<div class="elementosReqActividades"><label>Celular:</label><div><input type="text" id="textCelular" name="celular" ></div></div>
<div class="elementosReqActividades"><label>Email:</label><div><input type="text" id="textEmail" name="EMail1" ></div></div>
<div class="elementosReqActividades datosParaEmision"><label>Preferencia de comunicacion:</label><div><select name="preferenciaComunicacion" ><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option></select></div></div>
<div class="elementosReqActividades datosParaEmision"><label>Preferencia de Horario:</label><div><select name="horarioComunicacion"><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option></select></div></div>
<div class="elementosReqActividades datosParaEmision"><label>Dias de Contacto:</label><div><select name="diaComunicacion"><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option></select></div></div>
<div class="elementosReqActividades datosParaEmision"><label>Forma de pago:</label><div><select id="pagoFormas" name="pagoFormas" ><option value="">-- Seleccione --</option>                <option value="1">Anual</option>
                              <option value="2">Semestral</option>
                              <option value="3">Trimestral</option>
                              <option value="4">Mensual</option>
              </select></div></div>
<div class="elementosReqActividades datosParaEmision"><label>Conducto de Pago:</label><div><select id="pagoConducto" name="pagoConducto" onchange="cambiarConducto(this.value)"  ><option value="">-- Seleccione --</option>                <option value="1">Transferencia</option>
                              <option value="2">Cheque</option>
                              <option value="3">Tarjeta de Credito</option>
                              <option value="4">Tarjeta de debito</option>
              </select></div></div>



 <div class="elementosReqActividades datosParaEmision">
  <label>Datos Tarjeta:</label>
       <div>
          <div>
                    <div>
                        <div><label>Número de tarjeta</label></div>                        
                        <div><input type="text" id="numeroTarjeta" name="numeroTarjeta"  placeholder="Ingrese los 16 dígitos de la tarjeta"></div>
                    </div>
                    <div>
                        <div><label>Vencimiento</label></div>
                        <div>                        
                        <select id="mesTarjeta" name="mesTarjeta">
                            <option value="">Mes</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                        </select>
                      </div>
                    </div>
                    <div>
                    	<div><label>Año</label></div>
                      <div>
                        <select id="yearTarjeta" name="yearTarjeta">
                            <option value="">Año</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option>
                        </select>
                      </div>
                    </div>
                    <div>
                        <div><label>Código de Seguridad</label></div>
                        <div><input type="text" id="ccv" name="ccv" ></div>
                    </div>
                </div>



                <div >
                    <div>
                        <div><label>Titular de la tarjeta</label></div>
                        
                        <div><input type="text" id="titularTarjeta" name="titularTarjeta" class="datosTarjeta" placeholder="Como aparece en la tarjeta"></div>
                    </div>
                    <div>
                        <div><label>Tipo tarjeta</label></div>
                        
                        <div><select id="tipoTarjeta" name="tipoTarjeta" class="datosTarjeta">
                            <option value="Visa">Visa</option>
                            <option value="Master Card">Master Card</option>
                        </select>
                      </div>
                    </div>
                    <div>
                        <div><label>Banco</label></div>
                        
                        <div><input type="text" id="bancoTarjeta" name="bancoTarjeta" class="datosTarjeta" placeholder="Banco emisor"></div>
                    </div>
                    <div>
                        <div><label>Tipo de pago aplicación</label></div>
                        <div>
                        <select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="datosTarjeta">
                            <option value="Un solo cargo">Un solo cargo</option>
                            <option value="Domiciliada">Domiciliada</option>
                            <option value="Meses sin intereses">Meses sin intereses</option>
                        </select>
                      </div>
                    </div>
                </div></div></div>
<div class="elementosReqActividades"><label name="removerClass">Vendedor:</label><div><?=$SelectVendedor?></div></div>
<div class="elementosReqActividades"><label id="promotoriaLabel">Promotorias:</label><div id="divEleccionCompania"></div></div>
<div class="elementosReqActividades"><label>Comentarios:</label><div><textarea name="datosExpres" id="datosExpres" rows="10" cols="40" placeholder="Escribe aquí tus comentarios" onpaste="return false"></textarea></div></div>
<div class="elementosReqActividades"><label>Cotizacion Urgente!!!</label><div><input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" style="height: 30px; font-size: 12px; width: 20px;"></div></div>
<div class="elementosReqActividadesHorizontal"><div id="divOpciones"><button class="btn btn-danger" onclick="window.location.href='<?=base_url()?>actividades'">Cancelar</button></div><div><button class="btn btn-primary">Guardar</button></div></div>
</div>	

<input type="hidden" name="textRFC" id="textRFC">	
<input type="hidden" name="IDCliClienteActualiza" id="IDCliClienteActualiza">			
</form>
    <div id="miModalGenerico" class="modalCierraGenerico" ><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  ><div class="contenidoModal"><div><button onclick="cerrarModal()" class="botonCierre">X</button></div><div><label>Nuevo giro:<input type="text" id="inputNuevoGiro" class="form-control input-sm"></label></div><div><button onclick="grabaNuevoGiro(null)">Guardar</button></div></div></div></div>

    <div id="miModalCD" class="modalCierraGenerico" ><div id="ModalcontenidoCD" class="modal-contenidoGenerico"  ><div><img src="<?=base_url()?>assets/img/loading.gif"></div></div></div>

<script type="text/javascript">


function cancelarSubmit(e)
{
 e.preventDefault();
 guardarActividad(''); 
}
function guardarActividad(datos)
{
 if(datos=='')
 {
  guardarFormAjax('formActividades','guardarActividad','guardarActividad')
 }
 else
 {
  if(datos.exito!=false)
  {
    window.location.replace("<?=base_url()?>actividades/ver/"+datos.folioActividad);
  }
  else
  { 
  	alert(datos.mensaje);
 	  
  	document.getElementById(datos.idObjeto).focus();  	  
  }
 }
}
function guardarFormAjax(formulario,controlador,funcion){
  
   
    var Data = new FormData(document.getElementById(formulario));  
  if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
  else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}
  var direccion= <?php echo('"'.base_url().'actividades/"');?>+funcion;
  Req.open("POST",direccion, true);  
   document.getElementById("miModalCD").classList.remove("modalCierraGenerico");document.getElementById("miModalCD").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoCD").classList.add("verObjeto");document.getElementById("ModalcontenidoCD").classList.remove("ocultarObjeto");
 
  Req.onload = function(Event) {  
    if (Req.status == 200) 
    {
      var st = JSON.parse(Req.responseText);      
               document.getElementById("miModalCD").classList.add("modalCierraGenerico");
         document.getElementById("miModalCD").classList.remove("modalAbreGenerico");
         document.getElementById("ModalcontenidoCD").classList.remove("verObjeto");
         document.getElementById("ModalcontenidoCD").classList.add("ocultarObjeto");
 
       window[funcion](st);
      if(st.success){}
      else{}
    } 
    else 
    { 
      if(Req.status==500)
      {
       alert('El proceso presento un error favor de notificar a sistemas error 006');                                 
               document.getElementById("miModalCD").classList.add("modalCierraGenerico");
         document.getElementById("miModalCD").classList.remove("modalAbreGenerico");
         document.getElementById("ModalcontenidoCD").classList.remove("verObjeto");
         document.getElementById("ModalcontenidoCD").classList.add("ocultarObjeto");
 
      }
      
    }
  };      
  Req.send(Data);
}
function opcionesActividad()
{
 let opcionesActividad=Array.from(document.getElementsByClassName('datosParaEmision'));
 document.getElementById("divEleccionCompania").innerHTML='';
 obtenerCompaniaPorSubRamo('');
 if(document.getElementById('tipoActividad').value=="Cotizacion" || document.getElementById('tipoActividad').value=="CapturaEmision" || document.getElementById('tipoActividad').value=='CambiodeConducto')
 {
 	opcionesActividad.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
 }
 else
 {
 	opcionesActividad.forEach(e=>{e.classList.remove('ocultarElemento');e.classList.add('elementosReqActividades')})
 }
}
function escogerTipoEntidad()
{
   let fisica=Array.from(document.getElementsByClassName('razonFisica'));
   let moral=Array.from(document.getElementsByClassName('razonMoral'));
   switch(document.getElementById('selectRazon').value)
   {
   	case 'Moral':
   	  moral.forEach(e=>{e.classList.remove('ocultarElemento');e.classList.add('elementosReqActividades')})
   	  fisica.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
   	break;
   	case 'Fisica':
   		  moral.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
   	      fisica.forEach(e=>{e.classList.remove('ocultarElemento');e.classList.add('elementosReqActividades')})
   
   	break;
   	default:
   		  moral.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
   	  fisica.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
   
   	break;
   }
}
function obtenerCompaniaPorSubRamo(datos){  
  if(datos=='')
  {
        
    let params='idSubRamo='+document.getElementById('selectSubRamo').value;	     
    peticionAJAX('actividades/obtenerCompaniaPorSubRamo/',params,'obtenerCompaniaPorSubRamo');
  }
  else{
    let opciones="";
    let textoTitulo="Promotorias";
  switch(document.getElementById('tipoActividad').value)
  {
    case 'Cotizacion': 
            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<div><div><label>'+datos.companias[i].Promotoria+'</label></div><div><input type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="cbCompania" value="'+datos.companias[i].idPromotoria+'"></div></div>';
                }
    break;
    case 'Emision': 
             opciones='<select id="selectCompania" name="selectCompania"><option value> --SELECCIONE COMPANIA--</option>';
  	            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<option value="'+datos.companias[i].idPromotoria+'">'+datos.companias[i].Promotoria+'</option>';
                }
                opciones+='</select>';
    break;
    case 'CapturaEmision': 
       textoTitulo="Poliza Captura Emision:";
       opciones=`<input id="polizaNew" placeholder="Escriba Aqui el Numero Impreso en la Poliza que Esta Enviando a Captura (Obligatorio)" type="text" name="polizaNew">`
    break;
    case 'CambiodeConducto':
           textoTitulo="";
       opciones="";
    break;
    default: break;
  }
  if(document.getElementById("promotoriaLabel")){document.getElementById("promotoriaLabel").innerHTML=textoTitulo;}
  if(document.getElementById("divEleccionCompania")){document.getElementById("divEleccionCompania").innerHTML=opciones;}
  /* if(document.getElementById('tipoActividad').value=='Cotizacion')
    {
  	   var opciones="";
  	            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<div><label>'+datos.companias[i].Promotoria+'<input type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="form-control input-sm cbCompania" value="'+datos.companias[i].idPromotoria+'"></label></div>';
                }
                
                    	if(document.getElementById("divEleccionCompania")){document.getElementById("divEleccionCompania").innerHTML=opciones;}
    }
    else
    {
    	  var opciones='<select id="selectCompania" name="selectCompania"><option value> --SELECCIONE COMPANIA--</option>';
  	            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<option value="'+datos.companias[i].idPromotoria+'">'+datos.companias[i].Promotoria+'</option>';
                }
                
                    	if(document.getElementById("divEleccionCompania")){document.getElementById("divEleccionCompania").innerHTML=opciones;}

    }*/
  }
}

function devolverSubRamos(datos)
{
	
	if(datos=='')
	{
        let params = 'ramo='+document.getElementById('selectRamo').value;    	       	   
        controlador="actividades/devolverSubRamos/?";          
        peticionAJAX(controlador,params,'devolverSubRamos');
	}
	else
	{
		let option='';
		if(datos.subRamos.length>0){option=`<option value="">---SELECCIONE UN SUBRAMO----</option>`;}
     datos.subRamos.forEach(valor=>{option+=`<option value="${valor.IDSRamo}">${valor.Nombre}</option>`;});
       document.getElementById('selectSubRamo').innerHTML=option;
       document.getElementById("divEleccionCompania").innerHTML='';

}

let opcionesActividad=Array.from(document.getElementsByClassName('subRamoVehiculo'));
if(document.getElementById('selectRamo').value=='VEHICULOS')
 {
 	//opcionesActividad.forEach(e=>{e.classList.remove('ocultarElemento');e.classList.add('elementosReqActividades')})
 }
 else
 {
 	//opcionesActividad.forEach(e=>{e.classList.add('ocultarElemento');e.classList.remove('elementosReqActividades')})
 }






}
function grabaNuevoGiro(procesoDatos)
{    
  if(procesoDatos==null)
  {
    var datos='';
    if(document.getElementById('inputNuevoGiro').value!='')
    {  
        let params = 'giro='+document.getElementById('inputNuevoGiro').value;    	       	   
        controlador="actividades/nuevoGiro/?";
        peticionAJAX(controlador,params,'grabaNuevoGiro');
    	
    }
    else{alert('Nombre del Nuevo giro');}
  }
   else{
    var total=procesoDatos.catalogo.length;
    var opciones="";
     for(var i=0;i<total;i++){
        if(procesoDatos.catalogo[i].idGiro==procesoDatos.activo){
      opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'" selected>'+procesoDatos.catalogo[i].giro+'</option>'
        }else{
        opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'">'+procesoDatos.catalogo[i].giro+'</option>';}      
     }
     document.getElementById('giroCliente').innerHTML=opciones;
     cerrarModal();
   }
}	
function peticionAJAX(controlador,parametros,funcion)
{
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  document.getElementById("miModalCD").classList.remove("modalCierraGenerico");document.getElementById("miModalCD").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoCD").classList.add("verObjeto");document.getElementById("ModalcontenidoCD").classList.remove("ocultarObjeto");
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) 
    {
    	
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         document.getElementById("miModalCD").classList.add("modalCierraGenerico");
         document.getElementById("miModalCD").classList.remove("modalAbreGenerico");
         document.getElementById("ModalcontenidoCD").classList.remove("verObjeto");
         document.getElementById("ModalcontenidoCD").classList.add("ocultarObjeto");
          window[funcion](respuesta);                                                 
        }     
      if(req.status==500){document.getElementById("miModalCD").classList.add("modalCierraGenerico");document.getElementById("miModalCD").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoCD").classList.remove("verObjeto");document.getElementById("ModalcontenidoCD").classList.add("ocultarObjeto");  }
      
   }

  };
 req.send(parametros);
}


function cambiaVen(objeto)
{
  objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
  if(objeto.value==""){     document.getElementById('guardarActividad').classList.add('ocultarObjeto');
  document.getElementById('guardarActividad').classList.remove('verObjeto'); }
  for(var i=0;i<cant;i++){objetosCB[i].checked=false;}
} 


function escogeCompania(objeto)
{
  var select=document.getElementById('IDVend');
  var objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
  var contador=0;numeroPermitidos=numeroPorRanking[select[select.selectedIndex].getAttribute('data-ranking')];
  var canal=select[select.selectedIndex].getAttribute('data-canal');
  var agente=select[select.selectedIndex].getAttribute('data-tipoAgente');
  var ranking=select[select.selectedIndex].getAttribute('data-ranking');
  var band=0;
  if(typeof(numeroPermitidos) != "undefined")
  {
   for(var i=0;i<cant;i++){if(objetosCB[i].checked){contador++;}}
    if(canal=='FIANZAS' || agente=="Agente Independiente"){if(contador>3){band=1;}}
    else{if(contador>numeroPermitidos){objeto.checked=false;band=1;}}
    if(band){ 
        objeto.checked=false;contador--;
          if(agente=="Agente Independiente"){alert("Los agentes "+agente+" tiene permitidos "+contador+" companias");}
          else{
             if(canal=='FIANZAS' ){alert("Los agentes "+canal+" tiene permitidos "+contador+" companias");}
            else{alert("Los agentes "+ranking+" tiene permitidos "+contador+" companias");}}
        
         }
    if(contador>0)
    {
     document.getElementById('guardarActividad').classList.add('verObjeto');
     document.getElementById('guardarActividad').classList.remove('ocultarObjeto');
    }
    else
    {
     document.getElementById('guardarActividad').classList.add('ocultarObjeto');
     document.getElementById('guardarActividad').classList.remove('verObjeto');   
    } 
    }
    else{objeto.checked=false;alert("No tiene permitido elegir companias")}
}

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

    <?php  
    if(isset($permitirRanking))
    {
        echo('var numeroPorRanking=new Array();');
        foreach ($permitirRanking as  $value) {echo('numeroPorRanking["'.$value->personaRankingAgente.'"]="'.$value->companiasPermitidasPRA.'";');
        }
    }
    ?>
function abrirModal(e){e.preventDefault();document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.add("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.remove("ocultarObjeto");  document.getElementById('inputNuevoGiro').focus()}

function cerrarModal(){document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.remove("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.add("ocultarObjeto");  }


function valoresIniciales()
{
	document.getElementById('selectRazon').value="<?=$tipoEntidad;?>";
	document.getElementById('enlaceProyecto100').value="<?=$enlaceProyecto100;?>";
	document.getElementById('textApellidoPaterno').value="<?=$apellidoPaterno;?>";
	document.getElementById('textApellidoMaterno').value="<?=$apellidoMaterno;?>";
	document.getElementById('textNombres').value="<?=$nombre;?>";
	document.getElementById('textNombres').value="<?=$nombre;?>";
	document.getElementById('textRazonSocial').value="<?=$razonSocial;?>";
	document.getElementById('textRFC').value="<?=$RFC;?>";
	document.getElementById('textCelular').value="<?=$celular;?>";
	document.getElementById('textEmail').value="<?=$email;?>";
	document.getElementById('IDVend').value="<?=$IDVend;?>";
	document.getElementById('IDCliClienteActualiza').value="<?=$IDCliClienteActualiza;?>";
	document.getElementById('fecha_nacimiento').value="<?=$fecha_nacimiento;?>";
	document.getElementById('fechaConstitucion').value="<?=$fechaConstitucion;?>";

}

function cargaInicial()
{
valoresIniciales();
escogerTipoEntidad();
opcionesActividad();
if(document.getElementById('IDVend')){document.getElementById('IDVend').removeAttribute('required')}
}
window.onload=cargaInicial();

document.getElementById('filtroIDVend').classList.remove('input-sm');
document.getElementById('filtroIDVend').classList.remove('form-control')
document.getElementById('filtroIDVend').parentNode.removeAttribute('class')
document.getElementById('filtroIDVend').parentNode.parentNode.removeAttribute('class')
document.getElementById('filtroIDVend').parentNode.parentNode.parentNode.classList.add('elementosReqActividadesAlterno')
document.getElementById('IDVend').classList.remove('input-sm');
document.getElementById('IDVend').classList.remove('form-control')
document.getElementById('IDVend').parentNode.removeAttribute('class')

</script>
<style type="text/css">
.elementosReqActividadesHorizontal{display: flex}
 .elementosReqActividadesHorizontal>div{flex:1;}
 .elementosReqActividadesHorizontal>div> button,a{width: 90%}
 .elementosReqActividades>div>div{display: flex;}
 .elementosReqActividadesAlterno{margin: 10px}
.contenedorReqActividades{display: flex;flex-direction: column;width: 90%;margin-left: 5%;height: 400px}
.elementosReqActividades{display: flex;margin-bottom: 5px; }
.elementosReqActividades >label{flex: 1; }
.elementosReqActividades >div{flex: 3; ; }
.elementosReqActividades div>input,select,textarea{width: 100%}
#divEleccionCompania{display: flex;}
#divEleccionCompania>div{flex:1;}
.verElemento{display: block;}
.ocultarElemento{display: none; flex: 0 0 0}	
.botonCierre{background-color: red;color:white;}
.modal-contenidoGenerico{background-color:none  ;width:80%;height:100%;left: 30%;position: relative;z-index: 1000;top:25%; } 
.modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 10000}
.botonCierre{background-color: red;color:white;}
.contenidoModal{border: solid;background-color: white;width: 50%;height: 60%; position: relative;left: -0%;top: -5%}
#formActividades input:focus,select:focus,textarea:focus{background-color: #b2cae4}
</style>
<style type="text/css" id="estiloParaNoMovilV3">
@media only screen and (min-width: 751px) 
{ 
  .elementosReqActividades {display: flex;flex-direction: row;}  
  .elementosReqActividades>label{height: 25px;font-size: 15px;color:black;text-decoration: underline;}
  .elementosReqActividades>div> input,select{height: 25px;font-size: 15px}  
  .elementosReqActividades>div>textarea{height: 150px;font-size: 15px}
  #divEleccionCompania{flex-direction: row;flex-wrap: wrap;}  
  #divEleccionCompania>div{display:flex;flex-direction: column;border: solid 1px black;justify-content: space-between;}  
  #divEleccionCompania>div>div:nth-child(1){height :80%;}
  #divEleccionCompania>div>div>label{font-size: 15px}
  #divEleccionCompania>div>div:nth-child(2){height: 20%;}
  #divEleccionCompania>div>div>input{height: 25px}
  .elementosReqActividadesHorizontal>div>button,a{height: 30px;font-size: 15px}
  .elementosReqActividades>div>div>div>div input,select{height: 25px;font-size: 15px}
  .elementosReqActividades>div>div>div>div label{font-size: 15px}
  .elementosReqActividades>div>div{flex-direction: row;justify-content: space-between;}
  #filtroIDVend{height: 25px;font-size: 15px;flex:1;}
  #IDVend{flex:3;}
  .elementosReqActividadesAlterno>div{display: flex}
  .elementosReqActividadesAlterno>div>div:nth-child(1){flex:1;}
  .elementosReqActividadesAlterno>div>div:nth-child(2){flex:3;}
  
  
}
@media only screen and (min-width: 325px ) and (max-width: 750px)  
{
  .elementosReqActividades>label{height: 150px;font-size: 25px;color:black;text-decoration: underline;}
  .elementosReqActividades {display: flex;flex-direction: column;} 
  .elementosReqActividades>div> input,select{height: 30px;font-size: 25px}  
  .elementosReqActividades>div>textarea{height: 30px;font-size: 25px}  
  #divEleccionCompania{flex-direction: column;flex-wrap: wrap;}
  #divEleccionCompania>div{display: flex;flex-direction: row;border: solid 1px black}  
    #divEleccionCompania>div>div:nth-child(1){flex :4}
  #divEleccionCompania>div>div:nth-child(2){flex: 1}
  #divEleccionCompania>div>div>label{font-size: 25px}
  #divEleccionCompania>div>div>input{height:  30px}
  .elementosReqActividadesHorizontal>div>button,a{height: 30px}
  .elementosReqActividades>div>div>div>div input,select{height: 30px;font-size: 25px}
  .elementosReqActividades>div>div>div>div label{font-size: 25px}
  .elementosReqActividades>div>div{flex-direction: column;}
  #filtroIDVend{height: 30px;font-size: 25px}
}


@media only screen and (min-width: 320px) and (max-width: 600px)
{
  .elementosReqActividades>label{height: 60px;font-size: 50px;color:black;text-decoration: underline;}
  .elementosReqActividades {display: flex;flex-direction: column;} 
  .elementosReqActividades>div> input,select{height: 100px;font-size: 50px}  
  .elementosReqActividades>div>textarea{height: 500px;font-size: 50px}  
  #divEleccionCompania{flex-direction: column;flex-wrap: wrap;}
  #divEleccionCompania>div{display: flex;flex-direction: row;border: solid 1px black}  
    #divEleccionCompania>div>div:nth-child(1){flex :4}
  #divEleccionCompania>div>div:nth-child(2){flex: 1}
  #divEleccionCompania>div>div>label{font-size: 50px}
  #divEleccionCompania>div>div>input{height:  50px}
  .elementosReqActividadesHorizontal>div>button,a{height: 80px}
  .elementosReqActividades>div>div>div>div input,select{height: 60px;font-size: 50px}
  .elementosReqActividades>div>div>div>div label{font-size: 55px}
  .elementosReqActividades>div>div{flex-direction: column;}
  #filtroIDVend{height: 60px;font-size: 50px}
  #btnGiroCliente{height: 40px;width: 60px  }
}


</style>
<style type="text/css" id="estiloParaMovilV3">
 .nav-item>a{display: none;}
.nav-item>a[href="<?=base_url()?>directorio"]{display: block;font-size: 40px}
.nav-item>a[href="<?=base_url()?>crmproyecto/proyecto100"]{display: block;font-size: 40px}
.nav-item>a[href="<?=base_url()?>cotizador"]{display: block;font-size: 40px}
.nav-item>a[data-movil="1"]{display: block;font-size: 40px}
.dropdown-item{display: none}
 .dropdown-item[href="<?=base_url()?>actividades"]{display: block;font-size: 40px}
 .dropdown-item[href="<?=base_url()?>actividades/agregar"]{display: block;font-size: 40px}
@media only screen and (min-device-width: 601px ) and (max-device-width: 2000px)  
{
  .elementosReqActividades>label{height: 150px;font-size: 50px;contentolor:black;text-decoration: underline;}
  .elementosReqActividades {display: flex;flex-direction: column;} 
  .elementosReqActividades>div> input,select{height: 150px;font-size: 50px}  
  .elementosReqActividades>div>textarea{height: 300px;font-size: 50px}  
  #divEleccionCompania{flex-direction: column;flex-wrap: wrap;}
  #divEleccionCompania>div{display: flex;flex-direction: row;border: solid 1px black}  
    #divEleccionCompania>div>div:nth-child(1){flex :4}
  #divEleccionCompania>div>div:nth-child(2){flex: 1}
  #divEleccionCompania>div>div>label{font-size: 50px}
  #divEleccionCompania>div>div>input{height:  150px}
  .elementosReqActividadesHorizontal>div>button,a{height: 150px;font-size: 50px}
  .elementosReqActividades>div>div>div>div input,select{height: 150px;font-size: 50px}
  .elementosReqActividades>div>div>div>div label{font-size: 50px}
  .elementosReqActividades>div>div{flex-direction: column;}
  #filtroIDVend{height: 150px;font-size: 50px}

  #btnGiroCliente{height: 150px;width: 100px;font-size: 75px}

  body{width: 2000px}

}


@media only screen and (min-device-width: 320px) and (max-device-width: 600px) 
{
  .elementosReqActividades>label{height: 60px;font-size: 75px;color:black;text-decoration: underline;}
  .elementosReqActividades {display: flex;flex-direction: column;} 
  .elementosReqActividades>div> input,select{height: 200px;font-size: 75px}  
  .elementosReqActividades>div>textarea{height: 500px;font-size: 75px}  
  #divEleccionCompania{flex-direction: column;flex-wrap: wrap;}
  #divEleccionCompania>div{display: flex;flex-direction: row;border: solid 1px black}  
  #divEleccionCompania>div>div:nth-child(1){flex :4}
  #divEleccionCompania>div>div:nth-child(2){flex: 1}
  #divEleccionCompania>div>div>label{font-size: 50px}
  #divEleccionCompania>div>div>input{height:  50px}
  .elementosReqActividadesHorizontal>div>button,a{height: 150px;font-size: 75px}
  .elementosReqActividades>div>div>div>div input,select{height: 200px;font-size: 75px}
  .elementosReqActividades>div>div>div>div label{font-size: 75px}
  .elementosReqActividades>div>div{flex-direction: column;}
  #filtroIDVend{height: 200px;font-size: 75px}
  #btnGiroCliente{height: 150px;width: 100px;font-size: 75px}
  body{width: 1600px}

}
</style>
<?
function imprimirEstados($array)
{
	
	$options="";
	foreach ($array as $value) {
        if($value->clave=='31'){$options.='<option value="'.$value->clave.'" selected>'.$value->estado.'</option>';}
		else{$options.='<option value="'.$value->clave.'">'.$value->estado.'</option>';}}
  return $options;
}
//----------------------------------
function imprimirGiros($array)
{
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array,TRUE));fclose($fp);
	$options="<option value></option>";
	foreach ($array as $value) {$options.='<option value="'.$value->idGiro.'">'.$value->giro.'</option>';}
  return $options;
}
//----------------------------------
function imprimirRamos($array)
{
	
	$options="<option value=''>---SELECCIONE UN RAMO---</option>";
	foreach ($array as $value) {$options.='<option value="'.$value->Abreviacion.'">'.$value->Nombre.'</option>';}
  return $options;
}
?>

<script type="text/javascript">
  
  if(!esDispositivoMovil){document.getElementById('estiloParaMovilV3').parentNode.removeChild(document.getElementById('estiloParaMovilV3'));}
  else{document.getElementById('estiloParaNoMovilV3').parentNode.removeChild(document.getElementById('estiloParaNoMovilV3'));}
</script>