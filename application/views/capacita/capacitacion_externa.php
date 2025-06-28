<?php
  	$this->load->view('capacita/menu_capacita');
	$idPersona = $this->tank_auth->get_idPersona();
	$email = $this->tank_auth->get_usermail();
  	//var_dump($person);
  	//print_r($person);
    $permission = 0;
    if ($email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM") { $permission = 1; }
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.css">
<style type="text/css">
	/*ID*/
		#btnRegister {width: 83px;height: 31px;}
		#TableUserEvent {/*height: 100%;*/margin: 0px;}
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
		.container-spinner {width: -webkit-fill-available;height: -webkit-fill-available;/*position: absolute;*/z-index: 2;}
		.container-form {border: 1px solid #ddd;border-radius: 5px;padding: 15px;}
		.container-table {height: 350px;overflow: auto;border: 1px solid #ddd; border-top: none;border-radius: 4px;}
        .container-table-bootstrap {width: 100%;border: 1px solid #ddd;border-radius: 8px;padding: 0px 10px 10px;}
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
   		button.btn-primary {font-size: 14px;}
    	.btn-primary.active, .btn-primary.focus, .btn-primary:active, .btn-primary:focus, .btn-primary:hover, 
    	.open>.dropdown-toggle.btn-primary {
    	  color: #fff;
    	  background-color: #286090;
    	  border-color: #286090;
    	}
    	.btn-primary {color: #fff;background-color: #286090;border-color: #286090;}
    	.btn-view-cont {color: #26418f;font-size: 20px;padding: 2px 6px;outline: none;border: 1px solid #dbdbdb;border-radius: 5px;background: #e9e9e9;transition: 0.3s;}
    	.btn-primary:hover {background: #3e45a1;border-color: transparent;}
    	.btn-view-cont:hover {background: #d1d1d1;}
    	button.btn:active, button.btn-primary:active, button.btn:focus, button.btn-primary:focus, .btn-view-cont:active, .btn-view-cont:focus {outline: none;}
  	/*Tables*/
  		table {font-size: 13px;}
        tbody > tr > td > button, tbody > tr > td > a {font-size: 13px;}
    	.table > thead >.tr-style {background: #5d418b;}
    	.table-thead {position: sticky;top: 0;z-index: 1;}
    	.table-tfoot {position: sticky;bottom: 0px; background-color:#e3e3e3;}
  	/*Texts*/
    	.titleSection {font-size: 18px;color: #362380;margin-bottom: 0px;}
    	.subtitleSection {font-size: 14px;color: #3d3d3d;margin-right: 5px;margin-bottom: 0px;}
    	.text-label {font-size: 14px;color: #3d3d3d;}
    	.control-label {font-size: 12px;color: #6a6a6a;}
    	.form-check-label {font-size: 14px;color: #3d3d3d;margin-left: 3px;}
    /*Input*/
    	input.form-control, textarea.form-control {font-size: 14px;color: #472380;}
  	/*Others*/
    	.pd-left {padding-left: 0px;}
    	.pd-right {padding-right: 0px;}
    	.pd-top {padding-top: 15px;}
    	.pd-bottom {padding-bottom: 15px;}
    	.pd-hour {padding: 0px 5px 0px 10px;}
        .pd-items-table {padding-bottom: 5px;}
    	.title-hr {margin: 10px 0px 10px 0px;border-top: 1px solid #deceeb;}
    	.subtitle-hr {margin: 10px 0px 10px 0px;border-top: 1px solid #dbdbdb;}
    	.brd-right {border-right: 1px solid #dbdbdb;}
    	.mg-right {margin-right: 5px;}
    	.mg-bottom {margin-bottom: 5px;}
        .mg-cero {margin: 0px;}
        .mg-top-cero {margin-top: 0px;}
    	.pd-side {padding-left: 5px;padding-right: 5px;}
    	.show {visibility: visible;}
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
    	/* Radio */
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
    /*BootstrapTable*/
        /*-->Table Style*/
        .bootstrap-table.bootstrap4 .table-bordered>tbody>tr>td, .bootstrap-table.bootstrap4 .table-bordered>tbody>tr>th, .bootstrap-table.bootstrap4 .table-bordered>tfoot>tr>td, .bootstrap-table.bootstrap4 .table-bordered>tfoot>tr>th, .bootstrap-table.bootstrap4 .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {border: none;border-top: 1px solid #ddd;}
        .bootstrap-table .fixed-table-toolbar .columns label {display: flex;align-items: center;padding: 3px 15px;transition: 0.3s;}
        .dropdown-item.dropdown-item-marker > input[type='checkbox'] {width: 16px;height: 16px;vertical-align: top;background-color: #fff;background-repeat: no-repeat;background-position: center;background-size: contain;
            border: 1px solid rgba(0,0,0,.25);-webkit-appearance: none;-moz-appearance: none;appearance: none;-webkit-print-color-adjust: exact;color-adjust: exact;print-color-adjust: exact;position: inherit;border-radius: .3em;cursor: pointer;margin: 0px 5px 0px 0px;outline: 0;}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:active {filter:brightness(90%);}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:focus {border-color:#86b7fe;outline:0;box-shadow:0 0 0 .25rem rgba(13,110,253,.25);}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:disabled {pointer-events: none;filter: none;opacity: .5;}
        .dropdown-item.dropdown-item-marker > input[type='checkbox']:checked {background-color: #0d6efd;border-color: #0d6efd;background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");}
        .dropdown-item.dropdown-item-marker:focus, .dropdown-item.dropdown-item-marker:hover {background-color: #b1cafd;color: black;}
        /*-->Botones superiores*/
            /* Export -> data-show-export="true" | Select Column -> data-show-columns="true" | Hide/Show Pagination -> data-show-pagination-switch="true" | Refresh -> data-show-refresh="true" | Show Card View -> data-show-toggle="true" | Search Select Column -> data-show-columns-search="true" */
        .keep-open.btn-group > .dropdown-menu > .dropdown-item,
        .export.btn-group > .dropdown-menu > .dropdown-item {font-size: 13px;}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary,
        .keep-open.btn-group > .btn.btn-secondary,
        .export.btn-group > .btn.btn-secondary,
        .btn-group.dropdown.dropup > .btn.btn-secondary,
        .input-group-append > .btn.btn-secondary {background: #286090;border-color: #286090;color: white;height: 34px;display: flex;align-items: center}
        .keep-open.btn-group > .btn.btn-secondary > i,
        .export.btn-group > .btn.btn-secondary > i,
        .btn-group.dropdown.dropup > .btn.btn-secondary > span:nth-child(1) {margin-right: 3px;}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:focus,
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:active,
        .keep-open.btn-group > .btn.btn-secondary:focus,
        .keep-open.btn-group > .btn.btn-secondary:active,
        .export.btn-group > .btn.btn-secondary:focus,
        .export.btn-group > .btn.btn-secondary:active,
        .btn-group.dropdown.dropup > .btn.btn-secondary:focus,
        .btn-group.dropdown.dropup > .btn.btn-secondary:active,
        .input-group-append > .btn.btn-secondary:focus,
        .input-group-append > .btn.btn-secondary:active {color: #fff;background-color: #284790;border-color: #284790;outline: 0;box-shadow: 0 0 0 0.2rem rgb(0 78 146 / 50%);}
        .columns.columns-right.btn-group.float-right > .btn.btn-secondary:hover, .keep-open.btn-group > .btn.btn-secondary:hover,
        .export.btn-group > .btn.btn-secondary:hover, .input-group-append > .btn.btn-secondary:hover {color: #fff;background-color: #287F8F;border-color: #287F8F;}
        .btn-group.open .btn.btn-secondary {}
        .btn-secondary:not(:disabled):not(.disabled).active:focus, .btn-secondary:not(:disabled):not(.disabled):active:focus, .show>.btn-secondary.btn.btn-secondary:focus {box-shadow: 0 0 0 0.2rem rgb(0 105 213 / 50%);}
        .dropdown-toggle::after, .dropup .dropdown-toggle::after {content: none;}
        .btn-group>.btn-group:not(:last-child)>.btn, .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {border-radius: 6px 0px 0px 6px;}
        .btn-group>.btn-group:not(:first-child)>.btn, .btn-group>.btn:not(:first-child) {border-radius: 0px 6px 6px 0px;}
        /*-->Search*/ /*data-search="true"*/
        .float-right.search.btn-group > .form-control.search-input, label.dropdown-item.dropdown-item-marker 
        > input {border-radius: 6px;}
        .float-right.search.btn-group > .input-group > .form-control.search-input {height: 34px;border-radius: 6px 0px 0px 6px;}
        .input-group .form-control:first-child, .input-group-addon:first-child, .input-group-btn:first-child>.btn, .input-group-btn:first-child>.btn-group>.btn, .input-group-btn:first-child>.dropdown-toggle, .input-group-btn:last-child>.btn-group:not(:last-child)>.btn, .input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle) {border-radius: 6px 0px 0px 6px;}
        .input-group>.input-group-append > .btn, .input-group > .input-group-append > .input-group-text, .input-group > .input-group-prepend:first-child > .btn:not(:first-child), .input-group > .input-group-prepend:first-child > .input-group-text:not(:first-child), .input-group > .input-group-prepend:not(:first-child) > .btn, .input-group>.input-group-prepend:not(:first-child) > .input-group-text {border-radius: 0px 6px 6px 0px;}
        /*-->Fullscreen*/ /*data-show-fullscreen="true"*/
        .bootstrap-table.bootstrap4.fullscreen {padding: 15px;}
        /*-->Pagination*/ /*data-pagination="true"*/
        .btn-group.dropdown.dropup.show > .dropup.dropdown-menu.show, .btn-group.dropdown.dropup.show > .dropdown.dropdown-menu.show {bottom: auto;}
        .dropup .dropdown-menu, .navbar-fixed-bottom .dropdown .dropdown-menu {bottom: auto;}
        .show {display: inline-block !important;}
        .fixed-table-pagination {border: 1px solid #dddddd6b;border-top: none;border-radius: 0px 0px 5px 5px;padding: 0px 15px;background: white;color: #3d3d3d;font-size: 13px;}
        .pagination > li.page-item.page-pre > a.page-link {background: white;color: black;font: icon;border: 1px solid #ddd;border-radius: 4px 0px 0px 4px;}
        .pagination > li.page-item.page-next > a.page-link {background: white;color: black;font: icon;border: 1px solid #ddd;border-radius: 0px 4px 4px 0px;}
        .pagination > li.page-item > a.page-link {background: white;color: #286090;border: 1px solid #ddd;height: 34px;}
        .pagination > li.page-item > a.page-link:hover {background: #e3f2ff;color: #3d3d3d;border-color: #C7E5FF;}
        .pagination > li.page-item.active > a.page-link {background-color: #286090;border-color: #286090;color: white;}
</style>

<div class="container" style="margin-right: 0px;">
	<div class="col-md-12" style="padding: 15px;">
		<div class="col-md-12 column-flex-center-start pd-left pd-right">
			<h1 class="mg-right" style="font-size: 20px"><i class="fas fa-university"></i> Registrar Capacitación Externa</h1>
			<button class="btn-view-cont" data-toggle="collapse" href="#segAlertInfo" aria-expanded="true">
          		<i class="fas fa-info-circle"></i>
        	</button>
		</div>
		<div class="col-md-12 pd-left pd-right"><hr class="title-hr"></div>
		<div class="col-md-12">
			<div class="col-md-12 collapse pd-bottom" id="segAlertInfo">
                <div class="alert alert-primary" role="alert" style="margin: 0px;">
                    <h4 style="font-size: 16px;"><i class="fas fa-exclamation-circle"></i> Información</h4>
                    <p style="font-size: 14px;">En este apartado podrás guardar tus registros de las capacitaciones externas que tomes. Debes llenar todos los campos para que pueda guardar la información.</p>
                </div>
            </div>
		</div>
		<div class="col-md-12 container-form" id="eventRegister" style="margin-bottom: 40px;">
			<div class="col-md-12 pd-items-table">
				<div class="col-md-6 pd-left">
					<label class="text-label">Nombre Completo:</label>
					<input type="text" class="form-control register" id="nameUser" title="Nombre Completo" value="<?=$nameUser?>"><br>
					<label class="text-label">Nombre de la Capacitación:</label>
					<input type="text" class="form-control register" id="nameEvent" title="Nombre de la Capacitación"><br>
					<label class="text-label">Tema:</label>
					<input type="text" class="form-control register" id="themeEvent" title="Tema" value="Ninguno"><br>
					<label class="text-label">Descripción:</label>
					<textarea type="text" class="form-control register" id="description" title="Descripción" placeholder="Describe brevemente lo que más te agradó de la capacitación" maxlength="400" style="height: 61px;"></textarea>
					<label class="control-label" style="margin: 0px;">
            	        Caracteres ingresados: <span id="caracteres">0</span> de 400
            	    </label>
					<input type="text" class="form-control register hidden" id="typeUser" title="Tipo Persona" value="<?=$typeUser?>">
				</div>
				<div class="col-md-6 pd-right">
					<label class="text-label">Correo electrónico:</label>
                    <?php 
                    $usermail = $this->tank_auth->get_usermail();
                    if($usermail!="EJECUTIVO@ASESORESCAPITAL.COM"){?>
					<input type="text" class="form-control register" id="emailUser" title="Correo" value="<?=$email?>" disabled><br>
                    <?php }else{?>
                    <select id="emailUserSelect" class="form-control register" onchange="cambiarNombreAgente()">
                        <option data-id="<?=$idPersona?>" data-value="<?=$nameUser?>" data-type="<?=$typeUser?>"><?=$email?></option>
                            <? foreach ($emailAgentes as $row){ ?>
                            <option data-id="<?= ($row->idPersona ) ?>" data-value="<?= ($row->name)?>" data-type="Agente"><?= ($row->username) ?></option>
                        <? } ?>
                    </select><br> 
                    <?php } ?>					
                    <label class="text-label">Nombre de la Compañía (Aseguradora, Afianzadora, COPARMEX o cualquier otro):</label>
					<input type="text" class="form-control register" id="nameCompany" title="Nombre de la Compañía"><br>
					<label class="text-label">Fecha de la Capacitación:</label>
					<input type="date" class="form-control register" id="dateEvent" title="Fecha" value="<?=date('Y-m-d')?>">
                    <input style="visibility:hidden;" type="text" class="form-control register" id="idPersona" title="id" value="<?=$idPersona?>" disabled>					<label class="text-label">Duración (Tiempo de Capacitación):</label>
					<div class="column-flex-center-start" style="padding: 3px 10px 5px;">
						<label class="subtitleSection">Por:</label>
            	    	<div class="form-check column-flex-center-center">
            	    	  <input type="radio" class="form-check-input" name="radio-hour" value="1" checked>
            	    	  <label class="form-check-label">Hora Inicio y Hora Final</label>
            	    	</div>
            	    	<div class="form-check column-flex-center-center">
            	    	  <input type="radio" class="form-check-input" name="radio-hour" value="2">
            	    	  <label class="form-check-label">Cantidad de Horas</label>
            	    	  </div>
					</div>
					<div class="column-flex-center-start" id="contHIHF">
						<label class="text-label pd-hour">De:</label>
						<input type="time" class="form-control register" id="startHour" title="Hora Inicio">
						<label class="text-label pd-hour">A:</label>
						<input type="time" class="form-control register" id="finalHour" title="Hora Final" value="<?=date("H:i")?>">
					</div>
					<div class="column-flex-center-start" id="contHour" style="display: none;">
						<input type="number" class="form-control" id="hours" title="Horas">
					</div>
				</div>
			</div>
			<div class="col-md-12 column-flex-center-end">
				<button class="btn btn-primary" id="btnRegister" onclick="saveEventRegister()"><i class="fas fa-save"></i> Guardar</button>
			</div>
		</div>
		<div class="col-md-12 column-flex-center-start pd-left pd-right">
			<h1 class="mg-right" style="font-size: 20px"><i class="fas fa-graduation-cap"></i> Tus Capacitaciones Externas</h1>
		</div>
		<div class="col-md-12 pd-left pd-right"><hr class="title-hr"></div>
		<div class="col-md-12" style="margin-bottom: 40px;">
			<div class="container-table">
				<table class="table table-striped" id="TableUserEvent">
					<thead class="table-thead">
						<tr class="tr-style">
							<th>Capacitación</th>
							<th>Tema</th>
							<th>Empresa</th>
							<th>Fecha Capacitación</th>
							<th>Hora Inicio</th>
							<th>Hora Final</th>
							<th>Duración de Capacitación</th>
							<th>Registrado el</th>
						</tr>
					</thead>
					<tbody id="bodyTableUserEvent"></tbody>
				</table>
			</div>
		</div>
        <? if ($permission == 1) { ?>
        <div class="col-md-12 column-flex-center-start pd-left pd-right">
            <h1 class="mg-right" style="font-size: 20px"><i class="fas fa-graduation-cap"></i> Capacitaciones Externas</h1>
        </div>
        <div class="col-md-12 pd-left pd-right"><hr class="title-hr"></div>
        <div class="col-md-12">
            <div class="container-table-bootstrap" id="contTableExternalUserEvent"></div>
        </div>
        <? } ?>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.28.0/libs/jsPDF/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/bootstrap-table-locale-all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.4/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		contador("#description","#caracteres");
		getTableExternalEvent();
        <? if ($permission == 1) { ?>
        getTableExternalUserEvent();
        <? } ?>

		$('input[name="radio-hour"]').click(function() {
      		if (this.value == 1) {
        		$('#contHIHF').css('display','');
        		$('#contHour').css('display','none');
        		$('#startHour').addClass('register');
        		$('#finalHour').addClass('register');
        		$('#hours').removeClass('register');
      		}
      		else if (this.value == 2) {
        		$('#contHIHF').css('display','none');
        		$('#contHour').css('display','');
        		$('#startHour').removeClass('register');
        		$('#finalHour').removeClass('register');
        		$('#hours').addClass('register');
      		}
    	})
	})

	const baseUrl = '<?=base_url()?>capacita';

	function getTableExternalEvent() {
		$.ajax({
			type: "GET",
           	url: `${baseUrl}/tablaCapacitacionExterna`,
           	beforeSend: (load) => {
           	    $('#bodyTableUserEvent').html(`
        		    <tr>
        		        <td colspan="8">
        		            <div class="container-spinner-content-loading">
        		                <div class="cr-spinner spinner-border" role="status">
        		                    <span class="visually-hidden"></span>
        		                </div>
        		                <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
        		            </div>
        		        </td>
        		    </tr>
        		`);
           	},
           	success: (data) => {
           	    const r = JSON.parse(data);
           	    console.log(r);
           	    var trtd = ``;
           	    if (r != 0) {
           	    	for (const c in r) {
           	    		trtd += `
           	    			<tr>
           	    				<td>${r[c].title}</td>
           	    				<td>${r[c].theme}</td>
           	    				<td>${r[c].company}</td>
           	    				<td>${getDateFormat(r[c].date,5)}</td>
           	    				<td>${r[c].start_hour}</td>
           	    				<td>${r[c].final_hour}</td>
           	    				<td>${getTimeByHour(r[c].duration)}</td>
           	    				<td>${getDateFormat(r[c].registration_date,1)}</td>
           	    			</tr>
           	    		`;
           	    	}
           	    }
           	    else {
           	    	trtd = `<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`;
           	    }
           	    $('#bodyTableUserEvent').html(trtd);
           	},
           	error: (error) => {
           	    console.log(error);
           	    $('#bodyTableUserEvent').html(`<tr><td colspan="8"><center><strong>Sin resultados</strong><center></td></tr>`);
           	}
        })
	}

    function getTableExternalUserEvent() {
        $.ajax({
            type: "GET",
            url: `${baseUrl}/tablaCapacitacionesExternas`,
            beforeSend: (load) => {
            },
            success: (data) => {
                const r = JSON.parse(data);
                console.log(r);
                let json = [];
                var thead = `
                    <tr class="tr-style">
                        <th>Capacitación</th>
                        <th>Tema</th>
                        <th>Empresa</th>
                        <th>Fecha Capacitación</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>
                        <th>Duración de Capacitación</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Email</th>
                        <th>Registrado el</th>
                        <th>Eliminar</th>
                    </tr>
                `;

                for (const c in r) {
                    let add = {};
                    add[0] = r[c].title;
                    add[1] = r[c].theme;
                    add[2] = r[c].company;
                    add[3] = getDateFormat(r[c].date,5);
                    add[4] = r[c].start_hour;
                    add[5] = r[c].final_hour;
                    add[6] = getTimeByHour(r[c].duration);
                    add[7] = getTextValue(r[c].apellidoPaterno).trim() + " " + getTextValue(r[c].apellidoMaterno).trim() + " " + getTextValue(r[c].nombres).trim();
                    add[8] = r[c].typeUser;
                    add[9] = r[c].email;
                    add[10] = getDateFormat(r[c].registration_date,1);
                    add[11] = `<button class='btn btn-primary' onclick='deleteExternalEvent(${r[c].id})' style='font-size:13px;'><i class="fas fa-trash-alt"></i> Eliminar</button>`;
                    json.push(add);
                }

                getTableBootstrap("contTableExternalUserEvent","TableExternalUserEvent",thead,json,`Cap_Ext <?=date('Y-m-d H:i:s')?>`)
            },
            error: (error) => {
                console.log(error);
            }
        })
    }

    function saveEventRegister() {
        let form = document.getElementById('eventRegister');
        let input = form.getElementsByClassName('register');
        let values = [];
        var empty = "";
        //console.log(input);
        for (let i=0;i<input.length;i++) {
            if (input[i].value != 0) {
                values.push(input[i].value);
                //console.log(values[values.length - 1]);
            }
            else {
                if (empty != 0) { empty = empty + ", "; }
                empty = empty + input[i].title;
            }
        }
        //console.log(values);
        //console.log(empty);
        if (empty != 0) {
            swal("¡Espera!", "Los siguientes campos están vacíos: " + empty + ".", "warning"); 
        }
        else {
            //Se platicó sobre las enfermedades comunes que surgen en nuestro entorno y también en cómo podemos prevenirlo. Se hizo énfasis en las enfermedades que transmiten los mosquitos, como el dengue y la chikunguya.
            $.ajax({
                type: "POST",
                url: `${baseUrl}/guardarCapacitacionExterna`,
                data: {
                    info: values 
                },
                beforeSend: (load) => {
                    $('#btnRegister').html(`
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
                    $('#btnRegister').html(`<i class="fas fa-save"></i> Guardar`);
                    if (typeof(r['result'] == "string")) {
                        swal("¡Guardado!", "Registro realizado con éxito.", "success");
                        getTableExternalEvent();
                        <? if ($permission == 1) { ?>
                        getTableExternalUserEvent();
                        <? } ?>
                    }
                    else {
                        swal("¡Vaya!", "Hay incovenientes al intentar guardar la información.", "error");
                    }
                },
                error: (error) => {
                    console.log(error);
                    $('#btnRegister').html(`<i class="fas fa-save"></i> Guardar`);
                    swal("¡Uups!", "Ha ocurrido un problema al intentar guardar.", "error");
                }
            })
        }
    }

    function deleteExternalEvent(id) {
        swal({
            title: "¿Seguro que desea eliminarlo?",
            text: "La capacitación registrada será eliminada completamente.",
            icon: "warning",
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                $.ajax({
                    type: "POST",
                    url: `${baseUrl}/eliminarCapacitacionExterna`,
                    data: {
                        id: id
                    },
                    beforeSend: (load) => {
                    },
                    success: (data) => {
                        const r = JSON.parse(data);
                        //console.log(r);
                        if (r['status'] == true) {
                            swal("¡Hecho!", "La capacitación se eliminó con éxito.", "success");
                            getTableExternalUserEvent();
                            getTableExternalEvent();
                        }
                        else {
                            swal("¡Uups!", "Existen conflictos al intentar eliminar la información.", "error");
                        }
                    },
                    error: (error) => {
                        console.log(error);
                        swal("¡Vaya!", "Hay problemas al intentar eliminar la información.", "error");
                    }
                })
            }
        })
    }

    function getTableBootstrap(container,table,thead,jsonData,file) {
        $('#'+container).html(`<table class="table table-striped" id="${table}" data-show-columns="true" data-show-pagination-switch="true" data-show-search-clear-button="true" data-page-list="[5, 10, 25, 50, 100, all]"><thead>${thead}</thead></table>`);
        //console.log(jsonData);

        $('#'+table).bootstrapTable({
            data: jsonData,
            height: 450,
            pagination: true,
            pageSize: 5,
            search: true,
            cache: false,
            locale: 'es-MX',
            showExport: true,
            exportTypes: ['doc', 'pdf', 'excel'],
            exportOptions: {
                fileName: function () {
                    return file
                }
            }
        });
    }

	//----------------------------------------- OPERACIONES -----------------------------------------

    function contador(textarea, caracteres){
        function update_contador(textarea, caracteres){
            var contador = $(caracteres);
            var ta = $(textarea);   
            contador.html(ta.val().length);
        }
        $(textarea).keyup(function(){
            update_contador(textarea,caracteres);
        });
        $(textarea).change(function(){
            update_contador(textarea,caracteres);
        });
    }

    function getTimeByHour(time) {
    	if (time.includes('.')) { time = time + "0"; }
        var hour = 0;
        var minutes = time.split('.');
        hour = minutes[0] + " hora";
        if (minutes[0] == 0 || minutes[0] > 1) { hour += "s"; }
        if (minutes[1] > 0) {
            minutes = (60 * Number(minutes[1])) / 100;
            hour += ` con ${minutes} minutos`;
        }
        return hour;
    }

    function getTextValue(data) {
        if (data == "[object Object]" || data == undefined || data == null || data == "") {
            data = "";
        }
        return data;
    }

	function getDateFormat(data,format) {
        let nameM = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
        let numbermonth = new Array ("01","02","03","04","05","06","07","08","09","10","11","12");
        let nameD = new Array("Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb");
        let numberday = new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
        let monthname = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        let dayname = new Array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");

        var dateF = "";

        if (data == undefined || data == null || data == 0 || data == "") {
            dateF = "";
        }
        else {
        	if (!data.includes(':')) { data = data + " 00:00:00";}
            date = new Date(data);
            if (format == 1) {
            	dateF = date.getDate() + "/" + nameM[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 2) {
            	dateF = date.getDate() + "/" + numbermonth[date.getMonth()] + "/" + date.getFullYear();
            }
            else if (format == 3) {
                //fecha.replace(/[-]/g, "/"); //Reemplaza todas "-" por "/"
            	dateF = date.getFullYear() + "/" + numbermonth[date.getMonth()] + "/" + date.getDate();
            }
            else if (format == 4) {
            	dateF = date.getFullYear() + "-" + numbermonth[date.getMonth()] + "-" + numberday[date.getDate()];
            }
            else if (format == 5) {
                dateF = dayname[date.getDay()] + " " + numberday[date.getDate()] + " de " + monthname[date.getMonth()] + " del " + date.getFullYear();
            }
        }
        return dateF;
    }
//---------
    function cambiarNombreAgente(){
    select = document.getElementById("emailUserSelect");
    nombre = select.options[select.selectedIndex].dataset.value;
    inputName = document.getElementById("nameUser");
    inputName.value = nombre;
    idPersona = select.options[select.selectedIndex].dataset.id;
    id = document.getElementById("idPersona");
    id.value=idPersona;
    tipoUsuario = select.options[select.selectedIndex].dataset.type;
    typeUser = document.getElementById("typeUser");
    typeUser.value=tipoUsuario;
    
    }
</script>