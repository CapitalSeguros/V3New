<?php
$this->load->view('headers/header');
$this->load->view('headers/menu');

$user=$this->tank_auth->get_usermail();
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
  <style type="text/css">
 .divContTabla{height: 400px; width: 100%;overflow: scroll;}

  </style>
<? $totalResultados = count($ListaProspectosAgentes);?>



<section class="container-fluid divContenedor" style="margin-top: 3%;">
  <div class="divContenido">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <h3 class="titulo-secciones">Prospeccion de Agentes</h3>
      <hr class="title-hr">
    </div>
<div  class="col-md-12 d-flex flex-row-reverse container">
 
        <button id="btn_masive" class="btn btn-primary" onclick="activar_masivo()"><i class="fa fa-upload"></i>&nbsp;Importación Masiva de Agentes</button>&nbsp;&nbsp;
        <button id="btn_add" class="btn btn-primary" onclick="activar_agente()"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Agregar Nuevo Agente</button>&nbsp;&nbsp;
         <button id="btn_back" class="btn btn-primary" style="display: none;" onclick="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Regresar</button>

          </div>
          
        </div>

</section>
        <br>
    <div id="info_agentes" class="panel panel-default container">
      <div class="panel-body">
<table class="table table-responsive" id='tableAgentesInfo' >
                    <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Fecha Creacion</th>
                <th scope="col">Via</th>
                <th scope="col">ApellidoP</th>                        
                <th scope="col">ApellidoM</th>                     
                <th scope="col">Nombre</th>
                <th scope="col">Telefono</th>  
                <th scope="col">Correo</th>  
                <th scope="col">Comentarios</th>
                <th scope="col">Status</th>
                <th scope="col">Comentarios status</th>  
                <th scope="col">Acciones</th> 
              </tr>
                    </thead>
                    <tbody>   
              <?
              $flag=0;
                if($ListaProspectosAgentes != FALSE){$cont=0;
                  foreach ($ListaProspectosAgentes as $row){
              //if que corrobore el usuario y solo permita ver completo al de marketing
              //validar si el usuario es de marketing, de ser así continuar y dejar que realice la impresion total de no ser así validar si el usuario asignado es el usuario que esta ingreando e imprimir
                    if($user=="MARKETING@AGENTECAPITAL.COM"){
                      $flag=1;
                      $nocontac="";
                      $contac="";
                      $cita="";
                      $proces="";
                      $reclu="";
                      $desc="";
                      switch ($row->status) {
                        case 'NO CONTACTADO':
                          $nocontac="selected";
                          break;
                        case 'CONTACTADO':
                          $contac="selected";
                          break;
                        case 'PROGRAMADO PARA CITA':
                          $cita="selected";
                          break;
                        case 'EN PROCESO':
                          $proces="selected";
                          break;
                        case 'RECLUTADO':
                          $reclu="selected";
                          break;
                        case 'DESCARTADO':
                          $desc="selected";
                          break;
                      }
                      ?>
              <tr>
                <td><?=$row->id?></td> 
                <td><?php if($row->fecha!=null){echo(date("Y/m/d", strtotime($row->fecha)));} ?></td>
                <td><?=$row->medio?></td>
                
                <td><?=$row->apellido_paterno?></td>
                <td><?=$row->apellido_materno?></td>
                <td><?=$row->prospecto?></td>
                <td><?=$row->numero_telefono?></td>
                <td><?=$row->correo?></td>
                <td><?=$row->comentarios?></td>
                <td><select  style="width:120px" class="form-control input-sm statusAgent" name="statusClient"data-agent="<?=$row->id?>" onchange="statusAgent(this)">
                  <option value="NO CONTACTADO" <?=$nocontac?>>SIN EXITO DE CONTACTO</option>
                  <option value="CONTACTADO" <?=$contac?>>CONTACTADO</option>
                  <option value="PROGRAMADO PARA CITA" <?$cita?>>PROGRAMADO PARA CITA</option>
                  <option value="EN PROCESO" <?=$proces?>>EN PROCESO DE RECLUTA</option>
                  <option value="RECLUTADO" <?=$reclu?>>RECLUTADO</option>
                  <option value="DESCARTADO" <?=$desc?>>DESCARTADO</option></select>
                <div class="column-flex-center-center" id="loadingStatus<?=$row->id?>" style="padding: 8px 0px;"></div></td>
                <td><?=$row->comentarioStatus?></td>
                <td><div class="row"><button onclick="eliminarProspecto('<?=$row->id?>')" class="btn btn-danger" style="color: #ffffff;"><i class="fa fa-trash"></i></button></div></td>
                </tr>
                      <?
                    }else{
                      if($user==$row->asignado){
                        $flag=1;
                      ?>
                                    <tr>
                <td><?=$row->id?></td> 
                <td><?php if($row->fecha!=null){echo(date("Y/m/d", strtotime($row->fecha)));} ?></td>
                <td><?=$row->medio?></td>
                
                <td><?=$row->apellido_paterno?></td>
                <td><?=$row->apellido_materno?></td>
                <td><?=$row->prospecto?></td>
                <td><?=$row->numero_telefono?></td>
                <td><?=$row->correo?></td>
                <td><?=$row->comentarios?></td>
                <td>
                  <select  style="width:120px" class="form-control input-sm statusAgent" name="statusClient" data-agent="<?=$row->id?>" onchange="statusAgent(this)">
                    <option value="NO CONTACTADO" <?=$nocontac?>>SIN EXITO DE CONTACTO</option>
                    <option value="CONTACTADO" <?=$contac?>>CONTACTADO</option>
                    <option value="PROGRAMADO PARA CITA" <?$cita?>>PROGRAMADO PARA CITA</option>
                    <option value="EN PROCESO" <?=$proces?>>EN PROCESO DE RECLUTA</option>
                    <option value="RECLUTADO" <?=$reclu?>>RECLUTADO</option>
                    <option value="DESCARTADO" <?=$desc?>>DESCARTADO</option></select>
                    <div class="column-flex-center-center" id="loadingStatus<?=$row->id?>" style="padding: 8px 0px;"></div></td>
                <td><?=$row->comentarioStatus?></td>
                <td><div class="row"><button onclick="eliminarProspecto('<?=$row->id?>')" class="btn btn-danger" style="color: #ffffff;"><i class="fa fa-trash"></i></button></div></td>
                </tr>
                      <?
                      }
                    }
                  }
                }
              ?>
            </tbody>
            <?
              if($flag == 0){
            ?>
            <tfoot>
              <tr>
                <td colspan="13"><center><b>No se encontraron registros.</b></center></td>
              </tr>
            </tfoot>
            <?
              }
            ?>
          </table>

</div></div>
          <!-- Modal agendar citas-->
<div class="modal " id="calendarioCita" role="dialog" >
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Agendar Cita</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body row" style="padding: 0px 15px 0px !important">
         <form  method="post" style="padding: 5%" action="<?= base_url()?>prospectoAgente/agendarcita/">
          <input type="hidden" name="idAgent" id="idAgent">
          <div class="form-group row">
            <label for="fechaCita" class="col-sm-2 col-form-label">Fecha:</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="fechaCita" name="fechaCita">
            </div>
        </div>
        <div class="form-group row">
            <label for="selectFechaDeCC" class="col-sm-2 col-form-label">De:</label>
            <div class="col-sm-4">
              <select id="selectFechaDeCC" name="selectFechaDeCC" class="form-control"><option>9:00</option><option>9:30</option><option>10:00</option><option>10:30</option><option>11:00</option><option>11:30</option><option>12:00</option><option>12:30</option><option>13:00</option><option>13:30</option><option>14:00</option><option>14:30</option><option>15:00</option><option>15:30</option><option>16:00</option><option>16:30</option><option>17:00</option><option>17:30</option><option>18:00</option></select>
            </div>
            <label for="selectFechaACC" class="col-sm-2 col-form-label">A:</label>
            <div class="col-sm-4">
              <select id="selectFechaACC" name="selectFechaACC" class="form-control"><option>9:00</option><option>9:30</option><option>10:00</option><option>10:30</option><option>11:00</option><option>11:30</option><option>12:00</option><option>12:30</option><option>13:00</option><option>13:30</option><option>14:00</option><option>14:30</option><option>15:00</option><option>15:30</option><option>16:00</option><option>16:30</option><option>17:00</option><option>17:30</option><option>18:00</option></select>
            </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary">Agendar</button>
        </div>
      </form>
         </div>
    </div>
  </div>
</div>
<!-- Modal contacto -->
<div class="modal " id="agenteContactadoModal" role="dialog" >
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Contacto</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body row" style="padding: 0px 15px 0px !important">
         <form  method="post" style="padding: 5%" action="<?= base_url()?>prospectoAgente/agenteContactado">
          <input type="hidden" name="idAgentStatus" id="idAgentStatus">
          <input type="hidden" name="tipoContacto" id="tipoContacto">
          <div class="form-group row">
            <label for="fechaCita" class="col-sm-10 col-form-label">¿Hubo éxito de contacto?</label>
            <div class="col-sm-10">
              <select id="selectRespuesta" name="selectRespuesta" class="form-control"><option>Seleccione una respuesta</option><option>SI</option><option>NO</option></select>
            </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
         </div>
    </div>
  </div>
</div>
<!-- Div de Persona Agentes-->
<div id="div_agente" style="display: none;">
<div class="panel panel-default container"> <!--band-->
  <div class="panel-body">
  <form method="post" role="formdimension" id="formdimension_agentes" name="formdimension_agentes" action="<?= base_url()?>prospectoAgente/InsertaDimension_agente/">
    <div class="row">
      <div class="col-md-4">
        <h4>Datos personales</h4>
        <div class="form-group">
          <label class="subtitleSeg" for="nombre_agente">Nombre</label>
          <input type="text" class="form-control" id="nombre_agente" name="nombre_agente" placeholder="Nombre" required>
        </div>
        <div class="form-group">
          <label class="subtitleSeg" for="apellidop_agente">Apellido paterno</label>
          <input type="text" class="form-control" id="apellidop_agente" name="apellidop_agente" placeholder="Apellido paterno" required>
        </div>
        <div class="form-group">
          <label class="subtitleSeg" for="apellidom_agente">Apellido materno</label>
          <input type="text" class="form-control" id="apellidom_agente" name="apellidom_agente" placeholder="Apellido materno" required>
        </div>
      </div>
      <div class="col-md-4">
        <h4>Forma de contacto</h4>
        <div class="form-group">
          <label class="subtitleSeg" for="email_agente">Correo</label>
          <input type="email" class="form-control" id="email_agente" name="email_agente" placeholder="Email xx@yy.com" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
        </div>
        <div class="form-group">
          <label class="subtitleSeg" for="celular_agente">Teléfono celular</label>
          <input type="tel" class="form-control" id="celular_agente" name="celular_agente" placeholder="10 Digitos" maxlength="10" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
        </div>
        <div class="form-group">
          <label class="subtitleSeg" for="telefono-casa-agente">Teléfono casa</label>
          <input type="tel" class="form-control" id="telefono-casa-agente" name="telefono-casa-agente" placeholder="Teléfono fijo">
        </div>
      </div>
      <div class="col-md-4">
        <h4>Ubicación</h4>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="calle">Calle</label>
              <input type="text" class="form-control" id="calle" name="calle" placeholder="calle">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="cruzamiento">Cruzamiento</label>
              <input type="text" class="form-control" id="cruzamiento" name="cruzamiento" placeholder="cruzamiento">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="colonia">Colonia</label>
              <input type="text" class="form-control" id="colonia" name="colonia" placeholder="colonia">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="numero_casa">Número</label>
              <input type="text" class="form-control" id="numero_casa" name="numero_casa" placeholder="No.">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="municipio">Municipio</label>
              <input type="text" class="form-control" id="municipio" name="municipio" placeholder="Municipio">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="estado">Estado</label>
              <input type="text" class="form-control" id="estado" name="estado" placeholder="Estado">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="pais">País</label>
              <input type="text" class="form-control" id="pais" name="pais" placeholder="País">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="subtitleSeg" for="postal">Código postal</label>
              <input type="text" class="form-control" id="postal" name="postal" placeholder="Código postal">
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h4>Gestión del agente en prospecto</h4>
        <div class="row">
            <div class="col-md-4">
              <label class="subtitleSeg" for="comentarios">Comentarios</label>
              <textarea class="form-control" name="comentarios" id="comentarios" cols="45" rows="3"></textarea>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="subtitleSeg" for="asignado">Asignado</label>
                <select name="asignado" id="asignado" class="form-control" style="font-size: 12px;height: 30px;">
                  <option value="">SELECCIONE</option>
                  <?= array_reduce($accountsToAssignLeads, function($acc, $curr){ 

                    $acc .= "<option value='".$curr."'>".$curr."</option>"; 
                    return $acc;
                    }, "");?>
                  <!--<option value="COORDINADOR@CAPCAPITAL.COM.MX">COORDINADOR@CAPCAPITAL.COM.MX</option>
                  <option value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX">COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX</option>
                  <option value="EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM">EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM</option>
                  <option value="AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX">AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX</option>
                  <option value="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM">COORDINADORCOMERCIAL@FIANZASCAPITAL.COM</option>-->
                </select>
              </div>
              
            </div>
            <div class="col-md-4">
              <p>Agregar en caso de no estar en la lista.</p>
              <div class="row">
                <div class="col-md-9"><input type="email" id="newAssign" class="form-control"></div>
                <div class="col-md-3"><button class="btn btn-primary btn-xs mt-2 agreeAssing">Agregar</button></div>
              </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
               <label class="subtitleSeg" for="experiencia">Experiencia</label>
               <input type="text" class="form-control" id="experiencia" name="experiencia">
            </div></div>
            <div class="col-md-4">
            <div class="form-group">
               <label class="subtitleSeg" for="cartera">Cartera</label>
               <input type="text" class="form-control" id="cartera" name="cartera">
            </div>
          </div>
          <div class="col-md-4">
          <div class="form-group">
                <label class="subtitleSeg">Persona Referida: &nbsp;<input type="checkbox" class="form-check-input" name="referido" id="referidoAgente" value="1"></label>
              </div></div>
        </div>
      </div>
      <div class="col-md-12 text-center mt-6">
        <input type="submit" value="Agregar Prospecto Agentes" class="btn btn-primary"/>
      </div>
    </div>
  </form>
</div></div>
<!--<div class="panel panel-default">
  <div class="panel-body">
    <form method="post" class="form" role="formdimension" id="formdimension_agentes" name="formdimension_agentes" action="<?= base_url()?>crmproyecto/InsertaDimension_agente/">
      
      <div class="row">
        <div class="col-sm-6 col-md-6">
              <label class="subtitleSeg" for="nombre">Nombre:</label>
              <input type="text"  name="nombre_agente" id="nombre_agente" class="form-control" placeholder="Nombre">
          </div>
          <div class="col-sm-6 col-md-6">
              <label class="subtitleSeg" for="apellido">Apellido:</label>
              <input type="text"  name="apellido_agente" id="apellido_agente" class="form-control" placeholder="Apellido">
          </div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-md-6">
          <label class="subtitleSeg" for="ubicacion">Ubicacion:</label>
                  <input type="text"  name="ubicacion_agente" id="ubicacion_agente" class="form-control" placeholder="Ubicación">
          </div>
          <div class="col-sm-6 col-md-6">
                  <label class="subtitleSeg" for="cedula">Tiene Cedula:</label>
                  <select id="cedula" name="cedula_agente" class="form-control">
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    <option value="N/E">N/E</option>
                  </select>
          </div>
      </div>
          
      <div class="row">
            <div class="col-sm-6 col-md-6">
            <label class="subtitleSeg" for="email">Email:</label>
            <input type="email" name="email_agente" id="email_agente" placeholder="Email xx@yy.com" class="form-control" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"/>
            </div>
            <div class="col-sm-6 col-md-6">
              <label class="subtitleSeg" for="celular">Tel Cel:</label>
            <input type="text"  name="celular_agente" id="celular_agente" placeholder="10 Digitos" maxlength="10" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
            >
            </div>
      </div>

      <div class="row">
                <div class="col-sm-6 col-md-6">
                  <label class="subtitleSeg" for="email">Status:</label>
                  <select id="status" name="status"  class="form-control">
                    <option value="NO CONTACTADO">NO CONTACTADO</option>
                    <option value="EN PROCESO">EN PROCESO</option>
                    <option value="CONTACTADO">CONTACTADO</option>
                    <option value="RECLUTADO">RECLUTADO</option>
                    <option value="DESCARTADO">DESCARTADO</option>
                  </select>
                </div>
                
                <div class="col-sm-6 col-md-6">
                <label class="subtitleSeg" for="celular">Asignar a:</label>
                <select name="asignado" id="asignado" class="form-control" style="width: 150px;">
                <option value="NINGUNO">NINGUNO</option>
                <option value="COORDINADOR@CAPCAPITAL.COM.MX">COORDINADOR@CAPCAPITAL.COM.MX</option>
                <option value="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX">COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX</option>
                <option value="EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM">EJECUTIVOCOMERCIAL@ASESORESCAPITAL.COM</option>
                <option value="AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX">AUXILIARCOMERCIAL@CAPCAPITAL.COM.MX</option>
                </select>
      </div>

      </div>

      <div class="row">
            <div class="col-sm-12 col-md-12">
                <label class="subtitleSeg" for="detalles">Observación:</label>
                <input type="text" name="observacion_agente" id="observacion_agente" class="form-control" placeholder="Escriba algúna observacion ó comentario">
            </div>

            
            <div class="col-sm-2 col-md-2" align="right">
        
                  <br />
                      <input
                        type="submit"
                          value="Agregar Prospecto Agentes" class="btn btn-primary"
                      />
                
              </div>
      </div>

    </form>
  </div>
</div>-->
</div>
<div id="importacionMasiva" class="panel panel-default container" style="display: none;"><section class="container-fluid breadcrumb-formularios">
  <br>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-info">
        <i class="fa fa-upload"></i>
        <b style="font-size: 14px;">Seleccione Documento Excel (.xls ó .xlsx)</b>
        para realizar importación masiva de los prospectos
      </div>
    </div>  
  </div>
</section>
<div class="col-md-12">
  <div class="message"></div>
  <form method="post" enctype="multipart/form-data" id="upload-prospective-list">
    <div class="mb-4"><input type="file" id="lista" name="lista"></div>
    <div><input type="submit" name="boton" value="Guardar" class="btn btn-primary btn-md"></div>
  </form>
</div>
<!--<form method="post" enctype="multipart/form-data" action="http://localhost/Capsys/www/V3/crmproyecto/guardar_prospectos">
<div class="row">
  <div class="col-md-6">
    <input type="file" id="lista" name="lista">
  </div>
</div>
<br><br>
<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-2" style="text-align: left;">
  <input type="submit" name="boton" value="Guardar" class="btn btn-primary btn-md">
</div>
</div>
</form>-->
<br><br><br>
<div class="row">
  <div class="col-md-6"></div>
  <div class="col-md-6" style="text-align: left;">
<a href="../assets/documentos/layouts_prospectos/prospectoAgente.xlsx"><i class="fa fa-download"></i>&nbsp;Click para descargar plantilla modelo de Importacion Masiva de prospectos (Personas)</a>
  </div>
</div>

</div>


<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script type="text/javascript">

/* Ajax*/

  $(document).ready( function () { 
$('#tableAgentesInfo').DataTable({
      ordering: false,
      language: {
          url: `<?=base_url()?>assets/js/espanol.json`
      },
});
});

  function activar_agente(){
   document.getElementById('div_agente').style.display='block';
   document.getElementById('importacionMasiva').style.display='none';
   document.getElementById('info_agentes').style.display='none';
   document.getElementById('btn_add').style.display='none';  
   document.getElementById('btn_back').style.display='block';   
}
function activar_masivo(){
  document.getElementById('importacionMasiva').style.display='block';
  document.getElementById('div_agente').style.display='none';
   document.getElementById('info_agentes').style.display='none';
   document.getElementById('btn_masive').style.display='none';  
   document.getElementById('btn_back').style.display='block';
} 
function back(){
   document.getElementById('div_agente').style.display='none';
   document.getElementById('importacionMasiva').style.display='none';
   document.getElementById('info_agentes').style.display='block';
   document.getElementById('btn_add').style.display='block';
   document.getElementById('btn_masive').style.display='block';
   document.getElementById('btn_back').style.display='none'; 
} 
function agregarId(id){
 document.getElementById('idAgent').value=id;
}

function agregarIdContacto(id, tipo){
 document.getElementById('idAgentStatus').value=id;
  document.getElementById('tipoContacto').value=tipo;
}

function eliminarProspecto(id){
        console.log(id);
        var direccion=<?php echo('"'.base_url().'prospectoAgente/eliminarLead"'); ?>;
        var parametros = {
                "idAgent" : id,
        };
swal({
        title: "¿Desea eliminar el prospecto?",
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
    }).then((value) => {
                if (value) {
                      $.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   direccion, //archivo que recibe la peticion
                type:  'post', //método de envio
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                     location.reload();
                }

        })
                  }
            });         



    }
function statusAgent(obj) {
    const agent = $(obj).data('agent');
    const val = obj.value;
    var direccion=<?php echo('"'.base_url().'prospectoAgente/asignaStatus"'); ?>;
    $.ajax({
      type: "POST",
            url: direccion,
            data: {
              id: agent,
              status: val
            },
            beforeSend: (load) => {
                $('#loadingStatus'+agent).html(`
                  <div class="container-spinner-content-loading">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
                `);
            },
            success: (data) => {
                $('#loadingStatus'+agent).html(`<i class="fas fa-check-circle icon-circle-check"></i><label class="textCheck">Listo</label>`);
            },
            error: (error) => {
            $('#loadingStatus'+agent).html(`<i class="fas fa-times-circle icon-circle-close"></i><label class="textError">Error</label>`);
          }
        })
  }
//------
 $(document).on("submit", "#upload-prospective-list", function(e){
    e.preventDefault();
    const file = $("#lista").val();
    const arrayFile = file.split(".");
    const formdata = new FormData(this);

    if(file.length == 0){
      $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Favor de seleccionar un archivo</div>`);
      return false;
    }

    if(!["xlsx", "xls"].includes(arrayFile.pop())){
      $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>El formato no es el adecuado para la importación de registros.</div>`);
      return false;
    }

    $.ajax({ 
      type: "POST",
      url: `<?=base_url()?>prospectoAgente/importProspectivesList`,
      data:  formdata,
      contentType: false,
      processData: false,
      beforeSend: (data) => {
        $(".message").html(`<div class="alert alert-warning" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Subiendo registros...</div>`);
      },
      success: (data) => {
        const response = JSON.parse(data);
        console.log(response);
        $(".message").html(`<div class="alert alert-${response.status == "failed" ? "danger" : "success"}" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>${response.message} (registros importados: ${response.data.count}).</div>`);
      },
      error: (error) => {
        $(".message").html(`<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ocurrió un error al importar los datos. Favor de contactar al depto de sistemas.</div>`);
        console.log(error);
      }
    });

  });
</script>




