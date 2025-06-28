  <?php $this->load->view('generales/modalGenericoV3');?>
<style type="text/css">
.ks-cboxtags {
    list-style: none;
    padding-left: 20px;
    padding-right: 20px;
}
.ks-cboxtags li{
  display: inline;
}
.ks-cboxtags label{
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .5);
    color: #472380;
    border-radius: 25px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

.ks-cboxtags label {
    padding: 8px 12px;
    cursor: pointer;
}

.ks-cboxtags label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: "\2716";
    transition: transform .3s ease-in-out;
}

.ks-cboxtags input[type="checkbox"]:checked + label::before {
    content: "\2714";
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

.ks-cboxtags input[type="checkbox"]:checked + label {
    border: 2px solid #472380;
    background-color: #472380;
    color: #fff;
    transition: all .2s;
}

.ks-cboxtags input[type="checkbox"] {
  display: absolute;
}
.ks-cboxtags input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}
.ks-cboxtags input[type="checkbox"]:focus + label {
  border: 2px solid #472380;
}

</style>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="modificacionHorarios" role="dialog" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modificar horario de la persona</h5>
        <button type="button" class="btn" data-dismiss="modal" aria-label="Close" style="color: white;font-size: 12px;text-decoration: none;background: firebrick;border: none;border-radius: 25px;padding: 4px;">
          <i class="fa fa-times"></i>
        </button>
      </div>
      <div class="modal-body row" style="padding: 0px 15px 0px !important">
      	<input class="usuarioClass" type="hidden"  name="idPersonaHorario" id="idPersonaHorarioGlobal">

	<table class="table center mt-0 mb-0" >
		<th class="text-center">
			<td class="text-center">Hora de entrada</td>
			<td class="text-center">Hora de salida</td>
		</th>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox1" value="Lunes" onclick="timeOn(1)"><label for="checkbox1">Lunes</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada1"></td>
    	<td><input class="form-control" type="time" name="time" id="salida1" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox2" value="Martes" onclick="timeOn(2)"><label for="checkbox2">Martes</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada2" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida2" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox3" value="Miercoles" onclick="timeOn(3)"><label for="checkbox3">Miercoles</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada3" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida3" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox4" value="Jueves" onclick="timeOn(4)"><label for="checkbox4">Jueves</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada4" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida4" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox5" value="Viernes" onclick="timeOn(5)"><label for="checkbox5">Viernes</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada5" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida5" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"> <input type="checkbox" id="checkbox6" value="Sabado" onclick="timeOn(6)" ><label for="checkbox6">Sabado</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada6" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida6" ></td>
    </tr>
    <tr>
    	<td class="ks-cboxtags"><input type="checkbox" id="checkbox7" value="Domingo" onclick="timeOn(7)"><label for="checkbox7">Domingo</label></td>
    	<td><input class="form-control" type="time" name="time" id="entrada7" ></td>
    	<td><input class="form-control" type="time" name="time" id="salida7" ></td>
    </tr>

</table>
          <div class="col-md-12" style="padding-top: 1%;"><div class="col-md-4" style="padding-top: 2%;"><label class="Responsivo lbEtiqueta">Tipo de trabajo</label></div><div id="divTipoTrabajo" class="col-md-8">
            <select name="tipoTrabajo" id="tipoTrabajo" class="formEnviar form-control">
              <option value="0">Seleccione</option>
              <option value="Presencial">Presencial</option>
              <option value="Home Office">Home Office</option>
              <option value="Híbrido">H&iacute;brido</option>
            </select>
          </div></div> 

<div id="cargando" class="col-md-12 text-center" style="padding-top: 3%;"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>

        <button type="button" class="btn btn-primary"  onclick="actualizarHorario()">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    function traerColaboradorHorario(datos='')
    {
      if(datos=='')
      {
        let params=`idPersona=${document.getElementById('idPersonaHorarioGlobal').value}`;        
         peticionAJAXLib('persona/horariosColaboradorDevolver',params,'traerColaboradorHorario');
      } 
      else
      {
  
        llenarModal(datos.horarios.entradaLunes,datos.horarios.salidaLunes,datos.horarios.entradaMartes,datos.horarios.salidaMartes,datos.horarios.entradaMiercoles,datos.horarios.salidaMiercoles,datos.horarios.entradaJueves,datos.horarios.salidaJueves,datos.horarios.entradaViernes,datos.horarios.salidaViernes,datos.horarios.entradaSabado,datos.horarios.salidaSabado,datos.horarios.entradaDomingo,datos.horarios.salidaDomingo,datos.horarios.tipoTrabajo)
      }
    }
	function habilitarTime(){

		for (var j = 1; j <= 7; j++) {			
			id='checkbox'+j;
			var checkbox = document.getElementById(id);
			var checked = checkbox.checked;
					if(checked){
			$('#entrada'+j).removeAttr('disabled');
			$('#salida'+j).removeAttr('disabled');

		}else{
			$('#entrada'+j).attr('disabled', true);
			$('#salida'+j).attr('disabled', true);
		}
		}

	}
	function timeOn(x){
		var checkbox = document.getElementById('checkbox'+x);
			var checked = checkbox.checked;
					if(checked){
			$('#entrada'+x).removeAttr('disabled');
			$('#salida'+x).removeAttr('disabled');
			document.getElementById('entrada'+x).value="09:00";
			document.getElementById('salida'+x).value="18:00";


		}else{
			$('#entrada'+x).attr('disabled', true);
			$('#salida'+x).attr('disabled', true);
			document.getElementById('entrada'+x).value="";
			document.getElementById('salida'+x).value="";
		}
	}
	function actualizarHorario(){

		const HrentradaLunes = document.getElementById("entrada1");
		var entLunes= HrentradaLunes.value;

		const HrsalidaLunes = document.getElementById("salida1");
		var salLunes= HrsalidaLunes.value;

		const HrentradaMartes = document.getElementById("entrada2");
		var entMartes= HrentradaMartes.value;

		const HrsalidaMartes = document.getElementById("salida2");
		var salMartes= HrsalidaMartes.value;

		const HrentradaMiercoles = document.getElementById("entrada3");
		var entMiercoles= HrentradaMiercoles.value;

		const HrsalidaMiercoles = document.getElementById("salida3");
		var salMiercoles= HrsalidaMiercoles.value;

		const HrentradaJueves = document.getElementById("entrada4");
		var entJueves= HrentradaJueves.value;

		const HrsalidaJueves = document.getElementById("salida4");
		var salJueves= HrsalidaJueves.value;

		const HrentradaViernes = document.getElementById("entrada5");
		var entViernes= HrentradaViernes.value;

		const HrsalidaViernes = document.getElementById("salida5");
		var salViernes= HrsalidaViernes.value;

		const HrentradaSabado = document.getElementById("entrada6");
		var entSabado= HrentradaSabado.value;

		const HrsalidaSabado = document.getElementById("salida6");
		var salSabado= HrsalidaSabado.value;

		const HrentradaDomingo = document.getElementById("entrada7");
		var entDomingo= HrentradaDomingo.value;

		const HrsalidaDomingo = document.getElementById("salida7");
		var salDomingo= HrsalidaDomingo.value;



var idPersona=document.getElementById('idPersonaHorarioGlobal').value;

var tipoTrabajo=document.getElementById('tipoTrabajo').value;

var direccion=<?php echo('"'.base_url().'persona/actualizarHorario"'); ?>;

var parametros = {
                "idPersona" : idPersona,
                "entLunes": entLunes,
                "salLunes": salLunes,
                "entMartes": entMartes,
                "salMartes": salMartes,
                "entMiercoles": entMiercoles,
                "salMiercoles": salMiercoles,
                "entJueves": entJueves,
                "salJueves": salJueves,
                "entViernes": entViernes,
                "salViernes": salViernes,
                "entSabado": entSabado,
                "salSabado": salSabado,
                "entDomingo": entDomingo,
                "salDomingo": salDomingo,
                "tipoTrabajo":tipoTrabajo
        };

$.ajax({
                data:  parametros, //datos que se envian a traves de ajax
                url:   direccion, //archivo que recibe la peticion
                type:  'post', //método de envio
                beforeSend: function () {
                        $('#cargando').html(`
                    <div class="container-spinner-content-solicitudes-polizas">
                        <div class="cr-spinner spinner-border" role="status">
                            <span class="visually-hidden"></span>
                        </div>
                        <p class="cr-cargando" style="font-size:18px;">Cargando...</p>
                    </div>
                `);

                },
                success:  function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
                         swal("¡Modificado!","Actualizado con exito","success");
                         $('.swal-button--confirm').click(function() {
                         	document.getElementById("cargando").setAttribute("style", "visibility:hidden;");
					    		//location.reload();
							});

                }

        });
	}
function llenarModal(entrada1,salida1,entrada2,salida2,entrada3,salida3,entrada4,salida4,entrada5,salida5,entrada6,salida6,entrada7,salida7,tipoTrabajo){
	if(entrada1!=null&&salida1!=null){
		console.log(entrada1);
		if(entrada1.substr(0,5)!="00:00"&&salida1.substr(0,5)!="00:00"){
		document.getElementById('checkbox1').checked=true;
		document.getElementById('entrada1').value=entrada1.substr(0,5);
		document.getElementById('salida1').value=salida1.substr(0,5);
		}
	}
	if(entrada2!=null&&salida2!=null){
		if(entrada2.substr(0,5)!="00:00"&&salida2.substr(0,5)!="00:00"){
		document.getElementById('checkbox2').checked=true;
		document.getElementById('entrada2').value=entrada2.substr(0,5);
		document.getElementById('salida2').value=salida2.substr(0,5);
		}
	}
	if(entrada3!=null&&salida3!=null){
		if(entrada3.substr(0,5)!="00:00"&&salida3.substr(0,5)!="00:00"){
		document.getElementById('checkbox3').checked=true;
		document.getElementById('entrada3').value=entrada3.substr(0,5);
		document.getElementById('salida3').value=salida3.substr(0,5);
		}
	}
	if(entrada4!=null&&salida4!=null){
		if(entrada4.substr(0,5)!="00:00"&&salida4.substr(0,5)!="00:00"){
		document.getElementById('checkbox4').checked=true;
		document.getElementById('entrada4').value=entrada4.substr(0,5);
		document.getElementById('salida4').value=salida4.substr(0,5);	
		}
	}
	if(entrada5!=null&&salida5!=null){
		if(entrada5.substr(0,5)!="00:00"&&salida5.substr(0,5)!="00:00"){
		document.getElementById('checkbox5').checked=true;
		document.getElementById('entrada5').value=entrada5.substr(0,5);
		document.getElementById('salida5').value=salida5.substr(0,5);
		}
	}
	if(entrada6!=null&&salida6!=null){
		if(entrada6.substr(0,5)!="00:00"&&salida6.substr(0,5)!="00:00"){
		document.getElementById('checkbox6').checked=true;
		document.getElementById('entrada6').value=entrada6.substr(0,5);
		document.getElementById('salida6').value=salida6.substr(0,5);
		}
	}
	if(entrada7!=null&&salida7!=null){
		if(entrada7.substr(0,5)!="00:00"&&salida7.substr(0,5)!="00:00"){
		document.getElementById('checkbox7').checked=true;
		document.getElementById('entrada7').value=entrada7.substr(0,5);
		document.getElementById('salida7').value=salida7.substr(0,5);
		}
	}
	document.getElementById('tipoTrabajo').value=tipoTrabajo;

}
</script>