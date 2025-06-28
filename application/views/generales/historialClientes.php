<?php $this->load->view('generales/modalGenericoV3');?>
<div class="modalGenericoContenidoV3" id="divHistorialClientes">
   <div style="display:flex; ">
        <div class="ContendorbotonesHC"><div onclick="verVistaHistorial('historialActividadesVistaDiv')" >Actividades</div><div onclick="verVistaHistorial('historialCorreosVistaDiv')">Historia de Envios</div><div onclick="verVistaHistorial('historialRenovacionesVistaDiv')" style="display: none">Renovacion</div></div>
        <div class="contenedorPestaniasHC"><div id="historialActividadesVistaDiv" class="vistaPestaniasHistorial pestaniaHistoriaCliente"><div style="display:flex;flex-direction:column"><h3>ACTIVIDADES DEL CLIENTE</h3><hr></div><div style="display:flex; "><div style="flex:2; height: 400px;overflow: scroll;"><table class="table"><thead><tr><th>FOLIO ACTIVIDAD</th><th>TIPO ACTIVIDAD</th><th>RAMO</th><th>SUBRAMO</th><th>FECHA CREACION</th></tr></thead><tbody id="historiaActividadesTBody"></tbody></table></div><div id="muestraComentarioActividadID" style="border: solid;margin-left: 5%;overflow: scroll;height: 300px; flex: 1"></div></div></div><div id="historialCorreosVistaDiv" class="vistaPestaniasHistorial pestaniaHistoriaCliente"><h3>HISTORIAL DE CORREOS</h3><hr><div><table class="table"><thead><tr><th>DOCUMENTO</th><th>DE</th><th>PARA</th><th>TIPO DE ENVIO</th><th>DOCUMENTO</th><th>ESTATUS</th><th>FECHA</th></tr></thead><tbody id="historialEnvioTbody"></tbody></table></div></div><div id="historialRenovacionesVistaDiv" class="vistaPestaniasHistorial pestaniaHistoriaCliente"><h3>HISTORIAL DE RENOVACIONES</h3><hr></div></div>;
      </div>
  </div>


<script type="text/javascript">
  function verVistaHistorial(vista='')
  {
    let pestania=Array.from(document.getElementsByClassName('pestaniaHistoriaCliente'));    
  pestania.forEach(p=>{
    p.classList.add('vistaPestaniasHistorial');
  })  
  document.getElementById(vista).classList.remove('vistaPestaniasHistorial');
  }
   function  traerHistorialClientes(datos='',idCliente,idDiv='')
   {
     if(datos=='')
     {
       let params=`idCliente=${idCliente}`;
      controlador="clientes/traerHistorialClientes/?";
      peticionAJAXLib(controlador,params,'traerHistorialClientes','divHistorialClientes');
    }
     else
     {
      console.log(datos)

      let body='';
      let bodyCH='';
      datos.actividades.forEach(a=>{
        body+=`<tr onclick="escogerRowActividadesHistoria('',this)" data-clavebit="${a.ClaveBit}" data-idinterno="${a.idInterno}" data-folioactividad="${a.folioActividad}"><td>${a.folioActividad}</td><td>${a.tipoActividad}</td><td>${a.ramoActividad}</td><td>${a.subRamoActividad}</td><td>${a.fechaCreacion}</td></tr>`;
      })
       datos.historialEnvio.forEach(h=>{
        bodyCH+=`<tr><td>${h.documento}</td><td>${h.email}</td><td>${h.envioDestinoCH}</td><td>${h.tipoEnvioCH}</td>`;
        h.hRefCH==''?bodyCH+=`<td></td>`:bodyCH+=`<td><a href="${h.hRefCH}" target="_blank">DOCUMENTO</a></td>`;
        bodyCH+=`<td>${h.comentarioDelEnvio}</td><td>${h.fechaCreacion}</td>`;
       })
      document.getElementById('historiaActividadesTBody').innerHTML=body;
      document.getElementById('historialEnvioTbody').innerHTML=bodyCH;

     }


   }
   function escogerRowActividadesHistoria(datos='',objeto='')
   {
    if(datos=='')
    {
      let params=`idInterno=${objeto.dataset.idinterno}&folioActividad=${objeto.dataset.folioactividad}&ClaveBit=${objeto.dataset.clavebit}`;
      controlador="clientes/obtenerComentariosActividades/?";
      peticionAJAXLib(controlador,params,'escogerRowActividadesHistoria','');
    }
    else
    {
      console.log(datos.verBitacoraActividad)
      let div=''
         datos.verBitacoraActividad.forEach(v=>{
          console.log(v.Comentario);
           div+=`<div>${v.Comentario}<br>${v.FechaHora}<hr></div>`;
         })
         document.getElementById('muestraComentarioActividadID').innerHTML=div;
    }

   }
   verVistaHistorial('historialActividadesVistaDiv');
</script>
<style type="text/css">
   .ContendorbotonesHC{display:flex;flex-direction:column;flex: 1}   
  .ContendorbotonesHC div{border: solid;color: white;background-color: #14064ed9;height: 30px}
  .ContendorbotonesHC div:hover{background-color:#a59d44;cursor: pointer;text-decoration: underline;}
  .vistaPestaniasHistorial{display: none}
  .contenedorPestaniasHC{flex: 6}
  tbody[id^='historiaActividadesTBody'] tr:hover{color: white;cursor:pointer;background-color: #b3a7a7}
</style>