  
  <?php $this->load->view('generales/modalGenericoV3');?>

  <?

/*
PARA LLAMAR A LA VENTANA DE ALTA DENTRO DE LA VISTA DONDE SE UBICA TIENES QUE PASARLE EL VALOR DEL IDCLIENTE DE SICAS A LA VARIABLE GLOBAL idClienteTelEmailGeneralGloblal 
*/
 

  ?>
<style type="text/css">
  .tableAltaTeletonosCorreosGenerales > thead{position: sticky;top: 0px}
  .inputBotonDivATCGenerales{display: flex;flex-direction: row;border-left: solid;width: 30%;margin-left: 2px}
  .isbATCGenerales{display: flex;flex-direction: row;border-left: solid;width: 50%;margin-left: 2px}
  .isbATCGenerales select{flex: 4}
  .isbATCGenerales input{flex: 4}
  .isbATCGenerales button{flex: 1}
  .divContcontac{display: flex;width: 100%}
  .divContcontac>label{flex: 3;}
  .divContcontac>button{flex: 1}
  #contenidoModalGenericoV3{display: flex;flex-direction: column;}
  div[data-pf='1']{display: flex;flex-direction: column}
  div[data-pf='2']{flex:1;}
  div[data-pf='2']>button{width: 100%;border: 2px solid transparent;border-radius: 2px;color: #fff;background-color: #31b0d5;}
div[data-pf='2']>div{width:20px;height: 20px;position:relative;top: -10px;left:80%;}
div[data-pf='2']>div>img{position: relative;top: -15px;width: 30px;height: 25px}
  
  div[data-pf='3']{display: flex;flex-direction: column;}
  div[data-pf='3']>div{display: flex;flex-direction: row;}
  div[data-pf='3']>div>div{flex:1;flex-direction: column;}

</style>
<script type="text/javascript">
  function verHermanosATC(objeto)
  {
    let padre=objeto.parentNode;

    if(padre.nextElementSibling.style.display=='none'){padre.nextElementSibling.style.display='';padre.style.borderBottom=''}
    else{padre.nextElementSibling.style.display='none';padre.style.borderBottom='solid 10px white'}
  }
</script>
  <div class="modalGenericoContenidoV3" id="altaTelEmailGeneralesDiv">
    <div data-pf="1">
      <div data-pf="2"><button id="polizasPorRamoBotonPestania" name="pestaniamanejoATC" onclick="verHermanosATC(this)">POLIZAS POR RAMO</button><div title="LOS DATOS DE POLIZA POR RAMO ESTAN EN CARGA"><img id="polizasPorRamoEsperaImg" src="<?= base_url()?>assets/img/loading.gif"></div></div>
      <div><table class="table"><thead><tr><th>Lineas Personales</th><th>Vida</th><th>Daños</th><th>Vehiculos</th><th>Fianzas</th></tr></thead><tbody id="polizaRamoBodyATC"></tbody></table></div>
    </div>
    <div data-pf="1">
      <div data-pf="2"><button name="pestaniamanejoATC" id="datosClienteGeneralesBotonPestania" onclick="verHermanosATC(this)">DATOS DEL CLIENTE GENERALES</button><div title="LOS DATOS DEL CLIENTE GENERALES ESTAN EN CARGA"><img id="datosClienteGeneralesEsperaImg" src="<?= base_url()?>assets/img/loading.gif"></div> </div>
      <div data-pf="3">
         
        <div>
        <div><div><label>Entidad</label></div><div><select class="form-control altaTelCorreoDCGClass" id="entidadDCGATC" class="altaTelCorreoDCGClass" name=""><option value="1">Moral</option><option value="0">Fisica</option></select></div></div>
        <div><div><label>Ranking</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="rankingDCGATC" name=""></div></div>
        <div><div><label>Club Cap</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="clupCapitalDCGATC" name=""></div></div>
        <div><div><label>Poliza Verde</label></div><div><select   class="form-control altaTelCorreoDCGClass" id="polizaVerdeDCGATC" name=""><option value=''>NO</option><option value="POLIZA_VERDE">SI</option></select></div></div>
      </div> 
      <div>
                      <div><div><label>Nombre</label></div><div><input type="" class="form-control altaTelCorreoDCGClass" id="nombreDCGATC" name="altaTelCorreoDCG"></div></div>
        <div><div><label>Apellido Paterno</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="apellidoPaternoDCGATC" name="altaTelCorreoDCG"></div></div>
        <div><div><label>Apellido Materno</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="apellidoMaternoDCGATC" name="altaTelCorreoDCG"></div></div>
        <div><div><label>Sexo</label></div><div><select class="form-control altaTelCorreoDCGClass" id="sexoDCGATC" name=""><option value="0">Masculino</option><option value="1">Femenino</option></select></div></div>
        
      </div>  
      <div>
                      <div><div><label>Fecha Nacimiento y/o Constitucion</label></div><div><input type="date"  class="form-control altaTelCorreoDCGClass" id="fechaNacimientoDCGATC" name=""></div></div>
        <div><div><label>Edad  </label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="edadDCGATC" ></div></div>
        <div><div><label>Celular</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="celularDCGATC" name="altaTelCorreoDCG"></div></div>
        <div><div><label>RFC</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="rfcDCGATC" name="altaTelCorreoDCG"></div></div>

      </div>
      <div>
                      <div><div><label>Correo 1</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="correoDCGATC" name="altaTelCorreoDCG"></div></div>
                      <div><div><label>Razon Social</label></div><div><input type=""  class="form-control altaTelCorreoDCGClass" id="razonsocialDCGATC" name="altaTelCorreoDCG"></div></div>
                      <div><div></div><div><br><br><input id="actualizarInformacionContactoATCButton" value="&#128190" type="submit" name="" class="btn btn-primary btn-sm"  onclick="actualizarInformacionDeContactoATC('')"><input type="submit" id="escrituraInformacionContactoATCButton" value="&#9997" class="btn btn-primary btn-sm" onclick="habilitarEntradasGuardado()"></div></div>
                      
             <input type="hidden" name="" id="IDContDCGATC">

      </div> 

      </div>

    </div>
    <div data-pf="1">
      <div data-pf="2"><button id="direccionTelefonoBotonPestania" name="pestaniamanejoATC" onclick="verHermanosATC(this)">DIRECCIONES Y TELEFONOS</button><div title="LOS DATOS DE DIRECCION Y TELEFONOS ESTAN EN CARGA"><img id="direccionTelefonoEsperaImg" src="<?= base_url()?>assets/img/loading.gif"></div></div>
      <div data-pf="3">
        <table class="table"><thead><tr><th>Calle</th><th>No Ext</th><th>No Int</th><th>Codigo Postal</th><th>Colonia</th><th>Poblacion</th><th>Ciudad</th><th>Pais</th><th>Telefono</th><th>Telefono 2</th><th>Accion</th></tr></thead><tbody id="direccionTelefonoBodyATC"></tbody></table>
      </div>

    </div>
    <div data-pf="1">
      <div data-pf="2"><button id="preferenciaContactoBotonPestania" name="pestaniamanejoATC" style="/*background-image: url(<?=base_url()?>/assets/images/iconoMenuExpander.png)*/" onclick="verHermanosATC(this)">PREFERENCIA DE CONTACTO</button><div title="LOS DATOS DE PREFERENCIA DE CONTACTO ESTAN EN CARGA"><img id="preferenciaContactoEsperaImg" src="<?= base_url()?>assets/img/loading.gif"></div></div>
      <div data-pf="3">
        <div>
          <!--div><div><label>Telefono</label></div><div><input type="" name="" class="form-control" id="telefonoPCATC"></div></div>
         <div><div><label>Email</label></div><div><input type="" name="" class="form-control" id="emailPCATC"></div></div-->
         <div><div><label>Preferencia de comunicacion</label></div><div><select class="form-control" id="preferenciaComunicacionPCATC"><option value=""></option><option>SMS</option><option>Telefono</option><option>Correo</option><option>Whatsapp</option></select></div></div>
        </div>
        <div>
      <div><div><label>Horario de comunicacion</label></div><div><select class="form-control" id="horarioComunicacionPCATC"><option></option><option>Antes de la 9 am</option><option>De 9 a 11 am</option><option>De 12 a 3 pm</option><option>En las tardes 4 a 6 pm</option></select></div></div>
      <div><div><label>Dia para comunicarse</label></div><div><select class="form-control" id="diaComunicacionPCATC"><option></option><option>Lunes</option><option>Martes</option><option>Miercoles</option><option>Jueves</option><option>Viernes</option></select></div></div>
      <!--div><div><label>RFC</label></div><div><input type="" name="" class="form-control" id="rfcPCATC"></div></div-->
    </div>
      <!--div><div><div><label>MAS INFORMACION</label></div><div><input type="" name="" class="form-control" id="masInformacionPCATC"></div></div></div-->
      <div><div><div><label></label></div><div><input type="button" name="" class="btn btn-primary" value="Guardar" onclick="guardarPreferenciasDeContactoATC()"></div></div></div>
    </div>
    </div>
    <div data-pf="1">
      <div data-pf="2"><button id="preferenciasContactoParaPolizasBotonPestania" name="pestaniamanejoATC" onclick="verHermanosATC(this)">PREFERENCIAS DE CONTACTO PARA POLIZAS</button> <div title="LOS DATOS DE PREFERENCIA DE CONTACTO PARA POLIZA ESTAN EN CARGA"><img id="preferenciasContactoParaPolizasEsperaImg" src="<?= base_url()?>assets/img/loading.gif"></div></div>
      <div data-pf="3">    
    <div class="row">
      
      <div class="inputBotonDivATCGenerales"><input type="text" id="puestoEmpresaTelEmailGenerales" class="form-control" placeholder="AGREGAR UN NUEVO PUESTO"> <button class="btn btn-success" onclick="anexarPuesEmpTelEmailGenerales()" id="anexarPuesEmpTelEmailGeneralesBTN">&#128190</button></div>
      
      <div class="isbATCGenerales"><input type="text" id="nombreContactoTelEmailGenerales" class="form-control" placeholder="NOMBRE DEL CONTACTO"><select type="text" id="gerarquiaTelEmailGenerales" class="form-control"></select><button class="form-control" onclick="guardarNameContATCGenerales()" id="guardarNameContATCGeneralesBTN">&#128190</button></div>

  </div> 
  	 <div class="row">
      <div class="col-md-2 col-sm-2"><label>Nombre del Contacto</label><select id="nctSelectTEGenerales" class="form-control"></select></div>
  	 	<div class="col-md-2 col-sm-2"><label>Tipo Contacto</label><select id="tipoContactoTelEmailGenerales" class="form-control"><option value="1">TELEFONO</option><option value="2">CELULAR</option><option value="3">CORREO</option></select></div>
  	 	<div class="col-md-2 col-sm-2"><label>Telefono,Cel o Email</label><input type="text" id="contactoClienteTelEmailGenerales" class="form-control"></div>
  	 	<div class="col-md-2 col-sm-2"><label>Comentario</label><input type="text" id="comentarioTelEmailGenerales" class="form-control"></div>
     <!--div class="col-md-2 col-sm-2"><label>Puesto Empresarial</label></div-->

  	 	<div class="col-md-1 col-sm-1 col"><br><button class="btn btn-success" onclick="guardarTelEmailAltaTCGenerales('')" id="guardarTelEmailAltaTCGeneralesBTN">&#128190</button></div>

  	 </div>

     <hr>
  	 <div class="row" style="width: 95%;">
  	 	<div class="col-md-12 col-sm-12" style="width: 100%;height: 400px;overflow: scroll;" >
  	 		<table class="table tableAltaTeletonosCorreosGenerales">
  	 			<thead><tr><th>NOMBRE DEL CONTACTO</th><th>PUESTO EN EMPRESA</th><th>COMENTARIO</th><th>EMAIL</th><th>CELULAR</th><th>TELEFONO</th><th>BAJA</th></tr></thead>
  	 			<tbody id="bodyTablaAltaTCGenerales"></tbody>
  	 		</table>
  	 	</div>
  	 	
  	 </div>
  </div>
    </div>
  </div>

  <script type="text/javascript">
  var idClienteTelEmailGeneralGloblal='';
  var idIDDoctoGeneralGeneralGlobal='';
  function guardarPreferenciasDeContactoATC(datos='')
  {
    if(datos=='')
    {
      
      let params=`IDCli=${idClienteTelEmailGeneralGloblal}&preferenciaComunicacion=${document.getElementById('preferenciaComunicacionPCATC').value}&horarioComunicacion=${document.getElementById('horarioComunicacionPCATC').value}&diaComunicacion=${document.getElementById('diaComunicacionPCATC').value}&entidad=${document.getElementById('entidadDCGATC').value}&nombre=${document.getElementById('nombreDCGATC').value}&apellidoPaterno=${document.getElementById('apellidoPaternoDCGATC').value}&apellidoMaterno=${document.getElementById('apellidoMaternoDCGATC').value}&sexo=${document.getElementById('sexoDCGATC').value}&fechaNacimiento=${document.getElementById('fechaNacimientoDCGATC').value}&celular=${document.getElementById('celularDCGATC').value}&rfc=${document.getElementById('rfcDCGATC').value}&correo=${document.getElementById('correoDCGATC').value}&IDCont=${document.getElementById('IDContDCGATC').value}&TipoEnt=${document.getElementById('entidadDCGATC').value}`;
      controlador="directorio/actualizaInformacionContactoCLP/?";
      
      peticionAJAXLib(controlador,params,'guardarPreferenciasDeContactoATC');
      

    } 
    else
    {
      
    }     
  }
  function altaTelEmailGeneralesDivVer()
  {
       // sinPeticionAjax('altaTelEmailGeneralesDiv');
       if(idClienteTelEmailGeneralGloblal!='')
       {
        let params=`idCliente=${idClienteTelEmailGeneralGloblal}`;
        controlador="clientes/traerHistorialClientes/?";
        peticionAJAXLib(controlador,params,'traerHistorialClientes','altaTelEmailGeneralesDiv');
      }
      else
      {
        alert('ESCOGER UNA RENOVACION')
      }
  }


function traerTelEmailAltaTCGenerales()
{
     if(idClienteTelEmailGeneralGloblal!='')
     {
        let params=`IDCli=${idClienteTelEmailGeneralGloblal}&peticionAJAX=1`;
        controlador="cobranza/guardarContactoCliente/?";
        
        peticionAJAXLib('directorio/permisosAltaTelefonosCorreos','','permisosUsaurioAltaTelefonosCorreos');

        document.getElementById('preferenciasContactoParaPolizasBotonPestania').style.backgroundColor='#787373';
        document.getElementById('preferenciasContactoParaPolizasBotonPestania').disabled='true';
        document.getElementById('preferenciasContactoParaPolizasEsperaImg').style.display='block';
        peticionAJAXLib(controlador,params,'armarTablaEmailAltaTCGenerales','altaTelEmailGeneralesDiv');
        peticionAJAXLib('cobranza/anexarPuesEmpTelEmailGenerales','','agregarOpcionesPuestoEmpresaTCGenerales');
        peticionAJAXLib('cobranza/agregarNombreDelContactoParaEmpresa',params,'guardarNameContATCGenerales');


        document.getElementById('polizasPorRamoBotonPestania').style.backgroundColor='#787373';
        document.getElementById('polizasPorRamoBotonPestania').disabled='true';
        document.getElementById('polizasPorRamoEsperaImg').style.display='block';

        peticionAJAXLib('directorio/devuelveInformacionDeContacto',params,'preferenciasDeContactoATCGenerales');
        

        
        document.getElementById('datosClienteGeneralesBotonPestania').style.backgroundColor='#787373';
        document.getElementById('datosClienteGeneralesBotonPestania').disabled='true';
        document.getElementById('datosClienteGeneralesEsperaImg').style.display='block';
        document.getElementById('preferenciaContactoBotonPestania').style.backgroundColor='#787373';
        document.getElementById('preferenciaContactoBotonPestania').disabled='true';
        document.getElementById('preferenciaContactoEsperaImg').style.display='block';
        document.getElementById('direccionTelefonoBotonPestania').style.backgroundColor='#787373';
        document.getElementById('direccionTelefonoBotonPestania').disabled='true';
        document.getElementById('direccionTelefonoEsperaImg').style.display='block';
        peticionAJAXLib('directorio/registroDetalle',params,'registroSicasATC');
   }
   else
   {
    
   }

}
function preferenciasDeContactoATCGenerales(datos)
{
 
  let tbody='';
  tbody='<tr>';
  tbody+=`<td>${datos.polizas_ramo.Lp}</td>`;
  tbody+=`<td>${datos.polizas_ramo.Vi}</td>`;
  tbody+=`<td>${datos.polizas_ramo.Da}</td>`;
  tbody+=`<td>${datos.polizas_ramo.Ve}</td>`;
  tbody+=`<td>${datos.polizas_ramo.Fi}</td>`;
  tbody+='</tr>';
  
  document.getElementById('polizaRamoBodyATC').innerHTML=tbody;
          document.getElementById('polizasPorRamoBotonPestania').style.backgroundColor='';
        document.getElementById('polizasPorRamoBotonPestania').removeAttribute('disabled');
        document.getElementById('polizasPorRamoEsperaImg').style.display='none';


}

function armarTablaEmailAltaTCGenerales(datos)
{
  
  let row='';
  
  /*datos.informacion.forEach(i=>{
    let evento='cambiarTelefono';
    if(i.idTipoContacto==3){evento='cambiarCorreo'}
      if(i.nombrePuestoContacto==null){i.nombrePuestoContacto='';}
    row+=`<tr data-contacto="${i.contacto}" data-idcontacto="${i.idClienteLealtadTipoContacto}" data-idtipocontacto="${i.idTipoContacto}" data-nombrecontacto="${i.nombreContacto}" data-puesto="${i.nombrePuestoContacto}"><td>${i.nombreContacto}</td><td>${i.tipoContacto}</td><td>${i.contacto}</td><td>${i.comentario}</td><td>${i.nombrePuestoContacto}</td><td>${i.userEmail}</td><td><button class="btn btn-danger" onclick="bajaContactoCliente(${i.idClienteLealtadTipoContacto})">&#9940</button></td></tr>`;
  })*/

   let row2='';
   let cant=datos.datosAgrupados.length;
   for(var i=0 in datos.datosAgrupados)
   {  

      row2+=`<tr><td>${datos.datosAgrupados[i].nombreContacto}</td><td>${datos.datosAgrupados[i].nombrePuestoContacto}</td><td>${datos.datosAgrupados[i].comentario}</td>`;
      let cel='';
      let correo='';
      let tel='';
      if(datos.datosAgrupados[i].Correo)
        {
           for(var j=0 in datos.datosAgrupados[i].Correo)
           {
               correo+=`<div class="divContcontac"><label>${datos.datosAgrupados[i].Correo[j].Contacto}</label><butto class="btn btn-danger" onclick="bajaContactoCliente('',${datos.datosAgrupados[i].Correo[j].idClienteLealtadTipoContacto})">&#9940</button></div><br>`;
           }
          
        }
        if(datos.datosAgrupados[i].Celular)
        {
           for(var j=0 in datos.datosAgrupados[i].Celular)
           {
               cel+=`<div class="divContcontac"><label>${datos.datosAgrupados[i].Celular[j].Contacto}</label><butto class="btn btn-danger" onclick="bajaContactoCliente('',${datos.datosAgrupados[i].Celular[j].idClienteLealtadTipoContacto})">&#9940</button></div><br>`;
           }
          
        }


        if(datos.datosAgrupados[i].Telefono)
        {
           for(var j=0 in datos.datosAgrupados[i].Telefono)
           {
               tel+=`<div class="divContcontac"><label>${datos.datosAgrupados[i].Telefono[j].Contacto}</label><butto class="btn btn-danger" onclick="bajaContactoCliente('',${datos.datosAgrupados[i].Telefono[j].idClienteLealtadTipoContacto})">&#9940</button></div><br>`;
           }
          
        }

        
        row2+=`<td>${correo}<div><br></td>`;  
       row2+=`<td><div>${cel}<div><br></td>`;  
       row2+=`<td><div>${tel}<div><br></td>`;  

   }

  document.getElementById('bodyTablaAltaTCGenerales').innerHTML=row2;
          document.getElementById('preferenciasContactoParaPolizasBotonPestania').style.backgroundColor='';
        document.getElementById('preferenciasContactoParaPolizasBotonPestania').removeAttribute('disabled');
        document.getElementById('preferenciasContactoParaPolizasEsperaImg').style.display='none';
}
function anexarPuesEmpTelEmailGenerales(datos='')
{
  if(datos=='')
  {
    if(document.getElementById('puestoEmpresaTelEmailGenerales').value!='')
    {
     let params=`nombrePuesto=${document.getElementById('puestoEmpresaTelEmailGenerales').value}`;
     controlador="cobranza/anexarPuesEmpTelEmailGenerales/?";
     peticionAJAXLib(controlador,params,'anexarPuesEmpTelEmailGenerales');
    }
    else{alert('AGREGAR UN PUESTO')}
  }
 else
 {
  alert(datos.mensaje);
  let option='<option></option>';
  datos.nombrePuesto.forEach(n=>{option+=`<option>${n.contactoPuesto}</option>`});
  document.getElementById('gerarquiaTelEmailGenerales').innerHTML=option;
  document.getElementById('gerarquiaTelEmailGenerales').value=datos.contactoPuesto;
 }
}
function agregarOpcionesPuestoEmpresaTCGenerales(datos='')
{
 let option='<option></option>';
  datos.nombrePuesto.forEach(n=>{option+=`<option>${n.contactoPuesto}</option>`});
  document.getElementById('gerarquiaTelEmailGenerales').innerHTML=option;
  document.getElementById('gerarquiaTelEmailGenerales').value=datos.contactoPuesto;
}

function guardarNameContATCGenerales(datos='')
{
 if(datos=='')
 {
  let name=document.getElementById('nombreContactoTelEmailGenerales').value;
  let puesto=document.getElementById('gerarquiaTelEmailGenerales').value;
  if(name!='' && puesto!='' )
  {
     let params=`nombreContacto=${name}&nombrePuesto=${puesto}&IDCli=${idClienteTelEmailGeneralGloblal}`;
     controlador="cobranza/agregarNombreDelContactoParaEmpresa/?";
     peticionAJAXLib(controlador,params,'guardarNameContATCGenerales');
  }
  else{alert('PARA AGREGAR UN CONTACTO ESCRIBA EL NOMBRE Y ESCOGER EL PUESTO')}
 }
 else
 {
  if(datos.mensaje){alert(datos.mensaje)};
  
  let option='<option></option>';
  datos.informacion.forEach(i=>{option+=`<option value="${i.nombreContacto}">${i.nombreContacto}(${i.nombrePuesto})</option>`})
  document.getElementById('nctSelectTEGenerales').innerHTML=option;

 }
}
function bajaContactoCliente(datos='',id=0)
{
  if(datos=='')
  {
    let params=`IDCli=${idClienteTelEmailGeneralGloblal}&idClienteLealtadTipoContacto=${id}&delete=1`;
    controlador="cobranza/guardarContactoCliente/?";
    peticionAJAXLib(controlador,params,'bajaContactoCliente');
  }
  else
  {
    if(datos.mensaje){alert(datos.mensaje);}
    if(datos.success)
    {
      document.getElementById('contactoClienteTelEmailGenerales').value='';
      document.getElementById('comentarioTelEmailGenerales').value='';
      
    }
    armarTablaEmailAltaTCGenerales(datos);

  }

  
}


function guardarTelEmailAltaTCGenerales(datos='')
{
   if(datos=='')
   {

     let params='IDCli='+idClienteTelEmailGeneralGloblal;
     params+='&tipoContacto='+document.getElementById('contactoClienteTelEmailGenerales').value;
     params+='&tipoContactoID='+document.getElementById('tipoContactoTelEmailGenerales').value;     
     params+='&comentario='+document.getElementById('comentarioTelEmailGenerales').value;
     params+='&nombreContacto='+document.getElementById('nctSelectTEGenerales').value;
     //params+='&nombrePuestoOcupado='+document.getElementById('gerarquiaTelEmailGenerales').value;
     controlador="cobranza/guardarContactoCliente/?";
     peticionAJAXLib(controlador,params,'guardarTelEmailAltaTCGenerales');
   
   }
  else
   {
    if(datos.mensaje){alert(datos.mensaje);}
    if(datos.success)
    {
      document.getElementById('contactoClienteTelEmailGenerales').value='';
      document.getElementById('comentarioTelEmailGenerales').value='';
      
    }
    armarTablaEmailAltaTCGenerales(datos);
   }
}
function registroSicasATC(datos='')
{
  

    let tipoEntidad=0;
  //if(datos.contactos[0].tipoEntidad=='Moral'){tipoEntidad=1;}
  document.getElementById('entidadDCGATC').value=datos.ClienteContact.cliente.TipoEnt;
  document.getElementById('entidadDCGATC').dataset.oldvalue=datos.ClienteContact.cliente.TipoEnt;
 
  document.getElementById('rankingDCGATC').value=datos.ClienteContact.cliente.Calidad;
  document.getElementById('rankingDCGATC').dataset.oldvalue=datos.ClienteContact.cliente.Calidad;
 
  document.getElementById('clupCapitalDCGATC').value=(datos.ClienteContact.cliente.Expediente)? datos.ClienteContact.cliente.Expediente : '';
  document.getElementById('clupCapitalDCGATC').dataset.oldvalue=(datos.ClienteContact.cliente.Expediente)? datos.ClienteContact.cliente.Expediente : '';

 
  document.getElementById('polizaVerdeDCGATC').value=(datos.ClienteContact.cliente.ClaveTKM=='POLIZA_VERDE')? datos.ClienteContact.cliente.ClaveTKM : '';
  document.getElementById('polizaVerdeDCGATC').dataset.oldvalue=(datos.ClienteContact.cliente.ClaveTKM=='POLIZA_VERDE')? datos.ClienteContact.cliente.ClaveTKM : '';
 
  document.getElementById('nombreDCGATC').value=(datos.ClienteContact.cliente.Nombre)? datos.ClienteContact.cliente.Nombre : '';
  document.getElementById('nombreDCGATC').dataset.oldvalue=(datos.ClienteContact.cliente.Nombre)? datos.ClienteContact.cliente.Nombre : '';
 
  document.getElementById('apellidoPaternoDCGATC').value=(datos.ClienteContact.cliente.ApellidoP)? datos.ClienteContact.cliente.ApellidoP : '';
  document.getElementById('apellidoPaternoDCGATC').dataset.oldvalue=(datos.ClienteContact.cliente.ApellidoP)? datos.ClienteContact.cliente.ApellidoP : '';
 
  document.getElementById('apellidoMaternoDCGATC').value=(datos.ClienteContact.cliente.ApellidoM)? datos.ClienteContact.cliente.ApellidoM : '';
 document.getElementById('apellidoMaternoDCGATC').dataset.oldvalue=(datos.ClienteContact.cliente.ApellidoM)? datos.ClienteContact.cliente.ApellidoM : '';
 


  document.getElementById('sexoDCGATC').value=datos.ClienteContact.cliente.Sexo;
  document.getElementById('sexoDCGATC').dataset.oldvalue=datos.ClienteContact.cliente.Sexo;
  let fechaNac='';
   if(datos.ClienteContact.cliente.FechaNac){fechaNac=datos.ClienteContact.cliente.FechaNac.split('T');}
   else{if(datos.ClienteContact.cliente.FechaConst){fechaNac=datos.ClienteContact.cliente.FechaConst.split('T');}}
  
  document.getElementById('fechaNacimientoDCGATC').value=fechaNac[0];  
  document.getElementById('fechaNacimientoDCGATC').dataset.oldvalue=fechaNac[0];  
 
  document.getElementById('celularDCGATC').value=datos.ClienteContact.cliente.Telefono1;
  document.getElementById('celularDCGATC').dataset.oldvalue=datos.ClienteContact.cliente.Telefono1;
 
  document.getElementById('IDContDCGATC').value=datos.ClienteContact.cliente.IDCont;
 //document.getElementById('IDContDCGATC').dataset.oldvalue=datos.ClienteContact.cliente.IDCont;
 //document.getElementById('IDContDCGATC').dataset.newvalue='';

  if(datos.ClienteContact.cliente.RFC)
  {
   (typeof(datos.ClienteContact.cliente.RFC)=='object')? datos.ClienteContact.cliente.RFC='':document.getElementById('rfcDCGATC').value=datos.ClienteContact.cliente.RFC;

   document.getElementById('rfcDCGATC').dataset.oldvalue=document.getElementById('rfcDCGATC').value;
  }
  else
  {
   document.getElementById('rfcDCGATC').dataset.oldvalue=''; 
  }

  (typeof(datos.ClienteContact.cliente.EMail1)=='object')? document.getElementById('correoDCGATC').value='':document.getElementById('correoDCGATC').value=datos.ClienteContact.cliente.EMail1;

document.getElementById('correoDCGATC').dataset.oldvalue=document.getElementById('correoDCGATC').value;


  (typeof(datos.ClienteContact.cliente.RazonSocial)=='object')? document.getElementById('razonsocialDCGATC').value='':document.getElementById('razonsocialDCGATC').value=datos.ClienteContact.cliente.RazonSocial;
  
document.getElementById('razonsocialDCGATC').dataset.oldvalue=document.getElementById('razonsocialDCGATC').value;


  document.getElementById('edadDCGATC').value=datos.ClienteContact.cliente.Edad;
  let rowBody="";
  
   datos.direccionesContacto.forEach(d=>{
    rowBody+=`<tr><td>${d.Calle}</td><td>${d.IDDir}</td><td></td><td>${d.CPostal}</td><td>${d.Colonia}</td><td>${d.Poblacion}</td><td>${d.Ciudad}</td><td>${d.Pais}</td><td></td><td></td><td></td></tr>`})
   document.getElementById('direccionTelefonoBodyATC').innerHTML=rowBody;
   document.getElementById('preferenciaComunicacionPCATC').value=datos.formasContacto.preferenciaComunicacion;
   document.getElementById('horarioComunicacionPCATC').value=datos.formasContacto.horarioComunicacion;
   document.getElementById('diaComunicacionPCATC').value=datos.formasContacto.diaComunicacion;
 

   document.getElementById('datosClienteGeneralesEsperaImg').style.display='none';
           document.getElementById('datosClienteGeneralesBotonPestania').style.backgroundColor='';
        document.getElementById('datosClienteGeneralesBotonPestania').removeAttribute('disabled');

        document.getElementById('preferenciaContactoBotonPestania').style.backgroundColor='';
        document.getElementById('preferenciaContactoBotonPestania').removeAttribute('disabled');
        document.getElementById('preferenciaContactoEsperaImg').style.display='none';        


        document.getElementById('direccionTelefonoBotonPestania').style.backgroundColor='';
        document.getElementById('direccionTelefonoBotonPestania').removeAttribute('disabled');
        document.getElementById('direccionTelefonoEsperaImg').style.display='none';  
}

  function actualizarInformacionDeContactoATC(datos='')
  {
    if(datos=='')
    {
      let cadena='';
      let cadenaOldValue='';
      let cadenaObjeto=Array.from(document.getElementsByName("altaTelCorreoDCG"));
      cadenaObjeto.forEach(c=>{
        if(c.dataset.oldvalue!=c.value)
          {
            cadena+=`&${c.id}=${c.value}`;
            cadenaOldValue+=`"${c.id}":"${c.dataset.oldvalue}",`;
          }
      })
      if(cadena!='')
      {
        let cadenaOV = cadenaOldValue.substring(0, cadenaOldValue.length - 1);
      let params=`IDCont=${document.getElementById('IDContDCGATC').value}&IDCli=${idClienteTelEmailGeneralGloblal}${cadena}&oldValue={${cadenaOV}}`;
      controlador="directorio/actualizaInformacionClienteSicas/?";
       
          peticionAJAXLib(controlador,params,'actualizarInformacionDeContactoATC');
      }
      else{alert('NO EXISTEN CAMBIOS PARA REALIZAR')}

    } 
    else
    {
      
      for (const property in datos.objetos) 
      {
        if(property!='IDCont' && property!='IDCli'){ document.getElementById(property).dataset.oldvalue=datos.objetos[property];}

      }
      inhabilitarEntradasGuardado();
    }     
  }

function inhabilitarEntradasGuardado()
{
 let guardardoParaClientesSicas=Array.from(document.getElementsByClassName('altaTelCorreoDCGClass')) ;
   guardardoParaClientesSicas.forEach(g=>{g.disabled=true})

}

function habilitarEntradasGuardado()
{
 let guardardoParaClientesSicas=Array.from(document.getElementsByName('altaTelCorreoDCG')) ;
   guardardoParaClientesSicas.forEach(g=>{g.removeAttribute('disabled')})

}

function permisosUsaurioAltaTelefonosCorreos(datos='')
{
  console.log(datos)
  if(!datos.permisoGuardar)
  {
    document.getElementById('escrituraInformacionContactoATCButton').parentNode.removeChild(document.getElementById('escrituraInformacionContactoATCButton'));

    document.getElementById('actualizarInformacionContactoATCButton').parentNode.removeChild(document.getElementById('actualizarInformacionContactoATCButton'));
  }
}

 let ocultarInicionATC=Array.from(document.getElementsByName("pestaniamanejoATC"));
 ocultarInicionATC.forEach(o=>{verHermanosATC(o);})

inhabilitarEntradasGuardado();

  </script>}

<style type="text/css">
  
  .form-control{width: 95%}
</style>
