(function ($) {	

	var methods = {
		
		// init : function(options){
			// var settings = $.extend({EventJson: ''}, options);			
			// return this.each(function(){}
		// },
		
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
		}
	}
	
	function _CreateDomForEmail(description,alias,item){		
		
		html = "";
		texto = "Todos los ";
		if(description == "Todos los Usuarios del Sistema"){
			texto="";
		}
		html += "<div class='row'><label class='col-md-3'>" + 
				"<input type='checkbox' name='emailGap[]' data-alias='" + alias + "' class='search-invited'> <span data-alias='" + alias + "'>" + texto + description + "</span></label></div>";
		
		// html +=	"<div class='checkbox'>" +
				// "<label>" +
					// "<input type='checkbox' name='emailGap[]' data-alias='" + alias + "' class='search-invited'>" +
					// "<span data-alias='" + alias + "'>" + texto + description + "</span>" +
				// "</label>" +
				// "</div>";	
				
		if(description != "Todos los Usuarios del Sistema")
			html += "<div class='row'><label class='col-md-3'>" + "<span class='show-table' data-alias='" + alias + "' style='cursor: hand;'>" + description + "</span></label></div>";
		
		return html;
		
	} 
	
	function _CreateTableEmailTr(description,item,test){
		
		console.log(item);
		html = "<tr>"+
					"<td>" +
						"<input type='checkbox' class='search-invited' data-email='" + item.email + "' data-id='" + item.id + "'>" +
						"<a href='#'> <i class='glyphicon glyphicon-envelope'></i></a>" +
						"<input type='hidden' data-email='" + item.email + "' data-id='" + item.id + "' class='emailGap'>" +					

					"</td>"+
					"<td>" + item.email + "</td>" +
					"<td>" + item.username + "</td>" + 
				"<tr/>";
		
		return html;		
		
	}

	function _CreateTableEmailHead( alias ){

		//style='display:none'
		html =  "<table class=\"table table-condensed table-email-gap\"  id=\"" + alias + "\" style='display:none'>"+
					"<thead><tr>" +
						"<th class='all'></th>" + 
						"<th></th>" + 
						"<th></th>" + 
						"</tr></thead>" +
						"<tbody>";				
						
		return html;				

	}
	function _CreateTableEmailFooter(){
		html = 	"</tbody>"+
				  "</table>";
		return html;
	}
	
	$.fn.GeneralCenis = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('El metodo ' + methodOrOptions + ' no existe en jquery.generic.cenis.js');
        }
    };
	
})(jQuery);