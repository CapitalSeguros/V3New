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
    margin-top: -10px;
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
  .panel_buscar{
    background-color: #fff;
    width: 100%;
    height: 100px;
    margin-bottom: 2%;
    margin-top: 2%;
  }
  

</style>
<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>


<div style="height: auto; width: 90%;"  class="center-block">
 <!--[Dennis]-->
<div class="panel_botones">
  <table>
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

    <tr>
      <td>
        <a href="#" onclick="enviarFormGenerales(4)">
          <div class="boton">
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\exportar.png')?>" width="100%;">
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
          <img src="<?php echo(base_url().'assets\images\agrega_agentes\agentes.png')?>" width="100%;">
          <span class="lbboton">Todos los Agentes</span>
        </div>
        </a>
        </form>
      </td>
    </tr>

  
  </table>
</div>

<div id='divPermisoV3'>
  <div style="text-align: right; margin-right: 2%;">
  <h5><i class="fa fa-user"></i> AGENTES</h5>
</div>
<label class="Responsivo lbEtiqueta">El permiso de CAPSYS esta sujeto a los documentos obligatorios</label>
<form action="<?=base_url();?>persona/agente"   method="post" id="formPasaCapsys"><input type="hidden" name="idPasarAgente" id="idPasarAgente"></form>
</div>
<div>
  <select id="selectFiltroCreador" onchange="filtroCreador(document.getElementById('cbFiltroCreador'))" name="selectFiltroCreador"></select><input type="checkbox" id="cbFiltroCreador" onclick="filtroCreador(this)">
</div>

<div class="panel">
<div id="divContenedorTabla" style="overflow-x: scroll; width: 100%; margin-left: 5px;margin-right: 20px">
<!--<div class="contCapa"></div> -->
</div>
<div class="panel_buscar">
  <form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
    <table border="0" width="80%">
      <tr>
        <td>
          <input type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro" class="form-control" placeholder="Buscar">
        </td>
        <td colspan="4"></td>
      </tr>
      <tr>
        <td><select class="objetosResponsivos form-control" name="idPersonas" id="idPersonas"></select></td>
        <td><button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button></td>
         <td width="10%"></td>
        <td><button class="btn btn-primary" onclick="obtieneElementosTag(false);"><i class="fa fa-edit"></i>Modificar</button></td>
        <td><button class="btn  btn-primary" onclick="enviarForm();"><i class="fa fa-file"></i> Guardar</button>
        </td>
      </tr>
    </table>
  </form>
</div>
</div>





<div class="divPerson" style="direction: rtl;">
  <div class="ResponsivoDiv">
    <div class="ResponsivoDiv" id="divNuevaPersona"></div>
  </div>
  <div class="ResponsivoDiv" id="divCrearEnSicas"></div>
 
	<br>
    <!--[Dennis Castillo 2020-04-20]-->
  <br><br>
    <?php if($this->tank_auth->get_usermail()=="COORDINADOR@ASESORESCAPITAL.COM" || 
						$this->tank_auth->get_usermail()=="COORDINADOR@CAPCAPITAL.COM.MX" || 
						$this->tank_auth->get_usermail()=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX" ||
            $this->tank_auth->get_usermail()=="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM" || 
            $this->tank_auth->get_usermail()=="COORDINADORCOMERCIAL@FIANZAS.COM" ||
            $this->tank_auth->get_usermail()=="COORDINADORCARIBE@AGENTECAPITAL.COM" ||
            $this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM"){?>
    <button 
    	class="objetosResponsivos btn-primary"
      onclick="window.location.href='<?=base_url('persona/resumenCapacitacion')?>'">Resumen Hrs Capacitacion
    </button>
            <br><br> <?php }?>
    <?php if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'){?>
   <?php }?>
</div>


<div class="modal fade capacitacion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="text-align: center">
        <h5>Asignación de capacitación</h5>
      </div> <!--[Dennis 2020-05-21 aquiSe]-->
      <div class="modal-body"  style="text-align: center">
        <select name="" id="opcionesCarga" class="custom-select mr-sm-2">
          <option selected>Selecccione</option>
          <option value="1">Asignar horas de capacitación</option>
          <option value="2">Subir imágenes del curso</option>
        </select>
        <p id="prueba"></p>
        <form method="POST" name="capaForm" id="capaForm">
          <div style="display: none;" id="cargaHrs"><!--<p>carga de horas</p>-->
            <div><select id="selectCapacitacion" name="selectNameCapacitacion" required>
              <option value="">Seleccione un capacitación</option>
              <?php foreach($capacitacion as $valor){?>
                <option value=<?=$valor->id_capacitacion?>><?=ucwords($valor->tipoCapacitacion)?></option>
              <?php }?>
            </select>
            </div><br>
            <div id="contSelectCertificacion" style="display: none">
                <select name="nameSelectCerti" id="selectCerti" required></select>
            </div>
            <br>
            <br>
            <div id="contHrsCert" style="display:none;">
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs de Desarrollo Prof<div><input type="number" name="certificacion" id="certificacion"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs Autos<div><input type="number" name="certificacionAutos" id="certificacionAutos"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs Gastos Medicos<div><input type="number" name="certificacionGmm" id="certificacionGmm"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs de Vida<div><input type="number" name="certificacionVida" id="certificacionVida"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs Daños<div><input type="number" name="certificacionDanos" id="certificacionDanos"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Hrs Fianzas<div><input type="number" name="certificacionFianzas" id="certificacionFianzas"></div></label></div>
              <div class="certiOption"><label class="Responsivo lbEtiqueta">Descripcion de la capacitación<div><input type="text" name="descripcion" id="descripcion"></div></label></div>
            </div>
          </div>
          
          <div style="display: none" id="cargaImg">
            <p>carga de imagenes</p>
            <input type="file" name="cargaImagen" id="cargaImagen" multiple >  
            
          </div><br>
          <div id="buscadorVendedores" style="width: 100%; text-align: left">
            <p>Buscar vendedor: </p>
            <!--<input type="text" name="buscaVendedor" id="buscaVendedor" style="height: 20px">-->
            <?php if($this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM" || $this->tank_auth->get_usermail()=="DIRECTORGENERAL@AGENTECAPITAL.COM") {?>
            <select name="cuentasACargo" id="cuentasACargo" onchange="enviaUsuario('this')">
            </select> <?php }?> <!--[Dennis 2020-04-29]-->
          </div> <!--[Dennis 2020-04-27]-->

          <div id="listaCapa" style="overflow-y:scroll; height:200px;">
            <table style="width: 99%" id="tablaVendedores">
              <thead style="background-color:#472380; color:white;" id="cabeceraTabla"><tr><td>Seleccionar todo: <input type="checkbox" id="opcionTotal"></td><td>Nombre completo</td><td>Tipo de agente</td><td>Canal</td><td>Sucursal</td></tr></thead>
              <tbody style="border: solid 1px #D5D8DC" id="cuerpoTabla">
              <?php if(isset($agentesTemporales)){
                for($i=0;$i<count($agentesTemporales);$i++){?>
                <tr style="border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px" id="contenidoTabla">
                    <td  style="width: 15%"><input type="checkbox" class="opcionSelect" name="idPersona[]" value="<?=$agentesTemporales[$i]->idPersona?>"></td>
                    <td  style="text-align: left"><?=$agentesTemporales[$i]->nombres." ".$agentesTemporales[$i]->apellidoPaterno." ".$agentesTemporales[$i]->apellidoMaterno?></td>
                    <td><?=$agentesTemporales[$i]->personaTipoAgente?></td>
                    <td><?=$agentesTemporales[$i]->nombreTitulo?></td>
                    <td><?=$agentesTemporales[$i]->sucursal?></td> 
                </tr>
                <?php }} else{echo "No hay datos por el momento";}?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <!--<input type="submit" value="Enviar">-->
            <button class="btn btn-primary" id="actualizarCapa" style="display: none">Enviar</button>
            <button class="btn btn-primary" id="insertaImg" style="display: none">Enviar imagenes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div><?php if(isset($datosAgente)){ echo(bajaTotal($datosAgente,$this->tank_auth->get_usermail()));}?></div>
</div>
<div style="height: auto; width: 90%;"  class="center-block">
  <div class="divPerson"><label id="labelNombrePersona" class="labelNombrePersona"></label></div>
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
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Municipio Nac.<div><input class="formEnviar"  type="text" name="municipioNacimiento" id="municipioNacimiento"></div></label></div>

<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Civil<div><select class="formEnviar"  name="estadoCivil" id="estadoCivil"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Escolaridad<div><select class="formEnviar"  name="escolaridad" id="escolaridad"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cedula<div><input class="formEnviar"  type="text" name="cedulaPersona" id="cedulaPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de Cedula<div><input class="formEnviar"  type="text" name="tipoCedulaAgentePersona" id="tipoCedulaAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio cedula<div><input class="formEnviar fechaPersona" class="fechaPersona"   type="text" name="fecIniCedulaPersona" id="fecIniCedulaPersona" autocomplete="off"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin cedula<div><input class="formEnviar fechaPersona"    type="text" name="fecFinCedulaPersona" id="fecFinCedulaPersona" autocomplete="off"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Poliza RC<div><input class="formEnviar"   type="text" name="PRCAgentePersona" id="PRCAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Compania<div><input class="formEnviar"  type="text" name="PRCCompaniaAgentePersona" id="PRCCompaniaAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio RC<div><input class="formEnviar fechaPersona"    type="text" name="fecIniPRCAgentePersona" id="fecIniPRCAgentePersona" autocomplete="off"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin RC<div><input class="formEnviar fechaPersona"   type="text" name="fecFinPRCAgentePersona" id="fecFinPRCAgentePersona" autocomplete="off"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Beneficiario<div><input class="formEnviar"    type="text" name="beneficiarioPersona" id="beneficiarioPersona"></div></label></div>
<!--<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs de Desarrollo Prof<div><input class="formEnviar"    type="text" name="certificacion" id="certificacion"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Autos<div><input class="formEnviar"    type="text" name="certificacionAutos" id="certificacionAutos"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Gastos Medicos<div><input class="formEnviar"    type="text" name="certificacionGmm" id="certificacionGmm"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs de Vida<div><input class="formEnviar"    type="text" name="certificacionVida" id="certificacionVida"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Daños<div><input class="formEnviar"    type="text" name="certificacionDanos" id="certificacionDanos"></div></label></div>
</div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Fianzas<div><input class="formEnviar"    type="text" name="certificacionFianzas" id="certificacionFianzas"></div></label></div>-->
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Promotorias<div><div  style="height:80px ;width: 100%;border: solid; overflow: scroll;"   type="text" name="divCatalogoPromotorias" id="divCatalogoPromotorias"></div></div></label></div>

</div>
<div class="divPerson"><button  onclick="Verdatos(this,'DATOS EMPRESA AGENTE')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS EMPRESA AGENTE▲</button>
  <div class="divPersonSub ver">
  <!--[Dennis 2020-03-27]-->
  <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Tipo de contrato<div>
    <select class="formEnviar"  name="idModalidad" id="idModalidad" onchange="segmentarTipoAgente(this.value)" required>
      <option value="0">Seleccione</option>
      <?php foreach($tipoModalidad as $valor){?>
      <option value="<?=$valor->idModalidad ?>"><?=$valor->tipoModalidad?></option><?php }?>
    </select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Tipo de Agente<div>
    <select class="formEnviar"  name="personaTipoAgente" id="personaTipoAgente" required>
    </select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Sucursal<div><select  class="formEnviar" name="id_catalog_sucursales" id="id_catalog_sucursales"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Honorarios<div><select class="formEnviar"  name="honorariosCVH" id="honorariosCVH"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Canal<div><select class="formEnviar"  name="id_catalog_canales" id="id_catalog_canales" required></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Ranking(SICAS)<div><select class="formEnviar"  name="idpersonarankingagente" id="idpersonarankingagente"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Usuario<div  id="divUsuarioPersona"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Contraseña<div id="divPasswordPersona"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Id Vendedor<div id="divIdVendedor"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estatus<div><select class="formEnviar"  name="banned" id="banned"><option value="0">Habilitado</option><option value="1">Baneado</option></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Car Capital<div><select class="formEnviar"  name="UsuarioCarCapital" id="UsuarioCarCapital"><option value="0">No</option><option value="1">Si</option></select></div></label></div>

   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta lbSICAS">Vendedor Superior<div><select class="formEnviar"  name="IDVendNS" id="IDVendNS" style="width: 70%;"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuth<div><input type="text" class="formEnviar"  name="CodeAuthPersonaSicas" id="CodeAuthPersonaSicas"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuthUser<div><input type="text" class="formEnviar"  name="CodeAuthUserPersonaSicas" id="CodeAuthUserPersonaSicas" ></div></label></div>
      <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Num. Gafete(Validador)<div><label class="Responsivo lbEtiqueta" id="IDValida" ></label></div></label></div>
         <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fecha de Baneo<div><input type="text" class="formEnviar fechaPersona"  name="fecInicioBaneo" id="fecInicioBaneo" autocomplete="off" ></div></label></div>
</div>
</div>

<div class="divPerson"><button  onclick="Verdatos(this,'PERMISOS ADICIONALES')" class="objetosResponsivos btnCab objetosResponsivoGrande ">PERMISOS ADICIONALES▲</button>
  <div class="divPersonSub ver">
       <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta"><div id="divTipoAgente" ></div></label></div>       
  </div>
</div>


<div class="divPerson"><button  onclick="Verdatos(this,'DATOS CAPITAL HUMANO')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS 
 CAPITAL HUMANO▲</button>
  <div class="divPersonSub ver">
       <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo Persona<div id="divTipoPersona"></div></label></div>
       <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Puesto<div id="divIdPersonaPuesto"></div></label></div>
  </div>
</div>


<div class="divPerson"><button  onclick="Verdatos(this,'BANCOS')" class="objetosResponsivos btnCab objetosResponsivoGrande ">BANCOS ▲</button>
<div class="divPersonSub ver">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Banco<div><select class="formEnviar"  name="idBanco" id="idBanco"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Clave<div><input  class="formEnviar" type="text" name="claveBancoPersona" id="claveBancoPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cuenta<div><input  class="formEnviar" type="text" name="cuentaBancoPersona" id="cuentaBancoPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de cuenta<div><input  class="formEnviar" type="text" name="tipoCuentaBancoPersona" id="tipoCuentaBancoPersona"></div></label></div>
</div></div>



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
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Personal<div><input class="formEnviar"  type="text" name="celPersonal" id="celPersonal" ></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cel. Oficina<div><input  class="formEnviar" type="text" name="celOficina" id="celOficina"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Corre Electronico<div><input class="formEnviar" type="text" name="emailPersonal" id="emailPersonal"></div></label></div>
</div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'OTROS')" class="objetosResponsivos btnCab objetosResponsivoGrande">OTROS ▼</button>
	<div class="divPersonSub ocultar">
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
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tiene Vehiculo<div><select class="formEnviar"  name="vehiculoPersona" id="vehiculoPersona">
	<option value="SI">Si</option><option value="NO">No</option>
</select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Modelo<div><input class="formEnviar" type="text" name="modeloVehiculoPersona" id="modeloVehiculoPersona"></div></label></div>
</div>
</div>

<div class="divPerson"><button onclick="Verdatos(this,'IMAGENES')" class="objetosResponsivos btnCab objetosResponsivoGrande">IMAGENES ▼</button>
  <div class="divPersonSub ocultar">
    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagen Personal<div><input type="file" id="imgPersonal" onchange="if(!this.value.length)return false; enviarArchivo(this,'0');"></div></label></div>

    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Ver Imagen Personal<div><button class="btn-primary" onclick="direccionAJAX('ventanaImagenPersonal','sinID')">Imagen Personal</button></div></label></div>

    <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagenes<div><input type="file" id="imgGeneral" onchange="if(!this.value.length)return false; enviarArchivo(this,'1');"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Imagenes<div><button class="btn-primary" onclick="direccionAJAX('ventanaImagenes','sinID')">Ver galeria</button></div></label></div>
</div>
</div>


<div class="divPerson"><button onclick="Verdatos(this,'PERMISOS DE COTIZACION')" class="objetosResponsivos btnCab objetosResponsivoGrande">PERMISOS DE COTIZACION ▼</button>
	<div class="divPersonSub ocultar"><div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Accidentes y enfermedades<div><select  class="formEnviar" name="cotizasAcciEnferm" id="cotizasAcciEnferm"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Danos<div><select class="formEnviar"  name="cotizaDanios" id="cotizaDanios"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Fianzas<div><select class="formEnviar"  name="cotizaFianzas" id="cotizaFianzas"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Vehiculos<div><select class="formEnviar"  name="cotizaVehiculos" id="cotizaVehiculos"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Vida<div><select class="formEnviar"  name="cotizaVida" id="cotizaVida"><option value="SI">SI</option><option value="NO">NO</option></select></div></label></div>
</div>
</div>
</div>


<div class="divPerson"><button onclick="Verdatos(this,'PERMISOS LEGALES')" class="objetosResponsivos btnCab objetosResponsivoGrande">PERMISOS DE LEGALES ▼</button>
	<div class="divPersonSub ocultar">
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Recabar Informacion<div><select class="formEnviar"  name="recabarInfo" id="recabarInfo"><option value="0">SI</option><option value="-1">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Asesorias de Producto<div><select class="formEnviar"  name="asesoriaProduc" id="asesoriaProduc"><option value="1">SI</option><option value="-1">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Cobranza Primas<div><select class="formEnviar"  name="cobranzaPri" id="cobranzaPri"><option value="2">SI</option><option value="-1">NO</option></select></div></label></div>
<div class="ResponsivoDiv"><label  class="Responsivo lbEtiqueta">Endosos o Modificaciones<div><select class="formEnviar"  name="endoModif" id="endoModif"><option value="3">SI</option><option value="-1">NO</option></select></div></label></div>


</div>
</div>



<div class="divPerson"><button onclick="Verdatos(this,'TARGET DE AGENTES')" class="objetosResponsivos btnCab objetosResponsivoGrande">TARGET DE AGENTES ▼</button>
	<div class="divPersonSub ocultar">
<div id="targetPersona">
	
</div>


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
	<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta" id="agentesEnEspera"> </label></div>

</div>
</div>

</div>

<script>
  function mandaMiInfo(row,correo,idPersona){
   // var direccion="<?php //echo(base_url().'miInfo/verAgente?userMail=');?>";
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
    //console.log(objetoTabla.rows[i].innerText);
  if(objetoTabla.rows[i].innerText.indexOf(objeto.value)>-1){
    objetoTabla.rows[i].style.display = "";
  } 
  else{
    objetoTabla.rows[i].style.display = "none";
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
                var texto=tabla.rows[i].cells[8].childNodes[0].innerHTML;
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

 for(var i=0;i<cantidad;i++){
 	if(object.parentNode.childNodes[i])
 	{
 	if(object.parentNode.childNodes[i].nodeName=="DIV")
 	{   //console.log(object.parentNode.childNodes[i].nodeName);
 		if(object.parentNode.childNodes[i].classList.contains("ocultar")){object.parentNode.childNodes[i].classList.remove("ocultar");object.parentNode.childNodes[i].classList.add("ver");object.innerHTML=texto+" ▲"}
 		else{object.parentNode.childNodes[i].classList.remove("ver");object.parentNode.childNodes[i].classList.add("ocultar");object.innerHTML=texto+" ▼"}
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
  .ocultarElemento{display: none;}
  .baneadoPersona{background-color: red}
  .labelNombrePersona{background-color: white;color: black; font-size: 22px}
.divTD{width: 350px; overflow: auto;}
  .tableV3{width: 100%}
  .tableV3>thead{background-color: #472380;color: white;}
  .tbodyCabeceraEstatica tr:nth-child(even) { background: #ddd }
.certiOption{
  display: inline-block;
  width: 15%;}
.certiOption input{
  width: 100%;}
.certiOption label {
  width: 100%;}
.certiOptionOculto{
  display: none;
  width: 15%;
}
.modal-footer{text-align: right;}

  <?php
/*==============CONFIGURA ALGUNOS PARAMETROS SI ES COORDINADOR, AGENTE O MASTER==============*/
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'  ){

  echo(".lbSICAS{color: red}");
  }
 ?>

}
</style>


<script>


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
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement('input'); 

  if(objetosForm[i].name=='cbPromotoria'){
      if(objetosForm[i].checked){idPromotoria=idPromotoria+objetosForm[i].value+";";}
    }else{
  if(objetosForm[i].name=='cbPermisosPTA'){
      if(objetosForm[i].checked){idPersonaTipoAgente=idPersonaTipoAgente+objetosForm[i].value+";";}
    }
      else{
      objeto.name=objetosForm[i].name;
      objeto.value=objetosForm[i].value;
      formulario.appendChild(objeto);}
    }
      
  }
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
  //console.log(tipoCuenta);

  if(tipoCuenta=="DIRECTORGENERAL@AGENTECAPITAL.COM" || tipoCuenta=="SISTEMAS@ASESORESCAPITAL.COM" ||tipoCuenta=="AUDITORINTERNO@AGENTECAPITAL.COM"){
    if(tipoContrato.value>0 && tipoAgente.value>0 && tipoCanal.value>0){
      formulario.submit();
    }else{
      alert("Los campos tipo contrato, tipo de agente y canal son obligatorios");
    }
  }
  else{
    if(tipoContrato.value>0 && tipoAgente.value>0){
      formulario.submit();
    }else{
      alert("Los campos tipo contrato y tipo de agente son obligatorios");
    }
    }
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

  $total=count($escolaridad);
  $options='document.getElementById("escolaridad").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$escolaridad[$i]->idEscolaridad.'">'.$escolaridad[$i]->escolaridad.'</option>';}
  $options=$options.'\';';
  echo($options);
  $total=count($estadoCivil);
  $options='document.getElementById("estadoCivil").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$estadoCivil[$i]->idEstadoCivil.'">'.$estadoCivil[$i]->estadoCivil.'</option>';}
  $options=$options.'\';';
  echo($options);
//-----------------------------------------------------------------------------------//


//----------------------------------------------------------------------------------//
 /*$total=count($personaTipoAgente);
 //$total=count($permisoPersonaTipoAgente['permisoPTAMaster']);
  $options='document.getElementById("personaTipoAgente").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$personaTipoAgente[$i]->idPersonaTipoAgente.'">'.$personaTipoAgente[$i]->personaTipoAgente.'</option>';}
  $options=$options.'\';';
  echo($options); */
/*  if(isset($permisoPersonaTipoAgente['permisoPTACoordinador'])){
   $options='document.getElementById("personaTipoAgente").innerHTML=\'';     
   //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($permisoPersonaTipoAgente['permisoPTACoordinador'],TRUE));fclose($fp);   
  foreach ($permisoPersonaTipoAgente['permisoPTACoordinador'] as $value) {
   $options=$options.'<option value="'.$value->idPersonaTipoAgente.'">'.$value->personaTipoAgente.'</option>';}
  $options=$options.'\';';
  echo($options);
  }*/
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
  //$options=$options.'<option value="'.$valor->id_catalog_sucursales.'">'.$valor->NombreSucursal.'</option>';
  $options=$options.'\';';
  echo($options);


   /*   $total=count($catalog_canales);
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

     $total=count($agentesEnEspera);
  $options='<table id="tableEspera" border="1" class="table"><thead><tr><td>ID</td><td>Nombre</td><td>Creado</td><td>Status</td></tr></thead>';
  $selectOptions="<option></option>";
  $usuarioCreacion="";//$agentesEnEspera[0]->userEmailCreacion;
  for($i=0;$i<$total;$i++){
    if($usuarioCreacion!=$agentesEnEspera[$i]->userEmailCreacion){
      $selectOptions=$selectOptions.'<option>'.$agentesEnEspera[$i]->userEmailCreacion.'</option>';}
      $options=$options.'<tr>';
    $options=$options.'<td>'.$agentesEnEspera[$i]->idPersona.'</td><td>'.$agentesEnEspera[$i]->nombres." ".$agentesEnEspera[$i]->apellidoPaterno.' '.$agentesEnEspera[$i]->apellidoMaterno.'</td><td>'.$agentesEnEspera[$i]->userEmailCreacion.'</td><td>'.$agentesEnEspera[$i]->EstadoV3.'</td>';
   $usuarioCreacion=$agentesEnEspera[$i]->userEmailCreacion;  
    $options=$options.'<tr>'; 

  }
     // $divOption='document.getElementById("agentesEnEspera").innerHTML=\''.$options;
  $options='<select id="selectEspera" name="selectEspera" onchange="filtroTablaGenerico(this,tableEspera)">'.$selectOptions.'</select>'.$options.'</table>\';';

  $options='document.getElementById("agentesEnEspera").innerHTML=\''.$options;

  echo($options);

     $total=count($agentesTemporales);




  $options='document.getElementById("idPersonas").innerHTML=\'';
  $filtroCreacion=array();$baneado="";
$rowTabla="";
$rowTabla='document.getElementById(\'divContenedorTabla\').innerHTML=\'<table style="width: 100%" class="table table-responsive table-hover"><thead style="width: 1000px;  background-color:#472380; color:white;"><tr><th class="ocultarElemento"><div class="divTD">id</div></th><th><div class="divTD"></div></th><th><div class="divTD">Nombre</div></th><div class="divTD"></div><th><div class="divTD">Sucursal</div></th><th><div class="divTD">canal</div></th><th><div class="divTD">Tipo Agente</div></th><th><div class="divTD">Ranking</div></th><th><div class="divTD">E-mail</div></th><th><div class="divTD">Usuario Creacion</div></th><div class="divTD"></tr></thead></table></div>';
$rowTabla.='<div onscroll="moverScroll()" id="scrollTabla" style="width: 100%;height: 400px;"><table style="width:100%;margin-top: -5%;" border="0" id="tableCabeceraEstatica" class="table table-condended table-hover"><thead style="visibility: hidden;"><tr><th class="ocultarElemento"><div class="divTD">id</div></th><th><div class="divTD"></div></th><th><div class="divTD">Nombre</div></th><div class="divTD"></div><th><div class="divTD">Sucursal</div></th><th><div class="divTD">Canal</div></th><th><div class="divTD">Tipo Agente</div></th><th><div class="divTD">Ranking</div></th><th><div class="divTD">E-mail</div></th><th><div class="divTD">Usuario Creacion</div></th></tr></thead><tbody class="tbodyCabeceraEstatica">';
  for($i=0;$i<$total;$i++){
    $options=$options.'<option  value="'.$agentesTemporales[$i]->idPersona.'">'.$agentesTemporales[$i]->nombres.' '.$agentesTemporales[$i]->apellidoPaterno.' '.$agentesTemporales[$i]->apellidoMaterno.'</option>';
    $rowTabla=$rowTabla.'<tr onclick="escogeAgente(this)">';
    if($agentesTemporales[$i]->activated==0){$baneado="baneadoPersona";}else{$baneado="";}
    $rowTabla=$rowTabla.'<td class="ocultarElemento"><div class="divTD">'.$agentesTemporales[$i]->idPersona.'</div></td>';
     $rowTabla=$rowTabla.'<td class="'.$baneado.'"><div class="divTD">'.($i+1).'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->nombres.' '.$agentesTemporales[$i]->apellidoPaterno.' '.$agentesTemporales[$i]->apellidoMaterno.'<div><button class="btn-primary" onclick="mandaMiInfo(this,\\\''.$agentesTemporales[$i]->email.'\\\','.$agentesTemporales[$i]->idPersona.')">Ir MiInfo</button></div>  </div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->sucursal.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->nombreTitulo.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->personaTipoAgente.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->ranking.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->email.'</div></td>';
    $rowTabla=$rowTabla.'<td><div class="divTD">'.$agentesTemporales[$i]->userEmailCreacion.'</div></td>'; 
    // $rowTabla=$rowTabla.'<td><div class="divTD"><button class="btn-primary" onclick="mandaMiInfo(this,\\\''.$agentesTemporales[$i]->email.'\\\','.$agentesTemporales[$i]->idPersona.')">Ir MiInfo</button></div></td>';   
    $rowTabla=$rowTabla.'</tr>';    
    $filtroCreacion[$agentesTemporales[$i]->userEmailCreacion]=$agentesTemporales[$i]->nombres;
    //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($filtroCreacion, TRUE));fclose($fp);
}

$options=$options.'\';';
  echo($options);
 $rowTabla.='</tbody></table>';
  $rowTabla=$rowTabla.'\';';
  echo($rowTabla);


  $options="";
  $option0="<option value=todos>Todos</option>";
  foreach ($filtroCreacion as $key => $value) {
    $options=$options.'<option value="'.$key.'">'.$key.'</option>';
  }
  echo('document.getElementById(\'selectFiltroCreador\').innerHTML=\''.$options.'\';'); 
  if($this->tank_auth->get_usermail()=="SISTEMAS@ASESORESCAPITAL.COM"){
  echo('document.getElementById(\'cuentasACargo\').innerHTML=\''.$option0.''.$options.'\';');
  //echo ("<select name='cuentasACargo' id='cuentasACargo'>".$options."</select>");
}//cuentasACargo //[Dennis 2020-04-29]

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
   function  devolverSelect($datos,$id,$descripcion){ $opciones="";

   foreach ($datos as  $key =>$value) {$opciones=$opciones.'<option value="'.$value->$id.'">'.$value->$descripcion.'</option>';}
   return $opciones;
  }
 ?>
 <?php  if(isset($personaTipoPersonaCatalogo)){ ?>
     document.getElementById('divTipoPersona').innerHTML= '<select class="formEnviar"  name="tipoPersona" id="tipoPersona"></select>';
     document.getElementById('tipoPersona').innerHTML=<?php  echo('\''.devolverSelect($personaTipoPersonaCatalogo,'id','tipoPersona').'\'');  ?>

<?php } ?>
 <?php if(isset($personaPuestoCatalogo)){ ?>
     document.getElementById('divIdPersonaPuesto').innerHTML= '<select class="formEnviar"  name="idPersonaPuesto" id="idPersonaPuesto"></select>';
     document.getElementById('idPersonaPuesto').innerHTML=<?php  echo('\''.devolverSelect($personaPuestoCatalogo,'idPuesto','personaPuesto').'\'');  ?>
    
<?php } ?>
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
 
 $total=count($documentosFormato);
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
echo($options);
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
?>
document.getElementById('certificacion').value="<?php echo($datosAgente->certificacion); ?>";
document.getElementById('certificacionAutos').value="<?php echo($datosAgente->certificacionAutos); ?>";
document.getElementById('certificacionGmm').value="<?php echo($datosAgente->certificacionGmm); ?>";
document.getElementById('certificacionVida').value="<?php echo($datosAgente->certificacionVida); ?>";
document.getElementById('certificacionDanos').value="<?php echo($datosAgente->certificacionDanos); ?>";
document.getElementById('certificacionFianzas').value="<?php echo($datosAgente->certificacionFianzas); ?>";
document.getElementById('labelNombrePersona').innerHTML="<?php echo($datosAgente->nombres.' '.$datosAgente->apellidoPaterno.' '.$datosAgente->apellidoMaterno); ?>";
document.getElementById('idPersona').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('idPersonas').value="<?php echo($datosAgente->idPersona); ?>";
document.getElementById('nombres').	value="<?php echo($datosAgente->nombres); ?>";
document.getElementById('apellidoPaterno').value="<?php echo($datosAgente->apellidoPaterno); ?>";
document.getElementById('apellidoMaterno').value="<?php echo($datosAgente->apellidoMaterno); ?>";
document.getElementById('rfc').value="<?php echo($datosAgente->rfc); ?>";
document.getElementById('fechaNacimiento').value="<?php echo($datosAgente->fechaNacimiento); ?>";
document.getElementById('estadoNacimiento').value="<?php echo($datosAgente->estadoNacimiento); ?>";
document.getElementById('municipioNacimiento').value="<?php echo($datosAgente->municipioNacimiento); ?>";
document.getElementById('paisNacimiento').value="<?php echo($datosAgente->paisNacimiento); ?>";
document.getElementById('estadoCivil').value="<?php echo($datosAgente->estadoCivil); ?>"
document.getElementById('escolaridad').value="<?php echo($datosAgente->escolaridad); ?>"
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
//document.getElementById('personaTipoAgente').value="<?php echo($datosAgente->personaTipoAgente); ?>";
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
document.getElementById('vehiculoPersona').value="<?php echo($datosAgente->vehiculoPersona); ?>";

//[Dennis 2020-04-15]
detectarSelect=document.getElementById('personaTipoAgente');
if(detectarSelect.length==0){ //$agenteActual
  detectarSelect.innerHTML="<option value="+<?php echo($datosAgente->personaTipoAgente);?>+"><?= $datosAgente->personTipoAgenteNombre?></option>";
}

detectarCanal=document.getElementById('id_catalog_canales');
if(detectarCanal.length==0){
  detectarCanal.innerHTML="<option value="+<?php echo($datosAgente->id_catalog_canales);?>+"><?= $datosAgente->canalNombre?></option>";
}

document.getElementById('CodeAuthPersonaSicas').value="<?php echo($datosAgente->CodeAuthPersonaSicas); ?>";
document.getElementById('CodeAuthUserPersonaSicas').value="<?php echo($datosAgente->CodeAuthUserPersonaSicas); ?>";
document.getElementById('fecInicioBaneo').value="<?php echo($datosAgente->fecInicioBaneo); ?>";
document.getElementById('IDValida').innerHTML="<?php echo($datosAgente->IDValida); ?>";
if(document.getElementById('idPersonaPuesto')){document.getElementById('idPersonaPuesto').value="<?php echo($datosAgente->idPersonaPuesto); ?>";}
if(document.getElementById('tipoPersona')){document.getElementById('tipoPersona').value="<?php echo($datosAgente->tipoPersona); ?>";}




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


 
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='SISTEMAS@ASESORESCAPITAL.COM'  ){


 if(isset($datosAgente)){
echo('document.getElementById("divUsuarioPersona").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="usuarioPersona" name="usuarioPersona" value="'.$datosAgente->emailUsuario.'">\';');
echo('document.getElementById("divPasswordPersona").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="usuarioPassword" name="usuarioPassword" value="'.$datosAgente->passwordUsuario.'">\';');
echo('document.getElementById("divIdVendedor").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="IDVend" name="IDVend" value="'.$datosAgente->IDVend.'">\';');
$crearSicas="";
if($datosAgente->IDVend==0){$crearSicas='\'<button class="objetosResponsivos  btn-primary" onclick="nuevoAgente(this)">Nuevo</button><p>'.'<button class="objetosResponsivos  btn" onclick="enviarFormGenerales(3)" onclick="">Alta en Sicas</button>\';';}
else{$crearSicas='\'<button class="objetosResponsivos  btn-primary" onclick="nuevoAgente(this)">Nuevo</button>\';';}

echo('document.getElementById("divNuevaPersona").innerHTML='.$crearSicas);
      echo('document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente" value="'.$datosAgente->idPersona.'"><button class="objetosResponsivos  btn-primary" id="btnPasarAgente" onclick="validadorArchivos()">Permiso CAPSY</button> \';'); //[Dennis 2020-04-02]

}
  else{
echo('document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente">\';');

 }
echo('function obtieneElementosTag(modo){
     // if(event){event.preventDefault();}  
      var elementos=document.getElementsByTagName("input");
var cont=elementos.length;
for(var i=0;i<cont;i++){
  
  if(elementos[i].type!="checkbox" && elementos[i].type!="file" && elementos[i].type!="hidden"){
  elementos[i].disabled=modo;}
}
var elementos=document.getElementsByTagName("select");
var cont=elementos.length;
for(var i=0;i<cont;i++){
  if(elementos[i].name!="idPersonas" &&  elementos[i].name!="selectFiltroCreador" &&  elementos[i].name!="selectEspera")
  elementos[i].disabled=modo;
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
    error: function(){console.log("No entro");},
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
    error: function(){console.log("No entro");},
    success: function(data){
      //console.log(data);
      //$('#id_catalog_canales').html(data);
      $('#id_catalog_canales').html(`
      <option value=''>Seleccione</option>
      `+data);
    }
  });
 })
//--------------------------------------------------------------------------------------
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
//-------------------------------------------------------------------------------------
//[Dennis 2020-04-20]
//Opcion de cambio de opciones en modal
var selectCarga=document.getElementById("opcionesCarga");
selectCarga.addEventListener("change", function(){
  var opcionSeleccionada=selectCarga.selectedIndex;
  var divHrs=document.getElementById("cargaHrs");
  var divImg=document.getElementById("cargaImg");
  var divPadre=document.getElementsByClassName("modal-body")[0];
  var botonImg=document.getElementById("insertaImg");
  var botonCapa=document.getElementById("actualizarCapa");
  if(opcionSeleccionada==1) {
    divHrs.style.display="block";
    divImg.style.display="none";
    botonImg.style.display="none";
    botonCapa.style.display="block";
  }
  else if(opcionSeleccionada==2){
    divImg.style.display="block";
    divHrs.style.display="none";
    botonImg.style.display="block";
    botonCapa.style.display="none";
    
  }
});
//-------------------------------------------------------------------------------------
//[Dennis 2020-04-21]
//Opcion de seleccionar todos.
var checkBoxP=document.getElementById('opcionTotal');
checkBoxP.addEventListener("click", function(){
  var seleccionado=checkBoxP.checked;
  var formElementos=document.getElementById("capaForm");
  if(seleccionado){
    for(i=0;i<formElementos.length;i++){
      if(formElementos.elements[i].type=="checkbox"){
        formElementos.elements[i].checked=true;}
    }
  }
  else{
    for(i=0;i<formElementos.length;i++){
      if(formElementos.elements[i].type=="checkbox"){
        formElementos.elements[i].checked=false;}
    }
  }
});
//---------------------------------------------------------------------------------------
//[Dennis 2020-04-22]
//Validador de campos vacios y retorno de valores

/*$("#capaForm").submit(function(event){
  event.preventDefault();
  var contador=0;
  var inputText=0;
  $("input[type=checkbox]").each(function(){
    if($(this).is(":checked")){
      contador++;}
  });
  $("input[type=number]").each(function(){
    if($(this).val().length!=0){
      inputText++;}
  });
  //console.log(inputText);
  if(contador>0){
    if(inputText>0){
    $.ajax({
    type:"POST",
    url:$(this).attr("action"),
    data:$(this).serialize(),
    error: function(){
      alert('No se envió correctamente los datos');
    },
    success: function(data){
      //console.log(data);
      alert('Horas de capacitación actualizada');
      $('.capacitacion').modal('hide');
      $('#capaForm')[0].reset();
    }
  });
  }
  else{alert('Se requiere llenar mínimo un campo de horas');}
  }
  else{alert('Se requiere seleccionar mínimo a un vendedor');}
})*/
//-----------------------------------------------------------------------------------------
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
      console.log(data);
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
//-------------------------------------------------------------------------------------------
var submitImg=document.getElementById("insertaImg");
var cargaImg=document.getElementById("cargaImagen");
//var agentesSelect=document.getElementByName("idPersona[]");
var formCont=new FormData();
//jugar con imagenes.
cargaImg.addEventListener("change", function(){
  var infoFile = cargaImg.files;
  if(infoFile.length!=0){
    for(var i=0; i<infoFile.length; i++){

      var nombreArchivo=infoFile[i].name;
      var extension=nombreArchivo.split(".").pop().toLowerCase();
      var extValidas=["jpg","png","gif","jpeg"];
      if(extValidas.includes(extension)){

        formCont.append("archivo[]",infoFile[i]);
      }
      else{
        alert("Archivo con extensión no valida: "+nombreArchivo);
      }
    }
  }
});

var cuantosCheck=0;
//carga de imagenes de curso: 1-M,1-1,M-1,M-M
function enviaImg(e){
 
  var formRef=document.getElementById("capaForm");
  var contfiles=0;
  var contadorCheck=0;

  for(var j=0;j<formRef.elements.length;j++){
    if(formRef.elements[j].type=="checkbox"){
     
      if(formRef.elements[j].checked){
      
        formCont.append("agente[]",formRef.elements[j].value);
      }
    }
  }
  e.preventDefault();

  $("input[type=checkbox]").each(function(){
    if($(this).is(":checked")){
      contadorCheck++;}
  });

  $("input[type=file]").each(function(){
    if($(this).val().length!=0){
      contfiles++;}
  });
  if(contfiles>0){
    if(contadorCheck>0){
      $.ajax({
        type:"POST",
        url:"<?php echo base_url()."persona/asignaImgCurso";?>",
        data: formCont,
        processData: false,
        contentType: false,
        cache:false,
        error: function(){
          alert("Hubo un detalle");
        },
        success: function(data){
          alert("Imagenes enviadas");
          $('.capacitacion').modal('hide');
          $('#capaForm')[0].reset();
        }
      });} 
      else{
        alert("Debes seleccionar mínimo a un agente");
      }
      } else{
        alert("Seleccione mínimo una imágen");
      }
}


botonCapa.addEventListener("click", enviaCapa);
submitImg.addEventListener("click", enviaImg);
//[Dennis 2020-04-27]
//buscador de vendedores con JQuery.
/*$("#buscaVendedor").html("");
var filas=document.getElementById("contenidoTabla");
$("#buscaVendedor").on("keyup", function(){
  var datoABuscar= $(this).val();
    $.ajax({
      type:"POST",
      url:"<?=base_url()."persona/buscaVendedor"?>",
      data: {"buscaVendedor": datoABuscar},
      error: function(){
        alert('Datos erróneos');
      },
      success:function(data){
        $("#cuerpoTabla").html(data); 
      }
    })
}) */
//--------------------------------------------------------------------------------------------------------------
//[Dennis 2020-04-29]
function enviaUsuario(){
  var usuarioCreado = document.getElementById("cuentasACargo").value;
  var row="";
  $.ajax({
    type:"POST",
    url:"<?php echo base_url()."persona/prueba"?>",
    dataType:"json",
    data: {"usuarioACargo": usuarioCreado},
    error: function(){
      alert('Datos no enviados');
    },
    success: function(data){
      //$("#cuerpoTabla").html(data);
      //console.log(data);
      for(var indice in data){
        row+="<tr style='border-bottom-color:#D5D8DC; border-bottom-style: solid; border-bottom-width:1px'><td><input type='checkbox' class='opcionSelect' name='idPersona[]' value='"+data[indice].idPersona+"'></td><td style='text-align: left'>"+data[indice].nombres+" "+data[indice].apellidoPaterno+" "+data[indice].apellidoMaterno+"</td><td>"+data[indice].personaTipoAgente+"</td><td>"+data[indice].nombreTitulo+"</td><td>"+data[indice].NombreSucursal+"</td></tr>";
      }
      $("#cuerpoTabla").html(row);
    }
  });
}
//-------------------------------------------------------------------------------------------------------
//console.log(jsonGlobal);
//[Dennis 2020-04-30]
//Buscador con JS puro
/*var buscadorVend=document.getElementById("buscaVendedor");
var cuerpoTabla=document.getElementById("cuerpoTabla");

function convierteAJson(tabla){
  var tablaVendedores=tabla //document.getElementById('tablaVendedores');
  var objetoJson=new Array();
  //var textoFiltro=buscadorVend.value.toLowerCase();
  for(i=1;i<tablaVendedores.rows.length;i++){
    var objetoCelda={};
    var filaActual=tablaVendedores.rows[i];
    var celdas=filaActual.getElementsByTagName("td");
    for(j=0;j<celdas.length;j++){
      objetoCelda["idPersona"]=celdas[0].getElementsByClassName("opcionSelect")[0].value;
      objetoCelda["nombres"]=celdas[1].innerHTML;
      objetoCelda["tipoAgente"]=celdas[2].innerHTML;
      objetoCelda["canal"]=celdas[3].innerHTML;
      objetoCelda["sucursal"]=celdas[4].innerHTML;
    }
    objetoJson.push(objetoCelda);
  }
  console.log(objetoJson);
  return objetoJson;
}

var tablaX=document.getElementById('tablaVendedores');
function buscaCoincidencias(e){
  e.preventDefault();
  var tablaX=document.getElementById('tablaVendedores');
  var objeto
  objeto=convierteAJson(tablaX);
  //convierteAJson(tablaX);
  console.log(objeto);
  /*cuerpoTabla.innerHTML="";
  var textoCoincidencia=buscadorVend.value.toLowerCase();
  for(var indice in objeto){
    var nombre=objeto[indice].nombres.toLowerCase();
    //console.log(nombre);
    if(nombre.indexOf(textoCoincidencia)>-1){
      cuerpoTabla.innerHTML+="<tr><td>oka</td><td>"+objeto[indice].nombres+"</td></tr>";
      //console.log(objeto[indice].idPersona+" "+objeto[indice].nombres);
    }
  }
  if(cuerpoTabla.innerHTML==""){
    //cuerpoTabla.innerHTML+="<tr>No hubo coincidencias</tr>";
    //console.log("No hubo coincidencias");
  }
} */

//convierteAJson(tablaX);
//buscadorVend.addEventListener("keyup", buscaCoincidencias);
//botonFiltro.addEventListener("click", buscaCoincidencias);



//----------------------------------------------------------------------------------------------------

/*var cadenaBusqueda=document.getElementById('buscaVendedor');
var tablaVendedores=document.getElementById('tablaVendedores');
var cuerpoTabla=document.getElementById('cuerpoTabla');
cadenaBusqueda.addEventListener("keyup", function(){
  var valorDeCadena=cadenaBusqueda.value.toLowerCase();
  //var registro=tablaVendedores.rows[1].cells[1];
  //console.log(registro);
  var cadena="";
  for(i=1;i<tablaVendedores.rows.length;i++){
    var celdas=tablaVendedores.rows[i].getElementsByTagName('td');
    
    var fila=tablaVendedores.rows[i].innerHTML;
    for(j=1;j<celdas.length;j++){
      //console.log(celdas[j].innerHTML);
      var valorCelda=celdas[j].innerHTML.toLowerCase();
      if(valorCelda.indexOf(valorDeCadena)>-1){
        /*console.log('Hay coincidencia');
        console.log(valorCelda);
        console.log(valorCelda.length);
        cadena=cadena+fila;
        //cuerpoTabla.innerHTML=valorCelda.toUpperCase();
      }
      else{
        console.log('No hay');
      } 
    }
  }
  cuerpoTabla.innerHTML=cadena;
}); */

//--------------------------------------------------------------------------------------
//prueba de ajax vanilla js generico.
var selectCapacitacion=document.getElementById("selectCapacitacion");

function ajaxVanillaJS(){

  var xmltHttp= new XMLHttpRequest();

  var direccion="<?=base_url()."persona/devuelveCerti"?>";
  var selectName=document.createAttribute("name");
  selectName.value="selectCapacitacionName";
  selectCapacitacion.setAttributeNode(selectName);
  var selectRepuesta=document.getElementById("selectCerti");
  var contenedorSelectRespuesta=document.getElementById("contSelectCertificacion");
  contenedorSelectRespuesta.style.display="inline-block";
  selectRepuesta.innerHTML="";

  xmltHttp.onreadystatechange=function(){
    if(this.readyState==4 && this.status==200){
      //console.log(this.responseText);
      var tipoCerti=JSON.parse(this.responseText);
      
      selectRepuesta.innerHTML+="<option value=''>Seleccione un ramo</option>";
      for(var indice in tipoCerti){
        selectRepuesta.innerHTML+="<option value="+tipoCerti[indice].id_certificado+">"+tipoCerti[indice].nombreCertificado+"</option>";
      }
    }
  }
    xmltHttp.open("GET",direccion+"?"+selectName.value+"="+selectCapacitacion.value, true);
    xmltHttp.send();
}

//aquiSe 
selectCapacitacion.addEventListener("change", ajaxVanillaJS);

//--------------------------------------------------------------------------------------------
  var selectSecundario=document.getElementById("selectCerti");
  var campoTextoCerti=document.getElementsByClassName("certiOptionOculto");
  //var contenedorCamposTexto=document.getElementById("campoTextoHrs");
  //console.log(contenedorCamposTexto.length);
  
selectSecundario.addEventListener("change", function(){
  document.getElementById("contHrsCert").style.display="inline-block";
  /*if(selectSecundario.value!=0){
    /*var contHrsCont=document.getElementById("contHrsCert");
    contHrsCont.style.display="inline-block"; 

    for(var i=0;i<campoTextoCerti.length;i++){
        //campoTextoCerti[i].classList.replace("certiOptionOculto","certiOption");
        if(campoTextoCerti[i].classList.contains("certiOptionOculto")){
          campoTextoCerti[i].classList.replace("certiOptionOculto","certiOption");
        } 
    }
  }
  /*if(selectSecundario.value!=0){
    contenedorCamposTexto.classList.replace("certiOptionOculto","certiOption"); 
  } */
  //console.log(campoTextoCerti.classList.contains("certiOptionOculto"));
});



//---------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------
</script>
<?php
/*======================================FUNCIONES ===================================================*/
function bajaTotal($datosAgente,$usuario)
{
  $cadena="";
  if($usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $usuario=='AUDITORINTERNO@AGENTECAPITAL.COM' || $usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM'){
  if($datosAgente->banned==1){
    $cadena='<form action="'.base_url().'persona/bajaTotal" method="POST"><input type="hidden" value="'.$datosAgente->idPersona.'" name="idPersona"><button class="btn btn-danger">Eliminar</button></form>';
  }
  }
  return $cadena;
}
?>



