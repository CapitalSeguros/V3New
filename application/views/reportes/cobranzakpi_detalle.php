<?php 
  $this->load->view('headers/header'); 
  $this->load->view('headers/headerReportes');
  $this->load->view('headers/menu');
?>
<style type="text/css">
	#table_id thead{
		background-color: #66449f;
		color: #fff;
	    font-size: 11px;
	}
	#table_id tbody{
		font-size: 11px;
	}
	#loader {
	    position: fixed;
	    left: 0px;
	    top: 0px;
	    width: 100%;
	    height: 100%;
	    z-index: 9999;
	    background: url('../assets/images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
	    opacity: .8;
	}
</style>
<br>
<div id="loader" style="display: none;"></div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<div style="text-align: left;margin-bottom: 1%;margin-left: 4%;float: left;margin-right:2%;"><a href="<?php echo base_url()?>cobranzakpi/index"><button class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Volver</button></a></div><div style="text-align: left;margin-bottom: 1%;margin-left: 4%;"><a href="#" onclick="exportarExcel()"><button class="btn btn-success btn-xs" style="color: #fff;"><i class="fa fa-download"></i> Descargar</button></a></div>

<div class="container" style="background-color: #fff;width: 100%">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h4 class="titulo-secciones">
            <i class="glyphicon glyphicon-equalizer"></i> Detalles Reporte KPI´s Cobranza Pendiente
        </h4>
      </div>
    </div>
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div class="well">
				<table width="100%">
					<tr>
						<td><i class="fa fa-calendar"></i>&nbsp;Fecha Desde:</td>
						<td>
							<input type="date" name="fdesde" id="fdesde" class="form-control">
						</td>
						<td>&nbsp;<i class="fa fa-calendar"></i>&nbsp;Fecha Hasta:</td>
						<td>
						<input type="date" name="fhasta" id="fhasta" class="form-control">
						</td>
						<td>&nbsp;<i class="fa fa-calendar"></i> &nbsp;Fecha Corte:</td>
						<td><input type="date" name="fcorte" id="fcorte" class="form-control"></td>
						<td>
							<button type="button" class="btn btn-primary btn-sm" onclick="getAllCobranzaXfechas()"><i class="fa fa-check"></i>
							Consultar</button>
						</td>
					</tr>
				</table>
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-md-12 col-lg-12">
			<div id="panel">
				<?php $this->load->view('reportes/cobranzakpi_detalle_grid');?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
/* Ajax*/
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

function getAllCobranzaXfechas(){
		var fdesde=document.getElementById('fdesde').value;
		var fhasta=document.getElementById('fhasta').value;
		if((fdesde=='')||(fhasta=='')){
 			alert('Debe seleccionar un rango de fechas');
 		}else{
 			document.getElementById('loader').style.display="block";
 			divResultado = document.getElementById('panel'); 
	    	ajax=objetoAjax();   
	    	var URL="<?php echo base_url()?>"+"cobranzakpi/getAllCobranzaXfechasPendiente?fdesde="+fdesde+"&fhasta="+fhasta;
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

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript">
	$(document).ready( function () {
     $('#table_id').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Registros por Pagina",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrar Pagina por Pagina",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtrado de _MAX_ total registros)",
            "search":"Buscar",
            "paginate": {
      			"previous": "Anterior",
      			"next": "Siguiente"
    		}
        }
    } );
} );

//Funcion para exportar en excel
function exportarExcel(){
	var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange;
    var j = 0;
    tab = document.getElementById('table_id');
    for (j = 0 ; j < tab.rows.length ; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
    }
    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // remove input params
    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    return (sa);
}
</script>
