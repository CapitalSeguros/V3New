$(document).ready(function($){
	$(document).on("change","#RegimenFiscal",function(event){
		return;
		var tipo   = $(this).val(),
		contenedor = $(".contenido");
		contenedor.html("");

		if (tipo == "0")
		{
			contenedor.append('<div class="row"><div col-md-3><label for="Nombre">Nombre</label><input type="text" id="Nombre" name="Nombre" class="form-control input-sm"/></div></div>');
			contenedor.append('<div class="row"><div col-md-3><label for="ApellidoP">Apellido Paterno</label><input type="text" id="ApellidoP" name="ApellidoP" class="form-control input-sm"/></div></div>');
			contenedor.append('<div class="row"><div col-md-3><label for="ApellidoM">Apellido Materno</label><input type="text" id="ApellidoM" name="ApellidoM" class="form-control input-sm"/></div></div>');
		}

		contenedor.append('<div class="row"><div col-md-3><label for="RFC">RFC</label><input type="text" id="RFC" name="RFC" class="form-control input-sm"/></div></div>');
		contenedor.append('<div class="row"><div col-md-3><label for="Correo">Correo</label><input type="text" id="Correo" name="Correo" class="form-control input-sm"/></div></div>');
		contenedor.append('<div class="row"><div col-md-3><label for="Telefono">Teléfono</label><input type="text" id="Telefono" name="Telefono" class="form-control input-sm"/></div></div>');

		event.preventDefault();
	});
	

	window.ActualizarCliente = function()
	{
		/*var datos = { 
			Nobre 	  : $("#Nombre").val().trim(),
			ApellidoP : $("#ApellidoP").val().trim(),
			ApellidoM : $("#ApellidoM").val().trim(),
			RFC       : $("#RFC").val().trim(),
			Correo	  : $("#Correo").val().trim(),
			Telefono  : $("#Telefono").val().trim()
		};*/

		var url = 'actualizaCliente/guardarActualizacionDatos';

		var xhttp = new XMLHttpRequest();

		xhttp.open("POST", url, true);

		var Datos = "Nombre="      		+ ($("#Nombre").val() 		== null ? "" : $("#Nombre").val()).trim() +
		            "&ApellidoP=" 		+ ($("#ApellidoP").val() 	== null ? "" : $("#ApellidoP").val()).trim() + 
		            "&ApellidoM=" 		+ ($("#ApellidoM").val()	== null ? "" : $("#ApellidoM").val()).trim() +
		            "&RFC="       		+ ($("#RFC").val()			== null ? "" : $("#RFC").val()).trim() +
		            "&Correo="    		+ ($("#Correo").val()		== null ? "" : $("#Correo").val()).trim() +
		            "&Telefono="  		+ ($("#Telefono").val()		== null ? "" : $("#Telefono").val()).trim() +
		            "&IDCli="  	  		+ ($("#IDCli").val()		== null ? "" : $("#IDCli").val()).trim() +
		            "&IDCont="    		+ ($("#IDCont").val()		== null ? "" : $("#IDCont").val()).trim() +
		            "&RazonSocial=" 	+ ($("#RazonSocial").val()	== null ? "" : $("#RazonSocial").val()).trim() +
		            "&RegimenFiscal=" 	+ ($("#RegimenFiscal").val()== null ? "" : $("#RegimenFiscal").val()).trim() +
		            "&rsocial=" 		+ ($("#rsocial").val()		== null ? "" : $("#rsocial").val()).trim() +
		            "&TipoEnt="  		+ ($("#TipoEnt").val()		== null ? "" : $("#TipoEnt").val()).trim();

		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		xhttp.onreadystatechange = function() {
			console.log(xhttp.readyState );
			console.log(xhttp);
		    if (xhttp.readyState == 4 && xhttp.status == 200) {
		    	console.log(xhttp.responseText);
		    	if (xhttp.responseText == "")
		    	{
					$(".valid_exito").show();
		    		$(".text-exito").html("Sus datos fueron guardados correctamente, en breve nos comunicaremos con usted, Gracias.");
					setTimeout(function () {
						location.href = window.location.href;
					}, 700)
		    		//window.location.href=window.location.href;
		    	}
		      	else alert(xhttp.responseText);
		    }
		};

		xhttp.send(Datos);
	}

	$(document).on("click","#buscar",function(e)
	{
		var form = $("#formBusquedaCliente");
		
		$.validator.addMethod("valueNotEquals", function (value, element, arg) {
            return arg != value;
        }, "Value must not equal arg.");


		form.validate({
			rules: {
				busquedaCliente : { required: true },
				poliza     		: { required: true}
			},
			messages: {
				busquedaCliente : { required: "Ingrese su Nombre Completo" },
				poliza     		: { required: "Ingrese su Póliza" }
			},
			errorPlacement: function(error, element) {
			    error.insertBefore(element);
			},
			submitHandler: function (form) {
				form.submit();
			}
		});
	});
});