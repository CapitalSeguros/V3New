
   
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

/*=================================================================================*/




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
//alert(bandera);
document.getElementById("fFin").value="02/02/2017";
var hoy = new Date();
var dia = hoy.getDate(); 
var mes = hoy.getMonth();
var anio= hoy.getFullYear();
fecha_actual = String(dia+"/"+(mes+1)+"/"+anio);
fecha_inicial=String("01"+"/"+(mes+1)+"/"+anio);
document.getElementById("fIni").value=fecha_inicial;
document.getElementById("fFin").value=fecha_actual;
if(bandera==1){ 
     document.getElementById("fIni").value=fechaInicial;
     document.getElementById("fFin").value=fechaFinal;
    }
/*======================================================================================*/


