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