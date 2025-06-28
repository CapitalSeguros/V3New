<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<style type="text/css">
  .panel{
    background-color: #fff;
    padding: 10px;
    border-radius: 8px;
    width: 93%;
    margin-top: 10px;
    float: left;
  }
  .panel_botones{
    background-color: #fff;
    width: 10%;
    border-radius: 8px;
    float: left;
    margin-left: -5%;
    padding: 10px;
    padding-top: 20px;
    margin-right: 5px;
    height:auto;
    margin-top: -20px;
  }
  .boton{
    border-style: solid;
    border-radius: 8px;
    border-width: 1px;
    margin-bottom: 10%;
    padding: 5%;
    text-align: center;
  }
  .lbboton{
    font-size: 10px;font-weight: bold;
  }
  .btn{
    border-radius: 8px;
  }
  .btn:hover{
    background-color: #DBA901;
    border-color: #DBA901;
  }
.table-cebra{
  border-top: solid 1px #CCC;
  background-color: #fff;
  position: relative!important;
  top: 5%;
  height: auto;
  font-size: 12px;
  font-family: arial;
}

.table-cebra thead tr th{
  color: #fff;
  background-color: #8370a1;
  min-width: 140px;
}

.table-cebra tr td{
  color: #000;
  border-spacing: 0;
  border-right: 1px solid #ccc;
  padding: 0.5rem;
  text-align: left;
  width: 5%;
  font-size: 11px; 
}

.table-cebra tbody{
  position:absolute;
  height:calc(120vh - 200px);
  overflow:auto;
}
.table-cebra tbody tr {
  background-color: white;
}
.table-cebra tbody tr:nth-child(2n) {
  background-color: #f2f2f2;
}
.table-cebra tbody tr:hover {
  background-color: silver;
}
</style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<label style="margin-left: 90%;font-weight: bold;font-size: 16px;font-family: arial;"><i class="fa fa-user"></i> Agentes</label>
<?php 
  //Dennis Castillo [2022-02-22]
  $showDeleteButton = isset($datosAgente) ? 1 : 0; //&& $datosAgente->IDVend == 0
  $deleteButton =  isset($deleteInProcessing) && !empty($deleteInProcessing) && $deletePermission["operation"] != "delete"
    ? '<button class="btn btn-danger text-white cancel-request" data-id="'.$deleteInProcessing->id.'">Cancelar baja</button>'
    : '<button class="btn btn-danger text-white delete-persons-exists" data-op="'.$deletePermission["operation"].'">'.$deletePermission["label"].'</button>';

  $lockContractOptions = isset($datosAgente) && $datosAgente->tipoPersona == 3 ? false : true;
?>

<div style="height: auto; width: 90%;"  class="center-block">


<div class="panel_botones">
  <table>
<!--   
    <tr>
      <td>
        <a href="#" data-toggle="modal" data-target=".capacitacion">
        <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\asignacion.png')?>" width="100%;">
          <span class="lbboton">Asignación de Capacitación</span>
        </div>
         </a>
      </td>
    </tr>
  
<tr>
      <td>
        <a href="#" onclick="window.location.href='<?=base_url('persona/agenteReporteCapacitacion')?>'">
        <div class="boton">
        <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_capacitacion.png')?>" width="100%;">
          <span class="lbboton">Reporte Capacitación</span>
        </div>
        </a>
      </td>
    </tr>
    <tr>
      <td>
        <a href="#"  onclick="window.location.href='<?=base_url('persona/resumenGeneral')?>'">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\rpt_general.png')?>" width="100%;">
          <span class="lbboton">Resumen General de Capacitación</span>
        </div>
        </a>
      </td>
    </tr>
-->
    <tr>
      <td>
        <a href="#" onclick="enviarFormGenerales(4)">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\exportar.png')?>" width="60%;">
          <span class="lbboton">Exportar Agentes</span>
        </div>
        </a>
      </td>
    </tr>

    <tr>
      <td>
        <form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
        <input type="hidden" value="1" name="quitarFiltroActivo">
        <a href="#" onclick="javascript:document.getElementById('formBuscarAgente').submit;">
          <div class="boton">
<!--Miguel 11/08/2020-->
		<button class="objetosResponsivos" style="border-style: none;background-color: #fff;"> 
		<img src="<?php echo(base_url().'assets\images\agrega_agentes\agentes.png')?>" width="90%;"></button> <span class="lbboton">Todos los Agentes</span>
<!-- ***-->	
</div>
        </a>
        </form>
      </td>
    </tr>

  
  </table>
</div>

   
<br>
<div id='divPermisoV3'>
<label class="Responsivo lbEtiqueta">El permiso de CAPSYS esta sujeto a los documentos obligatorios</label>
<form action="<?=base_url();?>persona/agente"   method="post" id="formPasaCapsys"><input type="hidden" name="idPasarAgente" id="idPasarAgente"></form>
</div>
<div>
  <select id="selectFiltroCreador" onchange="filtroCreador(document.getElementById('cbFiltroCreador'))" name="selectFiltroCreador"></select><input type="checkbox" id="cbFiltroCreador" onclick="filtroCreador(this)">
  <button onclick="mostrarTablaAgenteNuevo()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Agente Nuevo</button>
</div>

<div id="divContenedorTabla" style="overflow-x: scroll; width: 91%; margin-left: 20px;margin-right: 20px">
</div>

<br>
<div class="col-md-12">
  <div class="row">
    <div class="col-md-2 text-right mt-4">
      <button class="btn btn-primary" onclick="obtieneElementosTag(false);"><i class="fa fa-edit"></i> Modificar</button> 
    </div>
    <form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
      <div class="col-md-8">
      <input type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro" class="form-control" style="text-align: left;" placeholder="Buscador">
      
        <select class="form-control"  name="idPersonas" id="idPersonas" style="text-align: left;"><?=imprimirSelecPersonas($personas, $inDeleteProcessing);?></select>
      </div>
      <div class="col-md-2 text-left mt-4">
        <button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-8 mt-4">
  <div class="row">
    <div class="col-md-2"><div class="ResponsivoDiv" id="divNuevaPersona"></div></div>
    <div class="col-md-2"><button class="btn btn-primary sendForm" onclick="enviarForm()"><i class="fa fa-folder"></i> Guardar</button></div>
    <!--<div class="col-md-2"><?php //if(isset($btnFastFile)){echo $btnFastFile;}?></div>-->
    <div class="col-md-2"><div class="ResponsivoDiv" id="divNuevaPersonaSicas"></div></div>
    <div class="col-md-2"><?=$deletePermission["show"] == 1 && $showDeleteButton ? $deleteButton : "";?></div> <!--Dennis Castillo [2022-02-22]-->
  </div>
</div>
<!--<div class="row">
  <div class="col-md-8">
    <form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
    <input type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro" class="form-control" style="text-align: left;">
      <select class="form-control"  name="idPersonas" id="idPersonas" style="text-align: left;"><?=imprimirSelecPersonas($personas, $inDeleteProcessing);?>
      </select>&nbsp;<button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
    </form>
  </div>
</div>-->



<!--<div class="divPerson" style="direction: rtl;">
  <div class="ResponsivoDiv"><div class="ResponsivoDiv" id="divNuevaPersona"></div>
  <button class="btn btn-primary" onclick="obtieneElementosTag(false);"><i class="fa fa-edit"></i> Modificar</button> 
  <button class="btn btn-primary" onclick="enviarForm()"><i class="fa fa-folder"></i> Guardar</button>
</div>-->
</div>
<br>


<div class="divPerson">
<div class="divPersonSub ver">
  <div class="ResponsivoDiv" style="width: 30%;">
    <label class="Responsivo lbEtiqueta"></label>
    <div>
    </div>
  </div>
</div>
</div>
<!--<?php if(isset($btnFastFile)){echo $btnFastFile;}?>-->


<!-- Boton de Baja-->
<!--
<a href="#" data-per-id="<?= @$datosAgente->idPersona ?>" data-per-name="<?= (@$datosAgente->nombres . ' ' . @$datosAgente->apellidoPaterno . ' ' . @$datosAgente->apellidoMaterno) ?>" class="btn btn-sm btn-primary bn-per-baja">Baja</a>
-->
<!-- -->
   <div class="ResponsivoDiv" id=""> <form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
<input type="hidden" value="1" name="quitarFiltroActivo">
  </select>
  <!--<button class="objetosResponsivos btn-primary">Todos los Agentes</button>-->

</form> </div>
  <div class="ResponsivoDiv" id="divCrearEnSicas"></div>
  <br><br><br><br>
</div>

<div><?php if(isset($datosAgente)){ echo(bajaTotal($datosAgente,$this->tank_auth->get_usermail()));}?></div>
</div>
<div style="height: auto; width: 90%;"  class="center-block">
  <div class="divPerson">
    <div class="well" style="background-color: #FFF;border-style: solid;border-color: silver;">
      <!-- Dennis Castillo [2022-02-28] -->
      <div class="row">
        <div><i class="fa fa-user fa-2x"></i><label id="labelNombrePersona" class="labelNombrePersona"></label></div>
        <div><h4 id="labelEstadoPersona" class="labelEstadoPersona text-danger" style="font-size: 20px; margin-top: 5px; margin-left: 10px"></h4></div>
      </div>
      <!---->
    </div>
  </div>

<?php if(isset($sendWelcome) && !empty($sendWelcome) && $sendWelcome->status == "released" && $welcomePermission){?>
<div class="divPerson"><button  onclick="Verdatos(this,'PLANTILLA DE BIENVENIDA')" class="objetosResponsivos btnCab objetosResponsivoGrande "> 
  PLANTILLA DE BIENVENIDA▲</button>
    <div class="divPersonSub ver">
      <div class="row">
        <div class="col-md-4 border-right">
          <div class="mb-4">
            <div class="row">
              <div class="col-md-6">
                <label for="select-bussiness-channel">Seleccione una plantilla</label>
                <select id="select-bussiness-channel">
                  <option value="">Seleccione</option>
                  <?php
                    
                    $typePerson = $datosAgente->tipoPersona == 1;
                    foreach($catalog_canales as $dch){
                      $disabled = $dch->IdCanal == $datosAgente->id_catalog_canales ? "" : "disabled";
                  ?>
                      <option value="<?=strtolower(str_replace(" ", "", $dch->nombreTitulo))?>" <?= $typePerson ? "" : $disabled ?>><?=$dch->nombreTitulo?></option>
                  <?php }?>
                </select>
              </div>
              <div class="col-md-6">
                <button class="btn btn-primary btn-sm get-w-template mt-3" type="button" data-toggle="modal" data-target=".w-template-modal">Previsualizar</button>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-8"><h5>Estado:</h5><div class="show-welcome-template"><p>No se ha enviado mensaje de bienvenida</p></div></div>
      </div>
    </div>
</div>
<?php }?>

<div class="divPerson"><button  onclick="Verdatos(this,'DATOS PERSONALES')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS PERSONALES ▲</button>
<div class="divPersonSub ver">
<input class="formEnviar usuarioClass" type="hidden"  name="idPersona" id="idPersona">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Nombre      <div><input class="formEnviar" type="text" name="nombres" id="nombres" disabled></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Apellido Pat.<div><input class="formEnviar" type="text" name="apellidoPaterno" id="apellidoPaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Apellido Mat.<div><input class="formEnviar" type="text" name="apellidoMaterno" id="apellidoMaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">RFC          <div><input class="formEnviar" type="text" name="rfc" id="rfc"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">CURP          <div><input class="formEnviar" type="text" name="curpPersona" id="curpPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Fecha Nac.<div><input class="formEnviar" class="fecha" type="text" name="fechaNacimiento" id="fechaNacimiento" autocomplete="off"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Pais Nac.<div><input class="formEnviar" type="text" name="paisNacimiento" id="paisNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Estado Nac.<div><input class="formEnviar" type="text" name="estadoNacimiento" id="estadoNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Municipio Nac.<div><input class="formEnviar"  type="text" name="municipioNacimiento" id="municipioNacimiento"></div></label></div>

<!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Civil<div><select class="formEnviar"  name="estadoCivil" id="estadoCivil"></select></div></label></div>-->
<!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Escolaridad<div><select class="formEnviar"  name="escolaridad" id="escolaridad"></select></div></label></div>-->
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Beneficiario<div><input class="formEnviar"    type="text" name="beneficiarioPersona" id="beneficiarioPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Promotorias<div><div  style="height:80px ;width: 100%;border: solid; overflow: scroll;"  type="text" name="divCatalogoPromotorias" id="divCatalogoPromotorias"></div></div></label></div>

<!--<div class="ResponsivoDiv">
  <label class="Responsivo lbEtiqueta">Sexo
    <div><select class="formEnviar"  name="sexo" id="sexo">
    <option value="0"></option>
    <option value="Masculino">Masculino</option>
    <option value="Femenino">Femenino</option>
    </select></div>
  </label>
</div>-->

</div>
</div>

<div class="divPerson"><button  onclick="Verdatos(this,'DATOS CAPITAL HUMANO')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS 
 CAPITAL HUMANO▲</button>
  <div class="divPersonSub ver">
    <div class="row">
      <div class="col-md-4 border-right">
        <h5 class="text-center">Opciones del registro de la persona</h5>
        <div class="row">
          <div class="col-md-6"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo Persona<div  id="divTipoPersona"><select id="tipoPersona" name="tipoPersona" class="formEnviar"><?=imprimirTipoPersona($personaTipoPersonaCatalogo, isset($tipoPersona) ? $tipoPersona : 0);?></select></div></label></div></div>
          <div class="col-md-6"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Area<div id="divIdPersonaPuesto"><select class="formEnviar" name="idColaboradorArea" id="idColaboradorArea"><?=imprimeArea($personaArea,$colaboradorArea);?></select></div></label></div></div>
          <div class="col-md-6"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Sucursal<div><select  class="formEnviar" name="id_catalog_sucursales" id="id_catalog_sucursales"></select></div></label></div></div>
          <div class="col-md-6"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Car Capital<div><select class="formEnviar"  name="UsuarioCarCapital" id="UsuarioCarCapital"><option value="0">No</option><option value="1">Si</option></select></div></label></div></div>
          <div class="col-md-6"><label class="Responsivo lbEtiqueta">Aliado Car Capital<div><select class="formEnviar" name="aliadoCarCapital" id="aliadoCarCapital"><option value="0">No</option><option value="1">Si</option></select></div></label></div>
          <div class="col-md-6"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estatus<div><select class="formEnviar"  name="banned" id="banned"><option value="0">Habilitado</option><option value="1">Baneado</option></select></div></label></div></div>
        </div>
      </div>
      <div class="col-md-4 border-right">
        <h5 class="text-center">Opciones de capital humano</h5>
        <div class="row">
          	<div class="col-md-6 mb-2"><div class=""><label class="Responsivo lbEtiqueta">Fecha ingreso<div id="divIdPersonaFechaIngreso"><input type="text" class="formEnviar" id="fecAltaSistemPersona" name="fecAltaSistemPersona" placeholder="dd/mm/aaaa" required></div></label></div></div>
          	<div class="col-md-6 mb-2"><div class=""><label class="Responsivo lbEtiqueta">Sueldo mensual percibido<div id="divIdPersonaFechaIngreso"><input type="number" class="formEnviar" id="sueldoPercibido" name="sueldoPercibido" required></div></label></div></div>
          	<div class="col-md-6 mb-2"><div class="">
            <label class="Responsivo lbEtiqueta">Solicitud de fondo de ahorro<div id="divIdPersonaFechaIngreso">
              <select name="fondoAhorro" id="fondoAhorro" class="formEnviar" >
                <option value="0">Seleccione</option>
                <option value="1">Aplica</option>
                <option value="2">No aplica</option>
              </select></div>
            </label></div></div>
            <div class="col-md-6 mb-2"><div class=""><label class="Responsivo lbEtiqueta">Tipo de contrato de la persona<div id="divIdPersonaFechaIngreso">
            <select name="contrato" id="contrato" class="formEnviar">
              <option value="0">Seleccione</option>
              <option value="1">Temporal</option>
              <option value="2">Permanente</option>
            </select>
          </div></label></div></div>
          <?php if($this->tank_auth->get_usermail() == "SISTEMAS@ASESORESCAPITAL.COM" || $this->tank_auth->get_usermail()=="ASISTENTEDIRECCION@AGENTECAPITAL.COM"){?>
          <div class="col-md-12"><h5 class="text-center">Horario</h5></div>
          
         <div class="col-md-12 text-center"><button type="button" id="editarHorario" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modificacionHorarios"  data-dismiss="modal" data-backdrop="false" onclick="traerColaboradorHorario()" disabled><i class="fa fa-edit"></i> Editar horario de la persona</button></div>
        <?}?>
<?php include('horario.php'); ?>
        </div>
      </div>
      <div class="col-md-4">
        <h5 class="text-center">Opciones del usuario</h5>
        <div class="row">
          <div class="col-md-6">
            <div class="ResponsivoDiv">
              <label class="Responsivo lbEtiqueta">Tipo de usuario
                <div id="divesAgenteNuevo">
                  <select name="esAgenteNuevo" id="esAgenteNuevo" class="formEnviar">
                    <!--<option value="-1">Seleccione</option>-->
                    <option value="1">TEMPORAL</option>
                  </select>
                  <!--<input type="text" class="formEnviar" id="esAgenteNuevo" placeholder="dd/mm/aaaa" name="esAgenteNuevo">-->
                </div>
              </label>
            </div>
          </div>
          <div class="col-md-12"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Usuario<div  id="divUsuarioPersona"> </div> </label>
          <?php if($this->tank_auth->get_usermail() == "SISTEMAS@ASESORESCAPITAL.COM"){?>
            <div class="dropdown mt-2 job-accounts-1">
              <button class="btn btn-primary btn-xs" id="job-accounts" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Cuentas del puesto  <span class="badge count-accounts">0</span></a></button>
              <ul class="dropdown-menu avalibe-accounts-list" role="menu" aria-labelledby="job-accounts"></ul>
            </div>
          <?php }?>
          </div></div>
          <div class="col-md-12"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Contraseña<div id="divPasswordPersona"></div></label></div></div> 
        </div>
      </div>
    </div>
  </div>
</div>

<div class="divPerson job-person"><button  onclick="Verdatos(this,'DATOS PARA EL COLABORADOR')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Employee">
  DATOS PARA EL COLABORADOR▲</button>
  <div class="divPersonSub ocultar">
    <div class="row">
      <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Puestos<div id="divIdPersonaPuesto"><select class="formEnviar"  name="idPersonaPuesto" id="idPersonaPuesto"><?=imprimirCatalogoPuestos($personaPuestoCatalogo, $puestoColaborador);?></select></div></label></div></div>
      <!--<div class="col-md-2 mt-2"><button class="btn btn-info btn-sm text-white get-descriptive">Descargar descriptivo</button></div>-->
      <div class="col-md-3">
        <div class="ResponsivoDiv">
          <label for="" class="Responsivo lbEtiqueta">Clave Externa
            <div class="divClaveExterna">
              <input type="text" class="" name="clave_externa">
            </div>
          </label>
        </div>    
      </div>
    </div>
  </div>
</div>

<div class="divPerson agent-person"><button  onclick="Verdatos(this,'DATOS EMPRESA AGENTE')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">DATOS EMPRESA AGENTE▲</button>
  <div class="divPersonSub ocultar">
    <div class="row">
        <!--<div class="col-md-3"></div>-->
        <div class="col-md-2">
          <!--[Dennis 2020-03-27]-->
          <div class="ResponsivoDiv">
            <label class="Responsivo lbEtiqueta lbSICAS">Tipo de contrato
                <div>
                <select class="formEnviar"  name="idModalidad" id="idModalidad" onchange="segmentarTipoAgente(this.value)" required>
                  <option value="0">Seleccione</option>
                  <?php foreach($tipoModalidad as $valor){?>
                  <option value="<?=$valor->idModalidad ?>"><?=$valor->tipoModalidad?></option><?php }?>
                </select>
              </div>
            </label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="ResponsivoDiv">
            <label class="Responsivo lbEtiqueta lbSICAS">Tipo de Agente
              <div>
                <?php $option_1 = isset($datosAgente) ? array_reduce($datosAgente->arrayTypeAgent, function($acc, $curr){ $acc .= '<option value="'.$curr->idPersonaTipoAgente.'">'.$curr->personaTipoAgente.'</option>'; return $acc; }, "") : ""; ?>
                <select class="formEnviar"  name="personaTipoAgente" id="personaTipoAgente" required><option value="0">Seleccione</option><?=$option_1?></select>
              </div>
            </label>
            </div>
        </div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Honorarios<div><select class="formEnviar"  name="honorariosCVH" id="honorariosCVH"></select></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Canal<div><select class="formEnviar"  name="id_catalog_canales" id="id_catalog_canales" required></select></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Ranking(SICAS)<div><select class="formEnviar"  name="idpersonarankingagente" id="idpersonarankingagente"></select></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Id Vendedor<div id="divIdVendedor"></div></label></div></div>
        <!--<div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estatus<div><select class="formEnviar"  name="banned" id="banned"><option value="0">Habilitado</option><option value="1">Baneado</option></select></div></label></div></div>-->
        <!--<div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Car Capital<div><select class="formEnviar"  name="UsuarioCarCapital" id="UsuarioCarCapital"><option value="0">No</option><option value="1">Si</option></select></div></label></div></div>-->
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuth<div><input type="text" class="formEnviar"  name="CodeAuthPersonaSicas" id="CodeAuthPersonaSicas"></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuthUser<div><input type="text" class="formEnviar"  name="CodeAuthUserPersonaSicas" id="CodeAuthUserPersonaSicas" ></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Num. Gafete(Validador)<div><label class="Responsivo lbEtiqueta" id="IDValida" ></label></div></label></div></div>
        <div class="col-md-2"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fecha de Baneo<div><input type="text" class="formEnviar fechaPersona"  name="fecInicioBaneo" id="fecInicioBaneo" autocomplete="off" ></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Vendedor Superior<div><select class="formEnviar"  name="IDVendNS" id="IDVendNS"></select></div></label></div></div>
    </div>
   <!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Sucursal<div><select  class="formEnviar" name="id_catalog_sucursales" id="id_catalog_sucursales"></select></div></label></div>-->
   <!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Usuario<div  id="divUsuarioPersona"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Contraseña<div id="divPasswordPersona"></div></label></div>-->
  </div>
</div>

<div class="divPerson agent-person"><button  onclick="Verdatos(this,'DATOS DE CÉDULA')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">DATOS DE CÉDULA▲</button>
  <div class="divPersonSub ocultar">
    <div class="row">
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cedula<div><input class="formEnviar"  type="text" name="cedulaPersona" id="cedulaPersona"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de Cedula<div><input class="formEnviar"  type="text" name="tipoCedulaAgentePersona" id="tipoCedulaAgentePersona"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio cedula<div><input class="formEnviar fechaPersona" class="fechaPersona"   type="text" name="fecIniCedulaPersona" id="fecIniCedulaPersona" autocomplete="off"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin cedula<div><input class="formEnviar fechaPersona"    type="text" name="fecFinCedulaPersona" id="fecFinCedulaPersona" autocomplete="off"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Poliza RC<div><input class="formEnviar"   type="text" name="PRCAgentePersona" id="PRCAgentePersona"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Compania<div><input class="formEnviar"  type="text" name="PRCCompaniaAgentePersona" id="PRCCompaniaAgentePersona"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio RC<div><input class="formEnviar fechaPersona"    type="text" name="fecIniPRCAgentePersona" id="fecIniPRCAgentePersona" autocomplete="off"></div></label></div></div>
        <div class="col-md-3"><div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin RC<div><input class="formEnviar fechaPersona"   type="text" name="fecFinPRCAgentePersona" id="fecFinPRCAgentePersona" autocomplete="off"></div></label></div></div>
    </div>
  </div>
</div>

<div class="divPerson agent-person"><button  onclick="Verdatos(this,'PERMISOS ADICIONALES')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">PERMISOS ADICIONALES▲</button>
  <div class="divPersonSub ocultar">
       <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta"><div id="divTipoAgente" ></div></label></div>
  </div>
</div>

<div class="divPerson agent-person"><button onclick="Verdatos(this,'PERMISOS DE COTIZACION')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">PERMISOS DE COTIZACION ▼</button>
	<div class="divPersonSub ocultar">
    <div>
      <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Accidentes y enfermedades<div><select  class="formEnviar" name="cotizasAcciEnferm" id="cotizasAcciEnferm"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
      <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Danos<div><select class="formEnviar"  name="cotizaDanios" id="cotizaDanios"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
      <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Fianzas<div><select class="formEnviar"  name="cotizaFianzas" id="cotizaFianzas"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
      <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Vehiculos<div><select class="formEnviar"  name="cotizaVehiculos" id="cotizaVehiculos"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
      <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Vida<div><select class="formEnviar"  name="cotizaVida" id="cotizaVida"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
    </div>
  </div>
</div>

<div class="divPerson agent-person"><button onclick="Verdatos(this,'PERMISOS LEGALES')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">PERMISOS DE LEGALES ▼</button>
	<div class="divPersonSub ocultar">
    <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Recabar Informacion<div><select class="formEnviar"  name="recabarInfo" id="recabarInfo"><option value="0">SI</option><option value="-1">NO</option></select></div></label></div>
    <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Asesorias de Producto<div><select class="formEnviar"  name="asesoriaProduc" id="asesoriaProduc"><option value="1">SI</option><option value="-1">NO</option></select></div></label></div>
    <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Cobranza Primas<div><select class="formEnviar"  name="cobranzaPri" id="cobranzaPri"><option value="2">SI</option><option value="-1">NO</option></select></div></label></div>
    <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Endosos o Modificaciones<div><select class="formEnviar"  name="endoModif" id="endoModif"><option value="3">SI</option><option value="-1">NO</option></select></div></label></div>
  </div>
</div>

<div class="divPerson agent-person"><button onclick="Verdatos(this,'TARGET DE AGENTES')" class="objetosResponsivos btnCab objetosResponsivoGrande requiredShow" data-typeUser="Agent">TARGET DE AGENTES ▼</button>
	<div class="divPersonSub ocultar">
    <div id="targetPersona"></div>
  </div>
</div>

<div class="divPerson"><button  onclick="Verdatos(this,'BANCOS')" class="objetosResponsivos btnCab objetosResponsivoGrande ">BANCOS ▲</button>
  <div class="divPersonSub ocultar">
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Banco<div><select class="formEnviar"  name="idBanco" id="idBanco"></select></div></label></div>
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Clave<div><input  class="formEnviar" type="text" name="claveBancoPersona" id="claveBancoPersona"></div></label></div>
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cuenta<div><input  class="formEnviar" type="text" name="cuentaBancoPersona" id="cuentaBancoPersona"></div></label></div>
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de cuenta<div><input  class="formEnviar" type="text" name="tipoCuentaBancoPersona" id="tipoCuentaBancoPersona"></div></label></div>
  </div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'DOMICILIO')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DOMICILIO ▼</button>
<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Calle<div><input class="formEnviar"  type="text" name="calle" id="calle"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cruzamiento<div><input class="formEnviar"  type="text" name="cruzamiento" id="cruzamiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Colonia<div><input class="formEnviar" type="text" name="colonia" id="colonia"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Numero<div><input class="formEnviar"  type="text" name="numero" id="numero"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Codigo Postal<div><input class="formEnviar"  type="text" name="codigoPostal" id="codigoPostal"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pais<div><input class="formEnviar" type="text" name="paisDomicilio" id="paisDomicilio"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado<div><input  class="formEnviar" type="text" name="estadoDomicilio" id="estadoDomicilio"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Municipio<div> <input class="formEnviar"  type="text" name="municipioDomicilio" id="municipioDomicilio"></div></label></div>
</div>
</div>


<div class="divPerson"><button onclick="Verdatos(this,'CONTACTO')" class="objetosResponsivos btnCab objetosResponsivoGrande">CONTACTO ▼</button>
  <div class="divPersonSub ocultar">
  <div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Tel. Casa<div><input class="formEnviar" type="text" name="telCasa" id="telCasa"></div></label></div>
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tel. Oficina<div><input class="formEnviar"  type="text" name="telOficina" id="telOficina"></div></label></div>
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tel. Oficina Extension<div><input class="formEnviar"  type="text" name="telOficinaExtension" id="telOficinaExtension"></div></label></div>
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Personal<div><input class="formEnviar"  type="text" name="celPersonal" id="celPersonal" ></div></label></div>
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Oficina<div><input  class="formEnviar" type="text" name="celOficina" id="celOficina"></div></label></div>
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Corre Electronico<div><input class="formEnviar" type="text" name="emailPersonal" id="emailPersonal"></div></label></div>
  </div>
</div>


<!-- Miguel Jaime 26-11-2021-->
<div class="divPerson"><button onclick="Verdatos(this,'REQUERIMIENTOS Y PERFIL DEL PUESTO')" class="objetosResponsivos btnCab objetosResponsivoGrande">REQUERIMIENTOS Y PERFIL DEL PUESTO ▼</button>
   <?php
   include('requerimientos.php');
   ?>
</div>


<div class="divPerson"><button onclick="Verdatos(this,'OTROS')" class="objetosResponsivos btnCab objetosResponsivoGrande">OTROS ▼</button>
	<div class="divPersonSub ocultar">


<!--Datos Nuevos Miguel Jaime-->
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Nombre y Apellido del Padre:<div><input class="formEnviar" type="text" name="nombrePapa" id="nombrePapa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Edad del Padre<div><input class="formEnviar"  type="text" name="edadPapa" id="edadPapa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Nombre y Apellido de la Madre<div><input class="formEnviar"  type="text" name="nombreMama" id="nombreMama"></div></label></div>

<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Edad de la Madre<div><input class="formEnviar" type="text" name="edadMama" id="edadMama"></div></label></div>
<div class="row">
  <div class="col-sm-3 col-md-3 col-lg-3">
      <label  class="Responsivo lbEtiqueta">Nombre y Apellido de Hijo(a):<div>
        <input type="text" name="nombreHijoPersona" id="nombreHijoPersona"></div>
      </label>
  </div>
  <div class="col-sm-3 col-md-3 col-lg-3">
      <label  class="Responsivo lbEtiqueta">Edad de Hijo(a):<div>
        <input type="number" name="EdadHijoPersona" id="edadHijoPersona"></div>
      </label>
      <button class="btn btn-sm btn-primary" onclick="agregarHijo()"><i class="fa fa-plus-circle"></i></button>
  </div>
  <div class="col-sm-3 col-md-3 col-lg-3">
      <label  class="Responsivo lbEtiqueta">Nombre y Apellido de Esposo(a):<div>
        <input class="formEnviar" type="text" name="nombreEsposo" id="nombreEsposo"></div>
      </label>
  </div>
  <div class="col-sm-3 col-md-3 col-lg-3">
      <label  class="Responsivo lbEtiqueta">Edad de Esposo(a):<div>
        <input class="formEnviar" type="text" name="edadEsposo" id="edadEsposo"></div>
      </label>
  </div>
</div>
  <div class="row">
  <input type="hidden" name="base" id="base" value="<?php echo base_url()?>">
   <div class="col-sm-6 col-md-6 col-lg-6">
    <div id="divtablaHijos">
      <?php include('tablaHijosPersona.php');?>
    </div>
   </div>
 </div>

<hr>
<!--fin -->




    
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Accidente Avisar<div><input class="formEnviar" type="text" name="accidtePersonaAvisa" id="accidtePersonaAvisa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tel. Accidente<div><input class="formEnviar"  type="text" name="telPersonaAvisa" id="telPersonaAvisa"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Recomendado<div><input class="formEnviar"  type="text" name="recomendarPersona" id="recomendarPersona" ></div></label></div>

<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">IMSS<div><input class="formEnviar" type="text" name="imssPersona" id="imssPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tiene Hijos<div><select  class="formEnviar" name="hijosPersona" id="hijosPersona">
	<option value="SI">Si</option><option value="NO"> No</option>
</select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Gasto Mensual<div><input class="formEnviar" type="text" name="gastoMenPersona" id="gastoMenPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Meta<div><input class="formEnviar" type="text" name="metaPersona" id="metaPersona"></div></label></div>

<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Comida Favorita<div><input class="formEnviar" type="text" name="comidaFavPersona" id="comidaFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Color Favorito<div><input class="formEnviar" type="text" name="colorFavPersona" id="colorFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pasatiempo Favorito<div><input class="formEnviar" type="text" name="pasatiempoFavPersona" id="pasatiempoFavPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Club Social<div><input class="formEnviar" type="text" name="clubSocialPersona" id="clubSocialPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Referencia<div><input class="formEnviar" type="text" name="referenciaPersona" id="referenciaPersona"></div></label></div>
<!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tiene Vehiculo<div><select class="formEnviar"  name="vehiculoPersona" id="vehiculoPersona">
	<option value="SI">Si</option><option value="NO">No</option>
</select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Modelo<div><input class="formEnviar" type="text" name="modeloVehiculoPersona" id="modeloVehiculoPersona"></div></label></div>
</div>-->
</div>

<div class="divPerson"><button onclick="Verdatos(this,'IMAGENES')" class="objetosResponsivos btnCab objetosResponsivoGrande">IMAGENES ▼</button>
  <div class="divPersonSub ocultar">
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagen Personal<div><input type="file" id="imgPersonal" onchange="if(!this.value.length)return false; enviarArchivo(this,'0');"></div></label></div>

    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Ver Imagen Personal<div><button class="btn-primary" onclick="direccionAJAX('ventanaImagenPersonal','sinID')">Imagen Personal</button></div></label></div>

    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagenes<div><input type="file" id="imgGeneral" onchange="if(!this.value.length)return false; enviarArchivo(this,'1');"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagenes<div><button class="btn-primary" onclick="direccionAJAX('ventanaImagenes','sinID')">Ver galeria</button></div></label></div>
</div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'DOCUMENTOS')" class="objetosResponsivos btnCab objetosResponsivoGrande">DOCUMENTOS ▼</button>
	<div class="divPersonSub ocultar">
<div id="documentosPersona">
	
</div>


</div>
</div>
<div class="divPerson"><button onclick="Verdatos(this,'DESCARGAS')" class="objetosResponsivos btnCab objetosResponsivoGrande">DESCARGAS ▼</button>
	<div class="divPersonSub ocultar">
	<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta"> <a href="<?=base_url();?>assets/documentos/AgentesLayout.xlsx"><button class="objetosResponsivos  btn-secondary">descargar layout de agentes</button></a>      <div></div></label></div>
	<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta"><form method="POST" action="<?=base_url();?>persona/caratulaAltaAgentes"><input type="submit" name="" id="submitIdPersonaCaratula" value="Caratula"><input type="hidden" name="idPersonaCaratula" id="idPersonaCaratula"></form>     <div></div></label></div>
</div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'AGENTES EN ESPERA')" class="objetosResponsivos btnCab objetosResponsivoGrande">AGENTES EN ESPERA ▼</button>
	<div class="divPersonSub ocultar">
  <div class="panel panel-body">
      <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#temporal-agent" aria-controls="temporal-agent" role="tab" data-toggle="tab">Agentes temporales</a></li>
          <?php 
            $validateAcounts = array("CAPITALHUMANO@AGENTECAPITAL.COM", "SISTEMAS@ASESORESCAPITAL.COM");

            if(in_array($this->tank_auth->get_usermail(), $validateAcounts)){?>
              <li role="presentation"><a href="#set-free" aria-controls="set-free" role="tab" data-toggle="tab">Liberar de inducción</a></li>
              <li role="presentation"><a href="#permit-person" aria-controls="permit-person" role="tab" data-toggle="tab">Solicitudes de alta</a></li>
            <?php }?>
        </ul>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="temporal-agent">
            <div class="ResponsivoDiv">
              <label class="Responsivo lbEtiqueta" id="agentesEnEspera"> </label>
            </div>
          </div>
          <?php if(in_array($this->tank_auth->get_usermail(), $validateAcounts)){?>
          <div role="tabpanel" class="tab-pane table-responsive" id="set-free">
            <h6>Liberación de inducción</h6>
            <table class="table table-sm" width="70">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>NOMBRE</th>
                  <th>CREADO POR </th>
                  <th>TIPO</th>
                  <th>LIBERAR</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($forSetFreePerson as $data){?>
                  <tr>
                    <td><?=$data->idPersona?></td>
                    <td><?=$data->nombres." ".$data->apellidoPaterno." ".$data->apellidoMaterno?></td>
                    <td><?=$data->userEmailCreacion?></td>
                    <td><?=($data->tipoPersona == 1 ? "COLABORADOR" : "AGENTE")?></td>
                    <td><a href="<?=base_url()?>persona/agente?liberar=<?=$data->idPersona?>" role="button" class="btn btn-primary btn-xs">Alta de inducción</a></td>
                  </tr>  
                <?php }?>
              </tbody>
            </table>
          </div>
          <div role="tabpanel" class="tab-pane" id="permit-person">
            <h6>Liberación de inducción</h6>
            <table class="table table-sm" width="70">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>NOMBRE</th>
                  <th>SOLICITADO POR </th>
                  <th>TIPO</th>
                  <th>LIBERAR</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($forRegistrationRequests as $data){?>
                  <tr>
                    <td><?=$data->idPersona?></td>
                    <td><?=$data->nombres." ".$data->apellidoPaterno." ".$data->apellidoMaterno?></td>
                    <td><?=!empty($data->userEmailCreacion) ? $data->userEmailCreacion : $data->creator?></td>
                    <td><?=($data->tipoPersona == 1 ? "COLABORADOR" : "AGENTE")?></td>
                    <td><a href="<?=base_url()?>persona/agente?permitir=<?=$data->idPersona?>" role="button" class="btn btn-primary btn-xs">Aceptar solicitud</a></td>
                  </tr>  
                <?php }?>
              </tbody>
            </table>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
	<!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta" id="agentesEnEspera"> </label></div>-->

</div>
</div>

</div>
<div id="divModalGenerico" class="modalCierra">
  <div class="modal-btnCerrar" style="width: 75%;height: 50px;" ><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido" style="width: 75%;height: 500px;overflow: scroll;" >

</div>
<div id="divModalGenericoComentarios" class="ocultarHijoModal" style="border:solid;position:relative;top: -40%">
  <div><button style="color: white;background-color:red; border:double;" onclick="cerrarModalHijo('divModalGenericoComentarios')">X</button><input type="text" id="textIdPersonaComentario"><input type="text" id="textTipoComentarioPN"></div><hr>
  <div class="row"><div class="col-md-12"><input type="text" name="" id="comentarioParaAN" class="form-control" placeholder="agregar comentario"></div><div class="col-md-4"><button class="btn btn-success" onclick="grabaComentarioAgenteNuevo('')">Guardar</button></div><div class="col-md-12" style="height: 160px;width: 100%; overflow: auto;"><table class="table"><thead><tr><td>Comentario</td><td>Fecha</td><td>Modificar</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneComentarios"></tbody></table></div></div>
</div>

<div id="divModalGenericoSubirDocumentos" class="ocultarHijoModal" style="border:solid;position:relative;top: -40%">
  <div><button style="color: white;background-color:red; border:double;" onclick="cerrarModalHijo('divModalGenericoSubirDocumentos')">X</button></div><hr>
  <div class="row"><div class="col-md-12"><form id="formArchivoAgenteNuevo"><input type="file" id="subirArchivoAgenteNuevo" name="Archivo" style="" onchange="agregaArchivoAgenteNuevo('',this);"><input type="hidden" name="idPersona" id="textIdPersonaSubirDocumentoPN"><input type="hidden" name="idTipoArchivo" id="textTipoComentarioSubirDocumentoPN"></form></div><div class="col-md-12" style="height: 160px;width: 90%; overflow: auto;"><table class="table"><thead><tr><td>Documento</td><td>Eliminar</td></tr></thead><tbody id="tablaBodyContieneDocumentos"></tbody></table></div></div>
</div>

</div>

<div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-labelledby="alertLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!--<div class="modal-header"></div> -->
      <div class="modal-body body-alert">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade w-template-modal" tabindex="-1" role="dialog" aria-labelledby="w-template-modal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header"><h4>Previsualización</h4></div>
      <div class="modal-body w-template-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary send-welcome-message" disabled>Enviar mensaje de bienvenida</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="sendNotification" value="0" id="sendNotification" class="formEnviar">
<?php if(isset($prospectiveAgent)) {?>

<input type="hidden" class="formEnviar" name="prospectiveAgent" value="<?=$prospectiveAgent?>" id="prospectiveAgent" data-baseUrl="<?=base_url()?>">
<?php } 

if(isset($setfree)){?> 
  <input type="hidden" class="formEnviar" name="setfree" value="<?=$setfree?>" id="setfree" data-baseUrl="<?=base_url()?>">
<?php }
  if(isset($permit)){
?>
  <input type="hidden" class="formEnviar" name="permit" value="<?=$permit?>" id="permit" data-baseUrl="<?=base_url()?>">
<?php } ?>

<input type="hidden" id="pass-to-inducction" value="<?= isset($crossToInducction) && $crossToInducction?>">
<input type="hidden" id="banned-value" value="<?= isset($datosAgente) && $datosAgente->banned == 1 ? 1 : 0; ?>"> <!-- Dennnis Castillo [2022-03-01] -->
<!---------------------------- Seccion de JS ------------------------------>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="<?=base_url()."assets/js/js_manajeProspectiveAgent.js"?>"></script>
<script src="<?=base_url()."assets/js/jquery.setFreePerson.js"?>"></script>
<script src="<?=base_url()."assets/js/jquery.usermanagement.js"?>"></script>
<script src="<?=base_url()."assets/js/jquery.verifystafftermination.js"?>"></script>
<script src="<?=base_url()."assets/js/jquery.validAddUser.js"?>"></script>
<script>

  <?
   if(isset($permisoAgenteNuevo['PasarAgenteNuevoParaAgente'])){echo('var permisoDeAgenteNuevo=1;');}
  else{echo('var permisoDeAgenteNuevo=0;');}
  ?>
  
  function pasarComoAgente(datos,idPersona)
  {
    if(datos=='')
   {
     let params='';
      params=params+'idPersona='+idPersona;          
      controlador="persona/pasarComoAgente/?";
      peticionAJAX(controlador,params,'pasarComoAgente');    
    }   
    else
    {
      let tablaBody=document.getElementById('tableBodyAgenteNuevo');
      let tablaEstatica=document.getElementById('tbodyCabeceraEstatica');
      let cant=tablaBody.rows.length;
      for(let i=0;i<cant;i++)
      { 
        if(tablaBody.rows[i].getAttribute('data-idpersona')==datos.idPersona)
        {
          tablaBody.deleteRow(i);
          i=cant;
        }
      }      
      cant=tablaEstatica.rows.length;
      for(let i=0;i<cant;i++)
      { 
        if(tablaEstatica.rows[i].getAttribute('data-idpersona')==datos.idPersona)
        {
          tablaEstatica.rows[i].setAttribute('data-agentenuevo',0);
          i=cant;
        }
      }

    }
  }
function guardarCaracteristicasAgenteNuevo(datos,objeto=null)
{
  if(datos=='')
  {
     let params='';
      params=params+'idPersona='+objeto.getAttribute('data-idpersona');
      params=params+'&caracteristicaAgenteNuevo='+objeto.getAttribute('data-idtipoobservacion');
      if(objeto.checked){params=params+'&insertar=1';}
      else{params=params+'&insertar=0';}      
      controlador="persona/guardarCaracteristicasAgenteNuevo/?";
      peticionAJAX(controlador,params,'guardarCaracteristicasAgenteNuevo');    
  }
}
function eliminarArchivo(datos,archivo)
{
  if(datos=="")
  {      
      let params='';
      params=params+'idPersona='+document.getElementById('textIdPersonaSubirDocumentoPN').value;
      params=params+'&idTipoArchivo='+document.getElementById('textTipoComentarioSubirDocumentoPN').value;
      params=params+'&nombreArchivo='+archivo;
      controlador="persona/eliminarArchivo/?";
      peticionAJAX(controlador,params,'eliminarArchivo');    

  }
  else
  {
   bodyArchivosAgenteNuevo(datos);
  }
}
function agregaArchivoAgenteNuevo(datos,objeto=null)
{
  if(datos=='')
  {
    if(!objeto.value.length){idPromoBono='';}
    else
    {     enviarArchivoAJAX('formArchivoAgenteNuevo','subirArchivoAgenteNuevo','agregaArchivoAgenteNuevo');
    }
  }
  else{bodyArchivosAgenteNuevo(datos); }
}

function enviarArchivoAJAX(formulario,funcion,funcionJS){ 

       
      var Data = new FormData(document.getElementById(formulario));  
    if(window.XMLHttpRequest) { var Req = new XMLHttpRequest();}
    else if(window.ActiveXObject) {var Req = new ActiveXObject("Microsoft.XMLHTTP");}  
    var direccion= <?php echo('"'.base_url().'persona/"');?>+funcion;
    Req.open("POST",direccion, true);     
    Req.onload = function(Event) {    
    var respuesta = JSON.parse(Req.responseText);   
    if (Req.status == 200 && Req.readyState == 4) 
    {     
                       
     window[funcionJS](respuesta);
    } 

  };   
  Req.send(Data);


}


  function abrirModalSubirArchivos(datos,objeto=null,tipo=null,idPersona=null){
  if(datos=='')
  {    
    let cant=document.getElementsByClassName('verHijoModal').length;    
    if(cant==0)
     { 
     document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('ocultarHijoModal');
     document.getElementById('divModalGenericoSubirDocumentos').classList.toggle('verHijoModal');   
     document.getElementById('textIdPersonaSubirDocumentoPN').value=idPersona;
      document.getElementById('textTipoComentarioSubirDocumentoPN').value=tipo;     
          let params='';
      params=params+'idPersona='+idPersona;
      params=params+'&idTipoArchivo='+tipo;
      controlador="persona/devolverArchivosAgenteNuevo/?";
      peticionAJAX(controlador,params,'abrirModalSubirArchivos');    

     }
     else{alert('Ya tiene abierto un modal');}
    }
    else
    {
      bodyArchivosAgenteNuevo(datos);
    }
}

function bodyArchivosAgenteNuevo(datos)
{
   let cant=datos.archivos.length;
   let row='';
   for(let i=0;i<cant;i++)
   {
    row=row+'<tr><td>'+datos.archivos[i].url+'</td><td><button onclick="eliminarArchivo(\'\',\''+datos.archivos[i].nombreArchivo+'\')">X</button></td></tr>';
   }
   document.getElementById('tablaBodyContieneDocumentos').innerHTML=row;
}


function modficarComentarioAgenteNuevo(datos,idComentario=null,eliminar=null)
{
 if(datos=='')
 {
   let params='';
   params=params+'comentario='+document.getElementById('ComentarioTD'+idComentario).innerHTML;
   params=params+'&idComentarioAgenteNuevo='+idComentario;
   params=params+'&idPersona='+document.getElementById('textIdPersonaComentario').value;
   params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
   if(eliminar!=null)
   {
    params=params+'&activo=0';
   }

   controlador="persona/grabaComentarioAgenteNuevo/?";
   peticionAJAX(controlador,params,'modficarComentarioAgenteNuevo');    
 }
 else{bodyComentariosAgenteNuevo(datos); }
}
    function grabaComentarioAgenteNuevo(datos)
  { 
   if(datos=='')
   {
    let params='';
   params=params+'comentario='+document.getElementById('comentarioParaAN').value;
   params=params+'&idPersona='+document.getElementById('textIdPersonaComentario').value;
   params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
   controlador="persona/grabaComentarioAgenteNuevo/?";

      peticionAJAX(controlador,params,'grabaComentarioAgenteNuevo');    
    }
    else{ bodyComentariosAgenteNuevo(datos);    }
  }

function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         window[funcion](respuesta);                                                          
      }     
   }
  };
 req.send(parametros);
}


  function cerrarModalHijo(hijo)
  {
     document.getElementById(hijo).classList.toggle('ocultarHijoModal');
     document.getElementById(hijo).classList.toggle('verHijoModal');    
}
function abrirModalDocumento(datos,objeto=null,tipo=null,idPersona=null){
  if(datos=='')
  {
  }
}
  
function abrirModalComentario(datos,objeto=null,tipo=null,idPersona=null){
  if(datos=='')
  {    
    let cant=document.getElementsByClassName('verHijoModal').length;    
    if(cant==0)
     { 
     document.getElementById('divModalGenericoComentarios').classList.toggle('ocultarHijoModal');
     document.getElementById('divModalGenericoComentarios').classList.toggle('verHijoModal');   
     document.getElementById('textIdPersonaComentario').value=idPersona;
      document.getElementById('textTipoComentarioPN').value=tipo;
     document.getElementById("comentarioParaAN").removeAttribute('disabled');
          let params='';
      params=params+'idPersona='+document.getElementById('textIdPersonaComentario').value;
      params=params+'&tipoComentario='+document.getElementById('textTipoComentarioPN').value;
      controlador="persona/grabaComentarioAgenteNuevo/?";
      peticionAJAX(controlador,params,'abrirModalComentario');    

     }
     else{alert('Ya tiene abierto un modal');}
    }
    else
    {
      bodyComentariosAgenteNuevo(datos);
    }
}

function bodyComentariosAgenteNuevo(datos)
{
      let cant=datos.comentarios.length;
      let row=""; 
      for(let i=0;i<cant;i++)
      {let idComentario=datos.comentarios[i].idComentarioAgenteNuevo;
        row=row+'<tr><td contenteditable="true" id="ComentarioTD'+idComentario+'">'+datos.comentarios[i].comentario+'</td><td>'+datos.comentarios[i].fechaCreacion+'</td>';
        row=row+'<td><button onclick="modficarComentarioAgenteNuevo(\'\','+idComentario+')">...</button></td><td><button onclick="modficarComentarioAgenteNuevo(\'\','+idComentario+',1)">-</button></td></tr>';
      }
      document.getElementById('tablaBodyContieneComentarios').innerHTML=row;
}

  function mostrarTablaAgenteNuevo(datos='')
  {
    if(datos=='')
    {
    let tabla=document.getElementById('tbodyCabeceraEstatica');
     let option='<option value=""></option>';
     option=option+document.getElementById('selectFiltroCreador').innerHTML;
    let tablaCantidad=tabla.rows.length;    
     let tablaAgente='<table class="table"><thead><tr><th>Agente de Nuevo Ingreso</th><th><label>Usuario Creador<select class="form-control" onchange="filtraTablaAgenteNuevo(this)">'+option+'</select></label></th><th>My Info</th><th>Induccion empresa</th><th>Manual Agente</th><th>Agente Ideal</th><th>Capacitacion del Sistema</th><th>Visto Bueno</th></tr></thead><tbody id="tableBodyAgenteNuevo">';
    let id="";
    for(let i=0;i<tablaCantidad;i++)
    {
      if(tabla.rows[i].getAttribute('data-agentenuevo')==1)
      {let idPersona=tabla.rows[i].getAttribute('data-idpersona');
      let tipoPersona=tabla.rows[i].getAttribute('data-tipopersona');
         if(tipoPersona=='1'){tipoPersona='(Colaborador)';}
         else{tipoPersona='(Agente)';}
        id=id+idPersona+',';
        tablaAgente=tablaAgente+'<tr data-idpersona="'+tabla.rows[i].getAttribute('data-idpersona')+'" data-usercreacion="'+tabla.rows[i].getAttribute('data-usercreacion')+'"><td>'+tabla.rows[i].getAttribute('data-nombreagente')+tipoPersona+'</td><td>'+tabla.rows[i].getAttribute('data-usercreacion')+'</td><td><input id="cb'+idPersona+'miinfo" type="checkbox" data-idpersona="'+idPersona+'" data-idtipoobservacion="miinfo" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)"></td><td><button onclick="abrirModalComentario(\'\',this,\'induccionempresa\','+idPersona+')">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'induccionempresa\','+idPersona+')">↑</button><input id="cb'+idPersona+'induccionempresa" type="checkbox" data-idpersona="'+idPersona+'" data-idtipoobservacion="induccionempresa" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)"></td><td><button onclick="abrirModalComentario(\'\',this,\'manualagente\','+idPersona+')">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'manualagente\','+idPersona+')">↑</button><input id="cb'+idPersona+'manualagente" type="checkbox" data-idpersona="'+idPersona+'" data-idtipoobservacion="manualagente" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)"></td><td><button onclick="abrirModalComentario(\'\',this,\'agenteideal\','+idPersona+')">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'agenteideal\','+idPersona+')">↑</button><input id="cb'+idPersona+'agenteideal" type="checkbox" data-idpersona="'+idPersona+'" data-idtipoobservacion="agenteideal" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)"></td><td><button onclick="abrirModalComentario(\'\',this,\'capacitacionsistema\','+idPersona+')">...</button><button onclick="abrirModalSubirArchivos(\'\',this,\'capacitacionsistema\','+idPersona+')">↑</button><input id="cb'+idPersona+'capacitacionsistema" type="checkbox" data-idpersona="'+idPersona+'" data-idtipoobservacion="capacitacionsistema" onclick="guardarCaracteristicasAgenteNuevo(\'\',this)"></td>';
        
          if(permisoDeAgenteNuevo=='1')
          {
            tablaAgente=tablaAgente+'<td><button onclick="pasarComoAgente(\'\','+idPersona+')">Aceptar</button></td></tr>';

          }
          else
          {
            tablaAgente=tablaAgente+'<td></td></tr>';            
          }
      }
//      abrirModalSubirArchivos
    }
    tablaAgente=tablaAgente+'</tbody></table>';
    document.getElementById('divModalContenidoGenerico').innerHTML=tablaAgente;
    cerrarModal('divModalGenerico');
    let params='';
      params=params+'idPersona='+id;      
      controlador="persona/caracteristicaAgenteNuevo/?";
      peticionAJAX(controlador,params,'mostrarTablaAgenteNuevo');   
     }
    else
    {
     let cant=datos.caracteristicas.length;     
     for(let i=0;i<cant;i++)
     {
      let cb='cb'+datos.caracteristicas[i].idPersona+datos.caracteristicas[i].caracteristicaAgenteNuevo;      
      document.getElementById(cb).checked=true;
     }
    }
  }
  function mandaMiInfo(row,correo,idPersona){   
      var direccion="<?php echo(base_url().'miInfo?userMail=');?>";
      direccion=direccion+correo+"&idPersona="+idPersona;
 
      var a = document.createElement("a");
    a.target = "_blank";
    a.href=direccion;
    //a.href = direccion+row.parentNode.parentNode.cells[7].innerHTML;
    a.click();
  }
  function escogeAgente(objeto){

  document.getElementById("idPersonas").value=objeto.cells[0].innerHTML

  }
function filtroTablaGenerico(objeto,objetoTabla){
 var cantidad=objetoTabla.rows.length;
  for(var i=1;i<cantidad;i++){
    
  if(objetoTabla.rows[i].innerText.indexOf(objeto.value)>-1){
    objetoTabla.rows[i].style.display = "";
  } 
  else{
    objetoTabla.rows[i].style.display = "none";
  }
 }

}
function filtraTablaAgenteNuevo(objeto)
{
    var filtro=objeto.value;
    var tabla=document.getElementById("tableBodyAgenteNuevo");    
    var cantidad=tabla.rows.length;
   var contador=0;
    if(filtro!='')
    {
     for(var i=0; i<cantidad;i++)
     {
        var texto=tabla.rows[i].getAttribute('data-usercreacion');                
        console.log(texto+'---'+filtro);
        if(texto==filtro)
          { 
            tabla.rows[i].classList.add("verElemento");           
            tabla.rows[i].classList.remove("ocultarElemento");                                   
           }
           else{ tabla.rows[i].classList.add("ocultarElemento");tabla.rows[i].classList.remove("verElemento");}
         
         
     }
    }
    else{
       for(var i=0; i<cantidad;i++){
          tabla.rows[i].classList.add("verElemento");            
            tabla.rows[i].classList.remove("ocultarElemento");            
            
       }
    }
  
}
  function filtroCreador(objeto){
    
    var filtro=document.getElementById("selectFiltroCreador").value;
    var tabla=document.getElementById("tableCabeceraEstatica").childNodes[1];    
    var cantidad=tabla.rows.length;
   var contador=0;
    if(objeto.checked){
     for(var i=0; i<cantidad;i++){
                //var texto=tabla.rows[i].cells[8].childNodes[0].innerHTML;
                var texto=tabla.rows[i].getAttribute('data-usercreacion');
         if(i>=0){         
          if(texto.indexOf(filtro)>=0)
          { contador=contador+1;

            tabla.rows[i].classList.add("verElemento");           
            tabla.rows[i].classList.remove("ocultarElemento");           
            tabla.rows[i].cells[1].innerHTML=contador;
            
           }
           else{ tabla.rows[i].classList.add("ocultarElemento");tabla.rows[i].classList.remove("verElemento");}
         }
         else{   tabla.rows[i].classList.add("verElemento");}
     }
    }
    else{
       for(var i=0; i<cantidad;i++){
          tabla.rows[i].classList.add("verElemento");            
            tabla.rows[i].classList.remove("ocultarElemento");            
             tabla.rows[i].cells[1].innerHTML=i+1;
       }
    }
  }
	function Verdatos(object,texto){
   this.event.preventDefault();
 //  alert(object.parentNode.parentNode);
 //object.parentNode.parentNode.classList.add('ocultar')
 cantidad=object.parentNode.parentNode.childNodes.length;
  console.log(cantidad);
 for(var i=0;i<cantidad;i++){
 	if(object.parentNode.childNodes[i])
 	{
 	if(object.parentNode.childNodes[i].nodeName=="DIV")
 	{
 		if(object.parentNode.childNodes[i].classList.contains("ocultar")){
      object.parentNode.childNodes[i].classList.remove("ocultar");
      object.parentNode.childNodes[i].classList.add("ver");
      object.innerHTML=texto+" ▲"
    }
 		else{
      object.parentNode.childNodes[i].classList.remove("ver");
      object.parentNode.childNodes[i].classList.add("ocultar");
      object.innerHTML=texto+" ▼"
    }
 	}
  } 

 }

	}


$(function () {
  

$("#fechaNacimiento").datepicker({
  closeText: 'Cerrar',
  prevText: 'Anterior',
  nextText: 'Siguiente',
    currentText: 'Hoy',
    //currentDay:new Date(),
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});
</script>



<? $this->load->view('footers/footer'); ?>
<style type="text/css">
body{overflow-x: hidden;  }
.divPerson{width: 100%;height: auto; margin-top:20px;}
.divPersonSub{width: 100%;height: auto; margin-top:10px;}
.divPersonCab{width: 100%;height: 30px;  }
.lbCabPersona{width: 100%;height: 30px;  clear: both;}
.ResponsivoDiv{float: left;}
.ResponsivoDivMe600{width: 100%;height: 160px }
.ResponsivoDivMe900{width: 50%; height: 180px }
.ResponsivoDivMa901{width: 25%;  }
.lbEtiqueta{color: black;background-color: #f5f5f5}
.lbEtiquetaMe600{font-size: 36px;height: 160px;color: black;background-color: #f5f5f5}
.lbEtiquetaMe900{font-size: 24px; height: 180px;color: black;background-color: #f5f5f5}
.lbEtiquetaMa901{font-size: 12px;color: black;background-color: #f5f5f5}
.objetosResponsivos{ }
.objetosResponsivoGrande{width: 100%;height: 100%}
.objectResp600{font-size: 36px;height: auto;width: 100%;margin-bottom: 13px }
.objectResp900{font-size: 24px; height: 50px;width: 100%;}
.objectResp901{font-size: 12px; color: black}
.ver{display: block;}
.ocultar{display: none; height: 200px}
.btnCab{background-color: #8370a1;color:white;}
.btnCab:hover {background-color: #67439f}
.ajustaAltura{height:auto}
.classFilaPrimar{background-color: #85cae7}
.classFilaPrimar > td {background-color: #85cae7}
.classFilaPrimar > td > label {background-color: #85cae7}
.filaImportante{background-color: #85cae7}
.filaImportante > td {background-color: #85cae7}
.filaImportante > td > label {background-color: #85cae7}
.classFilaSecund{}
.imgMisCursos{
  width: 200px;height: 200px;margin-left: 10px; margin-top: 10px;position: relative;top:0px;border: double;}
  .divGenericoImagenes{float: left;}
  .verElementoCabecera{display: table-header-group;}
  .verElemento{display:  table-row; }
  .trPersona:hover { background-color: green;color: green }
  .ocultarElemento{display: none;}
  .baneadoPersona{background-color: red}
  .labelNombrePersona{background-color: white;color: black; font-size: 22px}
.divTD{width: 130px; overflow: auto;}
  .tableV3{width: 100%}
  .tableV3>thead{background-color: #472380;color: white;}
  .tbodyCabeceraEstatica tr:nth-child(even) { background: #ddd }
.certiOption{display: inline-block;width: 15%;}
.certiOption input{width: 100%;}
.certiOption label {width: 100%;}
.certiOptionOculto{display: none;width: 15%;}
.modal-footer{text-align: right;}
.modal-btnCerrar{background-color:white;width:800px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
.verObjeto{display: block;}
.ocultarObjeto{display: none}
.formProspecto > label{color: black; text-decoration: underline;}
.ocultarHijoModal{display: none}
.verHijoModal{position: relative;top:-80%;left:30%;z-index:200000;background: #bfbac5;width: 500px;height: 300px}
 
  <?php
/*==============CONFIGURA ALGUNOS PARAMETROS SI ES COORDINADOR, AGENTE O MASTER==============*/
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'  ){

  echo(".lbSICAS{color: red}");
  }
 ?>

}
</style>


<script>
function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
}


window.addEventListener("resize",redimensionar);
redimensionar();
function filtrarBusqueda(){
  var busqueda=document.getElementById('idPersonas');
  var filtro=document.getElementById('txtBuscarFiltro').value.toUpperCase();
  var contador=busqueda.length;var text="";
  for(var j=2;j<contador;j++)
    {text=busqueda[j].innerHTML;
      if(text.indexOf(filtro)>=0){busqueda[j].classList.add('verElemento');busqueda[j].classList.remove('ocultarElemento');}
      else{ busqueda[j].classList.add('ocultarElemento'); busqueda[j].classList.remove('verElemento');}}
}
function redimensionar(){
var responsivo=document.getElementsByClassName('Responsivo');
var responsivoDiv=document.getElementsByClassName('ResponsivoDiv');
var objetosResponsivos=document.getElementsByClassName('objetosResponsivos');

  var cantidad=responsivo.length;
  var cantidadDiv=responsivoDiv.length;
  var cantObjetosResponsivos=objetosResponsivos.length;

var w = window.outerWidth;var h = window.outerHeight;
if(w<600)
{for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp900');objetosResponsivos[i].classList.remove('objectResp901');objetosResponsivos[i].classList.add('objectResp600');}
	  for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMe900');responsivoDiv[i].classList.remove('ResponsivoDivMa901');responsivoDiv[i].classList.add('ResponsivoDivMe600');}
  for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMe900');responsivo[i].classList.remove('lbEtiquetaMa901');responsivo[i].classList.add('lbEtiquetaMe600');}
}
else
{
   if(w>601 && w<700)
   {
   	for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp901');objetosResponsivos[i].classList.remove('objectResp600');objetosResponsivos[i].classList.add('objectResp900');}
   	for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMa901');responsivoDiv[i].classList.remove('ResponsivoDivMe600');responsivoDiv[i].classList.add('ResponsivoDivMe900');}
    for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMa901');responsivo[i].classList.remove('lbEtiquetaMe600');responsivo[i].classList.add('lbEtiquetaMe900');}
   }
  else
  {for(i=0;i<cantObjetosResponsivos;i++){objetosResponsivos[i].classList.remove('objectResp900');objetosResponsivos[i].classList.remove('objectResp600');objetosResponsivos[i].classList.add('objectResp901');}
   for(i=0;i<cantidadDiv;i++){responsivoDiv[i].classList.remove('ResponsivoDivMe900');responsivoDiv[i].classList.remove('ResponsivoDivMe600');responsivoDiv[i].classList.add('ResponsivoDivMa901');}
  for(i=0;i<cantidad;i++){responsivo[i].classList.remove('lbEtiquetaMe900');responsivo[i].classList.remove('lbEtiquetaMe600');responsivo[i].classList.add('lbEtiquetaMa901');}
  }
 }
}

function imprimeTarget(object,event){

	event.preventDefault();
	//event.stopPropagation();
}

function enviarForm(){
  var formulario=document.createElement('form'); 
      formulario.setAttribute('method','post'); 
      formulario.action=<?php echo('"'.base_url().'persona/agente"'); ?>;
  objetosForm=document.getElementsByClassName('formEnviar');
  objetos="";
  idPromotoria="";
  idPersonaTipoAgente="";
  cant=objetosForm.length;
  //--------------
  const validateParam = validateGetParam("liberar"); //Dennis Castillo [2022-01-06]
  //--------------
  //Dennis Castillo [2021-11-02]
  var validateInputs = ["celPersonal", "emailPersonal", "telCasa"];
  var validateValues = [];
  //--------------
  for(var i=0;i<cant;i++){
    tipo=objetosForm[i].nodeName;

    //--------------
    //Dennis Castillo [2021-11-07]
    if(objetosForm[i].name == "tipoPersona" && objetosForm[i].value == ""){
        alert("Seleccione a un tipo de usuario (combo de tipo de persona).");
        return false;
    }
    //--------------
    //Dennis Castillo [2021-11-02]
    if(validateInputs.includes(objetosForm[i].name) && objetosForm[i].value !== ""){
      validateValues.push(objetosForm[i].value);
    }
    //-------------
    var objeto=document.createElement('input'); 
    //objeto.setAttribute("type", "hidden");

    if(objetosForm[i].name=='cbPromotoria'){
        if(objetosForm[i].checked){idPromotoria=idPromotoria+objetosForm[i].value+";";}
    } else{
      if(objetosForm[i].name=='cbPermisosPTA')
        {
          if(objetosForm[i].checked){idPersonaTipoAgente=idPersonaTipoAgente+objetosForm[i].value+";";}
          }
        else
        {
            objeto.name=objetosForm[i].name;
            objeto.value=objetosForm[i].value;
            formulario.appendChild(objeto);
        }
    }
  }

  //--------------
  //Dennis Castillo [2021-11-02]
  if(validateValues.length == 0){
    alert("Los campos de contacto (teléfono de casa, celular y correo personal) deben de contener datos.\nRevisar en el apartado de contacto.");
    return false;
  }
  //-------------
    //console.log(validateValues);
    var objeto=document.createElement('input');
      objeto.name="promotoriasActivadas";
      objeto.value=idPromotoria;
      formulario.appendChild(objeto); 
  document.body.appendChild(formulario);
      var objeto=document.createElement('input');
      objeto.name="permisoPTA";
      objeto.value=idPersonaTipoAgente;
      formulario.appendChild(objeto); 
  document.body.appendChild(formulario);
  //formulario.submit();

  var tipoContrato=document.getElementById("idModalidad");
  var tipoAgente=document.getElementById("personaTipoAgente");
  var tipoCanal=document.getElementById("id_catalog_canales");
  var tipoCuenta="<?=$this->tank_auth->get_usermail()?>";
  
  if(document.getElementById('tipoPersona').value!=1 && document.getElementById('tipoPersona').value!=5)
  {
    if(tipoCuenta=="DIRECTORGENERAL@AGENTECAPITAL.COM" || tipoCuenta=="SISTEMAS@ASESORESCAPITAL.COM" ||tipoCuenta=="AUDITORINTERNO@AGENTECAPITAL.COM"){

      if(tipoContrato.value == 0 && tipoAgente.value == 0 && tipoCanal.value == 0){
        alert("Los campos tipo contrato, tipo de agente y canal son obligatorios");
        return false;
      }
    } else{
      if(tipoContrato.value == 0 && tipoAgente.value == 0){
        alert("Los campos tipo contrato y tipo de agente son obligatorios");
        return false;
      }
    }
  } else{
    if((document.getElementById('idPersonaPuesto').value==0 || document.getElementById('idColaboradorArea').value==0)&& document.getElementById('tipoPersona').value!=5){
      alert("Para agregar colaborador tienes que escoger un puesto y area");
      return false;
    }
  }
  //-------------------
  if(validateParam){

    const nam = document.getElementById("nombres").value;
    const app = document.getElementById("apellidoPaterno").value;
    const apm = document.getElementById("apellidoMaterno").value;
    const confirm = window.confirm(`¿Está seguro de liberar de inducción al siguiente usuario?\n Nombre: ${nam} ${app} ${apm}`);

    var objetoNotification = document.createElement('input');
    objetoNotification.name = "sendNotification";
    objetoNotification.value = confirm ? 1 : 0;
    formulario.appendChild(objetoNotification);
  }
  //-------------------
  formulario.submit();
}

function enviarFormGenerales(accion){
  var direccion="";var clase="";
  switch(accion){
  case 1:direccion=<?php echo('"'.base_url().'persona/banear"'); ?>;clase="usuarioClass";break;
  case 2:direccion=<?php echo('"'.base_url().'persona/habilitar"'); ?>;clase="usuarioClass";break;
  case 3:direccion=<?php echo('"'.base_url().'persona/crearUsuarioSicas"'); ?>;clase="usuarioClass";break;
  case 4:direccion=<?php echo('"'.base_url().'persona/reporteAgentes"'); ?>;clase="";break;
    }
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement( 'input'); 
      objeto.name=objetosForm[i].name;objeto.value=objetosForm[i].value;formulario.appendChild(objeto);
 
  }
  document.body.appendChild(formulario);
  formulario.submit();
}


function enviarArchivo(objeto,caso){
  objeto.setAttribute('name',objeto.id);
  var formulario=document.createElement('form'); 
  formulario.setAttribute('method','post'); 
  formulario.enctype='multipart/form-data';
  formulario.action=<?php echo('"'.base_url().'persona/guardaImagen"'); ?>;
  formulario.appendChild(objeto);
  inputCaso=document.createElement('input');inputCaso.name="caso";inputCaso.value=caso;formulario.appendChild(inputCaso);
  inputIdPersona=document.createElement('input');inputIdPersona.name="idPersona";inputIdPersona.value=document.getElementById('idPersona').value;
  formulario.appendChild(inputIdPersona);
  document.body.appendChild(formulario);
  formulario.submit();

}
</script>


<script>


  <?php
   
   $option="";
   foreach ($catalogoPromotorias as $values) {
     $option=$option.'<input type="checkbox"  class="formEnviar" id="promotoria'.$values->idPromotoria.'" name="cbPromotoria" value="'.$values->idPromotoria.'"  ><label>'.$values->Promotoria.'</label><br>';
   }
   
   echo('document.getElementById(\'divCatalogoPromotorias\').innerHTML=\''.$option.'\';');

  //------------------- //Comentado por Dennis Castillo [2022-05-23]
  //$total=count($escolaridad);
  //$options='document.getElementById("escolaridad").innerHTML=\'';
  //for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$escolaridad[$i]->idEscolaridad.'">'.$escolaridad[$i]->escolaridad.'</option>';}
  //$options=$options.'\';';
  //echo($options);

  //------------------- //Comentado por Dennis Castillo [2022-05-23]
  //$total=count($estadoCivil);
  //$options='document.getElementById("estadoCivil").innerHTML=\'';
  //for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$estadoCivil[$i]->idEstadoCivil.'">'.$estadoCivil[$i]->estadoCivil.'</option>';}
  //$options=$options.'\';';
  //echo($options);
  //-------------------

if(isset($permisoPersonaTipoAgente['permisoPTAMaster'])){

    $options='document.getElementById("divTipoAgente").innerHTML=\'';
  foreach ($permisoPersonaTipoAgente['permisoPTAMaster'] as  $value) {
    $checked="";
    if($value->permiso==1){$checked="checked";}
   $options=$options.'<div ><label><input type="checkbox" class="formEnviar" name="cbPermisosPTA"  id="cbPPTA'.$value->idPersonaTipoAgente.'" value="'.$value->idPersonaTipoAgente.'" '.$checked.'>'.$value->personaTipoAgente.'</label></div>';
  }
    $options=$options.'\';';
   
  echo($options);
}



  
      $total=count($catalog_sucursales);
  $options='document.getElementById("id_catalog_sucursales").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$catalog_sucursales[$i]->IdSucursal.'">'.$catalog_sucursales[$i]->NombreSucursal.'</option>';}
  $options=$options.'\';';
  echo($options);


    /*  $total=count($catalog_canales);
  $options='document.getElementById("id_catalog_canales").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$catalog_canales[$i]->IdCanal.'">'.$catalog_canales[$i]->nombreTitulo.'</option>';}
  $options=$options.'\';';
  echo($options); */
                   
                  
     $total=count($personarankingagente);
   
  $options='document.getElementById("idpersonarankingagente").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$personarankingagente[$i]->personaRankingAgente.'" >'.$personarankingagente[$i]->personaRankingAgente.'</option>';}
  $options=$options.'\';';
  echo($options);



     $total=count($bancos);
  $options='document.getElementById("idBanco").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$bancos[$i]->idBanco.'">'.$bancos[$i]->descripcionBancos.'</option>';}
  $options=$options.'\';';
  echo($options);
//Modificacion MJ
     $total=count($agentesEnEspera);
  $options='<table id="tableEspera" class="table table-hover table-bordered" style="font-size: 11px;"><thead><tr style="color:#fff;"><td>ID</td><td>Nombre</td><td>Creado</td><td>Status</td><td colspan="2" style="text-align:center;"><i class="fa fa-cogs"></i></td></tr></thead>';
  $selectOptions="<option></option>";
  $usuarioCreacion="";//$agentesEnEspera[0]->userEmailCreacion;
  for($i=0;$i<$total;$i++){
    if($usuarioCreacion!=$agentesEnEspera[$i]->userEmailCreacion){
      $selectOptions=$selectOptions.'<option>'.$agentesEnEspera[$i]->userEmailCreacion.'</option>';}
      $options=$options.'<tr>';
    $options=$options.'<td>'.$agentesEnEspera[$i]->idPersona.'</td><td>'.$agentesEnEspera[$i]->nombres." ".$agentesEnEspera[$i]->apellidoPaterno.' '.$agentesEnEspera[$i]->apellidoMaterno.'</td><td>'.$agentesEnEspera[$i]->userEmailCreacion.'</td><td>'.$agentesEnEspera[$i]->EstadoV3.'</td>';
   $usuarioCreacion=$agentesEnEspera[$i]->userEmailCreacion;  
    $options=$options.'<td><button class="btn btn-xs btn-primary" onclick="agregar_agente_en_espera()"><i class="fa fa-plus-circle"></i>&nbsp;Agregar</button></td><td><button class="btn btn-xs btn-danger" style="color:#fff;" onclick="eliminar_agente_en_espera()"><i class="fa fa-times-circle"></i>&nbsp;Eliminar</button></td><tr>'; 

  }
     // $divOption='document.getElementById("agentesEnEspera").innerHTML=\''.$options;
     // 
    $selectOptions=""; 
         foreach ($coordinadores as  $value) {
    $selectOptions.='<option value="'.$value->email.'">'.$value->email.'</option>';
  }
  $options='<select id="selectEspera" name="selectEspera" onchange="filtroTablaGenerico(this,tableEspera)">'.$selectOptions.'</select>'.$options.'</table>\';';

  $options='document.getElementById("agentesEnEspera").innerHTML=\''.'<span sytle="font-size: 14px;">Filtro por: <strong>creado por</strong></span>'.$options;

  echo($options);

     $total=count($agentesTemporales);




  $options='document.getElementById("idPersonas").innerHTML=\'';
  $filtroCreacion=array();$baneado="";
$rowTabla="";
$rowTabla='document.getElementById(\'divContenedorTabla\').innerHTML=\'<div style="height:350px;width:100%;overflow-y:hidden;"><table style="width: 100px;"class="table-cebra" border="1" id="tableCabeceraEstatica"><thead><tr style="height:30px;"><th><div class="divTD">NOMBRE</div></th><th><div class="divTD">SUCURSAL</div></th><th><div class="divTD">CANAL</div></th><th><div class="divTD">TIPO AGENTE / AREA</div></th><th><div class="divTD">RANKING</div></th><th><div class="divTD">EMAIL</div></th><th><div class="divTD">USUARIO CREACION</div></th></tr>';
if(isset($quitarFiltroActivo)){$rowTabla.='<tr><th colspan="7">Filtrar Baneados<input type="checkbox" onclick="filtrarSoloBaneados(this)"></th></tr>';}
$rowTabla.='</thead>';
$rowTabla.='<tbody style="height:300px">';
  for($i=0;$i<$total;$i++){

    $area = $agentesTemporales[$i]->tipoPersona == 1 ? $agentesTemporales[$i]->colaboradorArea : "Comercial";
    $typePerson = $agentesTemporales[$i]->tipoPersona == 1 ? "Colaborador" : "Agente";
    $baneado="";
    if($agentesTemporales[$i]->activated==0){$baneado="bg-danger";}
    $nombreAgente=$agentesTemporales[$i]->nombres.' '.$agentesTemporales[$i]->apellidoPaterno.' '.$agentesTemporales[$i]->apellidoMaterno;
    $options=$options.'<option  value="'.$agentesTemporales[$i]->idPersona.'">'.$agentesTemporales[$i]->nombres.' '.$agentesTemporales[$i]->apellidoPaterno.' '.$agentesTemporales[$i]->apellidoMaterno.'</option>';
    $rowTabla=$rowTabla.'<tr onclick="escogeAgente(this)" class="trPersona '.$baneado.'" data-agentenuevo="'.$agentesTemporales[$i]->esAgenteNuevo.'" data-nombreagente="'.$nombreAgente.'" data-idpersona="'.$agentesTemporales[$i]->idPersona.'" data-tipopersona="'.$agentesTemporales[$i]->tipoPersona.'" data-userCreacion="'.$agentesTemporales[$i]->userEmailCreacion.'">';
    
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$nombreAgente.'<div><button class="btn-primary" onclick="mandaMiInfo(this,\\\''.$agentesTemporales[$i]->email.'\\\','.$agentesTemporales[$i]->idPersona.')">Ir MiInfo</button></div>  </div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->sucursal.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->nombreTitulo.'</div></td>';
   
    //if($agentesTemporales[$i]->esAgenteColaborador==0){
       //$rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->personaTipoAgente.'</div></td>';
    //}else{
      $rowTabla=$rowTabla.'<td><div class="divTD"> <div class="col-md-12">'.$typePerson.' /</div> <div class="col-md-12">'.$area.'</div> </div></td>'; //$agentesTemporales[$i]->colaboradorArea
    //}
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->ranking.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->email.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->userEmailCreacion.'</div></td>'; 
    // $rowTabla=$rowTabla.'<td><div class="divTD"><button class="btn-primary" onclick="mandaMiInfo(this,\\\''.$agentesTemporales[$i]->email.'\\\','.$agentesTemporales[$i]->idPersona.')">Ir MiInfo</button></div></td>';   
    $rowTabla=$rowTabla.'</tr>';    
    $filtroCreacion[$agentesTemporales[$i]->userEmailCreacion]=$agentesTemporales[$i]->nombres;
   
}

$options=$options.'\';';
  //echo($options);
 $rowTabla.='</tbody></table>';
  $rowTabla=$rowTabla.'\';';
  echo($rowTabla);


  $options="";
  $option0="<option value=todos>Todos</option>";
  
  #foreach ($filtroCreacion as $key => $value) {$options=$options.'<option value="'.$key.'">'.$key.'</option>';}
   foreach ($coordinadores as  $value) {
    $options=$options.'<option value="'.$value->email.'">'.$value->nombres.' '.$value->apellidoPaterno.' ('.$value->email.')</option>';
  }
  echo('document.getElementById(\'selectFiltroCreador\').innerHTML=\''.$options.'\';'); 
  /*if($this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM"){
  echo('document.getElementById(\'cuentasACargo\').innerHTML=\''.$option0.''.$options.'\';');
  //echo ("<select name='cuentasACargo' id='cuentasACargo'>".$options."</select>");
} */ //cuentasACargo //[Dennis 2020-04-29]

     $total=count($catalogoHonorarios);
  $options='document.getElementById("honorariosCVH").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$catalogoHonorarios[$i]->idCVH.'">'.$catalogoHonorarios[$i]->comisionCVH.'</option>';}
  $options=$options.'\';';
  echo($options);

  $total=count($IDVendNS);
  $options='document.getElementById("IDVendNS").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$IDVendNS[$i]->IDVend.'">'.$IDVendNS[$i]->NombreCompleto.'</option>';}
  $options=$options.'\';';
  echo($options);


  ?>
   <?php 
   function  devolverSelect($datos,$id,$descripcion)
   { $opciones="";

   foreach ($datos as  $key =>$value) {$opciones=$opciones.'<option value="'.$value->$id.'">'.$value->$descripcion.'</option>';}
   return $opciones;
  }
 ?>
    
    

<?php 
/*DATOS SE CARGAN AL BUSCAR AGENTE*/
if(isset($datosAgente)){
 
  if($tipoPersona==3 || $tipoPersona==4){


    $promotoriasActivadas=explode(";",$datosAgente->promotoriasActivadasCP );


    foreach ($promotoriasActivadas as $value) {
    if($value!=""){
    echo('document.getElementById("promotoria'.$value.'").checked=true;');  }
    }
   

	  $total=count($target);$cont=count($targetPersona);
  if($cont>0){
  $options='document.getElementById("targetPersona").innerHTML=\'<table border="2">';
  for($i=0;$i<$total;$i++){
  $band=0;
    for($j=0;$j<$cont;$j++){
     if($target[$i]->idTarget==$targetPersona[$j]->idTarget){$band=1;$band=$cont;}
    }
   if($band==0){                                                                     
  	$options=$options.'<tr class="'.$target[$i]->claseFilaTarget.'"><td><input class="ResponsivoDiv Responsivo lbEtiqueta " type="checkbox" disabled="true" ></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta ajustaAltura" >'.$target[$i]->descripcionTarget.'</label></td></tr>';}
  	else{$options=$options.'<tr class="'.$target[$i]->claseFilaTarget.'"><td><input class="Responsivo lbEtiqueta " type="checkbox"  disabled="true" checked></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta ajustaAltura" >'.$target[$i]->descripcionTarget.'</label></td></tr>';}
  }
  $options=$options.'</table><form method="POST" action="'.base_url().'persona/recibeTarget"><input type="submit" id="btnTargetPersona" value="PDF"><input name="idPersonas" type="hidden" id="inputTargetPersona" value="'.$datosAgente->idPersona.'"></form>\';';
  echo($options);
 }
  else{
  $options='document.getElementById("targetPersona").innerHTML=\'<form id="miForm" method="POST" action="'.base_url().'persona/guardaTarget"><table border="2">';
  for($i=0;$i<$total;$i++){
  	$options=$options.'<tr class="'.$target[$i]->claseFilaTarget.'"><td><input class="ResponsivoDiv Responsivo lbEtiqueta"  type="checkbox" name="target[]" value="'.$target[$i]->idTarget.'" ></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta ajustaAltura">'.$target[$i]->descripcionTarget.'</label></td></tr>';
  }
  $options=$options.'</table><input type="hidden" id="inputTargetPersona" value="'.$datosAgente->idPersona.'" name="idPersonaTarget"><input type="submit"  id="btnTargetPersona"value="Enviar"></form>\';';

  echo($options);
  }
 
 /*$total=count($documentosFormato);
 $totalSubidos=count($documentosSubidos);
 $options='document.getElementById("documentosPersona").innerHTML=\'<table style="width:auto; height:auto" border="2">';
 
 for($i=0;$i<$total;$i++){
$band=0;
$descripcionPD="";
$extensionPDG="";
 for($j=0;$j<$totalSubidos;$j++){
 	if($documentosFormato[$i]->idPersonaDocumento==$documentosSubidos[$j]->idPersonaDocumento){$band=1;$descripcionPD=$documentosSubidos[$j]->descripcionPD;$extensionPDG=$documentosSubidos[$j]->extensionPDG;$j=$totalSubidos;}
 }
 
if($band){
	$options=$options.'<tr class="'.$documentosFormato[$i]->classFilaPD.'"><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.($i+1).'</label></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.$documentosFormato[$i]->textoPD.'</label></td><td><a href="'.base_url().'archivosPersona/'.$datosAgente->idPersona.'/'.$descripcionPD.'.'.$extensionPDG.'">Descargar</a></td><td><form method="POST" enctype="multipart/form-data" action="'.base_url().'persona/guardaDocumento" id="formDocumento'.$i.'"><input type="hidden" name="idPersona" value="'.$datosAgente->idPersona.'"><input type="hidden" name="idPersonaDocumento" value="'.$documentosFormato[$i]->idPersonaDocumento.'"><input type="hidden" name="layoutPD" value="'.$documentosFormato[$i]->layoutPD.'"><input class="ResponsivoDiv Responsivo lbEtiqueta" name="documento"  type="file" value="Agregar" onchange="if(!this.value.length)return false;this.parentNode.submit();" style="witdh:30px"></form></td></tr>';

}else{
 $options=$options.'<tr class="'.$documentosFormato[$i]->classFilaPD.'"><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.($i+1).'</label></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.$documentosFormato[$i]->textoPD.'</label></td><td></td><td><form method="POST" enctype="multipart/form-data" action="'.base_url().'persona/guardaDocumento" id="formDocumento'.$i.'"><input type="hidden" name="idPersona" value="'.$datosAgente->idPersona.'"><input type="hidden" name="idPersonaDocumento" value="'.$documentosFormato[$i]->idPersonaDocumento.'"><input type="hidden" name="layoutPD" value="'.$documentosFormato[$i]->layoutPD.'"><input class="ResponsivoDiv Responsivo lbEtiqueta" name="documento"  type="file" value="Agregar" onchange="if(!this.value.length)return false;this.parentNode.submit();" style="witdh:30px"></form></td></tr>';
}

 }
$options=$options.'</table>\';';
echo($options);*/
if($camposObligatorios==1){
$options='document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente"><button class="objetosResponsivos  btn-primary" id="btnPasarAgente" >Permiso CAPSY</button> \';'	;
echo($options);
}?>
document.getElementById('cotizasAcciEnferm').value="<?php echo($datosAgente->cotizasAcciEnferm); ?>";
document.getElementById('cotizaDanios').value="<?php echo($datosAgente->cotizaDanios); ?>";
document.getElementById('cotizaFianzas').value="<?php echo($datosAgente->cotizaFianzas); ?>";
document.getElementById('cotizaVehiculos').value="<?php echo($datosAgente->cotizaVehiculos); ?>";
document.getElementById('cotizaVida').value="<?php echo($datosAgente->cotizaVida); ?>";
document.getElementById('recabarInfo').value="<?php echo($datosAgente->permisosAgentes['recabarInfo']); ?>";
document.getElementById('asesoriaProduc').value="<?php echo($datosAgente->permisosAgentes['asesoriaProduc']); ?>";
document.getElementById('cobranzaPri').value="<?php echo($datosAgente->permisosAgentes['cobranzaPri']); ?>";
document.getElementById('endoModif').value="<?php echo($datosAgente->permisosAgentes['endoModif']); ?>";

document.getElementById('honorariosCVH').value="<?php echo($datosAgente->honorariosCVH); ?>";
document.getElementById('IDVendNS').value="<?php echo($datosAgente->IDVendNS); ?>";

<?php
}

//--------------
// Dennis Castillo [2021-10-28]
$total=count($documentosFormato);
$totalSubidos=count($documentosSubidos);
$options='document.getElementById("documentosPersona").innerHTML=\'<div class="mb-4"><button class="btn btn-primary mb-4" data-toggle="collapse" data-target="#support-content" aria-expanded="false" aria-controls="support-content">Mostrar enlaces de apoyo</button><div class="collapse support-links-content border" id="support-content"></div></div> <table style="width:auto; height:auto" border="2">';
$count = 0;
for($i=0;$i<$total;$i++){
$band=0;
$count++;
$descripcionPD="";
$extensionPDG="";
for($j=0;$j<$totalSubidos;$j++){
  if($documentosFormato[$i]->idPersonaDocumento==$documentosSubidos[$j]->idPersonaDocumento){$band=1;$descripcionPD=$documentosSubidos[$j]->descripcionPD;$extensionPDG=$documentosSubidos[$j]->extensionPDG;$j=$totalSubidos;}
}

if($band){
 $options=$options.'<tr class="'.$documentosFormato[$i]->classFilaPD.'"><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.($i+1).'</label></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.$documentosFormato[$i]->textoPD.'</label></td><td><a href="'.base_url().'archivosPersona/'.$datosAgente->idPersona.'/'.$descripcionPD.'.'.$extensionPDG.'">Descargar</a></td><td><form method="POST" enctype="multipart/form-data" action="'.base_url().'persona/guardaDocumento" id="formDocumento'.$i.'"><input type="hidden" name="idPersona" value="'.$datosAgente->idPersona.'"><input type="hidden" name="idPersonaDocumento" value="'.$documentosFormato[$i]->idPersonaDocumento.'"><input type="hidden" name="layoutPD" value="'.$documentosFormato[$i]->layoutPD.'"><input class="ResponsivoDiv Responsivo lbEtiqueta" name="documento"  type="file" value="Agregar" onchange="if(!this.value.length)return false;this.parentNode.submit();" style="witdh:30px"></form></td></tr>';

}else{
$options=$options.'<tr class="'.$documentosFormato[$i]->classFilaPD.'"><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.($i+1).'</label></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.$documentosFormato[$i]->textoPD.'</label></td><td></td><td><form method="POST" enctype="multipart/form-data" action="'.base_url().'persona/guardaDocumento" id="formDocumento'.$i.'"><input type="hidden" name="idPersona" value="'.$datosAgente->idPersona.'"><input type="hidden" name="idPersonaDocumento" value="'.$documentosFormato[$i]->idPersonaDocumento.'"><input type="hidden" name="layoutPD" value="'.$documentosFormato[$i]->layoutPD.'"><input class="ResponsivoDiv Responsivo lbEtiqueta" name="documento"  type="file" value="Agregar" onchange="if(!this.value.length)return false;this.parentNode.submit();" style="witdh:30px"></form></td></tr>';
}

}
$options=$options.'<tr class="filaImportante"><td><label class="ResponsivoDiv Responsivo lbEtiqueta">'.($count+1).'</label></td><td><label class="ResponsivoDiv Responsivo lbEtiqueta">Foto de perfil cargado desde el módulo de alta de asesores capital</label></td><td colspan="2">'.(!empty($personalPhoto) ? $personalPhoto->fotoUser : "Aún sin una foto asignada").'</td></tr></table>\';';
echo($options);
//-------------

?>
/*document.getElementById('certificacion').value="<?php echo($datosAgente->certificacion); ?>";
document.getElementById('certificacionAutos').value="<?php echo($datosAgente->certificacionAutos); ?>";
document.getElementById('certificacionGmm').value="<?php echo($datosAgente->certificacionGmm); ?>";
document.getElementById('certificacionVida').value="<?php echo($datosAgente->certificacionVida); ?>";
document.getElementById('certificacionDanos').value="<?php echo($datosAgente->certificacionDanos); ?>";
document.getElementById('certificacionFianzas').value="<?php echo($datosAgente->certificacionFianzas); ?>";*/
document.getElementById('labelNombrePersona').innerHTML="<?php echo($datosAgente->nombres.' '.$datosAgente->apellidoPaterno.' '.$datosAgente->apellidoMaterno); ?>";
document.getElementById('labelNombrePersona').setAttribute("title","<?php echo($datosAgente->idPersona); ?>")
document.getElementById('idPersona').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('idPersonas').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('idPersonaHorarioGlobal').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('nombres').	value="<?php echo($datosAgente->nombres); ?>";
document.getElementById('apellidoPaterno').value="<?php echo($datosAgente->apellidoPaterno); ?>";
document.getElementById('apellidoMaterno').value="<?php echo($datosAgente->apellidoMaterno); ?>";
document.getElementById('rfc').value="<?php echo($datosAgente->rfc); ?>";
document.getElementById('fechaNacimiento').value="<?php echo($datosAgente->fechaNacimiento); ?>";
document.getElementById('estadoNacimiento').value="<?php echo($datosAgente->estadoNacimiento); ?>";
document.getElementById('municipioNacimiento').value="<?php echo($datosAgente->municipioNacimiento); ?>";
document.getElementById('paisNacimiento').value="<?php echo($datosAgente->paisNacimiento); ?>";
//document.getElementById('estadoCivil').value="<?php echo($datosAgente->estadoCivil); ?>"
//document.getElementById('escolaridad').value="<?php echo($datosAgente->escolaridad); ?>"
document.getElementById('calle').value="<?php echo($datosAgente->calle); ?>";
document.getElementById('cruzamiento').value="<?php echo($datosAgente->cruzamiento); ?>";
document.getElementById('colonia').value="<?php echo($datosAgente->colonia); ?>";
document.getElementById('numero').value="<?php echo($datosAgente->numero); ?>";
document.getElementById('codigoPostal').value="<?php echo($datosAgente->codigoPostal); ?>";
document.getElementById('estadoDomicilio').value="<?php echo($datosAgente->estadoDomicilio); ?>";
document.getElementById('municipioDomicilio').value="<?php echo($datosAgente->municipioDomicilio); ?>";
document.getElementById('paisDomicilio').value="<?php echo($datosAgente->paisDomicilio); ?>";
document.getElementById('telCasa').value="<?php echo($datosAgente->telCasa); ?>";
document.getElementById('telOficina').value="<?php echo($datosAgente->telOficina); ?>";
document.getElementById('telOficinaExtension').value="<?php echo($datosAgente->telOficinaExtension); ?>";
document.getElementById('celPersonal').value="<?php echo($datosAgente->celPersonal); ?>";
document.getElementById('celOficina').value="<?php echo($datosAgente->celOficina); ?>";
document.getElementById('emailPersonal').value="<?php echo($datosAgente->emailPersonal); ?>";
document.getElementById('accidtePersonaAvisa').value="<?php echo($datosAgente->accidtePersonaAvisa); ?>";
document.getElementById('telPersonaAvisa').value="<?php echo($datosAgente->telPersonaAvisa); ?>";
document.getElementById('recomendarPersona').value="<?php echo($datosAgente->recomendarPersona); ?>";
document.getElementById('referenciaPersona').value="<?php echo($datosAgente->referenciaPersona); ?>";
document.getElementById('imssPersona').value="<?php echo($datosAgente->imssPersona); ?>";
document.getElementById('hijosPersona').value="<?php echo($datosAgente->hijosPersona); ?>";
document.getElementById('gastoMenPersona').value="<?php echo($datosAgente->gastoMenPersona); ?>";
document.getElementById('metaPersona').value="<?php echo($datosAgente->metaPersona); ?>";
document.getElementById('comidaFavPersona').value="<?php echo($datosAgente->comidaFavPersona); ?>";
document.getElementById('colorFavPersona').value="<?php echo($datosAgente->colorFavPersona); ?>";
document.getElementById('pasatiempoFavPersona').value="<?php echo($datosAgente->pasatiempoFavPersona); ?>";
document.getElementById('clubSocialPersona').value="<?php echo($datosAgente->clubSocialPersona); ?>";
document.getElementById('personaTipoAgente').value="<?php echo($datosAgente->personaTipoAgente); ?>";
document.getElementById('idModalidad').value="<?php echo($datosAgente->idModalidad); ?>"; //[Dennis 2020-03-31]
document.getElementById('idPasarAgente').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('cedulaPersona').value="<?php echo($datosAgente->cedulaPersona); ?>";
document.getElementById('idPersonaCaratula').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('idBanco').value="<?php echo($datosAgente->idBanco); ?>";
document.getElementById('claveBancoPersona').value="<?php echo($datosAgente->claveBancoPersona); ?>";
document.getElementById('cuentaBancoPersona').value="<?php echo($datosAgente->cuentaBancoPersona); ?>";
document.getElementById('tipoCuentaBancoPersona').value="<?php echo($datosAgente->tipoCuentaBancoPersona); ?>";
document.getElementById('fecIniCedulaPersona').value="<?php echo($datosAgente->fecIniCedulaPersona); ?>";
document.getElementById('fecFinCedulaPersona').value="<?php echo($datosAgente->fecFinCedulaPersona); ?>";
document.getElementById('PRCAgentePersona').value="<?php echo($datosAgente->PRCAgentePersona); ?>";
document.getElementById('fecIniPRCAgentePersona').value="<?php echo($datosAgente->fecIniPRCAgentePersona); ?>";
document.getElementById('fecFinPRCAgentePersona').value="<?php echo($datosAgente->fecFinPRCAgentePersona); ?>";
document.getElementById('curpPersona').value="<?php echo($datosAgente->curpPersona); ?>";
document.getElementById('PRCCompaniaAgentePersona').value="<?php echo($datosAgente->PRCCompaniaAgentePersona); ?>";
document.getElementById('tipoCedulaAgentePersona').value="<?php echo($datosAgente->tipoCedulaAgentePersona); ?>";
document.getElementById('beneficiarioPersona').value="<?php echo($datosAgente->beneficiarioPersona); ?>";
//document.getElementById('id_catalog_canales').value="<?php echo($datosAgente->id_catalog_canales); ?>";
document.getElementById('idpersonarankingagente').value="<?php echo($datosAgente->idpersonarankingagente); ?>";
document.getElementById('id_catalog_sucursales').value="<?php echo($datosAgente->id_catalog_sucursales); ?>";
document.getElementById('banned').value="<?php echo($datosAgente->banned); ?>";
document.getElementById('UsuarioCarCapital').value="<?php echo($datosAgente->UsuarioCarCapital); ?>";
//document.getElementById('vehiculoPersona').value="<?php echo($datosAgente->vehiculoPersona); ?>";
document.getElementById('fecAltaSistemPersona').value= "<?php echo($datosAgente->fecAltaSistemPersona); ?>";
//Miguel Jaime 18-11-2021
document.getElementById('nombreMama').value="<?php echo($datosAgente->nombreMama); ?>";
document.getElementById('edadMama').value="<?php echo($datosAgente->edadMama); ?>";
document.getElementById('nombrePapa').value="<?php echo($datosAgente->nombrePapa); ?>";
document.getElementById('edadPapa').value="<?php echo($datosAgente->edadPapa); ?>";
document.getElementById('nombreEsposo').value="<?php echo($datosAgente->nombreEsposo); ?>";
document.getElementById('edadEsposo').value="<?php echo($datosAgente->edadEsposo); ?>";
//document.getElementById('sexo').value="<?php echo($datosAgente->sexo); ?>";
//document.getElementById('ingles').value="<?php echo($datosAgente->ingles); ?>";
//document.getElementById('postgrado').value="<?php echo($datosAgente->postgrado); ?>";
if(document.getElementById('viajar')){document.getElementById('viajar').value="<?php echo($datosAgente->viajar); ?>";}
//document.getElementById('herramientas_office').value="<?php echo($datosAgente->herramientas_office); ?>";
if(document.getElementById('experiencia')){document.getElementById('experiencia').value="<?php echo($datosAgente->experiencia); ?>";} 

//Dennis Castillo [2022-04-21]
document.getElementById('sueldoPercibido').value="<?php echo($datosAgente->sueldoPercibido); ?>";
document.getElementById('fondoAhorro').value="<?php echo($datosAgente->fondoAhorro); ?>";
document.getElementById('contrato').value="<?php echo($datosAgente->contrato); ?>";
if(document.getElementById('escolar')){document.getElementById('escolar').value="<?php echo($datosAgente->escolar); ?>";}
if(document.getElementById('habilidadDecision')){document.getElementById('habilidadDecision').value="<?php echo($datosAgente->habilidadDecision); ?>";}
if(document.getElementById('habilidadPersonal')){document.getElementById('habilidadPersonal').value="<?php echo($datosAgente->habilidadPersonal); ?>";}
if(document.getElementById('habilidadAdministrativa')){document.getElementById('habilidadAdministrativa').value="<?php echo($datosAgente->habilidadAdministrativa); ?>";}
if(document.getElementById('psicometria')){document.getElementById('psicometria').value="<?php echo($datosAgente->psicometria); ?>";}
if(document.getElementById('valorOrganizacional')){document.getElementById('valorOrganizacional').value="<?php echo($datosAgente->valorOrganizacional); ?>";}
if(document.getElementById('experienciaLaboral')){document.getElementById('experienciaLaboral').value="<?php echo($datosAgente->experienciaLaboral); ?>";}
if(document.getElementById('habilidades')){document.getElementById('habilidades').value="<?php echo($datosAgente->habilidades); ?>";}
if(document.getElementById('competencias')){document.getElementById('competencias').value="<?php echo($datosAgente->competencias); ?>";}
if(document.getElementById('aliadoCarCapital')){document.getElementById('aliadoCarCapital').value="<?php echo($datosAgente->aliadoCarCapital); ?>";}

//[Dennis 2020-04-15]
//detectarSelect=document.getElementById('personaTipoAgente');
//if(detectarSelect.length==0){ //$agenteActual
  //detectarSelect.innerHTML="<option value="+<?php echo($datosAgente->personaTipoAgente);?>+"><?= $datosAgente->personTipoAgenteNombre?></option>";
//}

detectarCanal=document.getElementById('id_catalog_canales');
if(detectarCanal.length==0){
  detectarCanal.innerHTML="<option value="+<?php echo($datosAgente->id_catalog_canales);?>+"><?= $datosAgente->canalNombre?></option>";
}

document.getElementById('CodeAuthPersonaSicas').value="<?php echo($datosAgente->CodeAuthPersonaSicas); ?>";
document.getElementById('CodeAuthUserPersonaSicas').value="<?php echo($datosAgente->CodeAuthUserPersonaSicas); ?>";
document.getElementById('fecInicioBaneo').value="<?php echo($datosAgente->fecInicioBaneo); ?>";
document.getElementById('IDValida').innerHTML="<?php echo($datosAgente->IDValida); ?>";
document.getElementById('tipoPersona').value="<?php echo($datosAgente->tipoPersona); ?>";
if(document.getElementById('idPersonaPuesto')){document.getElementById('idPersonaPuesto').value="<?php echo($datosAgente->idPersonaPuesto); ?>";}
//if(document.getElementById('tipoPersona')){document.getElementById('tipoPersona').value="<?php echo($datosAgente->tipoPersona); ?>";}




<?php

}
?>
function nuevoAgente(){
  event.preventDefault();
 document.getElementById('nombres').value="";
 document.getElementById('apellidoPaterno').value="";
 document.getElementById('apellidoMaterno').value="";
 document.getElementById('rfc').value="";
 document.getElementById('fechaNacimiento').value="";
 document.getElementById('estadoNacimiento').value="";
 document.getElementById('municipioNacimiento').value="";
 document.getElementById('paisNacimiento').value="";
 document.getElementById('calle').value="";
 document.getElementById('cruzamiento').value="";
 document.getElementById('colonia').value="";
 document.getElementById('numero').value="";
 document.getElementById('codigoPostal').value="";
 document.getElementById('estadoDomicilio').value="";
 document.getElementById('municipioDomicilio').value="";
 document.getElementById('paisDomicilio').value="";
 document.getElementById('telCasa').value="";
 document.getElementById('telOficina').value="";
 document.getElementById('celPersonal').value="";
 document.getElementById('celOficina').value="";
 document.getElementById('emailPersonal').value="";
 document.getElementById('accidtePersonaAvisa').value="";
 document.getElementById('telPersonaAvisa').value="";
 document.getElementById('recomendarPersona').value="";
 document.getElementById('referenciaPersona').value="";
 document.getElementById('imssPersona').value="";
 document.getElementById('gastoMenPersona').value="";
 document.getElementById('metaPersona').value="";
 document.getElementById('comidaFavPersona').value="";
 document.getElementById('colorFavPersona').value="";
 document.getElementById('pasatiempoFavPersona').value="";
 document.getElementById('clubSocialPersona').value="";
 document.getElementById('cotizasAcciEnferm').value="NO";
 document.getElementById('cotizaDanios').value="NO";
 document.getElementById('cotizaFianzas').value="NO";
 document.getElementById('cotizaVehiculos').value="NO";
 document.getElementById('cotizaVida').value="NO";
 document.getElementById('cedulaPersona').value="";
 document.getElementById('recabarInfo').value=0;
 document.getElementById('asesoriaProduc').value=-1;
 document.getElementById('cobranzaPri').value=-1;
 document.getElementById('endoModif').value=-1;
 document.getElementById('idPersona').value=0;
 document.getElementById('idPersonas').value="";
 document.getElementById('targetPersona').innerHTML="";
 document.getElementById('documentosPersona').innerHTML="";	
 document.getElementById('idPersonaPuesto').value=0;  
 document.getElementById('tipoPersona').value = ""; 
 document.getElementById('aliadoCarCapital').value = 0;
//Miguel Jaime 18-11-2021
document.getElementById('nombreMama').value = ""; 
document.getElementById('edadMama').value = ""; 
document.getElementById('nombrePapa').value = ""; 
document.getElementById('edadPapa').value = ""; 
document.getElementById('nombreEsposo').value = ""; 
document.getElementById('edadEsposo').value = "";
//document.getElementById('sexo').value = 0;


 obtieneElementosTag(false);


}
function configParaNuevos(){
document.getElementById('idPersona').value=0;
document.getElementById('idPersonas').value="";
document.getElementById('targetPersona').innerHTML="";
document.getElementById('documentosPersona').innerHTML="";
}


function borrarNodosText(elemento){
  for(var i=0;i<document.getElementById(elemento).childNodes.length;i++){if(document.getElementById(elemento).childNodes[i].nodeName=="#text"){document.getElementById(elemento).removeChild(document.getElementById(elemento).childNodes[i]);}}}

<?php
/*==============CONFIGURA ALGUNOS PARAMETROS SI ES COORDINADOR, AGENTE O MASTER==============*/
  //echo('document.getElementById("divReportes").innerHTML="<button onclick=\'enviarFormGenerales(4)\' class=\'btn\'>Exportar Agentes</button>";');
 
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'  ){

$crearSicas='\'<button class="btn btn-primary" onclick="nuevoAgente(this)"><i class="fa fa-plus-circle"></i> Nuevo</button>\';';
$accesoASicas = '\'<button class="btn btn-primary" onclick="enviarFormGenerales(3)" onclick="">Alta en Sicas</button>\';';
 if(isset($datosAgente)){
echo('document.getElementById("divUsuarioPersona").innerHTML=\'<div><input class="formEnviar" style="width: 300px" type="text" id="usuarioPersona" name="usuarioPersona" value="'.$datosAgente->emailUsuario.'"></div>\';');
echo('document.getElementById("divPasswordPersona").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="usuarioPassword" name="usuarioPassword" value="'.$datosAgente->passwordUsuario.'">\';');
echo('document.getElementById("divIdVendedor").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="IDVend" name="IDVend" value="'.$datosAgente->IDVend.'">\';');

if($datosAgente->IDVend==0){
  //$crearSicas='\'<button class="btn btn-primary" onclick="nuevoAgente(this)"><i class="fa fa-plus-circle"></i> Nuevo</button><p>'.'<button class="btn btn-primary" onclick="enviarFormGenerales(3)" onclick="">Alta en Sicas</button>\';';
  $crearSicas='\'<button class="btn btn-primary" onclick="nuevoAgente(this)"><i class="fa fa-plus-circle"></i> Nuevo</button>\';';
  $accesoASicas = '\'<button class="btn btn-primary" onclick="enviarFormGenerales(3)" onclick="">Alta en Sicas</button>\';';
}
//else{$crearSicas='\'<button class="objetosResponsivos  btn-primary" onclick="nuevoAgente(this)">Nuevo</button>\';';}
echo('document.getElementById("divNuevaPersona").innerHTML='.$crearSicas);
echo('document.getElementById("divNuevaPersonaSicas").innerHTML='.$accesoASicas);
//echo('document.getElementById("divNuevaPersona").innerHTML='.$crearSicas);
      echo('document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente" value="'.$datosAgente->idPersona.'"><button class="objetosResponsivos  btn-primary" id="btnPasarAgente" onclick="validadorArchivos()">Permiso CAPSY</button> \';'); //[Dennis 2020-04-02]

}
  else{
echo('document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente">\';');
echo('document.getElementById("divNuevaPersona").innerHTML='.$crearSicas);

 }
echo('function obtieneElementosTag(modo){
     // if(event){event.preventDefault();}  
      var elementos=document.getElementsByTagName("input");
var cont=elementos.length;
for(var i=0;i<cont;i++){
  
  if(elementos[i].type!="checkbox" && elementos[i].type!="file" && elementos[i].type!="hidden"){
  elementos[i].disabled=modo;}
}
document.getElementById("editarHorario").disabled=modo;
var elementos=document.getElementsByTagName("select");
var cont=elementos.length;
for(var i=0;i<cont;i++){
  if(elementos[i].name!="idPersonas" &&  elementos[i].name!="selectFiltroCreador" &&  elementos[i].name!="selectEspera")
  elementos[i].disabled=modo;
}
if(document.getElementById("tipoPersona").value == 3){
  document.getElementById("contrato").disabled=true;
  document.getElementById("sueldoPercibido").disabled=true; //fondoAhorro
  document.getElementById("fondoAhorro").disabled=true;
}
if(document.getElementById("idPersonas").value!=-1){

 }
}');
}
else
  {

    echo('document.getElementById("divNuevaPersona").innerHTML=\'<button class="objetosResponsivos  btn-primary" id="buttonNuevoAgente" onclick="nuevoAgente(this)">Nuevo</button>\';'); 
   if(isset($datosAgente)){
    echo('document.getElementById("divUsuarioPersona").innerHTML=\'<label class="Responsivo lbEtiqueta lbEtiquetaMa901" >'.$datosAgente->emailUsuario.'</label>\';');
    echo('document.getElementById("divPasswordPersona").innerHTML=\'<label class="Responsivo lbEtiqueta lbEtiquetaMa901" >'.$datosAgente->passwordUsuario.'</label>\';');
      echo('document.getElementById("divIdVendedor").innerHTML=\'<label class="Responsivo lbEtiqueta lbEtiquetaMa901" >'.$datosAgente->IDVend.'</label>\';');
     }
echo('function obtieneElementosTag(modo){
  //if(event){event.preventDefault();}
var elementos=document.getElementsByTagName("input");var cont=elementos.length;
for(var i=0;i<cont;i++){
  if(elementos[i].type!="checkbox" && elementos[i].type!="file" && elementos[i].type!="hidden"){
  elementos[i].disabled=modo;}
}
document.getElementById("editarHorario").disabled=modo;
if(document.getElementById("tipoPersona").value == 3){
  document.getElementById("contrato").disabled=true;
  document.getElementById("sueldoPercibido").disabled=true; //fondoAhorro
  document.getElementById("fondoAhorro").disabled=true;
}
var elementos=document.getElementsByTagName("select");var cont=elementos.length;
for(var i=0;i<cont;i++){if(elementos[i].name!="idPersonas" &&  elementos[i].name!="selectFiltroCreador"  &&  elementos[i].name!="selectEspera"  )elementos[i].disabled=modo;}
if(document.getElementById("idPersonas").value!=-1){
document.getElementById("idPersonaCaratula").disabled=false;
document.getElementById("submitIdPersonaCaratula").disabled=false;
document.getElementById("idPasarAgente").disabled=false;
if(document.getElementById("inputTargetPersona"))document.getElementById("inputTargetPersona").disabled=false;
if(document.getElementById("btnTargetPersona"))document.getElementById("btnTargetPersona").disabled=false;
document.getElementById("personaTipoAgente").disabled=false;
document.getElementById("id_catalog_sucursales").disabled=false;
document.getElementById("txtBuscarFiltro").disabled=false;
document.getElementById("id_catalog_canales").disabled=true;
document.getElementById("idpersonarankingagente").disabled=true;
document.getElementById("banned").disabled=true;
document.getElementById("UsuarioCarCapital").disabled=true;
document.getElementById("CodeAuthPersonaSicas").disabled=true;
document.getElementById("CodeAuthUserPersonaSicas").disabled=true;
document.getElementById("IDVendNS").disabled=true;


 }
}');
  }
?>
/*===========================================================================================*/

obtieneElementosTag(true);
<?php 

 if(isset($mensajePersona)){echo $mensajePersona;}  	 ?>


 <?php //[Dennis 2020-04-04]
 //Cuando cargué la página de alta de agentes, inicializa estas variables a cero para la funcion: function validadorArchivos().
  if(empty($obtenerArchivosObligatorios) && empty($datosAgente) && empty($docObligatorios)){
    $obtenerArchivosObligatorios=0;
    $datosAgente=0;
    $docObligatorios=0;
  }
 ?>


function direccionAJAX(opcion,id){

  var direccionAJAX="<?php echo(base_url().'persona/');?>";
  switch(opcion){
     case 'ventanaImagenes':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=0"; break;
     case 'ventanaImagenPersonal':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=1"; break;
    case 'borraImagenCurso':direccionAJAX=direccionAJAX+'verImagenesPersona/?idPersona='+document.getElementById('idPersonas').value+"&tipoVentana=2&idImagen="+id; document.getElementById("btnCerrarVentana").onclick(); break;
  } 

  conectaAJAX(direccionAJAX);
}

function conectaAJAX(direccionAJAX){
  var req = new XMLHttpRequest();
  req.open('GET',direccionAJAX, true);
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {
      if (document.getElementById("divVentanaImagenes")){document.body.removeChild(document.getElementById('divVentanaComentarios'));}
      if(document.getElementById("divVentanaImagenesEstilo")){document.head.removeChild(document.getElementById('divVentanaComentarioEstilo'));}
       var j=JSON.parse(this.responseText);
       var hoja = document.createElement('style');hoja.id="divVentanaImagenesEstilo";
       document.head.appendChild(hoja);                   
       var div=document.createElement('div');div.id="divVentanaImagenes";div.innerHTML=j["datos"];
       hoja.type="text/css";
       hoja.innerHTML=j['estilo'];
       document.body.appendChild(div);
       document.getElementById("divVentanaImagenes").classList.add('divVentanaImagenesEstilo');                                                     
      }     
   }
  };
 req.send();
}


</script>

<script type="text/javascript">
$(function () {$(".fechaPersona").datepicker({
  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  firstDay: 1,       
});
});



 function moverScroll(){
   var elmnt = document.getElementById("scrollTabla");
    var x = elmnt.scrollLeft;
document.getElementById("scrollCabecera").scrollLeft=x;
}

//-----------------------------------------------------------------------------
//[Dennis 2020-03-30]
function segmentarTipoAgente(){
  
  var idModalidad= $("#idModalidad").val();
  $.ajax({
    type:"POST",
    url:<?php echo('"'.base_url().'persona/obtieneTipoAgente"'); ?>,
    data:{"tipoModalidad":idModalidad},
    error: function(){},
    success: function(data){
      //$('#personaTipoAgente').html(data);
      $('#personaTipoAgente').html(`
      <option value=''>Seleccione</option>
      `+data);
    }
  });
}
//[Dennis 2020-04-14]
 $('#personaTipoAgente').on('change', function(){

   var selectAgente=$('#personaTipoAgente').val();
   $.ajax({
    type:"POST",
    url:<?php echo('"'.base_url().'persona/obtieneTipoCanal"'); ?>,
    data:{"tipoAgente":selectAgente},
    error: function(){},
    success: function(data){

      $('#id_catalog_canales').html(`
      <option value=''>Seleccione</option>
      `+data);
    }
  });
 })

//[Dennis 2020-04-01]
function validadorArchivos(){
  var archivosObligatorios=<?php if(empty($obtenerArchivosObligatorios)){echo $obtenerArchivosObligatorios=0;}else{ echo json_encode($obtenerArchivosObligatorios);}?>;
  var tipoAgente=<?php echo json_encode($datosAgente);?>;
  var docObligatorio=<?php if(empty($docObligatorios)){$docObligatorios=0; echo $docObligatorios;}else{echo json_encode($docObligatorios);}?>;
    switch(tipoAgente.personaTipoAgente){
      case "4": if(archivosObligatorios.length>=2){document.getElementById("btnPasarAgente").disabled=false;}
                else{alert('Peticion rechazada. El usuario cuenta con '+archivosObligatorios.length+' de '+docObligatorio.length+' archivos obligatorios');
                  document.getElementById("btnPasarAgente").disabled=true;}
          break;
      case "3": //Misma condición de case:2 minimo un archivo obligatorio.
      case "2": if(archivosObligatorios.length>0){document.getElementById("btnPasarAgente").disabled=false;}
                else{alert('Peticion rechazada. El usuario no cuenta con los archivos obligatorios. Se requiere minimo 1 archivo');
                  document.getElementById("btnPasarAgente").disabled=true;}
          break;
          }
}

//[Dennis aquiSe]

//carga de horas de capacitación.
var botonCapa=document.getElementById("actualizarCapa");
var formu=document.getElementById("capaForm");
var opcionCapa=document.getElementById("opcionesCarga");

function enviaCapa(e){
  var contador=0;
  var inputText=0;
  e.preventDefault();
  $("input[type=checkbox]").each(function(){
    if($(this).is(":checked")){
      contador++;}
  });


  $("input[type=number]").each(function(){
    if($(this).val().length!=0){
      inputText++;}
  });


  if(contador>0){
    if(inputText>0){
  $.ajax({
    type:"POST",
    url:"<?php echo base_url()."persona/ingresaCapacitacion";?>",
    data: $("#capaForm").serialize(),
    error: function(){
      alert("No se envio");
    },
    success: function(data){
      
      alert("Datos enviados");
      $('.capacitacion').modal('hide');
      $('#capaForm')[0].reset();
    }
  });}else{
    alert("Debes llenar mínimo a un campo de horas.");
  }} else{
    alert("Debes seleccionar mínimo a un agente");
  }
}
//---------------------------------------------------------------------------------------------
$("#up_img").click(function() {$("body").append('<input type="file" name="imagen[]">');$("input[name='imagen[]']").trigger("click");});

//---------------------------------------------------------------------------------------------

</script>
<?php
/*======================================FUNCIONES ===================================================*/
function bajaTotal($datosAgente,$usuario)
{
  $cadena="";
  if($usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $usuario=='AUDITORINTERNO@AGENTECAPITAL.COM' || $usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM'){
  if($datosAgente->banned==1 && $datosAgente->IDVend > 0){ //Dennis Castillo [2022-02-22]
    $cadena='<form action="'.base_url().'persona/bajaTotal" method="POST"><input type="hidden" value="'.$datosAgente->idPersona.'" name="idPersona"><button class="btn btn-danger">Eliminar</button></form>';
  }
  }
  return $cadena;
}
?>
  <div id="base_url" class="container-fluid" data-base-url="<?= base_url() ?>">
  </div>
  <script src="<?= base_url() ?>assets/js/fileupload/public/bundle-personas.js"></script>
  <script>
    $(document).ready(function() {
      const persona = new Personas({
        classRender: '.js-persona-baja',
        actionOpen: '.bn-per-baja',
        callbackSuccess: function(response) {

          // datatable.draw();
        }
      });
      persona.init();
    });
  </script>
  <div class="js-persona-baja"></div>

<?
function imprimirSelecPersonas($datos, $deleteProccessing)
{
  
  $option='';
  foreach ($datos as $key1 => $value1) 
  {
  
    $option.='<optgroup label="'.$key1.'">';
    foreach ($value1 as $key => $value) 
    {
     $nombres=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
        $baneado="";
    if($value->activated==0){$baneado="bg-danger";}
    $delete = in_array($value->idPersona, $deleteProccessing) ? "text-danger" : "";
    $option.='<option value="'.$value->idPersona.'" class="'.$baneado.' '.$delete.'">'.$nombres.' <label>     ('.$value->email.')</label></option>';  
    }
    $option.='</optgroup>';
  
  }
  return $option;

}
function imprimirTipoPersona($datos, $typePerson = 0)
{

  $forprint = $typePerson == 1 || $typePerson == 0 ? array(1,5) :  array(3,5);

  $option='<option value="">Seleccione</option>';
  foreach ($datos as $key => $value) 
  {
    if(in_array($value->id, $forprint)){
      $option.='<option value="'.$value->id.'">'.$value->tipoPersona.'</option>';  
    }
    //$option.='<option value="'.$value->id.'">'.$value->tipoPersona.'</option>';  
  }
  return $option;
}
    

function imprimirCatalogoPuestos($datos,$puestoPersona)
{

    $option='<option value="">Seleccione</option>';
    foreach ($datos as  $value) 
    { 

     $option.='<option value="'.$value->idPuesto.'">'.$value->personaPuesto.'</option>';
    }
  if($puestoPersona['idPuesto']>0)
  {
   $option.='<option value="'.$puestoPersona['idPuesto'].'" data-puesto="1" selected>'.$puestoPersona['personaPuesto'].'</option>';
  }
  return $option;
}

function imprimeArea($datos,$idColaboradorArea)
{
  $option='';
  foreach ($datos as  $value) {
    $default='';
    if($value->idColaboradorArea==$idColaboradorArea){$default='selected';}
    $option.='<option value="'.$value->idColaboradorArea.'" '.$default.'>'.$value->colaboradorArea.'</option>';
  }
  return $option;
}
?>

<script type="text/javascript">
  function agregar_agente_en_espera(){
    alert('agregar');
  }
  function eliminar_agente_en_espera(){
    alert('eliminar');
  }
</script>
<script>
    $(function () {$("#fecAltaSistemPersona").datepicker({
        closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
        monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
        dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
        dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
        dateFormat: 'dd/mm/yy',
        monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
        firstDay: 1,  
            changeMonth: true,
            changeYear: true,     
        });
    });

  function filtrarSoloBaneados(objeto)
  {let tr=Array.from(document.getElementsByClassName('trPersona'));
    if(objeto.checked){tr.forEach(t=>{if(!t.classList.contains('bg-danger')){t.classList.add('ocultarObjeto')}})}
    else{tr.forEach(t=>{t.classList.remove('ocultarObjeto')})}
  }
</script>
<!--Miguel Jaime 29/11/2021-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
var HijosPersona= new Array();
function quitarItem(item){
  var index = HijosPersona.indexOf(item);
  HijosPersona.splice(index,1);
  HijosPersona.push();
  var base=document.getElementById('base').value;
  divResultado = document.getElementById('divtablaHijos'); 
  ajax=objetoAjax(); 
  var URL=base+"persona/mostrarTablaHijosPersona?hijos="+JSON.stringify(HijosPersona);
   ajax.open("GET", URL);
   ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          divResultado.innerHTML = ajax.responseText
      }
  }
    ajax.send(null)  
}

HijosPersona=new Array();
function agregarHijo(){
    var nombre=document.getElementById('nombreHijoPersona').value;
    var edad=document.getElementById('edadHijoPersona').value
    var base=document.getElementById('base').value;
    if(nombre!='' || edad!=''){
     divResultado = document.getElementById('divtablaHijos');  
     ajax=objetoAjax();
     var item=nombre+"|"+edad;   
     HijosPersona.push(item);
     var URL=base+"persona/mostrarTablaHijosPersona?hijos="+JSON.stringify(HijosPersona);
     //var URL=base+"persona/mostrarTablaHijosPersona?hijos="+HijosPersona;
     ajax.open("POST", URL);
     ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            divResultado.innerHTML = ajax.responseText
            document.getElementById('nombreHijoPersona').value='';
            document.getElementById('edadHijoPersona').value=''
        }
    }
      ajax.send(null)  
  } 
}

function ActivarRequerimientos(){
  var id=document.getElementById('experiencia').value;
  divResultado = document.getElementById('divRequerimientos');  
  ajax=objetoAjax();
  var URL="<?php echo base_url()?>"+"persona/mostrarExperienciaRequerimiento?id="+id;
  ajax.open("GET", URL);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
        divResultado.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)  
}

function viewDetailsRequeriments(detalle,titulo){
  swal("Concepto de "+titulo,detalle);
}

var ctHab=0;
function contarHabilidad(limite){
  ctHab++;
  total = ctHab/limite; //(ctHab*100)/limite;
  document.getElementById('habilidades').value=total;
}

var ctComp=0;
function contarCompetencia(limite){
  ctComp++;
  total=(ctComp*100)/limite;
  document.getElementById('competencias').value=total;
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

//function showOptionsPerson(val, vend){

  //------------------ //Dennis Castillo [2022-03-31]
  //if(val == 1 && vend == 0){
    //$(".agent-person").css("display", "none");
    //$(".job-person").css("display", "block");
  //} else if(val == 2){
    //$(".job-person").css("display", "none");
    //$(".agent-person").css("display", "block");
  //} else if(val == 1 && vend > 0){
    //$(".job-person").css("display", "block");
    //$(".agent-person").css("display", "block");
  //}
  //-----------------
//}
//----------------------------
$(document).on('show.bs.collapse', '.support-links-content', function () {
    
    const baseUrl = $("#base").val();

    const ajax = $.ajax({
        type: "GET",
        url: `${baseUrl}persona/getLinkList`,
        error: (error) => {
            console.log(error);
        },
        success: (data) => {
            
            const response = JSON.parse(data);
            console.log(response);

            if(response.data.length == 0){
                
                $(this).html(`<h4 class="text-center">Sin enlaces de apoyo por el momento</h4>`);

            } else{

              const tr = response.data.reduce((acc, curr, idx) => {
                acc += `<tr>
                  <td>
                    <a class="text-dark" target="_blank" href="${curr.link}"><div class="border-button">Consulta en la siguiente página: ${curr.label}</div><div><small>${curr.link}</small></div></a>
                  </td>
                </tr>`;
                return acc;
              }, ``);

              $(this).html(`<table class="table table-sm table-hover"><tbody>${tr}</tbody></table>`);
            }
        }
    });
});
//------------------------------
//const personVal = ["", "1"].includes($("#tipoPersona option:selected").val()) ? 1 : 2;
//console.log(personVal, $("#tipoPersona option:selected").val(), vend, "VALUES");
//showOptionsPerson(personVal, $("#IDVend"));
</script>
