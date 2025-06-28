<style type="text/css">
#loader {position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999;background: url('assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);opacity: .8;}
</style>
<div id="loader"></div>
<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="well">
				<table width="60%">
					<tr>
						<td><i class="fa fa-calendar"></i>&nbsp;Fecha Desde:</td>
						<td>
							<input type="date" name="fdesde" id="fdesde" class="form-control">
						</td>
						<td>&nbsp;<i class="fa fa-calendar"></i>&nbsp;Fecha Hasta:</td>
						<td>
						<input type="date" name="fhasta" id="fhasta" class="form-control">
						</td>
						<td>
							<button class="btn btn-primary btn-sm" onclick="consulta_kpi_fechas()"><i class="fa fa-check"></i>
							Consultar</button>
						</td>
					</tr>
                    <tr><td><?if($error>0){?><div><label class="label label-warning">Se produjo un error al conectar con sicas <? echo($error)?></label></div><?}?></td></tr>
					
				</table>
		</div>
	</div>
</div>
<div id="panel">
	<?php $this->load->view('reportes/cobranzakpi_detalle_resumen');?>
</div><!--fin de panel-->

<script type="text/javascript">
document.getElementById('loader').style.display="none";
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}
//Funcion para exportar en excel
function exportarExcel(){
	var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange;
    var j = 0;
    tab = document.getElementById('tablaGeneral');
    tabs = document.getElementById('tablaSecundaria');
    for (j = 0 ; j < tab.rows.length ; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
    }

    for (j = 0 ; j < tabs.rows.length ; j++) {
        tab_text = tab_text + tabs.rows[j].innerHTML + "</tr>";
    }

    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    return (sa);
}



function consulta_kpi_fechas(){
	var fdesde=document.getElementById('fdesde').value;
 	var fhasta=document.getElementById('fhasta').value;
 	if((fdesde=='')||(fhasta=='')){
 		alert('Debe seleccionar un rango de fechas');
 	}else{
 		document.getElementById('loader').style.display="block";
 		divResultado = document.getElementById('panel'); 
	    ajax=objetoAjax();   
	    var URL=document.getElementById('base').value+"cobranzakpi/index?fdesde="+fdesde+"&fhasta="+fhasta;
	    ajax.open("GET", URL);
	    ajax.onreadystatechange=function() {
	        if (ajax.readyState==4) {
	           divResultado.innerHTML = ajax.responseText
	            document.getElementById('loader').style.display="none";
	        }
	    }
	      ajax.send(null) 
	}
}
</script>