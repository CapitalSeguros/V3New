<?php $this->load->view('headers/headerS'); ?>
<?php $this->load->view('headers/menu');?>
<div id="miModal" >

<div id="Modalcontenido" class="modal-contenido"  >
  <table class="table">
    <div><thead><tr><th colspan="2" name="cabezetaBsuquedaTH">    <button onclick="abrirCerrar(true)" style="color: white;float:right;background-color:red; border:double; position:relative; top:0px">Cerrar</button>  </th></tr><tr><th name="cabezetaBsuquedaTH"><div style="display:flex"><input type="text" name="" id="buscarPorClieteText" placeholder="BUSCAR POR CLIENTE" class="form-control"><button class="btn btn-info" onclick="buscarPorCliente('')"></button></div></th>
    </tr>
    <tr id="buscarPorPolizaTR"><th name="cabezetaBsuquedaTH"><div style="display:flex"><input type="text" name="" id="buscarPorPolizaText" placeholder="BUSCAR POR POLIZA" class="form-control"><button class="btn btn-info" onclick="buscarPorPoliza('')"></button></div></th></tr>
  </thead>
    <tbody id="clienteBuscarBody"></tbody>
    </table> 
</div>
</div> 

</div>

<div class="contieneOpcionesDiv" id="contieneOpcionesDiv" >

<div id="tipoActividadDiv">
    <div labeldiv='1' class="label label-info"><label>Tipo Actividad</label></div>
    <div componentediv='1'>
        <select class="form-control"  id="tipoActividad" name="tipoActividad">
            <option value="">-- Seleccione --</option><option value="Cotizacion">Cotización</option><option value="Emision">Emisión</option><option value="CambiodeConducto">Cambio de Conducto</option><option value="Endoso">Endoso</option><option value="Cancelacion">Cancelación</option><option value="AclaraciondeComisiones">Aclaración de Comisiones</option><option value="CapturaEmision">Captura</option><option value="Sustitucion">Sustitución</option><option value="Fianzas">Fianzas</option>
        </select>
    </div>
</div>
<div id="ramoActividadesDiv" data-visible="0" data-tipovista="gral"></div>
<div id="subRamoActividadesDiv" data-visible="0" data-tipovista="gral"></div>
<div id="nombreClienteDiv" data-visible="0" data-tipovista="gral"></div>
<div id="preferenciaDeComunicacionDiv" data-visible="0" data-tipovista="emi"><div labeldiv='1' class="label label-info"><label>Preferencia de comunicacion:</label></div><div componentediv='1'><select name="preferenciaComunicacion" id="preferenciaComunicacion"  class="form-control">
<?=imprimirOptionPreferencias($preferenciaContacto['preferenciaComunicacion'],'Selecciones una preferencia de comunicacion')?>  
<!--option value="-1" >Selecciones una preferencia de comunicacion</option><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option--></select></div></div>
<div id="preferenciaDeHorarioDiv" data-visible="0" data-tipovista="emi"><div labeldiv='1' class="label label-info"><label>Preferencia de Horario:</label></div><div componentediv='1'><select name="horarioComunicacion" id="horarioComunicacion" class="form-control"><?=imprimirOptionPreferencias($preferenciaContacto['prefercianHorario'],'Seleccion una hora de comunicacion')?>  <!--option value="-1">Seleccion una hora de comunicacion</option><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option--></select></div></div>
<div id="diasDeContactoDiv" data-visible="0" data-tipovista="emi"><div labeldiv='1' class="label label-info"><label>Dias de Contacto:</label></div><div componentediv='1'><select name="diaComunicacion" id="diaComunicacion" class="form-control"><?=imprimirOptionPreferencias($preferenciaContacto['preferenciaDia'],'Seleccione un dia de comunicacion')?> <!--option value="-1">Seleccione un dia de comunicacion</option><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option--></select></div></div>


<div id="celularClienteDiv" data-visible="1" data-tipovista="cot"></div>
<div id="emailClienteDiv" data-visible="1" data-tipovista="cot"></div>

<div id="tipoEndosoDiv"  data-visible="1" data-tipovista="end">
    <div  labeldiv='1' class="label label-info"><label>Tipo de endoso</label></div>
    <div componentediv='1'><select name="" id="selectTipoEndoso" class="form-control"><option value="">-- Seleccione --</option><option value="A">Tipo A .- El endoso A genera primas adicionales para cobro, como ejemplo cambio de suma asegurada, agregar a un asegurado a una póliza existente.</option><option value="B">Tipo B .- El endoso B, es cualquier cambio a la póliza que no genera primas, como cambio de dirección, cambio de placas.</option><option value="D">Tipo D .- El endoso D cualquier cambio que genera disminución como eliminación de coberturas, baja de algún asegurado o incremento de deducible. El endoso D genera una nota de crédito.</option></select></div>
  </div>

<div id="formasDePagoDiv" data-visible="1" data-tipovista="emi;end"><div labeldiv='1' class="label label-info"><label>Forma de pago:</label></div><div componentediv='1'><select id="pagoFormas" name="pagoFormas" class="form-control"><option value="">-- Seleccione --</option>                <option value="1">Anual</option>
                              <option value="2">Semestral</option>
                              <option value="3">Trimestral</option>
                              <option value="4">Mensual</option>
              </select></div></div>

<div id="conductoDePagoDiv" data-visible="0" data-tipovista="emi">
<div  labeldiv='1' class="label label-info"><label>Conducto de Pago:</label></div><div componentediv='1'><select id="pagoConducto" name="pagoConducto" onchange="cambiarConducto(this.value)" class="form-control" ><option value="">-- Seleccione --</option>                <option value="1">Transferencia</option>
                              <option value="2">Cheque</option>
                              <option value="3">Tarjeta de Credito</option>
                              <option value="4">Tarjeta de debito</option>
              </select></div>

</div>


<div id="datosTarjetasDiv" data-visible="0" data-tipovista="emi">
  <div labeldiv='1' class="label label-info"><label>Datos Tarjeta:</label></div>
       <div componentediv='1'>
          <div style="display:flex;justify-content:space-around;flex-wrap:wrap">
                    <div>
                        <div><label>Número de tarjeta</label></div>                        
                        <div><input type="text" id="numeroTarjeta" name="numeroTarjeta"  placeholder="Ingrese los 16 dígitos de la tarjeta" class="form-control"></div>
                    </div>
                    <div>
                        <div><label>Vencimiento</label></div>
                        <div>                        
                        <select id="mesTarjeta" name="mesTarjeta" class="form-control">
                            <option value="">Mes</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
                        </select>
                      </div>
                    </div>
                    <div>
                    	<div><label>Año</label></div>
                      <div>
                        <select id="yearTarjeta" name="yearTarjeta" class="form-control">
                            <option value="">Año</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option>
                        </select>
                      </div>
                    </div>
                    <div>
                        <div><label>Código de Seguridad</label></div>
                        <div><input type="text" id="ccv" name="ccv" class="form-control"></div>
                    </div>
                </div>



                <div style="display:flex;justify-content:space-around;flex-wrap:wrap">
                    <div>
                        <div><label>Titular de la tarjeta</label></div>
                        
                        <div><input type="text" id="titularTarjeta" name="titularTarjeta" class="datosTarjeta form-control" placeholder="Como aparece en la tarjeta" ></div>
                    </div>
                    <div>
                        <div><label>Tipo tarjeta</label></div>
                        
                        <div><select id="tipoTarjeta" name="tipoTarjeta" class="datosTarjeta form-control">
                            <option value="Visa">Visa</option>
                            <option value="Master Card">Master Card</option>
                        </select>
                      </div>
                    </div>
                    <div>
                        <div><label>Banco</label></div>
                        
                        <div><input type="text" id="bancoTarjeta" name="bancoTarjeta" class="datosTarjeta form-control" placeholder="Banco emisor"></div>
                    </div>
                    <div>
                        <div><label>Tipo de pago aplicación</label></div>
                        <div>
                        <select id="tipoPagoTarjeta" name="tipoPagoTarjeta" class="datosTarjeta form-control">
                            <option value="Un solo cargo">Un solo cargo</option>
                            <option value="Domiciliada">Domiciliada</option>
                            <option value="Meses sin intereses">Meses sin intereses</option>
                        </select>
                      </div>
                    </div>
                </div></div></div>


                <div id="facturaDiv" data-visible="0" data-tipovista="emi">
                <div  labeldiv="1" class="label label-info"><label  class="labelResponsivo">Factura</label></div>
                <div componentediv="1"><select name="pagoFactura" id="pagoFactura" class="form-control" onchange="cambioDatosFactura(this.value)"><?php 
              foreach($pagoFactura as $value){?>
                <option value="<?php echo($value->idPagoFactura); ?>"><?php echo($value->pagoFactura); ?></option>
              <?php
              }
            ?></select></div>
</div>

<div>
  <div></div>
  <div></div>
</div>




<div id="datosDeFacturaDiv" data-visible="0" data-tipovista="emi;cc;ce">
  <div labeldiv="1" class="label label-info"><label class="labelResponsivo">Datos de Factura</label></div>
<div  componentediv="1" style="display:flex;flex-direction:row;justify-content:space-between;flex-wrap:wrap">
<div >
      <div><label>Direccion</label></div>
      <div><input type="text" id="direccionFactura" name="direccionFactura" class="form-control" placeholder="Ingrese Direccion"  />
    </div>  
  </diV>
   
  <div>
        <div><label>CP</label></div>
        <div><input type="text" id="cpFactura" name="cpFactura" class="form-control" placeholder="Ingrese codigo postal"  />
      </div>       
</div>
 
<div>
      <div><label>RFC</label></div>                  
      <div><input type="text" id="rfcFactura" name="rfcFactura" class="form-control" placeholder="Ingrese el RFC"  value="<?=$rfcFactura?>" />
     </div>                                                
     
            </div>
            </div>
            </div>                  
   
            <div id="validacionDeFacturaDiv" data-visible="0" data-tipovista="cc;ce">
            <!--div labeldiv="1" class="label label-info">Validar Factura</div-->
            <div  componentediv="1" style="display:flex;flex-direction:row;justify-content:end;flex-wrap:wrap">
              <div><a class="label label-warning" href="https://agsc.siat.sat.gob.mx/PTSC/ValidaRFC/index.jsf" target="_blanck">VALIDADOR DE RFC</a></div>
              <div><a href="https://consisa.com.mx/rfc" class="label label-warning" target="_blanck">CREAR RFC PROVISIONAL</a></div>
            </div>
            </div>            


            <div id="polizaCapturaEmisionDiv"  data-visible="0" data-tipovista="ce">
    <div labeldiv='1' class="label label-info"><label>Poliza captura emision</label></div>
    <div componentediv='1'><input type="text" name="" id="polizaCpaturaEmisionInput" class="form-control" placeholder="Este Campo es Obligatorio o no será atendida la Captura de Emision"></div>
  </div>


  <div id="companiaEleccionDiv"  data-visible="0" data-tipovista="emi">
    <div style="" labeldiv='1' class="label label-info"><label class="labelResponsivo">Companias</label></div>
    <div componentediv='1'><select name="" id="selectCompania" class="form-control"></select></div>
  </div>

<div id="cruceDeCarteraDiv"  data-visible="0" data-tipovista="emi">
  <div labeldiv='1' class="label label-info"><label>Cruce de Cartera</label></div>
  <div componentediv='1'><input type="checkbox" class="form-control" name="cruce" id="cruce" value="1"></div>
</div>




  <div id="polizaDiv"  data-visible="1"  data-tipovista="end;can;sus">
    <div  labeldiv='1' class="label label-info"><label>Poliza</label></div>
    <div componentediv='1'><input type="text" name="" id="polizaInput" class="form-control"></div>
  </div>





<div id="serieClienteDiv" data-visible="0" data-tipovista="cot;emi"></div>
<div id="agentesDiv" data-visible="0" data-tipovista="gral">
    <div labeldiv="1" class="label label-info"><label>Vendedores</label></div>
    <div componentediv="1"><?=($vendedores)?></div>
</div>
<div id="divEleccionCompania" data-visible="0" data-tipovista="cot">
<div style="height:20%;min-height:21px" labeldiv='1' class="label label-info"><label>Companias</label></div>
<div componentediv='1' id="companiasDiv"></div>
</div>
<div componentediv='1' data-visible="0" id="comentariosDiv" data-tipovista="gral">
  <div labeldiv='1' style="height:20%;min-height:21px" class="label label-info"><label>Comentarios</label></div>
  <div componentediv='1' ><textarea name="datosExpres" id="datosExpres" rows="10" cols="40" placeholder="Escribe aquí tus comentarios" onpaste="return false" class="form-control"></textarea></div>
</div>

<div id="adicionaleEmisionDiv"  data-visible="0" data-tipovista="emi">
  <div labeldiv='1' class="label label-info"><label >Opciones adicionales</label></div>
  <div componentediv='1' style="display:flex;flex-direction:row;justify-content:space-evenly">
     <div>  
       <div><label class="label label-warning">Emision Urgente!!!</label></div>
       <div><input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" class="form-control" ></div>
      </div>
      <div>  
       <div><label class="label label-warning">Se requiere RFC para facturar</label></div>
       <div><input name="actividadRequiereFactura" id="actividadRequiereFactura" type="checkbox" class="form-control" style="" onclick="activaRFCNecesario()"></div>
      </div>
  </div>
</div>

<div  id="informacionCotizacionDiv"  data-visible="1" data-tipovista="cot">
  <div labeldiv='1' class="label label-info" style="white-space:break-spaces"><p>Le recordamos que para poder tramitar su cotización exprés Necesitamos:</p></div>
  <div componentediv='1' style="    display: flex;flex-direction: row;justify-content: space-around;flex-wrap: wrap;">    
   <div><label class="label label-warning">*Marca</label></div>
   <div><label class="label label-warning">*Descripción</label></div>
   <div><label class="label label-warning">*Modelo</label></div>
   <div><label class="label label-warning">*Forma de pago</label></div>
   <div><label class="label label-warning">*Cobertura</label></div>
   <div><label class="label label-warning">*Codigo Postal</label></div>
   <div style="display:flex;flex-direction:column">
    <div><label class="label label-warning">*Tipo de carga solo Pick Up<label></div><br>
     <div><label class="label label-danger"> -Porcentaje Descuentos</label></div><br>
    <div><label class="label label-danger"> -Comparativos BASICA Merida </label></div><br>
    <div><label class="label label-danger"> -Comparativos ESTANDARIZADOS Merida</label></div><br>  
    </div>
            </div> 
</div>

<div  id="informacionCCDiv"  data-visible="1" data-tipovista="cc">
  <div labeldiv='1' class="label label-info" style="white-space:break-spaces"><p>Informacion necesaria:</p></div>
  <div componentediv='1' >    
  <div><label class="label label-danger">Le recordamos que para poder tramitar este tipo de activida es necesario el RFC</label></div>
</div>
     
</div>



<div  id="guardarDiv"  data-visible="0" data-tipovista="gral">
<div componentediv='1'   id="botonGuardarDiv" style="width:100%;text-align:center">
  <div><button id="guardarActividadButton" class="btn btn-success" style="width:50%">Guardar</button></div>
</div>
            </div>

</div>



<style>
    .contieneOpcionesDiv{display:flex;margin:10px;flex-wrap:wrap}
    .contieneOpcionesDiv>div{width: 95%;width: 100%;display:flex;margin-top:1%}
    .contieneOpcionesDiv>div[data-visible="0"]{display:none}
    .contieneOpcionesDiv>div:nth-child(1){}
    div[labeldiv="1"]{flex:1;text-align:center}
    div[labeldiv="1"]>label{margin-top:2%;font-size:large}
    div[componentediv="1"]{flex:5}
    div[id="companiasDiv"]{display:flex;justify-content:space-between;flex-wrap:wrap}
    .cargaDeInfo{/*width: 100%;height: 100%;background-color: white;opacity: .5;;background-size: 40px;background-repeat: no-repeat;background-position-x:center;background-position-y:center;*/}
    .cargaDeInfo::after{content:"";background-image: url(<?=base_url().'assets/img/esperaBlue.gif' ?>);    height:50px;
width:50px;display:block; background-size:100%;background-repeat:no-repeat;position:relative;left:50%}
.busquedaClientePoliza{background-color:#a0a0d1;position:absolute;opacity:.2}
#busquedaClientePoliza{display:none;width:70%;height:70%;position:relative;top:20%;left:10%}
#busquedaClientePoliza>div:nth-child(1){background-color:red}
.modal-contenido{background-color:white;width:90%;height:60%;margin: 10% auto;position: relative;z-index: 1000;overflow:scroll }
.modal-contenido thead{position:sticky;top:0px}

.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}

#clienteBuscarBody>tr:hover{color:white;cursor:pointer;background-color:#5fb36a}
.verElemento{display: block;}
.ocultarElemento{display: none; flex: 0 0 0}
#polizaCpaturaEmisionInput::placeholder{  color: red;opacity: 0.5;}
.errorVacio::before{content:'*';font-size:34px;color:#ff6464}
</style>
<script>
    let clientesGlobales=[];
    let polizasGlobales=[];
    let clienteGlobal=[];
    let IDDoctoGlobal=[];
    function peticionAJAX(controlador,parametros,funcion,componente='')
{
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
  req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if(componente!=''){document.getElementById(componente).classList.add('cargaDeInfo')}
   req.onreadystatechange = function (aEvt) 
  {
   
    if (req.readyState == 4) 
    {
    	
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         if(componente!=''){document.getElementById(componente).classList.remove('cargaDeInfo')}
          window[funcion](respuesta);                                                 
        }     
      if(req.status==500){  }
      
   }

  };
 req.send(parametros);
}
document.getElementById('tipoActividad').addEventListener('change',function(){
  let tipoActividad=document.getElementById('tipoActividad').value;  
  let parametros=`nombreRamo=${tipoActividad}`;  
     
     if(tipoActividad=='Cotizacion' || tipoActividad=='Emision' || tipoActividad=='CambiodeConducto' || tipoActividad=='AclaraciondeComisiones' || tipoActividad=='CapturaEmision' ) 
     {
      document.getElementById('buscarPorPolizaTR').style.display='none';
     }
     else
     {
      document.getElementById('buscarPorPolizaTR').style.display='table-row'
      if(tipoActividad=='Sustitucion' || tipoActividad=='Endoso')
      {
        let event = new Event("change");
        document.getElementById('selectTipoEndoso').dispatchEvent(event);
      }
     }

    peticionAJAX('actividades/obtenerRamosPorActividad',parametros,'ramoDeActividades','ramoActividadesDiv');

})


function buscarPorPoliza(datos='')
{
    if(datos=='')
  {
    let parametros=`type=1&search=${document.getElementById('buscarPorPolizaText').value}`;
    peticionAJAX('polizas/BusquedaPolizas',parametros,'buscarPorPoliza',componente='Modalcontenido');
  }
  else
  {    
    let rows='';
    rowParaPolizas(datos)

  }
}

function rowParaPolizas(datos)
{ let rows='';
  polizasGlobales=datos;
    for(let val of datos){rows+=`<tr data-id="${val.IDDocto}" ><td style="display:flex;justify-content:space-between;width:100%"><label>${val.TipoDocto_TXT}</label><label>${val.ApellidoP} ${val.ApellidoM} ${val.Nombre}</label><label>${val.Documento}</label></td></tr>`}
    document.getElementById("clienteBuscarBody").innerHTML=rows;
    let fila=document.getElementById("clienteBuscarBody").rows;
    
    for(let val of fila)
     {
        val.addEventListener('dblclick',function()
        {            
            let IDDocto=this.dataset.id;
            
            for(let val of polizasGlobales){if(IDDocto==val.IDDocto){IDDoctoGlobal=val;break}}

             let parametros=`IDCli=${IDDoctoGlobal.IDCli}&IDSRamo=${IDDoctoGlobal.IDSRamo}`;
             
            peticionAJAX('actividades/traerDatosClienteRamo',parametros,'traerDatosClienteRamo','');
            
            clientesGlobales=[];
            document.getElementById('clienteBuscarBody').innerHTML='';
            //crearComponentesDeActividades();
            if(document.getElementById('tipoActividad').value=='Endoso')
            {
             /* switch (IDDoctoGlobal.FPago) 
              {
                case value:break;
              
                default:
                  break;
              }
              alert(4)*/
              document.getElementById('pagoFormas').value= IDDoctoGlobal.FPago
            }
            
            abrirCerrar(true);
 
        })
     }
}
function traerDatosClienteRamo(datos)
{
  console.log(datos);
  clienteGlobal=datos.cliente;
  document.getElementById('tipoRamo').value=datos.Abreviacion;
  let event = new Event("change");
  document.getElementById('tipoRamo').dispatchEvent(event);
  document.getElementById('selectTipoEndoso').focus();
  document.getElementById('clienteEscogido').value=IDDoctoGlobal.NombreCompleto;
  document.getElementById('IDVend').value=IDDoctoGlobal.IDVend;
  document.getElementById('polizaInput').value=IDDoctoGlobal.Documento;
  let event2 = new Event("change");
  document.getElementById('selectTipoEndoso').dispatchEvent(event2);

  

}
function buscarPorCliente(datos='')
{
  let th=document.getElementsByName('cabezetaBsuquedaTH');
    if(datos=='')
  {
    let parametros=`type=3&search=${document.getElementById('buscarPorClieteText').value}`;
    peticionAJAX('polizas/BusquedaPolizas',parametros,'buscarPorCliente',componente='Modalcontenido');
    
  }
  else
  {
    let rows='';
    clientesGlobales=datos;
     if(document.getElementById('tipoActividad').value=='Cotizacion' || document.getElementById('tipoActividad').value=='Emision' || document.getElementById('tipoActividad').value=='CambiodeConducto' || document.getElementById('tipoActividad').value=='CapturaEmision')    
     {
      for(let val of datos){rows+=`<tr data-id="${val.IDCli}"><td>${val.ApellidoP} ${val.ApellidoM} ${val.Nombre}</td></tr>`}
 
     }
     else
     {
      for(let val of datos){rows+=`<tr data-id="${val.IDCli}"><td>${val.ApellidoP} ${val.ApellidoM} ${val.Nombre}</td><td><button class="btn btn-success buscarPolizasDelCliente"  data-id="${val.IDCli}">Buscar polizas</button></td></tr>`}
 
    
     }
   
    document.getElementById("clienteBuscarBody").innerHTML=rows;
    let fila=document.getElementById("clienteBuscarBody").rows;
    let botones=document.getElementsByClassName('buscarPolizasDelCliente');
    repintarCabecera();
    for(let val of fila)
     {
        val.addEventListener('dblclick',function(){
            
            let idCliente=this.dataset.id;
            for(let val of clientesGlobales){ if(idCliente==val.IDCli){clienteGlobal=val;break}}
            clientesGlobales=[]
            document.getElementById('clienteBuscarBody').innerHTML='';
            crearComponentesDeActividades();
            abrirCerrar(true);
            let parametros=`IDCli=${idCliente}`;
            peticionAJAX('clientes/devolverPreferenciasDeContacto',parametros,'preferenciasContacto');

        })
     }
     for(let val of botones)
     {
      val.addEventListener('click',function()
      {          
        let parametros=`type=11&search=${this.dataset.id}`;
        peticionAJAX('polizas/BusquedaPolizas',parametros,'recibePolCliente',componente='Modalcontenido');

      })
     }
  }
}
function preferenciasContacto(datos)
{
  
  let band=false;
  options=document.getElementById('preferenciaComunicacion').options;
  for(let val of options){if(val.value==datos.preferenciaComunicacion){band=true}}
  if(band){document.getElementById('preferenciaComunicacion').value=datos.preferenciaComunicacion;}
  else{document.getElementById('preferenciaComunicacion').value=-1}

  band=false;
  options=document.getElementById('horarioComunicacion').options;
  for(let val of options){if(val.value==datos.horarioComunicacion){band=true}}
  if(band){document.getElementById('horarioComunicacion').value=datos.horarioComunicacion;}
  else{document.getElementById('horarioComunicacion').value=-1}
  
  
  band=false;
  options=document.getElementById('diaComunicacion').options;
  for(let val of options){if(val.value==datos.diaComunicacion){band=true}}
  if(band){document.getElementById('diaComunicacion').value=datos.diaComunicacion;}
  else{document.getElementById('diaComunicacion').value=-1}
  
}
function recibePolCliente(datos)
{
  rowParaPolizas(datos)
}
function  repintarCabecera()
{
  let tabla=document.getElementById('clienteBuscarBody');
  if(tabla.rows.length>0)
   {
    
     let cabecera=document.getElementsByName('cabezetaBsuquedaTH');
     for(let val of cabecera)
     {
      val.setAttribute('colspan', tabla.rows[0].cells.length )
     }
   }
}
function crearComponentesDeActividades()
{
    if(!document.getElementById('clienteEscogido')){crearComponentes('clienteEscogido','input','nombreClienteDiv','Nombre del Cliente') ;}
    if(!document.getElementById('Telefono1')){crearComponentes('Telefono1','input','celularClienteDiv','Celular') ;}
    if(!document.getElementById('EMail1')){crearComponentes('EMail1','input','emailClienteDiv','Email') ;}
    document.getElementById('clienteEscogido').value=`${clienteGlobal.ApellidoP} ${clienteGlobal.ApellidoM} ${clienteGlobal.Nombre}`;
    document.getElementById('Telefono1').value=clienteGlobal.Telefono1;
    document.getElementById('EMail1').value=clienteGlobal.EMail1;
    if(document.getElementById('rfcFactura'))
    {
      if(!clienteGlobal.RFC){clienteGlobal.RFC='';}
      document.getElementById('rfcFactura').value=clienteGlobal.RFC;
    }
    /* if(document.getElementById('tipoRamo1').value=='17' || document.getElementById('tipoRamo1').value=='19' || document.getElementById('tipoRamo1').value=='21')
     {*/
        if(!document.getElementById('SerieAuto')){crearComponentes('SerieAuto','input','serieClienteDiv','Serie')}
     /*}
     else{document.getElementById('serieClienteDiv').innerHTML='';}*/
            
     
}
function ramoDeActividades(datos)
{
    crearComponentes('tipoRamo','select','ramoActividadesDiv','Ramo') ;
    let option='<option>--Seleccione--</option>';
    for(let valor of datos.ramos)
    {   let nombre=valor.Nombre;
        if(valor.Nombre=='DAÑOS'){nombre='DANOS'}
        if(valor.Nombre=='ACCIDENTES Y ENFERMEDADES'){nombre='ACCIDENTES_Y_ENFERMEDADES'}
        option+=`<option value="${nombre}">${nombre}</option>`;
    }
    document.getElementById('tipoRamo').innerHTML=option;
    visibilidadDeElementos('ramoActividadesDiv',1);
    document.getElementById('tipoRamo').addEventListener('change',function(){      
        let params = 'ramo='+document.getElementById('tipoRamo').value;    	       	   
        controlador="actividades/devolverSubRamos/?";          
        peticionAJAX(controlador,params,'subRamoDeActividades','subRamoActividadesDiv');
        
})
crearComponentes('tipoRamo1','select','subRamoActividadesDiv','SubRamo') ; 
muestraTipoVista(); 
}

function subRamoDeActividades(datos)
{
    crearComponentes('tipoRamo1','select','subRamoActividadesDiv','SubRamo') ;    
    let option='<option>--Seleccione--</option>';
    for(let valor of datos.subRamos){option+=`<option value="${valor.IDSRamo}">${valor.Nombre}</option>`;}
    document.getElementById('tipoRamo1').innerHTML=option;
    if(IDDoctoGlobal.IDSRamo){document.getElementById('tipoRamo1').value=IDDoctoGlobal.IDSRamo;}
    visibilidadDeElementos('subRamoActividadesDiv',1);
    document.getElementById('tipoRamo1').addEventListener('change',function(){
        if(Object.keys(clienteGlobal).length==0){abrirCerrar()}
        else{crearComponentesDeActividades();}
        let params='idSubRamo='+document.getElementById('tipoRamo1').value;	     
        peticionAJAX('actividades/obtenerCompaniaPorSubRamo/',params,'obtenerCompaniaPorSubRamo');


    })

}
function escogeCompania(objeto)
{
  var select=document.getElementById('IDVend');
  var objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
  var contador=0;
  numeroPermitidos=numeroPorRanking[select[select.selectedIndex].getAttribute('data-ranking')];
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


function obtenerCompaniaPorSubRamo(datos)
{
    let opciones="";
    let textoTitulo="Promotorias";
  switch(document.getElementById('tipoActividad').value)
  {
    case 'Cotizacion': 
            for (var i=0;i<datos.companias.length;i++) {
                    /*opciones=opciones+'<div><div><label>'+datos.companias[i].Promotoria+'</label></div><div><input class="form-control" type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="cbCompania" value="'+datos.companias[i].idPromotoria+'"></div></div>';*/
                    opciones+=`<div><div><label>${datos.companias[i].Promotoria} </label></div><div><input class="form-control cbCompania" type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)"  value="${datos.companias[i].idPromotoria}"></div></div>`
                }
    break;
    case 'Emision': 
             opciones='<option value>--SELECCIONE COMPANIA</opcion>';//'<select id="selectCompania" name="selectCompania"><option value> --SELECCIONE COMPANIA--</option>';
  	            for (var i=0;i<datos.companias.length;i++) {
                    opciones=opciones+'<option value="'+datos.companias[i].idPromotoria+'">'+datos.companias[i].Promotoria+'</option>';
                }
                //opciones+='</select>';
                document.getElementById('selectCompania').innerHTML=opciones;
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
 console.log(opciones);
  if(document.getElementById("promotoriaLabel")){document.getElementById("promotoriaLabel").innerHTML=textoTitulo;}
  if(document.getElementById("divEleccionCompania")){document.getElementById("companiasDiv").innerHTML=opciones;}
}

function crearComponentes(id='',tipo='',divContenedor='',titleLabel='')
{
 document.getElementById(divContenedor).innerHTML='';
 let elemento=document.createElement(tipo);
 let divLabel=document.createElement('div');
 let divComponente=document.createElement('div');
 let label=document.createElement('label');
 label.innerText=titleLabel; 
 divLabel.classList.add('label');
 divLabel.classList.add('label-info');
 divLabel.appendChild(label) ;
 divLabel.setAttribute('labeldiv','1');
 divComponente.setAttribute('componentediv','1');
 elemento.id=id;
 elemento.classList.add('form-control')
 divComponente.appendChild(elemento);
 document.getElementById(divContenedor).appendChild(divLabel);
 document.getElementById(divContenedor).appendChild(divComponente);
 switch (divContenedor) {
  case 'serieClienteDiv':
    elemento.setAttribute('placeholder','Para cotizacion y edicion de vehiculos individuales es necesario este dato')
    break;
    case 'nombreClienteDiv':
      let btn=document.createElement('button');
    btn.classList.add('btn')
    btn.classList.add('btn-info')
    document.getElementById(divContenedor).appendChild(btn);
    btn.addEventListener('click',abrir)
    break;
 
  default:
    break;
 }
 /*if(divContenedor=='nombreClienteDiv')
 {
    let btn=document.createElement('button');
    btn.classList.add('btn')
    btn.classList.add('btn-info')
    document.getElementById(divContenedor).appendChild(btn);
    btn.addEventListener('click',abrir)
    
 }*/
                                        
}
function busquedaClientePoliza(abrir=false)
{
  if(abrir)
  {
    let ancho=window.outerWidth;
    let altura=window.innerHeight;
    document.getElementById('busquedaClientePoliza').classList.add('busquedaClientePoliza');
    document.getElementById('busquedaClientePoliza').style.width=ancho+'px';
    document.getElementById('busquedaClientePoliza').style.height=altura+'px';
    document.getElementById('busquedaClientePoliza').style.display='block';
  }
}

function abrirCerrar(seCierra=false)
{
  if(seCierra)
   {
    document.getElementById("miModal").classList.add("modalCierra");
    document.getElementById("miModal").classList.remove("modalAbre");
	document.getElementById("Modalcontenido").style.display="none";
   }
   else
   {
    document.getElementById("miModal").classList.remove("modalCierra");
    document.getElementById("miModal").classList.add("modalAbre");
   document.getElementById("Modalcontenido").style.display="block";
   }
  
 }
function cerrar()
{
  document.getElementById("miModal").classList.add("modalCierra");
   document.getElementById("miModal").classList.remove("modalAbre");
	   document.getElementById("Modalcontenido").style.display="none";
  
 }
 function abrir(){
document.getElementById("miModal").classList.remove("modalCierra");
  document.getElementById("miModal").classList.add("modalAbre");
   document.getElementById("Modalcontenido").style.display="block";
 }
 abrirCerrar(true);
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

function cambiaVen(objeto)
{
  
  objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
  if(objeto.value==""){     document.getElementById('guardarActividad').classList.add('ocultarObjeto');
  document.getElementById('guardarActividad').classList.remove('verObjeto'); }
  for(var i=0;i<cant;i++){objetosCB[i].checked=false;}
} 

function visibilidadDeElementos(id,display)
{
  if(id==''){id=document.getElementById('tipoActividad').value;}
  switch (id) {
    case 'Cotizacion':
      
      break;
      case 'Emision':
      
      break;
  case 'CambiodeConducto':
    break;

    default:
          document.getElementById(id).dataset.visible=1;
      break;
  }
}
function muestraTipoVista()
{
  let divInformacion=document.getElementById('contieneOpcionesDiv').children;
  for(let div of divInformacion){div.dataset.visible=0;}
  document.getElementById('tipoActividadDiv').dataset.visible=1;
  let buscar='';
  let valor=document.getElementById('tipoActividad').value;
  switch (valor) 
  {
    case 'Cotizacion':buscar='cot';break;  
    case 'Emision':buscar='emi';break;  
    case 'CambiodeConducto':buscar='cc';break;  
    case 'Endoso':buscar='end';break;  
    case 'Cancelacion':buscar='can';break;  
    case 'AclaraciondeComisiones':buscar='ac';break;  
    case 'CapturaEmision':buscar='ce';break;  
    case 'Sustitucion':buscar='sus';break;  
    case 'Fianzas':buscar='fia';break;  
    default:break;
  }
if(valor!=''){
  for(let div of divInformacion)
  {
    if(div.dataset.tipovista)
    {
     let tipoVista=div.dataset.tipovista.split(';');
      if(tipoVista.includes('gral')){div.dataset.visible=1;}
      else{if(tipoVista.includes(buscar)){div.dataset.visible=1}}

    }
  }
 }
}
document.getElementById('IDVend').classList.remove('input-sm');
document.getElementById('filtroIDVend').classList.remove('input-sm');
crearComponentesDeActividades();
muestraTipoVista();

document.getElementById('guardarActividadButton').addEventListener('click',function()
{
  let parametros;
  let parametro=new Object();
  let tipoActividad=document.getElementById('tipoActividad').value;
  if(document.getElementById('tipoRamo1').selectedIndex==-1 || document.getElementById('tipoRamo1').value=='-- Seleccione --')
  {alert('ESCOGER RAMO Y SUBRAMO');return 0}
  /*
  oldValueRFC 
  TipoDocto
  IDDir
  IDAgente
  */ 
 let idVendedor=document.getElementById('IDVend').value;
  switch (tipoActividad) {

    case 'Cotizacion':
      let escogeCompania=[];
      let compania=document.getElementsByName('cbCompania[]');
      for(let val of compania){if(val.checked){escogeCompania.push(val.value)}}

            if(!clienteGlobal.Telefono1)
            {
              clienteGlobal.Telefono1='';

            }
      parametros=`tipoActividad=${tipoActividad}&Telefono1=${clienteGlobal.Telefono1}&IDVend=${idVendedor}&datosExpres=${document.getElementById('datosExpres').value}&TipoEnt=${clienteGlobal.TipoEnt}&EMail1=${clienteGlobal.EMail1}&SerieAuto=${document.getElementById('SerieAuto').value}&cbCompania=${escogeCompania}&datosExpres=${document.getElementById('datosExpres').value}&tipoRamo=${document.getElementById('tipoRamo').value}&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}&tipoCliente=Existente&IDCli=${clienteGlobal.IDCli}&IDCont=${clienteGlobal.IDCont}&IDDir=-1&IDAgente=${idVendedor}&IDGrupo=${clienteGlobal.IDGrupo}&tipoActividadSicas=ot&TipoDocto=0&IDEjecut=${clienteGlobal.IDEjecut}&IDSRamo=${document.getElementById('tipoRamo1').value}&poliza=&clienteEscogido=${document.getElementById('clienteEscogido').value}`; 
      break;
      case 'Emision':
         let actividadUrgente=0;
         let actividadRequiereFactura='off';
        if(document.getElementById('actividadUrgente').checked){actividadUrgente=1;}
        if(document.getElementById('actividadRequiereFactura').checked){actividadRequiereFactura='on';}
        let cruce='';
        if(document.getElementById('cruce').checked){cruce=`&cruce=${document.getElementById('cruce').value}`;}
        parametros=`nombreCliente=${clienteGlobal.NombreCompleto}`;
        parametros+=`&preferenciaComunicacion=${document.getElementById('preferenciaComunicacion').value}`;
        parametros+=`&horarioComunicacion=${document.getElementById('horarioComunicacion').value}`;
        parametros+=`&diaComunicacion=${document.getElementById('diaComunicacion').value}`;
        parametros+=`&pagoFormas=${document.getElementById('pagoFormas').value}`;
        parametros+=`&pagoConducto=${document.getElementById('pagoConducto').value}`;
        parametros+=`&numeroTarjeta=${document.getElementById('numeroTarjeta').value}`;
        parametros+=`&mesTarjeta=${document.getElementById('mesTarjeta').value}`;
        parametros+=`&yearTarjeta=${document.getElementById('yearTarjeta').value}`;
        parametros+=`&ccv=${document.getElementById('ccv').value}`;
        parametros+=`&titularTarjeta=${document.getElementById('titularTarjeta').value}`;
        parametros+=`&tipoTarjeta=${document.getElementById('tipoTarjeta').value}`;
        parametros+=`&bancoTarjeta=${document.getElementById('bancoTarjeta').value}`;
        parametros+=`&tipoPagoTarjeta=${document.getElementById('tipoPagoTarjeta').value}`;
        parametros+=`&pagoFactura=${document.getElementById('pagoFactura').value}`;
        parametros+=`&direccionFactura=${document.getElementById('direccionFactura').value}`;
        parametros+=`&rfcFactura=${document.getElementById('rfcFactura').value}`;        
        parametros+=`&cpFactura=${document.getElementById('cpFactura').value}`;
        parametros+=`&selectCompania=${document.getElementById('selectCompania').value}`;
        parametros+=`&SerieAuto=${document.getElementById('SerieAuto').value}`;
        parametros+=cruce;
        parametros+=`&IDVend=${idVendedor}`;
        parametros+=`&datosExpres=${document.getElementById('datosExpres').value}`;
        parametros+=`&TipoEnt=${clienteGlobal.TipoEnt}`;
        parametros+=`&oldValueRFC=${document.getElementById('rfcFactura').value}`;
        parametros+=`&tipoActividad=${tipoActividad}`;
        parametros+=`&tipoRamo=${document.getElementById('tipoRamo').value}`;
        parametros+=`&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}`;
        parametros+=`&tipoCliente=Existente`;
        parametros+=`&IDCli=${clienteGlobal.IDCli}`;
        parametros+=`&IDCont=${clienteGlobal.IDCont}`;
        parametros+=`&IDDir=-1`;      
        parametros+=`&IDAgente=${idVendedor}`; 
        parametros+=`&IDGrupo=${clienteGlobal.IDGrupo}`; 
        parametros+=`&tipoActividadSicas=ot`;
        parametros+=`&TipoDocto=0`;
        parametros+=`&IDEjecut=${clienteGlobal.IDEjecut}`;
        parametros+=`&IDSRamo=${document.getElementById('tipoRamo1').value}`;
        parametros+=`&poliza`;
        parametros+=`&actividadUrgente=${actividadUrgente}`;
        parametros+=`&actividadRequiereFactura=${actividadRequiereFactura}`;


 
      break;
      case 'CambiodeConducto':
       /* if(document.getElementById('tipoRamo1').selectedIndex==-1 || document.getElementById('tipoRamo1').value=='-- Seleccione --')
        {alert('ESCOGER RAMO Y SUBRAMO');return 0}*/
        parametros=`oldValueRFC=${clienteGlobal.RFC}&rfcCliente=${document.getElementById('rfcFactura').value}&IDVend=${idVendedor}&datosExpres=${document.getElementById('datosExpres').value}&TipoEnt=${clienteGlobal.TipoEnt}&tipoActividad=${tipoActividad}&tipoRamo=${document.getElementById('tipoRamo').value}&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}&tipoCliente=Existente&IDCli=${clienteGlobal.IDCli}&IDCont=${clienteGlobal.IDCont}&IDDir=-1&IDAgente=${idVendedor}&IDGrupo=${clienteGlobal.IDGrupo}&tipoActividadSicas=ot&TipoDocto=0&IDEjecut=${clienteGlobal.IDEjecut}&IDSRamo=${document.getElementById('tipoRamo1').value}`;


      break;
      case 'Endoso':
        
       parametros=`tipoEndoso=${document.getElementById('selectTipoEndoso').value}`;
       parametros+=`&selectNuevaFormaPago=${document.getElementById('pagoFormas')[document.getElementById('pagoFormas').selectedIndex].innerHTML}`;
       parametros+=`&hiddenAntiguaFormaPago=${IDDoctoGlobal.FPago}`;
       parametros+=`&tipoImg_0=`;
       parametros+=`&datosExpres=${document.getElementById('datosExpres').value}`;
       parametros+=`&tipoActividad=${tipoActividad}`;
       parametros+=`&tipoRamo=${document.getElementById('tipoRamo').value}`;
       parametros+=`&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}`;
       parametros+=`&tipoCliente=Existente`;
       parametros+=`&IDCli=${clienteGlobal.IDCli}`;
       parametros+=`&IDCont=${clienteGlobal.IDCont}`;
       parametros+=`&IDDir=-1`;
       parametros+=`&IDAgente=${idVendedor}`;
       parametros+=`&IDGrupo=${clienteGlobal.IDGrupo}`;
       parametros+=`&tipoActividadSicas=tarea`;
       parametros+=`&TipoDocto=${IDDoctoGlobal.TipoDocto}`;
       parametros+=`&IDEjecut=${clienteGlobal.IDEjecut}`;
       parametros+=`&IDSRamo=${document.getElementById('tipoRamo1').value}`;
       parametros+=`&poliza=${IDDoctoGlobal.Documento}`;
       parametros+=`&IDDocto=${IDDoctoGlobal.IDDocto}`;
       parametros+=`&IDVend=${idVendedor}`;
       
      break;

      case 'Cancelacion':
        
        parametros=`datosExpres=${document.getElementById('datosExpres').value}`;
        parametros+=`&tipoActividad=${tipoActividad}`;        
        parametros+=`&tipoRamo=${document.getElementById('tipoRamo').value}`;
        parametros+=`&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}`;
        parametros+=`&tipoCliente=Existente`;
        parametros+=`&IDCli=${clienteGlobal.IDCli}`;
        parametros+=`&IDCont=${clienteGlobal.IDCont}`;
        parametros+=`&IDDir=-1`;
        parametros+=`&IDAgente=${idVendedor}`;
        parametros+=`&IDGrupo=${clienteGlobal.IDGrupo}`;
        parametros+=`&tipoActividadSicas=tarea`;
        parametros+=`&TipoDocto=${IDDoctoGlobal.TipoDocto}`;
        parametros+=`&IDEjecut=${clienteGlobal.IDEjecut}`;
        parametros+=`&IDSRamo=${document.getElementById('tipoRamo1').value}`;
        parametros+=`&IDUserR=6`;
        parametros+=`&IDTTarea=0`;
        parametros+=`&poliza=${IDDoctoGlobal.Documento}`;
        parametros+=`&IDDocto=${IDDoctoGlobal.IDDocto}`;
        parametros+=`&IDVend=${idVendedor}`;
        
       break;     
      case 'AclaraciondeComisiones':
   
        parametros=`IDVend=${idVendedor}&datosExpres=${document.getElementById('datosExpres').value}&tipoRamo=${document.getElementById('tipoRamo').value}&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}&tipoCliente=Existente&IDCli=${clienteGlobal.IDCli}&IDCont=${clienteGlobal.IDCont}&IDDir=-1&IDAgente=${idVendedor}&IDGrupo=${clienteGlobal.IDGrupo}&tipoActividadSicas=tarea&TipoDocto=&IDEjecut=${clienteGlobal.IDEjecut}&IDSRamo=${document.getElementById('tipoRamo1').value}`;
      break;
      case 'CapturaEmision':
        parametros=`rfcCliente=${document.getElementById('rfcFactura').value}&IDVend=${idVendedor}&datosExpres=${document.getElementById('datosExpres').value}&TipoEnt=${clienteGlobal.TipoEnt}&oldValueRFC=&tipoActividad=${tipoActividad}&tipoRamo=${document.getElementById('tipoRamo').value}&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}&tipoCliente=Existente&IDCli=${clienteGlobal.IDCli}&IDCont=${clienteGlobal.IDCont}&IDDir=${clienteGlobal.IDDirec}&IDAgente=${idVendedor}&IDGrupo=${clienteGlobal.IDGrupo}&tipoActividadSicas=ot&TipoDocto=0&IDEjecut=${clienteGlobal.IDEjecut}&IDSRamo=${document.getElementById('tipoRamo1').value}&polizaNew=${document.getElementById('polizaCpaturaEmisionInput').value}`;
        break;
        case 'Sustitucion':
        parametros=`IDVend=${idVendedor}&datosExpres=${document.getElementById('datosExpres').value}&tipoActividad=${tipoActividad}&tipoRamo=${document.getElementById('tipoRamo').value}&tipoSubRamo=${document.getElementById('tipoRamo1')[document.getElementById('tipoRamo1').selectedIndex].innerHTML}&tipoCliente=Existente&IDCli=${clienteGlobal.IDCli}&IDCont=${clienteGlobal.IDCont}&IDDir=-1&IDAgente=${idVendedor}&IDGrupo=${clienteGlobal.IDGrupo}&tipoActividadSicas=ot&TipoDocto=0&IDEjecut=${clienteGlobal.IDEjecut}&IDSRamo=${document.getElementById('tipoRamo1').value}&IDDocto=${IDDoctoGlobal.IDDocto}&poliza=${IDDoctoGlobal.Documento}`;
        break;        
    default:
      alert('ESCOGER UN TIPO DE ACTIVIDAD');return 0;
      break;
  }
  console.log(parametros);
  //parametros=`type=1&search=${document.getElementById('buscarPorPolizaText').value}`;
  peticionAJAX('actividades/crearActivdadesAsincrono',parametros,'respuestaCrear','');

})
function respuestaCrear(datos)
{
    fallaCrearActividad(datos.errorVacio);

}
function fallaCrearActividad(error)
{
  if(error.length>0){alert('Se detectaron algunos valores que no deben ser vacios')}
  let errorVacio=document.getElementsByClassName('errorVacio');
  let errorVacioTotal=errorVacio.length

  while (document.getElementsByClassName('errorVacio').length>0) 
  {
    let i=document.getElementsByClassName('errorVacio').length-1
    document.getElementsByClassName('errorVacio')[i].classList.remove('errorVacio')
  
  }
  for(let val of error){document.getElementById(errorParam[val]).classList.add('errorVacio');}

}

document.getElementById('selectTipoEndoso').addEventListener('change',function(){
  let comentario='';
  
  switch (document.getElementById('tipoActividad').value) 
  {
    case 'Endoso':
      comentario=`ENDOSO DE LA POLIZA: ${IDDoctoGlobal.Documento}`;
      if(this.value!='')
      {
       comentario=`ENDOSO DEL TIPO : ${this.value}\n` 
       if(IDDoctoGlobal.Documento){comentario=`ENDOSO DEL TIPO : ${this.value}\n ENDOSO DE LA POLIZA: ${IDDoctoGlobal.Documento}`;}   
      }
 
         break;
    case 'Sustitucion':
      comentario=`SUSTITUCION DE LA POLIZA: ${IDDoctoGlobal.Documento}`;
      break;
  
    default:
      break;
  }
  
  document.getElementById('datosExpres').value=comentario
 
}
)

const errorParam={IDCli:"nombreClienteDiv",datosExpres:"comentariosDiv",IDVend:"agentesDiv",rfcCliente:"datosDeFacturaDiv",polizaNew:"polizaCapturaEmisionDiv",poliza:"polizaDiv",cbCompania:"divEleccionCompania",SerieAuto:"serieClienteDiv"};

</script>
<script>
  
  <?php  
    if(isset($permitirRanking))
    {
        echo('var numeroPorRanking=new Array();');
        foreach ($permitirRanking as  $value) {echo('numeroPorRanking["'.$value->personaRankingAgente.'"]="'.$value->companiasPermitidasPRA.'";');
        }
    }
    ?>
/*
actividades/obtenerRamosPorActividad
polizas/BusquedaPolizas
actividades/traerDatosClienteRamo
actividades/devolverSubRamos/
actividades/obtenerCompaniaPorSubRamo/ 
actividades/crearActivdadesAsincrono
*/
<?$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($preferenciaContacto['preferenciaComunicacion'],TRUE));fclose($fp);?>
var p=<?=$preferenciaContacto['preferenciaComunicacion']?>;
</script>

<?php
function imprimirOptionPreferencias($array,$valor1)
{
  $option='<option value="-1">'.$valor1.'</option>';
  foreach ($array as $value) {$option.='<option>'.$value.'</option>';}
  return $option;
}

?>
