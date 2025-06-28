(function ($) {
	
	/***/
	var repeat_on_sun = 0;
	var repeat_on_mon = 0;
	var repeat_on_tue = 0;
	var repeat_on_wed = 0;
	var repeat_on_thu = 0;
	var repeat_on_fri = 0;
	var repeat_on_sat = 0;
	var repeat_week_days_checked = false;
	//variante por que el controlador retorna index
	var Host = window.location.href.replace("/index","");
	/***/
	var methods = {
		
		init : function(options){
			var settings = $.extend({
                EventJson: ''
            }, options);
			
			return this.each(function(){
				$("#calendar").fullCalendar({
					googleCalendarApiKey: '',
					header: {
						center:   'title',
						//right: 'basicDay, basicWeek, month, agendaDay, agendaWeek',
						right: 'agendaDay, month, agendaWeek,list, resourceDay, pec',
						left:  'today prev,next'
					},
					allDaySlot:true,
					//allDayText:'all-day',
					axisFormat:'h(:mm)A',
					snapMinutes:'',
					currentTimezone: 'America/Ciudad_Mexico',
					timezone: 'America/Mexico_City',
					timezone: 'UTC-06:00',
					eventLimit: true,
					defaultEventMinutes: '',
					firstHour: '',
					minTime: '0',
					//maxTime: '24',
					slotEventOverlap: 'true',
					weekends: true,
					firstDay: 1,
					isRTL: false,
					hiddenDays: [],
					year:2016,
					month:0,
					date:27,
					theme: false,
					buttonIcons: { 
						prev: 'left-single-arrow',
						next: 'right-single-arrow',
						prevYear: 'left-double-arrow',
						nextYear: 'right-double-arrow'
					},
					weekMode: 'fixed',
					weekNumbers: false,
					weekNumberCalculation: 'iso',
					height:'',
					contentHeight: '',
					aspectRatio: 1.35,
					handleWindowResize: true,
					defaultView: 'month',
					//timeFormat: {'agenda':'hh:mm A','':'hh:mm A'},
					timeFormat: 'H(:mm)',
					columnFormat: {'month':'ddd','week':'ddd M\/D','day':'dddd M\/D'},
					titleFormat: {'month':'MMMM YYYY','week':'MMM D YYYY','day':'dddd, MMM D, YYYY'},
					//buttonText: {'prev':'Prev','next':'Next','agendaDay':'Day','basicDay':'Day','month':'Month','agendaWeek':'Week','list':'Agenda','resourceDay':'Resource','pec':'Upcoming'},
					//monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
					//monthNamesShort: ['En','Febr','Mzo','Abr','My','Jun','Jul','Ag','Sept','Oct','Nov','Dic'],
					//dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
					//dayNamesShort: ['Dom','Lun','Mart','Miérc','Juev','Vier','Sáb'],
					weekNumberTitle: 'W',
					selectable: 'false',
					selectHelper: 'false',
					unselectAuto: 'true',
					unselectCancel: '',
					viewRender: function(view, element){
						//alert('here');
						//alert(view);
						var view = $('#calendar').fullCalendar('getView');
							document.cookie = 'currentView='+view.name;
							//alert(view.name);
					},

					eventResize: function(event, revertFunc, jsEvent, ui, view) {
						processMovedEvent(event, revertFunc, jsEvent, ui, view);

						/*
						alert(
							'The end date of ' + event.title + 'has been moved ' +
							dayDelta + ' days and ' +
							minuteDelta + ' minutes.'
						);

						if (!confirm('is this okay?')) {
							revertFunc();
						}
						*/
					},

					eventDrop: function(event, revertFunc, jsEvent, ui, view) {
						processMovedEvent(event, revertFunc, jsEvent, ui, view);
					},
					select:function(start, end, jsEvent, view, resource) {
						
						$("#accordion1").hide();
						// console.log(start);
						// console.log(end);
						 console.log("select_1");
						 $('#cancel-block').hide();
						 $(".ajax-file-upload-statusbar").remove();
						$(".ajax-file-upload-container").remove();
						$("#dvElements input[name=file_drive\\[\\]]").remove();
						
						/*===============================================================*/
						/*=== Load attach
						/*===============================================================*/
						 $("#fileuploader").uploadFile(
								{url: Host + "/do_upload",
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

								},
								onLoad:function(obj)
								{									
							    }
							 });	
						/*===============================================================*/
						/*=== Load attach
						/*===============================================================*/
						// console.log(view);
						// console.log(resource);
						//alert(view);
						//==== show this panel if it is hidden
						$('#end-group').show();
						$('#remove-block').hide();
						$('#repeat_by_group').hide();

						//===Clearing Reminder, externalEmail and category-event Settings Panel

						$("#idEvento").click();

						$('#hide-reminder-settings').click();
						$('#hide-externalEmail-settings').click();
						$('#hide-category-event-settings').click();
						serial = 1;
						$('#guest-list div').remove();

						//===Selecting Multiple Calendar

						$('#eventForm fieldset').removeAttr('disabled');

						var dt = new Date();

						var hours   = 08;
						var minutes = start.format('mm');
						if(minutes > 30) minutes = 30;
						else minutes = 0;
						var ehours;
						if(hours > 0) ehours = hours+1;
						if(hours == 0) ehours = hours;
						if(hours == 23) ehours = hours;

						var eminutes;
						if(ehours >= 24) ehours = '0';
						if(hours > 0) eminutes = minutes;
						if(hours == 0) eminutes = '59';
						if(hours == 23) eminutes = '59';

						var mm = start.format('M');
						var dd = start.format('D');
						var yyyy = start.format('YYYY');

						if(parseInt(mm) <= 9) mm = '0'+(parseInt(mm)+0);
						if(parseInt(dd) <= 9) dd = '0'+dd;
						if(parseInt(hours) <= 9) hours = '0'+hours;
						if(parseInt(minutes) <= 9) minutes = '0'+minutes;
						if(parseInt(ehours) <= 9) ehours = '0'+ehours;
						if(parseInt(eminutes) <= 9) eminutes = '0'+eminutes;

						var curDate = yyyy+'-'+mm+'-'+dd+' '+hours+':'+minutes;
						var curDateInput = yyyy+'-'+mm+'-'+dd;

						var shortdateFormat = 'DD-MM-YYYY';
						var longdateFormat = 'dddd, DD MMMM YYYY';
						var title = $.fullCalendar.moment(start).format(longdateFormat)
						$('#myModal').modal({backdrop:'',keyboard:false});
						$('#myModalLabel').html(title);
						$('#myTab a:first').tab('show');
						$('#create-event').html('Crear Evento');
						$('#update-event').val('');

						//==== resetting fields
						document.getElementById('eventForm').reset();
						$('.checkbox-inline input, #allDay').removeAttr('checked');
						$('.repeat-box').hide();
						$('#hide-standard-settings').click();
						//$('.color-box').removeClass('color-box-selected');
						$('#backgroundColor').val('1');
						$('#repeat_end_on').val('');
						$('#repeat_end_after').val('');
						$('#repeat_never').val('1');
						$('#ends-db-val').datetimepicker('remove');
						$('#ends-db-val').attr('readonly','readonly');
						$('#ends-db-val').removeClass("number");

						//====For Agenda Week & Agenda Day
						if(hours > 0 || minutes > 0){

						}

						//====Setting Date Fields
						$('#start-date').val(curDateInput);
						$('#end-date').val(curDateInput);
						$('#repeat_start_date').val(curDateInput);

						//===convert 24 hours to 12 hours format
						var startTime12Format = _formatTimeStr(hours+':'+minutes);
						var endTime12Format = _formatTimeStr(ehours+':'+eminutes);

						$('#start-time').val('08:00 AM');
						$('#end-time').val('08:00 AM');

					},
					dayClick: function(date, allDay, jsEvent, view) {
						
						//==== show this panel if it is hidden
						$('#end-group').show();
						$('#remove-block').hide();
						$('#repeat_by_group').hide();

						//===Clearing Reminder Settings Panel
						$('#hide-reminder-settings').click();
						serial = 1;
						$('#guest-list div').remove();

						//===Selecting Multiple Calendar

						$('#eventForm fieldset').removeAttr('disabled');

						var dt = new Date();

						var hours   = dt.getHours();
						var minutes = dt.getMinutes();
						if(minutes > 30) minutes = 30;
						else minutes = 0;
						var ehours;
						if(hours > 0) ehours = hours+1;
						if(hours == 0) ehours = hours;
						if(hours == 23) ehours = hours;

						var eminutes;
						if(ehours >= 24) ehours = '0';
						if(hours > 0) eminutes = minutes;
						if(hours == 0) eminutes = '59';
						if(hours == 23) eminutes = '59';

						var mm = date.format('M');
						var dd = date.format('D');
						var yyyy = date.format('YYYY');

						if(parseInt(mm) <= 9) mm = '0'+(parseInt(mm)+0);
						if(parseInt(dd) <= 9) dd = '0'+dd;
						if(parseInt(hours) <= 9) hours = '0'+hours;
						if(parseInt(minutes) <= 9) minutes = '0'+minutes;
						if(parseInt(ehours) <= 9) ehours = '0'+ehours;
						if(parseInt(eminutes) <= 9) eminutes = '0'+eminutes;

						var curDate = yyyy+'-'+mm+'-'+dd+' '+hours+':'+minutes;
						var curDateInput = yyyy+'-'+mm+'-'+dd;

						var shortdateFormat = 'DD-MM-YYYY';
						var longdateFormat = 'dddd, DD MMMM YYYY';
						var title = $.fullCalendar.moment(date).format(longdateFormat+' hh:mm A');
						$('#myModal').modal({backdrop:'static',keyboard:false});
						$('#myModalLabel').html(title);
						$('#myTab a:first').tab('show');
						$('#create-event').html('Create Event');
						$('#update-event').val('');

						//==== resetting fields
						document.getElementById('eventForm').reset();
						$('.checkbox-inline input, #allDay').removeAttr('checked');
						$('.repeat-box').hide();
						$('#hide-standard-settings').click();
						//$('.color-box').removeClass('color-box-selected');
						$('#backgroundColor').val('1');
						$('#repeat_end_on').val('');
						$('#repeat_end_after').val('');
						$('#repeat_never').val('1');
						$('#ends-db-val').datetimepicker('remove');
						$('#ends-db-val').attr('readonly','readonly');
						$('#ends-db-val').removeClass("number");
						$('#files').children('div').remove();

						//====For Agenda Week & Agenda Day
						if(hours > 0 || minutes > 0){

						}

						//====Setting Date Fields
						$('#start-date').val(curDateInput);
						$('#end-date').val(curDateInput);
						$('#repeat_start_date').val(curDateInput);

						//===convert 24 hours to 12 hours format
						var startTime12Format = _formatTimeStr(hours+':'+minutes);
						var endTime12Format = _formatTimeStr(ehours+':'+eminutes);

						$('#start-time').val(startTime12Format);
						$('#end-time').val(endTime12Format);


						//$('#select-calendar').removeAttr('disabled');
						//$('.select-calendar-cls').css('opacity','1');
						// var jqxhr = $.ajax({
							// type: 'POST',
							// url: '/phpeventcal/server/ajax/events_manager.php',
								// data: {action:'LOAD_SELECTED_CALENDAR_FROM_SESSION'},
								// dataType: 'json'
							// })
							// .done(function(selCal) {
								// $('#select-calendar').val(selCal);
								// $('#select-calendar').selectpicker('refresh');
							// })
							// .fail(function() {
							// });

						// var jqxhr = $.ajax({
							// type: 'POST',
							// url: '/phpeventcal/server/ajax/events_manager.php',
								// data: {action:'LOAD_SELECTED_CALENDAR_COLOR'},
							// })
							// .done(function(selCalColor) {

								// $('#backgroundColor').val(selCalColor);
								// var selCalColorData = selCalColor.split('#');
								// var colorID = 'cid_'+selCalColorData[1];
								// $('#'+colorID).click();
							// })
							// .fail(function() {
							// });
					},
					events: settings.EventJson,
					resources: [],
					//================================
					eventSources: [],
					allDayDefault: true,
					ignoreTimezone: true,
					startParam: 'start',
					endParam: 'end',
					lazyFetching: true,
					eventColor: '',
					eventBackgroundColor: '',
					eventBorderColor: '',
					editable: true,
					eventStartEditable: true,
					eventDurationEditable: true,
					dragRevertDuration: 500,
					dragOpacity: 0.2,
					droppable: false,
					dropAccept: '*',
					eventClick: function(calEvent, jsEvent, view) {
						var shortdateFormat = 'DD-MM-YYYY';
						var longdateFormat = 'dddd, DD MMMM YYYY';
						userRole = 'admin';	
						$(".ajax-file-upload-container").remove();
						$("#dvElements input[name=file_drive\\[\\]]").remove();
						
						/*===============================================================*/
						/*=== Load attach
						/*===============================================================*/
						 $("#fileuploader").uploadFile(
								{url: Host + "/do_upload",
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

								},
								onLoad:function(obj)
								{	
									var jsonEvent = {
										"TypeEvent" : "LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID",
										"Event" : {
													eventId : calEvent.id
												}
									}
									
									$.ajax({										
										url: Host + "/do_load",
										dataType: "json",
										type :"POST",
										data:jsonEvent,
										success: function(data) 
										{		
											$.each(data,function(index, data){												
												
												obj.createProgress(data.name,data.path,data.size);
												
												if(typeof data ==  "object"){
													var sInput = '<input type="hidden" name="file_drive[]" data-drive-title="'+data.title +'" data-drive-mimeType="'+data.mimeType +'" data-drive-iconLink="'+data.iconLink +'" data-drive-id="'+data.id+'" data-drive-alternatelink="'+data.alternateLink+'" data-drive-downloadurl="'+data.downloadUrl+'" />';
													$('#dvElements').append(sInput);
												}
												
											});										
											// for(var i=0;i<data.length;i++)
											// {
												// console.log(data);
												// obj.createProgress(data[i]);
											// }
										},
										error:function(jqXHR, textStatus, errorThrown){
											console.log(jqXHR);
											console.log(textStatus);
											console.log(errorThrown);
										}
										
									});
							   }
							 });	
						/*===============================================================*/
						/*=== Load attach
						/*===============================================================*/
						_eventRenderer(calEvent,jsEvent,view,userRole,shortdateFormat,longdateFormat);
					}
				});
			

			});
		},
		/*
		*@Nombre
		*@Varibles
		*@Dependencias
		*@Descripición
		*/
		ShowSettings : function(options){
			
			var settings = $.extend({
                SettingsId: "#show-standard-settings",
				StandardClass: ".standard",
				Linkhide: ".basic .show-link",
				ColorClass : ".color-box",
				ClasColorRemove : "color-box-selected",
				IdColorCal : "#backgroundColor"
            }, options);
			
			return this.each(function(){
					
				$(settings.SettingsId).click(function(){
					$(settings.StandardClass).fadeIn();
					$(settings.Linkhide).hide();
					$(settings.StandardClass).css('display', 'inline-block');
				});
				
				$(settings.ColorClass).click(function () {
					$(settings.ColorClass).html('&nbsp;');
					$(settings.ColorClass).removeClass(settings.ClasColorRemove);
					$(this).addClass(settings.ClasColorRemove);
					$(this).html('&nbsp;✔');
					var cVal = $(this).attr('data-color');
					$(settings.IdColorCal).val(cVal);
				});
				/*=======================*/
				/*=======================*/
				$('.selectpicker').selectpicker();
				/*=======================*/				
				//=====Format Buttons on load
				$('.fc-button-basicDay').removeClass('fc-corner-right');
				$('.fc-button-basicWeek').removeClass('fc-corner-left fc-corner-right');
				$('.fc-button-month').removeClass('fc-corner-left fc-corner-right');
				//$('.fc-button-agendaDay').removeClass('fc-corner-left fc-corner-right');
				$('.fc-button-agendaDay').removeClass('fc-corner-right');
				$('.fc-button-agendaWeek').removeClass('fc-corner-left');
				//===== Formatting Buttons Ends
				/*=======================*/
				var serial = 1

				$('#add-guest').click(function () { //band0
					//=== count existing guest emails
					serial = $('.guest_email').length + 1;
					var guest = $('#guest').val();
					if (_isValidEmailAddress(guest) == false || guest == '') {
						$.bootstrapGrowl("<div style='text-align: left'>Invalid Email</div>", {
							type: 'warning',
							width: 450
						});
						return false;
					}
					//[Dennis 2020-06-26]: comentado para dividir correos a externos.
					//var guestView = "<div id='guest_" + serial + "'> <input class='form-control guest-view guest_email reminder_add_guest_in' id='guest_list_" + serial + "' name='guests[]' value='" + guest + "'><button class='close_guest' aria-hidden='true' data-dismiss='guest' type='button'>×</button></div>";
					var guestView = "<div id='guest_" + serial + "'> <input class='form-control guest-view guest_email reminder_add_guest_in' id='guest_list_" + serial + "' name='guestsExt[]' value='" + guest + "'><button class='close_guest' aria-hidden='true' data-dismiss='guest' type='button'>×</button></div>";
					$('#guest-list').append(guestView);
					$('.close_guest').click(function () {
						$(this).parent().remove();
					});
					$('#guest').val(null);
					serial++;
				});
				$('#guest').keyup(function (jsEventObj) {
					if (jsEventObj.keyCode == 13) {
						$('#add-guest').click();
					}
				});
				//--------------------------------------------------------------------
				//[Dennis 2020-06-10]
				//Cambio de opciones
				$("#idCapacitacion").click(function(){
					$("#tituloCapacitacion").show();
					$("#idSelectCapacitacion").val("0");
					$("#tituloEvento").hide();
					$("#title_capa").val("");
					$("#sub_categoria").hide();
					$(".combo-cat").show();
				});

				$("#idEvento").click(function(){
					$("#tituloEvento").show();
					$("#title").val("");
					$("#tituloCapacitacion").hide();
					$(".combo-cat").hide();
					//$("#contCat").hide();
				});

				$("#idSelectCapacitacion").on("change", function(){
					var valorSelect=$("#idSelectCapacitacion").val();

					$.ajax({
						type:"POST",
						url: Host+"/subCategorias",
						data:{
							"capacitacion":valorSelect
						},
						error: function(){
							alert("Datos no recibidos");
						},
						success:function(data){
							//console.log(JSON.parse(data));
							
							var selectSC=document.getElementById("idSubCategoria");
							selectSC.innerHTML="";
							selectSC.innerHTML+="<option value='0'>Seleccione una sub-categoría</option>"

							var resultado=JSON.parse(data);

							for(var indice in resultado){
								selectSC.innerHTML+=`
									<option value="`+resultado[indice].id_certificado+`">`+resultado[indice].nombreCertificado+`</option>
								`;
							}

							$("#sub_categoria").show();

							if(valorSelect==1 || valorSelect==2){
								$("#ramosCap").show();
							} else{
								$("#ramosCap").hide();
							}
						}
					});
				});

				console.log($("#eventForm").serializeArray());
				//---------------------------------------------------------------------
				//=== Add Organizer
				$('#add_organizer').click(function(){
					$('#selector').hide();
					$('#organizer-input').show();
					$('#add_organizer').hide();
					$('#cancel_organizer').show();
					//$('#new-organizer').val(1);
				});

				//=== Cancel Organizer
				$('#cancel_organizer').click(function(){
					$('#selector').show();
					$('#organizer-input').hide();
					$('#add_organizer').show();
					$('#cancel_organizer').hide();
					//$('#new-organizer').val(0);
				});


				//=== Add Resource
				$('#add_resource').click(function(){
					$('#selector-resource').hide();
					$('#resource-input').show();
					$('#add_resource').hide();
					$('#cancel_resource').show();
					//$('#new-resource').val(1);
				});

				//=== Cancel Resource
				$('#cancel_resource').click(function(){
					$('#selector-resource').show();
					$('#resource-input').hide();
					$('#add_resource').show();
					$('#cancel_resource').hide();
					//$('#new-resource').val(0);
				});

				//=== Add venue
				$('#add_venue').click(function(){
					$('#venue-select').hide();
					$('#venue-holder').show();
					$('#add_venue').hide();
					$('#cancel_venue').show();
				});

				//=== Cancel venue
				$('#cancel_venue').click(function(){
					$('#venue-select').show();
					$('#venue-holder').hide();
					$('#add_venue').show();
					$('#cancel_venue').hide();
				});
				/*=======================*/
				//==== reminder panel setup
				reminder2Obj = $('#reminder2').detach();
				reminder3Obj = $('#reminder3').detach();

				//==== add reminders

				var next_reminder_count;
				$('#add_reminder').click(function () {
					//=== count existing reminders
					next_reminder_count = $('.reminder-group').length + 1;
					if (next_reminder_count == 2) {
						$('.reminder-group').each(function () {
							if (this.id == 'reminder3') {
								reminder2Obj.appendTo("#reminder-holder");
							}
							else if (this.id == 'reminder2') {
								reminder3Obj.appendTo("#reminder-holder");
							}
							else
								reminder2Obj.appendTo("#reminder-holder");
						});
					}
					if (next_reminder_count == 3) {
						$('.reminder-group').each(function () {
							if (this.id == 'reminder3') {
								reminder2Obj.appendTo("#reminder-holder");
							}
							else if (this.id == 'reminder2') {
								reminder3Obj.appendTo("#reminder-holder");
							}
							else
								reminder3Obj.appendTo("#reminder-holder");

						});
					}

				});
				/*=======================*/
				$('#search-btn').click(function () {

					var searchKey = $('#search-event-input').val();
					if (searchKey == '') {
						//=== show a warning message
						$.bootstrapGrowl("<div style='text-align: left'>Invalid or Empty Search Keyword</div>", {
							type: 'warning',
							width: 450
						});

						return false;
					}
					searchEventsBasedOnKeyword(searchKey, this);
				});
				$('#search-event-input').keyup(function (jsEventObj) {
					if (jsEventObj.keyCode == 13) {
						$('#search-btn').click();
					}
				});
				/*=======================*/
				$('.repeat_on_day').click(function () {
					var tid = this.id;
					var tcheck = this.checked;

					if (tid == 'repeat_on_sun' && tcheck == false) repeat_on_sun = 0;
					if (tid == 'repeat_on_sun' && tcheck == true) repeat_on_sun = 1;

					if (tid == 'repeat_on_mon' && tcheck == false) repeat_on_mon = 0;
					if (tid == 'repeat_on_mon' && tcheck == true) repeat_on_mon = 1;

					if (tid == 'repeat_on_tue' && tcheck == false) repeat_on_tue = 0;
					if (tid == 'repeat_on_tue' && tcheck == true) repeat_on_tue = 1;

					if (tid == 'repeat_on_wed' && tcheck == false) repeat_on_wed = 0;
					if (tid == 'repeat_on_wed' && tcheck == true) repeat_on_wed = 1;

					if (tid == 'repeat_on_thu' && tcheck == false) repeat_on_thu = 0;
					if (tid == 'repeat_on_thu' && tcheck == true) repeat_on_thu = 1;

					if (tid == 'repeat_on_fri' && tcheck == false) repeat_on_fri = 0;
					if (tid == 'repeat_on_fri' && tcheck == true) repeat_on_fri = 1;

					if (tid == 'repeat_on_sat' && tcheck == false) repeat_on_sat = 0;
					if (tid == 'repeat_on_sat' && tcheck == true) repeat_on_sat = 1;

				});
				/*=======================*/
				$('#myModal').on('hide.bs.modal', function (e) {
					
					$('#reminder_type_1').val('email');
					$('#reminder_time_1').val('1');
					$('#reminder_time_unit_1').val('minute');

					$('#reminder_type_2').val('email');
					$('#reminder_time_2').val('1');
					$('#reminder_time_unit_2').val('minute');

					$('#reminder_type_3').val('email');
					$('#reminder_time_3').val('1');
					$('#reminder_time_unit_3').val('minute');

					_hideReminder2();
					_hideReminder3();
					$('#guest-list div').remove();
					serial = 1; //reset event reminder guest serial

					// to reset organizer form
					$('#selector').show();
					$('#organizer-input').hide();
					$('#add_organizer').show();
					$('#cancel_organizer').hide();

					// to reset resource form
					$('#selector').show();
					$('#resource-input').hide();
					$('#add_resource').show();
					$('#cancel_resource').hide();

					// to reset venue settings part
					$('#venue-select').show();
					$('#venue-holder').hide();
					$('#add_venue').show();
					$('#cancel_venue').hide();
					$('#hide-venue-settings').click();
				});
				/*=======================*/
				$('#create-event').on('click', function(e) {
					//==== start JS validating
					//var errMsg = '';
					e.preventDefault();
					var errMsg = _validateEventCreateForm(false);
					//==== display error message if there is any error
					if (errMsg != '') {
						$.bootstrapGrowl("<div style='text-align: left'>" + errMsg + "</div>", {
							type: 'warning',
							width: 450
						});
						return false;
					}

				});
				$('#cancel-link').on('click', function(e) {
					//==== start JS validating
					//var errMsg = '';
					e.preventDefault();
					var errMsg = _validateEventCreateForm(true);
					//==== display error message if there is any error
					if (errMsg != '') {
						$.bootstrapGrowl("<div style='text-align: left'>" + errMsg + "</div>", {
							type: 'warning',
							width: 450
						});
						return false;
					}

				});
				/*========================*/
				$('#start-date').datetimepicker({
					startDate: '2016-01-27',
					startView: 2,
					minView: 2,
					maxView: 2,
					autoclose: true,
					todayHighlight: true,
					format: 'yyyy-mm-dd'
				});

				$('#start-time').focus(function () {
					$('#time-panel-end').hide();
					$('#time-panel-start').show();					
				});
				$('#start-time').click(function () {
					$('#time-panel-end').hide();
					$('#time-panel-start').show();					
				});

				$('#time-panel-start ul li').click(function () {
					var selVal = $(this).attr('data-value');
					$('#start-time').val(_formatTimeStr(selVal));

					var selValArray = selVal.split(':');

					if(selValArray[0] != 20){
						if(selValArray[1] == 30)
						{
							selVal = (parseInt(selValArray[0])+1)+':00';
						}else{
							selVal = selValArray[0]+':30';
						}
					}
					
					$('#end-time').val(_formatTimeStr(selVal));
					$('#time-panel-start').hide();
				});


				$('#end-date').datetimepicker({
					startDate: '2016-01-27',
					startView: 2,
					minView: 2,
					maxView: 2,
					autoclose: true,
					todayHighlight: true,
					format: 'yyyy-mm-dd'
				});

				$('#end-time').focus(function () {
					$('#time-panel-start').hide();
					$('#time-panel-end').show();
				});
				$('#end-time').click(function () {
					$('#time-panel-start').hide();
					$('#time-panel-end').show();
					
				});
				$('body').focus(function () {
					setTimeout(function () {
						$('#time-panel-start').hide();
					}, 200)
					setTimeout(function () {
						$('#time-panel-end').hide();
					}, 200)
				});


				$('#time-panel-end ul li').click(function () {
					var selVal = $(this).attr('data-value');
					$('#end-time').val(_formatTimeStr(selVal));

					var endDate = $('#start-time').val();

					var endHour = _timeFrom12To124Hours(endDate);
					var endHourArray = endHour.split(':');

					var selValArray = selVal.split(':');

					if(parseInt(selValArray[0]) <= parseInt(endHourArray[0])){

						if(selValArray[0] != 08){
							if(selValArray[1] == 00)
							{
								selVal = (parseInt(selValArray[0])-1)+':30';
							}else{
								selVal = selValArray[0]+':00';
							}
						}else if(selVal == "08:30"){
							selVal = $('#start-time').val().replace(" AM","");	
							if(selVal === "08:30"){
								selVal = "08:00";
							}
						}

						$('#start-time').val(_formatTimeStr(selVal));
					}

					$('#time-panel-end').hide();
				});

				$('#date-picker').datetimepicker({
					startView: 2,
					minView: 2,
					maxView: 2,
					autoclose: true
				}).on('changeDate', function (ev) {

					//alert(ev.date)
					var startMoment = moment(ev.date).subtract('days', 0); // 0 was 1

					//====Move calendar to the selected date
					$('#calendar').fullCalendar('gotoDate', startMoment);
				});
				/*========================*/
				$('#backgroundColor-control').colorpicker().on('changeColor', function (ev) {
					bodyStyle.backgroundColor = ev.color.toHex();
				});
				$('#backgroundColor').click(function () {
					$('#backgroundColor-control').colorpicker('show');
				});

				$('#borderColor-control').colorpicker().on('changeColor', function (ev) {
					bodyStyle.backgroundColor = ev.color.toHex();
				});
				$('#borderColor').click(function () {
					$('#borderColor-control').colorpicker('show');
				});

				$('#textColor-control').colorpicker().on('changeColor', function (ev) {
					bodyStyle.backgroundColor = ev.color.toHex();
				});
				$('#textColor').click(function () {
					$('#textColor-control').colorpicker('show');
				});
				/*========================*/
				/*========================*/
				$('#show-standard-settings').click(function () {
					$('.standard').fadeIn();
					$('.basic .show-link').hide();
					$('.standard').css('display', 'inline-block');
				});

				$('#hide-standard-settings').click(function () {
					$('.basic .show-link').fadeIn();
					$('.standard').hide();
					//$('.repeat-box').fadeOut();
					//$('.repeat-box').css('display','none');
					//$('#repeat').removeAttr('checked')
				});

				$('#show-reminder-settings').click(function () {
					$('.reminder').fadeIn();
					$('.basic-remind .show-link-remind').hide();
					$('.reminder').css('display', 'inline-block');
				});

				$('#hide-reminder-settings').click(function () {
					$('.basic-remind .show-link-remind').fadeIn();
					$('.reminder').hide();
				});

				$('#show-venue-settings').click(function () {
					$('.venue').fadeIn();
					$('.basic-venue .show-link-venue').hide();
					$('.venue').css('display', 'inline-block');
				});

				$('#hide-venue-settings').click(function () {
					$('.basic-venue .show-link-venue').fadeIn();
					$('.venue').hide();
				});
				//----------------------------------------------------------------
				$('#show-externalEmail-settings').click(function () {
					$('.externalEmail').fadeIn();
					$('.basic-externalEmail .show-link-externalEmail').hide();
					$('.externalEmail').css('display', 'inline-block');
				});

				$('#hide-externalEmail-settings').click(function () {
					$('.basic-externalEmail .show-link-externalEmail').fadeIn();
					$('.externalEmail').hide();
				});

				$('#show-category-event-settings').click(function () {
					$('.category-event').fadeIn();
					$('.basic-category-event .show-link-category-event').hide();
					$('.category-event').css('display', 'inline-block');
				});

				$('#hide-category-event-settings').click(function () {
					$('.basic-category-event .show-link-category-event').fadeIn();
					$('.category-event').hide();
				});


				//----------------------------------------------------------------
				/*========================*/
				$('#start-date').change(function () {
					var thisDate = $(this).val();
					$('#end-date').val(thisDate);

					//==== set repeat options
					$('#repeat_start_date').val(thisDate);
					_setRepeatOptionsForDays(thisDate);
				});
				/*========================*/
				var repeatChecked = false;
				$('#repeat').click(function () {
					if (this.checked) {
						repeatChecked = true;
						$('.repeat-box').fadeIn();
						$('.repeat-box').css('display', 'inline-table');
						$('#repeat_type').val('daily');
						$('#repeat_on_group').hide();
						//_setRepeatOptionsForDays($('#start-date').val());
					}
					else {
						repeatChecked = false;
						$('.repeat-box').fadeOut();
						$('.repeat-box').css('display', 'none');
					}
					//$('#repeat_on_group').hide();
				});
				/*========================*/
				var endsParamSelected = 'Never';
				$('.ends-params').click(function () {
					var endsVal = $(this).attr('data-value');
					var endsText = $(this).attr('data-text');
					// ==setting label
					$('#ends-status').html(endsText);

					// ===resetting
					$('#ends-after-label').css('display', 'none');
					$('#repeat_end_on').val('');
					$('#repeat_end_after').val('');
					$('#repeat_never').val('');
					$('#ends-db-val').val('');
					
					endsParamSelected = endsVal;
					switch (endsVal) {
						case 'On':
							$('#ends-db-val').datetimepicker({
								startView: 2,
								minView: 2,
								maxView: 2,
								autoclose: true,
								todayHighlight: true,
								format: 'yyyy-mm-dd'
							});
							$('#ends-db-val').removeAttr('readonly');
							// $('#repeat_end_on').val('');
							break;
						case 'Never':
							$('#ends-db-val').datetimepicker('remove');
							$('#ends-db-val').attr('readonly', 'readonly');
							$('#repeat_never').val('1');
							break;
						case 'After':
							$('#ends-db-val').datetimepicker('remove');
							$('#ends-db-val').removeAttr('readonly');
							$('#ends-db-val').addClass('number');
							// $('#repeat_end_after').val('');
							$('#ends-after-label').css('display', 'inline-block');
							break;
					}
				});
				/*========================*/
				$('#ends-db-val').change(function () {
					var endsDBVal = $('#ends-db-val').val();
					
					switch (endsParamSelected) {
						case 'On':
							$('#repeat_end_on').val(endsDBVal);
							break;
						case 'Never':
							$('#repeat_never').val('1');
							break;
						case 'After':
							$('#repeat_end_after').val(endsDBVal);
							break;
					}
				});
				/*
				* Cambio de las repeticiones
				*/
				$('#repeat_type').change(function () {
					var repeatType = $(this).val();
					var intervalLabel = 'Semana(s)';
					$('#repeat_interval_group').show();
					$('#repeat_on_group').show();
					$('#repeat_by_group').hide();
					$('.repeat_by').removeAttr('checked');
					//$('#repeat_on_wed').removeAttr('checked');

					switch (repeatType) {
						case 'daily':
							$('#repeat_on_group').hide();
							intervalLabel = 'Dia(s)';
							break;
						case 'everyWeekDay':
							intervalLabel = '';
							$('#repeat_interval_group').hide();
							$('#repeat_on_group').hide();
							break;
						case 'everyMWFDay':
							intervalLabel = '';
							$('#repeat_interval_group').hide();
							$('#repeat_on_group').hide();
							break;
						case 'everyTTDay':
							intervalLabel = '';
							$('#repeat_interval_group').hide();
							$('#repeat_on_group').hide();
							break;
						case 'weekly':
							intervalLabel = 'Semana(s)';
							//$('#repeat_on_wed').attr('checked','checked');
							_setRepeatOptionsForDays($('#start-date').val());
							break;
						case 'monthly':
							$('#repeat_on_group').hide();
							$('#repeat_by_group').show();
							$('#repeat_by_day_of_the_month').click();
							intervalLabel = 'Mes(es)';
							break;
						case 'yearly':
							intervalLabel = 'Año(s)';
							$('#repeat_on_group').hide();
							break;
						case 'none':
						default :
							$('#repeat_on_group').hide();
							intervalLabel = 'Days';
							break;
					}
					$('#repeat_interval_label').html(intervalLabel);
				});
				
				/*============================*/
				$('#allDay').change(function () {
					if (this.checked) {
						$('#end-group').hide();
					}
					else {
						$('#end-group').show();
					}
				});
			});	

		},
		CreateCalendar : function(){
			
			var settings = $.extend({
                CalendarButtonId: '#create-calendar',
				CalName: '#name',
				ModalNameFormId: "#myModalCalendarCreateFrom",
				ColorClass : ".color-box",
				ClasColorRemove : "color-box-selected",
				IdColorCal : "#backgroundColor"
            }, options);
			
			return this.each(function(){
				
				$(settings.CalendarButtonId).click(function () {
					
					var calName = $(settings.CalName).val();
					
					if (calName == '') {
						$.bootstrapGrowl("<div style='text-align: left'>El nombre del calendario es requerido</div>", {
							type: 'warning',
							width: 450
						});

						return false;
					}

					var formData = $(settings.ModalNameFormId).serializeArray();

					var jqxhr = $.ajax({
						type: "POST",
						url: "/phpeventcal/server/ajax/calendar_manager.php",
						data: formData
					})
					.done(function (calJSON) {
						
						var uid = $('#update-calendar').val();
						var calData = $.parseJSON(calJSON);
						var calName = calData.name;
						var calID = calData.id;
						var calColor = calData.color;

						if (parseInt(uid) > 0) {
							//edit calendar

						}
						else {
							console.log("1 - ladda-label");
							var calContent = '<a href="javascript:void(0);" class="list-group-item ladda-button new-cal" data-style="expand-right" style="background-color: ' + calColor + '; color:white;" id="' + calID + '" ><span class="ladda-label">' + calName + '</span></a>';
							$('#my-calendars div.list-group').append(calContent);
							$('.new-cal').click();
							$('.new-cal').removeClass('new-cal');
						}
						
						$('#myModalCalendarCreate').modal('hide');
						
						$.bootstrapGrowl("Calendario creado correctamente", {
							type: 'success',
							width: 350
						});

						setTimeout(function () {
							location.href = 'index.php';
						}, 2000);

					})
					.fail(function () {
						$.bootstrapGrowl("Ocurrio algun error intenta mas tarde", {
							type: 'danger',
							width: 350
						});
					})
				});
			});
		},
		CreateEvent : function(options){
			
			var settings = $.extend({
                EventButtonId: '#create-new-event',
				CalName: '#name',
				ModalNameFormId: "#myModalCalendarCreateFrom",
				ColorClass : ".color-box",
				ClasColorRemove : "color-box-selected",
				IdColorCal : "#backgroundColor"
            }, options);
			
			return this.each(function(){
				
				$(settings.EventButtonId).click(function () {
					
					console.log("test - test");
					//==== Recuepar valores del calendario ====//
					// #repeat
					//==== Recuepar valores del calendario ====//
					
					//==== show this panel if it is hidden
					$('#end-group').show();
					$('#remove-block').hide();

					var dt = new Date();

					var mm = dt.getMonth();
					var dd = dt.getDate();
					var yyyy = dt.getFullYear();

					var hours = dt.getHours();
					var minutes = dt.getMinutes();
					if (parseInt(mm) <= 9) mm = '0' + (parseInt(mm)+1);
					if (parseInt(dd) <= 9) dd = '0' + dd;
					if (minutes > 30) minutes = 30;
					else minutes = 0;
					var ehours = hours + 1;
					if (ehours >= 24) ehours = '0';
					var eminutes = minutes;
					if (parseInt(minutes) <= 9) minutes = '0' + minutes;
					if (parseInt(ehours) <= 9) ehours = '0' + ehours;
					if (parseInt(eminutes) <= 9) eminutes = '0' + eminutes;

					var curDate = yyyy + '-' + mm + '-' + dd + ' ' + hours + ':' + minutes;
					var curDateInput = yyyy + '-' + mm + '-' + dd;

					//===Selecting Multiple Calendar
					$('#eventForm fieldset').removeAttr('disabled');

					$('#myModal').modal({backdrop: 'static', keyboard: false});
					
					//Texto de las etiquetas
					$('#myModalLabel').html('Crear nuevo evento');
					$('#myTab a:first').tab('show');
					$('#create-event').html('Crear evento');
					$('#update-event').val('');

					//==== resetting fields
					document.getElementById('eventForm').reset();
					$('.checkbox-inline input, #allDay').removeAttr('checked');
					$('.repeat-box').hide();
					$('#hide-standard-settings').click();
					$('#hide-venue-settings').click();
					//$('.color-box').removeClass('color-box-selected');
					$('#backgroundColor').val('1');
					$('#repeat_end_on').val('');
					$('#repeat_end_after').val('');
					$('#repeat_never').val('1');
					$('#ends-db-val').datetimepicker('remove');
					$('#ends-db-val').attr('readonly', 'readonly');

					//====Setting Date Fields
					$('#start-date').val(curDateInput);
					$('#end-date').val(curDateInput);
					$('#repeat_start_date').val(curDateInput);
					$('#start-time').val(hours + ':' + minutes);
					$('#end-time').val(ehours + ':' + eminutes);


					var jqxhr = $.ajax({
						type: 'POST',
						url: '/phpeventcal/server/ajax/events_manager.php',
						data: {action: 'LOAD_SELECTED_CALENDAR_FROM_SESSION'},
						dataType: 'json'
					})
					.done(function (selCal) {
						//====setting up values
						$('.selectpicker').selectpicker('val', selCal);
					})
					.fail(function () {
					});

					var jqxhr = $.ajax({
						type: 'POST',
						url: '/phpeventcal/server/ajax/events_manager.php',
						data: {action: 'LOAD_SELECTED_CALENDAR_COLOR'}
					})
					.done(function (selCalColor) {
						//====setting up values
						$('#backgroundColor').val(selCalColor);
						var selCalColorData = selCalColor.split('#');
						var colorID = 'cid_' + selCalColorData[1];
						$('#' + colorID).click();
					})
					.fail(function () {
					
					});

				});


			});
		},
		DeleteEvent : function(options){
			
			var settings = $.extend({
                EventButtonId: '#remove-link',
				EventId: 'data-event-id',
				CalendarId : '#calendar',
				ModalId : '#myModal',
				TextSucces: "Evento eliminado correctamente",
				TextDanger: "Ocurio un error al eliminar el evento",
				enviarNotificacion : true
            }, options);
			
			
			return this.each(function(){
				
				$(settings.EventButtonId).click(function () {
					var l = Ladda.create(this);
					l.start();
					var instance = false;
					var eid = $(this).attr(settings.EventId);					
					
					if (eid.toLowerCase().indexOf("_") >= 0){
						eid_ = eid.split("_")[0];
						instance = true;	
					}
					
					if(instance){
						var r = confirm("Existen multiples instancias del evento a eliminar, desea eliminar las multiples instancias?");
						if (r == true) {
							eid = eid_;
							x = true;
						} else {
							x = false;
						}
					}else x = false;

					$.post( Host + "/eliminar_evento",
						
						{ Event : { eventId: eid, enviarNotificacion : settings.enviarNotificacion,eliminarInstancias : x }, TypeEvent : 'REMOVE_THIS_EVENT'},
						
						function (eventJSON) {										
							
						}, "json")
						.always(function (eventJSON) {

							//console.log(eventJSON);
														
							if(jQuery.isEmptyObject(eventJSON)){
								
								$(settings.CalendarId).fullCalendar('removeEvents', eid);
							
								$(settings.ModalId).modal('hide');
								
								$.bootstrapGrowl("<div style='text-align: left'> Evento eliminado correctamente! </div>", {
									type: 'success',
									width: 450
								});
								
								if(x){
									setTimeout(function () {
										location.reload();
									}, 1000)
								}
								
							}else{							
							
								$(settings.ModalId).modal('hide');
								
								$.bootstrapGrowl("<div style='text-align: left'>" + settings.TextDanger + "</div>", {
									type: 'danger',
									width: 450
								});
								
							}
							
							
							l.stop();

						}, "json");
				});				
			});			
		},
		CancelarEventoOrganizer : function(options){
			
		},
		MostarCorreos1 : function(options){
			var settings = $.extend({
                EventButtonId: '#add-email',
				PromotorVendedor : "#add-promotor-vendedor",
				Data: {}
            }, options);
			
			return this.each(function(){
						
				$(settings.EventButtonId).append( _CreateDomForEmail("Todos los Usuarios del Sistema" ,"todos","") );
				
				$.each(settings.Data,function(  index, items ) {
					
					// console.log(items);
					
					$.each(items.gerente,function(index,item){
						
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Gerentes" ,"gerente","") );
						tabla = "";
						tabla += _CreateTableEmailHead("gerente");
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);					
						
					});
					$.each(items.ejecutivo,function(index,item){
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Ejecutivos " ,"ejecutivo","") );
						tabla = "";
						tabla += _CreateTableEmailHead("ejecutivo");
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);	
					});
					$.each(items.promotor,function(index,item){
						
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Promotores " ,"promotor","") );
						tabla = "";
						tabla += _CreateTableEmailHead("promotor");
						$.each(item[0],function(index,valores){	
							// console.log(valores);
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);						
					});				
					
					$.each(items.vendedor,function(index,item){
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Vendedores " ,"vendedor","") );
						tabla = "";
						tabla += _CreateTableEmailHead("vendedor");
						
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados " , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);	
					});
					
					
					$.each(items.promotor,function(index,item){
						$.each(item[0],function(index,valores){	
						
							$(settings.PromotorVendedor).append( _CreateDomForEmail("Invitados vendedores del promotor " + valores.username ,valores.id,"") );
							tabla = "";
							tabla += _CreateTableEmailHead(valores.id);
							$.each(valores.Vendedores,function(index,valor){
								$.each(valor,function(index,val){
									tabla += _CreateTableEmailTr("Invitados" , val,"test" );							
								
								});							
							});
							
							tabla += _CreateTableEmailFooter();
							$(settings.PromotorVendedor).append(tabla);	
						});						
					});	

				});
				
				$(".show-table").on("click",function(){
					var alias = $(this).attr("data-alias");					
					
					if( $("#" + alias).is(":visible") ){
						$("#" + alias).css("display","none");
					}else{
						$("#" + alias).css("display","block");
					}				
				});

				$('.search-invited').click(function () {
					//=== count existing guest emails
					 data_value = $(this).attr("data-alias");
					 data_id = $(this).attr("data-id");
					 
					 if (data_value === undefined) {
						 var guestView = "";
						 data_value = $(this).attr("data-email");
						 if($(this).is(':checked')){							 
							 guestView += "<input class='guest_" + data_id +"' name='guests[]' value='" + data_value + "'>";
							 $("#guest-list-gap").append(guestView);	
						 }else{
							$(".guest_" + data_id).remove(); 
						 }
						 
					 }else{	
						if($(this).is(':checked')){
							if(data_value == "todos"){
								
								var email = $(".table-email-gap").find(".emailGap");
								var guestView = "";
								$.each(email,function(index,item){
									guestView += "<input class='guest_" + data_value +"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
								});
								$("#guest-list-gap").append(guestView);	
								
							}else{													
								
								var email = $("#" + data_value).find(".emailGap");								
								var guestView = "";
								$.each(email,function(index,item){
									guestView += "<input class='guest_" + data_value +"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
								});
								$("#guest-list-gap").append(guestView);	
							}

						}else{
							if(data_value == "todos"){
								// var email = $(".table-email-gap").find(".emailGap");
								// var guestView = "";
								// $.each(email,function(index,item){
									// guestView += "<input class='' name='guests[]' value='" + $(item).attr("data-email") + "'>";
								// });
								$(".guest_" + data_value).remove();						
							}else{
								$(".guest_" + data_value).remove();	
							}
						} 
					 }				
					
					// var guest = $('#guest').val();
					// if (_isValidEmailAddress(guest) == false || guest == '') {
						// $.bootstrapGrowl("<div style='text-align: left'>Invalid Email</div>", {
							// type: 'warning',
							// width: 450
						// });
						// return false;
					// }
					// var guestView = "<div id='guest_" + serial + "'> <input class='form-control guest-view guest_email reminder_add_guest_in' id='guest_list_" + serial + "' name='guests[]' value='" + guest + "'><button class='close_guest' aria-hidden='true' data-dismiss='guest' type='button'>×</button></div>";
					// $('#guest-list').append(guestView);
					// $('.close_guest').click(function () {
						// $(this).parent().remove();
					// });
					// $('#guest').val(null);
					// serial++;
				});
			});
		},		
		MostarCorreos : function(options){
			var settings = $.extend({
                EventButtonId: '#add-email',
				PromotorVendedor : "#add-promotor-vendedor",
				Data: {}
            }, options);
			
			return this.each(function(){
						
				 $(settings.EventButtonId).append( _CreateDomForEmail("Todos los Usuarios del Sistema" ,"todos","") );
				
				// console.log(settings.Data[3].vendedor);
				// console.log(settings.Data[2].promotor);
				// console.log(settings.Data[1].ejecutivo);
				// console.log(settings.Data[0].gerente);
				
				// $.each(settings.Data,function(  index, items ) {
					
					// console.log(items);
					
					$.each(settings.Data[0].gerente,function(index,item){
						
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Gerentes" ,"gerente","") );
						tabla = "";
						tabla += _CreateTableEmailHead("gerente");
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);					
						
					});
					$.each(settings.Data[1].ejecutivo,function(index,item){
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Ejecutivos " ,"ejecutivo","") );
						tabla = "";
						tabla += _CreateTableEmailHead("ejecutivo");
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);	
					});
					$.each(settings.Data[2].promotor,function(index,item){
						
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Promotores " ,"promotor","") );
						tabla = "";
						tabla += _CreateTableEmailHead("promotor");
						
						$.each(item,function(index,valores){	
							tabla += _CreateTableEmailTr("Invitados" , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);						
					});				
					
					$.each(settings.Data[3].vendedor,function(index,item){
						$(settings.EventButtonId).append( _CreateDomForEmail("Invitados Vendedores " ,"vendedor","") );
						tabla = "";
						tabla += _CreateTableEmailHead("vendedor");
						
						$.each(item,function(index,valores){							
							tabla += _CreateTableEmailTr("Invitados " , valores,"" );							
						})
						tabla += _CreateTableEmailFooter();
						$(settings.EventButtonId).append(tabla);	
					});
					
					
					$.each(settings.Data[2].promotor,function(index,item){
						
						
						$.each(item,function(index,valores){

						
							$(settings.PromotorVendedor).append( _CreateDomForEmail("Invitados vendedores del promotor " + valores.username ,valores.id,"") );
							tabla = "";
							tabla += _CreateTableEmailHead(valores.id);
							$.each(valores.Vendedores,function(index,valor){
								console.log(valor);
								//$.each(valor,function(index,val){
									tabla += _CreateTableEmailTr("Invitados" , valor,"test" );							
								
								//});							
							});
							
							tabla += _CreateTableEmailFooter();
							$(settings.PromotorVendedor).append(tabla);	
						});						
					});	

				// });
				
				$(".show-table").on("click",function(){
					
					var alias = $(this).attr("data-alias");	
					if( $("#" + alias).is(":visible") ){
						$("#" + alias).css("display","none");
					}else{
						$("#" + alias).css("display","block");
					}				
				});

				$('.search-invited').click(function () {
					
					 data_value = $(this).attr("data-alias");
					 data_id = $(this).attr("data-id");
					 
					 if (data_value === undefined) {
						 var guestView = "";
						 data_value = $(this).attr("data-email");
						 if($(this).is(':checked')){							 
							 guestView += "<input class='guest_" + data_id +"' name='guests[]' value='" + data_value + "'>";
							 $("#guest-list-gap").append(guestView);	
						 }else{
							$(".guest_" + data_id).remove(); 
						 }
						 
					 }else{
						if($(this).is(':checked')){
							if(data_value == "todos"){
								
								var email = $(".table-email-gap").find(".emailGap");
								var guestView = "";
								$.each(email,function(index,item){
									guestView += "<input class='guest_" + data_value +"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
								});
								$("#guest-list-gap").append(guestView);	
								
							}else{													
								
								var email = $("#" + data_value).find(".emailGap");								
								var guestView = "";
								$.each(email,function(index,item){
									guestView += "<input class='guest_" + data_value +"' name='guests[]' value='" + $(item).attr("data-email") + "'>";
								});
								$("#guest-list-gap").append(guestView);	
							}

						}else{
							if(data_value == "todos"){
								$(".guest_" + data_value).remove();						
							}else{
								$(".guest_" + data_value).remove();	
							}
						} 
					 }		
				});
			});
		},	
		BuscarInvitados : function(options){
			var settings = $.extend({
				data_id :"0"
			});
			
			return this.each(function(){
				
			});
		},
		
	}
	function _CreateDomForEmail(description,alias,item){
		
		// console.log(item);
		html = "";
		texto = "Todos los ";
		if(description == "Todos los Usuarios del Sistema"){
			texto="";
		}
		
		html +=	"<div class='checkbox'>" +
				"<label>" +
					"<input type='checkbox' name='emailGap[]' data-alias='" + alias + "' class='search-invited'>" +
					"<span data-alias='" + alias + "'>" + texto + description + "</span>" +
				"</label>" +
				"</div>";	
				
		if(description != "Todos los Usuarios del Sistema")
			html += "<span class='show-table' data-alias='" + alias + "'>" + description + "</span>"
	
		return html;
		
	} 
	
	function _CreateTableEmailTr(description,item,test){
				
		html = "<tr>"+
					"<th scope=\"row\">" +
						"<div class='checkbox'>" +
							"<label>" +
								"<input type='checkbox' class='search-invited' data-email='" + item.email + "' data-id='" + item.id + "'>" +					
								"<input type='hidden' data-email='" + item.email + "' data-id='" + item.id + "' class='emailGap'>" +					
							"</label>" +
						"</div>"+
					"</th>"+
					"<td>" + item.username + "</td>" +
					"<td>" + item.email + "</td>" + 
				"<tr/>";
		
		return html;
		
		
	}

	function _CreateTableEmailHead( alias ){

	html = "<div class=\"table-responsive\">"+
				  "<table class=\"table table-email-gap\"  id=\"" + alias + "\" style='display:none'>"+
					"<thead><tr>" +
						"<th>#</th>" + 
						"<th>Usuario</th>" + 
						"<th>Correo</th>" + 
						"</tr></thead>" +
						"<tbody>";				
						
		return html;				

	}
	function _CreateTableEmailFooter(){
		html = 	"</tbody>"+
				  "</table>"+
				"</div>";
		return html;
	}
    function _eventRenderer(calEvent,jsEvent,view,userRole,shortdateFormat, longdateFormat){
				userRole = "";
				console.log("_eventRenderer");
				console.log(calEvent);
				$('#cancel-block').hide();
				$('#cancel-link').attr('data-event-id',calEvent.id);
				$('#remove-block').hide();
				$('#remove-link').attr('data-event-id',calEvent.id);				
				$('#eventForm fieldset').removeAttr('disabled');
				
				var allDay 				= $('#allDay').prop('checked');
				var end_time_ 			= "";
				end_time_  = $('#end-time').val();
				document.getElementById('eventForm').reset();

				//===Clearing Reminder Settings Panel
				$('#hide-reminder-settings').click();
				$('#hide-externalEmail-settings').click();
				$('#hide-category-event-settings').click();
				serial = 1;
				
				$('#guest-list div').remove();

				//===get current view
				var view = $('#calendar').fullCalendar('getView');
				
				$('#currentView').val(view.name);

				$('.basic').show();
				$('.standard').hide();
				$('.repeat-box').fadeOut();
				$('.repeat-box').css('display','none');
				$('#repeat').removeAttr('checked')
				$('#show-link').show();
				$('#repeat_by_group').hide();
				
				var jsonEvent = {
					"TypeEvent" : "LOAD_SINGLE_EVENT_BASED_ON_EVENT_ID",
					"Event" : {
								eventId : calEvent.id
								}
				}
				
				
				// traer el evento id
				var jqxhr = $.ajax({
					type: 'POST',					
					url: Host + '/load_event_id',
					data: jsonEvent,
					dataType: 'json'
				})
				.done(function(ed) {
					
					//console.log(ed.clasificacion);
					var organizer = $('.email-organizer').val();
					var json_id_cal = $('.json-event-for-email').val();
					$json = $.parseJSON(json_id_cal);
					
					$.each($json,function(index,item){
						
						var id_eval = calEvent.id;
						if (calEvent.id.toLowerCase().indexOf("_") >= 0){
							id_eval = calEvent.id.split("_")[0];
						}
						if(item.cal_id == id_eval){
							userRole = "admin";
						}
					});
					
					$('#guest-list-google').html('');
					//poder scrollerar
					$('#myModal').modal({backdrop:'static',keyboard:false});
					
					var modalTitle = 'Editar Evento: <b>' + 
						calEvent.title.toUpperCase() + '</b> <br >' +  
						$.fullCalendar.moment(ed.start_date+' '+ed.start_time).format(longdateFormat+' hh:mm A') +
						" - " +  $.fullCalendar.moment(ed.end_date+' '+ed.end_time).format(longdateFormat+' hh:mm A');	

					if(end_time_ == ""){	
						if(ed.allDay == true){	
							if(!ed.end_date){
								modalTitle = 'Editar Evento: <b>' + 
								calEvent.title.toUpperCase() + '</b> <br >' +  
								$.fullCalendar.moment(ed.start_date+' '+ed.start_time).format(longdateFormat+' hh:mm A');
							}							 	
						}			
					}else if(!calEvent.end){
						if(calEvent.allDay == true){	
							if(!calEvent.end_date){
								modalTitle = 'Editar Evento: <b>' + 
								calEvent.title.toUpperCase() + '</b> <br >' +  
								$.fullCalendar.moment(ed.start_date+' '+ed.start_time).format(longdateFormat+' hh:mm A');
							}							 	
						}
					}


					console.log(modalTitle);
					//-----------------------------------------------------------------------
					//[Dennis 2020-06-11]
					if(ed.clasificacion=="capacitacion"){
						$("#tituloCapacitacion").show();
						$('#idSelectCapacitacion').val(0);
						$("#idCapacitacion").prop("checked", true);
						$("#tituloEvento").hide();
						$(".combo-cat").show();
						$('#title_cap').val(calEvent.title);
					}

					if(ed.clasificacion=="estandar" || ed.clasificacion==null){
						$('#title').val(calEvent.title);
						$("#tituloEvento").show();
						$("#idEvento").prop("checked");
						$("#tituloCapacitacion").hide();
						$(".combo-cat").hide();
						//$("#contCat").hide();
						$('#title').val(calEvent.title);
					}
					//-----------------------------------------------------------------------


					$('#myModalLabel').html(modalTitle);					
					$('#myTab a:first').tab('show');
					// ====setting up values
					/*$('#title').val(calEvent.title);*/ //[Comentado por Dennis 2020-06-11]
					
					var startMoment = moment(ed.start_date+' '+ed.start_time);	
					
					$('#start-date').val(startMoment.format('YYYY-MM-DD'));					
					$('#start-time').val(startMoment.format('hh:mm A'));					
					var endMiliseconds = Date.parse(calEvent.end);					
					var endMoment = '';
					
					
					
					//endMoment = moment(ed.end);
					endMoment = moment(ed.end_date+' '+ed.end_time);	

					// if(ed.end == null && ( ed.allDay != 'on'  )){
					if(ed.end == null && ( ed.allDay != true  )){
						if(ed.end_date == null || ed.end_date == '' || calEvent.end == null){
							
							
							var dePrepDate = ed.start_date.split('-');
							var dePrepTime = ed.start_time.split(':');
							var dePrep = new Date(dePrepDate[0],dePrepDate[1]-1,dePrepDate[2],parseInt(dePrepTime[0])+1,dePrepTime[1],0,0);
							endMoment = moment(dePrep)
						}
						else {

							var dePrepDate = ed.end_date.split('-');
							var dePrepTime = ed.end_time.split(':');
							var dePrep = new Date(dePrepDate[0],dePrepDate[1],dePrepDate[2],dePrepTime[0],dePrepTime[1],0,0);
							endMoment = moment(dePrep)
						}
					}					
										
					if(ed.end != null){						
						
						$('#end-date').val(endMoment.format('YYYY-MM-DD'));
						$('#end-time').val(endMoment.format('hh:mm A'));
					}				
					//calEvent.allDay == 'on' || calEvent.allDay == true || 

					if(ed.allDay == 'on' || ed.allDay == true) {

						if(ed.end == null){
							$('#end-group').hide();
						}
						
						$('#allDay').attr('checked','checked');
					}					
					else {
						
						$('#end-group').show();
						$('#allDay').removeAttr('checked');
					}

					$('#url').val(calEvent.url);
					$('#backgroundColor').val(calEvent.backgroundColor);
					$('#borderColor').val(calEvent.borderColor);
					$('#textColor').val(calEvent.textColor);

					if(calEvent.image == null || calEvent.image == ""){
						$('#files').children('div').remove();
					}
					else{
						$('#imageName').val(calEvent.image);
						var imgHtml = '<div><img style="height: 100px; width: 100px;" src="uploads/'+calEvent.image+'" alt="No Image" /></div>';
						$('#files').children('div').remove();
						$('#files').append(imgHtml);
					}
					
					var thumb = (calEvent.thumbnail == 1) ? 'yes' : 'no';
					$('#thumbnail_'+thumb).attr('checked','checked');

					$('#create-event').html('Actualizar evento');
					$('#update-event').val(calEvent.id);
					// alert(calEvent.id)


					// ====setting data from AJAX load
					$('#repeat_type').val('none');
					$('#repeat_interval').val('1');
					$('#repeat_on_mon').removeAttr('checked');
					$('#repeat_on_sun').removeAttr('checked');
					$('#repeat_on_tue').removeAttr('checked');
					$('#repeat_on_wed').removeAttr('checked');
					$('#repeat_on_thu').removeAttr('checked');
					$('#repeat_on_fri').removeAttr('checked');
					$('#repeat_on_sat').removeAttr('checked');
					$('#repeat_on_group').hide();

					$('#ends-status').html('Never');

					$('#repeat_start_date').val(ed.start_date);

					
					
					if(ed.repeat_type =='none' || ed.repeat_type == null || ed.repeat_type == false) {
						//no se realiza nada 
					}
					else {
						// ==== If it is repeat event then get the date from eventClick Object
						var startMoment = moment(calEvent.start)
						$('#start-date').val(startMoment.format('YYYY-MM-DD'));
						$('#start-time').val(startMoment.format('hh:mm A'));

						var repeatType = ed.repeat_type;
						var intervalLabel = 'Semana(s)';
						$('#repeat_interval_group').show();
						$('#repeat_on_group').show();

						switch (repeatType){
							case 'daily':
								$('#repeat_on_group').hide();
								intervalLabel = 'Days';
								break;
							case 'everyWeekDay':
								intervalLabel = '';
								$('#repeat_interval_group').hide();
								$('#repeat_on_group').hide();
								break;
							case 'everyMWFDay':
								intervalLabel = '';
								$('#repeat_interval_group').hide();
								$('#repeat_on_group').hide();
								break;
							case 'everyTTDay':
								intervalLabel = '';
								$('#repeat_interval_group').hide();
								$('#repeat_on_group').hide();
								break;
							case 'weekly':
								intervalLabel = 'Semana(s)';
								// $('#repeat_on_wed').attr('checked','checked');
								break;
							case 'monthly':
								intervalLabel = 'Months';
								$('#repeat_by_group').show();
								$('#repeat_on_group').hide();
								if(ed.repeat_by == 'repeat_by_day_of_the_month') $('#repeat_by_day_of_the_month').click();
								if(ed.repeat_by == 'repeat_by_day_of_the_week') $('#repeat_by_day_of_the_week').click();

								break;
							case 'yearly':
								intervalLabel = 'Years';
								$('#repeat_on_group').hide();
								break;
							case 'none':
							default :
								var intervalLabel = 'Semana(s)';
								break;
						}
						$('#repeat_interval_label').html(intervalLabel);

						// $('#show-standard-settings').click();
						$('#repeat').click();
						$('#repeat_type').val(ed.repeat_type);

						if(ed.repeat_type == 'weekly')$('#repeat_on_group').show();

						$('#repeat_interval').val(ed.repeat_interval);
						if(ed.repeat_on_sun == '1') $('#repeat_on_sun').click();
						if(ed.repeat_on_mon == '1') $('#repeat_on_mon').click();
						if(ed.repeat_on_tue == '1') $('#repeat_on_tue').click();
						if(ed.repeat_on_wed == '1') $('#repeat_on_wed').click();
						if(ed.repeat_on_thu == '1') $('#repeat_on_thu').click();
						if(ed.repeat_on_fri == '1') $('#repeat_on_fri').click();
						if(ed.repeat_on_sat == '1') $('#repeat_on_sat').click();

						$('#repeat_start_date').val(ed.repeat_start_date);
						if(ed.repeat_end_on != '0000-01-01') {
							$('#repeat_end_on').val(ed.repeat_end_on);
							$('#ends-db-val').removeAttr('readOnly');
							$('#ends-db-val').val(ed.repeat_end_on);
							$('#repeat_never').val('');
							$('#ends-status').html('On');
						}
						if(ed.repeat_end_after != '0') {
							$('#repeat_end_after').val(ed.repeat_end_after);
							$('#ends-db-val').removeAttr('readOnly');
							$('#ends-db-val').val(ed.repeat_end_after);
							$('#repeat_never').val('');
							$('#ends-status').html('After');
						}
						if(ed.repeat_never != '0') {
							$('#repeat_end_after').val(ed.repeat_end_after);
							$('#ends-db-val').attr('readOnly','readOnly');
							$('#ends-db-val').removeAttr('value');
							$('#repeat_never').val('1');
							$('#ends-status').html('Never');
						}
					}
					if(ed.allDay == 'on'){
						// $('#show-standard-settings').click();
					}

					// ====setting up selected calendar values
					$('#select-calendar').selectpicker('val', [ed.cal_id]);
					// $('.select-calendar-cls').css('opacity','0.35');
					// $('#select-calendar').attr('disabled','disabled');

					
					$('#location').val(ed.location);
					$('#url').val(ed.url);					
					$('#description').val(ed.description);
					$('#backgroundColor').val(ed.backgroundColor);
					$('.color-box-selected').html(' ');
					$('.color-box').removeClass('color-box-selected');

					
					
					$('.color-box').each(function (){
						var cv = $(this).attr('data-color');
						if(cv == ed.backgroundColor) {
							$(this).addClass('color-box-selected');
							$(this).html('&nbsp;✔');
						}
					});
					
					
					$('#select-organizer').selectpicker('val', ed.organizer);
					$('#select-resource').selectpicker('val', ed.resource);
					$('#select-venue').selectpicker('val', ed.venue);
					
					
					$('#reminder_type').val(ed.reminder_type);
					$('#reminder_time').val(ed.reminder_time);
					$('#reminder_time_unit').val(ed.reminder_time_unit);
					$('#free_busy').val(ed.free_busy);
					$('#privacy').val(ed.privacy);

					// ====User Previlleged section
					// ===============================================
					// ====Add event remove link
					if(userRole == 'super' || userRole == 'admin'){
						$('#cancel-block').fadeIn(2500);
						$('#cancel-link').attr('data-event-id',calEvent.id);
						$('#remove-block').fadeIn(2500);
						$('#remove-link').attr('data-event-id',calEvent.id);

					}else{
						$('.ajax-file-upload-red').remove();
					}


					// ====Standard Settings
					// ===============================================
					$('#hide-standard-settings').click()
					if((ed.location != null && ed.location!='') || (ed.url != null && ed.url!='')  || (ed.description != null && ed.description!='')) $('#show-standard-settings').click();

					// ===Setting Data for Event Reminder if any

					if(ed.reminderData && ed.reminderData.length > 0){
						var i;
						var reminderType;
						var reminderTime;
						var reminderTimeUnit;
						for(i=0;i < ed.reminderData.length; i++){
							// === for first reminder option
							// alert(i)
							
							
							
							if(i==0){
								$('#reminder_type_1').val(ed.reminderData[i].type);
								$('#reminder_time_1').val(ed.reminderData[i].time);
								$('#reminder_time_unit_1').val(ed.reminderData[i].time_unit);
							}
							if(i==1){
								// alert(reminder2Obj)
								reminder2Obj.appendTo('#reminder-holder');
								$('#reminder_type_2').val(ed.reminderData[i].type);
								$('#reminder_time_2').val(ed.reminderData[i].time);
								$('#reminder_time_unit_2').val(ed.reminderData[i].time_unit);
							}
							if(i==2){
								// alert(reminder3Obj)
								reminder3Obj.appendTo('#reminder-holder');
								$('#reminder_type_3').val(ed.reminderData[i].type);
								$('#reminder_time_3').val(ed.reminderData[i].time);
								$('#reminder_time_unit_3').val(ed.reminderData[i].time_unit);
							}
						}
					}

					if(ed.reminderGuests && ed.reminderGuests.length > 0){ //aqui inserta los correos en la tabla de invitados.
						var i;
						var guestEmail;
						var reminderID;
						serial = 1;
						var guestView;
						$("#accordion1").show();
						for(i = 0; i < ed.reminderGuests.length; i++){
							guestEmail = ed.reminderGuests[i].email;
							reminderID = ed.reminderGuests[i].id;
							responseStatus = ed.reminderGuests[i].responseStatus;
							
							valResponse = "";
							class_ = "";
							icon = "";
							
							if(responseStatus == "needsAction"){
								valResponse = " no ha respondido la invitacion";
								class_ = "warning";
								icon = "glyphicon glyphicon-star-empty";
							}
							if(responseStatus == "declined"){
								valResponse = " ha rechazado la invitacion";
								class_ = "danger";
								icon = "glyphicon glyphicon-ban-circle";
							}
							if(responseStatus == "tentative"){
								valResponse = " es tentativa su asistencia";
								class_ = "info";
								icon = "glyphicon glyphicon-star";
							}
							if(responseStatus == "accepted"){
								valResponse = " ha confirmado su asistencia";
								class_ = "success";
								icon = "glyphicon glyphicon-ok";
							}
							
							tr = "";
							tr += '<tr class="' + class_ +'">' +
									  '<td><input type="checkbox"> <a href="#"><i class="' + icon + '"></i></a></td>' +
									  '<td><span class="badge">' + valResponse +'</span></td>' +
									  '<td><strong>' + guestEmail +' </strong></td>'+

									'</tr>';
							
							guestView = '<div id=\"guest_'+serial+'\"> <input class=\"form-control guest-view guest_email reminder_add_guest_in\" id=\"guest_list_'+serial+'\" name=\"guests[]\" value=\"'+guestEmail+'\"><button class=\"close_guest\" aria-hidden=\"true\" data-dismiss=\"guest\" type=\"button\">×</button></div>';
							$('#guest-list').append(guestView);
							
							$('#guest-list-google').append(tr);
							
							serial = serial + 1;
						}
					
						$('.close_guest').click(function(){
							$(this).parent().remove();
						});

					}else{
						$("#accordion1").hide();
					}

					//anexamos a los correos externos a la lista.
					if(ed.externalGuests.length>0){
						for(i=0;i<ed.externalGuests.length;i++){
							console.log(ed.externalGuests[i].email);
							guestView = '<div id=\"guest_'+serial+'\"> <input class=\"form-control guest-view guest_email reminder_add_guest_in\" id=\"guest_list_'+ed.externalGuests[i].id+'\" name=\"guestsExt[]\" value=\"'+ed.externalGuests[i].email+'\"><button class=\"close_guest\" aria-hidden=\"true\" data-dismiss=\"guest\" type=\"button\">×</button></div>';
							$('#guest-list').append(guestView);
						}
					}

				})
				.fail(function(request, status, error) {
					alert(request.responseText);
					console.log("No se pudo recuperar el evento id");
				});
				
				return false;

		}
	function _formatTimeStr (dateStr) {
		var timeData = dateStr.split(':');

		var hh = parseInt(timeData[0]);
		var m = parseInt(timeData[1]);
		var dd = "AM";
		var h = hh;
		if (h >= 12) {
			h = hh - 12;
			dd = "PM";
		}
		if (h == 0) {
			h = 12;
		}
		m = m < 10 ? "0" + m : m;

		h = h < 10 ? "0" + h : h;

		var replacement = h + ":" + m;
		replacement += " " + dd;

		return replacement;
	}
	function _formatTime(dateStr) {
		var d = new Date(dateStr);
		var hh = d.getHours();
		var m = d.getMinutes();
		var dd = "AM";
		var h = hh;
		if (h >= 12) {
			h = hh - 12;
			dd = "PM";
		}
		if (h == 0) {
			h = 12;
		}
		m = m < 10 ? "0" + m : m;

		h = h < 10 ? "0" + h : h;

		var replacement = h + ":" + m;
		replacement += " " + dd;

		return replacement;
	}
	function _isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	}
	function _hideReminder2() {
		reminder2Obj.appendTo('#reminder-holder');
		reminder2Obj = $('#reminder2').detach();
	}
	function _hideReminder3() {
		reminder3Obj.appendTo('#reminder-holder');
		reminder3Obj = $('#reminder3').detach();
	}
	function _processMovedEvent(event, revertFunc, jsEvent, ui, view) {
		var eventID = event.id;
		var title = event.title;
		var allDay = event.allDay;
		//====Full Calendar has a bug that returns allDay param as a HTML Object instead of boolean when hold time pointer and release event is triggered.
		//====But it seems OK for drag and drop event
		if (allDay && typeof(allDay) != 'object') allDay = '1';
		else allDay = '0';

		var startMoment = moment(event.start)
		var sdate = startMoment.format('YYYY-MM-DD');
		var stime = startMoment.format('hh:mm A');


		if (event.end != null) {
			var endMoment = moment(event.end)
			var edate = endMoment.format('YYYY-MM-DD');
			var etime = endMoment.format('hh:mm A');
		}
		else if(allDay == '0'){
			var edate = startMoment.format('YYYY-MM-DD');
			var etime = startMoment.add('h',1).format('hh:mm A');
		}

		if (!confirm('Are you sure about this change?')) {
			revertFunc();
		}
		else {
			var jqxhr = $.ajax({
				type: 'POST',
				url: '/phpeventcal/server/ajax/events_manager.php',
				data: {action: 'SAVE_MOVED_EVENT', sdate: sdate, edate: edate, stime: stime, etime: etime, eventID: eventID, title: title, allDay: allDay}
			})
				.done(function (msg) {
					if (msg == 'failed') {
						$.bootstrapGrowl('Something went wrong, please try again later', {
							type: 'danger',
							width: 350
						});
					}
					else if (msg == 'repeating') {
						revertFunc();
						$.bootstrapGrowl('<div style="text-align: left">Sorry! This operation is not supported for repeating events. Please try Editing instead</div>', {
							type: 'warning',
							width: 350
						});
					}
					else {
						$.bootstrapGrowl('Event Modified Successfully', {
							type: 'success',
							width: 350
						});
					}
				})
				.fail(function () {
					$.bootstrapGrowl('Something went wrong, please try again later', {
						type: 'danger',
						width: 350
					});
				});
		}
	}
	function _setRepeatOptionsForDays(stDate) {
		
		var stdUnix = new Date(stDate);
		var weekDay = stdUnix.getDay(stdUnix);

		repeat_week_days_checked = false;

		//==== reset the checkboxes
		if (repeat_on_sun == 1) $('#repeat_on_sun').click(function () {
			this.checked
		});
		if (repeat_on_mon == 1) $('#repeat_on_mon').click(function () {
			this.checked
		});
		if (repeat_on_tue == 1) $('#repeat_on_tue').click(function () {
			this.checked
		});
		if (repeat_on_wed == 1) $('#repeat_on_wed').click(function () {
			this.checked
		});
		if (repeat_on_thu == 1) $('#repeat_on_thu').click(function () {
			this.checked
		});
		if (repeat_on_fri == 1) $('#repeat_on_fri').click(function () {
			this.checked
		});
		if (repeat_on_sat == 1) $('#repeat_on_sat').click(function () {
			this.checked
		});

		repeat_on_sun = 0;
		repeat_on_mon = 0;
		repeat_on_tue = 0;
		repeat_on_wed = 0;
		repeat_on_thu = 0;
		repeat_on_fri = 0;
		repeat_on_sat = 0;

		//==== set repeat day checkboxes based on start date
		switch (weekDay) {
			case 0:
				$('#repeat_on_sun').click();
				repeat_on_sun = 1;
				repeat_week_days_checked = true;
				break;
			case 1:
				$('#repeat_on_mon').click();
				repeat_on_mon = 1;
				repeat_week_days_checked = true;
				break;
			case 2:
				$('#repeat_on_tue').click();
				repeat_on_tue = 1;
				repeat_week_days_checked = true;
				break;
			case 3:
				$('#repeat_on_wed').click();
				repeat_on_wed = 1;
				repeat_week_days_checked = true;
				break;
			case 4:
				$('#repeat_on_thu').click();
				repeat_on_thu = 1;
				repeat_week_days_checked = true;
				break;
			case 5:
				$('#repeat_on_fri').click();
				repeat_on_fri = 1;
				repeat_week_days_checked = true;
				break;
			case 6:
				$('#repeat_on_sat').click();
				repeat_on_sat = 1;
				repeat_week_days_checked = true;
				break;
		}

	}	
	function _validateEventCreateForm( organizer) {
		console.log("_validateEventCreateForm");
		if(organizer == undefined)
		{
			organizer = false;
		}		
	
		var errMsg 				='';
		var errMsgTitle 		='';
		var title 				= $('#title').val();
		var title_cap=$("#title_cap").val();
		var allDay 				= $('#allDay').prop('checked');

		var timeStart24 = 		_timeFrom12To124Hours($('#start-time').val());

		var end_time_ = $('#end-time').val();    
		
		if(end_time_ == ""){
			if(allDay == true){				
				end_time_ = $('#start-time').val();
			}			
		}
			
		


		var timeEnd24 =  _timeFrom12To124Hours(end_time_);
		// var start 				= moment($('#start-date').val()+' '+ $('#start-time').val());
		// var end 				= moment($('#end-date').val()+ ' ' +$('#end-time').val());
		
		var start 				= moment($('#start-date').val() + ' '+ timeStart24);
		var end 				= moment($('#end-date').val() + ' ' + timeEnd24);
		var startDate 			= start.format('X');
		var endDate 			= end.format('X');
		var startDateConflict 	= start.format('YYYY-MM-DD');
		var endDateConflict 	= end.format('YYYY-MM-DD');
			
		var startTimeConflict 	= _timeFrom12To124Hours($('#start-time').val());
		
		var endTimeConflict 	= _timeFrom12To124Hours(end_time_);

		var startTime 			= parseInt(_timeFrom12To124Hours($('#start-time').val()).replace(/:/, ''));
		var endTime 			= parseInt(_timeFrom12To124Hours(end_time_).replace(/:/, ''));
		
		//[Dennis 2020-06-09]
		//----------------------------------------------------------------------------
		var capa=$("#idCapacitacion").prop("checked");
		var eventoEstandar= $("#idEvento").prop("checked");


		//Liga para Zoom
		//[Miguel 2021-03-05]
		var urlZoom=$('#urlZoom').val();	
		var pswZoom=$('#pswZoom').val();
		if(urlZoom==''){
			errMsgTitle = "Por Favor coloque la liga de zoom la cual es Obligatoria!<br/>";
			return errMsgTitle;
		}
		if(pswZoom==''){
			errMsgTitle = "Por Favor coloque el Codigo de Acceso la cual es Obligatoria!<br/>";
			return errMsgTitle;
		}
			

		if(capa){
			if (title_cap == '') {
				errMsgTitle = "El titulo es requerido!<br/>";
				return errMsgTitle;
			}
			if($("#idSelectCapacitacion").val()==0){
				errMsgTitle="La selección de una categoria es requerido";
				return errMsgTitle;
			} else if(($("#idSelectCapacitacion").val()==1 || $("#idSelectCapacitacion").val()==2) && $("#ramosCapa").val()==0){
				errMsgTitle+="Es requerido seleccionar un ramo";
				return errMsgTitle;
			}
			if($("#idSubCategoria").val()==0){
				errMsgTitle+="Es requerido una sub-categoría"
				return errMsgTitle;
			}
		}

		if(eventoEstandar){
			if (title == '') {
				errMsgTitle = "El titulo es requerido!<br/>";
				return errMsgTitle;
			}
		}
		//------------------------------------------------------------------------------

		/*if (title == '') {
			errMsgTitle = "El titulo es requerido!<br/>";
			return errMsgTitle;
		}*/	

		if (startDate > endDate && allDay == false){
			errMsg = errMsg + "Fecha de finalización debe establecerse después de Fecha de Inicio!<br />";
			return errMsg;
		}			
		else if ( allDay != true){
			
			var date_end_compare = end.format('YYYYMMDD');
			var date_now_compare = moment().format("YYYYMMDD");
			var hour_now_compare = _timeFrom12To124Hours(moment().format("hh:mm A")).replace(":","");
			var hour_end_compare = _timeFrom12To124Hours(end_time_).replace(":","");
			
			if(date_now_compare > date_end_compare){

				errMsg = errMsg + "Lo sentimos, no se puede crear un evento con dias en el pasado!<br />";
				return errMsg;	
			}
			
			if(date_now_compare == date_end_compare){
				if(hour_now_compare > hour_end_compare){
					errMsg = errMsg + "Lo sentimos, no se puede crear un evento con dias en el pasado!<br />";
					return errMsg;
				}
			}
			
			if(startDate >= endDate)
			{
				errMsg = errMsg + "Lo sentimos, no se puede crear un evento que termina antes de que comience!<br />";
				return errMsg;	
			}
		} 
		
		
		if ((startTime == 2300 && endTime == 0) || (startTime == 2330 && endTime == 30) || (startTime == 2300 && endTime == 2330)){
			errMsg = '';
		} 
			
		if (startTime != 0 && endTime == 0){
			errMsg = '';
		} 
		// if (startTime == endTime && allDay == false){
			// errMsg = errMsg + "Lo sentimos, inicio y fin de las fechas no pueden ser iguales<br />";
		// } 
		if(startDate == endDate){
			console.log(startDate);
			console.log(endDate);
			console.log(allDay);
			if (startTime == endTime && allDay == false){
				errMsg = errMsg + "Lo sentimos, inicio y fin de las fechas no pueden ser iguales<br />";
			} 
		}
		
		//=== if allDay is set to true, then empty the the time for last date
		if (allDay == true) {
			$('#end-time').val("");
		}
		//alert(startDate);
		//alert(endDate);

		$.post("http://localhost:8080/CalendarGoogle/plugins/plugin-calendar/event_calendar.cenis.php",
			
			{ 
			  Event : {
						startDate: startDateConflict,
						endDate: endDateConflict,
						startTime: startTimeConflict,
						endTime: endTimeConflict
			  },
			  TypeEvent: 'CHECK_CONFLICT'
			},
			function (eventJSON) {
			}, "json")
			.always(function (eventJSON) { //==== no event found?
				if(errMsg+errMsgTitle == ''){
					
					if(eventJSON.title > 0){
						var overlap = confirm('Este entrará en conflicto con otro evento, va a proceder?');

						if(overlap){
								_eventCreateUpdate();
						}
					}
					else{
						if(errMsg+errMsgTitle == ''){
							console.log("Ready for insert");
							console.log(organizer);
							console.log("Ready for insert");
							_eventCreateUpdate(organizer);
						}
					}
				}
					/*$.bootstrapGrowl("<div style='text-align: left'>"+eventJSON.title+"</div>", {
						type: 'warning',
						width: 280
					});*/
			}, "json");

		return errMsg + errMsgTitle;
	}
	function _eventCreateUpdate(organizer){
		
		console.log("_eventCreateUpdate");
		
		var repeatChecked = false;
		var CancelaRorganizer = false;
		
		var end_time_ = $('#end-time').val();
		var end_date = $('#end-date').val();
				
		var allDay 	  = $('#allDay').prop('checked');
		var allDayBand = false;
		
		if(organizer == undefined)
		{
			CancelaRorganizer = false;
		}else{
			CancelaRorganizer = organizer;
		}
				
		var hour = $('#start-time').val();
		
		var startTimeConflict 	= _timeFrom12To124Hours($('#start-time').val());
		
		if(end_time_ == ""){
			if(allDay == true){
				if(end_date == ""){
					end_date = $('#start-date').val();
				}				
				end_time_ = $('#start-time').val();
				allDayBand = true;
			}			
		}

		var endTimeConflict 	= _timeFrom12To124Hours(end_time_);
				
		var recurrence = "";
		var count = "";
		// var repeatChecked = $("#repeat").val();
		if($("#repeat").is(':checked')){
			repeatChecked = true;
		}
		//==== check repeat week days are checked at least one, if none is checked, then check one by default
		var repeat_type;
						
		if (repeatChecked == true) {
			
			var repeatType = $('#repeat_type').val();

			//==== if repeat type is weekly
			
			if (repeatType == 'weekly') {
				
				//==== if no repeat day is checked
				if (repeat_on_sun == 0 && repeat_on_mon == 0 && repeat_on_tue == 0 && repeat_on_wed == 0 && repeat_on_thu == 0 && repeat_on_fri == 0 && repeat_on_sat == 0) {
					_setRepeatOptionsForDays($('#start-date').val());
				}
			}
			
			Until = "";
			Interval = "";
			by = "";
			Freq = "";
			
			if(repeatType == 'daily'){
				
				if($("repeat_interval_label").val() == "Dia(s)"){
					by = ";BYDAY=SU,MO,TU,WE,TH,FR,SA";
				}else{
					//by = ";BYWEEKNO=" + $("#repeat_interval").val();
				}
				
				Freq = repeatType.toUpperCase();
				Interval = ";INTERVAL=" + $("#repeat_interval").val();
				
				if($("#repeat_end_after").val().length > 0){
					count = ";COUNT=" + $("#repeat_end_after").val();
				}
				if($("#repeat_end_on").val().length > 0){
					var date__ = $("#repeat_end_on").val();
					Until = ";UNTIL=" + date__.replace(/\-/g,"") + 'T000000Z';
				}
				
			}else if(repeatType == "everyWeekDay"){
				
				Freq = "DAILY";
				//Interval = ";INTERVAL=" + $("#repeat_interval").val();
				by = ";BYDAY=MO,TU,WE,TH,FR;WKST=SU";
				
				//repeticiones
				if($("#repeat_end_after").val().length > 0){
					count = ";COUNT=" + $("#repeat_end_after").val();
				}
				if($("#repeat_end_on").val().length > 0){
					Until = ";UNTIL=" + $("#repeat_end_on").val().replace(/\-/g,"") + 'T000000Z';
				}
				
			}else if(repeatType == "everyMWFDay"){
				
				Freq = "WEEKLY";
				by = ";BYDAY=MO,WE,FR;WKST=SU";
				//repeticiones
				if($("#repeat_end_after").val().length > 0){
					count = ";COUNT=" + $("#repeat_end_after").val();
				}
				if($("#repeat_end_on").val().length > 0){
					Until = ";UNTIL=" + $("#repeat_end_on").val().replace(/\-/g,"") + 'T000000Z';
				}				
			}else if( repeatType == "everyTTDay"){
				
				Freq = "WEEKLY";
				by = ";BYDAY=TU,TH;WKST=SU";
				//repeticiones
				if($("#repeat_end_after").val().length > 0){
					count = ";COUNT=" + $("#repeat_end_after").val();
				}
				if($("#repeat_end_on").val().length > 0){
					Until = ";UNTIL=" + $("#repeat_end_on").val().replace(/\-/g,"") + 'T000000Z';
				}	
			}else if( repeatType == "weekly"){
				
				Freq = "WEEKLY";
				by = "";
				day = "";
				Interval = ";INTERVAL=" + $("#repeat_interval").val();
				if($("#repeat_on_sun").val() == "on"){
					day += "SU,";
				}
				if($("#repeat_on_mon").val() == "on"){
					day += "MO,";
				}
				if($("#repeat_on_tue").val() == "on"){
					day += "TU,";
				}
				if($("#repeat_on_wed").val() == "on"){
					day += "WE,";
				}
				if($("#repeat_on_thu").val() == "on"){
					day += "TH,";
				}
				if($("#repeat_on_fri").val() == "on"){
					day += "FR,";
				}
				if($("#repeat_on_sat").val() == "on"){
					day += "SA,";
				}
				
				if(day.length > 0){
					by = ";BYDAY=" + day;
				}
				
				
			}else if(repeatType == "monthly"){
				
				Freq = "MONTHLY";
				by = "";
				day = "";
				Interval = ";INTERVAL=" + $("#repeat_interval").val();
				if($("#repeat_by_day_of_the_month").val() == "on"){
					day += "1TU";
				}
								
				if(day.length > 0){
					by = ";BYDAY=" + day;
				}
			}else if(repeatType == "yearly"){
				
				Freq = "YEARLY";
				by = "";
				day = "";
				Interval = ";INTERVAL=" + $("#repeat_interval").val();
				if($("#repeat_end_after").val().length > 0){
					count = ";COUNT=" + $("#repeat_end_after").val();
				}
				if($("#repeat_end_on").val().length > 0){
					Until = ";UNTIL=" + $("#repeat_end_on").val().replace(/\-/g,"") + 'T000000Z';
				}	//by = ";BYDAY=" + day;
			}
						
			if(repeatType != "none"){
				recurrence = "RRULE:" + "FREQ=" + Freq + count + Until + Interval + by;
			}
			
		}else{
			$('#repeat_type').val('none');		
		}
		
		var formData = $('#eventForm').serializeArray();

		//---------------------------------------------------------------
		//[Dennis 2020-06-10]
		var eventoCapa=$("#idCapacitacion").prop("checked");
		var eventoEstandar= $("#idEvento").prop("checked");
		//---------------------------------------------------------------
		var jsonCreateEvent = "{";	
		var email = [];
		var email_externo=[];
		var attachment = [];
		if($('#update-event').val().length > 0){
				jsonCreateEvent += "\"eventId\" : \"" + $('#update-event').val()  + "\",";
		}
		
		if(CancelaRorganizer){
			jsonCreateEvent += "\"OrganizerCancel\" : \"true\",";
		}
		
		
		$('input[name^="file_drive"]').each(function() {

			alternateLink = $(this).attr("data-drive-alternateLink");
			downloadUrl = $(this).attr("data-drive-downloadUrl");
			mimeType = $(this).attr("data-drive-mimeType");
			drive_id = $(this).attr("data-drive-id");
			drive_title = $(this).attr("data-drive-title");
			iconLink = $(this).attr("data-drive-iconLink");
			
			attachJson = "{ \"mimeType\" : \"" + mimeType + "\",\"iconLink\" : \"" + iconLink + "\",\"title\" : \"" + drive_title + "\",\"alternateLink\" : \"" + alternateLink + "\", \"downloadUrl\" : \"" + downloadUrl + "\", \"id\" : \"" + drive_id + "\" }";	
			
			attachment.push( attachJson );
		});

		//Miguel 05/03/20121

		var urlZoom=$("#urlZoom").val();
		var pswZoom=$("#pswZoom").val();
		
		jsonCreateEvent += "\"urlZoom\" : \"" + urlZoom  + "\",";
		jsonCreateEvent += "\"pswZoom\" : \"" + pswZoom  + "\",";
		//---------------------------------------------------------------------------------
		
		//[Dennis 2020-06-12]
		//var cadenaT="";
		if(eventoCapa){

			var cat_capa="";
			var subCat_capa="";
			var ramosCap="";

			$("#idSelectCapacitacion").change(function(){
				$("#idSelectCapacitacion option:selected").each(function(){
					cat_capa=$(this).text();
					jsonCreateEvent += "\"categoria_capa\" : \"" + cat_capa  + "\",";
				});
			}).trigger("change");

			$("#idSubCategoria").change(function(){
				$("#idSubCategoria option:selected").each(function(){
					subCat_capa=$(this).text();
					jsonCreateEvent += "\"subCategoria_capa\" : \"" + subCat_capa  + "\",";
				});
			}).trigger("change");

			$("#ramosCap").change(function(){
				$("#ramosCap option:selected").each(function(){
					if($("#idSelectCapacitacion").val()==1 || $("#idSelectCapacitacion").val()==2){
						ramosCap=$(this).text();
						jsonCreateEvent += "\"ramo_capa\" : \"" + ramosCap  + "\",";
					} else{
						ramosCap=$(this).val();
						jsonCreateEvent += "\"ramo_capa\" : \"" + ramosCap  + "\",";
					}
				});
			}).trigger("change");

			
		}
		//---------------------------------------------------------------------------------
		var vacio="Ninguno";
		$.each(formData, function(i, item) {
		//----------------------------------------------------------------------------------
		//[Dennis 2020-06-10]
			if(eventoCapa){
				if(item.name == "title_cap"){
						
					Titleescaped = convert(item.value);
					jsonCreateEvent += "\"TituloEvento\" : \"" + Titleescaped  + "\",";
				}
			}
			
			if(eventoEstandar){
				if(item.name == "title"){
					
					Titleescaped = convert(item.value);
					jsonCreateEvent += "\"TituloEvento\" : \"" + Titleescaped  + "\",";
				}
				//Anexamos directamente el valor de ninguno a las categorias ya que en evento estandar no se contempla
				jsonCreateEvent += "\"categoria_capa\" : \""+ vacio +"\",";
				jsonCreateEvent += "\"subCategoria_capa\" : \""+ vacio +"\",";
				jsonCreateEvent += "\"ramo_capa\" : \""+ vacio +"\",";
			}
			if(item.name == "evento"){
				jsonCreateEvent += "\"clasificacion\" : \"" + item.value  + "\",";
			}
			//-------------------------------------------------------------------------------
			/*if(item.name == "title"){
					
					Titleescaped = convert(item.value);
					console.log(Titleescaped)
					jsonCreateEvent += "\"TituloEvento\" : \"" + Titleescaped  + "\",";
			} */
			
			if(item.name == "start-date"){
				
				if(allDayBand){
					end_time_ = item.value;
				}
				
				jsonCreateEvent += "\"FechaInicio\" : \"" + item.value  + "\",";
			}	
			
			if(item.name == "start-time"){
				jsonCreateEvent += "\"starttime\" : \"" + startTimeConflict  + "\",";
			}
			
			if(item.name == "end-date"){
				if(allDayBand){
					jsonCreateEvent += "\"FechaFinal\" : \"" + end_date + "\",";
				}else{
					jsonCreateEvent += "\"FechaFinal\" : \"" + item.value  + "\",";
				}
			}
			
			if(item.name == "end-time"){
				if(endTimeConflict == null)
					endTimeConflict = startTimeConflict;				
				jsonCreateEvent += "\"endtime\" : \"" + endTimeConflict  + "\",";
			}
			
			if(item.name == "allDay"){
				
				jsonCreateEvent += "\"allDay\" : \"" + item.value  + "\",";
			}
			
			if(item.name == "repeat_type"){
				jsonCreateEvent += "\"repeat_type\" : \"" + item.value  + "\",";
			}
			
			if(item.name == "guests[]"){	
				if(email.indexOf(item.value) == -1)
					email.push( "\"" + item.value + "\"" );
					//console.log(email);
			}
			//----------------------------------------------------------------------------------------
			//[Dennis 2020-06-26]: insertar al array los correos externos.
			if(item.name=="guestsExt[]"){
				if(email_externo.indexOf(item.value)==-1){
					email_externo.push("\""+item.value+"\"");
				}
			}
			//-------------------------------------------------------------------------------------------
			if(item.name == "emailGap[]"){
				alias = $(item).attr("data-alias");
			}
			if(item.name == "emailGapOnly[]"){
				console.log(item.value);
			}
			// if(item.name == "repeat_type"){
				// jsonCreate.push({ item.name : item.value });
			// }
			if(item.name == "repeat_interval"){
				jsonCreateEvent += "\"repeat_interval\" : \"" + item.value  + "\",";
			}
			if(item.name == "repeat_by"){
				jsonCreateEvent += "\"repeat_by\" : \"" + item.value  + "\",";
			}
			if(item.name == "repeat_start_date"){
				jsonCreateEvent += "\"repeat_start_date\" : \"" + item.value  + "\",";
			}
			if(item.name == "repeat_end_on"){
				jsonCreateEvent += "\"repeat_end_on\" : \"" + item.value  + "\",";
			}
			if(item.name == "repeat_end_after"){
				jsonCreateEvent += "\"repeat_end_after\" : \"" + item.value  + "\",";
			}
			if(item.name == "repeat_never"){
				jsonCreateEvent += "\"repeat_never\" : \"" + item.value  + "\",";
			}
			if(item.name == "location"){
				Locationescaped = convert(item.value);
				jsonCreateEvent += "\"Lugar\" : \"" + Locationescaped  + "\",";
			}
			if(item.name == "url"){
				jsonCreateEvent += "\"url\" : \"" + item.value  + "\",";
			}
			if(item.name == "organizer_new"){
				jsonCreateEvent += "\"organizer_new\" : \"" + item.value  + "\",";
			}
			if(item.name == "organizer"){
				jsonCreateEvent += "\"organizer\" : \"" + item.value  + "\",";
			}
			if(item.name == "description"){
				descriptionescaped = convert(item.value);
				console.log("text");
				jsonCreateEvent += "\"Descripcion\" : \"" + descriptionescaped  + "\",";
			}
			if(item.name == "backgroundColor"){				
				jsonCreateEvent += "\"ColorId\" : \"" + item.value  + "\",";
			}
			if(item.name == "free_busy"){
				value_item_busy = "";
				if(item.value == "free"){
					value_item_busy ="transparent";
				}else{
					value_item_busy ="opaque";
				}
				jsonCreateEvent += "\"free_busy\" : \"" + value_item_busy  + "\",";
			}
			if(item.name == "privacy"){
				jsonCreateEvent += "\"TipoEvento\" : \"" + item.value  + "\",";
			}
			if(item.name == "update-event"){
				jsonCreateEvent += "\"update-event\" : \"" + item.value  + "\",";
			}
			if(item.name == "currentView"){
				jsonCreateEvent += "\"currentView\" : \"" + item.value  + "\"";
			}
		});	
		
		if(recurrence.length > 0){
			jsonCreateEvent += ",\"Repetir\" : \"" + recurrence  + "\"";
		}
		
		if (email.length > 0) {
			jsonCreateEvent += ",\"Correo\" : [" + email  + "]";
		}

		//--------------------------------------------------------------------
		if(email_externo.length>0){
			jsonCreateEvent+=",\"correo_externo\":["+email_externo+"]";
		}
		//--------------------------------------------------------------------
		
		if (attachment.length > 0) {
			jsonCreateEvent += ",\"Attachment\" :  [" + attachment  + "]";
		}
		
		jsonCreateEvent += "}";
		
		var jsonCreate = { 
							"Event" : JSON.parse(jsonCreateEvent),
							"TypeEvent" : "CREATE_UPDATE_EVENT"
						};
		console.log(jsonCreateEvent);
		//console.log(item.name[0]);
		//return false;
		//var jsonSend = JSON.stringify(jsonCreate);
		
		//=== reset repeat check box
		repeatChecked = false;
		//return false;
		
		$('#eventForm fieldset').attr('disabled', 'disabled');

		var jqxhr = $.ajax({
			type: "POST",
			url: Host + "/create_update_event",
			data: jsonCreate,
			dataType: "json"
		})
			.done(function (eventJSON) {
				
				console.log(eventJSON);

				if (eventJSON.title == 'NO_EVENT_FOUND_FOR_SELECTED_CALENDARS') {
					$('#myModal').modal('hide');
					$.bootstrapGrowl("<div style='text-align: left'>Evento creado con éxito, aunque se muestra cuando se selecciona el correspondiente calendario</div>", {
						type: 'success',
						width: 450
					});
					return;
				}

				//=== Check if this is an update
				var uid = $('#update-event').val();
				
				if (parseInt(uid) > 0) {
					$('#calendar').fullCalendar('removeEvents', uid);

					//===get current view
					var view = $('#calendar').fullCalendar('getView');


					//=== if it is a agenda/list view then reload the page immediately
					if (view.name == 'list') {
						location.reload(); //[Dennis 2020-07-06]: comentado para verificar el duplicado de id por recarga de página.
						
						return;
					}
					else { //=== wait for 2 seconds for other views
						setTimeout(function () {
							location.reload();
						}, 1000);
					}
				}

				//alert(eventJSON);
				///$('#calendar').fullCalendar('addEventSource', eventJSON);

				setTimeout(function () {
					location.reload();
				}, 1000);

				$('#myModal').modal('hide');

				if (parseInt(uid) > 0) {
					$.bootstrapGrowl("Evento modificado correctamente", {
						type: 'success',
						width: 320
					});
				}
				else {
					$.bootstrapGrowl("Evento creado con éxito", {
						type: 'success',
						width: 320
					});
				}
			})
			.fail(function (jqXHR, textStatus) {
				
				//alert(eventMsg)
				/*$.bootstrapGrowl("<h3>Lea atentamente el mensaje de error y consulte a soporte; Por favor intente más tarde</h3>", {
					type: 'info',
					width: 350,
					delay: 117000, 
					allow_dismiss: true, 
					stackup_spacing: 10 
				});
				console.log(jqXHR);
				console.log(textStatus);
				
				$.bootstrapGrowl("<h5>" + jqXHR.responseText + "</h5>", {
					type: 'danger',
					width: 800,
					delay: 117000, 
					allow_dismiss: true, 
					stackup_spacing: 10 
				});*/
			})
		//return false;

	}
	function _searchEventsBasedOnKeyword(searchKey, laddaObj) {
		//=== ladda button animation starts
		var l = Ladda.create(laddaObj);
		l.start();

		//===Reusing calendar search code
		$.post("/phpeventcal/server/ajax/events_manager.php",
			{ searchKey: searchKey, action: 'LOAD_EVENTS_BASED_ON_SEARCH_KEY'},
			function (eventJSON) {
			}, "json")
			.always(function (eventJSON) { //==== no event found?
				if (eventJSON.title == 'NO___EVENT___FOUND') {
					//=== show a warning message
					$.bootstrapGrowl("<div style='text-align: left'>No match found</div>", {
						type: 'warning',
						width: 280
					});
				}
				else { //=== results found?
					$('#calendar').fullCalendar('changeView', 'list');
					$('#calendar').fullCalendar('removeEvents');
					$('#calendar').fullCalendar('addEventSource', eventJSON);
				}
				//==== ladda button animation stops
				l.stop();
			}, "json");
	}
	
	function _timeFrom12To124Hours(time) {
		
		var hor = time.match(/^(\d+)/);
		
		var hours = Number(hor[1]);
		var minutes = Number(time.match(/:(\d+)/)[1]);
		var AMPM = time.match(/\s(.*)$/)[1];
		if (AMPM == "PM" && hours < 12) hours = hours + 12;
		if (AMPM == "AM" && hours == 12) hours = hours - 12;
		var sHours = hours.toString();
		var sMinutes = minutes.toString();
		if (hours < 10) sHours = "0" + sHours;
		if (minutes < 10) sMinutes = "0" + sMinutes;
		// alert(sHours + ":" + sMinutes)
		return sHours + ":" + sMinutes;
	}
	function convert(str)
	{
	  str = str.replace(/&/g, "&amp;");
	  str = str.replace(/>/g, "&gt;");
	  str = str.replace(/</g, "&lt;");
	  str = str.replace(/"/g, "&quot;");
	  str = str.replace(/'/g, "&#039;");
	  str = str.replace(/[\\]/g, '\\\\')
				.replace(/[\"]/g, '\\\"')
				.replace(/[\/]/g, '\\/')
				.replace(/[\b]/g, '\\b')
				.replace(/[\f]/g, '\\f')
				.replace(/[\n]/g, '\\n')
				.replace(/[\r]/g, '\\r')
				.replace(/[\t]/g, '\\t');
			
	console.log(str);
			
	  return str;
	}
	/**
	 * (c) 2012 Steven Levithan <http://slevithan.com/>
	 * MIT license
	 */
	if (!String.prototype.codePointAt) {
		String.prototype.codePointAt = function (pos) {
			pos = isNaN(pos) ? 0 : pos;
			var str = String(this),
				code = str.charCodeAt(pos),
				next = str.charCodeAt(pos + 1);
			// If a surrogate pair
			if (0xD800 <= code && code <= 0xDBFF && 0xDC00 <= next && next <= 0xDFFF) {
				return ((code - 0xD800) * 0x400) + (next - 0xDC00) + 0x10000;
			}
			return code;
		};
	}

	/**
	 * Encodes special html characters
	 * @param string
	 * @return {*}
	 */
	function html_encode(string) {
		var ret_val = '';
		for (var i = 0; i < string.length; i++) { 
			if (string.codePointAt(i) > 127) {
				ret_val += '&#' + string.codePointAt(i) + ';';
			} else {
				ret_val += string.charAt(i);
			}
		}
		return ret_val;
	}
	
	$(document).on("click",".close",function(e){
        if ($(this).attr("aria-hidden") == "true") 
        {
            $(".ajax-file-upload-container").children().remove();
            $('#myModal').modal('hide');
        }
    });
	
	console.log(methods);

	$.fn.CalendarCenis = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('El metodo ' + methodOrOptions + ' no existe en jquery.CalendarCenis');
        }
    };
	
})(jQuery);
