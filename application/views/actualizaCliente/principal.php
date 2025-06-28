<?php
	#$busquedaCliente = $this->input->get('busquedaCliente', TRUE);
	$this->load->view('headers/header');
	#var_dump($ListaClientes);
	#var_dump($busquedaCliente);
?>
<style>
.alert-client hr.message-inner-separator
{
    clear: both;
    margin-top: 10px;
    margin-bottom: 13px;
    border: 0;
    height: 1px;
    background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
    background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}

.alert-client .alert-labeled{
  padding: 0px;
}

.alert-client .headers{
    margin-left: 15px;
    margin-top: 5px;
}
    
.alert-client .alert-labeled-row{
    display: table-row;
    padding: 0px;
}

.alert-client .alert-labelled-cell{
    padding: 10px;
    display: table-cell;
    vertical-align: middle;
}

.alert-client .alert-labeled .close > *{
    padding:10px;
    display: table-cell;
    vertical-align: middle;
}

.alert-client .alert-label{
    vertical-align: middle;
    background: #BCE8F1;
    width: auto;
    padding: 10px 15px;
    height: 100%;
    font-size:1.1em;
}
.form-control2 {
 	display: block;
  	width: 100%;
  	height: 34px;
  	padding: 6px 12px;
  	font-size: 14px;
  	line-height: 1.42857143;
  	color: #555;
  	background-color: #fff;
  	background-image: none;
  	border: 1px solid #ccc;
  	border-radius: 4px;
  	-counter-resetwebkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
  	-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
       -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
          transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
</style>
<section>
	<div class="container">
		<form action="<?=base_url()?>actualizaCliente" method="post" id="formBusquedaCliente" name="formBusquedaCliente" accept-charset="UTF-8">
			<div class="row">
				<div class="col-sm-10">
					<font class="tituloSeccione">
						Actualizar Mis Datos Como Cliente
					</font>
				</div>
			</div>		
			<br/>
			<!--?php #echo $busquedaCliente;
			if (strlen($busquedaCliente) == 0) {?-->
			<div class="row">
				<div class="col-md-3">
				    <label for="RegimenFiscal"><?php echo htmlentities('Régimen Fiscal'); ?>:</label>
				    <select name="RegimenFiscal" id="RegimenFiscal" class="form-control2 input-sm"/>
						<option value="-1" <?php echo($Regimen == -1 ? 'selected':'');?>>Seleccione una opci&oacute;n</option>
				        <option value="0" <?php echo($Regimen == 0 ? 'selected':'');?>><?php echo htmlentities('Física');?></option>
				        <option value="1" <?php echo($Regimen == 1 ? 'selected':'');?>>Moral</option>
				    </select>
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-6">
							<label for="busquedaCliente">Nombre:</label>
		                	<input id="busquedaCliente" name="busquedaCliente" class="form-control input-sm" type="text" value="<?php echo ($Regimen == -1 ? "" : utf8_decode($busquedaCliente));?>"/>
						</div>
						<div class="col-md-4">
							<label for="poliza"><?php echo htmlentities("Póliza:");?></label>
		                	<input id="poliza" name="poliza" class="form-control input-sm text-uppercase" type="text" value="<?php echo $poliza;?>"/>
						</div>
	                	<div class="col-md-2" style="margin-top:3.1%;">
	                		<input type="submit" id="buscar" value="Buscar" class="btn btn-block btn-sm" />
	                	</div>
					</div>
				</div>
			</div>
			<!--?php }
			else
			{?-->
			<br/>
			<div class="contenido">
				
				<?php
				#echo json_encode($ListaClientes);
				if (!empty($ListaClientes)){ 
					
					if($Regimen == 0) { ?>
						<div class="row">
						    <div class="col-md-6">
						        <label for="Nombre">Nombre</label>
						        <input type="text" id="Nombre" name="Nombre" class="form-control input-sm" value="<?php echo utf8_decode($ListaClientes[0]->Nombre);?>"/>
						    </div>
							<div class="col-md-6">
						        <label for="ApellidoP">Apellido Paterno</label>
						        <input type="text" id="ApellidoP" name="ApellidoP" class="form-control input-sm" value="<?php echo utf8_decode($ListaClientes[0]->ApellidoP);?>"/>
						    </div>
						</div>
						<div class="row">
						    
							<div class="col-md-6">
						        <label for="ApellidoM">Apellido Materno</label>
						        <input type="text" id="ApellidoM" name="ApellidoM" class="form-control input-sm" value="<?php echo utf8_decode($ListaClientes[0]->ApellidoM);?>"/>
						    </div>
							
						    <div class="col-md-6">
						        <label for="RFC">RFC</label>
						        <input type="text" id="RFC" name="RFC" class="form-control input-sm" value="<?php echo utf8_decode($ListaClientes[0]->RFC);?>"/>
						    </div>
						    
						</div>
						<div class="row">
						    <div class="col-md-6">
						        <label for="Correo">Correo</label>
						        <input type="text" id="Correo" name="Correo" class="form-control input-sm" value="<?php echo $ListaClientes[0]->EMail1;?>"/>
						    </div>
						    <div class="col-md-6">
						        <label for="Telefono"><?php echo htmlentities('Teléfono'); ?></label>
						        <input type="text" id="Telefono" name="Telefono" class="form-control input-sm" value=""/>
						    </div>
						</div><?php
					}
					else 
					{?>
						<div class="row">
						    <div class="col-md-12">
						        <label for="rsocial">Raz&oacute;n social</label>
						        <input type="text" id="rsocial" name="rsocial" class="form-control input-sm" value="<?php echo $ListaClientes[0]->RazonSocial;?>"/>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-12">
						        <label for="RFC">RFC</label>
						        <input type="text" id="RFC" name="RFC" class="form-control input-sm" value="<?php echo $ListaClientes[0]->RFC;?>"/>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-12">
						        <label for="Correo">Correo</label>
						        <input type="text" id="Correo" name="Correo" class="form-control input-sm" value="<?php echo $ListaClientes[0]->EMail1;?>"/>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-12">
						        <label for="Telefono"><?php echo htmlentities('Teléfono'); ?></label>
						        <input type="text" id="Telefono" name="Telefono" class="form-control input-sm" value="<?php echo $ListaClientes[0]->Telefono1;?>"/>
						    </div>
						</div>
					<?php } ?>
					
					<div class="row validGeneric" style="display:none">
						<div class="col-md-6">
							<div class="alert alert-danger text-alert" role="alert"></div>
						</div>
					</div>
					<div class="row valid_exito" style="display:none">
						<div class="col-md-6">
							<div class="alert alert-success text-exito" role="alert"></div>
						</div>
					</div>
					
					<div class="row">
						<div>
							<input type="hidden" id="IDCli" name="IDCli" value="<?php echo $ListaClientes[0]->IDCli;?>">
							<input type="hidden" id="RazonSocial" name="RazonSocial" value="<?php echo $ListaClientes[0]->RazonSocial;?>">
							<input type="hidden" id="IDCont" name="IDCont" value="<?php echo $ListaClientes[0]->IDCont;?>">
							<input type="hidden" id="TipoEnt" name="TipoEnt" value="<?php echo $ListaClientes[0]->TipoEnt;?>">
						</div>
						<div class="col-md-2 pull-right" style="margin-top:2%;">
							<button type="button" id="btnGuardar" class="btn btn-block btn-sm btn-primary" style="background-color: #472380;">Actualizar</button>
						</div>
					</div> 
		    	<?php }else{ if(!empty($busquedaCliente)){?>
				
							<div class="row alert-client">
								<div class="col-lg-12 col-md-12 col-sm-12">								
									<div class="alert alert-info alert-labeled">									
										<div class="alert-labeled-row">
											<span class="alert-label alert-label-left alert-labelled-cell">
												<i class="glyphicon glyphicon-info-sign"></i>
											</span>
											 <div>
											<p class="headers">
											  <span style="font-size: 1.3em;margin-top:5px;" class="glyphicon glyphicon-exclamation-sign"></span>
											 <strong>Datos no encontrados</strong> 
											 </p>
											<hr class="message-inner-separator">
											<p class="alert-body alert-body-right alert-labelled-cell">
											No se encotraron datos para su actualizaci&oacute;n, verifique si tiene seleccionado el regimen que le corresponde, y vuelva a intentar; Sin embargo usted puede llenar el siguiente formulario, Seleccione del en la parte superior su r&eacute;gimen fiscal para acceder el formulario; en breve nos comunicaremos con usted.
											</p>
											</div>
										</div>
									</div> 							
								</div>
							</div>
							<div class="template"></div>
							<div class="row validGeneric" style="display:none">
								<div class="col-md-6">
									<div class="alert alert-danger text-alert" role="alert"></div>
								</div>
							</div>
							<div class="row valid_exito" style="display:none">
								<div class="col-md-6">
									<div class="alert alert-success text-exito" role="alert"></div>
								</div>
							</div>
							<div class="btn-actualizar" style="display:none;">
								<div class="row">
									<div>
										<input type="hidden" id="IDCli" name="IDCli" value="0">										
										<input type="hidden" id="IDCont" name="IDCont" value="0">
										<input type="hidden" id="RazonSocial" name="RazonSocial" value="">
										<input type="hidden" id="TipoEnt" name="TipoEnt" value="">
									</div>
									<div class="col-md-2 pull-right" style="margin-top:2%;">
										<button type="button" id="btnGuardar" class="btn btn-block btn-sm btn-primary" style="background-color: #472380;">Actualizar</button>
									</div>
								</div> 
							</div>
							<script>
								$(document).ready(function(){
									$("select#RegimenFiscal").change(function(){
										$Regimen = $(this).val();
										var template = "";
										$(".btn-actualizar").show();
										if($Regimen == 0){
											template += "<div class='row'>" +
															"<div class='col-md-6'>" +
																"<label for='Nombre'>Nombre</label> "+
																"<input type='text' id='Nombre' name='Nombre' class='form-control input-sm'/>" +
															"</div>" +
															"<div class='col-md-6'>" +
																"<label for='ApellidoP'>Apellido Paterno</label>" +
																"<input type='text' id='ApellidoP' name='ApellidoP' class='form-control input-sm'/>" +
															"</div>" +
														"</div>" +
														"<div class='row'>" +
															"<div class='col-md-6'>" +
																"<label for='ApellidoM'>Apellido Materno</label>" +
																"<input type='text' id='ApellidoM' name='ApellidoM' class='form-control input-sm'/>" +
															"</div>" +
															"<div class='col-md-6'>" +
																"<label for='RFC'>RFC</label>" +
																"<input type='text' id='RFC' name='RFC' class='form-control input-sm'/>"+
															"</div>" +										
														"</div>" +
														"<div class='row'>" +
															"<div class='col-md-6'>" +
																"<label for='Correo'>Correo</label>" +
																"<input type='text' id='Correo' name='Correo' class='form-control input-sm'/>" +
															"</div>" +
															"<div class='col-md-6'>" +
																"<label for='Telefono'><?php echo htmlentities('Teléfono'); ?></label>" +
																"<input type='text' id='Telefono' name='Telefono' class='form-control input-sm'/>" +
															"</div>" +
														"</div>";
											$(".template").html(template);
										}else{
											template += "<div class='row'>" +
															"<div class='col-md-12'>" +
																"<label for='rsocial'>Raz&oacute;n social</label>" +
																"<input type='text' id='rsocial' name='rsocial' class='form-control input-sm'/>" +
															"</div>" +
														"</div>" +
														"<div class='row'>" +
															"<div class='col-md-12'>" +
																"<label for='RFC'>RFC</label>" +
																"<input type='text' id='RFC' name='RFC' class='form-control input-sm'/>" +
															"</div>" +
														"</div>" +
														"<div class='row'>" +
															"<div class='col-md-12'>" +
																"<label for='Correo'>Correo</label>" +
																"<input type='text' id='Correo' name='Correo' class='form-control input-sm'/>" +
															"</div>" +
														"</div>" +
														"<div class='row'>" +
															"<div class='col-md-12'>" +
																"<label for='Telefono'><?php echo htmlentities('Teléfono'); ?></label>" +
																"<input type='text' id='Telefono' name='Telefono' class='form-control input-sm'/>" +
															"</div>" +
														"</div>";
														
											$(".template").html(template);
										}
									})
								});
							</script>

				<?php } } ?>
			</div>
		<!--?php }?-->
		</form>
	</div>
</section>
<script>

	$("#btnGuardar").click(function(){

			$(".validGeneric").hide();  
			var email = $("#Correo").val();
			var rfc = $("#RFC").val();
			var phone = $("#Telefono").val();
			var Regimen = $("#RegimenFiscal").val();
			var mostrarEmail = false;
			var mostrarPhone = false;
			var mostrarRfc = false;
			var long_rfc = 0;
			var text = "";
			if(email != 0)
			{
				if(!isValidEmailAddress(email))
				{
					text += "El correo no tiene el formato correcto <br/>";
					mostrarEmail = true;
				} 
			} else {
				text += "El correo no puede ser vacio <br/>";
				mostrarEmail = true;
			}
			
			if(phone != 0){
				if(!isValisPhoneAddress(phone))
				{
					text += "El telefono no tiene el formato correcto<br/>";
					mostrarPhone = true;
				} else{
					if(phone.length > 10){
						text += "El telefono no valido <br/>";
						mostrarPhone = true;
					}
					
				}
			}else{
				text += "El telefono no puede ser vacio <br/>";
				mostrarPhone = true;
			}
			
			if(rfc != 0){
				
				if(Regimen == 0){
					long_rfc = 13;
				}else{
					long_rfc = 12;
				}
				
				if(rfc.length > long_rfc){
					text += "El Rfc no valido <br/>";
					mostrarRfc = true;
				}
				if(rfc.length < long_rfc ){
					text += "El Rfc no valido <br/>";
					mostrarRfc = true;
				}
				
			}else{
				text += "El RFC no puede ser vacio <br/>";
				mostrarRfc = true;
			}
			
			if(mostrarRfc == true || mostrarPhone == true || mostrarEmail == true){
				$(".text-alert").html(text);
				$(".validGeneric").show();
			}else if (mostrarRfc == false && mostrarPhone == false && mostrarEmail == false){
				ActualizarCliente();
			}
	});
	
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
	function isValisPhoneAddress(phoneAddres){
		var pattern = new RegExp(/^[0-9-+]+$/);
		return pattern.test(phoneAddres);
	}
	
	function DetalleRegistro(IDCli, seccion){
		if(IDCli == ""){ 
			alert("\n Seleccione un Resultado !!!");
		} 
		else
		{
			switch(seccion)
			{
				case 'directorio':
					window.open('<?=base_url()?>actualizaCliente/registroDetalle?IDCli='+IDCli,'_self');
				break;
			}
		}
	}
</script>
<?php $this->load->view('footers/footer'); ?>