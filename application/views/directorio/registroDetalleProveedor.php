<?php
//$IDCli = $this->input->get('IDCli', TRUE);
//$page = $this->input->get('page', TRUE);
//if($page == ""){
	//$page = 1;
//}
#var_dump($ClienteContact);
#var_dump($SubGrupo);
//if(!isset($ClienteContact)){
	//redirect('/directorio');
//}
?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>

 <!--:::::::::: INICIO CONTENIDO ::::::::::-->
<section class="container-fluid breadcrumb-formularios">
    <div class="row">
        <div class="col-md-6 col-sm-5 col-xs-5"><h3 class="titulo-secciones">Detalle directorio proveedor</h3></div>
        <div class="col-md-6">
            <ol class="breadcrumb text-right">
                <li><a href="./">Inicio</a></li>
                <li><a href="<?php echo base_url(); ?>directorio">Directorio</a></li>
                <li class="active">Detalle directorio proveedor</li>
            </ol>
        </div>
    </div>
        <hr /> 
</section>
<!-- End navbar -->
<section class="container-fluid">
	<form id="frmClient" action="<?php echo base_url();?>directorio/updateProveedor">
	 	<div class="row">
	        <div class="col-md-12">
	            <div class="row">
	                <div class="form-group col-md-6 col-sm-6 col-xs-4">
						<a href="#" id="aEdit" title="EDITAR" style="margin-left:10px;" class="btn btn-default btn-sm">&nbsp;<i class="glyphicon glyphicon-pencil"></i>&nbsp;</a>
	                </div>
	                <div class="form-group col-md-6 col-sm-6 col-xs-8 text-right">
	                    <button type="button" class="btn btn-default btn-sm ctl-save" id="btnCancel" name="operacion" title="CANCELAR" disabled >CANCELAR<!-- <i class="fa fa-check"></i> --></button>

	                    <button type="submit" class="btn btn-primary btn-sm ctl-save" id="btnSave" name="operacion" value="Guardar" disabled >GUARDAR<!-- <i class="fa fa-check"></i> --></button>
	                </div>
	            </div>
	             <!-- Nav tabs -->
	            <ul class="nav nav-tabs" role="tablist">
	                <li role="presentation" class="active"><a href="#tab-01" aria-controls="tab-01" role="tab" data-toggle="tab">Generales</a></li>
	                <li role="presentation"><a href="#tab-02" aria-controls="tab-02" role="tab" data-toggle="tab">Contacto</a></li>
	            </ul>

	            <div class="tab-content">
	            	<div role="tabpanel" class="tab-pane fade in active" id="tab-01">
						<div class="row">
	            			<div class="form-group col-md-12 col-sm-12"><!-- JjHe -->
								<label for="Expediente">Nombre</label>
	                            <input type="text" class="form-control  input-sm" name="Expediente" value="<?=$detalleProveedor[0]->Nombre_organizacion?>" disabled />
                            </div>
	                	</div>                           
	                </div>
                    
		            <!-- INICIO CONTENIDO TAB -->
		            <div role="tabpanel" class="tab-pane fade" id="tab-02">
					 	<div class="row">
		                    <div class="form-group col-md-12 text-right">
		                        <a href="#"  class="btn btn-default btn-sm addCto " title="Agregar contacto" disabled >&nbsp;<i class="fa fa-plus-circle fa-lg "></i> Agregar contacto</a>
		                    </div>
		                </div>

		                <?php
							if(isset($ClienteContact["contactos"])){
							   //tipoEnt
							   // var_dump($ClienteContact["contactos"]);
						?>
						<div class="row">
						   <div class="col-md-12 custyle">
								<table class="table table-striped custab">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Puesto / Trato</th>
											<th>Nacionalida / Idioma</th>
											<th>Correo 1</th>
											<th>Tel&#233;fono</th>
											<th class="text-center">Acci&#243;n </th>
										</tr>
									</thead>
									<tbody id="tabbody">
										<?php
											$i = 0;
											foreach($ClienteContact["contactos"] as $key => $contacto){
												$i += 1;	?>
												<tr>
													<td><?php echo $contacto->Nombre . " " . $contacto->ApellidoP . " " . $contacto->ApellidoM; ?></td>
													<td><?php echo $contacto->Puesto; ?></td>
													<td><?php if(isset($contacto->Nacionalidad)){ echo $contacto->Nacionalidad; } ?></td>
													<td><?php echo $contacto->EMail1; ?></td>
													<td><?php if(isset($contacto->Telefono1)){ echo $contacto->Telefono1; } ?></td>
													<td class="text-center">
														<input type="hidden" name="contacto-<?php echo $i;?>" class="cto-itm"
															data-IdCont="<?php echo $contacto->IDCont; ?>" 
															data-Nombre="<?php echo $contacto->Nombre; ?>" 
															data-ApellidoP="<?php echo $contacto->ApellidoP; ?>" 
															data-ApellidoM="<?php echo $contacto->ApellidoM; ?>" 
															data-Alias="<?php echo $contacto->Abreviacion; ?>"
															data-Sexo="<?php echo $contacto->Sexo; ?>" 
															data-Edad="<?php echo $contacto->Edad; ?>" 
															data-FechaNac="<?php echo $contacto->FechaNac; ?>"
															data-Email1="<?php echo $contacto->EMail1; ?>"
															data-Telefono1="<?php echo $contacto->Telefono1; ?>"
															data-Nacionalidad="<?php echo $contacto->Nacionalidad; ?>"
														>
														<a name="ver" class='btn btn-primary btn-xs contact-item' data-toggle="modal" data-target="#contact" data-original-title>
															<span class="glyphicon glyphicon-eye-open" ></span> 
														Ver Info</a>
														<a name="editar" class='btn btn-primary btn-xs contact-item hidden' data-toggle="modal" data-target="#contact" data-original-title>
															<span class="glyphicon glyphicon-edit"></span> 
														Editar</a>
														<!--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>-->
												</tr>	
											<?php
											}
											?>																					
									</tbody>												
								</table>
							</div>
						</div>
						<?php
							}
						?>
		            </div>
		            <!-- FIN CONTENIDO TAB -->

		         	<!-- INICIO CONTENIDO TAB -->
		            <div role="tabpanel" class="tab-pane fade" id="tab-03">
		                <div class="row">
		                    <div class="form-group col-md-12 text-right">
		                        <a href="#"  class="btn btn-default btn-sm addDic ctl-save"  title="Agregar dirección" disabled >&nbsp;<i class="fa fa-plus-circle fa-lg"></i> Agregar direcci&#243;n</a>
		                    </div>
		                </div>
		                <div class="row">
		                    <div class="col-md-12 table-responsive">
		                        <?php
								if(isset($Direcciones)){
								?>
								<div class="row">
									   <div class="col-md-12 custyle">
										<table class="table table-striped custab">
											<thead>
												<tr>
													<th>Calle</th>
													<th>No Ext</th>
													<th>No Int</th>
													<th>C&#243;digo Postal</th>
													<th>Colonia</th>
													<th>Poblaci&#243;n</th>
													<th>Ciudad</th>
													<th>Pa&#237;s</th>
													<th>Tel&#233;fono</th>
													<th>Tel&#233;fono2</th>
													<th class="text-center">Acci&#243;n &nbsp;&nbsp;<a class="fa fa-plus-circle addDic" disabled>&nbsp;Direcci&#243;n</a></th>
												</tr>
											</thead>
											<tbody id="tabbodyd">
												<?php
													$i = 0;
													foreach($Direcciones as $key => $contacto){
														$i += 1;	?>
														<tr>
															<td><?php echo $contacto->Calle ?></td>
															<td><?php echo $contacto->NOExt; ?></td>
															<td><?php echo $contacto->NOInt; ?></td>
															<td><?php echo $contacto->CPostal; ?></td>
															<td><?php echo $contacto->Colonia; ?></td>
															<td><?php echo $contacto->Poblacion; ?></td>
															<td><?php echo $contacto->Ciudad; ?></td>
															<td><?php echo $contacto->Pais; ?></td>
															<td><?php if(isset($contacto->Telefono1)){ echo str_replace("Telefono1:","",$contacto->Telefono1); } ?></td>
															<td><?php if(isset($contacto->Telefono2)){ echo str_replace("Telefono2:","",$contacto->Telefono2); } ?></td>
															<td class="text-center">
																<input type="hidden" name="direccion-<?php echo $i;?>" class="dic-itm"
																	data-IDDir="<?php echo $contacto->IDDir; ?>" 
																	data-Calle="<?php echo $contacto->Calle; ?>" 
																	data-NOExt="<?php echo $contacto->NOExt; ?>" 
																	data-NoInt="<?php echo $contacto->NOInt; ?>" 
																	data-CPostal="<?php echo $contacto->CPostal; ?>"
																	data-Colonia="<?php echo $contacto->Colonia; ?>" 
																	data-Poblacion="<?php echo $contacto->Poblacion; ?>" 
																	data-Ciudad="<?php echo $contacto->Ciudad; ?>"
																	data-Pais="<?php echo $contacto->Pais; ?>"
																	data-Telefono1="<?php echo str_replace("Telefono1:","",$contacto->Telefono1); ?>"
																	data-Telefono2="<?php echo str_replace("Telefono2:","",$contacto->Telefono2); ?>"
																>
																<a name="ver" class='btn btn-primary btn-xs address-item' data-toggle="modal" data-target="#address" data-original-title>
																	<span class="glyphicon glyphicon-eye-open" ></span> 
																Ver Info</a>
																<a name="editar" class='btn btn-primary btn-xs address-item hidden' data-toggle="modal" data-target="#address" data-original-title>
																	<span class="glyphicon glyphicon-edit"></span> 
																Editar</a>
																<!--<a href="#" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Del</a></td>-->
														</tr>	
														<?php
													}
												?>																					
											</tbody>												
										</table>
										</div>
								</div>
								<?php
									}
								?>
		                    </div>
		                </div>
		            </div>
		            <!-- FIN CONTENIDO TAB -->
				</div>	            
	        </div>
	    </div>
    </form>
</section>
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar contacto</h4>
            </div>
            
            <div class="modal-body">
            	<div class="row">
            		<div class="col-md-12">
            			<input class="IdCont" name="IdCont" type="hidden">
                      	<div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="ApellidoP">Apellido Paterno</label>
                                <input class="form-control ApellidoP" name="ApellidoP" placeholder="Apellido Paterno" type="text" required autofocus />
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="ApellidoM">Apellido Materno</label>
                                <input class="form-control ApellidoM" name="ApellidoM" placeholder="Apellido Materno" type="text" required />
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">Nombre (s)</label>
                                <input class="form-control Nombre" id="Nombre" name="Nombre" placeholder="Nombre" type="text" required />
                            </div>
                        </div>
						<!--div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="sexoc">Sexo</label>
                                <select name="sexoc" class="form-control2 Sexo" disabled>
									<option value="0">Masculino</option>
									<option value="1">Femenino</option>
								</select>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                            	<label for="fechaNacc">Fecha Nacimiento</label>
                                <div class="input-group">
									<input type="text" class="form-control FechaNac fecha" name="fechaNacc" placeholder="01/01/1900" value="" disabled>
	                                <div class="input-group-btn"><button class="btn btn-default fecha" type="button" disabled><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
	                            </div>
                            </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="edadc">Edad</label>
                                <a class="form-control Edad" disabled id="txtEdadC"></a>
								<input type="hidden" class="form-control Edad" id="edadC" name="edad" value="" disabled>
                            </div>
                        </div-->
                        <!--input class="form-control Departamento" name="Departamento" placeholder="Departamento" type="text" required /-->
                        <div class="row">
                        	<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
                        		<label for="Alias">Alias</label>
                        		<input class="form-control Alias" name="Alias" placeholder="Alias" type="text" required autofocus />
                        	</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            	<label for="Email1">E-mail</label>
                                <input class="form-control Email1" name="Email1" placeholder="E-mail" type="email"  required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            	<label for="telefono1">Tel&#233;fono1</label>
                                <input class="form-control Telefono1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="Telefono1" placeholder="Telefono1" type="text" required />
                            </div>
                        </div>
            		</div>
            	</div>
            </div>  
            <div class="panel-footer">
            	<div class="row">
            		<div class="col-md-1 col-md-offset-9" id="dvC">
					</div>
					<div class="col-md-1">
						<a class="btn btn-primary btn-sm" data-dismiss="modal" id="btnGuardar">Aceptar</a>
					</div>
					<div class="col-md-1">
					</div>
            	</div>
            </div>
        </div>
    </div>
</div>




<!--:::::::::: INICIO MODAL ::::::::::-->
<div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Agregar direcci&#243;n</h4>
            </div>
            <div class="modal-body">
	        	<div class="row">
	        		<div class="col-md-12">
	        			<input class="IdCont" name="IdCont" type="hidden">
	                  	<div class="row">
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoP">Calle</label>
	                            <input class="form-control DCalle" name="calle" placeholder="Calle" type="text" required autofocus />
	                        </div>
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoM">No Ext</label>
	                            <input class="form-control DNoExt" name="noext" placeholder="No Ex" type="text" required />
	                        </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">No Int</label>
	                            <input class="form-control DNoInt" id="noint" name="noint" placeholder="No Int" type="text" required />
	                        </div>
	                    </div>

	                    <div class="row">
	    	               	<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoP">C&#243;digo Postal</label>
	                            <input class="form-control DCP" name="cp" maxlength="5" minlength="5" placeholder="Codigo Postal" type="text" required autofocus />
	                        </div>
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="ApellidoM">Colonia</label>
	                            <input class="form-control DColonia" name="colonia" placeholder="Colonia" type="text" required />
	                        </div>
							<div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
								<label for="Nombre">Poblaci&#243;n</label>
	                            <input class="form-control DPoblacion" id="poblacion" name="poblacion" placeholder="Poblacion" type="text" required />
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="Email1">Ciudad</label>
	                            <input class="form-control DCiudad" name="ciudad" placeholder="Ciudad" type="text" required />
	                        </div>
	                         <div class="col-lg-4 col-md-4 col-sm-4" style="padding-bottom: 10px;">
	                        	<label for="Email1">Pa&#237;s</label>
	                            <input class="form-control DPais" name="pais" placeholder="Pais" type="text" required />
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
	                        	<label for="telefono1">Tel&#233;fono1</label>
	                            <input class="form-control DTelefono1" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="Telefono1" placeholder="Telefono 1" type="text" required />
	                        </div>
	                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
	                        	<label for="telefono1">Tel&#233;fono2</label>
	                            <input class="form-control DTelefono2" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="telefono2" placeholder="Telefono 2" type="text" required />
	                        </div>
	                    </div>
	        		</div>
	        	</div>
			</div>  
            
            <div class="modal-footer">
            	<div class="row">
            		<div class="col-md-1 col-md-offset-9" id="dvD">
					</div>
					<div class="col-md-1">
						<a class="btn btn-primary btn-sm" data-dismiss="modal" id="btnGuardarD">Aceptar</a>
					</div>
					<div class="col-md-1">
					</div>
            	</div>
            </div>
        </div>
        
    </div>
</div>
<!--:::::::::: FIN MODAL ::::::::::-->


<script>



$(document).ready(function()
 {


 	$(document.body).find('input[type=email]').blur(function(){
 		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
 		var email = this.value;

	    if(!re.test(email)){
	    	alert("El formato de correo es incorrecto.");
	    	$(this).focus();
	    }
 	});
 	<?php
 		if (strlen($msj) > 0)
 		{
 			echo 'alert("'.$msj.'");';
 		}
 	?>
	$('.addCto').off('click');
	$('.addDic').off('click');
	var editar = false;

	$(document.body).on('click','#aEdit',function(e){
		e.preventDefault();
		editar = true;
		$('.form-control, .ctl-save, .fecha, .form-control2').prop('disabled',false);
	
		$('a[name="editar"]').removeClass('hidden');
		$(".addCto").removeAttr("disabled");
		$('.addDic').removeAttr('disabled');
		$('.addCto').on("click", function(e){
			e.preventDefault();
			$(".editando").removeClass("editando");
			$("#contact input:text").removeAttr("disabled");
			$(".Nombre").val("");      
			$(".ApellidoP").val("");      
			$(".ApellidoM").val("");      
			$(".Alias").val("");      
			//$("#txtEdadC").text("");
			//$(".Edad").val("");      
			//$(".FechaNac").val("");      
			$(".Email1").val("");      
			$(".Telefono1").val("");      
			$(".Nacionalidad").val("");
			
			$("#btnGuardar").attr("data-new","true");
			$("#btnGuardar").addClass("guardarCto");
    		$("#dvC").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
			$("#contact").modal('show');
		});


		$('.addDic').on("click", function(e){
			e.preventDefault();
			$(".editando").removeClass("editando");
			$("#address input:text").removeAttr("disabled");
			$(".DCalle").val("");      
			$(".DNoExt").val("");      
			$(".DNoInt").val("");      
			$(".DCP").val("");      
			$(".DColonia").val("");      
			$(".DPoblacion").val("");      
			$(".DCiudad").val("");      
			$(".DPais").val("");      
			$(".DTelefono1").val("");      
			$(".DTelefono2").val(""); 
			
			$("#btnGuardarD").attr("data-new","true");
			$("#btnGuardarD").addClass("guardarDic");
    		$("#dvD").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardarD").removeAttr("data-dismiss");
			$("#address").modal('show');
		});
	});

	// $('#aEdit').click(function(e)
	// {
		
	// });

	$('#btnSave').click(function(e)
	{
		e.preventDefault();

		var contactos = [];
		$(".cto-itm").each(function(i,input){
			var item = {
				"IDCont"       : $(input).attr("data-IdCont"),
				"Nombre"       : $(input).attr("data-Nombre"),
				"ApellidoP"    : $(input).attr("data-ApellidoP"),
				"ApellidoM"    : $(input).attr("data-ApellidoM"),
				"Alias" 	   : $(input).attr("data-Alias"),
				//"Sexo" 	   	   : $(input).attr("data-Sexo"),
				//"FechaNac" 	   : $(input).attr("data-FechaNac"),
				//"Edad"		   : $(input).attr("data-Edad"),
				"Email1"       : $(input).attr("data-Email1"),
				"Telefono1"    : $(input).attr("data-Telefono1"),
				"Nacionalidad" : $(input).attr("data-Nacionalidad")
			}
			contactos.push(item);
			//var cto = JSON.stringify(item);
			//$(input).val(cto);
		});
		var ctos = JSON.stringify(contactos);
		if($("#contactos").length == 0) {
		  $('#frmClient').append('<input type="hidden" name="contactos" id="contactos">');
		}
		
		$("#contactos").val(ctos);

		var direcciones = [];
		$(".dic-itm").each(function(i,input){
			var item = {
				"IDDir"       : $(input).attr("data-IDDir"),
				"Calle"       : $(input).attr("data-Calle"),
				"NOExt"    : $(input).attr("data-NOExt"),
				"NOInt"    : $(input).attr("data-NoInt"),
				"CPostal" 	   : $(input).attr("data-CPostal"),
				"Colonia" 	   : $(input).attr("data-Colonia"),
				"Poblacion" 	   : $(input).attr("data-Poblacion"),
				"Ciudad" 	   : $(input).attr("data-Ciudad"),
				"Pais"       : $(input).attr("data-Pais"),
				"Telefono1"    : $(input).attr("data-Telefono1"),
				"Telefono2" : $(input).attr("data-Telefono2")
			}
			direcciones.push(item);
			//var cto = JSON.stringify(item);
			//$(input).val(cto);
		});
		var dirs = JSON.stringify(direcciones);
		if($("#direcciones").length == 0) {
		  $('#frmClient').append('<input type="hidden" name="direcciones" id="direcciones">');
		}
		
		$("#direcciones").val(dirs);
		
		var frmCli = $('#frmClient').find('input').serializeArray();
		// console.log(frmCli);
		$('#frmClient').submit();
		//$('#frmClient').trigger('submit');
	});

	$('#btnCancel').click(function(e)
	{
		e.preventDefault();
		editar = false;
		window.location.reload(true);
		// $('.ctl-save').prop('disabled',true);
		//$('.addCto').off('click');
		//$('.form-control, .ctl-save, .fecha, .form-control2').prop('disabled',true);
		//$(".addCto").Attr("disabled","disabled");
		//$('.form-control').prop('disabled',true);
	});
       //Click dropdown
    $('#tabbody').on('click','.contact-item',function(e)
    {
    	e.preventDefault();
    	$(".editando").removeClass("editando");
    	$("#btnGuardar").removeAttr("data-new");
    	if (e.target.name == "editar" && editar)
    	{
    		//$("#btnGuardar").text("Guardar");
    		$("#btnGuardar").addClass("guardarCto");
    		$("#dvC").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
    		$("input:text, select").removeAttr("disabled");
    	}
    	else
    	{
    		//$("#btnGuardar").text("Aceptar");
    		$("#btnGuardar").removeClass("guardarCto");
    		$("#btnGuardar").attr("data-dismiss","modal");
    		$("#contact input:text").attr("disabled","disabled");
    		$("#dvC").html('');	
    	}
        //get data-for attribute
        var input = $(this).parent().find("input.cto-itm");
        //console.log(input);
        input.addClass("editando");
		var //IdCont = input.attr("data-IdCont"),
			Nombre = input.attr("data-Nombre");
			ApellidoP = input.attr("data-ApellidoP");
			ApellidoM = input.attr("data-ApellidoM");
			Alias = input.attr("data-Alias");
			//Sexo = input.attr("data-Sexo"),
			//FechaNac = input.attr("data-FechaNac"),
			//Edad   = input.attr("data-Edad"),
			Email1 = input.attr("data-Email1");
			Telefono1 = input.attr("data-Telefono1");
			Nacionalidad = input.attr("data-Nacionalidad");
			
			
		 //$(".IdCont").val("");      
		$(".Nombre").val("");      
		$(".ApellidoP").val("");      
		$(".ApellidoM").val("");      
		$(".Alias").val("");      
		//$("#txtEdadC").text("");
		//$(".Edad").val("");      
		//$(".FechaNac").val("");      
		$(".Email1").val("");      
		$(".Telefono1").val("");      
		$(".Nacionalidad").val("");   
			
			
		//$(".IdCont").val(IdCont);      
		$(".NombreCompleto").html("<span class='glyphicon glyphicon-info-sign'></span> " + Nombre + " " + ApellidoP + " "+ ApellidoM);      
		$(".Nombre").val(Nombre);      
		$(".ApellidoP").val(ApellidoP);      
		$(".ApellidoM").val(ApellidoM);      
		$(".Alias").val(Alias);      
		//$("#txtEdadC").text(Edad);
		//$(".Sexo").val(Sexo);
		//$(".Edad").val(Edad);      
		//$(".FechaNac").val(fechaNac);      
		$(".Email1").val(Email1);      
		$(".Telefono1").val(Telefono1);      
		//$(".Nacionalidad").val(Nacionalidad);      
    });

    $('#tabbodyd').on('click','.address-item',function(e)
    {
    	e.preventDefault();
    	$(".editando").removeClass("editando");
    	$("#btnGuardarD").removeAttr("data-new");
    	if (e.target.name == "editar" && editar)
    	{
    		//$("#btnGuardar").text("Guardar");
    		$("#btnGuardarD").addClass("guardarDic");
    		$("#dvD").html('<a class="btn btn-default btn-sm" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardarD").removeAttr("data-dismiss");
    		$("input:text, select").removeAttr("disabled");
    	}
    	else
    	{
    		//$("#btnGuardar").text("Aceptar");
    		$("#btnGuardarD").removeClass("guardarDic");
    		$("#btnGuardarD").attr("data-dismiss","modal");
    		$("#address input:text").attr("disabled","disabled");
    		$("#dvD").html('');	
    	}
        //get data-for attribute
        var input = $(this).parent().find("input.dic-itm");
        //console.log(input);
        input.addClass("editando");
		var //IdCont = input.attr("data-IdCont"),
			Calle = input.attr("data-Calle");
			NoExt = input.attr("data-NOExt");
			NoInt = input.attr("data-NoInt");
			CP = input.attr("data-CPostal");
			Colonia = input.attr("data-Colonia");
			Poblacion = input.attr("data-Poblacion");
			Ciudad = input.attr("data-Ciudad");
			Pais = input.attr("data-Pais");
			Telefono1 = input.attr("data-Telefono1");
			Telefono2 = input.attr("data-Telefono2");			
			
		 //$(".IdCont").val("");      
		$(".DCalle").val("");      
		$(".DNoExt").val("");      
		$(".DNoInt").val("");      
		$(".DCP").val("");      
		$(".DColonia").val("");      
		$(".DPoblacion").val("");      
		$(".DCiudad").val("");      
		$(".DPais").val("");      
		$(".DTelefono1").val("");      
		$(".DTelefono2").val("");   
			
			
		$(".DCalle").val(Calle);      
		$(".DNoExt").val(NoExt);      
		$(".DNoInt").val(NoInt);      
		$(".DCP").val(CP);      
		$(".DColonia").val(Colonia);      
		$(".DPoblacion").val(Poblacion);      
		$(".DCiudad").val(Ciudad);      
		$(".DPais").val(Pais);      
		$(".DTelefono1").val(Telefono1);      
		$(".DTelefono2").val(Telefono2);
    });

	$(document).on("click",".guardarCto",function(e)
	{
		e.preventDefault();
		var //IdCont = $(".IdCont").val().trim(),
			Nombre = $(".Nombre").val().trim();
			ApellidoP = $(".ApellidoP").val().trim();
			ApellidoM = $(".ApellidoM").val().trim();
			Alias = $(".Alias").val().trim();
			//Sexo = $(".Sexo").val().trim();
			//FechaNac = $(".FechaNac").val().trim();
			//Edad = = $(".Edad").val().trim();
			Email1 = $(".Email1").val().trim();
			Telefono1 = $(".Telefono1").val().trim();
			//Nacionalidad = $(".Nacionalidad").val().trim();	

			if(Nombre == "" && ApellidoP == "" && ApellidoM == "" && Email1 == "" && Telefono1 == ""){
				$("#contact").modal('hide');
				return;
			}	

		if ($(e.target).attr("data-new") == "true")
		{
			var sig = $("#tabbody tr").length + 1;
			$("#tabbody").append('<tr>'+
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td class="text-center">' +
											'<input type="hidden" name="contacto-' + sig + '" class="cto-itm editando" data-IdCont="-1">' +
											'<a name="ver" class="btn btn-primary btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
												'<span class="glyphicon glyphicon-eye-open" ></span>' +
											'Ver Info</a>' +
											' <a name="editar" class="btn btn-primary btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
												'<span class="glyphicon glyphicon-edit"></span>' + 
											'Editar</a>' +
										'</td>' +
				                      '</tr>');
		}
		
		var input = $(".editando");
		var Row = $(".editando").parents("tr");
		Row.find("td:eq(0)").text(Nombre + ' ' + ApellidoP + ' ' + ApellidoM);
		//Row.find("td:eq(1)").text(Puesto);
		Row.find("td:eq(3)").text(Email1);
		Row.find("td:eq(4)").text(Telefono1);
		
		//input.attr("data-IdCont",IdCont);
		input.attr("data-Nombre",Nombre);
		input.attr("data-ApellidoP",ApellidoP);
		input.attr("data-ApellidoM",ApellidoM);
		input.attr("data-Alias",Alias);
		//input.attr("data-Sexo",Sexo);
		//input.attr("data-Edad",Edad);
		//input.attr("data-FechaNac",FechaNac);
		input.attr("data-Email1",Email1);
		input.attr("data-Telefono1",Telefono1);
		//input.attr("data-Nacionalidad",Nacionalidad);

		input.removeClass("editando");

		$("#contact").modal('hide');
	});


	$(document).on("click",".guardarDic",function(e)
	{
		e.preventDefault();
		var //IdCont = $(".IdCont").val().trim(),
		Calle = $(".DCalle").val().trim();      
		NoExt =	$(".DNoExt").val().trim();      
		NoInt =	$(".DNoInt").val().trim();      
		CP = $(".DCP").val().trim();      
		Colonia = $(".DColonia").val().trim();      
		Poblacion =	$(".DPoblacion").val().trim();      
		Ciudad = $(".DCiudad").val().trim();      
		Pais = $(".DPais").val().trim();      
		Telefono1 =	$(".DTelefono1").val().trim();      
		Telefono2 = $(".DTelefono2").val().trim();	


		if(Calle == "" && NoExt == "" && CP == "" && Colonia == "" && Poblacion == "" && Ciudad == "" && Pais == "" && Telefono1 == "" && Telefono2 == "" ){
			$("#address").modal('hide');
			return;
		}

		if ($(e.target).attr("data-new") == "true")
		{
			var sig = $("#tabbodyd tr").length + 1;
			$("#tabbodyd").append('<tr>'+
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td class="text-center">' +
											'<input type="hidden" name="contacto-' + sig + '" class="dic-itm editando" data-IDDir="-1">' +
											'<a name="ver" class="btn btn-primary btn-xs address-item" data-toggle="modal" data-target="#address" data-original-title>' +
												'<span class="glyphicon glyphicon-eye-open" ></span>' +
											'Ver Info</a>' +
											' <a name="editar" class="btn btn-primary btn-xs address-item" data-toggle="modal" data-target="#address" data-original-title>' +
												'<span class="glyphicon glyphicon-edit"></span>' + 
											'Editar</a>' +
										'</td>' +
				                      '</tr>');
		}
		
		var input = $(".editando");
		var Row = $(".editando").parents("tr");
		Row.find("td:eq(0)").text(Calle);
		Row.find("td:eq(1)").text(NoExt);
		Row.find("td:eq(2)").text(NoInt);
		Row.find("td:eq(3)").text(CP);
		Row.find("td:eq(4)").text(Colonia);
		Row.find("td:eq(5)").text(Poblacion);
		Row.find("td:eq(6)").text(Ciudad);
		Row.find("td:eq(7)").text(Pais);
		Row.find("td:eq(8)").text(Telefono1);
		Row.find("td:eq(9)").text(Telefono2);
		
		input.attr("data-Calle",Calle);
		input.attr("data-NOExt",NoExt);
		input.attr("data-NoInt",NoInt);
		input.attr("data-CPostal",CP);
		input.attr("data-Colonia",Colonia);
		input.attr("data-Poblacion",Poblacion);
		input.attr("data-Ciudad",Ciudad);
		input.attr("data-Pais",Pais);
		input.attr("data-Telefono1",Telefono1);
		input.attr("data-Telefono2",Telefono2);
		//input.attr("data-Nacionalidad",Nacionalidad);

		input.removeClass("editando");

		$("#address").modal('hide');
	});
	$(document).on('change','#grupo',function(event){
        var IDR = $(this).val();

        $.ajax({
          method: "POST",
          url: "<?php echo base_url(); ?>" + "directorio/getSubGrupos",        
          //dataType: 'json',
          data: { IDGrupo : IDR },
            success: function(json){
                if(json != ""){
                 $('#subgrupo').find('option')
                                        .remove()
                                        .end();

                $('#subgrupo').append($('<option>',{
                            value : "",
                            text : "Selecccione un Sub Grupo",
                        }));
                    var oJson = JSON.parse(json);
                    $.each(oJson,function(k,v){
                        $('#subgrupo').append($('<option>',{
                            value : v.IDSGrupo,
                            text : v.SubGrupo,
                        }));
                    });
                }
            },
            error: function(jqXHR,textStatus,errorThrown ){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown );
                    alert('Error while request..');
            }
        });
    });

	$('#tipoent').change(function(e){
    	this.value;

    	if(this.value == "0"){
    		$('.ctn-m').hide();
			$('.ctn-f').show();
    	}else{
    		$('.ctn-m').show();
			$('.ctn-f').hide();
    	}

    });
	var fecha =	$('.fecha').datepicker({
		format: "dd/mm/yyyy",
	    startDate: "01/01/1900",
	    language: "es",
	    autoclose: true,
     	orientation: "top auto",
	});

    fecha.on('changeDate',function(ev){
        //console.log(ev);
        var todayTime = new Date(ev.date);
       	var hoy = new Date();
		var edad = Math.floor((hoy-todayTime) / (365.25 * 24 * 60 * 60 * 1000));
		if ($("#tipoent").val() == "0")
		{
	        $("#txtEdad").text(edad);
	        $("#edad").val(edad);
		}
        // $('.fecha').val(todayTime.yyyymmdd());
    });
	
	$("#tipoent").change(function() {
		
		var TipoEntidad = $(this).val();
		
		console.log(TipoEntidad);
	})
});
</script>
<?php $this->load->view('footers/footer'); ?>