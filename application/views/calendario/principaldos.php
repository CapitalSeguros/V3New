<?php 
	$this->load->view('headers/header'); 
?>
<!-- Navbar -->


<link rel="stylesheet" href="<?php echo site_url('assets/js/plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/js/plugins/bootstrap-colorpicker-master/css/bootstrap-colorpicker.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/ladda-themeless.min.css'); ?>" />			
<link rel="stylesheet" href="<?php echo site_url('assets/js/fullcalendar/fullcalendar.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/dist/ladda-themeless.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/js/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/calendar.cenis.css'); ?>" />
<link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.fileupload.css'); ?>" />

<style>
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5A55A3;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5A55A3;
  background-image: #5A55A3;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5A55A3;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
/*Forms setup*/
.form-control {
    border-radius:0;
    box-shadow:none;
    height:auto;
}
.float-label{
    font-size:10px;
}
.table>tbody>tr>td.pleft{
	padding-left: 20px;
}
input[type="text"].form-control,
input[type="search"].form-control{
    border:none;
    border-bottom:1px dotted #CFCFCF;
}
textarea {
    border:1px dotted #CFCFCF!important;
    height:130px!important;
}
/*Content Container*/
.content-container {
    background-color:#fff;
    padding:35px 20px;
    margin-bottom:20px;
}
h1.content-title{
    font-size:32px;
    font-weight:300;
    text-align:center;
    margin-top:0;
    margin-bottom:20px;
    font-family: 'Open Sans', sans-serif!important;
}
/*Compose*/
.btn-send{
    text-align:center;
    margin-top:20px;
}
/*mail list*/
.mail-search{
    border-bottom-color:#7FBCC9!important; 
}

.cargando {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                url('http://i.stack.imgur.com/FhHRx.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .cargando {
    display: block;
    z-index: 999999999;
}
</style>

<section class="container-fluid">
	<div class="panel panel-default">
            <div class="panel-body">
				<div class="row">
					<div class="col-sm-12 col-md-12" align="right">
						<!-- -->
						<div id='calendar'></div>
					</div>
					<div class="col-sm-12 col-md-12" align="right">
						<!-- -->
					</div>            
				</div>
			</div>
	 </div>
</section>
<!-- modal para crear evento -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" <?php #data-dismiss="modal"?> aria-hidden="true">x</button>
				<h5 class="modal-title" id="myModalLabel"></h5>
			</div>
			<div style="margin: 2px 20px 0px 4px; float: right; display: none;" id="cancel-block">
				<input type="hidden" value="<?php if(isset($email_organizer) && !empty($email_organizer)){ echo $email_organizer; }else{ echo ''; } ?>" class="email-organizer">
				<input type="hidden" value="<?php if(isset($json_ical) && !empty($json_ical)){ echo htmlentities($json_ical); }else{ echo '{}'; } ?>" class="json-event-for-email">
				<input type="hidden" value="false" class="for-organizer-email">
				<button type="button" class="btn btn-danger btn-xs ladda-button" data-style="expand-left" data-event-id="4421" id="cancel-link"><span class="ladda-label">Cancelar este evento - (Organizador)</span></button>
			</div>
			<div style="margin: 2px 20px 0px 4px; float: right; display: none;" id="remove-block">
				<button type="button" class="btn btn-danger btn-xs ladda-button" data-style="expand-left" data-event-id="4421" id="remove-link"><span class="ladda-label">Eliminar este evento</span></button>
			</div>
			<div style="clear: both"></div>
			<form role="form" id="eventForm" class="form-horizontal">
				<div class="modal-body" style="padding-top: 10px">
					<fieldset>
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="form-group">
									<div class=" col-sm-12 col-md-12 col-xs-12">
										<label for="title" class="col-sm-2 col-md-2 col-xs-2 control-label">T&iacute;tulo</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="title" name="title" placeholder="Titulo evento">
										</div>
									</div>
								</div>
								<div class="form-group">									
									<div class=" col-sm-9 col-md-9 ">
										<label for="start-date" class="col-sm-3 col-md-3 col-xs-3 control-label">Inicio</label>
										<div class="input-group date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="start" data-link-format="yyyy-mm-dd">
											<input type="text" class="form-control" id="start-date" name="start-date" placeholder="Fecha inicial" readonly="readonly" style="background-color: white; cursor: default;">
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>																		
									<div class="col-sm-3 col-md-3 col-xs-3">
										<input type="text" name="start-time" id="start-time" class="form-control" readonly="readonly" style="background-color: white; cursor: default;">
										<div class="time-panel" id="time-panel-start">
											<ul class="time-panel-ul">
												<!-- <li data-value="00:00">00:00 AM</li>
												<li data-value="00:30">00:30 AM</li>
												<li data-value="01:00">01:00 AM</li>
												<li data-value="01:30">01:30 AM</li>
												<li data-value="02:00">02:00 AM</li>
												<li data-value="02:30">02:30 AM</li>
												<li data-value="03:00">03:00 AM</li>
												<li data-value="03:30">03:30 AM</li>
												<li data-value="04:00">04:00 AM</li>
												<li data-value="04:30">04:30 AM</li>
												<li data-value="05:00">05:00 AM</li>
												<li data-value="05:30">05:30 AM</li>
												<li data-value="06:00">06:00 AM</li>
												<li data-value="06:30">06:30 AM</li>
												<li data-value="07:00">07:00 AM</li>
												<li data-value="07:30">07:30 AM</li> -->
												<li data-value="08:00">08:00 AM</li>
												<li data-value="08:30">08:30 AM</li>
												<li data-value="09:00">09:00 AM</li>
												<li data-value="09:30">09:30 AM</li>
												<li data-value="10:00">10:00 AM</li>
												<li data-value="10:30">10:30 AM</li>
												<li data-value="11:00">11:00 AM</li>
												<li data-value="11:30">11:30 AM</li>
												<li data-value="12:00">12:00 PM</li>
												<li data-value="12:30">12:30 PM</li>
												<li data-value="13:00">01:00 PM</li>
												<li data-value="13:30">01:30 PM</li>
												<li data-value="14:00">02:00 PM</li>
												<li data-value="14:30">02:30 PM</li>
												<li data-value="15:00">03:00 PM</li>
												<li data-value="15:30">03:30 PM</li>
												<li data-value="16:00">04:00 PM</li>
												<li data-value="16:30">04:30 PM</li>
												<li data-value="17:00">05:00 PM</li>
												<li data-value="17:30">05:30 PM</li>
												<li data-value="18:00">06:00 PM</li>
												<li data-value="18:30">06:30 PM</li>
												<li data-value="19:00">07:00 PM</li>
												<li data-value="19:30">07:30 PM</li>
												<li data-value="20:00">08:00 PM</li>
									<!-- 			<li data-value="20:30">08:30 PM</li>
												<li data-value="21:00">09:00 PM</li>
												<li data-value="21:30">09:30 PM</li>
												<li data-value="22:00">10:00 PM</li>
												<li data-value="22:30">10:30 PM</li>
												<li data-value="23:00">11:00 PM</li>
												<li data-value="23:30">11:30 PM</li> -->
											</ul>
										</div>
									</div>
								</div>
								
								<div class="form-group" id="end-group">
									<div class="col-sm-9 col-md-9 ">
										<label for="end" class="col-sm-3 col-md-3 col-xs-3 control-label">Final</label>
										<div class="input-group form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="end" data-link-format="yyyy-mm-dd">
											<input type="text" class="form-control" placeholder="Fecha final" name="end-date" id="end-date" readonly="readonly" style="background-color: white; cursor: default;">
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<div class="col-sm-3 col-md-3 col-xs-3">
										<input type="text" name="end-time" id="end-time" class="form-control" readonly="readonly" style="background-color: white; cursor: default;">
										<div class="time-panel" id="time-panel-end">
											<ul class="time-panel-ul">
												<!-- <li data-value="00:00">00:00 AM</li>
												<li data-value="00:30">00:30 AM</li>
												<li data-value="01:00">01:00 AM</li>
												<li data-value="01:30">01:30 AM</li>
												<li data-value="02:00">02:00 AM</li>
												<li data-value="02:30">02:30 AM</li>
												<li data-value="03:00">03:00 AM</li>
												<li data-value="03:30">03:30 AM</li>
												<li data-value="04:00">04:00 AM</li>
												<li data-value="04:30">04:30 AM</li>
												<li data-value="05:00">05:00 AM</li>
												<li data-value="05:30">05:30 AM</li>
												<li data-value="06:00">06:00 AM</li>
												<li data-value="06:30">06:30 AM</li>
												<li data-value="07:00">07:00 AM</li>
												<li data-value="07:30">07:30 AM</li> -->
												<li data-value="08:00">08:00 AM</li>
												<li data-value="08:30">08:30 AM</li>
												<li data-value="09:00">09:00 AM</li>
												<li data-value="09:30">09:30 AM</li>
												<li data-value="10:00">10:00 AM</li>
												<li data-value="10:30">10:30 AM</li>
												<li data-value="11:00">11:00 AM</li>
												<li data-value="11:30">11:30 AM</li>
												<li data-value="12:00">12:00 PM</li>
												<li data-value="12:30">12:30 PM</li>
												<li data-value="13:00">01:00 PM</li>
												<li data-value="13:30">01:30 PM</li>
												<li data-value="14:00">02:00 PM</li>
												<li data-value="14:30">02:30 PM</li>
												<li data-value="15:00">03:00 PM</li>
												<li data-value="15:30">03:30 PM</li>
												<li data-value="16:00">04:00 PM</li>
												<li data-value="16:30">04:30 PM</li>
												<li data-value="17:00">05:00 PM</li>
												<li data-value="17:30">05:30 PM</li>
												<li data-value="18:00">06:00 PM</li>
												<li data-value="18:30">06:30 PM</li>
												<li data-value="19:00">07:00 PM</li>
												<li data-value="19:30">07:30 PM</li>
												<li data-value="20:00">08:00 PM</li>
									<!-- 			<li data-value="20:30">08:30 PM</li>
												<li data-value="21:00">09:00 PM</li>
												<li data-value="21:30">09:30 PM</li>
												<li data-value="22:00">10:00 PM</li>
												<li data-value="22:30">10:30 PM</li>
												<li data-value="23:00">11:00 PM</li>
												<li data-value="23:30">11:30 PM</li> -->
											</ul>
										</div>
									</div>
								</div>
							</div>

						</div>
						<!--- Action Links well well-sm-->
						<div class="" style="margin-top: 10px">
							<span class="basic">
							   <label for="allDay" style="padding-right: 5px">
									<input type="checkbox" name="allDay" id="allDay"> Todo el d&iacute;a
							   </label>
							   <label for="repeat" style="padding-right: 5px">
									<input type="checkbox" name="repeat" id="repeat" value="1"> Repetir
							   </label>
							   &nbsp;
							   <div class="show-link" style="float: right; padding-right: 5px; display: block;">
									<a href="javascript:void(0);" id="show-standard-settings">Mostar los ajustes estandar</a>
							   </div>
							</span>
							<div class="form-inline standard" style="float: right; padding-bottom: 3px; display: none;">
								<div class="checkbox" style="padding-top: 0; float: right; ">
									<label for="hide-standard-settings" style="padding-right: 5px; ">
										<a href="javascript:void(0);" id="hide-standard-settings">Ocultar configuraci&oacute;n estandar</a>
									</label>
								</div>
							</div>
							<!-- Repeat Box -->
							<div class="panel panel-info repeat-box col-sm-12" style="margin-top: 18px; margin-bottom: 8px; display: none;">
								<div class="panel-body">
									<div class="form-group">
										<label for="repeat_type" class="col-sm-3 control-label">Se repite</label>
										<div class="col-sm-9">
											<select class="form-control" name="repeat_type" id="repeat_type">
												<option value="daily" selected>Todos los d&iacute;as</option>
												<option value="everyWeekDay">Todos los d&iacute;as h&aacute;biles (de lunes a viernes)</option>
												<option value="everyMWFDay">Todos los lunes, mi&eacute;rcoles y viernes</option>
												<option value="everyTTDay">Todos los martes y jueves</option>
												<option value="weekly">Todas las semanas</option>
												<option value="monthly">Todos los meses</option>
												<option value="yearly">Todos los a&ntilde;os</option>
												<option value="none">Ninguno</option>
											</select>
										</div>
									</div>
									<div class="form-group" id="repeat_interval_group">
										<label for="repeat_interval" class="col-sm-3 control-label">Repetir cada</label>
										<div class="input-group col-sm-9">
											<select class="form-control" name="repeat_interval" id="repeat_interval">
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
												<option value="24">24</option>
												<option value="25">25</option>
												<option value="26">26</option>
												<option value="27">27</option>
												<option value="28">28</option>
												<option value="29">29</option>
												<option value="30">30</option>
											</select>
											<span class="input-group-addon" id="repeat_interval_label">Semana(s)</span>
										</div>
									</div>
									<div class="form-group" id="repeat_by_group" style="display: none;">
										<label for="repeat_by_group" class="col-sm-3 control-label">Repetir para</label>
										<div class="input-group col-sm-9">
											<label class="radio-inline">
												<input class="repeat_by" type="radio" id="repeat_by_day_of_the_month" checked="checked" name="repeat_by" value="repeat_by_day_of_the_month"> D&iacute;a del mes
											</label>
											<label class="radio-inline">
												<input class="repeat_by" type="radio" id="repeat_by_day_of_the_week" name="repeat_by" value="repeat_by_day_of_the_week"> D&iacute;a de la semana
											</label>
										</div>
									</div>
									<div class="form-group" id="repeat_on_group" style="display: none;">
										<label for="repeat_on" class="col-sm-3 control-label">Repetir el</label>
										<div class="input-group col-sm-9">
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_sun" name="repeat_on_sun" value="1"> D
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_mon" name="repeat_on_mon" value="1"> L
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_tue" name="repeat_on_tue" value="1"> M
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_wed" name="repeat_on_wed" value="1"> M
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_thu" name="repeat_on_thu" value="1"> J
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_fri" name="repeat_on_fri" value="1"> V
											</label>
											<label class="checkbox-inline">
												<input class="repeat_on_day" type="checkbox" id="repeat_on_sat" name="repeat_on_sat" value="1"> S
											</label>
										</div>
									</div>
									<div class="form-group">
										<label for="repeat_start_date" class="col-sm-3 control-label">Inicia en</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="repeat_start_date" name="repeat_start_date" value="0000-01-01" readonly="" style="background: transparent">
										</div>
									</div>
									<div class="form-group">
										<label for="ends-db-val" class="col-sm-3 control-label">Finaliza en</label>
										<div class="col-sm-9">
											<div class="input-group event-form-break">
												<div class="input-group-btn dropup">
													<button class="btn btn-default dropdown-toggle event-create-btn-input" type="button" data-toggle="dropdown">
														<span id="ends-text"> Finaliza <span id="ends-status">Nunca</span></span>&nbsp;<span class="caret"></span>
													</button>
													<ul class="dropdown-menu">
														<li><a id="ends-never" href="javascript:void(0);" data-value="Never" data-text="Nunca" class="ends-params">Nunca</a></li>
														<li><a id="ends-after" href="javascript:void(0);" data-value="After" data-text="Despues" class="ends-params">Despues</a></li>
														<li><a id="ends-on" href="javascript:void(0);" data-value="On" data-text="El" class="ends-params">El</a></li>
													</ul>
													<input type="hidden" name="repeat_end_on" id="repeat_end_on" value="">
													<input type="hidden" name="repeat_end_after" id="repeat_end_after" value="">
													<input type="hidden" name="repeat_never" id="repeat_never" value="1">
												</div>
												<input type="text" class="form-control" id="ends-db-val" readonly="readonly" style="width: 130px"> <span style="display: none; margin-left: 10px;" id="ends-after-label">Rep.</span>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Repeat Box Ends -->

							<!-- Standard Settings -->
							<div class="standard col-sm-12" style="margin-top: 18px; display: none;">
								<div class="form-group">
									<label for="location" class="col-sm-3 control-label">Lugar</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="location" name="location" placeholder="Lugar">
									</div>
								</div>

								<div class="form-group">
									<label for="url" class="col-sm-3 control-label">URL</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="url" name="url" placeholder="URL">
									</div>
								</div>
								<div class="form-group">
									<label for="select-organizer" class="col-sm-3 control-label">Organizador</label>
									<div class="col-sm-9">
										<div id="organizer-input-div">
											<input id="organizer-input" style="display: none" type="text" class="form-control" name="organizer_new">														
										</div>
										<div id="selector">													
											<select id="select-organizer" class="selectpicker show-tick col-lg-12 select-organizer-cls" name="organizer" style="display: none;">
												<option data-value="<?php echo $this->tank_auth->get_usermail(); ?>" value="<?php echo $this->tank_auth->get_usermail(); ?>" data-content="<span class=&quot;multiple-select-option-label&quot;><?php echo $this->tank_auth->get_usermail(); ?></span>"><?php echo $this->tank_auth->get_usermail(); ?></option>
											</select>
											<!--<div class="btn-group bootstrap-select show-tick col-lg-12 select-organizer-cls">
												<button type="button" class="btn dropdown-toggle selectpicker btn-default" data-toggle="dropdown" data-id="select-organizer" title="Seleccionar">
													<span class="filter-option pull-left">Seleccionar</span>&nbsp;
													<span class="caret"></span>
												</button>
												<div class="dropdown-menu open">
													<ul class="dropdown-menu inner selectpicker" role="menu">
														<li rel="0" class="">
															<a tabindex="0" class="" style="">
																<span class="multiple-select-option-label"><?php echo $this->tank_auth->get_usermail(); ?></span>
																<i class="glyphicon glyphicon-ok icon-ok check-mark"></i>
															</a>
														</li>
													</ul>
												</div>
											</div>-->
										</div>
										<!--<div class="col-sm-12" id="add_organizer_div">
											<a id="cancel_organizer" style="font-size: 12px; display:none;" href="javascript:void(0);">Cancelar</a>
											<a id="add_organizer" style="font-size: 12px;" href="javascript:void(0);">Agregar organizador</a>
										</div>-->
									</div>
								</div>
								<!--Resource Entry-->

								<!--2-->
								<div class="form-group">
									<label for="description" class="col-sm-3 control-label">Descripci&oacute;n</label>
									<div class="col-sm-9">
										<textarea class="form-control" id="description" name="description"></textarea>
									</div>
								</div>
								<div class="form-group">
                                    <label for="eventImage" class="col-sm-3 control-label">Subir archivos</label>
                                    <div class="col-sm-6">
                                        <!--<span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Agregar archivos...</span>                                            
                                            <input  type="file" name="files" class="btn btn-success" multiple="multiple" id="UploadImage">
                                        </span>										 
                                        <input type="hidden" id="imageName" name="imageName" value="" />-->
										<div id="fileuploader">Upload</div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div id="dvElements" class="files"></div>										
                                    </div>
                                </div>
								<div class="form-group">
									<label for="backgroundColor" class="col-sm-3 control-label">Color de evento</label>
									<div class="col-sm-9">
										<div class="form-control" style="padding-bottom: 2px;;white-space:nowrap">
											<span style="background-color: #A4BDFC" class="color-box" data-color="1" id="cid_3a87ad">&nbsp;</span>
											<span style="background-color: #7AE7BF" class="color-box" data-color="2" id="cid_eaff00">&nbsp;</span>
											<span style="background-color: #DBADFF" class="color-box" data-color="3" id="cid_f903a5">&nbsp;</span>
											<span style="background-color: #FF887C" class="color-box color-box-selected" data-color="4" id="cid_1a9b05">&nbsp;✔</span>
											<span style="background-color: #FBD75B" class="color-box" data-color="5" id="cid_0c2ddd">&nbsp;</span>
											<span style="background-color: #FFB878" class="color-box" data-color="6" id="cid_ff4206">&nbsp;</span>
											<span style="background-color: #46D6DB" class="color-box" data-color="7" id="cid_17cccc">&nbsp;</span>
											<span style="background-color: #E1E1E1" class="color-box" data-color="8" id="cid_0a0003">&nbsp;</span>
											<span style="background-color: #5484ED" class="color-box" data-color="9" id="cid_a8a8a8">&nbsp;</span>
											<span style="background-color: #51B749" class="color-box" data-color="10" id="cid_51B749">&nbsp;</span>
											<span style="background-color: #DC2127" class="color-box" data-color="11" id="cid_DC2127">&nbsp;</span>
										</div>
										<input type="hidden" name="backgroundColor" id="backgroundColor" value="4">
									</div>
								</div>
								<div class="form-group">
									<label for="free_busy" class="col-sm-3 control-label">Mostrar como</label>
									<div class="col-sm-9">
										<select name="free_busy" id="free_busy" class="form-control">
											<option value="free">Disponible</option>
											<option value="busy">Ocupado</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="privacy" class="col-sm-3 control-label">Privacy</label>
									<div class="col-sm-9">
										<select name="privacy" id="privacy" class="form-control ">
											<option value="public">Publico</option>
											<option value="private">Privado</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="panel-group" id="accordion1">
										<div class="panel panel-default">
										  <div class="panel-heading">
											<h5 class="panel-title">
											  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#genesis">Informaci&oacute;n de correos confirmado</a>
											</h5>
										  </div>
										  <div id="genesis" class="panel-collapse collapse">
												<div class="panel-body">
													<table class="table table-hover">
													  <thead>
														<tr>
														  <th></th>
														  <th></th>
														  <th></th>
														</tr>
													  </thead>
													  <tbody id="guest-list-google">
													  </tbody>
													</table>
												</div>
										  </div>
										</div>								  
									 </div>	
									 <div class="panel-group" id="accordion2">
										<div class="panel panel-default">
										  <div class="panel-heading">
											<h5 class="panel-title">
											  <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#emails_acordion">Tabla de contactos</a>
											</h5>
										  </div>
										  <div id="emails_acordion" class="panel-collapse collapse">
												
												<div class="panel-body">
														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
															<label><input type="checkbox" class="client" data-alias="todos"> Todos los correos</label>
														</div>
														<!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container">-->
														<div class="row">
															<div class="col-lg-12 col-md-12 col-sm-12 col-xs-9 bhoechie-tab-container" style="width:93%;margin-left:20px;">
															    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
															      <div class="list-group" style="height:500px;overflow-y:scroll;overflow-x:hidden;">
																	<?php
																	if(isset($Catalogo_Perfiles)):
																		foreach($Catalogo_Perfiles as $i => $item):
																		#echo $i; 
																		?>
																			<a href="#" class="list-group-item text-center <?php echo $i == 0 ? 'active' : '';?>">
																			    <h4 class="glyphicon glyphicon-user"></h4><br/><?php echo $item["Name"]; ?>
																			</a>
																			<?php if (isset($item["Data"])) { 
																				foreach ($item["Data"] as $value) { 
                                                                                    if($value['idTipoUser'] == '6'){?>
																					<a href="#" class="list-group-item text-center" <?php echo ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["IDVend"].'"' : "");?>>
								    													<h4 class="glyphicon glyphicon-user"></h4><br/><?php echo ($item["Name"] == "Vendedores" ? "Clientes del vendedor " : "Vendedores de "); echo ($value["username"] != "" ? $value["username"] : "Sin Usuario"); ?>
																					</a>
																				<?php } } 
																			} ?>
																		<?php
																			#var_dump($item);
																		endforeach;
																	endif;
																	?>
															      </div>
															    </div>
															    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab" style="height:500px;overflow-y:scroll;overflow-x:hidden;">
																	
															        <!-- flight section -->
															        <!-- en caso de modificarse el div con la clase "bhoechie-tab-content table-responsive" conservar: <?php echo $i == 0 ? 'active' : '' ;?>-->
																	<?php
																	if(isset($Catalogo_Perfiles)):
																		foreach($Catalogo_Perfiles as $i => $item):
																		?>
																		<div class="bhoechie-tab-content table-responsive <?php echo $i == 0 ? 'active' : '' ;?>">
																			<div class="form-group">
																				<label><input type="checkbox" class="client" data-alias="tablaVen-<?php echo $value["idTipoUser"]; ?>"> Todos los <?php echo $item["Name"]; ?></label>
																				<?php if( isset($item["Data"]) && $item["Data"] != NULL ): ?>
																				<table class="table table-hover table-email-gap" id="tablaVenC-<?php echo $value["idTipoUser"]; ?>" <?php echo ($item["Name"] == "Vendedores" ? 'data-IdVen="'.$value["idTipoUser"].'"' : "");?>>
																				  <thead>
																					<tr>
																					  <th class="all"></th>
																					  <th></th>
																					  <th></th>
																					</tr>
																				  </thead>
																				  <tbody>
																						<?php foreach($item["Data"] as $items): ?>								
																						<tr>
																						  <td><input type="checkbox" class="tablaVen-<?php echo $value["IDVend"]; ?> emailGap client" data-id="<?php echo $value["id"];?>" data-email ="<?php echo $items["email"]; ?>"> <a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>
																						  <td><strong><?php echo $items["username"]; ?></strong></td>
																						  <td><?php echo $items["email"]; ?></td>
																						</tr>
																						<?php endforeach; ?>
																				  </tbody>
																				</table>
																				<?php endif; ?>
																			</div>
																		</div>
																		<?php if (isset($item["Data"])) { 
																				foreach ($item["Data"] as $value) { ?>
                                                                                    <?php if($value['idTipoUser'] == '6'):?>
																					<div class="bhoechie-tab-content table-responsive">
																						<div class="form-group">
																							<label><input type="checkbox" class="client" data-alias="tablaVen-<?php echo $value["IDVend"]; ?>"><?php echo ($item["Name"] == "Vendedores" ? "Clientes del vendedor " : "Vendedores de "); echo ($value["username"] != "" ? $value["username"] : "Sin Usuario"); ?></label>
																							<?php if( isset($item["Data"]) && $item["Data"] != NULL ): ?>
																							<table class="table table-hover table-email-gap" id="tablaVen-<?php echo $value["IDVend"]; ?>">
																							  <thead>
																								<tr>
																								  <th class="all"></th>
																								  <th></th>
																								  <th></th>
																								</tr>
																							  </thead>
																							  <tbody>
																									<?php
																									if ($item["Name"] != "Vendedores") 
																									{
																										if (isset($value["vendedores"])) {
																											foreach($value["vendedores"] as $items): 
																												if (strlen($items["email"]) > 0): ?>								
																													<tr>
																													  <td><input type="checkbox" class="tablaVen-<?php echo $value["IDVend"]; ?> emailGap client" data-id="<?php echo $items["id"];?>" data-email ="<?php echo $items["email"]; ?>"> <a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>
																													  <td><strong><?php echo $items["name_complete"]; ?></strong></td>
																													  <td><?php echo $items["email"]; ?></td>
																													</tr>
																												<?php endif;
																											endforeach; 
																										}
																									}
																									?>
																							  </tbody>
																							</table>
																							<?php endif; ?>
																						</div>
																					</div>
                                                                                    <?php endif;?>
																				<?php } 
																			} ?>			
																		<?php
																		endforeach;
																	endif;
																	?>               
															    </div>
															</div>
														</div>
												</div>
										  </div>
										</div>								  
									 </div>
								</div>
							</div>
						</div>
						<div class="" style="margin-top: 10px; min-height: 40px;">
							<span class="basic-remind">
							   <div class="show-link-remind" style="float: right; padding-right: 5px;">
								   <a href="javascript:void(0);" id="show-reminder-settings">Ajustes Mostrar recordatorio</a>
							   </div>
							</span>
							<div class="form-inline reminder" style="float: right; padding-bottom:3px">
								<div class="checkbox" style="padding-top: 0; float: right; ">
									<label for="hide-reminder-settings"  style="padding-right: 5px; ">
										<a href="javascript:void(0);" id="hide-reminder-settings">ocultar configuraci&oacute;n de los recordatorios</a>
									</label>
								</div>
							</div>
							<div class="reminder col-sm-12" style="margin-top: 8px">
								<div id="reminder-holder">
									<div class="form-group reminder-group" id="reminder1" style="display: block">
										<label for="reminder_type_1" class="col-sm-3 control-label">Recordatorio</label>
										<div class="col-sm-9">
											<div class="col-sm-4">
												<select name="reminder_type[]" id="reminder_type_1" class="form-control">
													<option value="email">Email</option>
													<option value="popup">Popup</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px;">
												<select name="reminder_time[]" id="reminder_time_1" class="form-control">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="15">15</option>
													<option value="20">20</option>
													<option value="25">25</option>
													<option value="30">30</option>
													<option value="45">45</option>
													<option value="50">50</option>
													<option value="55">55</option>
													<option value="60">60</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px">
												<select name="reminder_time_unit[]" id="reminder_time_unit_1" class="form-control">
													<option value="minute">Minuto(s)</option>
													<option value="hour">Hora(s)</option>
													<option value="day">D&iacute;a(s)</option>
													<option value="week">Semana(s)</option>
												</select>
											</div>
											<div class="col-sm-2"></div>
										</div>
									</div>

									<div class="form-group reminder-group" id="reminder2" style="display: block">
										<label for="reminder_type_2" class="col-sm-3 control-label">&nbsp;</label>
										<div class="col-sm-9">
											<div class="col-sm-4">
												<select name="reminder_type[]" id="reminder_type_2" class="form-control">
													<option value="email">Email</option>
													<option value="popup">Popup</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px;">
												<select name="reminder_time[]" id="reminder_time_2" class="form-control">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="15">15</option>
													<option value="20">20</option>
													<option value="25">25</option>
													<option value="30">30</option>
													<option value="45">45</option>
													<option value="50">50</option>
													<option value="55">55</option>
													<option value="60">60</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px">
												<select name="reminder_time_unit[]" id="reminder_time_unit_2" class="form-control">
													<option value="minute">Minuto(s)</option>
													<option value="hour">Hora(s)</option>
													<option value="day">Dia(s)</option>
													<option value="week">Semana(s)</option>
												</select>
											</div>
											<div class="col-sm-2"><button class='close_reminder' onclick="javascript:hideReminder2();" aria-hidden='true' data-dismiss='guest' type='button'>×</button></div>

										</div>
									</div>

									<div class="form-group reminder-group" id="reminder3" style="display: block">
										<label for="reminder_type_3" class="col-sm-3 control-label">&nbsp;</label>
										<div class="col-sm-9">
											<div class="col-sm-4">
												<select name="reminder_type[]" id="reminder_type_3" class="form-control">
													<option value="email">Email</option>
													<option value="popup">Popup</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px;">
												<select name="reminder_time[]" id="reminder_time_3" class="form-control">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
													<option value="8">8</option>
													<option value="9">9</option>
													<option value="10">10</option>
													<option value="15">15</option>
													<option value="20">20</option>
													<option value="25">25</option>
													<option value="30">30</option>
													<option value="45">45</option>
													<option value="50">50</option>
													<option value="55">55</option>
													<option value="60">60</option>
												</select>
											</div>
											<div class="col-sm-3" style="padding-left: 5px">
												<select name="reminder_time_unit[]" id="reminder_time_unit_3" class="form-control">
													<option value="minute">Minuto(s)</option>
													<option value="hour">Hora(s)</option>
													<option value="day">Dia(s)</option>
													<option value="week">Semana(s)</option>
												</select>
											</div>
											<div class="col-sm-2"><button class='close_reminder' data-val='reminder3' onclick="javascript:hideReminder3();"  aria-hidden='true' data-dismiss='guest' type='button'>×</button></div>

										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="privacy" class="col-sm-3 control-label">&nbsp;</label>
									<div class="col-sm-9">
										<a href="javascript:void(0);" id="add_reminder" style="font-size: 12px;">A&ntilde;adir Recordatorio</a>
									</div>

								</div>
								
								<div class="form-group">									
									<label for="privacy" class="col-sm-3 control-label">Invitados</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" id="guest" style="width:80%; float:left;">&nbsp;<button type="button" class="btn btn-small btn-success" id="add-guest">A&ntilde;adir</button>
										<div id="guest-list"></div>
										<div id="guest-list-gap" style="display:none"></div>
									</div>

								</div>
								<div id="MostarListaCorreo">
										<div class="col-md-12 col-sm-12 col-xs-12">										
											<div id="add-email"></div>
											<div id="add-promotor-vendedor"></div>
										<div>
								</div>								
							</div>
						</div>

						<!-- Reminder Settings Ends -->
						</fieldset>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="" name="update-event" id="update-event">
						<input type="hidden" value="month" name="currentView" id="currentView">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" id="create-event">Crear Evento</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- finaliza modal de evento -->
<!-- plugins for calendar -->
<div class="modal cargando"><!-- Place at bottom of page --></div>
<link href="<?php echo site_url('assets/css/uploadfile.css'); ?>" rel="stylesheet">
<script type="text/javascript" src='<?php echo site_url('assets/js/fullcalendar/lib/moment.min.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/fullcalendar/fullcalendar.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/fullcalendar/lang/es.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/fullcalendar/gcal.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/bootstrap-colorpicker-master/js/bootstrap-colorpicker.min.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/bootstrap-silviomoreto-select/bootstrap-select.min.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/spin.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/ladda.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/prism.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/ifightcrime-bootstrap-growl/jquery.bootstrap-growl.js'); ?>'></script>
<script type="text/javascript" src='<?php echo site_url('assets/js/plugins/ladda-bootstrap-master/dist/spin.min.js'); ?>'></script>
<script src="<?php echo site_url('assets/js/jquery.uploadfile.js'); ?>"></script>


<script type="text/javascript" src='<?php echo site_url('assets/js/jquery.calendar.cenis.js'); ?>'></script>
<script type="text/javascript" src="<?php echo site_url('assets/js/jquery.generic.cenis.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {	
	 // $(".ajax-file-upload-container").remove();
	 // $("#dvElements input[name=file_drive\\[\\]]").remove();
	 $("#fileuploader").uploadFile({url: "<?php echo base_url() ?>calendario/do_upload",
		dragDrop: true,
		fileName: "myfile",
		returnType: "json",
		showDelete: true,
		showDownload:false,
		statusBarWidth:300,
		dragdropWidth:300,
		uploadStr:"Subir",
		abortStr: "Abortar",
		cancelStr: "Cancelar",
		deletelStr: "Eliminar",
		doneStr: "Listo",
		multiDragErrorStr: "Multiples Archivos Drag &amp; Drop.",
		//extErrorStr: "is not allowed. Allowed extensions: ",
		//duplicateErrorStr: "is not allowed. File already exists.",
		//sizeErrorStr: "is not allowed. Allowed Max size: ",
		//uploadErrorStr: "Upload is not allowed",
		//maxFileCountErrorStr: " is not allowed. Maximum allowed files are:",
		downloadStr: "Descargar",
		onSubmit:function(files)
		{
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Submitting:"+JSON.stringify(files));
			//return false;
		},
		onSuccess:function(files,data,xhr,pd)
		{
			if(typeof data ==  "object"){
				var sInput = '<input type="hidden" name="file_drive[]" data-drive-title="'+data.title +'" data-drive-mimeType="'+data.mimeType +'" data-drive-iconLink="'+data.iconLink +'" data-drive-id="'+data.id+'" data-drive-alternatelink="'+data.alternateLink+'" data-drive-downloadurl="'+data.downloadUrl+'" />';
				$('#dvElements').append(sInput);
			}
			//$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Success for: "+JSON.stringify(data));
			
		},
		afterUploadAll:function(obj)
		{
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>All files are uploaded");
			

		},
		onError: function(files,status,errMsg,pd)
		{
			$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Error for: "+JSON.stringify(files));
		},
		onCancel:function(files,pd)
		{
				$("#eventsmessage").html($("#eventsmessage").html()+"<br/>Canceled  files: "+JSON.stringify(files));
		},
		deleteCallback: function (data, pd) {
			
			$('#dvElements > input[data-drive-id='+data.id+']').remove();
			$.post("<?php echo base_url() ?>calendario/do_delete", { op: "delete",name: data.title, id: data.id },
					function (resp,textStatus, jqXHR) {
						//Show Message	
						alert("File Deleted");
					});
			
			pd.statusbar.hide();

		}//,
		// onLoad:function(obj)
		// {
			// var eventId = $('#update-event').val(); 
			// var data_json = { "eventId" : eventId };
			
			// console.log(data_json);
			
			// $.ajax({
				// cache: false,
				// url: "<?php echo base_url() ?>calendario/do_load",
				// dataType: "json",
				// data:data_json,
				// success: function(data) 
				// {
					// console.log(data);
					
					// for(var i=0;i<data.length;i++)
					// {
						// obj.createProgress(data[i]);
					// }
				// }
			// });
	   // },
		
		//,
		// downloadCallback:function(filename,pd)
			// {
				// location.href="download.php?filename="+filename;
			// }
		}); 
	});
	
	
	$(document).ready(function(){
		$body = $("body");
		$(document).on({
		    ajaxStart: function() { $body.addClass("loading");    },
		    ajaxStop: function()  { $body.removeClass("loading"); },
		    ajaxError: function() { $body.removeClass("loading"); }    
		});
		//Carcar todos los eventos del calendario primary
		$("#calendar").CalendarCenis({
			EventJson : <?php echo $Listar_evento; ?>
		});	
		
		//Cargar las configuraciones del popup del calendario
		$("#show-standard-settings").CalendarCenis('ShowSettings');	
		
		//Crear evento
		$("#create-new-event").CalendarCenis("CreateEvent",{
			CalName: '#name',
			ModalNameFormId: "#myModalCalendarCreateFrom",
			ColorClass : ".color-box",
			ClasColorRemove : "color-box-selected",
			IdColorCal : "#backgroundColor"
		});
		
		//Remover evento, y enviar notificacion
		$("#remove-link").CalendarCenis('DeleteEvent',{
			enviarNotificacion : true
		});
		
		$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
				e.preventDefault();
				var idven = $(e.target).attr("data-idven");
				if (idven) 
				{
					//console.log(table);
					//console.log(table.find("tbody tr").length);
					var table = $("#tablaVen-" + idven);

					var host = window.location.href;
					host = host.substring(0,host.lastIndexOf("/"));
					host = host.substring(0,host.lastIndexOf("/"));

					var Datos = { "IDVend" : idven };
					$.ajax({
						data: Datos,
						type: "POST",
						url: host + "/mailMasivo/getClientes",
						error: function (jqXHR, textStatus, errorThrown) {
							alert("error: " + errorThrown); 
						},
						success: function (response) {
							//console.log(response);
							var Array_JSON = JSON.parse(response);
							
							//console.log(Array_JSON);
							//console.log("******************************************************************************************");
							table.find("tbody tr").remove();
							$.each(Array_JSON,function(k,v){
								var rowhead = '<tr class="sramo">'+
												'<td colspan="3"><input type="checkbox" class="hsubramo" data-id="'+v.id+'">'+v.sramo+'</td>'+
											'</tr>';

								table.find("tbody").append(rowhead);

								
								$.each(v.data,function(i,item){

									

									var row = '<tr class="subsramo'+v.id+'" >' +
				                				'<td class="pleft"><input type="checkbox" data-id="'+ item.IDCli +'" data-id-sub="'+v.id+'" class="'+ table.attr("id") +' emailGap client sub'+v.id+'" data-email="'+  item.EMail1 +'"><a href="#"><i class="glyphicon glyphicon-envelope"></i></a></td>' +
				                				'<td><strong>'+ item.NombreCompleto +'<strong></td>'+
				                				'<td>'+ item.EMail1 + '</td>'+
				                			  '</tr>';
				                	//console.log(table);
				                	table.find("tbody").append(row);
				                	var agregado = $("#guest-list-gap input.guest_"+ item.IDCli).val();
				                	if (agregado)
				                	{
				                		$("." + table.attr("id")).prop("checked", true);
				                	}
								});
							});
						}
					});
				}

				$(this).siblings('a.active').removeClass("active");
				$(this).addClass("active");
				var index = $(this).index();
				$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
				$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
			});
		});


		$(document).on("click",'.hsubramo',function(e){
			var ID = $(this).attr('data-id');

			if(!this.checked){
				$('.sub'+ID).prop('checked',false);	
			}else{
				$('.sub'+ID).prop('checked',true);
			}
		});
	
		//*******//
		$(document.body).on('keydown','.number',function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
				 // Allow: Ctrl+A, Command+A
				(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
				 // Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
					 // let it happen, don't do anything
					 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		//*******//
		$(document).on("click",".client",function (e) {
						 
			 data_value = $(this).attr("data-alias");
			 data_id = $(this).attr("data-id");
			 data_id_sub = $(this).attr("data-id-sub");
			 
			 if (data_value === undefined) {
				 
				//console.log("client");
				 
				 var guestView = "";
				 
				data_value = $(this).attr("data-email");
				 
				 
				 
				if($(this).is(':checked')){							 
					guestView += "<input class='guest_" + data_id +"_"+data_id_sub+"' name='guests[]' value='" + data_value + "'>";
					$("#guest-list-gap").append(guestView);	
				}
				else{
					
					if($("input[data-alias=todos]").is(':checked')){
						$("input[data-alias=todos]").prop( "checked", false )
					}
					
					alias = $(this).closest('table').attr('id');
					
					console.log(alias);
					
					if($("input[data-alias=" + alias + "]").is(':checked')){
						$("input[data-alias=" + alias + "]").prop( "checked", false )
					}
					
					$(".guest_" + data_id).remove(); 
				 }
				 
			 }else if(data_value == 'subramo'){
				guestView = "";
			 	var ID = $(this).attr('data-id');
		 		var emails = $('.sub'+ID);
			 	if(this.checked){
			 		

			 		$.each(emails,function(index,item){
			 			var dta_id = $(item).attr("data-id");
			 			var dta_id_sub = $(item).attr("data-id-sub");

			 			if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
			 				guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
			 			}
						$(item).prop( "checked", true );						
			 		});

			 		$("#guest-list-gap").append(guestView);	

			 	}else{

			 		$.each(emails,function(index,item){
						var dta_id = $(item).attr("data-id");
						var dta_id_sub = $(item).attr("data-id-sub");
						$(".guest_" + dta_id+"_"+dta_id_sub).remove();
						$(item).prop( "checked", false );
					});
			 	}
			 }
			 else{
				if($(this).is(':checked')){
					console.log(data_value);
					console.log(data_id);
					//$( "#x" ).prop( "checked", true );
 
					// Uncheck #x
					//$( "#x" ).prop( "checked", false );
					if(data_value == "todos")
					{					
						$("#guest-list-gap").html("");
						var email = $(".table-email-gap").find(".emailGap");
						var guestView = "";
						$.each(email,function(index,item){
							
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");

							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});
						
						$("#guest-list-gap").append(guestView);	
						$("input.client").prop( "checked", true );
					}else{													
												
						var vals = data_value.split('-');	
						var email = $("#tablaVenC-"+vals[1]).find(".emailGap");								
						var guestView = "";
						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});

						var email = $("#"+data_value).find(".emailGap");		
						$.each(email,function(index,item){
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							if($(".guest_" + dta_id+"_"+dta_id_sub).length == 0){
								guestView += "<input class='guest_" + dta_id +"_"+dta_id_sub+"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
							}
							$(item).prop( "checked", true );
						});						

						$("#guest-list-gap").append(guestView);	
						//$("#" + data_value + " input.emailGap").prop( "checked", true );
						//$("#" + data_value + " .client").prop( "checked", true );
					}

				}else{
					
					if(data_value == "todos"){
						//$(".guest_" + data_value).remove();
						console.log("ready-todos");
						
						var email = $("#" + data_value).find(".emailGap");
						
						if(email.length > 0){
						
							$.each(email,function(index,item)
							{
								var dta_id = $(item).attr("data-id");
								var dta_id_sub = $(item).attr("data-id-sub");
								console.log(".guest_" + dta_id+"_"+dta_id_sub);
								$(".guest_" + dta_id+"_"+dta_id_sub).remove();
								$(item).prop( "checked", false );
							});
						}else{
							
							var email_list = $("#guest-list-gap").find("input");							
							$.each(email_list,function(index,item){	$(item).remove(); });
						}
						

						
						$("input.emailGap").prop( "checked", false );
						$("input.client").prop( "checked", false );
					}else{
						//console.log("dkadskas");
						//$(".guest_" + data_value).remove();
						//$("input." + data_value).prop( "checked", false );
						var vals = data_value.split('-');
						
						var email = $("#tablaVenC-"+vals[1]).find(".emailGap");								
						$.each(email,function(index,item)
						{
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							$(".guest_" + dta_id+"_"+dta_id_sub).remove();
							$(item).prop( "checked", false );
						});
						var email = $("#"+data_value).find(".emailGap");		
				
						$.each(email,function(index,item)
						{
							var dta_id = $(item).attr("data-id");
							var dta_id_sub = $(item).attr("data-id-sub");
							$(".guest_" + dta_id+"_"+dta_id_sub).remove();
							$(item).prop( "checked", false );
						});
					}
				} 
			 }		
		});
		function hideReminder2() {
			reminder2Obj.appendTo('#reminder-holder');
			reminder2Obj = $('#reminder2').detach();
		}
		function hideReminder3() {
			reminder3Obj.appendTo('#reminder-holder');
			reminder3Obj = $('#reminder3').detach();
		}

</script>	
<!-- plugins for calendar -->
<?php $this->load->view('footers/footer'); ?>