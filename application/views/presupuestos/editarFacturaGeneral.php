<div class="edicionFactura">
  <div>
    <div>
      <div><label>Apertura</label></div>
      <div><input type="text" id="idAperturaEFG" class="form-control" disabled=""></div>
    </div>
    <div>
      <div><label>Sucursal</label></div>
      <div>
        <select class="form-control" id="sucursalEFG">
          <option value="">Seleccione una opcion</option>
          <option value="MERIDA">MERIDA</option>
          <option value="NORTE">NORTE</option>
          <option value="CANCUN">CANCUN</option>
        </select>
      </div>
    </div>
    <div>
      <div><label>Tarjeta( escoger si es necesario)</label></div>
      <div><select class="form-control" id="tarjetasEFG"></select></div>
    </div>
    <div>
      <div><label>Proveedor</label></div>
      <div><select id="proveedorEFG" class="form-control"></select></div>
    </div>
  </div>

  <div>
    <div>
      <div><label>Cuentas Contables</label></div>
      <div><select id="cuentaContableEFG" class="form-control" onchange="calculaPagoPorCanalEFG()"></select></div>
    </div>
    <div>
      <div><label>Forma de pago</label></div>
      <div><select id="formaDePagoEFG" class="form-control"></select></div>
    </div>
  </div>

  <div>
    <div>
      <div><label>Folio de factura</label></div>
      <div><input type="text" id="folioFacturaEFG" name="" class="form-control"></div>
    </div>
    <div>
      <div><label>Fecha de Factura o Documento o Fecha Ingreso:</label></div>
      <div><input id="fechaFacturaEFG" type="date" name="" class="form-control"></div>
    </div>
  </div>

  <div>
    <div>
      <div><label>Concepto</label></div>
      <div><input type="text" id="conceptoEFG" name="" class="form-control"></div>
    </div>
    <div>
      <div><label>Subtotal</label></div>
      <div>
        <input value="0.00" type="text" id="subTotalEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="calculaPagoPorCanalEFG()">
      </div>
    </div>
  </div>

  <div>
    <div>
      <div><label>Cargo Fianzas</label></div>
      <div>
        <input type="text" value='0.00' id="cargoFianzasEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="sumaEFG()">
      </div>
    </div>
    <div>
      <div><label>Cargo Institucional</label></div>
      <div>
        <input value='0.00' type="text" id="cargoInstitucionalEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="sumaEFG()">
      </div>
    </div>
    <div>
      <div><label>Cargo Coorporativo</label></div>
      <div>
        <input value='0.00' type="text" id="cargoCoorporativoEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="sumaEFG()">
      </div>
    </div>
    <div>
      <div><label>Cargo Asesores</label></div>
      <div>
        <input value='0.00' type="text" id="cargoAsesoresEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="sumaEFG()">
      </div>
    </div>

    <div id="cargosEspecialesDivEFG" class="ocultarObjetoEFG">
      <div><label>Cargos Especiales</label></div>
      <div style="display: flex;flex-direction: row;">
        <div>
          <input value='0.00' type="text" id="cargoEspecialesEFG" name="" class="form-control" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" onchange="sumaEFG()" disabled>
        </div>
        <div><button class="btn btn-info" id="mostrarGastosEspecialesBTN">+</button></div>
      </div>

      <div>
        <div id="gastosEspecialesEFG" style="display: none">
          <div>
            <div><label>GASTOS CCC</label></div>
            <div><input value="0.00" type="text" id="gastosCCCEDF" name="" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></div>
          </div>
          <div>
            <div><label>GASTOS CCO</label></div>
            <div><input value="0.00" type="text" id="gastosCCOEDF" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></div>
          </div>
          <div>
            <div><label>INVERSIONES</label></div>
            <div><input value="0.00" type="text" id="gastosInversionesEDF" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></div>
          </div>
          <div>
            <div><label>ESTRATEGIA</label></div>
            <div><input value="0.00" type="text" id="gastosEstrategiaEDF" onkeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"></div>
          </div>
          <div style="display: flex;justify-content: center">
            <button id="guardarGastosEspecialesBTN" class="btn btn-success" onclick="sumaGastosEspecialesEFG()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div>
    <div style="flex: 1">
      <div><label>Motivo del cambio</label></div>
      <div><input type="text" id="motivoCambioEDF" class="form-control"></div>
    </div>
  </div>

  <div>
    <div>
      <div><label>Tipo de gasto</label></div>
      <div>
        <select id="tipoDeGastoEFG" class="form-control">
          <option value='1'>Operacional</option>
          <option value='2'>Nomina</option>
          <option value='3'>Fijo</option>
        </select>
      </div>
    </div>
    <div>
      <div><label>Total a pagar</label></div>
      <div><input value="0.00" type="text" id="totalDePagoEFG" name="" class="form-control"></div>
    </div>
    <div>
      <div></div>
      <div><button class="btn btn-primary" id="guardarEFG_BTN">&#128190</button></div>
    </div>
  </div>
</div>

<div class="gifEspera ocultarObjetoEFG" id="gifDeEsperaModalEFG">
  <img src="<?php echo(base_url().'assets\img\loading.gif')?>">
</div>



<style type="text/css">
	.edicionFactura{display: flex;flex-direction: column;flex-wrap: wrap;margin-left: 5%}
	.edicionFactura div{display: flex;margin-right: 5%}
	.edicionFactura div>div{display: flex;flex-direction: column;}
	#guardarEFG_BTN{vertical-align: middle;margin-top: 50%}
  #gastosEspecialesEFG{border: solid;color: black;background-color: #39b2ec}
  #gastosEspecialesEFG>div{display: flex;flex-direction: row;justify-content: space-between;margin-top: 10px}
  .gifEspera{position: fixed;left: 50%;top:50%;z-index: 100000}
  .ocultarObjetoEFG{display: none}
  
 </style>
<script type="text/javascript">
/*
 AL BOTON guardarEFG_BTN le debes pasar  actualizarDatosFacturaEFG con el nombre de la funcion que va a reibir los datos
  guardarEFG_BTN.addEventListener('click',function(){
  actualizarDatosFacturaEFG(nombreFuncion)
});
*/



let idFacturaGlobalEFG='';
let funcionExternaEFG='';
document.getElementById('mostrarGastosEspecialesBTN').addEventListener("click",desplegarGastosEspeciales)
document.getElementById('guardarGastosEspecialesBTN').addEventListener("click",desplegarGastosEspeciales)
function manejoGifEFG(){document.getElementById('gifDeEsperaModalEFG').classList.toggle('ocultarObjetoEFG');}
function desplegarGastosEspeciales()
{
    if(document.getElementById('gastosEspecialesEFG').style.display=='none'){document.getElementById('gastosEspecialesEFG').style.display='block'}
  else{document.getElementById('gastosEspecialesEFG').style.display='none'}
}


 function obtenerDatosParaFacturar(datos='')
{
 if(datos=='')
 {
   let params=``;
   controlador="presupuestos/datosParaFacturar/?";
   peticionAJAXEFG(controlador,params,'obtenerDatosParaFacturar');
 }
 else
 {
   let proveedores=datos.proveedores;
   let tarjetas=datos.tarjetas;
   let formaPago=datos.permisosFormaPago;
   let cuentaContable=datos.cuentasPorDepartamento;
   let proveedorOption='';
   let optionTarjeta='';
   let optionFormaPago;
   let optionCuentaContable='';
   for(let proveedor of proveedores){proveedorOption+=`<option value="${proveedor.id}">${proveedor.NombreProveedor}</option>`;}
   optionTarjeta='<option value="0">TARJETAS ASIGNADAS</option>';
   for(let tarjeta of tarjetas)
   {
   	if(tarjeta.esTarjetaEspecial==1){optionTarjeta+=`<option value="${tarjeta.idTarjetas}" data-especial="${tarjeta.esTarjetaEspecial}">${tarjeta.numeroTarjeta}</option>`;}
    else{optionTarjeta+=`<option value="${tarjeta.idTarjetas}" data-especial="${tarjeta.esTarjetaEspecial}">${tarjeta.numeroTarjeta}(${tarjeta.formaPago})</option>`;}
   }
   optionFormaPago='<option></option>'
   for(let pago of formaPago){optionFormaPago+=`<option value="${pago.idFormaPago}">${pago.formaPago}</option>`}

  /*for(let cuentaDepartamento in cuentaContable)
  {
    cuentaDepartamento.forEach(val=>{
     cl(val)
    })
  }*/
Object.keys(cuentaContable).forEach(key => {
  optionCuentaContable+=`<optgroup label="${key}">`
  let val=Object.values(cuentaContable[key])
  for(let i=0; i< val.length; i++){
optionCuentaContable+=`<option value="${val[i].idCuentaContable}" data-fianzasPorcentaje="${val[i].fianzasPorcentaje}" data-institucionalPorcentaje="${val[i].institucionalPorcentaje}" data-coorporativoPorcentaje="${val[i].coorporativoPorcentaje}" data-gestionPorcentaje="${val[i].gestionPorcentaje}" data-asesoresPorcentaje="${val[i].asesoresPorcentaje}" data-montomes="${val[i].montoMes}" data-autorizadomes="${val[i].autorizadoMes}">${val[i].cuentaContable}</option>`;
}
optionCuentaContable+=`</optgroup>`
  /*cuentaContable[key].forEach(val=>{
    console.log(val)
  })
  optionCuentaContable+=`<optgroup label="${key}">`


  optionCuentaContable+=`<option value="${val.idCuentaContable}" data-fianzasPorcentaje="${val.fianzasPorcentaje}" data-institucionalPorcentaje="${val.institucionalPorcentaje}" data-coorporativoPorcentaje="${val.coorporativoPorcentaje}" data-gestionPorcentaje="${val.gestionPorcentaje}" data-asesoresPorcentaje="${val.asesoresPorcentaje}" data-montomes="${val.montoMes}" data-autorizadomes="${val.autorizadoMes}">${val.cuentaContable}</option>`;

  optionCuentaContable+=`<option value="${cuentaContable.key.idCuentaContable}" data-fianzasPorcentaje="${cuentaContable[key].fianzasPorcentaje}" data-institucionalPorcentaje="${cuentaContable[key].institucionalPorcentaje}" data-coorporativoPorcentaje="${cuentaContable[key].coorporativoPorcentaje}" data-gestionPorcentaje="${cuentaContable[key].gestionPorcentaje}" data-asesoresPorcentaje="${cuentaContable[key].asesoresPorcentaje}" data-montomes="${cuentaContable[key].montoMes}" data-autorizadomes="${cuentaContable[key].autorizadoMes}">${cuentaContable[key].cuentaContable}</option>`
  optionCuentaContable+=`</optgroup>`*/

})

   document.getElementById('idAperturaEFG').value=datos.Apertura	;		
   document.getElementById('proveedorEFG').innerHTML=proveedorOption;	
   document.getElementById('tarjetasEFG').innerHTML=optionTarjeta;	
   document.getElementById('formaDePagoEFG').innerHTML=optionFormaPago;
   document.getElementById('cuentaContableEFG').innerHTML=optionCuentaContable;

 }



}	


function calculaPagoPorCanalEFG()
{
  let subtotal=document.getElementById('subTotalEFG');
  let select=document.getElementById('cuentaContableEFG');
  let option= select.options[select.selectedIndex];
 /* document.getElementById('motivoCambioPorcentajeDiv').classList.add('verOcultar')
  document.getElementById('motivoCambioPorcentajeInput').value='';*/
 if(subtotal.value>0)
   {
    //cargosManejoVista(false)
    let fianzas=option.getAttribute('data-fianzasporcentaje');
    let institucional=option.getAttribute('data-institucionalPorcentaje');
    let coorporativo=option.getAttribute('data-coorporativoPorcentaje');
    let gestion=option.getAttribute('data-gestionPorcentaje');
    let asesores=option.getAttribute('data-asesoresPorcentaje');
    let montoFianzas=0.00;
    let montoInstitucional=0.00;
    let montoCoorporativo=0.00;
    let montoGestion=0.00;
    let montoAsesores=0.00;
      /*  document.getElementById('spanCargoFianzas').innerHTML=fianzas+'%';
    document.getElementById('spanCargoSeguros').innerHTML=institucional+'%';
    document.getElementById('spanCargoCoorporativo').innerHTML=coorporativo+'%';
    document.getElementById('spanCargoAsesores').innerHTML=asesores+'%';
    document.getElementById('spanCargoEspeciales').innerHTML=gestion+'%';*/
    if(fianzas>0){montoFianzas=(fianzas*subtotal.value)/100;}

    if(institucional>0){montoInstitucional=(institucional*subtotal.value)/100;}

    if(coorporativo>0){montoCoorporativo=(coorporativo*subtotal.value)/100;}

    if(asesores>0){montoAsesores=(asesores*subtotal.value)/100;}

    if(gestion>0){montoGestion=(gestion*subtotal.value)/100;}


       if(parseFloat(document.getElementById('gastosCCCEDF').value)>0 || parseFloat(document.getElementById('gastosCCOEDF').value)>0 || parseFloat(document.getElementById('gastosInversionesEDF').value)>0 || parseFloat(document.getElementById('gastosEstrategiaEDF').value)>0)
  {
    let totalEspecial=parseFloat(document.getElementById('gastosCCCEDF').value)+ parseFloat(document.getElementById('gastosCCOEDF').value)+parseFloat(document.getElementById('gastosInversionesEDF').value)+ parseFloat(document.getElementById('gastosEstrategiaEDF').value);
    montoGestion=totalEspecial;


  }


     document.getElementById('cargoFianzasEFG').value=montoFianzas.toFixed(2);
     porcentajesGlobales.fianzas=montoFianzas.toFixed(2);
     document.getElementById('cargoInstitucionalEFG').value=montoInstitucional.toFixed(2);
     porcentajesGlobales.institucional=montoInstitucional.toFixed(2);
     document.getElementById('cargoCoorporativoEFG').value=montoCoorporativo.toFixed(2);
     porcentajesGlobales.coorporativo=montoCoorporativo.toFixed(2);
     document.getElementById('cargoAsesoresEFG').value=montoAsesores.toFixed(2);
     porcentajesGlobales.asesores=montoAsesores.toFixed(2);
     document.getElementById('cargoEspecialesEFG').value=montoGestion.toFixed(2)
     porcentajesGlobales.gestion=montoGestion.toFixed(2);
     document.getElementById('totalDePagoEFG').value=subtotal.value; 
   }
   /*else{cargosManejoVista(true)}
   calcularMontoDisponible()*/
}

function sumaEFG()
{
   var sumita;
  var CargoFianzas= document.getElementById("cargoFianzasEFG").value 
  var CargoInst= document.getElementById("cargoInstitucionalEFG").value 
  var CargoGes= document.getElementById("cargoEspecialesEFG").value 
  var Corporativos= document.getElementById("cargoCoorporativoEFG").value
  var Asesores= document.getElementById("cargoAsesoresEFG").value
  sumita=Number(CargoFianzas)+Number(CargoInst)+Number(Corporativos)+Number(CargoGes)+Number(Asesores);
  document.getElementById("subTotalEFG").value = sumita;
  document.getElementById("totalDePagoEFG").value = sumita;
  if(parseFloat(document.getElementById('gastosCCCEDF'))>0 || parseFloat(document.getElementById('gastosCCOEDF'))>0 || parseFloat(document.getElementById('gastosInversionesEDF'))>0 || parseFloat(document.getElementById('gastosEstrategiaEDF'))>0)
  {
    document.getElementById('cargoEspecialesEFG').value=parseFloat(document.getElementById('gastosCCCEDF'))+ parseFloat(document.getElementById('gastosCCOEDF'))+parseFloat(document.getElementById('gastosInversionesEDF'))+ parseFloat(document.getElementById('gastosEstrategiaEDF'));
      document.getElementById("subTotalEFG").value = sumita+parseFloat(document.getElementById('cargoEspecialesEFG').value);
  document.getElementById("totalDePagoEFG").value = sumita+parseFloat(document.getElementById('cargoEspecialesEFG').value);

  }
  //document.getElementById('motivoCambioPorcentajeDiv').classList.remove('verOcultar')
 
}
function sumaGastosEspecialesEFG()
{
  
   let gastoCCC= document.getElementById("gastosCCCEDF").value;
   let gastoCCo=document.getElementById("gastosCCOEDF").value;
   let gastoCCInst=document.getElementById("gastosInversionesEDF").value;
   let gastoEstrategia=document.getElementById("gastosEstrategiaEDF").value;
   
   /* $('#ccc').val(gastoCCC);
    $('#cco').val(gastoCCo);
    $('#inversion').val(gastoCCInst);
    $('#estrategia').val(gastoEstrategia);
   if(gastoCCC==""){gastoCCC=0.0;}
   if(gastoCCo==""){gastoCCC=0.0;}
   if(gastoCCInst==""){gastoCCC=0.0;}
   if(gastoEstrategia==""){gastoEstrategia=0.0;}*/
  
   let total = parseFloat(gastoCCC)+ parseFloat(gastoCCo) + parseFloat(gastoCCInst)+parseFloat(gastoEstrategia);
   document.getElementById('cargoEspecialesEFG').value=total;
   
   sumaEFG();
}

function peticionAJAXEFG(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  manejoGifEFG();
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {    
        manejoGifEFG();       
         var respuesta=JSON.parse(this.responseText); 
         window[funcion](respuesta);                                                          
      }     
   }
  };
 req.send(parametros);
}

function datosDeFacturaEFG(datos='',idFactura)
{
 
  if(datos=='')
  {
   let params=`idFactura=${idFactura}`;
   idFacturaGlobalEFG=idFactura;
   controlador="presupuestos/datosDeFactura/?";
   peticionAJAXEFG(controlador,params,'datosDeFacturaEFG');
  }
  else
  {
    
    let factura=datos.factura;
    console.log(factura);
    if(datos.user=='SISTEMAS@ASESORESCAPITAL.COM' || datos.user=='CONTABILIDAD@AGENTECAPITAL.COM' || datos.user=='GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX'){document.getElementById('cargosEspecialesDivEFG').style.display=''}
    else{document.getElementById('cargosEspecialesDivEFG').style.display='none';}
    document.getElementById('sucursalEFG').value=factura.sucursal;
    document.getElementById('conceptoEFG').value=factura.concepto;
    document.getElementById('formaDePagoEFG').value=factura.posteriorapago;
    document.getElementById('proveedorEFG').value=factura.idProveedor;
    document.getElementById('folioFacturaEFG').value=factura.folio_factura;
    document.getElementById('tarjetasEFG').value=factura.idTarjetas;
    document.getElementById('cuentaContableEFG').value=factura.idCuentaContable;
    document.getElementById('fechaFacturaEFG').value=factura.fecha_factura;  
    document.getElementById('cargoFianzasEFG').value=factura.montofianzas;
    document.getElementById('cargoInstitucionalEFG').value=factura.montoinstitucional;
    document.getElementById('cargoCoorporativoEFG').value=factura.corporativo;
    document.getElementById('cargoAsesoresEFG').value=factura.montoasesores;
    document.getElementById('subTotalEFG').value=factura.totalfactura;
    document.getElementById('totalDePagoEFG').value=factura.totalconiva;
    document.getElementById('tipoDeGastoEFG').value=factura.tipoGasto;
    document.getElementById('gastosCCCEDF').value=factura.ccc;
    document.getElementById('gastosCCOEDF').value=factura.cco;
    document.getElementById('gastosInversionesEDF').value=factura.inversion;
    document.getElementById('gastosEstrategiaEDF').value=factura.estrategia;
    document.getElementById('cargoEspecialesEFG').value=parseFloat(factura.ccc)+ parseFloat(factura.cco) + parseFloat(factura.inversion)+parseFloat(factura.estrategia);
    document.getElementById('motivoCambioEDF').value=factura.motivoCambioPorcentaje;
  }
}

function actualizarDatosFacturaEFG(funcion)
{


     let params=`sucursal=${document.getElementById('sucursalEFG').value}&concepto=${document.getElementById('conceptoEFG').value}&posteriorapago=${document.getElementById('formaDePagoEFG').value}&idProveedor=${document.getElementById('proveedorEFG').value}&folio_factura=${document.getElementById('folioFacturaEFG').value}&fecha_factura=${document.getElementById('fechaFacturaEFG').value}&montofianzas=${document.getElementById('cargoFianzasEFG').value}&montoinstitucional=${document.getElementById('cargoInstitucionalEFG').value}&corporativo=${document.getElementById('cargoCoorporativoEFG').value}&montoasesores=${document.getElementById('cargoAsesoresEFG').value}&totalfactura=${document.getElementById('subTotalEFG').value}&totalconiva=${document.getElementById('totalDePagoEFG').value}&tipoGasto=${document.getElementById('tipoDeGastoEFG').value}&ccc=${document.getElementById('gastosCCCEDF').value}&cco=${document.getElementById('gastosCCOEDF').value}&inversion=${document.getElementById('gastosInversionesEDF').value}&estrategia=${document.getElementById('gastosEstrategiaEDF').value}&idFactura=${idFacturaGlobalEFG}&idTarjetas=${document.getElementById('tarjetasEFG').value}&motivoCambioPorcentaje=${document.getElementById('motivoCambioEDF').value}`;
        controlador="presupuestos/actualizarDatosFactura/?";
      peticionAJAXEFG(controlador,params,funcion);

   

}
obtenerDatosParaFacturar();
</script>