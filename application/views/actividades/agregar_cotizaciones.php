
<!-- TipoRamo -->
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
			<label class="labelResponsivo">Ramo:</label>
            </div>
			<div class="form-group col-sm-4 col-md-4">
				<?
					print($SelectRamo);
				?>
            </div>

			<div class="form-group col-sm-2 col-md-2" align="right">
            <?
				if($tipoRamo != ""){
					echo '<label class="labelResponsivo">SubRamo:</label>';
				}
			?>
            </div>
			<div class="form-group col-sm-4 col-md-4">
            <?
				if($tipoRamo != ""){
					print($SelectSubRamo);
				}
			?>                
            </div>
        </div>
        <? if(isset($_GET['idCotizaDirectorio'])){echo('<input type="hidden"  id="idCotizaDirectorio">');}?>
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
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Tipo Cliente:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
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
            id="formActividadAgregar_clienteNuevo" name="formActividadAgregar_clienteNuevo"
			method="post" enctype="multipart/form-data"
            action="<?=base_url()?>actividades/agregarGuardar" onsubmit="verificarDatos(event)"
		>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        	<label class="labelResponsivo">Tipo Entidad:</label>
            </div>
            <div class="form-group col-sm-10 col-md-10">
                <? print($SelectEntidad); ?>
            </div>
        </div>       
        <?
		if($tipoEntidad == "Fisica"){
		?>
<!-- Fisica -->
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Sexo:</label>
            </div>
			<div class="form-group col-sm-5 col-md-5">
                <select 
                	name="Sexo" id="Sexo"
					class="form-control input-sm"
                >
                	<option value="0">Masculino</option>
                	<option value="1">Femenino</option>
                </select>
            </div>
        </div>

        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Fecha Nacimiento:</label>
            </div>
			<div class="form-group col-sm-5 col-md-5">
				<div class="input-group">
	            	<input
    	            	type="text" name="fecha_nacimiento" id="fecha_nacimiento"
						class="form-control input-sm"
            	        maxlength="10" required="required"
	                />
					<span class="input-group-btn">
                    	<button class="btn">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</span>
				</div>
			</div>
		<? //ENLACE PROYECTO 100
			if($IDPcien > 0){
		?>
			<div class="form-group col-sm-2 col-md-2" align="right">
				<label class="labelResponsivo" style="color:#F00;">
                	<strong>Enlace Proyecto 100:</strong>
				</label>
			</div>
			<div class="form-group col-sm-3 col-md-3" align="left">
				<input 
					type="text" name="IDPcien" id="IDPcien"
					maxlength="10" size="8"
					class="form-control input-sm"
					readonly=""  value="<?= $IDPcien; ?>" 
				/>
            </div>
		<?
			}
		?>
		</div>

        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Apellido Paterno:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                	id="ApellidoP" name="ApellidoP" 
                	type="text"
					class="form-control input-sm"
                    required="required" value="<?= $tipoAPATERNO  ?>" 
                />
      
            </div>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Apellido Materno:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                	id="ApellidoM" name="ApellidoM"
                	type="text"
					class="form-control input-sm"
                    required="required"  value="<?= $tipoAMATERNO  ?>"
                />
            </div>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Nombre(s):</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                	id="Nombre" name="Nombre"
                	type="text"
					class="form-control input-sm"
                    required="required" value="<?= $tipoNOMBRES  ?>" 
                />
            </div>
        </div>
                <?php if(isset($estados)) {?>
        <div class="row">
                    <div class="form-group col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Estados:
                </label>
            </div> 
             <div class="form-group col-sm-10 col-md-10">
                <select name="claveEstado" id="claveEstado"><?php echo(imprimirEstados($estados)); ?></select>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($giroCatalogo)) {?>
        <div class="row">
                    <div class="form-group col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Giro:
                </label>
            </div> 
             <div class="form-group col-sm-10 col-md-10">
                <select name="giroCliente" id="giroCliente"><?php echo(imprimirGiroCatalogo($giroCatalogo)); ?></select>
                <button onclick="abrirModal(event)">+</button>
            </div>
        </div>
                <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                   Actividad:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <input type="text" name="giroActividad" id="giroActividad" >
            </div>
        </div>
        <?php } ?>

        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Celular:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                	id="Telefono1" name="Telefono1" 
                	type="tel"
					class="form-control input-sm"
                    required="required" value="<?= $tipoCEL  ?>" 
                />
            </div>
        </div>

        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        		<label class="labelResponsivo">Email:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                	id="EMail1" name="EMail1"
                	type="email"
					class="form-control input-sm"
                    value="<?= $tipoEMAIL;  ?>"
                />
            </div>
        </div>
        <?php if(isset($permisos['polizaVerde'])){ ?>
               <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
        <?php  } ?>   
  
<!--* Fisica -->
        <?
		}
		?>
        
        <?
		if($tipoEntidad == "Moral"){
		?>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
        	<label class="labelResponsivo">Fecha Constituci&oacute;n:</label>
            </div>            
			<div class="form-group col-sm-5 col-md-5">
				<div class="input-group">
	            	<input 
    	            	type="text" name="fecha_constitucion" id="fecha_constitucion"
						class="form-control input-sm"
        	            maxlength="10" required="required"
	                />
					<span class="input-group-btn">
                    	<button class="btn">
							<i class="glyphicon glyphicon-calendar"></i>
						</button>
					</span>
				</div>
			</div>
		<? //ENLACE PROYECTO 100
			if($IDPcien > 0){
		?>
			<div class="form-group col-sm-2 col-md-2" align="right">
				<label class="labelResponsivo" style="color:#F00;">
                	<strong>Enlace Proyecto 100:</strong>
				</label>
			</div>
			<div class="form-group col-sm-3 col-md-3" align="left">
				<input 
					type="text" name="IDPcien" id="IDPcien"
					maxlength="10" size="8"
					class="form-control input-sm"
					readonly=""  value="<?= $IDPcien; ?>" 
				/>
            </div>
		<?
			}
		?>
        </div>
        
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
	        	<label class="labelResponsivo">
    	        	Raz&oacute;n Social
				</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input 
                    name="Nombre" id="Nombre"
                	type="text" required="required"
					class="form-control input-sm"
					value="<?= $Razon; ?>"
                />
            </div>
        </div>
        <?php if(isset($estados)) {?>
        <div class="row">
                    <div class="form-group col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Estados:
                </label>
            </div> 
             <div class="form-group col-sm-10 col-md-10">
                <select name="claveEstado" id="claveEstado"><?php echo(imprimirEstados($estados)); ?></select>
            </div>
        </div>
        <?php } ?>
        <?php if(isset($giroCatalogo)) {?>
        <div class="row">
                    <div class="form-group col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                    Giro:
                </label>
            </div> 
             <div class="form-group col-sm-10 col-md-10">
                <select name="giroCliente" id="giroCliente"><?php echo(imprimirGiroCatalogo($giroCatalogo)); ?></select>
            </div>
        </div>
                        <div class="row">
                    <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">
                   Actividad:
                </label>
            </div> 
             <div class="col-sm-9 col-md-9" align="left">
                <input type="text" name="giroActividad" id="giroActividad" >
            </div>
        </div>
        <?php } ?>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
	        	<label class="labelResponsivo">
	        		Celular:
                </label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
					name="Telefono1" id="Telefono1"
					type="text" required="required"
					class="form-control input-sm"
					value="<?= $tipoCEL; ?>" 
                />
            </div>
        </div>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
	        	<label class="labelResponsivo">
	        		Email:
                </label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
                <input
                    name="Email1" id="Email1"
                	type="text"
					class="form-control input-sm"
                    value="<?= $tipoEMAIL;  ?>"
                />
            </div>
        </div>
        <?php if(isset($permisos['polizaVerde'])){ ?>
               <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
        <?php  } ?>   
        <?
		}
		?>
        
        <?
		if($tipoEntidad != ""){
		?>
        <div class="row">
			<div class="form-group col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Vendedor:</label>
            </div>
			<div class="form-group col-sm-10 col-md-10">
            	<? print($SelectVendedor); ?>
            </div>
		</div>
        <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
             <label class="labelResponsivo">Seleccionar companias:</label>
            </div>
            <div class="col-sm-10 col-md-10" id="divEleccionCompania" >
            <?
				if(isset($companias)){
					//$opciones	= "";
					foreach($companias as $value){
						//$opciones = $opciones.'<label class="labelResponsivo" style="border:solid 1px black">'.$value->Promotoria.'<input type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="form-control input-sm cbCompania" value="'.$value->idPromotoria.'"></label>';
			?>
			<div class="col-sm-4 col-md-4" align="left">
						<div class="form-check form-check-inline" style="border:solid 1px #CCC; background-color:#EEE; opacity: 0.8;" align="center">
							<label class="form-check-label" for="inlineCheckbox1"><?= $value->Promotoria ?></label>
                            <br />
							<input class="form-check-input form-control input-sm cbCompania" type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" value="<?= $value->idPromotoria;?>">
						</div>
                        <br />
			</div>

            <?
					}
					//print($opciones);
				}
			?>
        </div>
        </div>
		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">
					<textarea name="datosExpres" id="datosExpres"  style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'COTIZACION DE LA POLIZA: '.$idPoliza:''?>
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
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?= isset($IDEjecut) ? $IDEjecut : '' ?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?= isset($usuarioResponsable) ? $usuarioResponsable : '' ?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?= isset($usuarioResponsable) ? $usuarioResponsable : '' ?>" />
            </div>
        </div>
        
        <br /><br />
        
        <div class="row">
			<div class="col-sm-4 col-md-4">
            	&nbsp;
            </div>
			<div class="col-sm-2 col-md-2">
        	<?
			if($tipoSubRamo!='17' && $tipoSubRamo!='19' && $tipoSubRamo!='21'){
			?>

            	<center title="Negocios importantes arriba de $50,000 de prima">
				Cotizaci&oacute;n Importante ...
				<br />
				<input 
                	name="actividadImportante" id="actividadImportante" 
                    type="checkbox" title="Clic Para Seleccionar vvvvv" 
                    value="1" 
				/>
				</center>

            <?
			} else {
			?>
            	&nbsp;
            <?
			}
			?>
            </div>
			<div class="col-sm-2 col-md-2">
				<center>
                Cotizaci&oacute;n Urgente !!!
                <br />
                <input 
                	name="actividadUrgente" id="actividadUrgente" 
                    type="checkbox" title="Clic Para Seleccionar" 
                    value="1" 
                />
                </center>
            </div>
			<div class="col-sm-2 col-md-2" align="center">
                <input 
                	type="button"
					id="cancelarActividad" value="Cancelar"
					class="btn btn-primary btn-sm"
                    onclick="window.open('<?=$urlCancelar?>','_self');" 
                />
			</div>
			<div class="col-sm-2 col-md-2" align="center">
                <input 
                	type="submit" 
                    id="guardarActividad" value="<?= "Guardar ".$this->uri->segment(3); ?>" 
					class="btn btn-primary btn-sm ocultarObjeto"
                />
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
			<div class="col-sm-10 col-md-10" align="right">
            	<div class="input-group">
                	<input
                        id="busquedaClienteProspecto" name="busquedaClienteProspecto" 
                    	type="text" class="form-control input-sm"
                        placeholder="Buscar Cliente" title="Bucar - Clic Aqu&iacute;"
                    >
                    <span class="input-group-btn">
                    	<button id="btnBuscaClient" class="btn btn-primary btn-sm search-trigger"><i class="fa fa-search fa-sm"></i>&nbsp;</button>
                    </span>
				</div>
			</div>
		</form>
<?
		} else if(isset($busquedaClienteProspecto) && $busquedaClienteProspecto != ""){
?>

        <div class="row">
			<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Clientes:</label>
            </div>
			<div class="col-sm-10 col-md-10">
            <select
            	name="IDCli" id="IDCli" 
                onDblClick="SeleccionIdCliente(this.value, '<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>')" 
                size="20"
                class="form-control"
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
            	&nbsp;
            </div>
		</div>		
        <div class="row">
        	<div class="col-sm-12 col-md-12" align="right">
            <input 
            	type="button"
                onclick="window.open('<?=base_url()."actividades/agregar/".$tipoActividad."/".$tipoRamo."/".$tipoSubRamo."/".$tipoCliente?>','_self');"
                value="Buscar Otro" id="buscarOtroClient"
                class="btn btn-primary btn-sm"
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
            action="<?=base_url()?>actividades/agregarGuardar" onsubmit="verificarDatos(event)"
		>
		<div class="row" style="padding-bottom:15px;">
        	<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Nombre Cliente:</label>
            </div>
        	<div class="col-sm-10 col-md-10">
				<input 
                	type="text" 
                    id="clienteEscogido" name="clienteEscogido"
					class="form-control input-sm"
                	value="<?=$informacionCliente[0]->NombreCompleto?>"
                />  

			</div>
		</div>

        <div class="row" style="padding-bottom:15px;">
            <div class="col-sm-2 col-md-2" align="right">
                <label class="labelResponsivo">Celular:</label>
            </div>

            <div class="col-sm-10 col-md-10">
                <input
                    id="Telefono1" name="Telefono1" 
                    type="tel"
					class="form-control input-sm"
                    required="required" value="<?=str_replace("Celular|", "", $informacionCliente[0]->Telefono1 )?>"
                />
            </div>
        </div>

        <div class="row" style="padding-bottom:15px;">
            <div class="col-sm-2 col-md-2" align="right">
                 <label class="labelResponsivo">Email:</label>
            </div>

            <div class="col-sm-10 col-md-10">
               <input
                    id="EMail1" name="EMail1"
                    type="email"
					class="form-control input-sm"
                    value="<?=$informacionCliente[0]->EMail1?>"
                />
            </div>
        </div>



   <?php  if(isset($permisos['polizaVerde'])){ ?>
       
       <div class="row">
            <div class="col-sm-2 col-md-2" align="right">
            <label  class="labelResponsivo">Poliza verde:</label>
           </div>
           <div class="col-sm-10 col-md-10">
            <select name="tarjetaVerde" class="form-control input-sm"><option value="0">No</option><option value="1">Si</option></select>
        </div>
        </div>
 <?php  } ?> 
        <div class="row" style="padding-bottom:15px;">
			<div class="col-sm-2 col-md-2" align="right">
            	<label class="labelResponsivo">Vendedor:</label>
            </div>
			<div class="col-sm-10 col-md-10">
            	<?= $SelectVendedor; ?>

                 <?  //ENLACE PROYECTO 100
                   if( $IDPcien > 0)
                   { 
                 ?>
                 <font color='red'>
                 Enlace Proyecto 100:
                 </font>
                 <input 
                    type="text" name="IDPcien" id="IDPcien"
                    maxlength="10" size="8"
                    readonly=""  value="<? echo $IDPcien  ?>" 
                />

                <?
                 }
                ?>
                
            </div>

            

		</div>

		<div class="row">
			<div class="col-sm-2 col-md-2" align="right">
				<label class="labelResponsivo">Seleccionar companias:</label>
            </div>
			<div class="col-sm-10 col-md-10">
            <div class="row">
            <?
				if(isset($companias)){
					//$opciones	= "";
					foreach($companias as $value){
						//$opciones = $opciones.'<label class="labelResponsivo" style="border:solid 1px black">'.$value->Promotoria.'<input type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" class="form-control input-sm cbCompania" value="'.$value->idPromotoria.'"></label>';
			?>
			<div class="col-sm-4 col-md-4" align="left">
						<div class="form-check form-check-inline" style="border:solid 1px #CCC; background-color:#EEE; opacity: 0.8;" align="center">
							<label class="form-check-label" for="inlineCheckbox1"><?= $value->Promotoria ?></label>
                            <br />
							<input class="form-check-input form-control input-sm cbCompania" type="checkbox" name="cbCompania[]" onclick="escogeCompania(this)" value="<?= $value->idPromotoria;?>">
						</div>
                        <br />
			</div>

            <?
					}
					//print($opciones);
				}
			?>
            </div>
        </div>
        </div>

		<div class="row">
        	<div class="col-sm-2 col-md-2" align="right">
            <label class="labelResponsivo">	Datos <?=$tipoActividad?> Expr&eacute;s:</label>
            </div>
        	<div class="col-sm-10 col-md-10">

					<textarea name="datosExpres" id="datosExpres" style="width:100%;">
            		<?=($TextoExpresFormulario != false)?$TextoExpresFormulario->row()->textoExpres_formulario:''?>
                    <?=($idPoliza != "" && isset($idPoliza))?'COTIZACION DE LA POLIZA: '.$idPoliza:''?>
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
            	<input type="hidden" name="IDAgente" id="IDAgente" value="63" required="Selecciones Un Vendedor si no conoce seleccione Agente GAP" />                                
            	<input type="hidden" name="IDGrupo" id="IDGrupo" value="1" />
                <input type="hidden" name="tipoActividadSicas" id="tipoActividadSicas" value="<?=$tipoActividadSicas?>" />
            	<input type="hidden" name="TipoDocto" id="TipoDocto" value="<?=$TipoDocto?>" /><!-- -->
            	<input type="hidden" name="IDEjecut" id="IDEjecut" value="<?= isset($IDEjecut) ? $IDEjecut : '' ?>" /><!-- -->
            	<input type="hidden" name="IDSRamo" id="IDSRamo" value="<?=$tipoSubRamo?>" />
            	<input type="hidden" name="poliza" id="poliza" value="<?=$idPoliza?>" />
                
				<!-- <input type="" name="IDVend" id="IDVend" value="<?=$IDVend?>" /> -->
                <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?=$this->tank_auth->get_usermail()?>" />
                <input type="hidden" name="usuarioResponsable" id="usuarioResponsable" value="<?= isset($usuarioResponsable) ? $usuarioResponsable : '' ?>" />
                <input type="hidden" name="usuarioBolita" id="usuarioBolita" value="<?= isset($usuarioResponsable) ? $usuarioResponsable : ''?>" />
            </div>
        </div>
        <br /><br />
        <div class="row">
			<div class="col-sm-4 col-md-4">
            	&nbsp;
            </div>
			<div class="col-sm-2 col-md-2">
        	<?
			if($tipoSubRamo!='17' && $tipoSubRamo!='19' && $tipoSubRamo!='21'){
			?>

            	<center title="Negocios importantes arriba de $50,000 de prima">
					<label class="labelResponsivo">
	    	            Cotizaci&oacute;n Importante ...
            	    </label>
					<br />
					<input 
    	            	name="actividadImportante" id="actividadImportante" 
            	        type="checkbox" title="Negocios importantes arriba de $50,000 de prima" 
        	            value="1" 
					/>
				</center>

            <?
			} else {
			?>
            	&nbsp;
            <?
			}
			?>
            </div>

			<div class="col-sm-2 col-md-2">
            	<center>
					<label class="labelResponsivo">
                		Cotizaci&oacute;n Urgente !!!
	                </label>
    	            <br />
        	        <input 
            	    	name="actividadUrgente" id="actividadUrgente" 
                	    type="checkbox" title="Clic Para Seleccionar" 
                    	value="1" 
	                />
				</center>
            </div>
			<div class="col-sm-2 col-md-2" align="center">
                <input 
                	type="button" 
                    id="cancelarActividad" value="Cancelar" 
                    class="btn btn-primary btn-sm"
                    onclick="window.open('<?=$urlCancelar?>','_self');"
                />
            </div>
			<div class="col-sm-2 col-md-2" align="center">
                <input 
                	type="submit"
                    id="guardarActividad" value="<?= "Guardar ".$this->uri->segment(3); ?>" 
                    class="btn btn-primary btn-sm ocultarObjeto"
                />
            </div>
        </div>
<?
		}
?>
        <?
		}
		?>
    <div id="miModalGenerico" class="modalCierraGenerico" ><div id="ModalcontenidoGenerico" class="modal-contenidoGenerico"  ><div class="contenidoModal"><div><button onclick="cerrarModal()" class="botonCierre">X</button></div><div><label>Nuevo giro:<input type="text" id="inputNuevoGiro" class="form-control input-sm"></label></div><div><button onclick="grabaNuevoGiro(null)">Guardar</button></div></div></div></div>

<script type="text/javascript">

    <?php  
    if(isset($permitirRanking)){
        echo('var numeroPorRanking=new Array();');
        foreach ($permitirRanking as  $value) {echo('numeroPorRanking["'.$value->personaRankingAgente.'"]="'.$value->companiasPermitidasPRA.'";');
        }
    }
    ?>

           function cambiaVen(objeto){objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
           if(objeto.value==""){     document.getElementById('guardarActividad').classList.add('ocultarObjeto');
    document.getElementById('guardarActividad').classList.remove('verObjeto'); }
  for(var i=0;i<cant;i++){objetosCB[i].checked=false;}
           } 
       function escogeCompania(objeto){
        //numeroPorRanking ES UNA VARIABLE ARRAY GLOBAL
        var select=document.getElementById('IDVend');
       //select[select.selectedIndex].getAttribute('data-ranking');
       //  console.log(select[select.selectedIndex].getAttribute('data-ranking'));
         //console.log(numeroPorRanking.ORO);
         var objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
         var contador=0;numeroPermitidos=numeroPorRanking[select[select.selectedIndex].getAttribute('data-ranking')];
          var canal=select[select.selectedIndex].getAttribute('data-canal');
          var agente=select[select.selectedIndex].getAttribute('data-tipoAgente');
            var ranking=select[select.selectedIndex].getAttribute('data-ranking');
         var band=0;
if(typeof(numeroPermitidos) != "undefined"){
  for(var i=0;i<cant;i++){if(objetosCB[i].checked){contador++;}}
    if(canal=='FIANZAS' || agente=="Agente Independiente"){if(contador>3){band=1;}}
    else{if(contador>numeroPermitidos){objeto.checked=false;band=1;}}
    if(band){ 
        objeto.checked=false;contador--;
          if(agente=="Agente Independiente"){alert("Los agentes "+agente+" tiene permitidos "+contador+" companias");}
          else{
             if(canal=='FIANZAS' ){alert("Los agentes "+canal+" tiene permitidos "+contador+" companias");}
            else{alert("Los agentes "+ranking+" tiene permitidos "+contador+" companias");}}
        
         }
            if(contador>0){
    document.getElementById('guardarActividad').classList.add('verObjeto');
    document.getElementById('guardarActividad').classList.remove('ocultarObjeto');
    }
    else{
     document.getElementById('guardarActividad').classList.add('ocultarObjeto');
    document.getElementById('guardarActividad').classList.remove('verObjeto');   
    } 
    }
    else{objeto.checked=false;alert("No tiene permitido elegir companias")}
}
        </script>

<?php
function imprimirEstados($datos){
    $option='<option value="">Escoger</option>';
    foreach ($datos as  $value) {$option.='<option value="'.$value->clave.'">'.$value->estado.'</option>';}
    return $option;
}
function imprimirGiroCatalogo($datos){
      $option='<option value="">Escoger</option>';
 
    foreach ($datos as  $value) {$option.='<option value="'.$value->idGiro.'">'.$value->giro.'</option>';}
    return $option;  
}
?>


<script type="text/javascript">
                function verificarDatos(e){
                     
var objetosCB=document.getElementsByClassName('cbCompania');cant=objetosCB.length;
var objetosActivo=0;
for(var i=0;i<cant;i++){
    if(objetosCB[i].checked){
        objetosActivo=objetosActivo+1;
        i=cant;
    }
}
if(objetosActivo==0){e.preventDefault();alert("Elegir al menos una compania")}

                 
            }
</script>

<style type="text/css">
.botonCierre{background-color: red;color:white;}
.modal-contenidoGenerico{background-color:none  ;width:80%;height:100%;left: 20%;margin: 5% auto;position: relative;z-index: 1000 } 
.modalCierraGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;relative;z-index: 1000}
.modalAbreGenerico{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 10000}
.botonCierre{background-color: red;color:white;}
.contenidoModal{border: solid;background-color: white;width: 50%;height: 60%; position: relative;left: -0%;top: -5%}
</style>
<script type="text/javascript">
     function cerrarModal(){document.getElementById("miModalGenerico").classList.add("modalCierraGenerico");document.getElementById("miModalGenerico").classList.remove("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.remove("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.add("ocultarObjeto");  }
 function abrirModal(e){e.preventDefault();document.getElementById("miModalGenerico").classList.remove("modalCierraGenerico");document.getElementById("miModalGenerico").classList.add("modalAbreGenerico");document.getElementById("ModalcontenidoGenerico").classList.add("verObjeto");document.getElementById("ModalcontenidoGenerico").classList.remove("ocultarObjeto");  document.getElementById('inputNuevoGiro').focus()}
function grabaNuevoGiro(procesoDatos){
    
    if(procesoDatos==null){
    var datos='';
   if(document.getElementById('inputNuevoGiro').value!=''){  datos="giro="+document.getElementById('inputNuevoGiro').value;mandaAJAX('actividades/nuevoGiro',datos,0);}
   }else{
    var total=procesoDatos.catalogo.length;
    var opciones="";
     for(var i=0;i<total;i++){
        if(procesoDatos.catalogo[i].idGiro==procesoDatos.activo){
      opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'" selected>'+procesoDatos.catalogo[i].giro+'</option>'
        }else{
        opciones=opciones+'<option value="'+procesoDatos.catalogo[i].idGiro+'">'+procesoDatos.catalogo[i].giro+'</option>';}      
     }
 
     document.getElementById('giroCliente').innerHTML=opciones;
     cerrarModal();
   }
}
function mandaAJAX(controlador,datos,manejoRespuesta){
    var url="<?=base_url();?>";
    url=url+controlador;
 var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {     
      var respuesta=JSON.parse(this.responseText);
      grabaNuevoGiro(respuesta);
    }
  };
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  xhttp.send(datos);
}
</script>