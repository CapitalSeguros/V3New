
<?php $this->load->view('headers/header');$this->load->view('headers/menu');?>

<script type="text/javascript">
    let meses=["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];

</script>
<h3 >Monitor de metas comerciales</h3>  

<div id="contenidoInformacion">
    
</div>
<div id="divImgEspera"  class="divEspera ocultarObjeto"><img id="imgEspera" src="<?php echo(base_url().'assets/img/loading.gif');?>"></div>

<div id="divModalGenerico" class="modalCierra"><div style="padding: 3%"><div style="background-color: #6f42c1;display: flex;justify-content: flex-end;" class="modal-btnCerrar"><button onclick="cerrarModalGenerico('divModalGenerico')" style="color: white;background-color:red; border:double;width: 5%">X</button></div><div id="divModalContenidoGenerico" class="modal-contenido"  ></div> </div></div>
<script type="text/javascript">

function cerrarModalGenerico(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
 req.open('POST', url, true);
 
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  document.getElementById('divImgEspera').classList.toggle('ocultarObjeto');
   req.onreadystatechange = function (aEvt) 
  {   
    if (req.readyState == 4) 
    {      
      if(req.status == 200)
        { 
          document.getElementById('divImgEspera').classList.toggle('ocultarObjeto');
          var respuesta=JSON.parse(this.responseText); 
          window[funcion](respuesta);                                               
        }           
   }
  };
 req.send(parametros);
}
function traerPolizas(datos='',objeto)
{
    if(datos=='')
    {
      let params=`emailCoordinador=${objetos.dataset.emailcoordinador}&mes=1&anio=2024`;
      controlador="indicadoresDeProductividad/kpiUnionPuesto/?";          
      peticionAJAX(controlador,params,'traerPolizas'); 
    }
    else
    {

    }
}
function traerMetas(datos='')
{
    if(datos=='')
    {
      let params='';
      controlador="controlMetaComercial/devolverMetasComerciales/?";          
      peticionAJAX(controlador,params,'traerMetas'); 
    }
    else
    {
     let innerHTML='';
     for(let canales of datos.canales)
     {
        
    
    let trVentaNueva='';
    let trVentaTotal='';
for(const [key, value] of Object.entries(canales.metas.mensualidales))
        {
         var1=value.comisionVentaNueva;
         var2=value.metaVentaNuevalMes;
                    if(var2>0 && var1!=0){porciento=(var1*100)/var2;}
            else
                {
                    if(var1=='0'){porciento=0;var2=0}
                    else{porciento=100;var2=var1;}
                }
                  let style='';
                
                if(datos.mesActual>=key)
                {
                 style='style="background-color:#f56464"';
                
                if(porciento>=100){style='style="background-color:#46cd46"';}
               }
            trVentaNueva+=`<tr ${style} class="trVenta" data-anio="${datos.anio}" data-canal="${canales.canal}" data-mes="${key}"><td>${key}</td><td style="text-align:center">${meses[key-1]}</td><td style="text-align:right">${formatoMoneda(value.metaVentaNuevalMes)}</td><td style="text-align:right;flex-direction:column">${formatoMoneda(value.comisionVentaNueva)}</td><td style="
    text-align: center"><div><div style="display:flex;justify-content:center"><progress value="${var1}" max="${var2}"></progress></div><div>${porciento.toFixed(2)}%</div></div></td></tr>`;


            var1=value.comisionVentaTotal;
         var2=value.metaVentaTotalMes;
                    if(var2>0 && var1!=0){porciento=(var1*100)/var2;}
            else
                {
                    if(var1=='0'){porciento=0;var2=0}
                    else{porciento=100;var2=var1;}
                }
                               if(datos.mesActual>=key)
                {
                style='style="background-color:#f56464"';
                if(porciento>=100){style='style="background-color:#46cd46"';}
                }
            trVentaTotal+=`<tr ${style} class="trVenta" data-anio="${datos.anio}" data-canal="${canales.canal}" data-mes="${key}" ><td>${key}</td><td style="text-align:center">${meses[key-1]}</td><td style="text-align:right">${formatoMoneda(value.metaVentaTotalMes)}</td><td style="text-align:right">${formatoMoneda(value.comisionVentaTotal)}</td><td style="
    text-align: center"><div style="display:flex;flex-direction:column;"><div style="display:flex;justify-content:center"><progress value="${var1}" max="${var2}"></progress></div><div style="display:flex;justify-content:center">${porciento.toFixed(2)}%</div></div></td></tr>`;
          
      }
        innerHTML+=`<div class="contenidoCanal">`;
        innerHTML+=`<div class="encabezadoPorCanal">`;
        innerHTML+=`<div style="display:flex;justify-content:center"><div><h2>${canales.nombre_completo}</h1></div><div><h2>(${canales.correo})</h1></div></div>`;
        innerHTML+=`<div class="contenidoPorCanal">`;
        innerHTML+=`<div class="divPestanias"><div><button class="btnPestania btnPestaniaSeleccionada" name="btn${canales.correo}" data-tipoventa="ventaNueva" data-emailcoordinador="${canales.correo}">VENTA NUEVA</button><button class="btnPestania" name="btn${canales.correo}" data-tipoventa="ventaTotal" data-emailcoordinador="${canales.correo}">VENTA TOTAL</button></div></div>`;
        innerHTML+=`<div id="ventaNuevaDiv${canales.correo}"><table class="table"><thead><tr style="background-color:white;color:black"><th colspan="5" style="color:black;text-align:center"><h2>META ANUAL DE VENTA NUEVA: ${formatoMoneda(canales.metas.metaAnualVentaNueva)}</h2></th></tr><tr><th>Num</th><th style="text-align:center">Mes registrado</th><th style="text-align:right">Meta del mes</th><th style="text-align:right">Comision</th><th style="text-align:center">Avance</th></tr></thead><tbody>${trVentaNueva}</tbody></table></div>`
    innerHTML+=`<div id="ventaTotalDiv${canales.correo}" class="ocultarObjeto"><table class="table"><thead><tr style="background-color:white;color:black"><th colspan="5" style="color:black;text-align:center"><h2>META ANUAL DE VENTA TOTAL: ${formatoMoneda(canales.metas.metaAnualVentaTotal)}</h2></th></tr><tr><th>Num</th><th style="text-align:center">Mes registrado</th><th style="text-align:right">Meta del mes</th><th style="text-align:right">Comision</th><th style="text-align:center">Avance</th></tr></thead><tbody>${trVentaTotal}</tbody></table></div>`;

        innerHTML+=`</div>`;
        innerHTML+=`</div>`;
        innerHTML+=`</div>`;
     }
     document.getElementById('contenidoInformacion').innerHTML=innerHTML;
     let botones=document.getElementsByClassName('btnPestania');
     for(let boton of botones)
     {
        boton.addEventListener('click',function()
        {
            let btn=document.getElementsByName(this.name);
            for(let obj of btn){obj.classList.remove('btnPestaniaSeleccionada');}
            this.classList.add('btnPestaniaSeleccionada');
            if(this.dataset.tipoventa=='ventaNueva')
            {
                document.getElementById('ventaNuevaDiv'+this.dataset.emailcoordinador).classList.remove('ocultarObjeto');
                document.getElementById('ventaTotalDiv'+this.dataset.emailcoordinador).classList.add('ocultarObjeto');
            }
            else
            {
                document.getElementById('ventaNuevaDiv'+this.dataset.emailcoordinador).classList.add('ocultarObjeto');
                document.getElementById('ventaTotalDiv'+this.dataset.emailcoordinador).classList.remove('ocultarObjeto');
            }

        })
     }
     let trVenta=document.getElementsByClassName('trVenta');
     for(let tr of trVenta)
     {
        tr.addEventListener('dblclick',function(){

      let params=`anio=${this.dataset.anio}&mes=${this.dataset.mes}&canal=${this.dataset.canal}`;
      controlador="controlMetaComercial/devolverPolizas/?";          
      peticionAJAX(controlador,params,'mostrarPolizas'); 
            
        })
     }
    }
}

function mostrarPolizas(datos)
{  
    let tabla='<table class="table" id="tablePolzas"><thead><tr>';
    let boton=`<div><button style="width: 40px;height: 40px;background-color: white;border: none" onclick="exportarPolzas()"><img style="width: 100%;height: 100%" src="<?=base_url()?>assets/images/iconoxls.png"></button><label id="labelExport"></label></div>`
    for(const [key, value] of Object.entries(datos.polizas.polizas[0]))
        {

            tabla+=`<th><div>${key}</div> ${boton}</th>`;
            boton='';
        }
    tabla+='</tr></thead><tbody id="polzasBody">';
  
  /*let tabla=`<table class="table" id="tablePolzas"><thead><tr><th><div>Documento</div><div><button style="width: 40px;height: 40px;background-color: white;border: none" onclick="exportarPolzas()"><img style="width: 100%;height: 100%" src="<?=base_url()?>assets/images/iconoxls.png"></button></div></th><th>Renovacion</th><th>Compania</th><th>Fecha Documento</th><th>Cliente</th><th>Ramo</th><th>SubRamo</th><th>Renovacion Docto</th><th>Grupo</th><th>SubGrupo</th><th>Gerencia</th><th>Prima total</th><th>Comision_0</th><th>Comision_1</th><th>Comision_2</th><th>Comision_3</th><th>Comision_4</th><th>Comision_5</th><th>Comision_6</th><th>Comision_7</th><th>Comision_8</th><th>Comision_9</th><th>Tipo cambio</th><th>Comision total</th><th>Canal</th></tr><tbody id="polzasBody">`*/
  /*for(let polizas of datos.polizas.polizas)
  {
    //let compania=polizas.AgenteNombre.replace(/ /g,'_')
    let compania=polizas.AgenteNombre;
    let comisionTotal=0;
    comisionTotal=(Number(polizas.Comision0)+Number(polizas.Comision1)+Number(polizas.Comision2)+Number(polizas.Comision3)+Number(polizas.Comision4)+Number(polizas.Comision5)+Number(polizas.Comision6)+Number(polizas.Comision7)+Number(polizas.Comision8)+Number(polizas.Comision9))*Number(polizas.TCPago);
    tabla+=`<tr><td><label>${polizas.Documento}</label></td><td style="text-align:center">${polizas.RenovacionDocto}</td><td><label>${compania}</label></td><td>${polizas.FechaDocto}</td><td>${polizas.NombreCompleto}</td><td>${polizas.RamosNombre}</td><td>${polizas.SRamoNombre}<td>${polizas.RenovacionDocto}</td><td>${polizas.Grupo}</td><td>${polizas.SubGrupo}</td><td>${polizas.GerenciaNombre}</td></td><td style="text-align:right">$${polizas.PrimaTotal}</td><td style="text-align:right">$${polizas.Comision0}</td><td style="text-align:right">$${polizas.Comision1}</td><td style="text-align:right">$${polizas.Comision2}</td><td style="text-align:right">$${polizas.Comision3}</td><td style="text-align:right">$${polizas.Comision4}</td><td style="text-align:right">$${polizas.Comision5}</td><td style="text-align:right">$${polizas.Comision6}</td><td style="text-align:right">$${polizas.Comision7}</td><td style="text-align:right">$${polizas.Comision8}</td><td style="text-align:right">$${polizas.Comision9}</td><td style="text-align:right">$${polizas.TCPago}</td><td>${comisionTotal.toFixed(2)}</td><td>${polizas.canal}</td></tr>`
  }*/
  /*datos.polizas.polizas[0]
  console.log(datos.polizas.polizas);*/

  for(const [key, value] of Object.entries(datos.polizas.polizas))
    {
        tabla+='<tr>';
       let objeto=(Object.values(value));
        objeto.forEach(elemento=>{tabla+=`<td>${elemento}</td>`});
        tabla+='</tr>';
  }
  tabla+='</tbody></table>';
  document.getElementById('divModalContenidoGenerico').innerHTML=tabla;
  cerrarModalGenerico('divModalGenerico');
}

function formatoMoneda(numero)
{
//PASAMOS EL NUMERO RECIBIDO EN LA FUNCION Y LO REDONDEAMOS A DOS DECIMALES  
numeroFlot=Number(numero).toFixed(2);
// LE ASIGNAMOS QUE SEA EN MONEDA MEXICAN EL CUAL DEVOLVERA EL VALOR CON EL        // SIGNO $
 formato=new Intl.NumberFormat(['es-MX'], {style: "currency",currency: "MXN",currencyDisplay: "symbol",maximumFractionDigit: 1}).format(numeroFlot);
 return formato;
}

  function exportarPolzas()
  {
  
  
 table=document.getElementById('tablePolzas');
      let tableExport = new TableExport(table, {
        exportButtons: false, // No queremos botones
        filename: "POLZAS", //Nombre del archivo de Excel
        sheetname: "POLZAS", //TÃ­tulo de la hoja
        mimeType: "application/vnd.ms-excel",
        formats: ["xlsx", "csv", "txt"]
    });
    
    let datos = tableExport.getExportData();     
         let preferenciasDocumento = datos.tablePolzas.csv;
         
          
 
    tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);


  }


traerMetas();

</script>
<style type="text/css">
   .encabezadoPorCanal{background-color: #f7f7f7;color: black} 
   .divPestanias{background-color: #8370a1;display: flex;flex-direction: column;width: 100%}
   .divPestanias>div:nth-child(1){height: auto}
   .divPestanias>div:nth-child(2){height: 50px;background-color: white}
   .btnPestania{padding: 8px;color: white;background-color: #8370a1;border:none;}
   .btnPestaniaSeleccionada{background-color: white;color: black;border-top: solid black 1px;border-left: solid black 1px;border-right: solid black 1px}
   .ocultarObjeto{display: none}
   .trVenta:hover{background-color: red;cursor: pointer;}
   .divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 60%;top: 55%;position: fixed;z-index: 10000}
    .modal-btnCerrar{background-color:white;width:90%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; }
    .modal-contenido{background-color:white;width:90%;height:500px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000; overflow: scroll;  }
    .modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000;}
    .modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;z-index: 1000}
</style>
<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>