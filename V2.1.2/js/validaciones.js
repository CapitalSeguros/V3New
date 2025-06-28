// JavaScript Document

function validacionAgregarComentarioCobranza(existePoliza){
	
	var f = document.formAgregarComentarioCobranza;
	var poliza = f.poliza.value;
	var tipoComentario = f.tipoComentario.value;

	var error = "";

	if(existePoliza > 0){

		if(poliza == ""){
			error+= "\n Seleccione una Poliza !!!";
		}
	}
	
	if(poliza == ""){
		error+= "\n Escriba un Numero de Poliza !!!";
	}
	
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function validacionAgregarPagoCobranza(existePoliza){
	
	var f = document.formAgregarPagoCobranza;
	var idPoliza = f.idPoliza.value;
	var importePago = f.importePago.value;
	var moneda = f.moneda.value;
	var tipoCambio = f.tipoCambio.value;
	
	var extension = f.extension.value;
	var TIPO_IMG = f.TIPO_IMG.value;

	var error = "";

	if(existePoliza > 0){
	var idPoliza = f.idPoliza.value;
	var idCliente = f.idCliente.value;
	
		if(idPoliza == ""){
			error+= "\n Seleccione una Poliza !!!";
		}
		if(idCliente == ""){
			error+= "\n Seleccione un Cliente !!!";
		}
	} else {

	var Ramo = f.Ramo.value;

		if(Ramo == ""){
			error+= "\n Seleccione El Area  !!!";
		}

	}

	if(idPoliza == ""){
		error+= "\n Escriba un Numero de Poliza !!!";
	}
	
	if(importePago == "0.00"){
		error+= "\n Importe del Pago debe ser Mayor a Cero!!!";
	}
		
	if(moneda == "MXN"){
		if(tipoCambio != "1.00"){
			error+= "\n Tipo de Cambio Incorrecto!!!";
		}
	} else if(moneda == "USD"){
		if(tipoCambio == "1.00"){
			error+= "\n Tipo de Cambio Incorrecto!!!";
		}
	}


	if(TIPO_IMG == ""){
		error+= "\n Seleccione un Tipo de Imagen!!!";
	}

	if(extension == ""){
		error+= "\n Seleccione un Archivo para Agregar!!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}

}

function validacionAgregarSiniestro(existePoliza){
	var f = document.formAgregarSiniestro;
	var error = "";

	if(existePoliza > 0){
	var idPoliza = f.idPoliza.value;
	var idCliente = f.idCliente.value;
	
		if(idPoliza == ""){
			error+= "\n Seleccione una Poliza !!!";
		}
		if(idCliente == ""){
			error+= "\n Seleccione un Cliente !!!";
		}
	} else {
	var ReferenciaPol = f.ReferenciaPol.value;
	var Ramo = f.Ramo.value;
	/*
		if(Referencia == ""){
			error+= "\n Escriba la Referencia !!!";
		}
	*/
		if(Ramo == ""){
			error+= "\n Seleccione El Area !!!";
		}
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function validacionCambioConducto(cliente){
	var f = document.formAgregarCambioConducto;
	var Referencia = f.Referencia.value;
	var error = "";

	if(cliente != "NEW"){
		var idRef = f.idRef.value;

		if(idRef == ""){
			error+= "\n Seleccione un Cliente  O  Prospecto !!!";
		}
	} else if(cliente == "NEW"){
		var NOMBRES = f.NOMBRES.value;
		var APELLIDO_PATERNO = f.APELLIDO_PATERNO.value;
		var APELLIDO_MATERNO = f.APELLIDO_MATERNO.value;
		var TELEFONO_MOVIL = f.TELEFONO_MOVIL.value;		

		if(NOMBRES == ''){
			error+= '\n Escriba un Nombre del Prospecto!!!';
		}
		if(APELLIDO_PATERNO == ''){
			error+= '\n Escriba un Apellido Paterno del Prospecto!!!';
		}
		if(APELLIDO_MATERNO == ''){
			error+= '\n Escriba un Apellido Materno del Prospecto!!! \n --Extranjeros: Poner un punto para continuar !!!';
		}
		if(TELEFONO_MOVIL == ""){
			error+= "\n Escriba el Telefono Celular a 10 Digitos !!!";
		} else if(TELEFONO_MOVIL.length < 10){
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
	

	if(Referencia != ""){
		error+= "\n Escriba la Referencia !!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function validacionAgregarCancelacion(existePoliza){
	var f = document.formAgregarCancelacion;
	var Comentario = f.Comentario.value;
	var motivoCancelacion = f.motivoCancelacion.value;
	var error = "";

	if(existePoliza > 0){
	var idPoliza = f.idPoliza.value;
	var idCliente = f.idCliente.value;
	var CLIENTE = f.CLIENTE.value;
	
		if(idPoliza == ""){
			error+= "\n Seleccione una Poliza !!!";
		}
		if(idCliente == ""){
			if(CLIENTE == ""){
				error+= "\n Seleccione un Cliente !!!";
			}
		}
		
	} else {
	var Referencia = f.Referencia.value;
	var Ramo = f.Ramo.value;
	/*
		if(Referencia == ""){
			error+= "\n Escriba la Referencia !!!";
		}
	*/
		if(Ramo == ""){
			error+= "\n Seleccione El Area !!!";
		}
	}
	
	if(Comentario != ""){
		error+= "\n Escriba el Comentario de la Cancelacion !!!";
	}
	if(motivoCancelacion == ""){
		error+= "\n Seleccione el Motivo de la Cancelacion !!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function validacionAgregarEndoso(existePoliza){
	var f = document.formAgregarEndoso;
	var cambia1 = f.cambia1.value;
	var queda1 = f.queda1.value;
	var error = "";

	if(existePoliza > 0){
	var idPoliza = f.idPoliza.value;
	var idCliente = f.idCliente.value;
	
		if(idPoliza == ""){
			error+= "\n Seleccione una Poliza !!!";
		}
		if(idCliente == ""){
			error+= "\n Seleccione un Cliente !!!";
		}
	} else {
	//var Referencia = f.Referencia.value;
	var Ramo = f.Ramo.value;
	/*
		if(Referencia == ""){
			error+= "\n Escriba la Referencia !!!";
		}
	*/
		if(Ramo == ""){
			error+= "\n Seleccione El Area !!!";
		}
	}
	
	if(cambia1 == ""){
		error+= "\n Escriba el Campo a Cambiar !!!";
	}
	if(queda1 == ""){
		error+= "\n Escriba a Quedar en !!!";
	}

	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function IsChk(chkName){
	var found = false;
	var chk = document.getElementsByName(chkName+'[]');
	for (var i=0 ; i < chk.length ; i++){
		found = chk[i].checked ? true : found;
	}
	return found;
}
 
function validarEnviarCorreoCliente(){
	var f = document.formEnviarCorreoCliente;
	
	var error = "";
	
	if(!IsChk('paCorreo')){
		error+= "\n Seleccione un Correo Electr\u00f3nico !!!";
	}
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function validarFormularioGmm(){
	var f = document.formLineasPersonales;
	var estado = f.estado.value;
	var forma_pago = f.forma_pago.value;
	var reconocimientoAntiguedad = f.reconocimientoAntiguedad.value;
	
	var error = "";
	
	if(!IsChk('addAseguradora')){
		error+= "\n Seleccione una Aseguradora !!!";
	}
	if(estado == ""){
		error+= "\n Seleccione una Estado !!!";
	}
	if(forma_pago == ""){
		error+= "\n Seleccione una Forma Pago !!!";
	}
	if(reconocimientoAntiguedad == ""){
		error+= "\n Seleccione Reconocimiento de antig\u00FCedad !!!";
	}
	
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}



function ValidarPagarPedido(){
	var f = document.formPagarPedido;
	var importePagado = f.importePagado.value;
	
	var error = "";
	
	if(importePagado == ""){
		error+= "\n Escriba un Importe A Pagar !!!";
	}
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function ValidarAgregarSurtido(){
	var f = document.formSurtirPartida;
	var cantidadSurtida = f.cantidadSurtida.value;
	
	var error = "";
	
	if(cantidadSurtida == ""){
		error+= "\n Escriba una Cantidad A Surtir !!!";
	}
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function ValidarAgregarLlamadaCita(){
	var f = document.formLlamadaCita;
	var comentario = f.comentario.value;
	var tipo = f.tipo.value;
	
	var error = "";
	
	if(comentario == ""){
		error+= "\n Escriba un Comentario !!!";
	}
	if(tipo == ""){
		error+= "\n Seleccione un Tipo !!!";
	}
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}
function validarAddDocumento(){
	var f = document.formAddDocumentos;
	var DESCRIPCION = f.DESCRIPCION.value;
	var TIPO_IMG = f.TIPO_IMG.value;
	var archivo = f.archivo.value;

	var error = "";
	var extension = "";
	extension =(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		
	if(DESCRIPCION == ""){
		error+= "\n Escriba una Descripcion";
	}
	if(TIPO_IMG == ""){
		error+= "\n Seleccione un Tipo de Imagen";
	}
	if(archivo == ""){
		error+= "\n Seleccione un Archivo";
	}else{
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

	if(error == ""){
		f.extension.value=extension;
		f.submit();
	} else {
		alert(error);
	}
}

function mostrarOcultarDiv(idDiv) {
	var elElemento=document.getElementById(idDiv);
	if(elElemento.style.display == 'block'){
		elElemento.style.display = 'none';
		fadeEffect.init(idDiv, 0);
	} else {
		elElemento.style.display = 'block';
		fadeEffect.init(idDiv, 1);
	}
}

var fadeEffect=function(){
	return{
		init:function(id, flag, target){
			this.elem = document.getElementById(id);
			clearInterval(this.elem.si);
			this.target = target ? target : flag ? 100 : 0;
			this.flag = flag || -1;
			this.alpha = this.elem.style.opacity ? parseFloat(this.elem.style.opacity) * 100 : 0;
			this.si = setInterval(function(){fadeEffect.tween()}, 20);
		},
		tween:function() {
			if(this.alpha == this.target){
				clearInterval(this.si);
			} else {
				var value = Math.round(this.alpha + ((this.target - this.alpha) * .05)) + (1 * this.flag);
				this.elem.style.opacity = value / 100;
				this.elem.style.filter = 'alpha(opacity=' + value + ')';
				this.alpha = value
			}
		}
	}
}();

function ValidarAgregarContacto(){
	var f = document.formAgregarContacto;
	var NOMBRE  = f.NOMBRE.value;
	var EMAIL  = f.EMAIL.value;
	var TELEFONO  = f.TELEFONO.value;
	var DIRECCION = f.DIRECCION.value;		
	
	var error = "";
	var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
	var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
	if(NOMBRE == ""){
		error+= "\n Escriba el Nombre !!!";
	}
	
	if(TELEFONO == ""){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(TELEFONO.length < 10){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(
			TELEFONO == '1111111111'
			||
			TELEFONO == '2222222222'
			||
			TELEFONO == '3333333333'
			||
			TELEFONO == '4444444444'
			||
			TELEFONO == '5555555555'
			||
			TELEFONO == '6666666666'
			||
			TELEFONO == '7777777777'
			||
			TELEFONO == '8888888888'
			||
			TELEFONO == '9999999999'
			||
			TELEFONO == '0000000000'
			||
			TELEFONO == '0123456789'
			||
			TELEFONO == '1234567890'
			 ){
				 error+= "\n Escriba el Telefono a 10 Digitos Valido !!!";
			 }
/*		
		if(EMAIL != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronCorreo.test(EMAIL)){
				error+= "\n Escriba un E-mail Valido !!!";
			}
		}
*/
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}
function ValidarAgregarContactoProveedor(){
	var f = document.formAgregarContacto;
	var Nombre_contacto  = f.Nombre_contacto.value;
	var email  = f.email.value;
	var telefono1  = f.telefono1.value;
	var direccion = f.direccion.value;		
	
	var error = "";
	var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
	var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
	if(Nombre_contacto == ""){
		error+= "\n Escriba el Nombre !!!";
	}
	
	if(telefono1 == ""){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(telefono1.length < 10){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(
			telefono1 == '1111111111'
			||
			telefono1 == '2222222222'
			||
			telefono1 == '3333333333'
			||
			telefono1 == '4444444444'
			||
			telefono1 == '5555555555'
			||
			telefono1 == '6666666666'
			||
			telefono1 == '7777777777'
			||
			telefono1 == '8888888888'
			||
			telefono1 == '9999999999'
			||
			telefono1 == '0000000000'
			||
			telefono1 == '0123456789'
			||
			telefono1 == '1234567890'
			 ){
				 error+= "\n Escriba el Telefono a 10 Digitos Valido !!!";
			 }
/*		
		if(EMAIL != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronCorreo.test(EMAIL)){
				error+= "\n Escriba un E-mail Valido !!!";
			}
		}
*/
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function ValidarEditarContacto(){
	var f = document.formEditarContacto;
	var NOMBRE  = f.NOMBRE.value;
	var EMAIL  = f.EMAIL.value;
	var TELEFONO  = f.TELEFONO.value;
	var DIRECCION = f.DIRECCION.value;		

	var error = "";
	var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
	var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
	if(NOMBRE == ""){
		error+= "\n Escriba el Nombre !!!";
	}
	
	if(TELEFONO == ""){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(TELEFONO.length < 10){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(
			TELEFONO == '1111111111'
			||
			TELEFONO == '2222222222'
			||
			TELEFONO == '3333333333'
			||
			TELEFONO == '4444444444'
			||
			TELEFONO == '5555555555'
			||
			TELEFONO == '6666666666'
			||
			TELEFONO == '7777777777'
			||
			TELEFONO == '8888888888'
			||
			TELEFONO == '9999999999'
			||
			TELEFONO == '0000000000'
			||
			TELEFONO == '0123456789'
			||
			TELEFONO == '1234567890'
			 ){
				 error+= "\n Escriba el Telefono a 10 Digitos Valido !!!";
			 }
			 
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function ValidarEditarContactoProveedor(){
	var f = document.formEditarContacto;
	var Nombre_contacto  = f.Nombre_contacto.value;
	var email  = f.email.value;
	var telefono_movil  = f.telefono_movil.value;
	var direccion = f.direccion.value;		

	var error = "";
	var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
	var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
	if(Nombre_contacto == ""){
		error+= "\n Escriba el Nombre !!!";
	}
	
	if(telefono_movil == ""){
		error+= "\n Escriba el Telefono Movil a 10 Digitos !!!";
	} else if(telefono_movil.length < 10){
		error+= "\n Escriba el Telefono Movil a 10 Digitos !!!";
	} else if(
			telefono_movil == '1111111111'
			||
			telefono_movil == '2222222222'
			||
			telefono_movil == '3333333333'
			||
			telefono_movil == '4444444444'
			||
			telefono_movil == '5555555555'
			||
			telefono_movil == '6666666666'
			||
			telefono_movil == '7777777777'
			||
			telefono_movil == '8888888888'
			||
			telefono_movil == '9999999999'
			||
			telefono_movil == '0000000000'
			||
			telefono_movil == '0123456789'
			||
			telefono_movil == '1234567890'
			 ){
				 error+= "\n Escriba el Telefono 1 a 10 Digitos Valido !!!";
			 }
			 
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function ValidarEditarProveedorNombre(){
	var f = document.formEditarProveedorNombre;
	var Nombre  = f.Nombre.value;

	var error = "";
		
	if(Nombre == ""){
		error+= "\n Escriba el Nombre !!!";
	}
				 
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function ValidarEditarMiContactoNombre(){
	var f = document.formEditarMiContactoNombre;
	var Nombre_misContactos  = f.Nombre_misContactos.value;

	var error = "";
		
	if(Nombre_misContactos == ""){
		error+= "\n Escriba el Nombre !!!";
	}
				 
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}

function DetalleCliente(valor, tipoDirectorio){
	if(valor == ""){ 
		alert("\n Seleccione un Resultado !!!");
	} else {
		switch(tipoDirectorio){
			case 'clientes':
				window.open('cliente.php?CLAVE='+valor,'_self');
			break;
			case 'proveedores':
				window.open('proveedor.php?CLAVE='+valor,'_self');
			break;
			case 'contactos':
				window.open('misContactos.php?CLAVE='+valor,'_self');
			break;
			case 'empleados':
				window.open('empleados.php?CLAVE='+valor,'_self');
			break;
		}
	}
}
function ValidarLogin(f){
	var error = true;
	var msg = "Escriba un:\n";

	if(f.user.value == ""){
		msg += "- Usuario \n";
		error = false;
	}
	if(f.pass.value == ""){
		msg += "- Password \n";
		error = false;
	}

	if(error == false)
		alert(msg);
		return error;
}


// -- -- //


function CalcularRFC(){
}
 
function limitaCaracteres(texto,maxlong){
	var tecla, in_value, out_value;
	
	if (texto.value.length > maxlong){
		in_value = texto.value;
		out_value = in_value.substring(0,maxlong);
		texto.value = out_value;
		
		return false;
	}
	return 
		true;
}

function ValidarEmisionesTerminar(){
	var f = document.formEmisionesTerminar;
	var marca = f.marca.value;
	var modelo = f.modelo.value;
	var year = f.year.value;
	var tipoVehiculo = f.tipoVehiculo.value;
	var placas = f.placas.value;
	var numero_serie_niv = f.numero_serie_niv.value;
	var numero_motor = f.numero_motor.value;
	var tipo_uso = f.tipo_uso.value;
	var estado = f.estado.value;
	
	var error = "";
		
	if(marca == ""){
		error+= "\n Escriba una Marca !!!";
	}
	if(modelo == ""){
		error+= "\n Escriba una Modelo !!!";
	}
	if(year == ""){
		error+= "\n Escriba una A\u00f1o !!!";
	}
	if(tipoVehiculo == ""){
		error+= "\n Seleccione un Tipo de Vehiculo !!!";
	}
	if(placas == ""){
		error+= "\n Escriba las Placas Marca !!!";
	}
	if(numero_serie_niv == ""){
		error+= "\n Escriba el Numero de Serrie !!!";
	}
	if(numero_motor == ""){
		error+= "\n Escriba el Numero de Motor !!!";
	}
	if(tipo_uso == ""){
		error+= "\n Seleccione el Tipo de Uso !!!";
	}
	if(estado == ""){
		error+= "\n Seleccione un Estado de Circulacion !!!";
	}
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function ValidarPlantillaEmail()
	{

		var f = document.formAgregarPlantillasEmail;
		var nombre_plantilla = f.nombre_plantilla.value;
		var texto = f.texto.value;

		var error = "";

		if(nombre_plantilla == ""){
			error+= "\n Escriba un Nombre de Plantilla !!!";
		}
		
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}

	}	

function ValidarAddPersonaAdicional(){
		var f = document.formAddPersonaAdicional;		
		var fecha_nacimiento_add = f.fecha_nacimiento_add.value;
		var edad_add = f.edad_add.value;
		var nombre_add = f.nombre_add.value;
		var parentesco_add = f.parentesco_add.value;
		var sexo_add = f.sexo_add.value;

		var error = "";

		if(fecha_nacimiento_add == ""){
			error+= "\n Selecciona una Fecha de Nacimiento !!!";
		}
		if(edad_add == ""){
			error+= "\n Escriba una Edad !!!";
		}
		if(nombre_add == ""){
			error+= "\n Escriba un Nombre !!!";
		}
		if(parentesco_add == ""){
			error+= "\n Escriba un Parentesco !!!";
		}
		if(sexo_add == ""){
			error+= "\n Selecciona un Sexo !!!";
		}
		
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}
	
	
function ValidarEmpresa()
	{
		var f = document.formEditarEmpresa;
		var APELLIDO_PATERNO = f.APELLIDO_PATERNO.value;
		var APELLIDO_MATERNO = f.APELLIDO_MATERNO.value;
		var NOMBRES = f.NOMBRES.value;
		
			
		var error = "";
		
		if(APELLIDO_PATERNO == ""){
			error+= "\n Escriba un Apellido Paterno !!!";
		}
		if(APELLIDO_MATERNO == ""){
			error+= "\n Escriba un Apellido Materno !!!";
		}
		if(NOMBRES == ""){
			error+= "\n Escriba un Nombre !!!";
		}

		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}	
	}
	
	
function ValidarTerminarActividad()
	{
		var f = document.formTerminarActividad;
		var Resultado = f.Resultado.value;
		
		var error = "";
		
		if(Resultado == ""){
			error+= "\n Selecciona un Resultado !!!";
		}

		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}	
	
function ValidarAgregarActividad()
	{
		var f = document.formAgregarActividad;
		var Actividad = f.Actividad.value;
		var Ramo = f.Ramo.value;
		var Responsable = f.Responsable.value;
		var Fecha = f.Fecha.value;
		
		var error = "";
		
		if(Actividad == ""){
			error+= "\n Selecciona una Actividad !!!";
		}
		if(Ramo == ""){
			error+= "\n Seleccione un Ramo !!!";
		}
		if(Responsable == ""){
			error+= "\n Selecciona un Responsable !!!";
		}
		if(Fecha == ""){
			error+= "\n Ingrese la Fecha !!!";
		}

		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}	
	
function ValidarAgregarActividadMas()
	{
		var f = document.formAgregarActividadMas;

		var ActividadMas = f.ActividadMas.value;
		var RamoMas = f.RamoMas.value;
		var ResponsableMas = f.ResponsableMas.value;
		var FechaMas = f.FechaMas.value;
		
		var error = "";

		if(ActividadMas == ""){
			error+= "\n Selecciona una Actividad !!!";
		}
		if(RamoMas == ""){
			error+= "\n Seleccione un Ramo !!!";
		}
		if(ResponsableMas == ""){
			error+= "\n Selecciona un Responsable !!!";
		}
		if(FechaMas == ""){
			error+= "\n Ingrese la Fecha !!!";
		}

		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}	

function ValidarAgregarEmpresasMoral()
	{
		var f = document.formAgregarEmpresa;

		var RAZON_SOCIAL = f.RAZON_SOCIAL.value;
		var RFC = f.RFC.value;
		var CALLE = f.CALLE.value;
		var NOEXTERIOR = f.NOEXTERIOR.value;
		var REFERENCIA = f.REFERENCIA.value;
		var COLONIA = f.COLONIA.value;
		var CODIGO_POSTAL = f.CODIGO_POSTAL.value;
		var LOCALIDAD = f.LOCALIDAD.value;
//		var MUNICIPIO = f.MUNICIPIO.value;
		var ESTADO = f.ESTADO.value;
		var PAIS = f.PAIS.value;
		var TELEFONO_PARTICULAR = f.TELEFONO_PARTICULAR.value;
		var TELEFONO_OFICINA = f.TELEFONO_OFICINA.value;
		var TELEFONO_MOVIL = f.TELEFONO_MOVIL.value;
		var observaciones = f.observaciones.value;
		
		var error = "";

		if(RAZON_SOCIAL == ""){
			error+= "\n Escriba la Razon Social !!!";
		}
/*
		if(RFC == ""){
			error+= "\n Escriba el RFC !!!";
		}
		if(CALLE == ""){
			error+= "\n Escriba la Direccion Calle !!!";
		}
		if(NOEXTERIOR == ""){
			error+= "\n Escriba la Direccion No. Exterior !!!";
		}
		if(REFERENCIA == ""){
			error+= "\n Escriba la Direccion Entre Callle !!!";
		}
		if(COLONIA == ""){
			error+= "\n Escriba la Direccion Colonia !!!";
		}
		if(CODIGO_POSTAL == ""){
			error+= "\n Escriba la Direccion Codigo Postal !!!";
		}
		if(LOCALIDAD == ""){
			error+= "\n Escriba la Direccion Localidad !!!";
		}

		if(MUNICIPIO == ""){
			error+= "\n Escriba la Direcion Municipio !!!";
		}

		if(ESTADO == ""){
			error+= "\n Escriba la Direccion Estado !!!";
		}
		if(PAIS == ""){
			error+= "\n Escriba la Direccion Pais !!!";
		}

		if(TELEFONO_PARTICULAR == ""){
			error+= "\n Escriba el Telefono Particular a 10 Digitos !!!";
		} else {
			if(TELEFONO_PARTICULAR.length < 10 ){
				error+= "\n Escriba el Telefono Particular a 10 Digitos !!!";
			}
		}

		if(TELEFONO_OFICINA == ""){
			error+= "\n Escriba el Telefono Oficina a 10 Digitos !!!";
		} else {
			if(TELEFONO_OFICINA.length < 10 ){
				error+= "\n Escriba el Telefono Oficina a 10 Digitos !!!";
			}
		}	
*/
		if(TELEFONO_MOVIL == ""){
			error+= "\n Escriba el Telefono Movil a 10 Digitos !!!";
		} else {
			if(TELEFONO_MOVIL.length < 10 ){
				error+= "\n Escriba el Telefono Movil a 10 Digitos !!!";
				}
		}
/*	*/
		if(observaciones == ""){
			error+= "\n Escriba las Observaciones !!!";
		}
		
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}	
	
function ValidarAgregarEmpresasFisica()
	{
		var f = document.formAgregarEmpresa;

		var FECHA_NACIMIENTO  = f.FECHA_NACIMIENTO.value;
//		var EDAD  = f.EDAD.value;
		var NACIONALIDAD  = f.NACIONALIDAD.value;
		var APELLIDO_PATERNO = f.APELLIDO_PATERNO.value;
		var APELLIDO_MATERNO  = f.APELLIDO_MATERNO.value;
		var NOMBRES  = f.NOMBRES.value;
		var RFC  = f.RFC.value;

		var CALLE = f.CALLE.value;
		var NOEXTERIOR = f.NOEXTERIOR.value;
		var REFERENCIA = f.REFERENCIA.value;
		var COLONIA = f.COLONIA.value;
		var CODIGO_POSTAL = f.CODIGO_POSTAL.value;
		var LOCALIDAD = f.LOCALIDAD.value;
//		var MUNICIPIO = f.MUNICIPIO.value;
		var ESTADO = f.ESTADO.value;
		var PAIS = f.PAIS.value;
		var TELEFONO_PARTICULAR = f.TELEFONO_PARTICULAR.value;
		var TELEFONO_OFICINA = f.TELEFONO_OFICINA.value;
		var TELEFONO_MOVIL = f.TELEFONO_MOVIL.value;
		var observaciones = f.observaciones.value;
		
		var error = "";
		
/*		
		if(FECHA_NACIMIENTO == ""){
			error+= "\n Escriba la Fecha de Nacimiento !!!";
		}

		if(EDAD == ""){
			error+= "\n Escriba la Edad !!!";
		}

		if(NACIONALIDAD == ""){
			error+= "\n Escriba la Nacionalidad !!!";
		}
*/
		if(APELLIDO_PATERNO == ""){
			error+= "\n Escriba el Apellido Paterno !!!";
		}
		if(APELLIDO_MATERNO == ""){
			error+= "\n Escriba el Apellido Materno !!!";
		}
		if(NOMBRES == ""){
			error+= "\n Escriba el Nombre(s) !!!";
		}
/*
		if(RFC == ""){
			error+= "\n Escriba el RFC !!!";
		}
		if(CALLE == ""){
			error+= "\n Escriba la Direccion Calle !!!";
		}
		if(NOEXTERIOR == ""){
			error+= "\n Escriba la Direccion No. Exterior !!!";
		}
		if(REFERENCIA == ""){
			error+= "\n Escriba la Direccion Entre Callle !!!";
		}
		if(COLONIA == ""){
			error+= "\n Escriba la Direccion Colonia !!!";
		}
		if(CODIGO_POSTAL == ""){
			error+= "\n Escriba la Direccion Codigo Postal !!!";
		}
		if(LOCALIDAD == ""){
			error+= "\n Escriba la Direccion Localidad !!!";
		}
		if(MUNICIPIO == ""){
			error+= "\n Escriba la Direcion Municipio !!!";
		}

		if(ESTADO == ""){
			error+= "\n Escriba la Direccion Estado !!!";
		}
		if(PAIS == ""){
			error+= "\n Escriba la Direccion Pais !!!";
		}

		if(TELEFONO_PARTICULAR == ""){
			error+= "\n Escriba el Telefono Particular a 10 Digitos !!!";
		} else {
			if(TELEFONO_PARTICULAR.length < 10 ){
				error+= "\n Escriba el Telefono Particular a 10 Digitos !!!";
			}
		}

		if(TELEFONO_OFICINA == ""){
			error+= "\n Escriba el Telefono Oficina !!!";
		} else {
			if(TELEFONO_OFICINA.length < 10 ){
				error+= "\n Escriba el Telefono Oficina a 10 Digitos !!!";
			}
		}
*/		
		if(TELEFONO_MOVIL == ""){
			error+= "\n Escriba el Telefono Movil !!!";
		} else {
			if(TELEFONO_MOVIL.length < 10 ){
				error+= "\n Escriba el Telefono Movil a 10 Digitos !!!";
				}
		}
/*		
*/
		if(observaciones == ""){
			error+= "\n Escriba las Observaciones !!!";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	}		




function validarDocumentosActividad(){
		var f = document.formDocumentosActividad;		
		var DESCRIPCION = f.DESCRIPCION.value;
		var TIPO_IMG = f.TIPO_IMG.value;
		var archivo = f.archivo.value;
		var VALOR = f.VALOR.value;
		var validacionPoliza = f.validacionPoliza.value;
		
		var error = "";
		var extension = "";
		extension =(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		
		if(DESCRIPCION == ""){
			error+= "\n Escriba una Descripcion";
		}
		if(TIPO_IMG == ""){
			error+= "\n Seleccione un Tipo de Imagen";
		}
		if(archivo == ""){
			error+= "\n Seleccione un Archivo";
		}
		if(validacionPoliza == 'S'){
			if(VALOR == ""){
				error+= "\n Escriba el Numero de Poliza !!!";
			}
		}
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
		
		if(error == ""){
			f.extension.value=extension;
			f.submit();
		} else {
			alert(error);
		}
}// fin function


<!-- -->
// JavaScript Document
function validarFianzas()
	{
		var f = document.formFianzas;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var calle = f.calle.value;
		var noint = f.noint.value;
		var noext = f.noext.value;
		var cruzamientos = f.cruzamientos.value;
		var colonia = f.colonia.value;
		var ciudad = f.ciudad.value;
		var estado = f.estado.value;
		var codigopostal = f.codigopostal.value;
		var telefono = f.telefono.value;
		var email = f.email.value;
		var fianzamonto = f.fianzamonto.value;
		var fianzatipo = f.fianzatipo.value;
		var beneficiario = f.beneficiario.value;
		var comentarios = f.comentarios.value;
		var vendedor = f.vendedor.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(calle == ""){
			error+= "\n Escriba la Calle";
		}
		/*
		if(noint == ""){
			error+= "\n Escriba el Numero Interior";
		}
		*/
		if(noext == ""){
			error+= "\n Escriba el Numero Exterior";
		}
		if(cruzamientos == ""){
			error+= "\n Escriba los Cruzamientos";
		}
		if(colonia == ""){
			error+= "\n Escriba la Colonia";
		}
		if(ciudad == ""){
			error+= "\n Escriba la Ciudad";
		}
		if(estado == ""){
			error+= "\n Escriba el Estado";
		}
		if(codigopostal == ""){
			error+= "\n Escriba el Codigo Postal";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(fianzamonto == ""){
			error+= "\n Escriba el Monto de la Fianza";
		}
		if(fianzatipo == ""){
			error+= "\n Seleccione un Tipo de Fianza";
		}
		if(beneficiario == ""){
			error+= "\n Escriba el Nombre del Beneficiario";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(vendedor == ""){
			error+= "\n Escriba su Vendedor";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	

function validarContacto()
	{
		var f = document.formContacto;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var telefono = f.telefono.value;
		var email = f.email.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	
	
	
function validarEcogap()
	{
		var f = document.formEcogap;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var email = f.email.value;
		var nopoliza = f.nopoliza.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(nopoliza == ""){
			error+= "\n Escriba el No. de Poliza";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	
function validarUnete()
	{
		var f = document.formUnete;
		var razon_contacto = f.razon_contacto.value;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var email = f.email.value;
		var estado = f.estado.value;
		var telefono = f.telefono.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(razon_contacto == ""){
			error+= "\n Seleccione una Razon de Contacto";
		}
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(estado == ""){
			error+= "\n Seleccione un Estado";
		}
		if(telefono == ""){
			error+= "\n Escriba un Numero Telefonico";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	
	function validarSegEducacion()
	{
		var f = document.formSegEducacion;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var calle = f.calle.value;
		var noint = f.noint.value;
		var noext = f.noext.value;
		var cruzamientos = f.cruzamientos.value;
		var colonia = f.colonia.value;
		var ciudad = f.ciudad.value;
		var estado = f.estado.value;
		var codigopostal = f.codigopostal.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var fechanacimiento = f.fechanacimiento.value;
		var rfc = f.rfc.value;
		var edad_contratante = f.edad_contratante.value;
		var edad_menor = f.edad_menor.value;
		var sexo = f.sexo.value;
		var costoUniversidad = f.costoUniversidad.value;
		var moneda = f.moneda.value;
		var fuma = f.fuma.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(calle == ""){
			error+= "\n Escriba la Calle";
		}
		if(noext == ""){
			error+= "\n Escriba el Numero Exterior";
		}
		if(cruzamientos == ""){
			error+= "\n Escriba los Cruzamientos";
		}
		if(colonia == ""){
			error+= "\n Escriba la Colonia";
		}
		if(ciudad == ""){
			error+= "\n Escriba la Ciudad";
		}
		if(estado == ""){
			error+= "\n Escriba el Estado";
		}
		if(codigopostal == ""){
			error+= "\n Escriba el Codigo Postal";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(fechanacimiento == "Día / Mes / Año (4 Digitos )" || fechanacimiento == ""){
			error+= "\n Escriba su Fecha de Nacimiento";
		}
		if(rfc == ""){
			error+= "\n Escriba su RFC";
		}
		if(edad_contratante == "Padre o Contratante" ||  edad_contratante == ""){
			error+= "\n Escriba su Edad";
		}
		if(edad_menor == "Child" || edad_menor ==""){
			error+= "\n Escriba la Edad Child";
		}
		if(sexo == ""){
			error+= "\n Seleccione su Sexo";
		}
		if(costoUniversidad == ""){
			error+= "\n Seleccione un Costo Universitario";
		}
		if(moneda == ""){
			error+= "\n Seleccione una Moneda";
		}
		if(fuma == ""){
			error+= "\n Seleccione si Fuma";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function

	function validarSegGastosMedicos()
	{
		var f = document.formSegGastosMedicos;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var edad_contratante = f.edad_contratante.value;
		var sexo = f.sexo.value;
		var coverturaInternacional = f.coverturaInternacional.value;
		var deducible = f.deducible.value;
		var nivelHospitalario = f.nivelHospitalario.value;
		var formaPago = f.formaPago.value;
		var residencia = f.residencia.value;
		var coaseguro = f.coaseguro.value;	
		var comentarios = f.comentarios.value;
		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(edad_contratante == "Contractor" ||  edad_contratante == ""){
			error+= "\n Escriba su Edad";
		}
		if(sexo == ""){
			error+= "\n Seleccione su Sexo";
		}
		if(coverturaInternacional == ""){
			error+= "\n Seleccione la Covertura";
		}
		if(deducible == ""){
			error+= "\n Seleccione un Deducible";
		}
		if(nivelHospitalario == ""){
			error+= "\n Seleccione el Nivel Hospitalario";
		}
		if(formaPago == ""){
			error+= "\n Seleccione la Forma de Pago";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(residencia == ""){
			error+= "\n Escriba su Residencia";
		}
		if(coaseguro == ""){
			error+= "\n Seleccione Coaseguro";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	
	function validarSegRetiro()
	{
		var f = document.formSegRetiro;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var calle = f.calle.value;
		var noint = f.noint.value;
		var noext = f.noext.value;
		var cruzamientos = f.cruzamientos.value;
		var colonia = f.colonia.value;
		var ciudad = f.ciudad.value;
		var estado = f.estado.value;
		var codigopostal = f.codigopostal.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var fechanacimiento = f.fechanacimiento.value;
		var rfc = f.rfc.value;
		var edad_contratante = f.edad_contratante.value;
		var sexo = f.sexo.value;
		var aportaciones = f.aportaciones.value;
		var moneda = f.moneda.value;
		var fuma = f.fuma.value;
		var formaPago = f.formaPago.value;
		var seguroInvalidez = f.seguroInvalidez.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(calle == ""){
			error+= "\n Escriba la Calle";
		}
		if(noext == ""){
			error+= "\n Escriba el Numero Exterior";
		}
		if(cruzamientos == ""){
			error+= "\n Escriba los Cruzamientos";
		}
		if(colonia == ""){
			error+= "\n Escriba la Colonia";
		}
		if(ciudad == ""){
			error+= "\n Escriba la Ciudad";
		}
		if(estado == ""){
			error+= "\n Escriba el Estado";
		}
		if(codigopostal == ""){
			error+= "\n Escriba el Codigo Postal";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(fechanacimiento == "Día / Mes / Año (4 Digitos )" || fechanacimiento == ""){
			error+= "\n Escriba su Fecha de Nacimiento";
		}
		if(rfc == ""){
			error+= "\n Escriba su RFC";
		}
		if(edad_contratante == "Contractor" ||  edad_contratante == ""){
			error+= "\n Escriba su Edad";
		}
		if(sexo == ""){
			error+= "\n Seleccione su Sexo";
		}
		if(aportaciones == ""){
			error+= "\n Seleccione su Aportacion";
		}
		if(moneda == ""){
			error+= "\n Seleccione la Moneda";
		}
		if(fuma == ""){
			error+= "\n Seleccione si Fuma";
		}
		if(formaPago == ""){
			error+= "\n Seleccione la Forma de Pago";
		}
		if(seguroInvalidez == ""){
			error+= "\n Seleccione el Seguro de Invalidez";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function


	function validarSegDanos()
	{
		var f = document.formSegDanos;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var calle = f.calle.value;
		var noint = f.noint.value;
		var noext = f.noext.value;
		var cruzamientos = f.cruzamientos.value;
		var colonia = f.colonia.value;
		var ciudad = f.ciudad.value;
		var estado = f.estado.value;
		var codigopostal = f.codigopostal.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		
		var valorHouse = f.valorHouse.value;
		var valorContents = f.valorContents.value;
		var hidrometeorologicos = f.hidrometeorologicos.value;
		var construccion = f.construccion.value;
		var techos = f.techos.value;
		
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(calle == ""){
			error+= "\n Escriba la Calle";
		}
		if(noext == ""){
			error+= "\n Escriba el Numero Exterior";
		}
		if(cruzamientos == ""){
			error+= "\n Escriba los Cruzamientos";
		}
		if(colonia == ""){
			error+= "\n Escriba la Colonia";
		}
		if(ciudad == ""){
			error+= "\n Escriba la Ciudad";
		}
		if(estado == ""){
			error+= "\n Escriba el Estado";
		}
		if(codigopostal == ""){
			error+= "\n Escriba el Codigo Postal";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		
		if(valorHouse == ""){
			error+= "\n escriba el Valor de la House";
		}
		if(valorContents == ""){
			error+= "\n Escriba el Valor de los Contents";
		}
		if(hidrometeorologicos == ""){
			error+= "\n Seleleccione si Desea Seguro Hidrometeorologico";
		}
		if(construccion == ""){
			error+= "\n Escriba el Tipo de Construcción";
		}
		if(techos == ""){
			error+= "\n Escriba el Tipo de Techos";
		}
		
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	

	function validarSegAutosCamiones()
	{
		var f = document.formSegAutosCamiones;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var estado = f.estado.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var marca = f.marca.value;
		var anio = f.anio.value;
		var modelo = f.modelo.value;
		var clima = f.clima.value;
		var uso = f.uso.value;
		var transmision = f.transmision.value;
		var quemaCocos = f.quemaCocos.value;
		var cobertura = f.cobertura.value;
		var precio = f.precio.value;
		var formaPago = f.formaPago.value;
		var descripcion = f.descripcion.value;
		var adaptacion = f.adaptacion.value;
		var comentarios = f.comentarios.value;		

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(estado == ""){
			error+= "\n Escriba el Estado";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(marca == ""){
			error+= "\n Escriba la Marca";
		}
		if(anio == ""){
			error+= "\n Escriba el Año";
		}
		if(modelo == ""){
			error+= "\n Escriba el Modelo";
		}
		if(clima == ""){
			error+= "\n Seleccione el Clima";
		}
		if(transmision == ""){
			error+= "\n Seleccione la Transmision";
		}
		if(uso == ""){
			error+= "\n Seleccione el tipo de Uso";
		}
		if(quemaCocos == ""){
			error+= "\n Seleccione Quema Cocos";
		}
		if(cobertura == ""){
			error+= "\n Seleccione una Cobertura";
		}
		if(precio == ""){
			error+= "\n Escriba el Valor Factura";
		}
		if(formaPago == ""){
			error+= "\n Seleccione la Forma de Pago";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(descripcion == ""){
			error+= "\n Escriba la Descripcion del Auto";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function

	function validarSegVida()
	{
		var f = document.formSegVida;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var edad_contratante = f.edad_contratante.value;
		var sexo = f.sexo.value;
		var ahorro = f.ahorro.value;
		var moneda = f.moneda.value;
		var estatura = f.estatura.value;
		var peso = f.peso.value;
		var fuma = f.fuma.value;
		var formaPago = f.formaPago.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(edad_contratante == "Contractor" ||  edad_contratante == ""){
			error+= "\n Escriba su Edad";
		}
		if(sexo == ""){
			error+= "\n Seleccione su Sexo";
		}
		if(ahorro == ""){
			error+= "\n Seleccione Si Requiere Incluir Ahorro";
		}
		if(moneda == ""){
			error+= "\n Seleccione la Moneda";
		}
		if(estatura == ""){
			error+= "\n Escriba su Estatura";
		}
		if(peso == ""){
			error+= "\n Escriba su Peso";
		}
		if(fuma == ""){
			error+= "\n Seleccione si Fuma";
		}
		if(formaPago == ""){
			error+= "\n Seleccione la Forma de Pago";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	

	function validarSegDental()
	{
		var f = document.formSegDental;
		var nombre = f.nombre.value;
		var apellidos = f.apellidos.value;
		var telefono = f.telefono.value;
		var email = f.email.value;		
		var edad_contratante = f.edad_contratante.value;
		var sexo = f.sexo.value;
		var gmm = f.gmm.value;
		var comentarios = f.comentarios.value;

		var error = "";
		if(nombre == ""){
			error+= "\n Escriba un Nombre(s)";
		}
		if(apellidos == ""){
			error+= "\n Escriba un Apellido(s)";
		}
		if(telefono == ""){
			error+= "\n Escriba un Telefono";
		}
		if(email == ""){
			error+= "\n Escriba un Email";
		}
		if(edad_contratante == "Contractor" ||  edad_contratante == ""){
			error+= "\n Escriba su Edad";
		}
		if(sexo == ""){
			error+= "\n Seleccione su Sexo";
		}
		if(gmm == ""){
			error+= "\n Seleccione si Cuenta con Gastos Médicos Mayores";
		}
		if(comentarios == ""){
			error+= "\n Escriba un Comentario";
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function

	function validarSegAdquirir(idioma)
	{
		var idioma;
		var f = document.formSeguroAdquirir;
		var tipoSeguro = f.tipoSeguro.value;

		var error = "";
		if(tipoSeguro == ""){
			if(idioma == "en")
				{
					error+= "\n Select a type of insurance";
				}
			if(idioma == "sp")
				{
					error+= "\n Seleccione un tipo de seguro";
				}
		}
		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} // fin function
	
	
	


function  contadorTexto(campo, cuentaCampos, limiteMaximo)
        {
             if  (campo.value.length > limiteMaximo) //Si muy largo, cortar.
                campo.value = campo.value.substring(0, limiteMaximo);
             else
                 cuentaCampos.value = (limiteMaximo - campo.value.length);
        }
		
function validaTextoCita(){
	var texValido = /^[a-zA-Z]{3,3}[0-9]{6,6}[a-zA-Z]{2,2}[0-9]{1,1}[a-zA-Z0-9]*$/;
	if(!this.value.match(texValido)){
		this.value = 'RFC INCORRECTO';
	}
}

function noespacios() {
		var er = new RegExp(/\s/);
		var web = document.getElementById('cdusuario_web').value;
		if(er.test(web)){
			alert('No se permiten espacios');
			return false;
		}
                else
			return true;
	}
	
var nav4 = window.Event ? true : false; 
function acceptNum(evt){  
// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57  
var key = nav4 ? evt.which : evt.keyCode;  
return (key <= 13 || (key >= 48 && key <= 57)); 
} 

function validacionTerminarEmisionWs(){
	var MensajeDeError="Seleccione Una Aseguradora para la Emision !!!";
	
	var f = document.formTerminarActividadWs;
	var Resultado = f.Resultado.value;
	var comenResultado = f.comenResultado.value;
	
	var error = "";
	marcado=false; 
    var nombre; 
	
	for(a=0; a<f.elements.length; a++){
		if(f[a].type=="radio"){
			if(nombre!=f[a].name){
				nombre=f[a].name;
				for(aa=0;f[a+aa].name==f[a].name;aa++){
					if(f[a+aa].checked){marcado=true;}
					}
				if(marcado==false){alert(MensajeDeError);return false;}
			} 
            marcado=false; 
		} 
	} 
	
	if(error == ""){
		f.submit();
	} else {
		alert(error);	
	}		
}



function validacionAgregarMisContactos(){
	var f = document.formAgregarMisContactos;
	var Nombre_misContactos = f.Nombre_misContactos.value;
	var telefono_movil = f.telefono_movil.value;
	
	var error = "";
	
	if(Nombre_misContactos == ""){
		error+= "\n Escriba el Nombre del Contacto !!!";
	}

	if(telefono_movil == ""){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(telefono_movil.length < 10){
		error+= "\n Escriba el Telefono a 10 Digitos !!!";
	} else if(
			telefono_movil == '1111111111'
			||
			telefono_movil == '2222222222'
			||
			telefono_movil == '3333333333'
			||
			telefono_movil == '4444444444'
			||
			telefono_movil == '5555555555'
			||
			telefono_movil == '6666666666'
			||
			telefono_movil == '7777777777'
			||
			telefono_movil == '8888888888'
			||
			telefono_movil == '9999999999'
			||
			telefono_movil == '0000000000'
			||
			telefono_movil == '0123456789'
			||
			telefono_movil == '1234567890'
			 ){
				 error+= "\n Escriba el Telefono a 10 Digitos Valido !!!";
			 }
			 	
	if(error == ""){
		f.submit();
	} else {
		alert(error);
	}
}


function validacionTerminarActividad(tipoEmision){
	var f = document.formTerminarActividad;
	var Resultado = f.Resultado.value;
	var error = "";

	if(Resultado == "conEmision"){
		var emitirAseguradora = document.formTerminarActividad.emitirAseguradora.value;		

		if(emitirAseguradora == ""){
			error+= "\n Seleccione una Aseguradora para Emitir!!!";
		}

		if(error == ""){
			f.submit();
		} else {
			alert(error);
		}
	} else if(Resultado == "conEmisionManual"){
			f.submit();
	} else if(Resultado == "sinEmision"){
			f.submit();
	} else if(Resultado == "N/A"){
			f.submit();
	} else if(Resultado == "recotizar"){
			f.submit();
	}
}


	function calcularExtensionPhotoUser(nombreFormulario){
		var f = document.forms[nombreFormulario.name];		
		var archivo = f.imageUser.value;

		var extension = "";
		var error="";
		
		extension =(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
		f.extension.value = extension;
		
		if(
			(extension != ".jpg" && extension != ".JPG")
		){
			error+= "\n Seleccione un Archivo JPG";
		}
		
		if(error != ""){
			alert(error);
		}
			
	}


function currencyFormat(fld, milSep, decSep, e) { 
	var sep = 0; 
	var key = ''; 
	var i = j = 0; 
	var len = len2 = 0; 
    var strCheck = '0123456789'; 
    var aux = aux2 = ''; 
    var whichCode = (window.Event) ? e.which : e.keyCode; 
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode);
    if (strCheck.indexOf(key) == -1) return false;
    len = fld.value.length; 
    for(i = 0; i < len; i++) 
     if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break; 
    aux = ''; 
    for(; i < len; i++) 
     if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i); 
    aux += key; 
    len = aux.length; 
    if (len == 0) fld.value = ''; 
    if (len == 1) fld.value = '0'+ decSep + '0' + aux; 
    if (len == 2) fld.value = '0'+ decSep + aux; 
    if (len > 2) { 
     aux2 = ''; 
     for (j = 0, i = len - 3; i >= 0; i--) { 
      if (j == 3) { 
       aux2 += milSep; 
       j = 0; 
      } 
      aux2 += aux.charAt(i); 
      j++; 
     } 
     fld.value = ''; 
     len2 = aux2.length; 
     for (i = len2 - 1; i >= 0; i--) 
      fld.value += aux2.charAt(i); 
     fld.value += decSep + aux.substr(len - 2, len); 
    } 
    return false; 
}
