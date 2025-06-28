<?php
	$this->load->view('headers/header');
?>
<!-- Navbar -->
<?php
	$this->load->view('headers/menu');
	//echo $this->tank_auth->get_usermail();
?>

<!-- <meta name="viewport" content="width=900px"/> -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/iconos.css">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<style type="text/css">
  	body {
    	font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
  	}
  	/*ID*/
  		#textNote {min-height: 200px;}
  		#contTableExport {height: 350px;overflow: auto;border-bottom: 1px solid #dbdbdb;background: #f7f7f7;padding: 0px;}
    	#bodyTableMessagesClient > tr > td:nth-child(3) {min-width: 250px;}
    	#bodyTableMessagesClient > tr > td:nth-child(4) {min-width: 350px;}
    	#bodyTableMessagesClient > tr > td:nth-child(5) > select {width: 280px;}
    	#bodyTableMessagesClient > tr > td:nth-child(6) > select {width: 350px;}
    	#bodyTableMessagesClient > tr > td:nth-child(7) > div {min-width: 280px;}
    	#bodyTableMessagesClient > tr > td:nth-child(8) {min-width: 150px;}
    	#bodyTableMessagesClient > tr > td:nth-child(9) > select {width: 200px;}
    	#tableMessagesClient_wrapper {max-height: 650px;overflow: auto;}
    	#tableMessagesClient_length {justify-content: flex-start;width: 50%;}
    	#tableMessagesClient_length > label, #tableMessagesClient_filter > label {font-size: 13px;}
    	#tableMessagesClient_length > label > select {color: #472380;border: 1px solid #d2d2d2;border-radius: 2px;height: 30px;line-height: 30px;padding: 5px 10px;font-size: 12px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
    	#tableMessagesClient_length > label > select:focus, #tableMessagesClient_filter > label > input:focus {border-color:#472380;outline:0;box-shadow:0 0 0 .25rem rgba(71,35,128,.25);}
    	#tableMessagesClient_length > label > select:active, #tableMessagesClient_filter > label > input:active {filter:brightness(90%);}
    	#tableMessagesClient_filter {justify-content: flex-end;width: 50%;}
    	#tableMessagesClient_filter > label > input {color: #472380;border: 1px solid #d2d2d2;border-radius: 2px;height: 30px;padding: 5px 10px;font-size: 12px;line-height: 1.5;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;}
  	/*Spinners*/
    	.container-spinner-content-loading {
    	    margin: 0px;
    	    color: #266093;
    	    width: 100%;
    	    height: 100%;
    	    align-items: center;
    	    display: flex;
    	    flex-direction: column;
    	    justify-content: center;
    	    position: relative;
    	    background-color: rgb(255 255 255 / 95%);
    	    /*z-index: 1;*/
    	    transition: all 0.3s;
    	}
    	.container-spinner-btn-loading {
    	    margin: 0px;
    	    color: white;
    	    width: 100%;
    	    height: 100%;
    	    align-items: center;
    	    display: flex;
    	    flex-direction: column;
    	    justify-content: center;
    	    position: relative;
    	    /*z-index: 1;*/
    	    transition: all 0.3s;
    	}
  	/*Containers*/
    	.contenido{display: flex;/*margin-left: 40px;*/width: 100%;align-items: stretch;}
    	.contenidoPrincipal{display: flex;flex-direction: column;padding: 15px 25px;width: 100%;transition: all 0.3s;}
    	.panel_botones{background-color: #fff;min-width: 125px;max-width: 125px;float: left;padding: 5px;height: auto;border-right: 1px solid #e1e1e1;transition: all 0.3s;}
    	.contenedor-modalEncuestas{background-color: rgb(221, 241, 241);align-items: center;width: 700px;margin-left: auto;margin-right:auto;margin-top: 100px;height:550px;overflow: scroll;}
    	.container-spinner {width: -webkit-fill-available;height: -webkit-fill-available;/*position: absolute;*/z-index: 2;}
    	.container-spinner-table-client {width: 600px;}
    	.panel {box-shadow: 0px 1px 5px 0px rgb(0 0 0 / 31%);}
    	.container-table {/*height: 400px;*/overflow: auto;border: 1px solid #dbdbdb;padding: 10px;border-radius: 4px;}
    	.input-group {display: flex;}
    	.input-group > select {border-radius: 0px .25rem .25rem 0px;}
    	.input-group > input.form-control {border-radius: 0px .25rem .25rem 0px;width: auto;}
    	.container-calendar {border: 1px solid #dbdbdb;border-radius: 4px;max-height: 350px;overflow: auto;}
    	.container-history {max-height: 280px;overflow: auto;margin-bottom: 10px;border-bottom: 1px solid #8f8f8f;}
    	.container-note {min-width: 200px;padding: 5px;background: #fffdef;border: 1px solid #cfc359;border-radius: 5px;}
    	.segment-search-filter {padding: 5px 10px;border: 1px solid #dbdbdb;border-radius: 5px;}
    	.container-message {display: flex;justify-content: flex-start;align-items: flex-start;max-width: 500px;min-width: 200px;}
    	.fc-day-grid-event, .fc-time-grid-event {display: flex;}
    	.cont-date-delete {width: -webkit-fill-available;padding: 0.5px;}
    	.cont-date-icon-delete {float: right;color: white;border: 1px solid #b50404;width: 12px;height: 12px;position: relative;background-color: #b50404;border-radius: 5px;display: flex;align-items: center;justify-content: center;padding: 1px;cursor: pointer;}
    	.sttaus-client {display: block;}
  	/*Modals*/
    	.modal {background-color: rgb(0 0 0 / 17%);}
    	/*.modal-dialog.modal-lg {margin: 5% auto;}*/
  	/*Columns*/
    	.column-flex-center-center {display: flex;justify-content: center;align-items: center;}
    	.column-flex-center-start {display: flex;justify-content: flex-start;align-items: center;}
    	.column-flex-center-end {display: flex;justify-content: flex-end;align-items: center;}
    	.column-flex-content-center {display: flex;justify-content: center;}
    	.column-flex-start {display: flex;justify-content: flex-start;}
    	.column-flex-end {display: flex;justify-content: flex-end;}
    	.column-flex-items-center {display: flex;align-items: center;}
    	.column-flex-bottom {display: flex;align-items: flex-end;}
    	.column-grid-start {display: flex;flex-direction: column;align-items: flex-start;}
    	.column-grid-center {display: flex;flex-direction: column;align-items: center;justify-content: center;}
    	.column-flex-space-evenly {display: flex;justify-content: space-evenly;}
    	.width-ajust {width: 100%;max-width: max-content;}
  	/*Botons*/
  		/*.btn {font-size: 13px;}*/
    	.btn-primary.active, .btn-primary.focus, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
    	.open>.dropdown-toggle.btn-primary {color: #fff;background-color: #286090;border-color: #286090;}
    	.btn-primary {color: #fff;background-color: #286090;border-color: #286090;font-size: 13px;}
    	.btn-primary.btn-sm {font-size: 12px;}
    	.btn-danger {color: white;}
    	.boton{border: 1px solid #a892cb;border-radius: 8px;border-width: 1px;text-align: center;max-height: 110px;max-width: 110px;cursor: pointer;transition: 0.3s;background: #fcfbff;padding: 3px;color: #2f1d5a;}
    	.lbboton{font-size: 12px;font-family: verdana;}
    	.btn-burguer {outline: none;background: transparent;border: none;color: #472380;padding: 3px;cursor: pointer;font-size: 18px;display: none;}
    	.btn-export-report {background: #449d44;border-color: #449d44;color: #FFFFFF;}
    	.btn-view-cont {color: #26418f;font-size: 20px;outline: none;border: 1px solid #dbdbdb;border-radius: 5px;background: #e9e9e9;transition: 0.3s;}
    	.btn-textNote {background: #ddd;border-radius: #ddd;color: black;}
    	.btnFilterDrop {background: none;color: white;border: none;}
    	.btn-primary:hover {background: #3e45a1;border-color: transparent;}
    	.boton:hover {background: #f0f2ff;border-color: #bec3e1;transition: 0.3s;color: #1d325a;}
    	.btn-export-report:hover {background: #43BD55;border-color: #43BD55;}
    	.btn-view-cont:hover {background: #d1d1d1;}
    	button.btn:active, .btn-burguer:active, .btn-view-cont:active, .btnBotonera:active, .btnTest:active, .btn-textNote:active {
    	  outline: 0;
    	}
    	button:focus, button.btn:focus, .btn-burguer:focus, .btn-view-cont:focus, .btnBotonera:focus, .btnTest:focus, .btn-textNote:focus {
    	  outline: 0;
    	}
    /*Dropdown*/
  		.li-filter > li {font-size: 12px;padding: 0px 8px 0px 3px;}
		.drop-content {display: none;position: absolute;background-color: #f9f9f9;min-width: auto;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);transform: translate3d(-90px, 0px, 0px);top: 0px;left: 0px;will-change: transform;}
  	/*Tables*/
  		table {height: 100%;margin: 0px;/*font-size: 12px;*/}
  		table > tbody {font-size: 12px;}
    	.table > thead >.tr-style {background: #5d418b;}
    	.table-thead {position: sticky;top: 0;z-index: 1;}
    	.table-tfoot {position: sticky;bottom: 0px; background-color:#e3e3e3;}
  	/*Texts*/
  		label {font-weight: 600;}
    	.titleSection {font-size: 18px;color: #362380;margin-bottom: 0px;}
    	.subtitleSection {font-size: 14px;color: #3d3d3d;margin-right: 5px;margin-bottom: 0px;}
    	.textCheck {font-size: 16px;font-weight: 600;color: green;margin: 0px 5px;}
    	.textError {font-size: 16px;font-weight: 600;color: red;margin: 0px 5px;}
    	.textAssign {font-size: 16px;font-weight: 600;color: #286090;margin: 0px 5px;}
    	.title-result {margin-top: 0px;margin-bottom: 0px;color:white;font-size: 16px;}
    	.subtitleModal {text-align: center;color: black;font-size: 16px;}
    	.title-table {text-align: center;}
    	.form-check-label {font-size: 13px;color: #3d3d3d;margin-left: 3px;}
    	.input-group-text {border-radius: .25rem 0px 0px .25rem;border-right: 0px;width: 35px;justify-content: center;}
    	.input-group-text > i {font-size: 14px;}
    	.form-check > label {margin-right: 5px;}
        .label-danger {padding: .2em .6em;background-color: #c10500;border-radius: 5px;font-weight: 600;}
  	/*Icons*/
    	.icon-circle-check {font-size: 25px;color: green;}
    	.icon-circle-close {font-size: 25px;color: red;}
    	.icon-circle-send {font-size: 15px;color: green;}
    	.icon-circle-no-send {font-size: 15px;color: orange;}
    	.icon-circle-assign {font-size: 25px;color: #286090;}
    	.icon-star {font-size: 16px;}
    	p.store {position: relative;overflow: hidden;display: inline-block;}		
		p.store input {position: absolute;top: -100px;}		
		p.store label {float: right;color: #286090;cursor: pointer;transition: 0.3s;}		
		p.store label:hover,
		p.store label:hover ~ label,
		p.store input:checked ~ label {color: #ddca27;}
    	/*.icon-delete {float: right;color: white;border: 1px solid #b50404;width: 12px;height: 12px;position: relative;top: -15px;background-color: #b50404;border-radius: 5px;display: flex;align-items: center;justify-content: center;padding: 1px;}*/
    	.container-message > i.fa-comments {padding: 2px 5px;font-size: 15px;}
  	/*Others*/
    	.pd-left {padding-left: 0px;}
    	.pd-right {padding-right: 0px;}
    	.pd-top {padding-top: 15px;}
    	.pd-bottom {padding-bottom: 15px;}
    	.title-hr {margin: 10px 0px 10px 0px;border-top: 1px solid #deceeb;}
    	.subtitle-hr {margin: 10px 0px 10px 0px;border-top: 1px solid #dbdbdb;}
    	.infoModal{position: relative; left: 0%;top: 30%}
    	.labelModal{color: red;background-color: white; font-size: 18px;}
    	.brd-right {border-right: 1px solid #dbdbdb;}
    	.history-hr {border-color: #c3beaf;margin: 10px 0px;}
    	.mg-right {margin-right: 5px;}
    	.mg-bottom {margin-bottom: 5px;}
    	.pd-side {padding-left: 5px;padding-right: 5px;}
    	.segment-search-filter > .pd-side:nth-child(3) {padding-right: 10px;}
    	.segment-search-filter > .pd-side:nth-child(4) > .form-check:nth-child(1) {padding-left: 5px;}
    	.datos-hr {margin: 10px 0px;border-top: 1px solid #78609f;}
  	/*Swal*/
    	.swal-modal {width: 28%; /* 68% height: 40%*/}
    	.swal-button--confirm{background-color:#337ab7!important;}
    	.swal-text{/*color:#472380 !important;*/font-size: 17px;text-align: center;}
  	/*Checkbox | Radio*/
    	.form-check-input {
    	  	width: 23px;
    	  	height: 23px;
    	  	margin-top: .25em;
    	  	vertical-align: top;
    	  	background-color: #fff;
    	  	background-repeat: no-repeat;
    	  	background-position: center;
    	  	background-size: contain;
    	  	border: 1px solid rgba(0,0,0,.25);
    	  	-webkit-appearance: none;
    	  	-moz-appearance: none;
    	  	appearance: none;
    	  	-webkit-print-color-adjust: exact;
    	  	color-adjust: exact;
    	  	print-color-adjust: exact;
    	  	position: inherit;
    	}
    	input.form-check-input[type=checkbox] {
    	    border-radius: .5em;
    	    cursor: pointer;
    	    margin: 0px 5px;
    	    outline: 0;
    	}
    	input.form-check-input[type=radio] {
    	  	border-radius: 50%;
    	  	cursor: pointer;
    	  	margin: 0px 0 0;
    	  	margin-top: 1px \9;
    	  	line-height: normal;
    	  	outline: 0;
    	}
    	.form-check .form-check-input {
    	    float: left;
    	}
    	.form-check-input:active{
    	  	filter:brightness(90%);
    	}
    	.form-check-input:focus{
    	  	border-color:#86b7fe;
    	  	outline:0;
    	  	box-shadow:0 0 0 .25rem rgba(13,110,253,.25);
    	}
    	.form-check-input:disabled {
    	  	pointer-events: none;
    	  	filter: none;
    	  	opacity: .5;
    	}
    	.form-check-input:checked{
    	  	background-color:#0d6efd;
    	  	border-color:#0d6efd;
    	}
    	.form-check-input:checked[type=checkbox]{
    	  	background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    	}
    	.form-check-input:checked[type=radio] {
    	  	background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='2' fill='%23fff'/%3e%3c/svg%3e");
    	}
    /*DataTable*/
		/*.dataTables_wrapper {height: 470px;overflow: auto;}*/
		.dataTables_wrapper .dataTables_length, 
		.dataTables_wrapper .dataTables_filter, 
		.dataTables_wrapper .dataTables_info, 
		.dataTables_wrapper .dataTables_processing, 
		.dataTables_wrapper .dataTables_paginate {
		    width: 100%;
		    align-items: center;
		    display: flex;
		    justify-content: center;
		    left: 0px;
		    position: sticky;
		}
		.dataTables_wrapper .dataTables_info {bottom: 35px;background: white;border-top: 1px solid darkgray;}
		.dataTables_wrapper .dataTables_paginate {bottom: 0;background: white;}
</style>

<div class="contenido" id="ContentEncuesta">
  	<div class="contenidoPrincipal" id="ContainerContent">
    	<div>
      		<section class="container-fluid breadcrumb-formularios">
        		<div class="row">
          			<div class="col-md-12 column-flex-center-start">
            			<h3 class="title-section-module">
              				<button class="btn-burguer" id="BtnMenuBurguer" title="Menú">
                				<i class="fa fa-bars" aria-hidden="true"></i></button>
              				<span id="TitleSectionTest">Proceso TeleMarketing</span>
            			</h3>
          			</div>
        		</div>
        		<hr/>
      		</section>
    	</div>
    	<div class="divContenidoEncuesta"> 
			<div class="panel panel-default" style="margin-bottom: 80px;">
			  	<div class="panel-body">
			  		<?//echo "<pre>";
						if($this->tank_auth->get_usermail() == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $this->tank_auth->get_usermail() == "MARKETING@AGENTECAPITAL.COM" || $this->tank_auth->get_usermail() == "AUXILIARMKT@AGENTECAPITAL.COM"){?>
			  		<div class="col-md-12 column-flex-center-end">
						<form id="Mailing" method="post" action="<?=base_url()?>mailing">
        			    	<button class="btn btn-primary btn-sm">
								<i class="fa fa-envelope"></i> Administración Mailing
							</button>
        			    </form>  
					</div>
					<? } ?>
			  		<div class="col-md-12" style="margin-bottom: 25px;">
              			<h5 class="titleSection">Agregar Nuevo Cliente
              			<button class="btn-view-cont open-icon" data-icon="1" data-toggle="collapse" href="#contNewClient" aria-expanded="true">
          					<i class="fa fa-eye" data-class="fa fa-eye" title="Ver"></i>
        				</button></h5>
              			<hr class="title-hr">
              			<div class="col-md-12 collapse" id="contNewClient">
			  				<div class="row form-group">
			  					<div class="col-md-5 column-flex-center-start width-ajust">
        					    	<label class="subtitleSection">Seleccione el tipo de Cliente:</label>
        					    	<div class="input-group width-ajust">
                                		<label class="input-group-text">
                                			<i class="fas fa-user"></i>
                                		</label>
										<select id="tipo_cliente" class="form-control input-sm width-ajust" title="Nuevo Cliente">
            								<option value="0">Nuevo Cliente</option>
                							<option value="Moral">Persona Moral</option>
            								<option value="Fisica">Persona Fisica</option>
										</select>
									</div>				
  								</div>
  							</div>
  							<div class="row form-group tipoCliente1" style="display: none;">
  								<div class="col-md-12">
        					    	<label class="subtitleSection">Razón:</label>
  									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-pencil-alt"></i>
                                		</label>
        					    		<input type="text" id="razon" placeholder="Razon Social" class="form-control input-sm">
									</div>
								</div>
  							</div>
							<div class="row form-group tipoCliente2" style="display: none;">
								<div class="col-md-4">
        							<label class="subtitleSection">Nombres:</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-portrait"></i>
                                		</label>
        							    <input type="text" id="nombre" placeholder="Nombre" class="form-control input-sm">
        							</div>
								</div>
								<div class="col-md-4">
        						    <label class="subtitleSection">A. Paterno:</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-user-edit"></i>
                                		</label>
        						    	<input type="text" id="apellidop" placeholder="Apellido Paterno" class="form-control input-sm">
        						    </div>
								</div>
								<div class="col-md-4">
        						    <label class="subtitleSection">A. Materno:</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-user-edit"></i>
                                		</label>
        						    	<input type="text" id="apellidom" placeholder="Apellido Materno" class="form-control input-sm"> 
        						    </div>
        						</div>			
							</div>
							<div class="row form-group tipoCliente" style="display: none;">
								<div class="col-md-3">
        						    <label class="subtitleSection">RFC:</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-address-card"></i>
                                		</label>
        						    	<input type="text" id="rfc" placeholder="RFC" class="form-control input-sm">
        						    </div>
								</div>
								<div class="col-md-3">
									<label class="subtitleSection">Email</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-envelope"></i>
                                		</label>
										<input type="email" id="email" placeholder="Email xx@yy.com" class="form-control input-sm" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}">
									</div>
								</div>
								<div class="col-md-3">
									<label class="subtitleSection">Tel Cel.</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-mobile-alt"></i>
                                		</label>
										<input type="text" id="celular" placeholder="10 Digitos" maxlength="10" class="form-control input-sm" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
									</div>
        						</div>
	    					</div>
							<div class="row form-group tipoCliente" style="display: none;">
								<div class="col-md-3">
        						    <label class="subtitleSection">Ramo:</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-file-medical-alt"></i>
                                		</label>
        						    	<select id="ramo" class="form-control input-sm" style="width: 80%;">
        						    		<option value="0"></option>
        						    		<option value="http://www.capitalsegurosgmm.com">GMM</option>
        						    		<option value="http://www.fianzascapital.com.mx">Fianzas</option>
        						    		<option value="http://capsys.com.mx/client">Client Crox</option>
        						    	</select>
        						    </div>
								</div>
								<div class="col-md-6">
									<label class="subtitleSection">Mensaje</label>
									<div class="input-group">
                                		<label class="input-group-text">
                                			<i class="fas fa-comment"></i>
                                		</label>
										<textarea type="text" id="mensaje" placeholder="Ejemplo: Buenas tardes, quisiera saber informacion sobre una fianza..." class="form-control input-sm" style="width: 80%;min-height: 30px;"></textarea>
									</div>
								</div>
								<div class="col-md-3 column-flex-top" style="padding-top: 20px;">
	    						    <button class="btn btn-primary" id="AddClient" style="width: 100%;" onclick="verifyField(1)"><i class="fas fa-user-plus"></i> Agregar Prospecto</span>
                    		    	</button>
	    						</div>
	    					</div>
	    				</div>
    		    	</div>
    		    	<div class="col-md-12" style="margin-bottom: 25px;">
              			<h5 class="titleSection">Clientes
              			<button class="btn-view-cont open-icon" data-icon="2" data-toggle="collapse" href="#contTableClient" aria-expanded="true">
          					<i class="fa fa-eye-slash" data-class="fa fa-eye" title="Ocultar"></i>
        				</button></h5>
              			<hr class="title-hr">
              			<div class="col-md-12 collapse show in" id="contTableClient">
              				<div class="col-md-12 segment-search-filter mg-bottom">
              					<div class="col-md-12 column-flex-center-start mg-bottom">
              						<label class="subtitleSection mg-right">Buscar por:</label>
              						<div class="form-check column-flex-center-center" style="padding-right: 1.25rem;">
                  						<input type="checkbox" class="form-check-input" name="check-search" value="1" checked>
                  						<label class="form-check-label">Mes</label>
                  						<input type="checkbox" class="form-check-input" name="check-search" value="2" checked>
                  						<label class="form-check-label">Año</label>
                  						<input type="checkbox" class="form-check-input" name="check-search" value="3">
                  						<label class="form-check-label mg-right">Fecha </label>
                  						<input type="checkbox" class="form-check-input" name="check-search" value="4">
                  						<label class="form-check-label">Canal</label>
                  					</div>
                  					<button class="btn btn-primary" id="btnSearch" onclick="verifyField(3)">
                      					<i class="fas fa-search"></i> Buscar</button>
                				</div>                				
              					<div class="col-md-12 segment-search-filter column-flex-center-start">
              						<div class="pd-side">
              							<label class="form-check-label">Mes:</label>
                						<select class="form-control width-ajust input-sm" id="searchMonth">
                							<?=$option1?>
                						</select>
                					</div>
                					<div class="pd-side">
              							<label class="form-check-label">Año:</label>
                						<select class="form-control width-ajust input-sm" id="searchYear">
                							<?=$option2?>
                						</select>
                					</div>
                					<div class="pd-side brd-right">
              							<label class="form-check-label">Fecha:</label>
                						<input type="date" class="form-control input-sm width-ajust" id="searchDate" value="<?=date('Y-m-d')?>" disabled>
                					</div>
                					<div class="pd-side column-flex-center-start">
                						<div class="form-check column-flex-center-center" style="display: none;">
                  							<input type="radio" class="form-check-input" name="searchChannel" value="1" disabled>
                  							<label class="form-check-label">Asesores</label>
                  						</div>
                						<div class="form-check column-flex-center-center">
                  							<input type="radio" class="form-check-input" name="searchChannel" value="2" checked disabled>
                  							<label class="form-check-label">Seguros</label>
                  						</div>
                						<div class="form-check column-flex-center-center">
                  							<input type="radio" class="form-check-input" name="searchChannel" value="3" disabled>
                  							<label class="form-check-label">Fianzas</label>
                  						</div>
                					</div>
              					</div>
              				</div>
              				<div class="col-md-12 pd-left pd-right" style="padding-bottom: 5px;">
              					<div class="col-md-6 column-flex-center-start pd-left">                     				
              						<div class="pd-side width-ajust pd-left" style="display: none;">
                    					<button class="btn btn-primary" id="btnProof">
                      					<i class="fas fa-search"></i> Buscar</button>
              						</div>
              						<div class="pd-side width-ajust pd-left brd-right">
                    					<button class="btn btn-primary" id="btnCalendar">
                      					<i class="fas fa-calendar-alt"></i> Calendario</button>
                      				</div> 
              						<div class="pd-side width-ajust pd-left">
              							<button class="btn btn-export-report" id="ExportTMC" disabled><i class="fas fa-file-excel"></i> Exportar Tabla</button>
                  					</div>
              						<div class="pd-side width-ajust pd-left">
              							<button class="btn btn-export-report" id="ExportTCE" disabled><i class="fas fa-file-excel"></i> Exportar Lead</button>
                  					</div>
              						<div class="pd-side width-ajust pd-left">
              							<form id="ExportaClientes" method="GET" action="<?=base_url()?>callcenter/ExportaClientes">
              								<button class="btn btn-export-report"><i class="fas fa-file-excel"></i> Exportar Clientes</button>
              							</form>
                  					</div>
              					</div>
              				</div>
    		    			<div class="col-md-12 container-table" id="contTMC" style="height: 650px;">
              					<div class="container-spinner" id="spinnerTMC" style="position: relative;">
              						<div class="container-spinner-content-loading">
                    				    <div class="bd-spinner spinner-border" role="status">
                    				        <span class="visually-hidden"></span>
                    				    </div>
                    				    <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                    				</div>
                    			</div>
                    			<div id="contTable"></div>
    		    			</div>
    		    			<div class="col-md-12">
    		    				<medium style="font-weight: 600;"><i>Total de resultados: <b id="TotalResult">0</b></i></medium>
    		    			</div>
    		    		</div>
    		    	</div>
				</div>
				<div class="panel panel-default" style="display: none;">
                    <div class="panel-body">
					   <div class="col-md-12" id="conTablesExport" style="height: 350px;overflow: auto;"></div>
					   <div class="col-md-12" id="conClientExport" style="height: 350px;overflow: auto;"></div>
                    </div>
				</div>
			</div>
		</div>
  	</div>
</div>

<!-- Modal Calendario -->
<div class="modal fade calendar-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Agendar Cita</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
      	<div class="col-md-12" style="padding-bottom: 5px;">
      		<label class="subtitleSection">Título:</label>
      		<input type="text" class="form-control input-sm" id="tituloCita">
      	</div>
      	<div class="col-md-12 column-flex-bottom pd-bottom">
      		<div class="col-md-2 pd-left">
      			<label class="subtitleSection">Fecha:</label>
      			<input type="date" class="form-control input-sm width-ajust" id="dpCita" value="<?=date('Y-m-d')?>">
      		</div>
      		<div class="col-md-2 width-ajust pd-left">
      			<label class="subtitleSection">De:</label>
      			<select class="form-control input-sm width-ajust" id="selFecIniCita"></select>
      		</div>
      		<div class="col-md-2 width-ajust pd-left">
      			<label class="subtitleSection">A:</label>
      			<select class="form-control input-sm width-ajust" id="selFecFinCita"></select>
      		</div>
      		<div class="col-md-2 width-ajust pd-left">
      			<button onclick="verifyField(2)" class="btn btn-primary" id="btnCita">Guardar Cita</button>
      		</div>
      	</div>
      	<div class="col-md-12 container-calendar pd-top pd-bottom"><div id='calendar'></div></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal Nota -->
<div class="modal fade note-modal" tabindex="-1" role="dialog" aria-labelledby="xd" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header column-select">
        <h4 class="title-result">Agregar Nota</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-10px;font-size:30px;color: lavender; padding:3px;">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
        </button>
      </div>
      <div class="modal-body" style="background: #f9f9f9;">
      	<div class="col-md-12 column-flex-center-start" style="padding-bottom: 5px;">
      		<label class="subtitleSection">Agregar texto:</label>
      		<button class="btn btn-textNote" onclick="insertText()">Cliente Interesado en Ramo:</button>
      	</div>
      	<div class="col-md-12 pd-bottom">
      		<textarea class="form-control input-sm" id="textNote" maxlength="200"></textarea>
      	</div>
      	<div class="col-md-12" style="display: none;"><input type="text" class="form-control input-sm" id="IDCliModal">
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="btnSaveNote" onclick="newNote()">Guardar</button>
        <button class="btn btn-default close-list" data-dismiss="modal" id="closeModalMissing">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/locale/es.js'></script>
<script src="https://unpkg.com/xlsx@latest/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script src="<?=base_url()?>/assets/gap/js/datatables.js"></script>
<script src="<?=base_url()?>/assets/js/bootstrap-table-export.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		schedule();
		$('#btnSearch').click();

		$('#tipo_cliente').change(function() {
			if (this.value == "Moral") {
				$('.tipoCliente').css('display','');
				$('.tipoCliente1').css('display','');
				$('.tipoCliente2').css('display','none');
			}
			else if (this.value == "Fisica") {
				$('.tipoCliente').css('display','');
				$('.tipoCliente1').css('display','none');
				$('.tipoCliente2').css('display','');				
			}
			else{				
				$('.tipoCliente').css('display','none');
				$('.tipoCliente1').css('display','none');
				$('.tipoCliente2').css('display','none');
			}
		})

		$('.open-icon').click(function() {
			openContainer(this);
		})

		$('input[name="check-search"]').click(function() {
			let checkbox = document.getElementsByName('check-search');
			const val = this.value;
			var check = 0;
			//Valor
			switch (val) {
				case "1":
					if (this.checked) { $('#searchMonth').prop('disabled',false);}
					else { $('#searchMonth').prop('disabled',true); }
				break;
				case "2":
					if (this.checked) { $('#searchYear').prop('disabled',false);}
					else { $('#searchYear').prop('disabled',true); }
				break;
				case "3":
					if (this.checked) { 
						$('#searchDate').prop('disabled',false);
						$('#searchMonth').prop('disabled',true);
						$('#searchYear').prop('disabled',true);
						$('input[name="check-search"][value="1"]').prop('disabled',true);
						$('input[name="check-search"][value="2"]').prop('disabled',true);
					}
					else { 
						$('#searchDate').prop('disabled',true);
						$('input[name="check-search"][value="1"]').prop('disabled',false);
						$('input[name="check-search"][value="2"]').prop('disabled',false);
						var checkMonth = 0;
						var checkYear = 0;
						for (let i=0;i<checkbox.length;i++) {
							if (checkbox[i].value == 1) {
								if (checkbox[i].checked) { $('#searchMonth').prop('disabled',false); }
								else { $('#searchMonth').prop('disabled',true); }
							}
							else if (checkbox[i].value == 2) {
								if (checkbox[i].checked) { $('#searchYear').prop('disabled',false); }
								else { $('#searchYear').prop('disabled',true); }
							}
						}
					}
				break;
				case "4":
					if (this.checked) { $('input[name="searchChannel"]').prop('disabled',false);}
					else { $('input[name="searchChannel').prop('disabled',true); }
				break;
			}
			//Verificar checked
			for (let i=0;i<checkbox.length;i++) {
				if (checkbox[i].checked) {
					check++;
				}
			}
			//Boton Buscar
			if (check > 0) { $('#btnSearch').prop('disabled',false); }
			else { $('#btnSearch').prop('disabled',true); }
		})

		$('#ExportTMC').click(function() {
			exportExcel(1);
		})

		$('#ExportTCE').click(function() {
			exportExcel(2);			
		})

		$('#btnCalendar').click(function() {
			$(".calendar-modal").modal({
        	    show: true,
        	    keyboard: false,
        	    backdrop: false,
        	})
		})

		$('#calendar').fullCalendar({ //Modificado [2024-02-15]
      		header: {
      		  left: 'prev,next today',
      		  center: 'title',
      		  right: 'month,agendaWeek,agendaDay,listWeek',
      		  
      		},
			locale: 'es',
      		defaultDate:new Date(),
      		navLinks: false, // can click day/week names to navigate views
      		editable: true,
      		eventLimit: true, // allow "more" link when too many events
      		events: [
      			<?php  
      		  		foreach ($citas as $value) {echo("{ title:'".$value->title."',start:'".$value->start."',end:'".$value->end."',id:'".$value->id."'},"); }
      			?>
      		],
      		eventDrop:function(event,delta,reverFunc){
          		var id=event.id;
          		var fi=event.start.format();
          		var ff=event.end.format();
          		$.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{
             		id:id,fi:fi,ff:ff},
             		function(data){
              		if(data==1){swal("¡Listo!", "Cita actualizada.", "success");}
              		else{swal("¡Error!", "No se puede actualizar en este momento. Favor de intentarlo más tarde.", "error");}
          		})
        	},
      		eventResize:function(event){
         		var id=event.id;
          		var fi=event.start.format();
          		var ff=event.end.format();
          		$.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{
             		id:id,fi:fi,ff:ff},
             		function(data){ if(data==1){swal("¡Listo!", "Cita actualizada.", "success");}
              		else{swal("¡Error!", "No se puede actualizar en este momento. Favor de intentarlo más tarde.", "error");}
          		})
          	},
      		eventRender: function(event,element){
        		var el=element.html();
        		element.html("<div style='width:90%;'>"+el+"</div><div class='cont-date-delete'><div class='cont-date-icon-delete'><i class='fas fa-times'></i></div></div>");
        		element.find('.cont-date-icon-delete').click(function(){
        			swal({
    				    title: "¿Desea eliminarlo?",
    				    text: "La cita seleccionada se eliminará.",
    				    icon: "warning",
    				    buttons: ["Cancelar", "Aceptar"],
    				}).then((value) => {
      					if (value) {
      						var id=event.id;
                   			$.post(<?php echo('"'.base_url().'crmproyecto/eliminaCita"');  ?>,{id:id},
             					function(data){ 
             						if(data==1){
              							$('#calendar').fullCalendar('removeEvents',event.id);
              							swal("¡Eliminado!", "La cita ha sido eiminada.", "success");}
              						else{swal("¡Vaya!", "Hay conflicto al intentar eliminar.", "error");}
          						}
          					)
      					}
      				})

        		})
      		}
    	});

    	$('#btnProof').click(function() {
    		const fechaBuscar = document.getElementById('searchDate').value;
    		const fechaCalend = document.getElementById('dpCita').value;
    		console.log(fechaBuscar + " | " + fechaCalend);
    		/*$.ajax({
        	    url: `${baseUrl}/getSearch`,
        	    success: (data) => {
        	        const r = JSON.parse(data);
        	        console.log(r);
        	    },
        	    error: (error) => {
        	        console.log(error);
        	    }
        	})*/
    	})
	})

	//------------------------------- FUNCIONES NUEVAS -----------------------------------
	const baseUrl = '<?=base_url()?>callcenter';
	function getTableListClient(month,year,date,channel) { //Modificado [Suemy][2024-04-03]
		$('#TotalResult').html("...");
		$('#btnSearch').prop('disabled',true);
		$('#ExportTMC').prop('disabled',true);
		$('#ExportTCE').prop('disabled',true);
		$('#contTable').css('height','');
		$.ajax({
			type: "GET",
            url: `${baseUrl}/getInfoClient`,
            data: {
            	mn: month,
            	yr: year,
            	dt: date,
            	ch: channel
            },
            beforeSend: (load) => {
            	$('#contTMC').css('height','650px');
            	$("#spinnerTMC").css('position','absolute');
                $('#spinnerTMC').html(`
                   	<div class="container-spinner-content-loading" style="height: 650px;">
                   	    <div class="bd-spinner spinner-border" role="status">
                   	        <span class="visually-hidden"></span>
                   	    </div>
                   	    <p class="bd-cargando" style="font-size:18px;">Cargando...</p>
                   	</div>
                `);
                $('#tableMessagesClient').css('display','none');
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                //console.log(data);
                let cli = r['ListaClientes'];
                let mail = r['mailings'];
                let per = r['personas'];
                let hist = r['historialClientes'];
                let pun = r['puntaje'];
        		let status = [{name:"DIMENSION",value:"NUEVO"}, {name:"SIN VENTA",value:"SINVENTA"}, {name:"CON VENTA",value:"CONVENTA"}, {name:"SIN INTENTO DE CONTACTO",value:"SINCONTACTO"}, {name:"SIN EXITO DE CONTACTO",value:"SINEXITOCONTACTO"}, {name:"CONTACTADO",value:"CONTACTADO"}, {name:"DESCARTADO",value:"DESCARTADO"}, {name:"COTIZADO",value:"COTIZADO"}, {name:"EN PROCESO",value:"ENPROCESO"}, {name:"CIERRE",value:"CIERRE"}];
                readyTableClientExport(channel,cli);
        		var theadTE = ``;
                var trtdTE = ``;
        		var thead = ``;
                var trtd = ``;
                if (cli != 0) {
                	for (const a in cli) {
                		/////////////////////////// CLIENTES //////////////////////////
                		//if (channel != "asesor") {
                			const leads = valor(cli[a].leads);
                			const nombre = valor(cli[a].Nombre) + " " + valor(cli[a].ApellidoP) + " " + valor(cli[a].ApellidoM);
                			var orderLeads = "";
                            var typeDoc = "";
                            var numFlotillas = "";
                			var select1 = `<select class="form-control input-sm" name="campaignEmail" data-cli="${cli[a].IDCli}" onchange="mailClient(this)"><option value="0">-- Seleccionar --</option>`;
                			var select2 = `<select class="form-control input-sm" name="emailUsuario" data-cli="${cli[a].IDCli}" onchange="emailUser(this)"><option value="0">-- Cambiar --</option>`;
                			var historial = " ";
                			var select3 = `<select class="form-control input-sm statusClient" name="statusClient" data-cli="${cli[a].IDCli}" onchange="statusClient(this)">`;
                			var contactado = "";
                			var cotizado = "";
                			var pagado = "";
                			var assigned = ``;
                			var asignado = cli[a].Usuario;
                            var spam = detect_spam(cli[a].observacion);
                            var clase = "";
                            var bg = "";
                            var badge = "";
      						// const cellphone = cli[a].Telefono1.split('(')[0];
                			//Operaciones
                			//->Leads
                			switch(leads){
								default:
									orderLeads	= "";
								break;
								case "http://www.fianzascapital.com.mx":
									orderLeads	= "Fianzas";
                                    var fianza = "";
                                    if (cli[a].tipo_documento == "Seleecione tipo de fianza") { fianza = "---"; }
                                    else { fianza = getCharacter(valor(cli[a].tipo_documento)); }
                                    typeDoc = `<strong>Fianza: </strong>${fianza} <br>`;
								break;
								case "http://www.capitalsegurosgmm.com":
									orderLeads	= "GMM";
								break;
								case "http://capsys.com.mx/client":
									orderLeads	= "Client Crox";
								break;
                                case "https://flotillascapital.com":
                                    var flotillas =cli[a].numeroVehiculos;
                                    numFlotillas  = `<strong>N&uacute;mero de veh&iacute;culos: </strong>${flotillas} <br>`;
                                break;
							}
							if (cli[a].fechaCreacionCA != null) {
								var date = new Date(cli[a].fechaCreacionCA);
								date = "<strong>Fecha: </strong>" + getDateFormat(cli[a].fechaCreacionCA,1) + " <strong>Hora: </strong>" + date.toLocaleTimeString('en-US');
							}
							//->Select1
							for (const b in mail) {
								var selected = "";
								if (cli[a].idMailing == mail[b].idMailing) {
									selected = "selected";
								}
								select1 += `<option value="${mail[b].idMailing}" ${selected}>${mail[b].nombre}</option>`;
							}
							select1 += `</select>`;
							//->Select2
							for (const c in per) {
								var selected = "";
								var usuario = per[c].nombres + " " + per[c].apellidoPaterno + " " + per[c].apellidoMaterno;
								if (cli[a].Usuario == per[c].email) {
									selected = "selected";
									assigned = `<i class="fas fa-check-circle icon-circle-assign"></i><label class="textAssign">Asignado</label>`;
								}
								select2 += `<option value="${per[c].email}" ${selected}>${usuario} (${per[c].email})</option>`;
							}
							select2 += `</select>`;				
							if (cli[a].Usuario == "marketing@agentecapital.com") {
								asignado = "";
							}
							//->Historial
							for (const d in hist) {
								if (cli[a].IDCli == hist[d].IDCli) {
									historial += `<div class="container-note"><p>${hist[d].fecha}</p><p>${hist[d].informacion}</p></div><hr class="history-hr">`;
								}
							}
							//->Select3
							for (i=0;i<status.length;i++) {
								var selected = "";
								if (cli[a].EstadoActual == status[i].name) {selected = "selected";}
								select3 += `<option value="${status[i].name}" ${selected}>${status[i].name}</option>`;
							}
							select3 += `</select>`;
							//->Puntaje
							for (const e in pun) {
								if (cli[a].IDCli == pun[e].IDCli) {
									if (pun[e].contactado > 0) { contactado = "Contactado"; }
									if (pun[e].cotizado > 0) { cotizado = "Cotizado"; }
									if (pun[e].pagado > 0) { contactado = "Pagado"; }
								}
							}
                            //->Spam
                            /*if (spam == true) {
                                clase = "active-spam";
                                bg = `style="background: #fff1f1;"`;
                                badge = `<span class="badge label-danger"><strong><i class="fas fa-ban"></i> </strong>Posible SPAM</span><br>`;
                            }*/
							//Implementación
							trtd += `
								<tr class="mostrar ${clase}" ${bg}>
									<td style="display: none;">${getDateFormat(cli[a].fechaActualizacion,2)}</td>
                  					<td title="${cli[a].IDCli}">
                  						${cli[a].actualiza} <br>
                  						${cli[a].FuenteProspecto} <br>
                  						${orderLeads} <br>
                  						<button class="btn btn-primary" data-cli="${cli[a].IDCli}" id="btnDelete${cli[a].IDCli}" onclick="deleteClient(this)"><i class="fa fa-trash"></i></button>
                  					</td>
                  					<td style="max-width:350px;">${nombre} ${valor(cli[a].RazonSocial)}</td>
                  					<td>
                                        ${badge}
                  						${date} <br>
                  						<strong>Actualizado: </strong>${getDateFormat(cli[a].fechaActualizacion,1)} <br>
                                        ${typeDoc}
                                        ${numFlotillas}
                                        <strong><i class="fas fa-envelope"></i> </strong>${valor(cli[a].EMail1,1)} <br>
                  						<strong><i class="fas fa-phone"></i> </strong>${valor(cli[a].Telefono1,1)} <br>
                  						<hr class="datos-hr">
                  						<div class="container-message">
                  							<i class="fas fa-comments"></i>
                  							<i>${getCharacter(valor(cli[a].observacion))}</i>
                  						</div>
                  					</td>
                  					<td>${select1}
                  						<br>
                  						<div class="column-flex-center-center" id="loadingMail${cli[a].IDCli}" style="padding: 8px 0px;"></div>
                  					</td>
                  					<td>
                  						<input type="text" class="form-control input-sm" value="${cli[a].Usuario.toUpperCase()}" disabled="disabled"/>
                  						${select2}
                  						<br>
                  						<div class="column-flex-center-center" id="loadingAsig${cli[a].IDCli}" style="padding: 8px 0px;">${assigned}</div>
                  					</td>
                  					<td>
                  						<div class="container-history" id="history${cli[a].IDCli}">${historial}</div>
                  						<div align="right">
											<button class="btn btn-primary btn-sm" onclick="openModalNote(${cli[a].IDCli})"><i class="fas fa-sticky-note"></i> Nueva Nota</button> 
                            		    </div>
                  					</td>
                  					<td>
										<p class="store">
											<input type="radio" id="r1-${cli[a].IDCli}" name="stars-${cli[a].IDCli}" value="5" data-cli="${cli[a].IDCli}">
									  		<label for="r1-${cli[a].IDCli}"><i class="fas fa-star icon-star"></i></label>
									  		<input type="radio" id="r2-${cli[a].IDCli}" name="stars-${cli[a].IDCli}" value="4" data-cli="${cli[a].IDCli}">
									  		<label for="r2-${cli[a].IDCli}"><i class="fas fa-star icon-star"></i></label>
									  		<input type="radio" id="r3-${cli[a].IDCli}" name="stars-${cli[a].IDCli}" value="3" data-cli="${cli[a].IDCli}">
									  		<label for="r3-${cli[a].IDCli}"><i class="fas fa-star icon-star"></i></label>
									  		<input type="radio" id="r4-${cli[a].IDCli}" name="stars-${cli[a].IDCli}" value="2" data-cli="${cli[a].IDCli}">
									  		<label for="r4-${cli[a].IDCli}"><i class="fas fa-star icon-star"></i></label>
									  		<input type="radio" id="r5-${cli[a].IDCli}" name="stars-${cli[a].IDCli}" value="1" data-cli="${cli[a].IDCli}">
									  		<label for="r5-${cli[a].IDCli}"><i class="fas fa-star icon-star"></i></label>
										</p>
                  					</td>
                  					<td>
                  						${select3}<br>
                  						<div class="column-flex-center-center" id="loadingStatus${cli[a].IDCli}" style="padding: 8px 0px;"></div>
                  						<p class="status-client">${contactado}</p>
                  						<p class="status-client">${cotizado}</p>
                  						<p class="status-client">${pagado}</p>
                  					</td>
                  				</tr>
							`;

							trtdTE += `
							<tr>
								<td>${getDateFormat(cli[a].fechaActualizacion,2)}</td>
								<td>${orderLeads}</td>
								<td>${cli[a].FuenteProspecto}</td>
								<td>${getDateFormat(cli[a].fechaCreacionCA,2)}</td>
								<td>${nombre}</td>
								<td>${cli[a].Telefono1}</td>
								<td>${valor(cli[a].RazonSocial)}</td>
								<td>${getCharacter(valor(cli[a].observacion))}</td>
								<td>${valor(cli[a].idMailing)}</td>
								<td>${asignado}</td>
								<td>${cli[a].EstadoActual}</td>
							</tr>`;

                		//}
                		//else {
                		/////////////////////////// AGENTES //////////////////////////
                		//}
                	}
            	}
            	else {
            		trtd = `<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`;
            	}

    		    var table = `<table class="table table-striped" id='tableMessagesClient'><thead class="table-thead"><tr class="tr-style"><th style="display: none;">Actualizado</th><th>Origen</th><th>Nombre</th><th>Datos</th><th>Mailing</th><th>Asignado a</th><th>Historial</th><th>Calificacion</th><th>Estado</th></tr></thead><tbody id="bodyTableMessagesClient">${trtd}</tbody></table>`;
    		    var tableExport = `<table class="table table-striped" id='tableMessagesClientR'><thead class="table-thead"><tr class="tr-style"><th>Actualizado</th><th>Landing</th><th>Origen</th><th>Registrado el</th><th>Nombre</th><th>Telefono</th><th>Razon</th><th>Nota</th><th>Mailing</th><th>Asignado a</th><th>Estado</th></tr></thead><tbody id="bodyTableMessagesClientR">${trtdTE}</tbody></table>`;
                $('#contTable').html(table);
            	$('#TotalResult').html(cli.length);
            	$('#conTablesExport').html(tableExport);
				$('#btnSearch').prop('disabled',false);
				if (cli.length > 0){ $('#ExportTMC').prop('disabled',false); }				
				if (cli.length > 0 && channel != "asesor") {
					$('#tableMessagesClient').DataTable({
                        ordering: false,
                    	language: {
                    	    url: `<?=base_url()?>assets/js/espanol.json`
                    	},
                    	columnDefs:[{
                            targets: "_all",
                            sortable: false
                        }],
                	});
  				}
  				else if (cli.length > 0 && channel == "asesor") {
  					$('#tableMessagesClient').DataTable({
                        ordering: false,
                    	language: {
                    	    url: `<?=base_url()?>assets/js/espanol.json`
                    	},
                    	columnDefs:[{
                            targets: "_all",
                            sortable: false
                        }],
                	});
  				}
  				else {$('#contTable').css('height','540px');}
  				setTimeout(function() {
  					$('#contTMC').css('height','');
  				    $("#spinnerTMC").html("");
  				    $("#spinnerTMC").css('position','');
  				    $('#tableMessagesClient').css('display','');
  				},3000);
            },
            error: (error) => {
                console.log(error);
                $('#btnSearch').prop('disabled',false);
                swal("¡Uups!", "Ha ocurrido un problema.", "error");
            }
        })
	}

	function readyTableClientExport(channel,cli) { //Modificado [Suemy][2024-04-03]
		var thead = ``;
		var trtd = ``;
		if (channel == "asesor") {
			thead = `<th colspan="14" align="center">ASESORES</th></tr><tr class="tr-style"><th>Fecha</th><th>Via</th><th>Nombre Prospecto Agente</th><th>Telefono</th><th>Ubicacion</th><th>Correo</th><th>Redes Sociales</th><th>Numero de Cedula</th><th>1era Llamada</th><th>2da Llamada</th><th>Mensaje de WhatsApp</th><th>Consfirmacion de Cita</th><th>Status</th><th>Comentarios</th>`;
		}
		else if (channel == "http://www.capitalsegurosgmm.com") {
			thead = `<th colspan="9" align="center">SEGUROS</th></tr><tr class="tr-style"><th>Fecha</th><th>Ramo</th><th>Nombre</th><th>Correo</th><th>Telefono</th><th>Nota del Lead</th><th>Fecha de Contacto</th><th>Status</th><th>Comentarios</th>`;
		}
		else if (channel == "http://www.fianzascapital.com.mx") {
			thead = `<th colspan="11" align="center">FIANZAS</th></tr><tr class="tr-style"><th>Fecha</th><th>Ramo</th><th>Nombre</th><th>Correo</th><th>Telefono</th><th>Ubicacion</th><th>Nota del Lead</th><th>Tipo de Fianza</th><th>Fecha de Contacto</th><th>Status</th><th>Comentarios</th>`;
		}
		for (const a in cli) {
			var cliente = valor(cli[a].Nombre) + " " + valor(cli[a].ApellidoP) + " " + valor(cli[a].ApellidoM);
			var fecha = getDateFormat(cli[a].fechaActualizacion,2);
			const contactoF = getDateFormat(cli[a].fechacontacto,2);
			if (channel == "asesor") {
				cliente = valor(cli[a].prospecto) + " " + valor(cli[a].apellido_paterno) + " " + valor(cli[a].apellido_materno);
				fecha = getDateFormat(cli[a].fecha,2);
				trtd += `
					<tr>
      					<td>${fecha}</td>
      					<td>Facebook</td>
      					<td>${cliente}</td>
      					<td>${valor(cli[a].numero_telefono)}</td>
      					<td>${valor(cli[a].ubicacion)}</td>
      					<td>${valor(cli[a].correo)}</td>
      					<td></td>
      					<td>${valor(cli[a].tiene_cedula)}</td>
      					<td>1</td>
      					<td>2</td>
      					<td>WhatsApp</td>
      					<td>Cita</td>
      					<td>${valor(cli[a].status)}</td>
      					<td>${valor(cli[a].comentarios)}</td>
      				</tr>`;
			}
			else if (channel == "http://www.capitalsegurosgmm.com") {
				var lead = "GMM";
				if (cli[a].lead == "http://capsys.com.mx/client") {
					lead = "Client Crox";
				}
				trtd += `
					<tr>
      					<td>${fecha}</td>
      					<td>${lead}</td>
      					<td>${cliente}</td>
      					<td>${valor(cli[a].EMail1)}</td>
      					<td>${valor(cli[a].Telefono1)}</td>
      					<td>${getCharacter(valor(cli[a].observacion))}</td>
      					<td>${contactoF}</td>
      					<td>${cli[a].EstadoActual}</td>
      					<td>${valor(cli[a].comentarios)}</td>
      				</tr>`;
			}
			else if (channel == "http://www.fianzascapital.com.mx") {
                var fianza = "";
                if (cli[a].tipo_documento == "Seleecione tipo de fianza") { fianza = "---"; }
                else { fianza = getCharacter(valor(cli[a].tipo_documento)); }
				trtd += `
					<tr class="view-lead">
      					<td>${fecha}</td>
      					<td>FIANZAS</td>
      					<td>${cliente}</td>
      					<td>${valor(cli[a].EMail1)}</td>
      					<td>${valor(cli[a].Telefono1)}</td>
      					<td>${valor(cli[a].CP)}</td>
      					<td>${getCharacter(valor(cli[a].observacion))}</td>
      					<td>${fianza}</td>
      					<td>${contactoF}</td>
      					<td>${cli[a].EstadoActual}</td>
      					<td>${valor(cli[a].comentarios)}</td>
      				</tr>`;
			}
		}
		var table = `<table class="table table-striped" id='tableChannel'><thead class="table-thead"><tr class="tr-style">${thead}</tr></thead><tbody id="bodyTableChannel">${trtd}</tbody></table>`;
		$('#conClientExport').html(table);
		if (cli.length > 0 && channel != 0) { $('#ExportTCE').prop('disabled',false); }
		else { $('#ExportTCE').prop('disabled',true); }		
	}

	function getHistory(cli) {
		$.ajax({
			type: "GET",
            url: `${baseUrl}/getHistoryClient`,
            data: {
            	id: cli
            },
            beforeSend: (load) => {
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                var history = ``;
                for (const a in r) {
                	history += `<div class="container-note"><p>${r[a].fecha}</p><p>${r[a].informacion}</p></div><hr class="history-hr">`;
                }
                $('#history'+cli).html(history);
            },
            error: (error) => {
                //console.log(error);
            }
        })
	}

	function insertClient() {
		const nombre = $('#nombre').val();
		const apellidoP = $('#apellidop').val();
		const apellidoM = $('#apellidom').val();
		const razon = $('#razon').val();
		const mensaje = $('#mensaje').val();
		const rfc = document.getElementById('rfc').value;
		const email = document.getElementById('email').value;
		const celular = document.getElementById('celular').value;
		const tipo = document.getElementById('tipo_cliente').value;
		var ramo = $('#ramo').val();
		if (ramo == 0) {ramo = "";}
		//console.log(ramo, mensaje);
		$.ajax({
			type: "POST",
            url: `${baseUrl}/InsertaDimension`,
            data: {
            	apellidop: apellidoP,
            	apellidom: apellidoM,
            	nombre: nombre,
            	razon: razon,
            	rfc: rfc,
            	email: email,
            	celular: celular,
            	entidad: tipo,
            	ramo: ramo,
            	mensaje: mensaje
            },
            beforeSend: (load) => {
                $('#AddClient').html(`
                   	<div class="bd-spinner spinner-border" role="status">
                   	    <span class="visually-hidden"></span>
                   	</div>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                $('#AddClient').html(`<i class="fas fa-user-plus"></i> Agregar Prospecto`);
                swal("¡Guardado!", "Cliente guardado con éxito.", "success");
                $('#nombre').val("");
                $('#apellidop').val("");
                $('#apellidom').val("");
                $('#razon').val("");
                $('#rfc').val("");
                $('#email').val("");
                $('#celular').val("");
                $('#ramo option[value="0"]').prop('selected',true);
                $('#mensaje').val("");
            },
            error: (error) => {
                //console.log(error);
                $('#AddClient').html(`<i class="fas fa-user-plus"></i> Agregar Prospecto`);
                swal("¡Uups!", "Ha ocurrido un problema al intentar guardar.", "error");
            }
        })
	}

	function saveDate(titulo,fecha,horaI,horaF) {
		$.ajax({
			type: "POST",
            url: `${baseUrl}/guardaCita`,
            data: {
            	tituloCita: titulo,
            	fecCita: fecha,
            	fecIniCita: horaI,
            	fecFinCita: horaF
            },
            beforeSend: (load) => {
                $('#AddDate').html(`
                   	<div class="bd-spinner spinner-border" role="status">
                   	    <span class="visually-hidden"></span>
                   	</div>
                `);
            },
            success: (data) => {
                const r = JSON.parse(data);
                //console.log(r);
                $('#calendar').fullCalendar('render');
                $('#AddDate').html(`Guadar Cita`);
                swal("¡Guardado!", "Cita agendada con éxito.", "success");
                $('#tituloCita').val("");
            },
            error: (error) => {
                //console.log(error);
                $('#AddDate').html(`Guardar Cita`);
                swal("¡Vaya!", "Ha ocurrido un conflicto al intentar guardar.", "error");
            }
        })
	}

	function deleteClient(obj) {
		const cli = $(obj).data('cli');
		swal({
    	    title: "¿Desea eliminarlo?",
    	    text: "El cliente sleccionado se eliminará.",
    	    icon: "warning",
    	    buttons: ["Cancelar", "Aceptar"],
    	}).then((value) => {
      		if (value) {
				$.ajax({
					type: "POST",
        		   	url: `${baseUrl}/eliminaCliente`,
        		   	data: {
        		   		IDCli: cli
        		   	},
        		   	beforeSend: (load) => {
        		   	    $('#btnDelete'+cli).html(`
        		   	    	<div class="container-spinner-btn-loading">
        		   			    <div class="spinner-border" role="status">
        		   			        <span class="visually-hidden"></span>
        		   			    </div>
        		   			</div>
        		   	    `);
        		   	},
        		   	success: (data) => {
        		   	    const r = JSON.parse(data);
        		   	    //console.log(r);
           	    		getHistory(cli);
        		   	    $('#btnDelete'+cli).prop('disabled',true);
        		   	    $('#btnDelete'+cli).html(`Eliminado`);
        		   	    swal("¡Eliminado!", "Cliente eliminado con éxito.", "success");
        		   	},
        		   	error: (error) => {
        			    //console.log(error);
        				$('#btnDelete'+cli).html(`<i class="fa fa-trash"></i>`);
        				swal("¡Vaya!", "Hay conflicto al intentar eliminar.", "error");
        			}
        		})
			}
		})
	}

	function mailClient(obj) {
		const cli = $(obj).data('cli');
		const val = $(obj).val();
		$.ajax({
			type: "POST",
           	url: `${baseUrl}/asignaMailing`,
           	data: {
           		IDCli: cli,
           		campaignEmail: val
           	},
           	beforeSend: (load) => {
           	    $('#loadingMail'+cli).html(`
           	    	<div class="container-spinner-content-loading">
           			    <div class="spinner-border" role="status">
           			        <span class="visually-hidden"></span>
           			    </div>
           			</div>
           	    `);
           	},
           	success: (data) => {
           	    const r = JSON.parse(data);
           	    //console.log(r);
           	    getHistory(cli);
           	    $('#loadingMail'+cli).html(`<i class="fas fa-check-circle icon-circle-check"></i><label class="textCheck">Listo</label>`);
           	},
           	error: (error) => {
        	    //console.log(error);
        		$('#loadingMail'+cli).html(`<i class="fas fa-times-circle icon-circle-close"></i><label class="textError">Error</label>`);
        	}
        })
	}
 
	function emailUser(obj) {
		const cli = $(obj).data('cli');
		const val = obj.value;
		$.ajax({
			type: "POST",
           	url: `${baseUrl}/asignaUsuario`,
           	data: {
           		IDCli: cli,
           		emailUsuario: val
           	},
           	beforeSend: (load) => {
           	    $('#loadingAsig'+cli).html(`
           	    	<div class="container-spinner-content-loading">
           			    <div class="spinner-border" role="status">
           			        <span class="visually-hidden"></span>
           			    </div>
           			</div>
           	    `);
           	},
           	success: (data) => {
           	    const r = JSON.parse(data);
           	    //console.log(r);
           	    getHistory(cli);
           	    $('#loadingAsig'+cli).html(`<i class="fas fa-check-circle icon-circle-check"></i><label class="textCheck">Listo</label>`);
           	},
           	error: (error) => {
        	    //console.log(error);
        		$('#loadingAsig'+cli).html(`<i class="fas fa-times-circle icon-circle-close"></i><label class="textError">Error</label>`);
        	}
        })
	}

	function statusClient(obj) {
		const cli = $(obj).data('cli');
		const val = obj.value;
		$.ajax({
			type: "POST",
           	url: `${baseUrl}/asignaStatus`,
           	data: {
           		IDCli: cli,
           		statusCliente: val
           	},
           	beforeSend: (load) => {
           	    $('#loadingStatus'+cli).html(`
           	    	<div class="container-spinner-content-loading">
           			    <div class="spinner-border" role="status">
           			        <span class="visually-hidden"></span>
           			    </div>
           			</div>
           	    `);
           	},
           	success: (data) => {
           	    const r = JSON.parse(data);
           	    //console.log(r);
           	    getHistory(cli);
           	    $('#loadingStatus'+cli).html(`<i class="fas fa-check-circle icon-circle-check"></i><label class="textCheck">Listo</label>`);
           	},
           	error: (error) => {
        	    //console.log(error);
        		$('#loadingStatus'+cli).html(`<i class="fas fa-times-circle icon-circle-close"></i><label class="textError">Error</label>`);
        	}
        })
	}

	function newNote() {
		const cli = document.getElementById('IDCliModal').value;
		const text = document.getElementById('textNote').value;
		if (text != 0) {
			$.ajax({
				type: "POST",
        	   	url: `${baseUrl}/saveNote`,
        	   	data: {
        	   		id: cli,
        	   		tx: text
        	   	},
        	   	beforeSend: (load) => {
        	   	    $('#btnSaveNote').html(`
        	   	    	<div class="container-spinner-btn-loading">
        	   			    <div class="spinner-border" role="status">
        	   			        <span class="visually-hidden"></span>
        	   			    </div>
        	   			</div>
        	   	    `);
        	   	},
        	   	success: (data) => {
        	   	    const r = JSON.parse(data);
        	   	    //console.log(r);
        	   	    $('#btnSaveNote').html("Guardar");
        	   	    getHistory(cli);
        	   	    swal("¡Guardado!", "Nota guardada con éxito.", "success");
           		},
           		error: (error) => {
        		    //console.log(error);
        	   	    $('#btnSaveNote').html("Guardar");
        			swal("¡Vaya!", "Ha ocurrido un conflicto al intentar guardar.", "error");
        		}
        	})
		}
	}

	function verifyField(type) {
		if (type == 1) {	
			const nombre = $('#nombre').val();
			const apellidoP = $('#apellidop').val();
			const apellidoM = $('apellidom').val();
			const razon = $('#razon').val();
			const rfc = document.getElementById('rfc').value;
			const email = document.getElementById('email').value;
			const celular = document.getElementById('celular').value;
			const tipo = document.getElementById('tipo_cliente').value;
			if (tipo == "Moral") {
				if (razon != 0) {
					insertClient();
				}
				else {swal("¡Espera!", "Parece que el campo Razón esta vacío.", "warning");}
			}
			else if (tipo == "Fisica") {
				if (nombre != 0 && apellidoP != 0 && apellidoM != 0) {
					insertClient();
				}
				else {swal("¡Espera!", "Parace que alguno de estos campos está vacío: Nombre, A. Paterno, A. Materno.", "warning");}
			}
		}
		else if (type == 2) {
			const titulo = document.getElementById('tituloCita').value;
			const fecha = document.getElementById('dpCita').value;
			const horaI = document.getElementById('selFecIniCita').value;
			const horaF = document.getElementById('selFecFinCita').value;
			const fechaS = fecha.replace(/[-]/g, "");
			const horaIS = Number(horaI.replace(":",""));
			const horaFS = Number(horaF.replace(":",""));
			var hoy = new Date();
			hoy = getDateFormat(hoy,4).replace(/[-]/g, "");
			//console.log(fecha, horaI, horaF + " | " + hoy + " | " + fechaS, horaIS, horaFS);
			if (titulo != 0) {
				if (horaIS < horaFS) {
					if (fechaS >= hoy) {
						saveDate(titulo,fecha,horaI,horaF);
					}
					else {swal("¡Espera!", "La fecha seleccionada ya pasó, por favor, escoge una nueva.", "warning");}
				}
				else {
					swal("¡Espera!", "Imposible agendar en esas horas, por favor, seleccione otro horario.", "warning");
				}				
			}
			else {
				swal("¡Espera!", "Parace que no has escrito el título.", "warning");
			}
		}
		else if (type == 3) {
			const check = document.getElementsByName('check-search');
			const radio = document.getElementsByName('searchChannel');
			var month = "";
			var year = "";
			var date = "";
			var channel = "";
			for (let i=0;i<check.length;i++) {
				if (check[i].checked && !check[i].disabled) {
					switch (check[i].value) {
						case "1":
							month = document.getElementById('searchMonth').value;
						break;
						case "2":
							year = document.getElementById('searchYear').value;
						break;
						case "3":
							date = document.getElementById('searchDate').value;
						break;
						case "4":
							for (let i=0;i<radio.length;i++) {
								if (radio[i].checked) {
									switch (radio[i].value) {
										case "1":
											channel = "asesor";
										break;
										case "2":
											channel = "http://www.capitalsegurosgmm.com";
										break;
										case "3":
											channel = "http://www.fianzascapital.com.mx";
										break;
									}
								}
							}
						break;
					}
				}
			}
			console.log("Mes: " + month + " Año: " + year + " Fecha: " + date + " Canal: " + channel);
			getTableListClient(month,year,date,channel);
		}
	}
	//-------------------- Operaciones ---------------------

	function exportExcel(tipo) {
    	var tablaActual = "";
    	var nameTable = "";
    	let refDoc = "";

    	if (tipo == "1") {
    	  	tablaActual = document.querySelector('#tableMessagesClientR');
    	  	nameTable = `Tabla <?=date('Y-m-d H:i:s')?>`;
    	}
    	else if (tipo == "2") {
    		tablaActual = document.querySelector('#tableChannel');
    	  	nameTable = `Leads <?=date('Y-m-d H:i:s')?>`;
    	}

    	let tableExport = new TableExport(tablaActual, {
    	    exportButtons: false, // No queremos botones
    	    filename: nameTable, //Nombre del archivo de Excel
    	    sheetname: nameTable, //Tí­tulo de la hoja
    	});
    	let datos = tableExport.getExportData();
    	//console.log(datos);
    	if (tipo == "1") { //El formato CSV lee bien los datos que contienen string, number y date
    	  	refDoc = datos.tableMessagesClientR.xlsx;
    	}
    	else if (tipo == "2") {
    		refDoc = datos.tableChannel.xlsx;
    	}
    	//console.log(refDoc);
    	tableExport.export2file(refDoc.data,refDoc.mimeType,refDoc.filename,refDoc.fileExtension,refDoc.merges,refDoc.RTL,refDoc.sheetname);
	}

	function openContainer(event) {
    	const icon = $(event).children('i');
      	icon.attr('class', icon.hasClass('fa fa-eye') ? 'fa fa-eye-slash' : icon.attr('data-class'));
      	icon.attr('title', icon.hasClass('fa fa-eye') ? 'Ver' : 'Ocultar');
	}

	function schedule() {
		var option = ``;
		var hour = 8;
		for (i=0;i<12;i++) {
			option += `<option>${hour}:00</option><option>${hour}:30</option>`;
			hour++;
		}
		$('#selFecIniCita').html(option);
		$('#selFecFinCita').html(option);
	}

	function openModalNote(id) {
		$('#textNote').val("");
		$('#IDCliModal').val(id);
		$(".note-modal").modal({
            show: true,
            keyboard: false,
            backdrop: false,
        })
	}

	function insertText() {
		textarea = $('#textNote').val();
		$('#textNote').val(textarea + " Cliente Interesado en Ramo: ");
	}

	function orderArray(array) {
        let compare;
        compare = function(a,b) {
            return (b.comision - a.comision);
        };
        array.sort(compare);
        return array;
    }

    function valor(data,type = null) { //Modificado [Suemy][2024-04-03]
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
            if (type == 1) { data = "---"; }
        }
        return data;
    }

	function getDateFormat(data,format) {
        let namemonth = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        var dateF = "";

        if (data == undefined || data == null || data == "") {
            dateF = "";
        }
        else {
            date = new Date(data);
            if (format == 1) {
            	dateF = date.getDate() + "/" + namemonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 2) {
            	dateF = date.getDate() + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 3) {
            	dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
            }
            else if (format == 4) {
            	dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            }
        }
        return dateF;
    }

    function getCharacter(data) { //Creado [Suemy][2024-04-03]
        if (data != 0) {
            const caracter = detect_character(data);
            if (caracter != true) {
                data = decode_utf8(data);
            }
        }
        return data;
    }

    function decode_utf8(string){ //Creado [Suemy][2024-04-03]
        try {
        return decodeURIComponent(escape(string));
        } catch (e) {
    console.error('Error al decodificar el URI:', e);
    console.log(string);
}
    }

    function detect_character(string) { //Creado [Suemy][2024-04-03]
        let filter = ["+","º","","»","¾","µ","</a>","href","½","‡","¶","á","é","í","ó","ú","Á","É","Í","Ó","Ú"];
        var number = 0;
        var data = false;
        for (let i=0;i<filter.length;i++) {
            if (string.includes(filter[i])) {
                number++;
            }
        }
        if (number > 0) { data = true; }
        return data;
    }

    function detect_spam(string) { //Creado [Suemy][2024-04-03]
        let filter = ["+","º","","»","¾","µ","</a>","href","½","‡","¶","http",".net",".io","www.","/?","bit.ly","your website"];
        var number = 0;
        var data = false;
        for (let i=0;i<filter.length;i++) {
            if (string.includes(filter[i])) {
                number++;
            }
        }
        if (number > 0) {
            data = true;
        }
        return data;
    }
</script>
<?php $this->load->view('footers/footer'); ?>
