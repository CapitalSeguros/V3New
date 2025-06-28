<?php
  $this->load->view('headers/headerReportes'); 
?>
<?php
  $this->load->view('headers/menu');
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
/*
html,body { 
	overflow-x: hidden;
	overflow-y: hidden;
}
*/
.ocultarElemento{display: none;}
.verElemento{display:  table-row; }
#tabla thead {

  position: -webkit-sticky;
  position: sticky;
  z-index: 2;
  top: 0;
}
</style>
 
	<section class="container-fluid breadcrumb-formularios">
		<div class="row">
			<div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Reportes</h3></div>
			<div class="col-md-6 col-sm-7 col-xs-7">
				<ol class="breadcrumb text-right">
                    <li class="active"><a>Honorarios</a></li>
                </ol>
            </div>
        </div>
		<hr /> 
	</section>

	<section class="container-fluid"><!-- container-fluid -->
		<form  action="<?=base_url();?>honorarios/buscaHonorarios" method="POST" style="width: 100%">
		<div class="row">
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="opcionHonorario">Buscar</label>
						<select class="form-control" name="opcionHonorario" onchange="verFechas()" id="opcionHonorario">
							<option value="1">Pagados</option>
							<option value="2">Pendientes</option>
						</select>
					</div>
				</div>
			<div id="verFechas">
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fIni">Fecha inicial</label>
						<input type="text" class="datepicker form-control" name="fIni" id="fIni">
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
					<div class="form-group">
						<label for="fFin">Fecha final</label>
						<input type="text" class="datepicker form-control" name="fFin" id="fFin">
					</div>
				</div>
			</div><!-- /verFechas -->
		</div><!-- /row -->
		<div class="row">
				<div class="col-sm-8 col-md-8">
					<div class="form-group">
					<? if(isset($vendedorCombo)){ ?>
						<label for="vendedor">Agente</label>
						<input type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro" class="form-control" style="text-align: left;" placeholder="Buscador">
                        <select name="vendedor" id="vendedor" class="form-control">
						<option>SELECCIONE UN AGENTE</option>
						<? foreach ($vendedorCombo as $row){ ?>
							<option value="<?= ($row->IDVend ) ?>"><?= ($row->name_complete) ?></option>
						<? } ?>
						</select>
					<? } ?>
					</div>
				</div>
				<div class="col-sm-4 col-md-4">
                	<br />
					<div class="form-group">
						<button type="submit" class="btn btn-primary" name="Consulta" id="Consulta" value="buscar">Buscar</button>
						<button type="submit" class="btn btn-primary" name="button" id="button" value="Exportar" onclick="descargarExcel()">Descagar excel</button>
					</div>
				</div>
		</div><!-- /row -->
		</form>

        	        
		<div class="panel panel-default">
			<div class="panel-body">


<div onscroll="moverScroll()" id="scrollTabla" style="width:1000;overflow-x:scroll;overflow-y: scroll;height: 500px;">
  
      <table class="table table-hover table-bordered" style="width:100%" id="tabla" >
        <thead style="width: 100%;" >
        <tr>    
          <th >Documento</th>
          <th >Desde</th>
          <th >Serie</th>
          <th >Nombre</th>
          <th >FormaPago</th>
          <th >PrimaNeta</th>
          <th >Ramo</th>
          <th >PorPart</th>
          <th >Importe</th>
          <th >TCDocto</th>
          <th >Moneda</th>
          <th >TCPago</th>
          <th >Importe</th>
          </tr>     
        </thead>
       <tbody style="width: 100%;">
       
        <?
         $total=0;
        if (isset($TableInfo)){ 

         ?>
          <script type="text/javascript">
        <? if(isset($vendedorCombo)){ ?>
        document.getElementById("vendedor").value=<? echo($idVendedor)  ;
          }
         ?>;
        document.getElementById("opcionHonorario").value= <? echo($opcionHonorario)  ?>;
        if(document.getElementById("opcionHonorario").value==2){
          document.getElementById('verFechas').style.display='none';
         }
         else
         {
          document.getElementById('verFechas').style.display='block';
         }
      
          </script>      
        <?
        foreach($TableInfo as $table) { ?>        
         <tr  >
          <td > <?echo $table->Documento?></td>
          <td > <?echo(date("d-m-y",strtotime((string)$table->FDesde))) ;?></td>
          <td > <?echo $table->Serie?></td>
          <td > <?echo $table->NombreCompleto?></td>
          <td > <?echo $table->FormaPago?></td>            
          <td >$<?echo number_format((double) $table->PrimaNeta,2,'.',','); ?></td>
          <td > <?echo $table->SRamoNombre?></td>
          <td >$<?echo number_format((double) $table->PorPart,2,'.',','); ?></td>
          <td>$<?echo number_format((double) $table->Importe,2,'.',','); ?></td>
          <td > <?echo $table->TCDocto?></td>
          <td > <?echo $table->Moneda?></td>
          <td > <?echo $table->TCPago?></td>
          <td >$<?echo number_format((double) $table->Importe,2,'.',','); ?></td>
         </tr>

        <?;
		$total+=$table->Importe;
        }  
        } 
  
        ?>
		<tr>    
          <th >Total</th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th >$<?echo number_format((double) $total,2,'.',',');?></th>
          <th ></th>
          <th ></th>
          <th ></th>
          <th >$<?echo number_format((double) $total,2,'.',',');?></th>
          </tr>  
       </tbody>

      </table> 
     

  </div>
            
            </div><!-- panel-body -->
		</div><!-- panel-default -->
	
    <div id="capaInvisible" style="visibility: hidden;height: 1px"></div>
	
    </section><!-- /container-fluid -->

<script type="text/javascript">
function filtrarBusqueda(){
  var busqueda=document.getElementById('vendedor');
  var filtro=document.getElementById('txtBuscarFiltro').value.toUpperCase();
  var contador=busqueda.length;var text="";
  for(var j=1;j<contador;j++)
    {text=busqueda[j].innerHTML;
      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarElemento');}
      else{ busqueda[j].classList.add('ocultarElemento'); busqueda[j].classList.remove('verElemento');}}
}

function moverScroll(){

   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}
function verFechas()
{
	var comboBusqueda=document.getElementById('opcionHonorario');

	 if (comboBusqueda.value==1){
	 	document.getElementById('verFechas').style.display='block';
	 }
	 else
	 {
	 document.getElementById('verFechas').style.display='none';	
	 }
}
     var bandera="0";
	
  <? if (isset($TableInfo) ){ ?>
       bandera="1";
      var fechaInicial=<? echo ('"'.$fechaInicial.'";'); ?>
      var fechaFinal=<? echo ('"'.$fechaFinal.'";'); ?>
      

  <? } ?>  

function descargarExcel()
{    
 var agente=navigator.userAgent;
 var navegadores=["Chrome","Firefox","Opera","Trident","MSIE","Edge","OPR"];
 var navegadorUsado="";

 for(var i=0 in navegadores)
  {if(agente.indexOf(navegadores[i])>-1)
       {navegadorUsado=navegadores[i];}
  }
       var miTabla=document.getElementById('tabla');
         var contador=tabla.rows[0].cells.length;
         var cont=tabla.rows.length;            
  var cadena='<table id="tablaCopia" class="table table-striped"><tr>';
 var argumento=0;
for(var i=argumento;i<contador;i++){
  cadena=cadena+'<td>'+tabla.rows[0].cells[i].innerHTML+'</td>';
}
  cadena=cadena+'</tr>';


  for(var t=1;t<cont;t++)
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
        tmpElemento.download = "honorarios";///argumento2; 
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
       myWindow.name="honararios";//argumento2;
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
</script>
<script src="<?=base_url();?>assets/js/honorarios.js"></script>
<?php 
	$this->load->view('footers/footer'); 
?>