<? $this->load->view('headers/header'); ?>
<!-- Navbar -->
<? $this->load->view('headers/menu'); ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<style type="text/css">
  .prueba{background-color: red}
</style>
<section class="container-fluid breadcrumb-formularios">
<div style="height: auto; width: 90%;"  class="center-block">
	<div class="row">
		<div class="col-md-12 col-sm-12">
        	<h3 class="titulo-secciones">Agentes
	  		<!-- <label class="Responsivo lbEtiqueta titulo-secciones" style=" margin-left: 60%" >Agentes</label> -->
			</h3>
		</div>
    </div>

	<div id='row divPermisoV3'>
		<label class="Responsivo lbEtiqueta titulo-secciones">
    		El permiso de CAPSYS esta sujeto a los documentos obligatorios
		</label>
		<form action="<?=base_url();?>persona/agente"   method="post" id="formPasaCapsys">
			<input class="btn btn-primary" type="hidden" name="idPasarAgente" id="idPasarAgente">
		</form>
	</div>
<br />
	<div class="row divPerson">
		<div class="divPersonSub ver">
    		<div class="col-md-2 col-sm-2">
				<form action="<?=base_url();?>persona/agente" method="post" id="formSucursal" name="formSucursal">
            <?
				$idSucursal	= $this->input->post('idSucursal', true);
				$sqlSucursal = "
					Select
						`IdSucursal`, `NombreSucursal`
					From 
						catalog_sucursales
					Where
						1
						   	   ";
				$queySucursal = $this->db->query($sqlSucursal)->result();
			?>
				<select class="form-control" id="idSucursal" name="idSucursal" onchange="this.form.submit()">
                	<option value="">Todos</option>
                    <?
						foreach($queySucursal as $rowSucursal){
					?>
                	<option value="<?=$rowSucursal->IdSucursal?>" <?=($rowSucursal->IdSucursal==$idSucursal)?"Selected":""?>><?=$rowSucursal->NombreSucursal?></option>
					<?
						}
					?>
                </select>
			</form>
      		</div>
	<!--
    		<div class="col-md-10 col-sm-10">
				<div class="ResponsivoDiv">
        			<label class="Responsivo lbEtiqueta">
       					<div>
	-->
							<form action="<?=base_url();?>persona/agente"  method="post" id="formBuscarAgente">
    		<div class="col-md-1 col-sm-1">
								<input class="form-control" type="text" onchange="filtrarBusqueda()" id="txtBuscarFiltro">
			</div>
    		<div class="col-md-8 col-sm-8">
								<select class="objetosResponsivos form-control"  name="idPersonas" id="idPersonas" >
								</select>
			</div>
    		<div class="col-md-1 col-sm-1">
								<button class="objetosResponsivos btn btn-primary">Buscar</button>
            </div>
							</form>
	<!--
						</div>
					</label>
				</div>
			</div>
	-->   
		</div>
	</div>
<br>
	<div class="row divPerson" style="direction: rtl;">
		<div class="col-md-12 col-sm-12">
		
    	    <div class="ResponsivoDiv">
	        	<div class="ResponsivoDiv" id="divNuevaPersona"></div>
            	<button class="objetosResponsivos btn btn-primary " onclick="obtieneElementosTag(false);">Modificar</button> 
        	    <button class="objetosResponsivos btn btn-primary" onclick="enviarForm()">Guardar</button>
			</div>
			<div class="ResponsivoDiv" id="divCrearEnSicas"></div>
        </div>
	</div>
</div>
</section>
<!-- ### -->

<div style="height: auto; width: 90%;"  class="center-block">
<div class="divPerson"><button  onclick="Verdatos(this,'DATOS PERSONALES')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS PERSONALES ▲</button>
<div class="divPersonSub ver">
<input class="formEnviar usuarioClass" type="hidden"  name="idPersona" id="idPersona">
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Nombre       <div><input class="formEnviar" type="text" name="nombres" id="nombres" disabled></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Apellido Pat.<div><input class="formEnviar" type="text" name="apellidoPaterno" id="apellidoPaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Apellido Mat.<div><input class="formEnviar" type="text" name="apellidoMaterno" id="apellidoMaterno"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">RFC          <div><input class="formEnviar" type="text" name="rfc" id="rfc"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CURP          <div><input class="formEnviar" type="text" name="curpPersona" id="curpPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fecha Nac.<div><input class="formEnviar" class="fecha" type="text" name="fechaNacimiento" id="fechaNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Pais Nac.<div><input class="formEnviar" type="text" name="paisNacimiento" id="paisNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Nac.<div><input class="formEnviar" type="text" name="estadoNacimiento" id="estadoNacimiento"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Municipio Nac.<div><input class="formEnviar"  type="text" name="municipioNacimiento" id="municipioNacimiento"></div></label></div>

<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estado Civil<div><select class="formEnviar"  name="estadoCivil" id="estadoCivil"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Escolaridad<div><select class="formEnviar"  name="escolaridad" id="escolaridad"></select></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Cedula<div><input class="formEnviar"  type="text" name="cedulaPersona" id="cedulaPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de Cedula<div><input class="formEnviar"  type="text" name="tipoCedulaAgentePersona" id="tipoCedulaAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio cedula<div><input class="formEnviar fechaPersona" class="fechaPersona"   type="text" name="fecIniCedulaPersona" id="fecIniCedulaPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin cedula<div><input class="formEnviar fechaPersona"    type="text" name="fecFinCedulaPersona" id="fecFinCedulaPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Poliza RC<div><input class="formEnviar"   type="text" name="PRCAgentePersona" id="PRCAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Compania<div><input class="formEnviar"  type="text" name="PRCCompaniaAgentePersona" id="PRCCompaniaAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Incicio RC<div><input class="formEnviar fechaPersona"    type="text" name="fecIniPRCAgentePersona" id="fecIniPRCAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Fec. Fin RC<div><input class="formEnviar fechaPersona"   type="text" name="fecFinPRCAgentePersona" id="fecFinPRCAgentePersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Beneficiario<div><input class="formEnviar"    type="text" name="beneficiarioPersona" id="beneficiarioPersona"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs de Desarrollo Prof<div><input class="formEnviar"    type="text" name="certificacion" id="certificacion"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Autos<div><input class="formEnviar"    type="text" name="certificacionAutos" id="certificacionAutos"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Gastos Medicos<div><input class="formEnviar"    type="text" name="certificacionGmm" id="certificacionGmm"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs de Vida<div><input class="formEnviar"    type="text" name="certificacionVida" id="certificacionVida"></div></label></div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Daños<div><input class="formEnviar"    type="text" name="certificacionDanos" id="certificacionDanos"></div></label></div>
</div>
<div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Hrs Fianzas<div><input class="formEnviar"    type="text" name="certificacionFianzas" id="certificacionFianzas"></div></label></div>

</div>
<div class="divPerson"><button  onclick="Verdatos(this,'DATOS EMPRESA AGENTE')" class="objetosResponsivos btnCab objetosResponsivoGrande ">DATOS EMPRESA AGENTE▲</button>
  <div class="divPersonSub ver">
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Tipo de Agente<div><select class="formEnviar"  name="personaTipoAgente" id="personaTipoAgente"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Sucursal<div><select  class="formEnviar" name="id_catalog_sucursales" id="id_catalog_sucursales"></select></div></label></div>
      <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Honorarios<div><select class="formEnviar"  name="honorariosCVH" id="honorariosCVH"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Canal<div><select class="formEnviar"  name="id_catalog_canales" id="id_catalog_canales"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Ranking<div><select class="formEnviar"  name="idpersonarankingagente" id="idpersonarankingagente"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Usuario<div  id="divUsuarioPersona"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Contraseña<div id="divPasswordPersona"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Id Vendedor<div id="divIdVendedor"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Estatus<div><select class="formEnviar"  name="banned" id="banned"><option value="0">Habilitado</option><option value="1">Baneado</option></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Car Capital<div><select class="formEnviar"  name="UsuarioCarCapital" id="UsuarioCarCapital"><option value="0">No</option><option value="1">Si</option></select></div></label></div>

   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Vendedor Superior<div><select class="formEnviar"  name="IDVendNS" id="IDVendNS"></select></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuth<div><input type="text" class="formEnviar"  name="CodeAuthPersonaSicas" id="CodeAuthPersonaSicas"></div></label></div>
   <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">CodeAuthUser<div><input type="text" class="formEnviar"  name="CodeAuthUserPersonaSicas" id="CodeAuthUserPersonaSicas" ></div></label></div>
      <div class="ResponsivoDiv"><label class="Responsivo lbEtiqueta">Num. Gafete<div><label class="Responsivo lbEtiqueta" id="IDValida" ></label></div></label></div>
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
  .verElemento{display: block; }
  .ocultarElemento{display: none;}

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
  cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement('input'); 
      objeto.name=objetosForm[i].name;
      objeto.value=objetosForm[i].value;
      formulario.appendChild(objeto);
      console.log(formulario[i]);
  }
  document.body.appendChild(formulario);
  formulario.submit();
}

function enviarFormGenerales(accion){
  var direccion="";var clase="";
  switch(accion){
  case 1:direccion=<?php echo('"'.base_url().'persona/banear"'); ?>;clase="usuarioClass";break;
  case 2:direccion=<?php echo('"'.base_url().'persona/habilitar"'); ?>;clase="usuarioClass";break;
  case 3:direccion=<?php echo('"'.base_url().'persona/crearUsuarioSicas"'); ?>;clase="usuarioClass";break;
    }
  var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=direccion;
  objetosForm=document.getElementsByClassName(clase);objetos="";cant=objetosForm.length;
  for(var i=0;i<cant;i++){
  tipo=objetosForm[i].nodeName;
  var objeto=document.createElement('input'); 
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

  $total=count($personaTipoAgente);
  $options='document.getElementById("personaTipoAgente").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$personaTipoAgente[$i]->idPersonaTipoAgente.'">'.$personaTipoAgente[$i]->personaTipoAgente.'</option>';}
  $options=$options.'\';';
  echo($options);


      $total=count($catalog_sucursales);
  $options='document.getElementById("id_catalog_sucursales").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$catalog_sucursales[$i]->IdSucursal.'">'.$catalog_sucursales[$i]->NombreSucursal.'</option>';}
  $options=$options.'\';';
  echo($options);


      $total=count($catalog_canales);
  $options='document.getElementById("id_catalog_canales").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option value="'.$catalog_canales[$i]->IdCanal.'">'.$catalog_canales[$i]->nombreTitulo.'</option>';}
  $options=$options.'\';';
  echo($options);
                   
                  
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
  $options='document.getElementById("agentesEnEspera").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.$agentesEnEspera[$i]->idPersona.'. '.$agentesEnEspera[$i]->nombres." ".$agentesEnEspera[$i]->apellidoPaterno.' '.$agentesEnEspera[$i]->apellidoMaterno.'->Creado por:'.$agentesEnEspera[$i]->userEmailCreacion.$agentesEnEspera[$i]->EstadoV3.'<br><br>';}
  $options=$options.'\';';
  echo($options);

     $total=count($agentesTemporales);

  $options='document.getElementById("idPersonas").innerHTML=\'';
  for($i=0;$i<$total;$i++){$options=$options.'<option  value="'.$agentesTemporales[$i]->idPersona.'">'.$agentesTemporales[$i]->nombres.' '.$agentesTemporales[$i]->apellidoPaterno.' '.$agentesTemporales[$i]->apellidoMaterno.'</option>';
    

}
  $options=$options.'\';';
   
  echo($options);
  
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
 <?php if(isset($personaTipoPersonaCatalogo)){ ?>
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
document.getElementById('certificacion').value="<?php echo($datosAgente->certificacion); ?>";
document.getElementById('certificacionAutos').value="<?php echo($datosAgente->certificacionAutos); ?>";
document.getElementById('certificacionGmm').value="<?php echo($datosAgente->certificacionGmm); ?>";
document.getElementById('certificacionVida').value="<?php echo($datosAgente->certificacionVida); ?>";
document.getElementById('certificacionDanos').value="<?php echo($datosAgente->certificacionDanos); ?>";
document.getElementById('certificacionFianzas').value="<?php echo($datosAgente->certificacionFianzas); ?>";
document.getElementById('honorariosCVH').value="<?php echo($datosAgente->honorariosCVH); ?>";
document.getElementById('IDVendNS').value="<?php echo($datosAgente->IDVendNS); ?>";

<?php
}
?>

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
document.getElementById('personaTipoAgente').value="<?php echo($datosAgente->personaTipoAgente); ?>";
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
document.getElementById('id_catalog_canales').value="<?php echo($datosAgente->id_catalog_canales); ?>";
document.getElementById('idpersonarankingagente').value="<?php echo($datosAgente->idpersonarankingagente); ?>";
document.getElementById('id_catalog_sucursales').value="<?php echo($datosAgente->id_catalog_sucursales); ?>";
document.getElementById('banned').value="<?php echo($datosAgente->banned); ?>";
document.getElementById('UsuarioCarCapital').value="<?php echo($datosAgente->UsuarioCarCapital); ?>";
document.getElementById('vehiculoPersona').value="<?php echo($datosAgente->vehiculoPersona); ?>";

document.getElementById('CodeAuthPersonaSicas').value="<?php echo($datosAgente->CodeAuthPersonaSicas); ?>";
document.getElementById('CodeAuthUserPersonaSicas').value="<?php echo($datosAgente->CodeAuthUserPersonaSicas); ?>";
document.getElementById('tipoPersona').value="<?php echo($datosAgente->tipoPersona); ?>";
document.getElementById('idPersonaPuesto').value="<?php echo($datosAgente->idPersonaPuesto); ?>";
document.getElementById('IDValida').innerHTML="<?php echo($datosAgente->IDValida); ?>";


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


<?php
/*==============CONFIGURA ALGUNOS PARAMETROS SI ES COORDINADOR, AGENTE O MASTER==============*/
if($this->tank_auth->get_usermail()=='DIRECTORGENERAL@AGENTECAPITAL.COM' || $this->tank_auth->get_usermail()=='AUDITORINTERNO@AGENTECAPITAL.COM' ){
   
 if(isset($datosAgente)){
echo('document.getElementById("divUsuarioPersona").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="usuarioPersona" name="usuarioPersona" value="'.$datosAgente->emailUsuario.'">\';');
echo('document.getElementById("divPasswordPersona").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="usuarioPassword" name="usuarioPassword" value="'.$datosAgente->passwordUsuario.'">\';');
echo('document.getElementById("divIdVendedor").innerHTML=\'<input class="formEnviar" style="width: 300px" type="text" id="IDVend" name="IDVend" value="'.$datosAgente->IDVend.'">\';');
$crearSicas="";
if($datosAgente->IDVend==0){$crearSicas='\'<button class="objetosResponsivos btn btn-primary" onclick="nuevoAgente(this)">Nuevo</button><p>'.'<button class="objetosResponsivos  btn btn-primary" onclick="enviarFormGenerales(3)" onclick="">Alta en Sicas</button>\';';}
else{$crearSicas='\'<button class="objetosResponsivos btn btn-primary" onclick="nuevoAgente(this)">Nuevo</button>\';';}

echo('document.getElementById("divNuevaPersona").innerHTML='.$crearSicas); 
   echo('document.getElementById("formPasaCapsys").innerHTML=\'<input type="hidden" name="idPasarAgente" id="idPasarAgente" value="'.$datosAgente->idPersona.'"><button class="objetosResponsivos  btn-primary" id="btnPasarAgente" >Permiso CAPSY</button> \';');
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
  if(elementos[i].name!="idPersonas")
  elementos[i].disabled=modo;
}
if(document.getElementById("idPersonas").value!=-1){

 }
}');
}
else
  {   



    echo('document.getElementById("divNuevaPersona").innerHTML=\'<button class="objetosResponsivos btn btn-primary" onclick="nuevoAgente(this)">Nuevo</button>\';'); 
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
for(var i=0;i<cont;i++){if(elementos[i].name!="idPersonas")elementos[i].disabled=modo;}
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
</script>
