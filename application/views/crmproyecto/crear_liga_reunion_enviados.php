<?php  
  	$this->load->view('capacita/menu_capacita'); 
    $this->load->model('crmproyecto_model');
    
    $accounts = array_map(function($arr){ return $arr->correo; }, $organizers);
    //var_dump($accounts);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">

<!--<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>-->
<style type="text/css">
.principal{
    float: left;
    width: 100%;
    margin-top: 2%;
  }
  #table_id{
    font-size: 12px;
  }
#generar{
   background-color: rgba(0, 0, 0, 0.7);
   position: fixed;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 1050;
}
  #nav-cap.nav-tabs {
      font-size: 13px;
  }
  #nav-cap.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
      cursor: default;
      background-color: #fff;
      border: 1px solid #ddd;
      border-bottom-color: transparent;
  }
  #tab-cap.tab-content {
      font-size: 12px;
      border: 1px solid #ddd;
      border-top: none;
  }
</style>
<input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
<div style="overflow: scroll-y;">
  <div class="new-lateral-menu hidden" style="width: 120px; vertical-align: top; display: inline-block; padding: 10px 5px 10px 5px"></div>
  <div style="width: 90%; vertical-align: top; display: inline-block">
    <h2 class="mt-4 title-capacita">
        Convocatoria Reunion ó Capacitación (Enviados)
    </h2>
    <hr/>

    <div class="tabpanel">
      <ul class="nav nav-tabs" id="nav-cap" role="tablist">
        <!--<li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">Todas las reuniones</a></li>-->
        <?php /*if(in_array($this->tank_auth->get_usermail(), $accounts)){?>
          <li role="presentation" <?= in_array($this->tank_auth->get_usermail(), $accounts) ? 'class="active"' : ""; ?>><a href="#capacitacion" aria-controls="capacitacion" role="tab" data-toggle="tab">Capacitación</a></li>
        <?php }*/?>
        <li role="presentation" <?= in_array($this->tank_auth->get_usermail(), $accounts) ? 'class="active"' : ""; ?>><a href="#capacitacion" aria-controls="capacitacion" role="tab" data-toggle="tab">Capacitación</a></li>
        <li role="presentation" <?= !in_array($this->tank_auth->get_usermail(), $accounts) ? 'class="active"' : ""; ?>><a href="#estandar" aria-controls="estandar" role="tab" data-toggle="tab">Eventos estándar</a></li>
      </ul>
    </div>

    <div class="tab-content" id="tab-cap">
      <!--<div role="tabpanel" class="tab-pane active" id="general">
        <table  id="table_id" class="display" width="100%" style="font-size: 11px;">
          <thead>
              <tr style="background-color: #361666;color: #fff;">
              <th>Titulo</th>
              <th>Fecha</th>
              <th>Hora</th>
              <th>Usuario Responsable</th>
              <th>Clasificacion</th>
              <th>Liga Video Conferencia</th>
              <th>Codigo Acceso</th>
              <th colspan="2" style="text-align: center"><i class="fa fa-cogs"></i></th>
              </tr>
          </thead>
          <tbody>
            <?php 
            $i=0;
            foreach ($eventos as $evento){
              $fechaHora=explode("T", $evento->created_on);
              $fecha=date("d-m-Y", strtotime($fechaHora[0]));
              $hora=$fechaHora[1];
              ?>
              <tr>
                <td><?php echo $evento->title;?></td>
                <td><?php echo $fecha;?></td>
                <td><?php echo $hora;?></td>
                <td><?php echo $evento->created_by;?></td>
                <td><?php echo strtoupper($evento->clasificacion);?></td>
                <td><?php echo $evento->liga;?></td>
                <td><?php echo $evento->password;?></td>
                <td>
                  <?php echo "ENVIADO";?>
                </td>
              <?php
                $rs=$this->crmproyecto_model->getAllEmailConvocatoriaInternos($evento->cal_id);
                $correoInternos="";
                foreach ($rs as $row) {
                  $correoInternos.=$row->correo_lectronico.'<br>';
                }

                $rs=$this->crmproyecto_model->getAllEmailConvocatoriaExternos($evento->cal_id);
                $correoExternos="";
                foreach ($rs as $row) {
                  $correoExternos.=$row->correo_externo.'<br>';
                }
              ?>
              <td>
                <a href="#" data-toggle="modal" data-target="#generar" data-backdrop="" onclick="setDatos('<?php echo $evento->cal_id?>','<?php echo strtoupper($evento->title);?>','<?php echo $fecha;?>','<?php echo $hora;?>','<?php echo $evento->clasificacion;?>','<?php echo  $evento->liga;?>','<?php echo $evento->password;?>','<?php echo $correoInternos;?>','<?php echo $correoExternos;?>')">
                  <i class="fa fa-list fa-2x"></i>
                </a>
              </td>
              </tr>
            <?php }?>
          </tbody>
        </table>

      </div>-->
      <div role="tabpanel" class="tab-pane <?= in_array($this->tank_auth->get_usermail(), $accounts) ? "active" : ""; ?>" id="capacitacion">
        <h4>Mis capacitaciones</h4>
        <div class="table-responsive">
            <table class="table" id="training-event-table">
              <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Fecha inicio/Hora</th>
                  <th>Fecha final/Hora</th>
                  <th>Clasificación</th>
                  <th>Organizador</th>
                  <th>Sub-categoría</th>
                  <th>Ramo</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($capacitaciones)){
                  foreach($capacitaciones as $d_c){?>

                  <tr>
                    <td><?=$d_c->titulo?></td>
                    <td><?=$d_c->fecha_inicio." - ".$d_c->hora_inicio." hrs"?></td>
                    <td><?=$d_c->fecha_final." - ".$d_c->hora_final." hrs"?></td>
                    <td><?=$d_c->clasificacion?></td>
                    <td><?=$d_c->correo?></td>
                    <td><?=$d_c->sub_categoria_capacitacion?></td>
                    <td><?=$d_c->ramo_capacitacion?></td>
                    <td><button class="btn btn-link btn-sm infoCapa" data-toggle="modal" data-target="#generar" data-backdrop="" data-event="<?=$d_c->id_cal?>" onclick="consultaCapacitacion(this)">Ver detalle</button></td>
                  </tr>

                <?php }
                } else{?>
                  <h4>Sin registros de capacitaciones creadas</h4>  
                <?php }?>
              </tbody>
            </table>
        </div>
      </div>
      <div role="tabpanel" class="tab-pane <?= !in_array($this->tank_auth->get_usermail(), $accounts) ? "active" : ""; ?>" id="estandar">
        <h4>Mis eventos</h4>
        <div class="table-responsive">
            <table class="table" id="default-event-table">
              <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Fecha inicio/Hora</th>
                  <th>Fecha final/Hora</th>
                  <th>Clasificación</th>
                  <th>Sub-categoría</th>
                  <th>Ramo</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($estandar)){
                  foreach($estandar as $d_c){?>

                  <tr>
                    <td><?=$d_c->titulo?></td>
                    <td><?=$d_c->fecha_inicio." - ".$d_c->hora_inicio." hrs"?></td>
                    <td><?=$d_c->fecha_final." - ".$d_c->hora_final." hrs"?></td>
                    <td><?=$d_c->clasificacion?></td>
                    <td><?=$d_c->sub_categoria_capacitacion?></td>
                    <td><?=$d_c->ramo_capacitacion?></td>
                    <td><button class="btn btn-link btn-sm infoCapa" data-toggle="modal" data-target="#generar" data-backdrop="" data-event="<?=$d_c->id_cal?>" onclick="consultaCapacitacion(this)">Ver detalle</button></td>
                  </tr>

                <?php }
                } else{?>
                  <h4 style="font-size: 13px;">Sin registros de capacitaciones creadas</h4>  
                <?php }?>
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container">

</div>
<hr>

<div id="generar" class="modal" role="dialog" tabindex="-1">
<div class="modal-dialog">
 <!-- Modal content-->
<div class="modal-content"  style="margin-left:-20%;height: auto;width: 150%;margin-top:-10px;">
      <div class="modal-header">
        <h3 class="modal-title" style="color: #fff;"><i class="fa fa-list"></i>&nbsp;Detalle de la convocatoria de reunión</h3>
      </div>
      <div class="modal-body">
        <br>
        <div class="well" style="margin-top: -10px;">
        <table class="table table-bordered">
          <input type="hidden" name="id" id="id">
          <tr>
            <td style="width: 25%;"><span style="font-weight: bold;font-size: 12px;">Título del Evento</span></td>
            <td><span><div id="titulo"></div></span></td>
          </tr>
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Casificación:</span></td>
            <td><span><div id="clasificacion"></div></span></td>
          </tr>
          <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Fecha y Hora:</span></td>
            <td><span><div id="fechaHora"></div></span></td>
          </tr>
           <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Liga de Zoom:</span></td>
            <td><span><div id="liga"></div></span></td>
          </tr>
           <tr>
            <td><span style="font-weight: bold;font-size: 12px;">Código Acceso:</span></td>
            <td><span><div id="codigo"></div></span></td>
          </tr>
        </table>
        </div>
        <div class="col-md-12">
          <h4><i class="fa fa-list"></i>&nbsp;Listado de Correos Enviados</h4>
        </div>
      <table style="width: 100%">
        <tr>
          <td style="background-color: #E6E6E6"><b style="font-size: 12px;"><i class="fa fa-envelope"></i> CORREOS INTERNOS</b></td>
        </tr>
        <tr>
          <td style="padding-left: 5%;font-size: 12px;"><div id="correoInternos"></div></td>
        </tr>

        <tr><td><hr></td></tr>

        <tr>
          <td style="background-color: #E6E6E6"><b style="font-size: 12px;"><i class="fa fa-envelope"></i>  CORREOS INVITADOS</b></td>
        </tr>
        <tr>
          <td style="padding-left: 5%;font-size: 12px;"><div id="correoExternos"></div></td>
        </tr>
      </table>
      <br>
       <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Cerrar</button>
       </div>
    </div>
  </div>
</div>

</div>
<div id="base_url" data-base-url="<?=base_url()?>"></div>
 
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>-->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script type="text/javascript">
    $(document).ready( function () {
      $('#training-event-table').DataTable( {
        "bSort":true,
        "order":[],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrar Página por Página",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
                "search":"Buscar",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
      $('#default-event-table').DataTable( {
        "bSort":true,
        "order":[],
            "language": {
                "lengthMenu": "Mostrar _MENU_ Registros por Página",
                "zeroRecords": "No se encontraron registros",
                "info": "Mostrar Página por Página",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(Filtrado de _MAX_ total registros)",
                "search":"Buscar",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                }
            }
        });
    });
</script>
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

function setDatos(id,titulo,fecha,hora,clasificacion,liga,codigo,correoInternos,correoExternos){
  document.getElementById('id').value=id;
  document.getElementById('titulo').innerHTML=titulo;
  document.getElementById('fechaHora').innerHTML=fecha+"&nbsp;&nbsp;&nbsp;&nbsp;"+hora;
  document.getElementById('clasificacion').innerHTML=clasificacion;
  document.getElementById('liga').innerHTML='<a href='+liga+' target="blank">'+liga+'</a>';
  document.getElementById('codigo').innerHTML=codigo;
  document.getElementById('correoInternos').innerHTML=correoInternos;
  document.getElementById('correoExternos').innerHTML=correoExternos;
}

</script>
<script>
  //Dennis [2021-08-23]
  function consultaCapacitacion(eTarget){

    var base_url = window.location.href.replace("crear_liga_reunion_enviados", "");
    var id_cal = eTarget.getAttribute("data-event");
    var modalTitle = document.getElementsByClassName("modal-title")[0];
    var modalBody = document.getElementsByClassName("modal-body")[0];

    //Peticion AJAX: GET.
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){

      if(this.readyState < 4){
        
        //modalBody.innerHTML=``;
        modalBody.innerHMTML =`
          <div class="text-center">Cargando información. Espere un momento...</div>
        `;

      }

      if(this.readyState == 4 && this.status == 200){

        var res = JSON.parse(this.responseText);
        console.log(res);
        //modalBody.innerHTML=``;
        //alert(res.mensaje);
        var info = res.datos;

        document.getElementById('titulo').innerHTML=info.titulo;
        document.getElementById('fechaHora').innerHTML=info.hFInicio;
        document.getElementById('clasificacion').innerHTML=info.clasificacion;
        document.getElementById('liga').innerHTML='<a href='+info.liga+' target="blank">'+info.liga+'</a>';
        document.getElementById('codigo').innerHTML=info.contrasena;
        document.getElementById('correoInternos').innerHTML=``;
        document.getElementById('correoExternos').innerHTML=``;

        var invitados_ = res.datos.IGuest;
        for(var a in invitados_.interno){
          document.getElementById('correoInternos').innerHTML+=`
            <div class="row">
              <div class="col-md-5"><p>${invitados_.interno[a].correo}</p></div>
              <div class="col-md-4"><p>${invitados_.interno[a].nombre.toUpperCase()}</p></div>
              ${info.permission ? `<div class="col-md-3"><p>${invitados_.interno[a].estado.toUpperCase()} &nbsp&nbsp&nbsp<span onclick="changeStatus('pendiente', ${invitados_.interno[a].id_invitado})"><i class="fa fa-refresh" aria-hidden="true"></i></span> </p></div>` : ``}
              
            </div>
          `;
        }

        for(var a in invitados_.externo){
          document.getElementById('correoExternos').innerHTML+=`
            <div class="row">
              <div class="col-md-5"><p>${invitados_.externo[a].correo}</p></div>
              <div class="col-md-4"><p>${invitados_.externo[a].nombre.toUpperCase()}</p></div>
              <div class="col-md-3 text-center">${invitados_.externo[a].estado == `tentativo` ? `
                <div class="row m-auto">
                ${info.permission ? `<div class=""><button class="btn btn-link btn-sm text-success" onclick="changeStatus('aceptado',${invitados_.externo[a].id_invitado})">Aceptar</button></div><div class=""><button class="btn btn-link btn-sm text-danger" onclick="changeStatus('rechazado', ${invitados_.externo[a].id_invitado})">Rechazar</button></div>` : `` }
                </div>
              ` : invitados_.externo[a].estado.toUpperCase()}</div>
            </div>
          `;
        }

        //document.getElementById('correoInternos').innerHTML=correoInternos;
        //document.getElementById('correoExternos').innerHTML=correoExternos;
      }
    }
    xmlhttp.open("GET", base_url+"consultaDatosEvento?q="+id_cal, true);
    xmlhttp.send();
  }
  
  function changeStatus(estado, invitado){
    //generar
    var base_url = window.location.href.replace("crear_liga_reunion_enviados", "");
    var dataSend = {
      invitado_: invitado,
      estado_: estado
    }
    //Peticion AJAX: POST.
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){

          var res = JSON.parse(this.responseText);
          //console.log(res);

          alert(res.mensaje);
          if(res.bool){
            //document.getElementById("generar").classList.remove("show");
            //$("#generar").modal("hide");
            window.location.reload();
          }
      }
    }

    //xmlhttp.open("POST", base_url+"actualizaEstado", true);
    //xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded/");
    //xmlhttp.send("send="+JSON.stringify(dataSend));
    xmlhttp.open("GET", base_url+`actualizaEstado?q=${invitado}&r=${estado.replace("aceptado", "pendiente")}&p=1`,true);
    xmlhttp.send()

  }
</script>

 

