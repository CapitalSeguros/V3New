
<!--/////////////////////////REGISTRA DIMENSION/////////////////////-->
<?
	//$this->load->view('headers/header');
	$this->load->view('headers/headerReportes');
	//$this->load->view('crmproyecto/notificacion');

?>
<style type="text/css">
 .botonAdd{
  width: 70%; 
    border-style: solid;
    border-color: silver;
    border-radius: 8px;
    border-width: 1px;
    padding-top: 5%;
    padding-bottom: 5%;
    text-align: center;
    color: #000;
    background-color: #fff;
    font-size: 14px;
    font-family: verdana;
    transition: 0.3s;
  }
  .botonAdd:hover{
    background-color: #d5e5f5;
    border-color: #d5e5f5;
  }
  .botonLabelAP{display: flex;flex-direction: column;align-items: center;}
  .botonLabelAP label{justify-content: flex-start;width: 70%}
  
</style>

 <!--********* Modificacion 05/11/2020-->
<center>

<input type="hidden" id="base_url" data-url="<?=base_url()?>">
<div class="column-flex-center-center" id="menuAltaProspecto">
  <div class="botonLabelAP"><button class="botonAdd" onclick="activar_persona()"><img src="<?= base_url()?>assets/images/crm/alta_masivo.png" width="90%"></button><label class="subtitleSeg">Prospecto Persona</label></div>
  <div class="botonLabelAP"><button class="botonAdd" onclick="activar_generico()"><img src="<?= base_url()?>assets/images/crm/alta_generico.png" width="90%"></button><label class="subtitleSeg">Prospecto Fianzas</label></div>
  <?if($imprimirSelecVendedor){?>
  <div class="botonLabelAP"><button class="botonAdd"  onclick="activar_agente()"><img src="<?= base_url()?>assets/images/crm/alta_generico.png" width="90%"></button><label class="subtitleSeg">Prospecto Agente</label></div>
   <?}?>
  <div class="botonLabelAP"><button class="botonAdd" onclick="cargarPagina('crmproyecto/importar_prospectos')"><img src="<?= base_url()?>assets/images/crm/alta_masivo.png" width="90%"></button><label class="subtitleSeg" class="">Importacíon Masiva de Prospectos</label></div>
</div>
<div id="div_seleccion"  style="width: 70%;margin-top: 2%;">
</div>
<!--table style="width: 100%;">
    <tr><td colspan="3" style="text-align: center;"><h3>Seleccione Opción</h3></td></tr>
    <tr><td colspan="3">&nbsp;</td></tr>
    <tr>
      <td style="text-align: center;">
        <button class="botonAdd" onclick="activar_persona()">
        <img src="<?= base_url()?>assets/images/crm/alta_masivo.png" width="100%">
      </button>
      </td>
      <td style="text-align: center;">
        <button class="botonAdd" onclick="activar_generico()">
          <img src="<?= base_url()?>assets/images/crm/alta_generico.png" width="100%">
         </button>
      </td>
      <td style="text-align: center;">
        <button class="botonAdd" onclick="cargarPagina('crmproyecto/importar_prospectos')">
          <img src="<?= base_url()?>assets/images/crm/alta_masivo.png" width="100%">
         </button>
      </td>
    
      <td style="text-align: center;">
        <button class="botonAdd"  onclick="activar_agente()">
          <img src="<?= base_url()?>assets/images/crm/alta_generico.png" width="100%">
         </button>
      </td>
    </tr>
    <tr>
      <td style="text-align: center;">
        <div style="font-size: 12px;">Prospecto<br>Persona</div>
      </td>
      <td style="text-align: center;">
          <div style="font-size: 12px;">Prospecto<br>Fianzas</div>
      </td>
      <td style="text-align: center;">
          <div style="font-size: 12px;">Importacíon Masiva<br>de Prospectos</div>
      </td>
      <td style="text-align: center;">
          <div style="font-size: 12px;">Prospecto<br>Agente</div>
      </td>

    </tr>
  </table-->

</center>



<!--Div Persona-->
<div id="div_persona" style="display: none;">
<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><h3 class="titulo-secciones">Prospeccion de negocios: Alta de Prospecto Persona</h3></div></div><hr class="title-hr"> 
</section>
<div class="panel panel-default">
<div class="panel-body">
	<form method="post" class="form" role="formdimension" id="formdimension" name="formdimension" action="<?= base_url()?>crmproyecto/InsertaDimension/">    
  <input type="hidden" name="tipo_prospecto" id="tipo_prospecto" value="0">     
		<div class="row">
        	<div class="col-md-3 width-ajust pd-items-table"><label for="tipo" class="mg-cero" style="font-size:15px; font-weight:bold;">Persona Moral <input type="radio" name="tipo" id="tipo" value="Moral" data-type="persona" class="form-check-input" onclick="statusCheckbox(this)"> </label></div>
          <div class="col-md-3 pd-items-table"><label class="subtitleSeg">Persona Referida: <input type="checkbox" class="form-check-input" name="referido" id="referidoMoral" data-type="persona" value="Moral" disabled></label></div>
		</div>

		<div class="row pd-bottom">
        	<div class="col-sm-6 col-md-6">
			<label class="subtitleSeg" for="razon">Razón:</label><input type="text"  name="razon" id="razon" class="form-control" placeholder="Razón Social">
             </div>
           
        	<div class="col-sm-6 col-md-6">
				<label class="subtitleSeg" for="rfc">RFC:</label><input type="text"  name="rfc" id="rfc" class="form-control" placeholder="RFC">
       	  	</div>
		</div>
        
		<div class="row">
        	<div class="col-md-3 width-ajust pd-items-table">
		     <label for="tipo2" class="mg-cero" style="font-size:15px; font-weight:bold;">Persona Física <input type="radio" name="tipo" id="tipo2" value="Fisica" class="form-check-input" data-type="persona" onclick="statusCheckbox(this)"></label>
       	  	</div>
          <div class="col-md-3 pd-items-table"><label class="subtitleSeg">Persona Referida: <input type="checkbox" class="form-check-input" name="referido" id="referidoFisica" data-type="persona" value="Fisica" disabled></label></div>
		</div>

		<div class="row">
        	<div class="col-sm-12 col-md-12 pd-items-table">

    		        <label class="subtitleSeg" for="nombre">Nombres:</label>
	        	    <input type="text"  name="nombre" id="nombre" class="form-control" placeholder="Nombre">

       	  	</div><!-- /col -->
           
        	<div class="col-sm-6 col-md-6 pd-items-table">

		            <label class="subtitleSeg" for="apellidop">A. Paterno:</label>
        		    <input type="text"  name="apellidop" id="apellidop" class="form-control" placeholder="Apellido Paterno">

       	  	</div><!-- /col -->
            
        	<div class="col-sm-6 col-md-6 pd-items-table">

		            <label class="subtitleSeg" for="apellidom">A. Materno:</label>
        		    <input type="text"  name="apellidom" id="apellidom" class="form-control" placeholder="Apellido Materno">
 
       	  	</div><!-- /col -->
		</div><!-- /row -->
        
		<div class="row">
        	<div class="col-sm-6 col-md-6 pd-items-table">
				
    		        <label class="subtitleSeg" for="email">Email:</label>
					<input
						type="email" name="email" id="email"
                        placeholder="Email xx@yy.com" class="form-control"
                        pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                    />
            
       	  	</div><!-- /col -->
           
        	<div class="col-sm-6 col-md-6 pd-items-table">
				
		            <label class="subtitleSeg" for="celular">Tel Cel:</label>
					<input 
                    	type="text"  name="celular" id="celular" 
                        placeholder="10 Digitos" maxlength="10" class="form-control"
                    	onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
					>
                
       	  	</div><!-- /col -->
          
		 <!-- Modificacion 05/11/2020-->

          <div class="col-sm-6 col-md-6 pd-items-table">
            <label class="subtitleSeg">Red Social 1:</label>
          <input type="text" name="red1" id="red1" placeholder="Red Social" class="form-control"/>
          </div><!-- /col -->
           
          <div class="col-sm-6 col-md-6 pd-items-table">
            <label class="subtitleSeg">Red Scocial 2:</label>
          <input type="text"  name="red2" id="red2" placeholder="Red Social" class="form-control">
          </div><!-- /col -->
          <div class="col-sm-6 col-md-6 pd-items-table">
              <label class="subtitleSeg">Fecha de Nacimiento:</label>
              <input type="date" name="fNac" id="fNac" class="form-control" placeholder="Agregue la Fecha de Nacimiento">
          </div>

<div class="col-sm-6 col-md-6 pd-items-table">
              <label class="subtitleSeg">Codigo Postal:</label>
              <input type="text" name="codigoPostal" id="codigoPostal" class="form-control" placeholder="Agregue CP">
          </div>
           <!-- fin--> 

<div class="col-sm-12 col-md-12 pd-items-table">
              <label class="subtitleSeg" for="detalles">Observación:</label>
              <input type="text" name="observacion" id="observacion" class="form-control" placeholder="Escriba algúna observacion ó comentario">
          </div>
          <div class="col-sm-12 col-md-12 pd-items-table">
            <?if($imprimirSelecVendedor){?>
              <label class="subtitleSeg" for="detalles">Vendedores</label>
            
             <select id="selectProspectoPersona" name="selectVendedor" class="form-control"><?=imprimirSelecPersonas($personaTipoPersonaCatalogo)?></select>
             <?}?>
          </div>
        	<div class="col-sm-2 col-md-2" align="right">
			
                <br />
                    <input 
                    	type="button" name="button" id="button" 
                        value="Agregar Prospecto Persona" class="btn btn-primary" 
                        onclick="SendForm_JjHe()" 
                    />
              
       	  	</div><!-- /col -->
		</div><!-- /row -->

		</form>
</div>
</div>
</div>
<!-- Div de persona generica-->

<div id="div_generico" style="display: none;">
<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><h3 class="titulo-secciones">Prospeccion de negocios: Alta de Prospecto Fianzas</h3></div></div><hr class="title-hr"> 
</section>
<div class="panel panel-default">
<div class="panel-body">  
  <form method="post" class="form" role="formdimension" id="formdimension_generico" name="formdimension_generico" action="<?= base_url()?>crmproyecto/InsertaDimension_generico/">  
  <input type="hidden" name="tipo_prospecto_generico" id="tipo_prospecto_generico" value="1">      
    <div class="row">
          <div class="col-md-3 width-ajust pd-items-table"><label for="tipo" class="mg-cero" style="font-size:15px; font-weight:bold;">Persona Moral <input type="radio" name="tipo_generico" id="tipo_generico" value="Moral" data-type="fianza" class="form-check-input" onclick="statusCheckbox(this)"> </label></div>
          <div class="col-md-3 pd-items-table"><label class="subtitleSeg">Persona Referida: <input type="checkbox" class="form-check-input" name="referido" id="referidoMoralF" data-type="fianza" value="Moral" disabled></label></div>
    </div>

    <div class="row pd-bottom">
          <div class="col-sm-6 col-md-6 pd-items-table">
      <label class="subtitleSeg" for="razon">Razón:</label><input type="text"  name="razon_generico" id="razon_generico" class="form-control" placeholder="Razón Social">
             </div>
           
          <div class="col-sm-6 col-md-6 pd-items-table">
        <label class="subtitleSeg" for="rfc">RFC:</label><input type="text"  name="rfc_generico" id="rfc_generico" class="form-control" placeholder="RFC">
            </div>
    </div>
        
    <div class="row">
          <div class="col-md-3 width-ajust">
         <label for="tipo2" class="mg-cero" style="font-size:15px; font-weight:bold;">Persona Física <input type="radio" name="tipo_generico" id="tipo2_generico" value="Fisica" class="form-check-input" data-type="fianza" onclick="statusCheckbox(this)"></label>
            </div>
          <div class="col-md-3"><label class="subtitleSeg">Persona Referida: <input type="checkbox" class="form-check-input" name="referido" id="referidoFisicaF" data-type="fianza" value="Fisica" disabled></label></div>
    </div>

    <div class="row">
          <div class="col-sm-12 col-md-12 pd-items-table">

                <label class="subtitleSeg" for="nombre">Nombres:</label>
                <input type="text"  name="nombre_generico" id="nombre_generico" class="form-control" placeholder="Nombre">

            </div><!-- /col -->
           
          <div class="col-sm-6 col-md-6 pd-items-table">

                <label class="subtitleSeg" for="apellidop">A. Paterno:</label>
                <input type="text"  name="apellidop_generico" id="apellidop_generico" class="form-control" placeholder="Apellido Paterno">

            </div><!-- /col -->
            
          <div class="col-sm-6 col-md-6 pd-items-table">

                <label class="subtitleSeg" for="apellidom">A. Materno:</label>
                <input type="text"  name="apellidom_generico" id="apellidom_generico" class="form-control" placeholder="Apellido Materno">
 
            </div><!-- /col -->
    </div><!-- /row -->
        
    <div class="row">
          <div class="col-sm-6 col-md-6 pd-items-table">
        
                <label class="subtitleSeg" for="email">Email:</label>
          <input
            type="email" name="email_generico" id="email_generico"
                        placeholder="Email xx@yy.com" class="form-control"
                        pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                    />
            
            </div><!-- /col -->
           
          <div class="col-sm-6 col-md-6 pd-items-table">
        
                <label class="subtitleSeg" for="celular">Tel Cel:</label>
          <input 
                      type="text"  name="celular_generico" id="celular_generico" 
                        placeholder="10 Digitos" maxlength="10" class="form-control"
                      onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;"
          >
                
            </div><!-- /col -->
	  
<!-- Modificacion 05/11/2020-->

          <div class="col-sm-6 col-md-6 pd-items-table">
            <label class="subtitleSeg">Red Social 1:</label>
          <input type="text" name="red1_generico" id="red1_generico" placeholder="Red Social" class="form-control"/>
          </div><!-- /col -->
           
          <div class="col-sm-6 col-md-6 pd-items-table">
            <label class="subtitleSeg">Red Scocial 2:</label>
          <input type="text"  name="red2_generico" id="red2_generico" placeholder="Red Social" class="form-control">
          </div><!-- /col -->
           <!-- fin--> 


          <div class="col-sm-12 col-md-12 pd-items-table">
              <label class="subtitleSeg" for="detalles">Observación:</label>
              <input type="text" name="observacion_generico" id="observacion_generico" class="form-control" placeholder="Escriba algúna observacion ó comentario">
          </div>
<div class="col-sm-12 col-md-12 pd-items-table">
  <?if($imprimirSelecVendedor){?>
              <label class="subtitleSeg" for="detalles">Vendedores</label>
             <select id="selectProspectoGenerico" name="selectVendedor" class="form-control"><?=imprimirSelecPersonas($personaTipoPersonaCatalogo)?></select>
<?}?>
          </div>
          <div class="col-sm-2 col-md-2" align="right">
      
                <br />
                    <input 
                      type="button" name="button" id="button" 
                        value="Agregar Prospecto Fianzas" class="btn btn-primary" 
                        onclick="SendForm_JjHe_generico()" 
                    />
              
            </div><!-- /col -->
    </div><!-- /row -->

    </form>
</div>
</div>
</div>

<!-- Div de Persona Agentes-->
<div id="div_agente" style="display: none;">
<section class="container-fluid breadcrumb-formularios"><div class="row"><div class="col-md-8 col-sm-8 col-xs-8"><h3 class="titulo-secciones">Prospeccion de Agentes</h3></div><div class="col-md-4 column-flex-end">
    <div><button class="btn btn-primary" onclick="cargarPagina('crmproyecto/importar_prospectos_agentes')"><i class="fa fa-upload"></i>&nbsp;Importación Masiva de Agentes</button>
          </div></div></div><hr class="title-hr">
</section>
<div class="container-fluid"> <!--band-->
  <form method="post" role="formdimension" id="formdimension_agentes" name="formdimension_agentes" action="<?= base_url()?>crmproyecto/InsertaDimension_agente/">
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
              <input type="text" class="form-control" id="colonia" name="colonia" placeholder="cruzamiento">
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
              <div class="form-group">
                <label class="subtitleSeg">Persona Referida: <input type="checkbox" class="form-check-input" name="referido" id="referidoAgente" value="1"></label>
              </div>
            </div>
            <div class="col-md-4">
              <p>Agregar en caso de no estar en la lista.</p>
              <div class="row">
                <div class="col-md-9"><input type="email" id="newAssign" class="form-control"></div>
                <div class="col-md-3"><button class="btn btn-primary btn-xs mt-2 agreeAssing">Agregar</button></div>
              </div>
            </div>
        </div>
      </div>
      <div class="col-md-12 text-center mt-6">
        <input type="submit" value="Agregar Prospecto Agentes" class="btn btn-primary"/>
      </div>
    </div>
  </form>
</div>
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

<?php

function imprimirSelecPersonas($datos)
{
  
  $option='<optgroup label=""><option data-value="0" value="">Escoger Vendedor</option></optgroup>';
  foreach ($datos as $key1 => $value1) 
  {
  
    $option.='<optgroup label="'.$key1.'">';
    foreach ($value1 as $key => $value) 
    {
     $nombres=$value->apellidoPaterno.' '.$value->apellidoMaterno.' '.$value->nombres;
   $option.='<option data-value="'.$value->idPersona.'" value="'.$value->email.'">'.$nombres.' <label class="subtitleSeg">     ('.$value->email.')</label></option>';  
    }
    $option.='</optgroup>';
  
  }
  return $option;

}
?>

        
