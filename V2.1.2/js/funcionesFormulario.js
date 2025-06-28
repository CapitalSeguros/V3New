// JavaScript Document
$(document).ready(function(){
// Habitacion Uno
	$("#hab1Adul").change(function(event){
		var hab1Adul = $("#hab1Adul").val();
		hab1AdulNumero(hab1Adul);
	});	
	function hab1AdulNumero(hab1Adul){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab1AdulNumero.post.php",
				data:{hab1AdulPost:hab1Adul},
				success: function(data){ 
					$("#hab1KitDiv").html(data);			
				}
		});
	} // fin hab1AdulNumero
	$("#hab1Kit").change(function(event){
		var hab1Kit = $("#hab1Kit").val();
		hab1KitEdad1Numero(hab1Kit);
	});
	function hab1KitEdad1Numero(hab1Kit){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab1KitEdadesNumero.post.php",
				data:{hab1KitPost:hab1Kit},
				success: function(data){ 
					$("#hab1KitEdadesDiv").html(data);			
				}
		});
	} // fin hab1KitEdad1Numero				   	

// Habitacion Dos
		$("#hab2Adul").change(function(event){
		var hab2Adul = $("#hab2Adul").val();
		hab2AdulNumero(hab2Adul);
	});	
	function hab2AdulNumero(hab2Adul){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab2AdulNumero.post.php",
				data:{hab2AdulPost:hab2Adul},
				success: function(data){ 
					$("#hab2KitDiv").html(data);			
				}
		});
	} // fin hab2AdulNumero
	$("#hab2Kit").change(function(event){
		var hab2Kit = $("#hab2Kit").val();
		hab2KitEdad1Numero(hab2Kit);
	});
	function hab2KitEdad1Numero(hab2Kit){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab2KitEdadesNumero.post.php",
				data:{hab2KitPost:hab2Kit},
				success: function(data){ 
					$("#hab2KitEdadesDiv").html(data);			
				}
		});
	} // fin hab2KitEdad1Numero
	
// Habitacion Tres
		$("#hab3Adul").change(function(event){
		var hab3Adul = $("#hab3Adul").val();
		hab3AdulNumero(hab3Adul);
	});	
	function hab3AdulNumero(hab3Adul){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab3AdulNumero.post.php",
				data:{hab3AdulPost:hab3Adul},
				success: function(data){ 
					$("#hab3KitDiv").html(data);			
				}
		});
	} // fin hab3AdulNumero
	$("#hab3Kit").change(function(event){
		var hab3Kit = $("#hab3Kit").val();
		hab3KitEdad1Numero(hab3Kit);
	});
	function hab3KitEdad1Numero(hab3Kit){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab3KitEdadesNumero.post.php",
				data:{hab3KitPost:hab3Kit},
				success: function(data){ 
					$("#hab3KitEdadesDiv").html(data);			
				}
		});
	} // fin hab3KitEdad1Numero
	
// Habitacion Cuatro
		$("#hab4Adul").change(function(event){
		var hab4Adul = $("#hab4Adul").val();
		hab4AdulNumero(hab4Adul);
	});	
	function hab4AdulNumero(hab4Adul){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab4AdulNumero.post.php",
				data:{hab4AdulPost:hab4Adul},
				success: function(data){ 
					$("#hab4KitDiv").html(data);			
				}
		});
	} // fin hab4AdulNumero
	$("#hab4Kit").change(function(event){
		var hab4Kit = $("#hab4Kit").val();
		hab4KitEdad1Numero(hab4Kit);
	});
	function hab4KitEdad1Numero(hab4Kit){
		$.ajax({
				type:"POST",
				url:"buscadorHotel/hab4KitEdadesNumero.post.php",
				data:{hab4KitPost:hab4Kit},
				success: function(data){ 
					$("#hab4KitEdadesDiv").html(data);			
				}
		});
	} // fin hab4KitEdad1Numero
});