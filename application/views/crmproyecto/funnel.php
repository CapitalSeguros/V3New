<?php
	$this->load->view('headers/header'); 
?>
<?php
	$this->load->view('headers/menu');
?>
<style type="text/css">
html,body{ 
 overflow-x: hidden;
}
</style>
<style>
.letra{width: 350px;background-color:black;display:block; margin-left:auto; margin-right:auto;position:relative; left:150px;top:30px;height:0px;background: black;font-size: 18px;color: black}
.trapecio-top {  width:350px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top1 {width: 290px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top2 {width: 230px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top3 {width: 170px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.trapecio-top4 {width: 110px;height:0px;border-right: 30px solid transparent;border-left: 30px solid transparent;
border-top: 50px solid #428bca;padding-left:50px;display:block; margin-left:auto; margin-right:auto}
.fondoSelecRow{background-color: blue;	}
.fondoClickRow{background-color: green;}
.fondoNoSelecRow{background-color: #737373;}
.fondoRowNuevo{background-color:#60abcb}
.fondoEditNuevo{background-color:#60abcb;width: 100px;}
.fondoEditExistente{background-color:white;width: 100px;}
.textPorcentaje{width: 100px;}
.ocultaTD{display: none;}
</style>
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Proyecto 100</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
	                <li><a href="./">Inicio</a></li>
                    <li class="active"><a>Funnel</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

    <section class="container-fluid"><!-- container-fluid -->
        <div class="row">
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="Vanio">año</label>
					<select id="Vanio" name="Vanio" class="form-control">
						<option value="2017">2017</option>
						<option value="2018">2018</option>
						<option value="2019">2019</option>
						<option value="2020">2020</option>
						<option value="2021">2021</option>
					</select>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="Vmes">mes</label>
					<select id="Vmes" name="Vmes" class="form-control">
						<option>Enero</option>
						<option>Febrero</option>
						<option>Marzo</option>
						<option>Abril</option>
						<option>Mayo</option>
						<option>Junio</option>
						<option>Julio</option>
						<option>Agosto</option>
						<option>Septiembre</option>
						<option>Octubre</option>
						<option>Noviembre</option>
						<option>Diciembre</option>
					</select>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VobjetivoMensual">objetivo mensual</label>
					<input  type="text" id="VobjetivoMensual" name="VobjetivoMensual" class="form-control" value="9000" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-3 col-md-3">
				<div class="form-group">
					<label for="VcontratoCerrar">contrato a cerrar</label>
                    <input type="text" id="VcontratoCerrar" name="VcontratoCerrar" class="form-control" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- <div style="overflow: scroll;height:80%;width: 100%;"></div> -->
				<div class="table-responsive">
								<table class="table" border="1" id="t_Funnel">
									<tr style="width: 300px">
										<td id="id" style="">id</td>
                                        <td id="anio">año</td>
										<td id="mes">mes</td>
										<td id="ticketProm" class="ocultaTD">ticket promedio</td>
										<td id="comision"  class="ocultaTD">comision</td>
										<td id="prospecto"  class="ocultaTD">prospecto</td>
										<td id="impacto"  class="ocultaTD">impacto</td>
										<td id="seguimiento"  class="ocultaTD">seguimiento</td>
										<td id="objetivoMensual"  class="ocultaTD">objetivo mensual</td>
										<td id="contratoCerrar"  class="ocultaTD">contrato cerrar</td>
										<td id="suspecto"  class="ocultaTD">suspecto</td>
										<td id="contactado"  class="ocultaTD">contactado</td>
										<td id="cotizado"  class="ocultaTD">cotizado</td>
										<td id="pagado"  class="ocultaTD">pagado</td>
										<td  class="ocultaTD" id="perfilado">perfilado</td>
										<td  class="ocultaTD" id="dimension">dimension</td>
									</tr>
									<? foreach ($datosfunnel as $informacion): ?>
									<tr onmouseover="cambiaFocoTabla(this)" class="fondoNoSelecRow" onclick="cambiaClickTabla(this)">
										<td><?= ($informacion->id) ?></td>
										<td><?= ($informacion->anio) ?></td>
										<td><?= ($informacion->mes) ?></td>
                                        <td class="ocultaTD"><?= ($informacion->ticketProm) ?></td>
										<td class="ocultaTD"><?= ($informacion->comision) ?></td>
										<td class="ocultaTD"><?= ($informacion->prospecto) ?></td>
										<td class="ocultaTD"><?= ($informacion->impacto) ?></td>
										<td class="ocultaTD"><?= ($informacion->seguimiento) ?></td>
										<td class="ocultaTD"><?= ($informacion->objetivoMensual) ?></td>
										<td class="ocultaTD"><?= ($informacion->contratoCerrar) ?></td>
										<td class="ocultaTD"><?= ($informacion->suspecto) ?></td>
										<td class="ocultaTD"><?= ($informacion->contactado) ?></td>
										<td class="ocultaTD"><?= ($informacion->cotizado) ?></td>
										<td class="ocultaTD"><?= ($informacion->pagado) ?></td>
										<td class="ocultaTD"><?= ($informacion->perfilado) ?></td>
										<td class="ocultaTD"><?= ($informacion->dimension) ?></td>
									</tr>
									<? endforeach ?>
								</table>
                                <br /><br />
					<table class="table">
						<tr>
							<td rowspan="5">
							</td>
							<td rowspan="5">100%</td>
							<td rowspan="5">
								<label style="font-size:250px">{</label>
							</td>
							<td rowspan="5" style="width:auto">
								<select size="8" style="font-size:30px; overflow:hidden;">
									<option></option>
									<option id="Otn1">100%{</option>
									<option></option>
									<option id="Otn2">100%{</option>
									<option></option>
									<option id="Otn3">100%{</option>
									<option id="Otn4">100%{</option>
								</select>
							</td>
							<td>
								<label class="letra">SUSPECTO</label>
								<img style="height: 70%;width: 100%" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL1.jpg">
							</td>
							<td>Suspecto</td>
							<td id="suspect"></td>
							<td><input type="text" id="Vsuspecto" class="textPorcentaje" />%</td>
							<td rowspan="5"><label style="font-size:200px">}</label></td>
							<td rowspan="5" id="porFinal"></td>
							<td>Dimension</td>
							<td><input type="text" id="Vdimension"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">PROSPECTO</label>
								<img style="height:70%; width:60%; display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
							</td>
							<td>Prospecto</td>
							<td id="prospect"></td>
							<td><input type="text" id="Vprospecto" class="textPorcentaje"  />%</td>
							<td>Perfilados</td>
							<td><input type="text" id="Vperfilado"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">IMPACTO</label>
                                <img style="height: 70%;width: 37%;display: block; margin-left: auto; margin-right: auto;" src="<?= base_url(); ?>assets/images/funnel/FUNNEL3.jpg">
							</td>
							<td>Impacto</td>
							<td id="impact"></td>
							<td><input type="text" id="Vimpacto" class="textPorcentaje"  />%</td>
							<td>Registrado/Contactado</td>
							<td><input type="text" id="Vcontactado"></td>
						</tr>
						<tr>
							<td>
								<label class="letra">SEGUIMIENTO</label>
								<img style="height: 70%;width: 23%;display: block; margin-left: auto; margin-right: auto; " src="<?= base_url(); ?>assets/images/funnel/FUNNEL4.jpg">
							</td>
							<td>Seguimiento</td>
							<td id="seguimient"></td>
							<td><input type="text" id="Vseguimiento" class="textPorcentaje" />%</td>
							<td>Cotizado</td>
							<td><input type="text" id="Vcotizado"></td>
						</tr>
						<tr>
							<td >
                            	<label class="letra">CIERRE</label>
                                <img style="height: 30%;width: 14%;display: block; margin-left: auto; margin-right:auto;" src="<?php echo base_url(); ?>assets/images/funnel/FUNNEL2.jpg">
							</td>
							<td>Cierre</td>
							<td id="cerrar"></td>
							<td></td>
							<td>Pagado</td>
							<td><input type="text" id="Vpagado"></td>
						</tr>
					</table>
				</div><!-- /table-responsive --> 
            </div><!-- panel-body -->
		</div><!-- panel-default -->
        
        <div class="row">
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="VticketProm">ticket promedio</label>
					<input id="VticketProm" name="VticketProm"  type="text" value="60000" class="form-control" />
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
        	<div class="col-sm-4 col-md-4">
				<div class="form-group">
					<label for="Vcomision">comision</label>
					<div class="input-group">
					<input type="text" id="Vcomision" name="Vcomision" value="15" class="form-control" />
					<span class="input-group-btn">
						<button class="btn btn-primary">%</button>
					</span>
                    </div>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
        <div class="row" align="right">
        	<div class="col-sm-12 col-md-12">
				<div class="form-group">
					<input type="button" value="Nuevo" onclick="F_append()" class="btn btn-primary"/>
					<input type="button" value="Guardar" onclick="F_guardar()"  class="btn btn-primary"/>
					<input type="button" value="Cancelar Nuevo" onclick="F_cancelar()"  class="btn btn-primary"/>
					<input type="button" value="borrar funnel" onclick="F_borrar()"  class="btn btn-primary"/>
                </div><!-- /form-group -->
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
	</section><!-- /container-fluid -->
<?php $this->load->view('footers/footer'); ?>
<script>
var rowAnterior;var objetoClickAnterior;var objetoClick;
var largoTabla=t_Funnel.rows[0].cells.length;var appen=false;

function  F_borrar(){
  var alto=t_Funnel.rows.length;var row;
for(var i=0;i<alto;i++){
  if(t_Funnel.rows[i].className=="fondoClickRow"){
   row=t_Funnel.rows[i].rowIndex;
  }
}
var idFun=t_Funnel.rows[row].cells[0].innerHTML;
  var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var rutabsoluta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    rutabsoluta=rutabsoluta+"funnel/cancelaFunnel";
  $.ajax({
    method:"POST",data:{"datos":idFun},url:rutabsoluta,dataType:"html",
    success:function(data){
t_Funnel.deleteRow(row);  
alert("El funnel fue eliminado");
    }
  })
}

function F_cancelar(){
t_Funnel.deleteRow(1);  
}


function F_guardar(){
	var mensaje=confirm("EL GUARDADO ES PARA EL FUNNEL NUEVO, DESEA PROSEGUIR");
	if(mensaje)
    { var cadena="";
	 for(var i=0;i<largoTabla;i++){
	 if((largoTabla-1)==i)
	 {cadena=cadena;cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
     cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML;
	}else
	 {cadena=cadena;
     cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
     cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML+',';
     }
	}	
	var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var rutabsoluta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    rutabsoluta=rutabsoluta+"funnel/guardaNuevo";

	$.ajax({
		method:"POST",data:{"datos":cadena},url:rutabsoluta,dataType:"html",
		success:function(data){
      console.log(data);
        	var j=JSON.parse(data);
			if(typeof(j)=="number"){
          	var valor=(-1)*(data);          	
          switch(valor){
             case 1:alert("El contrato a cerrar debe ser mayor de cero"); break;
             case 2:alert("El ticket promedio y el objetivo mensual deben ser mayores de cero"); break;
             case 3:alert("Los porcentajes deben ser mayor 0"); break;
             case 4:alert("Los porcentajes son menores o igual a 100"); break;
             case 5:alert("Error en la fecha seleccionada"); break;
             case 6:alert("Error en el mes seleccionado");break;
            }
			}
			else
			{var altoT=t_Funnel.rows.length;             
			 var row=t_Funnel.insertRow(altoT);	
       row.addEventListener("click",function(){cambiaClickTabla(this)});
       row.addEventListener("mouseover",function(){cambiaFocoTabla(this)});
       //row.className="fondoClickRow";//fondoNoSelecRow";

       
			 for(var i=0;i<largoTabla;i++){
				row.insertCell(i).innerHTML="-";
			 }	
			 var objeto=  Object.keys(j[0]);
			 var long=objeto.length;    
       for(var t=0;t<long;t++)
       {var nombre=objeto[t];
        if(document.getElementById(objeto[t]))
         {t_Funnel.rows[altoT].cells[document.getElementById(objeto[t]).cellIndex].innerHTML=j[0][nombre];          
         }
       }
      cambiaClickTabla(row);
       t_Funnel.deleteRow(1);
			}
		}
	})}else{alert("GUARDADO EN ESPERA");}   
 }



function F_append(){
var row=t_Funnel.insertRow(1);
for(var i=0; i<largoTabla;i++){
  row.insertCell(i);
  if(t_Funnel.rows[0].cells[i].id=="anio")
  {row.cells[i].innerHTML="2017";}
  if(t_Funnel.rows[0].cells[i].id=="id")
  {row.cells[i].innerHTML="NUEVO";}

  row.className="fondoRowNuevo";
  if(t_Funnel.rows[0].cells[i].id != "anio" && t_Funnel.rows[0].cells[i].id != "mes")
    {var ob="V"+t_Funnel.rows[0].cells[i].id;  	
     if(document.getElementById(ob))
     	{document.getElementById(ob).value="";}}
 }
 row.addEventListener("click",function(){cambiaClickTabla(this)}); 
 cambiaClickTabla(row);
//cambiaClickTabla(Vsuspecto);
Vsuspecto.value="100";
Vprospecto.value="100";
Vimpacto.value="100";
Vseguimiento.value="100";
suspect.innerHTML="0";
prospect.innerHTML="0";
impact.innerHTML="0";
seguimient.innerHTML="0";
}


for(var i=0; i<largoTabla;i++){	
	var obj="V"+t_Funnel.rows[0].cells[i].id;	
   if(document.getElementById(obj)){
   	 // document.getElementById(obj).addEventListener("change",function(){modificaTablaFunnel(this.id,this.value)});  
   	  document.getElementById(obj).addEventListener("change",function(){cambia(this.id)});  
   }
}

function modificaTablaFunnel(id,valor){
var columna=id.substring(1, id.length);

}

function cambiaClickTabla(objeto){
var bandNuevo=objeto.cells[0].innerHTML;
if(bandNuevo=="NUEVO"){
var largo=objeto.cells.length;
	for(var i=0;i<largo;i++){
	var idCab=objeto.parentNode.rows[0].cells[i].id;
if(document.getElementById("V"+idCab)){		
   document.getElementById("V"+idCab).value=objeto.cells[i].innerHTML;	
   document.getElementById("V"+idCab).className="fondoEditNuevo";

   if(idCab!="dimension" && idCab!="perfilado" && idCab!="pagado" && idCab!="contactado" && idCab!="cotizado" && idCab!="contratoCerrar" )   	
    {document.getElementById("V"+idCab).disabled="";}
    else{document.getElementById("V"+idCab).disabled="disabled";}  
   }
}
}else{
//if(bandNuevo!="NUEVO")
objeto.className="fondoClickRow";	

objetoClick=objeto;
var largo=objeto.cells.length;
for(var i=0;i<largo;i++){
	var idCab=objeto.parentNode.rows[0].cells[i].id;
if(document.getElementById("V"+idCab)){		
   document.getElementById("V"+idCab).value=objeto.cells[i].innerHTML;
     document.getElementById("V"+idCab).className="fondoEditExistente";
        document.getElementById("V"+idCab).disabled="disabled";       
   }	
}
if(objetoClickAnterior){objetoClickAnterior.className="fondoNoSelecRow";}
//if(bandNuevo!="NUEVO")	
objetoClickAnterior=objeto;
}
cambia();
}

function cambiaFocoTabla(objeto){
if(objeto.className!="fondoClickRow")
 {objeto.className="fondoSelecRow";
  if(rowAnterior && rowAnterior.className!="fondoClickRow")
  {rowAnterior.className="fondoNoSelecRow";}
   rowAnterior=objeto;
  }
}


function cambia(id){
var n1=Number(Vseguimiento.value);
var n2=Number(Vimpacto.value);
var n3=Number(Vprospecto.value);
var n4=Number(Vsuspecto.value);
var n5=Number(VobjetivoMensual.value);
var n6=Number(VticketProm.value);
var n7=Number(Vcomision.value)

if(!isNaN(n1) && n1>0 && !isNaN(n2) && n2>0 && !isNaN(n3) && n3>0 && !isNaN(n4) && n4>0 && n5>0 && !isNaN(n5)  && !isNaN(n6) && n6>0 && !isNaN(n7) && n7>0  ){
var calculado=(VcontratoCerrar.value*100)/Vseguimiento.value;
t_Funnel.rows[1].cells[seguimiento.cellIndex].innerHTML=Vseguimiento.value;//Math.round(calculado);
seguimient.innerHTML=Math.round(calculado);
if(!isNaN(Vimpacto.value))
calculado=(calculado*100)/Vimpacto.value;

t_Funnel.rows[1].cells[impacto.cellIndex].innerHTML=Vimpacto.value;//Math.round(calculado);

  impact.innerHTML=Math.round(calculado);
if(Vprospecto.value>0)
calculado=(calculado*100)/Vprospecto.value;
t_Funnel.rows[1].cells[prospecto.cellIndex].innerHTML=Vprospecto.value;//Math.round(calculado);
prospect.innerHTML=Math.round(calculado);
if(Vsuspecto.value>0)
calculado=(calculado*100)/Vsuspecto.value;
t_Funnel.rows[1].cells[suspecto.cellIndex].innerHTML=Vsuspecto.value;//Math.round(calculado);
suspect.innerHTML=Math.round(calculado);
porFinal.innerHTML=Math.round((VcontratoCerrar.value*100)/calculado)+"%";
Otn4.innerHTML=Vseguimiento.value+"%{";
Otn3.innerHTML=Vimpacto.value+"%{";
Otn2.innerHTML=Vprospecto.value+"%{";
Otn1.innerHTML=Vsuspecto.value+"%{";

if(id!="Vmes" && id!="Vanio"){
cantidad=Vcomision.value/100;
cantidad=cantidad*VticketProm.value;
var objetivo=VobjetivoMensual.value / cantidad;
entero=Math.floor(objetivo);
var contrato;
if(entero-objetivo==0){contrato=entero}
else{contrato=entero+1; } 
VcontratoCerrar.value=contrato;
cerrar.innerHTML=contrato;
t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML=contrato;
if(!isNaN(n1) && n1==0){Vseguimiento.value=100;}
if(!isNaN(n2) && n2==0) { Vimpacto.value=100;} 
if(!isNaN(n3) && n3==0){Vprospecto.value=100;} 
if(!isNaN(n4) && n4==0 ){Vsuspecto.value=100;} 
if(!isNaN(n1) && n1==100 && !isNaN(n2) && n2==100 && !isNaN(n2) && n3==100 && !isNaN(n2) && n4==100){
  impact.innerHTML=contrato;
  prospect.innerHTML=contrato;suspect.innerHTML=contrato;seguimient.innerHTML=contrato;porFinal.innerHTML="100%"}
}


}
if(id=="VobjetivoMensual" || id=="VticketProm" || id=="Vcomision" || id=="Vmes" || id=="Vanio"){
var columna=id.substring(1, id.length);
t_Funnel.rows[1].cells[document.getElementById(columna).cellIndex].innerHTML=document.getElementById(id).value;
}
/*if(id!="Vmes" && id!="Vanio"){
cantidad=Vcomision.value/100;
cantidad=cantidad*VticketProm.value;
var objetivo=VobjetivoMensual.value / cantidad;
entero=Math.floor(objetivo);
var contrato;
if(entero-objetivo==0){contrato=entero}
else{contrato=entero+1;	}	
VcontratoCerrar.value=contrato;
t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML=contrato;
if(!isNaN(n1) && n1==0){Vseguimiento.value=100;}
if(!isNaN(n2) && n2==0) { Vimpacto.value=100;} 
if(!isNaN(n3) && n3==0){Vprospecto.value=100;} 
if(!isNaN(n4) && n4==0 ){Vsuspecto.value=100;} 
}*/
}

function calcular(){
cantidad=Vcomision.value/100;cantidad=cantidad*VticketProm.value;
var objetivo=VobjetivoMensual.value / cantidad;
entero=Math.floor(objetivo);var contrato;
if(entero-objetivo==0){contrato=entero}
else{contrato=entero+1;	}	
VcontratoCerrar.value=contrato;
t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML=contrato;
var n1=Number(Vseguimiento.value);
var n2=Number(Vimpacto.value);
var n3=Number(Vprospecto.value);
var n4=Number(Vsuspecto.value);

if(!isNaN(n1) && n1==0){
 Vseguimiento.value=100;
}
if(!isNaN(n2) && n2==0) { Vimpacto.value=100;} 
if(!isNaN(n3) && n3==0){Vprospecto.value=100;} 
if(!isNaN(n4) && n4==0 ){Vsuspecto.value=100;} 
cambia();		
}
cambiaClickTabla(t_Funnel.rows[1]);
</script>