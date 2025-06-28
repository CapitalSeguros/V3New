<!-- TipoRamo -->
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
				Ramo:
            </div>
			<div class="col-sm-4 col-md-4">
				<?
					print($SelectRamo);
				?>
            </div>

			<div class="col-sm-2 col-md-2" align="right">
            <?
				if($tipoRamo != ""){
					echo "SubRamo:";
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
        		Tipo Cliente:
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
        		Tipo Entidad:
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
        		Sexo:
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
        		Fecha Nacimiento:
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
        		Apellido Paterno:
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
        		Apellido Materno:
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
        		Nombre(s):
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
        		Celular:
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
        		Email:
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
            	Vendedor:
            </div>
			<div class="col-sm-9 col-md-9">
            	<? print($SelectVendedor); ?>
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	Poliza Captura Emision:
            </div>
        	<div class="col-sm-10 col-md-10" align="left">
            	<input 
                	type="text"
                    name="polizaNew" id="polizaNew"
                    style="width:50%;"
                />
            </div>
        </div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	Datos <?=$tipoActividad?> Expr&eacute;s:
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
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
            	<!-- <input type="" name="poliza" id="poliza" value="<?=$idPoliza?>" /> -->
                
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
            </div>
        </div>
        
        <div class="row" align="right">
			<div class="col-sm-12 col-md-12">
            <!--
                <input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" />
			Cotizaci&oacute;n Urgente !!!
            -->
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" />
                <input type="submit" value="<? echo "Guardar ".$this->uri->segment(3); ?>" />
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
                size="20" style="width:100%;"
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
                value="Buscar Otro"
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
            	Poliza Anterior:
            </div>
        	<div class="col-sm-10 col-md-10">
				<input type="text" value="<?=$idPoliza?>" style="width:100%;" />       
			</div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	Nombre Cliente:
            </div>
        	<div class="col-sm-10 col-md-10">
				<input type="text" value="<?=$informacionCliente[0]->NombreCompleto?>" style="width:100%;" />       
			</div>
		</div>
        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	Vendedor:
            </div>
			<div class="col-sm-10 col-md-10">
            	<? print($SelectVendedor); ?>
            </div>
		</div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	Poliza Captura Emision:
            </div>
        	<div class="col-sm-10 col-md-10" align="left">
            	<input 
                	type="text"
                    name="polizaNew" id="polizaNew"
                    style="width:50%;"
                />
            </div>
        </div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	Datos <?=$tipoActividad?> Expr&eacute;s:
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
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
            	<!-- <input type="" name="poliza" id="poliza" value="<?=$idPoliza?>" /> -->
                
				<!-- <input type="" name="IDVend" id="IDVend" value="<?=$IDVend?>" /> -->
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?=$usuarioResponsable?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?=$usuarioResponsable?>" />
            </div>
        </div>
        
        <div class="row" align="right">
			<div class="col-sm-12 col-md-12">
            <!--
                <input name="actividadUrgente" id="actividadUrgente" type="checkbox" title="Clic Para Seleccionar" value="1" />
			Cotizaci&oacute;n Urgente !!!
            -->
                <input type="button" value="Cancelar" onclick="window.open('<?=$urlCancelar?>','_self');" />
                <input type="submit" value="<? echo "Guardar ".$this->uri->segment(3); ?>" />
            </div>
        </div>
<?
		}
?>
        <?
		}
		?>