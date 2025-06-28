<?php
$IDCli = $this->input->get('IDCli', TRUE);
$page = $this->input->get('page', TRUE);
if($page == ""){
	$page = 1;
}
#var_dump($ClienteContact);
#var_dump($Grupo);
if(!isset($ClienteContact)){
	redirect('/directorio');
}?>
<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
?>
<!-- End navbar -->
<section class="page-section">
	<div class="container">		
        <style>		
.panel.with-nav-tabs .panel-heading{
    padding: 5px 5px 0 5px;
}
.panel.with-nav-tabs .nav-tabs{
	border-bottom: none;
}
.panel.with-nav-tabs .nav-justified{
	margin-bottom: -1px;
}
/********************************************************************/
/*** PANEL DEFAULT ***/
.with-nav-tabs.panel-default .nav-tabs > li > a,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
}
.with-nav-tabs.panel-default .nav-tabs > .open > a,
.with-nav-tabs.panel-default .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-default .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-default .nav-tabs > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li > a:focus {
    color: #777;
	background-color: #ddd;
	border-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.active > a,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.active > a:focus {
	color: #555;
	background-color: #fff;
	border-color: #ddd;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #f5f5f5;
    border-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #777;   
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #ddd;
}
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-default .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #555;
}
/********************************************************************/
/*** PANEL PRIMARY ***/
.with-nav-tabs.panel-primary .nav-tabs > li > a,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
    color: #fff;
}
.with-nav-tabs.panel-primary .nav-tabs > .open > a,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-primary .nav-tabs > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li > a:focus {
	color: #fff;
	background-color: #3071a9;
	border-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.active > a:focus {
	color: #428bca;
	background-color: #fff;
	border-color: #428bca;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #428bca;
    border-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #fff;   
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #3071a9;
}
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-primary .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    background-color: #4a9fe9;
}
/********************************************************************/
/*** PANEL SUCCESS ***/
.with-nav-tabs.panel-success .nav-tabs > li > a,
.with-nav-tabs.panel-success .nav-tabs > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li > a:focus {
	color: #3c763d;
}
.with-nav-tabs.panel-success .nav-tabs > .open > a,
.with-nav-tabs.panel-success .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-success .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-success .nav-tabs > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li > a:focus {
	color: #3c763d;
	background-color: #d6e9c6;
	border-color: transparent;
}
.with-nav-tabs.panel-success .nav-tabs > li.active > a,
.with-nav-tabs.panel-success .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.active > a:focus {
	color: #3c763d;
	background-color: #fff;
	border-color: #d6e9c6;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #3c763d;   
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #d6e9c6;
}
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-success .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #3c763d;
}
/********************************************************************/
/*** PANEL INFO ***/
.with-nav-tabs.panel-info .nav-tabs > li > a,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
}
.with-nav-tabs.panel-info .nav-tabs > .open > a,
.with-nav-tabs.panel-info .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-info .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-info .nav-tabs > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li > a:focus {
	color: #31708f;
	background-color: #bce8f1;
	border-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.active > a,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.active > a:focus {
	color: #31708f;
	background-color: #fff;
	border-color: #bce8f1;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #d9edf7;
    border-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #31708f;   
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #bce8f1;
}
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-info .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #31708f;
}
/********************************************************************/
/*** PANEL WARNING ***/
.with-nav-tabs.panel-warning .nav-tabs > li > a,
.with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
	color: #8a6d3b;
}
.with-nav-tabs.panel-warning .nav-tabs > .open > a,
.with-nav-tabs.panel-warning .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-warning .nav-tabs > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li > a:focus {
	color: #8a6d3b;
	background-color: #faebcc;
	border-color: transparent;
}
.with-nav-tabs.panel-warning .nav-tabs > li.active > a,
.with-nav-tabs.panel-warning .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.active > a:focus {
	color: #8a6d3b;
	background-color: #fff;
	border-color: #faebcc;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #fcf8e3;
    border-color: #faebcc;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #8a6d3b; 
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #faebcc;
}
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-warning .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff;
    background-color: #8a6d3b;
}
/********************************************************************/
/*** PANEL DANGER ***/
.with-nav-tabs.panel-danger .nav-tabs > li > a,
.with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
	color: #a94442;
}
.with-nav-tabs.panel-danger .nav-tabs > .open > a,
.with-nav-tabs.panel-danger .nav-tabs > .open > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > .open > a:focus,
.with-nav-tabs.panel-danger .nav-tabs > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li > a:focus {
	color: #a94442;
	background-color: #ebccd1;
	border-color: transparent;
}
.with-nav-tabs.panel-danger .nav-tabs > li.active > a,
.with-nav-tabs.panel-danger .nav-tabs > li.active > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.active > a:focus {
	color: #a94442;
	background-color: #fff;
	border-color: #ebccd1;
	border-bottom-color: transparent;
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu {
    background-color: #f2dede; /* bg color */
    border-color: #ebccd1; /* border color */
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a {
    color: #a94442; /* normal text color */  
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > li > a:focus {
    background-color: #ebccd1; /* hover bg color */
}
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:hover,
.with-nav-tabs.panel-danger .nav-tabs > li.dropdown .dropdown-menu > .active > a:focus {
    color: #fff; /* active text color */
    background-color: #a94442; /* active bg color */
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
.form-control2[disabled], fieldset[disabled] .form-control2, .addCto[disabled] {
    cursor: not-allowed;
}
.form-control2[disabled], .form-control2[readonly], fieldset[disabled] .form-control2, .addCto {
    background-color: #eee;
    opacity: 1;
}
.addCto{
	cursor: pointer;
}
        </style>
			<div class="row" style="margin-top:3%;">
			  <div class="col-md-1">
				  <p>CLIENTE</p>		  
			  </div>
			  <div class="col-md-11">
				<a href="<?php echo base_url(); ?>directorio/GetPoliza?IDCli=<?php echo $IDCli; ?>&page=<?php echo $page; ?>" title="Documentos Cliente"><span class="glyphicon glyphicon-inbox text-color"></span></a>
				<a href="#" id="aEdit" title="Editar Cliente" style="margin-left:10px;"><span class="glyphicon glyphicon-pencil text-color"></span></a>
			  </div>
		  </div>
		 <div class="row">
			 <form id="frmClient" action="<?php echo base_url();?>directorio/updateClient">
				<div class="col-md-12">
					<div class="panel with-nav-tabs panel-default">
						<div class="panel-heading">
						<div class="row">
							<div class="col-md-9">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab1default" data-toggle="tab">Generales</a></li>
									<li><a href="#tab2default" data-toggle="tab">Contacto</a></li>
								</ul>
							</div>
							<div class="col-md-3">
								<div class="row">
									<div class="col-md-6">
										<input type="submit" class="btn form-control .ctl-save" id="btnSave" name="operacion" value="Guardar" disabled />
									</div>
									<div class="col-md-6">
										<button type="button" class="btn form-control .ctl-save"  id="btnCancel" name="operacion" disabled>Cancelar</button>
									</div>
								</div>
							</div>
						</div>		
						</div>
						<div class="panel-body">
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab1default">
								
									<div class="row">
									  <?php
										if(isset($ClienteContact)){
									   ?>
										 <div class="col-xs-6">
											  <p class="lead"></p>
											  <ul class="list-unstyled" style="line-height: 2">
												  <li>
													<div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Entidad</span>
																</button>															
														</div>
														<input type="hidden" class="form-control" name="idcli" value="<?php echo $ClienteContact["cliente"]->IDCli; ?>" >
														<input type="hidden" class="form-control" name="idcont" value="<?php echo $ClienteContact["cliente"]->IDCont; ?>" >
														<select class="form-control2" name="tipoent" id="tipoent" disabled>
															<option value="1" <?php echo ($ClienteContact["cliente"]->TipoEnt == "1")?'selected = "selected"':''; ?> >Moral</option>
															<option value="0" <?php echo ($ClienteContact["cliente"]->TipoEnt == "0")?'selected = "selected"':''; ?>>Física</option>
														</select>
													</div>
												  </li>	
											</ul>
										</div>
									</div>									
									<?php if($ClienteContact["cliente"]->TipoEnt == 0) { ?>
										<div class="row">
										 	<div class="col-xs-4">		
										  		<p class="lead"></p>
										  		<ul class="list-unstyled" style="line-height: 2">
										  			<li>
														<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Nombre</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="nombre" value="<?php echo $ClienteContact["cliente"]->Nombre; ?>" disabled>
														</div>
													</li>
													<li>
														<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Sexo</span>
																</button>															
															</div>
															<select name="sexo" class="form-control2" disabled>
																<option value="0" <?php echo ($ClienteContact["cliente"]->Sexo == "0" ? "selected" : ''); ?>>Masculino</option>
																<option value="1" <?php echo ($ClienteContact["cliente"]->Sexo == "1" ? "selected" : ''); ?>>Femenino</option>
															</select>
														</div>
											  		</li>
										  		</ul>
										  	</div>
										  	<div class="col-xs-4">
											 	<p class="lead"></p>
											  	<ul class="list-unstyled" style="line-height: 2">
													<li>
														<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Apellido Paterno</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="apellidoP" value="<?php echo $ClienteContact["cliente"]->ApellidoP; ?>" disabled>
														</div>
													</li>
													<li>
														<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Fecha de Nacimiento</span>
																	</button>															
															</div>
															<div class="input-group">
																<input type="text" class="form-control fecha" name="fechaNac" placeholder="01/01/1900" value="<?php echo strftime("%d/%m/%Y", strtotime($ClienteContact["cliente"]->FechaNac)); ?>" disabled>
								                                <div class="input-group-btn"><button class="btn btn-default fecha" type="button" disabled><i class="glyphicon glyphicon-calendar"></i>&nbsp;</button></div>
								                            </div>
														</div>
													</li>
												</ul>			 
										  	</div>
										  	<div class="col-xs-4">
										  		<p class="lead"></p>
										  		<ul class="list-unstyled" style="line-height: 2">
											  		<li>
												  		<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Apellido Materno</span>
																</button>															
															</div>
															<input type="text" class="form-control" name="apellidoM" value="<?php echo $ClienteContact["cliente"]->ApellidoM; ?>" disabled>
														</div>
													</li>
												  	<li>
												  	<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Edad</span>
																</button>															
															</div>
															<a class="form-control" disabled id="txtEdad"><?php echo $ClienteContact["cliente"]->Edad; ?></a>
															<input type="hidden" class="form-control" id="edad" name="edad" value="<?php echo $ClienteContact["cliente"]->Edad; ?>" disabled>
														</div>
													</li>	
												</ul>			 
									  		</div>
										</div>
									<?php } else {?>
										<div class="row">
										 	<div class="col-xs-8">		
										  		<p class="lead"></p>
										  		<ul class="list-unstyled" style="line-height: 2">
										  			<li>
										  				<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Razon social</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="razonsocial" value="<?php echo $ClienteContact["cliente"]->RazonSocial; ?>" disabled>
														</div>
													</li>
										  		</ul>
										  	</div>
										</div>
									<?php }?>
									<div class="row">
										<div class="col-xs-4">
										  <p class="lead"></p>
										  <ul class="list-unstyled" style="line-height: 2">										 
												<!--li>
													<div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Alias</span>
																</button>															
														</div>
														<input type="text" class="form-control" name="alias" value="<?php echo $ClienteContact["cliente"]->RazonSocial; ?>" disabled>
													</div>
												</li-->										  
											    <li>
													<div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Ejecutivo de cuenta</span>
																</button>															
														</div>
														<select class="form-control2" name="ejecutivoc" disabled>
															<option><?php echo $ClienteContact["cliente"]->EjecutNombre; ?></option>
														</select>
													</div>
											    </li>
												<li>
													<div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
															<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																<span class="concept">Sub Grupo</span>
															</button>															
														</div>
														<select class="form-control2" name="subgrupo" disabled>
															<option value="">Selecccione un Grupo</option>
															<?php if(isset($Grupo)){ 
								                            	foreach ($Grupo as $value) {
								                                	echo '<option value = "'.$value['IDSGrupo'].'" '. ($ClienteContact["cliente"]->IDSGrupo == $value['IDSGrupo'] ? 'selected' : '') .'>'.$value['SubGrupo'].'</option>';
								                             	}
								                            } ?>
														</select>
													</div>
												</li>
												<li>
												  <div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Nextel</span>
																</button>															
														</div>
														<input type="text" class="form-control" name="telefono2" value="<?php echo $ClienteContact["cliente"]->Telefono2; ?>" disabled>
													</div>
												</li>
												  <!--li>
														<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Sub sub Grupo</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="ssggrupo" value="<?php echo $ClienteContact["cliente"]->SSGrupo; ?>" disabled>
														</div>
												  </li-->
										  </ul>			  
									  </div>
										  <div class="col-xs-4">
											  <p class="lead"></p>
											  <ul class="list-unstyled" style="line-height: 2">
												  <li>
													  <div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Registro federal de contribuyente</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="rfc" value="<?php echo $ClienteContact["cliente"]->RFC; ?>" disabled>
														</div>
													</li>
												<li>
													<div class="form-group multiple-form-group input-group">
															<div class="input-group-btn input-group-select">
																	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																		<span class="concept">Celular</span>
																	</button>															
															</div>
															<input type="text" class="form-control" name="telefono1" value="<?php echo str_replace("Telefono1:",$ClienteContact["cliente"]->Telefono1); ?>" disabled>
														</div>
												</li>
												</ul>			 
										  </div>
										<div class="col-xs-4">
										  <p class="lead"></p>
										  <ul class="list-unstyled" style="line-height: 2">
											  <li>
												  <div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Grupo</span>
																</button>															
														</div>
														<select class="form-control2" name="grupo" id="grupo" disabled>
															<option value="">Selecccione un Grupo</option>
															<?php if(isset($Grupo)){ 
								                            	foreach ($Grupo as $value) {
								                                	echo '<option value = "'.$value['IdGrupo'].'" '. ($ClienteContact["cliente"]->IDGrupo == $value['IdGrupo'] ? 'selected' : '') .'>'.$value['Grupo'].'</option>';
								                             	}
								                            } ?>
														</select>
													</div>
												</li>
												  <li>
												  <div class="form-group multiple-form-group input-group">
														<div class="input-group-btn input-group-select">
																<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																	<span class="concept">Correo 1</span>
																</button>															
														</div>
														<input type="text" class="form-control" name="email1" value="<?php echo $ClienteContact["cliente"]->EMail1; ?>" disabled>
													</div>
												</li>										
											</ul>			 
									  </div>
									</div>	  
									 <?php
										}
									  ?>
								  </div>

								<div class="tab-pane fade" id="tab2default">
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
														<th>Telefono</th>
														<th class="text-center">Accion<?php #&nbsp;&nbsp;<a class="fa fa-plus-circle addCto" disabled>&nbsp;Contacto</a>?></th>
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
																	<a name="ver" class='btn btn-info btn-xs contact-item' data-toggle="modal" data-target="#contact" data-original-title>
																		<span class="glyphicon glyphicon-eye-open" ></span> 
																	Ver Info</a>
																	<a name="editar" class='btn btn-info btn-xs contact-item' data-toggle="modal" data-target="#contact" data-original-title>
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
					</div>
				</div>
			</form>
		</div>
	</div>            
</section>
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title" id="contactLabel"><p class="NombreCompleto"></p></h4>
                    </div>
                    
                    <div class="modal-body" style="padding: 5px;">
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
		                                <input class="form-control Email1" name="Email1" placeholder="E-mail" type="text" required />
		                            </div>
		                        </div>
		                        <div class="row">
		                            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
		                            	<label for="telefono1">Telefono1</label>
		                                <input class="form-control Telefono1" name="Telefono1" placeholder="Telefono1" type="text" required />
		                            </div>
		                        </div>
                    		</div>
                    	</div>
                    </div>  
                    <div class="panel-footer">
                    	<div class="row">
                    		<div class="col-md-2 col-md-offset-8" id="dvC">
							</div>
							<div class="col-md-2">
								<a class="btn btn-block btn-sm btn-primary" data-dismiss="modal" id="btnGuardar">Aceptar</a>
							</div>
                    	</div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js'); ?>'></script>
<script>
$(document).ready(function()
 {
 	<?php
 		if (strlen($msj) > 0)
 		{
 			echo 'alert("'.$msj.'");';
 		}
 	?>
	$('.addCto').off('click');

	$('#aEdit').click(function(e)
	{
		e.preventDefault();
		$('.form-control, .ctl-save, .fecha, .form-control2').prop('disabled',false);
		$(".addCto").removeAttr("disabled");
		$('.addCto').on("click", function(e)
		{
			e.preventDefault();
			$(".editando").removeClass("editando");
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
    		$("#dvC").html('<a class="btn btn-block btn-sm btn-danger" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
			$("#contact").modal('show');
		});
	});

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
		//console.log(contactos);
		var ctos = JSON.stringify(contactos);
		$('#frmClient').append('<input type="hidden" name="contactos" id="contactos">');
		$("#contactos").val(ctos);
		var frmCli = $('#frmClient').find('input').serializeArray();
		console.log(frmCli);
		$('#frmClient').submit();
		//$('#frmClient').trigger('submit');
	});

	$('#btnCancel').click(function(e)
	{
		e.preventDefault();
		// $('.ctl-save').prop('disabled',true);
		$('.form-control').prop('disabled',true);
	});
    
    var aButton = $('.contact-item');
    //Click dropdown
    aButton.click(function(e) 
    {
    	e.preventDefault();
    	$(".editando").removeClass("editando");
    	$("#btnGuardar").removeAttr("data-new");
    	if (e.target.name == "editar" && !$("#btnSave").is(":disabled"))
    	{
    		//$("#btnGuardar").text("Guardar");
    		$("#btnGuardar").addClass("guardarCto");
    		$("#dvC").html('<a class="btn btn-block btn-sm btn-danger" data-dismiss="modal">Cancelar</a>');
    		$("#btnGuardar").removeAttr("data-dismiss");
    		$("input:text, select").removeAttr("disabled");
    	}
    	else
    	{
    		//$("#btnGuardar").text("Aceptar");
    		$("#btnGuardar").removeClass("guardarCto");
    		$("#btnGuardar").attr("data-dismiss","modal");
    		$("input:text").attr("disabled","disabled");
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

		if ($(e.target).attr("data-new") == "true")
		{
			var sig = $("#tabbody tr").length + 1;
			alert(sig);
			$("#tabbody").append('<tr>'+
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td></td>' +
										'<td class="text-center">' +
											'<input type="hidden" name="contacto-' + sig + '" class="cto-itm editando" data-IdCont="-1">' +
											'<a name="ver" class="btn btn-info btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
												'<span class="glyphicon glyphicon-eye-open" ></span>' +
											'Ver Info</a>' +
											'<a name="editar" class="btn btn-info btn-xs contact-item" data-toggle="modal" data-target="#contact" data-original-title>' +
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

	var fecha =	$('.fecha').datetimepicker({
		//startDate: '2016-01-27',
		startView: 2,
		minView: 2,
		maxView: 2,
		autoclose: true,
		todayHighlight: true,
		changeMonth: true,
        changeYear: true,
		format: 'dd/mm/yyyy',
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
        $('.fecha').val(todayTime.yyyymmdd());
    });
});
</script>
<?php $this->load->view('footers/footer'); ?>