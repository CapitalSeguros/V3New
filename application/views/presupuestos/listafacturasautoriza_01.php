<script src="<?php echo(base_url())?>assets/js/bGenericV1.js"></script>

<?php
$busquedaUsuario = $this->input->get('busquedaUsuario', TRUE);
$totalResultados = $Listafacturas->num_rows();
$sumapre = $presuma;

?>
<?php $this->load->view('headers/header'); ?>
<?php $this->load->view('headers/menu');?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  
    $( function(){$( "#1fNacimiento" ).datepicker({          
            dateFormat: 'yy-mm-dd',});} );
</script>



<?  
    $colorRef[0] = "5";
    $colorRef[1] = "8";
    $colorRef[2] = "11";
    $colorRef[3] = "14";
    $colorRef[4] = "17";
    $colorRef[5] = "20";
    $colorRef[6] = "23";
    $colorRef[7] = "26";
    $colorRef[8] = "29";
    $colorRef[9] = "32";
    $colorRef[10] = "33"; //solo llegan a 34 los colores de la libreira
    $colorRef[11] = "34";
    $colorRef[12] = "";
    $colorRef[13] = "";
    $colorRef[14] = "";

    $graficaRef     = base_url().'assets/plugins/GraPHPico_0-0-3/graphref.php?ref=';
    $graficaBarras  = base_url()."assets/plugins/GraPHPico_0-0-3/graphbarras.php?dat=";
    $graficaPastel  = base_url()."assets/plugins/GraPHPico_0-0-3/graphpastel.php?dat=";
    $graficaPorcen  = base_url()."assets/plugins/GraPHPico_0-0-3/graphporcentaje.php?fil=";
?>

<meta name="viewport" content="width=900px"/>

<script language="javascript" type="text/javascript">


    function MakeStaticHeader(gridId, height, width, headerHeight, isFooter) {
        var tbl = document.getElementById(gridId);
        if (tbl) {
        var DivHR = document.getElementById('DivHeaderRow');
        var DivMC = document.getElementById('DivMainContent');
        var DivFR = document.getElementById('DivFooterRow');

        //*** Set divheaderRow Properties ****
        DivHR.style.height = headerHeight + 'px';
        DivHR.style.width = (parseInt(width) - 16) + 'px';
        DivHR.style.position = 'relative';
        DivHR.style.top = '0px';
        DivHR.style.zIndex = '10';
        DivHR.style.verticalAlign = 'top';

        //*** Set divMainContent Properties ****
        DivMC.style.width = width + 'px';
        DivMC.style.height = height + 'px';
        DivMC.style.position = 'relative';
        DivMC.style.top = -headerHeight + 'px';
        DivMC.style.zIndex = '1';

        //*** Set divFooterRow Properties ****
        DivFR.style.width = (parseInt(width) - 16) + 'px';
        DivFR.style.position = 'relative';
        DivFR.style.top = -headerHeight + 'px';
        DivFR.style.verticalAlign = 'top';
        DivFR.style.paddingtop = '2px';

        if (isFooter) {
         var tblfr = tbl.cloneNode(true);
      tblfr.removeChild(tblfr.getElementsByTagName('tbody')[0]);
         var tblBody = document.createElement('tbody');
         tblfr.style.width = '100%';
         tblfr.cellSpacing = "0";
         //*****In the case of Footer Row *******
         tblBody.appendChild(tbl.rows[tbl.rows.length - 1]);
         tblfr.appendChild(tblBody);
         DivFR.appendChild(tblfr);
         }
        //****Copy Header in divHeaderRow****
        DivHR.appendChild(tbl.cloneNode(true));
     }
    }


    function OnScrollDiv(Scrollablediv) {
    document.getElementById('DivHeaderRow').scrollLeft = Scrollablediv.scrollLeft;
    document.getElementById('DivFooterRow').scrollLeft = Scrollablediv.scrollLeft;
    }

    window.onload = function() {
   MakeStaticHeader('Mitabla', 550, 1750, 40, false)
}

 function traeInfo() {
    
   var parametros = {"id" :document.getElementById("usuariosPresupuestosSelect").value,"aperturaContable":document.getElementById("selectAperturaContable").value,"fechaFactura":document.getElementById("selectFechaFactura").value};
   var direccion="<?php echo(base_url().'presupuestos/devuelveFacturasUsuario/'); ?>";
   $.ajax({method: "POST",data: parametros ,url : direccion,dataType: "html",
     success : function(datat)
     {    
     
       j=JSON.parse(datat);   
      
        var objInsertar='<table border="1" class="tablaReporte">';
        objInsertar=objInsertar+'<thead><tr class="cabecera"><td></td><td>MES</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td>Saldo mes</td></tr></thead>';
         objInsertar=objInsertar+'<tbody>';
        var tamanio=j.tabla.length;
        var sumPresupuestos=0;
        var sumGastos=0;
        var sumAutorizado=0;
        var sumPagado=0;
        var sumSaldo=0;
      var numeroFlot=0; var formato=0;var cadPresupuesto="";var cadPagado="";
        for(var i=0;i<tamanio;i++){
         objInsertar=objInsertar+'<tr  onclick="muestraPart(this)"><td onclick="muestraPart(this)" class="abrePart">+</td>';

         objInsertar=objInsertar+'<td  class="tdPrimerCol">'+j.tabla[i][0]+'</td>';
         objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][1])+'</td>';
         cadPresupuesto=cadPresupuesto+j.tabla[i][1]+"-";
          
          objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][3])+'</td>'
             cadPagado=cadPagado+j.tabla[i][3]+"-";
          objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][4])+'</td>'
               
        if((j.tabla[i][1]-j.tabla[i][2])>=0){
         objInsertar=objInsertar+'<td align="right" class="tdSegundaCol">'+formatoMoneda((j.tabla[i][1]-j.tabla[i][2]))+'</td>'
         }else{
          objInsertar=objInsertar+'<td align="right" class="tdNegativaCol">'+formatoMoneda((j.tabla[i][1]-j.tabla[i][2]))+'</td>'
         }
         objInsertar=objInsertar+'</tr>'; 
                 if(j.detalle!=undefined){

          objInsertar=objInsertar+'<tr><td colspan="5"><table border="2" class="partOculto"><tbody><tr class="cabeceraDetalle"><td>Departamento</td><td>Presupuesto</td><td>Autorizado</td><td>Pagado</td><td>Total</td></tr>'; 
          var puesto='SISTEMAS@ASESORESCAPITAL.COM'
               //console.log(j.detalle[puesto]['ABRIL'][0]);
               
                   for(var m=1;m<usuariosPresupuestosSelect.length;m++){
        //console.log(usuariosPresupuestosSelect[i].innerHTML);
                  objInsertar=objInsertar+'<tr><td>'+usuariosPresupuestosSelect[m].innerHTML+'</td>'
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][0])+'</td>';
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][1])+'</td>';
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][2])+'</td>';
                  var totalDetalle=(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][0]-j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][1]);
                 if(totalDetalle>=0){ 
                  objInsertar=objInsertar+'<td align="right" class="tdColDetalle">'+formatoMoneda(totalDetalle)+'</td></tr>';
                   }else{objInsertar=objInsertar+'<td align="right" class="tdNegativoDetalle">'+formatoMoneda(totalDetalle)+'</td></tr>';}
                  }
          objInsertar=objInsertar+'</tbody></table></td></tr>';
         } 
         sumPresupuestos=sumPresupuestos+parseFloat(j.tabla[i][1]);
         sumGastos=sumGastos+parseFloat(j.tabla[i][2]);
         sumAutorizado=sumAutorizado+parseFloat(j.tabla[i][3]);
         sumPagado=sumPagado+parseFloat(j.tabla[i][4]);
         sumSaldo=sumSaldo+(j.tabla[i][1]-j.tabla[i][2]);
        }
         objInsertar=objInsertar+'<tr>';

         objInsertar=objInsertar+'<td></td><td class="tdPrimerCol">TOTALES</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumPresupuestos)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumAutorizado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumPagado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumSaldo)+'</td>'
         objInsertar=objInsertar+'</tr>'; 
       objInsertar=objInsertar+'</tbody>';
        objInsertar=objInsertar+'</table>';
        document.getElementById('tablaReporte').innerHTML=objInsertar;      
      limpiaCanvas();      
        cargarGrafica(cadPresupuesto,cadPagado);        
    }
    })
  }

function cargarDatos(){
      var xhr=new XMLHttpRequest();url="https://capsys.com.mx/V3/"+controlador;xhr.open('POST',url,true);
        xhr.onload=function(){if(this.status==200){document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   divContenido.innerHTML=xhr.responseText;}
        xhr.send();
}


 function traeInfoAperturaContable() {
    
   var parametros = {"id" :document.getElementById("usuariosPresupuestosSelect").value,"aperturaContable":document.getElementById("selectAperturaContable").value,"fechaFactura":document.getElementById("selectFechaFactura").value,"idPersonaDepartamento":document.getElementById("selectDepartamentos").value};
   var direccion="<?php echo(base_url().'presupuestos/devuelveFacturasUsuarioAC/'); ?>";
   $.ajax({method: "POST",data: parametros ,url : direccion,dataType: "html",
     success : function(datat)
     {    
     
       j=JSON.parse(datat);   
      
        var objInsertar='<table border="1" class="tablaReporte">';
        objInsertar=objInsertar+'<thead><tr class="cabecera"><td></td><td>MES</td><td>Presupuesto total</td><td>Autorizado</td><td>Pagado</td><td>Saldo mes</td></tr></thead>';
         objInsertar=objInsertar+'<tbody>';
        var tamanio=j.tabla.length,sumPresupuestos=0,sumGastos=0,sumAutorizado=0;sumPagado=0;sumSaldo=0;
        var numeroFlot=0,formato=0,cadPresupuesto="",cadPagado="";
        for(var i=0;i<tamanio;i++){
         objInsertar=objInsertar+'<tr  onclick="muestraPart(this)"><td onclick="muestraPart(this)" class="abrePart">+</td>';
         objInsertar=objInsertar+'<td  class="tdPrimerCol">'+j.tabla[i][0]+'</td>';
         objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][1])+'</td>';
         cadPresupuesto=cadPresupuesto+j.tabla[i][1]+"-";          
          objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][3])+'</td>'
             cadPagado=cadPagado+j.tabla[i][3]+"-";
          objInsertar=objInsertar+'<td align="right" class="tdCol">'+formatoMoneda(j.tabla[i][4])+'</td>'               
        if((j.tabla[i][1]-j.tabla[i][2])>=0){objInsertar=objInsertar+'<td align="right" class="tdSegundaCol">'+formatoMoneda((j.tabla[i][1]-j.tabla[i][2]))+'</td>'}
        else{objInsertar=objInsertar+'<td align="right" class="tdNegativaCol">'+formatoMoneda((j.tabla[i][1]-j.tabla[i][2]))+'</td>'}
         objInsertar=objInsertar+'</tr>'; 
                 if(j.detalle!=undefined){

          objInsertar=objInsertar+'<tr><td colspan="5"><table border="2" class="partOculto"><tbody><tr class="cabeceraDetalle"><td>Departamento</td><td>Presupuesto</td><td>Autorizado</td><td>Pagado</td><td>Total</td></tr>'; 
          var puesto='SISTEMAS@ASESORESCAPITAL.COM'
               
                   for(var m=1;m<usuariosPresupuestosSelect.length;m++){

                  objInsertar=objInsertar+'<tr><td>'+usuariosPresupuestosSelect[m].innerHTML+'</td>'
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][0])+'</td>';
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][1])+'</td>';
                  objInsertar=objInsertar+'<td align="right">'+formatoMoneda(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][2])+'</td>';
                  var totalDetalle=(j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][0]-j.detalle[usuariosPresupuestosSelect[m].innerHTML][j.tabla[i][0]][1]);
                 if(totalDetalle>=0){ 
                  objInsertar=objInsertar+'<td align="right" class="tdColDetalle">'+formatoMoneda(totalDetalle)+'</td></tr>';
                   }else{objInsertar=objInsertar+'<td align="right" class="tdNegativoDetalle">'+formatoMoneda(totalDetalle)+'</td></tr>';}
                  }
          objInsertar=objInsertar+'</tbody></table></td></tr>';
         } 
         sumPresupuestos=sumPresupuestos+parseFloat(j.tabla[i][1]);
         sumGastos=sumGastos+parseFloat(j.tabla[i][2]);
         sumAutorizado=sumAutorizado+parseFloat(j.tabla[i][3]);
         sumPagado=sumPagado+parseFloat(j.tabla[i][4]);
         sumSaldo=sumSaldo+(j.tabla[i][1]-j.tabla[i][2]);
        }
         objInsertar=objInsertar+'<tr>';

         objInsertar=objInsertar+'<td></td><td class="tdPrimerCol">TOTALES</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumPresupuestos)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumAutorizado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumPagado)+'</td>'
         objInsertar=objInsertar+'<td align="right" class="tdPrimerCol">'+formatoMoneda(sumSaldo)+'</td>'
         objInsertar=objInsertar+'</tr>'; 
       objInsertar=objInsertar+'</tbody>';
        objInsertar=objInsertar+'</table>';
        document.getElementById('tablaReporte').innerHTML=objInsertar;      
      limpiaCanvas();      
        cargarGrafica(cadPresupuesto,cadPagado);        
    }
    })
  }

  function muestraPart(objeto){
  if(objeto.parentNode.nextSibling.firstChild.firstChild.className=="partVisible")
  {objeto.parentNode.nextSibling.firstChild.firstChild.className="partOculto";
  objeto.innerHTML="+";}
 else{objeto.parentNode.nextSibling.firstChild.firstChild.className="partVisible";
 objeto.innerHTML="-";}

}
 </script>
<?php if($tipoVista=="controlPresupuesto"){    ?>
<div style="width: 99%; height: 400px;border: double;overflow: scroll; ">
<div class="row">
<div  class="col-md-3 col-sm-3 col-xs-3">
      <label class="etiquetaSimple">Departamenos</label>
  <select id="usuariosPresupuestosSelect" class="form-control">
     <option>TODOS</option>
      <?php
       foreach ($usuariosPresupuestos->result() as $row){ ?><option><?php echo($row->usuario); ?></option><?php } ?>}
 </select>
</div>
<div class="col-md-3 col-sm-3 col-xs-3">
  <label class="etiquetaSimple" >Departamentos</label><?= imprimirDepartamentos($departamentos);?></div>
</div>
<div class="col-md-3 col-sm-3 col-xs-3"><label class="etiquetaSimple" >Apertura contable</label><?= imprimirAperturaContable($aperturaContable);?></div>
  <div  class="col-md-3 col-sm-3 col-xs-3"><label class="etiquetaSimple">Fecha</label><select class="form-control" id="selectFechaFactura"><option value="fecha_factura">Fecha factura</option><option value="fecha_pago">fecha pago</option></select></div>
  <div  class="col-md-3 col-sm-1 col-xs-1"><button onclick="traeInfo()" class='btn btn-primary btn-xs contact-item'>Buscar</button><button onclick="traeInfoAperturaContable()" class='btn btn-primary btn-xs contact-item'>Buscar2</button></div>
</div>
<table>
  <tr>
    <td><div id="tablaReporte"></div></td>
    <td><canvas height="300px" width="1300px" style="" id="lienzo" ">   </canvas></td>
  </tr>
</table>
<?php } 
 else{
?>

</div>
 <section class="container-fluid breadcrumb-formularios"><div  class="col-md-3 col-sm-3 col-xs-3"><h4 class="titulo-secciones">Autoriza Pagos</h4></div></section>
<section class="container-fluid breadcrumb-formularios">

<div id="DivRoot" align="left">


    <div style="overflow:scroll;" onscroll="OnScrollDiv(this)" id="DivMainContent">
        <!--Place Your Table Heare-->
                    <div class="table-responsive">
						<table class="table" id='Mitabla'>
							<thead>
		              <tr>
                  <th>Id</th>
                  <th>Solicitado por</th>
                  <th>Fecha Factura</th>
									<th>FolioFac</th>				                                
									<th>Concepto</th>			                                
                  <th>Importe</th>               
                  <th>AcumuladoMes</th>
                  <th>LimiteMes</th>
                  <th>AcumuladoAnual</th>
                  <th>LimiteAnual</th>
                  <th>Autorizado</th>
                  <th>Proveedor</th>									
								</tr>
							</thead>
							<tbody>   
							<?php if($Listafacturas != FALSE){echo (imprimirFacturas($Listafacturas->result()));}?>
							</tbody>
              <?if($totalResultados == 0){?><tfoot><tr><td colspan="4"><center><b>No se encontraron registros.</b></center></td></tr></tfoot><?
								}
							?>
						</table>
               		</div>
    <div id="DivFooterRow" style="overflow:hidden">
    </div>
</div>
 <!--div class="row"><div class="col-md-12"><i>Suma de SubTotales a Autorizar: <b><? echo "$"; echo number_format($sumapre,2); ?></b></i></div></div-->
</section>
<?php } ?>
 
<?php $this->load->view('footers/footer'); ?>
<style type="text/css">/*#91d198*/
.cabecera{background-color: rgba(197,217,241,1);color: rgba(0,0,0,1);}
.cabeceraDetalle{background-color: rgba(145,209,152,1);color: rgba(0,0,0,1);}
.tablaReporte{padding: 2px;border: 1px solid #4CAF50; margin-left: 50px}
.tdPrimerCol{background-color: rgba(220,230,241,1);color: rgba(0,0,0,1);}
.tdSegundaCol{background-color: rgba(198,239,206,1);color: rgba(0,97,0,1);}
.tdNegativaCol{background-color: rgba(224,137,137,1);color: rgba(121,4,4,1);}
.tdCol{background-color: rgba(255,255,255,1);color: rgba(0,0,0,1);}
.tdNegativoDetalle{background-color: red}

.partVisible{display: block}
.partOculto{display: none}
tr.rowColor:hover   {background-color: #99CCCC;}
.trReporteCab{background-color: #3e6db9; color: black}
.trReportePol{background-color: #9ebef5; color: black;}
.trReportePol:hover  {background-color: #ff6600}
.trReporPartCab{background-color: #bedafb; color: black;}
.trReporPart:hover {background-color: #ff6600; color: white;}
.abrePart:hover{ cursor: pointer; background-color: #361866 }
</style>
<?php 
function imprimirAperturaContable($datos){
  $select='<select class="form-control" id="selectAperturaContable">';
    foreach ($datos as $value) {
      $select.='<option value="'.$value->idAperturaContable.'">'.$value->idAperturaContable.'('.$value->anioAC.')</option>';
    }
    $select.='</select>';
  return $select;
}
function imprimirDepartamentos($datos){
  
  $select='<select class="form-control" id="selectDepartamentos">';
    foreach ($datos as $value) {
      $select.='<option value="'.$value->idPersonaDepartamento.'">'.$value->personaDepartamento.'</option>';
    }
    $select.='</select>';
  return $select;
}

function imprimirFacturas($array)
{
    $body='';
    $ci = &get_instance();
    $ci->load->model("capsysdre");
    $ci->load->model("contabilidadmodelo");
    $body=array();
    $body[0]='';
    $body[1]='';
    $body[2]='';
    $body[3]='';
    $sumImporte=array();
    $sumImporte[0]=0;
    $sumImporte[1]=0;
    $sumImporte[2]=0;
    $sumImporte[3]=0;
  foreach ($array as $row)
  {  $nombre='FACTURA';
    $i=0;
    if($row->posteriorapago==2)
      {
        switch ($row->sucursal) {
          case 'MERIDA':$i=1;$nombre='CCMERIDA'; break;
          case 'NORTE':$i=2;$nombre='CCNORTE';break;
          default:$i=3;$nombre='CCCANCUN'; break;
        }
        
      }
    $class='';
      $sumImporte[$i]=(double)$sumImporte[$i]+(double)$row->totalfactura;
    $cadena=$row->fecha_factura;
    if($cadena==''){$cadena=$row->fecha_captura;}
    $mes = substr("$cadena", 5, 2);
    $ano = substr("$cadena", 0, 4);
    $acumuladoMes=array();
    if(!is_null($row->idPersonaDepartamento))
     {
        $acumuladoMes['idAperturaContable']=$row->idAperturaContable;             
        $acumuladoMes['idPersonaDepartamento']=$row->idPersonaDepartamento;
        $acumuladoMes['mes']=$mes;
        //$acumuladoMensual=$ci->capsysdre->devolverPresupuestoAutorizado($acumuladoMes);                              
        $acumuladoMensual=$ci->contabilidadmodelo-> facturasQueAfectanPresupuesto($acumuladoMes);                              
      }                
        $montoMes['idAperturaContable']=$row->idAperturaContable;
        $montoMes['idPersonaDepartamento']=$row->idPersonaDepartamento;
        $montoMes['idMes']=$mes;        
        $montoMensual=$ci->contabilidadmodelo->devolverAperturaContableMontoMes($montoMes)[0]['montoMes'];
       if((float)$acumuladoMensual>(float)$montoMensual){$class='style="background-color:red;color:black"';}
              
        $body[$i].='<tr  '.$class.' name="'.$nombre.'">';
        $body[$i].= '<td>'.$row->id.'</td>';
        $body[$i].= '<td>'.$ci->capsysdre->NombreUsuarioEmail($row->Usuario).'</td>';
        $body[$i].= '<td>'.$row->fecha_factura.'</td> ';
        $body[$i].= '<td>'.$row->folio_factura.'</td>';
        $body[$i].= '<td>'.$row->concepto.'</td>';
        $body[$i].= '<td align="right">$'.number_format($row->totalfactura,2).'</td>';
        
        $cadena=$row->fecha_factura;
        $mes = substr("$cadena", 5, 2);
        $ano = substr("$cadena", 0, 4);
        $body[$i].= '<td>$'.number_format($acumuladoMensual,2).'</td>';
        
        $body[$i].= '<td>$'.number_format($montoMensual,2).'</td>';
        $cadena=$row->fecha_factura;

        $totalAnual['idAperturaContable']=$row->idAperturaContable;
        $totalAnual['idPersonaDepartamento']=$row->idPersonaDepartamento;
        $presupuestoAutorizadoAnual=$ci->capsysdre->devolverPresupuestoAutorizado($totalAnual);
        $body[$i].= '<td>$'.number_format($presupuestoAutorizadoAnual,2).'</td>';
                                           
        $montoAnualLimite['idAperturaContable']=$row->idAperturaContable;
        $montoAnualLimite['idPersonaDepartamento']=$row->idPersonaDepartamento;
        $presupuestoAutorizado=$ci->contabilidadmodelo->devolverAperturaContableMontoMes($montoAnualLimite)[0]['montoMes'];
        $body[$i].= '<td>$'.number_format($presupuestoAutorizado,2).'</td>';
        $body[$i].= '<td><a href="'.base_url().'presupuestos/AutorizaFactura?IDFact='.$row->id.'".?IDCL=. class="btn btn-primary btn-xs contact-item"   data-original-title><span class="glyphicon glyphicon-pencil" ></span>Autorizar</a></td>';
          $body[$i].= '<td>'.$ci->capsysdre->GetNombreProveedor($row->idProveedor).'</td>';
        $body[$i].='</tr>';
   }
      $bodyTotal='';
      $bodyTotal.='<tr class="gridCabecera"><td><button class="btn btn-warning" onclick="abrirCerrarHijo(this)" data-hijo="FACTURA">-</button></td><td colspan="11">FACTURAS</td></tr>';      
      if($body[0]==''){$bodyTotal.='<tr name="FACTURAS"><td colspan="11"><label class="label label-success">SIN FACTURAS PARA AUTORIZAR</label></td></tr>';}
      else{$bodyTotal.=$body[0];}
      $bodyTotal.='<tr name="FACTURA" class="sumTabla"><td colspan="5"><label class="label">FACTURAS TOTAL:</label></td><td align="right">$'.number_format($sumImporte[0],2).'</td><td colspan="6"></td></tr>';
      $bodyTotal.='<tr class="gridCabecera"> <td><button class="btn btn-warning" onclick="abrirCerrarHijo(this)" data-hijo="CCMERIDA">-</button></td><td colspan="11" >CAJA CHICA MERIDA</td></tr>';
      if($body[1]==''){$bodyTotal.='<tr name="CCMERIDA"><td colspan="11"><label class="label label-success">SIN FACTURAS PARA AUTORIZAR</label></td></tr>';}
      else{$bodyTotal.=$body[1];}
      $bodyTotal.='<tr name="CCMERIDA" class="sumTabla"><td colspan="5"><label class="label">CAJA CHICA MERIDA TOTAL:</label></td><td align="right">$'.number_format($sumImporte[1],2).'</td><td colspan="6"></td></tr>';
      $bodyTotal.='<tr class="gridCabecera"><td><button class="btn btn-warning" onclick="abrirCerrarHijo(this)" data-hijo="CCNORTE">-</button></td><td colspan="11" >CAJA CHICA NORTE</td></tr>';
      if($body[2]==''){$bodyTotal.='<tr name="CCNORTE"><td colspan="11"><label class="label label-success">SIN FACTURAS PARA AUTORIZAR</label></td></tr>';}
      else{$bodyTotal.=$body[2];}
      $bodyTotal.='<tr name="CCNORTE" class="sumTabla"><td colspan="5"><label class="label">CAJA CHICA NORTE TOTAL:</label></td><td align="right">$'.number_format($sumImporte[2],2).'</td><td colspan="6"></td></tr>';
      $bodyTotal.='<tr class="gridCabecera"><td><button class="btn btn-warning" onclick="abrirCerrarHijo(this)" data-hijo="CCCANCUN">-</button></td><td colspan="11" >CAJA CHICA CANCUN</td></tr>';
      if($body[3]==''){$bodyTotal.='<tr name="CCCANCUN"><td colspan="11"><label class="label label-success">SIN FACTURAS PARA AUTORIZAR</label></td></tr>';}
      else{$bodyTotal.=$body[3];}
      $bodyTotal.='<tr name="CCCANCUN" class="sumTabla"><td colspan="5"><label class="label">CAJA CHICA CANCUN TOTAL:</label>  </td><td align="right">$'.number_format($sumImporte[3],2).'</td><td colspan="6"></td></tr>';
      $sumTotal=(double)$sumImporte[0]+(double)$sumImporte[1]+(double)$sumImporte[2]+(double)$sumImporte[3];
      $bodyTotal.='<tfoot class="footTabla"><tr><td colspan="5">TOTAL:</td><td align="right">$'.$sumTotal.'</td><td colspan="6"></td></tr></tfoot>';
      return $bodyTotal;
}
?>

<style type="text/css">
  .gridCabecera{background-color: #008004c7;border: solid}
  .ocultarObjeto{display: none} 
  .sumTabla{background-color: #a59f9f}
  .footTabla{background-color: #361666;color: white}
</style>
<script type="text/javascript">
  function abrirCerrarHijo(objeto)
  {
    let row=Array.from(document.getElementsByName(objeto.dataset.hijo));
    if(objeto.innerHTML=='-')
    {
      objeto.innerHTML='+';                        
      row.forEach(r=>{r.classList.add('ocultarObjeto');r.classList.remove('verObjeto');})
    }
    else
    {
     objeto.innerHTML='-';
     row.forEach(r=>{r.classList.remove('ocultarObjeto');r.classList.add('verObjeto');})
    }
  }
</script>
