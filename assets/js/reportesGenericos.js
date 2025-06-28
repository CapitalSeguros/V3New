var fecha=new Date();
//ert(fecha.getFullYear()+"/"+fecha.getMonth()+"/"+fecha.getDate());
var anio=fecha.getFullYear()
var mes=fecha.getMonth();
var dia=fecha.getDate();
mes=mes+1;
var mesS="";
var diaS="";
var diaI="";
if(dia.length=1)
{mesS="0"+dia.toString();}
if(mes<10)
{mesS="-0"+mes.toString();}
else
{mesS="-"+mes.toString();}
if(dia<10){diaS="-0"+dia.toString();diaI="-02";}
else{diaS="-"+dia.toString();diaI="-02";}
document.getElementById("fIni").value=(anio.toString()+mesS+diaI.toString());
document.getElementById("fFin").value=(anio.toString()+mesS+diaS.toString());
if(document.getElementById("fCorte")){document.getElementById("fCorte").value=(anio.toString()+mesS+diaS.toString());}


/*=================================================================================*/



/*=========================LLENA COMBO LIST PARA LA BUSQUEDA=============================*/


  var filtro=document.getElementById('tabla');
  var contadorFiltro=filtro.rows[0].cells.length;
  var cadFiltro= '';
  cadFiltro = '<label for="selectFiltro"><i class="fa fa-filter"></i> Filtrar</label>';
  cadFiltro = cadFiltro+'<select id="selectFiltro" class="form-control" style="width: 45%;">';
  cadFiltro = cadFiltro+'<option value="-1">Quitar filtro</option>';
  for(var i=1;i<contadorFiltro;i++){
    cadFiltro=cadFiltro+'<option value='+i+'>'+filtro.rows[0].cells[i].innerHTML+'</option>';
  }
  cadFiltro=cadFiltro+"</select>";

if($("#sw").val()=='g'){
  document.getElementById('filtro').innerHTML=cadFiltro
}

/*=======================================================================================*/
/*======================OCULTA EL DETALLE PARA MOSTRAR DOCUMENTOS=======================*/
document.getElementById("ventana-flotante").className = "ocultoInicio";
/*=====================================================================================*/

/*=========================FECHAS USANDO JQUERY========================================*/
  var mMeses=['Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
  var mDias=['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'];
  var mDiasCortos=['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'];5
$(function () {

$("#fIni").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
    currentText: 'Hoy',
  monthNames: mMeses,
  dayNames:mDias ,
  dayNamesShort:mDiasCortos,
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});
$(function () {

$("#fFin").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
   currentText: 'Hoy',
    monthNames: mMeses,
    dayNames: mDiasCortos,
    dayNamesShort:mDiasCortos,
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
            
});
});

$(function () {

$("#fCorte").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
   currentText: 'Hoy',
    monthNames: mMeses,
    dayNames: mDiasCortos,
    dayNamesShort:mDiasCortos,
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
            
});
});

var hoy = new Date();
var dia = hoy.getDate(); 
var mes = hoy.getMonth();
var anio= hoy.getFullYear();
fecha_actual = String(dia+"/"+(mes+1)+"/"+anio);
fecha_inicial=String("01"+"/"+(mes+1)+"/"+anio);
document.getElementById("fIni").value=fecha_inicial;
document.getElementById("fFin").value=fecha_actual;
if(document.getElementById("fCorte")){document.getElementById("fCorte").value=fecha_inicial;}
if(compruebaVariable==1){
     document.getElementById("fFin").value=document.getElementById("fechaFinO").value;
     document.getElementById("fIni").value=document.getElementById("fechaIniO").value;
     if(document.getElementById("fCorte")){document.getElementById("fCorte").value=document.getElementById("fechaIniO").value;}
    }
/*======================================================================================*/
function buscar()
{
  var ver="";
  var valorabuscar=document.getElementById("buscar").value;
  var campoBuscar=document.getElementById("selectFiltro").value;
  var tabla_tr = document.getElementById("tabla");
  var contador=tabla_tr.rows.length;
  var textoAbuscar=valorabuscar.toLowerCase();
  if(campoBuscar=="-1"){
   for(var j=2;j<contador;j++)
       {
        tabla_tr.rows[j].className="mostrar";          
       }
      }
  else{
          for(var j=2;j<contador;j++)
       {
           //alert(tabla_tr.rows[j].cells[1].innerHTML);
          var texto=tabla_tr.rows[j].cells[campoBuscar].innerHTML;
          var textMinus=texto.toLowerCase();
          if(textMinus.indexOf(textoAbuscar)>=0){
          tabla_tr.rows[j].className="mostrar";
           }
           else{ tabla_tr.rows[j].className="ocultar";}
       }
    }
}
/*=====================================FUNCION PARA DESCARGAR EXCEL===============================*/
       function descargarExcel(argumento,argumento2)
    {    
 /*   var miTabla=document.getElementById('tabla');
  var contador=tabla.rows[0].cells.length;
  var cont=tabla.rows.length;
   
  var cadena='<table id="tablaCopia" class="table table-striped"><tr>';
for(var i=1;i<contador;i++){
  cadena=cadena+'<td>'+tabla.rows[0].cells[i].innerHTML+'</td>';
}
  cadena=cadena+'</tr>';

  for(var t=1;t<cont;t=t+2)
  {   cadena=cadena+'<tr>';
     for(var j=1;j<contador;j++)
     {
         cadena=cadena+'<td>'+tabla.rows[t].cells[j].innerHTML+'</td>';
     }
      cadena=cadena+'</tr>';
  } 
  cadena=cadena+'</table>';
var capa=document.getElementById('capaInvisible');
capa.innerHTML=cadena
       var tmpElemento = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel;charset=iso-8859-1';
        var tabla_div = document.getElementById('tablaCopia');
        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
        tmpElemento.href = data_type + ', ' + tabla_html;
        tmpElemento.download = 'Produccion.xls';
        tmpElemento.click();
        var cad2="<a>";
      capa.innerHTML=cad2;*/

var agente=navigator.userAgent;
var navegadores=["Chrome","Firefox","Opera","Trident","MSIE","Edge","OPR"];
var navegadorUsado="";
//alert(navigator.userAgent)
     for(var i=0 in navegadores)
     {  //alert(navegadores[i]);
     if(agente.indexOf(navegadores[i])>-1)
     {
        navegadorUsado=navegadores[i];   
     }

     }
       var miTabla=document.getElementById('tabla');
         var contador=tabla.rows[0].cells.length;
         var cont=tabla.rows.length;            
  var cadena='<table id="tablaCopia" class="table table-striped"><tr>';
for(var i=argumento;i<contador;i++){
  cadena=cadena+'<td>'+tabla.rows[0].cells[i].innerHTML+'</td>';
}
  cadena=cadena+'</tr>';

  /*for(var t=1;t<cont;t=t+2)
  {   cadena=cadena+'<tr>';
     for(var j=1;j<contador;j++)
     {
         cadena=cadena+'<td>'+tabla.rows[t].cells[j].innerHTML+'</td>';
     }
      cadena=cadena+'</tr>';
  } */

  for(var t=2;t<cont;t++)
  {   cadena=cadena+'<tr>';
     for(var j=argumento;j<contador;j++)
     {
         cadena=cadena+'<td>'+tabla.rows[t].cells[j].innerHTML+'</td>';
     }
      cadena=cadena+'</tr>';
  }
  cadena=cadena+'</table>';

    if(navegadorUsado=="OPR" || navegadorUsado=="Chrome" )
    {
       
var capa=document.getElementById('capaInvisible');
capa.innerHTML=cadena
       var tmpElemento = document.createElement('a');
        var data_type = 'data:application/vnd.ms-excel;charset=iso-8859-1';
        var tabla_div = document.getElementById('tablaCopia');
        var tabla_html = tabla_div.outerHTML.replace(/ /g, '%20');
        tmpElemento.href = data_type + ', ' + tabla_html;
        tmpElemento.download = argumento2;
        tmpElemento.click();
        var cad2="<a>";
      capa.innerHTML=cad2;
    }
    else{
      if( navegadorUsado=="Firefox")
      {
       var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office"';
       htmlPlanilha =htmlPlanilha+' xmlns:x="urn:schemas-microsoft-com:office:excel"';
       htmlPlanilha=htmlPlanilha+' xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml>';
       htmlPlanilha=htmlPlanilha+' <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
       htmlPlanilha=htmlPlanilha+' <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>';
       htmlPlanilha=htmlPlanilha+' </x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>' ;
       htmlPlanilha=htmlPlanilha+ cadena + '</body></html>' 
       var uriContent = "data:application/vnd.ms-excel," + encodeURIComponent(htmlPlanilha);
       var myWindow = window.open(uriContent, "mywindow");
       myWindow.name=argumento2;
       myWindow.focus();
      }
  else{
 var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office"';
 htmlPlanilha =htmlPlanilha+' xmlns:x="urn:schemas-microsoft-com:office:excel"';
  htmlPlanilha=htmlPlanilha+' xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml>';
  htmlPlanilha=htmlPlanilha+' <x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
  htmlPlanilha=htmlPlanilha+' <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet>';
  htmlPlanilha=htmlPlanilha+' </x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body>' ;

  htmlPlanilha=htmlPlanilha+ cadena + '</body></html>'  

    var blobObject = new Blob([htmlPlanilha]);
    window.navigator.msSaveOrOpenBlob(blobObject, argumento2);
     } 
    }
  }
/*===============================================================================================*/

/*================================ APARECE DETALLE===============================================*/
function apareceDetalle(argumento,argumento2)
{
var cad="";//74388,1041,1108


   var imp="";
                    $.ajax({
                        method: "POST",
                        data: { "IDDocto":argumento2},
                        url : direccion,
                        dataType: "html",
                        success : function(datat)
                            {
                                
                                 var j=JSON.parse(datat);
                               
                               
                                 var valor="";
                             
                                 if(j.text!="No cuenta con documentos"){
                                     imp="<ul>";
                                 for(var hijo=0;hijo<j.children.length;hijo++){
                                 valor=JSON.stringify(j.children[hijo].isFolder);
                           
                                if(valor=="true"){
                                imp=imp+"<li style='list-style-image: url(folder.png)'>";
                                imp=imp+"C-"+JSON.stringify(j.children[hijo].text);
                                imp=imp+"</li>";
                               } 
                                 else
                               {
                                imp=imp+"<li style=\'list-style-image: url(archivo.png)\'>";
                                imp=imp+"<a href="+JSON.stringify(j.children[hijo].href)+" target='_blank'>";
                                imp=imp+JSON.stringify(j.children[hijo].text)+"</a>";
                                imp=imp+"</li>";
                               }
                             }
                              imp=imp+"</ul>"
                           }
                           else{
                            imp="<h1>No cuenta con documentos</h1>"
                           }
                                                  
                              var micapa = document.getElementById('ventana-flotante');
                             
                             var tbl = document.getElementById('tabla'); // table reference
                             lastCol = tbl.rows[0].cells.length-1; 
                            
                           cad=cad+'<a class="cerrar" href="javascript:void(0);" onclick="document.getElementById(&apos;ventana-flotante&apos;).className = &apos;oculto&apos;">x</a>';
                              
                            for (var i=1;i<lastCol;i++) {
                            cad=cad+'<input type="text"  readonly="readonly"  value="'+tbl.rows[0].cells[i].innerHTML+'" name="option" />';                           
                            cad=cad+'<input type="text" readonly="readonly" value="'+tbl.rows[argumento].cells[i].innerHTML+'" name="option" /></br>';
                           }
                           
                           micapa.innerHTML=cad+'<div style="background:white;border:  5px solid #351667;">'+imp+'</div>';
                         
                                    document.getElementById("ventana-flotante").className = "ver";    
                        }
                    
                    });   
                                
}
/*===============================================================================================*/
/*============================APARECE DETALLE ANTERIOR===========================*/
function apareceDetalleAnterior(argumento,argumento2)
{
var cad="";//74388,1041,1108


   var imp="";
                    $.ajax({
                        method: "POST",
                        data: { "IDDocto":argumento2},
                        url : dirDocAnterior,
                        dataType: "html",
                        success : function(datat)
                            {
                                
                                 var j=JSON.parse(datat);                                                              
                                 var valor="";
                      
                                 if(j.text!="No cuenta con documentos"){
                                     imp="<ul>";
                                 for(var hijo=0;hijo<j.children.length;hijo++){
                                 valor=JSON.stringify(j.children[hijo].isFolder);
                           
                                if(valor=="true"){
                                imp=imp+"<li style='list-style-image: url(folder.png)'>";
                                imp=imp+"C-"+JSON.stringify(j.children[hijo].text);
                                imp=imp+"</li>";
                               } 
                                 else
                               {
                                imp=imp+"<li style=\'list-style-image: url(archivo.png)\'>";
                                imp=imp+"<a href="+JSON.stringify(j.children[hijo].href)+" target='_blank'>";
                                imp=imp+JSON.stringify(j.children[hijo].text)+"</a>";
                                imp=imp+"</li>";
                               }
                             }
                              imp=imp+"</ul>"
                           }
                           else{
                            imp="<h1>No cuenta con documentos</h1>"
                           }
                           console.log(imp);                
                              var micapa = document.getElementById('ventana-flotante');
                             
                             var tbl = document.getElementById('tabla'); // table reference
                             lastCol = tbl.rows[0].cells.length-1; 
                            
                           cad=cad+'<a class="cerrar" href="javascript:void(0);" onclick="document.getElementById(&apos;ventana-flotante&apos;).className = &apos;oculto&apos;">x</a>';
                              
                           /* for (var i=1;i<lastCol;i++) {
                            cad=cad+'<input type="text"  readonly="readonly"  value="'+tbl.rows[0].cells[i].innerHTML+'" name="option" />';                           
                            cad=cad+'<input type="text" readonly="readonly" value="'+tbl.rows[argumento].cells[i].innerHTML+'" name="option" /></br>';
                           }*/
                           cad=cad+'<input type="text"  readonly="readonly"  value="Vendedor" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.VendNombre[0]+'" name="option" /></br>';                           
                                 cad=cad+'<input type="text"  readonly="readonly"  value="Prima total" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.PrimaTotal[0]+'" name="option" /></br>';                           
                                 cad=cad+'<input type="text"  readonly="readonly"  value="Prima neta" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.PrimaNeta[0]+'" name="option" /></br>';                           
cad=cad+'<input type="text"  readonly="readonly"  value="Sub ramo" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.SRamoAbreviacion[0]+'" name="option" /></br>';                           
 cad=cad+'<input type="text"  readonly="readonly"  value="Compania" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.CiaNombre[0]+'" name="option" /></br>';                           
 cad=cad+'<input type="text"  readonly="readonly"  value="Agente" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.CAgente[0]+'" name="option" /></br>';                           
cad=cad+'<input type="text"  readonly="readonly"  value="Moneda" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.Moneda[0]+'" name="option" /></br>';                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Concepto" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.Concepto[0]+'" name="option" /></br>';                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Nombre" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.NombreCompleto[0]+'" name="option" /></br>';                           
cad=cad+'<input type="text"  readonly="readonly"  value="Status" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.Status_TXT[0]+'" name="option" /></br>';                           
                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Hasta" name="option" />';
                                           
                            var fec=new Date(j.FHasta[0]);               
                           cad=cad+'<input type="text"  readonly="readonly" value="'+fec.getDate()+'-'+(fec.getMonth()+1)+'-'+fec.getFullYear()+'" name="option" /></br>';                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Desde" name="option" />';
                           fec=new Date(j.FDesde[0]);
                           cad=cad+'<input type="text" readonly="readonly" value="'+fec.getDate()+'-'+(fec.getMonth()+1)+'-'+fec.getFullYear()+'" name="option" /></br>';                           

cad=cad+'<input type="text"  readonly="readonly"  value="Anterior" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.DAnterior[0]+'" name="option" /></br>';                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Documento" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.Documento[0]+'" name="option" /></br>';                           
                           cad=cad+'<input type="text"  readonly="readonly"  value="Tipo" name="option" />';
                           cad=cad+'<input type="text" readonly="readonly" value="'+j.TipoDocto_TXT[0]+'" name="option" /></br>';                           
                           


                           
                           micapa.innerHTML=cad+'<div style="background:white;border:  5px solid #351667;">'+imp+'</div>';
                         
                                    document.getElementById("ventana-flotante").className = "ver";    
                        }
                    
                    });   
                                
}

/*===============================================================================*/


/*=================================APARECE SUBDETALLE CON COMENTARIO=============================*/

function agregaDetalle(indice,bit,ramoNombre,idDocto,IDSRamo,Documento,RamosNombre,dirUrl,IDCli){
                    $.ajax({
                        method: "POST",
                        data: { "claveBit":bit},
                        url : "<?php echo base_url()?>produccion/traeArchivosBit",
                        dataType: "html",
                        success : function(data)
                            {   var cad1="";
                              
                                var j=JSON.parse(data);
                                console.log(j);
                                if((j.TableControl.MaxRecords==0))
                                {
                                  
                                  cad1="<p>SIN COMENTARIOS";
                                }
                                else
                                {
                                  if(j.TableControl.MaxRecords==1)
                                  {
                                    cad1=cad1+"<p>*****"+j.TableInfo['FechaHora']+' -> ';
                                    cad1=cad1+j.TableInfo['Comentario'];
                                  }
                                   else{
                                    for(var hijo=0;hijo<j.TableInfo.length;hijo++){
                                   cad1=cad1+"<p>*****"+JSON.stringify(j.TableInfo[hijo].FechaHora)+' -> ';
                                 cad1=cad1+JSON.stringify(j.TableInfo[hijo].Comentario);
                               }
                                                            }
                                }                              
  var padreAnt=document.getElementById("padreAnt");
  var hijoAnt=document.getElementById("hijoAnt");
  var cadString='<td colspan="10"  id="tdBorrar'+indice +'">'+cad1+'<p>'+'<a href="'+dirUrl+'actividades/agregar/Cotizacion/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Cotizacion</a> <a href="'+dirUrl+'actividades/agregar/Emision/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Emision</a> <a href="'+dirUrl+'actividades/agregar/Endoso/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Prueba/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Endoso</a> <a href="'+dirUrl+'actividades/agregar/Cancelacion/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Cancelacion</a> <a href="'+dirUrl+'actividades/agregar/Diligencia/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Diligencia</a> <a href="'+dirUrl+'actividades/agregar/CapturaRenovacion/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Captura renovacion</a></td>';
  
  var cadContenedor=document.getElementById("F"+indice);
  cadContenedor.innerHTML=cadString;
 var borrar=hijoAnt.value;
  hijoAnt.value="tdBorrar"+indice;
  padreAnt.value=indice;
  var elim=document.getElementById(borrar);
  var padre=elim.parentNode;
   padre.removeChild(elim);

                            }
                          });


}


/*===============================================================================================*/

/*====================================AGREGA DETALLE SIN COMENTARO===============================*/
function agregaDetalleSinComentario(indice,bit,ramoNombre,idDocto,IDSRamo,Documento,RamosNombre,dirUrl,IDCli){

  var cadString='<p>'+'<a href="'+dirUrl+'actividades/agregar/Cotizacion/'+ 
  RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'
  +Documento+'&idPoliza='+Documento+
  '&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Cotizacion</a> <a href="'+dirUrl+'actividades/agregar/Emision/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Emision</a> <a href="'+dirUrl+'actividades/agregar/Endoso/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente/verFol?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Endoso</a> <a href="'+dirUrl+'actividades/agregar/Cancelacion/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente/verFol?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Cancelacion</a> <a href="'+dirUrl+'actividades/agregar/Diligencia/'+ RamosNombre.toUpperCase()+'/'+IDSRamo+'/Existente?idCliente='+IDCli+'-'+Documento+'&idPoliza='+Documento+'&consultar=Renovacin&cliente=&estatus&=&ramo=&subramo=&promotor=&grupo&subgrupo=&poliza">Diligencia</a>';  
  var cadContenedor=document.getElementById("Caja"+indice);
  cadContenedor.innerHTML=cadString;
 /*var borrar=hijoAnt.value;
  hijoAnt.value="tdBorrar"+indice;
  padreAnt.value=indice;
  var elim=document.getElementById(borrar);
  var padre=elim.parentNode;
   padre.removeChild(elim);*/


}

/*===============================================================================================*/



