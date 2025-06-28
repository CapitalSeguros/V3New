
<?php $this->load->view('headers/header'); ?><?php $this->load->view('headers/menu');
?>

<div id="divContenedor">
	<div id="divMenu">
		<div>
			<div>
				<button  
					style="background-image:url(<?php echo(base_url().'assets/images/crm/alta.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu"
					onclick="cargarPagina('crmproyecto/agregarProspecto')"
				>
                </button>

			</div>
			<div>
				<button
					style="background-image:url(<?php echo(base_url().'assets/images/crm/seguimientoProspecccion.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu" 
					onclick="cargarPagina('crmproyecto/seguimientoProspecto')"
				>
				</button>
			</div>
                        <!--Ultima actualizacion Miguel Jaime 05/10/2020-->
			<div>
				<button 
					style="background-image:url(<?php echo(base_url().'assets/images/crm/agendacitasasesores.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu" 
					onclick="cargarPagina('crmproyecto/agenda_citas_asesores')"
				>
				</button>
			</div>
			<!--*** fin ****-->
			<div>
				<button 
					style="background-image:url(<?php echo(base_url().'assets/images/crm/administracionProspectos.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu" 
					onclick="cargarPagina('crmproyecto/Reportes')"
				>
				</button>
			</div>
			<div>
				<button style="background-image:url(<?php echo(base_url().'assets/images/crm/reporte.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/reporteComercial')">
				</button>
			</div>
			<div>
				<button style="background-image:url(<?php echo(base_url().'assets/images/crm/puntosGenerados.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/Estadistica')">
				</button>
			</div>
			<div>
				<button style="background-image:url(<?php echo(base_url().'assets/images/crm/funnel.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('funnel')">
				</button>
			</div>
	<?php 
		$usuario=$this->tank_auth->get_usermail();
        if($usuario=='SISTEMAS@ASESORESCAPITAL.COM' || $usuario=='DIRECTORGENERAL@AGENTECAPITAL.COM'  || $usuario=='COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX' || $usuario=='CCO@AGENTECAPITAL.COM' || $usuario=='COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM'){ 
	?>
		<div><button style="background-image:url(<?php echo(base_url().'assets/images/crm/reasignaAgente.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="traeAgentes('')"></button></div>
        <div><button style="background-image:url(<?php echo(base_url().'assets/images/crm/reasignaOperativo.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="traeOperativos('')"></button></div>
        <div><button style="background-image:url(<?php echo(base_url().'assets/images/crm/reasignados.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" class="buttonMenu" onclick="cargarPagina('crmproyecto/verReasignados')"></button></div>
        <?php } ?>
			<div>
				<button 
					style="background-image:url(<?php echo(base_url().'assets/images/crm/tableroClientes.png'); ?>);background-position:center; background-size: 100px;background-repeat: no-repeat;" 
					class="buttonMenu" 
					onclick="cargarPagina('crmproyecto/TableroClientes')"
				>
				</button>
			</div>
		</div>
	</div>
	<div id="divContenido">	
	</div>
</div>

<div id="divModalGenerico" class="modalCierra">
	<div class="modal-btnCerrar"><button onclick="cerrarModal('divModalGenerico')" style="color: white;background-color:red; border:double;">X</button></div>
    <div id="divModalContenidoGenerico" class="modal-contenido">
    

</div>
</div>
<div id="miModal" class="modalCierra">
    <div id="Modalcontenido" class="modal-contenido"  >
      <table border="2"  style="position:relative; top:10px; left:0px">
      <tr><td><button onclick="cerrar()" style="color: white;float:right;background-color:red; border:double;  ">Cerrar</button>  <td></tr>
        <tr><td><p>Titulo: <input type="text" id="tituloCita" autocomplete="off"></p></td></tr>
      <tr><td><p>Date: <input type="text" id="dpCita" autocomplete="off"></p></td></tr>
       <tr><td><p>De: <select id="selFecIniCita">
            <?php 
             $inicio=8;
             for($i=0;$i<12;$i++){
              echo('<option>'.$inicio.':00</option>');
              echo('<option>'.$inicio.':30</option>');
              $inicio++;
             }

            ?>
          </select>
       A:<select id="selFecFinCita">
            <?php 
             $inicio=8;
             for($i=0;$i<12;$i++){
              echo('<option>'.$inicio.':00</option>');
              echo('<option>'.$inicio.':30</option>');
              $inicio++;
             }

      
            ?>
          </select>
         <button onclick="guardaCita()" class="btn btn-primary">Guardar Cita</button>
           </td>
         </tr>
      <tr><td>    <div id='calendar'></div>

</td></tr>
</table>
    </div>
</div>
<div><img id="imgEspera" src="<?php echo(base_url().'assets/img/loading.gif');?>" class="divEspera ocultarObjeto"></div>



<script type="text/javascript">


	var contienePrspectoTD="";
	var nunRow="";
	
	function verificarPago(datos,folioActividad,IDCli,objeto){
   	        if(datos==''){
    	 var parametros="?";
    	 contienePrspectoTD=objeto.parentNode.parentNode;
	     parametros=parametros+'folioActividad='+folioActividad+'&IDCli='+IDCli;	     
	     peticionAJAX('crmproyecto/verificarPago/',parametros,'verificarPago');
        }	
        else{
        	if(datos.Documento!=''){
        		var insertar="";
        	 if(datos.pagado==1){
                  insertar='<a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento='+datos.Documento+'" target="_blank">Recibos<span class="badge">✔</span></a> ';
                  contienePrspectoTD.innerHTML=insertar;
        	 }	
        	 else{
        	 	insertar='<div class="btn-group" style="overflow: all;width: 200px"><button class="btn btn-primary btn-xs contact-item" onclick="verificarPago(\'\',\''+datos.folioActividad+'\','+datos.IDCli+',this)">Verificar pago</button>';
                  insertar=insertar+'<a class="btn btn-primary btn-xs contact-item" href="<?= base_url()?>crmproyecto/muestraRecibos?Documento='+datos.Documento+'" target="_blank">Recibos<span class="badge">X</span></a> </div>';
                  contienePrspectoTD.innerHTML=insertar;
        	 }
             
        	}
        	abreCierraEspera();
        	alert(datos.mensaje);
         // alert(datos.mensaje);
         // document.getElementById('tablaActivacion').deleteRow(numRow);
          //cargarPagina('crmproyecto/Reportes');
        }
   }

	function activarEnPausa(datos,IDCli,row){
        if(datos==''){
    	 var parametros="?";
	     parametros=parametros+'IDCli='+IDCli;
	     numRow=row.parentNode.parentNode.rowIndex;
	     peticionAJAX('crmproyecto/activarEnPausa/',parametros,'activarEnPausa');
        }	
        else{
         // alert(datos.mensaje);
          document.getElementById('tablaActivacion').deleteRow(numRow);
          cargarPagina('crmproyecto/Reportes');
        }	
        
	}
			
	function guardarSuspension(datos,idCliente){
if(datos==''){
	var fecha=document.getElementById('fechaPospuesto').value;	
	var parametros="?";
	parametros=parametros+'IDCli='+idCliente+'&fechaPospuesto='+fecha;    
	peticionAJAX('crmproyecto/suspenderCliente/',parametros,'guardarSuspension');

}else{
  //alert(datos.mensaje);
    cargarPagina('crmproyecto/Reportes');abreCierraEspera();
       document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');
}

	}
	
	function pantallaSuspension(idCliente,fecha){
	var cadena="";
    cadena=cadena+'<label>Fecha de recordatorio:</label><input type="text" id="fechaPospuesto" class="fecha form-control" value="'+fecha+'">';
    cadena=cadena+'<button class="btn btn-success" onclick="guardarSuspension(\'\','+idCliente+')">Guardar</button>';
    cadena=cadena+'<button class="btn btn-danger" onclick="cerrarModal(\'divModalGenerico\')">Cancelar</button>';
	document.getElementById('divModalContenidoGenerico').innerHTML=cadena;
    llamarDate();
     document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');	
	}

	function guardaPerfilProspecto(datos){
	if(datos!=''){
		alert(datos.respuesta);
		contienePrspectoTD.innerHTML='Perfilado';	abreCierraEspera();	
		  document.getElementById('divModalGenerico').classList.toggle('modalCierra');		  
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');    
	}else{		
	var formulario=document.getElementById('formProspecto');
	var cant=formulario.length;
	var parametros="?";
	for(var i=0;i<cant;i++){parametros=parametros+formulario[i].name+"="+formulario[i].value+"&";}	
	peticionAJAX('crmproyecto/insertaPerfilado/',parametros,'guardaPerfilProspecto');
  }

	}

	function perfilarProspecto(objeto,idProspecto){
	contienePrspectoTD=objeto.parentNode;
var form='<div style="padding:3%;width:1	00%;height:600px;overflow:scroll"><form id="formProspecto" method="post" class="formProspecto" action="<?=base_url().'crmproyecto/InsertaPerfilado' ?>"><label>Fuente de Prospecto</label><select name="fuente" id="fuente" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="AMIGODEESCUELA">Amigos de la Escuela</option><option value="AMIGODEFAMILIA">Amigos de la Familia</option><option value="VECINOS">Vecinos</option><option value="CONOCIDOPASATIEMPOS">Conocidos a traves de Pasatiempos</option><option value="FAMPROPIAOCONYUGUE">Familia Propia o Conyugue</option><option value="CONOCIDOGRUPOSOCIAL">Conocidos atraves de los grupos sociales</option><option value="CONOCIDOACTIVICOMUNIDAD">Conocidos por la actividad de la comunidad</option><option value="CONOCIDOANTIGUOEMPLEO">Conocidos de Antiguos Empleos</option><option value="PERSONASHACENEGOCIO">Personas con las que hace negocios</option><option value="CENTRODEINFLUENCIA">Centro de Influencia</option></select><br>';
form=form+'<label>Ingreso Mensual</label><select name="IngMen" id="IngMen" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MENOSDE$25000">Menos de $25000</option><option value="DE$25000A$60000">de $25000 a $60000</option><option value="DE$6000A$100000">de $60000 a $100000</option><option value="MASDE$100000">Mas de $100000</option></select><br>';
form=form+' <label>Rango de edad</label><select name="RangoEdad" id="RangoEdad" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MENOSDE18">Menos de 18</option><option value="DE19A35">de 19 a 35</option><option value="DE36A50">de 36 a 50</option><option value="DE51A65">de 51 a 65</option></select><br>';
form=form+'<label>Ocupacion</label><select name="ocupacion" id="ocupacion" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="AMADECASA">Ama de Casa</option><option value="EJECUTIVO">Ejecutivo</option><option value="EMPLEADO">Empleado</option><option value="ESTUDIANTE">Estudiante</option><option value="EMPRESARIO">Empresario</option><option value="GERENTE">Gerente</option><option value="NEGOCIOPROPIO">Negocio Propio</option><option value="PROFESIONISTAINDEPENDIENTE">Profesionista Independiente</option><option value="RETIRADO">Retirado</option><option value="OTROSEMPLEOS">Otros Empleos</option></select><br>';
form=form+' <label>Estado Civil</label><select name="estadocivil" id="estadocivil" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="CASADO">Casado</option><option value="CASADOCONHIJOS">Casado con hijos</option><option value="DIVORCIADOS">Divorciado</option><option value="DIVORCIADOSCONHIJOS">Divorciado con hijos </option><option value="SOLTERO">Soltero</option><option value="SOLTEROCONHIJOS">Soltero con hijos</option><option value="UNIONLIBRE">Union Libre</option><option value="UNIONLIBRECONHIJOS">Union Libre con hijos</option><option value="VIUDO">Viudo</option><option value="VIUDOCONHIJOS">Viudo con hijos</option></select><br>';
form=form+'<label>Tiempo de Conocer los Prospectos</label><select name="tiempoconocer" id="tiempoconocer" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MASDE5ANIOS">Mas de 5 Años</option><option value="DE2A5ANIOS">de 2 a 5 Años</option><option value="MENOSDE2ANIOS">Menos de 2 años</option></select><br>';
form=form+'<label>Frecuencia que lo vio(ulitmo 12 meses)</label><select name="frecuenciavio" id="frecuenciavio" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="MASDE5VECES">Mas de 5 Veces</option><option value="DE3A5VECES">de 3 a 5 Veces</option><option value="DE1A2VECES">de 1 a 2 Veces</option><option value="NOLOVIO">No lo vio</option></select><br>';
form=form+' <label>Posibilidad de Acercamiento</label><select name="posacercamiento" id="posacercamiento" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="FACILMENTE">Facilmente</option><option value="NOMUYFACIL">No muy Facil</option><option value="CONDIFICULTAD">Con Dificultad</option></select><br>';
form=form+'<label>Habilidad para dar Referencias</label><select name="habilidadref" id="habilidadref" size="1" class="form-control" ><option value="">Seleccione una opcion</option><option value="EXCELENTE">Excelente</option><option value="BUENA">Buena</option><option value="REGULAR">Regular</option></select><br>'
form=form+'<input type="hidden" name="IDCL" value="'+idProspecto+'"></form></div><button class="btn btn-success" onclick="guardaPerfilProspecto(\'\')">Aceptar</button><button class="btn btn-danger" onclick="perfilarProspecto(-1)">Cancelar</button>';

   document.getElementById('divModalContenidoGenerico').innerHTML=form;
   document.getElementById('divModalGenerico').classList.toggle('modalCierra');
   document.getElementById('divModalGenerico').classList.toggle('modalAbre');	
}




function verDetalle(objeto,rfc,razon,nombre,apellidop,apellidom,email,telefono,fecha,estado,observacion){
	contienePrspectoTD=objeto.parentNode;
	var form='<div style="padding:3%;width:100%;height:600px;overflow:scroll"><table style="width:70%;"><tr><td colspan="2"><h3>DETALLE DE PROSPECTO</h3></td></tr><tr><td>Estado Actual:</td><td>'+estado+'</td></tr><tr><td><label>RFC:</label></td><td>'+rfc+'</td></tr><tr><td><label>Razon Social:</label></td><td>'+razon+'</td></tr><tr><td>Apellido Paterno: </td><td>'+apellidop+'</td></tr><tr><td>Apellido Materno: </td><td>'+apellidom+'</td></tr><tr><td>Nombre: </td><td>'+nombre+'</td></tr><tr><td>Email: </td><td>'+email+'</td></tr><tr><td>Telefono: </td><td>'+telefono+'</td></tr><tr><td>Fecha: </td><td>'+fecha+'</td></tr><tr><td>Observaciónes:</td><td>'+observacion+'</td></tr></table></div>';
	document.getElementById('divModalContenidoGenerico').innerHTML=form;
	document.getElementById('divModalGenerico').classList.toggle('modalCierra');
	document.getElementById('divModalGenerico').classList.toggle('modalAbre');	
}



	
//----------------------------------------			
	function traeFunnelCoordinadores(datos){cargarPagina("funnel/?idCoordinador="+document.getElementById('selectPersonaCoordinador').value);}
	
//----------------------------------------
	function traeFunnelAgentes(datos){

	if(document.getElementById('selectAgentes').value>0){
	cargarPagina("funnel/?idCoordinador="+document.getElementById('selectPersonaCoordinador').value+"&idAgente="+document.getElementById('selectAgentes').value);
    }else{
    		cargarPagina("funnel/?idCoordinador="+document.getElementById('selectPersonaCoordinador').value);
    }
	}
	
//----------------------------------------
	function traeAgentes(datos){
if(datos!=''){
	var select='<div>Agentes</div><div><select class="form-control" id="selectPersona">';
	cantidad=datos.length;
	for(var i=0; i<cantidad;i++){select=select+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';	}
  select=select+'</select></div>';
  select=select+'<button class="btn-primary" onclick="transferirProspectos(\'\')">Transferir prospecto</button>';
document.getElementById('divModalContenidoGenerico').innerHTML=select;
abreCierraEspera();
      document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');

}
else{peticionAJAX('crmproyecto/devolverAgentes/','','traeAgentes');}


	}

//----------------------------------------
	function traeOperativos(datos){
if(datos!=''){
	var select='<div>Operativos</div><div><select class="form-control" id="selectPersona">';
	cantidad=datos.length;
	for(var i=0; i<cantidad;i++){select=select+'<option value="'+datos[i].idPersona+'">'+datos[i].nombre+'</option>';	}
  select=select+'</select></div>';
  select=select+'<button class="btn-primary" onclick="transferirProspectos(\'\')">Transferir prospecto</button>';
  document.getElementById('divModalContenidoGenerico').innerHTML=select;
abreCierraEspera();
    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');
}
else{peticionAJAX('crmproyecto/devolverOperativos/','','traeOperativos');}
	}
	
//----------------------------------------
	function transferirProspectos(datos){

if(datos!=''){alert(datos);abreCierraEspera();    document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');cargarPagina('crmproyecto/seguimientoProspecto');}
else{
	var elementos=document.getElementsByClassName('cbReasignar');
var cantidad=elementos.length;
idCliente="";
for(var i=0; i<cantidad;i++){if(elementos[i].checked){(idCliente=idCliente+elementos[i].value+'-');}}
	var parametros='?idCliente='+idCliente+'&idPersona='+document.getElementById('selectPersona').value;
	peticionAJAX('crmproyecto/transfiereProspectos/',parametros,'transferirProspectos');
   }
	}

//----------------------------------------
	function peticionAJAX(controlador,parametros,funcion){
  var req = new XMLHttpRequest();
  var direccionAJAX="<?= base_url();?>";
  var url=direccionAJAX+controlador+parametros;
abreCierraEspera();
 req.open('POST', url, true);
  req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {
    	if(req.status == 200)
        { 
         var respuesta=JSON.parse(this.responseText);
         console.log(respuesta);
         switch(funcion){
         	case 'traeAgentes':traeAgentes(respuesta);break;
         	case 'traeOperativos':traeOperativos(respuesta);break;
         	case 'transferirProspectos':transferirProspectos(respuesta);break;
         	case 'traeAgentesPorCoordinador':traeAgentesPorCoordinador(respuesta);break;
         	case 'guardaPerfilProspecto':guardaPerfilProspecto(respuesta);break;
         	case 'guardarSuspension':guardarSuspension(respuesta,'');break;
         	case 'activarEnPausa':activarEnPausa(respuesta,'');break;
         	case 'verificarPago':verificarPago(respuesta,'','');break;
         }                                                           
      }     
   }
  };
 req.send();
	}
	
//----------------------------------------
	function abreCierraEspera(){
document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
document.getElementById('imgEspera').classList.toggle('verObjeto');	
	}
	
//---------------------------------------
	function SendForm_JjHe(){
		var bandFalse=0;
		/*POR EL MOMENTO NO VA A VALIDAR DATOS HASTA NUEVO AVISO*/
   if(bandFalse==1){
 		var formulario = document.getElementById('formdimension');
		var nom	= document.getElementById('nombre').value;
		var ap	= document.getElementById('apellidop').value;
		var am	= document.getElementById('apellidom').value;
		var raz	= document.getElementById('razon').value;
		var rfc	= document.getElementById('rfc').value;
		var ema	= document.getElementById('email').value;
		var cel	= document.getElementById('celular').value;		
		/* Persona Moral */
		if(document.getElementById('tipo').checked ){
			if(raz !='' && rfc!=''  && ema!='' && cel!=''){ document.formdimension.submit();} 
			else {alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');}                 
		}		
		/* Persona Fisica */
		if(document.getElementById('tipo2').checked ){
			if(nom !='' && ap!=''  && ema!='' && cel!=''){document.formdimension.submit();} 
			else {alert('No capturaste Nombre o Apellidos, Es Obligatorio Email y Telefono');}
		}
	}
   else{document.formdimension.submit();}
	}




	function SendForm_JjHe_generico(){
		var bandFalse=0;
		/*POR EL MOMENTO NO VA A VALIDAR DATOS HASTA NUEVO AVISO*/
   if(bandFalse==1){
 		var formulario = document.getElementById('formdimension_generico');
		var nom	= document.getElementById('nombre_generico').value;
		var ap	= document.getElementById('apellidop_generico').value;
		var am	= document.getElementById('apellidom_generico').value;
		var raz	= document.getElementById('razon_generico').value;
		var rfc	= document.getElementById('rfc_generico').value;
		var ema	= document.getElementById('email_generico').value;
		var cel	= document.getElementById('celular_generico').value;		
		/* Persona Moral */
		if(document.getElementById('tipo_generico').checked ){
			if(raz !='' && rfc!=''  && ema!='' && cel!=''){ document.formdimension_generico.submit();} 
			else {alert('No capturaste Razon y RFC y Es Obligatorio Email y Telefono');}                 
		}		
		/* Persona Fisica */
		if(document.getElementById('tipo2_generico').checked ){
			if(nom !='' && ap!=''  && ema!='' && cel!=''){document.formdimension_generico.submit();} 
			else {alert('No capturaste Nombre o Apellidos, Es Obligatorio Email y Telefono');}
		}
	}
   else{document.formdimension_generico.submit();}
	}
</script>

<script>

	function guardaCita(){

var formulario=document.createElement('form'); formulario.setAttribute('method','post'); formulario.action=<?php echo('"'.base_url().'crmproyecto/guardaCita"'); ?>;
var inputFI=document.createElement('input'); inputFI.setAttribute('type','text');inputFI.setAttribute('name','fecIniCita'); inputFI.value=document.getElementById('selFecIniCita').value;
var inputFF=document.createElement('input'); inputFF.setAttribute('type','text');inputFF.setAttribute('name','fecFinCita'); inputFF.value=document.getElementById('selFecFinCita').value;
var inputF=document.createElement('input'); inputF.setAttribute('type','text');inputF.setAttribute('name','fecCita'); inputF.value=document.getElementById('dpCita').value;
var inputT=document.createElement('input'); inputT.setAttribute('type','text');inputT.setAttribute('name','tituloCita'); inputT.value=document.getElementById('tituloCita').value;
var inputC=document.createElement('input'); inputC.setAttribute('type','hidden');inputC.setAttribute('name','idClienteCita'); inputC.value="<?php echo($idCliente); ?>";

formulario.appendChild(inputFI);formulario.appendChild(inputFF);formulario.appendChild(inputF);formulario.appendChild(inputT);formulario.appendChild(inputC);
document.body.appendChild(formulario);
if(inputT.value=="" || inputF.value==""){alert("Debe llevar titulo y fecha");}
else
{  
  var fechaInicial=inputFI.value;fechaInicial=fechaInicial.replace(":","");
  var fechaFinal=inputFF.value;fechaFinal=fechaFinal.replace(":","");
  if(parseInt(fechaFinal)>parseInt(fechaInicial)){formulario.submit();}
  else{alert("la fecha final debe ser mayor a la inicial")}
 }
	}
	
//----------------------------------------
	function enviarArchivo(objeto){
		objeto.setAttribute('name',objeto.id);
		var formulario=document.createElement('form'); 
		formulario.setAttribute('method','post');formulario.enctype='multipart/form-data';formulario.action=<?php echo('"'.base_url().'crmproyecto/guardaArchivo"'); ?>;formulario.appendChild(objeto);
		document.body.appendChild(formulario);
		
		formulario.submit();
	}

//----------------------------------------
	function verDocumentos(idProspecto){
  var req = new XMLHttpRequest();
  req.open('GET', '<?=base_url()?>crmproyecto/devuelveDocumentos/?idProspecto='+idProspecto, true);
  req.onreadystatechange = function (aEvt) 
  {document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
     if	(document.getElementById("divVentanaDocumentos")){document.head.removeChild(document.getElementById('divVentanaDocumentosEstilo'));}
     if(document.getElementById('divVentanaDocumentos')){document.body.removeChild(document.getElementById('divVentanaDocumentos'));}
     if (req.readyState == 4) {if(req.status == 200)
       {var j=JSON.parse(this.responseText);   
       	document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
        if(j==0){alert("Este usuario no tiene documento");}
        else
        {
        	var hoja = document.createElement('style');var div=document.createElement('div');div.id="divVentanaDocumentos";
        div.innerHTML=j["datos"];
        hoja.id="divVentanaDocumentosEstilo";hoja.type="text/css";hoja.innerHTML=j['estilo'];
        document.head.appendChild(hoja);document.body.appendChild(div);
        document.getElementById("divVentanaDocumentos").classList.add('ventanaDocumentosEstilo');
       }                                                 
      }     
   }
  };
 req.send();
	}

//----------------------------------------
	function direccionAJAX(idProspecto,opcion){
	var direccionAJAX="<?php echo(base_url().'crmproyecto/');?>";
	switch(opcion){
	case 'muestraDocumentos':direccionAJAX=direccionAJAX+'documentos/?idProspecto='+idProspecto; break;
    case 'muestraVentana':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&tipoCCC=0"; break;
  	case 'nuevoComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&nuevoComentario="+document.getElementById('textNuevoComentario').value+"&tipoCCC=0"; break;
  	case 'eliminaComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&eliminaComentario="+document.getElementById('textNuevoComentario').value+"&tipoCCC=0"; break;
  	case 'modificaComentario':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&modificaComentario="+document.getElementById('comentario'+idProspecto).value+"&tipoCCC=0"; break;
	case 'ventanaCCC':direccionAJAX=direccionAJAX+'ventanaCitaContacto/?idProspecto='+idProspecto ;break;
	case 'guardarCCC': direccionAJAX=direccionAJAX+'guardarContactoCita/?idProspecto='+idProspecto+"&citaContacto="+document.getElementById("dpCitaContacto").value+"&tipoCCC="+document.getElementById("tipoCCC").value+"&selectFechaDeCC="+document.getElementById("selectFechaDeCC").value+"&selectFechaACC="+document.getElementById("selectFechaACC").value;break;
	case 'modificaCCC':direccionAJAX=direccionAJAX+'comentarios/?idProspecto='+idProspecto+"&modificaComentario="+document.getElementById('comentario'+idProspecto).value+"&tipoCCC=1"; break;
	}	
	
  conectaAJAX(direccionAJAX);
	}
	
//----------------------------------------
	function conectaAJAX(direccionAJAX){
  var req = new XMLHttpRequest();
  req.open('GET',direccionAJAX, true);
  document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');
     if	(document.getElementById("divVentanaComentarios")){document.body.removeChild(document.getElementById('divVentanaComentarios'));}
     if(document.getElementById("divVentanaComentarioEstilo")){document.head.removeChild(document.getElementById('divVentanaComentarioEstilo'));}

     var j=JSON.parse(this.responseText);
      var hoja = document.createElement('style');hoja.id="divVentanaComentariosEstilo";
     document.head.appendChild(hoja);                   
     var div=document.createElement('div');div.id="divVentanaComentarios";div.innerHTML=j["datos"];
     hoja.type="text/css";
     hoja.innerHTML=j['estilo'];
     document.body.appendChild(div);
     document.getElementById("divVentanaComentarios").classList.add('estilo');
     asignaCalendario();                                                     
      }     
   }
  };
 req.send();
	}
</script>

<script type="text/javascript">	

	function asignaCalendario(){
 $( function() {
    $( "#dpCitaContacto" ).datepicker({
      changeMonth: true,changeYear: true,showWeek: true,firstDay: 1,  dateFormat: 'dd/mm/yy',
      regional:"fr",closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],

    });
    } );
  }
</script>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> Ojo Complemeto en Conflicto con easytree -->
<script src="https://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<script type="text/javascript">

	function cerrarModal(modal){
     document.getElementById(modal).classList.toggle('modalCierra');
     document.getElementById(modal).classList.toggle('modalAbre');   
	}
	
	function cerrar(){
		 document.getElementById("miModal").classList.add("modalCierra");document.getElementById("miModal").classList.remove("modalAbre");document.getElementById("Modalcontenido").style.display="none";
 
 	}
	
	function abrir(){
		document.getElementById("miModal").classList.remove("modalCierra");document.getElementById("miModal").classList.add("modalAbre");document.getElementById("Modalcontenido").style.display="block";
 $( function() {
 	$( "#dpCita" ).datepicker({
      changeMonth: true,changeYear: true,showWeek: true,firstDay: 1,regional:"fr",closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',dateFormat: 'dd/mm/yy',dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],     changeMonth: true,
    changeYear: true,     


    });
  } );
 
 	}
</script>
<script>
</script>

<style type="text/css">    
    .buttonMenu{border-color: #472380; clear: both;height: 100px;max-width: 25%;background-color: white; color:black; min-width: 100px}
    .buttonMenu:hover{background-color: #f0e7ff; cursor: pointer;}
    #divContenedor{width: 100%;display: flex;height:auto}
	#divMenu{width: 2%;min-width: 120px; height: 500px; overflow-y: auto;}
	/*#divMenu{transform: scale(.5,1.5);margin-left: 0px;position: inherit; top:120px; left: -120px}*/
	#divContenido{width: 95%;background-color: white;margin-left: 5%; overflow: scroll; height: 500px}   
	body, html {width: 100%; }
</style>
<style>
.modal-btnCerrar{background-color:white;width:800px;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido{background-color:white;width:800px;height:100%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modal-contenido1{background-color:white;width:400px;height:50%;padding: 0% 0%;margin: 0% auto;position: relative;z-index: 1000 }
.modalCierra{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:0;opacity:0;transition: all 1s;display:none;z-index: 1000}
.modalAbre{background-color: rgba(0,0,0,.8);position:fixed;top:0;right:0;bottom:0px;left:-100;transition: all 1s;width:100%;height:100%;display:block;relative;z-index: 1000}
.labelEditar{display: block; }
.labelEditar input{width: 100%; border: solid 1px black; color: black; background-color: #d7d1e1}
.divEspera{width: 80px;height: 80px;margin-top: -23px;margin-left: -163px;left: 50%;top: 50%;position: absolute;}
.verObjeto{display: block;}
.ocultarObjeto{display: none}
.formProspecto > label{color: black; text-decoration: underline;}

</style>


<script>

function buscarCliente(e){
e.preventDefault();
 if(document.getElementById("busquedaUsuario").value==''){window.alert('Escribir nombre de cliente');document.getElementById("busquedaUsuario").focus();
}
 else{enviarArchivoAJAX('formBuscarCliente','seguimientoProspecto');}

}
	function SendForm_ReporteComercial(){
		var formulario	= document.getElementById('formReporteComercial');
		var year		= document.getElementById('year').value;
		var month		= document.getElementById('month').value;
		var filtroFechasChec = document.getElementById('filtroFechasChec').value;
		
		if((year!='' && month!='') || filtroFechasChec != ''){
					//document.formReporteComercial.submit();
			enviarArchivoAJAX('formReporteComercial','verReporteComercial');
		} else {
					alert('No capturaste Año ó Mes');
		}
	}	

	function enviarArchivoAJAX(formulario,controlador)
	{
		var Data	= new FormData(document.getElementById(formulario));
		document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
		document.getElementById('imgEspera').classList.toggle('verObjeto');
		if(window.XMLHttpRequest){
			var Req	= new XMLHttpRequest();
		} else if(window.ActiveXObject){
			var Req = new ActiveXObject("Microsoft.XMLHTTP");
		}
		var direccion= <?= ('"'.base_url().'crmproyecto/"'); ?> + controlador;
		
		Req.open("POST",direccion, true);
		Req.onload	= function(Event){
			if (Req.status == 200){
				document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
				document.getElementById('imgEspera').classList.toggle('verObjeto');
				divContenido.innerHTML=Req.responseText;
			} else {				
			}
		};
  
		Req.send(Data);
	}
</script>
<script type="text/javascript">

function cargarPagina1(controlador,id){	

   if(controlador!=""){  
   document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');      
	    var xhr=new XMLHttpRequest();url=<?='"'.base_url().'"'?>+controlador+'?id='+id;xhr.open('POST',url,true);
        xhr.onload=function(){if(this.status==200){document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
        if(<?='"'.base_url().'auth/login"'?>==xhr.responseURL){window.location.replace(xhr.responseURL);}
   document.getElementById('imgEspera').classList.toggle('verObjeto');divContenido.innerHTML=xhr.responseText;$('#calendar').fullCalendar()}}
        xhr.send();}
}

function cargarPagina(controlador){	

   if(controlador!=""){  
   document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');      
	    var xhr=new XMLHttpRequest();url=<?='"'.base_url().'"'?>+controlador;xhr.open('POST',url,true);
        xhr.onload=function(){if(this.status==200){document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
        if(<?='"'.base_url().'auth/login"'?>==xhr.responseURL){window.location.replace(xhr.responseURL);}
   document.getElementById('imgEspera').classList.toggle('verObjeto');divContenido.innerHTML=xhr.responseText;$('#calendar').fullCalendar()}}
        xhr.send();}
}
	function enviaFormReportClient(e){
		e.preventDefault();
		
		if(document.getElementById("vendedorp").value==''){
			alert('Escoger Agente')
		} else {
			enviarArchivoAJAX('infoagente','Reportes');
		}
	}
	
	function enviaFormReportClientTab(e){
		e.preventDefault();
		
		if(document.getElementById("vendedorp").value==''){
			alert('Escoger Agente')
		} else {
			enviarArchivoAJAX('infoagente','ReportesTablero');
		}
	}
	
	
	function enviaFormBuscaCliente(e){
		e.preventDefault();
		if(document.getElementById("busquedaUsuario").value==''){
			alert('Escoger cliente')
		} else {
			enviarArchivoAJAX('formBuscaCliente','Reportes');
		}
	}
	
	function enviaFormBuscaClienteTab(e){
		e.preventDefault();
		if(document.getElementById("busquedaUsuario").value==''){
			alert('Escoger cliente')
		} else {
			enviarArchivoAJAX('formBuscaCliente','ReportesTablero');
		}
	}

function eliminarCliente(IDCli,EDOANT,row){
 if(IDCli!="")
 {
   var direccionAJAX="<?php echo(base_url().'crmproyecto/');?>";
   direccionAJAX=direccionAJAX+'Eliminar/?EDOANT='+EDOANT+"&IDCL="+IDCli+"&row="+row; 
   conectarAJAXMovimientos(direccionAJAX);
  }
 else{if(row!=""){document.getElementById("Mitabla").deleteRow(row.row);alert(row.mensaje);}}
}

function editarCliente(IDCli,respuesta){
 if(IDCli!=""){
 var direccionAJAX="<?php echo(base_url().'crmproyecto/');?>";
 direccionAJAX=direccionAJAX+'editPros/?'+"&IDCli="+IDCli; 
 conectarAJAXMovimientos(direccionAJAX);
 }else{
        var datos='<div ><form id="formEditarCliente"><label class="labelEditar">Apellido Paterno:<input type="text" name="ApellidoP"  value="'+respuesta.detalleUsuario[0].ApellidoP+'"></label>';
      datos=datos+'<label class="labelEditar">Apellido Matero:<input type="text" name="ApellidoM" value="'+respuesta.detalleUsuario[0].ApellidoM+'"></label>';
      datos=datos+'<label class="labelEditar">Nombres:<input type="text" name="Nombre" value="'+respuesta.detalleUsuario[0].Nombre+'"></label>';
      datos=datos+'<label class="labelEditar">Email:<input type="text" name="EMail1" value="'+respuesta.detalleUsuario[0].EMail1+'"></label>';
      datos=datos+'<label class="labelEditar">Telefono:<input type="text" name="Telefono1" value="'+respuesta.detalleUsuario[0].Telefono1+'"></label>';
      datos=datos+'<label class="labelEditar">Razon Social:<input type="text" name="RazonSocial" value="'+respuesta.detalleUsuario[0].RazonSocial+'"></label>';
       datos=datos+'<input type="hidden" value="'+respuesta.detalleUsuario[0].IDCli+'" name="IDCl">';
      datos=datos+'<label class="labelEditar">RFC:<input type="text" name="RFC" value="'+respuesta.detalleUsuario[0].RFC+'"></label><form></div>';     
    datos=datos+'<button onclick="guardarCambiosProspecto()">Guardar</button>';            
     document.getElementById('divModalContenidoGenerico').innerHTML=datos;
     document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');     
 }
}
function guardarCambiosProspecto(){
	   document.getElementById('divModalGenerico').classList.toggle('modalCierra');
     document.getElementById('divModalGenerico').classList.toggle('modalAbre');   
	 enviarArchivoAJAX('formEditarCliente','actualizaProspecto');
}
function conectarAJAXMovimientos(direccionAJAX){
  var req = new XMLHttpRequest();req.open('GET',direccionAJAX, true);
     document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
   document.getElementById('imgEspera').classList.toggle('verObjeto');  
   req.onreadystatechange = function (aEvt) 
  {
    if (req.readyState == 4) {if(req.status == 200)
    {  
    	var respuesta=JSON.parse(this.responseText);    
    	    document.getElementById('imgEspera').classList.toggle('ocultarObjeto');
      switch(respuesta.respuesta){
      	case 'Eliminar':eliminarCliente("","",respuesta);break;
      	case 'Editar':editarCliente("",respuesta);break;
        case 'clienteXmes':traerDatosFunnelMes("","","",respuesta.datos);break;
      }                                             
    }     
   }
  };
 req.send();
}
function traerDatosFunnelMes(anio,mes,posicion,datos){
	if(anio!=''){
    var direccionAJAX="<?php echo(base_url().'funnel/');?>";    
    direccionAJAX=direccionAJAX+'devolverClientesPorMes/?anio='+anio+"&mes="+mes+"&posicion="+posicion; 
    if(document.getElementById('selectPersonaCoordinador'))
    {
      if(document.getElementById('selectAgentes')){
      	     if(document.getElementById('selectAgentes').value>0)
         {
          direccionAJAX=direccionAJAX+'devolverClientesPorMes/?anio='+anio+"&mes="+mes+"&posicion="+posicion+"&idPersona="+document.getElementById('selectAgentes').value;
         }
         else
         {
         	direccionAJAX=direccionAJAX+'devolverClientesPorMes/?anio='+anio+"&mes="+mes+"&posicion="+posicion+"&idPersona="+document.getElementById('selectPersonaCoordinador').value;
         }
      }
     else{


     if(document.getElementById('selectPersonaCoordinador').value>0)
     {
        direccionAJAX=direccionAJAX+'devolverClientesPorMes/?anio='+anio+"&mes="+mes+"&posicion="+posicion+"&idPersona="+document.getElementById('selectPersonaCoordinador').value;
     } 
    }
    }
    conectarAJAXMovimientos(direccionAJAX);	
  }
  else{

  	cantDimension=datos.DIMENSION.length;
  	cantPerfilado=datos.PERFILADO.length;
  	cantContactado=datos.REGISTRADO.length;
  	cantCotizado=datos.COTIZADO.length;
  	 	cantPagado=datos.PAGADO.length
  	var div="";
  
  	for(var i=0;i<cantDimension;i++){div=div+'<label style="z-index:2">->'+datos.DIMENSION[i].ApellidoP+' '+datos.DIMENSION[i].ApellidoM+' '+datos.DIMENSION[i].Nombre+' Razon Social:'+datos.DIMENSION[i].RazonSocial+'</label></br>';
  	}
  	document.getElementById('divDimension').innerHTML=div;
  	div="";
  	for(var i=0;i<cantPerfilado;i++){div=div+'<label style="z-index:2">->'+datos.PERFILADO[i].ApellidoP+' '+datos.PERFILADO[i].ApellidoM+' '+datos.PERFILADO[i].Nombre+'</label></br>';
  	}
  	document.getElementById('divPerfilado').innerHTML=div;

div="";
  	for(var i=0;i<cantContactado;i++){div=div+'<label style="z-index:2">->'+datos.REGISTRADO[i].ApellidoP+' '+datos.REGISTRADO[i].ApellidoM+' '+datos.REGISTRADO[i].Nombre+'</label></br>';
  	}
  	document.getElementById('divContactado').innerHTML=div;

div="";
  	for(var i=0;i<cantCotizado;i++){div=div+'<label style="z-index:2">->'+datos.COTIZADO[i].ApellidoP+' '+datos.COTIZADO[i].ApellidoM+' '+datos.COTIZADO[i].Nombre+'</label></br>';
  	}
  	document.getElementById('divCotizado').innerHTML=div;


div="";
  	for(var i=0;i<cantPagado;i++){div=div+'<label style="z-index:2">->'+datos.PAGADO[i].ApellidoP+' '+datos.PAGADO[i].ApellidoM+' '+datos.PAGADO[i].Nombre+'</label></br>';
  	}
  	document.getElementById('divPagado').innerHTML=div;

  	document.getElementById("Vdimension").value=cantDimension;
  	document.getElementById("Vperfilado").value=cantPerfilado;
  	document.getElementById("Vcontactado").value=cantContactado;
  	document.getElementById("Vcotizado").value=cantCotizado;
  	document.getElementById("Vpagado").value=cantPagado;
  }
}
</script>

<script>
var rowAnterior;var objetoClickAnterior;var objetoClick;
//var largoTabla=t_Funnel.rows[0].cells.length;var appen=false;

function  F_borrar()
{var alto=t_Funnel.rows.length;var row;
  for(var i=0;i<alto;i++){if(t_Funnel.rows[i].className=="fondoClickRow"){row=t_Funnel.rows[i].rowIndex;}
}
var idFun=t_Funnel.rows[row].cells[0].innerHTML;
  var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var rutabsoluta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    rutabsoluta=rutabsoluta+"funnel/cancelaFunnel";
  $.ajax({
    method:"POST",data:{"datos":idFun},url:rutabsoluta,dataType:"html",
    success:function(data){t_Funnel.deleteRow(row);alert("El funnel fue eliminado");}
  })
}

function F_cancelar(){t_Funnel.deleteRow(1);}


/*function F_guardar(){
	var mensaje=confirm("EL GUARDADO ES PARA EL FUNNEL NUEVO, DESEA PROSEGUIR");
	if(mensaje)
    { var cadena="";
	 for(var i=0;i<largoTabla;i++){
	 if((largoTabla-1)==i)
	 {cadena=cadena;cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
     cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML;
	}else
	 {cadena=cadena;
     cadena=cadena+t_Funnel.rows[0].cells[i].id+':';
     cadena=cadena+t_Funnel.rows[1].cells[i].innerHTML+',';
     }
	}	
	var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var rutabsoluta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    rutabsoluta=rutabsoluta+"funnel/guardaNuevo";

	$.ajax({
		method:"POST",data:{"datos":cadena},url:rutabsoluta,dataType:"html",
		success:function(data){
      console.log(data);
        	var j=JSON.parse(data);
			if(typeof(j)=="number"){
          	var valor=(-1)*(data);          	
          switch(valor){
             case 1:alert("El contrato a cerrar debe ser mayor de cero"); break;
             case 2:alert("El ticket promedio y el objetivo mensual deben ser mayores de cero"); break;
             case 3:alert("Los porcentajes deben ser mayor 0"); break;
             case 4:alert("Los porcentajes son menores o igual a 100"); break;
             case 5:alert("Error en la fecha seleccionada"); break;
             case 6:alert("Error en el mes seleccionado");break;
            }
			}
			else
			{var altoT=t_Funnel.rows.length;             
			 var row=t_Funnel.insertRow(altoT);	
       row.addEventListener("click",function(){cambiaClickTabla(this)});
       row.addEventListener("mouseover",function(){cambiaFocoTabla(this)});
       //row.className="fondoClickRow";//fondoNoSelecRow";
       
	   for(var i=0;i<largoTabla;i++){row.insertCell(i).innerHTML="-";}	
			 var objeto=  Object.keys(j[0]);
			 var long=objeto.length;    
       for(var t=0;t<long;t++)
       {var nombre=objeto[t];
        if(document.getElementById(objeto[t]))
         {t_Funnel.rows[altoT].cells[document.getElementById(objeto[t]).cellIndex].innerHTML=j[0][nombre];          
         }
       }
      cambiaClickTabla(row);
       t_Funnel.deleteRow(1);
			}
		}
	})}else{alert("GUARDADO EN ESPERA");}   
 }*/



/*function F_append(){
var row=t_Funnel.insertRow(1);
for(var i=0; i<largoTabla;i++){
  row.insertCell(i);
  if(t_Funnel.rows[0].cells[i].id=="anio")
  {row.cells[i].innerHTML="2017";}
  if(t_Funnel.rows[0].cells[i].id=="id")
  {row.cells[i].innerHTML="NUEVO";}

  row.className="fondoRowNuevo";
  if(t_Funnel.rows[0].cells[i].id != "anio" && t_Funnel.rows[0].cells[i].id != "mes")
    {var ob="V"+t_Funnel.rows[0].cells[i].id;  	
     if(document.getElementById(ob))
     	{document.getElementById(ob).value="";}}
 }
 row.addEventListener("click",function(){cambiaClickTabla(this)}); 
 cambiaClickTabla(row);
//cambiaClickTabla(Vsuspecto);
Vsuspecto.value="100";
Vprospecto.value="100";
Vimpacto.value="100";
Vseguimiento.value="100";
suspect.innerHTML="0";
prospect.innerHTML="0";
impact.innerHTML="0";
seguimient.innerHTML="0";
}*/


/*for(var i=0; i<largoTabla;i++){	
	var obj="V"+t_Funnel.rows[0].cells[i].id;	
   if(document.getElementById(obj)){
  
   	  document.getElementById(obj).addEventListener("change",function(){cambia(this.id)});  
   }
}*/

function modificaTablaFunnel(id,valor){var columna=id.substring(1, id.length);}

function cambiaClickTabla(objeto){
var bandNuevo=objeto.cells[0].innerHTML;
if(bandNuevo=="NUEVO"){
var largo=objeto.cells.length;
	for(var i=0;i<largo;i++){
	var idCab=objeto.parentNode.rows[0].cells[i].id;
if(document.getElementById("V"+idCab)){		
   document.getElementById("V"+idCab).value=objeto.cells[i].innerHTML;	
   document.getElementById("V"+idCab).className="fondoEditNuevo";

   if(idCab!="dimension" && idCab!="perfilado" && idCab!="pagado" && idCab!="contactado" && idCab!="cotizado" && idCab!="contratoCerrar" )   	
    {document.getElementById("V"+idCab).disabled="";}
    else{document.getElementById("V"+idCab).disabled="disabled";}  
   }
}
}else{
//if(bandNuevo!="NUEVO")
objeto.className="fondoClickRow";	

objetoClick=objeto;
var largo=objeto.cells.length;
for(var i=0;i<largo;i++){
	var idCab=objeto.parentNode.rows[0].cells[i].id;
if(document.getElementById("V"+idCab)){		
   document.getElementById("V"+idCab).value=objeto.cells[i].innerHTML;
     //document.getElementById("V"+idCab).className="fondoEditExistente";
        document.getElementById("V"+idCab).disabled="disabled";       
   }	
}
if(objetoClickAnterior){objetoClickAnterior.className="fondoNoSelecRow";}
//if(bandNuevo!="NUEVO")	
objetoClickAnterior=objeto;
}
cambia();
}

function cambiaFocoTabla(objeto){
if(objeto.className!="fondoClickRow")
 {objeto.className="fondoSelecRow";
  if(rowAnterior && rowAnterior.className!="fondoClickRow")
  {rowAnterior.className="fondoNoSelecRow";}
   rowAnterior=objeto;
  }
}


function cambia(id){
var n1=Number(Vseguimiento.value);
var n2=Number(Vimpacto.value);
var n3=Number(Vprospecto.value);
var n4=Number(Vsuspecto.value);
var n5=Number(VobjetivoMensual.value);
var n6=Number(VticketProm.value);
var n7=Number(Vcomision.value)

if(!isNaN(n1) && n1>0 && !isNaN(n2) && n2>0 && !isNaN(n3) && n3>0 && !isNaN(n4) && n4>0 && n5>0 && !isNaN(n5)  && !isNaN(n6) && n6>0 && !isNaN(n7) && n7>0  ){
var calculado=(VcontratoCerrar.value*100)/Vseguimiento.value;
t_Funnel.rows[1].cells[seguimiento.cellIndex].innerHTML=Vseguimiento.value;//Math.round(calculado);
seguimient.innerHTML=Math.round(calculado);
if(!isNaN(Vimpacto.value))
calculado=(calculado*100)/Vimpacto.value;

t_Funnel.rows[1].cells[impacto.cellIndex].innerHTML=Vimpacto.value;//Math.round(calculado);

  impact.innerHTML=Math.round(calculado);
if(Vprospecto.value>0)
calculado=(calculado*100)/Vprospecto.value;
t_Funnel.rows[1].cells[prospecto.cellIndex].innerHTML=Vprospecto.value;//Math.round(calculado);
prospect.innerHTML=Math.round(calculado);
if(Vsuspecto.value>0)
calculado=(calculado*100)/Vsuspecto.value;
t_Funnel.rows[1].cells[suspecto.cellIndex].innerHTML=Vsuspecto.value;//Math.round(calculado);
suspect.innerHTML=Math.round(calculado);
porFinal.innerHTML=Math.round((VcontratoCerrar.value*100)/calculado)+"%";
Otn4.innerHTML=Vseguimiento.value+"%{";
Otn3.innerHTML=Vimpacto.value+"%{";
Otn2.innerHTML=Vprospecto.value+"%{";
Otn1.innerHTML=Vsuspecto.value+"%{";

if(id!="Vmes" && id!="Vanio"){
cantidad=Vcomision.value/100;
cantidad=cantidad*VticketProm.value;
var objetivo=VobjetivoMensual.value / cantidad;
entero=Math.floor(objetivo);
var contrato;
if(entero-objetivo==0){contrato=entero}
else{contrato=entero+1; } 
VcontratoCerrar.value=contrato;
cerrar.innerHTML=contrato;
t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML=contrato;
if(!isNaN(n1) && n1==0){Vseguimiento.value=100;}
if(!isNaN(n2) && n2==0) { Vimpacto.value=100;} 
if(!isNaN(n3) && n3==0){Vprospecto.value=100;} 
if(!isNaN(n4) && n4==0 ){Vsuspecto.value=100;} 
if(!isNaN(n1) && n1==100 && !isNaN(n2) && n2==100 && !isNaN(n2) && n3==100 && !isNaN(n2) && n4==100){
  impact.innerHTML=contrato;
  prospect.innerHTML=contrato;suspect.innerHTML=contrato;seguimient.innerHTML=contrato;porFinal.innerHTML="100%"}
}


}
if(id=="VobjetivoMensual" || id=="VticketProm" || id=="Vcomision" || id=="Vmes" || id=="Vanio"){
var columna=id.substring(1, id.length);
t_Funnel.rows[1].cells[document.getElementById(columna).cellIndex].innerHTML=document.getElementById(id).value;
}

}

function calcular(){
cantidad=Vcomision.value/100;cantidad=cantidad*VticketProm.value;
var objetivo=VobjetivoMensual.value / cantidad;
entero=Math.floor(objetivo);var contrato;
if(entero-objetivo==0){contrato=entero}
else{contrato=entero+1;	}	
VcontratoCerrar.value=contrato;
t_Funnel.rows[1].cells[contratoCerrar.cellIndex].innerHTML=contrato;
var n1=Number(Vseguimiento.value);
var n2=Number(Vimpacto.value);
var n3=Number(Vprospecto.value);
var n4=Number(Vsuspecto.value);

if(!isNaN(n1) && n1==0){
 Vseguimiento.value=100;
}
if(!isNaN(n2) && n2==0) { Vimpacto.value=100;} 
if(!isNaN(n3) && n3==0){Vprospecto.value=100;} 
if(!isNaN(n4) && n4==0 ){Vsuspecto.value=100;} 
cambia();		
}
//cambiaClickTabla(t_Funnel.rows[1]);

</script>
<script type="text/javascript">
	document.getElementById('marquesinaBanner').style.display='none';
	<?php 
if(isset($pestania)){echo('cargarPagina("crmproyecto/'.$pestania.'")');}
else{echo('cargarPagina("crmproyecto/agregarProspecto")');}
?>
</script>
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.css' rel="stylesheet">
<link href='<?php echo base_url();?>assets/fullcalendar/fullcalendar.print.min.css' rel="stylesheet" media='print'>
<script src='<?php echo base_url();?>assets/fullcalendar/lib/moment.min.js'></script>
<script src='<?php echo base_url();?>assets/fullcalendar/fullcalendar.min.js'></script>
<script type="text/javascript">




  $(document).ready(function() {
    $('#calendar').fullCalendar({
      header: {
      	left: 'prev,next today',
      	center: 'title',
      	right: 'month,agendaWeek,agendaDay,listWeek',
      },
      defaultDate:new Date(),
      navLinks: false,
      editable: true,
      eventLimit: true, 
    
      events: [<?php  foreach ($citas as $value) {echo('{ title:"'.$value->title.'",start:"'.$value->start.'",end:"'.$value->end.'",id:"'.$value->id.'"},');}?>],
      eventDrop:function(event,delta,reverFunc)
        {
          var id=event.id;var fi=event.start.format();var ff=event.end.format();
          $.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{id:id,fi:fi,ff:ff},
             function(data){
              if(data==1){alert("Cita actualizado correctamente")}
              else{alert("error intenterlo mas tarde")}
          })
        },
      eventResize:function(event)
      {var id=event.id;var fi=event.start.format();var ff=event.end.format();
          $.post(<?php echo('"'.base_url().'crmproyecto/actualizaCita"'); ?>,{id:id,fi:fi,ff:ff},
             function(data){ if(data==1){alert("Cita actualizado correctamente")}
              else{alert("error intenterlo mas tarde")}
          })


      },
      eventRender: function(event,element){
        var el=element.html();
        element.html("<div style='width:90%;'>"+el+"</div><div style='float:right;color:red;border:solid; width:10px; height:10px;text-align:right;position:relative; top:-15px; background-color:white' class='eliminaCita'>X</div>");
        element.find('.eliminaCita').click(function(){
          if(!confirm("Estas seguro de eliminar el evento")){
            alert("Eliminacion cancelada");
          }else{var id=event.id;
                   $.post(<?php echo('"'.base_url().'crmproyecto/eliminaCita"');  ?>,{id:id},
             function(data){ if(data==1){
              $('#calendar').fullCalendar('removeEvents',event.id);
              alert("Cita eliminada correctamente")}
              else{alert("error intenterlo mas tarde")}
          })

          }
        })
      }

    });

  });	
  function abrirCerrar(objeto,clase){
	var imagen=objeto.innerHTML;
	if(imagen=="▼"){objeto.innerHTML="►"; var clase = document.getElementsByClassName(clase);
	for (var i = 0; i<clase.length; i++) {
   clase[i].classList.remove("verObjeto");
   clase[i].classList.add("ocultarObjeto");
}

	}
	if(imagen=="►"){objeto.innerHTML="▼";var clase = document.getElementsByClassName(clase);

		for (var i = 0; i<clase.length; i++) {
   clase[i].classList.remove("ocultarObjeto");
   clase[i].classList.add("verObjeto");clase[i].classList.remove("verObjeto");}}
}

</script>
<script type="text/javascript">
	function llamarDate(){
 $(document).ready(function () {
   $('.fecha').datepicker({

  closeText: 'Cerrar',prevText: 'Anterior',nextText: 'Siguiente',currentText: 'Hoy',
  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
  dayNames:['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'] ,
  dayNamesShort:['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
  dateFormat: 'dd/mm/yy',
  monthNamesShort:['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
  firstDay: 1,  
     changeMonth: true,
    changeYear: true,    

   });
 });
}
</script>
<style type="text/css">
	.ocultarObjeto1{display: none;}
	.verObjeto1{display: table;}
</style>
<script type="text/javascript">

<?php 
    
if(isset($clientesEnPausa)){
	if((count($clientesEnPausa))>0){

	echo('document.getElementById(\'divModalContenidoGenerico\').innerHTML="'.impirmirEnPausa($clientesEnPausa).'";');
	echo('cerrarModal(\'divModalGenerico\');');
    }
}

?>	
</script>
<? 
function impirmirEnPausa($datos){
  $enPausa='<table border=\'1\' id=\'tablaActivacion\'><tr><td>Clientes En Pausa</td><td></td>';
   
foreach ($datos as  $value) {
	$enPausa.='<tr><td>'.$value->ApellidoP.' '.$value->ApellidoM.' '.$value->Nombre.'(Razon Social:'.$value->RazonSocial.')</td><td><button align=\'right\' onclick=\'activarEnPausa(\"\",'.$value->IDCli.',this)\'>activar</button></td></tr>';

}
$enPausa.='</table>';
  return $enPausa;
}
?>
<script>
	
	function generaLinkEnvio(tipoLink, numeroMovilLink, correoLink, datosLink){

	//	console.log(tipoLink);
	//	console.log(numeroMovilLink);
	//	console.log(correoLink);
	//	console.log(datosLink);
		var paramLinkCorto	= {
								"linkLargo"		: datosLink,
							  }
		//** console.log(paramLinkCorto);
		$.ajax({
			always:		function(){
							$('#modalPreload').modal('show');
						},
			url:		'<?=base_url()."bitly_controller/getLinkCorto"?>',
			type:		'POST',
			data:		paramLinkCorto,
			success:	function(data){
							data = jQuery.parseJSON(data);
							//** console.log(data);
							switch(tipoLink){
								case "linkSms":
// base_url('smsMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('smsMasivo?')."paraTelefonosUrl="; ?>'+numeroMovilLink+'&smsTextUrl=', '_blank');
									//console.log('Sms');
								break;
			
								case "linkWhatSapp":

// base_url('whatsAppMasivo?')."paraTelefonosUrl=".$movilNumber."&smsTextUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('whatsAppMasivo?')."paraTelefonosUrl="; ?>'+numeroMovilLink+'&smsTextUrl=', '_blank');
									//console.log('WhatSapp');
								break;
			
								case "linkCorreo":
// base_url('mailMasivo?')."paraCorreoUrl=".$infoCliente[0]->EMail1."&textCorreoUrl=Documento de la Poliza ".$this->bitly_model->linkCorto($documentos->PathWWW);
									window.open('<?= base_url('mailMasivo?')."paraCorreoUrl="; ?>'+correoLink+'&textCorreoUrl=', '_blank');
									//console.log('Correo');
								break;
							}
						}
		});

	}

//*********Ultimas Actualizacion Miguel Jaime 01/10/2020

/* Ajax*/
function objetoAjax(){
var oHttp=false;
        var asParsers=["Msxml2.XMLHTTP.5.0", "Msxml2.XMLHTTP.4.0",
        "Msxml2.XMLHTTP.3.0", "Msxml2.XMLHTTP", "Microsoft.XMLHTTP"];
        for (var iCont=0; ((!oHttp) && (iCont<asParsers.length)); iCont++){
            try{
                oHttp=new ActiveXObject(asParsers[iCont]);
            }
            catch(e){
                oHttp=false;
            }
        }
        if ((!oHttp) && (typeof XMLHttpRequest!='undefined')){
        oHttp=new XMLHttpRequest();
    }
return oHttp;
}

//Modificacion 05/11/2020
function activar_persona(){
    document.getElementById('div_persona').style.display='block';
    document.getElementById('div_seleccion').style.display='none'; 
    document.getElementById('div_agente').style.display='none';    
  }

function activar_generico(){
  document.getElementById('div_generico').style.display='block';
  document.getElementById('div_seleccion').style.display='none'; 
  document.getElementById('div_agente').style.display='none'; 
}

function activar_agente(){
   document.getElementById('div_agente').style.display='block';
   document.getElementById('div_seleccion').style.display='none';  
   document.getElementById('div_generico').style.display='none';  
}  



function abrir_pestania_generico(){
        document.getElementById('generico').style.display='block';
        document.getElementById('lead').style.display='none';
        document.getElementById('persona').style.display='none';
        document.getElementById('masivo').style.display='none';
        document.getElementById('agentes').style.display='none';
        document.getElementById('li_generico').style="background-color:blue";
        document.getElementById('li_persona').style="background-color: #000";
        document.getElementById('li_masivo').style="background-color: #000";
        document.getElementById('li_lead').style="background-color: #000";
        document.getElementById('li_agentes').style="background-color: #000";
}
function abrir_pestania_persona(){
        document.getElementById('persona').style.display='block';
        document.getElementById('lead').style.display='none';
        document.getElementById('generico').style.display='none';
        document.getElementById('agentes').style.display='none';
        document.getElementById('masivo').style.display='none';
        document.getElementById('li_persona').style="background-color:blue";
        document.getElementById('li_generico').style="background-color:#000";
        document.getElementById('li_masivo').style="background-color: #000";
        document.getElementById('li_lead').style="background-color: #000";
        document.getElementById('li_agentes').style="background-color: #000";
}

function abrir_pestania_masivo(){
        document.getElementById('masivo').style.display='block';
        document.getElementById('lead').style.display='none';
        document.getElementById('generico').style.display='none';
        document.getElementById('persona').style.display='none';
        document.getElementById('agentes').style.display='none';
        document.getElementById('li_masivo').style="background-color:blue";
        document.getElementById('li_generico').style="background-color:#000";
        document.getElementById('li_persona').style="background-color:#000";
        document.getElementById('li_lead').style="background-color: #000";
        document.getElementById('li_agentes').style="background-color: #000";
}
function abrir_pestania_lead(){
        document.getElementById('lead').style.display='block';
        document.getElementById('masivo').style.display='none';
        document.getElementById('generico').style.display='none';
        document.getElementById('persona').style.display='none';
        document.getElementById('agentes').style.display='none';
        document.getElementById('li_masivo').style="background-color:#000";
        document.getElementById('li_generico').style="background-color:#000";
        document.getElementById('li_persona').style="background-color:#000";
        document.getElementById('li_agentes').style="background-color: #000";
        document.getElementById('li_lead').style="background-color: blue";
}


function abrir_pestania_agentes(){
        document.getElementById('agentes').style.display='block';
        document.getElementById('masivo').style.display='none';
        document.getElementById('generico').style.display='none';
        document.getElementById('lead').style.display='none';
        document.getElementById('persona').style.display='none';
        document.getElementById('li_masivo').style="background-color:#000";
        document.getElementById('li_generico').style="background-color:#000";
        document.getElementById('li_persona').style="background-color:#000";
        document.getElementById('li_lead').style="background-color: #000";
        document.getElementById('li_agentes').style="background-color: blue";
}
//fin modificacion

// Pestañas de lista de notificaciones
$sw=0;
function abrir_lista_primera(){
if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='block';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
	document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
	document.getElementById('div_tareas').style.display='none';
  }
}

function abrir_lista_cierre(){
  if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_cierre').style.display='block';
    document.getElementById('div_leads').style.display='none';
	document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
	document.getElementById('div_tareas').style.display='none';
  }
}


function abrir_lista_leads(){
  if($sw==0){
    $sw=1;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_cierre').style.display='none';
    document.getElementById('div_leads').style.display='block';
	document.getElementById('div_tareas').style.display='none';
  }else{
    $sw=0;
    document.getElementById('div_primera').style.display='none';
    document.getElementById('div_leads').style.display='none';
    document.getElementById('div_cierre').style.display='none';
	document.getElementById('div_tareas').style.display='none';
  }
}
function abrir_lista_tareas(){
  
  if($sw==0){
	 $sw=1;
	 document.getElementById('div_primera').style.display='none';
	 document.getElementById('div_cierre').style.display='none';
	 document.getElementById('div_leads').style.display='none';
	 document.getElementById('div_tareas').style.display='block';
   }else{
	 $sw=0;
	 document.getElementById('div_primera').style.display='none';
	 document.getElementById('div_leads').style.display='none';
	 document.getElementById('div_cierre').style.display='none';
	 document.getElementById('div_tareas').style.display='none';
   }
 }
 function enviaTarea($idtarea){
  //console.log($idtarea);
  //var proyecto=0;
  var xhr = new XMLHttpRequest();
            var datos = new FormData();
            datos.append('idtarea',$idtarea);
          //  datos.append('fecha',fechaTarea.value);
            xhr.open('POST',"<?php echo base_url();?>cproyecto/actualizaAlerta",true);
            xhr.onload=function()
            {
              if(this.status === 200)
              {
                var respuesta = JSON.parse(xhr.responseText);
				// console.log(respuesta);
				//proyecto = respuesta;
			    window.location.replace("<?php echo base_url();?>Cproyecto/muestraProyectos?idproyecto="+respuesta);				
              }
            }
			//console.log(respuesta);
            xhr.send(datos);
			//window.location.replace("<?php echo base_url();?>Cproyecto/muestraProyectos?idproyecto="+proyecto);
}

//FIN
/** Actualiza tipo de prospectos**/
function actualiza_prospecto(id){
	var url=$('#base').val()+"crmproyecto/actualiza_prospecto";
	var tipo=$('#tipo_prospecto').val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: "id="+id+"&tipo_prospecto="+tipo,
        success: function(resp){
        }
    });
  	window.history.back(-2);
}  

/** Actualiza tipo de prospectos**/
function actualiza_estado(id){
	var url=$('#base').val()+"crmproyecto/actualiza_estado";
	var tipo=$('#estado').val();
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: url,
        data: "id="+id+"&estado="+tipo,
        success: function(resp){
        }
    });
  	window.history.back(-2);
}  

//*** Filtro tipo de Estado Actual prospectos genericos
function seleccionarEstadoActual(e){
	var estado=e.value;
	divResultado = document.getElementById('pantalla');  
	ajax=objetoAjax();   
	var url=document.getElementById('base').value;
	var URL=url+"crmproyecto/prospecto_genericos_estado?estado="+estado;
	ajax.open("GET", URL);
	ajax.onreadystatechange=function() {
	    if (ajax.readyState==4) {
	        divResultado.innerHTML = ajax.responseText
	        document.getElementById('loader').style.display="none";
	    }
	 }
	 ajax.send(null)  
}

//Pestañas Agenda asesores
function abrir_pestania_citas(){
	document.getElementById('citas').style.display='block';
	document.getElementById('configuracion').style.display='none';
	document.getElementById('li_citas').style="background-color:blue";
	document.getElementById('li_configuracion').style="background-color: #000";
}
function abrir_pestania_configuracion(){
	document.getElementById('citas').style.display='none';
	document.getElementById('configuracion').style.display='block';
	document.getElementById('li_citas').style="background-color:#000";
	document.getElementById('li_configuracion').style="background-color:blue";
}

function agregarAgenda(){
	
	let dias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado","Domingo"];
	var id=document.getElementById('id_userInfo').value;
	var fecha=document.getElementById('dia').value;
	var date = new Date(fecha);
    var diaLetras=dias[date.getDay()];

	var hinicio=document.getElementById('hinicio').value;
	var hfinal=document.getElementById('hfinal').value;
	if((dia=='')||(hinicio=='')||(hfinal=='')){
		alert("Todos los Datos son necesarios");
	}else{
			divResultado = document.getElementById('configuracion');  
			ajax=objetoAjax();   
			var url=document.getElementById('base').value;

			var inicio=document.getElementById('hinicio').value;
			var fin=document.getElementById('hfinal').value;
			fin=parseInt(fin)+1;
			inicio=parseInt(inicio);

			var data = [];
			for(i=inicio;i<fin;i++){
				var item=i+":00-"+i+":30";
				data.push(item);
			}
			
			var URL=url+"crmproyecto/agregar_agenda?id_userInfo="+id+"&dia="+diaLetras+"&fecha="+fecha+'&fracciones='+data;
			ajax.open("GET", URL);
			ajax.onreadystatechange=function() {
			    if (ajax.readyState==4) {
			        divResultado.innerHTML = ajax.responseText
			        document.getElementById('loader').style.display="none";
			    }
			 }
			 ajax.send(null) 
	}
	
}

function eliminarAgenda(id){
	divResultado = document.getElementById('configuracion');  
	ajax=objetoAjax();   
	var url=document.getElementById('base').value;
	var URL=url+"crmproyecto/eliminarAgenda?id="+id;
	ajax.open("GET", URL);
	ajax.onreadystatechange=function() {
	    if (ajax.readyState==4) {
	        divResultado.innerHTML = ajax.responseText
	        document.getElementById('loader').style.display="none";
	    }
	 }
	 ajax.send(null) 
}
function detalle_cita(cliente,correo,telefono,detalle){
	document.getElementById('detalle_cita').style.display="block";
	document.getElementById('detalle_cita').innerHTML="<table width='65%'><tr><td><div style='text-align:left'><button onclick='cerrar_detalle()' class='btn btn-xs btn-danger' style='color: #fff;'><i class='fa fa-times-circle'></i>&nbsp;Cerrar</button></div><br></td><td></td></tr><tr><td colspan='2'><h5>DETALLES DEL CLIENTE</h5></td></tr><tr><td><b>Nombre:</b></td><td>"+cliente+"</td></tr><tr><td><b>Email:</b></td><td>"+correo+"</td></tr><tr><td><b>Telefono:</b></td><td>"+telefono+"</td></tr><tr><td><b>Detalle de la Cita:</b></td><td>"+detalle+"</td></tr></table>";
}
function cerrar_detalle(){
	document.getElementById('detalle_cita').style.display="none";
}

//Modificacion  miguel jaime 11/11/2020
function EliminarProspectoAgente(id){
	var op=confirm("Esta seguro de eliminar este Prospecto de Agente");
	if(op==1){
		var url=document.getElementById('base').value;
		document.location.href=url+"crmproyecto/EliminarProspectoAgente?id="+id;
	}
}
function guardar_agente_temporal(nombres,apellidoP,apellidoM,email,telefono,fechaRegistro){
   var op=confirm("¿Esta seguro de traspasar este agente a capital humano?");
   if(op==1){
   var url=document.getElementById('base').value;
    document.location.href=url+"crmproyecto/guardar_agente_temporal?nombres="+nombres+"&apellidoP="+apellidoP+"&apellidoM="+apellidoM+"&email="+email+"&telefono="+telefono+"&fechaRegistro="+fechaRegistro;
	}
 }

	
//*************Fin  

</script>


