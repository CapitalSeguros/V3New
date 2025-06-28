
<?php

  function mesLetra($mes){
    switch ($mes) {
        case 1:return 'ENERO';break;
        case 2:return 'FEBRERO';break;
        case 3:return 'MARZO';break;
        case 4:return 'ABRIL';break;
        case 5:return 'MAYO';break;
        case 6:return 'JUNIO';break;
        case 7:return 'JULIO';break;
        case 8:return 'AGOSTO';break;
        case 9:return 'SEPTIEMBRE';break;
        case 10:return 'OCTUBRE';break;
        case 11:return 'NOVIEMBRE';break;
        case 12:return 'DICIEMBRE';break;
    }
}
?>

    <section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><h3 class="titulo-secciones">
    Configuración de agenda y disponibilidad para citas</h3></div></div><hr /> 
        <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
        <input type="hidden" name="id_userInfo" id="id_userInfo" value="<?php echo $id_userInfo?>">
        <input type="hidden" name="mesActual" id="mesActual" value="<?php echo date('m')?>">
        <input type="hidden" name="yearActual"  id="yearActual" value="<?php echo date('Y')?>">
       <table width="80%" border="0" style="border-color: #E2E2E2;border-style: solid;margin-bottom: 2%;">
        <tr>
          <td><b>&nbsp;Mes Actual:</b> <?php echo mesLetra(date('m'));?></td>
          <td style="text-align: right;">Seleccione cantidad de meses de vigencia: &nbsp;</td>
          <td colspan="2">
            <input type="radio" name="cantidad_mes" id="uno" value="1" checked>&nbsp; Un mes&nbsp;
            <input type="radio" name="cantidad_mes" id="tres" value="3">&nbsp; 3 meses&nbsp;
            <input type="radio" name="cantidad_mes" id="seis" value="6">&nbsp; 6 meses&nbsp;
            <input type="radio" name="cantidad_mes" id="doce" value="12">&nbsp; 12 meses
          </td>
        </tr>
      </table>
      <table width="80%" border="0" style="border-color: #E2E2E2;border-style: solid;">
         <tr>
         <td><b>&nbsp;Rango de Atención de Lunes a Viernes:</b></td>
         <td><b><i class="fa fa-calendar"></i>&nbsp;Hora de inicio</b>
           <select name="hinicio" id="hinicio" class="form-control">
             <option value="7">07:00</option>
             <option value="8">08:00</option>
             <option value="9">09:00</option>
             <option value="10">10:00</option>
             <option value="11">11:00</option>
             <option value="12">12:00</option>
             <option value="13">13:00</option>
             <option value="14">14:00</option>
             <option value="15">15:00</option>
             <option value="16">16:00</option>
             <option value="17">17:00</option>
             <option value="18">18:00</option>
           </select>
          </td>
        <td>&nbsp;</td>
        <td><b><i class="fa fa-calendar"></i>&nbsp;Hora final</b>
           <select name="hfinal" id="hfinal" class="form-control"∫>
             <!-- <option value="7">07:30</option>
             <option value="8">08:30</option>
             <option value="9">09:30</option>
             <option value="10">10:30</option>
             <option value="11">11:30</option>
             <option value="12">12:30</option>
             <option value="13">13:30</option>
             <option value="14">14:30</option>
             <option value="15">15:30</option>
             <option value="16">16:30</option>
             <option value="17">17:30</option>
             <option value="18">18:30</option>
             <option value="19">19:30</option> -->
           </select>
          </td>
          <td style="text-align: center;"><button type="button" class="btn btn-default" onclick="agregarAgenda()" style="background-color: #E2E2E2;"><i class="fa fa-calendar"></i>&nbsp;Agregar Agenda</button></td>
        </tr>
      </table>
  </section>
<section style="margin-left: 2%;margin-top: 2%;">
  <table style="width: 50%" id="time-content">
    <tr>
      <td colspan="3"><h4>Configuración actual mes: <?php echo mesLetra(date('m'))?> del <?php echo date('Y')?></h4></td>
    </tr>
    <tr style="background-color: #E6E6E6"><th><i class="fa fa-calendar"></i>&nbsp;Hora inicial de atención</th><th><i class="fa fa-calendar"></i>&nbsp;Hora final de atención</th><th><i class="fa fa-calendar"></i>&nbsp;Cantidad meses de vigencia</th><th><i class="fa fa-cogs"></i></th></tr>
    <?php foreach ($configuracion as $row) {?>
    <tr>
      <td><?php echo $row->hinicio.":00"?></td><td><?php echo $row->hfinal.":00"?></td><td style="text-align: center;"><?php echo $row->duracion?></td><td>
        <a href="#" onclick="eliminarAgenda(this, <?php echo $row->id?>)"><i class="fa fa-times-circle fa-2x"></i></a>
      </td>
    </tr>
    <?php }?>
  </table>
</section>
<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function(){

    reAdjustHours();
  });
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

  function agregarAgenda(){
        divResultado = document.getElementById('configuracion');  
        ajax=objetoAjax();   
        var url=document.getElementById('base').value;
        var id=document.getElementById('id_userInfo').value;
        var inicio=document.getElementById('hinicio').value;
        var fin=document.getElementById('hfinal').value;
        var mes=document.getElementById('mesActual').value;
        var year=document.getElementById('yearActual').value;
        
        var tres=document.getElementById('tres').checked;
        var seis=document.getElementById('seis').checked;
        var doce=document.getElementById('doce').checked;
        var duracion=1;
        if(tres){ duracion=3;}
        if(seis){ duracion=6;}
        if(doce){ duracion=12;}

        var URL=url+"crmproyecto/agregar_agenda_capital?id_userInfo="+id+"&hinicio="+inicio+"&hfinal="+fin+'&mesActual='+mes+'&yearActual='+year+"&duracion="+duracion;
        ajax.open("GET", URL);
        ajax.onreadystatechange=function() {
            if (ajax.readyState==4) {
                //divResultado.innerHTML = ajax.responseText

                var table = document.getElementById("time-content").innerHTML;
                var newRow = "";
                newRow += `<tr>
                  <td>${inicio}:00</td>
                  <td>${fin}:00</td>
                  <td style="text-align: center;">${duracion}</td>
                  <td><a href="#" onclick="eliminarAgenda(this, ${id})"><i class="fa fa-times-circle fa-2x"></i></a></td>
                </tr>`;

                document.getElementById("time-content").innerHTML = table + newRow;
            }
        }
        ajax.send(null)
  }

  function eliminarAgenda(event, id){

    var tr = event.parentNode.parentNode;
    var table = tr.parentNode;
    divResultado = document.getElementById('configuracion');  
    ajax=objetoAjax();   
    var url=document.getElementById('base').value;
    var URL=url+"crmproyecto/eliminar_configuracion_agenda_capital?id="+id;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            //divResultado.innerHTML = ajax.responseText
            table.removeChild(tr);
        }
    }
    ajax.send(null)
  }

  function reAdjustHours(){
    
    var hour = parseInt(document.getElementById("hinicio").value);
    var nhour = hour + 1;
    var fhour = !isNaN(parseInt(document.getElementById("hfinal").value)) ? parseInt(document.getElementById("hfinal").value) : nhour;
    var limit = 19;
    var option = "";

    for(init = nhour; init <= limit; init++){
      option += `<option value="${init}">${init}:00</option>`
    }
    
    document.getElementById("hfinal").innerHTML = option;
    document.getElementById("hfinal").value = hour < fhour ? fhour : nhour;
  }

  document.getElementById("hinicio").addEventListener("change", reAdjustHours);
</script>


































