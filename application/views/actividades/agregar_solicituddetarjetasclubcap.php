<!-- TipoRamo -->
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
				<label class="labelResponsivo">Ramo:</label>
            </div>
			<div class="col-sm-4 col-md-4">
				<?
					print($SelectRamo);
				?>
            </div>

			<div class="col-sm-2 col-md-2" align="right">
            <?
				if($tipoRamo != ""){
					echo '<label class="labelResponsivo">SubRamo:</label>';
				}
			?>
            </div>
			<div class="col-sm-4 col-md-4">
            <?
				if($tipoRamo != ""){
					print($SelectSubRamo);
				}
			?>                
            </div>
        </div>
<!--* TipoRamo -->

<!-- TipoCliente -->
        <?
		if(
			$tipoActividad != ""
			&&
			$tipoRamo != ""
			&&
			$tipoSubRamo != ""
		){
		?>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Tipo Cliente:</label>
            </div>
			<div class="col-sm-10 col-md-10">
                <? print($SelectCliente); ?>
            </div>
        </div>
        <?
		}
		?>
<!--* TipoCliente -->

<!-- TipoCliente [Nuevo] -->
		<?
		if($tipoCliente == "Nuevo"){
		?>
		<form 
        	class="form-horizontal" role="form" 
            id="formActividadAgregar_clienteNuevo" name="formActividadAgregar_clienteNuevo"
			method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarGuardar"
		>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        	<label class="labelResponsivo">	Tipo Entidad:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <? print($SelectEntidad); ?>
            </div>
        </div>       
        <?
		if($tipoEntidad == "Fisica"){
		?>
<!-- Fisica -->
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Sexo:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <select name="Sexo" id="Sexo">
                	<option value="0">Masculino</option>
                	<option value="1">Femenino</option>
                </select>
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Fecha Nacimiento:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
            	<input 
                	type="text" name="fecha_nacimiento" id="fecha_nacimiento"
                    maxlength="10"
                    required="required"
                />
                <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>



    



        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Apellido Paterno:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="ApellidoP" name="ApellidoP" 
                	type="text"
                    style="width:90%;"
                    required="required"
                />
      
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Apellido Materno:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="ApellidoM" name="ApellidoM"
                	type="text"
                    style="width:90%;"
                    required="required"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Nombre(s):</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="Nombre" name="Nombre"
                	type="text"
                    style="width:90%;"
                    required="required"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Celular:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="Telefono1" name="Telefono1" 
                	type="tel"
                    style="width:90%;"
                    required="required"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		<label class="labelResponsivo">Email:</label>
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input
                	id="EMail1" name="EMail1"
                	type="email"
                    style="width:90%;"
                   
                />
            </div>
        </div>
<!--* Fisica -->
        <?
		}
		?>
        
        <?
		if($tipoEntidad == "Moral"){
		?>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		Fecha Constituci&oacute;n:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
            	<input 
                	type="text" name="fecha_constitucion" id="fecha_constitucion"
                    maxlength="10"
                    required="required"
                />
                <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>

        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
            	Raz&oacute;n Social
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Nombre" id="Nombre"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		Celular:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Telefono1" id="Telefono1"
                />
            </div>
        </div>
        <div class="row">
			<div class="col-sm-3 col-md-3">
        		Email:
            </div>
			<div class="col-sm-9 col-md-9" align="left">
                <input 
                	type="text"
                    style="width:90%;"
                    name="Email1" id="Email1"
                />
            </div>
        </div>
        <?
		}
		?>
        
        <?
		if($tipoEntidad != ""){
		?>
        <div class="row">
			<div class="col-sm-3 col-md-3">
            	<label class="labelResponsivo">Vendedor:</label>
            </div>
			<div class="col-sm-9 col-md-9">
            	<? print($SelectVendedor); ?>
            </div>
		</div>

		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'SOLICITUD DE TARJETAS CLUB CAP DE LA POLIZA:'.$idPoliza:''?>
                    </textarea>
					<?php echo display_ckeditor($ckeditor); ?>
            </div>
        </div>
		<div class="row" style="padding-bottom:-60px;">
        	<div class="col-sm-2 col-md-2" align="right">
            	&nbsp;
            </div>
        	<div class="col-sm-10 col-md-10"> 
				<?=($TextoExpresAsteriscos != false)?$TextoExpresAsteriscos->row()->textoExpres_asteriscos:''?>
            </div>
		</div>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<input type="hidden" name="tipoActividad" id="tipoActividad" value="<?=$tipoActividad?>" />
            	<input type="hidden" name="tipoRamo" id="tipoRamo" value="<?=$tipoRamo?>" />
            	<input type="hidden" name="tipoSubRamo" id="tipoSubRamo" value="<?=$this->capsysdre_actividades->SubRamoActivicad($tipoSubRamo)?>" />
            	<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?=$tipoCliente?>" />
            	<input type="hidden" name="TipoEnt" id="TipoEnt" value="<?=$TipoEnt?>" />        
				<input type="hidden" name="IDDir" id="IDDir" value="-1" />
            	<input type="hidden" name="IDAgente" id="IDAgente" value="63" />                                
            	<input type="hidden" name="IDGrupo" id="IDGrupo" value="1" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$tipoActividadSicas?>" />
            	<input type="hidden" name="TipoDocto" id="TipoDocto" value="<?=$TipoDocto?>" /><!-- -->
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?=$IDEjecut?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
                
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
            </div>
        </div>
        
        <div class="row" align="right">
			<div class="col-sm-12 col-md-12">
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" id="cancelarActividad"/>
                <input type="submit" value="<? echo "Guardar ".$this->uri->segment(3); ?>" id="guardarActividad"/>
            </div>
        </div>
</form>
        <?
		}
		?>
<!--* TipoCliente [Nuevo] -->

<!-- TipoCliente [Existente] -->
        <?
		} else if($tipoCliente == "Existente") {
		?>
		<?
if(!$busquedaClienteProspecto && !$idCliente){
		?>
		<form
			class="form-horizontal" role="form" 
		    id="formActividadAgregar_BuscarClienteProspecto" name="formActividadAgregar_BuscarClienteProspecto" 
		    action="<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>"
		>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Buscar Cliente:
            </div>
			<div class="col-sm-10 col-md-10">
            	<input 
                	type="text"
                    name="busquedaClienteProspecto" id="busquedaClienteProspecto"
                    style="width:100%;"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12" align="right">
                <input 
                	type="submit" name="buttonBuscar" id="buttonBuscar" value="Buscar"
                />
            </div>
		</div>
        

		</form>
<?
		} else if(isset($busquedaClienteProspecto) && $busquedaClienteProspecto != ""){
?>

        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Clientes:
            </div>
			<div class="col-sm-10 col-md-10">
            <select
            	name="IDCli" id="IDCli" 
                onDblClick="SeleccionIdCliente(this.value, '<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>')" 
                size="5" style="width:100%;"
            >
            	<?
				if(!empty($ListaClienteProspecto) && count($ListaClienteProspecto) > 0){
					foreach ($ListaClienteProspecto as $Registro){
				?>
					<option value="<?=$Registro->IDCli."-".$Registro->IDCont?>"  title="<?=$this->capsysdre->NombreVendedor($Registro->FieldInt1)?>">
						<?=$Registro->NombreCompleto?>
					</option>
				<?
					}
				} else {
				?>
					<option value="false">
						Cliente No Encontrado !!!
					</option>
                <?
				}
				?>          
            </select>
            </div>
		</div>
        <div class="row">
        	<div class="col-sm-12 col-md-12" align="right">
            <input 
            	type="button"
                onclick="window.open('<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>','_self');"
                value="Buscar Otro" id="buscarOtroClient"
            />


            <input 
                type="button"
                onclick="SeleccionIdCliente(document.getElementById('IDCli').value, '<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>')" 
                value="Escoger" id="escogerClient"
                class="btn btn-primary btn-sm"
            />


            </div>
        </div>
<?
		}/*! If-busquedaClientePropecto-idCliente */
?>

<?
		if(isset($idCliente) && $idCliente != ""){
?>
		<form 
        	class="form-horizontal" role="form"
            id="formActividadAgregar_clienteExistente" name="formActividadAgregar_clienteExistente"
            method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarGuardar"
		>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            <label class="labelResponsivo">	Nombre Cliente: </label>
            </div>
        	<div class="col-sm-10 col-md-10">
				<input type="text" value="<?=$informacionCliente[0]->NombreCompleto?>" style="width:100%;" id="clienteEscogido"/>       
			</div>
		</div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
         <label class="labelResponsivo">    	Vendedor:</label>
            </div>
			<div class="col-sm-10 col-md-10">
            	<? print($SelectVendedor); ?>
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
             <label class="labelResponsivo">	Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">

					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'SOLICITUD DE TARJETAS CLUB CAP DE LA POLIZA: '.$idPoliza:''?>
                    </textarea>
					<?php echo display_ckeditor($ckeditor); ?>
            </div>
        </div>
		<div class="row" style="padding-bottom:-60px;">
        	<div class="col-sm-2 col-md-2" align="right">
            	&nbsp;
            </div>
        	<div class="col-sm-10 col-md-10"> 
				<?=($TextoExpresAsteriscos != false)?$TextoExpresAsteriscos->row()->textoExpres_asteriscos:''?>
            </div>
		</div>
        <?
			//include();
        ?>
        <div class="row">
			<div class="col-sm-12 col-md-12">
				<input type="hidden" name="tipoActividad" id="tipoActividad" value="<?=$tipoActividad?>" />
            	<input type="hidden" name="tipoRamo" id="tipoRamo" value="<?=$tipoRamo?>" />
            	<input type="hidden" name="tipoSubRamo" id="tipoSubRamo" value="<?=$this->capsysdre_actividades->SubRamoActivicad($tipoSubRamo)?>" />                
            	<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?=$tipoCliente?>" />
            	<input type="hidden" name="IDCli" id="IDCli" value="<?=$informacionCliente[0]->IDCli?>" />
            	<input type="hidden" name="IDCont" id="IDCont" value="<?=$informacionCliente[0]->IDCont?>" />        
				<input type="hidden" name="IDDir" id="IDDir" value="-1" />
            	<input type="hidden" name="IDAgente" id="IDAgente" value="63" />                                
            	<input type="hidden" name="IDGrupo" id="IDGrupo" value="1" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$tipoActividadSicas?>" />
            	<input type="hidden" name="TipoDocto" id="TipoDocto" value="<?=$TipoDocto?>" /><!-- -->
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?=$IDEjecut?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                
				<!-- <input type="" name="IDVend" id="IDVend" value="<?=$IDVend?>" /> -->
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="IDUserR" id="IDUserR" value="<?=$IDUserR?>" />
                <input type="hidden" name="IDTTarea" id="IDTTarea" value="<?=$IDTTarea?>" />

                
            </div>
        </div>
        
        <div class="row" align="right">
			<div class="col-sm-12 col-md-12">
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" id="cancelarActividad"/>
                <input type="submit" id="guardarForm" value="<? echo "Guardar ".$this->uri->segment(3); ?>" />
            </div>
        </div>
<?
		}
?>
        <?
		}
		?>