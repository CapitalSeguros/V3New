<?php
  $this->load->view('headers/header'); 
  $this->load->view('headers/menu');
?>
<div class="container">
  <div class="row">
      <div class="col-md-2 col-sm-2 col-xs-2">
        <h4 class="titulo-secciones">
            <div>
            <a href="<?php echo base_url()?>reportes/cuadroMando"><button class="btn btn-primary btn-xs"><i class="fa fa-cog"></i> Cuadro de Mando</button></a>
            </div>
        </h4>
    </div>
    <div class="col-md-2 col-sm-2 col-xs-2">
        <h4 class="titulo-secciones">
            <div>
            <a href="#" data-toggle="modal" data-target="#seleccion_mes"><button class="btn btn-primary btn-xs"><i class="fa fa-calendar"></i> Seleccione mes de Consulta</button></a>
            </div>
        </h4>
    </div>
</div>


<div id="panel">
    <?php $this->load->view('reportes/detalle_reporte_renovaciones_resumen')?>
</div>

<div id="seleccion_mes" class="modal" role="dialog">
  <div class="modal-dialog" style="width: 100%;font-size: 12px;">
  <!-- Modal content-->
    <div class="modal-content" style="width: 60%;">
      <div class="modal-header">
        <h5 class="modal-title" style="color: #fff;"><i class="fa fa-edit"></i>&nbsp;Seleccione el mes de consulta</h5>
      </div>
      <div class="modal-body" style="width: 100%;">
        <div class="well">
            <select name="mes" id="mes" class="form-control" onchange="getAllCobranzaXfechas(this)">
                <option></option>
                <option value="01"><?php echo "ENERO"." ".date('Y')?></option>
                <option value="02"><?php echo "FEBRERO"." ".date('Y')?></option>
                <option value="03"><?php echo "MARZO"." ".date('Y')?></option>
                <option value="04"><?php echo "ABRIL"." ".date('Y')?></option>
                <option value="05"><?php echo "MAYO"." ".date('Y')?></option>
                <option value="06"><?php echo "JUNIO"." ".date('Y')?></option>
                <option value="07"><?php echo "JULIO"." ".date('Y')?></option>
                <option value="08"><?php echo "AGOSTO"." ".date('Y')?></option>
                <option value="09"><?php echo "SEPTIEMBRE"." ".date('Y')?></option>
                <option value="10"><?php echo "OCTUBRE"." ".date('Y')?></option>
                <option value="11"><?php echo "NOVIEMBRE"." ".date('Y')?></option>
                <option value="12"><?php echo "DICIEMBRE"." ".date('Y')?></option>
            </select>
        </div>
      </div>
       <div class="modal-footer">
            <button type="button" class="btn btn-warning btn-md" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
       </div>
    </div>
  </div>
</div>

<script type="text/javascript">

const totalVerdesPendientes=document.getElementById('totalVerdesPendientes').value;
 document.getElementById('totalVerdesSemaforo').innerHTML=totalVerdesPendientes;

 const totalAmarillosPendientes=document.getElementById('totalAmarillosPendientes').value;
 document.getElementById('totalAmarillosSemaforo').innerHTML=totalAmarillosPendientes;

 const totalRojosPendientes=document.getElementById('totalRojosPendientes').value;
 document.getElementById('totalRojosSemaforo').innerHTML=totalRojosPendientes;

 function actualizarSemaforo(){
    const totalVerdesPendientes=document.getElementById('totalVerdesPendientes').value;
     document.getElementById('totalVerdesSemaforo').innerHTML=totalVerdesPendientes;

     const totalAmarillosPendientes=document.getElementById('totalAmarillosPendientes').value;
     document.getElementById('totalAmarillosSemaforo').innerHTML=totalAmarillosPendientes;

     const totalRojosPendientes=document.getElementById('totalRojosPendientes').value;
     document.getElementById('totalRojosSemaforo').innerHTML=totalRojosPendientes;
 }

function guardar_renovacion_justificacion(){
    var justificacion=document.getElementById('justificacion').value;
    document.location.href='<?php echo base_url()?>reportes/guardar_renovacion_justificacion?justificacion='+justificacion;
}

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



function getAllCobranzaXfechas(mes){
    var mes=mes.value;
    document.getElementById('loader').style.display="block";
    divResultado = document.getElementById('panel'); 
    ajax=objetoAjax();   
    var URL="<?php echo base_url()?>reportes/renovaciones_fechas_pendiente?mes="+mes;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
           divResultado.innerHTML = ajax.responseText
           actualizarSemaforo();
           document.getElementById('loader').style.display="none";
        }
    }
    ajax.send(null) 
}

</script>






        










          


