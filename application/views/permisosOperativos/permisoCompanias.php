<?php 
  $this->load->view('headers/header');
  $this->load->view('headers/headerReportes');
  $this->load->view('headers/menu');
?>

<!--------------------------------------- CONFIGURACIONES ------------------------------------------->
<?
/*$permisosIndividuales=array('GERENTECOMERCIAL@AGENTECAPITAL.COM'=>'<button atributoClass="divConfiguracionResponsableActividades"  onclick="escogePestania(\'divConfiguracionResponsableActividades\')"  class="btnPestania">Config. Responsable Actividades</button>','COORDINADOROPERATIVO@ASESORESCAPITAL.COM'=>'<button atributoClass="divConfiguracionResponsableActividades"  onclick="escogePestania(\'divConfiguracionResponsableActividades\')"  class="btnPestania">Config. Responsable Actividades</button>','SISTEMAS@ASESORESCAPITAL.COM'=>'<button atributoClass="divSubRamoCompania"  onclick="escogePestania(\'divSubRamoCompania\')"  class="btnPestania">SubRamo-Companias</button>
<button atributoClass="divConfiguracionResponsableActividades"  onclick="escogePestania(\'divConfiguracionResponsableActividades\')"  class="btnPestania">Config. Responsable Actividades</button>');*/
$permisosIndividuales=array(
  'GERENTECOMERCIAL@AGENTECAPITAL.COM'=>['divConfiguracionResponsableActividades','divSubRamoCompania','ModuloFinanciero','divPuntajeProspeccion','divCompaniaHoras','divPermisoSiniestro'],
  'DIRECTORCOMERCIAL@AGENTECAPITAL.COM'=>['divConfiguracionResponsableActividades','divSubRamoCompania','ModuloFinanciero'],
  'COORDINADOR@CAPCAPITAL.COM.MX'=>['divConfiguracionResponsableActividades','divSubRamoCompania','ModuloFinanciero'],
  'COORDINADOROPERATIVO@ASESORESCAPITAL.COM'=>['divConfiguracionResponsableActividades','divSubRamoCompania','divPermisosCobranza','divPermisosModulos'],
  'MARKETING@AGENTECAPITAL.COM'=>['divSubRamoCompania','divCompaniaHoras','divRanking'],
  'COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM'=>['divControlSemaforoActividades'],
  'COORDINADORCORPORATIVO@AGENTECAPITAL.COM'=>['divSubRamoCompania','divConfiguracionResponsableActividades','divCompaniaHoras','divPermisoSiniestro']
);

$botones=array('divSubRamoCompania'=>'<button atributoClass="divSubRamoCompania"  onclick="escogePestania(\'divSubRamoCompania\')"  class="btnPestania">SubRamo-Compañía</button>','divConfiguracionResponsableActividades'=>'    <button atributoClass="divConfiguracionResponsableActividades"  onclick="escogePestania(\'divConfiguracionResponsableActividades\')"  class="btnPestania">Config. Responsable Actividades</button>','divRanking'=>'<button atributoClass="divRanking" onclick="escogePestania(\'divRanking\')" class="btnPestania">Ranking</button>','divCalificacionAgente'=>'<button atributoClass="divCalificacionAgente" onclick="escogePestania(\'divCalificacionAgente\')" class="btnPestania">Calificación Agente</button>','divCompaniaHoras'=>' <button atributoClass="divHorasCompania" onclick="escogePestania(\'divHorasCompania\')" class="btnPestania">Horas Compañía
    </button>','divCambioCartera'=>'<button atributoClass="divCambioCartera" onclick="escogePestania(\'divCambioCartera\')" class="btnPestania">Cambio Cartera</button>','divResponsableEmision'=>'<button atributoClass="divResponsableEmision" onclick="escogePestania(\'divResponsableEmision\')" class="btnPestania">Responsable Emisión</button>','divPermisosModulos'=>'<button atributoClass="divPermisosModulos" onclick="escogePestania(\'divPermisosModulos\')" class="btnPestania">Módulo de Permisos</button>','divArchivosPromotoria'=>'<button atributoClass="divArchivosPromotoria" onclick="escogePestania(\'divArchivosPromotoria\')" class="btnPestania">Archivos por Promotoria</button>','divSMS'=>'<button atributoClass="divSMS" onclick="escogePestania(\'divSMS\')" class="btnPestania">Envío de SMS</button>','divAsignacionCoordinadores'=>'<button atributoClass="divAsignacionCoordinadores" onclick="escogePestania(\'divAsignacionCoordinadores\')" class="btnPestania">Asignación Coordinadores</button>','ModuloFinanciero'=>'<button atributoClass="ModuloFinanciero" onclick="escogePestania(\'ModuloFinanciero\')" class="btnPestania">Metas Comerciales</button>','divCausRaizAccionCorrectiva'=>'<button atributoClass="divCausRaizAccionCorrectiva" onclick="escogePestania(\'divCausRaizAccionCorrectiva\')" class="btnPestania">Causa Raíz y Acción Correctiva</button>','divTipoInicidencia'=>'<button atributoClass="divTipoInicidencia" onclick="escogePestania(\'divTipoInicidencia\')" class="btnPestania">Tipo de Incidencias</button>','divTipoBaja'=>'<button atributoClass="divTipoBaja" onclick="escogePestania(\'divTipoBaja\')" class="btnPestania">Tipo de Bajas</button>','divPermisoSiniestro'=>'<button atributoClass="divPermisoSiniestro" onclick="escogePestania(\'divPermisoSiniestro\')" class="btnPestania">Permiso Siniestros</button>','divControlSemaforoActividades'=>'<button atributoClass="divControlSemaforoActividades" onclick="escogePestania(\'divControlSemaforoActividades\')" class="btnPestania">Control Semáforo Actividades</button>','divControlCierreComercial'=>'<button atributoClass="divControlCierreComercial" onclick="escogePestania(\'divControlCierreComercial\')" class="btnPestania">Activar/Desactivar Cierre Comercial Del Mes</button>','divGuionesTelefonicos'=>'<button atributoClass="divGuionesTelefonicos" onclick="escogePestania(\'divGuionesTelefonicos\')" class="btnPestania">Guiones Telefónicos - Tutoriales</button>','divPuntosValoracion'=>'<button atributoClass="divPuntosValoracion" onclick="escogePestania(\'divPuntosValoracion\')" class="btnPestania">Puntos de Valoración</button>','divConfigReporteDiario'=>'<button atributoClass="divConfigReporteDiario" onclick="escogePestania(\'divConfigReporteDiario\')" class="btnPestania">Reportes Diarios a Correo</button>','divMonitoreoBD'=>'<button atributoClass="divMonitorearDB" onclick="escogePestania(\'divMonitorearDB\')" class="btnPestania">Monitorear BD</button>','divPermisosCobranza'=>'<button atributoClass="divPermisosCobranza" onclick="escogePestania(\'divPermisosCobranza\')" class="btnPestania">Cobranza</button>','divPuntajeProspeccion'=>'<button atributoClass="divPuntajeProspeccion" onclick="escogePestania(\'divPuntajeProspeccion\')" class="btnPestania">Puntaje de prospeccion</button>') ;

?>

<div class="pestaniasInfoDiv">
  <div class="divPestania">
    <? if(array_key_exists($userEmail, $permisosIndividuales))
    {
      $menu='';
     foreach ($permisosIndividuales[$userEmail] as $key => $valuePI) {if(array_key_exists($valuePI, $botones)){$menu.=$botones[$valuePI];}
     }
     echo $menu;

?>

<?} else{?>
    <button atributoClass="divSubRamoCompania"  onclick="escogePestania('divSubRamoCompania')"  class="btnPestania">SubRamo-Compañía</button>
    <button atributoClass="divConfiguracionResponsableActividades"  onclick="escogePestania('divConfiguracionResponsableActividades')"  class="btnPestania">Config. Responsable Actividades</button>
    <button atributoClass="divRanking" onclick="escogePestania('divRanking')" class="btnPestania">Ranking</button>
    <button atributoClass="divCalificacionAgente" onclick="escogePestania('divCalificacionAgente')" class="btnPestania">Calificación Agente</button>
    <button atributoClass="divHorasCompania" onclick="escogePestania('divHorasCompania')" class="btnPestania">Horas Compañía
    </button><!-- [Suemy][2024-07-23] -->
    <button atributoClass="divCambioCartera" onclick="escogePestania('divCambioCartera')" class="btnPestania">Cambio Cartera</button>
    <button atributoClass="divResponsableEmision" onclick="escogePestania('divResponsableEmision')" class="btnPestania">Responsable Emisión</button>
    <button atributoClass="divPermisosModulos" onclick="escogePestania('divPermisosModulos')" class="btnPestania">Módulo de Permisos</button>
    <button atributoClass="divArchivosPromotoria" onclick="escogePestania('divArchivosPromotoria')" class="btnPestania">Archivos por Promotoria</button>
    <button atributoClass="divSMS" onclick="escogePestania('divSMS')" class="btnPestania">Envío de SMS</button>
    <button atributoClass="divAsignacionCoordinadores" onclick="escogePestania('divAsignacionCoordinadores')" class="btnPestania">Asignación Coordinadores</button>
    <button atributoClass="ModuloFinanciero" onclick="escogePestania('ModuloFinanciero')" class="btnPestania">Metas Comerciales</button><!-- divModuloFinanciero -->
     <button atributoClass="divCausRaizAccionCorrectiva" onclick="escogePestania('divCausRaizAccionCorrectiva')" class="btnPestania">Causa Raíz y Acción Correctiva</button><!-- divAsigancionMetasComerciales -->
    <button atributoClass="divTipoInicidencia" onclick="escogePestania('divTipoInicidencia')" class="btnPestania">Tipo de Incidencias</button><!-- divPermisoSiniestro -->
    <button atributoClass="divTipoBaja" onclick="escogePestania('divTipoBaja')" class="btnPestania">Tipo de Bajas</button>
    <button atributoClass="divPermisoSiniestro" onclick="escogePestania('divPermisoSiniestro')" class="btnPestania">Permiso Siniestros</button>
    <button atributoClass="divControlSemaforoActividades" onclick="escogePestania('divControlSemaforoActividades')" class="btnPestania">Control Semáforo Actividades</button>
    <button atributoClass="divControlCierreComercial" onclick="escogePestania('divControlCierreComercial')" class="btnPestania">Activar/Desactivar Cierre Comercial Del Mes</button>
    <button atributoClass="divGuionesTelefonicos" onclick="escogePestania('divGuionesTelefonicos')" class="btnPestania">Guiones Telefónicos - Tutoriales</button> <!-- Dennis [2021-08-05] -->

    <button atributoClass="divPuntosValoracion" onclick="escogePestania('divPuntosValoracion')" class="btnPestania">Puntos de Valoración</button> 
    <button atributoClass="divConfigReporteDiario" onclick="escogePestania('divConfigReporteDiario')" class="btnPestania">Reportes Diarios a Correo</button>
    <button atributoClass="divMonitorearDB" onclick="escogePestania('divMonitorearDB')" class="btnPestania">Monitorear BD</button>
  
     <button atributoClass="divPermisosCobranza" onclick="escogePestania('divPermisosCobranza')" class="btnPestania">Cobranza</button>
    <button atributoClass="divPuntajeProspeccion" onclick="escogePestania('divPuntajeProspeccion')" class="btnPestania">Puntaje de prospecci&oacute;n</button>
      <?}?>
  </div>
  <div class="divContiene" style="">
    <!------------------------------------------------------------------------------->
    <!-- SubMódulo: SubRamo-Compañía -->
    <div id="divSubRamoCompania" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">SubRamo-Compañía</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-6 column-flex-center" style="margin-bottom: 5px;">
              <select class="form-control" id="selectRamos" onchange='enviarForm(0,"traerSubRamos")'></select>
              <button class="btn btn-primary hidden" id="subRamo-Guardar" onclick="asignarCompaniaRamo(0)" style="margin-left: 15px;">Guardar cambios</button>
              <input type="hidden"  id="hiddenIdSubRamo">
            </div>
            <div class="col-md-12">
              <div class="col-md-5" id="divSubRamos"></div>
              <div class="col-md-7" id="divCompanias">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Config. Responsable Actividades -->
    <div id="divConfiguracionResponsableActividades" class="divHojaPestania">
      <?= $this->load->view('permisosOperativos/permisosActividades'); ?>
    </div>
    <!-- SubMódulo: Ranking -->
    <div id="divRanking" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Ranking</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="alert alert-info">
          <i class="fa fa-info-circle"></i>&nbsp; Seleccione el ranking en la tabla para cambiar su número
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-12 column-flex-center" style="margin-bottom: 5px;">
              <input type="hidden" id="hiddenRanking"><input type="text" class="form-control" id="textRanking" placeholder="Número compañías permitidas" style="width:30%;">
              <button class="btn btn-primary" onclick="guardarPermitidoPorRanking()" style="margin-left:5px">Guardar</button>
            </div>
            <div class="col-md-12" id="Container-Ranking"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Calificación Agente -->
    <div id="divCalificacionAgente" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Calificación Agente</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-12">
              <div class="col-md-12 column-flex-center" style="padding: 0px 0px 5px;">
                <input type="input" class="form-control" id="inputNombreCalificacion" style="width: 40%;">
                <button class="btn btn-primary" onclick="guardarCalificacion()" style="margin-left: 5px;">Guardar</button>
              </div>
              <table class="table table-style" border="1" id="tableCalificacion">
                <thead><tr><td>Calificación Agente</td><td></td><td></td></tr>
                </thead>
                <tbody><?php echo(devuelveCalificaciones($calificacionAgente));?></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Horas Compañía -->
      <!---------------- [Suemy][2024-07-23]  --------------->
    <div id="divHorasCompania" class="divHojaPestania">
      <?= $this->load->view('permisosOperativos/horasCompania');?>
    </div>
    <!-- SubMódulo: Cambio Cartera -->
    <div id="divCambioCartera" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Cambio Cartera</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-12 column-flex-center">
              <label class="textLabel">Id Vendedor:</label>
              <input type="text" class="form-control" id="textIDVen" style="width: 20%;">
              <label class="textLabel" style="margin-left: 20px;">Id Cliente:</label>
              <input type="text" class="form-control" id="textCli" style="width: 20%;">
              <button class="btn btn-primary" onclick="guardarCambioCartera()" style="margin-left: 5px;">Guardar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Responsable Emisión -->
    <div id="divResponsableEmision" class="divHojaPestania">
      <div class="col-md-12" style="padding: 5px 15px;">
        <select class="form-control" id="selectEmpleado" style="color: #212529;"><?php echo(imprimirEmpleados($empleados));?></select>
      </div>
      <div class="col-md-12" style="height: 470px;overflow:auto;padding: 0px 10px 0px 15px">
        <table class="table table-style" id="TablaRespEm" border="1"><?php echo(imprimirTablaRamos($ramos));?></table>
      </div>
    </div>
    <!-- SubMódulo: Módulo de Permisos -->
    <div id="divPermisosModulos" class="divHojaPestania">
      <div class="col-md-12" style="padding: 5px 15px;">
        <select class="form-control" id="selectEmpleadoPermisos" onchange="traerPermisoModuloPersona(this.value)" style="color: #212529;"><?php echo(imprimirEmpleados($empleados));?></select>
      </div>
      <div class="col-md-12">
        <?
         if(!isset($instancia)){$instancia='';}
         if(!isset($celular)){$celular='';}
         if(!isset($token)){$token='';}
         if(!isset($celularSMS)){$celularSMS='';}
         if(!isset($idPersonaPermisosModulos)){$idPersonaPermisosModulos='';}

        ?>
        <div class="col-md-3 col-sm-3 col-xs-3"><input type="text" id="numeroCelular" class="form-control" placeholder="NUMERO DEL CELULAR" value="<?=$celular;?>"></div>
        <div class="col-md-3 col-sm-3 col-xs-3"><input type="text" id="instanciaCelular" class="form-control" placeholder="INSTANCIA" value="<?=$instancia;?>"></div>
        <div class="col-md-3 col-sm-3 col-xs-3"><input type="text" id="tokenCelular" class="form-control" placeholder="TOKEN" value="<?=$token?>"></div>
        <div class="col-md-2 col-sm-2 col-xs-2"><button class="btn btn-primary" onclick="guardarModuloPermiso()">Guardar</button></div>
      </div>
      <div class="col-md-12" style="padding: 5px 15px;">
        <div class="col-md-3"><input class="form-check-input checkbox-All" id="CheckSMS" onclick="traerNumeroEmpresa(<?=$idPersonaPermisosModulos?>)" type="checkbox" style="margin-top: 0px;"> Envio de inconformidades</div>
        <div class="col-md-3"><input type="text" id="numeroSMS" class="form-control" placeholder="NÚMERO PARA SMS" value="<?=$celularSMS;?>"></div>
        <div class="col-md-4"><button class="btn btn-primary" onclick="guardarCelSMS(<?=$idPersonaPermisosModulos?>)">Guardar</button></div>
      </div>
      <div class="col-md-12" id="containerTableModuloPermisos">
        <?php echo(imprimirModuloPermisos($modulosPermisosPersona));?>
      </div>
    </div>
    <script>if(document.getElementById('numeroSMS').value!=""){$( "#CheckSMS" ).prop('checked', true);}else{$( "#CheckSMS" ).prop('checked', false);}</script>
    <!-- SubMódulo: Archivos por Promotoria -->
    <div id="divArchivosPromotoria" class="divHojaPestania">
      <div class="col-md-12" style="display: flex;">
        <div class="col-md-6 container-table-archivos-promotoria">
          <input type="text" name="" id="textPromotoriaDocumento" placeholder="Descripción" class="form-control"><button onclick="agregarDocumentoNecesario('')" class="btn">+</button>
          <table class="table table-style" id="tableDocumentoNecesario">
            <?= imprimirDocumentos($documentosNecesarios); ?>
          </table>
        </div>
        <div class="col-md-6 container-table-archivos-promotoria">
          <table class="table table-style"><?= imprimirCompanias($companiasDocumentos);?></table>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Envío de SMS -->
    <div id="divSMS" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Mensaje de texto (SMS)</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <!-- <h5 style="font-size: 16px;margin-top: 0px;">Mensaje de texto (SMS)</h5>
            <hr style="border-color: grey;"> -->
            <div class="col-md-12">
              <textarea class="form-control" id="textareaMensaje" maxlength="2000" onkeyup="cantidadCaracteres(this)" cols="55" rows="8"><?=$tareasProgramadasSMS[0]->mensaje;?></textarea>
              <div class="column-flex-center" style="padding:2px 15px 10px 15px;">
                <label id="labelTotal" style="padding-right:10px;color: #545454;">Caracteres utilizados: <?= strlen($tareasProgramadasSMS[0]->mensaje);?></label>
                <label style="padding-left:10px;color: #545454;">Limite del mensaje: 299 caracteres</label>
              </div>
            </div>
            <div class="col-md-12 column-flex-center" style="padding: 10px;">
              <div class="col-md-3">
                <label class="textLabel">Días antes de vencimiento:</label>
                <input type="number" class="form-control" name="" id="inputDiasVencimiento" value="<?=$tareasProgramadasSMS[0]->dias;?>">
              </div>
              <div class="col-md-2">
                <label class="textLabel">Fecha:
                  <select class="form-control" id="opcionFecha" >
                    <option value="FLimPago" <? if($tareasProgramadasSMS[0]->tipoFecha=='FLimPago'){echo('selected');} ?> >FLimPago</option>
                    <option value="FDesde" <? if($tareasProgramadasSMS[0]->tipoFecha=='FDesde'){echo('selected');} ?>>FDesde</option>
                    <option value="FHasta" <? if($tareasProgramadasSMS[0]->tipoFecha=='FHasta'){echo('selected');} ?>>FHasta</option>
                  </select>
                </label>
              </div>
              <div class="col-md-2 column-grid">
                <label class="textLabel">Activar el envío:</label>
                <div class="checkbox-center">
                  <input type="checkbox" class="form-check-input checkbox-item" id="checkEnvioActivo" value="'.$value->idPersonaPermiso.'" checked  style="margin-top: 0px;" <? if($tareasProgramadasSMS[0]->activo){echo 'checked';} ?>>
                </div>
              </div>
              <div class="col-md-2">
                <button class="btn btn-primary" onclick="guardarTareaEnvioMensajes('')">Guardar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Asignación Coordinadores -->
    <div id="divAsignacionCoordinadores" class="divHojaPestania">
      <!-- <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Asignación de Coordinadores</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body"> -->
            <div class="col-md-12 column-flex-center" style="padding: 5px 15px;">
              <select id="selectAsignacionCoordinadores" onchange="asignaCoordinadoresTabla(this)" class="form-control" style="width: auto;color: #212529;"><?php echo(imprimirCoordinadores($empleados,$coordinadoresHijos));?></select>
              <button onclick="guardarAsigancionParaCoordinadores('')" class="btn btn-primary" style="margin-left:5px;">Guardar</button>
            </div>
            <div class="col-md-12 container-table-asignacion-coordinadores"> <!-- 374 -->
              <table id="tablaAsignacionCoordinadores" class="table table-style">
                <thead class="table-thead"><tr><th></th><th>Coordinador</th></tr></thead>
                <tbody id="bodyAsignacionCoordinadores"></tbody>
              </table>
            </div>
          <!-- </div>
        </div>
      </div> -->
    </div>
    <!-- SubMódulo: Metas Comerciales -->
      <!-- Nuevo modulo financiero. realizado por Dennis Castillo-->
    <div id='ModuloFinanciero' class="divHojaPestania" class="col-lg-12 col-sm-12 col-md-12">
      <div class="col-lg-12 container-fluid">
          <div cla="container" style="margin-bottom: 10px;">
            <div class="jumbotron" style="margin: 0px;padding: 20px 60px;">
              <h2 style="margin: 0px;">Módulo de Metas Comerciales</h2>
              <h4>Seleccione la acción a realizar.</h4>
              <select id="listaActividades" onchange="despliegaAgregaMetasComerciales()" name="listaMetaC" class="form-control">
              <!--<select id="listaActividades" name="listaMetaC">-->
                <option>Seleccione una opción</option>
                <option value="metaCA">Agregar meta comercial anual</option>
                <option value="metaPC">Agregar meta por ramo</option>
                <option value="listAsigna">Ver asignados anual</option>
                <option value="listAsignaRamos">Ver asignaciones por ramos</option>
              </select>
            </div>
          </div>
      </div>
      <!-------------------------------------------------------------------------------------------------------------->
      <div class="col-md-12 container-mc" id="contenidoMF" style="">
        <div class="panel panel-primary">
          <div class="panel-heading"><h4>Meta comercial para el año <b><?=date("Y")?></b></h4></div>
          <div class="panel-body column-grid">
            <h5>Asignar meta a un coordinador activo</h5>
            <input type="hidden" name="idMetaC" value="0" id="idMetaC">
            <select name="coordinacion" id="coordinacionId" class="form-control" style="width:auto;">
              <option value="0">Seleccione a un coordinador</option>
              <?php if(isset($personalSuperior)){
                foreach($personalSuperior as $valor){ ?>
                  <option value="<?=$valor->idPersona?>"><?=$valor->nombres." ".$valor->apellidoPaterno." ".$valor->apellidoMaterno." (".$valor->email.")"?></option>
                <?php }
                }?>
            </select>
            <br>
            <div class="col-md-12">
              <h5>Seleccione el tipo de meta a asignar</h5>
              <div class="col-md-12 column-flex-item-center" style="padding: 5px;">
                <input type="radio" class="form-check-input radio-item" name="tipo_meta" id="r_meta_vn" value="1" checked>&nbsp<label class="textLabel" for="meta_vn">Meta por comisión de venta nueva</label>
              </div>
              <div class="col-md-12 column-flex-item-center" style="padding: 5px;">
                <input type="radio" class="form-check-input radio-item" name="tipo_meta" id="r_meta_it" value="2">&nbsp<label class="textLabel" for="meta_it">Meta por comisión de ingreso total</label>
              </div>
            </div>
            <div class="col-md-12">
              <hr  style="width: 50%;border-top: 1px solid #e3e3e3; margin-top: 10px; margin-bottom: 5px;">
            </div>
            <div class="col-md-12">
              <h5>Asignación de monto anual</h5>
              <input type="number" name="metaAnio" id="cantidadAnual" class="form-control" placeholder="Asigne una cantidad" style="width:30%; text-align: center; margin:0 auto" required>
            </div>
            <br>
            <div class="col-md-12">
              <label for="cantidadAnual"><h4>Monto global: $ <span id="monto_en_miles">0</span></h4></label>
            </div>
            <br>
            <div class="col-md-12" style="padding-bottom: 20px;">
              <button id="btnSubmit" class="btn btn-primary">Asignar meta comercial</button>
            </div>
          </div>
        </div>

        <div class="container-fluid" id="conttablaMensual" style="display: none">
          <div class="panel panel-default">
              <div class="panel-heading"><h4 id="metaAsig"></h4></div>
              <div class="panel-body">
                <form id="formMensualM">
                  <table class="table">
                  <thead>
                    <tr class="active text-center">
                      <th class="text-center" style="color:#808B96">Mes</th>
                      <th class="text-center" style="color:#808B96">Monto asignado al mes</th>
                      <!--<th class="text-center" style="color:#808B96">Monto restante</th>-->
                    </tr>
                  </thead>
                  <tbody id="cuerpoMM">
                  </tbody>
                </table>
                <button id="submitMontoMensual" class="btn btn-success">Asignar montos mensuales</button>
                </form>
              </div>
          </div>            
        </div>
      </div> 
      <!-------------------------------------------->
      <div class="col-md-12" id="contenedor_asignacion_prima" style="display:none; width: 100%; text-align: center;">
        <div class="panel panel-default">
          <div class="panel-heading"> Asignación de meta por ramo </div>
          <div class="panel-body">
            <form id="formulario_asigna_meta">
            <div class="panel panel-info" style="width:34%; display: inline-block; margin: 0 auto; vertical-align: top">
              <div class="panel-heading"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbspMeta por ramo</div>
              <div class="panel-body" style="">
                <?php $mes_asignacion=array(1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");?>
                <h5> <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp Asignar meta a un mes</h5>
                <select name="mes_asignado" id="mes_asignado" class="form-control">
                  <option value="0">Seleccione</option>
                  <?php foreach($mes_asignacion as $num=>$valor){ ?>
                    <option value="<?=$num?>"><?=$valor?></option>
                  <?php }?>
                </select>
                <hr style="border-top: 1px solid #e3e3e3; margin-top: 20px; margin-bottom:20px;">
                <div class="tabpanel">
                  <ul class="nav nav-tabs text-center" role="tablist">
                    <li role="presentation" class="active"><a href="#div_prima" aria-controls="div_prima" role="tab" data-toggle="tab"><i class="fa fa-money" aria-hidden="true"></i>&nbspAsignar prima neta</a></li>
                    <li role="presentation"><a href="#div_polizas" aria-controls="div_polizas" role="tab" data-toggle="tab"><i class="fa fa-cube" aria-hidden="true"></i>&nbspCantidad de polizas</a></li>
                  </ul>
                  <div class="tab-content">
                  <?php $lista_ramos=array("autos","danios","gmm","vida","fianzas")?>
                    <div role="tabpanel" class="tab-pane active" id="div_prima">
                      <h5 style="margin-top: 0px;">Asignacion de meta de prima</h5>
                      <table class="table">
                        <tbody>
              <?php for($i=0; $i<count($lista_ramos); $i++){?> 
                          <tr>
                            <!--<td><input type="checkbox" name="ramos_prima[]" id="ramos_prima_<?=$lista_ramos[$i]?>" value="<?=$lista_ramos[$i]?>"></td>-->
                            <td class="text-left">Prima en <?=strtoupper($lista_ramos[$i])?></td>
                            <td><input type="number" class="form-control" name="<?=$lista_ramos[$i]?>_prima" id="<?=$lista_ramos[$i]?>_prima"></td>
                          </tr>
              <?php }?>
                          <!--<tr>
                            <td><input type="checkbox" name="ramos_prima" id="ramos_prima" value="autos"></td>
                          </tr>-->
                        </tbody>
                      </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="div_polizas">
                      <h5>Asignacion de cantidad de pólizas</h5>
                      <table class="table">
                        <tbody>
              <?php for($i=0; $i<count($lista_ramos); $i++){?> 
                          <tr>
                            <!--<td><input type="checkbox" name="ramos_polizas[]" id="ramos_polizas_<?=$lista_ramos[$i]?>" value="<?=$lista_ramos[$i]?>"></td>-->
                            <td class="text-left">Polizas en <?=strtoupper($lista_ramos[$i])?></td>
                            <td><input type="number" class="form-control" name="<?=$lista_ramos[$i]?>_polizas" id="<?=$lista_ramos[$i]?>_polizas"></td>
                          </tr>
              <?php }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                
                </div>
              </div>
              <div class="panel-footer">
                <button class="btn btn-primary" id="boton_envia_ramos"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbspAsignar metas</button>
              </div>
            </div>

            <div class="panel panel-info" style="width:65%; display: inline-block">
              <div class="panel-heading"><i class="fa fa-user" aria-hidden="true"></i>&nbspSelección de personal</div>
              <div class="panel-body">

                <h5>Seleccione una opcion de la lista</h5>

                <select name="coor_asigna_prima" id="coor_asigna_prima" class="form-control">
                      <option value="0">Seleccione</option>
                    <?php foreach($personalSuperior as $datos) {?> 
                      <option value="<?=$datos->idPersona?>"><?=$datos->nombres." ".$datos->apellidoPaterno." ".$datos->apellidoMaterno." (".$datos->email.")"?></option>
                    <?php }?>
                </select>
                <br>

                <p>Personal asignado</p>

                <div id="contenedor_personal">
                  <table class="table" id="tabla_contenedor_p">
                    <thead>
                      <tr>
                        <th class="text-center"><i class="fa fa-check" aria-hidden="true"></i>&nbspSeleccionado</th>
                        <th class="text-center"><i class="fa fa-user" aria-hidden="true"></i>&nbspCoordinador seleccionado</th>
                        <th class="text-center"><i class="fa fa-times-circle" aria-hidden="true"></i>&nbspEliminar selección</th>
                      </tr>
                    </thead>
                    <tbody id="lista_pp">
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
            <!---->
            </form>
          </div>
        <!---->
        </div>
      </div>          
      <!-------------------------------------------->
      <div id="contAsignados" style="width: 100%; height: 100%; text-align: center; display:none; align-content: center"> 
        <div class="container-fluid">
          <div class="panel panel-info">
            <div class="panel-heading">
                <h4>Lista de coordinadores con meta asignada.</h4>
            </div>
            <div class="panel-body">
              <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist" id="tabs_metas">
                  <li role="presentation" class="active"><a href="#tab_meta_ve" aria-controls="tab_meta_ve" role="tab" data-toggle="tab">Meta por venta nueva</a></li>
                  <li role="presentation"><a href="#tab_meta_it" aria-controls="tab_meta_it" role="tab" data-toggle="tab">Meta por ingreso total</a></li>
                </ul>
              </div>
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_meta_ve">
                  <h4>Personal con meta de venta nueva</h4><br>
                  <?php if(isset($coorAsignados)){?>
                  <table class="table table-striped">
                    <thead>
                      <tr class="active">
                        <th class="text-center" style="color:#808B96">COORDINADOR</th>
                        <th class="text-center" style="color:#808B96">META ASIGNADO</th>
                        <th class="text-center" style="color:#808B96">OPCIONES</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpoAsignados">
                <?php 
                  foreach($coorAsignados as $datosMeta){?> 
                    <tr id="fila_<?=$datosMeta->idMetaComercial?>">
                      <td class="text-left"><?=$datosMeta->email?></td>
                      <td>$ <?=number_format($datosMeta->montoDeMetaComercial)?> MXN</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-link dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="eliminaMeta(<?=$datosMeta->idMetaComercial?>,1)">Eliminar</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="actualizaMeta(<?=$datosMeta->idPersona?>,<?=$datosMeta->montoDeMetaComercial?>,<?=$datosMeta->idMetaComercial?>,1)">Modificar</a></li>
                            <li role="presentation"><button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-backdrop="false" data-target="#modal_ramos" onclick="editaMetaMensual(<?=$datosMeta->idPersona?>,<?=$datosMeta->idMetaComercial?>,1)">Actualiza meta mensual</button></li>
                            <li role="presentation">
                              <!--<button type="button" data-toggle="modal" data-target="#goalsForAssigned" class="goal-agent-assigned"  data-backdrop="false" data-persona="<?=$datosMeta->idPersona?>" data-metas="<?=$datosMeta->idMetaComercial?>">Asignar metas</button>-->
                              <a href="javascript: void(0);" role="button" class="goal-agent-assigned" data-persona="<?=$datosMeta->idPersona?>" data-metas="<?=$datosMeta->idMetaComercial?>">Asignar meta a agentes</a>
                            </li>
                          </ul>
                        </div>

                        <!--<button class="btn btn-danger btn-xs" id="eliminaMeta" onclick="eliminaMeta(<?=$datosMeta->idMetaComercial?>,1)">Eliminar</button>
                        <button class="btn btn-warning btn-xs" id="actualizaMeta" onclick="actualizaMeta(<?=$datosMeta->idPersona?>,<?=$datosMeta->montoDeMetaComercial?>,<?=$datosMeta->idMetaComercial?>,1)">Actualiza</button>
                        <button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-target="#modal_ramos" onclick="editaMetaMensual(<?=$datosMeta->idPersona?>,<?=$datosMeta->idMetaComercial?>,1)">Actualiza meta mensual</button>-->
                      </td>
                    </tr>
                  <?php } ?>
                    </tbody>
                  </table>
                  <?php } if(empty($coorAsignados)){?> 
                    <h4>No hay datos asignados por el momento...</h4>
                  <?php }?>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_meta_it">
                  <h4>Personal con meta de ingreso total</h4><br>
                  <?php if(isset($coorAsignadosIT)){?>
                  <table class="table table-striped">
                    <thead>
                      <tr class="active">
                        <th class="text-center" style="color:#808B96">COORDINADOR</th>
                        <th class="text-center" style="color:#808B96">META ASIGNADO</th>
                        <th class="text-center" style="color:#808B96">OPCIONES</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpoAsignados">
                <?php 
                  foreach($coorAsignadosIT as $datosMeta){?> 
                    <tr id="fila_it_<?=$datosMeta->idMetaComercial?>">
                      <td class="text-left"><?=$datosMeta->email?></td>
                      <td>$ <?=number_format($datosMeta->montoDeMetaComercial)?> MXN</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-link dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                          </button>
                          <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="eliminaMeta(<?=$datosMeta->idMetaComercial?>,2)">Eliminar</a></li>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="javascript: void(0);" onclick="actualizaMeta(<?=$datosMeta->idPersona?>,<?=$datosMeta->montoDeMetaComercial?>,<?=$datosMeta->idMetaComercial?>,2)">Modificar</a></li>
                            <li role="presentation"><button type="button" class="btn btn-link btn-xs" data-toggle="modal" data-backdrop="false" data-target="#modal_ramos" onclick="editaMetaMensual(<?=$datosMeta->idPersona?>,<?=$datosMeta->idMetaComercial?>,2)">Actualiza meta mensual</button></li>
                          </ul>
                        </div>

                        <!--<button class="btn btn-danger btn-xs" id="eliminaMeta" onclick="eliminaMeta(<?=$datosMeta->idMetaComercial?>,2)">Eliminar</button>
                        <button class="btn btn-warning btn-xs" id="actualizaMeta" onclick="actualizaMeta(<?=$datosMeta->idPersona?>,<?=$datosMeta->montoDeMetaComercial?>,<?=$datosMeta->idMetaComercial?>,2)">Actualiza</button>-->
                      </td>
                    </tr>
                  <?php } ?>
                    </tbody>
                  </table>
                  <?php } if(empty($coorAsignadosIT)){?> 
                    <h4>No hay datos asignados por el momento...</h4>
                  <?php }?>
                </div>
              </div>
            </div>
              <?php /*if(isset($coorAsignados)){?>
                  <table class="table table-striped">
                    <thead>
                      <tr class="active">
                        <th class="text-center" style="color:#808B96">COORDINADOR</th>
                        <th class="text-center" style="color:#808B96">META ASIGNADO</th>
                        <th class="text-center" style="color:#808B96">OPCIONES</th>
                      </tr>
                    </thead>
                    <tbody id="cuerpoAsignados">
                <?php 
                  foreach($coorAsignados as $datosMeta){?> 
                    <tr id="fila_<?=$datosMeta->idMetaComercial?>">
                      <td class="text-left"><?=$datosMeta->email?></td>
                      <td>$ <?=number_format($datosMeta->montoDeMetaComercial)?> MXN</td>
                      <td>
                        <button class="btn btn-danger btn-sm" id="eliminaMeta" onclick="eliminaMeta(<?=$datosMeta->idMetaComercial?>)">Eliminar</button>
                        <button class="btn btn-warning btn-sm" id="actualizaMeta" onclick="actualizaMeta(<?=$datosMeta->idPersona?>,<?=$datosMeta->montoDeMetaComercial?>,<?=$datosMeta->idMetaComercial?>)">Actualiza</button>
                      </td>
                    </tr>
                  <?php } ?>
                    </tbody>
                  </table>
                  <?php } if(empty($coorAsignados)){?> 
                    <h4>No hay datos asignados por el momento...</h4>
                  <?php }*/?>
          </div>
        </div>
      </div>
      <!-- Modal goalsForAssigned (Desactivado) -->
      <div class="modal fade goalsForAssigned hidden"  tabindex="-1" role="dialog" aria-labelledby="goalsForAssignedLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content modal-lg">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="">Asignación a agentes</h4>
            </div>
            <div class="modal-body" id="assigToAgent">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary assignGoal">Asignar metas</button>
            </div>
          </div>
        </div>
      </div>
      <!-------------------------------------------->
      <div id="contAsignadosRamos" style="width: 100%;height: 100%; text-align: center; display:none; align-content: center;">
        <div class="container-fluid">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h4>Personal asignado por Ramos.</h4>
            </div>
            <div class="panel-body">
              <div class="col-md-12 column-flex-bottom" style="padding: 0px;margin-bottom: 10px;">
                <div class="col-md-3 column-grid-ajust">
                  <label style="text-align: left; font-size: 13px;">Seleccione un mes de búsqueda</label>
                    <select name="mes_busqueda" id="mes_busqueda" class="form-control" >
                      <option value="0">Seleccione</option>
                      <? foreach($mes_asignacion as $mes_b=>$n_mes_b){?>
                        <option value="<?=$mes_b?>"><?=$n_mes_b?></option>
                      <?php }?>
                    </select>
                </div>
                <div class="col-md-2">
                  <button class="btn btn-primary" id="btn_busqueda">Realizar búsqueda</button>
                </div>
              </div>
              <div class="col-md-12 tab-items" role="tabpanel" style="padding:0px;border-bottom: 1px solid #ddd;display: flex;">
                <ul class="nav nav-tabs" role="tablist" style="width: fit-content;">
                  <li role="presentation" class="opcion_select active"><a href="#cont_polizas" aria-controls="cont_polizas" role="tab" data-toggle="tab" class="tipo_asignacion" tipo_asig="cantidad_polizas">Pólizas</a></li>
                  <li role="presentation" class="opcion_select"><a href="#cont_polizas_primas" aria-controls="cont_polizas_primas" role="tab" data-toggle="tab" class="tipo_asignacion" tipo_asig="prima_polizas">Primas</a></li>
                </ul>
              </div>
              <div class="tab-content bg-tab-content-poliza">
                <div role="tabpanel" class="col-md-12 tab-pane active" id="cont_polizas">
                  <div class="panel panel-warning" >
                    <div class="panel-heading"><h4>Ramos por cantidad de Pólizas</h4></div>
                    <div class="panel-body text-left">
                      <div class="hidden" id="sicas_consult_cantidad_polizas"></div>
                      <!--  <button class="btn btn-primary btn-xs" id="consultar_a_sicas">Consultar a Sicas</button>-->
                      <table class="table">
                        <thead>
                          <tr class="text-center">
                            <th>Asignado</th>
                            <th>Correo</th>
                            <th>Pólizas en Autos</th>
                            <th>Pólizas en Vida</th>
                            <th>Pólizas en Daños</th>
                            <th>Pólizas en GMM</th>
                            <th>Pólizas en Fianzas</th>
                            <!--<th class="sicas_result" style="display:none">Resultado de Sicas</th>-->
                            <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                          </tr>
                        </thead>
                        <tbody id="cantidad_polizas_contenedor"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div role="tabpanel" class="col-md-12 tab-pane" id="cont_polizas_primas">
                  <div class="panel panel-warning">
                    <div class="panel-heading"><h4>Ramos por Prima</h4></div>
                    <div class="panel-body text-left">
                      <div class="hidden" id="sicas_consult_prima_polizas"></div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Asignado</th>
                            <th>Correo</th>
                            <th>Prima en Autos</th>
                            <th>Prima en Vida</th>
                            <th>Prima en Daños</th>
                            <th>Prima en GMM</th>
                            <th>Prima en Fianzas</th>
                            <!--<th class="sicas_result" style="display:none">Resultado de Sicas</th>-->
                            <th><i class="fa fa-cog" aria-hidden="true"></i></th>
                          </tr>
                        </thead>
                        <tbody id="prima_polizas_contenedor"></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div style="text-align:center; align-content: center; align-items: center; position: relative; margin-top: 5%; display: none" id="cont_img_carga">
            <img src="<?php echo(base_url().'assets\img\loading.gif')?>" alt="">
            <p style="font-weight: bold">Cargando información. Espere un momento</p>
        </div>
        <!---->
        <div class="modal fade" id="modal_ramos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title" id="myModalLabel">Registro de Sicas.</h5>
              </div>
              <div class="modal-body" id="cuerpo_modal_ramos"></div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
          </div>
        </div>        
      <!---->
      </div>
    </div>
    <!-- Alternativo: Metas Comerciales (Desactivado) -->
      <div id="divAsigancionMetasComerciales" class="divHojaPestania">
        <label>De</label>
        <select id="selectParaEAM">
          <option value="F">Fianzas</option>
          <option value="M">Merida</option>
          <option value="C">Cancun</option>
        </select>
        <label>Anio</label>
        <select id='selectAnioMC' class="form-control">
          <option>2020</option>
          <option>2021</option>
          <option>2022</option>
        </select>
        <button class="btn btn-success">Ver metas</button><br>
        <label>Enero</label><input type="text" id="textEnero" data-anio="1"   class="form-control">
        <label>Febrero</label><input type="text" id="textFebrero" data-anio="2" class="form-control">
        <label>Marzo</label><input type="text" id="textMarzo"  data-anio="3" class="form-control">
        <label>Abril</label><input type="text" id="textAbril" data-anio="4"  class="form-control">
        <label>Mayo</label><input type="text" id="textMayo"  data-anio="5"  class="form-control">
        <label>Junio</label><input type="text" id="textJunio" data-anio="6"  class="form-control">
        <label>Julio</label><input type="text" id="textJulio"  data-anio="7" class="form-control">
        <label>Agosto</label><input type="text" id="textAgosto" data-anio="8" class="form-control">
        <label>Septimebre</label><input type="text" id="textSeptiembre" data-anio="9" class="form-control">
        <label>Octubre</label><input type="text" id="textOctubre" data-anio="10" class="form-control">
        <label>Noviembre</label><input type="text" id="textNoviembre" data-anio="11" class="form-control">
        <label>Diciembre</label><input type="text" id="textDiciembre" data-anio="12" class="form-control">
        <button class="btn btn-success" onclick="guardarMetasComerciales('')">Guardar</button>
      </div>
    <!-- SubMódulo: Causa Raíz y Acción Correctiva -->
    <div id="divCausRaizAccionCorrectiva" class="divHojaPestania">
      <div class="column-flex-center">
        <section class="container-fluid breadcrumb-formularios" style="width:50%;">
          <div class="row">
            <div class="col-md-12">
              <h3 class="title-section-module">Agregar Causas de la Raíz</h3>
            </div>
          </div>
          <hr/>
        </section>
        <section class="container-fluid breadcrumb-formularios" style="width:50%;">
          <div class="row">
            <div class="col-md-12">
              <h3 class="title-section-module">Agregar Acciones Correctivas</h3>
            </div>
          </div>
          <hr/>
        </section>
      </div>
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body" style="padding: 10px;">
            <div class="col-md-6 container-table-causa-raiz" style="padding: 0px 5px 0px 0px;border-right: 1px solid #e7dede;">
              <table class="table table-style" id="tableACR" border="1">
                <thead class="table-thead">
                  <tr>
                    <th><input type="text" name="" id="textNombreACR" class="form-control" placeholder="Nombre Causa Raíz"></th>
                    <th>
                      <div class="row">
                        <div class="col-sm-10 col-md-10"><input type="text" name="" id="textDescripcionACR" class="form-control" placeholder="Descripción"></div>
                        <div class="col-md-2 column-flex-center" style="padding: 0px;">
                          <button class="btn btn-success btn-plus" onclick="agregarCausaRaiz('')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                          </button>
                        </div>              
                      </div>
                    </th>
                    <th></th>
                  </tr>  
                </thead>
                <tbody id="bodyACR">
                  <?= imprimirCausaRaiz($causaRaiz);?>
                </tbody>
              </table>
            </div> 
            <div class="col-md-6 container-table-causa-raiz" style="padding: 0px 0px 0px 5px;">
              <table class="table table-style" id="tableAAC" border="1">
                <thead class="table-thead">
                  <tr>
                    <th><input type="text" name="" id="textNombreAAC" class="form-control" placeholder="Nombre Acción Correctiva"></th>
                    <th>
                      <div class="row">
                        <div class="col-sm-10 col-md-10"><input type="text" name="" id="textDescripcionAAC" class="form-control" placeholder="Descripción"></div>
                        <div class="col-md-2 column-flex-center" style="padding: 0px;">
                          <button class="btn btn-success btn-plus" onclick="agregarAccionCorrectiva('')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                          </button>
                        </div>
                      </div>
                    </th>
                    <th></th>
                  </tr>  
                </thead>
                <tbody id="bodyAAC"><?= imprimirAccionCorrectiva($accionCorrectiva);?></tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
    <!-- SubMódulo: Tipo de Incidencias -->
    <div id="divTipoInicidencia" class="divHojaPestania">
      <?= $this->load->view("permisosOperativos/tipoIncidencias") ?>
    </div>
    <!-- SubMódulo: Tipo de Bajas -->
    <div id="divTipoBaja" class="divHojaPestania">
      <?= $this->load->view("permisosOperativos/tipoBaja") ?>
    </div>
    <!-- SubMódulo: Permiso Siniestros -->
    <div id="divPermisoSiniestro" class="divHojaPestania">
      <?= $this->load->view("evaluaciones/validation/permisostree") ?>
    </div>
    <!-- SubMódulo: Control Semáforo Actividades -->
    <div id="divControlSemaforoActividades" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Control Semáforo Actividades</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-12" style="margin-bottom: 5px;">
              <div class="col-md-7 column-flex-bottom" style="padding-left: 0px;">
                <div class="col-md-5 column-grid-ajust" style="padding-left: 0px;">
                  <label>ESTADO DE ROBOT DE ACTIVIDADES:</label>
                  <select class="form-control" id="selectEstadoRobotActividades">
                    <option value="1">Prendido</option>
                    <option value="0">Apagado</option>
                  </select>
                </div>
                <div class="col-md-5" style="padding-left: 0px;">
                  <label>Comentarios:</label>
                  <input type="text" class="form-control" id="textComentariosApagado">
                </div>
                <div class="col-md-2" style="padding-left: 0px;">
                  <button class="btn btn-warning" onclick="pararRobot('','semaforoActividad',document.getElementById('textComentariosApagado').value,document.getElementById('selectEstadoRobotActividades'))" style="margin-left: 5px;">Guardar</button>
                </div>
              </div>
              <div class="col-md-5 column-flex-bottom">
                <div class="col-md-6 column-grid-ajust">
                  <label>AGREGAR DÍA INHÁBIL:</label>
                  <input type="date" class="form-control" id="dateDiaNoLaboral">
                </div>
                <div class="col-md-2">
                  <button class="btn btn-primary" onclick="agregarDiaInhabil('')">Guardar</button>
                </div>
              </div>
            </div>
            <div class="col-md-12 container-table-semaforo-actividades">
              <table class="table" id="TablaDiaInhabil">
                <thead class="table-thead">
                  <tr>
                    <th>Dia</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody id='bodyDiaNoLaboral'></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
      //$this->load->library("libreriav3");
      $mes_asignacion=array(1=>"Enero", 2=>"Febrero", 3=>"Marzo", 4=>"Abril", 5=>"Mayo", 6=>"Junio", 7=>"Julio", 8=>"Agosto", 9=>"Septiembre", 10=>"Octubre", 11=>"Noviembre", 12=>"Diciembre");
      $mes_anterior = !empty($mesComercialActivado[1]->mes_activado) ? $mes_asignacion[$mesComercialActivado[1]->mes_activado]. " - " . $mesComercialActivado[1]->anio : "Sin cierre";
      $mes_actual = !empty($mesComercialActivado[0]->mes_activado) ? $mes_asignacion[$mesComercialActivado[0]->mes_activado]. " - " . $mesComercialActivado[0]->anio : "Sin cierre";
      $mes_num = !empty($mesComercialActivado[0]->mes_activado) ? $mesComercialActivado[0]->mes_activado : 0;
      $fecha_cierre = !empty($mesComercialActivado[0]->fecha_activacion) ? $mesComercialActivado[0]->fecha_activacion : "Sin cierre";
      $anio_num = !empty($mesComercialActivado[0]->anio) ? $mesComercialActivado[0]->anio : date("Y");
      $lastYears = array_reduce(array(0,1,2,3,4,5,6,7,8,9), function($acc, $curr){
        $acc .= '<option value="'.(date("Y") - $curr).'">'.(date("Y") - $curr).'</option>';
        return $acc;
      }, "");
    ?>

    <!-- SubMódulo: Cierre Mensual Comercial -->
    <div id="divControlCierreComercial" class="divHojaPestania text-center">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Cierre Mensual Comercial</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div role="tabpanel">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#activa_cierre" aria-controls="cierre" role="tab" data-toggle="tab">Activar Cierre Comercial</a>
            </li>
            <li role="presentation">
              <a href="#reanuda_mes" aria-controls="reanuda" role="tab" data-toggle="tab">Reanudar Consulta Mensual</a>
            </li>
          </ul>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="activa_cierre">
              <div class="alert alert-info">
                <p class="text-left">Módulo para cerrar el mes de consultas comerciales.</p>
                <ul class="text-left">
                  <li>Para realizar el cierre del mes. Favor de escribir <strong>"ACEPTAR"</strong> en el campo siguiente.</li>
                  <li>El efecto de cambio se verá notado en un plazo de 10 minutos.</li>
                </ul>
              </div>
              <table class="table">
                <tbody>
                  <tr>
                    <td class="text-left">Cierre del mes anterior: <?=$mes_anterior?></td>
                    <td>Última fecha de cierre: <?=$fecha_cierre?></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-left">Mes activo: <?=$mes_actual?></td>
                  </tr>
                  <tr>
                    <td><label for="acpetacion" class="mt-3">Introduzca la palabra solicitada en el comentario anterior</label></td>
                    <td><input type="text" class="form-control" name="aceptacion" id="aceptacion" style="width: 50%"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><button class="btn btn-primary btn-sm pauta_cierre" data-mes="<?=$mes_num?>" data-anio="<?=$anio_num?>">Realizar cierre</button></td>
                  </tr>
                  <tr>
                    <td colspan="2"><label for="mssg" id="mssg"></label></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div role="tabpanel" class="tab-pane" id="reanuda_mes">
              <div class="alert alert-info">
                <p class="text-left">Módulo para reactivación de consultas comerciales</p>
                <ul class="text-left">
                  <li>Seleccione un mes para reactivación de consultas comerciales.</li>
                  <li>El efecto de cambio se verá notado en un plazo de 10 minutos.</li>
                </ul>
              </div>
              <table class="table">
                <tbody>
                  <tr>
                    <td><label for="nombre__" class="mt-3">MESES</label></td>
                    <td>
                      <select name="mes_activa" id="mes_activa" class="form-control">
                        <option value="0">SELECCIONE</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                      </select>
                    </td>
                    <td><label for="nombreA__" class="mt-3">AÑO</label></td>
                    <td><select name="anio-activo" id="anio-activo" class="form-control"><option value="0">SELECCIONE</option><?=$lastYears?></select></td>
                  </tr>
                  <tr><td colspan="4"><button class="btn btn-primary btn-sm activa_consulta">Activar consulta automática</button></td></tr>
                  <tr><td colspan="4" class="text-center"><label for="msgg" id="msgg"></label></td></tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Puntaje de Prospección -->
    <div id="divPuntajeProspeccion" class="divHojaPestania">
      <section class="container-fluid breadcrumb-formularios">
        <div class="row">
          <div class="col-md-12">
            <h3 class="title-section-module">Puntaje de Prospecci&oacute;n</h3>
          </div>
        </div>
        <hr/>
      </section>
      <div class="col-md-12">
        <div class="alert alert-info">
          <i class="fa fa-info-circle"></i>&nbsp; Seleccione el puntaje en la tabla para cambiar su número
        </div>
      </div>
      <div class="col-md-12">
        <div class="panel panel-default segment-sms" style="margin: 0px;">
          <div class="panel-body">
            <div class="col-md-12 column-flex-center" style="margin-bottom: 5px;">
              <input type="hidden" id="hiddenPuntaje"><input type="text" class="form-control" id="textPuntos" placeholder="Número de puntos" style="width:30%;">
              <button class="btn btn-primary" onclick="guardarPuntaje()" style="margin-left:5px">Guardar</button>
            </div>
            <div class="col-md-12" id="Container-Puntos"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- SubMódulo: Puntos de Valoración -->
      <!---------------- Miguel [2022-06-08]  --------------->
    <div id="divPuntosValoracion" class="divHojaPestania">
      <?php $this->load->view("permisosOperativos/puntosValoracion"); ?>
    </div>
    <!-- SubMódulo: Moniterar BD -->
    <div id="divMonitorearDB" class="divHojaPestania">
      <?php $this->load->view("permisosOperativos/monitoreoBD"); ?>
    </div>
    <!-- SubMódulo: Reportes Diarios a Correo -->
      <!---------------- Miguel [2023-03-11]  --------------->
    <div id="divConfigReporteDiario" class="divHojaPestania">
      <?php $this->load->view("permisosOperativos/configuracionReporteDiario"); ?>
    </div>
    <!-- SubMódulo: Guiones Telefónicos -->
      <!---------------- Dennis [2021-08-05]  --------------->
    <div id="divGuionesTelefonicos" class="divHojaPestania">
      <?php $this->load->view("permisosOperativos/guionTelefonico"); ?>
    </div>
    <!-- SubMódulo: Cobranza -->
    <div id="divPermisosCobranza" class="divHojaPestania">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="col-md-12 pd-items-table">
            <select class="form-control" id="selectPermisoCobranza" style="color: #212529;">
              <?php echo(imprimirEmpleados($empleados));?>
            </select>
          </div>
          <div class="col-md-12 pd-left pd-right container-table-cobranza">
            <table class="table table-striped" id="tableCobranza">
              <thead><tr><th></th><th>Permiso</th><th>Responsable</th></tr></thead>
              <tbody>
                <tr><td><button class="btn btn-warning responsablesCobranza" data-valor='cobranza'>GUARDAR</button></td><td>RESPONSABLE DE COBRANZA</td><td><div id="responsableCobranzaDiv"></div></td></tr>
                <tr><td><button class="btn btn-warning responsablesCobranza" data-valor='factura'>GUARDAR</button></td><td>RESPONSABLE DE FACTURA</td><td><div id="responsableFacturaDiv"></div></td></tr>
              </tbody>  
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade segumiento-hr-comp-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Seguimiento</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body brd-radius-modal-body" style="background: #f9f9f9;">
        <div class="col-md-12" id="contIndHRP"></div>
        <div class="col-md-12 column-flex-center-end pd-items-table-top">
          <div class="column-flex-center-end input-group inputs-md" style="width: 40%;">
            <input class="form-control search-input" placeholder="Filtrar" id="filterTableTHRP">
            <div class="input-group-append">
                <button class="btn btn-secondary" title="Limpiar Filtro" onclick="eraserFilterTable('filterTableTHRP')">
                  <i class="fas fa-eraser"></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-12" style="padding: 5px 15px 15px;">
          <div class="col-md-12 container-table-tab-modal">
            <table class="table table-striped" id="tableTrainingHoraPromotoria"></table>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div> -->
    </div>
  </div>
</div>

<?php $this->load->view('footers/footer'); ?>
<!--------------------------------------------- CSS -------------------------------------------->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/super-star-min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-table-style.css">
<style type="text/css">
  .divHojaPestania{display: flex;flex-direction: column;}
  #divSubRamos {padding: 0px;height: 380px;overflow: auto;}
  #divCompanias {padding: 0px 0px 0px 15px;height: 380px;overflow: auto;}
  #divHorasCompania > div.col-md-12 {height: -webkit-fill-available;}
  #containerTableModuloPermisos {height: 430px;overflow:auto;padding: 15px;margin-top: 5px;background: white;
    border: 1px solid #ddd;}
  #tableTrainingHoraPromotoria {font-size: 1.2rem;margin: 0px;height: 100%;}
  #tableTrainingHoraPromotoria > thead > tr > th:nth-child(2) {min-width: 120px;}
  #tableTrainingHoraPromotoria > thead > tr > th:nth-child(5) {min-width: 100px;}
  #tableTrainingHoraPromotoria > thead > tr > th:nth-child(7) {min-width: 100px;}
  #tableHoraCompania > tbody > tr:nth-of-type(odd) {background-color: #e9e9e9;}
  .pestaniasInfoDiv{display: flex;width: 100%}
  .pestaniasInfoDiv>div::nth-child(1){flex:1;}
  .pestaniasInfoDiv>div::nth-child(2){flex:2;}
  .divPestania{flex:1;display: flex;flex-direction: column;overflow-y: scroll;max-height: 550px;min-height: 200px;padding: 5px;background-color: #F6F4DB; border-bottom: 3px solid #A29C59;border-right: 1px solid #d6d2a1;}
  .divPestania > button:first-child {margin-top: 0px;}
  .divPestania>a{border:solid 1px;border-radius: .1in;min-height: 55px;min-width: 55px;margin-top: 5px;font-size: 13px}
	.divContiene{flex:8;left: 10%;height: 550px;color: black;overflow: auto;top: 20px}
	.divContiene >div{height:100%;width: 100%;padding: 15px;}
	.divContiene >div>table>tbody>tr:hover{cursor: pointer;}
	.subramoInActivo{background-color: #d14646}
	.subRamoSeleccionado{background-color: #84d784;}
	.noHabilitado{color: gray}
	.btnPestania{border: 1px solid #9a9240;border-radius: .1in;min-height: 55px;min-width: 55px;margin-top: 5px;font-size: 13px;color:black;background-color: white;transition: 0.3s;outline: none;}
	.btnPestania:hover {color: white; background: #9a9240; border: 1px solid #9a9240;}
  .btnPestania:active, .btnPestania:focus {outline: none;}
	.btnPestaniaActiva{color: white;background-color: #21114D;border-color: #21114D;}
	.ocultarObjeto{display: none;}
	.verObjeto{display: block; }
  .rowCompaniaDocumento{background-color: #8be58b;}
  /* Spinner */
  .content-load-spinner-table {
    width: 100%;
    height: 93%;
    position: absolute;
  }
  .load-spinner-table {
    text-align: center;
    /* margin: 10px; */
    color: #266093;
    width: 100%;
    height: 355.52px;
    align-items: center;
    display: flex;
    justify-content: center;
    flex-direction: column;
    position: relative;
    background-color: rgb(255 255 255 / 60%);
    z-index: 1001;
  }
  /* Text */
  .title-section-module {
    margin-top: 10px;
    text-align: initial;
  }
  optgroup {
    font-weight: 600;
  }
  /* Label */
  label {
    margin: 0px;
  }
  .label-info {
    font-size: 12px;
    margin: 0px 0px 0px 5px;
    padding: 5px;
  }
  .textLabel {
    font-size: 13px;
    margin-right: 5px;
  }
  /* Button */
  button.btn {
    border: 1px solid transparent;
    border-radius: 5px;
    outline: none;
  }
  .btn-primary {
    color: white;
    background: #266093;
  }
  .btn-success {
    color: white;
  }
  .btn-warning {
    color: #1e1e1e;
  }
  .btn-danger {
    color: azure;
  }
  .btn-info {
    color: white;
  }
  .btn-hrsComp {
    color: white;
    background: #266093;
    font-size: 13px;
  }
  .btn-plus {
    padding: 8px 10px;
    color: #133e6a;
  }
  .btn-delItem {color: #d11515;font-size: 25px;cursor: pointer;transition: 0.3s;}
  /*--- Hover ---*/
  .btn-primary:hover {
    background: #3e45a1;
    border-color: transparent;
  }
  .btn-hrsComp:hover {
    color: white;
    background: #472380;
  }
  .btn-plus:hover {
    color: beige;
  }
  .btn-delItem:hover {color: #e90000;}
  /*--- Active ---*/
  button.btn-primary:active, button.btn-primary:focus {outline: none;}
  button.btn:active, button.btn:focus {outline: 0 !important;}
  /* Textarea */
  textarea {
    outline: none;
    border-radius: 3px;
  }
  /* Input */
  input.form-control {
    border-radius: 5px;
  }
  .form-check-input.checkbox-item.check-input.checkCompanias {position: inherit;}
  .input-group.inputs-md > input {font-size: 1.3rem;height: 32px;}
  .input-group.inputs-md > .input-group-append > .btn.btn-secondary {height: 32px;}
  /* Table */
  .table.table-style {
    margin: 0px;
    background: #fafbfb;
    border: 1px solid #d1d1d1;
    border-top: none;
  }
  .table > thead > tr {
    color: white;
    background: #473380; /*#483b8f*/
  }
  /* Columnas */
  .column-flex-center {
    display: flex;
    align-items: center;
  }
  .column-flex-item-center {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .column-grid {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .column-grid-ajust {
    display: flex;
    flex-direction: column;
    max-width: max-content;
  }
  /* Contenedores */
  .container-table-overflow {height: 470px;overflow: auto;}
  .container-mc {width: 100%;height: 100%;text-align: center;display:none;align-content: center}
  .container-filter-input {padding: 5px;border: 1px solid #ddd;border-radius: 4px;}
  .container-table-tab-modal {max-width: 735px;max-height: 400px;overflow: auto;border: 1px solid #dbdbdb;padding: 0px;}
  .container-table-archivos-promotoria {height: 512px;overflow: auto;}
  .container-table-asignacion-coordinadores {height: 470px;overflow:auto;padding: 0px 10px 0px 15px;}
  .container-table-causa-raiz {overflow: auto;height: 428px;}
  .container-table-semaforo-actividades {height: 354px;overflow: auto;}
  .container-table-cobranza {max-height: 430px;overflow:auto;border: 1px solid #ddd}
  /* Segmentos */
  .segment-sms {
    /*padding: 15px;
    border: 1px solid #d5d5d5;
    border-radius: 5px;*/
    background: #fdfdfd;
  }
  /* Tabular */
  .tab-items {
    display: flex;
    padding-right: 0px;
    margin-top: 20px;
  }
  .bg-tab-content-poliza {
    border: 1px solid #ddd;
    border-top: 0px;
    padding-left: 10px;
    padding-right: 10px;
    background: white;
    padding-top: 10px;
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
  }
  /* Checkbox Personalizado */
  .checkbox-center {
    display: flex;
    align-items: center;
  }
  .checkbox-item {
    width: 20px;
    height: 20px;
    position: inherit;
  }
  
  /* Checkbox Permisos */
  .check-permisos {
    width: 16px;
    height: 16px;
  }
  .check-permisos[type=checkbox] {
    border-radius: .4em;
  }
  /* Radio */
  input[type=radio] {
    margin: 0px 0 0;
    margin-top: 1px \9;
    line-height: normal;
  }
  .radio-item {
    width: 20px;
    height: 20px;
    position: inherit;
  }
  /* Otros */
  td:focus[contenteditable="true"] {background: #f0efbe;outline: 2px solid #e5e39c;border-radius: 3px;}
  /*td:active[contenteditable="true"] {outline: 2px solid #BBB867;}*/
  .update_horaPromotoria {background: #b1e8ea;}
  .save_changes_horaPromotoria {background: #bdeabd;}
  /*.edit_horaPromotoria {background: #f0efbe;outline: 2px solid #e5e39c;border-radius: 4px;}*/
  .indicator-circle-selected {color: #f0efbe;border: 2px solid #e5e39c;border-radius: 50%;}
  .indicator-circle-edited {color: #bdeabd;font-size: 1.7rem;}
  .indicator-circle-updated {color: #b1e8ea;font-size: 1.7rem;}
  .dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter {width: auto;padding-bottom: 5px;}
  /*Media Query*/
    @media (max-width: 1440px) {
      .container-table { max-width: 1180px;height: 500px; }
    }
    @media (max-width: 1280px) {
      .container-table { max-width: 1030px;height: 400px; }
      .container-table-bootstrap { max-width: 1000px; }
    }
    @media (max-height: 860px) {
      #divSubRamos, #divCompanias {height: 620px;}
      #containerTableModuloPermisos {height: 550px;}
      .divPestania {max-height: 780px;}
      .divContiene {height: 780px;}
      .container-table-archivos-promotoria {height: 650px;}
      .container-table-asignacion-coordinadores {height: 630px;}
      .container-table-causa-raiz {height: 580px;}
      .container-table-semaforo-actividades {height: 520px;}
      .container-table-cobranza {max-height: 600px;}
      .container-table-tab-modal {max-height: 530px;}
    }
    @media (max-height: 680px) {
      #divSubRamos, #divCompanias {height: 420px;}
      .divPestania {max-height: 600px;}
      .divContiene {height: 600px;}
      .container-table-archivos-promotoria {height: 520px;}
      .container-table-asignacion-coordinadores {height: 470px;}
      .container-table-causa-raiz {height: 430px;}
      .container-table-semaforo-actividades {height: 360px;}
      .container-table-cobranza {max-height: 430px;}
      .container-table-tab-modal {max-height: 350px;}
    }
</style>
<!----------------------------------------- JavaScript ----------------------------------------->
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-storage.js"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script type="module" src="<?php echo site_url('assets/js/jquery.tutorialmodule.js');?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="<?=base_url()?>/assets/gap/js/incidencias_tipo.table.js"></script>
<script src="<?=base_url()?>/assets/gap/js/persona_baja.table.js"></script>
<script src="<?php echo site_url('assets/js/metaComercial.js');?>"></script>
<script src="<?php echo site_url('assets/js/jQuery.cierreMensualComercial.js');?>"></script>
<script src="<?php echo site_url('assets/js/js_guionTelefonico.js');?>"></script>
<script type="text/javascript">
  const path = $("#base_url").attr("data-base-url");
  function mostrarHorasCompania() {
    $("#horasCompania").modal({
        show: true,
        keyboard: false,
        backdrop: false,
    });
  }
  var direccion=<?php echo('"'.base_url().'permisosOperativos/"'); ?>;
function guardarAsigancionParaCoordinadores(datos)
{
  if(datos=='')
  {
   let cb=document.getElementsByName('cbAsignacionParaCoordinadores');
   let cbCant=cb.length;
   let cadena="";
   for(let i=0;i<cbCant;i++){if(cb[i].checked){cadena=cadena+cb[i].value+',';} }
      console.log(cadena)
     parametros='idPersonaCoordinador='+document.getElementById('selectAsignacionCoordinadores').value;
     parametros=parametros+'&idPersonaHijo='+cadena;
     controlador="permisosOperativos/guardarAsignacionParaCoordinadores/?";
     peticionAJAX(controlador,parametros,'guardarAsigancionParaCoordinadores');
  }
  else
  {
    let select=document.getElementById('selectAsignacionCoordinadores');
    let selectCant=select.length;
    for(let i=0;i<selectCant;i++)
    {
      if(select[i].value==datos.idPersonaCoordinador){select[i].setAttribute('data-hijos',datos.hijosId);}
    }
    alert(datos.mensaje);
  }

}
function asignaCoordinadoresTabla(objeto)
{
 let coordinadoresCant=objeto.length
 let rows="";

 let valorIndex=objeto[objeto.selectedIndex].value;
 let data=objeto[objeto.selectedIndex].getAttribute('data-hijos').split(' ');
 let dataCant=data.length;
 console.log(data); 
if(valorIndex!=-1){
 for(let i=0;i<coordinadoresCant;i++)
 {
  if(valorIndex!=objeto.options[i].value ){
    if(objeto.options[i].value!=-1)
  {   
     let check="";  
    for(let j=0;j<dataCant;j++)
       {
         if(data[j]==objeto.options[i].value){check='checked';break;}
       }
     rows=rows+'<tr><td><input type="checkbox" class="form-check-input checkbox-item" value="'+objeto.options[i].value+'" name="cbAsignacionParaCoordinadores" '+check+' style="margin-top: 0px;"></td><td>'+objeto.options[i].text+'</td></tr>';}}
  } 
 }
 document.getElementById('bodyAsignacionCoordinadores').innerHTML=rows;
}
function validaEntero(objeto)
{
  objeto.value= parseInt(objeto.value);
  
}
function cantidadCaracteres(objeto)
{
  let texto=objeto.value;
  document.getElementById('labelTotal').innerHTML="Caracteres utilizados: "+texto.length;
  if(texto.length>299)
  {
    objeto.value=texto.substr(0,299);
    document.getElementById('labelTotal').innerHTML="Caracteres utilizados: "+299;
  }
  
}
function relacionaDocumentoPromotoria(objeto){
  if(document.getElementsByClassName('rowCompaniaDocumento').length>0){
     let status='';let params="";let insertar="";
       if(objeto.checked){insertar=1;}else{insertar=0;}
      params=params+'idPromotoria='+document.getElementsByClassName('rowCompaniaDocumento')[0].getAttribute('data-idpromotoria')+'&id='+objeto.parentNode.parentNode.getAttribute('data-id')+'&insertar='+insertar;
            controlador="permisosOperativos/relaciondocumentopromotoria/?";
      //peticionAJAX(controlador,params,'relaciondocumentopromotoria');

    
  }
  else{
    if(objeto.checked){objeto.checked=false}
    else{objeto.checked=true}
    alert('Debes escoger una compania');
  }
}
function documentoDelCliente(objeto){
  let status='';let params="";
   (objeto.checked)?status=1:status=0;
      params=params+'id='+objeto.parentNode.parentNode.getAttribute("data-id")+'&status='+status;
            controlador="permisosOperativos/documentoDelCliente/?";
      peticionAJAX(controlador,params,'documentoDelCliente');
}
function mensaje(datos)
{
  if(datos.success)
  {
    alert(datos.mensaje)
  }
}
function guardarPermisosDirectos(objeto)
{
   let params='';
   let select=document.getElementById('selectEmpleadoPermisos');
   let delet='';
   if(!objeto.checked){delet='&delete=1';}
   let email=select[select.selectedIndex].dataset.email;
      params=`account=${email}&idPersona=${select.value}&idPersonaPermiso=${objeto.value}${delet}`;
            controlador=`${objeto.dataset.controlador}?`;
     peticionAJAX(controlador,params,objeto.dataset.funcioncliente);
}
function agregarDocumentoNecesario(datos)
{
  if(datos=='')
  {  let params='';
      params=params+'&Documento='+document.getElementById('textPromotoriaDocumento').value;
            controlador="permisosOperativos/agregarDocumentoNecesario/?";
      peticionAJAX(controlador,params,'agregarDocumentoNecesario');
  }
  else
  {
    //
  //  let row=document.createElement('row');
    //row.setAttribute('data-id',datos.documento.idCatalogPromotoriaDocumento)
    let td='<td><input type="checkbox" onclick="relacionaDocumentoPromotoria(this)" class="checkDocumentoPromotoria"></td><td>'+datos.documento.documento+'</td><td><input type="checkbox" onclick="documentoDelCliente(this)"></td>';
    //row.innerHTML=td;
   document.getElementById('bodyDocumentoNecesario').insertRow(0);
   document.getElementById('bodyDocumentoNecesario').rows[0].setAttribute('data-id',datos.documento.idCatalogPromotoriaDocumento);
   document.getElementById('bodyDocumentoNecesario').rows[0].innerHTML=td;
    
  }
  
}
function guardarTareaEnvioMensajes(datos)
{
  if(datos=='')
  {let activo=0;
    if(document.getElementById('checkEnvioActivo').checked){activo=1;}
   parametros='mensage='+document.getElementById('textareaMensaje').value;
   parametros=parametros+'&activado='+activo;
   parametros=parametros+'&diasAntesVencimiento='+document.getElementById('inputDiasVencimiento').value;
   parametros=parametros+'&tipoFecha='+document.getElementById('opcionFecha').value;
   controlador="permisosOperativos/guardarTareaEnvioMensajes/?";

   peticionAJAX(controlador,parametros,'guardarTareaEnvioMensajes');
  }
  else
  {
    alert(datos.mensaje);
  }
}

function agregarCausaRaiz(datos){
 if(datos==""){
  let parametros='nombreCausaRaiz='+document.getElementById('textNombreACR').value;
  parametros=parametros+'&descripcionCausaRaiz='+document.getElementById('textDescripcionACR').value;
  peticionAJAX('procesamientoNC/causaRaiz',parametros,'agregarCausaRaiz');
 }else {
      
   document.getElementById('bodyACR').insertRow(0);
   document.getElementById('bodyACR').rows[0].setAttribute('data-idcausaraiz', datos.causaRaiz[0].idCausaRaiz)
   document.getElementById('bodyACR').rows[0].insertCell(0);
   document.getElementById('bodyACR').rows[0].insertCell(1);
  document.getElementById('bodyACR').rows[0].cells[0].innerHTML=datos.causaRaiz[0].causaRaiz;
  document.getElementById('bodyACR').rows[0].cells[1].innerHTML=datos.causaRaiz[0].descripcionCausaRaiz;
  llenaSelectCR();
 }
}
function agregarAccionCorrectiva(datos){
  if(datos==""){
  let parametros='nombreAccionCorrectiva='+document.getElementById('textNombreAAC').value;
  parametros=parametros+'&descripcionAccionCorrectiva='+document.getElementById('textDescripcionAAC').value;
  peticionAJAX('procesamientoNC/accionCorrectiva',parametros,'agregarAccionCorrectiva');
 }
 else {
     document.getElementById('bodyAAC').insertRow(0);  
   document.getElementById('bodyAAC').rows[0].setAttribute('data-idaccioncorrectiva', datos.accionCorrectiva[0].idAccionCorrectiva)
   document.getElementById('bodyAAC').rows[0].insertCell(0);
   document.getElementById('bodyAAC').rows[0].insertCell(1);
  document.getElementById('bodyAAC').rows[0].cells[0].innerHTML=datos.accionCorrectiva[0].accionCorrectiva;
  document.getElementById('bodyAAC').rows[0].cells[1].innerHTML=datos.accionCorrectiva[0].descripcionAccionCorrectiva;
  llenaSelectAC();
  }
}

function eliminaCausaRaiz(datos,idCausaRaiz=null)
{
  if(datos=='')
  {
    let parametros='idCausaRaiz='+idCausaRaiz;
    peticionAJAX('procesamientoNC/eliminaCausaRaiz',parametros,'eliminaCausaRaiz');
  }
  else
  {
   alert(datos.mensaje);
   let tabla=document.getElementById('bodyACR');
   let cant=tabla.rows.length;
   for(let i=0;i<cant;i++)
   {
    if(datos.idCausaRaiz==tabla.rows[i].getAttribute('data-idcausaraiz'))
    {
      tabla.deleteRow(i);
      i=cant;
    }
   }
  }
}
function eliminaAccionCorrectiva(datos,idAccionCorrectiva=null)
{
  if(datos=='')
   {
    let parametros='idAccionCorrectiva='+idAccionCorrectiva;
    peticionAJAX('procesamientoNC/eliminaAccionCorrectiva',parametros,'eliminaAccionCorrectiva');

   }
   else
   {
     alert(datos.mensaje);
        let tabla=document.getElementById('tableAAC');
   let cant=tabla.rows.length;
   for(let i=0;i<cant;i++)
   {
    if(datos.idAccionCorrectiva==tabla.rows[i].getAttribute('data-idaccioncorrectiva'))
    {
      tabla.deleteRow(i);
      i=cant;
    }
   }
   }
}



function peticionAJAX(controlador,parametros,funcion){

  var req = new XMLHttpRequest();var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador;//+parametros;
  //abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
      if(req.status == 200)
        {           
         var respuesta=JSON.parse(this.responseText); 
         switch(funcion){
          case 'agregarDocumentoNecesario':agregarDocumentoNecesario(respuesta);break;   
          case 'traeDocumentoDePromotoria':traeDocumentoDePromotoria(respuesta,'');break;          
          case 'guardarTareaEnvioMensajes':guardarTareaEnvioMensajes(respuesta);break; 
          case 'guardarAsigancionParaCoordinadores':guardarAsigancionParaCoordinadores(respuesta);break; 
          case 'agregarCausaRaiz':agregarCausaRaiz(respuesta);break;
          case 'agregarAccionCorrectiva':agregarAccionCorrectiva(respuesta);break;
          case 'eliminaCausaRaiz':eliminaCausaRaiz(respuesta);break;
          case 'eliminaAccionCorrectiva':eliminaAccionCorrectiva(respuesta);break;
          default:window[funcion](respuesta);  break;                                               
         }                                                           
      }     
   }
  };
 req.send(parametros);
}

function guardarModuloPermiso(){
  check=document.getElementsByClassName("classModuloPermiso");
  cant=check.length;
  var cadena="";
  for(var i=0;i<cant;i++){
     if(check[i].checked){
      cadena=cadena+check[i].value+';';
     }
  }
  
crearObjetosF(cadena,"moduloPermisos"); 
crearObjetosF(document.getElementById('selectEmpleadoPermisos').value,"idPersona"); 
crearObjetosF(document.getElementById('numeroCelular').value,"numeroCelular"); 
crearObjetosF(document.getElementById('instanciaCelular').value,"instanciaCelular"); 
crearObjetosF(document.getElementById('tokenCelular').value,"tokenCelular"); 
enviarFormGenerales('permisosOperativos/PermisoModuloPersona');

  
}

//Funcion creada por Dennis Castillo.
function despliegaAgregaMetasComerciales() {
  var obtiene=document.getElementById("listaActividades").value;
  var formEnvioDatos=document.createElement("form");//<form>
  formEnvioDatos.setAttribute('method','POST');  //<form method='POST'>
  formEnvioDatos.action="<?php echo ("".base_url()."permisosOperativos/guardarMetasComerciales")?>"; //guardarMetasComerciales
  var contenido=document.createElement('div');
  var botonSubmit=document.createElement('button'); //Creacion de un botón
  botonSubmit.setAttribute('type','submit'); //Asignación de tipo de funcion al botón
  botonSubmit.textContent='Guardar informacion';

  //Agregar metas mensuales.
  if (obtiene=='metaCM') {
    var tipo = document.createElement('input');
    tipo.setAttribute('type','hidden'); 
    tipo.setAttribute('name','tipo'); tipo.setAttribute('value','metaCM');
    contenido.innerHTML="<?php
      $meses=array('ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMRE');
      $tabla="<table style='border: 1px black solid;'><thead><tr><td style='border: 1px black solid;'>MES</td><td>Asignación de Meta Comercial</td></tr></thead>";
      $tabla=$tabla."<tbody style='border: 1px black solid;'>";
      for($i=0;$i<count($meses);$i++) {
        $tabla=$tabla."<tr style='border: 1px black solid;'><td style='border: 1px black solid;'>".$meses[$i]."</td><td>$ <input type='text' value='' name='metaMensual".$i."'></td></tr>";}
        $tabla=$tabla."</tbody</table>";
        echo $tabla;?>";
    formEnvioDatos.appendChild(tipo);
    formEnvioDatos.appendChild(contenido);
    formEnvioDatos.appendChild(botonSubmit);
    document.getElementById('contenidoMF').appendChild(formEnvioDatos);}

  //Agregar metas anuales.
  else if(obtiene=='metaCA') {
    var contenidoMCA=document.createElement('div');
    var tipo = document.createElement('input');
    tipo.setAttribute('type','hidden'); 
    tipo.setAttribute('name','tipo'); tipo.setAttribute('value','metaCA');
    contenidoMCA.innerHTML="<?php
      //$listaDeAnios="<select name='anio'>";
      $listaDeCoordinadores="<select name='coordinador'>";
      $datos=$this->personamodelo->devuelveCoordinadoresVentas();
      foreach($datos as $valor){
        $listaDeCoordinadores=$listaDeCoordinadores."<option value=".$valor->idPersona.">".$valor->nombres." ".$valor->apellidoPaterno. " ".$valor->apellidoMaterno." (".$valor->email.")</option>";}
      $listaDeCoordinadores=$listaDeCoordinadores."</select>";
      /*for($i=20;$i<=40;$i++){
        $listaDeAnios=$listaDeAnios."<option value='20".$i."'>20".$i."</option>";}
      $listaDeAnios=$listaDeAnios."</select>";*/
      $anioActual=date("Y");
      $tabla="<table style='margin: 0 auto;'><tr class='lMCA'><td>Meta comercial para el año</td></tr><tr class='lMCA'><td>".$anioActual."</td></tr><tr class='lMCA'><td><br>Asignación de meta a coordinador</td></tr><tr class='lMCA'><td>".$listaDeCoordinadores."</td></tr><tr class='lMCA'><td><br>Monto de meta anual en $</td></tr><tr class='lMCA'><td><input type=number value='' name='metaAnio'> MXN</td></tr></table>";
      //echo $tabla."<br>";?>";
    formEnvioDatos.appendChild(tipo);
    formEnvioDatos.appendChild(contenidoMCA);
    //formEnvioDatos.appendChild(botonSubmit);
    document.getElementById('contenidoMF').appendChild(formEnvioDatos);}
}




function escogePestania(hoja){
 var btnPestania = document.getElementsByClassName("btnPestania");
 var divHojas=document.getElementsByClassName("divHojaPestania");
 var cant=btnPestania.length;
 var cantHojas=divHojas.length;
 for(var i=0;i<cant;i++){
  btnPestania[i].classList.remove('btnPestaniaActiva');
  if(btnPestania[i].getAttribute('atributoClass')==hoja){btnPestania[i].classList.add('btnPestaniaActiva');}
   }
  /*if(objeto!=null){
  objeto.classList.add('btnPestaniaActiva');}
  else{
    btnPestania[0]
  }*/
 for(var i=0;i<cantHojas;i++){divHojas[i].classList.add('ocultarObjeto');divHojas[i].classList.remove('verObjeto');}
  document.getElementById(hoja).classList.add('verObjeto');
    document.getElementById(hoja).classList.remove('ocultarObjeto');
}
function asignarCompaniaRamo(){
check=document.getElementsByClassName("checkCompanias");cant=check.length
event.stopPropagation();idSubRamo=document.getElementById('hiddenIdSubRamo').value;;var companias="companias=";
  for(var i=0;i<cant;i++){if(check[i].checked){companias=companias+check[i].value+';';}}  
  conectaAJAX('asignarCompaniaRamo',companias+"&idSubRamo="+idSubRamo,0);
}
function guardarPermitidoPorRanking(){
  enviarForm(1,"guardarPermitidoPorRanking");
  /*var tabla=document.getElementById('tableRanking').childNodes[1];
  var cantidad=tabla.childNodes.length;
  var contiene="";
  for(var i=0;i<cantidad;i++){if(tabla.childNodes[i].classList.contains('subRamoSeleccionado')){contiene=i;}
  }    
  console.log(tabla.childNodes[contiene].cells[1]);*/
}
function guardarPuntaje(){
  enviarForm(2,"guardarPuntaje");
  /*var tabla=document.getElementById('tableRanking').childNodes[1];
  var cantidad=tabla.childNodes.length;
  var contiene="";
  for(var i=0;i<cantidad;i++){if(tabla.childNodes[i].classList.contains('subRamoSeleccionado')){contiene=i;}
  }     
  console.log(tabla.childNodes[contiene].cells[1]);*/
}

function conectaAJAX(controlador,parametros,procesoRespuesta){
  var req = new XMLHttpRequest();
 req.open('POST', direccion+controlador, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
       {
         var respuesta=JSON.parse(this.responseText);         
        switch(procesoRespuesta){
          case 0: alert("Los datos se guardaron correctamente");break;
          case 1:  cantidad=respuesta.length;
               if(cantidad>0){
                check=document.getElementsByClassName("checkCompanias");cant=check.length
               for(var i=0;i<cantidad;i++){
                    for(var j=0;j<cant;j++){if(respuesta[i].idPromotoria==check[j].value){check[j].checked=true;j=cant;}} 
                 }
                };
   break;
        }
       } 
       else
       {var respuesta=JSON.parse(this.responseText);}                                                       
   }
  };
 req.send(parametros);
}
function seleccionaRow(objeto)
{
  let clase=document.getElementsByClassName('rowCompaniaDocumento');
  let total=clase.length;
  for(let i=0;i<total;i++)
  {
    clase[i].classList.remove('rowCompaniaDocumento');
  }
  objeto.classList.add('rowCompaniaDocumento');
  traeDocumentoDePromotoria('',clase[0].getAttribute('data-idpromotoria'));
}
function traeDocumentoDePromotoria(datos,idPromotoria){
  if(datos==''){let params='';
  params=params+'idPromotoria='+idPromotoria;
            controlador="permisosOperativos/traeDocumentoDePromotoria/?";
      //peticionAJAX(controlador,params,'traeDocumentoDePromotoria');
}
else
{
  let check=document.getElementsByClassName('checkDocumentoPromotoria');
  let cant=check.length;
  let cantDatos=datos.documentoPromotorias.length;
    console.log(datos.documentoPromotorias[0])
  for(let i=0;i<cant;i++){check[i].checked=false;}
  for(let j=0;j<cantDatos;j++)
  {console.log(datos.documentoPromotorias);
    for(let i=0;i<cant;i++)
    {        
      if(check[i].parentNode.parentNode.getAttribute('data-id')==datos.documentoPromotorias[j].idCatalogPromotoriaDocumento){check[i].checked=true;}
    }
  } 

}
}
function rowSeleccionado(objeto){
  var padre=objeto.parentNode;
  var cantHijos=padre.childNodes.length;
  for(var i=0;i<cantHijos;i++){padre.childNodes[i].classList.remove('subRamoSeleccionado');}
  objeto.classList.add('subRamoSeleccionado');
  check=document.getElementsByClassName("checkCompanias");cant=check.length;
  for(var i=0;i<cant;i++){check[i].checked=false;}
}

function traeCompaniasSubRamo(idSubRamo,objeto){
document.getElementById("hiddenIdSubRamo").value=idSubRamo;rowSeleccionado(objeto);
conectaAJAX('devolverCompaniasAsignadas',"&idSubRamo="+idSubRamo,1);

} 
function escogerRanking(idSubRamo,objeto){
document.getElementById("hiddenRanking").value=idSubRamo;rowSeleccionado(objeto); 
}
//Cambios Edwin Marin
function escogerProspeccion(idSubRamo,objeto){
document.getElementById("hiddenPuntaje").value=idSubRamo;rowSeleccionado(objeto); 
}
function guardarCambioCartera(){
crearObjetosF(document.getElementById('textIDVen').value,"IDVend"); 
crearObjetosF(document.getElementById('textCli').value,"IDCli"); 
 enviarFormGenerales('permisosOperativos/guardarCambioCartera');
}
function traerPermisoModuloPersona($idPersona){
crearObjetosF($idPersona,"idPersona"); 
 enviarFormGenerales('permisosOperativos/PermisoModuloPersona');
}
function guardarCalificacion(){
crearObjetosF(document.getElementById('inputNombreCalificacion').value,"calificacionAgente"); 
 enviarFormGenerales('permisosOperativos/guardarCalificacion');
}
function modificarCalificacion(idCalificacionAgente){
crearObjetosF(idCalificacionAgente,"idCalificacionAgente"); 
crearObjetosF(document.getElementById("calificacion"+idCalificacionAgente).innerHTML,"calificacionAgente"); 
 enviarFormGenerales('permisosOperativos/guardarCalificacion');
 //console.log();
}
function guardarRamoPromotoria(objeto,id){
  var row=objeto.parentNode.parentNode;
  var cantCeldas=row.childNodes.length;
  var cadena="";
  for(var i=0;i<cantCeldas;i++){
    if(row.childNodes[i].getAttribute('enviaForm')!=null) 
    {
      crearObjetosF(row.childNodes[i].innerHTML,row.childNodes[i].getAttribute('enviaForm'));
    }
    crearObjetosF(id,'idRamoPromotoria');
    enviarFormGenerales('permisosOperativos/guardarRamoPromotoria');
    //console.log(cadena);
  }
  
}
function modificarStatusCalificacion(idCalificacionAgente,statusCalificacionAgente){
crearObjetosF(idCalificacionAgente,"idCalificacionAgente"); 
crearObjetosF(statusCalificacionAgente,"statusCalificacionAgente"); 
 enviarFormGenerales('permisosOperativos/guardarCalificacion');
}
function crearObjetosF(datos,nombre){
  var input=document.createElement('input');input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class', 'formAutomatico');input.setAttribute('name',nombre);document.body.appendChild(input);
}
function enviarFormGenerales(controlador){
  var direccion=<?php echo('"'.base_url().'";'); ?>;
  direccion=direccion+controlador;
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;formulario.setAttribute('name','miFormulario');formulario.setAttribute('id','miFormulario');
  objetosForm=document.getElementsByClassName('formAutomatico');objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++)
  {var objeto=document.createElement('input'); 
   objeto.setAttribute('value',objetosForm[i].value);
   objeto.setAttribute('name',objetosForm[i].name);
   objeto.setAttribute('type','hidden');
   formulario.appendChild(objeto); 
  }
  document.body.appendChild(formulario);
  formulario.submit();
}



function enviarForm(opcion,controlador){
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion+controlador; formulario.setAttribute('id','formEnviar')
    document.body.appendChild(formulario);
 switch(opcion){
 case 0:crearObjetosParaForm(document.getElementById("selectRamos").value,'idRamo'); 
 break;
 case 1:crearObjetosParaForm(document.getElementById("hiddenRanking").value,'ranking') ;
        crearObjetosParaForm(document.getElementById("textRanking").value,'numeroPermitido') 
 break; 
 //Cambios Edwin Marin
 case 2:crearObjetosParaForm(document.getElementById("hiddenPuntaje").value,'prospeccion') ;
        crearObjetosParaForm(document.getElementById("textPuntos").value,'numeroOtorgado') 
 break;
 }
  formulario.submit();
}
function crearObjetosParaForm(datos,nombre){
  var input=document.createElement('input');
  input.setAttribute('type','hidden');input.setAttribute('value',datos);input.setAttribute('class','enviarForm');input.setAttribute('name',nombre);
  document.getElementById('formEnviar').appendChild(input);
  //document.body.appendChild(input);
}
function guardarResponsable(idRamo)
{
 crearObjetosF(idRamo,"IDRamo"); 
 crearObjetosF(document.getElementById('selectEmpleado').value,"idPersona"); 
 enviarFormGenerales('permisosOperativos/asignaResponsableRamo'); 
}

  function pararRobot(datos,tipoRobot=null,comentario=null,objeto=null)
  {
    if(datos=='')
    {
       comentario=comentario.trim();
      if(objeto.value==0)
      {
       if(comentario=='')
       {
         alert('Necesita agregar un comentario para apagar el robot');
         return 0;
       }
      }
     parametros='estaFuncionando='+objeto.value;
     parametros=parametros+'&tipoRobot='+tipoRobot;
     parametros=parametros+'&comentario='+comentario;
     controlador="permisosOperativos/pararRobot/?";
     peticionAJAX(controlador,parametros,'pararRobot');
       
    }
    else
    {
      alert(datos.mensaje);
    }
  }
  function eliminarDiaNoLaboral(objeto)
  {
    let dia=objeto.parentNode.parentNode.dataset.dia;
    parametros='diaNoLaboral='+dia;
    parametros+=`&delete=1`;
     controlador="permisosOperativos/agregarDiaInhabil/?";
     peticionAJAX(controlador,parametros,'agregarDiaInhabil');
 
  }
  function agregarDiaInhabil(datos)
  {
   if(datos=='')
   {
     parametros='diaNoLaboral='+document.getElementById('dateDiaNoLaboral').value;
     controlador="permisosOperativos/agregarDiaInhabil/?";
     peticionAJAX(controlador,parametros,'agregarDiaInhabil');
 
   }
   else
   {
    if(datos.mensaje){alert(datos.mensaje)}
      let row='';    
      datos.diaNoLaboral.forEach(dia=>{
       row+=`<tr data-dia="${dia.diaNoLaboral}"><td><input type="date" class="form-control" value="${dia.diaNoLaboral}" style="text-align: center;width: auto;" disabled></td><td><button onclick="eliminarDiaNoLaboral(this)" class="btn btn-danger">Eliminar día</button></td><tr>`;
      })
      document.getElementById('bodyDiaNoLaboral').innerHTML=row;
      /*$('#TablaDiaInhabil').DataTable({
          language: {
              url: `${path}assets/js/espanol.json`
          },
          dom: '<"toolbar toolbar-table-inhabil">rtip ',
          initComplete: function(row) {
              var tmp = `
              <div></div>`
              $('div.toolbar-table-inhabil').html(tmp);
          },
          //ordering: false,
      });*/
    
   }
  }
  function inicializaValores()
  {
    document.getElementById('selectEstadoRobotActividades').value="<?=$estadoRobotActividades?>";
    parametros='';
    controlador="permisosOperativos/agregarDiaInhabil/?";
    peticionAJAX(controlador,parametros,'agregarDiaInhabil');

   let responsablesCobranza=document.getElementsByClassName('responsablesCobranza');
   for(let val of responsablesCobranza)
   {
    val.addEventListener('click',obj=>{
      if(document.getElementById('selectPermisoCobranza').value!='SELECCIONAR')
      {
      parametros=`userEmail=${document.getElementById('selectPermisoCobranza').options[document.getElementById('selectPermisoCobranza').selectedIndex].getAttribute('data')}&idPersona=${document.getElementById('selectPermisoCobranza').value}&tipoPermiso=${obj.target.dataset.valor}`
          controlador="permisosOperativos/guardarPermisoCobranza/?";
    peticionAJAX(controlador,parametros,'traerResponsablesCobranzaDespuesGrabado');
      }
      else
      {
        alert('ESCOGER A UN COLABORADOR');
      }
      
    })
   }

  }
inicializaValores();
</script>
<script>
  
  $(document).on("click", ".goal-agent-assigned", function(){
    console.log("hi world");

    const idPersona = $(this).data("persona");
    const meta = $(this).data("metas");
    $.ajax({
      type:"GET",
      url: `${direccion}devuelveMetasMensuales`,
      data: {
        q: meta,
        r: idPersona,
        a: 1
      },
      error: function(error){
        console.log(error);
      },
      success:  function(data){
        //console.log(data);
        const response = JSON.parse(data);
        console.log(response);
        const agents = response.agents;
        const totalAgents = Object.values(agents).reduce((acc, curr) => acc + curr, 0);
        const monthsValues = response.mensualidades;
        var content = ``;

        $("#assigToAgent").html();
        //mensual
        for(var a in monthsValues){

          var goalsForAgents = ``;
          for(var b in agents){

            validateGoal = monthsValues[a] / totalAgents;
            var goalAssigned = 0;

            switch(b){
              case "BRONCE": goalAssigned = 2500;//validateGoal;
                break;
              case "ORO":
              case "PLATINO VIP": goalAssigned = validateGoal; //validateGoal > 2500 ? goalAssigned = validateGoal : goalAssigned = 2500;
                break;
            }

            goalsForAgents += `<div class="col-md-12"><p>${b}: <span class="text-info">$${(Math.round(goalAssigned)).toLocaleString("en-US")}</span></p></div>`;
          }

          content += `
            <div class="col-md-4">
              <div class="panel panel-body">
                ${mensual[a]}
                <hr>
                <p>Meta: <span class="text-info"> $${parseFloat(monthsValues[a]).toLocaleString("en-US")}</span></p>
                <p>Meta para asignar:</p>
                  <div>${goalsForAgents}</div>
              </div>
            </div>
          `;
        }
        $("#assigToAgent").html(`
          <input type="hidden" value="${idPersona}" id="coorId">
          <div class="col-md-12">
            <div>
              <div class="col-md-12"><h4>Meta anual: $ ${parseFloat(response.metaTotal).toLocaleString("en-US")}</h4></div>
              <div class="col-md-12"><h4>Total de agentes: ${totalAgents} agentes</h4></div>
            </div>
            <div style="margin-top: 30px">${content}</div>
          </div>
        `);

        $(".goalsForAssigned").modal({
          show: true,
          backdrop: false
        });
      }
    });
  });

  //---------------------------------
  $(document).on("click", ".assignGoal", function(){

    const id_ = $("#coorId").val();

    const ajax = $.ajax({
      type:"POST",
      url: `${direccion}assignNewSalesGoal`,
      data: {
       id: id_
      },
      error: (error) => {
        console.log(error);
      },
      success: (data) => {
        const response = JSON.parse(data);
        console.log(response);

        alert(response.message);
        if(response.bool){
          $(".goalsForAssigned").modal("hide");
        }
      }
    });
  });
  //---------------------------------


//Miguel Jaime 08/07/2022 
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
function guardarPuntos(){
  var base=document.getElementById('base').value
  let punto=document.getElementById('punto').value;
  divPuntosValoracion=document.getElementById('divPuntosValoracion');
  if(punto!=""){
    ajax=objetoAjax();   
    var URL=base+"permisosOperativos/savePuntoValoracion?punto="+punto;
    ajax.open("GET", URL);
    ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      divPuntosValoracion.innerHTML = ajax.responseText
        swal("El Punto ha sido guadado con exito!");
      }
    }
  ajax.send(null)
  }else{
     swal("Validacion","Debe ingresar un punto!","error");
  }  
}

function eliminarPunto(id){
  var op=confirm("¿Esta seguro de eliminar este punto de valoración?");
  if(op==1){
    var base=document.getElementById('base').value
    divPuntosValoracion=document.getElementById('divPuntosValoracion');
      ajax=objetoAjax();   
      var URL=base+"permisosOperativos/delPuntoValoracion?id="+id;
      ajax.open("GET", URL);
      ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
          divPuntosValoracion.innerHTML = ajax.responseText
          swal("El Punto ha sido eliminado!");
        }
      }
    ajax.send(null)
  }
}

//---------------------------------------------------- PHP ----------------------------------------------------------
<?php
function generaOption($array,$nombre,$id,$nombreObjeto){
 $option='<option value="-1">Escoger</optioni>';$asignar='document.getElementById("'.$nombreObjeto.'").innerHTML=';
 foreach ($array as  $value) {$option=$option.'<option value="'.$value[$id].'">'.$value[$nombre].'</option>';}
 $asignar=$asignar.'\''.$option.'\';';
 return $asignar;
}

function imprimirCausaRaiz($datos)
{
 $tbody="";
 foreach ($datos as  $value) 
 {
  $tbody.='<tr data-idcausaraiz="'.$value->idCausaRaiz.'">';
  $tbody.='<td>'.$value->causaRaiz.'</td>';
  $tbody.='<td>'.$value->descripcionCausaRaiz.'</td>';
  $tbody.='<td><button onclick="eliminaCausaRaiz(\'\','.$value->idCausaRaiz.')" class="btn btn-danger"><i class="fa fa-minus" style="color: azure;"></i></button></td>';
  $tbody.='</tr>';
 }
return $tbody;
}
function imprimirAccionCorrectiva($datos)
{
  $tbody="";
  foreach ($datos as  $value) 
  {
   $tbody.='<tr data-idaccioncorrectiva="'.$value->idAccionCorrectiva.'">';
   $tbody.='<td>'.$value->accionCorrectiva.'</td>';
   $tbody.='<td>'.$value->descripcionAccionCorrectiva.'</td>';
   $tbody.='<td><button onclick="eliminaAccionCorrectiva(\'\','.$value->idAccionCorrectiva.')" class="btn btn-danger"><i class="fa fa-minus" style="color: azure;"></i></button></td>';
   $tbody.='</tr>';
  }
  return $tbody;
}
?>

<?php 
function imprimirDocumentos($datos){
  $thead='<thead><tr><th>Asigna a Compañía</th><th>Documento</th><th>Documento de Cliente</th></tr></thead>';  
  $tbody='<tbody id="bodyDocumentoNecesario">';
  foreach ($datos as $value) {
    $tbody.='<tr data-id="'.$value->idCatalogPromotoriaDocumento.'">';
    $tbody.='<td><input type="checkbox" class="form-check-input checkbox-item checkDocumentoPromotoria" onclick="relacionaDocumentoPromotoria(this)" style="margin-top: 0px;"></td>';
    $tbody.='<td>'.$value->documento.'</td>';
    
    ($value->personal==1)?$tbody.='<td><input type="checkbox" class="form-check-input checkbox-item" onclick="documentoDelCliente(this)" style="margin-top: 0px;" checked>
      </td>':$tbody.='<td><input type="checkbox" class="form-check-input checkbox-item" onclick="documentoDelCliente(this)" style="margin-top: 0px;"></td>';
    $tbody.='</tr>';
  }
  $tbody.='</tbody>';
  return $thead.$tbody;
}
function imprimirCompanias($datos){
  $thead='<thead style="position:sticky; top:0px;"><tr><th>Compañía</th></tr></thead>';
  $tbody='<tbody>';
  foreach ($datos as  $value) {
     $tbody.='<tr onclick="seleccionaRow(this)" data-idpromotoria="'.$value->idPromotoria.'">';
      $tbody.='<td>'.$value->Promotoria.'</td>';
      $tbody.='<tr>';
      }
   $tbody.='</tbody>';
  return $thead.$tbody;
}
function imprimirCoordinadores($datos,$datosHijos)
{
$option="";
 
  $option.='<option value="-1">SELECCIONAR</option>';
    foreach ($datos as $key1 => $value1) {
  
    $option.='<optgroup label="'.$value1['Name'].'">';
    foreach ($value1['Data'] as $key => $value) 
    {
      
     if($value['esCoordinador']==1)
     {
      $data="";
      foreach ($datosHijos as $valueHijos) {if($value['idPersona']==$valueHijos->idPersonaCoordinador){$data.=$valueHijos->idPersonaHijo.' ' ;}
        
      }
      $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
      $option.='<option value="'.$value['idPersona'].'" data-correo="'.$value['email'].'" data-hijos="'.$data.'">'.$nombres.' <label>     ('.$value['email'].')</label></option>';  
     }

  }
    $option.='</optgroup>';
  
  }  
  return $option;
}
function imprimirEmpleados($datos){
  $option="<option>SELECCIONAR</option>";

  
    foreach ($datos as $key1 => $value1) {
  
    $option.='<optgroup label="'.$value1['Name'].'">';
    foreach ($value1['Data'] as $key => $value) 
    {
     $nombres=$value['apellidoPaterno'].' '.$value['apellidoMaterno'].' '.$value['nombres'];
   $option.='<option value="'.$value['idPersona'].'" data-email="'.$value['email'].'" data="'.$value['email'].'">'.$nombres.' <label>     ('.$value['email'].')</label></option>';  
    }
    $option.='</optgroup>';
   
  }

  return $option;
}

function imprimirConfiguracionDeCorreos($datos)
{

  $row="";
    if($datos!=""){ 
  $row.='<tr><td>Permiso</td><td>Modificar</td><td></td></tr>';
  
  foreach ($datos as  $value) {
    $row.='<tr>';
        $row.='<td>'.$value->nombrePersonaPermiso.'</td>';
        $row.='<td>'.$value->descripcionPermiso.'</td>';
        if($value->permite==0){
        $row.='<td><input type="checkbox"  class="classModuloPermiso"  value="'.$value->idPersonaPermiso.'" ></td>';
        }else{
          $row.='<td><input type="checkbox" class="classModuloPermiso" value="'.$value->idPersonaPermiso.'" checked></td>';
        }
    $row.='</tr>';

  }
    $row.='<tr><td colspan="3"><button class="btn-primary" onclick="guardarModuloPermiso()">Guardar</button></td></tr>';
  } 

 return $row; 
}
function imprimirModuloPermisos_copia($datos){
  

  $row="";$correos='<tr><td colspan="3" align="center">Permiso de Correos</td></tr>';
    if($datos!=""){ 
  $row.='<tr><td>Permiso</td><td>Modificar</td><td></td></tr>';
  
  foreach ($datos as  $value) {
    if($value->tipoPermiso!='correo' || $value->tipoPermiso!='correos')
    {
     $row.='<tr>';
        $row.='<td>'.$value->nombrePersonaPermiso.'</td>';
        $row.='<td>'.$value->descripcionPermiso.'</td>';
        if($value->permite==0){
        $row.='<td><input type="checkbox"  class="classModuloPermiso"  value="'.$value->idPersonaPermiso.'" ></td>';
        }else{
          $row.='<td><input type="checkbox" class="classModuloPermiso" value="'.$value->idPersonaPermiso.'" checked></td>';
        }
    $row.='</tr>';
    } elseif($value->tipoPermiso =='showDirect'){

    }
    else
    {
     $correos.='<tr>';
        $correos.='<td>'.$value->nombrePersonaPermiso.'</td>';
        $correos.='<td>'.$value->descripcionPermiso.'</td>';
        if($value->permite==0){
        $correos.='<td><input type="checkbox"  class="classModuloPermiso"  value="'.$value->idPersonaPermiso.'" ></td>';
        }else{
          $correos.='<td><input type="checkbox" class="classModuloPermiso" value="'.$value->idPersonaPermiso.'" checked></td>';
        }
    $correos.='</tr>';


    }

  }
    $row.=$correos.'<tr><td colspan="3"><button class="btn-primary" onclick="guardarModuloPermiso()">Guardar</button></td></tr>';
  } 
 return $row;
}

/**
 * Imprime el conjunto de permisos del modulo como una lista expandible
 * 
 * @param $datos - Arreglo con los datos de los permisos a procesar
 * @return string - Devuelve una cadena de texto con los permisos organizados en secciones
 */
function imprimirModuloPermisos($datos)
{
  try {
    // Creamos el arreglo donde guardaremos los permisos por tipo
    $permisos = array(
      'base' => array(),
      'correos' => array(),
      'directorio' => array(),
      'cobranza' => array(),
    );

    // Agrupamos los permisos por tipo
    if ($datos == "") {
      $datos = [];
    }
    foreach ($datos as $permiso) {
      switch ($permiso->vista) {
        case 'cobranza':
        case 'cancelarCobranza':
          array_push($permisos[ 'cobranza' ], $permiso);
          break;
        default:
          if ($permiso->tipoPermiso == 'correo') {
            array_push($permisos[ 'correos' ], $permiso);
          } elseif (in_array($permiso->tipoPermiso, [ 'directory', 'clienteN' ])) {
            array_push($permisos[ 'directorio' ], $permiso);
          } else {
            array_push($permisos[ 'base' ], $permiso);
        }
        }
    }

    // Creamos las distintas secciones para cada tipo de permiso
    $seccion_base = crearSeccionPermisos($permisos[ 'base' ], 'Modulo');
    $seccion_cobranza = crearSeccionPermisos($permisos[ 'cobranza' ], 'Cobranza');
    $seccion_correos = crearSeccionPermisos($permisos[ 'correos' ], 'Correos');
    $seccion_directorio = crearSeccionPermisos($permisos[ 'directorio' ], 'Directorio');

    $btn_guardar = '<button class="btn btn-success" onclick="guardarModuloPermiso()">Guardar permisos</button>';

    return $seccion_base . "<br/>" . $seccion_cobranza . "<br/>" . $seccion_correos . "<br/>" . $seccion_directorio . "<br/>" . $btn_guardar;
  } catch (Exception $e) {
    return "<div>Error al cargar los permisos</div>";
  }
}

/**
 * Crea una lista expandible para un conjunto de permisos
 * 
 * @param $permisos - Arreglo con los permisos a procesar
 * @param $nombre - Nombre de la seccion a crear
 * @return string - Devuelve una cadena de texto con el html de la seccion generada
 */
function crearSeccionPermisos($permisos, $nombre){
    $seccion = '<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse'.$nombre.'" aria-expanded="false" aria-controls="collapse'.$nombre.'">'.$nombre.'</button></br>';
    $seccion .= '<div class="collapse" id="collapse'.$nombre.'" style="width: 100%;"><div class="well well-sm">';

    $seccion .= '<table class="table table-style" id="tableModulo'.$nombre.'" border="2"  class="table">';
    $seccion .= '<thead><tr><th align="center">Permisos de '.$nombre.'</th><th align="center">Descripción</th><th align="center">Activo</th></tr></thead><tbody class="permisosTBody">';
    foreach ($permisos as $permiso) {
      $checked = $permiso->permite == 1 ? 'checked' : '';
      $checkboxHTML = '<td><div class="checkbox-center"><input type="checkbox" class="form-check-input checkbox-item classModuloPermiso" value="' . $permiso->idPersonaPermiso . '" style="margin-top: 0px;" ' . $checked . '></div></td>';
      $line = "<tr><td>{$permiso->nombrePersonaPermiso}</td><td>{$permiso->descripcionPermiso}</td>$checkboxHTML</tr>";
      $seccion .= $line;
    }
    $seccion .= "</tbody>";
    $seccion .= "</table>";

    $seccion .= "</div></div>";

    return $seccion;
}

function imprimirTablaRamos($datos){

  $celdas='<thead class="table-thead"><tr><th>Ramo</th><th>Responsable</th><th></th></tr></thead>';
foreach ($datos as  $value) {
  $celdas.='<tr><td>'.$value['nombre'].'</td><td>'.$value['emailResponsable'].'</td><td><button class="btn btn-primary" onclick="guardarResponsable(\''.$value['idRamo'].'\')">Guardar</button></td></tr>';
}
 return $celdas;
}

  function devuelveRamoPromotoria($ramoPromo,$permission){ //Modificado [Suemy][2024-07-23]
    $cadena='<thead class="table-thead"><tr style="background-color: #361666;font-size:11px;"><td>N°</td><td style="width:5%">Promotoria</td><td style="width:5%">Ramo</td><td style="width:5%">SubRamo</td><td style="width:0.6%">Cotización Portal</td><td  style="width:0.8%">Cotización Oficina</td><td style="width:1%">Emisión Port.</td><td style="width:1%">Emisión Ofic.</td><td style="width:1%">Endoso A Ofic.</td><td style="width:1%">Endoso B Ofic.</td><td style="width:1%">Endoso D Ofic.</td><td style="width:1%">Cancelac. Ofic.</td><td style="width:1%">Captura Port.</td><td colspan="2" align="center" style="width:5%"><i class="fa fa-cogs"></i></td></tr></thead><tbody id="bodyTableHoraCompania" style="font-size:1.2rem;">';
    foreach ($ramoPromo as $key => $values) {
      $num = $key + 1;
        $cadena .= '<tr class="show-horaRamoPromotoria hc-promo hc-ramo hc-subramo" data-id="'.$values->idRamoPromotoria.'" data-promo="'.$values->idPromotoria.'" data-ramo="'.$values->idRamo.'" data-subramo="'.$values->idSubRamo.'" data-num="'.$num.'">';
        $cadena .= '<td>'.$num.'</td>';
        $cadena .= '<td style="width:1.4%">'.$values->Promotoria.'</td>';
        $cadena .= '<td style="width:1.1%">'.$values->Ramo.'</td>';
        $cadena .= '<td style="width:1.1%">'.$values->SubRamo.'</td>';
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasPortalCotizacion.'" enviaForm="horasPortalCotizacion" align="right" contenteditable="true" style="width:1%">'.$values->horasPortalCotizacion.'</td>';  
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaCotizacion.'" enviaForm="horasOficinaCotizacion" align="right" contenteditable="true" style="width:1%">'.$values->horasOficinaCotizacion.'</td>';  
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasPortalEmision.'" enviaForm="horasPortalEmision" align="right" contenteditable="true" style="width:1%">'.$values->horasPortalEmision.'</td>';  
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaEmision.'" enviaForm="horasOficinaEmision" align="right" contenteditable="true" style="width:1%">'.$values->horasOficinaEmision.'</td>';
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaEndosos.'" enviaForm="horasOficinaEndosos" align="right" contenteditable="true" style="width:1%">'.$values->horasOficinaEndosos.'</td>'; 
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaEndososB.'" enviaForm="horasOficinaEndososB" align="right" contenteditable="true" style="width:1%">'.$values->horasOficinaEndososB.'</td>';
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaEndososD.'" enviaForm="horasOficinaEndososD" align="right" contenteditable="true" style="width:1.2%">'.$values->horasOficinaEndososD.'</td>';
        $cadena .= '<td name="horaRamoPomotoria" value="'.$values->horasOficinaCancelaciones.'" enviaForm="horasOficinaCancelaciones" align="right" contenteditable="true" style="width:1.4%">'.$values->horasOficinaCancelaciones.'</td>';
        $cadena .= '<td name="horaRamoPomotoria" value="'.isset($values->horas) ? null : $values->horas.'" enviaForm="horasPortalCaptura" align="right" contenteditable="true" style="width:1%">'.$values->horasPortalCaptura.'</td>'; 
        $cadena .= '<td style="width:1.6%"><button class="btn btn-hrsComp btn-sm" onclick="guardarHoraRamoPromotoria('.$values->idRamoPromotoria.')"><i class="fa fa-check-circle"></i>&nbsp;<span style="font-size:12px;">Guardar</span></button></td>';
        if ($permission == 1) {
          $cadena .= '<td style="width:1.6%"><button class="btn btn-hrsComp btn-sm" onclick="seguimientoHoraRamoPromotoria('.$values->idRamoPromotoria.')"><i class="far fa-eye"></i>&nbsp;<span style="font-size:12px;">Ver Cambios</span></button></td>';
        }
        $cadena .= '</tr>';
    }
    $cadena .= '</tbody>'; 
    return $cadena;
  }

function devuelveCalificaciones($calificacionAgent){
  $cadena="";
  
  foreach ($calificacionAgent as  $value) {
    $cadena=$cadena."<tr>";
    if($value->statusCalificacionAgente==1){$cadena=$cadena.'<td contenteditable="true" class="habilitado" id="calificacion'.$value->idCalificacionAgente.'">'.$value->calificacionAgente."</td>";
      $cadena=$cadena.'<td class="column-flex-item-center" style="border:none;border-top: 1px solid #dfdfdf;">
          <div class="checkbox-center">
              <input class="form-check-input checkbox-item" onclick="modificarStatusCalificacion('.$value->idCalificacionAgente.',0)" type="checkbox" style="margin-top: 0px;" checked>
          </div>
        </td><td ><button class="btn btn-primary" onclick="modificarCalificacion('.$value->idCalificacionAgente.')">Guardar</button></td>';}
        else{$cadena=$cadena.'<td contenteditable="true" class="noHabilitado" id="calificacion'.$value->idCalificacionAgente.'">'.$value->calificacionAgente."</td>";
        $cadena=$cadena.'<td class="column-flex-item-center" style="border:none;border-top: 1px solid #dfdfdf;">
          <div class="checkbox-center">
              <input class="form-check-input checkbox-item" onclick="modificarStatusCalificacion('.$value->idCalificacionAgente.',1)" type="checkbox" style="margin-top: 0px;">
          </div>
        </td><td ><button class="btn btn-primary" onclick="modificarCalificacion('.$value->idCalificacionAgente.')">Guardar</button></td>';}
    $cadena=$cadena."</tr>";
  }
  return $cadena;
}
echo(generaOption($ramos,"nombre",'idRamo','selectRamos'));
$table="";
$table='<table class=\'table table-style\' id=\'tableRanking\' border=\'1\'><thead><tr><td style=\'color: white;\'>Ranking</td><td style=\'color: white;\'>Número compañías permitidas</td></tr></thead><tbody>';
foreach ($rankings as  $value) {
  $table=$table.'<tr onclick=\'escogerRanking(\"'.$value->personaRankingAgente.'\",this)\'>';
  $table=$table.'<td>'.$value->personaRankingAgente.'</td>';
  $table=$table.'<td align=\'right\'>'.$value->companiasPermitidasPRA.'</td>';
  $table=$table.'</tr>';
}
$table=$table."</tbody></table>";
echo('document.getElementById(\'Container-Ranking\').innerHTML="'.$table.'";');
//Cambios Edwin Marin
$table2="";
$table2='<table class=\'table table-style\' id=\'tableRanking\' border=\'1\'><thead><tr><td style=\'color: white;\'>Prospecci&oacute;n</td><td style=\'color: white;\'>Puntos otorgados</td></tr></thead><tbody>';
foreach ($prospeccion as  $puntos) {
  $table2=$table2.'<tr onclick=\'escogerProspeccion(\"'.$puntos->prospeccion.'\",this)\'>';
  $table2=$table2.'<td>'.$puntos->prospeccion.'</td>';
  $table2=$table2.'<td align=\'right\'>'.$puntos->puntosOtorgados.'</td>';
  $table2=$table2.'</tr>';
}
$table=$table."</tbody></table>";
echo('document.getElementById(\'Container-Puntos\').innerHTML="'.$table2.'";')
?>
<?php
 if(isset($idRamo)){echo('document.getElementById("selectRamos").value="'.$idRamo.'";');}
 if(isset($subRamos)){echo('document.getElementById("divSubRamos").innerHTML=\''.$subRamos.'\';');
?>$('#subRamo-Guardar').removeClass('hidden');<?}
 if(isset($companias)){echo('document.getElementById("divCompanias").innerHTML=\''.$companias.'\';');}
  if(isset($idPersonaPermisosModulos)){echo('document.getElementById("selectEmpleadoPermisos").value="'.$idPersonaPermisosModulos.'";');}
?>

<?
 if(isset($pestania)){echo('escogePestania("'.$pestania.'");');}else{
?>


    /*let event = new Event("change");
      document.getElementById('documentoDataListInput').dispatchEvent(event);*/
      if(document.getElementsByClassName('btnPestania').length>0)
      {
        let event = new Event("click");
      document.getElementsByClassName('btnPestania')[0].dispatchEvent(event);
        
      }
<?}?>

function traerResponsablesCobranza(datos='')
{
   if(datos=='')
   {
     controlador="cobranza/devolverResponsablesCobranza/?";
     peticionAJAX(controlador,parametros,'traerResponsablesCobranza');  
   }
   else
   {
    
    (datos.responsableCobranza.length==0)? document.getElementById('responsableCobranzaDiv').innerHTML='SIN RESPONSABLE' : document.getElementById('responsableCobranzaDiv').innerHTML=datos.responsableCobranza[0].userEmail;
     (datos.responsableFactura.length==0)? document.getElementById('responsableFacturaDiv').innerHTML='SIN RESPONSABLE' : document.getElementById('responsableFacturaDiv').innerHTML=datos.responsableFactura[0].userEmail;
   }
}

function traerResponsablesCobranzaDespuesGrabado(datos='')
{
 traerResponsablesCobranza('');  
}
traerResponsablesCobranza('');
</script>
<script type="text/javascript">
  function traerNumeroEmpresa(idPersona){
      var parametros={
            "idPersona": idPersona,
              };
        $.ajax({
            data: parametros,
            url: <?php echo('"'.base_url().'permisosOperativos/obtenerNumeroEmpresa"'); ?>,
            method: 'POST',
            success: function(data) {
              console.log(data);
              const dataObj=JSON.parse(data);
              console.log(dataObj);
              document.getElementById("numeroSMS").value = dataObj[0].celOficina;     
            }
        });

  }
  function guardarCelSMS(idPersona){
    celular=document.getElementById("numeroSMS").value;
    var parametros={
      "numero": celular,
      "idPersona": idPersona,
    }
      $.ajax({
            data: parametros,
            url: <?php echo('"'.base_url().'permisosOperativos/guardarNumeroSMS"'); ?>,
            method: 'POST',
            success: function(data) {
              console.log(data);
              if(data){
                 swal("El número se ha sido guadado con exito!");
              }else{
                swal("Error","Hubo un problema al guardar el numero","error");
              }
            }
        });
  }

//-----------------------------------------------------------------------------------------------------------
  //SubMódulo: Horas Compañía | Creado [Suemy][2024-07-23]
  $(document).ready(function() {
    getCountResultHoraRamoPromotoria();

    $('td[name="horaRamoPomotoria"]').keyup(function() {
      const val = $(this).attr('value');
      const text = $(this).html();
      if (text != val) {
        $(this).addClass('save_changes_horaPromotoria');
      }
      else {
        $(this).removeClass('save_changes_horaPromotoria');
      }
    })

    $('#filterTableTHRP').keyup(function() {
      const val = $(this).val().toUpperCase();
      filterTable(val,"bodyTableTrainingHoraPromotoria","show-training-horas-compania");
    })
  })

  const baseUrl = '<?=base_url()?>permisosOperativos';

  function guardarHoraRamoPromotoria(id = null) {
    const type = (id != null) ? 'individual' : 'all';
    const find = (id != null) ? '[data-id="'+id+'"]' : "";
    let td = $('.show-horaRamoPromotoria' + find).find('td');
    let update = [];
    //console.log(tr);
    for (i=0;i<td.length;i++) {
      if ($(td[i]).hasClass('save_changes_horaPromotoria')) {
        let add = {};
        add['id'] = $(td[i]).parent().data('id');
        add['celda'] = $(td[i]).attr('enviaform');
        add['value'] = $(td[i]).html();
        update.push(add);
      }
    }
    //console.log(update);
    if (update != 0) {
      const num = (id != null) ? $('.show-horaRamoPromotoria[data-id="'+id+'"]').data('num') : "";
      const msg = (id != null) ? ('Se guardará la información de la fila ' + num) : 'Se actualizará la información de todos los cambios realizados.';
      swal({
        title: "¿Desea guardar los cambios?",
        text: msg,
        icon: "warning",
        buttons: ["Cancelar", "Aceptar"],
      }).then((value) => {
        if (value) {
          $.ajax({
            type: 'POST',
            url: `${baseUrl}/saveHourRamoPromotoria`,
            data: {
              up: update
            },
            beforeSend: (load) => {
            },
            success: (data) => {
              const r = JSON.parse(data);
              console.log(r);
              let dd = r['data'];
              const title = (id != null) ? "¡Guardado!" : "¡Hecho!";
              const message = (id != null) ? "Los cambios se guardaron exitósamente." : "Todos los cambios fueron actulizados."
              if (dd != 0) {
                swal(title, message, "success");
                for (a in dd) {
                  let trtd = $('.show-horaRamoPromotoria[data-id="'+dd[a].idRamoPromotoria+'"]').find('td[enviaform="'+dd[a].celda+'"]');
                  $(trtd).removeClass('save_changes_horaPromotoria');
                  $(trtd).addClass('update_horaPromotoria');
                  $(trtd).attr('value',dd[a].value);
                }
              }
              else {
                swal("¡Uups!", "Parece que hay problemas al tratar de guardar.", "error");
              }
            },
            error: (error) => {
              console.log(error);
              swal("¡Vaya!", "Se ha encontrado un error al intentar guardar la información.", "error");
            }
          })
        }
      })
    }
    else { swal("¡Sin cambios!", "No hay nada que guardar.", "warning"); }
  }

  function seguimientoHoraRamoPromotoria(id = null) {
    var colspan = (id != null) ? 6 : 9;
    var promo, ramo, subramo;
    if (id != null) {
      let td = $('.show-horaRamoPromotoria[data-id="'+id+'"]').find('td');
      promo = td[1].innerHTML;
      ramo = td[2].innerHTML;
      subramo = td[3].innerHTML;
    }
    var ind = (id != null) ? `
      <div class="col-md-12 column-flex-center-center pd-left pd-right">
        <div class="pd-side">
          <label class="textSizeLabel mg-right">Promotoria:</label>
          <label class="textForm" id="nameHRP">${promo}</label>
        </div>
        <div class="pd-side">
          <label class="textSizeLabel">Ramo:</label>
          <label class="textForm" id="ramoHRP">${ramo}</label>
        </div>
        <div class="pd-side">
          <label class="textSizeLabel">SubRamo:</label>
          <label class="textForm" id="subramoHRP">${subramo}</label>
        </div>
      </div>
    ` : "";
    $('#contIndHRP').html(ind);
    $('#filterTableTHRP').val("");
    $(".segumiento-hr-comp-modal").modal({
      show: true,
      keyboard: false,
      backdrop: false,
    });

    $.ajax({
      type: "GET",
      url: `${baseUrl}/getTrainingHoraRamoPromotoria`,
      data: {
        id: id
      },
      beforeSend: (load) => {
        $('#tableTrainingHoraPromotoria').html(`
          <tr>
            <td colspan="${colspan}">
              <div class="container-spinner-content-loading">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden"></span>
                </div>
                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
              </div>
            </td>
          </tr>
        `);
      },
      success: (data) => {
        const r = JSON.parse(data);
        //console.log(r);
        let tr = r['training'];
        var table = (id != null) ? `
          <thead>
            <tr class="tr-style" style="font-size:11px;">
              <th>N°</th>
              <th>Campo</th>
              <th>Valor Agregado</th>
              <th>Lapso de Tiempo</th>
              <th>Hecho Por</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody id="bodyTableTrainingHoraPromotoria">` : `
          <thead>
            <tr class="tr-style" style="font-size:11px;">
              <th>N°</th>
              <th>Promotoria</th>
              <th>Ramo</th>
              <th>SubRamo</th>
              <th>Campo</th>
              <th>Valor Agregado</th>
              <th>Lapso de Tiempo</th>
              <th>Hecho Por</th>
              <th>Fecha</th>
            </tr>
          </thead>
          <tbody id="bodyTableTrainingHoraPromotoria">
        `;
        if (tr != 0) {
          for (a in tr) {
            var user = `<label class="mg-cero">${getTextValue(tr[a].us_nombre)}</label><br><label class="mg-cero">${getTextValue(tr[a].us_email)}</label>`;
            var trtd = (id != null) ? "" : `
              <td>${getTextValue(tr[a].promotoria)}</td>
              <td>${getTextValue(tr[a].ramo)}</td>
              <td>${getTextValue(tr[a].subramo)}</td>
            `;
            var valor = (tr[a].accion == "insertar") ? `Creado` : getTextValue(tr[a].valor);
            var bg = (tr[a].accion == "insertar") ? `style="background: #d9f5f0;"` : ``;

            if (id != null && tr[a].accion == "insertar") {
              var modulo = (tr[a].campo != "grabarActividadCompania") ? "Actividades" : "Prospeccion";
              ind += `
                <div class="col-md-12 column-flex-center-start pd-items-table-top pd-left pd-right">
                  <div class="pd-side">
                    <label class="subtitleSeg mg-right">
                      *Creado el <b>${getDateFormat(tr[a].registro,10)}</b>, en el módulo de <b>${modulo}</b>
                    </label>
                  </div>
                </div>
              `;
            }

            table += `
              <tr class="show-training-horas-compania" ${bg}>
                <td>${Number(a) + 1}</td>
                ${trtd}
                <td><strong>${getCellTrainingHoraRamoPromotoria(tr[a].campo)}</strong></td>
                <td><b>${valor}</b></td>
                <td>${tr[a].tiempo}</td>
                <td>${user}</td>
                <td>${getDateFormat(tr[a].registro,1)}</td>
              </tr>
            `;
          }
        }
        else { table += `<tr><td colspan="${colspan}"><center><strong>Sin resultados</strong><center></td></tr>`; }
        table += `</tbody>`;
        $('#contIndHRP').html(ind);
        $('#tableTrainingHoraPromotoria').html(table);
      },
      error: (error) => {
          console.log(error);
      }
    })
  }

  function getCellTrainingHoraRamoPromotoria(val) {
    var cell = "";
    switch(val) {
      case 'horasPortalCotizacion': cell = "Cotización Portal"; break;
      case 'horasOficinaCotizacion': cell = "Cotización Oficina"; break;
      case 'horasPortalEmision': cell = "Emisión Portal"; break;
      case 'horasOficinaEmision': cell = "Emisión Oficina"; break;
      case 'horasOficinaEndosos': cell = "Endoso A Oficina"; break;
      case 'horasOficinaEndososB': cell = "Endoso B Oficina"; break;
      case 'horasOficinaEndososD': cell = "Endoso D Oficina"; break;
      case 'horasOficinaCancelaciones': cell = "Cancelación Oficina"; break;
      case 'horasPortalCaptura': cell = "Captura Portal"; break;
    }
    return cell;
  }

  function getCountResultHoraRamoPromotoria() {
    let show = document.getElementsByClassName('show-horaRamoPromotoria');
    $('#totalFilterTableHRP').text(show.length);
  }

  function selectFilterHoraRamoPromotoria(type,value) {
    var attr = "";
    var clase = "";
    let between = "";
    switch(type) {
      case '1': attr = "promo"; clase = "hc-promo"; between = [{[0]:"hc-ramo", [1]:"hc-subramo"}]; break;
      case '2': attr = "ramo"; clase = "hc-ramo"; between = [{[0]:"hc-promo", [1]:"hc-subramo"}]; break;
      case '3': attr = "subramo"; clase = "hc-subramo"; between = [{[0]:"hc-promo", [1]:"hc-ramo"}]; break;
    }
    //console.log(value, clase, attr, between[0]);
    filterTableHoraRamoPromotoria(value,clase,attr,between[0]);
  }

  //------------------------------------- OPERACIONES ----------------------------------------------

  function filterTableHoraRamoPromotoria(value,clase,data_attr,between) {
    var panel, d, tr, i, visible;
    panel = document.getElementById('bodyTableHoraCompania');
    d = panel.getElementsByTagName("tr");
    let Fila = document.getElementsByClassName(clase);
    //
    for (i = 0; i < d.length; i++) {
      visible = false;
      tr = $(d[i]).data(data_attr);
      if (tr == value || tr && value == "todos") {
        visible = true;
      }
      if ($(d[i]).hasClass(between[0]) && $(d[i]).hasClass(between[1])) {
        if (visible === true) {
            d[i].style.display = "";
            $(d[i]).addClass('show-horaRamoPromotoria');
        }
        else {
            d[i].style.display = "none";
            $(d[i]).removeClass('show-horaRamoPromotoria');
        }
      }
      if (visible === true) {
          $(d[i]).addClass(clase);
      }
      else {
          $(d[i]).removeClass(clase);
      }
    }
    result = Fila.length;
    getCountResultHoraRamoPromotoria();
  }

  function filterTable(value,body,clase) {
    var filter, panel, d, td, i, j, k, visible;
    var tr = "";
    filter = value;
    panel = document.getElementById(body);
    d = panel.getElementsByTagName('tr');
    let Fila = document.getElementsByClassName(clase);
    //
    for (i = 0; i < d.length; i++) {
      visible = false;
      td = d[i].getElementsByTagName('td');
      for (j = 0; j < td.length; j++) {
          if (td[j] && td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
              visible = true;
          }
      }
      if (visible === true) {
          d[i].style.display = "";
          $(d[i]).addClass(clase);
      }
      else {
          d[i].style.display = "none";
          $(d[i]).removeClass(clase);
      }
    }
    result = Fila.length;
  }

  function searchFilterTable(filter,val) {
    $('#'+filter).val(val);
    $('#'+filter).keyup();
  }

  function eraserFilterTable(filter) {
    $('#'+filter).val("");
    $('#'+filter).keyup();
  }

  function getTextValue(data) {
    if (data == "[object Object]" || data == undefined || data == null || data == "") {
      data = "";
    }
    return data;
  }

  function getDateFormat(data,format) {
    let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
    let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
    let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
    let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
    let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
    var dateF = "";
    if (data == undefined || data == null || data == "") {
        dateF = "";
    }
    else {
      if (!data.includes(':')) { data = data + " 00:00:00";}
      date = new Date(data);
      switch (format) {
        case 1:
            dateF = numberday[date.getDate()] + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
        break;
        case 2:
            dateF = numberday[date.getDate()] + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
        break;
        case 3:
            dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
        break;
        case 4:
            dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
        break;
        case 5:
            dateF = numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
        break;
        case 6:
            dateF = dayname[date.getDay()];
        break;
        case 7:
            dateF = monthname[date.getMonth()];
        break;
        case 8:
            dateF = date.getFullYear();
        break;
        case 9:
            if (!data.includes('00:00:00')) { dateF = date.toLocaleTimeString('en-US'); }
        break;
        case 10:
            dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
        break;
      }
    }
    return dateF;
  }

</script>
