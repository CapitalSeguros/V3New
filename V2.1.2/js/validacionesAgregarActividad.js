// JavaScript Document
// Funcion que comprueba que "valor" es un numero entero
function EsNumeroEntero(valor){
    var cadena = valor.toString();
	var longitud = cadena.length;
	if (longitud == 0){return false;}
	var ascii = null;
    for (var i=0; i<longitud; i++) {
		ascii = cadena.charCodeAt(i);
        if (ascii < 48 || ascii > 57){return false;}
    }
	return true;
}

	function ValidarAgregarTarjeta(){
		var f = document.formAgregarTarjeta;
		var NUMERO_TARJETA = f.NUMERO_TARJETA.value;
		var EXPIRA = f.EXPIRA.value;
		var TIPO = f.TIPO.value;
		var BANCO = f.BANCO.value;
		var CODIGO_SEGURIDAD = f.CODIGO_SEGURIDAD.value;
		
		var patronVisa = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/
		var patronMastercard = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/		
		var error = '';

<!-- -->
	//** var numero_tarjeta=numa+""+numb+""+numc+""+numd;

	if(NUMERO_TARJETA == ""){
			error+= "\n Escriba un numero de tarjeta Valido !!!";
	}
/*	
	// Comprobamos que solo hemos introducido numeros
	if (!EsNumeroEntero(NUMERO_TARJETA) && NUMERO_TARJETA != ""){
		//**alert("Debe introducir unicamente números");
		//** return false;
		alert('ok22');
			error+= "\n Escriba un numero de tarjeta Valido !!!";

	}

	// Paso 1: Tomamos las cifras en posiciones impares y las multiplicamos por 2 y
	// sumamos el resultado
	var cadena = numero_tarjeta.toString();
	var longitud = cadena.length;
	var cifra = null;
	var cifra_cad=null;
	var suma=0;
	for (var i=0; i < longitud; i+=2){
		cifra = parseInt(cadena.charAt(i))*2;
		// Si la cifra resultante es mayor que 9 sumamos las cifras
		if (cifra > 9){ 
			cifra_cad = cifra.toString();
			cifra = parseInt(cifra_cad.charAt(0))+parseInt(cifra_cad.charAt(1));
		}
		suma+=cifra;
	}
	// Paso 2: Tomamos las cifras en posiciones pares y las sumamos
	for (var i=1; i < longitud; i+=2){
		suma += parseInt(cadena.charAt(i));
	}
	
	// Paso 3: Comprobamos que el resultado es múltiplo de 10
	if ((suma % 10) == 0){ 
		// Si todo es correcto enviamos el formulario
		window.document.miformulario.submit();
	} else {
		alert("El número de tarjeta no es válido");
	}
*/
<!-- -->
/*
	if(NUMERO_TARJETA == ""){
			error+= "\n Escriba un numero de tarjeta Valido !!!";
	}
*/
	if(EXPIRA == ""){
			error+= "\n Escriba una fecha de expiracion !!!";
	}
	
	if(TIPO == ""){
			error+= "\n Selecciones un tipo de tarjeta !!!";
	}
	
	if(CODIGO_SEGURIDAD == ""){
			error+= "\n Escriba un numero de seguridad !!!";
	}
	
	if(BANCO == ""){
			error+= "\n Escriba un banco !!!";
	}

		/*
		if(NUMERO_TARJETA != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronVisa.test(NUMERO_TARJETA)){
				error+= "\n Escriba un numero de tarjeta Valido !!!";
			}
		}
		*/
		
		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}
	}
	
	function ValidarAgregarActividadNew(){
		var f = document.formAgregarActividad;
		var idRef = f.idRef.value;
		var tipoCliente = f.tipoCliente.value;
		var error = '';
		
		if(tipoCliente == "SEARCH" && tipoCliente != ""){
			if(idRef == ''){
				error+= '\n Selecciona A un Cliente !!!';
			}
		} else{
				error+= '\n Selecciona A un Cliente !!!';
		}
		
		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}
	}

	function ValidarCotizadorExpres(){
		var f = document.formCotizadorExpres;
		var idRef = f.idRef.value;
				
		var error = '';
		
		if(idRef == ''){
			error+= '\n Selecciona A un Cliente !!!';
		}

		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}
	}

	function ValidarCotizadorExpresNewProspecto(){		
		var f = document.formCotizadorExpres; <!-- formNewProspecto -->
		var NOMBRES = f.NOMBRES.value;
		var TELEFONO_MOVIL = f.TELEFONO_MOVIL.value;		
		var EMAIL = f.EMAIL.value;

		var error = '';
		var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
		var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
		if(NOMBRES == ''){
			error+= '\n Escriba Nombre o Raz\u00f3n Social del Prospecto!!!';
		}

		if(TELEFONO_MOVIL != ""){
			if(TELEFONO_MOVIL.length < 10){
				error+= "\n Escriba el Telefono Celular a 10 Digitos !!!"; 
			} else if(
				TELEFONO_MOVIL == '1111111111'
				||
				TELEFONO_MOVIL == '2222222222'
				||
				TELEFONO_MOVIL == '3333333333'
				||
				TELEFONO_MOVIL == '4444444444'
				||
				TELEFONO_MOVIL == '5555555555'
				||
				TELEFONO_MOVIL == '6666666666'
				||
				TELEFONO_MOVIL == '7777777777'
				||
				TELEFONO_MOVIL == '8888888888'
				||
				TELEFONO_MOVIL == '9999999999'
				||
				TELEFONO_MOVIL == '0000000000'
				||
				TELEFONO_MOVIL == '0123456789'
				||
				TELEFONO_MOVIL == '1234567890'
			){  // !patronTelefono.test(TELEFONO_MOVIL)
				error+= "\n Escriba el Telefono Celular a 10 Digitos Valido !!!";
			}
		}
		
		if(EMAIL != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronCorreo.test(EMAIL)){
				error+= "\n Escriba un E-mail Valido !!!";
			}
		}
		
		
		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}		
	}
	
	function BuscarPolCli(){		
	}

	function calcularExtensionArchivo(nombreFormulario){		
		var f = document.forms[nombreFormulario.name];
		
		var archivo = f.archivo.value;
		var archivo_2 = f.archivo_2.value;
		var archivo_3 = f.archivo_3.value;
		
		var extension = "";
		var extension_2 = "";
		var extension_3 = "";
		
		extension =(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		extension_2 =(archivo_2.substring(archivo_2.lastIndexOf("."))).toLowerCase();
		extension_3 =(archivo_3.substring(archivo_3.lastIndexOf("."))).toLowerCase();

		f.extension.value = extension;
		f.extension_2.value = extension_2;
		f.extension_3.value = extension_3;
					
		if(
			(extension != ".pdf" && extension != ".PDF") && 
			(extension != ".jpg" && extension != ".JPG") &&
			(extension != ".doc" && extension != ".DOC") && 
			(extension != ".docx" && extension != ".DOCX") && 
			(extension != ".xls" && extension != ".XLS") &&
			(extension != ".xlsx" && extension != ".XLSX") &&
			(extension != ".ppt" && extension != ".PPT") &&
			(extension != ".pptx" && extension != ".PPTX") &&			
			(extension != ".xml" && extension != ".XML")
		){
			error+= "\n Seleccione un Archivo PDF, JPG, DOC, XLS, PPT, XML";
		}
			
	}
	
function cambioUsuarioCreacion(nameFormulario){ //Superfuncion de Recarga para los formularios parciales de la actividad
	var f = document.forms[nameFormulario];
	var error = '';
	var textoAlert = '';

	if(error == ''){
		textoAlert+= '\n Responsable Seleccionado';
		
		alert(textoAlert);
		f.submit();
	} else {
		alert(error);
	}
}

function validacionBuscadorClientes(){
	var f = document.formBuscadorCliente;
	var idRefCliente = f.idRefCliente.value;
	var idRefProspecto = f.idRefProspecto.value;
	
	var error = "";

	if(idRefCliente == "" && idRefProspecto == ""){
		error+= "\n Seleccione una Cliente/Prospecto !!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function ValidarCambioConducto(){
	var f = document.formAgregarCambioConducto;
	var idRef = f.idRef.value;
	var Referencia = f.Referencia.value;
				
	var error = "";
		
	if(idRef == ""){
		error+= "\n Selecciona A un Cliente !!!";
	}

	if(Referencia != ""){
		error+= "\n Escriba la Referencia !!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}
